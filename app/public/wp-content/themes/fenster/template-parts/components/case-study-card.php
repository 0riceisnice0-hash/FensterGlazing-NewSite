<?php
/**
 * Shared case-study card.
 *
 * One card, used by the case-studies archive, the homepage case-studies block
 * and the product-page "from our case studies" strip. Build the card array
 * with fenster_case_study_card(); pass 'heading' to control the heading tag
 * ('h2' on the archive where cards are the page's main content, 'h3' inside
 * blocks that already have a section heading).
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$card = is_array($args['card'] ?? null) ? $args['card'] : [];
$heading = in_array($args['heading'] ?? 'h2', ['h2', 'h3'], true) ? (string) $args['heading'] : 'h2';
$archive_index = isset($args['archive_index']) ? (int) $args['archive_index'] : null;

if ($card === [] || empty($card['url'])) {
    return;
}
?>
<a class="fg-cs-card" href="<?php echo esc_url((string) $card['url']); ?>"<?php echo $archive_index !== null ? ' data-fg-case-study-card data-fg-case-study-index="' . esc_attr((string) $archive_index) . '"' : ''; ?>>
    <div class="fg-cs-card__media">
        <?php if (is_array($card['image'] ?? null)) : ?>
            <img src="<?php echo esc_url((string) ($card['image']['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($card['image']['caption'] ?? $card['title'] ?? '')); ?>" loading="lazy">
        <?php endif; ?>
    </div>
    <div class="fg-cs-card__body">
        <span class="fg-cs-card__meta">
            <?php echo esc_html(trim((string) ($card['type'] ?? '') . ' • ' . (string) ($card['location'] ?? ''), ' •')); ?>
            <?php if (! empty($card['date'])) : ?>
                <span class="fg-cs-card__date"><?php echo esc_html(date_i18n('j M Y', (int) strtotime((string) $card['date']))); ?></span>
            <?php endif; ?>
        </span>
        <<?php echo $heading; ?> class="fg-cs-card__title"><?php echo esc_html((string) ($card['title'] ?? '')); ?></<?php echo $heading; ?>>
        <p class="fg-cs-card__summary"><?php echo esc_html((string) ($card['summary'] ?? '')); ?></p>
        <?php if (! empty($card['products']) && is_array($card['products'])) : ?>
            <span class="fg-cs-card__tags">
                <?php foreach ($card['products'] as $product) : ?>
                    <span class="fg-cs-tag"><?php echo esc_html((string) ($product['label'] ?? '')); ?></span>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>
        <span class="fg-cs-card__more"><?php esc_html_e('Read case study', 'fenster'); ?></span>
    </div>
</a>
