<?php
/**
 * Enquiry capture, storage and email delivery.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', 'fenster_register_enquiry_post_type');
function fenster_register_enquiry_post_type(): void
{
    register_post_type('fenster_enquiry', [
        'labels' => [
            'name' => __('Enquiries', 'fenster'),
            'singular_name' => __('Enquiry', 'fenster'),
            'menu_name' => __('Enquiries', 'fenster'),
            'all_items' => __('All enquiries', 'fenster'),
            'view_item' => __('View enquiry', 'fenster'),
            'search_items' => __('Search enquiries', 'fenster'),
            'not_found' => __('No enquiries found', 'fenster'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title', 'editor'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ]);
}

add_action('add_meta_boxes_fenster_enquiry', 'fenster_enquiry_add_outcome_meta_box');
function fenster_enquiry_add_outcome_meta_box(): void
{
    add_meta_box(
        'fenster-enquiry-outcome',
        __('Lead outcome', 'fenster'),
        'fenster_enquiry_render_outcome_meta_box',
        'fenster_enquiry',
        'side',
        'high'
    );
}

function fenster_enquiry_render_outcome_meta_box(WP_Post $post): void
{
    $status = (string) get_post_meta($post->ID, '_fenster_outcome_status', true);
    $status = $status !== '' ? $status : 'new';
    $value = (string) get_post_meta($post->ID, '_fenster_outcome_value', true);
    wp_nonce_field('fenster_enquiry_outcome_' . $post->ID, 'fenster_enquiry_outcome_nonce');
    ?>
    <p>
        <label for="fenster-outcome-status"><strong><?php esc_html_e('Status', 'fenster'); ?></strong></label>
        <select id="fenster-outcome-status" name="fenster_outcome_status" class="widefat">
            <?php foreach ([
                'new' => __('New', 'fenster'),
                'contacted' => __('Contacted', 'fenster'),
                'qualified' => __('Qualified', 'fenster'),
                'appointment' => __('Appointment', 'fenster'),
                'won' => __('Won', 'fenster'),
                'lost' => __('Lost', 'fenster'),
            ] as $key => $label) : ?>
                <option value="<?php echo esc_attr($key); ?>" <?php selected($status, $key); ?>><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="fenster-outcome-value"><strong><?php esc_html_e('Won value (£)', 'fenster'); ?></strong></label>
        <input id="fenster-outcome-value" class="widefat" type="number" min="0" step="0.01" name="fenster_outcome_value" value="<?php echo esc_attr($value); ?>">
    </p>
    <p class="description"><?php esc_html_e('Qualified and won outcomes are sent to the Marketing Dashboard and become eligible for Google Ads offline reporting when consented attribution is available.', 'fenster'); ?></p>
    <?php
}

add_action('save_post_fenster_enquiry', 'fenster_enquiry_save_outcome', 20, 2);
function fenster_enquiry_save_outcome(int $post_id, WP_Post $post): void
{
    if (wp_is_post_revision($post_id)
        || wp_is_post_autosave($post_id)
        || ! current_user_can('edit_post', $post_id)
        || ! isset($_POST['fenster_enquiry_outcome_nonce'])
        || ! wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['fenster_enquiry_outcome_nonce'])),
            'fenster_enquiry_outcome_' . $post_id
        )
    ) {
        return;
    }

    $status = sanitize_key((string) wp_unslash($_POST['fenster_outcome_status'] ?? 'new'));
    if (! in_array($status, ['new', 'contacted', 'qualified', 'appointment', 'won', 'lost'], true)) {
        $status = 'new';
    }
    $value = max(0, (float) wp_unslash($_POST['fenster_outcome_value'] ?? 0));
    $previous_status = (string) get_post_meta($post_id, '_fenster_outcome_status', true);
    $previous_value = (float) get_post_meta($post_id, '_fenster_outcome_value', true);

    update_post_meta($post_id, '_fenster_outcome_status', $status);
    update_post_meta($post_id, '_fenster_outcome_value', number_format($value, 2, '.', ''));

    if ($previous_status === $status && abs($previous_value - $value) < 0.005) {
        return;
    }

    $updated_at = gmdate('c');
    update_post_meta($post_id, '_fenster_outcome_updated_at', $updated_at);
    $journey_id = (string) get_post_meta($post_id, '_fenster_journey_ref', true);
    fenster_dashboard_track_outcome($journey_id, $status, $value, $updated_at);
    if ($status === 'won') {
        fenster_meta_track_enquiry($post_id, 'Purchase', 'wp-won-' . $post_id, $value);
    }
}

add_filter('manage_fenster_enquiry_posts_columns', 'fenster_enquiry_admin_columns');
function fenster_enquiry_admin_columns(array $columns): array
{
    return [
        'cb' => $columns['cb'] ?? '<input type="checkbox">',
        'title' => __('Customer', 'fenster'),
        'fenster_project' => __('Project', 'fenster'),
        'fenster_contact' => __('Contact', 'fenster'),
        'fenster_source' => __('Source', 'fenster'),
        'fenster_ad' => __('Ad attribution', 'fenster'),
        'fenster_outcome' => __('Outcome', 'fenster'),
        'fenster_delivery' => __('Email', 'fenster'),
        'date' => __('Received', 'fenster'),
    ];
}

add_action('manage_fenster_enquiry_posts_custom_column', 'fenster_render_enquiry_admin_column', 10, 2);
function fenster_render_enquiry_admin_column(string $column, int $post_id): void
{
    if ($column === 'fenster_project') {
        echo esc_html((string) get_post_meta($post_id, '_fenster_project_type', true));
    } elseif ($column === 'fenster_contact') {
        $email = (string) get_post_meta($post_id, '_fenster_email', true);
        $phone = (string) get_post_meta($post_id, '_fenster_phone', true);
        echo esc_html(implode(' · ', array_filter([$email, $phone])));
    } elseif ($column === 'fenster_source') {
        echo esc_html((string) get_post_meta($post_id, '_fenster_source', true));
    } elseif ($column === 'fenster_ad') {
        $click_id = (string) get_post_meta($post_id, '_fenster_ad_click_id', true);
        $click_type = (string) get_post_meta($post_id, '_fenster_ad_click_type', true);
        $ads_tracker = (string) get_post_meta($post_id, '_fenster_ads_tracker', true);
        if ($click_id === '' && $ads_tracker === '') {
            echo '<span aria-hidden="true">&#8212;</span><span class="screen-reader-text">' . esc_html__('Not from an ad', 'fenster') . '</span>';
            return;
        }

        if ($ads_tracker !== '') {
            echo '<code>' . esc_html('ads: ' . $ads_tracker) . '</code>';
        }
        if ($click_id !== '') {
            // The full value is what an offline conversion upload needs, so keep
            // it selectable in the title attribute rather than only showing a stub.
            printf(
                '%1$s<code title="%2$s">%3$s: %4$s</code>',
                $ads_tracker !== '' ? '<br>' : '',
                esc_attr($click_id),
                esc_html($click_type),
                esc_html(strlen($click_id) > 16 ? substr($click_id, 0, 16) . '...' : $click_id)
            );
        }
    } elseif ($column === 'fenster_outcome') {
        $status = (string) get_post_meta($post_id, '_fenster_outcome_status', true);
        echo esc_html(ucfirst($status !== '' ? $status : 'new'));
    } elseif ($column === 'fenster_delivery') {
        $sent = (bool) get_post_meta($post_id, '_fenster_email_sent', true);
        echo esc_html($sent ? __('Sent', 'fenster') : __('Saved only', 'fenster'));
    }
}

function fenster_enquiry_recipient(): string
{
    if (defined('FENSTER_ENQUIRY_EMAIL') && is_email((string) FENSTER_ENQUIRY_EMAIL)) {
        return (string) FENSTER_ENQUIRY_EMAIL;
    }

    return (string) apply_filters('fenster_enquiry_recipient', 'Fenster Glazing <info@fensterglazing.com>');
}

function fenster_mail_config_value(string $key, string $default = ''): string
{
    if (defined($key)) {
        return (string) constant($key);
    }

    $value = getenv($key);
    if (is_string($value) && trim($value) !== '') {
        return $value;
    }

    return $default;
}

function fenster_smtp_is_configured(): bool
{
    return fenster_mail_config_value('FENSTER_SMTP_HOST') !== '';
}

function fenster_enquiry_office_subject(array $data): string
{
    // Set by the honeypot check in fenster_process_enquiry(). The enquiry is saved
    // and sent exactly like any other, so the prefix is the only thing telling the
    // office to read this one before acting on it.
    $prefix = ! empty($data['spam_suspected']) ? '[Possible spam] ' : '';

    if (! empty($data['appointment_date']) && ! empty($data['appointment_time'])) {
        return $prefix . sprintf('New Consultation Request from %s', $data['name']);
    }

    $project = strtolower((string) ($data['project_type'] ?? ''));
    if (str_contains($project, 'commercial')) {
        return $prefix . sprintf('New Commercial Enquiry from %s', $data['name']);
    }

    return $prefix . sprintf('New Residential Enquiry from %s', $data['name']);
}

/**
 * Return England and Wales bank-holiday dates from the official GOV.UK feed.
 *
 * @return string[] Dates in Y-m-d format.
 */
