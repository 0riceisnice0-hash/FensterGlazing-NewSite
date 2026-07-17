<?php
/**
 * Residential case study renderer (archive + detail).
 *
 * Driven entirely by fenster_case_studies(). Reuses the shared fg-case-*
 * styling with a few residential-only additions (product chips, the instant
 * quote note and product CTAs). Add a case study in inc/case-studies-data.php
 * and it appears here and links itself up automatically.
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
    <a class="fg-case-card fg-case-card--residential" href="<?php echo esc_url($card['url']); ?>">
        <?php if (is_array($card['image'])) : ?>
            <img src="<?php echo esc_url((string) ($card['image']['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" loading="lazy">
        <?php endif; ?>
        <span><?php echo esc_html(trim($card['type'] . ' / ' . $card['location'], ' /')); ?></span>
        <strong><?php echo esc_html($card['title']); ?></strong>
        <small><?php echo esc_html($card['summary']); ?></small>
        <?php if (! empty($card['products'])) : ?>
            <span class="fg-case-card__tags">
                <?php foreach (array_slice($card['products'], 0, 2) as $product) : ?>
                    <span class="fg-case-card__tag"><?php echo esc_html((string) ($product['label'] ?? '')); ?></span>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
};

if ($is_archive) :
    $featured = array_slice($cards, 0, 3);
    ?>
    <article class="fg-case-page fg-case-page--archive fg-case-page--residential">
        <section class="fg-case-hero">
            <div class="fg-case-hero__media">
                <?php foreach ($featured as $index => $card) : ?>
                    <?php if (is_array($card['image'])) : ?>
                        <img src="<?php echo esc_url((string) ($card['image']['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($card['image']['alt'] ?? $card['title'])); ?>" style="--slot: <?php echo esc_attr((string) $index); ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="fg-case-hero__shade"></div>
            <div class="container fg-case-hero__inner">
                <p class="eyebrow"><?php esc_html_e('Case studies', 'fenster'); ?></p>
                <h1><?php esc_html_e('Real Fenster installs, in real homes.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Recent window and door projects across Milton Keynes and Bedfordshire, with the products, colours and detail behind each one.', 'fenster'); ?></p>
                <div class="fg-case-hero__stats">
                    <span><strong><?php echo esc_html((string) count($cards)); ?></strong><?php esc_html_e('recent projects', 'fenster'); ?></span>
                    <span><strong><?php esc_html_e('Local', 'fenster'); ?></strong><?php esc_html_e('homes we serve', 'fenster'); ?></span>
                    <span><strong>1</strong><?php esc_html_e('in-house team', 'fenster'); ?></span>
                </div>
                <div class="button-row">
                    <a class="button" href="#fenster-projects"><?php esc_html_e('Explore projects', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                </div>
            </div>
        </section>

        <section class="fg-case-index" id="fenster-projects">
            <div class="container">
                <div class="fg-case-section-head">
                    <p class="eyebrow"><?php esc_html_e('Recent work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Projects, products and finishes.', 'fenster'); ?></h2>
                </div>
                <div class="fg-case-index__grid">
                    <?php foreach ($cards as $card) : ?>
                        <?php $render_card($card); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-case-cta" id="fenster-enquiry">
            <div class="container fg-case-cta__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Start yours', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Want windows or doors like these?', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Price your project in minutes with our instant quote tool, or talk it through with the team first.', 'fenster'); ?></p>
                </div>
                <div class="button-row">
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
$intro = (string) ($study['intro'] ?? ($study['summary'] ?? ''));
$finish = (string) ($study['finish'] ?? '');
$outcome = (string) ($study['outcome'] ?? 'Project details');
$products = is_array($study['products'] ?? null) ? $study['products'] : [];
$colour = is_array($study['colour'] ?? null) ? $study['colour'] : null;
$installed = is_array($study['installed'] ?? null) ? $study['installed'] : [];
$story = is_array($study['story'] ?? null) ? $study['story'] : [];
$images = is_array($study['images'] ?? null) ? $study['images'] : [];
$hero = $images[0] ?? null;
$gallery = array_slice($images, 1);

$product_labels = implode(', ', array_map(static fn ($p): string => (string) ($p['label'] ?? ''), $products));

$related = [];
foreach ($cards as $short => $card) {
    if ($short !== $short_slug) {
        $related[] = $card;
    }
}
$related = array_slice($related, 0, 3);
?>
<article class="fg-case-page fg-case-page--single fg-case-page--residential">
    <section class="fg-case-single-hero">
        <?php if (is_array($hero)) : ?>
            <img src="<?php echo esc_url((string) ($hero['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($hero['alt'] ?? $title)); ?>">
        <?php endif; ?>
        <div class="fg-case-single-hero__shade"></div>
        <div class="container fg-case-single-hero__inner">
            <a class="fg-case-back" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('Case studies', 'fenster'); ?></a>
            <p class="eyebrow"><?php echo esc_html($type . ' project'); ?></p>
            <h1><?php echo esc_html($title); ?></h1>
            <p><?php echo esc_html($intro); ?></p>
            <div class="fg-case-facts">
                <span><small><?php esc_html_e('Location', 'fenster'); ?></small><strong><?php echo esc_html($location); ?></strong></span>
                <?php if ($product_labels !== '') : ?>
                    <span><small><?php esc_html_e('Products', 'fenster'); ?></small><strong><?php echo esc_html($product_labels); ?></strong></span>
                <?php endif; ?>
                <?php if ($finish !== '') : ?>
                    <span><small><?php esc_html_e('Finish', 'fenster'); ?></small><strong><?php echo esc_html($finish); ?></strong></span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="fg-case-brief">
        <div class="container fg-case-brief__grid">
            <div class="fg-case-snapshot__intro">
                <p class="eyebrow"><?php esc_html_e('Project snapshot', 'fenster'); ?></p>
                <h2><?php echo esc_html($outcome); ?></h2>
                <p><?php echo esc_html($study['summary'] ?? $intro); ?></p>
                <?php if (! empty($products) || $colour) : ?>
                    <div class="fg-case-chips">
                        <?php foreach ($products as $product) : ?>
                            <a class="fg-case-chip" href="<?php echo esc_url((string) ($product['url'] ?? '#')); ?>">
                                <?php echo esc_html((string) ($product['label'] ?? '')); ?>
                            </a>
                        <?php endforeach; ?>
                        <?php if ($colour) : ?>
                            <a class="fg-case-chip fg-case-chip--colour" href="<?php echo esc_url((string) ($colour['url'] ?? home_url('/colour-options/'))); ?>">
                                <?php echo esc_html((string) ($colour['label'] ?? '')); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <p class="fg-case-quote-note">
                    <?php
                    printf(
                        /* translators: %s: instant quote tool link */
                        esc_html__('This customer got their price from our %s.', 'fenster'),
                        '<a href="' . esc_url($quote_url) . '">' . esc_html__('instant quote tool', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <?php if (! empty($installed)) : ?>
                <div class="fg-case-installed">
                    <span><?php esc_html_e('Installed', 'fenster'); ?></span>
                    <ul>
                        <?php foreach ($installed as $item) : ?>
                            <li><?php echo esc_html((string) $item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($story)) : ?>
        <section class="fg-case-story">
            <div class="container fg-case-story__grid">
                <aside class="fg-case-story__rail">
                    <span><?php esc_html_e('Project file', 'fenster'); ?></span>
                    <strong><?php echo esc_html($title); ?></strong>
                    <small><?php echo esc_html($location); ?></small>
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Start a similar project', 'fenster'); ?></a>
                </aside>
                <div class="fg-case-story__body">
                    <?php foreach ($story as $index => $block) : ?>
                        <section class="fg-case-story-block">
                            <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <p class="eyebrow"><?php echo esc_html((string) ($block['label'] ?? '')); ?></p>
                            <h2><?php echo esc_html((string) ($block['title'] ?? '')); ?></h2>
                            <p><?php echo esc_html((string) ($block['copy'] ?? '')); ?></p>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($gallery)) : ?>
        <section class="fg-case-gallery">
            <div class="container">
                <div class="fg-case-section-head">
                    <p class="eyebrow"><?php esc_html_e('Project images', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Details from the work.', 'fenster'); ?></h2>
                </div>
                <div class="fg-case-gallery__grid">
                    <?php foreach (array_slice($gallery, 0, 6) as $image) : ?>
                        <figure>
                            <img src="<?php echo esc_url((string) ($image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($image['alt'] ?? $title)); ?>" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($related)) : ?>
        <section class="fg-case-related">
            <div class="container">
                <div class="fg-case-section-head">
                    <p class="eyebrow"><?php esc_html_e('More case studies', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Keep exploring recent projects.', 'fenster'); ?></h2>
                </div>
                <div class="fg-case-index__grid">
                    <?php foreach ($related as $card) : ?>
                        <?php $render_card($card); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-case-cta" id="fenster-enquiry">
        <div class="container fg-case-cta__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Next project', 'fenster'); ?></p>
                <h2><?php esc_html_e('Want the same for your home?', 'fenster'); ?></h2>
                <p><?php esc_html_e('Price it in minutes with our instant quote tool, or explore the products used on this project.', 'fenster'); ?></p>
            </div>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                <?php $primary_product = $products[0] ?? null; ?>
                <?php if (is_array($primary_product)) : ?>
                    <?php $cta_label = str_replace('upvc', 'uPVC', strtolower((string) ($primary_product['label'] ?? 'products'))); ?>
                    <a class="button button--light" href="<?php echo esc_url((string) ($primary_product['url'] ?? '#')); ?>">
                        <?php printf(esc_html__('View %s', 'fenster'), esc_html($cta_label)); ?>
                    </a>
                <?php else : ?>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('Back to case studies', 'fenster'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</article>
