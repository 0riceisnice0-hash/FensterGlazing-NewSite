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
        <section class="fg-roof-lantern-hero">
            <div class="container fg-roof-lantern-hero__grid">
                <div class="fg-roof-lantern-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Roof lanterns in Milton Keynes', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Bring more daylight into your extension.', 'fenster'); ?></h1>
                    <p class="fg-roof-lantern-hero__lead"><?php esc_html_e('We supply and install Sheerline S1 aluminium roof lanterns across Milton Keynes. We check the roof opening, glass specification, ventilation and finish before the lantern is ordered.', 'fenster'); ?></p>
                    <div class="fg-roof-lantern-hero__actions">
                        <a class="button" href="#fenster-roof-lantern-enquiry"><?php esc_html_e('Get a roof lantern quote', 'fenster'); ?></a>
                        <a class="fg-roof-lantern-hero__call" href="tel:01908429200"><?php esc_html_e('Call us on 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-roof-lantern-hero__reassurance" aria-label="<?php esc_attr_e('Roof lantern reassurance', 'fenster'); ?>">
                        <li><?php esc_html_e('Opening measured and checked before order', 'fenster'); ?></li>
                        <li><?php esc_html_e('Glass options for heat, noise and safety', 'fenster'); ?></li>
                        <li><?php esc_html_e('Local installation with aftercare', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure class="fg-roof-lantern-hero__media">
                    <img src="<?php echo esc_url($imported('S1-Lantern-Kitchen-A-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Sheerline roof lantern above a modern kitchen and dining space', 'fenster'); ?>" loading="eager"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg'); ?>>
                    <figcaption><?php esc_html_e('Sheerline S1 aluminium roof lantern', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-roof-lantern-brief" aria-label="<?php esc_attr_e('Roof lantern specification summary', 'fenster'); ?>">
            <div class="container">
                <div class="fg-roof-lantern-brief__grid">
                    <p><strong><?php esc_html_e('S1 aluminium system', 'fenster'); ?></strong><span><?php esc_html_e('Slim, low-line external appearance', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('28mm glazing', 'fenster'); ?></strong><span><?php esc_html_e('Solar-control, acoustic and toughened options', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('Up to 3.2 x 6m', 'fenster'); ?></strong><span><?php esc_html_e('Available without tie bars, subject to size and survey', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('SheerVent option', 'fenster'); ?></strong><span><?php esc_html_e('Automated ventilation with rain sensing', 'fenster'); ?></span></p>
                </div>
            </div>
        </section>

        <section id="rooflight-types" class="fg-roof-light-types">
            <div class="container">
                <div class="fg-roof-light-types__heading">
                    <p class="eyebrow"><?php esc_html_e('Roof lantern or flat rooflight', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose how much structure you want to see.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('A lantern creates a raised, pitched feature. A flat rooflight keeps the outside profile lower and gives you a simpler opening from below. We will check the roof and explain which options suit it.', 'fenster'); ?></p>
                </div>
                <div class="fg-roof-light-types__grid">
                    <article>
                        <figure><img src="<?php echo esc_url($imported('S1-Lantern-first-installation-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Sheerline S1 pitched roof lantern installed on a flat roof', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-first-installation-min-scaled.jpg'); ?>></figure>
                        <div><span><?php esc_html_e('Sheerline S1', 'fenster'); ?></span><h3><?php esc_html_e('Roof lantern', 'fenster'); ?></h3><p><?php esc_html_e('A pitched aluminium lantern with 13 layouts, 28mm glazing and optional powered ventilation.', 'fenster'); ?></p></div>
                    </article>
                    <article>
                        <figure><img src="<?php echo esc_url($asset('titan/titan-edge-fixed-rooflight.jpg')); ?>" alt="<?php esc_attr_e('Titan EDGE fixed flat rooflight with edge-to-edge glass', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-fixed-rooflight.jpg'); ?>></figure>
                        <div><span><?php esc_html_e('Titan EDGE', 'fenster'); ?></span><h3><?php esc_html_e('Fixed flat rooflight', 'fenster'); ?></h3><p><?php esc_html_e('Edge-to-edge glass, a thermally broken aluminium frame and a low 63mm height above the upstand.', 'fenster'); ?></p></div>
                    </article>
                    <article>
                        <figure><img src="<?php echo esc_url($asset('titan/titan-edge-air-opening-rooflight.jpg')); ?>" alt="<?php esc_attr_e('Titan EDGE Air opening flat rooflight', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-air-opening-rooflight.jpg'); ?>></figure>
                        <div><span><?php esc_html_e('Titan EDGE Air', 'fenster'); ?></span><h3><?php esc_html_e('Opening flat rooflight', 'fenster'); ?></h3><p><?php esc_html_e('Manual or powered opening with optional remote, rain sensor and thermostatic controls.', 'fenster'); ?></p></div>
                    </article>
                </div>
            </div>
        </section>

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
                <div class="fg-colour-carousel fg-roof-lantern-configurations__carousel" data-fg-colour-carousel>
                    <div class="fg-colour-carousel__viewport">
                        <div class="fg-colour-carousel__track" data-fg-colour-carousel-track>
                            <?php foreach ($roof_styles as $index => $roof_style) : ?>
                                <article class="fg-colour-carousel__slide fg-roof-lantern-configurations__slide" data-fg-colour-slide>
                                    <img src="<?php echo esc_url($asset('configurations/' . $roof_style['image'])); ?>" alt="<?php echo esc_attr($roof_style['layout'] . ' ' . $roof_style['style'] . ' roof lantern in ' . $roof_style['colour']); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/configurations/' . $roof_style['image']); ?>>
                                    <div>
                                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                        <h3><?php echo esc_html($roof_style['layout'] . ' ' . $roof_style['style']); ?></h3>
                                        <p><?php echo esc_html($roof_style['colour']); ?></p>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="fg-colour-carousel__controls">
                        <button type="button" data-fg-colour-prev aria-label="<?php esc_attr_e('Previous roof lantern configuration', 'fenster'); ?>">&#8249;</button>
                        <span data-fg-colour-count><?php echo esc_html('01 / ' . sprintf('%02d', count($roof_styles))); ?></span>
                        <button type="button" data-fg-colour-next aria-label="<?php esc_attr_e('Next roof lantern configuration', 'fenster'); ?>">&#8250;</button>
                    </div>
                </div>
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
                        'project_type' => 'Roof lanterns and flat rooflights',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--roof-lantern', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
