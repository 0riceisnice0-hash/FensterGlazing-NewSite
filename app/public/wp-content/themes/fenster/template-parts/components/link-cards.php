<?php
/**
 * Shared related-links renderer: image cards where a curated thumbnail exists,
 * classic text pills for everything else (area and town links have no
 * photography, so they fall back gracefully).
 *
 * Args:
 * - links: array of ['url' => string, 'text' => string].
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$links = is_array($args['links'] ?? null) ? array_values($args['links']) : [];

if ($links === []) {
    return;
}

$carded = [];
$plain = [];

foreach ($links as $link) {
    $url = (string) ($link['url'] ?? '');
    $text = (string) ($link['text'] ?? '');
    if ($url === '' || $text === '') {
        continue;
    }

    $image = function_exists('fenster_link_card_image') ? fenster_link_card_image($url) : '';
    if ($image !== '') {
        $carded[] = ['url' => $url, 'text' => $text, 'image' => $image];
    } else {
        $plain[] = ['url' => $url, 'text' => $text];
    }
}
?>
<?php if ($carded !== []) : ?>
    <div class="fg-link-cards">
        <?php foreach ($carded as $link) : ?>
            <a class="fg-link-card" href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>">
                <span class="fg-link-card__media">
                    <img <?php echo fenster_image_attr_string($link['image'], ['alt' => $link['text'], 'loading' => 'lazy']); ?>>
                </span>
                <span class="fg-link-card__label"><?php echo esc_html($link['text']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($plain !== []) : ?>
    <div class="generated-links">
        <?php foreach ($plain as $link) : ?>
            <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
