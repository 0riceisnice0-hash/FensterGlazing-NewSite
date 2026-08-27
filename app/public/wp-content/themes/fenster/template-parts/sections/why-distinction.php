<?php
/**
 * `/why-distinction/` — why we fit this door and not another.
 *
 * WHY IT IS A PAGE OF ITS OWN. `/composite-doors/` has to sell the door and
 * take the enquiry; loading it with construction detail buries the range and the
 * quote tool. This carries the technical case at length.
 *
 * ---- 2026-08-27 overhaul -------------------------------------------------
 *
 * WHERE THE SPLIT BETWEEN THE TWO PAGES NOW SITS, because it was in the wrong
 * place. Both pages explained the slab as six layers, in the same order, in
 * different words, each presented as the definitive account.
 * **`/composite-doors/` owns the GRAPHIC** — the cutaway, six layers, seen.
 * **This page owns the ARGUMENT** — what each layer is for, where the figures
 * come from, what they do not cover, and the part that is a judgement. The slab
 * section below opens by handing off from the drawing and links back to it, so
 * a reader meets one account in two halves rather than two accounts.
 *
 * IT HAD NO IMAGES AT ALL. Four sections, 4,689px, zero photographs, with about
 * 700px of empty viewport beside every paragraph at 1440. It carries our own
 * work now: the Milton Keynes door open on its own edge in the hero, and the
 * showroom where the closing section invites somebody to come and close one.
 *
 * THREE EM DASHES WERE LIVE IN CUSTOMER COPY here, at what used to be lines 116
 * and 142. Both `STYLE.md` and `TONEOFVOICE.md` forbid them without exception.
 * The sentences were rewritten rather than hyphenated.
 *
 * BOTH SIX-ITEM GRIDS RAN FOUR ACROSS, so each left two cards beside a two-cell
 * hole. Three across divides exactly.
 *
 * ---- standing rules ------------------------------------------------------
 *
 * EVERY FACT HERE IS DISTINCTION'S AND IS ATTRIBUTED AS THEIRS. Their own "Why
 * Distinction" page is the source, and `TONEOFVOICE.md` uses a sentence off it —
 * "Our superior GRP doors have a high impact resistant skin with a beautiful
 * woodgrain finish" — as its worked example of what must never survive into
 * Fenster copy. So the facts are taken and every word is rewritten. Nothing here
 * is restated as a Fenster performance figure, the same rule the Kenrick,
 * Sheerline and Liniar numbers are held to.
 *
 * THE 50% IS THE ONE COMPARISON THIS SITE PUBLISHES, and it survives because it
 * names a CONSTRUCTION rather than a competitor: a 48mm solid-timber-core
 * composite door is a build several firms sell. It keeps its test conditions
 * attached. See the Supplier Naming Rule in `AI.md`.
 *
 * THE SPINE IS THE OWNER'S OWN REASON AND IT IS A JUDGMENT. `AI.md` records it:
 * he fits Distinction because it is the best-made composite door he has handled.
 * That is not a specification and this page does not dress it up as one — it
 * says so, and sends the reader to the showroom to test it.
 *
 * NO U-VALUE. A real one belongs to a complete doorset, and the composite FAQ
 * already explains why we will not print an invented figure.
 *
 * NO £5,000 GUARANTEE HERE. That is Fenster's break-in guarantee on the doorsets
 * we fit, not Distinction's, and it belongs on `/composite-doors/` where its
 * three lock components are named with it.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$fg_page = $args['page'] ?? [];

$fg_composite = home_url('/composite-doors/');
/* The cutaway, the range and the quiz, by the ids those sections already
   carry on their own headings. Anchored links rather than a bare route,
   because "back to the door page" is not a route anybody wants; the range
   and the quiz are. */
$fg_cutaway = $fg_composite . '#fg-cd3-anatomy-title';
$fg_range   = $fg_composite . '#fg-cds-title';
$fg_quiz    = $fg_composite . '#fg-cdq-title';

$fg_hero_stem = '/wp-content/themes/fenster/assets/images/products/composite-distinction/hero/fenster-mk-front-door-open-';

/* The slab, outside in. Distinction's six layers, in their order, described for
   somebody deciding rather than for a fabricator. This is the WHY for each
   layer; the WHAT and the WHERE are the cutaway on `/composite-doors/`. Keep
   them different or the two pages start competing again. */
