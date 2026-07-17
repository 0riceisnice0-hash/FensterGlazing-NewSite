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
                <p class="fg-cs-head__lead"><?php esc_html_e('A look at recent Fenster window and door projects across Milton Keynes and Bedfordshire, with the products, colours and detail behind each one.', 'fenster'); ?></p>
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

$related = [];
foreach ($cards as $short => $card) {
    if ($short !== $short_slug) {
        $related[] = $card;
    }
}
$related = array_slice($related, 0, 3);
?>
<article class="fg-cs fg-cs--single">
    <header class="fg-cs-head">
        <div class="container">
            <a class="fg-cs-back" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
            <p class="eyebrow"><?php echo esc_html(trim($type . ' • ' . $location, ' ')); ?></p>
            <h1><?php echo esc_html($title); ?></h1>
            <p class="fg-cs-head__lead"><?php echo esc_html($lead); ?></p>
        </div>
    </header>

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
            </div>

            <aside class="fg-cs-specs">
                <?php if (! empty($specs)) : ?>
                    <h2 class="fg-cs-specs__title"><?php esc_html_e('Specification', 'fenster'); ?></h2>
                    <dl class="fg-cs-specs__list">
                        <?php foreach ($specs as $spec) : ?>
                            <div>
                                <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                                <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                <?php endif; ?>
                <?php if (! empty($products) || $colour) : ?>
                    <div class="fg-cs-specs__links">
                        <span class="fg-cs-specs__links-label"><?php esc_html_e('Explore', 'fenster'); ?></span>
                        <?php foreach ($products as $product) : ?>
                            <a class="fg-cs-link" href="<?php echo esc_url((string) ($product['url'] ?? '#')); ?>"><?php echo esc_html((string) ($product['label'] ?? '')); ?></a>
                        <?php endforeach; ?>
                        <?php if ($colour) : ?>
                            <a class="fg-cs-link" href="<?php echo esc_url((string) ($colour['url'] ?? home_url('/colour-options/'))); ?>"><?php echo esc_html((string) ($colour['label'] ?? '')); ?></a>
                        <?php endif; ?>
                        <a class="fg-cs-link fg-cs-link--quote" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                    </div>
                <?php endif; ?>
                <?php if (! empty($installed)) : ?>
                    <div class="fg-cs-specs__installed">
                        <span class="fg-cs-specs__links-label"><?php esc_html_e('What we fitted', 'fenster'); ?></span>
                        <ul>
                            <?php foreach ($installed as $item) : ?>
                                <li><?php echo esc_html((string) $item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>

    <?php if (! empty($images)) : ?>
        <section class="fg-cs-gallery">
            <div class="container">
                <div class="fg-cs-gallery__grid">
                    <?php foreach ($images as $image) : ?>
                        <figure class="fg-cs-figure">
                            <div class="fg-cs-figure__media">
                                <img src="<?php echo esc_url((string) ($image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($image['caption'] ?? $title)); ?>" loading="lazy">
                            </div>
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
