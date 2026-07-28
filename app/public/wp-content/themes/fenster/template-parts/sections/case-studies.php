<?php
/**
 * Case study archive and detail renderer.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = get_query_var('fenster_generated_page');

if (! is_array($page)) {
    return;
}

$slug = (string) ($page['slug'] ?? '');
$title = (string) ($page['title'] ?? 'Case Studies');
$sections = is_array($page['sections'] ?? null) ? $page['sections'] : [];
$images = is_array($page['images'] ?? null) ? $page['images'] : [];
$links = is_array($page['links'] ?? null) ? $page['links'] : [];
$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$asset_base = '/wp-content/themes/fenster/assets/images/imported/';

if (! function_exists('fenster_case_path_from_url')) {
    function fenster_case_path_from_url(string $url): string
    {
        $path = (string) (wp_parse_url($url, PHP_URL_PATH) ?? '');
        $path = preg_replace('#^/app#', '', $path) ?: $path;

        return trim($path, '/');
    }
}

if (! function_exists('fenster_case_is_detail')) {
    function fenster_case_is_detail(array $case_page): bool
    {
        $case_slug = (string) ($case_page['slug'] ?? '');

        return str_starts_with($case_slug, 'case-studies/') && $case_slug !== 'case-studies/';
    }
}

if (! function_exists('fenster_case_clean_lines')) {
    function fenster_case_clean_lines(array $lines): array
    {
        $blocked = [
            'products used:',
            'find out more',
            'request a call',
            'get started now!',
        ];

        return array_values(array_filter(array_map(static function ($line) use ($blocked): string {
            $line = trim(wp_strip_all_tags((string) $line));
            if ($line === '') {
                return '';
            }

            return in_array(strtolower($line), $blocked, true) ? '' : $line;
        }, $lines)));
    }
}

if (! function_exists('fenster_case_excerpt')) {
    function fenster_case_excerpt(array $case_page, int $words = 28): string
    {
        $seo = (string) ($case_page['seo']['meta_description'] ?? '');
        if ($seo !== '') {
            return wp_trim_words($seo, $words);
        }

        foreach (($case_page['sections'] ?? []) as $section) {
            $lines = fenster_case_clean_lines($section['body'] ?? []);
            foreach ($lines as $line) {
                if (strlen($line) > 60) {
                    return wp_trim_words($line, $words);
                }
            }
        }

        return 'A Fenster Glazing project shaped around performance, practical installation and a cleaner finished result.';
    }
}

if (! function_exists('fenster_case_location')) {
    function fenster_case_location(array $case_page): string
    {
        $title = (string) ($case_page['title'] ?? '');
        if (str_contains($title, ',')) {
            return trim((string) substr(strrchr($title, ','), 1));
        }

        foreach (($case_page['sections'] ?? []) as $section) {
            $lines = fenster_case_clean_lines($section['body'] ?? []);
            foreach ($lines as $line) {
                if (str_ends_with($line, ':') || str_contains($line, '.')) {
                    continue;
                }

                if (strlen($line) < 70 && preg_match('/[A-Z][a-z]+/', $line)) {
                    return $line;
                }
            }
        }

        return 'Fenster project';
    }
}

if (! function_exists('fenster_case_type')) {
    function fenster_case_type(array $case_page): string
    {
        $case_slug = (string) ($case_page['slug'] ?? '');
        $commercial_slugs = [
            'case-studies/barn-hotel-windows-coventry',
            'case-studies/bespoke-windows-woburn-water-end-barn',
            'case-studies/care-home-window-replacement',
            'case-studies/dental-practice-door-replacement',
            'case-studies/pub-windows-eversholt',
            'case-studies/replacement-aluminium-windows-herts-and-essex-community-hospital',
            'case-studies/test',
        ];

        if (in_array($case_slug, $commercial_slugs, true)) {
            return 'Commercial';
        }

        $haystack = strtolower((string) ($case_page['title'] ?? '') . ' ' . wp_json_encode($case_page['sections'] ?? []));

        if (str_contains($haystack, 'hospital') || str_contains($haystack, 'clinic') || str_contains($haystack, 'care home') || str_contains($haystack, 'hotel') || str_contains($haystack, 'commercial')) {
            return 'Commercial';
        }

        if (str_contains($haystack, 'pub')) {
            return 'Hospitality';
        }

        return 'Residential';
    }
}

if (! function_exists('fenster_case_project_details')) {
    function fenster_case_project_details(array $case_page): array
    {
        $slug = (string) ($case_page['slug'] ?? '');
        $fallback_title = (string) ($case_page['title'] ?? 'Fenster Glazing project');
        $fallback_type = fenster_case_type($case_page);
        $fallback_location = fenster_case_location($case_page);
        $fallback_intro = fenster_case_excerpt($case_page, 42);
        $details = [
            'sector' => $fallback_type,
            'location' => $fallback_location,
            'installed' => ['Surveyed glazing package', 'Fenster installation team', 'Aftercare support'],
            'brief' => $fallback_intro,
            'challenge' => 'The project needed the right balance of product choice, measured detail and clean installation.',
            'approach' => 'Fenster shaped the specification around the property, surveyed the details and planned the installation around the site conditions.',
            'result' => 'The finished work improved comfort, performance and the overall appearance of the building.',
            'outcome_label' => 'Improved performance',
            'timeline' => 'Survey to install',
            'tone' => $fallback_type === 'Residential' ? 'Residential' : 'Commercial',
            'scope' => 'Survey, supply and installation of replacement glazing.',
            'systems' => ['Glazing systems selected to suit the site'],
            'access' => 'Standard site access',
            'features' => ['Measured survey', 'Fenster installation team', 'Aftercare support'],
        ];

        $project_details = [
            'case-studies/barn-hotel-windows-coventry' => [
                'display_title' => 'Barn Hotel - Coventry',
                'sector' => 'Hotel refurbishment',
                'location' => 'Coventry',
                'installed' => ['37 aluminium hotel windows', 'Commercial entrance doors', 'Crane-assisted first-floor glazing lifts'],
                'scope' => 'Replacement aluminium hotel windows and commercial entrance doors.',
                'systems' => ['Aluminium window systems', 'Commercial entrance doors', 'Double glazed units'],
                'access' => 'Crane-assisted lifts to first-floor openings while the building was still at shell stage.',
                'features' => ['37 windows installed', 'Upper-floor crane lifts', 'Shell-stage coordination', 'Hospitality refurbishment'],
                'brief' => 'Fenster was appointed to deliver the window and entrance-door package for a major hotel refurbishment while the building was still stripped back to shell condition.',
                'challenge' => 'The hotel had no internal staircases installed when glazing began, so large aluminium units had to be lifted safely to upper floors and sequenced around the wider construction programme.',
                'approach' => 'The team coordinated access, lifting strategy and installation sequencing before work began, then installed durable aluminium systems selected for hospitality use, slim sightlines and thermal performance.',
                'result' => 'The completed package gives the refurbished hotel a cleaner contemporary facade, better insulation for guest and communal spaces, and a more efficient building envelope.',
                'outcome_label' => '37 windows installed',
                'timeline' => 'Shell stage delivery',
                'tone' => 'Commercial',
            ],
            'case-studies/bespoke-windows-woburn-water-end-barn' => [
                'display_title' => 'Water End Barn - Woburn',
                'sector' => 'Commercial heritage offices',
                'location' => 'Water End Barn, Woburn',
                'installed' => ['19 bespoke Residence 9 windows', 'Clotted Cream finish', 'Timber-alternative flush casement styling'],
                'scope' => 'Bespoke replacement windows for a converted barn used as commercial office space.',
                'systems' => ['Residence 9 windows', 'Clotted Cream finish', 'Flush casement detailing'],
                'access' => 'Heritage-sensitive survey and installation around the existing barn structure.',
                'features' => ['19 bespoke windows', 'Timber-alternative appearance', 'Commercial office setting', 'Heritage detailing'],
                'brief' => 'Water End Barn needed heritage-sensitive windows for a converted commercial building, preserving countryside character while supporting modern office use.',
                'challenge' => 'The installation had to respect the age and appearance of the barn while meeting the practical expectations of a commercial workspace.',
                'approach' => 'Fenster specified bespoke Residence 9 frames in Clotted Cream, balancing heritage detailing, commercial compliance, thermal comfort and a tidy installation programme.',
                'result' => 'The barn keeps its traditional character while gaining better warmth, light and usability for the businesses working inside.',
                'outcome_label' => '19 bespoke windows',
                'timeline' => 'Heritage-led survey',
                'tone' => 'Commercial',
            ],
            'case-studies/care-home-window-replacement' => [
                'display_title' => 'Sunrise Care Home - Kettering',
                'sector' => 'Healthcare',
                'location' => 'Kettering',
                'installed' => ['Replacement uPVC windows', 'Replacement doors', 'Care-setting secure glazing specification'],
                'scope' => 'Replacement windows and doors for a live care home environment.',
                'systems' => ['uPVC window systems', 'Replacement door sets', 'Secure glazing specification'],
                'access' => 'Phased work in a live dementia-specific care setting with controlled access.',
                'features' => ['Live healthcare environment', 'Resident safety controls', 'Phased installation', 'Improved thermal performance'],
                'brief' => 'Sunrise Care Home needed a full window and door replacement package as part of a refurbishment focused on safety, comfort and energy efficiency.',
                'challenge' => 'The building remained a live dementia-specific care environment, so disruption, safety, access control and resident wellbeing had to be managed throughout.',
                'approach' => 'Fenster phased the installation, used suitable high-performance uPVC systems and kept tools, access and working areas controlled around day-to-day care operations.',
                'result' => 'The care home now has improved thermal performance, better security and a calmer internal environment for residents and staff.',
                'outcome_label' => 'Live care setting',
                'timeline' => 'Phased installation',
                'tone' => 'Commercial',
            ],
            'case-studies/dental-practice-door-replacement' => [
                'display_title' => 'Roka Dental - Woburn Sands',
                'sector' => 'Healthcare',
                'location' => 'Woburn Sands',
                'installed' => ['Replacement aluminium doors', 'Replacement uPVC doors', 'Brand-aligned entrance detailing'],
                'scope' => 'Replacement door package for a new dental practice entrance.',
                'systems' => ['Aluminium door system', 'uPVC door system', 'Secure entrance hardware'],
                'access' => 'Installation planned around clinic launch requirements.',
                'features' => ['Healthcare entrance', 'New clinic fit-out', 'Brand-aligned finish', 'Commercial daily-use doors'],
                'brief' => 'Roka Dental needed external doors for a new clinic launch, with the entrance expected to feel professional, durable and aligned with the practice brand.',
                'challenge' => 'The doors needed to support daily clinical use while making the right first impression for a new local healthcare business.',
                'approach' => 'Fenster selected aluminium and uPVC door systems around proportion, finish, security and long-term performance, then installed them through an efficient in-house programme.',
                'result' => 'The clinic gained a clean, brand-aligned entrance that improves appearance, reliability and commercial durability.',
                'outcome_label' => 'Clinic-ready entrance',
                'timeline' => 'Launch programme',
                'tone' => 'Commercial',
            ],
            'case-studies/double-glazing-rushden' => [
                'sector' => 'Residential',
                'location' => 'Rushden, Northamptonshire',
                'installed' => ['Liniar casement windows', 'Leaded diamond glass', 'Three-part white uPVC bay window'],
                'brief' => 'A Rushden homeowner wanted to replace failing windows, improve comfort and keep the traditional character of a cosy bungalow intact.',
                'challenge' => 'The existing bay window had blown panes, draughts and cold rooms, but the replacement still needed to suit the original frontage.',
                'approach' => 'Fenster installed a three-part white uPVC bay with modern double glazed units and leaded diamond casements to keep the property character while improving performance.',
                'result' => 'The home is warmer, quieter and more comfortable, with reduced heat loss and a bay window that looks naturally suited to the property.',
                'outcome_label' => 'Warmer bungalow',
                'timeline' => 'Residential upgrade',
                'tone' => 'Residential',
            ],
            'case-studies/pub-windows-eversholt' => [
                'display_title' => 'The Green Man - Eversholt',
                'sector' => 'Hospitality',
                'location' => 'Eversholt',
                'installed' => ['6 Residence 9 windows', '1 three-part Residence 9 bay window', '5 white woodgrain C70 flush casement windows', 'Black monkey tail handles', 'Astragal bars'],
                'scope' => 'Replacement heritage-style windows for a village pub.',
                'systems' => ['Residence 9 windows', 'C70 flush casement windows', 'Astragal bars', 'Black monkey tail handles'],
                'access' => 'Commercial hospitality setting with works planned around building use.',
                'features' => ['6 Residence 9 windows', '1 three-part bay window', '5 C70 flush casements', 'Repeat client'],
                'brief' => 'The Green Man needed pub windows that could improve insulation and reliability while preserving a traditional village hospitality feel.',
                'challenge' => 'The building needed commercial-grade performance without losing the look of timber joinery or disrupting the day-to-day running of the pub.',
                'approach' => 'Fenster combined Residence 9, C70 flush casements, mechanical joints, astragal bars and black monkey tail handles for a heritage-led commercial double glazing package.',
                'result' => 'The pub gained warmer, lower-maintenance windows that protect its character while improving comfort for guests and staff.',
                'outcome_label' => 'Heritage pub finish',
                'timeline' => 'Repeat client',
                'tone' => 'Commercial',
            ],
            'case-studies/replacement-aluminium-windows-herts-and-essex-community-hospital' => [
                'display_title' => 'Herts and Essex Community Hospital',
                'sector' => 'Healthcare',
                'location' => 'Bishop\'s Stortford',
                'installed' => ['Replacement aluminium windows', 'Replacement aluminium doors', 'Colour-matched systems'],
                'scope' => 'Replacement aluminium windows and doors for the Kitwood Unit.',
                'systems' => ['Aluminium window systems', 'Aluminium door systems', 'Colour-matched frames'],
                'access' => 'Phased healthcare-site installation using approved RAMS and controlled working areas.',
                'features' => ['Live clinical environment', 'Colour-matched aluminium', 'Approved RAMS', 'Estate consistency'],
                'brief' => 'Herts and Essex Community Hospital needed replacement aluminium windows and doors for the Kitwood Unit as part of wider healthcare construction works.',
                'challenge' => 'The package had to integrate with existing hospital buildings, preserve visual consistency and be installed safely in a live clinical environment.',
                'approach' => 'Fenster supplied colour-matched aluminium systems and installed them through healthcare-aware site protocols, approved RAMS and careful phasing.',
                'result' => 'The new glazing improves durability, performance and estate consistency while supporting essential healthcare infrastructure.',
                'outcome_label' => 'Clinical environment',
                'timeline' => 'Phased healthcare work',
                'tone' => 'Commercial',
            ],
            'case-studies/test' => [
                'display_title' => 'Herts and Essex Community Hospital',
                'sector' => 'Healthcare',
                'location' => 'Bishop\'s Stortford',
                'installed' => ['Replacement aluminium windows', 'Replacement aluminium doors', 'Colour-matched systems'],
                'scope' => 'Replacement aluminium windows and doors for the Kitwood Unit.',
                'systems' => ['Aluminium window systems', 'Aluminium door systems', 'Colour-matched frames'],
                'access' => 'Phased healthcare-site installation using approved RAMS and controlled working areas.',
                'features' => ['Live clinical environment', 'Colour-matched aluminium', 'Approved RAMS', 'Estate consistency'],
                'brief' => 'Herts and Essex Community Hospital needed replacement aluminium windows and doors for the Kitwood Unit as part of wider healthcare construction works.',
                'challenge' => 'The package had to integrate with existing hospital buildings, preserve visual consistency and be installed safely in a live clinical environment.',
                'approach' => 'Fenster supplied colour-matched aluminium systems and installed them through healthcare-aware site protocols, approved RAMS and careful phasing.',
                'result' => 'The new glazing improves durability, performance and estate consistency while supporting essential healthcare infrastructure.',
                'outcome_label' => 'Clinical environment',
                'timeline' => '3 weeks',
                'tone' => 'Commercial',
            ],
            'case-studies/water-stratford' => [
                'sector' => 'Residential heritage',
                'location' => 'Water Stratford, Buckingham',
                'installed' => ['Flush sash windows', 'White woodgrain finish', 'Georgian bar detailing'],
                'brief' => 'A 300-year-old Water Stratford property needed new windows that would respect its age, architecture and village setting.',
                'challenge' => 'The project needed modern performance and a clean finish without making the 17th-century cottage feel over-modernised.',
                'approach' => 'Fenster specified eye-catching flush sash windows from Liniar with white woodgrain and Georgian bars to echo traditional detailing.',
                'result' => 'The property keeps its period character while gaining cleaner, better-performing windows chosen around the architecture.',
                'outcome_label' => '300-year-old home',
                'timeline' => 'Heritage upgrade',
                'tone' => 'Residential',
            ],
        ];

        return array_merge($details, $project_details[$slug] ?? []);
    }
}

if (! function_exists('fenster_case_archive_kind')) {
    function fenster_case_archive_kind(string $slug): string
    {
        return $slug === 'commercial-projects' ? 'commercial' : 'residential';
    }
}

if (! function_exists('fenster_case_display_title')) {
    function fenster_case_display_title(array $case_page, array $details): string
    {
        return trim((string) ($details['display_title'] ?? $case_page['title'] ?? 'Fenster Glazing project'));
    }
}

if (! function_exists('fenster_case_archive_cards')) {
    function fenster_case_archive_cards(array $archive_page): array
    {
        $cards = [];
        $archive_images = array_values(array_filter($archive_page['images'] ?? [], static function ($image): bool {
            $src = (string) ($image['src'] ?? '');

            return $src !== '' && ! str_ends_with($src, '/case-studies/');
        }));

        foreach (($archive_page['links'] ?? []) as $index => $link) {
            $url = (string) ($link['url'] ?? '');
            $path = fenster_case_path_from_url($url);

            if (! str_starts_with($path, 'case-studies/') || $path === 'case-studies') {
                continue;
            }

            // Do not surface a project card that is deliberately retired with
            // a 410 response. This prevented the Commercial Projects archive
            // from linking to the removed Woburn case-study route.
            if (function_exists('fenster_gone_slugs') && isset(fenster_gone_slugs()[$path])) {
                continue;
            }

            $case_page = fenster_get_generated_page($path);
            if (! is_array($case_page)) {
                continue;
            }

            $case_title = trim((string) ($case_page['title'] ?? ''));
            if ($case_title === '' || in_array(strtolower($case_title), ['template new'], true) || $path === 'case-studies/test') {
                continue;
            }

            /* Was `$archive_images[$index] ?? $archive_images[$index - 1]`, which
               gave a study whatever photograph happened to sit at its position in
               the links list. Nothing connected the two, so studies with no image
               of their own displayed other people's buildings. Own image first,
               then the verified pairing, then nothing. */
            $image = $case_page['images'][0] ?? fenster_commercial_case_image($path);
            $details = fenster_case_project_details($case_page);
            $cards[] = [
                'page' => $case_page,
                'title' => fenster_case_display_title($case_page, $details),
                'url' => home_url('/' . trim($path, '/') . '/'),
                'image' => is_array($image) ? $image : null,
                'location' => (string) ($details['location'] ?? fenster_case_location($case_page)),
                'type' => (string) ($details['tone'] ?? fenster_case_type($case_page)),
                'excerpt' => fenster_case_excerpt($case_page),
                'details' => $details,
            ];
        }

        return $cards;
    }
}

