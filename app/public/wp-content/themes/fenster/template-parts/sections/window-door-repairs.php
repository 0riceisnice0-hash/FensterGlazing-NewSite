<?php
/**
 * Window and door repairs: the bespoke page.
 *
 * THIRD REBUILD, 2026-08-06. The owner rejected the previous two outright and
 * the reason is worth keeping: "reads like a whole page of text and no images
 * whatsoever", and "think Aston Martin servicing, not a local garage". Both
 * earlier versions were a grid of text cards with a service list in them. This
 * one is built round photography and one interactive object.
 *
 * WHAT CHANGED IN THE BRIEF, and none of it may be quietly reversed:
 *   - NO PRICES. The office price list is now the source of what we OFFER and
 *     nothing else. See the Repair Pricing Rule in AI.md.
 *   - The register is a marque's servicing pages, not a trades service list.
 *     That means full-bleed photography, a dark technical plate, real component
 *     imagery, and no card grids.
 *   - The USPs are the owner's: quick and efficient, dedicated service
 *     engineers with decades of experience, transparent, fairly priced, and we
 *     can source most parts for most systems.
 *
 * THE ONE FEATURE is the diagnostic schematic. A technical line drawing of a
 * window and a door, the way a workshop manual draws them. Choosing a symptom
 * highlights the part responsible ON the drawing and shows the real studio
 * photograph of that component beside it. It earns its place by AI.md's test —
 * it answers something a photograph cannot, because which part matters depends
 * on the symptom — and it is what replaced fifteen text cards.
 *
 * The schematic is inline SVG, deliberately. It is crisp at any size, it needs
 * no library (so the Three.js rule is untouched), it themes with CSS custom
 * properties, and every hit target in it is a real <button> outside the
 * drawing rather than a click handler on a path. The drawing itself is
 * `aria-hidden`: it is an illustration of the answer, not the control.
 *
 * THREE PLACES MUST AGREE and the render harness asserts all three: a symptom's
 * `part` is a key in `repair_parts`, its `svg` is a `data-part` group in the
 * markup below, and every group in the markup is reachable from some symptom.
 *
 * NOT CLAIMED ANYWHERE: response times, callout windows, same-day or emergency
 * service, a guarantee on repair work. Quoting being normally free and usually
 * remote IS claimed, because the owner stated it; see Repair Service Facts.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$phone_href = preg_replace('/\s+/', '', $phone);

$parts = fenster_data('repair_parts', []);
$parts = is_array($parts) ? $parts : [];

/* Resolve the image and link paths BEFORE they reach the JSON block. The data
   stores theme-relative `/wp-content/themes/fenster/...` paths, which is the
   site-wide convention, but test and live are Bedrock and serve the theme from
   `/app/themes/fenster/...`. Every other consumer of these paths runs them
   through `fenster_generated_url()` on the way out; the controller cannot,
   because by then it is a string in a JSON blob. Miss this and every part
   photograph 404s on test while working perfectly in a local render. */
foreach ($parts as $key => $part) {
    if (! empty($part['image'])) {
        $parts[$key]['image'] = fenster_generated_url((string) $part['image']);
    }
    if (! empty($part['link'])) {
        $parts[$key]['link'] = home_url((string) $part['link']);
    }
}
$diagnostics = fenster_data('repair_diagnostics', []);
$diagnostics = is_array($diagnostics) ? $diagnostics : [];
$usps = fenster_data('repair_usps', []);
$usps = is_array($usps) ? array_values($usps) : [];
$services = fenster_data('repair_services', []);
$services = is_array($services) ? array_values($services) : [];

$img = '/wp-content/themes/fenster/assets/images/';
$glass_url = esc_url(home_url('/double-glazing-replacement/'));

/* The parts wall. "We can source most parts for most systems" is an assertion
   until you see the range, so the section shows it: five handle families and
   the casement hardware set, all real supplier photography already in the
   theme. Every one of these is a finish or component we actually fit, which is
   what stops it being a decorative collage. */
