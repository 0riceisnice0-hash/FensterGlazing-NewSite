<?php
/**
 * Commercial glazing hub.
 * ---------------------------------------------------------------------------
 * Extracted out of `generated-page.php` and rebuilt 2026-08-12. It was ~250
 * lines inline in a 3,000-line template, which is why nobody noticed what was
 * wrong with it.
 *
 * WHAT THIS PAGE IS. A hub, and only a hub. Its job is to get a contractor,
 * architect, QS, estimator or PM to the right page in one click and to take the
 * enquiry from the ones who would rather just send the drawings. It sells
 * nothing itself.
 *
 * THE FAULT THE AUDIT FOUND, fixed on 2026-08-12: the fifth product card went
 * to `/double-glazing-replacement/`, a homeowner page headed "Misted and Blown
 * Double Glazing", which then said larger and commercial work is handled through
 * commercial glazing and sent the visitor back here. A commercial buyer clicking
 * the most relevant card completed a loop and landed nowhere.
 *
 * THE FAULT THE AUDIT DID NOT FIND, fixed in the same pass: the hub linked FIVE
 * of the twelve commercial routes. `/automatic-opening-vents/` and all six
 * sector pages had no route in from the page that exists to route people. They
 * were reachable from the main navigation and from nowhere else. There are two
 * card rows now, products and sectors, and every commercial route appears in
 * exactly one of them. If a route is added to
 * `fenster_commercial_product_pages()` it must be added to a row here as well —
 * the same three-registry problem `AI.md` records for residential routes.
 *
 * THE PROOF BAND IS REAL NOW. It carried three hardcoded cards — Barn Hotel,
 * Sunrise Care Home, Herts and Essex — all three linking to the
 * `/commercial-projects/` archive rather than to a study, two of them with
 * completion dates nobody has confirmed. It reads the case-study library
 * instead, so a study added there appears here with its own photograph and its
 * own link, and nothing needs editing twice.
 *
 * REGISTER. `STYLE.md`, Commercial Pages: write for the person pricing it. Lead
 * with the fact, cut the softening, no decorative motion. Still Fenster: plain
 * words and the awkward thing said out loud, just without the warm-up.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$hero_media_src = (string) ($args['hero'] ?? '');
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];

$brand_phone = (string) ($brand['phone'] ?? '01908 429200');
$brand_email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $brand_phone);

$commercial_img = '/wp-content/themes/fenster/assets/images/commercial/';
$cs_img = '/wp-content/themes/fenster/assets/images/case-studies/';
$sector_img = '/wp-content/themes/fenster/assets/images/commercial-sectors/';
$louvre_img = '/wp-content/themes/fenster/assets/images/products/louvre/';

/* ---- Row one: what we install -----------------------------------------------
   Six products. Every card goes to a commercial route; none leaves the
   commercial section. Imagery is our own work throughout. */
$commercial_products = [
    [
        'title' => 'Commercial windows and doors',
        'copy' => 'Aluminium and uPVC windows, doorsets and entrance screens, surveyed and installed as one package.',
        'url' => home_url('/commercial-windows-and-doors/'),
        'image' => $cs_img . 'cs-bletchley-rail-depot-elevation.webp',
        'alt' => 'Refurbished depot elevation with new aluminium windows, doors and curtain walling',
    ],
    [
        'title' => 'Curtain walling',
        'copy' => 'Glazed facades and entrance screens, set out from the grid and detailed at the interfaces.',
        'url' => home_url('/curtain-walling/'),
        'image' => $commercial_img . 'comm-curtain-walling-parade-1600w.jpg',
        'alt' => 'A glazed aluminium curtain walling elevation across a commercial parade',
    ],
    [
        'title' => 'Louvres and ventilation',
        'copy' => 'Blade centres from 30mm to 95mm, physical free area from 43.5% to 57%, sized to the schedule.',
        'url' => home_url('/louvre-vents/'),
        'image' => $louvre_img . 'louvre-vent-headrow-1500w.jpg',
        'alt' => 'An aluminium louvre panel installed in a city centre elevation',
    ],
    [
        'title' => 'AOV smoke ventilation',
        'copy' => 'Automatic opening vents formed within the window line, fitted with the glazing and tested before handover.',
        'url' => home_url('/automatic-opening-vents/'),
        'image' => $cs_img . 'cs-all-hallows-bedford-terrace.webp',
        'alt' => 'A terrace elevation with new aluminium AOV windows and screens',
    ],
    [
        'title' => 'Automatic doors and entrances',
        'copy' => 'Glazed entrance packages set out around the operator, the access control and the escape route.',
        'url' => home_url('/commercial-automation/'),
        'image' => $cs_img . 'cs-bletchley-rail-depot-entrance.webp',
        'alt' => 'A glazed commercial entrance screen with double doors',
    ],
    [
        /* THE CARD THAT USED TO LEAVE THE COMMERCIAL SECTION. See the header. */
        'title' => 'Commercial replacement glazing',
        'copy' => 'Failed and broken units replaced at height and at size, with the floor still in use. No maximum unit size.',
        'url' => home_url('/commercial-replacement-glazing/'),
        'image' => $commercial_img . 'comm-failed-unit-office-1200w.jpg',
        'alt' => 'A crazed glass unit in an office elevation being replaced from inside the room',
    ],
];

