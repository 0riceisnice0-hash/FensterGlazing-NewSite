<?php
/**
 * Window handle finishes.
 *
 * Same layout as the uPVC colour grid, so a product page shows the finishes
 * instead of sending people to the handle hub to find out what they are.
 *
 * Window handles only. Doors take different hardware, so door routes should
 * not include this part.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$window_handles = fenster_data('window_handles', []);
$window_handles = is_array($window_handles) ? $window_handles : [];
$handle_finishes = is_array($window_handles['finishes'] ?? null) ? array_values($window_handles['finishes']) : [];

if (empty($handle_finishes)) {
    return;
}
?>
<section id="window-handle-finishes" class="fg-handle-finishes" aria-labelledby="fg-handle-finishes-title">
    <div class="container">
        <div class="fg-handle-finishes__heading">
            <p class="eyebrow"><?php esc_html_e('Handles', 'fenster'); ?></p>
            <h2 id="fg-handle-finishes-title"><?php esc_html_e('Six handle finishes, lockable as standard.', 'fenster'); ?></h2>
            <p><?php esc_html_e('The S2 Signature range, in left and right hand versions so the operation matches the way the window opens. The release button and the screw cover cap come in the finish you choose rather than defaulting to white.', 'fenster'); ?></p>
        </div>
        <ul class="fg-handle-finishes__grid">
            <?php foreach ($handle_finishes as $finish) : ?>
                <?php
                $finish_name = (string) ($finish['name'] ?? '');
                /* The supplied labels are prefixed "Premium", which TONEOFVOICE.md
                   rules out. The rest of the label is the actual finish method and
                   is worth keeping, so only the adjective is dropped. */
                $finish_label = preg_replace('/^Premium\s+/i', '', (string) ($finish['label'] ?? ''));
                ?>
                <li>
                    <?php if (! empty($finish['image'])) : ?>
                        <img src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>" alt="<?php echo esc_attr(sprintf('S2 Signature window handle in %s', $finish_name)); ?>" loading="lazy">
                    <?php endif; ?>
                    <strong><?php echo esc_html($finish_name); ?></strong>
                    <span><?php echo esc_html($finish_label); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="fg-handle-finishes__note">
            <?php esc_html_e('Handing, restrictors and key-locking are settled at survey, alongside how far the sash swings and whether the handle can be reached comfortably.', 'fenster'); ?>
            <a class="fg-cw-link" href="<?php echo esc_url(home_url('/window-handles/')); ?>"><?php esc_html_e('See the full handle specification', 'fenster'); ?></a>
        </p>
    </div>
</section>
