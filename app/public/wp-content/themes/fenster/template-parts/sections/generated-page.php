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
    } elseif (str_starts_with($path, '/wp-content/themes/fenster/')) {
        /* Theme assets live at web/app/themes/fenster on the Bedrock servers,
           so the generic ABSPATH mapping below never finds them and every
           theme-pool image would be silently dropped. Resolve via the real
           theme directory instead. */
        $local_path = get_template_directory() . substr($path, strlen('/wp-content/themes/fenster'));
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
$is_composite_doors = $slug === 'composite-doors';
$is_home = $slug === 'home';
/* Both archives and both detail prefixes. Without the commercial-projects/
   prefix a migrated study fell through to the generic generated-page template,
   which rendered one image and no gallery because it knows nothing about the
   curated data. */
$is_case_study = in_array($slug, ['case-studies', 'commercial-projects'], true)
    || str_starts_with($slug, 'case-studies/')
    || str_starts_with($slug, 'commercial-projects/');
$is_team = $slug === 'meet-the-team';
$is_obscure_glass = $slug === 'obscured-glass';
$is_colour_options = in_array($slug, ['colour-options', 'upvc-colours', 'aluminium-colours'], true);
/* Flush replaces the middle of this template only — owner, 2026-08-06, "just
   change the middle". The hero, the specification strip, the technology banner
   and the whole tail from the specification choices down are the shared ones
   every product page gets; what comes out is `fg-product-why`,
   `fg-product-intel` and `fg-product-visuals`, and the bespoke sections go in
   their place. Not an early return like casement, which owns its own tail. */
$is_flush_bespoke = $slug === 'flush-casement-windows';
/* Aluminium doors replaces the middle on exactly the same terms as flush, and
   for the same reason: the route was running the generic journey, so it printed
   "Aluminium Doors" as an H2 twice under an H1 already saying it, headed its hub
   band "More information on Aluminium Doors", and filled the middle with copy
   written about no particular system. Hero, key-specification strip, Thermlock
   banner and the whole tail from the specification choices down are untouched
   and still shared. Not an early return. */
$is_alu_doors_bespoke = $slug === 'aluminium-doors';
/* Secondary glazing replaces the middle on the same terms, and additionally
   gates off the key-specification strip the way repairs does. Owner, 2026-08-07:
   keep the strip "only if we actually have relevant stats, dont want filler
   there". This product publishes no numbers at all. The starred U-value came off
   on 2026-08-05 because a secondary glazed figure depends entirely on the window
   it is fitted inside, and there is no acoustic figure either, so the strip was
   four facts with no measurement in them, each of which the bespoke sections now
   say better and in context. `product_usps` is KEPT and kept accurate because
   Legend reads its verified product facts from there. */
$is_secondary_bespoke = $slug === 'secondary-glazing';
/* Replacement glazing, 2026-08-10. Bespoke middle, and it drops the same two
   tail pieces secondary drops plus one more:

     - the KEY-SPECIFICATION PULSE, because one of its four tiles claimed an
       "A+ rated" energy rating. A+ is a Window Energy Rating and belongs to a
       complete window; a sealed unit going into somebody else's frame cannot
       carry one. What was left after removing it is process rather than
       specification, so the strip goes the way secondary's went. `product_usps`
       is KEPT and corrected, because Legend reads its verified facts from there.
     - the SPECIFICATION-CHOICES band, which offers frame colours. On the one
       route whose entire premise is that the frame stays exactly where it is,
       inviting somebody to choose a frame colour is incoherent.
     - the CASE-STUDY strip, because no replacement glazing study exists and
       `fenster_case_studies_for_product()` falls back to ALL studies when
       nothing matches, so the route was showing secondary glazing, casements
       and bifolds as though they were this. Same reason repairs gates it. */
$is_replacement_bespoke = $slug === 'double-glazing-replacement';
/* Aluminium flush windows, 2026-08-10. Bespoke middle, generic bands off. The
   key-specification pulse is KEPT here, unlike secondary glazing and
   replacement glazing, because this product genuinely has numbers: a U-value, a
   published sightline and a colour range. Two of its four tiles were corrected
   rather than removed; see `product_usps` in `inc/site-data.php`. */
$is_alu_flush_bespoke = $slug === 'aluminium-flush-windows';
/* Heritage windows, 2026-08-11. Bespoke middle, generic bands off, and the same
   two things KEPT as on flush aluminium: the key-specification pulse, because
   this product has real published figures, and the specification-choices
   wrapper, because the Classic colour grid and the S2 handle grid inside it are
   both genuine decisions here. The route keeps its instant-price button too —
   owner-confirmed on 2026-08-11 that the Aluminium Windows collection covers
   it — so nothing points at a tool that cannot price the job. */
$is_heritage_bespoke = $slug === 'heritage-windows';
/* uPVC doors, 2026-08-12. Bespoke middle, generic bands off, and the same two
   things KEPT as on flush aluminium and heritage: the key-specification pulse,
   because this product has real published figures, and the specification-choices
   wrapper, because colour, glass and the long-plate handle grid inside it are
   all genuine decisions on a uPVC door. The quote embed stays too: the uPVC
   Doors collection prices this exact product, so the randomiser can hand over
   to something that gives a real number. */
$is_upvc_doors_bespoke = $slug === 'upvc-doors';
/* Tilt and turn, 2026-08-12. Bespoke middle, generic bands off, and the same
   two things KEPT as on flush aluminium, heritage and uPVC doors: the
   key-specification pulse, because this product has real published figures, and
   the specification-choices wrapper, because the uPVC colour grid and the
   greenteQ tilt and turn handle grid inside it are both genuine decisions here.
   The quote embed stays — the uPVC Windows collection prices this window — and
   so does the order rail, because it is an ordinary installation.

   THE CASE-STUDY STRIP IS THE ONE THING GATED OFF, and it was live and wrong
   until this build. Nothing claims this route, so
   `fenster_case_studies_for_product()` fell through to its documented
   all-studies fallback and put secondary glazing, uPVC casements and aluminium
   bifolds under a heading promising real installs of this product. Same fault,
   same fix as `/aluminium-windows/`. See `$no_case_study_routes` below. */
$is_tilt_turn_bespoke = $slug === 'tilt-turn-windows';
/* Repairs replaces the middle the same way flush does, and additionally takes
   more of the tail out than flush needs to, because a repair is not a purchase
   of a product:

     - the specification-choices band offers colours, privacy glass and
       hardware, none of which anybody chooses when a handle has snapped;
     - the quote embed prices new windows and doors, so on this route it
       pointed a broken-lock visitor at a tool that cannot price their job.
       Same fault already fixed for integral blinds, and this slug is now in
       `$no_instant_price_routes` for the same reason;
     - the order-process rail describes the installation journey, ending at a
       technical survey and a FENSA certificate. Nobody having a hinge changed
       gets either. The bespoke section carries a repair-specific process
       instead. Note AI.md still lists this route as a rail consumer: this is a
       deliberate deviation and the owner has been told;
     - the case-study strip had no study claiming this route, so
       `fenster_case_studies_for_product()` fell through to its documented
       fallback and showed three unrelated INSTALLATIONS under a repairs
       heading. Gated rather than fixed with data, because a repair is not a
       case study we photograph. */
$is_repairs = $slug === 'window-and-door-repairs';
$is_window_handles = $slug === 'handle-options';
$is_trust_page = $slug === 'why-trust-fenster';
$is_about_page = $slug === 'about';
$is_about = in_array($slug, ['about', 'meet-the-team'], true);
$is_contact = $slug === 'contact';
$is_consultation_page = $slug === 'book-a-consultation';
$is_fensa_page = $slug === 'fensa-approved-installers';
$is_cpa_page = $slug === 'consumer-protection-association';
$is_ggf_page = $slug === 'glass-and-glazing-federation-ggf-standards';
$is_constructionline_page = $slug === 'constructionline-gold';
$is_ssip_page = $slug === 'ssip-health-and-safety';
$is_windows_hub = $slug === 'windows-milton-keynes';
$is_doors_hub = $slug === 'doors-milton-keynes';
// /other-services/ used to fall through to the generated utility layout, which
// rendered it as a scrape shell. It is a product-selector hub like the other two.
$is_services_hub = $slug === 'other-services';
$product_hub_group = $is_doors_hub ? 'doors' : ($is_services_hub ? 'other-services' : 'windows');
$is_product_selector_hub = $is_windows_hub || $is_doors_hub || $is_services_hub;
$is_commercial_hub = $slug === 'commercial-glazing';
$commercial_county_pages = function_exists('fenster_commercial_county_pages') ? fenster_commercial_county_pages() : [];
$is_commercial_county = isset($commercial_county_pages[$slug]);
$is_commercial_areas = $slug === 'commercial-areas';
$commercial_route_slugs = [
    'commercial-glazing',
    'commercial-replacement-glazing',
    'commercial-windows-and-doors',
    'curtain-walling',
    'louvre-vents',
    'commercial-automation',
    'commercial-projects',
    'healthcare-construction',
    'automatic-opening-vents',
    'school-and-education-glazing',
    'student-accommodation-glazing',
    'hotel-and-hospitality-glazing',
    'care-home-glazing',
    'office-and-retail-glazing',
    'industrial-and-logistics-glazing',
];
$is_commercial = in_array($slug, $commercial_route_slugs, true) || str_starts_with($slug, 'commercial-glazing-');
$commercial_product = function_exists('fenster_commercial_product_page') ? fenster_commercial_product_page($slug) : null;
$is_commercial_product = is_array($commercial_product);
$price_guide_pages = function_exists('fenster_price_guide_pages') ? fenster_price_guide_pages() : [];
$is_price_guide = isset($price_guide_pages[$slug]) || ! empty($page['is_price_guide']);
$is_quote_tool = in_array($slug, ['online-quote', '3d-visualiser', 'instant-pricing', 'instant-pricing-meta-ads', 'pricing-gads', 'design-your-windows-and-doors', 'door-designer'], true);
$is_archive_page = $slug === 'blog' || str_starts_with($slug, 'blog/page/') || str_starts_with($slug, 'category/') || str_starts_with($slug, 'tag/') || str_starts_with($slug, 'author/');
$is_utility_page = in_array($slug, ['privacy-policy', 'cookie-policy', 'terms-conditions', 'why-trust-fenster', 'brochures', 'downloads', 'gallery', 'customer-portal', 'careers', 'refer-a-friend', 'fenster-partners', 'videos', 'apecs-terms-conditions'], true);
$location_matrix_towns = function_exists('fenster_location_matrix_towns') ? fenster_location_matrix_towns() : [];
$location_matrix_products = function_exists('fenster_location_matrix_products') ? fenster_location_matrix_products() : [];
// '/double-glazing-milton-keynes/' is no longer a matrix route (Milton Keynes
// was removed from the town matrix) but it must keep rendering through
// location-service.php, which carries its dedicated head-term page sections.
$is_location_service = ($slug === 'double-glazing-milton-keynes')
    || (function_exists('fenster_location_matrix_page') && is_array(fenster_location_matrix_page($slug)));
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
$is_pet_flap_page = $slug === 'cat-and-dog-flaps';
$is_secondary_glazing_page = $slug === 'secondary-glazing';
$product_usps = fenster_data('product_usps.' . $slug, []);
$product_usps = is_array($product_usps) ? array_slice($product_usps, 0, 4) : [];
$product_content = fenster_data('product_content.' . $slug, []);
$product_content = is_array($product_content) ? $product_content : [];

/* Routes that lay the Liniar foil range out in full. Sliding sash is Roseview
   and secondary glazing is aluminium, so neither carries this range. Casement
   has its own template and includes the same component directly. */
$upvc_foil_routes = [
    'flush-casement-windows' => 'flush casement window',
    'french-casement-windows' => 'French casement window',
    'tilt-turn-windows' => 'tilt and turn window',
    'bow-bay-windows' => 'bow or bay window',
    /* uPVC DOORS CAME OFF THIS LIST, 2026-08-12. The shared grid is headed
       "Sixteen colours outside" and a door takes thirteen, so on that route it
       was both a duplicate and a contradiction. `/upvc-doors/` shows its own
       finish chart instead — a render of the actual door in every finish it can
       have — which the window routes have no equivalent of. Do not put the slug
       back without changing the heading, and note the chart is complete rather
       than a sample, so it must stay in step with `upvc_door_renders`. */
    'patio-doors' => 'patio door',
];
$shows_upvc_colour_grid = isset($upvc_foil_routes[$slug]) || $slug === 'casement-windows';

/* The powder-coated range, laid out the way the heritage door page lays out
   its colours. Owner instruction, 2026-08-02.

   Only routes that genuinely carry this range. Sliding sash is Roseview,
   composite has its own paint range, and the uPVC routes take the foil grid
   above. /heritage-aluminium-doors/ is absent on purpose: it has its own
   template and its own twelve-colour section, which is the reference this one
   copies, and its range stops at dual and bespoke on request rather than the
   any-RAL match these routes offer. */
$aluminium_colour_routes = [
    'aluminium-windows' => 'window',
    'aluminium-flush-windows' => 'window',
    'heritage-windows' => 'window',
    'aluminium-bifold-doors' => 'door',
    'aluminium-doors' => 'door',
    'aluminium-sliding-doors' => 'door',
];
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
$show_window_handle_card = $use_product_journey && is_array($window_handle_slugs) && in_array($slug, $window_handle_slugs, true);
/* Where the finishes are laid out in full, the card that links to the hub is
   redundant. Same rule the colour grid follows. */
$shows_handle_grid = is_array($window_handle_slugs) && in_array($slug, $window_handle_slugs, true) && $slug !== 'casement-windows';
$show_window_handles = false;
$window_handle_finishes = $window_handles['finishes'] ?? [];
$window_handle_finishes = is_array($window_handle_finishes) ? array_values($window_handle_finishes) : [];
$door_handles = fenster_data('door_handles', []);
$door_handles = is_array($door_handles) ? $door_handles : [];
$door_handle_slugs = $door_handles['slugs'] ?? [];
/* Composite is no longer excluded. Its old inline hardware picker went with
   the tabbed configurator on 2026-07-22 and renders nowhere, so the route had
   no handle content at all until the owner asked for the grid on 2026-07-29. */
$tilt_turn_handles = fenster_data('tilt_turn_handles', []);
$tilt_turn_handles = is_array($tilt_turn_handles) ? $tilt_turn_handles : [];
$tt_handle_slugs = $tilt_turn_handles['slugs'] ?? [];
$show_tilt_turn_handles = $use_product_journey && is_array($tt_handle_slugs) && in_array($slug, $tt_handle_slugs, true);

$show_door_handles = $use_product_journey && $is_door_product && is_array($door_handle_slugs) && in_array($slug, $door_handle_slugs, true);
$door_handle_finishes = $door_handles['finishes'] ?? [];
$door_handle_finishes = is_array($door_handle_finishes) ? array_values($door_handle_finishes) : [];
/* The sliding patio D-pull. Its own family, not an entry in door_handles: a
   slider takes no lever, so the long-plate grid would be the wrong hardware
   here in the same way the S2 grid would be wrong on tilt and turn. */
$patio_handles = fenster_data('patio_handles', []);
$patio_handles = is_array($patio_handles) ? $patio_handles : [];
$patio_handle_slugs = $patio_handles['slugs'] ?? [];
$show_patio_handles = $use_product_journey && is_array($patio_handle_slugs) && in_array($slug, $patio_handle_slugs, true);
$lift_slide_handles = fenster_data('lift_slide_handles', []);
$lift_slide_handles = is_array($lift_slide_handles) ? $lift_slide_handles : [];
$lift_slide_handle_slugs = $lift_slide_handles['slugs'] ?? [];
$show_lift_slide_handles = $use_product_journey && is_array($lift_slide_handle_slugs) && in_array($slug, $lift_slide_handle_slugs, true);
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
/* Hoisted so the two slots that can show a scrub agree on one decision. The
   intel figure used to work this out for itself further down the file; with a
   second possible home for the video, computing it twice is how the two would
   drift into rendering it in both places. */
$product_scrub_sources = function_exists('fenster_product_scrub_video_sources_for_slug')
    ? fenster_product_scrub_video_sources_for_slug($slug)
    : [];
$scrub_in_why_routes = function_exists('fenster_product_scrub_in_why_routes')
    ? fenster_product_scrub_in_why_routes()
    : [];
$scrub_in_why = ! empty($product_scrub_sources) && in_array($slug, $scrub_in_why_routes, true);
$sash_roseview_models = [];
$sash_roseview_details = [];
$sash_roseview_feature_cards = [];
$sash_roseview_gallery = [];
if ($slug === 'sliding-sash-windows') {
    $sash_asset_base = '/wp-content/themes/fenster/assets/images/products/sash-roseview/';
    $sash_roseview_models = [
        [
            'name' => 'Ultimate Rose',
            'tagline' => 'Closest to timber',
            'image' => $sash_asset_base . 'ultimate-rose-window-external.png',
            'rail_image' => $sash_asset_base . 'ultimate-35mm-meeting-rail.jpg',
            'rail_label' => '35mm meeting rail',
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
            'rail_image' => $sash_asset_base . 'heritage-44mm-midrail.jpg',
            'rail_label' => '44.5mm meeting rail',
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
            'rail_image' => $sash_asset_base . 'charisma-60mm-rail.jpg',
            'rail_label' => '60mm meeting rail',
            'alt' => 'Charisma Rose sash window viewed externally',
            'copy' => 'The accessible Rose Collection option: still a proper vertical sliding sash window, but with a simpler sculptured profile and wider rail for projects balancing appearance and budget.',
            'best_for' => 'Modern replacements, rental refurbishments and homes where sash operation matters more than maximum timber replication.',
            'specs' => [
                ['label' => 'Meeting rail', 'value' => '60mm'],
                ['label' => 'Corner detail', 'value' => 'Welded joints'],
                ['label' => 'Bottom rail', 'value' => '68mm standard'],
                ['label' => 'Glazing', 'value' => '24mm IGUs'],
            ],
        ],
    ];
    $sash_roseview_gallery = [
        [
            'image' => $sash_asset_base . 'gallery/roseview-wisteria-window.webp',
            'alt' => 'White Roseview sash window framed by flowering wisteria',
            'caption' => 'Arched sash with Georgian bars',
            'width' => 1800,
        ],
        [
            'image' => $sash_asset_base . 'gallery/roseview-dining-room.webp',
            'alt' => 'Roseview sash windows in a bright period dining room',
            'caption' => 'Sage-green frames in a period dining room',
            'width' => 1800,
        ],
        [
            'image' => $sash_asset_base . 'gallery/roseview-surrey-home.webp',
            'alt' => 'White Surrey home fitted with Roseview sash windows',
            'caption' => 'Full-property sash replacement',
            'width' => 1800,
        ],
        [
            'image' => $sash_asset_base . 'gallery/roseview-bay-room.webp',
            'alt' => 'Roseview sash bay window in a green living room',
            'caption' => 'Three-sided bay window',
            'width' => 1800,
        ],
        [
            'image' => $sash_asset_base . 'gallery/roseview-red-brick-home.webp',
            'alt' => 'Large red-brick home fitted with Roseview sash windows',
            'caption' => 'Balanced sash proportions across a large elevation',
            'width' => 1500,
        ],
        [
            'image' => $sash_asset_base . 'gallery/roseview-arched-interior.webp',
            'alt' => 'Arched Roseview sash windows viewed from inside a period home',
            'caption' => 'Special-shaped sash windows viewed from inside',
            'width' => 1200,
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
                'We check the right construction level against the elevation, budget and survey detail.',
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
            'copy' => 'Trickle vent options, concealed options and frame details are checked at survey so compliance does not ruin the elevation.',
        ],
    ];
}
$composite_door_families = [];
$composite_door_gallery = [];
$composite_door_colours = [];
$composite_door_glass = [];
if ($is_composite_doors) {
    $composite_asset_base = '/wp-content/themes/fenster/assets/images/products/composite-distinction/';
    // Two Distinction collections, each holding the styles Fenster fits within it.
    // Fenster's own composite collections, matching the door-style groups in the
    // WindowCAD retail designer so the website and the quote tool agree. This is
    // deliberately NOT Distinction's Signature/Contemporary split. Within a
    // collection the slab is fixed and the glass varies, which is the useful
    // thing to tell a customer. If WindowCAD's groups change, change these.
    $composite_collections = [
        [
            'name' => 'Traditional',
            'slug' => 'esteem',
            'slab' => 'Panelled slab, glass cut into it',
            'copy' => 'A moulded slab with raised detail and the glazed section cut into it. Much the biggest group, and where most period and estate frontages end up.',
        ],
        [
            'name' => 'Esprit',
            'slug' => 'esprit-esc19',
            'slab' => 'One flat woodgrain slab',
            'copy' => 'A single flat face with no moulded detail at all, so the glass shape does the work. Clean without feeling cold.',
        ],
        [
            'name' => 'Rustic Renown',
            'slug' => 'rustic-renown-rr03',
            'slab' => 'Shiplap boards inside a border',
            'copy' => 'Tongue and groove boards framed by a plain border. It reads like a cottage door on a cottage and like a design choice on a new build.',
        ],
        [
            'name' => 'Renown',
            'slug' => 'renown',
            'slab' => 'Full shiplap, no border',
            'copy' => 'The same boards running edge to edge with nothing framing them. The most flexible door we fit: it suits a Victorian terrace and a new build equally.',
        ],
        [
            'name' => 'Infinity',
            'slug' => 'infinity-gd01',
            'slab' => 'Long horizontal grooves',
            'copy' => 'The most modern end of the range. Wide grooves, bold glass shapes and long bar handles rather than a lever.',
        ],
        [
            'name' => 'Stable Doors',
            'slug' => 'stable-half-glazed',
            'slab' => 'Split across the middle',
            'copy' => 'The top half opens on its own while the bottom stays shut and locked. Kitchens, utility rooms and anyone with a dog or small children.',
        ],
    ];
    // Construction facts sourced from the Distinction technical material and
    // rewritten in the Fenster voice (see TONEOFVOICE.md). Do not invent specs.
    $composite_anatomy = [
        // Trimmed copy: the 428w original carries ~43px of flat white either
        // side, which reads as a mis-sized image against the panel's tint.
        'image' => $composite_asset_base . 'anatomy/slab-cutaway-trim-341w.webp',
        'image_alt' => 'Cutaway illustration of a Distinction composite door slab showing the layers behind the GRP skin',
        'layers' => [
            ['name' => 'GRP skin', 'copy' => 'Compression-moulded glass reinforced polyester with a woodgrain taken from real oak. It does not crack, flake or need repainting.'],
            ['name' => 'Water-resistant polymer edges', 'copy' => 'The rails bonded to the skin are polymer, not timber, so the door cannot drink rainwater and bow the way solid-timber-core doors can.'],
            ['name' => 'Engineered wood stiles', 'copy' => 'Engineered rather than sawn timber, so the slab stays stable through wet winters and warm summers.'],
            ['name' => 'Reinforced central board', 'copy' => 'A reinforced board through the middle keeps the door solid under force.'],
            ['name' => 'Foam-filled core', 'copy' => 'CFC-free polyurethane insulation fills the slab. It is the main reason the door holds heat so well.'],
            ['name' => 'Decorative glass', 'copy' => 'Most designs are triple glazed and laminated as standard; Chatsworth and Wentworth are double glazed. We tell you which is which before you order.'],
        ],
        'stats' => [
            ['value' => '44.5mm', 'label' => 'insulated slab; a typical uPVC door panel is 28mm'],
            ['value' => '50%', 'label' => 'more thermally efficient than solid timber core*'],
            ['value' => '£5,000', 'label' => 'security guarantee on our composite doors'],
            ['value' => '10 years', 'label' => 'insurance-backed installation guarantee'],
        ],
        'footnote' => '*Distinction\'s independent testing at the University of Salford\'s Energy House, against a 48mm solid-timber-core composite door and a 44mm timber panelled door.',
    ];
    // The £5,000 break-in guarantee is the headline USP on this route. The
    // hardware named here is the guarantee's actual basis, confirmed by the
    // owner on 2026-07-22: AI Secure locking, an APECS 3-star cylinder and an
    // ILH Duplex multipoint lock, with up to £5,000 compensation if either
    // fails in a break-in. Terms apply. Do not restate the terms beyond this.
    $composite_security = [
        ['title' => 'AI Secure locking', 'copy' => 'Fitted to every Distinction door we hang, not offered as an upgrade on the ones that can afford it.'],
        ['title' => 'APECS 3-star cylinder', 'copy' => 'The cylinder is the part a thief attacks first, which is why it is the part worth rating.'],
        ['title' => 'ILH Duplex multipoint lock', 'copy' => 'Engages at several points up the frame rather than only behind the handle.'],
        ['title' => 'Secured by Design slabs', 'copy' => 'The police-backed standard, tested by a UKAS-accredited body. It covers the door slabs, though not the stable doors.'],
    ];
    // Shared with the colours hub: the palette lives in inc/site-data.php under
    // colour_options.materials.composite so both surfaces stay in sync.
    $composite_door_colours = array_values(array_filter(
        (array) fenster_data('colour_options.materials.composite.colours', []),
        static fn ($colour): bool => is_array($colour) && ! empty($colour['slug'])
    ));
    // The Distinction style catalogue, built from the scrape by
    // scripts/build-composite-door-wall.py. Names come from the Distinction
    // Signature and Contemporary product pages; do not invent style names.
    $composite_styles_base = $composite_asset_base . 'styles/';
    $composite_door_styles = [
        ['slug' => 'retail-cottage', 'name' => 'Cottage', 'collection' => 'Renown'],
        ['slug' => 'elegance', 'name' => 'Elegance', 'collection' => 'Traditional'],
        ['slug' => 'classical', 'name' => 'Classical', 'collection' => 'Traditional'],
        ['slug' => 'rustic-renown-rr03', 'name' => 'Rustic Renown RR03', 'collection' => 'Rustic Renown'],
        ['slug' => 'rustic-renown-glazed', 'name' => 'Rustic Renown, glazed', 'collection' => 'Rustic Renown'],
        ['slug' => 'eclat-arch', 'name' => 'Eclat Arch', 'collection' => 'Traditional'],
        ['slug' => 'esteem', 'name' => 'Esteem', 'collection' => 'Traditional'],
        ['slug' => 'infinity-gd12', 'name' => 'Infinity GD12', 'collection' => 'Infinity'],
        ['slug' => 'new-england', 'name' => 'New England', 'collection' => 'Traditional'],
        ['slug' => 'elegance-arch-grid', 'name' => 'Elegance Arch with Grid', 'collection' => 'Traditional'],
        ['slug' => 'renown-full-moon', 'name' => 'Renown Full Moon', 'collection' => 'Renown'],
        ['slug' => '6-panel', 'name' => '6 Panel', 'collection' => 'Traditional'],
        ['slug' => 'esprit-esc19', 'name' => 'Esprit ESC19', 'collection' => 'Esprit'],
        ['slug' => 'renown', 'name' => 'Renown', 'collection' => 'Renown'],
        ['slug' => 'classical-half-glazed', 'name' => 'Classical Half Glazed', 'collection' => 'Traditional'],
        ['slug' => 'esteem-arch', 'name' => 'Esteem Arch', 'collection' => 'Traditional'],
        ['slug' => 'new-england-quarter', 'name' => 'New England Quarter', 'collection' => 'Traditional'],
        ['slug' => 'infinity-gd01', 'name' => 'Infinity GD01', 'collection' => 'Infinity'],
        ['slug' => 'elegance-grid', 'name' => 'Elegance with Grid', 'collection' => 'Traditional'],
        ['slug' => 'renown-top', 'name' => 'Renown Top', 'collection' => 'Renown'],
        ['slug' => 'eclat-craftsman', 'name' => 'Eclat Craftsman', 'collection' => 'Traditional'],
        ['slug' => 'stable-half-glazed', 'name' => 'Stable, half glazed', 'collection' => 'Stable Doors'],
        ['slug' => 'stable-diamond', 'name' => 'Stable, diamond glass', 'collection' => 'Stable Doors'],
        ['slug' => 'stable-solid', 'name' => 'Stable, solid', 'collection' => 'Stable Doors'],
        ['slug' => 'stable-cottage', 'name' => 'Stable, cottage', 'collection' => 'Stable Doors'],
        ['slug' => '9-panel', 'name' => '9 Panel', 'collection' => 'Traditional'],
        ['slug' => 'elegance-arch', 'name' => 'Elegance Arch', 'collection' => 'Traditional'],
        ['slug' => 'eclat', 'name' => 'Eclat', 'collection' => 'Traditional'],
        ['slug' => 'renown-diamond', 'name' => 'Renown Diamond', 'collection' => 'Renown'],
        ['slug' => 'eclat-craftsman-half-glazed', 'name' => 'Eclat Craftsman Half Glazed', 'collection' => 'Traditional'],
        ['slug' => 'esteem-eyebrow', 'name' => 'Esteem Eyebrow', 'collection' => 'Traditional'],
        ['slug' => 'esp01-flush', 'name' => 'Flush', 'collection' => 'Esprit'],
        ['slug' => 'eclat-arch-grid', 'name' => 'Eclat Arch with Grid', 'collection' => 'Traditional'],
    ];
    // The colour wall. Nine colours have a photographed door, so those lead and
    // hovering one shows the real door; the rest of the Distinction paint range
    // follows and shows the paint itself. Nothing here is a tinted swatch, and
    // no colour is faked: if there is no door photograph, we show the paint.
    // 'door' is a stem under colours/, 'swatch' a stem under palette/.
    $composite_colour_wall = [
        ['name' => 'Anthracite Grey', 'ref' => '', 'swatch' => 'anthracite-grey', 'door' => 'anthracite-grey'],
        ['name' => 'Black', 'ref' => '', 'swatch' => 'standard-black', 'door' => 'black'],
        ['name' => 'Slate Grey', 'ref' => '', 'swatch' => 'slate-grey', 'colour_door' => 'slate-grey'],
        ['name' => 'Basalt Grey', 'ref' => '', 'swatch' => 'basalt-grey', 'colour_door' => 'basalt-grey'],
        ['name' => 'Buckingham Grey', 'ref' => '', 'swatch' => 'buckingham-grey', 'colour_door' => 'buckingham-grey'],
        ['name' => 'Light Grey', 'ref' => '', 'hex' => '#a8aaa5', 'door' => 'light-grey'],
        ['name' => 'Chartwell Green', 'ref' => '', 'swatch' => 'chartwell-green', 'door' => 'chartwell-green'],
        ['name' => 'Standard Green', 'ref' => '', 'swatch' => 'standard-green', 'colour_door' => 'standard-green'],
        ['name' => 'Pale Green', 'ref' => 'RAL 6021', 'swatch' => 'pale-green'],
        ['name' => 'Leaf Green', 'ref' => 'RAL 6002', 'swatch' => 'leaf-green'],
        ['name' => 'Distant Blue', 'ref' => 'RAL 5023', 'swatch' => 'distant-blue', 'door' => 'distant-blue'],
        ['name' => 'Pale Blue', 'ref' => '', 'hex' => '#9fbec0', 'door' => 'pale-blue'],
        ['name' => 'Standard Blue', 'ref' => '', 'swatch' => 'standard-blue'],
        ['name' => 'Steel Blue', 'ref' => '', 'swatch' => 'steel-blue'],
        ['name' => 'Ultramarine Blue', 'ref' => 'RAL 5002', 'swatch' => 'ultramarine-blue'],
        ['name' => 'Turquoise Blue', 'ref' => 'RAL 5018', 'swatch' => 'turquoise-blue'],
        ['name' => 'Ruby Red', 'ref' => 'RAL 3003', 'hex' => '#8c1f2b', 'door' => 'ruby-red'],
        ['name' => 'Traffic Red', 'ref' => 'RAL 3020', 'swatch' => 'traffic-red', 'colour_door' => 'traffic-red'],
        ['name' => 'Wine Red', 'ref' => 'RAL 3005', 'swatch' => 'wine-red', 'colour_door' => 'wine-red'],
        ['name' => 'Standard Red', 'ref' => '', 'swatch' => 'standard-red'],
        ['name' => 'Telemagenta', 'ref' => 'RAL 4010', 'swatch' => 'telemagenta'],
        ['name' => 'Purple Violet', 'ref' => 'RAL 4007', 'swatch' => 'purple-violet', 'colour_door' => 'purple-violet'],
        ['name' => 'Colza Yellow', 'ref' => 'RAL 1021', 'swatch' => 'colza-yellow', 'colour_door' => 'colza-yellow'],
        ['name' => 'Black Brown', 'ref' => '', 'swatch' => 'black-brown', 'colour_door' => 'black-brown'],
        ['name' => 'White', 'ref' => '', 'hex' => '#f2f0e8', 'door' => 'white'],
        ['name' => 'Gold Oak', 'ref' => 'Woodgrain stain', 'swatch' => 'gold-oak'],
        ['name' => 'Rosewood', 'ref' => 'Woodgrain stain', 'swatch' => 'rosewood'],
    ];
    $composite_palette_base = $composite_asset_base . 'palette/';
    $composite_palette = [
        ['slug' => 'standard-black', 'name' => 'Standard Black', 'ref' => ''],
        ['slug' => 'anthracite-grey', 'name' => 'Anthracite Grey', 'ref' => ''],
        ['slug' => 'slate-grey', 'name' => 'Slate Grey', 'ref' => ''],
        ['slug' => 'basalt-grey', 'name' => 'Basalt Grey', 'ref' => ''],
        ['slug' => 'buckingham-grey', 'name' => 'Buckingham Grey', 'ref' => ''],
        ['slug' => 'chartwell-green', 'name' => 'Chartwell', 'ref' => ''],
        ['slug' => 'standard-green', 'name' => 'Standard Green', 'ref' => ''],
        ['slug' => 'pale-green', 'name' => 'Pale Green', 'ref' => 'RAL 6021'],
        ['slug' => 'leaf-green', 'name' => 'Leaf Green', 'ref' => 'RAL 6002'],
        ['slug' => 'standard-blue', 'name' => 'Standard Blue', 'ref' => ''],
        ['slug' => 'distant-blue', 'name' => 'Distant Blue', 'ref' => 'RAL 5023'],
        ['slug' => 'steel-blue', 'name' => 'Steel Blue', 'ref' => ''],
        ['slug' => 'ultramarine-blue', 'name' => 'Ultramarine Blue', 'ref' => 'RAL 5002'],
        ['slug' => 'turquoise-blue', 'name' => 'Turquoise Blue', 'ref' => 'RAL 5018'],
        ['slug' => 'standard-red', 'name' => 'Standard Red', 'ref' => ''],
        ['slug' => 'traffic-red', 'name' => 'Traffic Red', 'ref' => 'RAL 3020'],
        ['slug' => 'wine-red', 'name' => 'Wine Red', 'ref' => 'RAL 3005'],
        ['slug' => 'telemagenta', 'name' => 'Telemagenta', 'ref' => 'RAL 4010'],
        ['slug' => 'purple-violet', 'name' => 'Purple Violet', 'ref' => 'RAL 4007'],
        ['slug' => 'colza-yellow', 'name' => 'Colza Yellow', 'ref' => 'RAL 1021'],
        ['slug' => 'black-brown', 'name' => 'Black Brown', 'ref' => ''],
        ['slug' => 'gold-oak', 'name' => 'Gold Oak', 'ref' => 'Woodgrain stain'],
        ['slug' => 'rosewood', 'name' => 'Rosewood', 'ref' => 'Woodgrain stain'],
    ];
    $composite_door_glass = [
        ['name' => 'Lunna', 'slug' => 'lunna', 'copy' => 'Decorative zinc lines and textured glass with a traditional feel.'],
        ['name' => 'Chatsworth', 'slug' => 'chatsworth', 'copy' => 'A restrained satin privacy centre with a fine clear border.'],
        ['name' => 'Wentworth', 'slug' => 'wentworth', 'copy' => 'A wider clear border around a softly obscured privacy centre.'],
        ['name' => 'Andorra', 'slug' => 'andorra', 'copy' => 'Curved decorative lines and a central bevel for a softer pattern.'],
        ['name' => 'Scotia', 'slug' => 'scotia', 'copy' => 'Compact traditional bevels that suit smaller glazed apertures.'],
        ['name' => 'Kara Zinc', 'slug' => 'kara-zinc', 'copy' => 'Clean zinc caming with stronger geometry and a brighter finish.'],
    ];
}
$aluminium_windows_story_poster = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('website-header-specifiers-poster.jpg') : '';
$aluminium_windows_story_desktop_frames = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('frames-desktop/frame-001.webp') : '';
$aluminium_windows_story_mobile_frames = $is_aluminium_windows ? fenster_aluminium_windows_story_asset_url('frames-mobile/frame-001.webp') : '';
/* ROOFLINE USES THE SAME SCROLL-SCRUBBED CANVAS AS ALUMINIUM WINDOWS, and it is
   the same markup, the same controller and the same stylesheet block. Nothing
   new was written for the motion: `data-fg-aw-story` already scrubs a frame
   sequence against scroll and activates a copy panel per stage, so reusing it
   costs no JavaScript, no CSS and no build.

   WHAT THE SEQUENCE IS, because it decides whether this page is honest. Thirty
   frames crossfading one real photograph of a roof edge into an edge-trace OF
   THAT SAME PHOTOGRAPH, generated with ImageMagick's Canny detector. The line
   work is derived from the pixels rather than drawn, so it cannot be out of
   perspective or wrong about what a gutter union looks like — a hand-drawn
   trace over a photograph is exactly what the repairs schematics needed three
   rounds of owner correction to get right, and this sidesteps it entirely.

   The panels name the parts the drawing reveals, in the order the eye travels
   down the detail: fascia, soffit, guttering, downpipe. Every one of them is
   visible in the photograph. Do not add a panel for a part the picture does
   not show. */
$is_roofline = $slug === 'roofline';
$roofline_story_desktop_frames = $is_roofline ? fenster_story_asset_url('roofline-story', 'frames-desktop/frame-001.webp') : '';
$roofline_story_mobile_frames = $is_roofline ? fenster_story_asset_url('roofline-story', 'frames-mobile/frame-001.webp') : '';
$roofline_story_poster = $is_roofline ? fenster_generated_url('/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-soffit.jpg') : '';
$roofline_story_panels = [
    [
        'eyebrow' => 'The fascia',
        'heading' => 'The board the gutter hangs on.',
        'copy' => 'It runs along the roof edge, caps the rafter ends and carries the weight of a full gutter. Square, ogee or bullnose, and the square profile is the one available in every colour.',
    ],
    [
        'eyebrow' => 'The soffit',
        'heading' => 'The underside you see from the garden.',
        'copy' => 'It closes the gap between the fascia and the wall. Solid, hollow, or vented where the roof space needs to breathe.',
    ],
    [
        'eyebrow' => 'Gutter and downpipe',
        'heading' => 'Where the water actually goes.',
        'copy' => 'Half round, square, ogee or high capacity, sized to the roof above it and set to fall towards the outlet. The downpipe takes it from there to the drain.',
    ],
];

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
        ['value' => '100s', 'label' => 'of customer reviews'],
    ];

