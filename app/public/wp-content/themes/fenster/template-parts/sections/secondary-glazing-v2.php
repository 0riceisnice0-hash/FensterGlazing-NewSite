<?php
/**
 * Secondary glazing: the bespoke page.
 *
 * Rebuilt 2026-08-07 from the ground up on the owner's brief. The route had been
 * running the generic product journey and had nothing of its own: "Secondary
 * Glazing" as the H1 and then twice more as an H2, a band headed "More
 * information on Secondary Glazing", and not one photograph of the product
 * anywhere on it. The gallery pool it drew from held four images and NONE of
 * them was secondary glazing, including the stock man-with-a-screwdriver shot
 * the repairs page is forbidden from using, carrying alt text that claimed it
 * was a window checked for secondary glazing.
 *
 * Bespoke MIDDLE, the same shape flush casement and aluminium doors use, plus
 * the key-specification strip gated off the way repairs gates it.
 *
 * WHY THE KEY-SPECIFICATION STRIP IS GONE. Owner, 2026-08-07: keep it "only if
 * we actually have relevant stats, dont want filler there". This product has no
 * numbers. The starred U-value came off on 2026-08-05 because a secondary glazed
 * figure depends entirely on the window it is fitted inside, and we publish no
 * acoustic figure. What was left was four facts with no measurement in them, and
 * all four are said better and in context by the sections below. `product_usps`
 * is KEPT and kept accurate because Legend reads its verified product facts from
 * there; it simply no longer renders. Same arrangement as repairs.
 *
 * The order is the order the questions arrive in:
 *   what even is it        -> most people have never had it explained
 *   why would I have it    -> the three reasons, and the USP is the first
 *   can I still open it    -> the objection everybody has, answered with a photo
 *   what glass, what colour-> the two things left to choose
 *
 * THE USP LEADS, on the owner's steer. It is that you keep your own windows.
 * Everything else about this product follows from that, which is why it is the
 * first section and the first card rather than a bullet somewhere in the middle.
 *
 * Owner-confirmed facts, 2026-08-07:
 *   - Styles offered: horizontal sliders, vertical sliders, hinged, fixed, and
 *     lift-out. FIVE on the owner's ruling of 2026-08-13, which split fixed
 *     and lift-out into separate products and superseded the four-style list
 *     confirmed here on 2026-08-07. See the note above `$styles` below.
 *   - A laminated glass upgrade is offered.
 *   - Colours: white, brown, or any RAL. This is NOT the twelve powder-coated
 *     finishes on the aluminium window and door routes, which is why
 *     /secondary-glazing/ is absent from `$aluminium_colour_routes` and must
 *     stay absent.
 *   - It is on the online designer. The route is mapped in
 *     `$product_quote_embeds` to a UUID collection, so the embed in the shared
 *     tail is real and the page can promise online pricing.
 *
 * NO U-VALUE AND NO DECIBEL FIGURE. We publish neither, and the noise copy is
 * deliberately written about the air gap and the glass rather than about a
 * quantity. Do not add "reduces noise by X" without a confirmed figure.
 *
 * NO FENSA. A FENSA certificate covers replacement windows and doors; secondary
 * glazing is an additional internal window and is not that. The shared order
 * process rail below still promises one on this route, which is flagged to the
 * owner rather than changed here, because AI.md is explicit that the rail is one
 * shared set of steps and a route-specific `steps` argument needs the owner.
 *
 * Every photograph on this page is a Fenster installation. Two came from the
 * owner directly and the rest from the Winslow job that is now a case study.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$base = '/wp-content/themes/fenster/assets/images/products/secondary-glazing/';
$quote_url = (string) ($args['quote_url'] ?? '');
$case_study = home_url('/case-studies/secondary-glazing-winslow/');

/* Three cards, and the order is the order they matter in. "The windows have to
   stay" is the USP and leads. */
