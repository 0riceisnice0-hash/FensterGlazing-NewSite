<?php
/**
 * Scheduled blog post layout.
 *
 * Composition follows the product hero pattern from STYLE.md: eyebrow with
 * date, H1 naming the topic, one lead paragraph, the green-then-steel CTA
 * pair and a single real product photograph. The body reads at article
 * measure with one or two deliberate feature images, then the post's own
 * next-steps routes, then the shared enquiry form with explicit contrast.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$post = is_array($args['post'] ?? null) ? $args['post'] : null;

if ($post === null) {
    return;
}

$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);
$title = (string) ($post['title'] ?? 'Fenster Glazing');
$publish_date = (string) ($post['publish_date'] ?? '');
$display_date = $publish_date !== '' ? date_i18n('j F Y', (int) strtotime($publish_date)) : '';
$sections = (array) ($post['sections'] ?? []);
$next_steps = (array) ($post['next_steps'] ?? []);
$products = array_values((array) ($post['products'] ?? []));

/* The hero shows the first declared product; feature figures come from the
   remaining pool imagery so every photograph matches the copy. */
$hero_image = null;
$feature_images = [];
$seen_srcs = [];

foreach ($products as $product_slug) {
    $media = fenster_data('product_media.' . $product_slug, []);
    if (! is_array($media)) {
        continue;
    }

    $candidates = [];
    if (! empty($media['hero']['src'])) {
        $candidates[] = $media['hero'];
    }
    if (! empty($media['card']['src'])) {
        $candidates[] = $media['card'];
    }
    foreach ((array) ($media['gallery'] ?? []) as $gallery_image) {
        if (! empty($gallery_image['src'])) {
            $candidates[] = $gallery_image;
        }
    }

    foreach ($candidates as $candidate) {
        $src = (string) $candidate['src'];
        if (isset($seen_srcs[$src])) {
            continue;
        }
        $seen_srcs[$src] = true;

        if ($hero_image === null) {
            $hero_image = $candidate;
        } elseif (count($feature_images) < 2) {
            $feature_images[] = $candidate;
        }
    }
}

/* The first heading-less section is the lead paragraph under the H1. */
$lead = '';
$intro_extra = [];
$body_blocks = [];

foreach ($sections as $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $body = array_values(array_filter(array_map('trim', (array) ($section['body'] ?? []))));

    if ($heading === '' && $lead === '' && ! empty($body)) {
        $lead = array_shift($body);
        $intro_extra = $body;
        continue;
    }

    if ($heading === '' && empty($body)) {
        continue;
    }

    $body_blocks[] = ['heading' => $heading, 'body' => $body];
}

$next_links = array_slice((array) ($next_steps['links'] ?? []), 0, 3);
?>

<main id="main-content" class="fg-blog-post-page">
    <article>
        <section class="fg-blog-post-hero">
            <div class="container fg-blog-post-hero__grid">
                <div class="fg-blog-post-hero__copy">
                    <p class="eyebrow">
                        <?php esc_html_e('Advice and guides', 'fenster'); ?><?php if ($display_date !== '') : ?><span aria-hidden="true"> &middot; </span><?php echo esc_html($display_date); ?><?php endif; ?>
                    </p>
                    <h1><?php echo esc_html($title); ?></h1>
                    <?php if ($lead !== '') : ?>
                        <p class="fg-blog-post-hero__lead"><?php echo esc_html($lead); ?></p>
                    <?php endif; ?>
                    <div class="button-row">
                        <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get a quote', 'fenster'); ?></a>
                        <a class="button button--steel" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
                    </div>
                </div>
                <?php if (is_array($hero_image)) : ?>
                    <figure class="fg-blog-post-hero__media">
                        <img <?php echo fenster_image_attr_string((string) $hero_image['src'], ['alt' => (string) ($hero_image['alt'] ?? $title), 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                    </figure>
                <?php endif; ?>
            </div>
        </section>

        <section class="fg-blog-post-body">
            <div class="container fg-blog-post-body__inner">
                <?php foreach ($intro_extra as $paragraph) : ?>
                    <p><?php echo esc_html($paragraph); ?></p>
                <?php endforeach; ?>
                <?php foreach ($body_blocks as $block_index => $block) : ?>
                    <?php if ($block['heading'] !== '') : ?>
                        <h2><?php echo esc_html($block['heading']); ?></h2>
                    <?php endif; ?>
                    <?php foreach ($block['body'] as $paragraph) : ?>
                        <p><?php echo esc_html($paragraph); ?></p>
                    <?php endforeach; ?>
                    <?php if ($block_index === 1 && isset($feature_images[0])) : ?>
                        <figure class="fg-blog-post-body__figure">
                            <img <?php echo fenster_image_attr_string((string) $feature_images[0]['src'], ['alt' => (string) ($feature_images[0]['alt'] ?? $title), 'loading' => 'lazy']); ?>>
                            <?php if (! empty($feature_images[0]['alt'])) : ?>
                                <figcaption><?php echo esc_html((string) $feature_images[0]['alt']); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>
                    <?php if ($block_index === 3 && isset($feature_images[1]) && count($body_blocks) >= 5) : ?>
                        <figure class="fg-blog-post-body__figure">
                            <img <?php echo fenster_image_attr_string((string) $feature_images[1]['src'], ['alt' => (string) ($feature_images[1]['alt'] ?? $title), 'loading' => 'lazy']); ?>>
                            <?php if (! empty($feature_images[1]['alt'])) : ?>
                                <figcaption><?php echo esc_html((string) $feature_images[1]['alt']); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (! empty($next_links)) : ?>
            <section class="fg-blog-post-routes">
                <div class="container fg-blog-post-routes__inner">
                    <div class="fg-blog-post-routes__copy">
                        <p class="eyebrow"><?php echo esc_html((string) ($next_steps['eyebrow'] ?? 'Next step')); ?></p>
                        <h2><?php echo esc_html((string) ($next_steps['title'] ?? 'Plan the next step.')); ?></h2>
                        <p><?php echo esc_html((string) ($next_steps['copy'] ?? '')); ?></p>
                    </div>
                    <div class="fg-blog-post-routes__links">
                        <?php foreach ($next_links as $link) : ?>
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

        <section id="fenster-enquiry" class="fg-blog-post-enquiry">
            <div class="container fg-blog-post-enquiry__grid">
                <div class="fg-blog-post-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Send an enquiry', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Tell us what you are dealing with.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Describe the window, door or project and roughly where you are. Photos help, but they are not required. We will review the details and contact you about the next step.', 'fenster'); ?></p>
                    <ul>
                        <li><?php esc_html_e('Repairs, replacements and new installations', 'fenster'); ?></li>
                        <li><?php esc_html_e('Based in Milton Keynes, with our own fitters', 'fenster'); ?></li>
                        <li><?php esc_html_e('Phone lines open 24/7 on 01908 429200', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-blog-post-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form fg-blog-post-form',
                        'source' => 'Blog: ' . $title,
                        'button_label' => 'Send enquiry',
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</main>
