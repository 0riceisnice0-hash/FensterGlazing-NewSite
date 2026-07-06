<?php
/**
 * Article layout for imported blog posts and guides.
 *
 * Renders informational content as a readable article rather than forcing it
 * through the product journey template.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$sections = is_array($args['sections'] ?? null) ? $args['sections'] : ($page['sections'] ?? []);
$images = is_array($args['images'] ?? null) ? $args['images'] : ($page['images'] ?? []);
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$title = (string) ($args['title'] ?? ($page['title'] ?? 'Fenster Glazing'));
$hero_intro = trim((string) ($args['hero_intro'] ?? ''));
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);

$article_blocks = [];
$intro_consumed = false;

foreach ($sections as $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $body = array_values(array_filter(array_map(
        static fn ($line): string => trim((string) $line),
        $section['body'] ?? []
    )));

    if ($heading === $title) {
        $heading = '';
    }

    if (! $intro_consumed && $hero_intro !== '' && isset($body[0]) && $body[0] === $hero_intro) {
        array_shift($body);
        $intro_consumed = true;
    }

    if ($heading === '' && empty($body)) {
        continue;
    }

    $article_blocks[] = [
        'heading' => $heading,
        'body' => $body,
    ];
}

$article_images = array_values(array_filter($images, static fn ($image): bool => is_array($image) && ! empty($image['src'])));
$hero_image = $article_images[0] ?? null;
$inline_images = array_slice($article_images, 1, 3);
$inline_image_gap = max(2, (int) ceil(count($article_blocks) / max(1, count($inline_images) + 1)));
?>

<article class="fg-article-page">
    <section class="fg-article-hero">
        <div class="container fg-article-hero__grid">
            <div class="fg-article-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Advice and guides', 'fenster'); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($hero_intro !== '') : ?>
                    <p><?php echo esc_html($hero_intro); ?></p>
                <?php endif; ?>
            </div>
            <?php if (is_array($hero_image)) : ?>
                <figure class="fg-article-hero__media">
                    <img src="<?php echo esc_url(fenster_generated_url((string) $hero_image['src'])); ?>" alt="<?php echo esc_attr((string) ($hero_image['alt'] ?? $title)); ?>" loading="eager">
                </figure>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($article_blocks)) : ?>
        <section class="fg-article-body">
            <div class="container fg-article-body__inner">
                <?php $inline_image_index = 0; ?>
                <?php foreach ($article_blocks as $block_index => $block) : ?>
                    <?php if ($block['heading'] !== '') : ?>
                        <h2><?php echo esc_html($block['heading']); ?></h2>
                    <?php endif; ?>
                    <?php foreach ($block['body'] as $paragraph) : ?>
                        <p><?php echo esc_html($paragraph); ?></p>
                    <?php endforeach; ?>
                    <?php
                    $should_place_image = isset($inline_images[$inline_image_index])
                        && $block_index > 0
                        && (($block_index + 1) % $inline_image_gap === 0);
                    ?>
                    <?php if ($should_place_image) : ?>
                        <?php $inline_image = $inline_images[$inline_image_index]; ?>
                        <figure class="fg-article-body__figure">
                            <img src="<?php echo esc_url(fenster_generated_url((string) $inline_image['src'])); ?>" alt="<?php echo esc_attr((string) ($inline_image['alt'] ?? $title)); ?>" loading="lazy">
                        </figure>
                        <?php $inline_image_index++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-article-cta">
        <div class="container fg-article-cta__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Talk to Fenster', 'fenster'); ?></p>
                <h2><?php esc_html_e('Thinking about your own windows or doors?', 'fenster'); ?></h2>
                <p><?php esc_html_e('The Fenster team can help with product advice, survey-led specification and clear pricing for your home or project.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a class="text-link" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => 'Article: ' . $title,
                'button_label' => 'Send enquiry',
                'compact' => true,
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Related reading', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products and services mentioned in this guide', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach (array_slice(array_values($related_links), 0, 18) as $link) : ?>
                        <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>
