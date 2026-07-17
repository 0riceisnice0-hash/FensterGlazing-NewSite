<?php
/**
 * Residential case study renderer (archive + detail).
 *
 * A clean, text-led, descriptive layout on the continuous page canvas. No hero
 * imagery: each detail page is a written overview, a specification panel and a
 * captioned image gallery. Driven entirely by fenster_case_studies(); add a
 * case study in inc/case-studies-data.php and it appears and links itself up.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = is_array($args ?? null) ? $args : [];
$is_archive = ! empty($args['is_archive']);
$short_slug = (string) ($args['short_slug'] ?? '');
$quote_url = (string) ($args['quote_url'] ?? home_url('/online-quote/'));

$studies = function_exists('fenster_case_studies') ? fenster_case_studies() : [];
if (! is_array($studies) || empty($studies)) {
    return;
}

$allowed_overview_html = [
    'a' => ['href' => true, 'title' => true],
    'strong' => [],
    'em' => [],
];

/** Build lightweight card data for the archive and related sections. */
$cards = [];
foreach ($studies as $short => $study) {
    $cards[$short] = [
        'short' => $short,
        'url' => home_url('/case-studies/' . $short . '/'),
        'title' => (string) ($study['title'] ?? ''),
        'location' => (string) ($study['location'] ?? ''),
        'type' => (string) ($study['type'] ?? 'Residential'),
        'summary' => (string) ($study['summary'] ?? ''),
        'image' => is_array($study['images'][0] ?? null) ? $study['images'][0] : null,
        'products' => is_array($study['products'] ?? null) ? $study['products'] : [],
    ];
}

/** Render a single archive/related card. */
$render_card = static function (array $card): void {
    ?>
    <a class="fg-cs-card" href="<?php echo esc_url($card['url']); ?>">
        <div class="fg-cs-card__media">
            <?php if (is_array($card['image'])) : ?>
                <img src="<?php echo esc_url((string) ($card['image']['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($card['image']['caption'] ?? $card['title'])); ?>" loading="lazy">
            <?php endif; ?>
        </div>
        <div class="fg-cs-card__body">
            <span class="fg-cs-card__meta"><?php echo esc_html(trim($card['type'] . ' • ' . $card['location'], ' ')); ?></span>
            <h2 class="fg-cs-card__title"><?php echo esc_html($card['title']); ?></h2>
            <p class="fg-cs-card__summary"><?php echo esc_html($card['summary']); ?></p>
            <?php if (! empty($card['products'])) : ?>
                <span class="fg-cs-card__tags">
                    <?php foreach ($card['products'] as $product) : ?>
                        <span class="fg-cs-tag"><?php echo esc_html((string) ($product['label'] ?? '')); ?></span>
                    <?php endforeach; ?>
                </span>
            <?php endif; ?>
            <span class="fg-cs-card__more"><?php esc_html_e('Read case study', 'fenster'); ?></span>
        </div>
    </a>
    <?php
};

