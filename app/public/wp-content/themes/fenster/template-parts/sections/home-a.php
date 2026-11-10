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
 *   plain link to /online-quote/?product=<slug>, so the page works with
 *   JavaScript off. With it on (initHomeA in src/js/home-a.js) the picked
 *   product's photo wipes onto the card and the panel turns into its price,
 *   the steps you take in the quote tool and one button. "All products" goes
 *   back to the four.
 * - 3.0's project rail and coverage map come in as components
 *   (template-parts/components/h30-*.php) inside a .fg-h30 wrapper.
 * - The quote tool's own screens only ever show a window, so they appear for
 *   Windows only. Doors get their photo and a plain "Style · Size · Colour".
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

/* The real "from" prices: the 10th percentile of real Glasshouse quote lines,
   16 Jul to 10 Nov 2026, inc VAT. Use no figure that is not in this list.
   `kind` decides whether the quote tool's own screens are shown: they only
   ever show a window. */
$ha_products = [
    'windows' => ['name' => 'Windows', 'from' => '£552', 'slug' => 'casement-windows', 'bar' => 'Price my windows', 'kind' => 'window', 'alt' => 'Grey casement windows in a stone cottage wall'],
    'door' => ['name' => 'Front doors', 'from' => '£1,909', 'slug' => 'composite-doors', 'bar' => 'Price my front door', 'kind' => 'door', 'alt' => 'An anthracite grey composite front door with a full height sidelight, fitted in Milton Keynes'],
    'patio' => ['name' => 'French & patio doors', 'from' => '£1,797', 'slug' => 'patio-doors', 'bar' => 'Price my patio doors', 'kind' => 'door', 'alt' => 'Black French doors set between flush casements in a white painted wall, Wolverton'],
    'bifold' => ['name' => 'Bifold doors', 'from' => '£4,418', 'slug' => 'aluminium-bifold-doors', 'bar' => 'Price my bifolds', 'kind' => 'door', 'alt' => 'Black aluminium slide and fold doors folded open in our Bradwell Abbey showroom'],
];
$ha_sash = ['name' => 'Sash windows', 'from' => '£1,045', 'slug' => 'sliding-sash-windows'];
$ha_price_note = 'Starting prices from real Fenster quotes, Jul–Nov 2026, inc VAT. Your price depends on size and spec.';

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
$quote = static fn (string $slug = ''): string => $slug === '' ? home_url('/online-quote/') : add_query_arg('product', $slug, home_url('/online-quote/'));

/* The quote tool's own screens, windows only. */
$ha_tool = [
    'style' => ['label' => 'Style', 'alt' => 'The style step of our quote tool, choosing the window layout'],
    'size' => ['label' => 'Size', 'alt' => 'The size step of our quote tool, with width and height in millimetres'],
    'colour' => ['label' => 'Colour', 'alt' => 'The colour step of our quote tool, with the window redrawn in anthracite grey'],
];

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
        'bar' => $p['bar'],
        'kind' => $p['kind'],
    ], $ha_products),
];

/* A price button: label, then a spinner and a tick that take its place.
   $carries: the chosen product is written into its link (data-fg-ha-price). */
