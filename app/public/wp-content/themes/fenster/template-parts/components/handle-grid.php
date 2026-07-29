<?php
/**
 * Handle finishes, the compact product-page grid.
 *
 * One component for all three handle families: S2 Signature on windows, the
 * long-plate on doors, and greenteQ Alpha TBT on tilt and turn. Same layout as
 * the uPVC colour grid, so a product page shows the finishes rather than
 * sending people to the hub to find out what they are.
 *
 * The hub uses handle-chooser.php instead, which is the full treatment.
 *
 * Args:
 *   data          array   the handle family (finishes, and anything else)
 *   id            string  section id, also the hub anchor to link to
 *   eyebrow|heading|intro|note
 *   alt_pattern   string  sprintf pattern, receives the finish name
 *   sub_label     bool    render the finish label under the name
 *   columns       string  modifier class for a non-default column count
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$handle_data = is_array($args['data'] ?? null) ? $args['data'] : [];
$finishes = is_array($handle_data['finishes'] ?? null) ? array_values($handle_data['finishes']) : [];

if (empty($finishes)) {
    return;
}

$section_id  = (string) ($args['id'] ?? 'handle-finishes');
$eyebrow     = (string) ($args['eyebrow'] ?? 'Handles');
$heading     = (string) ($args['heading'] ?? '');
$intro       = (string) ($args['intro'] ?? '');
$note        = (string) ($args['note'] ?? '');
$alt_pattern = (string) ($args['alt_pattern'] ?? '%s handle');
$sub_label   = ! empty($args['sub_label']);
$columns     = (string) ($args['columns'] ?? '');
$link_label  = (string) ($args['link_label'] ?? 'See the full handle specification');
$link_href   = (string) ($args['link_href'] ?? home_url('/window-handles/'));
$title_id    = 'fg-' . $section_id . '-title';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="fg-handle-finishes<?php echo $columns !== '' ? ' ' . esc_attr($columns) : ''; ?>" aria-labelledby="<?php echo esc_attr($title_id); ?>">
    <div class="container">
        <div class="fg-handle-finishes__heading">
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h2 id="<?php echo esc_attr($title_id); ?>"><?php echo esc_html($heading); ?></h2>
            <?php if ($intro !== '') : ?>
                <p><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </div>
        <ul class="fg-handle-finishes__grid">
            <?php foreach ($finishes as $finish) : ?>
                <?php
                $finish_name = (string) ($finish['name'] ?? '');
                /* The S2 labels are prefixed "Premium", which TONEOFVOICE.md rules
                   out. The rest of the label names the real finish method and is
                   worth keeping, so only the adjective is dropped. */
                $finish_label = preg_replace('/^Premium\s+/i', '', (string) ($finish['label'] ?? ''));
                ?>
                <li>
                    <?php if (! empty($finish['image'])) : ?>
                        <img src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>" alt="<?php echo esc_attr(sprintf($alt_pattern, $finish_name)); ?>" loading="lazy">
                    <?php endif; ?>
                    <strong><?php echo esc_html($finish_name); ?></strong>
                    <?php if ($sub_label && $finish_label !== '') : ?>
                        <span><?php echo esc_html($finish_label); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($note !== '') : ?>
            <p class="fg-handle-finishes__note">
                <?php echo esc_html($note); ?>
                <a class="fg-cw-link" href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_label); ?></a>
            </p>
        <?php endif; ?>
    </div>
</section>