function fenster_consultation_bank_holidays(): array
{
    $cached = get_transient('fenster_consultation_bank_holidays_england_wales');
    if (is_array($cached)) {
        return $cached;
    }

    $dates = [];
    $response = wp_remote_get('https://www.gov.uk/bank-holidays.json', [
        'timeout' => 4,
        'redirection' => 2,
    ]);

    if (! is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $payload = json_decode((string) wp_remote_retrieve_body($response), true);
        $events = $payload['england-and-wales']['events'] ?? [];
        if (is_array($events)) {
            foreach ($events as $event) {
                $date = is_array($event) ? (string) ($event['date'] ?? '') : '';
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    $dates[] = $date;
                }
            }
        }
    }

    $dates = array_values(array_unique($dates));
    if (! empty($dates)) {
        set_transient('fenster_consultation_bank_holidays_england_wales', $dates, DAY_IN_SECONDS);
    }

    return $dates;
}

function fenster_consultation_is_bank_holiday(DateTimeInterface $date): bool
{
    return in_array($date->format('Y-m-d'), fenster_consultation_bank_holidays(), true);
}

add_action('phpmailer_init', 'fenster_configure_smtp');
function fenster_configure_smtp(PHPMailer\PHPMailer\PHPMailer $mailer): void
{
    $host = fenster_mail_config_value('FENSTER_SMTP_HOST');
    if ($host === '') {
        return;
    }

    $mailer->isSMTP();
    $mailer->Host = $host;
    $mailer->Port = (int) fenster_mail_config_value('FENSTER_SMTP_PORT', '587');
    $mailer->Username = fenster_mail_config_value('FENSTER_SMTP_USERNAME');
    $mailer->Password = fenster_mail_config_value('FENSTER_SMTP_PASSWORD');
    $mailer->SMTPAuth = $mailer->Username !== '';
    $mailer->SMTPSecure = fenster_mail_config_value('FENSTER_SMTP_SECURE', 'tls');
    // Pin the authentication mechanism for determinism. Left unset, PHPMailer
    // picks whichever mechanism the relay advertises first, which can vary
    // between environments and makes failures harder to reason about. Brevo
    // authenticates with both CRAM-MD5 and LOGIN, so this is hardening rather
    // than a fix: a 535 is almost always wrong credentials. Override with
    // FENSTER_SMTP_AUTH_TYPE if a provider ever needs something else.
    $mailer->AuthType = fenster_mail_config_value('FENSTER_SMTP_AUTH_TYPE', 'LOGIN');
    $mailer->From = fenster_mail_config_value('FENSTER_MAIL_FROM', 'info@fensterglazing.com');
    $mailer->FromName = fenster_mail_config_value('FENSTER_MAIL_FROM_NAME', 'Fenster Glazing');
    $mailer->Sender = $mailer->From;
}

