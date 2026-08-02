<?php
/**
 * Heritage aluminium doors conversion page.
 *
 * Product information is a rewritten summary of the Sheerline Classic Heritage
 * Door specification. Runtime assets are local theme copies; nothing here
 * depends on the supplier scrape export.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$quote_url = (string) ($args['quote_url'] ?? '');
$quote_label = (string) ($args['quote_label'] ?? 'Heritage Aluminium Doors');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
// Where the pricing buttons point: the embed when the tool is available for
// this route, the shared quote page when it is not.
$quote_link = $quote_url !== '' ? '#fenster-product-quote' : home_url('/online-quote/');

$asset_path = static function (string $path): string {
    return '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/' . $path;
};
$asset = static function (string $path) use ($asset_path): string {
    return fenster_generated_url($asset_path($path));
};

/* The Classic Heritage Door turntable. It was already mapped to this route in
   fenster_product_scroll_videos() and had simply never been rendered, because
   this template returns before the generic product journey that reads it.

   Deliberately not the bifold treatment: that one flies the video across the
   page from a slot beside the hero, and the owner asked for the scrub without
   the travel. It scrubs in place from its own position in the viewport. */
$turntable_sources = function_exists('fenster_product_scroll_video_sources_for_slug')
    ? fenster_product_scroll_video_sources_for_slug('heritage-aluminium-doors')
    : [];

$door_configurations = [
    ['leaf' => 'Single door', 'bars' => 'No bars', 'colour' => 'Anthracite Grey', 'image' => 'config-01-single-no-bars-anthracite.webp'],
    ['leaf' => 'Single door', 'bars' => '2 bar', 'colour' => 'Pure White', 'image' => 'config-02-single-2-bar-pure-white.webp'],
    ['leaf' => 'Single door', 'bars' => '4 bar', 'colour' => 'Jet Black', 'image' => 'config-03-single-4-bar-jet-black.webp'],
    ['leaf' => 'French doors', 'bars' => 'No bars', 'colour' => 'Agate Grey', 'image' => 'config-07-french-no-bars-agate-grey.webp'],
    ['leaf' => 'French doors', 'bars' => '2 bar', 'colour' => 'Cream', 'image' => 'config-08-french-2-bar-cream.webp'],
    ['leaf' => 'French doors', 'bars' => '4 bar', 'colour' => 'Silver Metallic', 'image' => 'config-09-french-4-bar-silver-metallic.webp'],
];

/* Gallery order matters: the first image takes the large cell, so it needs a
   focal point or the crop loses the door.

   Only genuinely photographic shots are here. The cutout doors on white in
   assets/images/imported are product renders, and the configurations carousel
   below already shows those; putting them in a gallery headed "real homes"
   would be a claim the picture cannot support. */
$door_gallery = [
    ['file' => 'heritage-wolverton', 'width' => 1050, 'focus' => '50% 50%', 'caption' => 'Wolverton', 'alt' => 'Black heritage aluminium French doors with a toplight, fitted by Fenster to a Victorian terrace in Wolverton'],
    ['file' => 'heritage-northampton', 'width' => 1080, 'focus' => '50% 50%', 'caption' => 'Northampton', 'alt' => 'Black heritage aluminium doors and a roof lantern fitted by Fenster on a Northampton extension'],
    ['file' => 'heritage-french-open', 'width' => 1400, 'focus' => '68% 50%', 'caption' => 'French doors open to a courtyard', 'alt' => 'Black heritage aluminium French doors standing open onto a planted courtyard'],
    ['file' => 'heritage-lever-handles', 'width' => 886, 'focus' => '50% 50%', 'caption' => 'Lever handles', 'alt' => 'Lever handles on a pair of black heritage aluminium doors'],
];

