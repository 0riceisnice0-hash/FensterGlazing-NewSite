<?php
/**
 * Privacy-conscious website journey attribution.
 *
 * Browser events only contain journey and marketing context. Lead PII stays in
 * WordPress/AdminBase; WindowCAD's hidden Reference field carries the opaque
 * journey ID back to this site in WindowCAD's separate Tracking field when a
 * quote is completed. The office-owned Reference field is never read or set.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_website_dashboard_url(): string
{
    $configured = defined('FENSTER_WEBSITE_DASHBOARD_URL')
        ? (string) FENSTER_WEBSITE_DASHBOARD_URL
        : '';

    return esc_url_raw($configured !== '' ? $configured : 'https://marketing-dashboard-1d0.pages.dev/api/website/event');
}

function fenster_website_dashboard_consent_url(): string
{
    return (string) preg_replace('#/event/?$#', '/consent', fenster_website_dashboard_url());
}

function fenster_website_dashboard_stat_url(): string
{
    return (string) preg_replace('#/event/?$#', '/stat', fenster_website_dashboard_url());
}

function fenster_website_dashboard_chat_url(): string
{
    return (string) preg_replace('#/event/?$#', '/chat', fenster_website_dashboard_url());
}

function fenster_website_dashboard_secret(): string
{
    if (defined('FENSTER_WEBSITE_DASHBOARD_SECRET')) {
        return (string) FENSTER_WEBSITE_DASHBOARD_SECRET;
    }

    $secret = getenv('FENSTER_WEBSITE_DASHBOARD_SECRET');
    if (is_string($secret) && $secret !== '') {
        return $secret;
    }

    return isset($_ENV['FENSTER_WEBSITE_DASHBOARD_SECRET'])
        ? (string) $_ENV['FENSTER_WEBSITE_DASHBOARD_SECRET']
        : '';
}

function fenster_windowcad_reference_parameter(): string
{
    return defined('FENSTER_WINDOWCAD_REFERENCE_PARAMETER')
        ? sanitize_key((string) FENSTER_WINDOWCAD_REFERENCE_PARAMETER)
        : 'tracking';
}

function fenster_ad_attribution_endpoint(): string
{
    return esc_url_raw(rest_url('fenster/v1/ad-attribution'));
}

function fenster_ad_attribution_key(string $journey_id): string
{
    return 'fenster_ad_' . substr(hash_hmac('sha256', strtoupper($journey_id), wp_salt('auth')), 0, 40);
}

function fenster_ad_attribution_for_journey(string $journey_id): array
{
    if (! preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $journey_id)) {
        return [];
    }

    $record = get_transient(fenster_ad_attribution_key($journey_id));
    if (! is_array($record)) {
        return [];
    }

    $click_type = sanitize_key((string) ($record['click_type'] ?? ''));
    $click_id = sanitize_text_field((string) ($record['click_id'] ?? ''));
    $ads_tracker = sanitize_text_field((string) ($record['ads_tracker'] ?? ''));
    if (! in_array($click_type, ['gclid', 'gbraid', 'wbraid'], true)
        || ! preg_match('/^[A-Za-z0-9_.-]{10,200}$/', $click_id)
    ) {
        return [];
    }

    return [
        'click_type' => $click_type,
        'click_id' => $click_id,
        'ads_tracker' => preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $ads_tracker) ? $ads_tracker : '',
    ];
}

add_action('rest_api_init', 'fenster_register_ad_attribution_route');
function fenster_register_ad_attribution_route(): void
{
    register_rest_route('fenster/v1', '/ad-attribution', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'fenster_store_ad_attribution',
        'permission_callback' => 'fenster_ad_attribution_request_allowed',
    ]);
}

function fenster_ad_attribution_request_allowed(WP_REST_Request $request): bool
{
    $origin_host = strtolower((string) wp_parse_url((string) $request->get_header('origin'), PHP_URL_HOST));
    $site_host = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));

    return $origin_host !== '' && $site_host !== '' && hash_equals($site_host, $origin_host);
}

function fenster_store_ad_attribution(WP_REST_Request $request): WP_REST_Response
{
    $data = $request->get_json_params();
    $journey_id = strtoupper(sanitize_text_field((string) ($data['journey_id'] ?? '')));
    $ad_click_id = sanitize_text_field((string) ($data['ad_click_id'] ?? ''));
    $ads_tracker = sanitize_text_field((string) ($data['ads_tracker'] ?? ''));

    if (! preg_match('/^FG2-[A-Z0-9-]{8,80}$/', $journey_id)
        || ! preg_match('/^(gclid|gbraid|wbraid):([A-Za-z0-9_.-]{10,200})$/', $ad_click_id, $click_parts)
        || ($ads_tracker !== '' && ! preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $ads_tracker))
    ) {
        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'Invalid ad attribution payload.',
        ], 422);
    }

    set_transient(fenster_ad_attribution_key($journey_id), [
        'click_type' => $click_parts[1],
        'click_id' => $click_parts[2],
        'ads_tracker' => $ads_tracker,
    ], 90 * DAY_IN_SECONDS);

    return new WP_REST_Response(null, 204);
}

function fenster_dashboard_track_event(string $event, array $payload = []): void
{
    $endpoint = fenster_website_dashboard_url();
    $secret = fenster_website_dashboard_secret();

    if ($endpoint === '') {
        return;
    }

    $allowed = [
        'journey_id',
        'visitor_id',
        'page_path',
        'landing_path',
        'source',
        'medium',
        'campaign',
        'content',
        'term',
        'referrer_host',
        'cta',
        'product_collection',
        'price_amount',
        'price_currency',
        'event_value',
    ];
    $clean = ['event' => $event, 'origin' => home_url('/')];

    foreach ($allowed as $key) {
        if (! array_key_exists($key, $payload) || $payload[$key] === '') {
            continue;
        }

        $clean[$key] = is_numeric($payload[$key])
            ? (float) $payload[$key]
            : sanitize_text_field((string) $payload[$key]);
    }

    $response = wp_remote_post($endpoint, [
        'timeout' => 8,
        // WindowCAD callbacks can end before a non-blocking outbound request
        // has been sent. Wait for the no-PII dashboard acknowledgement so a
        // completed quote is not silently lost.
        'blocking' => true,
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Fenster-Website-Secret' => $secret,
        ],
        'body' => wp_json_encode($clean),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster website tracking relay failed for event: ' . $event);
    }
}

/**
 * Relay one aggregate-only statistic bucket to the dashboard.
 *
 * This is the documented non-consented statistical path: hourly totals only,
 * no journey/visitor identifiers. Used server-side so quote completions that
 * arrive without a consented FG2 reference are still counted as totals.
 */