if (! function_exists('fenster_commercial_case_image')) {
    /**
     * Photograph for a commercial case study, keyed by its own route.
     *
     * These five studies carry no image in `images[]`, so the archive card
     * builder used to hand them `$archive_images[$index]`: a photograph picked
     * by the study's position in the links list, with nothing tying it to the
     * job. That is why the Barn Hotel page was showing the Sunrise Care Home
     * building. Three of the five can be paired from their own social metadata
     * in `data/pages.json`, which is the only place the imported records name a
     * photograph. The Green Man was identified by the owner on 2026-07-28 from
     * the loose archive pool.
     *
     * The Barn Hotel, Coventry is deliberately absent and falls through to the
     * neutral commercial image: no photograph of it exists anywhere in the
     * export. The other loose archive photograph, `5-1.png`, is Water End Barn,
     * Woburn, whose case study is retired and returns 410, so it must not be
     * borrowed for the hotel. A wrong building is worse than none on a page
     * whose whole job is proof.
     */
    function fenster_commercial_case_image(string $slug): ?array
    {
        $base = '/wp-content/themes/fenster/assets/images/imported/';
        $map = [
            'case-studies/pub-windows-eversholt' => [
                '3-1-3.png',
                'The Green Man, Eversholt, after its window replacement',
            ],
            'case-studies/care-home-window-replacement' => [
                '668a13f5-3500-420d-8e15-47834268084b.jpg',
                'Sunrise Care Home after its window replacement',
            ],
            'case-studies/replacement-aluminium-windows-herts-and-essex-community-hospital' => [
                'fe2513f8-d557-4972-bb3f-bc0cc6a9d5f3.jpg',
                'Herts and Essex Community Hospital after its aluminium window replacement',
            ],
            'case-studies/dental-practice-door-replacement' => [
                'ROKA-Dental-Post-Fitting-2-scaled.jpg',
                'Roka Dental Clinic, Woburn Sands, after fitting',
            ],
        ];

        $slug = trim($slug, '/');
        if (! isset($map[$slug])) {
            return null;
        }

        return ['src' => $base . $map[$slug][0], 'alt' => $map[$slug][1]];
    }
}

