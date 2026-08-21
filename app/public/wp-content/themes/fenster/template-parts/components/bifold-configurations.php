<?php
/**
 * Sheerline Prestige bi-fold: swipe the layouts, jump by pane count.
 *
 * NOT A CONFIGURATOR, and the distinction is the one the uPVC door randomiser
 * relies on: it never pretends to quote. It shows the manufacturer's own
 * published configuration renders and hands over to WindowCAD for a price,
 * exactly as the heritage window bar layouts do. Three home-built
 * configurators have been removed from this site on sight because they
 * competed with the tool that both configures AND prices. Do not add pricing,
 * dimensions you can type into, or a drawn door here.
 *
 * ONE RAIL, NOT SEVEN PANELS. The first build gave each pane count its own
 * tab panel, which left a lone third card beside half an empty row and made
 * the doors read as floating in oversized plates. The rail fixes both: every
 * card is the same size, they sit next to each other, and the door visibly
 * grows as you swipe. The pane-count buttons are a jump control into the rail
 * rather than a separate switcher, so there is one interaction and one state.
 * This is the `.fg-colour-rail` model the owner approved on 2026-07-29 for the
 * colour hub: equal cards, next one visibly cut, native scroll, drag for a
 * mouse, and a position counter because a rail with no affordance does not say
 * how much more there is.
 *
 * THE RENDERS WERE RE-SCALED AND KEYED BEFORE USE, and both are worth knowing.
 * Sheerline draw the six and seven pane configurations at about 77% of the
 * two-to-five pane ones so the wider doors fit the same 1024px canvas: the
 * door frame measures 443px tall in one group and 340px in the other. A door's
 * height does not change with its pane count, so dropped in as supplied a
 * seven pane door renders SHORTER than a three pane one. Every render is
 * scaled so the frame measures the same height, then composited bottom-aligned
 * and centred through ONE shared window. Relative widths are truthful as a
 * result, which is the whole argument the rail makes.
 *
 * The canvas grey was then keyed to transparency by FLOOD FILL from the
 * borders rather than by a global colour match, because the glass is nearly
 * the same grey as the background and a global key punches holes through every
 * pane. That is what lets them sit on the dark band and read as lit studio
 * product, the same treatment the casement and tilt and turn plates use.
 *
 * Do not re-trim these individually. Same rule as the heritage door
 * configurations, the tilt and turn handles and the Mila patio set.
 *
 * Data and full provenance in `bifold_configurations` in inc/site-data.php.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$bifold_config = fenster_data('bifold_configurations', []);
$bifold_counts = is_array($bifold_config['counts'] ?? null) ? $bifold_config['counts'] : [];

if ($bifold_counts === []) {
    return;
}

/* The buttons read the counts; the rail reads one flat list built from the
   same array, so the two cannot drift apart. */
$bifold_slides = [];

foreach ($bifold_counts as $count) {
    $panes = (int) ($count['panes'] ?? 0);
    $max_width = (int) ($count['max_width_mm'] ?? 0);
    $configs = is_array($count['configs'] ?? null) ? $count['configs'] : [];

    if ($panes < 2 || $configs === []) {
        continue;
    }

    foreach ($configs as $index => $config) {
        $code = trim((string) ($config['code'] ?? ''));

        if ($code === '') {
            continue;
        }

        $bifold_slides[] = [
            'panes'     => $panes,
            'max_width' => $max_width,
            'code'      => $code,
            'name'      => trim((string) ($config['name'] ?? '')),
            'copy'      => trim((string) ($config['copy'] ?? '')),
            'first'     => $index === 0,
        ];
    }
}

if ($bifold_slides === []) {
    return;
}

