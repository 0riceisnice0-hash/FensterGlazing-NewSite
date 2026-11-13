<?php
/**
 * The price-first homepage, variant A, "Open House" (A/B test, 10/11/2026).
 *
 * Served at /?home=a (noindex, canonical /), see fenster_home_variant_requested()
 * in inc/generated-pages.php. Variant B is template-parts/sections/home-next.php.
 *
 * One job: start a price. The hero is a working model of the quote journey,
 * in Homepage 3.0's language (owner, 10/11/2026): a big rounded photo card, a
 * centred headline that types itself out (typewriter.js, via data-h30-type),
 * a light product panel where 3.0's dark finder sat, a slim trust row.
 * - Four real products, each with its real "from" price. Every tile is a
 *   plain link to that product's WindowCAD designer, so the page works with
 *   JavaScript off. With it on (initHomeA in src/js/home-a.js) the picked
 *   product's photo wipes onto the card and the bar turns into the kinds the
 *   tool prices (uPVC, sash, aluminium...), each a link straight into the
 *   tool. "All products" goes back to the four. Bifolds have one kind, so
 *   that tile is a plain link to the tool.
 * - 3.0's project rail and coverage map come in as components
 *   (template-parts/components/h30-*.php) inside a .fg-h30 wrapper.
 * - The product chosen there is carried into every price button on the page,
 *   and into the footer's phone price bar.
 * - Repairs and commercial get quiet exits: neither can be instant-priced
 *   (owner rule 16/09/2026).
 * - Pricing is instant. Never write "ten minutes" here (owner, 10/11/2026).
 * - Nothing dark bigger than half a viewport (owner rule 02/09/2026), and every
 *   section fits one 1440 x 780 screen under the header.
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
   Aluminium windows £1,117: a 540x518 Sheerline casement, website quote 17 Oct
   2026 (£930.58 + VAT), sold-quoted £952.36 + VAT two days later. NOT £450
   (owner, 11/11/2026: "we've never sold an alley window at that price"): that
   was one line inside a large office job on 9 Nov, priced far below the same
   job's other windows. Lines inside multi-window office jobs are not prices.
   Sash windows £989: a 600x1000 Charisma sash, contract 5 Oct 2026 at
   £824.29 + VAT, the cheapest sash actually sold. NOT £794: that was two
   350mm-wide heritage units in one office quote at an identical price, a
   minimum charge, not a price (owner chose £989, 11/11/2026).
   `bar` is the phone price bar's label once that product is chosen. */
$ha_products = [
    'windows' => ['name' => 'Windows', 'from' => '£506', 'slug' => 'casement-windows', 'bar' => 'Price my windows', 'kind' => 'window', 'alt' => 'Grey casement windows in a stone cottage wall'],
    'door' => ['name' => 'Front doors', 'from' => '£1,480', 'slug' => 'composite-doors', 'bar' => 'Price my front door', 'kind' => 'door', 'alt' => 'A black Distinction composite front door with a long bar handle and glazed panel'],
    'patio' => ['name' => 'French & patio doors', 'from' => '£1,726', 'slug' => 'patio-doors', 'bar' => 'Price my patio doors', 'kind' => 'door', 'alt' => 'Black French doors set between flush casements in a white painted wall, Wolverton'],
    'bifold' => ['name' => 'Bifold doors', 'from' => '£2,324', 'slug' => 'aluminium-bifold-doors', 'bar' => 'Price my bifolds', 'kind' => 'door', 'alt' => 'Black aluminium slide and fold doors folded open in our Bradwell Abbey showroom'],
];
$ha_sash = ['name' => 'Sash windows', 'from' => '£989', 'slug' => 'sliding-sash-windows'];

/* CONVERSION FIRST (owner, 10/11/2026): picking a category turns the bar into
   the kinds the quote tool prices, and each one opens the tool on that product
   straight away. No screenshots of the tool in between. One kind per quote-tool
   collection (inc/quote-collections.php), so no two buttons open the same
   designer. Every kind has a real from-price from the CRM (see above).
   A category with one kind (bifolds) is a plain link. */
