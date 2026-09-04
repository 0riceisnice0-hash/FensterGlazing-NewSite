<?php
/**
 * HOMEPAGE 3.0 — the Rightmove-UX homepage for Fenster Glazing 3.0.
 *
 * SELF-CONTAINED BY DESIGN. Everything this homepage needs lives here, in
 * `template-parts/sections/home-30.php`, `src/home30/` and `assets/home30/`.
 * The only edit anywhere else in the theme is the one filterable slug in
 * `template-parts/sections/generated-page.php`, so the whole strand can be
 * removed by deleting these files and reverting that line.
 *
 * The classic homepage (`home-experience.php`) is untouched and still renders
 * if `fenster_home_template` is filtered back to it.
 *
 * WHY IT IS BUILT THIS WAY. `src/scss/main.scss` is 50,000 lines. Adding a
 * whole homepage to it would be slow to build and impossible to unpick, so
 * this strand ships its own stylesheet the way the showroom already does.
 * `main.css` still loads underneath it for the shared header and footer;
 * every class here is namespaced `fg-h30-` so the two cannot collide.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

const FENSTER_H30_VERSION = '1.0.0';

/**
 * Is the current request the new homepage?
 */
function fenster_h30_is_home(): bool
{
    if (is_admin() || wp_doing_ajax()) {
        return false;
    }

    $path = trim((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/');

    return $path === '';
}

/**
 * The 128px square swatch for a search option, given its full-size preview.
 *
 * The option list draws each product beside a 44x46 swatch. Pointing those at
 * the full product photographs meant twenty-five files of up to 2,400px and
 * 640KB fetched to fill a strip of postage stamps. `scripts` in the scratch
 * work built square 128px copies into assets/images/home30/thumbs/; this finds
 * the copy and falls back to the original if one was never built, so a new
 * product option still shows a picture before anyone regenerates them.
 */
function fenster_h30_option_thumb(string $src): string
{
    $name = pathinfo(parse_url($src, PHP_URL_PATH) ?: $src, PATHINFO_FILENAME);

    if ($name !== '' && file_exists(FENSTER_THEME_DIR . '/assets/images/home30/thumbs/' . $name . '-128w.jpg')) {
        return FENSTER_THEME_URI . '/assets/images/home30/thumbs/' . $name . '-128w.jpg';
    }

    return $src;
}

/* -------------------------------------------------------------------------
   THE GATE
   ------------------------------------------------------------------------- */

/**
 * May this homepage render on this host?
 *
 * AN ALLOW-LIST, NOT A BLOCK-LIST, AND THE REASON IS IN `AI.md`. Composite
 * Doors V2 reached production because nothing stopped it: absence of approval
 * is not a gate, and a theme deploy carries every file in it. This homepage
 * replaces the front page of the site, so shipping it to test must not also
 * ship it to live the next time the theme goes out. An unknown host gets the
 * classic homepage.
 *
 * LIVE WAS ADDED ON 2026-09-04, ON THE OWNER'S EXPLICIT INSTRUCTION: "just make
 * sure the homepage gets replaced with the new home page. it's a redesign so."
 * It is its own commit and it is recorded in `AI.md` and `LIVECHANGES.md`,
 * which is what the paragraph above asks of whoever does this. The gate is
 * kept rather than deleted: it is what lets the local experiment and test run
 * ahead of production again, and removing it would take the safety with it.
 */
function fenster_h30_enabled(): bool
{
    $host = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));

    if ($host === '') {
        return false;
    }

    return in_array($host, [
        'fenster-glazing-30.local',   // this experiment
        'fenster-glazing.local',      // the working local site
        'test.fensterglazing.com',    // the password-protected test site
        'fensterglazing.com',         // live, opened 2026-09-04
        'www.fensterglazing.com',     // live, opened 2026-09-04
        'localhost',
        '127.0.0.1',
    ], true);
}

/* The homepage template only changes where the gate allows it. Everywhere else
   `generated-page.php` keeps its own default, which is the classic homepage. */
add_filter('fenster_home_template', static function ($template) {
    return fenster_h30_enabled() ? 'template-parts/sections/home-30' : $template;
});

/* -------------------------------------------------------------------------
   THE HEADLINE
   ------------------------------------------------------------------------- */

/**
 * The lines the hero headline types through.
 *
 * The first one is the anchor: it is what renders in the markup, what a
 * screen reader is given, and what stays on the page if the script never
 * runs. Everything after it is a prompt in a homeowner's own words, matched
 * to the tabs underneath, so the animation is doing the same job as the
 * search rather than decorating around it.
 *
 * TONEOFVOICE.md rules these out: anything that sells by naming what goes
 * wrong. No draughts, no failures, no misted glass as a complaint. Say the
 * thing someone wants, not the thing they are afraid of.
 *
 * @return array<int, string>
 */
