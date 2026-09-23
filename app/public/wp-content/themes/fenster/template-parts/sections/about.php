<?php
/**
 * Hardcoded about page.
 *
 * Hard-won implementation notes, do not undo these:
 *
 * 1. Every image goes through fenster_image_attr_string() for real width/height
 *    attributes. An earlier version used height:auto with loading="lazy" and no
 *    dimensions, which collapsed the gallery to zero height, so the images never
 *    entered the viewport and never loaded at all.
 * 2. Images carrying real height attributes need an explicit CSS height, or the
 *    attribute beats aspect-ratio and renders them at full natural size. That
 *    once produced 2560px-tall portraits.
 * 3. The award video loads deferred: sources carry data-src and the
 *    [data-fg-about-video] handler in src/js/main.js attaches it near the
 *    viewport, with poster plus controls under reduced motion. The hero is the
 *    showroom photograph by owner request; the data-fg-video-bg background
 *    handling remains in main.js should a background video ever return.
 * 4. Videos are absolutely positioned inside aspect-ratio boxes. In flow they
 *    feed intrinsic size into the grid row and the box derives the wrong width.
 * 5. CTAs are buttons. Text links for primary actions are a STYLE.md failure.
 * 6. No multi-image parallax on this page. The owner rejected it at every
 *    strength that was visible.
 *
 * Copy rules from the owner, 2026-07-20: the page opens with the mission, not
 * the quote tool. The pricing comparison presents two routes Fenster genuinely
 * offers, online or a priced-on-the-spot consultation, as equals; do not mock
 * the traditional route, because we sell it too. Both run on the same pricing
 * software, so the number is the same either way, and that fact belongs on the
 * page. Do not reinstate the founding anecdote. Do not claim the quote tool
 * gives a price without taking any details, because it does not.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);
$address = is_array($brand['address'] ?? null) ? $brand['address'] : [];

$cs = '/wp-content/themes/fenster/assets/images/case-studies/';
$team = '/wp-content/themes/fenster/assets/images/imported/';
$about = '/wp-content/themes/fenster/assets/images/about/';
$trust = '/wp-content/themes/fenster/assets/trust/';
$video_base = '/wp-content/themes/fenster/assets/videos/case-studies/';

$img = static function (string $url, array $attrs = []): string {
    return function_exists('fenster_image_attr_string')
        ? fenster_image_attr_string($url, $attrs)
        : 'src="' . esc_attr(fenster_generated_url($url)) . '"';
};

$quote_url = home_url('/online-quote/');
$consult_url = home_url('/book-a-consultation/');
$prices_url = home_url('/window-door-prices-milton-keynes/');

$facts = [
    ['value' => '2018', 'label' => 'trading since'],
    ['value' => '1,000+', 'label' => 'installations completed'],
    ['value' => 'In-house', 'label' => 'fitters on every home, never subcontracted'],
    ['value' => '10 years', 'label' => 'insurance-backed guarantee'],
];

$price_online = [
    'title' => 'Online',
    'steps' => [
        'Build the job on our quote tool',
        'A real figure in about ten minutes',
        'A free survey confirms the details',
    ],
];

$price_visit = [
    'title' => 'In person',
    'steps' => [
        'Send an enquiry or give us a call',
        'We visit and talk it through',
        'You get the price on the spot',
    ],
];

$installs = [
    ['file' => 'cs-mk-whitehouse-bifold-open.jpg', 'title' => 'Aluminium bifold doors', 'place' => 'Whitehouse, Milton Keynes', 'study' => 'aluminium-bifold-doors-whitehouse-milton-keynes', 'lead' => true],
    ['file' => 'cs-big-roof-lantern-14.jpg', 'title' => 'Roof lantern', 'place' => 'Drayton Parslow', 'study' => 'sheerline-roof-lantern'],
    ['file' => 'cs-lantern-doors-interior.jpg', 'title' => 'Heritage doors', 'place' => 'Northampton', 'study' => 'roof-lantern-and-heritage-doors'],
    ['file' => 'cs-leighton-buzzard-slide-fold-open.jpg', 'title' => 'Slide and fold doors', 'place' => 'Leighton Buzzard', 'study' => 'flush-casement-and-slide-fold-doors-leighton-buzzard'],
    ['file' => 'cs-leighton-buzzard-casement-street.jpg', 'title' => 'uPVC casement windows', 'place' => 'Leighton Buzzard', 'study' => 'upvc-casement-windows-leighton-buzzard'],
];

$accreditations = [
    ['src' => $trust . 'fensa.png', 'alt' => 'FENSA approved', 'url' => home_url('/fensa-approved-installers/'), 'title' => 'FENSA registered', 'copy' => 'Eligible replacement windows and doors are registered after installation, and FENSA send your certificate directly to you.'],
    ['src' => $trust . 'cpa.png', 'alt' => 'Consumer Protection Association', 'url' => home_url('/consumer-protection-association/'), 'title' => 'Insurance-backed', 'copy' => 'A ten year guarantee on new windows and doors, underwritten so it still stands if we ever stop trading.'],
    ['src' => $trust . 'constructionline-gold-member.png', 'alt' => 'Constructionline Gold Member', 'url' => home_url('/constructionline-gold/'), 'title' => 'Constructionline Gold', 'copy' => 'Assessed against the Common Assessment Standard, which is what lets us work on schools, healthcare and commercial sites.'],
    ['src' => $team . 'cropped-ssip.png', 'alt' => 'SSIP health and safety assessed', 'url' => home_url('/ssip-health-and-safety/'), 'title' => 'SSIP assessed', 'copy' => 'Independently assessed health and safety, required on most commercial and public sector work.'],
];

$founders = is_array($brand['founders'] ?? null) ? $brand['founders'] : [];
$founder_link = static function (string $name) use ($founders): string {
    foreach ($founders as $founder) {
        if (($founder['name'] ?? '') === $name) {
            return home_url('/meet-the-team/#' . ($founder['anchor'] ?? sanitize_title($name)));
        }
    }
    return home_url('/meet-the-team/');
};

$address_line = implode(', ', array_map('strval', $address));

/* Who we work with, and the at-a-glance table, added 2026-09-23 on the owner's
   brief. Two rules hold both of them to the rest of this site:
   - FITTING IS OURS ON HOMES, AND SAID ONLY OF HOMES. Owner, 2026-09-23:
     residential work is never subcontracted, commercial sometimes is, and the
     commercial side is not to be pushed on it either way. So every "our own
     installers" line here is scoped to homes, and the commercial copy says
     nothing about who fits.
   - THE GUARANTEE IS STATED POSITIVELY AND SCOPED TO NEW WINDOWS AND DOORS.
     No list of what it does not cover in anything new (2026-08-02 ruling);
     the older note in the accreditations band predates that and is left for
     the owner. */
