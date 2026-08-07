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
 *   - Styles offered: fixed (and lift-out), horizontal sliders, vertical
 *     sliders, hinged. Four, and the page names all four.
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

/* The four styles the owner confirmed we offer. Fixed and lift-out are one
   entry because a lift-out IS the fixed one: it does not open, it comes out. */
$styles = [
    ['name' => __('Horizontal slider', 'fenster'), 'copy' => __('Panes run sideways past each other on a track. Nothing swings into the room and nothing needs clear space in front of it, which is why it suits a window behind a deep sill or a radiator.', 'fenster')],
    ['name' => __('Vertical slider', 'fenster'), 'copy' => __('Panes move up and down instead of across. It is the one for a sash window, and for a tall narrow opening where a sideways track would have nowhere to go.', 'fenster')],
    ['name' => __('Hinged', 'fenster'), 'copy' => __('Opens towards you like a casement, so the whole original window is in front of you at once. The choice where you need proper access rather than a gap to reach through.', 'fenster')],
    ['name' => __('Fixed, and lift-out', 'fenster'), 'copy' => __('For an opening that is never opened. A fixed pane is sealed in; a lift-out is the same pane held so it comes away in your hands when you want the original window back.', 'fenster')],
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
                <p><?php esc_html_e('This is the question we get asked first, and the answer is yes on everything except the fixed panels. You open the secondary glazing, reach the original catch, open the window itself, and close both again. The photograph is one of ours with the original casement wide open behind the glazing.', 'fenster'); ?></p>
                <p><?php esc_html_e('Which of the four suits an opening depends on the window behind it and on what is in front of it in the room. We work that out at survey rather than asking you to.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <?php foreach ($styles as $style) : ?>
                        <li><strong><?php echo esc_html($style['name']); ?></strong><?php echo esc_html('. ' . $style['copy']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
