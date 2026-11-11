<?php
/**
 * The price-first homepage, "The Showroom" (design competition, 10/11/2026).
 *
 * Served only at /?home=next until it is switched on (noindex, canonical /),
 * see fenster_home_next_requested() in inc/generated-pages.php. Switching it
 * on for everyone is one edit there.
 *
 * One job: start a price. The hero is a working model of the quote journey.
 * - Four categories stand on the stage, each with its real "from" price.
 *   Every tile is a plain link to that product's WindowCAD designer, so the page
 *   works with JavaScript off. With it on (initHomeNext in src/js/main.js)
 *   picking one turns the same container into the kinds the quote tool
 *   prices, each with its own "Get my price" straight into the tool
 *   (conversion first, owner 10/11/2026). Bifolds have one kind, so that
 *   tile goes straight to the tool. "All products" goes back to the four.
 * - The product chosen there is carried into every price button on the page,
 *   and into the footer's phone price bar.
 * - Repairs and commercial get quiet exits: neither can be instant-priced
 *   (owner rule 16/09/2026).
 * - Nothing dark bigger than half a viewport (owner rule 02/09/2026).
 *
 * Every link carries data-fg-cta so its clicks are counted.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/* The real "from" prices, inc VAT: the cheapest real price for each product
   (owner, 10/11/2026: "make them the absolute cheapest"). Searched across
   the Glasshouse CRM (fenster-fieldos: WindowCAD projects, parsed sales
   quotes and contract quotes, 767 unique lines, 14 Oct 2024 to 10 Nov 2026).
   uPVC windows £506 (a sold 508x737 casement) and heritage French £2,766
   are the owner's figures. Bifolds £2,324: contract 1609, a 2-pane aluminium
   bifold sold May 2023 and paid in full (lead 2333). Skipped as website-tool pricing
   faults: a 1200 French pair at £438, a 2420 slider at £1,118, an 1800
   French pair at £1,191 and a 2043 heritage pair at £1,597. Use no figure that is not in this list.
   `bar` is the phone price bar's label once that category is chosen. */
$hn_products = [
    'windows' => ['name' => 'Windows', 'seg' => 'Windows', 'short' => 'Windows', 'from' => '£506', 'slug' => 'casement-windows', 'bar' => 'Price my windows', 'kind' => 'window', 'h' => 0.72, 'render' => 732],
    'door' => ['name' => 'Front doors', 'seg' => 'Front doors', 'short' => 'Doors', 'from' => '£1,480', 'slug' => 'composite-doors', 'bar' => 'Price my front door', 'kind' => 'door', 'h' => 1, 'render' => 418],
    'french' => ['name' => 'French & patio doors', 'seg' => 'French & patio', 'short' => 'Patio', 'from' => '£1,726', 'slug' => 'patio-doors', 'bar' => 'Price my patio doors', 'kind' => 'door', 'h' => 0.94, 'render' => 551],
    'bifold' => ['name' => 'Bifold doors', 'seg' => 'Bifold doors', 'short' => 'Bifold', 'from' => '£2,324', 'slug' => 'aluminium-bifold-doors', 'bar' => 'Price my bifolds', 'kind' => 'door', 'h' => 0.9, 'render' => 644],
];

/* What each category opens into: the kinds the quote tool prices, each its
   own collection there. "from" is the same cheapest real price, per
   product. */
$hn_types = [
    'windows' => ['ask' => 'Which windows?', 'types' => [
        ['name' => 'uPVC windows', 'slug' => 'casement-windows', 'from' => '£506', 'img' => 'thumb-windows'],
        ['name' => 'Sash windows', 'slug' => 'sliding-sash-windows', 'from' => '£794', 'img' => 'sub-sash'],
        ['name' => 'Aluminium windows', 'slug' => 'aluminium-windows', 'from' => '£450', 'img' => 'sub-alu-windows'],
    ]],
    'door' => ['ask' => 'Which front door?', 'types' => [
        ['name' => 'Composite doors', 'slug' => 'composite-doors', 'from' => '£1,480', 'img' => 'kind-composite'],
        ['name' => 'uPVC doors', 'slug' => 'upvc-doors', 'from' => '£1,166', 'img' => 'kind-upvc-door'],
        ['name' => 'Aluminium doors', 'slug' => 'aluminium-doors', 'from' => '£2,299', 'img' => 'kind-alu-door'],
    ]],
    'french' => ['ask' => 'Which garden doors?', 'types' => [
        ['name' => 'uPVC French doors', 'slug' => 'french-doors', 'from' => '£1,726', 'img' => 'kind-french'],
        ['name' => 'Aluminium sliding', 'slug' => 'aluminium-sliding-doors', 'from' => '£2,793', 'img' => 'kind-sliding'],
        ['name' => 'Heritage French doors', 'slug' => 'heritage-aluminium-doors', 'from' => '£2,766', 'img' => 'kind-heritage'],
    ]],
];

