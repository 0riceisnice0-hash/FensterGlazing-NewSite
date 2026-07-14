<?php
/**
 * Flat rooflights conversion page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$asset = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/' . $path);
};
$imported = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/images/imported/' . $path);
};
?>

<main id="main-content" class="fg-flat-rooflight-page">
    <article>
        <section class="fg-flat-rooflight-hero">
            <div class="container fg-flat-rooflight-hero__grid">
                <div class="fg-flat-rooflight-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Flat rooflights in Milton Keynes', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Daylight from above, with less frame in view.', 'fenster'); ?></h1>
                    <p class="fg-flat-rooflight-hero__lead"><?php esc_html_e('We supply and install Titan aluminium flat rooflights for extensions, flat roofs, larger openings and walk-on areas. We check the opening, upstand, glass and whether the rooflight needs to open before it is ordered.', 'fenster'); ?></p>
                    <div class="fg-flat-rooflight-hero__actions">
                        <a class="button" href="#fenster-flat-rooflight-enquiry"><?php esc_html_e('Get a flat rooflight quote', 'fenster'); ?></a>
                        <a class="fg-flat-rooflight-hero__call" href="tel:01908429200"><?php esc_html_e('Call us on 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-flat-rooflight-hero__reassurance" aria-label="<?php esc_attr_e('Flat rooflight reassurance', 'fenster'); ?>">
                        <li><?php esc_html_e('Fixed and opening rooflights', 'fenster'); ?></li>
                        <li><?php esc_html_e('Survey checks the opening and upstand', 'fenster'); ?></li>
                        <li><?php esc_html_e('Glass specified around safety and comfort', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure class="fg-flat-rooflight-hero__media">
                    <img src="<?php echo esc_url($asset('titan-edge-installed-pair.jpg')); ?>" alt="<?php esc_attr_e('Pair of Titan EDGE fixed flat rooflights installed on a flat roof', 'fenster'); ?>" loading="eager"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-installed-pair.jpg'); ?>>
                    <figcaption><?php esc_html_e('Titan EDGE fixed flat rooflight', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-flat-rooflight-brief" aria-label="<?php esc_attr_e('Flat rooflight specification summary', 'fenster'); ?>">
            <div class="container fg-flat-rooflight-brief__grid">
                <p><strong><?php esc_html_e('Edge-to-edge glass', 'fenster'); ?></strong><span><?php esc_html_e('No raised perimeter frame above the glass', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Fixed or opening', 'fenster'); ?></strong><span><?php esc_html_e('Manual and powered ventilation options', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Typical 1.3 W/m²K', 'fenster'); ?></strong><span><?php esc_html_e('Overall roof value across the Titan range shown', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Safety glass', 'fenster'); ?></strong><span><?php esc_html_e('Toughened or laminated inner pane by specification', 'fenster'); ?></span></p>
            </div>
        </section>

        <section class="fg-flat-rooflight-choice">
            <div class="container">
                <div class="fg-flat-rooflight-heading">
                    <p class="eyebrow"><?php esc_html_e('Fixed or opening', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose whether the rooflight only brings in light or also opens.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Titan EDGE stays fixed and sits 63mm above the upstand. EDGE Air adds manual or powered opening and rises to 103mm, only 40mm higher than the fixed version.', 'fenster'); ?></p>
                </div>
                <div class="fg-flat-rooflight-choice__grid">
                    <article>
                        <figure><img src="<?php echo esc_url($asset('titan-edge-close-up.jpg')); ?>" alt="<?php esc_attr_e('Close-up of the polished edge-to-edge glass on a Titan EDGE rooflight', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-close-up.jpg'); ?>></figure>
                        <div><span><?php esc_html_e('Titan EDGE', 'fenster'); ?></span><h3><?php esc_html_e('Fixed flat rooflight', 'fenster'); ?></h3><p><?php esc_html_e('Choose this when daylight is the priority and the room already has enough ventilation. Water can run off the polished glass edge without a raised frame around it.', 'fenster'); ?></p></div>
                    </article>
                    <article>
                        <figure><img src="<?php echo esc_url($asset('titan-edge-air-opening-rooflight.jpg')); ?>" alt="<?php esc_attr_e('Titan EDGE Air flat rooflight open above its upstand', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-air-opening-rooflight.jpg'); ?>></figure>
                        <div><span><?php esc_html_e('Titan EDGE Air', 'fenster'); ?></span><h3><?php esc_html_e('Opening flat rooflight', 'fenster'); ?></h3><p><?php esc_html_e('Choose this when the room also needs high-level ventilation. It opens up to 300mm using a manual winder or a powered actuator.', 'fenster'); ?></p></div>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-flat-rooflight-operation">
            <div class="container">
                <div class="fg-flat-rooflight-heading">
                    <p class="eyebrow"><?php esc_html_e('Opening and controls', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Decide how you want the rooflight to open.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('EDGE Air can use a wall switch, remote control or manual pole. Powered versions can also add rain sensing and thermostatic control, so we need to confirm the controls and wiring before order.', 'fenster'); ?></p>
                </div>
                <div class="fg-flat-rooflight-operation__grid">
                    <figure><img src="<?php echo esc_url($asset('titan-edge-air-controls.jpg')); ?>" alt="<?php esc_attr_e('Remote, wall switch and actuator controls for a Titan EDGE Air rooflight', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-air-controls.jpg'); ?>><figcaption><?php esc_html_e('Remote and wall controls', 'fenster'); ?></figcaption></figure>
                    <figure><img src="<?php echo esc_url($asset('titan-edge-air-actuator.jpg')); ?>" alt="<?php esc_attr_e('Section detail comparing the fixed EDGE and opening EDGE Air rooflight frames', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-edge-air-actuator.jpg'); ?>><figcaption><?php esc_html_e('Concealed powered actuator', 'fenster'); ?></figcaption></figure>
                </div>
            </div>
        </section>

        <section class="fg-flat-rooflight-special">
            <div class="container">
                <div class="fg-flat-rooflight-heading">
                    <p class="eyebrow"><?php esc_html_e('Larger and walk-on openings', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Some roofs need more than a single pane.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Multipane divides a larger opening into several glazed panels. Walkon uses a heavier laminated glass build-up for balconies and other areas where people need to cross the rooflight.', 'fenster'); ?></p>
                </div>
                <div class="fg-flat-rooflight-special__grid">
                    <article>
                        <div class="fg-flat-rooflight-special__images">
                            <img src="<?php echo esc_url($asset('titan-multipane-exterior.jpg')); ?>" alt="<?php esc_attr_e('Titan Multipane flat rooflight viewed from outside', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-multipane-exterior.jpg'); ?>>
                            <img src="<?php echo esc_url($asset('titan-multipane-interior.jpg')); ?>" alt="<?php esc_attr_e('Titan Multipane flat rooflight viewed from the room below', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-multipane-interior.jpg'); ?>>
                        </div>
                        <div><span><?php esc_html_e('Titan EDGE Multipane', 'fenster'); ?></span><h3><?php esc_html_e('For larger roof openings', 'fenster'); ?></h3><p><?php esc_html_e('Multiple panes reduce individual glass sizes while keeping narrow internal and external sightlines. The unit is normally delivered in one section with its fixing straps attached.', 'fenster'); ?></p></div>
                    </article>
                    <article>
                        <div class="fg-flat-rooflight-special__images">
                            <img src="<?php echo esc_url($asset('titan-walkon-exterior.jpg')); ?>" alt="<?php esc_attr_e('Titan Walkon rooflight set into a terrace', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-walkon-exterior.jpg'); ?>>
                            <img src="<?php echo esc_url($asset('titan-walkon-deck.jpg')); ?>" alt="<?php esc_attr_e('Person standing on a Titan Walkon rooflight in a deck', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/titan/titan-walkon-deck.jpg'); ?>>
                        </div>
                        <div><span><?php esc_html_e('Titan EDGE Walkon', 'fenster'); ?></span><h3><?php esc_html_e('For pedestrian areas', 'fenster'); ?></h3><p><?php esc_html_e('Three laminated layers of 10mm toughened glass form the walk-on outer section. Clear, obscure, sandblasted and textured anti-slip finishes are available by specification.', 'fenster'); ?></p></div>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-roof-related">
            <div class="container fg-roof-related__card">
                <figure><img src="<?php echo esc_url($imported('S1-Lantern-Kitchen-A-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Sheerline S1 pitched roof lantern above a kitchen', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg'); ?>></figure>
                <div><p class="eyebrow"><?php esc_html_e('Prefer a pitched feature?', 'fenster'); ?></p><h2><?php esc_html_e('Compare Sheerline S1 roof lanterns.', 'fenster'); ?></h2><p><?php esc_html_e('A roof lantern adds visible aluminium rafters and a raised shape above the roof. The separate roof lantern page shows all 13 S1 layouts.', 'fenster'); ?></p><a class="button button--outline" href="<?php echo esc_url(home_url('/roof-lanterns/')); ?>"><?php esc_html_e('View roof lanterns', 'fenster'); ?></a></div>
            </div>
        </section>

        <section id="fenster-flat-rooflight-enquiry" class="fg-flat-rooflight-enquiry">
            <div class="container fg-flat-rooflight-enquiry__grid">
                <div class="fg-flat-rooflight-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send us the opening details.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us where the rooflight is going, the rough opening size and whether it needs to open or be walked on. Photos or drawings help us understand the roof before we contact you.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('Fixed, opening, Multipane or Walkon if known', 'fenster'); ?></li>
                        <li><?php esc_html_e('Rough opening and upstand dimensions', 'fenster'); ?></li>
                        <li><?php esc_html_e('Any safety, privacy, heat or ventilation concerns', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-flat-rooflight-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form fg-roof-lantern-form',
                        'source' => 'Flat Rooflights',
                        'button_label' => 'Send enquiry',
                        'project_type' => 'Flat rooflights',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--flat-rooflight', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
