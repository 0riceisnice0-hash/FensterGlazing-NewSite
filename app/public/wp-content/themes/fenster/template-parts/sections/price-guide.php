<?php
/**
 * Transparent price guide pages.
 *
 * Customer-facing by owner instruction (2026-07-20): these pages are live, so
 * nothing on them may read like an internal plan. Placeholder examples with no
 * confirmed price are never rendered; only checked examples with a real fitted
 * price appear. The quote-station iframe block must stay intact, including its
 * data-quote-* attributes and the placeholder markup, because src/js/main.js
 * owns the deferred loading behaviour.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$all_guides = function_exists('fenster_price_guide_pages') ? fenster_price_guide_pages() : [];
$slug = (string) ($page['slug'] ?? '');
$title = (string) ($page['title'] ?? 'Window and door prices');
$intro = (string) ($page['intro'] ?? '');
$product = (string) ($page['product'] ?? 'windows and doors');
$quote_url = (string) ($page['quote_url'] ?? 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing');
$examples = is_array($page['examples'] ?? null) ? array_values($page['examples']) : [];
$moves = is_array($page['moves'] ?? null) ? array_values($page['moves']) : [];
$linked_slugs = is_array($page['links'] ?? null) ? array_values($page['links']) : [];

/*
 * Only examples with a confirmed £ price are shown to customers. The data file
 * still holds "To confirm from WindowCAD" rows as internal slots; they must
 * never render publicly.
 */
$checked = array_values(array_filter(
    $examples,
    static fn (array $example): bool => str_starts_with((string) ($example['price'] ?? ''), '£')
));

