<?php
/**
 * Product selector hub for /windows-milton-keynes/, /doors-milton-keynes/
 * and /other-services/.
 *
 * A routing page. The whole range is one grid of photographs sized to sit in a
 * single desktop viewport, so a customer can see every option at once and click
 * the one they want without scrolling or filtering. Card imagery comes from the
 * curated product_media entries, so a tile and the page it links to can never
 * show different pictures of the same product.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'brand' => [],
    'group' => 'windows',
    'instant_quote_preview' => '',
    'title' => '',
    'trust_items' => [],
]);

$group_key = (string) $args['group'];
$group = fenster_data('product_hub_groups.' . $group_key, []);
$group = is_array($group) ? $group : [];

$products = is_array($group['products'] ?? null) ? $group['products'] : [];
if ($products === []) {
    return;
}

$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$instant_quote_preview = (string) $args['instant_quote_preview'];
$trust_items = is_array($args['trust_items']) ? $args['trust_items'] : [];
$guide = is_array($group['guide'] ?? null) ? $group['guide'] : [];

/**
 * One tile: the product's own curated card image, its name, and the system it
 * is built on. product_media.card is a closer crop for this cell, falling back
 * to the hero. The system comes from the manufacturer data that already drives
 * the product pages, so there is no second mapping to keep in step.
 */
$tiles = [];
foreach ($products as $item) {
    $slug = (string) ($item['slug'] ?? '');
    if ($slug === '') {
        continue;
    }

    $media = fenster_data('product_media.' . $slug, []);
    $media = is_array($media) ? $media : [];

    $image = (string) ($item['image'] ?? '');
    $alt = '';
    if ($image === '') {
        $image = (string) ($media['card']['src'] ?? $media['hero']['src'] ?? '');
        $alt = (string) ($media['card']['alt'] ?? $media['hero']['alt'] ?? '');
    }

    if ($image === '') {
        continue;
    }

    $hub = function_exists('fenster_product_hub_data') ? fenster_product_hub_data($slug) : [];
    $system = is_array($hub['systems'][0] ?? null) ? $hub['systems'][0] : [];

    $tiles[] = [
        'slug' => $slug,
        'name' => (string) ($item['name'] ?? $slug),
        'fit' => (string) ($item['fit'] ?? ''),
        'url' => home_url('/' . $slug . '/'),
        'image' => $image,
        'alt' => $alt !== '' ? $alt : (string) ($item['name'] ?? ''),
        'system_logo' => trim((string) ($system['logo'] ?? '')),
        'system_label' => (string) ($system['label'] ?? ''),
    ];
}

if ($tiles === []) {
    return;
}

$case_studies = function_exists('fenster_case_studies_for_product_group')
    ? fenster_case_studies_for_product_group(array_column($tiles, 'slug'), 3)
    : [];
?>

