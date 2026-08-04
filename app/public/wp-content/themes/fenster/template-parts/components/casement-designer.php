<?php
/**
 * Casement designer: draw the window the customer is describing.
 *
 * The page it sits on sells a made-to-measure product. Sixteen foils against
 * six layouts, three glazing-bar treatments, horns on or off, six handle
 * finishes, two interior faces and a continuous size is tens of thousands of
 * combinations, which is far past what a photograph set can hold. That is the
 * test a configurator has to pass on this site, and it is the same argument
 * already accepted for the Notan blind on /integral-blinds/.
 *
 * 2D canvas, no library, and face-on for the same reason the blind is: with no
 * perspective a hinged sash projects to an exact quadrilateral, so the
 * geometry is calculated rather than approximated. See the Three.js / Canvas
 * Rule in AI.md before changing that.
 *
 * Every value a customer can see comes from inc/site-data.php: the foils from
 * colour_options, the handle finishes from window_handles. Nothing here is a
 * hex written into a template. See the Swatch Provenance Rule in AI.md.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$designer_colours = fenster_data('colour_options.materials.upvc.colours', []);
$designer_colours = is_array($designer_colours) ? $designer_colours : [];

$designer_handles = fenster_data('window_handles.finishes', []);
$designer_handles = is_array($designer_handles) ? $designer_handles : [];

// Without either source there is nothing honest to draw, so the section does
// not render at all rather than falling back to invented values.
if (empty($designer_colours) || empty($designer_handles)) {
    return;
}

$quote_url = (string) ($args['quote_url'] ?? '');
$fallback_image = '/wp-content/themes/fenster/assets/images/products/casement/casement-cranfield-1400w.webp';

/* Layout keys are matched by the controller, which owns the cell geometry.
   Labels and descriptions stay here so they are translatable and so the copy
   lives with the rest of the page's words. */
$designer_layouts = [
    ['key' => 'single', 'name' => 'Single opener', 'note' => 'One side-hung sash.'],
    ['key' => 'two-side', 'name' => 'Two openers', 'note' => 'A pair of side-hung sashes on a mullion.'],
    ['key' => 'three-light', 'name' => 'Three light', 'note' => 'Fixed centre pane, an opener each side.'],
    ['key' => 'top-over-fixed', 'name' => 'Top light over fixed', 'note' => 'A top-hung sash above a fixed pane.'],
    ['key' => 'cottage', 'name' => 'Cottage', 'note' => 'Two top lights over two side-hung sashes.'],
    ['key' => 'fixed', 'name' => 'Fixed pane', 'note' => 'No hinges, no handle, the most glass.'],
];

