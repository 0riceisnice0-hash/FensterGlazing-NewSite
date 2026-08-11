<?php
/**
 * Heritage windows: the bespoke page.
 *
 * Rebuilt 2026-08-11. The route was running the generic product journey and read
 * like it: "Heritage Windows" as the H1 and twice more as an H2, a band headed
 * "More information on Heritage Windows", and a middle written about the
 * category rather than about the window we actually fit.
 *
 * WHAT THIS PAGE IS ABOUT. Sheerline Classic, and specifically the STEPPED sash.
 * Owner, 2026-08-11: "we use just the stepped sash to keep it a proper steel
 * look (designed to replace crittal or give the same look)". Sheerline publish
 * four aesthetics on this system — Contemporary, Contemporary Flush, Stepped and
 * Stepped Flush — and we fit one of them. The stepped shoulder is what carries
 * the shadow line an original steel window has, so it is the reason the product
 * exists and it must not be softened into "slim aluminium windows", which is
 * what the old copy did and which describes /aluminium-windows/ instead.
 *
 * THE ANGLE, and it is different from every other window route: this one
 * replaces something rather than upgrading it. The visitor usually has steel
 * windows that rust, bind and stream with condensation, or has seen the look on
 * somebody else's house. So the page opens on what it replaces, not on what it
 * is made of.
 *
 * THERE IS NO CONFIGURATOR HERE, AND THAT IS A DECISION. An interactive bar
 * planner was built for this page and the owner removed it on sight, 2026-08-11:
 * "miss out your cartoon planner tool. already have a way better
 * designer/pricing tool that should be the focus." WindowCAD configures the
 * window and prices it in the same breath; anything drawn in-house competes with
 * the thing that actually converts and answers less. The same call was made on
 * /casement-windows/ on 2026-08-04. Do not build another one.
 *
 * SIGHTLINES ARE THE BEADED FIGURES, 60.5mm on a casement and from 36.5mm on a
 * fixed light, owner-confirmed as the variant we fit. Do not reach for the
 * beadless 59mm, and do not quote the fixed-light figure as though it described
 * a casement.
 *
 * NO TRIPLE GLAZING. Owner, 2026-08-11: triple can be done on the Classic
 * CONTEMPORARY sash but is not offered on the STEPPED one, deliberately, so the
 * Classic offering does not muddy against Prestige. Sheerline publish 1.1 for
 * the system; it does not belong to what we sell here.
 *
 * PHOTOGRAPHY. One install of ours, shot as one frame and used twice — the whole
 * gable and a closer crop of the same picture. The rest is Sheerline's, and the
 * page never claims otherwise: supplier work is unattributed and ours is
 * captioned as ours, which is the split the flush aluminium route documents.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$quote_url = (string) ($args['quote_url'] ?? '');
$base = '/wp-content/themes/fenster/assets/images/products/heritage-windows/';

$colour_hub = esc_url(home_url('/colour-options/'));
$heritage_doors = esc_url(home_url('/heritage-aluminium-doors/'));
$aluminium_windows = esc_url(home_url('/aluminium-windows/'));

$layouts = fenster_data('heritage_window_layouts', []);
$layouts = is_array($layouts) ? $layouts : [];
$bar_options = is_array($layouts['bars'] ?? null) ? $layouts['bars'] : [];

/* Four cards. Every figure is Sheerline's own published specification for the
   Classic system, and the page says so under them. Nothing here is restated as
   a Fenster performance number, which is the rule the Kenrick figures on the
   casement page are held to. */
$classic_gives = [
    [
        'name' => __('A thermal break through the frame', 'fenster'),
        'copy' => __('Sheerline run their Thermlock multi-chamber break through the Classic frame instead of the polyamide strip most aluminium systems use. Double glazed the window reaches 1.4 W/m²K, where an original steel window has nothing at all between the outside air and your curtains.', 'fenster'),
    ],
    [
        'name' => __('Slim, and slimmest where it shows', 'fenster'),
        'copy' => __('60.5mm sightlines on a beaded casement, and fixed lights from 36.5mm. On a small stone opening, that is the difference between a window and a frame with some glass in it.', 'fenster'),
    ],
    [
        'name' => __('Tested to PAS 24, and beyond it if you want', 'fenster'),
        'copy' => __('Sheerline hold PAS 24:2016 on the Classic window, and Secured by Design, the police standard, with a laminated glass upgrade. Both are theirs rather than ours, and the second is something you choose rather than something every window arrives with.', 'fenster'),
    ],
    [
        'name' => __('Corners cleated, not welded', 'fenster'),
        'copy' => __('The mitres are cleated, which keeps the frame square. Corners that move are the usual reason a slim window starts to catch after a few winters, and they are the first thing to go on the steel window this replaces.', 'fenster'),
    ],
];
?>

