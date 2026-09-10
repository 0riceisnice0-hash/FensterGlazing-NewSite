<?php
/**
 * Notan magnetic integrated blind visualiser.
 *
 * A face-on, fully straight view of one glazed unit with the blind sealed
 * inside it. Tilt and lift are continuous sliders and the colour selector
 * carries the nine real Notan slat colours from `notan_blind_colours`.
 *
 * The blind is not a photograph and not a sprite sheet. It is drawn to a
 * canvas from the slat geometry, which is what makes nine colours times a
 * continuous tilt times a continuous lift possible at all: as a set of
 * pre-rendered images that matrix is thousands of files. Face-on is also why
 * a canvas is enough and WebGL is not needed. With no perspective, a slat
 * projects to a plain rectangle of height `w*|sin p| + t*|cos p|`, which is
 * exact rather than approximated, and `AI.md` bars reintroducing Three.js
 * without the owner asking for 3D.
 *
 * Markup here is deliberately inert. The controls are native inputs and the
 * fallback photograph is visible by default; the controller adds `is-live`
 * once it has a context and a first frame, which swaps the photograph for the
 * canvas. A JS failure therefore degrades to the real Notan close-up rather
 * than to an empty box, and that holds for a thrown error as well as for
 * scripting being off, which a <noscript> block would not cover.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$colours = fenster_data('notan_blind_colours', []);
$colours = is_array($colours) ? array_values($colours) : [];

if (empty($colours)) {
    return;
}

$section_id  = (string) ($args['id'] ?? 'blind-visualiser');
$eyebrow     = (string) ($args['eyebrow'] ?? 'See it move');
$heading     = (string) ($args['heading'] ?? 'Tilt it, raise it, change the colour.');
$intro       = (string) ($args['intro'] ?? '');
$fallback    = (string) ($args['fallback_image'] ?? '');
$fallback_alt = (string) ($args['fallback_alt'] ?? 'Integral blind sealed between the panes of a glazed unit');

/* Which colour opens. Anthracite reads as a blind rather than as an empty
   frame at every tilt angle, where White at a low tilt can look like nothing
   is there at all on a first glance. */