if (! function_exists('fenster_case_image_for_page')) {
    function fenster_case_image_for_page(array $case_page, array $archive_cards, string $fallback): array
    {
        $image = $case_page['images'][0] ?? null;
        if (is_array($image) && ! empty($image['src'])) {
            return $image;
        }

        $case_slug = (string) ($case_page['slug'] ?? '');

        $verified = fenster_commercial_case_image($case_slug);
        if (is_array($verified)) {
            return $verified;
        }

        foreach ($archive_cards as $card) {
            if (($card['page']['slug'] ?? '') === $case_slug && is_array($card['image'])) {
                return $card['image'];
            }
        }

        return [
            'src' => $fallback,
            'alt' => (string) ($case_page['title'] ?? 'Fenster Glazing case study'),
        ];
    }
}

if (! function_exists('fenster_case_related_cards')) {
    function fenster_case_related_cards(array $archive_cards, string $current_slug, int $limit = 3): array
    {
        $same_type = [];
        $others = [];
        $current_type = '';

        foreach ($archive_cards as $card) {
            if (($card['page']['slug'] ?? '') === $current_slug) {
                $current_type = (string) ($card['type'] ?? '');
                break;
            }
        }

        foreach ($archive_cards as $card) {
            if (($card['page']['slug'] ?? '') === $current_slug) {
                continue;
            }

            if ($current_type !== '' && ($card['type'] ?? '') === $current_type) {
                $same_type[] = $card;
            } else {
                $others[] = $card;
            }
        }

        return array_slice(array_merge($same_type, $others), 0, $limit);
    }
}