$door_colours = [
    ['name' => 'Pure White', 'ref' => 'RAL 9010 Matt', 'image' => 'pure-white.webp'],
    ['name' => 'Hipca Gloss White', 'ref' => 'RAL 9910 Gloss', 'image' => 'gloss-white.webp'],
    ['name' => 'Anthracite Grey', 'ref' => 'RAL 7016 Matt', 'image' => 'anthracite-grey.webp'],
    ['name' => 'Jet Black', 'ref' => 'RAL 9005 Matt', 'image' => 'jet-black.webp'],
    ['name' => 'Cream', 'ref' => 'RAL 9001 Matt', 'image' => 'cream.webp'],
    ['name' => 'Agate Grey', 'ref' => 'RAL 7038 Matt', 'image' => 'agate-grey.webp'],
    ['name' => 'Squirrel Grey', 'ref' => 'RAL 7000 Matt', 'image' => 'squirrel-grey.webp'],
    ['name' => 'Pastel Turquoise', 'ref' => 'RAL 6034 Matt', 'image' => 'pastel-turquoise.webp'],
    ['name' => 'Chocolate Brown', 'ref' => 'RAL 8017 Matt', 'image' => 'chocolate-brown.webp'],
    ['name' => 'Silver Metallic', 'ref' => 'Metallic effect', 'image' => 'silver-metallic.webp'],
    ['name' => 'Mid Bronze Metallic', 'ref' => 'Metallic effect', 'image' => 'mid-bronze-metallic.webp'],
    ['name' => 'Black Metallic', 'ref' => 'Metallic effect', 'image' => 'black-metallic.webp'],
];
?>

