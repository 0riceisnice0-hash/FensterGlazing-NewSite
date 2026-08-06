<?php
/**
 * Flush against standard, on one handle.
 *
 * Two matched studio photographs in one box, with a handle you drag across so
 * the shadow line around the sash appears and disappears.
 *
 * A note on what this is and is not, because it has been rebuilt twice. It is
 * NOT the same window photographed twice, and the copy must not say it is: the
 * two frames are different windows from the same studio set, one shot at a
 * corner and one at a four-way junction. An attempt to make it literally one
 * window, by generating both halves from a shared drawing, was rejected — the
 * drawing was worse than the photographs, and the photographs were always the
 * point. So the copy describes what a reader can actually verify: same studio,
 * same light, same white background, one difference that matters.
 *
 * It is also deliberately NOT the top of the page. The product's selling point
 * is the flat sash face, not "compare it with the other one", so this belongs
 * beside the comparison table late on, where somebody is choosing between two
 * things, rather than in the opening where it would frame the whole product as a
 * variant of something else.
 *
 * Built to survive its own failure. `--fg-wipe` keeps a CSS default of 50%, so
 * with no JavaScript the box is a straight half-and-half comparison that still
 * makes the point. Flush is the layer underneath and always fills the stage: on
 * the flush page, the untouched state should be the thing being sold.
 *
 * Accessibility: the control is a real `<input type="range">` rather than a div
 * with pointer handlers, so it is keyboard operable, announces a value and
 * inherits the platform's touch behaviour.
 *
 * Args:
 *   flush_src / flush_alt        Flush photograph. Required.
 *   standard_src / standard_alt  Standard casement photograph. Required.
 *   eyebrow / heading / copy     Section furniture.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$flush_src = (string) ($args['flush_src'] ?? '');
$standard_src = (string) ($args['standard_src'] ?? '');

if ($flush_src === '' || $standard_src === '') {
    return;
}

$flush_alt = (string) ($args['flush_alt'] ?? 'Flush casement window, the sash closing level with the outer frame');
$standard_alt = (string) ($args['standard_alt'] ?? 'Standard casement window, the sash standing proud of the outer frame');
$eyebrow = (string) ($args['eyebrow'] ?? 'Side by side');
$heading = (string) ($args['heading'] ?? 'Drag it, and watch the step disappear.');
$copy = (string) ($args['copy'] ?? '');
$uid = 'fg-wipe-' . wp_unique_id();
?>

<figure class="fg-wipe__stage" data-fg-wipe>
    <?php /* Flush underneath, filling the box: the resting state is the product
             this page sells. */ ?>
    <img class="fg-wipe__img fg-wipe__img--flush"
        src="<?php echo esc_url(fenster_generated_url($flush_src)); ?>"
        alt="<?php echo esc_attr($flush_alt); ?>" loading="lazy" decoding="async">

    <?php /* Standard on top, revealed from the left by a clip that follows the
             slider. `alt` is empty because the flush image below already carries
             a description and the tags name both sides; two near-identical
             descriptions of the same subject help nobody. */ ?>
    <span class="fg-wipe__layer" aria-hidden="true">
        <img class="fg-wipe__img fg-wipe__img--standard"
            src="<?php echo esc_url(fenster_generated_url($standard_src)); ?>"
            alt="" loading="lazy" decoding="async">
    </span>

    <span class="fg-wipe__seam" aria-hidden="true"></span>
    <span class="fg-wipe__tag fg-wipe__tag--standard" aria-hidden="true"><?php esc_html_e('Standard', 'fenster'); ?></span>
    <span class="fg-wipe__tag fg-wipe__tag--flush" aria-hidden="true"><?php esc_html_e('Flush', 'fenster'); ?></span>

    <label class="fg-cas-sr" for="<?php echo esc_attr($uid); ?>"><?php esc_html_e('Reveal the standard casement over the flush one', 'fenster'); ?></label>
    <input class="fg-wipe__range" id="<?php echo esc_attr($uid); ?>" type="range"
        min="0" max="100" value="50" step="1" data-fg-wipe-range>
</figure>
