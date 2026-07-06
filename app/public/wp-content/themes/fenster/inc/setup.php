<?php
/**
 * Theme setup.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', 'fenster_setup');
function fenster_setup(): void
{
    load_theme_textdomain('fenster', FENSTER_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height' => 80,
        'width' => 260,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'fenster'),
        'footer' => __('Footer Menu', 'fenster'),
    ]);
}

add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

add_action('wp_head', 'fenster_render_favicons', 2);
function fenster_render_favicons(): void
{
    $brand_uri = FENSTER_THEME_URI . '/assets/brand';

    printf(
        '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n",
        esc_url($brand_uri . '/favicon-32.png')
    );
    printf(
        '<link rel="icon" type="image/png" sizes="512x512" href="%s">' . "\n",
        esc_url($brand_uri . '/favicon-512.png')
    );
    printf(
        '<link rel="apple-touch-icon" sizes="180x180" href="%s">' . "\n",
        esc_url($brand_uri . '/apple-touch-icon.png')
    );
}
