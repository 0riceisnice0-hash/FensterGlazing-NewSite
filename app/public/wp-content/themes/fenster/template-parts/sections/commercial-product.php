<?php
/**
 * Commercial product route template.
 * ---------------------------------------------------------------------------
 * Reworked 2026-08-12 against `COMMERCIAL-AUDIT-2026-08-12.md`, which found four
 * things wrong with the twelve routes that share this file. Each one is answered
 * here rather than page by page, because the whole point of a shared template is
 * that one fix lands twelve times.
 *
 * 1. TEN OF ELEVEN PAGES CARRIED NO SPECIFICATION FIGURE AT ALL, on pages
 *    written for people who price work. There is a specification table now,
 *    driven by `specification` in `inc/commercial-product-data.php`. Figures
 *    nobody has confirmed render as a visible "confirming on request" row rather
 *    than being silently omitted: a specifier reading a table with a row missing
 *    concludes we do not do it, which loses the enquiry the row would have won.
 *
 * 2. THREE HEADINGS WERE IDENTICAL ACROSS ALL ELEVEN, and in the third person,
 *    in H2s a visitor reads first. "What Fenster can check, supply and install",
 *    "Buildings Fenster can look at for this type of work", "Send Fenster your X
 *    brief". They now come from the route's own data with a we/our fallback.
 *    `STYLE.md` and `TONEOFVOICE.md` both require the first person; the
 *    commercial set was simply never swept when the residential one was.
 *
 * 3. THE PROOF BAND IS NEW AND IT USES THE NO-FALLBACK HELPER ON PURPOSE.
 *    `fenster_case_studies_for_product()` returns EVERY study when nothing
 *    matches — the documented fault that put Winslow secondary glazing under
 *    "Real installs" on the tilt and turn page. On a commercial route that would
 *    put a care home under a curtain walling heading. So this calls
 *    `fenster_case_studies_for_product_group([$slug], 3, 'commercial')`, which
 *    has no fallback, and a route nothing claims renders no strip at all.
 *
 * 4. THE REGISTER IS THE SPECIFIER'S, per `STYLE.md` Commercial Pages: "Write
 *    for the person pricing it, not the person living in it." Lead with the
 *    fact, let it carry the sentence, cut the softening. Still Fenster — plain
 *    words, the awkward thing said out loud — just without the warm-up.
 *
 * MARKED PLACEHOLDERS. A detail section may carry `placeholder` and an empty
 * `image`, which renders the dashed panel from the Marked Placeholders Rule in
 * `AI.md` saying what photograph belongs there. Two routes use it today:
 * automation has no photograph of an automatic entrance we have fitted, and
 * healthcare has none of us working inside a live clinical setting. That is
 * better than borrowing a neighbouring product's picture, which is how a
 * residential composite-looking door ended up on the automation page.
 *
 * @package Fenster
 */

$page = is_array($args['page'] ?? null) ? $args['page'] : [];
$product = is_array($args['product'] ?? null) ? $args['product'] : [];
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$slug = (string) ($page['slug'] ?? '');

if ($slug === '' || empty($product)) {
    return;
}

$brand_phone = (string) ($brand['phone'] ?? '01908 429200');
$brand_email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
/* One place to swap when a commercial address exists. Falls back to the office
   recipient rather than to an invented `commercial@`, which would bounce. */
