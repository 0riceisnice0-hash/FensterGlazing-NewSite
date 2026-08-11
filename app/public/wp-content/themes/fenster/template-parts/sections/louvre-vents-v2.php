<?php
/**
 * Louvre vents: the bespoke middle.
 *
 * Rebuilt 2026-08-11. The route was running the shared commercial template with
 * copy that could have described any product on it: "Fenster can include louvre
 * panels within aluminium window, door and curtain walling packages". True, and
 * it tells a specifier nothing they can act on.
 *
 * WHAT THIS PAGE IS NOW. The range we actually offer, with the manufacturer's
 * own published figures, pitched a step below the way they publish them. Owner,
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
 * SIX PHOTOGRAPHS, EACH PLACED WHERE IT ARGUES FOR SOMETHING. Two marked
 * placeholders shipped here first, and four photographs then arrived with the
 * instruction not to dump them into a gallery under "our work". So the plant
 * doorsets are the hero, the scaffold shot sits against the scope copy because
 * it shows a louvre and a window in one frame line, the blade close-up sits
 * against the blade-pitch trade-off, and the boiler-house screen sits against
 * the frame types. The two older photographs are the only ones doing nothing
 * but proving, so they are the pair at the end.
 *
 * NO CAPTION NAMES A SYSTEM. Nobody has confirmed which system any of these
 * jobs used, and the blade close-up is visibly a wider pitch than the IKL33, so
 * captions describe what is in frame and stop. A third-party sprinkler
 * contractor's sign was cropped out of that frame. Neither fitter's face is
 * visible in the scaffold shot, so nothing there is blurred.
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

/* The placeholder helper that lived here is gone: every slot it covered
   now has a real photograph. The pattern itself is written up in AI.md under
   the Marked Placeholders Rule, and `.fg-lv-placeholder` stays in the
   stylesheet for the next page that needs it. */
?>

<div class="fg-lv">

    <?php /* ---------- The one we fit most -------------------------------------
             IKL33 leads on frequency, not on performance, and the copy says so.
             The figures come out of `fenster_louvre_systems()` so this block and
             the table below cannot drift apart. */ ?>
    <?php if ($common !== []) : ?>
        <section class="fg-lv-lead" aria-labelledby="fg-lv-lead-title">
            <div class="container fg-lv-lead__grid fg-lv-lead__grid--single">
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

            <?php /* Wide blades, photographed. This is a plant doorset on one of
                     our jobs and the blades are visibly further apart than the
                     IKL33's; it earns its place here rather than in the IKL33
                     section above precisely because it is NOT that system.
                     Nothing in the caption names a system, because nobody has
                     confirmed which one it is. The third-party sprinkler
                     contractor's sign in the original frame is cropped out. */ ?>
            <figure class="fg-lv-figure fg-lv-figure--wide">
                <img <?php echo fenster_image_attr_string($louvre_img . 'louvre-blade-detail-1150w.webp', [
                    'alt' => __('Close view of wide-pitched aluminium louvre blades on a pair of plant room doors, with the lock between them', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
                <figcaption><?php esc_html_e('Wider blade centres on a plant doorset. More air and a longer view in, on an opening where neither matters.', 'fenster'); ?></figcaption>
            </figure>

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
            <?php /* A louvre and a glazed panel in one screen, which is what the
                     glaze-in frame in the list below actually looks like built.
                     Ours, on a boiler house. */ ?>
            <figure class="fg-lv-figure fg-lv-figure--wide">
                <img <?php echo fenster_image_attr_string($louvre_img . 'louvre-screen-boiler-1400w.webp', [
                    'alt' => __('A wide louvre panel with obscured glazing above it, framed as one screen in a brick elevation', 'fenster'),
                    'loading' => 'lazy',
                ]); ?>>
                <figcaption><?php esc_html_e('Louvre below, glazing above, in one screen and one frame line. The plant behind it gets its air and the elevation keeps a single opening.', 'fenster'); ?></figcaption>
            </figure>

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

    <?php /* ---------- Two more of ours ----------------------------------
             The section came out earlier in the day, when we owned two louvre
             photographs and both were needed above. Four more arrived and it is
             back, using the two that are not doing a job further up: the fixed
             panel at Headrow and a plant doorset on another site.

             Owner instruction, 2026-08-11: the new photographs were not to be
             dumped into a gallery under "our work". They are placed where they
             argue for something instead — the plant doors as the hero, the
             scaffold shot against the scope copy, the blade detail against the
             blade-pitch trade-off, the screen against the frame types. These
             two are the ones that are genuinely just proof. */ ?>
    <section class="fg-lv-work" aria-labelledby="fg-lv-work-title">
        <div class="container">
            <div class="fg-lv-work__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Elsewhere on site', 'fenster'); ?></p>
                    <h2 id="fg-lv-work-title"><?php esc_html_e('Two more, on different jobs.', 'fenster'); ?></h2>
                </div>
                <p>
                    <?php
                    printf(
                        /* translators: %s: link to the Heal's case study */
                        esc_html__('Louvres normally arrive as part of a wider package. Six bespoke ones went into the courtyard elevations at %s, in a golden brown against black windows.', 'fenster'),
                        '<a href="' . esc_url(home_url('/commercial-projects/heals-tottenham-court-road/')) . '">' . esc_html__('Heal\'s on Tottenham Court Road', 'fenster') . '</a>'
                    );
                    ?>
                </p>
            </div>
            <div class="fg-lv-work__grid">
                <figure>
                    <img <?php echo fenster_image_attr_string($louvre_img . 'louvre-vent-headrow-1500w.jpg', [
                        'alt' => __('A dark grey aluminium louvre panel set into red brickwork', 'fenster'),
                        'loading' => 'lazy',
                    ]); ?>>
                    <figcaption><?php esc_html_e('Fixed louvre panel, Headrow Court, Leeds. Colour-matched to the windows on the same elevation.', 'fenster'); ?></figcaption>
                </figure>
                <figure>
                    <img <?php echo fenster_image_attr_string($louvre_img . 'louvre-plant-doorset-1300w.jpg', [
                        'alt' => __('A pair of fully louvred aluminium plant room doors set into dark brickwork', 'fenster'),
                        'loading' => 'lazy',
                    ]); ?>>
                    <figcaption><?php esc_html_e('Plant room doorset, louvred over its full height, so the doors ventilate as well as open.', 'fenster'); ?></figcaption>
                </figure>
            </div>
        </div>
    </section>

</div>