function fenster_h30_headlines(): array
{
    return (array) apply_filters('fenster_h30_headlines', [
        'What would you like to change?',
        'Windows for the whole house?',
        'A new front door?',
        'Doors onto the garden?',
        'More light in the kitchen?',
    ]);
}

/* -------------------------------------------------------------------------
   THE PRICING TOOL
   ------------------------------------------------------------------------- */

/**
 * The WindowCAD quote tool, as embedded in the pricing band.
 *
 * The same retail interface the other templates open, kept in one place here
 * so the strand stays self-contained, and filterable so a different account
 * or interface can be swapped in without touching the markup.
 */
function fenster_h30_quote_embed_url(): string
{
    $url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing';

    return (string) apply_filters('fenster_h30_quote_embed_url', $url);
}

/* -------------------------------------------------------------------------
   ASSETS
   ------------------------------------------------------------------------- */

add_action('wp_enqueue_scripts', 'fenster_h30_assets', 20);
function fenster_h30_assets(): void
{
    if (! fenster_h30_enabled() || ! fenster_h30_is_home()) {
        return;
    }

    $css = FENSTER_THEME_DIR . '/assets/home30/home30.css';
    $js = FENSTER_THEME_DIR . '/assets/home30/home30.js';

    if (file_exists($css)) {
        wp_enqueue_style(
            'fenster-home30',
            FENSTER_THEME_URI . '/assets/home30/home30.css',
            ['fenster-main'],
            (string) filemtime($css)
        );
    }

    if (file_exists($js)) {
        wp_enqueue_script(
            'fenster-home30',
            FENSTER_THEME_URI . '/assets/home30/home30.js',
            [],
            (string) filemtime($js),
            true
        );
    }

    /* The pricing iframe is a third-party origin and the thing people came to
       use, so the connection is opened while they are still reading the hero.
       The frame itself still loads late; see src/home30/quote.js. */
    add_action('wp_head', static function (): void {
        echo '<link rel="preconnect" href="https://www.windowsoftware.co.uk" crossorigin>' . "
";
        echo '<link rel="dns-prefetch" href="https://www.windowsoftware.co.uk">' . "
";
    }, 2);
}

/* -------------------------------------------------------------------------
   THE FINDER
   -------------------------------------------------------------------------
   Real product links are the baseline. JavaScript adds filtering, accessible
   category tabs and matching project photos. The older fg_find/fg_where GET
   resolver remains for bookmarked URLs, not as the new visible interface.
   ------------------------------------------------------------------------- */

/**
 * Shared catalogue and verified case-study photography for the homepage finder.
 *
 * @return array<string, array<string, mixed>>
 */
