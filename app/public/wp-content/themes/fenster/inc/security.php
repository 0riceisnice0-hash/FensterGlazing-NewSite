<?php
/**
 * Public hardening for the launch theme.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', 'fenster_harden_public_wordpress_output');
function fenster_harden_public_wordpress_output(): void
{
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

add_filter('xmlrpc_enabled', '__return_false');

add_filter('wp_headers', 'fenster_remove_public_wordpress_headers');
function fenster_remove_public_wordpress_headers(array $headers): array
{
    unset($headers['X-Pingback']);

    return $headers;
}

add_filter('rest_pre_dispatch', 'fenster_restrict_public_user_rest_routes', 10, 3);
function fenster_restrict_public_user_rest_routes($result, WP_REST_Server $server, WP_REST_Request $request)
{
    unset($server);

    $route = $request->get_route();
    $is_public_user_route = str_starts_with($route, '/wp/v2/users')
        || (str_starts_with($route, '/wp/v2/search') && $request->get_param('type') === 'user');

    if (! is_user_logged_in() && $is_public_user_route) {
        return new WP_Error(
            'fenster_rest_forbidden',
            __('This REST endpoint is not public.', 'fenster'),
            ['status' => 401]
        );
    }

    return $result;
}