$ha_types = [
    'windows' => ['ask' => 'Which windows?', 'types' => [
        ['name' => 'uPVC windows', 'slug' => 'casement-windows', 'from' => '£506', 'img' => 'thumb-windows'],
        ['name' => 'Sash windows', 'slug' => 'sliding-sash-windows', 'from' => '£989', 'img' => 'sub-sash'],
        ['name' => 'Aluminium windows', 'slug' => 'aluminium-windows', 'from' => '£1,117', 'img' => 'sub-alu-windows'],
    ]],
    'door' => ['ask' => 'Which front door?', 'types' => [
        ['name' => 'Composite doors', 'slug' => 'composite-doors', 'from' => '£1,480', 'img' => 'kind-composite'],
        ['name' => 'uPVC doors', 'slug' => 'upvc-doors', 'from' => '£1,166', 'img' => 'kind-upvc-door'],
        ['name' => 'Aluminium doors', 'slug' => 'aluminium-doors', 'from' => '£2,299', 'img' => 'kind-alu-door'],
    ]],
    'patio' => ['ask' => 'Which garden doors?', 'types' => [
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
foreach ($ha_types as $__key => $__group) {
    if (! isset($ha_products[$__key]) || empty($__group['types'])) {
        continue;
    }
    $__cheapest = array_reduce($__group['types'], static fn (?array $low, array $type): array => $low === null || $__from_value($type['from']) < $__from_value($low['from']) ? $type : $low);
    $ha_products[$__key]['from'] = $__cheapest['from'];
}
unset($__from_value, $__key, $__group, $__cheapest);
$ha_price_note = 'Lowest prices from real Fenster quotes, Oct 2024–Nov 2026, inc VAT. Your price depends on size and spec.';

/* The typed headline (typewriter.js from Homepage 3.0). Short, price-led, every
   figure from the list above, no full stops. Pricing is instant: never "ten
   minutes". The first line is what shows without JavaScript. */
$ha_headlines = [
    'Instant window and door prices',
    'Windows from ' . $ha_products['windows']['from'],
    'Front doors from ' . $ha_products['door']['from'],
    'French doors from ' . $ha_products['patio']['from'],
    'Bifold doors from ' . $ha_products['bifold']['from'],
];

/* The opening photograph: a real local job, linked to its write-up. */
$ha_home = [
    'alt' => 'Agate grey flush windows and a matching composite front door across a Little Horwood cottage',
    'location' => 'Little Horwood',
    'project' => 'flush-casement-windows-and-composite-door-little-horwood',
];

/* VARIANT B, "the tool is the homepage" (owner, 13/11/2026: "build b"). The
   first screen is the live designer, already open on the first product, with
   the products above it as a row of chips. A chip changes what the designer is
   pricing; nothing navigates. Everything below the first screen is A's page,
   so the test measures the first screen and nothing else. Each chip is one
   quote-tool collection with its real from-price from the kinds above. */
$ha_b = function_exists('fenster_home_variant_requested') && fenster_home_variant_requested() === 'b';
$hb_kinds = [];
foreach ([['windows', 'casement-windows'], ['door', 'composite-doors'], ['door', 'upvc-doors'], ['patio', 'french-doors'], ['bifold', 'aluminium-bifold-doors'], ['windows', 'sliding-sash-windows'], ['windows', 'aluminium-windows']] as [$__group, $__slug]) {
    $__kind = null;
    foreach ($ha_types[$__group]['types'] ?? [] as $__type) {
        if ($__type['slug'] === $__slug) {
            $__kind = $__type;
        }
    }
    if ($__kind === null && $__group === 'bifold') {
        $__kind = ['name' => 'Bifold doors', 'slug' => $__slug, 'from' => $ha_products['bifold']['from'], 'img' => 'thumb-bifold'];
    }
    if ($__kind !== null && function_exists('fenster_quote_collection_url') && fenster_quote_collection_url($__slug) !== '') {
        $hb_kinds[] = $__kind + ['url' => fenster_quote_collection_url($__slug)];
    }
}
unset($__group, $__slug, $__kind, $__type);

$args = wp_parse_args($args ?? [], [
    'brand' => [],
]);
$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? fenster_data('brand.phone', '01908 429200'));
$phone_href = preg_replace('/\s+/', '', $phone);
$address = array_values(array_filter(array_map('strval', (array) fenster_data('brand.address', []))));
$showroom_hours = (string) fenster_data('brand.showroom_hours', '');
$google_reviews_url = (string) fenster_data('brand.google_reviews_url', '');
$ha_reviews = function_exists('fenster_review_summary') ? (array) fenster_review_summary() : [];
$ha_rating = number_format((float) ($ha_reviews['rating'] ?? fenster_data('brand.google_rating', 4.9)), 1);
$ha_tick = '<svg class="fg-ha-ic fg-ha-ic--sm" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>';

$img = FENSTER_THEME_URI . '/assets/images/home-a/';
$trust = FENSTER_THEME_URI . '/assets/trust/';
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

$guides = [
    ['label' => 'Guides and advice', 'url' => home_url('/blog/')],
    ['label' => 'Window and door prices in Milton Keynes', 'url' => home_url('/window-door-prices-milton-keynes/')],
    ['label' => 'What is double glazing and how does it work?', 'url' => home_url('/what-are-double-glazed-glass-windows/')],
    ['label' => 'Try the 3D visualiser', 'url' => home_url('/3d-visualiser/')],
];

/* What the script needs: each product's copy and the quote tool's address. */
$ha_config = [
    'quote' => home_url('/online-quote/'),
    'products' => array_map(static fn (array $p): array => [
        'name' => $p['name'],
        'from' => $p['from'],
        'slug' => $p['slug'],
        'url' => $quote($p['slug']),
        'bar' => $p['bar'],
        'kind' => $p['kind'],
    ], $ha_products),
    'asks' => array_map(static fn (array $g): string => $g['ask'], $ha_types),
];

/* A price button: label, then a spinner and a tick that take its place.
   $carries: the chosen product is written into its link (data-fg-ha-price). */
$button = static function (string $label, string $href, string $class = '', bool $carries = true) use ($ha_b): string {
    if ($ha_b) {
        return sprintf('<a class="fg-ha-btn%1$s" href="#fg-hb-tool" data-fg-cta data-fg-hb-jump><span class="fg-ha-btn__label">%2$s</span></a>', $class !== '' ? ' ' . esc_attr($class) : '', esc_html($label));
    }

    return sprintf(
        '<a class="fg-ha-btn%1$s" href="%2$s" data-fg-cta data-fg-ha-go%3$s><span class="fg-ha-btn__label">%4$s</span><span class="fg-ha-btn__busy" aria-hidden="true"><span class="fg-ha-btn__spin"></span><svg class="fg-ha-btn__tick" viewBox="0 0 16 16" focusable="false"><path d="M3 8.5 6.5 12 13 4.5"/></svg></span></a>',
        $class !== '' ? ' ' . esc_attr($class) : '',
        esc_url($href),
        $carries ? ' data-fg-ha-price' : '',
        esc_html($label)
    );
};
?>
<article class="generated-page generated-page--home-lab fg-ha" data-fg-ha="<?php echo esc_attr((string) wp_json_encode($ha_config)); ?>">

    <?php if ($ha_b && $hb_kinds !== []) : ?>
    <section class="fg-hb" id="fg-hb-tool" data-fg-hb aria-labelledby="fg-hb-title">
        <div class="fg-ha-wrap fg-hb__in">
            <h1 class="fg-hb__title" id="fg-hb-title"><?php esc_html_e('Instant window and door prices', 'fenster'); ?></h1>
            <ul class="fg-hb__picks" aria-label="<?php esc_attr_e('Choose what to price', 'fenster'); ?>">
                <?php foreach ($hb_kinds as $__i => $__kind) : ?>
                    <li>
                        <button class="fg-hb__pick" type="button" data-fg-hb-pick data-url="<?php echo esc_url($__kind['url']); ?>" aria-pressed="<?php echo $__i === 0 ? 'true' : 'false'; ?>">
                            <span class="fg-hb__thumb"><img <?php echo fenster_image_attr_string($img . $__kind['img'] . '-200w.webp', ['alt' => '', 'loading' => 'eager', 'sizes' => '40px']); ?>></span>
                            <span class="fg-hb__label">
                                <span class="fg-hb__name"><?php echo esc_html($__kind['name']); ?></span>
                                <span class="fg-hb__from"><?php esc_html_e('from', 'fenster'); ?> <b class="fg-ha-num"><?php echo esc_html($__kind['from']); ?></b></span>
                            </span>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="fg-hb__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($hb_kinds[0]['url']); ?>" data-quote-autoload="view">
                <p class="fg-hb__wait" aria-hidden="true"><span class="fg-hb__spin"></span><?php esc_html_e('Opening the price tool', 'fenster'); ?></p>
                <iframe data-quote-iframe-src="<?php echo esc_url($hb_kinds[0]['url']); ?>" title="<?php esc_attr_e('Fenster instant price tool', 'fenster'); ?>" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <p class="fg-ha-note fg-hb__note"><?php echo esc_html($ha_price_note); ?></p>
        </div>
        <ul class="fg-ha-trust" aria-label="<?php esc_attr_e('Why homeowners choose Fenster', 'fenster'); ?>">
            <li><a href="<?php echo esc_url($google_reviews_url !== '' ? $google_reviews_url : home_url('/about/')); ?>" target="_blank" rel="noopener" data-fg-cta><span class="fg-ha-stars" aria-hidden="true">★★★★★</span> <b class="fg-ha-num"><?php echo esc_html($ha_rating); ?>/5</b> <?php esc_html_e('on Google', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('FENSA registered', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Our own installation team', 'fenster'); ?></a></li>
            <li><a href="#fg-ha-showroom" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Visit our Milton Keynes showroom', 'fenster'); ?></a></li>
        </ul>
    </section>
    <?php else : ?>
    <section class="fg-ha-hero" data-fg-ha-hero aria-labelledby="fg-ha-title">
        <div class="fg-ha-card">
            <figure class="fg-ha-stage" data-fg-ha-stage>
                <img class="is-on" data-k="home" <?php echo fenster_image_attr_string($img . 'card-home-1300w.webp', ['alt' => $ha_home['alt'], 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 760px) 100vw, 1296px']); ?>>
                <?php foreach ($ha_products as $key => $product) : ?>
                    <img data-k="<?php echo esc_attr($key); ?>" aria-hidden="true" <?php echo fenster_image_attr_string($img . 'card-' . $key . '-1300w.webp', ['alt' => $product['alt'], 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 1296px']); ?>>
                <?php endforeach; ?>
                <figcaption class="fg-ha-credit">
                    <?php echo esc_html(sprintf(__('Fitted by Fenster in %s', 'fenster'), $ha_home['location'])); ?>
                    <a href="<?php echo esc_url(home_url('/case-studies/' . $ha_home['project'] . '/')); ?>" data-fg-cta><?php esc_html_e('See this project', 'fenster'); ?></a>
                </figcaption>
            </figure>

            <?php /* The heading a screen reader hears is the fixed sentence; the
                     line that types itself out (typewriter.js, Homepage 3.0) is
                     decoration beside it and hidden from assistive technology. */ ?>
            <div class="fg-ha-intro">
                <h1 class="fg-ha-title" id="fg-ha-title">
                    <span class="fg-ha-sr"><?php esc_html_e('Instant window and door prices in Milton Keynes', 'fenster'); ?></span>
                    <span class="fg-ha-typed" aria-hidden="true" data-h30-type data-h30-phrases="<?php echo esc_attr((string) wp_json_encode($ha_headlines)); ?>"><span data-h30-type-text><?php echo esc_html($ha_headlines[0]); ?></span><span class="fg-ha-caret"></span></span>
                </h1>
            </div>

            <div class="fg-ha-panel">
                <div class="fg-ha-state fg-ha-state--pick" data-fg-ha-lineup>
                    <ul class="fg-ha-picks" aria-label="<?php esc_attr_e('Choose a product to price', 'fenster'); ?>">
                        <?php foreach ($ha_products as $key => $product) : ?>
                            <li>
                                <a class="fg-ha-pick fg-ha-pick--cat" href="<?php echo esc_url(isset($ha_types[$key]) ? $chooser($product['slug']) : $quote($product['slug'])); ?>" data-fg-cta<?php if (isset($ha_types[$key])) : ?> data-fg-ha-pick="<?php echo esc_attr($key); ?>"<?php endif; ?>>
                                    <span class="fg-ha-pick__img"><img <?php echo fenster_image_attr_string($img . 'thumb-' . $key . '-200w.webp', ['alt' => '', 'loading' => 'eager', 'sizes' => '96px']); ?>></span>
                                    <span class="fg-ha-pick__text">
                                        <span class="fg-ha-pick__name"><?php echo esc_html($product['name']); ?></span>
                                        <span class="fg-ha-pick__from"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-ha-num"><?php echo esc_html($product['from']); ?></b></span>
                                    </span>
                                    <span class="fg-ha-pick__cta"><?php esc_html_e('Get my price', 'fenster'); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="fg-ha-note"><?php echo esc_html($ha_price_note); ?></p>
                </div>

                <div class="fg-ha-state fg-ha-state--chosen" data-fg-ha-detail hidden>
                    <div class="fg-ha-typesbar">
                        <button class="fg-ha-back" type="button" data-fg-ha-back>
                            <svg class="fg-ha-ic" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15 18l-6-6 6-6"/></svg>
                            <?php esc_html_e('All products', 'fenster'); ?>
                        </button>
                        <h2 class="fg-ha-typesbar__ask" data-fg-ha-name tabindex="-1"><?php echo esc_html($ha_types['windows']['ask']); ?></h2>
                    </div>
                    <?php foreach ($ha_types as $key => $group) : ?>
                        <ul class="fg-ha-picks fg-ha-picks--types" data-fg-ha-types="<?php echo esc_attr($key); ?>" aria-label="<?php echo esc_attr($group['ask']); ?>" hidden>
                            <?php foreach ($group['types'] as $type) : ?>
                                <li>
                                    <a class="fg-ha-pick fg-ha-pick--type" href="<?php echo esc_url($quote($type['slug'])); ?>" data-fg-cta data-fg-ha-type>
                                        <span class="fg-ha-pick__img"><img <?php echo fenster_image_attr_string($img . $type['img'] . '-200w.webp', ['alt' => '', 'loading' => 'lazy', 'sizes' => '96px']); ?>></span>
                                        <span class="fg-ha-pick__text">
                                            <span class="fg-ha-pick__name"><?php echo esc_html($type['name']); ?></span>
                                            <?php if ($type['from'] !== '') : ?>
                                                <span class="fg-ha-pick__from"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-ha-num"><?php echo esc_html($type['from']); ?></b></span>
                                            <?php endif; ?>
                                            <span class="fg-ha-pick__cta"><?php esc_html_e('Get my price', 'fenster'); ?></span>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                    <p class="fg-ha-note"><?php echo esc_html($ha_price_note); ?></p>
                </div>
            </div>
        </div>

        <ul class="fg-ha-trust" aria-label="<?php esc_attr_e('Why homeowners choose Fenster', 'fenster'); ?>">
            <li><a href="<?php echo esc_url($google_reviews_url !== '' ? $google_reviews_url : home_url('/about/')); ?>" target="_blank" rel="noopener" data-fg-cta><span class="fg-ha-stars" aria-hidden="true">★★★★★</span> <b class="fg-ha-num"><?php echo esc_html($ha_rating); ?>/5</b> <?php esc_html_e('on Google', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('FENSA registered', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Our own installation team', 'fenster'); ?></a></li>
            <li><a href="#fg-ha-showroom" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Visit our Milton Keynes showroom', 'fenster'); ?></a></li>
        </ul>

    </section>
    <?php endif; ?>

    <section class="fg-ha-next" aria-labelledby="fg-ha-next-title">
        <figure class="fg-ha-next__photo">
            <img <?php echo fenster_image_attr_string($img . 'installer-700w.webp', ['alt' => 'A Fenster installer hanging a new composite front door in Milton Keynes', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 46vw']); ?>>
        </figure>
        <div class="fg-ha-next__copy">
            <h2 class="fg-ha-h2" id="fg-ha-next-title"><?php esc_html_e('From price to fitted', 'fenster'); ?></h2>
            <ol class="fg-ha-steps">
                <li><h3><?php esc_html_e('Your price, instantly', 'fenster'); ?></h3><p><?php esc_html_e('Pick the style, size and colour. The price appears on screen.', 'fenster'); ?></p></li>
                <li><h3><?php esc_html_e('We survey and confirm', 'fenster'); ?></h3><p><?php esc_html_e('We measure and check the specification before anything is made.', 'fenster'); ?></p></li>
                <li><h3><?php esc_html_e('Our own team fits it', 'fenster'); ?></h3><p><?php esc_html_e('Never subcontracted, and FENSA registered afterwards.', 'fenster'); ?></p></li>
            </ol>
            <div class="fg-ha-act"><?php echo $button(__('Get my instant price', 'fenster'), $quote()); ?></div>
        </div>
    </section>

    <?php /* Homepage 3.0's project rail (owner, 10/11/2026: he loved that page).
             Its styles are scoped to .fg-h30 and its script starts itself. */ ?>
    <div class="fg-h30 fg-ha-h30">
        <?php get_template_part('template-parts/components/h30-projects', null, [
            'title' => __('Recently fitted near you', 'fenster'),
            'lede' => '',
            'kicker' => '',
        ]); ?>
    </div>

    <section class="fg-ha-ba" data-fg-ha-ba aria-labelledby="fg-ha-ba-title">
        <figure class="fg-ha-ba__frame" data-fg-ha-ba-frame>
            <img <?php echo fenster_image_attr_string($img . 'wolverton-before-1000w.webp', ['alt' => 'The Wolverton semi before: white uPVC windows and a cream render', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 760px']); ?>>
            <img class="fg-ha-ba__after" <?php echo fenster_image_attr_string($img . 'wolverton-after-1000w.webp', ['alt' => 'The same Wolverton semi after: black brown flush casements and a white render', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 760px']); ?>>
        </figure>
        <div class="fg-ha-ba__copy">
            <h2 class="fg-ha-h2" id="fg-ha-ba-title"><?php esc_html_e('Wolverton, before and after', 'fenster'); ?></h2>
            <p class="fg-ha-sub"><?php esc_html_e('Every window and both doors, in black brown', 'fenster'); ?></p>
            <div class="fg-ha-switch" role="group" aria-label="<?php esc_attr_e('Show the house', 'fenster'); ?>">
                <span class="fg-ha-switch__knob" data-fg-ha-knob aria-hidden="true"></span>
                <button type="button" aria-pressed="true" data-fg-ha-ba-v="before"><?php esc_html_e('Before', 'fenster'); ?></button>
                <button type="button" aria-pressed="false" data-fg-ha-ba-v="after"><?php esc_html_e('After', 'fenster'); ?></button>
            </div>
            <div class="fg-ha-act fg-ha-act--row">
                <?php echo $button(__('Price my windows', 'fenster'), $quote('casement-windows'), '', false); ?>
                <a class="fg-ha-link" href="<?php echo esc_url(home_url('/case-studies/flush-casement-windows-and-composite-door-wolverton/')); ?>" data-fg-cta><?php esc_html_e('See the job', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <?php /* And its map: every finished job pinned across the area we cover,
             with the showroom on it, just above the showroom itself. */ ?>
    <div class="fg-h30 fg-ha-h30">
        <?php get_template_part('template-parts/components/h30-areas', null, [
            'title' => __('The area we cover', 'fenster'),
            'kicker' => '',
            'notes' => [
                __('From Northampton to St Albans, and Bedford to Brackley', 'fenster'),
                __('Each green pin is a finished job. Tap one to see the house', 'fenster'),
            ],
        ]); ?>
    </div>

    <section class="fg-ha-room" id="fg-ha-showroom" aria-labelledby="fg-ha-room-title">
        <div class="fg-ha-room__copy">
            <h2 class="fg-ha-h2" id="fg-ha-room-title"><?php esc_html_e('Visit the Milton Keynes showroom', 'fenster'); ?></h2>
            <?php if ($address !== []) : ?>
                <address class="fg-ha-room__address"><?php echo esc_html(implode(', ', array_slice($address, 0, 2))); ?><?php if (count($address) > 2) : ?><br><?php echo esc_html(implode(', ', array_slice($address, 2))); ?><?php endif; ?></address>
            <?php endif; ?>
            <?php if ($showroom_hours !== '') : ?>
                <p class="fg-ha-room__hours"><?php echo esc_html($showroom_hours); ?></p>
            <?php endif; ?>
            <div class="fg-ha-act">
                <a class="fg-ha-btn fg-ha-btn--quiet" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>" data-fg-cta><?php esc_html_e('Book a free home visit', 'fenster'); ?></a>
            </div>
            <ul class="fg-ha-marks" aria-label="<?php esc_attr_e('Accreditations and reviews', 'fenster'); ?>">
                <li><img <?php echo fenster_image_attr_string($trust . 'fensa.png', ['alt' => 'FENSA approved installer', 'loading' => 'lazy']); ?>></li>
                <li><img <?php echo fenster_image_attr_string($trust . 'trustpilot-excellent.png', ['alt' => 'Rated Excellent on Trustpilot', 'loading' => 'lazy']); ?>></li>
                <li><img <?php echo fenster_image_attr_string($trust . 'cpa.png', ['alt' => 'CPA insurance-backed guarantee', 'loading' => 'lazy']); ?>></li>
            </ul>
            <?php if ($google_reviews_url !== '') : ?>
                <p class="fg-ha-room__rev"><a class="fg-ha-link" href="<?php echo esc_url($google_reviews_url); ?>" target="_blank" rel="noopener" data-fg-cta><?php esc_html_e('Hundreds of Google reviews', 'fenster'); ?></a></p>
            <?php endif; ?>
        </div>
        <figure class="fg-ha-room__photo">
            <img <?php echo fenster_image_attr_string($img . 'showroom-700w.webp', ['alt' => 'The Fenster Glazing showroom on Alston Drive, Bradwell Abbey', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 50vw']); ?>>
        </figure>
    </section>

    <section class="fg-ha-close" aria-labelledby="fg-ha-close-title">
        <div class="fg-ha-wrap fg-ha-close__in">
            <h2 class="fg-ha-h2" id="fg-ha-close-title"><?php esc_html_e('See your price now', 'fenster'); ?></h2>
            <?php echo $button(__('Get my instant price', 'fenster'), $quote(), 'fg-ha-btn--lg'); ?>
            <p class="fg-ha-close__ways">
                <a class="fg-ha-close__tel" href="tel:<?php echo esc_attr($phone_href); ?>" data-fg-cta>
                    <svg class="fg-ha-ic" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
                    <span class="fg-ha-num"><?php echo esc_html($phone); ?></span><span class="fg-ha-close__open"><?php esc_html_e('lines open 24/7', 'fenster'); ?></span>
                </a>
                <a class="fg-ha-quiet" href="<?php echo esc_url(home_url('/window-and-door-repairs/')); ?>" data-fg-cta><?php esc_html_e('Need a repair?', 'fenster'); ?></a>
                <a class="fg-ha-quiet" href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>" data-fg-cta><?php esc_html_e('Commercial project?', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/location-town-links', null, ['product' => 'double-glazing']); ?>

    <nav class="fg-ha-guides" aria-label="<?php esc_attr_e('Guides', 'fenster'); ?>">
        <div class="fg-ha-wrap">
            <ul>
                <?php foreach ($guides as $guide) : ?>
                    <li><a href="<?php echo esc_url($guide['url']); ?>" data-fg-cta><?php echo esc_html($guide['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</article>
