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
        'permission_callback' => '__return_true',
    ]);
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
    $notes = 'Lead from WindowCAD';
    $journey_ref = fenster_windowcad_reference_from_fields($fields);
    $quote_price = fenster_windowcad_price_from_fields($fields);

    $summary = implode("\n", array_filter([
        'Name: ' . $full_name,
        'Email: ' . $email,
        $phone !== '' ? 'Phone: ' . $phone : '',
        $postcode !== '' ? 'Postcode: ' . $postcode : '',
        $house_number !== '' ? 'House number: ' . $house_number : '',
        $street !== '' ? 'Street: ' . $street : '',
        'Source: WindowCAD',
        '',
        'Raw WindowCAD fields:',
        wp_json_encode($fields, JSON_PRETTY_PRINT),
    ]));

    $enquiry_id = wp_insert_post([
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
            '_fenster_windowcad_fields' => wp_json_encode($fields),
        ];
        foreach ($meta as $key => $value) {
            update_post_meta((int) $enquiry_id, $key, $value);
        }
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

    fenster_dashboard_track_event('quote_completed', [
        'journey_id' => $journey_ref,
        'price_amount' => $quote_price,
        'price_currency' => 'GBP',
    ]);

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
        'notes' => $message,
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
