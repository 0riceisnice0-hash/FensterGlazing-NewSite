<?php
/**
 * AdminBase lead relay.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_adminbase_config_value(string $key, string $option = '', string $default = ''): string
{
    if (defined($key)) {
        return trim((string) constant($key));
    }

    $value = getenv($key);
    if (is_string($value) && trim($value) !== '') {
        return trim($value);
    }

    if ($option !== '') {
        $stored = get_option($option, '');
        if (is_string($stored) && trim($stored) !== '') {
            return trim($stored);
        }
    }

    return $default;
}

function fenster_adminbase_credentials(): array
{
    return [
        'endpoint' => fenster_adminbase_config_value(
            'FENSTER_ADMINBASE_ENDPOINT',
            'fenster_adminbase_endpoint',
            'https://webleads.abinitiosoftware.co.uk/api/LeadDetails'
        ),
        'customer_id' => fenster_adminbase_config_value('FENSTER_ADMINBASE_CUSTID', 'fenster_adminbase_custid'),
        'password' => fenster_adminbase_config_value('FENSTER_ADMINBASE_PASSWORD', 'fenster_adminbase_password'),
    ];
}

function fenster_adminbase_is_configured(): bool
{
    $credentials = fenster_adminbase_credentials();

    return $credentials['endpoint'] !== '' && $credentials['customer_id'] !== '' && $credentials['password'] !== '';
}

function fenster_adminbase_surname_parts(string $name): array
{
    $name = trim(preg_replace('/\s+/', ' ', $name) ?? '');
    if ($name === '') {
        return ['', ''];
    }

    $parts = explode(' ', $name, 2);

    return [
        $parts[0] ?? '',
        $parts[1] ?? ($parts[0] ?? ''),
    ];
}

function fenster_adminbase_address_parts(string $address): array
{
    $address = trim(preg_replace('/\s+/', ' ', $address) ?? '');
    if ($address === '') {
        return ['', ''];
    }

    if (preg_match('/^(\d+[A-Za-z]?)\s+(.*)$/', $address, $matches)) {
        return [$matches[1] ?? '', $matches[2] ?? ''];
    }

    return ['', $address];
}

/**
 * AdminBase renewed its certificate in July 2026 with a chain anchored to the
 * newer Sectigo R46 root, which WordPress' bundled ca-bundle.crt predates, so
 * wp_remote_post() failed with cURL error 60 while system curl verified fine.
 * For AdminBase requests only, point curl at the host system trust store,
 * which SiteGround keeps current.
 */
add_filter('http_request_args', 'fenster_adminbase_http_ssl_args', 10, 2);
function fenster_adminbase_http_ssl_args(array $args, string $url): array
{
    $host = (string) wp_parse_url($url, PHP_URL_HOST);
    $endpoint_host = (string) wp_parse_url(fenster_adminbase_credentials()['endpoint'], PHP_URL_HOST);
    if ($host === '' || $host !== $endpoint_host) {
        return $args;
    }

    foreach (['/etc/pki/ca-trust/extracted/pem/tls-ca-bundle.pem', '/etc/ssl/certs/ca-bundle.crt'] as $bundle) {
        if (is_readable($bundle)) {
            $args['sslcertificates'] = $bundle;
            break;
        }
    }

    return $args;
}