$audiences = [
    [
        'title' => 'Homeowners',
        'copy' => 'Replacement windows and doors, roof lanterns, integral blinds, secondary glazing, new glass and repairs. Price it on our quote tool or book a free consultation, and our own installers fit it.',
        'links' => [
            ['label' => 'View windows', 'url' => home_url('/windows-milton-keynes/')],
            ['label' => 'View doors', 'url' => home_url('/doors-milton-keynes/')],
        ],
    ],
    [
        'title' => 'Commercial clients',
        'copy' => 'Contractors, schools, care homes, offices and property owners. Windows, doors, curtain walling, shopfronts, louvres and replacement glazing, specified to the drawings. Constructionline Gold and SSIP assessed.',
        'links' => [
            ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
        ],
    ],
];

$glance = [
    ['label' => 'Trading name', 'value' => (string) ($brand['name'] ?? 'Fenster Glazing')],
    ['label' => 'Registered company', 'value' => 'Fenster Glazing & Locks Ltd, company number 11579136'],
    ['label' => 'Founded', 'value' => '2018, by Adam Butcher and Nick Baker'],
    ['label' => 'Showroom and office', 'value' => $address_line],
    ['label' => 'Opening hours', 'value' => (string) ($brand['hours'] ?? '')],
    ['label' => 'Areas covered', 'value' => 'Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire'],
    ['label' => 'For homes', 'value' => 'Windows, doors, roof lanterns, integral blinds, secondary glazing, replacement glass and repairs'],
    ['label' => 'For commercial buildings', 'value' => 'Windows, doors, curtain walling, shopfronts, louvres and replacement glazing'],
    ['label' => 'Fitting', 'value' => 'Our own installers on every home, never subcontracted'],
    ['label' => 'Guarantee', 'value' => 'Ten years, insurance-backed, on new windows and doors'],
    ['label' => 'Registrations', 'value' => 'FENSA registered, Constructionline Gold, SSIP assessed'],
    ['label' => 'Pricing', 'value' => 'Online on our quote tool, or at a free consultation at your property'],
];

