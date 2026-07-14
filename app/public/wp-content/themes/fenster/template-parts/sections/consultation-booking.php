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
$hero_image = [
    'src' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png',
    'alt' => 'Fenster Glazing showroom in Milton Keynes',
];
$decision_topics = [
    [
        'title' => 'Open up an extension',
        'copy' => 'Compare bifold doors, sliding doors and the glazing that makes a new room feel connected to the garden.',
        'url' => '/bifold-doors-milton-keynes/',
        'image' => FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-bifold-exterior.jpg',
        'alt' => 'Anthracite grey bifold doors opening onto a patio',
    ],
    [
        'title' => 'Choose an entrance',
        'copy' => 'Talk through door styles, colour, glass and security details before choosing a front door for your home.',
        'url' => '/composite-doors-milton-keynes/',
        'image' => FENSTER_THEME_URI . '/assets/images/products/curated/distinction-composite-door-installed.jpg',
        'alt' => 'Light blue composite front door installed at a home',
    ],
    [
        'title' => 'Bring in more light',
        'copy' => 'See how roof lanterns, glazing and window choices can change the light and comfort of an existing room.',
        'url' => '/roof-lanterns-milton-keynes/',
        'image' => FENSTER_THEME_URI . '/assets/images/imported/S1-Lantern-Lounge-with-LEDs-min-scaled.jpg',
        'alt' => 'Bright living room with a roof lantern and glazed doors',
    ],
];
$booking_trust = [
    ['title' => 'Rated Excellent', 'copy' => 'Independent feedback on Trustpilot.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
];
$consultation_links = [
    ['text' => 'Windows in Milton Keynes', 'url' => '/windows-milton-keynes/'],
    ['text' => 'Doors in Milton Keynes', 'url' => '/doors-milton-keynes/'],
    ['text' => 'Roof lanterns', 'url' => '/roof-lanterns-milton-keynes/'],
    ['text' => 'Why trust Fenster Glazing', 'url' => '/why-trust-fenster/'],
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
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
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
                <h1><?php esc_html_e('Book a window and door consultation in Milton Keynes.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Choose a weekday and a preferred time. We will confirm your appointment directly and help you make the right decisions for your home.', 'fenster'); ?></p>
                <figure class="fg-consultation-page__hero-image">
                    <img <?php echo fenster_image_attr_string((string) $hero_image['src'], ['alt' => (string) $hero_image['alt'], 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                    <figcaption><?php esc_html_e('See products, finishes and options at our Milton Keynes showroom.', 'fenster'); ?></figcaption>
                </figure>
            </div>

            <div class="fg-consultation-page__booking">
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-consultation-form fg-consultation-page__form',
                    'id' => 'book-consultation',
                    'source' => 'Dedicated consultation booking page',
                    'button_label' => 'Request consultation',
                    'consultation_booking' => true,
                ]);
                ?>
                <aside class="fg-consultation-page__booking-trust" aria-label="<?php esc_attr_e('Booking reassurance', 'fenster'); ?>">
                    <?php foreach ($booking_trust as $trust) : ?>
                        <?php if (is_array($trust['item'])) : ?>
                            <div>
                                <img <?php echo fenster_image_attr_string((string) $trust['item']['src'], ['alt' => (string) $trust['item']['alt'], 'loading' => 'lazy']); ?>>
                                <p><strong><?php echo esc_html($trust['title']); ?></strong><span><?php echo esc_html($trust['copy']); ?></span></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </aside>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__decisions">
        <div class="container">
            <div class="fg-consultation-page__section-head">
                <p class="eyebrow"><?php esc_html_e('Advice before decisions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Bring the questions that are hard to answer online.', 'fenster'); ?></h2>
            </div>
            <div class="fg-consultation-page__decisions-grid">
                <?php foreach ($decision_topics as $topic) : ?>
                    <a href="<?php echo esc_url(home_url((string) $topic['url'])); ?>" class="fg-consultation-page__decision-card">
                        <img <?php echo fenster_image_attr_string((string) $topic['image'], ['alt' => (string) $topic['alt'], 'loading' => 'lazy']); ?>>
                        <span>
                            <strong><?php echo esc_html($topic['title']); ?></strong>
                            <small><?php echo esc_html($topic['copy']); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__support">
        <div class="container fg-consultation-page__support-grid">
            <figure class="fg-consultation-page__support-image">
                <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/images/imported/Installation-4.jpg', ['alt' => 'Fenster windows and doors installed on a Milton Keynes home', 'loading' => 'lazy']); ?>>
            </figure>
            <div class="fg-consultation-page__support-copy">
                <p class="eyebrow"><?php esc_html_e('A useful next step', 'fenster'); ?></p>
                <h2><?php esc_html_e('Talk it through with a local team.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Whether you are replacing a single door or planning a larger project, we can help you compare options, understand practical considerations and decide what should happen next.', 'fenster'); ?></p>
            </div>
            <aside class="fg-consultation-page__support-contact">
                <span><?php esc_html_e('Prefer to speak now?', 'fenster'); ?></span>
                <a href="tel:<?php echo esc_attr($phone_href); ?>">
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.91.7 2.82a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.26-1.26a2 2 0 0 1 2.11-.45c.91.34 1.86.57 2.82.7A2 2 0 0 1 22 16.92Z"/></svg>
                    <span><small><?php esc_html_e('Call the Milton Keynes team', 'fenster'); ?></small><strong><?php echo esc_html($phone); ?></strong></span>
                </a>
                <a href="mailto:<?php echo esc_attr($email); ?>">
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    <span><small><?php esc_html_e('Email the team', 'fenster'); ?></small><strong><?php echo esc_html($email); ?></strong></span>
                </a>
            </aside>
        </div>
    </section>

    <section class="fg-consultation-page__faq">
        <div class="container fg-consultation-page__faq-grid">
            <div class="fg-consultation-page__faq-intro">
                <figure>
                    <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/images/imported/S1-Lantern-Lounge-with-LEDs-min-scaled.jpg', ['alt' => 'Living room with a roof lantern and glazed doors', 'loading' => 'lazy']); ?>>
                </figure>
                <div class="fg-consultation-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Booking questions', 'fenster'); ?></p>
                    <h2><?php esc_html_e('What to expect from your request.', 'fenster'); ?></h2>
                </div>
            </div>
            <div class="fg-consultation-page__faq-items">
                <?php foreach ($faqs as $faq) : ?>
                    <article>
                        <h3><?php echo esc_html($faq['question']); ?></h3>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--consultation', 'trust_items' => $trust_items, 'limit' => 7]); ?>

    <section class="fg-links-band fg-consultation-page__links">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow"><?php esc_html_e('Explore Fenster', 'fenster'); ?></p>
                <h2><?php esc_html_e('Not ready to book? Start with the right product.', 'fenster'); ?></h2>
            </div>
            <div class="generated-links">
                <?php foreach ($consultation_links as $link) : ?>
                    <a href="<?php echo esc_url(home_url((string) $link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</article>

<script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
