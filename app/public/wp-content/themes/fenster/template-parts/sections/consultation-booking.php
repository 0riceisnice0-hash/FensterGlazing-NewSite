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
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$booking_notes = [
    'Choose a weekday within the next 30 days.',
    'Select a preferred time from 9am to 4pm.',
    'Fenster confirms the appointment directly with you.',
];
$steps = [
    ['number' => '01', 'title' => 'Pick a date', 'copy' => 'Choose the weekday that suits you from the next 30 days.'],
    ['number' => '02', 'title' => 'Choose a time', 'copy' => 'Select your preferred appointment time between 9am and 4pm.'],
    ['number' => '03', 'title' => 'We confirm it', 'copy' => 'Leave your details and the Fenster team will confirm the appointment with you.'],
];
$faqs = [
    ['question' => 'How do I book a consultation?', 'answer' => 'Choose an available weekday, select a preferred time and leave your contact details. Fenster will then confirm the appointment directly with you.'],
    ['question' => 'Is my chosen time confirmed immediately?', 'answer' => 'No. Your selected date and time are a preferred appointment request. The Fenster team checks availability and confirms the appointment by phone or email.'],
    ['question' => 'What can I discuss at a consultation?', 'answer' => 'You can discuss windows, doors, glazing, repairs, roof lanterns, colour choices, project plans or a showroom visit with the Fenster team.'],
];
$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ],
        $faqs
    ),
];
?>

<article class="fg-consultation-page">
    <section class="fg-consultation-page__hero">
        <div class="container fg-consultation-page__hero-grid">
            <div class="fg-consultation-page__hero-copy">
                <p class="eyebrow"><?php esc_html_e('Fenster Glazing · Milton Keynes', 'fenster'); ?></p>
                <h1><?php esc_html_e('Book a window and door consultation.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Choose a preferred weekday and time to talk through your windows, doors, glazing or project plans with the Fenster team.', 'fenster'); ?></p>
                <div class="fg-consultation-page__hero-actions">
                    <a class="button" href="#book-consultation"><?php esc_html_e('Choose a date', 'fenster'); ?></a>
                    <a class="text-link" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                </div>
                <ul class="fg-consultation-page__notes" aria-label="<?php esc_attr_e('Consultation booking details', 'fenster'); ?>">
                    <?php foreach ($booking_notes as $note) : ?>
                        <li><?php echo esc_html($note); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-consultation-form fg-consultation-page__form',
                'id' => 'book-consultation',
                'source' => 'Dedicated consultation booking page',
                'button_label' => 'Request consultation',
                'consultation_booking' => true,
            ]);
            ?>
        </div>
    </section>

    <section class="fg-consultation-page__trust" aria-label="<?php esc_attr_e('Fenster trust and accreditation', 'fenster'); ?>">
        <div class="container">
            <p><?php esc_html_e('Local advice, survey-led fitting and recognised customer protection.', 'fenster'); ?></p>
            <div class="fg-consultation-page__trust-items">
                <?php foreach ($trust_items as $item) : ?>
                    <img src="<?php echo esc_url((string) ($item['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($item['alt'] ?? '')); ?>" loading="lazy">
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__steps">
        <div class="container">
            <div class="fg-consultation-page__section-head">
                <p class="eyebrow"><?php esc_html_e('How booking works', 'fenster'); ?></p>
                <h2><?php esc_html_e('A simple route to the right conversation.', 'fenster'); ?></h2>
            </div>
            <div class="fg-consultation-page__steps-grid">
                <?php foreach ($steps as $step) : ?>
                    <article>
                        <span><?php echo esc_html($step['number']); ?></span>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__support">
        <div class="container fg-consultation-page__support-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Advice before decisions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Bring the questions that are hard to answer online.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A consultation is useful when you want to compare products, work through an extension, understand colour and glazing options, or decide whether a showroom visit or survey is the right next step.', 'fenster'); ?></p>
            </div>
            <div class="fg-consultation-page__support-contact">
                <span><?php esc_html_e('Prefer to speak now?', 'fenster'); ?></span>
                <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__faq">
        <div class="container fg-consultation-page__faq-grid">
            <div class="fg-consultation-page__section-head">
                <p class="eyebrow"><?php esc_html_e('Booking questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('What to expect from your request.', 'fenster'); ?></h2>
            </div>
            <div>
                <?php foreach ($faqs as $faq) : ?>
                    <article>
                        <h3><?php echo esc_html($faq['question']); ?></h3>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--consultation',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Explore Fenster', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products and services to consider before we talk.', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach (array_slice(array_values($related_links), 0, 12) as $link) : ?>
                        <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>

<script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
