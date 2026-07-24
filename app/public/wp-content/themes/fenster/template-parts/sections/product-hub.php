<?php
/**
 * Product selector hub for /windows-milton-keynes/, /doors-milton-keynes/
 * and /other-services/.
 *
 * This is a routing page, not a product page. The customer's job is to work out
 * which of our products they need, so the whole range is on screen as real
 * photographs rather than hidden behind a tab control. Card imagery comes from
 * the curated product_media heroes, so a hub card and the page it links to can
 * never show different pictures of the same product.
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

/*
 * Resolve each card's picture from the product's own curated hero. An explicit
 * 'image' is only for routes with no product_media entry, currently just
 * /flat-rooflights/, which has its own template.
 */
$cards = [];
foreach ($products as $product) {
    $slug = (string) ($product['slug'] ?? '');
    if ($slug === '') {
        continue;
    }

    $media = fenster_data('product_media.' . $slug, []);
    $image = (string) ($product['image'] ?? '');
    if ($image === '' && is_array($media)) {
        $image = (string) ($media['hero']['src'] ?? '');
    }

    if ($image === '') {
        continue;
    }

    $cards[] = [
        'slug' => $slug,
        'name' => (string) ($product['name'] ?? $slug),
        'fit' => (string) ($product['fit'] ?? ''),
        'copy' => (string) ($product['copy'] ?? ''),
        'url' => home_url('/' . $slug . '/'),
        'image' => $image,
        'alt' => (string) ($media['hero']['alt'] ?? ($product['name'] ?? '')),
    ];
}

if ($cards === []) {
    return;
}

/*
 * Group the cards into the bands declared for this hub. Anything a band does
 * not claim still renders, in one unlabelled band at the end, so a product
 * added to 'products' can never silently vanish from the page.
 */
$cards_by_slug = [];
foreach ($cards as $card) {
    $cards_by_slug[$card['slug']] = $card;
}

$bands = [];
$claimed = [];
foreach ((array) ($group['bands'] ?? []) as $band) {
    $band_cards = [];
    foreach ((array) ($band['slugs'] ?? []) as $slug) {
        if (isset($cards_by_slug[$slug])) {
            $band_cards[] = $cards_by_slug[$slug];
            $claimed[$slug] = true;
        }
    }

    if ($band_cards !== []) {
        $bands[] = [
            'label' => (string) ($band['label'] ?? ''),
            'note' => (string) ($band['note'] ?? ''),
            'cards' => $band_cards,
        ];
    }
}

$unclaimed = array_values(array_filter($cards, static function (array $card) use ($claimed): bool {
    return ! isset($claimed[$card['slug']]);
}));

if ($unclaimed !== []) {
    $bands[] = ['label' => '', 'note' => '', 'cards' => $unclaimed];
}

$suppliers = array_values(array_filter((array) ($group['suppliers'] ?? []), 'is_array'));

$case_studies = function_exists('fenster_case_studies_for_product_group')
    ? fenster_case_studies_for_product_group(array_column($cards, 'slug'), 3)
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

    <section class="fg-product-hub__range">
        <div class="container">
            <?php foreach ($bands as $band_index => $band) : ?>
                <?php $band_id = 'fg-hub-band-' . $band_index; ?>
                <div class="fg-product-hub__band"<?php echo $band['label'] !== '' ? ' role="group" aria-labelledby="' . esc_attr($band_id) . '"' : ''; ?>>
                    <?php if ($band['label'] !== '') : ?>
                        <header class="fg-product-hub__band-head">
                            <h2 id="<?php echo esc_attr($band_id); ?>"><?php echo esc_html($band['label']); ?></h2>
                            <?php if ($band['note'] !== '') : ?>
                                <p><?php echo esc_html($band['note']); ?></p>
                            <?php endif; ?>
                        </header>
                    <?php endif; ?>
                    <ul class="fg-product-hub__grid">
                        <?php foreach ($band['cards'] as $card) : ?>
                            <li>
                                <a class="fg-product-hub__card" href="<?php echo esc_url($card['url']); ?>">
                                    <span class="fg-product-hub__media">
                                        <img <?php echo fenster_image_attr_string($card['image'], [
                                            'alt' => $card['alt'],
                                            'loading' => 'lazy',
                                        ]); ?>>
                                    </span>
                                    <span class="fg-product-hub__body">
                                        <span class="fg-product-hub__fit"><?php echo esc_html($card['fit']); ?></span>
                                        <strong><?php echo esc_html($card['name']); ?></strong>
                                        <span class="fg-product-hub__copy"><?php echo esc_html($card['copy']); ?></span>
                                        <span class="fg-product-hub__more"><?php echo esc_html(sprintf(__('View %s', 'fenster'), $card['name'])); ?></span>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
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