function fenster_h30_search_groups(): array
{
    return [
        'windows' => [
            'label' => 'Windows',
            'placeholder' => 'Try "sash", "bay window" or "misted glass"',
            /* Hand-picked. Black bay windows against white render under a blue
               sky is the strongest window contrast we own, and the neighbouring
               pebbledash with its old white frames makes the point without a
               caption. Cropped left-of-centre by `object-position` to keep the
               bins, the cables and the neighbour out of frame. */
            'image' => 'cs-wolverton-restyle-front-after.jpg',
            'width' => 1600,
            'height' => 1200,
            'alt' => 'Black flush casement bay windows and a black front door on a white rendered 1930s home in Wolverton',
            'location' => 'Wolverton',
            'caption' => 'Black flush casements on a 1930s semi',
            'project' => 'flush-casement-windows-and-composite-door-wolverton',
            'options' => [
                ['value' => 'casement-windows', 'label' => 'uPVC windows', 'meta' => 'Side or top opening casements', 'keywords' => 'replacement double glazing plastic pvc liniar'],
                ['value' => 'flush-casement-windows', 'label' => 'Flush windows', 'meta' => 'A flat face for a traditional look', 'keywords' => 'flush sash timber look period'],
                ['value' => 'sliding-sash-windows', 'label' => 'Sliding sash windows', 'meta' => 'Sashes that slide up and down', 'keywords' => 'vertical slider roseview period victorian'],
                ['value' => 'aluminium-windows', 'label' => 'Aluminium windows', 'meta' => 'Slim frames and more glass', 'keywords' => 'metal aluminum slimline modern'],
                ['value' => 'aluminium-flush-windows', 'label' => 'Aluminium flush windows', 'meta' => 'Slim frames with a flat face', 'keywords' => 'metal aluminum modern'],
                ['value' => 'heritage-windows', 'label' => 'Steel-look windows', 'meta' => 'Slim aluminium with a heritage look', 'keywords' => 'heritage crittall period industrial'],
                ['value' => 'bow-bay-windows', 'label' => 'Bay and bow windows', 'meta' => 'Windows that project from the house', 'keywords' => 'bay bow curved'],
                ['value' => 'tilt-turn-windows', 'label' => 'Tilt and turn windows', 'meta' => 'Tilt for ventilation or open inwards', 'keywords' => 'tilt turn inward'],
                ['value' => 'french-casement-windows', 'label' => 'French casement windows', 'meta' => 'A pair without a fixed centre post', 'keywords' => 'double opening french'],
                ['value' => 'obscured-glass', 'label' => 'Privacy glass', 'meta' => 'Patterned glass for bathrooms and doors', 'keywords' => 'obscure obscured frosted opaque bathroom'],
                ['value' => 'secondary-glazing', 'label' => 'Secondary glazing', 'meta' => 'An extra pane inside your existing window', 'keywords' => 'noise sound quiet listed draught'],
            ],
        ],
        'doors' => [
            'label' => 'Doors',
            'placeholder' => 'Try "front door", "bifold" or "sliding patio"',
            /* A WHOLE HOUSE, NOT A DOOR. The banner is scenery behind a
               search box, so it wants an elevation with depth in it, the same
               as the other two tabs. A door photographed close enough to show
               its handle is a product shot; those belong in the tiles and the
               case studies further down, where showing the product is the job.

               This is the Hanslope garden elevation: stone, a tilt and turn on
               the left and a fully glazed door onto the decking on the right. */
            'image' => 'cs-hanslope-gable-tilt-turn-and-door.jpg',
            'width' => 1600,
            'height' => 1200,
            'alt' => 'A stone barn conversion in Hanslope with an anthracite tilt and turn window and a fully glazed door onto the decking',
            'location' => 'Hanslope',
            'caption' => 'A glazed garden door on a stone barn conversion',
            'project' => 'flush-casement-tilt-turn-and-doors-hanslope',
            /* Down onto the door. A wide banner can only keep about half the
               height of a 4:3 photograph, and spending that half on the gable
               left the door running off the bottom edge. This lands on the
               door and the decking it opens onto. */
            'focus' => '52% 74%',
            /* A phone banner is upright, so it keeps the full height and
               crops the width instead. The door is over on the right of this
               photograph, so the narrow crop has to go and find it. */
            'focus_narrow' => '100% 50%',
            'options' => [
                ['value' => 'composite-doors', 'label' => 'Front doors', 'meta' => 'Composite doors in your choice of colour', 'keywords' => 'entrance front composite distinction secure'],
                ['value' => 'upvc-doors', 'label' => 'Back and side doors', 'meta' => 'Practical uPVC doors for everyday use', 'keywords' => 'back side upvc pvc plastic kitchen'],
                ['value' => 'aluminium-bifold-doors', 'label' => 'Bifold doors', 'meta' => 'Fold the panels back onto the garden', 'keywords' => 'bi fold folding bifold aluminum aluminium'],
                ['value' => 'aluminium-sliding-doors', 'label' => 'Aluminium sliding doors', 'meta' => 'Big glass panels that slide to the side', 'keywords' => 'patio slider sliding garden aluminum'],
                ['value' => 'french-doors', 'label' => 'French doors', 'meta' => 'A pair that opens from the middle', 'keywords' => 'double garden french'],
                ['value' => 'patio-doors', 'label' => 'uPVC patio doors', 'meta' => 'Sliding doors for the garden', 'keywords' => 'plastic slider patio upvc pvc'],
                ['value' => 'slide-fold-doors', 'label' => 'Slide and fold doors', 'meta' => 'Folding panels with an everyday access door', 'keywords' => 'slide fold folding traffic'],
                ['value' => 'heritage-aluminium-doors', 'label' => 'Steel-look doors', 'meta' => 'Heritage doors and internal screens', 'keywords' => 'heritage crittall industrial internal aluminium'],
                ['value' => 'aluminium-doors', 'label' => 'Aluminium entrance doors', 'meta' => 'A single aluminium door', 'keywords' => 'front entrance single aluminum'],
            ],
        ],
        'whole-home' => [
            'label' => 'Whole house',
            'placeholder' => 'Try "whole house", "roof lantern" or "repairs"',
            'image' => 'cs-little-horwood-flush-frontage.jpg',
            'width' => 1600,
            'height' => 1200,
            'alt' => 'Agate grey flush windows and a matching composite front door across a Little Horwood cottage',
            'location' => 'Little Horwood',
            'caption' => 'New windows and a matching front door',
            'project' => 'flush-casement-windows-and-composite-door-little-horwood',
            'options' => [
                ['value' => 'online-quote', 'label' => 'Windows and doors together', 'meta' => 'Design your project and get a price online', 'keywords' => 'whole house home renovation quote cost price budget replace all'],
                ['value' => 'book-a-consultation', 'label' => 'Help planning your project', 'meta' => 'Book a free home consultation', 'keywords' => 'whole house home advice unsure help survey visit extension renovation'],
                ['value' => 'roof-lanterns', 'label' => 'Roof lanterns', 'meta' => 'Bring daylight into a flat-roof extension', 'keywords' => 'extension kitchen roof lantern skylight light'],
                ['value' => 'flat-rooflights', 'label' => 'Flat rooflights', 'meta' => 'Glazing that sits low on a flat roof', 'keywords' => 'extension roof light skylight'],
                ['value' => 'integral-blinds', 'label' => 'Blinds inside the glass', 'meta' => 'Adjust light and privacy', 'keywords' => 'integral blind privacy'],
                ['value' => 'double-glazing-replacement', 'label' => 'Replacement glass', 'meta' => 'Replace misted or blown double glazing', 'keywords' => 'misted misty blown foggy fogged condensation broken glass repair'],
                ['value' => 'window-and-door-repairs', 'label' => 'Window and door repairs', 'meta' => 'Help with hinges, handles and locks', 'keywords' => 'fix repair handle hinge lock sticking'],
            ],
        ],
    ];
}