$wall = [
    ['file' => 'products/handles/s2-chrome-cutout.png', 'alt' => 'Chrome window handle', 'cutout' => true],
    ['file' => 'products/handles/s2-gold-finish.png', 'alt' => 'Gold window handle'],
    ['file' => 'products/handles/s2-black-finish.png', 'alt' => 'Black window handle'],
    ['file' => 'products/handles/monkey-tail-handle.png', 'alt' => 'Monkey tail window handle'],
    ['file' => 'products/door-handles/chrome-long-plate.png', 'alt' => 'Chrome long-plate door handle'],
    ['file' => 'products/door-handles/black-long-plate.png', 'alt' => 'Black long-plate door handle'],
    ['file' => 'products/door-handles/gold-long-plate.png', 'alt' => 'Gold long-plate door handle'],
    ['file' => 'products/door-handles/brushed-steel-long-plate.png', 'alt' => 'Brushed steel long-plate door handle'],
    ['file' => 'products/handles-patio/patio-chrome.webp', 'alt' => 'Chrome sliding patio door handle'],
    ['file' => 'products/handles-patio/patio-black.webp', 'alt' => 'Black sliding patio door handle'],
    ['file' => 'products/handles-tilt-turn/tilt-turn-chrome.png', 'alt' => 'Chrome tilt and turn window handle'],
    ['file' => 'products/handles-tilt-turn/tilt-turn-white.png', 'alt' => 'White tilt and turn window handle'],
    ['file' => 'products/handles-liftslide/liftslide-black.webp', 'alt' => 'Black lift and slide door lever'],
    ['file' => 'products/handles-liftslide/liftslide-brushed-stainless-steel.webp', 'alt' => 'Brushed stainless lift and slide door lever'],
];
?>