if ($is_archive) :
    ?>
    <article class="fg-cs fg-cs--archive">
        <header class="fg-cs-head">
            <div class="container">
                <p class="eyebrow"><?php esc_html_e('Case studies', 'fenster'); ?></p>
                <h1><?php esc_html_e('Recent installations', 'fenster'); ?></h1>
                <p class="fg-cs-head__lead"><?php esc_html_e('We have completed over 1,000 window and door installations across Milton Keynes and Bedfordshire. We are writing up the best of them here as full case studies, with the products, colours and detail behind each one, so this page will keep growing.', 'fenster'); ?></p>
            </div>
        </header>

        <section class="fg-cs-list">
            <div class="container">
                <div class="fg-cs-grid">
                    <?php foreach ($cards as $card) : ?>
                        <?php $render_card($card); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-cs-cta">
            <div class="container fg-cs-cta__inner">
                <div>
                    <h2><?php esc_html_e('Want windows or doors like these?', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Price your project in minutes with our instant quote tool, or talk it through with the team first.', 'fenster'); ?></p>
                </div>
                <div class="fg-cs-cta__actions">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    </article>
    <?php
    return;
endif;

/* ---------- Detail page ---------- */
$study = fenster_case_study($short_slug);
if (! is_array($study)) {
    return;
}

$title = (string) ($study['title'] ?? 'Case study');
$location = (string) ($study['location'] ?? '');
$type = (string) ($study['type'] ?? 'Residential');
$lead = (string) ($study['lead'] ?? ($study['summary'] ?? ''));
$overview = is_array($study['overview'] ?? null) ? $study['overview'] : [];
$specs = is_array($study['specs'] ?? null) ? $study['specs'] : [];
$products = is_array($study['products'] ?? null) ? $study['products'] : [];
$colour = is_array($study['colour'] ?? null) ? $study['colour'] : null;
$installed = is_array($study['installed'] ?? null) ? $study['installed'] : [];
$images = is_array($study['images'] ?? null) ? $study['images'] : [];
$installers = is_array($study['installers'] ?? null) ? $study['installers'] : [];
$review = is_array($study['review'] ?? null) ? $study['review'] : null;
$hero_image = $images[0] ?? null;
$gallery_images = array_slice($images, 1);

$related = [];
foreach ($cards as $short => $card) {
    if ($short !== $short_slug) {
        $related[] = $card;
    }
}
$related = array_slice($related, 0, 3);
?>
<article class="fg-cs fg-cs--single">
    <header class="fg-cs-hero">
        <div class="container fg-cs-hero__grid">
            <div class="fg-cs-hero__intro">
                <a class="fg-cs-back" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
                <p class="eyebrow"><?php echo esc_html(trim($type . ' • ' . $location, ' ')); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <p class="fg-cs-hero__lead"><?php echo esc_html($lead); ?></p>
                <div class="fg-cs-hero__actions">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                    <?php $first_product = $products[0] ?? null; ?>
                    <?php if (is_array($first_product)) : ?>
                        <a class="button button--light" href="<?php echo esc_url((string) ($first_product['url'] ?? '#')); ?>"><?php echo esc_html((string) ($first_product['label'] ?? '')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (is_array($hero_image)) : ?>
                <figure class="fg-cs-hero__media">
                    <a class="fg-cs-zoom" href="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" data-fg-gallery-lightbox aria-label="<?php esc_attr_e('View full image', 'fenster'); ?>">
                        <img src="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($hero_image['caption'] ?? $title)); ?>" loading="eager">
                    </a>
                </figure>
            <?php endif; ?>
        </div>
    </header>

    <?php if (! empty($specs)) : ?>
        <section class="fg-cs-specstrip">
            <div class="container fg-cs-specstrip__grid">
                <?php foreach ($specs as $spec) : ?>
                    <div class="fg-cs-specstrip__item">
                        <span><?php echo esc_html((string) ($spec['label'] ?? '')); ?></span>
                        <strong><?php echo esc_html((string) ($spec['value'] ?? '')); ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-cs-body">
        <div class="container fg-cs-body__grid">
            <div class="fg-cs-overview">
                <?php foreach ($overview as $paragraph) : ?>
                    <p><?php echo wp_kses((string) $paragraph, $allowed_overview_html); ?></p>
                <?php endforeach; ?>
                <p class="fg-cs-quote-note">
                    <?php
                    printf(
                        /* translators: %s: instant quote tool link */
                        esc_html__('This customer got their price from our %s.', 'fenster'),
                        '<a href="' . esc_url($quote_url) . '">' . esc_html__('instant quote tool', 'fenster') . '</a>'
                    );
                    ?>
                </p>

                <?php if ($review && ! empty($review['quote'])) : ?>
                    <figure class="fg-cs-review">
                        <blockquote><?php echo wp_kses((string) $review['quote'], $allowed_overview_html); ?></blockquote>
                        <?php if (! empty($review['author'])) : ?>
                            <figcaption><?php echo esc_html((string) $review['author']); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </div>

            <aside class="fg-cs-aside">
                <div class="fg-cs-aside__block">
                    <span class="fg-cs-aside__label"><?php esc_html_e('Explore', 'fenster'); ?></span>
                    <?php foreach ($products as $product) : ?>
                        <a class="fg-cs-link" href="<?php echo esc_url((string) ($product['url'] ?? '#')); ?>"><?php echo esc_html((string) ($product['label'] ?? '')); ?></a>
                    <?php endforeach; ?>
                    <?php if ($colour) : ?>
                        <a class="fg-cs-link" href="<?php echo esc_url((string) ($colour['url'] ?? home_url('/colour-options/'))); ?>"><?php echo esc_html((string) ($colour['label'] ?? '')); ?></a>
                    <?php endif; ?>
                    <a class="fg-cs-link fg-cs-link--quote" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                </div>

                <?php if (! empty($installed)) : ?>
                    <div class="fg-cs-aside__block">
                        <span class="fg-cs-aside__label"><?php esc_html_e('What we fitted', 'fenster'); ?></span>
                        <ul class="fg-cs-fitted">
                            <?php foreach ($installed as $item) : ?>
                                <li><?php echo esc_html((string) $item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (! empty($installers)) : ?>
                    <div class="fg-cs-aside__block fg-cs-installers">
                        <span class="fg-cs-aside__label"><?php esc_html_e('Installers', 'fenster'); ?></span>
                        <ul class="fg-cs-installers__list">
                            <?php foreach ($installers as $person) : ?>
                                <li>
                                    <a class="fg-cs-installer" href="<?php echo esc_url((string) ($person['url'] ?? home_url('/meet-the-team/'))); ?>">
                                        <?php if (! empty($person['image'])) : ?>
                                            <span class="fg-cs-installer__photo"><img src="<?php echo esc_url((string) $person['image']); ?>" alt="<?php echo esc_attr((string) ($person['name'] ?? '')); ?>" loading="lazy"></span>
                                        <?php endif; ?>
                                        <span class="fg-cs-installer__meta">
                                            <strong><?php echo esc_html((string) ($person['name'] ?? '')); ?></strong>
                                            <small><?php echo esc_html((string) ($person['role'] ?? 'Installer')); ?></small>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>

    <?php if (! empty($gallery_images)) : ?>
        <section class="fg-cs-gallery">
            <div class="container">
                <h2 class="fg-cs-gallery__title"><?php esc_html_e('The project in pictures', 'fenster'); ?></h2>
                <div class="fg-cs-gallery__masonry">
                    <?php foreach ($gallery_images as $image) : ?>
                        <figure class="fg-cs-shot">
                            <a class="fg-cs-zoom" href="<?php echo esc_url((string) ($image['src'] ?? '')); ?>" data-fg-gallery-lightbox aria-label="<?php esc_attr_e('View full image', 'fenster'); ?>">
                                <img src="<?php echo esc_url((string) ($image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($image['caption'] ?? $title)); ?>" loading="lazy">
                            </a>
                            <?php if (! empty($image['caption'])) : ?>
                                <figcaption><?php echo esc_html((string) $image['caption']); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($related)) : ?>
        <section class="fg-cs-more">
            <div class="container">
                <h2 class="fg-cs-more__title"><?php esc_html_e('More case studies', 'fenster'); ?></h2>
                <div class="fg-cs-grid">
                    <?php foreach ($related as $card) : ?>
                        <?php $render_card($card); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-cs-cta">
        <div class="container fg-cs-cta__inner">
            <div>
                <h2><?php esc_html_e('Want the same for your home?', 'fenster'); ?></h2>
                <p><?php esc_html_e('Price it in minutes with our instant quote tool, or explore the products used on this project.', 'fenster'); ?></p>
            </div>
            <div class="fg-cs-cta__actions">
                <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
            </div>
        </div>
    </section>
</article>
