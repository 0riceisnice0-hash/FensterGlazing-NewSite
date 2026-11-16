<?php
/**
 * Winter guide: every fix, side by side.
 *
 * A real table, because that is what it is and because a table is what a
 * search engine or an assistant can lift an answer from. The filters only hide
 * rows; with JavaScript off the whole table shows.
 *
 * THE "MEASURED" COLUMN IS THE POINT OF THE TABLE. Where a test exists it
 * gives the figure and links the test; where none does it says "Not measured"
 * instead of repeating the percentages that circulate. See the notes at the
 * top of inc/warm-guide-data.php.
 *
 * This section runs taller than one viewport on purpose: STYLE.md allows it
 * for a comparison table, and fourteen rows are the content.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$fixes = (array) ($warm['fixes'] ?? []);
$rows = (array) ($fixes['rows'] ?? []);

if ($rows === []) {
    return;
}

$tag_labels = [];
foreach ((array) $fixes['filters'] as $filter) {
    $tag_labels[$filter['key']] = $filter['label'];
}
?>
<section class="fg-warm-section fg-warm-fixes" id="fixes" aria-labelledby="fg-warm-fixes-title" data-fg-warm-fixes>
    <div class="container">
        <div class="fg-warm-fixes__top">
            <div class="fg-warm-head">
                <p class="eyebrow"><?php echo esc_html($fixes['eyebrow']); ?></p>
                <h2 id="fg-warm-fixes-title"><?php echo esc_html($fixes['title']); ?></h2>
                <p><?php echo esc_html($fixes['intro']); ?></p>
            </div>
            <div class="fg-warm-fixes__filters" role="group" aria-label="<?php esc_attr_e('Show fixes for', 'fenster'); ?>">
                <?php foreach ((array) $fixes['filters'] as $index => $filter) : ?>
                    <button class="fg-warm-fixes__filter<?php echo $index === 0 ? ' is-active' : ''; ?>" type="button" data-fg-warm-filter="<?php echo esc_attr($filter['key']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"><?php echo esc_html($filter['label']); ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="fg-warm-fixes__table fg-warm-panel">
            <table>
                <caption class="fg-warm-sr"><?php echo esc_html($fixes['eyebrow']); ?></caption>
                <thead>
                    <tr>
                        <?php foreach ((array) $fixes['columns'] as $column) : ?>
                            <th scope="col"><?php echo esc_html($column); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr data-fg-warm-tags="<?php echo esc_attr(implode(' ', (array) $row['tags'])); ?>">
                            <th scope="row">
                                <?php if (! empty($row['url'])) : ?>
                                    <a href="<?php echo esc_url($row['url']); ?>"><?php echo esc_html($row['fix']); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($row['fix']); ?>
                                <?php endif; ?>
                            </th>
                            <td data-label="<?php echo esc_attr($fixes['columns'][1]); ?>"><span class="fg-warm-fixes__on fg-warm-fixes__on--<?php echo esc_attr($row['on']); ?>"><?php echo esc_html($fixes['on_labels'][$row['on']] ?? ''); ?></span></td>
                            <td data-label="<?php echo esc_attr($fixes['columns'][2]); ?>"><?php echo esc_html($row['cost']); ?></td>
                            <td data-label="<?php echo esc_attr($fixes['columns'][3]); ?>" class="<?php echo $row['source'] !== '' ? 'fg-warm-fixes__measured' : 'fg-warm-fixes__unmeasured'; ?>">
                                <?php echo esc_html($row['measured']); ?>
                                <?php if ($row['source'] !== '' && isset($warm['sources'][$row['source']])) : ?>
                                    <a class="fg-warm-fixes__ref" href="<?php echo esc_url($warm['sources'][$row['source']]['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($warm['sources'][$row['source']]['short']); ?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="fg-warm-fixes__empty" hidden><?php echo esc_html($fixes['empty']); ?></p>
        </div>

        <div class="fg-warm-fixes__notes">
            <p><?php echo esc_html($fixes['film_note']); ?></p>
            <div>
                <?php echo fenster_warm_source_line($warm, $fixes['film_source'], 'tp1', 'part-l'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <p class="fg-warm-source"><?php echo esc_html($fixes['price_note']); ?></p>
            </div>
        </div>
    </div>
</section>
