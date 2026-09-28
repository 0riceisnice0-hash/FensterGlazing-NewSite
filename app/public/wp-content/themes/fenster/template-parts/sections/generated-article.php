<?php
/**
 * The imported guides from the old site, rendered through the shared article
 * layout in blog-article.php since 2026-09-28 (owner: "revamp the old blogs
 * too"). Their words, addresses and titles are unchanged; the layout, heading
 * case, lists and routes onward are new. generated-page.php still decides which
 * routes land here and passes the cleaned sections, images and related links.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$sections = is_array($args['sections'] ?? null) ? $args['sections'] : ($page['sections'] ?? []);
$images = is_array($args['images'] ?? null) ? $args['images'] : ($page['images'] ?? []);
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$title = (string) ($args['title'] ?? ($page['title'] ?? 'Fenster Glazing'));
$slug = trim((string) ($page['slug'] ?? ''), '/');

$article_next_steps_map = [
    // These four guides draw large impression volumes with almost no route
    // into a money page: soundproofing 14.5k, U-values 12.1k, acoustic vs
    // triple 3.5k and condensation 2.4k impressions a quarter between them.
    // Each next step is the genuine commercial answer to the question asked,
    // not a generic CTA.
    'soundproof-windows' => [
        'eyebrow' => 'Want a quieter room?',
        'title' => 'Cutting road and neighbour noise at the window.',
        'copy' => 'Noise usually gets in through the glass, the frame seals or the gaps around them. We can look at which of those is the problem in your room before you spend money on the wrong fix.',
        'links' => [
            ['label' => 'Secondary glazing', 'url' => home_url('/secondary-glazing/'), 'meta' => 'A second internal pane for noise'],
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Thicker units and better seals'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'When the seals are the problem'],
        ],
    ],
    'a-guide-to-understanding-u-values' => [
        'eyebrow' => 'Comparing efficiency?',
        'title' => 'What the U-value means for your rooms and your bills.',
        'copy' => 'A lower U-value means less heat escaping. We can tell you the real figure for each window we fit, so you can compare like with like rather than headline claims.',
        'links' => [
            ['label' => 'Double glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/'), 'meta' => 'Windows, doors and replacement glass'],
            ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'A+ rated options with real figures'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'which-is-better-triple-or-acoustic-glazing' => [
        'eyebrow' => 'Noise or heat?',
        'title' => 'Choose the glazing for the problem you actually have.',
        'copy' => 'Triple glazing and acoustic glass solve different things. Tell us which room, which noise and which direction it faces, and we can point you at the right specification.',
        'links' => [
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare glazing specifications'],
            ['label' => 'Secondary glazing', 'url' => home_url('/secondary-glazing/'), 'meta' => 'Often the better answer for noise'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'how-to-prevent-window-condensation-in-winter' => [
        'eyebrow' => 'Condensation between the panes?',
        'title' => 'Misting inside the glass is a failed unit, not condensation.',
        'copy' => 'Condensation on the inside face is usually ventilation. Misting sealed between the panes means the unit itself has failed, and that we can replace without changing the whole window.',
        'links' => [
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Misted units, seals and hardware'],
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When the frame has gone too'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'what-is-a-door-lintel' => [
        'eyebrow' => 'Planning door work?',
        'title' => 'Need a doorway checked before new doors or glazing?',
        'copy' => 'If a door opening, lintel or frame condition affects the project, we can check the practical details before replacement doors or glazing are ordered.',
        'links' => [
            ['label' => 'View doors', 'url' => home_url('/doors-milton-keynes/'), 'meta' => 'Front, patio, French and bifold options'],
            ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Secure entrance door replacements'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'When the opening needs attention first'],
        ],
    ],
    'different-types-of-window-frame-materials' => [
        'eyebrow' => 'Choosing frames?',
        'title' => 'Compare window materials around your home, not just the brochure.',
        'copy' => 'Frame material affects sightlines, colour, maintenance, insulation and cost. Start with the main window ranges, then we can help narrow the specification.',
        'links' => [
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare uPVC, aluminium and heritage styles'],
            ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/'), 'meta' => 'Slim frames and modern finishes'],
            ['label' => 'Colour options', 'url' => home_url('/colour-options/'), 'meta' => 'uPVC and aluminium frame colours'],
        ],
    ],
    'what-is-double-glazing-and-how-does-it-work' => [
        'eyebrow' => 'Ready to compare options?',
        'title' => 'Turn double glazing research into a practical quote.',
        'copy' => 'We can help compare windows, doors, replacement glass and frame choices around the rooms you want to improve.',
        'links' => [
            ['label' => 'Double glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/'), 'meta' => 'Windows, doors and replacement glass'],
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Browse the main window styles'],
            ['label' => 'Start an online quote', 'url' => home_url('/online-quote/'), 'meta' => 'Get a guide price before survey'],
        ],
    ],
    'what-are-double-glazed-glass-windows' => [
        'eyebrow' => 'Glass or full window?',
        'title' => 'Check whether you need replacement glass or new windows.',
        'copy' => 'If the frame is sound, failed glass may be replaceable. If the frame, seals or hardware are tired, a full window replacement may make more sense.',
        'links' => [
            ['label' => 'Double glazing replacement', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Failed sealed units and replacement glass'],
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare complete window options'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, hinges, glass and frame issues'],
        ],
    ],
    'all-you-need-to-know-about-louvre-vents' => [
        'eyebrow' => 'Commercial ventilation',
        'title' => 'Need louvres as part of a commercial glazing package?',
        'copy' => 'Louvre panels usually need airflow, free-area, colour and facade details checked before they are priced or fitted.',
        'links' => [
            ['label' => 'Louvre vents', 'url' => home_url('/louvre-vents/'), 'meta' => 'Commercial louvre panels and ventilation'],
            ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/'), 'meta' => 'Windows, doors, facades and glass'],
            ['label' => 'Commercial windows and doors', 'url' => home_url('/commercial-windows-and-doors/'), 'meta' => 'Replacement and refurbishment works'],
        ],
    ],
    'the-history-of-upvc-windows' => [
        'eyebrow' => 'Considering uPVC?',
        'title' => 'Compare modern uPVC windows with today\'s frame options.',
        'copy' => 'Modern uPVC windows can be secure, efficient and low maintenance, but aluminium, flush and heritage styles may suit some homes better.',
        'links' => [
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare all main window ranges'],
            ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'Practical uPVC window style'],
            ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/'), 'meta' => 'Cleaner traditional look'],
        ],
    ],
];

/* The old site's titles carried a second clause after a pipe ("... | Which is
   Better?"). The title tag keeps it; the H1 shows the question itself. */
