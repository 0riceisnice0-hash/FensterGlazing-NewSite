<?php
/**
 * `/why-distinction/` — why we fit this door and not another.
 *
 * WHY IT IS A PAGE OF ITS OWN. `/composite-doors/` has to sell the door and
 * take the enquiry; loading it with construction detail buries the range and the
 * quote tool. This carries the technical case at length.
 *
 * ---- 2026-08-27, third pass: "good and looking nice with good info and images"
 *
 * THE SLAB IS DRAWN HERE NOW, WITH THIS PAGE'S OWN WORDS BESIDE IT. The section
 * was six white text cards under a link that said "open the slab drawing" on
 * another page — a page titled "what is in the slab" with no picture of the
 * slab. The cutaway component from `/composite-doors/` renders here with THIS
 * page's six layers passed in, so it is one drawing and two sets of words: the
 * composite page says what each layer is and where it sits, this page says what
 * each one is for. That is the split the earlier pass described and then failed
 * to picture. The component gained overridable head copy for it.
 *
 * SIX PARAGRAPHS BECAME A STAT BAND. "The rest of it, briefly" was six equal
 * white cards of prose. Five of the six facts in them are numbers — 25 years,
 * 31 dB, four million, one in four, UK made — and the sixth is a badge. Numbers
 * are read as a band and skipped as paragraphs. Every figure is still
 * Distinction's and still attributed as theirs in the line beneath it.
 *
 * THE HERO IS THE DOOR AS AN OBJECT, not a fitter beside a van. The install
 * photograph was honest and it was also dust sheets, a Trustpilot livery and a
 * doorset on its back. This page argues that the door is well made, so the hero
 * is `gallery/pale-blue-glass-detail`: the slab, the grain, the leaded glass
 * and the brass, close and lit. Full bleed, the same grammar as the composite
 * hero, so the two pages read as siblings.
 *
 * THE ENQUIRY FORM WAS RENDERING WHITE LABELS ON A PALE GROUND. The component's
 * label colour is built for the dark `.fg-enquiry` panel every product page
 * wraps it in, and this page had called it bare. It sits in that panel now,
 * which also gives the page a closing dark moment the composite page has and
 * this one did not.
 *
 * ---- earlier passes, still true ------------------------------------------
 *
 * IT HAD NO IMAGES AT ALL before 2026-08-27: four sections, 4,689px, zero
 * photographs, about 700px of empty viewport beside every paragraph at 1440.
 *
 * THREE EM DASHES WERE LIVE IN CUSTOMER COPY here. Both `STYLE.md` and
 * `TONEOFVOICE.md` forbid them without exception. Rewritten, not hyphenated.
 *
 * ---- standing rules ------------------------------------------------------
 *
 * EVERY FACT HERE IS DISTINCTION'S AND IS ATTRIBUTED AS THEIRS. Their own "Why
 * Distinction" page is the source, and `TONEOFVOICE.md` uses a sentence off it
 * as its worked example of what must never survive into Fenster copy. So the
 * facts are taken and every word is rewritten. Nothing here is restated as a
 * Fenster performance figure, the same rule the Kenrick, Sheerline and Liniar
 * numbers are held to.
 *
 * THE 50% IS THE ONE COMPARISON THIS SITE PUBLISHES, and it survives because it
 * names a CONSTRUCTION rather than a competitor: a 48mm solid-timber-core
 * composite door is a build several firms sell. It keeps its test conditions
 * attached. See the Supplier Naming Rule in `AI.md`.
 *
 * THE SPINE IS THE OWNER'S OWN REASON AND IT IS A JUDGMENT. `AI.md` records it:
 * he fits Distinction because it is the best-made composite door he has handled.
 * That is not a specification and this page does not dress it up as one. It
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
/* The range and the quiz, by the ids those sections carry on their own
   headings. Anchored links rather than a bare route, because "back to the
   door page" is not a route anybody wants; the range and the quiz are. */
$fg_range = $fg_composite . '#fg-cds-title';
$fg_quiz  = $fg_composite . '#fg-cdq-title';

$fg_hero_stem = '/wp-content/themes/fenster/assets/images/products/composite-distinction/gallery/pale-blue-glass-detail-';

