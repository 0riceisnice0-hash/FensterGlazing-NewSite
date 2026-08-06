<?php
/**
 * Window and door repairs: the bespoke page.
 *
 * Rebuilt 2026-08-06 on the owner's brief. The route had been running on the
 * generic product template, which is wrong for repairs in a way that is worth
 * spelling out: that template sells a product someone has decided to buy, and
 * this visitor has not decided anything. Something has broken and they want to
 * know whether we can fix it and roughly what it costs.
 *
 * Three faults on the old page were factual rather than tonal, and all three
 * are fixed in `generated-page.php` and `site-data.php` rather than here:
 *   - the key-specification strip claimed "Guarantee: 10 years", which is CPA
 *     cover on NEW windows and doors. Repairs sit outside it, and the process
 *     rail four sections below said so, so the page contradicted itself;
 *   - the hero offered instant pricing, pointing a broken-handle visitor at a
 *     tool that prices windows and doors and cannot price a repair;
 *   - the case-study strip showed three unrelated installations, because
 *     nothing claims this route and the helper falls back to any three.
 *
 * This replaces the MIDDLE of the generic template, the same shape flush
 * casement uses: `fg-product-why`, `fg-product-intel` and `fg-product-visuals`
 * come out, plus the specification-choices band, the quote embed, the process
 * rail and the case-study strip, which are gated off for this slug. The hero,
 * the key-specification strip, the FAQs, the reviews, the enquiry form and the
 * related links are the shared ones. It is NOT an early return.
 *
 * Built on `.fg-cw`, the split grammar the heritage door and flush pages
 * already share, with an `.fg-rp` namespace for the parts that are new.
 * Deliberately not the casement page's stacked chapters: that device stays
 * unique to casement.
 *
 * THE ONE IDEA. The page is ordered by what the visitor knows, which is the
 * symptom, never the part. So the finder comes first and everything below it
 * answers a question the finder has just raised: what will it cost, is it even
 * worth repairing, who are you, what happens next.
 *
 * WHY THE FINDER FILTERS RATHER THAN FETCHES. Every problem card is rendered
 * server-side with its diagnosis and its price. The controller only shows and
 * hides. That is deliberate three times over: the symptom language is in the
 * HTML for search, the page works with JavaScript off, and there is no second
 * copy of the content to drift. Do not "improve" this into something that
 * builds cards from a JSON blob.
 *
 * EVERY PRICE comes from the office Customer Repairs Price List via
 * `repair_problems` and `repair_prices` in `inc/site-data.php`. Nothing is
 * priced in this template. Read the comment on that data before touching a
 * figure; in particular the inc-VAT rule and the reading of the multiples
 * column are recorded there.
 *
 * NOT CLAIMED ANYWHERE, and none of it may be added without the owner:
 * response times, callout windows, same-day or emergency service, a guarantee
 * on repair work, or free diagnosis. The price list supports none of them.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);

$problems = fenster_data('repair_problems', []);
$problems = is_array($problems) ? array_values($problems) : [];

$prices = fenster_data('repair_prices', []);
$prices = is_array($prices) ? $prices : [];
$price_rows = is_array($prices['rows'] ?? null) ? array_values($prices['rows']) : [];
$price_notes = is_array($prices['footnotes'] ?? null) ? array_values($prices['footnotes']) : [];

$glass_url = esc_url(home_url('/double-glazing-replacement/'));
$img = '/wp-content/themes/fenster/assets/images/';

/* The filter groups. Counts are derived rather than written down, because a
   hand-typed count is the thing that goes stale the first time somebody adds a
   problem to the data. */
$groups = [
    'all' => 'Everything',
    'window' => 'Windows',
    'door' => 'Doors',
    'glass' => 'Glass',
];
$group_counts = ['all' => count($problems)];
foreach ($problems as $problem) {
    $key = (string) ($problem['group'] ?? '');
    if ($key !== '') {
        $group_counts[$key] = ($group_counts[$key] ?? 0) + 1;
    }
}

