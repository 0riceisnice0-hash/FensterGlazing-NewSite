<?php
/**
 * Footer template.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}
?>
<?php /* "From the blog": renders only on pages a published post is about. */ ?>
<?php get_template_part('template-parts/components/blog-related'); ?>
<?php /* "Where we fit": renders only on the town matrix's product pages and the Milton Keynes windows hub. */ ?>
<?php get_template_part('template-parts/components/location-town-links'); ?>
</main>
<?php get_template_part('template-parts/layout/site-footer'); ?>
<?php get_template_part('template-parts/components/legend-assistant'); ?>
<?php if (function_exists('fenster_show_price_bar') && fenster_show_price_bar()) :
    /* Phones only (CSS). See fenster_show_price_bar() for where it never shows. */
    $fg_bar_phone = (string) (fenster_data('brand', [])['phone'] ?? '01908 429200'); ?>
<nav class="fg-price-bar" aria-label="<?php esc_attr_e('Get a price', 'fenster'); ?>">
    <a class="fg-price-bar__price" href="<?php echo esc_url(fenster_price_bar_url()); ?>" data-fg-cta><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
    <a class="fg-price-bar__call" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $fg_bar_phone)); ?>" data-fg-cta aria-label="<?php echo esc_attr(sprintf(__('Call us on %s', 'fenster'), $fg_bar_phone)); ?>"><?php esc_html_e('Call', 'fenster'); ?></a>
</nav>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
