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
$is_commercial = ! empty($args['is_commercial']);
$short_slug = (string) ($args['short_slug'] ?? '');
$quote_url = (string) ($args['quote_url'] ?? home_url('/online-quote/'));
/* The instant quote tool prices domestic windows and doors. It cannot price a
   facade, so it is kept off commercial pages entirely: a contractor sent to a
   retail quote engine learns we have not understood the job. Commercial work
   routes to the project enquiry instead. Owner instruction, 2026-07-28. */
$commercial_enquiry_url = home_url('/commercial-glazing/#commercial-enquiry');

/* One renderer, two archives. Commercial work lists at /commercial-projects/
   and residential at /case-studies/, so each archive only builds cards for its
   own type. A detail page still needs the full set for related links. */
if ($is_archive && function_exists('fenster_case_studies_of_type')) {
    $studies = fenster_case_studies_of_type($is_commercial ? 'commercial' : 'residential');
} else {
    $studies = function_exists('fenster_case_studies') ? fenster_case_studies() : [];
}
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
    $cards[$short] = fenster_case_study_card((string) $short, $study);
}

/** Render a single archive/related card via the shared partial. */
$render_card = static function (array $card, string $heading = 'h2'): void {
    get_template_part('template-parts/components/case-study-card', null, [
        'card' => $card,
        'heading' => $heading,
    ]);
};

if ($is_archive) :
    ?>
    <article class="fg-cs fg-cs--archive">
        <header class="fg-cs-head">
            <div class="container">
                <p class="eyebrow"><?php echo esc_html($is_commercial ? __('Commercial projects', 'fenster') : __('Case studies', 'fenster')); ?></p>
                <h1><?php echo esc_html($is_commercial ? __('Commercial projects', 'fenster') : __('Recent installations', 'fenster')); ?></h1>
                <p class="fg-cs-head__lead"><?php echo esc_html($is_commercial
                    ? __('Buildings we have glazed for other businesses, with the scope, the constraints and what was actually fitted.', 'fenster')
                    : __('See the most recent of our 1,000+ installations in the case studies below.', 'fenster')); ?></p>
            </div>
        </header>

        <section class="fg-cs-list">
            <div class="container">
                <div class="fg-cs-grid <?php echo esc_attr($is_commercial ? 'fg-cs-grid--overlay' : ''); ?>" data-fg-case-studies-archive data-fg-case-studies-initial="6">
                    <?php foreach (array_values($cards) as $archive_index => $card) : ?>
                        <?php get_template_part('template-parts/components/case-study-card', null, [
                            'card' => $card,
                            'heading' => 'h2',
                            'archive_index' => $archive_index,
                            'variant' => $is_commercial ? 'overlay' : '',
                        ]); ?>
                    <?php endforeach; ?>
                </div>
                <div class="fg-cs-show-more-wrap">
                    <button class="button button--light fg-cs-show-more" type="button" data-fg-case-studies-more hidden>
                        <?php esc_html_e('Show more case studies', 'fenster'); ?>
                    </button>
                </div>
            </div>
        </section>

        <section class="fg-cs-cta">
            <div class="container fg-cs-cta__inner">
                <div>
                    <h2><?php echo esc_html($is_commercial ? __('Have a building that needs glazing?', 'fenster') : __('Want windows or doors like these?', 'fenster')); ?></h2>
                    <p><?php echo esc_html($is_commercial
                        ? __('Send the drawings, the schedule or a short scope note and we will review what is needed.', 'fenster')
                        : __('Price your project in minutes with our instant quote tool, or talk it through with the team first.', 'fenster')); ?></p>
                </div>
                <div class="fg-cs-cta__actions">
                    <?php if ($is_commercial) : ?>
                        <a class="button" href="<?php echo esc_url($commercial_enquiry_url); ?>"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>"><?php esc_html_e('Commercial glazing', 'fenster'); ?></a>
                    <?php else : ?>
                        <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                    <?php endif; ?>
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
$date_iso = (string) ($study['date'] ?? '');
/* Commercial work is dated to the month and labelled "Completed": a contractor
   thinks in handover months, and we do not hold a reliable install date for the
   migrated projects, so printing an exact day would be inventing one. Domestic
   jobs keep the full date, which is real and useful to a homeowner. */