/* "Start your design consultation" is the right label for somebody choosing
   windows and the wrong one for somebody whose door will not lock. */
/* Replacement glazing gets its own, added 2026-08-10. "Start your design
   consultation" is the right invitation for somebody choosing a window and the
   wrong one for somebody with a misted pane who wants it gone: there is nothing
   to design. The owner's actual route in is that rough sizes and a photograph
   are enough to get a price without a visit, so the button says that. */
/* "Start your design consultation" went, 2026-08-13. This button has never
   opened a consultation: every render site sends it to `#fenster-enquiry`,
   which is the enquiry form at the foot of the page. On the routes with no
   instant price the button next to it is the real consultation link, going to
   `/book-a-consultation/`, so the two sat side by side with the wrong one
   promising the consultation. The label now names what the button does, and it
   is the wording composite doors already used for the same destination, so
   `#fenster-enquiry` has one label across the routes this covers. The short
   mobile label further down has to match it; see the comment there. */
$cta_label = $is_commercial ? 'Discuss a commercial project' : ($is_composite_doors ? 'Send an enquiry' : ($is_repairs ? 'Request a repair' : ($is_replacement_bespoke ? 'Send us the sizes' : 'Send an enquiry')));
/* The hero eyebrow names the system on a route that is sold around one, which
   is what composite doors has done since it was rebuilt. Heritage windows joins
   it on 2026-08-11. The H1 deliberately stays "Heritage Windows": that is the
   term people search and the one this route already ranks for, so the system
   name goes in the eyebrow rather than into the heading, which is also where
   STYLE.md puts the supporting line. */
$hero_eyebrow = 'Fenster Glazing';
if ($is_commercial) {
    $hero_eyebrow = 'Commercial glazing';
} elseif ($is_composite_doors) {
    $hero_eyebrow = 'Distinction composite doors';
} elseif ($is_heritage_bespoke) {
    $hero_eyebrow = 'Sheerline Classic';
} elseif ($slug === 'roofline') {
    /* Owner instruction, 2026-08-13: the page has to say fascias, soffits and
       guttering, or explain what roofline is, high up.

       The explanation already exists in `product_content['roofline']['intro']`
       and it is GOOD, but it never reaches this hero: `.fg-hero--compact` sets
       `.fg-hero__intro { display: none }` (src/scss/main.scss:3510), so on every
       compact-hero route the H1 is the only thing naming the product. That is
       fine for "Casement Windows" and useless for "Roofline", which is a trade
       word a homeowner may not know.

       The eyebrow is the right slot rather than lengthening the H1: STYLE.md
       requires the H1 to be the product name, and this eyebrow already carries a
       qualifier on three other routes. It renders directly above the H1, so the
       plain-English words are the first thing read. */
    $hero_eyebrow = 'Fascias, soffits and guttering';
}
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

/* Whether the online tool can actually put a price on this route.
   Integral blinds cannot be priced consumer-side: a blind unit is a sealed
   unit specification made to the host window or door, and the tool prices
   windows and doors. Sending someone to it from here promises a number they
   cannot get, so the route offers a consultation instead. Owner instruction,
   2026-08-04. Add a slug here rather than deleting the buttons, so the two
   hero variants and the hero card stay in step. */