/**
 * Hero images used by the linked pages. Bespoke heroes override product_media;
 * keep these exceptions in step with their named templates when they change.
 * Advice/quote pages have no product hero and retain the category photograph.
 */
function fenster_h30_option_preview(string $slug): array
{
    static $previews = null;
    if ($previews === null) {
        $site = fenster_site_data();
        $previews = [];
        foreach ($site['product_media'] ?? [] as $key => $media) {
            $previews[$key] = $media['hero'] ?? [];
        }
        $products = '/wp-content/themes/fenster/assets/images/products/';
        // generated-page.php: canvas opening frame, composite hero and video poster.
        $previews['aluminium-windows'] = [
            'src' => fenster_aluminium_windows_story_asset_url('frames-desktop/frame-001.webp'),
            'alt' => 'Aluminium windows on a brick building from the product-page animation',
        ];
        $previews['composite-doors'] = [
            'src' => $products . 'composite-distinction/gallery/chatsworth-double-lite-1400w.webp',
            'alt' => 'Pale composite entrance door with twin Chatsworth glazed panels',
        ];
        $previews['slide-fold-doors'] = [
            'src' => $products . 'slide-fold/sf-hero-poster-1280w.webp',
            'alt' => 'Slide and fold doors across a garden opening',
        ];
        // Bespoke section templates: roof-lanterns, flat-rooflights, heritage-aluminium-doors.
        $previews['roof-lanterns'] = [
            'src' => $products . 'roof-lanterns/hero/lantern-drayton-parslow-1200w.webp',
            'alt' => 'Roof lantern installed at a home in Drayton Parslow',
        ];
        $previews['flat-rooflights'] = [
            'src' => $products . 'roof-lanterns/flat-rooflights/fixed-flat-rooflights-installed-pair.jpg',
            'alt' => 'Pair of fixed flat rooflights installed on a flat roof',
        ];
        $previews['heritage-aluminium-doors'] = [
            'src' => $products . 'heritage-aluminium/hero/heritage-door-brick-1760w.webp',
            'alt' => 'Black Sheerline heritage aluminium French doors in a red brick courtyard',
        ];
        // Privacy glass uses a texture wall, not one photograph: preview its first tile.
        $texture = $site['obscure_glass']['textures'][0] ?? [];
        $previews['obscured-glass'] = [
            'src' => $texture['image'] ?? '',
            'alt' => ($texture['name'] ?? 'Patterned') . ' privacy glass from the product-page texture wall',
        ];
    }
    return $previews[$slug] ?? [];
}

/**
 * Every product value the search can legitimately return, flattened.
 *
 * @return array<string, true>
 */
function fenster_h30_search_values(): array
{
    static $values = null;

    if ($values === null) {
        $values = [];
        foreach (fenster_h30_search_groups() as $group) {
            foreach ($group['options'] as $option) {
                $values[$option['value']] = true;
            }
        }
    }

    return $values;
}

/**
 * Resolve a product and an optional town onto a real route.
 *
 * Falls back to the plain product route whenever the product+town combination
 * is not one the location matrix publishes, which is most of the service
 * routes. A search must never land on a 404.
 */
