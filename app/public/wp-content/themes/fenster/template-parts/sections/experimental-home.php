<?php
/**
 * EXPERIMENTAL — /fenster-new-home-page/ markup.
 *
 * Two layers, and the split matters:
 *
 *  - Everything the page SAYS is ordinary HTML. Headline, specifications,
 *    the product range with real links, the CTAs. It is in the document
 *    whether or not WebGL exists, whether or not the models load, and
 *    whether or not the visitor can see the canvas at all.
 *  - Everything the page DOES is the canvas. If it fails, `.is-failed` is set
 *    and the static hero comes forward; the page is then simply a good dark
 *    landing page rather than a broken one.
 *
 * Copy follows `TONEOFVOICE.md`: facts rather than adjectives, the awkward
 * thing said first, no em dashes, we/you voice. Every figure on this page is
 * one already published on the route it belongs to.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = fenster_site_data()['brand'];
$products = fenster_experimental_home_products();
$modelled = fenster_experimental_home_modelled();
$asset_base = FENSTER_THEME_URI . '/assets/experimental';

// The traced mark, inlined so the loader can draw its strokes on. Traced from
// the real brand asset by scripts/trace-logo.mjs; see assets/experimental/README.md.
$mark_svg = '';
$mark_path = FENSTER_THEME_DIR . '/assets/experimental/fenster-mark.svg';
if (file_exists($mark_path)) {
    $mark_svg = (string) file_get_contents($mark_path);
    $mark_svg = preg_replace('/<\?xml.*?\?>/s', '', $mark_svg);
    $mark_svg = preg_replace('/<!--.*?-->/s', '', $mark_svg);
}

$quote_url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing';

/* ---------------------------------------------------------------------------
   PASS TWO: THE COPY MOVED INTO THE ROOM.

   Pass one carried four panels of headline, lede, specs and buttons pinned to
   the left third of the viewport. It read as a hero banner with a 3D
   background, which is exactly backwards: the moment there is a paragraph on
   the glass, the scene behind it is wallpaper.

   So the information is now spatial. It is built as geometry in
   `src/experimental/lib/annotations.js` and placed in the world by the
   choreography: callouts with hairline leaders pointing at the part they
   describe, type lying on the floor, numbered steps standing around the
   terminal. What is left in HTML here is only what HTML should carry — the
   accessible document underneath, and two links.

   Every figure below is passed to the scene rather than typed into the
   JavaScript, so a spec that changes on the product page changes in the room.
   All of them are already published on the route they belong to:

     casement   Liniar EnergyPlus 70mm, A+ rated, 0.95 W/m2K on a 36mm triple
                glazed unit, 16 colours, PAS 24 security option
     bifold     Sheerline Prestige, thermally broken aluminium, slim sightlines
     composite  44.5mm insulated slab, glass reinforced polyester, multi-point

   The window and door counts are COUNTED from the same registry the menu is
   built from. The scene says "09 WINDOW SYSTEMS" in type; if a tenth is added
   that number has to follow, and nobody would think to look in a shader.
   --------------------------------------------------------------------------- */
$group_counts = fenster_experimental_home_group_counts();

$scene_labels = fenster_scene_labels();
/* Shared with the showroom routes — see fenster_scene_labels() in
   inc/showroom.php. Two copies of a published figure drift, and the one
   inside a shader is the one nobody thinks to check. */
?>

