<?php
/**
 * Hardcoded about page.
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
$images = is_array($page['images'] ?? null) ? $page['images'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);

$image_src = static function (int $index, string $fallback) use ($images): string {
    return (string) ($images[$index]['src'] ?? $fallback);
};

$asset_base = '/wp-content/themes/fenster/assets/images/imported/';
$hero_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';
$project_image = $image_src(1, $asset_base . 'Colston-Street-2-600x450-2.jpg');
$contact_image = $asset_base . 'new-front-door-in-Milton-Keynes.jpeg';
$showroom_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';

$assurances = [
    [
        'title' => 'See the products for yourself',
        'copy' => 'Compare frames, colours, handles and glass options at our Milton Keynes showroom.',
    ],
    [
        'title' => 'A proper survey before we order',
        'copy' => 'We check sizes, access, thresholds, hardware and finishing details at your property.',
    ],
    [
        'title' => 'Help after the installation',
        'copy' => 'Our team remains available for guarantee queries, maintenance advice and aftercare.',
    ],
];

$process = [
    ['title' => 'Talk', 'copy' => 'Call, email, visit the showroom or use the enquiry form to explain what you want to change.'],
    ['title' => 'Quote', 'copy' => 'Fenster helps compare suitable products, finishes, glass options and practical installation details.'],
    ['title' => 'Survey', 'copy' => 'A proper survey checks sizes, access, thresholds, trims, hardware and the condition of the opening.'],
    ['title' => 'Install', 'copy' => 'Experienced fitters install the products, tidy the details and leave you with aftercare information.'],
];

?>

<article class="fg-about-page">
    <section class="fg-about-hero">
        <div class="container fg-about-hero__grid">
            <div class="fg-about-hero__copy">
                <p class="eyebrow"><?php esc_html_e('About Fenster Glazing', 'fenster'); ?></p>
                <h1><?php esc_html_e('Windows, doors and glazing from a local team.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Visit our Milton Keynes showroom, explore the options and talk through your home improvements with the Fenster team.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Visit the showroom', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-about-hero__media">
                <img src="<?php echo esc_url(fenster_generated_url($hero_image)); ?>" alt="<?php esc_attr_e('Fenster Glazing showroom exterior in Milton Keynes', 'fenster'); ?>" loading="eager">
                <div>
                    <strong><?php esc_html_e('Made for the way you use your home', 'fenster'); ?></strong>
                    <span><?php esc_html_e('Explore windows and doors in styles and finishes that suit your property.', 'fenster'); ?></span>
                </div>
            </div>
        </div>
    </section>

    <div class="fg-about-main">
        <section class="fg-about-story">
            <div class="container fg-about-story__grid">
                <div class="fg-about-story__copy">
                    <p class="eyebrow"><?php esc_html_e('About Fenster', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Friendly advice for improving your home.', 'fenster'); ?></h2>
                    <p class="fg-about-story__lead"><?php esc_html_e('We supply and install windows, doors and glazing across Milton Keynes, Buckinghamshire and the surrounding areas.', 'fenster'); ?></p>
                    <p><?php esc_html_e('Our team can help you compare uPVC and aluminium frames, colours, glass, security and hardware. We will explain the options clearly, survey the property carefully and keep you informed through ordering and installation.', 'fenster'); ?></p>
                    <a class="text-link" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('View our recent work', 'fenster'); ?></a>
                </div>
                <figure class="fg-about-story__media">
                    <img src="<?php echo esc_url(fenster_generated_url($project_image)); ?>" alt="<?php esc_attr_e('A completed Fenster Glazing home installation', 'fenster'); ?>" loading="lazy">
                    <figcaption>
                        <strong><?php esc_html_e('Windows, doors and glazing for your home', 'fenster'); ?></strong>
                        <span><?php esc_html_e('From a single replacement window to a larger home renovation.', 'fenster'); ?></span>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="fg-about-assurance">
            <div class="container fg-about-assurance__grid">
                <div class="fg-about-assurance__heading">
                    <p class="eyebrow"><?php esc_html_e('What to expect', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Helpful advice from your first visit onwards.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('We help you choose the products, check the details at survey and support the installation afterwards.', 'fenster'); ?></p>
                </div>
                <div class="fg-about-assurance__list">
                    <?php foreach ($assurances as $assurance) : ?>
                        <article>
                            <div>
                                <h3><?php echo esc_html($assurance['title']); ?></h3>
                                <p><?php echo esc_html($assurance['copy']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-about-process">
            <div class="container">
                <div class="fg-about-section-head">
                    <p class="eyebrow"><?php esc_html_e('Your installation with Fenster', 'fenster'); ?></p>
                    <h2><?php esc_html_e('What happens from enquiry to installation.', 'fenster'); ?></h2>
                </div>
                <div class="fg-about-process__grid">
                    <?php foreach ($process as $item) : ?>
                        <article>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-about-area-cta">
            <div class="container fg-about-area-cta__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Where we work', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Fenster serves Milton Keynes and surrounding towns.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Check the main areas we cover for windows, doors, replacement glass and glazing projects.', 'fenster'); ?></p>
                </div>
                <a class="button" href="<?php echo esc_url(home_url('/areas-we-cover/')); ?>"><?php esc_html_e('View areas we cover', 'fenster'); ?></a>
            </div>
        </section>

        <section class="fg-about-people">
            <div class="container fg-about-people__grid">
                <figure class="fg-about-people__media">
                    <img
                        src="<?php echo esc_url($showroom_image); ?>"
                        alt="<?php esc_attr_e('Exterior of the Fenster Glazing showroom in Milton Keynes', 'fenster'); ?>"
                        width="1536"
                        height="1024"
                        loading="lazy"
                        style="display:block;width:100%;max-width:100%;height:auto;">
                </figure>
                <div class="fg-about-people__copy">
                    <p class="eyebrow"><?php esc_html_e('Our Milton Keynes showroom', 'fenster'); ?></p>
                    <h2><?php esc_html_e('See the choices before you order.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Visit the showroom to look at window and door displays, compare colours and handles, and ask questions about your property. Bring photographs, measurements or plans if you have them and we can help you work through the next steps.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Plan your visit', 'fenster'); ?></a>
                        <a class="text-link" href="<?php echo esc_url(home_url('/meet-the-team/')); ?>"><?php esc_html_e('Meet the team', 'fenster'); ?></a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--about',
        'eyebrow' => 'Customer proof',
        'title' => 'Reviewed, accredited and backed by proven product systems.',
        'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-about-showroom">
        <div class="container fg-about-showroom__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Talk to our team', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you would like to improve.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Call, email or visit the showroom to discuss new windows, doors, repairs or replacement glass for your home.', 'fenster'); ?></p>
                <div class="fg-about-showroom__links">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact page', 'fenster'); ?></a>
                </div>
            </div>
            <img src="<?php echo esc_url(fenster_generated_url($contact_image)); ?>" alt="<?php esc_attr_e('New front door installed by Fenster Glazing', 'fenster'); ?>" loading="lazy">
        </div>
    </section>
</article>