$reasons = [
    [
        'name' => __('The windows have to stay', 'fenster'),
        'copy' => __('A listed building, a conservation area, or a flat where the windows are not yours to change. Original leaded lights or stained glass worth keeping is the other one. Secondary glazing goes on the inside and takes nothing out, so what is there stays there.', 'fenster'),
    ],
    [
        'name' => __('The road is loud', 'fenster'),
        'copy' => __('Two separate windows with a run of air between them is a different thing from one sealed unit, and the air gap is what slows sound down. If noise is the reason you are calling, say so early, because it changes the glass we would put in.', 'fenster'),
    ],
    [
        'name' => __('The room is cold', 'fenster'),
        'copy' => __('Single glazing loses heat and old frames let draughts through around the edges. A second glazed layer on the inside slows both of those down, and it does it without anybody touching the original window.', 'fenster'),
    ],
];

/* FIVE styles, on the owner's ruling of 2026-08-13: horizontal slider,
   vertical slider, hinged, fixed, and lift-out.

   SUPERSEDES the four-entry list that stood here from 2026-08-07, which folded
   the two together on the reasoning that a lift-out IS the fixed one because
   neither of them opens. That is true and it is not what decides it: a fixed
   pane is sealed into its frame and stays where we fit it, and a lift-out is
   made to come away in your hands, which is a real difference to somebody
   choosing between the two. Both readings were recorded as owner-confirmed, so
   the older one is struck rather than deleted in AI.md:289-290. Do not fold
   them back into one entry.

   LAYOUT CHECKED BEFORE ADDING THE FIFTH. These render as `<li>` in the
   `.fg-cw-facts` list further down, which in main.css is a one-column
   `display: grid` with a gap and no `grid-template-columns`, no column count
   and no `nth-child` rule anywhere against it. A fifth entry adds a row and
   nothing else, and no card grid is involved. */
/* SECTION DRAWINGS ADDED 2026-09-09, on the owner's instruction to make the
   styles visual and put a section drawing behind each one.

   THE DRAWINGS ARE THE MANUFACTURER'S OWN GEOMETRY AND ARE NOT REDRAWN. Each is
   the jamb section, lifted out of the manufacturer's technical PDF by keeping
   the profile paths and dropping the dimension lines, which that document draws
   in a different colour. Clip paths are preserved, or the balance-spiral
   hatching on the vertical slider overshoots its profile. **Do not redraw one by
   hand.** The owner's instruction was that these are technical drawings rather
   than a rough guide, and AI.md's Repair Schematic Rule already records what
   happens when a part is drawn from imagination: every one came back corrected.

   EVERY DRAWING IS AT ONE TRUE SCALE ACROSS ALL FIVE STYLES, so the fixed panel
   really is about a third the width of the hinged frame on screen. **The scale of
   each source drawing was MEASURED off that drawing's own dimension lines** --
   find the tick pair whose midpoint sits on a numeric label, divide the span by
   the stated millimetres, and take the consensus of the dozens that agree. An
   earlier pass derived it from the face/reveal depth difference instead, which is
   right only if nothing but the depth changes between the two frames. It was out
   by 10% on the horizontal slider and by a THIRD on the vertical. Do not derive
   this figure; measure it. `mm_w` is the
   drawing's true width in millimetres and the stylesheet multiplies it by
   `--sg-mm`, so that one custom property rescales the whole set and cannot break
   the relationship between them. This is the rule the bifold configuration rail
   already carries: renders used at different scales publish a lie.

   TWO FIGURES ONLY, on the owner's instruction: front to back, and outer frame
   edge to glass. Both are the manufacturer's own, read off the source documents.
   The depth is the one that changes with the fixing method, which is what makes
   the pair self-checking: the difference between the two depths on one axis is
   what established the drawing scale in the first place.

   THE SUPPLIER IS NOT NAMED, AND NOR IS THE RANGE. Owner, 2026-09-09: "it's a
   generic system so do not name it." The five styles come from three separate
   ranges in the source documents; none of those names, and none of the part
   codes, appears here or in these filenames. Same position as the louvre and
   roofline routes, where figures are the manufacturer's and are attributed as
   theirs and nothing else.

   FIXED IS FACE FIX ONLY, owner-confirmed. There is no reveal fix section for it
   because it is not offered that way. Do not invent one. */
