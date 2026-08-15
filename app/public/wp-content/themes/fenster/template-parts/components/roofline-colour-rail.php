<?php
/**
 * Roofline colour rails.
 *
 * Owner instruction, 2026-08-15: a swipeable rail like the colour hub's, on
 * `/roofline/` only, and the roofline finishes are NOT to be added to
 * `/colour-options/`. That hub is the window and door foil and powder-coat
 * range, which is neither what a roofline is made from nor where it is bought.
 * So this component reads `roofline_colours`, a separate array with no
 * cross-reference to `colour_options` in either direction.
 *
 * NO NEW JAVASCRIPT. The markup is the colour hub's `.fg-colour-rail` exactly,
 * so the existing `[data-fg-colour-rail]` controller picks these up on sight and
 * they get the same native scroll-snap, click-drag, glide and keyboard handling.
 * The same approach the rest of this rebuild took with the story canvas: reuse
 * the component, write no controller.
 *
 * TWO RAILS, NOT ONE, and that is the whole reason this is a component rather
 * than a loop. The board photographs are roofline corners on brick against sky;
 * the gutter photographs are isolated fittings on white. Shuffling the two
 * treatments into one rail is the fault already recorded against the CGI render
 * in a row of photographs on the doors hub. They are also genuinely two
 * decisions, which the copy says out loud.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$roofline_groups = fenster_data('roofline_colours.groups', []);
$roofline_groups = is_array($roofline_groups) ? $roofline_groups : [];

if (empty($roofline_groups)) {
    return;
}

/* The heading and intro were the specification-choices band's until this rail
   existed. They move here with the content rather than being rewritten, and the
   band is gated off for this route in `generated-page.php` so the two cannot
   both render: a card listing fifteen colour names directly above a rail showing
   the same fifteen in photographs is a table of contents for the thing under it.
   That is the same reason the band is gated off for `/upvc-doors/`. */
$roofline_heading = (string) ($args['heading'] ?? __('Roofline colours, chosen to match what is below.', 'fenster'));
$roofline_intro = (string) ($args['intro'] ?? __('Roofline is chosen to sit with the windows and doors below it, so the colour is the decision worth making early.', 'fenster'));
?>
<section id="roofline-colours" class="fg-roofline-colours" aria-labelledby="fg-roofline-colours-title">
    <div class="container">
        <div class="fg-upvc-colours__heading">
            <p class="eyebrow"><?php esc_html_e('Specification choices', 'fenster'); ?></p>
            <h2 id="fg-roofline-colours-title"><?php echo esc_html($roofline_heading); ?></h2>
            <p><?php echo esc_html($roofline_intro); ?></p>
        </div>

        <?php foreach ($roofline_groups as $group_key => $group) : ?>
            <?php
            $group_colours = is_array($group['colours'] ?? null) ? $group['colours'] : [];
            if (empty($group_colours)) {
                continue;
            }
            $group_label = (string) ($group['label'] ?? '');
            /* The group label is an eyebrow rather than an h3, because the rail's
               own stylesheet styles `.fg-colour-rail__slide h3` as the colour
               name. Making the group an h3 as well would put two different things
               at one level and restyle every tile. The group is still named for a
               screen reader: it goes into the region label on the track, which is
               how the colour hub names its material rails. */
            ?>
            <p class="eyebrow fg-roofline-colours__group"><?php echo esc_html($group_label); ?></p>
            <div class="fg-colour-rail fg-colour-rail--roofline" data-fg-colour-rail>
                <ul
                    class="fg-colour-rail__track"
                    data-fg-colour-rail-viewport
                    tabindex="0"
                    role="region"
                    aria-label="<?php echo esc_attr(sprintf(__('%s. Scroll or swipe sideways.', 'fenster'), $group_label)); ?>"
                >
                    <?php foreach ($group_colours as $colour) : ?>
                        <?php
                        $colour_name = (string) ($colour['name'] ?? '');
                        $colour_image = (string) ($colour['image'] ?? '');
                        if ($colour_name === '' || $colour_image === '') {
                            continue;
                        }
                        /* Alt text describes what is actually in the frame. On a
                           board photograph the gutter is usually black whatever
                           the boards are, so the alt names the boards and stops
                           there rather than claiming the whole corner is in that
                           colour. On a gutter photograph no profile is named,
                           because nobody has confirmed which of these are
                           half-round and which are square, and identifying a part
                           from a product shot is how the tilt and turn keep
                           shipped to live captioned as a cam. */
                        $colour_alt = $group_key === 'guttering'
                            ? sprintf(__('Gutter and downpipe outlet in %s', 'fenster'), $colour_name)
                            : sprintf(__('Fascia and soffit in %s, at the corner of a tiled roof', 'fenster'), $colour_name);
                        ?>
                        <li
                            class="fg-colour-rail__slide"
                            data-fg-colour-slide
                            data-colour-slug="<?php echo esc_attr(sanitize_title($colour_name)); ?>"
                        >
                            <span class="fg-colour-rail__media<?php echo ! empty($colour['pale']) ? ' is-pale' : ''; ?>">
                                <img
                                    src="<?php echo esc_url(fenster_generated_url($colour_image)); ?>"
                                    alt="<?php echo esc_attr($colour_alt); ?>"
                                    width="460"
                                    height="272"
                                    loading="lazy"
                                >
                            </span>
                            <h3><?php echo esc_html($colour_name); ?></h3>
                            <?php if (! empty($colour['finish'])) : ?>
                                <p><?php echo esc_html((string) $colour['finish']); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="fg-colour-rail__hint"><?php esc_html_e('Drag or swipe to see more', 'fenster'); ?></p>
            </div>
        <?php endforeach; ?>

        <?php /* The note carries the one thing the two rails do not say on their
                 own, and nothing the heading above has already said. It links to
                 the enquiry rather than to `/colour-options/`, which is the wrong
                 range for this route. */ ?>
        <p class="fg-upvc-colours__note">
            <?php esc_html_e('The boards and the guttering are chosen separately, so the two do not have to match.', 'fenster'); ?>
            <a class="fg-cw-link" href="#fenster-enquiry"><?php esc_html_e('Ask about a colour', 'fenster'); ?></a>
        </p>
    </div>
</section>
