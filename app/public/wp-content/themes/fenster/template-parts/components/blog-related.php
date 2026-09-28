<?php
/**
 * "From the blog" at the foot of a product, hub or town page: up to three
 * published posts that name the page's product, newest first, topped up from
 * the rest of its window or door family. Owner, 2026-09-28: "link to them.
 * only the new ones."
 *
 * Included from footer.php on every page and silent wherever no post applies
 * (fenster_blog_posts_for_page() decides), so a page gains the band on the
 * Monday its first post publishes, with no template change.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('fenster_blog_posts_for_page')) {
    return;
}

$posts = fenster_blog_posts_for_page(fenster_blog_current_slug());

if ($posts === []) {
    return;
}

fenster_blog_print_stylesheet_fallback();
$used_images = [];

/* One or two posts fill the row rather than leaving empty columns. */
$layouts = [
    1 => ['class' => 'fg-journal-cards--one', 'sizes' => '(min-width: 1180px) 500px, (min-width: 820px) 42vw, 92vw'],
    2 => ['class' => 'fg-journal-cards--two', 'sizes' => '(min-width: 1180px) 580px, (min-width: 820px) 46vw, 92vw'],
];
$layout = $layouts[count($posts)] ?? ['class' => 'fg-journal-cards--three', 'sizes' => '(min-width: 1180px) 370px, (min-width: 700px) 31vw, 92vw'];
?>
<section class="fg-journal-related" aria-labelledby="fg-journal-related-title">
    <div class="container">
        <div class="fg-journal-section-head">
            <div>
                <p class="eyebrow"><?php esc_html_e('From the blog', 'fenster'); ?></p>
                <h2 id="fg-journal-related-title"><?php esc_html_e('Worth reading before you decide.', 'fenster'); ?></h2>
            </div>
            <a class="button button--steel" href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Read the blog', 'fenster'); ?></a>
        </div>
        <div class="fg-journal-cards <?php echo esc_attr($layout['class']); ?>">
            <?php foreach ($posts as $post) : ?>
                <?php get_template_part('template-parts/components/blog-card', null, [
                    'post' => $post,
                    'image' => fenster_blog_post_card_image($post, $used_images),
                    'sizes' => $layout['sizes'],
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
