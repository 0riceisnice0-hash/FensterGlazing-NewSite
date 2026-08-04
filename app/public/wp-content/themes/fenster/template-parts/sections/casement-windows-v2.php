<?php
/**
 * Casement windows: 70mm Liniar EnergyPlus product page.
 *
 * Redesigned 2026-08-04 on the owner's brief: more imagery, a reserved slot
 * near the top for the installation film being shot, a personalisation stage
 * in the spirit of Liniar's own customise block, an honest side-by-side with
 * the flush casement, and the opening-styles copy sense-checked against the
 * photograph it sits beside.
 *
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

/* The film slot. The owner is having a real casement installation filmed;
   when the asset lands, drop it under assets/videos/ and set $film_src to its
   theme path. The section then renders an autoplaying muted loop in place of
   the poster, with no other change needed. Until then the poster and the
   "in production" chip keep the slot honest rather than looking unfinished. */
$film_src = '';
$film_poster = $asset_base . 'casement-installation-900w.webp';

/* The personalisation stage. Each option is one real photograph; the shared
   [data-fg-door-selector] controller swaps the stage image, name chip and
   copy line. Thumbs are dedicated 160w files so five chips do not pull five
   full-size images. */
$style_options = [
    [
        'name' => 'Clean and simple',
        'file' => 'casement-leighton-front-1400w',
        'thumb' => 'casement-leighton-front-160w',
        'width' => 1400,
        'height' => 1050,
        'copy' => 'Clear glass and no bars, the slimmest look the system makes. Most modern replacements go out exactly like this.',
        'alt' => 'White uPVC casement window with clear glass in a tile hung elevation',
    ],
    [
        'name' => 'Georgian bars',
        'file' => 'casement-bay-white-1080w',
        'thumb' => 'casement-bay-white-160w',
        'width' => 1080,
        'height' => 608,
        'copy' => 'A bar grid set inside the sealed unit divides the panes without interrupting the glass, so the cottage look wipes clean as one pane.',
        'alt' => 'White uPVC bay window with Georgian bars between the panes',
    ],
    [
        'name' => 'Astragal bars and horns',
        'file' => 'casement-astragal-horn-1250w',
        'thumb' => 'casement-astragal-horn-160w',
        'width' => 1250,
        'height' => 857,
        'copy' => 'Astragal bars sit proud on the glass face, and mock sash horns finish the sash corners, so a casement reads like a period sash window from the street.',
        'alt' => 'Close up of an astragal glazing bar and mock sash horn on a white uPVC window',
    ],
    [
        'name' => 'Leaded glass',
        'file' => 'casement-leaded-bay-1400w',
        'thumb' => 'casement-leaded-bay-160w',
        'width' => 1400,
        'height' => 1120,
        'copy' => 'Lead strip laid over the glass in squares or diamonds, sealed against the weather. It suits bays and older brickwork, and it never needs polishing.',
        'alt' => 'White uPVC bay window with square leaded glass on a red brick house',
    ],
    [
        'name' => 'Two colours, one window',
        'file' => 'casement-broughton-grey-1200w',
        'thumb' => 'casement-broughton-grey-160w',
        'width' => 1200,
        'height' => 900,
        'copy' => 'The colour you choose is the outside face; inside stays smooth white or matches. This Broughton house runs basalt grey out and white in.',
        'alt' => 'Basalt grey uPVC casement window on a Broughton townhouse, fitted by Fenster',
    ],
];

$layout_points = [
    ['name' => 'Side-hung', 'copy' => 'Friction stays hold the sash at any angle. Where a bedroom needs its escape route, egress hinges swing to 90 degrees so the clear opening meets the Building Regulations minimum: 0.33m², at least 450mm each way.'],
    ['name' => 'Top-hung', 'copy' => 'Hinged in the top rail with the handle on the bottom one. The open sash sheds rain clear of the opening, and a restrictor holds the first opening to around 100mm where children sleep.'],
    ['name' => 'Fixed pane', 'copy' => 'No hinges, gearing or handle, so it costs less than an opener the same size and holds more glass. Ventilation and escape come from the openers around it.'],
    ['name' => 'Combinations', 'copy' => 'All three share one outer frame. Transom and mullion positions decide whether the glass lines up, so we draw the elevation with every sightline marked before anything is ordered.'],
];

/* The flush comparison. Marker coordinates are percentages against each
   photograph and are placed by eye on the rendered page; if either image is
   replaced, re-place its markers. */
