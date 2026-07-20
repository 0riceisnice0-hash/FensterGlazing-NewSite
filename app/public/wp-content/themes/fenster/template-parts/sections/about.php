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
 * 3. The install carousel reuses the fg-colour-carousel component wholesale, so
 *    the 3D coverflow, drag, prev/next and counter come from existing JS and
 *    SCSS. Keep the class names even though they say "colour".
 * 4. CTAs are buttons. Text links for primary actions are a STYLE.md failure.
 *
 * Do not reinstate the founding anecdote: the owner ruled it out. Do not claim
 * the quote tool gives a price without taking any details, because it does not.
 * The honest and still strong claim is speed: a real figure in minutes instead
 * of an appointment and a callback days later.
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

$img = static function (string $url, array $attrs = []): string {
    return function_exists('fenster_image_attr_string')
        ? fenster_image_attr_string($url, $attrs)
        : 'src="' . esc_attr(fenster_generated_url($url)) . '"';
};

$quote_url = home_url('/online-quote/');
$consult_url = home_url('/book-a-consultation/');

$facts = [
    ['value' => '2018', 'label' => 'trading since'],
    ['value' => '1,000+', 'label' => 'installations completed'],
    ['value' => 'In-house', 'label' => 'fitters, never subcontracted'],
    ['value' => 'Milton Keynes', 'label' => 'showroom and office'],
];

$installs = [
    ['file' => 'cs-mk-whitehouse-bifold-open.jpg', 'title' => 'Aluminium bifolds', 'place' => 'Whitehouse, Milton Keynes'],
    ['file' => 'cs-lantern-doors-interior.jpg', 'title' => 'Heritage doors and lantern', 'place' => 'Northampton'],
    ['file' => 'cs-big-roof-lantern-14.jpg', 'title' => 'Sheerline S1 roof lantern', 'place' => 'Drayton Parslow'],
    ['file' => 'cs-leighton-buzzard-slide-fold-open.jpg', 'title' => 'Slide and fold doors', 'place' => 'Leighton Buzzard'],
    ['file' => 'cs-leighton-buzzard-casement-street.jpg', 'title' => 'uPVC casements', 'place' => 'Leighton Buzzard'],
    ['file' => 'cs-mk-broughton-casement-after.jpg', 'title' => 'Dormer casement', 'place' => 'Broughton, Milton Keynes'],
];

$process = [
    ['step' => '01', 'title' => 'Price it yourself', 'copy' => 'Start online with your sizes, style, colour, glass and hardware. The tool prices as you go, using the same figures the office quotes from, so you know the ballpark before you speak to anybody. Most people get there in about ten minutes on a phone.'],
    ['step' => '02', 'title' => 'Talk it through', 'copy' => 'Call, email, or come into the showroom and see the frames in person. This is where the awkward questions get answered: what suits the property, whether trickle vents are required, and what the glass should do about heat, noise or privacy.'],
    ['step' => '03', 'title' => 'A proper survey', 'copy' => 'Before anything is ordered we measure on site and check the details that catch people out: access, thresholds, lintels, cills, trims, the state of the opening and how the frames meet the brickwork. The survey is what makes the price final.'],
    ['step' => '04', 'title' => 'Manufacture and fit', 'copy' => 'Your frames are made to the surveyed sizes, then fitted by our own installers. They clear up behind themselves, run through the hardware with you, and leave you with the paperwork, guarantee details and FENSA registration where the work is eligible.'],
    ['step' => '05', 'title' => 'Afterwards', 'copy' => 'If a handle drops or a hinge needs adjusting a year later, you call the same office and one of our service engineers comes out. That is the part a national lead-generation site cannot offer, because there is nobody local behind it.'],
];

$accreditations = [
    ['src' => $trust . 'fensa.png', 'alt' => 'FENSA approved', 'url' => home_url('/fensa-approved-installers/'), 'title' => 'FENSA registered', 'copy' => 'Eligible replacement windows and doors are registered after installation, and FENSA send your certificate directly to you.'],
    ['src' => $trust . 'cpa.png', 'alt' => 'Consumer Protection Association', 'url' => home_url('/consumer-protection-association/'), 'title' => 'Insurance-backed', 'copy' => 'A ten year guarantee on new windows and doors, underwritten so it still stands if we ever stop trading.'],
    ['src' => $trust . 'constructionline-gold-member.png', 'alt' => 'Constructionline Gold Member', 'url' => home_url('/constructionline-gold/'), 'title' => 'Constructionline Gold', 'copy' => 'Assessed against the Common Assessment Standard, which is what lets us work on schools, healthcare and commercial sites.'],
    ['src' => '/wp-content/themes/fenster/assets/images/imported/cropped-ssip.png', 'alt' => 'SSIP health and safety assessed', 'url' => home_url('/ssip-health-and-safety/'), 'title' => 'SSIP assessed', 'copy' => 'Independently assessed health and safety, required on most commercial and public sector work.'],
];