/* A category's "from" is the cheapest of the kinds inside it, worked out here
   so it can never promise less, or more, than the list it opens (owner,
   11/11/2026: "Front doors from £1,480 ... you click on it and it says uPVC
   doors £1,166"). */
$__from_value = static fn (string $price): int => (int) preg_replace('/[^0-9]/', '', $price);
foreach ($hn_types as $__key => $__group) {
    if (! isset($hn_products[$__key]) || empty($__group['types'])) {
        continue;
    }
    $__cheapest = array_reduce($__group['types'], static fn (?array $low, array $type): array => $low === null || $__from_value($type['from']) < $__from_value($low['from']) ? $type : $low);
    $hn_products[$__key]['from'] = $__cheapest['from'];
}
unset($__from_value, $__key, $__group, $__cheapest);
$hn_price_note = 'Lowest prices from real Fenster quotes, Oct 2024–Nov 2026, inc VAT. Your price depends on size and spec.';

$args = wp_parse_args($args ?? [], [
    'brand' => [],
]);
$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? fenster_data('brand.phone', '01908 429200'));
$phone_href = preg_replace('/\s+/', '', $phone);
$address = (array) fenster_data('brand.address', []);
$showroom_hours = (string) fenster_data('brand.showroom_hours', '');
$google_reviews_url = (string) fenster_data('brand.google_reviews_url', '');
$trustpilot_url = (string) fenster_data('brand.trustpilot_url', '');
$hn_reviews = function_exists('fenster_review_summary') ? (array) fenster_review_summary() : [];
$hn_rating = number_format((float) ($hn_reviews['rating'] ?? fenster_data('brand.google_rating', 4.9)), 1);
$hn_review_count = (int) ($hn_reviews['count'] ?? 0);

$img = FENSTER_THEME_URI . '/assets/images/home-next/';
$img_a = FENSTER_THEME_URI . '/assets/images/home-a/';
$hn_arrow = '<svg class="fg-hn-ic" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3.5 10.5 8 6 12.5"/></svg>';
$trust = FENSTER_THEME_URI . '/assets/trust/';
$doors_dir = FENSTER_THEME_URI . '/assets/images/products/composite-distinction/colours/';
/* A product goes straight into its own WindowCAD designer (owner, 10/11/2026:
   "link to the windowcad product ... that is product specific"), from the one
   map in inc/quote-collections.php. main.js stamps the visitor's tracking
   reference onto every WindowCAD link as it is clicked, so the quote still
   reaches the office with its journey. No product, or one the map does not
   know: /online-quote/, the all-products designer. */
$quote = static function (string $slug = ''): string {
    $designer = $slug !== '' && function_exists('fenster_quote_collection_url') ? fenster_quote_collection_url($slug) : '';

    return $designer !== '' ? $designer : ($slug === '' ? home_url('/online-quote/') : add_query_arg('product', $slug, home_url('/online-quote/')));
};
/* A category tile that opens its list of kinds is a chooser, not a quote: with
   JavaScript on it never navigates. Its fallback stays on our own quote page so
   a click on it is never counted as a WindowCAD quote opened. */
$chooser = static fn (string $slug): string => add_query_arg('product', $slug, home_url('/online-quote/'));

/* Distinction composite door colours: the products' own photographs. */
$hn_doors = [
    ['slug' => 'anthracite-grey', 'name' => 'Anthracite grey', 'hex' => '#3e4246'],
    ['slug' => 'black', 'name' => 'Black', 'hex' => '#2c2d2f'],
    ['slug' => 'chartwell-green', 'name' => 'Chartwell green', 'hex' => '#99a884'],
    ['slug' => 'distant-blue', 'name' => 'Distant blue', 'hex' => '#444d6a'],
    ['slug' => 'ruby-red', 'name' => 'Ruby red', 'hex' => '#641921'],
];

$guides = [
    ['label' => 'Guides and advice', 'url' => home_url('/blog/')],
    ['label' => 'Window and door prices in Milton Keynes', 'url' => home_url('/window-door-prices-milton-keynes/')],
    ['label' => 'What is double glazing and how does it work?', 'url' => home_url('/what-are-double-glazed-glass-windows/')],
    ['label' => 'Try the 3D visualiser', 'url' => home_url('/3d-visualiser/')],
];

