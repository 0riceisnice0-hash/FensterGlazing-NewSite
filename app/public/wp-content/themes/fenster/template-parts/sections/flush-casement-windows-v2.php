<?php
/**
 * Flush casement windows: the bespoke page.
 *
 * Rebuilt 2026-08-06 on the owner's brief. The route had been running on the
 * generic generated-page template, which is why it read as generated: templated
 * headings ("More information on Flush Casement Windows"), a specification strip
 * with a non-fact in it, and a photo set that included two aluminium windows and
 * an interior shot that cannot show the one thing this product does.
 *
 * This replaces the MIDDLE of the generic template and nothing else — owner,
 * 2026-08-06, "just change the middle". The hero, the specification strip, the
 * technology banner and the whole tail from the specification choices down are
 * the shared ones every product page gets. What this stands in for is
 * `fg-product-why`, `fg-product-intel` and `fg-product-visuals`, which are gated
 * off for this slug in generated-page.php. It is NOT an early return like
 * casement, which owns its own tail; do not turn it into one.
 *
 * Built on `.fg-cw`, the split-section grammar the heritage door page and the
 * lift-and-slide component already share, rather than a third layout of its own.
 * Deliberately NOT the casement page's stacked chapters: the owner wants that
 * device to stay unique to casement.
 *
 * The order is the order the decision gets made in:
 *   does it suit my house             -> period, then the sash line up close
 *   is it any good                    -> performance and security, Liniar's figures
 *   how does it differ from standard  -> the comparison, flush-first, with the
 *                                        slider inside it
 *   have you actually fitted them     -> our own work
 *
 * The slider is deliberately late. The selling point is the flat sash face, not
 * "compare it with the other one", and opening on a comparison framed the whole
 * product as a variant of something else.
 *
 * Every figure here is Liniar's published specification for the 70mm flush sash:
 * 1.2 W/m²K whole window, A+, 28mm double glazed unit, PAS 24 and Secured by
 * Design, Part Q compliant, 35 (-1;-4) acoustic, six chambers on the EnergyPlus
 * outer frame, patented co-extruded bubble gasket. Two things this system does
 * NOT do, both of which have already caused trouble on this page: it takes no
 * triple glazed unit, and we do not offer mechanical jointing on it. Liniar
 * publish mechanical jointing for the profile; that is their capability, not
 * ours. Do not reinstate either without asking the owner.
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
$base = '/wp-content/themes/fenster/assets/images/products/flush-casement/';
$casement = esc_url(home_url('/casement-windows/'));
$colour_link = home_url('/colour-options/?material=upvc');

/* Flush first, standard second: the reverse of the casement page's table, which
   runs standard first because standard is its subject. Same six rows, same
   figures, read from the other side. */
$versus_rows = [
    ['label' => 'The sash', 'a' => 'Closes level with the frame', 'b' => 'Stands proud of the frame'],
    ['label' => 'Fixed panes', 'a' => 'Matched dummy sash, so every pane reads the same', 'b' => 'Glazed into the frame, so more glass'],
    ['label' => 'Glazing', 'a' => '28mm double', 'b' => '28mm double, or 36mm triple'],
    /* This row read as if flush were the colder window. It gave flush its double
       glazed figure and standard its TRIPLE glazed one, which is not a
       comparison — like for like on 28mm double both are 1.2 W/m²K, and the 0.95
       is what standard reaches only because it takes a triple unit and flush does
       not. Stating both figures on the standard side is the honest way to show an
       advantage that is real but conditional. */
    ['label' => 'Whole window U-value', 'a' => '1.2 W/m²K', 'b' => '1.2 W/m²K, or 0.95 with triple'],
    ['label' => 'Energy rating', 'a' => 'A+', 'b' => 'A+'],
    ['label' => 'Suits', 'a' => 'Period frontages, and modern elevations wanting a flatter line', 'b' => 'Most homes, and the wider specification'],
];

