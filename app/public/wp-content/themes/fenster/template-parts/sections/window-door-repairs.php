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
        'copy' => 'Installing is our main trade, so we recognise the gear rather than guessing at it.',
    ],
    [
        'title' => 'We will tell you when not to bother.',
        'copy' => 'A window we would be fixing again next winter is a postponement, not a repair. You will hear that the first time.',
    ],
    [
        'title' => 'Our own engineers.',
        'copy' => 'The people who come out are the people who fit our installations. Nobody is sent under our name who does not work for us.',
    ],
    [
        'title' => 'Established, with a showroom.',
        /* No accreditation marks in this card. FENSA and CPA are real and they
           are on the trust strip site-wide, but sat in repair copy they read as
           cover on the repair, which is exactly the confusion the guarantee
           claim on this route caused for months. Owner instruction, 2026-08-06:
           cut it. */
        'copy' => 'Since 2018, from Alston Drive in Bradwell Abbey. If a repair turns into a replacement, it is the same company either way.',
    ],
];

/* The repair process. Four steps, and deliberately not the shared order-process
   rail, which runs "Your price, Technical survey, Installation, Aftercare" and
   describes buying windows. Nobody having a hinge changed gets a technical
   survey or a FENSA certificate.

   Corrected 2026-08-06 against the real office process, which the owner
   supplied and which is better than what this said. Step 3 used to be "we
   confirm it at the door", i.e. we always come out. In practice the office can
   usually diagnose and price remotely from a description and photographs, and
   where a visit IS needed it is normally free. That is a materially stronger
   proposition than the one the page was making, and it is why the photograph
   ask in step 1 matters: it is not a nicety, it is what lets us skip a visit. */
$process = [
    ['step' => '01', 'title' => 'Tell us what it is doing.', 'copy' => 'In your own words, with a photograph if you can. You do not need the name of the part.'],
    ['step' => '02', 'title' => 'We price it, usually remotely.', 'copy' => 'Most faults the office can diagnose and quote over the phone or by email, without anyone coming out.'],
    ['step' => '03', 'title' => 'If it needs looking at, we come.', 'copy' => 'Normally free of charge. You get the figure before you decide anything.'],
    ['step' => '04', 'title' => 'We fix it, or say why not.', 'copy' => 'On older systems parts availability decides it. If a part is obsolete we will tell you.'],
];
?>