function fenster_dashboard_track_stat(string $event, string $page_path = ''): void
{
    $endpoint = fenster_website_dashboard_stat_url();
    if ($endpoint === '') {
        return;
    }

    $response = wp_remote_post($endpoint, [
        'timeout' => 8,
        'blocking' => true,
        'headers' => [
            'Content-Type' => 'text/plain;charset=UTF-8',
            'X-Fenster-Website-Secret' => fenster_website_dashboard_secret(),
        ],
        'body' => wp_json_encode([
            'event' => $event,
            'page_path' => $page_path,
            'device_type' => 'server',
            'origin' => home_url('/'),
        ]),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster website stat relay failed for event: ' . $event);
    }
}

function fenster_windowcad_tracking_from_fields(array $fields): string
{
    foreach (['Tracking', 'tracking'] as $key) {
        $value = sanitize_text_field((string) ($fields[$key] ?? ''));
        if (preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $value)) {
            return strtoupper($value);
        }
    }

    // Defensive fallback: if WindowCAD's form configuration ever renames or
    // moves the Tracking property, a valid FG2 value in any submitted field
    // still attributes the quote. Values are read only; the office-owned
    // Reference field is never written by this site.
    foreach ($fields as $value) {
        $value = sanitize_text_field((string) $value);
        if (preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $value)) {
            return strtoupper($value);
        }
    }

    return '';
}

/**
 * Whether the WindowCAD submission carried any website tracking value at all,
 * including the deliberate rejected/no-choice markers. When this is false the
 * WindowCAD website-form configuration has probably lost the Tracking field.
 */
function fenster_windowcad_tracking_field_present(array $fields): bool
{
    foreach (['Tracking', 'tracking'] as $key) {
        if (isset($fields[$key]) && $fields[$key] !== '') {
            return true;
        }
    }

    foreach ($fields as $value) {
        if (preg_match('/^(FG2-[A-Z0-9-]{8,80}|rejected-cookies|cookie-consent-not-accepted)$/i', (string) $value)) {
            return true;
        }
    }

    return false;
}

function fenster_windowcad_price_from_fields(array $fields): float
{
    foreach (['Total', 'Quote total', 'Quote Total', 'Price', 'Total price'] as $key) {
        $value = (string) ($fields[$key] ?? '');
        $amount = preg_replace('/[^0-9.]/', '', $value);
        if ($amount !== '' && is_numeric($amount)) {
            return (float) $amount;
        }
    }

    return 0.0;
}

function fenster_windowcad_ads_tracker_from_fields(array $fields): string
{
    foreach ($fields as $name => $value) {
        if (! preg_match('/^(ads?|advert(?:ising)?)(?: (?:source|tracker|number))?$/i', (string) $name)) {
            continue;
        }

        $tracker = sanitize_text_field((string) $value);
        if (preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $tracker)) {
            return $tracker;
        }
    }

    return '';
}

add_action('wp_enqueue_scripts', 'fenster_enqueue_website_tracking_config', 20);
function fenster_enqueue_website_tracking_config(): void
{
    $config = [
        'endpoint' => fenster_website_dashboard_url(),
        'consentEndpoint' => fenster_website_dashboard_consent_url(),
        'statEndpoint' => fenster_website_dashboard_stat_url(),
        'chatEndpoint' => fenster_website_dashboard_chat_url(),
        'adAttributionEndpoint' => fenster_ad_attribution_endpoint(),
        'referenceParameter' => fenster_windowcad_reference_parameter(),
    ];

    wp_add_inline_script(
        'fenster-main',
        'window.fensterWebsiteTracking = ' . wp_json_encode($config) . ';',
        'before'
    );
}
