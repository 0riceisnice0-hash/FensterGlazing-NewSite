<?php
/**
 * Aluminium frame colour grid.
 *
 * The powder-coated range, laid out the way /heritage-aluminium-doors/ lays out
 * its colours, and the counterpart to upvc-colour-grid.php. Shared by the
 * aluminium window and door routes so the list and the wording cannot drift.
 *
 * Only for products that actually carry this range. Sliding sash is Roseview,
 * composite doors have their own paint range, and the uPVC routes take the foil
 * grid instead.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/* Read from the same source the colour options page uses, so a colour added
   there appears here without a second list to keep in step. */
$aluminium_colours = fenster_data('colour_options.materials.aluminium.colours', []);
$aluminium_colours = is_array($aluminium_colours) ? $aluminium_colours : [];

/* Entries with no swatch photograph stay out of the grid rather than falling
   back to a flat block. The only one today is the any-RAL wildcard, which is a
   statement about the range rather than a colour, and it reads better in the
   note below than as a rainbow tile among twelve real frame corners. Heritage
   doors handles the same fact the same way. */
$aluminium_swatches = array_values(array_filter(
    $aluminium_colours,
    static fn ($colour): bool => is_array($colour) && ! empty($colour['image'])
));

if (empty($aluminium_swatches)) {
    return;
}

$product_noun = (string) ($args['product_noun'] ?? 'frame');
$swatch_count = count($aluminium_swatches);
?>
<section id="aluminium-colours" class="fg-alu-colours" aria-labelledby="fg-alu-colours-title">
    <div class="container">
        <div class="fg-alu-colours__heading">
            <p class="eyebrow"><?php esc_html_e('Colour', 'fenster'); ?></p>
            <h2 id="fg-alu-colours-title">
                <?php
                printf(
                    /* translators: %s: number of standard colours, spelled out */
                    esc_html__('%s standard colours, powder coated in the UK.', 'fenster'),
                    esc_html($swatch_count === 12 ? __('Twelve', 'fenster') : (string) $swatch_count)
                );
                ?>
            </h2>
            <p><?php esc_html_e('Powder coating is baked onto the aluminium rather than painted over it, so it does not flake and it never needs redoing. Anthracite Grey and Jet Black are the two we fit most often, and both sit well against brick and render alike.', 'fenster'); ?></p>
        </div>
        <ul class="fg-alu-colours__grid">
            <?php foreach ($aluminium_swatches as $colour) : ?>
                <?php
                $colour_name = (string) ($colour['name'] ?? '');
                $colour_ref = (string) ($colour['finish'] ?? '');
                ?>
                <li>
                    <?php
                    /* The swatch renders are Sheerline Classic corners, used
                       site-wide for this range. They show the colour, not the
                       profile, so the alt says exactly that rather than naming a
                       system this route may not sell. */
                    ?>
                    <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr(sprintf(__('Powder-coated aluminium frame corner in %s', 'fenster'), $colour_name)); ?>" loading="lazy">
                    <strong><?php echo esc_html($colour_name); ?></strong>
                    <?php if ($colour_ref !== '') : ?>
                        <span><?php echo esc_html($colour_ref); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="fg-alu-colours__note">
            <?php
            printf(
                /* translators: %s: the product, e.g. "window" or "door" */
                esc_html__('You can have a different colour inside and out, and beyond these we can match any RAL colour, confirmed against a sample before your %s is ordered. If you have a shade in mind, ask and we will tell you what is possible.', 'fenster'),
                esc_html($product_noun)
            );
            ?>
            <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('Compare colours across every material', 'fenster'); ?></a>
        </p>
    </div>
</section>
