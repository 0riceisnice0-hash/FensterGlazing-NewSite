<?php
/**
 * The /blog/ hub, since 2026-09-28. Owner: "revamp how the blog page looks"
 * and "only the new ones": it lists the scheduled posts from inc/blog-posts.php
 * and nothing else. Until then it mixed them with nine cards of old site posts
 * (commercial county "strategies" and the like), ran an introduction scraped
 * from one of them, and repeated one photograph three times.
 *
 * The page idea: the newest post is the first thing you see, beside a short
 * introduction; the rest follow as a grid, each with its own photograph; past
 * nine posts, older ones become a plain list so the page stays short as the
 * weekly posts accumulate. It ends with a way to ask what the blog does not
 * cover.
 *
 * Dispatched from the top of generated-simple.php, which still serves the
 * category, tag and paged archives.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

fenster_blog_print_stylesheet_fallback();

$posts = array_values(fenster_live_blog_posts());
$featured = $posts[0] ?? null;
$grid = array_slice($posts, 1, 8);
$older = array_slice($posts, 9);
$used_images = [];

$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Blog',
    'name' => 'Fenster Glazing blog',
    'url' => home_url('/blog/'),
    'publisher' => ['@type' => 'Organization', 'name' => 'Fenster Glazing', 'url' => home_url('/')],
    'blogPost' => array_map(static fn (array $post): array => [
        '@type' => 'BlogPosting',
        'headline' => (string) $post['title'],
        'url' => home_url('/' . $post['slug'] . '/'),
        'datePublished' => (string) $post['publish_date'],
    ], array_slice($posts, 0, 20)),
];
?>

<div class="fg-journal-hub">
    <section class="fg-journal-hub-hero">
        <div class="container fg-journal-hub-hero__grid">
            <div class="fg-journal-hub-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Blog', 'fenster'); ?></p>
                <h1><?php esc_html_e('Window and door advice', 'fenster'); ?></h1>
                <p class="fg-journal-hub-hero__lead"><?php esc_html_e('Straight answers from Fenster in Milton Keynes: why things go wrong, what to fix yourself, what to choose and when to do it.', 'fenster'); ?></p>
                <p class="fg-journal-hub-hero__cadence"><?php esc_html_e('A new post every Monday.', 'fenster'); ?></p>
            </div>

            <?php if ($featured !== null) : ?>
                <?php get_template_part('template-parts/components/blog-card', null, [
                    'post' => $featured,
                    'image' => fenster_blog_post_card_image($featured, $used_images),
                    'heading_level' => 'h2',
                    'sizes' => '(min-width: 1180px) 640px, (min-width: 900px) 54vw, 92vw',
                    'eager' => true,
                    'class' => 'fg-journal-card--feature',
                ]); ?>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($grid !== []) : ?>
        <section class="fg-journal-hub-grid" aria-labelledby="fg-journal-hub-grid-title">
            <div class="container">
                <div class="fg-journal-section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('More posts', 'fenster'); ?></p>
                        <h2 id="fg-journal-hub-grid-title"><?php esc_html_e('Fixes, choices and seasonal checks.', 'fenster'); ?></h2>
                    </div>
                </div>
                <div class="fg-journal-cards fg-journal-cards--four">
                    <?php foreach ($grid as $post) : ?>
                        <?php get_template_part('template-parts/components/blog-card', null, [
                            'post' => $post,
                            'image' => fenster_blog_post_card_image($post, $used_images),
                        ]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($older !== []) : ?>
        <section class="fg-journal-hub-older" aria-labelledby="fg-journal-hub-older-title">
            <div class="container">
                <div class="fg-journal-section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Earlier posts', 'fenster'); ?></p>
                        <h2 id="fg-journal-hub-older-title"><?php esc_html_e('Everything else we have written.', 'fenster'); ?></h2>
                    </div>
                </div>
                <ul class="fg-journal-list">
                    <?php foreach ($older as $post) : ?>
                        <li>
                            <a href="<?php echo esc_url(home_url('/' . $post['slug'] . '/')); ?>">
                                <strong><?php echo esc_html((string) $post['title']); ?></strong>
                                <span><?php echo esc_html(fenster_blog_post_meta_line($post, false)); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-journal-ask">
        <div class="container fg-journal-ask__panel">
            <div>
                <p class="eyebrow"><?php esc_html_e('Ask us', 'fenster'); ?></p>
                <h2><?php esc_html_e('Something the blog does not cover?', 'fenster'); ?></h2>
                <p><?php esc_html_e('Send us the question with a photo of the window or door, or ring the office. We will tell you what we think it needs.', 'fenster'); ?></p>
            </div>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Send an enquiry', 'fenster'); ?></a>
                <a class="button button--steel" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
            </div>
        </div>
    </section>

    <script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
</div>
