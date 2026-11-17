<?php
/**
 * The winter guide: /stop-window-draughts/.
 *
 * The page idea: someone is sitting in a cold room, often renting, often with
 * single-glazed sashes, and has typed or asked "how do I stop my windows
 * leaking heat". The first screen gives them the short answer. The rest reads
 * like an article in the blog's own layout, with the headings listed beside
 * it, each heading the question they would ask, and three small diagrams where
 * a picture explains something faster than a sentence. The renting section is
 * written to be followed in order. Then the questions, what we do, and the
 * enquiry form.
 *
 * All the words are in inc/warm-guide-data.php; the diagrams are in
 * inc/warm-guide-graphics.php. Styles are the blog's (assets/blog/blog.css)
 * plus a small sheet for the guide's own blocks (src/warm/warm.scss).
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once FENSTER_THEME_DIR . '/inc/warm-guide-graphics.php';

if (function_exists('fenster_blog_print_stylesheet_fallback')) {
    fenster_blog_print_stylesheet_fallback();
}

$warm = fenster_warm_guide_data();
$sections = (array) $warm['sections'];
$sources = (array) $warm['sources'];
$guide_url = fenster_warm_guide_url();

/* Reading time from every word on the page, at 220 words a minute. */
$all_text = $warm['lead'] . ' ' . implode(' ', (array) $warm['answer']['items']);
foreach ($sections as $section) {
    foreach ((array) $section['blocks'] as $block) {
        $all_text .= ' ' . ($block['text'] ?? '') . ' ' . implode(' ', (array) ($block['items'] ?? []));
        foreach ((array) ($block['rows'] ?? []) as $row) {
            $all_text .= ' ' . implode(' ', (array) $row);
        }
    }
}
foreach ((array) $warm['faq']['items'] as $faq) {
    $all_text .= ' ' . $faq['question'] . ' ' . $faq['answer'];
}
$minutes = max(1, (int) ceil(str_word_count(wp_strip_all_tags($all_text)) / 220));

/* The list of contents: the short answer, every question, then the FAQ and
   the sources. A full stop is dropped from a heading in the list; a question
   mark stays. */
$contents = [['id' => 'short-answer', 'text' => 'The short answer']];
foreach ($sections as $section) {
    $contents[] = ['id' => $section['id'], 'text' => preg_replace('/\.$/u', '', $section['heading'])];
}
$contents[] = ['id' => 'questions', 'text' => 'More questions'];
$contents[] = ['id' => 'sources', 'text' => 'Where the figures come from'];

/* Further reading: every winter post that links up to this guide, once it is
   live, under its own title, then the older guides in the data file. */
$posts = function_exists('fenster_blog_posts') ? fenster_blog_posts() : [];
$related = [];
foreach (fenster_warm_guide_related_posts() as $post_slug) {
    $post = $posts[$post_slug] ?? null;
    if (is_array($post) && function_exists('fenster_blog_post_is_live') && fenster_blog_post_is_live($post)) {
        $related[] = ['label' => (string) ($post['title'] ?? $post_slug), 'url' => '/' . $post_slug . '/'];
    }
}
foreach ((array) $warm['related'] as $link) {
    if (($link['post'] ?? '') === '') {
        $related[] = $link;
    }
}

$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$updated = (string) $warm['updated'];

$photo_url = '';
foreach ($sections as $section) {
    foreach ((array) $section['blocks'] as $block) {
        if (($block['type'] ?? '') === 'photo' && $photo_url === '') {
            $photo_url = FENSTER_THEME_URI . $block['src'];
        }
    }
}

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => (string) $warm['title'],
    'description' => (string) $warm['description'],
    'mainEntityOfPage' => $guide_url,
    'datePublished' => $updated,
    'dateModified' => $updated,
    'author' => ['@type' => 'Organization', 'name' => 'Fenster Glazing', 'url' => home_url('/')],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Fenster Glazing',
        'logo' => ['@type' => 'ImageObject', 'url' => FENSTER_THEME_URI . '/assets/brand/18931%20Fenster%20Glazing%20Logo%20-%20White%20Background.png'],
    ],
    'about' => ['Draught-proofing', 'Single glazing', 'Sash windows', 'Secondary glazing', 'Renting'],
    'citation' => array_values(array_unique(array_map(static fn (array $source): string => (string) $source['url'], $sources))),
];
if ($photo_url !== '') {
    $schema['image'] = [str_starts_with($photo_url, '/') ? home_url($photo_url) : $photo_url];
}
?>