function fenster_h30_resolve(string $product, string $town): string
{
    if ($product === '' || ! isset(fenster_h30_search_values()[$product])) {
        return home_url('/');
    }

    if ($town !== ''
        && isset(fenster_location_matrix_products()[$product])
        && isset(fenster_location_matrix_towns()[$town])
    ) {
        return home_url('/' . $product . '-' . $town . '/');
    }

    return home_url('/' . $product . '/');
}

add_action('template_redirect', 'fenster_h30_handle_search', -3);
function fenster_h30_handle_search(): void
{
    if (! fenster_h30_is_home()) {
        return;
    }

    if (! isset($_GET['fg_find'])) {
        return;
    }

    $product = isset($_GET['fg_find']) && is_string($_GET['fg_find'])
        ? sanitize_key(wp_unslash($_GET['fg_find'])) : '';
    $town = isset($_GET['fg_where']) && is_string($_GET['fg_where'])
        ? sanitize_key(wp_unslash($_GET['fg_where'])) : '';

    $target = fenster_h30_resolve($product, $town);

    if ($target === home_url('/')) {
        return; // nothing usable chosen; just render the homepage
    }

    wp_safe_redirect($target, 302);
    exit;
}

/* -------------------------------------------------------------------------
   BROWSE CATEGORIES
   -------------------------------------------------------------------------
   Six things a homeowner might actually be thinking, each with the technical
   routes underneath it as text links. The card is the homeowner's language;
   the links are the industry's.
   ------------------------------------------------------------------------- */

/**
 * @return array<int, array<string, mixed>>
 */
/* The six tile photographs are served at 720px wide, built from the full
   size originals into assets/images/home30/tiles/. The slot is 184px on a
   desktop and 348 on a phone; the originals ran to 2560px and 640KB each,
   which was two megabytes fetched to fill a strip of thumbnails. Rebuild
   them from the originals if a tile photograph is ever changed. */
function fenster_h30_categories(): array
{
    $img = '/wp-content/themes/fenster/assets/images/products/';

    return [
        [
            'title' => 'Windows',
            'copy' => 'Replace the lot, or just the ones that have gone.',
            'url' => home_url('/casement-windows/'),
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/cs-little-horwood-flush-window-open-720w.jpg',
            'alt' => 'An agate grey flush casement window standing open on a rendered cottage',
            'links' => [
                ['uPVC casement', '/casement-windows/'],
                ['Flush sash', '/flush-casement-windows/'],
                ['Sliding sash', '/sliding-sash-windows/'],
                ['Aluminium', '/aluminium-windows/'],
                ['Bay and bow', '/bow-bay-windows/'],
            ],
        ],
        [
            'title' => 'Front doors',
            'copy' => 'The one everybody sees. Colour, glass and locking, chosen properly.',
            'url' => home_url('/composite-doors/'),
            /* Two earlier attempts here were a 348x425 supplier cut-out and
               then the yellow Drayton Parslow door. This is the Milton Keynes
               composite front door: anthracite, diamond light, glazed
               sidelight, the whole door in the frame with the soffit above it
               and the step below. It appears nowhere else on the page. */
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/cs-mk-composite-door-finished-720w.jpg',
            'alt' => 'An anthracite grey composite front door with a diamond light and a glazed sidelight, fitted in Milton Keynes',
            'links' => [
                ['Composite doors', '/composite-doors/'],
                ['uPVC doors', '/upvc-doors/'],
                ['Aluminium doors', '/aluminium-doors/'],
                ['Door colours', '/colour-options/'],
            ],
        ],
        [
            'title' => 'Doors onto the garden',
            'copy' => 'Open a wall, or a corner of the kitchen, and keep the weather out.',
            'url' => home_url('/aluminium-bifold-doors/'),
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/sheerline-bifold-doors-720w.jpg',
            'alt' => 'Open-plan kitchen looking out through aluminium bifold doors onto open countryside',
            'links' => [
                ['Bifold doors', '/aluminium-bifold-doors/'],
                ['Sliding doors', '/aluminium-sliding-doors/'],
                ['French doors', '/french-doors/'],
                ['Slide and fold', '/slide-fold-doors/'],
                ['Heritage doors', '/heritage-aluminium-doors/'],
            ],
        ],
        [
            'title' => 'Light from above',
            'copy' => 'For the middle of a flat roof, where a window cannot reach.',
            'url' => home_url('/roof-lanterns/'),
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/sheerline-roof-lantern-720w.jpg',
            'alt' => 'An aluminium roof lantern over a kitchen extension',
            'links' => [
                ['Roof lanterns', '/roof-lanterns/'],
                ['Flat rooflights', '/flat-rooflights/'],
            ],
        ],
        [
            'title' => 'Glass and privacy',
            'copy' => 'Blinds inside the glass, patterned glass, and quieter rooms.',
            'url' => home_url('/integral-blinds/'),
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/notan-integral-blinds-720w.jpg',
            'alt' => 'Integral blinds sealed inside a double glazed unit',
            'links' => [
                ['Integral blinds', '/integral-blinds/'],
                ['Obscured glass', '/obscured-glass/'],
                ['Secondary glazing', '/secondary-glazing/'],
            ],
        ],
        [
            'title' => 'Repairs and misted glass',
            'copy' => 'Often the frame is fine and only the glass has failed.',
            'url' => home_url('/double-glazing-replacement/'),
            /* The CLEAR view, not the misted one. The misted photograph is the
               honest "before" and it is on the product page where it belongs,
               but as a browse tile it is the one bleak, grey image on an
               otherwise bright page. This shows the same window fixed. */
            'image' => '/wp-content/themes/fenster/assets/images/home30/tiles/rg-view-clear-1400w-720w.jpg',
            'alt' => 'A clear view through a replaced double glazed unit',
            'links' => [
                ['Misted units', '/double-glazing-replacement/'],
                ['Window and door repairs', '/window-and-door-repairs/'],
                ['Cat and dog flaps', '/cat-and-dog-flaps/'],
            ],
        ],
    ];
}