/* ---- Row two: buildings we work in ------------------------------------------
   The six sector routes, none of which the hub linked before today. Each was
   written around the constraint that actually differs by sector rather than a
   capability list with the noun swapped, so the card copy leads on that
   constraint rather than on the product. */
$commercial_sectors = [
    [
        'title' => 'Schools and education',
        'copy' => 'Planned around term dates, phased by block, DBS and induction as the site requires.',
        'url' => home_url('/school-and-education-glazing/'),
        'image' => $sector_img . 'sector-education-glazed-run-1400w.webp',
        'alt' => 'A new glazed window run installed in a school building',
    ],
    [
        'title' => 'Student accommodation',
        'copy' => 'Worked back from a September handover that cannot move, usually on a conversion.',
        'url' => home_url('/student-accommodation-glazing/'),
        'image' => $cs_img . 'cs-headrow-court-oriels.webp',
        'alt' => 'Projecting bay windows on a city centre student accommodation building',
    ],
    [
        'title' => 'Hotels and hospitality',
        'copy' => 'Phased by floor, wing or room, because the cost that matters is the rooms out of service.',
        'url' => home_url('/hotel-and-hospitality-glazing/'),
        'image' => $sector_img . 'sector-hospitality-holiday-inn-1400w.webp',
        'alt' => 'A hotel elevation surveyed before window replacement',
    ],
    [
        'title' => 'Care homes',
        'copy' => 'One room opened, glazed and closed the same day, with restrictors to your own assessment.',
        'url' => home_url('/care-home-glazing/'),
        'image' => $sector_img . 'sector-offices-courtyard-1000w.webp',
        'alt' => 'A traditional brick elevation with replacement windows',
    ],
    [
        'title' => 'Offices and retail',
        'copy' => 'Out of hours where trading demands it, floor by floor or unit by unit.',
        'url' => home_url('/office-and-retail-glazing/'),
        'image' => $sector_img . 'sector-offices-water-end-barn-1400w.webp',
        'alt' => 'A converted barn office complex with replacement windows',
    ],
    [
        'title' => 'Healthcare and clinical',
        'copy' => 'Sequenced against the treatment list, with infection control deciding the route.',
        'url' => home_url('/healthcare-construction/'),
        'image' => '/wp-content/themes/fenster/assets/images/imported/dental-practice-glazing.jpg',
        'alt' => 'A dental practice frontage after its glazing was replaced',
    ],
];

/* Four facts, not four adjectives. The previous strip read "Live sites",
   "Drawings", "Systems", "Surveyed" against sentence fragments, which told an
   estimator nothing. These are things that are either true or not. */
$commercial_proof_points = [
    ['value' => 'Nationwide', 'label' => 'commercial coverage across England and Wales'],
    ['value' => 'In-house', 'label' => 'fitters, not subcontracted labour'],
    ['value' => 'Occupied', 'label' => 'buildings phased, sequenced and handed back daily'],
    ['value' => 'No minimum', 'label' => 'one failed unit or a whole facade'],
];

$commercial_process = [
    ['step' => '01', 'title' => 'Send what you have', 'copy' => 'Drawings, a window schedule, elevations or photographs. A postcode and a description is enough to start.'],
    ['step' => '02', 'title' => 'We read it properly', 'copy' => 'Building type, access, programme, performance targets and the gaps in the scope, before anyone talks about price.'],
    ['step' => '03', 'title' => 'Survey and specify', 'copy' => 'Measured on site rather than off the drawing, because a refurbished building rarely matches it.'],
    ['step' => '04', 'title' => 'Sequence the install', 'copy' => 'Manufacture, access, phasing and daily handback agreed against how the building has to keep working.'],
];

/* Real commercial studies, newest first, straight from the library. */
$commercial_studies = function_exists('fenster_case_studies_of_type')
    ? array_slice(fenster_case_studies_of_type('commercial'), 0, 3, true)
    : [];