$bifold_total = count($bifold_slides);
?>
<section class="fg-bfc" aria-labelledby="fg-bfc-title">
    <div class="container fg-bfc__inner">
        <div class="fg-bfc__head">
            <p class="eyebrow"><?php esc_html_e('Configurations', 'fenster'); ?></p>
            <h2 id="fg-bfc-title"><?php esc_html_e('How many panes, and which way they fold.', 'fenster'); ?></h2>
            <p><?php esc_html_e('A bi-fold runs from two panes up to seven. They can all fold to one side, or split and open from the middle, and most layouts can carry a traffic door.', 'fenster'); ?></p>
            <?php if (! empty($bifold_config['traffic_door'])) : ?>
                <p class="fg-bfc__aside"><?php echo esc_html((string) $bifold_config['traffic_door']); ?></p>
            <?php endif; ?>
        </div>

        <?php
        /* The controls ship hidden and the controller reveals them. Without
           JavaScript the rail is still a native horizontal scroller and every
           layout is readable and indexable, so nothing is locked behind a
           control that cannot move. */
        ?>
        <div class="fg-bfc__controls" data-fg-bifold-controls hidden>
            <div class="fg-bfc__jumps" role="group" aria-label="<?php esc_attr_e('Jump to a pane count', 'fenster'); ?>">
                <?php foreach ($bifold_counts as $count) : ?>
                    <?php
                    $panes = (int) ($count['panes'] ?? 0);

                    if ($panes < 2) {
                        continue;
                    }
                    ?>
                    <button
                        type="button"
                        class="fg-bfc__jump"
                        data-fg-bifold-jump="<?php echo esc_attr((string) $panes); ?>"
                        aria-pressed="false"
                        aria-label="<?php echo esc_attr(sprintf(
                            /* translators: %d: number of panes. */
                            __('Jump to %d pane layouts', 'fenster'),
                            $panes
                        )); ?>"
                    ><?php echo esc_html((string) $panes); ?></button>
                <?php endforeach; ?>
                <span class="fg-bfc__jumps-label"><?php esc_html_e('panes', 'fenster'); ?></span>
            </div>

            <p class="fg-bfc__counter" data-fg-bifold-counter aria-live="polite">
                <span data-fg-bifold-position>01</span>
                <span class="fg-bfc__counter-sep">/</span>
                <span><?php echo esc_html(sprintf('%02d', $bifold_total)); ?></span>
            </p>
        </div>
    </div>

    <?php
    /* The rail breaks out of the container so a card can bleed off the right
       edge of the viewport. That cut card is the swipe affordance. */
    ?>
    <div class="fg-bfc__rail" data-fg-bifold-rail tabindex="0" role="group" aria-label="<?php esc_attr_e('Bi-fold configurations', 'fenster'); ?>">
        <ul class="fg-bfc__track">
            <?php foreach ($bifold_slides as $index => $slide) : ?>
                <?php
                $file = 'bifold-' . str_replace('/', '-', $slide['code']) . '.webp';
                $alt = sprintf(
                    /* translators: 1: configuration code such as 4/3/1. 2: what the layout does. */
                    __('Sheerline Prestige bi-fold in a %1$s layout, folded open. %2$s', 'fenster'),
                    $slide['code'],
                    $slide['copy']
                );
                ?>
                <li
                    class="fg-bfc__slide"
                    data-fg-bifold-slide="<?php echo esc_attr((string) $index); ?>"
                    data-panes="<?php echo esc_attr((string) $slide['panes']); ?>"
                    <?php echo $slide['first'] ? 'data-first-of-count="' . esc_attr((string) $slide['panes']) . '"' : ''; ?>
                >
                    <figure class="fg-bfc__stage">
                        <img <?php echo fenster_image_attr_string(
                            '/wp-content/themes/fenster/assets/images/products/sheerline-bifold/' . $file,
                            ['alt' => $alt, 'loading' => 'lazy']
                        ); ?>>
                    </figure>

                    <div class="fg-bfc__meta">
                        <p class="fg-bfc__code"><?php echo esc_html($slide['code']); ?></p>
                        <?php if ($slide['name'] !== '') : ?>
                            <h3 class="fg-bfc__name"><?php echo esc_html($slide['name']); ?></h3>
                        <?php endif; ?>
                        <?php if ($slide['copy'] !== '') : ?>
                            <p class="fg-bfc__copy"><?php echo esc_html($slide['copy']); ?></p>
                        <?php endif; ?>
                        <p class="fg-bfc__width">
                            <?php
                            /* No thousands separator. A width is written 6500mm
                               by everyone who prices work, and it is how
                               Sheerline publish it; "6,500mm" reads as a typo. */
                            echo esc_html(sprintf(
                                /* translators: 1: number of panes. 2: maximum width in millimetres. */
                                __('%1$d panes, up to %2$dmm wide', 'fenster'),
                                $slide['panes'],
                                $slide['max_width']
                            ));
                            ?>
                        </p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container fg-bfc__inner">
        <div class="fg-bfc__foot">
            <?php if (! empty($bifold_config['note'])) : ?>
                <p class="fg-bfc__note"><?php echo esc_html((string) $bifold_config['note']); ?></p>
            <?php endif; ?>
            <a class="button" href="#fenster-product-quote"><?php esc_html_e('Design and price it', 'fenster'); ?></a>
        </div>
    </div>
</section>
