<?php
/**
 * Password-protected Google Ads offline conversion feed.
 *
 * Completed WindowCAD quotes already store the consented Google click
 * identifier against a private enquiry. This endpoint exposes only the fields
 * Google Ads needs for a scheduled HTTPS import. It never exports lead PII.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_google_ads_feed_username(): string
{
    return fenster_adminbase_config_value(
        'FENSTER_GOOGLE_ADS_FEED_USERNAME',
        'fenster_google_ads_feed_username',
        'fenster-google-ads'
    );
}

function fenster_google_ads_feed_password(): string
{
    return fenster_adminbase_config_value(
        'FENSTER_GOOGLE_ADS_FEED_PASSWORD',
        'fenster_google_ads_feed_password'
    );
}

function fenster_google_ads_feed_token(): string
{
    return fenster_adminbase_config_value(
        'FENSTER_GOOGLE_ADS_FEED_TOKEN',
        'fenster_google_ads_feed_token'
    );
}

function fenster_google_ads_feed_request_credentials(WP_REST_Request $request): array
{
    $username = sanitize_text_field((string) ($_SERVER['PHP_AUTH_USER'] ?? ''));
    $password = (string) ($_SERVER['PHP_AUTH_PW'] ?? '');

    if ($username !== '' || $password !== '') {
        return [$username, $password];
    }

    $authorization = trim((string) $request->get_header('authorization'));
    if (! preg_match('/^Basic\s+([A-Za-z0-9+\/=]+)$/i', $authorization, $matches)) {
        return ['', ''];
    }

    $decoded = base64_decode($matches[1], true);
    if (! is_string($decoded) || ! str_contains($decoded, ':')) {
        return ['', ''];
    }

    return array_pad(explode(':', $decoded, 2), 2, '');
}

function fenster_google_ads_feed_is_authorized(WP_REST_Request $request): bool|WP_Error
{
    $expected_username = fenster_google_ads_feed_username();
    $expected_password = fenster_google_ads_feed_password();
    $expected_token = fenster_google_ads_feed_token();
    $request_token = sanitize_text_field((string) $request->get_param('feed_token'));

    if ($expected_token !== ''
        && $request_token !== ''
        && hash_equals($expected_token, $request_token)
    ) {
        return true;
    }

    if (($expected_username === '' || $expected_password === '') && $expected_token === '') {
        return new WP_Error(
            'fenster_google_ads_feed_not_configured',
            'The Google Ads conversion feed is not configured.',
            ['status' => 503]
        );
    }

    [$username, $password] = fenster_google_ads_feed_request_credentials($request);
    if (! hash_equals($expected_username, $username) || ! hash_equals($expected_password, $password)) {
        error_log('Fenster Google Ads feed: unauthorized request ' . wp_json_encode([
            'authorization_header' => $request->get_header('authorization') !== '' ? 'present' : 'absent',
            'username_match' => $username !== '' && hash_equals($expected_username, $username),
            'user_agent' => substr(sanitize_text_field((string) $request->get_header('user-agent')), 0, 180),
        ]));

        return new WP_Error(
            'fenster_google_ads_feed_unauthorized',
            'Valid feed credentials are required.',
            ['status' => 401]
        );
    }

    return true;
}

add_action('rest_api_init', 'fenster_register_google_ads_conversion_feed');
function fenster_register_google_ads_conversion_feed(): void
{
    register_rest_route('fenster/v1', '/google-ads-conversions\.csv', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'fenster_google_ads_conversion_feed',
        'permission_callback' => 'fenster_google_ads_feed_is_authorized',
    ]);

    /*
     * Google Ads Data Manager's Java fetcher reaches SiteGround without the
     * Authorization header supplied in its HTTPS connection form. The opaque
     * path token is the fallback for that host-level header stripping.
     */
    register_rest_route('fenster/v1', '/google-ads-conversions/(?P<feed_token>[A-Fa-f0-9]{64})\.csv', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'fenster_google_ads_conversion_feed',
        'permission_callback' => 'fenster_google_ads_feed_is_authorized',
    ]);
}

