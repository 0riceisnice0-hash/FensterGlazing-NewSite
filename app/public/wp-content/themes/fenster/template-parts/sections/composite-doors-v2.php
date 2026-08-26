<?php
/**
 * Composite Doors: collections, the door style wall, slab construction, the
 * £5,000 break-in guarantee and the colour wall.
 *
 * The tabbed colour/glass/hardware configurator was removed on 2026-07-22 at
 * the owner's request and replaced by the colour wall, where hovering a paint
 * colour shows that colour on a real door. Decorative glass and hardware no
 * longer appear on this route; restore from git history if they are wanted back.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$collections = is_array($args['collections'] ?? null) ? array_values($args['collections']) : [];
$security = is_array($args['security'] ?? null) ? array_values($args['security']) : [];
$anatomy = is_array($args['anatomy'] ?? null) ? $args['anatomy'] : [];
$door_styles = is_array($args['styles'] ?? null) ? array_values($args['styles']) : [];
$styles_base = (string) ($args['styles_base'] ?? '');
$colour_wall = is_array($args['colour_wall'] ?? null) ? array_values($args['colour_wall']) : [];
$palette_base = (string) ($args['palette_base'] ?? '');
$colours_base = (string) ($args['colours_base'] ?? '');
$colour_doors_base = (string) ($args['colour_doors_base'] ?? '');

if (empty($collections)) {
    return;
}
?>

<section class="fg-cd3-collections" aria-labelledby="fg-cd3-collections-title">
    <div class="container">
        <header class="fg-cd3-head fg-cd3-head--wide">
            <p class="eyebrow"><?php esc_html_e('Our collections', 'fenster'); ?></p>
            <h2 id="fg-cd3-collections-title"><?php esc_html_e('Six collections, and it is the slab that separates them.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Within a collection the slab stays the same and the glass changes, so pick the slab you like the look of and the glass design comes later. These are the same six you will meet in our quote tool, in the same order, so nothing is renamed between here and your price.', 'fenster'); ?></p>
        </header>

        <p class="fg-cd3-collections__cue"><?php esc_html_e('Swipe through the six.', 'fenster'); ?></p>
        <div class="fg-cd3-collections__carousel" data-fg-collection-carousel>
        <ul class="fg-cd3-collections__grid">
            <?php foreach ($collections as $index => $collection) : ?>
                <?php $stem = $styles_base . (string) $collection['slug']; ?>
                <li class="fg-cd3-collection">
                    <figure class="fg-cd3-collection__img">
                        <img
                            src="<?php echo esc_url(fenster_generated_url($stem . '-300w.webp')); ?>"
                            srcset="<?php echo esc_attr(fenster_generated_url($stem . '-300w.webp') . ' 300w, ' . fenster_generated_url($stem . '-600w.webp') . ' 600w'); ?>"
                            sizes="(max-width: 860px) 45vw, 200px"
                            alt="<?php echo esc_attr(sprintf(__('A %s composite door', 'fenster'), (string) $collection['name'])); ?>"
                            loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>"
                            width="300" height="734">
                    </figure>
                    <div class="fg-cd3-collection__body">
                        <h3><?php echo esc_html((string) $collection['name']); ?></h3>
                        <p class="fg-cd3-collection__slab"><?php echo esc_html((string) $collection['slab']); ?></p>
                        <p><?php echo esc_html((string) $collection['copy']); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
            <div class="fg-cd3-collections__dots" aria-hidden="true">
                <?php foreach ($collections as $index => $collection) : ?>
                    <span data-fg-collection-dot="<?php echo esc_attr((string) $index); ?>" class="<?php echo $index === 0 ? 'is-active' : ''; ?>"></span>
                <?php endforeach; ?>
            </div>
        </div>
        <p class="fg-cd3-collections__note"><?php esc_html_e('Matching glazed side panels can go either side of any of them, which is how we widen a narrow opening and get more daylight into a dark hallway.', 'fenster'); ?></p>
    </div>
</section>

<?php
/*
 * THE STYLE RANGE. This was a drifting wall of 33 photographed door faces under
 * the heading "The range runs to over 300 door styles." Replaced 2026-08-26.
 *
 * Both halves of that were wrong for the job. The 300 described Distinction's
 * catalogue rather than what our own quoting system can price, so a visitor
 * could fall for a door we cannot put a number on. And the wall offered no way
 * to act on a door beyond "send us the name", which asks a customer to describe
 * a door to us in an email rather than just clicking it.
 *
 * The replacement renders the 142 doors WindowCAD can price, as line art, each
 * one opening the quote tool on that exact door. `$door_styles` and the
 * photographs under `styles/` are untouched and still in git history if the
 * owner wants the wall back.
 */
