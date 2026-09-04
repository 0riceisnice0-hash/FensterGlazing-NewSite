<?php
/**
 * Composite Doors: the middle of the page, as three chapters.
 *
 * ---- 2026-08-27 overhaul -------------------------------------------------
 *
 * THE PAGE WAS SEVENTEEN SECTIONS OF EQUAL WEIGHT. Measured on test at
 * 1440x900 it ran to 13,909px across seventeen sections, every page `h2`
 * resolved to 28.8px, and seven sections were taller than a full desktop
 * viewport against the 680-780px `STYLE.md` asks for. Nothing was allowed to be
 * more important than anything else, so nothing led. This file now carries three
 * chapters rather than eight loose sections:
 *
 *   CHOOSING   the 142-door range and the quiz, on one surface
 *   MADE OF    the slab cutaway, the security guarantee, the through-link
 *   FINISHES   glass, colour and handles, as one decision made three times
 *
 * WHAT WAS ABSORBED RATHER THAN DELETED. The collections carousel is gone as a
 * section: its six cards were the range's six tabs, its slab lines and
 * descriptions now live in `fenster_composite_door_collections()` and render
 * inside each panel, and its image grid forced tall door renders into a column
 * about 105px wide so the doors were cut off. The approved-installer band moved
 * into the hero. The handle grid moved in here from the shared tail so glass,
 * colour and handles read as one chapter; it is gated off for this slug in
 * `generated-page.php` exactly the way `/upvc-doors/` gates it.
 *
 * A BUG THIS FIXES, WORTH KNOWING ABOUT. The glass section and the
 * `/why-distinction/` through-link were both inside `if (! empty($colour_wall))`
 * — an unrelated key — so an empty colour wall would have silently taken the
 * decorative glass and the only link to that page off the site. That is the same
 * shape as the fault that had the glass section gated off the one route with the
 * data. Each block is guarded on its own data now.
 *
 * The tabbed colour/glass/hardware configurator was removed on 2026-07-22 at
 * the owner's request and replaced by the colour wall, where hovering a paint
 * colour shows that colour on a real door.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$security = is_array($args['security'] ?? null) ? array_values($args['security']) : [];
$anatomy = is_array($args['anatomy'] ?? null) ? $args['anatomy'] : [];
$colour_wall = is_array($args['colour_wall'] ?? null) ? array_values($args['colour_wall']) : [];
$palette_base = (string) ($args['palette_base'] ?? '');
$colours_base = (string) ($args['colours_base'] ?? '');
$colour_doors_base = (string) ($args['colour_doors_base'] ?? '');
?>

<?php
/* ==================================================================
   CHAPTER: CHOOSING
   The range and the quiz on ONE surface. They were two white cards with
   a visible seam between them, which is the "stack of white cards"
   `STYLE.md` warns against, and they are one thought: see the whole
   range, then let us narrow it. The quiz's opening line only lands if
   the reader has just scrolled past 142 doors, so the order is fixed.
   ================================================================== */
?>
<section class="fg-choose">
    <div class="container fg-choose__surface">
        <?php get_template_part('template-parts/components/composite-door-styles', null, ['bare' => true]); ?>
    </div>
</section>

<?php
/* THE QUIZ MOVED TO THE TAIL ON 2026-08-27, on the owner's instruction, and it
   is rendered from `generated-page.php` just above the enquiry form.

   It sat here, directly under the range, because its opening line is that 142
   doors is too many to choose from cold and that only lands after you have
   scrolled past 142 doors. That reasoning was right about the sentence and
   wrong about the page: a five-question game is not what somebody who has just
   arrived wants, and putting it third made the page's own range look like
   something to be rescued from. At the bottom it is what it actually is — a
   shortcut for somebody who has read the lot and still cannot choose. */
?>

<?php
/* ==================================================================
   CHAPTER: WHAT IT IS MADE OF
   The cutaway, the guarantee, then the handoff to `/why-distinction/`
   as this chapter's own footer rather than a stranded band.
   ================================================================== */
?>
<?php if (! empty($anatomy['layers'])) : ?>
    <?php get_template_part('template-parts/components/composite-anatomy', null, ['anatomy' => $anatomy]); ?>
