<?php
/**
 * Hardcoded about page.
 *
 * This page answers the question a customer actually has before spending five
 * figures and letting people into their home for several days: who turns up,
 * where are they based, and what happens if something goes wrong. It leads with
 * the installers and engineers rather than the directors, because they are the
 * people the customer meets.
 *
 * Every claim here must be owner-confirmed. Do not add installation counts,
 * review totals or guarantee wording that is not in the verified fact set. See
 * AI.md, and the guarantee scope in inc/legend-assistant.php.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$address = is_array($brand['address'] ?? null) ? $brand['address'] : [];

$team_img = FENSTER_THEME_URI . '/assets/images/imported/';
$about_img = FENSTER_THEME_URI . '/assets/images/about/';
$asset_base = '/wp-content/themes/fenster/assets/images/imported/';

$showroom_image = $about_img . 'fenster-showroom.png';
$story_image = $asset_base . 'Colston-Street-2-600x450-2.jpg';

// The people a customer actually meets. Photos are mapped by name here rather
// than by array position, so adding or reordering someone cannot pair the wrong
// face with the wrong name. This mirrors the fitter map in
// inc/case-studies-data.php. Anyone without a photo is simply omitted.
$person = static function (string $name, string $role, string $image, string $note = '') use ($team_img): array {
    return [
        'name' => $name,
        'role' => $role,
        'image' => $team_img . $image,
        'note' => $note,
        'url' => home_url('/meet-the-team/#' . sanitize_title($name)),
    ];
};

$crew = [
    $person('David Foord', 'Installation Manager', 'David-Foord.jpg', 'Plans and checks the installs'),
    $person('Johnnie Greenwell', 'Installer', '1.png', 'Over 20 years in the trade'),
    $person('Zac Rugman', 'Installer', '8.png', 'Over 15 years in the trade'),
    $person('Tom Carter', 'Installer', 'unnamed-8.jpg'),
    $person('Shane Gowing', 'Installer', '20250617_1628580-scaled.jpg', 'Time served'),
    $person('Andy McCullagh', 'Service Engineer', '7.png', 'Repairs and aftercare'),
    $person('Steven Welch', 'Service Engineer', '5-2.png', 'Repairs and aftercare'),
];

// Only facts that are owner-confirmed or already published sitewide.
$facts = [
    [
        'value' => '2018',
        'label' => 'The year we started',
        'copy' => 'Eight years of trading around Milton Keynes, built on local homes and repeat recommendations.',
    ],
    [
        'value' => '50+ years',
        'label' => 'Combined experience',
        'copy' => 'Across uPVC, aluminium, composite doors, glass, repairs and installation planning.',
    ],
    [
        'value' => '10 years',
        'label' => 'Insurance-backed guarantee',
        'copy' => 'On every new window and door installation, backed by the Consumer Protection Association.',
    ],
    [
        'value' => 'Mon to Fri',
        'label' => 'Showroom, 8.30am to 5pm',
        'copy' => 'Phone lines are answered around the clock, so an out of hours call still reaches someone.',
    ],
];

$guarantee_covers = [
    'Every new window and door installation, for ten years.',
    'Backed by the Consumer Protection Association if we ever stop trading.',
    'FENSA registration on eligible replacement work, with the certificate sent to you directly.',
];

$guarantee_limits = [
    'Repairs, replacement glass, roofline, integral blinds and pet flaps are not covered by the ten year guarantee.',
    'The guarantee stays with you rather than the property, so it does not pass to a new owner if you sell.',
];

?>

<article class="fg-about-page">

    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('We are a Milton Keynes glazing company, and we show you our prices.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('Most window companies make you fill in a form and wait for a salesperson. We would rather you saw the numbers first, met the people who will be at your house, and decided in your own time.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Price your job', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-hero__media">
                <img src="<?php echo esc_url($showroom_image); ?>" alt="<?php esc_attr_e('The Fenster Glazing showroom in Milton Keynes', 'fenster'); ?>" loading="eager" fetchpriority="high" width="960" height="720">
            </figure>
        </div>
    </section>

    <section class="fg-about-story">
        <div class="container fg-about-story__grid">
            <div class="fg-about-story__copy">
                <p class="eyebrow"><?php esc_html_e('How we started', 'fenster'); ?></p>
                <h2><?php esc_html_e('Two people, one Monday morning, and a trade one of them already knew.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Fenster started in 2018 for a reason nobody puts on a website. Nick did not fancy going back to work on the Monday. Adam had spent years in glazing and knew the trade inside out. Between them they decided they would rather run it themselves, so they did.', 'fenster'); ?></p>
                <p><?php esc_html_e('There was no business plan and no grand mission. What we did have was a fair idea of how glazing usually gets sold, because we had both watched it up close. The pressure appointments, the discount that only lasts until Friday, the price you cannot get without giving your phone number first.', 'fenster'); ?></p>
                <p><?php esc_html_e('So the one thing we have been deliberate about is the money. Our prices are on the website. You can build a quote for your own windows and doors, see what it costs, and never speak to us if you do not want to. That is unusual in this trade, and it is the part of Fenster we are proudest of.', 'fenster'); ?></p>
            </div>
            <figure class="fg-about-story__media">
                <img src="<?php echo esc_url(fenster_generated_url($story_image)); ?>" alt="<?php esc_attr_e('A Fenster Glazing installation on a local home', 'fenster'); ?>" loading="lazy">
            </figure>
        </div>
    </section>

    <section class="fg-about-facts">
        <div class="container">
            <div class="fg-about-facts__grid">
                <?php foreach ($facts as $fact) : ?>
                    <div class="fg-about-fact">
                        <strong class="fg-about-fact__value"><?php echo esc_html($fact['value']); ?></strong>
                        <span class="fg-about-fact__label"><?php echo esc_html($fact['label']); ?></span>
                        <p><?php echo esc_html($fact['copy']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-about-crew">
        <div class="container">
            <div class="fg-about-crew__head">
                <p class="eyebrow"><?php esc_html_e('The people who turn up', 'fenster'); ?></p>
                <h2><?php esc_html_e('These are the fitters and engineers who will be at your house.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Not a subcontracted crew booked in for the week. Our installers and service engineers are the same people on every job, and they are the ones named on our case studies.', 'fenster'); ?></p>
            </div>
            <ul class="fg-about-crew__grid">
                <?php foreach ($crew as $member) : ?>
                    <li class="fg-about-crew__item">
                        <a class="fg-about-crew__card" href="<?php echo esc_url($member['url']); ?>">
                            <span class="fg-about-crew__portrait">
                                <img src="<?php echo esc_url(fenster_generated_url($member['image'])); ?>" alt="<?php echo esc_attr($member['name']); ?>" loading="lazy">
                            </span>
                            <strong class="fg-about-crew__name"><?php echo esc_html($member['name']); ?></strong>
                            <span class="fg-about-crew__role"><?php echo esc_html($member['role']); ?></span>
                            <?php if ($member['note'] !== '') : ?>
                                <span class="fg-about-crew__note"><?php echo esc_html($member['note']); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-about-crew__more">
                <a href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('See everyone, including the office and commercial team', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <div class="fg-about-award__copy">
                <p class="eyebrow"><?php esc_html_e('Recognised work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Sheerline made one of our installs their Installation of the Month.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A Sheerline S1 roof lantern and a set of black heritage aluminium doors on an extension in Northampton, fitted by Johnnie and Tom. Sheerline picked it out of the work their installers submitted nationally.', 'fenster'); ?></p>
                <p class="fg-about-award__links">
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a>
                    <a href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('All case studies', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-about-award__media">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/case-studies/cs-lantern-doors-interior.jpg'); ?>" alt="<?php esc_attr_e('Black heritage aluminium doors and a Sheerline roof lantern on a Northampton extension', 'fenster'); ?>" loading="lazy">
                <figcaption>
                    <img class="fg-about-award__logo" src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/partners/sheerline.png'); ?>" alt="<?php esc_attr_e('Sheerline', 'fenster'); ?>" loading="lazy">
                    <span><?php esc_html_e('Installation of the Month', 'fenster'); ?></span>
                </figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-about-guarantee">
        <div class="container">
            <div class="fg-about-guarantee__head">
                <p class="eyebrow"><?php esc_html_e('What we stand behind', 'fenster'); ?></p>
                <h2><?php esc_html_e('The guarantee, including the parts most companies leave out.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A ten year guarantee is only worth what it actually covers, so here is the whole of it rather than the headline.', 'fenster'); ?></p>
            </div>
            <div class="fg-about-guarantee__grid">
                <div class="fg-about-guarantee__panel">
                    <h3><?php esc_html_e('What it covers', 'fenster'); ?></h3>
                    <ul>
                        <?php foreach ($guarantee_covers as $line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="fg-about-guarantee__panel fg-about-guarantee__panel--limits">
                    <h3><?php esc_html_e('What it does not', 'fenster'); ?></h3>
                    <ul>
                        <?php foreach ($guarantee_limits as $line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <p class="fg-about-guarantee__links">
                <a href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>"><?php esc_html_e('How the CPA backing works', 'fenster'); ?></a>
                <a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>"><?php esc_html_e('What FENSA registration means', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-about-prices">
        <div class="container fg-about-prices__inner">
            <p class="eyebrow"><?php esc_html_e('Open about prices', 'fenster'); ?></p>
            <h2><?php esc_html_e('You should not have to give us your number to find out what it costs.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Build a real quote for your own windows and doors, with sizes, colours, glass and hardware, and see the price on screen. If you want a rough idea first, our price guides show what recent jobs actually cost.', 'fenster'); ?></p>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Build a quote', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url(home_url('/window-door-prices-milton-keynes/')); ?>"><?php esc_html_e('See price guides', 'fenster'); ?></a>
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
            <div class="fg-about-visit__copy">
                <p class="eyebrow"><?php esc_html_e('Where we are', 'fenster'); ?></p>
                <h2><?php esc_html_e('Come and see the products before you buy them.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Frames, colours, handles and glass look different in person than they do on a screen. The showroom is a few minutes from the centre of Milton Keynes and you do not need an appointment.', 'fenster'); ?></p>
                <?php if ($address !== []) : ?>
                    <address class="fg-about-visit__address">
                        <?php foreach ($address as $line) : ?>
                            <span><?php echo esc_html($line); ?></span>
                        <?php endforeach; ?>
                    </address>
                <?php endif; ?>
                <div class="fg-about-visit__links">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a home visit', 'fenster'); ?></a>
                </div>
                <p class="fg-about-visit__legend">
                    <?php
                    printf(
                        /* translators: %s: link to Legend's team profile. */
                        esc_html__('If a black cat walks across the desk while you are here, that is %s. He was here before most of us.', 'fenster'),
                        '<a href="' . esc_url(home_url('/meet-the-team/#legend')) . '">' . esc_html__('Legend, our Chief Meow Officer', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <figure class="fg-about-visit__media">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/team/legend-colour.webp'); ?>" alt="<?php esc_attr_e('Legend, the Fenster Glazing office cat', 'fenster'); ?>" loading="lazy">
            </figure>
        </div>
    </section>

</article>
