<?php
/**
 * Product selector hub for /windows-milton-keynes/, /doors-milton-keynes/
 * and /other-services/.
 *
 * This is a routing page, not a product page. The customer's job is to work out
 * which of our products they need, so the whole range is on screen as real
 * photographs and the filter narrows it rather than hiding it. Card imagery
 * comes from the curated product_media entries, so a hub card and the page it
 * links to can never show different pictures of the same product.
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
 * Build one card from a hub item plus the curated data the product already owns.
 *
 * Imagery: product_media.card is a closer crop for this 4:3 cell, falling back
 * to the hero. Specs: the first two product_usps, so the card carries a real
 * number rather than another adjective. System: from the manufacturer data that
 * drives the product pages, so there is no second mapping to keep in step.
 */
$build_card = static function (array $item): ?array {
    $slug = (string) ($item['slug'] ?? '');
    if ($slug === '') {
        return null;
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
        return null;
    }

    $usps = fenster_data('product_usps.' . $slug, []);
    $specs = [];
    foreach (is_array($usps) ? array_slice($usps, 0, 2) : [] as $usp) {
        if (! is_array($usp) || trim((string) ($usp['value'] ?? '')) === '') {
            continue;
        }

        $specs[] = [
            'label' => (string) ($usp['label'] ?? ''),
            'value' => (string) $usp['value'],
        ];
    }

    $hub = function_exists('fenster_product_hub_data') ? fenster_product_hub_data($slug) : [];
    $system = is_array($hub['systems'][0] ?? null) ? $hub['systems'][0] : [];

    return [
        'slug' => $slug,
        'name' => (string) ($item['name'] ?? $slug),
        'fit' => (string) ($item['fit'] ?? ''),
        'copy' => (string) ($item['copy'] ?? ''),
        'url' => home_url('/' . $slug . '/'),
        'image' => $image,
        'alt' => $alt !== '' ? $alt : (string) ($item['name'] ?? ''),
        'specs' => $specs,
        'system_logo' => trim((string) ($system['logo'] ?? '')),
        'system_label' => (string) ($system['label'] ?? ''),
    ];
};

$cards = array_values(array_filter(array_map($build_card, $products)));
if ($cards === []) {
    return;
}

$configurations = array_values(array_filter(array_map($build_card, (array) ($group['configurations'] ?? []))));

/*
 * Filters are the same groupings the range already had, but as controls rather
 * than fixed headings, so the whole range stays on one grid. Any product no
 * filter claims still appears under "All", so it can never be lost.
 */
$filters = [];
foreach ((array) ($group['filters'] ?? []) as $filter) {
    $slugs = array_values(array_filter((array) ($filter['slugs'] ?? []), static function ($slug) use ($cards): bool {
        foreach ($cards as $card) {
            if ($card['slug'] === $slug) {
                return true;
            }
        }

        return false;
    }));

    if ($slugs !== []) {
        $filters[] = [
            'key' => sanitize_title((string) ($filter['label'] ?? '')),
            'label' => (string) ($filter['label'] ?? ''),
            'note' => (string) ($filter['note'] ?? ''),
            'slugs' => $slugs,
        ];
    }
}

$filter_of = [];
foreach ($filters as $filter) {
    foreach ($filter['slugs'] as $slug) {
        $filter_of[$slug] = $filter['key'];
    }
}

$case_studies = function_exists('fenster_case_studies_for_product_group')
    ? fenster_case_studies_for_product_group(array_merge(array_column($cards, 'slug'), array_column($configurations, 'slug')), 3)
    : [];