/* What the script needs: each category's slug, bar label and question. */
$hn_config = [
    'quote' => home_url('/online-quote/'),
    'products' => array_map(static fn (array $p): array => [
        'slug' => $p['slug'],
        'url' => $quote($p['slug']),
        'bar' => $p['bar'],
    ], $hn_products),
    'asks' => array_map(static fn (array $g): string => $g['ask'], $hn_types),
    'doors' => array_map(static fn (array $d): array => [
        'name' => $d['name'],
        'src' => $doors_dir . $d['slug'] . '-800w.webp',
        'srcset' => $doors_dir . $d['slug'] . '-480w.webp 480w, ' . $doors_dir . $d['slug'] . '-800w.webp 800w',
    ], $hn_doors),
];

/* A price button: label, then a spinner and a tick that take its place. */
$button = static function (string $label, string $href, string $class = '', bool $carries = true): string {
    return sprintf(
        '<a class="fg-hn-btn%1$s" href="%2$s" data-fg-cta data-fg-hn-go%3$s><span class="fg-hn-btn__label">%4$s</span><span class="fg-hn-btn__busy" aria-hidden="true"><span class="fg-hn-btn__spin"></span><svg class="fg-hn-btn__tick" viewBox="0 0 16 16" focusable="false"><path d="M3 8.5 6.5 12 13 4.5"/></svg></span></a>',
        $class !== '' ? ' ' . esc_attr($class) : '',
        esc_url($href),
        $carries ? ' data-fg-hn-price' : '',
        esc_html($label)
    );
};
?>

