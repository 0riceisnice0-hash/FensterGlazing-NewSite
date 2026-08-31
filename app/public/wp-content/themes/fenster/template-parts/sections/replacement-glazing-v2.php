<?php
/**
 * Replacement glazing: the bespoke page.
 *
 * Rebuilt 2026-08-10 from the ground up on the owner's brief. The route had been
 * running the generic product journey: "Double Glazing Replacement Glass in
 * Milton Keynes" as the H1 and then twice more as an H2, the same five benefit
 * tiles rendered twice, a spec strip offering FRAME COLOURS on the one page whose
 * whole premise is that the frame stays, a key-spec tile claiming an A+ energy
 * rating that a unit going into somebody else's frame cannot carry, and a case
 * study strip showing secondary glazing, casements and bifolds because no
 * replacement glazing study exists and the helper falls back to all of them.
 *
 * THIS IS NOT AN ENERGY PAGE, and that is the most important thing about it.
 * Owner, 2026-08-10, asked whether a new unit improves thermal performance:
 * "they can but thats not really why we do it as a lot of energy will be lost in
 * an old frame so often a false economy". He also confirmed we do not convert
 * single glazing to double. So the entire angle the old page leaned on is gone.
 * What replaces it is the honest version, which is a better page: your window
 * has failed, the frame is fine, and the glass is the job.
 *
 * THE LINE AGAINST REPAIRS, in the owner's words: "repairs is repairs and this
 * page covers replacement glass only (subtle difference ie new unit must be
 * ordered), both want to link to each other as they are closely related and one
 * job may need both." That is the cleanest definition either page has had. If
 * something has to be MADE, it is this page. Both cross-link, and the copy says
 * plainly that one job can need both.
 *
 * NO EXCLUSIONS ANYWHERE IN THE COPY, per the standing owner instruction and
 * TONEOFVOICE.md: the site does not write what is not covered or not included.
 * Three things were drafted and cut on that rule. A "what is out" list naming
 * conservatory roofs; a line explaining that triple glazing is not a swap for
 * double; and board-ups qualified by hours. Scope is stated positively and what
 * is absent from the list is the answer. Do not reintroduce any of them.
 *
 * Owner-confirmed facts, 2026-08-10, all of them load-bearing here:
 *   - Every frame: uPVC, aluminium and timber, beaded AND putty glazed.
 *   - Windows and doors both. Velux takes a sealed unit swap.
 *   - Single glazing goes back like for like where that is what the frame holds.
 *   - Leaded, Georgian bar and decorative can be matched.
 *   - Commercial is done and belongs to /commercial-replacement-glazing/,
 *     linked from here. It used to point at the commercial HUB, which closed a
 *     loop: the hub's replacement card pointed back at this page. Split on
 *     2026-08-12.
 *   - Existing beads and gaskets are almost always reused.
 *   - We survey and measure before anything is ordered, and the survey is free.
 *   - No minimum. One unit is a job.
 *   - One to two weeks from order. A typical unit takes about an hour to fit.
 *   - Access is needed inside and out. We take the old glass away.
 *   - Integral blinds retrofit into most windows and doors, including frames we
 *     never fitted. The owner asked specifically for this to be included and it
 *     has a section rather than a bullet.
 *   - Ten years on the sealed unit, which is what the manufacturer gives us.
 *
 * PHOTOGRAPHY. Every image is a Fenster job, supplied by the owner on
 * 2026-08-10. The wipe pair is one window five minutes apart, EXIF-confirmed,
 * and the side panes are clear in both frames, which is the whole reason that
 * pair was chosen over the more dramatic one: it carries its own control. The
 * action shot is a BROKEN unit rather than a misted one, so the caption says
 * broken; it is also the owner himself in the early days of the business.
 * All assets are EXIF-stripped because the originals carried the customers'
 * GPS coordinates, and one frame had a number plate and a street name sign
 * blurred out. See PHOTO-CHECKLIST.md.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$base = '/wp-content/themes/fenster/assets/images/products/replacement-glazing/';
$blinds = '/wp-content/themes/fenster/assets/images/products/integral-blinds/';
$quote_url = (string) ($args['quote_url'] ?? '');

$repairs = esc_url(home_url('/window-and-door-repairs/'));
$commercial = esc_url(home_url('/commercial-replacement-glazing/'));
$obscure = esc_url(home_url('/obscure-glass/'));
$pet_flaps = esc_url(home_url('/cat-and-dog-flaps/'));
$integral = esc_url(home_url('/integral-blinds/'));

/* Scope, stated as what we put glass into. Four cards because that is what the
   band renders cleanly, and they are ordered by how often the question comes in
   rather than by material. */
