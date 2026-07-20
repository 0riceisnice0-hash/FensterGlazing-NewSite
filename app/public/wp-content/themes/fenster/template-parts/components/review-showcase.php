<?php
/**
 * Curated customer review showcase.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'class' => '',
    'trust_items' => [],
    'limit' => 7,
    'prioritise_context' => '',
]);

$reviews = fenster_data('customer_reviews', []);
$reviews = is_array($reviews) ? array_values($reviews) : [];
$prioritise_context = strtolower(trim((string) $args['prioritise_context']));
if ($prioritise_context !== '') {
    usort($reviews, static function (array $left, array $right) use ($prioritise_context): int {
        $left_match = str_contains(strtolower((string) ($left['context'] ?? '')), $prioritise_context);
        $right_match = str_contains(strtolower((string) ($right['context'] ?? '')), $prioritise_context);
        return (int) $right_match <=> (int) $left_match;
    });
}
$reviews = array_slice($reviews, 0, max(1, (int) $args['limit']));
$classes = trim('fg-review-showcase ' . (string) $args['class']);

if (empty($reviews)) {
    return;
}
?>

<section class="<?php echo esc_attr($classes); ?>" data-fg-review-carousel aria-label="<?php esc_attr_e('Customer reviews', 'fenster'); ?>">
    <div class="container">
        <header class="fg-review-showcase__summary">
            <strong><?php esc_html_e('EXCELLENT', 'fenster'); ?></strong>
            <span class="fg-review-showcase__summary-stars" role="img" aria-label="<?php esc_attr_e('5 out of 5 stars', 'fenster'); ?>"></span>
            <div class="fg-review-showcase__sources" role="group" aria-label="<?php esc_attr_e('Review sources', 'fenster'); ?>">
                <a class="fg-review-showcase__source-pill" href="<?php echo esc_url((string) fenster_data('brand.google_reviews_url', '')); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Read Fenster Glazing reviews on Google', 'fenster'); ?>">
                    <span class="fg-review-showcase__google" role="img" aria-label="<?php esc_attr_e('Google', 'fenster'); ?>">
                        <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
                    </span>
                    <b><?php esc_html_e('Customer reviews', 'fenster'); ?></b>
                </a>
                <a class="fg-review-showcase__source-pill fg-review-showcase__source-pill--trustpilot" href="<?php echo esc_url((string) fenster_data('brand.trustpilot_url', '')); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Read Fenster Glazing reviews on Trustpilot', 'fenster'); ?>">
                    <span class="fg-review-showcase__trustpilot-mark" aria-hidden="true">★</span>
                    <span class="fg-review-showcase__trustpilot-word"><?php esc_html_e('Trustpilot', 'fenster'); ?></span>
                    <b><?php esc_html_e('Customer reviews', 'fenster'); ?></b>
                </a>
            </div>
        </header>

        <div class="fg-review-showcase__carousel">
            <button class="fg-review-showcase__button fg-review-showcase__button--prev" type="button" data-fg-review-prev aria-label="<?php esc_attr_e('Previous reviews', 'fenster'); ?>"></button>
            <div class="fg-review-showcase__cards" data-fg-review-track>
                <?php foreach ($reviews as $review) : ?>
                    <?php
                    $source = (string) ($review['source'] ?? 'Google');
                    $is_google = strtolower($source) === 'google';
                    $initial = strtoupper(substr((string) ($review['author'] ?? 'R'), 0, 1));
                    $review_date_raw = (string) ($review['date'] ?? '');
                    $review_date_ts = $review_date_raw !== '' ? strtotime($review_date_raw) : false;
                    $review_date = $review_date_ts ? date_i18n('j M Y', $review_date_ts) : $review_date_raw;
                    ?>
                    <a class="fg-review-showcase__card" href="<?php echo esc_url((string) ($review['url'] ?? '#')); ?>" target="_blank" rel="noopener">
                        <span class="fg-review-showcase__avatar" aria-hidden="true"><?php echo esc_html($initial); ?></span>
                        <span class="fg-review-showcase__name"><?php echo esc_html((string) ($review['author'] ?? 'Customer')); ?></span>
                        <span class="fg-review-showcase__date"><?php echo esc_html($review_date); ?></span>
                        <span class="<?php echo esc_attr($is_google ? 'fg-review-showcase__platform fg-review-showcase__platform--google' : 'fg-review-showcase__platform fg-review-showcase__platform--trustpilot'); ?>">
                            <?php if ($is_google) : ?>
                                <span class="fg-review-showcase__gmark" aria-hidden="true">G</span>
                                <span><?php esc_html_e('Google', 'fenster'); ?></span>
                            <?php else : ?>
                                <span class="fg-review-showcase__trustpilot-mark" aria-hidden="true">★</span>
                                <span><?php esc_html_e('Trustpilot', 'fenster'); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="fg-review-showcase__stars" role="img" aria-label="<?php echo esc_attr(sprintf('%d out of 5 stars', max(0, min(5, (int) ($review['rating'] ?? 5))))); ?>"></span>
                        <p><?php echo esc_html((string) ($review['quote'] ?? '')); ?></p>
                        <span class="fg-review-showcase__read"><?php esc_html_e('Read more', 'fenster'); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="fg-review-showcase__button fg-review-showcase__button--next" type="button" data-fg-review-next aria-label="<?php esc_attr_e('Next reviews', 'fenster'); ?>"></button>
        </div>
    </div>
</section>
