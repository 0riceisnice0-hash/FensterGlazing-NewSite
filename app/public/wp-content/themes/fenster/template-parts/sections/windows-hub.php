<?php
/**
 * Dedicated window-category hub for /windows-milton-keynes/.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'asset_base' => '/wp-content/themes/fenster/assets/images/imported/',
    'brand' => [],
    'instant_quote_preview' => '',
    'page' => [],
    'related_links' => [],
    'selector_type' => 'windows',
    'title' => 'Double Glazed Windows',
    'trust_items' => [],
]);

$asset_base = (string) $args['asset_base'];
$brand = is_array($args['brand']) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$instant_quote_preview = (string) $args['instant_quote_preview'];
$related_links = is_array($args['related_links']) ? $args['related_links'] : [];
$selector_type = (string) $args['selector_type'];
$trust_items = is_array($args['trust_items']) ? $args['trust_items'] : [];
$is_doors = $selector_type === 'doors';

$window_types = [
    [
        'name' => 'Casement Windows',
        'short' => 'Casement',
        'url' => home_url('/casement-windows/'),
        'image' => $asset_base . 'Casement_03.jpg',
        'fit' => 'The versatile all-rounder',
        'copy' => 'A practical choice for most homes, with flexible opening layouts, strong security and a broad range of colours and finishes.',
        'features' => ['uPVC frames', 'Flexible openings', 'Excellent value'],
    ],
    [
        'name' => 'Flush Casement Windows',
        'short' => 'Flush Casement',
        'url' => home_url('/flush-casement-windows/'),
        'image' => $asset_base . 'Flush_Sash_001.jpg',
        'fit' => 'Clean, understated sightlines',
        'copy' => 'The opening sash sits level with the outer frame for a calmer, more refined finish that works on modern and traditional properties.',
        'features' => ['Flush exterior', 'Timber-inspired look', 'Modern performance'],
    ],
    [
        'name' => 'Sliding Sash Windows',
        'short' => 'Sliding Sash',
        'url' => home_url('/sliding-sash-windows/'),
        'image' => $asset_base . 'Sliding-Sash-Windows-Flitwick-3.jpg',
        'fit' => 'Traditional character',
        'copy' => 'Vertical sliding proportions recreate the appearance of classic timber sash windows with modern security, warmth and easier maintenance.',
        'features' => ['Vertical opening', 'Period detailing', 'Low maintenance'],
    ],
    [
        'name' => 'French Casement Windows',
        'short' => 'French Casement',
        'url' => home_url('/french-casement-windows/'),
        'image' => $asset_base . 'Aylesbury-French-Casement-Windows.jpg',
        'fit' => 'A wider clear opening',
        'copy' => 'Both leaves open without a fixed central bar, creating a generous unobstructed opening for ventilation, access and an open outlook.',
        'features' => ['No fixed mullion', 'Wide opening', 'Flexible ventilation'],
    ],
    [
        'name' => 'Tilt & Turn Windows',
        'short' => 'Tilt & Turn',
        'url' => home_url('/tilt-turn-windows/'),
        'image' => $asset_base . 'Window_23.jpg',
        'fit' => 'Ventilation and easy cleaning',
        'copy' => 'Tilt inward for secure everyday airflow or open fully into the room, making upper floors and hard-to-reach glazing easier to maintain.',
        'features' => ['Dual opening', 'Secure ventilation', 'Easy cleaning'],
    ],
    [
        'name' => 'Bow & Bay Windows',
        'short' => 'Bow & Bay',
        'url' => home_url('/bow-bay-windows/'),
        'image' => $asset_base . 'bay-window.jpg',
        'fit' => 'More space and a wider outlook',
        'copy' => 'Projecting window arrangements add depth, daylight and architectural presence while creating a brighter feature inside the room.',
        'features' => ['More natural light', 'Extra interior depth', 'Strong kerb appeal'],
    ],
    [
        'name' => 'Aluminium Windows',
        'short' => 'Aluminium',
        'url' => home_url('/aluminium-windows/'),
        'image' => $asset_base . 'Aluminium-Windows-16.jpg',
        'fit' => 'Slim frames and larger glass',
        'copy' => 'Strong, thermally broken aluminium supports narrow sightlines and larger panes for contemporary homes, extensions and architectural glazing.',
        'features' => ['Slim sightlines', 'Larger panes', 'Durable powder coating'],
    ],
    [
        'name' => 'Aluminium Flush Windows',
        'short' => 'Aluminium Flush',
        'url' => home_url('/aluminium-flush-windows/'),
        'image' => $asset_base . 'Flush_8-copy.jpg',
        'fit' => 'Flush lines in a slim aluminium frame',
        'copy' => 'A flush aluminium sash creates a clean, level exterior with durable powder-coated finishes and strong modern thermal performance.',
        'features' => ['Flush exterior', '80mm outer frame', 'Any RAL colour'],
    ],
    [
        'name' => 'Heritage Windows',
        'short' => 'Heritage',
        'url' => home_url('/heritage-windows/'),
        'image' => $asset_base . 'C08-Classic-Windows-Heritage-Style-Anthracite-2048x1366-1.jpg',
        'fit' => 'Steel-look proportions',
        'copy' => 'Fine aluminium profiles and heritage-style detailing give period renovations and industrial-inspired spaces an elegant steel-look finish.',
        'features' => ['Steel-look design', 'Fine profiles', 'Period-sensitive style'],
    ],
];

if ($is_doors) {
    $window_types = [
        ['name' => 'Aluminium Doors', 'short' => 'Aluminium', 'url' => home_url('/aluminium-doors/'), 'image' => $asset_base . 'Prestige-aluminium-door-in-stone-web.webp', 'fit' => 'Slim, strong entrance doors', 'copy' => 'Contemporary aluminium entrance doors combine crisp lines, robust construction and durable colour finishes.', 'features' => ['Slim aluminium frame', 'High security', 'Contemporary finishes']],
        ['name' => 'Heritage Aluminium Doors', 'short' => 'Heritage', 'url' => home_url('/heritage-aluminium-doors/'), 'image' => $asset_base . 'Sheerline-Heritage-Doors.jpg', 'fit' => 'Steel-look character', 'copy' => 'Ultra-slim aluminium profiles and period-inspired glazing details bring classic steel-door proportions to modern performance.', 'features' => ['Classic aesthetic', 'Ultra-slim sightlines', 'Any RAL colour']],
        ['name' => 'Aluminium Bifold Doors', 'short' => 'Bifold', 'url' => home_url('/aluminium-bifold-doors/'), 'image' => $asset_base . 'Bifold-550-GardenView-v1.webp', 'fit' => 'Open the room to the garden', 'copy' => 'Multiple folding panels create a wide opening for kitchens, extensions and garden rooms, with configurations planned around your space.', 'features' => ['Wide openings', 'Slim panels', 'Flexible layouts']],
        ['name' => 'Slide & Fold Doors', 'short' => 'Slide & Fold', 'url' => home_url('/slide-fold-doors/'), 'image' => $asset_base . 'Slide-Fold.png', 'fit' => 'Flexible partial or full opening', 'copy' => 'Panels slide independently and fold back when required, giving you more control over ventilation, access and the size of the opening.', 'features' => ['Versatile opening', '10 point locking', 'Any RAL colour']],
        ['name' => 'Aluminium Sliding Doors', 'short' => 'Aluminium Sliding', 'url' => home_url('/aluminium-sliding-doors/'), 'image' => $asset_base . 'steel-look-patio-hero.webp', 'fit' => 'Large glass with slim aluminium lines', 'copy' => 'Dual or triple-track aluminium sliders create broad glazed views with smooth operation and secure flush hook-locks.', 'features' => ['Dual or triple track', 'Slim sightlines', 'Flush hook-locks']],
        ['name' => 'Composite Doors', 'short' => 'Composite', 'url' => home_url('/composite-doors/'), 'image' => $asset_base . 'composite-door.jpeg', 'fit' => 'Secure front-door character', 'copy' => 'A substantial entrance door with strong insulation, reassuring security and a broad choice of styles, colours and decorative glass.', 'features' => ['Strong insulation', 'Secure construction', 'Extensive design choice']],
        ['name' => 'French Doors', 'short' => 'French', 'url' => home_url('/french-doors/'), 'image' => $asset_base . 'French_Door_02.jpg', 'fit' => 'A balanced double-door opening', 'copy' => 'A classic pair of glazed doors creates an elegant connection to patios and gardens, with flexible colours and glazing details.', 'features' => ['Double opening', 'Traditional proportions', 'Bright garden access']],
        ['name' => 'Patio Doors', 'short' => 'Patio', 'url' => home_url('/patio-doors/'), 'image' => $asset_base . '7016_grey_patio-new_build_cladded_house_9.jpg', 'fit' => 'Glazing without opening into the room', 'copy' => 'Sliding panels provide generous glass area and practical garden access where space around the doorway needs to stay clear.', 'features' => ['Sliding opening', 'Large glazed area', 'Space-efficient']],
        ['name' => 'uPVC Doors', 'short' => 'uPVC', 'url' => home_url('/upvc-doors/'), 'image' => $asset_base . 'Residential_Door_01.jpg', 'fit' => 'Practical, adaptable and affordable', 'copy' => 'Made-to-measure uPVC doors offer dependable warmth and security with a wide range of colours, panels and glass options.', 'features' => ['Excellent value', 'Low maintenance', 'Flexible styles']],
    ];
}

$page_eyebrow = $is_doors ? 'Doors in Milton Keynes' : 'Windows in Milton Keynes';
$page_heading = $is_doors ? 'Doors in Milton Keynes' : 'Double glazed windows in Milton Keynes';
$page_intro = $is_doors
    ? 'Compare front, bifold, French, patio and sliding door options, then plan the material, glass, threshold and fitting details with Fenster.'
    : 'Compare uPVC, aluminium, flush, sash and heritage window options, then plan survey-led installation with Fenster.';
$selector_heading = $is_doors
    ? 'Start with where the door leads and how you want it to open.'
    : 'Start with the way you want the window to look and open.';
$selector_label = $is_doors ? 'Door types' : 'Window types';
$product_singular = $is_doors ? 'door' : 'window';
$guide_heading = $is_doors
    ? 'Start with the opening. We will help with the specification.'
    : 'Start with the style. We will help with the specification.';
$quote_heading = $is_doors
    ? 'Build a door online, then let Fenster check the details.'
    : 'Build a window online, then let Fenster check the details.';
$guide_intro = $is_doors
    ? 'Tell Fenster where the door leads, how much glass you want and how you would like it to open. We will confirm the material, security, threshold and configuration.'
    : 'Tell Fenster what you like, what you want to improve and how the room is used. The survey and design process will confirm the right frame, glazing, hardware and configuration.';
$guide_steps = $is_doors
    ? [
        ['title' => 'Choose the purpose', 'copy' => 'Front entrance, garden access or a wide opening for an extension.'],
        ['title' => 'Choose how it opens', 'copy' => 'Hinged, folding or sliding around the space available.'],
        ['title' => 'Fenster specifies the detail', 'copy' => 'Material, glass, colour, security and threshold are checked around your property.'],
    ]
    : [
        ['title' => 'Choose the character', 'copy' => 'Modern, traditional, slim, flush or feature-led.'],
        ['title' => 'Choose how it opens', 'copy' => 'Everyday ventilation, a wide opening or easy inward cleaning.'],
        ['title' => 'Fenster specifies the detail', 'copy' => 'Material, glass, colour, security and installation are checked around your property.'],
    ];

?>

<article class="fg-window-hub fg-window-hub--<?php echo esc_attr($selector_type); ?>">
    <section class="fg-window-selector" id="compare-windows" data-fg-window-selector>
        <div class="container">
            <header class="fg-window-selector__head">
                <div>
                    <p class="eyebrow"><?php echo esc_html($page_eyebrow); ?></p>
                    <h1><?php echo esc_html($page_heading); ?></h1>
                    <p><?php echo esc_html($page_intro); ?></p>
                </div>
                <div>
                    <h2><?php echo esc_html($selector_heading); ?></h2>
                    <a href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                </div>
            </header>

            <div class="fg-window-selector__desktop">
                <div
                    class="fg-window-selector__list"
                    role="tablist"
                    aria-label="<?php echo esc_attr($selector_label); ?>"
                    style="--fg-selector-count: <?php echo esc_attr((string) count($window_types)); ?>;">
                    <?php foreach ($window_types as $index => $type) : ?>
                        <button
                            type="button"
                            role="tab"
                            class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                            aria-selected="<?php echo esc_attr($index === 0 ? 'true' : 'false'); ?>"
                            data-window-url="<?php echo esc_url($type['url']); ?>"
                            data-fg-window-option="<?php echo esc_attr((string) $index); ?>">
                            <strong><?php echo esc_html($type['short']); ?></strong>
                            <small><?php echo esc_html($type['fit']); ?></small>
                        </button>
                    <?php endforeach; ?>
                </div>

                <a class="fg-window-selector__preview" href="<?php echo esc_url($window_types[0]['url']); ?>" data-fg-window-preview>
                    <div class="fg-window-selector__media">
                        <?php foreach ($window_types as $index => $type) : ?>
                            <img
                                class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                                src="<?php echo esc_url(fenster_generated_url($type['image'])); ?>"
                                alt=""
                                loading="eager"
                                decoding="async"
                                data-fg-window-image="<?php echo esc_attr((string) $index); ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="fg-window-selector__detail">
                        <?php foreach ($window_types as $index => $type) : ?>
                            <article class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>" data-fg-window-detail="<?php echo esc_attr((string) $index); ?>">
                                <span><?php echo esc_html($type['fit']); ?></span>
                                <h3><?php echo esc_html($type['name']); ?></h3>
                                <p><?php echo esc_html($type['copy']); ?></p>
                                <ul>
                                    <?php foreach ($type['features'] as $feature) : ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <strong><?php echo esc_html('Explore ' . $type['name']); ?></strong>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </a>
            </div>

            <div class="fg-window-selector__mobile">
                <?php foreach ($window_types as $type) : ?>
                    <a href="<?php echo esc_url($type['url']); ?>">
                        <img src="<?php echo esc_url(fenster_generated_url($type['image'])); ?>" alt="" loading="lazy">
                        <div>
                            <span><?php echo esc_html($type['fit']); ?></span>
                            <strong><?php echo esc_html($type['name']); ?></strong>
                            <p><?php echo esc_html($type['copy']); ?></p>
                            <small><?php echo esc_html('View ' . $product_singular); ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-window-hub__guide">
        <div class="container fg-window-hub__guide-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('A simpler decision', 'fenster'); ?></p>
                <h2><?php echo esc_html($guide_heading); ?></h2>
                <p><?php echo esc_html($guide_intro); ?></p>
            </div>
            <ul>
                <?php foreach ($guide_steps as $step) : ?>
                    <li>
                        <div><strong><?php echo esc_html($step['title']); ?></strong><p><?php echo esc_html($step['copy']); ?></p></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="fg-window-hub__quote">
        <div class="container fg-window-hub__quote-grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('See a starting price', 'fenster'); ?></p>
                <h2><?php echo esc_html($quote_heading); ?></h2>
                <p><?php esc_html_e('Use the instant quote tool to choose a style, colour and approximate size. Your final specification is confirmed after survey.', 'fenster'); ?></p>
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
            </div>
            <a href="<?php echo esc_url(home_url('/online-quote/')); ?>">
                <img src="<?php echo esc_url($instant_quote_preview); ?>" alt="<?php echo esc_attr('Fenster instant ' . $product_singular . ' quote interface'); ?>" loading="lazy">
            </a>
        </div>
    </section>

    <section class="fg-window-hub__contact">
        <div class="container">
            <div>
                <p class="eyebrow"><?php esc_html_e('Prefer to talk?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Describe the home and the look you have in mind.', 'fenster'); ?></h2>
            </div>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php echo esc_html('Request a ' . $product_singular . ' quote'); ?></a>
                <a class="button button--outline" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--windows-hub',
            'eyebrow' => 'Customer proof',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>
</article>
