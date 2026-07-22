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
$slug = trim((string) ($page['slug'] ?? ''), '/');

$article_next_steps_map = [
    // These four guides draw large impression volumes with almost no route
    // into a money page: soundproofing 14.5k, U-values 12.1k, acoustic vs
    // triple 3.5k and condensation 2.4k impressions a quarter between them.
    // Each next step is the genuine commercial answer to the question asked,
    // not a generic CTA.
    'soundproof-windows' => [
        'eyebrow' => 'Want a quieter room?',
        'title' => 'Cutting road and neighbour noise at the window.',
        'copy' => 'Noise usually gets in through the glass, the frame seals or the gaps around them. We can look at which of those is the problem in your room before you spend money on the wrong fix.',
        'links' => [
            ['label' => 'Secondary glazing', 'url' => home_url('/secondary-glazing/'), 'meta' => 'A second internal pane for noise'],
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Thicker units and better seals'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'When the seals are the problem'],
        ],
    ],
    'a-guide-to-understanding-u-values' => [
        'eyebrow' => 'Comparing efficiency?',
        'title' => 'What the U-value means for your rooms and your bills.',
        'copy' => 'A lower U-value means less heat escaping. We can tell you the real figure for each window we fit, so you can compare like with like rather than headline claims.',
        'links' => [
            ['label' => 'Double glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/'), 'meta' => 'Windows, doors and replacement glass'],
            ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'A+ rated options with real figures'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'which-is-better-triple-or-acoustic-glazing' => [
        'eyebrow' => 'Noise or heat?',
        'title' => 'Choose the glazing for the problem you actually have.',
        'copy' => 'Triple glazing and acoustic glass solve different things. Tell us which room, which noise and which direction it faces, and we can point you at the right specification.',
        'links' => [
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare glazing specifications'],
            ['label' => 'Secondary glazing', 'url' => home_url('/secondary-glazing/'), 'meta' => 'Often the better answer for noise'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'how-to-prevent-window-condensation-in-winter' => [
        'eyebrow' => 'Condensation between the panes?',
        'title' => 'Misting inside the glass is a failed unit, not condensation.',
        'copy' => 'Condensation on the inside face is usually ventilation. Misting sealed between the panes means the unit itself has failed, and that we can replace without changing the whole window.',
        'links' => [
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Misted units, seals and hardware'],
            ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When the frame has gone too'],
            ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
        ],
    ],
    'what-is-a-door-lintel' => [
        'eyebrow' => 'Planning door work?',
        'title' => 'Need a doorway checked before new doors or glazing?',
        'copy' => 'If a door opening, lintel or frame condition affects the project, Fenster can check the practical details before replacement doors or glazing are ordered.',
        'links' => [
            ['label' => 'View doors', 'url' => home_url('/doors-milton-keynes/'), 'meta' => 'Front, patio, French and bifold options'],
            ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Secure entrance door replacements'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'When the opening needs attention first'],
        ],
    ],
    'different-types-of-window-frame-materials' => [
        'eyebrow' => 'Choosing frames?',
        'title' => 'Compare window materials around your home, not just the brochure.',
        'copy' => 'Frame material affects sightlines, colour, maintenance, insulation and cost. Start with the main window ranges, then Fenster can help narrow the specification.',
        'links' => [
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare uPVC, aluminium and heritage styles'],
            ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/'), 'meta' => 'Slim frames and modern finishes'],
            ['label' => 'Colour options', 'url' => home_url('/colour-options/'), 'meta' => 'uPVC and aluminium frame colours'],
        ],
    ],
    'what-is-double-glazing-and-how-does-it-work' => [
        'eyebrow' => 'Ready to compare options?',
        'title' => 'Turn double glazing research into a practical quote.',
        'copy' => 'Fenster can help compare windows, doors, replacement glass and frame choices around the rooms you want to improve.',
        'links' => [
            ['label' => 'Double glazing Milton Keynes', 'url' => home_url('/double-glazing-milton-keynes/'), 'meta' => 'Windows, doors and replacement glass'],
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Browse the main window styles'],
            ['label' => 'Start an online quote', 'url' => home_url('/online-quote/'), 'meta' => 'Get a guide price before survey'],
        ],
    ],
    'what-are-double-glazed-glass-windows' => [
        'eyebrow' => 'Glass or full window?',
        'title' => 'Check whether you need replacement glass or new windows.',
        'copy' => 'If the frame is sound, failed glass may be replaceable. If the frame, seals or hardware are tired, a full window replacement may make more sense.',
        'links' => [
            ['label' => 'Double glazing replacement', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Failed sealed units and replacement glass'],
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare complete window options'],
            ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, hinges, glass and frame issues'],
        ],
    ],
    'all-you-need-to-know-about-louvre-vents' => [
        'eyebrow' => 'Commercial ventilation',
        'title' => 'Need louvres as part of a commercial glazing package?',
        'copy' => 'Louvre panels usually need airflow, free-area, colour and facade details checked before they are priced or fitted.',
        'links' => [
            ['label' => 'Louvre vents', 'url' => home_url('/louvre-vents/'), 'meta' => 'Commercial louvre panels and ventilation'],
            ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/'), 'meta' => 'Windows, doors, facades and glass'],
            ['label' => 'Commercial windows and doors', 'url' => home_url('/commercial-windows-and-doors/'), 'meta' => 'Replacement and refurbishment works'],
        ],
    ],
    'the-history-of-upvc-windows' => [
        'eyebrow' => 'Considering uPVC?',
        'title' => 'Compare modern uPVC windows with today\'s frame options.',
        'copy' => 'Modern uPVC windows can be secure, efficient and low maintenance, but aluminium, flush and heritage styles may suit some homes better.',
        'links' => [
            ['label' => 'Windows in Milton Keynes', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare all main window ranges'],
            ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'Practical uPVC window style'],
            ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/'), 'meta' => 'Cleaner traditional look'],
        ],
    ],
];
$article_next_steps = $article_next_steps_map[$slug] ?? [];

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
                    <img <?php echo fenster_image_attr_string((string) $hero_image['src'], ['alt' => (string) ($hero_image['alt'] ?? $title), 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                </figure>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($article_next_steps)) : ?>
        <section class="fg-article-next-steps">
            <div class="container fg-article-next-steps__inner">
                <div class="fg-article-next-steps__copy">
                    <p class="eyebrow"><?php echo esc_html((string) ($article_next_steps['eyebrow'] ?? 'Next step')); ?></p>
                    <h2><?php echo esc_html((string) ($article_next_steps['title'] ?? 'Plan the next step with Fenster.')); ?></h2>
                    <p><?php echo esc_html((string) ($article_next_steps['copy'] ?? 'Explore the most relevant Fenster products and services for this guide.')); ?></p>
                </div>
                <div class="fg-article-next-steps__links">
                    <?php foreach (array_slice((array) ($article_next_steps['links'] ?? []), 0, 4) as $link) : ?>
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
                            <img <?php echo fenster_image_attr_string((string) $inline_image['src'], ['alt' => (string) ($inline_image['alt'] ?? $title), 'loading' => 'lazy']); ?>>
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
                'class' => 'fg-form fg-article-form',
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
