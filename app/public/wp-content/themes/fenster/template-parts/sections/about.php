<?php
/**
 * Hardcoded about page.
 *
 * This page answers what a customer actually wants to know before spending five
 * figures and letting people into their home for several days: who turns up,
 * what they have already built, and what happens if it goes wrong.
 *
 * The crew stage is the centrepiece. It is built by matching the installer
 * names below against the installers recorded on each case study, so adding a
 * new study automatically appears under the right person. It reuses the
 * data-fg-cd-range tab component from the composite door page, so no new
 * JavaScript is needed.
 *
 * Every claim must be owner-confirmed. Do not add installation counts, review
 * totals or guarantee wording that is not in the verified fact set. Do not
 * reinstate the founding anecdote: the owner has ruled it out as unsuitable for
 * publication. See AI.md and inc/legend-assistant.php for the guarantee scope.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$address = is_array($brand['address'] ?? null) ? $brand['address'] : [];

$team_img = FENSTER_THEME_URI . '/assets/images/imported/';
$showroom_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';

/*
 * The people a customer meets on site. Photos are mapped by name here rather
 * than by array position, so adding someone cannot pair the wrong face with the
 * wrong name. Mirrors the fitter map in inc/case-studies-data.php.
 */
$crew = [
    ['name' => 'Johnnie Greenwell', 'role' => 'Installer', 'image' => '1.png', 'note' => 'Over 20 years in the trade.'],
    ['name' => 'Tom Carter', 'role' => 'Installer', 'image' => 'unnamed-8.jpg', 'note' => ''],
    ['name' => 'Zac Rugman', 'role' => 'Installer', 'image' => '8.png', 'note' => 'Over 15 years in the trade.'],
    ['name' => 'Shane Gowing', 'role' => 'Installer', 'image' => '20250617_1628580-scaled.jpg', 'note' => 'Time served.'],
    ['name' => 'Andy McCullagh', 'role' => 'Service Engineer', 'image' => '7.png', 'note' => 'Repairs, adjustments and aftercare.'],
    ['name' => 'David Foord', 'role' => 'Installation Manager', 'image' => 'David-Foord.jpg', 'note' => 'Plans and checks every installation.'],
];

// Attach the documented jobs for each person, newest first.
$studies = function_exists('fenster_case_studies') ? fenster_case_studies() : [];
foreach ($crew as $index => $member) {
    $jobs = [];

    foreach ($studies as $short_slug => $study) {
        $installers = is_array($study['installers'] ?? null) ? $study['installers'] : [];
        $names = array_map(static fn ($person): string => (string) ($person['name'] ?? ''), $installers);

        if (! in_array($member['name'], $names, true)) {
            continue;
        }

        $image = is_array($study['images'][0] ?? null) ? (string) ($study['images'][0]['src'] ?? '') : '';
        if ($image === '' && is_array($study['video'] ?? null)) {
            $image = (string) ($study['video']['poster'] ?? '');
        }

        $jobs[] = [
            'title' => (string) ($study['title'] ?? ''),
            'location' => (string) ($study['location'] ?? ''),
            'date' => (string) ($study['date'] ?? ''),
            'summary' => (string) ($study['summary'] ?? ''),
            'image' => $image,
            'url' => home_url('/case-studies/' . $short_slug . '/'),
            'award' => is_array($study['award'] ?? null) ? $study['award'] : null,
        ];
    }

    $crew[$index]['jobs'] = $jobs;
    $crew[$index]['src'] = $team_img . $member['image'];
}

$facts = [
    ['value' => '2018', 'label' => 'Trading since'],
    ['value' => '50+', 'label' => 'Years of combined experience'],
    ['value' => '10 yr', 'label' => 'Insurance-backed guarantee'],
    ['value' => '24/7', 'label' => 'Phone lines answered'],
];

$guarantee_rows = [
    ['term' => 'Covered', 'copy' => 'Every new window and door installation, for ten years from the date of the work.'],
    ['term' => 'Backed by', 'copy' => 'The Consumer Protection Association, which steps in if we ever stop trading. Until then, you come to us.'],
    ['term' => 'Registered', 'copy' => 'FENSA registration on eligible replacement work. FENSA send your certificate to you directly.'],
    ['term' => 'Not covered', 'copy' => 'Repairs, replacement glass, roofline, integral blinds and pet flaps sit outside the ten year guarantee.'],
    ['term' => 'Not transferable', 'copy' => 'The guarantee stays with you rather than the property, so it does not pass on if you sell the house.'],
];

?>