<div class="fx"
     data-fx-atrium
     data-fx-models="<?php echo esc_url($asset_base . '/models'); ?>"
     data-fx-mark="<?php echo esc_url($asset_base . '/fenster-mark.svg'); ?>"
     data-fx-quote="<?php echo esc_url($quote_url); ?>"
     data-fx-labels="<?php echo esc_attr(wp_json_encode($scene_labels)); ?>">

    <?php /* ---------------------------------------------------------- loader */ ?>
    <div class="fx__loader" data-fx-loader>
        <div class="fx__loader-inner">
            <div class="fx__loader-mark" aria-hidden="true"><?php echo $mark_svg; // phpcs:ignore ?></div>
            <div class="fx__loader-bar"><span data-fx-loader-bar></span></div>
            <div class="fx__loader-meta">
                <span class="fx__loader-note" data-fx-loader-note>Preparing the scene</span>
                <span><b data-fx-loader-pct>0</b>%</span>
            </div>
        </div>
    </div>

    <?php /* ----------------------------------------------------------- stage */ ?>
    <div class="fx__stage" data-fx-stage>
        <canvas class="fx__canvas" data-fx-canvas aria-hidden="true"></canvas>
        <div class="fx__css-layer" data-fx-css-layer></div>
    </div>

    <?php /* -------------------------------------------------------- overlay ui */ ?>
    <?php
    /* What is left of the HTML overlay, and it is deliberately almost nothing.
       One annotation line at the top, one pair of links at the bottom, one
       scroll cue. Anything that describes a product now lives in the room. */
    ?>
    <div class="fx__ui">
        <div class="fx__top">
            <span class="fx__coords">Real WindowCAD geometry &nbsp;&middot;&nbsp; <?php echo (int) $scene_labels['counts']['modelled']; ?> products &nbsp;&middot;&nbsp; local experiment</span>
        </div>

        <?php
        /* The CTAs stay in the document, per the brief, but they are a lower
           third rather than a card: two links, hairline rule, no box. They sit
           out of the way for the whole cinematic sequence and only come up to
           full strength once the terminal is square on and usable. */
        ?>
        <div class="fx__actions" data-fx-actions>
            <a class="fx__btn" href="<?php echo esc_url(home_url('/online-quote/')); ?>">Get an instant price</a>
            <a class="fx__btn fx__btn--ghost" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Book a free consultation</a>
        </div>

        <div class="fx__cue" data-fx-cue aria-hidden="true">
            <span class="fx__cue-line"></span>
            <span>Scroll</span>
        </div>
    </div>

    <?php /* --------------------------------------------------- progress rail */ ?>
    <nav class="fx__rail" aria-label="Scene progress">
        <span class="fx__rail-track"><b data-fx-rail-fill></b></span>
        <?php foreach (['Fenster', 'Windows', 'Doors', 'Pricing'] as $i => $tick) : ?>
            <span class="fx__tick" data-fx-tick><b><?php echo esc_html($tick); ?></b></span>
        <?php endforeach; ?>
    </nav>

    <?php /* ------------------------------------------------------ scroll runway */ ?>
    <div class="fx__scroller" data-fx-scroller aria-hidden="true"></div>

    <?php
    /* ------------------------------------------------------------------------
       The page as an ordinary document.

       Hidden from sight once the canvas is live, but present in the markup
       always. If WebGL is missing, the model files fail, or the visitor has
       asked for reduced motion, this is what the page is — and it is a real
       page rather than an apology.
       ---------------------------------------------------------------------- */
    ?>
    <section class="fx__static fx__static--hero">
        <p class="fx__eyebrow">Fenster Glazing, Milton Keynes</p>
        <h1 class="fx__title">Windows and doors, <em>fitted properly</em>.</h1>
        <p class="fx__lede">
            We supply and install windows, doors, bifolds, roof lanterns and replacement glazing
            across Milton Keynes and the counties around it. Price the job online in minutes,
            or have someone come out and go through it with you.
        </p>
        <div class="fx__actions">
            <a class="fx__btn" href="<?php echo esc_url(home_url('/online-quote/')); ?>">Get an instant price</a>
            <a class="fx__btn fx__btn--ghost" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Book a free consultation</a>
        </div>
    </section>

    <?php /* ------------------------------------------------------- below the fold */ ?>
    <div class="fx__below">
        <section class="fx__section">
            <header class="fx__section-head">
                <h2>The range, and what we can actually show you.</h2>
                <p>
                    Every product marked below has a real model behind it, exported from the
                    configurator rather than modelled by hand. The rest are photographed.
                </p>
            </header>

            <div class="fx__index">
                <?php foreach ($products as $i => $product) : ?>
                    <?php $has_model = isset($modelled[$product['slug']]); ?>
                    <a class="fx__index-item" href="<?php echo esc_url($product['url']); ?>">
                        <span class="fx__index-idx"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <span class="fx__index-name"><?php echo esc_html($product['label']); ?></span>
                        <?php if ($product['spec'] !== '') : ?>
                            <span class="fx__index-meta"><?php echo esc_html($product['spec']); ?></span>
                        <?php endif; ?>
                        <?php if ($has_model) : ?>
                            <span class="fx__index-badge">
                                <?php echo esc_html($modelled[$product['slug']]['animated'] ? 'Animated 3D model' : '3D model'); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php
            /* The honest note. `AI.md` requires that nothing on this site presents
               the same geometry as two different products, and `3d.md` records
               that size is only a real axis for bifolds. Saying so on the page is
               cheaper than being caught not saying it. */
            ?>
            <p class="fx__note">
                <b>About the models.</b>
                Thirteen products on this page carry real geometry exported from WindowCAD, the
                configurator this business quotes from. All thirteen are verified as distinct
                meshes, so nothing here shows one product twice under two names. Size is
                deliberately not a variable in this scene: only bifold doors genuinely vary by
                size in the current export set, so showing size options would be describing a
                range that does not exist yet. Colour <em>is</em> real and is changed at runtime,
                which is why the door changes finish as the light crosses it.
            </p>
        </section>

        <footer class="fx__foot">
            Experimental sandbox. The live homepage is
            <a href="<?php echo esc_url(home_url('/')); ?>">over here</a> and is untouched.
        </footer>
    </div>
</div>