$about_faqs = [
    [
        'question' => 'When did Fenster start?',
        'answer' => 'Adam Butcher and Nick Baker started Fenster in 2018 and are still here every day. Nick runs sales and the showroom, and Adam runs the commercial side.',
    ],
    [
        'question' => 'Which areas do you cover?',
        'answer' => 'Milton Keynes and the towns around it, across Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. Commercial work goes further, so tell us where the building is.',
    ],
    [
        'question' => 'Who fits the windows and doors?',
        'answer' => 'On homes, our own installers, never subcontracted. The people who survey the job work for us too.',
    ],
    [
        'question' => 'Do you work on commercial buildings?',
        'answer' => 'Yes. Adam runs our commercial side, working for contractors, schools, care homes, offices and property owners. We are Constructionline Gold and SSIP assessed.',
    ],
    [
        'question' => 'What guarantee do new windows and doors come with?',
        'answer' => 'A ten year insurance-backed guarantee, underwritten so it still stands if we ever stop trading. Eligible installations are registered with FENSA, who send your certificate directly to you.',
    ],
    [
        'question' => 'Can I get a price online?',
        'answer' => 'Yes. Build the job on our quote tool with your sizes, styles, colours and glass, and most people have a real figure inside ten minutes. It asks for your contact details before it shows the price, or you can book a free consultation and we price it at your property.',
    ],
];

$routes = [
    ['title' => 'Get an instant price', 'copy' => 'Your sizes, your finishes, a real figure in minutes.', 'url' => $quote_url, 'primary' => true],
    ['title' => 'Book a free consultation', 'copy' => 'We go through the options and price the job at the property, at no charge.', 'url' => $consult_url],
    ['title' => 'See our work', 'copy' => 'Real installs with the fitters, specs and photos.', 'url' => home_url('/case-studies/')],
    ['title' => 'Meet the team', 'copy' => 'Everyone here, including the office cat.', 'url' => home_url('/meet-the-team/')],
    ['title' => 'Why you can trust us', 'copy' => 'Guarantees, accreditations and how we price.', 'url' => home_url('/why-trust-fenster/')],
    ['title' => 'Colours and finishes', 'copy' => 'uPVC foils and aluminium powder coats.', 'url' => home_url('/colour-options/')],
];

?>