<article class="fg-product-hub fg-product-hub--<?php echo esc_attr($group_key); ?>">
    <section class="fg-product-hub__intro">
        <div class="container fg-product-hub__intro-grid">
            <div class="fg-product-hub__lead">
                <p class="eyebrow"><?php echo esc_html((string) ($group['eyebrow'] ?? '')); ?></p>
                <?php /* Theme-owned, so the H1 no longer depends on the scraped page record. */ ?>
                <h1><?php echo esc_html((string) ($group['h1'] ?? $args['title'])); ?></h1>
                <p class="fg-product-hub__lead-copy"><?php echo esc_html((string) ($group['intro'] ?? '')); ?></p>
                <p class="fg-product-hub__actions">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                </p>
            </div>

            <?php $suppliers = array_values(array_filter((array) ($group['suppliers'] ?? []), 'is_array')); ?>
            <?php if ($suppliers !== []) : ?>
                <aside class="fg-product-hub__systems">
                    <p class="fg-product-hub__systems-title"><?php esc_html_e('The systems we fit', 'fenster'); ?></p>
                    <ul>
                        <?php foreach ($suppliers as $supplier) : ?>
                            <?php $logo = '/wp-content/themes/fenster/assets/partners/' . (string) ($supplier['logo'] ?? ''); ?>
                            <li>
                                <span class="fg-product-hub__systems-logo">
                                    <img <?php echo fenster_image_attr_string($logo, [
                                        'alt' => (string) ($supplier['name'] ?? ''),
                                        'loading' => 'lazy',
                                    ]); ?>>
                                </span>
                                <span class="fg-product-hub__systems-role"><?php echo esc_html((string) ($supplier['role'] ?? '')); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            <?php endif; ?>
        </div>
    </section>

    <section class="fg-product-hub__range">
        <div class="container">
            <ul class="fg-ph-tiles" data-count="<?php echo esc_attr((string) count($tiles)); ?>">
                <?php foreach ($tiles as $index => $tile) : ?>
                    <li>
                        <a class="fg-ph-tile" href="<?php echo esc_url($tile['url']); ?>">
                            <img <?php echo fenster_image_attr_string($tile['image'], [
                                'alt' => $tile['alt'],
                                'loading' => $index < 6 ? 'eager' : 'lazy',
                            ]); ?>>
                            <span class="fg-ph-tile__label">
                                <strong><?php echo esc_html($tile['name']); ?></strong>
                                <small><?php echo esc_html($tile['fit']); ?></small>
                            </span>
                            <?php if ($tile['system_logo'] !== '') : ?>
                                <span class="fg-ph-tile__system">
                                    <img src="<?php echo esc_url(fenster_generated_url($tile['system_logo'])); ?>" alt="<?php echo esc_attr(sprintf(__('%s system', 'fenster'), $tile['system_label'])); ?>" loading="lazy">
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php if ($guide !== []) : ?>
        <section class="fg-product-hub__guide">
            <div class="container fg-product-hub__guide-grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Narrowing it down', 'fenster'); ?></p>
                    <h2><?php echo esc_html((string) ($group['guide_heading'] ?? '')); ?></h2>
                    <p><?php echo esc_html((string) ($group['guide_intro'] ?? '')); ?></p>
                </div>
                <ol>
                    <?php foreach ($guide as $index => $step) : ?>
                        <li>
                            <span aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <div>
                                <strong><?php echo esc_html((string) ($step['title'] ?? '')); ?></strong>
                                <p><?php echo esc_html((string) ($step['copy'] ?? '')); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($case_studies !== []) : ?>
        <section class="fg-product-hub__proof">
            <div class="container">
                <header class="fg-product-hub__proof-head">
                    <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Recent jobs, photographed the day we finished.', 'fenster'); ?></h2>
                </header>
                <ul class="fg-product-hub__studies">
                    <?php foreach ($case_studies as $study) : ?>
                        <li>
                            <a href="<?php echo esc_url((string) ($study['url'] ?? '')); ?>">
                                <?php if (is_array($study['image'] ?? null)) : ?>
                                    <img src="<?php echo esc_url(fenster_generated_url((string) ($study['image']['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($study['image']['alt'] ?? $study['title'] ?? '')); ?>" loading="lazy">
                                <?php endif; ?>
                                <div>
                                    <span><?php echo esc_html((string) ($study['location'] ?? '')); ?></span>
                                    <strong><?php echo esc_html((string) ($study['title'] ?? '')); ?></strong>
                                    <small><?php esc_html_e('See the project', 'fenster'); ?></small>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-product-hub__proof-more">
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                </p>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-product-hub__quote">
        <div class="container fg-product-hub__quote-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('How pricing works', 'fenster'); ?></p>
                <h2><?php echo esc_html((string) ($group['quote_heading'] ?? '')); ?></h2>
                <p><?php esc_html_e('If you like doing things yourself, build the job on the quote tool and see the number on the spot. If you would rather talk it through, book a consultation and we will come to you.', 'fenster'); ?></p>
                <p class="fg-product-hub__actions">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                </p>
            </div>
            <?php if ($instant_quote_preview !== '') : ?>
                <a class="fg-product-hub__quote-shot" href="<?php echo esc_url(home_url('/online-quote/')); ?>">
                    <img src="<?php echo esc_url($instant_quote_preview); ?>" alt="<?php esc_attr_e('The Fenster instant quote tool', 'fenster'); ?>" loading="lazy">
                </a>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--product-hub',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>
</article>
