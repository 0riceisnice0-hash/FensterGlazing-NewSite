<?php
/**
 * Slide and fold doors: the bespoke page.
 *
 * Rebuilt 2026-08-18. The route had been running the generic generated-page
 * template on scrape-era copy written before anybody had the real
 * specification. It opened "Slide and fold doors give a flexible alternative to
 * conventional bifolds", carried five benefit cards that named no figure at all
 * ("Smooth, simple operation", "Space-efficient opening"), and its
 * key-specification strip carried "Design: Versatile", which is one of the
 * adjective tiles FULL-SITE-AUDIT-2026-08-13.md flags by name.
 *
 * This replaces the MIDDLE of the generic template and nothing else, the same
 * shape flush casement and aluminium doors use. It is NOT an early return like
 * casement. What it stands in for is `fg-product-why`, `fg-product-intel` and
 * `fg-product-visuals`, gated off for this slug in generated-page.php.
 *
 * Built on `.fg-cw`, the split grammar the heritage door, flush casement and
 * aluminium door pages already share, rather than a fifth layout of its own.
 *
 * ---------------------------------------------------------------------------
 * THE ONE RULE THIS PAGE IS WRITTEN AGAINST: DO NOT SELL IT BY ATTACKING
 * BIFOLD DOORS. Owner instruction, 2026-08-18.
 *
 * The supplier's own marketing is built end to end on the opposite: "doors that
 * do what bifolds don't", "bi-folding doors have never made sense in the UK",
 * "bi-folding doors compromise security by their very design". Not one word of
 * that may reach this page, and the reason is not politeness. WE SELL BIFOLD
 * DOORS. /aluminium-bifold-doors/ is a live route with its own case study at
 * Whitehouse, and TONEOFVOICE.md forbids positioning one of our own products as
 * the weaker choice on specification, in those words and the softer ones.
 *
 * So every section here states what this door DOES, and never what another one
 * does not. Bifolds appear once, in the closing section, as one of three routes
 * named beside each other with no ranking between them. If you are editing this
 * file and find yourself writing a sentence whose point is that a bifold is
 * worse, the sentence is wrong even when it is true.
 * ---------------------------------------------------------------------------
 *
 * THE SUPPLIER IS NOT NAMED, ANYWHERE. Owner instruction, 2026-08-18. Their
 * brand, their system names and their component brands are all off this page:
 * the manufacturer, the aluminium extruder, the uPVC profile house, the thermal
 * core and the lock brand. This is the Supplier Naming Rule in AI.md applied
 * exactly as it is applied to the louvre range: we sell this page around the
 * product, not around whose extrusion it is, and a customer who could go
 * straight to them is a customer we would lose. Figures are attributed to "the
 * manufacturer" where attribution is needed, the same wording /louvre-vents/
 * uses. THE NAMES ARE DELIBERATELY ABSENT FROM THIS COMMENT TOO, so that a
 * future grep of the theme for them returns nothing at all.
 *
 * Facts, and where each one comes from. All are the manufacturer's published
 * figures, read off their site on 2026-08-18:
 *   - Maximum panel width 1000mm, INCLUSIVE OF THE OUTER FRAME. Their own
 *     worked example is that a four panel system is 4000mm. The "inclusive of
 *     the outer frame" half matters: drop it and every span on this page is
 *     quietly wrong.
 *   - Maximum height 2400mm. Above that is possible, priced on application, and
 *     it can reduce the maximum panel width. That caveat is on the page because
 *     a customer planning a tall opening needs it.
 *   - WE FIT THE ALUMINIUM ONE ONLY, owner 2026-08-18. The manufacturer's uPVC
 *     figures (850mm panels, 2200mm high) are deliberately nowhere on this
 *     route. Do not add them back.
 *   - No limit on the number of panels.
 *   - All the weight of the sliding panels is carried on the BOTTOM track;
 *     nothing is top hung. The manufacturer's stated consequence is tolerance
 *     to lintel deflection and building settlement.
 *   - The panels run on wheels on that bottom track.
 *   - Closed, the panels interlock and engage a double weather seal.
 *   - Concealed hinges. The hinge only operates once the master door is open
 *     and the panel has been moved to the master door position.
 *   - Ten point lock. This one is NOT new: `product_usps` has said "10 point
 *     locking" for this route since launch, and the Leighton Buzzard case study
 *     states it in owner-approved copy.
 *   - A level internal threshold is achievable. With adequate drainage the
 *     external floor level can sit 10mm below the top of the bottom track.
 *   - No cill is required, provided an alternative drainage method is confirmed
 *     for building control.
 *   - Two master doors are possible on four panels or more, with an opening
 *     panel at either end.
 *   - Any RAL, in a matt powder coat or a textured brushed-sand finish. Their
 *     published standard colours are Anthracite Grey RAL 7016 and Signal White
 *     RAL 9003.
 *   - The film is OUR Milton Keynes showroom, owner-confirmed 2026-08-18, which
 *     is why the page can invite somebody to come and work one. Before that
 *     confirmation the caption claimed nothing.
 *
 * DELIBERATELY NOT USED, from the same source:
 *   - "A lifespan of more than 350 years" for the uPVC profile. It is absurd on
 *     its face and this project does not republish a figure it cannot stand
 *     behind.
 *   - "Bifold doors add up to 10% to a house's sale value."
 *   - A hint that this door may earn a home insurance discount. Nobody has
 *     confirmed that with an insurer and it is the kind of claim a customer
 *     could act on and be wrong.
 *   - Every superlative: market leading, legendary, unrivalled, obsession with
 *     excellence.
 *   - THE THERMAL BREAK, and the reason is not that it conflicts. This
 *     aluminium uses a polyamide thermal break, while /aluminium-doors/ sells
 *     the Sheerline core as "a multi-chamber Thermlock core, not a polyamide
 *     strip". That was raised with the owner on 2026-08-18 as a possible
 *     contradiction and he ruled it is not one: they are different products and
 *     it is product-specific information. So NEITHER page needs changing. It
 *     stays off this route because the page carries no thermal section at all,
 *     the U-value is already on the strip above, and a lone thermal sentence
 *     with nothing to attach to would be filler.
 *
 * NO U-VALUE APPEARS IN THIS FILE. 1.4 W/m²K is already on the
 * key-specification strip that renders directly above this section, and stating
 * it again inside the same viewport and a half is the exact defect the casement
 * page was corrected for on 2026-07-27.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$base = '/wp-content/themes/fenster/assets/images/products/slide-fold/';
$bifold_link = home_url('/aluminium-bifold-doors/');
$sliding_link = home_url('/aluminium-sliding-doors/');
$blinds_link = home_url('/integral-blinds/');
$study_link = home_url('/case-studies/flush-casement-and-slide-fold-doors-leighton-buzzard/');
$showroom_link = home_url('/contact/');

/* THE SPAN ARITHMETIC IS DERIVED, NOT TYPED, so the two figures cannot drift
   apart. The manufacturer publishes a maximum panel width and their own worked
   example of a four panel system; everything else on the row is that width
   multiplied out. If the panel width is ever corrected, every span here follows
   it. Do not hand-type a metre figure into the copy. */
