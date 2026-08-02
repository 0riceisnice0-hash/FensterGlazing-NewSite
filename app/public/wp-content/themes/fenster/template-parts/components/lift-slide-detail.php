<?php
/**
 * Sheerline Prestige Lift & Slide: the two details that decide the door.
 *
 * Built on the casement split sections the heritage door page already reuses,
 * so it inherits that grammar rather than growing a third one. Only the copy
 * and the photographs are new.
 *
 * Figures come from Sheerline's published Prestige Lift & Slide specification:
 * 106mm frame and sash, 80mm or 52mm interlock, 2.5m maximum height, 6.5m
 * maximum width, 400kg per sash, 1.4 W/m²K double glazed and 1.0 triple, PAS 24,
 * stainless steel tracks and flush hook-locks. Do not add values that source
 * does not support, and keep the triple-glazed figure starred: it is the
 * lowest achievable, not a promise for every size.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$asset = static function (string $file): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/images/products/aluminium-sliding/' . $file);
};
?>
<div class="fg-cw fg-ls-detail">
    <section class="fg-cw-intro" aria-labelledby="fg-ls-track-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Underfoot', 'fenster'); ?></p>
                <h2 id="fg-ls-track-title"><?php esc_html_e('The threshold is where a slider is won or lost.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A sash on this system can weigh up to 400kg, so what it runs on matters more than anything else on the door. The tracks are stainless steel rather than rolled aluminium, and the lift and slide action takes the weight off the seals before the door moves, which is why a door this size still slides with one hand.', 'fenster'); ?></p>
                <p><?php esc_html_e('Drainage is built into the threshold instead of being cut in afterwards. There are three threshold heights, and which one suits you depends on the floor build-up inside and the drop outside, so we settle it at survey rather than on the order.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Stainless steel tracks, in dual or triple track', 'fenster'); ?></li>
                    <li><?php esc_html_e('Up to 400kg a sash, lifted clear of the seals to move', 'fenster'); ?></li>
                    <li><?php esc_html_e('Three threshold heights, chosen against your floor at survey', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-media">
                <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-track-900w.webp', [
                    'alt' => __('Low threshold and stainless steel track under an open aluminium sliding door, with oak flooring inside and paving outside', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
                <figcaption><?php esc_html_e('Threshold and track', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-cw-intro" aria-labelledby="fg-ls-interlock-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media">
                <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-handle-900w.webp', [
                    'alt' => __('Slim lever handle and the flush hook-lock set into the interlock of an aluminium sliding door', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
                <figcaption><?php esc_html_e('Handle and hook-lock', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Where the panes meet', 'fenster'); ?></p>
                <h2 id="fg-ls-interlock-title"><?php esc_html_e('The bar down the middle is the one you will look at.', 'fenster'); ?></h2>
                <p><?php esc_html_e('On a slider the interlock is the upright where two panes overlap, and it is the only thing interrupting the view when the door is shut. There are two: 80mm, or 52mm where you want the glass to carry as far as it can. Everything else on the frame is 106mm.', 'fenster'); ?></p>
                <p><?php esc_html_e('The locks are flush hook-locks set into that upright rather than a handle assembly bolted to the face, which is what keeps the line clean and gets the door through PAS 24. The handle sits flush with the sash for the same reason.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('80mm or 52mm interlock, on a 106mm frame and sash', 'fenster'); ?></li>
                    <li><?php esc_html_e('Flush hook-locks, tested to PAS 24', 'fenster'); ?></li>
                    <li><?php esc_html_e('Up to 6.5m wide and 2.5m tall in one opening', 'fenster'); ?></li>
                </ul>
            </div>
        </div>
    </section>
</div>
