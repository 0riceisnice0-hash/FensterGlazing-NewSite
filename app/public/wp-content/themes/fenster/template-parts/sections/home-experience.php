<?php
/**
 * Hardcoded homepage experience for Fenster.
 *
 * This is intentionally separate from the generic generated page renderer so
 * future AI work can understand and extend the homepage without untangling the
 * product/location page template.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'asset_base' => '/wp-content/themes/fenster/assets/images/imported/',
    'brand' => [],
    'hero_intro' => '',
    'instant_quote_preview' => '',
    'instant_quote_url' => '',
    'related_links' => [],
    'sick_video' => '',
    'title' => 'Double Glazing in Milton Keynes',
    'trust_items' => [],
]);

$asset_base = (string) $args['asset_base'];
$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$title = (string) $args['title'];
$hero_intro = (string) $args['hero_intro'];
$instant_quote_url = (string) $args['instant_quote_url'];
$instant_quote_preview = (string) $args['instant_quote_preview'];
$related_links = is_array($args['related_links']) ? $args['related_links'] : [];
$sick_video = (string) $args['sick_video'];
$trust_items = is_array($args['trust_items']) ? $args['trust_items'] : [];
$hero_poster = $asset_base . 'home-hero-poster.jpg';

$trust_messages = [
    ['title' => 'Hundreds of customer reviews', 'copy' => 'Feedback across Google and Trustpilot.', 'item' => $trust_items[0] ?? null],
    ['title' => 'Rated Excellent', 'copy' => 'Independent feedback on Trustpilot.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
    ['title' => 'Insurance-backed protection', 'copy' => 'Supported by the Consumer Protection Association.', 'item' => $trust_items[3] ?? null],
];

$product_routes = [
    ['label' => 'Windows', 'url' => home_url('/windows-milton-keynes/'), 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-windows.jpg', 'copy' => 'Compare uPVC, aluminium, flush casement, sash and heritage styles, with help choosing the right warmth, security, colour and sightlines.', 'best_for' => 'Every style of property', 'benefit' => 'Warmer, quieter rooms'],
    ['label' => 'Doors', 'url' => home_url('/doors-milton-keynes/'), 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-composite-door.jpg', 'copy' => 'Explore entrance, French, patio, sliding and bifold doors in one place, from secure front doors to wide garden openings.', 'best_for' => 'Entrances and garden access', 'benefit' => 'Security, light and kerb appeal'],
    ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/'), 'image' => $asset_base . 'S1-Lantern-Kitchen-A-min-scaled.jpg', 'copy' => 'Bring more natural light into an extension or open-plan room with a slim aluminium roof lantern made around your space.', 'best_for' => 'Extensions and open-plan rooms', 'benefit' => 'More overhead daylight'],
    ['label' => 'Integral Blinds', 'url' => home_url('/integral-blinds/'), 'image' => $asset_base . 'HiTech-Blinds-Integral-Blinds-Black-Doors.jpg', 'copy' => 'Blinds sealed safely between the glass give you clean, low-maintenance control of light and privacy.', 'best_for' => 'Doors and glazed rooms', 'benefit' => 'Protected, easy privacy'],
    ['label' => 'Other Services', 'url' => home_url('/other-services/'), 'image' => $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg', 'copy' => 'Find replacement glass, glazing repairs, cat and dog flaps, porches and the smaller upgrades that complete your home.', 'best_for' => 'Repairs and finishing touches', 'benefit' => 'Practical glazing solutions'],
];

$case_cards = [
    [
        'label' => 'Water Stratford',
        'title' => '300 year old property, handled with care.',
        'copy' => 'Flush sash windows were specified for a historic local property near Buckingham, keeping the character while upgrading comfort and performance.',
        'image' => $asset_base . 'smart148.jpg',
        'url' => home_url('/commercial-projects/'),
    ],
    [
        'label' => 'Healthcare',
        'title' => 'Commercial replacement glazing in live settings.',
        'copy' => 'Fenster supports healthcare and high-use commercial environments where access, safety and disruption planning matter as much as the frames.',
        'image' => $asset_base . 'healthcare.jpg',
        'url' => home_url('/commercial-window-installation-in-healthcare/'),
    ],
    [
        'label' => 'Commercial',
        'title' => 'Aluminium systems for national sites.',
        'copy' => 'Commercial windows and doors are selected around performance, compliance, access and lifecycle value, with nationwide project capability.',
        'image' => $asset_base . 'commercial-5.jpg',
        'url' => home_url('/commercial-glazing/'),
    ],
    [
        'label' => 'Local homes',
        'title' => 'Milton Keynes installs with proper aftercare.',
        'copy' => 'From warm window upgrades to statement entrance doors, the work is surveyed, fitted and supported by the Fenster team.',
        'image' => $asset_base . 'new-front-door-in-Milton-Keynes.jpeg',
        'url' => home_url('/commercial-projects/'),
    ],
];

$partners = [
    ['label' => 'Sheerline', 'type' => 'Aluminium systems', 'copy' => 'Slim aluminium windows, doors and glazed openings for cleaner sightlines.', 'src' => FENSTER_THEME_URI . '/assets/partners/sheerline.png'],
    ['label' => 'Liniar', 'type' => 'uPVC frames', 'copy' => 'EnergyPlus uPVC window and door systems for everyday home upgrades.', 'src' => FENSTER_THEME_URI . '/assets/partners/liniar-logo.png'],
    ['label' => 'Roseview', 'type' => 'Sliding sash windows', 'copy' => 'Sash-specific systems for heritage-style windows with proper period detail.', 'src' => FENSTER_THEME_URI . '/assets/partners/roseview-logo-new.png'],
    ['label' => 'Distinction Doors', 'type' => 'Composite doors', 'copy' => 'Entrance door slabs and styles for secure, practical kerb appeal.', 'src' => FENSTER_THEME_URI . '/assets/partners/distinction-doors.png'],
];

$location_links = [
    ['text' => 'Double Glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/')],
    ['text' => 'Double Glazing Northampton', 'url' => home_url('/double-glazing-northampton/')],
    ['text' => 'Double Glazing Bedford', 'url' => home_url('/double-glazing-bedford/')],
    ['text' => 'Double Glazing Buckingham', 'url' => home_url('/double-glazing-buckingham/')],
    ['text' => 'Double Glazing Ampthill', 'url' => home_url('/double-glazing-ampthill/')],
    ['text' => 'Double Glazing Toddington', 'url' => home_url('/double-glazing-toddington/')],
    ['text' => 'Windows Milton Keynes', 'url' => home_url('/windows-milton-keynes/')],
    ['text' => 'Doors Milton Keynes', 'url' => home_url('/doors-milton-keynes/')],
];
?>

<article class="generated-page generated-page--home-lab">
    <section class="fg-home-hero" data-fg-home-hero aria-label="<?php esc_attr_e('Fenster Glazing homepage hero', 'fenster'); ?>">
        <?php if ($sick_video !== '') : ?>
            <video class="fg-home-hero__video" autoplay muted loop playsinline preload="none" poster="<?php echo esc_url(fenster_generated_url($hero_poster)); ?>" data-fg-lazy-video data-fg-video-slow-mode="interaction">
                <source data-src="<?php echo esc_url($sick_video); ?>" type="video/mp4">
            </video>
        <?php endif; ?>
        <div class="fg-home-hero__shade"></div>
        <div class="container fg-home-hero__inner">
            <div class="fg-home-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Fenster Glazing', 'fenster'); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <p><?php echo esc_html($hero_intro); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--light" href="#fenster-products"><?php esc_html_e('Explore our products', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <div class="fg-home-product-flow">
    <section class="fg-home-proof-wall" aria-label="<?php esc_attr_e('Reviews and accreditations', 'fenster'); ?>">
        <div class="container fg-home-proof-wall__grid">
            <?php foreach ($trust_messages as $trust) : ?>
                <?php if (is_array($trust['item'])) : ?>
                    <article class="fg-home-trust-card">
                        <img <?php echo fenster_image_attr_string((string) $trust['item']['src'], ['alt' => (string) $trust['item']['alt'], 'loading' => 'lazy']); ?>>
                        <div>
                            <strong><?php echo esc_html($trust['title']); ?></strong>
                            <span><?php echo esc_html($trust['copy']); ?></span>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="container fg-home-proof-wall__link">
            <a href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('Why you can trust Fenster Glazing', 'fenster'); ?></a>
        </div>
    </section>

    <section
        id="fenster-products"
        class="fg-home-product-theatre"
        data-fg-product-theatre
        style="--fg-product-count: <?php echo esc_attr((string) count($product_routes)); ?>;"
        aria-label="<?php esc_attr_e('Explore Fenster products', 'fenster'); ?>">
        <div class="fg-home-product-theatre__stage">
            <div class="container fg-home-product-theatre__shell">
                <header class="fg-home-product-theatre__intro">
                    <p class="eyebrow"><?php esc_html_e('Explore the range', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Find the right fit for your home.', 'fenster'); ?></h2>
                </header>

                <nav class="fg-home-product-theatre__nav" aria-label="<?php esc_attr_e('Product showcase navigation', 'fenster'); ?>">
                    <?php foreach ($product_routes as $index => $route) : ?>
                        <button
                            class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                            type="button"
                            data-fg-product-jump="<?php echo esc_attr((string) $index); ?>"
                            aria-label="<?php echo esc_attr('Show ' . $route['label']); ?>">
                            <span><?php echo esc_html($route['label']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </nav>

                <div class="fg-home-product-theatre__visual">
                    <a
                        class="fg-home-product-theatre__frame"
                        data-fg-product-tilt
                        data-fg-product-stage-link
                        href="<?php echo esc_url($product_routes[0]['url']); ?>"
                        aria-label="<?php echo esc_attr('Explore ' . $product_routes[0]['label']); ?>">
                        <?php foreach ($product_routes as $index => $route) : ?>
                            <img <?php echo fenster_image_attr_string((string) $route['image'], [
                                'class' => $index === 0 ? 'is-active' : '',
                                'data-fg-product-visual' => (string) $index,
                                'alt' => '',
                                'loading' => $index === 0 ? 'eager' : 'lazy',
                                'fetchpriority' => $index === 0 ? 'high' : 'auto',
                            ]); ?>>
                        <?php endforeach; ?>
                        <div class="fg-home-product-theatre__wipe" aria-hidden="true"></div>
                        <div class="fg-home-product-theatre__reflection" aria-hidden="true"></div>
                        <span class="fg-home-product-theatre__counter" data-fg-product-counter><?php echo esc_html('01 / ' . sprintf('%02d', count($product_routes))); ?></span>
                    </a>
                </div>

                <div class="fg-home-product-theatre__content">
                    <?php foreach ($product_routes as $index => $route) : ?>
                        <article
                            class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                            data-fg-product-content="<?php echo esc_attr((string) $index); ?>"
                            aria-hidden="<?php echo esc_attr($index === 0 ? 'false' : 'true'); ?>">
                            <span><?php echo esc_html($route['best_for']); ?></span>
                            <h3><?php echo esc_html($route['label']); ?></h3>
                            <p><?php echo esc_html($route['copy']); ?></p>
                            <div class="fg-home-product-theatre__facts">
                                <small><?php esc_html_e('Why homeowners choose it', 'fenster'); ?></small>
                                <strong><?php echo esc_html($route['benefit']); ?></strong>
                            </div>
                            <a href="<?php echo esc_url($route['url']); ?>"><?php echo esc_html('Explore ' . $route['label']); ?></a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="fg-home-product-theatre__timeline" aria-hidden="true">
                    <span data-fg-product-progress></span>
                </div>
            </div>
        </div>

        <div class="container fg-home-product-theatre__mobile">
            <div class="fg-home-product-theatre__mobile-head">
                <p class="eyebrow"><?php esc_html_e('Explore the range', 'fenster'); ?></p>
                <h2><?php esc_html_e('What would you like to improve?', 'fenster'); ?></h2>
                <p class="fg-home-product-theatre__mobile-cue"><?php esc_html_e('Swipe through the range, then tap a product to explore it.', 'fenster'); ?></p>
            </div>
            <div
                class="fg-home-product-theatre__mobile-carousel"
                role="group"
                aria-roledescription="<?php esc_attr_e('carousel', 'fenster'); ?>"
                aria-label="<?php esc_attr_e('Fenster product range', 'fenster'); ?>">
                <div class="fg-home-product-theatre__mobile-track" role="group" aria-label="<?php esc_attr_e('Swipe through Fenster products', 'fenster'); ?>">
                    <?php foreach ($product_routes as $index => $route) : ?>
                        <a class="fg-home-product-theatre__mobile-card" href="<?php echo esc_url($route['url']); ?>">
                            <img <?php echo fenster_image_attr_string((string) $route['image'], ['alt' => (string) $route['label'], 'loading' => $index === 0 ? 'eager' : 'lazy', 'fetchpriority' => $index === 0 ? 'high' : 'auto']); ?>>
                            <div>
                                <span><?php echo esc_html($route['best_for']); ?></span>
                                <strong><?php echo esc_html($route['label']); ?></strong>
                                <p><?php echo esc_html($route['copy']); ?></p>
                                <small><?php echo esc_html($route['benefit']); ?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="fg-home-product-theatre__mobile-dots" role="group" aria-label="<?php esc_attr_e('Choose a product slide', 'fenster'); ?>">
                    <?php foreach ($product_routes as $index => $route) : ?>
                        <button
                            class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                            type="button"
                            data-fg-mobile-product-dot="<?php echo esc_attr((string) $index); ?>"
                            aria-label="<?php echo esc_attr(sprintf('Show %s', $route['label'])); ?>"
                            aria-current="<?php echo esc_attr($index === 0 ? 'true' : 'false'); ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-home-quote-station fg-home-quote-station--bridge">
        <div class="container fg-home-quote-station__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Ready to see a price?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Get an instant quote for your windows and doors.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Choose your product, style, colour and approximate size online. You will see an immediate guide price, then Fenster can confirm the final details after survey.', 'fenster'); ?></p>
                <ul class="fg-home-quote-station__points">
                    <li><?php esc_html_e('Available straight away', 'fenster'); ?></li>
                    <li><?php esc_html_e('No callback needed to begin', 'fenster'); ?></li>
                    <li><?php esc_html_e('Final specification checked by Fenster', 'fenster'); ?></li>
                </ul>
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url($instant_quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
            </div>
            <div class="fg-home-quote-station__preview" data-quote-frame-wrap data-quote-card data-lenis-prevent data-quote-url="<?php echo esc_url($instant_quote_url); ?>" data-quote-autoload="near">
                <div class="fg-quote-frame-placeholder">
                    <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                    <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                    <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                </div>
                <iframe
                    data-quote-iframe-src="<?php echo esc_url($instant_quote_url); ?>"
                    title="<?php esc_attr_e('Fenster instant quote tool', 'fenster'); ?>"
                    loading="lazy"
                    allow="fullscreen"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    </div>

    <section class="fg-home-partner-strip">
        <div class="container fg-home-partner-strip__inner">
            <div class="fg-home-partner-strip__copy">
                <p class="eyebrow"><?php esc_html_e('Systems and backing', 'fenster'); ?></p>
                <h2><?php esc_html_e('Product systems matched to the job.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Fenster specifies recognised window and door systems around the property, budget and finish you want.', 'fenster'); ?></p>
            </div>
            <div class="fg-home-partner-strip__logos">
                <?php foreach ($partners as $partner) : ?>
                    <article class="fg-home-partner-card">
                        <div>
                            <?php if ($partner['src'] !== '') : ?>
                                <img <?php echo fenster_image_attr_string((string) $partner['src'], ['alt' => (string) $partner['label'], 'loading' => 'lazy']); ?>>
                            <?php else : ?>
                                <strong><?php echo esc_html($partner['label']); ?></strong>
                            <?php endif; ?>
                        </div>
                        <strong class="fg-home-partner-card__name"><?php echo esc_html($partner['label']); ?></strong>
                        <span><?php echo esc_html($partner['type']); ?></span>
                        <p><?php echo esc_html($partner['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--home',
        'eyebrow' => 'Customer proof',
        'title' => 'Reviewed, accredited and backed by proven product systems.',
        'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-home-showroom" id="fenster-enquiry">
        <div class="container fg-home-showroom__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you would like to change.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Share the product, property location and a few project details. The Fenster team will come back to you to discuss options and arrange the next step.', 'fenster'); ?></p>
                <div class="fg-home-showroom__links">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form fg-home-enquiry-form',
                'source' => 'Homepage',
                'button_label' => 'Request a quote',
            ]);
            ?>
        </div>
    </section>

    <section class="fg-home-seo-mesh">
        <div class="container">
            <div class="fg-home-section-head">
                <p class="eyebrow"><?php esc_html_e('Local installations', 'fenster'); ?></p>
                <h2><?php esc_html_e('Double glazing across Milton Keynes and nearby towns.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A few of our main local service areas. Contact Fenster if your town is not listed.', 'fenster'); ?></p>
            </div>
            <div class="fg-home-seo-mesh__links">
                <?php foreach (array_slice($location_links, 0, 8) as $link) : ?>
                    <a href="<?php echo esc_url(fenster_generated_url((string) $link['url'])); ?>"><?php echo esc_html((string) $link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</article>