<div class="fg-cw fg-hw">

    <?php /* ---------- What it replaces --------------------------------------
             Media first, because the argument is a photograph of a house rather
             than a specification. This is the only route on the site whose
             visitor usually owns the thing being replaced, so the section opens
             on that and not on the material. */ ?>
    <section class="fg-cw-intro" aria-labelledby="fg-hw-replaces-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <?php /* NOT the Sheerline 1930s brick house that was here first.
                     That photograph is the same house on the same shoot as the
                     `/aluminium-flush-windows/` hero — same cordyline palm, same
                     sign in the window — so it was a flush product picture on a
                     heritage page, and the owner spotted it immediately. Check a
                     supplier photograph against the other aluminium routes
                     before using it. */ ?>
            <figure class="fg-cw-media">
                <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', [
                    'alt' => __('Dark heritage aluminium windows along a traditional terrace', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
            </figure>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('What it replaces', 'fenster'); ?></p>
                <h2 id="fg-hw-replaces-title"><?php esc_html_e('The steel window, without the cold.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Britain put steel windows into a great many houses between the wars, Crittall being the name most people remember, and they are still the reason those houses look the way they do. They are also single glazed, they rust from inside the frame outwards, and by now most of them bind in the wet and run with condensation from October to March.', 'fenster'); ?></p>
                <p><?php esc_html_e('Sheerline Classic is aluminium drawn to the same proportions and given a thermal break, modern glass and a powder coat that does not need painting. It has quietly become the window the trade reaches for when somebody wants steel back, and we fit it with the stepped sash, which is the profile that keeps the shoulder and the shadow line the original had. Get that wrong and you have a nice window that reads as new.', 'fenster'); ?></p>
                <ul class="fg-cw-facts">
                    <li><?php esc_html_e('60.5mm on a casement, and from 36.5mm on a fixed light', 'fenster'); ?></li>
                    <li><?php esc_html_e('1.4 W/m²K double glazed', 'fenster'); ?></li>
                    <li><?php esc_html_e('Twelve powder-coated colours, or any RAL you can name', 'fenster'); ?></li>
                </ul>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $colour_hub; ?>"><?php esc_html_e('See the colour range', 'fenster'); ?></a>
                    <a class="fg-cw-link" href="<?php echo $aluminium_windows; ?>"><?php esc_html_e('Aluminium without the bars', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php /* ---------- The look: stepped sash and bars ---------------------
             The one dark plate on the page. One moment is a moment; three would
             be a theme park, which is why the sections either side are ordinary.

             THIS SLOT HELD AN INTERACTIVE BAR PLANNER AND THE OWNER REMOVED IT,
             2026-08-11: "miss out your cartoon planner tool. already have a way
             better designer/pricing tool that should be the focus." He is right
             and the reasoning is worth keeping, because a drawn configurator is
             an attractive thing to propose on a page like this. WindowCAD
             configures the window AND prices it; anything we draw ourselves
             competes with the thing that converts and gives a worse answer. The
             identical call was made on /casement-windows/ on 2026-08-04, where a
             canvas configurator was built and removed the same day. **Do not
             build another one here.** The bar layouts are copy, and the section
             ends by handing over to the designer. */ ?>
    <section class="fg-hw-look" aria-labelledby="fg-hw-look-title">
        <div class="container">
            <div class="fg-hw-look__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('The look', 'fenster'); ?></p>
                    <h2 id="fg-hw-look-title"><?php esc_html_e('A stepped sash, and the bars in the right places.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Two things decide whether a window reads as steel. The sash has to step, so the face throws the shoulder and the shadow line an original had, and the bars have to be laid out the way the house would have had them. Everything else is colour and glass, and you can settle that later.', 'fenster'); ?></p>
            </div>

            <div class="fg-hw-look__grid">
                <figure class="fg-hw-look__media">
                    <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', [
                        'alt' => __('Close view of slim dark glazing bars meeting on a heritage aluminium window', 'fenster'),
                        'loading' => 'lazy',
                    ]); ?>>
                    <figcaption><?php esc_html_e('The bars are slim enough to read as steel, and they are set out to the elevation rather than to a catalogue.', 'fenster'); ?></figcaption>
                </figure>

                <div class="fg-hw-layouts">
                    <?php foreach ($bar_options as $bar) : ?>
                        <?php if (! is_array($bar)) { continue; } ?>
                        <div>
                            <h3><?php echo esc_html($bar['label'] ?? ''); ?></h3>
                            <p><?php echo esc_html($bar['copy'] ?? ''); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php /* The handover. The owner's instruction is that the designer
                     is the focus, so the page's one strong in-body call to
                     action points at it rather than at a form. It jumps to the
                     embed further down the same page, which is where the tool
                     already lives, rather than opening WindowCAD cold. */ ?>
            <div class="fg-hw-look__handover">
                <p><?php esc_html_e('You can build the window itself on our designer, bars and colour and sizes together, and it prices as you go. It is the same software and the same price list we use at a consultation, so the figure is the real one.', 'fenster'); ?></p>
                <p class="fg-hw-look__actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Design and price it', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--light" href="<?php echo $colour_hub; ?>"><?php esc_html_e('See the colours', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php /* ---------- What the system gives you --------------------------------
             Card band, so the page changes shape between the plate and the
             photographs. Shares `.fg-hw-band` with the four other routes that
             carry one of these rather than owning a copy of it. */ ?>
    <section class="fg-hw-band" aria-labelledby="fg-hw-system-title">
        <div class="container">
            <div class="fg-hw-band__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('The system', 'fenster'); ?></p>
                    <h2 id="fg-hw-system-title"><?php esc_html_e('What you get that the original never had.', 'fenster'); ?></h2>
                </div>
                <p>
                    <?php
                    printf(
                        /* translators: %s: link to the heritage aluminium doors page */
                        esc_html__('Sheerline Classic is one system, and we sell the whole of it: these windows and the %s that go with them. What follows is the part of it a steel window cannot answer back to.', 'fenster'),
                        '<a class="fg-cw-link" href="' . $heritage_doors . '">' . esc_html__('heritage doors', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <dl class="fg-hw-list">
                <?php foreach ($classic_gives as $item) : ?>
                    <div>
                        <dt><?php echo esc_html($item['name']); ?></dt>
                        <dd><?php echo esc_html($item['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <p class="fg-hw-band__note">
                <?php esc_html_e('Figures and accreditations are Sheerline\'s published specification for the Classic system. What suits your opening, and what it costs, depends on the opening.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <?php /* ---------- Our work ---------------------------------------------
             ONE job, shot as one frame, shown twice: the gable and a closer crop
             of the same photograph. The copy describes the house and the work
             and makes no claim about how many of these we have fitted, which is
             the owner's instruction. Do not write "our only install" here, and
             do not imply a portfolio either. */ ?>
    <section class="fg-cw-gallery fg-cw-gallery--pair" aria-labelledby="fg-hw-proof-title">
        <div class="container">
            <div class="fg-cw-gallery__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-hw-proof-title"><?php esc_html_e('Three lights, three stone openings.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cw-gallery__copy--desktop"><?php esc_html_e('White Classic frames in an ironstone gable, one window per original opening so the stone mullions still carry the elevation. Click either image for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cw-gallery__copy--mobile"><?php esc_html_e('White Classic frames in an ironstone gable, one window per stone opening. Tap either image for a closer look.', 'fenster'); ?></span>
                </p>
            </div>

            <div class="fg-cw-gallery__mosaic" aria-label="<?php esc_attr_e('Heritage window gallery', 'fenster'); ?>">
                <?php
                $gallery = [
                    [
                        'src' => $base . 'hw-install-stone-mullion-1200w.webp',
                        'alt' => __('White heritage aluminium windows in the stone mullioned openings of a cottage gable', 'fenster'),
                        'caption' => __('The gable, with the original stone kept and the openings unaltered', 'fenster'),
                    ],
                    [
                        'src' => $base . 'hw-install-sash-detail-1200w.webp',
                        'alt' => __('Close view of three white heritage aluminium lights divided by original stone mullions, each with a top opener', 'fenster'),
                        'caption' => __('Closer: a top opener over each light, and the frame kept inside the stone', 'fenster'),
                    ],
                ];
                ?>
                <?php foreach ($gallery as $shot) : ?>
                    <?php $full = fenster_generated_url($shot['src']); ?>
                    <figure>
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
        </div>
    </section>

    <?php /* ---------- The doors ------------------------------------------------
             Owner instruction, 2026-08-11: the two products match perfectly and
             each page must send people to the other. The doors page carries the
             matching band back. Media on the right this time, so this does not
             repeat the shape of the opening section. */ ?>
    <section class="fg-cw-intro fg-hw-pair" aria-labelledby="fg-hw-doors-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('The set', 'fenster'); ?></p>
                <h2 id="fg-hw-doors-title"><?php esc_html_e('The door is the same window with a handle on it.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The Classic heritage door is drawn on the same system as these windows, which is why the two sit together properly rather than nearly matching. The stepped face runs on at the same depth, the bars line through at the same spacing, and both come in the same twelve colours, so a garden door between two windows reads as one piece of work.', 'fenster'); ?></p>
                <p><?php esc_html_e('It is worth deciding both at once even if the door comes later. We can hold the colour and the bar layout on file, and the survey takes the door opening at the same visit.', 'fenster'); ?></p>
                <p class="fg-cw-actions">
                    <a class="fg-cw-link" href="<?php echo $heritage_doors; ?>"><?php esc_html_e('See the heritage doors', 'fenster'); ?></a>
                </p>
            </div>
            <?php /* This photograph rather than the French door render two
                     folders along, because it shows the pairing the section is
                     about: a door and a window in the same black on the same
                     elevation. It is also a photograph rather than a CGI, and
                     the render would have been the only one on a page of real
                     pictures, which is the fault already recorded against the
                     Northampton dusk render on the doors hub tile. Supplier
                     imagery, so the caption describes it and claims nothing. */ ?>
            <figure class="fg-cw-media">
                <img <?php echo fenster_image_attr_string('/wp-content/themes/fenster/assets/images/products/heritage-aluminium/hero/heritage-door-brick-1200w.webp', [
                    'alt' => __('A black heritage aluminium door and a matching heritage window on the same brick elevation', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
                <figcaption><?php esc_html_e('A heritage door and a heritage window on one elevation', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

</div>
