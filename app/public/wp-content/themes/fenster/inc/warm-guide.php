<?php
/**
 * The winter guide, `/stop-window-draughts/`, and the seasonal banner that links to it.
 *
 * Self-contained: this file, `inc/warm-guide-data.php`, the template part
 * `template-parts/sections/warm-windows.php`, `src/warm/` and `assets/warm/`.
 * The route itself is registered in `inc/generated-pages.php` next to
 * `/why-distinction/`, the same way every other virtual page is.
 *
 * HOST GATED, AND LIVE IS DELIBERATELY NOT ON THE LIST. Built on test on
 * 16/11/2026 for the owner to review. Until `fenster_warm_guide_enabled()`
 * names the live hosts, a theme deploy cannot publish the page, the banner or
 * the sitemap entry. Putting it live is one edit to that list, and per `AI.md`
 * the commit that makes it must say so.
 *
 * NOTHING HERE IS PER-VISITOR. Live pages are proxy-cached and served to
 * everybody, so the banner is decided only from the date and the route, which
 * are the same for every visitor. Whether somebody has dismissed it lives in
 * their own browser (`localStorage`) and is applied by a tiny script in
 * `<head>` before the first paint, so a dismissed banner never flashes and
 * never moves the page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once FENSTER_THEME_DIR . '/inc/warm-guide-data.php';

function fenster_warm_guide_slug(): string
{
    return 'stop-window-draughts';
}

function fenster_warm_guide_url(): string
{
    return home_url('/' . fenster_warm_guide_slug() . '/');
}

/**
 * Blog posts on the same subject. Each gains a link up to the guide, which is
 * their hub (see `fenster_blog_post()`), and the guide links down to each one
 * that has been published.
 */
function fenster_warm_guide_related_posts(): array
{
    return [
        'draughty-windows-repair-or-replace',
        'sash-windows-in-winter',
        'which-rooms-lose-the-most-heat',
        'is-secondary-glazing-worth-it',
        'stop-morning-condensation-inside-windows',
        'winter-ready-window-and-door-checklist',
        'cold-snap-quick-fixes',
        'how-much-heat-do-old-windows-lose',
        'wet-window-sills-every-morning',
    ];
}

/**
 * Whether the guide and its banner exist on this host at all.
 */
function fenster_warm_guide_enabled(): bool
{
    $host = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));

    if ($host === '') {
        return false;
    }

    return (bool) apply_filters('fenster_warm_guide_enabled', in_array($host, [
        'fenster-glazing.local',     // the working local site
        'test.fensterglazing.com',   // the password-protected test site
        'localhost',
        '127.0.0.1',
        // Live, when the owner approves the page. Uncomment both together.
        // 'fensterglazing.com',
        // 'www.fensterglazing.com',
    ], true));
}

/**
 * The banner runs from 1 November to 31 March, UK time.
 *
 * `?warm_banner=1` forces it on a host where the guide is enabled, so it can
 * be reviewed out of season. It cannot switch the banner on anywhere the gate
 * above has not already allowed, and the test site is not proxy-cached, so the
 * forced copy is never the one a cache keeps.
 */
function fenster_warm_banner_in_season(?string $today = null): bool
{
    $today = $today ?? wp_date('m-d');

    return $today >= '11-01' || $today <= '03-31';
}

/**
 * Routes that never carry the banner.
 *
 * The homepage is out while its A/B test runs: a banner added part-way through
 * changes both arms' baseline and pulls people off the quote path the test is
 * measuring. The rest are pages where the visitor is already doing the thing
 * we would want them to do next.
 */
function fenster_warm_banner_excluded_slugs(): array
{
    return [
        'home',
        fenster_warm_guide_slug(),
        'online-quote',
        'book-a-consultation',
        'contact',
        'customer-portal',
        '3d-visualiser',
    ];
}

function fenster_warm_banner_should_render(): bool
{
    static $decision = null;

    if ($decision !== null) {
        return $decision;
    }

    if (! fenster_warm_guide_enabled() || is_admin() || is_404()) {
        return $decision = false;
    }

    $forced = isset($_GET['warm_banner']) && $_GET['warm_banner'] === '1'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if (! $forced && ! fenster_warm_banner_in_season()) {
        return $decision = false;
    }

    if (is_front_page()) {
        return $decision = false;
    }

    $slug = function_exists('fenster_current_generated_slug') ? fenster_current_generated_slug() : '';
    $first_segment = strtok($slug, '/');

    return $decision = ! in_array($first_segment === false ? $slug : $first_segment, fenster_warm_banner_excluded_slugs(), true);
}

/**
 * Hide a dismissed banner before the first paint.
 *
 * Runs in every visitor's own browser against their own storage, so the cached
 * HTML stays identical for everyone. Dismissal lasts 30 days.
 */
