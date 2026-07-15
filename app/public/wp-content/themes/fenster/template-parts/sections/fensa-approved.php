<?php
/**
 * Dedicated FENSA approved installer page.
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

<div class="fg-fensa-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('FENSA Approved Installer in Milton Keynes', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Your installation, registered by us.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('With any eligible installation, you will receive a FENSA certificate. We apply for it on your behalf, and FENSA sends it directly to you once your installation has been registered.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-fensa-enquiry"><?php esc_html_e('Get a window or door quote', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="FENSA certificate assurance">
                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s FENSA approved installations', 'fenster'); ?>">
                        <img src="<?php echo esc_url($asset('trust/fensa.png')); ?>" alt="FENSA Approved Installer">
                    </a>
                    <p class="eyebrow"><?php esc_html_e('Included with eligible work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Yes, you will receive a FENSA certificate.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('We apply on your behalf after installation', 'fenster'); ?></li>
                        <li><?php esc_html_e('FENSA sends the certificate directly to you', 'fenster'); ?></li>
                        <li><?php esc_html_e('It confirms compliance with Building Regulations', 'fenster'); ?></li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="fg-fensa-stories">
            <div class="container">
                <div class="fg-fensa-story">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/Residential_Door_08.jpg', ['alt' => 'Replacement entrance door installed in a stone property', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('We handle the registration', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Nothing extra for you to arrange.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Your FENSA certificate confirms that the installation complies with Building Regulations. That means there is no need for your local authority’s Building Control department to inspect and sign off eligible work separately.', 'fenster'); ?></p>
                        <p><?php esc_html_e('If an installer is not part of a Competent Person Scheme such as FENSA, Building Control approval may be required instead. Without the correct certification, you could run into problems when selling because solicitors will often ask for proof that replacement windows and doors comply with Building Regulations.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.fensa.org.uk/homeowners" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read FENSA guidance for homeowners', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', ['alt' => 'Replacement windows installed in a row of homes', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('Insurance Backed Guarantee', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Your guarantee has insurance behind it.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('A Consumer Protection Association Insurance Backed Guarantee can protect the installer’s written guarantee if Fenster Glazing were ever to cease trading, subject to the individual policy terms.', 'fenster'); ?></p>
                        <p><?php esc_html_e('The certificate and policy wording confirm the exact cover and duration. Many guarantees are available for up to 10 years, but your own documents are the record to keep with your FENSA certificate.', 'fenster'); ?></p>
                        <p class="fg-fensa-story__accreditation"><a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>" aria-label="<?php esc_attr_e('Learn about Consumer Protection Association protection', 'fenster'); ?>"><img src="<?php echo esc_url($asset('trust/cpa.png')); ?>" alt="Consumer Protection Association"></a><span><?php esc_html_e('Insurance backing supplied by the Consumer Protection Association', 'fenster'); ?></span></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-fensa-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Plan your replacement', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us which windows or doors you want to replace.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Share your postcode, the products involved and any photos you already have. We will confirm the next step and arrange a survey where needed.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('For eligible work, FENSA registration is handled by us after installation.', 'fenster'); ?></p>
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
</div>
