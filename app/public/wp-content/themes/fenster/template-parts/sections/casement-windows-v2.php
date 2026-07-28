<?php
/**
 * Casement windows: 70mm Liniar EnergyPlus product page.
 *
 * Composed on the /heritage-aluminium-doors/ pattern: copy column on one side,
 * real photography on the other, short paragraphs, divided detail lists.
 * The shared hero and four-tile specification strip render above this partial
 * and are deliberately untouched.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$quote_url = (string) ($args['quote_url'] ?? '');
$quote_label = (string) ($args['quote_label'] ?? 'uPVC Windows');
$phone = (string) ($brand['phone'] ?? '01908 429200');
$asset_base = '/wp-content/themes/fenster/assets/images/products/casement/';
$swatch_base = '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/';

// The page hero already uses casement-stone-cottage-1600w.webp. Every image
// below is used exactly once.
$opening_styles = [
    [
        'id' => 'side-hung',
        'name' => 'Side-hung',
        'label' => 'Friction stays and egress hinges',
        'image' => 'casement-friction-stay-1200w.webp',
        'width' => 1200,
        'height' => 823,
        'position' => 'center',
        'alt' => 'Friction stay holding a white uPVC casement sash open',
        'copy' => 'Friction stays hold the sash at any angle. For bedrooms we fit egress hinges, which swing clear to 90 degrees to meet the escape minimum.',
        'chip_label' => 'Bedroom escape',
        'chip' => 'Building Regulations ask for 0.33m², at least 450mm each way',
    ],
    [
        'id' => 'top-hung',
        'name' => 'Top-hung',
        'label' => 'Hinged from the top rail',
        'image' => 'casement-top-hinge-1200w.webp',
        'width' => 1200,
        'height' => 823,
        'position' => 'center',
        'alt' => 'Top rail hinge and gasket on an open white uPVC casement sash',
        'copy' => 'The stays sit in the top rail and the handle on the bottom one. The open sash sheds rain clear of the opening, so it can stand ajar in weather.',
        'chip_label' => 'Child safety',
        'chip' => 'Restrictors hold the first opening to around 100mm',
    ],
    [
        'id' => 'fixed-pane',
        'name' => 'Fixed pane',
        'label' => 'No gearing, no handle',
        'image' => 'casement-anthracite-fixed-600w.webp',
        'width' => 600,
        'height' => 450,
        'position' => 'center',
        'alt' => 'Fixed anthracite uPVC window pane with a glazing bar cross',
        'copy' => 'No hinges, gearing or handle, so it costs less than an opener the same size. Ventilation and escape have to come from the openers around it.',
        'chip_label' => 'Glass area',
        'chip' => 'No sash frame inside the outer frame, so more glass per opening',
    ],
    [
        'id' => 'mixed-layout',
        'name' => 'Mixed layout',
        'label' => 'One outer frame',
        'image' => 'casement-three-light-stone-600w.webp',
        'width' => 600,
        'height' => 450,
        'position' => 'center',
        'alt' => 'Three-light white uPVC casement with two openers around a fixed centre, set in a stone wall',
        'copy' => 'Openers and fixed panes share one outer frame. Transom and mullion positions decide whether the glass lines up across the elevation.',
        'chip_label' => 'Before ordering',
        'chip' => 'We draw the elevation with every sightline marked',
    ],
];

// Comparison rows, in the same order as the cards above.
$style_table = [
    ['label' => 'Hinges', 'values' => ['Friction stays, egress or easy-clean options', 'Friction stays in the top rail', 'None', 'Chosen per sash']],
    ['label' => 'Handle', 'values' => ['On the closing edge', 'On the bottom rail', 'None', 'One per opener']],
    ['label' => 'Bedroom escape', 'values' => ['Yes, with egress hinges', 'Rarely tall enough to qualify', 'No', 'Through a side-hung sash']],
    ['label' => 'Cleaning the outside', 'values' => ['From inside, with easy-clean stays', 'Usually from outside', 'From the opener beside it', 'Planned at survey']],
    ['label' => 'Rain with the sash ajar', 'values' => ['Comes in', 'Sheds clear of the opening', 'Not applicable', 'Depends on the sash']],
];

$frame_points = [
    ['title' => 'Six chambers', 'copy' => 'Each one interrupts the route heat takes through the uPVC. On our listed specification that comes out at 0.95 W/m²K, A+ rated.'],
    ['title' => 'A seal that cannot fall out', 'copy' => 'The weather gasket is co-extruded, formed as part of the profile rather than pushed into a groove. It cannot shrink back at a corner.'],
    ['title' => 'The figure follows the window', 'copy' => 'Liniar publish 0.8 W/m²K for a suitable build-up. Size, layout and glass all move it, so the number we agree is yours, not the brochure\'s.'],
];

$spec_points = [
    ['title' => 'Glass', 'copy' => 'Warmth, privacy, noise and security do not point at the same sealed unit. Triple glazing on its own is not automatically the quietest answer.'],
    ['title' => 'Locking', 'copy' => 'Multi-point locking, reinforcement sized for the window, and PAS 24 or Secured by Design where you want it. Those approvals belong to a tested window, not to a profile name.'],
    ['title' => 'Handles', 'copy' => 'S2 Signature handles, finished to match the frame, with restrictors where they are sensible.'],
    ['title' => 'Ventilation', 'copy' => 'Trickle vents and background ventilation are set at survey, alongside handle reach and how far the sash swings outside.'],
];

$swatches = [
    ['name' => 'White', 'file' => 'colours_page_image-White-weiss.webp'],
    ['name' => 'Cream', 'file' => 'colours_page_image-Cream-Cremeweiss.webp'],
    ['name' => 'Chartwell Green', 'file' => 'colours_page_image-Chartwell-green.webp'],
    ['name' => 'Agate Grey', 'file' => 'colours_page_image-Agate-grey-7038.webp'],
    ['name' => 'Anthracite Grey', 'file' => 'colours_page_image-7016-SM-Grey.webp'],
    ['name' => 'Slate Grey', 'file' => 'colours_page_image-Slate-grey-7015-grey.webp'],
    ['name' => 'Golden Oak', 'file' => 'colours_page_image-Golden-Oak.webp'],
    ['name' => 'Rosewood', 'file' => 'colours_page_image-Rosewood.webp'],
];

// Mosaic order matters: the first image takes the large portrait cell, so it
// needs a focal point or a landscape source loses its subject to the crop.
$gallery = [
    ['file' => 'casement-cottage-arch', 'width' => 1200, 'focus' => '76% 50%', 'caption' => 'Arched head on a stone cottage', 'alt' => 'Grey uPVC casement windows with an arched head in a stone cottage elevation'],
    ['file' => 'casement-stone-elevation', 'width' => 1200, 'focus' => '50% 45%', 'caption' => 'White casements across a full elevation', 'alt' => 'White uPVC casement windows across the front elevation and dormers of a stone house'],
    ['file' => 'casement-brick-bay', 'width' => 1400, 'focus' => '40% 50%', 'caption' => 'Casements in a bay', 'alt' => 'White uPVC casement windows with glazing bars set into a brick bay'],
    ['file' => 'casement-new-build', 'width' => 1200, 'focus' => '50% 50%', 'caption' => 'Three lights on new cladding', 'alt' => 'Grey uPVC casement window with three lights and glazing bars on a clad new build'],
    ['file' => 'casement-apartment-block', 'width' => 1200, 'focus' => '50% 50%', 'caption' => 'Repeated openings on an apartment block', 'alt' => 'Dark uPVC casement windows repeated across an apartment block elevation'],
    ['file' => 'casement-open-interior', 'width' => 1400, 'focus' => '35% 50%', 'caption' => 'A sash open from inside', 'alt' => 'White uPVC casement sash opened outwards, seen from inside the room'],
];

$related = [
    ['url' => '/flush-casement-windows/', 'name' => 'Flush casement windows', 'view' => 'View flush casements', 'copy' => 'The sash closes level with the frame instead of sitting proud of it.'],
    ['url' => '/french-casement-windows/', 'name' => 'French casement windows', 'view' => 'View French casements', 'copy' => 'Two sashes and no post between them, for one uninterrupted opening.'],
    ['url' => '/tilt-turn-windows/', 'name' => 'Tilt and turn windows', 'view' => 'View tilt and turn', 'copy' => 'Tilts in at the top for air, or swings fully inwards for cleaning.'],
];

$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'Which Liniar system do you fit?', 'answer' => 'The 70mm Liniar EnergyPlus system, a six-chamber uPVC platform used for both replacement and new-build work. Glass, reinforcement and hardware are confirmed for your individual job.'],
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => 'We list 0.95 W/m²K. Liniar say a suitable EnergyPlus build-up can reach 0.8 W/m²K. Size, layout, glass and reinforcement all move the complete-window figure, so the number we agree follows the final specification.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options. Those approvals belong to a tested complete window rather than to the profile name, so we confirm what applies to your configuration.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'It depends on the frame, the sash size and what you are trying to improve. We will compare the benefit, the weight and the cost with you rather than treating it as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Acoustic glass, pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen, inside, outside or both. Liniar publish a wider foil catalogue, but availability, lead time and cost depend on the exact profile and the fabricator, so we confirm before you order.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, though an exact copy is not always the best answer. At survey we check escape, ventilation, handle reach, outside clearance and how the sightlines sit before the drawing is signed off.'],
    ['question' => 'Are the frames recyclable?', 'answer' => 'Liniar describe their uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire, and independent fabricators make the finished windows.'],
];

$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
        ],
        $faqs
    ),
];
?>

<div class="fg-cw">
    <section class="fg-cw-intro" aria-labelledby="fg-cw-intro-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The system we fit', 'fenster'); ?></p>
                <h2 id="fg-cw-intro-title"><?php esc_html_e('One frame, openers and fixed panes together.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A casement is hinged at the side or the top and opens outwards. Because the openers and the fixed panes are made into one frame, a single window can give you a wide opening where you need one and uninterrupted glass where you do not.', 'fenster'); ?></p>
                <p><?php esc_html_e('We fit the 70mm Liniar EnergyPlus system. We work out the layout room by room first, then match the glass, the locking and the handles to it.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Side-hung, top-hung and fixed lights in any combination', 'fenster'); ?></li>
                    <li><?php esc_html_e('Made to measure, in sixteen colours inside and out', 'fenster'); ?></li>
                    <li><?php esc_html_e('Fitted by our own installers, with a ten year guarantee', 'fenster'); ?></li>
                </ul>
                <div class="fg-cw-actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                </div>
            </div>
            <figure class="fg-cw-media">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-bay-white-1080w.webp')); ?>"
                    alt="<?php esc_attr_e('White uPVC casement windows with glazing bars and top opening lights on a bay', 'fenster'); ?>"
                    loading="lazy"
                    width="1080"
                    height="608"
                >
                <figcaption><?php esc_html_e('70mm Liniar EnergyPlus', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section id="casement-opening-styles" class="fg-cw-styles" aria-labelledby="fg-cw-styles-title">
        <div class="container">
            <div class="fg-cw-styles__head">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Opening styles', 'fenster'); ?></p>
                <h2 id="fg-cw-styles-title"><?php esc_html_e('Four layouts, four different jobs.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The names are obvious; the hardware is the actual difference. Most houses end up using at least three of the four.', 'fenster'); ?></p>
            </div>

            <aside class="fg-cw-note">
                <p class="eyebrow"><?php esc_html_e('What we settle at survey', 'fenster'); ?></p>
                <p><?php esc_html_e('Which panes open, where they hinge, and what Building Regulations ask of the frame: escape openings for bedrooms, safety glass below 800mm, and trickle vents, which most replacement windows have needed since June 2022.', 'fenster'); ?></p>
            </aside>
            </div>

            <div class="fg-cw-styles__grid">
                <?php foreach ($opening_styles as $style) : ?>
                    <article class="fg-cw-style">
                        <figure data-position="<?php echo esc_attr($style['position']); ?>">
                            <img
                                src="<?php echo esc_url(fenster_generated_url($asset_base . $style['image'])); ?>"
                                alt="<?php echo esc_attr($style['alt']); ?>"
                                loading="lazy"
                                width="<?php echo esc_attr((string) $style['width']); ?>"
                                height="<?php echo esc_attr((string) $style['height']); ?>"
                            >
                        </figure>
                        <div class="fg-cw-style__body">
                            <p class="eyebrow"><?php echo esc_html($style['label']); ?></p>
                            <h3><?php echo esc_html($style['name']); ?></h3>
                            <p><?php echo esc_html($style['copy']); ?></p>
                            <p class="fg-cw-style__best">
                                <strong><?php echo esc_html($style['chip_label']); ?></strong>
                                <?php echo esc_html($style['chip']); ?>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="fg-cw-compare" role="region" aria-label="<?php esc_attr_e('Casement opening styles compared', 'fenster'); ?>" tabindex="0">
                <table>
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e('Difference', 'fenster'); ?></th>
                            <?php foreach ($opening_styles as $style) : ?>
                                <th scope="col"><?php echo esc_html($style['name']); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($style_table as $row) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html($row['label']); ?></th>
                                <?php foreach ($row['values'] as $value) : ?>
                                    <td><?php echo esc_html($value); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="fg-cw-gallery" aria-labelledby="fg-cw-gallery-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Real homes', 'fenster'); ?></p>
                    <h2 id="fg-cw-gallery-title"><?php esc_html_e('Liniar casements on real houses.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Stone cottages, brick bays, full elevations and new build. Click any image for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('Swipe through finished installations. Tap any image for a closer look.', 'fenster'); ?></span>
                </p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Casement window gallery', 'fenster'); ?>">
                <?php foreach ($gallery as $index => $image) : ?>
                    <?php
                    $stem = $asset_base . 'gallery/' . $image['file'];
                    $sources = [
                        fenster_generated_url($stem . '-480w.webp') . ' 480w',
                        fenster_generated_url($stem . '-800w.webp') . ' 800w',
                    ];
                    if ((int) $image['width'] >= 1400) {
                        $sources[] = fenster_generated_url($stem . '-1400w.webp') . ' 1400w';
                    }
                    $sources[] = fenster_generated_url($stem . '.webp') . ' ' . (int) $image['width'] . 'w';
                    ?>
                    <figure>
                        <a
                            href="<?php echo esc_url(fenster_generated_url($stem . '.webp')); ?>"
                            data-fg-gallery-lightbox
                            aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $image['alt'])); ?>"
                        >
                            <img
                                src="<?php echo esc_url(fenster_generated_url($stem . '-800w.webp')); ?>"
                                srcset="<?php echo esc_attr(implode(', ', $sources)); ?>"
                                sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '38vw' : '20vw'; ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>"
                                loading="lazy"
                                style="object-position: <?php echo esc_attr($image['focus']); ?>;"
                            >
                            <figcaption><?php echo esc_html($image['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>

            <p class="fg-cw-gallery__hint" aria-hidden="true"><?php esc_html_e('Swipe to explore', 'fenster'); ?> <span>&rarr;</span></p>
        </div>
    </section>

    <section class="fg-cw-cta" aria-label="<?php esc_attr_e('Casement window quote options', 'fenster'); ?>">
        <div class="container">
            <div class="fg-cw-cta__panel">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Your project', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Ready to price your casement windows?', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Get an instant figure from the quote tool, or have us come and measure up properly.', 'fenster'); ?></p>
                </div>
                <div class="fg-cw-cta__actions">
                    <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get a casement quote', 'fenster'); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a survey', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>



    <?php
    // Rendered here rather than by generated-page.php so the banner sits with
    // the construction section instead of stacking on the spec strip.
    get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('casement-windows'));
    ?>

    <section class="fg-cw-frame" aria-labelledby="fg-cw-frame-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <div class="fg-cw-tiles">
                <figure class="fg-cw-tiles__wide">
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-energyplus-thermal-600w.webp')); ?>"
                        alt="<?php esc_attr_e('Cutaway of the six-chamber Liniar EnergyPlus profile with a thermal overlay', 'fenster'); ?>"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                    <figcaption><?php esc_html_e('Six-chamber profile', 'fenster'); ?></figcaption>
                </figure>
                <figure class="fg-cw-tiles__narrow">
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-detail-1600w.webp')); ?>"
                        alt="<?php esc_attr_e('Casement window opened on its hinges with the handle and gearing visible', 'fenster'); ?>"
                        loading="lazy"
                        width="1600"
                        height="1068"
                    >
                    <figcaption><?php esc_html_e('Sash and seal', 'fenster'); ?></figcaption>
                </figure>
            </div>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Inside the frame', 'fenster'); ?></p>
                <h2 id="fg-cw-frame-title"><?php esc_html_e('Where the warmth actually comes from.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Three things do the work, and only one of them is the profile.', 'fenster'); ?></p>
                <dl class="fg-cw-list">
                    <?php foreach ($frame_points as $point) : ?>
                        <div>
                            <dt><?php echo esc_html($point['title']); ?></dt>
                            <dd><?php echo esc_html($point['copy']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>
        </div>
    </section>

    <section class="fg-cw-spec" aria-labelledby="fg-cw-spec-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Glass, locking and hardware', 'fenster'); ?></p>
                <h2 id="fg-cw-spec-title"><?php esc_html_e('Four decisions we make at the survey.', 'fenster'); ?></h2>
                <p><?php esc_html_e('None of these can be settled properly from a website, which is why we come and look before anything is drawn.', 'fenster'); ?></p>
                <dl class="fg-cw-list">
                    <?php foreach ($spec_points as $point) : ?>
                        <div>
                            <dt><?php echo esc_html($point['title']); ?></dt>
                            <dd><?php echo esc_html($point['copy']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <p class="fg-cw-links">
                    <a class="fg-cw-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Obscure glass patterns', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo esc_url(home_url('/window-handles/')); ?>"><?php esc_html_e('Handle finishes', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-cw-media fg-cw-media--tall">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-installation-900w.webp')); ?>"
                    alt="<?php esc_attr_e('Fenster installer fitting a new uPVC window frame into a brick opening', 'fenster'); ?>"
                    loading="lazy"
                    width="900"
                    height="600"
                >
                <figcaption><?php esc_html_e('Our own installers', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-cw-finish" aria-labelledby="fg-cw-finish-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Colour', 'fenster'); ?></p>
                    <h2 id="fg-cw-finish-title"><?php esc_html_e('Sixteen colours, and eight of them here.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('A uPVC colour is a foil bonded to the profile at the factory, so it has a grain you can feel and never needs repainting. You can have a different colour inside and out.', 'fenster'); ?></p>
            </div>

            <ul class="fg-cw-swatches">
                <?php foreach ($swatches as $swatch) : ?>
                    <li>
                        <img
                            src="<?php echo esc_url(fenster_generated_url($swatch_base . $swatch['file'])); ?>"
                            alt=""
                            loading="lazy"
                            aria-hidden="true"
                        >
                        <span><?php echo esc_html($swatch['name']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="fg-cw-foot">
                <?php esc_html_e('None of these look the same on a screen as they do on a sample, so ask us to bring the ones you are considering.', 'fenster'); ?>
                <?php // /upvc-colours/ is 301'd to /colour-options/ in fenster_redirect_target(); link straight there. ?>
                <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('See all uPVC colours', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-cw-related" aria-labelledby="fg-cw-related-title">
        <div class="container">
            <div class="fg-cw-copy fg-cw-copy--lead">
                <p class="eyebrow"><?php esc_html_e('Nearby styles', 'fenster'); ?></p>
                <h2 id="fg-cw-related-title"><?php esc_html_e('Three windows worth comparing first.', 'fenster'); ?></h2>
            </div>
            <div class="fg-cw-related__grid">
                <?php foreach ($related as $item) : ?>
                    <a href="<?php echo esc_url(home_url($item['url'])); ?>">
                        <h3><?php echo esc_html($item['name']); ?></h3>
                        <p><?php echo esc_html($item['copy']); ?></p>
                        <span class="fg-cw-link"><?php echo esc_html($item['view']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php
// The .fg-cw wrapper closes here on purpose. Its base type rules are (0,1,1)
// and would otherwise repaint the shared quote, enquiry, review and FAQ
// components, which put ink-coloured headings on the dark enquiry panel.
?>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Your sizes, your finishes, a real figure in minutes. Survey confirms the layout, glass and hardware before anything is made.', 'fenster'); ?></p>
                </div>
                <article class="fg-product-quote-embed__card" data-quote-card>
                    <div class="fg-product-quote-embed__bar">
                        <h3><?php esc_html_e('uPVC window quote tool', 'fenster'); ?></h3>
                        <div class="fg-product-quote-embed__actions">
                            <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                            <a class="button" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                            <a class="button fg-product-quote-embed__mobile-open" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                        </div>
                    </div>
                    <div class="fg-product-quote-embed__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="near">
                        <div class="fg-quote-frame-placeholder fg-product-quote-embed__placeholder">
                            <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                            <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                        </div>
                        <iframe data-quote-iframe-src="<?php echo esc_url($quote_url); ?>" title="<?php echo esc_attr($quote_label . ' instant quote tool'); ?>" loading="lazy" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </article>
            </div>
        </section>
    <?php endif; ?>

    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <section class="fg-product-faq" aria-labelledby="fg-cw-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cw-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('All of these refer to the 70mm Liniar EnergyPlus system on this page.', 'fenster'); ?></p>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer"><p><?php echo esc_html($faq['answer']); ?></p></div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us about the windows.', 'fenster'); ?></h2>
                <p><?php esc_html_e('How many, what sort of property, and the main reason for replacing them. That is enough to start with.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?>"><?php echo esc_html((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => 'Casement Windows',
                'button_label' => 'Send my casement details',
                'project_type' => 'Casement windows',
                'lock_project_type' => true,
                'compact' => true,
            ]);
            ?>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--product',
        'eyebrow' => 'Customer proof',
        'title' => 'What Milton Keynes homeowners say',
        'copy' => 'Real reviews from real installations across Milton Keynes and the surrounding towns.',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>
