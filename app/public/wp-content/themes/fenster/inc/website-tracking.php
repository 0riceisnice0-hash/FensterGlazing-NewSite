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

function fenster_windowcad_tracking_from_fields(array $fields): string
{
    foreach (['Tracking', 'tracking'] as $key) {
        $value = sanitize_text_field((string) ($fields[$key] ?? ''));
        if (preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $value)) {
            return strtoupper($value);
        }
    }

    return '';
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

add_action('wp_enqueue_scripts', 'fenster_enqueue_website_tracking_config', 20);
function fenster_enqueue_website_tracking_config(): void
{
    $config = [
        'endpoint' => fenster_website_dashboard_url(),
        'consentEndpoint' => fenster_website_dashboard_consent_url(),
        'referenceParameter' => fenster_windowcad_reference_parameter(),
    ];

    wp_add_inline_script(
        'fenster-main',
        'window.fensterWebsiteTracking = ' . wp_json_encode($config) . ';',
        'before'
    );
}
