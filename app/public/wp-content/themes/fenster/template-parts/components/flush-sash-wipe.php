<?php
/**
 * Flush against standard, on one handle.
 *
 * The page's whole argument is that the sash closes level with the frame instead
 * of standing proud of it. A table can state that; it cannot show it. This puts
 * the two studio photographs in the same box, one over the other, and lets you
 * drag the join across so the step appears and disappears under your thumb.
 *
 * The two frames are the pair already used on the casement page's comparison, so
 * they are the same window, the same size and the same light — which is the only
 * reason a wipe reads as one object changing rather than two pictures swapping.
 * Do not substitute a photograph shot on a different day.
 *
 * Built to survive its own failure. With no JavaScript the input is still a real
 * range control, and `--fg-wipe` keeps its CSS default of 50%, so the component
 * renders as a straight half-and-half comparison that still makes the point. The
 * flush half is the one that stays underneath and always fills the box, because
 * this is the flush page: what you see when nothing has been touched is the thing
 * we are selling.
 *
 * Accessibility: the control is an `<input type="range">` rather than a div with
 * pointer handlers, so it is keyboard operable, announces a value, and inherits
 * the platform's own touch behaviour. Both photographs carry real alt text — the
 * comparison is the content here, not decoration.
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
$eyebrow = (string) ($args['eyebrow'] ?? 'The difference');
$heading = (string) ($args['heading'] ?? 'Drag to see the step disappear.');
$copy = (string) ($args['copy'] ?? '');
$uid = 'fg-wipe-' . wp_unique_id();
?>

<section class="fg-wipe" aria-labelledby="<?php echo esc_attr($uid); ?>-title">
    <div class="container fg-wipe__grid">
        <div class="fg-wipe__copy">
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h2 id="<?php echo esc_attr($uid); ?>-title" class="fg-wipe__title"><?php echo esc_html($heading); ?></h2>
            <?php if ($copy !== '') : ?>
                <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
        </div>

        <figure class="fg-wipe__stage" data-fg-wipe>
            <?php /* Flush underneath, filling the box: the resting state is the
                     product this page sells. */ ?>
            <img class="fg-wipe__img fg-wipe__img--flush"
                src="<?php echo esc_url(fenster_generated_url($flush_src)); ?>"
                alt="<?php echo esc_attr($flush_alt); ?>" loading="lazy" decoding="async">

            <?php /* Standard on top, revealed from the left by a clip that follows
                     the slider. `aria-hidden` because the caption and the control
                     already say which side is which, and a screen reader does not
                     benefit from two near-identical descriptions of the same
                     window. The flush image below keeps its alt. */ ?>
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
                min="0" max="100" value="50" step="1"
                aria-describedby="<?php echo esc_attr($uid); ?>-title" data-fg-wipe-range>
        </figure>
    </div>
</section>
