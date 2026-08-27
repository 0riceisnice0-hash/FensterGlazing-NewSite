<?php
/**
 * The composite door style range — every door we can actually put a price on.
 *
 * WHAT THIS REPLACED, AND WHY. The page carried a drifting wall of 33
 * photographed door faces under the heading "The range runs to over 300 door
 * styles." Both halves were a problem: the number described Distinction's
 * catalogue rather than what our quoting system can price, and the section
 * offered no way to act on a door beyond "send us the name". A visitor who
 * liked one had to describe it to us in an email.
 *
 * THE RANGE HERE IS WHAT WINDOWCAD CAN PRICE. 142 doors across the six
 * collections, from `fenster_composite_door_collections()`. Distinction publish
 * more; a door we cannot quote is a door that wastes somebody's afternoon.
 *
 * THE DRAWINGS ARE LINE ART, NOT PHOTOGRAPHS, AND THAT IS THE POINT. A door
 * style is a shape — where the panels sit, where the glass sits. Line art shows
 * that at 1.3KB a door, so a whole collection fits on one screen and the
 * differences are legible at a glance. Photographs are better at colour and
 * finish, which is what the finishes chapter below does. Each is doing the job
 * it is good at rather than both doing the same one badly.
 *
 * CLICKING A DOOR OPENS THE QUOTE TOOL ON THAT DOOR. This is the whole reason
 * the section exists rather than being a gallery: the brief's warning is that a
 * customer must not choose their door twice, so choosing it here IS choosing it,
 * and WindowCAD picks up mid-configuration rather than at the start.
 *
 * PROGRESSIVE ENHANCEMENT RUNS IN THE HONEST DIRECTION. Every collection ships
 * in the HTML with its own heading, so with no JavaScript a visitor gets all 142
 * doors as six labelled grids and every link still works. The controller reveals
 * the switcher and collapses it to one collection at a time.
 *
 * ---- 2026-08-27 overhaul -------------------------------------------------
 *
 * THE COLLECTIONS CAROUSEL WAS ABSORBED INTO THIS SECTION. A 912px section
 * above the range showed the same six collections as cards, each forcing a tall
 * door render into a column about 105px wide so the doors were cut off, on
 * three different render backgrounds, with uneven rows. Its only unique content
 * was a slab line and a description per collection, which now live in
 * `fenster_composite_door_collections()` and render inside each panel. The six
 * cards were the six tabs.
 *
 * THE DRAWINGS ARE SET AT `opacity` RATHER THAN RECOLOURED. They are
 * `fill:none; stroke:currentColor` and are loaded through `<img src>`, which is
 * an isolated document, so `currentColor` resolves to their own black and no
 * amount of CSS on the `<img>` changes it — the rule `AI.md` already records
 * against the quiz. The artwork also carries its stroke weights inline, 55.9 on
 * the frame and 28 on the panels against a 914 viewBox, which is what made
 * eight columns of them read as a wall. Opacity is the one lever that works on
 * an isolated document without a mask, and unlike `mask-image` it degrades to
 * the drawing rather than to a solid block.
 *
 * FIVE COLUMNS, NOT EIGHT, IS A COUNTING DECISION. The six collections hold 19,
 * 43, 27, 25, 23 and 5 doors. At five columns none of them leaves a remainder of
 * one, so no collection strands a single door beside four empty cells the way
 * 19-in-eights did. Check that before changing the column count.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once FENSTER_THEME_DIR . '/inc/composite-door-data.php';

$fg_cds_collections = fenster_composite_door_collections();
if (empty($fg_cds_collections)) {
    return;
}

$fg_cds_total = array_sum(array_map(static fn ($c) => count($c['styles']), $fg_cds_collections));

/* Rendered inside the choosing chapter's own surface, which supplies the
   container. Standalone is kept working for any route that calls this on its
   own. */