function fenster_enquiry_redirect(string $status, string $fallback = ''): void
{
    $fallback = $fallback ?: home_url('/contact/');
    $referer = wp_get_referer();
    $redirect = wp_validate_redirect((string) $referer, $fallback);
    $redirect = remove_query_arg(['fenster_enquiry'], $redirect);
    $redirect = add_query_arg('fenster_enquiry', $status, $redirect);
    $redirect .= '#fenster-enquiry';

    wp_safe_redirect($redirect, 303);
    exit;
}

function fenster_enquiry_error(string $status, string $message): WP_Error
{
    return new WP_Error($status, $message);
}

function fenster_enquiry_email_row(string $label, string $value, string $href = ''): string
{
    if ($value === '') {
        return '';
    }

    $content = $href !== ''
        ? sprintf('<a href="%s" style="color:#087943;text-decoration:none;font-weight:700;">%s</a>', esc_url($href), esc_html($value))
        : esc_html($value);

    return sprintf(
        '<tr><td style="padding:12px 0;border-bottom:1px solid #dce7e5;color:#60727a;font-size:13px;line-height:1.4;width:34%%;vertical-align:top;">%s</td><td style="padding:12px 0;border-bottom:1px solid #dce7e5;color:#06212a;font-size:15px;line-height:1.4;font-weight:700;vertical-align:top;">%s</td></tr>',
        esc_html($label),
        $content
    );
}

function fenster_enquiry_files_from_request(string $field = 'attachments'): array
{
    if (empty($_FILES[$field]) || ! is_array($_FILES[$field])) {
        return [];
    }

    $files = $_FILES[$field];
    $normalised = [];
    $names = is_array($files['name'] ?? null) ? $files['name'] : [];

    foreach ($names as $index => $name) {
        $error = (int) ($files['error'][$index] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE || $name === '') {
            continue;
        }

        $normalised[] = [
            'name' => $name,
            'type' => (string) ($files['type'][$index] ?? ''),
            'tmp_name' => (string) ($files['tmp_name'][$index] ?? ''),
            'error' => $error,
            'size' => (int) ($files['size'][$index] ?? 0),
        ];
    }

    return $normalised;
}