$display_title = fenster_blog_sentence_case(trim(explode(' | ', $title)[0]));

/* The sections are rebuilt from the page's own data, not from the $sections
   generated-page.php passes in. Its filter drops a whole section when the
   first line is short or stops mid-sentence, and every guide's first section
   opens with the old site's "ONLINE DESIGNER" menu label, so 4,096 words of
   these guides never rendered (measured 28/09/2026): all of the stable doors
   and Anglian guides, 438 words of the Wolverton one, half of triple versus
   acoustic glazing. Here the boilerplate goes a line at a time, and the
   sentences the old import split are rejoined before anything is judged. */
$raw_sections = is_array($page['sections'] ?? null) ? $page['sections'] : $sections;
$junk_lines = [
    '/^online designer$/i',
    '/registered you will be taken to our custom design software/i',
    '/online designer tool/i',
    '/visualise your design/i',
    '/3d rendering/i',
    '/stay updated with us/i',
    '/social media channels/i',
    '/^the best windows milton keynes$/i',
    '/^commercial glazing: high-quality/i',
    '/2026 giveaway/i',
    '/showroom 97-98/i',
    '/\bwindowcad\b/i',
    // A partner logo strip and its caption, which named Manchester and
    // Birmingham in two guides; a breadcrumb; the site footer's sign-off.
    '/facilitate bespoke/i',
    '/commercial portfolio/i',
    '/^knowledge hub/i',
    '/^our system partners$/i',
    '/^don.t miss out on exclusive content/i',
    '/^fenster glazing are expert window & door installers/i',
    '/^we supply throughout/i',
];
$boilerplate_headings = '/^(?:use our quoting engine|related products|our system partners|our products|bedfordshire|northamptonshire|hertfordshire)$/i';