$fg_layers = [
    [
        'name' => __('The skin', 'fenster'),
        'copy' => __('Glass reinforced plastic, moulded with a grain taken from real oak. It is the same family of material boat hulls are made from, which is why it takes a knock without denting the way an aluminium or a timber face does.', 'fenster'),
    ],
    [
        'name' => __('The edges', 'fenster'),
        'copy' => __('The rails around the slab are a water-resistant polymer rather than timber. Distinction use them because a timber-cored door can take up water at its edges over years and bow; a polymer rail has nothing to take up.', 'fenster'),
    ],
    [
        'name' => __('The engineered timber', 'fenster'),
        'copy' => __('Laminated veneer lumber inside the stiles, which is timber rebuilt in layers so it stays straight. It is what the hinges and the lock are screwed into, so it is the part that decides whether a door still shuts properly in ten years.', 'fenster'),
    ],
    [
        'name' => __('The reinforced board', 'fenster'),
        'copy' => __('A central board running through the slab. It is what makes the door feel solid rather than hollow when you close it, and it is the reason a Distinction slab is heavy to lift.', 'fenster'),
    ],
    [
        'name' => __('The core', 'fenster'),
        'copy' => __('High density insulating foam fills everything the structure does not. This is where the thermal figure below comes from.', 'fenster'),
    ],
    [
        'name' => __('The glass', 'fenster'),
        'copy' => __('Decorative units are triple glazed and laminated as standard, with the decorative layer sealed between two panes of clear glass. That is a maintenance point as much as a security one: the pattern is on the inside, so cleaning the door never touches it.', 'fenster'),
    ],
];

