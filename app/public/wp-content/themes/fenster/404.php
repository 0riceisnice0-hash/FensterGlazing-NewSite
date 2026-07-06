<?php
/**
 * 404 template.
 *
 * @package Fenster
 */

get_header();
?>
<section class="content-band">
    <div class="container prose">
        <p class="eyebrow"><?php esc_html_e('404', 'fenster'); ?></p>
        <h1><?php esc_html_e('Page not found', 'fenster'); ?></h1>
        <p><?php esc_html_e('Sorry, we could not find the page you were looking for. Use the links below or head back to the homepage.', 'fenster'); ?></p>
        <a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to home', 'fenster'); ?></a>
    </div>
</section>
<?php
get_footer();