add_action('wp_head', 'fenster_warm_banner_head', 1);
function fenster_warm_banner_head(): void
{
    if (! fenster_warm_banner_should_render()) {
        return;
    }
    ?>
    <script data-clarity-unmask="true">(function(){try{var t=Number(window.localStorage.getItem('fenster_warm_banner_closed')||0);if(t&&Date.now()-t<2592e6){document.documentElement.classList.add('fg-warm-banner-off');}}catch(e){}})();</script>
    <style id="fenster-warm-banner-css" data-clarity-unmask="true">
        .fg-warm-banner{position:relative;z-index:40;display:flex;align-items:center;justify-content:center;min-height:44px;padding:0 3.25rem 0 1rem;background:#002d3a;color:#fff;font-size:.95rem;line-height:1.3}
        .fg-warm-banner__link{display:inline-flex;align-items:center;gap:.6rem;min-height:44px;padding:.45rem 0;color:#fff;text-decoration:none;font-weight:600}
        .fg-warm-banner__flake{flex:none;width:18px;height:18px;color:#8fd9ae}
        .fg-warm-banner__more{display:inline-flex;align-items:center;gap:.3rem;color:#8fd9ae;white-space:nowrap}
        .fg-warm-banner__more svg{width:14px;height:14px;transition:transform .2s ease}
        .fg-warm-banner__link:hover .fg-warm-banner__more svg,.fg-warm-banner__link:focus-visible .fg-warm-banner__more svg{transform:translateX(3px)}
        .fg-warm-banner__link:focus-visible,.fg-warm-banner__close:focus-visible{outline:2px solid #8fd9ae;outline-offset:2px;border-radius:3px}
        .fg-warm-banner__close{position:absolute;top:50%;right:.35rem;display:grid;place-items:center;width:44px;height:44px;margin:0;padding:0;border:0;background:none;color:rgba(255,255,255,.78);cursor:pointer;transform:translateY(-50%)}
        .fg-warm-banner__close:hover{color:#fff}
        .fg-warm-banner__close svg{width:14px;height:14px}
        .fg-warm-banner-off .fg-warm-banner{display:none}
        @media(max-width:860px){
            <?php /* The phone header is fixed, so the banner drops below it and the page gives up the top padding it kept for the header. */ ?>
            .fg-warm-banner{margin-top:var(--site-header-main-height,76px);justify-content:flex-start;font-size:.9rem}
            html:not(.fg-warm-banner-off) .fg-warm-banner~.site-main{padding-top:0}
            .fg-warm-banner__short{display:none}
        }
        @media(prefers-reduced-motion:reduce){.fg-warm-banner__more svg{transition:none}}
    </style>
    <?php
}

/**
 * The banner itself. Called from `header.php`, before the site header.
 *
 * `data-fg-cta` puts the click through the site's own `cta_click` tracking in
 * `main.js`, with the label and the destination, and nothing else is needed
 * to measure it.
 */
function fenster_render_warm_banner(): void
{
    if (! fenster_warm_banner_should_render()) {
        return;
    }
    ?>
    <aside class="fg-warm-banner" data-fg-warm-banner aria-label="<?php esc_attr_e('Winter guide', 'fenster'); ?>">
        <a class="fg-warm-banner__link" href="<?php echo esc_url(fenster_warm_guide_url()); ?>" data-fg-cta>
            <svg class="fg-warm-banner__flake" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M12 2v20M3.3 7l17.4 10M20.7 7 3.3 17M12 6l-2.2-2.2M12 6l2.2-2.2M12 18l-2.2 2.2M12 18l2.2 2.2M6.8 9 3.8 9.8M6.8 9 6 6M17.2 15l3 .8M17.2 15l.8 3M17.2 9l.8-3M17.2 9l3 .8M6.8 15 6 18M6.8 15l-3-.8"/></svg>
            <span><?php esc_html_e('Struggling to keep warm?', 'fenster'); ?> <span class="fg-warm-banner__short"><?php esc_html_e('See how to stop the heat escaping through your windows.', 'fenster'); ?></span></span>
            <span class="fg-warm-banner__more"><?php esc_html_e('Read the guide', 'fenster'); ?><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span>
        </a>
        <button class="fg-warm-banner__close" type="button" data-fg-warm-banner-close aria-label="<?php esc_attr_e('Hide this message', 'fenster'); ?>">
            <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M2 2l10 10M12 2 2 12"/></svg>
        </button>
    </aside>
    <script data-clarity-unmask="true">(function(){var b=document.querySelector('[data-fg-warm-banner-close]');if(!b){return;}b.addEventListener('click',function(){document.documentElement.classList.add('fg-warm-banner-off');try{window.localStorage.setItem('fenster_warm_banner_closed',String(Date.now()));}catch(e){}});})();</script>
    <?php
}

/**
 * The guide's own stylesheet and script, on the guide only.
 *
 * Kept out of `main.css` and `main.js` on purpose: both are loaded by every
 * page on the site, and nothing here is used anywhere else.
 */
add_action('wp_enqueue_scripts', 'fenster_warm_enqueue_assets', 20);
function fenster_warm_enqueue_assets(): void
{
    if (! fenster_warm_guide_enabled()) {
        return;
    }

    $slug = function_exists('fenster_current_generated_slug') ? fenster_current_generated_slug() : '';
    if ($slug !== fenster_warm_guide_slug()) {
        return;
    }

    /* The guide is an article in the blog's layout, so it needs the blog's
       stylesheet in <head>, ahead of its own small one. */
    $deps = ['fenster-main'];
    $blog_css = FENSTER_THEME_DIR . '/assets/blog/blog.css';
    if (is_file($blog_css)) {
        if (! wp_style_is('fenster-blog', 'enqueued')) {
            wp_enqueue_style('fenster-blog', FENSTER_THEME_URI . '/assets/blog/blog.css', ['fenster-main'], filemtime($blog_css) . '-' . filesize($blog_css));
        }
        $deps[] = 'fenster-blog';
    }

    $css = FENSTER_THEME_DIR . '/assets/warm/warm.css';
    if (is_file($css)) {
        wp_enqueue_style('fenster-warm', FENSTER_THEME_URI . '/assets/warm/warm.css', $deps, filemtime($css) . '-' . filesize($css));
    }

    $js = FENSTER_THEME_DIR . '/assets/warm/warm.js';
    if (is_file($js)) {
        wp_enqueue_script('fenster-warm', FENSTER_THEME_URI . '/assets/warm/warm.js', [], filemtime($js) . '-' . filesize($js), ['in_footer' => true, 'strategy' => 'defer']);
    }
}
