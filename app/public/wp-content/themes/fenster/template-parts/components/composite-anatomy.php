<?php
/**
 * The composite slab, cut open.
 *
 * WHAT THIS REPLACED. The construction section paired a flat bitmap with a
 * six-row accordion and the two were not connected to each other: opening
 * "GRP skin" highlighted nothing, a leader line and dot sat in the middle of
 * the picture pointing at nothing in particular, and five of the six rows were
 * dead space at any moment. Built 2026-08-27 from the design handoff at
 * `design_handoff_composite_door_anatomy/`.
 *
 * WHAT IT DOES INSTEAD. Every layer is its own element, so selecting a row
 * highlights that component in the drawing, moves a leader dot onto it and
 * shows a measurement chip beside it. The reference was Distinction's own
 * peel-back graphic; the thing that beats it is correspondence, which is
 * exactly what theirs does not have.
 *
 * THE CUTAWAY IS TWO CONCENTRIC ARCS, not a peeling animation. A large one
 * removes the skin and a smaller one also removes the board, so moving into the
 * top-right corner reads skin, then board, then foam. That is what makes six
 * layers legible in one still image.
 *
 * FOUR THINGS THAT ARE LOAD-BEARING AND FAIL SILENTLY IF THEY ARE "TIDIED":
 *
 * 1. `.fg-cd3-slab__glass-sawn` is a SIBLING of the glass face, never a child.
 *    Their two arc masks are exact complements, so nesting them multiplies the
 *    alpha to zero and the sawn edge vanishes with no error.
 * 2. That element is FULL-SLAB and clipped down to the cassette rect, not an
 *    element sized to the cassette. The arc mask has to resolve against the
 *    slab box or the ellipse lands somewhere else entirely.
 * 3. TIMBER SITS INSIDE POLYMER. The polymer rail is what the weather touches
 *    and the engineered wood is a reinforcement behind it that never sees
 *    daylight. Distinction's own graphic has this the wrong way round; do not
 *    "correct" it back.
 * 4. THE APERTURE IS CUT CLEAN THROUGH BOARD AND FOAM and framed with an
 *    engineered-wood surround. No foam runs behind the glass.
 *
 * GEOMETRY LIVES IN THE STYLESHEET, not here. Every number is a percentage of a
 * box with `aspect-ratio: 0.43`, so the drawing scales with its column and there
 * is not a pixel value in it. The callout anchors were checked against both arc
 * masks; anchor 04 in particular has to sit in the band BETWEEN the arcs, inside
 * the skin cut but outside the board cut, or it points at foam. If the arcs
 * move, re-check all six.
 *
 * COPY, STATS AND THE FOOTNOTE ARE UNCHANGED and still come from
 * `$composite_anatomy` in `generated-page.php`. This is a presentation change.
 * The chip text is new and belongs to the graphic rather than to the data.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$fg_an = is_array($args['anatomy'] ?? null) ? $args['anatomy'] : [];
$fg_layers = is_array($fg_an['layers'] ?? null) ? array_values($fg_an['layers']) : [];
if (count($fg_layers) !== 6) {
    /* The drawing is built for exactly these six layers in this order and its
       highlights are keyed to their index. A different list is a different
       drawing, so fall back rather than render a graphic that points at the
       wrong things. */
    return;
}

/* The measurement beside each layer. Ordered with the layers, and deliberately
   not in `$composite_anatomy`: these are properties of the drawing, and a
   number that only exists to be printed next to a dot does not belong in the
   page's content data. `side` flips the chip to the left of its dot wherever
   the anchor sits past 62% across, so a chip never runs outside the figure. */
$fg_chips = [
    ['text' => __('2mm each face', 'fenster'),          'side' => 'right'],
    ['text' => __('wraps the perimeter', 'fenster'),    'side' => 'left'],
    ['text' => __('inside the polymer edge', 'fenster'), 'side' => 'left'],
    ['text' => __('6mm, mid-plane', 'fenster'),         'side' => 'left'],
    ['text' => __('fills the 34mm cavity', 'fenster'),  'side' => 'left'],
    ['text' => __('sealed unit', 'fenster'),            'side' => 'right'],
];