function fenster_process_enquiry_uploads(int $enquiry_id): array
{
    $incoming_files = fenster_enquiry_files_from_request();
    if (empty($incoming_files)) {
        return [];
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $allowed_mimes = [
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'heic' => 'image/heic',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'csv' => 'text/csv',
        'txt' => 'text/plain',
    ];
    $uploaded = [];

    foreach (array_slice($incoming_files, 0, 5) as $file) {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || (int) ($file['size'] ?? 0) > 8 * MB_IN_BYTES) {
            continue;
        }

        $handled = wp_handle_upload($file, [
            'test_form' => false,
            'mimes' => $allowed_mimes,
        ]);
        if (! is_array($handled) || ! empty($handled['error']) || empty($handled['file'])) {
            continue;
        }

        $attachment_id = wp_insert_attachment([
            'post_mime_type' => (string) ($handled['type'] ?? ''),
            'post_title' => sanitize_file_name(pathinfo((string) $handled['file'], PATHINFO_FILENAME)),
            'post_content' => '',
            'post_status' => 'private',
            'post_parent' => $enquiry_id,
        ], (string) $handled['file'], $enquiry_id);

        if (! is_wp_error($attachment_id)) {
            wp_update_attachment_metadata((int) $attachment_id, wp_generate_attachment_metadata((int) $attachment_id, (string) $handled['file']));
        }

        $uploaded[] = [
            'id' => is_wp_error($attachment_id) ? 0 : (int) $attachment_id,
            'name' => basename((string) $handled['file']),
            'url' => (string) ($handled['url'] ?? ''),
            'path' => (string) $handled['file'],
        ];
    }

    return $uploaded;
}

// The uploads travel with this email as real attachments, so the row states how
// many to expect rather than listing filenames the mail client already shows. It
// always renders: "nothing attached" is information, and a missing row is not.
function fenster_enquiry_attachment_summary(array $attachments): string
{
    $count = count($attachments);
    if ($count === 0) {
        return 'No images or files attached';
    }

    return $count === 1 ? '1 attachment' : $count . ' attachments';
}

// Same reasoning as the attachment summary above: the free text box is optional
// on every form variant, so the office panel states that nothing was written
// rather than arriving as an empty green box.
function fenster_enquiry_message_summary(string $message): string
{
    return trim($message) !== '' ? $message : 'No project details added';
}

// This goes to office sales staff, who have no WordPress logins, so it must not
// link into wp-admin. Everything needed to act on the lead is in the email.
function fenster_enquiry_office_email(array $data, int $enquiry_id, array $attachments = []): string
{
    $logo = FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png';
    $phone_href = $data['phone'] !== '' ? 'tel:' . preg_replace('/[^0-9+]/', '', $data['phone']) : '';
    $rows = implode('', [
        fenster_enquiry_email_row('Customer', $data['name']),
        fenster_enquiry_email_row('Company', $data['company']),
        fenster_enquiry_email_row('Email', $data['email'], 'mailto:' . $data['email']),
        fenster_enquiry_email_row('Phone', $data['phone'], $phone_href),
        fenster_enquiry_email_row('Location', $data['location']),
        fenster_enquiry_email_row('Project', $data['project_type']),
        fenster_enquiry_email_row('Preferred consultation', $data['appointment_display'] ?? ''),
        fenster_enquiry_email_row('Timescale', $data['timescale'] !== '' ? $data['timescale'] : 'Not specified'),
        fenster_enquiry_email_row('Source', $data['source']),
        fenster_enquiry_email_row('Attachments', fenster_enquiry_attachment_summary($attachments)),
    ]);

    return '<!doctype html>
<html lang="en"><head><meta name="viewport" content="width=device-width,initial-scale=1"><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#edf4f2;font-family:Arial,Helvetica,sans-serif;color:#06212a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#edf4f2;"><tr><td align="center" style="padding:28px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 16px 50px rgba(0,45,58,.12);">
<tr><td style="padding:22px 28px;background:#ffffff;border-bottom:1px solid #dce7e5;"><table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td><img src="' . esc_url($logo) . '" width="170" alt="Fenster Glazing" style="display:block;max-width:170px;height:auto;"></td><td align="right" style="color:#087943;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">' . (! empty($data['appointment_display']) ? 'Consultation request' : 'New website enquiry') . '</td></tr></table></td></tr>
<tr><td style="padding:30px 28px 12px;"><div style="display:inline-block;padding:7px 10px;border-radius:999px;background:#e6f6ed;color:#087943;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">' . esc_html($data['project_type']) . '</div><h1 style="margin:16px 0 8px;color:#06212a;font-size:28px;line-height:1.12;">' . esc_html($data['name']) . (! empty($data['appointment_display']) ? ' has requested a consultation.' : ' has started a project.') . '</h1><p style="margin:0;color:#60727a;font-size:15px;line-height:1.6;">Reply directly to this email to contact the customer, or use the details below.</p></td></tr>
<tr><td style="padding:10px 28px 4px;"><table role="presentation" width="100%" cellspacing="0" cellpadding="0">' . $rows . '</table></td></tr>
<tr><td style="padding:24px 28px;"><div style="padding:22px;border-radius:12px;background:#f3f8f7;border-left:4px solid #2eac66;"><div style="margin-bottom:8px;color:#087943;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Project details</div><div style="color:#06212a;font-size:16px;line-height:1.65;">' . nl2br(esc_html(fenster_enquiry_message_summary($data['message']))) . '</div></div></td></tr>
<tr><td style="padding:0 28px 30px;"><table role="presentation" cellspacing="0" cellpadding="0"><tr><td style="border-radius:8px;background:#2eac66;"><a href="mailto:' . esc_attr($data['email']) . '" style="display:inline-block;padding:14px 20px;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;">Reply to ' . esc_html($data['name']) . '</a></td></tr></table></td></tr>
<tr><td style="padding:18px 28px;background:#f3f8f7;color:#60727a;font-size:12px;line-height:1.5;">Submitted from <a href="' . esc_url($data['page_url']) . '" style="color:#087943;">' . esc_html($data['page_url']) . '</a><br>The enquiry was saved privately in WordPress before this email was sent.</td></tr>
</table></td></tr></table></body></html>';
}