$routes = [
    ['title' => 'Get an instant price', 'copy' => 'Your sizes, your finishes, a real figure in minutes.', 'url' => $quote_url, 'primary' => true],
    ['title' => 'Book a home visit', 'copy' => 'We measure up and talk it through at the property.', 'url' => $consult_url],
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
                <h1><?php esc_html_e('Windows and doors, priced in minutes.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('Most people find us because of the pricing. You can specify your own windows and doors on this site and get a real figure straight away, instead of booking an appointment and waiting days for someone to call you back. Everything after that is ours: our surveyors, our fitters, our showroom in Milton Keynes.', 'fenster'); ?></p>
                <ul class="fg-about-hero__points">
                    <li><?php esc_html_e('Installing across Milton Keynes and the surrounding counties since 2018', 'fenster'); ?></li>
                    <li><?php esc_html_e('Over a thousand installations completed', 'fenster'); ?></li>
                    <li><?php esc_html_e('Ten year insurance-backed guarantee on new windows and doors', 'fenster'); ?></li>
                </ul>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url($consult_url); ?>"><?php esc_html_e('Book a home visit', 'fenster'); ?></a>
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

    <section class="fg-about-pricing">
        <div class="container fg-about-pricing__grid">
            <div class="fg-about-pricing__copy">
                <p class="eyebrow"><?php esc_html_e('What we are known for', 'fenster'); ?></p>
                <h2><?php esc_html_e('You should not wait a week to find out what it costs.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The usual way of buying windows is to fill in a form, wait for a call, sit through an appointment, and only then get a number. That is a strange way to treat someone who mainly wants to know whether the job is four thousand pounds or fourteen.', 'fenster'); ?></p>
                <p><?php esc_html_e('So our pricing tool runs on the same figures we quote from. Choose the product, the sizes, the colour inside and out, the glass and the handles, and it prices as you go. If the number works, carry on. If it does not, you have lost ten minutes rather than an evening.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is a real quote for the specification you entered, not a teaser figure. The only thing that can move it is the survey, once we have measured the openings properly, and we tell you plainly when something is likely to change.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Price your job now', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/window-door-prices-milton-keynes/')); ?>"><?php esc_html_e('See example prices', 'fenster'); ?></a>
                </div>
            </div>
            <ul class="fg-about-pricing__points">
                <li><strong><?php esc_html_e('Ten minutes, not ten days', 'fenster'); ?></strong><span><?php esc_html_e('Most people reach a figure on their phone before they ever ring us.', 'fenster'); ?></span></li>
                <li><strong><?php esc_html_e('No pressure appointment', 'fenster'); ?></strong><span><?php esc_html_e('Nobody sits in your front room discounting a price that was never real.', 'fenster'); ?></span></li>
                <li><strong><?php esc_html_e('Priced from our real list', 'fenster'); ?></strong><span><?php esc_html_e('The same figures the office quotes from, not a rough online estimate.', 'fenster'); ?></span></li>
                <li><strong><?php esc_html_e('Published example costs', 'fenster'); ?></strong><span><?php esc_html_e('Real jobs with real prices, so you can sense-check before you start.', 'fenster'); ?></span></li>
            </ul>
        </div>
    </section>

    <section class="fg-about-installs">
        <div class="container">
            <div class="fg-about-installs__head">
                <p class="eyebrow"><?php esc_html_e('Recent installs', 'fenster'); ?></p>
                <h2><?php esc_html_e('Our own work, photographed on the day.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No stock photography and no showroom mock-ups. Drag through a few of the jobs we finished recently, or open the full case studies for specifications, finishes and the fitters who did them.', 'fenster'); ?></p>
            </div>
            <div class="fg-colour-carousel fg-about-carousel" data-fg-colour-carousel>
                <div class="fg-colour-carousel__viewport">
                    <div class="fg-colour-carousel__track" data-fg-colour-carousel-track>
                        <?php foreach ($installs as $index => $install) : ?>
                            <article class="fg-colour-carousel__slide" data-fg-colour-slide>
                                <img <?php echo $img($cs . $install['file'], ['alt' => $install['title'] . ', ' . $install['place'], 'loading' => $index < 2 ? 'eager' : 'lazy']); ?>>
                                <div>
                                    <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                    <h3><?php echo esc_html($install['title']); ?></h3>
                                    <p><?php echo esc_html($install['place']); ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="fg-colour-carousel__controls">
                    <button type="button" data-fg-colour-prev aria-label="<?php esc_attr_e('Previous install', 'fenster'); ?>">&#8249;</button>
                    <span data-fg-colour-count><?php echo esc_html('01 / ' . sprintf('%02d', count($installs))); ?></span>
                    <button type="button" data-fg-colour-next aria-label="<?php esc_attr_e('Next install', 'fenster'); ?>">&#8250;</button>
                </div>
            </div>
            <div class="button-row fg-about-installs__cta">
                <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-about-process">
        <div class="container">
            <div class="fg-about-process__head">
                <p class="eyebrow"><?php esc_html_e('How it works', 'fenster'); ?></p>
                <h2><?php esc_html_e('From a price on your phone to a fitted window.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Five stages, and you can stop at any of them. Nobody is going to chase you.', 'fenster'); ?></p>
            </div>
            <ol class="fg-about-process__list">
                <?php foreach ($process as $item) : ?>
                    <li>
                        <span class="fg-about-process__step"><?php echo esc_html($item['step']); ?></span>
                        <div>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['copy']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="fg-about-founders">
        <div class="container fg-about-founders__grid">
            <div class="fg-about-founders__copy">
                <p class="eyebrow"><?php esc_html_e('Who runs it', 'fenster'); ?></p>
                <h2><?php esc_html_e('Adam and Nick started Fenster in 2018.', 'fenster'); ?></h2>
                <p><?php esc_html_e('They still run it day to day, and between them they have spent their working lives in glazing. Nick looks after the showroom and homeowners. Adam handles the commercial side, which runs from care homes and schools through to curtain walling and access control.', 'fenster'); ?></p>
                <p><?php esc_html_e('The rest of the team came from the trade too: installers with fifteen and twenty years behind them, service engineers, surveyors, estimators, and an office that answers its own phone.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
                </div>
            </div>
            <ul class="fg-about-founders__people">
                <li>
                    <figure class="fg-about-founder">
                        <span class="fg-about-parallax" data-fg-depth="0.04">
                            <img <?php echo $img($team . 'adam-butcher-scaled.jpg', ['alt' => 'Adam Butcher', 'loading' => 'lazy']); ?>>
                        </span>
                        <figcaption><strong><?php esc_html_e('Adam Butcher', 'fenster'); ?></strong><span><?php esc_html_e('Commercial Director', 'fenster'); ?></span></figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="fg-about-founder">
                        <span class="fg-about-parallax" data-fg-depth="0.09">
                            <img <?php echo $img($team . 'unnamed-5.jpg', ['alt' => 'Nick Baker', 'loading' => 'lazy']); ?>>
                        </span>
                        <figcaption><strong><?php esc_html_e('Nick Baker', 'fenster'); ?></strong><span><?php esc_html_e('Sales Director', 'fenster'); ?></span></figcaption>
                    </figure>
                </li>
            </ul>
        </div>
    </section>

    <section class="fg-about-trust">
        <div class="container">
            <div class="fg-about-trust__head">
                <p class="eyebrow"><?php esc_html_e('Trusted and accredited', 'fenster'); ?></p>
                <h2><?php esc_html_e('The badges, and what each one actually means.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Plenty of installers show these logos without explaining them. Here is what ours cover, including the parts most companies leave in the small print.', 'fenster'); ?></p>
            </div>
            <ul class="fg-about-trust__grid">
                <?php foreach ($accreditations as $item) : ?>
                    <li>
                        <a class="fg-about-badge" href="<?php echo esc_url($item['url']); ?>">
                            <span class="fg-about-badge__logo"><img <?php echo $img($item['src'], ['alt' => $item['alt'], 'loading' => 'lazy']); ?>></span>
                            <strong><?php echo esc_html($item['title']); ?></strong>
                            <span class="fg-about-badge__copy"><?php echo esc_html($item['copy']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-about-trust__note"><?php esc_html_e('The ten year guarantee covers new window and door installations. Repairs, replacement glass, roofline, integral blinds and pet flaps sit outside it, and it stays with you rather than the property if you sell. We would rather say that here than bury it.', 'fenster'); ?></p>
            <div class="button-row">
                <a class="button button--light" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('How our guarantees work', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <figure class="fg-about-award__media">
                <span class="fg-about-parallax" data-fg-depth="0.07">
                    <img <?php echo $img($cs . 'cs-roof-lantern-heritage-doors-poster.jpg', ['alt' => 'Black heritage aluminium doors and a Sheerline roof lantern on a Northampton extension', 'loading' => 'lazy']); ?>>
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
                <div class="button-row">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a>
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

    <section class="fg-about-visit">
        <div class="container fg-about-visit__grid">
            <figure class="fg-about-visit__media">
                <span class="fg-about-parallax" data-fg-depth="0.05">
                    <img <?php echo $img($about . 'fenster-showroom.png', ['alt' => 'The Fenster Glazing showroom on Alston Drive, Milton Keynes', 'loading' => 'lazy']); ?>>
                </span>
                <figcaption><?php esc_html_e('Alston Drive, Bradwell Abbey', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-about-visit__copy">
                <p class="eyebrow"><?php esc_html_e('Come and see us', 'fenster'); ?></p>
                <h2><?php esc_html_e('The showroom is open, and you do not need an appointment.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Frames, colours, handles and glass all look different in person than they do on a screen. Come and open a bifold, feel the difference between a foil and a powder coat, and hold the handles before you choose them.', 'fenster'); ?></p>
                <?php if ($address !== []) : ?>
                    <address class="fg-about-visit__address">
                        <?php foreach ($address as $line) : ?>
                            <span><?php echo esc_html($line); ?></span>
                        <?php endforeach; ?>
                    </address>
                <?php endif; ?>
                <p class="fg-about-visit__hours"><?php esc_html_e('Monday to Friday, 8.30am to 5pm. Phone lines answered around the clock.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact us', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

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
