<?php
/**
 * Commercial glazing county landing pages.
 *
 * @package Fenster
 */

$page = is_array($args['page'] ?? null) ? $args['page'] : [];
$slug = (string) ($page['slug'] ?? '');
$asset_base = (string) ($args['asset_base'] ?? '');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$related_links = is_array($args['links'] ?? null) ? $args['links'] : [];
$county_slug = str_replace('commercial-glazing-', '', $slug);
$profiles = function_exists('fenster_commercial_county_profiles') ? fenster_commercial_county_profiles() : [];
$profile = $profiles[$county_slug] ?? null;

if (! is_array($profile)) {
    return;
}

$county_name = (string) ($profile['county'] ?? 'England');
$region = (string) ($profile['region'] ?? $county_name);
$towns = is_array($profile['towns'] ?? null) ? array_values($profile['towns']) : [];
$context = (string) ($profile['context'] ?? 'commercial buildings, public estates and phased refurbishment projects');
$brand_phone = (string) ($brand['phone'] ?? '01908 429200');
$brand_email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
/* The county routes are commercial pages too — around forty of them — so they
   show the commercial address like the rest of the set. See the note on
   `brand.commercial_email` in `inc/site-data.php`. */
$commercial_email = (string) ($brand['commercial_email'] ?? $brand_email);
$phone_href = preg_replace('/\s+/', '', $brand_phone);
$town_summary = implode(', ', array_slice($towns, 0, 4));

$service_images = [
    $asset_base . 'c02c21c7-23d6-4a83-a739-3932c9eeaffd.png',
    $asset_base . 'curtain-walling.jpg',
    $asset_base . 'replacement-glazing-milton-keynes-scaled.jpg',
    '/wp-content/themes/fenster/assets/images/products/louvre/louvre-plant-doorset-1300w.jpg',
];
$services = [
    [
        'title' => 'Commercial windows and doors',
        'label' => 'Windows + doors',
        'copy' => sprintf('Aluminium and uPVC packages shaped around %s in %s.', $context, $county_name),
        'detail' => 'Frames, glazing, doors, hardware and finishes can be reviewed as one coordinated package.',
        'url' => home_url('/commercial-windows-and-doors/'),
        'image' => $service_images[0],
    ],
    [
        'title' => 'Curtain walling',
        'label' => 'Curtain walling',
        'copy' => sprintf('Facade and entrance glazing reviewed around structure, access and performance across %s.', $region),
        'detail' => 'Bring elevations, interface details and performance targets into the conversation early.',
        'url' => home_url('/curtain-walling/'),
        'image' => $service_images[1],
    ],
    [
        'title' => 'Replacement glazing',
        'label' => 'Replacement glass',
        'copy' => sprintf('Measured replacement units and phased glass upgrades for occupied buildings in %s.', $county_name),
        'detail' => 'Plan failed-unit replacement or wider glass upgrades around live building access.',
        'url' => home_url('/commercial-replacement-glazing/'),
        'image' => $service_images[2],
    ],
    [
        'title' => 'Louvres and ventilation',
        'label' => 'Louvres + airflow',
        'copy' => sprintf('Airflow, screening and louvre details coordinated with commercial glazing packages in %s.', $county_name),
        'detail' => 'Coordinate airflow, screening and facade appearance without treating them as isolated items.',
        'url' => home_url('/louvre-vents/'),
        'image' => $service_images[3],
    ],
];
$delivery_points = [
    [
        'title' => 'County-specific planning',
        'copy' => sprintf('Fenster reviews %s, access, programme pressure and the practical constraints that tend to affect commercial glazing in %s.', $context, $county_name),
    ],
    [
        'title' => 'Survey-led scope checks',
        'copy' => sprintf('Drawings, schedules, photographs and site notes help the team identify the right glazing approach before pricing work in %s.', $region),
    ],
    [
        'title' => 'Phased live-site work',
        'copy' => sprintf('Where buildings stay occupied, window, door and glass replacement can be planned around staff, visitors, residents or other trades in places such as %s.', $town_summary ?: $county_name),
    ],
];
$sectors = [
    'Education and public buildings',
    'Healthcare and care settings',
    'Offices and business parks',
    'Hospitality and leisure',
    'Retail and mixed-use property',
    'Multi-site refurbishment',
];
$faqs = [
    [
        'question' => sprintf('Which parts of %s do you cover?', $county_name),
        'answer' => sprintf('Fenster can review commercial glazing projects across %s, including %s. If your site is nearby, send the postcode and the team can confirm the best approach.', $county_name, implode(', ', $towns)),
    ],
    [
        'question' => sprintf('What makes %s commercial projects different?', $county_name),
        'answer' => sprintf('Projects in %s often involve %s, so Fenster starts by checking access, usage, specification, performance targets and installation sequencing.', $region, $context),
    ],
    [
        'question' => 'Can you work in occupied commercial buildings?',
        'answer' => 'Yes. The project review can include phased access, segregation, delivery timing, protection and sequencing around staff, residents, visitors or other trades.',
    ],
    [
        'question' => 'Can Fenster review drawings and schedules before pricing?',
        'answer' => 'Yes. Send drawings, elevations, window or door schedules, site photographs and performance requirements so the team can identify relevant systems and any scope gaps.',
    ],
];
?>

