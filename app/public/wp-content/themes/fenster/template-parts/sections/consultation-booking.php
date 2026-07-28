<?php
/**
 * Dedicated consultation booking page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$booking_trust = [
    ['title' => 'Rated Excellent', 'copy' => 'Independent Trustpilot feedback.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
];
$faqs = [
    ['question' => 'Is the consultation free?', 'answer' => 'Yes. The visit, the measuring and the price we give you are free, and they stay free whether you go ahead with us or not. There is no charge for coming out and no fee to pay if you decide against the job.'],
    ['question' => 'How do I book a free consultation?', 'answer' => 'Choose an available weekday, select a preferred time and leave your contact details. We will then confirm the appointment directly with you.'],
    ['question' => 'Is my chosen time confirmed immediately?', 'answer' => 'No. Your selected date and time are a preferred appointment request. The Fenster team checks availability and confirms the appointment by phone or email.'],
    ['question' => 'What can I discuss at a consultation?', 'answer' => 'You can discuss windows, doors, glazing, repairs, roof lanterns, colour choices, project plans or a showroom visit with the Fenster team.'],
    ['question' => 'Which areas do you cover?', 'answer' => 'We visit homes across Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. Our showroom is in Milton Keynes, but the consultation happens at your property.'],
];
$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn (array $faq): array => [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
    ], $faqs),
];
?>

<article class="fg-consultation-page">
    <section class="fg-consultation-page__hero">
        <div class="container fg-consultation-page__hero-grid">
            <div class="fg-consultation-page__hero-copy">
                <p class="eyebrow"><?php esc_html_e('Fenster Glazing · Milton Keynes and surrounding areas', 'fenster'); ?></p>
                <h1><?php esc_html_e('Book a free consultation with an expert.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Choose a weekday and a preferred time, and one of our experts will come to you. They measure the openings properly, answer the awkward questions and price the job before they leave. The visit is free, whether you go ahead with us or not.', 'fenster'); ?></p>
                <p><?php esc_html_e('We cover Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. We will confirm your appointment directly.', 'fenster'); ?></p>
            </div>

            <div class="fg-consultation-page__booking">
                <?php get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-consultation-form fg-consultation-page__form',
                    'id' => 'book-consultation',
                    'source' => 'Dedicated consultation booking page',
                    'button_label' => 'Request consultation',
                    'consultation_booking' => true,
                ]); ?>
                <aside class="fg-consultation-page__booking-trust" aria-label="<?php esc_attr_e('Booking reassurance', 'fenster'); ?>">
                    <?php foreach ($booking_trust as $trust) : ?>
                        <?php if (is_array($trust['item'])) : ?>
                            <div>
                                <?php if (! empty($trust['item']['url'])) : ?>
                                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust['item']['url']); ?>"<?php echo fenster_trust_link_attrs($trust['item']); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $trust['item']['alt'])); ?>">
                                <?php endif; ?>
                                <img <?php echo fenster_image_attr_string((string) $trust['item']['src'], ['alt' => (string) $trust['item']['alt'], 'loading' => 'lazy']); ?>>
                                <?php if (! empty($trust['item']['url'])) : ?></a><?php endif; ?>
                                <p><strong><?php echo esc_html($trust['title']); ?></strong><span><?php echo esc_html($trust['copy']); ?></span></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </aside>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__story">
        <div class="container fg-consultation-page__story-grid">
            <figure class="fg-consultation-page__story-image">
                <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-bifold-exterior.jpg', ['alt' => 'Anthracite grey bifold doors opening onto a patio', 'loading' => 'lazy']); ?>>
            </figure>
            <div class="fg-consultation-page__story-copy">
                <p class="eyebrow"><?php esc_html_e('Advice before decisions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Bring the questions that are hard to answer online.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Whether you are replacing one door or planning a larger extension, a free consultation gives you time to compare the options that matter before you commit, with an expert who fits these for a living.', 'fenster'); ?></p>
                <ul>
                    <li><?php esc_html_e('Compare products, colour, glazing and practical details.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Talk through your home, your plans and the right next step.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Ask about a showroom visit, survey or installation timing.', 'fenster'); ?></li>
                </ul>
                <div class="fg-consultation-page__story-contact">
                    <span><?php esc_html_e('Prefer to speak now?', 'fenster'); ?></span>
                    <a href="tel:<?php echo esc_attr($phone_href); ?>">
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.91.7 2.82a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.26-1.26a2 2 0 0 1 2.11-.45c.91.34 1.86.57 2.82.7A2 2 0 0 1 22 16.92Z"/></svg>
                        <?php echo esc_html($phone); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr($email); ?>">
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        <?php echo esc_html($email); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__faq">
        <div class="container fg-consultation-page__faq-grid">
            <div class="fg-consultation-page__section-head">
                <p class="eyebrow"><?php esc_html_e('Booking questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('What to expect from your request.', 'fenster'); ?></h2>
            </div>
            <div class="fg-consultation-page__faq-items">
                <?php foreach ($faqs as $faq) : ?>
                    <article><h3><?php echo esc_html($faq['question']); ?></h3><p><?php echo esc_html($faq['answer']); ?></p></article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--consultation', 'trust_items' => $trust_items, 'limit' => 7]); ?>
</article>

<script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