<article class="fg-journal fg-journal--guide fg-warm">
    <header class="fg-journal-hero">
        <div class="container fg-journal-hero__grid">
            <div class="fg-journal-hero__copy">
                <p class="eyebrow fg-journal-hero__eyebrow"><?php echo esc_html($warm['eyebrow']); ?></p>
                <h1><?php echo esc_html($warm['title']); ?></h1>
                <p class="fg-journal-hero__lead"><?php echo esc_html($warm['lead']); ?></p>
                <p class="fg-journal-meta">
                    <span><?php esc_html_e('Updated', 'fenster'); ?> <time datetime="<?php echo esc_attr($updated); ?>"><?php echo esc_html(date_i18n('j F Y', (int) strtotime($updated))); ?></time></span>
                    <span><?php echo esc_html(sprintf('%d min read', $minutes)); ?></span>
                </p>
                <div class="button-row">
                    <a class="button" href="#tonight"><?php esc_html_e('Fixes for tonight', 'fenster'); ?></a>
                    <a class="button button--steel" href="#i-rent"><?php esc_html_e('If you rent', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </header>

    <div class="container fg-journal-layout fg-journal-layout--contents">
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

        <div class="fg-journal-body">
            <section class="fgw-answer" aria-labelledby="short-answer">
                <h2 id="short-answer"><?php echo esc_html($warm['answer']['title']); ?></h2>
                <ul>
                    <?php foreach ((array) $warm['answer']['items'] as $item) : ?>
                        <li><?php echo fenster_warm_inline($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <nav class="fgw-jump" aria-label="<?php echo esc_attr($warm['jump']['label']); ?>">
                <p><?php echo esc_html($warm['jump']['label']); ?></p>
                <ul>
                    <?php foreach ((array) $warm['jump']['links'] as $link) : ?>
                        <li><a href="<?php echo esc_attr($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <?php foreach ($sections as $section) : ?>
                <h2 id="<?php echo esc_attr($section['id']); ?>"><?php echo esc_html($section['heading']); ?></h2>

                <?php foreach ((array) $section['blocks'] as $block) : ?>
                    <?php if ($block['type'] === 'h3') : ?>
                        <h3><?php echo esc_html($block['text']); ?></h3>

                    <?php elseif ($block['type'] === 'ul') : ?>
                        <ul>
                            <?php foreach ((array) $block['items'] as $item) : ?>
                                <li><?php echo fenster_warm_inline($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
                            <?php endforeach; ?>
                        </ul>

                    <?php elseif ($block['type'] === 'note') : ?>
                        <aside class="fgw-note"><p><?php echo fenster_warm_inline($block['text']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p></aside>

                    <?php elseif ($block['type'] === 'anim') : ?>
                        <figure class="fgw-figure fgw-figure--<?php echo esc_attr($block['key']); ?>" data-fgw-anim>
                            <div class="fgw-figure__art"><?php echo fenster_warm_diagram($block['key']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                            <figcaption>
                                <?php if (! empty($block['legend'])) : ?>
                                    <ul class="fgw-legend">
                                        <?php foreach ((array) $block['legend'] as $key) : ?>
                                            <li><span class="fgw-legend__swatch fgw-legend__swatch--<?php echo esc_attr($key['swatch']); ?>" aria-hidden="true"></span><?php echo esc_html($key['label']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php echo esc_html($block['caption']); ?>
                            </figcaption>
                        </figure>

                    <?php elseif ($block['type'] === 'photo') :
                        $photo_attrs = ['alt' => (string) $block['alt'], 'loading' => 'lazy', 'sizes' => '(min-width: 1240px) 562px, (min-width: 1024px) 48vw, (min-width: 720px) 672px, calc(100vw - 2rem)'];
                        /* A theme without `fenster_image_srcset()` (live, 17/11/2026) adds no WebP copies itself, so ask for them here. */
                        if (! function_exists('fenster_image_srcset')) {
                            $photo_srcset = fenster_warm_manifest_srcset((string) $block['src']);
                            if ($photo_srcset !== '') {
                                $photo_attrs['srcset'] = $photo_srcset;
                            }
                        }
                        ?>
                        <figure class="fg-journal-figure fgw-photo">
                            <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . $block['src'], $photo_attrs); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <figcaption><?php echo fenster_warm_inline($block['caption']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figcaption>
                        </figure>

                    <?php elseif ($block['type'] === 'table') : ?>
                        <div class="fgw-table">
                            <table>
                                <caption><?php echo esc_html($block['caption']); ?></caption>
                                <thead>
                                    <tr>
                                        <?php foreach ((array) $block['columns'] as $index => $column) : ?>
                                            <?php if ($index === 0 && $column === '') : ?>
                                                <td></td>
                                            <?php else : ?>
                                                <th scope="col"><?php echo esc_html($column); ?></th>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ((array) $block['rows'] as $row) : ?>
                                        <tr>
                                            <?php foreach (array_values((array) $row) as $index => $cell) : ?>
                                                <?php if ($index === 0) : ?>
                                                    <th scope="row"><?php echo esc_html($cell); ?></th>
                                                <?php else : ?>
                                                    <td data-label="<?php echo esc_attr($block['columns'][$index] ?? ''); ?>"><?php echo fenster_warm_inline($cell); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php elseif ($block['type'] === 'letter') : ?>
                        <div class="fgw-letter" id="<?php echo esc_attr($block['id']); ?>">
                            <div class="fgw-letter__head">
                                <p class="fgw-letter__title"><?php echo esc_html($block['title']); ?></p>
                                <button class="fgw-letter__copy" type="button" data-fgw-copy data-fgw-copied="<?php echo esc_attr($block['copied_label']); ?>" hidden><?php echo esc_html($block['copy_label']); ?></button>
                            </div>
                            <p class="fgw-letter__hint"><?php echo esc_html($block['hint']); ?></p>
                            <div class="fgw-letter__text" data-fgw-letter>
                                <?php foreach (explode("\n\n", (string) $block['text']) as $paragraph) : ?>
                                    <p><?php echo nl2br(esc_html($paragraph), false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    <?php else : ?>
                        <p><?php echo fenster_warm_inline((string) ($block['text'] ?? '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <?php if ($related !== []) : ?>
                <h2 id="read-next"><?php esc_html_e('Read next.', 'fenster'); ?></h2>
                <ul>
                    <?php foreach ($related as $link) : ?>
                        <li><a href="<?php echo esc_url(home_url($link['url'])); ?>"><?php echo esc_html($link['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div id="questions" class="fgw-faq">
        <?php get_template_part('template-parts/components/faq-block', null, [
            'faqs' => (array) $warm['faq']['items'],
            'heading' => (string) $warm['faq']['title'],
            'eyebrow' => (string) $warm['faq']['eyebrow'],
            'id' => 'fgw-faq-title',
        ]); ?>
    </div>

    <section class="fg-journal-next">
        <div class="container fg-journal-next__panel">
            <div class="fg-journal-next__copy">
                <p class="eyebrow"><?php echo esc_html($warm['next']['eyebrow']); ?></p>
                <h2><?php echo esc_html($warm['next']['title']); ?></h2>
                <p><?php echo esc_html($warm['next']['copy']); ?></p>
                <div class="button-row fgw-next-buttons">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a consultation', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-journal-next__routes">
                <?php foreach ((array) $warm['next']['routes'] as $route) : ?>
                    <a class="fg-journal-route" href="<?php echo esc_url(home_url($route['url'])); ?>">
                        <strong><?php echo esc_html($route['label']); ?></strong>
                        <span><?php echo esc_html($route['meta']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fgw-sources" aria-labelledby="sources">
        <div class="container">
            <h2 id="sources"><?php echo esc_html($warm['sources_title']); ?></h2>
            <p><?php echo esc_html($warm['sources_intro']); ?></p>
            <ul>
                <?php
                $listed = [];
                foreach ($sources as $source) :
                    if (isset($listed[$source['url']])) {
                        continue;
                    }
                    $listed[$source['url']] = true;
                    ?>
                    <li><a href="<?php echo esc_url($source['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($source['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section id="fenster-enquiry" class="fg-journal-enquiry">
        <div class="container fg-journal-enquiry__grid">
            <div class="fg-journal-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Send an enquiry', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us about your windows.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Say what kind of windows they are and what is wrong, and roughly where you are. Photos help, but they are not required. We will look at the details and contact you about the next step.', 'fenster'); ?></p>
                <ul>
                    <li><?php esc_html_e('Repairs, secondary glazing and new windows', 'fenster'); ?></li>
                    <li><?php esc_html_e('Based in Milton Keynes, with our own fitters', 'fenster'); ?></li>
                    <li><?php echo esc_html(sprintf('Phone lines open 24/7 on %s', $phone)); ?></li>
                </ul>
            </div>
            <div class="fg-journal-enquiry__form">
                <?php get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form fg-blog-post-form',
                    'source' => (string) $warm['enquiry_source'],
                    'button_label' => 'Send enquiry',
                ]); ?>
            </div>
        </div>
    </section>

    <script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>
    <script>
    /* As on the blog: the list of contents is open in the sticky column on a
       wide screen and closed on a narrow one, where it would push the article
       down. */
    (function () {
        var contents = document.querySelector('[data-fg-journal-contents]');
        if (contents && window.matchMedia && window.matchMedia('(max-width: 1023px)').matches) {
            contents.open = false;
        }
    })();
    </script>
</article>
