<?php
/**
 * The instant quote tool page.
 *
 * This route used to share `quote-tool.php` with `/3d-visualiser/` and five
 * other slugs, which rendered them as the same page with a different H1. That
 * left three self-canonicalling near-duplicates competing for the same intent.
 * This template is `online-quote` only; the others stay on the shared one until
 * the visualiser gets its own treatment.
 *
 * The walkthrough below is the tool as it actually behaves, checked screen by
 * screen on 2026-08-06 against the live retail interface. **The price is shown
 * after a required name, email, phone, address and postcode**, not during
 * configuration, and the page says so in three places rather than implying
 * otherwise. If the tool's flow changes, re-walk it before editing this copy.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$title = (string) ($args['title'] ?? ($page['title'] ?? 'Online quote'));
$quote_url = (string) ($args['instant_quote_url'] ?? 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing');
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$img_base = FENSTER_THEME_URI . '/assets/images/quote-tool/';

/* The six screens, in the order the tool presents them. Each image is a
   screenshot of our own tool, cut through one shared 4:3 window so the set
   stays the same size; see the note at the top of this file. */
$steps = [
    [
        'title' => 'Pick what you are pricing.',
        'copy'  => 'Composite doors, uPVC and aluminium windows, sash windows, patio and bifold doors, replacement glass and secondary glazing all price here. Choose the one you want a figure for.',
        'image' => 'quote-step-1-product.webp',
        'alt'   => 'The first screen of our quote tool, showing product ranges to choose from including composite doors, uPVC windows and aluminium bifold doors.',
    ],
    [
        'title' => 'Set the sizes.',
        'copy'  => 'Width and height in millimetres. Measure the existing frame roughly and you will be close enough for a price. The proper measurements happen at the technical survey, later.',
        'image' => 'quote-step-2-sizes.webp',
        'alt'   => 'The sizes step, with width and height in millimetres beside a render of the window.',
    ],
    [
        'title' => 'Choose how it opens.',
        'copy'  => 'Pick the layout from the grid: which panes open, where the transom sits, which way the hinges go. The render redraws as you choose, so you can see it rather than imagine it.',
        'image' => 'quote-step-3-layout.webp',
        'alt'   => 'The frame style step, showing a grid of window layout options with one selected.',
    ],
    [
        'title' => 'Pick the colours.',
        'copy'  => 'Outside and inside are chosen separately, from the foil range we actually fit. Anthracite outside with white inside is the common one, and this is where you find out whether you like it.',
        'image' => 'quote-step-4-colour.webp',
        'alt'   => 'The outside colour step, with the window render redrawn in anthracite grey beside the colour swatches.',
    ],
    [
        'title' => 'Choose the glass and the handles.',
        'copy'  => 'Toughened, laminated, acoustic laminated or triple glazed, plus obscure patterns where you want privacy, then the handle style and finish. Every one of these moves the price.',
        'image' => 'quote-step-5-glass.webp',
        'alt'   => 'The glazing step, showing the glass specification options for the window being priced.',
    ],
    [
        'title' => 'See the price.',
        'copy'  => 'Add another frame if you are doing more than one opening, and they price together. Then you fill in your details and the figure appears.',
        'image' => 'quote-step-6-price.webp',
        'alt'   => 'The summary screen, listing the configured window with its colours and glazing beside the option to add another frame or see the price.',
    ],
];

$before = [
    'A rough width and height for each opening, in millimetres.',
    'Your address and postcode.',
    'Some idea of the colour you want, outside and in.',
    'How many openings you are pricing.',
];

$after = [
    'The price appears on screen, and the same quote reaches us.',
    'We check the specification suits the opening before anything else happens.',
    'If you go ahead, a technical survey takes the proper measurements before anything is made.',
    'The price is the price. There is no discount held back for a second visit.',
];

