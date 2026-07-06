<?php
/**
 * Site footer.
 *
 * @package Fenster
 */

$brand = fenster_data('brand', []);
$footer_products = [
    ['label' => 'Windows', 'url' => home_url('/windows-milton-keynes/')],
    ['label' => 'Doors', 'url' => home_url('/doors-milton-keynes/')],
    ['label' => 'Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/')],
    ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/')],
    ['label' => 'Replacement Glass', 'url' => home_url('/double-glazing-replacement/')],
    ['label' => 'Commercial Glazing', 'url' => home_url('/commercial-glazing/')],
];
$footer_company = [
    ['label' => 'About Fenster', 'url' => home_url('/about/')],
    ['label' => 'Why Trust Fenster', 'url' => home_url('/why-trust-fenster/')],
    ['label' => 'Areas We Cover', 'url' => home_url('/areas-we-cover/')],
    ['label' => 'Meet the Team', 'url' => home_url('/meet-the-team/')],
    ['label' => 'Case Studies', 'url' => home_url('/case-studies/')],
    ['label' => 'Commercial Projects', 'url' => home_url('/commercial-projects/')],
    ['label' => 'Contact', 'url' => home_url('/contact/')],
    ['label' => 'Instant Quote', 'url' => home_url('/online-quote/')],
];
?>
<footer class="site-footer">
    <div class="container site-footer__grid">
        <div class="site-footer__about">
            <img class="site-footer__logo" src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/brand/18931 - 2026 - Fenster Glazing Logo - Dark Background.png'); ?>" alt="<?php echo esc_attr($brand['name']); ?>">
            <p><?php echo esc_html($brand['tagline']); ?></p>
            <div class="site-footer__trust" aria-label="<?php esc_attr_e('Accreditations', 'fenster'); ?>">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/fensa.png'); ?>" alt="<?php esc_attr_e('FENSA approved', 'fenster'); ?>">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/cpa.png'); ?>" alt="<?php esc_attr_e('Consumer Protection Association', 'fenster'); ?>">
            </div>
        </div>

        <div class="site-footer__nav">
            <h2><?php esc_html_e('Products', 'fenster'); ?></h2>
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
