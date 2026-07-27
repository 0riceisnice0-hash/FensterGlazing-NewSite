<?php
/**
 * Long-form Liniar EnergyPlus casement window journey.
 *
 * The shared generated-page hero and specification strip render before this
 * partial. Keeping them outside this file preserves the approved hero exactly.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$quote_url = (string) ($args['quote_url'] ?? '');
$quote_label = (string) ($args['quote_label'] ?? 'uPVC Windows');
$asset_base = '/wp-content/themes/fenster/assets/images/products/casement/';

$opening_styles = [
    [
        'id' => 'side-hung',
        'number' => '01',
        'name' => 'Side-hung',
        'short' => 'The everyday all-rounder',
        'copy' => 'Hinged at the side and opening outwards. It gives a generous clear opening, so it works well where you want fast ventilation or a practical bedroom escape opening.',
        'best' => 'Bedrooms, living rooms and larger openings',
        'survey' => 'We check hinge side, furniture position, outside clearance and any escape requirement.',
    ],
    [
        'id' => 'top-hung',
        'number' => '02',
        'name' => 'Top-hung',
        'short' => 'Ventilation with more privacy',
        'copy' => 'Hinged along the top and opening outwards from the bottom. A smaller top-hung opener is useful above a fixed pane or where controlled ventilation matters more than a wide opening.',
        'best' => 'Bathrooms, kitchens, cloakrooms and fanlights',
        'survey' => 'We agree the opener height, handle reach and the glass privacy level before manufacture.',
    ],
    [
        'id' => 'fixed-pane',
        'number' => '03',
        'name' => 'Fixed pane',
        'short' => 'Maximum glass, no opening hardware',
        'copy' => 'A non-opening glazed section brings in light without hinges or handles. It can sit alone or beside opening sashes to keep a wide window visually balanced.',
        'best' => 'Picture windows, bays and mixed multi-light designs',
        'survey' => 'Ventilation, cleaning access and emergency escape must be provided elsewhere where required.',
    ],
    [
        'id' => 'mixed-layout',
        'number' => '04',
        'name' => 'Mixed layout',
        'short' => 'Openers and fixed lights together',
        'copy' => 'Casements can combine side-hung, top-hung and fixed lights in one frame. The result should be planned around the room, not copied blindly from the window being replaced.',
        'best' => 'Wide living-room windows and whole-home replacements',
        'survey' => 'We align sightlines, balance pane widths and confirm which sections really need to open.',
    ],
];

$room_plans = [
    ['room' => 'Bedroom', 'priority' => 'Escape and ventilation', 'copy' => 'A side-hung sash may provide the clear opening needed for escape. Final size and hardware are checked against the opening and applicable requirements.'],
    ['room' => 'Bathroom', 'priority' => 'Privacy and moisture', 'copy' => 'A top-hung opener with obscure glass can ventilate the room while reducing direct views from outside.'],
    ['room' => 'Kitchen', 'priority' => 'Reach and clearance', 'copy' => 'Handle height, taps, worktops and the outward swing all matter. We avoid layouts that look right on paper but are awkward to use.'],
    ['room' => 'Living room', 'priority' => 'Light and balanced sightlines', 'copy' => 'Larger fixed panes can hold the view, with practical opening lights positioned where they will actually be used.'],
    ['room' => 'Landing', 'priority' => 'Safe operation', 'copy' => 'We consider stair position, handle reach, restrictors and how the outside glass will be accessed for cleaning.'],
    ['room' => 'Street-facing room', 'priority' => 'Noise, privacy and security', 'copy' => 'Glass build-up, laminated options, trickle ventilation and locking should be specified together rather than as isolated upgrades.'],
];

$glass_options = [
    ['title' => 'Energy-efficient glazing', 'copy' => 'The sealed unit and warm-edge spacer are selected with the frame to reach the agreed whole-window performance. The best glass choice depends on pane size and orientation.'],
    ['title' => 'Obscure glass', 'copy' => 'Patterned privacy glass suits bathrooms, cloakrooms and overlooked elevations. Privacy levels and which face carries the pattern are agreed before order.'],
    ['title' => 'Acoustic glass', 'copy' => 'For traffic or neighbourhood noise, acoustic performance depends on the full glass build-up, frame, seals and ventilation path. Triple glazing alone is not automatically the quietest answer.'],
    ['title' => 'Safety and security glass', 'copy' => 'Toughened or laminated glass can be specified where impact safety, low-level glazing or added resistance is required. Survey determines the correct locations.'],
];

$colour_options = [
    ['name' => 'White', 'class' => 'white'],
    ['name' => 'Cream', 'class' => 'cream'],
    ['name' => 'Chartwell Green', 'class' => 'chartwell'],
    ['name' => 'Agate Grey', 'class' => 'agate'],
    ['name' => 'Anthracite Grey', 'class' => 'anthracite'],
    ['name' => 'Black', 'class' => 'black'],
    ['name' => 'Golden Oak', 'class' => 'golden-oak'],
    ['name' => 'Rosewood', 'class' => 'rosewood'],
];

$survey_checks = [
    ['number' => '01', 'title' => 'Opening layout', 'copy' => 'Which panes open, where they are hinged and whether the sightlines line up across the elevation.'],
    ['number' => '02', 'title' => 'Glass specification', 'copy' => 'Thermal, safety, security, privacy, acoustic and solar-control needs are checked room by room.'],
    ['number' => '03', 'title' => 'Ventilation', 'copy' => 'Background ventilation and trickle-vent requirements are considered alongside how you actually use each room.'],
    ['number' => '04', 'title' => 'Colour and detail', 'copy' => 'Inside and outside finish, cills, Georgian bars, mock horns, handles and hardware are recorded before sign-off.'],
    ['number' => '05', 'title' => 'Structure and access', 'copy' => 'Reveal depth, lintels, render, tiles, alarms, blinds, access and safe installation space all affect the plan.'],
    ['number' => '06', 'title' => 'Final performance', 'copy' => 'The quoted U-value, security evidence and guarantee apply to the finished configuration, not just the profile name.'],
];

$faqs = [
    [
        'question' => 'What is a casement window?',
        'answer' => 'A casement is an outward-opening window with sashes hinged at the side or top. Opening sashes and fixed panes can be combined in one made-to-measure frame.',
    ],
    [
        'question' => 'Which Liniar system does Fenster use for these casement windows?',
        'answer' => 'This page covers the 70mm Liniar EnergyPlus uPVC system. It is a six-chamber platform designed for UK replacement and new-build applications. The final glass, reinforcement and hardware are confirmed for your project.',
    ],
    [
        'question' => 'What U-value can a Liniar EnergyPlus casement achieve?',
        'answer' => 'Fenster lists a 0.95 W/m²K specification for this product. Liniar says suitable EnergyPlus configurations can achieve values as low as 0.8 W/m²K. The actual whole-window value depends on size, layout, glass and reinforcement, so it is confirmed against the final specification.',
    ],
    [
        'question' => 'Are casement windows secure?',
        'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options where required. Certification applies to the tested complete window configuration, so it should not be assumed from the profile alone.',
    ],
    [
        'question' => 'Can I have triple glazing?',
        'answer' => 'The suitable glazing build-up depends on the selected frame, sash size and required performance. We will compare the practical benefit, weight and cost rather than treating triple glazing as an automatic upgrade.',
    ],
    [
        'question' => 'Can casement windows help reduce outside noise?',
        'answer' => 'Yes, when the complete specification is designed for it. Acoustic glass, pane thicknesses, frame seals and the ventilation route all influence the result. We can discuss the noise source during survey.',
    ],
    [
        'question' => 'How many colours are available?',
        'answer' => 'Fenster currently presents 16 colour choices for this range. The Liniar foil catalogue is wider, but availability, substrate, lead time and cost depend on the fabricator and exact profile, so uncommon finishes need confirmation.',
    ],
    [
        'question' => 'What is the difference between EnergyPlus and Zero|90?',
        'answer' => 'EnergyPlus is the 70mm six-chamber system covered on this page. Zero|90 is a separate 90mm Passivhaus-certified system with different glass capacity and test figures. Zero|90 performance should not be attributed to a standard EnergyPlus quote.',
    ],
    [
        'question' => 'Can you match the layout of my existing windows?',
        'answer' => 'Usually, but matching it exactly is not always the best answer. Survey checks escape, ventilation, handle reach, outside clearance and sightline balance before the final drawing is approved.',
    ],
    [
        'question' => 'Are Liniar uPVC frames recyclable?',
        'answer' => 'Liniar describes its uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire; independent fabricators manufacture the finished windows.',
    ],
];

$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ],
        $faqs
    ),
];
?>

<div class="fg-cw">
    <nav class="fg-cw-nav" aria-label="<?php esc_attr_e('Casement windows page sections', 'fenster'); ?>">
        <div class="container fg-cw-nav__inner">
            <span><?php esc_html_e('Explore casements', 'fenster'); ?></span>
            <div>
                <a href="#casement-opening-styles"><?php esc_html_e('Opening styles', 'fenster'); ?></a>
                <a href="#casement-performance"><?php esc_html_e('Performance', 'fenster'); ?></a>
                <a href="#casement-glass"><?php esc_html_e('Glass', 'fenster'); ?></a>
                <a href="#casement-colours"><?php esc_html_e('Colours', 'fenster'); ?></a>
                <a href="#casement-survey"><?php esc_html_e('Survey', 'fenster'); ?></a>
                <a href="#fenster-product-quote"><?php esc_html_e('Price yours', 'fenster'); ?></a>
            </div>
        </div>
    </nav>

    <section class="fg-cw-intro" aria-labelledby="fg-cw-intro-title">
        <div class="container fg-cw-intro__grid">
            <div class="fg-cw-intro__copy">
                <p class="eyebrow"><?php esc_html_e('The practical window, properly specified', 'fenster'); ?></p>
                <h2 id="fg-cw-intro-title"><?php esc_html_e('One familiar design. Far more decisions than it first appears.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('Casement windows suit almost every kind of home because the frame can mix opening sashes and fixed panes without making the elevation fussy. The important part is choosing where each section opens, then matching the glass, locks, ventilation and finish to the room.', 'fenster'); ?></p>
                <p><?php esc_html_e('Fenster specifies the 70mm Liniar EnergyPlus platform for this page. It is made to measure by an independent fabricator, then surveyed and installed around the details of your property.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="#casement-opening-styles"><?php esc_html_e('Compare opening styles', 'fenster'); ?></a>
                    <a class="button button--light" href="#casement-survey"><?php esc_html_e('See what we survey', 'fenster'); ?></a>
                </div>
            </div>
            <figure class="fg-cw-intro__media">
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-detail-1600w.webp')); ?>" alt="<?php esc_attr_e('Open white Liniar casement sash showing the handle and frame detail', 'fenster'); ?>" loading="eager" width="1600" height="1068">
                <figcaption>
                    <strong><?php esc_html_e('Outward opening', 'fenster'); ?></strong>
                    <span><?php esc_html_e('The handle, hinge side and outside clearance are all agreed at survey.', 'fenster'); ?></span>
                </figcaption>
            </figure>
        </div>
    </section>

    <section id="casement-opening-styles" class="fg-cw-openings" data-fg-casement-explorer aria-labelledby="fg-cw-openings-title">
        <div class="container">
            <header class="fg-cw-heading fg-cw-heading--wide">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Opening styles', 'fenster'); ?></p>
                    <h2 id="fg-cw-openings-title"><?php esc_html_e('Start with how the room needs the window to work.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Select an option to see where it works best and what Fenster checks before it is ordered.', 'fenster'); ?></p>
            </header>

            <div class="fg-cw-openings__layout">
                <div class="fg-cw-openings__tabs" role="tablist" aria-label="<?php esc_attr_e('Casement opening styles', 'fenster'); ?>">
                    <?php foreach ($opening_styles as $index => $style) : ?>
                        <button
                            type="button"
                            role="tab"
                            id="fg-cw-tab-<?php echo esc_attr($style['id']); ?>"
                            aria-controls="fg-cw-panel-<?php echo esc_attr($style['id']); ?>"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                            class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                            data-fg-casement-tab
                        >
                            <small><?php echo esc_html($style['number']); ?></small>
                            <span>
                                <strong><?php echo esc_html($style['name']); ?></strong>
                                <em><?php echo esc_html($style['short']); ?></em>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-cw-openings__stage">
                    <?php foreach ($opening_styles as $index => $style) : ?>
                        <article
                            id="fg-cw-panel-<?php echo esc_attr($style['id']); ?>"
                            role="tabpanel"
                            aria-labelledby="fg-cw-tab-<?php echo esc_attr($style['id']); ?>"
                            class="fg-cw-opening-panel <?php echo $index === 0 ? 'is-active' : ''; ?>"
                            data-fg-casement-panel
                            <?php echo $index === 0 ? '' : 'hidden'; ?>
                        >
                            <div class="fg-cw-window-diagram fg-cw-window-diagram--<?php echo esc_attr($style['id']); ?>" aria-hidden="true">
                                <span class="fg-cw-window-diagram__frame">
                                    <i></i><i></i><i></i>
                                </span>
                            </div>
                            <div class="fg-cw-opening-panel__copy">
                                <p class="eyebrow"><?php echo esc_html($style['number'] . ' / ' . $style['name']); ?></p>
                                <h3><?php echo esc_html($style['short']); ?></h3>
                                <p><?php echo esc_html($style['copy']); ?></p>
                                <dl>
                                    <div>
                                        <dt><?php esc_html_e('Often best for', 'fenster'); ?></dt>
                                        <dd><?php echo esc_html($style['best']); ?></dd>
                                    </div>
                                    <div>
                                        <dt><?php esc_html_e('At survey', 'fenster'); ?></dt>
                                        <dd><?php echo esc_html($style['survey']); ?></dd>
                                    </div>
                                </dl>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="casement-performance" class="fg-cw-system" aria-labelledby="fg-cw-system-title">
        <div class="container fg-cw-system__grid">
            <div class="fg-cw-system__visual">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-energyplus-thermal-600w.webp')); ?>" alt="<?php esc_attr_e('Thermal illustration of the six-chamber Liniar EnergyPlus casement profile', 'fenster'); ?>" loading="lazy" width="600" height="400">
                </figure>
                <div class="fg-cw-system__note">
                    <span><?php esc_html_e('Profile illustration', 'fenster'); ?></span>
                    <strong><?php esc_html_e('EnergyPlus, not Zero|90', 'fenster'); ?></strong>
                </div>
            </div>
            <div class="fg-cw-system__copy">
                <p class="eyebrow"><?php esc_html_e('Inside the frame', 'fenster'); ?></p>
                <h2 id="fg-cw-system-title"><?php esc_html_e('A 70mm, six-chamber system designed to slow heat transfer.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('EnergyPlus uses symmetrical internal chambers to create insulating pockets through the frame. Liniar says the chamber webs and spacing were developed with thermal-modelling software, while the co-extruded bubble gasket forms the continuous weather seal.', 'fenster'); ?></p>
                <div class="fg-cw-system__facts">
                    <article>
                        <strong>70mm</strong>
                        <span><?php esc_html_e('frame depth', 'fenster'); ?></span>
                    </article>
                    <article>
                        <strong>6</strong>
                        <span><?php esc_html_e('profile chambers', 'fenster'); ?></span>
                    </article>
                    <article>
                        <strong>0.8</strong>
                        <span><?php esc_html_e('W/m²K manufacturer best-case claim', 'fenster'); ?></span>
                    </article>
                    <article>
                        <strong>0.95</strong>
                        <span><?php esc_html_e('W/m²K Fenster listed specification', 'fenster'); ?></span>
                    </article>
                </div>
                <p class="fg-cw-caveat"><?php esc_html_e('U-values are for the complete window, not the empty frame. Size, opening layout, reinforcement and sealed-unit build-up affect the result, so the final figure belongs on the agreed specification.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <section class="fg-cw-weather" aria-labelledby="fg-cw-weather-title">
        <div class="container">
            <header class="fg-cw-heading">
                <p class="eyebrow"><?php esc_html_e('Comfort is a whole-window job', 'fenster'); ?></p>
                <h2 id="fg-cw-weather-title"><?php esc_html_e('Four layers have to work together.', 'fenster'); ?></h2>
            </header>
            <div class="fg-cw-four">
                <article>
                    <span>01</span>
                    <h3><?php esc_html_e('Frame chambers', 'fenster'); ?></h3>
                    <p><?php esc_html_e('The multi-chamber profile reduces the direct path for heat through the uPVC frame.', 'fenster'); ?></p>
                </article>
                <article>
                    <span>02</span>
                    <h3><?php esc_html_e('Sealed glass unit', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Glass panes, coatings, gas fill and spacer-bar choice determine much of the overall thermal performance.', 'fenster'); ?></p>
                </article>
                <article>
                    <span>03</span>
                    <h3><?php esc_html_e('Bubble gasket', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Liniar co-extrudes the weather gasket into the profile, helping it stay correctly positioned around the sash.', 'fenster'); ?></p>
                </article>
                <article>
                    <span>04</span>
                    <h3><?php esc_html_e('Installation', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Accurate survey, fixing, sealing and finishing are what connect the tested product to the actual wall opening.', 'fenster'); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="fg-cw-rooms" aria-labelledby="fg-cw-rooms-title">
        <div class="container">
            <header class="fg-cw-heading fg-cw-heading--wide">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Plan room by room', 'fenster'); ?></p>
                    <h2 id="fg-cw-rooms-title"><?php esc_html_e('The same house rarely needs the same window everywhere.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Whole-home replacements look coherent when the outer proportions match, while the opening and glass choices respond to each room.', 'fenster'); ?></p>
            </header>
            <div class="fg-cw-rooms__grid">
                <?php foreach ($room_plans as $room) : ?>
                    <article>
                        <p><?php echo esc_html($room['room']); ?></p>
                        <h3><?php echo esc_html($room['priority']); ?></h3>
                        <span><?php echo esc_html($room['copy']); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="casement-glass" class="fg-cw-glass" aria-labelledby="fg-cw-glass-title">
        <div class="container fg-cw-glass__layout">
            <div class="fg-cw-glass__intro">
                <p class="eyebrow"><?php esc_html_e('Glass choices', 'fenster'); ?></p>
                <h2 id="fg-cw-glass-title"><?php esc_html_e('Choose the glass for the problem you are solving.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Warmth, privacy, sound and security do not always point to the same sealed unit. We separate those needs before pricing so an upgrade has a clear purpose.', 'fenster'); ?></p>
                <a class="fg-cw-text-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Explore obscure-glass patterns', 'fenster'); ?><span aria-hidden="true">→</span></a>
            </div>
            <div class="fg-cw-glass__cards">
                <?php foreach ($glass_options as $index => $option) : ?>
                    <article>
                        <small><?php echo esc_html(sprintf('%02d', $index + 1)); ?></small>
                        <div>
                            <h3><?php echo esc_html($option['title']); ?></h3>
                            <p><?php echo esc_html($option['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-cw-security" aria-labelledby="fg-cw-security-title">
        <div class="container fg-cw-security__grid">
            <div class="fg-cw-security__copy">
                <p class="eyebrow"><?php esc_html_e('Security by configuration', 'fenster'); ?></p>
                <h2 id="fg-cw-security-title"><?php esc_html_e('Locks, frame, glass and installation form one tested window.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('Liniar’s wider window range supports multi-point locking, reinforced frames and PAS 24 or Secured by Design options. Those labels apply only when the complete window matches the tested specification.', 'fenster'); ?></p>
                <ul class="fg-cw-check-list">
                    <li><?php esc_html_e('Multi-point locking positioned around the opening sash', 'fenster'); ?></li>
                    <li><?php esc_html_e('Reinforcement selected for size, colour and exposure', 'fenster'); ?></li>
                    <li><?php esc_html_e('Laminated or safety glass where the design requires it', 'fenster'); ?></li>
                    <li><?php esc_html_e('PAS 24 and Secured by Design options when specified', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-security__media">
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-handle-detail-1400w.webp')); ?>" alt="<?php esc_attr_e('Close view of a casement window handle and locking detail', 'fenster'); ?>" loading="lazy" width="1400" height="933">
            </figure>
        </div>
    </section>

    <section class="fg-cw-style" aria-labelledby="fg-cw-style-title">
        <div class="container">
            <header class="fg-cw-heading fg-cw-heading--wide">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Make the proportions intentional', 'fenster'); ?></p>
                    <h2 id="fg-cw-style-title"><?php esc_html_e('A traditional opening style can still look crisp and current.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Frame colour matters, but pane proportions, transom height, equal sightlines and the amount of opening hardware make just as much visual difference.', 'fenster'); ?></p>
            </header>
            <div class="fg-cw-style__gallery">
                <figure class="fg-cw-style__wide">
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-house-rear-1600w.webp')); ?>" alt="<?php esc_attr_e('House elevation with dark grey casement windows', 'fenster'); ?>" loading="lazy" width="1600" height="900">
                    <figcaption><?php esc_html_e('A consistent outer colour can tie together different opening layouts across one elevation.', 'fenster'); ?></figcaption>
                </figure>
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-mockhorn-detail-600w.webp')); ?>" alt="<?php esc_attr_e('White casement windows with optional mock-horn detailing', 'fenster'); ?>" loading="lazy" width="600" height="600">
                    <figcaption><?php esc_html_e('Optional mock horns can add a sash-like cue. They are a style choice, not a standard feature.', 'fenster'); ?></figcaption>
                </figure>
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-sill-interior-1200w.webp')); ?>" alt="<?php esc_attr_e('Interior view through a white casement window', 'fenster'); ?>" loading="lazy" width="1200" height="800">
                    <figcaption><?php esc_html_e('Inside colour, handle finish and cill detail affect the room long after the outside has been forgotten.', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <section id="casement-colours" class="fg-cw-colours" aria-labelledby="fg-cw-colours-title">
        <div class="container fg-cw-colours__grid">
            <div class="fg-cw-colours__copy">
                <p class="eyebrow"><?php esc_html_e('Colour and foil', 'fenster'); ?></p>
                <h2 id="fg-cw-colours-title"><?php esc_html_e('Start with the eight finishes people ask to compare most often.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('Fenster currently lists 16 colour choices for this casement range. These swatches show the main colour families; the exact grain, inside/outside combination, substrate and lead time are confirmed from a physical sample.', 'fenster'); ?></p>
                <p><?php esc_html_e('Liniar’s wider foil catalogue contains more finishes, but an entry in the manufacturer catalogue does not mean every profile is stocked by every fabricator. Uncommon colours may change price or lead time.', 'fenster'); ?></p>
                <a class="button button--light" href="<?php echo esc_url(home_url('/upvc-colours/')); ?>"><?php esc_html_e('See the uPVC colour guide', 'fenster'); ?></a>
            </div>
            <div class="fg-cw-colours__swatches" aria-label="<?php esc_attr_e('Representative Liniar uPVC colour families', 'fenster'); ?>">
                <?php foreach ($colour_options as $colour) : ?>
                    <div class="fg-cw-swatch fg-cw-swatch--<?php echo esc_attr($colour['class']); ?>">
                        <span aria-hidden="true"></span>
                        <strong><?php echo esc_html($colour['name']); ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-cw-hardware" aria-labelledby="fg-cw-hardware-title">
        <div class="container fg-cw-hardware__grid">
            <figure class="fg-cw-hardware__media">
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-brick-1400w.webp')); ?>" alt="<?php esc_attr_e('Open casement window set in a brick elevation', 'fenster'); ?>" loading="lazy" width="1400" height="933">
            </figure>
            <div class="fg-cw-hardware__copy">
                <p class="eyebrow"><?php esc_html_e('Handles and hardware', 'fenster'); ?></p>
                <h2 id="fg-cw-hardware-title"><?php esc_html_e('The parts you touch every day deserve a proper decision.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('Fenster offers S2 Signature window handles with finish choices to coordinate with the frame and room. We also agree restrictors, hinge type and locking around how each window will be used.', 'fenster'); ?></p>
                <dl class="fg-cw-mini-spec">
                    <div><dt><?php esc_html_e('Handle', 'fenster'); ?></dt><dd><?php esc_html_e('S2 Signature option', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Locking', 'fenster'); ?></dt><dd><?php esc_html_e('Multi-point', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Safety', 'fenster'); ?></dt><dd><?php esc_html_e('Restrictors where useful', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Finish', 'fenster'); ?></dt><dd><?php esc_html_e('Matched to the scheme', 'fenster'); ?></dd></div>
                </dl>
                <a class="fg-cw-text-link" href="<?php echo esc_url(home_url('/window-handles/')); ?>"><?php esc_html_e('Compare window-handle finishes', 'fenster'); ?><span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>

    <section class="fg-cw-clarity" aria-labelledby="fg-cw-clarity-title">
        <div class="container">
            <header class="fg-cw-heading">
                <p class="eyebrow"><?php esc_html_e('Product clarity', 'fenster'); ?></p>
                <h2 id="fg-cw-clarity-title"><?php esc_html_e('EnergyPlus and Zero|90 are not two names for the same frame.', 'fenster'); ?></h2>
            </header>
            <div class="fg-cw-compare">
                <article class="is-current">
                    <span><?php esc_html_e('This Fenster page', 'fenster'); ?></span>
                    <h3><?php esc_html_e('70mm EnergyPlus', 'fenster'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Six-chamber uPVC profile', 'fenster'); ?></li>
                        <li><?php esc_html_e('Made for replacement and new-build use', 'fenster'); ?></li>
                        <li><?php esc_html_e('Manufacturer claim as low as 0.8 W/m²K in a suitable configuration', 'fenster'); ?></li>
                        <li><?php esc_html_e('The system used for the quote journey below', 'fenster'); ?></li>
                    </ul>
                </article>
                <article>
                    <span><?php esc_html_e('A separate Liniar system', 'fenster'); ?></span>
                    <h3><?php esc_html_e('90mm Zero|90', 'fenster'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Passivhaus-certified 90mm platform', 'fenster'); ?></li>
                        <li><?php esc_html_e('Different glass capacity and installation details', 'fenster'); ?></li>
                        <li><?php esc_html_e('Separate published performance figures', 'fenster'); ?></li>
                        <li><?php esc_html_e('Not included simply because a quote says “Liniar”', 'fenster'); ?></li>
                    </ul>
                </article>
            </div>
            <p class="fg-cw-clarity__note"><?php esc_html_e('Why say this? Because product-level figures only mean something when they match the frame, glass and hardware that will actually be installed.', 'fenster'); ?></p>
        </div>
    </section>

    <section class="fg-cw-sustainability" aria-labelledby="fg-cw-sustainability-title">
        <div class="container fg-cw-sustainability__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Designed and extruded in Derbyshire', 'fenster'); ?></p>
                <h2 id="fg-cw-sustainability-title"><?php esc_html_e('A British profile system with end-of-life recycling in mind.', 'fenster'); ?></h2>
            </div>
            <div class="fg-cw-sustainability__copy">
                <p class="fg-cw-lead"><?php esc_html_e('Liniar describes its casement profiles as lead-free and the uPVC elements as recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire.', 'fenster'); ?></p>
                <p><?php esc_html_e('Liniar supplies profile systems to independent fabricators, who manufacture the finished window. That is why the final guarantee, hardware, colour availability and performance evidence must follow the actual Fenster order rather than a generic manufacturer headline.', 'fenster'); ?></p>
            </div>
            <div class="fg-cw-sustainability__facts">
                <span><strong><?php esc_html_e('Lead-free', 'fenster'); ?></strong><?php esc_html_e('profile formulation', 'fenster'); ?></span>
                <span><strong><?php esc_html_e('Recyclable', 'fenster'); ?></strong><?php esc_html_e('uPVC at end of life', 'fenster'); ?></span>
                <span><strong><?php esc_html_e('Derbyshire', 'fenster'); ?></strong><?php esc_html_e('design, extrusion and testing', 'fenster'); ?></span>
            </div>
        </div>
    </section>

    <section id="casement-survey" class="fg-cw-survey" aria-labelledby="fg-cw-survey-title">
        <div class="container">
            <header class="fg-cw-heading fg-cw-heading--wide">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Before anything is made', 'fenster'); ?></p>
                    <h2 id="fg-cw-survey-title"><?php esc_html_e('The survey turns a window preference into an orderable specification.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('These are the six decisions we want resolved before a manufacturing drawing is approved.', 'fenster'); ?></p>
            </header>
            <div class="fg-cw-survey__content">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-installation-900w.webp')); ?>" alt="<?php esc_attr_e('Installer checking a Liniar casement window frame in a brick opening', 'fenster'); ?>" loading="lazy" width="900" height="600">
                    <figcaption><?php esc_html_e('Survey, manufacture and installation are separate stages. Each one should confirm the detail it controls.', 'fenster'); ?></figcaption>
                </figure>
                <ol>
                    <?php foreach ($survey_checks as $check) : ?>
                        <li>
                            <span><?php echo esc_html($check['number']); ?></span>
                            <div>
                                <h3><?php echo esc_html($check['title']); ?></h3>
                                <p><?php echo esc_html($check['copy']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </section>

    <section class="fg-cw-process" aria-labelledby="fg-cw-process-title">
        <div class="container">
            <header class="fg-cw-heading">
                <p class="eyebrow"><?php esc_html_e('From first idea to fitted window', 'fenster'); ?></p>
                <h2 id="fg-cw-process-title"><?php esc_html_e('A simple four-stage route.', 'fenster'); ?></h2>
            </header>
            <ol class="fg-cw-process__steps">
                <li><span>01</span><h3><?php esc_html_e('Design and budget', 'fenster'); ?></h3><p><?php esc_html_e('Choose a starting layout and get an indicative price online or with the team.', 'fenster'); ?></p></li>
                <li><span>02</span><h3><?php esc_html_e('Technical survey', 'fenster'); ?></h3><p><?php esc_html_e('We measure the openings and resolve glass, ventilation, access, finish and hardware.', 'fenster'); ?></p></li>
                <li><span>03</span><h3><?php esc_html_e('Manufacture', 'fenster'); ?></h3><p><?php esc_html_e('The approved specification is made to measure by the selected Liniar fabricator.', 'fenster'); ?></p></li>
                <li><span>04</span><h3><?php esc_html_e('Install and handover', 'fenster'); ?></h3><p><?php esc_html_e('Frames are fitted, sealed, adjusted and demonstrated before the project is signed off.', 'fenster'); ?></p></li>
            </ol>
        </div>
    </section>

    <section class="fg-cw-related" aria-labelledby="fg-cw-related-title">
        <div class="container">
            <header class="fg-cw-heading">
                <p class="eyebrow"><?php esc_html_e('If standard casements are not quite right', 'fenster'); ?></p>
                <h2 id="fg-cw-related-title"><?php esc_html_e('Compare the adjacent window styles before committing.', 'fenster'); ?></h2>
            </header>
            <div class="fg-cw-related__grid">
                <a href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>">
                    <span><?php esc_html_e('For a flatter outside face', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Flush casement windows', 'fenster'); ?></h3>
                    <p><?php esc_html_e('A more understated external line for contemporary or heritage-led elevations.', 'fenster'); ?></p>
                    <strong><?php esc_html_e('Explore flush casements', 'fenster'); ?> →</strong>
                </a>
                <a href="<?php echo esc_url(home_url('/french-casement-windows/')); ?>">
                    <span><?php esc_html_e('For a wide clear opening', 'fenster'); ?></span>
                    <h3><?php esc_html_e('French casement windows', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Two opening sashes can meet without a fixed central mullion in suitable designs.', 'fenster'); ?></p>
                    <strong><?php esc_html_e('Explore French casements', 'fenster'); ?> →</strong>
                </a>
                <a href="<?php echo esc_url(home_url('/tilt-turn-windows/')); ?>">
                    <span><?php esc_html_e('For inward opening and cleaning', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Tilt and turn windows', 'fenster'); ?></h3>
                    <p><?php esc_html_e('A different operating style with secure tilt ventilation and an inward-opening turn mode.', 'fenster'); ?></p>
                    <strong><?php esc_html_e('Explore tilt and turn', 'fenster'); ?> →</strong>
                </a>
            </div>
        </div>
    </section>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed fg-cw-quote" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Build a starting design and see an indicative price.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Choose the window style, sizes, colours and options in the Fenster quote tool. It is a useful first pass; survey confirms the exact layout, glass, hardware and final price before manufacture.', 'fenster'); ?></p>
                    <a class="button fg-cw-quote__mobile-action" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Design and price my windows', 'fenster'); ?></a>
                </div>
                <article class="fg-product-quote-embed__card" data-quote-card>
                    <div class="fg-product-quote-embed__bar">
                        <h3><?php esc_html_e('uPVC window quote tool', 'fenster'); ?></h3>
                        <div class="fg-product-quote-embed__actions">
                            <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                            <a class="button" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                            <a class="button fg-product-quote-embed__mobile-open" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                        </div>
                    </div>
                    <div class="fg-product-quote-embed__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="near">
                        <div class="fg-quote-frame-placeholder fg-product-quote-embed__placeholder">
                            <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                            <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                        </div>
                        <iframe
                            data-quote-iframe-src="<?php echo esc_url($quote_url); ?>"
                            title="<?php echo esc_attr($quote_label . ' instant quote tool'); ?>"
                            loading="lazy"
                            allow="fullscreen"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </article>
            </div>
        </section>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--product fg-cw-reviews',
        'eyebrow' => 'Customer proof',
        'title' => 'Local installation, supported by recognised product systems.',
        'copy' => 'Read what customers say about Fenster, then use the specification above to decide what your own windows need.',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>

    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <section class="fg-product-faq fg-cw-faq" aria-labelledby="fg-cw-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cw-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('These answers refer to the 70mm Liniar EnergyPlus casement system described on this page.', 'fenster'); ?></p>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="fenster-enquiry" class="fg-enquiry fg-cw-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Start your casement project', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what you want the new windows to improve.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Share the number of windows, property type and the main reason for replacing them. We can then guide you through layout, colour, glass, survey and pricing.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', (string) ($brand['phone'] ?? '01908 429200'))); ?>"><?php echo esc_html((string) ($brand['phone'] ?? '01908 429200')); ?></a>
                    <a href="mailto:<?php echo esc_attr((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?>"><?php echo esc_html((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => 'Casement Windows',
                'button_label' => 'Send my casement details',
                'project_type' => 'Casement windows',
                'lock_project_type' => true,
                'compact' => true,
            ]);
            ?>
        </div>
    </section>
</div>
