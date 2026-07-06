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

add_filter('style_loader_tag', 'fenster_defer_main_stylesheet', 10, 4);
function fenster_defer_main_stylesheet(string $html, string $handle, string $href, string $media): string
{
    if ($handle !== 'fenster-main' || is_admin()) {
        return $html;
    }

    $media_attr = $media !== '' && $media !== 'all' ? ' media="' . esc_attr($media) . '"' : '';
    $href_attr = esc_url($href);

    return sprintf(
        '<link rel="preload" href="%1$s" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"%2$s>' . "\n" .
        '<noscript><link rel="stylesheet" href="%1$s"%2$s></noscript>' . "\n",
        $href_attr,
        $media_attr
    );
}

add_action('wp_head', 'fenster_render_critical_head_assets', 0);
function fenster_render_critical_head_assets(): void
{
    $font_version = (string) filemtime(FENSTER_THEME_DIR . '/assets/fonts/Gibson-Regular.woff2');

    printf(
        '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
        esc_url(FENSTER_THEME_URI . '/assets/fonts/Gibson-Regular.woff2?ver=' . $font_version)
    );
    printf(
        '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
        esc_url(FENSTER_THEME_URI . '/assets/fonts/Gibson-SemiBold.woff2?ver=' . (string) filemtime(FENSTER_THEME_DIR . '/assets/fonts/Gibson-SemiBold.woff2'))
    );

    if (is_front_page() || is_home()) {
        $hero_poster = FENSTER_THEME_URI . '/assets/images/imported/home-hero-poster.jpg';
        printf(
            '<link rel="preload" href="%s" as="image" type="image/jpeg" fetchpriority="high">' . "\n",
            esc_url($hero_poster)
        );
    }

    ?>
    <style id="fenster-critical-css">
        @font-face{font-family:"Gibson";src:url("<?php echo esc_url(FENSTER_THEME_URI . '/assets/fonts/Gibson-Regular.woff2?ver=' . $font_version); ?>") format("woff2");font-weight:400;font-style:normal;font-display:swap}
        :root{--color-ink:#06212a;--color-accent:#2eac66;--color-steel:#002d3a;--container:1180px;--site-header-main-height:72px}
        *{box-sizing:border-box}html{scroll-padding-top:88px}body{margin:0;color:var(--color-ink);font-family:"Gibson",Arial,Helvetica,sans-serif;line-height:1.6;background:#eef5f4}a{color:inherit}.container{width:min(100% - 2rem,var(--container));margin-inline:auto}.site-header{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.94);backdrop-filter:blur(18px);border-bottom:1px solid rgba(6,33,42,.08)}.site-header__inner{min-height:72px;display:flex;align-items:center;justify-content:space-between;gap:1rem}.site-brand__logo{display:block;width:clamp(132px,14vw,188px);height:auto}.site-nav-toggle,.button{min-height:44px}.button{display:inline-flex;align-items:center;justify-content:center;border-radius:999px;padding:.85rem 1.15rem;background:var(--color-accent);color:#fff;text-decoration:none;font-weight:700}.button--light{background:#fff;color:var(--color-steel)}.fg-home-hero{position:relative;min-height:clamp(600px,78svh,760px);display:flex;align-items:center;overflow:hidden;background:#0c3038}.fg-home-hero__video,.fg-home-hero__shade{position:absolute;inset:0;width:100%;height:100%}.fg-home-hero__video{object-fit:cover}.fg-home-hero__shade{background:linear-gradient(90deg,rgba(0,45,58,.78),rgba(0,45,58,.3) 54%,rgba(0,45,58,.08))}.fg-home-hero__inner{position:relative;z-index:1}.fg-home-hero__copy{max-width:720px;color:#fff}.fg-home-hero__copy h1{margin:.25rem 0 1rem;font-size:clamp(2.4rem,5vw,5.4rem);line-height:.95}.fg-home-hero__copy p{font-size:clamp(1rem,1.5vw,1.25rem)}.button-row{display:flex;flex-wrap:wrap;gap:.8rem}.fg-home-proof-wall{padding:clamp(1.25rem,3vw,2.5rem) 0}@media(max-width:860px){.site-header{position:fixed;left:0;right:0}.fg-home-hero{min-height:0;padding:calc(72px + 4.75rem) 0 4rem}.fg-home-hero__copy h1{font-size:clamp(2.2rem,10vw,3.35rem)}.button-row .button{width:100%}}
    </style>
    <?php
}

function fenster_theme_asset_path_from_url(string $url): string
{
    if ($url === '') {
        return '';
    }

    $resolved_url = function_exists('fenster_generated_url') ? fenster_generated_url($url) : $url;
    $parsed = wp_parse_url($resolved_url);
    $path = (string) ($parsed['path'] ?? $resolved_url);
    $theme_uri_path = (string) (wp_parse_url(FENSTER_THEME_URI, PHP_URL_PATH) ?? '');
    $relative = '';

    if ($theme_uri_path !== '' && str_starts_with($path, $theme_uri_path . '/')) {
        $relative = substr($path, strlen($theme_uri_path));
    } elseif (str_starts_with($path, '/wp-content/themes/fenster/')) {
        $relative = substr($path, strlen('/wp-content/themes/fenster'));
    } elseif (str_starts_with($path, '/app/themes/fenster/')) {
        $relative = substr($path, strlen('/app/themes/fenster'));
    }

    if ($relative === '') {
        return '';
    }

    return FENSTER_THEME_DIR . '/' . ltrim($relative, '/');
}

function fenster_image_dimensions(string $url): array
{
    static $cache = [];

    if ($url === '') {
        return [];
    }

    $key = function_exists('fenster_generated_url') ? fenster_generated_url($url) : $url;

    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $path = fenster_theme_asset_path_from_url($url);

    if ($path === '' || ! file_exists($path)) {
        return $cache[$key] = [];
    }

    $size = getimagesize($path);

    if (! is_array($size) || empty($size[0]) || empty($size[1])) {
        return $cache[$key] = [];
    }

    return $cache[$key] = [
        'width' => (int) $size[0],
        'height' => (int) $size[1],
    ];
}

function fenster_image_attr_string(string $url, array $attrs = []): string
{
    $src = function_exists('fenster_generated_url') ? fenster_generated_url($url) : $url;
    $attrs = array_merge(['src' => $src, 'decoding' => 'async'], $attrs);
    $dimensions = fenster_image_dimensions($url);

    foreach (['width', 'height'] as $dimension_key) {
        if (! isset($attrs[$dimension_key]) && isset($dimensions[$dimension_key])) {
            $attrs[$dimension_key] = (string) $dimensions[$dimension_key];
        }
    }

    $output = [];

    foreach ($attrs as $name => $value) {
        if ($value === null || $value === false) {
            continue;
        }

        $output[] = esc_attr((string) $name) . '="' . esc_attr((string) $value) . '"';
    }

    return implode(' ', $output);
}

function fenster_product_scroll_videos(): array
{
    return [
        'aluminium-bifold-doors' => [
            ['file' => 'bifold-video.webm', 'type' => 'video/webm'],
            ['file' => 'bifold-video.mp4', 'type' => 'video/mp4'],
        ],
        'heritage-aluminium-doors' => [
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