/* -------------------------------------------------------------------------
   PROJECTS AS LISTINGS
   -------------------------------------------------------------------------
   The case studies already carry a location, a product list, a date, a photo
   and approved copy. Presented as listing cards they read like property
   results, which is exactly the browsing pattern this homepage borrows.

   THE COLOUR CHIP IS READ OUT OF THE APPROVED SUMMARY, never invented. If the
   summary does not name a colour the chip is simply absent; nothing is
   guessed. `AI.md` forbids inventing product detail and this is the one place
   the temptation would be strongest.
   ------------------------------------------------------------------------- */

/**
 * Pull a finish name out of already-approved case-study copy.
 */
function fenster_h30_colour_from(string $text): string
{
    /* Longest first so "anthracite grey" wins over "grey". */
    $vocabulary = [
        'anthracite grey', 'agate grey', 'chartwell green', 'colza yellow',
        'black brown', 'irish oak', 'golden oak', 'jet black', 'rosewood',
        'two-tone', 'anthracite', 'cream', 'white', 'black', 'grey', 'oak',
    ];

    $haystack = strtolower($text);

    foreach ($vocabulary as $colour) {
        if (str_contains($haystack, $colour)) {
            return ucfirst($colour);
        }
    }

    return '';
}

/**
 * Residential case studies shaped as listing cards.
 *
 * @return array<int, array<string, mixed>>
 */
function fenster_h30_projects(int $limit = 6): array
{
    if (! function_exists('fenster_case_studies_of_type') || ! function_exists('fenster_case_study_card')) {
        return [];
    }

    $cards = [];

    foreach (fenster_case_studies_of_type('residential') as $short => $study) {
        $card = fenster_case_study_card($short, $study);

        $image = is_array($card['image'] ?? null) ? $card['image'] : null;
        if ($image === null) {
            continue;
        }

        $products = [];
        foreach ((array) ($card['products'] ?? []) as $product) {
            $label = is_array($product) ? (string) ($product['label'] ?? '') : (string) $product;
            if ($label !== '') {
                $products[] = $label;
            }
        }

        $product_text = strtolower(implode(' ', $products));
        $project_types = [];
        if (str_contains($product_text, 'window') || str_contains($product_text, 'secondary glazing')) {
            $project_types[] = 'windows';
        }
        if (str_contains($product_text, 'door')) {
            $project_types[] = 'doors';
        }
        if (count($project_types) === 2) {
            $project_types[] = 'together';
        }
        $timestamp = strtotime((string) ($card['date'] ?? ''));

        $cards[] = [
            'url' => (string) $card['url'],
            'location' => (string) $card['location'],
            'summary' => (string) $card['summary'],
            'products' => $products,
            'types' => $project_types,
            'colour' => fenster_h30_colour_from((string) $card['summary']),
            'date' => $timestamp ? date_i18n('F Y', $timestamp) : '',
            'image' => $image,
        ];

        if (count($cards) >= $limit) {
            break;
        }
    }

    return $cards;
}

/* -------------------------------------------------------------------------
   THE COVERAGE MAP
   -------------------------------------------------------------------------
   One red outline around the whole working area, a pin for every residential
   case study inside it, and the showroom. Rendered by `src/home30/map.js`,
   which uses Google Maps if `FENSTER_GOOGLE_MAPS_KEY` is configured and
   Leaflet on OpenStreetMap when it is not. All of the geography is here so
   it can be edited without touching the JavaScript.
   ------------------------------------------------------------------------- */