$max_panel_mm = 1000;
$spans = [];
foreach ([3, 4, 5, 6] as $panels) {
    $spans[] = [
        'panels' => $panels,
        'span'   => number_format(($panels * $max_panel_mm) / 1000, 1) . 'm',
    ];
}

/* WE FIT THE ALUMINIUM ONE ONLY. Owner, 2026-08-18: "just ali slide and fold".
   The manufacturer also makes a uPVC version at 850mm panels and 2200mm high,
   and an earlier draft of this page carried both side by side. It came out on
   that instruction, and the same instruction corrected the Leighton Buzzard case
   study, which had described its door as uPVC since it was published. The
   photograph on that study settles it independently: slim frames and slim
   meeting stiles, which is not a uPVC section.

   So there are no uPVC figures anywhere on this route, and nothing here needs
   to say which material we do not do. Per the 2026-08-02 ruling the page states
   what is offered and stops.

   THE TWO STANDARD COLOURS ARE THE MANUFACTURER'S OWN STANDARDS and they are
   named because a customer choosing between "any RAL" and a stock colour needs
   to know there is a stock colour. Their published standards are Anthracite
   Grey RAL 7016 and Signal White RAL 9003.

   NO SWATCHES ARE DRAWN FOR THIS. We hold no photographed colour samples for
   this product, and the Swatch Provenance Rule in AI.md forbids painting a chip
   from a hex to fill the gap, which is the same call the composite colour hub
   made for the four colours it has no tile for. The colours are named in words
   until real samples exist. */
$colour_standards = [
    ['name' => __('Anthracite Grey', 'fenster'), 'ref' => __('RAL 7016', 'fenster')],
    ['name' => __('Signal White', 'fenster'), 'ref' => __('RAL 9003', 'fenster')],
];
?>