<article class="fg-about">

    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('Simple, honest glazing.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('Fenster exists to make windows and doors straightforward: a fair price you can get in minutes, people who know what they are fitting, and a company that is still here long after the scaffolding has gone. We started in 2018, our showroom is in Milton Keynes, and every home we fit is surveyed and fitted by our own people.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url($consult_url); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-hero__media">
                <img <?php echo $img($about . 'fenster-showroom.png', ['alt' => 'The Fenster Glazing showroom on Alston Drive, Milton Keynes', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                <figcaption><?php esc_html_e('Our showroom, Milton Keynes', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-about-facts">
        <div class="container">
            <dl class="fg-about-facts__strip" data-fg-about-reveal>
                <?php foreach ($facts as $fact) : ?>
                    <div class="fg-about-facts__item">
                        <dt><?php echo esc_html($fact['value']); ?></dt>
                        <dd><?php echo esc_html($fact['label']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <section class="fg-about-pricing">
        <div class="container fg-about-pricing__grid">
            <div class="fg-about-pricing__copy" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('How pricing works', 'fenster'); ?></p>
                <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                <p><?php esc_html_e('If you like doing things yourself, build the job on our quote tool: your sizes, styles, colours and glass, priced as you go. Most people have a real figure inside ten minutes.', 'fenster'); ?></p>
                <p><?php esc_html_e('If you would rather talk it through, book a free consultation. We come out, go through the options for your property, answer the awkward questions and price the job before we leave. It stays free if you decide against the job. No waiting a week to find out the number.', 'fenster'); ?></p>
                <p>
                    <?php esc_html_e('Both run on the same pricing software and the same price list. One number for the job, not an online teaser and a different figure at the door. If you want to sense-check us first, we publish', 'fenster'); ?>
                    <a href="<?php echo esc_url($prices_url); ?>"><?php esc_html_e('example prices for real jobs', 'fenster'); ?></a><?php esc_html_e(', free to browse with no form in the way.', 'fenster'); ?>
                </p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--ghost" href="<?php echo esc_url($consult_url); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-about-pricing__panel" data-fg-about-reveal>
                <div class="fg-about-pricing__way">
                    <h3><?php echo esc_html($price_online['title']); ?></h3>
                    <ol>
                        <?php foreach ($price_online['steps'] as $step) : ?>
                            <li><?php echo esc_html($step); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <div class="fg-about-pricing__way">
                    <h3><?php echo esc_html($price_visit['title']); ?></h3>
                    <ol>
                        <?php foreach ($price_visit['steps'] as $step) : ?>
                            <li><?php echo esc_html($step); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-about-work">
        <div class="container">
            <div class="fg-about-work__head" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Recent jobs, photographed the day we finished.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No stock photos and no showroom sets. These are real installations by our own fitters, and each one opens the full case study with the specification, the exact colours and the people who did the work.', 'fenster'); ?></p>
            </div>
            <ul class="fg-about-work__mosaic">
                <?php foreach ($installs as $index => $shot) : ?>
                    <li class="fg-about-cell<?php echo ! empty($shot['lead']) ? ' fg-about-cell--lead' : ''; ?>" data-fg-about-reveal style="--fg-about-delay: <?php echo esc_attr(number_format($index * 0.07, 2)); ?>s;">
                        <a href="<?php echo esc_url(home_url('/case-studies/' . $shot['study'] . '/')); ?>">
                            <img <?php echo $img($cs . $shot['file'], ['alt' => $shot['title'] . ', ' . $shot['place'], 'loading' => 'lazy']); ?>>
                            <span class="fg-about-cell__caption"><strong><?php echo esc_html($shot['title']); ?></strong><em><?php echo esc_html($shot['place']); ?></em></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="button-row fg-about-work__cta">
                <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-about-founders">
        <div class="container fg-about-founders__grid">
            <div class="fg-about-founders__copy" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Who runs it', 'fenster'); ?></p>
                <h2><?php esc_html_e('Run by the two people who started it.', 'fenster'); ?></h2>
                <p>
                    <a href="<?php echo esc_url($founder_link('Adam Butcher')); ?>"><?php esc_html_e('Adam Butcher', 'fenster'); ?></a><?php esc_html_e(' and ', 'fenster'); ?><a href="<?php echo esc_url($founder_link('Nick Baker')); ?>"><?php esc_html_e('Nick Baker', 'fenster'); ?></a><?php esc_html_e(' founded Fenster in 2018 and are still here every day. Nick runs sales and the showroom. Adam runs the commercial side, from schools and care homes to full curtain walling. The name is the German word for window.', 'fenster'); ?>
                </p>
                <p><?php esc_html_e('Behind them is a team from the trade, not a call centre: fitters with decades on the tools between them, service engineers, surveyors, and an office that answers its own phone at any hour.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
                </div>
            </div>
            <ul class="fg-about-founders__people">
                <li data-fg-about-reveal>
                    <figure class="fg-about-founder">
                        <img <?php echo $img($team . 'adam-butcher-scaled.jpg', ['alt' => 'Adam Butcher, Commercial Director', 'loading' => 'lazy']); ?>>
                        <figcaption><strong><a href="<?php echo esc_url($founder_link('Adam Butcher')); ?>"><?php esc_html_e('Adam Butcher', 'fenster'); ?></a></strong><span><?php esc_html_e('Commercial Director', 'fenster'); ?></span></figcaption>
                    </figure>
                </li>
                <li data-fg-about-reveal style="--fg-about-delay: 0.1s;">
                    <figure class="fg-about-founder">
                        <img <?php echo $img($team . 'unnamed-5.jpg', ['alt' => 'Nick Baker, Sales Director', 'loading' => 'lazy']); ?>>
                        <figcaption><strong><a href="<?php echo esc_url($founder_link('Nick Baker')); ?>"><?php esc_html_e('Nick Baker', 'fenster'); ?></a></strong><span><?php esc_html_e('Sales Director', 'fenster'); ?></span></figcaption>
                    </figure>
                </li>
            </ul>
        </div>
    </section>

    <section class="fg-about-audience">
        <div class="container">
            <div class="fg-about-audience__head" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Who we work with', 'fenster'); ?></p>
                <h2><?php esc_html_e('Homes, schools, offices and care homes.', 'fenster'); ?></h2>
            </div>
            <ul class="fg-about-audience__grid">
                <?php foreach ($audiences as $index => $audience) : ?>
                    <li class="fg-about-audience__item" data-fg-about-reveal style="--fg-about-delay: <?php echo esc_attr(number_format($index * 0.07, 2)); ?>s;">
                        <h3><?php echo esc_html($audience['title']); ?></h3>
                        <p><?php echo esc_html($audience['copy']); ?></p>
                        <div class="button-row">
                            <?php foreach ($audience['links'] as $link_index => $link) : ?>
                                <a class="button<?php echo $link_index > 0 ? ' button--steel' : ''; ?>" href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <figure class="fg-about-award__media" data-fg-about-reveal>
                <video data-fg-about-video muted playsinline loop preload="none"
                    poster="<?php echo esc_url(fenster_generated_url($cs . 'cs-roof-lantern-heritage-doors-poster.jpg')); ?>"
                    aria-label="<?php esc_attr_e('Video of the award-winning roof lantern and heritage doors we installed in Northampton', 'fenster'); ?>">
                    <source data-src="<?php echo esc_url(fenster_generated_url($video_base . 'cs-roof-lantern-heritage-doors.mp4')); ?>" type="video/mp4">
                </video>
                <figcaption><?php esc_html_e('The winning job, Northampton', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-about-award__copy" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Recognised work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Sheerline Installation of the Month.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Sheerline manufacture the aluminium systems we fit, and each month they feature one installation. In August 2025 it was ours: a Northampton extension with an S1 roof lantern overhead and black steel-look heritage doors to the garden. Johnnie and Tom fitted it. This is the actual job.', 'fenster'); ?></p>
                <p class="fg-about-award__mark">
                    <img <?php echo $img('/wp-content/themes/fenster/assets/partners/sheerline.png', ['alt' => 'Sheerline', 'loading' => 'lazy']); ?>>
                    <span><?php esc_html_e('Installation of the Month, August 2025', 'fenster'); ?></span>
                </p>
                <div class="button-row">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-about-trust">
        <div class="container">
            <div class="fg-about-trust__head" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Accreditations', 'fenster'); ?></p>
                <h2><?php esc_html_e('The badges, and what they actually mean.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Any installer can print a logo, so here is what each of ours covers, including the limits most keep in the small print.', 'fenster'); ?></p>
            </div>
            <ul class="fg-about-trust__grid">
                <?php foreach ($accreditations as $index => $item) : ?>
                    <li data-fg-about-reveal style="--fg-about-delay: <?php echo esc_attr(number_format($index * 0.07, 2)); ?>s;">
                        <a class="fg-about-badge" href="<?php echo esc_url($item['url']); ?>">
                            <span class="fg-about-badge__logo"><img <?php echo $img($item['src'], ['alt' => $item['alt'], 'loading' => 'lazy']); ?>></span>
                            <strong><?php echo esc_html($item['title']); ?></strong>
                            <span class="fg-about-badge__copy"><?php echo esc_html($item['copy']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-about-trust__note" data-fg-about-reveal><?php esc_html_e('The ten year guarantee covers new window and door installations. Repairs, replacement glass, roofline, integral blinds and pet flaps sit outside it, and it stays with you rather than the property if you sell. We would rather say that here than bury it.', 'fenster'); ?></p>
            <div class="button-row">
                <a class="button button--light" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('Why you can trust us', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-about-visit">
        <div class="container fg-about-visit__grid">
            <div class="fg-about-visit__copy" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('Come and see us', 'fenster'); ?></p>
                <h2><?php esc_html_e('See it all in person at the showroom.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Colours, glass, frames and handles never look quite the same on a screen. Come and open a bifold, feel the weight of a handle, compare a foil to a powder coat and ask the awkward questions. You do not need an appointment.', 'fenster'); ?></p>
                <?php if ($address !== []) : ?>
                    <address class="fg-about-visit__address">
                        <?php foreach ($address as $line) : ?>
                            <span><?php echo esc_html($line); ?></span>
                        <?php endforeach; ?>
                    </address>
                <?php endif; ?>
                <p class="fg-about-visit__hours"><?php esc_html_e('Monday to Friday, 8.30am to 5pm. Phone lines answered around the clock.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact us', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-visit__media" data-fg-about-reveal>
                <img <?php echo $img($about . 'fenster-showroom.png', ['alt' => 'The Fenster Glazing showroom on Alston Drive, Milton Keynes', 'loading' => 'lazy']); ?>>
                <figcaption><?php esc_html_e('Alston Drive, Bradwell Abbey', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-about-glance">
        <div class="container fg-about-glance__grid">
            <div class="fg-about-glance__head" data-fg-about-reveal>
                <p class="eyebrow"><?php esc_html_e('At a glance', 'fenster'); ?></p>
                <h2><?php esc_html_e('Fenster, in plain facts.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The short version, for anyone checking us out before they get in touch.', 'fenster'); ?></p>
            </div>
            <table class="fg-about-glance__table" data-fg-about-reveal>
                <tbody>
                    <?php foreach ($glance as $row) : ?>
                        <?php if ($row['value'] === '') { continue; } ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($row['label']); ?></th>
                            <td><?php echo esc_html($row['value']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/faq-block', null, [
        'faqs' => $about_faqs,
        'eyebrow' => 'Questions',
        'heading' => 'Straight answers about who we are.',
        'id' => 'fg-about-faq-title',
    ]);
    ?>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--about',
        'eyebrow' => 'Customer proof',
        'title' => 'What people say once the work is done.',
        'copy' => 'Independent reviews from customers across Milton Keynes and the surrounding counties.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-about-routes">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e('Where to next', 'fenster'); ?></p>
            <h2><?php esc_html_e('Whatever you came here to work out.', 'fenster'); ?></h2>
            <ul class="fg-about-routes__grid">
                <?php foreach ($routes as $route) : ?>
                    <li>
                        <a class="fg-about-route<?php echo ! empty($route['primary']) ? ' fg-about-route--primary' : ''; ?>" href="<?php echo esc_url($route['url']); ?>">
                            <strong><?php echo esc_html($route['title']); ?></strong>
                            <span><?php echo esc_html($route['copy']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

</article>