<article class="fg-about">

    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('A Milton Keynes glazing company that shows you the price.', 'fenster'); ?></h1>
                <p class="fg-about-hero__lead"><?php esc_html_e('We have been fitting windows and doors across Milton Keynes and the surrounding counties since 2018. You can price your own job on this website, see the work we have already done, and meet the people who would be at your house before you speak to anyone.', 'fenster'); ?></p>
                <ul class="fg-about-hero__points">
                    <li><?php esc_html_e('Our own installers, not a subcontracted crew', 'fenster'); ?></li>
                    <li><?php esc_html_e('Real prices online, with no form to fill in first', 'fenster'); ?></li>
                    <li><?php esc_html_e('A showroom you can walk into without an appointment', 'fenster'); ?></li>
                </ul>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Price your job', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See our work', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-hero__media">
                <img src="<?php echo esc_url($showroom_image); ?>" alt="<?php esc_attr_e('The Fenster Glazing showroom in Milton Keynes', 'fenster'); ?>" loading="eager" fetchpriority="high" width="960" height="720">
                <figcaption><?php esc_html_e('Our showroom, Bradwell Abbey', 'fenster'); ?></figcaption>
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

    <section class="fg-about-crew" data-fg-cd-range>
        <div class="container">
            <div class="fg-about-crew__head">
                <p class="eyebrow"><?php esc_html_e('The people who turn up', 'fenster'); ?></p>
                <h2><?php esc_html_e('Pick a name and see what they have built.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Our installers and engineers are on the payroll, not booked in for the week. These are the same people on every job, and each install below is one of ours.', 'fenster'); ?></p>
            </div>

            <div class="fg-about-crew__stage">
                <div class="fg-about-crew__selector" role="tablist" aria-label="<?php esc_attr_e('Fenster installers and engineers', 'fenster'); ?>">
                    <?php foreach ($crew as $index => $member) : ?>
                        <button
                            class="fg-about-crew__tab"
                            type="button"
                            role="tab"
                            id="fg-crew-tab-<?php echo esc_attr((string) $index); ?>"
                            aria-controls="fg-crew-panel-<?php echo esc_attr((string) $index); ?>"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            data-fg-cd-range-tab="<?php echo esc_attr((string) $index); ?>"
                        >
                            <span class="fg-about-crew__tab-portrait">
                                <img src="<?php echo esc_url(fenster_generated_url($member['src'])); ?>" alt="" loading="lazy" aria-hidden="true">
                            </span>
                            <strong><?php echo esc_html($member['name']); ?></strong>
                            <span class="fg-about-crew__tab-role"><?php echo esc_html($member['role']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-about-crew__display">
                    <?php foreach ($crew as $index => $member) : ?>
                        <figure class="fg-about-crew__portrait" data-fg-cd-range-image="<?php echo esc_attr((string) $index); ?>" <?php echo $index === 0 ? '' : 'hidden'; ?>>
                            <img src="<?php echo esc_url(fenster_generated_url($member['src'])); ?>" alt="<?php echo esc_attr($member['name']); ?>" loading="lazy">
                            <figcaption>
                                <strong><?php echo esc_html($member['name']); ?></strong>
                                <span><?php echo esc_html($member['role']); ?></span>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>

                    <?php foreach ($crew as $index => $member) : ?>
                        <div
                            class="fg-about-crew__panel"
                            id="fg-crew-panel-<?php echo esc_attr((string) $index); ?>"
                            role="tabpanel"
                            aria-labelledby="fg-crew-tab-<?php echo esc_attr((string) $index); ?>"
                            data-fg-cd-range-panel="<?php echo esc_attr((string) $index); ?>"
                            <?php echo $index === 0 ? '' : 'hidden'; ?>
                        >
                            <?php if ($member['note'] !== '') : ?>
                                <p class="fg-about-crew__note"><?php echo esc_html($member['note']); ?></p>
                            <?php endif; ?>

                            <?php if ($member['jobs'] !== []) : ?>
                                <p class="fg-about-crew__count">
                                    <?php
                                    printf(
                                        esc_html(_n('%s documented install', '%s documented installs', count($member['jobs']), 'fenster')),
                                        esc_html(number_format_i18n(count($member['jobs'])))
                                    );
                                    ?>
                                </p>
                                <ul class="fg-about-crew__jobs">
                                    <?php foreach ($member['jobs'] as $job) : ?>
                                        <li>
                                            <a class="fg-about-job" href="<?php echo esc_url($job['url']); ?>">
                                                <span class="fg-about-job__media">
                                                    <?php if ($job['image'] !== '') : ?>
                                                        <img src="<?php echo esc_url($job['image']); ?>" alt="" loading="lazy" aria-hidden="true">
                                                    <?php endif; ?>
                                                    <?php if ($job['award']) : ?>
                                                        <span class="fg-about-job__award"><?php esc_html_e('Award winner', 'fenster'); ?></span>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="fg-about-job__body">
                                                    <strong><?php echo esc_html($job['title']); ?></strong>
                                                    <span class="fg-about-job__meta">
                                                        <?php echo esc_html($job['location']); ?>
                                                        <?php if ($job['date'] !== '') : ?>
                                                            <em><?php echo esc_html(date_i18n('M Y', (int) strtotime($job['date']))); ?></em>
                                                        <?php endif; ?>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p class="fg-about-crew__empty"><?php esc_html_e('Every install we document is surveyed, planned and signed off before the team leaves site.', 'fenster'); ?></p>
                                <p><a href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See the installs', 'fenster'); ?></a></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <p class="fg-about-crew__more">
                <a href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet everyone, including the office and commercial team', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-about-award">
        <div class="container fg-about-award__grid">
            <figure class="fg-about-award__media">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/case-studies/cs-lantern-doors-interior.jpg'); ?>" alt="<?php esc_attr_e('Black heritage aluminium doors and a Sheerline roof lantern on a Northampton extension', 'fenster'); ?>" loading="lazy">
                <figcaption><?php esc_html_e('Northampton, April 2025', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-about-award__copy">
                <p class="eyebrow"><?php esc_html_e('Recognised work', 'fenster'); ?></p>
                <h2><?php esc_html_e('Sheerline made one of our installs their Installation of the Month.', 'fenster'); ?></h2>
                <p><?php esc_html_e('In August 2025 Sheerline picked out an extension we finished in Northampton: an S1 roof lantern overhead and a set of black steel-look heritage doors opening to the garden. Johnnie and Tom fitted it.', 'fenster'); ?></p>
                <p class="fg-about-award__mark">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/partners/sheerline.png'); ?>" alt="<?php esc_attr_e('Sheerline', 'fenster'); ?>" loading="lazy">
                    <span><?php esc_html_e('Installation of the Month, August 2025', 'fenster'); ?></span>
                </p>
                <p>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/roof-lantern-and-heritage-doors/')); ?>"><?php esc_html_e('See the project', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <section class="fg-about-guarantee">
        <div class="container fg-about-guarantee__grid">
            <div class="fg-about-guarantee__copy">
                <p class="eyebrow"><?php esc_html_e('What we stand behind', 'fenster'); ?></p>
                <h2><?php esc_html_e('The guarantee, including the parts most companies leave out.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A ten year guarantee is only worth what it actually covers. Here is the whole of it rather than the headline.', 'fenster'); ?></p>
                <p class="fg-about-guarantee__links">
                    <a href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>"><?php esc_html_e('How the CPA backing works', 'fenster'); ?></a>
                    <a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>"><?php esc_html_e('What FENSA registration means', 'fenster'); ?></a>
                </p>
            </div>
            <dl class="fg-about-guarantee__rows">
                <?php foreach ($guarantee_rows as $row) : ?>
                    <div class="fg-about-guarantee__row">
                        <dt><?php echo esc_html($row['term']); ?></dt>
                        <dd><?php echo esc_html($row['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <section class="fg-about-prices">
        <div class="container fg-about-prices__inner">
            <p class="eyebrow"><?php esc_html_e('Open about prices', 'fenster'); ?></p>
            <h2><?php esc_html_e('You should not have to give us your number to find out what it costs.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Build a real quote for your own windows and doors, with your sizes, colours, glass and hardware, and see the price on screen. If you want a rough idea first, our price guides show what recent jobs actually came to.', 'fenster'); ?></p>
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
                <p><?php esc_html_e('Frames, colours, handles and glass look different in person than they do on a screen. We are a few minutes from the centre of Milton Keynes and you do not need an appointment.', 'fenster'); ?></p>
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
                    <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a home visit', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-about-visit__media">
                <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/team/legend-colour.webp'); ?>" alt="<?php esc_attr_e('Legend, the Fenster Glazing office cat', 'fenster'); ?>" loading="lazy">
                <figcaption>
                    <?php
                    printf(
                        /* translators: %s: link to Legend's team profile. */
                        esc_html__('%s, who runs the office.', 'fenster'),
                        '<a href="' . esc_url(home_url('/meet-the-team/#legend')) . '">' . esc_html__('Legend', 'fenster') . '</a>'
                    );
                    ?>
                </figcaption>
            </figure>
        </div>
    </section>

</article>