<div class="fg-cw fg-sf">

    <?php /* ---------- 1. How it actually opens -----------------------------
             The page opens on the operation because the operation is the entire
             product. Everything else here follows from panels that slide along
             a track and swing individually.

             The still is the master door open on its own with the rest of the
             run still closed, which is the state a customer will have the door
             in most days of the year, and it is the one frame in the film that
             shows the point without any explanation. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sf-open-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('How it opens', 'fenster'); ?></p>
                <h2 id="fg-sf-open-title"><?php esc_html_e('Every panel opens on its own.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The panels slide along a track, and each one swings open by itself once it reaches the end. That means the opening is not a single decision you make once. You can walk through one leaf on a Tuesday in February, stand two of them back on a warm evening, and put the whole run away when the weather earns it.', 'fenster'); ?></p>
                <p><?php esc_html_e('One panel is the master door, and it behaves like an ordinary door. It has the handle, it is the one you use for the bins and the washing, and it opens without moving anything else. On four panels or more you can have a master door at each end.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A master door for everyday access, on either end or both', 'fenster'); ?></li>
                    <li><?php esc_html_e('A ventilation position without standing the whole run back', 'fenster'); ?></li>
                    <li><?php esc_html_e('Panels stack together to one side when the run is fully open', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img <?php echo fenster_image_attr_string($base . 'sf-traffic-door-1400w.webp', [
                    'alt' => 'A black aluminium slide and fold door with the master door swung open and the remaining panels still closed',
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
        </div>
    </section>

    <?php /* ---------- 2. How wide it goes ----------------------------------
             The question the office is actually asked about a wide opening, and
             the one the generic copy never answered. The row is generated from
             $max_panel_mm rather than typed, so the arithmetic cannot drift.

             "Inclusive of the outer frame" is load-bearing and stays in the
             sentence. A customer measuring a structural opening and a customer
             measuring a panel are measuring different things, and this is the
             page where that gets settled. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sf-span-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img <?php echo fenster_image_attr_string($base . 'sf-open-stack-1400w.webp', [
                    'alt' => 'A slide and fold door fully open with all panels stacked to one side, leaving the opening clear',
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The span', 'fenster'); ?></p>
                <h2 id="fg-sf-span-title"><?php esc_html_e('You add panels until the opening is covered.', 'fenster'); ?></h2>
                <p><?php echo esc_html(sprintf(
                    /* translators: %s: maximum panel width in millimetres, e.g. 1000mm */
                    __('Each aluminium panel goes up to %s wide, and that figure includes the outer frame, so the sum is straightforward. There is no limit on how many panels you can have, which is why this suits an opening that is wider than a normal set of doors can reach.', 'fenster'),
                    $max_panel_mm . 'mm'
                )); ?></p>
                <ul class="fg-cw-list fg-sf-spans">
                    <?php foreach ($spans as $span) : ?>
                        <li>
                            <strong><?php echo esc_html($span['span']); ?></strong>
                            <span><?php echo esc_html(sprintf(
                                /* translators: %d: number of door panels */
                                _n('%d panel', '%d panels', $span['panels'], 'fenster'),
                                $span['panels']
                            )); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p><?php esc_html_e('Standard height runs to 2400mm in aluminium. Taller than that can be done and is priced on application, and it can pull the maximum panel width back, so tell us the height you are working to early rather than at survey.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <?php /* ---------- 3. Closed ----------------------------------------------
             The security and weather section, written positively throughout.

             The supplier's version of this material is entirely about what a
             bifold does wrong: hinges that can be levered, panels that cannot
             interlock, gaps that are impossible to close. None of that is here.
             What is here is what this door's own detailing achieves, which is
             the TONEOFVOICE.md test: state what the detail achieves, not what
             its absence causes. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sf-closed-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Closed', 'fenster'); ?></p>
                <h2 id="fg-sf-closed-title"><?php esc_html_e('Shut, it reads as one face of glass.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The panels close into each other rather than past each other, so they interlock along their full height and pull up against a double weather seal. That is what gives the closed run its flat, continuous line, and it is why the door looks like a window wall from the garden rather than a row of leaves.', 'fenster'); ?></p>
                <p><?php esc_html_e('The hinges are concealed inside the panels and only come into play once the master door is open and a panel has been slid round to it. From outside there is nothing to see but glass, frame and the one handle on the master door.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A ten point lock across the master door', 'fenster'); ?></li>
                    <li><?php esc_html_e('Panels interlocking into each other along their full height', 'fenster'); ?></li>
                    <li><?php esc_html_e('One handle on the run, and no hinge on show', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo esc_url($blinds_link); ?>"><?php esc_html_e('Blinds sealed inside the glass', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img <?php echo fenster_image_attr_string($base . 'sf-closed-1400w.webp', [
                    'alt' => 'A four panel black aluminium slide and fold door closed, the panels meeting in a continuous flat face',
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
        </div>
    </section>

    <?php /* ---------- 4. The track and the threshold -------------------------
             The builder's section, and the one worth having on the page early
             in a project rather than at survey.

             The 10mm figure is the manufacturer's and is attributed as such.
             The drainage sentence is stated as a requirement to confirm rather
             than as a limitation, per the standing ruling against writing what
             is not offered. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sf-track-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img <?php echo fenster_image_attr_string($base . 'sf-part-open-1400w.webp', [
                    'alt' => 'A slide and fold door part open, showing the bottom track running across the threshold',
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Track and threshold', 'fenster'); ?></p>
                <h2 id="fg-sf-track-title"><?php esc_html_e('The floor carries it, not the lintel.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The panels run on wheels along the bottom track, and that track carries all of their weight. Nothing hangs from the head. The manufacturer gives the reason worth knowing on a new build: a door that is not top hung keeps working when the structure above it settles or the lintel takes up its load, which is a normal part of a building being new.', 'fenster'); ?></p>
                <p><?php esc_html_e('A level threshold on the inside is achievable, and the manufacturer states the outside floor can finish 10mm below the top of the bottom track where the drainage is right. A cill is not needed if the drainage is handled another way, so the thing to settle with your builder is where the water goes.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A flush internal threshold where the floor build-up allows it', 'fenster'); ?></li>
                    <li><?php esc_html_e('Drainage agreed with your builder before the door is made', 'fenster'); ?></li>
                    <li><?php esc_html_e('Sizes taken from the opening at survey before anything is ordered', 'fenster'); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <?php /* ---------- 5. Colour, and the showroom ---------------------------
             The closing section, and it carries two jobs.

             The colour answer HAS to be here. The shared specification-choices
             band is gated off for this route because its colour card points at
             /colour-options/, which is the Liniar foil range and the Sheerline
             powder-coat range, and this door is neither of those systems. Gating
             a band is only safe if something else carries what it said, which is
             the lesson the roofline rebuild paid for when a heading was left
             over nothing. This is that something else. If this section is ever
             removed, un-gate the band in the same commit.

             And the showroom, which is now worth saying: the owner confirmed on
             2026-08-18 that the film is OUR showroom. That changes what this
             page can claim. A door whose whole argument is how it feels to work
             is a door worth sending somebody to touch, and we have one standing
             on the floor in Milton Keynes.

             The bifold and slider links live here, framed as three ways of
             answering the same opening rather than as a ranking. This is the
             only place any of the three is named beside the others. */ ?>
    <section class="fg-cw-intro fg-sf-close" aria-labelledby="fg-sf-close-title">
        <div class="container">
            <?php /* TWO COLUMNS OF COPY RATHER THAN ONE, and it is a layout fix
                     as much as an editorial one. As a single constrained column
                     this section left the right half of the row empty under four
                     alternating splits, which reads as a page that has run out
                     rather than one that has finished. Two columns also separate
                     the two ideas properly: what you choose, and where to go and
                     work one. There is no fifth photograph and none is needed;
                     the change of shape is what closes the page. */ ?>
            <div class="fg-cw-head fg-sf-close__head">
                <p class="eyebrow"><?php esc_html_e('Colour, and seeing one', 'fenster'); ?></p>
                <h2 id="fg-sf-close-title"><?php esc_html_e('Any RAL colour, in one of two finishes.', 'fenster'); ?></h2>
            </div>
            <div class="fg-sf-close__grid">
                <div class="fg-cw-copy">
                    <p><?php esc_html_e('The frame is powder coated in any RAL colour, in a matt finish or in a textured brushed-sand look that catches the light differently. Two are held as standards and cover most of what goes out.', 'fenster'); ?></p>
                    <ul class="fg-cw-facts fg-sf-standards">
                        <?php foreach ($colour_standards as $colour) : ?>
                            <li>
                                <strong><?php echo esc_html($colour['name']); ?></strong>
                                <span><?php echo esc_html($colour['ref']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="fg-cw-copy">
                    <p><?php esc_html_e('There is one standing in our Milton Keynes showroom, and it is the reason to come in rather than read about it. This is a door you judge by working it: sliding a panel round, swinging it open on its own, and feeling the run close back onto its seals. Ten minutes with it tells you more than this page can.', 'fenster'); ?></p>
                    <p class="fg-cw-actions fg-sf-close__links">
                        <a class="fg-cw-link" href="<?php echo esc_url($showroom_link); ?>"><?php esc_html_e('Visit the showroom', 'fenster'); ?></a>
                        <a class="fg-cw-link" href="<?php echo esc_url($study_link); ?>"><?php esc_html_e('See the Leighton Buzzard job', 'fenster'); ?></a>
                        <a class="fg-cw-link" href="<?php echo esc_url($bifold_link); ?>"><?php esc_html_e('Bifold doors', 'fenster'); ?></a>
                        <a class="fg-cw-link" href="<?php echo esc_url($sliding_link); ?>"><?php esc_html_e('Sliding doors', 'fenster'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>