/**
 * A browser key for the Google Maps JavaScript API, if one has been set.
 *
 * Same resolution order as the Places key: constant, then environment, then
 * the option. Restrict it by HTTP referrer in Cloud Console; it is public.
 */
function fenster_h30_google_maps_key(): string
{
    if (! function_exists('fenster_google_config_value')) {
        return '';
    }

    return fenster_google_config_value('FENSTER_GOOGLE_MAPS_KEY', 'fenster_google_maps_key');
}

/**
 * The working area as one ring of [lat, lng] points, clockwise from the north.
 *
 * DRAWN THROUGH THE OUTER TOWNS THE LOCATION MATRIX PUBLISHES, not derived
 * from postcode geometry: Northampton at the top, round by Bedford to
 * Stevenage and Hitchin, along the bottom past Luton and Dunstable to
 * Aylesbury, and back up through Buckingham and Towcester. The points between
 * towns follow the countryside between them so the line reads as a boundary
 * rather than a polygon with eight corners. Edit freely; the map re-fits
 * itself to whatever ring is here.
 *
 * @return array<int, array{0: float, 1: float}>
 */
function fenster_h30_coverage_outline(): array
{
    // Drawn about 5 km outside the outermost towns we work in, so each of them
    // sits inside the line rather than on it. Clockwise from the north.
    return [
        [52.360, -0.850], // north of Northampton
        [52.365, -0.700], // north of Wellingborough
        [52.335, -0.580], // Rushden
        [52.260, -0.450],
        [52.195, -0.300], // north of Sandy
        [52.140, -0.215], // east of Sandy
        [52.050, -0.165], // Biggleswade side
        [51.950, -0.135], // east of Stevenage
        [51.870, -0.150],
        [51.800, -0.215], // Welwyn
        [51.715, -0.295], // south of St Albans
        [51.695, -0.420], // south of Hemel Hempstead
        [51.705, -0.550], // south of Berkhamsted
        [51.735, -0.665], // Tring
        [51.760, -0.800], // south of Aylesbury
        [51.790, -0.920],
        [51.850, -1.050],
        [51.950, -1.185], // west of Brackley
        [52.050, -1.225], // north-west of Brackley
        [52.135, -1.165], // west of Towcester
        [52.225, -1.080],
        [52.305, -1.000],
        [52.360, -0.850],
    ];
}

/**
 * Where the pins go. Keyed by the first part of a case study's `location`,
 * lower-cased, so "Wolverton, Milton Keynes" and "Wolverton" both land on
 * Wolverton. A study whose town is not here is simply not pinned — nothing
 * is ever placed by guesswork.
 *
 * @return array<string, array{0: float, 1: float}>
 */
function fenster_h30_town_coordinates(): array
{
    return [
        'milton keynes'   => [52.0406, -0.7594],
        'wolverton'       => [52.0628, -0.8099],
        'whitehouse'      => [52.0290, -0.8380],
        'broughton'       => [52.0500, -0.7010],
        'bolbeck park'    => [52.0600, -0.7420],
        'bletchley'       => [51.9950, -0.7350],
        'woburn sands'    => [52.0180, -0.6520],
        'winslow'         => [51.9420, -0.8820],
        'little horwood'  => [51.9640, -0.8560],
        'drayton parslow' => [51.9480, -0.7940],
        'leighton buzzard'=> [51.9165, -0.6600],
        'leagrave'        => [51.9030, -0.4620],
        'eversholt'       => [51.9930, -0.5720],
        'hanslope'        => [52.1130, -0.8280],
        'northampton'     => [52.2405, -0.9027],
        'bedford'         => [52.1364, -0.4668],
        'newport pagnell' => [52.0870, -0.7220],
        'olney'           => [52.1530, -0.7020],
        'wellingborough'  => [52.3020, -0.6940],
        'rushden'         => [52.2880, -0.6010],
        'towcester'       => [52.1330, -0.9890],
        'brackley'        => [52.0330, -1.1470],
        'buckingham'      => [51.9950, -0.9870],
        'aylesbury'       => [51.8160, -0.8130],
        'tring'           => [51.7960, -0.6600],
        'berkhamsted'     => [51.7600, -0.5630],
        'hemel hempstead' => [51.7530, -0.4490],
        'st albans'       => [51.7550, -0.3360],
        'luton'           => [51.8790, -0.4180],
        'dunstable'       => [51.8860, -0.5210],
        'toddington'      => [51.9500, -0.5330],
        'flitwick'        => [52.0030, -0.4930],
        'ampthill'        => [52.0270, -0.4950],
        'hitchin'         => [51.9490, -0.2830],
        'letchworth'      => [51.9780, -0.2290],
        'stevenage'       => [51.9030, -0.2020],
        'biggleswade'     => [52.0860, -0.2640],
        'sandy'           => [52.1300, -0.2900],
    ];
}

