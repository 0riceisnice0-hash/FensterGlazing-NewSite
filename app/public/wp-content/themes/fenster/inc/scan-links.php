<?php
/**
 * Short offline links for printed and vehicle marketing.
 *
 * A scan lands on a short path, which redirects to the real page with UTM
 * parameters attached. The count comes from the existing website tracker: the
 * landing script reads the UTM values out of the destination URL and files the
 * journey under that source, so scans show up in the dashboard next to every
 * other channel rather than in a counter of their own.
 *
 * Nothing is counted on the short path itself. SiteGround's proxy caches by
 * path and ignores the query string, so a hit recorded here would be missed the
 * moment the redirect was served from cache. The redirect therefore asks not to
 * be cached, and the measurement happens on the destination page, which is
 * where the tracker already runs.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * The short paths, and where each one sends a scan.
 *
 * `path` is matched without slashes and case-insensitively, so the QR can be
 * printed as /van, /van/ or /VAN. `target` is a site-relative path. `utm` is
 * appended to it; keep `utm_source` unique per printed item, because that is
 * the name the scan appears under in the dashboard.
 */
function fenster_scan_links(): array
{
    return [
        'van' => [
            'target' => '/',
            'utm' => [
                'utm_source' => 'van',
                'utm_medium' => 'offline',
                'utm_campaign' => 'van-qr',
            ],
        ],
    ];
}

add_action('template_redirect', 'fenster_maybe_redirect_scan_link', -20);
function fenster_maybe_redirect_scan_link(): void
{
    if (is_admin() || wp_doing_ajax() || is_feed()) {
        return;
    }

    $path = strtolower(trim((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/'));
    $link = fenster_scan_links()[$path] ?? null;
    if (! is_array($link)) {
        return;
    }

    $target = home_url((string) $link['target']);
    $target = add_query_arg((array) $link['utm'], $target);

    // 302, and uncached, so the destination can be changed later without a
    // printed code pointing at a redirect that browsers and proxies have kept.
    nocache_headers();
    wp_safe_redirect($target, 302);
    exit;
}
