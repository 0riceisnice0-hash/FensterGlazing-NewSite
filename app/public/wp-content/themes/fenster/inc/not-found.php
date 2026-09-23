<?php
/**
 * The 404 and 410 pages: what to offer somebody who followed a dead link.
 *
 * Rebuilt 2026-09-23. The old page said "Use the links below" and had no links
 * below it, only a button back to the homepage.
 *
 * WHO ACTUALLY LANDS ON IT, from the live access logs for 24 August to 22
 * September 2026, with crawlers taken out: people following a link somebody
 * guessed (`/instant-quote/`, from Legend's chat replies and a Facebook post,
 * now redirected), people arriving from Google on a malformed address that got
 * indexed (`/what-are-integral-blindsparent/`), and links that picked up junk on
 * the end (`/casement-windows-letchworth/tel:01908429200`). In every one of
 * those the right page exists and its address is close to the one requested,
 * so the page offers the closest published pages before anything else.
 *
 * HOW A MATCH IS FOUND. Candidates are exactly the sitemap
 * (`fenster_generated_sitemap_entries()`), so nothing unpublished, redirected or
 * noindexed is ever offered. A candidate has to explain the request: either
 * every word of the requested address appears in it, or every word of it
 * appears in the request, or the two addresses are near-identical strings.
 * That rule is what stops `/double-glazing-hertford/` being offered "Double
 * glazing replacement" on the strength of two shared words. A town page is
 * never offered for a request that does not name that town, because a
 * neighbouring town's page looks like a match and is the wrong answer. Checked
 * against the real 404s above and forty guessed addresses before it shipped.
 *
 * It runs only on a 404, which is never cached, so a suggestion can depend on
 * the address without leaking between visitors.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', 'fenster_not_found_assets', 20);
function fenster_not_found_assets(): void
{
    if (! is_404()) {
        return;
    }

    $relative = '/assets/css/not-found.css';
    $path = FENSTER_THEME_DIR . $relative;

    if (file_exists($path)) {
        wp_enqueue_style(
            'fenster-not-found',
            FENSTER_THEME_URI . $relative,
            ['fenster-main'],
            filemtime($path) . '-' . filesize($path)
        );
    }
}

/**
 * The routes offered to everyone, whatever they asked for. Each is a way into
 * a part of the site the header menu also leads to, described by what is in it.
 */
function fenster_not_found_routes(): array
{
    $phone = (string) fenster_data('brand.phone', '01908 429200');

    return [
        [
            'title' => 'Windows',
            'copy' => 'Casement, flush, sliding sash, tilt and turn, aluminium and heritage.',
            'url' => home_url('/windows-milton-keynes/'),
        ],
        [
            'title' => 'Doors',
            'copy' => 'Composite, uPVC, bifold, sliding, French and heritage aluminium.',
            'url' => home_url('/doors-milton-keynes/'),
        ],
        [
            'title' => 'Other services',
            'copy' => 'Roof lanterns, rooflights, roofline, integral blinds and replacement glass.',
            'url' => home_url('/other-services/'),
        ],
        [
            // Repairs go to the repairs page and its form, never to the quote
            // tool: a repair has no specification to price.
            'title' => 'Repairs',
            'copy' => 'Locks, hinges, handles, seals and misted glass.',
            'url' => home_url('/window-and-door-repairs/'),
        ],
        [
            'title' => 'Commercial',
            'copy' => 'Windows, doors, curtain walling, louvres and smoke vents.',
            'url' => home_url('/commercial-glazing/'),
        ],
        [
            'title' => 'Call ' . $phone,
            'copy' => 'Phone lines open 24/7.',
            'url' => 'tel:' . preg_replace('/\s+/', '', $phone),
        ],
    ];
}

/**
 * Up to three published pages whose address is closest to the requested one,
 * best first, as `['url' => ..., 'title' => ..., 'path' => ...]`. Empty when
 * nothing is close enough to be worth offering.
 */
function fenster_not_found_suggestions(string $request_path): array
{
    $request = fenster_not_found_clean_path($request_path);

    if ($request === '') {
        return [];
    }

    $towns = array_keys(fenster_location_matrix_towns());
    $aliases = fenster_not_found_menu_aliases();
    $scores = [];
    $locs = [];

    foreach (fenster_generated_sitemap_entries() as $entry) {
        $slug = trim((string) wp_parse_url($entry['loc'], PHP_URL_PATH), '/');

        if ($slug === '' || isset($scores[$slug])) {
            continue;
        }

        foreach ($towns as $town) {
            if (str_ends_with($slug, '-' . $town) && ! str_contains($request, $town)) {
                continue 2;
            }
        }

        $score = fenster_not_found_score($request, $slug, $aliases[$slug] ?? []);

        // Prefer the page a menu leads to over a blog post of the same name.
        if ($score > 0 && $score < 0.95 && isset($aliases[$slug])) {
            $score = min(0.94, $score + 0.12);
        }

        if ($score >= 0.5) {
            $scores[$slug] = $score;
            $locs[$slug] = $entry['loc'];
        }
    }

    if ($scores === []) {
        return [];
    }

    arsort($scores);
    $best = (float) reset($scores);
    $suggestions = [];

    foreach ($scores as $slug => $score) {
        // An exact or parent match is the answer; anything below it is noise.
        if (count($suggestions) === 3 || ($best >= 0.95 && $suggestions !== []) || $score < $best - 0.15) {
            break;
        }

        $suggestions[] = [
            'url' => $locs[$slug],
            'title' => fenster_not_found_page_name($slug),
            'path' => '/' . $slug . '/',
        ];
    }

    return $suggestions;
}