/* The slab, outside in. Distinction's six layers, in their order, described for
   somebody deciding rather than for a fabricator. This is the WHY for each
   layer; the WHAT and the WHERE are the drawing beside them. The order is
   load-bearing: the cutaway's highlights and chips are keyed to it. */
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

/* The rest of it, as figures. Each is Distinction's and the line under it says
   so; the one that is not a number is the accreditation. */
$fg_figures = [
    [
        'figure' => __('25 years', 'fenster'),
        'label'  => __('Warranty on the slab', 'fenster'),
        'copy'   => __('Distinction warrant the door structurally and its surface for 25 years. That covers the slab. Our installation carries its own ten year insurance-backed guarantee, which is a different thing and covers different ground.', 'fenster'),
    ],
    [
        'figure' => __('31 dB', 'fenster'),
        'label'  => __('Weighted noise reduction', 'fenster'),
        'copy'   => __('The figure Distinction publish for the slab. If a busy road is the reason you are replacing the door, say so at the consultation, because the glass and the seals matter as much as the slab does.', 'fenster'),
    ],
    [
        'figure' => __('4 million', 'fenster'),
        'label'  => __('Fitted since 2004', 'fenster'),
        'copy'   => __('By Distinction\'s own count. Ordinary is worth something on a front door: parts are available, and nobody has to work out how it comes apart.', 'fenster'),
    ],
    [
        'figure' => __('1 in 4', 'fenster'),
        'label'  => __('UK entrance doors', 'fenster'),
        'copy'   => __('Their share of the front doors fitted in the UK, by their figure. It is why the name is on the page rather than hidden: a customer meets it anyway.', 'fenster'),
    ],
    [
        'figure' => __('SBD', 'fenster'),
        'label'  => __('Secured by Design', 'fenster'),
        'copy'   => __('The slab is accredited by the police security initiative, tested by an independent UKAS-accredited body. That belongs to the slab; the locking on the doorsets we fit is ours, and is on the composite doors page.', 'fenster'),
    ],
    [
        'figure' => __('UK', 'fenster'),
        'label'  => __('Where it is made', 'fenster'),
        'copy'   => __('The slabs are manufactured in the UK and the doorset is built to your opening, so a door is made after the survey rather than picked off a shelf and packed out to fit.', 'fenster'),
    ],
];

