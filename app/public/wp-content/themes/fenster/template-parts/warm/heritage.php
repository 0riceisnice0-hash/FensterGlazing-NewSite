<?php
/**
 * Winter guide: conservation areas and listed buildings.
 *
 * The one photograph on the page is here, because this is the section that
 * needs proving: a listed house in Winslow where the windows stayed and we
 * glazed them a second time. It is our own job, photographed the day it was
 * finished, and every word of the caption is from the case study record.
 *
 * The table is the general position in England and says so. The council
 * decides, and the copy sends the reader to the conservation officer.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$heritage = (array) ($warm['heritage'] ?? []);
$rows = (array) ($heritage['rows'] ?? []);

if ($rows === []) {
    return;
}

$proof = (array) $heritage['proof'];
$status_chip = ['yes' => '', 'ask' => ' fg-warm-chip--ask', 'consent' => ' fg-warm-chip--stop'];
?>
<section class="fg-warm-section fg-warm-heritage" id="conservation" aria-labelledby="fg-warm-heritage-title">
    <div class="container fg-warm-heritage__grid">
        <div class="fg-warm-heritage__main">
            <div class="fg-warm-head">
                <p class="eyebrow"><?php echo esc_html($heritage['eyebrow']); ?></p>
                <h2 id="fg-warm-heritage-title"><?php echo esc_html($heritage['title']); ?></h2>
                <p><?php echo esc_html($heritage['intro']); ?></p>
            </div>

            <div class="fg-warm-heritage__table fg-warm-panel">
                <table>
                    <caption class="fg-warm-sr"><?php echo esc_html($heritage['eyebrow']); ?></caption>
                    <thead>
                        <tr>
                            <td></td>
                            <?php foreach ((array) $heritage['columns'] as $column) : ?>
                                <th scope="col"><?php echo esc_html($column); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html($row['label']); ?></th>
                                <?php foreach ((array) $row['cells'] as $index => $cell) : ?>
                                    <td data-label="<?php echo esc_attr($heritage['columns'][$index] ?? ''); ?>">
                                        <span class="fg-warm-chip<?php echo esc_attr($status_chip[$cell['status']] ?? ''); ?>"><?php echo esc_html($heritage['status_labels'][$cell['status']] ?? ''); ?></span>
                                        <span class="fg-warm-heritage__cell"><?php echo esc_html($cell['copy']); ?></span>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="fg-warm-heritage__foot">
                <p class="fg-warm-source"><?php echo esc_html($heritage['disclaimer']); ?></p>
                <?php echo fenster_warm_source_line($warm, ...(array) $heritage['general_sources']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>

        <div class="fg-warm-heritage__side">
            <figure class="fg-warm-heritage__proof">
                <a class="fg-warm-heritage__photo" href="<?php echo esc_url($proof['url']); ?>" aria-labelledby="fg-warm-heritage-proof-title">
                    <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . $proof['image'], ['alt' => (string) $proof['alt'], 'loading' => 'lazy', 'sizes' => '(max-width: 860px) 100vw, 440px']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                </a>
                <figcaption>
                    <h3 id="fg-warm-heritage-proof-title"><?php echo esc_html($proof['title']); ?></h3>
                    <p><?php echo esc_html($proof['copy']); ?></p>
                    <a href="<?php echo esc_url($proof['url']); ?>"><?php echo esc_html($proof['link_label']); ?></a>
                </figcaption>
            </figure>
            <div class="fg-warm-heritage__local">
                <p><?php echo esc_html($heritage['local']); ?></p>
                <?php echo fenster_warm_source_line($warm, $heritage['local_source']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>
    </div>
</section>
