<?php
/**
 * Casement windows: 70mm Liniar EnergyPlus product journey.
 *
 * The approved shared hero and four-tile specification strip render before this
 * partial and are deliberately untouched.
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
$phone = (string) ($brand['phone'] ?? '01908 429200');
$asset_base = '/wp-content/themes/fenster/assets/images/products/casement/';
$swatch_base = '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/';

// The page hero already uses casement-stone-cottage-1600w.webp, so it is not
// repeated below. Every image here is used exactly once.
$opening_styles = [
    [
        'id' => 'side-hung',
        'name' => 'Side-hung',
        'label' => 'The wide opening',
        'image' => 'casement-open-brick-1400w.webp',
        'width' => 1400,
        'height' => 933,
        'position' => 'center',
        'alt' => 'White uPVC casement windows opened outwards on a brick house',
        'copy' => 'Hinged at the side and opening outwards. This is the everyday all-rounder, and it is what most of the windows we fit end up being. It gives you the widest clear opening, the fastest way to air a room and, where the sizes allow it, a usable escape route from a bedroom.',
        'best' => 'Bedrooms, living rooms and larger openings',
        'check' => 'Which side it hinges on, where the furniture sits, how far the sash swings outside and whether the opening has to meet an escape requirement.',
    ],
    [
        'id' => 'top-hung',
        'name' => 'Top-hung',
        'label' => 'Controlled ventilation',
        'image' => 'casement-mockhorn-detail-600w.webp',
        'width' => 600,
        'height' => 600,
        'position' => 'center',
        'alt' => 'Top-hung white uPVC casement openers above fixed panes, with mock horns',
        'copy' => 'Hinged along the top so the bottom edge swings out. You can leave it open in the rain without much coming in, and it sits happily above a fixed pane where a full-width opener would be more than the room needs.',
        'best' => 'Bathrooms, kitchens, cloakrooms and fanlights',
        'check' => 'Opener height, whether you can reach the handle, obscure glass for privacy and how far it should be allowed to open.',
    ],
    [
        'id' => 'fixed-pane',
        'name' => 'Fixed pane',
        'label' => 'More glass, fewer joints',
        'image' => 'casement-sill-interior-1200w.webp',
        'width' => 1200,
        'height' => 800,
        'position' => 'center',
        'alt' => 'White uPVC casement window and cill seen from inside a room',
        'copy' => 'A pane with no hinges and no handle. It costs less to glaze than an opener of the same size, it lets more light in because there is no sash frame in the way, and it keeps a wide window from looking like a row of identical boxes.',
        'best' => 'Picture windows, bays and wide multi-light frames',
        'check' => 'That ventilation, cleaning access and any escape route are covered by the opening lights elsewhere in the frame.',
    ],
    [
        'id' => 'mixed-layout',
        'name' => 'Mixed layout',
        'label' => 'One frame, several jobs',
        'image' => 'casement-house-rear-1600w.webp',
        'width' => 1600,
        'height' => 900,
        'position' => 'top',
        'alt' => 'Rear elevation of a house with grey uPVC casement windows',
        'copy' => 'Side-hung, top-hung and fixed lights can all be made into one frame. This is where most of the thinking goes: the layout has to work for the room from the inside and still look deliberate from the pavement.',
        'best' => 'Whole-house replacements and wide living-room windows',
        'check' => 'Pane widths, transom heights, which sections genuinely need to open, and whether the sightlines line up with the windows either side.',
    ],
];

$room_rows = [
    ['room' => 'Bedroom', 'need' => 'Escape and night air', 'answer' => 'A side-hung sash sized so the clear opening works, with the handle somewhere you can reach from the bed side of the room.'],
    ['room' => 'Bathroom', 'need' => 'Privacy and moisture', 'answer' => 'A top-hung opener you can leave ajar, with the obscure pattern and privacy level picked from a real sample.'],
    ['room' => 'Kitchen', 'need' => 'Reach and clearance', 'answer' => 'A layout planned around the taps, the worktop depth and how far the sash swings out over a path or a bin store.'],
    ['room' => 'Living room', 'need' => 'Light and proportion', 'answer' => 'Larger fixed panes for the view, with opening lights only where somebody will actually use them.'],
    ['room' => 'Landing', 'need' => 'Safe operation', 'answer' => 'Handle reach over a stairwell, restrictors where they are sensible, and how the outside face gets cleaned.'],
    ['room' => 'Street-facing room', 'need' => 'Noise and security', 'answer' => 'Glass build-up, ventilation route, locking and frame specification treated as one problem rather than four.'],
];

$glass_rows = [
    ['title' => 'Energy-efficient glazing', 'copy' => 'Panes, coatings, gas fill and a warm-edge spacer chosen with the frame to hit the agreed whole-window figure.'],
    ['title' => 'Obscure glass', 'copy' => 'Patterned privacy glass for bathrooms and overlooked rooms. Pick the pattern and the privacy level from a sample, not a screen.'],
    ['title' => 'Acoustic glass', 'copy' => 'Pane thicknesses, laminate, seals and the ventilation route all matter. Triple glazing on its own is not automatically the quietest answer.'],
    ['title' => 'Safety and security glass', 'copy' => 'Toughened or laminated where the design needs it, including low-level glazing and anywhere resistance is part of the specification.'],
];

$swatches = [
    ['name' => 'White', 'file' => 'colours_page_image-White-weiss.webp'],
    ['name' => 'Cream', 'file' => 'colours_page_image-Cream-Cremeweiss.webp'],
    ['name' => 'Chartwell Green', 'file' => 'colours_page_image-Chartwell-green.webp'],
    ['name' => 'Agate Grey', 'file' => 'colours_page_image-Agate-grey-7038.webp'],
    ['name' => 'Anthracite Grey', 'file' => 'colours_page_image-7016-SM-Grey.webp'],
    ['name' => 'Slate Grey', 'file' => 'colours_page_image-Slate-grey-7015-grey.webp'],
    ['name' => 'Golden Oak', 'file' => 'colours_page_image-Golden-Oak.webp'],
    ['name' => 'Rosewood', 'file' => 'colours_page_image-Rosewood.webp'],
];

$frame_facts = [
    ['value' => '70mm', 'label' => 'Profile depth'],
    ['value' => '6', 'label' => 'Chambers through the frame'],
    ['value' => '0.95', 'label' => 'W/m²K on our listed specification'],
    ['value' => '0.8', 'label' => 'W/m²K, Liniar best case in a suitable build-up'],
];

$frame_points = [
    ['title' => 'Chambered frame', 'copy' => 'Six symmetrical chambers interrupt the direct route heat would otherwise take through the uPVC.'],
    ['title' => 'Sealed glass unit', 'copy' => 'Panes, coatings, gas and spacer decide most of the whole-window figure, not the profile on its own.'],
    ['title' => 'Co-extruded gasket', 'copy' => 'The weather seal is formed as part of the profile, so it cannot shrink back or work loose at a corner.'],
    ['title' => 'Installation', 'copy' => 'Fixing, sealing and finishing are what connect a tested product to your actual wall opening.'],
];

$security_points = [
    'Multi-point locking around the opening sash',
    'Reinforcement selected for the size, colour and exposure of each window',
    'Laminated or toughened glass where the design calls for it',
    'PAS 24 and Secured by Design specifications when they are asked for',
];

$survey_checks = [
    ['title' => 'Opening layout', 'copy' => 'Which panes open, where they hinge and whether the sightlines line up across the elevation.'],
    ['title' => 'Glass', 'copy' => 'Thermal, safety, security, privacy, acoustic and solar-control needs, room by room.'],
    ['title' => 'Ventilation', 'copy' => 'Background ventilation and trickle-vent requirements alongside how you actually use the room.'],
    ['title' => 'Finish', 'copy' => 'Inside and outside colour, cills, glazing bars, mock horns, handles and hardware.'],
    ['title' => 'The opening', 'copy' => 'Reveal depth, lintels, render, tiles, alarms, blinds, access and safe working space outside.'],
    ['title' => 'Evidence', 'copy' => 'The U-value, security evidence and guarantee that apply to the configuration you have agreed.'],
];

$related = [
    ['url' => '/flush-casement-windows/', 'name' => 'Flush casement windows', 'copy' => 'The sash closes level with the frame instead of sitting proud of it.'],
    ['url' => '/french-casement-windows/', 'name' => 'French casement windows', 'copy' => 'Two sashes and no post between them, for one uninterrupted opening.'],
    ['url' => '/tilt-turn-windows/', 'name' => 'Tilt and turn windows', 'copy' => 'Tilts in at the top for air, or swings fully inwards for cleaning.'],
];

$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A casement is a window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'Which Liniar system do you fit?', 'answer' => 'The 70mm Liniar EnergyPlus system. It is a six-chamber uPVC platform used for both replacement and new-build work. Glass, reinforcement and hardware are confirmed for your individual job.'],
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => 'We list 0.95 W/m²K for this product. Liniar says a suitable EnergyPlus build-up can reach 0.8 W/m²K. Size, layout, glass and reinforcement all move the complete-window figure, so the number we agree follows the final specification.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options. Those approvals belong to a tested complete window, not to the profile name, so we confirm what applies to your configuration.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'It depends on the frame, the sash size and what you are trying to improve. We will compare the practical benefit, the weight and the cost with you rather than treating triple glazing as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Acoustic glass, pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen colour choices for this range, inside, outside or both. Liniar publishes a wider foil catalogue, but availability, substrate, lead time and cost depend on the exact profile and the fabricator, so we confirm before you order.'],
    ['question' => 'What is the difference between EnergyPlus and Zero|90?', 'answer' => 'EnergyPlus is the 70mm six-chamber system this page describes. Zero|90 is a separate 90mm Passivhaus-certified system with different glass capacity and its own test figures. Zero|90 performance is not part of a standard EnergyPlus quote.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, though an exact copy is not always the best answer. At survey we check escape, ventilation, handle reach, outside clearance and how the sightlines sit before the drawing is signed off.'],
    ['question' => 'Are the frames recyclable?', 'answer' => 'Liniar describes its uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire, and independent fabricators make the finished windows.'],
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

<div class="fg-cw">
    <section class="fg-cw-intro" aria-labelledby="fg-cw-intro-title">
        <div class="container fg-cw-intro__grid">
            <div class="fg-cw-intro__copy">
                <p class="eyebrow"><?php esc_html_e('The system we fit', 'fenster'); ?></p>
                <h2 id="fg-cw-intro-title"><?php esc_html_e('One frame can mix openers and fixed panes.', 'fenster'); ?></h2>
                <p class="fg-cw-lead"><?php esc_html_e('A casement is hinged at the side or the top and opens outwards. Because the opening sashes and the fixed panes are made into a single frame, one window can give you a wide opening where you need it and uninterrupted glass where you do not.', 'fenster'); ?></p>
                <p><?php esc_html_e('We specify the 70mm Liniar EnergyPlus system on this page. We work out the layout room by room first, then match the glass, the locking, the ventilation, the colour and the handles to the job each window has to do.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('70mm six-chamber Liniar EnergyPlus profile, made to measure', 'fenster'); ?></li>
                    <li><?php esc_html_e('0.95 W/m²K on our listed specification, A+ rated', 'fenster'); ?></li>
                    <li><?php esc_html_e('Surveyed and fitted by our own installers, with a ten year guarantee', 'fenster'); ?></li>
                </ul>
                <div class="fg-cw-actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                </div>
            </div>
            <figure class="fg-cw-intro__media">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-brick-1400w.webp')); ?>"
                    alt="<?php esc_attr_e('White uPVC casement windows opened outwards on a brick house', 'fenster'); ?>"
                    loading="lazy"
                    width="1400"
                    height="933"
                >
                <figcaption><?php esc_html_e('Liniar EnergyPlus casements, Milton Keynes', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section id="casement-opening-styles" class="fg-cw-openings" data-fg-product-intel aria-labelledby="fg-cw-openings-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Opening styles', 'fenster'); ?></p>
                    <h2 id="fg-cw-openings-title"><?php esc_html_e('Four layouts, and what each one is for.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('These are not decorative variations. Each one changes how the room is aired, how far you have to reach, how far the sash swings outside and how much uninterrupted glass you end up with.', 'fenster'); ?></p>
            </div>

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
                        data-fg-product-intel-tab
                    >
                        <strong><?php echo esc_html($style['name']); ?></strong>
                        <span><?php echo esc_html($style['label']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="fg-cw-openings__stage">
                <?php foreach ($opening_styles as $index => $style) : ?>
                    <article
                        id="fg-cw-panel-<?php echo esc_attr($style['id']); ?>"
                        role="tabpanel"
                        aria-labelledby="fg-cw-tab-<?php echo esc_attr($style['id']); ?>"
                        class="fg-cw-opening<?php echo $index === 0 ? ' is-active' : ''; ?>"
                        data-fg-product-intel-panel
                        <?php echo $index === 0 ? '' : 'hidden'; ?>
                    >
                        <figure class="fg-cw-opening__media" data-position="<?php echo esc_attr($style['position']); ?>">
                            <img
                                src="<?php echo esc_url(fenster_generated_url($asset_base . $style['image'])); ?>"
                                alt="<?php echo esc_attr($style['alt']); ?>"
                                loading="lazy"
                                width="<?php echo esc_attr((string) $style['width']); ?>"
                                height="<?php echo esc_attr((string) $style['height']); ?>"
                            >
                        </figure>
                        <div class="fg-cw-opening__copy">
                            <h3><?php echo esc_html($style['name']); ?></h3>
                            <p><?php echo esc_html($style['copy']); ?></p>
                            <dl>
                                <div>
                                    <dt><?php esc_html_e('Works well in', 'fenster'); ?></dt>
                                    <dd><?php echo esc_html($style['best']); ?></dd>
                                </div>
                                <div>
                                    <dt><?php esc_html_e('What we check', 'fenster'); ?></dt>
                                    <dd><?php echo esc_html($style['check']); ?></dd>
                                </div>
                            </dl>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-cw-frame" aria-labelledby="fg-cw-frame-title">
        <div class="container">
            <div class="fg-cw-frame__grid">
                <figure class="fg-cw-frame__media">
                    <img
                        src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-energyplus-thermal-600w.webp')); ?>"
                        alt="<?php esc_attr_e('Cutaway of the six-chamber Liniar EnergyPlus profile with a thermal overlay', 'fenster'); ?>"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                    <figcaption><?php esc_html_e('Manufacturer cutaway. The finished window also includes the glass, reinforcement and hardware you choose.', 'fenster'); ?></figcaption>
                </figure>
                <div class="fg-cw-frame__copy">
                    <p class="eyebrow"><?php esc_html_e('Inside the frame', 'fenster'); ?></p>
                    <h2 id="fg-cw-frame-title"><?php esc_html_e('Six chambers, and a seal that cannot fall out.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('EnergyPlus is a 70mm profile with six chambers running through the frame. Each one interrupts the route heat takes through the uPVC. The weather seal is co-extruded, which means it is formed as part of the profile rather than pushed into a groove afterwards, so it cannot shrink back or work its way loose at a corner.', 'fenster'); ?></p>
                    <dl class="fg-cw-figures">
                        <?php foreach ($frame_facts as $fact) : ?>
                            <div>
                                <dt><?php echo esc_html($fact['value']); ?></dt>
                                <dd><?php echo esc_html($fact['label']); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
            </div>

            <ol class="fg-cw-points">
                <?php foreach ($frame_points as $index => $point) : ?>
                    <li>
                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html($point['title']); ?></h3>
                        <p><?php echo esc_html($point['copy']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>

            <p class="fg-cw-note"><?php esc_html_e('A U-value belongs to a complete window, not to an empty frame. Size, opening layout, reinforcement and the sealed unit all move it, so the figure we agree has to follow the final specification rather than the brochure.', 'fenster'); ?></p>
        </div>
    </section>

    <section class="fg-cw-plan" aria-labelledby="fg-cw-plan-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Planning the layout', 'fenster'); ?></p>
                    <h2 id="fg-cw-plan-title"><?php esc_html_e('What each room needs comes first.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The outside can stay consistent while every room gets the opening and the glass it actually needs. These are the conversations we have at survey, before anything is drawn.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-rooms">
                <?php foreach ($room_rows as $row) : ?>
                    <article>
                        <h3><?php echo esc_html($row['room']); ?></h3>
                        <p class="fg-cw-rooms__need"><?php echo esc_html($row['need']); ?></p>
                        <p><?php echo esc_html($row['answer']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="fg-cw-glass">
                <div class="fg-cw-glass__intro">
                    <h3><?php esc_html_e('Then the glass, for the problem it has to solve.', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Warmth, privacy, noise and security do not all point at the same sealed unit, so it is worth saying which one matters most to you.', 'fenster'); ?></p>
                    <a class="fg-cw-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('See obscure glass patterns', 'fenster'); ?></a>
                </div>
                <ul class="fg-cw-glass__list">
                    <?php foreach ($glass_rows as $row) : ?>
                        <li>
                            <strong><?php echo esc_html($row['title']); ?></strong>
                            <span><?php echo esc_html($row['copy']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="fg-cw-secure" aria-labelledby="fg-cw-secure-title">
        <div class="container fg-cw-secure__grid">
            <div class="fg-cw-secure__copy">
                <p class="eyebrow"><?php esc_html_e('Locking and handles', 'fenster'); ?></p>
                <h2 id="fg-cw-secure-title"><?php esc_html_e('Security belongs to the whole window, not the profile name.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The Liniar window range supports multi-point locking, reinforced frames and PAS 24 or Secured by Design specifications. Those labels only apply when the frame, glass, hardware and installation all match what was tested, so we tell you which of them your configuration actually carries.', 'fenster'); ?></p>
                <ul class="fg-cw-ticks">
                    <?php foreach ($security_points as $point) : ?>
                        <li><?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
                <dl class="fg-cw-hardware">
                    <div><dt><?php esc_html_e('Handle', 'fenster'); ?></dt><dd><?php esc_html_e('S2 Signature range', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Locking', 'fenster'); ?></dt><dd><?php esc_html_e('Multi-point', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Restrictors', 'fenster'); ?></dt><dd><?php esc_html_e('Where they are sensible', 'fenster'); ?></dd></div>
                    <div><dt><?php esc_html_e('Finishes', 'fenster'); ?></dt><dd><?php esc_html_e('Matched to the frame', 'fenster'); ?></dd></div>
                </dl>
                <a class="fg-cw-link" href="<?php echo esc_url(home_url('/window-handles/')); ?>"><?php esc_html_e('Compare handle finishes', 'fenster'); ?></a>
            </div>
            <figure class="fg-cw-secure__media">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-open-detail-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Casement window opened on its hinges with the handle and gearing visible', 'fenster'); ?>"
                    loading="lazy"
                    width="1600"
                    height="1068"
                >
            </figure>
        </div>
    </section>

    <section class="fg-cw-finish" aria-labelledby="fg-cw-finish-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Colour and finish', 'fenster'); ?></p>
                    <h2 id="fg-cw-finish-title"><?php esc_html_e('Sixteen colours, and one thing worth doing in person.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('A uPVC colour is a foil bonded to the profile at the factory, so it has a grain you can feel and it never needs repainting. You can have a different colour inside and out. What you cannot do is judge one on a screen, so ask us to bring the samples.', 'fenster'); ?></p>
            </div>

            <ul class="fg-cw-swatches">
                <?php foreach ($swatches as $swatch) : ?>
                    <li>
                        <img
                            src="<?php echo esc_url(fenster_generated_url($swatch_base . $swatch['file'])); ?>"
                            alt=""
                            loading="lazy"
                            aria-hidden="true"
                        >
                        <span><?php echo esc_html($swatch['name']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="fg-cw-finish__foot">
                <p><?php esc_html_e('Eight of the sixteen are shown here. Mock horns, glazing bars, cills and a different colour on the inside face are all decided at the same time, because they change how the elevation reads more than any of them do on their own.', 'fenster'); ?></p>
                <a class="fg-cw-link" href="<?php echo esc_url(home_url('/upvc-colours/')); ?>"><?php esc_html_e('See all uPVC colours', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-cw-systems" aria-labelledby="fg-cw-systems-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('What is in the quote', 'fenster'); ?></p>
                    <h2 id="fg-cw-systems-title"><?php esc_html_e('EnergyPlus and Zero|90 are two different systems.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Liniar publishes figures for both, and the best of them belong to the one we are not quoting here. A published number is only worth anything when it belongs to the frame and glass that will actually be fitted, so this is the distinction spelled out.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-compare">
                <article class="fg-cw-compare__card is-ours">
                    <p class="fg-cw-compare__tag"><?php esc_html_e('The system on this page', 'fenster'); ?></p>
                    <h3><?php esc_html_e('70mm EnergyPlus', 'fenster'); ?></h3>
                    <dl>
                        <div><dt><?php esc_html_e('Profile', 'fenster'); ?></dt><dd><?php esc_html_e('Six-chamber uPVC', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Used for', 'fenster'); ?></dt><dd><?php esc_html_e('Replacement and new build', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Published best case', 'fenster'); ?></dt><dd>0.8 W/m²K</dd></div>
                        <div><dt><?php esc_html_e('Quote tool', 'fenster'); ?></dt><dd><?php esc_html_e('Further down this page', 'fenster'); ?></dd></div>
                    </dl>
                </article>
                <article class="fg-cw-compare__card">
                    <p class="fg-cw-compare__tag"><?php esc_html_e('A separate Liniar platform', 'fenster'); ?></p>
                    <h3><?php esc_html_e('90mm Zero|90', 'fenster'); ?></h3>
                    <dl>
                        <div><dt><?php esc_html_e('Profile', 'fenster'); ?></dt><dd><?php esc_html_e('90mm Passivhaus-certified system', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Used for', 'fenster'); ?></dt><dd><?php esc_html_e('Different new-build and retrofit details', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Evidence', 'fenster'); ?></dt><dd><?php esc_html_e('Its own glass capacity and test figures', 'fenster'); ?></dd></div>
                        <div><dt><?php esc_html_e('Quote tool', 'fenster'); ?></dt><dd><?php esc_html_e('Ask us, it is not assumed', 'fenster'); ?></dd></div>
                    </dl>
                </article>
            </div>

            <ul class="fg-cw-origin">
                <li><strong><?php esc_html_e('Lead-free', 'fenster'); ?></strong><span><?php esc_html_e('profile formulation', 'fenster'); ?></span></li>
                <li><strong><?php esc_html_e('Recyclable', 'fenster'); ?></strong><span><?php esc_html_e('uPVC at the end of its useful life', 'fenster'); ?></span></li>
                <li><strong><?php esc_html_e('Derbyshire', 'fenster'); ?></strong><span><?php esc_html_e('profile design, extrusion and testing', 'fenster'); ?></span></li>
                <li class="fg-cw-origin__note"><?php esc_html_e('Independent fabricators make the finished windows, which is why colour, hardware, guarantee and performance evidence all have to follow your actual order.', 'fenster'); ?></li>
            </ul>
        </div>
    </section>

    <section class="fg-cw-survey" aria-labelledby="fg-cw-survey-title">
        <div class="container fg-cw-survey__grid">
            <figure class="fg-cw-survey__media">
                <img
                    src="<?php echo esc_url(fenster_generated_url($asset_base . 'casement-installation-900w.webp')); ?>"
                    alt="<?php esc_attr_e('Fenster installer fitting a new uPVC window frame into a brick opening', 'fenster'); ?>"
                    loading="lazy"
                    width="900"
                    height="600"
                >
                <figcaption><?php esc_html_e('Survey, manufacture and installation are three separate stages, and each one confirms the detail it controls.', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-survey__copy">
                <p class="eyebrow"><?php esc_html_e('Before anything is made', 'fenster'); ?></p>
                <h2 id="fg-cw-survey-title"><?php esc_html_e('Six things we settle at the survey.', 'fenster'); ?></h2>
                <ol>
                    <?php foreach ($survey_checks as $index => $check) : ?>
                        <li>
                            <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
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

    <section class="fg-cw-related" aria-labelledby="fg-cw-related-title">
        <div class="container">
            <div class="fg-cw-head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Nearby styles', 'fenster'); ?></p>
                    <h2 id="fg-cw-related-title"><?php esc_html_e('Three windows worth comparing first.', 'fenster'); ?></h2>
                </div>
            </div>
            <div class="fg-cw-related__grid">
                <?php foreach ($related as $item) : ?>
                    <a href="<?php echo esc_url(home_url($item['url'])); ?>">
                        <h3><?php echo esc_html($item['name']); ?></h3>
                        <p><?php echo esc_html($item['copy']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Choose the style, sizes, colours and options and the tool gives you a real figure. Survey confirms the layout, glass, hardware and final price before anything is made.', 'fenster'); ?></p>
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
        'class' => 'fg-review-showcase--product',
        'eyebrow' => 'Customer proof',
        'title' => 'What Milton Keynes homeowners say',
        'copy' => 'Local installation, recognised product systems and independent customer reviews.',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>

    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <section class="fg-product-faq" aria-labelledby="fg-cw-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cw-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('These answers all refer to the 70mm Liniar EnergyPlus system described on this page.', 'fenster'); ?></p>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer"><p><?php echo esc_html($faq['answer']); ?></p></div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Tell us about the job', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us what the new windows need to fix.', 'fenster'); ?></h2>
                <p><?php esc_html_e('How many windows, what sort of property and the main reason for replacing them is enough to start with. We will take it from there through layout, colour, glass, survey and price.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
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
