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

// The page hero already uses casement-stone-cottage-1600w.webp. Every image
// below is used exactly once.
$layout_points = [
    ['name' => 'Side-hung', 'copy' => 'Friction stays hold the sash at any angle. Bedrooms get egress hinges, which swing to 90 degrees so the opening meets the Building Regulations escape minimum: 0.33m², at least 450mm each way.'],
    ['name' => 'Top-hung', 'copy' => 'Hinged in the top rail with the handle on the bottom one. The open sash sheds rain clear of the opening, and a restrictor holds the first opening to around 100mm where children sleep.'],
    ['name' => 'Fixed pane', 'copy' => 'No hinges, gearing or handle, so it costs less than an opener the same size and holds more glass. Ventilation and escape come from the openers around it.'],
    ['name' => 'Mixed layout', 'copy' => 'All three share one outer frame. Transom and mullion positions decide whether the glass lines up, so we draw the elevation with every sightline marked before anything is ordered.'],
];

$anatomy_items = [
    ['name' => 'Six chambers', 'copy' => 'Six sealed air pockets run the length of every frame section. Each one interrupts the route heat takes through the uPVC; on our listed specification the whole window comes out at 0.95 W/m²K, A+ rated.'],
    ['name' => 'Co-extruded gasket', 'copy' => 'The weather seal is formed with the profile as it is extruded, not pushed into a groove afterwards. It cannot shrink back or fall out at a corner, which is where pushed-in gaskets fail.'],
    ['name' => 'Reinforcement', 'copy' => 'Sized for each window, so a large dark sash on an exposed elevation is stiffened differently from a small white one in a sheltered wall.'],
    ['name' => 'The sealed unit', 'copy' => 'Panes, coatings, argon fill and a warm-edge spacer decide most of the whole-window figure. A 28mm double or a 36mm triple unit, with the triple reaching 0.95 W/m²K; the number we agree follows your glass, not the brochure.'],
    ['name' => 'Installation', 'copy' => 'Fixing, sealing and finishing are what connect a tested window to your actual wall. Our own installers do it, which is why the guarantee below is ours to give.'],
];

$spec_points = [
    ['title' => 'Glass', 'copy' => 'Warmth, privacy, noise and security do not point at the same sealed unit. Triple glazing on its own is not automatically the quietest answer.'],
    ['title' => 'Locking', 'copy' => 'Multi-point locking, reinforcement sized for the window, and PAS 24 or Secured by Design where you want it. Those approvals belong to a tested window, not to a profile name.'],
    ['title' => 'Handles', 'copy' => 'S2 Signature handles, finished to match the frame, with restrictors where they are sensible.'],
    ['title' => 'Ventilation', 'copy' => 'Trickle vents and background ventilation are set at survey, alongside handle reach and how far the sash swings outside.'],
];

