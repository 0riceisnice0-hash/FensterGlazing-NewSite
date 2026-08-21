<?php
/**
 * Sheerline Prestige bi-fold: pick a pane count, see the layouts it comes in.
 *
 * NOT A CONFIGURATOR, and the distinction is the one the uPVC door randomiser
 * relies on: it never pretends to quote. It shows the manufacturer's own
 * published configuration renders grouped by pane count and hands over to
 * WindowCAD for a price, exactly as the heritage window bar layouts do. Three
 * home-built configurators have been removed from this site on sight (the
 * casement canvas, the heritage bar planner, and the composite wall before
 * them) because they competed with the tool that both configures AND prices.
 * Do not add pricing, dimensions you can type into, or a drawn door here.
 *
 * THE RENDERS WERE RE-SCALED BEFORE THEY WERE USED, and this is the part worth
 * knowing. Sheerline draw the six and seven pane configurations at about 77% of
 * the one-to-five pane ones so the wider doors fit the same 1024px canvas. A
 * door's height does not change with its pane count, so dropped in as supplied
 * a seven pane door renders SHORTER than a three pane one. Every render was
 * therefore scaled so the outer frame measures the same height, then
 * composited bottom-aligned and centred through ONE shared window. Relative
 * widths are truthful as a result: the panes visibly narrow at six and seven,
 * which is real, because Sheerline cap both at 6500mm.
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

/* Four is the default because it is the commonest domestic bi-fold and it is
   what Sheerline lead their own product page with. */
$bifold_default = 4;

$bifold_asset = static function (string $file): string {
    return '/wp-content/themes/fenster/assets/images/products/sheerline-bifold-configurations/' . $file;
};

$bifold_slug = static function (string $code): string {
    return str_replace('/', '-', $code);
};
?>
<section class="fg-bfc" aria-labelledby="fg-bfc-title">
    <div class="container">
        <div class="fg-bfc__head">
            <p class="eyebrow"><?php esc_html_e('Configurations', 'fenster'); ?></p>
            <h2 id="fg-bfc-title"><?php esc_html_e('How many panes, and which way they fold.', 'fenster'); ?></h2>
            <p><?php esc_html_e('A bi-fold runs from a single door up to seven panes. They can all fold to one side, or split and open from the middle, and most layouts can carry a traffic door.', 'fenster'); ?></p>
            <?php if (! empty($bifold_config['traffic_door'])) : ?>
                <p><?php echo esc_html((string) $bifold_config['traffic_door']); ?></p>
            <?php endif; ?>
        </div>

        <?php
        /* The picker ships hidden and the controller reveals it. Without
           JavaScript every pane count stays on the page under its own heading,
           so all nineteen layouts are readable and indexable rather than
           locked behind a control that cannot move. */
        ?>
        <div class="fg-bfc__picker" role="tablist" aria-label="<?php esc_attr_e('Number of panes', 'fenster'); ?>" data-fg-bifold-picker hidden>
            <?php foreach ($bifold_counts as $count) : ?>
                <?php
                $panes = (int) ($count['panes'] ?? 0);
                if ($panes < 1) {
                    continue;
                }
                $is_default = $panes === $bifold_default;
                ?>
                <button
                    type="button"
                    role="tab"
                    id="fg-bfc-tab-<?php echo esc_attr((string) $panes); ?>"
                    class="fg-bfc__tab"
                    aria-controls="fg-bfc-panel-<?php echo esc_attr((string) $panes); ?>"
                    aria-selected="<?php echo $is_default ? 'true' : 'false'; ?>"
                    tabindex="<?php echo $is_default ? '0' : '-1'; ?>"
                    data-fg-bifold-tab="<?php echo esc_attr((string) $panes); ?>"
                    <?php
                    /* The accessible name is set explicitly rather than left to
                       the two spans, because the label shrinks hard at narrow
                       widths and "4" on its own names nothing. */
                    ?>
                    aria-label="<?php echo esc_attr($panes === 1
                        ? __('Single door', 'fenster')
                        : sprintf(
                            /* translators: %s: number of panes. */
                            __('%s panes', 'fenster'),
                            number_format_i18n($panes)
                        )); ?>"
                >
                    <span class="fg-bfc__tab-count"><?php echo esc_html((string) $panes); ?></span>
                    <span class="fg-bfc__tab-label"><?php echo esc_html($panes === 1 ? __('Single', 'fenster') : __('panes', 'fenster')); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="fg-bfc__panels">
            <?php foreach ($bifold_counts as $count) : ?>
                <?php
                $panes = (int) ($count['panes'] ?? 0);
                $configs = is_array($count['configs'] ?? null) ? $count['configs'] : [];
                $max_width = (int) ($count['max_width_mm'] ?? 0);

                if ($panes < 1 || $configs === []) {
                    continue;
                }

                $panel_title = $panes === 1
                    ? sprintf(
                        /* translators: %s: maximum width in millimetres. */
                        __('A single door, up to %smm wide.', 'fenster'),
                        number_format_i18n($max_width)
                    )
                    : sprintf(
                        /* translators: 1: number of panes. 2: maximum width in millimetres. */
                        __('%1$s panes, up to %2$smm wide.', 'fenster'),
                        number_format_i18n($panes),
                        number_format_i18n($max_width)
                    );
                ?>
                <div
                    class="fg-bfc__panel"
                    role="tabpanel"
                    id="fg-bfc-panel-<?php echo esc_attr((string) $panes); ?>"
                    aria-labelledby="fg-bfc-tab-<?php echo esc_attr((string) $panes); ?>"
                    tabindex="0"
                    data-fg-bifold-panel="<?php echo esc_attr((string) $panes); ?>"
                >
                    <h3 class="fg-bfc__panel-title"><?php echo esc_html($panel_title); ?></h3>

                    <ul class="fg-bfc__grid" data-count="<?php echo esc_attr((string) count($configs)); ?>">
                        <?php foreach ($configs as $config) : ?>
                            <?php
                            $code = trim((string) ($config['code'] ?? ''));
                            $name = trim((string) ($config['name'] ?? ''));
                            $copy = trim((string) ($config['copy'] ?? ''));

                            if ($code === '') {
                                continue;
                            }

                            $file = 'bifold-config-' . $bifold_slug($code) . '.webp';
                            $alt = sprintf(
                                /* translators: 1: configuration code such as 4/3/1. 2: what the layout does. */
                                __('Sheerline Prestige bi-fold in a %1$s layout, folded open. %2$s', 'fenster'),
                                $code,
                                $copy
                            );
                            ?>
                            <li class="fg-bfc__card">
                                <figure class="fg-bfc__plate">
                                    <img <?php echo fenster_image_attr_string($bifold_asset($file), [
                                        'alt' => $alt,
                                        'loading' => 'lazy',
                                    ]); ?>>
                                </figure>
                                <p class="fg-bfc__code"><?php echo esc_html($code); ?></p>
                                <?php if ($name !== '') : ?>
                                    <p class="fg-bfc__name"><?php echo esc_html($name); ?></p>
                                <?php endif; ?>
                                <?php if ($copy !== '') : ?>
                                    <p class="fg-bfc__copy"><?php echo esc_html($copy); ?></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="fg-bfc__foot">
            <?php if (! empty($bifold_config['note'])) : ?>
                <p class="fg-bfc__note"><?php echo esc_html((string) $bifold_config['note']); ?></p>
            <?php endif; ?>
            <a class="button" href="#fenster-product-quote"><?php esc_html_e('Design and price it', 'fenster'); ?></a>
        </div>
    </div>
</section>