/**
 * Everything the map needs, as one array ready for JSON.
 *
 * Pins come from the residential case studies only, and only those whose
 * town has coordinates above, so the commercial jobs in Leeds, London and
 * Coventry stay off a map of where we fit windows for homeowners. Two studies
 * in one town are nudged apart by a few dozen metres so both stay clickable.
 *
 * @return array<string, mixed>
 */
function fenster_h30_map_data(): array
{
    $pins = [];
    $seen = [];

    if (function_exists('fenster_case_studies_of_type') && function_exists('fenster_case_study_card')) {
        $towns = fenster_h30_town_coordinates();

        foreach (fenster_case_studies_of_type('residential') as $short => $study) {
            $card = fenster_case_study_card($short, $study);
            $location = (string) ($card['location'] ?? '');
            $town = strtolower(trim((string) strtok($location, ',')));

            if ($town === '' || ! isset($towns[$town])) {
                continue;
            }

            /* SEVERAL JOBS IN ONE TOWN GET SPREAD AROUND IT.
               Three studies in Wolverton all share one set of coordinates, and
               a straight diagonal nudge of a few hundred metres left them in a
               stack that reads as one pin. The first keeps the town's own spot
               and the rest are placed around it, each a further turn of the
               golden angle so no two ever line up however many there are. The
               longitude step is divided by the cosine of the latitude, without
               which a ring drawn this far north comes out as an ellipse. */
            $seen[$town] = ($seen[$town] ?? 0) + 1;
            $spread = $seen[$town] - 1;
            $lat = $towns[$town][0];
            $lng = $towns[$town][1];

            if ($spread > 0) {
                $angle = deg2rad(($spread - 1) * 137.5);
                $radius = 0.012;
                $lat += $radius * cos($angle);
                $lng += ($radius * sin($angle)) / max(0.2, cos(deg2rad($lat)));
            }

            $products = [];
            foreach ((array) ($card['products'] ?? []) as $product) {
                $label = is_array($product) ? (string) ($product['label'] ?? '') : (string) $product;
                if ($label !== '') {
                    $products[] = $label;
                }
            }

            $image = is_array($card['image'] ?? null) ? (string) ($card['image']['src'] ?? $card['image']['url'] ?? '') : '';

            $pins[] = [
                'lat' => $lat,
                'lng' => $lng,
                'location' => $location,
                'products' => implode(' · ', $products),
                'url' => (string) ($card['url'] ?? ''),
                'image' => $image,
            ];
        }
    }

    return [
        'googleKey' => fenster_h30_google_maps_key(),
        'outline' => fenster_h30_coverage_outline(),
        'pins' => $pins,
        'showroom' => [
            'lat' => 52.0466,
            'lng' => -0.7938,
            'label' => 'Fenster Glazing showroom',
            'address' => '98 Alston Drive, Bradwell Abbey, Milton Keynes MK13 9HF',
            'url' => home_url('/contact/'),
            /* The card opens the reveal, so it carries a photograph like every
               job card does rather than being the one plain box among them. */
            'image' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png',
        ],
    ];
}

/* -------------------------------------------------------------------------
   LOCAL LINK MESH
   -------------------------------------------------------------------------
   Rightmove's footer is a wall of "Property for sale in ..." links, and it is
   there because it is genuinely how people navigate. The same applies here:
   these are real routes out of the location matrix.
   ------------------------------------------------------------------------- */

/**
 * @return array<int, array{town: string, links: array<int, array{0: string, 1: string}>}>
 */
function fenster_h30_area_mesh(): array
{
    $towns = [
        'bletchley' => 'Bletchley',
        'wolverton' => 'Wolverton',
        'stony-stratford' => 'Stony Stratford',
        'newport-pagnell' => 'Newport Pagnell',
    ];

    $products = [
        'casement-windows' => 'Windows',
        'composite-doors' => 'Front doors',
        'aluminium-bifold-doors' => 'Bifold doors',
        'sliding-sash-windows' => 'Sash windows',
    ];

    $matrix_towns = fenster_location_matrix_towns();
    $matrix_products = fenster_location_matrix_products();

    $mesh = [];

    foreach ($towns as $town_slug => $town_label) {
        if (! isset($matrix_towns[$town_slug])) {
            continue;
        }

        $links = [];
        foreach ($products as $product_slug => $product_label) {
            if (! isset($matrix_products[$product_slug])) {
                continue;
            }
            $links[] = [$product_label . ' in ' . $town_label, '/' . $product_slug . '-' . $town_slug . '/'];
        }

        $mesh[] = ['town' => $town_label, 'links' => $links];
    }

    return $mesh;
}
