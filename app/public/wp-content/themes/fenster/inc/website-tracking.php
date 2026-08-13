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

function fenster_website_dashboard_outcome_url(): string
{
    return (string) preg_replace('#/event/?$#', '/outcome-ingest', fenster_website_dashboard_url());
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

    $environment_secret = isset($_ENV['FENSTER_WEBSITE_DASHBOARD_SECRET'])
        ? (string) $_ENV['FENSTER_WEBSITE_DASHBOARD_SECRET']
        : '';

    if ($environment_secret !== '') {
        return $environment_secret;
    }

    return trim((string) get_option('fenster_website_dashboard_secret', ''));
}

function fenster_website_tracking_environment(): string
{
    $host = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));

    return $host === 'test.fensterglazing.com' ? 'test' : 'production';
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
    if (! preg_match('/^FG(?:2|A)-[A-Z0-9-]{8,80}$/i', $journey_id)) {
        return [];
    }

    $record = get_transient(fenster_ad_attribution_key($journey_id));
    if (! is_array($record)) {
        return [];
    }

    $click_type = sanitize_key((string) ($record['click_type'] ?? ''));
    $click_id = sanitize_text_field((string) ($record['click_id'] ?? ''));
    $ads_tracker = sanitize_text_field((string) ($record['ads_tracker'] ?? ''));
    $marketing_consent = ! empty($record['marketing_consent']);
    $valid_click = in_array($click_type, ['gclid', 'gbraid', 'wbraid'], true)
        && preg_match('/^[A-Za-z0-9_.-]{10,200}$/', $click_id);
    if (! $marketing_consent) {
        return [];
    }

    return [
        'click_type' => $valid_click ? $click_type : '',
        'click_id' => $valid_click ? $click_id : '',
        'ads_tracker' => preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $ads_tracker) ? $ads_tracker : '',
        'marketing_consent' => $marketing_consent,
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
    $marketing_consent = filter_var($data['marketing_consent'] ?? false, FILTER_VALIDATE_BOOLEAN);

    $click_parts = [];
    $valid_click = $ad_click_id !== ''
        && preg_match('/^(gclid|gbraid|wbraid):([A-Za-z0-9_.-]{10,200})$/', $ad_click_id, $click_parts);
    if (! preg_match('/^FG(?:2|A)-[A-Z0-9-]{8,80}$/', $journey_id)
        || ! $marketing_consent
        || ($ad_click_id !== '' && ! $valid_click)
        || ($ads_tracker !== '' && ! preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $ads_tracker))
    ) {
        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'Invalid ad attribution payload.',
        ], 422);
    }

    set_transient(fenster_ad_attribution_key($journey_id), [
        'click_type' => $valid_click ? $click_parts[1] : '',
        'click_id' => $valid_click ? $click_parts[2] : '',
        'ads_tracker' => $ads_tracker,
        'marketing_consent' => $marketing_consent,
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
        'event_id',
        'occurred_at',
    ];
    $clean = [
        'event' => $event,
        'origin' => home_url('/'),
        'environment' => fenster_website_tracking_environment(),
    ];

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
function fenster_dashboard_track_stat(
    string $event,
    string $page_path = '',
    string $event_id = '',
    string $occurred_at = ''
): void
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
            'environment' => fenster_website_tracking_environment(),
            'event_id' => $event_id,
            'occurred_at' => $occurred_at,
        ]),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster website stat relay failed for event: ' . $event);
    }
}

function fenster_dashboard_track_outcome(
    string $journey_id,
    string $status,
    float $value = 0,
    string $occurred_at = ''
): void {
    if (! preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $journey_id)
        || ! in_array($status, ['new', 'contacted', 'qualified', 'appointment', 'won', 'lost'], true)
    ) {
        return;
    }

    $response = wp_remote_post(fenster_website_dashboard_outcome_url(), [
        'timeout' => 8,
        'blocking' => true,
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Fenster-Website-Secret' => fenster_website_dashboard_secret(),
        ],
        'body' => wp_json_encode([
            'journey_id' => strtoupper($journey_id),
            'status' => $status,
            'value' => max(0, $value),
            'currency' => 'GBP',
            'occurred_at' => $occurred_at,
            'origin' => home_url('/'),
            'environment' => fenster_website_tracking_environment(),
        ]),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster website outcome relay failed for journey: ' . strtoupper($journey_id));
    }
}

function fenster_meta_capi_token(): string
{
    if (defined('FENSTER_META_CAPI_TOKEN')) {
        return trim((string) FENSTER_META_CAPI_TOKEN);
    }

    $environment = getenv('FENSTER_META_CAPI_TOKEN');
    if (is_string($environment) && trim($environment) !== '') {
        return trim($environment);
    }

    return trim((string) get_option('fenster_meta_capi_token', ''));
}