/* Customer first, the figure second. These were headed "Six chambers in the outer
   frame" and "35 decibels of sound reduction", which is what the window has
   rather than what it does for the person paying for it. Same facts, same
   figures, told from the other end. Copy lengths are deliberately close so the
   four cards sit level. */
$performance = [
    ['name' => 'The room holds its heat', 'copy' => 'Six sealed chambers run through the frame instead of the usual four, and each one interrupts the route warmth takes out of the room. It is the same EnergyPlus platform we fit on the standard casement.'],
    ['name' => 'No draught at the corners', 'copy' => 'The weather seal is formed with the frame rather than pushed into a groove afterwards, so it runs unbroken around every corner. Corners are where a pushed-in seal lets go first, usually a few winters in.'],
    ['name' => 'A+ rated, and 1.2 W/m²K', 'copy' => 'Whole window, on the 28mm double glazed unit this system takes. Size, layout and glass all move the real figure, so the number we agree follows your actual windows rather than a brochure.'],
    ['name' => 'Quieter rooms on a busy road', 'copy' => 'Liniar publish 35 decibels of sound reduction for this frame. If noise is the reason you are replacing the windows, say so at survey: the glass does most of that work and it is specified differently.'],
];

$security = [
    ['name' => 'Held shut along the whole sash', 'copy' => 'One turn of the handle throws locking points down the full edge of the sash, so the window is held into its seals along its length rather than at the handle alone. That is standard on every one we fit, not an upgrade.'],
    ['name' => 'Glass that holds together', 'copy' => 'A laminated pane has a bonded interlayer, so it stays in one piece instead of breaking through. It is the first thing we would suggest on a ground floor window, or any window out of sight from the road.'],
    ['name' => 'Tested, and certified if you need it', 'copy' => 'Available to PAS 24 and Secured by Design, which is what building control asks for on a new dwelling and some extensions. Tell us early if your build is covered and we will specify to it from the start.'],
];

/* Our own installations, every one 4:3 so the rows sit square rather than
   ragged. Chosen for variation as much as quality: three colours, a period
   frontage, a bay, a modern elevation and one close enough to read the sash
   line. Two come from case studies — the Green Man and Leighton Buzzard — which
   are the best-photographed flush jobs we have and were not being used here at
   all. */
$gallery = [
    ['file' => 'g-green-man-bay.webp', 'caption' => 'The Green Man, Eversholt', 'alt' => 'White flush casement windows and a bay on the period frontage of The Green Man at Eversholt'],
    ['file' => 'g-wolverton-black.webp', 'caption' => 'Black, on white brick', 'alt' => 'Black flush casement windows standing open on a white painted brick elevation in Wolverton'],
    ['file' => 'g-cream-bars.webp', 'caption' => 'Cream, with Georgian bars', 'alt' => 'Cream flush casement window with Georgian bars in a buff brick elevation'],
    ['file' => 'g-white-detail.webp', 'caption' => 'The sash line, up close', 'alt' => 'White flush casement window in red brick, the sashes closing level with the outer frame'],
    ['file' => 'g-leighton.webp', 'caption' => 'Leighton Buzzard', 'alt' => 'White flush casement window in a pebbledashed elevation in Leighton Buzzard'],
    ['file' => 'g-white-bay.webp', 'caption' => 'A bay, built in flush sashes', 'alt' => 'White flush casement bay window on a tile hung house'],
];
?>

