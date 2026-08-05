<?php
/**
 * Key specifications strip.
 *
 * Four tiles of product fact. Where the route has both glazing figures in
 * `glazing_u_values`, the U-value tile becomes the one interactive thing in the
 * strip: a double/triple toggle that swaps the figure in place.
 *
 * The caption slot under the figure is always occupied, either by the toggle or
 * by a static "Double glazed" line, so a route that cannot take triple is the
 * same height as one that can and the row never goes ragged. That static line
 * is also how the page says a system is double-only without writing a sentence
 * about what is not included.
 *
 * Shared because heritage aluminium doors returns before the generic product
 * tail and rendered its own copy of this markup.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$pulse_usps  = is_array($args['usps'] ?? null) ? array_values($args['usps']) : [];
$pulse_slug  = (string) ($args['slug'] ?? '');
$pulse_title = (string) ($args['title'] ?? '');

if (count($pulse_usps) !== 4) {
    return;
}

$glazing_all = fenster_data('glazing_u_values', []);
$glazing     = is_array($glazing_all) && isset($glazing_all[$pulse_slug]) && is_array($glazing_all[$pulse_slug])
    ? $glazing_all[$pulse_slug]
    : [];

$double = (string) ($glazing['double'] ?? '');
$triple = (string) ($glazing['triple'] ?? '');

/* Owner instruction, 2026-08-04: on the Liniar routes the strip states the
   lowest achievable figure only, starred, and both figures move to the
   EnergyPlus banner further down the page. Two numbers at the top of a page
   ask the visitor to choose between them before anything has explained the
   difference. The star is the site's existing convention for "lowest
   achievable, not guaranteed for every size"; Legend already answers on it. */
$single_routes = (array) fenster_data('single_u_value_routes', []);
$single_u = in_array($pulse_slug, $single_routes, true);
$best = $triple !== '' ? $triple : $double;
?>
<section class="fg-product-pulse fg-product-pulse--usps" aria-label="<?php echo esc_attr($pulse_title . ' key specifications'); ?>">
    <div class="container fg-product-pulse__inner">
        <div>
            <p class="eyebrow"><?php esc_html_e('Key specifications', 'fenster'); ?></p>
            <h2><?php echo esc_html($pulse_title); ?></h2>
        </div>
        <ul aria-label="<?php esc_attr_e('Four product specifications', 'fenster'); ?>">
            <?php foreach ($pulse_usps as $usp) : ?>
                <?php
                $label     = (string) ($usp['label'] ?? '');
                $value     = (string) ($usp['value'] ?? '');
                $is_uvalue = $double !== '' && stripos($label, 'U-value') === 0;
                ?>
                <?php if ($is_uvalue) : ?>
                    <li class="fg-product-pulse__glazing">
                        <small><?php esc_html_e('U-value', 'fenster'); ?></small>
                        <?php
                        /* Triple above double, on the owner's instruction. Both
                           are always visible: a system that takes triple shows
                           two rows, one that does not shows a single row that
                           still names its glazing, so the difference between
                           the two products is legible without a sentence about
                           what is not included. */
                        $rows = [];
                        if ($single_u) {
                            /* Owner instruction, 2026-08-05: the glazing line comes
                               off and the figure carries the star on its own. The
                               thickness is stated on the EnergyPlus banner further
                               down, so naming it twice at the top of the page was
                               the thing to lose, not the figure. The tile then
                               matches the other three, which carry no caption. */
                            $rows[] = ['figure' => $best . '*', 'glazing' => ''];
                        } else {
                            if ($triple !== '') {
                                $rows[] = ['figure' => $triple, 'glazing' => __('Triple', 'fenster')];
                            }
                            $rows[] = ['figure' => $double, 'glazing' => __('Double', 'fenster')];
                        }
                        ?>
                        <span class="fg-product-pulse__glazing-rows<?php echo $single_u ? ' is-single' : ''; ?>">
                            <?php foreach ($rows as $row) : ?>
                                <span>
                                    <strong><?php echo esc_html($row['figure']); ?></strong>
                                    <?php if ($row['glazing'] !== '') : ?>
                                        <i><?php echo esc_html($row['glazing']); ?></i>
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; ?>
                        </span>
                        <?php if ($single_u && $best !== '') : ?>
                            <?php /* Owner instruction, 2026-08-05: the note belongs
                                     tight under the figure it explains, not below the
                                     strip. `__inner` is a two-column grid, so a note
                                     placed after the list auto-flowed into a second
                                     row under the heading and stretched the whole
                                     box; inside the tile it costs no row at all. */ ?>
                            <p class="fg-product-pulse__note"><?php esc_html_e('* Lowest achievable whole-window U-value.', 'fenster'); ?></p>
                        <?php endif; ?>
                    </li>
                <?php else : ?>
                    <li>
                        <small><?php echo esc_html($label); ?></small>
                        <strong><?php echo esc_html($value); ?></strong>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
