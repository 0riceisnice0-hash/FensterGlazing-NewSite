<?php
/**
 * One blog post as a card: photograph, date and reading time, title, summary.
 * The whole card is the link. Used on the hub, under articles and in the
 * "From the blog" band on product pages.
 *
 * Args: post (array, from fenster_live_blog_posts()), image (from
 * fenster_blog_post_card_image(), may be null), heading_level ('h2'|'h3'),
 * sizes (for the photograph), eager (bool), class (extra classes).
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$post = is_array($args['post'] ?? null) ? $args['post'] : null;
if ($post === null || empty($post['slug'])) {
    return;
}

$image = is_array($args['image'] ?? null) ? $args['image'] : null;
$heading_level = (string) ($args['heading_level'] ?? 'h3');
$heading_level = in_array($heading_level, ['h2', 'h3'], true) ? $heading_level : 'h3';
$sizes = (string) ($args['sizes'] ?? '(min-width: 1180px) 280px, (min-width: 900px) 30vw, (min-width: 600px) 46vw, 92vw');
$eager = ! empty($args['eager']);
$summary = fenster_blog_post_summary($post);
$class = trim('fg-journal-card ' . (string) ($args['class'] ?? ''));
?>
<a class="<?php echo esc_attr($class); ?>" href="<?php echo esc_url(home_url('/' . $post['slug'] . '/')); ?>">
    <div class="fg-journal-card__media">
        <?php if ($image !== null) : ?>
            <?php /* The title beside it names the link, so the photograph is decorative here. */ ?>
            <img <?php echo fenster_blog_image_attrs((string) $image['src'], ['alt' => '', 'sizes' => $sizes, 'loading' => $eager ? 'eager' : 'lazy']); ?>>
        <?php endif; ?>
    </div>
    <div class="fg-journal-card__body">
        <p class="fg-journal-card__meta"><?php echo esc_html(fenster_blog_post_meta_line($post)); ?></p>
        <<?php echo $heading_level; ?> class="fg-journal-card__title"><?php echo esc_html((string) $post['title']); ?></<?php echo $heading_level; ?>>
        <?php if ($summary !== '') : ?>
            <p class="fg-journal-card__summary"><?php echo esc_html($summary); ?></p>
        <?php endif; ?>
    </div>
</a>