$sg_drawing = static function (string $slug): string {
    $rel = '/assets/images/products/secondary-glazing/sections/sg-section-' . $slug . '.svg';
    $abs = get_template_directory() . $rel;

    /* Versioned on filemtime for the same reason the composite door line art is:
       these are generated files that will be regenerated, theme image URLs carry
       no version string otherwise, and a replaced drawing would then be live,
       correct on the server and invisible to anyone who had already loaded the
       page. See the Asset And Cache Rules in AI.md. */
    return file_exists($abs) ? FENSTER_THEME_URI . $rel . '?v=' . filemtime($abs) : '';
};

$styles = [
    [
        'slug' => 'horizontal',
        'name' => __('Horizontal slider', 'fenster'),
        'copy' => __('Panes run sideways past each other on a track. Nothing swings into the room and nothing needs clear space in front of it, which is why it suits a window behind a deep sill or a radiator.', 'fenster'),
        'fixings' => [
            'face' => ['depth' => 39, 'span' => 47, 'mm_w' => 86.8, 'mm_h' => 76.0],
            'reveal' => ['depth' => 56, 'span' => 47, 'mm_w' => 77.7, 'mm_h' => 94.8],
        ],
    ],
    [
        'slug' => 'vertical',
        'name' => __('Vertical slider', 'fenster'),
        'copy' => __('Panes move up and down instead of across. It is the one for a sash window, and for a tall narrow opening where a sideways track would have nowhere to go.', 'fenster'),
        'fixings' => [
            'face' => ['depth' => 39, 'span' => 56, 'mm_w' => 99.0, 'mm_h' => 55.7],
            'reveal' => ['depth' => 55, 'span' => 56, 'mm_w' => 76.0, 'mm_h' => 67.8],
        ],
    ],
    [
        'slug' => 'hinged',
        'name' => __('Hinged', 'fenster'),
        'copy' => __('Opens towards you like a casement, so the whole original window is in front of you at once. The choice where you need proper access rather than a gap to reach through.', 'fenster'),
        'fixings' => [
            'face' => ['depth' => 39, 'span' => 70, 'mm_w' => 87.9, 'mm_h' => 49.0],
            'reveal' => ['depth' => 55, 'span' => 70, 'mm_w' => 88.0, 'mm_h' => 65.2],
        ],
    ],
    [
        'slug' => 'fixed',
        'name' => __('Fixed', 'fenster'),
        'copy' => __('A single pane sealed into its frame, which is where it stays. The one for an opening nobody uses, where nothing behind it needs reaching and there is no reason for it to move.', 'fenster'),
        'fixings' => [
            'face' => ['depth' => 12, 'span' => 20, 'mm_w' => 31.7, 'mm_h' => 19.9],
        ],
    ],
    [
        'slug' => 'liftout',
        'name' => __('Lift-out', 'fenster'),
        'copy' => __('Does not open either, but it is made to come out. The pane lifts away in your hands and goes back afterwards, so the original window is still reachable when you want it without the glazing being a fixture.', 'fenster'),
        'fixings' => [
            'face' => ['depth' => 30, 'span' => 40, 'mm_w' => 53.8, 'mm_h' => 40.0],
            'reveal' => ['depth' => 49, 'span' => 40, 'mm_w' => 54.2, 'mm_h' => 59.0],
        ],
    ],
];

/* The icons are the standard glazing elevation convention rather than drawn
   symbols: two panes and a pair of arrows for each slider, the hinge triangle
   with its apex on the hinged edge, a plain glazed rectangle for fixed, and a
   dashed pane lifting clear for lift-out. A specifier reads them immediately and
   a homeowner reads them as pictures, which is the point of using the real
   convention rather than inventing one. */
$sg_icons = [
    'horizontal' => '<rect x="4" y="8" width="40" height="32"/><path d="M24 8v32"/><path d="M9 24h9m-9 0 3-2.5M9 24l3 2.5m27-.5h-9m9 0-3-2.5m3 2.5-3 2.5"/>',
    'vertical' => '<rect x="8" y="4" width="32" height="40"/><path d="M8 24h32"/><path d="M24 9v9m0-9-2.5 3M24 9l2.5 3m-2.5 27v-9m0 9-2.5-3m2.5 3 2.5-3"/>',
    'hinged' => '<rect x="8" y="6" width="32" height="36"/><path d="M40 6 8 24l32 18"/>',
    'fixed' => '<rect x="8" y="6" width="32" height="36"/><rect x="14" y="12" width="20" height="24"/>',
    'liftout' => '<rect x="8" y="14" width="32" height="28"/><rect x="13" y="5" width="22" height="20" stroke-dasharray="3 2.5"/><path d="M18 33v-6m0 0-2 2.5m2-2.5 2 2.5M32 33v-6m0 0-2 2.5m2-2.5 2 2.5"/>',
];

