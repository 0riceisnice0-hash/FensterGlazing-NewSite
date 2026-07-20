<?php
/**
 * Trust and customer confidence page.
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
$showroom_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';
$asset_base = '/wp-content/themes/fenster/assets/images/imported/';
$theme_image_base = '/wp-content/themes/fenster/assets/images/';
$team_image_base = '/wp-content/themes/fenster/assets/team/';
$google_reviews_url = 'https://www.google.com/search?q=Fenster+Glazing+Milton+Keynes+reviews';
$trustpilot_reviews_url = 'https://uk.trustpilot.com/review/fensterglazing.com';

$reasons = [
    [
        'title' => __('Eight years of local trading', 'fenster'),
        'copy' => __('Fenster started in 2018 and has grown around local homes, showroom advice and repeat recommendations. That means there is a real local company behind the quote, with people you can contact before the work starts, while decisions are being made and after the installation is complete.', 'fenster'),
    ],
    [
        'title' => __('Over 50 years of combined experience', 'fenster'),
        'copy' => __('The team brings practical experience across windows, doors, aluminium systems, uPVC, composite doors, replacement glass, repairs and installation planning. Advice is based on products the team actually works with, not a sales script or a one-size-fits-all online estimate.', 'fenster'),
    ],
    [
        'title' => __('Clear prices before the work starts', 'fenster'),
        'copy' => __('Fenster prides itself on transparent upfront pricing. Quotes are built to make the full supply and installation cost clear, with VAT, fitting, delivery and known specification details explained before the job moves forward. If something needs survey confirmation, that is made clear rather than hidden.', 'fenster'),
    ],
    [
        'title' => __('Honest advice, not pressure selling', 'fenster'),
        'copy' => __('Good glazing decisions need straight answers. Fenster helps you compare product type, glass, colour, hardware, security, maintenance, thermal performance and installation approach for your home instead of pushing the quickest sale or the most expensive option.', 'fenster'),
    ],
];

$process_steps = [
    ['step' => '01', 'title' => __('Talk it through', 'fenster'), 'copy' => __('Tell us what you are looking at, what matters most and whether you want a showroom visit, online quote or a home survey conversation first.')],
    ['step' => '02', 'title' => __('Choose the right option', 'fenster'), 'copy' => __('We help narrow the product, glass, colour and hardware choices around your property, budget and the way the room or entrance will be used.')],
    ['step' => '03', 'title' => __('Survey and confirm', 'fenster'), 'copy' => __('Before anything is made, the practical details are checked properly: sizes, access, thresholds, openings, fixing points and site conditions.')],
    ['step' => '04', 'title' => __('Install and support', 'fenster'), 'copy' => __('Your installation is fitted by trained people, with clear contact options afterwards if you have a question or need support after the job is complete.')],
];

$standards = [
    __('We explain what is included in the price, including supply, delivery, installation and VAT where relevant.', 'fenster'),
    __('We do not pressure you to choose before the practical details are clear.', 'fenster'),
    __('We keep the public review platforms visible so you can read customer feedback for yourself.', 'fenster'),
    __('We use enquiry details to handle the quote, survey, installation and aftercare process.', 'fenster'),
];

$hero_trust_cards = [
    [
        'src' => FENSTER_THEME_URI . '/assets/trust/google-5-stars.png',
        'alt' => __('Google five star reviews', 'fenster'),
        'title' => __('Google reviews', 'fenster'),
        'copy' => __('Public customer feedback you can check before you enquire.', 'fenster'),
        'url' => $google_reviews_url,
        'external' => true,
    ],
    [
        'src' => FENSTER_THEME_URI . '/assets/trust/trustpilot-excellent.png',
        'alt' => __('Trustpilot Excellent rating', 'fenster'),
        'title' => __('Trustpilot Excellent', 'fenster'),
        'copy' => __('Independent reviews from customers who have used Fenster.', 'fenster'),
        'url' => $trustpilot_reviews_url,
        'external' => true,
    ],
    [
        'src' => FENSTER_THEME_URI . '/assets/trust/fensa.png',
        'alt' => __('FENSA approved', 'fenster'),
        'title' => __('FENSA approved', 'fenster'),
        'copy' => __('Registered window and door installation work where applicable.', 'fenster'),
        'url' => home_url('/fensa-approved-installers/'),
    ],
    [
        'src' => FENSTER_THEME_URI . '/assets/trust/cpa.png',
        'alt' => __('Consumer Protection Association', 'fenster'),
        'title' => __('CPA backed', 'fenster'),
        'copy' => __('Extra consumer protection available on qualifying work.', 'fenster'),
        'url' => home_url('/consumer-protection-association/'),
    ],
];

$feature_sections = [
    [
        'eyebrow' => __('Local showroom and straight advice', 'fenster'),
        'title' => __('A real place to visit before you choose.', 'fenster'),
        'copy' => __('Fenster is not just a quote form on a website. You can visit the Milton Keynes showroom, see products and finishes, compare handles, glass, frame colours and opening styles, and ask practical questions before making a decision. That matters because glazing choices are easier to trust when you can see the difference between products rather than relying on small brochure images or vague online descriptions.', 'fenster'),
        'src' => $showroom_image,
        'alt' => __('Fenster Glazing showroom in Milton Keynes', 'fenster'),
        'cta_label' => __('Find the showroom', 'fenster'),
        'cta_url' => home_url('/contact/#contact-showroom'),
    ],
    [
        'eyebrow' => __('Products fitted by trained people', 'fenster'),
        'title' => __('Clear choices, careful survey and fitting.', 'fenster'),
        'copy' => __('Windows, doors, glass, colours and hardware are explained around your home, budget and priorities. Once you are happy with the direction, the practical details are checked through survey before manufacture: sizes, access, thresholds, opening direction, fixing conditions and any details that could affect the final fit. The aim is simple: no surprises, no guesswork and no pretending a made-to-measure installation is a one-click purchase.', 'fenster'),
        'src' => fenster_generated_url($theme_image_base . 'products/curated/sheerline-bifold-exterior.jpg'),
        'alt' => __('Installed aluminium bifold doors', 'fenster'),
        'reverse' => true,
        'cta_label' => __('View products', 'fenster'),
        'cta_url' => home_url('/windows-milton-keynes/'),
    ],
];

$team_cards = [
    [
        'src' => fenster_generated_url($asset_base . 'unnamed-5.jpg'),
        'alt' => __('Nick Baker from Fenster Glazing', 'fenster'),
        'title' => __('Nick Baker', 'fenster'),
        'role' => __('Sales Director', 'fenster'),
        'copy' => __('Leads sales and customer advice, helping customers compare products, designs and practical options before committing.', 'fenster'),
        'slug' => 'nick',
    ],
    [
        'src' => fenster_generated_url($asset_base . 'adam-butcher-scaled.jpg'),
        'alt' => __('Adam Butcher from Fenster Glazing', 'fenster'),
        'title' => __('Adam Butcher', 'fenster'),
        'role' => __('Commercial Director', 'fenster'),
        'copy' => __('Oversees commercial glazing and larger project standards, bringing practical installation knowledge into the way work is planned.', 'fenster'),
        'slug' => 'adam',
    ],
    [
        'src' => fenster_generated_url($team_image_base . 'perry-giffin-cropped-bw.jpg'),
        'alt' => __('Perry Giffin from Fenster Glazing', 'fenster'),
        'title' => __('Perry Giffin', 'fenster'),
        'role' => __('Office Manager', 'fenster'),
        'copy' => __('Keeps enquiries, customer service and day-to-day project communication moving clearly from first contact onward.', 'fenster'),
        'slug' => 'perry',
    ],
];
?>

<article class="fg-trust-page">
    <section class="fg-trust-hero">
        <div class="container fg-trust-hero__grid">
            <div class="fg-trust-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Why trust Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('Honest pricing, experienced fitters and a local team you can actually speak to.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Fenster Glazing has been helping customers since 2018. We combine over 50 years of glazing experience with transparent upfront pricing, highly trained fitters and a straightforward approach from first quote to aftercare.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($google_reviews_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Read Google reviews', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url($trustpilot_reviews_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Read Trustpilot reviews', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-trust-hero__checklist fg-trust-hero__proof" aria-label="<?php esc_attr_e('Fenster trust proof', 'fenster'); ?>">
                <div class="fg-trust-hero__logos">
                    <?php foreach ($hero_trust_cards as $hero_trust_card) : ?>
                        <?php $is_accreditation_hero_logo = str_contains((string) ($hero_trust_card['src'] ?? ''), '/fensa.') || str_contains((string) ($hero_trust_card['src'] ?? ''), '/cpa.'); ?>
                        <div class="fg-trust-hero__logo-card">
                            <?php if ($is_accreditation_hero_logo && ! empty($hero_trust_card['url'])) : ?>
                                <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $hero_trust_card['url']); ?>" aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $hero_trust_card['alt'])); ?>">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($hero_trust_card['src']); ?>" alt="<?php echo esc_attr($hero_trust_card['alt']); ?>" loading="eager">
                            <?php if ($is_accreditation_hero_logo && ! empty($hero_trust_card['url'])) : ?></a><?php endif; ?>
                            <strong><?php echo esc_html($hero_trust_card['title']); ?></strong>
                            <span><?php echo esc_html($hero_trust_card['copy']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </aside>
        </div>
    </section>

    <section class="fg-trust-proof" aria-label="<?php esc_attr_e('Trust proof', 'fenster'); ?>">
        <div class="container fg-trust-proof__grid">
            <article>
                <strong><?php esc_html_e('2018', 'fenster'); ?></strong>
                <span><?php esc_html_e('Fenster Glazing started serving local customers', 'fenster'); ?></span>
            </article>
            <article>
                <strong><?php esc_html_e('8 years', 'fenster'); ?></strong>
                <span><?php esc_html_e('helping homeowners and businesses choose better glazing', 'fenster'); ?></span>
            </article>
            <article>
                <strong><?php esc_html_e('50+ yrs', 'fenster'); ?></strong>
                <span><?php esc_html_e('of combined glazing experience across the team', 'fenster'); ?></span>
            </article>
            <article>
                <strong><?php esc_html_e('Clear prices', 'fenster'); ?></strong>
                <span><?php esc_html_e('transparent upfront quotes with the full installation cost made clear', 'fenster'); ?></span>
            </article>
        </div>
    </section>

    <section class="fg-trust-mission">
        <div class="container fg-trust-mission__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Mission statement', 'fenster'); ?></p>
                <h2><?php esc_html_e('To make buying windows, doors and glazing clearer, fairer and less stressful.', 'fenster'); ?></h2>
            </div>
            <div class="fg-trust-mission__copy">
                <p><?php esc_html_e('Fenster exists to give customers straight advice, transparent upfront pricing and a properly supported installation process. We want every customer to understand what they are buying, why it suits their property and what happens next before they commit.', 'fenster'); ?></p>
                <p><?php esc_html_e('That means combining showroom advice, practical product knowledge, careful survey checks, trained fitting teams and visible aftercare, so the experience feels controlled from first enquiry through to completion.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <section class="fg-trust-features">
        <div class="container">
            <?php foreach ($feature_sections as $feature_section) : ?>
                <article class="fg-trust-feature <?php echo ! empty($feature_section['reverse']) ? 'fg-trust-feature--reverse' : ''; ?>">
                    <figure>
                        <img src="<?php echo esc_url($feature_section['src']); ?>" alt="<?php echo esc_attr($feature_section['alt']); ?>" loading="lazy">
                    </figure>
                    <div>
                        <p class="eyebrow"><?php echo esc_html($feature_section['eyebrow']); ?></p>
                        <h2><?php echo esc_html($feature_section['title']); ?></h2>
                        <p><?php echo esc_html($feature_section['copy']); ?></p>
                        <?php if (! empty($feature_section['cta_label']) && ! empty($feature_section['cta_url'])) : ?>
                            <a class="button" href="<?php echo esc_url($feature_section['cta_url']); ?>"><?php echo esc_html($feature_section['cta_label']); ?></a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="fg-trust-team">
        <div class="container fg-trust-team__layout">
            <div class="fg-trust-section-head">
                <p class="eyebrow"><?php esc_html_e('Meet the team', 'fenster'); ?></p>
                <h2><?php esc_html_e('A few of the people behind Fenster.', 'fenster'); ?></h2>
                <p><?php esc_html_e('These are some of the people involved in customer advice, project planning and keeping enquiries moving clearly. You can meet the wider team on the full team page.', 'fenster'); ?></p>
                <a class="button" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
            </div>
            <div class="fg-trust-team__grid">
                <?php foreach ($team_cards as $team_card) : ?>
                    <article class="fg-trust-team__card fg-trust-team__card--<?php echo esc_attr($team_card['slug']); ?>">
                        <figure>
                            <img src="<?php echo esc_url($team_card['src']); ?>" alt="<?php echo esc_attr($team_card['alt']); ?>" loading="lazy">
                        </figure>
                        <div>
                            <h3><?php echo esc_html($team_card['title']); ?></h3>
                            <span><?php echo esc_html($team_card['role']); ?></span>
                            <p><?php echo esc_html($team_card['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-trust-promises">
        <div class="container">
            <div class="fg-trust-section-head">
                <p class="eyebrow"><?php esc_html_e('Why customers choose Fenster', 'fenster'); ?></p>
                <h2><?php esc_html_e('Trust is built before, during and after the installation.', 'fenster'); ?></h2>
            </div>
            <div class="fg-trust-promises__grid">
                <?php foreach ($reasons as $reason) : ?>
                    <article>
                        <h3><?php echo esc_html($reason['title']); ?></h3>
                        <p><?php echo esc_html($reason['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-trust-reviews', 'limit' => 9]); ?>

    <section class="fg-order-process fg-trust-order-process">
        <div class="container">
            <div class="section-heading section-heading--wide">
                <p class="eyebrow"><?php esc_html_e('Order process', 'fenster'); ?></p>
                <h2><?php esc_html_e('A clear process from first conversation to aftercare.', 'fenster'); ?></h2>
                <p><?php esc_html_e('This is the usual flow. Some jobs are very simple, others need more detail, but the aim is always to keep the next step clear.', 'fenster'); ?></p>
            </div>
            <div class="fg-order-process__rail">
                <?php foreach ($process_steps as $process_step) : ?>
                    <article>
                        <span class="fg-order-process__number"><?php echo esc_html($process_step['step']); ?></span>
                        <div class="fg-order-process__card">
                            <span class="fg-order-process__icon" aria-hidden="true"></span>
                            <h3><?php echo esc_html($process_step['title']); ?></h3>
                            <p><?php echo esc_html($process_step['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-trust-info">
        <div class="container fg-trust-info__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Customer information', 'fenster'); ?></p>
                <h2><?php esc_html_e('Your details are used to help with your project.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Fenster asks for project information so the team can price the work, contact you, plan a survey, arrange installation and support aftercare. The formal privacy and cookie pages explain the detail.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/cookie-policy/')); ?>"><?php esc_html_e('Cookie Policy', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-trust-info__list">
                <strong><?php esc_html_e('Our approach is simple.', 'fenster'); ?></strong>
                <ul>
                    <?php foreach ($standards as $standard) : ?>
                        <li><?php echo esc_html($standard); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="fg-trust-accreditations">
        <div class="container fg-trust-accreditations__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Reviews and backing', 'fenster'); ?></p>
                <h2><?php esc_html_e('Public feedback, recognised bodies and real contact options.', 'fenster'); ?></h2>
                <p><?php esc_html_e('No single badge should be the whole reason you choose a company. Fenster brings the pieces together: public customer feedback, FENSA approval, Consumer Protection Association backing where applicable, and a local team you can contact directly.', 'fenster'); ?></p>
            </div>
            <div class="fg-trust-accreditations__logos" aria-label="<?php esc_attr_e('Fenster trust logos', 'fenster'); ?>">
                <?php foreach ($trust_items as $trust_item) : ?>
                    <?php if (! empty($trust_item['url'])) : ?>
                        <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust_item['url']); ?>"<?php echo fenster_trust_link_attrs($trust_item); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) ($trust_item['alt'] ?? ''))); ?>">
                    <?php endif; ?>
                    <img src="<?php echo esc_url((string) ($trust_item['src'] ?? '')); ?>" alt="<?php echo esc_attr((string) ($trust_item['alt'] ?? '')); ?>" loading="lazy">
                    <?php if (! empty($trust_item['url'])) : ?></a><?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-trust-cta">
        <div class="container fg-trust-cta__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Still deciding?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Ask us anything before you commit.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Ask about products, pricing, surveys, guarantees, reviews, showroom visits, privacy or what happens if something needs attention after the fit.', 'fenster'); ?></p>
            </div>
            <div class="fg-trust-cta__actions">
                <a class="button" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                <a class="button button--light" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                <a class="text-link" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Open contact page', 'fenster'); ?></a>
            </div>
        </div>
    </section>
</article>
