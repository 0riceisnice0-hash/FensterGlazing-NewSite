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
            </div>

            <p class="fg-blind-visualiser__readout" data-fg-blind-readout aria-live="polite"></p>

            <div class="fg-blind-visualiser__controls">
                <div class="fg-blind-visualiser__slider">
                    <label for="<?php echo esc_attr($section_id); ?>-tilt"><?php esc_html_e('Tilt', 'fenster'); ?></label>
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
                    <span class="fg-blind-visualiser__scale" aria-hidden="true">
                        <em><?php esc_html_e('Closed', 'fenster'); ?></em>
                        <em><?php esc_html_e('Open', 'fenster'); ?></em>
                        <em><?php esc_html_e('Closed', 'fenster'); ?></em>
                    </span>
                </div>

                <div class="fg-blind-visualiser__slider">
                    <label for="<?php echo esc_attr($section_id); ?>-lift"><?php esc_html_e('Height', 'fenster'); ?></label>
                    <input
                        type="range"
                        id="<?php echo esc_attr($section_id); ?>-lift"
                        min="0"
                        max="100"
                        step="0.5"
                        value="0"
                        data-fg-blind-lift
                    >
                    <span class="fg-blind-visualiser__scale fg-blind-visualiser__scale--pair" aria-hidden="true">
                        <em><?php esc_html_e('Down', 'fenster'); ?></em>
                        <em><?php esc_html_e('Raised', 'fenster'); ?></em>
                    </span>
                </div>
            </div>

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
                        class="fg-blind-visualiser__colour<?php echo $active ? ' is-active' : ''; ?>"
                        style="<?php echo esc_attr('--swatch:' . $hex . ';--swatch-reverse:' . ($reverse !== '' ? $reverse : $hex)); ?>"
                        aria-pressed="<?php echo $active ? 'true' : 'false'; ?>"
                        data-fg-blind-colour="<?php echo esc_attr((string) $index); ?>"
                        data-hex="<?php echo esc_attr($hex); ?>"
                        <?php if ($reverse !== '') : ?>data-reverse="<?php echo esc_attr($reverse); ?>"<?php endif; ?>
                        <?php if (! empty($colour['metallic'])) : ?>data-metallic="1"<?php endif; ?>
                        data-name="<?php echo esc_attr($name); ?>"
                        data-code="<?php echo esc_attr($code); ?>"
                    >
                        <i aria-hidden="true"></i>
                        <span class="fg-blind-visualiser__colour-name"><?php echo esc_html($name); ?></span>
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
