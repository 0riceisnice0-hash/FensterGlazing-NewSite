<?php
/**
 * Reusable Fenster enquiry form.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'class' => 'fg-form',
    'source' => 'Website',
    'button_label' => 'Send enquiry',
    'project_type' => 'Residential windows and doors',
    'project_options' => [],
    'show_company' => false,
    'compact' => false,
    'lock_project_type' => false,
    'consultation_booking' => false,
]);

$project_options = is_array($args['project_options']) && ! empty($args['project_options'])
    ? $args['project_options']
    : [
        'Residential windows and doors',
        'Bifold or sliding doors',
        'Entrance doors',
        'Roof lanterns or integral blinds',
        'Replacement glass or repairs',
        'Commercial glazing',
    ];
$phone_pattern = '^(?:\+44|0044|0)[0-9\s().-]{9,18}$';
$postcode_pattern = '^([Gg][Ii][Rr]\s?0[Aa]{2}|[A-Za-z]{1,2}[0-9][A-Za-z0-9]?\s?[0-9][A-Za-z]{2})$';
$status = sanitize_key(wp_unslash($_GET['fenster_enquiry'] ?? ''));
$notices = [
    'success' => ['title' => 'Thanks - your enquiry has been received.', 'copy' => 'The Fenster team now has your details and will come back to you as soon as possible.'],
    'missing' => ['title' => 'Please check the highlighted details.', 'copy' => 'Name, email, phone, postcode, project type, project details and privacy confirmation are required.'],
    'bad_email' => ['title' => 'Please check your email address.', 'copy' => 'Enter a valid email address so the team can reply.'],
    'bad_phone' => ['title' => 'Please check your phone number.', 'copy' => 'Enter a valid UK phone number, such as 01908 429200 or 07123 456789.'],
    'bad_postcode' => ['title' => 'Please check your postcode.', 'copy' => 'Enter a valid UK postcode.'],
    'bad_appointment' => ['title' => 'Please choose another appointment time.', 'copy' => 'Consultations can be requested on weekdays in the next 30 days, between 9am and 4pm.'],
    'invalid' => ['title' => 'The form session expired.', 'copy' => 'Please refresh the page and send your enquiry again.'],
    'error' => ['title' => 'We could not save that enquiry.', 'copy' => 'Please call 01908 429200 or email info@fensterglazing.com and the team will help.'],
];
?>

<form
    class="<?php echo esc_attr((string) $args['class']); ?> fg-enquiry-form"
    action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
    method="post"
    enctype="multipart/form-data"
    data-fg-enquiry-form
    data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
    <div class="fg-enquiry-form__feedback" data-fg-enquiry-feedback tabindex="-1" hidden></div>
    <?php if (isset($notices[$status])) : ?>
        <div class="fg-enquiry-form__notice fg-enquiry-form__notice--<?php echo esc_attr($status); ?>" role="<?php echo $status === 'success' ? 'status' : 'alert'; ?>">
            <strong><?php echo esc_html($notices[$status]['title']); ?></strong>
            <span><?php echo esc_html($notices[$status]['copy']); ?></span>
        </div>
    <?php endif; ?>

    <?php if (! empty($args['consultation_booking'])) : ?>
        <input type="hidden" name="project_type" value="Consultation request">
        <input type="hidden" name="appointment_date" value="" data-fg-consultation-date required>
        <input type="hidden" name="appointment_time" value="" data-fg-consultation-time required>

        <div class="fg-consultation-booking" data-fg-consultation-booking>
            <noscript>
                <label><span><?php esc_html_e('Preferred weekday', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><input type="date" name="appointment_date" min="<?php echo esc_attr(wp_date('Y-m-d')); ?>" max="<?php echo esc_attr(wp_date('Y-m-d', strtotime('+30 days'))); ?>" required></label>
                <label><span><?php esc_html_e('Preferred time', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><select name="appointment_time" required><option value=""><?php esc_html_e('Select a time', 'fenster'); ?></option><?php foreach (['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $time) : ?><?php $time_label = (((int) substr($time, 0, 2) % 12) ?: 12) . ((int) substr($time, 0, 2) < 12 ? ' am' : ' pm'); ?><option value="<?php echo esc_attr($time); ?>"><?php echo esc_html($time_label); ?></option><?php endforeach; ?></select></label>
            </noscript>
            <div class="fg-consultation-booking__stage" data-fg-consultation-stage="date">
                <div class="fg-consultation-booking__intro">
                    <span><?php esc_html_e('Step 1 of 3', 'fenster'); ?></span>
                    <strong><?php esc_html_e('Pick a date for your consultation.', 'fenster'); ?></strong>
                    <p><?php esc_html_e('Pick a preferred time and the Fenster team will confirm the appointment with you.', 'fenster'); ?></p>
                </div>
                <div class="fg-consultation-booking__calendar" data-fg-consultation-calendar aria-live="polite"></div>
            </div>
            <div class="fg-consultation-booking__stage" data-fg-consultation-stage="time" hidden>
                <div class="fg-consultation-booking__times" data-fg-consultation-times>
                <div><span><?php esc_html_e('Step 2 of 3', 'fenster'); ?></span><strong><?php esc_html_e('Choose a time between 9am and 4pm.', 'fenster'); ?></strong></div>
                <div class="fg-consultation-booking__time-options" role="group" aria-label="<?php esc_attr_e('Available consultation times', 'fenster'); ?>">
                    <?php foreach (['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $time) : ?>
                        <?php $time_label = (((int) substr($time, 0, 2) % 12) ?: 12) . ((int) substr($time, 0, 2) < 12 ? ' am' : ' pm'); ?>
                        <button type="button" data-fg-consultation-time-option data-time="<?php echo esc_attr($time); ?>" aria-pressed="false"><?php echo esc_html($time_label); ?></button>
                    <?php endforeach; ?>
                </div>
                <button class="fg-consultation-booking__back" type="button" data-fg-consultation-back="date"><?php esc_html_e('Change date', 'fenster'); ?></button>
                </div>
            </div>
            <div class="fg-consultation-booking__stage" data-fg-consultation-stage="details" hidden>
                <div class="fg-consultation-booking__selection" data-fg-consultation-selection></div>
                <div class="fg-consultation-booking__details">
                    <div class="fg-consultation-booking__details-head"><span><?php esc_html_e('Step 3 of 3', 'fenster'); ?></span><strong><?php esc_html_e('Your details', 'fenster'); ?></strong><button class="fg-consultation-booking__back" type="button" data-fg-consultation-back="time"><?php esc_html_e('Change time', 'fenster'); ?></button></div>
                    <div class="fg-enquiry-form__row">
                    <label><span><?php esc_html_e('Your name', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><input type="text" name="name" autocomplete="name" required></label>
                    <label><span><?php esc_html_e('Phone number', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><input type="tel" name="phone" autocomplete="tel" inputmode="tel" pattern="<?php echo esc_attr($phone_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK phone number.', 'fenster'); ?>" required></label>
                </div>
                <div class="fg-enquiry-form__row">
                    <label><span><?php esc_html_e('Email address', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><input type="email" name="email" autocomplete="email" required></label>
                    <label><span><?php esc_html_e('Postcode', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><input type="text" name="location" autocomplete="postal-code" inputmode="text" pattern="<?php echo esc_attr($postcode_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK postcode.', 'fenster'); ?>" required></label>
                </div>
                <label class="fg-enquiry-form__message"><span><?php esc_html_e('What would you like to discuss?', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span><textarea name="message" rows="4" required placeholder="<?php esc_attr_e('Tell us about your windows, doors, glazing, repairs or showroom visit.', 'fenster'); ?>"></textarea></label>
                <label class="fg-enquiry-form__consent"><input type="checkbox" name="privacy" value="1" required><span><?php printf(wp_kses(__('I agree that Fenster can use these details to respond to my enquiry. See the <a href="%s">privacy policy</a>.', 'fenster'), ['a' => ['href' => []]]), esc_url(home_url('/privacy-policy/'))); ?></span></label>
                <div class="fg-enquiry-form__footer"><button class="button" type="submit"><span><?php echo esc_html((string) $args['button_label']); ?></span><i aria-hidden="true">-&gt;</i></button><small><?php esc_html_e('Your preferred time is a request. Fenster will confirm your appointment directly.', 'fenster'); ?></small></div>
            </div>
            </div>
        </div>
    <?php elseif (! empty($args['compact'])) : ?>
        <div class="fg-enquiry-form__compact-grid">
            <input type="hidden" name="project_type" value="<?php echo esc_attr((string) $args['project_type']); ?>">
            <label>
                <span><?php esc_html_e('Your name', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="text" name="name" autocomplete="name" required>
            </label>
            <label>
                <span><?php esc_html_e('Phone number', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="tel" name="phone" autocomplete="tel" inputmode="tel" pattern="<?php echo esc_attr($phone_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK phone number.', 'fenster'); ?>" required>
            </label>
            <label>
                <span><?php esc_html_e('Email address', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="email" name="email" autocomplete="email" required>
            </label>
            <label>
                <span><?php esc_html_e('Postcode', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="text" name="location" autocomplete="postal-code" inputmode="text" pattern="<?php echo esc_attr($postcode_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK postcode.', 'fenster'); ?>" required>
            </label>
            <label class="fg-enquiry-form__message fg-enquiry-form__compact-wide">
                <span><?php esc_html_e('Project details', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <textarea name="message" rows="4" required placeholder="<?php esc_attr_e('What would you like to change? Approximate sizes, number of items, access notes or anything else useful.', 'fenster'); ?>"></textarea>
            </label>
            <label class="fg-enquiry-form__compact-wide">
                <span><?php esc_html_e('Photos or files', 'fenster'); ?></span>
                <input type="file" name="attachments[]" accept=".jpg,.jpeg,.png,.webp,.heic,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt" multiple>
                <small><?php esc_html_e('Optional. Add photos, drawings, schedules or documents up to 8MB each.', 'fenster'); ?></small>
            </label>

            <label class="fg-enquiry-form__consent fg-enquiry-form__compact-wide">
                <input type="checkbox" name="privacy" value="1" required>
                <span>
                    <?php
                    printf(
                        wp_kses(
                            __('I agree that Fenster can use these details to respond to my enquiry. See the <a href="%s">privacy policy</a>.', 'fenster'),
                            ['a' => ['href' => []]]
                        ),
                        esc_url(home_url('/privacy-policy/'))
                    );
                    ?>
                </span>
            </label>

            <div class="fg-enquiry-form__footer fg-enquiry-form__compact-wide">
                <button class="button" type="submit">
                    <span><?php echo esc_html((string) $args['button_label']); ?></span>
                    <i aria-hidden="true">-&gt;</i>
                </button>
                <small><?php esc_html_e('Your enquiry is securely saved before email delivery.', 'fenster'); ?></small>
            </div>
        </div>
    <?php else : ?>
    <input type="hidden" name="project_type" value="<?php echo esc_attr((string) $args['project_type']); ?>" data-fg-project-type>
    <?php if (empty($args['lock_project_type'])) : ?>
        <fieldset class="fg-enquiry-form__audience" data-fg-audience-gate>
            <legend><?php esc_html_e('Choose enquiry type', 'fenster'); ?></legend>
            <div class="fg-enquiry-form__audience-options">
                <button type="button" data-fg-audience-choice data-project-type="Residential windows and doors" aria-pressed="false">
                    <b aria-hidden="true">01</b>
                    <span><?php esc_html_e('Homeowner', 'fenster'); ?></span>
                    <small><?php esc_html_e('Windows, doors, glass, repairs or home improvements for your property.', 'fenster'); ?></small>
                    <i aria-hidden="true"><?php esc_html_e('Continue', 'fenster'); ?></i>
                </button>
                <button type="button" data-fg-audience-choice data-project-type="Commercial glazing" aria-pressed="false">
                    <b aria-hidden="true">02</b>
                    <span><?php esc_html_e('Business', 'fenster'); ?></span>
                    <small><?php esc_html_e('Commercial sites, schools, offices, shopfronts, schedules or tender work.', 'fenster'); ?></small>
                    <i aria-hidden="true"><?php esc_html_e('Continue', 'fenster'); ?></i>
                </button>
            </div>
        </fieldset>
    <?php endif; ?>

    <div class="fg-enquiry-form__body" data-fg-audience-body>
    <div class="fg-enquiry-form__body-head">
        <span><?php echo esc_html(empty($args['lock_project_type']) ? __('Step 2 of 2', 'fenster') : __('Project enquiry', 'fenster')); ?></span>
        <strong><?php esc_html_e('Tell us the basics.', 'fenster'); ?></strong>
        <p><?php esc_html_e('A few useful details are enough. Fenster can confirm the exact specification after survey.', 'fenster'); ?></p>
    </div>

    <fieldset class="fg-enquiry-form__step">
        <legend><?php esc_html_e('Your contact details', 'fenster'); ?></legend>
        <div class="fg-enquiry-form__row">
            <label>
                <span><?php esc_html_e('Your name', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="text" name="name" autocomplete="name" required>
            </label>
            <?php if (! empty($args['show_company'])) : ?>
                <label>
                    <span><?php esc_html_e('Company', 'fenster'); ?></span>
                    <input type="text" name="company" autocomplete="organization">
                </label>
            <?php else : ?>
                <label>
                    <span><?php esc_html_e('Phone number', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                    <input type="tel" name="phone" autocomplete="tel" inputmode="tel" pattern="<?php echo esc_attr($phone_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK phone number.', 'fenster'); ?>" required>
                </label>
            <?php endif; ?>
        </div>
    </fieldset>

    <fieldset class="fg-enquiry-form__step">
        <legend><?php esc_html_e('How should we reply?', 'fenster'); ?></legend>
        <div class="fg-enquiry-form__row">
            <label>
                <span><?php esc_html_e('Email address', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="email" name="email" autocomplete="email" required>
            </label>
            <label>
                <span><?php echo esc_html(! empty($args['show_company']) ? 'Phone number' : 'Postcode'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input
                    type="<?php echo ! empty($args['show_company']) ? 'tel' : 'text'; ?>"
                    name="<?php echo ! empty($args['show_company']) ? 'phone' : 'location'; ?>"
                    autocomplete="<?php echo ! empty($args['show_company']) ? 'tel' : 'postal-code'; ?>"
                    inputmode="<?php echo ! empty($args['show_company']) ? 'tel' : 'text'; ?>"
                    pattern="<?php echo esc_attr(! empty($args['show_company']) ? $phone_pattern : $postcode_pattern); ?>"
                    title="<?php echo esc_attr(! empty($args['show_company']) ? __('Enter a valid UK phone number.', 'fenster') : __('Enter a valid UK postcode.', 'fenster')); ?>"
                    required>
            </label>
        </div>
        <?php if (! empty($args['show_company'])) : ?>
            <label>
                <span><?php esc_html_e('Postcode', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
                <input type="text" name="location" autocomplete="postal-code" inputmode="text" pattern="<?php echo esc_attr($postcode_pattern); ?>" title="<?php esc_attr_e('Enter a valid UK postcode.', 'fenster'); ?>" required>
            </label>
        <?php endif; ?>
    </fieldset>

    <fieldset class="fg-enquiry-form__step">
        <legend><?php esc_html_e('A few project details', 'fenster'); ?></legend>
        <label class="fg-enquiry-form__message">
            <span><?php esc_html_e('Tell us about your project', 'fenster'); ?> <em><?php esc_html_e('Required', 'fenster'); ?></em></span>
            <textarea name="message" rows="5" required placeholder="<?php esc_attr_e('What would you like to change? Approximate sizes, number of items, access notes or anything else useful.', 'fenster'); ?>"></textarea>
            <small><?php esc_html_e('Add photos, drawings or schedules below if they help explain the project.', 'fenster'); ?></small>
        </label>

        <label>
            <span><?php esc_html_e('Photos or files', 'fenster'); ?></span>
            <input type="file" name="attachments[]" accept=".jpg,.jpeg,.png,.webp,.heic,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt" multiple>
            <small><?php esc_html_e('Optional. Add photos, drawings, schedules or documents up to 8MB each.', 'fenster'); ?></small>
        </label>

        <label class="fg-enquiry-form__consent">
            <input type="checkbox" name="privacy" value="1" required>
            <span>
                <?php
                printf(
                    wp_kses(
                        __('I agree that Fenster can use these details to respond to my enquiry. See the <a href="%s">privacy policy</a>.', 'fenster'),
                        ['a' => ['href' => []]]
                    ),
                    esc_url(home_url('/privacy-policy/'))
                );
                ?>
            </span>
        </label>

        <div class="fg-enquiry-form__footer">
            <button class="button" type="submit">
                <span><?php echo esc_html((string) $args['button_label']); ?></span>
                <i aria-hidden="true">-&gt;</i>
            </button>
            <small><?php esc_html_e('Your enquiry is securely saved before email delivery.', 'fenster'); ?></small>
            </div>
    </fieldset>
    </div>
    <?php endif; ?>

    <div class="fg-enquiry-form__trap" aria-hidden="true">
        <label>
            <span><?php esc_html_e('Company website', 'fenster'); ?></span>
            <input type="text" name="company_website" tabindex="-1" autocomplete="off">
        </label>
    </div>
    <input type="hidden" name="action" value="fenster_submit_enquiry">
    <input type="hidden" name="source" value="<?php echo esc_attr((string) $args['source']); ?>">
    <input type="hidden" name="page_url" value="<?php echo esc_url((string) home_url(wp_unslash($_SERVER['REQUEST_URI'] ?? '/'))); ?>">
    <input type="hidden" name="journey_ref" value="" data-fg-journey-ref>
    <input type="hidden" name="visitor_id" value="" data-fg-visitor-id>
    <input type="hidden" name="fenster_started_at" value="<?php echo esc_attr((string) time()); ?>">
    <?php wp_nonce_field('fenster_submit_enquiry', 'fenster_enquiry_nonce'); ?>
</form>
