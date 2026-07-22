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

$asset_path = static function (string $path): string {
    return '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/' . $path;
};
$asset = static function (string $path) use ($asset_path): string {
    return fenster_generated_url($asset_path($path));
};

$door_configurations = [
    ['leaf' => 'Single door', 'bars' => 'No bars', 'colour' => 'Anthracite Grey', 'image' => 'config-01-single-no-bars-anthracite.webp'],
    ['leaf' => 'Single door', 'bars' => '2 bar', 'colour' => 'Pure White', 'image' => 'config-02-single-2-bar-pure-white.webp'],
    ['leaf' => 'Single door', 'bars' => '4 bar', 'colour' => 'Jet Black', 'image' => 'config-03-single-4-bar-jet-black.webp'],
    ['leaf' => 'Single door with toplight', 'bars' => 'No bars', 'colour' => 'Squirrel Grey', 'image' => 'config-04-toplight-single-no-bars-squirrel-grey.webp'],
    ['leaf' => 'Single door with toplight', 'bars' => '2 bar', 'colour' => 'Pastel Turquoise', 'image' => 'config-05-toplight-single-2-bar-pastel-turquoise.webp'],
    ['leaf' => 'Single door with toplight', 'bars' => '4 bar', 'colour' => 'Black Metallic', 'image' => 'config-06-toplight-single-4-bar-black-metallic.webp'],
    ['leaf' => 'French doors', 'bars' => 'No bars', 'colour' => 'Agate Grey', 'image' => 'config-07-french-no-bars-agate-grey.webp'],
    ['leaf' => 'French doors', 'bars' => '2 bar', 'colour' => 'Cream', 'image' => 'config-08-french-2-bar-cream.webp'],
    ['leaf' => 'French doors', 'bars' => '4 bar', 'colour' => 'Silver Metallic', 'image' => 'config-09-french-4-bar-silver-metallic.webp'],
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
        <section class="fg-heritage-door-hero">
            <div class="container fg-heritage-door-hero__grid">
                <div class="fg-heritage-door-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Heritage aluminium doors in Milton Keynes', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Sheerline heritage aluminium doors', 'fenster'); ?></h1>
                    <p class="fg-heritage-door-hero__lead"><?php esc_html_e('We supply and install the Sheerline Classic Heritage Door across Milton Keynes and the surrounding towns. It copies the slim proportions of early twentieth century steel doors, but it is powder-coated aluminium, so it does not rust and it does not need repainting.', 'fenster'); ?></p>
                    <div class="fg-heritage-door-hero__actions">
                        <a class="button" href="#fenster-heritage-door-enquiry"><?php esc_html_e('Get a heritage door quote', 'fenster'); ?></a>
                        <a class="button button--steel" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-heritage-door-hero__reassurance" aria-label="<?php esc_attr_e('Heritage door reassurance', 'fenster'); ?>">
                        <li><?php esc_html_e('Single doors and French doors, with or without glazing bars', 'fenster'); ?></li>
                        <li><?php esc_html_e('Opening measured and checked before anything is ordered', 'fenster'); ?></li>
                        <li><?php esc_html_e('Fitted by our own installers, with a 10 year guarantee', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure class="fg-heritage-door-hero__media">
                    <img src="<?php echo esc_url($asset('heritage-door-kitchen-1600w.webp')); ?>" alt="<?php esc_attr_e('Black heritage aluminium door and side screen looking onto a garden from a green kitchen', 'fenster'); ?>" loading="eager"<?php echo fenster_image_attr_string($asset_path('heritage-door-kitchen-1600w.webp')); ?>>
                    <figcaption><?php esc_html_e('Sheerline Classic Heritage Door', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-heritage-door-brief" aria-label="<?php esc_attr_e('Heritage door specification summary', 'fenster'); ?>">
            <div class="container">
                <div class="fg-heritage-door-brief__grid">
                    <p><strong><?php esc_html_e('60.5mm sightlines', 'fenster'); ?></strong><span><?php esc_html_e('Slim frame faces, so the glass does the work', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('1.4 W/m²K', 'fenster'); ?></strong><span><?php esc_html_e('Double glazed U-value for the door', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('Up to 2.2m x 1m', 'fenster'); ?></strong><span><?php esc_html_e('Maximum sash size per leaf', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('Opens in or out', 'fenster'); ?></strong><span><?php esc_html_e('Set by the room, the threshold and the swing', 'fenster'); ?></span></p>
                </div>
            </div>
        </section>

        <section id="heritage-door-configurations" class="fg-heritage-door-configurations">
            <div class="container">
                <div class="fg-heritage-door-configurations__heading">
                    <p class="eyebrow"><?php esc_html_e('Configurations', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Two decisions make the door.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('First, single or French. Then how many glazing bars, and whether the opening needs a toplight above the door. These nine are the stocked combinations. Bar spacing changes the character more than anything else, so it is worth looking at all three.', 'fenster'); ?></p>
                </div>
                <div class="fg-colour-carousel fg-heritage-door-configurations__carousel" data-fg-colour-carousel>
                    <div class="fg-colour-carousel__viewport">
                        <div class="fg-colour-carousel__track" data-fg-colour-carousel-track>
                            <?php foreach ($door_configurations as $index => $configuration) : ?>
                                <article class="fg-colour-carousel__slide fg-heritage-door-configurations__slide" data-fg-colour-slide>
                                    <img src="<?php echo esc_url($asset('configurations/' . $configuration['image'])); ?>" alt="<?php echo esc_attr(sprintf('%1$s heritage aluminium door, %2$s, in %3$s', $configuration['leaf'], strtolower($configuration['bars']), $configuration['colour'])); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('configurations/' . $configuration['image'])); ?>>
                                    <div>
                                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
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

        <section class="fg-heritage-door-frame">
            <div class="container fg-heritage-door-frame__grid">
                <div class="fg-heritage-door-frame__visuals">
                    <figure class="fg-heritage-door-frame__thermal">
                        <img src="<?php echo esc_url($asset('heritage-thermlock-900w.webp')); ?>" alt="<?php esc_attr_e('Thermal image cut-through of a Sheerline Classic aluminium frame and sealed glass unit', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-thermlock-900w.webp')); ?>>
                    </figure>
                    <figure class="fg-heritage-door-frame__corner">
                        <img src="<?php echo esc_url($asset('heritage-corner-cleat-600w.webp')); ?>" alt="<?php esc_attr_e('Cut-through of the corner cleat that joins a Sheerline Classic frame', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-corner-cleat-600w.webp')); ?>>
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
                            <dt><?php esc_html_e('Matches the Classic windows', 'fenster'); ?></dt>
                            <dd><?php esc_html_e('The door was drawn to sit alongside the Classic window range, so the stepped face, colour and bars line up if you are doing the doors and windows together.', 'fenster'); ?></dd>
                        </div>
                    </dl>
                </div>
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
                            <span><?php esc_html_e('01. Period replacement', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Replacing something original.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('If a house already has steel or slim timber doors, a chunky modern replacement reads wrong from the street. The Classic Heritage Door keeps the frame narrow enough that the opening still looks like it belongs to the house.', 'fenster'); ?></p>
                        </div>
                    </article>
                    <article>
                        <figure>
                            <img src="<?php echo esc_url($asset('heritage-french-open-1400w.webp')); ?>" alt="<?php esc_attr_e('Heritage aluminium French doors opened from a living room onto a courtyard', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path('heritage-french-open-1400w.webp')); ?>>
                        </figure>
                        <div class="fg-heritage-door-use__copy">
                            <span><?php esc_html_e('02. New extension', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Giving a new room some age.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('On a kitchen or garden room extension the bars do the opposite job. They stop a big glazed opening looking like a shopfront and give the new part of the house something to look at.', 'fenster'); ?></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-heritage-door-security">
            <div class="container fg-heritage-door-security__grid">
                <div class="fg-heritage-door-security__copy">
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Secured by Design is an upgrade, not the standard.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Secured by Design is the police service\'s own standard, and the Classic Heritage Door passes it. It does not arrive that way. It is a specification you choose and pay for, and the badge tends to appear on installer websites without that sentence next to it.', 'fenster'); ?></p>
                    <p><?php esc_html_e('Whether you need it depends on the door. A garden door inside a walled courtyard is a different problem from a side door onto an unlit alley. A four bar door breaks the glass into five small panes. A door with no bars is one sheet at chest height.', 'fenster'); ?></p>
                    <p><?php esc_html_e('So we come and look. Where the door sits, what is behind it, who can see it from the road. Then we tell you whether the upgrade is worth your money on that opening, and we are happy to say no.', 'fenster'); ?></p>
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
                    <h2><?php esc_html_e('Twelve standard colours, and most people pick two of them.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Anthracite Grey and Jet Black cover the large majority of heritage doors we fit, which is worth knowing before you spend an evening on the other ten. All twelve are powder coated in the UK on a Qualicoat approved line.', 'fenster'); ?></p>
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
                <p class="fg-heritage-door-colours__note"><?php esc_html_e('You can have a different colour inside and out at no lead-time penalty, and bespoke colours outside the twelve are available if you need to match something existing. Ask us before you assume a colour is not possible.', 'fenster'); ?></p>
            </div>
        </section>

        <section id="fenster-heritage-door-enquiry" class="fg-heritage-door-enquiry">
            <div class="container fg-heritage-door-enquiry__grid">
                <div class="fg-heritage-door-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us about the opening.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Heritage doors are not on the instant quote tool, because the bar layout and the toplight change the price too much to guess at. Send us the details instead and we will come back with a real figure.', 'fenster'); ?></p>
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