function fenster_enquiry_customer_email(array $data): string
{
    $logo = FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png';
    /*
     * This panel quotes the customer's own words back to them, so unlike the
     * office one it is dropped when there are none. Telling the office that
     * nothing was written is useful; telling the customer what they already
     * know is not. The message box is optional on every form variant.
     */
    $message_panel = trim($data['message']) !== ''
        ? '<div style="padding:18px;border-radius:10px;background:#f3f8f7;color:#06212a;font-size:15px;line-height:1.6;">' . nl2br(esc_html($data['message'])) . '</div>'
        : '';

    return '<!doctype html>
<html lang="en"><head><meta name="viewport" content="width=device-width,initial-scale=1"><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#edf4f2;font-family:Arial,Helvetica,sans-serif;color:#06212a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:28px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:16px;overflow:hidden;">
<tr><td style="padding:22px 28px;background:#ffffff;border-bottom:1px solid #dce7e5;"><img src="' . esc_url($logo) . '" width="170" alt="Fenster Glazing" style="display:block;max-width:170px;height:auto;"></td></tr>
<tr><td style="padding:32px 28px;"><div style="color:#2eac66;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Enquiry received</div><h1 style="margin:12px 0;color:#06212a;font-size:28px;line-height:1.15;">Thanks, ' . esc_html($data['name']) . '.</h1><p style="margin:0 0 16px;color:#60727a;font-size:16px;line-height:1.65;">We have received your enquiry about <strong style="color:#06212a;">' . esc_html($data['project_type']) . '</strong>. A member of our team will come back to you as soon as possible.</p><p style="margin:0 0 22px;color:#60727a;font-size:16px;line-height:1.65;">If you have extra photos, drawings or schedules, send them to info@fensterglazing.com.</p>' . $message_panel . '</td></tr>
<tr><td style="padding:20px 28px;background:#f3f8f7;color:#60727a;font-size:13px;line-height:1.6;"><strong style="color:#06212a;">Fenster Glazing</strong><br>01908 429200 · info@fensterglazing.com</td></tr>
</table></td></tr></table></body></html>';
}

function fenster_enquiry_valid_phone(string $phone): bool
{
    $phone = trim($phone);
    if ($phone === '' || ! preg_match('/^[0-9+().\s-]{10,24}$/', $phone)) {
        return false;
    }

    if (substr_count($phone, '+') > 1 || (str_contains($phone, '+') && ! str_starts_with($phone, '+'))) {
        return false;
    }

    $digits = preg_replace('/\D+/', '', $phone);
    if (! is_string($digits)) {
        return false;
    }

    if (str_starts_with($digits, '0044')) {
        $national = '0' . substr($digits, 4);
    } elseif (str_starts_with($digits, '44')) {
        $national = '0' . substr($digits, 2);
    } else {
        $national = $digits;
    }

    return (bool) preg_match('/^0[1-9][0-9]{8,9}$/', $national);
}

function fenster_enquiry_valid_postcode(string $postcode): bool
{
    $postcode = strtoupper(preg_replace('/\s+/', '', trim($postcode)) ?? '');

    return (bool) preg_match('/^(GIR0AA|[A-Z]{1,2}[0-9][A-Z0-9]?[0-9][A-Z]{2})$/', $postcode);
}

