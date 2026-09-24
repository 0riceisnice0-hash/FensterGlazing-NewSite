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
     *
     * IT HAPPENED A SECOND TIME AND THE RAISED CAP WAS THE CAUSE, 2026-09-04.
     * 5000000 was still inside the real distribution: accepted quotes routinely
     * reach 3.75MB, so the margin was less than one factor of two. Five genuine
     * leads were 413'd between 13 August and 4 September — 5.94MB, 6.65MB,
     * 8.64MB, 5.77MB and 10.37MB, five of the 140 submissions in that window —
     * and because the rejection happens in the permission callback, none of them
     * created an enquiry or reached AdminBase. They were invisible in WordPress:
     * an absence in the Enquiries list is the only trace a dropped webhook
     * leaves, which is why three weeks passed before anyone noticed.
     *
     * THE CHECK CANNOT DO THE JOB THE FIRST PARAGRAPH CLAIMS FOR IT. PHP has
     * already read and buffered the entire body by the time `get_body()` returns
     * it, so the memory is spent before the comparison runs; live sits at
     * `post_max_size=256M` and `memory_limit=768M`, and the real ceiling is
     * those, not this line. It is kept only as a bound on something absurd, and
     * is set far enough above any plausible quote that it cannot cost a lead
     * again. If a genuine submission ever approaches 64MB, raise it — do not
     * treat the rejection as protecting anything.
     */
    $body_length = strlen((string) $request->get_body());
    if ($body_length > 64000000) {
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

/**
 * The decoded payload, once per request: a quote is several megabytes and
 * both the fields and the project id are read from it.
 */
function fenster_windowcad_payload_data(WP_REST_Request $request): array
{
    // Held with the request itself: an object id alone can be handed to the
    // next request once this one is freed.
    static $last = null;
    if ($last === null || $last[0] !== $request) {
        $data = $request->get_json_params();
        if (! is_array($data) || empty($data)) {
            // WindowCAD's fetch() sends no content type, so the body arrives as text.
            $parsed = json_decode((string) $request->get_body(), true);
            $data = is_array($parsed) ? $parsed : [];
        }
        $last = [$request, $data];
    }

    return $last[1];
}

function fenster_windowcad_payload_fields(WP_REST_Request $request): array
{
    $data = fenster_windowcad_payload_data($request);

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

/*
 * EVERYTHING WINDOWCAD SENDS IS KEPT, AND HANDED ON TO FIELDOS. 2026-09-24.
 *
 * Zac: "why are windowcad leads not coming in with the quote and sales
 * contract attached ... they throw away everything except name etc. so store
 * that info." The account's CRM hook posts the whole priced quote here: every
 * item with its product, style, colours, glass, hardware, size, price and a
 * picture of it, the total with VAT, and - when the office presses Print to
 * CRM - the Quotation or Sales Contract PDF itself. This file kept the name,
 * email and phone out of it and let the rest go.
 *
 * Now each payload is written whole, gzipped, OUTSIDE the web root (this host's
 * nginx serves any static file under public_html before Apache's rewrite
 * runs, so a folder in there is not private), and forwarded to FieldOS, which
 * puts the quote on the residential lead. A forward that fails leaves a marker
 * in pending/ and the hourly retry sends it; FieldOS takes the same bytes only
 * once, so a retry can never double anything.
 *
 * What the body is, read from WindowCAD 7.2.0's designer on 2026-09-24:
 * { supplierUsername, username, json, appType, accountType, event?, pdf? }.
 * `json.id` is WindowCAD's project id, the same id its notice to info@ links.
 * `event` is absent for a customer's own submission and names the office's
 * action otherwise ("Pdf", "Project_status_changed", "Order",
 * "Project_created") - none of which is a new lead.
 */

function fenster_windowcad_store_dir(): string
{
    $configured = fenster_adminbase_config_value('FENSTER_WINDOWCAD_STORE_DIR', 'fenster_windowcad_store_dir');
    if ($configured !== '') {
        return rtrim($configured, '/\\');
    }

    // Bedrock's .../public_html/web/wp/ and a plain install's .../public/ both
    // climb out of everything the server can serve.
    $dir = rtrim(ABSPATH, '/\\');
    while (in_array(basename($dir), ['wp', 'web', 'public_html', 'public'], true)) {
        $dir = dirname($dir);
    }

    return $dir . '/fenster-private/windowcad';
}

function fenster_fieldos_windowcad_target(): array
{
    return [
        'url' => fenster_adminbase_config_value('FENSTER_FIELDOS_WINDOWCAD_URL', 'fenster_fieldos_windowcad_url'),
        'key' => fenster_adminbase_config_value('FENSTER_FIELDOS_WINDOWCAD_KEY', 'fenster_fieldos_windowcad_key'),
    ];
}

/** WindowCAD's project id: a 24 character hex id. Anything else is not a WindowCAD project. */
function fenster_windowcad_project_id(array $data): string
{
    $id = $data['json']['id'] ?? $data['id'] ?? '';

    return is_string($id) && preg_match('/^[0-9a-f]{24}$/i', $id) ? strtolower($id) : '';
}

function fenster_windowcad_event(array $data): string
{
    $event = $data['event'] ?? '';

    return is_string($event) ? sanitize_key($event) : '';
}

/**
 * Writes the body once, gzipped, and leaves a pending marker for the forward.
 * Returns the stored file name, or '' when nothing was kept.
 */
function fenster_windowcad_keep_payload(string $body, string $received_at): string
{
    $dir = fenster_windowcad_store_dir();
    $month = gmdate('Y-m', strtotime($received_at) ?: time());
    if (! wp_mkdir_p($dir . '/' . $month) || ! wp_mkdir_p($dir . '/pending')) {
        fenster_windowcad_log('payload not kept: the store folder could not be made');

        return '';
    }

    $sha = hash('sha256', $body);
    $name = $month . '/' . $sha . '.json.gz';
    $path = $dir . '/' . $name;
    if (! file_exists($path)) {
        // A bound on what an open webhook can write in a day. Fenster gets a
        // handful of real quotes a day; this is two orders of magnitude above.
        $today = 'fenster_wc_kept_' . gmdate('Ymd');
        $kept_today = (int) get_transient($today);
        if ($kept_today >= 500) {
            fenster_windowcad_log('payload not kept: the daily bound is reached', ['kept' => $kept_today]);

            return '';
        }
        $gz = gzencode($body, 6);
        if ($gz === false || file_put_contents($path, $gz, LOCK_EX) === false) {
            fenster_windowcad_log('payload not kept: the write failed', ['bytes' => strlen($body)]);

            return '';
        }
        set_transient($today, $kept_today + 1, DAY_IN_SECONDS);
        file_put_contents(
            $dir . '/pending/' . $sha,
            (string) wp_json_encode(['file' => $name, 'received_at' => $received_at, 'enquiry_id' => 0]),
            LOCK_EX
        );
    }

    return $name;
}

/** Sends one payload to FieldOS. True once FieldOS has it. */
function fenster_windowcad_forward(string $body, int $enquiry_id, string $received_at): bool
{
    $target = fenster_fieldos_windowcad_target();
    if ($target['url'] === '' || $target['key'] === '') {
        return false;
    }

    $response = wp_remote_post($target['url'], [
        'timeout' => 20,
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $target['key'],
            'X-Fenster-Enquiry-Id' => (string) $enquiry_id,
            'X-Fenster-Received-At' => $received_at,
        ],
        'body' => $body,
        'data_format' => 'body',
    ]);
    if (is_wp_error($response)) {
        fenster_windowcad_log('forward to FieldOS failed', ['error' => $response->get_error_message()]);

        return false;
    }
    $status = (int) wp_remote_retrieve_response_code($response);
    if ($status < 200 || $status >= 300) {
        fenster_windowcad_log('forward to FieldOS refused', [
            'status' => $status,
            'body' => substr((string) wp_remote_retrieve_body($response), 0, 200),
        ]);

        return false;
    }

    return true;
}

/** Keeps the payload, then hands it on; the marker goes once FieldOS has it. */
function fenster_windowcad_hand_on(string $body, string $kept, int $enquiry_id, string $received_at): void
{
    if (fenster_windowcad_forward($body, $enquiry_id, $received_at)) {
        if ($kept !== '') {
            @unlink(fenster_windowcad_store_dir() . '/pending/' . basename($kept, '.json.gz'));
        }
    } elseif ($kept !== '' && $enquiry_id > 0) {
        // The retry sends the enquiry id too.
        $marker = fenster_windowcad_store_dir() . '/pending/' . basename($kept, '.json.gz');
        if (file_exists($marker)) {
            file_put_contents(
                $marker,
                (string) wp_json_encode(['file' => $kept, 'received_at' => $received_at, 'enquiry_id' => $enquiry_id]),
                LOCK_EX
            );
        }
    }
}

add_action('init', 'fenster_schedule_windowcad_forward');
function fenster_schedule_windowcad_forward(): void
{
    if (! wp_next_scheduled('fenster_windowcad_forward_pending')) {
        wp_schedule_event(time() + HOUR_IN_SECONDS, 'hourly', 'fenster_windowcad_forward_pending');
    }
}

/** The hourly retry: whatever FieldOS has not acknowledged, oldest first. */
add_action('fenster_windowcad_forward_pending', 'fenster_windowcad_forward_pending');
function fenster_windowcad_forward_pending(int $limit = 20): array
{
    $dir = fenster_windowcad_store_dir();
    $markers = glob($dir . '/pending/*') ?: [];
    usort($markers, static fn (string $a, string $b): int => filemtime($a) <=> filemtime($b));
    $sent = 0;
    $failed = 0;
    foreach (array_slice($markers, 0, $limit) as $marker) {
        $meta = json_decode((string) file_get_contents($marker), true);
        $file = is_array($meta) ? (string) ($meta['file'] ?? '') : '';
        $gz = $file !== '' ? @file_get_contents($dir . '/' . $file) : false;
        $body = $gz !== false ? gzdecode($gz) : false;
        if ($body === false) {
            fenster_windowcad_log('pending payload unreadable', ['marker' => basename($marker)]);
            $failed++;
            continue;
        }
        if (fenster_windowcad_forward($body, (int) ($meta['enquiry_id'] ?? 0), (string) ($meta['received_at'] ?? gmdate('c')))) {
            @unlink($marker);
            $sent++;
        } else {
            $failed++;
        }
    }

    return ['sent' => $sent, 'failed' => $failed, 'waiting' => max(0, count($markers) - $sent)];
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('fenster windowcad forward', static function (): void {
        WP_CLI::line((string) wp_json_encode(fenster_windowcad_forward_pending(200)));
    });
}

function fenster_handle_windowcad_submission(WP_REST_Request $request): WP_REST_Response|WP_Error
{
    $received_at = gmdate('c');
    $body = (string) $request->get_body();
    $data = fenster_windowcad_payload_data($request);
    $project_id = fenster_windowcad_project_id($data);
    $event = fenster_windowcad_event($data);
    // Kept first, before anything below can turn it away: it is the only copy.
    $kept = $project_id !== '' ? fenster_windowcad_keep_payload($body, $received_at) : '';

    $fields = fenster_windowcad_payload_fields($request);
    fenster_windowcad_log('submission received', [
        'content_type' => (string) $request->get_header('content-type'),
        'body_length' => strlen($body),
        'fields' => $fields,
        'project' => $project_id,
        'event' => $event,
        'kept' => $kept !== '',
    ]);

    // The office printing the quotation or the sales contract to CRM, or
    // changing the project's status, posts the same project again. It is never a
    // new lead: no enquiry, no AdminBase lead and no conversion, which is what
    // every Print to CRM used to produce. It goes to FieldOS, where the PDF lands
    // on the lead the customer's own submission made.
    if ($event !== '' && ! str_ends_with($event, '_designer_submitted')) {
        fenster_windowcad_hand_on($body, $kept, 0, $received_at);

        return new WP_REST_Response([
            'status' => 'success',
            'message' => 'Kept for FieldOS.',
            'event' => $event,
        ], 200);
    }

    if (empty($fields)) {
        fenster_windowcad_log('empty payload rejected');
        if ($kept !== '') {
            fenster_windowcad_hand_on($body, $kept, 0, $received_at);
        }

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
            '_fenster_windowcad_project' => $project_id,
            '_fenster_windowcad_payload' => $kept,
        ];
        foreach ($meta as $key => $value) {
            update_post_meta((int) $enquiry_id, $key, $value);
        }
    }

    // The whole quote to FieldOS before anything slower runs; the hourly retry
    // covers it if FieldOS cannot be reached now.
    fenster_windowcad_hand_on($body, $kept, is_wp_error($enquiry_id) ? 0 : (int) $enquiry_id, $received_at);

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