$button = static function (string $label, string $href, string $class = '', bool $carries = true): string {
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
                                <a class="fg-ha-pick" href="<?php echo esc_url($quote($product['slug'])); ?>" data-fg-cta data-fg-ha-pick="<?php echo esc_attr($key); ?>">
                                    <span class="fg-ha-pick__img"><img <?php echo fenster_image_attr_string($img . 'thumb-' . $key . '-200w.webp', ['alt' => '', 'loading' => 'eager', 'sizes' => '96px']); ?>></span>
                                    <span class="fg-ha-pick__text">
                                        <span class="fg-ha-pick__name"><?php echo esc_html($product['name']); ?></span>
                                        <span class="fg-ha-pick__from"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-ha-num"><?php echo esc_html($product['from']); ?></b></span>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="fg-ha-note"><?php echo esc_html($ha_price_note); ?></p>
                </div>

                <div class="fg-ha-state fg-ha-state--chosen" data-fg-ha-detail hidden>
                    <div class="fg-ha-chosen">
                        <button class="fg-ha-back" type="button" data-fg-ha-back>
                            <svg class="fg-ha-ic" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15 18l-6-6 6-6"/></svg>
                            <?php esc_html_e('All products', 'fenster'); ?>
                        </button>
                        <div aria-live="polite">
                            <h2 class="fg-ha-chosen__name" data-fg-ha-name tabindex="-1"><?php echo esc_html($ha_products['windows']['name']); ?></h2>
                            <p class="fg-ha-chosen__price"><?php esc_html_e('From', 'fenster'); ?> <b class="fg-ha-num" data-fg-ha-from><?php echo esc_html($ha_products['windows']['from']); ?></b> <?php esc_html_e('inc VAT', 'fenster'); ?></p>
                        </div>
                        <p class="fg-ha-note fg-ha-note--tight"><?php echo esc_html($ha_price_note); ?></p>
                    </div>
                    <div class="fg-ha-tool">
                        <ul class="fg-ha-shots" data-fg-ha-shots aria-label="<?php esc_attr_e('What you choose in the quote tool', 'fenster'); ?>">
                            <?php foreach ($ha_tool as $key => $tool) : ?>
                                <li>
                                    <button class="fg-ha-shot" type="button" data-fg-ha-zoom="<?php echo esc_attr($img . 'tool-' . $key . '-900w.webp'); ?>" aria-label="<?php echo esc_attr(sprintf(__('Enlarge the %s step', 'fenster'), strtolower($tool['label']))); ?>">
                                        <img <?php echo fenster_image_attr_string($img . 'tool-' . $key . '-240w.webp', ['alt' => $tool['alt'], 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 30vw, 150px']); ?>>
                                        <span><?php echo esc_html($tool['label']); ?></span>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="fg-ha-choose" data-fg-ha-choose hidden><?php esc_html_e('You choose the', 'fenster'); ?> <b><?php esc_html_e('Style · Size · Colour', 'fenster'); ?></b></p>
                    </div>
                    <div class="fg-ha-go">
                        <?php echo $button(__('Get my instant price', 'fenster'), $quote($ha_products['windows']['slug']), 'fg-ha-btn--lg'); ?>
                        <a class="fg-ha-link fg-ha-num" href="<?php echo esc_url($quote($ha_sash['slug'])); ?>" data-fg-cta data-fg-ha-sash><?php echo esc_html(sprintf(__('%1$s from %2$s', 'fenster'), $ha_sash['name'], $ha_sash['from'])); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="fg-ha-trust" aria-label="<?php esc_attr_e('Why homeowners choose Fenster', 'fenster'); ?>">
            <li><a href="<?php echo esc_url($google_reviews_url !== '' ? $google_reviews_url : home_url('/about/')); ?>" target="_blank" rel="noopener" data-fg-cta><span class="fg-ha-stars" aria-hidden="true">★★★★★</span> <b class="fg-ha-num"><?php echo esc_html($ha_rating); ?>/5</b> <?php esc_html_e('on Google', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('FENSA registered', 'fenster'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Our own installation team', 'fenster'); ?></a></li>
            <li><a href="#fg-ha-showroom" data-fg-cta><?php echo $ha_tick; ?><?php esc_html_e('Visit our Milton Keynes showroom', 'fenster'); ?></a></li>
        </ul>

        <dialog class="fg-ha-zoom" data-fg-ha-zoombox aria-label="<?php esc_attr_e('Quote tool screen', 'fenster'); ?>">
            <img class="fg-ha-zoom__img" src="<?php echo esc_url($img . 'tool-style-900w.webp'); ?>" alt="" width="900" height="675" loading="lazy" decoding="async">
            <button class="fg-ha-zoom__close" type="button" data-fg-ha-zoomclose aria-label="<?php esc_attr_e('Close', 'fenster'); ?>">
                <svg class="fg-ha-ic" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </dialog>
    </section>

    <section class="fg-ha-next" aria-labelledby="fg-ha-next-title">
        <figure class="fg-ha-next__photo">
            <img <?php echo fenster_image_attr_string($img . 'installer-700w.webp', ['alt' => 'A Fenster installer hanging a new composite front door in Milton Keynes', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 46vw']); ?>>
        </figure>
        <div class="fg-ha-next__copy">
            <h2 class="fg-ha-h2" id="fg-ha-next-title"><?php esc_html_e('Then what happens', 'fenster'); ?></h2>
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
