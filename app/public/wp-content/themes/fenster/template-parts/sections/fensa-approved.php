<?php
/**
 * Dedicated FENSA homeowner guidance and enquiry page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$asset = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/' . ltrim($path, '/'));
};
?>

<main id="main-content" class="fg-fensa-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('FENSA Approved Installer in Milton Keynes', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Replacement windows and doors, properly registered.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('We supply and install replacement windows and doors across Milton Keynes and the surrounding area. For work covered by the FENSA scheme, we register the completed installation so you receive the compliance certificate for your records.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-fensa-enquiry"><?php esc_html_e('Get a window or door quote', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-fensa-hero__checks" aria-label="FENSA installation reassurance">
                        <li><?php esc_html_e('Building Regulations compliance recorded', 'fenster'); ?></li>
                        <li><?php esc_html_e('Installation registered with the local council', 'fenster'); ?></li>
                        <li><?php esc_html_e('Certificate issued after eligible work is complete', 'fenster'); ?></li>
                    </ul>
                </div>
                <figure class="fg-fensa-hero__media">
                    <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/about/fenster-showroom.png', ['alt' => 'Fenster Glazing showroom in Milton Keynes', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                    <figcaption>
                        <img src="<?php echo esc_url($asset('trust/fensa.png')); ?>" alt="FENSA Approved Installer">
                        <span><?php esc_html_e('Local advice, survey, installation and aftercare from our Milton Keynes team.', 'fenster'); ?></span>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-fensa-proof" aria-label="What a FENSA certificate proves">
            <div class="container fg-fensa-proof__grid">
                <p><strong><?php esc_html_e('Compliant', 'fenster'); ?></strong><span><?php esc_html_e('The eligible installation meets the relevant Building Regulations.', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Registered', 'fenster'); ?></strong><span><?php esc_html_e('The completed work is registered with the local council.', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Documented', 'fenster'); ?></strong><span><?php esc_html_e('You have evidence to keep with the property and use when you sell.', 'fenster'); ?></span></p>
            </div>
        </section>

        <section class="fg-fensa-explainer">
            <div class="container fg-fensa-explainer__grid">
                <div class="fg-fensa-explainer__copy">
                    <p class="eyebrow"><?php esc_html_e('What FENSA means', 'fenster'); ?></p>
                    <h2><?php esc_html_e('One less piece of compliance for you to organise.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('FENSA is a government-authorised Competent Person Scheme for replacement windows and doors in England and Wales. Approved installers can self-certify eligible work instead of leaving the homeowner to arrange a separate Building Control inspection.', 'fenster'); ?></p>
                    <p><?php esc_html_e('The certificate is proof of compliance and registration. It is separate from the product and installation guarantee, although FENSA also requires the installer guarantee for registered work to be insurance backed.', 'fenster'); ?></p>
                    <a class="text-link" href="https://www.fensa.org.uk/homeowners" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read FENSA guidance for homeowners', 'fenster'); ?></a>
                </div>
                <figure>
                    <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/Residential_Door_08.jpg', ['alt' => 'Replacement entrance door installed in a stone property', 'loading' => 'lazy']); ?>>
                </figure>
            </div>
        </section>

        <section class="fg-fensa-scope">
            <div class="container">
                <div class="fg-fensa-heading">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Check the project', 'fenster'); ?></p>
                        <h2><?php esc_html_e('FENSA covers replacement work, not every glazing job.', 'fenster'); ?></h2>
                    </div>
                    <p><?php esc_html_e('We will confirm the correct compliance route before quoting. If the work falls outside the scheme, we can explain what approval or documentation may be needed instead.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-scope__grid">
                    <article>
                        <h3><?php esc_html_e('Usually covered', 'fenster'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('Replacement external windows', 'fenster'); ?></li>
                            <li><?php esc_html_e('Replacement external doors within the scheme rules', 'fenster'); ?></li>
                            <li><?php esc_html_e('Replacement roof windows and rooflights', 'fenster'); ?></li>
                            <li><?php esc_html_e('Homes on their existing footprint where room use and size are unchanged', 'fenster'); ?></li>
                        </ul>
                    </article>
                    <article class="fg-fensa-scope__outside">
                        <h3><?php esc_html_e('Outside the scheme', 'fenster'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('New builds and extensions', 'fenster'); ?></li>
                            <li><?php esc_html_e('New conservatories and most porches', 'fenster'); ?></li>
                            <li><?php esc_html_e('Repairs where the frame is not replaced', 'fenster'); ?></li>
                            <li><?php esc_html_e('Commercial properties', 'fenster'); ?></li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="fg-fensa-process">
            <div class="container fg-fensa-process__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('From quote to certificate', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We keep the route clear before anything is ordered.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us what you want to replace and where the property is. We will survey the opening, confirm the specification and explain whether the installation is eligible for FENSA registration.', 'fenster'); ?></p>
                </div>
                <ol>
                    <li><span>01</span><div><strong><?php esc_html_e('Survey and specify', 'fenster'); ?></strong><p><?php esc_html_e('We check sizes, safety glass, ventilation and the practical installation details.', 'fenster'); ?></p></div></li>
                    <li><span>02</span><div><strong><?php esc_html_e('Install and check', 'fenster'); ?></strong><p><?php esc_html_e('Our team fits the agreed products and completes the installation checks.', 'fenster'); ?></p></div></li>
                    <li><span>03</span><div><strong><?php esc_html_e('Register eligible work', 'fenster'); ?></strong><p><?php esc_html_e('We notify FENSA after completion so the certificate can be issued to you.', 'fenster'); ?></p></div></li>
                </ol>
            </div>
        </section>

        <section id="fenster-fensa-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Ask about your project', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us which windows or doors you want to replace.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Share the property postcode, the products involved and any photos you already have. We can confirm the next step and arrange a survey where needed.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'FENSA approved installers page',
                        'button_label' => 'Send project enquiry',
                        'project_type' => 'Replacement windows and doors',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</main>