<div class="fg-cw fg-flush">

    <?php /* ---------- Where it fits: both halves of the market ----------------
             The page opens on what the window is and who it suits, not on how it
             differs from a standard casement. Owner, 2026-08-06: the selling
             point is the flat sash face, not "compare it with the other one", so
             the slider moved down to the comparison where somebody is actually
             choosing between two things. Opening on it framed the whole product
             as a variant of something else. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-flush-period-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Where it fits', 'fenster'); ?></p>
                <h2 id="fg-flush-period-title"><?php esc_html_e('The window a period frontage asks for.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A flat sash face is how timber windows were made, so on a cottage, a stone frontage or a Victorian terrace a flush casement reads as joinery from the pavement where a standard casement reads as replacement. That is the whole reason the style exists, and it is why conservation officers tend to be easier about it.', 'fenster'); ?></p>
                <p><?php esc_html_e('Georgian bars, astragal bars and the heritage colours all belong to that argument. Cream and Chartwell Green do more for a period elevation than white does, and they cost the same to fit.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Reads as painted joinery rather than replacement uPVC', 'fenster'); ?></li>
                    <li><?php esc_html_e('Cream, Chartwell Green, Irish Oak and the woodgrain foils', 'fenster'); ?></li>
                    <li><?php esc_html_e('Georgian or astragal bars where the frontage had them', 'fenster'); ?></li>
                </ul>
            </div>
            <figure class="fg-cw-media">
                <img src="<?php echo esc_url(fenster_generated_url($base . 'flush-stone-cottage-1400w.webp')); ?>"
                    alt="<?php esc_attr_e('White flush casement windows in the stone frontage of a cottage', 'fenster'); ?>"
                    loading="lazy" width="1400" height="1050">
                <figcaption><?php esc_html_e('Stone cottage frontage', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-cw-intro" aria-labelledby="fg-flush-modern-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media">
<?php /* This section says the window is not only for period houses, and was
         illustrated with a Victorian red brick frontage, which argued the
         opposite. It is a modern elevation now. */ ?>
                <?php /* Third image in this slot. The first argued against its own
                         heading by showing a Victorian frontage; the second was a
                         phone shot taken at a steep angle that needed a 9.5 degree
                         rotation to stand up, and still read as leaning. This one
                         is square to the wall straight out of the camera at
                         4032x3024 — no rotation, no correction. */ ?>
                <img src="<?php echo esc_url(fenster_generated_url($base . 'flush-modern-black-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Black flush casement windows and a door in a white painted brick extension, with a black flush bay above', 'fenster'); ?>"
                    loading="lazy" width="1600" height="1200">
                <figcaption><?php esc_html_e('Black, on a white brick extension', 'fenster'); ?></figcaption>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('And the other half', 'fenster'); ?></p>
                <h2 id="fg-flush-modern-title"><?php esc_html_e('It is not only a period window.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Half the flush casements we fit go onto elevations with nothing period about them. A flat sash in anthracite or black brown against white render gives a crisp, modern line that a stepped sash cannot, because there is no shadow running around every opener to break it up.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is the same argument as the cottage, arriving from the other direction: the flat face is quieter, and quiet suits a plain elevation as much as it suits an old one.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('Anthracite, black brown and the greys, inside and out', 'fenster'); ?></li>
                    <li><?php esc_html_e('The inside face specified separately from the outside', 'fenster'); ?></li>
                    <li><?php esc_html_e('One flat plane, with no shadow line around the openers', 'fenster'); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <?php /* ---------- Performance, on Liniar's published figures ---------- */ ?>
    <section class="fg-flush-band" aria-labelledby="fg-flush-perf-title">
        <div class="container">
            <div class="fg-flush-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Performance', 'fenster'); ?></p>
                    <h2 id="fg-flush-perf-title"><?php esc_html_e('It looks traditional. It does not behave traditionally.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The look is why people choose it. Behind the look is the same six-chamber frame we fit on every other Liniar window.', 'fenster'); ?></p>
            </div>
            <dl class="fg-flush-list">
                <?php foreach ($performance as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <?php /* ---------- Security ---------- */ ?>
    <section class="fg-flush-band fg-flush-band--dark" aria-labelledby="fg-flush-sec-title">
        <div class="container">
            <div class="fg-flush-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2 id="fg-flush-sec-title"><?php esc_html_e('Locked along the sash, not just at the handle.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('A flatter sash is not a softer window. It locks the same way every casement we fit does, and the glass decides most of the rest.', 'fenster'); ?></p>
            </div>
            <dl class="fg-flush-list">
                <?php foreach ($security as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <?php /* ---------- Flush against standard, flush first ---------- */ ?>
    <section class="fg-flush-versus" aria-labelledby="fg-flush-versus-title">
        <div class="container">
            <div class="fg-flush-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Two faces', 'fenster'); ?></p>
                    <h2 id="fg-flush-versus-title"><?php esc_html_e('Flush or standard.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The same 70mm Liniar uPVC and the same fitters. The sash is the difference, and it changes both the look and the glass the frame will take.', 'fenster'); ?></p>
            </div>

            <?php /* The slider lives here, not at the top. This is the point in
                     the page where somebody is choosing between two things, which
                     is the only place a comparison belongs. */ ?>
            <div class="fg-flush-compare">
                <div class="fg-flush-compare__copy">
                    <h3><?php esc_html_e('Drag it, and watch the step disappear.', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Two windows from the same studio set, shot in the same light against the same white. On the standard casement the sash stands proud of the outer frame and throws a shadow line around every opener. On the flush, it closes into the frame and the face is one plane.', 'fenster'); ?></p>
                </div>
                <?php
                get_template_part('template-parts/components/flush-sash-wipe', null, [
                    'flush_src' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-flush-level-w.webp',
                    'flush_alt' => 'White uPVC flush casement window, every sash closing level with the outer frame in one plane',
                    'standard_src' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-sash-proud-w.webp',
                    'standard_alt' => 'White uPVC standard casement window, the opening sash standing proud of the outer frame',
                ]);
                ?>
            </div>

            <table class="fg-cas-table">
                <thead>
                    <tr>
                        <th scope="col"><span class="fg-cas-sr"><?php esc_html_e('Specification', 'fenster'); ?></span></th>
                        <th scope="col"><?php esc_html_e('Flush', 'fenster'); ?></th>
                        <?php /* The link lives in the column it belongs to. Sitting in a
                                 note under the table it read as a footnote to both
                                 sides; here it is plainly the way on from the half
                                 somebody has just decided they prefer. */ ?>
                        <th scope="col"><a class="fg-cas-link" href="<?php echo $casement; ?>"><?php esc_html_e('Standard', 'fenster'); ?></a></th>
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
            <p class="fg-flush-note">
                <a class="fg-cas-link" href="<?php echo esc_url($colour_link); ?>"><?php esc_html_e('Every colour', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <?php /* ---------- Our own work ------------------------------------------
             `fg-cw-gallery`, the same component the heritage door page uses, on
             the owner's instruction that this section should look like the rest
             of the site rather than carry a mosaic of its own. It comes with the
             lightbox and the desktop/mobile copy split already, which is most of
             why the other pages read as consistent. */ ?>
    <section class="fg-cw-gallery" aria-labelledby="fg-flush-proof-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-flush-proof-title"><?php esc_html_e('Flush casements, fitted by us.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('Every photograph here is a Fenster installation. Judge them on the sash line, which is the only thing separating this window from a standard one. Click any image for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('Every photograph is a Fenster installation. Tap any for a closer look.', 'fenster'); ?></span>
                </p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Flush casement window gallery', 'fenster'); ?>">
                <?php foreach ($gallery as $index => $shot) : ?>
                    <?php $full = fenster_generated_url($base . $shot['file']); ?>
                    <figure>
                        <a href="<?php echo esc_url($full); ?>" data-fg-gallery-lightbox
                            aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $shot['alt'])); ?>">
                            <img src="<?php echo esc_url($full); ?>"
                                sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '40vw' : '28vw'; ?>"
                                alt="<?php echo esc_attr($shot['alt']); ?>" loading="lazy">
                            <figcaption><?php echo esc_html($shot['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</div>
