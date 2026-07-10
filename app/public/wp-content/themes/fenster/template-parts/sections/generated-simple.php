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
$is_careers = $slug === 'careers';

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

if ($is_careers) :
    $careers_intro = $cards[0]['body'] ?? [];
    $careers_status = $cards[1]['body'] ?? [];
    $careers_fit = $cards[2]['body'] ?? [];
    $careers_interest = $cards[3]['body'] ?? [];
    ?>

<article class="fg-careers-page">
    <section class="fg-careers-hero">
        <div class="container fg-careers-hero__grid">
            <div class="fg-careers-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Careers at Fenster', 'fenster'); ?></p>
                <h1><?php esc_html_e('Work with a glazing team that cares about the details.', 'fenster'); ?></h1>
                <?php foreach (array_slice($careers_intro, 0, 2) as $paragraph) : ?>
                    <p><?php echo esc_html($paragraph); ?></p>
                <?php endforeach; ?>
                <div class="button-row">
                    <a class="button" href="mailto:<?php echo esc_attr($email); ?>?subject=Future%20careers%20interest"><?php esc_html_e('Register interest', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('About Fenster', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-careers-status" aria-labelledby="fg-careers-status-title">
                <span><?php esc_html_e('Hiring status', 'fenster'); ?></span>
                <h2 id="fg-careers-status-title"><?php esc_html_e('No current vacancies', 'fenster'); ?></h2>
                <?php foreach (array_slice($careers_status, 0, 2) as $paragraph) : ?>
                    <p><?php echo esc_html($paragraph); ?></p>
                <?php endforeach; ?>
            </aside>
        </div>
    </section>

    <section class="fg-careers-fit">
        <div class="container fg-careers-fit__grid">
            <div class="fg-careers-fit__intro">
                <p class="eyebrow"><?php esc_html_e('Future opportunities', 'fenster'); ?></p>
                <h2><?php esc_html_e('The kind of people who usually fit well here.', 'fenster'); ?></h2>
                <?php foreach (array_slice($careers_fit, 0, 2) as $paragraph) : ?>
                    <p><?php echo esc_html($paragraph); ?></p>
                <?php endforeach; ?>
            </div>
            <div class="fg-careers-pillars" aria-label="<?php esc_attr_e('Fenster working standards', 'fenster'); ?>">
                <article>
                    <span><?php esc_html_e('01', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Clear with customers', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Good updates, tidy handovers and plain answers matter as much as the product itself.', 'fenster'); ?></p>
                </article>
                <article>
                    <span><?php esc_html_e('02', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Careful with details', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Survey notes, measurements, trims, thresholds, hardware and aftercare all need proper attention.', 'fenster'); ?></p>
                </article>
                <article>
                    <span><?php esc_html_e('03', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Ready to learn', 'fenster'); ?></h3>
                    <p><?php esc_html_e('The glazing world changes quickly, so curiosity and pride in improvement go a long way.', 'fenster'); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="fg-careers-interest">
        <div class="container fg-careers-interest__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Stay in touch', 'fenster'); ?></p>
                <h2><?php esc_html_e('Want to be considered when something opens?', 'fenster'); ?></h2>
                <?php foreach (array_slice($careers_interest, 0, 2) as $paragraph) : ?>
                    <p><?php echo esc_html($paragraph); ?></p>
                <?php endforeach; ?>
            </div>
            <div class="fg-contact-list">
                <a href="mailto:<?php echo esc_attr($email); ?>?subject=Future%20careers%20interest"><?php echo esc_html($email); ?></a>
                <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
            </div>
        </div>
    </section>
</article>

    <?php
    return;
endif;
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
