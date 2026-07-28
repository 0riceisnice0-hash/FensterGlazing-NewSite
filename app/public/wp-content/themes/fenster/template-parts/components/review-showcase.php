<?php
/**
 * Customer review showcase.
 *
 * Renders live Google reviews when the Places API is configured (see
 * `inc/google-reviews.php`) and falls back to the owner-curated set otherwise.
 * Google's terms require attribution, so each card carries the reviewer's own
 * name and photo and links to the review on Google.
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

$summary = fenster_review_summary();
$reviews = fenster_review_cards((int) $args['limit'], (string) $args['prioritise_context']);
$classes = trim('fg-review-showcase ' . (string) $args['class']);

if (empty($reviews)) {
    return;
}

$rating = (float) $summary['rating'];
$review_count = (int) $summary['count'];
$read_url = fenster_google_reviews_url();
$trustpilot_url = (string) fenster_data('brand.trustpilot_url', '');

/** Five stars, filled to the nearest half. */
$render_stars = static function (float $value): string {
    $markup = '';
    for ($index = 1; $index <= 5; $index++) {
        $state = $value >= $index ? 'is-full' : ($value >= $index - 0.5 ? 'is-half' : '');
        $markup .= '<i class="fg-stars__star ' . esc_attr($state) . '" aria-hidden="true"></i>';
    }

    return $markup;
};
?>

<section class="<?php echo esc_attr($classes); ?>" data-fg-review-carousel aria-label="<?php esc_attr_e('Customer reviews', 'fenster'); ?>">
    <div class="container">
        <?php /* One flat row: copy on the left, both platforms in a proof cluster on
                 the right. The score used to sit in its own tinted, padded box inside
                 this white panel, which STYLE.md rules out (no cards inside cards) and
                 was most of why it read as bulky. */ ?>
        <header class="fg-review-showcase__summary">
            <div class="fg-review-showcase__intro">
                <span class="fg-review-showcase__badge"><?php esc_html_e('Google and Trustpilot', 'fenster'); ?></span>
                <h2><?php esc_html_e('What Milton Keynes homeowners say', 'fenster'); ?></h2>
                <p><?php esc_html_e('Real reviews from real installations. Every one is public, so you can go and check them yourself.', 'fenster'); ?></p>
            </div>

            <?php /* Both platforms get identical treatment. A big "Read all reviews"
                     button beside a small Trustpilot link put the same job at two very
                     different weights, and "all reviews" was misleading anyway: it only
                     ever went to Google. Each block now links to its own platform. */ ?>
            <div class="fg-review-showcase__proof">
                <a class="fg-review-showcase__platform fg-review-showcase__score" href="<?php echo esc_url($read_url); ?>" target="_blank" rel="noopener">
                    <span class="fg-review-showcase__gmark" aria-hidden="true">
                        <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
                    </span>
                    <span class="fg-review-showcase__score-row">
                        <span class="fg-review-showcase__score-value"><?php echo esc_html(number_format($rating, 1)); ?></span>
                        <span class="fg-stars fg-stars--lg" role="img" aria-label="<?php echo esc_attr(sprintf(__('%s out of 5 stars', 'fenster'), number_format($rating, 1))); ?>">
                            <?php echo $render_stars($rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </span>
                    </span>
                    <span class="fg-review-showcase__score-meta">
                        <?php if ($review_count > 0) : ?>
                            <?php printf(
                                esc_html__('Rated by %s customers', 'fenster'),
                                '<strong>' . esc_html(number_format_i18n($review_count)) . '</strong>'
                            ); ?>
                        <?php else : ?>
                            <?php esc_html_e('Verified customer reviews', 'fenster'); ?>
                        <?php endif; ?>
                    </span>
                    <span class="fg-review-showcase__platform-link"><?php esc_html_e('Read our Google reviews', 'fenster'); ?></span>
                </a>

                <?php if ($trustpilot_url !== '') : ?>
                    <a class="fg-review-showcase__platform fg-review-showcase__trustpilot" href="<?php echo esc_url($trustpilot_url); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png'); ?>" alt="<?php esc_attr_e('Trustpilot, rated Excellent', 'fenster'); ?>" width="355" height="150" loading="lazy" decoding="async">
                        <span class="fg-review-showcase__platform-link"><?php esc_html_e('Read our Trustpilot reviews', 'fenster'); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </header>

        <div class="fg-review-showcase__carousel">
            <button class="fg-review-showcase__button fg-review-showcase__button--prev" type="button" data-fg-review-prev aria-label="<?php esc_attr_e('Previous reviews', 'fenster'); ?>"></button>
            <div class="fg-review-showcase__cards" data-fg-review-track>
                <?php foreach ($reviews as $review) : ?>
                    <?php
                    $source = (string) ($review['source'] ?? 'Google');
                    $is_google = strtolower($source) === 'google';
                    $author = (string) ($review['author'] ?? 'Customer');
                    $initial = strtoupper(mb_substr($author, 0, 1));
                    $photo = (string) ($review['author_photo'] ?? '');
                    $card_rating = max(1, min(5, (int) ($review['rating'] ?? 5)));

                    $relative = trim((string) ($review['relative_date'] ?? ''));
                    if ($relative === '') {
                        $raw_date = (string) ($review['date'] ?? '');
                        $timestamp = $raw_date !== '' ? strtotime($raw_date) : false;
                        $relative = $timestamp ? date_i18n('j M Y', $timestamp) : $raw_date;
                    }

                    $url = (string) ($review['url'] ?? '');
                    if ($url === '') {
                        $url = $is_google ? $read_url : $trustpilot_url;
                    }
                    ?>
                    <a class="fg-review-showcase__card" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                        <span class="fg-review-showcase__head">
                            <?php if ($photo !== '') : ?>
                                <img class="fg-review-showcase__avatar fg-review-showcase__avatar--photo" src="<?php echo esc_url($photo); ?>" alt="" width="44" height="44" loading="lazy" decoding="async">
                            <?php else : ?>
                                <span class="fg-review-showcase__avatar" aria-hidden="true"><?php echo esc_html($initial); ?></span>
                            <?php endif; ?>
                            <span class="fg-review-showcase__identity">
                                <span class="fg-review-showcase__name"><?php echo esc_html($author); ?></span>
                                <span class="fg-review-showcase__date"><?php echo esc_html($relative); ?></span>
                            </span>
                            <span class="fg-review-showcase__platform" aria-label="<?php echo esc_attr($is_google ? __('Review on Google', 'fenster') : __('Review on Trustpilot', 'fenster')); ?>">
                                <?php if ($is_google) : ?>
                                    <span class="fg-review-showcase__glyph" aria-hidden="true">G</span>
                                <?php else : ?>
                                    <span class="fg-review-showcase__glyph fg-review-showcase__glyph--trustpilot" aria-hidden="true">★</span>
                                <?php endif; ?>
                            </span>
                        </span>
                        <span class="fg-stars" role="img" aria-label="<?php echo esc_attr(sprintf(__('%d out of 5 stars', 'fenster'), $card_rating)); ?>">
                            <?php echo $render_stars((float) $card_rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </span>
                        <p><?php echo esc_html((string) ($review['quote'] ?? '')); ?></p>
                        <span class="fg-review-showcase__read"><?php esc_html_e('Read on Google', 'fenster'); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="fg-review-showcase__button fg-review-showcase__button--next" type="button" data-fg-review-next aria-label="<?php esc_attr_e('Next reviews', 'fenster'); ?>"></button>
        </div>
    </div>
</section>
