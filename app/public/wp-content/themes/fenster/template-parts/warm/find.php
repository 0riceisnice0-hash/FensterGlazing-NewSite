<?php
/**
 * Winter guide: the leak finder.
 *
 * The same window as the hero. Picking a spot, on the drawing or from the
 * list, opens a thermal lens over it and shows what is happening there, the
 * fix and what it costs. The spot positions come from
 * `fenster_warm_window_points()`, the same numbers the drawing is made from.
 *
 * Every spot's panel is in the markup, so with JavaScript off the section is
 * a readable list of all seven beside a plain drawing.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$find = (array) ($warm['find'] ?? []);
$spots = (array) ($find['spots'] ?? []);
$points = fenster_warm_window_points();

if ($spots === []) {
    return;
}

$first = (string) $spots[0]['key'];
$first_point = $points[$first] ?? ['x' => 240, 'y' => 257];
$renter_class = ['yes' => '', 'ask' => ' fg-warm-chip--ask', 'landlord' => ' fg-warm-chip--ask'];
?>
<section class="fg-warm-section fg-warm-find" id="find" aria-labelledby="fg-warm-find-title" data-fg-warm-find>
    <div class="container fg-warm-find__grid">
        <figure class="fg-warm-find__figure">
            <div class="fg-warm-find__stage" style="--fgw-x: <?php echo esc_attr(round($first_point['x'] / 4.8, 2)); ?>%; --fgw-y: <?php echo esc_attr(round($first_point['y'] / 6.2, 2)); ?>%;">
                <svg class="fg-warm-find__svg" viewBox="0 0 480 620" aria-hidden="true" focusable="false"><?php echo fenster_warm_window_scene('room', 'fgw-fr'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
                <svg class="fg-warm-find__svg fg-warm-find__lens" viewBox="0 0 480 620" aria-hidden="true" focusable="false"><?php echo fenster_warm_window_scene('thermal', 'fgw-ft'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
                <span class="fg-warm-find__ring" aria-hidden="true"></span>
                <?php foreach ($spots as $index => $spot) : ?>
                    <?php
                    $point = $points[$spot['key']] ?? null;
                    if ($point === null) {
                        continue;
                    }
                    ?>
                    <button class="fg-warm-find__spot<?php echo $index === 0 ? ' is-active' : ''; ?>" type="button" style="left: <?php echo esc_attr(round($point['x'] / 4.8, 2)); ?>%; top: <?php echo esc_attr(round($point['y'] / 6.2, 2)); ?>%;" data-fg-warm-spot="<?php echo esc_attr($spot['key']); ?>" data-x="<?php echo esc_attr(round($point['x'] / 4.8, 2)); ?>" data-y="<?php echo esc_attr(round($point['y'] / 6.2, 2)); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="fg-warm-find-panel-<?php echo esc_attr($spot['key']); ?>">
                        <span class="fg-warm-sr"><?php echo esc_html($spot['label']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <figcaption><?php echo esc_html($find['hint']); ?> <span><?php echo esc_html($warm['hero']['scope_note']); ?></span></figcaption>
        </figure>

        <div class="fg-warm-find__side">
            <div class="fg-warm-head">
                <p class="eyebrow"><?php echo esc_html($find['eyebrow']); ?></p>
                <h2 id="fg-warm-find-title"><?php echo esc_html($find['title']); ?></h2>
                <p><?php echo esc_html($find['intro']); ?></p>
            </div>

            <div class="fg-warm-find__picks" role="group" aria-label="<?php esc_attr_e('Where the draught is', 'fenster'); ?>">
                <?php foreach ($spots as $index => $spot) : ?>
                    <button class="fg-warm-find__pick<?php echo $index === 0 ? ' is-active' : ''; ?>" type="button" data-fg-warm-spot="<?php echo esc_attr($spot['key']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="fg-warm-find-panel-<?php echo esc_attr($spot['key']); ?>"><?php echo esc_html($spot['label']); ?></button>
                <?php endforeach; ?>
            </div>

            <div class="fg-warm-find__panels">
                <?php foreach ($spots as $index => $spot) : ?>
                    <article class="fg-warm-find__panel fg-warm-panel<?php echo $index === 0 ? ' is-active' : ''; ?>" id="fg-warm-find-panel-<?php echo esc_attr($spot['key']); ?>" data-fg-warm-spot-panel="<?php echo esc_attr($spot['key']); ?>">
                        <h3><?php echo esc_html($spot['title']); ?></h3>
                        <dl>
                            <div>
                                <dt><?php echo esc_html($find['labels']['what']); ?></dt>
                                <dd><?php echo esc_html($spot['what']); ?></dd>
                            </div>
                            <div>
                                <dt><?php echo esc_html($find['labels']['fix']); ?></dt>
                                <dd><?php echo esc_html($spot['fix']); ?></dd>
                            </div>
                        </dl>
                        <p class="fg-warm-find__meta">
                            <span class="fg-warm-chip fg-warm-chip--plain"><?php echo esc_html($spot['cost']); ?></span>
                            <span class="fg-warm-chip<?php echo esc_attr($renter_class[$spot['renter']] ?? ''); ?>"><?php echo esc_html($find['legend'][$spot['renter']] ?? ''); ?></span>
                            <span class="fg-warm-chip"><?php echo esc_html($find['legend'][$spot['heritage']] ?? ''); ?></span>
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>

            <p class="fg-warm-find__other">
                <strong><?php echo esc_html($find['other_windows']['label']); ?></strong>
                <?php echo esc_html($find['other_windows']['copy']); ?>
                <a href="<?php echo esc_url($find['other_windows']['url']); ?>"><?php echo esc_html($find['other_windows']['link_label']); ?></a>
            </p>
        </div>
    </div>
</section>