/* A study can carry a date purely as a sort key. Where the office is not sure
   of the month, `date_confirmed => false` keeps the ordering but prints nothing,
   because a guessed month on a proof page is worse than no month. */
$date_confirmed = ($study['date_confirmed'] ?? true) !== false;
$date_display = ($date_iso !== '' && $date_confirmed)
    ? date_i18n($is_commercial ? 'F Y' : 'j F Y', (int) strtotime($date_iso))
    : '';
$date_label = $is_commercial ? __('Completed', 'fenster') : __('Installed', 'fenster');
$lead = (string) ($study['lead'] ?? ($study['summary'] ?? ''));
$overview = is_array($study['overview'] ?? null) ? $study['overview'] : [];
$specs = is_array($study['specs'] ?? null) ? $study['specs'] : [];
$products = is_array($study['products'] ?? null) ? $study['products'] : [];
$colour = is_array($study['colour'] ?? null) ? $study['colour'] : null;
$installed = is_array($study['installed'] ?? null) ? $study['installed'] : [];
$images = is_array($study['images'] ?? null) ? $study['images'] : [];
$installers = is_array($study['installers'] ?? null) ? $study['installers'] : [];
$review = is_array($study['review'] ?? null) ? $study['review'] : null;
$award = is_array($study['award'] ?? null) ? $study['award'] : null;
$video = is_array($study['video'] ?? null) ? $study['video'] : null;
$is_wide_video = $video && ($video['orientation'] ?? '') === 'landscape';

/* Article schema for a case study, added 2026-08-15.
   ---------------------------------------------------------------------------
   Fourteen studies were the strongest proof on the site and carried no markup
   at all beyond the site-wide business node, so the one thing that demonstrates
   the work was invisible to anything reading structurally.

   THIS IS THE ONE PLACE ON THE SITE WITH AN HONEST DATE. Everywhere else a
   `dateModified` would have to be invented from a file timestamp, which would
   claim every page changed on every deploy — which is why it has deliberately
   not been added anywhere else. Here the office recorded a real completion date
   AND recorded whether it is sure of it, so `datePublished` is gated on exactly
   the same `$date_confirmed` flag the visible date is gated on. An unsure date
   prints nothing and publishes nothing, and the two can never disagree.

   The named installers become `contributor`, because they are the people who
   did the work and the page already names them. `about` points at the products,
   which is what the study is evidence FOR. No `review` or `aggregateRating`
   even where a study carries a customer quote: the standing rule in `AI.md` is
   that self-serving review markup earns risk without producing stars, and a
   case study is exactly where it would be tempting. */
$case_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => home_url('/case-studies/' . $short_slug . '/#article'),
    'headline' => $title,
    'url' => home_url('/case-studies/' . $short_slug . '/'),
    'publisher' => ['@id' => home_url('/#business')],
    'author' => ['@id' => home_url('/#business')],
    'isPartOf' => ['@id' => home_url('/#website')],
];

if ($lead !== '') {
    $case_schema['description'] = wp_strip_all_tags($lead);
}

if ($date_iso !== '' && $date_confirmed) {
    $case_schema['datePublished'] = gmdate('Y-m-d', (int) strtotime($date_iso));
}

if ($location !== '') {
    $case_schema['contentLocation'] = ['@type' => 'Place', 'name' => $location];
}

// images[0] IS the hero on this data shape, so there is no separate hero key to
// read. An earlier draft reached for `$study['image']`, which does not exist and
// would have thrown on a string offset if it ever did.
$case_images = [];
foreach ($images as $case_image) {
    $case_image_src = (string) (is_array($case_image) ? ($case_image['src'] ?? '') : $case_image);
    if ($case_image_src !== '') {
        $case_images[] = fenster_generated_url($case_image_src);
    }
}
$case_images = array_values(array_unique(array_filter($case_images)));
if (! empty($case_images)) {
    $case_schema['image'] = $case_images;
}

/* The installers already carry a role and a link to their own anchor on
   /meet-the-team/, so a contributor here resolves to the same Person the team
   page publishes rather than to a loose name. That join is the point: it is
   what turns "some fitters" into named people who work for a named company. */
