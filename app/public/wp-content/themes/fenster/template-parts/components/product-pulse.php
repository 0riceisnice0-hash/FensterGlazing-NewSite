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
                    <li class="fg-product-pulse__glazing"<?php echo $triple !== '' ? ' data-fg-glazing' : ''; ?>>
                        <small><?php esc_html_e('U-value', 'fenster'); ?></small>
                        <strong data-fg-glazing-figure><?php echo esc_html($double); ?></strong>
                        <?php if ($triple !== '') : ?>
                            <span class="fg-product-pulse__glazing-toggle" role="group" aria-label="<?php esc_attr_e('Choose glazing', 'fenster'); ?>">
                                <button type="button" class="is-active" data-fg-glazing-option="<?php echo esc_attr($double); ?>" aria-pressed="true"><?php esc_html_e('Double', 'fenster'); ?></button>
                                <button type="button" data-fg-glazing-option="<?php echo esc_attr($triple); ?>" aria-pressed="false"><?php esc_html_e('Triple', 'fenster'); ?></button>
                            </span>
                        <?php else : ?>
                            <span class="fg-product-pulse__glazing-note"><?php esc_html_e('Double glazed', 'fenster'); ?></span>
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
