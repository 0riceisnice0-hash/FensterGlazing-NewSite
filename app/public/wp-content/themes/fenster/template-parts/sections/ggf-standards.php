<?php
/**
 * Dedicated Glass and Glazing Federation guidance page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<div class="fg-fensa-page fg-ggf-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('What is GGF guidance?', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Glass standards, explained in plain English.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('The GGF is the Glass and Glazing Federation, an industry body that publishes technical and consumer guidance. We use relevant guidance to assess new glass fairly, explain what is normal and investigate anything that may be a genuine defect.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-ggf-enquiry"><?php esc_html_e('Ask about your windows or doors', 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="What GGF guidance means for you">
                    <p class="eyebrow"><?php esc_html_e('What this means for you', 'fenster'); ?></p>
                    <h2><?php esc_html_e('A fair way to look at new glass.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('We use relevant visual-quality guidance when checking glass', 'fenster'); ?></li>
                        <li><?php esc_html_e('Normal optical effects are not confused with faults', 'fenster'); ?></li>
                        <li><?php esc_html_e('Genuine concerns are checked properly and explained clearly', 'fenster'); ?></li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="fg-fensa-stories">
            <div class="container">
                <div class="fg-fensa-story">
                    <figure class="fg-ggf-story__image">
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/imported/Woburn-Waters-End-Barn-3.png', ['alt' => 'Fenster installation showing GGF and Fenster branding', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('How it works with Fenster', 'fenster'); ?></p>
                        <h2><?php esc_html_e('New glass is not judged from inches away.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Modern double and triple glazing can show subtle reflections, slight distortion or tiny marks in certain light. That does not automatically mean the glass is faulty. The relevant GGF guidance helps set a sensible, consistent way to assess appearance rather than treating every natural manufacturing effect as a defect.', 'fenster'); ?></p>
                        <p><?php esc_html_e('If you are concerned about a pane, show us. We will look at it in the right conditions, explain what we see and arrange the appropriate next step if there is a genuine issue.', 'fenster'); ?></p>
                        <a class="text-link" href="https://www.ggf.org.uk/downloads/consumer-leaflets/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Read GGF consumer guidance', 'fenster'); ?></a>
                    </div>
                </div>

                <div class="fg-fensa-story fg-fensa-story--reverse">
                    <figure>
                        <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', ['alt' => 'Close view of a heritage-style replacement window', 'loading' => 'lazy']); ?>>
                    </figure>
                    <div class="fg-fensa-story__copy">
                        <p class="eyebrow"><?php esc_html_e('What it means for your project', 'fenster'); ?></p>
                        <h2><?php esc_html_e('GGF guidance is not the same as FENSA or your guarantee.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('GGF guidance helps us make fair technical and visual assessments of glazing. For eligible replacement work, FENSA records Building Regulations compliance. Your Fenster guarantee covers the work we promise to do, with separate CPA-backed protection available for qualifying installations if we ever stop trading.', 'fenster'); ?></p>
                        <p><?php esc_html_e('We will tell you what applies to your project before you order and make the paperwork clear after installation.', 'fenster'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fenster-ggf-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Need a straight answer?', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Ask us about the glass in your project.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us what you are planning, or send photos if there is an existing concern. We will explain the practical options, inspection approach and next step without technical jargon.', 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('We will explain what is normal, what needs checking and what we can do next.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'GGF standards page',
                        'button_label' => 'Send project enquiry',
                        'project_type' => 'Windows and doors',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