<article class="fg-commercial-hub fg-commercial-county">
    <section class="fg-county-hero">
        <img class="fg-county-hero__image" src="<?php echo esc_url(fenster_generated_url($asset_base . 'commercial-glazed-elevation.jpg')); ?>" alt="<?php echo esc_attr('Commercial glazing in ' . $county_name); ?>" loading="eager">
        <div class="fg-county-hero__shade"></div>
        <div class="container fg-county-hero__inner">
            <div class="fg-county-hero__copy">
                <p class="eyebrow"><?php echo esc_html('Commercial glazing ' . $county_name); ?></p>
                <h1><?php echo esc_html('Commercial glazing across ' . $county_name . '.'); ?></h1>
                <p><?php echo esc_html(sprintf('Fenster supports contractors, estates teams, facilities managers and building owners with commercial windows, doors, curtain walling and replacement glazing across %s.', $region)); ?></p>
                <div class="fg-county-hero__contact">
                    <a class="fg-county-hero__phone" href="tel:<?php echo esc_attr($phone_href); ?>">
                        <span><?php esc_html_e('Call commercial enquiries', 'fenster'); ?></span>
                        <strong><?php echo esc_html($brand_phone); ?></strong>
                    </a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('View projects', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-county-hero__form" aria-label="<?php echo esc_attr('Commercial glazing enquiry form for ' . $county_name); ?>">
                <div class="fg-county-hero__form-head">
                    <span><?php esc_html_e('Fast project response', 'fenster'); ?></span>
                    <h2><?php echo esc_html('Tell us about your ' . $county_name . ' site.'); ?></h2>
                    <p><?php esc_html_e('Send the basics now. You can attach drawings, schedules or photos to the form.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-commercial-form fg-commercial-form--hero',
                    'source' => 'Commercial glazing ' . $county_name,
                    'button_label' => 'Send project enquiry',
                    'project_type' => 'Commercial glazing',
                    'project_options' => [
                        'Commercial glazing',
                        'Commercial windows and doors',
                        'Curtain walling',
                        'Louvres or ventilation',
                        'Replacement glazing',
                    ],
                    'compact' => true,
                    'show_company' => true,
                ]);
                ?>
                <p class="fg-county-hero__email"><?php esc_html_e('Prefer email?', 'fenster'); ?> <a href="mailto:<?php echo esc_attr($commercial_email); ?>"><?php echo esc_html($commercial_email); ?></a></p>
            </aside>
        </div>
    </section>

    <section class="fg-county-summary">
        <div class="container fg-county-summary__grid">
            <div class="fg-county-summary__copy">
                <p class="eyebrow"><?php echo esc_html('Commercial glazing in ' . $county_name); ?></p>
                <h2><?php echo esc_html('Project coverage across ' . $region . '.'); ?></h2>
                <p><?php echo esc_html(sprintf('Fenster reviews commercial window, door, curtain walling, louvre and replacement glazing requirements across %s. The commercial team checks drawings, schedules, performance requirements, access constraints and the practical demands of %s.', $county_name, $context)); ?></p>
                <a class="button" href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>"><?php esc_html_e('Explore commercial glazing', 'fenster'); ?></a>
            </div>
            <figure class="fg-county-summary__media">
                <img src="<?php echo esc_url(fenster_generated_url($services[0]['image'])); ?>" alt="<?php echo esc_attr('Commercial glazing package for ' . $county_name); ?>" loading="lazy">
            </figure>
        </div>
    </section>

    <section class="fg-county-details">
        <div class="container fg-county-details__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Services', 'fenster'); ?></p>
                <div class="fg-county-details__links">
                    <?php foreach ($services as $service) : ?>
                        <a href="<?php echo esc_url($service['url']); ?>"><?php echo esc_html($service['title']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <p class="eyebrow"><?php echo esc_html('Areas in ' . $county_name); ?></p>
                <div class="fg-county-details__tags">
                    <?php foreach ($towns as $town) : ?>
                        <span><?php echo esc_html($town); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <p class="eyebrow"><?php esc_html_e('Typical projects', 'fenster'); ?></p>
                <div class="fg-county-details__tags">
                    <?php foreach ($sectors as $sector) : ?>
                        <span><?php echo esc_html($sector); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-county-operations">
        <div class="container fg-county-operations__grid">
            <div class="fg-county-operations__intro">
                <p class="eyebrow"><?php esc_html_e('Planning notes', 'fenster'); ?></p>
                <h2><?php echo esc_html('Commercial glazing planned around ' . $county_name . ' sites.'); ?></h2>
                <p><?php echo esc_html(sprintf('The useful first step is a clear brief: building type, location, drawings or photographs, target dates and any access constraints around %s.', $context)); ?></p>
            </div>
            <div class="fg-county-operations__cards">
                <?php foreach ($delivery_points as $point) : ?>
                    <article>
                        <span aria-hidden="true"></span>
                        <h3><?php echo esc_html($point['title']); ?></h3>
                        <p><?php echo esc_html($point['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="fg-county-operations__coverage">
                <div>
                    <span><?php esc_html_e('County coverage', 'fenster'); ?></span>
                    <strong><?php echo esc_html($county_name); ?></strong>
                </div>
                <div class="fg-county-operations__towns">
                    <?php foreach ($towns as $town) : ?>
                        <span><?php echo esc_html($town); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-location-faq fg-commercial-county__faq">
        <div class="container fg-location-faq__grid">
            <div>
                <p class="eyebrow"><?php echo esc_html($county_name . ' FAQs'); ?></p>
                <h2><?php esc_html_e('Commercial glazing questions.', 'fenster'); ?></h2>
            </div>
            <div class="fg-location-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="commercial-county-enquiry" class="fg-county-cta">
        <div class="container fg-county-cta__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Commercial project support', 'fenster'); ?></p>
                <h2><?php echo esc_html('Have a project in ' . $county_name . '?'); ?></h2>
                <p><?php echo esc_html(sprintf('Call %s or use the form above with the site postcode, building type and the first details you have available.', $brand_phone)); ?></p>
            </div>
            <a class="button" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html('Call ' . $brand_phone); ?></a>
        </div>
    </section>

    <section class="fg-links-band">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow"><?php esc_html_e('Related commercial pages', 'fenster'); ?></p>
                <h2><?php esc_html_e('Services, projects and glazing packages', 'fenster'); ?></h2>
            </div>
            <div class="generated-links">
                <?php foreach (array_slice(array_values($related_links), 0, 24) as $link) : ?>
                    <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</article>
