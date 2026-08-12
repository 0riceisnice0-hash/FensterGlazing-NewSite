<?php
/**
 * Tilt and turn windows: the bespoke page.
 *
 * Rebuilt 2026-08-12 as the eleventh bespoke residential middle. The route was
 * running the generic product journey and read exactly like it: "Tilt and Turn
 * Windows" as the H1 and then twice more as an H2, a band headed "More
 * information on Tilt and Turn Windows", five benefit cards that argued the
 * two-way opening four times over, and a FAQ answering "are they energy
 * efficient?" with "U-value information shown on the page".
 *
 * WHAT THIS PAGE IS ABOUT, and it is one sentence: this is the only window we
 * fit that opens INTO the room. Everything a customer actually cares about
 * follows from that and from nothing else — you can reach the outside of the
 * glass standing in the room, and no sash swings out over a balcony, a walkway
 * or a path. Do not let the copy drift back to "versatile" and "practical",
 * which is what the old page said and which describes any window ever made.
 *
 * THE ASSETS ARE FOUR STUDIO RENDERS AND ONE ROOM, AND THAT IS THE WHOLE
 * LIBRARY. Nobody has photographed a tilt and turn of ours tilting or turning,
 * so the mechanism renders carry the argument and the page is built around
 * them rather than around lifestyle photography it does not have. They are
 * Liniar's, they are unattributed here per the split this site holds to, and
 * they render as plates on a tinted panel rather than cropped into photo boxes,
 * because a white-ground render `cover`-cropped into a 16/10 loses the
 * mechanism that is the entire reason it is on the page.
 *
 * THE HERO IS NOT THE OLD ONE, AND THE OLD ONE WAS NOT THIS PRODUCT.
 * `tilt-turn-brick-1600w.webp` shows two barrel hinges on the jamb and a sash
 * standing proud of the frame: a side-hung casement opening outward. Full note
 * against `product_media` in `inc/site-data.php`.
 *
 * THE FIGURES ARE LINIAR'S OWN FOR THIS WINDOW, 1.3 double and 0.93 triple,
 * not the 0.95/1.2 the rest of the Liniar range carries. Owner ruling
 * 2026-08-12. Their spec table also lists 0.85 W/m²K whole window, which is
 * almost certainly the 40mm IGU, and 40mm is not offered on any uPVC we fit.
 * See `glazing_u_values`.
 *
 * NO U-VALUE IN THIS MIDDLE. They are already on the key-specification strip
 * and again on the EnergyPlus banner, both of which render above this. A third
 * statement inside 1.5 viewports is the defect the casement page was corrected
 * for on 2026-07-27 and the aluminium doors rule spells out.
 *
 * DO NOT NAME THE KENRICK EXCALIBUR HERE. That is the casement lock. A tilt and
 * turn runs different gearing and nobody has confirmed whose it is, so the
 * hardware is described and not branded.
 *
 * DO NOT BUILD A CONFIGURATOR. Three have been cut from this site on sight: the
 * casement canvas one (2026-08-04), the heritage bar planner (2026-08-11) and
 * the uPVC door randomiser (2026-08-12). A tilt/turn demonstrator is the
 * obvious thing to propose here and it is the same mistake. Two positions is
 * two pictures, and WindowCAD both configures and prices.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$quote_url = (string) ($args['quote_url'] ?? '');
$imported = '/wp-content/themes/fenster/assets/images/imported/';

$handle_hub = esc_url(home_url('/handle-options/#tilt-turn-handle-finishes'));
$colour_hub = esc_url(home_url('/colour-options/'));
$casement = esc_url(home_url('/casement-windows/'));
$flush = esc_url(home_url('/flush-casement-windows/'));
$sash = esc_url(home_url('/sliding-sash-windows/'));

/* Where it suits, in the customer's terms rather than ours. Each of these is a
   consequence of the sash coming inwards, which is what keeps the section from
   turning into a list of adjectives. */
