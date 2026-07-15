<?php
/**
 * Dedicated Consumer Protection Association information page.
 *
 * Uses the established FENSA page composition for consumer protection guidance.
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

<div class="fg-fensa-page fg-cpa-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Consumer Protection Association', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Your installation guarantee, with a back-up plan.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('An Insurance Backed Guarantee can protect the original written guarantee for qualifying Fenster installations if we were ever unable to honour it. The Consumer Protection Association provides this additional layer of protection.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-cpa-enquiry"><?php esc_html_e('Ask about your installation', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="Consumer Protection Association assurance">
                    <img src="<?php echo esc_url($asset('trust/cpa.png')); ?>" alt="Consumer Protection Association">
                    <p class="eyebrow"><?php esc_html_e('Insurance Backed Guarantee', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Protection if your installer can no longer honour their guarantee.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Supports the original written installation guarantee', 'fenster'); ?></li>
                        <li><?php esc_html_e('Can apply if Fenster Glazing ceases trading', 'fenster'); ?></li>
                        <li><?php esc_html_e('Your certificate confirms the exact cover and term', 'fenster'); ?></li>
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
                        <p class="eyebrow"><?php esc_html_e('What the guarantee does', 'fenster'); ?></p>
                        <h2><?php esc_html_e('It protects the promise behind the installation.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('An Insurance Backed Guarantee is not a second product warranty. It is insurance that can step in if an installer ceases to trade during the original guarantee period, subject to the terms of the policy.', 'fenster'); ?></p>
                        <p><?php esc_html_e('The cover is intended to reflect the installer’s written guarantee. Your own certificate and policy wording set out what is covered, how long it lasts and how to make a claim.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.thecpa.co.uk/consumers/advice/insurance-backed-guarantee/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read CPA guidance on Insurance Backed Guarantees', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', ['alt' => 'Replacement windows installed in a row of homes', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('Keep the paperwork together', 'fenster'); ?></p>
                        <h2><?php esc_html_e('FENSA and CPA give you different protections.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Your FENSA certificate records compliance with the relevant Building Regulations for eligible replacement work. A CPA Insurance Backed Guarantee relates to the installer’s own written guarantee if the installer stops trading.', 'fenster'); ?></p>
                        <p><?php esc_html_e('Many guarantees are available for up to 10 years, but the duration depends on the work and individual policy. Keep the FENSA certificate, guarantee and insurance documents with your property records.', 'fenster'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-cpa-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Ask before work starts', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We will make the protection around your installation clear.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us what you are planning to replace. We will explain the relevant registration, guarantee and protection documents for your proposed installation.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('For qualifying work, ask us to explain the Insurance Backed Guarantee and the documents you will receive.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'Consumer Protection Association page',
                        'button_label' => 'Send project enquiry',
                        'project_type' => 'Replacement windows and doors',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