/**
 * Normalise a UK phone number to bare E.164 digits, or '' when it is not one.
 *
 * Digits are stripped first, so a `0044` number also starts with `0`. Testing
 * for `0` before `0044` therefore turned `00441908...` into `440441908...`,
 * which then failed the E.164 check and was silently dropped from both the
 * Meta payload and the Google Ads feed. Longest prefix has to be tested first.
 */
function fenster_normalise_uk_phone(string $raw): string
{
    $digits = (string) preg_replace('/\D+/', '', $raw);

    if (str_starts_with($digits, '0044')) {
        $digits = substr($digits, 2);
    } elseif (str_starts_with($digits, '0')) {
        $digits = '44' . substr($digits, 1);
    }

    return preg_match('/^44[1-9][0-9]{8,9}$/', $digits) ? $digits : '';
}

/**
 * Send one consented lead/outcome to Meta without exposing raw contact data.
 */
function fenster_meta_track_enquiry(
    int $post_id,
    string $event_name = 'Lead',
    string $event_id = '',
    float $value = 0,
    bool $include_request_context = false
): void {
    $token = fenster_meta_capi_token();
    if ($token === ''
        || get_post_meta($post_id, '_fenster_marketing_consent', true) !== '1'
        || ! defined('FENSTER_META_PIXEL_ID')
    ) {
        return;
    }

    $email = strtolower(trim((string) get_post_meta($post_id, '_fenster_email', true)));
    $phone = fenster_normalise_uk_phone((string) get_post_meta($post_id, '_fenster_phone', true));

    $user_data = [];
    if (is_email($email)) {
        $user_data['em'] = [hash('sha256', $email)];
    }
    if ($phone !== '') {
        $user_data['ph'] = [hash('sha256', $phone)];
    }
    $journey_id = (string) get_post_meta($post_id, '_fenster_journey_ref', true);
    if ($journey_id === '') {
        $journey_id = (string) get_post_meta($post_id, '_fenster_marketing_ref', true);
    }
    if ($journey_id !== '') {
        $user_data['external_id'] = [hash('sha256', strtoupper($journey_id))];
    }
    if ($include_request_context) {
        $client_ip = sanitize_text_field((string) ($_SERVER['REMOTE_ADDR'] ?? ''));
        $client_user_agent = sanitize_text_field((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
        if ($client_ip !== '') {
            $user_data['client_ip_address'] = $client_ip;
        }
        if ($client_user_agent !== '') {
            $user_data['client_user_agent'] = $client_user_agent;
        }
    }
    if (empty($user_data)) {
        return;
    }

    $source_url = (string) get_post_meta($post_id, '_fenster_page_url', true);
    $event = [
        'event_name' => $event_name,
        'event_time' => time(),
        'event_id' => $event_id !== '' ? $event_id : 'wp-enquiry-' . $post_id,
        'action_source' => 'website',
        'event_source_url' => esc_url_raw($source_url !== '' ? $source_url : home_url('/')),
        'user_data' => $user_data,
        'custom_data' => [
            'content_name' => (string) get_post_meta($post_id, '_fenster_project_type', true),
            'currency' => 'GBP',
            'value' => max(0, $value),
        ],
    ];

    $version = defined('FENSTER_META_GRAPH_VERSION')
        ? sanitize_text_field((string) FENSTER_META_GRAPH_VERSION)
        : 'v24.0';
    /*
     * The token goes in the body, not the query string. A URL carrying a
     * secret ends up in whatever logs a failed request, and wp_remote_post
     * errors print the endpoint.
     */
    $endpoint = sprintf(
        'https://graph.facebook.com/%s/%s/events',
        rawurlencode($version),
        rawurlencode((string) FENSTER_META_PIXEL_ID)
    );

    /*
     * Never blocking. This runs on the enquiry submission path, so an
     * unreachable graph.facebook.com would otherwise hold the customer's
     * success response for the full timeout. Losing a Meta event costs an
     * attribution row; losing the lead costs the job. Same lesson as the
     * AdminBase cURL 60 outage on 2026-07-21.
     */
    $response = wp_remote_post($endpoint, [
        'timeout' => 2,
        'blocking' => false,
        'headers' => ['Content-Type' => 'application/json'],
        'body' => wp_json_encode([
            'access_token' => $token,
            'data' => [$event],
        ]),
    ]);
    if (is_wp_error($response)) {
        error_log('Fenster Meta conversion relay failed for enquiry: ' . $post_id);
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

function fenster_windowcad_marketing_reference_from_fields(array $fields): string
{
    foreach (['Tracking', 'tracking'] as $key) {
        $value = sanitize_text_field((string) ($fields[$key] ?? ''));
        if (preg_match('/^FGA-[A-Z0-9-]{8,80}$/i', $value)) {
            return strtoupper($value);
        }
    }

    foreach ($fields as $value) {
        $value = sanitize_text_field((string) $value);
        if (preg_match('/^FGA-[A-Z0-9-]{8,80}$/i', $value)) {
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
        if (preg_match('/^(FG(?:2|A)-[A-Z0-9-]{8,80}|rejected-cookies|cookie-consent-not-accepted)$/i', (string) $value)) {
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
        'environment' => fenster_website_tracking_environment(),
        'sessionTimeoutMinutes' => 30,
        'googleAds' => [
            'conversionId' => 'AW-808336148',
            'enquiryLabel' => 'r6edCOm2ztgcEJT2uIED',
            'consultationLabel' => 'Zi3tCLLU1tgcEJT2uIED',
            'phoneLabel' => 'S9iCCJr3ztgcEJT2uIED',
            'quoteLabel' => trim((string) get_option('fenster_google_ads_quote_label', '')),
        ],
    ];

    wp_add_inline_script(
        'fenster-main',
        'window.fensterWebsiteTracking = ' . wp_json_encode($config) . ';',
        'before'
    );
}

/**
 * Reconcile saved WordPress leads with the no-PII dashboard event stream.
 *
 * Deterministic event IDs make this safe to repeat. Aggregate-only events use
 * the same receipt ID on the dashboard, so retrying does not inflate totals.
 */
function fenster_tracking_backfill_recent(int $days = 7): array
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
            'after' => gmdate('Y-m-d H:i:s', time() - (max(1, min(365, $days)) * DAY_IN_SECONDS)),
            'inclusive' => true,
        ]],
    ]);

    $result = ['leads' => 0, 'identified' => 0, 'aggregate' => 0, 'outcomes' => 0];
    foreach ($query->posts as $post_id) {
        $post_id = (int) $post_id;
        $project_type = (string) get_post_meta($post_id, '_fenster_project_type', true);
        $event = $project_type === 'WindowCAD' ? 'quote_completed' : 'form_submitted';
        $event_id = ($project_type === 'WindowCAD' ? 'wp-windowcad-' : 'wp-form-') . $post_id;
        $journey_id = (string) get_post_meta($post_id, '_fenster_journey_ref', true);
        $visitor_id = (string) get_post_meta($post_id, '_fenster_visitor_id', true);
        $page_path = (string) wp_parse_url(
            (string) get_post_meta($post_id, '_fenster_page_url', true),
            PHP_URL_PATH
        );
        $page_path = $page_path !== '' ? $page_path : ($project_type === 'WindowCAD' ? '/online-quote/' : '/');
        $occurred_at = (string) get_post_time('c', true, $post_id);
        $result['leads']++;

        if (preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $journey_id)) {
            fenster_dashboard_track_event($event, [
                'event_id' => $event_id,
                'journey_id' => strtoupper($journey_id),
                'visitor_id' => $visitor_id,
                'page_path' => $page_path,
                'cta' => $project_type === 'WindowCAD'
                    ? 'WindowCAD'
                    : (string) get_post_meta($post_id, '_fenster_source', true),
                'price_amount' => (float) get_post_meta($post_id, '_fenster_quote_price', true),
                'price_currency' => 'GBP',
                'occurred_at' => $occurred_at,
            ]);
            $result['identified']++;
        } else {
            fenster_dashboard_track_stat($event, $page_path, $event_id, $occurred_at);
            $result['aggregate']++;
        }

        $outcome = sanitize_key((string) get_post_meta($post_id, '_fenster_outcome_status', true));
        if (in_array($outcome, ['contacted', 'qualified', 'appointment', 'won', 'lost'], true)
            && preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $journey_id)
        ) {
            fenster_dashboard_track_outcome(
                $journey_id,
                $outcome,
                (float) get_post_meta($post_id, '_fenster_outcome_value', true),
                (string) get_post_meta($post_id, '_fenster_outcome_updated_at', true)
            );
            $result['outcomes']++;
        }
    }

    return $result;
}

add_action('init', 'fenster_schedule_tracking_reconciliation');
function fenster_schedule_tracking_reconciliation(): void
{
    if (! wp_next_scheduled('fenster_tracking_reconcile_daily')) {
        wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', 'fenster_tracking_reconcile_daily');
    }
}

add_action('fenster_tracking_reconcile_daily', 'fenster_run_tracking_reconciliation');
function fenster_run_tracking_reconciliation(): void
{
    fenster_tracking_backfill_recent(7);
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('fenster tracking backfill', static function (array $args, array $assoc_args): void {
        $days = isset($assoc_args['days']) ? (int) $assoc_args['days'] : 90;
        WP_CLI::success(wp_json_encode(fenster_tracking_backfill_recent($days)));
    });
}
