<?php
/**
 * Casement Windows V3: image-led 70mm Liniar EnergyPlus product journey.
 *
 * The approved shared hero and specification strip render before this partial.
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
        'label' => 'Wide opening',
        'image' => 'casement-open-brick-1400w.webp',
        'width' => 1400,
        'height' => 933,
        'alt' => 'White side-hung casement window open against a brick elevation',
        'copy' => 'Hinged at the side and opening outwards. This is the everyday all-rounder: useful where you want a generous opening, fast ventilation or a practical bedroom escape route.',
        'best' => 'Bedrooms, living rooms and larger openings',
        'check' => 'Hinge side, furniture position, outside clearance and any escape requirement.',
    ],
    [
        'id' => 'top-hung',
        'number' => '02',
        'name' => 'Top-hung',
        'label' => 'Controlled ventilation',
        'image' => 'casement-open-detail-1600w.webp',
        'width' => 1600,
        'height' => 1068,
        'alt' => 'White top-hung casement window open from the bottom',
        'copy' => 'Hinged along the top and opening outwards from the bottom. It is a useful way to add ventilation above a fixed pane or in a room where a wide opening is not the priority.',
        'best' => 'Bathrooms, kitchens, cloakrooms and fanlights',
        'check' => 'Opener height, handle reach, privacy glass and the safe opening distance.',
    ],
    [
        'id' => 'fixed-pane',
        'number' => '03',
        'name' => 'Fixed pane',
        'label' => 'More glass',
        'image' => 'casement-sill-interior-1200w.webp',
        'width' => 1200,
        'height' => 800,
        'alt' => 'Clean interior cill and frame detail on a white casement window',
        'copy' => 'A non-opening glazed section brings in light without hinges or an operating handle. Used beside opening sashes, it can simplify a wide frame and give the elevation calmer proportions.',
        'best' => 'Picture windows, bays and wide multi-light designs',
        'check' => 'Ventilation, cleaning access and emergency escape must be provided elsewhere where needed.',
    ],
    [
        'id' => 'mixed-layout',
        'number' => '04',
        'name' => 'Mixed layout',
        'label' => 'One frame, several jobs',
        'image' => 'casement-house-rear-1600w.webp',
        'width' => 1600,
        'height' => 900,
        'alt' => 'House elevation using different dark casement window layouts',
        'copy' => 'Side-hung, top-hung and fixed lights can be combined in one frame. The right answer balances how the room works with sightlines that still look deliberate from outside.',
        'best' => 'Whole-home replacements and wide living-room windows',
        'check' => 'Pane widths, transom heights, which sections genuinely need to open and how they align across the house.',
    ],
];

$room_rows = [
    ['room' => 'Bedroom', 'need' => 'Escape and night ventilation', 'answer' => 'A suitable side-hung sash, with the clear opening and handle position checked at survey.'],
    ['room' => 'Bathroom', 'need' => 'Privacy and moisture', 'answer' => 'A top-hung opener with the agreed obscure-glass pattern and privacy level.'],
    ['room' => 'Kitchen', 'need' => 'Reach and clearance', 'answer' => 'A layout planned around taps, worktops, handles and the outward opening arc.'],
    ['room' => 'Living room', 'need' => 'Light and balanced proportions', 'answer' => 'Larger fixed panes for the view, with practical opening lights where they will be used.'],
    ['room' => 'Landing', 'need' => 'Safe operation', 'answer' => 'Handle reach, stair position, restrictors and external cleaning access considered together.'],
    ['room' => 'Street-facing room', 'need' => 'Noise, privacy and security', 'answer' => 'Glass build-up, ventilation route, locks and frame specification treated as one problem.'],
];

$glass_rows = [
    ['title' => 'Energy-efficient glazing', 'copy' => 'The panes, coatings, gas fill and warm-edge spacer are selected with the frame to reach the agreed whole-window value.'],
    ['title' => 'Obscure glass', 'copy' => 'Patterned privacy glass for bathrooms and overlooked rooms, with the pattern and privacy level agreed from a physical sample.'],
    ['title' => 'Acoustic glass', 'copy' => 'Pane thicknesses, laminate, seals and ventilation route are considered together. Triple glazing alone is not automatically the quietest answer.'],
    ['title' => 'Safety and security glass', 'copy' => 'Toughened or laminated glass can be specified for impact safety, low-level glazing or added resistance where the design requires it.'],
];

$colours = [
    ['name' => 'White', 'class' => 'white'],
    ['name' => 'Cream', 'class' => 'cream'],
    ['name' => 'Chartwell Green', 'class' => 'chartwell'],
    ['name' => 'Agate Grey', 'class' => 'agate'],
    ['name' => 'Anthracite Grey', 'class' => 'anthracite'],
    ['name' => 'Black', 'class' => 'black'],
    ['name' => 'Golden Oak', 'class' => 'golden-oak'],
    ['name' => 'Rosewood', 'class' => 'rosewood'],
];

$spec_topics = [
    ['id' => 'room', 'label' => 'Room plan'],
    ['id' => 'glass', 'label' => 'Glass'],
    ['id' => 'security', 'label' => 'Security'],
    ['id' => 'hardware', 'label' => 'Hardware'],
];

$survey_checks = [
    ['number' => '01', 'title' => 'Opening layout', 'copy' => 'Which panes open, where they are hinged and whether sightlines align across the elevation.'],
    ['number' => '02', 'title' => 'Glass', 'copy' => 'Thermal, safety, security, privacy, acoustic and solar-control needs, room by room.'],
    ['number' => '03', 'title' => 'Ventilation', 'copy' => 'Background ventilation and trickle-vent requirements alongside how you use each room.'],
    ['number' => '04', 'title' => 'Finish', 'copy' => 'Inside and outside colour, cills, bars, mock horns, handles and hardware.'],
    ['number' => '05', 'title' => 'The opening', 'copy' => 'Reveal depth, lintels, render, tiles, alarms, blinds, access and safe working space.'],
    ['number' => '06', 'title' => 'Evidence', 'copy' => 'The U-value, security evidence and guarantee that apply to the finished configuration.'],
];

$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A casement is an outward-opening window with sashes hinged at the side or top. Opening sashes and fixed panes can be combined in one made-to-measure frame.'],
    ['question' => 'Which Liniar system does Fenster use?', 'answer' => 'This page covers the 70mm Liniar EnergyPlus uPVC system. It is a six-chamber platform designed for UK replacement and new-build applications. Glass, reinforcement and hardware are confirmed for the individual project.'],
    ['question' => 'What U-value can an EnergyPlus casement achieve?', 'answer' => 'Fenster lists a 0.95 W/m²K specification for this product. Liniar says suitable EnergyPlus configurations can achieve values as low as 0.8 W/m²K. Size, layout, glass and reinforcement affect the complete-window value.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options where required. Certification applies to the tested complete window, not the profile name alone.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'The appropriate glass build-up depends on the selected frame, sash size and required performance. We compare the practical benefit, weight and cost rather than treating triple glazing as an automatic upgrade.'],
    ['question' => 'Can casement windows reduce outside noise?', 'answer' => 'Yes, when the complete specification is designed for it. Acoustic glass, pane thicknesses, frame seals and the ventilation path all influence the result.'],
    ['question' => 'How many colours are available?', 'answer' => 'Fenster currently presents 16 colour choices for this range. Liniar has a wider foil catalogue, but profile availability, substrate, lead time and cost depend on the fabricator and exact configuration.'],
    ['question' => 'What is the difference between EnergyPlus and Zero|90?', 'answer' => 'EnergyPlus is the 70mm six-chamber system on this page. Zero|90 is a separate 90mm Passivhaus-certified system with different glass capacity and test figures. Zero|90 performance is not part of a standard EnergyPlus quote.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, but an exact copy is not always the best answer. Survey checks escape, ventilation, handle reach, outside clearance and sightline balance before the final drawing is approved.'],
    ['question' => 'Are Liniar uPVC frames recyclable?', 'answer' => 'Liniar describes its uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire; independent fabricators manufacture the finished windows.'],
];

$faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(
        static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
        ],
        $faqs
    ),
];
?>

<div class="fg-cv3">
    <section class="fg-cv3-intro" aria-labelledby="fg-cv3-intro-title">
        <div class="container fg-cv3-intro__grid">
            <div class="fg-cv3-intro__copy">
                <p class="eyebrow"><?php esc_html_e('The window most homes need', 'fenster'); ?></p>
                <h2 id="fg-cv3-intro-title"><?php esc_html_e('Simple from the street. Carefully decided underneath.', 'fenster'); ?></h2>
                <p class="fg-cv3-lead"><?php esc_html_e('Casements work because one frame can mix wide-opening sashes, small ventilators and fixed panes without making the house look busy.', 'fenster'); ?></p>
                <p><?php esc_html_e('Fenster specifies the 70mm Liniar EnergyPlus platform. We decide the layout room by room, then match the glass, locks, ventilation, colour and hardware to the job each window has to do.', 'fenster'); ?></p>
                <a class="fg-cv3-arrow-link" href="#casement-opening-styles"><?php esc_html_e('Start with the opening style', 'fenster'); ?><span aria-hidden="true">↓</span></a>
            </div>
            <figure class="fg-cv3-intro__image">
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-detail-1600w.webp')); ?>" alt="<?php esc_attr_e('Open white Liniar casement window showing the sash and handle', 'fenster'); ?>" loading="eager" width="1600" height="1068">
                <figcaption>
                    <span>70mm</span>
                    <p><?php esc_html_e('Liniar EnergyPlus profile, made to measure for the opening.', 'fenster'); ?></p>
                </figcaption>
            </figure>
            <aside class="fg-cv3-intro__note">
                <span><?php esc_html_e('The useful starting point', 'fenster'); ?></span>
                <strong><?php esc_html_e('Decide what each room needs before deciding what every window should look like.', 'fenster'); ?></strong>
            </aside>
        </div>
    </section>

    <section id="casement-opening-styles" class="fg-cv3-openings" data-fg-casement-explorer aria-labelledby="fg-cv3-openings-title">
        <div class="container">
            <header class="fg-cv3-heading">
                <p class="eyebrow"><?php esc_html_e('Choose how it opens', 'fenster'); ?></p>
                <h2 id="fg-cv3-openings-title"><?php esc_html_e('Four layouts. Four different jobs.', 'fenster'); ?></h2>
                <p><?php esc_html_e('These are not decorative variations. Each choice changes ventilation, handle reach, outside clearance and the amount of uninterrupted glass.', 'fenster'); ?></p>
            </header>

            <div class="fg-cv3-openings__tabs" role="tablist" aria-label="<?php esc_attr_e('Casement opening styles', 'fenster'); ?>">
                <?php foreach ($opening_styles as $index => $style) : ?>
                    <button
                        type="button"
                        role="tab"
                        id="fg-cv3-tab-<?php echo esc_attr($style['id']); ?>"
                        aria-controls="fg-cv3-panel-<?php echo esc_attr($style['id']); ?>"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                        class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                        data-fg-casement-tab
                    >
                        <small><?php echo esc_html($style['number']); ?></small>
                        <strong><?php echo esc_html($style['name']); ?></strong>
                        <span><?php echo esc_html($style['label']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="fg-cv3-openings__stage">
                <?php foreach ($opening_styles as $index => $style) : ?>
                    <article
                        id="fg-cv3-panel-<?php echo esc_attr($style['id']); ?>"
                        role="tabpanel"
                        aria-labelledby="fg-cv3-tab-<?php echo esc_attr($style['id']); ?>"
                        class="fg-cv3-opening <?php echo $index === 0 ? 'is-active' : ''; ?>"
                        data-fg-casement-panel
                        <?php echo $index === 0 ? '' : 'hidden'; ?>
                    >
                        <figure>
                            <img
                                src="<?php echo esc_url(fenster_generated_url($asset_base . $style['image'])); ?>"
                                alt="<?php echo esc_attr($style['alt']); ?>"
                                loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                                width="<?php echo esc_attr((string) $style['width']); ?>"
                                height="<?php echo esc_attr((string) $style['height']); ?>"
                            >
                            <span><?php echo esc_html($style['number'] . ' / ' . $style['name']); ?></span>
                        </figure>
                        <div class="fg-cv3-opening__copy">
                            <p class="eyebrow"><?php echo esc_html($style['label']); ?></p>
                            <h3><?php echo esc_html($style['name']); ?></h3>
                            <p><?php echo esc_html($style['copy']); ?></p>
                            <dl>
                                <div><dt><?php esc_html_e('Works well in', 'fenster'); ?></dt><dd><?php echo esc_html($style['best']); ?></dd></div>
                                <div><dt><?php esc_html_e('Fenster checks', 'fenster'); ?></dt><dd><?php echo esc_html($style['check']); ?></dd></div>
                            </dl>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-cv3-engineering" aria-labelledby="fg-cv3-engineering-title">
        <div class="container">
            <header class="fg-cv3-engineering__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('What is inside the frame', 'fenster'); ?></p>
                    <h2 id="fg-cv3-engineering-title"><?php esc_html_e('EnergyPlus is a six-chamber 70mm system.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The chamber layout slows heat transfer through the uPVC. A co-extruded bubble gasket seals the opening sash, while the glass unit and installation complete the thermal envelope.', 'fenster'); ?></p>
            </header>

            <div class="fg-cv3-engineering__main">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-energyplus-thermal-600w.webp')); ?>" alt="<?php esc_attr_e('Thermal illustration of the six-chamber Liniar EnergyPlus profile', 'fenster'); ?>" loading="lazy" width="600" height="400">
                    <figcaption><?php esc_html_e('Manufacturer profile illustration. The finished window includes the selected glass, reinforcement and hardware.', 'fenster'); ?></figcaption>
                </figure>
                <div class="fg-cv3-engineering__numbers">
                    <article><strong>70</strong><span>mm</span><p><?php esc_html_e('profile depth', 'fenster'); ?></p></article>
                    <article><strong>6</strong><span><?php esc_html_e('chambers', 'fenster'); ?></span><p><?php esc_html_e('through the EnergyPlus frame', 'fenster'); ?></p></article>
                    <article><strong>0.95</strong><span>W/m²K</span><p><?php esc_html_e('Fenster listed specification', 'fenster'); ?></p></article>
                    <article><strong>0.8</strong><span>W/m²K</span><p><?php esc_html_e('Liniar best-case claim in a suitable build-up', 'fenster'); ?></p></article>
                </div>
            </div>

            <div class="fg-cv3-engineering__layers">
                <article><span>01</span><h3><?php esc_html_e('Chambered frame', 'fenster'); ?></h3><p><?php esc_html_e('Symmetrical internal chambers interrupt the direct route for heat through the profile.', 'fenster'); ?></p></article>
                <article><span>02</span><h3><?php esc_html_e('Sealed glass unit', 'fenster'); ?></h3><p><?php esc_html_e('Panes, coatings, gas and spacer choice determine much of the whole-window result.', 'fenster'); ?></p></article>
                <article><span>03</span><h3><?php esc_html_e('Bubble gasket', 'fenster'); ?></h3><p><?php esc_html_e('The weather seal is co-extruded into the profile to keep it correctly positioned.', 'fenster'); ?></p></article>
                <article><span>04</span><h3><?php esc_html_e('Installation', 'fenster'); ?></h3><p><?php esc_html_e('Fixing, sealing and finishing connect the tested product to the actual wall opening.', 'fenster'); ?></p></article>
            </div>

            <p class="fg-cv3-engineering__caveat"><?php esc_html_e('U-values belong to the complete window, not the empty frame. Size, opening layout, reinforcement and sealed-unit build-up affect the figure, so the agreed value must follow the final specification.', 'fenster'); ?></p>
        </div>
    </section>

    <section class="fg-cv3-spec" data-fg-product-intel aria-labelledby="fg-cv3-spec-title">
        <div class="container">
            <header class="fg-cv3-heading fg-cv3-heading--split">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Specify it properly', 'fenster'); ?></p>
                    <h2 id="fg-cv3-spec-title"><?php esc_html_e('One window system. A different answer for every room.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Use the four views below to see how room use, glass, security and hardware shape the finished window.', 'fenster'); ?></p>
            </header>

            <div class="fg-cv3-spec__shell">
                <div class="fg-cv3-spec__tabs" role="tablist" aria-label="<?php esc_attr_e('Casement specification topics', 'fenster'); ?>">
                    <?php foreach ($spec_topics as $index => $topic) : ?>
                        <button
                            type="button"
                            role="tab"
                            id="fg-cv3-spec-tab-<?php echo esc_attr($topic['id']); ?>"
                            aria-controls="fg-cv3-spec-panel-<?php echo esc_attr($topic['id']); ?>"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                            class="<?php echo $index === 0 ? 'is-active' : ''; ?>"
                            data-fg-product-intel-tab
                        ><?php echo esc_html($topic['label']); ?></button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-cv3-spec__panels">
                    <section id="fg-cv3-spec-panel-room" class="fg-cv3-spec__panel is-active" role="tabpanel" aria-labelledby="fg-cv3-spec-tab-room" data-fg-product-intel-panel>
                        <div class="fg-cv3-spec__intro">
                            <span>01</span>
                            <div><h3><?php esc_html_e('Plan the house from inside and outside.', 'fenster'); ?></h3><p><?php esc_html_e('The outer proportions can stay consistent while each room gets the opening and glass it needs.', 'fenster'); ?></p></div>
                        </div>
                        <div class="fg-cv3-room-table">
                            <?php foreach ($room_rows as $row) : ?>
                                <article>
                                    <strong><?php echo esc_html($row['room']); ?></strong>
                                    <span><?php echo esc_html($row['need']); ?></span>
                                    <p><?php echo esc_html($row['answer']); ?></p>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section id="fg-cv3-spec-panel-glass" class="fg-cv3-spec__panel" role="tabpanel" aria-labelledby="fg-cv3-spec-tab-glass" data-fg-product-intel-panel hidden>
                        <div class="fg-cv3-spec__intro">
                            <span>02</span>
                            <div><h3><?php esc_html_e('Choose glass for the problem it solves.', 'fenster'); ?></h3><p><?php esc_html_e('Warmth, privacy, noise and security do not always point to the same sealed unit.', 'fenster'); ?></p></div>
                        </div>
                        <div class="fg-cv3-glass-list">
                            <?php foreach ($glass_rows as $index => $row) : ?>
                                <article><small><?php echo esc_html(sprintf('%02d', $index + 1)); ?></small><div><h4><?php echo esc_html($row['title']); ?></h4><p><?php echo esc_html($row['copy']); ?></p></div></article>
                            <?php endforeach; ?>
                        </div>
                        <a class="fg-cv3-arrow-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Explore obscure-glass patterns', 'fenster'); ?><span aria-hidden="true">→</span></a>
                    </section>

                    <section id="fg-cv3-spec-panel-security" class="fg-cv3-spec__panel" role="tabpanel" aria-labelledby="fg-cv3-spec-tab-security" data-fg-product-intel-panel hidden>
                        <div class="fg-cv3-spec__feature">
                            <div>
                                <span>03</span>
                                <h3><?php esc_html_e('Security comes from the complete configuration.', 'fenster'); ?></h3>
                                <p><?php esc_html_e('Liniar’s wider window range supports multi-point locking, reinforced frames and PAS 24 or Secured by Design options. Those labels apply only when the frame, glass, hardware and installation match the tested specification.', 'fenster'); ?></p>
                                <ul>
                                    <li><?php esc_html_e('Multi-point locking around the opening sash', 'fenster'); ?></li>
                                    <li><?php esc_html_e('Reinforcement selected for size, colour and exposure', 'fenster'); ?></li>
                                    <li><?php esc_html_e('Laminated or safety glass where required', 'fenster'); ?></li>
                                    <li><?php esc_html_e('PAS 24 and Secured by Design options when specified', 'fenster'); ?></li>
                                </ul>
                            </div>
                            <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-handle-detail-1400w.webp')); ?>" alt="<?php esc_attr_e('Casement window locking handle detail', 'fenster'); ?>" loading="lazy" width="1400" height="933">
                        </div>
                    </section>

                    <section id="fg-cv3-spec-panel-hardware" class="fg-cv3-spec__panel" role="tabpanel" aria-labelledby="fg-cv3-spec-tab-hardware" data-fg-product-intel-panel hidden>
                        <div class="fg-cv3-spec__feature fg-cv3-spec__feature--reverse">
                            <div>
                                <span>04</span>
                                <h3><?php esc_html_e('Choose the parts you will touch every day.', 'fenster'); ?></h3>
                                <p><?php esc_html_e('Fenster offers S2 Signature window handles with finish choices to coordinate with the frame and room. Restrictors, hinge type and locking are agreed around how each window will be used.', 'fenster'); ?></p>
                                <dl>
                                    <div><dt><?php esc_html_e('Handle', 'fenster'); ?></dt><dd><?php esc_html_e('S2 Signature option', 'fenster'); ?></dd></div>
                                    <div><dt><?php esc_html_e('Locking', 'fenster'); ?></dt><dd><?php esc_html_e('Multi-point', 'fenster'); ?></dd></div>
                                    <div><dt><?php esc_html_e('Safety', 'fenster'); ?></dt><dd><?php esc_html_e('Restrictors where useful', 'fenster'); ?></dd></div>
                                    <div><dt><?php esc_html_e('Finish', 'fenster'); ?></dt><dd><?php esc_html_e('Matched to the scheme', 'fenster'); ?></dd></div>
                                </dl>
                                <a class="fg-cv3-arrow-link" href="<?php echo esc_url(home_url('/window-handles/')); ?>"><?php esc_html_e('Compare handle finishes', 'fenster'); ?><span aria-hidden="true">→</span></a>
                            </div>
                            <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-sill-interior-1200w.webp')); ?>" alt="<?php esc_attr_e('White casement window handle above an interior cill', 'fenster'); ?>" loading="lazy" width="1200" height="800">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-cv3-finish" aria-labelledby="fg-cv3-finish-title">
        <div class="container">
            <figure class="fg-cv3-finish__hero">
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-house-rear-1600w.webp')); ?>" alt="<?php esc_attr_e('House elevation with dark grey casement windows', 'fenster'); ?>" loading="lazy" width="1600" height="900">
                <figcaption>
                    <p class="eyebrow"><?php esc_html_e('Colour, proportion and detail', 'fenster'); ?></p>
                    <h2 id="fg-cv3-finish-title"><?php esc_html_e('Make the elevation feel considered, not catalogued.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Pane widths, transom heights, equal sightlines and colour do more visual work than decorative extras. We draw the whole elevation before asking you to approve it.', 'fenster'); ?></p>
                </figcaption>
            </figure>

            <div class="fg-cv3-finish__lower">
                <div class="fg-cv3-finish__colours">
                    <header>
                        <div><p class="eyebrow"><?php esc_html_e('Representative colour families', 'fenster'); ?></p><h3><?php esc_html_e('Start with the finish in your hand, not on a screen.', 'fenster'); ?></h3></div>
                        <p><?php esc_html_e('Fenster lists 16 colour choices. Liniar’s wider foil catalogue contains more, but profile availability, substrate, cost and lead time must be confirmed.', 'fenster'); ?></p>
                    </header>
                    <div class="fg-cv3-swatches" aria-label="<?php esc_attr_e('Representative Liniar colour families', 'fenster'); ?>">
                        <?php foreach ($colours as $colour) : ?>
                            <div class="fg-cv3-swatch fg-cv3-swatch--<?php echo esc_attr($colour['class']); ?>"><span aria-hidden="true"></span><strong><?php echo esc_html($colour['name']); ?></strong></div>
                        <?php endforeach; ?>
                    </div>
                    <a class="fg-cv3-arrow-link" href="<?php echo esc_url(home_url('/upvc-colours/')); ?>"><?php esc_html_e('See the complete uPVC colour guide', 'fenster'); ?><span aria-hidden="true">→</span></a>
                </div>
                <figure class="fg-cv3-finish__detail">
                    <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-mockhorn-detail-600w.webp')); ?>" alt="<?php esc_attr_e('White casement windows with optional mock-horn detail', 'fenster'); ?>" loading="lazy" width="600" height="600">
                    <figcaption><strong><?php esc_html_e('Mock horns', 'fenster'); ?></strong><span><?php esc_html_e('An optional sash-like visual cue, not a standard feature.', 'fenster'); ?></span></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <section class="fg-cv3-clarity" aria-labelledby="fg-cv3-clarity-title">
        <div class="container">
            <header class="fg-cv3-heading fg-cv3-heading--split">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Know what is in the quote', 'fenster'); ?></p>
                    <h2 id="fg-cv3-clarity-title"><?php esc_html_e('EnergyPlus and Zero|90 are different products.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The distinction matters because the best published figure only has value when it belongs to the frame and glass that will actually be installed.', 'fenster'); ?></p>
            </header>

            <div class="fg-cv3-compare">
                <article>
                    <span><?php esc_html_e('The system on this page', 'fenster'); ?></span>
                    <h3><?php esc_html_e('70mm EnergyPlus', 'fenster'); ?></h3>
                    <dl>
                        <div><dt><?php esc_html_e('Profile', 'fenster'); ?></dt><dd><?php esc_html_e('Six-chamber uPVC', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Use', 'fenster'); ?></dt><dd><?php esc_html_e('Replacement and new build', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Published best case', 'fenster'); ?></dt><dd>0.8 W/m²K</dd></div>
                        <div><dt><?php esc_html_e('Quote journey', 'fenster'); ?></dt><dd><?php esc_html_e('Included below', 'fenster'); ?></dd></div>
                    </dl>
                </article>
                <article>
                    <span><?php esc_html_e('A separate Liniar platform', 'fenster'); ?></span>
                    <h3><?php esc_html_e('90mm Zero|90', 'fenster'); ?></h3>
                    <dl>
                        <div><dt><?php esc_html_e('Profile', 'fenster'); ?></dt><dd><?php esc_html_e('90mm Passivhaus system', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Use', 'fenster'); ?></dt><dd><?php esc_html_e('Different new-build and retrofit details', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Evidence', 'fenster'); ?></dt><dd><?php esc_html_e('Separate glass and test figures', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Standard quote', 'fenster'); ?></dt><dd><?php esc_html_e('Not assumed', 'fenster'); ?></dd></div>
                    </dl>
                </article>
            </div>

            <div class="fg-cv3-origin">
                <p><strong><?php esc_html_e('Lead-free', 'fenster'); ?></strong><?php esc_html_e('profile formulation', 'fenster'); ?></p>
                <p><strong><?php esc_html_e('Recyclable', 'fenster'); ?></strong><?php esc_html_e('uPVC at end of useful life', 'fenster'); ?></p>
                <p><strong><?php esc_html_e('Derbyshire', 'fenster'); ?></strong><?php esc_html_e('profile design, extrusion and testing', 'fenster'); ?></p>
                <p><?php esc_html_e('Independent Liniar fabricators make the finished windows, which is why colour, hardware, guarantee and performance evidence must follow the actual order.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    <section class="fg-cv3-survey" aria-labelledby="fg-cv3-survey-title">
        <div class="container fg-cv3-survey__grid">
            <figure>
                <img src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-installation-900w.webp')); ?>" alt="<?php esc_attr_e('Installer checking a Liniar window in a brick opening', 'fenster'); ?>" loading="lazy" width="900" height="600">
                <figcaption><?php esc_html_e('Survey, manufacture and installation are separate stages. Each confirms the detail it controls.', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cv3-survey__copy">
                <p class="eyebrow"><?php esc_html_e('Before anything is made', 'fenster'); ?></p>
                <h2 id="fg-cv3-survey-title"><?php esc_html_e('Six things should be settled on the survey.', 'fenster'); ?></h2>
                <ol>
                    <?php foreach ($survey_checks as $check) : ?>
                        <li><span><?php echo esc_html($check['number']); ?></span><div><h3><?php echo esc_html($check['title']); ?></h3><p><?php echo esc_html($check['copy']); ?></p></div></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </section>

    <section class="fg-cv3-related" aria-labelledby="fg-cv3-related-title">
        <div class="container">
            <header>
                <p class="eyebrow"><?php esc_html_e('Compare before you commit', 'fenster'); ?></p>
                <h2 id="fg-cv3-related-title"><?php esc_html_e('Three nearby alternatives.', 'fenster'); ?></h2>
            </header>
            <div>
                <a href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>"><span>01</span><h3><?php esc_html_e('Flush casement', 'fenster'); ?></h3><p><?php esc_html_e('For a flatter outside face and a quieter external line.', 'fenster'); ?></p><strong><?php esc_html_e('Explore', 'fenster'); ?> →</strong></a>
                <a href="<?php echo esc_url(home_url('/french-casement-windows/')); ?>"><span>02</span><h3><?php esc_html_e('French casement', 'fenster'); ?></h3><p><?php esc_html_e('For two opening sashes and a wider clear opening.', 'fenster'); ?></p><strong><?php esc_html_e('Explore', 'fenster'); ?> →</strong></a>
                <a href="<?php echo esc_url(home_url('/tilt-turn-windows/')); ?>"><span>03</span><h3><?php esc_html_e('Tilt and turn', 'fenster'); ?></h3><p><?php esc_html_e('For secure tilt ventilation and inward-opening access.', 'fenster'); ?></p><strong><?php esc_html_e('Explore', 'fenster'); ?> →</strong></a>
            </div>
        </div>
    </section>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed fg-cv3-quote" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Build a starting design and see an indicative price.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Choose the style, sizes, colours and options in the Fenster tool. Survey confirms the exact layout, glass, hardware and final price before manufacture.', 'fenster'); ?></p>
                    <a class="button fg-cv3-quote__mobile" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Design and price my windows', 'fenster'); ?></a>
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
                        <iframe data-quote-iframe-src="<?php echo esc_url($quote_url); ?>" title="<?php echo esc_attr($quote_label . ' instant quote tool'); ?>" loading="lazy" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </article>
            </div>
        </section>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--product fg-cv3-reviews',
        'eyebrow' => 'Customer proof',
        'title' => 'What Milton Keynes homeowners say',
        'copy' => 'Local installation, supported by recognised product systems and independent customer reviews.',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>

    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <section class="fg-product-faq fg-cv3-faq" aria-labelledby="fg-cv3-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cv3-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('These answers refer to the 70mm Liniar EnergyPlus system described on this page.', 'fenster'); ?></p>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>><summary><?php echo esc_html($faq['question']); ?></summary><div class="fg-product-faq__answer"><p><?php echo esc_html($faq['answer']); ?></p></div></details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="fenster-enquiry" class="fg-enquiry fg-cv3-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Start your casement project', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what the new windows need to improve.', 'fenster'); ?></h2>
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