$article_sections = [];
foreach ($raw_sections as $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $body = [];
    foreach ((array) ($section['body'] ?? []) as $line) {
        $line = trim((string) $line);
        foreach ($junk_lines as $pattern) {
            if (preg_match($pattern, $line)) {
                continue 2;
            }
        }
        $body[] = $line;
    }

    if (preg_match($boilerplate_headings, $heading)) {
        continue;
    }

    /* The old site closed every page with the same "Get in touch" paragraph,
       192 copies of it, 36 in these guides. The enquiry section below does
       that job now. */
    if (strcasecmp($heading, 'Get in touch') === 0 && str_starts_with((string) ($body[0] ?? ''), 'We welcome our homeowners to get in touch')) {
        continue;
    }

    // The first section repeats the title.
    if ($heading === $title) {
        $heading = '';
    }

    $body = fenster_blog_join_legacy_lines($body);
    if ($heading === '' && $body === []) {
        continue;
    }

    $article_sections[] = ['heading' => $heading, 'body' => $body];
}

/* The first full paragraph opens the page, the same line generated-page.php
   would have chosen had it seen these sections. */
$lead = '';
foreach ($article_sections as $index => $section) {
    foreach ($section['body'] as $line_index => $line) {
        if (mb_strlen($line) > 70 && ! str_ends_with($line, ':')) {
            $lead = fenster_blog_repair_legacy_sentence($line);
            array_splice($article_sections[$index]['body'], $line_index, 1);
            if ($article_sections[$index]['heading'] === '' && $article_sections[$index]['body'] === []) {
                array_splice($article_sections, $index, 1);
            }
            break 2;
        }
    }
}
$lead = $lead !== '' ? $lead : trim((string) ($page['seo']['meta_description'] ?? ''));

/* Photographs that exist, each once. */
$photographs = [];
foreach ($images as $image) {
    if (! is_array($image) || empty($image['src'])) {
        continue;
    }
    $image_url = fenster_generated_url((string) $image['src']);
    $image_path = fenster_theme_asset_path_from_url($image_url);
    if ($image_path !== '' && ! is_file($image_path)) {
        continue;
    }
    $photographs[$image_path !== '' ? $image_path : $image_url] = ['src' => (string) $image['src'], 'alt' => (string) ($image['alt'] ?? '')];
}
$photographs = array_values($photographs);

/* The products a guide mentions, which also choose the posts suggested under it. */
$product_links = [];
$products = [];
foreach (array_slice(array_values($related_links), 0, 8) as $link) {
    $url = fenster_generated_url((string) ($link['url'] ?? ''));
    $text = trim((string) ($link['text'] ?? ''));
    if ($url === '' || $text === '') {
        continue;
    }
    $product_links[] = ['url' => $url, 'text' => fenster_blog_sentence_case($text)];
    $path = trim((string) wp_parse_url($url, PHP_URL_PATH), '/');
    if ($path !== '' && ! str_contains($path, '/')) {
        $products = array_merge($products, fenster_blog_page_products($path));
    }
}

get_template_part('template-parts/sections/blog-article', null, [
    'kind' => 'guide',
    'slug' => $slug,
    'title' => $display_title,
    'date' => '',
    'lead' => $lead,
    'sections' => $article_sections,
    'legacy' => true,
    'hero_image' => $photographs[0] ?? null,
    'figures' => array_slice($photographs, 1, 3),
    'next_steps' => $article_next_steps_map[$slug] ?? (is_array($page['next_steps'] ?? null) ? $page['next_steps'] : []),
    'product_links' => $product_links,
    'products' => array_values(array_unique($products)),
    'description' => (string) ($page['seo']['meta_description'] ?? ''),
    'form_source' => 'Article: ' . $title,
]);