/*
 * Residential case studies are a curated, self-contained system driven by
 * fenster_case_studies(). They render here and return before any of the
 * legacy pages.json commercial logic runs. The commercial-projects archive
 * and commercial detail pages continue to use the pages.json data below.
 */
$case_short_slug = str_starts_with($slug, 'case-studies/') ? substr($slug, strlen('case-studies/')) : '';
$is_residential_archive = $slug === 'case-studies';
$is_residential_detail = $case_short_slug !== '' && function_exists('fenster_case_study') && fenster_case_study($case_short_slug) !== null;

if ($is_residential_archive || $is_residential_detail) {
    get_template_part('template-parts/sections/case-studies-residential', null, [
        'slug' => $slug,
        'short_slug' => $case_short_slug,
        'is_archive' => $is_residential_archive,
        'quote_url' => home_url('/online-quote/'),
        'phone' => $phone,
        'email' => $email,
    ]);

    return;
}

// Commercial archive card source. The 'case-studies' getter now returns the
// curated residential archive, so read the raw pages.json index here to keep
// the commercial-projects archive working from the imported project links.
$archive_page = fenster_generated_pages_index()['case-studies'] ?? [];
$all_archive_cards = is_array($archive_page) ? fenster_case_archive_cards($archive_page) : [];
$is_archive = in_array($slug, ['case-studies', 'commercial-projects'], true);
$archive_kind = fenster_case_archive_kind($slug);
$archive_cards = $is_archive ? array_values(array_filter($all_archive_cards, static function ($card) use ($archive_kind): bool {
    $tone = strtolower((string) ($card['details']['tone'] ?? $card['type'] ?? ''));

    return $archive_kind === 'commercial' ? $tone !== 'residential' : $tone === 'residential';
})) : $all_archive_cards;
$fallback_image = $asset_base . 'commercial-1.jpg';
$case_image = fenster_case_image_for_page($page, $all_archive_cards, $fallback_image);