<div class="fg-rp">

    <?php /* ---------- The proposition -------------------------------------
             Four USPs on a dark plate directly under the hero, which is where
             the key-specification strip sits on a product route. A repair has
             no specification — owner, 2026-08-06 — so this says what the
             service is instead. Dark because it is the handoff out of the hero
             and it keeps the top of the page from being a white text block,
             which is what the last version was. */ ?>
    <section class="fg-rp-prop" aria-labelledby="fg-rp-prop-title">
        <div class="container">
            <h2 id="fg-rp-prop-title" class="fg-rp-sr"><?php esc_html_e('Why have us repair it', 'fenster'); ?></h2>
            <ul class="fg-rp-prop__grid">
                <?php foreach ($usps as $index => $usp) : ?>
                    <li>
                        <span class="fg-rp-prop__num"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html((string) ($usp['title'] ?? '')); ?></h3>
                        <p><?php echo esc_html((string) ($usp['copy'] ?? '')); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php /* ---------- The diagnostic schematic -----------------------------
             The feature. Symptom in, part out, drawn.

             Progressive enhancement: without JavaScript the symptom buttons do
             nothing, so the whole interactive shell is `hidden` in the markup
             and revealed by the controller, exactly as the previous version's
             filter row was. What renders instead is `.fg-rp-diag__fallback`
             below, a plain list pairing each symptom with its part — which is
             also what search engines read, so the symptom language is never
             locked inside a widget. */ ?>
    <section class="fg-rp-diag" aria-labelledby="fg-rp-diag-title" data-fg-repair-diag>
        <div class="container">
            <div class="fg-rp-diag__head">
                <p class="eyebrow"><?php esc_html_e('Diagnostics', 'fenster'); ?></p>
                <h2 id="fg-rp-diag-title"><?php esc_html_e('Tell us what it is doing. We will show you the part.', 'fenster'); ?></h2>
                <p><?php esc_html_e('You do not need to know what anything is called. Pick the symptom and the drawing shows you where the fault lives and what we do about it.', 'fenster'); ?></p>
            </div>

            <?php /* The part library, once, for the controller to swap from.
                     A JSON script block rather than a hidden panel per symptom:
                     twelve symptoms share nine parts, so per-symptom panels
                     would duplicate the copy and let the copies drift. Emitted
                     with `wp_json_encode` and a `type` the browser will not
                     execute. */ ?>
            <script type="application/json" data-fg-diag-parts>
                <?php echo wp_json_encode($parts); ?>
            </script>

            <div class="fg-rp-diag__shell" data-fg-diag-shell hidden>

                <?php /* Product toggle. Two schematics, one visible at a time. */ ?>
                <div class="fg-rp-diag__switch" role="group" aria-label="<?php esc_attr_e('Choose windows or doors', 'fenster'); ?>">
                    <?php foreach ($diagnostics as $key => $set) : ?>
                        <button
                            type="button"
                            data-fg-diag-product="<?php echo esc_attr((string) $key); ?>"
                            aria-pressed="<?php echo $key === 'window' ? 'true' : 'false'; ?>"><?php echo esc_html((string) ($set['label'] ?? '')); ?></button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-rp-diag__stage">

                    <?php /* Column 1: the symptoms. */ ?>
                    <div class="fg-rp-diag__symptoms">
                        <?php foreach ($diagnostics as $key => $set) : ?>
                            <ul data-fg-diag-list="<?php echo esc_attr((string) $key); ?>"<?php echo $key === 'window' ? '' : ' hidden'; ?>>
                                <?php foreach ((array) ($set['symptoms'] ?? []) as $i => $symptom) : ?>
                                    <li>
                                        <button
                                            type="button"
                                            data-fg-diag-symptom="<?php echo esc_attr((string) ($symptom['id'] ?? '')); ?>"
                                            data-part="<?php echo esc_attr((string) ($symptom['part'] ?? '')); ?>"
                                            data-svg="<?php echo esc_attr((string) ($symptom['svg'] ?? '')); ?>"
                                            aria-pressed="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                                            <span><?php echo esc_html((string) ($symptom['symptom'] ?? '')); ?></span>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                        <p class="fg-rp-diag__note">
                            <?php esc_html_e('Not sure which?', 'fenster'); ?>
                            <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                        </p>
                    </div>

                    <?php /* Column 2: the drawing. Aria-hidden because it
                             illustrates the answer rather than being the
                             control; the buttons above are the interface and
                             the panel below carries the same information as
                             text. */ ?>
                    <div class="fg-rp-diag__plate">
                        <svg class="fg-rp-svg" viewBox="0 0 400 360" role="img" aria-hidden="true" focusable="false" data-fg-diag-svg="window">
                            <g class="fg-rp-svg__frame">
                                <rect x="24" y="18" width="352" height="286" rx="3"/>
                                <rect x="36" y="30" width="328" height="262" rx="2"/>
                                <line x1="212" y1="30" x2="212" y2="292"/>
                                <path d="M18 304 H382 l-10 20 H28 Z" class="fg-rp-svg__cill"/>
                            </g>
                            <g data-part="glass" class="fg-rp-svg__part">
                                <rect x="52" y="46" width="144" height="230" rx="1"/>
                                <rect x="228" y="46" width="120" height="230" rx="1"/>
                                <path d="M60 260 L120 60 M84 260 L144 60" class="fg-rp-svg__sheen"/>
                            </g>
                            <g data-part="gasket" class="fg-rp-svg__part">
                                <rect x="46" y="40" width="156" height="242" rx="2"/>
                            </g>
                            <g data-part="stays" class="fg-rp-svg__part">
                                <path d="M56 50 L128 62 M56 62 L104 66"/>
                                <path d="M56 272 L128 260 M56 260 L104 256"/>
                                <circle cx="128" cy="62" r="3"/>
                                <circle cx="128" cy="260" r="3"/>
                            </g>
                            <g data-part="mechanism" class="fg-rp-svg__part">
                                <rect x="192" y="60" width="8" height="202" rx="2"/>
                                <path d="M192 96 h-9 M192 140 h-9 M192 184 h-9 M192 228 h-9"/>
                            </g>
                            <g data-part="keeps" class="fg-rp-svg__part">
                                <rect x="204" y="90" width="9" height="14" rx="1"/>
                                <rect x="204" y="134" width="9" height="14" rx="1"/>
                                <rect x="204" y="178" width="9" height="14" rx="1"/>
                                <rect x="204" y="222" width="9" height="14" rx="1"/>
                            </g>
                            <g data-part="handle" class="fg-rp-svg__part">
                                <rect x="176" y="150" width="16" height="26" rx="3"/>
                                <path d="M184 176 v34" stroke-linecap="round"/>
                            </g>
                        </svg>

                        <svg class="fg-rp-svg" viewBox="0 0 400 360" role="img" aria-hidden="true" focusable="false" data-fg-diag-svg="door" hidden>
                            <g class="fg-rp-svg__frame">
                                <rect x="88" y="14" width="224" height="300" rx="3"/>
                                <rect x="100" y="26" width="200" height="276" rx="2"/>
                                <path d="M80 314 H320 l-8 18 H88 Z" class="fg-rp-svg__cill"/>
                            </g>
                            <g data-part="dglass" class="fg-rp-svg__part">
                                <rect x="126" y="52" width="148" height="96" rx="1"/>
                                <path d="M134 140 L182 60 M158 140 L206 60" class="fg-rp-svg__sheen"/>
                            </g>
                            <g data-part="dgasket" class="fg-rp-svg__part">
                                <rect x="110" y="36" width="180" height="256" rx="2"/>
                            </g>
                            <g data-part="hinges" class="fg-rp-svg__part">
                                <rect x="104" y="62" width="12" height="26" rx="2"/>
                                <rect x="104" y="152" width="12" height="26" rx="2"/>
                                <rect x="104" y="242" width="12" height="26" rx="2"/>
                            </g>
                            <g data-part="gearbox" class="fg-rp-svg__part">
                                <rect x="282" y="58" width="8" height="212" rx="2"/>
                                <path d="M290 96 h9 M290 150 h9 M290 204 h9"/>
                            </g>
                            <g data-part="cylinder" class="fg-rp-svg__part">
                                <circle cx="268" cy="200" r="9"/>
                                <path d="M268 200 v10" stroke-linecap="round"/>
                            </g>
                            <g data-part="dhandle" class="fg-rp-svg__part">
                                <rect x="260" y="150" width="16" height="34" rx="3"/>
                                <path d="M268 166 h-34" stroke-linecap="round"/>
                            </g>
                        </svg>

                        <p class="fg-rp-diag__caption" data-fg-diag-caption></p>
                    </div>

                    <?php /* Column 3: the part. Every field is swapped by the
                             controller from the data attributes the buttons
                             carry, so there is exactly one copy of each part's
                             copy in the DOM rather than one per symptom. */ ?>
                    <figure class="fg-rp-diag__part" data-fg-diag-panel>
                        <div class="fg-rp-diag__media">
                            <img data-fg-diag-image src="" alt="" width="1100" height="1182" loading="lazy" decoding="async">
                        </div>
                        <figcaption>
                            <p class="fg-rp-diag__sub" data-fg-diag-sub></p>
                            <h3 data-fg-diag-name></h3>
                            <p data-fg-diag-what></p>
                            <p class="fg-rp-diag__fix"><span><?php esc_html_e('What we do', 'fenster'); ?></span><em data-fg-diag-fix></em></p>
                            <a class="fg-rp-diag__link" data-fg-diag-link hidden href="#"></a>
                        </figcaption>
                    </figure>
                </div>
            </div>

            <?php /* The no-JavaScript version, and the indexable one. Real
                     content, not a placeholder: every symptom paired with the
                     part behind it. */ ?>
            <div class="fg-rp-diag__fallback" data-fg-diag-fallback>
                <?php foreach ($diagnostics as $set) : ?>
                    <div>
                        <h3><?php echo esc_html((string) ($set['label'] ?? '')); ?></h3>
                        <dl>
                            <?php foreach ((array) ($set['symptoms'] ?? []) as $symptom) : ?>
                                <?php $part = $parts[(string) ($symptom['part'] ?? '')] ?? null; ?>
                                <dt><?php echo esc_html((string) ($symptom['symptom'] ?? '')); ?></dt>
                                <dd><?php echo esc_html($part ? (string) $part['name'] . '. ' . (string) $part['fix'] : ''); ?></dd>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ---------- The engineers ---------------------------------------
             The owner's strongest USP and the one that most needs a face on
             it. Full-bleed photograph, copy on the plate. */ ?>
    <section class="fg-rp-team" aria-labelledby="fg-rp-team-title">
        <?php /* Andy McCullagh, and this is the one portrait on the page for
                 two reasons. It is genuinely ours, black and white, in a
                 Fenster fleece, which is the register the owner asked for —
                 the previous version used a hi-vis installer shot, which is
                 the local-garage look this page exists to avoid.

                 And it is HIM specifically because CASESTUDIES.md records his
                 job title as Service Engineer. The other portraits in the
                 theme are fitters, and a row of installers' faces under a
                 heading reading "service engineers, not installers" would
                 contradict itself. If the owner wants the whole repair team
                 here, we need to know who they are first. */ ?>
        <div class="fg-rp-team__media">
            <img
                src="<?php echo esc_url(fenster_generated_url($img . 'imported/7.png')); ?>"
                alt="<?php esc_attr_e('Andy McCullagh, Fenster service engineer', 'fenster'); ?>"
                width="2430" height="2430" loading="lazy" decoding="async">
        </div>
        <div class="fg-rp-team__copy">
            <p class="eyebrow"><?php esc_html_e('Who comes out', 'fenster'); ?></p>
            <h2 id="fg-rp-team-title"><?php esc_html_e('Service engineers, not installers between jobs.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Repairs are their trade rather than the gap between fitting weeks, and there are decades of experience across the team. They are on our books, so nobody arrives at your house under our name who does not work for us.', 'fenster'); ?></p>
            <p><?php esc_html_e('It is also why the diagnosis usually holds: they have seen the system before, and most faults are recognised from a description and a photograph rather than found on the day.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* ---------- The parts wall ---------------------------------------
             "We can source most parts for most systems" proved rather than
             asserted. Fourteen real components from five handle families and
             the casement hardware set. It is the densest imagery on the page
             and it is doing an argument, not decoration. */ ?>
    <section class="fg-rp-wall" aria-labelledby="fg-rp-wall-title">
        <div class="container">
            <div class="fg-rp-wall__head">
                <p class="eyebrow"><?php esc_html_e('Parts', 'fenster'); ?></p>
                <h2 id="fg-rp-wall-title"><?php esc_html_e('Most parts, for most systems.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Hardware is more standardised than it looks. A mechanism is matched on its backset, centres and faceplate rather than on the badge on the window, which is why we can repair systems we did not fit and systems nobody sells any more.', 'fenster'); ?></p>
            </div>
            <ul class="fg-rp-wall__grid" aria-label="<?php esc_attr_e('Hardware finishes and components we fit', 'fenster'); ?>">
                <?php foreach ($wall as $item) : ?>
                    <li<?php echo ! empty($item['cutout']) ? ' class="is-cutout"' : ''; ?>>
                        <img
                            src="<?php echo esc_url(fenster_generated_url($img . $item['file'])); ?>"
                            alt="<?php echo esc_attr((string) $item['alt']); ?>"
                            loading="lazy" decoding="async">
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($services !== []) : ?>
                <div class="fg-rp-wall__scope">
                    <h3><?php esc_html_e('What we are called out for', 'fenster'); ?></h3>
                    <ul>
                        <?php foreach ($services as $service) : ?>
                            <li><?php echo esc_html((string) $service); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php /* ---------- Repair or replace, and the glass hand-off -------------
             Kept from the previous version because the owner did not object to
             either, but both cut back and the glass band given the photograph
             it always should have had. */ ?>
    <section class="fg-rp-verdict" aria-labelledby="fg-rp-verdict-title">
        <div class="container fg-rp-verdict__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Repair or replace', 'fenster'); ?></p>
                <h2 id="fg-rp-verdict-title"><?php esc_html_e('A repair is usually right. Sometimes it is not.', 'fenster'); ?></h2>
                <p><?php esc_html_e('On a sound frame the hardware and the glass are the parts designed to be replaced, and they cost a fraction of the window. What we will not do is take the money for a repair we can see will not hold.', 'fenster'); ?></p>
                <div class="fg-rp-verdict__lists">
                    <div>
                        <h3><?php esc_html_e('Repair', 'fenster'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('The frame is straight and the welds are sound', 'fenster'); ?></li>
                            <li><?php esc_html_e('The fault is hardware or glass', 'fenster'); ?></li>
                            <li><?php esc_html_e('One or two windows, not the whole house', 'fenster'); ?></li>
                        </ul>
                    </div>
                    <div>
                        <h3><?php esc_html_e('Replace', 'fenster'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('Sashes distorted or welds opened', 'fenster'); ?></li>
                            <li><?php esc_html_e('The same fault has come back before', 'fenster'); ?></li>
                            <li><?php esc_html_e('Most of the windows are failing at once', 'fenster'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <a class="fg-rp-glass" href="<?php echo $glass_url; ?>">
                <img
                    src="<?php echo esc_url(fenster_generated_url($img . 'products/curated/fenster-double-glazed-unit.jpeg')); ?>"
                    alt="<?php esc_attr_e('Sealed double glazed unit cut through to show the cavity between the panes', 'fenster'); ?>"
                    width="1920" height="1280" loading="lazy" decoding="async">
                <span class="fg-rp-glass__body">
                    <span class="eyebrow"><?php esc_html_e('Misted or broken glass', 'fenster'); ?></span>
                    <strong><?php esc_html_e('If it is the glass, the frame stays.', 'fenster'); ?></strong>
                    <span><?php esc_html_e('A failed sealed unit is measured and changed on its own.', 'fenster'); ?></span>
                    <span class="fg-rp-glass__cta"><?php esc_html_e('Replacement glazed units', 'fenster'); ?></span>
                </span>
            </a>
        </div>
    </section>

    <?php /* ---------- How it works ------------------------------------------
             Replaces the shared order-process rail, which describes buying
             windows. The office process, owner-supplied: quoting is normally
             free, and most faults never need a visit. */ ?>
    <section class="fg-rp-process" aria-labelledby="fg-rp-process-title">
        <div class="container">
            <div class="fg-rp-process__head">
                <p class="eyebrow"><?php esc_html_e('How it works', 'fenster'); ?></p>
                <h2 id="fg-rp-process-title"><?php esc_html_e('Most of it happens before anyone visits.', 'fenster'); ?></h2>
            </div>
            <ol class="fg-rp-process__rail">
                <li>
                    <span><?php esc_html_e('01', 'fenster'); ?></span>
                    <h3><?php esc_html_e('Tell us what it is doing', 'fenster'); ?></h3>
                    <p><?php esc_html_e('In your own words, with a photograph if you can.', 'fenster'); ?></p>
                </li>
                <li>
                    <span><?php esc_html_e('02', 'fenster'); ?></span>
                    <h3><?php esc_html_e('We price it, usually remotely', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Most faults the office can diagnose and quote by phone or email.', 'fenster'); ?></p>
                </li>
                <li>
                    <span><?php esc_html_e('03', 'fenster'); ?></span>
                    <h3><?php esc_html_e('If it needs looking at, we come', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Normally free of charge, and you get the figure before you decide.', 'fenster'); ?></p>
                </li>
                <li>
                    <span><?php esc_html_e('04', 'fenster'); ?></span>
                    <h3><?php esc_html_e('We fix it, or say why not', 'fenster'); ?></h3>
                    <p><?php esc_html_e('If a part is genuinely obsolete you will hear that rather than a guess.', 'fenster'); ?></p>
                </li>
            </ol>
            <div class="fg-rp-process__actions">
                <a class="button" href="#fenster-enquiry"><?php esc_html_e('Request a repair', 'fenster'); ?></a>
                <a class="button button--steel" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html(sprintf(/* translators: %s: phone number */ __('Call %s', 'fenster'), $phone)); ?></a>
            </div>
        </div>
    </section>

</div>