function fenster_google_ads_conversion_rows(): array
{
    $query = new WP_Query([
        'post_type' => 'fenster_enquiry',
        'post_status' => 'private',
        'posts_per_page' => 500,
        'fields' => 'ids',
        'orderby' => 'date',
        'order' => 'ASC',
        'no_found_rows' => true,
        'date_query' => [[
            'column' => 'post_date_gmt',
            'after' => gmdate('Y-m-d H:i:s', time() - (89 * DAY_IN_SECONDS)),
            // Google can reject a conversion tied to a click less than six
            // hours old. The next daily import will pick it up safely.
            'before' => gmdate('Y-m-d H:i:s', time() - (6 * HOUR_IN_SECONDS)),
            'inclusive' => true,
        ]],
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => '_fenster_project_type',
                'value' => 'WindowCAD',
            ],
            [
                'key' => '_fenster_ad_click_id',
                'compare' => 'EXISTS',
            ],
            [
                'key' => '_fenster_ad_click_type',
                'value' => ['gclid', 'gbraid', 'wbraid'],
                'compare' => 'IN',
            ],
        ],
    ]);

    $rows = [];
    foreach ($query->posts as $post_id) {
        $click_type = sanitize_key((string) get_post_meta($post_id, '_fenster_ad_click_type', true));
        $click_id = sanitize_text_field((string) get_post_meta($post_id, '_fenster_ad_click_id', true));
        if (! in_array($click_type, ['gclid', 'gbraid', 'wbraid'], true)
            || ! preg_match('/^[A-Za-z0-9_.-]{10,200}$/', $click_id)
        ) {
            continue;
        }

        $post_date_gmt = (string) get_post_field('post_date_gmt', $post_id);
        $converted_at = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $post_date_gmt,
            new DateTimeZone('UTC')
        );
        if (! $converted_at) {
            continue;
        }

        $identifiers = [
            'gclid' => '',
            'gbraid' => '',
            'wbraid' => '',
        ];
        $identifiers[$click_type] = $click_id;

        $rows[] = [
            $identifiers['gclid'],
            $identifiers['gbraid'],
            $identifiers['wbraid'],
            'Instant quote submitted',
            $converted_at->format('Y-m-d\TH:i:s\Z'),
            '25.00',
            'GBP',
            'fg-windowcad-' . (int) $post_id,
        ];
    }

    return $rows;
}

function fenster_google_ads_conversion_feed(): WP_REST_Response
{
    $stream = fopen('php://temp', 'w+');
    if (! is_resource($stream)) {
        return new WP_REST_Response('Unable to create conversion feed.', 500);
    }

    fputcsv($stream, [
        'gclid',
        'gbraid',
        'wbraid',
        'conversion_action',
        'conversion_time',
        'conversion_value',
        'conversion_currency',
        'order_id',
    ]);

    foreach (fenster_google_ads_conversion_rows() as $row) {
        fputcsv($stream, $row);
    }

    rewind($stream);
    $csv = stream_get_contents($stream);
    fclose($stream);

    return new WP_REST_Response((string) $csv, 200, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'inline; filename="fenster-google-ads-conversions.csv"',
        'Cache-Control' => 'private, no-store, max-age=0',
        'X-Robots-Tag' => 'noindex, nofollow, noarchive',
    ]);
}

add_filter('rest_pre_serve_request', 'fenster_serve_google_ads_conversion_csv', 10, 4);
function fenster_serve_google_ads_conversion_csv(
    bool $served,
    WP_HTTP_Response $result,
    WP_REST_Request $request,
    WP_REST_Server $server
): bool {
    if (! preg_match('#^/fenster/v1/google-ads-conversions(?:/[A-Fa-f0-9]{64})?\.csv$#', $request->get_route())
        || $result->get_status() !== 200
        || ! is_string($result->get_data())
    ) {
        return $served;
    }

    echo $result->get_data(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    return true;
}