if ($is_archive) :
    $featured_cards = array_slice($archive_cards, 0, 3);
    $grid_cards = array_slice($archive_cards, 3);
    $is_commercial_archive = $archive_kind === 'commercial';
    $archive_eyebrow = $is_commercial_archive ? 'Commercial projects' : 'Residential case studies';
    $archive_heading = $is_commercial_archive ? 'Commercial project records.' : 'Residential transformations with real project detail.';
    $archive_intro = $is_commercial_archive
        ? 'Completed commercial glazing work. Scope, location, systems and site requirements.'
        : 'Explore home glazing projects where Fenster balanced comfort, character, product choice and careful installation.';
    $archive_secondary_url = $is_commercial_archive ? '' : home_url('/commercial-projects/');
    $archive_secondary_label = $is_commercial_archive ? '' : 'View commercial projects';
    ?>
    <article class="fg-case-page fg-case-page--archive <?php echo esc_attr($is_commercial_archive ? 'fg-case-page--commercial' : ''); ?>">
        <section class="fg-case-hero">
            <div class="fg-case-hero__media">
                <?php foreach ($featured_cards as $index => $card) : ?>
                    <?php if (is_array($card['image'])) : ?>
                        <img src="<?php echo esc_url(fenster_generated_url((string) ($card['image']['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" style="--slot: <?php echo esc_attr((string) $index); ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="fg-case-hero__shade"></div>
            <div class="container fg-case-hero__inner">
                <p class="eyebrow"><?php echo esc_html($archive_eyebrow); ?></p>
                <h1><?php echo esc_html($archive_heading); ?></h1>
                <p><?php echo esc_html($archive_intro); ?></p>
                <div class="fg-case-hero__stats">
                    <span><strong><?php echo esc_html((string) count($archive_cards)); ?></strong><?php echo esc_html($is_commercial_archive ? 'project records' : 'project stories'); ?></span>
                    <span><strong><?php echo esc_html($is_commercial_archive ? '4' : '2'); ?></strong><?php echo esc_html($is_commercial_archive ? 'project facts' : 'project priorities'); ?></span>
                    <span><strong>1</strong><?php esc_html_e('in-house team', 'fenster'); ?></span>
                </div>
                <div class="button-row">
                    <a class="button" href="#fenster-projects"><?php esc_html_e('Explore projects', 'fenster'); ?></a>
                    <?php if ($archive_secondary_url !== '') : ?>
                        <a class="button button--light" href="<?php echo esc_url($archive_secondary_url); ?>"><?php echo esc_html($archive_secondary_label); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php if (! empty($featured_cards)) : ?>
            <section class="fg-case-featured" id="fenster-projects">
                <div class="container">
                    <div class="fg-case-section-head">
                        <p class="eyebrow"><?php echo esc_html($is_commercial_archive ? 'Commercial work' : 'Residential work'); ?></p>
                        <h2><?php echo esc_html($is_commercial_archive ? 'Scope, systems and site conditions.' : 'Comfort, character and considered product choices.'); ?></h2>
                    </div>
                    <div class="fg-case-featured__grid">
                        <?php foreach ($featured_cards as $card) : ?>
                            <a class="fg-case-card fg-case-card--large <?php echo esc_attr($is_commercial_archive ? 'fg-case-card--commercial' : ''); ?>" href="<?php echo esc_url($card['url']); ?>">
                                <?php if (is_array($card['image'])) : ?>
                                    <img src="<?php echo esc_url(fenster_generated_url((string) ($card['image']['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" loading="lazy">
                                <?php endif; ?>
                                <span><?php echo esc_html($is_commercial_archive ? $card['location'] : $card['type']); ?></span>
                                <strong><?php echo esc_html($card['title']); ?></strong>
                                <?php if ($is_commercial_archive) : ?>
                                    <dl class="fg-case-spec-list">
                                        <div><dt><?php esc_html_e('Scope', 'fenster'); ?></dt><dd><?php echo esc_html((string) ($card['details']['scope'] ?? $card['excerpt'])); ?></dd></div>
                                        <div><dt><?php esc_html_e('Installed', 'fenster'); ?></dt><dd><?php echo esc_html(implode(', ', array_slice((array) ($card['details']['installed'] ?? []), 0, 3))); ?></dd></div>
                                        <div><dt><?php esc_html_e('Site', 'fenster'); ?></dt><dd><?php echo esc_html((string) ($card['details']['access'] ?? 'Commercial site installation')); ?></dd></div>
                                    </dl>
                                <?php else : ?>
                                    <small><?php echo esc_html($card['excerpt']); ?></small>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (! empty($grid_cards)) : ?>
            <section class="fg-case-index">
                <div class="container">
                    <div class="fg-case-index__grid">
                        <?php foreach ($grid_cards as $card) : ?>
                            <a class="fg-case-card <?php echo esc_attr($is_commercial_archive ? 'fg-case-card--commercial' : ''); ?>" href="<?php echo esc_url($card['url']); ?>">
                                <?php if (is_array($card['image'])) : ?>
                                    <img src="<?php echo esc_url(fenster_generated_url((string) ($card['image']['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" loading="lazy">
                                <?php endif; ?>
                                <span><?php echo esc_html($is_commercial_archive ? $card['location'] : $card['type'] . ' / ' . $card['location']); ?></span>
                                <strong><?php echo esc_html($card['title']); ?></strong>
                                <?php if ($is_commercial_archive) : ?>
                                    <dl class="fg-case-spec-list">
                                        <div><dt><?php esc_html_e('Scope', 'fenster'); ?></dt><dd><?php echo esc_html((string) ($card['details']['scope'] ?? $card['excerpt'])); ?></dd></div>
                                        <div><dt><?php esc_html_e('Installed', 'fenster'); ?></dt><dd><?php echo esc_html(implode(', ', array_slice((array) ($card['details']['installed'] ?? []), 0, 3))); ?></dd></div>
                                    </dl>
                                <?php else : ?>
                                    <small><?php echo esc_html($card['excerpt']); ?></small>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="fg-case-cta" id="fenster-enquiry">
            <div class="container fg-case-cta__inner">
                <div>
                    <p class="eyebrow"><?php echo esc_html($is_commercial_archive ? 'Commercial enquiry' : 'Start yours'); ?></p>
                    <h2><?php echo esc_html($is_commercial_archive ? 'Send drawings, schedule or site requirements.' : 'Have a project that needs the same level of care?'); ?></h2>
                    <p><?php echo esc_html($is_commercial_archive ? 'Fenster can support survey, product specification, supply and installation planning for commercial glazing packages.' : 'Bring Fenster in early for product advice, survey detail, installation planning and a clearer path from idea to finished glazing.'); ?></p>
                </div>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Talk to Fenster', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>"><?php esc_html_e('Commercial glazing', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    </article>
    <?php
    return;
