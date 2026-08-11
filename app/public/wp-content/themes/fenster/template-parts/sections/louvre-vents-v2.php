<?php
/**
 * Louvre vents: the bespoke middle.
 *
 * Rebuilt 2026-08-11. The route was running the shared commercial template with
 * copy that could have described any product on it: "Fenster can include louvre
 * panels within aluminium window, door and curtain walling packages". True, and
 * it tells a specifier nothing they can act on.
 *
 * WHAT THIS PAGE IS NOW. The IKON range we actually offer, with IKON's own
 * published figures, pitched a step below the way IKON publish them. Owner,
 * 2026-08-11: "be good to add some details but maybe not QUITE as hard as they
 * go". So the systems are here, and the free areas are here, and the pressure
 * loss curves and K-factors are not.
 *
 * COMPOSITE PANELS ARE EXCLUDED. Owner instruction the same day: it is the one
 * product in IKON's louvre range we do not offer. They sit alongside these
 * systems on IKON's own site, so anybody comparing the two lists will notice
 * the gap, and it is deliberate.
 *
 * IKL33 LEADS BECAUSE IT IS WHAT WE FIT MOST, not because it performs best. On
 * free area it is the lowest of the four at 43.5%, which the copy says out
 * loud: a page that leads with its most common product and quietly hides that
 * product's weakest number is the sort of thing a consultant notices.
 *
 * EVERY FIGURE IS IKON'S, and the page attributes them to "the system
 * manufacturer" rather than by name. Owner instruction, 2026-08-11: "we dont
 * want to state the ikon brand. models are ok." So IKL33, IKCL95 and the rest
 * stay on the page and IKON does not, which is the same position the site takes
 * on Renolit, Notan, Mila and VBH: a supplier is named only where we
 * deliberately sell the page around them, as with Sheerline and Liniar. The
 * name stays in this comment and in the data file so the figures can be
 * re-verified. None of it may be restated as a Fenster performance number,
 * which is the rule the Kenrick lock figures are held to.
 *
 * TWO PLACEHOLDERS SHIP HERE DELIBERATELY. The owner has more photographs and
 * asked for placeholders in the meantime. They are marked as such on the page
 * rather than filled with a supplier render or a stand-in from another product,
 * which is how /aluminium-doors/ ended up with a hero that reads as uPVC.
 * Replace them with `fenster_image_attr_string()` figures and delete the
 * placeholder markup; the captions already say what each one should show.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$systems = function_exists('fenster_louvre_systems') ? fenster_louvre_systems() : [];
$standard = is_array($systems['standard'] ?? null) ? $systems['standard'] : [];
$continuous = is_array($systems['continuous'] ?? null) ? $systems['continuous'] : [];
$specials = is_array($systems['specials'] ?? null) ? $systems['specials'] : [];
$frames = is_array($systems['frames'] ?? null) ? $systems['frames'] : [];
$options = is_array($systems['options'] ?? null) ? $systems['options'] : [];

$louvre_img = '/wp-content/themes/fenster/assets/images/products/louvre/';
$commercial_enquiry = '#commercial-product-enquiry';

/* The one we fit most, pulled from the range rather than written out again, so
   the headline figures and the table can never disagree. */
$common = [];
foreach ($standard as $system) {
    if (! empty($system['common'])) {
        $common = $system;
        break;
    }
}

/** A marked placeholder. Deliberately not an <img>: a broken image and a
 *  photograph we have not taken yet look the same to a visitor, and only one of
 *  them is honest. */
$placeholder = static function (string $ratio, string $describes): void {
    ?>
    <div class="fg-lv-placeholder" style="--fg-lv-ratio: <?php echo esc_attr($ratio); ?>" role="img"
        aria-label="<?php echo esc_attr(sprintf(__('Photograph to follow: %s', 'fenster'), $describes)); ?>">
        <span><?php esc_html_e('Photograph to follow', 'fenster'); ?></span>
        <small><?php echo esc_html($describes); ?></small>
    </div>
    <?php
};
?>