<article class="generated-page generated-page--home-lab generated-page--home-next fg-hn" data-fg-hn="<?php echo esc_attr((string) wp_json_encode($hn_config)); ?>">

    <section class="fg-hn-hero" aria-labelledby="fg-hn-title">
        <div class="fg-hn-wrap fg-hn-hero__grid">
            <div class="fg-hn-hero__copy">
                <h1 id="fg-hn-title" class="fg-hn-hero__title"><?php esc_html_e('Instant prices in Milton Keynes', 'fenster'); ?></h1>
                <p class="fg-hn-hero__line"><?php esc_html_e('Pick a product to see how it’s priced', 'fenster'); ?></p>
                <ul class="fg-hn-proof" aria-label="<?php esc_attr_e('Reviews and accreditations', 'fenster'); ?>">
                    <li class="fg-hn-proof__google">
                        <?php if ($google_reviews_url !== '') : ?><a href="<?php echo esc_url($google_reviews_url); ?>" target="_blank" rel="noopener" data-fg-cta><?php endif; ?>
                            <img <?php echo fenster_image_attr_string($trust . 'google-5-stars.png', ['alt' => __('Google reviews', 'fenster'), 'loading' => 'eager']); ?>>
                            <span class="fg-hn-proof__score"><b class="fg-hn-num"><?php echo esc_html($hn_rating); ?></b><?php if ($hn_review_count > 0) : ?> <small class="fg-hn-num"><?php echo esc_html(sprintf(_n('%s review', '%s reviews', $hn_review_count, 'fenster'), number_format_i18n($hn_review_count))); ?></small><?php endif; ?></span>
                        <?php if ($google_reviews_url !== '') : ?></a><?php endif; ?>
                    </li>
                    <li>
                        <?php if ($trustpilot_url !== '') : ?><a href="<?php echo esc_url($trustpilot_url); ?>" target="_blank" rel="noopener" data-fg-cta><?php endif; ?>
                        <img <?php echo fenster_image_attr_string($trust . 'trustpilot-excellent.png', ['alt' => __('Rated Excellent on Trustpilot', 'fenster'), 'loading' => 'eager']); ?>>
                        <?php if ($trustpilot_url !== '') : ?></a><?php endif; ?>
                    </li>
                    <li><img <?php echo fenster_image_attr_string($trust . 'fensa.png', ['alt' => __('FENSA approved installer', 'fenster'), 'loading' => 'eager']); ?>></li>
                    <li><img <?php echo fenster_image_attr_string($trust . 'cpa.png', ['alt' => __('Consumer Protection Association insurance-backed guarantee', 'fenster'), 'loading' => 'eager']); ?>></li>
                </ul>
            </div>

            <div class="fg-hn-hero__stagecol">
            <div class="fg-hn-stage" data-fg-hn-stage data-kind="window">
                <ul class="fg-hn-lineup" data-fg-hn-lineup aria-label="<?php esc_attr_e('Products', 'fenster'); ?>">
                    <?php foreach ($hn_products as $key => $product) : ?>
                        <li>
                            <a class="fg-hn-tile" href="<?php echo esc_url(isset($hn_types[$key]) ? $chooser($product['slug']) : $quote($product['slug'])); ?>" data-fg-cta<?php if (isset($hn_types[$key])) : ?> data-fg-hn-pick="<?php echo esc_attr($key); ?>"<?php endif; ?>>
                                <span class="fg-hn-tile__img">
                                    <img <?php echo fenster_image_attr_string($img . 'render-' . $key . '-' . $product['render'] . 'w.webp', ['alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 760px) 45vw, 26vw']); ?>>
                                </span>
                                <span class="fg-hn-tile__row">
                                    <span class="fg-hn-tile__name"><?php echo esc_html($product['name']); ?></span>
                                    <span class="fg-hn-tile__from"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-hn-num"><?php echo esc_html($product['from']); ?></b></span>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="fg-hn-types" data-fg-hn-detail hidden>
                    <div class="fg-hn-types__bar">
                        <button class="fg-hn-back" type="button" data-fg-hn-back>
                            <svg class="fg-hn-ic" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M10 3.5 5.5 8l4.5 4.5"/></svg><?php esc_html_e('All products', 'fenster'); ?>
                        </button>
                        <h2 class="fg-hn-types__ask" tabindex="-1" data-fg-hn-ask></h2>
                    </div>
                    <?php foreach ($hn_types as $key => $group) : ?>
                        <ul class="fg-hn-types__list" data-fg-hn-types="<?php echo esc_attr($key); ?>" hidden>
                            <?php foreach ($group['types'] as $type) : ?>
                                <li>
                                    <a class="fg-hn-type" href="<?php echo esc_url($quote($type['slug'])); ?>" data-fg-cta>
                                        <span class="fg-hn-type__img">
                                            <img <?php echo fenster_image_attr_string($img_a . $type['img'] . '-400w.webp', ['alt' => '', 'loading' => 'lazy', 'srcset' => $img_a . $type['img'] . '-200w.webp 200w, ' . $img_a . $type['img'] . '-400w.webp 400w', 'sizes' => '(max-width: 760px) 120px, 22vw']); ?>>
                                        </span>
                                        <span class="fg-hn-type__text">
                                            <span class="fg-hn-type__name"><?php echo esc_html($type['name']); ?></span>
                                            <span class="fg-hn-type__from"><?php if ($type['from'] !== '') : ?><?php esc_html_e('From', 'fenster'); ?> <b class="fg-hn-num"><?php echo esc_html($type['from']); ?></b><?php else : ?><?php esc_html_e('Instant price', 'fenster'); ?><?php endif; ?></span>
                                            <span class="fg-hn-type__cta"><?php esc_html_e('Get my price', 'fenster'); ?><?php echo $hn_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>
            <p class="fg-hn-note"><?php echo esc_html($hn_price_note); ?></p>
            </div>
        </div>
    </section>

    <section class="fg-hn-after" aria-labelledby="fg-hn-after-title">
        <div class="fg-hn-wrap fg-hn-after__grid">
            <figure class="fg-hn-after__photo">
                <img <?php echo fenster_image_attr_string($img . 'installer-1000w.webp', ['alt' => __('A Fenster installer fitting a new composite front door in a Milton Keynes home', 'fenster'), 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 92vw, 34vw']); ?>>
            </figure>
            <div class="fg-hn-after__copy">
                <h2 id="fg-hn-after-title" class="fg-hn-h2"><?php esc_html_e('After your instant price', 'fenster'); ?></h2>
                <ul class="fg-hn-after__steps">
                    <li><h3><?php esc_html_e('See it on screen', 'fenster'); ?></h3><p><?php esc_html_e('Add your details and the price appears', 'fenster'); ?></p></li>
                    <li><h3><?php esc_html_e('We survey', 'fenster'); ?></h3><p><?php esc_html_e('We check the specification at your home', 'fenster'); ?></p></li>
                    <li><h3><?php esc_html_e('Our own installers fit it', 'fenster'); ?></h3><p><?php esc_html_e('FENSA approved, with an insurance-backed guarantee', 'fenster'); ?></p></li>
                </ul>
                <div class="fg-hn-act">
                    <?php echo $button(__('Get my instant price', 'fenster'), $quote()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-hn-ba" aria-labelledby="fg-hn-ba-title" data-fg-hn-ba>
        <div class="fg-hn-wrap fg-hn-ba__grid">
            <figure class="fg-hn-ba__frame">
                <img <?php echo fenster_image_attr_string($img . 'wolverton-before-1520w.webp', ['alt' => __('The Wolverton semi before: white uPVC windows and a cream render', 'fenster'), 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 58vw']); ?>>
                <img class="fg-hn-ba__after" <?php echo fenster_image_attr_string($img . 'wolverton-after-1520w.webp', ['alt' => __('The same Wolverton semi after: black brown flush casements and a white render', 'fenster'), 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 58vw']); ?>>
            </figure>
            <div class="fg-hn-ba__copy">
                <h2 id="fg-hn-ba-title" class="fg-hn-h2"><?php esc_html_e('Wolverton, before and after', 'fenster'); ?></h2>
                <p class="fg-hn-sub"><?php esc_html_e('Every window and both doors, in black brown', 'fenster'); ?></p>
                <div class="fg-hn-switch" role="group" aria-label="<?php esc_attr_e('Show the house', 'fenster'); ?>">
                    <span class="fg-hn-switch__knob" data-fg-hn-ba-knob aria-hidden="true"></span>
                    <button type="button" aria-pressed="true" data-fg-hn-ba-v="before"><?php esc_html_e('Before', 'fenster'); ?></button>
                    <button type="button" aria-pressed="false" data-fg-hn-ba-v="after"><?php esc_html_e('After', 'fenster'); ?></button>
                </div>
                <div class="fg-hn-act fg-hn-act--row">
                    <?php echo $button(__('Price my windows', 'fenster'), $quote($hn_products['windows']['slug']), '', false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <a class="fg-hn-link" href="<?php echo esc_url(home_url('/case-studies/flush-casement-windows-and-composite-door-wolverton/')); ?>" data-fg-cta><?php esc_html_e('See the job', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-hn-colour" aria-labelledby="fg-hn-colour-title">
        <div class="fg-hn-wrap fg-hn-colour__grid">
            <div class="fg-hn-door" data-fg-hn-door>
                <img <?php echo fenster_image_attr_string($doors_dir . $hn_doors[0]['slug'] . '-800w.webp', ['alt' => __('An anthracite grey Distinction composite front door in a brick entrance', 'fenster'), 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 92vw, 440px']); ?>>
            </div>
            <div class="fg-hn-colour__copy">
                <h2 id="fg-hn-colour-title" class="fg-hn-h2"><?php esc_html_e('Pick your front door colour', 'fenster'); ?></h2>
                <p class="fg-hn-sub"><?php esc_html_e('Distinction composite doors, shown in each colour', 'fenster'); ?></p>
                <ul class="fg-hn-swatches" role="radiogroup" aria-label="<?php esc_attr_e('Door colour', 'fenster'); ?>">
                    <?php foreach ($hn_doors as $index => $door) : ?>
                        <li><button class="fg-hn-sw" type="button" role="radio" aria-checked="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-fg-hn-sw="<?php echo esc_attr((string) $index); ?>" style="--fg-hn-c:<?php echo esc_attr($door['hex']); ?>" aria-label="<?php echo esc_attr($door['name']); ?>"></button></li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-hn-sw-name" aria-live="polite" data-fg-hn-sw-name><?php echo esc_html($hn_doors[0]['name']); ?></p>
                <div class="fg-hn-act fg-hn-act--row">
                    <?php echo $button(__('Price my front door', 'fenster'), $quote($hn_products['door']['slug']), '', false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <span class="fg-hn-colour__from"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-hn-num"><?php echo esc_html($hn_products['door']['from']); ?></b> <?php esc_html_e('inc VAT', 'fenster'); ?></span>
                </div>
            </div>
        </div>
    </section>

    <?php /* Homepage 3.0's project rail, the part of it the owner loved (10/11/2026). */ ?>
    <div class="fg-h30 fg-hn-h30">
        <?php get_template_part('template-parts/components/h30-projects', null, [
            'title' => __('Real homes near you', 'fenster'),
            'lede' => '',
            'kicker' => '',
        ]); ?>
    </div>

    <section class="fg-hn-room" id="fg-hn-showroom" aria-labelledby="fg-hn-room-title">
        <div class="fg-hn-wrap fg-hn-room__grid">
            <div class="fg-hn-room__copy">
                <h2 id="fg-hn-room-title" class="fg-hn-h2"><?php esc_html_e('Visit our Milton Keynes showroom', 'fenster'); ?></h2>
                <?php if ($address !== []) : ?>
                    <p class="fg-hn-room__addr"><?php echo esc_html(implode(', ', array_map('strval', $address))); ?></p>
                <?php endif; ?>
                <?php if ($showroom_hours !== '') : ?>
                    <p class="fg-hn-room__hours"><?php echo esc_html($showroom_hours); ?></p>
                <?php endif; ?>
                <div class="fg-hn-marks">
                    <img <?php echo fenster_image_attr_string($trust . 'trustpilot-excellent.png', ['alt' => __('Rated Excellent on Trustpilot', 'fenster'), 'loading' => 'lazy']); ?>>
                    <img <?php echo fenster_image_attr_string($trust . 'fensa.png', ['alt' => __('FENSA approved', 'fenster'), 'loading' => 'lazy']); ?>>
                    <img <?php echo fenster_image_attr_string($trust . 'cpa.png', ['alt' => __('Consumer Protection Association insurance-backed guarantee', 'fenster'), 'loading' => 'lazy']); ?>>
                </div>
                <?php if ($google_reviews_url !== '') : ?>
                    <p class="fg-hn-room__rev"><a class="fg-hn-link" href="<?php echo esc_url($google_reviews_url); ?>" target="_blank" rel="noopener" data-fg-cta><?php esc_html_e('Hundreds of Google reviews', 'fenster'); ?></a></p>
                <?php endif; ?>
                <div class="fg-hn-act fg-hn-act--row">
                    <?php echo $button(__('Get my instant price', 'fenster'), $quote()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <a class="fg-hn-link" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>" data-fg-cta><?php esc_html_e('Book a free home visit', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-hn-room__photo">
                <img <?php echo fenster_image_attr_string($img . 'showroom-968w.webp', ['alt' => __('The Fenster Glazing showroom on Alston Drive, Bradwell Abbey', 'fenster'), 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 92vw, 40vw']); ?>>
            </figure>
        </div>
    </section>

    <?php /* And its map: every finished job pinned across the area we cover. */ ?>
    <div class="fg-h30 fg-hn-h30">
        <?php get_template_part('template-parts/components/h30-areas', null, [
            'title' => __('Where we fit', 'fenster'),
            'kicker' => '',
            'notes' => [
                __('Milton Keynes, Bedford, Northampton, Aylesbury and the towns between', 'fenster'),
                __('Green pins are recent jobs. Click one to see the house', 'fenster'),
            ],
        ]); ?>
    </div>

    <section class="fg-hn-close" aria-labelledby="fg-hn-close-title" data-fg-hn-close>
        <div class="fg-hn-wrap">
            <h2 id="fg-hn-close-title" class="fg-hn-close__title"><?php esc_html_e('Ready for your price?', 'fenster'); ?></h2>
            <div class="fg-hn-close__cta">
                <?php echo $button(__('Get my instant price', 'fenster'), $quote(), 'fg-hn-btn--lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <ul class="fg-hn-ways">
                <li><a href="tel:<?php echo esc_attr($phone_href); ?>" data-fg-cta><span class="fg-hn-num"><?php echo esc_html($phone); ?></span><small><?php esc_html_e('Lines open 24/7', 'fenster'); ?></small></a></li>
                <li><a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>" data-fg-cta><?php esc_html_e('Free home visit', 'fenster'); ?><small><?php esc_html_e('We build the quote with you', 'fenster'); ?></small></a></li>
                <li><a href="#fg-hn-showroom" data-fg-cta><?php esc_html_e('Showroom', 'fenster'); ?><small><?php esc_html_e('Bradwell Abbey', 'fenster'); ?></small></a></li>
            </ul>
            <p class="fg-hn-quiet">
                <a href="<?php echo esc_url(home_url('/window-and-door-repairs/')); ?>" data-fg-cta><?php esc_html_e('Need a repair?', 'fenster'); ?></a>
                <a href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>" data-fg-cta><?php esc_html_e('Commercial project?', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/location-town-links', null, ['product' => 'double-glazing']); ?>

    <nav class="fg-hn-guides" aria-label="<?php esc_attr_e('Guides', 'fenster'); ?>">
        <div class="fg-hn-wrap">
            <ul>
                <?php foreach ($guides as $guide) : ?>
                    <li><a href="<?php echo esc_url($guide['url']); ?>" data-fg-cta><?php echo esc_html($guide['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</article>
