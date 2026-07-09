<?php
/**
 * Generic content output.
 *
 * @package Fenster
 */
$post_slug = (string) get_post_field('post_name', get_the_ID());
$single_post_next_steps = [];

if (is_singular('post') && $post_slug === 'what-is-double-glazing-and-how-does-it-work') {
    $single_post_next_steps = [
        'eyebrow' => 'Ready to compare options?',
        'title' => 'Turn double glazing research into a practical quote.',
        'copy' => 'Fenster can help compare windows, doors, replacement glass and frame choices around the rooms you want to improve.',
        'links' => [
            ['label' => 'Double glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/'), 'meta' => 'Windows, doors and replacement glass'],
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Browse the main window styles'],
            ['label' => 'Start an online quote', 'url' => home_url('/online-quote/'), 'meta' => 'Get a guide price before survey'],
        ],
    ];
}

$content_classes = 'content-band';
if (! empty($single_post_next_steps)) {
    $content_classes .= ' fg-article-page';
}
?>
<article <?php post_class($content_classes); ?>>
    <div class="container prose">
        <p class="eyebrow"><?php echo esc_html(get_post_type()); ?></p>
        <h1><?php the_title(); ?></h1>
        <?php if (! empty($single_post_next_steps)) : ?>
            <section class="fg-article-next-steps fg-article-next-steps--single">
                <div class="fg-article-next-steps__inner">
                    <div class="fg-article-next-steps__copy">
                        <p class="eyebrow"><?php echo esc_html((string) ($single_post_next_steps['eyebrow'] ?? 'Next step')); ?></p>
                        <h2><?php echo esc_html((string) ($single_post_next_steps['title'] ?? 'Plan the next step with Fenster.')); ?></h2>
                        <p><?php echo esc_html((string) ($single_post_next_steps['copy'] ?? 'Explore the most relevant Fenster products and services for this guide.')); ?></p>
                    </div>
                    <div class="fg-article-next-steps__links">
                        <?php foreach (array_slice((array) ($single_post_next_steps['links'] ?? []), 0, 4) as $link) : ?>
                            <a href="<?php echo esc_url((string) ($link['url'] ?? '#')); ?>">
                                <strong><?php echo esc_html((string) ($link['label'] ?? 'View option')); ?></strong>
                                <?php if (! empty($link['meta'])) : ?>
                                    <span><?php echo esc_html((string) $link['meta']); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>
</article>
