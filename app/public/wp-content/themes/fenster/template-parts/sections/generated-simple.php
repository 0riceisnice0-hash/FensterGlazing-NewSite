<?php
/**
 * Simple fallback for generated non-product pages.
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
$hero_intro = (string) ($args['hero_intro'] ?? ($page['seo']['meta_description'] ?? 'Find useful Fenster Glazing information, product guidance and contact details.'));
$hero_media_src = (string) ($args['hero_media_src'] ?? (($images[0]['src'] ?? '') ?: '/wp-content/themes/fenster/assets/images/imported/Aluminium-Windows-16.jpg'));
$slug = (string) ($page['slug'] ?? '');
$is_archive = (bool) ($args['is_archive'] ?? false);
$is_utility = (bool) ($args['is_utility'] ?? false);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$cards = [];

foreach ($sections as $index => $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $body = array_values(array_filter(array_map('trim', $section['body'] ?? [])));

    if ($heading === '' || empty($body)) {
        continue;
    }

    $cards[] = [
        'heading' => $heading,
        'body' => $body,
        'image' => $images[$index]['src'] ?? ($images[$index + 1]['src'] ?? ''),
        'alt' => $images[$index]['alt'] ?? $heading,
    ];
}

$cards = array_slice($cards, 0, $is_archive ? 18 : 8);
?>

<article class="fg-simple-page <?php echo esc_attr($is_archive ? 'fg-simple-page--archive' : ''); ?>">
    <section class="fg-simple-hero">
        <div class="container fg-simple-hero__grid">
            <div class="fg-simple-hero__copy">
                <p class="eyebrow"><?php echo esc_html($is_archive ? 'Fenster articles' : 'Fenster Glazing'); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($hero_intro !== '') : ?>
                    <p><?php echo esc_html(wp_trim_words($hero_intro, 34)); ?></p>
                <?php endif; ?>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Fenster', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Start a quote', 'fenster'); ?></a>
                </div>
            </div>
            <?php if ($hero_media_src !== '') : ?>
                <figure class="fg-simple-hero__media">
                    <img src="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
                </figure>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($cards)) : ?>
        <section class="fg-simple-content">
            <div class="container">
                <div class="fg-simple-section-head">
                    <p class="eyebrow"><?php echo esc_html($is_archive ? 'Latest guidance' : 'Useful information'); ?></p>
                    <h2><?php echo esc_html($is_archive ? 'Fenster articles and updates' : 'What to know about this page'); ?></h2>
                </div>
                <div class="fg-simple-grid">
                    <?php foreach ($cards as $card) : ?>
                        <article class="fg-simple-card">
                            <?php if (! empty($card['image'])) : ?>
                                <img src="<?php echo esc_url(fenster_generated_url($card['image'])); ?>" alt="<?php echo esc_attr($card['alt']); ?>" loading="lazy">
                            <?php endif; ?>
                            <div>
                                <h3><?php echo esc_html($card['heading']); ?></h3>
                                <?php foreach (array_slice($card['body'], 0, $is_archive ? 1 : 3) as $paragraph) : ?>
                                    <p><?php echo esc_html($paragraph); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-simple-contact">
        <div class="container fg-simple-contact__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Need help?', 'fenster'); ?></p>
                <h2><?php echo esc_html($is_utility ? 'Speak to Fenster if you need anything clarified.' : 'Talk to Fenster about your project.'); ?></h2>
                <p><?php esc_html_e('The team can help with windows, doors, glazing repairs, commercial enquiries and showroom visits.', 'fenster'); ?></p>
            </div>
            <div class="fg-contact-list">
                <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </div>
        </div>
    </section>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Useful pages', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products, services and project examples', 'fenster'); ?></h2>
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
