<?php
/**
 * Site header.
 *
 * @package Fenster
 */

$brand = fenster_data('brand', []);
?>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($brand['name']); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img class="site-brand__logo" <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/brand/18931 Fenster Glazing Logo - White Background.png', ['alt' => (string) $brand['name'], 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
            <?php endif; ?>
        </a>

        <a class="site-header__mobile-call" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'])); ?>">
            <svg class="site-header__mobile-call-icon" aria-hidden="true" viewBox="0 0 24 24" focusable="false">
                <path d="M6.62 10.79a15.46 15.46 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 11.34 11.34 0 0 0 3.56.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.34 11.34 0 0 0 .57 3.56 1 1 0 0 1-.24 1.01l-2.21 2.22Z" />
            </svg>
            <span><?php esc_html_e('Call us', 'fenster'); ?></span>
        </a>

        <button class="site-nav-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
            <span><?php esc_html_e('Menu', 'fenster'); ?></span>
        </button>

        <nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e('Primary navigation', 'fenster'); ?>">
            <?php fenster_render_nav_fallback(); ?>
        </nav>

        <a class="site-header__phone" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'])); ?>">
            <?php echo esc_html($brand['phone']); ?>
        </a>
    </div>
</header>