get_template_part('template-parts/components/composite-door-styles');
?>

<?php
/*
 * The "Real homes" supplier mosaic was removed on 2026-07-22. The door wall
 * above now teaches style, glass and colour using cleaner catalogue renders,
 * and the case-study strip further down proves real installs with Fenster's
 * own photography rather than Distinction's stock lifestyle shots. Restore
 * from git history if the owner wants it back.
 */
?>

<?php if (! empty($anatomy['layers'])) : ?>
    <section class="fg-cd3-anatomy" aria-labelledby="fg-cd3-anatomy-title">
        <div class="container">
            <div class="fg-cd3-anatomy__head">
                <p class="eyebrow"><?php esc_html_e('Construction', 'fenster'); ?></p>
                <h2 id="fg-cd3-anatomy-title"><?php esc_html_e('What is inside the slab.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A composite door looks like timber and is deliberately nothing like one inside. Open a layer to see what it is doing.', 'fenster'); ?></p>
            </div>
            <?php
            // Six layers used to render as six stacked headings and paragraphs,
            // which was a wall of text on any screen and 1,474px tall on a
            // phone. They open one at a time instead. The order is the order
            // you meet them going from the weather into the slab, so the list
            // reads as a section through the door rather than as six facts.
            ?>
            <div class="fg-cd3-anatomy__explorer" data-fg-anatomy>
                <figure class="fg-cd3-anatomy__media">
                    <img
                        src="<?php echo esc_url(fenster_generated_url((string) $anatomy['image'])); ?>"
                        alt="<?php echo esc_attr((string) $anatomy['image_alt']); ?>"
                        loading="lazy" width="341" height="480">
                </figure>
                <ol class="fg-cd3-anatomy__layers">
                    <?php foreach ($anatomy['layers'] as $layer_index => $layer) : ?>
                        <?php $layer_id = 'fg-cd3-layer-' . $layer_index; ?>
                        <li class="fg-cd3-layer">
                            <h3>
                                <button
                                    type="button"
                                    class="fg-cd3-layer__toggle"
                                    data-fg-anatomy-toggle
                                    aria-expanded="<?php echo $layer_index === 0 ? 'true' : 'false'; ?>"
                                    aria-controls="<?php echo esc_attr($layer_id); ?>">
                                    <span class="fg-cd3-layer__num" aria-hidden="true"><?php echo esc_html(str_pad((string) ($layer_index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                                    <span class="fg-cd3-layer__name"><?php echo esc_html((string) $layer['name']); ?></span>
                                    <span class="fg-cd3-layer__mark" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="fg-cd3-layer__body" id="<?php echo esc_attr($layer_id); ?>" <?php echo $layer_index === 0 ? '' : 'hidden'; ?>>
                                <p><?php echo esc_html((string) $layer['copy']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <?php if (! empty($anatomy['stats'])) : ?>
                <dl class="fg-cd3-anatomy__stats">
                    <?php foreach ($anatomy['stats'] as $stat) : ?>
                        <div>
                            <dt><?php echo esc_html((string) $stat['value']); ?></dt>
                            <dd><?php echo esc_html((string) $stat['label']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>
            <?php if (! empty($anatomy['footnote'])) : ?>
                <p class="fg-cd3-anatomy__footnote"><?php echo esc_html((string) $anatomy['footnote']); ?></p>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if (! empty($security)) : ?>
    <section class="fg-cd3-security" aria-labelledby="fg-cd3-security-title">
        <div class="container fg-cd3-security__inner">
            <div class="fg-cd3-security__lead">
                <?php
                // The guarantee badge, drawn rather than an image so it stays sharp
                // and needs no asset. Swap for the supplier artwork if it is ever
                // supplied as a file; there is no APECS or badge asset in the repo.
                ?>
                <span class="fg-cd3-shield" aria-hidden="true">
                    <svg viewBox="0 0 120 132" role="presentation" focusable="false">
                        <path d="M6 12C28 4 46 0 60 0s32 4 54 12v76c0 22-30 36-54 44-24-8-54-22-54-44V12Z" fill="#12306b"/>
                        <path d="M13 18c22-7 36-10 47-10s25 3 47 10v70c0 18-26 30-47 37-21-7-47-19-47-37V18Z" fill="none" stroke="#ffffff" stroke-width="3"/>
                        <rect x="6" y="56" width="108" height="30" fill="#ffffff"/>
                        <text x="60" y="44" text-anchor="middle" font-family="Gibson, Arial, sans-serif" font-size="30" font-weight="700" fill="#ffffff">£5000</text>
                        <text x="60" y="78" text-anchor="middle" font-family="Gibson, Arial, sans-serif" font-size="17" font-weight="700" fill="#12306b" letter-spacing="0.4">GUARANTEE</text>
                    </svg>
                </span>
                <div class="fg-cd3-security__words">
                    <p class="eyebrow"><?php esc_html_e('£5,000 break-in guarantee', 'fenster'); ?></p>
                    <h2 id="fg-cd3-security-title"><?php esc_html_e('If the lock fails in a break-in, you are covered.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Every Distinction door we fit is secured with AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock. Should either fail in a break-in, you are covered for up to £5,000 in compensation. Terms apply, and we go through them with you before you order rather than after.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('How we back our work', 'fenster'); ?></a>
                    </div>
                </div>
            </div>
            <ul class="fg-cd3-security__points">
                <?php foreach ($security as $point) : ?>
                    <li>
                        <strong><?php echo esc_html((string) $point['title']); ?></strong>
                        <span><?php echo esc_html((string) $point['copy']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<?php if (! empty($colour_wall)) : ?>
    <?php
    $cw_first = $colour_wall[0];
    $cw_preview = static function (array $entry) use ($colours_base, $colour_doors_base, $palette_base): array {
        // A photographed door we fitted comes first, then a Distinction render
        // of a door in that named colour, then the paint itself.
        if (! empty($entry['door'])) {
            $stem = $colours_base . $entry['door'];
            return [
                'src' => fenster_generated_url($stem . '-480w.webp'),
                'srcset' => fenster_generated_url($stem . '-480w.webp') . ' 480w, ' . fenster_generated_url($stem . '-800w.webp') . ' 800w',
                'alt' => sprintf(__('A %s composite front door', 'fenster'), (string) $entry['name']),
                'kind' => __('On a door we fitted', 'fenster'),
            ];
        }
        if (! empty($entry['colour_door'])) {
            $stem = $colour_doors_base . $entry['colour_door'];
            return [
                'src' => fenster_generated_url($stem . '-400w.webp'),
                'srcset' => fenster_generated_url($stem . '-400w.webp') . ' 400w, ' . fenster_generated_url($stem . '-800w.webp') . ' 800w',
                'alt' => sprintf(__('A composite door in %s', 'fenster'), (string) $entry['name']),
                'kind' => __('On a door', 'fenster'),
            ];
        }
        $stem = $palette_base . $entry['swatch'];
        return [
            'src' => fenster_generated_url($stem . '-320w.webp'),
            'srcset' => fenster_generated_url($stem . '-160w.webp') . ' 160w, ' . fenster_generated_url($stem . '-320w.webp') . ' 320w',
            'alt' => sprintf(__('%s composite door paint', 'fenster'), (string) $entry['name']),
            'kind' => __('Paint sample', 'fenster'),
        ];
    };
    $cw_first_preview = $cw_preview($cw_first);
    ?>
<?php
/*
 * GLASS, IMMEDIATELY BEFORE COLOUR, BECAUSE THEY ARE THE SAME DECISION.
 *
 * The markup used to sit inline in the shared product tail in
 * `generated-page.php`, behind `if (! $is_composite_doors && ...)`. Composite
 * doors is the ONLY route in `product_content` carrying a `glass_styles` array,
 * so the one page with the data was the one page excluded from rendering it and
 * the section reached no route at all. That is why the page has been shipping
 * with no glass on it. It is a component now and the tail still calls the same
 * one for any future route that gains the data.
 *
 * Placed here rather than after the style range so glass and colour read as the
 * pair of finish decisions they are, and the approved middle of the page —
 * anatomy and security — is left where the owner signed it off.
 */
$fg_glass = fenster_data('product_content.composite-doors.glass_styles', []);
if (! empty($fg_glass['items'])) {
    get_template_part('template-parts/components/composite-glass', null, [
        'items' => $fg_glass['items'],
        'intro' => (string) ($fg_glass['intro'] ?? ''),
        'note'  => (string) ($fg_glass['note'] ?? ''),
    ]);
}
?>

    <section class="fg-cd3-colour" aria-labelledby="fg-cd3-colour-title">
        <div class="container">
            <header class="fg-cd3-head fg-cd3-head--wide">
                <p class="eyebrow"><?php esc_html_e('The paint range', 'fenster'); ?></p>
                <h2 id="fg-cd3-colour-title"><?php esc_html_e('Pick a colour and see it on a real door.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Distinction mix their own paint rather than buying it in. Hover or tap any colour below and most of them will show you a door in it. The few we have no door for show the paint itself, because we would rather show you the real thing than tint a picture and hope.', 'fenster'); ?></p>
                <?php /* Owner-confirmed 2026-07-29: these are a selection of the
                         standard range, not the whole of it, and any RAL can be
                         matched beyond it. See the confirmed facts in AI.md
                         before trimming this back. */ ?>
                <p><?php esc_html_e('What is below is a mix of standard colours and RAL matches, not the full list. The standard range runs wider, and past it we can match any RAL colour, so if you have a shade in mind it is worth asking rather than settling for the nearest one here.', 'fenster'); ?></p>
            </header>

            <div class="fg-cd3-colour__layout" data-fg-door-selector data-fg-colour-wall>
                <div class="fg-cd3-colour__swatches">
                    <?php foreach ($colour_wall as $index => $entry) : ?>
                        <?php $preview = $cw_preview($entry); ?>
                        <button
                            type="button"
                            class="fg-cd3-swatch"
                            data-fg-choice-option
                            data-preview-src="<?php echo esc_url($preview['src']); ?>"
                            data-preview-srcset="<?php echo esc_attr($preview['srcset']); ?>"
                            data-preview-alt="<?php echo esc_attr($preview['alt']); ?>"
                            data-preview-name="<?php echo esc_attr((string) $entry['name']); ?>"
                            data-preview-copy="<?php echo esc_attr(trim((string) ($entry['ref'] ?? '') . ' ' . $preview['kind'])); ?>"
                            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                            <?php if (! empty($entry['swatch'])) : ?>
                                <img
                                    src="<?php echo esc_url(fenster_generated_url($palette_base . $entry['swatch'] . '-160w.webp')); ?>"
                                    alt="" aria-hidden="true" loading="lazy" width="160" height="160">
                            <?php else : ?>
                                <i style="--option-colour: <?php echo esc_attr((string) $entry['hex']); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                            <span><?php echo esc_html((string) $entry['name']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <figure class="fg-cd3-colour__preview">
                    <img
                        data-fg-choice-image
                        src="<?php echo esc_url($cw_first_preview['src']); ?>"
                        srcset="<?php echo esc_attr($cw_first_preview['srcset']); ?>"
                        sizes="(max-width: 860px) 92vw, 40vw"
                        alt="<?php echo esc_attr($cw_first_preview['alt']); ?>"
                        loading="lazy" width="800" height="1000">
                    <figcaption>
                        <strong data-fg-choice-name><?php echo esc_html((string) $cw_first['name']); ?></strong>
                        <span data-fg-choice-copy><?php echo esc_html(trim((string) ($cw_first['ref'] ?? '') . ' ' . $cw_first_preview['kind'])); ?></span>
                    </figcaption>
                </figure>
            </div>

            <p class="fg-cd3-colour__note"><?php esc_html_e('You can have one colour on the outside and a different one facing your hallway. Woodgrain stains are single sided. Colour swatches come out to a consultation, and the doors themselves are at the showroom, which is the only way to see a finish properly.', 'fenster'); ?></p>
        </div>
    </section>
<?php endif; ?>
