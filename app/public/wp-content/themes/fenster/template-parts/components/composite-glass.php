<?php
/**
 * Decorative glass for composite doors.
 *
 * WHY THIS IS A COMPONENT. The markup lived inline in the shared product tail
 * behind `if (! $is_composite_doors && ! empty($product_glass_styles))`, and
 * `composite-doors` is the ONLY route in `product_content` that carries a
 * `glass_styles` array. So the one page with the data was the one page excluded
 * from rendering it, and the section reached no route at all.
 *
 * ---- 2026-08-27, third pass: the right asset for each design -------------
 *
 * IT WAS SHOWING 250px THUMBNAILS BLOWN UP INTO 270px CARDS. Every design in
 * `product_content` points at `assets/images/products/composite-glass/*.jpg`,
 * which are 250x250 pattern crops, and the grid rendered them at 4:3 landscape.
 * Two of them, Chatsworth and Wentworth, are 1KB near-white squares, because a
 * satin panel with a fine clear border photographs as nothing at all when it is
 * cropped to a macro square. The section meant to show you glass was showing
 * blurred fragments, and two cards read as broken images.
 *
 * SIX OF THE ELEVEN HAVE STUDIO RENDERS OF THE DESIGN IN A DOOR, at 800x1000,
 * in `composite-distinction/glass-doors/`, and they were unused. Those six lead
 * the section now, portrait and large. It is a better answer to the question
 * the section exists for — a pattern crop cannot tell you what a design looks
 * like from the pavement — and it makes the aperture point without asserting
 * it: the Lunna render carries the same design in an arched top light, two
 * rectangular lites and a sunburst, all in one photograph.
 *
 * THE OTHER FIVE STAY AS PATTERN SWATCHES AND ARE LABELLED AS PATTERNS. At
 * 250px they are sharp at the size they are shown, which the old grid was not.
 * Presenting a crop as though it were a door is the fault the Marked
 * Placeholders Rule in `AI.md` exists to prevent; presenting it as a crop is
 * honest and still useful.
 *
 * THE SPLIT IS DERIVED FROM THE FILESYSTEM, not hard-coded. A design moves into
 * the top grid the moment a door render with its slug appears, and nothing here
 * needs editing.
 *
 * WHAT IS PICTURED IS WHAT WE HOLD ARTWORK FOR, AND THE COPY SAYS SO. Eleven of
 * the twenty-six decorative designs the quote tool offers.
 *
 * ---- 2026-09-02, fourth pass: one door at a time ------------------------
 *
 * OWNER: "the finishes section sucks." The chapter was 3,408px - twenty-seven
 * per cent of the page - and held nineteen bordered boxes: six glass cards
 * with caption boxes, eight handle cards, and all of it inside the chapter's
 * own white panel. `STYLE.md` asks for one strong image treatment before
 * several small ones, and forbids cards inside cards.
 *
 * THE THREE STEPS ALSO HAD THREE DIFFERENT GRAMMARS. Glass was a 3-up card
 * grid, colour was a preview plus a swatch wall, handles were an 8-up card
 * row. Nothing shared a column and the chapter read as three sections of three
 * different sites.
 *
 * THE PICKER ALREADY EXISTED. `[data-fg-door-selector]` in `main.js` drives
 * the paint range directly below this and reads `data-door-*` off each option
 * when `data-fg-glass-selector` is set. The six door renders became one large
 * preview and six names using it, so glass and colour now have the same shape
 * and NO JavaScript changed.
 *
 * Expects `$args['items']`, `$args['intro']`, `$args['note']`.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$fg_glass_items = isset($args['items']) && is_array($args['items']) ? array_values($args['items']) : [];
if (empty($fg_glass_items)) {
    return;
}

$fg_glass_intro = trim((string) ($args['intro'] ?? ''));
$fg_glass_note  = trim((string) ($args['note'] ?? ''));

/* THEME-RELATIVE, so these are built with `FENSTER_THEME_URI` and NOT with
   `fenster_generated_url()`. That helper maps `/wp-content/themes/fenster/...`
   onto the theme URI and returns anything else unchanged, so a theme-relative
   path comes back untouched and resolves against the site root, where nothing
   is. Every render 404'd on the first deploy of this section. The line-art
   helper in `inc/composite-door-data.php` uses `FENSTER_THEME_URI` for the
   same reason. */
$fg_door_rel = '/assets/images/products/composite-distinction/glass-doors/';

