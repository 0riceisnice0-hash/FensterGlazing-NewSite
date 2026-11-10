<?php
/**
 * The price-first homepage, Route A of the 10/11/2026 plan (Part B).
 *
 * The classic homepage (home-experience.php) with one job: start a price.
 * Served only at /?home=next until it is switched on (noindex, canonical /),
 * see fenster_home_next_requested() in inc/generated-pages.php. Switching it
 * on for everyone is one edit there.
 *
 * What changed from the classic page, and why (tracker, 12/09 to 10/11/2026):
 * - The hero asks "What would you like a price for?" and each answer opens
 *   /online-quote/ on that product. The hero price button was already the most
 *   clicked thing on the page; 40 visits clicked a product and were sent to read.
 * - Repairs and commercial get their own quiet exits: neither can be
 *   instant-priced (owner rule 16/09/2026).
 * - The quote frame embedded mid-page is gone. Of about 51 completions by
 *   visitors who landed on the homepage, 37 went through /online-quote/ and
 *   about 2 through the embed alone; Homepage 3.0's embed completed zero of 249.
 * - The hero is light. Owner rule 02/09/2026: nothing dark bigger than half a
 *   viewport. The classic hero predates it.
 * - The H1, title, product copy, partner copy, reviews and every town link stay,
 *   because the homepage is #4 for "windows milton keynes".
 *
 * Every button carries data-fg-cta so its clicks are counted (Homepage 3.0's
 * buttons were not, and nobody could see what was happening).
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
    'title' => 'Double Glazing in Milton Keynes',
    'trust_items' => [],
]);

$asset_base = (string) $args['asset_base'];
$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$title = (string) $args['title'];
$hero_intro = (string) $args['hero_intro'];
$trust_items = is_array($args['trust_items']) ? $args['trust_items'] : [];
$quote_page = home_url('/online-quote/');
$price_url = static fn (string $product): string => $product === '' ? home_url('/online-quote/') : add_query_arg('product', $product, home_url('/online-quote/'));

/* Each answer opens the designer on that product (inc/quote-collections.php).
   Roof lanterns were in the plan's list, but the designer has no roof lantern
   range, so the sixth answer is sash windows, which it does price. */
$price_choices = [
    ['label' => 'Windows', 'copy' => 'uPVC and aluminium', 'product' => 'casement-windows'],
    ['label' => 'Front door', 'copy' => 'Composite, Distinction range', 'product' => 'composite-doors'],
    ['label' => 'Bifold or sliding', 'copy' => 'Aluminium garden doors', 'product' => 'aluminium-bifold-doors'],
    ['label' => 'French or patio', 'copy' => 'uPVC garden doors', 'product' => 'patio-doors'],
    ['label' => 'Sash windows', 'copy' => 'uPVC vertical sliders', 'product' => 'sliding-sash-windows'],
    ['label' => 'Whole house', 'copy' => 'Several at once', 'product' => ''],
];

