<?php
/**
 * The blog's article layout, shared by the scheduled posts (blog-post.php) and
 * the imported guides from the old site (generated-article.php). Both reduce
 * their data to the arguments below, so the two kinds of article read the same.
 *
 * The page idea: someone arrives with a question, usually from search. The
 * first screen confirms they are in the right place (title, the answer's first
 * lines, a real photograph where the post has one); the body reads at a proper
 * measure with the headings listed beside it; then the next step the article
 * points to, more posts, and the enquiry form.
 *
 * Args:
 * - kind          'post' or 'guide'
 * - slug, title   the route and the H1
 * - date          Y-m-d, posts only
 * - lead          the opening paragraph
 * - sections      [['heading' => '', 'body' => ['...']], ...]
 * - legacy        true for imported guides: sentence-case the headings and
 *                 rebuild the lists and steps the old import flattened
 * - hero_image    ['src', 'alt'] or null
 * - figures       up to three more photographs for the body
 * - next_steps    ['eyebrow', 'title', 'copy', 'links' => [['label', 'url', 'meta']]]
 * - product_links [['url', 'text']], the products a guide mentions
 * - products      product slugs, to choose related posts
 * - description   for structured data
 * - form_source   the enquiry's Source label; keep it stable, reports group on it
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

fenster_blog_print_stylesheet_fallback();

$kind = ($args['kind'] ?? 'post') === 'guide' ? 'guide' : 'post';
$slug = trim((string) ($args['slug'] ?? ''), '/');
$title = (string) ($args['title'] ?? 'Fenster Glazing');
$date = (string) ($args['date'] ?? '');
$lead = trim((string) ($args['lead'] ?? ''));
$sections = (array) ($args['sections'] ?? []);
$legacy = ! empty($args['legacy']);
$hero_image = is_array($args['hero_image'] ?? null) && ! empty($args['hero_image']['src']) ? $args['hero_image'] : null;
$figures = array_values(array_filter((array) ($args['figures'] ?? []), static fn ($image): bool => is_array($image) && ! empty($image['src'])));
$next_steps = is_array($args['next_steps'] ?? null) ? $args['next_steps'] : [];
$next_links = array_slice((array) ($next_steps['links'] ?? []), 0, 3);
$product_links = array_slice((array) ($args['product_links'] ?? []), 0, 8);
$products = (array) ($args['products'] ?? []);
$description = trim((string) ($args['description'] ?? ''));
$form_source = (string) ($args['form_source'] ?? ('Blog: ' . $title));

$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);
$display_date = $date !== '' ? date_i18n('j F Y', (int) strtotime($date)) : '';
$minutes = fenster_blog_reading_minutes($sections, $lead);

/* A long opening paragraph crowds the first screen, which is the case for most
   of the imported guides. Over 320 characters it opens the body instead. */
$lead_in_hero = $lead !== '' && mb_strlen($lead) <= 320;

/* The body as a flat list of blocks, with an id on every section heading for
   the list of contents. */
$blocks = [];
$contents = [];
$used_ids = [];

if ($lead !== '' && ! $lead_in_hero) {
    $blocks[] = ['type' => 'lead', 'text' => $lead];
}

foreach ($sections as $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $lines = array_values(array_filter(array_map(static fn ($line): string => trim((string) $line), (array) ($section['body'] ?? [])), static fn (string $line): bool => $line !== ''));

    if ($legacy && $heading !== '') {
        $heading = fenster_blog_sentence_case($heading);
    }

    $section_blocks = [];
    if ($legacy) {
        foreach (fenster_blog_structure_legacy_body($lines) as $block) {
            if ($block['type'] === 'h3') {
                $block['text'] = fenster_blog_sentence_case($block['text']);
            }
            $section_blocks[] = $block;
        }
    } else {
        foreach ($lines as $line) {
            $section_blocks[] = ['type' => 'p', 'text' => $line];
        }
    }

    /* A guide section whose lines were all link leftovers ("Our system
       partners": "uPVC Windows", "and Liniar") goes, heading and all. */
    if ($section_blocks === [] && ($legacy || $heading === '')) {
        continue;
    }

    if ($heading !== '') {
        $id = fenster_blog_heading_id($heading, $used_ids);
        $blocks[] = ['type' => 'h2', 'text' => $heading, 'id' => $id];
        // A list of headings reads as a list; the full stops stay on the headings.
        $contents[] = ['id' => $id, 'text' => preg_replace('/(?<!\.)\.$/u', '', $heading)];
    }

    array_push($blocks, ...$section_blocks);
}

/* Photographs go in front of section headings spread through the body, never
   before the first one, so each sits between two thoughts rather than in one. */
$heading_positions = array_keys(array_filter($blocks, static fn (array $block): bool => $block['type'] === 'h2'));
$heading_positions = array_slice($heading_positions, 1);
$figures = array_slice($figures, 0, min(3, count($heading_positions)));
$figure_at = [];
foreach ($figures as $index => $figure) {
    $slot = (int) floor(($index + 1) * count($heading_positions) / (count($figures) + 1));
    $position = $heading_positions[min(max($slot, 0), count($heading_positions) - 1)] ?? null;
    if ($position !== null && ! isset($figure_at[$position])) {
        $figure_at[$position] = $figure;
    }
}

