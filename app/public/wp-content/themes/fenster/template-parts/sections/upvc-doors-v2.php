<?php
/**
 * uPVC doors, bespoke middle.
 *
 * Route: /upvc-doors/. Dispatched from `generated-page.php` on
 * `$is_upvc_doors_bespoke`, OUTSIDE the specification-choices wrapper for the
 * reason recorded against the secondary glazing dispatch: that wrapper is gated
 * on a condition about colour swatches, so a bespoke middle placed inside it
 * silently renders nothing.
 *
 * RESTRUCTURED 2026-08-12, and the restructure is the point of this file.
 * The page had grown to eighteen sections in a fortnight of adding, and it said
 * the same things repeatedly: COLOUR appeared five times (the intro list, a
 * decisions tile, a whole photographic band, the specification-choices card and
 * the shared sixteen-swatch grid), PRIVACY GLASS three times and HARDWARE three
 * times. It also contradicted itself, because the shared grid is headed
 * "Sixteen colours" and this route is thirteen.
 *
 * The order now runs: what it is, how it opens, what it looks like, what else
 * you choose, what it is made of, what gets settled at survey. Nothing is said
 * twice, and each section answers the question a customer asks next.
 *
 * WHAT WAS REMOVED, so nobody rebuilds it out of habit:
 *
 *  - **The "on a real house" band.** Five photographs and a placeholder making
 *    the colour argument that the finish chart now makes better, with a render
 *    of every finish rather than five examples of four of them.
 *  - **The specification-choices band** (`fg-product-gallery-band`), gated off
 *    in `generated-page.php`. Three cards pointing at colour, privacy glass and
 *    handles, all three of which are on this page in full, below it.
 *  - **The shared sixteen-swatch uPVC colour grid**, by taking this slug out of
 *    `$upvc_colour_routes`. Wrong count for a door, and the finish chart
 *    replaces it. The window routes keep it, untouched.
 *  - **Every marked placeholder.** Owner, 2026-08-12: the useful assets are
 *    exhausted, so no section may depend on a photograph that does not exist.
 *  - **The intro bullet list**, which was a contents page for the sections
 *    underneath it.
 *  - **The randomiser payload**, dead since the randomiser came out.
 *
 * THE TECH BANNER IS DEFERRED INTO THIS FILE rather than rendering in its usual
 * slot under the key-specification strip. It is a profile cutaway with chamber
 * counts and U-values, and it was landing before the page had said what the
 * product is. It now sits after the choosing and before the survey detail,
 * which is where "what am I actually getting" belongs. Same mechanism
 * `/aluminium-sliding-doors/` already uses.
 *
 * OWNER-CONFIRMED, and none of it may be softened or widened:
 *
 *  - **We do not advertise the full infill panel**, the moulded 2000s front
 *    door slab. What we sell is half glazed over a flat panel, over shiplap, or
 *    glass top to bottom.
 *  - **WHERE THE PANEL STOPS IS NOT A LIST.** Owner, 2026-08-12: a quarter, a
 *    half, three quarters and full are examples, not a range, and it is drawn
 *    on the door. Do not enumerate it and do not multiply by it.
 *  - **Thirteen foils on a door**, not the windows' sixteen, and the theme holds
 *    a render of every one. The colour is the outside face, white or the same
 *    colour inside, and the inside foil costs more.
 *  - **28mm double or 36mm triple on the sculptured EnergyPlus outer frame.**
 *    Liniar also publish a 40mm unit, a standard outer frame and a chamfered
 *    profile; none of those is what we fit.
 *  - **1.0 W/m²K is the triple figure and 1.2 is the window's**, borrowed on the
 *    owner's ruling because Liniar publish no double glazed figure for this
 *    door. See the comment in `glazing_u_values`.
 *  - **Multi-point lock, one star cylinder as standard, three star upgrade.**
 *    The composite door's £5,000 break-in guarantee does NOT apply here.
 *  - **PAS 24 and Secured by Design are Liniar's and are attributed**, never
 *    asserted as ours. Same distinction as the Kenrick Excalibur.
 *  - **Cat flaps are cut in on site**, once the door is hung. Letterplates,
 *    knockers, numerals and spyholes are chosen with the door. Cylinder guards
 *    are not offered.
 *  - **THIS PAGE SELLS NEW DOORS.** A draft said a cat flap could go into "the
 *    one you already have", which is true and belongs on
 *    `/cat-and-dog-flaps/`, not here: on a new-door page it points the reader at
 *    a different job. Keep retrofit talk off this route.
 *  - **Four thresholds, in our names**, on Liniar's own cutaway drawings.
 *  - **The whole privacy glass range** is available in a door, and the page says
 *    privacy glass rather than obscure glass throughout.
 *
 * ON NOT SELLING AGAINST OURSELVES. The owner's summary of why a customer picks
 * uPVC over composite is that it is cheaper, and `TONEOFVOICE.md` forbids
 * positioning one of our own products as the budget option, in those words and
 * the softer ones. The page argues what this door DOES and lets the quote tool
 * carry the number. Composite is named once, in the FAQ, where somebody is
 * actually asking.
 */

