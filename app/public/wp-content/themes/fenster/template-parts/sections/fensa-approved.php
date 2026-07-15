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
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('We are a FENSA Approved Installer. When we complete eligible replacement window or door work, we register the installation and you receive the FENSA certificate for your property records.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-fensa-enquiry"><?php esc_html_e('Get a window or door quote', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="FENSA certificate assurance">
                    <img src="<?php echo esc_url($asset('trust/fensa.png')); ?>" alt="FENSA Approved Installer">
                    <p class="eyebrow"><?php esc_html_e('Included with eligible work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Yes, you will receive a FENSA certificate.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('We register the completed installation', 'fenster'); ?></li>
                        <li><?php esc_html_e('The work is recorded with your local authority', 'fenster'); ?></li>
                        <li><?php esc_html_e('You keep the certificate with your property documents', 'fenster'); ?></li>
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
                        <p><?php esc_html_e('We survey the opening, agree the specification and install your new windows or doors. Once eligible work is complete, we notify FENSA so your certificate can be issued.', 'fenster'); ?></p>
                        <p><?php esc_html_e('The certificate confirms that the installation meets the relevant Building Regulations and has been registered with your local authority. Keep it with your home records, as it may be requested when you sell.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.fensa.org.uk/homeowners" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read FENSA guidance for homeowners', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', ['alt' => 'Replacement windows installed in a row of homes', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('The right route from the start', 'fenster'); ?></p>
                        <h2><?php esc_html_e('We confirm whether your project is covered before you order.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('FENSA normally covers replacement external windows, doors and rooflights in existing homes. We will confirm that your proposed work is eligible when we survey and quote.', 'fenster'); ?></p>
                        <p><?php esc_html_e('New builds, extensions, commercial properties and some structural changes sit outside the scheme. If that applies to your project, we will explain the correct Building Control or approval route clearly before work begins.', 'fenster'); ?></p>
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
