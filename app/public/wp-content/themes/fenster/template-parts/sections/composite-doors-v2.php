<?php
/**
 * Composite Doors: collections, real-home gallery, door types and finish configurator.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$collections = is_array($args['collections'] ?? null) ? array_values($args['collections']) : [];
$gallery = is_array($args['gallery'] ?? null) ? array_values($args['gallery']) : [];
$door_types = is_array($args['door_types'] ?? null) ? $args['door_types'] : [];
$colours = is_array($args['colours'] ?? null) ? array_values($args['colours']) : [];
$glass_styles = is_array($args['glass'] ?? null) ? array_values($args['glass']) : [];
$handle_finishes = is_array($args['handles'] ?? null) ? array_values($args['handles']) : [];
$asset_base = (string) ($args['asset_base'] ?? '');

if (empty($collections) || empty($colours) || empty($glass_styles)) {
    return;
}

/**
 * Build a srcset string from an asset stem and a list of widths.
 */
$cd_srcset = static function (string $stem, array $widths) use ($asset_base): string {
    $parts = [];
    foreach ($widths as $width) {
        $width = (int) $width;
        $parts[] = fenster_generated_url($asset_base . $stem . '-' . $width . 'w.webp') . ' ' . $width . 'w';
    }
    return implode(', ', $parts);
};

$first_colour = $colours[0];
$first_colour_stem = $asset_base . 'colours/' . $first_colour['slug'];
$first_glass = $glass_styles[0];
$first_glass_stem = $asset_base . 'glass/' . $first_glass['slug'];
?>

<section class="fg-cd3-collections" aria-labelledby="fg-cd3-collections-title">
    <div class="container">
        <header class="fg-cd3-head">
            <p class="eyebrow"><?php esc_html_e('Two collections', 'fenster'); ?></p>
            <h2 id="fg-cd3-collections-title"><?php esc_html_e('Start with the look, then make it yours.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Every Distinction door sits in one of two collections. Choose the character first. The styles, colour, glass and hardware come next.', 'fenster'); ?></p>
        </header>

        <div class="fg-cd3-collections__grid">
            <?php foreach ($collections as $index => $collection) : ?>
                <article class="fg-cd3-collection">
                    <figure class="fg-cd3-collection__img">
                        <img
                            src="<?php echo esc_url(fenster_generated_url((string) $collection['image_400'])); ?>"
                            srcset="<?php echo esc_attr(fenster_generated_url((string) $collection['image_400']) . ' 400w, ' . fenster_generated_url((string) $collection['image_800']) . ' 800w'); ?>"
                            sizes="(max-width: 860px) 100vw, 44vw"
                            alt="<?php echo esc_attr((string) $collection['alt']); ?>"
                            loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                            width="800" height="800">
                    </figure>
                    <div class="fg-cd3-collection__body">
                        <p class="eyebrow"><?php echo esc_html((string) $collection['tagline']); ?></p>
                        <h3><?php echo esc_html((string) $collection['name']); ?></h3>
                        <p><?php echo esc_html((string) $collection['copy']); ?></p>
                        <?php if (! empty($collection['styles'])) : ?>
                            <ul class="fg-cd3-collection__styles" aria-label="<?php echo esc_attr(sprintf(__('%s door styles', 'fenster'), (string) $collection['name'])); ?>">
                                <?php foreach ($collection['styles'] as $style) : ?>
                                    <li><?php echo esc_html((string) $style); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (! empty($gallery)) : ?>
    <section class="fg-cd3-gallery" aria-labelledby="fg-cd3-gallery-title">
        <div class="container">
            <header class="fg-cd3-head">
                <p class="eyebrow"><?php esc_html_e('Real homes', 'fenster'); ?></p>
                <h2 id="fg-cd3-gallery-title"><?php esc_html_e('See the style, glass and colour on a real door.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The best way to choose is to see a door fitted. Here is a spread of finishes across both collections.', 'fenster'); ?></p>
            </header>

            <div class="fg-cd3-mosaic">
                <?php foreach ($gallery as $tile) : ?>
                    <?php
                    $widths = is_array($tile['widths'] ?? null) ? $tile['widths'] : [800];
                    $smallest = (int) min($widths);
                    ?>
                    <figure class="fg-cd3-tile <?php echo esc_attr((string) ($tile['class'] ?? '')); ?>">
                        <img
                            src="<?php echo esc_url(fenster_generated_url($asset_base . (string) $tile['stem'] . '-' . $smallest . 'w.webp')); ?>"
                            srcset="<?php echo esc_attr($cd_srcset((string) $tile['stem'], $widths)); ?>"
                            sizes="(max-width: 860px) 50vw, 33vw"
                            alt="<?php echo esc_attr((string) $tile['caption']); ?>"
                            loading="lazy">
                        <figcaption>
                            <strong><?php echo esc_html((string) $tile['caption']); ?></strong>
                            <small><?php echo esc_html((string) $tile['sub']); ?></small>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (! empty($door_types['items'])) : ?>
    <section class="fg-cd3-types" aria-labelledby="fg-cd3-types-title">
        <div class="container">
            <div class="fg-cd3-types__panel">
                <figure class="fg-cd3-types__img">
                    <?php
                    $type_widths = is_array($door_types['image_widths'] ?? null) ? $door_types['image_widths'] : [800];
                    $type_smallest = (int) min($type_widths);
                    ?>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . (string) $door_types['image_stem'] . '-' . $type_smallest . 'w.webp')); ?>"
                        srcset="<?php echo esc_attr($cd_srcset((string) $door_types['image_stem'], $type_widths)); ?>"
                        sizes="(max-width: 860px) 100vw, 48vw"
                        alt="<?php echo esc_attr((string) $door_types['image_alt']); ?>"
                        loading="lazy">
                </figure>
                <div class="fg-cd3-types__body">
                    <p class="eyebrow"><?php esc_html_e('More than single doors', 'fenster'); ?></p>
                    <h2 id="fg-cd3-types-title"><?php esc_html_e('Stable doors and side panels.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Not every opening is a plain single door. We fit the full Distinction range of door types.', 'fenster'); ?></p>
                    <div class="fg-cd3-types__grid">
                        <?php foreach ($door_types['items'] as $item) : ?>
                            <div>
                                <h3><?php echo esc_html((string) $item['name']); ?></h3>
                                <p><?php echo esc_html((string) $item['copy']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="fg-cd-v2-config" aria-labelledby="fg-cd-v2-config-title" data-fg-cd-config>
    <div class="container">
        <header class="fg-cd-v2-heading">
            <div>
                <p class="eyebrow"><?php esc_html_e('Make it yours', 'fenster'); ?></p>
                <h2 id="fg-cd-v2-config-title"><?php esc_html_e('Colour, glass and hardware.', 'fenster'); ?></h2>
            </div>
            <p><?php esc_html_e('Change one detail at a time. Pick a colour and see it on the door, browse the decorative glass close up, then coordinate the handle set.', 'fenster'); ?></p>
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
                        <img data-fg-choice-image src="<?php echo esc_url(fenster_generated_url($first_glass_stem . '-360w.webp')); ?>" srcset="<?php echo esc_attr(fenster_generated_url($first_glass_stem . '-360w.webp') . ' 360w, ' . fenster_generated_url($first_glass_stem . '-720w.webp') . ' 720w'); ?>" sizes="(max-width: 860px) 100vw, 42vw" alt="<?php echo esc_attr((string) $first_glass['name'] . ' decorative glass close-up'); ?>" loading="lazy" width="720" height="720">
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
