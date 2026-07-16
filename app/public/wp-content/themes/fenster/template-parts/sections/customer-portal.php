<?php
/** Dedicated customer order lookup page. */

$args = is_array($args ?? null) ? $args : [];
$title = (string) ($args['title'] ?? __('Customer portal', 'fenster'));
$portal_url = 'https://orderupdates.abinitiosoftware.co.uk/login/7014422';
?>
<main class="fg-customer-portal-page">
    <section class="fg-customer-portal-hero">
        <div class="container fg-customer-portal-hero__grid">
            <div class="fg-customer-portal-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Existing customers', 'fenster'); ?></p>
                <h1><?php esc_html_e('Check your Fenster order.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Use your order number and postcode to see the latest update on your windows, doors or glazing project.', 'fenster'); ?></p>
                <div class="fg-customer-portal-hero__actions">
                    <a class="button" href="#order-lookup"><?php esc_html_e('Check order status', 'fenster'); ?></a>
                    <a class="button button--ghost" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Fenster', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-customer-portal-hero__note" aria-label="<?php esc_attr_e('Customer portal information', 'fenster'); ?>">
                <span class="fg-customer-portal-hero__note-mark" aria-hidden="true">✓</span>
                <div>
                    <strong><?php esc_html_e('Have your details ready', 'fenster'); ?></strong>
                    <p><?php esc_html_e('You will need the order number from your Fenster paperwork and the postcode linked to the order.', 'fenster'); ?></p>
                </div>
            </aside>
        </div>
    </section>

    <section id="order-lookup" class="fg-customer-portal-lookup">
        <div class="container">
            <div class="fg-customer-portal-lookup__heading">
                <p class="eyebrow"><?php esc_html_e('Order lookup', 'fenster'); ?></p>
                <h2><?php esc_html_e('Enter your order details below.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The secure lookup opens inside this page. Your details are handled by the order system that manages Fenster updates.', 'fenster'); ?></p>
            </div>

            <div class="fg-customer-portal-embed" data-lenis-prevent>
                <div class="fg-customer-portal-embed__bar">
                    <span><?php esc_html_e('Fenster order lookup', 'fenster'); ?></span>
                    <a href="<?php echo esc_url($portal_url); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Open in a separate window', 'fenster'); ?></a>
                </div>
                <iframe
                    src="<?php echo esc_url($portal_url); ?>"
                    title="<?php esc_attr_e('Fenster order lookup', 'fenster'); ?>"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                ></iframe>
            </div>

            <div class="fg-customer-portal-help">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Need a hand?', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We can help with an order update.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('If your order number is not recognised, or you need to discuss a change, contact our team and include your name, address and any reference shown on your paperwork.', 'fenster'); ?></p>
                <div class="fg-customer-portal-help__actions">
                    <a class="button" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    <a class="button button--ghost" href="mailto:info@fensterglazing.com"><?php esc_html_e('Email the team', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>
</main>