$fg_cds_bare = ! empty($args['bare']);
?>
<section class="fg-cds<?php echo $fg_cds_bare ? ' fg-cds--bare' : ''; ?>" aria-labelledby="fg-cds-title">
    <?php if (! $fg_cds_bare) : ?><div class="container"><?php endif; ?>
        <header class="fg-cds__head">
            <p class="eyebrow"><?php esc_html_e('The style range', 'fenster'); ?></p>
            <h2 id="fg-cds-title"><?php esc_html_e('Every door we can price, drawn to scale.', 'fenster'); ?></h2>
            <p>
                <?php
                echo esc_html(sprintf(
                    /* translators: %d: number of door styles. */
                    __('All %d of them, grouped the way the quote tool groups them. The drawings are to scale against each other, so a six panel really is squarer than a cottage. Pick one and the online tool opens on that door, ready for your colour, glass and handles.', 'fenster'),
                    $fg_cds_total
                ));
                ?>
            </p>
        </header>

        <?php /* Ships hidden; the controller reveals it. No JavaScript, all six grids. */ ?>
        <div class="fg-cds__switcher" data-fg-cds-switcher role="tablist" aria-label="<?php esc_attr_e('Door collections', 'fenster'); ?>" hidden>
            <?php foreach ($fg_cds_collections as $i => $collection) : ?>
                <button
                    type="button"
                    role="tab"
                    id="fg-cds-tab-<?php echo esc_attr((string) $i); ?>"
                    aria-controls="fg-cds-panel-<?php echo esc_attr((string) $i); ?>"
                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                    tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>"
                    class="fg-cds__tab">
                    <?php echo esc_html((string) $collection['name']); ?>
                    <span class="fg-cds__tab-count"><?php echo esc_html((string) count($collection['styles'])); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <?php
        /* NARROWING, NOT BROWSING. Owner, 2026-08-27: "don't bombard them with
           all the changes." A hundred and forty two doors is a catalogue, and a
           catalogue you cannot filter is a wall. Every value below is a trait
           already in `fenster_composite_door_collections()`, measured off real
           cassette geometry, so nothing here is a new claim about a door.

           It ships hidden and the controller reveals it: with no JavaScript the
           grids are complete and every link still works, which is the same
           bargain the collection switcher makes. */
        $fg_cds_filters = [
            'g' => [
                'label' => __('Glass', 'fenster'),
                'opts'  => [
                    ''  => __('Any', 'fenster'),
                    '3' => __('Lots', 'fenster'),
                    '2' => __('Some', 'fenster'),
                    '1' => __('A little', 'fenster'),
                    '0' => __('None', 'fenster'),
                ],
            ],
            'v' => [
                'label' => __('Shape', 'fenster'),
                'opts'  => [
                    ''  => __('Any', 'fenster'),
                    '0' => __('Square', 'fenster'),
                    '1' => __('Arched', 'fenster'),
                ],
            ],
            'd' => [
                'label' => __('Face', 'fenster'),
                'opts'  => [
                    ''  => __('Any', 'fenster'),
                    '0' => __('Plain', 'fenster'),
                    '1' => __('Some detail', 'fenster'),
                    '2' => __('A feature', 'fenster'),
                ],
            ],
        ];
        ?>
        <div class="fg-cds__filters" data-fg-cds-filters hidden>
            <?php foreach ($fg_cds_filters as $fg_key => $fg_filter) : ?>
                <div class="fg-cds__filter" role="group" aria-label="<?php echo esc_attr($fg_filter['label']); ?>">
                    <span class="fg-cds__filter-label"><?php echo esc_html($fg_filter['label']); ?></span>
                    <?php foreach ($fg_filter['opts'] as $fg_val => $fg_text) : ?>
                        <button
                            type="button"
                            class="fg-cds__chip"
                            data-fg-cds-filter="<?php echo esc_attr($fg_key); ?>"
                            data-value="<?php echo esc_attr((string) $fg_val); ?>"
                            aria-pressed="<?php echo $fg_val === '' ? 'true' : 'false'; ?>">
                            <?php echo esc_html($fg_text); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="fg-cds__panels" data-fg-cds-panels>
            <?php foreach ($fg_cds_collections as $i => $collection) : ?>
                <section
                    class="fg-cds__panel"
                    id="fg-cds-panel-<?php echo esc_attr((string) $i); ?>"
                    aria-labelledby="fg-cds-heading-<?php echo esc_attr((string) $i); ?>"
                    data-fg-cds-panel="<?php echo esc_attr((string) $i); ?>">

                    <?php
                    /* The collection's own line, from the carousel this section
                       absorbed. It answers the question the tab cannot: what is
                       the slab, and who is this collection for. */
                    ?>
                    <div class="fg-cds__panel-head">
                        <h3 class="fg-cds__panel-title" id="fg-cds-heading-<?php echo esc_attr((string) $i); ?>">
                            <?php echo esc_html((string) $collection['name']); ?>
                            <?php if (! empty($collection['slab'])) : ?>
                                <span class="fg-cds__panel-slab"><?php echo esc_html((string) $collection['slab']); ?></span>
                            <?php endif; ?>
                        </h3>
                        <?php if (! empty($collection['intro'])) : ?>
                            <p class="fg-cds__panel-intro"><?php echo esc_html((string) $collection['intro']); ?></p>
                        <?php endif; ?>
                    </div>

                    <ul class="fg-cds__grid">
                        <?php foreach ($collection['styles'] as $style) : ?>
                            <?php
                            $fg_art = fenster_composite_door_line_art((string) $style['key']);
                            if ($fg_art === '') {
                                continue;
                            }
                            $fg_label = sprintf(
                                /* translators: 1: door style name, 2: collection name. */
                                __('%1$s, %2$s collection. Opens the online quote tool on this door.', 'fenster'),
                                (string) $style['name'],
                                (string) $collection['name']
                            );
                            ?>
                            <?php $fg_t = $style['traits'] ?? []; ?>
                            <li class="fg-cds-door"
                                data-g="<?php echo esc_attr((string) ($fg_t['glass'] ?? '')); ?>"
                                data-v="<?php echo esc_attr((string) ($fg_t['curved'] ?? '')); ?>"
                                data-d="<?php echo esc_attr((string) ($fg_t['detail'] ?? '')); ?>">
                                <a
                                    class="fg-cds-door__link"
                                    href="<?php echo esc_url(fenster_composite_door_quote_url((string) $style['key'])); ?>"
                                    target="_blank"
                                    rel="noopener"
                                    aria-label="<?php echo esc_attr($fg_label); ?>">
                                    <span class="fg-cds-door__art">
                                        <img
                                            src="<?php echo esc_url($fg_art); ?>"
                                            alt=""
                                            loading="lazy"
                                            decoding="async"
                                            width="822"
                                            height="2073">
                                    </span>
                                    <span class="fg-cds-door__name"><?php echo esc_html((string) $style['name']); ?></span>
                                    <?php /* The affordance the section was missing: every drawing is a
                                             link into the quote tool and nothing on the card said so. */ ?>
                                    <span class="fg-cds-door__cue" aria-hidden="true"><?php esc_html_e('Price this door', 'fenster'); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php /* The controller fills the count and reveals the button
                             only when a collection is longer than the first look. */ ?>
                    <p class="fg-cds__result" data-fg-cds-result hidden>
                        <span data-fg-cds-count></span>
                        <button type="button" class="fg-cds__more" data-fg-cds-more hidden></button>
                    </p>
                </section>
            <?php endforeach; ?>
        </div>

        <?php
        /* NO SIDE PANEL LINE HERE. The collections copy this section absorbed
           already says side panels go either side of any door, and two places
           making the same point is the fault `TONEOFVOICE.md` names as a page
           built by adding. This note earns its place only by saying what
           happens next. */
        ?>
        <p class="fg-cds__note">
            <?php esc_html_e('Matching glazed side panels can go either side of any of them, and colour, glass and handles are all chosen in the tool once you have picked a shape, with the price moving as you change them.', 'fenster'); ?>
        </p>
    <?php if (! $fg_cds_bare) : ?></div><?php endif; ?>
</section>
