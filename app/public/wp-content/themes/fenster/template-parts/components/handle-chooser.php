<?php
/**
 * Handle finish chooser, the full hub treatment.
 *
 * Swatches, a switching product image, a per-finish copy panel, a
 * specification card and feature tiles. Shared so the handle hub can carry
 * windows and doors in the same format without a second copy of ninety lines
 * of near-identical markup.
 *
 * Product pages do not use this. They use the compact grids
 * (window-handle-grid.php, door-handle-grid.php) and link here.
 *
 * The JS controller keyed on data-fg-window-handles scopes every query to its
 * own block, so several choosers on one page operate independently.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$handle_data = is_array($args['data'] ?? null) ? $args['data'] : [];
$finishes = is_array($handle_data['finishes'] ?? null) ? array_values($handle_data['finishes']) : [];

if (empty($finishes)) {
    return;
}

$section_id      = (string) ($args['id'] ?? 'handle-finishes');
$modifier        = (string) ($args['modifier'] ?? '');
$eyebrow         = (string) ($args['eyebrow'] ?? '');
$heading         = (string) ($args['heading'] ?? '');
$intro           = (string) ($args['intro'] ?? ($handle_data['intro'] ?? ''));
$alt_pattern     = (string) ($args['alt_pattern'] ?? '%s handle');
$details_heading = (string) ($args['details_heading'] ?? 'Technical specification');
$swatches_label  = (string) ($args['swatches_label'] ?? 'Handle finish options');
$features_label  = (string) ($args['features_label'] ?? 'Handle features');
$eager_first     = ! empty($args['eager_first']);
$technical       = is_array($handle_data['technical'] ?? null) ? $handle_data['technical'] : [];
$features        = is_array($handle_data['features'] ?? null) ? $handle_data['features'] : [];
?>
<section id="<?php echo esc_attr($section_id); ?>" class="fg-window-handles<?php echo $modifier !== '' ? ' ' . esc_attr($modifier) : ''; ?>" data-fg-window-handles>
    <div class="container">
        <div class="fg-window-handles__shell">
            <div class="fg-window-handles__intro">
                <?php if ($eyebrow !== '') : ?>
                    <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading !== '') : ?>
                    <h2><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($intro !== '') : ?>
                    <p><?php echo esc_html($intro); ?></p>
                <?php endif; ?>
            </div>

            <?php
            /* A family can have no per-finish photography: the lift and slide
               suite is rendered by VBH in three of the five finishes we offer
               and in none of them for White. Rendering the stage anyway gave
               every finish an empty src, which is a broken image and makes the
               browser re-request the page. Fall back to one static product
               image instead, and let the swatches and the copy panel carry the
               finish. */
            $has_finish_images = false;
            foreach ($finishes as $finish) {
                if (! empty($finish['image'])) {
                    $has_finish_images = true;
                    break;
                }
            }
            $fallback_image = (string) ($args['fallback_image'] ?? '');
            ?>
            <div class="fg-window-handles__visual" aria-live="polite">
                <?php if ($has_finish_images) : ?>
                    <?php foreach ($finishes as $index => $finish) : ?>
                        <?php $finish_name = (string) ($finish['name'] ?? 'Handle finish'); ?>
                        <?php if (empty($finish['image'])) { continue; } ?>
                        <img
                            src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>"
                            alt="<?php echo esc_attr(sprintf($alt_pattern, $finish_name)); ?>"
                            loading="<?php echo ($eager_first && $index === 0) ? 'eager' : 'lazy'; ?>"
                            data-fg-handle-image="<?php echo esc_attr((string) $index); ?>"
                            class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                        >
                    <?php endforeach; ?>
                <?php elseif ($fallback_image !== '') : ?>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($fallback_image)); ?>"
                        alt="<?php echo esc_attr((string) ($args['fallback_alt'] ?? '')); ?>"
                        loading="lazy"
                        class="is-active"
                    >
                <?php endif; ?>
            </div>

            <div class="fg-window-handles__chooser">
                <div class="fg-window-handles__swatches" role="list" aria-label="<?php echo esc_attr($swatches_label); ?>">
                    <?php foreach ($finishes as $index => $finish) : ?>
                        <button
                            type="button"
                            role="listitem"
                            class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                            style="<?php echo esc_attr('--swatch:' . (string) ($finish['hex'] ?? '#ffffff')); ?>"
                            data-fg-handle-finish="<?php echo esc_attr((string) $index); ?>"
                            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        >
                            <i aria-hidden="true"></i>
                            <span><?php echo esc_html((string) ($finish['name'] ?? 'Finish')); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-window-handles__finish-copy">
                    <?php foreach ($finishes as $index => $finish) : ?>
                        <article data-fg-handle-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                            <span><?php echo esc_html((string) ($finish['label'] ?? $finish['name'] ?? 'Handle finish')); ?></span>
                            <p><?php echo esc_html((string) ($finish['copy'] ?? '')); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if (! empty($technical)) : ?>
                    <aside class="fg-window-handles__details" aria-label="<?php echo esc_attr($details_heading); ?>">
                        <div class="fg-window-handles__details-card">
                            <h3><?php echo esc_html($details_heading); ?></h3>
                            <div class="fg-window-handles__detail-panel">
                                <?php if (! empty($handle_data['technical_intro'])) : ?>
                                    <p><?php echo esc_html((string) $handle_data['technical_intro']); ?></p>
                                <?php endif; ?>
                                <dl class="fg-window-handles__specs">
                                    <?php foreach ($technical as $spec) : ?>
                                        <div>
                                            <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                                            <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>

            <?php if (! empty($features)) : ?>
                <div class="fg-window-handles__features" aria-label="<?php echo esc_attr($features_label); ?>">
                    <?php foreach ($features as $feature) : ?>
                        <article>
                            <h3><?php echo esc_html((string) ($feature['title'] ?? '')); ?></h3>
                            <p><?php echo esc_html((string) ($feature['copy'] ?? '')); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