$designer_bars = [
    ['key' => 'none', 'name' => 'No bars', 'note' => 'Clear glass, the slimmest look the system makes.'],
    ['key' => 'georgian', 'name' => 'Georgian bars', 'note' => 'Set inside the sealed unit, so the glass still wipes clean as one pane.'],
    ['key' => 'astragal', 'name' => 'Astragal bars', 'note' => 'Bonded to the face of the glass, so they catch the light and cast a shadow.'],
];
?>
<section id="casement-designer" class="fg-cwd" aria-labelledby="fg-cwd-title">
    <div class="container">
        <div class="fg-cwd__head">
            <div>
                <p class="eyebrow"><?php esc_html_e('Design it here', 'fenster'); ?></p>
                <h2 id="fg-cwd-title"><?php esc_html_e('Build your casement and watch it change.', 'fenster'); ?></h2>
            </div>
            <p><?php esc_html_e('Every window we make is drawn before it is built. This is the same set of decisions, in the same order, with the drawing keeping up. Nothing here is a stock photograph.', 'fenster'); ?></p>
        </div>

        <div class="fg-cwd__panel" data-fg-casement-designer>
            <div class="fg-cwd__stage">
                <figure class="fg-cwd__canvas-wrap">
                    <?php
                    /* The photograph is what shows until the controller has a
                       context and a first frame, so a thrown error degrades to
                       a real casement window rather than to an empty box. This
                       is the same guard the blind visualiser uses. */
                    ?>
                    <img
                        class="fg-cwd__fallback"
                        src="<?php echo esc_url(fenster_generated_url($fallback_image)); ?>"
                        alt="<?php esc_attr_e('White uPVC casement window with a top opening light and a fixed pane, fitted by Fenster in Cranfield', 'fenster'); ?>"
                        width="1400" height="1050" loading="lazy">
                    <canvas class="fg-cwd__canvas" data-fg-cwd-canvas role="img" aria-label="<?php esc_attr_e('Drawing of the casement window you have specified', 'fenster'); ?>"></canvas>
                </figure>
                <p class="fg-cwd__readout" data-fg-cwd-readout aria-live="polite"></p>
            </div>

            <div class="fg-cwd__controls">
                <div class="fg-cwd__group">
                    <p class="fg-cwd__label" id="fg-cwd-layout-label"><?php esc_html_e('Layout', 'fenster'); ?></p>
                    <div class="fg-cwd__choices fg-cwd__choices--layout" role="group" aria-labelledby="fg-cwd-layout-label">
                        <?php foreach ($designer_layouts as $index => $layout) : ?>
                            <button type="button" class="fg-cwd__choice" data-fg-cwd-layout="<?php echo esc_attr($layout['key']); ?>" data-note="<?php echo esc_attr($layout['note']); ?>" aria-pressed="<?php echo $index === 2 ? 'true' : 'false'; ?>">
                                <span class="fg-cwd__choice-mark" aria-hidden="true" data-fg-cwd-layout-mark="<?php echo esc_attr($layout['key']); ?>"></span>
                                <span><?php echo esc_html($layout['name']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fg-cwd__group">
                    <p class="fg-cwd__label" id="fg-cwd-colour-label"><?php esc_html_e('Outside colour', 'fenster'); ?></p>
                    <div class="fg-cwd__swatches" role="group" aria-labelledby="fg-cwd-colour-label">
                        <?php foreach ($designer_colours as $index => $colour) : ?>
                            <?php
                            $colour_name = (string) ($colour['name'] ?? '');
                            $colour_hex = (string) ($colour['hex'] ?? '#ffffff');
                            $colour_finish = (string) ($colour['finish'] ?? '');
                            if ($colour_name === '') {
                                continue;
                            }
                            $colour_title = $colour_finish !== '' ? $colour_name . ', ' . $colour_finish : $colour_name;
                            ?>
                            <button
                                type="button"
                                class="fg-cwd__swatch"
                                data-fg-cwd-colour="<?php echo esc_attr($colour_hex); ?>"
                                data-colour-name="<?php echo esc_attr($colour_name); ?>"
                                data-colour-finish="<?php echo esc_attr($colour_finish); ?>"
                                style="--cwd-swatch: <?php echo esc_attr($colour_hex); ?>;"
                                aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                title="<?php echo esc_attr($colour_title); ?>">
                                <span class="screen-reader-only"><?php echo esc_html($colour_title); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="fg-cwd__hint" data-fg-cwd-colour-name></p>
                </div>

                <div class="fg-cwd__group">
                    <p class="fg-cwd__label" id="fg-cwd-bars-label"><?php esc_html_e('Glazing bars', 'fenster'); ?></p>
                    <div class="fg-cwd__choices" role="group" aria-labelledby="fg-cwd-bars-label">
                        <?php foreach ($designer_bars as $index => $bar) : ?>
                            <button type="button" class="fg-cwd__choice" data-fg-cwd-bars="<?php echo esc_attr($bar['key']); ?>" data-note="<?php echo esc_attr($bar['note']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                <span class="fg-cwd__choice-mark" aria-hidden="true" data-fg-cwd-bar-mark="<?php echo esc_attr($bar['key']); ?>"></span>
                                <span><?php echo esc_html($bar['name']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fg-cwd__group">
                    <p class="fg-cwd__label" id="fg-cwd-handle-label"><?php esc_html_e('Handle finish', 'fenster'); ?></p>
                    <div class="fg-cwd__swatches fg-cwd__swatches--handles" role="group" aria-labelledby="fg-cwd-handle-label">
                        <?php foreach ($designer_handles as $index => $handle) : ?>
                            <?php
                            $handle_name = (string) ($handle['name'] ?? '');
                            $handle_hex = (string) ($handle['hex'] ?? '#cccccc');
                            if ($handle_name === '') {
                                continue;
                            }
                            ?>
                            <button
                                type="button"
                                class="fg-cwd__swatch fg-cwd__swatch--handle"
                                data-fg-cwd-handle="<?php echo esc_attr($handle_hex); ?>"
                                data-handle-name="<?php echo esc_attr($handle_name); ?>"
                                style="--cwd-swatch: <?php echo esc_attr($handle_hex); ?>;"
                                aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                title="<?php echo esc_attr($handle_name); ?>">
                                <span class="screen-reader-only"><?php echo esc_html($handle_name); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fg-cwd__group fg-cwd__group--sizes">
                    <p class="fg-cwd__label"><?php esc_html_e('Size', 'fenster'); ?></p>
                    <div class="fg-cwd__slider">
                        <label for="fg-cwd-width"><?php esc_html_e('Width', 'fenster'); ?> <output data-fg-cwd-width-out>1500mm</output></label>
                        <input id="fg-cwd-width" type="range" min="500" max="3000" step="50" value="1500" data-fg-cwd-width>
                    </div>
                    <div class="fg-cwd__slider">
                        <label for="fg-cwd-height"><?php esc_html_e('Height', 'fenster'); ?> <output data-fg-cwd-height-out>1200mm</output></label>
                        <input id="fg-cwd-height" type="range" min="400" max="2100" step="50" value="1200" data-fg-cwd-height>
                    </div>
                </div>

                <div class="fg-cwd__toggles">
                    <button type="button" class="fg-cwd__toggle" data-fg-cwd-open aria-pressed="false"><?php esc_html_e('Open the sashes', 'fenster'); ?></button>
                    <button type="button" class="fg-cwd__toggle" data-fg-cwd-horns aria-pressed="false"><?php esc_html_e('Mock sash horns', 'fenster'); ?></button>
                    <button type="button" class="fg-cwd__toggle" data-fg-cwd-obscure aria-pressed="false"><?php esc_html_e('Obscure glass', 'fenster'); ?></button>
                    <button type="button" class="fg-cwd__toggle" data-fg-cwd-inside aria-pressed="false"><?php esc_html_e('View from inside', 'fenster'); ?></button>
                    <button type="button" class="fg-cwd__toggle" data-fg-cwd-match aria-pressed="false"><?php esc_html_e('Match colour inside', 'fenster'); ?></button>
                </div>

                <p class="fg-cwd__note" data-fg-cwd-note></p>

                <div class="fg-cwd__actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Price this window', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--steel" href="#fenster-enquiry"><?php esc_html_e('Send us the spec', 'fenster'); ?></a>
                </div>
            </div>
        </div>

        <p class="fg-cwd__foot"><?php esc_html_e('Drawn to proportion from the sculptured 70mm profile we fit, in the sixteen foils and six handle finishes we actually stock. Colours on a screen are a guide; the real foils are photographed further down this page.', 'fenster'); ?></p>
    </div>
</section>
