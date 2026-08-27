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

        <?php if (! empty($fg_in_door)) : ?>
            <?php
            /* THE DESIGNS WE CAN SHOW YOU IN A DOOR. This is the treatment the
               section should always have had: a pattern crop tells you what
               glass looks like from six inches away, and nobody chooses a front
               door from six inches away. */
            ?>
            <ul class="fg-glass-doors" aria-label="<?php esc_attr_e('Decorative glass designs shown in a door', 'fenster'); ?>">
                <?php foreach ($fg_in_door as $fg_style) : ?>
                    <li class="fg-glass-door">
                        <figure>
                            <img
                                src="<?php echo esc_url(fenster_generated_url($fg_style['stem'] . '480w.webp')); ?>"
                                srcset="<?php echo esc_attr(implode(', ', [
                                    fenster_generated_url($fg_style['stem'] . '240w.webp') . ' 240w',
                                    fenster_generated_url($fg_style['stem'] . '480w.webp') . ' 480w',
                                    fenster_generated_url($fg_style['stem'] . '800w.webp') . ' 800w',
                                ])); ?>"
                                sizes="(max-width: 860px) 46vw, 30vw"
                                alt="<?php echo esc_attr(sprintf(
                                    /* translators: %s: glass design name. */
                                    __('A composite door glazed with the %s decorative design', 'fenster'),
                                    (string) $fg_style['name']
                                )); ?>"
                                loading="lazy" decoding="async" width="800" height="1000">
                        </figure>
                        <div class="fg-glass-door__body">
                            <h3>
                                <?php echo esc_html((string) $fg_style['name']); ?>
                                <?php if (! empty($fg_style['double'])) : ?>
                                    <span class="fg-glass-door__tag"><?php esc_html_e('Double glazed', 'fenster'); ?></span>
                                <?php endif; ?>
                            </h3>
                            <?php if (trim((string) ($fg_style['copy'] ?? '')) !== '') : ?>
                                <p><?php echo esc_html((string) $fg_style['copy']); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (! empty($fg_patterns)) : ?>
            <?php
            /* AND THE ONES WE ONLY HOLD THE PATTERN FOR, said plainly. Showing
               a 250px crop at 250px is honest; showing it at 270px in a card
               that looks like the six above is not. */
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
    </div>
</section>
