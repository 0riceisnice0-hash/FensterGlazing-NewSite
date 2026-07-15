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
                    <p class="eyebrow"><?php esc_html_e('What is CPA?', 'fenster'); ?></p>
                    <h1><?php esc_html_e('A back-up for your Fenster guarantee.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('CPA means Consumer Protection Association. Every new Fenster window and door installation receives a 10-year insurance-backed guarantee, which can protect our written guarantee if Fenster Glazing ever stops trading.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-cpa-enquiry"><?php esc_html_e('Ask how your guarantee is protected', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="Consumer Protection Association assurance">
                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>" aria-label="<?php esc_attr_e('Learn about Consumer Protection Association protection', 'fenster'); ?>">
                        <img src="<?php echo esc_url($asset('trust/cpa.png')); ?>" alt="Consumer Protection Association">
                    </a>
                    <p class="eyebrow"><?php esc_html_e('What it means for you', 'fenster'); ?></p>
                    <h2><?php esc_html_e('A back-up to our guarantee, not a replacement for it.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Fenster remains responsible for fixing issues while we are trading', 'fenster'); ?></li>
                        <li><?php esc_html_e('CPA-backed cover can help if we permanently cease trading', 'fenster'); ?></li>
                        <li><?php esc_html_e('Your policy documents confirm the exact cover and term', 'fenster'); ?></li>
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
                        <p class="eyebrow"><?php esc_html_e('How it works with Fenster', 'fenster'); ?></p>
                        <h2><?php esc_html_e('If something goes wrong, you call Fenster first.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Your agreement is with us, so we deal with any installation issue covered by our written guarantee. CPA insurance is not another product warranty or a separate aftercare service while Fenster is here to help.', 'fenster'); ?></p>
                        <p><?php esc_html_e('It becomes your safety net only if Fenster Glazing permanently ceases trading during the guarantee period. In that situation, you may be able to claim under the Insurance Backed Guarantee, subject to its policy terms.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.thecpa.co.uk/consumers/advice/insurance-backed-guarantee/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read CPA guidance on Insurance Backed Guarantees', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', ['alt' => 'Replacement windows installed in a row of homes', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('What you receive', 'fenster'); ?></p>
                        <h2><?php esc_html_e('We make the protection around your job clear before you commit.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('We set out our own written guarantee and tell you what documents to expect. You will receive insurance documentation that explains the 10-year protection in your name and the exact policy cover.', 'fenster'); ?></p>
                        <p><?php esc_html_e('FENSA and CPA do different jobs. FENSA records Building Regulations compliance for eligible replacement work. CPA-backed insurance protects the Fenster guarantee if we are no longer able to honour it. Keep both sets of documents with your property records.', 'fenster'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-cpa-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Ask before work starts', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We will explain exactly what protects your installation.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us what you are planning to replace. We will explain our written guarantee, the 10-year CPA-backed cover and the documents you should keep after installation.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('No jargon: we will explain who does what, and what you receive.', 'fenster'); ?></p>
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