$versus_cards = [
    [
        'title' => 'Standard casement',
        'line' => 'The one on this page. 28mm double or 36mm triple glazing, down to 0.95 W/m²K, A+ rated.',
        'file' => 'casement-cranfield-1400w',
        'width' => 1400,
        'height' => 1050,
        'alt' => 'White uPVC casement window in Cranfield with a proud sash and a large fixed pane glazed directly into the frame',
        'markers' => [
            ['x' => 68, 'y' => 30, 'copy' => 'The sash stands proud of the frame, the classic stepped casement look.'],
            ['x' => 30, 'y' => 64, 'copy' => 'A fixed pane is glazed straight into the frame, so the border is slimmer and the glass is bigger.'],
        ],
    ],
    [
        'title' => 'Flush casement',
        'line' => '28mm double glazing, 1.2 W/m²K, A+ rated, on its own page.',
        'file' => 'flush-light-grey-stone-1400w',
        'width' => 1400,
        'height' => 933,
        'alt' => 'White Liniar flush casement window in a stone wall with every sash closing level with the frame',
        'asset_base' => '/wp-content/themes/fenster/assets/images/products/flush-casement/',
        'markers' => [
            ['x' => 24, 'y' => 44, 'copy' => 'The sash closes level with the frame, the look of traditional timber joinery.'],
            ['x' => 52, 'y' => 52, 'copy' => 'Fixed lights carry a matching dummy sash, so every pane reads the same.'],
        ],
    ],
];

$versus_rows = [
    ['label' => 'Sash face', 'casement' => 'Stands proud of the frame', 'flush' => 'Closes level with the frame'],
    ['label' => 'Fixed panes', 'casement' => 'Glazed into the frame, the most glass', 'flush' => 'Matched to the openers, equal lines'],
    ['label' => 'Glazing', 'casement' => '28mm double or 36mm triple', 'flush' => '28mm double'],
    ['label' => 'Best whole-window U-value', 'casement' => '0.95 W/m²K, A+ rated', 'flush' => '1.2 W/m²K, A+ rated'],
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
    ['file' => 'casement-anthracite-bay', 'width' => 1600, 'focus' => '50% 45%', 'caption' => 'Anthracite grey bay', 'alt' => 'Anthracite grey uPVC casement bay window with obscured lower panes, fitted by Fenster'],
    ['file' => 'casement-rushden-leaded', 'width' => 1400, 'focus' => '45% 45%', 'caption' => 'Rushden', 'alt' => 'White uPVC casement windows with leaded diamond glazing on a red brick house in Rushden, fitted by Fenster'],
    ['file' => 'casement-stony-stratford', 'width' => 1400, 'focus' => '30% 50%', 'caption' => 'Stony Stratford', 'alt' => 'White uPVC casement windows in a bay on a red brick Victorian terrace in Stony Stratford, fitted by Fenster'],
    ['file' => 'casement-leighton-buzzard', 'width' => 1400, 'focus' => '50% 55%', 'caption' => 'Leighton Buzzard', 'alt' => 'White Liniar casement windows fitted by Fenster across a Leighton Buzzard terrace'],
];

