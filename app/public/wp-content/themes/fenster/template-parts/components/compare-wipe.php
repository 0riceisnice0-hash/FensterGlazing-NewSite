<?php
/**
 * Two photographs in one box, with a handle you drag across.
 *
 * Was `flush-sash-wipe.php`, which did exactly this job for one page and named
 * itself after it. Generalised on 2026-08-10 when `/double-glazing-replacement/`
 * needed the same control for a misted unit against a replaced one. The markup,
 * the CSS block and the JavaScript were already generic — only the argument
 * names, the two tag labels and the hardcoded stage ratio were not.
 *
 * The base layer is underneath and always fills the stage; the overlay sits on
 * top and is revealed from the left by a clip that follows the slider. So the
 * resting state should be the thing the page is selling, and the overlay should
 * be what the reader is being moved away from. On the flush page that is flush
 * underneath and standard on top; on replacement glazing it is the clear unit
 * underneath and the misted one on top, which also happens to read left to
 * right as before and after.
 *
 * Built to survive its own failure. `--fg-wipe` keeps a CSS default of 50%, so
 * with no JavaScript the box is a straight half-and-half comparison that still
 * makes the point.
 *
 * Accessibility: the control is a real `<input type="range">` rather than a div
 * with pointer handlers, so it is keyboard operable, announces a value and
 * inherits the platform's touch behaviour. The overlay image carries an empty
 * `alt` on purpose — the base image below describes the subject and the two
 * tags name both sides, so a second near-identical description helps nobody.
 *
 * Args:
 *   base_src / base_alt        Underneath, always visible. Required.
 *   overlay_src                On top, revealed from the left. Required. It
 *                              takes no alt: the layer is `aria-hidden`, for
 *                              the reason in the accessibility note above.
 *   base_tag / overlay_tag     The two corner labels.
 *   ratio                      Stage aspect, as a CSS `aspect-ratio` value.
 *                              Defaults to the flush studio pair's 820 / 857.
 *   sr_label                   Label for the range, read by screen readers.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$base_src = (string) ($args['base_src'] ?? '');
$overlay_src = (string) ($args['overlay_src'] ?? '');

if ($base_src === '' || $overlay_src === '') {
    return;
}

$base_alt = (string) ($args['base_alt'] ?? '');
$base_tag = (string) ($args['base_tag'] ?? __('Flush', 'fenster'));
$overlay_tag = (string) ($args['overlay_tag'] ?? __('Standard', 'fenster'));
$ratio = (string) ($args['ratio'] ?? '820 / 857');
$sr_label = (string) ($args['sr_label'] ?? __('Reveal the second photograph over the first', 'fenster'));
$uid = 'fg-wipe-' . wp_unique_id();
?>

<figure class="fg-wipe__stage" data-fg-wipe style="<?php echo esc_attr('--fg-wipe-ratio:' . $ratio . ';'); ?>">
    <img class="fg-wipe__img fg-wipe__img--base"
        src="<?php echo esc_url(fenster_generated_url($base_src)); ?>"
        alt="<?php echo esc_attr($base_alt); ?>" loading="lazy" decoding="async">

    <span class="fg-wipe__layer" aria-hidden="true">
        <img class="fg-wipe__img fg-wipe__img--overlay"
            src="<?php echo esc_url(fenster_generated_url($overlay_src)); ?>"
            alt="" loading="lazy" decoding="async">
    </span>

    <span class="fg-wipe__seam" aria-hidden="true"></span>
    <span class="fg-wipe__tag fg-wipe__tag--overlay" aria-hidden="true"><?php echo esc_html($overlay_tag); ?></span>
    <span class="fg-wipe__tag fg-wipe__tag--base" aria-hidden="true"><?php echo esc_html($base_tag); ?></span>

    <label class="fg-cas-sr" for="<?php echo esc_attr($uid); ?>"><?php echo esc_html($sr_label); ?></label>
    <input class="fg-wipe__range" id="<?php echo esc_attr($uid); ?>" type="range"
        min="0" max="100" value="50" step="1" data-fg-wipe-range>
</figure>