$faqs = [
    [
        'question' => 'Are the prices on this page real?',
        'answer' => 'Yes. Each checked example is a real fitted price from our pricing software for the exact specification shown, including VAT. The same software prices your job in the quote tool.',
    ],
    [
        'question' => 'Do the prices include VAT and fitting?',
        'answer' => 'Yes. Every checked example is a fitted price including VAT. The only thing that can move it is the survey, once we have measured your opening properly, and we tell you before you order.',
    ],
    [
        'question' => 'Why can the same product cost different amounts?',
        'answer' => 'Size, colour, glass, vents, handles, thresholds and access all change the fitted price. The quote tool lets you test each choice and watch the number move before anyone visits your home.',
    ],
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

<article class="fg-price-guide">
    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>

    <section class="fg-price-guide__hero">
        <div class="container fg-price-guide__hero-grid">
            <div class="fg-price-guide__hero-copy">
                <p class="eyebrow"><?php esc_html_e('Transparent pricing', 'fenster'); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <p><?php echo esc_html($intro); ?></p>
                <div class="button-row">
                    <a class="button" href="#fenster-instant-pricing"><?php esc_html_e('Price your own job', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-price-guide__glance" aria-label="<?php esc_attr_e('Checked fitted prices at a glance', 'fenster'); ?>">
                <?php if ($checked !== []) : ?>
                    <strong><?php esc_html_e('Checked fitted prices', 'fenster'); ?></strong>
                    <ul>
                        <?php foreach ($checked as $example) : ?>
                            <li>
                                <span><?php echo esc_html((string) ($example['spec'] ?? '')); ?></span>
                                <em><?php echo esc_html((string) ($example['price'] ?? '')); ?></em>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p><?php esc_html_e('Fitted prices including VAT, checked July 2026. Full details below.', 'fenster'); ?></p>
                <?php else : ?>
                    <strong><?php esc_html_e('Your price in minutes', 'fenster'); ?></strong>
                    <p><?php echo esc_html(sprintf('Choose your %s, sizes, colours and glass in the quote tool below and it prices as you go, from the same list our office quotes from.', $product)); ?></p>
                <?php endif; ?>
            </aside>
        </div>
    </section>

    <?php if ($checked !== []) : ?>
        <section class="fg-price-guide__examples">
            <div class="container">
                <div class="fg-price-guide__section-head">
                    <p class="eyebrow"><?php esc_html_e('Checked examples', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Real products, real fitted prices.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('No vague price ranges. Each example below is a full specification priced in our software, fitted and including VAT, alongside our own installation photos where we have fitted the same product.', 'fenster'); ?></p>
                </div>
                <div class="fg-price-guide__example-stack">
                    <?php foreach ($checked as $index => $example) : ?>
                        <?php
                        $photo = (string) ($example['photo'] ?? '');
                        $config_image = (string) ($example['image'] ?? '');
                        $media = $photo !== '' ? $photo : $config_image;
                        $media_alt = $photo !== ''
                            ? (string) ($example['photo_alt'] ?? $example['spec'] ?? 'Fenster installation photo')
                            : (string) ($example['image_alt'] ?? $example['spec'] ?? 'Priced configuration');
                        ?>
                        <article class="fg-price-guide__example <?php echo esc_attr($index % 2 ? 'fg-price-guide__example--reverse' : ''); ?>">
                            <div class="fg-price-guide__example-copy">
                                <p class="eyebrow"><?php echo esc_html(sprintf('Example %02d', $index + 1)); ?></p>
                                <h3><?php echo esc_html((string) ($example['spec'] ?? 'Checked example')); ?></h3>
                                <p><?php echo esc_html((string) ($example['details'] ?? '')); ?></p>
                                <span class="fg-price-guide__price"><?php echo esc_html((string) ($example['price'] ?? '')); ?><em><?php esc_html_e('fitted', 'fenster'); ?></em></span>
                                <small><?php esc_html_e('The survey confirms the final details before anything is made.', 'fenster'); ?></small>
                                <?php if ($photo !== '' && $config_image !== '') : ?>
                                    <figure class="fg-price-guide__config">
                                        <img <?php echo fenster_image_attr_string($config_image, ['alt' => (string) ($example['image_alt'] ?? 'The exact configuration we priced'), 'loading' => 'lazy']); ?>>
                                        <figcaption><?php esc_html_e('The exact configuration behind this price', 'fenster'); ?></figcaption>
                                    </figure>
                                <?php endif; ?>
                            </div>
                            <figure class="fg-price-guide__example-media<?php echo $photo === '' ? ' fg-price-guide__example-media--config' : ''; ?>">
                                <img <?php echo fenster_image_attr_string($media, ['alt' => $media_alt, 'loading' => $index === 0 ? 'eager' : 'lazy']); ?>>
                                <?php if (! empty($example['photo_caption'])) : ?>
                                    <figcaption><?php echo esc_html((string) $example['photo_caption']); ?></figcaption>
                                <?php endif; ?>
                            </figure>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-price-guide__factors">
        <div class="container fg-price-guide__factors-grid">
            <div class="fg-price-guide__factors-copy">
                <p class="eyebrow"><?php esc_html_e('What changes the price', 'fenster'); ?></p>
                <h2><?php esc_html_e('The choices that move the number.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No two openings are quite the same, which is why one-size price lists are usually fiction. These are the choices that genuinely change the fitted price, and you can test every one of them in the quote tool before anyone visits.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="#fenster-instant-pricing"><?php esc_html_e('Try it on your job', 'fenster'); ?></a>
                </div>
            </div>
            <ul class="fg-price-guide__factor-list">
                <?php foreach ($moves as $move) : ?>
                    <li><?php echo esc_html((string) $move); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="fg-price-guide__faq">
        <div class="container fg-price-guide__faq-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Pricing questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('The questions everyone asks about price.', 'fenster'); ?></h2>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="fenster-instant-pricing" class="fg-home-quote-station fg-home-quote-station--bridge fg-price-guide__quote-station">
        <div class="container fg-home-quote-station__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Ready for your number?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Price your exact job, right here.', 'fenster'); ?></h2>
                <p><?php echo esc_html(sprintf('Choose your %s, sizes, colours, glass and hardware, and watch the price build as you go. It is the same software behind every checked example on this page.', $product)); ?></p>
                <ul class="fg-home-quote-station__points">
                    <li><?php esc_html_e('A real figure in about ten minutes', 'fenster'); ?></li>
                    <li><?php esc_html_e('See how each choice moves the price', 'fenster'); ?></li>
                    <li><?php esc_html_e('We check the final details at survey', 'fenster'); ?></li>
                </ul>
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
            </div>
            <div class="fg-home-quote-station__preview" data-quote-frame-wrap data-quote-card data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="near">
                <div class="fg-quote-frame-placeholder">
                    <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                    <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                    <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                </div>
                <iframe
                    data-quote-iframe-src="<?php echo esc_url($quote_url); ?>"
                    title="<?php echo esc_attr($title . ' instant quote tool'); ?>"
                    loading="lazy"
                    allow="fullscreen"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <?php if (! empty($linked_slugs)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Related price guides', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Compare the products that affect your budget.', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach ($linked_slugs as $linked_slug) : ?>
                        <?php
                        $linked_page = $all_guides[$linked_slug] ?? ($linked_slug !== '' && function_exists('fenster_get_generated_page') ? fenster_get_generated_page((string) $linked_slug) : null);
                        if (! is_array($linked_page)) {
                            continue;
                        }
                        ?>
                        <a href="<?php echo esc_url(fenster_generated_url((string) ($linked_page['url'] ?? home_url('/' . $linked_slug . '/')))); ?>"><?php echo esc_html((string) ($linked_page['label'] ?? $linked_page['title'] ?? ucwords(str_replace('-', ' ', (string) $linked_slug)))); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>