$show_contents = count($contents) >= 4;
/* With the contents beside it the body takes the hero's right-hand column,
   562px in the 1180px container; without, one centred 42rem column. */
$figure_sizes = $show_contents
    ? '(min-width: 1240px) 562px, (min-width: 1024px) 48vw, (min-width: 720px) 672px, calc(100vw - 2rem)'
    : '(min-width: 720px) 672px, calc(100vw - 2rem)';
$more_posts = fenster_blog_more_posts($kind === 'post' ? $slug : '', $products, 3);

/* A product already offered as a route above is not repeated as a chip. */
$link_path = static fn ($link): string => is_array($link) ? trim((string) wp_parse_url((string) ($link['url'] ?? ''), PHP_URL_PATH), '/') : '';
$route_paths = array_map($link_path, $next_links);
$product_links = array_values(array_filter($product_links, static fn ($link): bool => is_array($link) && ! in_array($link_path($link), $route_paths, true)));
$used_card_images = [];
if ($hero_image !== null) {
    $used_card_images[(string) $hero_image['src']] = true;
}

$image_url = static function (string $src): string {
    $url = function_exists('fenster_generated_url') ? fenster_generated_url($src) : $src;
    return str_starts_with($url, '/') ? home_url($url) : $url;
};

$schema = [
    '@context' => 'https://schema.org',
    '@type' => $kind === 'post' ? 'BlogPosting' : 'Article',
    'headline' => mb_substr($title, 0, 110),
    'mainEntityOfPage' => home_url('/' . $slug . '/'),
    'author' => ['@type' => 'Organization', 'name' => 'Fenster Glazing', 'url' => home_url('/')],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Fenster Glazing',
        'logo' => ['@type' => 'ImageObject', 'url' => FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png'],
    ],
];
if ($description !== '') {
    $schema['description'] = $description;
}
if ($hero_image !== null) {
    $schema['image'] = [$image_url((string) $hero_image['src'])];
}
if ($date !== '') {
    $schema['datePublished'] = $date;
    $schema['dateModified'] = $date;
    $schema['isPartOf'] = ['@type' => 'Blog', 'name' => 'Fenster Glazing blog', 'url' => home_url('/blog/')];
}
?>

