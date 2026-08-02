<?php
/**
 * Hardcoded contact page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$address = is_array($brand['address'] ?? null) ? $brand['address'] : [
    '98 Alston Drive',
    'Bradwell Abbey',
    'Milton Keynes',
    'Buckinghamshire MK13 9HF',
];
$address_string = implode(', ', $address);
$phone_href = preg_replace('/\s+/', '', $phone);
$map_query = rawurlencode('Fenster Glazing, ' . $address_string);
$map_embed = 'https://www.google.com/maps?q=' . $map_query . '&output=embed';
$map_link = 'https://www.google.com/maps/search/?api=1&query=' . $map_query;
$directions_link = 'https://www.google.com/maps/dir/?api=1&destination=' . $map_query;
$showroom_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';

/* The card photograph is a real <img>, not a background on the ::before.
   It used to be the third layer of a `background` shorthand on a pseudo-element
   at `z-index: -2` inside an `isolation: isolate` card, sitting under a page
   whose cookie modal applies `backdrop-filter: blur()`. That combination has to
   composite a negative-z layer through a filtered backdrop, and on the owner's
   machine it was dropping the photograph and leaving the flat colour underneath
   it: accent green on the quote card, steel on the showroom one, which is
   exactly what was reported. It could not be reproduced here, so this removes
   the fragile construction rather than chasing the compositor.

   The ::before keeps the gradient. The image is also right-sized on the way
   past: the showroom PNG was 2.37MB for a 580px card, which AUDIT.md has
   flagged since July. */
$hub_routes = [
    [
        'label' => 'Instant quote',
        'title' => 'Price windows and doors online.',
        'copy' => 'Open the quote tool, choose products, colours and sizes, then use the price as a starting point before survey.',
        'meta' => 'Fastest option',
        'url' => home_url('/online-quote/'),
        'image' => '/wp-content/themes/fenster/assets/images/contact/contact-hub-quote.webp',
    ],
    /* This card is the home visit, not a showroom chat. It said "Talk to the
       showroom team" and described a "showroom or project consultation", which
       is the wrong offer: we come out to the property. Owner correction,
       2026-08-02.

       Two things the same owner correction settled. The lead is the expert
       advice, not the price of the visit: free is true and stays, but it is the
       reassurance at the end rather than the headline. And **we do not measure
       at a consultation** — sizes taken there are rough, only enough to price
       the job. The real measurements are the technical survey, later. */
    [
        'label' => 'Consultation',
        'title' => 'Talk it through with an expert.',
        'copy' => 'One of our window and door experts comes to you, goes through the options for your property and prices the job before they leave. It is free, whether you go ahead or not.',
        'meta' => 'Expert advice',
        'url' => home_url('/book-a-consultation/'),
        /* Still the showroom exterior. Flagged to the owner on 2026-08-02: the
           picture says "come to our showroom" while the copy says we come to
           you, and there is no photograph anywhere in the theme of a consultant
           at a customer's home. Swap it when one exists. */
        'image' => '/wp-content/themes/fenster/assets/images/contact/contact-hub-showroom.webp',
    ],
];

$quick_routes = [
    ['label' => 'Home projects', 'title' => 'Windows, doors and glazing', 'copy' => 'For replacements, new openings, roof lanterns, integral blinds, glass units and repairs.', 'url' => home_url('/windows-milton-keynes/')],
    ['label' => 'Commercial work', 'title' => 'Sites, schools and businesses', 'copy' => 'For shopfronts, commercial glazing, doors, windows, louvres, AOV and project support.', 'url' => home_url('/commercial-glazing/')],
    ['label' => 'Price first', 'title' => 'Instant quote tool', 'copy' => 'Use online pricing for a quick product and price starting point before a final Fenster check.', 'url' => home_url('/online-quote/')],
];

/* These described the consultation booking flow, which is no longer the form on
   this page. Deliberately no promise of a confirmation email: those are gated
   on `fenster_smtp_is_configured()` and switch themselves on and off, so copy
   must not assert one. */
$form_notes = [
    'Attach photos, drawings or a schedule if it helps.',
    'Phone lines are answered 24 hours a day if it is urgent.',
    'For a figure first, the online quote tool prices your job in minutes.',
];
?>

