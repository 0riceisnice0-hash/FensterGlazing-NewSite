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
    $css_version = file_exists($css_path) ? filemtime($css_path) . '-' . filesize($css_path) : FENSTER_THEME_VERSION;
    $js_version = file_exists($js_path) ? filemtime($js_path) . '-' . filesize($js_path) : FENSTER_THEME_VERSION;

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

add_filter('style_loader_tag', 'fenster_unmask_stylesheet_for_clarity', 10, 4);
function fenster_unmask_stylesheet_for_clarity(string $html, string $handle, string $href, string $media): string
{
    if ($html === '' || str_contains($html, 'data-clarity-unmask=')) {
        return $html;
    }

    return str_replace('<link ', '<link data-clarity-unmask="true" ', $html);
}

add_action('wp_head', 'fenster_render_critical_head_assets', 0);
function fenster_render_critical_head_assets(): void
{
    $font_version = (string) filemtime(FENSTER_THEME_DIR . '/assets/fonts/Gibson-Regular.woff2');

    printf(
        '<link rel="preload" data-clarity-unmask="true" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
        esc_url(FENSTER_THEME_URI . '/assets/fonts/Gibson-Regular.woff2?ver=' . $font_version)
    );
    printf(
        '<link rel="preload" data-clarity-unmask="true" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
        esc_url(FENSTER_THEME_URI . '/assets/fonts/Gibson-SemiBold.woff2?ver=' . (string) filemtime(FENSTER_THEME_DIR . '/assets/fonts/Gibson-SemiBold.woff2'))
    );

    if (is_front_page() || is_home()) {
        $hero_poster = FENSTER_THEME_URI . '/assets/images/imported/home-hero-poster.jpg';
        printf(
            '<link rel="preload" data-clarity-unmask="true" href="%s" as="image" type="image/jpeg" fetchpriority="high">' . "\n",
            esc_url($hero_poster)
        );
    }

    ?>
    <style id="fenster-critical-css" data-clarity-unmask="true">
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

/**
 * The traveller: videos lifted out of the flow and flown across the page from a
 * slot beside the hero.
 *
 * **This map is empty and the traveller therefore renders nowhere.** Bifold was
 * its only route and moved to the in-place scrub below on 2026-08-02, on owner
 * instruction: the video should stay in the first box the way the heritage door
 * turntable does, rather than travelling in from the hero.
 *
 * The mechanism is left in place rather than deleted, because removing it also
 * means removing its markup in generated-page.php, its controller in main.js and
 * its styles. That is a separate change and nobody has asked for it. If it is
 * still empty next time someone reads this, it is worth deleting properly. Its
 * source assets, `bifold-video.webm` and `bifold-video.mp4`, are still on disk;
 * the webm is the alpha master the scrub encode was made from, so keep it even
 * if the traveller does go.
 */
function fenster_product_scroll_videos(): array
{
    return [];
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

/**
 * Videos that scrub in place from their own position in the viewport.
 *
 * Deliberately a separate map from fenster_product_scroll_videos(), which is
 * the bifold traveller: that one lifts the video out of the flow and flies it
 * across the page from a slot beside the hero. Anything listed there gets the
 * traveller markup rendered for it in generated-page.php, so a route wanting
 * the plain scrub has to be listed here instead or it gets both treatments.
 *
 * Every entry must be the system the route actually sells. The Prestige corner
 * belongs on aluminium windows, which is a Prestige route; it is not the
 * Classic profile and must not be used on the heritage pages.
 */
function fenster_product_scrub_videos(): array
{
    /*
     * All-intra H.264: every frame is a keyframe. A scrub seeks on almost every
     * scroll frame, and with a normal GOP each seek decodes forward from the
     * last keyframe, which is what made this feel laggy. prestige-slider had
     * one keyframe in 101 frames, so every seek was decoding from frame zero.
     * All-intra costs about five times the file size and buys a single-frame
     * decode per seek.
     *
     * The mobile source is listed first because a browser takes the first
     * source whose media matches. It is half the width and under half the
     * bytes, which matters more on a phone than the sharpness does in a 351px
     * slot.
     *
     * No WebM here on purpose: VP9 all-intra is larger and less reliably
     * hardware-decoded, and hardware decode is the whole point.
     */
    $scrub = static function (string $stem): array {
        return [
            ['file' => $stem . '-scrub-mobile.mp4', 'type' => 'video/mp4', 'media' => '(max-width: 860px)'],
            ['file' => $stem . '-scrub.mp4', 'type' => 'video/mp4'],
        ];
    };

    return [
        'aluminium-windows' => $scrub('prestige-window'),
        'aluminium-sliding-doors' => $scrub('prestige-slider'),
        'heritage-aluminium-doors' => $scrub('classic-door-turntable'),
        /* Moved off the traveller on 2026-08-02, owner instruction. Re-encoded
           from `bifold-video.webm` rather than the mp4: the webm is the alpha
           master at more than three times the bitrate, and the mp4's baked
           background is #fdfdfd where the figure is #fbfbfb, which would have
           shown as a faint square inside its own box. The flat colour is
           encoded as #fdfdfd on purpose, because yuv420p round-trips that to
           #fbfbfb and an exact match is what makes the letterboxing invisible. */
        'aluminium-bifold-doors' => $scrub('bifold'),
    ];
}

/**
 * Routes whose scrub video renders in the "why" box rather than the product
 * intel figure.
 *
 * Most routes show the scrub in the intel figure. Bifold shows it in the first
 * box after the hero, which is where its video already ended up as a traveller
 * and where the owner asked for it to stay. A route named here must be skipped
 * by the intel figure or it renders the same video twice, which is the same
 * both-treatments trap the traveller comment above warns about.
 */
function fenster_product_scrub_in_why_routes(): array
{
    return ['aluminium-bifold-doors'];
}

function fenster_product_scrub_video_sources_for_slug(string $slug): array
{
    return fenster_product_scroll_video_sources_from(fenster_product_scrub_videos()[$slug] ?? []);
}

function fenster_product_scroll_video_sources_for_slug(string $slug): array
{
    $videos = fenster_product_scroll_videos();

    return fenster_product_scroll_video_sources_from($videos[$slug] ?? []);
}

/**
 * Turn a list of {file, type} entries into renderable {src, type} sources,
 * dropping any whose file is missing from the theme.
 */
function fenster_product_scroll_video_sources_from(mixed $sources): array
{
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
                'media' => (string) ($source['media'] ?? ''),
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

/**
 * Scroll-scrubbed story frames for any route that has a sequence.
 * ---------------------------------------------------------------------------
 * Added 2026-08-15 with `/roofline/`, which is the second route to use the
 * `data-fg-aw-story` canvas. The aluminium windows helper below now defers to
 * this one rather than a third copy of the same six lines existing.
 *
 * The `ver` query is filemtime, so a regenerated sequence busts its own cache.
 * That matters more here than usual: theme images carry no version string, and
 * a frame replaced in place would otherwise keep serving the old one, which is
 * the trap recorded twice in `AI.md` under the Asset And Cache Rules.
 */
function fenster_story_asset_url(string $story, string $file): string
{
    if ($story === '' || $file === '') {
        return '';
    }

    $relative_path = '/assets/videos/' . $story . '/' . $file;
    $absolute_path = FENSTER_THEME_DIR . $relative_path;
    $asset_url = FENSTER_THEME_URI . $relative_path;

    if (file_exists($absolute_path)) {
        $asset_url = add_query_arg('ver', (string) filemtime($absolute_path), $asset_url);
    }

    return $asset_url;
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
            '<link rel="preload" data-clarity-unmask="true" href="%s" as="image" type="image/webp" fetchpriority="high">' . "\n",
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

/**
 * Curated thumbnail for an internal route, used by the shared link-cards
 * component. Keyed by route path so town/matrix variants fall back to plain
 * text links. Only material-correct imagery is mapped: a wrong-material
 * thumbnail is worse than none.
 *
 * @param string $url Internal link URL.
 * @return string Theme-relative image path, or '' when the route has no image.
 */
function fenster_link_card_image(string $url): string
{
    static $map = null;

    if ($map === null) {
        $curated = '/wp-content/themes/fenster/assets/images/products/curated/';
        $map = [
            'windows-milton-keynes' => $curated . 'home-theatre-windows.jpg',
            'doors-milton-keynes' => $curated . 'home-theatre-composite-door.jpg',
            'double-glazing-milton-keynes' => $curated . 'liniar-casement-closeup.jpg',
            'casement-windows' => $curated . 'liniar-casement-exterior.jpg',
            'flush-casement-windows' => $curated . 'liniar-flush-window.jpg',
            'sliding-sash-windows' => $curated . 'fenster-sliding-sash-window.jpg',
            'bow-bay-windows' => $curated . 'liniar-bay-window.jpg',
            'aluminium-windows' => $curated . 'sheerline-aluminium-window.jpg',
            'heritage-windows' => $curated . 'sheerline-heritage-windows.jpg',
            'composite-doors' => $curated . 'distinction-composite-door-installed.jpg',
            /* Was the golden oak slab that reads composite. The related-link
               card is a third place that image lived, after product_media
               and the gallery pool; the doc comment above says a
               wrong-material thumbnail is worse than none, and it was one. */
            'upvc-doors' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-anthracite-brick.webp',
            'aluminium-doors' => $curated . 'sheerline-aluminium-door.jpg',
            'heritage-aluminium-doors' => $curated . 'sheerline-heritage-door.jpg',
            'aluminium-bifold-doors' => $curated . 'sheerline-bifold-exterior.jpg',
            'aluminium-sliding-doors' => $curated . 'sheerline-sliding-door.jpg',
            /* Was `neutral-slide-fold-doors.jpg`, the scrape-era image the route
               ran on before the 2026-08-18 rebuild. This map is the FOURTH place
               that product's imagery lived, after `product_media`, the gallery
               pool and the hub tile, and it was found only by rendering a town
               matrix page and seeing the old picture come back. The comment on
               the uPVC doors entry above says a related-link card is a third
               place an image lives; for this product it was a fourth.

               The open stack rather than the closed run, for the same reason the
               hub card uses it: this cell is small, and stacked panels read at
               that size where a closed wall of glass does not. */
            'slide-fold-doors' => '/wp-content/themes/fenster/assets/images/products/slide-fold/sf-open-stack-1400w.webp',
            'patio-doors' => $curated . 'liniar-patio-door.jpg',
            'integral-blinds' => $curated . 'notan-integral-blinds.jpg',
            'roof-lanterns' => $curated . 'sheerline-roof-lantern.jpg',
            'flat-rooflights' => $curated . 'sheerline-roof-lantern-interior.jpg',
            'cat-and-dog-flaps' => $curated . 'fenster-cat-flap-glass.jpg',
            /* Was `fenster-double-glazed-unit.jpeg`, a stock cut-through sample.
               Wrong twice over as of 2026-08-10: it is stock on a site that
               prefers its own work, and it shows a SEALED UNIT, which the owner
               has now drawn as the line AGAINST repairs — "new unit must be
               ordered" makes that /double-glazing-replacement/, not this. A
               thumbnail that illustrates the neighbouring product is exactly the
               wrong-material case the note above warns about. Our own van. */
            'window-and-door-repairs' => '/wp-content/themes/fenster/assets/images/about/fenster-van.jpg',
            /* Added 2026-08-10. This route had no entry, so it rendered as a bare
               text link wherever it was related-linked, because until the owner
               found the archive pairs there was no honest photograph of it. A
               whole misted window rather than the leaded close-up: at card size a
               scene reads and a close-up reads as texture. */
            'double-glazing-replacement' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-view-misted-1400w.jpg',
            'roofline' => $curated . 'liniar-roofline-fascia.jpg',
        ];
    }

    $path = strtolower(trim((string) wp_parse_url($url, PHP_URL_PATH), '/'));

    return $map[$path] ?? '';
}
