<?php
/**
 * Integral blind slat colour grid.
 *
 * The nine standard Notan slat colours, laid out the way the uPVC and
 * aluminium routes lay out their frame finishes, so the choice is made on the
 * page rather than behind a card that links somewhere else.
 *
 * Read from `notan_blind_colours`, the same list the visualiser on this page
 * and the section on the colour hub both read, so the three cannot drift.
 *
 * These are the slats, not a frame finish. The frame around a blind unit takes
 * the colour of whichever window or door the unit is built into, which is why
 * this route carries no frame colour grid and no card pointing at one.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$slat_colours = fenster_data('notan_blind_colours', []);
$slat_colours = is_array($slat_colours) ? array_values($slat_colours) : [];

if (empty($slat_colours)) {
    return;
}
?>
<section id="blind-colours" class="fg-blind-colours" aria-labelledby="fg-blind-colours-title">
    <div class="container">
        <div class="fg-blind-colours__heading">
            <p class="eyebrow"><?php esc_html_e('Colour', 'fenster'); ?></p>
            <h2 id="fg-blind-colours-title"><?php esc_html_e('Nine slat colours, sealed inside the glass.', 'fenster'); ?></h2>
            <p><?php esc_html_e('This is the blind itself rather than the frame around it. Aluminium slats come in nine standard colours as part of the Notan magnetic system, with bespoke RAL available to order. The frame the unit sits in takes the colour of whichever window or door it is built into, so that decision is made with the product, not here.', 'fenster'); ?></p>
        </div>
        <ul class="fg-blind-colours__grid">
            <?php foreach ($slat_colours as $colour) : ?>
                <?php
                $colour_name = (string) ($colour['name'] ?? '');
                $colour_hex = (string) ($colour['hex'] ?? '#ffffff');
                $colour_code = (string) ($colour['code'] ?? '');
                $colour_reverse = (string) ($colour['reverse'] ?? '');
                $swatch_style = '--swatch:' . $colour_hex;
                if ($colour_reverse !== '') {
                    $swatch_style .= ';--swatch-reverse:' . $colour_reverse;
                }
                ?>
                <li>
                    <?php
                    /* A two sided slat shows both of its faces on the swatch,
                       because the swatch is the only place the second one is
                       visible without working the blind. */
                    ?>
                    <i
                        aria-hidden="true"
                        class="<?php echo $colour_reverse !== '' ? 'is-two-sided' : ''; ?><?php echo ! empty($colour['glitter']) ? ' is-glitter' : ''; ?>"
                        style="<?php echo esc_attr($swatch_style); ?>"
                    ></i>
                    <strong><?php echo esc_html($colour_name); ?></strong>
                    <span><?php echo esc_html($colour_reverse !== '' ? trim($colour_code . ' ' . __('two sided', 'fenster')) : $colour_code); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="fg-blind-colours__note">
            <?php esc_html_e('White/Anthracite is white on the room side and anthracite outside, so one blind can suit the room and the elevation at the same time. Tilt it one way in the visualiser above to see each face.', 'fenster'); ?>
            <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/#integral-blind-colours')); ?>"><?php esc_html_e('Compare colours across every material', 'fenster'); ?></a>
        </p>
    </div>
</section>
