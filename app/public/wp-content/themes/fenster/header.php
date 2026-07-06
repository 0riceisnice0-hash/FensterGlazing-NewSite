<?php
/**
 * Header template.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<?php if (get_query_var('fenster_generated_page')) : ?>
<body class="fenster-generated-route">
<?php else : ?>
<body <?php body_class(); ?>>
<?php endif; ?>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'fenster'); ?></a>
<?php get_template_part('template-parts/layout/site-header'); ?>
<main id="main-content" class="site-main">
