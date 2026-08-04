<?php
/**
 * Privacy glass choice card.
 *
 * The card that points at /obscured-glass/, panelled with the real pattern
 * photographs from `obscure_glass` so it shows the actual product rather than
 * a texture invented in the stylesheet.
 *
 * Extracted 2026-08-04 so the casement page and the generic product journey
 * render one copy of it. The panel is an `<i>`, not a `<span>`: the card styles
 * its number badge as `> span`, and a span here inherits position: relative and
 * width: fit-content and collapses to about 15px.
 *
 * Args:
 *   heading  string  Section heading. Defaults to the product-journey wording.
 *   copy     string  Supporting line under the heading.
 *   eyebrow  string  Section eyebrow.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$glass_textures = fenster_data('obscure_glass.textures', []);
$glass_textures = is_array($glass_textures) ? $glass_textures : [];

/* Curated for variety, lines against florals against stipple, but anything
   missing simply falls through to whatever else carries a photograph. */
$glass_order = ['Reeded', 'Cotswold', 'Stippolyte', 'Contora', 'Everglade'];
$glass_by_name = [];
$glass_rest = [];
foreach ($glass_textures as $glass_texture) {
    if (! is_array($glass_texture) || trim((string) ($glass_texture['image'] ?? '')) === '') {
        continue;
    }
    $glass_by_name[(string) ($glass_texture['name'] ?? '')] = $glass_texture;
    $glass_rest[] = $glass_texture;
}

$glass_patch = [];
foreach ($glass_order as $glass_name) {
    if (isset($glass_by_name[$glass_name])) {
        $glass_patch[] = $glass_by_name[$glass_name];
    }
}
foreach ($glass_rest as $glass_texture) {
    if (count($glass_patch) >= 5) {
        break;
    }
    if (! in_array($glass_texture, $glass_patch, true)) {
        $glass_patch[] = $glass_texture;
    }
}
$glass_patch = array_slice($glass_patch, 0, 5);

$glass_eyebrow = (string) ($args['eyebrow'] ?? __('Specification choices', 'fenster'));
$glass_heading = (string) ($args['heading'] ?? __('Privacy where the room needs it.', 'fenster'));
$glass_copy = (string) ($args['copy'] ?? __('Bathrooms, en suites, ground floor side windows and anything overlooked. Obscured glass goes in the same frame and the same sealed unit, so it changes nothing about how the window performs.', 'fenster'));
?>
<section class="fg-product-gallery-band fg-product-gallery-band--glass">
    <div class="container">
        <div class="section-heading section-heading--wide">
            <p class="eyebrow"><?php echo esc_html($glass_eyebrow); ?></p>
            <h2><?php echo esc_html($glass_heading); ?></h2>
            <p><?php echo esc_html($glass_copy); ?></p>
        </div>
        <div class="fg-product-choice-map fg-product-choice-map--single">
            <div class="fg-product-options fg-product-options--hub">
                <a class="fg-product-option-card fg-product-option-card--glass<?php echo count($glass_patch) >= 3 ? ' is-glazed' : ''; ?>" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>">
                    <?php if (count($glass_patch) >= 3) : ?>
                        <i class="fg-glass-patch" aria-hidden="true">
                            <?php foreach ($glass_patch as $glass_pane) : ?>
                                <span style="<?php echo esc_attr('background-image:url(' . fenster_generated_url((string) $glass_pane['image']) . ')'); ?>"></span>
                            <?php endforeach; ?>
                        </i>
                    <?php endif; ?>
                    <h3><?php esc_html_e('Privacy glass', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Preview obscured glass patterns and privacy levels on the visualiser, then tell us which room needs which.', 'fenster'); ?></p>
                    <strong><?php esc_html_e('Compare glass patterns', 'fenster'); ?></strong>
                </a>
            </div>
        </div>
    </div>
</section>
