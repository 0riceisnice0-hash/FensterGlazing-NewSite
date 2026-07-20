<?php
/**
 * Hardcoded about page.
 *
 * Page idea: the name is the hook. "Fenster" is German for window, which
 * answers the question every visitor half-wonders and is the kind of thing
 * people repeat. From there the page is image-led: the two founders, real
 * installs, the Sheerline award, then a route to everywhere else.
 *
 * Imagery is deliberately restricted to work that is genuinely ours. Case
 * study photography and the team portraits are Fenster's own. Supplier
 * libraries (Roseview, Sheerline, Distinction) are NOT used here, because an
 * about page trading on someone else's photography defeats its own purpose.
 *
 * Motion uses the existing global data-fg-depth parallax utility, so no new
 * JavaScript. Every motion rule is disabled under prefers-reduced-motion.
 *
 * Do not reinstate the founding anecdote: the owner has ruled it out as
 * unsuitable for publication. Do not claim the quote tool shows a price
 * without taking details, because it does not. The price guide pages are the
 * honest version of that claim.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$address = is_array($brand['address'] ?? null) ? $brand['address'] : [];

$cs = FENSTER_THEME_URI . '/assets/images/case-studies/';
$team = FENSTER_THEME_URI . '/assets/images/imported/';
$about = FENSTER_THEME_URI . '/assets/images/about/';
$partners = FENSTER_THEME_URI . '/assets/partners/';

$founders = [
    [
        'name' => 'Adam Butcher',
        'role' => 'Commercial Director',
        'image' => $team . 'adam-butcher-scaled.jpg',
        'copy' => 'Adam runs the commercial side, from schools and care homes to curtain walling and access control.',
    ],
    [
        'name' => 'Nick Baker',
        'role' => 'Sales Director',
        'image' => $team . 'unnamed-5.jpg',
        'copy' => 'Nick looks after the showroom and the homeowners, and is the reason there is a cat in the office.',
    ],
];

$facts = [
    ['value' => '2018', 'label' => 'trading since'],
    ['value' => '1,000+', 'label' => 'installations completed'],
    ['value' => '10 year', 'label' => 'insurance-backed guarantee'],
    ['value' => '100s', 'label' => 'of customer reviews'],
];

// Real Fenster installs only. Mixed orientations are deliberate: the masonry
// never crops, which is what makes the case study galleries feel honest.
$gallery = [
    ['file' => 'cs-mk-whitehouse-bifold-open.jpg', 'caption' => 'Aluminium bifolds opened up, Whitehouse', 'study' => 'aluminium-bifold-doors-whitehouse-milton-keynes'],
    ['file' => 'cs-leighton-buzzard-casement-street.jpg', 'caption' => 'New casements from the street, Leighton Buzzard', 'study' => 'upvc-casement-windows-leighton-buzzard'],
    ['file' => 'cs-lantern-doors-interior.jpg', 'caption' => 'Heritage doors and a roof lantern, Northampton', 'study' => 'roof-lantern-and-heritage-doors'],
    ['file' => 'cs-big-roof-lantern-19.jpg', 'caption' => 'A Sheerline S1 lantern over an extension, Drayton Parslow', 'study' => 'sheerline-roof-lantern'],
    ['file' => 'cs-leighton-buzzard-slide-fold-open.jpg', 'caption' => 'Slide and fold doors folded back, Leighton Buzzard', 'study' => 'flush-casement-and-slide-fold-doors-leighton-buzzard'],
    ['file' => 'cs-mk-broughton-casement-after.jpg', 'caption' => 'A boarded dormer put right, Broughton', 'study' => 'upvc-casement-windows-broughton-milton-keynes'],
    ['file' => 'cs-leighton-buzzard-casement-handle-open.jpg', 'caption' => 'Hardware detail on a Liniar casement', 'study' => 'upvc-casement-windows-leighton-buzzard'],
    ['file' => 'cs-lantern-doors-up.jpg', 'caption' => 'Looking up through the lantern, Northampton', 'study' => 'roof-lantern-and-heritage-doors'],
];

$routes = [
    ['title' => 'Price your job', 'copy' => 'Build a quote with your own sizes, colours and glass.', 'url' => home_url('/online-quote/'), 'image' => $cs . 'cs-leighton-buzzard-casement-front.jpg'],
    ['title' => 'Book a home visit', 'copy' => 'We measure up and talk it through at your property.', 'url' => home_url('/book-a-consultation/'), 'image' => $cs . 'cs-mk-whitehouse-bifold-closed.jpg'],
    ['title' => 'See our work', 'copy' => 'Real installs with the fitters, specs and photos.', 'url' => home_url('/case-studies/'), 'image' => $cs . 'cs-big-roof-lantern-14.jpg'],
    ['title' => 'Meet the team', 'copy' => 'Everyone here, including the office cat.', 'url' => home_url('/meet-the-team/'), 'image' => $team . 'David-Foord.jpg'],
    ['title' => 'Why you can trust us', 'copy' => 'Accreditations, guarantees and how we price.', 'url' => home_url('/why-trust-fenster/'), 'image' => $cs . 'cs-leighton-buzzard-flush-casement.jpg'],
    ['title' => 'Colours and finishes', 'copy' => 'uPVC foils and aluminium powder coats, side by side.', 'url' => home_url('/colour-options/'), 'image' => $cs . 'cs-leighton-buzzard-slide-fold-closed.jpg'],
];

$accreditations = [
    ['src' => FENSTER_THEME_URI . '/assets/trust/fensa.png', 'alt' => 'FENSA approved', 'url' => home_url('/fensa-approved-installers/')],
    ['src' => FENSTER_THEME_URI . '/assets/trust/cpa.png', 'alt' => 'Consumer Protection Association', 'url' => home_url('/consumer-protection-association/')],
    ['src' => FENSTER_THEME_URI . '/assets/trust/constructionline-gold-member.png', 'alt' => 'Constructionline Gold Member', 'url' => home_url('/constructionline-gold/')],
    ['src' => FENSTER_THEME_URI . '/assets/images/imported/cropped-ssip.png', 'alt' => 'SSIP health and safety assessed', 'url' => home_url('/ssip-health-and-safety/')],
];

?>

<article class="fg-about">

    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('Fenster is German for window.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('It seemed like a reasonable name for a window company. We have been fitting windows, doors and glazing across Milton Keynes and the counties around it since 2018, with our own installers and our prices published rather than hidden.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Price your job', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See our work', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-hero__media">
                <span class="fg-about-parallax" data-fg-depth="0.06">
                    <img src="<?php echo esc_url($cs . 'cs-big-roof-lantern-14.jpg'); ?>" alt="<?php esc_attr_e('A Sheerline S1 aluminium roof lantern installed by Fenster over an extension in Drayton Parslow', 'fenster'); ?>" loading="eager" fetchpriority="high" width="1600" height="900">
                </span>
                <figcaption><?php esc_html_e('Drayton Parslow', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-about-facts">
        <div class="container">
            <dl class="fg-about-facts__strip">
                <?php foreach ($facts as $fact) : ?>
                    <div class="fg-about-facts__item">
                        <dt><?php echo esc_html($fact['value']); ?></dt>
                        <dd><?php echo esc_html($fact['label']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <section class="fg-about-founders">
        <div class="container">
            <div class="fg-about-founders__head">
                <p class="eyebrow"><?php esc_html_e('Who started it', 'fenster'); ?></p>
                <h2><?php esc_html_e('Two people who already knew the trade.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Adam and Nick set Fenster up in 2018 and still run it day to day. You will meet one of them at the showroom, and the other if your project is commercial.', 'fenster'); ?></p>
            </div>
            <div class="fg-about-founders__grid">
                <?php foreach ($founders as $index => $founder) : ?>
                    <figure class="fg-about-founder">
                        <span class="fg-about-parallax" data-fg-depth="<?php echo esc_attr($index === 0 ? '0.05' : '0.09'); ?>">
                            <img src="<?php echo esc_url($founder['image']); ?>" alt="<?php echo esc_attr($founder['name']); ?>" loading="lazy">
                        </span>
                        <figcaption>
                            <strong><?php echo esc_html($founder['name']); ?></strong>
                            <span class="fg-about-founder__role"><?php echo esc_html($founder['role']); ?></span>
                            <span class="fg-about-founder__copy"><?php echo esc_html($founder['copy']); ?></span>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-about-work">
        <div class="container">
            <div class="fg-about-work__head">
                <p class="eyebrow"><?php esc_html_e('Recent installs', 'fenster'); ?></p>
                <h2><?php esc_html_e('Our own work, photographed on the day.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No stock photography and no showroom mock-ups. Every picture below is a Fenster installation, and each one links to the full project with its specification, fitters and finish.', 'fenster'); ?></p>
            </div>
            <div class="fg-about-work__masonry">
                <?php foreach ($gallery as $shot) : ?>
                    <figure class="fg-about-shot">
                        <a href="<?php echo esc_url($cs . $shot['file']); ?>" data-fg-gallery-lightbox aria-label="<?php echo esc_attr($shot['caption']); ?>">
                            <img src="<?php echo esc_url($cs . $shot['file']); ?>" alt="<?php echo esc_attr($shot['caption']); ?>" loading="lazy">
                        </a>
                        <figcaption>
                            <span><?php echo esc_html($shot['caption']); ?></span>
                            <a href="<?php echo esc_url(home_url('/case-studies/' . $shot['study'] . '/')); ?>"><?php esc_html_e('Read the project', 'fenster'); ?></a>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p class="fg-about-work__more">
                <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <figure class="fg-about-award__media">
                <span class="fg-about-parallax" data-fg-depth="0.07">
                    <img src="<?php echo esc_url($cs . 'cs-lantern-doors-6.jpg'); ?>" alt="<?php esc_attr_e('Black heritage aluminium doors and a Sheerline roof lantern on a Northampton extension', 'fenster'); ?>" loading="lazy">
                </span>
            </figure>
            <div class="fg-about-award__copy">
                <p class="eyebrow"><?php esc_html_e('Recognised work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Sheerline named one of our installs Installation of the Month.', 'fenster'); ?></h2>
                <p><?php esc_html_e('In August 2025 Sheerline picked out an extension we finished in Northampton: an S1 roof lantern overhead, and black steel-look heritage doors opening to the garden. Johnnie and Tom fitted it.', 'fenster'); ?></p>
                <p class="fg-about-award__mark">
                    <img src="<?php echo esc_url($partners . 'sheerline.png'); ?>" alt="<?php esc_attr_e('Sheerline', 'fenster'); ?>" loading="lazy">
                    <span><?php esc_html_e('Installation of the Month, August 2025', 'fenster'); ?></span>
                </p>
                <p>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <section class="fg-about-trust">
        <div class="container fg-about-trust__grid">
            <div class="fg-about-trust__copy">
                <p class="eyebrow"><?php esc_html_e('What we stand behind', 'fenster'); ?></p>
                <h2><?php esc_html_e('Ten years, insurance-backed, and we say what it excludes.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Every new window and door installation carries a ten year guarantee backed by the Consumer Protection Association. Repairs, replacement glass, roofline, integral blinds and pet flaps sit outside it, and it stays with you rather than the house if you move.', 'fenster'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('How our guarantees and accreditations work', 'fenster'); ?></a></p>
            </div>
            <ul class="fg-about-trust__logos">
                <?php foreach ($accreditations as $item) : ?>
                    <li>
                        <a class="fg-accreditation-logo-link" href="<?php echo esc_url($item['url']); ?>" aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), $item['alt'])); ?>">
                            <img src="<?php echo esc_url($item['src']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" loading="lazy">
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

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

    <section class="fg-about-visit">
        <div class="container fg-about-visit__grid">
            <figure class="fg-about-visit__media">
                <span class="fg-about-parallax" data-fg-depth="0.05">
                    <img src="<?php echo esc_url($about . 'fenster-showroom.png'); ?>" alt="<?php esc_attr_e('The Fenster Glazing showroom on Alston Drive, Milton Keynes', 'fenster'); ?>" loading="lazy">
                </span>
                <figcaption><?php esc_html_e('Alston Drive, Bradwell Abbey', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-about-visit__copy">
                <p class="eyebrow"><?php esc_html_e('Where we are', 'fenster'); ?></p>
                <h2><?php esc_html_e('Walk in and see the products properly.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Frames, colours, handles and glass all look different in person. We are a few minutes from the centre of Milton Keynes and you do not need an appointment.', 'fenster'); ?></p>
                <?php if ($address !== []) : ?>
                    <address class="fg-about-visit__address">
                        <?php foreach ($address as $line) : ?>
                            <span><?php echo esc_html($line); ?></span>
                        <?php endforeach; ?>
                    </address>
                <?php endif; ?>
                <p class="fg-about-visit__hours"><?php esc_html_e('Monday to Friday, 8.30am to 5pm. Phone lines are answered around the clock.', 'fenster'); ?></p>
                <div class="fg-about-visit__links">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-about-routes">
        <div class="container">
            <div class="fg-about-routes__head">
                <p class="eyebrow"><?php esc_html_e('Where to next', 'fenster'); ?></p>
                <h2><?php esc_html_e('Whatever you came here to work out.', 'fenster'); ?></h2>
            </div>
            <ul class="fg-about-routes__grid">
                <?php foreach ($routes as $route) : ?>
                    <li>
                        <a class="fg-about-route" href="<?php echo esc_url($route['url']); ?>">
                            <span class="fg-about-route__media">
                                <img src="<?php echo esc_url($route['image']); ?>" alt="" loading="lazy" aria-hidden="true">
                            </span>
                            <span class="fg-about-route__body">
                                <strong><?php echo esc_html($route['title']); ?></strong>
                                <span><?php echo esc_html($route['copy']); ?></span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

</article>