$args = wp_parse_args(
    $args ?? [],
    [
        'brand' => [],
        'quote_url' => '',
        'renders' => [],
        'handles' => [],
        'glass' => [],
        'photos' => [],
        'tech_banner' => [],
    ]
);

$renders = is_array($args['renders']) ? $args['renders'] : [];
$handles = is_array($args['handles']) ? $args['handles'] : [];
$glass = is_array($args['glass']) ? $args['glass'] : [];
$photos = is_array($args['photos']) ? $args['photos'] : [];
$tech_banner = is_array($args['tech_banner']) ? $args['tech_banner'] : [];

$curated = '/wp-content/themes/fenster/assets/images/products/upvc-doors/curated/';

$photo = static function (string $key) use ($photos): array {
    $found = $photos[$key] ?? null;
    return is_array($found) ? $found : [];
};
?>

<?php /* 2. HOW IT OPENS. Moved up from the bottom half of the old page: it is
         the first real question a homeowner has and it is answered entirely in
         our own photographs.

         A SHAPED HEAD IS NOT A WAY OF OPENING and it is not on this page as a
         picture at all. It was a fourth card here and the owner pulled it,
         2026-08-12: an arched door is still a single leaf, so it said nothing
         about opening. It was then promoted to the opening photograph, and he
         pulled it again — shaped heads are **super niche**, so leading the page
         on one misrepresents what we sell. It gets one clause in the intro copy
         and no photograph. Do not promote it again. */ ?>
<section class="fg-cw fg-upd fg-upd-config" aria-labelledby="fg-upd-config-title">
    <div class="container">
        <div class="fg-upd-config__head">
            <p class="eyebrow"><?php esc_html_e('How it opens', 'fenster'); ?></p>
            <h2 id="fg-upd-config-title"><?php esc_html_e('Three ways the same system opens.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Decided by the opening and how the room gets used.', 'fenster'); ?></p>
        </div>
        <div class="fg-upd-config__grid">
            <?php
            $configs = [
                [
                    'title' => __('A single leaf', 'fenster'),
                    'copy' => __('The everyday one. Front, back, side or utility, hinged on the side that keeps the path clear.', 'fenster'),
                    'image' => 'upvc-door-white-shiplap-brick.webp',
                    'alt' => __('White uPVC back door glazed over a shiplap panel in a brick opening', 'fenster'),
                    'link' => '',
                    'link_label' => '',
                ],
                [
                    'title' => __('French doors', 'fenster'),
                    'copy' => __('Two leaves opening from the centre onto a garden. One is used day to day and the second unbolts when you want the whole opening.', 'fenster'),
                    'image' => 'upvc-door-white-french-decking.webp',
                    'alt' => __('White uPVC French doors opening onto decking', 'fenster'),
                    'link' => home_url('/french-doors/'),
                    'link_label' => __('More on French doors', 'fenster'),
                ],
                [
                    'title' => __('A stable door', 'fenster'),
                    'copy' => __('Split across the middle so the top half opens on its own: air in, the dog and the toddler still in.', 'fenster'),
                    'image' => 'upvc-door-white-stable.webp',
                    'alt' => __('White uPVC stable door with both halves glazed, in a brick opening', 'fenster'),
                    'link' => '',
                    'link_label' => '',
                ],
            ];
            foreach ($configs as $config) :
                ?>
                <article class="fg-upd-config__card">
                    <figure>
                        <img src="<?php echo esc_url(fenster_generated_url($curated . $config['image'])); ?>" alt="<?php echo esc_attr($config['alt']); ?>" width="1280" height="1600" loading="lazy" decoding="async">
                    </figure>
                    <h3><?php echo esc_html($config['title']); ?></h3>
                    <p><?php echo esc_html($config['copy']); ?></p>
                    <?php if ($config['link'] !== '') : ?>
                        <a class="fg-upd-config__link" href="<?php echo esc_url($config['link']); ?>"><?php echo esc_html($config['link_label']); ?></a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php /* 2b. WHATEVER SHAPE OR SIZE. This sat at the top of the middle until
         2026-08-12, when the owner moved it below the three ways of opening: the
         standard three first, and then the point that a door is made to whatever
         opening you actually have. The arched door is the proof of that
         sentence, which is why it is back after two removals — it earns its
         place here, where it illustrates a claim, rather than at the top where
         it led the page on a niche product. */ ?>
