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
        'image' => fenster_generated_url('/wp-content/themes/fenster/assets/images/products/colours/liniar-door/' . $render['file']),
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
                <h2 id="fg-upd-open-title"><?php esc_html_e('No two of ours leave the factory the same.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A uPVC door is made to the hole in your wall, not picked off a shelf and packed out to fit. The leaf, the frame, the threshold and the glass are all specified for the opening you have, which is why a Victorian back door and a new-build side entrance come off the same system and look nothing like each other.', 'fenster'); ?></p>
                <p><?php esc_html_e('What changes is everything you can see. One leaf or a pair. Glazed over a flat panel or over shiplap. Any of sixteen finishes outside. Clear glass, obscure glass, or leaded to match what is already in the house. Then the handle, the letterplate and the lock on top of that.', 'fenster'); ?></p>
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

<?php /* THE RANDOMISER. Owner's idea, 2026-08-12, and the page's one interactive
         feature. It is deliberately NOT a configurator: it does not price, it
         does not save, and it hands over to WindowCAD the moment somebody wants
         a number, which is the standing rule after two home-built configurators
         were removed on sight.

         WHAT IT MAY AND MAY NOT DO. The door image changes because a real render
         exists for every finish in it. The handle and the glass are shown as
         their own product photographs beside the door rather than composited
         onto it, because we do not hold renders of this door wearing each of
         them, and drawing them on would be inventing a product view. The copy
         says which is which so the panel cannot be misread. When WindowCAD
         supply per-style renders, `upvc_door_renders` grows a `style` key and
         this section gains a dimension without changing shape. */ ?>
<section class="fg-cw fg-upd fg-upd-shuffle" aria-labelledby="fg-upd-shuffle-title" data-fg-door-randomiser data-door-payload="<?php echo esc_attr(wp_json_encode($randomiser_payload)); ?>">
    <div class="container">
        <div class="fg-upd-shuffle__head">
            <p class="eyebrow"><?php esc_html_e('One door, endlessly', 'fenster'); ?></p>
            <h2 id="fg-upd-shuffle-title"><?php esc_html_e('Every one of these is a door we can make.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Press the button and it specifies itself: a finish, a glass and a handle, put together the way a real order is. Nothing here is a mock-up. When you find one you like, the designer will price that exact door.', 'fenster'); ?></p>
        </div>

        <div class="fg-upd-shuffle__stage">
            <figure class="fg-upd-door">
                <?php $first = $randomiser[0] ?? null; ?>
                <img data-door-image src="<?php echo esc_url($first['image'] ?? ''); ?>" alt="<?php esc_attr_e('uPVC residential door shown in the selected finish', 'fenster'); ?>" width="1300" height="867" loading="lazy" decoding="async">
                <figcaption data-door-caption><?php esc_html_e('The render shows the finish. The handle and glass beside it are the ones chosen.', 'fenster'); ?></figcaption>
            </figure>

            <div class="fg-upd-spec">
                <p class="fg-upd-spec__label"><?php esc_html_e('This one', 'fenster'); ?></p>
                <dl class="fg-upd-spec__list">
                    <div class="fg-upd-spec__row">
                        <dt><?php esc_html_e('Finish', 'fenster'); ?></dt>
                        <dd>
                            <span class="fg-upd-chip" data-door-colour-chip aria-hidden="true"></span>
                            <span data-door-colour><?php echo esc_html($first['colour'] ?? ''); ?></span>
                            <em data-door-colour-note><?php echo esc_html($first['finish'] ?? ''); ?></em>
                        </dd>
                    </div>
                    <div class="fg-upd-spec__row">
                        <dt><?php esc_html_e('Glass', 'fenster'); ?></dt>
                        <dd>
                            <span class="fg-upd-chip fg-upd-chip--glass" data-door-glass-chip aria-hidden="true"></span>
                            <span data-door-glass></span>
                            <em data-door-glass-note></em>
                        </dd>
                    </div>
                    <div class="fg-upd-spec__row">
                        <dt><?php esc_html_e('Handle', 'fenster'); ?></dt>
                        <dd>
                            <img class="fg-upd-spec__handle" data-door-handle-image src="" alt="" width="120" height="120" loading="lazy" decoding="async">
                            <span data-door-handle></span>
                        </dd>
                    </div>
                </dl>
                <div class="fg-upd-spec__actions">
                    <button type="button" class="button" data-door-shuffle><?php esc_html_e('Shuffle it', 'fenster'); ?></button>
                    <?php if ($quote_url !== '') : ?>
                        <a class="button button--steel" href="#fenster-product-quote"><?php esc_html_e('Price a door like it', 'fenster'); ?></a>
                    <?php endif; ?>
                </div>
                <p class="fg-upd-spec__foot"><?php esc_html_e('Sixteen finishes are available, thirteen of them rendered here. Every obscure glass we fit can go in a door.', 'fenster'); ?> <a href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('See the full colour range', 'fenster'); ?></a>.</p>
                <p class="fg-upd-spec__live" data-door-live role="status" aria-live="polite"></p>
            </div>
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
            </article>
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The lock, and what comes as standard.', 'fenster'); ?></h3>
                <p><?php esc_html_e('A multi-point mechanism throws hooks or bolts into the frame at several points up the leaf, rather than one latch in the middle. That is standard on every door we fit.', 'fenster'); ?></p>
                <p><?php esc_html_e('The cylinder that comes with it is a one star. A three star cylinder is an upgrade and it is worth asking for: it is the part that resists snapping, and it is the cheapest thing on the whole door to improve.', 'fenster'); ?></p>
            </article>
            <article class="fg-upd-detail__card">
                <h3><?php esc_html_e('The glass, which is a privacy decision.', 'fenster'); ?></h3>
                <p><?php esc_html_e('Every obscure glass we fit can go in a door, graded one to five for how much they hide. A bathroom or a front door onto a street usually wants a five; a back door onto your own garden usually does not.', 'fenster'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Compare the obscure glass range', 'fenster'); ?></a></p>
            </article>
        </div>
    </div>
</section>
