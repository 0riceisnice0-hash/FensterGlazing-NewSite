<?php
/**
 * Generated scrape-backed page with polished product/commercial layouts.
 *
 * @package Fenster
 */

$page = get_query_var('fenster_generated_page');

if (! is_array($page)) {
    return;
}

$slug = (string) ($page['slug'] ?? '');
$title = (string) ($page['title'] ?? 'Fenster Glazing');
$sections = $page['sections'] ?? [];
$images = $page['images'] ?? [];
$links = $page['links'] ?? [];
$hero_image = $page['hero_image'] ?? null;
$bad_scrape_patterns = [
    '/registered you will be taken to our custom design software/i',
    '/online designer tool/i',
    '/visualise your design/i',
    '/3d rendering/i',
    '/unique door to suit your home style/i',
    '/stay updated with us/i',
    '/social media channels/i',
    '/the best windows milton keynes/i',
    '/commercial glazing: high-quality/i',
    '/2026 giveaway/i',
    '/showroom 97-98/i',
    '/^frequently asked questions\b/i',
    '/\bbrochure\b/i',
    '/^get in touch$/i',
    '/^use our quoting engine$/i',
    '/^related products$/i',
    '/^(bedfordshire|northamptonshire|hertfordshire)$/i',
    '/\bdoor designer\b/i',
    '/\bwindowcad\b/i',
];
$is_bad_scrape_section = static function ($section) use ($bad_scrape_patterns): bool {
    $text = strtolower((string) ($section['heading'] ?? '') . ' ' . implode(' ', $section['body'] ?? []));
    $heading = trim((string) ($section['heading'] ?? ''));
    $body_lines = array_values(array_filter(array_map(static fn ($line): string => trim((string) $line), $section['body'] ?? [])));
    $first_body = $body_lines[0] ?? '';

    foreach ($bad_scrape_patterns as $pattern) {
        if (preg_match($pattern, $text)) {
            return true;
        }
    }

    if ($first_body !== '') {
        if (preg_match('/^[,.;:]/', $first_body)) {
            return true;
        }

        if (strlen($first_body) < 35) {
            return true;
        }

        if (preg_match('/\b(?:from|by|with|the|a|an|and|or|to|for|of|our|your)$/i', $first_body)) {
            return true;
        }
    }

    if ($heading !== '' && $first_body === '' && strlen($heading) < 35) {
        return true;
    }

    return false;
};
$is_valid_generated_image = static function ($image): bool {
    $src = (string) ($image['src'] ?? '');

    if ($src === '') {
        return false;
    }

    $path = strtolower((string) (wp_parse_url($src, PHP_URL_PATH) ?? ''));

    if (! preg_match('/\.(avif|gif|jpe?g|png|webp)$/i', $path)) {
        return false;
    }

    if (str_contains($path, '/assets/other/')) {
        return false;
    }

    $filename = strtolower((string) basename($path));
    $blocked_image_names = [
        'placeholder',
        'stock-',
        'shutterstock',
        'pexels',
        'unsplash',
        'istock',
    ];

    foreach ($blocked_image_names as $blocked_image_name) {
        if (str_contains($filename, $blocked_image_name)) {
            return false;
        }
    }

    $local_path = '';
    if (str_starts_with($path, '/app/uploads/')) {
        $local_path = ABSPATH . 'wp-content/uploads/' . substr($path, strlen('/app/uploads/'));
    } elseif (str_starts_with($path, '/wp-content/uploads/')) {
        $local_path = ABSPATH . ltrim($path, '/');
    } elseif (str_starts_with($path, '/wp-content/')) {
        $local_path = ABSPATH . ltrim($path, '/');
    }

    return $local_path === '' || file_exists($local_path);
};
$sections = array_values(array_filter(is_array($sections) ? $sections : [], static fn ($section): bool => ! $is_bad_scrape_section($section)));
$hero_image = is_array($hero_image) && $is_valid_generated_image($hero_image) ? $hero_image : null;
$images = array_values(array_filter(is_array($images) ? $images : [], $is_valid_generated_image));
$content_sections = count($sections) > 1 ? array_slice($sections, 1) : $sections;
$designer_sections = array_values(array_filter($content_sections, static function ($section): bool {
    $heading = strtolower((string) ($section['heading'] ?? ''));
    return str_contains($heading, '3d designer') || str_contains($heading, 'unique door');
}));
$scroll_story_sections = [];
if ($slug === 'aluminium-bifold-doors') {
    $scroll_story_sections = array_values(array_filter($content_sections, static function ($section): bool {
        $heading = strtolower((string) ($section['heading'] ?? ''));
        return ! str_contains($heading, '3d designer') && ! str_contains($heading, 'unique door');
    }));
}
$feature_sections = $slug === 'aluminium-bifold-doors'
    ? []
    : array_slice(array_values(array_filter($content_sections, static function ($section): bool {
        $heading = strtolower((string) ($section['heading'] ?? ''));
        return ! str_contains($heading, '3d designer') && ! str_contains($heading, 'unique door');
    })), 0, 8);
$detail_sections = $slug === 'aluminium-bifold-doors' ? [] : array_slice($content_sections, 8);
$feature_images = array_slice($images, is_array($hero_image) ? 1 : 0, 8);
$gallery_images = array_slice($images, is_array($hero_image) ? 1 : 0);
$product_why_image = $gallery_images[0] ?? (is_array($hero_image) ? $hero_image : null);
$sick_video = FENSTER_THEME_URI . '/assets/videos/home/fenster-home-hero.mp4';
$brand = fenster_data('brand', []);
$is_bifold = $slug === 'aluminium-bifold-doors';
$is_aluminium_windows = $slug === 'aluminium-windows';
$is_integral_blinds = $slug === 'integral-blinds';
$is_home = $slug === 'home';
$is_case_study = in_array($slug, ['case-studies', 'commercial-projects'], true) || str_starts_with($slug, 'case-studies/');
$is_team = $slug === 'meet-the-team';
$is_obscure_glass = $slug === 'obscured-glass';
$is_colour_options = in_array($slug, ['colour-options', 'upvc-colours', 'aluminium-colours'], true);
$is_trust_page = $slug === 'why-trust-fenster';
$is_about_page = $slug === 'about';
$is_about = in_array($slug, ['about', 'meet-the-team'], true);
$is_contact = $slug === 'contact';
$is_windows_hub = $slug === 'windows-milton-keynes';
$is_doors_hub = $slug === 'doors-milton-keynes';
$is_product_selector_hub = $is_windows_hub || $is_doors_hub;
$is_commercial_hub = $slug === 'commercial-glazing';
$commercial_county_pages = function_exists('fenster_commercial_county_pages') ? fenster_commercial_county_pages() : [];
$is_commercial_county = isset($commercial_county_pages[$slug]);
$is_commercial_areas = $slug === 'commercial-areas';
$commercial_route_slugs = [
    'commercial-glazing',
    'commercial-windows-and-doors',
    'curtain-walling',
    'louvre-vents',
    'commercial-automation',
    'commercial-projects',
    'healthcare-construction',
];
$is_commercial = in_array($slug, $commercial_route_slugs, true) || str_starts_with($slug, 'commercial-glazing-');
$is_quote_tool = in_array($slug, ['online-quote', '3d-visualiser', 'instant-pricing', 'instant-pricing-meta-ads', 'pricing-gads', 'design-your-windows-and-doors', 'door-designer'], true);
$is_archive_page = $slug === 'blog' || str_starts_with($slug, 'blog/page/') || str_starts_with($slug, 'category/') || str_starts_with($slug, 'tag/') || str_starts_with($slug, 'author/');
$is_utility_page = in_array($slug, ['privacy-policy', 'cookie-policy', 'terms-conditions', 'why-trust-fenster', 'brochures', 'downloads', 'gallery', 'customer-portal', 'careers', 'refer-a-friend', 'fenster-partners', 'videos', 'apecs-terms-conditions', 'other-services'], true);
$location_matrix_towns = function_exists('fenster_location_matrix_towns') ? fenster_location_matrix_towns() : [];
$location_matrix_products = function_exists('fenster_location_matrix_products') ? fenster_location_matrix_products() : [];
$is_location_service = function_exists('fenster_location_matrix_page') && is_array(fenster_location_matrix_page($slug));
$product_route_slugs = array_merge(
    array_keys($location_matrix_products),
    [
        'double-glazing',
        'double-glazing-replacement',
        'secondary-glazing',
        'window-and-door-repairs',
        'cat-and-dog-flaps',
        'roofline',
        'windows-milton-keynes',
        'doors-milton-keynes',
    ]
);
$is_product = ! $is_quote_tool && (
    $is_commercial
    || in_array($slug, $product_route_slugs, true)
    || str_starts_with($slug, 'double-glazing-')
    || $is_location_service
);
$is_door_product = $is_product && (str_contains($slug, 'door') || str_contains($slug, 'bifold') || str_contains($slug, 'patio') || $slug === 'slide-fold-doors');
$use_product_journey = $is_product && ! $is_home && ! $is_case_study && ! $is_team && ! $is_about_page && ! $is_contact && ! $is_product_selector_hub && ! $is_commercial_hub && ! $is_commercial_county && ! $is_location_service && ! $is_colour_options;
$product_usps = fenster_data('product_usps.' . $slug, []);
$product_usps = is_array($product_usps) ? array_slice($product_usps, 0, 4) : [];
$product_content = fenster_data('product_content.' . $slug, []);
$product_content = is_array($product_content) ? $product_content : [];
$product_media = fenster_data('product_media.' . $slug, []);
$product_media = is_array($product_media) ? $product_media : [];
$sash_furniture = fenster_data('sash_furniture', []);
$sash_furniture = is_array($sash_furniture) ? $sash_furniture : [];
$sash_furniture_slugs = $sash_furniture['slugs'] ?? [];
$show_sash_furniture = $use_product_journey && is_array($sash_furniture_slugs) && in_array($slug, $sash_furniture_slugs, true);
$sash_furniture_ranges = $sash_furniture['ranges'] ?? [];
$sash_furniture_ranges = is_array($sash_furniture_ranges) ? array_values($sash_furniture_ranges) : [];
$window_handles = fenster_data('window_handles', []);
$window_handles = is_array($window_handles) ? $window_handles : [];
$window_handle_slugs = $window_handles['slugs'] ?? [];
$show_window_handles = $use_product_journey && is_array($window_handle_slugs) && in_array($slug, $window_handle_slugs, true);
$window_handle_finishes = $window_handles['finishes'] ?? [];
$window_handle_finishes = is_array($window_handle_finishes) ? array_values($window_handle_finishes) : [];
$door_handles = fenster_data('door_handles', []);
$door_handles = is_array($door_handles) ? $door_handles : [];
$door_handle_slugs = $door_handles['slugs'] ?? [];
$show_door_handles = $use_product_journey && $is_door_product && is_array($door_handle_slugs) && in_array($slug, $door_handle_slugs, true);
$door_handle_finishes = $door_handles['finishes'] ?? [];
$door_handle_finishes = is_array($door_handle_finishes) ? array_values($door_handle_finishes) : [];
$obscure_glass = fenster_data('obscure_glass', []);
$obscure_glass = is_array($obscure_glass) ? $obscure_glass : [];
$obscure_glass_textures = $obscure_glass['textures'] ?? [];
$obscure_glass_textures = is_array($obscure_glass_textures) ? array_values(array_filter($obscure_glass_textures, static function ($texture): bool {
    return trim((string) ($texture['name'] ?? '')) !== '' && (trim((string) ($texture['image'] ?? '')) !== '' || trim((string) ($texture['texture'] ?? '')) !== '');
})) : [];
$obscure_glass_first = $obscure_glass_textures[0] ?? null;
$colour_options = fenster_data('colour_options', []);
$colour_options = is_array($colour_options) ? $colour_options : [];
$colour_materials = $colour_options['materials'] ?? [];
$colour_materials = is_array($colour_materials) ? $colour_materials : [];
$product_scroll_video_src = fenster_product_scroll_video_for_slug($slug);
$product_scroll_video_sources = fenster_product_scroll_video_sources_for_slug($slug);
$sash_roseview_models = [];
$sash_roseview_details = [];
$sash_roseview_feature_cards = [];
if ($slug === 'sliding-sash-windows') {
    $sash_asset_base = '/wp-content/themes/fenster/assets/images/products/sash-roseview/';
    $sash_roseview_models = [
        [
            'name' => 'Ultimate Rose',
            'tagline' => 'Closest to timber',
            'image' => $sash_asset_base . 'ultimate-rose-window-external.png',
            'alt' => 'Ultimate Rose sash window viewed externally',
            'copy' => 'The premium choice when the window needs to look genuinely traditional up close, with the finest meeting rail and the most authentic joint detailing in the Rose Collection.',
            'best_for' => 'Conservation-led projects, high-detail period homes and front elevations where authenticity matters most.',
            'specs' => [
                ['label' => 'Meeting rail', 'value' => '35mm'],
                ['label' => 'Corner detail', 'value' => 'Mechanical joints'],
                ['label' => 'Bottom rail', 'value' => '81mm deep rail'],
                ['label' => 'Glazing', 'value' => '28mm IGUs'],
            ],
        ],
        [
            'name' => 'Heritage Rose',
            'tagline' => 'Traditional all-rounder',
            'image' => $sash_asset_base . 'heritage-rose-window.png',
            'alt' => 'Heritage Rose sash window viewed externally',
            'copy' => 'A strong traditional sash specification with slim sightlines, putty-line detailing and welded frame construction for homeowners who want period character without stepping to the highest-detail model.',
            'best_for' => 'Traditional homes, Victorian or Edwardian styling and projects where a convincing timber-style appearance is needed.',
            'specs' => [
                ['label' => 'Meeting rail', 'value' => '44.5mm'],
                ['label' => 'Corner detail', 'value' => 'Welded joints'],
                ['label' => 'Bottom rail', 'value' => '81mm deep rail'],
                ['label' => 'Glazing', 'value' => '28mm IGUs'],
            ],
        ],
        [
            'name' => 'Charisma Rose',
            'tagline' => 'Cost-conscious sash style',
            'image' => $sash_asset_base . 'charisma-rose-window.png',
            'alt' => 'Charisma Rose sash window viewed externally',
            'copy' => 'The accessible Rose Collection route: still a proper vertical sliding sash window, but with a simpler sculptured profile and wider rail for projects balancing appearance and budget.',
            'best_for' => 'Modern replacements, rental refurbishments and homes where sash operation matters more than maximum timber replication.',
            'specs' => [
                ['label' => 'Meeting rail', 'value' => '60mm'],
                ['label' => 'Corner detail', 'value' => 'Welded joints'],
                ['label' => 'Bottom rail', 'value' => '68mm standard'],
                ['label' => 'Glazing', 'value' => '24mm IGUs'],
            ],
        ],
    ];
    $sash_roseview_details = [
        [
            'eyebrow' => 'Sightline comparison',
            'title' => 'The meeting rail changes the whole feel of the sash.',
            'copy' => 'A slimmer central rail lets the two sliding sashes read more like traditional timber. Ultimate Rose is the finest at 35mm, Heritage Rose sits at 44.5mm, and Charisma Rose keeps a broader 60mm rail for a simpler, more cost-conscious specification.',
            'image' => $sash_asset_base . 'ultimate-35mm-meeting-rail.jpg',
            'alt' => 'Close-up of an Ultimate Rose 35mm meeting rail',
            'points' => ['35mm Ultimate Rose', '44.5mm Heritage Rose', '60mm Charisma Rose'],
        ],
        [
            'eyebrow' => 'Corner construction',
            'title' => 'Mechanical or welded joints, chosen around the level of authenticity required.',
            'copy' => 'Ultimate Rose uses mechanical joints to mimic timber butt-joint construction. Heritage and Charisma use welded joints, giving robust modern uPVC performance while keeping the sash styling clean.',
            'image' => $sash_asset_base . 'ultimate-mechanical-joints.jpg',
            'alt' => 'Close-up of Ultimate Rose mechanical joint detail',
            'points' => [
                'Ultimate Rose: visible butt-joint style detail for the closest timber replication.',
                'Heritage Rose: welded construction with a slimmer traditional sash appearance.',
                'Charisma Rose: welded construction for a simpler, cost-conscious sash specification.',
                'Fenster checks the right construction level against the elevation, budget and survey detail.',
            ],
        ],
    ];
    $sash_roseview_feature_cards = [
        [
            'title' => 'Tilt-in cleaning',
            'copy' => 'Modern sliding sashes can tilt inward so upstairs exterior glass is easier to clean safely from inside the room.',
        ],
        [
            'title' => 'Colour and hardware',
            'copy' => 'Foils, RAL colours, fasteners, lifts and knobs are specified together so the sash feels deliberate inside and out.',
        ],
        [
            'title' => 'Ventilation details',
            'copy' => 'Trickle vent routes, concealed options and frame details are checked at survey so compliance does not ruin the elevation.',
        ],
    ];
}
$integral_blinds_reveal_video = $is_integral_blinds ? fenster_integral_blinds_reveal_url() : '';
$aluminium_windows_story_poster = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('website-header-specifiers-poster.jpg') : '';
$aluminium_windows_story_desktop_frames = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('frames-desktop/frame-001.webp') : '';
$aluminium_windows_story_mobile_frames = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('frames-mobile/frame-001.webp') : '';
$aluminium_windows_story_panels = [
    [
        'eyebrow' => 'Slim aluminium frames',
        'heading' => 'More glass. Less frame.',
        'copy' => 'Crisp, narrow sightlines bring more daylight into the room and keep the view feeling open.',
    ],
    [
        'eyebrow' => 'Built for British weather',
        'heading' => 'Comfort through every season.',
        'copy' => 'Thermally broken aluminium frames and high-performance glazing help retain warmth and reduce draughts.',
    ],
    [
        'eyebrow' => 'Security as standard',
        'heading' => 'Strong where it matters.',
        'copy' => 'Robust aluminium construction and multi-point locking give every opening a reassuring, secure finish.',
    ],
    [
        'eyebrow' => 'Made for your home',
        'heading' => 'Your colour. Your configuration.',
        'copy' => 'Choose the opening style, frame finish and glazing details that suit the architecture around them.',
    ],
    [
        'eyebrow' => 'Fenster installation',
        'heading' => 'Measured, fitted and guaranteed.',
        'copy' => 'Every window is surveyed and installed by our team, with a 10-year insurance-backed guarantee.',
    ],
];
$team_page = $slug === 'about' ? fenster_get_generated_page('meet-the-team') : null;
$team_cards = [];
if (is_array($team_page)) {
    foreach (($team_page['sections'] ?? []) as $index => $team_section) {
        $heading = trim((string) ($team_section['heading'] ?? ''));
        $body = array_values(array_filter(array_map('trim', $team_section['body'] ?? [])));
        $role = $body[0] ?? '';

        if ($index < 2 || $heading === '' || $role === '' || strtolower($role) === 'office companion') {
            continue;
        }

        $team_cards[] = [
            'name' => $heading,
            'role' => $role,
            'copy' => $body[1] ?? '',
            'image' => $team_page['images'][$index - 2]['src'] ?? '',
            'alt' => $team_page['images'][$index - 2]['alt'] ?? $heading,
        ];
    }
}
$hero_intro = '';
$seo_intro = (string) ($page['seo']['meta_description'] ?? '');
$bad_intro_patterns = $bad_scrape_patterns;