<div class="fg-lv">

    <?php /* ---------- The one we fit most -------------------------------------
             IKL33 leads on frequency, not on performance, and the copy says so.
             The figures come out of `fenster_louvre_systems()` so this block and
             the table below cannot drift apart. */ ?>
    <?php if ($common !== []) : ?>
        <section class="fg-lv-lead" aria-labelledby="fg-lv-lead-title">
            <div class="container fg-lv-lead__grid">
                <div class="fg-lv-lead__copy">
                    <p class="eyebrow"><?php esc_html_e('The one we fit most', 'fenster'); ?></p>
                    <h2 id="fg-lv-lead-title"><?php esc_html_e('The IKL33 is the system we fit most.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Blades at 34mm centres, set to 60 degrees, in a 36.2mm frame. The close pitch and steep angle give sightproofing and weather resistance, and the shallow frame suits openings that will not take a deeper system.', 'fenster'); ?></p>
                    <p><?php esc_html_e('It trades free area for that performance and is the lowest of the four standard systems at 43.5% physical. Where a schedule needs more air through the same opening, we move up the range.', 'fenster'); ?></p>
                    <dl class="fg-lv-figures">
                        <div>
                            <dt><?php esc_html_e('Blade centres', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) $common['centre']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Blade angle', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) $common['angle']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Frame depth', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) $common['depth']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Physical free area', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) $common['physical']); ?></dd>
                        </div>
                    </dl>
                    <p class="fg-lv-note"><?php esc_html_e('The system manufacturer\'s published specification for the IKL33, tested to EN 13030:2002.', 'fenster'); ?></p>
                </div>
                <?php /* 4:3 rather than the portrait it was: at 4:5 the empty box was taller
                         than the copy beside it and dominated a section that is
                         mostly numbers. */ ?>
                <?php $placeholder('4 / 3', __('an IKL33 run photographed close, square to the blades', 'fenster')); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php /* ---------- Free area ---------------------------------------------
             The single most useful thing this page can explain, and the reason
             louvre enquiries go wrong. Two numbers, one of which a consultant
             means and the other of which a client reads off a brochure. */ ?>
    <section class="fg-lv-free" aria-labelledby="fg-lv-free-title">
        <div class="container">
            <div class="fg-lv-free__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('The number that matters', 'fenster'); ?></p>
                    <h2 id="fg-lv-free-title"><?php esc_html_e('Free area is quoted two ways. A schedule means one of them.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('Every louvre carries both figures and they are a long way apart. Specifying against the visual figure is the most common reason a louvre arrives undersized for the plant behind it.', 'fenster'); ?></p>
            </div>
            <div class="fg-lv-free__pair">
                <div>
                    <p class="fg-lv-free__value"><?php echo esc_html((string) ($common['visual'] ?? '59%')); ?></p>
                    <h3><?php esc_html_e('Visual free area', 'fenster'); ?></h3>
                    <p><?php esc_html_e('The proportion of the opening you can see through. It describes appearance, not airflow, and it is always the larger of the two.', 'fenster'); ?></p>
                </div>
                <div>
                    <p class="fg-lv-free__value"><?php echo esc_html((string) ($common['physical'] ?? '43.5%')); ?></p>
                    <h3><?php esc_html_e('Physical free area', 'fenster'); ?></h3>
                    <p><?php esc_html_e('The proportion air can actually pass through, with the blades and frame deducted. This is the figure a mechanical schedule refers to and the one we size from.', 'fenster'); ?></p>
                </div>
            </div>
            <p class="fg-lv-note"><?php esc_html_e('Both figures are the IKL33\'s. Send the free area required and the opening size and we will confirm which system meets it.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* ---------- The range ------------------------------------------------
             A table, because four systems with four figures each is a table and
             pretending otherwise makes it harder to read. Wrapped in its own
             scroller so it cannot push the page sideways on a phone, which is a
             release blocker. */ ?>
    <section class="fg-lv-range" aria-labelledby="fg-lv-range-title">
        <div class="container">
            <div class="fg-lv-range__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('The range', 'fenster'); ?></p>
                    <h2 id="fg-lv-range-title"><?php esc_html_e('Wider blades, more air, less screening.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('That is the trade-off across the range. Wider blade centres raise free area and the view through; closer centres give sightproofing, better weather resistance and a shallower frame.', 'fenster'); ?></p>
            </div>

            <?php if ($standard !== []) : ?>
                <div class="fg-lv-table" tabindex="0" role="region" aria-label="<?php esc_attr_e('Louvre systems and their published free areas', 'fenster'); ?>">
                    <table>
                        <caption class="screen-reader-text"><?php esc_html_e('Louvre systems, blade centres, angles and free areas', 'fenster'); ?></caption>
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('System', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Blade centres', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Angle', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Visual', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Physical', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Frame depth', 'fenster'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($standard as $system) : ?>
                                <tr<?php echo ! empty($system['common']) ? ' class="is-common"' : ''; ?>>
                                    <th scope="row">
                                        <?php echo esc_html((string) $system['code']); ?>
                                        <?php if (! empty($system['common'])) : ?>
                                            <span><?php esc_html_e('Most used', 'fenster'); ?></span>
                                        <?php endif; ?>
                                    </th>
                                    <td><?php echo esc_html((string) $system['centre']); ?></td>
                                    <td><?php echo esc_html((string) $system['angle']); ?></td>
                                    <td><?php echo esc_html((string) $system['visual']); ?></td>
                                    <td><?php echo esc_html((string) $system['physical']); ?></td>
                                    <td><?php echo esc_html((string) $system['depth']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="fg-lv-range__more">
                <?php if ($continuous !== []) : ?>
                    <div>
                        <h3><?php esc_html_e('Continuous louvres', 'fenster'); ?></h3>
                        <p><?php esc_html_e('The same blades run across a whole elevation rather than sitting in separate framed panels. Reinforcement bars are pre-assembled with glazing clips and concealed once the blades are in, so the line reads unbroken.', 'fenster'); ?></p>
                        <ul class="fg-lv-chips">
                            <?php foreach ($continuous as $system) : ?>
                                <li>
                                    <strong><?php echo esc_html((string) $system['code']); ?></strong>
                                    <span><?php echo esc_html(sprintf(
                                        /* translators: 1: blade centre, 2: physical free area */
                                        __('%1$s blades, %2$s physical', 'fenster'),
                                        (string) $system['centre'],
                                        (string) $system['physical']
                                    )); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php foreach ($specials as $special) : ?>
                    <div>
                        <h3><?php echo esc_html((string) $special['name']); ?></h3>
                        <p><?php echo esc_html((string) $special['copy']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <p class="fg-lv-note"><?php esc_html_e('Figures are the system manufacturer\'s published specifications, each tested to EN 13030:2002. Which system suits an opening depends on the free area required, the depth available and the exposure, and that is settled at survey.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* ---------- Specifying it -------------------------------------------
             Frames and options side by side. The frame is the half that goes
             wrong on site, because it has to suit the construction rather than
             the drawing, so it leads. */ ?>
    <section class="fg-lv-spec" aria-labelledby="fg-lv-spec-title">
        <div class="container">
            <div class="fg-lv-spec__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Specifying it', 'fenster'); ?></p>
                    <h2 id="fg-lv-spec-title"><?php esc_html_e('The frame is specified separately from the blade.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The same louvre meets an opening in five ways, and the right one depends on the construction rather than the louvre. It is worth settling at survey: drawings rarely show it.', 'fenster'); ?></p>
            </div>
            <div class="fg-lv-spec__grid">
                <div>
                    <h3><?php esc_html_e('How it meets the opening', 'fenster'); ?></h3>
                    <dl>
                        <?php foreach ($frames as $frame) : ?>
                            <div>
                                <dt><?php echo esc_html((string) $frame['name']); ?></dt>
                                <dd><?php echo esc_html((string) $frame['copy']); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
                <div>
                    <h3><?php esc_html_e('Worth asking for', 'fenster'); ?></h3>
                    <dl>
                        <?php foreach ($options as $option) : ?>
                            <div>
                                <dt><?php echo esc_html((string) $option['name']); ?></dt>
                                <dd><?php echo esc_html((string) $option['copy']); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    <?php /* ---------- Where the work section went -------------------------
             There WAS a three-cell "our work" gallery here and it came out on
             2026-08-11, when the hero became a louvre. We own exactly two
             photographs of louvres: one is now the hero and the other is the
             intro image in the shared template above, so a gallery underneath
             could only repeat them or run on placeholders alone.

             Put it back the moment more photographs arrive. The Heal's job is
             the obvious first entry — six bespoke louvres in golden brown — and
             it already links here from its own study. */ ?>

</div>
