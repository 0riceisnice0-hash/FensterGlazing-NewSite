<?php
/**
 * Site footer.
 *
 * @package Fenster
 */

$brand = fenster_data('brand', []);
$footer_products = [
    ['label' => 'Double Glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/')],
    ['label' => 'Windows and doors', 'url' => home_url('/windows-milton-keynes/')],
    ['label' => 'Aluminium glazing', 'url' => home_url('/aluminium-windows/')],
    ['label' => 'Bifolds and sliders', 'url' => home_url('/aluminium-bifold-doors/')],
    ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/')],
    ['label' => 'Flat rooflights', 'url' => home_url('/flat-rooflights/')],
    /* SPLIT 2026-08-31. One sitewide footer link read "Repairs and
       replacement units" and pointed at the REPLACEMENT GLAZING page, so the
       only footer anchor either service had led with the wrong word and the
       repairs page had no footer link at all. It is on all 721 pages, which
       makes it the single most repeated anchor text on the site describing
       these two services, and it conflated the exact distinction both pages
       exist to draw. Two links, each naming its own service. */
    ['label' => 'Replacement glass', 'url' => home_url('/double-glazing-replacement/')],
    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/')],
    ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
];
$footer_company = [
    ['label' => 'About Fenster', 'url' => home_url('/about/')],
    ['label' => 'Why Trust Fenster', 'url' => home_url('/why-trust-fenster/')],
    ['label' => 'Meet the Team', 'url' => home_url('/meet-the-team/')],
    ['label' => 'Areas We Cover', 'url' => home_url('/areas-we-cover/')],
    ['label' => 'Care and Maintenance', 'url' => home_url('/care-and-maintenance/')],
    /* `AI.md` has recorded since 2026-08-26 that `/why-distinction/` is
       reached from the composite page AND from the footer, the way
       `/care-and-maintenance/` is. It was not: one CTA band on one page
       was the only route to it on the whole site. Added 2026-08-27. */
    ['label' => 'Why Distinction Doors', 'url' => home_url('/why-distinction/')],
    ['label' => 'Case Studies', 'url' => home_url('/case-studies/')],
    ['label' => 'Commercial Projects', 'url' => home_url('/commercial-projects/')],
    ['label' => 'Contact', 'url' => home_url('/contact/')],
    ['label' => 'Instant Quote', 'url' => home_url('/online-quote/')],
    ['label' => 'Book a Free Consultation', 'url' => home_url('/book-a-consultation/')],
];
?>
<footer class="site-footer">
    <div class="container site-footer__grid">
        <div class="site-footer__about">
            <img class="site-footer__logo" src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/brand/18931 - 2026 - Fenster Glazing Logo - Dark Background.png'); ?>" alt="<?php echo esc_attr($brand['name']); ?>">
            <p><?php echo esc_html($brand['tagline']); ?></p>
            <div class="site-footer__trust" aria-label="<?php esc_attr_e('Accreditations', 'fenster'); ?>">
                <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s FENSA approved installations', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/fensa.png'); ?>" alt="<?php esc_attr_e('FENSA approved', 'fenster'); ?>">
                </a>
                <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>" aria-label="<?php esc_attr_e('Learn about Consumer Protection Association protection', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/cpa.png'); ?>" alt="<?php esc_attr_e('Consumer Protection Association', 'fenster'); ?>">
                </a>
                <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/constructionline-gold/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s Constructionline Gold membership', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/constructionline-gold-member.png'); ?>" alt="<?php esc_attr_e('Constructionline Gold Member', 'fenster'); ?>">
                </a>
                <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/ssip-health-and-safety/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s SSIP health and safety assessment', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/imported/cropped-ssip.png'); ?>" alt="<?php esc_attr_e('SSIP health and safety assessed', 'fenster'); ?>">
                </a>
                <a class="fg-accreditation-logo-link site-footer__trust-mark" href="<?php echo esc_url((string) fenster_data('brand.google_reviews_url', '')); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Read Fenster Glazing reviews on Google', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/google-5-stars.png'); ?>" alt="<?php esc_attr_e('Google five star reviews', 'fenster'); ?>">
                </a>
                <a class="fg-accreditation-logo-link site-footer__trust-mark" href="<?php echo esc_url((string) fenster_data('brand.trustpilot_url', '')); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Read Fenster Glazing reviews on Trustpilot', 'fenster'); ?>">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png'); ?>" alt="<?php esc_attr_e('Trustpilot Excellent reviews', 'fenster'); ?>">
                </a>
            </div>
            <div class="site-footer__socials" aria-label="<?php esc_attr_e('Fenster Glazing social media', 'fenster'); ?>">
                <a href="https://www.instagram.com/fensterglazing/" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Fenster Glazing on Instagram', 'fenster'); ?>">
                    <svg class="site-footer__social-outline" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.5"></circle></svg>
                    <span>Instagram</span>
                </a>
                <a href="https://www.facebook.com/fensterg/" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Fenster Glazing on Facebook', 'fenster'); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v6h4v-6h3l1-4h-4V9c0-.7.3-1 1-1Z"></path></svg>
                    <span>Facebook</span>
                </a>
                <a href="https://www.linkedin.com/company/fenster-glazing/" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Fenster Glazing on LinkedIn', 'fenster'); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="9" width="4" height="12"></rect><circle cx="5" cy="5" r="2"></circle><path d="M10 9h4v2c1-1.5 2.5-2.4 4.5-2.4 2.4 0 3.5 1.6 3.5 4.4v8h-4v-7c0-1.4-.5-2.2-1.7-2.2-1.4 0-2.3 1-2.3 2.8V21h-4Z"></path></svg>
                    <span>LinkedIn</span>
                </a>
            </div>
        </div>

        <div class="site-footer__nav">
            <h2><?php esc_html_e('What we do', 'fenster'); ?></h2>
            <?php foreach ($footer_products as $item) : ?>
                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php endforeach; ?>
        </div>

        <div class="site-footer__nav">
            <h2><?php esc_html_e('Fenster', 'fenster'); ?></h2>
            <?php foreach ($footer_company as $item) : ?>
                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php endforeach; ?>
        </div>

        <div class="site-footer__contact">
            <h2><?php esc_html_e('Contact', 'fenster'); ?></h2>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'])); ?>"><?php echo esc_html($brand['phone']); ?></a>
            <a href="mailto:<?php echo esc_attr($brand['email']); ?>"><?php echo esc_html($brand['email']); ?></a>
            <?php if (! empty($brand['address'])) : ?>
                <address>
                    <?php foreach ($brand['address'] as $line) : ?>
                        <?php echo esc_html($line); ?><br>
                    <?php endforeach; ?>
                </address>
            <?php endif; ?>
            <?php if (! empty($brand['hours'])) : ?>
                <p><?php echo esc_html($brand['hours']); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="container site-footer__bottom">
        <p>&copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html($brand['name']); ?>. <?php esc_html_e('Made in house by', 'fenster'); ?> <a href="<?php echo esc_url(home_url('/meet-the-team/#zac-bartley')); ?>"><?php esc_html_e('Zac', 'fenster'); ?></a>.</p>
        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'fenster'); ?></a>
        <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>"><?php esc_html_e('Cookie Policy', 'fenster'); ?></a>
        <button type="button" class="site-footer__stat-settings" data-fg-statistics-optout><?php esc_html_e('Opt out of anonymous statistics', 'fenster'); ?></button>
        <button type="button" class="site-footer__cookie-settings" data-fg-cookie-settings hidden><?php esc_html_e('Cookie settings', 'fenster'); ?></button>
        <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><?php esc_html_e('Terms & Conditions', 'fenster'); ?></a>
    </div>
</footer>