/**
 * The requested path reduced to a comparable slug: lower case, no file
 * extension, and nothing from the first segment that cannot be part of an
 * address on this site (`tel:`, `mailto:`, an email address) onwards.
 */
function fenster_not_found_clean_path(string $path): string
{
    $segments = [];

    foreach (explode('/', strtolower(rawurldecode($path))) as $segment) {
        if ($segment === '') {
            continue;
        }

        if (preg_match('/[:@]/', $segment)) {
            break;
        }

        $segment = (string) preg_replace('/\.(html?|php|aspx?)$/', '', $segment);
        $segment = trim((string) preg_replace('/[^a-z0-9]+/', '-', $segment), '-');

        if ($segment !== '' && $segment !== 'index') {
            $segments[] = $segment;
        }
    }

    return implode('/', $segments);
}

/**
 * How well a published slug answers the request, from 0 to 1. 1 is the same
 * address, 0.95 is a parent of it, and anything else tops out at 0.9.
 */
function fenster_not_found_score(string $request, string $slug, array $alias_words): float
{
    if ($request === $slug) {
        return 1.0;
    }

    if (str_starts_with($request, $slug . '/')) {
        return 0.95;
    }

    $request_words = fenster_not_found_words($request);
    $slug_words = fenster_not_found_words($slug);

    if ($request_words === [] || $slug_words === []) {
        return 0.0;
    }

    // The menu's own name for a page counts towards the request: "uPVC
    // Casement" is how /casement-windows/ answers a request for uPVC windows.
    $answer_words = array_values(array_unique(array_merge($slug_words, $alias_words)));
    $explained = 0;

    foreach ($request_words as $word) {
        foreach ($answer_words as $answer_word) {
            if (fenster_not_found_words_match($word, $answer_word)) {
                $explained++;
                break;
            }
        }
    }

    $contained = 0;

    foreach ($slug_words as $slug_word) {
        foreach ($request_words as $word) {
            if (fenster_not_found_words_match($word, $slug_word)) {
                $contained++;
                break;
            }
        }
    }

    if ($explained === 0) {
        return 0.0;
    }

    $longest = max(strlen($request), strlen($slug));
    $similarity = 1 - levenshtein($request, $slug) / $longest;
    $fully_explained = $explained === count($request_words);
    $fully_contained = $contained === count($slug_words);

    if (! $fully_explained && ! $fully_contained && $similarity < 0.8) {
        return 0.0;
    }

    $overlap = ($explained / count($request_words) + $contained / count($slug_words)) / 2;

    return min(0.9, ($overlap + $similarity) / 2);
}

function fenster_not_found_words(string $text): array
{
    static $filler = [
        'a' => true, 'an' => true, 'and' => true, 'are' => true, 'for' => true, 'free' => true,
        'get' => true, 'how' => true, 'in' => true, 'is' => true, 'my' => true, 'of' => true,
        'on' => true, 'or' => true, 'the' => true, 'to' => true, 'us' => true, 'what' => true,
        'with' => true, 'your' => true,
    ];

    $words = preg_split('/[^a-z0-9]+/', strtolower($text)) ?: [];

    return array_values(array_unique(array_filter(
        $words,
        static fn (string $word): bool => $word !== '' && ! isset($filler[$word])
    )));
}

/**
 * Two words are the same word when they are equal, when one begins the other
 * (door/doors, blinds/blindsparent), or when one letter is out in a longer word.
 */
function fenster_not_found_words_match(string $a, string $b): bool
{
    if ($a === $b) {
        return true;
    }

    $shorter = min(strlen($a), strlen($b));

    if ($shorter >= 4 && (str_starts_with($a, $b) || str_starts_with($b, $a))) {
        return true;
    }

    return $shorter >= 5 && levenshtein($a, $b) <= 1;
}

/**
 * Words the header menu uses for each page it links to, keyed by slug.
 */
function fenster_not_found_menu_aliases(): array
{
    $aliases = [];
    $add = static function (string $label, string $url) use (&$aliases): void {
        $slug = trim((string) wp_parse_url($url, PHP_URL_PATH), '/');
        if ($slug !== '') {
            $aliases[$slug] = array_values(array_unique(array_merge($aliases[$slug] ?? [], fenster_not_found_words($label))));
        }
    };

    foreach ((array) fenster_data('primary_nav_fallback', []) as $item) {
        $add((string) ($item['label'] ?? ''), (string) ($item['url'] ?? ''));

        foreach ((array) ($item['columns'] ?? []) as $column) {
            $add((string) ($column['label'] ?? ''), (string) ($column['url'] ?? ''));

            foreach ((array) ($column['items'] ?? []) as $link) {
                $add((string) ($link['label'] ?? ''), (string) ($link['url'] ?? ''));
            }
        }
    }

    return $aliases;
}

/**
 * The name to show for a suggested page. The imported record is right for
 * nearly every route; `/online-quote/` is the exception, titled "Book a
 * Consultation" in the scrape, which the breadcrumb schema in
 * `generated-pages.php` corrects the same way.
 */
function fenster_not_found_page_name(string $slug): string
{
    $names = [
        'online-quote' => 'Online Quote',
    ];

    if (isset($names[$slug])) {
        return $names[$slug];
    }

    $page = fenster_get_generated_page($slug);
    $title = trim((string) ($page['title'] ?? ''));

    return $title !== '' ? $title : ucfirst(str_replace(['-', '/'], [' ', ' / '], $slug));
}