$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'What is the difference between casement and flush casement windows?', 'answer' => 'The sash. On a standard casement it stands slightly proud of the frame, and fixed panes are glazed straight into the frame so they hold more glass. On a flush casement the sash closes level with the frame for a traditional joinery look, with fixed lights matched to the openers so every pane reads the same. Standard takes 28mm double or 36mm triple glazing and reaches 0.95 W/m²K; flush takes 28mm double and reaches 1.2 W/m²K. Both are A+ rated.'],
    ['question' => 'Which Liniar system do you fit?', 'answer' => 'The 70mm Liniar EnergyPlus system, a six-chamber uPVC platform used for both replacement and new-build work. Glass, reinforcement and hardware are confirmed for your individual job.'],
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => '0.95 W/m²K, with the 36mm triple glazed unit, which makes it an A+ window. Size, layout, glass and reinforcement all move the complete-window figure, so the number we agree follows your final specification rather than a brochure.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options. PAS 24 is the standard Part Q calls for on new dwellings and some extensions, so if your build is covered by it, say so early and we will specify to it. Those approvals belong to a tested complete window rather than to the profile name, so we confirm what applies to your configuration.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'Yes. The 70mm frame takes a 28mm double glazed unit or a 36mm triple. Whether triple is worth it depends on the sash size, the weight and what you are actually trying to improve, so we will compare it with you rather than treating it as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Liniar publish around 33 decibels for a standard double glazed unit and up to 37 decibels, rated 37 (-2;-5), where the window is built for acoustics. Reaching the higher figure is the glass doing the work rather than the frame. Pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen. The colour you pick is the external face, with the same colour or smooth white on the inside. Liniar publish a wider foil catalogue, but availability, lead time and cost depend on the exact profile and the fabricator, so we confirm before you order.'],
    ['question' => 'Can I have bars, horns or leaded glass?', 'answer' => 'Yes. Georgian bars sit inside the sealed unit, astragal bars are bonded to the glass face, mock sash horns dress the sash corners, and leaded glass comes in squares or diamonds. All of them are priced with the window rather than added afterwards.'],
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
    <section class="fg-cw-film" aria-labelledby="fg-cw-film-title">
        <div class="container fg-cw-film__grid">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Coming to this page', 'fenster'); ?></p>
                <h2 id="fg-cw-film-title" class="fg-cw-display"><?php esc_html_e('Watch a set of casements go in.', 'fenster'); ?></h2>
                <p><?php esc_html_e('We are filming a real installation with our own fitters, from the first survey measure to the final wipe-down. No actors and no showroom set, just a local house getting its windows done properly.', 'fenster'); ?></p>
                <p><?php esc_html_e('The film will sit right here. Until then, the photographs below are the same honest record, one frame at a time.', 'fenster'); ?></p>
            </div>
            <figure class="fg-cw-film__media">
                <?php if ($film_src !== '') : ?>
                    <video autoplay muted loop playsinline poster="<?php echo esc_url(fenster_generated_url($film_poster)); ?>">
                        <source src="<?php echo esc_url(fenster_generated_url($film_src)); ?>" type="video/mp4">
                    </video>
                <?php else : ?>
                    <img
                        src="<?php echo esc_url(fenster_generated_url($film_poster)); ?>"
                        alt="<?php esc_attr_e('Fenster installer fitting a white uPVC casement window frame in a brick opening', 'fenster'); ?>"
                        loading="lazy" width="900" height="600">
                    <span class="fg-cw-film__chip"><i aria-hidden="true"></i><?php esc_html_e('In production', 'fenster'); ?></span>
                <?php endif; ?>
            </figure>
        </div>
    </section>

    <section class="fg-cw-intro" aria-labelledby="fg-cw-intro-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The system we fit', 'fenster'); ?></p>
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
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-brick-1400w.webp')); ?>"
                    alt="<?php esc_attr_e('White uPVC casement windows opened outwards beside a patio door on a new build brick house', 'fenster'); ?>"
                    loading="lazy"
                    width="1400"
                    height="933"
                >
                <figcaption><?php esc_html_e('70mm Liniar EnergyPlus', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php
    /* Rendered here rather than by generated-page.php, which would stack it on
       the spec strip immediately under the hero. The intro above leads on
       EnergyPlus being what we fit as standard, so the banner belongs against
       that claim. */
    get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('casement-windows'));
    ?>

    <section class="fg-cw-style" aria-labelledby="fg-cw-style-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Make it yours', 'fenster'); ?></p>
                    <h2 id="fg-cw-style-title" class="fg-cw-display"><?php esc_html_e('One window, five different characters.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Bars, horns, lead and colour are chosen per window, not per order. All five of these come out of the same 70mm system.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-style__panel" data-fg-door-selector>
                <figure class="fg-cw-style__stage">
                    <img
                        data-fg-choice-image
                        src="<?php echo esc_url(fenster_generated_url($asset_base . $style_options[0]['file'] . '.webp')); ?>"
                        alt="<?php echo esc_attr($style_options[0]['alt']); ?>"
                        loading="lazy"
                        width="<?php echo esc_attr((string) $style_options[0]['width']); ?>"
                        height="<?php echo esc_attr((string) $style_options[0]['height']); ?>"
                    >
                    <figcaption data-fg-choice-name><?php echo esc_html($style_options[0]['name']); ?></figcaption>
                </figure>
                <div class="fg-cw-style__controls">
                    <div class="fg-cw-style__options" role="group" aria-label="<?php esc_attr_e('Casement window looks', 'fenster'); ?>">
                        <?php foreach ($style_options as $option_index => $option) : ?>
                            <button
                                type="button"
                                class="fg-cw-style__option"
                                data-fg-choice-option
                                aria-pressed="<?php echo $option_index === 0 ? 'true' : 'false'; ?>"
                                data-preview-src="<?php echo esc_url(fenster_generated_url($asset_base . $option['file'] . '.webp')); ?>"
                                data-preview-alt="<?php echo esc_attr($option['alt']); ?>"
                                data-preview-name="<?php echo esc_attr($option['name']); ?>"
                                data-preview-copy="<?php echo esc_attr($option['copy']); ?>"
                            >
                                <img src="<?php echo esc_url(fenster_generated_url($asset_base . $option['thumb'] . '.webp')); ?>" alt="" loading="lazy" width="56" height="56">
                                <span><?php echo esc_html($option['name']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="fg-cw-style__copy" data-fg-choice-copy><?php echo esc_html($style_options[0]['copy']); ?></p>
                    <p class="fg-cw-links">
                        <a class="fg-cw-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('All sixteen colours', 'fenster'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="casement-opening-styles" class="fg-cw-layouts" aria-labelledby="fg-cw-layouts-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--tall">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-leighton-inside-1400w.webp')); ?>"
                    alt="<?php esc_attr_e('White Liniar casement window seen from inside, both side-hung sashes open either side of a fixed centre pane, fitted by Fenster in Leighton Buzzard', 'fenster'); ?>"
                    loading="lazy" width="1400" height="1050">
                <figcaption><?php esc_html_e('Leighton Buzzard', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Opening styles', 'fenster'); ?></p>
                <h2 id="fg-cw-layouts-title"><?php esc_html_e('Four layouts, four different jobs.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The names are obvious; the hardware is the actual difference. This Leighton Buzzard window pairs two side-hung sashes around a fixed centre pane.', 'fenster'); ?></p>
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

    <section class="fg-cw-versus" aria-labelledby="fg-cw-versus-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Casement or flush casement', 'fenster'); ?></p>
                    <h2 id="fg-cw-versus-title" class="fg-cw-display"><?php esc_html_e('Same family, two different faces.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Both are 70mm Liniar uPVC, both come in the same sixteen colours and both are fitted by our own installers. The difference is how the sash meets the frame, and what that does to the glass.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-versus__cards">
                <?php foreach ($versus_cards as $card) : ?>
                    <?php $card_base = $card['asset_base'] ?? $asset_base; ?>
                    <article class="fg-cw-versus__card">
                        <div class="fg-cw-versus__media">
                            <img
                                src="<?php echo esc_url(fenster_generated_url($card_base . $card['file'] . '.webp')); ?>"
                                alt="<?php echo esc_attr($card['alt']); ?>"
                                loading="lazy"
                                width="<?php echo esc_attr((string) $card['width']); ?>"
                                height="<?php echo esc_attr((string) $card['height']); ?>"
                            >
                            <?php foreach ($card['markers'] as $marker_index => $marker) : ?>
                                <span class="fg-cw-versus__marker" style="left: <?php echo esc_attr((string) $marker['x']); ?>%; top: <?php echo esc_attr((string) $marker['y']); ?>%;" aria-hidden="true"><?php echo esc_html((string) ($marker_index + 1)); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <ol class="fg-cw-versus__legend">
                            <?php foreach ($card['markers'] as $marker) : ?>
                                <li><?php echo esc_html($marker['copy']); ?></li>
                            <?php endforeach; ?>
                        </ol>
                        <p class="fg-cw-versus__line"><?php echo esc_html($card['line']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="fg-cw-versus__tablewrap">
                <table class="fg-cw-versus__table">
                    <thead>
                        <tr>
                            <th scope="col"><span class="screen-reader-text"><?php esc_html_e('Specification', 'fenster'); ?></span></th>
                            <th scope="col"><?php esc_html_e('Standard casement', 'fenster'); ?></th>
                            <th scope="col"><?php esc_html_e('Flush casement', 'fenster'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($versus_rows as $row) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html($row['label']); ?></th>
                                <td><?php echo esc_html($row['casement']); ?></td>
                                <td><?php echo esc_html($row['flush']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="fg-cw-versus__actions">
                <p><?php esc_html_e('Whichever you pick, the price comes off the same live list in the quote tool.', 'fenster'); ?></p>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>"><?php esc_html_e('View flush casements', 'fenster'); ?></a>
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

    <section class="fg-cw-gallery" aria-labelledby="fg-cw-gallery-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Real homes', 'fenster'); ?></p>
                    <h2 id="fg-cw-gallery-title"><?php esc_html_e('Liniar casements on real houses.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Five of these six are our own installs, from Bolbeck Park to Rushden; the stone elevation is Liniar photography of the same system. Click any image for a closer look.', 'fenster'); ?></span>
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

    <section class="fg-cw-spec" aria-labelledby="fg-cw-spec-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Glass, locking and hardware', 'fenster'); ?></p>
                <h2 id="fg-cw-spec-title"><?php esc_html_e('Four decisions to make before you price it.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Glass, locking and handles are yours to choose, and the quote tool asks for them as you build the window. Ventilation we set against the regulations. If you would rather talk it through, we go through the options with you at a consultation.', 'fenster'); ?></p>
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
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-sill-interior-1200w.webp')); ?>"
                    alt="<?php esc_attr_e('White uPVC casement window, sill and handle seen from inside a room', 'fenster'); ?>"
                    loading="lazy"
                    width="1200"
                    height="800"
                >
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
