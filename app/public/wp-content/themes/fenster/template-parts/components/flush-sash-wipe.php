<?php
/**
 * Flush against standard: the same window, twice.
 *
 * The page's whole argument is that the sash closes level with the frame instead
 * of standing proud of it. A table can state that; this shows it.
 *
 * Drawn rather than photographed, and that is the point. The first version of
 * this wiped between two studio photographs, `cas-sash-proud` and
 * `cas-flush-level`, and the owner caught the flaw immediately: one is a corner
 * detail and the other a four-way junction, so it was two different windows
 * swapping rather than one window changing. A wipe only makes its argument if
 * everything except the thing being demonstrated stays still, and no two
 * photographs of two real windows can do that.
 *
 * So both halves are the same drawing. Identical outer frame, identical mullions,
 * identical panes, to the pixel — the only thing that changes across the seam is
 * the sash. On the standard side each opener carries the step that stands proud
 * of the frame and the shadow it throws; on the flush side that step is gone and
 * the face is one plane. Because the geometry underneath is shared, the eye has
 * nowhere else to go.
 *
 * A section runs under the elevation for the same reason, because a shadow line
 * is the symptom and the profile is the cause: standard shows the sash sitting on
 * top of the frame, flush shows it sitting into it.
 *
 * Built to survive its own failure. `--fg-wipe` keeps a CSS default of 50%, so
 * with no JavaScript the box is a straight half-and-half comparison that still
 * makes the point. Flush is the layer underneath and always fills the stage: on
 * the flush page, the untouched state should be the thing being sold.
 *
 * Accessibility: the control is a real `<input type="range">` rather than a div
 * with pointer handlers, so it is keyboard operable, announces a value and
 * inherits the platform's touch behaviour. The drawings are decorative — the
 * copy beside them carries the meaning — so they are hidden from assistive tech
 * rather than described twice.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$eyebrow = (string) ($args['eyebrow'] ?? 'The difference');
$heading = (string) ($args['heading'] ?? 'Drag it, and watch the step disappear.');
$copy = (string) ($args['copy'] ?? '');
$uid = 'fg-wipe-' . wp_unique_id();

/* One drawing, rendered twice. `$sashes` is the pane grid, shared by both sides
   so the two halves cannot drift apart: change a number here and it changes on
   both sides at once, which is the invariant the whole component rests on. */
$panes = [
    ['x' => 40, 'w' => 150],
    ['x' => 200, 'w' => 150],
    ['x' => 360, 'w' => 150],
];

$draw = static function (bool $proud) use ($panes): string {
    $out = '';
    foreach ($panes as $pane) {
        $x = $pane['x'];
        $w = $pane['w'];
        if ($proud) {
            // The sash stands off the frame, so it casts and carries a step.
            $out .= '<rect x="' . ($x - 4) . '" y="46" width="' . ($w + 8) . '" height="188" rx="2" class="fg-wipe-svg__shadow"/>';
            $out .= '<rect x="' . ($x - 3) . '" y="45" width="' . ($w + 6) . '" height="186" rx="2" class="fg-wipe-svg__sash"/>';
            $out .= '<rect x="' . ($x + 8) . '" y="56" width="' . ($w - 16) . '" height="164" rx="1" class="fg-wipe-svg__glass"/>';
        } else {
            // Level with the frame: one plane, no step, nothing to shadow.
            $out .= '<rect x="' . $x . '" y="48" width="' . $w . '" height="182" rx="2" class="fg-wipe-svg__sash"/>';
            $out .= '<rect x="' . ($x + 11) . '" y="59" width="' . ($w - 22) . '" height="160" rx="1" class="fg-wipe-svg__glass"/>';
        }
    }
    return $out;
};

/* The section under the elevation. Standard sits the sash on the face of the
   frame; flush sets it into the frame so the outer faces line up. */
$section = static function (bool $proud): string {
    $frame = '<rect x="40" y="300" width="470" height="26" rx="2" class="fg-wipe-svg__sectionframe"/>';
    if ($proud) {
        return $frame
            . '<rect x="150" y="286" width="250" height="16" rx="2" class="fg-wipe-svg__sectionsash"/>'
            . '<path d="M150 286 L150 300" class="fg-wipe-svg__lead"/>'
            . '<text x="275" y="279" class="fg-wipe-svg__note">sash sits on the frame</text>';
    }
    return $frame
        . '<rect x="150" y="300" width="250" height="16" rx="2" class="fg-wipe-svg__sectionsash"/>'
        . '<text x="275" y="279" class="fg-wipe-svg__note">sash sits into the frame</text>';
};

$svg = static function (bool $proud) use ($draw, $section): string {
    return '<svg class="fg-wipe-svg" viewBox="0 0 550 340" role="presentation" aria-hidden="true" focusable="false">'
        . '<rect x="24" y="30" width="502" height="218" rx="3" class="fg-wipe-svg__frame"/>'
        . $draw($proud)
        . $section($proud)
        . '</svg>';
};
?>

<section class="fg-wipe" aria-labelledby="<?php echo esc_attr($uid); ?>-title">
    <div class="container fg-wipe__grid">
        <div class="fg-wipe__copy">
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h2 id="<?php echo esc_attr($uid); ?>-title" class="fg-wipe__title"><?php echo esc_html($heading); ?></h2>
            <?php if ($copy !== '') : ?>
                <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
        </div>

        <figure class="fg-wipe__stage" data-fg-wipe>
            <?php /* Flush underneath, filling the stage: the resting state is the
                     product this page sells. */ ?>
            <span class="fg-wipe__side fg-wipe__side--flush"><?php echo $svg(false); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>

            <?php /* Standard on top, revealed from the left by a clip that follows
                     the slider. Same drawing, one difference. */ ?>
            <span class="fg-wipe__layer"><span class="fg-wipe__side fg-wipe__side--standard"><?php echo $svg(true); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></span>

            <span class="fg-wipe__seam" aria-hidden="true"></span>
            <span class="fg-wipe__tag fg-wipe__tag--standard" aria-hidden="true"><?php esc_html_e('Standard', 'fenster'); ?></span>
            <span class="fg-wipe__tag fg-wipe__tag--flush" aria-hidden="true"><?php esc_html_e('Flush', 'fenster'); ?></span>

            <label class="fg-cas-sr" for="<?php echo esc_attr($uid); ?>"><?php esc_html_e('Reveal the standard casement over the flush one', 'fenster'); ?></label>
            <input class="fg-wipe__range" id="<?php echo esc_attr($uid); ?>" type="range"
                min="0" max="100" value="50" step="1"
                aria-describedby="<?php echo esc_attr($uid); ?>-title" data-fg-wipe-range>
        </figure>
    </div>
</section>
