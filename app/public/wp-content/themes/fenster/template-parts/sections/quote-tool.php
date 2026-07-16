<?php
/**
 * Quote and visualiser landing pages.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$title = (string) ($args['title'] ?? ($page['title'] ?? 'Start your Fenster quote'));
$slug = (string) ($page['slug'] ?? '');
$instant_quote_preview = (string) ($args['instant_quote_preview'] ?? '');
$instant_quote_url = (string) ($args['instant_quote_url'] ?? 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing');
$is_visualiser = $slug === '3d-visualiser' || str_contains($slug, 'design');
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$hero_heading = $is_visualiser ? 'Visualise your windows and doors with Fenster.' : 'Start your window and door quote.';
$hero_copy = $is_visualiser
    ? 'Explore product styles, colours and glazing choices, then send us the details so we can check the specification with you.'
    : 'Use the product selector as a starting point, then we can confirm the details, survey requirements and next steps with you.';
$steps = [
    ['title' => 'Choose a product', 'copy' => 'Pick the window, door or glazing option you want to price.'],
    ['title' => 'Get your quote', 'copy' => 'Use the online tool to choose sizes, layouts, colours and options.'],
    ['title' => 'We get in touch', 'copy' => 'We check the details, survey needs and next steps before anything is ordered.'],
];
?>

<article class="fg-quote-page">
    <section class="fg-quote-hero">
        <div class="container fg-quote-hero__grid">
            <div class="fg-quote-hero__copy">
                <p class="eyebrow"><?php echo esc_html($is_visualiser ? 'Product visualiser' : 'Instant pricing'); ?></p>
                <h1><?php echo esc_html($hero_heading); ?></h1>
                <p><?php echo esc_html($hero_copy); ?></p>
                <div class="button-row">
                    <a class="button" href="#quote-form"><?php esc_html_e('Send quote details', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Talk to the team', 'fenster'); ?></a>
                </div>
            </div>
            <article class="fg-quote-hero__media fg-quote-hero__embed">
                <div class="fg-quote-hero__embed-bar">
                    <h2><?php esc_html_e('Instant quote tool', 'fenster'); ?></h2>
                    <div class="fg-quote-hero__embed-actions">
                        <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                        <a class="button" href="<?php echo esc_url($instant_quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                        <a class="button fg-quote-hero__mobile-open" href="<?php echo esc_url($instant_quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                    </div>
                </div>
                <div class="fg-quote-hero__embed-frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($instant_quote_url); ?>" data-quote-autoload="idle">
                    <div class="fg-quote-frame-placeholder">
                        <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                        <span><?php esc_html_e('The designer loads after the page settles, or you can open it now.', 'fenster'); ?></span>
                        <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                    </div>
                    <iframe
                        data-quote-iframe-src="<?php echo esc_url($instant_quote_url); ?>"
                        title="<?php esc_attr_e('Fenster instant quote tool', 'fenster'); ?>"
                        loading="lazy"
                        allow="fullscreen"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </article>
        </div>
    </section>

    <section class="fg-quote-steps">
        <div class="container">
            <div class="fg-quote-section-head">
                <p class="eyebrow"><?php esc_html_e('How it works', 'fenster'); ?></p>
                <h2><?php esc_html_e('A quick starting point before the final survey.', 'fenster'); ?></h2>
            </div>
            <div class="fg-quote-steps__grid">
                <?php foreach ($steps as $index => $step) : ?>
                    <article>
                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="quote-form" class="fg-quote-form-section">
        <div class="container fg-quote-form-section__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Send the basics', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you are looking for.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Share the useful details and our team will receive the enquiry directly. You can attach drawings, schedules or photos to the form if they help.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => $is_visualiser ? 'Visualiser' : 'Online quote',
                'button_label' => 'Send quote details',
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--quote',
            'eyebrow' => 'Trusted locally',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Useful pages', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products and services to explore next', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach (array_slice(array_values($related_links), 0, 18) as $link) : ?>
                        <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>
