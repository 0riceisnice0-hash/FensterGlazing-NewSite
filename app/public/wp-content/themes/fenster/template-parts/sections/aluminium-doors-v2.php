<?php
/**
 * Aluminium doors: the bespoke page.
 *
 * Rebuilt 2026-08-07. The route had been running the generic generated-page
 * template and read exactly like it: "Aluminium Doors" appeared as the H1 and
 * then twice more as an H2, the hub band was headed "More information on
 * Aluminium Doors", and the whole middle was `product_content` copy written
 * about no particular system ("Modern aluminium door systems use thermal breaks
 * and appropriate glazing").
 *
 * This replaces the MIDDLE of the generic template and nothing else, the same
 * shape flush casement uses. The hero, the key-specification strip, the
 * Thermlock banner and the whole tail from the specification choices down are
 * the shared ones every product page gets. What this stands in for is
 * `fg-product-why`, `fg-product-intel` and `fg-product-visuals`, gated off for
 * this slug in generated-page.php. It is NOT an early return like casement.
 *
 * Built on `.fg-cw`, the split grammar the heritage door and flush casement
 * pages already share, rather than a fourth layout of its own.
 *
 * THE FIGURES ARE DELIBERATELY NOT REPEATED HERE. 1.4 W/m²K double and 1.0
 * triple are already on the key-specification strip AND on the Thermlock banner,
 * both of which render immediately above this section. Stating them a third time
 * is the exact defect the casement page was corrected for on 2026-07-27, where
 * the same figures appeared three times inside 1.5 viewports. The banner names
 * the technology; the Thermlock section below explains it and shows it. Do not
 * "helpfully" add the numbers back.
 *
 * Facts and where each comes from:
 *   - Sheerline, and NOT "Sheerline Prestige". The windows, bifolds and sliders
 *     are named Prestige in product-hub-data.php; the residential door is not,
 *     so it is not named that here either.
 *   - Twelve standard powder-coated colours plus any RAL: `product_usps` says
 *     "Any RAL colour" and the aluminium colour grid further down the page
 *     renders twelve. Heritage is deliberately excluded from the any-RAL claim
 *     and this route is not; see the Colour Hub Rule in AI.md.
 *   - "Available to PAS 24" is the hub's wording and is the careful one. PAS 24
 *     belongs to a tested complete doorset, never to a component, which is the
 *     same distinction AI.md records for the Kenrick Excalibur.
 *   - Multi-point locking as standard is the doors hub's own owner-approved
 *     line, "Everything we hang is multi-point locked as standard".
 *
 * NOT claimed, and the reason: flush hook-locks. The doors hub FAQ says "the
 * aluminium doors add flush hook-locks on top", but every other reference in the
 * theme puts hook-locks on the lift-and-slide interlock
 * (`aluminium-sliding-doors`, lift-slide-detail.php, product-hub-data.php:187).
 * A hinged residential door is not that product. Do not carry that line over.
 *
 * InvisiHinge copy is the owner's, supplied 2026-08-07, with two deliberate
 * omissions he made in the same breath:
 *   - the option of a fourth hinge at stress points is NOT mentioned;
 *   - nothing is said about the hinge being easy to INSTALL, because the doors
 *     arrive with it already in. Adjustment after hanging is a different thing
 *     and is kept, because it is what lets a dropped door be trued up later.
 * The image is a supplier composite from a third-party installer's site, given
 * by the owner. It is a marketing graphic rather than our photography, so it is
 * captioned as a comparison and claims no installation of ours.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$base = '/wp-content/themes/fenster/assets/images/products/aluminium-doors/';
$colour_link = home_url('/colour-options/?material=aluminium');
$handles_link = home_url('/handle-options/');
$flush_link = home_url('/aluminium-flush-windows/');

/* Three cards rather than loose paragraphs, so the terms line up across the row
   whatever length the copy runs to. Same component the flush page uses for its
   performance and security lists. */