function fenster_process_enquiry(): array|WP_Error
{
    if (
        ! isset($_POST['fenster_enquiry_nonce'])
        || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fenster_enquiry_nonce'])), 'fenster_submit_enquiry')
    ) {
        return fenster_enquiry_error('invalid', 'The form session expired. Please refresh the page and try again.');
    }

    $data = [
        'name' => sanitize_text_field(wp_unslash($_POST['name'] ?? '')),
        'email' => sanitize_email(wp_unslash($_POST['email'] ?? '')),
        'company' => sanitize_text_field(wp_unslash($_POST['company'] ?? '')),
        'phone' => sanitize_text_field(wp_unslash($_POST['phone'] ?? '')),
        'location' => sanitize_text_field(wp_unslash($_POST['location'] ?? '')),
        'project_type' => sanitize_text_field(wp_unslash($_POST['project_type'] ?? '')),
        'timescale' => sanitize_text_field(wp_unslash($_POST['timescale'] ?? '')),
        'message' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
        'source' => sanitize_text_field(wp_unslash($_POST['source'] ?? 'Website')),
        'page_url' => esc_url_raw(wp_unslash($_POST['page_url'] ?? '')),
        'journey_ref' => sanitize_text_field(wp_unslash($_POST['journey_ref'] ?? '')),
        'visitor_id' => sanitize_text_field(wp_unslash($_POST['visitor_id'] ?? '')),
        'analytics_consent' => sanitize_text_field(wp_unslash($_POST['analytics_consent'] ?? '0')) === '1',
        'ad_click_id' => sanitize_text_field(wp_unslash($_POST['ad_click_id'] ?? '')),
        'ad_tracker' => sanitize_text_field(wp_unslash($_POST['ad_tracker'] ?? '')),
        'marketing_ref' => sanitize_text_field(wp_unslash($_POST['marketing_ref'] ?? '')),
        'marketing_consent' => sanitize_text_field(wp_unslash($_POST['marketing_consent'] ?? '0')) === '1',
        'appointment_date' => sanitize_text_field(wp_unslash($_POST['appointment_date'] ?? '')),
        'appointment_time' => sanitize_text_field(wp_unslash($_POST['appointment_time'] ?? '')),
    ];
    $data['journey_ref'] = preg_match('/^FG2-[A-Z0-9-]{8,80}$/i', $data['journey_ref']) ? strtoupper($data['journey_ref']) : '';
    $data['visitor_id'] = preg_match('/^FGV-[A-Z0-9-]{8,80}$/i', $data['visitor_id']) ? strtoupper($data['visitor_id']) : '';
    /*
     * These two flags are asserted by the browser, not verified here, and that
     * is a deliberate limit rather than an oversight. `fenster_cookie_consent`
     * lives in local storage and is never written to a cookie, so PHP has
     * nothing to check them against; the generated Privacy Policy tells
     * visitors that in as many words. Do not "harden" this by mirroring
     * consent into a cookie without changing that policy text first.
     *
     * The flags still narrow what gets stored, so a normal rejecting visitor
     * saves no journey, visitor id or click id. Forging them only exposes the
     * forger's own submission.
     */
    if (! $data['analytics_consent']) {
        $data['journey_ref'] = '';
        $data['visitor_id'] = '';
    }
    if (! $data['marketing_consent']) {
        $data['ad_click_id'] = '';
        $data['ad_tracker'] = '';
    }

    /*
     * NOT cleared on a marketing refusal, unlike the two above, and the
     * difference is the point of it. The click id and the ad tracker are values
     * we persisted about the visitor; this is a one-way hash of the URL they
     * arrived on, held server-side against a campaign and nothing else. It
     * identifies an ad click, not a person, and clearing it would lose which
     * campaign paid for the lead while protecting nobody.
     */
    $data['marketing_ref'] = preg_match('/^FGA-[A-Z0-9-]{8,80}$/i', $data['marketing_ref'])
        ? strtoupper($data['marketing_ref'])
        : '';

    /*
     * Google Ads click identifiers arrive as "gclid:value", "gbraid:value" or
     * "wbraid:value". Split the type from the value so an offline conversion
     * export can put each in the column Google expects. Anything else is dropped.
     */
    $data['ad_click_type'] = '';
    if (preg_match('/^(gclid|gbraid|wbraid):([A-Za-z0-9_\-\.]{10,200})$/', $data['ad_click_id'], $click_parts)) {
        $data['ad_click_type'] = $click_parts[1];
        $data['ad_click_id'] = $click_parts[2];
    } else {
        $data['ad_click_id'] = '';
    }
    $data['ad_tracker'] = preg_match('/^[A-Za-z0-9 _.-]{1,80}$/', $data['ad_tracker'])
        ? $data['ad_tracker']
        : '';
    $privacy = ! empty($_POST['privacy']);

    // `message` is deliberately absent from this gate: the free-text box was made
    // optional on every variant of the form (owner approved 2026-08-13). An empty
    // message reaches the record and both emails, which is why the summary and the
    // office panel below state that none was given rather than rendering blank.
    if ($data['name'] === '' || $data['email'] === '' || $data['phone'] === '' || $data['location'] === '' || $data['project_type'] === '' || ! $privacy) {
        return fenster_enquiry_error('missing', 'Please complete the required fields and confirm the privacy notice.');
    }

    /*
     * Honeypot. `company_website` is rendered inside an aria-hidden wrapper with
     * tabindex="-1" (template-parts/components/enquiry-form.php:318-323), so no
     * visitor can reach it, including one using a screen reader; something
     * automated filling the form is what puts a value there.
     *
     * A hit is flagged, never discarded. A real lead must not be lost, and a
     * browser autofill mistake would otherwise bin a genuine enquiry in silence.
     * The submission is saved, relayed and emailed as normal, with the office
     * subject prefixed and `_fenster_spam_suspected` recorded so the office can
     * judge it themselves. The response returned below is the same either way,
     * so a bot learns nothing from being caught.
     */
    $data['spam_suspected'] = sanitize_text_field(wp_unslash($_POST['company_website'] ?? '')) !== '';

    if (! is_email($data['email'])) {
        return fenster_enquiry_error('bad_email', 'Please enter a valid email address.');
    }

    if (! fenster_enquiry_valid_phone($data['phone'])) {
        return fenster_enquiry_error('bad_phone', 'Please enter a valid UK phone number.');
    }

    if (! fenster_enquiry_valid_postcode($data['location'])) {
        return fenster_enquiry_error('bad_postcode', 'Please enter a valid UK postcode.');
    }

    $has_appointment = $data['appointment_date'] !== '' || $data['appointment_time'] !== '';
    $data['appointment_display'] = '';
    if ($data['project_type'] === 'Consultation request' && ! $has_appointment) {
        return fenster_enquiry_error('bad_appointment', 'Please choose a weekday within the next 30 days and a time between 9am and 4pm.');
    }

    if ($has_appointment) {
        $timezone = wp_timezone();
        $appointment = DateTimeImmutable::createFromFormat('!Y-m-d', $data['appointment_date'], $timezone);
        $today = new DateTimeImmutable('today', $timezone);
        $last_bookable_day = $today->modify('+30 days');
        $allowed_times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

        if (
            ! $appointment
            || $appointment->format('Y-m-d') !== $data['appointment_date']
            || $appointment < $today
            || $appointment > $last_bookable_day
            || (int) $appointment->format('N') > 5
            || fenster_consultation_is_bank_holiday($appointment)
            || ! in_array($data['appointment_time'], $allowed_times, true)
        ) {
            return fenster_enquiry_error('bad_appointment', 'Please choose a Monday to Friday date within the next 30 days, excluding bank holidays, and a time between 9am and 4pm.');
        }

        $data['appointment_display'] = wp_date('l j F Y', $appointment->getTimestamp(), $timezone) . ' at ' . wp_date('g a', strtotime($data['appointment_time']));
    }

    $summary = implode("\n", array_filter([
        'Name: ' . $data['name'],
        'Email: ' . $data['email'],
        $data['company'] !== '' ? 'Company: ' . $data['company'] : '',
        $data['phone'] !== '' ? 'Phone: ' . $data['phone'] : '',
        $data['location'] !== '' ? 'Postcode / location: ' . $data['location'] : '',
        'Project type: ' . $data['project_type'],
        $data['appointment_display'] !== '' ? 'Preferred consultation: ' . $data['appointment_display'] : '',
        $data['timescale'] !== '' ? 'Timescale: ' . $data['timescale'] : '',
        'Source: ' . $data['source'],
        $data['page_url'] !== '' ? 'Page: ' . $data['page_url'] : '',
        '',
        'Project details:',
        fenster_enquiry_message_summary($data['message']),
    ]));

    $enquiry_id = wp_insert_post([
        'post_type' => 'fenster_enquiry',
        'post_status' => 'private',
        'post_title' => sprintf('%s — %s', $data['name'], $data['project_type']),
        'post_content' => $summary,
    ], true);

    if (is_wp_error($enquiry_id)) {
        return fenster_enquiry_error('error', 'We could not save your enquiry. Please call or email us.');
    }

    $meta = [
        '_fenster_name' => $data['name'],
        '_fenster_email' => $data['email'],
        '_fenster_company' => $data['company'],
        '_fenster_phone' => $data['phone'],
        '_fenster_location' => $data['location'],
        '_fenster_project_type' => $data['project_type'],
        '_fenster_timescale' => $data['timescale'],
        '_fenster_source' => $data['source'],
        '_fenster_page_url' => $data['page_url'],
        '_fenster_journey_ref' => $data['journey_ref'],
        '_fenster_visitor_id' => $data['visitor_id'],
        '_fenster_ad_click_type' => $data['ad_click_type'],
        '_fenster_ad_click_id' => $data['ad_click_id'],
        '_fenster_ads_tracker' => $data['ad_tracker'],
        '_fenster_marketing_ref' => $data['marketing_ref'],
        '_fenster_analytics_consent' => $data['analytics_consent'] ? '1' : '0',
        '_fenster_marketing_consent' => $data['marketing_consent'] ? '1' : '0',
        '_fenster_appointment_date' => $data['appointment_date'],
        '_fenster_appointment_time' => $data['appointment_time'],
        '_fenster_appointment_display' => $data['appointment_display'],
        '_fenster_spam_suspected' => $data['spam_suspected'] ? '1' : '0',
    ];
    foreach ($meta as $key => $value) {
        update_post_meta($enquiry_id, $key, $value);
    }

    $attachments = fenster_process_enquiry_uploads((int) $enquiry_id);
    if (! empty($attachments)) {
        update_post_meta($enquiry_id, '_fenster_attachments', wp_json_encode($attachments));
    }

    $recipient = fenster_enquiry_recipient();
    $office_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: WordPress <wordpress@fensterglazing.com>',
    ];
    $office_sent = wp_mail(
        $recipient,
        fenster_enquiry_office_subject($data),
        fenster_enquiry_office_email($data, (int) $enquiry_id, $attachments),
        $office_headers,
        array_values(array_filter(array_column($attachments, 'path')))
    );
    update_post_meta($enquiry_id, '_fenster_email_sent', $office_sent ? '1' : '0');
    update_post_meta($enquiry_id, '_fenster_email_recipient', $recipient);

    $confirmation_sent = false;
    if (fenster_smtp_is_configured()) {
        $customer_headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: Fenster Glazing <info@fensterglazing.com>',
            'Reply-To: Fenster Glazing <info@fensterglazing.com>',
        ];
        $confirmation_sent = wp_mail(
            $data['email'],
            'We received your Fenster Glazing enquiry',
            fenster_enquiry_customer_email($data),
            $customer_headers
        );
    }
    update_post_meta($enquiry_id, '_fenster_confirmation_sent', $confirmation_sent ? '1' : '0');

    do_action('fenster_enquiry_created', $enquiry_id, $meta, $data['message']);

    if ($data['journey_ref'] !== '') {
        fenster_dashboard_track_event('form_submitted', [
            'event_id' => 'wp-form-' . (int) $enquiry_id,
            'journey_id' => $data['journey_ref'],
            'visitor_id' => $data['visitor_id'],
            'page_path' => (string) wp_parse_url($data['page_url'], PHP_URL_PATH),
            'cta' => $data['source'],
        ]);
    } else {
        fenster_dashboard_track_stat(
            'form_submitted',
            (string) wp_parse_url($data['page_url'], PHP_URL_PATH),
            'wp-form-' . (int) $enquiry_id,
            (string) get_post_time('c', true, $enquiry_id)
        );
    }
    /*
     * Attach the lead to the ad click that produced it. Independent of the two
     * branches above: those depend on analytics consent, and this deliberately
     * does not, which is what keeps cost per lead per campaign measurable for
     * the majority of paid visitors who never answer the banner.
     */
    if ($data['marketing_ref'] !== '') {
        fenster_relay_ad_click_outcome($data['marketing_ref'], 'form_submitted');
    }

    fenster_meta_track_enquiry(
        (int) $enquiry_id,
        $data['appointment_display'] !== '' ? 'Schedule' : 'Lead',
        'wp-form-' . (int) $enquiry_id,
        0,
        true
    );

    return [
        'status' => 'success',
        'message' => 'Thanks — your enquiry has been received.',
        'copy' => 'Your project details are safely with our team.',
        'enquiry_id' => (int) $enquiry_id,
        'office_email_sent' => $office_sent,
        'confirmation_sent' => $confirmation_sent,
    ];
}

add_action('admin_post_nopriv_fenster_submit_enquiry', 'fenster_handle_enquiry_submission');
add_action('admin_post_fenster_submit_enquiry', 'fenster_handle_enquiry_submission');
function fenster_handle_enquiry_submission(): void
{
    $result = fenster_process_enquiry();
    if (is_wp_error($result)) {
        fenster_enquiry_redirect((string) $result->get_error_code());
    }

    fenster_enquiry_redirect('success');
}

add_action('wp_ajax_nopriv_fenster_submit_enquiry', 'fenster_handle_enquiry_ajax');
add_action('wp_ajax_fenster_submit_enquiry', 'fenster_handle_enquiry_ajax');
function fenster_handle_enquiry_ajax(): void
{
    $result = fenster_process_enquiry();
    if (is_wp_error($result)) {
        wp_send_json_error([
            'status' => $result->get_error_code(),
            'message' => $result->get_error_message(),
        ], 422);
    }

    wp_send_json_success($result);
}
