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
                    <h1><?php esc_html_e('Put daylight at the centre of your extension.', 'fenster'); ?></h1>
                    <p class="fg-roof-lantern-hero__lead"><?php esc_html_e('A well-planned roof lantern can make the kitchen, dining space or extension below feel more open from the moment you walk in. Fenster specifies and fits Sheerline S1 aluminium lanterns around the room, roof opening and everyday use.', 'fenster'); ?></p>
                    <div class="fg-roof-lantern-hero__actions">
                        <a class="button" href="#fenster-roof-lantern-enquiry"><?php esc_html_e('Plan my roof lantern', 'fenster'); ?></a>
                        <a class="fg-roof-lantern-hero__call" href="tel:01908429200"><?php esc_html_e('Or call 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-roof-lantern-hero__reassurance" aria-label="<?php esc_attr_e('Roof lantern reassurance', 'fenster'); ?>">
                        <li><?php esc_html_e('Survey-led sizes and roof opening checks', 'fenster'); ?></li>
                        <li><?php esc_html_e('Solar-control, acoustic and safety glass options', 'fenster'); ?></li>
                        <li><?php esc_html_e('Local installation and aftercare', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure class="fg-roof-lantern-hero__media">
                    <img src="<?php echo esc_url($imported('S1-Lantern-Kitchen-A-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Sheerline roof lantern bringing daylight into a kitchen extension', 'fenster'); ?>" loading="eager"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg'); ?>>
                    <figcaption><?php esc_html_e('Sheerline S1 aluminium roof lantern', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-roof-lantern-brief" aria-label="<?php esc_attr_e('Roof lantern specification summary', 'fenster'); ?>">
            <div class="container">
                <div class="fg-roof-lantern-brief__grid">
                    <p><strong><?php esc_html_e('S1 aluminium system', 'fenster'); ?></strong><span><?php esc_html_e('Slim, low-line external appearance', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('28mm glazing', 'fenster'); ?></strong><span><?php esc_html_e('Solar-control, acoustic and toughened options', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('Up to 3.2 × 6m', 'fenster'); ?></strong><span><?php esc_html_e('Without tie bars, subject to survey', 'fenster'); ?></span></p>
                    <p><strong><?php esc_html_e('SheerVent option', 'fenster'); ?></strong><span><?php esc_html_e('Automated ventilation with rain sensing', 'fenster'); ?></span></p>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-intro">
            <div class="container fg-roof-lantern-intro__grid">
                <figure class="fg-roof-lantern-intro__media">
                    <img src="<?php echo esc_url($imported('S1-Lantern-Lounge-with-LEDs-min-scaled.jpg')); ?>" alt="<?php esc_attr_e('Roof lantern above a finished living space', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Lounge-with-LEDs-min-scaled.jpg'); ?>>
                </figure>
                <div class="fg-roof-lantern-intro__copy">
                    <p class="eyebrow"><?php esc_html_e('More than a bright square in the roof', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Start with how the room needs to feel.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('The most successful lanterns feel like they belong to the extension. That starts with the proportion of the opening, where the light falls, how the room gets warm in summer and how the frame colour relates to the doors and windows around it.', 'fenster'); ?></p>
                    <ol class="fg-roof-lantern-intro__steps">
                        <li><strong><?php esc_html_e('01 — Light', 'fenster'); ?></strong><span><?php esc_html_e('Choose the position and proportion that lifts the room without taking over the roof.', 'fenster'); ?></span></li>
                        <li><strong><?php esc_html_e('02 — Comfort', 'fenster'); ?></strong><span><?php esc_html_e('Match the glazing and ventilation approach to the way the space faces and is used.', 'fenster'); ?></span></li>
                        <li><strong><?php esc_html_e('03 — Finish', 'fenster'); ?></strong><span><?php esc_html_e('Bring frame colour, sightlines and the surrounding aluminium together before manufacture.', 'fenster'); ?></span></li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-system">
            <div class="container fg-roof-lantern-system__grid">
                <div class="fg-roof-lantern-system__copy">
                    <p class="eyebrow"><?php esc_html_e('The S1 system', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Clean lines above. Practical performance below.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Sheerline S1 is designed with low-line external caps and aligned corner details, keeping the rooflight looking restrained rather than over-engineered. Beneath that appearance, Thermlock multi-chamber technology and 28mm glazing help the lantern support year-round comfort.', 'fenster'); ?></p>
                    <dl class="fg-roof-lantern-system__points">
                        <div><dt><?php esc_html_e('Low-line finish', 'fenster'); ?></dt><dd><?php esc_html_e('Rafter and hip caps sit close to the glazing for a calmer roofline.', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Thermlock technology', 'fenster'); ?></dt><dd><?php esc_html_e('Multi-chamber construction supports thermal performance through the frame.', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Made around the opening', 'fenster'); ?></dt><dd><?php esc_html_e('Final size, style, colour and glass are confirmed once the roof and upstand are checked.', 'fenster'); ?></dd></div>
                    </dl>
                </div>
                <div class="fg-roof-lantern-system__visuals">
                    <figure class="fg-roof-lantern-system__thermal"><img src="<?php echo esc_url($asset('s1-thermal-eaves.jpg')); ?>" alt="<?php esc_attr_e('Thermal detail of a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-thermal-eaves.jpg'); ?>></figure>
                    <figure class="fg-roof-lantern-system__corner"><img src="<?php echo esc_url($asset('s1-corner-detail.jpg')); ?>" alt="<?php esc_attr_e('Close-up of a Sheerline S1 roof lantern corner', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-corner-detail.jpg'); ?>></figure>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-assurance">
            <div class="container fg-roof-lantern-assurance__grid">
                <figure><img src="<?php echo esc_url($asset('s1-security-detail.jpg')); ?>" alt="<?php esc_attr_e('Security detail for a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-security-detail.jpg'); ?>></figure>
                <div>
                    <p class="eyebrow"><?php esc_html_e('Security considered properly', 'fenster'); ?></p>
                    <h2><?php esc_html_e('The overhead glass should feel as secure as the rest of the extension.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('S1 incorporates enclosed glazing, anti-tamper features and a high-security ridge end. For projects needing an additional level of protection, an optional Secured by Design upgrade adds clamping plates to help keep laminated glass panels in place without changing the finished look.', 'fenster'); ?></p>
                    <p class="fg-roof-lantern-assurance__note"><?php esc_html_e('Fenster will help you choose the glazing and security approach that fits the room, roof position and project—not a one-size-fits-all specification.', 'fenster'); ?></p>
                </div>
            </div>
        </section>

        <section class="fg-roof-lantern-ventilation">
            <div class="container fg-roof-lantern-ventilation__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('When the room runs warm', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Build ventilation into the conversation early.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('A lantern over a busy kitchen or south-facing extension can need more than good glass. SheerVent is a flush, powered ventilation option designed to sit neatly with the lantern bars, helping release warm air without adding a clumsy roof vent.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('Flush visual integration with the S1 lantern', 'fenster'); ?></li>
                        <li><?php esc_html_e('Powered opening with optional automated rain sensing', 'fenster'); ?></li>
                        <li><?php esc_html_e('Specified around the room, orientation and final roof design', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure><img src="<?php echo esc_url($asset('s1-sheervent.jpg')); ?>" alt="<?php esc_attr_e('SheerVent integrated into a Sheerline S1 roof lantern', 'fenster'); ?>" loading="lazy"<?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/roof-lanterns/s1-sheervent.jpg'); ?>></figure>
            </div>
        </section>

        <section id="fenster-roof-lantern-enquiry" class="fg-roof-lantern-enquiry">
            <div class="container fg-roof-lantern-enquiry__grid">
                <div class="fg-roof-lantern-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Start with the space', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us what you are planning.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('A photo of the extension, a rough opening size or even a short description of the room is enough to start. Fenster will help with the practical questions before final measurements are taken at survey.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('New extension, existing roof opening or replacement lantern', 'fenster'); ?></li>
                        <li><?php esc_html_e('Rough dimensions and preferred frame colour if known', 'fenster'); ?></li>
                        <li><?php esc_html_e('Any concerns about heat, glare, ventilation or privacy', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-roof-lantern-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'Roof Lanterns',
                        'button_label' => 'Ask about a roof lantern',
                        'project_type' => 'Roof lanterns or integral blinds',
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--roof-lantern', 'trust_items' => $trust_items, 'limit' => 7]); ?>
    </article>
</main>