<?php endif; ?>

<?php if (! empty($security)) : ?>
    <section class="fg-cd3-security" aria-labelledby="fg-cd3-security-title">
        <div class="container fg-cd3-security__inner">
            <div class="fg-cd3-security__lead">
                <?php
                // The guarantee badge, drawn rather than an image so it stays sharp
                // and needs no asset. Redrawn 2026-08-27: the old one was a filled
                // navy shield with a white band and two sizes of centred text,
                // which read as clip art beside a real photograph. This is a line
                // shield on the panel's own ground, in the same hairline weight the
                // rest of the page uses. Swap for the supplier artwork if it is
                // ever supplied as a file; there is no APECS or badge asset in the
                // repo.
                ?>
                <span class="fg-cd3-shield" aria-hidden="true">
                    <svg viewBox="0 0 132 150" role="presentation" focusable="false">
                        <path d="M66 3 122 21v58c0 33-27 54-56 68C37 133 10 112 10 79V21L66 3Z" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" opacity=".55"/>
                        <path d="M66 14 111 28v50c0 27-22 44-45 56-23-12-45-29-45-56V28L66 14Z" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linejoin="round" opacity=".3"/>
                        <text x="66" y="72" text-anchor="middle" font-family="Gibson, Arial, sans-serif" font-size="33" font-weight="700" fill="currentColor" letter-spacing="-0.5">£5,000</text>
                        <line x1="34" y1="86" x2="98" y2="86" stroke="currentColor" stroke-width="1" opacity=".45"/>
                        <text x="66" y="106" text-anchor="middle" font-family="Gibson, Arial, sans-serif" font-size="12.5" font-weight="600" fill="currentColor" letter-spacing="1.6" opacity=".8">GUARANTEE</text>
                    </svg>
                </span>
                <div class="fg-cd3-security__words">
                    <p class="eyebrow"><?php esc_html_e('£5,000 break-in guarantee', 'fenster'); ?></p>
                    <h2 id="fg-cd3-security-title"><?php esc_html_e('If the lock fails in a break-in, you are covered.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Every Distinction door we fit is secured with AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock. Should either fail in a break-in, you are covered for up to £5,000 in compensation. Terms apply, and we go through them with you before you order rather than after.', 'fenster'); ?></p>
                    <div class="button-row">
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                        <a class="button button--light" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('How we back our work', 'fenster'); ?></a>
                    </div>
                </div>
            </div>
            <ul class="fg-cd3-security__points">
                <?php foreach ($security as $point) : ?>
                    <li>
                        <strong><?php echo esc_html((string) $point['title']); ?></strong>
                        <span><?php echo esc_html((string) $point['copy']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="fg-wd-cta">
            <div class="container">
                <div class="fg-wd-cta__inner">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('The long version', 'fenster'); ?></p>
                        <h2><?php esc_html_e('Why we fit Distinction and not something else.', 'fenster'); ?></h2>
                        <p><?php esc_html_e('Where the thermal figure comes from and what it does not cover, the accreditation, the warranty, and the part that is a judgement rather than a measurement.', 'fenster'); ?></p>
                    </div>
                    <p class="fg-wd-cta__action">
                        <a class="button" href="<?php echo esc_url(home_url('/why-distinction/')); ?>"><?php esc_html_e('Read why we fit them', 'fenster'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php
/* ==================================================================
   CHAPTER: THE FINISHES
   Glass, colour and handles were three separate sections running to
   1,532px, 1,170px and 510px, each with its own heading, and they are
   one decision made three times. They run in order of how much each
   changes the door, which is the order the page already asserted when
   the glass heading said the glass changes it more than the colour.
   ================================================================== */
$fg_glass = fenster_data('product_content.composite-doors.glass_styles', []);
$fg_has_glass = ! empty($fg_glass['items']);
$fg_has_colour = ! empty($colour_wall);
?>
<?php if ($fg_has_glass || $fg_has_colour) : ?>
<div class="fg-finish">
    <?php
    /* THE INDEX WENT, AND SO DID THE VIEWPORT IT COST. It listed Glass,
       Colour and Handles with a fact each, immediately above Glass, Colour
       and Handles. A table of contents for three things you can already see
       is duplication wearing a card, and it was 280px of a chapter that was
       already thirty per cent of the page.

       THE CHAPTER IS ONE SURFACE NOW, not three sections on bare canvas.
       That was the finding: 3,992px, glass into colour into handles with no
       change of ground and nothing marking where one decision ended and the
       next began. The steps sit on a single card with a number in the gutter,
       so the sequence is the structure rather than something the copy has to
       assert. */
    ?>
            <?php if ($fg_has_glass) : ?>
                <section class="fg-finish__step fg-finish__step--first">
                    <div class="container">
                        <?php
                        /* ONE LINE, NOT A SECOND TITLE. As a full chapter head
                           this was 113px of heading sitting directly above the
                           step's own eyebrow and heading - 165px of titling
                           before a single picture, and the screen was clipping
                           its own closing note as a result. The step below
                           already says what it is; the chapter only needs to
                           say that three of them are coming. */
                        ?>
                        <p class="fg-finish__chapter"><?php esc_html_e('The finishes — the three things that make it yours', 'fenster'); ?></p>
                        <p class="fg-finish__num" aria-hidden="true">01</p>
                    </div>
                    <div class="fg-finish__body">
                        <?php
                        get_template_part('template-parts/components/composite-glass', null, [
                            'items' => $fg_glass['items'],
                            'intro' => (string) ($fg_glass['intro'] ?? ''),
                            'note'  => (string) ($fg_glass['note'] ?? ''),
                        ]);
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($fg_has_colour) : ?>
        <?php
        $cw_first = $colour_wall[0];
        $cw_preview = static function (array $entry) use ($colours_base, $colour_doors_base, $palette_base): array {
            // A photographed door we fitted comes first, then a Distinction render
            // of a door in that named colour, then the paint itself.
            if (! empty($entry['door'])) {
                $stem = $colours_base . $entry['door'];
                return [
                    'src' => fenster_generated_url($stem . '-480w.webp'),
                    'srcset' => fenster_generated_url($stem . '-480w.webp') . ' 480w, ' . fenster_generated_url($stem . '-800w.webp') . ' 800w',
                    'alt' => sprintf(__('A %s composite front door', 'fenster'), (string) $entry['name']),
                    'kind' => __('On a door we fitted', 'fenster'),
                ];
            }
            if (! empty($entry['colour_door'])) {
                $stem = $colour_doors_base . $entry['colour_door'];
                return [
                    'src' => fenster_generated_url($stem . '-400w.webp'),
                    'srcset' => fenster_generated_url($stem . '-400w.webp') . ' 400w, ' . fenster_generated_url($stem . '-800w.webp') . ' 800w',
                    'alt' => sprintf(__('A composite door in %s', 'fenster'), (string) $entry['name']),
                    'kind' => __('On a door', 'fenster'),
                ];
            }
            $stem = $palette_base . $entry['swatch'];
            return [
                'src' => fenster_generated_url($stem . '-320w.webp'),
                'srcset' => fenster_generated_url($stem . '-160w.webp') . ' 160w, ' . fenster_generated_url($stem . '-320w.webp') . ' 320w',
                'alt' => sprintf(__('%s composite door paint', 'fenster'), (string) $entry['name']),
                'kind' => __('Paint sample', 'fenster'),
            ];
        };
        $cw_first_preview = $cw_preview($cw_first);
        ?>
        <?php
        /* THE SECTION NO LONGER PAINTS ITS OWN BACKGROUND. It carried a band
           that met the page canvas in a visible horizontal seam, which is the
           exact banding fault the Site-Wide Background Rule records against
           this page. It sits on the shared canvas now and the preview panel
           supplies the local contrast. */
        ?>
        <section class="fg-finish__step">
            <div class="container"><p class="fg-finish__num" aria-hidden="true">02</p></div>
            <div class="fg-finish__body">
        <section class="fg-cd3-colour" aria-labelledby="fg-cd3-colour-title">
            <div class="container">
                <header class="fg-finish__step-head">
                    <p class="eyebrow"><?php esc_html_e('The paint range', 'fenster'); ?></p>
                    <h3 id="fg-cd3-colour-title"><?php esc_html_e('Pick a colour and see it on a real door.', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Distinction mix their own paint rather than buying it in. Hover or tap any colour and most of them will show you a door in it. The few we have no door for show the paint itself, because we would rather show you the real thing than tint a picture and hope.', 'fenster'); ?></p>
                    <?php /* THE SECOND PARAGRAPH MOVED TO THE NOTE UNDER THE
                             SWATCHES, where it belongs: it is a caveat about the
                             range you have just looked at rather than a preamble
                             to looking at it. Owner-confirmed 2026-07-29 that
                             these are a selection and any RAL can be matched
                             beyond it, and BOTH halves of that survive verbatim
                             below. See the confirmed facts in AI.md before
                             trimming it further. */ ?>
                </header>

                <div class="fg-cd3-colour__layout" data-fg-door-selector data-fg-colour-wall>
                    <div class="fg-cd3-colour__swatches">
                        <?php foreach ($colour_wall as $index => $entry) : ?>
                            <?php $preview = $cw_preview($entry); ?>
                            <button
                                type="button"
                                class="fg-cd3-swatch"
                                data-fg-choice-option
                                data-preview-src="<?php echo esc_url($preview['src']); ?>"
                                data-preview-srcset="<?php echo esc_attr($preview['srcset']); ?>"
                                data-preview-alt="<?php echo esc_attr($preview['alt']); ?>"
                                data-preview-name="<?php echo esc_attr((string) $entry['name']); ?>"
                                data-preview-copy="<?php echo esc_attr(trim((string) ($entry['ref'] ?? '') . ' ' . $preview['kind'])); ?>"
                                aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                <?php if (! empty($entry['swatch'])) : ?>
                                    <img
                                        src="<?php echo esc_url(fenster_generated_url($palette_base . $entry['swatch'] . '-160w.webp')); ?>"
                                        alt="" aria-hidden="true" loading="lazy" width="160" height="160">
                                <?php else : ?>
                                    <i style="--option-colour: <?php echo esc_attr((string) $entry['hex']); ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                                <span><?php echo esc_html((string) $entry['name']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <figure class="fg-cd3-colour__preview">
                        <img
                            data-fg-choice-image
                            src="<?php echo esc_url($cw_first_preview['src']); ?>"
                            srcset="<?php echo esc_attr($cw_first_preview['srcset']); ?>"
                            sizes="(max-width: 860px) 92vw, 34vw"
                            alt="<?php echo esc_attr($cw_first_preview['alt']); ?>"
                            loading="lazy" width="800" height="1000">
                        <figcaption>
                            <strong data-fg-choice-name><?php echo esc_html((string) $cw_first['name']); ?></strong>
                            <span data-fg-choice-copy><?php echo esc_html(trim((string) ($cw_first['ref'] ?? '') . ' ' . $cw_first_preview['kind'])); ?></span>
                        </figcaption>
                    </figure>
                </div>

                <p class="fg-cd3-colour__note">
                    <?php esc_html_e('One colour outside and a different one facing your hallway is normal, and woodgrain stains are single sided. What is above is a selection of the standard range, not the whole of it: past it we can match any RAL colour, so a shade you have in mind is worth asking about rather than settling for the nearest one here.', 'fenster'); ?>
                </p>
            </div>
        </section>
            </div>
        </section>
    <?php endif; ?>

            <?php
            /* THE HANDLE GRID, IN THE CHAPTER RATHER THAN IN THE SHARED TAIL. It
               is gated off for this slug in `generated-page.php`, the same way
               `/upvc-doors/` gates it so its three finish decisions run
               together. It keeps its own `.container`, which the surface
               neutralises in CSS rather than this route forking a shared
               component. */
            if (function_exists('fenster_door_handle_grid_args')) :
                ?>
                <section class="fg-finish__step">
                    <div class="container"><p class="fg-finish__num" aria-hidden="true">03</p></div>
                    <div class="fg-finish__body">
                        <?php get_template_part('template-parts/components/handle-grid', null, fenster_door_handle_grid_args()); ?>
                    </div>
                </section>
            <?php endif; ?>
</div>
<?php endif; ?>