/* Why Fenster. Every line here is something already established elsewhere in
   the theme and checkable, which is the whole point: the brief asked for real
   differentiators rather than "professional service". Trading since 2018 and
   the Alston Drive showroom are on /about/; own fitters rather than
   subcontractors is the order-process rail's step 3 and the About page; the
   FENSA and CPA marks are the footer trust set. The Google rating is
   deliberately NOT hardcoded here — the review showcase further down the page
   renders the live figure from the Places API, and a second number written
   into a template is exactly how the two drift apart. */
$why = [
    [
        'title' => 'We fit these systems every week.',
        'copy' => 'A repair company guesses at hardware it meets occasionally. We install uPVC, aluminium and composite windows and doors as our main trade, so we recognise the gear, we know which mechanism a symptom points at, and we know what it is compatible with.',
    ],
    [
        'title' => 'We will tell you when not to bother.',
        'copy' => 'Repair is usually the right answer and it is the cheaper one, so it is what we lead with. But a window we would be fixing again next winter is not a repair, it is a postponement, and we would rather say so than take the money twice.',
    ],
    [
        'title' => 'Our own engineers, not a subcontractor.',
        'copy' => 'The people who come out are the people who fit our installations. Nobody is sent to your house under our name who does not work for us.',
    ],
    [
        'title' => 'Established here, with a showroom you can stand in.',
        /* No accreditation marks in this card. FENSA and CPA are real and they
           are on the trust strip site-wide, but sat in repair copy they read as
           cover on the repair, which is exactly the confusion the guarantee
           claim on this route caused for months. Owner instruction, 2026-08-06:
           cut it. The card keeps what is genuinely a repair differentiator —
           local, established, and the same company either way. */
        'copy' => 'Trading since 2018 from Alston Drive in Bradwell Abbey, with a showroom you can walk into rather than a call centre. If a repair turns into a replacement, you are dealing with the same company for both.',
    ],
];

/* The repair process. Four steps, and deliberately not the shared order-process
   rail, which runs "Your price, Technical survey, Installation, Aftercare" and
   describes buying windows. Nobody having a hinge changed gets a technical
   survey or a FENSA certificate.

   Step 1 carries the photograph ask because it is genuinely the fastest route
   to an accurate answer and it is the only "process" claim on this page that
   the price list supports outright: a sill repair is quoted from pictures. */
$process = [
    ['step' => '01', 'title' => 'Tell us what it is doing.', 'copy' => 'In your own words. You do not need the name of the part. A photograph of the fault, and one of the whole window or door, gets you a straighter answer than any description.'],
    ['step' => '02', 'title' => 'We tell you what it usually is.', 'copy' => 'Most faults on this page are recognisable before anyone comes out, which is what lets us give you a price to expect rather than a range.'],
    ['step' => '03', 'title' => 'We come and confirm it.', 'copy' => 'The diagnosis is settled at the door, on the actual window. If it turns out to be something other than we expected, you hear that before any work starts, not after.'],
    ['step' => '04', 'title' => 'We fix it, or we say why not.', 'copy' => 'Parts availability is the one thing that decides it on older systems. Where a part is genuinely obsolete we will tell you what the options are instead of leaving you with a window that does not lock.'],
];
?>