$faqs = [
    [
        'question' => 'Do I have to give my details to see the price?',
        'answer'   => 'Yes. The tool asks for your name, address, phone and email before it shows the figure, and the quote reaches us at the same time. Nothing is ordered by doing it, and a quote normally holds for 30 days.',
    ],
    [
        'question' => 'Is it a real price or an estimate?',
        'answer'   => 'It prices from the same list our office quotes from, so it is the figure we would charge for that specification. What can still change it is the opening itself: access, the state of what is there now, and anything the survey turns up.',
    ],
    [
        'question' => 'Will somebody ring me?',
        'answer'   => 'Yes. We check the specification is right for the opening before anything else, because a window priced against the wrong opening helps nobody.',
    ],
    [
        'question' => 'Can I price a whole house?',
        'answer'   => 'Yes. Configure one opening, add a frame, and repeat until every window or door is in the list. They price together as one job.',
    ],
    [
        'question' => 'What if my window is not a standard shape?',
        'answer'   => 'Price the nearest thing to it and say so in the comments box. Shaped heads, bays and anything structural are better settled at a consultation, where somebody looks at the opening with you.',
    ],
    [
        'question' => 'How is this different from a consultation?',
        'answer'   => 'This is you pricing the job yourself in about ten minutes. A consultation is an hour at your property with a window and door expert, who builds the same job on the same software and prices it in front of you. Both are free, and the figure matches.',
    ],
];

$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ],
        $faqs
    ),
];
?>

