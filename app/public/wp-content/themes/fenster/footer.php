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
</main>
<?php get_template_part('template-parts/layout/site-footer'); ?>
<?php get_template_part('template-parts/components/legend-assistant'); ?>
<?php wp_footer(); ?>
</body>
</html>
