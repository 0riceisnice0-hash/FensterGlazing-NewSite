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
 * WHAT THIS REPLACES. `fg-product-why`, `fg-product-intel` and
 * `fg-product-visuals`, which between them said "uPVC doors can include
 * multi-point locking", "threshold details can be reviewed" and "profiles help
 * reduce heat transfer". Every one of those sentences would survive unchanged
 * on a competitor's site, which is the test `TONEOFVOICE.md` sets and fails.
 *
 * WHAT IS KEPT AND WHY. The key-specification pulse, because this product has
 * real published figures. The specification-choices wrapper, because colour,
 * glass and handles are all genuine decisions here and the long-plate handle
 * grid lives inside it. The quote embed, because the uPVC Doors collection
 * prices this exact product. The order-process rail and the case-study strip,
 * because a new door is a normal installation and the Wolverton study claims
 * this route.
 *
 * OWNER-CONFIRMED, 2026-08-12, and none of it may be softened or widened:
 *
 *  - **We do not advertise the full infill panel**, the moulded 2000s front
 *    door slab. What we sell is a half-glazed door over a flat panel, or a
 *    shiplap panel. Do not add decorative infill panels to this page.
 *  - **Same colour range and the same theory as the uPVC windows**: 16 foils,
 *    the colour on the outside face, white or the same colour inside, and the
 *    inside foil costs more. Do not restate that as a free choice.
 *  - **The whole obscure glass range is available** in a door.
 *  - **1.0 W/m²K is the TRIPLE glazed figure.** Liniar publish 0.99 whole-door
 *    triple on the 70mm residential door and publish NO double glazed figure,
 *    so there is no second number and none may be borrowed from the windows.
 *  - **Security is a multi-point lock and a one star cylinder as standard, with
 *    a three star upgrade available.** The composite door's £5,000 break-in
 *    guarantee does NOT apply here and must never appear on this route.
 *  - **PAS 24 is deliberately not claimed.** Liniar publish PAS24 and Secured by
 *    Design for the system; that belongs to a tested complete doorset and we fit
 *    a one star cylinder as standard, so the page stays quiet on it. Same
 *    distinction already recorded for the Kenrick Excalibur.
 *  - **Letterplates, knockers, numerals and spyholes are offered; cylinder
 *    guards are not.** No models are confirmed, so none is named.
 *  - **Shaped doors are possible and very niche**, so the page mentions it once
 *    and does not build a section on it.
 *  - The ten year insurance-backed guarantee and FENSA both apply.
 *
 * ON NOT SELLING AGAINST OURSELVES. The owner's own summary of why a customer
 * picks uPVC over composite is that it is cheaper, and stable doors and French
 * pairs are both available in composite too. `TONEOFVOICE.md` forbids
 * positioning one of our own products as the budget option, in those words and
 * in the softer ones, so the page argues what this door DOES: it is made to the
 * opening, in the full foil range, with the glass and hardware chosen on top.
 * Price belongs on the quote tool, where it comes with a real figure. The owner
 * also asked that composite barely be mentioned, so it is named once, in the
 * FAQ, where somebody is actually asking.
 */

$args = wp_parse_args(
    $args ?? [],
    [
        'brand' => [],
        'quote_url' => '',
        'renders' => [],
        'colours' => [],
        'handles' => [],
        'glass' => [],
        'photos' => [],
    ]
);

$renders = is_array($args['renders']) ? $args['renders'] : [];
$handles = is_array($args['handles']) ? $args['handles'] : [];
$glass = is_array($args['glass']) ? $args['glass'] : [];
$photos = is_array($args['photos']) ? $args['photos'] : [];
$quote_url = (string) $args['quote_url'];

$photo = static function (string $key) use ($photos): array {
    $found = $photos[$key] ?? null;
    return is_array($found) ? $found : [];
};

/* MARKED PLACEHOLDERS, per the rule in AI.md: a photograph we have not taken
   is marked as one, never left as a gap and never filled with a supplier render
   or a shot of a neighbouring product. Each one carries the brief for the
   picture that belongs there, so the panel doubles as the shot list — the next
   person with a phone on a job knows exactly what is wanted. Delete the call
   and drop the real figure in; the caption already says what it should show.
   `.fg-lv-placeholder` is the louvre page's component, kept in the stylesheet
   for the next page that needed it. */
