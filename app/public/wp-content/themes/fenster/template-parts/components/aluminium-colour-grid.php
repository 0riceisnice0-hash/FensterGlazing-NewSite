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
/* Which corner render to show. The colour DATA is shared by every aluminium
   route and the colour hub, so the swatch path is rewritten here rather than
   duplicated in the data.

   Default is the Sheerline Classic corner, which is correct for
   /heritage-windows/ and is what the rest of the range has always used.
   `prestige-flush` swaps to Sheerline's own Prestige flush renders, obtained
   2026-08-10, because a Classic corner has a STEPPED profile with the sash
   standing proud and putting that on the flush page contradicted the page.
   Filenames were deliberately matched one for one so this is a string swap.

   There is no Prestige STANDARD corner render published, so /aluminium-windows/
   still shows a Classic corner and is still slightly wrong. Ask Sheerline. */
$corner_set = (string) ($args['corner_set'] ?? '');

$corner_src = static function (string $src) use ($corner_set): string {
    if ($corner_set !== 'prestige-flush') {
        return $src;
    }
    return str_replace(
        ['/colours/sheerline/', 'Classic-Corner-'],
        ['/colours/sheerline-prestige-flush/', 'Prestige-Flush-Corner-'],
        $src
    );
};

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
                    /* Alt follows the render actually being shown. On the flush
                       route it is a Prestige flush corner and the alt says so;
                       everywhere else it stays generic, because a Classic corner
                       is showing the colour rather than the system that route
                       sells. */
                    $corner_alt = $corner_set === 'prestige-flush'
                        ? sprintf(__('Sheerline Prestige flush window corner, powder coated in %s', 'fenster'), $colour_name)
                        : sprintf(__('Powder-coated aluminium frame corner in %s', 'fenster'), $colour_name);
                    ?>
                    <img src="<?php echo esc_url(fenster_generated_url($corner_src((string) $colour['image']))); ?>" alt="<?php echo esc_attr($corner_alt); ?>" loading="lazy">
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