$fg_cards = [
    [
        'name' => __('Secured by Design', 'fenster'),
        'copy' => __('Distinction door slabs are accredited by Secured by Design, the police security initiative, having been tested by an independent UKAS-accredited body. That accreditation belongs to the slab; the locking on the doorsets we fit is ours and is on the composite doors page.', 'fenster'),
    ],
    [
        'name' => __('Sound', 'fenster'),
        'copy' => __('Distinction publish a weighted noise reduction of 31 decibels for the slab. If a busy road is the reason you are replacing the door, say so at the consultation, because the glass and the seals matter as much as the slab does.', 'fenster'),
    ],
    [
        'name' => __('Warranty', 'fenster'),
        'copy' => __('Distinction warrant the door structurally and its surface for 25 years. That is theirs and it covers the slab. The installation carries our own ten year insurance-backed guarantee, which is a different thing and covers different ground.', 'fenster'),
    ],
    [
        'name' => __('Looking after it', 'fenster'),
        /* No em dashes. This sentence carried two of the three that were live on
           this page; it is rewritten rather than hyphenated. */
        'copy' => __('Warm water and a soft cloth, and that is genuinely the whole routine. Do not paint one, because it voids the surface warranty, and skip anything abrasive, any solvent and the pressure washer.', 'fenster'),
    ],
    [
        'name' => __('How common they are', 'fenster'),
        'copy' => __('Distinction have been making these since 2004 and say more than four million have gone in, around one in four of the entrance doors fitted in the UK. Ordinary is worth something on a front door: parts are available and nobody has to work out how it comes apart.', 'fenster'),
    ],
    [
        'name' => __('Where it is made', 'fenster'),
        'copy' => __('The slabs are manufactured in the UK and the doorset is built to your opening, so a door is made after the survey rather than picked off a shelf and packed out to fit.', 'fenster'),
    ],
];
?>
<main id="main" class="site-main fg-wd-page">

    <section class="fg-wd-hero">
        <div class="container fg-wd-hero__grid">
            <div class="fg-wd-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Why Distinction', 'fenster'); ?></p>
                <h1><?php esc_html_e('Why we fit this door and not another.', 'fenster'); ?></h1>
                <p class="fg-wd-lead">
                    <?php esc_html_e('We fit Distinction composite doors on nearly every front door job we do. Some of that is specification and some of it is a judgement, and this page separates the two, because a page that pretends everything is a measurement is not worth reading.', 'fenster'); ?>
                </p>
                <p class="fg-wd-hero__actions">
                    <a class="button" href="<?php echo esc_url($fg_range); ?>"><?php esc_html_e('See the door range', 'fenster'); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </p>
            </div>
            <?php /* The same Milton Keynes door as the composite hero, open, so
                     the page that argues about the slab opens on the slab's own
                     edge. Ours, not a supplier render. */ ?>
            <figure class="fg-wd-hero__media">
                <img
                    src="<?php echo esc_url(fenster_generated_url($fg_hero_stem . '960w.webp')); ?>"
                    srcset="<?php echo esc_attr(implode(', ', [
                        fenster_generated_url($fg_hero_stem . '640w.webp') . ' 640w',
                        fenster_generated_url($fg_hero_stem . '960w.webp') . ' 960w',
                        fenster_generated_url($fg_hero_stem . '1280w.webp') . ' 1280w',
                    ])); ?>"
                    sizes="(max-width: 860px) 100vw, 42vw"
                    alt="An anthracite grey Distinction composite front door standing open, showing the edge of the slab, on a Milton Keynes house Fenster fitted"
                    loading="eager" fetchpriority="high" width="1152" height="1440">
                <figcaption><?php esc_html_e('A door we fitted in Milton Keynes, open on its own edge.', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <section class="fg-wd-slab" aria-labelledby="fg-wd-slab-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('What is in it', 'fenster'); ?></p>
                <h2 id="fg-wd-slab-title"><?php esc_html_e('A 44.5mm slab, built in six layers.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A uPVC door panel is around 28mm and mostly hollow. That difference is the whole argument for a composite door, and it is why one feels so unlike anything else the first time you close it.', 'fenster'); ?></p>
                <?php /* THE HANDOFF, STATED. The cutaway shows where the layers
                         sit; this page says what each one is for. Naming the
                         relationship is what stops the two pages reading as two
                         competing accounts of the same slab. */ ?>
                <p class="fg-wd-slab__handoff">
                    <?php esc_html_e('The cutaway on the composite doors page shows you where they sit.', 'fenster'); ?>
                    <a href="<?php echo esc_url($fg_cutaway); ?>"><?php esc_html_e('Open the slab drawing', 'fenster'); ?></a>
                    <?php esc_html_e('This is what each of them is doing.', 'fenster'); ?>
                </p>
            </header>
            <ol class="fg-wd-layers">
                <?php foreach ($fg_layers as $fg_i => $fg_layer) : ?>
                    <li class="fg-wd-layer">
                        <span class="fg-wd-layer__num"><?php echo esc_html(sprintf('%02d', $fg_i + 1)); ?></span>
                        <h3><?php echo esc_html($fg_layer['name']); ?></h3>
                        <p><?php echo esc_html($fg_layer['copy']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <?php
    /* THE FIGURE, ANCHORED. It was 600px of left-aligned prose with about 700px
       of empty viewport beside it, and `50%` floated as the largest green
       display type on the site with nothing holding it. The number and its
       claim sit on one side; what it does not cover sits on the other, which is
       the shape the argument actually has. */
    ?>
    <section class="fg-wd-figure" aria-labelledby="fg-wd-figure-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('The one number', 'fenster'); ?></p>
                <h2 id="fg-wd-figure-title"><?php esc_html_e('The one number worth quoting, with its conditions attached.', 'fenster'); ?></h2>
            </header>
            <div class="fg-wd-figure__grid">
                <div class="fg-wd-figure__claim">
                    <p class="fg-wd-stat"><span>50%</span> <?php esc_html_e('more thermally efficient', 'fenster'); ?></p>
                    <p>
                        <?php esc_html_e('Distinction had their 44.5mm slab independently tested against a 48mm solid-timber-core composite door and a 44mm timber panelled door, and it came out 50% more thermally efficient than both. The testing was at the University of Salford\'s Energy House.', 'fenster'); ?>
                    </p>
                </div>
                <div class="fg-wd-figure__caveats">
                    <h3><?php esc_html_e('What it does not tell you.', 'fenster'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('It is Distinction\'s test rather than ours, and it measures the slab rather than a finished doorset. Your frame, your glass, your threshold and how well the thing is fitted all move the real answer.', 'fenster'); ?></li>
                        <li><?php esc_html_e('It is a thermal comparison only. It says nothing about security, and nothing about how a timber core handles an impact, where a solid timber door may well have its own case.', 'fenster'); ?></li>
                        <li><?php esc_html_e('It is also why you will not find a U-value on our composite door pages. A real one belongs to a complete doorset, and we would rather publish nothing than a number invented before your door is specified.', 'fenster'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-wd-cards" aria-labelledby="fg-wd-cards-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('The rest of it', 'fenster'); ?></p>
                <h2 id="fg-wd-cards-title"><?php esc_html_e('The rest of it, briefly.', 'fenster'); ?></h2>
            </header>
            <div class="fg-wd-grid">
                <?php foreach ($fg_cards as $fg_card) : ?>
                    <article class="fg-wd-card">
                        <h3><?php echo esc_html($fg_card['name']); ?></h3>
                        <p><?php echo esc_html($fg_card['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-wd-judgement" aria-labelledby="fg-wd-judgement-title">
        <div class="container fg-wd-judgement__grid">
            <div class="fg-wd-judgement__words">
                <p class="eyebrow"><?php esc_html_e('Not a specification', 'fenster'); ?></p>
                <h2 id="fg-wd-judgement-title"><?php esc_html_e('And the part that is not a specification.', 'fenster'); ?></h2>
                <p>
                    <?php esc_html_e('Every figure above is Distinction\'s and every one of them is checkable. The actual reason we fit their doors is not on that list: it is the best-made composite door we have handled, and after enough years of hanging them you can tell. That is a judgement, not a measurement, and we are not going to pretend otherwise by finding a number to stand behind it.', 'fenster'); ?>
                </p>
                <p>
                    <?php esc_html_e('The way to test a claim like that is to close one. There are doors in the Milton Keynes showroom and you are welcome to come and be unconvinced.', 'fenster'); ?>
                </p>
                <p class="fg-wd-judgement__actions">
                    <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Visit the showroom', 'fenster'); ?></a>
                    <a class="button button--steel" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                </p>
            </div>
            <figure class="fg-wd-judgement__media">
                <img
                    src="<?php echo esc_url(fenster_generated_url('/wp-content/themes/fenster/assets/images/contact/contact-hub-showroom.webp')); ?>"
                    alt="The Fenster Glazing showroom in Milton Keynes, its window signage listing composite doors"
                    loading="lazy" decoding="async" width="1200" height="800">
                <figcaption><?php esc_html_e('The showroom on Tanners Drive, Blakelands.', 'fenster'); ?></figcaption>
            </figure>
        </div>
    </section>

    <?php
    /* THE RETURN ROUTES, NAMED. This page used to end with two buttons pointing
       at the top of `/composite-doors/`, which is not a thing anybody wants to
       go back to. The range and the quiz are. */
    ?>
    <section class="fg-wd-next" aria-labelledby="fg-wd-next-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('Where to go next', 'fenster'); ?></p>
                <h2 id="fg-wd-next-title"><?php esc_html_e('If that settles it, pick a door.', 'fenster'); ?></h2>
            </header>
            <div class="fg-wd-next__grid">
                <a class="fg-wd-next__card" href="<?php echo esc_url($fg_range); ?>">
                    <strong><?php esc_html_e('The full range', 'fenster'); ?></strong>
                    <span><?php esc_html_e('All 142 doors we can price, drawn to scale. Click one and the quote tool opens on it.', 'fenster'); ?></span>
                </a>
                <a class="fg-wd-next__card" href="<?php echo esc_url($fg_quiz); ?>">
                    <strong><?php esc_html_e('Five questions instead', 'fenster'); ?></strong>
                    <span><?php esc_html_e('If 142 is too many to look at cold, answer five questions about your house and we will point at one.', 'fenster'); ?></span>
                </a>
                <a class="fg-wd-next__card" href="<?php echo esc_url($fg_cutaway); ?>">
                    <strong><?php esc_html_e('The slab, cut open', 'fenster'); ?></strong>
                    <span><?php esc_html_e('The drawing this page keeps referring to, with every layer where it actually sits.', 'fenster'); ?></span>
                </a>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/components/enquiry-form', null, [
        'title'        => __('Ask us anything about the door.', 'fenster'),
        'project_type' => 'Composite doors',
        'source'       => 'Why Distinction',
    ]); ?>
</main>
