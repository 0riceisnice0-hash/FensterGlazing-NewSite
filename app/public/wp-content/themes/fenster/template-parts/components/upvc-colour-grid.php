<?php
/**
 * uPVC frame colour grid.
 *
 * The Liniar foil range, laid out the way /heritage-aluminium-doors/ lays out
 * its powder-coated colours. Shared by the casement page and the other uPVC
 * window routes so the list and the wording cannot drift apart.
 *
 * Only for products that actually carry this range. Sliding sash is Roseview
 * and secondary glazing is aluminium, so neither should include this part.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/* Read from the same source the colour options page uses. Smooth white carries
   no image because it is the unfoiled profile, and falls back to a flat block. */
$upvc_colours = fenster_data('colour_options.materials.upvc.colours', []);
$upvc_colours = is_array($upvc_colours) ? $upvc_colours : [];

/* A ROUTE MAY CARRY A SUBSET, and it has to be able to say so in the heading.
   The doors take thirteen of these foils where the windows take sixteen, and
   before this the component hardcoded "Sixteen colours outside", which is why
   `/upvc-doors/` had to be taken off it entirely and given a chart of its own.
   Pass `names` to filter and `heading` to match, and the source of truth stays
   this one list either way. Order follows `colour_options`, not the order the
   names arrive in, so every route lays the range out the same way. */
$colour_names = is_array($args['names'] ?? null) ? array_map('strval', $args['names']) : [];
if (! empty($colour_names)) {
    $upvc_colours = array_values(array_filter(
        $upvc_colours,
        static fn (array $colour): bool => in_array((string) ($colour['name'] ?? ''), $colour_names, true)
    ));
}

if (empty($upvc_colours)) {
    return;
}

$product_noun = (string) ($args['product_noun'] ?? 'window');
$colour_heading = (string) ($args['heading'] ?? __('Sixteen colours outside, matched or white inside.', 'fenster'));
/* A subset rarely divides the way sixteen does. Thirteen in the six-column grid
   left one swatch alone on a third row, so a route carrying a subset can pass a
   modifier and set its own column count. */
$colour_modifier = (string) ($args['modifier'] ?? '');
$colour_intro = (string) ($args['intro'] ?? __('A uPVC colour is a foil bonded to the profile at the factory rather than paint applied afterwards, which is why the woodgrains have a grain you can feel and why none of them need repainting. The colour you choose is the external face, with the same colour or smooth white on the inside.', 'fenster'));
?>
<section id="upvc-colours" class="fg-upvc-colours <?php echo esc_attr($colour_modifier); ?>" aria-labelledby="fg-upvc-colours-title">
    <div class="container">
        <div class="fg-upvc-colours__heading">
            <p class="eyebrow"><?php esc_html_e('Colour', 'fenster'); ?></p>
            <h2 id="fg-upvc-colours-title"><?php echo esc_html($colour_heading); ?></h2>
            <p><?php echo esc_html($colour_intro); ?></p>
        </div>
        <ul class="fg-upvc-colours__grid">
            <?php foreach ($upvc_colours as $colour) : ?>
                <?php
                $colour_name = (string) ($colour['name'] ?? '');
                $colour_hex = (string) ($colour['hex'] ?? '#ffffff');
                $colour_ref = (string) ($colour['finish'] ?? 'Foil');
                ?>
                <li>
                    <?php if (! empty($colour['image'])) : ?>
                        <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr(sprintf('Liniar uPVC %1$s profile in %2$s', $product_noun, $colour_name)); ?>" loading="lazy">
                    <?php else : ?>
                        <i aria-hidden="true" style="<?php echo esc_attr('--swatch:' . $colour_hex); ?>"></i>
                    <?php endif; ?>
                    <strong><?php echo esc_html($colour_name); ?></strong>
                    <span><?php echo esc_html($colour_ref); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="fg-upvc-colours__note">
            <?php esc_html_e('Availability, lead time and cost depend on the exact profile and the fabricator, so we confirm all three before you order rather than after.', 'fenster'); ?>
            <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('Compare colours across every material', 'fenster'); ?></a>
        </p>
    </div>
</section>