<article class="fg-oq">
    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>

    <section id="fenster-quote-tool" class="fg-oq-hero" data-quote-card>
        <div class="container fg-oq-hero__grid">
            <div class="fg-oq-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                <h1><?php esc_html_e('Price your windows and doors online.', 'fenster'); ?></h1>
                <p class="fg-oq-hero__lead"><?php esc_html_e('Build the job the way you would order it. Your sizes in millimetres, the way it opens, the colour outside and in, the glass and the handles. It prices from the same list our office quotes from, so the number you see is the number we would charge.', 'fenster'); ?></p>
                <div class="button-row">
                    <?php /* Desktop opens the embed in place and records a deliberate open;
                             mobile gets one same-tab action instead, per the quote-embed rule
                             in AI.md. Never both on one screen. */ ?>
                    <button class="button fg-oq-hero__start" type="button" data-load-quote><?php esc_html_e('Start your quote', 'fenster'); ?></button>
                    <a class="button fg-oq-hero__start-mobile" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </div>
                <ul class="fg-oq-hero__points">
                    <li><?php esc_html_e('The tool on the right is live. Start clicking whenever you like', 'fenster'); ?></li>
                    <li><?php esc_html_e('The same price list our office quotes from', 'fenster'); ?></li>
                    <li><?php esc_html_e('Your details come before the number, and nothing is ordered', 'fenster'); ?></li>
                </ul>
            </div>

            <?php /* The embed reads as a screenshot until you touch it, which is the
                     single largest measured drop on the site: 182 journeys were shown
                     the tool in the 24 days to 5 August 2026 and 21 opened it, while
                     57% of the ones who opened it finished a quote. Everything in this
                     block exists to say "this is live, go straight in". */ ?>
            <div class="fg-oq-hero__tool" data-fg-tool-cue>
                <div class="fg-oq-hero__tool-bar">
                    <h2>
                        <?php esc_html_e('The quote tool', 'fenster'); ?>
                        <span class="fg-oq-live"><i aria-hidden="true"></i><?php esc_html_e('Live', 'fenster'); ?></span>
                    </h2>
                    <div class="fg-oq-hero__tool-actions">
                        <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                        <a class="button" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                    </div>
                </div>
                <div class="fg-oq-hero__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="idle">
                    <div class="fg-quote-frame-placeholder">
                        <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                        <span><?php esc_html_e('The tool loads in a moment, or you can open it now.', 'fenster'); ?></span>
                        <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                    </div>
                    <iframe
                        data-quote-iframe-src="<?php echo esc_url($quote_url); ?>"
                        title="<?php esc_attr_e('Fenster instant quote tool', 'fenster'); ?>"
                        loading="lazy"
                        allow="fullscreen"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                    <?php /* A ghost hand drifting over the tool and tapping it. Showing
                             that the embed is live works better than a line of copy
                             saying so, which is what this replaced. Decorative only:
                             aria-hidden, no pointer events, and it stops for good the
                             moment the visitor touches the tool themselves. */ ?>
                    <div class="fg-oq-ghost" aria-hidden="true">
                        <div class="fg-oq-ghost__travel">
                            <span class="fg-oq-ghost__tap"></span>
                            <svg class="fg-oq-ghost__hand" viewBox="0 0 24 24" width="38" height="38" focusable="false">
                                <path d="M10 3.6a1.5 1.5 0 0 1 3 0V11h.4a1.9 1.9 0 0 1 3.8 0v.6a1.9 1.9 0 0 1 1.9 1.9V17a4.2 4.2 0 0 1-4.2 4.2h-2.7a4.2 4.2 0 0 1-3-1.3l-3.9-4a1.6 1.6 0 0 1 2.2-2.3L10 15.2Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-oq-steps">
        <div class="container">
            <div class="fg-oq-section-head">
                <p class="eyebrow"><?php esc_html_e('How it works', 'fenster'); ?></p>
                <h2><?php esc_html_e('Six screens, and this is all of them.', 'fenster'); ?></h2>
                <p><?php esc_html_e('There is nothing you need to know in advance and no jargon to get past. These are the actual screens, in the order the tool asks.', 'fenster'); ?></p>
            </div>
            <ol class="fg-oq-steps__grid">
                <?php foreach ($steps as $index => $step) : ?>
                    <li class="fg-oq-step">
                        <figure class="fg-oq-step__media">
                            <img <?php echo fenster_image_attr_string($img_base . $step['image'], [
                                'alt' => $step['alt'],
                                'loading' => $index < 2 ? 'eager' : 'lazy',
                            ]); ?>>
                        </figure>
                        <div class="fg-oq-step__copy">
                            <span class="fg-oq-step__number"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <h3><?php echo esc_html($step['title']); ?></h3>
                            <p><?php echo esc_html($step['copy']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
            <div class="fg-oq-steps__action">
                <a class="button" href="#fenster-quote-tool"><?php esc_html_e('Start your quote', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-oq-practical">
        <div class="container fg-oq-practical__grid">
            <div class="fg-oq-practical__panel">
                <p class="eyebrow"><?php esc_html_e('Before you start', 'fenster'); ?></p>
                <h2><?php esc_html_e('Worth having to hand.', 'fenster'); ?></h2>
                <ul>
                    <?php foreach ($before as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-oq-practical__note"><?php esc_html_e('A tape measure and five minutes is genuinely enough. Nobody expects survey accuracy from a homeowner on a windowsill.', 'fenster'); ?></p>
            </div>
            <div class="fg-oq-practical__panel fg-oq-practical__panel--dark">
                <p class="eyebrow"><?php esc_html_e('After you send it', 'fenster'); ?></p>
                <h2><?php esc_html_e('What actually happens next.', 'fenster'); ?></h2>
                <ul>
                    <?php foreach ($after as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <div class="button-row">
                    <a class="button button--light" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html(sprintf('Call %s', $phone)); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-oq-faq">
        <div class="container fg-oq-faq__grid">
            <div class="fg-oq-faq__head">
                <p class="eyebrow"><?php esc_html_e('Quote questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('The things people ask before they start.', 'fenster'); ?></h2>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="quote-form" class="fg-oq-form">
        <div class="container fg-oq-form__grid">
            <div class="fg-oq-form__copy">
                <p class="eyebrow"><?php esc_html_e('Rather describe it?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you are looking for.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Some jobs are quicker to explain than to configure. Send us the details and we will come back to you, and you can attach drawings, schedules or photographs of the openings if they help.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => 'Online quote',
                'button_label' => 'Send the details',
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--quote',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>
</article>
