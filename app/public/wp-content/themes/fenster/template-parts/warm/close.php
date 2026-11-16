<?php
/**
 * Winter guide: where it ends.
 *
 * One route onward, the related reading, then the sources. The related list
 * shows a blog post only once it has been published, so a link here can never
 * point at a post that is still scheduled.
 *
 * The Article schema is printed here, with real dates, an image and the
 * organisation as author. FAQPage comes from the shared FAQ block and the
 * breadcrumb from the theme, so this is the only schema the page adds.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$close = (array) ($warm['close'] ?? []);
$related = (array) ($warm['related'] ?? []);
$sources = (array) ($warm['sources'] ?? []);

$posts = function_exists('fenster_blog_posts') ? fenster_blog_posts() : [];
$links = array_values(array_filter((array) ($related['links'] ?? []), static function (array $link) use ($posts): bool {
    $post = (string) ($link['post'] ?? '');
    if ($post === '') {
        return true;
    }

    return isset($posts[$post]) && function_exists('fenster_blog_post_is_live') && fenster_blog_post_is_live($posts[$post]);
}));

$guide_url = function_exists('fenster_warm_guide_url') ? fenster_warm_guide_url() : home_url('/stop-window-draughts/');
$image = FENSTER_THEME_URI . (string) ($warm['heritage']['proof']['image'] ?? '');
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => (string) $warm['hero']['title'],
    'description' => (string) $warm['hero']['lead'],
    'mainEntityOfPage' => $guide_url,
    'datePublished' => (string) $warm['updated'],
    'dateModified' => (string) $warm['updated'],
    'image' => [str_starts_with($image, '/') ? home_url($image) : $image],
    'author' => ['@type' => 'Organization', 'name' => 'Fenster Glazing', 'url' => home_url('/')],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Fenster Glazing',
        'logo' => ['@type' => 'ImageObject', 'url' => FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png'],
    ],
    'citation' => array_values(array_map(static fn (array $source): string => (string) $source['url'], $sources)),
];
?>
<section class="fg-warm-section fg-warm-close" id="next-steps" aria-labelledby="fg-warm-close-title">
    <div class="container fg-warm-close__grid">
        <div class="fg-warm-close__lead">
            <p class="eyebrow"><?php echo esc_html($close['eyebrow']); ?></p>
            <h2 id="fg-warm-close-title"><?php echo esc_html($close['title']); ?></h2>
            <p><?php echo esc_html($close['copy']); ?></p>
            <div class="fg-warm-close__actions">
                <a class="button" href="<?php echo esc_url($close['primary']['url']); ?>"><?php echo esc_html($close['primary']['label']); ?></a>
                <a class="button button--steel" href="<?php echo esc_url($close['secondary']['url']); ?>"><?php echo esc_html($close['secondary']['label']); ?></a>
            </div>
        </div>
        <ul class="fg-warm-close__routes">
            <?php foreach ((array) $close['routes'] as $route) : ?>
                <li>
                    <a href="<?php echo esc_url($route['url']); ?>">
                        <strong><?php echo esc_html($route['label']); ?></strong>
                        <span><?php echo esc_html($route['meta']); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="fg-warm-section fg-warm-more" aria-labelledby="fg-warm-more-title">
    <div class="container fg-warm-more__grid">
        <?php if ($links !== []) : ?>
            <div class="fg-warm-more__related">
                <p class="eyebrow"><?php echo esc_html($related['eyebrow']); ?></p>
                <h2 id="fg-warm-more-title"><?php echo esc_html($related['title']); ?></h2>
                <ul>
                    <?php foreach ($links as $link) : ?>
                        <li>
                            <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
                            <span><?php echo esc_html($link['meta']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="fg-warm-more__sources">
            <h3><?php echo esc_html($warm['sources_title']); ?></h3>
            <p><?php echo esc_html($warm['sources_intro']); ?></p>
            <ol>
                <?php foreach ($sources as $source) : ?>
                    <li><a href="<?php echo esc_url($source['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($source['label']); ?></a></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>
