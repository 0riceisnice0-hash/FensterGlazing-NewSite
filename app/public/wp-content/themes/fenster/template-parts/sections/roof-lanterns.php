<?php
/**
 * Roof lantern conversion page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$asset = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/images/products/roof-lanterns/' . $path);
};
$imported = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/images/imported/' . $path);
};
$roof_styles = [
    ['layout' => 'Square', 'style' => 'Style 1', 'colour' => 'Anthracite Grey', 'image' => 'Style-01-Anthracite-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 2', 'colour' => 'Anthracite Grey', 'image' => 'Style-02-Anthracite-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 3', 'colour' => 'Anthracite Grey', 'image' => 'Style-03-Anthracite-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 4', 'colour' => 'Anthracite Grey', 'image' => 'Style-04-Anthracite-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 5', 'colour' => 'Anthracite Grey', 'image' => 'Style-05-Anthracite-800x450.png'],
    ['layout' => 'Square', 'style' => 'Style 6', 'colour' => 'Jet Black', 'image' => 'Style-06-Black-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 7', 'colour' => 'Jet Black', 'image' => 'Style-07-Black-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 8', 'colour' => 'Jet Black', 'image' => 'Style-08-Black-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 9', 'colour' => 'Jet Black', 'image' => 'Style-09-Black-800x450.png'],
    ['layout' => '2-way', 'style' => 'Style 10', 'colour' => 'Pure White', 'image' => 'Style-10-White-800x450.png'],
    ['layout' => '3-way', 'style' => 'Style 11', 'colour' => 'Pure White', 'image' => 'Style-11-White-800x450.png'],
    ['layout' => '3-way', 'style' => 'Style 12', 'colour' => 'Pure White', 'image' => 'Style-12-White-800x450.png'],
    ['layout' => '3-way', 'style' => 'Style 13', 'colour' => 'Pure White', 'image' => 'Style-13-White-800x450.png'],
];
?>

<main id="main-content" class="fg-roof-lantern-page">
    <article>
        <?php
        /* The shared full-bleed hero, as every other product route uses, rather
           than this page's old boxed two-column one. Same change heritage doors
           had on 2026-07-29 and for the same reason: it was the odd page out.

           The photograph is our own Drayton Parslow install with the vents
           open, not one of the Sheerline renders this page used to lead on. The
           old hero was S1-Lantern-Kitchen-A, which is a manufacturer CGI
           visualisation; three of the four wide lantern images in the theme
           are.

           .fg-hero--compact hides .fg-hero__intro by design, so the lead
           paragraph and the reassurance list move to their own block below
           rather than staying here where they would be marked up and never
           seen. */
        ?>
        <section class="fg-hero fg-hero--compact">
            <?php
            /* The same Drayton Parslow job as the still, moving. It reuses the
               generic data-fg-lazy-video controller rather than a new one:
               preload="none", the sources are swapped in on idle, and
               data-fg-video-slow-mode="interaction" holds it back entirely on
               small viewports, constrained connections and reduced motion. That
               is the treatment the homepage hero already has, and the reason
               6.5MB never lands in a phone's initial payload.

               The poster is the 1200w still deliberately, not the 1600w. The
               video is 1280 wide, so poster and video sit at the same effective
               resolution and there is no visible jump when it swaps in. */
            ?>
            <video
                class="fg-hero__video"
                autoplay
                muted
                loop
                playsinline
                preload="none"
                poster="<?php echo esc_url($asset('hero/lantern-drayton-parslow-1200w.webp')); ?>"
                aria-label="<?php esc_attr_e('Sheerline S1 roof lantern with its opening vents raised, fitted by Fenster in Drayton Parslow', 'fenster'); ?>"
                data-fg-lazy-video
                data-fg-video-slow-mode="interaction"
            >
                <source data-src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/videos/case-studies/cs-big-roof-lantern.mp4'); ?>" type="video/mp4">
            </video>
            <div class="fg-hero__shade"></div>
            <div class="container fg-hero__inner">
                <div class="fg-hero__copy">
                    <div class="fg-hero__heading">
                        <p class="eyebrow"><?php esc_html_e('Roof lanterns and roof lights in Milton Keynes', 'fenster'); ?></p>
                        <h1><?php esc_html_e('Sheerline S1 roof lanterns', 'fenster'); ?></h1>
                    </div>
                    <div class="button-row">
                        <a class="button" href="#fenster-roof-lantern-enquiry">
                            <span class="fg-hero-cta__full"><?php esc_html_e('Get a roof lantern quote', 'fenster'); ?></span>
                            <span class="fg-hero-cta__short"><?php esc_html_e('Get a quote', 'fenster'); ?></span>
                        </a>
                        <a class="button button--light" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
            </div>
        </section>

        <?php
        /* The shared key-specification strip, which is what gives this route its
           U-value; it previously carried a bespoke four-fact block and showed no
           U-value at all. Tiles are passed rather than read from product_usps
           for the same reason heritage does it: the usps entry here holds facts
           this page does not lead on, and the S1 system name is already the H1. */
        get_template_part('template-parts/components/product-pulse', null, [
            'slug'  => 'roof-lanterns',
            'title' => __('Sheerline S1 roof lantern', 'fenster'),
            'usps'  => [
                ['label' => __('U-value', 'fenster'), 'value' => __('1.0 W/m²K', 'fenster')],
                ['label' => __('Glazing', 'fenster'), 'value' => __('28mm Activ Blue', 'fenster')],
                ['label' => __('Max size', 'fenster'), 'value' => __('3.2m x 6m', 'fenster')],
                ['label' => __('Ventilation', 'fenster'), 'value' => __('SheerVent option', 'fenster')],
            ],
        ]);
        ?>

        <div class="fg-cw fg-roof-lantern-lede">
            <div class="container">
                <p><?php esc_html_e('We supply and install Sheerline S1 aluminium roof lanterns across Milton Keynes. We check the roof opening, glass specification, ventilation and finish before the lantern is ordered.', 'fenster'); ?></p>
                <ul class="fg-roof-lantern-hero__reassurance" aria-label="<?php esc_attr_e('Roof lantern reassurance', 'fenster'); ?>">
                    <li><?php esc_html_e('Opening measured and checked before order', 'fenster'); ?></li>
                    <li><?php esc_html_e('Glass options for heat, noise and safety', 'fenster'); ?></li>
                    <li><?php esc_html_e('Local installation with aftercare', 'fenster'); ?></li>
                </ul>
            </div>
        </div>

        <?php
        get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('roof-lanterns'));
        ?>

        <section class="fg-roof-lantern-views">
            <div class="container">
                <div class="fg-roof-lantern-views__heading">
                    <p class="eyebrow"><?php esc_html_e('Inside and outside', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Check the lantern from both sides.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('From inside, you see the opening and daylight. From outside, you see the frame, caps and roof finish. We specify both sides together.', 'fenster'); ?></p>
                </div>
                <div class="fg-roof-lantern-views__grid">
                    <figure><img src="<?php echo esc_url($imported('S1-Lantern-by-night-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Low-profile Sheerline roof lantern viewed from a flat roof at dusk', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-by-night-min-scaled.jpg'); ?>><figcaption><?php esc_html_e('Exterior at night', 'fenster'); ?></figcaption></figure>
                    <figure><img src="<?php echo esc_url($imported('S1-Lantern-exterior-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Installed Sheerline aluminium roof lantern viewed across a flat roof', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-exterior-min-scaled.jpg'); ?>><figcaption><?php esc_html_e('Low-line roof finish', 'fenster'); ?></figcaption></figure>
                    <figure><img src="<?php echo esc_url($imported('S1-Lantern-first-installation-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Completed Sheerline roof lantern installation', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-first-installation-min-scaled.jpg'); ?>><figcaption><?php esc_html_e('Completed installation', 'fenster'); ?></figcaption></figure>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-intro">
            <div class="container fg-roof-lantern-intro__grid">
                <figure class="fg-roof-lantern-intro__media">
                    <img src="<?php echo esc_url($imported('S1-Lantern-Lounge-with-LEDs-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Roof lantern above a finished living space', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Lounge-with-LEDs-min-scaled.jpg'); ?>>
                </figure>
                <div class="fg-roof-lantern-intro__copy">
                    <p class="eyebrow"><?php esc_html_e('Getting the specification right', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Start with the room and roof opening.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('We look at the opening size, where daylight will fall, the direction the room faces and the surrounding windows and doors. We then use that information to specify the glass, ventilation, frame colour and proportions.', 'fenster'); ?></p>
                    <ol class="fg-roof-lantern-intro__steps">
                        <li><strong><?php esc_html_e('01. Position', 'fenster'); ?></strong><span><?php esc_html_e('Set the opening size and position around the room below and the roof structure above.', 'fenster'); ?></span></li>
                        <li><strong><?php esc_html_e('02. Comfort', 'fenster'); ?></strong><span><?php esc_html_e('Choose glass and ventilation for the direction the room faces and how you use it.', 'fenster'); ?></span></li>
                        <li><strong><?php esc_html_e('03. Finish', 'fenster'); ?></strong><span><?php esc_html_e('Confirm the frame colour and sightlines before the lantern is ordered.', 'fenster'); ?></span></li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-system">
            <div class="container fg-roof-lantern-system__grid">
                <div class="fg-roof-lantern-system__copy">
                    <p class="eyebrow"><?php esc_html_e('The S1 system', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Slim outside. Insulated through the frame.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Sheerline S1 uses low-line external caps and aligned corner details to keep the outside profile slim. Inside the aluminium frame, Thermlock multi-chamber technology works with 28mm glazing to improve insulation.', 'fenster'); ?></p>
                    <dl class="fg-roof-lantern-system__points">
                        <div><dt><?php esc_html_e('Low-line caps', 'fenster'); ?></dt><dd><?php esc_html_e('The rafter and hip caps sit close to the glazing to reduce the outside profile.', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Thermlock technology', 'fenster'); ?></dt><dd><?php esc_html_e('The multi-chamber construction reduces heat transfer through the frame.', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Checked before order', 'fenster'); ?></dt><dd><?php esc_html_e('We confirm the size, style, colour and glass after checking the roof and upstand.', 'fenster'); ?></dd></div>
                    </dl>
                </div>
                <div class="fg-roof-lantern-system__visuals">
                    <figure class="fg-roof-lantern-system__thermal"><img src="<?php echo esc_url($asset('s1-thermal-eaves.jpg')); ?>" alt="<?php esc_attr_e('Thermal detail of a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-thermal-eaves.jpg'); ?>></figure>
                    <figure class="fg-roof-lantern-system__corner"><img src="<?php echo esc_url($asset('s1-corner-detail.jpg')); ?>" alt="<?php esc_attr_e('Close-up of a Sheerline S1 roof lantern corner', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-corner-detail.jpg'); ?>></figure>
                </div>
            </div>
        </section>

        <section id="roof-lantern-configurations" class="fg-roof-lantern-configurations">
            <div class="container">
                <div class="fg-roof-lantern-configurations__heading">
                    <p class="eyebrow"><?php esc_html_e('S1 configurations', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Compare all 13 roof lantern layouts.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('S1 is available in square, 2-way and 3-way layouts up to 3.2 x 6m without tie bars. We will confirm which layouts suit the opening before you choose the frame colour and glass.', 'fenster'); ?></p>
                </div>
            </div>
            <?php
            /*
             * Rendered twice so the drift in main.js can rewind by exactly half the
             * scroll width without showing a seam. The second pass is hidden from
             * assistive tech, and from everyone at 860px and under reduced motion,
             * where the wall becomes a plain swipe rail.
             */
            $wall_passes = [false, true];
            ?>
            <div class="fg-cd3-wall__viewport" data-fg-door-wall tabindex="0" role="region" aria-label="<?php esc_attr_e('Sheerline S1 roof lantern layouts. Drag or scroll sideways to explore.', 'fenster'); ?>">
                <ul class="fg-cd3-wall__track">
                    <?php foreach ($wall_passes as $is_clone) : ?>
                        <?php foreach ($roof_styles as $roof_style) : ?>
                            <li class="fg-lantern-card<?php echo $is_clone ? ' is-clone' : ''; ?>"<?php echo $is_clone ? ' aria-hidden="true"' : ''; ?>>
                                <img src="<?php echo esc_url($asset('configurations/' . $roof_style['image'])); ?>" alt="<?php echo esc_attr(sprintf('%1$s %2$s roof lantern in %3$s', $roof_style['layout'], $roof_style['style'], $roof_style['colour'])); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/configurations/' . $roof_style['image']); ?>>
                                <span class="fg-lantern-card__label">
                                    <strong><?php echo esc_html($roof_style['layout'] . ' ' . $roof_style['style']); ?></strong>
                                    <small><?php echo esc_html($roof_style['colour']); ?></small>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <section class="fg-roof-lantern-options">
            <div class="container">
                <div class="fg-roof-lantern-options__heading">
                    <p class="eyebrow"><?php esc_html_e('Choose before order', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Decide on security and ventilation early.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Both options change how the lantern and glass are made. We will discuss them with you before the final specification is signed off.', 'fenster'); ?></p>
                </div>
                <div class="fg-roof-lantern-options__grid">
                    <article>
                        <figure><img src="<?php echo esc_url($asset('s1-security-detail.jpg')); ?>" alt="<?php esc_attr_e('Security detail for a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-security-detail.jpg'); ?>></figure>
                        <div class="fg-roof-lantern-options__copy">
                            <span><?php esc_html_e('01. Security', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Security built into the frame.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('S1 uses enclosed glazing, anti-tamper features and a high-security ridge end. The optional Secured by Design upgrade adds concealed clamping plates that retain laminated glass panels.', 'fenster'); ?></p>
                        </div>
                    </article>
                    <article>
                        <figure><img src="<?php echo esc_url($asset('s1-sheervent.jpg')); ?>" alt="<?php esc_attr_e('SheerVent integrated into a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-sheervent.jpg'); ?>></figure>
                        <div class="fg-roof-lantern-options__copy">
                            <span><?php esc_html_e('02. Ventilation', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Ventilation without a bulky roof vent.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('SheerVent sits flush with the S1 rafter bars and opens using powered actuators. An optional rain sensor can close the vent automatically when it starts to rain.', 'fenster'); ?></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-roof-related">
            <div class="container fg-roof-related__card">
                <figure><img src="<?php echo esc_url($asset('flat-rooflights/fixed-flat-rooflights-installed-pair.jpg')); ?>" alt="<?php esc_attr_e('Pair of fixed flat rooflights', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/flat-rooflights/fixed-flat-rooflights-installed-pair.jpg'); ?>></figure>
                <div><p class="eyebrow"><?php esc_html_e('Prefer a flatter roof profile?', 'fenster'); ?></p><h2><?php esc_html_e('Compare fixed and opening flat rooflights.', 'fenster'); ?></h2><p><?php esc_html_e('Flat rooflights use edge-to-edge glass without the pitched rafters of a lantern. The separate page covers fixed, opening, larger multi-pane and walk-on options.', 'fenster'); ?></p><a class="button button--outline" href="<?php echo esc_url(home_url('/flat-rooflights/')); ?>"><?php esc_html_e('View flat rooflights', 'fenster'); ?></a></div>
            </div>
        </section>

        <?php
        /* Real lantern jobs before the enquiry, as casement and heritage doors
           both do. Two studies genuinely link to /roof-lanterns/, the Drayton
           Parslow lantern and the Northampton lantern with heritage doors, so
           the heading says two rather than carrying a count that could go stale.

           Checked rather than assumed: fenster_case_studies_for_product falls
           back to returning every study when nothing matches, which is how a
           page ends up claiming unrelated jobs as its own. These two match on
           their products[] url. */
        ?>
        <?php if (function_exists('fenster_case_studies_for_product')) : ?>
            <?php $rl_case_cards = fenster_case_studies_for_product('roof-lanterns', 3); ?>
            <?php if ($rl_case_cards !== []) : ?>
                <section class="fg-cs-strip">
                    <div class="container">
                        <div class="fg-cs-strip__head">
                            <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Lanterns we have fitted, photographed on the day.', 'fenster'); ?></h2>
                        </div>
                        <div class="fg-cs-strip__grid">
                            <?php foreach ($rl_case_cards as $rl_case_card) : ?>
                                <?php
                                get_template_part('template-parts/components/case-study-card', null, [
                                    'card' => $rl_case_card,
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

        <section id="fenster-roof-lantern-enquiry" class="fg-roof-lantern-enquiry">
            <div class="container fg-roof-lantern-enquiry__grid">
                <div class="fg-roof-lantern-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send us the basic details.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us where the lantern is going and what stage the project has reached. Photos and rough dimensions help, but they are not required. We will review the information and contact you to discuss the next step.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('New extension, existing roof opening or replacement lantern', 'fenster'); ?></li>
                        <li><?php esc_html_e('Rough dimensions and preferred frame colour if known', 'fenster'); ?></li>
                        <li><?php esc_html_e('Any concerns about heat, glare, ventilation or privacy', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-roof-lantern-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form fg-roof-lantern-form',
                        'source' => 'Roof Lanterns',
                        'button_label' => 'Send enquiry',
                        'project_type' => 'Roof lanterns',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--roof-lantern', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