<div class="fg-cw fg-rp">

    <?php /* ---------- The finder ------------------------------------------
             First thing after the hero, because the symptom is the only thing
             this visitor knows. The whole grid is in the markup; the buttons
             filter it. With no JavaScript the buttons never appear (the
             controller adds `is-live`) and the grid reads as a plain list of
             every problem we fix, which is a perfectly good page. */ ?>
    <section class="fg-rp-finder" id="fg-repair-finder" aria-labelledby="fg-rp-finder-title" data-fg-repair-finder>
        <div class="container">
            <div class="fg-rp-finder__head">
                <p class="eyebrow"><?php esc_html_e('What is it doing?', 'fenster'); ?></p>
                <h2 id="fg-rp-finder-title"><?php esc_html_e('Start with the symptom, not the part.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Nobody rings up asking for an espagnolette. Pick the thing your window or door is actually doing and we will tell you what is usually behind it, what we do about it, and what it costs.', 'fenster'); ?></p>
            </div>

            <?php /* Hidden until the controller runs. A filter that filters
                     nothing is worse than no filter. */ ?>
            <div class="fg-rp-finder__filters" data-fg-repair-filters hidden>
                <div class="fg-rp-finder__group" role="group" aria-label="<?php esc_attr_e('Filter repairs by what has gone wrong', 'fenster'); ?>">
                    <?php foreach ($groups as $key => $label) : ?>
                        <?php if ($key !== 'all' && empty($group_counts[$key])) { continue; } ?>
                        <button
                            type="button"
                            class="fg-rp-chip<?php echo $key === 'all' ? ' is-active' : ''; ?>"
                            data-fg-repair-group="<?php echo esc_attr($key); ?>"
                            aria-pressed="<?php echo $key === 'all' ? 'true' : 'false'; ?>">
                            <span><?php echo esc_html($label); ?></span>
                            <span class="fg-rp-chip__count"><?php echo esc_html((string) ($group_counts[$key] ?? 0)); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <p class="fg-rp-finder__status" data-fg-repair-status role="status" aria-live="polite"></p>
            </div>

            <div class="fg-rp-grid" data-fg-repair-grid>
                <?php foreach ($problems as $problem) : ?>
                    <?php
                    $pid = (string) ($problem['id'] ?? '');
                    $group = (string) ($problem['group'] ?? '');
                    $symptom = (string) ($problem['symptom'] ?? '');
                    $price = (string) ($problem['price'] ?? '');
                    $link = (string) ($problem['link'] ?? '');
                    if ($pid === '' || $symptom === '') {
                        continue;
                    }
                    ?>
                    <article
                        class="fg-rp-card"
                        data-fg-repair-card
                        data-group="<?php echo esc_attr($group); ?>"
                        id="repair-<?php echo esc_attr($pid); ?>">
                        <div class="fg-rp-card__top">
                            <h3><?php echo esc_html($symptom); ?></h3>
                            <?php if ($price !== '') : ?>
                                <p class="fg-rp-card__price"><span><?php esc_html_e('From', 'fenster'); ?></span><strong><?php echo esc_html($price); ?></strong></p>
                            <?php else : ?>
                                <p class="fg-rp-card__price fg-rp-card__price--quoted"><strong><?php esc_html_e('Quoted', 'fenster'); ?></strong></p>
                            <?php endif; ?>
                        </div>

                        <?php if (! empty($problem['also'])) : ?>
                            <p class="fg-rp-card__also"><?php echo esc_html((string) $problem['also']); ?></p>
                        <?php endif; ?>

                        <dl class="fg-rp-card__detail">
                            <dt><?php esc_html_e('Usually', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) ($problem['cause'] ?? '')); ?></dd>
                            <dt><?php esc_html_e('What we do', 'fenster'); ?></dt>
                            <dd><?php echo esc_html((string) ($problem['fix'] ?? '')); ?></dd>
                        </dl>

                        <?php if (! empty($problem['price_note'])) : ?>
                            <p class="fg-rp-card__note"><?php echo esc_html((string) $problem['price_note']); ?></p>
                        <?php endif; ?>

                        <?php if ($link !== '') : ?>
                            <a class="fg-cw-link" href="<?php echo esc_url(home_url($link)); ?>"><?php echo esc_html((string) ($problem['link_label'] ?? 'Read more')); ?></a>
                        <?php else : ?>
                            <?php /* Carries the symptom to the form. `main.js`
                                     reads data-fg-repair-request and writes the
                                     sentence into the message field, so the
                                     enquiry arrives saying what is wrong
                                     without the customer diagnosing anything.
                                     Still a real anchor, so with no JavaScript
                                     it simply jumps to the form. */ ?>
                            <a
                                class="fg-cw-link"
                                href="#fenster-enquiry"
                                data-fg-repair-request="<?php echo esc_attr($symptom); ?>"><?php esc_html_e('Request this repair', 'fenster'); ?></a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php /* Only ever shown by the controller, and only when a filter
                     empties the grid. It cannot be reached without JavaScript,
                     which is why it is not a `hidden` paragraph of real copy. */ ?>
            <p class="fg-rp-empty" data-fg-repair-empty hidden>
                <?php esc_html_e('Nothing under that heading. Tell us what it is doing and we will work it out.', 'fenster'); ?>
                <a href="#fenster-enquiry"><?php esc_html_e('Describe the fault', 'fenster'); ?></a>
            </p>

            <p class="fg-rp-finder__foot">
                <?php esc_html_e('Not on the list, or not sure which one it is? That is normal, and working it out is our job rather than yours.', 'fenster'); ?>
                <a class="fg-cw-link" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html(sprintf(/* translators: %s: phone number */ __('Call %s', 'fenster'), $phone)); ?></a>
            </p>
        </div>
    </section>

    <?php /* ---------- The parts ---------------------------------------------
             One image section, and it earns its place by answering the question
             the finder raises: what is actually inside my window? These are the
             three parts that account for most of the cards above, photographed
             as parts rather than as a man in overalls holding a screwdriver.
             That is also the answer to "no cheesy tradesman aesthetic": show
             the component, at studio scale, on white. */ ?>
    <section class="fg-rp-parts" aria-labelledby="fg-rp-parts-title">
        <div class="container">
            <div class="fg-rp-parts__head">
                <p class="eyebrow"><?php esc_html_e('What actually fails', 'fenster'); ?></p>
                <h2 id="fg-rp-parts-title"><?php esc_html_e('Three parts account for most of it.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A window or a door is a frame, some glass and a set of moving metal parts. The frame and the glass last decades. It is the moving parts that wear, and every one of them is designed to be replaced without touching the rest.', 'fenster'); ?></p>
            </div>
            <div class="fg-rp-parts__grid">
                <figure class="fg-rp-part">
                    <div class="fg-rp-part__media fg-rp-part__media--cutout">
                        <img
                            src="<?php echo esc_url($img . 'products/casement/studio/cas-kenrick-excalibur.webp'); ?>"
                            alt="<?php esc_attr_e('Multi-point locking mechanism removed from a window sash, showing the gearbox and cams', 'fenster'); ?>"
                            width="1116" height="1200" loading="lazy" decoding="async">
                    </div>
                    <figcaption>
                        <h3><?php esc_html_e('The mechanism', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Runs the full height of the sash edge and throws the locking points when you turn the handle. When a window or door stops locking, this is nearly always the part, and it comes out on its own.', 'fenster'); ?></p>
                    </figcaption>
                </figure>
                <figure class="fg-rp-part">
                    <div class="fg-rp-part__media">
                        <img
                            src="<?php echo esc_url($img . 'products/casement/casement-friction-stay-1200w.webp'); ?>"
                            alt="<?php esc_attr_e('Stainless friction stay hinge along the bottom of an open window sash', 'fenster'); ?>"
                            width="1200" height="823" loading="lazy" decoding="async">
                    </div>
                    <figcaption>
                        <h3><?php esc_html_e('The hinges', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Friction stays carry the whole weight of the sash every time it opens. They seize and bind rather than snap, which is why a stiff window is usually a hinge problem and not a frame problem.', 'fenster'); ?></p>
                    </figcaption>
                </figure>
                <figure class="fg-rp-part">
                    <div class="fg-rp-part__media">
                        <img
                            src="<?php echo esc_url($img . 'products/casement/studio/cas-security-keep.webp'); ?>"
                            alt="<?php esc_attr_e('Steel keep fitted into a white window frame, the part the locking cam engages', 'fenster'); ?>"
                            width="1249" height="855" loading="lazy" decoding="async">
                    </div>
                    <figcaption>
                        <h3><?php esc_html_e('The keeps', 'fenster'); ?></h3>
                        <p><?php esc_html_e('The steel the locking points close into. They drift a millimetre or two as a frame settles, and that is the whole reason a window suddenly needs a shove. Resetting them is the cheapest repair on this page.', 'fenster'); ?></p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <?php /* ---------- Pricing --------------------------------------------
             Eight rows of the eighteen on the office list. The minimum charge
             leads because it is the first thing anyone wants to know and
             publishing it filters out the people we cannot help cheaply, which
             is a kindness to both sides. */ ?>
    <section class="fg-rp-pricing" id="repair-prices" aria-labelledby="fg-rp-pricing-title">
        <div class="container">
            <div class="fg-rp-pricing__shell">
                <div class="fg-rp-pricing__intro">
                    <p class="eyebrow"><?php esc_html_e('What it costs', 'fenster'); ?></p>
                    <h2 id="fg-rp-pricing-title"><?php esc_html_e('Our repair prices, published.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Most companies quote a repair on the doorstep, once someone is already standing in your hall. These are the common jobs at the price we charge for them, so you can decide before anyone comes out.', 'fenster'); ?></p>
                    <?php if (! empty($prices['minimum'])) : ?>
                        <div class="fg-rp-minimum">
                            <p class="fg-rp-minimum__label"><?php esc_html_e('Minimum charge', 'fenster'); ?></p>
                            <p class="fg-rp-minimum__figure"><?php echo esc_html((string) $prices['minimum']); ?></p>
                            <?php if (! empty($prices['minimum_note'])) : ?>
                                <p class="fg-rp-minimum__note"><?php echo esc_html((string) $prices['minimum_note']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="fg-rp-pricing__table">
                    <table>
                        <?php /* The theme has no global visually-hidden utility;
                                 casement added its own scoped one for the same
                                 reason. `.fg-rp-sr` is this block's. */ ?>
                        <caption class="fg-rp-sr"><?php esc_html_e('Selected window and door repair prices, including VAT', 'fenster'); ?></caption>
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('Repair', 'fenster'); ?></th>
                                <th scope="col"><?php esc_html_e('Price', 'fenster'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($price_rows as $row) : ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo esc_html((string) ($row['job'] ?? '')); ?>
                                        <?php if (! empty($row['note'])) : ?>
                                            <span><?php echo esc_html((string) $row['note']); ?></span>
                                        <?php endif; ?>
                                    </th>
                                    <td><?php echo esc_html((string) ($row['price'] ?? '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($price_notes !== []) : ?>
                        <ul class="fg-rp-pricing__notes">
                            <?php foreach ($price_notes as $note) : ?>
                                <li><?php echo esc_html((string) $note); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <p class="fg-rp-pricing__caveat"><?php esc_html_e('These are the common jobs, not the whole list. The exact fault, the parts it needs and how many items are done on the same visit all move the final figure, and we confirm it before any work starts.', 'fenster'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php /* ---------- Repair or replace ------------------------------------
             The honest section, and the one that carries the positioning. Two
             columns, no verdict: the customer's situation decides it. Written
             as parallel lists on purpose, which is the same even-handedness
             rule AI.md sets for comparing two products we both sell. */ ?>
    <section class="fg-rp-verdict" aria-labelledby="fg-rp-verdict-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Repair or replace', 'fenster'); ?></p>
                <h2 id="fg-rp-verdict-title"><?php esc_html_e('A repair is usually right. Sometimes it is not.', 'fenster'); ?></h2>
                <p><?php esc_html_e('We would rather fix your window than sell you a new one, and on a sound frame that is genuinely the better answer: the hardware and the glass are the parts designed to be replaced, and replacing them costs a fraction of the window.', 'fenster'); ?></p>
                <p><?php esc_html_e('What we will not do is take the money for a repair we can see will not hold. If the frame itself has gone, a new mechanism is a postponement rather than a fix, and you should hear that from us the first time rather than the second.', 'fenster'); ?></p>
                <div class="fg-cw-actions">
                    <a class="button" href="#fg-repair-finder"><?php esc_html_e('Find your problem', 'fenster'); ?></a>
                    <a class="button button--steel" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html(sprintf(/* translators: %s: phone number */ __('Call %s', 'fenster'), $phone)); ?></a>
                </div>
            </div>
            <div class="fg-rp-verdict__panels">
                <div class="fg-rp-verdict__panel">
                    <h3><?php esc_html_e('Repair it', 'fenster'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('The frame is straight and the welds are sound', 'fenster'); ?></li>
                        <li><?php esc_html_e('The fault is hardware: a lock, a handle, a hinge, a keep', 'fenster'); ?></li>
                        <li><?php esc_html_e('The glass has misted but the frame is fine', 'fenster'); ?></li>
                        <li><?php esc_html_e('One or two windows are affected, not the whole house', 'fenster'); ?></li>
                        <li><?php esc_html_e('Parts for the system are still made', 'fenster'); ?></li>
                    </ul>
                </div>
                <div class="fg-rp-verdict__panel fg-rp-verdict__panel--alt">
                    <h3><?php esc_html_e('Replace it', 'fenster'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Sashes have distorted or the welds have opened', 'fenster'); ?></li>
                        <li><?php esc_html_e('The same window has needed the same repair before', 'fenster'); ?></li>
                        <li><?php esc_html_e('Hardware for the system is genuinely obsolete', 'fenster'); ?></li>
                        <li><?php esc_html_e('Most of the windows are failing at once', 'fenster'); ?></li>
                        <li><?php esc_html_e('You were replacing them soon anyway', 'fenster'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php /* ---------- Replacement glass -------------------------------------
             A real share of this page's traffic wants glass, not hardware. The
             band is prominent because sending them one click sooner is worth
             more than keeping them here, and it says only enough to make the
             click obviously correct. Everything else about sealed units lives
             on that page and is not repeated. */ ?>
    <section class="fg-rp-glass" aria-labelledby="fg-rp-glass-title">
        <div class="container fg-rp-glass__shell">
            <div class="fg-rp-glass__copy">
                <p class="eyebrow"><?php esc_html_e('Misted or broken glass', 'fenster'); ?></p>
                <h2 id="fg-rp-glass-title"><?php esc_html_e('If it is the glass, the frame stays.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Cloudy glass, condensation you cannot wipe off, a pane you can no longer see the garden through: that is a failed sealed unit, not a failed window. The glass is measured, made to suit the frame you already have, and changed on its own.', 'fenster'); ?></p>
                <a class="button" href="<?php echo $glass_url; ?>"><?php esc_html_e('See replacement glazed units', 'fenster'); ?></a>
            </div>
            <figure class="fg-rp-glass__media">
                <img
                    src="<?php echo esc_url($img . 'products/curated/fenster-double-glazed-unit.jpeg'); ?>"
                    alt="<?php esc_attr_e('Sealed double glazed unit sample cut through to show the two panes and the cavity between them', 'fenster'); ?>"
                    width="1920" height="1280" loading="lazy" decoding="async">
            </figure>
        </div>
    </section>

    <?php /* ---------- Why Fenster -------------------------------------------
             Four claims, every one checkable, none of them "professional
             service". See the note on $why above for where each comes from. */ ?>
    <section class="fg-rp-why" aria-labelledby="fg-rp-why-title">
        <div class="container">
            <div class="fg-rp-why__head">
                <p class="eyebrow"><?php esc_html_e('Why us', 'fenster'); ?></p>
                <h2 id="fg-rp-why-title"><?php esc_html_e('An installer who repairs, not a repair company.', 'fenster'); ?></h2>
                <p><?php esc_html_e('That distinction is the whole argument, and it cuts both ways. It is why we recognise the hardware, and it is why we have no reason to talk you into a window you do not need.', 'fenster'); ?></p>
            </div>
            <div class="fg-rp-why__grid">
                <?php foreach ($why as $index => $item) : ?>
                    <article class="fg-rp-why__card">
                        <span class="fg-rp-why__number"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ---------- How it works ------------------------------------------
             Replaces the shared order-process rail on this route only. See the
             note on $process above for why. */ ?>
    <section class="fg-rp-process" aria-labelledby="fg-rp-process-title">
        <div class="container">
            <div class="fg-rp-process__head">
                <p class="eyebrow"><?php esc_html_e('How a repair works', 'fenster'); ?></p>
                <h2 id="fg-rp-process-title"><?php esc_html_e('Four steps, and the first one is a photograph.', 'fenster'); ?></h2>
            </div>
            <ol class="fg-rp-process__rail">
                <?php foreach ($process as $step) : ?>
                    <li>
                        <span class="fg-rp-process__number"><?php echo esc_html($step['step']); ?></span>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['copy']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

</div>