$default_index = 3;
foreach ($colours as $index => $colour) {
    if (($colour['key'] ?? '') === 'anthracite') {
        $default_index = $index;
        break;
    }
}
?>
<section id="<?php echo esc_attr($section_id); ?>" class="fg-blind-visualiser" data-fg-blind-visualiser>
    <div class="container">
        <div class="fg-blind-visualiser__shell">
            <div class="fg-blind-visualiser__intro">
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <h2><?php echo esc_html($heading); ?></h2>
                <?php if ($intro !== '') : ?>
                    <p><?php echo esc_html($intro); ?></p>
                <?php endif; ?>
            </div>

            <div class="fg-blind-visualiser__stage">
                <?php /* Sized in CSS by aspect-ratio; the controller sets the
                         backing store from the painted box and the device
                         pixel ratio, so no width/height attributes here. */ ?>
                <canvas
                    class="fg-blind-visualiser__canvas"
                    data-fg-blind-canvas
                    role="img"
                    aria-label="<?php esc_attr_e('A glazed unit seen straight on, with the integral blind drawn at the tilt, height and colour you have selected', 'fenster'); ?>"
                ></canvas>
                <?php if ($fallback !== '') : ?>
                    <img
                        class="fg-blind-visualiser__fallback"
                        src="<?php echo esc_url(fenster_generated_url($fallback)); ?>"
                        alt="<?php echo esc_attr($fallback_alt); ?>"
                        loading="lazy"
                        decoding="async"
                    >
                <?php endif; ?>

                <?php
                /* The two magnets are drawn on the unit's own profile and are
                   dragged there, because that is where they are on the real
                   product. These inputs are the same two controls for anyone
                   not using a pointer: they stay in the tab order, carry the
                   labels and the values a screen reader needs, and the
                   controller mirrors them to the magnets in both directions.
                   They are placed off screen rather than hidden, because
                   `display: none` would take them out of the tab order and
                   leave the visualiser operable by mouse alone. */
                ?>
                <?php
                /* Real elements over each magnet rather than hit testing the
                   canvas. On touch this is the whole difference between the
                   thing working and not: the stage has to stay pannable so the
                   page scrolls when a thumb lands on the glass, and switching
                   the canvas to `touch-action: none` on pointerdown is too
                   late, because the browser has already committed to a scroll
                   by then. Only these two carry `touch-action: none`, so a drag
                   on a magnet is a drag and a drag anywhere else is a scroll.
                   The controller positions them from the drawn magnets. */
                ?>
                <div class="fg-blind-visualiser__grab" data-fg-blind-grab="tilt" aria-hidden="true"></div>
                <div class="fg-blind-visualiser__grab" data-fg-blind-grab="lift" aria-hidden="true"></div>

                <?php
                /* The first-use coach. Owner, 2026-09-10: the visualiser should
                   say which magnet does what, on the blind itself, and go away
                   once it has been used.

                   The two magnets are small dark tabs on a dark frame and they
                   are the whole interface, so without this the paragraph below
                   the stage is the only thing that says they can be dragged,
                   and it is under the picture rather than on it.

                   `aria-hidden` because this says nothing new to a screen
                   reader: the two range inputs in `__a11y` are labelled "Tilt
                   the slats" and "Raise or lower the blind" already, and the
                   hint paragraph carries the same sentence in text. It is also
                   `pointer-events: none` throughout, so it can never take a
                   drag that was meant for the magnet under it.

                   Positioned by the controller from the same `magnetCentre` the
                   grabs use, so it follows the magnets rather than guessing at
                   where they are, and it is only displayed once the canvas is
                   live: over the fallback photograph it would point at nothing. */
                ?>
                <?php
                /* One hand per magnet, and it does the explaining. Owner,
                   2026-09-10, after four variants were put in front of him:
                   video game style, with a little hand showing the drag, and
                   the wording in a box to the left as it already was.

                   So each magnet gets three things: a dashed outline left where
                   it rests, a translucent copy of it that the hand takes hold of
                   and pulls along the rail, and the label. Showing what MOVES is
                   the part a static label could never do, and it is the reason
                   this variant was chosen over a hand travelling on its own.

                   The hand is MIRRORED. A pointing hand has its palm below and
                   to the right of the fingertip, and these magnets sit on the
                   right hand rail, so unmirrored the palm falls off the edge of
                   the unit. Mirrored it reaches in across the glass, which is
                   also how a real hand would come at it. The fingertip lands on
                   the magnet's left half rather than its centre, so it points at
                   the magnet without covering it.

                   Everything is positioned by the controller from the same
                   `magnetCentre` and `magnetTracks` the drag targets use, so the
                   ghost travels the magnet's REAL range rather than a guess at
                   it, and the whole thing follows a resize. */
                ?>
                <div class="fg-blind-visualiser__coach" data-fg-blind-coach aria-hidden="true">
                    <?php foreach (['tilt', 'lift'] as $coach_which) : ?>
                        <span class="fg-blind-visualiser__coach-mark" data-fg-blind-coach-mark="<?php echo esc_attr($coach_which); ?>"></span>
                        <span class="fg-blind-visualiser__coach-ghost" data-fg-blind-coach-ghost="<?php echo esc_attr($coach_which); ?>"></span>
                        <span class="fg-blind-visualiser__coach-hand" data-fg-blind-coach-hand="<?php echo esc_attr($coach_which); ?>">
                            <svg viewBox="0 0 30 36" focusable="false" aria-hidden="true">
                                <path d="M11.4 4.1a2.6 2.6 0 0 1 5.2 0v9.6a2.4 2.4 0 0 1 4.3.9 2.4 2.4 0 0 1 4 1.5 2.4 2.4 0 0 1 3.7 2v6.4c0 5.3-4.3 9.6-9.6 9.6h-1.6a9.6 9.6 0 0 1-7.7-3.9l-4.4-5.9a2.5 2.5 0 0 1 3.7-3.3l2.4 2.3z"/>
                            </svg>
                        </span>
                    <?php endforeach; ?>
                    <span class="fg-blind-visualiser__coach-tip" data-fg-blind-coach-for="tilt">
                        <?php esc_html_e('Drag to tilt the slats', 'fenster'); ?>
                    </span>
                    <span class="fg-blind-visualiser__coach-tip" data-fg-blind-coach-for="lift">
                        <?php esc_html_e('Drag to raise and lower', 'fenster'); ?>
                    </span>
                </div>

                <div class="fg-blind-visualiser__a11y">
                    <label for="<?php echo esc_attr($section_id); ?>-tilt"><?php esc_html_e('Tilt the slats', 'fenster'); ?></label>
                    <?php /* 0 and 100 are both closed, 50 is edge on. That is
                             the real travel of the magnet: closed one way,
                             open, closed the other way. */ ?>
                    <input
                        type="range"
                        id="<?php echo esc_attr($section_id); ?>-tilt"
                        min="0"
                        max="100"
                        step="0.5"
                        value="78"
                        data-fg-blind-tilt
                    >
                    <label for="<?php echo esc_attr($section_id); ?>-lift"><?php esc_html_e('Raise or lower the blind', 'fenster'); ?></label>
                    <input
                        type="range"
                        id="<?php echo esc_attr($section_id); ?>-lift"
                        min="0"
                        max="100"
                        step="0.5"
                        value="0"
                        data-fg-blind-lift
                    >
                </div>
            </div>

            <p class="fg-blind-visualiser__readout" data-fg-blind-readout aria-live="polite"></p>

            <p class="fg-blind-visualiser__hint">
                <?php esc_html_e('Drag the two magnets on the frame inside the glass. The top one tilts the slats. The bottom one raises and lowers the blind.', 'fenster'); ?>
            </p>

            <div class="fg-blind-visualiser__colours" role="list" aria-label="<?php esc_attr_e('Notan slat colours', 'fenster'); ?>">
                <?php foreach ($colours as $index => $colour) : ?>
                    <?php
                    $name    = (string) ($colour['name'] ?? 'Slat colour');
                    $code    = (string) ($colour['code'] ?? '');
                    $hex     = (string) ($colour['hex'] ?? '#ffffff');
                    $reverse = (string) ($colour['reverse'] ?? '');
                    $active  = $index === $default_index;
                    ?>
                    <button
                        type="button"
                        role="listitem"
                        class="fg-blind-visualiser__colour<?php echo $active ? ' is-active' : ''; ?><?php echo ! empty($colour['glitter']) ? ' is-glitter' : ''; ?>"
                        style="<?php echo esc_attr('--swatch:' . $hex . ';--swatch-reverse:' . ($reverse !== '' ? $reverse : $hex)); ?>"
                        aria-pressed="<?php echo $active ? 'true' : 'false'; ?>"
                        data-fg-blind-colour="<?php echo esc_attr((string) $index); ?>"
                        data-hex="<?php echo esc_attr($hex); ?>"
                        <?php if ($reverse !== '') : ?>data-reverse="<?php echo esc_attr($reverse); ?>"<?php endif; ?>
                        <?php if (! empty($colour['metallic'])) : ?>data-metallic="1"<?php endif; ?>
                        <?php if (! empty($colour['glitter'])) : ?>data-glitter="1"<?php endif; ?>
                        data-name="<?php echo esc_attr($name); ?>"
                        data-code="<?php echo esc_attr($code); ?>"
                    >
                        <i aria-hidden="true"></i>
                        <?php /* White/Anthracite is the longest name and a
                                 slash is not a break opportunity, so it runs
                                 out of its chip without somewhere to wrap.
                                 Escaped first, then the marker is added, so
                                 the name itself is still never trusted. */ ?>
                        <span class="fg-blind-visualiser__colour-name"><?php echo str_replace('/', '/<wbr>', esc_html($name)); ?></span>
                        <?php if ($code !== '') : ?>
                            <span class="fg-blind-visualiser__colour-code"><?php echo esc_html($code); ?></span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <p class="fg-blind-visualiser__note">
                <?php esc_html_e('Nine standard Notan slat colours, plus bespoke RAL to order. White/Anthracite is white on the room side and anthracite outside, so the blind can match the room and the elevation at the same time.', 'fenster'); ?>
            </p>
        </div>
    </div>
</section>
