<?php
/**
 * Casement windows: 70mm Liniar EnergyPlus.
 *
 * Rebuilt 2026-08-04 on the owner's brief: order the page around the customer's
 * journey, lead on the three things that actually sell this window, and hold it
 * to the register of a luxury vehicle site rather than a double glazing one.
 *
 * The journey, in the order a buyer asks the questions:
 *   what is it, does it suit my house -> the overture
 *   can I have it the way I want it   -> 01 Versatility
 *   will it be warm                   -> 02 EnergyPlus
 *   will it be safe                   -> 03 Security
 *   are you any good                  -> the proof
 *   what does it cost                 -> the quote tool
 *
 * Imagery rule for this page: the best image wins, and manufacturer studio
 * photography beats a rough job photograph everywhere except the proof
 * sections, where the whole point is that the work is ours. The studio set
 * under assets/images/products/casement/studio was converted from CMYK
 * originals; see the note in PROGRESS.md before regenerating it.
 *
 * The shared hero and four-tile specification strip render above this partial.
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
$base = '/wp-content/themes/fenster/assets/images/products/casement/';
$studio = $base . 'studio/';

/* The film slot. Set $film_src to a theme path when the installation film is
   delivered and the band plays it in place of the poster; nothing else needs to
   change. A chip keeps it honest until then rather than looking unfinished. */
$film_src = '';

$styles = [
    [
        'name' => 'Side hung',
        'copy' => 'Hinged on the stile and held at any angle by a stainless friction stay. Where a bedroom needs its escape route, egress hinges swing the sash to ninety degrees so the clear opening meets the Building Regulations minimum of 0.33m², at least 450mm each way.',
        'image' => $studio . 'cas-hinge-open.webp',
        'alt' => 'Corner of a white uPVC casement window opened on its hinge, showing the gearing and the gasket',
    ],
    [
        'name' => 'Top hung',
        'copy' => 'Hinged in the head with the handle on the bottom rail. The open sash sheds rain clear of the opening, which is why top lights sit above fixed panes and over kitchen worktops. A restrictor holds the first opening to around 100mm where children sleep.',
        'image' => $studio . 'cas-stay-open.webp',
        'alt' => 'White uPVC top hung casement sash held open on its friction stay above a fixed pane',
    ],
    [
        'name' => 'Fixed pane',
        'copy' => 'No hinges, no gearing, no handle. The glass is bedded straight into the frame, so a fixed pane costs less than an opener the same size and carries a slimmer border and more glass. Ventilation and escape come from the openers around it.',
        'image' => $studio . 'cas-sash-proud-sq.webp',
        'alt' => 'White uPVC casement window at a transom, the opening sash standing proud of the frame above a directly glazed fixed pane',
    ],
    [
        'name' => 'Combinations',
        'copy' => 'All three share one outer frame, so a single window can do more than one job: a fixed centre for the view, openers either side for the air, a top light over a worktop. Transom and mullion positions decide whether the glass lines up across an elevation.',
        'image' => $base . 'casement-three-light-stone-600w.webp',
        'alt' => 'White uPVC three light casement window with Georgian bars in a stone wall',
    ],
];

$versus_rows = [
    ['label' => 'The sash', 'a' => 'Stands proud of the frame', 'b' => 'Closes level with the frame'],
    ['label' => 'Fixed panes', 'a' => 'Glazed into the frame, so more glass', 'b' => 'Matched dummy sash, so equal lines'],
    ['label' => 'Glazing', 'a' => '28mm double or 36mm triple', 'b' => '28mm double'],
    ['label' => 'Whole window U-value', 'a' => '0.95 W/m²K', 'b' => '1.2 W/m²K'],
    ['label' => 'Energy rating', 'a' => 'A+', 'b' => 'A+'],
    ['label' => 'Suits', 'a' => 'Most homes, and the wider specification', 'b' => 'Period and cottage elevations'],
];

