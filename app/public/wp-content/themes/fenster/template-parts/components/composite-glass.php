<?php
/**
 * Decorative glass for composite doors.
 *
 * WHY THIS IS A COMPONENT. The markup lived inline in the shared product tail
 * behind `if (! $is_composite_doors && ! empty($product_glass_styles))`, and
 * `composite-doors` is the ONLY route in `product_content` that carries a
 * `glass_styles` array. So the one page with the data was the one page excluded
 * from rendering it, and the section reached no route at all. It was presumably
 * gated when composite doors moved to its own v2 template, and nothing in v2
 * ever picked it up.
 *
 * Pulled out here so the bespoke template can place it deliberately — after the
 * style range, because glass is the decision you make once you have a shape —
 * and so there is still exactly one copy of this markup.
 *
 * WHAT IS PICTURED IS WHAT WE HOLD ARTWORK FOR, AND THE COPY SAYS SO. Eleven of
 * the twenty-six decorative designs the quote tool offers. The honest move is to
 * show the eleven properly and say the tool carries more, rather than padding
 * the grid with name-only tiles or borrowing a door photograph and calling it a
 * glass sample. See the Marked Placeholders Rule in `AI.md` for the same
 * principle applied to photography.
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
?>
<section class="fg-composite-glass" aria-labelledby="fg-composite-glass-title">
    <div class="container">
        <div class="fg-composite-glass__head">
            <div>
                <p class="eyebrow"><?php esc_html_e('Decorative glass', 'fenster'); ?></p>
                <h2 id="fg-composite-glass-title"><?php esc_html_e('The glass changes the door more than the colour does.', 'fenster'); ?></h2>
            </div>
            <p>
                <?php
                echo esc_html($fg_glass_intro !== ''
                    ? $fg_glass_intro
                    : __('Decorative glass gives a composite entrance its character. Most decorative units are triple glazed and laminated as standard.', 'fenster'));
                ?>
            </p>
        </div>

        <div class="fg-composite-glass__grid" aria-label="<?php esc_attr_e('Decorative glass designs for composite doors', 'fenster'); ?>">
            <?php foreach ($fg_glass_items as $index => $fg_style) : ?>
                <?php
                $fg_name  = trim((string) ($fg_style['name'] ?? ''));
                $fg_image = trim((string) ($fg_style['image'] ?? ''));
                $fg_copy  = trim((string) ($fg_style['copy'] ?? ''));
                if ($fg_name === '') {
                    continue;
                }
                ?>
                <article class="fg-composite-glass-card">
                    <span class="fg-composite-glass-card__number"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                    <?php if ($fg_image !== '') : ?>
                        <figure>
                            <img
                                src="<?php echo esc_url(fenster_generated_url($fg_image)); ?>"
                                alt="<?php echo esc_attr(sprintf(
                                    /* translators: %s: glass design name. */
                                    __('%s decorative glass for composite doors', 'fenster'),
                                    $fg_name
                                )); ?>"
                                loading="lazy" decoding="async">
                        </figure>
                    <?php endif; ?>
                    <div>
                        <h3><?php echo esc_html($fg_name); ?></h3>
                        <?php if ($fg_copy !== '') : ?>
                            <p><?php echo esc_html($fg_copy); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php
        /* THE TWO THINGS A SWATCH CANNOT TELL YOU, said once each.

           The first is the range: the tool offers twenty-six decorative designs
           and we hold usable artwork for eleven, so the grid above is a
           selection rather than the list. Saying that is better than a grid of
           name-only tiles, and far better than showing a photograph of a door
           and letting it stand in for a glass sample.

           The second is the one the brief singles out: a design is cut to the
           aperture, so the same glass reads completely differently in a full
           panel and in a diamond. Nobody choosing from square swatches would
           guess that, and it is the commonest reason a finished door surprises
           somebody. */
        ?>
        <p class="fg-composite-glass__aperture">
            <?php esc_html_e('Every design is cut to the shape of the opening, so the same glass reads very differently in a full-length panel, a half panel or a small diamond. That is worth seeing before you settle on one: the tool draws your chosen design into your chosen door style, and the showroom has the real thing.', 'fenster'); ?>
        </p>

        <p class="fg-composite-glass__range">
            <?php esc_html_e('Eleven designs are pictured here. The online tool carries twenty-six, including the plain and privacy options, and draws each one into the door style you have picked.', 'fenster'); ?>
        </p>

        <?php if ($fg_glass_note !== '') : ?>
            <p class="fg-composite-glass__note"><?php echo esc_html($fg_glass_note); ?></p>
        <?php endif; ?>
    </div>
</section>