endif;

$story_sections = array_values(array_filter($sections, static function ($section): bool {
    $heading = trim((string) ($section['heading'] ?? ''));
    $lines = fenster_case_clean_lines($section['body'] ?? []);

    return $heading !== '' && ! empty($lines) && ! in_array(strtolower($heading), ['get in touch', 'use our quoting engine', 'find out more'], true);
}));
$intro = fenster_case_excerpt($page, 42);
$project_details = fenster_case_project_details($page);
$display_title = fenster_case_display_title($page, $project_details);
$location = (string) ($project_details['location'] ?? fenster_case_location($page));
$type = (string) ($project_details['sector'] ?? fenster_case_type($page));
$tone = (string) ($project_details['tone'] ?? fenster_case_type($page));
$is_commercial_single = strtolower($tone) !== 'residential';
$related_cards = fenster_case_related_cards($all_archive_cards, $slug);
$back_url = strtolower($tone) === 'residential' ? home_url('/case-studies/') : home_url('/commercial-projects/');
$back_label = strtolower($tone) === 'residential' ? 'Residential case studies' : 'Commercial projects';
$commercial_step_images = [
    (string) ($case_image['src'] ?? $fallback_image),
    $asset_base . 'Airbus-Commercial.jpg',
    $asset_base . 'commercial-1.jpg',
    $asset_base . 'aluminium-windows.jpg',
];
$commercial_page_images = array_values(array_filter([
    (string) ($case_image['src'] ?? ''),
    $commercial_step_images[1],
    $commercial_step_images[2],
]));
$project_blocks = $is_commercial_single
    ? [
        [
            'label' => 'Scope',
            'title' => 'Works carried out',
            'copy' => (string) ($project_details['scope'] ?? $project_details['brief'] ?? $intro),
        ],
        [
            'label' => 'Systems',
            'title' => 'Products used',
            'copy' => implode(', ', (array) ($project_details['systems'] ?? $project_details['installed'] ?? [])),
        ],
        [
            'label' => 'Access',
            'title' => 'Site requirements',
            'copy' => (string) ($project_details['access'] ?? $project_details['challenge'] ?? ''),
        ],
        [
            'label' => 'Features',
            'title' => 'Project notes',
            'copy' => implode(', ', (array) ($project_details['features'] ?? [])),
        ],
    ]
    : [
        [
            'label' => 'Brief',
            'title' => 'What the project needed',
            'copy' => (string) ($project_details['brief'] ?? $intro),
        ],
        [
            'label' => 'Challenge',
            'title' => 'The detail that mattered',
            'copy' => (string) ($project_details['challenge'] ?? ''),
        ],
        [
            'label' => 'Approach',
            'title' => 'How Fenster handled it',
            'copy' => (string) ($project_details['approach'] ?? ''),
        ],
        [
            'label' => 'Result',
            'title' => 'The finished outcome',
            'copy' => (string) ($project_details['result'] ?? ''),
        ],
    ];