/* Face fix and reveal fix are the words the surveyor uses on the day, so the
   customer meets them anyway and the page may as well be the place they learn
   them. Each carries one plain line saying what it means rather than being left
   as trade shorthand. Which one an opening gets is settled at survey. */
$sg_fixings = [
    'face' => [
        'label' => __('Face fix', 'fenster'),
        'note' => __('The frame sits on the wall face around the opening.', 'fenster'),
    ],
    'reveal' => [
        'label' => __('Reveal fix', 'fenster'),
        'note' => __('The frame sits inside the opening, against the reveal.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-sg">

    <?php /* ---------- What it actually is -------------------------------------
             Opening on the explanation rather than on a benefit, because the
             thing this page has to do first is tell people what the product is.
             Most arrive having been told "you could get secondary glazing" and
             no more than that. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sg-what-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('What it is', 'fenster'); ?></p>
                <h2 id="fg-sg-what-title"><?php esc_html_e('A second window, on the inside of the one you have.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A slim frame is fitted into the reveal in front of your existing window. The original is not touched: same glass, same frame, same view of the house from the street. What changes is that there are now two windows with a run of air between them, and that gap is the part doing the work.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is the answer when replacing the window is not on the table, and it is reversible, which is usually the point. Nothing is cut, nothing is removed, and the original window is still there behind it doing what it always did.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Nothing comes out, and the outside of the house does not change', 'fenster'); ?></li>
                    <li><?php esc_html_e('Slim aluminium frames in white, brown or any RAL colour', 'fenster'); ?></li>
                    <li><?php esc_html_e('Priced on our online designer, the same as the windows', 'fenster'); ?></li>
                </ul>
                <?php if ($quote_url !== '') : ?>
                    <p class="fg-cw-actions">
                        <a class="fg-cw-link" href="#fenster-product-quote"><?php esc_html_e('Price it online', 'fenster'); ?></a>
                    </p>
                <?php endif; ?>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'sg-stone-mullion-4x3.jpg')); ?>"
                    alt="<?php esc_attr_e('White secondary glazing fitted inside a stone mullioned reveal, with the original leaded diamond window behind it', 'fenster'); ?>"
                    loading="lazy" width="1200" height="900">
                <figcaption><?php esc_html_e('Our install', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php /* ---------- Why people have it ---------------------------------------
             A card band rather than a third split, so the page changes shape once
             in the middle. The USP is the first card by instruction. */ ?>
    <section class="fg-sg-band" aria-labelledby="fg-sg-why-title">
        <div class="container">
            <div class="fg-sg-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Why people have it', 'fenster'); ?></p>
                    <h2 id="fg-sg-why-title"><?php esc_html_e('Three reasons, and usually two at once.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Almost nobody comes to secondary glazing first. They come to it because replacing the window turned out to be off the table, or because they tried everything else on the noise.', 'fenster'); ?></p>
            </div>
            <dl class="fg-sg-list">
                <?php foreach ($reasons as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <?php /* ---------- How it opens ---------------------------------------------
             The objection everybody arrives with is "so I can never open my
             window again". The photograph answers it before the copy does, which
             is why this section is media-first and why that photograph was worth
             going and finding. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sg-open-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'sg-casement-open-behind-4x3.jpg')); ?>"
                    alt="<?php esc_attr_e('Secondary glazing closed across a leaded window, with the original casement standing wide open behind it', 'fenster'); ?>"
                    loading="lazy" width="1200" height="900">
                <figcaption><?php esc_html_e('The original, open behind it', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('How it opens', 'fenster'); ?></p>
                <h2 id="fg-sg-open-title"><?php esc_html_e('You can still open the window behind it.', 'fenster'); ?></h2>
                <p><?php esc_html_e('This is the question we get asked first, and the answer is yes on everything except the fixed and lift-out panels. You open the secondary glazing, reach the original catch, open the window itself, and close both again. The photograph is one of ours with the original casement wide open behind the glazing.', 'fenster'); ?></p>
                <p><?php esc_html_e('Which of the five suits an opening depends on the window behind it and on what is in front of it in the room. We work that out at survey rather than asking you to.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <?php /* ---------- The five styles, with their sections ---------------------
             The five used to be a flat `<ul>` inside the section above: five
             names and five sentences, nothing to look at, and no answer to the
             question a customer actually asks next, which is how far the thing
             stands into the room.

             PROGRESSIVE ENHANCEMENT RUNS IN THE HONEST DIRECTION. Every panel
             ships open and every drawing ships in the markup, and the picker
             ships `hidden` for the controller to reveal. With no JavaScript the
             visitor gets all five styles and all nine drawings stacked, which is
             complete rather than broken. That is the bargain the bifold
             configuration rail already makes.

             The `[hidden]` guard in the stylesheet is deliberate and is not
             tidy-up: this component sets `display` on the picker and the panels,
             and an author rule outranks the UA sheet's `[hidden] { display:
             none }`. Without it the picker renders before the controller runs
             and every panel stays open after it. That exact fault shipped both
             repairs drawings at once once already. */ ?>
    <section class="fg-sgs" aria-labelledby="fg-sg-styles-title" data-fg-sg-styles>
        <div class="container">
            <div class="fg-sgs__head">
                <p class="eyebrow"><?php esc_html_e('The five styles', 'fenster'); ?></p>
                <h2 id="fg-sg-styles-title"><?php esc_html_e('Five ways it opens, and how much room each one takes.', 'fenster'); ?></h2>
                <?php /* Two numbers, said once, in the order somebody stood in
                         their own room would ask them. The first draft explained
                         the drawings instead of the windows and talked about how
                         things looked "on screen", which is the page describing
                         itself rather than telling anybody anything. */ ?>
                <p><?php esc_html_e('Two numbers matter on any of them: how far the frame stands into the room, and how much of it you see before the glass starts. They are drawn to one scale, so you can compare them.', 'fenster'); ?></p>
            </div>

            <div class="fg-sgs__picker" role="tablist" aria-label="<?php esc_attr_e('Secondary glazing styles', 'fenster'); ?>" hidden>
                <?php foreach ($styles as $i => $style) : ?>
                    <button type="button"
                        class="fg-sgs__tab"
                        role="tab"
                        id="fg-sgs-tab-<?php echo esc_attr($style['slug']); ?>"
                        aria-controls="fg-sgs-panel-<?php echo esc_attr($style['slug']); ?>"
                        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>"
                        data-fg-sg-tab="<?php echo esc_attr($style['slug']); ?>">
                        <svg class="fg-sgs__icon" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
                            <g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round">
                                <?php echo $sg_icons[$style['slug']]; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed inline SVG geometry defined above, no user input ?>
                            </g>
                        </svg>
                        <span><?php echo esc_html($style['name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="fg-sgs__panels">
                <?php foreach ($styles as $style) :
                    $fixings = $style['fixings'];
                    $face = $fixings['face'];
                    $reveal = $fixings['reveal'] ?? null;
                    ?>
                    <article class="fg-sgs__panel"
                        id="fg-sgs-panel-<?php echo esc_attr($style['slug']); ?>"
                        role="tabpanel"
                        aria-labelledby="fg-sgs-tab-<?php echo esc_attr($style['slug']); ?>"
                        data-fg-sg-panel="<?php echo esc_attr($style['slug']); ?>">
                        <div class="fg-sgs__copy">
                            <h3><?php echo esc_html($style['name']); ?></h3>
                            <p><?php echo esc_html($style['copy']); ?></p>
                            <?php /* THE FRAME-TO-GLASS FIGURE IS SAID ONCE, HERE,
                                     because it is a property of the style and does
                                     not change with the fixing method. It used to
                                     print under both drawings and again in a
                                     specification list beside them, so the same
                                     number appeared three times in one panel.
                                     Each drawing now carries only the figure that
                                     is actually its own, which is the depth. */ ?>
                            <p class="fg-sgs__span"><?php echo esc_html(sprintf(
                                /* translators: %d: millimetres of frame before the glass. */
                                __('You see %dmm of frame before the glass starts, whichever way it fixes.', 'fenster'),
                                $face['span']
                            )); ?></p>
                        </div>
                        <div class="fg-sgs__dwgs">
                            <?php foreach ($fixings as $fix_key => $fix) :
                                $src = $sg_drawing($style['slug'] . '-' . $fix_key);
                                if ($src === '') {
                                    continue;
                                }
                                ?>
                                <figure class="fg-sgs__dwg">
                                    <?php /* `height: auto` is set in the stylesheet against these
                                             dimension attributes. An `<img>` height attribute maps
                                             to CSS height and would otherwise beat the width the
                                             calc sets, which is the trap the composite glass door
                                             renders hit at 1,103px tall. The attributes are here
                                             for the aspect ratio and the reserved space only. */ ?>
                                    <img src="<?php echo esc_url($src); ?>"
                                        width="<?php echo esc_attr((string) round($fix['mm_w'] * 10)); ?>"
                                        height="<?php echo esc_attr((string) round($fix['mm_h'] * 10)); ?>"
                                        style="--mm-w: <?php echo esc_attr((string) $fix['mm_w']); ?>"
                                        loading="lazy" decoding="async"
                                        alt="<?php echo esc_attr(sprintf(
                                            /* translators: 1: style name, 2: fixing method. */
                                            __('Scale section through the frame of a %1$s, %2$s', 'fenster'),
                                            strtolower($style['name']),
                                            strtolower($sg_fixings[$fix_key]['label'])
                                        )); ?>">
                                    <figcaption>
                                        <span class="fg-sgs__fix"><?php echo esc_html($sg_fixings[$fix_key]['label']); ?></span>
                                        <span class="fg-sgs__dims"><?php echo esc_html(sprintf(
                                            /* translators: %d: millimetres the frame stands into the room. */
                                            __('%dmm into the room', 'fenster'),
                                            $fix['depth']
                                        )); ?></span>
                                        <span class="fg-sgs__fixnote"><?php echo esc_html($sg_fixings[$fix_key]['note']); ?></span>
                                    </figcaption>
                                </figure>
                            <?php endforeach; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php /* Attributed, never restated as ours. Same position the louvre
                     and roofline routes hold their manufacturers' figures in. */ ?>
            <p class="fg-sgs__note"><?php esc_html_e('The sections and the sizes are the manufacturer\'s. Which style suits an opening, and whether it fixes to the face or into the reveal, is settled at the survey.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* ---------- Glass and colour ------------------------------------------
             The two things genuinely left to choose. Deliberately no decibel
             figure: we publish none, so the copy talks about what the glass does
             rather than by how much. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-sg-glass-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Glass and finish', 'fenster'); ?></p>
                <h2 id="fg-sg-glass-title"><?php esc_html_e('If noise is the reason, the glass is the decision.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Standard glass is enough where the job is warmth and draughts. Laminated glass is the upgrade, two sheets bonded around an interlayer, and it is the one to take if traffic or a flight path is the whole reason you are doing this. It is worth saying so on the phone, because it is specified at the start rather than added later.', 'fenster'); ?></p>
                <p><?php esc_html_e('The frames are slim aluminium and sit inside the reveal, which is what stops a second window looking like one. White and brown are the two standard colours, and any RAL can be matched where a frame needs to disappear into a dark reveal or pick up something already in the room.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Laminated glass upgrade where noise is the priority', 'fenster'); ?></li>
                    <li><?php esc_html_e('White, brown, or any RAL colour', 'fenster'); ?></li>
                    <li><?php esc_html_e('Frames sized to the reveal, so they sit back rather than stand out', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo esc_url($case_study); ?>"><?php esc_html_e('See a listed home in Winslow', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'sg-slider-catch-4x3.jpg')); ?>"
                    alt="<?php esc_attr_e('The catch on a secondary glazing slider, with the original leaded light immediately behind it', 'fenster'); ?>"
                    loading="lazy" width="1200" height="900">
                <figcaption><?php esc_html_e('The catch on a slider', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

</div>
