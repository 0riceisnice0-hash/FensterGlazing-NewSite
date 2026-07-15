<?php
/**
 * Dedicated Constructionline Gold information page.
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

<div class="fg-fensa-page fg-constructionline-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Constructionline Gold member', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Commercial glazing, with the checks already in place.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('Constructionline is a supplier pre-qualification service used across construction. Our Gold membership means our business information has been checked against the Common Assessment Standard, helping commercial clients assess us before a project starts.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-constructionline-enquiry"><?php esc_html_e('Discuss a commercial project', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="Constructionline Gold assurance">
                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/constructionline-gold/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s Constructionline Gold membership', 'fenster'); ?>">
                        <img src="<?php echo esc_url($asset('trust/constructionline-gold-member.png')); ?>" alt="Constructionline Gold Member">
                    </a>
                    <p class="eyebrow"><?php esc_html_e('What it means', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Useful evidence before you appoint a supplier.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Gold aligns with the Common Assessment Standard desktop assessment', 'fenster'); ?></li>
                        <li><?php esc_html_e('Our supplier information can support your procurement checks', 'fenster'); ?></li>
                        <li><?php esc_html_e('We can still talk through the detail of your individual project', 'fenster'); ?></li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="fg-fensa-stories">
            <div class="container">
                <div class="fg-fensa-story">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/Airbus-Commercial.jpg', ['alt' => 'Commercial glazing installation by Fenster Glazing', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('Less repetition at the start', 'fenster'); ?></p>
                        <h2><?php esc_html_e('It helps your procurement team get a clearer picture of Fenster.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Commercial clients often need to review a supplier before inviting them onto a project. Constructionline brings standard supplier questions into one place, rather than asking every prospective contractor to prepare the same information from scratch.', 'fenster'); ?></p>
                        <p><?php esc_html_e('At Gold level, Constructionline verifies a desktop submission against the Common Assessment Standard. That makes our membership useful evidence when you are considering Fenster for commercial windows, doors, curtain walling or specialist glazing.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.constructionline.co.uk/about/common-assessment-standard/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read about the Common Assessment Standard', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/commercial-4.jpg', ['alt' => 'Commercial glazing project completed by Fenster Glazing', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('Clear about its role', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Constructionline Gold is not a product warranty or a certificate for your installation.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('It is a business pre-qualification status, not a substitute for project-specific design, survey, product approvals, warranties or Building Regulations paperwork. We still scope your job properly, agree the specification and explain the documents that apply to it.', 'fenster'); ?></p>
                        <p><?php esc_html_e('For domestic replacement work, FENSA may provide the Building Regulations route where the installation is eligible. For commercial work, we will set out the compliance, product and handover requirements with you before work begins.', 'fenster'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-constructionline-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Bring us in early', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We will help you plan the glazing package properly.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us about the site, programme and glazing scope. We can discuss the specification, access, survey requirements and the procurement information your team needs from us.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('Straight answers for commercial projects, before work is committed.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'Constructionline Gold page',
                        'button_label' => 'Send commercial enquiry',
                        'project_type' => 'Commercial glazing project',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
