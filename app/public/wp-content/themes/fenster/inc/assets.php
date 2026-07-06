<?php
/**
 * Asset loading.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', 'fenster_enqueue_assets');
function fenster_enqueue_assets(): void
{
    $css_path = FENSTER_THEME_DIR . '/assets/css/main.css';
    $js_path = FENSTER_THEME_DIR . '/assets/js/main.js';
    $css_version = file_exists($css_path) ? (string) filemtime($css_path) : FENSTER_THEME_VERSION;
    $js_version = file_exists($js_path) ? (string) filemtime($js_path) : FENSTER_THEME_VERSION;

    wp_enqueue_style(
        'fenster-main',
        FENSTER_THEME_URI . '/assets/css/main.css',
        [],
        $css_version
    );

    wp_enqueue_script(
        'fenster-main',
        FENSTER_THEME_URI . '/assets/js/main.js',
        [],
        $js_version,
        true
    );
}

function fenster_product_scroll_videos(): array
{
    return [
        'aluminium-bifold-doors' => [
            ['file' => 'bifold-video.webm', 'type' => 'video/webm'],
            ['file' => 'bifold-video.mp4', 'type' => 'video/mp4'],
        ],
        'heritage-aluminium-doors' => [
            ['file' => 'heritage.webm', 'type' => 'video/webm'],
            ['file' => 'heritage.mp4', 'type' => 'video/mp4'],
        ],
        'aluminium-doors' => [
            ['file' => 'classic-door-turntable.webm', 'type' => 'video/webm'],
            ['file' => 'classic-door-turntable.mp4', 'type' => 'video/mp4'],
        ],
    ];
}

function fenster_product_scroll_video_url(string $file): string
{
    if ($file === '') {
        return '';
    }

    $relative_path = '/assets/videos/product-scroll/' . $file;
    $absolute_path = FENSTER_THEME_DIR . $relative_path;
    $video_url = FENSTER_THEME_URI . $relative_path;

    if (file_exists($absolute_path)) {
        $video_url = add_query_arg('ver', (string) filemtime($absolute_path), $video_url);
    }

    return $video_url;
}

function fenster_integral_blinds_reveal_url(): string
{
    return fenster_product_scroll_video_url('integral-blinds-chroma.mp4');
}

function fenster_product_scroll_video_sources_for_slug(string $slug): array
{
    $videos = fenster_product_scroll_videos();
    $sources = $videos[$slug] ?? [];

    return array_values(array_filter(array_map(
        static function (array $source): array {
            $file = (string) ($source['file'] ?? '');
            $url = fenster_product_scroll_video_url($file);

            if ($url === '') {
                return [];
            }

            return [
                'src' => $url,
                'type' => (string) ($source['type'] ?? 'video/mp4'),
            ];
        },
        is_array($sources) ? $sources : []
    )));
}

function fenster_product_scroll_video_for_slug(string $slug): string
{
    $sources = fenster_product_scroll_video_sources_for_slug($slug);

    return (string) ($sources[0]['src'] ?? '');
}

function fenster_aluminium_windows_story_asset_url(string $file): string
{
    if ($file === '') {
        return '';
    }

    $relative_path = '/assets/videos/aluminium-windows-story/' . $file;
    $absolute_path = FENSTER_THEME_DIR . $relative_path;
    $asset_url = FENSTER_THEME_URI . $relative_path;

    if (file_exists($absolute_path)) {
        $asset_url = add_query_arg('ver', (string) filemtime($absolute_path), $asset_url);
    }

    return $asset_url;
}

add_action('wp_head', 'fenster_preload_product_scroll_video', 1);
function fenster_preload_product_scroll_video(): void
{
    $page = get_query_var('fenster_generated_page');

    if (! is_array($page)) {
        return;
    }

    $slug = (string) ($page['slug'] ?? '');

    if ($slug === 'integral-blinds') {
        return;
    }

    if ($slug === 'aluminium-windows') {
        printf(
            '<link rel="preload" href="%s" as="image" type="image/webp" fetchpriority="high">' . "\n",
            esc_url(fenster_aluminium_windows_story_asset_url('frames-desktop/frame-001.webp'))
        );
        return;
    }

    $sources = fenster_product_scroll_video_sources_for_slug($slug);
    $video = (string) ($sources[0]['src'] ?? '');
    $type = (string) ($sources[0]['type'] ?? 'video/mp4');

    if ($video === '') {
        return;
    }

    return;
}