$trust_messages = [
    ['title' => 'Hundreds of customer reviews', 'copy' => 'Feedback across Google and Trustpilot.', 'item' => $trust_items[0] ?? null],
    ['title' => 'Rated Excellent', 'copy' => 'Independent feedback on Trustpilot.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
    ['title' => 'Insurance-backed protection', 'copy' => 'Supported by the Consumer Protection Association.', 'item' => $trust_items[3] ?? null],
];

/* The quote page's own screenshots of the tool (assets/images/quote-tool/). */
$quote_shots = FENSTER_THEME_URI . '/assets/images/quote-tool/';
$price_steps = [
    ['title' => 'Pick what you are pricing.', 'copy' => 'Windows, doors, sash, bifolds or replacement glass.', 'image' => 'quote-step-1-product.webp', 'alt' => 'The first screen of our quote tool, showing the product ranges to choose from.'],
    ['title' => 'Set the size, style and colour.', 'copy' => 'Rough sizes in millimetres are close enough. The render redraws as you choose.', 'image' => 'quote-step-4-colour.webp', 'alt' => 'The colour step of the quote tool, with the window redrawn in anthracite grey.'],
    ['title' => 'See the price.', 'copy' => 'Add your details and the guide price appears on screen. We check the specification at survey.', 'image' => 'quote-step-6-price.webp', 'alt' => 'The summary screen of the quote tool, listing the configured window before the price.'],
];

/* The classic page's product range, copy unchanged. Only the routes the
   designer can price get "Price this"; the rest keep a single link. */
$product_routes = [
    ['label' => 'Windows', 'url' => home_url('/windows-milton-keynes/'), 'product' => 'casement-windows', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-windows.jpg', 'copy' => 'Compare uPVC, aluminium, flush casement, sash and heritage styles, with help choosing the right warmth, security, colour and sightlines.', 'best_for' => 'Every style of property'],
    ['label' => 'Doors', 'url' => home_url('/doors-milton-keynes/'), 'product' => 'composite-doors', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-composite-door.jpg', 'copy' => 'Explore entrance, French, patio, sliding and bifold doors in one place, from secure front doors to wide garden openings.', 'best_for' => 'Entrances and garden access'],
    ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/'), 'product' => null, 'image' => $asset_base . 'S1-Lantern-Kitchen-A-min-scaled.jpg', 'copy' => 'Bring more natural light into an extension or open-plan room with a slim aluminium roof lantern made around your space.', 'best_for' => 'Extensions and open-plan rooms'],
    ['label' => 'Integral Blinds', 'url' => home_url('/integral-blinds/'), 'product' => null, 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/notan-integral-blinds.jpg', 'copy' => 'Blinds sealed safely between the glass give you clean, low-maintenance control of light and privacy.', 'best_for' => 'Doors and glazed rooms'],
    ['label' => 'Other Services', 'url' => home_url('/other-services/'), 'product' => null, 'image' => $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg', 'copy' => 'Find replacement glass, glazing repairs, cat and dog flaps and the smaller upgrades that complete your home.', 'best_for' => 'Repairs and finishing touches'],
];

$partners = [
    ['label' => 'Sheerline', 'type' => 'Aluminium systems', 'copy' => 'Slim aluminium windows, doors and glazed openings for cleaner sightlines.', 'src' => FENSTER_THEME_URI . '/assets/partners/sheerline.png'],
    ['label' => 'Liniar', 'type' => 'uPVC frames', 'copy' => 'EnergyPlus uPVC window and door systems for everyday home upgrades.', 'src' => FENSTER_THEME_URI . '/assets/partners/liniar-logo.png'],
    ['label' => 'Roseview', 'type' => 'Sliding sash windows', 'copy' => 'Sash-specific systems for heritage-style windows with proper period detail.', 'src' => FENSTER_THEME_URI . '/assets/partners/roseview-logo-new.png'],
    ['label' => 'Distinction Doors', 'type' => 'Composite doors', 'copy' => 'Entrance door slabs and styles for secure, practical kerb appeal.', 'src' => FENSTER_THEME_URI . '/assets/partners/distinction-doors.png'],
];

$studies_fallback = false;
$studies = function_exists('fenster_case_studies_for_product')
    ? fenster_case_studies_for_product('home', 3, 'residential', $studies_fallback)
    : [];

$guides = [
    ['label' => 'Guides and advice', 'url' => home_url('/blog/')],
    ['label' => 'Window and door prices in Milton Keynes', 'url' => home_url('/window-door-prices-milton-keynes/')],
    ['label' => 'What is double glazing and how does it work?', 'url' => home_url('/what-are-double-glazed-glass-windows/')],
    ['label' => 'Try the 3D visualiser', 'url' => home_url('/3d-visualiser/')],
];
?>

<article class="generated-page generated-page--home-lab generated-page--home-next">
    <section class="fg-hn-hero" aria-labelledby="fg-hn-title">
        <div class="container fg-hn-hero__grid">
            <div class="fg-hn-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Fenster Glazing', 'fenster'); ?></p>
                <h1 id="fg-hn-title"><?php echo esc_html($title); ?></h1>
                <?php if ($hero_intro !== '') : ?>
                    <p class="fg-hn-hero__intro"><?php echo esc_html($hero_intro); ?></p>
                <?php endif; ?>

                <h2 class="fg-hn-hero__ask"><?php esc_html_e('What would you like a price for?', 'fenster'); ?></h2>
                <ul class="fg-hn-choices">
                    <?php foreach ($price_choices as $choice) : ?>
                        <li>
                            <a class="fg-hn-choice" href="<?php echo esc_url($price_url($choice['product'])); ?>" data-fg-cta>
                                <strong><?php echo esc_html($choice['label']); ?></strong>
                                <span><?php echo esc_html($choice['copy']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-hn-hero__note"><?php esc_html_e('Choose the product, sizes and colours online, and a guide price appears on screen in about ten minutes.', 'fenster'); ?></p>
                <p class="fg-hn-hero__quiet">
                    <a href="<?php echo esc_url(home_url('/window-and-door-repairs/')); ?>" data-fg-cta><?php esc_html_e('Need a repair?', 'fenster'); ?></a>
                    <a href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>" data-fg-cta><?php esc_html_e('Commercial project?', 'fenster'); ?></a>
                    <a href="tel:<?php echo esc_attr($phone_href); ?>" data-fg-cta><?php echo esc_html(sprintf(__('Rather talk? %s', 'fenster'), $phone)); ?></a>
                    <a href="#fenster-products" data-fg-cta><?php esc_html_e('Explore our products', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-hn-hero__photo">
                <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-windows.jpg', ['alt' => __('Anthracite grey windows fitted by Fenster Glazing to a Milton Keynes home', 'fenster'), 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 900px) 100vw, 44vw']); ?>>
            </figure>
        </div>
    </section>

    <section class="fg-home-proof-wall fg-hn-proof" aria-label="<?php esc_attr_e('Reviews and accreditations', 'fenster'); ?>">
        <div class="container fg-home-proof-wall__grid">
            <?php foreach ($trust_messages as $trust) : ?>
                <?php if (is_array($trust['item'])) : ?>
                    <article class="fg-home-trust-card">
                        <?php if (! empty($trust['item']['url'])) : ?>
                            <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust['item']['url']); ?>"<?php echo fenster_trust_link_attrs($trust['item']); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $trust['item']['alt'])); ?>">
                        <?php endif; ?>
                        <img <?php echo fenster_image_attr_string((string) $trust['item']['src'], ['alt' => (string) $trust['item']['alt'], 'loading' => 'lazy']); ?>>
                        <?php if (! empty($trust['item']['url'])) : ?></a><?php endif; ?>
                        <div>
                            <strong><?php echo esc_html($trust['title']); ?></strong>
                            <span><?php echo esc_html($trust['copy']); ?></span>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="fg-hn-steps" aria-labelledby="fg-hn-steps-title">
        <div class="container">
            <header class="fg-hn-head">
                <p class="eyebrow"><?php esc_html_e('How the price works', 'fenster'); ?></p>
                <h2 id="fg-hn-steps-title"><?php esc_html_e('Three steps to a guide price, in our own quote tool.', 'fenster'); ?></h2>
            </header>
            <ol class="fg-hn-steps__list">
                <?php foreach ($price_steps as $index => $step) : ?>
                    <li>
                        <img <?php echo fenster_image_attr_string($quote_shots . $step['image'], ['alt' => $step['alt'], 'loading' => 'lazy', 'width' => '800', 'height' => '600']); ?>>
                        <span class="fg-hn-steps__num"><?php echo esc_html((string) ($index + 1)); ?></span>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['copy']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
            <p class="fg-hn-steps__cta">
                <a class="button" href="<?php echo esc_url($quote_page); ?>" data-fg-cta><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>" data-fg-cta><?php esc_html_e('Or book a free consultation and we build it with you', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section id="fenster-products" class="fg-hn-products" aria-labelledby="fg-hn-products-title">
        <div class="container">
            <header class="fg-hn-head">
                <p class="eyebrow"><?php esc_html_e('Explore the range', 'fenster'); ?></p>
                <h2 id="fg-hn-products-title"><?php esc_html_e('Find the right fit for your home.', 'fenster'); ?></h2>
            </header>
            <ul class="fg-hn-products__grid">
                <?php foreach ($product_routes as $route) : ?>
                    <li class="fg-hn-product">
                        <img <?php echo fenster_image_attr_string((string) $route['image'], ['alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 700px) 92vw, (max-width: 1100px) 31vw, 240px']); ?>>
                        <span class="fg-hn-product__for"><?php echo esc_html($route['best_for']); ?></span>
                        <h3><?php echo esc_html($route['label']); ?></h3>
                        <p><?php echo esc_html($route['copy']); ?></p>
                        <div class="fg-hn-product__actions">
                            <?php if ($route['product'] !== null) : ?>
                                <a class="button" href="<?php echo esc_url($price_url((string) $route['product'])); ?>" data-fg-cta><?php echo esc_html(sprintf(__('Price %s', 'fenster'), strtolower($route['label']))); ?></a>
                            <?php endif; ?>
                            <a class="fg-hn-product__range" href="<?php echo esc_url($route['url']); ?>" data-fg-cta><?php esc_html_e('See the range', 'fenster'); ?></a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php if ($studies !== []) : ?>
        <section class="fg-cs-strip fg-hn-jobs">
            <div class="container">
                <div class="fg-cs-strip__head">
                    <p class="eyebrow"><?php esc_html_e('Recent jobs', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Homes we have finished recently.', 'fenster'); ?></h2>
                </div>
                <div class="fg-cs-strip__grid">
                    <?php foreach ($studies as $card) : ?>
                        <?php get_template_part('template-parts/components/case-study-card', null, ['card' => $card, 'heading' => 'h3']); ?>
                    <?php endforeach; ?>
                </div>
                <div class="button-row fg-cs-strip__cta">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>" data-fg-cta><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--home',
        'eyebrow' => 'Customer proof',
        'title' => 'Reviewed, accredited and backed by proven product systems.',
        'copy' => 'We combine local installation experience with recognised accreditations and trusted glazing system partners.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-home-partner-strip">
        <div class="container fg-home-partner-strip__inner">
            <div class="fg-home-partner-strip__copy">
                <p class="eyebrow"><?php esc_html_e('Systems and backing', 'fenster'); ?></p>
                <h2><?php esc_html_e('Product systems matched to the job.', 'fenster'); ?></h2>
                <p><?php esc_html_e('We specify recognised window and door systems around the property, budget and finish you want.', 'fenster'); ?></p>
            </div>
            <div class="fg-home-partner-strip__logos">
                <?php foreach ($partners as $partner) : ?>
                    <article class="fg-home-partner-card">
                        <div>
                            <img <?php echo fenster_image_attr_string((string) $partner['src'], ['alt' => (string) $partner['label'], 'loading' => 'lazy']); ?>>
                        </div>
                        <strong class="fg-home-partner-card__name"><?php echo esc_html($partner['label']); ?></strong>
                        <span><?php echo esc_html($partner['type']); ?></span>
                        <p><?php echo esc_html($partner['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-home-showroom" id="fenster-enquiry">
        <div class="container fg-home-showroom__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Not ready for a price?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Talk it through with us instead.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Tell us the product, where the property is and a few details, and we will come back to you to discuss options. Or book a free consultation and we build the quote with you.', 'fenster'); ?></p>
                <div class="fg-home-showroom__links">
                    <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>" data-fg-cta><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                    <a href="tel:<?php echo esc_attr($phone_href); ?>" data-fg-cta><?php echo esc_html($phone); ?></a>
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

    <?php get_template_part('template-parts/components/location-town-links', null, ['product' => 'double-glazing']); ?>

    <nav class="fg-hn-guides" aria-label="<?php esc_attr_e('Guides', 'fenster'); ?>">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e('Guides', 'fenster'); ?></p>
            <ul>
                <?php foreach ($guides as $guide) : ?>
                    <li><a href="<?php echo esc_url($guide['url']); ?>"><?php echo esc_html($guide['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</article>