$suits = [
    [
        'name' => __('Flats and upper floors', 'fenster'),
        'copy' => __('With the sash turned in you can wash the outside of the glass standing in the room. Three floors up that is the difference between cleaning your own windows and paying somebody with a pole, and it is the reason most of these go where they go.', 'fenster'),
    ],
    [
        'name' => __('Anything above a drop', 'fenster'),
        'copy' => __('Lock the handle on the middle key position and the window still tilts for air but will not swing open. A bedroom airs overnight with the sash held in the frame.', 'fenster'),
    ],
    [
        'name' => __('Where nothing can swing outwards', 'fenster'),
        'copy' => __('A balcony, a walkway, a shared path, a boundary a few feet from the wall. An outward-opening casement is simply not allowed to be there, and this is the window that solves it.', 'fenster'),
    ],
    [
        'name' => __('Wide openings in one sash', 'fenster'),
        'copy' => __('The weight is carried at the bottom corner rather than hung off hinges down one edge, so a tilt and turn takes a bigger single sash than a side-hung casement of the same system. We size it against the opening at survey.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-tt">

    <?php /* ---------- It opens inwards -------------------------------------
             Media first, and the media is the tilt render rather than a room,
             because the one thing this page has to establish in the first
             screen is a direction of travel. Every other window route can open
             on a house; this one has to open on the sash coming towards you or
             the rest of the page is describing something the reader has not
             pictured yet. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-tt-inwards-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <figure class="fg-cw-media fg-cw-media--plate">
                <img <?php echo fenster_image_attr_string($imported . 'Tilt-turn-ventilation-1.jpeg', [
                    'alt' => __('A tilt and turn window tipped inwards at the top, with the stay arm across the head and the locking gear running down the sash edge', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('How it opens', 'fenster'); ?></p>
                <h2 id="fg-tt-inwards-title"><?php esc_html_e('It opens into the room.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Every other window we fit either swings out or slides. This one comes in. Tip the top inwards a few inches for air, or swing the whole sash into the room like a door, and both come off the same handle.', 'fenster'); ?></p>
                <p><?php esc_html_e('Two things follow from that, and between them they are the reason anybody buys one. You can reach the outside face of the glass from where you are standing, however far up the building you are. And nothing ever swings out over whatever happens to be on the other side of the wall.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <?php /* SCULPTURED, and the word is load-bearing. Liniar
                             publish this system as "sculptured or chamfered";
                             the owner confirmed on 2026-08-12 that we fit the
                             sculptured profile only, which is the same answer
                             already recorded for the casement. Stated positively
                             — the page never says we do not do the other one,
                             per the 2026-08-02 ruling against exclusions. */ ?>
                    <li><?php esc_html_e('Liniar 70mm EnergyPlus, sculptured, four chambers through the frame', 'fenster'); ?></li>
                    <li><?php esc_html_e('28mm double glazed as standard, or a 36mm triple', 'fenster'); ?></li>
                    <li><?php esc_html_e('Sixteen colours outside, matched or smooth white inside', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $colour_hub; ?>"><?php esc_html_e('See the colour range', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php /* ---------- The handle ---------------------------------------------
             THE TILT-ONLY KEY SETTING GETS A SECTION, and that is the point of
             this one. `AI.md` has said since 2026-07-29 that it is "the
             strongest thing on this page for a bedroom or anything above a
             drop", and the page it was written about had it buried in a handle
             grid below the fold, where it was one bullet among five finishes.

             The two-part correction underneath it is owner-supplied and both
             halves matter: the HANDLE POSITION selects tilt or turn, the KEY
             does not. The key locks the handle, and its middle position lets
             the handle reach tilt but not the full swing. He corrected the
             first point and verified the second on a real window, both
             2026-07-29. Do not collapse them into "the key decides how far the
             window opens", which is the original error. */ ?>
    <section class="fg-cw-intro fg-tt-handle" aria-labelledby="fg-tt-handle-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The handle', 'fenster'); ?></p>
                <h2 id="fg-tt-handle-title"><?php esc_html_e('One lever does both, and the key can hold it at tilt.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A quarter turn of the handle and the top of the sash tips inwards for background air. Keep turning and the same handle swings the whole sash into the room. There is no second catch and nothing to prop.', 'fenster'); ?></p>
                <p><?php esc_html_e('The handle also locks with a key, and the middle key position is the one worth knowing about. Leave it there and the handle still reaches tilt but will not go round to the full opening. The room airs all night and the sash cannot be swung in, which is what you want in a child\'s bedroom or anything above a drop. It is the locking handle on every tilt and turn we fit, so the setting is there whether or not you ask for it.', 'fenster'); ?></p>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $handle_hub; ?>"><?php esc_html_e('See the five handle finishes', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-cw-media fg-cw-media--plate">
                <img <?php echo fenster_image_attr_string($imported . 'Tilt-turn-ventilation-2.jpeg', [
                    'alt' => __('The stay at the top corner of a tilt and turn sash, the arm that carries the weight when the window is tipped inwards', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
        </div>
    </section>

    <?php /* ---------- How it holds shut ---------------------------------------
             A pair rather than a split, because the two renders are halves of
             one idea: the cam on the sash and the keep it pulls into on the
             frame. `.fg-cw-gallery--pair` is the two-cell cut already built for
             exactly this on the aluminium flush route.

             PAS 24 AND SECURED BY DESIGN ARE LINIAR'S AND ARE ATTRIBUTED, never
             asserted as ours. The standard belongs to a tested complete window,
             not to a profile and not to a component, which is the same
             distinction the casement page holds the Kenrick figures to and the
             uPVC doors page holds Liniar's own PAS 24 to. Do not promote this
             to "our tilt and turn windows are PAS 24". */ ?>
    <section class="fg-cw-gallery fg-cw-gallery--pair fg-tt-secure" aria-labelledby="fg-tt-secure-title">
        <div class="container">
            <div class="fg-cw-gallery__head fg-tt-secure__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                    <h2 id="fg-tt-secure-title"><?php esc_html_e('It locks by pulling itself into the frame.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Turning the handle to shut runs a steel gear down the edge of the sash and rolls a line of mushroom-headed cams into keeps set in the frame. Because the sash closes inwards, every cam draws it tighter against its seals instead of holding it up against them. That is the same movement that makes it weathertight, and it is why there is nothing on the outside to get a bar behind.', 'fenster'); ?></p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Tilt and turn locking hardware', 'fenster'); ?>">
                <?php
                $locking = [
                    [
                        'src' => $imported . 'Tilt-turn-keep-2.jpeg',
                        'alt' => 'A mushroom-headed cam on the edge of a tilt and turn sash, the part that rolls into the keep as the handle turns',
                        'caption' => __('The cam, on the edge of the sash', 'fenster'),
                    ],
                    [
                        'src' => $imported . 'Tilt-turn-keep-1.jpeg',
                        'alt' => 'The steel keep set into a tilt and turn window frame, which the sash cam draws into',
                        'caption' => __('The keep, set into the frame', 'fenster'),
                    ],
                ];
                ?>
                <?php foreach ($locking as $shot) : ?>
                    <?php $full = fenster_generated_url($shot['src']); ?>
                    <figure class="fg-tt-plate">
                        <a href="<?php echo esc_url($full); ?>" data-fg-gallery-lightbox
                            aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $shot['alt'])); ?>">
                            <img src="<?php echo esc_url($full); ?>"
                                sizes="(max-width: 860px) 82vw, 40vw"
                                alt="<?php echo esc_attr($shot['alt']); ?>" loading="lazy">
                            <figcaption><?php echo esc_html($shot['caption']); ?></figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>

            <?php /* The mosaic becomes a scroll-snap rail at 860px and the
                     second plate is clipped at 82%, which is the affordance
                     `STYLE.md` asks for. The hint is belt and braces on top of
                     it, the same one the heritage door configurations carry. */ ?>
            <p class="fg-cw-gallery__hint" aria-hidden="true"><?php esc_html_e('Swipe to see the keep', 'fenster'); ?> <span>&rarr;</span></p>

            <p class="fg-tt-secure__note">
                <?php esc_html_e('Liniar test the 70mm system to PAS 24 and to Part Q, and it is a Secured by Design product to BS EN 12608-1. Those are their figures for the profile rather than a certificate for one particular window, so ask us what a specific opening is being built to and we will tell you.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <?php /* ---------- Where it suits -------------------------------------------
             The dark plate, and the only one. One moment is a moment; the
             heritage page makes the same call in the same words.

             THE LAST CARD IS THE AWKWARD ONE AND IT STAYS. `TONEOFVOICE.md`
             asks for the caveat before the customer has to dig for it, and the
             product hub rule asks that a comparison between two things we both
             sell praise both sides and let the reader separate them. So the
             period-property card names what a flush sash and a sliding sash are
             better at rather than saying a tilt and turn is worse, which is the
             wording the 2026-07-24 ruling bans.

             NO FIGURES HERE. They are on the key-specification strip and the
             EnergyPlus banner already, both above this. */ ?>
    <section class="fg-tt-suits" aria-labelledby="fg-tt-suits-title">
        <div class="container">
            <div class="fg-tt-suits__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Where it goes', 'fenster'); ?></p>
                    <h2 id="fg-tt-suits-title"><?php esc_html_e('Four jobs it does better than anything else we fit.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('A tilt and turn is not the window for every opening in the house, and we would rather say so here than at survey. These are the four situations where it is the right answer and the others are not close.', 'fenster'); ?></p>
            </div>

            <dl class="fg-tt-list">
                <?php foreach ($suits as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>

            <div class="fg-tt-suits__foot">
                <p>
                    <?php
                    printf(
                        /* translators: 1: casement windows link, 2: flush casement windows link, 3: sliding sash windows link */
                        esc_html__('It reads modern, which is right at home on a flat or a newer house. On a period elevation the %1$s and the %2$s hold the proportions the building was built with, and a %3$s is the one that belongs in a Victorian front. All three are ours, and getting you the right one matters more to us than getting you this one.', 'fenster'),
                        '<a class="fg-cw-link" href="' . $casement . '">' . esc_html__('casement', 'fenster') . '</a>',
                        '<a class="fg-cw-link" href="' . $flush . '">' . esc_html__('flush sash', 'fenster') . '</a>',
                        '<a class="fg-cw-link" href="' . $sash . '">' . esc_html__('sliding sash', 'fenster') . '</a>'
                    );
                    ?>
                </p>
                <?php /* Hands over to the designer rather than to a form, on the
                         standing instruction that WindowCAD is the interactive
                         feature on a product page. It jumps to the embed further
                         down this page, where the tool already is, rather than
                         opening it cold. */ ?>
                <?php if ($quote_url !== '') : ?>
                    <p class="fg-tt-suits__actions">
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Design and price it', 'fenster'); ?></a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>