<article class="fg-contact-page">
    <section class="fg-contact-hero">
        <div class="container fg-contact-hero__inner">
            <div class="fg-contact-hero__head">
                <p class="eyebrow"><?php esc_html_e('Contact Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('How do you want to start?', 'fenster'); ?></h1>
                <p><?php esc_html_e('Pick the fastest option for your windows, doors, glazing, repairs or showroom visit. The practical details are all below once you choose where you want to go.', 'fenster'); ?></p>
            </div>

            <div class="fg-contact-hub" aria-label="<?php esc_attr_e('Choose how to contact Fenster', 'fenster'); ?>">
                <?php foreach ($hub_routes as $index => $route) : ?>
                    <a class="fg-contact-hub-card <?php echo esc_attr($index === 0 ? 'fg-contact-hub-card--quote' : 'fg-contact-hub-card--showroom'); ?>" href="<?php echo esc_url($route['url']); ?>">
                        <?php if (! empty($route['image'])) : ?>
                            <img class="fg-contact-hub-card__media" <?php echo fenster_image_attr_string((string) $route['image'], [
                                'alt' => '',
                                'loading' => 'eager',
                                'decoding' => 'async',
                            ]); ?>>
                        <?php endif; ?>
                        <span><?php echo esc_html($route['label']); ?></span>
                        <strong><?php echo esc_html($route['title']); ?></strong>
                        <small><?php echo esc_html($route['copy']); ?></small>
                        <em><?php echo esc_html($route['meta']); ?></em>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="fg-contact-quickline" aria-label="<?php esc_attr_e('Direct contact details', 'fenster'); ?>">
                <a href="tel:<?php echo esc_attr($phone_href); ?>">
                    <span><?php esc_html_e('Call', 'fenster'); ?></span>
                    <strong><?php echo esc_html($phone); ?></strong>
                </a>
                <a href="mailto:<?php echo esc_attr($email); ?>">
                    <span><?php esc_html_e('Email', 'fenster'); ?></span>
                    <strong><?php echo esc_html($email); ?></strong>
                </a>
                <a href="#contact-showroom">
                    <span><?php esc_html_e('Showroom', 'fenster'); ?></span>
                    <strong><?php esc_html_e('Milton Keynes', 'fenster'); ?></strong>
                </a>
            </div>

            <div class="fg-contact-hero__showroom-strip">
                <img src="<?php echo esc_url($showroom_image); ?>" alt="<?php esc_attr_e('Fenster Glazing showroom exterior in Milton Keynes', 'fenster'); ?>" loading="eager">
                <div>
                    <span><?php esc_html_e('98 Alston Drive', 'fenster'); ?></span>
                    <p><?php esc_html_e('Visit the showroom for product displays, colour decisions, glazing advice and survey support.', 'fenster'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact-showroom" class="fg-contact-showroom">
        <div class="container fg-contact-showroom__grid">
            <div class="fg-contact-showroom__copy">
                <p class="eyebrow"><?php esc_html_e('Find the showroom', 'fenster'); ?></p>
                <h2><?php esc_html_e('Find our Milton Keynes showroom.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Use the map before you set off, or call ahead if you want to check product availability or arrange a design conversation.', 'fenster'); ?></p>
                <address>
                    <?php foreach ($address as $line) : ?>
                        <span><?php echo esc_html($line); ?></span>
                    <?php endforeach; ?>
                </address>
                <?php
                /* Showroom times only. This block answers "when can I turn up",
                   so the 24/7 phone line does not belong in it (owner
                   instruction, 2026-08-02). It reads brand.showroom_hours
                   rather than retyping the times, because a second copy is how
                   this and the footer end up disagreeing. */
                $showroom_hours = trim((string) ($brand['showroom_hours'] ?? ''));
                ?>
                <?php if ($showroom_hours !== '') : ?>
                    <p class="fg-contact-showroom__hours">
                        <span><?php esc_html_e('Opening hours', 'fenster'); ?></span>
                        <strong><?php echo esc_html($showroom_hours); ?></strong>
                    </p>
                <?php endif; ?>
                <div class="fg-contact-showroom__actions">
                    <a class="button" href="<?php echo esc_url($directions_link); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open directions', 'fenster'); ?></a>
                    <a class="text-link" href="<?php echo esc_url($map_link); ?>" target="_blank" rel="noopener"><?php esc_html_e('View on Google Maps', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-contact-showroom__map">
                <iframe
                    title="<?php esc_attr_e('Fenster Glazing showroom on Google Maps', 'fenster'); ?>"
                    src="<?php echo esc_url($map_embed); ?>"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <section class="fg-contact-route">
        <div class="container fg-contact-route__layout">
            <div class="fg-contact-section-head">
                <p class="eyebrow"><?php esc_html_e('What can we help with?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Not every enquiry starts in the same place.', 'fenster'); ?></h2>
            </div>
            <div class="fg-contact-route__rows">
                <?php foreach ($quick_routes as $route) : ?>
                    <a class="fg-contact-route-row" href="<?php echo esc_url($route['url']); ?>">
                        <span><?php echo esc_html($route['label']); ?></span>
                        <strong><?php echo esc_html($route['title']); ?></strong>
                        <small><?php echo esc_html($route['copy']); ?></small>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    /* The general enquiry form, restored 2026-08-02 on owner instruction.
       It was never removed on purpose: `931c7ef` ("Add reusable consultation
       booking form") converted this one include in place, taking the heading,
       source, button label and mode with it, so the page that the header,
       footer and nav all point at for "get in touch" had no way to simply send
       a message. Every version before that commit carried this form.

       The consultation booker is deliberately not here as well. It has its own
       indexable route at /book-a-consultation/ with its own SEO, FAQs and proof
       row, and the hub card at the top of this page already sends people there,
       so carrying it twice made the site repeat one journey and offer the other
       nowhere. Nothing linked to the old #book-consultation anchor. */
    ?>
    <section id="contact-enquiry" class="fg-contact-form-section">
        <div class="container fg-contact-form-section__grid">
            <div class="fg-contact-form-section__copy">
                <p class="eyebrow"><?php esc_html_e('Send an enquiry', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you need help with.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Windows, doors, a repair, a misted unit or a commercial job. Leave the details and we will come back to you. If you would rather have someone come out and go through it properly, book a free consultation instead.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
                <ul class="fg-contact-form-section__notes" aria-label="<?php esc_attr_e('Enquiry notes', 'fenster'); ?>">
                    <?php foreach ($form_notes as $note) : ?>
                        <li><?php echo esc_html($note); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-contact-form',
                'source' => 'Contact page',
                'button_label' => 'Send enquiry',
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--contact',
            'eyebrow' => 'Customer proof',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>

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