$placeholder = static function (string $brief, string $ratio = '4 / 3'): void {
    ?>
    <div class="fg-lv-placeholder fg-upd-placeholder" style="--fg-lv-ratio: <?php echo esc_attr($ratio); ?>">
        <span><?php esc_html_e('Photograph to follow', 'fenster'); ?></span>
        <small><?php echo esc_html($brief); ?></small>
    </div>
    <?php
};

/* The randomiser payload. Everything the controller shuffles is a real asset:
   a render per finish, a photograph per handle, a texture or a CSS surface per
   glass. Nothing is tinted, generated or implied. */
$randomiser = [];
foreach ($renders as $render) {
    if (empty($render['file']) || empty($render['colour'])) {
        continue;
    }
    $randomiser[] = [
        'colour' => (string) $render['colour'],
        'finish' => (string) ($render['finish'] ?? ''),
        'hex' => (string) ($render['hex'] ?? '#ffffff'),
        'image' => fenster_generated_url('/wp-content/themes/fenster/assets/images/products/upvc-doors/renders/' . $render['file']),
    ];
}

$randomiser_payload = [
    'finishes' => $randomiser,
    'handles' => array_values(array_map(static function (array $h): array {
        return [
            'name' => (string) ($h['name'] ?? ''),
            'image' => isset($h['image']) ? fenster_generated_url((string) $h['image']) : '',
            'hex' => (string) ($h['hex'] ?? '#111313'),
        ];
    }, $handles)),
    'glass' => array_values(array_map(static function (array $g): array {
        return [
            'name' => (string) ($g['name'] ?? ''),
            'privacy' => (int) ($g['privacy'] ?? 0),
            'image' => ! empty($g['image']) ? fenster_generated_url((string) $g['image']) : '',
            'texture' => (string) ($g['texture'] ?? ''),
        ];
    }, $glass)),
];
?>

<section class="fg-cw fg-upd fg-upd-open" aria-labelledby="fg-upd-open-title">
    <div class="container">
        <div class="fg-cw-split">
            <div class="fg-cw-split__text">
                <p class="eyebrow"><?php esc_html_e('Made to the opening', 'fenster'); ?></p>
                <?php /* THE OLD HEADING CLAIMED "no two of ours leave the factory the
                         same", and the owner pulled it: a glazed white or grey back door
                         is one of the commonest things we fit. Saying the awkward thing
                         first is the house voice and it is also just true — the range is
                         the point, not the rarity. */ ?>
                <h2 id="fg-upd-open-title"><?php esc_html_e('Most of ours are a white back door. Yours does not have to be.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A uPVC door is made to the opening you have, not picked off a shelf and packed out to fit. That is true of the plain white one most people order, and it is what makes everything else possible.', 'fenster'); ?></p>
                <ul class="fg-flush-list fg-upd-list">
                    <li><?php esc_html_e('Single leaf, a French pair, or a stable door split across the middle', 'fenster'); ?></li>
                    <li><?php esc_html_e('Half glazed over a flat panel, or over a shiplap panel', 'fenster'); ?></li>
                    <li><?php esc_html_e('Sixteen foil finishes, white or the same colour inside', 'fenster'); ?></li>
                    <li><?php esc_html_e('Shaped heads are possible, though they are rare', 'fenster'); ?></li>
                </ul>
            </div>
            <?php if (! empty($photo('opening')['src'])) : ?>
                <figure class="fg-cw-media fg-upd-media--4x3">
                    <img src="<?php echo esc_url($photo('opening')['src']); ?>" alt="<?php echo esc_attr($photo('opening')['alt'] ?? ''); ?>" loading="lazy" decoding="async" width="1200" height="1600">
                    <figcaption><?php esc_html_e('Our install. A back door glazed over a shiplap panel, with black furniture against a white frame.', 'fenster'); ?></figcaption>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php /* THE RANDOMISER IS GONE, 2026-08-12, and this replaces it. It was the
         owner's idea and he took it back the same day: shuffling a render was a
         gimmick standing where the argument should be, and the moment it grew a
         colour picker it started competing with WindowCAD, which configures AND
         prices. What a customer actually wants to know is what they get to
         choose, so the page now says exactly that, one decision per tile, in
         our own photographs.

         THE ARITHMETIC IS REAL and it is computed from the data on this page
         rather than typed in: 16 foils, 3 panel styles, the obscure glass range
         plus clear, and the door handle finishes. If any of those lists change,
         the number changes with them. Never round it up to something rhetorical
         — the whole force of it is that it is a count, not a boast. */ ?>
