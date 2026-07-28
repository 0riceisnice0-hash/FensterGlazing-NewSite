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
/* 'overlay' is the commercial archive treatment: the photograph is the card and
   the title sits on it, because a facilities manager recognises the building
   before they read the words. Everywhere else keeps the photo-above-copy card. */
$variant = ($args['variant'] ?? '') === 'overlay' ? 'overlay' : '';

if ($card === [] || empty($card['url'])) {
    return;
}

if ($variant === 'overlay') :
    /* Sector then service, both linked. "Commercial" was the first pill, which
       told a reader of the commercial archive nothing they had not worked out.
       These two answer what a commercial buyer arrives with, in the vocabulary
       of the Sectors and Services columns in the menu.

       The card is an <article>, not an <a>, because a link inside a link is
       invalid and swallows the pill clicks. The title carries the real link and
       stretches over the whole card with ::after, so the card still behaves as
       one target while the pills stay independently clickable above it. */
    $tags = [];
    if (! empty($card['sector'])) {
        $tags[] = ['label' => (string) $card['sector'], 'url' => (string) ($card['sector_url'] ?? '')];
    }
    if (! empty($card['service'])) {
        $tags[] = ['label' => (string) $card['service'], 'url' => (string) ($card['service_url'] ?? '')];
    }
    if ($tags === []) {
        foreach (array_slice((array) ($card['products'] ?? []), 0, 1) as $product) {
            if (! empty($product['label'])) {
                $tags[] = ['label' => (string) $product['label'], 'url' => (string) ($product['url'] ?? '')];
            }
        }
    }
    ?>
    <article class="fg-cs-card fg-cs-card--overlay"<?php echo $archive_index !== null ? ' data-fg-case-study-card data-fg-case-study-index="' . esc_attr((string) $archive_index) . '"' : ''; ?>>
        <?php if (is_array($card['image'] ?? null)) : ?>
            <img class="fg-cs-card__photo" src="<?php echo esc_url((string) ($card['image']['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($card['image']['caption'] ?? $card['title'] ?? '')); ?>" loading="lazy">
        <?php endif; ?>
        <span class="fg-cs-card__scrim" aria-hidden="true"></span>
        <?php if ($tags !== []) : ?>
            <p class="fg-cs-card__pills">
                <?php foreach ($tags as $tag) : ?>
                    <?php if ($tag['url'] !== '') : ?>
                        <a class="fg-cs-card__pill" href="<?php echo esc_url($tag['url']); ?>"><?php echo esc_html($tag['label']); ?></a>
                    <?php else : ?>
                        <span class="fg-cs-card__pill"><?php echo esc_html($tag['label']); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
        <?php $title_id = 'cs-card-' . sanitize_title((string) ($card['short'] ?? $card['title'] ?? 'project')); ?>
        <div class="fg-cs-card__overlay">
            <<?php echo $heading; ?> class="fg-cs-card__overlay-title" id="<?php echo esc_attr($title_id); ?>"><?php echo esc_html((string) ($card['title'] ?? '')); ?></<?php echo $heading; ?>>
            <?php if (! empty($card['location'])) : ?>
                <span class="fg-cs-card__overlay-location"><?php echo esc_html((string) $card['location']); ?></span>
            <?php endif; ?>
        </div>
        <?php /* The card's own link: a transparent layer over the whole card, named
                 by the title so it is not an empty link. It sits under the pills,
                 which keep their own targets. */ ?>
        <a class="fg-cs-card__stretch" href="<?php echo esc_url((string) $card['url']); ?>" aria-labelledby="<?php echo esc_attr($title_id); ?>"></a>
    </article>
    <?php
    return;
endif;
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
            <?php if (! empty($card['date']) && ($card['date_confirmed'] ?? true) !== false) : ?>
                <span class="fg-cs-card__date"><?php echo esc_html(date_i18n(strtolower((string) ($card['type'] ?? '')) === 'commercial' ? 'M Y' : 'j M Y', (int) strtotime((string) $card['date']))); ?></span>
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