$takes_glass = [
    [
        'name' => __('uPVC, aluminium and timber', 'fenster'),
        'copy' => __('Beaded frames and putty glazed timber both. The unit is measured to the frame it is going into, and the beads and gaskets already on it are almost always the ones that go back.', 'fenster'),
    ],
    [
        'name' => __('Windows and doors', 'fenster'),
        'copy' => __('A pane in a door is the same job as a pane in a window, and a Velux takes a sealed unit swap in the same way. Doors and low panes get checked for toughened or laminated glass before anything is ordered.', 'fenster'),
    ],
    [
        'name' => __('Leaded, Georgian and decorative', 'fenster'),
        'copy' => __('A leaded diamond pattern or Georgian bars can be matched into the new unit, so a period window comes back looking like the one that failed rather than a flat pane in an old frame.', 'fenster'),
    ],
    [
        'name' => __('Single glazing, like for like', 'fenster'),
        'copy' => __('Where a frame holds a single pane, a single pane is what goes back into it, cut and fitted the same way.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-rg">

    <?php /* ---------- What has actually happened -------------------------------
             Opening on the explanation rather than a benefit, because the person
             reading this is annoyed rather than excited and wants to know what is
             wrong before they want to know what we sell. The leaded photograph
             does most of the work: you can see water sitting between the panes,
             which is the whole point and is very hard to say in words. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-rg-what-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('What has happened', 'fenster'); ?></p>
                <h2 id="fg-rg-what-title"><?php esc_html_e('The water is on the inside, which is why cleaning it does nothing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A double glazed unit is two panes of glass held apart by a spacer and sealed all the way round. The seal is the part that fails. Once it goes, damp air gets into the gap, and on a cold morning it condenses against the glass where no cloth will ever reach it.', 'fenster'); ?></p>
                <?php /* "Cloudy, foggy, steamed up" added 2026-08-31. The page
                         described the fault accurately in its own words and used
                         none of the words people type: it said misted and blown
                         and nothing else. These are the three that come up most
                         in competitor copy and in the way callers describe it.
                         One sentence, once, naming them as the same failure. */ ?>
                <p><?php esc_html_e('That is the haze, the tide marks and the streaks that come back however many times the window is cleaned. Cloudy, foggy, steamed up: they are all the same failure. The frame around it is usually still perfectly good, which is why the glass on its own is the job.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A pane that mists over when the weather turns, then clears again', 'fenster'); ?></li>
                    <li><?php esc_html_e('Streaks and tide marks that do not wipe off from either side', 'fenster'); ?></li>
                    <li><?php esc_html_e('Often one pane in a window while the ones beside it stay clear', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'rg-failed-unit-leaded-1600w.jpg')); ?>"
                    alt="<?php esc_attr_e('A failed sealed unit in a leaded window, with condensation and water droplets trapped between the two panes of glass', 'fenster'); ?>"
                    loading="lazy" width="1600" height="1200">
                <figcaption><?php esc_html_e('A failed unit, from inside the room', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php /* ---------- Before and after ------------------------------------------
             High on the page rather than late, which is the opposite of where the
             same control sits on the flush casement page. There the comparison was
             not the selling point, so it belonged beside the comparison table. Here
             the before and after IS the product: it is literally what somebody is
             buying. The pair carries its own proof because the panes either side of
             the failed one are clear in both photographs. */ ?>
    <section class="fg-cw-intro fg-rg-compare" aria-labelledby="fg-rg-compare-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <?php
            get_template_part('template-parts/components/compare-wipe', null, [
                'base_src' => $base . 'rg-clear-1600w.jpg',
                'base_alt' => 'The same window after the failed unit was replaced, with the street outside sharp through all three panes',
                'overlay_src' => $base . 'rg-misted-1600w.jpg',
                'base_tag' => __('Replaced', 'fenster'),
                'overlay_tag' => __('Misted', 'fenster'),
                'ratio' => '16 / 10',
                'sr_label' => __('Drag to reveal the misted unit over the replaced one', 'fenster'),
            ]);
            ?>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Before and after', 'fenster'); ?></p>
                <h2 id="fg-rg-compare-title"><?php esc_html_e('The same window, five minutes apart.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Both photographs are ours, taken on the same afternoon from the same spot. Drag the handle across and watch the middle pane come back.', 'fenster'); ?></p>
                <p><?php esc_html_e('Look at the panes either side of it. They were clear the whole time, in both photographs, because only the middle unit had failed. That is what a failed seal looks like next to a good one, in the same window and the same light.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <?php /* ---------- On the day --------------------------------------------------
             Media first so the photograph lands before the explanation. It is the
             only picture on the site of the work itself rather than the result,
             and it is worth the position. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-rg-day-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--4x5">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'rg-bead-out-1000w.jpg')); ?>"
                    alt="<?php esc_attr_e('A glazing bead being cut away from a uPVC frame with a knife, next to a shattered glass unit waiting to come out', 'fenster'); ?>"
                    loading="lazy" width="1000" height="1333">
                <figcaption><?php esc_html_e('Taking the bead out on a broken unit. That is Nick, in the early days of Fenster.', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('On the day', 'fenster'); ?></p>
                <h2 id="fg-rg-day-title"><?php esc_html_e('The frame stays exactly where it is.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The beads come off, the old unit lifts out, the new one goes in and the beads go back. The beads and gaskets already on your window are almost always the ones that go back on it, so the frame, the hinges, the handles and the locks are all left as they were.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is usually one of our service engineers, sometimes a fitter, and it is a quiet job. We leave the room as we found it.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('About an hour for a typical unit, longer for several or for something awkward', 'fenster'); ?></li>
                    <li><?php esc_html_e('We need to reach the window from inside and out', 'fenster'); ?></li>
                    <li><?php esc_html_e('The old glass leaves with us', 'fenster'); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <?php /* ---------- What we put glass into ---------------------------------------
             A card band so the page changes shape in the middle, and the place the
             repairs boundary is drawn. The heading IS the boundary: if it has to be
             made, it is this page. The honest-advice paragraph lives in the head
             copy rather than in a section of its own, because it is a sentence
             somebody needs at the moment they are wondering whether we will just
             try to sell them a window. Stated positively throughout, per the
             standing rule against writing what is not covered. */ ?>
    <section class="fg-rg-band" aria-labelledby="fg-rg-takes-title">
        <div class="container">
            <div class="fg-rg-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('What we put glass into', 'fenster'); ?></p>
                    <h2 id="fg-rg-takes-title"><?php esc_html_e('If a new unit has to be made, this is the page.', 'fenster'); ?></h2>
                </div>
                <p>
                    <?php
                    printf(
                        /* translators: 1: link to the repairs page, 2: link to the commercial glazing page */
                        /* THE BOUNDARY IS GLASS VS EVERYTHING ELSE, and
                           nothing to do with logistics. This read "a repair is
                           what we call it when the fix happens on the visit and
                           nothing has to be ordered", which the owner rejected
                           on 2026-08-31: "sometimes we have to order parts for
                           a repair." It contradicted the repairs page, which is
                           built on a parts wall and an obsolete-part answer.
                           Owner-confirmed the same day: for these two pages the
                           split is simply glass or not; a real job can be both;
                           it is priced and done together by the SAME engineers,
                           so who attends is not a difference; and the £96
                           repairs minimum does not apply to glass, because the
                           cheapest unit is £170 plus VAT. The rewrite was also
                           twice as long as what it replaced, which the owner
                           called out separately. Keep it to four sentences. */
                        esc_html__('A %1$s is the hardware, the alignment or the seals. This page is the glass itself, made to your measurements. Plenty of jobs need both, and the same engineers price and do them together. Larger and commercial work goes through %2$s.', 'fenster'),
                        '<a class="fg-cw-link" href="' . $repairs . '">' . esc_html__('repair', 'fenster') . '</a>',
                        '<a class="fg-cw-link" href="' . $commercial . '">' . esc_html__('commercial replacement glazing', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <dl class="fg-rg-list">
                <?php foreach ($takes_glass as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <?php /* Was three sentences and the owner called it waffle, which it
                     was. The warmth half of it was also saying the same thing as
                     the "will new glass make the room warmer" FAQ, so it goes
                     there and only there. What is left is the part that earns
                     its place: we will talk you out of it, and it costs nothing
                     to find out. */ ?>
            <p class="fg-rg-band__note">
                <?php esc_html_e('If the frame is rotten or no longer closing properly, we will say so rather than sell you glass for it. The survey is free either way.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <?php /* ---------- While the glass is being made -----------------------------
             The one honest upsell on the page, and it is honest because the timing
             argument is true: the unit is being manufactured from scratch, so this is
             the only moment changing something costs almost nothing extra. Integral
             blinds leads and gets the photograph on the owner's instruction that it
             is a real and frequent job and wants including. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-rg-while-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('While the glass is being made', 'fenster'); ?></p>
                <h2 id="fg-rg-while-title"><?php esc_html_e('The one moment it costs almost nothing to change something.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The unit is being built from scratch to fit your frame, so anything you have been meaning to change about that window is easiest and cheapest now rather than as a job of its own later.', 'fenster'); ?></p>
                <p><?php esc_html_e('Integral blinds are the one people are most surprised by. The blind sits sealed inside the unit, so there is nothing hanging in the room and nothing to dust, and it goes into most windows and doors including frames we never fitted in the first place.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Integral blinds, into most windows and doors', 'fenster'); ?></li>
                    <li><?php esc_html_e('Obscure glass where a bathroom or a landing wants privacy', 'fenster'); ?></li>
                    <li><?php esc_html_e('A cat or dog flap aperture cut into the new unit', 'fenster'); ?></li>
                    <li><?php esc_html_e('Toughened, laminated, acoustic and solar control glass', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $integral; ?>"><?php esc_html_e('Integral blinds', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo $obscure; ?>"><?php esc_html_e('Obscure glass', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo $pet_flaps; ?>"><?php esc_html_e('Cat and dog flaps', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-cw-media fg-cw-media--4x3">
                <img src="<?php echo esc_url(fenster_generated_url($blinds . 'ib-retrofit-closed-1600w.jpg')); ?>"
                    alt="<?php esc_attr_e('A white uPVC window with integral blinds closed inside the glazed units, fitted into an existing frame', 'fenster'); ?>"
                    loading="lazy" width="1600" height="1000">
                <figcaption><?php esc_html_e('Integral blinds, retrofitted into an existing window', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php /* ---------- Where we work -----------------------------------------
             ADDED 2026-08-31. The page carried no statement of coverage in its
             body at all: the towns existed only inside the `areaServed` of the
             Service schema, which no reader sees and which says nothing on its
             own without visible copy behind it. The repairs page has carried
             the same claim as an FAQ since it was rebuilt, so this is the
             sibling page catching up rather than a new claim. Towns are taken
             from that same `areaServed` list, unchanged.

             The guarantee is the owner-confirmed fact recorded at the top of
             this file, "ten years on the sealed unit, which is what the
             manufacturer gives us", and it is stated as exactly that: the
             manufacturer's, on the unit. Do not widen it to the workmanship or
             to the frame, neither of which it covers.

             Reuses `fg-rg-band` unchanged, so there is no CSS to rebuild. */ ?>
    <section class="fg-rg-band" aria-labelledby="fg-rg-where-title">
        <div class="container">
            <div class="fg-rg-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Where we work', 'fenster'); ?></p>
                    <h2 id="fg-rg-where-title"><?php esc_html_e('Replacement glass across Milton Keynes and the towns around it.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Bletchley, Wolverton, Stony Stratford, Newport Pagnell and Woburn Sands among them, and out into the wider Buckinghamshire, Bedfordshire and Northamptonshire area. Glass is measured on site and made to the opening it is going into, so the distance matters less than the access does.', 'fenster'); ?></p>
            </div>
            <p class="fg-rg-band__note">
                <?php esc_html_e('Every sealed unit we fit carries a ten year guarantee from the manufacturer that made it.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <?php /* ---------- Our work -----------------------------------------------------
             `fg-cw-gallery`, the shared component the flush and heritage door pages
             use, so this section looks like the rest of the site and inherits the
             lightbox. Three photographs, all Fenster jobs. */ ?>
    <section class="fg-cw-gallery fg-cw-gallery--trio" aria-labelledby="fg-rg-proof-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-rg-proof-title"><?php esc_html_e('Units we have changed.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Every photograph here is a Fenster job, taken on the day. The two of the same room are before and after on one window. Click any image for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('Every photograph is a Fenster job. Tap any for a closer look.', 'fenster'); ?></span>
                </p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Replacement glazing gallery', 'fenster'); ?>">
                <?php
                /* Order matters to the cut above. Cell one is the near-square
                   tall cell, so it takes the photograph that survives losing a
                   little from each side; the before and after go in cells two
                   and three, which stack, so they sit directly above one
                   another and read as a pair. */
                $gallery = [
                    [
                        'src' => $blinds . 'ib-retrofit-open-1600w.jpg',
                        'alt' => 'A window with integral blinds drawn up inside the glass, the slats stacked at the head of each pane and the view clear below',
                        'caption' => __('Integral blinds, drawn up', 'fenster'),
                    ],
                    [
                        'src' => $base . 'rg-view-misted-1400w.jpg',
                        'alt' => 'A large picture window with a failed sealed unit, the countryside beyond it veiled and streaked',
                        'caption' => __('Before: the failed unit', 'fenster'),
                    ],
                    [
                        'src' => $base . 'rg-view-clear-1400w.jpg',
                        'alt' => 'The same picture window after the unit was replaced, with the fields and the horizon sharp through it',
                        'caption' => __('After: the same window', 'fenster'),
                    ],
                ];
                ?>
                <?php foreach ($gallery as $index => $shot) : ?>
                    <?php $full = fenster_generated_url($shot['src']); ?>
                    <figure>
                        <a href="<?php echo esc_url($full); ?>" data-fg-gallery-lightbox
                            aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $shot['alt'])); ?>">
                            <img src="<?php echo esc_url($full); ?>"
                                sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '40vw' : '28vw'; ?>"
                                alt="<?php echo esc_attr($shot['alt']); ?>" loading="lazy">
                            <figcaption><?php echo esc_html($shot['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</div>