$no_instant_price_routes = ['integral-blinds', 'window-and-door-repairs'];
$offers_instant_price = ! in_array($slug, $no_instant_price_routes, true);
$asset_base = '/wp-content/themes/fenster/assets/images/imported/';
$hero_overrides = [
    'home' => $asset_base . 'Aluminium-Windows-16.jpg',
    'aluminium-bifold-doors' => $asset_base . 'Bifold-550-GardenView-v1.webp',
    'aluminium-flush-windows' => $asset_base . 'Flush_8-copy.jpg',
    'aluminium-sliding-doors' => $asset_base . 'steel-look-patio-hero.webp',
    'windows-milton-keynes' => $asset_base . 'Aluminium-windows.jpg',
    'doors-milton-keynes' => $asset_base . 'new-front-door-in-Milton-Keynes.jpeg',
    'commercial-glazing' => $asset_base . 'commercial-glazed-elevation.jpg',
    'commercial-glazing-buckinghamshire' => $asset_base . 'commercial-glazed-elevation.jpg',
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
$product_hero_image_key = strtolower((string) parse_url(fenster_generated_url($hero_media_src), PHP_URL_PATH));
$product_unique_body_images = array_values(array_filter($product_visual_gallery, static function (array $image) use ($product_hero_image_key): bool {
    $image_key = strtolower((string) parse_url(fenster_generated_url((string) ($image['src'] ?? '')), PHP_URL_PATH));
    return $image_key !== '' && $image_key !== $product_hero_image_key;
}));
$product_why_image = $product_unique_body_images[0] ?? null;
$product_why_secondary_image = $product_unique_body_images[1] ?? null;
$product_gallery_heading = sprintf('%s: styles, details and fitted examples.', $title);
$product_gallery_copy = sprintf(
    'A closer look at %1$s: compare frame lines, glass options, opening formats and colours before you ask for a price.',
    $title
);
if ($is_pet_flap_page) {
    $product_gallery_heading = 'Pet flap fitting options and fitted details.';
    $product_gallery_copy = 'Pet flap projects are less about frame catalogues and more about the right fitting choice. We check whether the flap belongs in a replacement panel or a new sealed glass unit before the work is ordered.';
}
$home_categories = [
    ['label' => 'Windows', 'url' => home_url('/windows-milton-keynes/'), 'image' => $asset_base . 'Aluminium-windows.jpg', 'copy' => 'uPVC, aluminium, flush, sash and heritage-style windows for warmer, quieter homes.'],
    ['label' => 'Doors', 'url' => home_url('/doors-milton-keynes/'), 'image' => $asset_base . 'new-front-door-in-Milton-Keynes.jpeg', 'copy' => 'Composite, aluminium, French, patio and uPVC doors built around security and style.'],
    ['label' => 'Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/'), 'image' => $asset_base . 'Bifold-550-GardenView-v1.webp', 'copy' => 'Slim aluminium bifolds that open up kitchens, extensions and garden rooms.'],
    ['label' => 'Commercial Glazing', 'url' => home_url('/commercial-glazing/'), 'image' => $asset_base . 'commercial-glazed-elevation.jpg', 'copy' => 'Specification-led glazing, doors and facade support for commercial projects.'],
    ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/'), 'image' => $asset_base . 'S1-Lantern-Kitchen-A-min-scaled.jpg', 'copy' => 'Aluminium roof lanterns that bring clean daylight into living spaces.'],
    ['label' => 'Integral Blinds', 'url' => home_url('/integral-blinds/'), 'image' => $asset_base . 'HiTech-Blinds-Integral-Blinds-Black-Doors.jpg', 'copy' => 'Sealed blinds between glass panes for neat privacy and low-maintenance control.'],
    ['label' => 'Replacement Glazing', 'url' => home_url('/double-glazing-replacement/'), 'image' => $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg', 'copy' => 'Replace failed, misted or damaged glass without replacing the whole frame.'],
    ['label' => 'Cat & Dog Flaps', 'url' => home_url('/cat-and-dog-flaps/'), 'image' => $asset_base . 'SureFlap_Microchip_Cat_Flap_Glass.webp', 'copy' => 'Pet flap glazing options fitted cleanly into suitable doors and glass units.'],
];
$home_showcase = [
    ['label' => 'Residential aluminium', 'image' => $asset_base . 'Aluminium-Windows-16.jpg', 'copy' => 'Slim frames, clean glass lines and practical performance for modern extensions and whole-home upgrades.'],
    ['label' => 'Commercial delivery', 'image' => $asset_base . 'commercial-glazed-elevation.jpg', 'copy' => 'Specification-led glazing packages for offices, education, healthcare and large commercial sites.'],
    ['label' => 'Bifold living spaces', 'image' => $asset_base . 'Bifold-OpenSplit-v1.webp', 'copy' => 'Open-plan spaces with controlled thresholds, hardware and colour options.'],
];
$home_process = [
    ['step' => '01', 'title' => 'Design', 'copy' => 'Start with the instant quote tool, visualise products and shape a brief before a survey.'],
    ['step' => '02', 'title' => 'Survey', 'copy' => 'We check sizes, details, access, thresholds, finishes and installation constraints.'],
    ['step' => '03', 'title' => 'Build', 'copy' => 'Systems are specified around performance, security, style and manufacturer fit.'],
    ['step' => '04', 'title' => 'Install', 'copy' => 'Installation is planned cleanly, with aftercare and guarantee support built in.'],
];
$trust_items = [
    ['src' => FENSTER_THEME_URI . '/assets/trust/google-5-stars.png', 'alt' => 'Google five star reviews', 'url' => fenster_data('brand.google_reviews_url', ''), 'external' => true],
    ['src' => FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png', 'alt' => 'Trustpilot Excellent', 'url' => fenster_data('brand.trustpilot_url', ''), 'external' => true],
    ['src' => FENSTER_THEME_URI . '/assets/trust/fensa.png', 'alt' => 'FENSA approved', 'url' => home_url('/fensa-approved-installers/')],
    ['src' => FENSTER_THEME_URI . '/assets/trust/cpa.png', 'alt' => 'Consumer Protection Association', 'url' => home_url('/consumer-protection-association/')],
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
$product_hub_image = is_array($product_hub['image'] ?? null) ? $product_hub['image'] : ($product_unique_body_images[2] ?? null);
$product_hub_support_image = is_array($product_unique_body_images[3] ?? null) ? $product_unique_body_images[3] : null;
$product_visual_gallery_remainder = array_slice($product_unique_body_images, 4);
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
        ['title' => 'Designed around your property', 'copy' => 'We help shape the right specification around style, performance, security and the way the space will be used.'],
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
            'answer' => 'We will guide you through product style, frame material, colour, glazing, hardware and installation details once we understand the property and how the space is used.',
        ],
        [
            'question' => 'Can I choose different colours and finishes?',
            'answer' => 'Yes. Popular colours are shown on this page, with wider finish options available depending on the product system and material selected.',
        ],
        [
            'question' => 'Will the product be surveyed before it is made?',
            'answer' => 'Yes. We check measurements, thresholds, access and installation details before manufacture so the final specification fits the project properly.',
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

if ($slug === 'sliding-sash-windows') {
    $product_faqs = [
        [
            'question' => 'Which Roseview sash window should I choose?',
            'answer' => 'Ultimate Rose gives the closest timber replication, Heritage Rose balances traditional detailing and value, and Charisma Rose suits simpler or more contemporary replacements. We confirm the right model after seeing the property and the level of detail required.',
        ],
        [
            'question' => 'Do sash windows need planning permission?',
            'answer' => 'Most like-for-like replacements do not need planning permission, but listed buildings, Article 4 directions and some conservation areas can require consent. Check with the local planning authority before ordering if restrictions may apply.',
        ],
        [
            'question' => 'Are Roseview sash windows suitable for conservation areas?',
            'answer' => 'Ultimate Rose is commonly chosen where timber-like proportions and joint detailing matter most. Acceptance always depends on the property and local planning requirements, so we can help prepare the specification but cannot guarantee planning approval.',
        ],
        [
            'question' => 'How do tilt-in sash windows work?',
            'answer' => 'The sliding sashes can tilt inwards so the outside glass can be cleaned safely from inside. Tilt availability and any weight restrictions are confirmed for the finished window during survey.',
        ],
        [
            'question' => 'What affects the price of sliding sash windows?',
            'answer' => 'Price depends on the Roseview model, size, colour, glazing bars, horn and cill details, glass specification, security upgrades, access and installation conditions. A survey confirms the final specification and price.',
        ],
        [
            'question' => 'What security upgrades are available?',
            'answer' => 'PAS 24, Part Q and Secured by Design options are available on suitable Roseview specifications. The final lock and furniture package is confirmed around the selected model and project requirements.',
        ],
    ];
}

/* Flush takes a 28mm double glazed unit and no triple. That was a note in the
   middle of the page until 2026-08-06; the owner moved it here, which is the
   better place for it — a thing the product cannot do belongs where somebody goes
   looking for the awkward answers, not halfway through the argument for it.

   Appended rather than overriding, so the FAQs this page already generates from
   its own sections survive. It names the alternative, because the honest version
   of "no" is "not here, and here is where you can". */
if ($slug === 'flush-casement-windows') {
    $product_faqs[] = [
        'question' => 'Can I have triple glazing in a flush casement?',
        'answer' => 'Not on this system. The uPVC flush sash takes a 28mm double glazed unit only, which is what it reaches 1.2 W/m²K and an A+ rating on. If triple glazing matters more to you than the flat sash line, the standard casement takes a 36mm triple unit and reaches 0.95 W/m²K. We would rather tell you that before a survey than after one.',
    ];
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
$journey_why_eyebrow = $is_about ? 'Why Fenster?' : ($is_commercial ? 'Why Fenster commercially?' : 'Product information');
$journey_why_heading = $is_about ? 'Why choose Fenster Glazing?' : ($is_commercial ? 'Why choose Fenster for commercial glazing?' : $title);

/* Roofline rendered "Product information / Roofline" as an H2 directly under an
   H1 reading Roofline. Set AFTER the default above and outside every route
   branch, because a first pass put it inside the pet-flap block, where it was
   syntactically fine, linted clean and never ran. Twenty-odd routes still
   repeat their own H1 as an H2 site-wide; this is the third to stop. */
if ($slug === 'roofline') {
    $journey_why_eyebrow = 'What we replace';
    $journey_why_heading = 'What a roofline job actually covers.';
}
$journey_why_button = $is_about ? 'Talk to the team' : ($is_commercial ? 'Start a commercial enquiry' : 'Start a product enquiry');
$journey_gallery_eyebrow = $is_about ? 'People and proof' : ($is_commercial ? 'Projects and systems' : 'Gallery and choices');
$journey_gallery_heading = $is_about ? 'See the team, work and details behind the company.' : ($is_commercial ? 'See the commercial work, systems and details before you enquire.' : 'See the styles, finishes and details before you enquire.');
$journey_faq_eyebrow = $is_about ? 'Company questions' : ($is_commercial ? 'Commercial questions' : 'Product questions');
/* This heading interpolates the route title, which works because every other
   title in `pages.json` is a noun phrase: "Flush Casement Windows", "Secondary
   Glazing". Replacement glazing's H1 was rewritten on 2026-08-10 to lead with
   the fault rather than the trade term, on the owner's steer, and a sentence
   with a full stop in it reads as nonsense once "FAQs about " is bolted to the
   front of it. Overridden below, the way cat and dog flaps already does. If any
   future route takes a sentence for a title, it needs the same treatment. */
$journey_faq_heading = $is_about ? 'FAQs about Fenster Glazing' : ($is_commercial ? 'FAQs about commercial glazing' : 'FAQs about ' . $title);
if ($is_replacement_bespoke) {
    $journey_faq_heading = 'FAQs about replacement glazing';
}
$journey_order_eyebrow = $is_commercial ? 'Project process' : ($is_about ? 'How Fenster works' : 'Order process');
$journey_order_heading = $is_commercial ? 'A clear process from early brief to delivery.' : ($is_about ? 'A clear process from first conversation to aftercare.' : 'A clear process from first quote to aftercare.');
$journey_order_copy = $is_commercial
    ? 'We keep commercial projects moving through brief, specification, coordination, installation and aftercare.'
    : ($is_about
        ? 'We keep enquiries straightforward: understand the need, check the details, install carefully and support the work afterwards.'
        : 'Four steps. The first one has two ways in: price it yourself online, or have us come out. After that it runs the same either way.');
$journey_order_action = $is_commercial ? 'Start a commercial conversation' : ($is_about ? 'Start a conversation' : 'Start your enquiry');
$journey_trust_heading = $is_about ? 'A local glazing team backed by recognised accreditations.' : 'Reviewed, accredited and backed by proven product systems.';
$journey_trust_copy = $is_about
    ? 'Fenster combines local installation experience, real people, recognised accreditations and trusted glazing system partners.'
    : 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.';
$journey_option_eyebrow = ($is_product && ! $is_commercial) ? 'Popular colours' : ($is_commercial ? 'Commercial checkpoints' : 'Company checkpoints');
$journey_option_heading = ($is_product && ! $is_commercial) ? 'Choose a finish that fits the property.' : ($is_commercial ? 'Keep the important project decisions visible.' : 'Understand how Fenster keeps the work grounded.');
$journey_options = $product_colours;

if ($is_pet_flap_page) {
    $journey_heading = 'Cat and dog flaps, fitted into glass or into the panel.';
    $journey_steps = ['Glass or panel', 'Standard or microchip', 'Survey before ordering'];
    $journey_intro_heading = 'A small job with one big decision in it.';
    $journey_intro_copy = 'A sealed unit cannot be cut once it has been made, so glass means a new unit. A panel we cut ourselves.';
    $journey_why_eyebrow = 'Pet flap fitting';
    $journey_why_heading = 'Glass or panel decides the rest of the job.';
    $journey_why_button = 'Ask about a pet flap';
    $journey_gallery_eyebrow = 'Fitting choices';
    $journey_gallery_heading = 'Where the flap goes, and what that means.';
    $journey_faq_heading = 'FAQs about cat and dog flaps';
    $journey_order_eyebrow = 'Pet flap process';
    $journey_order_heading = 'We look at the door before anything is ordered.';
    $journey_order_copy = 'A pet flap is not made to survey sizes like a window, so the order goes in once we know which route your door takes and which flap you want.';
    $journey_order_action = 'Ask about pet flap fitting';
    $journey_option_eyebrow = 'Pet flap checks';
    $journey_option_heading = 'Choose the fitting method around the existing door or glass.';
}

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

/* Null means the canonical set in inc/site-data.php, which is what every
   non-commercial route now uses. Only override where the journey is genuinely
   a different one. */
$product_order_steps = null;

if ($is_commercial) {
    $product_order_steps = [
        ['step' => '01', 'title' => 'Brief', 'copy' => 'Share the building type, package scope, programme, drawings and performance requirements.'],
        ['step' => '02', 'title' => 'Specification', 'copy' => 'We help align systems, glazing, access, interfaces and delivery constraints before work moves ahead.'],
        ['step' => '03', 'title' => 'Installation', 'copy' => 'Commercial installation is planned around site coordination, safety, sequencing and programme needs.'],
        ['step' => '04', 'title' => 'Aftercare', 'copy' => 'The team remains available for documentation, maintenance guidance and practical project support.'],
    ];
} elseif (in_array($slug, ['secondary-glazing', 'roofline', 'integral-blinds', 'double-glazing-replacement'], true)) {
    /* The four routes outside BOTH schemes. Owner-confirmed 2026-08-07 in two
       parts, and the second is the durable one:

         1. FENSA is not relevant to secondary glazing, roofline, integral blinds
            or double glazing replacement. A FENSA certificate covers replacement
            windows and doors. Secondary glazing is an additional window inside
            the one already there, roofline is fascia, soffit and guttering with
            no glazing in it at all, integral blinds are not a replacement
            window, and replacing a sealed unit into a frame that stays put is
            not one either.

         2. "all non fensa are non CPA too, they're linked." FENSA eligibility
            and the ten year CPA insurance-backed guarantee travel together, so
            a route outside one is outside the other. There is no non-FENSA
            route that still carries the CPA cover.

       So step 04 loses the certificate AND the guarantee, not just the
       certificate. An earlier pass kept the guarantee sentence on the grounds
       that it is scoped to "new windows and doors" and therefore still
       technically true. It is, but leading the aftercare step of a secondary
       glazing page with a ten year insurance-backed guarantee that does not
       apply to what the visitor is buying invites the wrong conclusion anyway.
       Scoping is not the same as honesty.

       The replacement says nothing about what these products do NOT get either,
       because the owner ruled out that register on 2026-08-02: the site does not
       write copy stating what is not covered.

       This still takes the canonical steps and changes ONE sentence rather than
       giving four routes four hand-written journeys. Six step sets across three
       templates is the mess the 2026-07-29 consolidation cleaned up.

       Secondary glazing takes one further change, to step 02: "thresholds" is a
       measurement a secondary glazed unit does not have, and reveal depth is
       what this product actually turns on. The other three keep the canonical
       02. */
    $product_order_steps = fenster_data('order_process.steps', []);
    $no_fensa_aftercare = (string) fenster_data('order_process.aftercare_outside_fensa_and_cpa', '');

    if (is_array($product_order_steps) && $product_order_steps !== [] && $no_fensa_aftercare !== '') {
        $product_order_steps = array_values($product_order_steps);
        $last = count($product_order_steps) - 1;
        $product_order_steps[$last]['copy'] = $no_fensa_aftercare;

        if ($is_secondary_glazing_page && isset($product_order_steps[1])) {
            $product_order_steps[1]['copy'] = 'Once you go ahead we survey before anything is made. Not a second sales visit: the reveal depth, the fixings and the sizes the factory needs to build it right.';
        }

        /* Replacement glazing takes three, all owner-confirmed 2026-08-10.

           01, because this is the one route you can be priced on without anybody
           coming out: "if they have rough sizes (and/or pics) we can price
           remotely or they can use our windowcad tool."

           02, because the canonical step names thresholds, which a sealed unit
           does not have, and because "we always measure before ordering" and the
           survey is free.

           04, because the shared no-scheme string is silent on guarantees and
           this product genuinely carries one: "we guarantee sealed units for 10
           years (what we get from manufacturer)". It is stated as ours and whose
           it is, and it names no scheme, which is what keeps it clear of both
           the CPA claim and the rule against writing what is not covered. */
        if ($is_replacement_bespoke) {
            if (isset($product_order_steps[0])) {
                $product_order_steps[0]['copy'] = 'Send rough sizes and a photograph and we can usually price it without coming out, or price it yourself on the online tool. There is no minimum: one unit is a job worth doing.';
            }
            if (isset($product_order_steps[1])) {
                $product_order_steps[1]['copy'] = 'Once you go ahead we come and measure before anything is ordered: the glass size, the spacer, the frame it goes back into and whether the position calls for toughened or laminated. The survey is free.';
            }
            $product_order_steps[$last]['copy'] = 'Ten years on the sealed unit, which is the guarantee the manufacturer gives us and we pass straight on. Anything afterwards you ring us rather than a call centre, and you are talking to the same people who fitted it.';
        }
    } else {
        /* Fall back to the canonical set rather than to nothing. A missing data
           key must not silently empty the rail. */
        $product_order_steps = null;
    }
} elseif ($is_pet_flap_page) {
    /* Held back from the canonical set deliberately. A pet flap is a different
       job: nothing is manufactured to survey sizes, and it sits outside the ten
       year guarantee, so the canonical steps would describe work we are not
       doing here. Flagged to the owner on 2026-07-29. */
    $product_order_steps = [
        /* This rail carries its own steps because a pet flap is a different job
           from a window, and it was the one source the 2026-08-02 copy sweep
           missed first time round: it still offered "manual, lockable and
           microchip" as three flap types after every other source had been
           corrected to two. Worth remembering that this page has six places
           copy lives, and the process steps are the easiest to forget. */
        ['step' => '01', 'title' => 'Look at the door', 'copy' => 'We work out whether the flap is going into a panel we can cut, or into a new sealed unit, because that decides the rest of it.'],
        ['step' => '02', 'title' => 'Pick the flap', 'copy' => 'A standard flap that locks by hand, or a microchip one that opens only for your pet. We size it around the animal rather than the door.'],
        ['step' => '03', 'title' => 'Order the part', 'copy' => 'A new glass unit is made to order with the aperture already in it, so allow a week or two. A panel does not need one.'],
        ['step' => '04', 'title' => 'Fit and finish', 'copy' => 'We fit it, weather it and check your pet can actually get through at the height it has ended up.'],
    ];
}
/* Legend's verdict on the pet flap page. He is Fenster's office cat and the
   Chief Meow Officer on Meet the Team, so a pet flap is the one route on the
   site where his opinion is on topic.

   Kept to the one dry aside per page TONEOFVOICE.md allows, and kept away from
   the FENSA and CPA marks on purpose: "Legend approved" must read as the joke it
   is and never as a badge that could be mistaken for a real accreditation. The
   verdicts are deadpan, with no exclamation marks, for the same reason.

   The first is rendered server-side and visible, so with JavaScript off the
   stamp still reads as a complete thought and only the cycling is lost. */
$legend_verdicts = $is_pet_flap_page
    ? [
        'Went through it. Came back. Went through it again.',
        'Tested at three in the morning. Several times.',
        'Fits a cat of my proportions, which was generous of them.',
        'No draught. No complaints.',
        'Approved. Now open the door for me anyway.',
    ]
    : [];
$pet_flap_cards = $is_pet_flap_page
    ? [
        [
            'title' => 'Into new glass',
            'copy' => 'A sealed unit cannot be cut once it has been made, so we measure the opening and order a new unit with the aperture already in it. The old unit comes out, the new one goes in, and the flap fits into that.',
            'points' => ['The glass you have cannot be cut', 'Aperture made at the factory', 'Usually a week or two for the unit'],
        ],
        [
            'title' => 'Into a door panel',
            'copy' => 'Where the door has a panel that suits it, we cut the aperture ourselves and fit the flap straight into it. We check the material and the thickness first, because not every panel will take one.',
            'points' => ['Cut by us, on site', 'Suitable panels only', 'No glass to reorder'],
        ],
        [
            'title' => 'Standard or microchip',
            'copy' => 'The standard flap locks by hand when you want it shut. The microchip flap reads the chip your pet already has and opens only for them, which is the one people ask for when other animals have been getting in. Either goes into glass or a panel.',
            'points' => ['Both lock', 'Microchip reads your own pet', 'We are approved SureFlap installers'],
        ],
        [
            'title' => 'Where it sits',
            'copy' => 'Height matters more than people expect. We look at the pet, the threshold and what is on the other side, because a flap at the wrong height gets used once and then ignored.',
            'points' => ['Set around the pet, not the door', 'Outside step checked', 'Cats and dogs, sized to suit'],
        ],
    ]
    : [];
$related_links = [];
$generated_pages = fenster_generated_pages_index();
/* A ROUTE THAT IS NOT IN `pages.json` STILL HAS TO BE NAMED HERE, OR EVERY LINK
   TO IT IS SILENTLY DROPPED, 2026-08-13.

   `$route_exists()` below tests `fenster_generated_pages_index()` (which is
   `data/pages.json` and nothing else) and this map. `areas-we-cover` and
   `flat-rooflights` are virtual routes built in `inc/generated-pages.php` and
   were in neither, so `$add_related_route('areas-we-cover', 'Areas We Cover')`
   at three separate call sites in this file was a no-op on every route on the
   site, and the link never rendered anywhere. The same held for
   `$add_related_route('window-door-prices-milton-keynes', ...)`.

   The price guides are added from their own registry rather than restated, so a
   renamed guide or a changed title follows automatically, and they are added
   only when `fenster_price_guides_enabled()` is true because that is the same
   gate `fenster_get_generated_page()` uses to serve them. Linking them on a host
   where they do not resolve would trade a missing link for a 404. */
$virtual_page_titles = [
    'aluminium-flush-windows' => 'Aluminium Flush Windows',
    'aluminium-sliding-doors' => 'Aluminium Sliding Doors',
    'areas-we-cover' => 'Areas We Cover',
    'commercial-areas' => 'Commercial Areas',
    'commercial-projects' => 'Commercial Projects',
    'flat-rooflights' => 'Flat Rooflights',
];
if (
    function_exists('fenster_price_guide_pages')
    && function_exists('fenster_price_guides_enabled')
    && fenster_price_guides_enabled()
) {
    foreach (fenster_price_guide_pages() as $price_guide_slug => $price_guide_page) {
        $price_guide_title = trim((string) ($price_guide_page['title'] ?? ''));
        if ($price_guide_title !== '') {
            $virtual_page_titles[$price_guide_slug] = $price_guide_title;
        }
    }
}
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
            'title' => __('Local advice from Milton Keynes', 'fenster'),
            'copy' => __('We are based in Milton Keynes and work across nearby towns for homeowners planning windows, doors, roof lanterns, glass replacement and larger glazing projects.', 'fenster'),
        ],
        [
            'title' => __('Survey-led installation', 'fenster'),
            'copy' => __('The team checks measurements, access, frame style, glass specification, ventilation, thresholds and installation details before made-to-measure products are ordered.', 'fenster'),
        ],
        [
            'title' => __('Nearby town not listed?', 'fenster'),
            'copy' => __('If you are close to one of the listed towns, contact the showroom. The team can confirm whether your postcode is within the normal service area.', 'fenster'),
        ],
    ];
    $service_shortcuts = [
        ['title' => __('Double glazing', 'fenster'), 'url' => home_url('/double-glazing-milton-keynes/')],
        ['title' => __('Windows', 'fenster'), 'url' => home_url('/windows-milton-keynes/')],
        ['title' => __('Doors', 'fenster'), 'url' => home_url('/doors-milton-keynes/')],
        ['title' => __('Bifold doors', 'fenster'), 'url' => home_url('/aluminium-bifold-doors/')],
        ['title' => __('Roof lanterns', 'fenster'), 'url' => home_url('/roof-lanterns/')],
        ['title' => __('Online quote', 'fenster'), 'url' => home_url('/online-quote/')],
    ];
    $town_order = [
        'milton-keynes',
        'aylesbury',
        'buckingham',
        'bedford',
        'ampthill',
        'flitwick',
        'dunstable',
        'leighton-buzzard',
        'luton',
        'toddington',
        'northampton',
        'hitchin',
        'letchworth',
        'stevenage',
    ];
    $product_group_map = [
        'windows' => [
            'label' => __('Windows', 'fenster'),
            'slugs' => [
                'casement-windows',
                'flush-casement-windows',
                'sliding-sash-windows',
                'french-casement-windows',
                'tilt-turn-windows',
                'bow-bay-windows',
                'aluminium-windows',
                'aluminium-flush-windows',
                'heritage-windows',
            ],
        ],
        'doors' => [
            'label' => __('Doors', 'fenster'),
            'slugs' => [
                'composite-doors',
                'upvc-doors',
                'aluminium-doors',
                'heritage-aluminium-doors',
                'aluminium-bifold-doors',
                'slide-fold-doors',
                'aluminium-sliding-doors',
                'patio-doors',
                'french-doors',
            ],
        ],
        'extras' => [
            'label' => __('Glazing and extras', 'fenster'),
            'slugs' => [
                'double-glazing',
                'integral-blinds',
                'roof-lanterns',
            ],
        ],
    ];
    $product_group_by_slug = [];
    foreach ($product_group_map as $group_key => $group) {
        foreach ($group['slugs'] as $product_slug) {
            $product_group_by_slug[$product_slug] = $group_key;
        }
    }
    $area_groups = [];
    foreach ($matrix_towns as $location_slug => $location_label) {
        $area_groups[$location_slug] = [
            'label' => $location_label,
            'links' => [],
            'groups' => array_fill_keys(array_keys($product_group_map), []),
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

            $product_slug = substr($generated_slug, 0, -strlen('-' . $location_slug));
            $area_link = [
                'title' => trim((string) ($generated_page['title'] ?? ucwords(str_replace('-', ' ', $generated_slug)))),
                'url' => home_url('/' . $generated_slug . '/'),
                'slug' => $generated_slug,
                'product_slug' => $product_slug,
            ];
            $area_groups[$location_slug]['links'][$generated_slug] = $area_link;
            $group_key = $product_group_by_slug[$product_slug] ?? 'extras';
            $area_groups[$location_slug]['groups'][$group_key][$generated_slug] = $area_link;
            break;
        }
    }

    foreach ($area_groups as $location_slug => $area_group) {
        uasort($area_groups[$location_slug]['links'], static function (array $first, array $second): int {
            return strcasecmp($first['title'], $second['title']);
        });
        foreach ($area_groups[$location_slug]['groups'] as $group_key => $group_links) {
            uasort($area_groups[$location_slug]['groups'][$group_key], static function (array $first, array $second) use ($product_group_map, $group_key): int {
                $order = array_flip($product_group_map[$group_key]['slugs'] ?? []);

                return ($order[$first['product_slug']] ?? 999) <=> ($order[$second['product_slug']] ?? 999);
            });
        }
    }

    $area_groups = array_filter($area_groups, static fn (array $area_group): bool => ! empty($area_group['links']));
    $area_link_count = array_sum(array_map(static fn (array $area_group): int => count($area_group['links']), $area_groups));
    $ordered_area_groups = [];
    foreach ($town_order as $town_slug) {
        if (! empty($area_groups[$town_slug])) {
            $ordered_area_groups[$town_slug] = $area_groups[$town_slug];
        }
    }
    foreach ($area_groups as $town_slug => $area_group) {
        $ordered_area_groups[$town_slug] = $ordered_area_groups[$town_slug] ?? $area_group;
    }
    $featured_area_cards = [];
    foreach ($featured_area_slugs as $featured_slug => $featured_label) {
        $featured_area_cards[] = [
            'label' => $featured_label,
            'url' => '#area-' . $featured_slug,
            'copy' => sprintf(__('Windows, doors and glazing around %s.', 'fenster'), $featured_label),
        ];
    }
    ?>
    <article class="generated-page generated-page--areas fg-areas-page">
        <section class="fg-areas-page__hero">
            <div class="container fg-areas-page__hero-grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Local glazing coverage', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Find our glazing services near you.', 'fenster'); ?></h1>
                    <p><?php esc_html_e('We supply and install double glazing, windows, doors, roof lanterns and replacement glass from Milton Keynes across nearby towns in Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button button--light" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                        <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Ask about your postcode', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-areas-page__summary" aria-label="<?php esc_attr_e('Fenster service area summary', 'fenster'); ?>">
                    <strong><?php esc_html_e('Start with your nearest town.', 'fenster'); ?></strong>
                    <span><?php echo esc_html(sprintf(__('%d towns and %d local service links', 'fenster'), count($area_groups), $area_link_count)); ?></span>
                    <p><?php esc_html_e('You do not need to choose the perfect page. If your property is nearby, send the postcode and we can point you in the right direction.', 'fenster'); ?></p>
                </aside>
            </div>
        </section>

        <section class="fg-areas-page__featured" aria-label="<?php esc_attr_e('Popular local areas', 'fenster'); ?>">
            <div class="container">
                <div class="fg-areas-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Main local areas', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose the place closest to the property.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('These are the most common starting points for local double glazing, window and door enquiries.', 'fenster'); ?></p>
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

        <section class="fg-areas-page__services" aria-label="<?php esc_attr_e('Popular services by area', 'fenster'); ?>">
            <div class="container fg-areas-page__services-inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Popular services', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Most customers start with the product they need or the town they live in.', 'fenster'); ?></h2>
                </div>
                <nav class="fg-areas-page__service-links" aria-label="<?php esc_attr_e('Popular Fenster services', 'fenster'); ?>">
                    <?php foreach ($service_shortcuts as $service_shortcut) : ?>
                        <a href="<?php echo esc_url($service_shortcut['url']); ?>"><?php echo esc_html($service_shortcut['title']); ?></a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </section>

        <section class="fg-areas-page__body">
            <div class="container">
                <div class="fg-areas-page__section-head">
                    <p class="eyebrow"><?php esc_html_e('Browse by region', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Pick your town, then choose windows or doors.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Open the nearest town, choose the product group, then select the page that matches the project.', 'fenster'); ?></p>
                </div>
                <div class="fg-areas-page__town-picker">
                    <?php foreach ($ordered_area_groups as $town_slug => $area_group) : ?>
                        <details class="fg-areas-page__town-panel" id="area-<?php echo esc_attr($town_slug); ?>" <?php echo $town_slug === 'milton-keynes' ? 'open' : ''; ?>>
                            <summary>
                                <span><?php echo esc_html($area_group['label']); ?></span>
                                <em><?php esc_html_e('Choose Windows, Doors or extras', 'fenster'); ?></em>
                            </summary>
                            <div class="fg-areas-page__town-panel-body">
                                <a class="fg-areas-page__town-main" href="<?php echo esc_url(home_url('/double-glazing-' . $town_slug . '/')); ?>">
                                    <strong><?php echo esc_html('Double glazing in ' . $area_group['label']); ?></strong>
                                    <span><?php esc_html_e('Start with the main local glazing page', 'fenster'); ?></span>
                                </a>
                                <div class="fg-areas-page__product-groups">
                                    <?php foreach ($product_group_map as $group_key => $product_group) : ?>
                                        <?php if (empty($area_group['groups'][$group_key])) : ?>
                                            <?php continue; ?>
                                        <?php endif; ?>
                                        <details class="fg-areas-page__product-group" <?php echo $group_key === 'windows' ? 'open' : ''; ?>>
                                            <summary><?php echo esc_html($product_group['label']); ?></summary>
                                            <div class="fg-areas-page__links">
                                                <?php foreach ($area_group['groups'][$group_key] as $area_link) : ?>
                                                    <a href="<?php echo esc_url($area_link['url']); ?>">
                                                        <span><?php echo esc_html($area_link['title']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </details>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-areas-page__cta">
            <div class="container fg-areas-page__cta-inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Not sure where to start?', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send the postcode and a few project details.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('We can confirm whether the property is covered and whether an instant quote, showroom visit or survey is the best next step.', 'fenster'); ?></p>
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
    'commercial-replacement-glazing',
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
/* A MATRIX ROUTE IS NAMED BY THE MATRIX, NOT BY `pages.json`, AND THAT WAS THE
   SEVENTH PLACE THE 2026-08-12 RENAME HAD TO REACH.

   `data/pages.json` still carries scrape-era records for some town routes —
   eight for patio doors alone — and `fenster_generated_pages_index()` hands
   those raw titles back. The page itself never uses them, because
   `fenster_location_matrix_page()` overrides the title from
   `fenster_location_matrix_products()` when it builds the route. The related-
   links band did use them, so `/patio-doors/` rendered a row of links reading
   "Patio Doors Northampton" straight underneath its own H1 reading "uPVC
   Sliding Doors", and the page it linked to was titled "uPVC Sliding Doors
   Northampton" when you got there.

   So the matrix name wins here too, and it is derived rather than restated:
   change `fenster_location_matrix_products()` and this follows. Fixing the
   eight stale `pages.json` records instead would have left the same trap armed
   for the next rename. */
$route_title = static function (string $target_slug) use ($generated_pages, $virtual_page_titles, $known_locations): string {
    $matrix_products = function_exists('fenster_location_matrix_products') ? fenster_location_matrix_products() : [];

    foreach ($known_locations as $location_slug => $location_name) {
        if (! str_ends_with($target_slug, '-' . $location_slug)) {
            continue;
        }
        $product_slug = substr($target_slug, 0, -strlen('-' . $location_slug));
        if (isset($matrix_products[$product_slug])) {
            return $matrix_products[$product_slug] . ' ' . $location_name;
        }
        break;
    }

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

if ($is_product && ! $is_commercial && ! $is_commercial_county) {
    $add_related_route('double-glazing-milton-keynes', 'Double Glazing Milton Keynes');
    $add_related_route('window-door-prices-milton-keynes', 'Window and Door Prices Milton Keynes');
    $add_related_route('areas-we-cover', 'Areas We Cover');

    /* THE GUIDE THAT PRICES THIS PRODUCT, 2026-08-13. Five of the six product
       price guides were unreachable from the product they price: only composite
       doors linked its own, from the quote embed near the foot of this file.
       The map is keyed on the base route deliberately, so a town matrix route
       such as `composite-doors-northampton` is untouched.

       WHY THIS DOES NOT GO THROUGH `$add_related_route()`. It could now: the
       guide slugs were added to `$virtual_page_titles` above later the same day,
       so `$route_exists()` answers true for them and the
       `window-door-prices-milton-keynes` call three lines above finally renders.
       This map is kept because it says something `$add_related_route()` cannot,
       which is WHICH guide prices THIS product. The hub guide and the product
       guide are different links and both belong here.

       Titles are copied from `fenster_price_guide_pages()` rather than invented:
       inc/generated-pages.php lines 703, 718, 733, 763 and 778.

       `composite-doors` and `sliding-sash-windows` are in the map for
       completeness, but neither renders this band (see the gate on the links
       band at the foot of this file), so both also carry the link in the quote
       embed section. */
    $product_price_guides = [
        'composite-doors' => ['composite-door-prices', 'Composite Door Prices'],
        'sliding-sash-windows' => ['sash-window-prices', 'Sash Window Prices'],
        'aluminium-bifold-doors' => ['bifold-door-cost', 'Bifold Door Cost'],
        'aluminium-windows' => ['aluminium-window-prices', 'Aluminium Window Prices'],
        'patio-doors' => ['patio-french-door-prices', 'Patio and French Door Prices'],
        'french-doors' => ['patio-french-door-prices', 'Patio and French Door Prices'],
    ];
    if (
        isset($product_price_guides[$slug])
        && function_exists('fenster_price_guides_enabled')
        && fenster_price_guides_enabled()
    ) {
        [$product_price_guide_slug, $product_price_guide_label] = $product_price_guides[$slug];
        $related_links[$product_price_guide_slug] = [
            'text' => $product_price_guide_label,
            'url' => home_url('/' . $product_price_guide_slug . '/'),
        ];
    }
}

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
    $add_related_route('areas-we-cover', 'Areas We Cover');
    $add_related_route('window-door-prices-milton-keynes', 'Window and Door Prices Milton Keynes');

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
        'double-glazing-milton-keynes',
        'window-door-prices-milton-keynes',
        'areas-we-cover',
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

if ($is_commercial_product) {
    get_template_part('template-parts/sections/commercial-product', null, [
        'brand' => $brand,
        'page' => $page,
        'product' => $commercial_product,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_price_guide) {
    get_template_part('template-parts/sections/price-guide', null, [
        'brand' => $brand,
        'page' => $page,
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

if ($is_consultation_page) {
    get_template_part('template-parts/sections/consultation-booking', null, [
        'brand' => $brand,
        'page' => $page,
        'related_links' => $related_links,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($is_fensa_page) {
    get_template_part('template-parts/sections/fensa-approved', null, [
        'page' => $page,
    ]);
    return;
}

if ($is_cpa_page) {
    get_template_part('template-parts/sections/cpa-protection', null, [
        'page' => $page,
    ]);
    return;
}

if ($is_ggf_page) {
    get_template_part('template-parts/sections/ggf-standards', null, [
        'page' => $page,
    ]);
    return;
}

if ($is_constructionline_page) {
    get_template_part('template-parts/sections/constructionline-gold', null, [
        'page' => $page,
    ]);
    return;
}

if ($is_ssip_page) {
    get_template_part('template-parts/sections/ssip-health-and-safety', null, [
        'page' => $page,
    ]);
    return;
}

if ($slug === 'roof-lanterns') {
    get_template_part('template-parts/sections/roof-lanterns', null, [
        'page' => $page,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

if ($slug === 'heritage-aluminium-doors') {
    get_template_part('template-parts/sections/heritage-aluminium-doors', null, [
        'page' => $page,
        'title' => $title,
        'trust_items' => $trust_items,
        // Heritage doors are on the quote tool, productCollection=12 in the map
        // above. The route just never received the URL, so the page could not
        // offer the tool and its copy said the opposite.
        'quote_url' => $product_quote_embed_url,
        'quote_label' => $product_quote_embed_label,
        'brand' => $brand,
    ]);
    return;
}

if ($slug === 'flat-rooflights') {
    get_template_part('template-parts/sections/flat-rooflights', null, [
        'page' => $page,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

/* Scheduled blog posts render through their own template rather than the
   imported-guide article layout; see inc/blog-posts.php. */
$blog_post = function_exists('fenster_blog_post') ? fenster_blog_post($slug) : null;
if (is_array($blog_post)) {
    get_template_part('template-parts/sections/blog-post', null, [
        'page' => $page,
        'post' => $blog_post,
    ]);
    return;
}

if ($is_product_selector_hub) {
    get_template_part('template-parts/sections/product-hub', null, [
        'brand' => $brand,
        'group' => $product_hub_group,
        'instant_quote_preview' => $instant_quote_preview,
        'title' => $title,
        'trust_items' => $trust_items,
    ]);
    return;
}

/* `/online-quote/` has its own template. It shared `quote-tool.php` with
   `/3d-visualiser/` and five other slugs, which made three indexable routes
   render as the same page with a different H1. The visualiser keeps the shared
   template until it gets its own treatment; do not fold this back in. */
if ($slug === 'online-quote') {
    get_template_part('template-parts/sections/online-quote', null, [
        'brand' => $brand,
        'instant_quote_url' => $instant_quote_url,
        'page' => $page,
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

if ($slug === 'customer-portal') {
    get_template_part('template-parts/sections/customer-portal', null, [
        'page' => $page,
        'title' => $title,
    ]);
    return;
}

if ($is_window_handles) {
    $window_handle_intro = (string) ($window_handles['intro'] ?? 'Compare Fenster window handle finishes, locking detail and traditional handle options before the final specification is confirmed.');
    ?>
    <main class="fg-window-handle-page">
        <?php
        /* Owner, 2026-08-05: the photograph belongs at the top, the way a product
           page opens, with the copy over it and fading like the colour hub — and
           inverted if that suits the picture better. It does, so it is.

           What this replaced: `$window_handle_finishes[0]['image']` in a boxed
           panel beside the text, which was the first cut-out from the grid a few
           hundred pixels below, on a white card with a green glow, under the alt
           text "Fenster window handle finish option". The hero showed the first
           thing you scroll to, and whichever finish happened to sit first in the
           array was the face of the hub.

           Same direction as the colour hub: copy left on the solid end of a white
           veil, picture carrying the right. An inverted version was built first,
           on the reasoning that the hardware sits left in the frame, and it looked
           wrong (owner, same day). The fix belonged in the crop rather than in the
           layout — the file is now cut from the left edge of the original so the
           lever lands at roughly 72%, out where the veil has cleared.

           The blown-out window that then fills the left of the crop is not a
           defect, it is what makes the fade seamless: it is already white exactly
           where the veil is white, so there is no visible join between the solid
           end of the gradient and the photograph beneath it.

           The door frame rather than the window one. The hub covers both families,
           the long backplate carrying a lever and a cylinder is the more
           substantial piece of hardware, and the window frame from the same shoot
           has a bright, busy driveway behind it that fights the copy at every
           width. */
        ?>
        <section class="fg-window-handle-hero fg-window-handle-hero--photo">
            <div class="fg-window-handle-hero__photo">
                <img src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/images/products/handles/handle-hero-detail.jpg')); ?>"
                    alt="<?php esc_attr_e('A lever handle on the long backplate of a black woodgrain composite door', 'fenster'); ?>"
                    width="2400" height="1000" loading="eager" fetchpriority="high">
            </div>
            <div class="fg-window-handle-hero__veil" aria-hidden="true"></div>
            <div class="container fg-window-handle-hero__grid">
                <div class="fg-window-handle-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Specification hub', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Window and door handle options.', 'fenster'); ?></h1>
                    <p><?php esc_html_e('Every handle finish we fit, for windows and for doors, on one page. Windows take the S2 Signature range, tilt and turn takes its own locking lever, hinged doors take a long backplate that carries the lever and the cylinder together, and sliding patio doors take a D-pull. We confirm what a given system can take at specification stage.', 'fenster'); ?></p>
                    <a class="button" href="#fenster-enquiry"><?php esc_html_e('Ask about handles', 'fenster'); ?></a>
                </div>
            </div>
        </section>

        <?php
        /* Both handle families render through the same component, so the hub
           presents them identically. Doors moved here from the product pages on
           2026-07-29; those pages now carry the compact grid instead. */
        get_template_part('template-parts/components/handle-chooser', null, [
            'id' => 'window-handle-finishes',
            'modifier' => 'fg-window-handles--hub',
            'eyebrow' => 'Window handles',
            'heading' => 'Six finishes, lockable as standard.',
            'intro' => 'The S2 Signature range, in left and right hand versions so the operation matches the way the window opens. Monkey tail is the traditional option, where the window system takes it.',
            'data' => $window_handles,
            'alt_pattern' => '%s window handle',
            'details_heading' => 'Technical specification',
            'swatches_label' => 'Window handle finish options',
            'features_label' => 'Window handle features',
            'eager_first' => true,
        ]);

        get_template_part('template-parts/components/handle-chooser', null, [
            'id' => 'tilt-turn-handle-finishes',
            'modifier' => 'fg-window-handles--hub fg-tilt-turn-handles',
            'eyebrow' => 'Tilt and turn handles',
            'heading' => 'One lever does the tilting and the turning.',
            'intro' => (string) ($tilt_turn_handles['intro'] ?? ''),
            'data' => $tilt_turn_handles,
            'alt_pattern' => 'greenteQ Alpha TBT tilt and turn window handle in %s',
            'details_heading' => 'Handle specification',
            'swatches_label' => 'Tilt and turn handle finish options',
            'features_label' => 'Tilt and turn handle features',
        ]);

        get_template_part('template-parts/components/handle-chooser', null, [
            'id' => 'door-handle-finishes',
            'modifier' => 'fg-window-handles--hub fg-door-handles',
            'eyebrow' => 'Door handles',
            'heading' => 'Door handles in finishes that match the frame and letterplate.',
            'intro' => (string) ($door_handles['intro'] ?? ''),
            'data' => $door_handles,
            'alt_pattern' => 'Long-plate door handle in %s',
            'details_heading' => 'Door hardware note',
            'swatches_label' => 'Door handle finish options',
            'features_label' => 'Door handle features',
        ]);

        /* Patio last, because it is the one family that is not a lever, so it
           reads better after the three that are. Added 2026-08-02, closing the
           "patio to come" note this hub was built with. */
        get_template_part('template-parts/components/handle-chooser', null, [
            'id' => 'patio-handle-finishes',
            'modifier' => 'fg-window-handles--hub fg-patio-handles',
            'eyebrow' => 'Patio door handles',
            'heading' => 'A pull, not a lever, on a sliding door.',
            'intro' => (string) ($patio_handles['intro'] ?? ''),
            'data' => $patio_handles,
            'alt_pattern' => 'Mila ProLinea sliding patio door handle in %s',
            'details_heading' => 'Handle specification',
            'swatches_label' => 'Patio door handle finish options',
            'features_label' => 'Patio door handle features',
        ]);

        /* Fifth family on the hub, and the one that closes the "patio to come"
           note this page was built with. A lift and slide is a different
           mechanism from the uPVC slider above it, which is why it is here
           rather than folded into that section. */
        get_template_part('template-parts/components/handle-chooser', null, [
            'id' => 'lift-slide-handle-finishes',
            'modifier' => 'fg-window-handles--hub fg-lift-slide-handles',
            'eyebrow' => 'Lift and slide door handles',
            'heading' => 'A lever inside, a finger cup outside.',
            'intro' => (string) ($lift_slide_handles['intro'] ?? ''),
            'data' => $lift_slide_handles,
            'alt_pattern' => 'architeQ Aspire lift and slide door handle in %s',
            'details_heading' => 'Handle specification',
            'swatches_label' => 'Lift and slide door handle finish options',
            'features_label' => 'Lift and slide door handle features',
        ]);
        ?>

        <?php
        /* Owner, 2026-08-05: a banner through to the colour hub. It sits here,
           after all five handle families and before the enquiry, because that is
           where the page has answered the question it was opened for. The enquiry
           immediately below already says "bring handles, colours and glass
           together", so the two read as one thought rather than as a CTA landing
           on top of another.

           The swatches are read from `colour_options.materials.upvc.colours`, the
           same source the colour hub and the product-page grids use, so this can
           never drift out of step with the real palette. Eight of them, purely as
           a visual: they are decoration for a link, not a chooser, so they carry
           no names and are hidden from assistive tech, which reads the heading and
           the link instead. Frame colour is the point, and the handle finishes the
           page just listed are their own decision — deliberately no claim here
           about one matching the other. */
        $banner_colours = fenster_data('colour_options.materials.upvc.colours', []);
        $banner_colours = is_array($banner_colours) ? array_slice(array_values($banner_colours), 0, 8) : [];
        ?>
        <?php if ($banner_colours !== []) : ?>
            <section class="fg-handle-colour-banner" aria-labelledby="fg-handle-colour-banner-title">
                <div class="container fg-handle-colour-banner__panel">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Next decision', 'fenster'); ?></p>
                        <h2 id="fg-handle-colour-banner-title"><?php esc_html_e('The frame the handle goes on.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Sixteen uPVC foils and any RAL colour in aluminium, with the inside face specified separately from the outside. Every swatch, on one page.', 'fenster'); ?></p>
                    </div>
                    <div class="fg-handle-colour-banner__aside">
                        <span class="fg-handle-colour-banner__swatches" aria-hidden="true">
                            <?php foreach ($banner_colours as $banner_colour) : ?>
                                <i style="background: <?php echo esc_attr((string) ($banner_colour['hex'] ?? '#cccccc')); ?>"></i>
                            <?php endforeach; ?>
                        </span>
                        <a class="button" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('See every colour', 'fenster'); ?></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section id="fenster-enquiry" class="fg-obscure-enquiry">
            <div class="container fg-obscure-enquiry__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Match the full specification', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Bring handles, colours and glass together before ordering.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('We confirm the final handle choice during survey so it works with the chosen window system, colour and opening style.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form',
                    'source' => $title,
                    'button_label' => 'Ask about window handles',
                    'project_type' => 'Windows',
                ]);
                ?>
            </div>
        </section>
    </main>
    <?php
    return;
}

if ($is_colour_options) {
    $active_material = $slug === 'aluminium-colours' ? 'aluminium' : ($slug === 'upvc-colours' ? 'upvc' : 'upvc');

    /* Integral blind slats belong on the hub too, on the owner's instruction of
       2026-08-04. Built here from `notan_blind_colours` rather than copied into
       `colour_options`, so the hub and the visualiser on /integral-blinds/
       cannot drift apart: there is one list of nine and both read it.

       It is deliberately last. Frame colour is the decision most people came
       for, and the slats are a different surface on a different product. */
    $notan_slats = fenster_data('notan_blind_colours', []);
    $notan_slats = is_array($notan_slats) ? array_values($notan_slats) : [];

    if ($notan_slats !== []) {
        $colour_materials['integral-blinds'] = [
            'label' => __('Integral blind colours', 'fenster'),
            'slug' => 'integral-blind-colours',
            'headline' => __('Integral blind colours.', 'fenster'),
            'copy' => __('These are the slats themselves, sealed inside the glass, not a frame finish. Nine are standard and bespoke RAL is available to order. White/Anthracite is the one to look at twice: it is white on the room side and anthracite outside, so the same blind can suit the room and the elevation at once. The frame around a blind unit takes the colour of whichever window or door it is built into.', 'fenster'),
            'colours' => array_map(
                static function (array $slat): array {
                    $code = trim((string) ($slat['code'] ?? ''));
                    return [
                        'name' => (string) ($slat['name'] ?? 'Slat colour'),
                        'hex' => (string) ($slat['hex'] ?? '#ffffff'),
                        /* The reverse face is the whole point of BY012, so say
                           so here rather than leaving the swatch to imply a
                           plain white slat. */
                        'hex_reverse' => (string) ($slat['reverse'] ?? ''),
                        'glitter' => ! empty($slat['glitter']),
                        'finish' => ! empty($slat['reverse'])
                            ? trim($code . ' ' . __('two sided, anthracite outside', 'fenster'))
                            : $code,
                    ];
                },
                array_filter($notan_slats, 'is_array')
            ),
        ];
    }
    $render_colour_material = static function (string $material_key, array $material, string $active_material): void {
        $colours = is_array($material['colours'] ?? null) ? array_values($material['colours']) : [];
        ?>
        <article
            class="fg-colour-hub__material<?php echo $material_key === $active_material ? ' is-active' : ''; ?>"
            id="<?php echo esc_attr((string) ($material['slug'] ?? $material_key)); ?>"
            data-fg-colour-material="<?php echo esc_attr($material_key); ?>"
        >
            <div class="fg-colour-hub__material-copy">
                <?php
                /* No eyebrow here. Every label in the data repeats its own
                   heading word for word, so the card said "uPVC colours" twice
                   before it said anything. The label is still used for the
                   rail's accessible name. */
                ?>
                <h2><?php echo esc_html((string) ($material['headline'] ?? 'Compare colour options.')); ?></h2>
                <?php
                /* Each collection's explainer runs long on a phone and pushes
                   the swatches themselves off the screen, which is what people
                   came for. It collapses there, not on desktop.

                   No clamp in the markup or the base stylesheet: the controller
                   adds it, so a page where the script never runs shows the
                   paragraph in full rather than cut off with no way to open. */
                $material_copy_id = 'fg-colour-copy-' . sanitize_html_class($material_key);
                ?>
                <p id="<?php echo esc_attr($material_copy_id); ?>"><?php echo esc_html((string) ($material['copy'] ?? '')); ?></p>
                <button class="fg-colour-readmore" type="button" data-fg-readmore aria-controls="<?php echo esc_attr($material_copy_id); ?>" aria-expanded="false" hidden>
                    <span data-fg-readmore-label><?php esc_html_e('Read more', 'fenster'); ?></span>
                </button>
            </div>
            <?php
            /* Equal-width swipeable rail, replacing the coverflow on 2026-07-29.
               Owner instruction: the front slide was massive and the rest stacked
               behind it. Modelled on the Sheerline frame-corner rail, which runs
               four across on a wide screen, three at tablet and about one and a
               half on a phone so the next one peeks.

               Deliberately its own component rather than a rewrite of
               .fg-colour-carousel: that class and its controller are shared with
               the heritage door configurations carousel, which is a different job
               and was not part of this instruction. */
            ?>
            <div class="fg-colour-rail" data-fg-colour-rail>
                <ul class="fg-colour-rail__track" data-fg-colour-rail-viewport tabindex="0" role="region" aria-label="<?php echo esc_attr(sprintf(__('%s. Scroll or swipe sideways.', 'fenster'), (string) ($material['label'] ?? 'Colours'))); ?>">
                        <?php foreach ($colours as $colour) : ?>
                        <?php $swatch = (string) ($colour['hex'] ?? '#ffffff'); ?>
                        <?php
                        /* A two sided slat carries its reverse face as well, so
                           the tile shows both rather than reading as a plain
                           white one. Only the blind colours use it. */
                        $swatch_reverse = trim((string) ($colour['hex_reverse'] ?? ''));
                        $swatch_style = '--swatch:' . $swatch;
                        if ($swatch_reverse !== '') {
                            $swatch_style .= ';--swatch-reverse:' . $swatch_reverse;
                        }
                        ?>
                    <li class="fg-colour-rail__slide<?php echo $swatch_reverse !== '' ? ' is-two-sided' : ''; ?><?php echo ! empty($colour['glitter']) ? ' is-glitter' : ''; ?>" style="<?php echo esc_attr($swatch_style); ?>" data-fg-colour-slide data-colour-slug="<?php echo esc_attr(sanitize_title((string) ($colour['name'] ?? ''))); ?>">
                            <?php
                            /* A near-white swatch on a white card reads as an
                               empty slot rather than a colour, so it takes a
                               hairline. Composite white is the case that forced
                               this; it applies to any pale tile. */
                            $is_pale_swatch = (bool) preg_match('/^#[0-9a-f]{6}$/i', $swatch)
                                && min(
                                    hexdec(substr($swatch, 1, 2)),
                                    hexdec(substr($swatch, 3, 2)),
                                    hexdec(substr($swatch, 5, 2))
                                ) > 228;
                            ?>
                            <span class="fg-colour-rail__media<?php echo $is_pale_swatch ? ' is-pale' : ''; ?>">
                                <?php if (! empty($colour['image'])) : ?>
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $colour['image'])); ?>" alt="<?php echo esc_attr((string) ($colour['name'] ?? 'Colour')); ?>" loading="lazy">
                                <?php else : ?>
                                    <i aria-hidden="true"></i>
                                <?php endif; ?>
                            </span>
                            <h3><?php echo esc_html((string) ($colour['name'] ?? 'Colour')); ?></h3>
                            <?php if (! empty($colour['finish'])) : ?>
                                <p><?php echo esc_html((string) $colour['finish']); ?></p>
                            <?php endif; ?>
                    </li>
                        <?php endforeach; ?>
                </ul>
                <?php /* No buttons and no counter: the owner asked for swipe and
                         said the numbers were not needed. Touch and trackpad get
                         it natively from scroll-snap, and the controller adds
                         click-drag with a glide so a mouse can do the same. */ ?>
                <p class="fg-colour-rail__hint"><?php esc_html_e('Drag or swipe to see more', 'fenster'); ?></p>
            </div>
        </article>
        <?php
    };
    ?>
    <?php
    /* Hero colour wall, 2026-07-29. Owner: the header looked unexciting and
       wanted "tonnes of colour". Built from the real range rather than
       decoration, so every tile is a finish that can actually be ordered and
       adding a colour to the data adds it to the hero.

       Weighted toward the lighter and more saturated finishes: an even shuffle
       of this range reads almost black, because most of it is grey, charcoal
       and dark green. The bright end is nearly all composite. */
    $colour_wall = [];
    foreach ($colour_materials as $wall_material) {
        foreach ((array) ($wall_material['colours'] ?? []) as $wall_colour) {
            $wall_hex = strtolower((string) ($wall_colour['hex'] ?? ''));
            if (preg_match('/^#[0-9a-f]{6}$/', $wall_hex)) {
                $colour_wall[$wall_hex] = $wall_hex;
            }
        }
    }
    $colour_wall = array_values($colour_wall);

    $colour_wall_channels = static function (string $hex): array {
        return [
            hexdec(substr($hex, 1, 2)),
            hexdec(substr($hex, 3, 2)),
            hexdec(substr($hex, 5, 2)),
        ];
    };
    $colour_wall_score = static function (string $hex) use ($colour_wall_channels): float {
        [$r, $g, $b] = $colour_wall_channels($hex);
        $max = max($r, $g, $b);
        return ($max * 0.55) + (($max - min($r, $g, $b)) * 0.85);
    };
    /* Three of the foils are effectively white. Rather than keep them out of
       the pale part of the fade, which only works if PHP knows the column count
       the CSS chose, they carry a hairline so a white tile still reads as a
       tile wherever it lands. */
    $colour_wall_is_near_white = static function (string $hex) use ($colour_wall_channels): bool {
        return min($colour_wall_channels($hex)) > 228;
    };

    usort($colour_wall, static function ($a, $b) use ($colour_wall_score) {
        return $colour_wall_score($b) <=> $colour_wall_score($a);
    });

    $colour_wall_pool = [];
    foreach ($colour_wall as $wall_index => $wall_hex) {
        $repeat = $wall_index < 20 ? 3 : ($wall_index < 32 ? 2 : 1);
        for ($n = 0; $n < $repeat; $n++) {
            $colour_wall_pool[] = $wall_hex;
        }
    }

    /* Deliberately more tiles than the widest grid needs. Rows are a fixed
       height and the section clips, so the wall always runs off the bottom
       rather than leaving a bald patch when the column count changes.

       Named rather than a bare number on purpose. The obscure glass hero below
       ran the identical literal until its wall was rebuilt as six columns of
       36, and that edit clipped this loop to 36 as well, which left the colour
       wall a row and a half deep in a section several hundred pixels tall.
       These are two different grids. Do not match this to the glass count. */
    $colour_wall_tile_count = 336;
    $colour_wall_tiles = [];
    if ($colour_wall_pool !== []) {
        $colour_wall_count = count($colour_wall_pool);
        for ($i = 0; $i < $colour_wall_tile_count; $i++) {
            $colour_wall_tiles[] = $colour_wall_pool[(($i * 11) + (intdiv($i, 28) * 5)) % $colour_wall_count];
        }
    }
    ?>
    <main class="fg-colour-hub-page">
        <section class="fg-colour-hub-hero fg-colour-hub-hero--wall">
            <?php if ($colour_wall_tiles !== []) : ?>
                <div class="fg-colour-hub-hero__wall" aria-hidden="true">
                    <?php foreach ($colour_wall_tiles as $wall_tile) : ?>
                        <span class="<?php echo $colour_wall_is_near_white($wall_tile) ? 'is-pale' : ''; ?>" style="<?php echo esc_attr('background:' . $wall_tile); ?>"></span>
                    <?php endforeach; ?>
                </div>
                <div class="fg-colour-hub-hero__veil" aria-hidden="true"></div>
            <?php endif; ?>
            <div class="container fg-colour-hub-hero__grid">
                <div class="fg-colour-hub-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Specification hub', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Colour options for Fenster windows and doors.', 'fenster'); ?></h1>
                    <p><?php echo esc_html((string) ($colour_options['intro'] ?? $hero_intro)); ?></p>
                    <div class="fg-colour-hub-hero__actions">
                        <a class="button" href="<?php echo esc_url($instant_quote_url); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                        <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
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

        <?php
        /* Owner instruction, 2026-07-29: send people to the handle hub once they
           have been through the colours. Handles are the same kind of decision
           one step on, so the finishes are pulled from the S2 data rather than
           hardcoded here: the strip cannot fall out of step with the hub it
           links to. */
        $handle_finishes = (array) fenster_data('window_handles.finishes', []);
        $handle_finishes = array_values(array_filter(
            $handle_finishes,
            static fn ($finish): bool => is_array($finish) && ! empty($finish['image'])
        ));
        ?>
        <?php if ($handle_finishes !== []) : ?>
            <section class="fg-colour-next">
                <div class="container">
                    <a class="fg-colour-next__box" href="<?php echo esc_url(home_url('/handle-options/')); ?>">
                        <span class="fg-colour-next__copy">
                            <span class="eyebrow"><?php esc_html_e('Next choice', 'fenster'); ?></span>
                            <span class="fg-colour-next__title"><?php esc_html_e('Handle options.', 'fenster'); ?></span>
                            <span class="fg-colour-next__text"><?php esc_html_e('Frame colour is one half of how a window reads. The handle is the part you touch every day, and it comes in its own set of finishes for windows, doors and patio doors.', 'fenster'); ?></span>
                            <span class="button"><?php esc_html_e('See handle options', 'fenster'); ?></span>
                        </span>
                        <span class="fg-colour-next__strip" aria-hidden="true">
                            <?php foreach (array_slice($handle_finishes, 0, 5) as $handle_finish) : ?>
                                <span class="fg-colour-next__handle">
                                    <img <?php echo fenster_image_attr_string((string) $handle_finish['image'], [
                                        'alt' => '',
                                        'loading' => 'lazy',
                                    ]); ?>>
                                </span>
                            <?php endforeach; ?>
                        </span>
                    </a>
                </div>
            </section>
        <?php endif; ?>

        <section id="fenster-enquiry" class="fg-obscure-enquiry">
            <div class="container fg-obscure-enquiry__grid">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Bring samples together', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Match frame colour, glass and hardware before ordering.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('We can help narrow the material, colour, glass and handle choices around the property rather than treating each decision separately.', 'fenster'); ?></p>
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
    /* Optional per-pattern scale. Only the photographed textures need it — a CSS
       gradient has no intrinsic size to get wrong — and without it `cover` blows a
       photograph up to whatever box it lands in, which is what made Reeded read as
       giant fluting on a 58px swatch. Defaults to `cover` so nothing else changes. */
    $obscure_glass_texture_size = static function (array $texture): string {
        $size = trim((string) ($texture['size'] ?? ''));
        return $size !== '' ? $size : 'cover';
    };
    $active_glass_texture = is_array($obscure_glass_first) ? $obscure_glass_texture_value($obscure_glass_first) : 'none';
    $active_glass_texture_size = is_array($obscure_glass_first) ? $obscure_glass_texture_size($obscure_glass_first) : 'cover';
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
            data-size="<?php echo esc_attr(trim((string) ($texture['size'] ?? 'cover'))); ?>"
            data-name="<?php echo esc_attr($texture_name); ?>"
            data-key="<?php echo esc_attr(sanitize_title($texture_name)); ?>"
            data-privacy="<?php echo esc_attr((string) $privacy); ?>"
            data-copy="<?php echo esc_attr((string) ($texture['copy'] ?? '')); ?>"
            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
        >
            <span style="<?php echo esc_attr('--texture:' . $texture_value . '; --texture-size:' . trim((string) ($texture['size'] ?? 'cover')) . ';'); ?>" aria-hidden="true"></span>
            <strong><?php echo esc_html($texture_name); ?></strong>
            <small><?php echo esc_html($privacy === 0 ? 'Decorative' : 'Privacy ' . $privacy); ?></small>
        </button>
        <?php
    };
    ?>
    <article class="fg-obscure-glass-page">
        <section class="fg-obscure-hero">
            <?php
            /* The wall. Direct child of the section, not of `.container`, or
               `inset: 0` resolves against the centred column and the whole thing
               sits in a box.

               Every pattern once before any of them twice. There are 21 textures
               and the visible grid is six columns by three rows, so the eighteen
               tiles anybody actually sees are all different glass — which is the
               point of a wall on this particular page. Walking the list in order
               would put Cotswold, Satin and Arctic side by side in row one and
               again in row four; stepping by 8 instead is a full permutation of
               21 (they share no factor), so consecutive tiles are never
               neighbours in the list either. Only the rows below the clip, which
               exist so the wall never stops short, reuse anything. */
            /* Mayflower and Tribal are out of the wall on the owner's instruction.
               They stay in the picker below, where somebody choosing glass can
               still find them — this only decides what the hero advertises. */
            $obscure_wall_skip = ['mayflower', 'tribal'];
            $obscure_wall_pool = array_values(array_filter(
                $obscure_glass_textures,
                static function (array $texture) use ($obscure_wall_skip): bool {
                    return ! in_array(sanitize_title((string) ($texture['name'] ?? '')), $obscure_wall_skip, true);
                }
            ));
            $obscure_wall_tiles = [];
            if ($obscure_wall_pool !== []) {
                $obscure_wall_count = count($obscure_wall_pool);
                for ($i = 0; $i < 36; $i++) {
                    $obscure_wall_tiles[] = $obscure_wall_pool[($i * 8) % $obscure_wall_count];
                }
            }
            ?>
            <div class="fg-obscure-hero__preview" aria-hidden="true">
                <?php foreach ($obscure_wall_tiles as $texture) : ?>
                    <span style="<?php echo esc_attr('--texture:' . $obscure_glass_texture_value($texture) . '; --texture-size:' . $obscure_glass_texture_size($texture) . ';'); ?>"></span>
                <?php endforeach; ?>
            </div>
            <div class="fg-obscure-hero__veil" aria-hidden="true"></div>
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
                    <?php /* Painted with the house already in place, because the JS
                             now starts on 'house' too. If this still rendered Legend the
                             scene would visibly swap the moment the script ran. */ ?>
                    style="<?php echo esc_attr('--scene-image:url(' . fenster_generated_url($house_image !== '' ? $house_image : $legend_image) . '); --active-texture:' . $active_glass_texture . '; --active-texture-size:' . $active_glass_texture_size . '; --privacy:' . $active_glass_privacy); ?>"
                    data-cat-image="<?php echo esc_url(fenster_generated_url($legend_image)); ?>"
                    data-house-image="<?php echo esc_url(fenster_generated_url($house_image)); ?>"
                    data-active-background="house"
                    data-active-glass="<?php echo esc_attr($active_glass_key); ?>"
                >
                    <div class="fg-obscure-stage__viewport" data-fg-obscure-tilt>
                        <div class="fg-obscure-stage__main-image" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__glass" data-fg-obscure-glass-layer aria-hidden="true"></div>
                        <div class="fg-obscure-stage__shine" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__scan" aria-hidden="true"></div>
                        <div class="fg-obscure-stage__divider" aria-hidden="true"><span></span></div>
                        <input class="fg-obscure-stage__range" type="range" min="0" max="100" value="54" aria-label="<?php esc_attr_e('Move the clear and obscured glass comparison divider', 'fenster'); ?>" data-fg-obscure-split>
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

                <?php
                /*
                 * Flat item-level snap rail. The previous full-width page chunks
                 * with scroll-snap-type: x mandatory would not swipe on iPhones
                 * (WebKit snaps straight back on 100%-width snap pages); this is
                 * the same native card-rail pattern as the rest of the site.
                 */
                ?>
                <div class="fg-obscure-mobile-picker" role="list" aria-label="<?php esc_attr_e('Obscured glass pattern options', 'fenster'); ?>" data-lenis-prevent>
                    <?php foreach ($obscure_glass_textures as $index => $texture) : ?>
                        <?php $render_obscure_glass_option($texture, (int) $index); ?>
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
                    <h2><?php esc_html_e('All obscured glass options at a glance.', 'fenster'); ?></h2>
                </div>
                <div class="fg-obscure-compare__grid">
                    <?php foreach ($obscure_glass_textures as $texture) : ?>
                        <?php $privacy = (int) ($texture['privacy'] ?? 0); ?>
                        <article>
                            <span style="<?php echo esc_attr('--texture:' . $obscure_glass_texture_value($texture) . '; --texture-size:' . $obscure_glass_texture_size($texture) . ';'); ?>" aria-hidden="true"></span>
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
                    <h2><?php esc_html_e('Ask us which obscured glass works with your product.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us whether the glass is for a bathroom, entrance door, side panel, replacement unit or another product and we will help narrow the options.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form',
                    'source' => 'Obscured glass page',
                    'button_label' => 'Ask about obscured glass',
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
                        <h2><?php esc_html_e('Products that can use obscured glass', 'fenster'); ?></h2>
                    </div>
                    <?php
                    get_template_part('template-parts/components/link-cards', null, [
                        'links' => array_slice(array_values($related_links), 0, 18),
                    ]);
                    ?>
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
    /* THE HUB MOVED OUT OF THIS FILE ON 2026-08-12. It was ~280 lines inline in
       a template already past 3,000, which is most of why nobody spotted that it
       linked five of the twelve commercial routes and that one of those five
       left the commercial section entirely. It lives in its own template now and
       the reasoning is in the header there. */
    get_template_part('template-parts/sections/commercial-glazing-v2', null, [
        'brand' => $brand,
        'hero' => $hero_media_src,
        'related_links' => $related_links,
    ]);
    return;
}
?>
<article class="generated-page generated-page--<?php echo esc_attr($is_commercial ? 'commercial' : 'residential'); ?> <?php echo esc_attr($use_product_journey ? 'generated-page--product-journey' : ''); ?> <?php echo esc_attr($is_aluminium_windows ? 'generated-page--aluminium-windows-story' : ''); ?> <?php echo esc_attr($is_integral_blinds ? 'generated-page--integral-blinds-reveal' : ''); ?> <?php echo esc_attr($slug === 'sliding-sash-windows' ? 'generated-page--sliding-sash' : ''); ?> <?php echo esc_attr($is_composite_doors ? 'generated-page--composite-doors' : ''); ?>">
    <?php if ($is_roofline && $roofline_story_desktop_frames) : ?>
    <?php /* Same component as aluminium windows, different sequence. The panel
             count is +1 because the first panel is the H1 rather than a part. */ ?>
    <section class="fg-aw-story fg-aw-story--roofline" data-fg-aw-story style="--fg-aw-panel-count: <?php echo esc_attr((string) (count($roofline_story_panels) + 1)); ?>;">
        <div class="fg-aw-story__stage">
            <canvas
                class="fg-aw-story__canvas"
                data-fg-aw-story-canvas
                data-desktop-frame="<?php echo esc_url($roofline_story_desktop_frames); ?>"
                data-mobile-frame="<?php echo esc_url($roofline_story_mobile_frames); ?>"
                data-frame-count="1"
                aria-hidden="true"
            ></canvas>
            <noscript><img class="fg-aw-story__fallback" src="<?php echo esc_url($roofline_story_poster); ?>" alt="White fascia, black guttering and a vented soffit with downlights above a set of bifold doors"></noscript>
            <div class="fg-aw-story__shade"></div>
            <?php /* THE HIGHLIGHT IS THE POINT, not the line drawing. Owner,
                     2026-08-15: it "wants to highlight individual components of
                     the roofline and explain/sell as you scroll", not turn into
                     a drawing for its own sake. So the trace exists to make the
                     isolation readable and nothing more.

                     The regions were read off a coordinate grid laid over the
                     photograph rather than guessed, and they are percentages of
                     the frame so they track the canvas at any width. Each one
                     sits on a part that is genuinely visible: the fascia along
                     the left roof edge, the soffit under the boxed corner, the
                     gutter run with its union, and the downpipe with its swan
                     neck.

                     NO JAVASCRIPT. The story controller already puts `is-active`
                     on the panel it has scrolled to, so `:has()` drives which
                     region lights from that alone. Where `:has()` is not
                     supported nothing highlights and the page is exactly what it
                     was, which is the right way round for progressive
                     enhancement. */ ?>
            <div class="fg-rl-parts" aria-hidden="true">
                <span class="fg-rl-parts__scrim"></span>
                <span class="fg-rl-zone fg-rl-zone--fascia"></span>
                <span class="fg-rl-zone fg-rl-zone--soffit"></span>
                <span class="fg-rl-zone fg-rl-zone--gutter"></span>
                <span class="fg-rl-pin fg-rl-pin--fascia" style="--x: 84%; --y: 58%;"><i></i><b>Fascia</b></span>
                <span class="fg-rl-pin fg-rl-pin--soffit" style="--x: 34%; --y: 60%;"><i></i><b>Soffit</b></span>
                <span class="fg-rl-pin fg-rl-pin--gutter" style="--x: 80%; --y: 30%;"><i></i><b>Guttering</b></span>
            </div>
            <div class="fg-aw-story__grain" aria-hidden="true"></div>
            <div class="container fg-aw-story__content">
                <div class="fg-aw-story__panel is-active" data-fg-aw-story-panel>
                    <p class="eyebrow"><?php esc_html_e('Fascias, soffits and guttering', 'fenster'); ?></p>
                    <h1><?php echo esc_html($title); ?></h1>
                    <p><?php esc_html_e('The boards and gutters along the edge of your roof. Scroll to see what each one does.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="#fenster-enquiry"><?php echo esc_html($cta_label); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                    </div>
                </div>
                <?php foreach ($roofline_story_panels as $index => $story_panel) : ?>
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
    <?php elseif ($is_aluminium_windows && $aluminium_windows_story_desktop_frames) : ?>
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
                        <?php if ($offers_instant_price) : ?>
                            <a class="button button--light" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
                        <?php else : ?>
                            <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                        <?php endif; ?>
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
    <?php elseif ($is_composite_doors) : ?>
    <?php
    // Composite doors follows the light, boxed-image hero used by
    // /roof-lanterns/ and /heritage-aluminium-doors/ rather than the shared
    // dark photo hero. Styling is shared with those routes in main.scss.
    // Chosen by rendering every candidate at the real 6/5 hero crop: this is the
    // only one where a whole door sits centred and uncut in frame.
    $composite_hero_img = '/wp-content/themes/fenster/assets/images/products/composite-distinction/gallery/black-lunna-entrance-800w.webp';
    $composite_phone = (string) ($brand['phone'] ?? '01908 429200');
    ?>
    <section class="fg-cd3-hero">
        <div class="container fg-cd3-hero__grid">
            <div class="fg-cd3-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Composite doors in Milton Keynes', 'fenster'); ?></p>
                <h1><?php esc_html_e('Distinction composite doors', 'fenster'); ?></h1>
                <p class="fg-cd3-hero__lead"><?php esc_html_e('A 44.5mm insulated slab under a tough GRP skin, fitted across Milton Keynes by our own installers. It holds its heat, shrugs off the weather and keeps its colour without a paintbrush.', 'fenster'); ?></p>
                <div class="fg-cd3-hero__actions">
                    <a class="button" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $composite_phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $composite_phone)); ?></a>
                </div>
            </div>
            <figure class="fg-cd3-hero__media">
                <img <?php echo fenster_image_attr_string($composite_hero_img, [
                    'alt' => 'A black composite front door with arched decorative glass, set between white pillars on a brick frontage',
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                ]); ?>>
                <figcaption><?php esc_html_e('Distinction composite door', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-cd3-brief" aria-label="<?php esc_attr_e('Composite door specification summary', 'fenster'); ?>">
        <div class="container">
            <div class="fg-cd3-brief__grid">
                <p><strong><?php esc_html_e('44.5mm slab', 'fenster'); ?></strong><span><?php esc_html_e('Insulated GRP, against 28mm for a uPVC door panel', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('£5,000', 'fenster'); ?></strong><span><?php esc_html_e('Break-in guarantee, terms confirmed before you order', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('Six collections', 'fenster'); ?></strong><span><?php esc_html_e('The same six you meet in our quote tool', 'fenster'); ?></span></p>
                <p><strong><?php esc_html_e('10 years', 'fenster'); ?></strong><span><?php esc_html_e('Insurance-backed installation guarantee', 'fenster'); ?></span></p>
            </div>
        </div>
    </section>
    <?php else : ?>
    <section class="fg-hero <?php echo esc_attr($use_product_journey ? 'fg-hero--compact' : ''); ?>">
        <?php if ($is_home) : ?>
            <video class="fg-hero__video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>">
                <source src="<?php echo esc_url($sick_video); ?>" type="video/mp4">
            </video>
        <?php elseif ($hero_media_src) : ?>
            <?php if ($slug === 'sliding-sash-windows') : ?>
                <img <?php echo fenster_image_attr_string($hero_media_src, [
                    'class' => 'fg-hero__image',
                    'alt' => 'White Roseview sliding sash bay window fitted to a red-brick home',
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                    'srcset' => implode(', ', [
                        fenster_generated_url('/wp-content/themes/fenster/assets/images/products/sash-roseview/hero/roseview-sash-bay-480w.webp') . ' 480w',
                        fenster_generated_url('/wp-content/themes/fenster/assets/images/products/sash-roseview/hero/roseview-sash-bay-960w.webp') . ' 960w',
                        fenster_generated_url('/wp-content/themes/fenster/assets/images/products/sash-roseview/hero/roseview-sash-bay-1920w.webp') . ' 1920w',
                    ]),
                    'sizes' => '100vw',
                ]); ?>>
            <?php else : ?>
                <img <?php echo fenster_image_attr_string($hero_media_src, ['class' => 'fg-hero__image', 'alt' => $title, 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
            <?php endif; ?>
        <?php endif; ?>
        <div class="fg-hero__shade"></div>
        <div class="container fg-hero__inner <?php echo esc_attr($is_home ? 'fg-hero__inner--quote' : ''); ?>">
            <div class="fg-hero__copy">
                <div class="fg-hero__heading">
                    <p class="eyebrow"><?php echo esc_html($hero_eyebrow); ?></p>
                    <h1><?php echo esc_html($title); ?></h1>
                    <p class="fg-hero__intro"><?php echo esc_html($hero_intro); ?></p>
                </div>
                <div class="button-row">
                    <a class="button" href="#fenster-enquiry">
                        <span class="fg-hero-cta__full"><?php echo esc_html($cta_label); ?></span>
                        <?php /* The short label is a SEPARATE string, not a
                                 truncation of `$cta_label`, so a route that
                                 overrides the full label has to override this
                                 one too or the phone quietly says something
                                 else. Replacement glazing said "Send us the
                                 sizes" on desktop and "Design consultation" on
                                 mobile until 2026-08-10, and only a mobile
                                 screenshot showed it. */ ?>
                        <span class="fg-hero-cta__short"><?php echo esc_html($is_repairs ? __('Request a repair', 'fenster') : ($is_replacement_bespoke ? __('Send us the sizes', 'fenster') : __('Send an enquiry', 'fenster'))); ?></span>
                    </a>
                    <?php if ($offers_instant_price) : ?>
                        <a class="button button--light" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
                    <?php elseif ($is_repairs) : ?>
                        <?php /* The other route in is the phone, not a design
                                 consultation: a repair customer wants to talk
                                 to somebody today. STYLE.md requires a phone
                                 CTA to be a button rather than a text link. */ ?>
                        <a class="button button--light" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', (string) ($brand['phone'] ?? '01908429200'))); ?>"><?php echo esc_html(sprintf(/* translators: %s: phone number */ __('Call %s', 'fenster'), (string) ($brand['phone'] ?? '01908 429200'))); ?></a>
                    <?php else : ?>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                    <?php endif; ?>
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
                    <h2><?php echo esc_html($is_commercial ? 'Get a specification conversation moving.' : ($offers_instant_price ? 'Get pricing or book a design chat.' : 'Book a design chat.')); ?></h2>
                    <div class="fg-hero-card__logos">
                        <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/google-5-stars.png'); ?>" alt="<?php esc_attr_e('Google five star reviews', 'fenster'); ?>">
                        <a class="fg-accreditation-logo-link" href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>" aria-label="<?php esc_attr_e('Learn about Fenster’s FENSA approved installations', 'fenster'); ?>">
                            <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/fensa.png'); ?>" alt="<?php esc_attr_e('FENSA approved', 'fenster'); ?>">
                        </a>
                    </div>
                    <div class="fg-hero-form">
                        <a class="button" href="#fenster-enquiry"><?php esc_html_e('Start your project', 'fenster'); ?></a>
                        <?php if ($offers_instant_price) : ?>
                            <a class="text-link" href="<?php echo esc_url($product_quote_link); ?>"><?php esc_html_e('Use the instant quote tool', 'fenster'); ?></a>
                        <?php endif; ?>
                    </div>
                </aside>
            <?php endif; ?>
            <?php if ($product_scroll_video_src) : ?>
                <div class="fg-product-traveller-start" data-fg-product-video-start aria-hidden="true"></div>
            <?php endif; ?>
        </div>
    </section>
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
                    <span>100s</span>
                    <small><?php esc_html_e('of customer reviews', 'fenster'); ?></small>
                </div>
                <div class="fg-home-proof__logos">
                    <?php foreach ($trust_items as $item) : ?>
                        <?php if (! empty($item['url'])) : ?>
                            <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $item['url']); ?>"<?php echo fenster_trust_link_attrs($item); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $item['alt'])); ?>">
                        <?php endif; ?>
                        <img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" loading="lazy">
                        <?php if (! empty($item['url'])) : ?></a><?php endif; ?>
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
                    <h2><?php esc_html_e('Eight ways to find the right glazing system.', 'fenster'); ?></h2>
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
                    <p><?php esc_html_e('The preview shows the product selector. On the live domain, this opens the online quote tool for product selection and instant pricing.', 'fenster'); ?></p>
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
                    <h2><?php esc_html_e('Tell us what you want to change.', 'fenster'); ?></h2>
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
                        <h2><?php esc_html_e('Core products and service areas', 'fenster'); ?></h2>
                    </div>
                    <?php
                    get_template_part('template-parts/components/link-cards', null, [
                        'links' => array_slice(array_values($related_links), 0, 24),
                    ]);
                    ?>
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
            'prioritise_context' => $slug === 'sliding-sash-windows' ? 'sash windows' : '',
        ]);
        ?>
    <?php endif; ?>

    <?php if ($is_home) : ?>
        <section class="fg-home-services">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('What we install', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Choose the option that matches your project.', 'fenster'); ?></h2>
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

    <?php if ($is_composite_doors) : ?>
        <section class="fg-composite-approved" aria-label="<?php esc_attr_e('Approved Distinction Doors installer', 'fenster'); ?>">
            <div class="container fg-composite-approved__inner">
                <img class="fg-composite-approved__logo" src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/partners/distinction-doors.png')); ?>" alt="Distinction Doors" loading="eager" width="473" height="107">
                <div class="fg-composite-approved__copy">
                    <strong><?php esc_html_e('Approved Distinction Doors installer', 'fenster'); ?></strong>
                    <p><?php esc_html_e('One in four front doors fitted in Britain is a Distinction. We survey, supply and hang yours ourselves, with our own fitters rather than subcontractors.', 'fenster'); ?></p>
                </div>
                <a class="button button--steel fg-composite-approved__call" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', (string) ($brand['phone'] ?? '01908 429200'))); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), (string) ($brand['phone'] ?? '01908 429200'))); ?></a>
            </div>
        </section>
    <?php endif; ?>

    <?php /* Repairs has no key specifications, because a repair is not a
             product with a specification. Owner, 2026-08-06: "repairs dont have
             spec so having a box for it makes no sense." The bespoke section
             opens with a reassurance strip in the same slot instead, which says
             something true about the service rather than inventing four
             product facts for a service that has none. */ ?>
    <?php if ($use_product_journey && count($product_usps) === 4 && ! $is_composite_doors && ! $is_secondary_bespoke && ! $is_replacement_bespoke && ! $is_repairs) : ?>
        <?php get_template_part('template-parts/components/product-pulse', null, [
            'usps'  => $product_usps,
            'slug'  => $slug,
            /* The pulse heading is the route title on all 23 routes that render
               this strip, which means every one of them repeats its own H1 as an
               H2 a few hundred pixels below it. That is a site-wide structural
               smell rather than a fault of this route, and it is flagged rather
               than fixed everywhere here. Aluminium flush is overridden because a
               duplicate H1 sitting directly above a bespoke middle looks like
               nobody read the page. Tilt and turn joined it on 2026-08-12 for
               the same reason and in the same shape; both name the system rather
               than repeating the product. Two of twenty-three is not the fix,
               and the site-wide one is still open. */
            'title' => $is_alu_flush_bespoke
                ? 'Sheerline Prestige, in four figures.'
                : ($is_tilt_turn_bespoke ? 'Liniar EnergyPlus, in four figures.' : $title),
        ]); ?>
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

    <?php if ($slug === 'casement-windows') : ?>
        <?php
        get_template_part('template-parts/sections/casement-windows-v2', null, [
            'brand' => $brand,
            'trust_items' => $trust_items,
            'quote_url' => $product_quote_embed_url,
            'quote_label' => $product_quote_embed_label,
        ]);
        ?>
        </article>
        <?php return; ?>
    <?php endif; ?>

    <?php
    // EnergyPlus on the Liniar routes, Thermlock on the Sheerline ones.
    // Routes that return earlier (casement, roof lanterns, heritage aluminium
    // doors) place the banner themselves, where it sits beside the section
    // that explains the technology instead of stacking on the spec strip.
    $tech_banner = fenster_tech_banner_args($slug);
    // Aluminium sliding doors places it itself, further down, for the same
    // reason: stacked straight onto the specification strip it repeats the
    // numbers the strip has just given inside a single viewport.
    /* Deferred so the bespoke middle can place it. On sliding doors that is the
       heritage rhythm; on uPVC doors it is because a profile cutaway with chamber
       counts and U-values was landing before the page had said what the product
       is. Both render it themselves. */
    $defer_tech_banner = in_array($slug, ['aluminium-sliding-doors', 'upvc-doors'], true);
    if (! empty($tech_banner) && ! $defer_tech_banner) {
        get_template_part('template-parts/components/tech-banner', null, $tech_banner);
    }
    ?>

    <?php if ($is_composite_doors) : ?>
        <?php
        get_template_part('template-parts/sections/composite-doors-v2', null, [
            'collections' => $composite_collections,
            'security' => $composite_security,
            'anatomy' => $composite_anatomy,
            'styles' => $composite_door_styles,
            'styles_base' => $composite_styles_base,
            'colour_wall' => $composite_colour_wall,
            'palette_base' => $composite_palette_base,
            'colours_base' => $composite_asset_base . 'colours/',
            'colour_doors_base' => $composite_asset_base . 'colour-doors/',
            'asset_base' => $composite_asset_base,
        ]);
        ?>
    <?php endif; ?>

    <?php if (! $is_composite_doors && ! empty($composite_door_families)) : ?>
        <section class="fg-composite-range" aria-labelledby="fg-composite-range-title">
            <div class="container">
                <div class="fg-composite-range__head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('The Distinction doors we install', 'fenster'); ?></p>
                        <h2 id="fg-composite-range-title"><?php esc_html_e('Choose between traditional and contemporary styles.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('We install the Signature and Contemporary ranges. Rustic Renown is a popular cottage-style design within Signature, so it is shown separately to make that choice easier to see.', 'fenster'); ?></p>
                    </div>
                    <aside>
                        <strong><?php esc_html_e('What we check', 'fenster'); ?></strong>
                        <p><?php esc_html_e('Opening size, frame, threshold, handing, glass, colour, hardware and the final doorset performance are confirmed after survey.', 'fenster'); ?></p>
                    </aside>
                </div>

                <div class="fg-composite-family-carousel" data-fg-composite-carousel>
                    <div class="fg-composite-family-track" data-fg-composite-track aria-label="<?php esc_attr_e('Distinction composite door range and style comparison', 'fenster'); ?>">
                        <?php foreach ($composite_door_families as $index => $family) : ?>
                            <?php
                            $family_image = (string) $family['image'];
                            $family_image_400 = str_replace('-800w.webp', '-400w.webp', $family_image);
                            ?>
                            <article class="fg-composite-family" data-fg-composite-slide>
                                <figure>
                                    <img src="<?php echo esc_url(fenster_generated_url($family_image)); ?>" srcset="<?php echo esc_attr(fenster_generated_url($family_image_400) . ' 400w, ' . fenster_generated_url($family_image) . ' 800w'); ?>" sizes="(max-width: 860px) 88vw, 25vw" alt="<?php echo esc_attr((string) $family['alt']); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                                    <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                </figure>
                                <div class="fg-composite-family__body">
                                    <p class="eyebrow"><?php echo esc_html((string) $family['tagline']); ?></p>
                                    <h3><?php echo esc_html((string) $family['name']); ?></h3>
                                    <p><?php echo esc_html((string) $family['copy']); ?></p>
                                    <div class="fg-composite-family__best">
                                        <small><?php esc_html_e('Best for', 'fenster'); ?></small>
                                        <strong><?php echo esc_html((string) $family['best_for']); ?></strong>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="fg-composite-family-controls" aria-label="<?php esc_attr_e('Choose a composite door range or style', 'fenster'); ?>">
                        <button type="button" data-fg-composite-prev aria-label="<?php esc_attr_e('Previous door range or style', 'fenster'); ?>">&#8249;</button>
                        <div aria-live="polite">
                            <strong data-fg-composite-name><?php echo esc_html((string) $composite_door_families[0]['name']); ?></strong>
                            <span data-fg-composite-count><?php echo esc_html('01 / ' . sprintf('%02d', count($composite_door_families))); ?></span>
                        </div>
                        <button type="button" data-fg-composite-next aria-label="<?php esc_attr_e('Next door range or style', 'fenster'); ?>">&#8250;</button>
                    </div>
                    <div class="fg-composite-family-dots" aria-label="<?php esc_attr_e('Composite door range and style slides', 'fenster'); ?>">
                        <?php foreach ($composite_door_families as $index => $family) : ?>
                            <button type="button" data-fg-composite-dot="<?php echo esc_attr((string) $index); ?>" aria-label="<?php echo esc_attr(sprintf(__('Show %s', 'fenster'), (string) $family['name'])); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="fg-composite-mobile-specs">
                        <p class="eyebrow"><?php esc_html_e('Selected range or style', 'fenster'); ?></p>
                        <?php foreach ($composite_door_families as $index => $family) : ?>
                            <section data-fg-composite-spec-panel <?php echo $index === 0 ? '' : 'hidden'; ?>>
                                <h3><?php echo esc_html((string) $family['name']); ?></h3>
                                <dl>
                                    <?php foreach ($family['specs'] as $spec) : ?>
                                        <div><dt><?php echo esc_html((string) $spec['label']); ?></dt><dd><?php echo esc_html((string) $spec['value']); ?></dd></div>
                                    <?php endforeach; ?>
                                </dl>
                            </section>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fg-composite-comparison" aria-label="<?php esc_attr_e('Distinction composite door range and style comparison', 'fenster'); ?>">
                    <div class="fg-composite-comparison__row fg-composite-comparison__row--head">
                        <span><?php esc_html_e('Difference', 'fenster'); ?></span>
                        <?php foreach ($composite_door_families as $family) : ?><strong><?php echo esc_html((string) $family['name']); ?></strong><?php endforeach; ?>
                    </div>
                    <?php for ($spec_index = 0; $spec_index < 4; $spec_index++) : ?>
                        <div class="fg-composite-comparison__row">
                            <span><?php echo esc_html((string) $composite_door_families[0]['specs'][$spec_index]['label']); ?></span>
                            <?php foreach ($composite_door_families as $family) : ?><p><?php echo esc_html((string) $family['specs'][$spec_index]['value']); ?></p><?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <section class="fg-composite-choices" aria-labelledby="fg-composite-choices-title">
            <div class="container">
                <div class="fg-composite-choices__head">
                    <p class="eyebrow"><?php esc_html_e('Make it yours', 'fenster'); ?></p>
                    <h2 id="fg-composite-choices-title"><?php esc_html_e('Choose the finish on the door.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Select a colour or glass style to see it in context. Final availability still depends on the collection, aperture and complete doorset.', 'fenster'); ?></p>
                </div>

                <?php
                $first_composite_colour = $composite_door_colours[0];
                $first_composite_colour_stem = $composite_asset_base . 'colours/' . $first_composite_colour['slug'];
                ?>
                <div class="fg-composite-choice-selector fg-composite-choice-selector--colour" data-fg-door-selector>
                    <figure class="fg-composite-choice-preview">
                        <img data-fg-choice-image src="<?php echo esc_url(fenster_generated_url($first_composite_colour_stem . '-480w.webp')); ?>" srcset="<?php echo esc_attr(fenster_generated_url($first_composite_colour_stem . '-480w.webp') . ' 480w, ' . fenster_generated_url($first_composite_colour_stem . '-800w.webp') . ' 800w'); ?>" sizes="(max-width: 860px) 100vw, 42vw" alt="<?php echo esc_attr((string) $first_composite_colour['alt']); ?>" loading="lazy" width="800" height="1000">
                        <figcaption>
                            <span><?php esc_html_e('Selected colour', 'fenster'); ?></span>
                            <h3 data-fg-choice-name><?php echo esc_html((string) $first_composite_colour['name']); ?></h3>
                            <p data-fg-choice-copy><?php echo esc_html((string) $first_composite_colour['copy']); ?></p>
                        </figcaption>
                    </figure>
                    <div class="fg-composite-choice-controls">
                        <p class="eyebrow"><?php esc_html_e('Colour direction', 'fenster'); ?></p>
                        <h3><?php esc_html_e('Choose a colour to preview it.', 'fenster'); ?></h3>
                        <p><?php esc_html_e('These are photographed examples. We confirm the full current palette before order, and colour swatches come out to a consultation.', 'fenster'); ?></p>
                        <div class="fg-composite-choice-options fg-composite-choice-options--colours" aria-label="<?php esc_attr_e('Popular composite door colour directions', 'fenster'); ?>">
                            <?php foreach ($composite_door_colours as $index => $colour) : ?>
                                <?php
                                $colour_stem = $composite_asset_base . 'colours/' . $colour['slug'];
                                $colour_src = fenster_generated_url($colour_stem . '-480w.webp');
                                $colour_srcset = $colour_src . ' 480w, ' . fenster_generated_url($colour_stem . '-800w.webp') . ' 800w';
                                ?>
                                <button type="button" data-fg-choice-option data-preview-src="<?php echo esc_url($colour_src); ?>" data-preview-srcset="<?php echo esc_attr($colour_srcset); ?>" data-preview-alt="<?php echo esc_attr((string) $colour['alt']); ?>" data-preview-name="<?php echo esc_attr((string) $colour['name']); ?>" data-preview-copy="<?php echo esc_attr((string) $colour['copy']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                    <span><i style="--door-colour: <?php echo esc_attr((string) $colour['hex']); ?>" aria-hidden="true"></i><?php echo esc_html((string) $colour['name']); ?></span>
                                </button>
                            <?php endforeach; ?>
                            <span class="fg-composite-choice-more"><?php esc_html_e('And more', 'fenster'); ?></span>
                        </div>
                    </div>
                </div>

                <?php
                $first_composite_glass = $composite_door_glass[0];
                $first_composite_glass_stem = $composite_asset_base . 'glass/' . $first_composite_glass['slug'];
                ?>
                <div class="fg-composite-choice-selector fg-composite-choice-selector--glass" data-fg-door-selector>
                    <figure class="fg-composite-choice-preview">
                        <img data-fg-choice-image src="<?php echo esc_url(fenster_generated_url($first_composite_glass_stem . '-360w.webp')); ?>" srcset="<?php echo esc_attr(fenster_generated_url($first_composite_glass_stem . '-360w.webp') . ' 360w, ' . fenster_generated_url($first_composite_glass_stem . '-720w.webp') . ' 720w'); ?>" sizes="(max-width: 860px) 100vw, 42vw" alt="Lunna decorative glass close-up" loading="lazy" width="720" height="720">
                        <figcaption>
                            <span><?php esc_html_e('Selected glass', 'fenster'); ?></span>
                            <h3 data-fg-choice-name><?php echo esc_html((string) $first_composite_glass['name']); ?></h3>
                            <p data-fg-choice-copy><?php echo esc_html((string) $first_composite_glass['copy']); ?></p>
                        </figcaption>
                    </figure>
                    <div class="fg-composite-choice-controls">
                        <p class="eyebrow"><?php esc_html_e('Decorative glass', 'fenster'); ?></p>
                        <h3><?php esc_html_e('Choose a glass design to see the detail.', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Aperture size, privacy and availability are checked against your selected door before order.', 'fenster'); ?></p>
                        <div class="fg-composite-choice-options fg-composite-choice-options--glass" aria-label="<?php esc_attr_e('Selected Distinction decorative glass styles', 'fenster'); ?>">
                            <?php foreach ($composite_door_glass as $index => $glass) : ?>
                                <?php
                                $glass_detail_stem = $composite_asset_base . 'glass/' . $glass['slug'];
                                $glass_detail_src = fenster_generated_url($glass_detail_stem . '-360w.webp');
                                ?>
                                <button type="button" data-fg-choice-option data-preview-src="<?php echo esc_url($glass_detail_src); ?>" data-preview-srcset="<?php echo esc_attr($glass_detail_src . ' 360w, ' . fenster_generated_url($glass_detail_stem . '-720w.webp') . ' 720w'); ?>" data-preview-alt="<?php echo esc_attr((string) $glass['name'] . ' decorative glass close-up'); ?>" data-preview-name="<?php echo esc_attr((string) $glass['name']); ?>" data-preview-copy="<?php echo esc_attr((string) $glass['copy']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                    <span><?php echo esc_html((string) $glass['name']); ?></span>
                                </button>
                            <?php endforeach; ?>
                            <span class="fg-composite-choice-more"><?php esc_html_e('And more', 'fenster'); ?></span>
                        </div>
                    </div>
                </div>

                <?php if (! empty($door_handle_finishes)) : ?>
                    <div class="fg-composite-hardware" data-fg-window-handles>
                        <div class="fg-composite-hardware__intro">
                            <p class="eyebrow"><?php esc_html_e('Hardware direction', 'fenster'); ?></p>
                            <h3><?php esc_html_e('See the handle finish against the door.', 'fenster'); ?></h3>
                            <p><?php esc_html_e('Choose a finish below. We then coordinate the compatible handle, letterplate, cylinder and threshold as one hardware set.', 'fenster'); ?></p>
                        </div>
                        <div class="fg-composite-hardware__stage" aria-live="polite">
                            <span class="fg-composite-hardware__door-line" aria-hidden="true"></span>
                            <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                <img src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>" alt="<?php echo esc_attr((string) $finish['label']); ?>" loading="lazy" data-fg-handle-image="<?php echo esc_attr((string) $index); ?>" class="<?php echo $index === 0 ? 'is-active' : ''; ?>">
                            <?php endforeach; ?>
                            <div class="fg-composite-hardware__selected">
                                <span><?php esc_html_e('Selected finish', 'fenster'); ?></span>
                                <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                    <article data-fg-handle-panel="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                                        <strong><?php echo esc_html((string) $finish['name']); ?></strong>
                                        <p><?php echo esc_html((string) $finish['copy']); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="fg-composite-hardware__finishes" role="list" aria-label="<?php esc_attr_e('Composite door handle finish options', 'fenster'); ?>">
                            <?php foreach ($door_handle_finishes as $index => $finish) : ?>
                                <button type="button" role="listitem" class="<?php echo $index === 0 ? 'is-active' : ''; ?>" style="<?php echo esc_attr('--hardware-swatch:' . (string) ($finish['hex'] ?? '#ffffff')); ?>" data-fg-handle-finish="<?php echo esc_attr((string) $index); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                    <i aria-hidden="true"></i>
                                    <span><?php echo esc_html((string) $finish['name']); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($sash_roseview_models)) : ?>
        <section class="fg-sash-collection" aria-labelledby="fg-sash-collection-title">
            <div class="container">
                <div class="fg-sash-collection__hero">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Roseview sash systems', 'fenster'); ?></p>
                        <h2 id="fg-sash-collection-title">
                            <span class="fg-sash-heading--desktop"><?php esc_html_e('Choose the sash window by detail level, not just by name.', 'fenster'); ?></span>
                            <span class="fg-sash-heading--mobile"><?php esc_html_e('Choose your Roseview sash.', 'fenster'); ?></span>
                        </h2>
                        <p><?php esc_html_e('Ultimate, Heritage and Charisma Rose all give a vertical sliding sash format. The important differences are the meeting rail, corner construction, horns, cills, glazing depth and how closely the window needs to reproduce timber.', 'fenster'); ?></p>
                    </div>
                    <aside class="fg-sash-collection__note">
                        <span><?php esc_html_e('Fenster survey note', 'fenster'); ?></span>
                        <p><?php esc_html_e('We confirm the final model, colour, bar layout, horn detail, ventilation option and hardware before order so the sash suits the property rather than just the brochure.', 'fenster'); ?></p>
                    </aside>
                </div>

                <?php
                $sash_mobile_comparison_rows = [
                    ['Meeting rail', '35mm', '44.5mm', '60mm'],
                    ['Corner detail', 'Mechanical joints', 'Welded joints', 'Welded joints'],
                    ['Profile', 'Putty line', 'Putty line', 'Sculptured ovolo'],
                    ['Bottom rail', '81mm standard', '81mm standard', '68mm standard'],
                    ['Glass unit', '28mm IGU', '28mm IGU', '24mm IGU'],
                    ['Best U-value', '1.2 W/m²K option', '1.2 W/m²K option', '1.4 W/m²K option'],
                ];
                ?>

                <div class="fg-sash-carousel" data-fg-sash-carousel>
                <div class="fg-sash-models" aria-label="<?php esc_attr_e('Roseview sash model comparison', 'fenster'); ?>" data-fg-sash-track>
                    <?php foreach ($sash_roseview_models as $index => $model) : ?>
                        <?php
                        $model_image = (string) $model['image'];
                        $model_image_dir = trailingslashit(dirname($model_image));
                        $model_image_stem = pathinfo($model_image, PATHINFO_FILENAME);
                        $model_image_srcset = implode(', ', [
                            fenster_generated_url($model_image_dir . $model_image_stem . '-400w.webp') . ' 400w',
                            fenster_generated_url($model_image_dir . $model_image_stem . '-800w.webp') . ' 800w',
                        ]);
                        ?>
                        <article class="fg-sash-model" data-fg-sash-slide>
                            <figure class="fg-sash-model__media" data-fg-depth="<?php echo esc_attr($index === 1 ? '0.045' : '0.065'); ?>">
                                <img src="<?php echo esc_url(fenster_generated_url($model_image_dir . $model_image_stem . '-800w.webp')); ?>" srcset="<?php echo esc_attr($model_image_srcset); ?>" sizes="(max-width: 860px) 86vw, 30vw" alt="<?php echo esc_attr((string) $model['alt']); ?>" loading="lazy">
                                <span class="fg-sash-model__rail-detail">
                                    <img src="<?php echo esc_url(fenster_generated_url((string) $model['rail_image'])); ?>" alt="" loading="lazy">
                                    <strong><?php echo esc_html((string) $model['rail_label']); ?></strong>
                                </span>
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

                <div class="fg-sash-carousel__controls" aria-label="<?php esc_attr_e('Choose a sash window model', 'fenster'); ?>">
                    <button type="button" data-fg-sash-prev aria-label="<?php esc_attr_e('Previous sash model', 'fenster'); ?>">&#8249;</button>
                    <div class="fg-sash-carousel__status" aria-live="polite">
                        <strong data-fg-sash-name><?php echo esc_html((string) ($sash_roseview_models[0]['name'] ?? '')); ?></strong>
                        <span data-fg-sash-count><?php echo esc_html('01 / ' . sprintf('%02d', count($sash_roseview_models))); ?></span>
                    </div>
                    <button type="button" data-fg-sash-next aria-label="<?php esc_attr_e('Next sash model', 'fenster'); ?>">&#8250;</button>
                </div>

                <div class="fg-sash-carousel__dots" aria-label="<?php esc_attr_e('Sash model slides', 'fenster'); ?>">
                    <?php foreach ($sash_roseview_models as $index => $model) : ?>
                        <button
                            type="button"
                            data-fg-sash-dot="<?php echo esc_attr((string) $index); ?>"
                            aria-label="<?php echo esc_attr(sprintf(__('Show %s', 'fenster'), (string) $model['name'])); ?>"
                            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        ></button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-sash-mobile-specs">
                    <p class="eyebrow"><?php esc_html_e('Selected model specifications', 'fenster'); ?></p>
                    <?php foreach ($sash_roseview_models as $model_index => $model) : ?>
                        <section data-fg-sash-spec-panel <?php echo $model_index === 0 ? '' : 'hidden'; ?>>
                            <h3><?php echo esc_html((string) $model['name']); ?></h3>
                            <dl>
                                <?php foreach ($sash_mobile_comparison_rows as $row) : ?>
                                    <div>
                                        <dt><?php echo esc_html((string) $row[0]); ?></dt>
                                        <dd><?php echo esc_html((string) $row[$model_index + 1]); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        </section>
                    <?php endforeach; ?>
                </div>
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
                        ['Profile detail', 'Putty line', 'Putty line', 'Sculptured ovolo'],
                        ['Bottom rail', '81mm standard', '81mm standard', '68mm standard'],
                        ['Horn options', 'Seamless run-through', 'Run-through, clip-on or none', 'Run-through, clip-on or none'],
                        ['Glass unit', '28mm IGU', '28mm IGU', '24mm IGU'],
                        ['Best U-value', '1.2 W/m²K option', '1.2 W/m²K option', '1.4 W/m²K option'],
                        ['Furniture', 'Globe standard', 'Acorn standard', 'Acorn standard'],
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

        <?php if (! empty($sash_roseview_gallery)) : ?>
            <section class="fg-sash-gallery" aria-labelledby="fg-sash-gallery-title">
                <div class="container">
                    <div class="fg-sash-gallery__head">
                        <div>
                            <p class="eyebrow"><?php esc_html_e('Real homes', 'fenster'); ?></p>
                            <h2 id="fg-sash-gallery-title"><?php esc_html_e('Roseview sash windows in real homes.', 'fenster'); ?></h2>
                        </div>
                        <p>
                            <span class="fg-sash-gallery__copy--desktop"><?php esc_html_e('Explore finished Roseview installations across period rooms, bays, full elevations and special window shapes.', 'fenster'); ?></span>
                            <span class="fg-sash-gallery__copy--mobile"><?php esc_html_e('Swipe through finished Roseview installations. Tap any image for a closer look.', 'fenster'); ?></span>
                        </p>
                    </div>
                    <div class="fg-sash-gallery__rail" aria-label="<?php esc_attr_e('Roseview sash window gallery', 'fenster'); ?>">
                        <?php foreach ($sash_roseview_gallery as $image) : ?>
                            <?php
                            $gallery_src = (string) $image['image'];
                            $gallery_stem = preg_replace('/\.webp$/', '', $gallery_src);
                            $gallery_width = (int) ($image['width'] ?? 1200);
                            $gallery_sources = [
                                fenster_generated_url($gallery_stem . '-480w.webp') . ' 480w',
                                fenster_generated_url($gallery_stem . '-800w.webp') . ' 800w',
                            ];
                            if ($gallery_width > 1400) {
                                $gallery_sources[] = fenster_generated_url($gallery_stem . '-1400w.webp') . ' 1400w';
                            }
                            $gallery_sources[] = fenster_generated_url($gallery_src) . ' ' . $gallery_width . 'w';
                            $gallery_srcset = implode(', ', $gallery_sources);
                            ?>
                            <figure>
                                <a href="<?php echo esc_url(fenster_generated_url($gallery_src)); ?>" data-fg-gallery-lightbox aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), (string) $image['alt'])); ?>">
                                    <img src="<?php echo esc_url(fenster_generated_url($gallery_stem . '-800w.webp')); ?>" srcset="<?php echo esc_attr($gallery_srcset); ?>" sizes="(max-width: 860px) 82vw, (max-width: 1100px) 48vw, 42vw" alt="<?php echo esc_attr((string) $image['alt']); ?>" loading="lazy">
                                    <figcaption><?php echo esc_html((string) $image['caption']); ?></figcaption>
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                    <p class="fg-sash-gallery__hint" aria-hidden="true"><?php esc_html_e('Swipe to explore', 'fenster'); ?> <span>&rarr;</span></p>
                </div>
            </section>
        <?php endif; ?>

        <section class="fg-sash-gallery-cta" aria-label="<?php esc_attr_e('Sliding sash window quote options', 'fenster'); ?>">
            <div class="container fg-sash-gallery-cta__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Your project', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Ready to price your sash windows?', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Start an instant estimate or book a free consultation to compare the Roseview options for your property.', 'fenster'); ?></p>
                </div>
                <div class="fg-sash-gallery-cta__actions">
                    <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get a sash window quote', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </div>
            </div>
        </section>

        <?php if ($slug !== 'sliding-sash-windows' && ! $is_composite_doors) : ?>
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
    <?php endif; ?>

    <?php if ($use_product_journey) : ?>
        <?php if ($slug !== 'sliding-sash-windows' && ! $is_composite_doors && ! $is_flush_bespoke && ! $is_alu_doors_bespoke && ! $is_secondary_bespoke && ! $is_replacement_bespoke && ! $is_alu_flush_bespoke && ! $is_heritage_bespoke && ! $is_upvc_doors_bespoke && ! $is_tilt_turn_bespoke && ! $is_repairs) : ?>
        <section class="fg-product-why">
            <div class="container fg-product-why__grid">
                <?php if (is_array($product_why_image) && ! empty($product_why_image['src'])) : ?>
                    <div class="fg-product-why__media-stack<?php echo $is_pet_flap_page ? ' fg-product-why__media-stack--capped' : ''; ?>">
                        <figure class="fg-product-why__media fg-product-why__media--primary<?php echo $scrub_in_why ? ' fg-product-why__media--scrub' : ''; ?>">
                            <?php if ($scrub_in_why) : ?>
                                <?php
                                /* Scrubs in place from this box. No autoplay and
                                   no controls: scroll position is the only thing
                                   that moves it. With JavaScript off or reduced
                                   motion on it holds frame one, which is the
                                   doors closed, so the slot still shows the
                                   product rather than an empty box. The still
                                   image is deliberately not rendered underneath:
                                   the video is the picture here, and layering
                                   the two is what the traveller needed, not
                                   this. */
                                ?>
                                <video data-fg-scrub-video muted playsinline preload="auto" aria-label="<?php echo esc_attr(sprintf(__('%s opening and folding back', 'fenster'), $title)); ?>">
                                    <?php foreach ($product_scrub_sources as $product_scrub_source) : ?>
                                        <source src="<?php echo esc_url($product_scrub_source['src']); ?>" type="<?php echo esc_attr($product_scrub_source['type']); ?>"<?php if (! empty($product_scrub_source['media'])) : ?> media="<?php echo esc_attr($product_scrub_source['media']); ?>"<?php endif; ?>>
                                    <?php endforeach; ?>
                                </video>
                            <?php else : ?>
                                <?php if ($product_scroll_video_src) : ?>
                                    <video class="fg-product-traveller-final" data-fg-product-video-final muted playsinline preload="auto" aria-label="<?php echo esc_attr($title . ' product animation'); ?>">
                                        <?php foreach ($product_scroll_video_sources as $product_scroll_video_source) : ?>
                                            <source src="<?php echo esc_url($product_scroll_video_source['src']); ?>" type="<?php echo esc_attr($product_scroll_video_source['type']); ?>">
                                        <?php endforeach; ?>
                                    </video>
                                <?php endif; ?>
                                <img src="<?php echo esc_url(fenster_generated_url($product_why_image['src'])); ?>" alt="<?php echo esc_attr($product_why_image['alt'] ?? $title); ?>" loading="lazy">
                            <?php endif; ?>
                            <figcaption>
                                <span><?php esc_html_e('Fenster specification', 'fenster'); ?></span>
                                <strong><?php echo esc_html($title); ?></strong>
                            </figcaption>
                        </figure>
                        <?php if (is_array($product_why_secondary_image) && ! empty($product_why_secondary_image['src'])) : ?>
                            <figure class="fg-product-why__media fg-product-why__media--secondary">
                                <img src="<?php echo esc_url(fenster_generated_url($product_why_secondary_image['src'])); ?>" alt="<?php echo esc_attr($product_why_secondary_image['alt'] ?? $title); ?>" loading="lazy">
                            </figure>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="fg-product-why__content">
                    <p class="eyebrow"><?php echo esc_html($journey_why_eyebrow); ?></p>
                    <h2><?php echo esc_html($journey_why_heading); ?></h2>
                    <p><?php echo esc_html($hero_intro); ?></p>
                    <div class="fg-product-why__cards">
                        <?php foreach (array_slice($product_benefits, 0, 5) as $index => $benefit) : ?>
                            <article>
                                <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                <div>
                                    <h3><?php echo esc_html($benefit['title']); ?></h3>
                                    <p><?php echo esc_html($benefit['copy']); ?></p>
                                </div>
                            </article>
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
        <?php endif; ?>

        <?php if (! empty($legend_verdicts)) : ?>
            <?php
            /* Its own band rather than a chip in the guide's column, and above
               the guide rather than inside it: owner asked for it higher and
               more prominent, 2026-08-02.

               It does not go higher than this. `STYLE.md` puts the page's one
               dry aside anywhere but the hero, and the specification strip
               directly under the hero is where a customer is still working out
               whether a flap can go in their door at all. This sits after the
               product information, which is the first point where a joke is not
               interrupting an answer. */
            ?>
            <section class="fg-legend-band" aria-label="<?php esc_attr_e('Legend approved', 'fenster'); ?>">
                <div class="container">
                    <div class="fg-legend-approved" data-fg-legend-approved data-fg-legend-verdicts="<?php echo esc_attr((string) wp_json_encode(array_values($legend_verdicts))); ?>">
                        <button type="button" class="fg-legend-approved__stamp" aria-describedby="fg-legend-verdict">
                            <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/team/legend-avatar.webp', [
                                'alt' => '',
                                'loading' => 'lazy',
                                'decoding' => 'async',
                            ]); ?>>
                            <span><?php esc_html_e('Legend approved', 'fenster'); ?></span>
                        </button>
                        <div class="fg-legend-approved__body">
                            <p class="fg-legend-approved__verdict" id="fg-legend-verdict" data-fg-legend-verdict aria-live="polite">
                                <?php echo esc_html((string) $legend_verdicts[0]); ?>
                            </p>
                            <p class="fg-legend-approved__who">
                                <a href="<?php echo esc_url(home_url('/meet-the-team/#legend')); ?>"><?php esc_html_e('Legend, Chief Meow Officer', 'fenster'); ?></a>
                                <?php /* Hidden until the controller attaches, so it never invites a press that cannot happen. */ ?>
                                <span class="fg-legend-approved__hint" data-fg-legend-hint hidden><?php esc_html_e('Press the stamp for another verdict', 'fenster'); ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        /* The blind visualiser sits here, straight after the why section, for
           the same reason the obscured glass visualiser sits where it does:
           the page has just told the customer the blind is sealed in the
           glass and they cannot touch it, so the next thing to do is let them
           work it. Everything below this point is specification and process,
           which reads better once the product has been understood. */
        ?>
        <?php if ($is_integral_blinds) : ?>
            <?php
            get_template_part('template-parts/components/blinds-visualiser', null, [
                'id'            => 'blind-visualiser',
                'eyebrow'       => __('See it work', 'fenster'),
                'heading'       => __('Work the blind before you order it.', 'fenster'),
                'intro'         => __('This is a Notan magnetic blind sealed inside a sealed unit, drawn straight on. Work it the way you would work the real thing, using the two magnets on the frame inside the glass, and pick any of the nine standard colours to see it in the finish you are considering.', 'fenster'),
                'fallback_image' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg',
                'fallback_alt'  => __('Close-up of a Notan integral blind sealed between the panes of a glazed door', 'fenster'),
            ]);
            ?>
        <?php endif; ?>

        <?php if ($is_pet_flap_page && ! empty($pet_flap_cards)) : ?>
            <section class="fg-pet-flap-guide">
                <div class="container fg-pet-flap-guide__grid">
                    <div class="fg-pet-flap-guide__lead">
                        <p class="eyebrow"><?php esc_html_e('How it actually goes in', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Two ways in, and the door decides which.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('From the outside a pet flap looks like a hole in a door. The part that matters is what it is being cut into: a sealed unit that has to be remade, or a panel we can cut on site. We look at the door, the pet and the outside step before anything is ordered.', 'fenster'); ?></p>
                        <a class="button" href="#fenster-enquiry"><?php esc_html_e('Check my pet flap options', 'fenster'); ?></a>
                    </div>
                    <div class="fg-pet-flap-guide__cards" aria-label="<?php esc_attr_e('Pet flap fitting options', 'fenster'); ?>">
                        <?php foreach ($pet_flap_cards as $card) : ?>
                            <article>
                                <h3><?php echo esc_html((string) ($card['title'] ?? 'Pet flap option')); ?></h3>
                                <p><?php echo esc_html((string) ($card['copy'] ?? '')); ?></p>
                                <?php if (! empty($card['points']) && is_array($card['points'])) : ?>
                                    <ul>
                                        <?php foreach ($card['points'] as $point) : ?>
                                            <li><?php echo esc_html((string) $point); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($slug !== 'sliding-sash-windows' && ! $is_composite_doors && ! $is_flush_bespoke && ! $is_alu_doors_bespoke && ! $is_secondary_bespoke && ! $is_replacement_bespoke && ! $is_alu_flush_bespoke && ! $is_heritage_bespoke && ! $is_upvc_doors_bespoke && ! $is_tilt_turn_bespoke && ! $is_repairs && (! empty($product_hub_specs) || ! empty($product_hub_choices))) : ?>
            <section class="fg-product-intel">
                <div class="container fg-product-intel__shell">
                    <div class="fg-product-intel__lead">
                        <div class="fg-product-intel__intro">
                            <p class="eyebrow"><?php echo esc_html((string) ($product_hub['eyebrow'] ?? 'Product guide')); ?></p>
                            <h2><?php echo esc_html(sprintf(__('More information on %s', 'fenster'), $title)); ?></h2>
                            <p><?php echo esc_html((string) ($product_hub['copy'] ?? 'We confirm the final product specification after survey so each window, door or glazing unit is matched to the property.')); ?></p>

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

                        <?php
                        /* A route with a scrub video shows the profile turning
                           here instead of a still of the same corner. The video
                           stays in this figure and only maps scroll position
                           onto currentTime.

                           `$scrub_in_why` excludes the routes that show their
                           scrub in the "why" box further up the page instead,
                           currently bifold. Without that guard the same video
                           renders twice on those routes. Both flags are worked
                           out once at the top of this file. */
                        ?>
                        <?php if (! empty($product_scrub_sources) && ! $scrub_in_why) : ?>
                            <figure class="fg-product-intel__media fg-product-intel__media--turntable">
                                <video data-fg-scrub-video muted playsinline preload="auto" aria-label="<?php echo esc_attr(sprintf(__('%s frame profile rotating to show its section', 'fenster'), $title)); ?>">
                                    <?php foreach ($product_scrub_sources as $product_scrub_source) : ?>
                                        <source src="<?php echo esc_url($product_scrub_source['src']); ?>" type="<?php echo esc_attr($product_scrub_source['type']); ?>"<?php if (! empty($product_scrub_source['media'])) : ?> media="<?php echo esc_attr($product_scrub_source['media']); ?>"<?php endif; ?>>
                                    <?php endforeach; ?>
                                </video>
                                <figcaption>
                                    <span><?php esc_html_e('Product view', 'fenster'); ?></span>
                                    <strong><?php echo esc_html($title); ?></strong>
                                </figcaption>
                            </figure>
                        <?php elseif (is_array($product_hub_image) && ! empty($product_hub_image['src'])) : ?>
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
                        <div class="fg-product-intel__checks" aria-label="<?php esc_attr_e('Product specification checks', 'fenster'); ?>">
                            <?php foreach (array_slice($product_hub_specs, 0, 6) as $index => $spec) : ?>
                                <?php
                                $spec_label = trim((string) ($spec['label'] ?? 'Specification'));
                                $spec_value = trim((string) ($spec['value'] ?? ''));
                                $spec_copy = trim((string) ($spec['copy'] ?? ''));
                                ?>
                                <article>
                                    <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                    <div>
                                        <p class="eyebrow"><?php echo esc_html($spec_label); ?></p>
                                        <?php if ($spec_value !== '') : ?>
                                            <h3><?php echo esc_html($spec_value); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($spec_copy !== '') : ?>
                                            <p><?php echo esc_html($spec_copy); ?></p>
                                        <?php else : ?>
                                            <p><?php esc_html_e('This detail is confirmed during survey, with the final choice matched to the property, opening and day-to-day use.', 'fenster'); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </section>
        <?php endif; ?>

        <?php if (! $is_composite_doors && ! empty($product_glass_styles)) : ?>
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
                        <?php foreach ($product_glass_styles as $index => $style) : ?>
                            <?php
                            $glass_name = trim((string) ($style['name'] ?? 'Glass style'));
                            $glass_image = trim((string) ($style['image'] ?? ''));
                            $glass_copy = trim((string) ($style['copy'] ?? ''));
                            ?>
                            <?php if ($glass_name !== '') : ?>
                                <article class="fg-composite-glass-card">
                                    <span class="fg-composite-glass-card__number"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
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

        <?php if ($slug === 'aluminium-sliding-doors') : ?>
            <?php
            /* The heritage rhythm: lede, then the technology banner beside the
               claim it backs, then the product's own detail sections, and only
               then the gallery and the finishes. */
            if (! empty($tech_banner)) {
                get_template_part('template-parts/components/tech-banner', null, $tech_banner);
            }
            ?>
            <?php get_template_part('template-parts/components/lift-slide-detail'); ?>
        <?php endif; ?>

        <?php if (! $is_pet_flap_page && ! $is_composite_doors && ! $is_flush_bespoke && ! $is_alu_doors_bespoke && ! $is_secondary_bespoke && ! $is_replacement_bespoke && ! $is_alu_flush_bespoke && ! $is_heritage_bespoke && ! $is_upvc_doors_bespoke && ! $is_tilt_turn_bespoke && ! $is_repairs && count($product_visual_gallery_remainder) >= 4) : ?>
            <section class="fg-product-visuals">
                <div class="container fg-product-visuals__grid">
                    <div class="fg-product-visuals__mosaic" aria-label="<?php echo esc_attr($title . ' image gallery'); ?>">
                        <?php foreach (array_slice($product_visual_gallery_remainder, 0, 4) as $index => $image) : ?>
                            <figure>
                                <a href="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" data-fg-gallery-lightbox aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $image['alt'])); ?>">
                                    <img src="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="eager">
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                    <aside class="fg-product-visuals__copy">
                        <p class="eyebrow"><?php esc_html_e('Product gallery', 'fenster'); ?></p>
                        <h2><?php echo esc_html($product_gallery_heading); ?></h2>
                        <p><?php echo esc_html($product_gallery_copy); ?></p>
                        <p><?php esc_html_e('If you spot a style, colour or glass detail you like, mention it in your enquiry and we will build the quote around it.', 'fenster'); ?></p>
                        <a class="button" href="#fenster-enquiry"><?php esc_html_e('Ask about this product', 'fenster'); ?></a>
                    </aside>
                </div>
            </section>
        <?php endif; ?>

        <?php /* Repairs sits OUTSIDE the block below on purpose. That block is
                 gated on the specification-choices band, which this route does
                 not render, so putting the bespoke section inside it would gate
                 the page's whole middle on a condition about colour swatches. */ ?>
        <?php if ($is_repairs) : ?>
            <?php
            get_template_part('template-parts/sections/window-door-repairs', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the specification-choices wrapper below, and it has to
                 be. That wrapper is gated on `! $is_secondary_glazing_page`,
                 which predates this rebuild and is what stops the colour, glass
                 and hardware band rendering on a route where none of those is a
                 decision. Putting the bespoke middle inside it gated the whole
                 page's middle on a condition about swatches, and the sections
                 silently did not render at all. The same warning is already
                 written against the repairs dispatch immediately above; this is
                 the second time it has caught someone. */ ?>
        <?php if ($is_secondary_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/secondary-glazing-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the wrapper below for the same reason as the two above.
                 Replacement glazing is additionally excluded FROM that wrapper,
                 because it contains the specification-choices band and that band
                 offers frame colours: the one route where the frame is the thing
                 staying put. */ ?>
        <?php if ($is_replacement_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/replacement-glazing-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the wrapper below, same as the four above. This route
                 DOES still render the specification-choices band, because the
                 aluminium colour grid and the handle grid inside it are real
                 decisions on this product, so it is not excluded from the
                 wrapper the way replacement glazing is. */ ?>
        <?php if ($is_alu_flush_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/aluminium-flush-windows-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the wrapper below, same as the five above, and for the
                 reason spelled out against the secondary glazing dispatch: that
                 wrapper is gated on a condition about colour swatches, so a
                 bespoke middle placed inside it silently renders nothing. This
                 route DOES still render the wrapper itself, because the Classic
                 colour grid and the handle grid it contains are real decisions
                 on a heritage window. */ ?>
        <?php if ($is_heritage_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/heritage-windows-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the wrapper below, same as every bespoke middle above
                 it. This route DOES still render the wrapper itself, because
                 the colour, privacy glass and handle cards inside it are real
                 decisions on a uPVC door.

                 The randomiser needs three things joined together, and each is
                 read from its own source rather than copied: the door renders
                 join to `colour_options` by name so a chip cannot drift from
                 its swatch, the handles come from the same `door_handles`
                 finishes the grid below renders, and the glass comes from
                 `obscure_glass`, which is what `/obscured-glass/` runs on. */ ?>
        <?php if ($is_upvc_doors_bespoke) : ?>
            <?php
            $upvc_renders = fenster_data('upvc_door_renders', []);
            $upvc_renders = is_array($upvc_renders) ? $upvc_renders : [];
            $upvc_colour_data = fenster_data('colour_options', []);
            $upvc_colour_list = $upvc_colour_data['materials']['upvc']['colours'] ?? [];
            $upvc_colour_index = [];
            foreach ((array) $upvc_colour_list as $upvc_colour) {
                if (! empty($upvc_colour['name'])) {
                    $upvc_colour_index[(string) $upvc_colour['name']] = $upvc_colour;
                }
            }
            $upvc_render_args = [];
            foreach ($upvc_renders as $upvc_render) {
                $name = (string) ($upvc_render['colour'] ?? '');
                $match = $upvc_colour_index[$name] ?? [];
                $upvc_render_args[] = [
                    'colour' => $name,
                    'file' => (string) ($upvc_render['file'] ?? ''),
                    'hex' => (string) ($match['hex'] ?? '#ffffff'),
                    'finish' => (string) ($match['finish'] ?? ''),
                ];
            }
            $upvc_glass = fenster_data('obscure_glass', []);
            $upvc_glass = is_array($upvc_glass['textures'] ?? null) ? $upvc_glass['textures'] : [];
            /* `$product_media` is ALREADY scoped to this slug, three hundred lines
               above: `fenster_data('product_media.' . $slug)`. Indexing it by the
               slug again returned nothing and the whole page rendered with no
               photographs at all, which the source could not show and the first
               render did. */
            /* `$product_media` is ALREADY scoped to this slug, three hundred
               lines above. Indexing it by the slug again returned nothing and the
               whole page rendered with no photographs at all.

               THE CONFIGURATION AND DECISION IMAGES ARE NOT PASSED IN. They come
               from the curated set the template names directly, because they are
               cropped and graded as one run and the gallery pool is not: the pool
               feeds the town matrix pages and has to stay as it is. Only the two
               photographs that are genuinely shared with the pool are looked up
               here. */
            $upvc_media = $product_media;
            $upvc_gallery = is_array($upvc_media['gallery'] ?? null) ? $upvc_media['gallery'] : [];
            $upvc_pick = static function (string $needle) use ($upvc_gallery): array {
                foreach ($upvc_gallery as $item) {
                    if (! empty($item['src']) && str_contains((string) $item['src'], $needle)) {
                        return ['src' => fenster_generated_url((string) $item['src']), 'alt' => (string) ($item['alt'] ?? '')];
                    }
                }
                return [];
            };
            $upvc_curated = '/wp-content/themes/fenster/assets/images/products/upvc-doors/curated/';
            get_template_part('template-parts/sections/upvc-doors-v2', null, [
                'brand' => $brand,
                'quote_url' => $product_quote_embed_url,
                'tech_banner' => is_array($tech_banner ?? null) ? $tech_banner : [],
                'renders' => $upvc_render_args,
                'handles' => is_array($door_handle_finishes) ? $door_handle_finishes : [],
                'glass' => $upvc_glass,
                /* THE ARCH ILLUSTRATES "whatever shape or size", and it sits
                   below the three ways of opening rather than above them. It was
                   pulled twice on the way here: once from the configurations,
                   where a shaped head says nothing about opening, and once from
                   the top of the page, where leading on a niche product
                   misrepresents what we sell. Under a claim about shape it is
                   the proof rather than the pitch. */
                'photos' => [
                    'opening' => [
                        'src' => fenster_generated_url($upvc_curated . 'upvc-door-white-arched-leaded.webp'),
                        'alt' => __('White uPVC door with a curved head and leaded glass in an arched brick opening', 'fenster'),
                    ],
                    'stable' => [
                        'src' => fenster_generated_url($upvc_curated . 'upvc-door-white-stable.webp'),
                        'alt' => __('White uPVC stable door with both halves glazed, in a brick opening', 'fenster'),
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>

        <?php /* OUTSIDE the wrapper below, same as every bespoke middle above
                 it, and for the reason spelled out against the secondary
                 glazing dispatch: that wrapper is gated on a condition about
                 colour swatches, so a bespoke middle placed inside it silently
                 renders nothing. This route DOES still render the wrapper
                 itself, because the uPVC colour grid and the greenteQ tilt and
                 turn handle grid inside it are both real decisions on this
                 window. */ ?>
        <?php if ($is_tilt_turn_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/tilt-turn-windows-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
            ]);
            ?>
        <?php endif; ?>

        <?php if (! $is_pet_flap_page && ! $is_secondary_glazing_page && ! $is_composite_doors && ! $is_replacement_bespoke && ! $is_repairs) : ?>
        <?php if ($is_flush_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/flush-casement-windows-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
                'quote_url' => $product_quote_embed_url,
                'quote_label' => $product_quote_embed_label,
            ]);
            ?>
        <?php endif; ?>

        <?php if ($is_alu_doors_bespoke) : ?>
            <?php
            get_template_part('template-parts/sections/aluminium-doors-v2', null, [
                'brand' => $brand,
                'trust_items' => $trust_items,
            ]);
            ?>
        <?php endif; ?>


        <?php /* GATED OFF FOR uPVC DOORS, 2026-08-12. This band is three cards
                 pointing at colour, privacy glass and handles. On that route the
                 finish chart, the privacy glass card and the full handle grid are
                 all on the page already, so the cards were a table of contents for
                 things three sections away. */ ?>
        <?php if (! $is_upvc_doors_bespoke) : ?>
        <section class="fg-product-gallery-band">
            <div class="container">
                <div class="section-heading section-heading--wide">
                    <p class="eyebrow"><?php esc_html_e('Specification choices', 'fenster'); ?></p>
                    <?php
                    /* Integral blinds get their own wording. The generic line
                       promises colours, glass and hardware, and on this route
                       two of those three are not decisions made here: the frame
                       belongs to whichever window or door the unit goes into,
                       and there is no hardware on the room side at all. */
                    ?>
                    <h2><?php echo esc_html($slug === 'roofline' ? 'Roofline colours, chosen to match what is below.' : ($is_integral_blinds ? 'Choose the glass around the blind.' : ($slug === 'sliding-sash-windows' ? 'Choose your glass and hardware.' : 'Finish the design with your colours, glass and hardware.'))); ?></h2>
                    <p><?php echo esc_html($slug === 'roofline' ? 'Roofline is chosen to sit with the windows and doors below it, so the colour is the decision worth making early.' : ($is_integral_blinds ? 'The slat colours are further down this page. The other choice on a blind unit is the glass itself: clear, or obscured where the room needs privacy even with the blind open.' : ($slug === 'sliding-sash-windows' ? 'Compare privacy glass here, then choose the Roseview furniture style and finish below.' : 'Choose your colours, privacy glass and hardware; each guide helps narrow the detail before survey.'))); ?></p>
                </div>
                <?php
                /* Built as a list before rendering so the count is known. The
                   cards used to number themselves as they printed, which was
                   fine at three but left a lone "01" on the routes that show
                   the colour grid and handle grid inline and so suppress both
                   of those cards. A single numbered step is not a sequence. */
                $option_cards = [];

                /* A route that lays the colours out inline does not also need a
                   card pointing at the colour hub: the grid's own note already
                   links there. Same suppression the uPVC foil routes use. */
                /* Integral blinds render no colour card at all. Frame colour
                   is not a decision on that route, because the unit goes into
                   whichever window or door is being made and takes that frame's
                   colour; and the slat colours that *are* chosen lay out inline
                   further down the page, with their own link to the hub. A card
                   pointing at the hub as well is the duplicate the uPVC foil
                   routes already suppress. */
                /* ROOFLINE GETS ITS OWN COLOUR CARD, not the frame one. Owner
                   instruction, 2026-08-15: the colour information was showing
                   the uPVC window foil range, and roofline is a different range
                   bought through a different route. It wants to be generic. So
                   the card names what a roofline actually comes in and points
                   at the hub for the window and door finishes it is usually
                   being matched TO, which is the real customer question here:
                   people choose roofline to sit with the windows below it. No
                   count is published, because none is confirmed. */
                /* NO COLOUR CARD ON ROOFLINE, and no link to the colour hub.
                   Owner instruction, 2026-08-15: that hub is the window and door
                   foil and powder-coat range, which is not what a roofline is
                   made from and not where it is bought, so pointing at it was
                   inaccurate as well as irrelevant. The real range is named on
                   the page itself instead, in the benefits, where a customer
                   reads it rather than being sent somewhere else to guess. */
                if ($slug === 'roofline') {
                    // No colour card.
                } elseif ($is_integral_blinds) {
                    // No colour card.
                } elseif ($slug !== 'sliding-sash-windows' && ! $shows_upvc_colour_grid && ! isset($aluminium_colour_routes[$slug])) {
                    /* The six dots on this card were six hexes invented in the
                       stylesheet. Four happened to land on real finishes and
                       two, a sage green and a navy, matched nothing that can be
                       ordered. They are pulled from the real range by name now,
                       chosen to show its spread: a white, a heritage green, a
                       woodgrain, a dark, a pale grey and a strong colour. A
                       missing name simply drops out and the CSS fallback for
                       that slot stands. */
                    $frame_dot_names = ['White', 'Chartwell Green', 'Golden Oak', 'Anthracite Grey', 'Agate Grey', 'Blue'];
                    $frame_palette = [];
                    foreach ((array) fenster_data('colour_options.materials.upvc.colours', []) as $frame_colour) {
                        if (! is_array($frame_colour)) {
                            continue;
                        }
                        $frame_palette[(string) ($frame_colour['name'] ?? '')] = (string) ($frame_colour['hex'] ?? '');
                    }
                    $frame_dots = [];
                    foreach ($frame_dot_names as $frame_dot_name) {
                        $frame_dot_hex = $frame_palette[$frame_dot_name] ?? '';
                        if (preg_match('/^#[0-9a-f]{6}$/i', $frame_dot_hex)) {
                            $frame_dots[] = $frame_dot_hex;
                        }
                    }

                    $option_cards[] = [
                        'modifier' => 'colour',
                        'url' => home_url('/colour-options/'),
                        'title' => __('Frame colours', 'fenster'),
                        'dots' => count($frame_dots) === 6 ? $frame_dots : [],
                        'copy' => $slug === 'sliding-sash-windows'
                            ? __('Compare Roseview foils, woodgrain finishes, dual colours and special colour options.', 'fenster')
                            : __('Compare uPVC foils, aluminium powder-coated finishes, dual colour and RAL-matched options.', 'fenster'),
                        'cta' => __('Open colour hub', 'fenster'),
                    ];
                }

                /* NO PRIVACY GLASS ON ROOFLINE. Owner instruction, 2026-08-15:
                   "dont mention privacy glass because it doesnt make sense",
                   and it does not — fascias, soffits and guttering contain no
                   glass at all, so the card was inviting a homeowner to choose
                   an obscure pattern for a product that has no pane in it. The
                   frame-colour card is excluded on the same route just above
                   for the same class of reason: there is no frame. */
                if ($slug !== 'roofline') {
                    $option_cards[] = [
                        'modifier' => 'glass',
                        'url' => home_url('/obscured-glass/'),
                        'title' => __('Privacy glass', 'fenster'),
                        'copy' => __('Preview obscured glass patterns and privacy levels using the dedicated visualiser page.', 'fenster'),
                        'cta' => __('Compare glass patterns', 'fenster'),
                    ];
                }

                if ($show_window_handle_card && ! $shows_handle_grid) {
                    $option_cards[] = [
                        'modifier' => 'handles',
                        'url' => home_url('/handle-options/'),
                        'title' => __('Window handles', 'fenster'),
                        'copy' => __('Compare white, black, chrome, gold, satin silver and monkey tail handle options on one focused page.', 'fenster'),
                        'cta' => __('Open handle hub', 'fenster'),
                    ];
                }

                /* The glass card is panelled with the real pattern photographs
                   from the obscure glass data, so it shows the actual product
                   rather than an effect invented in the stylesheet. Curated for
                   variety, lines against florals against stipple, but anything
                   missing simply falls through to whatever else has a photo. */
                /* Kept in step with template-parts/components/privacy-glass-card.php,
                   which renders the same card for routes that build their own
                   page. If this order changes, change it there too. */
                $glass_patch_order = ['Reeded', 'Cotswold', 'Stippolyte', 'Contora', 'Everglade'];
                $glass_patch_by_name = [];
                $glass_patch_rest = [];
                foreach ((array) $obscure_glass_textures as $glass_texture) {
                    if (! is_array($glass_texture) || trim((string) ($glass_texture['image'] ?? '')) === '') {
                        continue;
                    }
                    $glass_patch_by_name[(string) ($glass_texture['name'] ?? '')] = $glass_texture;
                    $glass_patch_rest[] = $glass_texture;
                }
                $glass_patch = [];
                foreach ($glass_patch_order as $glass_patch_name) {
                    if (isset($glass_patch_by_name[$glass_patch_name])) {
                        $glass_patch[] = $glass_patch_by_name[$glass_patch_name];
                    }
                }
                foreach ($glass_patch_rest as $glass_texture) {
                    if (count($glass_patch) >= 5) {
                        break;
                    }
                    if (! in_array($glass_texture, $glass_patch, true)) {
                        $glass_patch[] = $glass_texture;
                    }
                }
                $glass_patch = array_slice($glass_patch, 0, 5);

                $number_cards = count($option_cards) > 1;
                ?>
                <div class="fg-product-choice-map <?php echo esc_attr($slug === 'sliding-sash-windows' ? 'fg-product-choice-map--sash' : ''); ?> <?php echo esc_attr($number_cards ? '' : 'fg-product-choice-map--single'); ?>">
                    <div class="fg-product-options fg-product-options--hub">
                    <?php foreach ($option_cards as $card_index => $option_card) : ?>
                        <?php $is_patched_glass = $option_card['modifier'] === 'glass' && count($glass_patch) >= 3; ?>
                        <?php
                        /* A card may carry its own swatches, set from the data
                           it links to, rather than the stylesheet's defaults. */
                        $card_dots = is_array($option_card['dots'] ?? null) ? $option_card['dots'] : [];
                        $card_dot_style = '';
                        foreach ($card_dots as $dot_index => $dot_hex) {
                            $card_dot_style .= '--dot-' . ($dot_index + 1) . ':' . $dot_hex . ';';
                        }
                        ?>
                        <a
                            class="fg-product-option-card fg-product-option-card--<?php echo esc_attr($option_card['modifier']); ?><?php echo $is_patched_glass ? ' is-glazed' : ''; ?>"
                            href="<?php echo esc_url($option_card['url']); ?>"
                            <?php echo $card_dot_style !== '' ? 'style="' . esc_attr($card_dot_style) . '"' : ''; ?>
                        >
                            <?php if ($is_patched_glass) : ?>
                                <?php
                                /* An <i>, not a <span>: the card styles its
                                   number badge as `> span`, so a span here
                                   inherited position: relative and
                                   width: fit-content and collapsed to 15px. */
                                ?>
                                <i class="fg-glass-patch" aria-hidden="true">
                                    <?php foreach ($glass_patch as $glass_pane) : ?>
                                        <span style="<?php echo esc_attr('background-image:url(' . fenster_generated_url((string) $glass_pane['image']) . ')'); ?>"></span>
                                    <?php endforeach; ?>
                                </i>
                            <?php endif; ?>
                            <?php if ($number_cards) : ?>
                                <span><?php echo esc_html(sprintf('%02d', $card_index + 1)); ?></span>
                            <?php endif; ?>
                            <h3><?php echo esc_html($option_card['title']); ?></h3>
                            <p><?php echo esc_html($option_card['copy']); ?></p>
                            <strong><?php echo esc_html($option_card['cta']); ?></strong>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($upvc_foil_routes[$slug])) : ?>
            <?php get_template_part('template-parts/components/upvc-colour-grid', null, ['product_noun' => $upvc_foil_routes[$slug]]); ?>
        <?php endif; ?>

        <?php if (isset($aluminium_colour_routes[$slug])) : ?>
            <?php get_template_part('template-parts/components/aluminium-colour-grid', null, ['product_noun' => $aluminium_colour_routes[$slug], 'corner_set' => in_array($slug, ['aluminium-flush-windows', 'aluminium-windows'], true) ? 'prestige-flush' : '']); ?>
        <?php endif; ?>

        <?php /* Slat colours inline, the same as the uPVC and aluminium routes
                 lay out their frame finishes, rather than behind a card that
                 links away. Owner instruction, 2026-08-04. */ ?>
        <?php if ($is_integral_blinds) : ?>
            <?php get_template_part('template-parts/components/blind-colour-grid'); ?>
        <?php endif; ?>


        <?php if ($shows_handle_grid) : ?>
            <?php get_template_part('template-parts/components/handle-grid', null, fenster_window_handle_grid_args()); ?>
        <?php endif; ?>

        <?php if ($show_tilt_turn_handles) : ?>
            <?php get_template_part('template-parts/components/handle-grid', null, [
                'data' => $tilt_turn_handles,
                'id' => 'tilt-turn-handle-finishes',
                'eyebrow' => 'Handles',
                'heading' => 'Five finishes on the locking tilt and turn handle.',
                'intro' => (string) ($tilt_turn_handles['intro'] ?? ''),
                'note' => 'We fit the locking version on every tilt and turn window, so the tilt-only setting is there whether or not you ask for it.',
                'alt_pattern' => 'greenteQ Alpha TBT tilt and turn window handle in %s',
                'columns' => 'fg-handle-finishes--five',
                'link_href' => home_url('/handle-options/#tilt-turn-handle-finishes'),
            ]); ?>
        <?php endif; ?>

        <?php /* uPVC doors render this themselves, immediately after the colour
                 grid, so the three choices a customer actually makes — colour,
                 handle, glass — run together the way they do on
                 /casement-windows/. Left here for every other door route. */ ?>
        <?php if ($show_door_handles && ! $is_upvc_doors_bespoke) : ?>
            <?php get_template_part('template-parts/components/handle-grid', null, fenster_door_handle_grid_args()); ?>
        <?php endif; ?>

        <?php if ($show_patio_handles) : ?>
            <?php get_template_part('template-parts/components/handle-grid', null, fenster_patio_handle_grid_args()); ?>
        <?php endif; ?>

        <?php if ($show_lift_slide_handles) : ?>
            <?php get_template_part('template-parts/components/handle-grid', null, fenster_lift_slide_handle_grid_args()); ?>
        <?php endif; ?>

        <?php if ($show_sash_furniture && ! empty($sash_furniture_ranges)) : ?>
            <?php
            $sash_furniture_base = '/wp-content/themes/fenster/assets/images/products/sash-roseview/furniture-guide/';
            $sash_furniture_options = [
                'globe' => [
                    'name' => 'Globe furniture',
                    'models' => 'Ultimate Rose',
                    'copy' => 'The curved Globe lock is the standard traditional furniture style for Ultimate Rose.',
                    'finishes' => ['Bronze', 'Gold', 'Chrome', 'Antique Black', 'Graphite', 'Pewter'],
                ],
                'acorn' => [
                    'name' => 'Acorn furniture',
                    'models' => 'Ultimate, Heritage and Charisma Rose',
                    'copy' => 'The Acorn lock is standard on Heritage and Charisma Rose and is also available on suitable Ultimate Rose specifications.',
                    'finishes' => ['Bronze', 'Gold', 'Chrome', 'Antique Black', 'Graphite', 'Pewter', 'White'],
                ],
            ];
            ?>
            <section id="fenster-sash-furniture" class="fg-sash-furniture fg-sash-furniture--selector" data-fg-sash-furniture>
                <div class="container">
                    <div class="fg-sash-furniture__head">
                        <div>
                            <p class="eyebrow"><?php esc_html_e('Sash window furniture', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Choose the lock style and finish.', 'fenster'); ?></h2>
                        </div>
                        <p><?php esc_html_e('Globe and Acorn furniture are supplied as coordinated sets with matching sash lifts, pole eyes and tilt knobs. Compatibility depends on the Roseview model.', 'fenster'); ?></p>
                    </div>

                    <div class="fg-sash-furniture-selector">
                        <div class="fg-sash-furniture-selector__visual" aria-live="polite">
                            <?php foreach ($sash_furniture_options as $style_key => $style) : ?>
                                <?php foreach ($style['finishes'] as $finish_index => $finish) : ?>
                                    <?php $asset_key = $style_key . '-' . sanitize_title($finish); ?>
                                    <img
                                        src="<?php echo esc_url(fenster_generated_url($sash_furniture_base . $asset_key . '.webp')); ?>"
                                        alt="<?php echo esc_attr($style['name'] . ' in ' . $finish); ?>"
                                        loading="eager"
                                        data-fg-furniture-image="<?php echo esc_attr($asset_key); ?>"
                                        <?php echo $style_key === 'globe' && $finish_index === 0 ? '' : 'hidden'; ?>
                                    >
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="fg-sash-furniture-selector__controls">
                            <div class="fg-sash-furniture-selector__styles" role="group" aria-label="<?php esc_attr_e('Furniture style', 'fenster'); ?>">
                                <?php foreach ($sash_furniture_options as $style_key => $style) : ?>
                                    <button type="button" data-fg-furniture-style="<?php echo esc_attr($style_key); ?>" aria-pressed="<?php echo $style_key === 'globe' ? 'true' : 'false'; ?>">
                                        <strong><?php echo esc_html($style['name']); ?></strong>
                                        <span><?php echo esc_html($style['models']); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <?php foreach ($sash_furniture_options as $style_key => $style) : ?>
                                <section data-fg-furniture-panel="<?php echo esc_attr($style_key); ?>" <?php echo $style_key === 'globe' ? '' : 'hidden'; ?>>
                                    <p><?php echo esc_html($style['copy']); ?></p>
                                    <div class="fg-sash-furniture-selector__finishes" role="group" aria-label="<?php echo esc_attr($style['name'] . ' finishes'); ?>">
                                        <?php foreach ($style['finishes'] as $finish_index => $finish) : ?>
                                            <?php $asset_key = $style_key . '-' . sanitize_title($finish); ?>
                                            <button type="button" data-fg-furniture-finish="<?php echo esc_attr($asset_key); ?>" aria-pressed="<?php echo $finish_index === 0 ? 'true' : 'false'; ?>">
                                                <i class="fg-sash-furniture-selector__swatch fg-sash-furniture-selector__swatch--<?php echo esc_attr(sanitize_title($finish)); ?>" aria-hidden="true"></i>
                                                <span><?php echo esc_html($finish); ?></span>
                                                <?php if (in_array($finish, ['Graphite', 'Pewter'], true)) : ?><small><?php esc_html_e('New', 'fenster'); ?></small><?php endif; ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </section>
                            <?php endforeach; ?>

                            <div class="fg-sash-furniture-selector__note">
                                <strong><?php esc_html_e('Supplied as a matching set', 'fenster'); ?></strong>
                                <p><?php esc_html_e('The number of locks, lifts and pole eyes depends on the finished sash width and is confirmed during survey.', 'fenster'); ?></p>
                            </div>
                        </div>
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


        <?php if (! empty($product_faqs)) : ?>
            <?php
            /* Composite doors carries six: the price question was added in front of
               the existing five, and the U-value answer must not drop off. Flush
               casement is now the same story — the triple glazing answer is appended
               to five that already exist, so at a limit of five it was built, added
               to the array, and then sliced off before it ever rendered. The code
               was on the page and the answer was not, which is the worst version of
               this bug because nothing looks broken.

               Anything appending a FAQ to a route that already fills its limit has
               to raise the limit too. */
            /* Repairs takes seven, the only route that does. It needs the cost
               question, the "do you charge to quote" one, repair-or-replace,
               parts availability, misted glass and the coverage question, and
               none of those is the one to lose. This cap has now silently
               sliced a correctly written FAQ off three routes; if you add a
               question past the limit, raise the route here in the same commit
               or it renders nowhere and you will not be told. */
            /* Composite doors was briefly raised to 7 on 2026-08-15 and put
               back the same day. Raising the cap to fit a new answer is the
               documented move and it was not the problem; the answer was. It
               restated the construction from "What is a composite door made
               from?" and the Salford figure from "Why is there no U-value
               shown", so the route was being given a third telling of what it
               already said twice. **Check what the route already answers before
               raising this number.** A cap that forces that question is doing
               something useful. */
            $product_faq_limit = $is_repairs ? 7 : (($slug === 'sliding-sash-windows' || $is_composite_doors || $slug === 'flush-casement-windows') ? 6 : 5);
            /* The schema is the shared emitter now, passed the same limit the
               render below slices to, so the markup can never describe a
               question the page does not show. Only the JSON-LD moved; the
               markup underneath is untouched. */
            ?>
            <?php fenster_render_faq_page_schema($product_faqs, $product_faq_limit); ?>
            <section class="fg-product-faq">
                <div class="container fg-product-faq__grid">
                    <div>
                        <p class="eyebrow"><?php echo esc_html($journey_faq_eyebrow); ?></p>
                        <h2><?php echo esc_html($journey_faq_heading); ?></h2>
                    </div>
                    <div class="fg-product-faq__items">
                        <?php foreach (array_slice($product_faqs, 0, $product_faq_limit) as $index => $faq) : ?>
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

        <?php if ($slug !== 'sliding-sash-windows' && ! $is_composite_doors && $slug !== 'aluminium-sliding-doors' && ! $is_repairs) : ?>
        <?php
        get_template_part('template-parts/components/order-process', null, [
            'eyebrow' => $journey_order_eyebrow,
            'heading' => $journey_order_heading,
            'copy' => $journey_order_copy,
            'steps' => $product_order_steps,
            'action_label' => $journey_order_action,
            'action_href' => '#fenster-enquiry',
        ]);
        ?>
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
                                <a class="text-link" href="#fenster-enquiry"><?php esc_html_e('Talk to us about this', 'fenster'); ?></a>
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

    <?php if (! $use_product_journey && ! $is_product) : ?>
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
                    <?php if ($is_composite_doors) : ?>
                        <h2><?php esc_html_e('Build your door and watch the price move.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Pick the style, size, colour, glass and handles and the figure updates as you go. Most people have a real number inside ten minutes. Nothing is committed and the survey confirms the detail before anything is ordered.', 'fenster'); ?></p>
                    <?php else : ?>
                        <h2><?php echo esc_html('Design and price your ' . $product_quote_embed_label . ' online.'); ?></h2>
                        <p><?php esc_html_e('Use the Fenster quote tool to choose a style, sizes, colours and options. Final pricing and specification are confirmed after survey.', 'fenster'); ?></p>
                    <?php endif; ?>
                    <?php /* B7, 2026-08-13: the free consultation is how most of
                             this work actually closes and it appeared nowhere in
                             product-page content bar the sash gallery. One
                             sentence, the two-routes construction TONEOFVOICE.md
                             asks for at :84, and a text link rather than a
                             button, so the quote tool stays the primary action
                             here. The claim that a consultation builds the same
                             quote is the order process rail's own wording, at
                             inc/site-data.php:2465; "free" is stated there, in
                             the mega-menu card at inc/site-data.php:211 and in
                             Legend's briefing at inc/legend-assistant.php:375.

                             It sits above the buttons, not below them: it frames
                             the two ways in, so it has to be read before the
                             action rather than after it. It also no longer says
                             the tool gives a figure in minutes. The tool asks
                             for name, address, phone and email before it shows
                             one, so that phrasing promised a number the visitor
                             does not reach in minutes. The same wording is still
                             live at casement-windows-v2.php:643,
                             heritage-aluminium-doors.php:552 and
                             about.php:103 and needs the same look. */ ?>
                    <p class="fg-product-quote-embed__aside">
                        <?php
                        printf(
                            /* translators: %s: link to the consultation booking page */
                            esc_html__('If you like doing things yourself, build the job on the quote tool. If you would rather talk it through, %s and we build the same quote with you.', 'fenster'),
                            '<a href="' . esc_url(home_url('/book-a-consultation/')) . '">' . esc_html__('book a free consultation', 'fenster') . '</a>'
                        );
                        ?>
                    </p>
                    <?php if ($slug === 'sliding-sash-windows' || $is_composite_doors) : ?>
                        <a class="button fg-product-quote-embed__sash-mobile-action" href="<?php echo esc_url($product_quote_embed_url); ?>"><?php echo esc_html($is_composite_doors ? 'Price my composite door' : 'Design and price your sash windows'); ?></a>
                    <?php endif; ?>
                    <?php if ($is_composite_doors) : ?>
                        <p class="fg-product-quote-embed__aside"><?php esc_html_e('Would rather see a figure before opening a tool? One we fitted recently came to £2,000, and the guide breaks down what moves that.', 'fenster'); ?></p>
                        <a class="button button--steel" href="<?php echo esc_url(home_url('/composite-door-prices/')); ?>"><?php esc_html_e('See example prices', 'fenster'); ?></a>
                    <?php elseif ($slug === 'sliding-sash-windows') : ?>
                        <?php /* Sash links its price guide here rather than in the
                                 related-links band, because the band is gated off
                                 for this route and composite doors at the foot of
                                 this file. Same pattern as composite doors above.
                                 The wording deliberately does not promise example
                                 prices: `sash-window-prices` currently holds no
                                 confirmed £ example, so `price-guide.php` filters
                                 its three rows out and the page leads on what
                                 moves the number. Change this line when a checked
                                 sash price lands in that guide. */ ?>
                        <p class="fg-product-quote-embed__aside"><?php esc_html_e('Would rather understand the number before opening a tool? The sash price guide sets out what moves it, from the model and colour to horns, bars and furniture.', 'fenster'); ?></p>
                        <a class="button button--steel" href="<?php echo esc_url(home_url('/sash-window-prices/')); ?>"><?php esc_html_e('See what moves the price', 'fenster'); ?></a>
                    <?php endif; ?>
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
            'prioritise_context' => $slug === 'sliding-sash-windows' ? 'sash windows' : ($is_composite_doors ? 'composite door' : ''),
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

    <?php /* Repairs is excluded because nothing claims it, and this helper's
             documented fallback is to return ANY three studies when nothing
             matches. Live, that put three unrelated installations under a
             heading reading "Real installs, photographed on the day" on a page
             about a broken lock. */ ?>
    <?php /* `$is_replacement_bespoke` is excluded because no replacement glazing
             case study exists, and the helper below falls back to ALL studies
             when a product matches none. The route was showing secondary glazing,
             casement windows and bifold doors under a heading about real installs
             of this product. Remove the exclusion when a study exists. */ ?>
    <?php /* Heritage windows is excluded, and the reason took three goes in one
             day to settle. No study claimed the route, so the strip fell through
             to its documented all-studies fallback and put a bifold job and two
             casement jobs under a heading about real installs of a steel-look
             window. The Heal's commercial study then claimed the route, so the
             gate came off. Then the owner ruled that commercial studies do not
             belong on residential product pages at all, which is now enforced
             in `fenster_case_studies_for_product()` itself — so Heal's no longer
             counts here and the fallback is what would render again. Gate back
             on. **It comes off when a RESIDENTIAL heritage window study
             exists**, and not before. */ ?>
    <?php
    /* `/aluminium-windows/` joins them, 2026-08-11. It had been showing three
       COMMERCIAL studies, which the owner's instruction removes, and with those
       filtered out no residential study claims the route, so the fallback would
       have put secondary glazing, uPVC casements and bifold doors under a
       heading about real installs of an aluminium window. Two of those three are
       the wrong material entirely. That would be a regression caused by the
       filter rather than something the filter merely revealed, so the strip is
       off here until a residential aluminium window study exists. */
    /* `/tilt-turn-windows/` joins them, 2026-08-12, and unlike the two above it
       this one was never caused by a filter — it has simply been wrong since the
       route existed. Nothing has ever claimed it, so the fallback was rendering
       Winslow secondary glazing, Leighton Buzzard casements and Whitehouse
       bifolds under "Real installs, photographed on the day" on a tilt and turn
       page. Not one of the three is this product and one is not even a window.
       It comes off when a tilt and turn study exists; the route is a real gap in
       `PHOTO-CHECKLIST.md` and not merely an un-photographed one. */
    $no_case_study_routes = ['aluminium-windows', 'tilt-turn-windows'];
    $shows_case_study_strip = $use_product_journey
        && ! $is_repairs
        && ! $is_replacement_bespoke
        && ! $is_heritage_bespoke
        && ! in_array($slug, $no_case_study_routes, true)
        && function_exists('fenster_case_studies_for_product');
    ?>
    <?php if ($shows_case_study_strip) : ?>
        <?php
        /* THE HEADING FOLLOWS THE MATCH, 2026-08-13. The owner's ruling is that
           the fallback stays — "show all case studies where we dont have any
           applicable" — so the cards are unchanged. What could not stay is the
           claim over them: "Real installs, photographed on the day" is a promise
           that these three jobs are THIS product, and on a fallback they are
           not. `fenster_case_studies_for_product()` now says which case it
           handed back, so the honest heading is chosen rather than the route
           being gated off. The exact-match wording is untouched. */
        $product_case_is_fallback = false;
        $product_case_cards = fenster_case_studies_for_product($slug, 3, 'residential', $product_case_is_fallback);
        ?>
        <?php if ($product_case_cards !== []) : ?>
            <section class="fg-cs-strip">
                <div class="container">
                    <div class="fg-cs-strip__head">
                        <?php if ($product_case_is_fallback) : ?>
                            <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Recent work across the range.', 'fenster'); ?></h2>
                            <p><?php esc_html_e('Jobs we have finished recently, fitted by our own installers and photographed the day we finished. They cover the range rather than this product.', 'fenster'); ?></p>
                        <?php else : ?>
                            <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Real installs, photographed on the day.', 'fenster'); ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="fg-cs-strip__grid">
                        <?php foreach ($product_case_cards as $product_case_card) : ?>
                            <?php
                            get_template_part('template-parts/components/case-study-card', null, [
                                'card' => $product_case_card,
                                'heading' => 'h3',
                            ]);
                            ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="button-row fg-cs-strip__cta">
                        <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <?php /* Repairs gets its own three lines. "Start your project"
                         and "Tell us about your project" are the language of
                         buying windows; a broken lock is not a project, and
                         asking about "styles, pricing, survey and installation
                         options" answers a question this visitor did not ask.
                         The problem finder above writes the fault straight into
                         the message field, which is what the last line means. */ ?>
                <p class="eyebrow"><?php echo esc_html($is_repairs ? 'Book a repair' : ($is_commercial ? 'Start the conversation' : ($is_replacement_bespoke ? 'Get it priced' : 'Start your project'))); ?></p>
                <h2><?php echo esc_html($is_repairs ? 'Tell us what it is doing.' : ($is_commercial ? 'Tell us about the building, package or programme.' : ($is_replacement_bespoke ? 'Tell us which window it is.' : 'Tell us about your project.'))); ?></h2>
                <p><?php echo esc_html($is_repairs ? 'In your own words is fine, and a photograph of the fault tells us more than any description will. We will come back with what it usually turns out to be.' : ($is_commercial ? 'A Fenster specialist can help with early feasibility, system options, budgets and installation planning.' : ($is_replacement_bespoke ? 'Rough sizes and a photograph are usually enough for us to price it without coming out. Tell us how many units and roughly how big, and say if anything about the glass wants changing while it is made.' : 'Send the basics and the team can guide you through styles, pricing, survey and installation options.'))); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'] ?? '01908429200')); ?>"><?php echo esc_html($brand['phone'] ?? '01908 429200'); ?></a>
                    <a href="mailto:<?php echo esc_attr($brand['email'] ?? 'info@fensterglazing.com'); ?>"><?php echo esc_html($brand['email'] ?? 'info@fensterglazing.com'); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => $title,
                'button_label' => $is_repairs ? 'Request a repair' : ($is_commercial ? 'Send project enquiry' : 'Send my project details'),
                'project_type' => $is_commercial ? 'Commercial glazing' : ($is_repairs ? 'Window or door repair' : ($slug === 'sliding-sash-windows' ? 'Sliding sash windows' : ($is_composite_doors ? 'Composite doors' : 'Residential windows and doors'))),
                'show_company' => $is_commercial,
                'lock_project_type' => $is_commercial || $slug === 'sliding-sash-windows' || $is_composite_doors,
                'compact' => $slug === 'sliding-sash-windows' || $is_composite_doors,
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($related_links) && $slug !== 'sliding-sash-windows' && ! $is_composite_doors) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Keep exploring', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Related products and service areas', 'fenster'); ?></h2>
                </div>
                <?php
                get_template_part('template-parts/components/link-cards', null, [
                    'links' => array_slice(array_values($related_links), 0, 24),
                ]);
                ?>
            </div>
        </section>
    <?php endif; ?>
</article>