<article class="fg-journal fg-journal--<?php echo esc_attr($kind); ?>">
    <header class="fg-journal-hero<?php echo $hero_image !== null ? ' fg-journal-hero--media' : ''; ?>">
        <div class="container fg-journal-hero__grid">
            <div class="fg-journal-hero__copy">
                <?php if ($kind === 'post') : ?>
                    <p class="eyebrow fg-journal-hero__eyebrow"><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'fenster'); ?></a></p>
                <?php else : ?>
                    <p class="eyebrow fg-journal-hero__eyebrow"><?php esc_html_e('Guide', 'fenster'); ?></p>
                <?php endif; ?>
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($lead_in_hero) : ?>
                    <p class="fg-journal-hero__lead"><?php echo esc_html($lead); ?></p>
                <?php endif; ?>
                <p class="fg-journal-meta">
                    <?php if ($display_date !== '') : ?>
                        <time datetime="<?php echo esc_attr($date); ?>"><?php echo esc_html($display_date); ?></time>
                    <?php endif; ?>
                    <span><?php echo esc_html(sprintf('%d min read', $minutes)); ?></span>
                </p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get a quote', 'fenster'); ?></a>
                    <a class="button button--steel" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
                </div>
            </div>
            <?php if ($hero_image !== null) : ?>
                <figure class="fg-journal-hero__media">
                    <img <?php echo fenster_blog_image_attrs((string) $hero_image['src'], ['alt' => (string) ($hero_image['alt'] ?? $title), 'sizes' => '(min-width: 1180px) 560px, (min-width: 900px) 46vw, 92vw', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                </figure>
            <?php endif; ?>
        </div>
    </header>

    <div class="container fg-journal-layout<?php echo $show_contents ? ' fg-journal-layout--contents' : ''; ?>">
        <?php if ($show_contents) : ?>
            <nav class="fg-journal-contents" aria-label="<?php esc_attr_e('On this page', 'fenster'); ?>">
                <details open data-fg-journal-contents>
                    <summary><?php esc_html_e('On this page', 'fenster'); ?></summary>
                    <ul>
                        <?php foreach ($contents as $entry) : ?>
                            <li><a href="#<?php echo esc_attr($entry['id']); ?>"><?php echo esc_html($entry['text']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </details>
            </nav>
        <?php endif; ?>

        <div class="fg-journal-body">
            <?php foreach ($blocks as $position => $block) : ?>
                <?php if (isset($figure_at[$position])) : ?>
                    <?php
                    $figure = $figure_at[$position];
                    /* Never wider than the photograph itself: some old gallery
                       shots are 600px, and stretched they turn soft. */
                    $figure_width = (int) (fenster_image_dimensions((string) $figure['src'])['width'] ?? 0);
                    ?>
                    <figure class="fg-journal-figure"<?php echo $figure_width > 0 ? ' style="--fg-figure-max: ' . esc_attr((string) $figure_width) . 'px"' : ''; ?>>
                        <img <?php echo fenster_blog_image_attrs((string) $figure['src'], ['alt' => (string) ($figure['alt'] ?? ''), 'sizes' => $figure_sizes, 'loading' => 'lazy']); ?>>
                        <?php if (! empty($figure['alt'])) : ?>
                            <figcaption><?php echo esc_html((string) $figure['alt']); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
                <?php if ($block['type'] === 'h2') : ?>
                    <h2 id="<?php echo esc_attr($block['id']); ?>"><?php echo esc_html($block['text']); ?></h2>
                <?php elseif ($block['type'] === 'h3') : ?>
                    <h3><?php echo esc_html($block['text']); ?></h3>
                <?php elseif ($block['type'] === 'ul') : ?>
                    <ul>
                        <?php foreach ($block['items'] as $item) : ?>
                            <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif ($block['type'] === 'lead') : ?>
                    <p class="fg-journal-body__lead"><?php echo esc_html($block['text']); ?></p>
                <?php else : ?>
                    <p><?php echo esc_html($block['text']); ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($next_links !== [] || $product_links !== []) : ?>
        <section class="fg-journal-next">
            <div class="container fg-journal-next__panel">
                <div class="fg-journal-next__copy">
                    <p class="eyebrow"><?php echo esc_html((string) ($next_steps['eyebrow'] ?? 'Next step')); ?></p>
                    <h2><?php echo esc_html((string) ($next_steps['title'] ?? 'See the products this guide covers.')); ?></h2>
                    <?php if (! empty($next_steps['copy'])) : ?>
                        <p><?php echo esc_html((string) $next_steps['copy']); ?></p>
                    <?php elseif ($next_links === []) : ?>
                        <p><?php esc_html_e('Each page covers the options we fit, photographs of our own work and how to get a price.', 'fenster'); ?></p>
                    <?php endif; ?>
                </div>
                <div class="fg-journal-next__routes">
                    <?php foreach ($next_links as $link) : ?>
                        <a class="fg-journal-route" href="<?php echo esc_url((string) ($link['url'] ?? home_url('/'))); ?>">
                            <strong><?php echo esc_html((string) ($link['label'] ?? '')); ?></strong>
                            <?php if (! empty($link['meta'])) : ?>
                                <span><?php echo esc_html((string) $link['meta']); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    <?php if ($product_links !== []) : ?>
                        <ul class="fg-journal-products" aria-label="<?php esc_attr_e('Products in this guide', 'fenster'); ?>">
                            <?php foreach ($product_links as $link) : ?>
                                <li><a href="<?php echo esc_url((string) $link['url']); ?>"><?php echo esc_html((string) $link['text']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($more_posts !== []) : ?>
        <section class="fg-journal-more" aria-labelledby="fg-journal-more-title">
            <div class="container">
                <div class="fg-journal-section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('From the blog', 'fenster'); ?></p>
                        <h2 id="fg-journal-more-title"><?php esc_html_e('Keep reading.', 'fenster'); ?></h2>
                    </div>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('All posts', 'fenster'); ?></a>
                </div>
                <div class="fg-journal-cards fg-journal-cards--three">
                    <?php foreach ($more_posts as $more_post) : ?>
                        <?php get_template_part('template-parts/components/blog-card', null, [
                            'post' => $more_post,
                            'image' => fenster_blog_post_card_image($more_post, $used_card_images),
                            'sizes' => '(min-width: 1180px) 370px, (min-width: 700px) 31vw, 92vw',
                        ]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-journal-enquiry">
        <div class="container fg-journal-enquiry__grid">
            <div class="fg-journal-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Send an enquiry', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you are dealing with.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Describe the window, door or project and roughly where you are. Photos help, but they are not required. We will review the details and contact you about the next step.', 'fenster'); ?></p>
                <ul>
                    <li><?php esc_html_e('Repairs, replacements and new installations', 'fenster'); ?></li>
                    <li><?php esc_html_e('Based in Milton Keynes, with our own fitters', 'fenster'); ?></li>
                    <li><?php echo esc_html(sprintf('Phone lines open 24/7 on %s', $phone)); ?></li>
                </ul>
            </div>
            <div class="fg-journal-enquiry__form">
                <?php get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form fg-blog-post-form',
                    'source' => $form_source,
                    'button_label' => 'Send enquiry',
                ]); ?>
            </div>
        </div>
    </section>

    <script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <?php if ($show_contents) : ?>
        <script>
        /* The list of contents is open for the sticky column on a wide screen
           and closed on a narrow one, where it would push the article down. */
        (function () {
            var contents = document.querySelector('[data-fg-journal-contents]');
            if (contents && window.matchMedia && window.matchMedia('(max-width: 1023px)').matches) {
                contents.open = false;
            }
        })();
        </script>
    <?php endif; ?>
</article>