function fenster_adminbase_relay(array $lead): array|WP_Error
{
    $credentials = fenster_adminbase_credentials();
    if ($credentials['customer_id'] === '' || $credentials['password'] === '') {
        return new WP_Error('adminbase_not_configured', 'AdminBase credentials are not configured.');
    }

    $body = array_filter([
        'AB_CUSTID' => $credentials['customer_id'],
        'AB_PWORD' => $credentials['password'],
        'FIRSTINITIAL' => (string) ($lead['first_name'] ?? ''),
        'FIRSTSURNAME' => (string) ($lead['last_name'] ?? ''),
        'EMAIL' => (string) ($lead['email'] ?? ''),
        'MOBTEL' => (string) ($lead['phone'] ?? ''),
        'PCODE' => (string) ($lead['postcode'] ?? ''),
        'HOUSENO' => (string) ($lead['house_number'] ?? ''),
        'STREET' => (string) ($lead['street'] ?? ''),
        'NOTES' => (string) ($lead['notes'] ?? ''),
        'SALESAREA' => (string) ($lead['sales_area'] ?? ''),
        'QUOTETYPE' => (string) ($lead['quote_type'] ?? ''),
        'TOKENREQ' => '1',
    ], static fn ($value): bool => $value !== '');

    $response = wp_remote_post($credentials['endpoint'], [
        'method' => 'POST',
        'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
        'body' => http_build_query($body),
        'timeout' => 12,
    ]);

    if (is_wp_error($response)) {
        return $response;
    }

    $status = (int) wp_remote_retrieve_response_code($response);
    $response_body = (string) wp_remote_retrieve_body($response);

    if ($status < 200 || $status >= 300) {
        return new WP_Error(
            'adminbase_bad_response',
            sprintf('AdminBase returned HTTP %d.', $status),
            ['status' => $status, 'body' => $response_body]
        );
    }

    return [
        'status' => $status,
        'body' => $response_body,
    ];
}

function fenster_adminbase_meta_from_result(array|WP_Error $result): array
{
    if (is_wp_error($result)) {
        return [
            '_fenster_adminbase_sent' => '0',
            '_fenster_adminbase_error' => $result->get_error_message(),
        ];
    }

    return [
        '_fenster_adminbase_sent' => '1',
        '_fenster_adminbase_status' => (string) ($result['status'] ?? ''),
        '_fenster_adminbase_response' => substr((string) ($result['body'] ?? ''), 0, 500),
    ];
}

add_action('rest_api_init', 'fenster_register_windowcad_adminbase_route');
function fenster_register_windowcad_adminbase_route(): void
{
    register_rest_route('fenster/v1', '/windowcad', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'fenster_handle_windowcad_submission',
        'permission_callback' => 'fenster_windowcad_request_allowed',
    ]);
}

function fenster_windowcad_webhook_secret(): string
{
    return fenster_adminbase_config_value(
        'FENSTER_WINDOWCAD_WEBHOOK_SECRET',
        'fenster_windowcad_webhook_secret'
    );
}