<section class="fg-cw fg-upd fg-upd-ways" aria-labelledby="fg-upd-ways-title">
    <div class="container">
        <div class="fg-upd-ways__head">
            <p class="eyebrow"><?php esc_html_e('What you choose', 'fenster'); ?></p>
            <h2 id="fg-upd-ways-title"><?php esc_html_e('Everything you can see is a decision.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Six of them, taken in about ten minutes at the survey, and none of them changes how long the job takes. This is the part where a door stops being a door and starts being yours.', 'fenster'); ?></p>
        </div>

        <div class="fg-upd-ways__grid">
            <?php
            $ways = [
                [
                    'span' => 'wide',
                    'label' => __('The colour', 'fenster'),
                    'copy' => __('Sixteen foils, bonded to the profile at the factory rather than painted on, so there is nothing to repaint and nothing to flake. Greys, blacks, a cream, three woodgrains and a green that suits an old house.', 'fenster'),
                    'image' => 'upvc-door-cream-glazed-stone.webp',
                    'alt' => __('Cream uPVC door with two glazed panes in a white stone wall', 'fenster'),
                ],
                [
                    'span' => 'wide',
                    'label' => __('The panel', 'fenster'),
                    'copy' => __('Half glazed over a flat panel, half glazed over shiplap, or glazed top to bottom for light. The bottom half is the part that takes the knocks, the dog and the hoover, so it is worth a moment.', 'fenster'),
                    'image' => 'upvc-door-anthracite-solid-shiplap.webp',
                    'alt' => __('Anthracite uPVC door with a solid shiplap panel on yellow brick', 'fenster'),
                ],
                [
                    'span' => 'third',
                    'label' => __('The glass', 'fenster'),
                    'copy' => __('Every obscure glass we fit goes in a door, graded one to five for how much they hide. Clear is the right answer onto your own garden and the wrong one onto a street.', 'fenster'),
                    'image' => 'upvc-door-white-obscure-glass.webp',
                    'alt' => __('White uPVC door with obscure glass in the upper panel', 'fenster'),
                ],
                [
                    'span' => 'third',
                    'label' => __('Bars, or leaded', 'fenster'),
                    'copy' => __('Georgian bars across the glass, or leaded work matched to what the house already has. It is what stops a new door looking new beside old windows.', 'fenster'),
                    'image' => 'upvc-detail-rosewood-woodgrain-bars.webp',
                    'alt' => __('Close detail of a rosewood woodgrain uPVC door with Georgian bars in the glass', 'fenster'),
                ],
                [
                    'span' => 'third',
                    'label' => __('The inside face', 'fenster'),
                    'copy' => __('White inside as standard, whatever the outside is doing. The same colour on both faces is an extra, and it is worth seeing the two together before you decide.', 'fenster'),
                    'image' => 'upvc-door-white-inside-face.webp',
                    'alt' => __('A uPVC back door seen from inside, showing the white internal face', 'fenster'),
                ],
                [
                    'span' => 'third',
                    'label' => __('What goes through it', 'fenster'),
                    'copy' => __('A cat flap through the panel, a letterplate, a knocker, numerals, a spyhole. Specified with the door rather than cut into it afterwards.', 'fenster'),
                    'image' => 'upvc-door-anthracite-cat-flap.webp',
                    'alt' => __('Anthracite uPVC door with a cat flap fitted through the lower panel', 'fenster'),
                ],
            ];
            foreach ($ways as $way) :
                ?>
                <article class="fg-upd-way fg-upd-way--<?php echo esc_attr($way['span']); ?>">
                    <figure>
                        <img src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/images/products/upvc-doors/curated/' . $way['image'])); ?>" alt="<?php echo esc_attr($way['alt']); ?>" width="1280" height="1600" loading="lazy" decoding="async">
                    </figure>
                    <h3><?php echo esc_html($way['label']); ?></h3>
                    <p><?php echo esc_html($way['copy']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <?php
        $way_finishes = 16;
        $way_panels = 3;
        $way_glass = count($glass) + 1;
        $way_handles = max(1, count($handles));
        $way_total = $way_finishes * $way_panels * $way_glass * $way_handles;
        ?>
        <div class="fg-upd-ways__sum">
            <p class="fg-upd-ways__figure"><?php echo esc_html(number_format($way_total)); ?></p>
            <div class="fg-upd-ways__sumtext">
                <p><?php
                    printf(
                        /* translators: 1: foil count, 2: panel style count, 3: glass count, 4: handle finish count */
                        esc_html__('That is %1$d finishes against %2$d panel styles, %3$d glasses and %4$d handle finishes, and it is the count before anybody adds a bar, a letterplate or a leaded pattern. Nobody needs eight thousand doors. The point is that yours is not one of six on a list.', 'fenster'),
                        (int) $way_finishes,
                        (int) $way_panels,
                        (int) $way_glass,
                        (int) $way_handles
                    );
                ?></p>
                <?php if ($quote_url !== '') : ?>
                    <a class="button" href="#fenster-product-quote"><?php esc_html_e('Build yours and see the price', 'fenster'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php /* A render tells you the colour; it does not tell you what the colour
         does against your own brick. This band is where that gets answered, and
         it is entirely placeholders on purpose: we own no photograph of a
         finished door in context that is not already used elsewhere on the
         page. Four shots, one per kind of elevation, and the briefs are written
         so anyone on a job can take them. */ ?>
<section class="fg-cw fg-upd fg-upd-context" aria-labelledby="fg-upd-context-title">
    <div class="container">
        <div class="fg-upd-context__head">
            <p class="eyebrow"><?php esc_html_e('On a real house', 'fenster'); ?></p>
            <h2 id="fg-upd-context-title"><?php esc_html_e('A colour is a different thing on brick than it is on a screen.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Anthracite reads almost black against red brick and blue-grey against render. Chartwell green looks period on a cottage and odd on a new build. These are the four we are photographing next.', 'fenster'); ?></p>
        </div>
        <div class="fg-upd-context__grid">
            <?php
            $context_shots = [
                ['label' => __('Anthracite on red brick', 'fenster'), 'brief' => __('A back door straight on, mid-morning, no cars in shot. The one everybody orders.', 'fenster')],
                ['label' => __('Chartwell green on stone or render', 'fenster'), 'brief' => __('A cottage or older elevation. The colour needs an old wall behind it to make its case.', 'fenster')],
                ['label' => __('A woodgrain front door', 'fenster'), 'brief' => __('Irish oak or golden oak, close enough that the grain in the foil is visible.', 'fenster')],
                ['label' => __('A white door doing its job', 'fenster'), 'brief' => __('The commonest door we fit and the one we photograph least. Side or utility entrance, clean and ordinary.', 'fenster')],
                ['label' => __('The door furniture', 'fenster'), 'brief' => __('Letterplate, knocker and numerals on a finished door, one arm\'s length away.', 'fenster')],
                ['label' => __('White on the inside', 'fenster'), 'brief' => __('A coloured door photographed from indoors, showing the white inside face. It is the thing people are most surprised by.', 'fenster')],
            ];
            foreach ($context_shots as $shot) :
                ?>
                <figure class="fg-upd-context__cell">
                    <?php $placeholder($shot['brief'], '4 / 3'); ?>
                    <figcaption><?php echo esc_html($shot['label']); ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="fg-cw fg-upd fg-upd-config" aria-labelledby="fg-upd-config-title">
    <div class="container">
        <div class="fg-upd-config__head">
            <p class="eyebrow"><?php esc_html_e('How it opens', 'fenster'); ?></p>
            <h2 id="fg-upd-config-title"><?php esc_html_e('Three ways the same system opens.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Which one suits you is decided by the opening and how the room gets used, not by the price of it.', 'fenster'); ?></p>
        </div>
        <div class="fg-upd-config__grid">
            <?php
            $configs = [
                [
                    'title' => __('A single leaf', 'fenster'),
                    'copy' => __('The everyday one. Front, back, side or utility, hung to open whichever way the room needs and hinged on the side that keeps the path clear.', 'fenster'),
                    'photo' => $photo('single'),
                    'link' => '',
                    'link_label' => '',
                ],
                [
                    'title' => __('A French pair', 'fenster'),
                    'copy' => __('Two leaves opening from the centre, for a wider opening onto a garden or patio. One leaf is used day to day and the second unbolts when you want the whole opening.', 'fenster'),
                    'photo' => $photo('french'),
                    'link' => home_url('/french-doors/'),
                    'link_label' => __('More on French doors', 'fenster'),
                ],
                [
                    'title' => __('A stable door', 'fenster'),
                    'copy' => __('Split across the middle so the top half opens on its own: air in, the dog and the toddler still in. Available glazed or panelled in each half.', 'fenster'),
                    'photo' => $photo('stable'),
                    'link' => '',
                    'link_label' => '',
                ],
            ];
            foreach ($configs as $config) :
                if (empty($config['photo']['src'])) {
                    continue;
                }
                ?>
                <article class="fg-upd-config__card">
                    <figure>
                        <img src="<?php echo esc_url($config['photo']['src']); ?>" alt="<?php echo esc_attr($config['photo']['alt'] ?? ''); ?>" loading="lazy" decoding="async">
                    </figure>
                    <h3><?php echo esc_html($config['title']); ?></h3>
                    <p><?php echo esc_html($config['copy']); ?></p>
                    <?php if ($config['link'] !== '') : ?>
                        <a class="fg-upd-config__link" href="<?php echo esc_url($config['link']); ?>"><?php echo esc_html($config['link_label']); ?></a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>

            <?php
            /* The three above are real installs. These three are the shots that
               would finish the section, and each is a thing the copy claims and
               the photography cannot yet show. */
            $config_wanted = [
                ['title' => __('The top half open', 'fenster'), 'brief' => __('A stable door with the top leaf open and the bottom closed, from outside, ideally with somebody leaning on it.', 'fenster')],
                ['title' => __('A pair, fully open', 'fenster'), 'brief' => __('French doors thrown right back onto a garden in summer, straight on, both leaves flat against the wall.', 'fenster')],
                ['title' => __('A shaped head', 'fenster'), 'brief' => __('An arched or angled head door in its opening. Rare, and we currently illustrate it with nothing at all.', 'fenster')],
            ];
            foreach ($config_wanted as $wanted) :
                ?>
                <article class="fg-upd-config__card fg-upd-config__card--wanted">
                    <?php $placeholder($wanted['brief'], '4 / 5'); ?>
                    <h3><?php echo esc_html($wanted['title']); ?></h3>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php /* THE THREE THINGS THAT GET DECIDED AT SURVEY, and the one section on the
         page where the awkward thing is said first, per TONEOFVOICE.md. The
         cylinder is one star as standard with a three star upgrade, and saying
         so is worth more than a security adjective. Note what is NOT here: no
         PAS 24 claim, no Secured by Design badge, and no £5,000 guarantee,
         which belongs to the composite door and to nothing else. */ ?>
<section class="fg-cw fg-upd fg-upd-detail" aria-labelledby="fg-upd-detail-title">
    <div class="container">
        <div class="fg-upd-detail__head">
            <p class="eyebrow"><?php esc_html_e('The three that matter', 'fenster'); ?></p>
            <h2 id="fg-upd-detail-title"><?php esc_html_e('The parts nobody thinks about until they live with them.', 'fenster'); ?></h2>
        </div>
        <div class="fg-upd-detail__grid">
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The threshold you step over.', 'fenster'); ?></h3>
                <p><?php esc_html_e('The strip under the door decides whether you trip on it, whether a wheelchair or a pushchair gets through, and how much weather sits against it. Liniar publish eight for this system, including a Part M low threshold for level access.', 'fenster'); ?></p>
                <p><?php esc_html_e('Which one is right depends on your floor levels inside and out, so it is settled at survey rather than guessed at from a drawing.', 'fenster'); ?></p>
                <?php $placeholder(__('A Part M low threshold at the sill, camera down at ankle height, showing how little there is to step over.', 'fenster'), '16 / 10'); ?>
            </article>
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The lock, and what comes as standard.', 'fenster'); ?></h3>
                <p><?php esc_html_e('A multi-point mechanism throws hooks or bolts into the frame at several points up the leaf, rather than one latch in the middle. That is standard on every door we fit.', 'fenster'); ?></p>
                <p><?php esc_html_e('The cylinder that comes with it is a one star. A three star cylinder is an upgrade and it is worth asking for: it is the part that resists snapping, and it is the cheapest thing on the whole door to improve.', 'fenster'); ?></p>
                <?php $placeholder(__('The open leaf edge, showing the hooks and rollers of the multi-point up the length of it. Close, sharp, plain background.', 'fenster'), '16 / 10'); ?>
            </article>
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The glass, which is a privacy decision.', 'fenster'); ?></h3>
                <p><?php esc_html_e('Every obscure glass we fit can go in a door, graded one to five for how much they hide. A bathroom or a front door onto a street usually wants a five; a back door onto your own garden usually does not.', 'fenster'); ?></p>
                <?php $placeholder(__('Obscure glass in a door panel, shot from outside at dusk with the hall light on, so it reads as privacy rather than as texture.', 'fenster'), '16 / 10'); ?>
                <p><a href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Compare the obscure glass range', 'fenster'); ?></a></p>
            </article>
        </div>
    </div>
</section>
