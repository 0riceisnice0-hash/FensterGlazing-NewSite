<?php
/**
 * Dedicated SSIP health and safety information page.
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

<div class="fg-fensa-page fg-ssip-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('What is SSIP?', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Health and safety checks, without repeating the paperwork.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('SSIP means Safety Schemes in Procurement. It is the shared framework used by recognised assessment schemes to check a contractor’s health and safety arrangements before commercial work is awarded.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-ssip-enquiry"><?php esc_html_e('Discuss a commercial project', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="SSIP health and safety assurance">
                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/ssip-health-and-safety/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s SSIP health and safety assessment', 'fenster'); ?>">
                        <img src="<?php echo esc_url($asset('images/imported/cropped-ssip.png')); ?>" alt="Safety Schemes in Procurement">
                    </a>
                    <p class="eyebrow"><?php esc_html_e('What it means for you', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Our health and safety arrangements have been assessed for procurement.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('It supports early-stage health and safety pre-qualification', 'fenster'); ?></li>
                        <li><?php esc_html_e('SSIP member schemes can recognise each other’s valid approvals', 'fenster'); ?></li>
                        <li><?php esc_html_e('Your project still receives its own safety planning and review', 'fenster'); ?></li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="fg-fensa-stories">
            <div class="container">
                <div class="fg-fensa-story">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/commercial-1.jpg', ['alt' => 'Fenster Glazing team completing a commercial project', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('How it works with Fenster', 'fenster'); ?></p>
                        <h2><?php esc_html_e('SSIP helps clients avoid asking the same health and safety questions again.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('When you are appointing a contractor, you need confidence that their health and safety management has been assessed. SSIP is the umbrella body behind a group of assessment schemes that use common core criteria for that early procurement check.', 'fenster'); ?></p>
                        <p><?php esc_html_e('The practical benefit is mutual recognition. A current assessment through one recognised SSIP member scheme can be accepted by another, so your procurement team does not have to begin the same first-stage review from scratch.', 'fenster'); ?></p>
                        <a class="text-link" href="https://ssip.org.uk/about/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read SSIP’s explanation of the scheme', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/commercial-5.jpg', ['alt' => 'Commercial glazing installation by Fenster Glazing', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('What it means for your project', 'fenster'); ?></p>
                        <h2><?php esc_html_e('It is not a blanket approval for every site or every kind of work.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('SSIP looks at health and safety capability at the pre-qualification stage. It does not replace project-specific risk assessments, method statements, design responsibility, product approvals or the checks needed for work on your site.', 'fenster'); ?></p>
                        <p><?php esc_html_e('That is why we still review the scope, access, programme and glazing specification with you before work begins. For a domestic installation, the same care applies, but SSIP is primarily useful as commercial procurement evidence rather than a homeowner certificate.', 'fenster'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-ssip-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Plan the work safely', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Bring us in before the glazing package is fixed.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us about the site, programme and scope. We will discuss the survey, access, specification and safety information that applies to your individual project.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('Commercial glazing support, with the project detail properly considered.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'SSIP health and safety page',
                        'button_label' => 'Send commercial enquiry',
                        'project_type' => 'Commercial glazing project',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
