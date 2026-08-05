<?php
/**
 * Key specifications strip.
 *
 * Four tiles of product fact, all the same shape: a label and a value, no
 * captions. The U-value tile reads `glazing_u_values` and prints the lowest
 * figure the route can reach. Where the route has two units that figure is
 * starred and a one-line note under it says what the star means; where it has
 * one there is no lower figure to qualify, so it prints plain.
 *
 * There is no per-route list behind any of that. It is derived from the data, so
 * adding a route to `glazing_u_values` is the only edit needed.
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

/* Owner instruction, 2026-08-04 for the Liniar routes and 2026-08-05 for the
   rest: every strip states the lowest achievable figure and nothing else. Two
   numbers at the top of a page ask the visitor to choose between them before
   anything has explained the difference.

   This is now derived rather than listed. It used to be gated on
   `single_u_value_routes` in site-data, which was a hand-kept list of the routes
   that had been converted; with the behaviour universal that list could only
   drift out of step with the data, so it has gone and the treatment follows the
   figures themselves.

   The star means "this is the lower of two", so it is earned only where a second
   figure exists. Owner instruction, 2026-08-05: a route that takes one glazing
   unit has no lower figure to qualify, so it shows the number plain, with no
   star and no note. That is why this asks whether both are present rather than
   whether one is. "Lowest achievable" is the wording AI.md requires wherever the
   star does appear, and Legend answers on the same distinction. */
$best     = $triple !== '' ? $triple : $double;
$has_both = $double !== '' && $triple !== '';
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
                        /* One row, always. The glazing thickness came off on
                           2026-08-05: where a route has two units the banner
                           further down names them, and where it has one there is
                           nothing to distinguish. That also leaves this tile
                           shaped like the other three, which carry no caption. */
                        $rows = [['figure' => $best . ($has_both ? '*' : ''), 'glazing' => '']];
                        ?>
                        <span class="fg-product-pulse__glazing-rows">
                            <?php foreach ($rows as $row) : ?>
                                <span>
                                    <strong><?php echo esc_html($row['figure']); ?></strong>
                                    <?php if ($row['glazing'] !== '') : ?>
                                        <i><?php echo esc_html($row['glazing']); ?></i>
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; ?>
                        </span>
                        <?php if ($has_both && $best !== '') : ?>
                            <?php
                            /* Owner instruction, 2026-08-05: the note belongs tight
                               under the figure it explains, not below the strip.
                               `__inner` is a two-column grid, so a note placed after
                               the list auto-flowed into a second row under the
                               heading and stretched the whole box; inside the tile it
                               costs no row at all.

                               Kept to one line on purpose. At two lines the tile grew
                               and the row stretched with it, which put the height
                               back. "Whole-window U-value" came off for that: the
                               tile is already labelled U-value and the figure is
                               right above, so the star only has to say which figure
                               it is. "Lowest achievable" is the half AI.md requires
                               and must survive any further trim. */
                            ?>
                            <p class="fg-product-pulse__note"><?php esc_html_e('* Lowest achievable.', 'fenster'); ?></p>
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