$commercial_email = (string) ($brand['commercial_email'] ?? $brand_email);
$phone_href = preg_replace('/\s+/', '', $brand_phone);
$title = (string) ($product['title'] ?? ($page['title'] ?? 'Commercial glazing'));
$subtitle = (string) ($product['subtitle'] ?? '');
$intro_heading = (string) ($product['intro_heading'] ?? ($title . ' for commercial buildings.'));
$summary = is_array($product['summary'] ?? null) ? array_values($product['summary']) : [];
$stats = is_array($product['stats'] ?? null) ? array_values($product['stats']) : [];
$specification = is_array($product['specification'] ?? null) ? array_values($product['specification']) : [];
$capabilities = is_array($product['capabilities'] ?? null) ? array_values($product['capabilities']) : [];
$detail_sections = is_array($product['detail_sections'] ?? null) ? array_values($product['detail_sections']) : [];
$use_cases = is_array($product['use_cases'] ?? null) ? array_values($product['use_cases']) : [];
$all_products = function_exists('fenster_commercial_product_pages') ? fenster_commercial_product_pages() : [];
$related_products = array_filter($all_products, static fn ($item, $item_slug): bool => $item_slug !== $slug, ARRAY_FILTER_USE_BOTH);
$related_products = array_slice($related_products, 0, 3, true);
$hero_image = (string) ($product['hero_image'] ?? '');
$hero_alt = (string) ($product['hero_alt'] ?? $title);
$intro_image = (string) ($product['intro_image'] ?? $hero_image);
$intro_alt = (string) ($product['intro_alt'] ?? $hero_alt);

/* Per-route headings. The fallbacks are first person so a route that never gets
   its own heading still cannot reintroduce the third-person copy this rework
   removed. */
$capabilities_heading = (string) ($product['capabilities_heading'] ?? 'What we take on within this package.');
$use_cases_heading = (string) ($product['use_cases_heading'] ?? 'Where this work usually happens.');
$enquiry_heading = (string) ($product['enquiry_heading'] ?? ('Send us the ' . strtolower($title) . ' brief.'));

/* THE BAND HEADINGS ARE DERIVED FROM THE ROUTE, NOT HARDCODED, and the render
   harness fails the build if any two routes end up sharing an H2. The first
   version of this rework fixed the three headings the audit named and then
   introduced three more identical ones — spec, proof and related — across all
   twelve pages, which is the same fault wearing a different label. Twelve pages
   sharing an H2 is a weaker page for a reader and a weaker one in search.

   `$title_lc` keeps "uPVC" and other internal capitals intact where a title has
   them, because `strtolower()` on a product name is how "uPVC" becomes "upvc" in
   customer-facing copy — a fault already recorded against the gallery copy on
   the residential template. */
$title_lc = preg_match('/[a-z][A-Z]/', $title) ? $title : strtolower($title);
/* Was "X, in figures." and the owner was right that it did not fit: most rows in
   this table are not figures at all, they are what the thing is specified to —
   "Liniar", "to the rating the specification calls for", "specified to the job".
   A heading promising numbers over a table of specifications reads as a page that
   has not got any. This says what the table is. */
$spec_heading = (string) ($product['spec_heading'] ?? ($title . ', to your specification.'));
$proof_heading = (string) ($product['proof_heading'] ?? ('Recent ' . $title_lc . ' projects.'));
$related_heading = (string) ($product['related_heading'] ?? ('Work that usually comes with ' . $title_lc . '.'));

/* Real jobs claiming this route. No fallback: see the header note. */
$proof = function_exists('fenster_case_studies_for_product_group')
    ? fenster_case_studies_for_product_group([$slug], 3, 'commercial')
    : [];

$is_louvre = $slug === 'louvre-vents';
?>

