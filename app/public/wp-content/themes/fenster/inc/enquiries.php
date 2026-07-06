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

add_filter('manage_fenster_enquiry_posts_columns', 'fenster_enquiry_admin_columns');
function fenster_enquiry_admin_columns(array $columns): array
{
    return [
        'cb' => $columns['cb'] ?? '<input type="checkbox">',
        'title' => __('Customer', 'fenster'),
        'fenster_project' => __('Project', 'fenster'),
        'fenster_contact' => __('Contact', 'fenster'),
        'fenster_source' => __('Source', 'fenster'),
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

    return (string) apply_filters('fenster_enquiry_recipient', 'info@fensterglazing.com');
}

add_action('phpmailer_init', 'fenster_configure_smtp');
function fenster_configure_smtp(PHPMailer\PHPMailer\PHPMailer $mailer): void
{
    if (! defined('FENSTER_SMTP_HOST') || trim((string) FENSTER_SMTP_HOST) === '') {
        return;
    }

    $mailer->isSMTP();
    $mailer->Host = (string) FENSTER_SMTP_HOST;
    $mailer->Port = defined('FENSTER_SMTP_PORT') ? (int) FENSTER_SMTP_PORT : 587;
    $mailer->SMTPAuth = defined('FENSTER_SMTP_USERNAME') && (string) FENSTER_SMTP_USERNAME !== '';
    $mailer->Username = defined('FENSTER_SMTP_USERNAME') ? (string) FENSTER_SMTP_USERNAME : '';
    $mailer->Password = defined('FENSTER_SMTP_PASSWORD') ? (string) FENSTER_SMTP_PASSWORD : '';
    $mailer->SMTPSecure = defined('FENSTER_SMTP_SECURE') ? (string) FENSTER_SMTP_SECURE : 'tls';
    $mailer->From = 'info@fensterglazing.com';
    $mailer->FromName = 'Fenster Glazing';
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

function fenster_enquiry_office_email(array $data, int $enquiry_id): string
{
    $logo = FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png';
    $admin_url = admin_url('post.php?post=' . $enquiry_id . '&action=edit');
    $phone_href = $data['phone'] !== '' ? 'tel:' . preg_replace('/[^0-9+]/', '', $data['phone']) : '';
    $rows = implode('', [
        fenster_enquiry_email_row('Customer', $data['name']),
        fenster_enquiry_email_row('Company', $data['company']),
        fenster_enquiry_email_row('Email', $data['email'], 'mailto:' . $data['email']),
        fenster_enquiry_email_row('Phone', $data['phone'], $phone_href),
        fenster_enquiry_email_row('Location', $data['location']),
        fenster_enquiry_email_row('Project', $data['project_type']),
        fenster_enquiry_email_row('Timescale', $data['timescale'] !== '' ? $data['timescale'] : 'Not specified'),
        fenster_enquiry_email_row('Source', $data['source']),
    ]);

    return '<!doctype html>
<html lang="en"><head><meta name="viewport" content="width=device-width,initial-scale=1"><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#edf4f2;font-family:Arial,Helvetica,sans-serif;color:#06212a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#edf4f2;"><tr><td align="center" style="padding:28px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 16px 50px rgba(0,45,58,.12);">
<tr><td style="padding:24px 28px;background:#003845;"><table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td><img src="' . esc_url($logo) . '" width="150" alt="Fenster Glazing" style="display:block;max-width:150px;height:auto;"></td><td align="right" style="color:#75d49d;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">New website enquiry</td></tr></table></td></tr>
<tr><td style="padding:30px 28px 12px;"><div style="display:inline-block;padding:7px 10px;border-radius:999px;background:#e6f6ed;color:#087943;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">' . esc_html($data['project_type']) . '</div><h1 style="margin:16px 0 8px;color:#06212a;font-size:28px;line-height:1.12;">' . esc_html($data['name']) . ' has started a project.</h1><p style="margin:0;color:#60727a;font-size:15px;line-height:1.6;">Reply directly to this email to contact the customer, or use the details below.</p></td></tr>
<tr><td style="padding:10px 28px 4px;"><table role="presentation" width="100%" cellspacing="0" cellpadding="0">' . $rows . '</table></td></tr>
<tr><td style="padding:24px 28px;"><div style="padding:22px;border-radius:12px;background:#f3f8f7;border-left:4px solid #2eac66;"><div style="margin-bottom:8px;color:#087943;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Project details</div><div style="color:#06212a;font-size:16px;line-height:1.65;">' . nl2br(esc_html($data['message'])) . '</div></div></td></tr>
<tr><td style="padding:0 28px 30px;"><table role="presentation" cellspacing="0" cellpadding="0"><tr><td style="border-radius:8px;background:#2eac66;"><a href="mailto:' . esc_attr($data['email']) . '" style="display:inline-block;padding:14px 20px;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;">Reply to ' . esc_html($data['name']) . '</a></td><td width="10"></td><td style="border-radius:8px;border:1px solid #cbdad7;"><a href="' . esc_url($admin_url) . '" style="display:inline-block;padding:13px 20px;color:#003845;text-decoration:none;font-size:15px;font-weight:700;">View saved enquiry</a></td></tr></table></td></tr>
<tr><td style="padding:18px 28px;background:#f3f8f7;color:#60727a;font-size:12px;line-height:1.5;">Submitted from <a href="' . esc_url($data['page_url']) . '" style="color:#087943;">' . esc_html($data['page_url']) . '</a><br>The enquiry was saved privately in WordPress before this email was sent.</td></tr>
</table></td></tr></table></body></html>';
}

function fenster_enquiry_customer_email(array $data): string
{
    $logo = FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png';

    return '<!doctype html>
<html lang="en"><head><meta name="viewport" content="width=device-width,initial-scale=1"><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#edf4f2;font-family:Arial,Helvetica,sans-serif;color:#06212a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:28px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:16px;overflow:hidden;">
<tr><td style="padding:24px 28px;background:#003845;"><img src="' . esc_url($logo) . '" width="150" alt="Fenster Glazing" style="display:block;max-width:150px;height:auto;"></td></tr>
<tr><td style="padding:32px 28px;"><div style="color:#2eac66;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Enquiry received</div><h1 style="margin:12px 0;color:#06212a;font-size:28px;line-height:1.15;">Thanks, ' . esc_html($data['name']) . '.</h1><p style="margin:0 0 16px;color:#60727a;font-size:16px;line-height:1.65;">We have received your enquiry about <strong style="color:#06212a;">' . esc_html($data['project_type']) . '</strong>. A member of the Fenster team will come back to you as soon as possible.</p><p style="margin:0 0 22px;color:#60727a;font-size:16px;line-height:1.65;">If you have photos, drawings or schedules, reply to this email and attach them.</p><div style="padding:18px;border-radius:10px;background:#f3f8f7;color:#06212a;font-size:15px;line-height:1.6;">' . nl2br(esc_html($data['message'])) . '</div></td></tr>
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

    $honeypot = sanitize_text_field(wp_unslash($_POST['company_website'] ?? ''));
    $started_at = absint($_POST['fenster_started_at'] ?? 0);
    if ($honeypot !== '' || ($started_at > 0 && time() - $started_at < 2)) {
        return ['status' => 'success', 'message' => 'Thanks — your enquiry has been received.', 'spam' => true];
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
    ];
    $privacy = ! empty($_POST['privacy']);

    if ($data['name'] === '' || $data['email'] === '' || $data['phone'] === '' || $data['location'] === '' || $data['project_type'] === '' || $data['message'] === '' || ! $privacy) {
        return fenster_enquiry_error('missing', 'Please complete the required fields and confirm the privacy notice.');
    }

    if (! is_email($data['email'])) {
        return fenster_enquiry_error('bad_email', 'Please enter a valid email address.');
    }

    if (! fenster_enquiry_valid_phone($data['phone'])) {
        return fenster_enquiry_error('bad_phone', 'Please enter a valid UK phone number.');
    }

    if (! fenster_enquiry_valid_postcode($data['location'])) {
        return fenster_enquiry_error('bad_postcode', 'Please enter a valid UK postcode.');
    }

    $summary = implode("\n", array_filter([
        'Name: ' . $data['name'],
        'Email: ' . $data['email'],
        $data['company'] !== '' ? 'Company: ' . $data['company'] : '',
        $data['phone'] !== '' ? 'Phone: ' . $data['phone'] : '',
        $data['location'] !== '' ? 'Postcode / location: ' . $data['location'] : '',
        'Project type: ' . $data['project_type'],
        $data['timescale'] !== '' ? 'Timescale: ' . $data['timescale'] : '',
        'Source: ' . $data['source'],
        $data['page_url'] !== '' ? 'Page: ' . $data['page_url'] : '',
        '',
        'Project details:',
        $data['message'],
    ]));

    $enquiry_id = wp_insert_post([
        'post_type' => 'fenster_enquiry',
        'post_status' => 'private',
        'post_title' => sprintf('%s — %s', $data['name'], $data['project_type']),
        'post_content' => $summary,
    ], true);

    if (is_wp_error($enquiry_id)) {
        return fenster_enquiry_error('error', 'We could not save your enquiry. Please call or email the team.');
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
    ];
    foreach ($meta as $key => $value) {
        update_post_meta($enquiry_id, $key, $value);
    }

    $recipient = fenster_enquiry_recipient();
    $office_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Fenster Website <info@fensterglazing.com>',
        sprintf('Reply-To: %s <%s>', $data['name'], $data['email']),
    ];
    $office_sent = wp_mail(
        $recipient,
        sprintf('New project enquiry: %s — %s', $data['project_type'], $data['name']),
        fenster_enquiry_office_email($data, (int) $enquiry_id),
        $office_headers
    );
    update_post_meta($enquiry_id, '_fenster_email_sent', $office_sent ? '1' : '0');
    update_post_meta($enquiry_id, '_fenster_email_recipient', $recipient);

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
    update_post_meta($enquiry_id, '_fenster_confirmation_sent', $confirmation_sent ? '1' : '0');

    do_action('fenster_enquiry_created', $enquiry_id, $meta, $data['message']);

    return [
        'status' => 'success',
        'message' => 'Thanks — your enquiry has been received.',
        'copy' => 'Your project details are safely with the Fenster team. We have also sent a confirmation to ' . $data['email'] . '.',
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
