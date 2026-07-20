<?php
/**
 * Hardcoded about page.
 *
 * Hard-won implementation notes, do not undo these:
 *
 * 1. Every image here goes through fenster_image_attr_string() so it carries
 *    real width/height attributes. An earlier version used height:auto with
 *    loading="lazy" and no dimensions, which collapsed the gallery to zero
 *    height, so the images never entered the viewport and never loaded at all.
 * 2. The work gallery is a deliberate mosaic with fixed aspect-ratio cells, not
 *    a ragged masonry. Masonry is right on a case study detail page where every
 *    shot is one project; as a standalone "our work" section it reads as a dump.
 * 3. Portraits are supporting elements. Do not let them grow to half-viewport
 *    faces again.
 *
 * The name being German for window is a small aside in the lead, not the
 * headline. Do not reinstate the founding anecdote: the owner ruled it out.
 * Do not claim the quote tool shows a price without taking details, because it
 * does not. The price guide pages are the honest version of that claim.
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

$cs = '/wp-content/themes/fenster/assets/images/case-studies/';
$team = '/wp-content/themes/fenster/assets/images/imported/';
$about = '/wp-content/themes/fenster/assets/images/about/';

$img = static function (string $url, array $attrs = []): string {
    return function_exists('fenster_image_attr_string')
        ? fenster_image_attr_string($url, $attrs)
        : 'src="' . esc_attr(fenster_generated_url($url)) . '"';
};

$founders = [
    ['name' => 'Adam Butcher', 'role' => 'Commercial Director', 'image' => $team . 'adam-butcher-scaled.jpg'],
    ['name' => 'Nick Baker', 'role' => 'Sales Director', 'image' => $team . 'unnamed-5.jpg'],
];

$facts = [
    ['value' => '2018', 'label' => 'trading since'],
    ['value' => '1,000+', 'label' => 'installations completed'],
    ['value' => '10 year', 'label' => 'insurance-backed guarantee'],
    ['value' => '100s', 'label' => 'of customer reviews'],
];

// One dominant image plus five supporting cells, per the STYLE.md mosaic rule.
$gallery = [
    ['file' => 'cs-mk-whitehouse-bifold-open.jpg', 'caption' => 'Aluminium bifolds, Whitehouse', 'study' => 'aluminium-bifold-doors-whitehouse-milton-keynes', 'lead' => true],
    ['file' => 'cs-lantern-doors-interior.jpg', 'caption' => 'Heritage doors, Northampton', 'study' => 'roof-lantern-and-heritage-doors'],
    ['file' => 'cs-big-roof-lantern-14.jpg', 'caption' => 'Roof lantern, Drayton Parslow', 'study' => 'sheerline-roof-lantern'],
    ['file' => 'cs-leighton-buzzard-slide-fold-open.jpg', 'caption' => 'Slide and fold doors, Leighton Buzzard', 'study' => 'flush-casement-and-slide-fold-doors-leighton-buzzard'],
    ['file' => 'cs-leighton-buzzard-casement-street.jpg', 'caption' => 'Casements, Leighton Buzzard', 'study' => 'upvc-casement-windows-leighton-buzzard'],
];

$routes = [
    ['title' => 'Price your job', 'copy' => 'Build a quote with your own sizes and finishes.', 'url' => home_url('/online-quote/')],
    ['title' => 'Book a home visit', 'copy' => 'We measure up and talk it through at your property.', 'url' => home_url('/book-a-consultation/')],
    ['title' => 'See our work', 'copy' => 'Real installs with fitters, specs and photos.', 'url' => home_url('/case-studies/')],
    ['title' => 'Meet the team', 'copy' => 'Everyone here, including the office cat.', 'url' => home_url('/meet-the-team/')],
    ['title' => 'Why you can trust us', 'copy' => 'Accreditations, guarantees and how we price.', 'url' => home_url('/why-trust-fenster/')],
    ['title' => 'Colours and finishes', 'copy' => 'uPVC foils and aluminium powder coats.', 'url' => home_url('/colour-options/')],
];

$accreditations = [
    ['src' => '/wp-content/themes/fenster/assets/trust/fensa.png', 'alt' => 'FENSA approved', 'url' => home_url('/fensa-approved-installers/')],
    ['src' => '/wp-content/themes/fenster/assets/trust/cpa.png', 'alt' => 'Consumer Protection Association', 'url' => home_url('/consumer-protection-association/')],
    ['src' => '/wp-content/themes/fenster/assets/trust/constructionline-gold-member.png', 'alt' => 'Constructionline Gold Member', 'url' => home_url('/constructionline-gold/')],
    ['src' => '/wp-content/themes/fenster/assets/images/imported/cropped-ssip.png', 'alt' => 'SSIP health and safety assessed', 'url' => home_url('/ssip-health-and-safety/')],
];

?>

<article class="fg-about">

    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('We fit our own work.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('We have installed windows, doors and glazing across Milton Keynes and the counties around it since 2018. Our fitters are on our payroll rather than subcontracted, which is why the same faces turn up on every job. The name is German for window, which felt about right.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Price your job', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See our work', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-hero__media">
                <span class="fg-about-parallax" data-fg-depth="0.05">
                    <img <?php echo $img($about . 'fenster-showroom.png', ['alt' => 'The Fenster Glazing showroom on Alston Drive, Milton Keynes', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
                </span>
                <figcaption><?php esc_html_e('Our showroom, Milton Keynes', 'fenster'); ?></figcaption>
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
        <div class="container fg-about-founders__grid">
            <div class="fg-about-founders__copy">
                <p class="eyebrow"><?php esc_html_e('Who runs it', 'fenster'); ?></p>
                <h2><?php esc_html_e('Adam and Nick started Fenster in 2018.', 'fenster'); ?></h2>
                <p><?php esc_html_e('They still run it day to day. Nick looks after the showroom and homeowners, Adam handles the commercial side, and between them they have spent their working lives in glazing.', 'fenster'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the rest of the team', 'fenster'); ?></a></p>
            </div>
            <ul class="fg-about-founders__people">
                <?php foreach ($founders as $founder) : ?>
                    <li>
                        <figure class="fg-about-founder">
                            <img <?php echo $img($founder['image'], ['alt' => $founder['name'], 'loading' => 'lazy']); ?>>
                            <figcaption>
                                <strong><?php echo esc_html($founder['name']); ?></strong>
                                <span><?php echo esc_html($founder['role']); ?></span>
                            </figcaption>
                        </figure>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="fg-about-work">
        <div class="container">
            <div class="fg-about-work__head">
                <p class="eyebrow"><?php esc_html_e('Recent installs', 'fenster'); ?></p>
                <h2><?php esc_html_e('Our own work, photographed on the day.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No stock photography and no showroom mock-ups. Every picture is a Fenster installation, and each one opens the full project with its specification, fitters and finish.', 'fenster'); ?></p>
            </div>
            <ul class="fg-about-work__mosaic">
                <?php foreach ($gallery as $shot) : ?>
                    <li class="fg-about-cell<?php echo ! empty($shot['lead']) ? ' fg-about-cell--lead' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/case-studies/' . $shot['study'] . '/')); ?>">
                            <img <?php echo $img($cs . $shot['file'], ['alt' => $shot['caption'], 'loading' => 'lazy']); ?>>
                            <span class="fg-about-cell__caption"><?php echo esc_html($shot['caption']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-about-work__more">
                <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <figure class="fg-about-award__media">
                <span class="fg-about-parallax" data-fg-depth="0.06">
                    <img <?php echo $img($cs . 'cs-lantern-doors-6.jpg', ['alt' => 'Black heritage aluminium doors and a Sheerline roof lantern on a Northampton extension', 'loading' => 'lazy']); ?>>
                </span>
            </figure>
            <div class="fg-about-award__copy">
                <p class="eyebrow"><?php esc_html_e('Recognised work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Sheerline Installation of the Month.', 'fenster'); ?></h2>
                <p><?php esc_html_e('In August 2025 Sheerline picked out an extension we finished in Northampton: an S1 roof lantern overhead, and black steel-look heritage doors opening to the garden. Johnnie and Tom fitted it.', 'fenster'); ?></p>
                <p class="fg-about-award__mark">
                    <img <?php echo $img('/wp-content/themes/fenster/assets/partners/sheerline.png', ['alt' => 'Sheerline', 'loading' => 'lazy']); ?>>
                    <span><?php esc_html_e('August 2025', 'fenster'); ?></span>
                </p>
                <p><a href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a></p>
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
                            <img <?php echo $img($item['src'], ['alt' => $item['alt'], 'loading' => 'lazy']); ?>>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="fg-about-visit">
        <div class="container fg-about-visit__grid">
            <figure class="fg-about-visit__media">
                <span class="fg-about-parallax" data-fg-depth="0.04">
                    <img <?php echo $img($cs . 'cs-leighton-buzzard-casement-front.jpg', ['alt' => 'A Fenster casement window installation in Leighton Buzzard', 'loading' => 'lazy']); ?>>
                </span>
                <figcaption><?php esc_html_e('Leighton Buzzard', 'fenster'); ?></figcaption>
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
                <p class="fg-about-visit__hours"><?php esc_html_e('Monday to Friday, 8.30am to 5pm. Phone lines answered around the clock.', 'fenster'); ?></p>
                <div class="fg-about-visit__links">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </div>
            </div>
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

    <section class="fg-about-routes">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e('Where to next', 'fenster'); ?></p>
            <ul class="fg-about-routes__grid">
                <?php foreach ($routes as $route) : ?>
                    <li>
                        <a class="fg-about-route" href="<?php echo esc_url($route['url']); ?>">
                            <strong><?php echo esc_html($route['title']); ?></strong>
                            <span><?php echo esc_html($route['copy']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

</article>