$details = [
    ['name' => 'Georgian bars', 'copy' => 'Set inside the sealed unit, so the pane still wipes clean in one pass.', 'image' => $base . 'casement-bay-white-1080w.webp', 'w' => 1080, 'h' => 608, 'alt' => 'White uPVC bay window with Georgian bars set inside the sealed units'],
    ['name' => 'Astragal bars and mock horns', 'copy' => 'Bars bonded to the face of the glass, and horns turned below the sash, the way a period window is finished.', 'image' => $studio . 'cas-mock-horn.webp', 'w' => 1250, 'h' => 857, 'alt' => 'Close up of a mock sash horn and astragal bar on a white uPVC casement window'],
    ['name' => 'Leaded glass', 'copy' => 'Lead laid over the pane in squares or diamonds and sealed against the weather. It never needs polishing.', 'image' => $base . 'casement-leaded-bay-1400w.webp', 'w' => 1400, 'h' => 1120, 'alt' => 'White uPVC bay window with square leaded glass on a red brick house, fitted by Fenster'],
];

$energy_stats = [
    ['figure' => '0.95', 'unit' => 'W/m²K', 'note' => 'Whole window, with the 36mm triple glazed unit'],
    ['figure' => 'A+', 'unit' => 'rated', 'note' => 'On the specification we list'],
    ['figure' => 'Six', 'unit' => 'chambers', 'note' => 'Through every frame section, against four as standard'],
];

$anatomy = [
    ['name' => 'Six chambers', 'copy' => 'Six sealed air pockets run the length of every frame section, and each one interrupts the route heat takes out of the room. This is the difference between the EnergyPlus profile and a standard one, and it is what we fit as standard rather than as an upgrade tier.'],
    ['name' => 'The gasket', 'copy' => 'The weather seal is formed with the profile as it is extruded rather than pushed into a groove afterwards, so it cannot shrink back or work loose at a corner. Corners are where a pushed-in gasket fails first.'],
    ['name' => 'Reinforcement', 'copy' => 'Sized window by window. A large dark sash on an exposed elevation is stiffened differently from a small white one in a sheltered wall, which is a survey decision rather than a catalogue one.'],
    ['name' => 'The sealed unit', 'copy' => 'Panes, coatings, argon fill and a warm edge spacer decide most of the whole window figure. A 28mm double or a 36mm triple, with the triple reaching 0.95 W/m²K. The number we agree follows your glass rather than a brochure.'],
    ['name' => 'The installation', 'copy' => 'Fixing, sealing and finishing are what connect a tested window to your actual wall. Our own installers do it, which is why the ten year guarantee on the work is ours to give.'],
];

$security_points = [
    ['name' => 'Multi-point locking', 'copy' => 'Locking points engage down the sash rather than at the handle alone, so it is held into its seals along its length.'],
    ['name' => 'Reinforced where it counts', 'copy' => 'Reinforcement sized for the individual window. It is what a lock has to pull against, so it is specified with the window rather than assumed.'],
    ['name' => 'PAS 24 and Secured by Design', 'copy' => 'Both available. PAS 24 is the standard Part Q calls for on new dwellings and some extensions, so if your build is covered by it, say so early and we specify to it. Those approvals belong to a tested complete window, not to a profile name.'],
    ['name' => 'Glass that holds', 'copy' => 'Laminated panes stay together when they break. Worth specifying on ground floors and anywhere out of sight from the road.'],
];

// Our own work only. The studio photography carries the rest of the page; proof
// has to be the real thing.
$gallery = [
    ['file' => 'casement-bolbeck-park', 'width' => 1000, 'focus' => '50% 40%', 'caption' => 'Bolbeck Park, Milton Keynes', 'alt' => 'Anthracite Liniar casement windows stacked on a corner elevation in Bolbeck Park, fitted by Fenster'],
    ['file' => 'casement-stone-elevation', 'width' => 1200, 'focus' => '50% 45%', 'caption' => 'A full stone elevation', 'alt' => 'White uPVC casement windows across the front elevation and dormers of a stone house'],
    ['file' => 'casement-anthracite-bay', 'width' => 1600, 'focus' => '50% 45%', 'caption' => 'Anthracite grey bay', 'alt' => 'Anthracite grey uPVC casement bay window with obscured lower panes, fitted by Fenster'],
    ['file' => 'casement-rushden-leaded', 'width' => 1400, 'focus' => '45% 45%', 'caption' => 'Rushden', 'alt' => 'White uPVC casement windows with leaded diamond glazing on a red brick house in Rushden, fitted by Fenster'],
    ['file' => 'casement-stony-stratford', 'width' => 1400, 'focus' => '30% 50%', 'caption' => 'Stony Stratford', 'alt' => 'White uPVC casement windows in a bay on a red brick Victorian terrace in Stony Stratford, fitted by Fenster'],
    ['file' => 'casement-leighton-buzzard', 'width' => 1400, 'focus' => '50% 55%', 'caption' => 'Leighton Buzzard', 'alt' => 'White Liniar casement windows fitted by Fenster across a Leighton Buzzard terrace'],
];