/**
 * Chatsworth and Wentworth are the two double-glazed designs; everything else
 * is triple glazed and laminated as standard. It is the one hard difference
 * between these designs and the section already states it in prose, so the two
 * cards it applies to carry it.
 */
$fg_double_glazed = ['chatsworth', 'wentworth'];

$fg_in_door = [];
$fg_patterns = [];

foreach ($fg_glass_items as $fg_style) {
    $fg_name = trim((string) ($fg_style['name'] ?? ''));
    if ($fg_name === '') {
        continue;
    }

    $fg_slug = sanitize_title($fg_name);
    $fg_stem = $fg_door_rel . $fg_slug . '-';
    $fg_style['slug'] = $fg_slug;
    $fg_style['name'] = $fg_name;

    /* Derived, so a design promotes itself the moment its render lands. */
    if (is_readable(FENSTER_THEME_DIR . $fg_stem . '800w.webp')) {
        $fg_style['stem'] = $fg_stem;
        $fg_style['double'] = in_array($fg_slug, $fg_double_glazed, true);
        $fg_in_door[] = $fg_style;
    } else {
        $fg_patterns[] = $fg_style;
    }
}

if (empty($fg_in_door) && empty($fg_patterns)) {
    return;
}
?>
<section class="fg-composite-glass" aria-labelledby="fg-composite-glass-title">
    <div class="container">
        <header class="fg-finish__step-head">
            <p class="eyebrow"><?php esc_html_e('Decorative glass', 'fenster'); ?></p>
            <h2 id="fg-composite-glass-title"><?php esc_html_e('The glass changes the door more than the colour does.', 'fenster'); ?></h2>
            <p>
                <?php
                echo esc_html($fg_glass_intro !== ''
                    ? $fg_glass_intro
                    : __('Decorative glass gives a composite entrance its character. Most decorative units are triple glazed and laminated as standard.', 'fenster'));
                ?>
            </p>
        </header>

        <?php
        /* THE PATTERNS AND THE NOTE MOVE INTO THE PICKER'S RIGHT COLUMN. The
           preview is 650px tall and the strip beside it was 161px, so the
           right of the section was 580px of nothing while these two blocks
           queued underneath. Captured rather than moved inline, because they
           still have to render on their own if no door render exists. */
        ob_start();
        ?>
        <?php if (! empty($fg_patterns)) : ?>
            <?php
            /* AND THE ONES WE ONLY HOLD THE PATTERN FOR, said plainly. Showing
               a 250px crop at 250px is honest; showing it at 270px in a card
               that looks like a door render is not. They stay out of the picker
               for the same reason: the preview is 800px tall and these would go
               into it four times their own size. */
            ?>
            <div class="fg-glass-patterns">
                <p class="fg-glass-patterns__intro">
                    <?php esc_html_e('Five more we hold the pattern for but not a door render. The tool draws any of them into the style you have picked.', 'fenster'); ?>
                </p>
                <ul aria-label="<?php esc_attr_e('Further decorative glass patterns', 'fenster'); ?>">
                    <?php foreach ($fg_patterns as $fg_style) : ?>
                        <?php $fg_image = trim((string) ($fg_style['image'] ?? '')); ?>
                        <li>
                            <?php if ($fg_image !== '') : ?>
                                <img
                                    src="<?php echo esc_url(fenster_generated_url($fg_image)); ?>"
                                    alt="<?php echo esc_attr(sprintf(
                                        /* translators: %s: glass design name. */
                                        __('The %s decorative glass pattern', 'fenster'),
                                        (string) $fg_style['name']
                                    )); ?>"
                                    loading="lazy" decoding="async" width="250" height="250">
                            <?php endif; ?>
                            <span><?php echo esc_html((string) $fg_style['name']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
        /* ONE NOTE, NOT THREE. This closed with three consecutive blocks in
           three different treatments: a green-ruled aperture note, a plain
           range note and a bordered availability box. The owner's verdict on
           the page was "random boxes of text everywhere", and this was the
           worst of it. Everything true is still here, in one place. */
        ?>
        <div class="fg-composite-glass__foot">
            <p>
                <?php esc_html_e('Every design is cut to the shape of the opening, so the same glass reads very differently in a full-length panel, an arched top light and a small diamond. Several of the doors above show one design doing all three at once.', 'fenster'); ?>
            </p>
            <p>
                <?php esc_html_e('Eleven are pictured. The tool carries twenty-six including the plain and privacy options, and draws your chosen design into your chosen door style.', 'fenster'); ?>
                <?php if ($fg_glass_note !== '') : ?>
                    <span class="fg-composite-glass__avail"><?php echo esc_html($fg_glass_note); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <?php $fg_glass_side = trim((string) ob_get_clean()); ?>

        <?php if (! empty($fg_in_door)) : ?>
            <?php
            /* ONE DOOR AT A TIME, THE SAME WAY THE PAINT RANGE UNDER IT WORKS.
               This was six 4:5 door renders in six bordered white cards, each
               with its own caption box, inside the chapter's own white panel:
               nineteen boxes in one chapter, and `STYLE.md` asks for one strong
               image treatment before several small ones. Worse, it was a third
               grammar in a chapter that already had two, so glass, colour and
               handles each looked like a different section of a different site.

               The picker mechanism already existed. `[data-fg-door-selector]`
               in `main.js` drives the paint range directly below this, reads
               `data-door-*` off each option when `data-fg-glass-selector` is
               present, and needs no new JavaScript at all. So the six designs
               become one large door and six names, which is the same shape as
               the colour step, and the chapter reads as one bench. */
            $fg_first = $fg_in_door[0];
            ?>
            <div class="fg-glass-pick" data-fg-door-selector data-fg-glass-selector>
                <figure class="fg-glass-pick__preview">
                    <img
                        data-fg-choice-image
                        src="<?php echo esc_url(FENSTER_THEME_URI . $fg_first['stem'] . '480w.webp'); ?>"
                        srcset="<?php echo esc_attr(implode(', ', [
                            FENSTER_THEME_URI . $fg_first['stem'] . '480w.webp 480w',
                            FENSTER_THEME_URI . $fg_first['stem'] . '800w.webp 800w',
                        ])); ?>"
                        sizes="(max-width: 860px) 86vw, 34vw"
                        alt="<?php echo esc_attr(sprintf(
                            /* translators: %s: glass design name. */
                            __('A composite door glazed with the %s decorative design', 'fenster'),
                            (string) $fg_first['name']
                        )); ?>"
                        width="800" height="1000" decoding="async">
                    <figcaption>
                        <strong data-fg-choice-name><?php echo esc_html((string) $fg_first['name']); ?></strong>
                        <span data-fg-choice-copy><?php echo esc_html((string) ($fg_first['copy'] ?? '')); ?></span>
                    </figcaption>
                </figure>

                <div class="fg-glass-pick__side">
                    <ul class="fg-glass-pick__options" aria-label="<?php esc_attr_e('Decorative glass designs shown in a door', 'fenster'); ?>">
                    <?php foreach ($fg_in_door as $fg_i => $fg_style) : ?>
                        <?php
                        $fg_alt = sprintf(
                            /* translators: %s: glass design name. */
                            __('A composite door glazed with the %s decorative design', 'fenster'),
                            (string) $fg_style['name']
                        );
                        ?>
                        <li>
                            <button
                                type="button"
                                data-fg-choice-option
                                aria-pressed="<?php echo $fg_i === 0 ? 'true' : 'false'; ?>"
                                data-door-src="<?php echo esc_url(FENSTER_THEME_URI . $fg_style['stem'] . '480w.webp'); ?>"
                                data-door-srcset="<?php echo esc_attr(implode(', ', [
                                    FENSTER_THEME_URI . $fg_style['stem'] . '480w.webp 480w',
                                    FENSTER_THEME_URI . $fg_style['stem'] . '800w.webp 800w',
                                ])); ?>"
                                data-door-alt="<?php echo esc_attr($fg_alt); ?>"
                                data-preview-name="<?php echo esc_attr((string) $fg_style['name']); ?>"
                                data-preview-copy="<?php echo esc_attr((string) ($fg_style['copy'] ?? '')); ?>">
                                <img
                                    src="<?php echo esc_url(FENSTER_THEME_URI . $fg_style['stem'] . '240w.webp'); ?>"
                                    alt="" aria-hidden="true"
                                    loading="lazy" decoding="async" width="240" height="300">
                                <span class="fg-glass-pick__name">
                                    <?php echo esc_html((string) $fg_style['name']); ?>
                                </span>
                                <?php if (! empty($fg_style['double'])) : ?>
                                    <span class="fg-glass-pick__tag"><?php esc_html_e('Double glazed', 'fenster'); ?></span>
                                <?php endif; ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <?php echo $fg_glass_side; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- captured markup, escaped at source. ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($fg_in_door)) : ?>
            <?php echo $fg_glass_side; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- captured markup, escaped at source. ?>
        <?php endif; ?>


    </div>
</section>