<section class="fg-cw fg-upd fg-upd-open" aria-labelledby="fg-upd-open-title">
    <div class="container">
        <div class="fg-cw-split">
            <div class="fg-cw-split__text">
                <p class="eyebrow"><?php esc_html_e('Made to the opening', 'fenster'); ?></p>
                <h2 id="fg-upd-open-title"><?php esc_html_e('Made for the opening it goes into, whatever shape or size that is.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The leaf, the frame, the threshold and the glass are all specified for your house. A plain white back door is the one we fit most, and it is made the same way as the arched one here: to the hole in your wall, whatever shape that hole is in.', 'fenster'); ?></p>
                <p><?php esc_html_e('Everything from here is what you get to choose.', 'fenster'); ?></p>
            </div>
            <?php if (! empty($photo('opening')['src'])) : ?>
                <figure class="fg-cw-media fg-upd-media--4x3">
                    <img src="<?php echo esc_url($photo('opening')['src']); ?>" alt="<?php echo esc_attr($photo('opening')['alt'] ?? ''); ?>" loading="lazy" decoding="async" width="1280" height="1600">
                    <figcaption><?php esc_html_e('Our install. A curved head made to a Victorian brick arch, with leaded glass and a full panel below.', 'fenster'); ?></figcaption>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php /* 3. THE FINISH. This replaces five separate goes at colour, and it is the
         one section on the page that could not exist anywhere else: the same
         door drawn in every finish we offer. The renders sat unused in the theme
         for a month.

         THIRTEEN IS THE WHOLE RANGE for a door, so the chart is complete rather
         than a sample, and nothing here says "and more besides". */ ?>
