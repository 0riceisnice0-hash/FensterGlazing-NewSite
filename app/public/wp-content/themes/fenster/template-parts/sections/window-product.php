<?php
/**
 * Shared dedicated window product page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$slug = sanitize_key((string) ($args['slug'] ?? ''));
$product = function_exists('fenster_window_product_page') ? fenster_window_product_page($slug) : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];

if (empty($product)) {
    return;
}

$asset_path = static fn (string $path): string => '/wp-content/themes/fenster/assets/images/products/' . ltrim($path, '/');
$asset_url = static fn (string $path): string => fenster_generated_url('/wp-content/themes/fenster/assets/images/products/' . ltrim($path, '/'));
$collection = in_array($slug, ['aluminium-windows', 'aluminium-flush-windows', 'heritage-windows'], true) ? '5' : '0';
$quote_url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=' . $collection;
$selector_id = 'fg-window-selector-' . $slug;
$faqs = is_array($product['faqs'] ?? null) ? array_slice($product['faqs'], 0, 5) : [];
$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => (string) ($faq['q'] ?? ''),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => (string) ($faq['a'] ?? ''),
            ],
        ],
        $faqs
    ),
];
?>

<main id="main-content" class="fg-window-page fg-window-page--<?php echo esc_attr($slug); ?>">
    <article>
        <section class="fg-window-hero">
            <div class="container fg-window-hero__grid">
                <div class="fg-window-hero__copy">
                    <p class="eyebrow"><?php echo esc_html((string) $product['eyebrow']); ?></p>
                    <h1><?php echo esc_html((string) $product['title']); ?></h1>
                    <p class="fg-window-hero__lead"><?php echo esc_html((string) $product['lead']); ?></p>
                    <div class="fg-window-hero__actions">
                        <a class="button" href="#fenster-window-enquiry"><?php esc_html_e('Get a window quote', 'fenster'); ?></a>
                        <a class="button button--steel" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                    <ul class="fg-window-hero__reassurance" aria-label="<?php esc_attr_e('Product reassurance', 'fenster'); ?>">
                        <?php foreach ((array) $product['reassurance'] as $item) : ?>
                            <li><?php echo esc_html((string) $item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <figure class="fg-window-hero__media">
                    <img src="<?php echo esc_url($asset_url((string) $product['hero'])); ?>" alt="<?php echo esc_attr((string) $product['hero_alt']); ?>" loading="eager" fetchpriority="high"<?php echo fenster_image_attr_string($asset_path((string) $product['hero'])); ?>>
                    <figcaption><?php echo esc_html((string) $product['eyebrow']); ?></figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-window-facts" aria-label="<?php esc_attr_e('Product specification summary', 'fenster'); ?>">
            <div class="container fg-window-facts__grid">
                <?php foreach ((array) $product['facts'] as $fact) : ?>
                    <p><strong><?php echo esc_html((string) ($fact['value'] ?? '')); ?></strong><span><?php echo esc_html((string) ($fact['label'] ?? '')); ?></span></p>
                <?php endforeach; ?>
            </div>
        </section>

        <?php $selector = is_array($product['selector'] ?? null) ? $product['selector'] : []; ?>
        <?php if (! empty($selector['options'])) : ?>
            <section class="fg-window-selector" data-fg-window-selector>
                <div class="container">
                    <div class="fg-window-selector__heading">
                        <p class="eyebrow"><?php echo esc_html((string) ($selector['eyebrow'] ?? 'Compare the options')); ?></p>
                        <h2><?php echo esc_html((string) ($selector['title'] ?? 'Choose the right arrangement.')); ?></h2>
                        <p><?php echo esc_html((string) ($selector['intro'] ?? '')); ?></p>
                    </div>
                    <div class="fg-window-selector__tabs" role="tablist" aria-label="<?php echo esc_attr((string) ($selector['title'] ?? 'Window options')); ?>">
                        <?php foreach ((array) $selector['options'] as $index => $option) : ?>
                            <button
                                id="<?php echo esc_attr($selector_id . '-tab-' . $index); ?>"
                                type="button"
                                role="tab"
                                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr($selector_id . '-panel-' . $index); ?>"
                                tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                                data-fg-window-tab="<?php echo esc_attr((string) $index); ?>"
                            >
                                <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                <strong><?php echo esc_html((string) ($option['title'] ?? '')); ?></strong>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="fg-window-selector__panels">
                        <?php foreach ((array) $selector['options'] as $index => $option) : ?>
                            <article
                                id="<?php echo esc_attr($selector_id . '-panel-' . $index); ?>"
                                class="fg-window-selector__panel"
                                role="tabpanel"
                                aria-labelledby="<?php echo esc_attr($selector_id . '-tab-' . $index); ?>"
                                data-fg-window-panel="<?php echo esc_attr((string) $index); ?>"
                            >
                                <figure>
                                    <img src="<?php echo esc_url($asset_url((string) ($option['image'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($option['alt'] ?? $option['title'] ?? 'Window option')); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"<?php echo fenster_image_attr_string($asset_path((string) ($option['image'] ?? ''))); ?>>
                                </figure>
                                <div>
                                    <p class="eyebrow"><?php echo esc_html((string) ($option['kicker'] ?? '')); ?></p>
                                    <h3><?php echo esc_html((string) ($option['title'] ?? '')); ?></h3>
                                    <p><?php echo esc_html((string) ($option['copy'] ?? '')); ?></p>
                                    <a class="text-link" href="#fenster-window-enquiry"><?php esc_html_e('Ask about this option', 'fenster'); ?></a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php foreach ((array) ($product['stories'] ?? []) as $index => $story) : ?>
            <section class="fg-window-story <?php echo $index % 2 ? 'fg-window-story--reverse' : ''; ?>">
                <div class="container fg-window-story__grid">
                    <figure>
                        <img src="<?php echo esc_url($asset_url((string) ($story['image'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($story['alt'] ?? $story['title'] ?? 'Window detail')); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path((string) ($story['image'] ?? ''))); ?>>
                    </figure>
                    <div>
                        <p class="eyebrow"><?php echo esc_html((string) ($story['eyebrow'] ?? '')); ?></p>
                        <h2><?php echo esc_html((string) ($story['title'] ?? '')); ?></h2>
                        <p><?php echo esc_html((string) ($story['copy'] ?? '')); ?></p>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>

        <?php $system = is_array($product['system'] ?? null) ? $product['system'] : []; ?>
        <section class="fg-window-system">
            <div class="container fg-window-system__grid">
                <div class="fg-window-system__copy">
                    <p class="eyebrow"><?php echo esc_html((string) ($system['label'] ?? 'Window system')); ?></p>
                    <h2><?php echo esc_html((string) ($system['title'] ?? '')); ?></h2>
                    <p><?php echo esc_html((string) ($system['copy'] ?? '')); ?></p>
                    <dl>
                        <?php foreach ((array) ($system['specs'] ?? []) as $spec) : ?>
                            <div><dt><?php echo esc_html((string) ($spec[0] ?? '')); ?></dt><dd><?php echo esc_html((string) ($spec[1] ?? '')); ?></dd></div>
                        <?php endforeach; ?>
                    </dl>
                    <p class="fg-window-system__note"><?php esc_html_e('Published figures come from the manufacturer’s stated configurations. We confirm the value and certification for the actual size, glass and opening schedule before order.', 'fenster'); ?></p>
                </div>
                <figure>
                    <img src="<?php echo esc_url($asset_url((string) ($system['image'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($system['alt'] ?? $system['label'] ?? 'Window system')); ?>" loading="lazy"<?php echo fenster_image_attr_string($asset_path((string) ($system['image'] ?? ''))); ?>>
                </figure>
            </div>
        </section>

        <section class="fg-window-choices">
            <div class="container">
                <div class="fg-window-choices__heading">
                    <p class="eyebrow"><?php esc_html_e('Finish the specification', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose colour, glass and handles together.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('These choices change how the complete elevation reads. Compare them before the final order, not after the frame layout is fixed.', 'fenster'); ?></p>
                </div>
                <div class="fg-window-choices__grid">
                    <?php foreach ((array) ($product['choices'] ?? []) as $index => $choice) : ?>
                        <a href="<?php echo esc_url(home_url((string) ($choice['url'] ?? '/'))); ?>">
                            <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <h3><?php echo esc_html((string) ($choice['title'] ?? '')); ?></h3>
                            <p><?php echo esc_html((string) ($choice['copy'] ?? '')); ?></p>
                            <strong><?php esc_html_e('Compare options', 'fenster'); ?></strong>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php if (! empty($faqs)) : ?>
            <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
            <section class="fg-product-faq fg-window-faq">
                <div class="container fg-product-faq__grid">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Questions before you choose', 'fenster'); ?></p>
                        <h2><?php echo esc_html('What to know about ' . strtolower((string) $product['title']) . '.'); ?></h2>
                    </div>
                    <div class="fg-product-faq__items">
                        <?php foreach ($faqs as $index => $faq) : ?>
                            <details <?php echo $index === 0 ? 'open' : ''; ?>>
                                <summary><?php echo esc_html((string) ($faq['q'] ?? '')); ?></summary>
                                <div class="fg-product-faq__answer"><p><?php echo esc_html((string) ($faq['a'] ?? '')); ?></p></div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section id="fenster-product-quote" class="fg-product-quote-embed fg-window-quote" aria-label="<?php echo esc_attr((string) $product['quote_label']); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php echo esc_html((string) $product['quote_label']); ?></h2>
                    <p><?php esc_html_e('Choose a layout, enter rough sizes and compare colours and options. The survey confirms the final measurements, glass, performance and installation detail before anything is ordered.', 'fenster'); ?></p>
                    <a class="button fg-window-quote__mobile-action" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open the quote tool', 'fenster'); ?></a>
                </div>
                <article class="fg-product-quote-embed__card" data-quote-card>
                    <div class="fg-product-quote-embed__bar">
                        <h3><?php esc_html_e('WindowCAD quote tool', 'fenster'); ?></h3>
                        <div class="fg-product-quote-embed__actions">
                            <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                            <a class="button" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                            <a class="button fg-product-quote-embed__mobile-open" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                        </div>
                    </div>
                    <div class="fg-product-quote-embed__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="near">
                        <div class="fg-quote-frame-placeholder fg-product-quote-embed__placeholder">
                            <strong><?php esc_html_e('WindowCAD quote tool', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                            <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                        </div>
                        <iframe data-quote-iframe-src="<?php echo esc_url($quote_url); ?>" title="<?php echo esc_attr((string) $product['quote_label']); ?>" loading="lazy" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </article>
            </div>
        </section>

        <section id="fenster-window-enquiry" class="fg-window-enquiry">
            <div class="container fg-window-enquiry__grid">
                <div class="fg-window-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send the opening sizes or a few photographs.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us which rooms or elevations are involved and what you want to change. Rough sizes and photographs help us prepare, but they are not required for the first conversation.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('Property postcode and number of windows', 'fenster'); ?></li>
                        <li><?php esc_html_e('Preferred material, style and colour if known', 'fenster'); ?></li>
                        <li><?php esc_html_e('Any ventilation, noise, access or planning concerns', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-window-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form fg-window-product-form',
                        'source' => 'Window Product: ' . (string) $product['title'],
                        'button_label' => 'Send window enquiry',
                        'project_type' => (string) $product['project_type'],
                        'lock_project_type' => true,
                    ]); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--window-product', 'trust_items' => $trust_items, 'limit' => 7]); ?>

        <section class="fg-window-related">
            <div class="container fg-window-related__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Compare the range', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Not sure this is the right window type?', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Use the windows overview to compare uPVC, aluminium, sash and heritage options before narrowing the specification.', 'fenster'); ?></p>
                </div>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/windows-milton-keynes/')); ?>"><?php esc_html_e('Compare all windows', 'fenster'); ?></a>
            </div>
        </section>
    </article>
</main>
