<?php
/**
 * Aluminium flush windows: the bespoke page.
 *
 * Rebuilt 2026-08-10. The route was running the generic product journey with
 * "Aluminium Flush Windows" as the H1 and then twice more as an H2, plus a band
 * headed "More information on Aluminium Flush Windows".
 *
 * WHAT THIS PAGE IS ABOUT, and it took two attempts to get right. The first
 * concept was built around fixed panes having slimmer frames than openers,
 * which is true and is not the product: it is a detail of the one install we
 * have photographs of. The owner's correction was exact — "too much focus on
 * the fixed pane which is not the whole flush part". The product is the FLAT
 * FACE. The sash closes into the frame instead of onto it, so the outside of
 * the window is one plane. That is the only difference between this and a
 * standard aluminium casement, and it is the one you can see from the garden.
 *
 * THE ANGLE that makes this page different from `/flush-casement-windows/`,
 * which is the uPVC one: that page argues flush against standard uPVC. This one
 * is about aluminium being the material that suits an OLD building, which is the
 * opposite of what the previous copy said ("useful on modern homes and sharper
 * renovation projects"). Our only install is a Cotswold-stone cottage with
 * timber lintels and it looks completely right, because a flat sash face is what
 * timber casements always had. A proud sash is what makes a modern window look
 * wrong on old stone.
 *
 * OWNER BRIEF: make it look and feel cool while staying high end and
 * trustworthy. Hence the dark plate: the real photograph of the join beside a
 * drawn section of the same junction, which is the whole product stated twice in
 * two registers.
 *
 * THE DRAWING CARRIES NO INVENTED DIMENSIONS. Sheerline publishes sightlines
 * (46/60/70mm for fixed lights, 88/102/112mm for casement and French) and a
 * "72-80mm wide system", and those are used. It publishes NO figure for how far
 * a standard sash stands proud, so the step is drawn and labelled in words and
 * is not dimensioned. Do not add a number to it without a source.
 *
 * SHEERLINE PRESTIGE IS BOTH FLUSH AND STANDARD, which the owner flagged, so
 * every figure taken from that page describes the system rather than the flush
 * variant specifically. Nothing here claims a figure is flush-only.
 *
 * PHOTOGRAPHY: three photographs, all one Fenster install, supplied by the owner
 * as the only flush aluminium we have fitted. The detail crop is from the same
 * frame as the timber-lintel shot.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$base = '/wp-content/themes/fenster/assets/images/products/aluminium-flush/';
$quote_url = (string) ($args['quote_url'] ?? '');

$colour_hub = esc_url(home_url('/colour-options/'));
$upvc_flush = esc_url(home_url('/flush-casement-windows/'));
$alu_standard = esc_url(home_url('/aluminium-windows/'));

/* Four cards. Every figure is Sheerline's own published specification for the
   Prestige system, and the system covers both flush and standard, so none of
   these is presented as unique to flush. */
