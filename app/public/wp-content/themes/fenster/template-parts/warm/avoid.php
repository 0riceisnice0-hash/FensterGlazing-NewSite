<?php
/**
 * Winter guide: four shortcuts to skip, and what to do instead.
 *
 * TONEOFVOICE.md forbids selling by describing what goes wrong. This section
 * sells nothing: each card is a safety or damage point somebody about to seal a
 * window needs, paired at once with the better way to do the same job.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$avoid = (array) ($warm['avoid'] ?? []);
$items = (array) ($avoid['items'] ?? []);

if ($items === []) {
    return;
}

$icons = [
    'tissue' => '<path d="M7 6h18v8H7z"/><path d="M9 14c0 6 2 8 2 12M16 14c0 7-1 9 0 13M23 14c0 6-2 8-2 12"/><path d="M12 28c1 2 3 2 4 0"/>',
    'tape' => '<circle cx="14" cy="16" r="9"/><circle cx="14" cy="16" r="3.5"/><path d="M14 25h14v-6"/>',
    'vents' => '<rect x="5" y="8" width="22" height="16" rx="2"/><path d="M9 13h14M9 16h14M9 19h14"/>',
    'escape' => '<rect x="6" y="5" width="20" height="22" rx="1.5"/><path d="M6 16h20M16 5v22"/><path d="M19 21l4 0M21 19l2 2-2 2"/>',
];
?>
<section class="fg-warm-section fg-warm-avoid" id="avoid" aria-labelledby="fg-warm-avoid-title">
    <div class="container">
        <div class="fg-warm-head">
            <p class="eyebrow"><?php echo esc_html($avoid['eyebrow']); ?></p>
            <h2 id="fg-warm-avoid-title"><?php echo esc_html($avoid['title']); ?></h2>
        </div>

        <ul class="fg-warm-avoid__grid">
            <?php foreach ($items as $item) : ?>
                <li class="fg-warm-avoid__card fg-warm-panel">
                    <p class="fg-warm-avoid__label fg-warm-avoid__label--skip">
                        <svg class="fg-warm-avoid__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $icons[$item['key']] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
                        <?php echo esc_html($avoid['skip_label']); ?>
                    </p>
                    <h3><?php echo esc_html($item['skip']); ?></h3>
                    <p class="fg-warm-avoid__why"><?php echo esc_html($item['why']); ?></p>
                    <div class="fg-warm-avoid__instead">
                        <p class="fg-warm-avoid__label"><?php echo esc_html($avoid['instead_label']); ?></p>
                        <p><?php echo esc_html($item['instead']); ?></p>
                    </div>
                    <?php
                    if ($item['source'] !== '') {
                        echo fenster_warm_source_line($warm, $item['source']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="fg-warm-avoid__note">
            <h3><?php echo esc_html($avoid['note_title']); ?></h3>
            <p><?php echo esc_html($avoid['note']); ?> <a href="<?php echo esc_url($avoid['note_url']); ?>"><?php echo esc_html($avoid['note_link_label']); ?></a></p>
            <?php echo fenster_warm_source_line($warm, $avoid['note_source'], 'est-draught'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
    </div>
</section>