$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'What is the difference between casement and flush casement windows?', 'answer' => 'The sash. On a standard casement it stands slightly proud of the frame, and fixed panes are glazed straight into the frame so they hold more glass. On a flush casement the sash closes level with the frame for a traditional joinery look, with fixed lights matched to the openers so every pane reads the same. Standard takes 28mm double or 36mm triple glazing and reaches 0.95 W/m²K; flush takes 28mm double and reaches 1.2 W/m²K. Both are A+ rated.'],
    ['question' => 'Which Liniar system do you fit?', 'answer' => 'The 70mm Liniar EnergyPlus system in the sculptured profile, a six-chamber uPVC platform used for both replacement and new-build work. Glass, reinforcement and hardware are confirmed for your individual job.'],
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => '0.95 W/m²K, with the 36mm triple glazed unit, which makes it an A+ window. Size, layout, glass and reinforcement all move the complete-window figure, so the number we agree follows your final specification rather than a brochure.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'They can be specified with reinforced frames, multi-point locking and PAS 24 or Secured by Design options. PAS 24 is the standard Part Q calls for on new dwellings and some extensions, so if your build is covered by it, say so early and we will specify to it. Those approvals belong to a tested complete window rather than to the profile name, so we confirm what applies to your configuration.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'Yes. The 70mm frame takes a 28mm double glazed unit or a 36mm triple. Whether triple is worth it depends on the sash size, the weight and what you are actually trying to improve, so we will compare it with you rather than treating it as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Liniar publish around 33 decibels for a standard double glazed unit and up to 37 decibels, rated 37 (-2;-5), where the window is built for acoustics. Reaching the higher figure is the glass doing the work rather than the frame. Pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen foils, plus smooth white as the unfoiled profile. The colour you pick is the external face, with the same colour or smooth white on the inside. Liniar publish a wider foil catalogue, but availability, lead time and cost depend on the exact profile and the fabricator, so we confirm before you order.'],
    ['question' => 'Can I have bars, horns or leaded glass?', 'answer' => 'Yes. Georgian bars sit inside the sealed unit, astragal bars are bonded to the glass face, mock sash horns dress the sash corners, and leaded glass comes in squares or diamonds. All of them are priced with the window rather than added afterwards.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, though an exact copy is not always the best answer. At survey we check escape, ventilation, handle reach, outside clearance and how the sightlines sit before the drawing is signed off.'],
    ['question' => 'What guarantee comes with them?', 'answer' => 'Two separate ones. Liniar guarantee the frame for ten years, and we guarantee our installation for ten years. They cover different things and come from different people, which is worth knowing if something ever needs putting right.'],
    ['question' => 'Are the frames recyclable?', 'answer' => 'Liniar describe their uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire, and independent fabricators make the finished windows.'],
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