<div class="fg-cw fg-rp">

    <?php /* ---------- What to expect ------------------------------------
             Stands in the slot the key-specification strip occupies on every
             other product route. That strip is gated off here because a repair
             has no specification — owner, 2026-08-06 — and four invented
             product facts would be worse than nothing.

             All four of these are the real office process, given by the owner
             on 2026-08-06 and not inferable from the price list:
               - quoting is normally free, including coming out to look;
               - the office can often diagnose and estimate remotely, over the
                 phone or by email, which is the fastest route for most faults;
               - the minimum charge is a floor on the WORK and applies only if
                 we do it. It is not a callout fee. Its purpose is that we are
                 not sending someone out to fit a £20 handle;
               - we repair other installers' work.
             "Normally" and "often" are the owner's own hedges and stay. */ ?>
    <section class="fg-rp-expect" aria-label="<?php esc_attr_e('What to expect from a repair enquiry', 'fenster'); ?>">
        <div class="container">
            <ul class="fg-rp-expect__row">
                <li>
                    <span class="fg-rp-expect__label"><?php esc_html_e('Quoting', 'fenster'); ?></span>
                    <span class="fg-rp-expect__value"><?php esc_html_e('Normally free, including coming out', 'fenster'); ?></span>
                </li>
                <li>
                    <span class="fg-rp-expect__label"><?php esc_html_e('Often no visit needed', 'fenster'); ?></span>
                    <span class="fg-rp-expect__value"><?php esc_html_e('We can usually price it by phone or email', 'fenster'); ?></span>
                </li>
                <li>
                    <span class="fg-rp-expect__label"><?php esc_html_e('We repair', 'fenster'); ?></span>
                    <span class="fg-rp-expect__value"><?php esc_html_e("Any installer's work, uPVC, aluminium, composite", 'fenster'); ?></span>
                </li>
                <li>
                    <span class="fg-rp-expect__label"><?php esc_html_e('Minimum charge', 'fenster'); ?></span>
                    <span class="fg-rp-expect__value"><?php esc_html_e('Only applies if you go ahead with the work', 'fenster'); ?></span>
                </li>
            </ul>
        </div>
    </section>

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
                <p><?php esc_html_e('Nobody rings up asking for an espagnolette. Pick what yours is doing and we will tell you what is usually behind it.', 'fenster'); ?></p>
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
                            <?php /* The data carries "From £144" whole rather
                                     than a bare figure with a "From" label
                                     rendered beside it. Owner instruction,
                                     2026-08-06: no exact prices anywhere, so
                                     there is no code path that can print one.
                                     A blank price means quoted individually. */ ?>
                            <p class="fg-rp-card__price">
                                <strong><?php echo esc_html($price !== '' ? $price : __('Quoted', 'fenster')); ?></strong>
                            </p>
                        </div>

                        <?php /* One line of diagnosis and nothing else. This
                                 used to be a two-term definition list under
                                 "USUALLY" and "WHAT WE DO" labels, which was
                                 two paragraphs and two uppercase labels per
                                 card, fifteen times over. Owner, 2026-08-06:
                                 it read as a big page of text. The label went
                                 with it — the sentence says "usually" itself
                                 where it needs to. */ ?>
                        <p class="fg-rp-card__cause"><?php echo esc_html((string) ($problem['cause'] ?? '')); ?></p>

                        <?php if (! empty($problem['also'])) : ?>
                            <p class="fg-rp-card__also"><?php echo esc_html((string) $problem['also']); ?></p>
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
                <p><?php esc_html_e('The frame and the glass last decades. It is the moving metal that wears, and all of it is designed to come out without touching the rest.', 'fenster'); ?></p>
            </div>
            <div class="fg-rp-parts__grid">
                <figure class="fg-rp-part">
                    <div class="fg-rp-part__media fg-rp-part__media--cutout">
                        <img
                            src="<?php echo esc_url($img . 'products/casement/studio/cas-kenrick-excalibur.webp'); ?>"
                            alt="<?php esc_attr_e('Multi-point locking mechanism removed from a window sash, showing the gearbox and cams', 'fenster'); ?>"
                            width="1100" height="1182" loading="lazy" decoding="async">
                    </div>
                    <figcaption>
                        <h3><?php esc_html_e('The mechanism', 'fenster'); ?></h3>
                        <p><?php esc_html_e('Throws the locking points when you turn the handle. When something stops locking, it is nearly always this.', 'fenster'); ?></p>
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
                        <p><?php esc_html_e('Friction stays take the sash weight every time it opens. They seize and bind rather than snap.', 'fenster'); ?></p>
                    </figcaption>
                </figure>
                <?php /* Was "the keeps", and that was wrong. Owner correction,
                         2026-08-06: keeps do not fail. They are a folded piece
                         of steel with nothing to wear out; what moves is the
                         sash around them, which is the realignment job, not a
                         part failure. The tell was there and I missed it —
                         keeps are not a line on the repairs price list, and all
                         three of these should map to something that is.
                         Handles are: they are the most common single repair we
                         are called out for. */ ?>
                <figure class="fg-rp-part">
                    <div class="fg-rp-part__media fg-rp-part__media--cutout">
                        <img
                            <?php /* `-cutout`, not the handle hub's own file.
                                     `s2-chrome-finish.png` has an alpha channel
                                     but an OPAQUE #FAFAFA backdrop, so the CSS
                                     drop-shadow drew a shadow round the
                                     rectangle and it read as a card inside a
                                     card. This is that file flood-filled to
                                     real transparency, saved under a new name
                                     rather than replacing a shared asset the
                                     handle hub also renders. */ ?>
                            src="<?php echo esc_url($img . 'products/handles/s2-chrome-cutout.png'); ?>"
                            alt="<?php esc_attr_e('Chrome window handle with its key, off the window', 'fenster'); ?>"
                            width="421" height="715" loading="lazy" decoding="async">
                    </div>
                    <figcaption>
                        <h3><?php esc_html_e('The handle', 'fenster'); ?></h3>
                        <p><?php esc_html_e('The part you touch every day, so it wears first. Usually the spindle rounding off rather than the handle breaking.', 'fenster'); ?></p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <?php /* ---------- Price guiding ------------------------------------
             NOT a price list, and it must not become one again. The first
             build put eight rows of the office tariff on the page as a table.
             Owner, 2026-08-06: that encourages shopping around, hands a
             competitor a line-by-line undercut and turns us into somebody
             else's benchmark. What a visitor needs is enough to know they are
             in the right ballpark, which is three "from" anchors and a range.
             Do not add a fourth example and do not restore the table. */ ?>
    <section class="fg-rp-pricing" id="repair-prices" aria-labelledby="fg-rp-pricing-title">
        <div class="container">
            <div class="fg-rp-pricing__shell">
                <div class="fg-rp-pricing__intro">
                    <p class="eyebrow"><?php esc_html_e('Rough cost', 'fenster'); ?></p>
                    <h2 id="fg-rp-pricing-title"><?php esc_html_e('What a repair usually comes to.', 'fenster'); ?></h2>
                    <?php if (! empty($prices['range'])) : ?>
                        <p><?php echo esc_html((string) $prices['range']); ?></p>
                    <?php endif; ?>
                    <?php if (! empty($prices['remote'])) : ?>
                        <p><?php echo esc_html((string) $prices['remote']); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (! empty($prices['examples']) && is_array($prices['examples'])) : ?>
                    <ul class="fg-rp-anchors">
                        <?php foreach ($prices['examples'] as $example) : ?>
                            <li>
                                <span class="fg-rp-anchors__job"><?php echo esc_html((string) ($example['job'] ?? '')); ?></span>
                                <span class="fg-rp-anchors__price"><?php echo esc_html((string) ($example['price'] ?? '')); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (! empty($prices['minimum_note'])) : ?>
                    <p class="fg-rp-pricing__minimum"><?php echo esc_html((string) $prices['minimum_note']); ?></p>
                <?php endif; ?>

                <?php if ($price_notes !== []) : ?>
                    <p class="fg-rp-pricing__caveat"><?php echo esc_html(implode(' ', array_map('strval', $price_notes))); ?></p>
                <?php endif; ?>
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
                <p><?php esc_html_e('On a sound frame, repair is genuinely the better answer: the hardware and the glass are the parts designed to be replaced, and they cost a fraction of the window. What we will not do is take the money for a repair we can see will not hold.', 'fenster'); ?></p>
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
                <p><?php esc_html_e('Cloudy glass and condensation you cannot wipe off mean a failed sealed unit, not a failed window. The glass is measured to the frame you already have and changed on its own.', 'fenster'); ?></p>
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
                <p><?php esc_html_e('That cuts both ways, and both are the point: it is why we recognise the hardware, and why we have no reason to talk you into a window you do not need.', 'fenster'); ?></p>
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
                <h2 id="fg-rp-process-title"><?php esc_html_e('Most of it happens before anyone visits.', 'fenster'); ?></h2>
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