$case_contributors = [];
foreach ($installers as $installer) {
    if (! is_array($installer)) {
        continue;
    }

    $installer_name = trim((string) ($installer['name'] ?? ''));
    if ($installer_name === '') {
        continue;
    }

    $contributor = ['@type' => 'Person', 'name' => $installer_name];

    $installer_role = trim((string) ($installer['role'] ?? ''));
    if ($installer_role !== '') {
        $contributor['jobTitle'] = $installer_role;
    }

    $installer_url = trim((string) ($installer['url'] ?? ''));
    if ($installer_url !== '') {
        $contributor['url'] = $installer_url;
    }

    $case_contributors[] = $contributor;
}
if (! empty($case_contributors)) {
    $case_schema['contributor'] = $case_contributors;
}

$case_about = [];
foreach ($products as $case_product) {
    $case_product_name = trim((string) (is_array($case_product) ? ($case_product['label'] ?? $case_product['name'] ?? '') : $case_product));
    if ($case_product_name !== '') {
        $case_about[] = ['@type' => 'Service', 'name' => $case_product_name];
    }
}
if (! empty($case_about)) {
    $case_schema['about'] = $case_about;
}

printf(
    "<script type=\"application/ld+json\">%s</script>\n",
    wp_json_encode($case_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);
if ($video && ! $is_wide_video) {
    // A square/portrait video fills the hero slot, so every still goes to the gallery.
    $hero_image = null;
    $gallery_images = $images;
} else {
    // No video, or a wide video (which sits full-width below a normal two-column
    // hero): the first still fills the hero image slot, the rest go to the gallery.
    $hero_image = $images[0] ?? null;
    $gallery_images = array_slice($images, 1);
}

/* Related work stays within the same type. A commercial project page was
   offering a domestic bifold as the next thing to read, which is the wrong
   audience and the wrong sale. Same type first, then anything else only if
   there are not enough to fill the row. */
$related = [];
$related_other = [];
foreach ($cards as $short => $card) {
    if ($short === $short_slug) {
        continue;
    }
    if (strtolower((string) ($card['type'] ?? '')) === strtolower($type)) {
        $related[] = $card;
    } else {
        $related_other[] = $card;
    }
}
if (count($related) < 3) {
    $related = array_merge($related, $related_other);
}
$related = array_slice($related, 0, 3);
?>
<?php
ob_start();
?>
<a class="fg-cs-back" href="<?php echo esc_url(home_url($is_commercial ? '/commercial-projects/' : '/case-studies/')); ?>"><?php echo esc_html($is_commercial ? __('All commercial projects', 'fenster') : __('All case studies', 'fenster')); ?></a>
<p class="eyebrow"><?php echo esc_html(trim($type . ' • ' . $location, ' ')); ?></p>
<h1><?php echo esc_html($title); ?></h1>
<p class="fg-cs-hero__lead"><?php echo esc_html($lead); ?></p>
<?php if ($date_display !== '') : ?>
    <p class="fg-cs-hero__date"><?php echo esc_html($date_label); ?> <time datetime="<?php echo esc_attr($is_commercial ? substr($date_iso, 0, 7) : $date_iso); ?>"><?php echo esc_html($date_display); ?></time></p>
<?php endif; ?>
<div class="fg-cs-hero__actions">
    <?php if ($is_commercial) : ?>
        <a class="button" href="<?php echo esc_url($commercial_enquiry_url); ?>"><?php esc_html_e('Send project details', 'fenster'); ?></a>
    <?php else : ?>
        <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
    <?php endif; ?>
    <?php $first_product = $products[0] ?? null; ?>
    <?php if (is_array($first_product)) : ?>
        <a class="button button--light" href="<?php echo esc_url((string) ($first_product['url'] ?? '#')); ?>"><?php echo esc_html((string) ($first_product['label'] ?? '')); ?></a>
    <?php endif; ?>
</div>
<?php
$hero_intro_html = ob_get_clean();
?>
<article class="fg-cs fg-cs--single">
    <?php if ($is_wide_video) : ?>
        <header class="fg-cs-hero fg-cs-hero--wide-video">
            <div class="container">
                <div class="fg-cs-hero__grid">
                    <div class="fg-cs-hero__intro"><?php echo $hero_intro_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                    <?php if (is_array($hero_image)) : ?>
                        <figure class="fg-cs-hero__media">
                            <a class="fg-cs-zoom" href="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" data-fg-gallery-lightbox aria-label="<?php esc_attr_e('View full image', 'fenster'); ?>">
                                <img src="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($hero_image['caption'] ?? $title)); ?>" loading="eager">
                            </a>
                        </figure>
                    <?php endif; ?>
                </div>
                <div class="fg-cs-hero__video-wide">
                    <video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url((string) ($video['poster'] ?? '')); ?>" aria-label="<?php echo esc_attr((string) ($video['label'] ?? $title)); ?>">
                        <source src="<?php echo esc_url((string) ($video['src'] ?? '')); ?>" type="video/mp4">
                    </video>
                </div>
            </div>
        </header>
    <?php else : ?>
        <header class="fg-cs-hero">
            <div class="container fg-cs-hero__grid">
                <div class="fg-cs-hero__intro"><?php echo $hero_intro_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                <?php if ($video) : ?>
                    <figure class="fg-cs-hero__media fg-cs-hero__media--video">
                        <video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url((string) ($video['poster'] ?? '')); ?>" aria-label="<?php echo esc_attr((string) ($video['label'] ?? $title)); ?>">
                            <source src="<?php echo esc_url((string) ($video['src'] ?? '')); ?>" type="video/mp4">
                        </video>
                    </figure>
                <?php elseif (is_array($hero_image)) : ?>
                    <figure class="fg-cs-hero__media">
                        <a class="fg-cs-zoom" href="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" data-fg-gallery-lightbox aria-label="<?php esc_attr_e('View full image', 'fenster'); ?>">
                            <img src="<?php echo esc_url((string) ($hero_image['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($hero_image['caption'] ?? $title)); ?>" loading="eager">
                        </a>
                    </figure>
                <?php endif; ?>
            </div>
        </header>
    <?php endif; ?>

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

    <?php if ($award) : ?>
        <section class="fg-cs-award">
            <div class="container fg-cs-award__inner">
                <span class="fg-cs-award__badge" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"></circle><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"></path></svg>
                </span>
                <div class="fg-cs-award__text">
                    <p class="fg-cs-award__title"><?php echo esc_html((string) ($award['title'] ?? '')); ?></p>
                    <?php if (! empty($award['note'])) : ?>
                        <p class="fg-cs-award__note"><?php echo esc_html((string) $award['note']); ?></p>
                    <?php endif; ?>
                </div>
                <?php if (! empty($award['logo'])) : ?>
                    <img class="fg-cs-award__logo" src="<?php echo esc_url((string) $award['logo']); ?>" alt="<?php echo esc_attr((string) ($award['source'] ?? 'Sheerline')); ?>" loading="lazy">
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-cs-body">
        <div class="container fg-cs-body__grid">
            <div class="fg-cs-overview">
                <?php foreach ($overview as $paragraph) : ?>
                    <p><?php echo wp_kses((string) $paragraph, $allowed_overview_html); ?></p>
                <?php endforeach; ?>
                <?php
                /* How this customer got their price. The instant quote tool is
                   the default, so a study only sets priced_by when the job was
                   priced another way. 'consultation' is the Wolverton heritage
                   door job, which stated the quote tool until the owner
                   corrected it. A study priced by a route with no branch here
                   needs one adding rather than being left on the default,
                   because this is a claim about a real customer. */
                $priced_by = (string) ($study['priced_by'] ?? '');
                ?>
                <?php if (! $is_commercial && $priced_by === 'consultation') : ?>
                    <p class="fg-cs-quote-note">
                        <?php
                        printf(
                            /* translators: %s: consultation booking link */
                            esc_html__('This customer got their price from a %s.', 'fenster'),
                            '<a href="' . esc_url(home_url('/book-a-consultation/')) . '">' . esc_html__('home consultation', 'fenster') . '</a>'
                        );
                        ?>
                    </p>
                <?php elseif (! $is_commercial) : ?>
                    <p class="fg-cs-quote-note">
                        <?php
                        printf(
                            /* translators: %s: instant quote tool link */
                            esc_html__('This customer got their price from our %s.', 'fenster'),
                            '<a href="' . esc_url($quote_url) . '">' . esc_html__('instant quote tool', 'fenster') . '</a>'
                        );
                        ?>
                    </p>
                <?php endif; ?>

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
                    <?php if ($is_commercial) : ?>
                        <a class="fg-cs-link fg-cs-link--quote" href="<?php echo esc_url($commercial_enquiry_url); ?>"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                    <?php else : ?>
                        <a class="fg-cs-link fg-cs-link--quote" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                    <?php endif; ?>
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

                <?php /* The label is a study field now, added 2026-08-10. It was
                         hardcoded to "Installers", which is right for the
                         residential studies and wrong for a commercial one whose
                         named people are the surveyor and the commercial
                         director. Naming people is the strongest trust signal
                         these pages have, and it only works if the label is
                         true. Defaults to "Installers" so nothing else moves. */ ?>
                <?php if (! empty($installers)) : ?>
                    <div class="fg-cs-aside__block fg-cs-installers">
                        <span class="fg-cs-aside__label"><?php echo esc_html((string) ($study['team_label'] ?? __('Installers', 'fenster'))); ?></span>
                        <ul class="fg-cs-installers__list">
                            <?php foreach ($installers as $person) : ?>
                                <?php
                                $person_url = (string) ($person['url'] ?? '');
                                $person_tag = $person_url !== '' ? 'a' : 'span';
                                ?>
                                <li>
                                    <<?php echo $person_tag; ?> class="fg-cs-installer<?php echo $person_url === '' ? ' fg-cs-installer--static' : ''; ?>"<?php echo $person_url !== '' ? ' href="' . esc_url($person_url) . '"' : ''; ?>>
                                        <span class="fg-cs-installer__photo">
                                            <?php if (! empty($person['image'])) : ?>
                                                <img src="<?php echo esc_url((string) $person['image']); ?>" alt="<?php echo esc_attr((string) ($person['name'] ?? '')); ?>" loading="lazy">
                                            <?php else : ?>
                                                <span class="fg-cs-installer__initial" aria-hidden="true"><?php echo esc_html(strtoupper(substr((string) ($person['name'] ?? '?'), 0, 1))); ?></span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="fg-cs-installer__meta">
                                            <strong><?php echo esc_html((string) ($person['name'] ?? '')); ?></strong>
                                            <small><?php echo esc_html((string) ($person['role'] ?? 'Fitter')); ?></small>
                                        </span>
                                    </<?php echo $person_tag; ?>>
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
                <?php
                /* The gallery cell is square by default. `gallery_shape =>
                   'tall'` swaps it for 3:4 on this study only.

                   THIS DOES NOT REVERSE THE ALIGNMENT RULE, it applies it. The
                   owner rule of 2026-08-10 is that every image in a gallery
                   shares ONE shape, so the rows line up and no holes open under
                   a shorter photograph. A study whose photographs are all
                   portrait still satisfies that with a portrait cell, and gets
                   back the quarter of the height a square cell takes off it.

                   ONLY SET IT WHEN EVERY IMAGE IN THE GALLERY IS PORTRAIT.
                   Measured across the 93 images in the library, a 3:4 cell
                   keeps 96% of a portrait's height against 72% for a square,
                   but leaves a landscape showing 53% of its width against 71%.
                   Mixing one landscape into a tall gallery is the fault this
                   rule was written to stop. */
                $gallery_shape = ($study['gallery_shape'] ?? '') === 'tall' ? ' fg-cs-gallery__masonry--tall' : '';
                ?>
                <div class="fg-cs-gallery__masonry<?php echo esc_attr($gallery_shape); ?>">
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
                <h2><?php echo esc_html($is_commercial ? __('Have a project like this?', 'fenster') : __('Want the same for your home?', 'fenster')); ?></h2>
                <p><?php echo esc_html($is_commercial
                    ? __('Send the drawings, the schedule or a short scope note and we will review what is needed.', 'fenster')
                    : __('Price it in minutes with our instant quote tool, or explore the products used on this project.', 'fenster')); ?></p>
            </div>
            <div class="fg-cs-cta__actions">
                <?php if ($is_commercial) : ?>
                    <a class="button" href="<?php echo esc_url($commercial_enquiry_url); ?>"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('All commercial projects', 'fenster'); ?></a>
                <?php else : ?>
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
                <?php endif; ?>
        </div>
    </section>
</article>