/** Card markup, shared by the range grid and the configurations row. */
$render_card = static function (array $card, string $filter_key, bool $eager = false): void {
    ?>
    <li class="fg-ph-card__wrap" data-fg-hub-item data-filter="<?php echo esc_attr($filter_key); ?>">
        <a class="fg-ph-card" href="<?php echo esc_url($card['url']); ?>">
            <span class="fg-ph-card__media">
                <img <?php echo fenster_image_attr_string($card['image'], [
                    'alt' => $card['alt'],
                    'loading' => $eager ? 'eager' : 'lazy',
                ]); ?>>
                <?php if ($card['specs'] !== []) : ?>
                    <span class="fg-ph-card__specs">
                        <?php foreach ($card['specs'] as $spec) : ?>
                            <span>
                                <b><?php echo esc_html($spec['value']); ?></b>
                                <i><?php echo esc_html($spec['label']); ?></i>
                            </span>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>
            </span>
            <span class="fg-ph-card__body">
                <span class="fg-ph-card__fit"><?php echo esc_html($card['fit']); ?></span>
                <strong><?php echo esc_html($card['name']); ?></strong>
                <span class="fg-ph-card__copy"><?php echo esc_html($card['copy']); ?></span>
                <span class="fg-ph-card__foot">
                    <?php if ($card['system_logo'] !== '') : ?>
                        <span class="fg-ph-card__system">
                            <img src="<?php echo esc_url(fenster_generated_url($card['system_logo'])); ?>" alt="<?php echo esc_attr(sprintf(__('%s system', 'fenster'), $card['system_label'])); ?>" loading="lazy">
                        </span>
                    <?php else : ?>
                        <span class="fg-ph-card__system" aria-hidden="true"></span>
                    <?php endif; ?>
                    <span class="fg-ph-card__more"><?php esc_html_e('View', 'fenster'); ?></span>
                </span>
            </span>
        </a>
    </li>
    <?php
};
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
                    <?php if (! empty($group['suppliers_note'])) : ?>
                        <p class="fg-product-hub__systems-note"><?php echo esc_html((string) $group['suppliers_note']); ?></p>
                    <?php endif; ?>
                </aside>
            <?php endif; ?>
        </div>
    </section>

    <section class="fg-product-hub__range" data-fg-product-hub>
        <div class="container">
            <?php if ($filters !== []) : ?>
                <div class="fg-ph-filters">
                    <div class="fg-ph-filters__row" role="group" aria-label="<?php esc_attr_e('Narrow the range', 'fenster'); ?>">
                        <button type="button" class="is-active" data-fg-hub-filter="all" aria-pressed="true">
                            <?php esc_html_e('All', 'fenster'); ?>
                            <span><?php echo esc_html((string) count($cards)); ?></span>
                        </button>
                        <?php foreach ($filters as $filter) : ?>
                            <button type="button" data-fg-hub-filter="<?php echo esc_attr($filter['key']); ?>" aria-pressed="false">
                                <?php echo esc_html($filter['label']); ?>
                                <span><?php echo esc_html((string) count($filter['slugs'])); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="fg-ph-filters__note" data-fg-hub-note aria-live="polite"><?php esc_html_e('The whole range. Narrow it if you already know roughly what you want.', 'fenster'); ?></p>
                </div>
                <?php foreach ($filters as $filter) : ?>
                    <template data-fg-hub-note-for="<?php echo esc_attr($filter['key']); ?>"><?php echo esc_html($filter['note']); ?></template>
                <?php endforeach; ?>
            <?php endif; ?>

            <ul class="fg-ph-grid" data-fg-hub-grid>
                <?php foreach ($cards as $index => $card) : ?>
                    <?php $render_card($card, (string) ($filter_of[$card['slug']] ?? ''), $index < 3); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php if ($configurations !== []) : ?>
        <section class="fg-product-hub__configs">
            <div class="container">
                <header class="fg-product-hub__configs-head">
                    <p class="eyebrow"><?php esc_html_e('Configurations', 'fenster'); ?></p>
                    <h2><?php echo esc_html((string) ($group['configurations_heading'] ?? '')); ?></h2>
                    <p><?php echo esc_html((string) ($group['configurations_intro'] ?? '')); ?></p>
                </header>
                <ul class="fg-ph-grid fg-ph-grid--configs">
                    <?php foreach ($configurations as $card) : ?>
                        <?php $render_card($card, ''); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

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
