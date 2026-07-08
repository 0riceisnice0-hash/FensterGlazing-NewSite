<?php
/**
 * Transparent price guide pages.
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
$product_slug = (string) ($page['product_slug'] ?? '');
$quote_url = (string) ($page['quote_url'] ?? 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing');
$examples = is_array($page['examples'] ?? null) ? array_values($page['examples']) : [];
$moves = is_array($page['moves'] ?? null) ? array_values($page['moves']) : [];
$linked_slugs = is_array($page['links'] ?? null) ? array_values($page['links']) : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);
$source_product = $product_slug !== '' && function_exists('fenster_get_generated_page') ? fenster_get_generated_page($product_slug) : null;
$source_images = is_array($source_product['images'] ?? null) ? array_values($source_product['images']) : [];
$hero_image = $source_images[0] ?? null;
$detail_images = array_slice($source_images, 1, 3);
$checked_label = 'Guide template ready for July 2026 pricing';
$faqs = [
    [
        'question' => 'Are Fenster online prices exact?',
        'answer' => 'They are a strong starting point from the online pricing tool. The final order is confirmed after Fenster checks the specification and completes the survey where required.',
    ],
    [
        'question' => 'Does Fenster include VAT and fitting?',
        'answer' => 'Fenster public price guidance is intended to explain fitted homeowner projects. VAT, fitting, removal of old frames and survey requirements should be stated clearly on each checked example.',
    ],
    [
        'question' => 'Why can the same product cost different amounts?',
        'answer' => 'Size, colour, glass, vents, handles, thresholds, access and survey findings can all change the fitted price.',
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
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Price this in WindowCAD', 'fenster'); ?></a>
                    <a class="button button--light" href="#fenster-enquiry"><?php esc_html_e('Ask Fenster to check it', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-price-guide__quote-card" aria-label="<?php esc_attr_e('Price guide status', 'fenster'); ?>">
                <span><?php echo esc_html($checked_label); ?></span>
                <strong><?php esc_html_e('Real examples, not vague averages.', 'fenster'); ?></strong>
                <p><?php esc_html_e('The structure is ready. The example rows below are waiting for the confirmed WindowCAD prices, screenshots and install photos before we publish exact figures.', 'fenster'); ?></p>
            </aside>
        </div>
    </section>

    <section class="fg-price-guide__table-section">
        <div class="container">
            <div class="fg-price-guide__section-head">
                <p class="eyebrow"><?php esc_html_e('Example price table', 'fenster'); ?></p>
                <h2><?php echo esc_html('Typical ' . $product . ' examples'); ?></h2>
                <p><?php esc_html_e('These rows are the slots we will fill from checked WindowCAD configurations. Each one should use a real spec, show what is included, and say when it was checked.', 'fenster'); ?></p>
            </div>
            <div class="fg-price-guide__table-wrap">
                <table class="fg-price-guide__table">
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e('Example', 'fenster'); ?></th>
                            <th scope="col"><?php esc_html_e('Specification to show', 'fenster'); ?></th>
                            <th scope="col"><?php esc_html_e('Fitted guide price', 'fenster'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($examples as $example) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html((string) ($example['spec'] ?? 'Example configuration')); ?></th>
                                <td><?php echo esc_html((string) ($example['details'] ?? 'WindowCAD specification to confirm.')); ?></td>
                                <td><strong><?php echo esc_html((string) ($example['price'] ?? 'To confirm from WindowCAD')); ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="fg-price-guide__factors">
        <div class="container fg-price-guide__factors-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('What changes the price', 'fenster'); ?></p>
                <h2><?php esc_html_e('The honest bits customers normally only find out later.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Fenster can use the pricing tool to show how each choice affects the quote before the survey confirms the final details.', 'fenster'); ?></p>
            </div>
            <div class="fg-price-guide__factor-list">
                <?php foreach ($moves as $move) : ?>
                    <article>
                        <h3><?php echo esc_html((string) $move); ?></h3>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-price-guide__proof">
        <div class="container fg-price-guide__proof-grid">
            <div class="fg-price-guide__proof-copy">
                <p class="eyebrow"><?php esc_html_e('How we should show it', 'fenster'); ?></p>
                <h2><?php esc_html_e('WindowCAD screenshot, then the real fitted result.', 'fenster'); ?></h2>
                <p><?php esc_html_e('For each guide, the strongest page will show the configured product, the checked price, the choices that moved the number and a real installation photo where we have one.', 'fenster'); ?></p>
                <ol>
                    <li><?php esc_html_e('Build the standard product in WindowCAD.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Record the exact options: size, colour, glass, vents, cill, threshold and hardware.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Add the fitted guide price and checked date.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Pair it with a real Fenster installation photo where possible.', 'fenster'); ?></li>
                </ol>
            </div>
            <div class="fg-price-guide__image-stack">
                <?php if (is_array($hero_image) && ! empty($hero_image['src'])) : ?>
                    <figure>
                        <img <?php echo fenster_image_attr_string((string) $hero_image['src'], ['alt' => (string) ($hero_image['alt'] ?? $title), 'loading' => 'lazy']); ?>>
                    </figure>
                <?php endif; ?>
                <?php foreach ($detail_images as $image) : ?>
                    <?php if (is_array($image) && ! empty($image['src'])) : ?>
                        <figure>
                            <img <?php echo fenster_image_attr_string((string) $image['src'], ['alt' => (string) ($image['alt'] ?? $title), 'loading' => 'lazy']); ?>>
                        </figure>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-price-guide__faq">
        <div class="container fg-price-guide__faq-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Pricing questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Clear answers before anyone books a survey.', 'fenster'); ?></h2>
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

    <section id="fenster-enquiry" class="fg-price-guide__cta">
        <div class="container fg-price-guide__cta-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Check your own project', 'fenster'); ?></p>
                <h2><?php esc_html_e('Use the guide, then price the real thing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Tell Fenster what you want to replace and the team can help check the product choices, survey details and fitted quote.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a class="text-link" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open WindowCAD for this product', 'fenster'); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form fg-article-form',
                'source' => 'Price guide: ' . $title,
                'button_label' => 'Ask about pricing',
                'project_type' => $product,
                'compact' => true,
            ]);
            ?>
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
