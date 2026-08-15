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

/* The two openers had each other's photograph until 2026-08-05. A friction stay
   is fitted on the members square to the hinge line, so which member carries the
   stay names the window: `cas-stay-open` runs its long track along the head and
   cill with the keep on the jamb, which is a side hung sash, and `cas-hinge-open`
   carries its stay on the jamb, which is a top hung one. Owner caught it; the
   photographs read that way round too. Judge these by the stay, not the filename.

   `focus` is the object-position for the 4/3 crop. It is only set where centring
   cuts the subject: the fixed pane photograph is 820x857, so a centred crop puts
   the transom across the middle and halves the pane the tile is named after.
   Owner instruction, 2026-08-05, to lift the split toward the top. */
$styles = [
    [
        'name' => 'Side hung',
        'copy' => 'Hinged on the stile and held at any angle by a stainless friction stay. Where a bedroom needs its escape route, egress hinges swing the sash to ninety degrees so the clear opening meets the Building Regulations minimum of 0.33m², at least 450mm each way.',
        'image' => $studio . 'cas-stay-open.webp',
        'w' => 1250,
        'h' => 857,
        'alt' => 'Friction stay along the cill of a white uPVC side hung casement, the sash swung open on its stile hinges',
    ],
    [
        'name' => 'Top hung',
        'copy' => 'Hinged in the head with the handle on the bottom rail. The open sash sheds rain clear of the opening, which is why top-hung sashes sit above fixed panes and over kitchen worktops. A restrictor holds the first opening to around 100mm where children sleep.',
        'image' => $studio . 'cas-hinge-open.webp',
        'w' => 1250,
        'h' => 857,
        'alt' => 'Friction stay on the jamb of a white uPVC top hung casement, the sash held open from the head',
    ],
    [
        'name' => 'Fixed pane',
        'copy' => 'No hinges, no gearing, no handle. The glass is bedded straight into the frame, so a fixed pane costs less than an opener the same size and carries a slimmer border and more glass. Ventilation and escape come from the openers around it.',
        'image' => $studio . 'cas-sash-proud-w.webp',
        'w' => 820,
        'h' => 857,
        'focus' => '50% 92%',
        'alt' => 'White uPVC casement window at a transom, the opening sash standing proud of the frame above a directly glazed fixed pane',
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

/* Four dressings, four photographs, each checked at full size before it was
   labelled. The bay bars are Georgian: the reflection of the street runs
   straight over them, so they are inside the sealed unit. The brick bay bars
   are astragal: moulded, standing proud of the glass and casting a shadow. */
$details = [
    /* Owner's photograph, 2026-08-05, and checked the same way the wrong one was
       caught: at full size the obscured glass stipple runs unbroken across the
       faces of the bars, so they are behind the glass surface inside the sealed
       unit. No moulding, no step, no shadow. That is this tile's own copy, and
       the opposite of the astragal tile below it.

       Note the filename is reused. `casement-georgian-bar-900w` previously held
       a crop of `casement-bay-white-1080w` whose bars carried a highlight and a
       cast shadow, so they sat on the face of the glass: astragal, not a bar
       inside the unit, which is why this slot held a placeholder. Nothing else
       referenced it, so the name now holds a photograph that matches it.

       Shot on a phone on its side and rotated upright, then cropped from the
       whole bathroom window to the bar cross on the left sash, keeping the sash
       stile and handle for structure and leaving the sill, the bath and the
       towel rail out. 980x734 of the original down to 900x675, so a downscale,
       at the astragal tile's ratio. */
    ['name' => 'Georgian bars', 'copy' => 'An 18mm flat bar inside the sealed unit, colour matched to the frame. The pane still wipes clean.', 'image' => $base . 'casement-georgian-bar-900w.webp', 'w' => 900, 'h' => 675, 'alt' => 'Georgian bars set inside the sealed unit of a white uPVC casement window, the obscured glass reading unbroken across the bars'],
    ['name' => 'Astragal bars', 'copy' => 'A moulded bar bonded to the face of the glass, so it catches the light and throws a shadow.', 'image' => $base . 'casement-astragal-bar-900w.webp', 'w' => 900, 'h' => 675, 'alt' => 'Close up of moulded astragal bars standing proud of the glass on a white uPVC bay window'],
    /* The horn photograph was wrong until 2026-08-05: `casement-mock-horn-900w`
       is a studio shot of a mullion meeting the cill and shows no horn at all.
       So are `casement-astragal-horn-1250w` and `studio/cas-mock-horn` — all
       three are the same subject under three names, so pick by looking, not by
       filename. This one is the only asset in the theme that actually shows
       horns: the curved projections on the bottom corners of the open sashes.
       It is 600x600 and the trio crops to 4/3, which keeps both of them. */
    ['name' => 'Mock sash horns', 'copy' => 'Turned on the bottom corners of the sash, the way a period sash window was always finished.', 'image' => $base . 'casement-mockhorn-detail-600w.webp', 'w' => 600, 'h' => 600, 'alt' => 'Mock sash horns turned on the bottom corners of open white uPVC casement sashes'],
    ['name' => 'Leaded glass', 'copy' => 'Lead laid over the pane in diamonds or squares, then sealed into the unit against the weather.', 'image' => $base . 'casement-diamond-lead-900w.webp', 'w' => 900, 'h' => 660, 'alt' => 'Diamond leaded glass in a white uPVC casement window, fitted by us in Rushden'],
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
    /* Owner instruction, 2026-08-05: security is the whole window, not the
       mechanism with the glass as a footnote. So the lock keeps its place as one
       part of five rather than a branded headline of its own, what it pulls
       against is a point in its own right, and the glass is named for what it
       actually does instead of trailing at the end as an upsell. The Kenrick
       test figures live in the guarantee point; they are Kenrick's figures for a
       mechanism, and the approval point says what belongs to a whole tested
       window. */
    ['name' => 'Multi-point locking as standard', 'copy' => 'Not an upgrade. The Kenrick Excalibur strip runs the length of the sash, and one turn of the handle throws steel shoot bolts into the frame and bi-directional claws into keeps down the sash edge, so the window is held into its seals along its whole length rather than at the handle.'],
    ['name' => 'The frame it pulls against', 'copy' => 'A lock is only as good as what it is fixed into. Reinforcement is sized window by window, because a large dark sash on an exposed elevation is stiffened differently from a small one in a sheltered wall.'],
    ['name' => 'The glass does half the work', 'copy' => 'A laminated pane has a bonded interlayer, so it holds together instead of breaking through. That is the difference between a broken window and an open one, and it is the upgrade we would point at first on a ground floor or any window out of sight from the road.'],
    ['name' => 'Tested, and guaranteed ten years', 'copy' => 'Kenrick test the mechanism to 100,000 opening cycles and 240 hours of salt spray, beyond what BS EN 1670 asks, and guarantee it for ten years.'],
    ['name' => 'PAS 24 and Secured by Design', 'copy' => 'Both available. PAS 24 is what Part Q calls for on new dwellings and some extensions, so tell us early if your build is covered. The approval belongs to a tested complete window, not to a profile name or a lock on its own.'],
];
/* Kenrick's own published figures for the Excalibur, taken from
   kenricks.co.uk/products/window-hardware/excalibur on 2026-08-04. They belong
   to the mechanism, not to our finished window, which is why the PAS 24 line
   says capable rather than certified: the approval sits with a tested complete
   window and the security list below already makes that distinction. Do not
   restate any of these as a Fenster figure. */
// Our own work only. The studio photography carries the rest of the page; proof
// has to be the real thing.
/* Our own installations only. The stone elevation that used to sit here is
   Liniar photography of a job that is not ours; it carries the overture now,
   where nothing claims it. The Leighton Buzzard frame is cropped to the
   downstairs window because the upstairs windows on that terrace are not ours.
   Every tag below is read off its own photograph. */
$gallery = [
    ['file' => 'casement-bolbeck-park', 'width' => 1000, 'focus' => '50% 40%', 'caption' => 'Bolbeck Park, Milton Keynes', 'tags' => ['Anthracite grey', 'Two-storey bay', 'Top opening sashes'], 'alt' => 'Anthracite Liniar casement windows stacked over two floors on a corner elevation in Bolbeck Park, fitted by us'],
    ['file' => 'casement-anthracite-bay', 'width' => 1600, 'focus' => '50% 45%', 'caption' => 'Anthracite grey bay', 'tags' => ['Anthracite grey', 'Splayed bay', 'Obscure glass'], 'alt' => 'Anthracite grey uPVC casement bay window with obscured lower panes, fitted by us'],
    ['file' => 'casement-rushden-leaded', 'width' => 1400, 'focus' => '45% 45%', 'caption' => 'Rushden', 'tags' => ['White', 'Diamond lead', 'Side hung openers'], 'alt' => 'White uPVC casement windows with diamond leaded glazing on a red brick house in Rushden, fitted by us'],
    ['file' => 'casement-stony-stratford', 'width' => 1400, 'focus' => '30% 50%', 'caption' => 'Stony Stratford', 'tags' => ['White', 'Splayed bay', 'Top opening sashes'], 'alt' => 'White uPVC casement windows in a bay on a red brick Victorian terrace in Stony Stratford, fitted by us'],
    ['file' => 'casement-leighton-downstairs', 'width' => 490, 'focus' => '50% 50%', 'caption' => 'Leighton Buzzard', 'tags' => ['White', 'Fixed pane and opener', 'Tile-hung elevation'], 'alt' => 'White Liniar casement window with a wide fixed pane and a side hung opener on a tile hung terrace in Leighton Buzzard, fitted by us'],
];
$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'What is the difference between casement and flush casement windows?', 'answer' => 'The sash. On a standard casement it stands slightly proud of the frame, and fixed panes are glazed straight into the frame so they hold more glass. On a flush casement the sash closes level with the frame for a traditional joinery look, with fixed panes matched to the openers so every pane reads the same. Standard takes 28mm double or 36mm triple glazing and reaches 0.95 W/m²K; flush takes 28mm double and reaches 1.2 W/m²K. Both are A+ rated.'],
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

// FAQPage markup comes from the shared emitter in `inc/generated-pages.php`.
// Seven separate copies of this block existed across the theme until
// 2026-08-15, which is seven places for the shape to drift and five that
// had already been missed when the schema itself needed changing.
?>

<div class="fg-cas">

    <?php
    /* ---------- The stack begins ---------------------------------------------
       The opening is the base plate: it anchors, and chapter 01 rises over it,
       so 01 behaves like 02 and 03 rather than arriving in ordinary flow.
       Without something beneath it there is nothing for it to cover.

       The plate is deliberately "the opening", whatever the opening happens to
       contain, rather than one named section. Today that is the overture alone.
       When the installation film is delivered it joins this same panel instead
       of becoming a second plate, because two plates here put two covers on top
       of one another: measured at 1280x900, the film's own cover ran from 258 to
       1071 while chapter 01's began at 737, so 334px of scrolling had both
       running at once. One plate, one cover, whatever the opening holds.

       The page still has a normal-scrolling run-up before any of this: the
       shared hero and the four-tile specification strip render above this
       partial and are untouched.

       See the block in main.scss for how the sticky offset is derived and why
       every panel after the first has to be opaque. ---------------------- */
    ?>
    <div class="fg-cas-stack" data-fg-chapter-stack>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--opening">

    <?php /* Overture. One claim, the system named once, one wide photograph. */ ?>
    <section class="fg-cas-overture" aria-labelledby="fg-cas-overture-title">
        <div class="container fg-cas-overture__grid">
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('70mm Liniar EnergyPlus', 'fenster'); ?></p>
                <h2 id="fg-cas-overture-title" class="fg-cas-display"><?php esc_html_e('The window most British homes are built around.', 'fenster'); ?></h2>
            </div>
            <div class="fg-cas-overture__copy">
                <p><?php esc_html_e('A casement is the everyday window: sashes hinged at the side or the top, opening outwards, made to the millimetre for the hole in your wall. It is the most adaptable window there is, which is why one system covers a bathroom window, a full bay and everything in between.', 'fenster'); ?></p>
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
            <img src="<?php echo esc_url(fenster_generated_url($base . 'gallery/casement-stone-elevation.webp')); ?>"
                alt="<?php esc_attr_e('White uPVC casement windows across the front elevation and dormers of a stone house', 'fenster'); ?>"
                loading="lazy" width="1200" height="803">
        </figure>
    </section>

    <?php
    /* The film band. Owner instruction, 2026-08-05: the placeholder comes off the
       page for now. The slot itself is kept rather than deleted, because it is
       reserved work and `$film_src` at the top of this file is already the switch
       for it; set that to a theme path and the band returns here, inside the
       opening plate, and plays the mp4 in the same frame.

       With no source there is nothing to show but an "In production" chip, which
       is the placeholder that was asked to go, so the whole section is gated
       rather than the video element alone. */
    ?>
    <?php if ($film_src !== '') : ?>
        <section class="fg-cas-film" aria-labelledby="fg-cas-film-title">
            <div class="container fg-cas-film__grid">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('On this page', 'fenster'); ?></p>
                    <h2 id="fg-cas-film-title" class="fg-cas-display"><?php esc_html_e('A set of casements, going in.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('A real installation with our own fitters, from the first survey measure to the final wipe-down. No actors and no showroom set.', 'fenster'); ?></p>
                </div>
                <figure class="fg-cas-film__media">
                    <video autoplay muted loop playsinline poster="<?php echo esc_url(fenster_generated_url($base . 'casement-installation-900w.webp')); ?>">
                        <source src="<?php echo esc_url(fenster_generated_url($film_src)); ?>" type="video/mp4">
                    </video>
                </figure>
            </div>
        </section>
    <?php endif; ?>

    </div><?php /* end the opening plate */ ?>

    <?php
    /* ---------- The three chapters ---------------------------------------------
       01, 02 and 03 read as physical panels: each one anchors at the foot of the
       viewport once you have scrolled through it, and the next slides up over it.
       Security is the last plate, and the page returns to ordinary scrolling under
       it.

       A panel is a chapter AND the sections it owns, because the chapters are not
       adjacent in the flow: 02 owns the EnergyPlus tech banner that closes it.
       Keep a chapter and the sections it introduces in one panel — split a chapter
       from its own run and the covering sequence breaks.

       01 is now only the ways the window opens, which is what its own heading
       says. The dressings, the two faces and the finishes all sit below the stack
       and scroll normally; they carry their own section heads. Three plates is the
       whole device, and the number of them is deliberate: the stack is for the
       three things that carry an argument, not for everything on the page.
       ------------------------------------------------------------------- */
    ?>
    <div class="fg-cas-stack__panel fg-cas-stack__panel--versatility">

    <?php /* ---------- 01 VERSATILITY ---------- */ ?>
    <section class="fg-cas-chapter" aria-labelledby="fg-cas-ch1-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">01</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Versatility', 'fenster'); ?></p>
                <h2 id="fg-cas-ch1-title" class="fg-cas-display"><?php esc_html_e('One system. Every opening in the house.', 'fenster'); ?></h2>
                <p class="fg-cas-lead"><?php esc_html_e('Three ways of opening and any combination of them, in one outer frame, at any size we can make. Every window is drawn for the opening it goes into rather than picked from a catalogue.', 'fenster'); ?></p>
            </div>
        </div>

        <div class="container">
            <div class="fg-cas-styles">
                <?php foreach ($styles as $style) : ?>
                    <article class="fg-cas-style">
                        <figure>
                            <img src="<?php echo esc_url(fenster_generated_url($style['image'])); ?>" alt="<?php echo esc_attr($style['alt']); ?>" loading="lazy" width="<?php echo esc_attr((string) $style['w']); ?>" height="<?php echo esc_attr((string) $style['h']); ?>"<?php if (! empty($style['focus'])) : ?> style="object-position: <?php echo esc_attr($style['focus']); ?>"<?php endif; ?>>
                        </figure>
                        <h3><?php echo esc_html($style['name']); ?></h3>
                        <p><?php echo esc_html($style['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
        /* Combinations is not a fourth opening style, it is what you get from
           mixing the three, so it reads as a band rather than a fourth card.
           That also keeps the three studio photographs above as one matched
           set instead of putting an elevation shot among them. */
        ?>
        <div class="container fg-cas-combi">
            <figure>
                <img src="<?php echo esc_url(fenster_generated_url($base . 'casement-house-rear-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Anthracite grey uPVC casement windows in several different configurations across the rear elevation of a house', 'fenster'); ?>"
                    loading="lazy" width="1600" height="900">
            </figure>
            <div>
                <h3><?php esc_html_e('And any combination of the three.', 'fenster'); ?></h3>
                <p><?php esc_html_e('This is where the range stops being a list. Openers and fixed panes share one outer frame, in any arrangement, at any size we can make: a fixed centre with openers either side, a run of top openers over a worktop, a three pane window, a splayed bay, a bow, a dormer. Transom and mullion positions are drawn for your opening rather than picked from a catalogue.', 'fenster'); ?></p>
                <p><?php esc_html_e('There is no standard size and no fixed set of layouts. Every window is drawn, made and priced for the hole it goes into, which is why one system covers the whole house.', 'fenster'); ?></p>
            </div>
        </div>
    </section>

    </div><?php /* end panel 01 */ ?>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--energy">

    <?php /* ---------- 02 ENERGYPLUS ---------- */ ?>
    <section class="fg-cas-energy" aria-labelledby="fg-cas-ch2-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">02</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('EnergyPlus', 'fenster'); ?></p>
                <h2 id="fg-cas-ch2-title" class="fg-cas-display"><?php esc_html_e('Energy efficiency starts in the frame.', 'fenster'); ?></h2>
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

    </div><?php /* end panel 02 */ ?>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--security">

    <?php /* ---------- 03 SECURITY ---------- */ ?>
    <section class="fg-cas-security" aria-labelledby="fg-cas-ch3-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true">03</span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                <h2 id="fg-cas-ch3-title" class="fg-cas-display"><?php esc_html_e('Secure as standard, and tested to prove it.', 'fenster'); ?></h2>
                <p class="fg-cas-lead"><?php esc_html_e('Security in a window is a system: the lock, what it pulls against, the glass, and the test the finished window passed. A profile name on its own proves none of it.', 'fenster'); ?></p>
            </div>
        </div>
        <?php /* Images left, copy right, which is the arrangement the owner
                 preferred. The mechanism and the keep share the media column so
                 the chapter reads as one band rather than a branded feature
                 followed by a list. */ ?>
        <div class="container fg-cas-security__grid">
            <div class="fg-cas-security__media">
                <?php /* Kenrick's studio photograph with the backdrop and its drop
                         shadow cut away, so the part floats on the band. The shadow
                         stays in CSS, not baked into the file, or it cannot sit on
                         any other colour. The arrival rides the wrapper and the
                         drift the image inside it, so the two never share a
                         transform. */ ?>
                <div class="fg-cas-lock__stage" data-fg-depth="0.15">
                    <div class="fg-cas-lock__arrive" data-fg-lock-arrive>
                        <img class="fg-cas-lock__art"
                            src="<?php echo esc_url(fenster_generated_url($studio . 'cas-kenrick-excalibur.webp')); ?>"
                            srcset="<?php echo esc_attr(fenster_generated_url($studio . 'cas-kenrick-excalibur-640w.webp') . ' 640w, ' . fenster_generated_url($studio . 'cas-kenrick-excalibur.webp') . ' 1100w'); ?>"
                            sizes="(max-width: 860px) 76vw, 460px"
                            alt="<?php esc_attr_e('Kenrick Excalibur multi-point window lock, showing the die-cast gearbox, the square spindle hole, the claws and the steel shoot bolts', 'fenster'); ?>"
                            loading="lazy" width="1100" height="1182">
                    </div>
                </div>
                <?php /* Named here rather than as a heading. The mechanism is one of
                         five things that make the window secure, not the subject of
                         the chapter. */ ?>
                <p class="fg-cas-security__caption"><?php esc_html_e('Kenrick Excalibur multi-point mechanism', 'fenster'); ?></p>
                <figure class="fg-cas-lock__keep">
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-security-keep.webp')); ?>"
                        alt="<?php esc_attr_e('Steel locking keep and reinforced rebate inside a white uPVC casement window frame', 'fenster'); ?>"
                        loading="lazy" width="1250" height="857">
                    <figcaption><?php esc_html_e('The keep it locks into', 'fenster'); ?></figcaption>
                </figure>
            </div>
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

    </div><?php /* end panel 03 */ ?>

    </div><?php /* end .fg-cas-stack — security is the last plate */ ?>

    <?php
    /* ---------- Everything below scrolls normally --------------------------------
       Owner instruction, 2026-08-05 (evening): the 04 and 05 chapter heads come
       off, and these sections stop stacking.

       They were numbered chapters on their own plates for half a day. The stack
       is a device for the three things that carry an argument — how it opens, how
       warm it is, how secure it is — and the choosing that follows reads better at
       ordinary pace than pinned under it. Ending the stack on security also gives
       the dark band a proper close instead of a light plate sliding over it.

       Their own section heads carry them from here, which is what the rest of the
       site already does: Detail / Bars, horns and lead, then Two faces / Standard
       or flush, then the three finishes components with headings of their own.
       Those are untouched. Nothing below this line is inside `.fg-cas-stack`, so
       no sticky, no z-index ladder and no dim overlay applies to any of it.

       The chapter numbers therefore run 01, 02, 03 and stop, which is the whole
       set: there is no 04 or 05 to be missing. ----------------------------- */
    ?>

    <?php /* Owner instruction, 2026-08-05: the detail runs before the two faces.
             It reads as the closer of the two, so the chapter opens on how the
             window is put together and closes on which face it wears. */ ?>
    <section class="fg-cas-detail" aria-labelledby="fg-cas-detail-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Detail', 'fenster'); ?></p>
                    <h2 id="fg-cas-detail-title" class="fg-cas-display"><?php esc_html_e('Bars, horns and lead.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The difference between a replacement window and one that belongs on the house. All four are priced with the window, not added afterwards.', 'fenster'); ?></p>
            </div>
            <div class="fg-cas-trio">
                <?php foreach ($details as $detail) : ?>
                    <figure>
                        <?php if ($detail['image'] !== '') : ?>
                            <img src="<?php echo esc_url(fenster_generated_url($detail['image'])); ?>" alt="<?php echo esc_attr($detail['alt']); ?>" loading="lazy" width="<?php echo esc_attr((string) $detail['w']); ?>" height="<?php echo esc_attr((string) $detail['h']); ?>">
                        <?php else : ?>
                            <?php /* Holding the slot rather than dropping the tile: the
                                     option is real and sold, only the photograph is
                                     missing. Dashed and labelled so it reads as
                                     deliberate rather than as a failed image. */ ?>
                            <p class="fg-cas-trio__placeholder"><?php esc_html_e('Photograph to follow', 'fenster'); ?></p>
                        <?php endif; ?>
                        <figcaption><strong><?php echo esc_html($detail['name']); ?></strong><span><?php echo esc_html($detail['copy']); ?></span></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p class="fg-cas-note">
                <a class="fg-cas-link" href="<?php echo esc_url(home_url('/obscured-glass/')); ?>"><?php esc_html_e('Obscure glass patterns', 'fenster'); ?></a>
                <a class="fg-cas-link" href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('Every colour', 'fenster'); ?></a>
                <a class="fg-cas-link" href="<?php echo esc_url(home_url('/handle-options/')); ?>"><?php esc_html_e('Handle options', 'fenster'); ?></a>
            </p>
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

            <div class="fg-cas-versus__body">
            <div class="fg-cas-versus__pair">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-sash-proud-w.webp')); ?>" alt="<?php esc_attr_e('White uPVC standard casement window, the opening sash standing proud of the outer frame', 'fenster'); ?>" loading="lazy" width="820" height="857">
                    <figcaption><strong><?php esc_html_e('Standard casement', 'fenster'); ?></strong><span><?php esc_html_e('The sash stands proud. Fixed panes glaze straight into the frame, so they carry more glass.', 'fenster'); ?></span></figcaption>
                </figure>
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-flush-level-w.webp')); ?>" alt="<?php esc_attr_e('White uPVC flush casement window, four sashes closing level with the frame in one plane', 'fenster'); ?>" loading="lazy" width="820" height="857">
                    <?php /* Owner instruction, 2026-08-05: the link belongs in the
                             flush card rather than at the foot of the section, where
                             it read as a footnote to the comparison instead of the
                             way on from the half of it people are choosing. */ ?>
                    <figcaption><strong><?php esc_html_e('Flush casement', 'fenster'); ?></strong><span><?php esc_html_e('Every sash closes level with the frame, in one plane, the way timber joinery sits.', 'fenster'); ?></span><a class="fg-cas-link fg-cas-versus__link" href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>"><?php esc_html_e('See flush casements', 'fenster'); ?></a></figcaption>
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
            </div>
        </div>
    </section>

    <?php /* Colour, handles and glass. Each component carries its own heading, so
             they need nothing above them now the 05 head has gone. */ ?>
    <?php get_template_part('template-parts/components/upvc-colour-grid', null, ['product_noun' => 'casement window']); ?>
    <?php get_template_part('template-parts/components/handle-grid', null, fenster_window_handle_grid_args()); ?>
    <?php get_template_part('template-parts/components/privacy-glass-card'); ?>

    <?php /* ---------- PROOF ---------- */ ?>
    <section class="fg-cas-proof" aria-labelledby="fg-cas-proof-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-cas-proof-title" class="fg-cas-display"><?php esc_html_e('Casements, fitted by us.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cas-proof__desktop"><?php esc_html_e('Every photograph here is one of our installations, taken on the day we finished. Click any of them for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cas-proof__mobile"><?php esc_html_e('Every photograph is one of our installations. Tap any for a closer look.', 'fenster'); ?></span>
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
                            <figcaption>
                                <strong><?php echo esc_html($image['caption']); ?></strong>
                                <span class="fg-cas-tags">
                                    <?php foreach ((array) $image['tags'] as $tag) : ?>
                                        <i><?php echo esc_html($tag); ?></i>
                                    <?php endforeach; ?>
                                </span>
                            </figcaption>
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

    <?php fenster_render_faq_page_schema($faqs); ?>
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
        <?php
        /* THE HEADING FOLLOWS THE MATCH, 2026-08-13. `fenster_case_studies_for_
           product()` falls back to every study when nothing claims this route,
           and "Three casement jobs" is a promise those three are casement work.
           The helper now reports which case it handed back, so the honest
           heading is chosen rather than the strip being gated off. Same wording
           as the shared strip in generated-page.php. */
        $cas_case_is_fallback = false;
        $cas_studies = fenster_case_studies_for_product('casement-windows', 3, 'residential', $cas_case_is_fallback);
        ?>
        <?php if ($cas_studies !== []) : ?>
            <section class="fg-cs-strip">
                <div class="container">
                    <div class="fg-cs-strip__head">
                        <?php if ($cas_case_is_fallback) : ?>
                            <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Recent work across the range.', 'fenster'); ?></h2>
                            <p><?php esc_html_e('Jobs we have finished recently, fitted by our own installers and photographed the day we finished. They cover the range rather than this product.', 'fenster'); ?></p>
                        <?php else : ?>
                            <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Three casement jobs, start to finish.', 'fenster'); ?></h2>
                        <?php endif; ?>
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