function fenster_windowcad_request_allowed(WP_REST_Request $request): bool|WP_Error
{
    $secret = fenster_windowcad_webhook_secret();
    if ($secret !== '') {
        $provided = trim((string) $request->get_header('x-fenster-windowcad-secret'));
        if ($provided === '') {
            $provided = trim((string) $request->get_param('webhook_token'));
        }
        if ($provided === '' || ! hash_equals($secret, $provided)) {
            return new WP_Error(
                'fenster_windowcad_unauthorized',
                'A valid WindowCAD webhook credential is required.',
                ['status' => 401]
            );
        }
    }

    /*
     * This ceiling exists only to stop an abusive body being buffered. It must
     * never sit close to a real submission, because rejecting one loses a lead.
     * It was 100000, which every genuine WindowCAD quote exceeds: the webhook
     * posts the whole quote document and the parser keeps only the handful of
     * `infoProperties` values, a few hundred bytes of it. From 31 July 2026 that
     * cap returned 413 to every submission, and the office received no WindowCAD
     * leads at all until 3 August. Size is now noted, not judged.
     */
    $body_length = strlen((string) $request->get_body());
    if ($body_length > 5000000) {
        fenster_windowcad_log('payload rejected as abusively large', ['bytes' => $body_length]);

        return new WP_Error(
            'fenster_windowcad_payload_too_large',
            'The WindowCAD payload is too large.',
            ['status' => 413]
        );
    }
    if ($body_length > 1000000) {
        fenster_windowcad_log('unusually large payload accepted', ['bytes' => $body_length]);
    }

    $remote_address = sanitize_text_field((string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    $rate_key = 'fenster_wc_rate_' . substr(hash('sha256', $remote_address), 0, 32);
    $requests = (int) get_transient($rate_key);
    if ($requests >= 60) {
        return new WP_Error(
            'fenster_windowcad_rate_limited',
            'Too many WindowCAD submissions.',
            ['status' => 429]
        );
    }
    set_transient($rate_key, $requests + 1, HOUR_IN_SECONDS);

    return true;
}

function fenster_windowcad_payload_fields(WP_REST_Request $request): array
{
    $data = $request->get_json_params();
    if (! is_array($data) || empty($data)) {
        $raw = (string) $request->get_body();
        $decoded = json_decode($raw, true);
        $data = is_array($decoded) ? $decoded : [];
    }

    $properties = $data['json']['infoProperties'] ?? $data['infoProperties'] ?? [];
    $fields = [];

    if (is_array($properties)) {
        foreach ($properties as $item) {
            if (! is_array($item) || ! isset($item['name'])) {
                continue;
            }

            $name = sanitize_text_field((string) $item['name']);
            $value = is_scalar($item['value'] ?? null) ? sanitize_text_field((string) $item['value']) : '';
            if ($name !== '' && $value !== '') {
                $fields[$name] = $value;
            }
        }
    }

    return $fields;
}

function fenster_windowcad_log(string $message, array $context = []): void
{
    $safe_context = $context;
    if (isset($safe_context['fields']) && is_array($safe_context['fields'])) {
        $safe_context['fields'] = array_keys($safe_context['fields']);
    }

    error_log('Fenster WindowCAD: ' . $message . ' ' . wp_json_encode($safe_context));
}

function fenster_handle_windowcad_submission(WP_REST_Request $request): WP_REST_Response|WP_Error
{
    $fields = fenster_windowcad_payload_fields($request);
    fenster_windowcad_log('submission received', [
        'content_type' => (string) $request->get_header('content-type'),
        'body_length' => strlen((string) $request->get_body()),
        'fields' => $fields,
    ]);

    if (empty($fields)) {
        fenster_windowcad_log('empty payload rejected');

        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'WindowCAD payload did not include infoProperties.',
        ], 422);
    }

    $full_name = sanitize_text_field((string) ($fields['Name'] ?? $fields['Customer name'] ?? ''));
    [$first_name, $last_name] = fenster_adminbase_surname_parts($full_name);
    [$house_number, $street] = fenster_adminbase_address_parts((string) ($fields['Address'] ?? ''));

    $email = sanitize_email((string) ($fields['Email'] ?? ''));
    $phone = sanitize_text_field((string) ($fields['Phone'] ?? $fields['Telephone'] ?? ''));
    $postcode = sanitize_text_field((string) ($fields['Post code'] ?? $fields['Postcode'] ?? ''));
    if ($full_name === '' || ($email === '' && $phone === '')) {
        fenster_windowcad_log('payload rejected because required contact details were missing');

        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'WindowCAD must include a customer name and an email address or phone number.',
        ], 422);
    }

    $fingerprint = hash('sha256', (string) $request->get_body());
    $existing = new WP_Query([
        'post_type' => 'fenster_enquiry',
        'post_status' => 'private',
        'posts_per_page' => 1,
        'fields' => 'ids',
        'no_found_rows' => true,
        'meta_key' => '_fenster_windowcad_fingerprint',
        'meta_value' => $fingerprint,
    ]);
    $existing_enquiry_id = ! empty($existing->posts) ? (int) $existing->posts[0] : 0;
    if ($existing_enquiry_id > 0 && get_post_meta($existing_enquiry_id, '_fenster_adminbase_sent', true) === '1') {
        fenster_windowcad_log('duplicate webhook accepted without creating another lead', [
            'enquiry_id' => $existing_enquiry_id,
        ]);

        return new WP_REST_Response([
            'status' => 'success',
            'message' => 'Duplicate WindowCAD lead already processed.',
            'enquiry_id' => $existing_enquiry_id,
            'duplicate' => true,
        ], 200);
    }

    $journey_ref = fenster_windowcad_tracking_from_fields($fields);
    $marketing_ref = fenster_windowcad_marketing_reference_from_fields($fields);
    $tracking_field_present = fenster_windowcad_tracking_field_present($fields);
    $quote_price = fenster_windowcad_price_from_fields($fields);
    $windowcad_ads_tracker = fenster_windowcad_ads_tracker_from_fields($fields);
    $attribution_ref = $journey_ref !== '' ? $journey_ref : $marketing_ref;
    $ad_attribution = $attribution_ref !== ''
        ? fenster_ad_attribution_for_journey($attribution_ref)
        : [];
    $ads_tracker = (string) ($ad_attribution['ads_tracker'] ?? '');
    if ($ads_tracker === '') {
        $ads_tracker = $windowcad_ads_tracker;
    }
    $ad_click_type = (string) ($ad_attribution['click_type'] ?? '');
    $ad_click_id = (string) ($ad_attribution['click_id'] ?? '');
    $marketing_consent = ! empty($ad_attribution['marketing_consent']);

    if (! $tracking_field_present) {
        // Every website-originated quote URL carries a tracking value, even for
        // rejected/no-choice visitors. A submission without one means either an
        // office-entered quote or that the WindowCAD website-form configuration
        // has lost the Tracking field again (as happened on 2026-07-15/16).
        fenster_windowcad_log('submission has no Tracking field - check the WindowCAD website designer form still includes the Tracking property');
    }

    $notes = 'Lead from WindowCAD';
    if ($journey_ref !== '') {
        $notes .= "\nWebsite tracking: " . $journey_ref;
    } elseif ($marketing_ref !== '') {
        $notes .= "\nMarketing attribution: " . $marketing_ref;
    } elseif (! $tracking_field_present) {
        $notes .= "\nWebsite tracking: none (WindowCAD submission had no Tracking field)";
    }
    if ($ads_tracker !== '') {
        $notes .= "\nAds tracker: " . $ads_tracker;
    }

    $summary = implode("\n", array_filter([
        'Name: ' . $full_name,
        'Email: ' . $email,
        $phone !== '' ? 'Phone: ' . $phone : '',
        $postcode !== '' ? 'Postcode: ' . $postcode : '',
        $house_number !== '' ? 'House number: ' . $house_number : '',
        $street !== '' ? 'Street: ' . $street : '',
        'Source: WindowCAD',
        $ads_tracker !== '' ? 'Ads tracker: ' . $ads_tracker : '',
        '',
        'Raw WindowCAD fields:',
        wp_json_encode($fields, JSON_PRETTY_PRINT),
    ]));

    $enquiry_id = $existing_enquiry_id > 0
        ? $existing_enquiry_id
        : wp_insert_post([
            'post_type' => 'fenster_enquiry',
            'post_status' => 'private',
            'post_title' => trim($full_name) !== '' ? $full_name . ' - WindowCAD' : 'WindowCAD lead',
            'post_content' => $summary,
        ], true);

    if (! is_wp_error($enquiry_id)) {
        $meta = [
            '_fenster_name' => $full_name,
            '_fenster_email' => $email,
            '_fenster_phone' => $phone,
            '_fenster_location' => $postcode,
            '_fenster_project_type' => 'WindowCAD',
            '_fenster_source' => 'WindowCAD',
            '_fenster_page_url' => home_url('/online-quote/'),
            '_fenster_journey_ref' => $journey_ref,
            '_fenster_marketing_ref' => $marketing_ref,
            '_fenster_ad_click_type' => $ad_click_type,
            '_fenster_ad_click_id' => $ad_click_id,
            '_fenster_ads_tracker' => $ads_tracker,
            '_fenster_quote_price' => number_format($quote_price, 2, '.', ''),
            '_fenster_analytics_consent' => $journey_ref !== '' ? '1' : '0',
            '_fenster_marketing_consent' => $marketing_consent ? '1' : '0',
            '_fenster_windowcad_fields' => wp_json_encode($fields),
            '_fenster_windowcad_fingerprint' => $fingerprint,
        ];
        foreach ($meta as $key => $value) {
            update_post_meta((int) $enquiry_id, $key, $value);
        }
    }

    // Record the completion for the dashboard before attempting AdminBase, so
    // attribution never depends on the office CRM being reachable. The lead
    // itself is already saved as a private enquiry above.
    if ($existing_enquiry_id === 0 && ! is_wp_error($enquiry_id) && $journey_ref !== '') {
        fenster_dashboard_track_event('quote_completed', [
            'event_id' => 'wp-windowcad-' . (int) $enquiry_id,
            'journey_id' => $journey_ref,
            'price_amount' => $quote_price,
            'price_currency' => 'GBP',
        ]);
    } elseif ($existing_enquiry_id === 0 && ! is_wp_error($enquiry_id)) {
        // No consented FG2 reference: never create a dashboard journey, but do
        // count the completion in the aggregate-only statistical path so total
        // WindowCAD completions remain measurable and a broken Tracking field
        // is visible within a day instead of silently zeroing the tracker.
        fenster_dashboard_track_stat(
            'quote_completed',
            '/online-quote/',
            'wp-windowcad-' . (int) $enquiry_id,
            (string) get_post_time('c', true, (int) $enquiry_id)
        );
    }
    /*
     * Attach the completed quote to the ad click behind it. Runs whether or not
     * a consented FG2 journey exists, because the FGA reference is derived from
     * the landing URL rather than from anything stored on the visitor — so a
     * paid quote from somebody who refused cookies still reports its campaign
     * and its value. The quote price is the value: it is what the office would
     * bill if the job lands, and it is what makes cost per lead comparable
     * between campaigns.
     */
    if ($existing_enquiry_id === 0 && ! is_wp_error($enquiry_id) && $marketing_ref !== '') {
        fenster_relay_ad_click_outcome($marketing_ref, 'quote_completed', $quote_price);
    }

    if ($existing_enquiry_id === 0 && ! is_wp_error($enquiry_id)) {
        fenster_meta_track_enquiry(
            (int) $enquiry_id,
            'Lead',
            'wp-windowcad-' . (int) $enquiry_id,
            $quote_price
        );
    }

    $result = fenster_adminbase_relay([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        'postcode' => $postcode,
        'house_number' => $house_number,
        'street' => $street,
        'notes' => $notes,
    ]);

    if (! is_wp_error($enquiry_id)) {
        foreach (fenster_adminbase_meta_from_result($result) as $key => $value) {
            update_post_meta((int) $enquiry_id, $key, $value);
        }
    }

    if (is_wp_error($result)) {
        fenster_windowcad_log('adminbase relay failed', [
            'error' => $result->get_error_message(),
            'enquiry_id' => is_wp_error($enquiry_id) ? 0 : (int) $enquiry_id,
        ]);

        return new WP_REST_Response([
            'status' => 'error',
            'message' => $result->get_error_message(),
            'enquiry_id' => is_wp_error($enquiry_id) ? 0 : (int) $enquiry_id,
        ], 500);
    }

    fenster_windowcad_log('adminbase relay succeeded', [
        'status' => (string) ($result['status'] ?? ''),
        'enquiry_id' => is_wp_error($enquiry_id) ? 0 : (int) $enquiry_id,
    ]);

    return new WP_REST_Response([
        'status' => 'success',
        'message' => 'Lead sent to AdminBase.',
        'enquiry_id' => is_wp_error($enquiry_id) ? 0 : (int) $enquiry_id,
    ], 200);
}