<div class="fg-cas">

    <?php /* Overture. One claim, the system named once, one wide photograph. */ ?>
    <section class="fg-cas-overture" aria-labelledby="fg-cas-overture-title">
        <div class="container fg-cas-overture__grid">
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('70mm Liniar EnergyPlus', 'fenster'); ?></p>
                <h2 id="fg-cas-overture-title" class="fg-cas-display"><?php esc_html_e('The window most British homes are built around.', 'fenster'); ?></h2>
            </div>
            <div class="fg-cas-overture__copy">
                <p><?php esc_html_e('A casement is the everyday window: sashes hinged at the side or the top, opening outwards, made to the millimetre for the hole in your wall. It is the most adaptable window there is, which is why one system covers a bathroom light, a full bay and everything in between.', 'fenster'); ?></p>
                <p><?php esc_html_e('We fit one. The 70mm Liniar EnergyPlus profile, sculptured, as standard rather than as an upgrade tier. Everything on this page is that window.', 'fenster'); ?></p>
                <div class="fg-cas-actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                </div>
            </div>
        </div>
        <figure class="fg-cas-bleed">
            <img src="<?php echo esc_url(fenster_generated_url($base . 'casement-house-rear-1600w.webp')); ?>"
                alt="<?php esc_attr_e('Anthracite grey uPVC casement windows across the rear elevation of a house', 'fenster'); ?>"
                loading="lazy" width="1600" height="900">
        </figure>
    </section>

    <?php /* The film, high on the page where a product film belongs. */ ?>
    <section class="fg-cas-film" aria-labelledby="fg-cas-film-title">
        <div class="container fg-cas-film__grid">
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Coming to this page', 'fenster'); ?></p>
                <h2 id="fg-cas-film-title" class="fg-cas-display"><?php esc_html_e('A set of casements, going in.', 'fenster'); ?></h2>
                <p><?php esc_html_e('We are filming a real installation with our own fitters, from the first survey measure to the final wipe-down. No actors and no showroom set. It will play here.', 'fenster'); ?></p>
            </div>
            <figure class="fg-cas-film__media">
                <?php if ($film_src !== '') : ?>
                    <video autoplay muted loop playsinline poster="<?php echo esc_url(fenster_generated_url($base . 'casement-installation-900w.webp')); ?>">
                        <source src="<?php echo esc_url(fenster_generated_url($film_src)); ?>" type="video/mp4">
                    </video>
                <?php else : ?>
                    <img src="<?php echo esc_url(fenster_generated_url($base . 'casement-installation-900w.webp')); ?>"
                        alt="<?php esc_attr_e('Fenster installer fitting a white uPVC casement window frame into a brick opening', 'fenster'); ?>"
                        loading="lazy" width="900" height="600">
                    <span class="fg-cas-chip"><i aria-hidden="true"></i><?php esc_html_e('In production', 'fenster'); ?></span>
                <?php endif; ?>
            </figure>
        </div>
    </section>

    <?php /* ---------- 01 VERSATILITY ---------- */ ?>
    <section class="fg-cas-chapter" aria-labelledby="fg-cas-ch1-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">01</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Versatility', 'fenster'); ?></p>
                <h2 id="fg-cas-ch1-title" class="fg-cas-display"><?php esc_html_e('One system. Every opening in the house.', 'fenster'); ?></h2>
                <p class="fg-cas-lead"><?php esc_html_e('Four ways of opening, two faces, sixteen colours, and the detail that decides whether a window suits a Victorian terrace or a new build. All of it made to measure, none of it an upgrade pack.', 'fenster'); ?></p>
            </div>
        </div>

        <div class="container">
            <div class="fg-cas-styles">
                <?php foreach ($styles as $style) : ?>
                    <article class="fg-cas-style">
                        <figure>
                            <img src="<?php echo esc_url(fenster_generated_url($style['image'])); ?>" alt="<?php echo esc_attr($style['alt']); ?>" loading="lazy" width="1250" height="857">
                        </figure>
                        <h3><?php echo esc_html($style['name']); ?></h3>
                        <p><?php echo esc_html($style['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* Standard against flush, in matched studio photography. */ ?>
    <section class="fg-cas-versus" aria-labelledby="fg-cas-versus-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Two faces', 'fenster'); ?></p>
                    <h2 id="fg-cas-versus-title" class="fg-cas-display"><?php esc_html_e('Standard or flush.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The same 70mm Liniar uPVC, the same sixteen colours, the same fitters. The sash is the difference, and it changes both the look and the glass.', 'fenster'); ?></p>
            </div>

            <div class="fg-cas-versus__pair">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-sash-proud-sq.webp')); ?>" alt="<?php esc_attr_e('White uPVC standard casement window, the opening sash standing proud of the outer frame', 'fenster'); ?>" loading="lazy" width="857" height="857">
                    <figcaption><strong><?php esc_html_e('Standard casement', 'fenster'); ?></strong><span><?php esc_html_e('The sash stands proud. Fixed panes glaze straight into the frame, so they carry more glass.', 'fenster'); ?></span></figcaption>
                </figure>
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-flush-level-sq.webp')); ?>" alt="<?php esc_attr_e('White uPVC flush casement window, four sashes closing level with the frame in one plane', 'fenster'); ?>" loading="lazy" width="857" height="857">
                    <figcaption><strong><?php esc_html_e('Flush casement', 'fenster'); ?></strong><span><?php esc_html_e('Every sash closes level with the frame, in one plane, the way timber joinery sits.', 'fenster'); ?></span></figcaption>
                </figure>
            </div>

            <table class="fg-cas-table">
                <thead>
                    <tr>
                        <th scope="col"><span class="fg-cas-sr"><?php esc_html_e('Specification', 'fenster'); ?></span></th>
                        <th scope="col"><?php esc_html_e('Standard', 'fenster'); ?></th>
                        <th scope="col"><?php esc_html_e('Flush', 'fenster'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($versus_rows as $row) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($row['label']); ?></th>
                            <td><?php echo esc_html($row['a']); ?></td>
                            <td><?php echo esc_html($row['b']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="fg-cas-note"><a class="fg-cas-link" href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>"><?php esc_html_e('See flush casements', 'fenster'); ?></a></p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/upvc-colour-grid', null, ['product_noun' => 'casement window']); ?>

    <section class="fg-cas-detail" aria-labelledby="fg-cas-detail-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Detail', 'fenster'); ?></p>
                    <h2 id="fg-cas-detail-title" class="fg-cas-display"><?php esc_html_e('Bars, horns and lead.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The difference between a replacement window and one that belongs on the house. All three are priced with the window, not added afterwards.', 'fenster'); ?></p>
            </div>
            <div class="fg-cas-trio">
                <?php foreach ($details as $detail) : ?>
                    <figure>
                        <img src="<?php echo esc_url(fenster_generated_url($detail['image'])); ?>" alt="<?php echo esc_attr($detail['alt']); ?>" loading="lazy" width="<?php echo esc_attr((string) $detail['w']); ?>" height="<?php echo esc_attr((string) $detail['h']); ?>">
                        <figcaption><strong><?php echo esc_html($detail['name']); ?></strong><span><?php echo esc_html($detail['copy']); ?></span></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p class="fg-cas-note">
                <a class="fg-cas-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Obscure glass patterns', 'fenster'); ?></a>
                <a class="fg-cas-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('Every colour', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/handle-grid', null, fenster_window_handle_grid_args()); ?>

    <?php /* ---------- 02 ENERGYPLUS ---------- */ ?>
    <section class="fg-cas-energy" aria-labelledby="fg-cas-ch2-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">02</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('EnergyPlus', 'fenster'); ?></p>
                <h2 id="fg-cas-ch2-title" class="fg-cas-display"><?php esc_html_e('Six chambers, and a number to show for them.', 'fenster'); ?></h2>
                <p class="fg-cas-lead"><?php esc_html_e('A standard uPVC profile has four chambers. EnergyPlus has six, running the length of every frame section, each one interrupting the route heat takes out of the room. It is what we specify as standard on every casement we fit.', 'fenster'); ?></p>
            </div>
        </div>

        <div class="container fg-cas-energy__grid">
            <figure class="fg-cas-energy__media">
                <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-profile-cutaway-c.webp')); ?>"
                    alt="<?php esc_attr_e('Cutaway of the six-chamber Liniar EnergyPlus uPVC frame and sash profile', 'fenster'); ?>"
                    loading="lazy" width="1100" height="733">
            </figure>
            <dl class="fg-cas-stats">
                <?php foreach ($energy_stats as $stat) : ?>
                    <div>
                        <dt><span><?php echo esc_html($stat['figure']); ?></span><?php echo esc_html($stat['unit']); ?></dt>
                        <dd><?php echo esc_html($stat['note']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>

        <div class="container">
            <ol class="fg-cas-anatomy" data-fg-anatomy>
                <?php foreach ($anatomy as $i => $item) : ?>
                    <?php $id = 'fg-cas-anatomy-' . $i; ?>
                    <li>
                        <h3>
                            <button type="button" class="fg-cas-anatomy__toggle" data-fg-anatomy-toggle aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($id); ?>">
                                <span class="fg-cas-anatomy__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                <span class="fg-cas-anatomy__name"><?php echo esc_html($item['name']); ?></span>
                                <span class="fg-cas-anatomy__mark" aria-hidden="true"></span>
                            </button>
                        </h3>
                        <div class="fg-cas-anatomy__body" id="<?php echo esc_attr($id); ?>" <?php echo $i === 0 ? '' : 'hidden'; ?>>
                            <p><?php echo esc_html($item['copy']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
            <p class="fg-cas-note fg-cas-note--quiet"><?php esc_html_e('Liniar profiles are lead-free and recyclable at the end of their life, designed, extruded and tested in Derbyshire. The frame carries a ten year Liniar guarantee; our installation carries ten years of ours.', 'fenster'); ?></p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('casement-windows')); ?>

    <?php /* ---------- 03 SECURITY ---------- */ ?>
    <section class="fg-cas-security" aria-labelledby="fg-cas-ch3-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">03</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                <h2 id="fg-cas-ch3-title" class="fg-cas-display"><?php esc_html_e('Held shut along the sash, not at the handle.', 'fenster'); ?></h2>
                <p class="fg-cas-lead"><?php esc_html_e('Security in a window is a system: the lock, what it pulls against, the glass, and the test the finished window passed. A profile name on its own proves none of it.', 'fenster'); ?></p>
            </div>
        </div>
        <div class="container fg-cas-security__grid">
            <figure>
                <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-security-keep.webp')); ?>"
                    alt="<?php esc_attr_e('Steel locking keep and reinforced rebate inside a white uPVC casement window frame', 'fenster'); ?>"
                    loading="lazy" width="1250" height="857">
            </figure>
            <dl class="fg-cas-list">
                <?php foreach ($security_points as $point) : ?>
                    <div>
                        <dt><?php echo esc_html($point['name']); ?></dt>
                        <dd><?php echo esc_html($point['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <?php /* ---------- PROOF ---------- */ ?>
    <section class="fg-cas-proof" aria-labelledby="fg-cas-proof-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-cas-proof-title" class="fg-cas-display"><?php esc_html_e('Casements we have fitted.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cas-proof__desktop"><?php esc_html_e('Every photograph here is a Fenster installation, taken on the day we finished. Click any of them for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cas-proof__mobile"><?php esc_html_e('Every photograph is a Fenster installation. Tap any for a closer look.', 'fenster'); ?></span>
                </p>
            </div>
            <div class="fg-cas-mosaic">
                <?php foreach ($gallery as $index => $image) : ?>
                    <?php
                    $stem = $base . 'gallery/' . $image['file'];
                    $srcset = [
                        fenster_generated_url($stem . '-480w.webp') . ' 480w',
                        fenster_generated_url($stem . '-800w.webp') . ' 800w',
                    ];
                    if ((int) $image['width'] >= 1400) {
                        $srcset[] = fenster_generated_url($stem . '-1400w.webp') . ' 1400w';
                    }
                    $srcset[] = fenster_generated_url($stem . '.webp') . ' ' . (int) $image['width'] . 'w';
                    ?>
                    <figure>
                        <a href="<?php echo esc_url(fenster_generated_url($stem . '.webp')); ?>" data-fg-gallery-lightbox aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $image['alt'])); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($stem . '-800w.webp')); ?>"
                                srcset="<?php echo esc_attr(implode(', ', $srcset)); ?>"
                                sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '46vw' : '23vw'; ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy"
                                style="object-position: <?php echo esc_attr($image['focus']); ?>;">
                            <figcaption><?php echo esc_html($image['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p class="fg-cas-swipe" aria-hidden="true"><?php esc_html_e('Swipe', 'fenster'); ?> <span>&rarr;</span></p>
        </div>
    </section>

</div>

<?php
// The wrapper closes here. Its base type rules are (0,1,1) and would otherwise
// repaint the shared quote, FAQ, enquiry and review components.
?>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Your sizes, your finishes, a real figure in minutes. Survey confirms the layout, glass and hardware before anything is made.', 'fenster'); ?></p>
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

    <script type="application/ld+json"><?php echo wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <section class="fg-product-faq" aria-labelledby="fg-cas-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cas-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('All of these refer to the 70mm Liniar EnergyPlus system on this page.', 'fenster'); ?></p>
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

    <?php if (function_exists('fenster_case_studies_for_product')) : ?>
        <?php $cas_studies = fenster_case_studies_for_product('casement-windows', 3); ?>
        <?php if ($cas_studies !== []) : ?>
            <section class="fg-cs-strip">
                <div class="container">
                    <div class="fg-cs-strip__head">
                        <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Three casement jobs, start to finish.', 'fenster'); ?></h2>
                    </div>
                    <div class="fg-cs-strip__grid">
                        <?php foreach ($cas_studies as $card) : ?>
                            <?php get_template_part('template-parts/components/case-study-card', null, ['card' => $card, 'heading' => 'h3']); ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="button-row fg-cs-strip__cta">
                        <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us about the windows.', 'fenster'); ?></h2>
                <p><?php esc_html_e('How many, what sort of property, and the main reason for replacing them. That is enough to start with.', 'fenster'); ?></p>
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

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--product',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>