// Mosaic order matters: the first image takes the large portrait cell, so it
// needs a focal point or a landscape source loses its subject to the crop.
$gallery = [
    ['file' => 'casement-bolbeck-park', 'width' => 1000, 'focus' => '50% 40%', 'caption' => 'Bolbeck Park, Milton Keynes', 'alt' => 'Anthracite Liniar casement windows stacked on a corner elevation in Bolbeck Park, fitted by Fenster'],
    ['file' => 'casement-stone-elevation', 'width' => 1200, 'focus' => '50% 45%', 'caption' => 'White casements across a full elevation', 'alt' => 'White uPVC casement windows across the front elevation and dormers of a stone house'],
    ['file' => 'casement-brick-bay', 'width' => 1400, 'focus' => '40% 50%', 'caption' => 'Casements in a bay', 'alt' => 'White uPVC casement windows with glazing bars set into a brick bay'],
    ['file' => 'casement-leighton-buzzard', 'width' => 1400, 'focus' => '50% 55%', 'caption' => 'Leighton Buzzard', 'alt' => 'White Liniar casement windows fitted by Fenster across a Leighton Buzzard terrace'],
    ['file' => 'casement-cottage-arch', 'width' => 1200, 'focus' => '76% 50%', 'caption' => 'Arched head on a stone cottage', 'alt' => 'Grey uPVC casement windows with an arched head in a stone cottage elevation'],
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
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => '0.95 W/m²K, with the 36mm triple glazed unit, which makes it an A+ window. Size, layout, glass and reinforcement all move the complete-window figure, so the number we agree follows your final specification rather than a brochure.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options. PAS 24 is the standard Part Q calls for on new dwellings and some extensions, so if your build is covered by it, say so early and we will specify to it. Those approvals belong to a tested complete window rather than to the profile name, so we confirm what applies to your configuration.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'Yes. The 70mm frame takes a 28mm double glazed unit or a 36mm triple. Whether triple is worth it depends on the sash size, the weight and what you are actually trying to improve, so we will compare it with you rather than treating it as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Liniar publish around 33 decibels for a standard double glazed unit and up to 37 decibels, rated 37 (-2;-5), where the window is built for acoustics. Reaching the higher figure is the glass doing the work rather than the frame. Pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen. The colour you pick is the external face, with the same colour or smooth white on the inside. Liniar publish a wider foil catalogue, but availability, lead time and cost depend on the exact profile and the fabricator, so we confirm before you order.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, though an exact copy is not always the best answer. At survey we check escape, ventilation, handle reach, outside clearance and how the sightlines sit before the drawing is signed off.'],
    ['question' => 'What guarantee comes with them?', 'answer' => 'Two separate ones. Liniar guarantee the frame for ten years, and we guarantee our installation for ten years. They cover different things and come from different people, which is worth knowing if something ever needs putting right.'],
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
                <?php
                /* This section used to open by defining the hinge types and
                   listing side-hung, top-hung and fixed lights, which is
                   precisely what the Opening styles section below does in
                   detail. It now says what the window is and why we fit it, and
                   leaves the mechanics to that section.

                   It stays out of the anatomy section's territory too: chambers,
                   gaskets and the sealed unit explain how the 0.95 figure is
                   reached, so the figure is claimed once here and explained
                   there rather than argued twice. */
                ?>
                <h2 id="fg-cw-intro-title"><?php esc_html_e('The most popular window in the country, and the most adaptable.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Casement is the window most UK homes already have, and the one that adapts to the widest range of openings. Every window is made to measure, so the same system covers a small bathroom light, a full bay across the front and everything in between.', 'fenster'); ?></p>
                <p><?php esc_html_e('We fit the 70mm Liniar EnergyPlus system on every casement. It is what we specify as standard rather than an upgrade tier, and on our listed specification the finished window reaches 0.95 W/m²K, which makes it A+ rated.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Made to measure, from a single light to a full bay', 'fenster'); ?></li>
                    <li><?php esc_html_e('Sixteen external colours, with smooth white or the same colour inside', 'fenster'); ?></li>
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

    <?php
    /* Rendered here rather than by generated-page.php, which would stack it on
       the spec strip immediately under the hero. It used to sit further down
       with the construction section, but at 32% of an 11,000px page it arrived
       long after the claim it backs up. The intro directly above now leads on
       EnergyPlus being what we fit as standard, so the banner belongs against
       that rather than three sections later. */
    get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('casement-windows'));
    ?>

    <section id="casement-opening-styles" class="fg-cw-layouts" aria-labelledby="fg-cw-layouts-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--tall">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-leighton-front-1400w.webp')); ?>"
                    alt="<?php esc_attr_e('White Liniar casement window with opening and fixed lights, fitted by Fenster in Leighton Buzzard', 'fenster'); ?>"
                    loading="lazy" width="1400" height="1050">
                <figcaption><?php esc_html_e('Leighton Buzzard', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Opening styles', 'fenster'); ?></p>
                <h2 id="fg-cw-layouts-title"><?php esc_html_e('Four layouts, four different jobs.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The names are obvious; the hardware is the actual difference. This Leighton Buzzard window uses three of the four.', 'fenster'); ?></p>
                <dl class="fg-cw-list">
                    <?php foreach ($layout_points as $point) : ?>
                        <div>
                            <dt><?php echo esc_html($point['name']); ?></dt>
                            <dd><?php echo esc_html($point['copy']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>
        </div>
    </section>

    <section class="fg-cw-details" aria-labelledby="fg-cw-details-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The moving parts', 'fenster'); ?></p>
                <h2 id="fg-cw-details-title"><?php esc_html_e('Look at the stays and the seal.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Every opener rides on stainless friction stays like these. Easy-clean versions let the sash slide along its track, so you can reach the outside of the glass from indoors on an upper floor.', 'fenster'); ?></p>
                <p><?php esc_html_e('The black line around the sash is the co-extruded gasket, formed with the profile rather than pushed into a groove afterwards. Hinges, gearing and locking are specified window by window at survey.', 'fenster'); ?></p>
            </div>
            <div class="fg-cw-tiles fg-cw-tiles--pair">
                <figure>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-friction-stay-1200w.webp')); ?>"
                        alt="<?php esc_attr_e('Friction stay holding a white uPVC casement sash open', 'fenster'); ?>"
                        loading="lazy" width="1200" height="823">
                    <figcaption><?php esc_html_e('Friction stay', 'fenster'); ?></figcaption>
                </figure>
                <figure>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-top-hinge-1200w.webp')); ?>"
                        alt="<?php esc_attr_e('Top rail hinge and gasket on an open white uPVC casement sash', 'fenster'); ?>"
                        loading="lazy" width="1200" height="823">
                    <figcaption><?php esc_html_e('Top rail hinge', 'fenster'); ?></figcaption>
                </figure>
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
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Bolbeck Park and Leighton Buzzard are our own installs; the rest are Liniar photography of the same system. Click any image for a closer look.', 'fenster'); ?></span>
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
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free survey', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>



    <section class="fg-cw-anatomy" aria-labelledby="fg-cw-anatomy-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Inside the frame', 'fenster'); ?></p>
                    <h2 id="fg-cw-anatomy-title"><?php esc_html_e('What is inside an EnergyPlus frame.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The cutaway is the actual profile. Open a part to see the job it does.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-anatomy__explorer" data-fg-anatomy>
                <figure class="fg-cw-anatomy__media">
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-energyplus-thermal-600w.webp')); ?>"
                        alt="<?php esc_attr_e('Cutaway of the six-chamber Liniar EnergyPlus profile with a thermal overlay', 'fenster'); ?>"
                        loading="lazy" width="600" height="400">
                </figure>
                <ol class="fg-cw-anatomy__items">
                    <?php foreach ($anatomy_items as $item_index => $item) : ?>
                        <?php $item_id = 'fg-cw-anatomy-' . $item_index; ?>
                        <li class="fg-cw-anatomy__item">
                            <h3>
                                <button
                                    type="button"
                                    class="fg-cw-anatomy__toggle"
                                    data-fg-anatomy-toggle
                                    aria-expanded="<?php echo $item_index === 0 ? 'true' : 'false'; ?>"
                                    aria-controls="<?php echo esc_attr($item_id); ?>">
                                    <span class="fg-cw-anatomy__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $item_index + 1)); ?></span>
                                    <span class="fg-cw-anatomy__name"><?php echo esc_html($item['name']); ?></span>
                                    <span class="fg-cw-anatomy__mark" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="fg-cw-anatomy__body" id="<?php echo esc_attr($item_id); ?>" <?php echo $item_index === 0 ? '' : 'hidden'; ?>>
                                <p><?php echo esc_html($item['copy']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
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
                    <a class="fg-cw-link" href="<?php echo esc_url(home_url('/handle-options/')); ?>"><?php esc_html_e('Handle finishes', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('All sixteen colours', 'fenster'); ?></a>
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

    <?php get_template_part('template-parts/components/upvc-colour-grid', null, ['product_noun' => 'casement window']); ?>

    <?php get_template_part('template-parts/components/handle-grid', null, fenster_window_handle_grid_args()); ?>

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

    <?php if (function_exists('fenster_case_studies_for_product')) : ?>
        <?php $cw_case_cards = fenster_case_studies_for_product('casement-windows', 3); ?>
        <?php if ($cw_case_cards !== []) : ?>
            <section class="fg-cs-strip">
                <div class="container">
                    <div class="fg-cs-strip__head">
                        <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Three casement jobs, photographed on the day.', 'fenster'); ?></h2>
                    </div>
                    <div class="fg-cs-strip__grid">
                        <?php foreach ($cw_case_cards as $cw_case_card) : ?>
                            <?php
                            get_template_part('template-parts/components/case-study-card', null, [
                                'card' => $cw_case_card,
                                'heading' => 'h3',
                            ]);
                            ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="button-row fg-cs-strip__cta">
                        <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

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
