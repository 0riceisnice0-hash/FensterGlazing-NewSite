<?php
/**
 * `/why-distinction/` — why we fit this door and not another.
 *
 * WHY IT IS A PAGE OF ITS OWN. `/composite-doors/` has to sell the door and
 * take the enquiry; loading it with construction detail buries the range and the
 * quote tool. This carries the technical case at length, and the composite page
 * links to it with one CTA.
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

/* The slab, outside in. Distinction's six layers, in their order, described for
   somebody deciding rather than for a fabricator. */
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
?>
<main id="main" class="site-main fg-wd-page">

    <section class="fg-wd-hero">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e('Why Distinction', 'fenster'); ?></p>
            <h1><?php esc_html_e('Why we fit this door and not another.', 'fenster'); ?></h1>
            <p class="fg-wd-lead">
                <?php esc_html_e('We fit Distinction composite doors on nearly every front door job we do. Some of that is specification and some of it is a judgement, and this page separates the two, because a page that pretends everything is a measurement is not worth reading.', 'fenster'); ?>
            </p>
            <p class="fg-wd-hero__actions">
                <a class="button" href="<?php echo esc_url(home_url('/composite-doors/')); ?>"><?php esc_html_e('See the door range', 'fenster'); ?></a>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <section class="fg-wd-slab" aria-labelledby="fg-wd-slab-title">
        <div class="container">
            <header class="fg-cd3-head fg-cd3-head--wide">
                <p class="eyebrow"><?php esc_html_e('What is in it', 'fenster'); ?></p>
                <h2 id="fg-wd-slab-title"><?php esc_html_e('A 44.5mm slab, built in six layers.', 'fenster'); ?></h2>
                <p><?php esc_html_e('A uPVC door panel is around 28mm and mostly hollow. That difference is the whole argument for a composite door, and it is why one feels so unlike anything else the first time you close it.', 'fenster'); ?></p>
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

    <section class="fg-wd-figure" aria-labelledby="fg-wd-figure-title">
        <div class="container">
            <h2 id="fg-wd-figure-title"><?php esc_html_e('The one number worth quoting, with its conditions attached.', 'fenster'); ?></h2>
            <p class="fg-wd-stat"><span>50%</span> <?php esc_html_e('more thermally efficient', 'fenster'); ?></p>
            <p>
                <?php esc_html_e('Distinction had their 44.5mm slab independently tested against a 48mm solid-timber-core composite door and a 44mm timber panelled door, and it came out 50% more thermally efficient than both. The testing was at the University of Salford\'s Energy House.', 'fenster'); ?>
            </p>
            <p>
                <?php esc_html_e('Two things about that figure. It is Distinction\'s test, not ours, and it measures the slab rather than a finished doorset — your frame, glass, threshold and how well it is fitted all move the real answer. And it is a thermal comparison only: it says nothing about security or about how a timber core handles an impact, where a solid timber door may well have its own case.', 'fenster'); ?>
            </p>
            <p>
                <?php esc_html_e('It is also why you will not find a U-value on our composite door pages. A real one belongs to a complete doorset, and we would rather publish nothing than a number invented before your door is specified.', 'fenster'); ?>
            </p>
        </div>
    </section>

    <section class="fg-wd-cards" aria-labelledby="fg-wd-cards-title">
        <div class="container">
            <h2 id="fg-wd-cards-title"><?php esc_html_e('The rest of it, briefly.', 'fenster'); ?></h2>
            <div class="fg-wd-grid">
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('Secured by Design', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Distinction door slabs are accredited by Secured by Design, the police security initiative, having been tested by an independent UKAS-accredited body. That accreditation belongs to the slab; the locking on the doorsets we fit is ours and is on the composite doors page.', 'fenster'); ?></p>
                </article>
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('Sound', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Distinction publish a weighted noise reduction of 31 decibels for the slab. If a busy road is the reason you are replacing the door, say so at the consultation, because the glass and the seals matter as much as the slab does.', 'fenster'); ?></p>
                </article>
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('Warranty', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Distinction warrant the door structurally and its surface for 25 years. That is theirs and it covers the slab. The installation carries our own ten year insurance-backed guarantee, which is a different thing and covers different ground.', 'fenster'); ?></p>
                </article>
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('Looking after it', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Warm water and a soft cloth, and that is genuinely the whole routine. Do not paint one — it voids the surface warranty — and skip anything abrasive, any solvent and the pressure washer.', 'fenster'); ?></p>
                </article>
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('How common they are', 'fenster'); ?></h3>
                    <p><?php esc_html_e('Distinction have been making these since 2004 and say more than four million have gone in, around one in four of the entrance doors fitted in the UK. Ordinary is worth something on a front door: parts are available and nobody has to work out how it comes apart.', 'fenster'); ?></p>
                </article>
                <article class="fg-wd-card">
                    <h3><?php esc_html_e('Where it is made', 'fenster'); ?></h3>
                    <p><?php esc_html_e('The slabs are manufactured in the UK and the doorset is built to your opening, so a door is made after the survey rather than picked off a shelf and packed out to fit.', 'fenster'); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="fg-wd-judgement" aria-labelledby="fg-wd-judgement-title">
        <div class="container">
            <h2 id="fg-wd-judgement-title"><?php esc_html_e('And the part that is not a specification.', 'fenster'); ?></h2>
            <p>
                <?php esc_html_e('Every figure above is Distinction\'s and every one of them is checkable. The actual reason we fit their doors is not on that list: it is the best-made composite door we have handled, and after enough years of hanging them you can tell. That is a judgement, not a measurement, and we are not going to pretend otherwise by finding a number to stand behind it.', 'fenster'); ?>
            </p>
            <p>
                <?php esc_html_e('The way to test a claim like that is to close one. There are doors in the Milton Keynes showroom and you are welcome to come and be unconvinced.', 'fenster'); ?>
            </p>
            <p class="fg-wd-judgement__actions">
                <a class="button" href="<?php echo esc_url(home_url('/composite-doors/')); ?>"><?php esc_html_e('See the door range', 'fenster'); ?></a>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Visit the showroom', 'fenster'); ?></a>
            </p>
        </div>
    </section>

    <?php get_template_part('template-parts/components/enquiry-form', null, [
        'title'        => __('Ask us anything about the door.', 'fenster'),
        'project_type' => 'Composite doors',
        'source'       => 'Why Distinction',
    ]); ?>
</main>