<article class="fg-commercial-product">
    <section class="fg-commercial-product-hero">
        <?php if ($hero_image !== '') : ?>
            <img class="fg-commercial-product-hero__image" src="<?php echo esc_url(fenster_generated_url($hero_image)); ?>" alt="<?php echo esc_attr($hero_alt); ?>" loading="eager">
        <?php endif; ?>
        <div class="fg-commercial-product-hero__shade"></div>
        <div class="container fg-commercial-product-hero__inner">
            <div class="fg-commercial-product-hero__copy">
                <p class="eyebrow"><?php echo esc_html((string) ($product['eyebrow'] ?? 'Commercial glazing')); ?></p>
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($subtitle !== '') : ?>
                    <p><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php /* THE ACTION ROW WAS UNEVEN and the owner called it, 2026-08-12:
                         a single-line button sitting beside a two-line phone card,
                         so the two never lined up at any width. All three items are
                         one component now, stretched to a shared height, and the
                         email sits with the phone where a specifier expects to find
                         it — most of them would rather send drawings than call.

                         THE EMAIL IS `info@`, WHICH MAY NOT BE THE RIGHT ONE. There
                         is no commercial-specific address anywhere in this theme,
                         and inventing one would bounce real enquiries into nothing.
                         `info@fensterglazing.com` is the owner-confirmed office
                         recipient (2026-08-10), so it is the only defensible choice
                         until a commercial address is supplied. One swap in
                         `brand.email` or a new `brand.commercial_email` changes it
                         everywhere. */ ?>
                <div class="fg-commercial-product-hero__actions">
                    <a class="button button--light" href="#commercial-product-enquiry"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                    <a class="fg-commercial-product-hero__phone" href="tel:<?php echo esc_attr($phone_href); ?>">
                        <span><?php esc_html_e('Call', 'fenster'); ?></span>
                        <strong><?php echo esc_html($brand_phone); ?></strong>
                    </a>
                    <a class="fg-commercial-product-hero__phone" href="mailto:<?php echo esc_attr($commercial_email); ?>">
                        <span><?php esc_html_e('Email', 'fenster'); ?></span>
                        <strong><?php echo esc_html($commercial_email); ?></strong>
                    </a>
                </div>
            </div>

            <?php if (! empty($stats)) : ?>
                <aside class="fg-commercial-product-hero__stats" aria-label="<?php esc_attr_e('Commercial product highlights', 'fenster'); ?>">
                    <?php foreach ($stats as $stat) : ?>
                        <div>
                            <strong><?php echo esc_html((string) ($stat['value'] ?? '')); ?></strong>
                            <span><?php echo esc_html((string) ($stat['label'] ?? '')); ?></span>
                        </div>
                    <?php endforeach; ?>
                </aside>
            <?php endif; ?>
        </div>
    </section>

    <?php /* THE GRID COLLAPSES WHEN THERE IS NO INTRO IMAGE. Without this the
             copy sits in a half-width column with the media column left empty
             beside it — the "narrow leftover column" defect `STYLE.md` names, and
             it appeared the moment the industrial route shipped with no
             photography. Caught by looking at the rendered page, not by the
             harness, which is the third time on this project that a fault passed
             every check and was obvious in one screenshot. */ ?>
    <section class="fg-commercial-product-intro">
        <div class="container fg-commercial-product-intro__grid<?php echo $intro_image === '' ? ' fg-commercial-product-intro__grid--solo' : ''; ?>">
            <?php if ($intro_image !== '') : ?>
                <figure class="fg-commercial-product-intro__media">
                    <img src="<?php echo esc_url(fenster_generated_url($intro_image)); ?>" alt="<?php echo esc_attr($intro_alt); ?>" loading="lazy">
                </figure>
            <?php endif; ?>
            <div class="fg-commercial-product-intro__copy">
                <p class="eyebrow"><?php esc_html_e('Scope of works', 'fenster'); ?></p>
                <h2><?php echo esc_html($intro_heading); ?></h2>
                <?php
                /* Summary copy is curated in inc/commercial-product-data.php, not user
                   input, but it is still filtered. Links are allowed so a sector page can
                   point at the project or product page that proves the claim. */
                $summary_tags = ['a' => ['href' => [], 'title' => []], 'strong' => [], 'em' => []];
                ?>
                <?php foreach ($summary as $line) : ?>
                    <p><?php echo wp_kses((string) $line, $summary_tags); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ---------- Specification -------------------------------------------
             The audit's first finding, answered. `STYLE.md`: "Give them the
             number they have to put in a schedule."

             A pending row is RENDERED, not hidden. An estimator scanning for a
             wind-load standard and finding no row concludes we do not design to
             one; finding a row that says we are confirming it makes them ask.
             The sentinel and the owner's checklist both live in
             `fenster_commercial_spec_pending()`. */ ?>
    <?php if (! empty($specification)) : ?>
        <section class="fg-cm-spec" aria-labelledby="fg-cm-spec-title">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Specification', 'fenster'); ?></p>
                    <h2 id="fg-cm-spec-title"><?php echo esc_html($spec_heading); ?></h2>
                </div>
                <dl class="fg-cm-spec__grid">
                    <?php foreach ($specification as $row) :
                        $label = (string) ($row['label'] ?? '');
                        $value = $row['value'] ?? null;
                        $pending = function_exists('fenster_spec_is_pending') && fenster_spec_is_pending($value);

                        if ($label === '') {
                            continue;
                        }

                        /* A PENDING ROW IS NO LONGER RENDERED. Owner ruling,
                           2026-08-13: "drop the figure place until we have them."
                           This reverses the 2026-08-12 decision recorded in the
                           Commercial Specification Rule in `AI.md`, which had the
                           row render as "Confirming, ask and we will send it" on
                           the reasoning that an absent row reads as "we do not do
                           this". The owner's call is that a visible placeholder
                           on a page written for people who price work looks worse
                           than a shorter table.

                           THE ROW STAYS IN THE DATA ON PURPOSE. It is skipped
                           here, not deleted there, so `fenster_commercial_spec_
                           pending()` still generates the owner's outstanding
                           checklist and §6b of COMMERCIAL-AUDIT-2026-08-12.md
                           cannot drift from what the pages actually show. Fill
                           the sentinel in and the row reappears by itself. */
                        if ($pending) {
                            continue;
                        }
                        ?>
                        <div class="fg-cm-spec__row">
                            <dt><?php echo esc_html($label); ?></dt>
                            <dd><?php echo esc_html((string) $value); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <?php /* A route may override this note. Curtain walling does,
                         because it is specified across several systems and the
                         owner's instruction (2026-08-13) is that its figures are
                         "more of a guide than a source of truth". Saying so is
                         better than letting a specifier find out at tender. */
                       $spec_note = (string) ($product['spec_note'] ?? ''); ?>
                <p class="fg-cm-spec__note">
                    <?php if ($spec_note !== '') : ?>
                        <?php echo esc_html($spec_note); ?>
                    <?php else : ?>
                        <?php /* The second sentence used to read "Where a row is
                                 still being confirmed for this system, ask and we
                                 will send it to you in writing", which pointed at
                                 the pending rows. Those stopped rendering on the
                                 owner's ruling of 2026-08-13, leaving the clause
                                 referring to something no reader can see. The
                                 invitation is worth keeping, so it now covers
                                 anything the table does not answer. */
                              esc_html_e('Every figure published here is one we can stand behind. Ask us for anything the table does not cover and we will send it to you in writing.', 'fenster'); ?>
                    <?php endif; ?>
                </p>
            </div>
        </section>
    <?php endif; ?>

    <?php /* Louvre vents replaces the two generic middle bands with a bespoke
             section, 2026-08-11, the same shape the residential routes use: the
             hero, the intro, the settings strip, the related band and the
             enquiry are all still the shared ones. The capabilities grid and the
             alternating detail sections are what it stands in for, because on
             this route they described a service in the abstract while the page
             was about a product with published numbers.

             It renders no specification table either: its bespoke middle already
             carries the full range as a table, and a second one above it would
             state the same figures twice.

             Gated on the slug rather than on the presence of data, so the data
             the other routes rely on is untouched. */ ?>
    <?php if ($is_louvre) : ?>
        <?php get_template_part('template-parts/sections/louvre-vents-v2'); ?>
    <?php endif; ?>

    <?php if (! $is_louvre && ! empty($capabilities)) : ?>
        <section class="fg-commercial-product-checks">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Scope', 'fenster'); ?></p>
                    <h2><?php echo esc_html($capabilities_heading); ?></h2>
                </div>
                <div class="fg-commercial-product-checks__grid">
                    <?php foreach ($capabilities as $index => $capability) : ?>
                        <article>
                            <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <h3><?php echo esc_html((string) ($capability['title'] ?? '')); ?></h3>
                            <p><?php echo esc_html((string) ($capability['copy'] ?? '')); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! $is_louvre && ! empty($detail_sections)) : ?>
        <section class="fg-commercial-product-details">
            <div class="container">
                <?php foreach ($detail_sections as $index => $detail) :
                    $detail_image = (string) ($detail['image'] ?? '');
                    $detail_placeholder = (string) ($detail['placeholder'] ?? '');
                    ?>
                    <article class="fg-commercial-product-detail <?php echo $index % 2 === 1 ? 'fg-commercial-product-detail--flip' : ''; ?>">
                        <?php if ($detail_image !== '') : ?>
                            <figure>
                                <img src="<?php echo esc_url(fenster_generated_url($detail_image)); ?>" alt="<?php echo esc_attr((string) ($detail['alt'] ?? $title)); ?>" loading="lazy">
                            </figure>
                        <?php elseif ($detail_placeholder !== '') : ?>
                            <?php /* Marked placeholder. To a visitor a missing image and
                                     an image that failed to load are the same thing, and
                                     only one of them is honest. It also tells the next
                                     person what to shoot. See AI.md. */ ?>
                            <figure class="fg-lv-placeholder fg-cm-placeholder" aria-hidden="true">
                                <span><?php esc_html_e('Photograph to follow', 'fenster'); ?></span>
                                <small><?php echo esc_html($detail_placeholder); ?></small>
                            </figure>
                        <?php endif; ?>
                        <div>
                            <p class="eyebrow"><?php echo esc_html((string) ($detail['eyebrow'] ?? 'Commercial glazing')); ?></p>
                            <h2><?php echo esc_html((string) ($detail['title'] ?? '')); ?></h2>
                            <p><?php echo esc_html((string) ($detail['copy'] ?? '')); ?></p>
                            <?php if (! empty($detail['points']) && is_array($detail['points'])) : ?>
                                <ul>
                                    <?php foreach ($detail['points'] as $point) : ?>
                                        <li><?php echo esc_html((string) $point); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php /* ---------- Proof ------------------------------------------------------
             Real jobs that claim this route, and nothing where none do. The
             no-fallback helper is the whole safety mechanism here; see the
             header note before changing it to the single-product one. */ ?>
    <?php if (! empty($proof)) : ?>
        <section class="fg-cm-proof" aria-labelledby="fg-cm-proof-title">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Project proof', 'fenster'); ?></p>
                    <h2 id="fg-cm-proof-title"><?php echo esc_html($proof_heading); ?></h2>
                </div>
                <div class="fg-cm-proof__grid">
                    <?php foreach ($proof as $card) :
                        /* `image` is the study's card_image or its first image, and
                           it is an ARRAY of src/caption, not a string. Casting it
                           straight to string emitted an empty src and a PHP notice
                           on ten of the twelve routes; the harness caught it. */
                        $card_image = is_array($card['image'] ?? null) ? (string) ($card['image']['src'] ?? '') : '';
                        $card_alt = is_array($card['image'] ?? null) ? (string) ($card['image']['caption'] ?? '') : '';
                        ?>
                        <a class="fg-cm-proof__card" href="<?php echo esc_url((string) ($card['url'] ?? '#')); ?>">
                            <?php if ($card_image !== '') : ?>
                                <img src="<?php echo esc_url(fenster_generated_url($card_image)); ?>" alt="<?php echo esc_attr($card_alt !== '' ? $card_alt : (string) ($card['title'] ?? '')); ?>" loading="lazy">
                            <?php endif; ?>
                            <span class="fg-cm-proof__meta"><?php echo esc_html((string) ($card['location'] ?? 'Commercial project')); ?></span>
                            <strong><?php echo esc_html((string) ($card['title'] ?? '')); ?></strong>
                            <?php if (! empty($card['summary'])) : ?>
                                <small><?php echo esc_html((string) $card['summary']); ?></small>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-commercial-product-fit">
        <div class="container fg-commercial-product-fit__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Common settings', 'fenster'); ?></p>
                <h2><?php echo esc_html($use_cases_heading); ?></h2>
                <p><?php esc_html_e('Survey, access and the existing building decide the final route. These are the settings this work usually goes into.', 'fenster'); ?></p>
            </div>
            <?php if (! empty($use_cases)) : ?>
                <div class="fg-commercial-product-fit__tags">
                    <?php foreach ($use_cases as $use_case) : ?>
                        <span><?php echo esc_html((string) $use_case); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if (! empty($related_products)) : ?>
        <section class="fg-commercial-product-related">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Related commercial services', 'fenster'); ?></p>
                    <h2><?php echo esc_html($related_heading); ?></h2>
                </div>
                <div class="fg-commercial-product-related__grid">
                    <?php foreach ($related_products as $related_slug => $related) : ?>
                        <a href="<?php echo esc_url(home_url('/' . $related_slug . '/')); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url((string) ($related['hero_image'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($related['hero_alt'] ?? $related['title'] ?? 'Commercial glazing')); ?>" loading="lazy">
                            <span><?php echo esc_html((string) ($related['eyebrow'] ?? 'Commercial glazing')); ?></span>
                            <strong><?php echo esc_html((string) ($related['title'] ?? 'Commercial glazing')); ?></strong>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php /* FAQs sit between the related band and the credentials, so the last
             thing before the enquiry is still the proof. They are the answers a
             specifier would otherwise have to ask for, and every one of them
             restates something already published further up this page — see the
             note on `faqs` in `inc/commercial-product-data.php`.

             This is also the only FAQPage markup on the commercial set: until
             2026-08-15 thirteen routes carried none, while every residential
             product page had it. A route with no `faqs` key renders nothing at
             all, because the component returns early on an empty list. */ ?>
    <?php
    $commercial_faqs = is_array($product['faqs'] ?? null) ? $product['faqs'] : [];
    if (! empty($commercial_faqs)) {
        get_template_part('template-parts/components/faq-block', null, [
            'faqs' => $commercial_faqs,
            'eyebrow' => __('Common questions', 'fenster'),
            'heading' => sprintf(
                /* translators: %s: commercial product name, e.g. "Curtain walling". */
                __('%s, asked and answered.', 'fenster'),
                $title
            ),
            'id' => 'fg-cm-faq-title',
        ]);
    }
    ?>

    <?php /* Credentials sit immediately above the enquiry, per `STYLE.md`:
             reassurance next to the action should be compact and specific. Owner
             instruction 2026-08-12 is that they are visible on every commercial
             page, so this renders on all twelve. */ ?>
    <?php get_template_part('template-parts/components/commercial-credentials'); ?>

    <section class="fg-commercial-enquiry" id="commercial-product-enquiry">
        <div class="container fg-commercial-enquiry__grid">
            <div class="fg-commercial-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Commercial enquiry', 'fenster'); ?></p>
                <h2><?php echo esc_html($enquiry_heading); ?></h2>
                <p><?php esc_html_e('Drawings, a window schedule, elevations or site photographs are all useful, and none of them is required. A postcode and a description of the building is enough to get a sensible answer back.', 'fenster'); ?></p>
                <ul class="fg-commercial-enquiry__notes">
                    <li><?php esc_html_e('Phone lines are open 24/7.', 'fenster'); ?></li>
                    <li><?php esc_html_e('The office team picks up drawings and schedules during working hours.', 'fenster'); ?></li>
                    <li><a href="mailto:<?php echo esc_attr($commercial_email); ?>"><?php echo esc_html($commercial_email); ?></a></li>
                </ul>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-commercial-form',
                'source' => $title,
                'button_label' => 'Send commercial enquiry',
                'project_type' => 'Commercial glazing',
                'project_options' => [
                    'Commercial glazing',
                    'Commercial windows and doors',
                    'Curtain walling',
                    'Louvres or ventilation',
                    'Automatic doors and entrances',
                    'AOV smoke ventilation',
                    'Commercial replacement glazing',
                ],
                'show_company' => true,
                'lock_project_type' => true,
            ]);
            ?>
        </div>
    </section>
</article>