add_action('fenster_enquiry_created', 'fenster_send_enquiry_to_adminbase', 10, 3);
function fenster_send_enquiry_to_adminbase(int $enquiry_id, array $meta, string $message): void
{
    $name = (string) ($meta['_fenster_name'] ?? '');
    [$first_name, $last_name] = fenster_adminbase_surname_parts($name);
    $project_type = (string) ($meta['_fenster_project_type'] ?? '');
    $is_commercial = stripos($project_type, 'commercial') !== false;

    $result = fenster_adminbase_relay([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => (string) ($meta['_fenster_email'] ?? ''),
        'phone' => (string) ($meta['_fenster_phone'] ?? ''),
        'postcode' => (string) ($meta['_fenster_location'] ?? ''),
        'notes' => trim($message . (($meta['_fenster_journey_ref'] ?? '') !== '' ? "\n\nWebsite tracking: " . $meta['_fenster_journey_ref'] : '')),
        'sales_area' => $is_commercial ? 'COMM' : '',
        'quote_type' => $is_commercial ? 'Commercial' : '',
    ]);

    foreach (fenster_adminbase_meta_from_result($result) as $key => $value) {
        update_post_meta($enquiry_id, $key, $value);
    }

    if (is_wp_error($result)) {
        error_log('Fenster AdminBase enquiry error: ' . $result->get_error_message());
    }
}