?>

<article class="fg-case-page fg-case-page--single <?php echo esc_attr($is_commercial_single ? 'fg-case-page--commercial' : ''); ?>">
    <section class="fg-case-single-hero">
        <img src="<?php echo esc_url(fenster_generated_url((string) ($case_image['src'] ?? $fallback_image))); ?>" alt="<?php echo esc_attr((string) ($case_image['alt'] ?? $title)); ?>">
        <div class="fg-case-single-hero__shade"></div>
        <div class="container fg-case-single-hero__inner">
            <a class="fg-case-back" href="<?php echo esc_url($back_url); ?>"><?php echo esc_html($back_label); ?></a>
            <p class="eyebrow"><?php echo esc_html($type . ' project'); ?></p>
            <h1><?php echo esc_html($display_title); ?></h1>
            <p><?php echo esc_html($is_commercial_single ? (string) ($project_details['scope'] ?? $intro) : (string) ($project_details['brief'] ?? $intro)); ?></p>
            <div class="fg-case-facts">
                <span><small><?php esc_html_e('Sector', 'fenster'); ?></small><strong><?php echo esc_html($type); ?></strong></span>
                <span><small><?php esc_html_e('Location', 'fenster'); ?></small><strong><?php echo esc_html($location); ?></strong></span>
                <span><small><?php echo esc_html($is_commercial_single ? 'Access' : 'Delivery'); ?></small><strong><?php echo esc_html((string) ($is_commercial_single ? ($project_details['timeline'] ?? 'Site planned') : ($project_details['timeline'] ?? 'Survey to install'))); ?></strong></span>
            </div>
        </div>
    </section>

    <?php if ($is_commercial_single) : ?>
        <section class="fg-commercial-record">
            <div class="container fg-commercial-record__grid">
                <div class="fg-commercial-record__media">
                    <?php foreach ($commercial_page_images as $index => $image_src) : ?>
                        <figure class="<?php echo esc_attr($index === 0 ? 'is-main' : ''); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url((string) $image_src)); ?>" alt="<?php echo esc_attr($display_title . ' project image'); ?>" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
                <div class="fg-commercial-record__facts">
                    <div class="fg-commercial-record__intro">
                        <p class="eyebrow"><?php esc_html_e('Project details', 'fenster'); ?></p>
                        <p><?php echo esc_html((string) ($project_details['scope'] ?? $intro)); ?></p>
                    </div>
                    <dl class="fg-commercial-record__list">
                        <div>
                            <dt><?php esc_html_e('Location', 'fenster'); ?></dt>
                            <dd><?php echo esc_html($location); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Sector', 'fenster'); ?></dt>
                            <dd><?php echo esc_html($type); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Role', 'fenster'); ?></dt>
                            <dd><?php esc_html_e('Survey, supply and install', 'fenster'); ?></dd>
                        </div>
                    </dl>
                    <div class="fg-commercial-record__installed">
                        <span><?php esc_html_e('Installed', 'fenster'); ?></span>
                        <ul>
                            <?php foreach (($project_details['installed'] ?? []) as $installed_item) : ?>
                                <li><?php echo esc_html((string) $installed_item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php else : ?>
        <section class="fg-case-snapshot">
            <div class="container fg-case-snapshot__grid">
                <div class="fg-case-snapshot__intro">
                    <p class="eyebrow"><?php esc_html_e('Project snapshot', 'fenster'); ?></p>
                    <h2><?php echo esc_html((string) ($project_details['outcome_label'] ?? 'Project details')); ?></h2>
                    <p><?php echo esc_html((string) ($project_details['result'] ?? $intro)); ?></p>
                </div>
                <div class="fg-case-installed">
                    <span><?php esc_html_e('Installed', 'fenster'); ?></span>
                    <ul>
                        <?php foreach (($project_details['installed'] ?? []) as $installed_item) : ?>
                            <li><?php echo esc_html((string) $installed_item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="fg-case-mini-facts">
                    <span><small><?php esc_html_e('Where', 'fenster'); ?></small><strong><?php echo esc_html($location); ?></strong></span>
                    <span><small><?php esc_html_e('Project type', 'fenster'); ?></small><strong><?php echo esc_html($type); ?></strong></span>
                    <span><small><?php esc_html_e('Fenster role', 'fenster'); ?></small><strong><?php esc_html_e('Survey, supply and install', 'fenster'); ?></strong></span>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-case-story">
        <div class="container <?php echo esc_attr($is_commercial_single ? 'fg-commercial-detail' : 'fg-case-story__grid'); ?>">
            <?php if (! $is_commercial_single) : ?>
                <aside class="fg-case-story__rail">
                    <span><?php esc_html_e('Project file', 'fenster'); ?></span>
                    <strong><?php echo esc_html($display_title); ?></strong>
                    <small><?php echo esc_html($location); ?></small>
                    <a class="button" href="#fenster-enquiry"><?php esc_html_e('Start a similar project', 'fenster'); ?></a>
                </aside>
            <?php endif; ?>
            <div class="<?php echo esc_attr($is_commercial_single ? 'fg-commercial-detail__body' : 'fg-case-story__body'); ?>">
                <?php if ($is_commercial_single) : ?>
                    <section class="fg-case-stepper" data-fg-case-steps>
                        <div class="fg-case-stepper__nav" role="tablist" aria-label="<?php esc_attr_e('Project details', 'fenster'); ?>">
                            <?php foreach ($project_blocks as $index => $block) : ?>
                                <?php $step_id = 'case-step-' . esc_attr((string) $index); ?>
                                <button
                                    class="<?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                                    type="button"
                                    role="tab"
                                    id="<?php echo esc_attr($step_id . '-tab'); ?>"
                                    aria-selected="<?php echo esc_attr($index === 0 ? 'true' : 'false'); ?>"
                                    aria-controls="<?php echo esc_attr($step_id . '-panel'); ?>"
                                    data-case-step="<?php echo esc_attr((string) $index); ?>"
                                >
                                    <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                                    <?php echo esc_html((string) $block['label']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="fg-case-stepper__panels">
                            <?php foreach ($project_blocks as $index => $block) : ?>
                                <?php $step_id = 'case-step-' . esc_attr((string) $index); ?>
                                <section
                                    class="fg-case-stepper__panel <?php echo esc_attr($index === 0 ? 'is-active' : ''); ?>"
                                    role="tabpanel"
                                    id="<?php echo esc_attr($step_id . '-panel'); ?>"
                                    aria-labelledby="<?php echo esc_attr($step_id . '-tab'); ?>"
                                    data-case-panel="<?php echo esc_attr((string) $index); ?>"
                                >
                                    <div class="fg-case-stepper__content">
                                        <p class="eyebrow"><?php echo esc_html((string) $block['label']); ?></p>
                                        <p><?php echo esc_html((string) $block['copy']); ?></p>
                                    </div>
                                </section>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php else : ?>
                    <?php foreach ($project_blocks as $index => $block) : ?>
                        <section class="fg-case-story-block fg-case-story-block--<?php echo esc_attr(sanitize_title((string) $block['label'])); ?>">
                            <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <p class="eyebrow"><?php echo esc_html((string) $block['label']); ?></p>
                            <h2><?php echo esc_html((string) $block['title']); ?></h2>
                            <p><?php echo esc_html((string) $block['copy']); ?></p>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (count($images) > 1) : ?>
        <section class="fg-case-gallery">
            <div class="container">
                <div class="fg-case-section-head">
                    <p class="eyebrow"><?php esc_html_e('Project images', 'fenster'); ?></p>
                    <h2><?php echo esc_html($is_commercial_single ? 'Site images.' : 'Details from the work.'); ?></h2>
                </div>
                <div class="fg-case-gallery__grid">
                    <?php foreach (array_slice($images, 0, 6) as $image) : ?>
                        <figure>
                            <img src="<?php echo esc_url(fenster_generated_url((string) ($image['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($image['alt'] ?? $title)); ?>" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($related_cards)) : ?>
        <section class="fg-case-related">
            <div class="container">
                <div class="fg-case-section-head">
                    <p class="eyebrow"><?php echo esc_html($is_commercial_single ? 'More projects' : 'More case studies'); ?></p>
                    <h2><?php echo esc_html($is_commercial_single ? 'More commercial projects.' : 'Keep exploring Fenster project work.'); ?></h2>
                </div>
                <div class="fg-case-index__grid">
                    <?php foreach ($related_cards as $card) : ?>
                        <?php $related_is_commercial = strtolower((string) ($card['details']['tone'] ?? $card['type'] ?? '')) !== 'residential'; ?>
                        <a class="fg-case-card <?php echo esc_attr($related_is_commercial ? 'fg-case-card--commercial' : ''); ?>" href="<?php echo esc_url($card['url']); ?>">
                            <?php if (is_array($card['image'])) : ?>
                                <img src="<?php echo esc_url(fenster_generated_url((string) ($card['image']['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" loading="lazy">
                            <?php endif; ?>
                            <span><?php echo esc_html($related_is_commercial ? $card['location'] : $card['type'] . ' / ' . $card['location']); ?></span>
                            <strong><?php echo esc_html($card['title']); ?></strong>
                            <?php if ($related_is_commercial) : ?>
                                <dl class="fg-case-spec-list">
                                    <div><dt><?php esc_html_e('Scope', 'fenster'); ?></dt><dd><?php echo esc_html((string) ($card['details']['scope'] ?? $card['excerpt'])); ?></dd></div>
                                    <div><dt><?php esc_html_e('Installed', 'fenster'); ?></dt><dd><?php echo esc_html(implode(', ', array_slice((array) ($card['details']['installed'] ?? []), 0, 3))); ?></dd></div>
                                </dl>
                            <?php else : ?>
                                <small><?php echo esc_html($card['excerpt']); ?></small>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-case-cta" id="fenster-enquiry">
        <div class="container fg-case-cta__inner">
            <div>
                <p class="eyebrow"><?php echo esc_html($is_commercial_single ? 'Project enquiry' : 'Next project'); ?></p>
                <h2><?php echo esc_html($is_commercial_single ? 'Send project requirements.' : 'Want Fenster to look at your property or commercial site?'); ?></h2>
                <p><?php echo esc_html($is_commercial_single ? 'Call ' . $phone . ' or email ' . $email . ' with drawings, schedules, site details or access requirements.' : 'Call ' . $phone . ' or email ' . $email . ' to start a proper conversation about survey, specification and installation.'); ?></p>
            </div>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Fenster', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url($back_url); ?>"><?php echo esc_html($back_label); ?></a>
            </div>
        </div>
    </section>
</article>