foreach ($sections as $section) {
    foreach (($section['body'] ?? []) as $line) {
        $is_bad_intro = false;
        foreach ($bad_intro_patterns as $pattern) {
            if (preg_match($pattern, $line)) {
                $is_bad_intro = true;
                break;
            }
        }

        if (! $is_bad_intro && strlen($line) > 70) {
            $hero_intro = $line;
            break 2;
        }
    }
}

if ($slug === 'home') {
    $hero_intro = 'High-quality windows, doors, bifolds and glazing systems installed across Milton Keynes, Buckinghamshire, Bedfordshire and the surrounding areas.';
} elseif ($seo_intro !== '' && $hero_intro === '') {
    $hero_intro = $seo_intro;
}

if ($hero_intro === '') {
    $hero_intro = $is_commercial
        ? 'Specification-led glazing systems for demanding commercial environments, built around clarity, performance and dependable delivery.'
        : 'High-performance glazing, windows and doors designed around your home, your project and the way you want to live.';
}

if (! empty($product_content['intro'])) {
    $hero_intro = (string) $product_content['intro'];
}

$stats = $is_commercial
    ? [
        ['value' => 'Nationwide', 'label' => 'commercial delivery'],
        ['value' => 'Part L', 'label' => 'performance-led specification'],
        ['value' => 'In-house', 'label' => 'technical project support'],
    ]
    : [
        ['value' => '10 year', 'label' => 'insurance-backed guarantee'],
        ['value' => '1,000+', 'label' => 'installations completed'],
        ['value' => '200+', 'label' => 'five-star reviews'],
    ];