$fg_phone = '01908 429200';
?>
<main id="main" class="site-main fg-wd-page">

    <section class="fg-wd-hero fg-wd-hero--bleed">
        <div class="fg-wd-hero__media" aria-hidden="true">
            <img
                src="<?php echo esc_url(fenster_generated_url($fg_hero_stem . '1400w.webp')); ?>"
                srcset="<?php echo esc_attr(implode(', ', [
                    fenster_generated_url($fg_hero_stem . '480w.webp') . ' 480w',
                    fenster_generated_url($fg_hero_stem . '800w.webp') . ' 800w',
                    fenster_generated_url($fg_hero_stem . '1400w.webp') . ' 1400w',
                ])); ?>"
                sizes="100vw"
                alt=""
                loading="eager" fetchpriority="high" width="1400" height="593">
            <span class="fg-wd-hero__scrim"></span>
        </div>
        <div class="container fg-wd-hero__inner">
            <div class="fg-wd-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Why Distinction', 'fenster'); ?></p>
                <h1><?php esc_html_e('Why we fit this door and not another.', 'fenster'); ?></h1>
                <p class="fg-wd-lead">
                    <?php esc_html_e('We fit Distinction composite doors on nearly every front door job we do. Some of that is specification and some of it is a judgement, and this page separates the two, because a page that pretends everything is a measurement is not worth reading.', 'fenster'); ?>
                </p>
                <p class="fg-wd-hero__actions">
                    <a class="button" href="<?php echo esc_url($fg_range); ?>"><?php esc_html_e('See the door range', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
                </p>
            </div>
        </div>
    </section>

    <?php
    /* THE SLAB, DRAWN, WITH THIS PAGE'S REASONS BESIDE IT. One drawing, two sets
       of words: the composite page says what and where, this says what for. */
    get_template_part('template-parts/components/composite-anatomy', null, [
        'anatomy' => [
            'layers'    => $fg_layers,
            'image_alt' => __('Cutaway drawing of a Distinction composite door slab, showing the GRP skin, the polymer edge, the engineered timber, the reinforced board, the foam core and the glazed unit', 'fenster'),
        ],
        'eyebrow' => __('What is in it', 'fenster'),
        'title'   => __('A 44.5mm slab, built in six layers.', 'fenster'),
        'lede'    => __('A uPVC door panel is around 28mm and mostly hollow. That difference is the whole argument for a composite door. Open a layer and the drawing shows where it sits; the words say what it is there for.', 'fenster'),
    ]);
    ?>

    <?php
    /* THE FIGURE, ANCHORED. The number and its claim sit on one side; what it
       does not cover sits on the other, which is the shape the argument
       actually has. */
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

    <?php
    /* THE REST OF IT, AS A BAND OF FIGURES. Six paragraphs in six white cards
       became six numbers with a line each. Same facts, same attribution, read
       in a glance rather than skipped. */
    ?>
    <section class="fg-wd-figures" aria-labelledby="fg-wd-figures-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('The rest of it', 'fenster'); ?></p>
                <h2 id="fg-wd-figures-title"><?php esc_html_e('The rest of it, in figures.', 'fenster'); ?></h2>
                <p><?php esc_html_e('All Distinction\'s numbers, and each one says so. None of them is the reason we fit the door; that is further down.', 'fenster'); ?></p>
            </header>
            <dl class="fg-wd-band">
                <?php foreach ($fg_figures as $fg_f) : ?>
                    <div class="fg-wd-band__cell">
                        <dt>
                            <span class="fg-wd-band__figure"><?php echo esc_html($fg_f['figure']); ?></span>
                            <span class="fg-wd-band__label"><?php echo esc_html($fg_f['label']); ?></span>
                        </dt>
                        <dd><?php echo esc_html($fg_f['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <p class="fg-wd-figures__care">
                <?php esc_html_e('Looking after it is warm water and a soft cloth, and that is genuinely the whole routine. Do not paint one, because it voids the surface warranty, and skip anything abrasive, any solvent and the pressure washer.', 'fenster'); ?>
            </p>
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
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $fg_phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $fg_phone)); ?></a>
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
    /* THE RETURN ROUTES, NAMED. Two now rather than three: the drawing this
       used to point at is on this page. */
    ?>
    <section class="fg-wd-next" aria-labelledby="fg-wd-next-title">
        <div class="container">
            <header class="fg-chapter-head">
                <p class="eyebrow"><?php esc_html_e('Where to go next', 'fenster'); ?></p>
                <h2 id="fg-wd-next-title"><?php esc_html_e('If that settles it, pick a door.', 'fenster'); ?></h2>
            </header>
            <div class="fg-wd-next__grid fg-wd-next__grid--two">
                <a class="fg-wd-next__card" href="<?php echo esc_url($fg_range); ?>">
                    <strong><?php esc_html_e('The full range', 'fenster'); ?></strong>
                    <span><?php esc_html_e('All 142 doors we can price, drawn to scale and filterable by how much glass you want. Click one and the quote tool opens on it.', 'fenster'); ?></span>
                </a>
                <a class="fg-wd-next__card" href="<?php echo esc_url($fg_quiz); ?>">
                    <strong><?php esc_html_e('Five questions instead', 'fenster'); ?></strong>
                    <span><?php esc_html_e('If 142 is too many to look at cold, answer five questions about your house and we will point at one, in the colour you chose.', 'fenster'); ?></span>
                </a>
            </div>
        </div>
    </section>

    <?php
    /* THE FORM, IN THE PANEL IT WAS DESIGNED FOR. This mirrors the product
       page's closing section exactly, so the labels have the dark ground
       their colour assumes. */
    ?>
    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Start your project', 'fenster'); ?></p>
                <h2><?php esc_html_e('Ask us anything about the door.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Send the basics and we will come back with straight answers: which style suits the house, what the glass does to the price, and when we can survey.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $fg_phone)); ?>"><?php echo esc_html($fg_phone); ?></a>
                    <a href="mailto:info@fensterglazing.com">info@fensterglazing.com</a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class'             => 'fg-form',
                'source'            => 'Why Distinction',
                'button_label'      => 'Send my project details',
                'project_type'      => 'Composite doors',
                'lock_project_type' => true,
                'compact'           => true,
            ]);
            ?>
        </div>
    </section>
</main>
