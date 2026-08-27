<?php
/**
 * The immersive stage: a gallery you walk through, one route per group.
 *
 * This is the same engine as `/fenster-new-home-page/` — the architectural
 * gallery, the products installed in splayed walls, the specification drawn on
 * hairline leaders, the stepped camera, the WindowCAD terminal at the end. What
 * changed is that it is laid out from a station list rather than hard-coded, so
 * the windows and the doors each get their own walk.
 *
 * WHAT MAKES THIS ONE FAST. The audit of the original measured 12.3 MB, 2,223
 * draw calls and 17-19fps. Nothing about the experience caused that; the models
 * did. These routes load the reprocessed set — 408 KB for windows, 679 KB for
 * doors, against 9,205 KB — and the material merge took the draw calls with it.
 * The experience is the same. The bill is not.
 *
 * It sits ABOVE the page's own content rather than replacing it: the stage
 * hands the document back when the sequence ends, and everything a crawler and
 * a customer need is in the markup underneath either way.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], ['group' => 'windows']);
$group = $args['group'] === 'doors' ? 'doors' : 'windows';

$asset_base = FENSTER_THEME_URI . '/assets/showroom';
$mark_base  = FENSTER_THEME_URI . '/assets/experimental';
$quote_url  = fenster_data('brand.quote_url', home_url('/online-quote/'));

/* The claims, shared with the experiment through fenster_scene_labels() so the
   two cannot drift, then cut to the products this route actually shows. A
   window route carrying door specifications would be dead weight in the
   attribute and a lie waiting to happen. */
$all_labels = fenster_scene_labels();
$route_ids = [];
foreach (fenster_showroom_model_map($group) as $slug => $m) {
    $route_ids[$m['id']] = true;
}
$scene_labels = ['counts' => $all_labels['counts'] ?? [], 'steps' => $all_labels['steps'] ?? []];
foreach ($all_labels as $key => $val) {
    if (isset($route_ids[$key])) {
        $scene_labels[$key] = $val;
    }
}

$mark_svg = '';
$mark_file = get_theme_file_path('assets/experimental/fenster-mark.svg');
if (is_readable($mark_file)) {
    $mark_svg = (string) file_get_contents($mark_file);
}

/* The rail's ticks name this route's own beats rather than the catalogue's,
   and there is ONE PER STOP. The doors route has six — the mark, three
   stations, the bifold screen between the first two, and the terminal — and it
   was carrying five, so every label from the screen onward named the wrong
   beat. */
$ticks = $group === 'doors'
    ? ['Fenster', 'Front doors', 'Bifold', 'Aluminium & folding', 'Sliding', 'Pricing']
    : ['Fenster', 'Casement & sash', 'Aluminium & flush', 'Pricing'];
?>

<div class="fx fx--showroom"
     data-fx-atrium
     data-fx-group="<?php echo esc_attr($group); ?>"
     data-fx-models="<?php echo esc_url($asset_base . '/models'); ?>"
     data-fx-manifest="<?php echo esc_attr('manifest-' . $group . '.json'); ?>"
     data-fx-shadows="0"
     data-fx-mirror="0"
     data-fx-transmission="0"
     data-fx-mark="<?php echo esc_url($mark_base . '/fenster-mark.svg'); ?>"
     data-fx-quote="<?php echo esc_url($quote_url); ?>"
     data-fx-labels="<?php echo esc_attr(wp_json_encode($scene_labels)); ?>">

    <div class="fx__loader" data-fx-loader>
        <div class="fx__loader-inner">
            <div class="fx__loader-mark" aria-hidden="true"><?php echo $mark_svg; // phpcs:ignore ?></div>
            <div class="fx__loader-bar"><span data-fx-loader-bar></span></div>
            <div class="fx__loader-meta">
                <span class="fx__loader-note" data-fx-loader-note><?php esc_html_e('Preparing the showroom', 'fenster'); ?></span>
                <span><b data-fx-loader-pct>0</b>%</span>
            </div>
        </div>
    </div>

    <div class="fx__stage" data-fx-stage>
        <canvas class="fx__canvas" data-fx-canvas aria-hidden="true"></canvas>
        <div class="fx__css-layer" data-fx-css-layer></div>
    </div>

    <div class="fx__ui">
        <div class="fx__top">
            <span class="fx__coords">
                <?php
                printf(
                    esc_html__('Real WindowCAD geometry &middot; %1$s %2$s, in 3D &middot; Milton Keynes', 'fenster'),
                    esc_html((string) count(fenster_showroom_model_map($group))),
                    esc_html($group === 'doors' ? 'doors' : 'windows')
                );
                ?>
            </span>
        </div>

        <?php /* THESE WORK AT EVERY POINT IN THE SEQUENCE. The original faded
                 them to 32% and made them unclickable at six of its seven
                 stops — measured by hit-testing, which is the only way to find
                 that, because a correct bounding box tells you nothing about
                 whether a control can be pressed. */ ?>
        <div class="fx__actions" data-fx-actions>
            <a class="fx__btn" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
            <a class="fx__btn fx__btn--ghost" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
        </div>

        <div class="fx__cue" data-fx-cue aria-hidden="true">
            <span class="fx__cue-line"></span>
            <span><?php esc_html_e('Scroll', 'fenster'); ?></span>
        </div>
    </div>

    <nav class="fx__rail" aria-label="<?php esc_attr_e('Showroom progress', 'fenster'); ?>">
        <span class="fx__rail-track"><b data-fx-rail-fill></b></span>
        <?php foreach ($ticks as $tick) : ?>
            <span class="fx__tick" data-fx-tick><b><?php echo esc_html($tick); ?></b></span>
        <?php endforeach; ?>
    </nav>

    <div class="fx__scroller" data-fx-scroller aria-hidden="true"></div>
</div>
