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
    ['label' => 'Repairs and replacement units', 'url' => home_url('/double-glazing-replacement/')],
    ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
];
$footer_company = [
    ['label' => 'About Fenster', 'url' => home_url('/about/')],
    ['label' => 'Why Trust Fenster', 'url' => home_url('/why-trust-fenster/')],
    ['label' => 'Meet the Team', 'url' => home_url('/meet-the-team/')],
    ['label' => 'Areas We Cover', 'url' => home_url('/areas-we-cover/')],
    ['label' => 'Commercial Projects', 'url' => home_url('/commercial-projects/')],
    ['label' => 'Contact', 'url' => home_url('/contact/')],
    ['label' => 'Instant Quote', 'url' => home_url('/online-quote/')],
    ['label' => 'Book a Consultation', 'url' => home_url('/book-a-consultation/')],
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
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/imported/cropped-ssip.png'); ?>" alt="<?php esc_attr_e('SSIP accredited', 'fenster'); ?>">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/google-5-stars.png'); ?>" alt="<?php esc_attr_e('Google five star reviews', 'fenster'); ?>">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png'); ?>" alt="<?php esc_attr_e('Trustpilot Excellent reviews', 'fenster'); ?>">
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
        <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><?php esc_html_e('Terms & Conditions', 'fenster'); ?></a>
    </div>
</footer>
