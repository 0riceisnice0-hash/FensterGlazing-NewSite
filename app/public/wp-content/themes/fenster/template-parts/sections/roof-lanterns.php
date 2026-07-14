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
                        'project_type' => 'Roof lanterns',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--roof-lantern', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