$fg_face  = '/wp-content/themes/fenster/assets/images/products/composite-distinction/styles/esp01-flush-600w.webp';
$fg_glass = '/wp-content/themes/fenster/assets/images/products/composite-distinction/glass/lunna-720w.webp';
?>
<section class="fg-cd3-anatomy" aria-labelledby="fg-cd3-anatomy-title" data-fg-anatomy data-active-layer="0">
    <div class="container">
        <header class="fg-cd3-anatomy__head">
            <p class="eyebrow"><?php esc_html_e('Construction', 'fenster'); ?></p>
            <h2 id="fg-cd3-anatomy-title"><?php esc_html_e('What is inside the slab.', 'fenster'); ?></h2>
            <p class="fg-cd3-anatomy__lede"><?php esc_html_e('A composite door looks like timber and is deliberately nothing like one inside. Open a layer and the drawing shows you where it sits.', 'fenster'); ?></p>
        </header>

        <div class="fg-cd3-anatomy__explorer">
            <figure class="fg-cd3-anatomy__media" aria-label="<?php echo esc_attr((string) ($fg_an['image_alt'] ?? 'Cutaway of a composite door slab')); ?>">
                <div class="fg-cd3-slab">
                    <span class="fg-cd3-slab__shadow" aria-hidden="true"></span>

                    <div class="fg-cd3-slab__body">
                        <div class="fg-cd3-slab__stack">

                            <?php /* Foam and board share one hole, punched clean through both. */ ?>
                            <div class="fg-cd3-slab__core">
                                <div class="fg-cd3-slab__foam"></div>
                                <div class="fg-cd3-slab__hl" data-hl="foam"><i></i></div>

                                <div class="fg-cd3-slab__board">
                                    <div class="fg-cd3-slab__board-mat"></div>
                                    <div class="fg-cd3-slab__board-arc"></div>
                                </div>
                                <div class="fg-cd3-slab__hl" data-hl="board"><i></i></div>
                            </div>

                            <?php /* The engineered-wood surround the cassette screws into. */ ?>
                            <div class="fg-cd3-slab__surround">
                                <div class="fg-cd3-slab__surround-mat"></div>
                                <div class="fg-cd3-slab__surround-reveal"></div>
                            </div>

                            <?php /* Engineered wood, INSIDE the polymer. */ ?>
                            <div class="fg-cd3-slab__timber">
                                <i class="is-l"></i><i class="is-r"></i><i class="is-t"></i><i class="is-b"></i>
                            </div>
                            <div class="fg-cd3-slab__hl fg-cd3-slab__hl--line" data-hl="timber-line">
                                <i class="is-l"></i><i class="is-r"></i>
                            </div>
                            <div class="fg-cd3-slab__hl" data-hl="timber">
                                <span class="fg-cd3-slab__hl-clip">
                                    <i class="is-ap"></i><i class="is-l"></i><i class="is-r"></i><i class="is-t"></i><i class="is-b"></i>
                                </span>
                            </div>

                            <?php /* Water-resistant polymer, wrapping everything. */ ?>
                            <div class="fg-cd3-slab__poly">
                                <i class="is-l"></i><i class="is-r"></i><i class="is-t"></i><i class="is-b"></i>
                            </div>
                            <div class="fg-cd3-slab__hl fg-cd3-slab__hl--line" data-hl="poly-line">
                                <i class="is-l"></i><i class="is-r"></i><i class="is-t"></i>
                            </div>
                            <div class="fg-cd3-slab__hl" data-hl="poly">
                                <span class="fg-cd3-slab__hl-clip">
                                    <i class="is-l"></i><i class="is-r"></i><i class="is-t"></i><i class="is-b"></i>
                                </span>
                            </div>

                            <?php /* The GRP skin: holed at the cassette, cut by the big arc. */ ?>
                            <div class="fg-cd3-slab__skin">
                                <div class="fg-cd3-slab__skin-mask">
                                    <div class="fg-cd3-slab__skin-base"></div>
                                    <img class="fg-cd3-slab__face" src="<?php echo esc_url(fenster_generated_url($fg_face)); ?>" alt="" loading="lazy" decoding="async" width="600" height="1395">
                                    <div class="fg-cd3-slab__sheen"></div>
                                </div>
                            </div>

                            <div class="fg-cd3-slab__cut" aria-hidden="true"></div>
                            <div class="fg-cd3-slab__hl" data-hl="skin"><i></i></div>

                            <?php
                            /* SIBLING, NOT CHILD, AND FULL-SLAB. See the header.
                               The sealed unit read edge-on where the arc saws
                               through it: three panes and two cavities. */
                            ?>
                            <div class="fg-cd3-slab__glass-sawn" aria-hidden="true"></div>

                            <div class="fg-cd3-slab__glass-clip">
                                <div class="fg-cd3-slab__cassette">
                                    <div class="fg-cd3-slab__glass-base"></div>
                                    <img class="fg-cd3-slab__glass-face" src="<?php echo esc_url(fenster_generated_url($fg_glass)); ?>" alt="" loading="lazy" decoding="async" width="720" height="720">
                                    <div class="fg-cd3-slab__lead" aria-hidden="true">
                                        <i></i><i></i><i></i><b></b>
                                    </div>
                                    <div class="fg-cd3-slab__glass-sheen"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php /* Decoration that repeats what the open row already says. */ ?>
                    <div class="fg-cd3-slab__callouts" aria-hidden="true">
                        <span class="fg-cd3-slab__ring"></span>
                        <span class="fg-cd3-slab__dot"></span>
                        <?php foreach ($fg_chips as $fg_i => $fg_chip) : ?>
                            <span class="fg-cd3-slab__chip fg-cd3-slab__chip--<?php echo esc_attr($fg_chip['side']); ?>" data-chip="<?php echo esc_attr((string) $fg_i); ?>">
                                <span><?php echo esc_html($fg_chip['text']); ?></span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </figure>

            <ol class="fg-cd3-anatomy__layers">
                <?php foreach ($fg_layers as $fg_i => $fg_layer) : ?>
                    <?php $fg_id = 'fg-cd3-layer-' . $fg_i; ?>
                    <li class="fg-cd3-layer">
                        <h3>
                            <button
                                type="button"
                                class="fg-cd3-layer__toggle"
                                data-fg-anatomy-toggle
                                data-fg-anatomy-layer="<?php echo esc_attr((string) $fg_i); ?>"
                                aria-expanded="<?php echo $fg_i === 0 ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr($fg_id); ?>">
                                <span class="fg-cd3-layer__num" aria-hidden="true"><?php echo esc_html(str_pad((string) ($fg_i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                                <span class="fg-cd3-layer__name"><?php echo esc_html((string) $fg_layer['name']); ?></span>
                                <?php /* The plus that becomes a minus is drawn with the mark's
                                         own pseudo-elements, which already existed and already
                                         work. No children here. */ ?>
                                <span class="fg-cd3-layer__mark" aria-hidden="true"></span>
                            </button>
                        </h3>
                        <div class="fg-cd3-layer__body" id="<?php echo esc_attr($fg_id); ?>" <?php echo $fg_i === 0 ? '' : 'hidden'; ?>>
                            <p><?php echo esc_html((string) $fg_layer['copy']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>

        <?php if (! empty($fg_an['stats'])) : ?>
            <dl class="fg-cd3-anatomy__stats">
                <?php foreach ($fg_an['stats'] as $fg_stat) : ?>
                    <div>
                        <dt><?php echo esc_html((string) $fg_stat['value']); ?></dt>
                        <dd><?php echo esc_html((string) $fg_stat['label']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>

        <?php if (! empty($fg_an['footnote'])) : ?>
            <p class="fg-cd3-anatomy__footnote"><?php echo esc_html((string) $fg_an['footnote']); ?></p>
        <?php endif; ?>
    </div>
</section>