$cta_label = $is_commercial ? 'Discuss a commercial project' : 'Start your design consultation';
$instant_quote_url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing';
$instant_quote_preview = FENSTER_THEME_URI . '/assets/quote/instant-quote-screenshot.png';
$product_quote_embeds = [
    'composite-doors' => ['label' => 'Composite Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=4'],
    'casement-windows' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'flush-casement-windows' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'tilt-turn-windows' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'french-casement-windows' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'bow-bay-windows' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'double-glazing' => ['label' => 'uPVC Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=0'],
    'sliding-sash-windows' => ['label' => 'Sash Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=9'],
    'aluminium-windows' => ['label' => 'Aluminium Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=5'],
    'aluminium-flush-windows' => ['label' => 'Aluminium Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=5'],
    'heritage-windows' => ['label' => 'Aluminium Windows', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=5'],
    'upvc-doors' => ['label' => 'uPVC Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=1'],
    'french-doors' => ['label' => 'uPVC French Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=10'],
    'patio-doors' => ['label' => 'uPVC Sliding Patio Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=2'],
    'aluminium-bifold-doors' => ['label' => 'Aluminium Bifolding Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=11'],
    'aluminium-sliding-doors' => ['label' => 'Aluminium Sliding Patio Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=7'],
    'heritage-aluminium-doors' => ['label' => 'Heritage Aluminium Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=12'],
    'aluminium-doors' => ['label' => 'Aluminium Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=6'],
    'slide-fold-doors' => ['label' => 'Slide & Fold Doors', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=ad895968-3d4e-4bf5-901a-d3112b7631d2'],
    'double-glazing-replacement' => ['label' => 'Replacement Glazed Units', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=3'],
    'secondary-glazing' => ['label' => 'Secondary Glazing', 'url' => 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=bd73ed10-ee26-4c12-b95e-6220826dc9d3'],
];
$product_quote_embed = $product_quote_embeds[$slug] ?? null;
$product_quote_embed_url = is_array($product_quote_embed) ? (string) ($product_quote_embed['url'] ?? '') : '';
$product_quote_embed_label = is_array($product_quote_embed) ? (string) ($product_quote_embed['label'] ?? $title) : $title;
$product_quote_link = $product_quote_embed_url !== '' ? '#fenster-product-quote' : home_url('/online-quote/');
$asset_base = '/wp-content/themes/fenster/assets/images/imported/';
$hero_overrides = [
    'home' => $asset_base . 'Aluminium-Windows-16.jpg',
    'aluminium-bifold-doors' => $asset_base . 'Bifold-550-GardenView-v1.webp',
    'aluminium-flush-windows' => $asset_base . 'Flush_8-copy.jpg',
    'aluminium-sliding-doors' => $asset_base . 'steel-look-patio-hero.webp',
    'windows-milton-keynes' => $asset_base . 'Aluminium-windows.jpg',
    'doors-milton-keynes' => $asset_base . 'new-front-door-in-Milton-Keynes.jpeg',
    'commercial-glazing' => $asset_base . 'Airbus-Commercial.jpg',
    'commercial-glazing-buckinghamshire' => $asset_base . 'Airbus-Commercial.jpg',
    'roof-lanterns' => $asset_base . 'S1-Lantern-Kitchen-A-min-scaled.jpg',
    'integral-blinds' => $asset_base . 'HiTech-Blinds-Integral-Blinds-Black-Doors.jpg',
    'cat-and-dog-flaps' => $asset_base . 'SureFlap_Microchip_Cat_Flap_Glass.webp',
    'online-quote' => $asset_base . 'fthumbnail.png',
    '3d-visualiser' => $asset_base . 'fthumbnail.png',
];
$hero_media_src = $hero_overrides[$slug] ?? (is_array($hero_image) ? $hero_image['src'] : '');
if (! empty($product_media['hero']['src'])) {
    $hero_media_src = (string) $product_media['hero']['src'];
}
if (! empty($product_media['gallery']) && is_array($product_media['gallery'])) {
    $curated_gallery_images = array_values(array_filter(array_map(static function ($image) use ($title) {
        if (! is_array($image)) {
            return null;
        }

        $src = trim((string) ($image['src'] ?? ''));
        if ($src === '') {
            return null;
        }

        $alt = trim((string) ($image['alt'] ?? ''));

        return [
            'src' => $src,
            'alt' => $alt !== '' ? $alt : $title,
        ];
    }, $product_media['gallery'])));

    if (! empty($curated_gallery_images)) {
        $gallery_images = $curated_gallery_images;
        $feature_images = $curated_gallery_images;
        $product_why_image = $curated_gallery_images[0];
    }
}
$product_gallery_group_map = fenster_data('product_gallery_groups', []);
$product_gallery_group_map = is_array($product_gallery_group_map) ? $product_gallery_group_map : [];
$product_gallery_group = (string) ($product_gallery_group_map[$slug] ?? '');
$product_gallery_pool = $product_gallery_group !== '' ? fenster_data('product_gallery_pools.' . $product_gallery_group, []) : [];
$product_gallery_pool = is_array($product_gallery_pool) ? $product_gallery_pool : [];
$product_visual_gallery = [];
$product_visual_seen = [];
$product_visual_candidates = array_merge(is_array($gallery_images) ? $gallery_images : [], $product_gallery_pool);
foreach ($product_visual_candidates as $image) {
    if (! is_array($image)) {
        continue;
    }

    $src = trim((string) ($image['src'] ?? ''));
    if ($src === '' || isset($product_visual_seen[$src])) {
        continue;
    }

    $alt = trim((string) ($image['alt'] ?? ''));
    $product_visual_seen[$src] = true;
    $product_visual_gallery[] = [
        'src' => $src,
        'alt' => $alt !== '' ? $alt : $title,
    ];

    if (count($product_visual_gallery) >= 16) {
        break;
    }
}
$product_gallery_heading = sprintf('%s styles, details and installed examples.', $title);
$product_gallery_copy = sprintf(
    'This %1$s gallery brings together verified product imagery, close-up frame details and related specification examples so homeowners can compare sightlines, glazing style, opening format, colour tone and installation context before requesting a quote.',
    strtolower($title)
);
$home_categories = [
    ['label' => 'Windows', 'url' => home_url('/windows-milton-keynes/'), 'image' => $asset_base . 'Aluminium-windows.jpg', 'copy' => 'uPVC, aluminium, flush, sash and heritage-style windows for warmer, quieter homes.'],
    ['label' => 'Doors', 'url' => home_url('/doors-milton-keynes/'), 'image' => $asset_base . 'new-front-door-in-Milton-Keynes.jpeg', 'copy' => 'Composite, aluminium, French, patio and uPVC doors built around security and style.'],
    ['label' => 'Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/'), 'image' => $asset_base . 'Bifold-550-GardenView-v1.webp', 'copy' => 'Slim aluminium bifolds that open up kitchens, extensions and garden rooms.'],
    ['label' => 'Commercial Glazing', 'url' => home_url('/commercial-glazing/'), 'image' => $asset_base . 'Airbus-Commercial.jpg', 'copy' => 'Specification-led glazing, doors and facade support for commercial projects.'],
    ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/'), 'image' => $asset_base . 'S1-Lantern-Kitchen-A-min-scaled.jpg', 'copy' => 'Aluminium roof lanterns that bring clean daylight into living spaces.'],
    ['label' => 'Integral Blinds', 'url' => home_url('/integral-blinds/'), 'image' => $asset_base . 'HiTech-Blinds-Integral-Blinds-Black-Doors.jpg', 'copy' => 'Sealed blinds between glass panes for neat privacy and low-maintenance control.'],
    ['label' => 'Replacement Glazing', 'url' => home_url('/double-glazing-replacement/'), 'image' => $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg', 'copy' => 'Replace failed, misted or damaged glass without replacing the whole frame.'],
    ['label' => 'Cat & Dog Flaps', 'url' => home_url('/cat-and-dog-flaps/'), 'image' => $asset_base . 'SureFlap_Microchip_Cat_Flap_Glass.webp', 'copy' => 'Pet flap glazing options fitted cleanly into suitable doors and glass units.'],
];
$home_showcase = [
    ['label' => 'Residential aluminium', 'image' => $asset_base . 'Aluminium-Windows-16.jpg', 'copy' => 'Slim frames, clean glass lines and practical performance for modern extensions and whole-home upgrades.'],
    ['label' => 'Commercial delivery', 'image' => $asset_base . 'Airbus-Commercial.jpg', 'copy' => 'Specification-led glazing packages for offices, education, healthcare and large commercial sites.'],
    ['label' => 'Bifold living spaces', 'image' => $asset_base . 'Bifold-OpenSplit-v1.webp', 'copy' => 'Open-plan spaces with controlled thresholds, hardware and colour options.'],
];
$home_process = [
    ['step' => '01', 'title' => 'Design', 'copy' => 'Start with the instant quote route, visualise products and shape a brief before a survey.'],
    ['step' => '02', 'title' => 'Survey', 'copy' => 'Fenster checks sizes, details, access, thresholds, finishes and installation constraints.'],
    ['step' => '03', 'title' => 'Build', 'copy' => 'Systems are specified around performance, security, style and manufacturer fit.'],
    ['step' => '04', 'title' => 'Install', 'copy' => 'Installation is planned cleanly, with aftercare and guarantee support built in.'],
];
$trust_items = [
    ['src' => FENSTER_THEME_URI . '/assets/trust/google-5-stars.png', 'alt' => 'Google five star reviews'],
    ['src' => FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png', 'alt' => 'Trustpilot Excellent'],
    ['src' => FENSTER_THEME_URI . '/assets/trust/fensa.png', 'alt' => 'FENSA approved'],
    ['src' => FENSTER_THEME_URI . '/assets/trust/cpa.png', 'alt' => 'Consumer Protection Association'],
];
$partner_items = [
    ['src' => FENSTER_THEME_URI . '/assets/partners/sheerline.png', 'alt' => 'Sheerline'],
    ['label' => 'Liniar', 'alt' => 'Liniar'],
    ['src' => FENSTER_THEME_URI . '/assets/partners/distinction-doors.png', 'alt' => 'Distinction Doors'],
];
$product_hub = function_exists('fenster_product_hub_data') ? fenster_product_hub_data($slug) : [];
$product_hub_systems = is_array($product_hub['systems'] ?? null) ? array_values($product_hub['systems']) : [];
$product_hub_badges = is_array($product_hub['badges'] ?? null) ? array_values($product_hub['badges']) : [];
$product_hub_specs = is_array($product_hub['specs'] ?? null) ? array_values($product_hub['specs']) : [];
$product_hub_choices = is_array($product_hub['choices'] ?? null) ? array_values($product_hub['choices']) : [];
$product_hub_image = is_array($product_hub['image'] ?? null) ? $product_hub['image'] : ($product_visual_gallery[0] ?? $product_why_image);
$product_hub_support_image = is_array($product_visual_gallery[1] ?? null) ? $product_visual_gallery[1] : ($product_visual_gallery[0] ?? $product_hub_image);
$product_glass_styles = is_array($product_content['glass_styles']['items'] ?? null) ? array_values($product_content['glass_styles']['items']) : [];
if ($use_product_journey) {
    $partner_items = array_values(array_filter(array_map(static function ($system): ?array {
        if (! is_array($system)) {
            return null;
        }

        $label = trim((string) ($system['label'] ?? ''));
        $alt = trim((string) ($system['alt'] ?? $label));
        $src = trim((string) ($system['logo'] ?? ''));

        if ($label === '' && $src === '') {
            return null;
        }

        return [
            'label' => $label,
            'alt' => $alt !== '' ? $alt : $label,
            'src' => $src,
        ];
    }, $product_hub_systems)));
}
$product_benefits = [];
foreach (array_slice($feature_sections, 0, 6) as $section) {
    $benefit_title = trim((string) ($section['heading'] ?? ''));
    $benefit_body = trim((string) (($section['body'] ?? [])[0] ?? ''));

    if ($benefit_title === '' || $benefit_body === '') {
        continue;
    }

    $product_benefits[] = [
        'title' => $benefit_title,
        'copy' => $benefit_body,
    ];
}

if (empty($product_benefits)) {
    $product_benefits = [
        ['title' => 'Designed around your property', 'copy' => 'Fenster helps shape the right specification around style, performance, security and the way the space will be used.'],
        ['title' => 'Surveyed before specification', 'copy' => 'Every project is checked carefully so sizes, thresholds, finishes and installation details are understood before manufacture.'],
        ['title' => 'Installed with aftercare', 'copy' => 'The team supports the project from first conversation through to installation, guarantee and aftercare.'],
    ];
}

if (! empty($product_content['benefits']) && is_array($product_content['benefits'])) {
    $product_benefits = array_values(array_filter($product_content['benefits'], static function ($benefit): bool {
        return trim((string) ($benefit['title'] ?? '')) !== '' && trim((string) ($benefit['copy'] ?? '')) !== '';
    }));
}

$product_faqs = [];
foreach (array_slice(array_merge($detail_sections, $feature_sections), 0, 6) as $section) {
    $question = trim((string) ($section['heading'] ?? ''));
    $answer = trim((string) (($section['body'] ?? [])[0] ?? ''));

    if ($question === '' || $answer === '') {
        continue;
    }

    if (! str_ends_with($question, '?')) {
        $question = 'What should I know about ' . strtolower($question) . '?';
    }

    $product_faqs[] = [
        'question' => $question,
        'answer' => $answer,
    ];
}

if (empty($product_faqs)) {
    $product_faqs = [
        [
            'question' => 'How do I choose the right specification?',
            'answer' => 'Fenster will guide you through product style, frame material, colour, glazing, hardware and installation details after understanding the property and how the space is used.',
        ],
        [
            'question' => 'Can I choose different colours and finishes?',
            'answer' => 'Yes. Popular colours are shown on this page, with wider finish options available depending on the product system and material selected.',
        ],
        [
            'question' => 'Will the product be surveyed before it is made?',
            'answer' => 'Yes. Fenster checks measurements, thresholds, access and installation details before manufacture so the final specification fits the project properly.',
        ],
        [
            'question' => 'What happens after installation?',
            'answer' => 'The team supports the installation with aftercare, guarantee guidance and practical advice for looking after the product.',
        ],
    ];
}

if (! empty($product_content['faqs']) && is_array($product_content['faqs'])) {
    $product_faqs = array_values(array_filter($product_content['faqs'], static function ($faq): bool {
        return trim((string) ($faq['question'] ?? '')) !== '' && trim((string) ($faq['answer'] ?? '')) !== '';
    }));
}

$upvc_colour_routes = [
    'casement-windows',
    'flush-casement-windows',
    'sliding-sash-windows',
    'french-casement-windows',
    'tilt-turn-windows',
    'bow-bay-windows',
    'double-glazing',
    'upvc-doors',
    'patio-doors',
    'french-doors',
];
$is_upvc_colour_product = in_array($slug, $upvc_colour_routes, true);
$product_colours = $is_upvc_colour_product
    ? [
        ['name' => 'White', 'hex' => '#f7f6ef', 'finish' => 'Standard smooth or grained foil'],
        ['name' => 'Cream', 'hex' => '#efe6cf', 'finish' => 'Grained foil'],
        ['name' => 'Chartwell Green', 'hex' => '#94b59f', 'finish' => 'Grained foil'],
        ['name' => 'Irish Oak', 'hex' => '#9c7440', 'finish' => 'Grained foil'],
        ['name' => 'Golden Oak', 'hex' => '#9a5b25', 'finish' => 'Grained foil'],
        ['name' => 'Rosewood', 'hex' => '#4d211b', 'finish' => 'Grained foil'],
        ['name' => 'Anthracite Grey', 'hex' => '#353b3f', 'finish' => 'Smooth foil or grained foil'],
        ['name' => 'Black Brown', 'hex' => '#171513', 'finish' => 'Grained foil'],
        ['name' => 'Agate Grey', 'hex' => '#c2c8bd', 'finish' => 'Grained foil'],
        ['name' => 'Silver Grey', 'hex' => '#9ea8a9', 'finish' => 'Grained foil'],
        ['name' => 'Basalt Grey', 'hex' => '#596266', 'finish' => 'Grained foil'],
        ['name' => 'Slate Grey', 'hex' => '#40484b', 'finish' => 'Grained foil'],
        ['name' => 'Steel Blue', 'hex' => '#27394f', 'finish' => 'Grained foil'],
        ['name' => 'Dark Green', 'hex' => '#1f3f35', 'finish' => 'Grained foil'],
        ['name' => 'Dark Red', 'hex' => '#7b2627', 'finish' => 'Grained foil'],
        ['name' => 'Custom RAL', 'hex' => 'conic-gradient(#e64545, #f4c542, #45a857, #3d7ee8, #8a4de8, #e64545)', 'finish' => 'RAL colour match'],
    ]
    : [
        ['name' => 'White', 'hex' => '#f7f7f2'],
        ['name' => 'Anthracite Grey', 'hex' => '#353b3f'],
        ['name' => 'Black', 'hex' => '#111111'],
        ['name' => 'Cream', 'hex' => '#efe6d0'],
        ['name' => 'Chartwell Green', 'hex' => '#b7c7b4'],
        ['name' => 'Golden Oak', 'hex' => '#b77935'],
    ];

if (str_contains($slug, 'aluminium') || str_contains($slug, 'bifold')) {
    $product_colours = [
        ['name' => 'Anthracite Grey', 'hex' => '#353b3f'],
        ['name' => 'Black', 'hex' => '#111111'],
        ['name' => 'White', 'hex' => '#f7f7f2'],
        ['name' => 'Cream', 'hex' => '#efe6d0'],
        ['name' => 'Silver Grey', 'hex' => '#929a9d'],
        ['name' => 'RAL Colour', 'hex' => '#2eac66'],
    ];
}

$journey_type_label = $is_about ? 'Company guide' : ($is_commercial ? 'Commercial planning' : 'Product guide');
$journey_heading = $is_about ? 'Get to know Fenster with clarity.' : ($is_commercial ? 'Plan commercial glazing with clarity.' : 'Choose ' . $title . ' with clarity.');
$journey_steps = $is_about
    ? ['Meet the team', 'Understand the process', 'Start a conversation']
    : ($is_commercial
        ? ['Define the building need', 'Shape the specification', 'Move into delivery']
        : ['Compare the real benefits', 'See finishes and project images', 'Move into survey and install']);
$journey_intro_heading = $is_about ? 'People, process and proof.' : ($is_commercial ? 'Clear specification, cleaner delivery.' : 'A better way to choose glazing.');
$journey_intro_copy = $is_about
    ? 'Use this page to understand the people behind Fenster, the way projects are handled and the proof points that support the business.'
    : ($is_commercial
        ? 'Use this page to compare performance, system fit, project control and enquiry details in one place.'
        : 'The essentials are brought forward: style, performance, security, images, guarantees and a clear way to request a quote or consultation.');
$journey_why_eyebrow = $is_about ? 'Why Fenster?' : ($is_commercial ? 'Why Fenster commercially?' : 'Why choose this product?');
$journey_why_heading = $is_about ? 'Why choose Fenster Glazing?' : ($is_commercial ? 'Why choose Fenster for commercial glazing?' : 'Why choose ' . $title . '?');
$journey_why_button = $is_about ? 'Talk to the team' : ($is_commercial ? 'Start a commercial enquiry' : 'Start a product enquiry');
$journey_gallery_eyebrow = $is_about ? 'People and proof' : ($is_commercial ? 'Projects and systems' : 'Gallery and choices');
$journey_gallery_heading = $is_about ? 'See the team, work and details behind the company.' : ($is_commercial ? 'See the commercial work, systems and details before you enquire.' : 'See the styles, finishes and details before you enquire.');
$journey_faq_eyebrow = $is_about ? 'Company questions' : ($is_commercial ? 'Commercial questions' : 'Product questions');
$journey_faq_heading = $is_about ? 'FAQs about Fenster Glazing' : ($is_commercial ? 'FAQs about commercial glazing' : 'FAQs about ' . $title);
$journey_order_eyebrow = $is_commercial ? 'Project process' : ($is_about ? 'How Fenster works' : 'Order process');
$journey_order_heading = $is_commercial ? 'A clear process from early brief to delivery.' : ($is_about ? 'A clear process from first conversation to aftercare.' : 'A clear process from first quote to aftercare.');
$journey_order_copy = $is_commercial
    ? 'Fenster keeps commercial projects moving through brief, specification, coordination, installation and aftercare.'
    : ($is_about
        ? 'Fenster keeps enquiries straightforward: understand the need, check the details, install carefully and support the work afterwards.'
        : 'Fenster keeps the process simple: understand the brief, survey properly, install carefully and support the product afterwards.');
$journey_order_action = $is_commercial ? 'Start a commercial conversation' : ($is_about ? 'Start a conversation' : 'Start your enquiry');
$journey_trust_heading = $is_about ? 'A local glazing team backed by recognised accreditations.' : 'Reviewed, accredited and backed by proven product systems.';
$journey_trust_copy = $is_about
    ? 'Fenster combines local installation experience, real people, recognised accreditations and trusted glazing system partners.'
    : 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.';
$journey_option_eyebrow = ($is_product && ! $is_commercial) ? 'Popular colours' : ($is_commercial ? 'Commercial checkpoints' : 'Company checkpoints');
$journey_option_heading = ($is_product && ! $is_commercial) ? 'Choose a finish that fits the property.' : ($is_commercial ? 'Keep the important project decisions visible.' : 'Understand how Fenster keeps the work grounded.');
$journey_options = $product_colours;

if ($is_commercial) {
    $journey_options = [
        ['name' => 'Brief', 'hex' => '#2eac66'],
        ['name' => 'Performance', 'hex' => '#002d3a'],
        ['name' => 'Interfaces', 'hex' => '#4c7b86'],
        ['name' => 'Programme', 'hex' => '#20824c'],
        ['name' => 'Access', 'hex' => '#19424e'],
        ['name' => 'Aftercare', 'hex' => '#60727a'],
    ];
} elseif (! $is_product) {
    $journey_options = [
        ['name' => 'People', 'hex' => '#2eac66'],
        ['name' => 'Survey', 'hex' => '#002d3a'],
        ['name' => 'Install', 'hex' => '#4c7b86'],
        ['name' => 'Guarantee', 'hex' => '#20824c'],
        ['name' => 'Reviews', 'hex' => '#19424e'],
        ['name' => 'Support', 'hex' => '#60727a'],
    ];
}

$product_order_steps = [
    ['step' => '01', 'title' => 'Quotation', 'copy' => 'Tell Fenster what you want to change and get clear pricing guidance for the product.'],
    ['step' => '02', 'title' => 'Design & Survey', 'copy' => 'The team checks measurements, styles, colours, thresholds, hardware and installation details.'],
    ['step' => '03', 'title' => 'Installation', 'copy' => 'Your product is installed by experienced fitters with the right preparation and care on site.'],
    ['step' => '04', 'title' => 'Aftercare', 'copy' => 'Fenster supports the installation with guarantee guidance, maintenance advice and aftercare.'],
];

if ($is_commercial) {
    $product_order_steps = [
        ['step' => '01', 'title' => 'Brief', 'copy' => 'Share the building type, package scope, programme, drawings and performance requirements.'],
        ['step' => '02', 'title' => 'Specification', 'copy' => 'Fenster helps align systems, glazing, access, interfaces and delivery constraints before work moves ahead.'],
        ['step' => '03', 'title' => 'Installation', 'copy' => 'Commercial installation is planned around site coordination, safety, sequencing and programme needs.'],
        ['step' => '04', 'title' => 'Aftercare', 'copy' => 'The team remains available for documentation, maintenance guidance and practical project support.'],
    ];
} elseif ($is_about) {
    $product_order_steps = [
        ['step' => '01', 'title' => 'Conversation', 'copy' => 'Fenster starts by understanding the property, the people involved and what needs to change.'],
        ['step' => '02', 'title' => 'Survey', 'copy' => 'The team checks details properly so the recommendation is based on real site conditions.'],
        ['step' => '03', 'title' => 'Installation', 'copy' => 'Experienced installers manage the work with care for the property and the finished detail.'],
        ['step' => '04', 'title' => 'Aftercare', 'copy' => 'Fenster supports customers after installation with guarantee guidance and practical advice.'],
    ];
}
$related_links = [];
$generated_pages = fenster_generated_pages_index();
$virtual_page_titles = [
    'aluminium-flush-windows' => 'Aluminium Flush Windows',
    'aluminium-sliding-doors' => 'Aluminium Sliding Doors',
    'commercial-areas' => 'Commercial Areas',
    'commercial-projects' => 'Commercial Projects',
];
foreach ($commercial_county_pages as $commercial_county_slug => $commercial_county_page) {
    $virtual_page_titles[$commercial_county_slug] = (string) ($commercial_county_page['title'] ?? ucwords(str_replace('-', ' ', $commercial_county_slug)));
}
$known_locations = [
    'leighton-buzzard' => 'Leighton Buzzard',
    'northamptonshire' => 'Northamptonshire',
    'milton-keynes' => 'Milton Keynes',
    'buckinghamshire' => 'Buckinghamshire',
    'northampton' => 'Northampton',
    'letchworth' => 'Letchworth',
    'stevenage' => 'Stevenage',
    'toddington' => 'Toddington',
    'aylesbury' => 'Aylesbury',
    'dunstable' => 'Dunstable',
    'flitwick' => 'Flitwick',
    'ampthill' => 'Ampthill',
    'hitchin' => 'Hitchin',
    'bedford' => 'Bedford',
    'buckingham' => 'Buckingham',
    'luton' => 'Luton',
];

if ($slug === 'areas-we-cover') {
    $matrix_towns = ! empty($location_matrix_towns) ? $location_matrix_towns : $known_locations;
    $matrix_pages = function_exists('fenster_location_matrix_pages') ? fenster_location_matrix_pages() : [];
    $featured_area_slugs = [
        'milton-keynes' => 'Milton Keynes',
        'northampton' => 'Northampton',
        'bedford' => 'Bedford',
        'buckingham' => 'Buckingham',
        'ampthill' => 'Ampthill',
        'toddington' => 'Toddington',
    ];
    $coverage_highlights = [
        [
            'title' => __('Showroom-led advice', 'fenster'),
            'copy' => __('Visit the Milton Keynes showroom, then arrange a survey for your home or project.', 'fenster'),
        ],
        [
            'title' => __('Residential and commercial', 'fenster'),
            'copy' => __('Windows, doors, replacement glass, roof lanterns and commercial glazing support.', 'fenster'),
        ],
        [
            'title' => __('Local survey planning', 'fenster'),
            'copy' => __('Fenster checks access, measurements, specification choices and installation details before ordering.', 'fenster'),
        ],
    ];
    $area_groups = [];
    foreach ($matrix_towns as $location_slug => $location_label) {
        $area_groups[$location_slug] = [
            'label' => $location_label,
            'links' => [],
        ];
    }

    foreach ($matrix_pages as $generated_slug => $generated_page) {
        $generated_slug = trim((string) $generated_slug, '/');
        if ($generated_slug === '') {
            continue;
        }

        foreach ($matrix_towns as $location_slug => $location_label) {
            if (! str_ends_with($generated_slug, '-' . $location_slug)) {
                continue;
            }

            $area_groups[$location_slug]['links'][$generated_slug] = [
                'title' => trim((string) ($generated_page['title'] ?? ucwords(str_replace('-', ' ', $generated_slug)))),
                'url' => home_url('/' . $generated_slug . '/'),
                'slug' => $generated_slug,
            ];
            break;
        }
    }

    foreach ($area_groups as $location_slug => $area_group) {
        uasort($area_groups[$location_slug]['links'], static function (array $first, array $second): int {
            return strcasecmp($first['title'], $second['title']);
        });
    }

    $area_groups = array_filter($area_groups, static fn (array $area_group): bool => ! empty($area_group['links']));
    $area_link_count = array_sum(array_map(static fn (array $area_group): int => count($area_group['links']), $area_groups));
    $featured_area_cards = [];
    foreach ($featured_area_slugs as $featured_slug => $featured_label) {
        $featured_area_cards[] = [
            'label' => $featured_label,
            'url' => home_url('/double-glazing-' . $featured_slug . '/'),
            'copy' => sprintf(__('Windows, doors and glazing around %s.', 'fenster'), $featured_label),
        ];
    }
    ?>
    <article class="generated-page generated-page--areas fg-areas-page">
        <section class="fg-areas-page__hero">
            <div class="container fg-areas-page__hero-grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Local glazing coverage', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Windows, doors and glazing across the areas we serve.', 'fenster'); ?></h1>
                    <p><?php esc_html_e('Fenster Glazing works from our Milton Keynes showroom across Buckinghamshire, Bedfordshire, Northamptonshire and nearby towns. Check your local area, then start an enquiry or instant quote.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Ask about your area', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-areas-page__summary" aria-label="<?php esc_attr_e('Fenster service area summary', 'fenster'); ?>">
                    <strong><?php echo esc_html(sprintf(__('%d local service pages', 'fenster'), $area_link_count)); ?></strong>
                    <span><?php echo esc_html(sprintf(__('%d towns grouped below', 'fenster'), count($area_groups))); ?></span>
                    <p><?php esc_html_e('If your town is nearby but not listed, contact the showroom and the team can confirm coverage.', 'fenster'); ?></p>
                </aside>
            </div>
        </section>

        <section class="fg-areas-page__featured" aria-label="<?php esc_attr_e('Popular local areas', 'fenster'); ?>">
            <div class="container">
                <div class="fg-areas-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Popular areas', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Start with one of our main local pages.', 'fenster'); ?></h2>
                </div>
                <div class="fg-areas-page__featured-grid">
                    <?php foreach ($featured_area_cards as $featured_area) : ?>
                        <a href="<?php echo esc_url($featured_area['url']); ?>">
                            <strong><?php echo esc_html($featured_area['label']); ?></strong>
                            <span><?php echo esc_html($featured_area['copy']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-areas-page__proof">
            <div class="container fg-areas-page__proof-grid">
                <?php foreach ($coverage_highlights as $coverage_highlight) : ?>
                    <article>
                        <h2><?php echo esc_html($coverage_highlight['title']); ?></h2>
                        <p><?php echo esc_html($coverage_highlight['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="fg-areas-page__body">
            <div class="container">
                <div class="fg-areas-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Browse by town', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Find Fenster services near you.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Each town links to the most useful product and service pages for local homeowners.', 'fenster'); ?></p>
                </div>
                <div class="fg-areas-page__grid">
                    <?php foreach ($area_groups as $area_group) : ?>
                        <section class="fg-areas-page__group" aria-labelledby="area-<?php echo esc_attr(sanitize_title($area_group['label'])); ?>">
                            <header class="fg-areas-page__group-head">
                                <h3 id="area-<?php echo esc_attr(sanitize_title($area_group['label'])); ?>"><?php echo esc_html($area_group['label']); ?></h3>
                                <span><?php echo esc_html(sprintf(_n('%d service', '%d services', count($area_group['links']), 'fenster'), count($area_group['links']))); ?></span>
                            </header>

                            <div class="fg-areas-page__links">
                                <?php foreach ($area_group['links'] as $area_link) : ?>
                                    <a href="<?php echo esc_url($area_link['url']); ?>">
                                        <span><?php echo esc_html($area_link['title']); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-areas-page__cta">
            <div class="container fg-areas-page__cta-inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Not sure where to start?', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us where the property is and what you would like to change.', 'fenster'); ?></h2>
                </div>
                <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Fenster', 'fenster'); ?></a>
            </div>
        </section>
    </article>
    <?php
    return;
}

if ($is_commercial_areas) {
    $county_profiles = function_exists('fenster_commercial_county_profiles') ? fenster_commercial_county_profiles() : [];
    uasort($commercial_county_pages, static function (array $first, array $second): int {
        return strcasecmp((string) ($first['title'] ?? ''), (string) ($second['title'] ?? ''));
    });
    ?>
    <article class="generated-page generated-page--areas fg-areas-page fg-commercial-areas-page">
        <section class="fg-areas-page__hero">
            <div class="container fg-areas-page__hero-grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Commercial county pages', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Commercial glazing landing pages by county.', 'fenster'); ?></h1>
                    <p><?php esc_html_e('Temporary review index for the generated commercial county landing pages. This page is noindex and exists so the full England county set can be checked quickly during development.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>"><?php esc_html_e('Commercial hub', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('Commercial projects', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-areas-page__summary" aria-label="<?php esc_attr_e('Commercial county page summary', 'fenster'); ?>">
                    <strong><?php echo esc_html(sprintf(__('%d county pages', 'fenster'), count($commercial_county_pages))); ?></strong>
                    <span><?php esc_html_e('England county coverage', 'fenster'); ?></span>
                    <p><?php esc_html_e('Each link opens an SEO landing page with a hero form, visible phone route and county-specific commercial copy.', 'fenster'); ?></p>
                </aside>
            </div>
        </section>

        <section class="fg-areas-page__body">
            <div class="container">
                <div class="fg-areas-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Browse pages', 'fenster'); ?></p>
                    <h2><?php esc_html_e('England commercial glazing counties.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Use this temporary page to review titles, hero forms, town coverage and county-specific copy.', 'fenster'); ?></p>
                </div>
                <div class="fg-commercial-areas-page__grid">
                    <?php foreach ($commercial_county_pages as $county_slug => $county_page) : ?>
                        <?php
                        $profile_key = str_replace('commercial-glazing-', '', (string) $county_slug);
                        $profile = $county_profiles[$profile_key] ?? [];
                        ?>
                        <a class="fg-commercial-areas-page__card" href="<?php echo esc_url($county_page['url'] ?? home_url('/' . $county_slug . '/')); ?>">
                            <strong><?php echo esc_html((string) ($profile['county'] ?? $county_page['title'] ?? 'Commercial county')); ?></strong>
                            <span><?php echo esc_html((string) ($profile['region'] ?? __('Commercial glazing coverage', 'fenster'))); ?></span>
                            <?php if (! empty($profile['towns']) && is_array($profile['towns'])) : ?>
                                <small><?php echo esc_html(implode(', ', array_slice($profile['towns'], 0, 4))); ?></small>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </article>
    <?php
    return;
}

$window_routes = [
    'windows-milton-keynes',
    'casement-windows',
    'flush-casement-windows',
    'sliding-sash-windows',
    'french-casement-windows',
    'tilt-turn-windows',
    'bow-bay-windows',
    'aluminium-windows',
    'aluminium-flush-windows',
    'heritage-windows',
];
$door_routes = [
    'doors-milton-keynes',
    'aluminium-bifold-doors',
    'slide-fold-doors',
    'aluminium-sliding-doors',
    'aluminium-doors',
    'heritage-aluminium-doors',
    'composite-doors',
    'upvc-doors',
    'patio-doors',
    'french-doors',
];
$other_service_routes = [
    'roof-lanterns',
    'integral-blinds',
    'double-glazing-replacement',
    'secondary-glazing',
    'window-and-door-repairs',
    'roofline',
    'cat-and-dog-flaps',
];
$commercial_routes = [
    'commercial-glazing',
    'commercial-windows-and-doors',
    'curtain-walling',
    'louvre-vents',
    'commercial-automation',
    'commercial-projects',
];
$commercial_routes = array_values(array_unique(array_merge($commercial_routes, array_keys($commercial_county_pages))));
$product_families = [
    'french-casement-windows' => ['group' => 'windows', 'main' => 'french-casement-windows'],
    'flush-casement-windows' => ['group' => 'windows', 'main' => 'flush-casement-windows'],
    'sliding-sash-windows' => ['group' => 'windows', 'main' => 'sliding-sash-windows'],
    'tilt-and-turn-windows' => ['group' => 'windows', 'main' => 'tilt-turn-windows'],
    'tilt-turn-windows' => ['group' => 'windows', 'main' => 'tilt-turn-windows'],
    'bow-and-bay-windows' => ['group' => 'windows', 'main' => 'bow-bay-windows'],
    'bow-bay-windows' => ['group' => 'windows', 'main' => 'bow-bay-windows'],
    'aluminium-bifold-doors' => ['group' => 'doors', 'main' => 'aluminium-bifold-doors'],
    'heritage-aluminium-doors' => ['group' => 'doors', 'main' => 'heritage-aluminium-doors'],
    'aluminium-sliding-doors' => ['group' => 'doors', 'main' => 'aluminium-sliding-doors'],
    'slide-fold-doors' => ['group' => 'doors', 'main' => 'slide-fold-doors'],
    'composite-doors' => ['group' => 'doors', 'main' => 'composite-doors'],
    'aluminium-doors' => ['group' => 'doors', 'main' => 'aluminium-doors'],
    'french-doors' => ['group' => 'doors', 'main' => 'french-doors'],
    'patio-doors' => ['group' => 'doors', 'main' => 'patio-doors'],
    'upvc-doors' => ['group' => 'doors', 'main' => 'upvc-doors'],
    'aluminium-flush-windows' => ['group' => 'windows', 'main' => 'aluminium-flush-windows'],
    'aluminium-windows' => ['group' => 'windows', 'main' => 'aluminium-windows'],
    'heritage-windows' => ['group' => 'windows', 'main' => 'heritage-windows'],
    'casement-windows' => ['group' => 'windows', 'main' => 'casement-windows'],
    'roof-lanterns' => ['group' => 'other', 'main' => 'roof-lanterns'],
    'integral-blinds' => ['group' => 'other', 'main' => 'integral-blinds'],
    'secondary-glazing' => ['group' => 'other', 'main' => 'secondary-glazing'],
    'double-glazing-replacement' => ['group' => 'other', 'main' => 'double-glazing-replacement'],
    'window-and-door-repairs' => ['group' => 'other', 'main' => 'window-and-door-repairs'],
    'roofline' => ['group' => 'other', 'main' => 'roofline'],
    'cat-and-dog-flaps' => ['group' => 'other', 'main' => 'cat-and-dog-flaps'],
];
$current_location = '';
foreach ($known_locations as $location_slug => $location_label) {
    if ($slug === 'double-glazing-' . $location_slug || str_ends_with($slug, '-' . $location_slug)) {
        $current_location = $location_slug;
        break;
    }
}
$route_exists = static function (string $target_slug) use ($generated_pages, $virtual_page_titles): bool {
    return $target_slug === 'home' || isset($generated_pages[$target_slug]) || isset($virtual_page_titles[$target_slug]);
};
$route_title = static function (string $target_slug) use ($generated_pages, $virtual_page_titles, $known_locations): string {
    $label = trim((string) ($virtual_page_titles[$target_slug] ?? $generated_pages[$target_slug]['title'] ?? ''));

    foreach ($known_locations as $location_slug => $location_name) {
        if (str_ends_with($target_slug, '-' . $location_slug) && ! str_contains(strtolower($label), strtolower($location_name))) {
            $label .= ' ' . $location_name;
            break;
        }
    }

    return $label;
};
$add_related_route = static function (string $target_slug, string $label = '') use (&$related_links, $slug, $route_exists, $route_title): void {
    $target_slug = trim($target_slug, '/');
    if ($target_slug === '' || $target_slug === $slug || ! $route_exists($target_slug)) {
        return;
    }

    $label = trim($label !== '' ? $label : $route_title($target_slug));
    if ($label === '') {
        return;
    }

    $related_links[$target_slug] = [
        'text' => $label,
        'url' => home_url('/' . $target_slug . '/'),
    ];
};
$add_related_routes = static function (array $target_slugs) use ($add_related_route): void {
    foreach ($target_slugs as $target_slug) {
        $add_related_route((string) $target_slug);
    }
};
$matched_family = null;
foreach ($product_families as $family_prefix => $family) {
    if ($slug === $family_prefix || str_starts_with($slug, $family_prefix . '-')) {
        $matched_family = $family;
        break;
    }
}

if (str_starts_with($slug, 'double-glazing-') && $current_location !== '') {
    $add_related_route('windows-milton-keynes');
    $add_related_route('doors-milton-keynes');

    foreach (array_merge(array_slice($window_routes, 1), array_slice($door_routes, 1), $other_service_routes) as $candidate) {
        $add_related_route($candidate . '-' . $current_location);
    }

    $add_related_routes(['casement-windows', 'composite-doors', 'aluminium-windows', 'aluminium-bifold-doors']);
} elseif (is_array($matched_family)) {
    $group_routes = $matched_family['group'] === 'windows'
        ? $window_routes
        : ($matched_family['group'] === 'doors' ? $door_routes : $other_service_routes);

    $add_related_route($matched_family['main']);

    if ($current_location !== '') {
        $add_related_route('double-glazing-' . $current_location);
        foreach ($group_routes as $candidate) {
            $add_related_route($candidate . '-' . $current_location);
        }
    } else {
        foreach (array_keys($known_locations) as $location_slug) {
            $add_related_route($matched_family['main'] . '-' . $location_slug);
        }
    }

    $add_related_routes($group_routes);
} elseif ($is_commercial) {
    $add_related_routes($commercial_routes);
    $add_related_routes([
        'commercial-glazing-bedfordshire',
        'commercial-glazing-milton-keynes',
        'commercial-glazing-northamptonshire',
    ]);
} else {
    $context = strtolower($slug . ' ' . $title . ' ' . $seo_intro);

    if (str_contains($context, 'door') || str_contains($context, 'lock') || str_contains($context, 'lintel')) {
        $add_related_routes($door_routes);
    }
    if (
        str_contains($context, 'window')
        || str_contains($context, 'glaz')
        || str_contains($context, 'condensation')
        || str_contains($context, 'u-value')
        || str_contains($context, 'soundproof')
    ) {
        $add_related_routes($window_routes);
        $add_related_routes(['double-glazing-replacement', 'secondary-glazing']);
    }
    if (str_contains($context, 'blind')) {
        $add_related_routes(['integral-blinds', 'patio-doors', 'aluminium-bifold-doors']);
    }
    if (str_contains($context, 'roof')) {
        $add_related_routes(['roof-lanterns', 'roofline']);
    }
}

if (count($related_links) < 6) {
    $add_related_routes([
        'windows-milton-keynes',
        'doors-milton-keynes',
        'aluminium-windows',
        'aluminium-bifold-doors',
        'composite-doors',
        'roof-lanterns',
        'integral-blinds',
        'double-glazing-replacement',
    ]);
}

if ($is_home) {
    get_template_part('template-parts/sections/home-experience', null, [
        'asset_base' => $asset_base,
        'brand' => $brand,
        'hero_intro' => $hero_intro,
        'instant_quote_preview' => $instant_quote_preview,
        'instant_quote_url' => $instant_quote_url,
        'related_links' => $related_links,
        'sick_video' => $sick_video,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_case_study) {
    get_template_part('template-parts/sections/case-studies');
    return;
}

if ($is_location_service) {
    get_template_part('template-parts/sections/location-service', null, [
        'asset_base' => $asset_base,
        'brand' => $brand,
        'gallery_images' => $gallery_images,
        'hero_image' => $hero_image,
        'hero_intro' => $hero_intro,
        'instant_quote_preview' => $instant_quote_preview,
        'links' => $related_links,
        'page' => $page,
        'sections' => $sections,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_commercial_county) {
    get_template_part('template-parts/sections/commercial-county', null, [
        'asset_base' => $asset_base,
        'brand' => $brand,
        'links' => $related_links,
        'page' => $page,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_team) {
    get_template_part('template-parts/sections/team', null, [
        'brand' => $brand,
        'page' => $page,
        'related_links' => $related_links,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_about_page) {
    get_template_part('template-parts/sections/about', null, [
        'brand' => $brand,
        'page' => $page,
        'related_links' => $related_links,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_contact) {
    get_template_part('template-parts/sections/contact', null, [
        'brand' => $brand,
        'page' => $page,
        'related_links' => $related_links,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_product_selector_hub) {
    get_template_part('template-parts/sections/windows-hub', null, [
        'asset_base' => $asset_base,
        'brand' => $brand,
        'instant_quote_preview' => $instant_quote_preview,
        'page' => $page,
        'related_links' => $related_links,
        'selector_type' => $is_doors_hub ? 'doors' : 'windows',
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_quote_tool) {
    get_template_part('template-parts/sections/quote-tool', null, [
        'brand' => $brand,
        'instant_quote_preview' => $instant_quote_preview,
        'instant_quote_url' => $instant_quote_url,
        'page' => $page,
        'related_links' => $related_links,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_colour_options) {
    $active_material = $slug === 'aluminium-colours' ? 'aluminium' : ($slug === 'upvc-colours' ? 'upvc' : 'upvc');
    $hero_upvc_colours = array_slice(array_values((array) ($colour_materials['upvc']['colours'] ?? [])), 0, 4);
    $hero_aluminium_colours = array_slice(array_values((array) ($colour_materials['aluminium']['colours'] ?? [])), 0, 4);
    $render_colour_material = static function (string $material_key, array $material, string $active_material): void {
        $colours = is_array($material['colours'] ?? null) ? array_values($material['colours']) : [];
        ?>
        <article
            class="fg-colour-hub__material<?php echo $material_key === $active_material ? ' is-active' : ''; ?>"
            id="<?php echo esc_attr((string) ($material['slug'] ?? $material_key)); ?>"
            data-fg-colour-material="<?php echo esc_attr($material_key); ?>"
        >
            <div class="fg-colour-hub__material-copy">
                <p class="eyebrow"><?php echo esc_html((string) ($material['label'] ?? 'Frame colours')); ?></p>
                <h2><?php echo esc_html((string) ($material['headline'] ?? 'Compare colour options.')); ?></h2>
                <p><?php echo esc_html((string) ($material['copy'] ?? '')); ?></p>
            </div>
            <div class="fg-colour-carousel" data-fg-colour-carousel>
                <div class="fg-colour-carousel__viewport">
                    <div class="fg-colour-carousel__track" data-fg-colour-carousel-track>
                        <?php foreach ($colours as $index => $colour) : ?>
                            <?php $swatch = (string) ($colour['hex'] ?? '#ffffff'); ?>
                            <article class="fg-colour-carousel__slide" style="<?php echo esc_attr('--swatch:' . $swatch); ?>" data-fg-colour-slide>
                                <?php if (! empty($colour['image'])) : ?>
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr((string) ($colour['name'] ?? 'Colour')); ?>" loading="lazy">
                                <?php else : ?>
                                    <i aria-hidden="true"></i>
                                <?php endif; ?>
                                <div>
                                    <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                    <h3><?php echo esc_html((string) ($colour['name'] ?? 'Colour')); ?></h3>
                                    <?php if (! empty($colour['finish'])) : ?>
                                        <p><?php echo esc_html((string) $colour['finish']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="fg-colour-carousel__controls">
                    <button type="button" data-fg-colour-prev aria-label="<?php esc_attr_e('Previous colour', 'fenster'); ?>">&#8249;</button>
                    <span data-fg-colour-count><?php echo esc_html('01 / ' . sprintf('%02d', max(1, count($colours)))); ?></span>
                    <button type="button" data-fg-colour-next aria-label="<?php esc_attr_e('Next colour', 'fenster'); ?>">&#8250;</button>
                </div>
            </div>
        </article>
        <?php
    };
    ?>
    <main class="fg-colour-hub-page">
        <section class="fg-colour-hub-hero">
            <div class="container fg-colour-hub-hero__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Specification hub', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Colour options for Fenster windows and doors.', 'fenster'); ?></h1>
                    <p><?php echo esc_html((string) ($colour_options['intro'] ?? $hero_intro)); ?></p>
                </div>
                <div class="fg-colour-hub-hero__visual" aria-label="<?php esc_attr_e('Frame colour sample board', 'fenster'); ?>">
                    <div class="fg-colour-hub-hero__frame">
                        <?php foreach (array_slice($hero_upvc_colours, 0, 3) as $index => $colour) : ?>
                            <?php if (! empty($colour['image'])) : ?>
                                <figure class="fg-colour-hub-hero__tile fg-colour-hub-hero__tile--<?php echo esc_attr((string) ($index + 1)); ?>" style="<?php echo esc_attr('--swatch:' . (string) ($colour['hex'] ?? '#ffffff')); ?>">
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr((string) ($colour['name'] ?? 'Colour finish')); ?>" loading="eager">
                                    <figcaption><?php echo esc_html((string) ($colour['name'] ?? 'uPVC colour')); ?></figcaption>
                                </figure>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach (array_slice($hero_aluminium_colours, 0, 2) as $index => $colour) : ?>
                            <?php if (! empty($colour['image'])) : ?>
                                <figure class="fg-colour-hub-hero__tile fg-colour-hub-hero__tile--metal-<?php echo esc_attr((string) ($index + 1)); ?>" style="<?php echo esc_attr('--swatch:' . (string) ($colour['hex'] ?? '#ffffff')); ?>">
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr((string) ($colour['name'] ?? 'Colour finish')); ?>" loading="eager">
                                    <figcaption><?php echo esc_html((string) ($colour['name'] ?? 'Aluminium colour')); ?></figcaption>
                                </figure>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="fg-colour-hub-hero__swatches" aria-hidden="true">
                        <span><?php esc_html_e('uPVC colours', 'fenster'); ?></span>
                        <span><?php esc_html_e('Aluminium colours', 'fenster'); ?></span>
                        <span><?php esc_html_e('Sample-led selection', 'fenster'); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="fg-colour-hub">
            <div class="container">
                <?php foreach ($colour_materials as $material_key => $material) : ?>
                    <?php $render_colour_material((string) $material_key, is_array($material) ? $material : [], $active_material); ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="fenster-enquiry" class="fg-obscure-enquiry">
            <div class="container fg-obscure-enquiry__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Bring samples together', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Match frame colour, glass and hardware before ordering.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Fenster can help narrow the material, colour, glass and handle choices around the property rather than treating each decision separately.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form',
                    'source' => $title,
                    'button_label' => 'Ask about colour options',
                    'project_type' => 'Windows and doors',
                ]);
                ?>
            </div>
        </section>
    </main>
    <?php
    return;
}

if ($is_trust_page) {
    get_template_part('template-parts/sections/trust-page', null, [
        'brand' => $brand,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_obscure_glass) {
    $legend_image = (string) ($obscure_glass['legend_image'] ?? '/wp-content/themes/fenster/assets/team/legend-bw.jpg');
    $house_image = (string) ($obscure_glass['house_image'] ?? '');
    $obscure_glass_intro = (string) ($obscure_glass['intro'] ?? $hero_intro);
    $active_glass_name = is_array($obscure_glass_first) ? (string) ($obscure_glass_first['name'] ?? 'Arctic') : 'Arctic';
    $active_glass_privacy = is_array($obscure_glass_first) ? (int) ($obscure_glass_first['privacy'] ?? 0) : 0;
    $active_glass_copy = is_array($obscure_glass_first) ? (string) ($obscure_glass_first['copy'] ?? '') : '';
    $active_glass_key = sanitize_title($active_glass_name);
    $obscure_glass_texture_value = static function (array $texture): string {
        $texture_css = trim((string) ($texture['texture'] ?? ''));
        if ($texture_css !== '') {
            return $texture_css;
        }

        $texture_image = trim((string) ($texture['image'] ?? ''));
        return $texture_image !== '' ? 'url("' . fenster_generated_url($texture_image) . '")' : 'none';
    };
    $active_glass_texture = is_array($obscure_glass_first) ? $obscure_glass_texture_value($obscure_glass_first) : 'none';
    $obscure_glass_left = array_slice($obscure_glass_textures, 0, 10, true);
    $obscure_glass_right = array_slice($obscure_glass_textures, 10, null, true);
    $obscure_glass_bottom = [];
    $render_obscure_glass_option = static function (array $texture, int $index): void {
        $texture_name = (string) ($texture['name'] ?? '');
        $privacy = (int) ($texture['privacy'] ?? 0);
        $texture_value = trim((string) ($texture['texture'] ?? ''));
        if ($texture_value === '') {
            $texture_value = 'url("' . fenster_generated_url((string) ($texture['image'] ?? '')) . '")';
        }
        ?>
        <button
            type="button"
            role="listitem"
            class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
            data-fg-obscure-option
            data-texture="<?php echo esc_attr($texture_value); ?>"
            data-name="<?php echo esc_attr($texture_name); ?>"
            data-key="<?php echo esc_attr(sanitize_title($texture_name)); ?>"
            data-privacy="<?php echo esc_attr((string) $privacy); ?>"
            data-copy="<?php echo esc_attr((string) ($texture['copy'] ?? '')); ?>"
            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
        >
            <span style="<?php echo esc_attr('--texture:' . $texture_value . ';'); ?>" aria-hidden="true"></span>
            <strong><?php echo esc_html($texture_name); ?></strong>
            <small><?php echo esc_html($privacy === 0 ? 'Decorative' : 'Privacy ' . $privacy); ?></small>
        </button>
        <?php
    };
    ?>
    <article class="fg-obscure-glass-page">
        <section class="fg-obscure-hero">
            <div class="container fg-obscure-hero__grid">
                <div class="fg-obscure-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Glass privacy choices', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Obscured glass, previewed properly.', 'fenster'); ?></h1>
                    <p><?php echo esc_html($obscure_glass_intro); ?></p>
                    <div class="button-row">
                        <a class="button" href="#fg-obscure-visualiser"><?php esc_html_e('Try the glass preview', 'fenster'); ?></a>
                        <a class="button button--light" href="#fenster-enquiry"><?php esc_html_e('Ask about glass options', 'fenster'); ?></a>
                    </div>
                </div>
                <div class="fg-obscure-hero__preview" aria-hidden="true">
                    <?php foreach (array_slice($obscure_glass_textures, 0, 5) as $index => $texture) : ?>
                        <span style="<?php echo esc_attr('--texture:' . $obscure_glass_texture_value($texture) . '; --delay:' . ($index * 0.16) . 's;'); ?>"></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="fg-obscure-visualiser" class="fg-obscure-visualiser" data-fg-obscure-glass>
            <div class="container fg-obscure-visualiser__grid">
                <div class="fg-obscure-rail fg-obscure-rail--left fg-obscure-picker__buttons" role="list" aria-label="<?php esc_attr_e('Obscured glass pattern options, left side', 'fenster'); ?>">
                    <?php foreach ($obscure_glass_left as $index => $texture) : ?>
                        <?php $render_obscure_glass_option($texture, (int) $index); ?>
                    <?php endforeach; ?>
                </div>

                <div
                    class="fg-obscure-stage"
                    style="<?php echo esc_attr('--scene-image:url(' . fenster_generated_url($legend_image) . '); --active-texture:' . $active_glass_texture . '; --privacy:' . $active_glass_privacy); ?>"
                    data-cat-image="<?php echo esc_url(fenster_generated_url($legend_image)); ?>"
                    data-house-image="<?php echo esc_url(fenster_generated_url($house_image)); ?>"
                    data-active-background="cat"
                    data-active-glass="<?php echo esc_attr($active_glass_key); ?>"
                >
                    <div class="fg-obscure-stage__viewport" data-fg-obscure-tilt>
                        <div class="fg-obscure-stage__main-image" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__glass" data-fg-obscure-glass-layer aria-hidden="true"></div>
                        <div class="fg-obscure-stage__shine" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__scan" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__divider" aria-hidden="true"><span></span></div>
                        <input class="fg-obscure-stage__range" type="range" min="0" max="100" value="54" aria-label="<?php esc_attr_e('Move the clear and Obscured glass comparison divider', 'fenster'); ?>" data-fg-obscure-split>
                    </div>
                    <div class="fg-obscure-stage__readout" aria-live="polite">
                        <div>
                            <strong data-fg-obscure-active-name><?php echo esc_html($active_glass_name); ?></strong>
                            <span data-fg-obscure-active-privacy><?php echo esc_html($active_glass_privacy === 0 ? 'Decorative texture' : sprintf('Privacy %d', $active_glass_privacy)); ?></span>
                            <p data-fg-obscure-active-copy><?php echo esc_html($active_glass_copy); ?></p>
                        </div>
                        <button class="button fg-obscure-stage__background-button" type="button" data-fg-obscure-background-toggle><?php esc_html_e('Change background', 'fenster'); ?></button>
                    </div>
                </div>

                <div class="fg-obscure-mobile-picker" role="list" aria-label="<?php esc_attr_e('Obscured glass pattern options', 'fenster'); ?>" data-lenis-prevent>
                    <?php foreach (array_chunk($obscure_glass_textures, 4, true) as $obscure_glass_page) : ?>
                        <div class="fg-obscure-mobile-picker__page" aria-hidden="false">
                            <?php foreach ($obscure_glass_page as $index => $texture) : ?>
                                <?php $render_obscure_glass_option($texture, (int) $index); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="fg-obscure-rail fg-obscure-rail--right fg-obscure-picker__buttons" role="list" aria-label="<?php esc_attr_e('Obscured glass pattern options, right side', 'fenster'); ?>">
                    <?php foreach ($obscure_glass_right as $index => $texture) : ?>
                        <?php $render_obscure_glass_option($texture, (int) $index); ?>
                    <?php endforeach; ?>
                </div>

                <div class="fg-obscure-picker">
                    <div class="fg-obscure-picker__intro">
                        <p class="eyebrow"><?php esc_html_e('Interactive glass selector', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Pick a pattern, then drag the divider across the pane.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('The left side shows the treated view and the right side keeps a clear reference, so privacy levels are easier to compare.', 'fenster'); ?></p>
                    </div>
                    <div class="fg-obscure-picker__tips" aria-label="<?php esc_attr_e('How to compare Obscured glass options', 'fenster'); ?>">
                        <article>
                            <span><?php esc_html_e('1', 'fenster'); ?></span>
                            <strong><?php esc_html_e('Choose a texture', 'fenster'); ?></strong>
                            <p><?php esc_html_e('Use the pattern buttons either side of the preview to swap glass styles instantly.', 'fenster'); ?></p>
                        </article>
                        <article>
                            <span><?php esc_html_e('2', 'fenster'); ?></span>
                            <strong><?php esc_html_e('Drag the divider', 'fenster'); ?></strong>
                            <p><?php esc_html_e('Slide from fully clear to fully obscured to judge how much detail each glass hides.', 'fenster'); ?></p>
                        </article>
                        <article>
                            <span><?php esc_html_e('3', 'fenster'); ?></span>
                            <strong><?php esc_html_e('Change the scene', 'fenster'); ?></strong>
                            <p><?php esc_html_e('Switch between Legend and a house view to compare close-up privacy with real-world glazing.', 'fenster'); ?></p>
                        </article>
                    </div>
                    <?php if (! empty($obscure_glass_bottom)) : ?>
                        <div class="fg-obscure-picker__buttons" role="list" aria-label="<?php esc_attr_e('More Obscured glass pattern options', 'fenster'); ?>">
                            <?php foreach ($obscure_glass_bottom as $index => $texture) : ?>
                                <?php $render_obscure_glass_option($texture, (int) $index); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="fg-obscure-compare">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('Pattern comparison', 'fenster'); ?></p>
                    <h2><?php esc_html_e('All Obscured glass options at a glance.', 'fenster'); ?></h2>
                </div>
                <div class="fg-obscure-compare__grid">
                    <?php foreach ($obscure_glass_textures as $texture) : ?>
                        <?php $privacy = (int) ($texture['privacy'] ?? 0); ?>
                        <article>
                            <span style="<?php echo esc_attr('--texture:' . $obscure_glass_texture_value($texture) . ';'); ?>" aria-hidden="true"></span>
                            <div>
                                <h3><?php echo esc_html((string) ($texture['name'] ?? 'Glass pattern')); ?></h3>
                                <p><?php echo esc_html($privacy === 0 ? 'Decorative texture' : 'Privacy level ' . $privacy); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="fenster-enquiry" class="fg-obscure-enquiry">
            <div class="container fg-obscure-enquiry__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Glass specification', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Ask Fenster which Obscured glass works with your product.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell the team whether the glass is for a bathroom, entrance door, side panel, replacement unit or another product and they will help narrow the options.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form',
                    'source' => 'Obscured glass page',
                    'button_label' => 'Ask about Obscured glass',
                    'project_type' => 'Obscured glass',
                    'compact' => true,
                ]);
                ?>
            </div>
        </section>

        <?php if (! empty($related_links)) : ?>
            <section class="fg-links-band">
                <div class="container">
                    <div class="section-heading">
                        <p class="eyebrow"><?php esc_html_e('Related products', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Products that can use Obscured glass', 'fenster'); ?></h2>
                    </div>
                    <div class="generated-links">
                        <?php foreach (array_slice(array_values($related_links), 0, 18) as $link) : ?>
                            <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </article>
    <?php
    return;
}

$is_article = ! $is_product && ! $is_archive_page && ! $is_utility_page;

if (! $use_product_journey && $is_article) {
    get_template_part('template-parts/sections/generated-article', null, [
        'brand' => $brand,
        'hero_intro' => $hero_intro,
        'images' => $images,
        'page' => $page,
        'related_links' => $related_links,
        'sections' => $sections,
        'title' => $title,
    ]);
    return;
}

if (! $use_product_journey && ($is_archive_page || $is_utility_page || ! $is_product)) {
    get_template_part('template-parts/sections/generated-simple', null, [
        'brand' => $brand,
        'hero_intro' => $hero_intro,
        'hero_media_src' => $hero_media_src,
        'images' => $images,
        'is_archive' => $is_archive_page,
        'is_utility' => $is_utility_page,
        'page' => $page,
        'related_links' => $related_links,
        'sections' => $sections,
        'title' => $title,
    ]);
    return;
}

if ($is_commercial_hub) {
    $commercial_intro = 'Fenster supports commercial glazing packages for refurbishments, education, healthcare, office, public sector and managed buildings. Send the drawings, schedule, site photos or a short scope note and the team can review what is needed before the first specification conversation.';
    $commercial_services = [
        [
            'title' => 'Commercial windows and doors',
            'copy' => 'Aluminium and uPVC window and door packages for offices, schools, care settings and managed buildings.',
            'url' => home_url('/commercial-windows-and-doors/'),
            'image' => $asset_base . 'Airbus-Commercial.jpg',
        ],
        [
            'title' => 'Curtain walling',
            'copy' => 'Glazed facade packages shaped around structure, thermal performance, interfaces and installation sequencing.',
            'url' => home_url('/curtain-walling/'),
            'image' => $asset_base . 'curtain-walling-2.jpg',
        ],
        [
            'title' => 'Louvres and ventilation',
            'copy' => 'Louvre, airflow and screening products coordinated with the wider glazing requirement.',
            'url' => home_url('/louvre-vents/'),
            'image' => $asset_base . 'IKL33louvresystem.png',
        ],
        [
            'title' => 'AOV and automation',
            'copy' => 'Automated opening vents and controls for life-safety, ventilation and building-management requirements.',
            'url' => home_url('/commercial-automation/'),
            'image' => $asset_base . 'commercial-4.jpg',
        ],
        [
            'title' => 'Replacement glazing',
            'copy' => 'Measured replacement glass, failed-unit replacement and phased upgrade work for live commercial buildings.',
            'url' => home_url('/double-glazing-replacement/'),
            'image' => $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg',
        ],
        [
            'title' => 'Project support',
            'copy' => 'Early review of drawings, elevations, scope gaps, access constraints, performance targets and programme pressure.',
            'url' => '#commercial-enquiry',
            'image' => $asset_base . 'commercial-1.jpg',
        ],
    ];
    $commercial_proof = [
        ['value' => 'Live sites', 'label' => 'phased access, RAMS and occupied buildings'],
        ['value' => 'Drawings', 'label' => 'reviewed before survey and pricing'],
        ['value' => 'Systems', 'label' => 'windows, doors, curtain walling and louvres'],
        ['value' => 'Surveyed', 'label' => 'measured before anything is made'],
    ];
    $commercial_process = [
        ['step' => '01', 'title' => 'Send the package', 'copy' => 'Drawings, schedules, photos or a short note are enough to start the right conversation.'],
        ['step' => '02', 'title' => 'Check the constraints', 'copy' => 'Fenster reviews building type, access, programme, performance targets and likely system choices.'],
        ['step' => '03', 'title' => 'Confirm the route', 'copy' => 'Survey, specification, finishes, interfaces and installation detail are shaped before final pricing.'],
        ['step' => '04', 'title' => 'Plan delivery', 'copy' => 'Manufacture, access, sequencing and handover are planned around the real site conditions.'],
    ];
    $commercial_fit = [
        ['title' => 'Drawings or schedules are ready', 'copy' => 'Best when there is already a package to review, price or tidy into a workable specification.'],
        ['title' => 'The building is occupied', 'copy' => 'Useful for care, healthcare, education, offices and public buildings where disruption matters.'],
        ['title' => 'Several products need coordinating', 'copy' => 'Windows, doors, curtain walling, louvres, glass and finishes can be reviewed together.'],
        ['title' => 'Access or programme is tight', 'copy' => 'Send the awkward details early so lifting, phasing and survey requirements are not guessed.'],
    ];
    $commercial_projects = [
        [
            'title' => 'Barn Hotel - Coventry',
            'url' => home_url('/commercial-projects/'),
            'image' => $asset_base . 'commercial-5.jpg',
            'scope' => 'Hotel refurbishment',
            'installed' => '37 aluminium windows and commercial entrance doors',
            'site' => 'Crane-assisted lifts during shell-stage works',
        ],
        [
            'title' => 'Sunrise Care Home - Kettering',
            'url' => home_url('/commercial-projects/'),
            'image' => $asset_base . 'healthcare.jpg',
            'scope' => 'Live healthcare environment',
            'installed' => 'Replacement windows and doors',
            'site' => 'Phased work with controlled access',
        ],
        [
            'title' => 'Herts and Essex Community Hospital',
            'url' => home_url('/commercial-projects/'),
            'image' => $asset_base . 'curtain-walling-4.jpg',
            'scope' => 'Healthcare glazing replacement',
            'installed' => 'Aluminium replacement windows',
            'site' => 'Public building coordination',
        ],
    ];
    ?>
    <article class="fg-commercial-hub">
        <section class="fg-commercial-hub-hero">
            <?php if ($hero_media_src) : ?>
                <img class="fg-commercial-hub-hero__image" src="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
            <?php endif; ?>
            <div class="fg-commercial-hub-hero__shade"></div>
            <div class="container fg-commercial-hub-hero__grid">
                <div class="fg-commercial-hub-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Commercial glazing contractors', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Commercial glazing for live projects, planned refurbishments and full building packages.', 'fenster'); ?></h1>
                    <p><?php echo esc_html($commercial_intro); ?></p>
                    <div class="button-row">
                        <a class="button" href="#commercial-enquiry"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('View commercial projects', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-commercial-hub-brief" aria-label="<?php esc_attr_e('Commercial enquiry checklist', 'fenster'); ?>">
                    <span><?php esc_html_e('Fastest route to a useful reply', 'fenster'); ?></span>
                    <h2><?php esc_html_e('Send the project information you already have.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Building type and location', 'fenster'); ?></li>
                        <li><?php esc_html_e('Required systems or performance targets', 'fenster'); ?></li>
                        <li><?php esc_html_e('Programme, access or live-site constraints', 'fenster'); ?></li>
                    </ul>
                    <a class="text-link" href="#commercial-enquiry"><?php esc_html_e('Open project form', 'fenster'); ?></a>
                </aside>
            </div>
        </section>

        <section class="fg-commercial-hub-proof" aria-label="<?php esc_attr_e('Commercial proof points', 'fenster'); ?>">
            <div class="container fg-commercial-hub-proof__grid">
                <?php foreach ($commercial_proof as $item) : ?>
                    <article>
                        <strong><?php echo esc_html($item['value']); ?></strong>
                        <span><?php echo esc_html($item['label']); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="fg-commercial-products">
            <div class="container">
                <div class="fg-commercial-section-head">
                    <p class="eyebrow"><?php esc_html_e('Commercial products', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Commercial glazing products and services.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Choose the product or service area that matches your building, specification or refurbishment project.', 'fenster'); ?></p>
                </div>
                <div class="fg-commercial-products__grid">
                    <?php foreach ($commercial_services as $service) : ?>
                        <a class="fg-commercial-product-card" href="<?php echo esc_url($service['url']); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($service['image'])); ?>" alt="<?php echo esc_attr($service['title']); ?>" loading="lazy">
                            <span>
                                <strong><?php echo esc_html($service['title']); ?></strong>
                                <small><?php echo esc_html($service['copy']); ?></small>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-commercial-flow">
            <div class="container fg-commercial-flow__grid">
                <div class="fg-commercial-flow__copy">
                    <p class="eyebrow"><?php esc_html_e('How enquiries move', 'fenster'); ?></p>
                    <h2><?php esc_html_e('A practical route from brief to install.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('The aim is simple: understand the package quickly, spot missing details early and get the enquiry to the right person before time is wasted.', 'fenster'); ?></p>
                </div>
                <div class="fg-commercial-flow__steps">
                    <?php foreach ($commercial_process as $step) : ?>
                        <article>
                            <span><?php echo esc_html($step['step']); ?></span>
                            <div>
                                <h3><?php echo esc_html($step['title']); ?></h3>
                                <p><?php echo esc_html($step['copy']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-commercial-projects-preview">
            <div class="container">
                <div class="fg-commercial-section-head">
                    <p class="eyebrow"><?php esc_html_e('Project proof', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Recent commercial glazing projects.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('See examples of work completed for hotels, healthcare settings and public buildings.', 'fenster'); ?></p>
                </div>
                <div class="fg-commercial-projects-preview__grid">
                    <?php foreach ($commercial_projects as $project) : ?>
                        <a class="fg-commercial-project-card" href="<?php echo esc_url($project['url']); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($project['image'])); ?>" alt="<?php echo esc_attr($project['title']); ?>" loading="lazy">
                            <span><?php echo esc_html($project['scope']); ?></span>
                            <strong><?php echo esc_html($project['title']); ?></strong>
                            <dl>
                                <div>
                                    <dt><?php esc_html_e('Installed', 'fenster'); ?></dt>
                                    <dd><?php echo esc_html($project['installed']); ?></dd>
                                </div>
                                <div>
                                    <dt><?php esc_html_e('Site', 'fenster'); ?></dt>
                                    <dd><?php echo esc_html($project['site']); ?></dd>
                                </div>
                            </dl>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="fg-commercial-projects-preview__action">
                    <a class="button" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('View all commercial projects', 'fenster'); ?></a>
                </div>
            </div>
        </section>

        <section class="fg-commercial-sectors">
            <div class="container fg-commercial-sectors__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Where this fits', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Best-fit commercial enquiries.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('This page is for commercial projects where the details matter: drawings, access, live buildings, multiple products, programme pressure or a specification that needs checking before it becomes expensive.', 'fenster'); ?></p>
                </div>
                <div class="fg-commercial-sectors__list">
                    <?php foreach ($commercial_fit as $fit) : ?>
                        <article>
                            <strong><?php echo esc_html($fit['title']); ?></strong>
                            <span><?php echo esc_html($fit['copy']); ?></span>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="commercial-enquiry" class="fg-commercial-enquiry">
            <div class="container fg-commercial-enquiry__grid">
                <div class="fg-commercial-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Send a commercial enquiry', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send the brief. Fenster will route it properly.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Add the key site, programme and performance notes. Attach files if they explain the package better than a message can.', 'fenster'); ?></p>
                    <ul class="fg-commercial-enquiry__notes">
                        <li><?php esc_html_e('Drawings, schedules or elevations', 'fenster'); ?></li>
                        <li><?php esc_html_e('Site photos, access notes or deadlines', 'fenster'); ?></li>
                        <li><?php esc_html_e('System, colour or performance requirements', 'fenster'); ?></li>
                    </ul>
                    <div class="fg-contact-list">
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'] ?? '01908429200')); ?>"><?php echo esc_html($brand['phone'] ?? '01908 429200'); ?></a>
                        <a href="mailto:<?php echo esc_attr($brand['email'] ?? 'info@fensterglazing.com'); ?>"><?php echo esc_html($brand['email'] ?? 'info@fensterglazing.com'); ?></a>
                    </div>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-commercial-form',
                    'source' => 'Commercial glazing hub',
                    'button_label' => 'Send commercial enquiry',
                    'project_type' => 'Commercial glazing',
                    'project_options' => [
                        'Commercial glazing',
                        'Commercial windows and doors',
                        'Curtain walling',
                        'Louvres or ventilation',
                        'Automation or access',
                        'Replacement glazing',
                    ],
                    'show_company' => true,
                ]);
                ?>
            </div>
        </section>

        <?php if (! empty($related_links)) : ?>
            <section class="fg-links-band">
                <div class="container">
                    <div class="section-heading">
                        <p class="eyebrow"><?php esc_html_e('Commercial services', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Service areas and related commercial pages', 'fenster'); ?></h2>
                    </div>
                    <div class="generated-links">
                        <?php foreach (array_slice(array_values($related_links), 0, 24) as $link) : ?>
                            <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </article>
    <?php
    return;
}
?>
<article class="generated-page generated-page--<?php echo esc_attr($is_commercial ? 'commercial' : 'residential'); ?> <?php echo esc_attr($use_product_journey ? 'generated-page--product-journey' : ''); ?> <?php echo esc_attr($is_aluminium_windows ? 'generated-page--aluminium-windows-story' : ''); ?> <?php echo esc_attr($is_integral_blinds ? 'generated-page--integral-blinds-reveal' : ''); ?>">
    <?php if ($is_aluminium_windows && $aluminium_windows_story_desktop_frames) : ?>
    <section class="fg-aw-story" data-fg-aw-story style="--fg-aw-panel-count: <?php echo esc_attr((string) (count($aluminium_windows_story_panels) + 1)); ?>;">
        <div class="fg-aw-story__stage">
            <canvas
                class="fg-aw-story__canvas"
                data-fg-aw-story-canvas
                data-desktop-frame="<?php echo esc_url($aluminium_windows_story_desktop_frames); ?>"
                data-mobile-frame="<?php echo esc_url($aluminium_windows_story_mobile_frames); ?>"
                data-frame-count="241"
                aria-hidden="true"
            ></canvas>
            <noscript><img class="fg-aw-story__fallback" src="<?php echo esc_url($aluminium_windows_story_poster); ?>" alt=""></noscript>
            <div class="fg-aw-story__shade"></div>
            <div class="fg-aw-story__grain" aria-hidden="true"></div>
            <div class="container fg-aw-story__content">
                <div class="fg-aw-story__panel is-active" data-fg-aw-story-panel>
                    <p class="eyebrow"><?php esc_html_e('Fenster Glazing', 'fenster'); ?></p>
                    <h1><?php echo esc_html($title); ?></h1>
                    <p><?php echo esc_html($hero_intro); ?></p>
                    <div class="button-row">
                        <a class="button" href="#fenster-enquiry"><?php echo esc_html($cta_label); ?></a>
                        <a class="button button--light" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
                    </div>
                </div>
                <?php foreach ($aluminium_windows_story_panels as $index => $story_panel) : ?>
                    <div class="fg-aw-story__panel" data-fg-aw-story-panel aria-hidden="true">
                        <p class="eyebrow"><?php echo esc_html($story_panel['eyebrow']); ?></p>
                        <span class="fg-aw-story__number"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h2><?php echo esc_html($story_panel['heading']); ?></h2>
                        <p><?php echo esc_html($story_panel['copy']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="fg-aw-story__progress" aria-hidden="true">
                <span data-fg-aw-story-progress></span>
            </div>
            <p class="fg-aw-story__scroll-cue"><?php esc_html_e('Scroll to explore', 'fenster'); ?></p>
        </div>
    </section>
    <?php else : ?>
    <section class="fg-hero <?php echo esc_attr($use_product_journey ? 'fg-hero--compact' : ''); ?>">
        <?php if ($is_home) : ?>
            <video class="fg-hero__video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>">
                <source src="<?php echo esc_url($sick_video); ?>" type="video/mp4">
            </video>
        <?php elseif ($hero_media_src) : ?>
            <img class="fg-hero__image" src="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
        <?php endif; ?>
        <div class="fg-hero__shade"></div>
        <div class="container fg-hero__inner <?php echo esc_attr($is_home ? 'fg-hero__inner--quote' : ''); ?>">
            <div class="fg-hero__copy">
                <div class="fg-hero__heading">
                    <p class="eyebrow"><?php echo esc_html($is_commercial ? 'Commercial glazing' : 'Fenster Glazing'); ?></p>
                    <h1><?php echo esc_html($title); ?></h1>
                    <p class="fg-hero__intro"><?php echo esc_html($hero_intro); ?></p>
                </div>
                <div class="button-row">
                    <a class="button" href="#fenster-enquiry">
                        <span class="fg-hero-cta__full"><?php echo esc_html($cta_label); ?></span>
                        <span class="fg-hero-cta__short"><?php esc_html_e('Design consultation', 'fenster'); ?></span>
                    </a>
                    <a class="button button--light" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
                </div>
            </div>
            <?php if ($is_home) : ?>
                <aside class="fg-home-hero-3d" aria-label="<?php esc_attr_e('Interactive window and door scene', 'fenster'); ?>">
                    <canvas data-fg-home-3d></canvas>
                    <div class="fg-home-hero-3d__hud">
                        <span><?php esc_html_e('Live 3D system preview', 'fenster'); ?></span>
                        <strong><?php esc_html_e('Windows. Doors. Bifolds.', 'fenster'); ?></strong>
                        <small><?php esc_html_e('Move your mouse or scroll to shift the scene.', 'fenster'); ?></small>
                    </div>
                </aside>
            <?php else : ?>
                <aside class="fg-hero__panel fg-hero-card" aria-label="<?php esc_attr_e('Project enquiry', 'fenster'); ?>">
                    <p class="fg-hero-card__kicker"><?php esc_html_e('Start here', 'fenster'); ?></p>
                    <h2><?php echo esc_html($is_commercial ? 'Get a specification conversation moving.' : 'Get pricing or book a design chat.'); ?></h2>
                    <div class="fg-hero-card__logos">
                        <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/google-5-stars.png'); ?>" alt="<?php esc_attr_e('Google five star reviews', 'fenster'); ?>">
                        <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/fensa.png'); ?>" alt="<?php esc_attr_e('FENSA approved', 'fenster'); ?>">
                    </div>
                    <div class="fg-hero-form">
                        <a class="button" href="#fenster-enquiry"><?php esc_html_e('Start your project', 'fenster'); ?></a>
                        <a class="text-link" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Use the instant quote tool', 'fenster'); ?></a>
                    </div>
                </aside>
            <?php endif; ?>
            <?php if ($product_scroll_video_src) : ?>
                <div class="fg-product-traveller-start" data-fg-product-video-start aria-hidden="true"></div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($is_integral_blinds && $integral_blinds_reveal_video) : ?>
        <div class="fg-integral-blinds-reveal" data-fg-integral-blinds-reveal aria-hidden="true">
            <canvas class="fg-integral-blinds-reveal__canvas" data-fg-integral-blinds-canvas aria-hidden="true"></canvas>
            <video
                class="fg-integral-blinds-reveal__video"
                data-fg-integral-blinds-video
                data-src="<?php echo esc_url($integral_blinds_reveal_video); ?>"
                preload="none"
                muted
                playsinline
            ></video>
            <div class="fg-integral-blinds-reveal__cue">
                <span><?php esc_html_e('Scroll to open the blinds', 'fenster'); ?></span>
                <i></i>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($is_home) : ?>
        <section class="fg-home-proof">
            <div class="container fg-home-proof__grid">
                <div class="fg-home-proof__metric">
                    <span>10 year</span>
                    <small><?php esc_html_e('insurance-backed guarantee', 'fenster'); ?></small>
                </div>
                <div class="fg-home-proof__metric">
                    <span>1,000+</span>
                    <small><?php esc_html_e('installations completed', 'fenster'); ?></small>
                </div>
                <div class="fg-home-proof__metric">
                    <span>200+</span>
                    <small><?php esc_html_e('five-star reviews', 'fenster'); ?></small>
                </div>
                <div class="fg-home-proof__logos">
                    <?php foreach ($trust_items as $item) : ?>
                        <img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" loading="lazy">
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-home-parallax">
            <div class="container fg-home-parallax__grid">
                <div class="fg-home-parallax__copy">
                    <p class="eyebrow"><?php esc_html_e('Built for real properties', 'fenster'); ?></p>
                    <h2><?php esc_html_e('A glazing site that moves like the products do.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('The new homepage is designed around decisions: what you want to install, how it performs, how it looks, and how quickly you can get from idea to quote.', 'fenster'); ?></p>
                </div>
                <div class="fg-home-parallax__stack" data-parallax-stack>
                    <?php foreach ($home_showcase as $index => $item) : ?>
                        <article style="--shift: <?php echo esc_attr((string) ($index + 1)); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($item['image'])); ?>" alt="<?php echo esc_attr($item['label']); ?>" loading="lazy">
                            <div>
                                <h3><?php echo esc_html($item['label']); ?></h3>
                                <p><?php echo esc_html($item['copy']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-home-services fg-home-services--mad">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('Pick the product path', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Eight routes into the right glazing system.', 'fenster'); ?></h2>
                </div>
                <div class="fg-home-services__grid">
                    <?php foreach ($home_categories as $category) : ?>
                        <a class="fg-service-tile" href="<?php echo esc_url($category['url']); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($category['image'])); ?>" alt="<?php echo esc_attr($category['label']); ?>" loading="lazy">
                            <span>
                                <strong><?php echo esc_html($category['label']); ?></strong>
                                <small><?php echo esc_html($category['copy']); ?></small>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-home-quote-lab">
            <div class="container fg-home-quote-lab__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Instant quote lab', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Use the visualiser when the site is on the live Fenster domain.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('The preview shows the product selector journey. On the live domain, this route can hand customers into the WindowCAD retail designer for product selection and instant pricing.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="<?php echo esc_url($instant_quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Launch instant quote', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('View quote page', 'fenster'); ?></a>
                    </div>
                </div>
                <figure class="fg-home-quote-lab__preview">
                    <img src="<?php echo esc_url($instant_quote_preview); ?>" alt="<?php esc_attr_e('Instant quote product selector preview', 'fenster'); ?>" loading="lazy">
                </figure>
            </div>
        </section>

        <section class="fg-home-process">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('From idea to install', 'fenster'); ?></p>
                    <h2><?php esc_html_e('A clearer journey for residential and commercial projects.', 'fenster'); ?></h2>
                </div>
                <div class="fg-home-process__rail">
                    <?php foreach ($home_process as $item) : ?>
                        <article>
                            <span><?php echo esc_html($item['step']); ?></span>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="fenster-enquiry" class="fg-home-final">
            <div class="container fg-home-final__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Ready when you are', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell Fenster what you want to change.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Windows, doors, bifolds, lanterns, integral blinds, replacement glass and commercial glazing all start with the same thing: a clear conversation.', 'fenster'); ?></p>
                    <div class="fg-contact-list">
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'] ?? '01908429200')); ?>"><?php echo esc_html($brand['phone'] ?? '01908 429200'); ?></a>
                        <a href="mailto:<?php echo esc_attr($brand['email'] ?? 'info@fensterglazing.com'); ?>"><?php echo esc_html($brand['email'] ?? 'info@fensterglazing.com'); ?></a>
                    </div>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form',
                    'source' => 'Legacy generated homepage section',
                    'button_label' => 'Start conversation',
                ]);
                ?>
            </div>
        </section>

        <?php if (! empty($related_links)) : ?>
            <section class="fg-links-band">
                <div class="container">
                    <div class="section-heading">
                        <p class="eyebrow"><?php esc_html_e('Keep exploring', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Core routes and service areas', 'fenster'); ?></h2>
                    </div>
                    <div class="generated-links">
                        <?php foreach (array_slice(array_values($related_links), 0, 24) as $link) : ?>
                            <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </article>
    <?php return; ?>
    <?php endif; ?>

    <?php if (! $use_product_journey) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--generated',
            'eyebrow' => 'Customer proof',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>

    <?php if ($is_home) : ?>
        <section class="fg-home-services">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('What we install', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose the route that matches your project.', 'fenster'); ?></h2>
                </div>
                <div class="fg-home-services__grid">
                    <?php foreach ($home_categories as $category) : ?>
                        <a class="fg-service-tile" href="<?php echo esc_url($category['url']); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($category['image'])); ?>" alt="<?php echo esc_attr($category['label']); ?>" loading="lazy">
                            <span>
                                <strong><?php echo esc_html($category['label']); ?></strong>
                                <small><?php echo esc_html($category['copy']); ?></small>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="fg-quote-callout">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Design your products and get an instant price.', 'fenster'); ?></h2>
                    </div>
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Open instant quote', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($use_product_journey && count($product_usps) === 4) : ?>
        <section class="fg-product-pulse fg-product-pulse--usps" aria-label="<?php echo esc_attr($title . ' key specifications'); ?>">
            <div class="container fg-product-pulse__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Key specifications', 'fenster'); ?></p>
                    <h2><?php echo esc_html($title); ?></h2>
                </div>
                <ul aria-label="<?php esc_attr_e('Four product specifications', 'fenster'); ?>">
                    <?php foreach ($product_usps as $usp) : ?>
                        <li>
                            <small><?php echo esc_html($usp['label'] ?? ''); ?></small>
                            <strong><?php echo esc_html($usp['value'] ?? ''); ?></strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php elseif (! $use_product_journey) : ?>
        <section class="fg-intent-band">
            <div class="container fg-intent">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Built around the decision', 'fenster'); ?></p>
                    <h2><?php echo esc_html($journey_intro_heading); ?></h2>
                </div>
                <p><?php echo esc_html($journey_intro_copy); ?></p>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($sash_roseview_models)) : ?>
        <section class="fg-sash-collection" aria-labelledby="fg-sash-collection-title">
            <div class="container">
                <div class="fg-sash-collection__hero">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Roseview sash systems', 'fenster'); ?></p>
                        <h2 id="fg-sash-collection-title"><?php esc_html_e('Choose the sash window by detail level, not just by name.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Ultimate, Heritage and Charisma Rose all give a vertical sliding sash format. The important differences are the meeting rail, corner construction, horns, cills, glazing depth and how closely the window needs to reproduce timber.', 'fenster'); ?></p>
                    </div>
                    <aside class="fg-sash-collection__note">
                        <span><?php esc_html_e('Fenster survey note', 'fenster'); ?></span>
                        <p><?php esc_html_e('We confirm the final model, colour, bar layout, horn detail, ventilation route and hardware before order so the sash suits the property rather than just the brochure.', 'fenster'); ?></p>
                    </aside>
                </div>

                <div class="fg-sash-models" aria-label="<?php esc_attr_e('Roseview sash model comparison', 'fenster'); ?>">
                    <?php foreach ($sash_roseview_models as $index => $model) : ?>
                        <article class="fg-sash-model">
                            <figure class="fg-sash-model__media" data-fg-depth="<?php echo esc_attr($index === 1 ? '0.045' : '0.065'); ?>">
                                <img src="<?php echo esc_url(fenster_generated_url((string) $model['image'])); ?>" alt="<?php echo esc_attr((string) $model['alt']); ?>" loading="lazy">
                            </figure>
                            <div class="fg-sash-model__body">
                                <span><?php echo esc_html((string) $model['tagline']); ?></span>
                                <h3><?php echo esc_html((string) $model['name']); ?></h3>
                                <p><?php echo esc_html((string) $model['copy']); ?></p>
                                <div class="fg-sash-model__best">
                                    <small><?php esc_html_e('Best for', 'fenster'); ?></small>
                                    <strong><?php echo esc_html((string) $model['best_for']); ?></strong>
                                </div>
                                <dl>
                                    <?php foreach ($model['specs'] as $spec) : ?>
                                        <div>
                                            <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                                            <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="fg-sash-spec-table" aria-label="<?php esc_attr_e('Roseview sash model specification comparison', 'fenster'); ?>">
                    <div class="fg-sash-spec-table__row fg-sash-spec-table__row--head">
                        <span><?php esc_html_e('Difference', 'fenster'); ?></span>
                        <strong><?php esc_html_e('Ultimate Rose', 'fenster'); ?></strong>
                        <strong><?php esc_html_e('Heritage Rose', 'fenster'); ?></strong>
                        <strong><?php esc_html_e('Charisma Rose', 'fenster'); ?></strong>
                    </div>
                    <?php
                    $sash_comparison_rows = [
                        ['Meeting rail', '35mm', '44.5mm', '60mm'],
                        ['Corner detail', 'Mechanical joints', 'Welded joints', 'Welded joints'],
                        ['Frame depth', '137mm', '137mm', '125mm'],
                        ['Glass unit', '28mm IGU', '28mm IGU', '24mm IGU'],
                        ['Energy rating', 'A rated', 'A rated', 'A rated'],
                        ['ThermoVFlex route', '1.2 W/m2K option', '1.2 W/m2K option', 'Confirm at survey'],
                    ];
                    ?>
                    <?php foreach ($sash_comparison_rows as $row) : ?>
                        <div class="fg-sash-spec-table__row">
                            <?php foreach ($row as $cell_index => $cell) : ?>
                                <?php if ($cell_index === 0) : ?>
                                    <span><?php echo esc_html($cell); ?></span>
                                <?php else : ?>
                                    <p><?php echo esc_html($cell); ?></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-sash-detail-run">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('The visible differences', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Small sash details decide whether the window reads modern, traditional or genuinely timber-like.', 'fenster'); ?></h2>
                </div>
                <div class="fg-sash-detail-run__items">
                    <?php foreach ($sash_roseview_details as $index => $detail) : ?>
                        <article class="fg-sash-detail <?php echo $index % 2 === 1 ? 'fg-sash-detail--flip fg-sash-detail--joint' : ''; ?>">
                            <figure data-fg-depth="0.08">
                                <img src="<?php echo esc_url(fenster_generated_url((string) $detail['image'])); ?>" alt="<?php echo esc_attr((string) $detail['alt']); ?>" loading="lazy">
                            </figure>
                            <div>
                                <p class="eyebrow"><?php echo esc_html((string) $detail['eyebrow']); ?></p>
                                <h3><?php echo esc_html((string) $detail['title']); ?></h3>
                                <p><?php echo esc_html((string) $detail['copy']); ?></p>
                                <ul class="<?php echo $index % 2 === 1 ? 'fg-sash-detail__comparison' : ''; ?>">
                                    <?php foreach ($detail['points'] as $point) : ?>
                                        <li><?php echo esc_html((string) $point); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="fg-sash-feature-strip">
                    <?php foreach ($sash_roseview_feature_cards as $card) : ?>
                        <article>
                            <h3><?php echo esc_html((string) $card['title']); ?></h3>
                            <p><?php echo esc_html((string) $card['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($use_product_journey) : ?>
        <section class="fg-product-why">
            <div class="container fg-product-why__grid">
                <?php if (is_array($product_why_image) && ! empty($product_why_image['src'])) : ?>
                    <div class="fg-product-why__media-stack">
                        <figure class="fg-product-why__media fg-product-why__media--primary">
                            <?php if ($product_scroll_video_src) : ?>
                                <video class="fg-product-traveller-final" data-fg-product-video-final muted playsinline preload="auto" aria-label="<?php echo esc_attr($title . ' product animation'); ?>">
                                    <?php foreach ($product_scroll_video_sources as $product_scroll_video_source) : ?>
                                        <source src="<?php echo esc_url($product_scroll_video_source['src']); ?>" type="<?php echo esc_attr($product_scroll_video_source['type']); ?>">
                                    <?php endforeach; ?>
                                </video>
                            <?php endif; ?>
                            <img src="<?php echo esc_url(fenster_generated_url($product_why_image['src'])); ?>" alt="<?php echo esc_attr($product_why_image['alt'] ?? $title); ?>" loading="lazy">
                            <figcaption>
                                <span><?php esc_html_e('Fenster specification', 'fenster'); ?></span>
                                <strong><?php echo esc_html($title); ?></strong>
                            </figcaption>
                        </figure>
                        <?php if (! empty($gallery_images[1]['src'])) : ?>
                            <figure class="fg-product-why__media fg-product-why__media--secondary">
                                <img src="<?php echo esc_url(fenster_generated_url($gallery_images[1]['src'])); ?>" alt="<?php echo esc_attr($gallery_images[1]['alt'] ?? $title); ?>" loading="lazy">
                            </figure>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="fg-product-why__content">
                    <p class="eyebrow"><?php echo esc_html($journey_why_eyebrow); ?></p>
                    <h2><?php echo esc_html($journey_why_heading); ?></h2>
                    <p><?php echo esc_html($hero_intro); ?></p>
                    <div class="fg-product-why__accordion">
                        <?php foreach (array_slice($product_benefits, 0, 5) as $index => $benefit) : ?>
                            <details <?php echo $index === 0 ? 'open' : ''; ?>>
                                <summary>
                                    <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                    <?php echo esc_html($benefit['title']); ?>
                                </summary>
                                <div class="fg-product-why__answer">
                                    <p><?php echo esc_html($benefit['copy']); ?></p>
                                </div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                    <a class="button" href="#fenster-enquiry"><?php echo esc_html($journey_why_button); ?></a>
                </div>
                <div class="fg-product-why__panel" hidden>
                    <?php foreach (array_slice($product_benefits, 0, 6) as $index => $benefit) : ?>
                        <article>
                            <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <h3><?php echo esc_html($benefit['title']); ?></h3>
                            <p><?php echo esc_html($benefit['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php if (! empty($product_hub_specs) || ! empty($product_hub_choices)) : ?>
            <section class="fg-product-intel">
                <div class="container fg-product-intel__shell">
                    <div class="fg-product-intel__lead">
                        <div class="fg-product-intel__intro">
                            <p class="eyebrow"><?php echo esc_html((string) ($product_hub['eyebrow'] ?? 'Product information hub')); ?></p>
                            <h2><?php echo esc_html((string) ($product_hub['heading'] ?? 'The details worth checking before you choose.')); ?></h2>
                            <p><?php echo esc_html((string) ($product_hub['copy'] ?? 'Fenster confirms the final product specification after survey so each window, door or glazing unit is matched to the property.')); ?></p>

                            <?php if (! empty($product_hub_systems) || ! empty($product_hub_badges)) : ?>
                                <div class="fg-product-intel__badges" aria-label="<?php esc_attr_e('Product systems and highlights', 'fenster'); ?>">
                                    <?php foreach ($product_hub_systems as $system) : ?>
                                        <?php
                                        $system_label = trim((string) ($system['label'] ?? ''));
                                        $system_logo = trim((string) ($system['logo'] ?? ''));
                                        ?>
                                        <?php if ($system_label !== '' || $system_logo !== '') : ?>
                                            <span class="fg-product-intel__badge fg-product-intel__badge--system">
                                                <?php if ($system_logo !== '') : ?>
                                                    <img src="<?php echo esc_url(fenster_generated_url($system_logo)); ?>" alt="<?php echo esc_attr((string) ($system['alt'] ?? $system_label)); ?>" loading="lazy">
                                                <?php else : ?>
                                                    <?php echo esc_html($system_label); ?>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($product_hub_badges as $badge) : ?>
                                        <?php if (is_array($badge)) : ?>
                                            <?php
                                            $badge_label = trim((string) ($badge['label'] ?? ''));
                                            $badge_image = trim((string) ($badge['image'] ?? ''));
                                            ?>
                                            <?php if ($badge_label !== '' || $badge_image !== '') : ?>
                                                <span class="fg-product-intel__badge fg-product-intel__badge--technology">
                                                    <?php if ($badge_image !== '') : ?>
                                                        <img src="<?php echo esc_url($badge_image); ?>" alt="<?php echo esc_attr((string) ($badge['alt'] ?? $badge_label)); ?>" loading="lazy">
                                                    <?php else : ?>
                                                        <?php echo esc_html($badge_label); ?>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php elseif (trim((string) $badge) !== '') : ?>
                                            <span class="fg-product-intel__badge"><?php echo esc_html((string) $badge); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (is_array($product_hub_image) && ! empty($product_hub_image['src'])) : ?>
                            <figure class="fg-product-intel__media">
                                <img src="<?php echo esc_url(fenster_generated_url((string) $product_hub_image['src'])); ?>" alt="<?php echo esc_attr((string) ($product_hub_image['alt'] ?? $title)); ?>" loading="lazy">
                                <figcaption>
                                    <span><?php esc_html_e('Product view', 'fenster'); ?></span>
                                    <strong><?php echo esc_html($title); ?></strong>
                                </figcaption>
                            </figure>
                        <?php endif; ?>
                    </div>

                    <?php if (! empty($product_hub_specs)) : ?>
                        <?php $product_hub_spec_count = min(6, count($product_hub_specs)); ?>
                        <div class="fg-product-intel__explorer" data-fg-product-intel>
                            <?php if ($product_hub_spec_count > 2) : ?>
                                <p class="fg-product-intel__nav-hint">
                                    <?php echo esc_html(sprintf(__('Swipe to see all %d product checks.', 'fenster'), $product_hub_spec_count)); ?>
                                </p>
                            <?php endif; ?>
                            <div class="fg-product-intel__nav" role="tablist" aria-label="<?php esc_attr_e('Product specification topics', 'fenster'); ?>">
                                <?php foreach (array_slice($product_hub_specs, 0, 6) as $index => $spec) : ?>
                                    <?php
                                    $spec_label = trim((string) ($spec['label'] ?? 'Specification'));
                                    $tab_id = 'fg-product-intel-tab-' . $slug . '-' . $index;
                                    $panel_id = 'fg-product-intel-panel-' . $slug . '-' . $index;
                                    ?>
                                    <button
                                        id="<?php echo esc_attr($tab_id); ?>"
                                        class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                        type="button"
                                        role="tab"
                                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                        aria-controls="<?php echo esc_attr($panel_id); ?>"
                                        tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                                        data-fg-product-intel-tab
                                    >
                                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                        <strong><?php echo esc_html($spec_label); ?></strong>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <div class="fg-product-intel__stage">
                                <?php foreach (array_slice($product_hub_specs, 0, 6) as $index => $spec) : ?>
                                    <?php
                                    $spec_label = trim((string) ($spec['label'] ?? 'Specification'));
                                    $spec_value = trim((string) ($spec['value'] ?? ''));
                                    $tab_id = 'fg-product-intel-tab-' . $slug . '-' . $index;
                                    $panel_id = 'fg-product-intel-panel-' . $slug . '-' . $index;
                                    ?>
                                    <article
                                        id="<?php echo esc_attr($panel_id); ?>"
                                        class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                        role="tabpanel"
                                        aria-labelledby="<?php echo esc_attr($tab_id); ?>"
                                        <?php echo $index === 0 ? '' : 'hidden'; ?>
                                        data-fg-product-intel-panel
                                    >
                                        <p class="eyebrow"><?php echo esc_html($spec_label); ?></p>
                                        <?php if ($spec_value !== '') : ?>
                                            <h3><?php echo esc_html($spec_value); ?></h3>
                                        <?php endif; ?>
                                        <p><?php esc_html_e('Fenster checks this during the survey and quotation stage so the final specification suits the property, budget, opening style and performance target.', 'fenster'); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($product_hub_choices)) : ?>
                        <div class="fg-product-intel__choices-strip">
                            <span><?php esc_html_e('Common choices', 'fenster'); ?></span>
                            <ul>
                                <?php foreach ($product_hub_choices as $choice) : ?>
                                    <?php if (trim((string) $choice) !== '') : ?>
                                        <li><?php echo esc_html((string) $choice); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($product_hub_choices)) : ?>
                        <aside class="fg-product-intel__summary">
                            <?php if (is_array($product_hub_support_image) && ! empty($product_hub_support_image['src'])) : ?>
                                <figure class="fg-product-intel__summary-image">
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $product_hub_support_image['src'])); ?>" alt="<?php echo esc_attr((string) ($product_hub_support_image['alt'] ?? $title)); ?>" loading="lazy">
                                </figure>
                            <?php endif; ?>
                            <div>
                                <span><?php esc_html_e('At survey', 'fenster'); ?></span>
                                <p><?php esc_html_e('Fenster checks the selected profile, opening style, colour, glass, hardware and installation details before anything is ordered.', 'fenster'); ?></p>
                            </div>
                            <a class="button" href="#fenster-enquiry"><?php esc_html_e('Ask about this specification', 'fenster'); ?></a>
                        </aside>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (! empty($product_glass_styles)) : ?>
            <section class="fg-composite-glass">
                <div class="container">
                    <div class="fg-composite-glass__head">
                        <div>
                            <p class="eyebrow"><?php esc_html_e('Composite door glass styles', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Decorative glass, shown before you commit.', 'fenster'); ?></h2>
                        </div>
                        <p><?php echo esc_html((string) ($product_content['glass_styles']['intro'] ?? 'Choose from decorative and privacy glass options for your composite door.')); ?></p>
                    </div>

                    <div class="fg-composite-glass__grid" aria-label="<?php esc_attr_e('Composite door decorative glass style options', 'fenster'); ?>">
                        <?php foreach ($product_glass_styles as $style) : ?>
                            <?php
                            $glass_name = trim((string) ($style['name'] ?? 'Glass style'));
                            $glass_image = trim((string) ($style['image'] ?? ''));
                            $glass_copy = trim((string) ($style['copy'] ?? ''));
                            ?>
                            <?php if ($glass_name !== '') : ?>
                                <article class="fg-composite-glass-card">
                                    <?php if ($glass_image !== '') : ?>
                                        <figure>
                                            <img src="<?php echo esc_url(fenster_generated_url($glass_image)); ?>" alt="<?php echo esc_attr($glass_name . ' decorative glass for composite doors'); ?>" loading="lazy">
                                        </figure>
                                    <?php endif; ?>
                                    <div>
                                        <h3><?php echo esc_html($glass_name); ?></h3>
                                        <?php if ($glass_copy !== '') : ?>
                                            <p><?php echo esc_html($glass_copy); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <?php if (! empty($product_content['glass_styles']['note'])) : ?>
                        <p class="fg-composite-glass__note"><?php echo esc_html((string) $product_content['glass_styles']['note']); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (count($product_visual_gallery) >= 4) : ?>
            <section class="fg-product-visuals">
                <div class="container fg-product-visuals__grid">
                    <div class="fg-product-visuals__mosaic" aria-label="<?php echo esc_attr($title . ' image gallery'); ?>">
                        <?php foreach (array_slice($product_visual_gallery, 0, 4) as $index => $image) : ?>
                            <figure>
                                <img src="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="eager">
                            </figure>
                        <?php endforeach; ?>
                    </div>
                    <aside class="fg-product-visuals__copy">
                        <p class="eyebrow"><?php esc_html_e('Product gallery', 'fenster'); ?></p>
                        <h2><?php echo esc_html($product_gallery_heading); ?></h2>
                        <p><?php echo esc_html($product_gallery_copy); ?></p>
                        <ul>
                            <li><?php esc_html_e('Installed product examples and close-up details from verified supplier imagery.', 'fenster'); ?></li>
                            <li><?php esc_html_e('Useful for comparing frame depth, glass area, opening style and colour direction.', 'fenster'); ?></li>
                            <li><?php esc_html_e('Matched to the product family so the page stays visually accurate.', 'fenster'); ?></li>
                        </ul>
                        <a class="button" href="#fenster-enquiry"><?php esc_html_e('Ask about this product', 'fenster'); ?></a>
                    </aside>
                </div>
            </section>
        <?php endif; ?>

        <section class="fg-product-gallery-band">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('Specification choices', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Move from the product into the details that make it yours.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Colours, privacy glass and hardware now live in focused guides so the product pages stay useful instead of turning into endless finish catalogues.', 'fenster'); ?></p>
                </div>
                <div class="fg-product-choice-map">
                    <div class="fg-product-options fg-product-options--hub">
                    <a
                        class="fg-product-option-card fg-product-option-card--colour"
                        href="<?php echo esc_url(home_url('/colour-options/')); ?>"
                    >
                        <span><?php esc_html_e('01', 'fenster'); ?></span>
                        <h3><?php esc_html_e('Frame colours', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Compare uPVC foils, aluminium powder-coated finishes, dual colour and RAL-matched options.', 'fenster'); ?></p>
                        <strong><?php esc_html_e('Open colour hub', 'fenster'); ?></strong>
                    </a>
                    <a
                        class="fg-product-option-card fg-product-option-card--glass"
                        href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"
                    >
                        <span><?php esc_html_e('02', 'fenster'); ?></span>
                        <h3><?php esc_html_e('Privacy glass', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Preview Obscured glass patterns and privacy levels using the dedicated visualiser page.', 'fenster'); ?></p>
                        <strong><?php esc_html_e('Compare glass patterns', 'fenster'); ?></strong>
                    </a>
                    <?php if (! $show_sash_furniture && ! $show_window_handles && ! $show_door_handles) : ?>
                        <a class="fg-product-option-card fg-product-option-card--quote" href="<?php echo esc_url($product_quote_link); ?>">
                            <span><?php esc_html_e('03', 'fenster'); ?></span>
                            <h3><?php esc_html_e('Quote options', 'fenster'); ?></h3>
                            <p><?php esc_html_e('Use the quote route to combine sizes, layouts, colour and optional extras into a starting price.', 'fenster'); ?></p>
                            <strong><?php esc_html_e('Start pricing', 'fenster'); ?></strong>
                        </a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php if ($show_sash_furniture && ! empty($sash_furniture_ranges)) : ?>
            <section id="fenster-sash-furniture" class="fg-sash-furniture">
                <div class="container">
                    <div class="fg-sash-furniture__head">
                        <div>
                            <p class="eyebrow"><?php esc_html_e('Sash window furniture', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Locks, pole eyes and sash lifts matched to the Rose model.', 'fenster'); ?></h2>
                        </div>
                        <?php if (! empty($sash_furniture['intro'])) : ?>
                            <p><?php echo esc_html((string) $sash_furniture['intro']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="fg-sash-furniture__ranges" aria-label="<?php esc_attr_e('Roseview sash furniture options', 'fenster'); ?>">
                        <?php foreach ($sash_furniture_ranges as $range) : ?>
                            <?php
                            $range_items = is_array($range['items'] ?? null) ? array_values($range['items']) : [];
                            $range_name = (string) ($range['name'] ?? 'Sash furniture');
                            ?>
                            <article class="fg-sash-furniture__range">
                                <div class="fg-sash-furniture__range-copy">
                                    <span><?php echo esc_html((string) ($range['tagline'] ?? 'Roseview sash furniture')); ?></span>
                                    <h3><?php echo esc_html($range_name); ?></h3>
                                    <?php if (! empty($range['model'])) : ?>
                                        <p class="fg-sash-furniture__model"><?php echo esc_html((string) $range['model']); ?></p>
                                    <?php endif; ?>
                                    <?php if (! empty($range['copy'])) : ?>
                                        <p><?php echo esc_html((string) $range['copy']); ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if (! empty($range_items)) : ?>
                                    <div class="fg-sash-furniture__items">
                                        <?php foreach ($range_items as $item) : ?>
                                            <?php
                                            $item_name = (string) ($item['name'] ?? 'Sash furniture item');
                                            $item_image = (string) ($item['image'] ?? '');
                                            ?>
                                            <figure>
                                                <?php if ($item_image !== '') : ?>
                                                    <img src="<?php echo esc_url(fenster_generated_url($item_image)); ?>" alt="<?php echo esc_attr($item_name . ' for Roseview sash windows'); ?>" loading="lazy">
                                                <?php endif; ?>
                                                <figcaption><?php echo esc_html($item_name); ?></figcaption>
                                            </figure>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="fg-sash-furniture__notes">
                        <?php if (! empty($sash_furniture['width_rule']) && is_array($sash_furniture['width_rule'])) : ?>
                            <article>
                                <span><?php esc_html_e('Width rule', 'fenster'); ?></span>
                                <h3><?php echo esc_html((string) ($sash_furniture['width_rule']['title'] ?? 'Furniture count changes by sash width')); ?></h3>
                                <p><?php echo esc_html((string) ($sash_furniture['width_rule']['copy'] ?? '')); ?></p>
                            </article>
                        <?php endif; ?>
                        <?php if (! empty($sash_furniture['finish_note'])) : ?>
                            <article>
                                <span><?php esc_html_e('Finish check', 'fenster'); ?></span>
                                <h3><?php esc_html_e('Gold, chrome and white routes.', 'fenster'); ?></h3>
                                <p><?php echo esc_html((string) $sash_furniture['finish_note']); ?></p>
                            </article>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($show_window_handles && ! empty($window_handle_finishes)) : ?>
            <section id="fenster-window-handles" class="fg-window-handles" data-fg-window-handles>
                <div class="container">
                    <div class="fg-window-handles__shell">
                        <div class="fg-window-handles__intro">
                            <p class="eyebrow"><?php esc_html_e('Window handles', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Handle finish, locking and detail in one choice.', 'fenster'); ?></h2>
                            <?php if (! empty($window_handles['intro'])) : ?>
                                <p><?php echo esc_html((string) $window_handles['intro']); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="fg-window-handles__visual" aria-live="polite">
                            <?php foreach ($window_handle_finishes as $index => $finish) : ?>
                                <?php $finish_name = (string) ($finish['name'] ?? 'Handle finish'); ?>
                                <img
                                    src="<?php echo esc_url(fenster_generated_url((string) ($finish['image'] ?? ''))); ?>"
                                    alt="<?php echo esc_attr('S2 Signature window handle in ' . strtolower($finish_name)); ?>"
                                    loading="lazy"
                                    data-fg-handle-image="<?php echo esc_attr((string) $index); ?>"
                                    class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                >
                            <?php endforeach; ?>
                        </div>

                        <div class="fg-window-handles__chooser">
                            <div class="fg-window-handles__swatches" role="list" aria-label="<?php esc_attr_e('Handle finish options', 'fenster'); ?>">
                                <?php foreach ($window_handle_finishes as $index => $finish) : ?>
                                    <button
                                        type="button"
                                        role="listitem"
                                        class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                        style="<?php echo esc_attr('--swatch:' . (string) ($finish['hex'] ?? '#ffffff')); ?>"
                                        data-fg-handle-finish="<?php echo esc_attr((string) $index); ?>"
                                        aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                    >
                                        <i aria-hidden="true"></i>
                                        <span><?php echo esc_html((string) ($finish['name'] ?? 'Finish')); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <div class="fg-window-handles__finish-copy">
                                <?php foreach ($window_handle_finishes as $index => $finish) : ?>
                                    <article data-fg-handle-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                                        <span><?php echo esc_html((string) ($finish['label'] ?? $finish['name'] ?? 'Handle finish')); ?></span>
                                        <p><?php echo esc_html((string) ($finish['copy'] ?? '')); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>

                            <?php if (! empty($window_handles['technical']) && is_array($window_handles['technical'])) : ?>
                                <aside class="fg-window-handles__details" aria-label="<?php esc_attr_e('Technical specification', 'fenster'); ?>">
                                    <div class="fg-window-handles__details-card">
                                        <h3><?php esc_html_e('Technical specification', 'fenster'); ?></h3>
                                        <div class="fg-window-handles__detail-panel">
                                            <?php if (! empty($window_handles['technical_intro'])) : ?>
                                                <p><?php echo esc_html((string) $window_handles['technical_intro']); ?></p>
                                            <?php endif; ?>
                                            <dl class="fg-window-handles__specs">
                                                <?php foreach ($window_handles['technical'] as $spec) : ?>
                                                    <div>
                                                        <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                                                        <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                                                    </div>
                                                <?php endforeach; ?>
                                            </dl>
                                        </div>
                                    </div>
                                </aside>
                            <?php endif; ?>
                        </div>

                        <?php if (! empty($window_handles['features']) && is_array($window_handles['features'])) : ?>
                            <div class="fg-window-handles__features" aria-label="<?php esc_attr_e('Window handle features', 'fenster'); ?>">
                                <?php foreach ($window_handles['features'] as $feature) : ?>
                                    <article>
                                        <h3><?php echo esc_html((string) ($feature['title'] ?? '')); ?></h3>
                                        <p><?php echo esc_html((string) ($feature['copy'] ?? '')); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($show_door_handles && ! empty($door_handle_finishes)) : ?>
            <section id="fenster-door-handles" class="fg-window-handles fg-door-handles" data-fg-window-handles>
                <div class="container">
                    <div class="fg-window-handles__shell">
                        <div class="fg-window-handles__intro">
                            <p class="eyebrow"><?php esc_html_e('Door handles', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Choose the handle finish with the door, not after it.', 'fenster'); ?></h2>
                            <?php if (! empty($door_handles['intro'])) : ?>
                                <p><?php echo esc_html((string) $door_handles['intro']); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="fg-window-handles__visual" aria-live="polite">
                            <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                <?php $finish_name = (string) ($finish['name'] ?? 'Door handle finish'); ?>
                                <img
                                    src="<?php echo esc_url(fenster_generated_url((string) ($finish['image'] ?? ''))); ?>"
                                    alt="<?php echo esc_attr('Long-plate door handle in ' . strtolower($finish_name)); ?>"
                                    loading="lazy"
                                    data-fg-handle-image="<?php echo esc_attr((string) $index); ?>"
                                    class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                >
                            <?php endforeach; ?>
                        </div>

                        <div class="fg-window-handles__chooser">
                            <div class="fg-window-handles__swatches" role="list" aria-label="<?php esc_attr_e('Door handle finish options', 'fenster'); ?>">
                                <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                    <button
                                        type="button"
                                        role="listitem"
                                        class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                                        style="<?php echo esc_attr('--swatch:' . (string) ($finish['hex'] ?? '#ffffff')); ?>"
                                        data-fg-handle-finish="<?php echo esc_attr((string) $index); ?>"
                                        aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                    >
                                        <i aria-hidden="true"></i>
                                        <span><?php echo esc_html((string) ($finish['name'] ?? 'Finish')); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <div class="fg-window-handles__finish-copy">
                                <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                    <article data-fg-handle-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                                        <span><?php echo esc_html((string) ($finish['label'] ?? $finish['name'] ?? 'Door handle finish')); ?></span>
                                        <p><?php echo esc_html((string) ($finish['copy'] ?? '')); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>

                            <?php if (! empty($door_handles['technical']) && is_array($door_handles['technical'])) : ?>
                                <aside class="fg-window-handles__details" aria-label="<?php esc_attr_e('Door handle specification', 'fenster'); ?>">
                                    <div class="fg-window-handles__details-card">
                                        <h3><?php esc_html_e('Door hardware note', 'fenster'); ?></h3>
                                        <div class="fg-window-handles__detail-panel">
                                            <?php if (! empty($door_handles['technical_intro'])) : ?>
                                                <p><?php echo esc_html((string) $door_handles['technical_intro']); ?></p>
                                            <?php endif; ?>
                                            <dl class="fg-window-handles__specs">
                                                <?php foreach ($door_handles['technical'] as $spec) : ?>
                                                    <div>
                                                        <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                                                        <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                                                    </div>
                                                <?php endforeach; ?>
                                            </dl>
                                        </div>
                                    </div>
                                </aside>
                            <?php endif; ?>
                        </div>

                        <?php if (! empty($door_handles['features']) && is_array($door_handles['features'])) : ?>
                            <div class="fg-window-handles__features" aria-label="<?php esc_attr_e('Door handle features', 'fenster'); ?>">
                                <?php foreach ($door_handles['features'] as $feature) : ?>
                                    <article>
                                        <h3><?php echo esc_html((string) ($feature['title'] ?? '')); ?></h3>
                                        <p><?php echo esc_html((string) ($feature['copy'] ?? '')); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (! empty($product_faqs)) : ?>
            <?php
            $faq_schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(
                    static fn (array $faq): array => [
                        '@type' => 'Question',
                        'name' => (string) $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => (string) $faq['answer'],
                        ],
                    ],
                    array_slice($product_faqs, 0, 5)
                ),
            ];
            ?>
            <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
            <section class="fg-product-faq">
                <div class="container fg-product-faq__grid">
                    <div>
                        <p class="eyebrow"><?php echo esc_html($journey_faq_eyebrow); ?></p>
                        <h2><?php echo esc_html($journey_faq_heading); ?></h2>
                    </div>
                    <div class="fg-product-faq__items">
                        <?php foreach (array_slice($product_faqs, 0, 5) as $index => $faq) : ?>
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
        <?php endif; ?>

        <section class="fg-order-process">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php echo esc_html($journey_order_eyebrow); ?></p>
                    <h2><?php echo esc_html($journey_order_heading); ?></h2>
                    <p><?php echo esc_html($journey_order_copy); ?></p>
                </div>
                <div class="fg-order-process__rail">
                    <?php foreach ($product_order_steps as $step) : ?>
                        <article>
                            <span class="fg-order-process__number"><?php echo esc_html($step['step']); ?></span>
                            <div class="fg-order-process__card">
                                <span class="fg-order-process__icon" aria-hidden="true"></span>
                                <h3><?php echo esc_html($step['title']); ?></h3>
                                <p><?php echo esc_html($step['copy']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="fg-order-process__action">
                    <a class="button" href="#fenster-enquiry"><?php echo esc_html($journey_order_action); ?></a>
                </div>
            </div>
        </section>

        <?php if (! empty($partner_items)) : ?>
            <section class="fg-product-accreditations">
                <div class="container fg-partners">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Accreditations and systems', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Backed by recognised glazing bodies and trusted product partners.', 'fenster'); ?></h2>
                    </div>
                    <div class="fg-partners__logos">
                        <?php foreach ($partner_items as $item) : ?>
                            <span class="fg-logo-tile fg-logo-tile--partner" aria-label="<?php echo esc_attr($item['alt']); ?>">
                                <?php if (! empty($item['src'])) : ?>
                                    <img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" loading="lazy">
                                <?php else : ?>
                                    <strong><?php echo esc_html($item['label']); ?></strong>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (! empty($feature_sections) && ! $use_product_journey) : ?>
        <section class="fg-feature-band">
            <div class="container fg-feature-stack">
                <?php foreach ($feature_sections as $index => $section) : ?>
                    <?php $image = $feature_images[$index] ?? null; ?>
                    <section class="fg-feature <?php echo esc_attr($index % 2 ? 'fg-feature--reverse' : ''); ?>">
                        <div class="fg-feature__copy">
                            <p class="eyebrow"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></p>
                            <?php if (! empty($section['heading'])) : ?>
                                <h2><?php echo esc_html($section['heading']); ?></h2>
                            <?php endif; ?>
                            <?php foreach (array_slice(($section['body'] ?? []), 0, 4) as $paragraph) : ?>
                                <p><?php echo esc_html($paragraph); ?></p>
                            <?php endforeach; ?>
                            <?php if ($index === 1 || $index === 4) : ?>
                                <a class="text-link" href="#fenster-enquiry"><?php esc_html_e('Talk to Fenster about this', 'fenster'); ?></a>
                            <?php endif; ?>
                        </div>

                        <?php if (is_array($image) && ! empty($image['src'])) : ?>
                            <figure class="fg-feature__media">
                                <img src="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" alt="<?php echo esc_attr($image['alt'] ?? $title); ?>" loading="<?php echo $index < 2 ? 'eager' : 'lazy'; ?>">
                            </figure>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($team_cards)) : ?>
        <section class="fg-team-band">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('Meet the team', 'fenster'); ?></p>
                    <h2><?php esc_html_e('The people behind Fenster Glazing.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('From commercial specification through to installation, estimating, service and aftercare, the Fenster team keeps each project moving clearly.', 'fenster'); ?></p>
                </div>
                <div class="fg-team-grid">
                    <?php foreach (array_slice($team_cards, 0, 12) as $member) : ?>
                        <article class="fg-team-card">
                            <?php if (! empty($member['image'])) : ?>
                                <img src="<?php echo esc_url(fenster_generated_url($member['image'])); ?>" alt="<?php echo esc_attr($member['alt']); ?>" loading="lazy">
                            <?php endif; ?>
                            <div>
                                <p><?php echo esc_html($member['role']); ?></p>
                                <h3><?php echo esc_html($member['name']); ?></h3>
                                <?php if (! empty($member['copy'])) : ?>
                                    <span><?php echo esc_html($member['copy']); ?></span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="fg-team-band__action">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('View the full team', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! $use_product_journey) : ?>
        <section class="fg-cta-strip">
            <div class="container fg-cta-strip__inner">
                <div>
                    <p class="eyebrow"><?php echo esc_html($is_commercial ? 'Project support' : 'Quote support'); ?></p>
                    <h2><?php echo esc_html($is_commercial ? 'Need drawings, constraints or a specification checked?' : 'Ready to shape this around your property?'); ?></h2>
                </div>
                <a class="button button--light" href="#fenster-enquiry"><?php echo esc_html($cta_label); ?></a>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($is_product && ! $use_product_journey) : ?>
        <section class="fg-partners-band">
            <div class="container fg-partners">
                <div>
                    <p class="eyebrow"><?php esc_html_e('System partners', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products selected from manufacturers we trust.', 'fenster'); ?></h2>
                </div>
                <div class="fg-partners__logos">
                    <?php foreach ($partner_items as $item) : ?>
                        <span class="fg-logo-tile fg-logo-tile--partner" aria-label="<?php echo esc_attr($item['alt']); ?>">
                            <?php if (! empty($item['src'])) : ?>
                                <img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" loading="lazy">
                            <?php else : ?>
                                <strong><?php echo esc_html($item['label']); ?></strong>
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($is_product && $product_quote_embed_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($product_quote_embed_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php echo esc_html('Design and price your ' . $product_quote_embed_label . ' online.'); ?></h2>
                    <p><?php esc_html_e('Use the Fenster quote tool to choose a style, sizes, colours and options. Final pricing and specification are confirmed after survey.', 'fenster'); ?></p>
                </div>
                <article class="fg-product-quote-embed__card" data-quote-card>
                    <div class="fg-product-quote-embed__bar">
                        <h3><?php esc_html_e('Instant quote tool', 'fenster'); ?></h3>
                        <div class="fg-product-quote-embed__actions">
                            <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                            <a class="button" href="<?php echo esc_url($product_quote_embed_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                            <a class="button fg-product-quote-embed__mobile-open" href="<?php echo esc_url($product_quote_embed_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                        </div>
                    </div>
                    <div class="fg-product-quote-embed__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($product_quote_embed_url); ?>" data-quote-autoload="near">
                        <div class="fg-quote-frame-placeholder fg-product-quote-embed__placeholder">
                            <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                            <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                        </div>
                        <iframe
                            data-quote-iframe-src="<?php echo esc_url($product_quote_embed_url); ?>"
                            title="<?php echo esc_attr($product_quote_embed_label . ' instant quote tool'); ?>"
                            loading="lazy"
                            allow="fullscreen"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </article>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($is_product) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--product',
            'eyebrow' => 'Customer proof',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>

    <?php if (! empty($detail_sections) && ! $use_product_journey) : ?>
        <section class="fg-details-band">
            <div class="container fg-details-grid">
                <?php foreach ($detail_sections as $section) : ?>
                    <section class="fg-detail-card">
                        <?php if (! empty($section['heading'])) : ?>
                            <h2><?php echo esc_html($section['heading']); ?></h2>
                        <?php endif; ?>
                        <?php foreach (array_slice(($section['body'] ?? []), 0, 3) as $paragraph) : ?>
                            <p><?php echo esc_html($paragraph); ?></p>
                        <?php endforeach; ?>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (count($gallery_images) > 0 && ! $use_product_journey) : ?>
        <section class="fg-gallery-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Visual evidence', 'fenster'); ?></p>
                    <h2><?php echo esc_html($is_commercial ? 'Systems, projects and details.' : 'Products, projects and finishes.'); ?></h2>
                </div>
                <div class="fg-gallery">
                    <?php foreach (array_slice($gallery_images, 0, 24) as $image) : ?>
                        <figure class="fg-gallery__item">
                            <img src="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" alt="<?php echo esc_attr($image['alt'] ?? $title); ?>" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php echo esc_html($is_commercial ? 'Start the conversation' : 'Start your project'); ?></p>
                <h2><?php echo esc_html($is_commercial ? 'Tell us about the building, package or programme.' : 'Tell us about your project.'); ?></h2>
                <p><?php echo esc_html($is_commercial ? 'A Fenster specialist can help with early feasibility, system options, budgets and installation planning.' : 'Send the basics and the team can guide you through styles, pricing, survey and installation options.'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'] ?? '01908429200')); ?>"><?php echo esc_html($brand['phone'] ?? '01908 429200'); ?></a>
                    <a href="mailto:<?php echo esc_attr($brand['email'] ?? 'info@fensterglazing.com'); ?>"><?php echo esc_html($brand['email'] ?? 'info@fensterglazing.com'); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => $title,
                'button_label' => $is_commercial ? 'Send project enquiry' : 'Send my project details',
                'project_type' => $is_commercial ? 'Commercial glazing' : 'Residential windows and doors',
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Keep exploring', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Related products and service areas', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach (array_slice(array_values($related_links), 0, 24) as $link) : ?>
                        <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>

