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