<main id="main-content" class="fg-heritage-door-page">
    <article>
        <?php
        /* The shared full-bleed hero, the same one every other product route
           uses, rather than this page's old boxed-image hero. Owner asked for
           it to match. .fg-hero--compact hides .fg-hero__intro by design, which
           is why the lead paragraph moves out to its own block below rather
           than staying here where it would be marked up but never seen. */
        ?>
        <section class="fg-hero fg-hero--compact">
            <img <?php echo fenster_image_attr_string($asset_path('hero/heritage-door-brick-1760w.webp'), [
                'class' => 'fg-hero__image',
                'alt' => __('Black Sheerline heritage aluminium French doors in a red brick courtyard', 'fenster'),
                'loading' => 'eager',
                'fetchpriority' => 'high',
                'srcset' => implode(', ', [
                    $asset('hero/heritage-door-brick-800w.webp') . ' 800w',
                    $asset('hero/heritage-door-brick-1200w.webp') . ' 1200w',
                    $asset('hero/heritage-door-brick-1760w.webp') . ' 1760w',
                ]),
                'sizes' => '100vw',
            ]); ?>>
            <div class="fg-hero__shade"></div>
            <div class="container fg-hero__inner">
                <div class="fg-hero__copy">
                    <div class="fg-hero__heading">
                        <p class="eyebrow"><?php esc_html_e('Heritage aluminium doors in Milton Keynes', 'fenster'); ?></p>
                        <h1><?php esc_html_e('Sheerline heritage aluminium doors', 'fenster'); ?></h1>
                    </div>
                    <div class="button-row">
                        <?php
                        /* Casement's pairing: consultation leads in the hero and
                           the pricing route follows, with the intro box below
                           reversing it. The second button is a quote request
                           rather than instant pricing, because heritage doors
                           are not on the instant quote tool, which the enquiry
                           section further down states outright.

                           Full and short labels as casement, so the long label
                           does not wrap on a phone; .fg-hero--compact swaps them
                           at 860px. */
                        ?>
                        <a class="button" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">
                            <span class="fg-hero-cta__full"><?php esc_html_e('Start your design consultation', 'fenster'); ?></span>
                            <span class="fg-hero-cta__short"><?php esc_html_e('Design consultation', 'fenster'); ?></span>
                        </a>
                        <a class="button button--light" href="<?php echo esc_url($quote_link); ?>"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
                    </div>
                </div>
            </div>
        </section>

        <?php
        /* The shared specification strip, the same component casement puts
           under its hero. This page had its own four-cell grid with no label
           block, which is why it read as a different thing sitting in the same
           place. Label and value only, as the component does; the qualifying
           sentences the old grid carried are made again in the sections that
           own them. */
        ?>
        <section class="fg-product-pulse fg-product-pulse--usps" aria-label="<?php esc_attr_e('Heritage aluminium door key specifications', 'fenster'); ?>">
            <div class="container fg-product-pulse__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Key specifications', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Sheerline Classic Heritage Door', 'fenster'); ?></h2>
                </div>
                <ul aria-label="<?php esc_attr_e('Four product specifications', 'fenster'); ?>">
                    <li><small><?php esc_html_e('Sightlines', 'fenster'); ?></small><strong><?php esc_html_e('60.5mm', 'fenster'); ?></strong></li>
                    <li><small><?php esc_html_e('U-value', 'fenster'); ?></small><strong><?php esc_html_e('1.4 W/m²K', 'fenster'); ?></strong></li>
                    <li><small><?php esc_html_e('Max sash size', 'fenster'); ?></small><strong><?php esc_html_e('2.2m x 1m', 'fenster'); ?></strong></li>
                    <li><small><?php esc_html_e('Opening', 'fenster'); ?></small><strong><?php esc_html_e('In or out', 'fenster'); ?></strong></li>
                </ul>
            </div>
        </section>

        <?php
        /* Built from the casement intro's own markup and classes rather than a
           lookalike: fg-cw carries the eyebrow, heading and figure rules, and
           fg-cw-split, fg-cw-facts, fg-cw-actions and fg-cw-media are shared
           already. Same section, not a copy of it. */
        ?>
        <div class="fg-cw fg-heritage-door-lede">
            <section class="fg-cw-intro" aria-labelledby="fg-heritage-intro-title">
                <div class="container fg-cw-split">
                    <div class="fg-cw-copy">
                        <p class="eyebrow"><?php esc_html_e('The door we fit', 'fenster'); ?></p>
                        <h2 id="fg-heritage-intro-title"><?php esc_html_e('Steel-look proportions, in aluminium that never needs painting.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('We supply and install the Sheerline Classic Heritage Door across Milton Keynes and the surrounding towns. It copies the slim proportions of early twentieth century steel doors, but it is powder-coated aluminium, so it does not rust and it does not need repainting.', 'fenster'); ?></p>
                        <p><?php esc_html_e('Sheerline build their own multi-chamber thermal core into every frame, which is how a door with 60.5mm sightlines still reaches 1.4 W/m²K double glazed. Single or French, with or without glazing bars, opening in or out.', 'fenster'); ?></p>
                        <ul class="fg-cw-facts">
                            <li><?php esc_html_e('Single doors and French doors, with or without glazing bars', 'fenster'); ?></li>
                            <li><?php esc_html_e('Opening measured and checked before anything is ordered', 'fenster'); ?></li>
                            <li><?php esc_html_e('Fitted by our own installers, with a ten year guarantee', 'fenster'); ?></li>
                        </ul>
                        <?php
                        /* Reversed against the hero, as casement does: the hero
                           opens with the consultation and this box leads with
                           the pricing route, then the phone. */
                        ?>
                        <div class="fg-cw-actions">
                            <a class="button" href="<?php echo esc_url($quote_link); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                            <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                        </div>
                    </div>
                    <?php if (! empty($turntable_sources)) : ?>
                        <figure class="fg-cw-media fg-cw-media--turntable">
                            <?php
                            /* No autoplay and no controls: scroll position is the
                               only thing that moves it. With JavaScript off or
                               reduced motion on it stays on the first frame, which
                               is a straight-on shot of the door, so the slot still
                               shows the product rather than an empty box. */
                            ?>
                            <video class="fg-heritage-door-turntable" data-fg-scrub-video muted playsinline preload="metadata" aria-label="<?php esc_attr_e('Sheerline Classic Heritage Door rotating to show its profile', 'fenster'); ?>">
                                <?php foreach ($turntable_sources as $turntable_source) : ?>
                                    <source src="<?php echo esc_url($turntable_source['src']); ?>" type="<?php echo esc_attr($turntable_source['type']); ?>">
                                <?php endforeach; ?>
                            </video>
                            <figcaption><?php esc_html_e('Sheerline Classic Heritage Door', 'fenster'); ?></figcaption>
                        </figure>
                    <?php else : ?>
                        <figure class="fg-cw-media">
                            <img <?php echo fenster_image_attr_string($asset_path('heritage-door-kitchen-1600w.webp'), [
                                'alt' => __('Black heritage aluminium door and side screen looking onto a garden from a green kitchen', 'fenster'),
                                'loading' => 'lazy',
                            ]); ?>>
                            <figcaption><?php esc_html_e('Sheerline Classic Heritage Door', 'fenster'); ?></figcaption>
                        </figure>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <?php
        get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('heritage-aluminium-doors'));
        ?>

        <section id="heritage-door-configurations" class="fg-heritage-door-configurations">
            <div class="container">
                <div class="fg-heritage-door-configurations__heading">
                    <p class="eyebrow"><?php esc_html_e('Configurations', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Two decisions make the door.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('First, single or French. Then how many glazing bars. These six are the stocked combinations. Bar spacing changes the character more than anything else, so it is worth looking at all three.', 'fenster'); ?></p>
                </div>
                <div class="fg-colour-carousel fg-heritage-door-configurations__carousel" data-fg-colour-carousel>
                    <div class="fg-colour-carousel__viewport">
                        <div class="fg-colour-carousel__track" data-fg-colour-carousel-track>
                            <?php foreach ($door_configurations as $configuration) : ?>
                                <article class="fg-colour-carousel__slide fg-heritage-door-configurations__slide" data-fg-colour-slide>
                                    <img src="<?php echo esc_url($asset('configurations/' . $configuration['image'])); ?>" alt="<?php echo esc_attr(sprintf('%1$s heritage aluminium door, %2$s, in %3$s', $configuration['leaf'], strtolower($configuration['bars']), $configuration['colour'])); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('configurations/' . $configuration['image'])); ?>>
                                    <div>
                                        <h3><?php echo esc_html($configuration['leaf']); ?></h3>
                                        <p><?php echo esc_html($configuration['bars'] . ', ' . $configuration['colour']); ?></p>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="fg-colour-carousel__controls">
                        <button type="button" data-fg-colour-prev aria-label="<?php esc_attr_e('Previous heritage door configuration', 'fenster'); ?>">&#8249;</button>
                        <span data-fg-colour-count><?php echo esc_html('01 / ' . sprintf('%02d', count($door_configurations))); ?></span>
                        <button type="button" data-fg-colour-next aria-label="<?php esc_attr_e('Next heritage door configuration', 'fenster'); ?>">&#8250;</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="fg-heritage-door-detail">
            <div class="container fg-heritage-door-detail__grid">
                <div class="fg-heritage-door-detail__copy">
                    <p class="eyebrow"><?php esc_html_e('The period details', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Look at the lockbox and the bars.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Two things separate a heritage door from an ordinary glazed aluminium door. The first is the lockbox, a raised plate around the lock that copies the ironmongery on an original steel door. The second is the bar: stepped rather than flat, so it catches a shadow line the way a real glazing bar does.', 'fenster'); ?></p>
                    <p><?php esc_html_e('Bars come in 25mm and 40mm, flat or stepped. On a cottage we usually go wider and fewer. On a Georgian elevation we go narrower and more, so the panes stay square. We will set the layout out on paper with you before anything is ordered.', 'fenster'); ?></p>
                </div>
                <div class="fg-heritage-door-detail__visuals">
                    <figure class="fg-heritage-door-detail__lockbox">
                        <img src="<?php echo esc_url($asset('heritage-lockbox-900w.webp')); ?>" alt="<?php esc_attr_e('Period-style lockbox and lever handles on a pair of black heritage aluminium doors', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-lockbox-900w.webp')); ?>>
                        <figcaption><?php esc_html_e('Period lockbox', 'fenster'); ?></figcaption>
                    </figure>
                    <figure class="fg-heritage-door-detail__bar">
                        <img src="<?php echo esc_url($asset('heritage-glazing-bar-600w.webp')); ?>" alt="<?php esc_attr_e('Close-up of a stepped glazing bar crossing a heritage aluminium frame', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-glazing-bar-600w.webp')); ?>>
                        <figcaption><?php esc_html_e('Stepped bar', 'fenster'); ?></figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <?php
        /* Reuses the casement gallery component wholesale rather than growing a
           second one: same mosaic, same lightbox, same swipe row on a phone.
           The --heritage modifier only re-cuts the grid, because that mosaic is
           hard-coded for six cells and there are four honest pictures here. */
        ?>
        <section class="fg-cw-gallery fg-cw-gallery--heritage" aria-labelledby="fg-heritage-gallery-title">
            <div class="container">
                <div class="fg-cw-gallery__head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Real homes', 'fenster'); ?></p>
                        <h2 id="fg-heritage-gallery-title"><?php esc_html_e('Heritage doors on real houses.', 'fenster'); ?></h2>
                    </div>
                    <p>
                        <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Wolverton and Northampton are our own installs; the rest is Sheerline photography of the same door. Click any image for a closer look.', 'fenster'); ?></span>
                        <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('Swipe through finished doors. Tap any image for a closer look.', 'fenster'); ?></span>
                    </p>
                </div>

                <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Heritage door gallery', 'fenster'); ?>">
                    <?php foreach ($door_gallery as $index => $image) : ?>
                        <?php
                        $stem = $asset_path('gallery/' . $image['file']);
                        $full_width = (int) $image['width'];
                        $sources = [
                            fenster_generated_url($stem . '-480w.webp') . ' 480w',
                            fenster_generated_url($stem . '-800w.webp') . ' 800w',
                        ];
                        if ($full_width > 1400) {
                            $sources[] = fenster_generated_url($stem . '-1400w.webp') . ' 1400w';
                        }
                        $sources[] = fenster_generated_url($stem . '.webp') . ' ' . $full_width . 'w';
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
                                    sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '40vw' : '28vw'; ?>"
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

        <section class="fg-heritage-door-use">
            <div class="container">
                <div class="fg-heritage-door-use__heading">
                    <p class="eyebrow"><?php esc_html_e('Where they work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Two jobs these doors do well.', 'fenster'); ?></h2>
                </div>
                <div class="fg-heritage-door-use__grid">
                    <article>
                        <figure>
                            <img src="<?php echo esc_url($asset('heritage-french-brick-1400w.webp')); ?>" alt="<?php esc_attr_e('Black heritage aluminium French doors in a red brick courtyard with stone paving', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-french-brick-1400w.webp')); ?>>
                        </figure>
                        <div class="fg-heritage-door-use__copy">
                            <span><?php esc_html_e('Period replacement', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Replacing something original.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('If a house already has steel or slim timber doors, a chunky modern replacement reads wrong from the street. The Classic Heritage Door keeps the frame narrow enough that the opening still looks like it belongs to the house.', 'fenster'); ?></p>
                        </div>
                    </article>
                    <article>
                        <figure>
                            <?php
                            /* The kitchen shot, moved here from the intro slot the
                               turntable now holds. It was this or leaving the
                               courtyard French doors in two places: they were
                               already the gallery's second image, and a photograph
                               used twice on one page reads as a thin library. */
                            ?>
                            <img src="<?php echo esc_url($asset('heritage-door-kitchen-1600w.webp')); ?>" alt="<?php esc_attr_e('Black heritage aluminium door and side screen looking onto a garden from a green kitchen extension', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-door-kitchen-1600w.webp')); ?>>
                        </figure>
                        <div class="fg-heritage-door-use__copy">
                            <span><?php esc_html_e('New extension', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Giving a new room some age.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('On a kitchen or garden room extension the bars do the opposite job. They stop a big glazed opening looking like a shopfront and give the new part of the house something to look at.', 'fenster'); ?></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-heritage-door-frame">
            <div class="container fg-heritage-door-frame__grid">
                <?php
                /* One visual, not two. The corner-cleat photograph was a dark
                   grey mechanical joint sitting under the thermal cut-through
                   and reading as a second, duller version of it. The cleat is
                   still explained in the Patented corner joint point below,
                   which is where that fact belongs. */
                ?>
                <div class="fg-heritage-door-frame__visuals fg-heritage-door-frame__visuals--single">
                    <figure class="fg-heritage-door-frame__thermal">
                        <img src="<?php echo esc_url($asset('heritage-thermlock-900w.webp')); ?>" alt="<?php esc_attr_e('Thermal image cut-through of a Sheerline Classic aluminium frame and sealed glass unit', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-thermlock-900w.webp')); ?>>
                    </figure>
                </div>
                <div class="fg-heritage-door-frame__copy">
                    <p class="eyebrow"><?php esc_html_e('Inside the frame', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Old proportions, current building regulations.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('The reason we sell an aluminium heritage door rather than sourcing a real steel one is straightforward. A genuine steel door is a cold bridge. This one is not.', 'fenster'); ?></p>
                    <dl class="fg-heritage-door-frame__points">
                        <div>
                            <dt><?php esc_html_e('Thermlock thermal break', 'fenster'); ?></dt>
                            <dd><?php esc_html_e('Sheerline use their own multi-chamber thermal break instead of the polyamide strip most aluminium systems use. They put it at close to double the insulation of polyamide. Paired with double glazing it gives the door a 1.4 W/m²K U-value.', 'fenster'); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Patented corner joint', 'fenster'); ?></dt>
                            <dd><?php esc_html_e('The corners are cleated rather than welded, which keeps the frame square. Misaligned corners are the usual reason a slim door starts to bind after a few years.', 'fenster'); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Matches our heritage windows', 'fenster'); ?></dt>
                            <dd>
                                <?php
                                /* "Classic" is Sheerline's name for the system.
                                   The route a customer can actually click is
                                   /heritage-windows/, and that page calls them
                                   heritage windows, so this says the same. */
                                printf(
                                    /* translators: %s: heritage windows page link */
                                    esc_html__('The door was drawn to sit alongside our %s, so the stepped face, colour and bars line up if you are doing the doors and windows together.', 'fenster'),
                                    '<a href="' . esc_url(home_url('/heritage-windows/')) . '">' . esc_html__('heritage windows', 'fenster') . '</a>'
                                );
                                ?>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="fg-heritage-door-security">
            <div class="container fg-heritage-door-security__grid">
                <div class="fg-heritage-door-security__copy">
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Secured by Design, specified door by door.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Secured by Design is the police service\'s own standard, and the Classic Heritage Door meets it. It is a specification you choose, so you can put it exactly where it does the most good.', 'fenster'); ?></p>
                    <p><?php esc_html_e('What a door needs depends on where it sits. A garden door inside a walled courtyard is a different job from a side door onto an unlit alley. A four bar door breaks the glass into five small panes, and a door with no bars is a single sheet at chest height.', 'fenster'); ?></p>
                    <p><?php esc_html_e('So we come and look at the opening: where the door sits, what is behind it, who can see it from the road. You get a straight recommendation for that door, based on what we find.', 'fenster'); ?></p>
                </div>
                <figure class="fg-heritage-door-security__media">
                    <img src="<?php echo esc_url($asset('heritage-french-courtyard-1100w.webp')); ?>" alt="<?php esc_attr_e('Anthracite heritage aluminium French doors beside a matching window on a rendered house', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-french-courtyard-1100w.webp')); ?>>
                </figure>
            </div>
        </section>

        <section id="heritage-door-colours" class="fg-heritage-door-colours">
            <div class="container">
                <div class="fg-heritage-door-colours__heading">
                    <p class="eyebrow"><?php esc_html_e('Colour', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Twelve standard colours, powder coated in the UK.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Anthracite Grey and Jet Black are the two we fit most often, and they sit well against brick and render alike. All twelve are powder coated in the UK on a Qualicoat approved line, so the finish is the same whichever you choose.', 'fenster'); ?></p>
                </div>
                <ul class="fg-heritage-door-colours__grid">
                    <?php foreach ($door_colours as $colour) : ?>
                        <li>
                            <img src="<?php echo esc_url($asset('colours/' . $colour['image'])); ?>" alt="<?php echo esc_attr(sprintf('Sheerline Classic aluminium frame corner in %s', $colour['name'])); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('colours/' . $colour['image'])); ?>>
                            <strong><?php echo esc_html($colour['name']); ?></strong>
                            <span><?php echo esc_html($colour['ref']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-heritage-door-colours__note"><?php esc_html_e('You can have a different colour inside and out with no effect on the lead time, and we can match a colour beyond the twelve if you have something existing to work to. If you have a shade in mind, ask and we will tell you what is possible.', 'fenster'); ?></p>
            </div>
        </section>

        <?php
        /* This route returns before the shared product tail, so it calls the
           handle grid itself, the same way it calls the tech banner above.
           Sits after colour because handle finish is the decision that
           follows frame colour. */
        get_template_part('template-parts/components/handle-grid', null, fenster_door_handle_grid_args());
        ?>

        <?php if (function_exists('fenster_case_studies_for_product')) : ?>
            <?php $heritage_case_cards = fenster_case_studies_for_product('heritage-aluminium-doors', 3); ?>
            <?php if ($heritage_case_cards !== []) : ?>
                <section class="fg-cs-strip">
                    <div class="container">
                        <div class="fg-cs-strip__head">
                            <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                            <?php
                            /* No count in this heading. Casement says "three
                               jobs" because it has three; one study names these
                               doors today, and a number would go stale the
                               moment another is written. */
                            ?>
                            <h2><?php esc_html_e('Heritage doors, photographed on the day.', 'fenster'); ?></h2>
                        </div>
                        <div class="fg-cs-strip__grid">
                            <?php foreach ($heritage_case_cards as $heritage_case_card) : ?>
                                <?php
                                get_template_part('template-parts/components/case-study-card', null, [
                                    'card' => $heritage_case_card,
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

        <?php if ($quote_url !== '') : ?>
            <?php
            /* Heritage doors are on the quote tool as productCollection=12, and
               were the whole time. The route simply never received the URL, so
               the page could not offer the tool and the enquiry copy told
               people it did not exist. Same embed casement uses. */
            ?>
            <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
                <div class="container fg-product-quote-embed__grid">
                    <div class="fg-product-quote-embed__copy">
                        <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Your sizes, your bar layout and your colour, a real figure in minutes. Survey confirms the opening, the swing and the threshold before anything is made.', 'fenster'); ?></p>
                    </div>
                    <article class="fg-product-quote-embed__card" data-quote-card>
                        <div class="fg-product-quote-embed__bar">
                            <h3><?php esc_html_e('Heritage door quote tool', 'fenster'); ?></h3>
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

        <section id="fenster-heritage-door-enquiry" class="fg-heritage-door-enquiry">
            <div class="container fg-heritage-door-enquiry__grid">
                <div class="fg-heritage-door-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us about the opening.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('You can price a heritage door yourself with the tool above. If your opening is awkward, or you would rather talk it through, send the details here instead and we will come back with a figure.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('A photo of the existing door or opening, if there is one', 'fenster'); ?></li>
                        <li><?php esc_html_e('Rough width and height, and whether you want single or French', 'fenster'); ?></li>
                        <li><?php esc_html_e('Anything you already know about the bars, colour or swing', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-heritage-door-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form fg-heritage-door-form',
                        'source' => 'Heritage Aluminium Doors',
                        'button_label' => 'Send enquiry',
                        'project_type' => 'Heritage aluminium doors',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--heritage-door', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