$aluminium_gives = [
    [
        'name' => __('Frames you barely notice', 'fenster'),
        'copy' => __('Sightlines run from 88mm on a casement and 46mm on a fixed light. Aluminium is strong enough to hold a large pane in a narrow frame, which is the part uPVC cannot follow, and it is why a big opening stays mostly glass.', 'fenster'),
    ],
    [
        'name' => __('Any colour, inside and out', 'fenster'),
        'copy' => __('Twelve standard powder-coated finishes, any RAL colour to order, and a different colour inside from outside if the room wants one thing and the elevation another.', 'fenster'),
    ],
    [
        'name' => __('Warm for a metal window', 'fenster'),
        'copy' => __('Thermlock multi-chamber thermal breaks separate the outside of the frame from the inside. 1.4 W/m2K double glazed, 1.0 triple, and up to an A+ window energy rating.', 'fenster'),
    ],
    [
        'name' => __('Screwed corners, not crimped', 'fenster'),
        'copy' => __('Sheerline bind the mitres with threaded screws rather than crimping them. It is a patented detail and it matters most on a flush window, because the corner is on show rather than hidden behind a proud sash.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-afw">

    <?php /* ---------- The flat face ------------------------------------------
             The plate. Dark, because aluminium takes a dark ground and because
             this is the one section that has to feel like a product being
             presented rather than described. Photograph on one side, drawn
             section of the same junction on the other: the same fact twice, once
             as evidence and once as explanation. */ ?>
    <section class="fg-afw-plate" aria-labelledby="fg-afw-flat-title">
        <div class="container">
            <div class="fg-afw-plate__head">
                <p class="eyebrow"><?php esc_html_e('What flush means', 'fenster'); ?></p>
                <h2 id="fg-afw-flat-title"><?php esc_html_e('The sash closes into the frame, not onto it.', 'fenster'); ?></h2>
                <p><?php esc_html_e('On a standard casement the opening sash sits on the face of the frame and stands proud of it, so every opener has a step around it and a shadow line that follows the sun round. On a flush window the sash closes down into the frame and the outside of the window is one plane. That is the only difference between the two, and it is the one you see from the garden.', 'fenster'); ?></p>
            </div>

            <div class="fg-afw-plate__grid">
                <figure class="fg-afw-plate__shot">
                    <img src="<?php echo esc_url(fenster_generated_url($base . 'afw-flush-join-1300w.jpg')); ?>"
                        alt="<?php esc_attr_e('Close detail of a grey aluminium flush window where the opening sash meets the fixed light, the two faces sitting in one continuous plane', 'fenster'); ?>"
                        loading="lazy" width="1300" height="1005">
                    <figcaption><?php esc_html_e('One of ours. The join between the opener and the fixed light, and no step across it.', 'fenster'); ?></figcaption>
                </figure>

                <figure class="fg-afw-plate__draw">
                    <?php /* Plan section through the jamb, outside at the top. The
                             dashed datum is the outside face of the frame and it
                             runs across BOTH halves on purpose: the flush sash
                             sits on that line and the standard sash breaks it,
                             which is the whole drawing. Deliberately simplified,
                             and the step carries no dimension because Sheerline
                             publishes no figure for it. */ ?>
                    <svg class="fg-afw-svg" viewBox="8 58 624 222" role="img"
                        aria-label="<?php esc_attr_e('Section drawing comparing a flush window, where the sash face sits level with the frame face, against a standard window, where the sash stands proud of it', 'fenster'); ?>">
                        <g class="fg-afw-svg__construct">
                            <path d="M20 100 H620"/>
                        </g>

                        <g class="fg-afw-svg__frame">
                            <rect x="60" y="100" width="70" height="100"/>
                            <rect x="68" y="108" width="54" height="84"/>
                            <rect x="130" y="100" width="60" height="85"/>
                            <rect x="138" y="108" width="44" height="69"/>
                        </g>
                        <g class="fg-afw-svg__glass">
                            <path d="M190 132 H300 M190 152 H300"/>
                        </g>

                        <g class="fg-afw-svg__frame">
                            <rect x="380" y="100" width="70" height="100"/>
                            <rect x="388" y="108" width="54" height="84"/>
                            <rect x="438" y="78" width="72" height="107"/>
                            <rect x="446" y="86" width="56" height="91"/>
                        </g>
                        <g class="fg-afw-svg__glass">
                            <path d="M510 132 H620 M510 152 H620"/>
                        </g>
                        <g class="fg-afw-svg__construct">
                            <path d="M424 78 V100 M418 78 h12 M418 100 h12"/>
                        </g>

                        <g class="fg-afw-svg__label">
                            <text x="60" y="240"><?php esc_html_e('FLUSH', 'fenster'); ?></text>
                            <text x="60" y="262" class="fg-afw-svg__note"><?php esc_html_e('faces level', 'fenster'); ?></text>
                            <text x="380" y="240"><?php esc_html_e('STANDARD', 'fenster'); ?></text>
                            <text x="380" y="262" class="fg-afw-svg__note"><?php esc_html_e('sash proud of the frame', 'fenster'); ?></text>
                            <text x="20" y="92" class="fg-afw-svg__note"><?php esc_html_e('outside face', 'fenster'); ?></text>
                        </g>
                    </svg>
                    <figcaption><?php esc_html_e('Section through the jamb, outside at the top. Simplified, and drawn to make one point.', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <?php /* ---------- Why it suits an old building ------------------------------
             The angle. Media first because the photograph is the argument: dove
             grey aluminium on Cotswold limestone, and it does not fight it. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-afw-old-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--4x5">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'afw-stone-gable-1100w.jpg')); ?>"
                    alt="<?php esc_attr_e('Dove grey aluminium flush windows in a Cotswold stone gable, set under timber lintels', 'fenster'); ?>"
                    loading="lazy" width="1100" height="1466">
                <figcaption><?php esc_html_e('Our install, on limestone, under timber lintels', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Where it belongs', 'fenster'); ?></p>
                <h2 id="fg-afw-old-title"><?php esc_html_e('The aluminium window that suits an old house.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Aluminium has a reputation for looking modern, and a standard casement earns it: the proud sash is a hard, obviously manufactured line that a stone elevation was never designed to carry. A flush window does not have that line. A flat sash face is what timber casements always had, which is why this one sits on a limestone gable under timber lintels and does not argue with it.', 'fenster'); ?></p>
                <p><?php esc_html_e('That is worth saying plainly because most people arrive here assuming aluminium is for extensions and glass boxes. It is very good at those. It is also the material to reach for when the frames want to be quiet and thin and a particular colour, and the building they are going into is two hundred years older than they are.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('A flat outside face, the way a timber casement sits', 'fenster'); ?></li>
                    <li><?php esc_html_e('Slim frames, so a small stone opening keeps its glass', 'fenster'); ?></li>
                    <li><?php esc_html_e('Colour chosen against the stone rather than out of a box', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $colour_hub; ?>"><?php esc_html_e('See the colour range', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo $upvc_flush; ?>"><?php esc_html_e('Flush in uPVC instead', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php /* ---------- What aluminium gives you ---------------------------------
             Card band so the page changes shape. Every figure is Sheerline's own
             published specification for the Prestige system. */ ?>
    <section class="fg-afw-band" aria-labelledby="fg-afw-alu-title">
        <div class="container">
            <div class="fg-afw-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Why aluminium', 'fenster'); ?></p>
                    <h2 id="fg-afw-alu-title"><?php esc_html_e('What the metal buys you.', 'fenster'); ?></h2>
                </div>
                <p>
                    <?php
                    printf(
                        /* translators: %s: link to the uPVC flush casement page */
                        esc_html__('Flush is a shape and you can have it in %s for less. Aluminium is what you choose when the frames need to be thinner than uPVC can go, or a colour it does not come in, or when the window has to still be there in thirty years looking like this.', 'fenster'),
                        '<a class="fg-cw-link" href="' . $upvc_flush . '">' . esc_html__('uPVC', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <dl class="fg-afw-list">
                <?php foreach ($aluminium_gives as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <p class="fg-afw-band__note">
                <?php esc_html_e('Figures are Sheerline\'s published specification for the Prestige system, which covers both flush and standard windows. What we fit, and what it costs, depends on the opening.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <?php /* ---------- Our work ---------------------------------------------------
             Two photographs, the same house, shared component so it looks like
             the rest of the site. Only one install exists, and the copy says so
             rather than implying a portfolio. */ ?>
    <section class="fg-cw-gallery fg-cw-gallery--pair" aria-labelledby="fg-afw-proof-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-afw-proof-title"><?php esc_html_e('The house on the stone.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('One house, photographed on a clear November afternoon. Look at the sash lines: on every opener the face runs level with the frame around it. Click either image for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('One of our installs. Tap either image for a closer look.', 'fenster'); ?></span>
                </p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Aluminium flush window gallery', 'fenster'); ?>">
                <?php
                $gallery = [
                    [
                        'src' => $base . 'afw-timber-lintel-1100w.jpg',
                        'alt' => 'A grey aluminium flush window under a timber lintel in a limestone wall, with a fixed light beside the opening sash',
                        'caption' => __('Opener and fixed light under a timber lintel', 'fenster'),
                    ],
                    [
                        'src' => $base . 'afw-stone-return-1100w.jpg',
                        'alt' => 'Grey aluminium flush windows turning a corner on a limestone cottage, seen from the garden',
                        'caption' => __('The same house, turning the corner', 'fenster'),
                    ],
                ];
                ?>
                <?php foreach ($gallery as $index => $shot) : ?>
                    <?php $full = fenster_generated_url($shot['src']); ?>
                    <figure>
                        <a href="<?php echo esc_url($full); ?>" data-fg-gallery-lightbox
                            aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $shot['alt'])); ?>">
                            <img src="<?php echo esc_url($full); ?>"
                                sizes="(max-width: 860px) 82vw, 40vw"
                                alt="<?php echo esc_attr($shot['alt']); ?>" loading="lazy">
                            <figcaption><?php echo esc_html($shot['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</div>