$commercial_cards = [];
foreach ($commercial_studies as $short => $study) {
    if (function_exists('fenster_case_study_card')) {
        $commercial_cards[] = fenster_case_study_card((string) $short, $study);
    }
}
?>

<article class="fg-commercial-hub">
    <section class="fg-commercial-hub-hero">
        <?php if ($hero_media_src !== '') : ?>
            <img class="fg-commercial-hub-hero__image" src="<?php echo esc_url(fenster_generated_url($hero_media_src)); ?>" alt="<?php esc_attr_e('Commercial glazing installed on a refurbished elevation', 'fenster'); ?>" loading="eager">
        <?php endif; ?>
        <div class="fg-commercial-hub-hero__shade"></div>
        <div class="container fg-commercial-hub-hero__grid">
            <div class="fg-commercial-hub-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Commercial glazing contractors', 'fenster'); ?></p>
                <h1><?php esc_html_e('Commercial glazing, surveyed and installed by the people who fit it.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Windows, doors, curtain walling, louvres, AOV and replacement glazing for occupied and live commercial buildings. We survey from your drawings or from the building itself, and we sequence the work around how the building has to keep operating.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="#commercial-enquiry"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('See commercial projects', 'fenster'); ?></a>
                </div>
            </div>
            <aside class="fg-commercial-hub-brief" aria-label="<?php esc_attr_e('Commercial enquiry checklist', 'fenster'); ?>">
                <span><?php esc_html_e('The fastest route to a useful answer', 'fenster'); ?></span>
                <h2><?php esc_html_e('Four things that let us price it properly.', 'fenster'); ?></h2>
                <ul>
                    <li><?php esc_html_e('Building type, use and location', 'fenster'); ?></li>
                    <li><?php esc_html_e('Elevations, a schedule or photographs', 'fenster'); ?></li>
                    <li><?php esc_html_e('Performance targets, if they are set', 'fenster'); ?></li>
                    <li><?php esc_html_e('Programme, access and occupied hours', 'fenster'); ?></li>
                </ul>
                <a class="text-link" href="#commercial-enquiry"><?php esc_html_e('Open the project form', 'fenster'); ?></a>
            </aside>
        </div>
    </section>

    <section class="fg-commercial-hub-proof" aria-label="<?php esc_attr_e('Commercial capability', 'fenster'); ?>">
        <div class="container fg-commercial-hub-proof__grid">
            <?php foreach ($commercial_proof_points as $item) : ?>
                <article>
                    <strong><?php echo esc_html($item['value']); ?></strong>
                    <span><?php echo esc_html($item['label']); ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <?php /* Row one: products. Six cards, six commercial routes. */ ?>
    <section class="fg-commercial-products" id="commercial-products">
        <div class="container">
            <div class="fg-commercial-section-head">
                <p class="eyebrow"><?php esc_html_e('What we install', 'fenster'); ?></p>
                <h2><?php esc_html_e('Six commercial packages, each with its own specification.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Most projects take more than one of these. Send the whole scope and we will tell you which parts we would price together.', 'fenster'); ?></p>
            </div>
            <div class="fg-commercial-products__grid">
                <?php foreach ($commercial_products as $service) : ?>
                    <a class="fg-commercial-product-card" href="<?php echo esc_url($service['url']); ?>">
                        <img src="<?php echo esc_url(fenster_generated_url($service['image'])); ?>" alt="<?php echo esc_attr($service['alt']); ?>" loading="lazy">
                        <span>
                            <strong><?php echo esc_html($service['title']); ?></strong>
                            <small><?php echo esc_html($service['copy']); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* Row two: sectors. These six routes had no way in from this page
             until 2026-08-12. Adding a commercial route means adding it here. */ ?>
    <section class="fg-commercial-sectors-row">
        <div class="container">
            <div class="fg-commercial-section-head">
                <p class="eyebrow"><?php esc_html_e('Buildings we work in', 'fenster'); ?></p>
                <h2><?php esc_html_e('The constraint is rarely the glazing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('What decides a commercial job is usually the building around it: who is in it, when it can be closed, and what cannot stop. These pages are written around that rather than around the product.', 'fenster'); ?></p>
            </div>
            <div class="fg-commercial-products__grid">
                <?php foreach ($commercial_sectors as $sector) : ?>
                    <a class="fg-commercial-product-card" href="<?php echo esc_url($sector['url']); ?>">
                        <img src="<?php echo esc_url(fenster_generated_url($sector['image'])); ?>" alt="<?php echo esc_attr($sector['alt']); ?>" loading="lazy">
                        <span>
                            <strong><?php echo esc_html($sector['title']); ?></strong>
                            <small><?php echo esc_html($sector['copy']); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (! empty($commercial_cards)) : ?>
        <section class="fg-commercial-projects-preview">
            <div class="container">
                <div class="fg-commercial-section-head">
                    <p class="eyebrow"><?php esc_html_e('Project proof', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Recent commercial work, with the photographs from the job.', 'fenster'); ?></h2>
                </div>
                <div class="fg-cm-proof__grid">
                    <?php foreach ($commercial_cards as $card) :
                        $card_image = is_array($card['image'] ?? null) ? (string) ($card['image']['src'] ?? '') : '';
                        $card_alt = is_array($card['image'] ?? null) ? (string) ($card['image']['caption'] ?? '') : '';
                        ?>
                        <a class="fg-cm-proof__card" href="<?php echo esc_url((string) ($card['url'] ?? '#')); ?>">
                            <?php if ($card_image !== '') : ?>
                                <img src="<?php echo esc_url(fenster_generated_url($card_image)); ?>" alt="<?php echo esc_attr($card_alt !== '' ? $card_alt : (string) ($card['title'] ?? '')); ?>" loading="lazy">
                            <?php endif; ?>
                            <span class="fg-cm-proof__meta"><?php echo esc_html((string) ($card['location'] ?? 'Commercial project')); ?></span>
                            <strong><?php echo esc_html((string) ($card['title'] ?? '')); ?></strong>
                            <?php if (! empty($card['summary'])) : ?>
                                <small><?php echo esc_html((string) $card['summary']); ?></small>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="fg-commercial-projects-preview__action">
                    <a class="button" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('See all commercial projects', 'fenster'); ?></a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-commercial-flow">
        <div class="container fg-commercial-flow__grid">
            <div class="fg-commercial-flow__copy">
                <p class="eyebrow"><?php esc_html_e('How an enquiry moves', 'fenster'); ?></p>
                <h2><?php esc_html_e('From brief to installed, without the guesswork in the middle.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The aim is to read the scope properly at the start, while everything is still cheap to change. Most of what decides a glazing package is visible on day one.', 'fenster'); ?></p>
                <?php /* Constructionline Gold and SSIP are existing site-wide claims
                         with their own pages; this links them rather than making a
                         new claim. Whether they may be stated as tendering
                         credentials on the service pages themselves is still an
                         open question for the owner. */ ?>
                <div class="fg-contact-list">
                    <a href="<?php echo esc_url(home_url('/constructionline-gold/')); ?>"><?php esc_html_e('Constructionline Gold', 'fenster'); ?></a>
                    <a href="<?php echo esc_url(home_url('/ssip-health-and-safety/')); ?>"><?php esc_html_e('SSIP health and safety', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-commercial-flow__steps">
                <?php foreach ($commercial_process as $step) : ?>
                    <article>
                        <span><?php echo esc_html($step['step']); ?></span>
                        <div>
                            <h3><?php echo esc_html($step['title']); ?></h3>
                            <p><?php echo esc_html($step['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="commercial-enquiry" class="fg-commercial-enquiry">
        <div class="container fg-commercial-enquiry__grid">
            <div class="fg-commercial-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Commercial enquiry', 'fenster'); ?></p>
                <h2><?php esc_html_e('Send the drawings and we will come back with questions, not a brochure.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Attach elevations, a window schedule, site photographs or performance notes. Anything still open in the scope, we would rather settle now than price around.', 'fenster'); ?></p>
                <ul class="fg-commercial-enquiry__notes">
                    <li><?php esc_html_e('Drawings, schedules or elevations', 'fenster'); ?></li>
                    <li><?php esc_html_e('Access, programme and occupied hours', 'fenster'); ?></li>
                    <li><?php esc_html_e('Performance targets where they are set', 'fenster'); ?></li>
                </ul>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($brand_phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($brand_email); ?>"><?php echo esc_html($brand_email); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-commercial-form',
                'source' => 'Commercial glazing hub',
                'button_label' => 'Send commercial enquiry',
                'project_type' => 'Commercial glazing',
                'project_options' => [
                    'Commercial glazing',
                    'Commercial windows and doors',
                    'Curtain walling',
                    'Louvres or ventilation',
                    'AOV smoke ventilation',
                    'Automatic doors and entrances',
                    'Commercial replacement glazing',
                ],
                'show_company' => true,
                'lock_project_type' => true,
            ]);
            ?>
        </div>
    </section>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Commercial coverage', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Areas we cover for commercial work', 'fenster'); ?></h2>
                </div>
                <?php
                get_template_part('template-parts/components/link-cards', null, [
                    'links' => array_slice(array_values($related_links), 0, 24),
                ]);
                ?>
            </div>
        </section>
    <?php endif; ?>
</article>
