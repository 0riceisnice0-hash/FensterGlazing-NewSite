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
 * that at 1.3KB a door, so the whole of Traditional fits on one screen and the
 * differences are legible at a glance. Photographs are better at colour and
 * finish, which is what the colour section below does. Each is doing the job it
 * is good at rather than both doing the same one badly.
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
?>
<section class="fg-cds" aria-labelledby="fg-cds-title">
    <div class="container">
        <header class="fg-cd3-head fg-cd3-head--wide">
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

        <div class="fg-cds__panels" data-fg-cds-panels>
            <?php foreach ($fg_cds_collections as $i => $collection) : ?>
                <section
                    class="fg-cds__panel"
                    id="fg-cds-panel-<?php echo esc_attr((string) $i); ?>"
                    aria-labelledby="fg-cds-heading-<?php echo esc_attr((string) $i); ?>"
                    data-fg-cds-panel="<?php echo esc_attr((string) $i); ?>">

                    <h3 class="fg-cds__panel-title" id="fg-cds-heading-<?php echo esc_attr((string) $i); ?>">
                        <?php echo esc_html((string) $collection['name']); ?>
                    </h3>

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
                            <li class="fg-cds-door">
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
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endforeach; ?>
        </div>

        <p class="fg-cds__note">
            <?php esc_html_e('Side panels can go either side of any of them, which is how we widen a narrow opening and get more daylight into a dark hallway. Glass and colour come next in the tool.', 'fenster'); ?>
        </p>
    </div>
</section>