<?php if (! empty($renders)) : ?>
    <section class="fg-cw fg-upd fg-upd-finish" aria-labelledby="fg-upd-finish-title">
        <div class="container">
            <div class="fg-upd-finish__head">
                <p class="eyebrow"><?php esc_html_e('The finish', 'fenster'); ?></p>
                <h2 id="fg-upd-finish-title"><?php esc_html_e('Thirteen finishes. This is all of them.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Bonded to the profile at the factory rather than painted on, so the colour lasts as long as the door does. Most carry a woodgrain you can feel; a few are smooth. Inside is white as standard, or the same colour on both faces if you would rather see it from the sofa.', 'fenster'); ?></p>
            </div>

            <ul class="fg-upd-chart">
                <?php foreach ($renders as $render) : ?>
                    <?php if (empty($render['file']) || empty($render['colour'])) { continue; } ?>
                    <li class="fg-upd-chart__item">
                        <img src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/images/products/upvc-doors/renders/' . $render['file'])); ?>" alt="<?php printf(esc_attr__('uPVC residential door in %s', 'fenster'), esc_attr((string) $render['colour'])); ?>" width="640" height="1600" loading="lazy" decoding="async">
                        <span class="fg-upd-chart__name"><?php echo esc_html((string) $render['colour']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </section>
<?php endif; ?>

<?php /* 4. THE REST OF THE DECISIONS. Three now, not six: colour has its own
         section above, and privacy glass belongs with the survey detail below
         where the decision actually gets made. */ ?>
<section class="fg-cw fg-upd fg-upd-ways" aria-labelledby="fg-upd-ways-title">
    <div class="container">
        <div class="fg-upd-ways__head">
            <p class="eyebrow"><?php esc_html_e('What else you choose', 'fenster'); ?></p>
            <h2 id="fg-upd-ways-title"><?php esc_html_e('Everything you can see is a decision.', 'fenster'); ?></h2>
        </div>

        <div class="fg-upd-ways__grid">
            <?php
            $ways = [
                [
                    'label' => __('The panel', 'fenster'),
                    'copy' => __('Two faces, flat or shiplap, and you say how much of the door they cover. A quarter, a half, three quarters, all of it like the one above, or glass top to bottom. You say where it stops and it is drawn to that.', 'fenster'),
                    'image' => 'upvc-door-anthracite-solid-shiplap.webp',
                    'alt' => __('Anthracite uPVC door with a full shiplap panel and no glazing, on yellow brick', 'fenster'),
                ],
                [
                    'label' => __('Bars and lead', 'fenster'),
                    'copy' => __('Georgian bars set inside the unit, astragal bars applied to the face so they throw a real shadow, or leaded work in squares or diamonds. On an older house it is what ties the door to the windows either side of it.', 'fenster'),
                    'image' => 'upvc-detail-rosewood-woodgrain-bars.webp',
                    'alt' => __('Close detail of a rosewood woodgrain uPVC door with bars across the glass', 'fenster'),
                ],
                [
                    'label' => __('The fittings', 'fenster'),
                    'copy' => __('A letterplate, a knocker, numerals, a spyhole: all chosen with the door. A cat flap goes in too, though it is cut on site once the door is hung rather than arriving in it.', 'fenster'),
                    'image' => 'upvc-door-anthracite-cat-flap.webp',
                    'alt' => __('Anthracite uPVC door with a cat flap cut into the lower panel', 'fenster'),
                ],
            ];
            foreach ($ways as $way) :
                ?>
                <article class="fg-upd-way">
                    <figure>
                        <img src="<?php echo esc_url(fenster_generated_url($curated . $way['image'])); ?>" alt="<?php echo esc_attr($way['alt']); ?>" width="1280" height="1600" loading="lazy" decoding="async">
                    </figure>
                    <h3><?php echo esc_html($way['label']); ?></h3>
                    <p><?php echo esc_html($way['copy']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <?php
        /* THE COUNT ONLY MULTIPLIES THINGS THAT ARE ACTUALLY LISTS. It used to
           include "nine ways to split the panel", worked out from the owner's
           own examples — none, a quarter, a half, three quarters, full, against
           two faces. He corrected it on 2026-08-12: those were examples, not a
           range. Where the panel stops is drawn on the door, so it has no count
           and multiplying by an invented one made every figure on the line
           false.

           What is left is three genuine lists: the thirteen foils, the privacy
           glass range plus clear, and the door handle finishes. The panel is
           named after the figure as the thing that is NOT on it, which is a
           better line than the one it replaces. If any of the three lists
           change the number changes with them; never round it, and never add a
           dimension that cannot be counted. */
        $way_finishes = count($renders) ?: 13;
        $way_glass = count($glass) + 1;
        $way_handles = max(1, count($handles));
        $way_total = $way_finishes * $way_glass * $way_handles;
        ?>
        <div class="fg-upd-ways__sum">
            <p class="fg-upd-ways__figure"><?php echo esc_html(number_format($way_total)); ?></p>
            <div class="fg-upd-ways__sumtext">
                <p><?php
                    printf(
                        /* translators: 1: foil count, 2: privacy glass count, 3: handle finish count */
                        esc_html__('%1$d finishes against %2$d glasses and %3$d handle finishes, and that is before the panel, which is not a list of options at all: where it stops is drawn on the door. Nobody needs two thousand doors. The point is that yours is not one of six on a list.', 'fenster'),
                        (int) $way_finishes,
                        (int) $way_glass,
                        (int) $way_handles
                    );
                ?></p>
            </div>
        </div>
    </div>
</section>

<?php /* 5. WHAT IT IS MADE OF. The deferred tech banner: chambers, both
         U-values and the lead-free formulation, landing after the choosing
         rather than before the page has said what the product is. */ ?>
<?php if (! empty($tech_banner)) : ?>
    <?php get_template_part('template-parts/components/tech-banner', null, $tech_banner); ?>
<?php endif; ?>

<?php /* 6. WHAT GETS SETTLED AT SURVEY. The three practical decisions, with
         privacy glass merged in from the old decisions grid so it is stated
         once, in the place where somebody is deciding it. */ ?>
<section class="fg-cw fg-upd fg-upd-detail" aria-labelledby="fg-upd-detail-title">
    <div class="container">
        <div class="fg-upd-detail__head">
            <p class="eyebrow"><?php esc_html_e('Settled at survey', 'fenster'); ?></p>
            <h2 id="fg-upd-detail-title"><?php esc_html_e('The parts nobody thinks about until they live with them.', 'fenster'); ?></h2>
        </div>
        <?php /* THE DRAWINGS BELONG TO THE CARD THAT DESCRIBES THEM. They sat
                 in a strip under all three cards and read as an orphan, which is
                 what the owner called out. The threshold now takes a row of its
                 own with its four sections beside the copy, and the two
                 text-only decisions sit under it as a pair. It also gives the
                 section a shape rather than three columns and a loose band. */ ?>
        <div class="fg-upd-threshold-row">
            <div class="fg-upd-threshold-row__text">
                <h3><?php esc_html_e('The threshold you step over.', 'fenster'); ?></h3>
                <p><?php esc_html_e('The strip under the door decides whether you trip on it, whether a wheelchair or a pushchair gets through, and how much weather sits against it. Which one you get turns on your floor levels inside and out, so it is settled at survey, and we aim for the low aluminium wherever those levels allow it.', 'fenster'); ?></p>
                <p><?php esc_html_e('The seal itself is Liniar\'s patented bubble gasket, which is the part you feel in January rather than read on a data sheet: it squashes to the shape of the gap rather than relying on the door shutting in exactly the same place every time.', 'fenster'); ?></p>
            </div>
            <div class="fg-upd-thresholds">
                <?php
                $threshold_options = [
                    ['name' => __('Large uPVC', 'fenster'), 'file' => 'upvc-threshold-large-upvc.webp', 'note' => __('The full upstand', 'fenster')],
                    ['name' => __('Low uPVC', 'fenster'), 'file' => 'upvc-threshold-low-upvc.webp', 'note' => __('A slimmer section', 'fenster')],
                    ['name' => __('Low aluminium', 'fenster'), 'file' => 'upvc-threshold-low-aluminium.webp', 'note' => __('What we aim for', 'fenster')],
                    ['name' => __('Part M low', 'fenster'), 'file' => 'upvc-threshold-part-m-low.webp', 'note' => __('For wheelchair access', 'fenster')],
                ];
                foreach ($threshold_options as $threshold) :
                    ?>
                    <figure class="fg-upd-threshold">
                        <img src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/images/products/upvc-doors/thresholds/' . $threshold['file'])); ?>" alt="<?php printf(esc_attr__('Cutaway section of the %s door threshold', 'fenster'), esc_attr(strtolower((string) $threshold['name']))); ?>" width="960" height="900" loading="lazy" decoding="async">
                        <figcaption>
                            <strong><?php echo esc_html($threshold['name']); ?></strong>
                            <span><?php echo esc_html($threshold['note']); ?></span>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="fg-upd-detail__grid fg-upd-detail__grid--pair">
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The lock, and what comes as standard.', 'fenster'); ?></h3>
                <p><?php esc_html_e('A multi-point mechanism throws hooks or bolts into the frame at several points up the leaf, rather than one latch in the middle. That is standard on every door we fit.', 'fenster'); ?></p>
                <p><?php esc_html_e('The cylinder that comes with it is a one star. A three star cylinder is an upgrade and it is worth asking for: it is the part that resists snapping, and it is the cheapest thing on the whole door to improve.', 'fenster'); ?></p>
                <p class="fg-upd-detail__note"><?php esc_html_e('Liniar test the system to PAS 24, it is a Secured by Design product, and the profile carries a BSI Kitemark to BS EN 12608-1. Those are their figures for the profile, not a certificate for a particular door, so ask us what a specific doorset is built to.', 'fenster'); ?></p>
            </article>
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The glass, which is a privacy decision.', 'fenster'); ?></h3>
                <p><?php esc_html_e('Every style of privacy glass we fit can go in a door, graded one to five for how much it hides. A bathroom or a front door onto a street usually wants a five; a back door onto your own garden usually does not.', 'fenster'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Compare the privacy glass', 'fenster'); ?></a></p>
            </article>
        </div>

        <p class="fg-upd-thresholds__note"><?php esc_html_e('Sections drawn by Liniar, whose profile this is.', 'fenster'); ?></p>
    </div>
</section>
