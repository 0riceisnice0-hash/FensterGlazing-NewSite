<?php
/**
 * Composite Doors V2: sold-range and finish configurator.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$families = is_array($args['families'] ?? null) ? array_values($args['families']) : [];
$colours = is_array($args['colours'] ?? null) ? array_values($args['colours']) : [];
$glass_styles = is_array($args['glass'] ?? null) ? array_values($args['glass']) : [];
$handle_finishes = is_array($args['handles'] ?? null) ? array_values($args['handles']) : [];
$asset_base = (string) ($args['asset_base'] ?? '');

if (empty($families) || empty($colours) || empty($glass_styles)) {
    return;
}

$first_colour = $colours[0];
$first_colour_stem = $asset_base . 'colours/' . $first_colour['slug'];
$first_glass = $glass_styles[0];
$first_glass_stem = $asset_base . 'glass/' . $first_glass['slug'];
?>

<section class="fg-cd-v2-range" aria-labelledby="fg-cd-v2-range-title" data-fg-cd-range>
    <div class="container">
        <header class="fg-cd-v2-heading">
            <div>
                <p class="eyebrow"><?php esc_html_e('The Distinction doors we install', 'fenster'); ?></p>
                <h2 id="fg-cd-v2-range-title"><?php esc_html_e('Choose the style before the finishing details.', 'fenster'); ?></h2>
            </div>
            <p><?php esc_html_e('Signature covers the traditional range. Contemporary uses cleaner grooves and glass layouts. Rustic Renown is a cottage-style Signature design that deserves its own view.', 'fenster'); ?></p>
        </header>

        <div class="fg-cd-v2-range__facts" aria-label="<?php esc_attr_e('Composite door specification summary', 'fenster'); ?>">
            <span><small><?php esc_html_e('Door slab', 'fenster'); ?></small><strong><?php esc_html_e('44.5mm insulated GRP', 'fenster'); ?></strong></span>
            <span><small><?php esc_html_e('Installed by', 'fenster'); ?></small><strong><?php esc_html_e('Approved installer', 'fenster'); ?></strong></span>
            <span><small><?php esc_html_e('Security guarantee', 'fenster'); ?></small><strong><?php esc_html_e('£5,000', 'fenster'); ?></strong></span>
        </div>

        <div class="fg-cd-v2-range__studio">
            <figure class="fg-cd-v2-range__visual" aria-live="polite">
                <?php foreach ($families as $index => $family) : ?>
                    <?php
                    $image = (string) $family['image'];
                    $image_400 = str_replace('-800w.webp', '-400w.webp', $image);
                    ?>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($image)); ?>"
                        srcset="<?php echo esc_attr(fenster_generated_url($image_400) . ' 400w, ' . fenster_generated_url($image) . ' 800w'); ?>"
                        sizes="(max-width: 860px) 100vw, 42vw"
                        alt="<?php echo esc_attr((string) $family['alt']); ?>"
                        loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                        data-fg-cd-range-image="<?php echo esc_attr((string) $index); ?>"
                        <?php echo $index === 0 ? '' : 'hidden'; ?>
                    >
                <?php endforeach; ?>
                <figcaption>
                    <span><?php esc_html_e('Selected style', 'fenster'); ?></span>
                    <strong data-fg-cd-range-name><?php echo esc_html((string) $families[0]['name']); ?></strong>
                </figcaption>
            </figure>

            <div class="fg-cd-v2-range__picker">
                <div class="fg-cd-v2-range__tabs" role="tablist" aria-label="<?php esc_attr_e('Choose a composite door style', 'fenster'); ?>">
                    <?php foreach ($families as $index => $family) : ?>
                        <button type="button" role="tab" data-fg-cd-range-tab="<?php echo esc_attr((string) $index); ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                            <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <strong><?php echo esc_html((string) $family['name']); ?></strong>
                            <small><?php echo esc_html((string) $family['tagline']); ?></small>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-cd-v2-range__panels">
                    <?php foreach ($families as $index => $family) : ?>
                        <article data-fg-cd-range-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                            <p><?php echo esc_html((string) $family['copy']); ?></p>
                            <div class="fg-cd-v2-range__best">
                                <small><?php esc_html_e('Best for', 'fenster'); ?></small>
                                <strong><?php echo esc_html((string) $family['best_for']); ?></strong>
                            </div>
                            <dl>
                                <?php foreach ($family['specs'] as $spec) : ?>
                                    <div><dt><?php echo esc_html((string) $spec['label']); ?></dt><dd><?php echo esc_html((string) $spec['value']); ?></dd></div>
                                <?php endforeach; ?>
                            </dl>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="fg-cd-v2-config" aria-labelledby="fg-cd-v2-config-title" data-fg-cd-config>
    <div class="container">
        <header class="fg-cd-v2-heading">
            <div>
                <p class="eyebrow"><?php esc_html_e('Colour, glass and hardware', 'fenster'); ?></p>
                <h2 id="fg-cd-v2-config-title"><?php esc_html_e('Change one detail at a time.', 'fenster'); ?></h2>
            </div>
            <p><?php esc_html_e('Use the three tabs to compare the visible choices without filling the page with every option at once.', 'fenster'); ?></p>
        </header>

        <div class="fg-cd-v2-config__tabs" role="tablist" aria-label="<?php esc_attr_e('Composite door design options', 'fenster'); ?>">
            <button type="button" role="tab" data-fg-cd-config-tab="colour" aria-selected="true"><?php esc_html_e('Colour', 'fenster'); ?></button>
            <button type="button" role="tab" data-fg-cd-config-tab="glass" aria-selected="false"><?php esc_html_e('Glass', 'fenster'); ?></button>
            <button type="button" role="tab" data-fg-cd-config-tab="hardware" aria-selected="false"><?php esc_html_e('Hardware', 'fenster'); ?></button>
        </div>

        <div class="fg-cd-v2-config__shell">
            <section class="fg-cd-v2-config__panel" data-fg-cd-config-panel="colour">
                <div class="fg-cd-v2-selector" data-fg-door-selector>
                    <div class="fg-cd-v2-selector__controls">
                        <p class="eyebrow"><?php esc_html_e('Photographed colours', 'fenster'); ?></p>
                        <h3><?php esc_html_e('Select a colour.', 'fenster'); ?></h3>
                        <p><?php esc_html_e('More supplier colours and woodgrain finishes are available. We confirm the current palette with physical samples.', 'fenster'); ?></p>
                        <div class="fg-cd-v2-options fg-cd-v2-options--colour" aria-label="<?php esc_attr_e('Composite door colour examples', 'fenster'); ?>">
                            <?php foreach ($colours as $index => $colour) : ?>
                                <?php
                                $stem = $asset_base . 'colours/' . $colour['slug'];
                                $source = fenster_generated_url($stem . '-480w.webp');
                                ?>
                                <button type="button" data-fg-choice-option data-preview-src="<?php echo esc_url($source); ?>" data-preview-srcset="<?php echo esc_attr($source . ' 480w, ' . fenster_generated_url($stem . '-800w.webp') . ' 800w'); ?>" data-preview-alt="<?php echo esc_attr((string) $colour['alt']); ?>" data-preview-name="<?php echo esc_attr((string) $colour['name']); ?>" data-preview-copy="<?php echo esc_attr((string) $colour['copy']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                    <i style="--option-colour: <?php echo esc_attr((string) $colour['hex']); ?>" aria-hidden="true"></i>
                                    <span><?php echo esc_html((string) $colour['name']); ?></span>
                                </button>
                            <?php endforeach; ?>
                            <span class="fg-cd-v2-options__more"><?php esc_html_e('And more', 'fenster'); ?></span>
                        </div>
                    </div>
                    <figure class="fg-cd-v2-selector__preview">
                        <img data-fg-choice-image src="<?php echo esc_url(fenster_generated_url($first_colour_stem . '-480w.webp')); ?>" srcset="<?php echo esc_attr(fenster_generated_url($first_colour_stem . '-480w.webp') . ' 480w, ' . fenster_generated_url($first_colour_stem . '-800w.webp') . ' 800w'); ?>" sizes="(max-width: 860px) 100vw, 42vw" alt="<?php echo esc_attr((string) $first_colour['alt']); ?>" loading="lazy" width="800" height="1000">
                        <figcaption><span><?php esc_html_e('Selected colour', 'fenster'); ?></span><strong data-fg-choice-name><?php echo esc_html((string) $first_colour['name']); ?></strong><p data-fg-choice-copy><?php echo esc_html((string) $first_colour['copy']); ?></p></figcaption>
                    </figure>
                </div>
            </section>

            <section class="fg-cd-v2-config__panel" data-fg-cd-config-panel="glass" hidden>
                <div class="fg-cd-v2-selector" data-fg-door-selector>
                    <div class="fg-cd-v2-selector__controls">
                        <p class="eyebrow"><?php esc_html_e('Decorative glass', 'fenster'); ?></p>
                        <h3><?php esc_html_e('Select a glass design.', 'fenster'); ?></h3>
                        <p><?php esc_html_e('We check the aperture size, privacy and current availability against your selected door.', 'fenster'); ?></p>
                        <div class="fg-cd-v2-options fg-cd-v2-options--glass" aria-label="<?php esc_attr_e('Composite door decorative glass examples', 'fenster'); ?>">
                            <?php foreach ($glass_styles as $index => $glass) : ?>
                                <?php
                                $stem = $asset_base . 'glass/' . $glass['slug'];
                                $source = fenster_generated_url($stem . '-360w.webp');
                                ?>
                                <button type="button" data-fg-choice-option data-preview-src="<?php echo esc_url($source); ?>" data-preview-srcset="<?php echo esc_attr($source . ' 360w, ' . fenster_generated_url($stem . '-720w.webp') . ' 720w'); ?>" data-preview-alt="<?php echo esc_attr((string) $glass['name'] . ' decorative glass close-up'); ?>" data-preview-name="<?php echo esc_attr((string) $glass['name']); ?>" data-preview-copy="<?php echo esc_attr((string) $glass['copy']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                    <?php echo esc_html((string) $glass['name']); ?>
                                </button>
                            <?php endforeach; ?>
                            <span class="fg-cd-v2-options__more"><?php esc_html_e('And more', 'fenster'); ?></span>
                        </div>
                    </div>
                    <figure class="fg-cd-v2-selector__preview fg-cd-v2-selector__preview--glass">
                        <img data-fg-choice-image src="<?php echo esc_url(fenster_generated_url($first_glass_stem . '-360w.webp')); ?>" srcset="<?php echo esc_attr(fenster_generated_url($first_glass_stem . '-360w.webp') . ' 360w, ' . fenster_generated_url($first_glass_stem . '-720w.webp') . ' 720w'); ?>" sizes="(max-width: 860px) 100vw, 42vw" alt="Lunna decorative glass close-up" loading="lazy" width="720" height="720">
                        <figcaption><span><?php esc_html_e('Selected glass', 'fenster'); ?></span><strong data-fg-choice-name><?php echo esc_html((string) $first_glass['name']); ?></strong><p data-fg-choice-copy><?php echo esc_html((string) $first_glass['copy']); ?></p></figcaption>
                    </figure>
                </div>
            </section>

            <?php if (! empty($handle_finishes)) : ?>
                <section class="fg-cd-v2-config__panel" data-fg-cd-config-panel="hardware" hidden>
                    <div class="fg-cd-v2-hardware" data-fg-window-handles>
                        <div class="fg-cd-v2-hardware__controls">
                            <p class="eyebrow"><?php esc_html_e('Hardware finish', 'fenster'); ?></p>
                            <h3><?php esc_html_e('Select a handle finish.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('We coordinate the compatible handle, letterplate, cylinder and threshold as one set.', 'fenster'); ?></p>
                            <div class="fg-cd-v2-options fg-cd-v2-options--hardware" role="list" aria-label="<?php esc_attr_e('Composite door handle finishes', 'fenster'); ?>">
                                <?php foreach ($handle_finishes as $index => $finish) : ?>
                                    <button type="button" role="listitem" style="<?php echo esc_attr('--option-colour:' . (string) ($finish['hex'] ?? '#ffffff')); ?>" data-fg-handle-finish="<?php echo esc_attr((string) $index); ?>" class="<?php echo $index === 0 ? 'is-active' : ''; ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                        <i aria-hidden="true"></i><span><?php echo esc_html((string) $finish['name']); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <figure class="fg-cd-v2-hardware__preview">
                            <?php foreach ($handle_finishes as $index => $finish) : ?>
                                <img src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>" alt="<?php echo esc_attr((string) $finish['label']); ?>" loading="lazy" data-fg-handle-image="<?php echo esc_attr((string) $index); ?>" class="<?php echo $index === 0 ? 'is-active' : ''; ?>">
                            <?php endforeach; ?>
                            <figcaption>
                                <span><?php esc_html_e('Selected finish', 'fenster'); ?></span>
                                <?php foreach ($handle_finishes as $index => $finish) : ?>
                                    <article data-fg-handle-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>><strong><?php echo esc_html((string) $finish['name']); ?></strong><p><?php echo esc_html((string) $finish['copy']); ?></p></article>
                                <?php endforeach; ?>
                            </figcaption>
                        </figure>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="fg-cd-v2-config__actions">
            <p><?php esc_html_e('Your final colour, glass and hardware combination is confirmed after survey.', 'fenster'); ?></p>
            <div><a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a><a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book consultation', 'fenster'); ?></a></div>
        </div>
    </div>
</section>
