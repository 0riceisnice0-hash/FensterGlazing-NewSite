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
 * Built on `.fg-cw`, the split-section grammar the heritage door page and the
 * lift-and-slide component already share, rather than a third layout of its own.
 * Deliberately NOT the casement page's stacked chapters: the owner wants that
 * device to stay unique to casement, so the feature here is the wipe instead.
 *
 * The order is the order the decision gets made in:
 *   what is a flush casement          -> the wipe, which shows it in one gesture
 *   does it suit my house             -> period and modern, side by side
 *   is it any good                    -> performance and security, Liniar's figures
 *   how does it differ from standard  -> the comparison, flush-first
 *   have you actually fitted them     -> our own work
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
    ['label' => 'Glazing', 'a' => '28mm double', 'b' => '28mm double or 36mm triple'],
    ['label' => 'Whole window U-value', 'a' => '1.2 W/m²K', 'b' => '0.95 W/m²K'],
    ['label' => 'Energy rating', 'a' => 'A+', 'b' => 'A+'],
    ['label' => 'Suits', 'a' => 'Period frontages, and modern elevations wanting a flatter line', 'b' => 'Most homes, and the wider specification'],
];

$performance = [
    ['name' => 'Six chambers in the outer frame', 'copy' => 'The flush sash runs on Liniar\'s EnergyPlus outer frame, so the profile carries six sealed chambers rather than the four a standard profile has. Each one interrupts the route heat takes out of the room.'],
    ['name' => 'A gasket formed with the profile', 'copy' => 'The weather seal is co-extruded with the frame rather than pushed into a groove afterwards, so it runs unbroken around the corners. Corners are where a pushed-in gasket fails first.'],
    ['name' => '1.2 W/m²K, A+ rated', 'copy' => 'Whole window, with the 28mm double glazed unit this system takes. Size, layout and glass all move the final figure, so the number we agree follows your specification rather than a brochure.'],
    ['name' => '35 decibels of sound reduction', 'copy' => 'Liniar publish 35 (-1;-4) for this profile. It is the frame and the glass together, and if noise is the reason you are replacing the windows, say so early: the glass does most of that work and it is specified differently.'],
];

$security = [
    ['name' => 'PAS 24, and Secured by Design', 'copy' => 'Both available on this system, and PAS 24 is what Part Q asks for on new dwellings and some extensions. Tell us early if your build is covered by it. The approval belongs to a tested complete window rather than to a profile name.'],
    ['name' => 'Multi-point locking as standard', 'copy' => 'Not an upgrade. One turn of the handle throws the locking points down the sash edge, so the window is held into its seals along its length rather than at the handle alone.'],
    ['name' => 'Laminated glass where it matters', 'copy' => 'A bonded interlayer holds a broken pane together instead of letting it break through. It is the upgrade we would point at first on a ground floor, or on any window out of sight from the road.'],
];

/* Our own installations. The two aluminium frames that used to sit in this set
   are gone: judge a replacement by the sash-to-frame junction, not by a filename
   that says flush. */
$gallery = [
    ['file' => 'flush-modern-elevation-1600w.webp', 'caption' => 'Anthracite, across a rear elevation', 'alt' => 'Anthracite flush casement windows across the rear elevation of a red brick house'],
    ['file' => 'flush-white-detail-1400w.webp', 'caption' => 'White, and the sash line up close', 'alt' => 'White flush casement window in red brick, the sashes closing level with the outer frame'],
    ['file' => 'flush-cream-bars-1400w.webp', 'caption' => 'Cream, with Georgian bars', 'alt' => 'Cream flush casement windows with Georgian bars on a buff brick house'],
    ['file' => 'flush-white-bay-brick-1400w.webp', 'caption' => 'A bay, built in flush sashes', 'alt' => 'White flush casement bay window on a tile hung house'],
    ['file' => 'flush-stone-cottage-1400w.webp', 'caption' => 'A stone cottage frontage', 'alt' => 'White flush casement windows in a stone cottage elevation'],
    ['file' => 'flush-oak-dormers-1400w.webp', 'caption' => 'Golden oak dormers', 'alt' => 'Golden oak flush casement windows in two dormer gables'],
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
                <img src="<?php echo esc_url(fenster_generated_url($base . 'flush-render-detail-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Grey flush casement window with a stone cill in a white rendered wall', 'fenster'); ?>"
                    loading="lazy" width="1600" height="1163">
                <figcaption><?php esc_html_e('Grey, on white render', 'fenster'); ?></figcaption>
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
                    <h2 id="fg-flush-perf-title"><?php esc_html_e('A traditional face on a modern frame.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The look is the reason people choose it. The frame behind the look is the same six-chamber platform we fit everywhere else.', 'fenster'); ?></p>
            </div>
            <dl class="fg-flush-list">
                <?php foreach ($performance as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <p class="fg-flush-note"><?php esc_html_e('One thing this system does not do: it takes a 28mm double glazed unit only, so there is no triple glazed option on a uPVC flush casement. Worth knowing before a survey rather than after one.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* ---------- Security ---------- */ ?>
    <section class="fg-flush-band fg-flush-band--dark" aria-labelledby="fg-flush-sec-title">
        <div class="container">
            <div class="fg-flush-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2 id="fg-flush-sec-title"><?php esc_html_e('Tested to the standard Part Q asks for.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('A flatter sash does not mean a softer window. This system is available tested and approved, and the glass is where most of the rest is decided.', 'fenster'); ?></p>
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
                        <th scope="col"><?php esc_html_e('Standard', 'fenster'); ?></th>
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
                <a class="fg-cas-link" href="<?php echo $casement; ?>"><?php esc_html_e('See standard casement windows', 'fenster'); ?></a>
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