$security = [
    [
        'name' => __('Multi-point locking as standard', 'fenster'),
        'copy' => __('One turn of the key throws bolts at several points down the leaf, so the door is held into its seals along its full height rather than at the lock alone. That is standard on every door we hang, not an upgrade you have to ask for.', 'fenster'),
    ],
    [
        'name' => __('Glass that stays in one piece', 'fenster'),
        'copy' => __('Laminated glass carries a bonded interlayer, so it holds together instead of breaking through. It is the first thing we would suggest for a glazed side screen at ground level, or any panel within reach of the handle.', 'fenster'),
    ],
    [
        'name' => __('Available to PAS 24', 'fenster'),
        'copy' => __('The standard applies to the doorset as a whole, the leaf, the frame, the glass and the locking tested together, so it is specified from the start rather than added afterwards. Tell us at survey if your build has to meet it.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-alu-door">

    <?php /* ---------- What it is, and why anyone picks one ------------------
             The page opens on the reason this door gets chosen, which is nearly
             always that something else on the house is already aluminium. The
             generic copy this replaces opened with "Aluminium doors create
             strong, slim and highly configurable entrances for modern homes and
             extensions", which is four adjectives and no reason. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-alud-fit-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Where it fits', 'fenster'); ?></p>
                <h2 id="fg-alud-fit-title"><?php esc_html_e('The door that matches the windows.', 'fenster'); ?></h2>
                <p><?php esc_html_e('An aluminium front or back door is usually chosen because something else on the house is already aluminium. It comes off the same Sheerline frames and the same powder coating as our aluminium windows and sliders, so a door sitting in a run of them reads as one set rather than as two separate decisions made a year apart.', 'fenster'); ?></p>
                <p><?php esc_html_e('The frame is thin for the strength it holds, which is what lets a door carry a tall glazed panel, or sit between windows without the surround thickening up to cope. French doors with a flush aluminium window either side, all in one black, reads as a single opening rather than as three products that happen to be near each other.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Twelve standard powder-coated colours, and any RAL beyond them', 'fenster'); ?></li>
                    <li><?php esc_html_e('A single leaf or French doors, with side screens and toplights where the opening allows', 'fenster'); ?></li>
                    <li><?php esc_html_e('Blinds can be sealed inside the glass, as they are here', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo esc_url($colour_link); ?>"><?php esc_html_e('See the colours', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo esc_url($flush_link); ?>"><?php esc_html_e('Flush aluminium windows', 'fenster'); ?></a>
                </p>
            </div>
            <?php /* THE ONE PHOTOGRAPH ON THIS PAGE THAT IS OURS. Supplied by the
                     owner 2026-08-07 as "the only one i can find we actually
                     installed", and confirmed by him the same day as aluminium
                     French doors with flush aluminium windows either side.
                     Confirmation mattered: the frames read chunky and glossy in
                     the source and this route's standing defect is a hero that
                     reads as uPVC, so it was not used until he said what it was.

                     It sits here rather than in the hero, and that was decided by
                     measuring rather than by preference: the hero is a 3.2:1
                     letterbox, and a band that shallow across a tall symmetric
                     subject shows handles and blinds and no door. Forcing it in
                     would be the "never force tall imagery into a wide box" rule.
                     It is in this section because this section's heading is the
                     claim the photograph happens to prove.

                     Default `.fg-cw-media` here, no aspect modifier: the crop is
                     16:10 to match the box exactly, so nothing is cropped twice.
                     The source is 3024x4032 and the weeds, hose and garden bench
                     along the bottom are cropped out rather than published. */ ?>
            <figure class="fg-cw-media">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'alu-door-french-flag-install-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Black aluminium French doors with a flush aluminium window either side, blinds sealed inside the glass, under a brick arch in a red brick elevation', 'fenster'); ?>"
                    loading="lazy" width="1600" height="1000">
                <figcaption><?php esc_html_e('Our install', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php /* ---------- The hinge ------------------------------------------------
             Its own section on the owner's instruction, 2026-08-07. It earns one
             because it is the rare piece of door hardware a customer can see the
             point of immediately, and the supplied image argues it without any
             help: a conventional knuckle standing off the frame in the top
             circle, the concealed hinge set into the edge in the bottom one.
             Media-first so the picture leads, because here the picture is the
             argument. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-alud-hinge-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-alu-door-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'alu-door-invisihinge.webp')); ?>"
                    alt="<?php esc_attr_e('A conventional door hinge standing proud of the frame, beside the InvisiHinge set flush into the edge of an anthracite aluminium door', 'fenster'); ?>"
                    loading="lazy" width="500" height="377">
                <figcaption><?php esc_html_e('Standard hinge, and the InvisiHinge', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Hardware', 'fenster'); ?></p>
                <h2 id="fg-alud-hinge-title"><?php esc_html_e('The hinge you cannot see.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Hinges are the one part of a door nobody chooses and everybody looks at. Three knuckles standing off the frame break the line of the door every time you walk up to it, and on a flat aluminium leaf there is nothing else going on to distract from them.', 'fenster'); ?></p>
                <p><?php esc_html_e('The InvisiHinge sits inside the edge instead, so with the door shut there is nothing on the face of it at all. The restrictor that stops the door swinging into a wall is built into the hinge rather than bolted across the frame as a separate arm, so that disappears with it. It stays adjustable after the door is hung, which is what lets us bring a door back into line later without taking anything off the face.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Concealed in the edge, so nothing shows on a closed door', 'fenster'); ?></li>
                    <li><?php esc_html_e('The restrictor is part of the hinge, not a separate arm', 'fenster'); ?></li>
                    <li><?php esc_html_e('Adjustable after hanging, so the door can be trued up later', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo esc_url($handles_link); ?>"><?php esc_html_e('Handle finishes', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php /* ---------- Thermlock, on dark ------------------------------------
             Dark because the cutaway is a lit render on a black ground: on the
             page canvas it would sit as a black rectangle, and on dark it reads
             as lit product. Same reasoning the casement page gives for putting
             both of its technical chapters on dark.

             `.fg-cw h2` and `.fg-cw p` are (0,1,1) and beat a bare class, so the
             overrides for this section are qualified in the stylesheet rather
             than relying on source order. That trap is already recorded against
             the flush security band; this is the second consumer. */ ?>
    <section class="fg-alu-door-dark" aria-labelledby="fg-alud-warm-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Thermlock', 'fenster'); ?></p>
                <h2 id="fg-alud-warm-title"><?php esc_html_e('Where the cold stops.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Aluminium conducts heat, and that is the one honest argument against it. What decides whether an aluminium door is warm is the break running up the middle of the frame, the part that stops the outside face passing the cold straight through to the inside one.', 'fenster'); ?></p>
                <p><?php esc_html_e('Most systems bridge that gap with a polyamide strip. Sheerline designed a multi-chamber core instead, and it goes into every Sheerline frame we fit rather than sitting on an upgrade list. The cutaway is what the figures at the top of this page are measuring: blue is the weather, orange is your hallway, and the band between them is the part doing the work.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A multi-chamber core in place of a polyamide strip', 'fenster'); ?></li>
                    <li><?php esc_html_e('The same core as our aluminium windows and sliders', 'fenster'); ?></li>
                    <li><?php esc_html_e('Standard on every Sheerline frame we fit', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-media fg-alu-door-media--tech">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'alu-door-thermlock-cutaway.webp')); ?>"
                    alt="<?php esc_attr_e('Thermal cutaway of a Sheerline aluminium frame and sealed unit, graded from blue at the outer face to orange at the room face', 'fenster'); ?>"
                    loading="lazy" width="900" height="890">
                <figcaption><?php esc_html_e('Thermlock, in section', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php /* ---------- Security ---------------------------------------------
             A card band rather than a fifth split, so the page changes shape
             once in the middle instead of running five photographs down one
             rhythm. STYLE.md: no two adjacent sections repeat the same layout. */ ?>
    <section class="fg-alu-door-band" aria-labelledby="fg-alud-sec-title">
        <div class="container">
            <div class="fg-alu-door-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2 id="fg-alud-sec-title"><?php esc_html_e('Held at several points, not just at the lock.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('An aluminium leaf is a stiff leaf. It does not flex under pressure, which gives the locking something solid to pull against, and it is the specification around that which is worth talking about.', 'fenster'); ?></p>
            </div>
            <dl class="fg-alu-door-list">
                <?php foreach ($security as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <?php /* ---------- The threshold ------------------------------------------
             Kept because it is a real decision with a real trade-off, and the
             one part of a door somebody feels every single day. The hub already
             carries "Low threshold option" as a badge, so the page should say
             what the option costs you rather than just advertising it. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-alud-thresh-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-alu-door-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'alu-door-low-threshold.webp')); ?>"
                    alt="<?php esc_attr_e('Low aluminium threshold under a sage green door, sitting almost flush with the paving slabs outside', 'fenster'); ?>"
                    loading="lazy" width="514" height="356">
                <figcaption><?php esc_html_e('A low threshold', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The threshold', 'fenster'); ?></p>
                <h2 id="fg-alud-thresh-title"><?php esc_html_e('The step you stop noticing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The threshold is the part of a door you meet every day, usually carrying something. A low one takes the step down to a lip you can push a pushchair or a wheelchair over, and it is the detail that decides whether a back door gets used properly or gets avoided.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is not automatic, and we would rather say so before survey than after. A low threshold has less height in which to throw water back out, so on an exposed elevation, a door with nothing above it, or a path that falls back towards the house, the weathered detail is the right answer. We look at the levels, the drainage and how the door is actually used before choosing one.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Low threshold where the exposure and the drainage allow it', 'fenster'); ?></li>
                    <li><?php esc_html_e('Weathered detail for exposed and unsheltered openings', 'fenster'); ?></li>
                    <li><?php esc_html_e('Settled at survey against levels, drainage and access', 'fenster'); ?></li>
                </ul>
            </div>
        </div>
    </section>

</div>
