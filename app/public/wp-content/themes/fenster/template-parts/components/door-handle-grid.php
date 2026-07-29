<?php
/**
 * Door handle finishes.
 *
 * The doors counterpart of window-handle-grid.php, and the same layout as the
 * uPVC colour grid, so a door page shows the finishes instead of carrying the
 * full chooser. The chooser now lives once on the handle hub.
 *
 * Door handles only. Windows take the S2 Signature range, so window routes
 * should not include this part.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$door_handles = fenster_data('door_handles', []);
$door_handles = is_array($door_handles) ? $door_handles : [];
$handle_finishes = is_array($door_handles['finishes'] ?? null) ? array_values($door_handles['finishes']) : [];

if (empty($handle_finishes)) {
    return;
}

/* Spelled out because TONEOFVOICE.md wants small numbers as words in prose.
   Falls back to a plain count if the range ever grows past the map. */
$finish_words = [2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve'];
$finish_count = count($handle_finishes);
$finish_word = $finish_words[$finish_count] ?? (string) $finish_count;
?>
<section id="door-handle-finishes" class="fg-handle-finishes fg-handle-finishes--doors" aria-labelledby="fg-door-handle-finishes-title">
    <div class="container">
        <div class="fg-handle-finishes__heading">
            <p class="eyebrow"><?php esc_html_e('Door handles', 'fenster'); ?></p>
            <h2 id="fg-door-handle-finishes-title"><?php echo esc_html(sprintf(__('%s handle finishes on a long backplate.', 'fenster'), $finish_word)); ?></h2>
            <p><?php esc_html_e('The backplate carries the lever and the cylinder aperture together, so the lock and the handle are settled as one decision rather than two. The finish you pick runs through the letterplate, hinges and threshold as well.', 'fenster'); ?></p>
        </div>
        <ul class="fg-handle-finishes__grid">
            <?php foreach ($handle_finishes as $finish) : ?>
                <?php $finish_name = (string) ($finish['name'] ?? ''); ?>
                <li>
                    <?php if (! empty($finish['image'])) : ?>
                        <img src="<?php echo esc_url(fenster_generated_url((string) $finish['image'])); ?>" alt="<?php echo esc_attr(sprintf('Long-plate door handle in %s', strtolower($finish_name))); ?>" loading="lazy">
                    <?php endif; ?>
                    <?php /* No sub-label here. Every door label reads "<name> long-plate
                             handle", which the heading has already said, and the repeat
                             wrapped to two lines and made the row taller. The window grid
                             keeps its sub-label because there it names the finish method. */ ?>
                    <strong><?php echo esc_html($finish_name); ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="fg-handle-finishes__note">
            <?php esc_html_e('Which handles a door can take depends on the slab, the lock set and the colour package, so we confirm the exact hardware at specification stage.', 'fenster'); ?>
            <a class="fg-cw-link" href="<?php echo esc_url(home_url('/window-handles/#door-handle-finishes')); ?>"><?php esc_html_e('See the full handle specification', 'fenster'); ?></a>
        </p>
    </div>
</section>
