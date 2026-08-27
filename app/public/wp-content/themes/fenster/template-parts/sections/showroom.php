<?php
/**
 * Window and door showroom.
 *
 * The page is COMPLETE WITHOUT JAVASCRIPT. Every product's name, positioning
 * line, description and four specification figures are in the served HTML;
 * every one links to its own product route; the poster image is a real `<img>`
 * with intrinsic dimensions. Turn the viewer off entirely and this is still a
 * page that ranks and converts.
 *
 * That is the opposite of how the earlier 3D page was built, and the audit is
 * the reason: it rendered 170 crawlable words and put its call-to-action behind
 * six scroll steps. Here the specification panel carries all nine products at
 * once — one visible, the rest hidden but present — so a crawler reads the
 * whole range and the switcher is only ever changing which is on screen.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], ['group' => 'windows']);
$group = $args['group'] === 'doors' ? 'doors' : 'windows';

$page = fenster_showroom_page($group);
$hub = fenster_data('product_hub_groups.' . $group, []);
$hub = is_array($hub) ? $hub : [];
$products = fenster_showroom_products($group);
$poster = fenster_showroom_poster_size();

if ($products === []) {
    return;
}

// The default product is the first one with a model — the one the poster shows.
$default = null;
foreach ($products as $p) {
    if (! empty($p['model'])) { $default = $p; break; }
}
if ($default === null) { $default = $products[0]; }

$modelled = array_values(array_filter($products, static fn ($p) => ! empty($p['model'])));
$photo_only = array_values(array_filter($products, static fn ($p) => empty($p['model'])));

$brand = fenster_data('brand', []);
$phone = (string) ($brand['phone'] ?? '01908 429200');
$quote_url = home_url('/instant-quote/');
$decision_columns = is_array($hub['decision_columns'] ?? null) ? $hub['decision_columns'] : [];
$faqs = is_array($hub['faqs'] ?? null) ? $hub['faqs'] : [];
$finishes = fenster_showroom_finishes($group);
?>

<section class="fg-sr" data-showroom="<?php echo esc_attr($group); ?>">

    <header class="fg-sr__hero">
        <div class="fg-sr__hero-inner">
            <p class="fg-sr__eyebrow"><?php echo esc_html($page['eyebrow']); ?></p>
            <h1 class="fg-sr__h1"><?php echo esc_html($page['h1']); ?></h1>
            <p class="fg-sr__standfirst"><?php echo esc_html($page['standfirst']); ?></p>
            <p class="fg-sr__hero-links">
                <a href="<?php echo esc_url($page['hub']['url']); ?>"><?php echo esc_html($page['hub']['label']); ?></a>
                <span aria-hidden="true">·</span>
                <a href="<?php echo esc_url($page['other']['url']); ?>"><?php echo esc_html($page['other']['label']); ?></a>
            </p>
        </div>
    </header>

    <div class="fg-sr__stage">

        <?php /* THE VIEWER SHELL. The poster is the LCP element and it carries
                 width and height attributes so the box is reserved before the
                 image arrives — that is what keeps CLS at zero when the canvas
                 later takes the same box. */ ?>
        <div class="fg-sr__viewer" data-sr-viewer
             data-model-base="<?php echo esc_url(FENSTER_THEME_URI . '/assets/showroom/models/'); ?>">
            <div class="fg-sr__frame" style="aspect-ratio: <?php echo (int) $poster['width']; ?> / <?php echo (int) $poster['height']; ?>">
                <?php foreach ($modelled as $i => $p) : ?>
                    <img class="fg-sr__poster<?php echo $i === 0 ? ' is-current' : ''; ?>"
                         src="<?php echo esc_url($p['poster']); ?>"
                         alt="<?php echo esc_attr(sprintf(__('%s, shown in 3D', 'fenster'), $p['name'])); ?>"
                         width="<?php echo (int) $poster['width']; ?>"
                         height="<?php echo (int) $poster['height']; ?>"
                         data-sr-poster="<?php echo esc_attr($p['model']['id']); ?>"
                         <?php echo $i === 0 ? 'fetchpriority="high"' : 'loading="lazy" decoding="async"'; ?>>
                <?php endforeach; ?>
                <canvas class="fg-sr__canvas" data-sr-canvas aria-hidden="true"></canvas>
                <div class="fg-sr__loading" data-sr-loading hidden>
                    <span class="fg-sr__loading-bar"><i data-sr-progress></i></span>
                    <span class="fg-sr__loading-text" data-sr-loading-text><?php esc_html_e('Loading the model', 'fenster'); ?></span>
                </div>
            </div>

            <?php /* The upgrade button. Present in the HTML but only revealed
                     once the script confirms WebGL — a button that promises 3D
                     on a machine that cannot draw it is worse than no button. */ ?>
            <div class="fg-sr__viewer-bar">
                <button type="button" class="fg-sr__enter" data-sr-enter hidden>
                    <?php esc_html_e('View in 3D', 'fenster'); ?>
                </button>
                <div class="fg-sr__tools" data-sr-tools hidden>
                    <button type="button" class="fg-sr__tool" data-sr-open aria-pressed="false">
                        <?php esc_html_e('Open it', 'fenster'); ?>
                    </button>
                    <button type="button" class="fg-sr__tool" data-sr-reset>
                        <?php esc_html_e('Reset', 'fenster'); ?>
                    </button>
                    <span class="fg-sr__hint" data-sr-hint><?php esc_html_e('Drag to turn', 'fenster'); ?></span>
                </div>
            </div>

            <?php /* THE FINISH SWITCHER.
                     Costs nothing to run: there are no textures in any of these
                     models, so a finish is a baseColorFactor change and not a
                     download. The optimiser leaves exactly one material named
                     `fenster:frame` per product, which is what makes it one
                     assignment rather than a hunt through forty.

                     Hidden until the viewer is live, because without 3D there
                     is nothing to recolour — the swatches would be decoration. */ ?>
            <?php foreach ($finishes as $mat_key => $set) :
                if (empty($set['colours'])) { continue; } ?>
                <div class="fg-sr__finishes" data-sr-finishes="<?php echo esc_attr($mat_key); ?>" hidden>
                    <p class="fg-sr__finishes-label">
                        <?php echo esc_html($set['label']); ?>
                        <span><?php echo esc_html($set['note']); ?></span>
                    </p>
                    <ul class="fg-sr__swatches">
                        <?php foreach ($set['colours'] as $ci => $c) : ?>
                            <li>
                                <button type="button" class="fg-sr__swatch"
                                        data-sr-finish="<?php echo esc_attr($c['hex']); ?>"
                                        aria-pressed="<?php echo $ci === 0 ? 'true' : 'false'; ?>">
                                    <span class="fg-sr__chip" style="--chip: <?php echo esc_attr($c['hex']); ?>"></span>
                                    <span class="fg-sr__swatch-name"><?php echo esc_html($c['name']); ?></span>
                                    <?php if ($c['finish'] !== '') : ?>
                                        <span class="fg-sr__swatch-ref"><?php echo esc_html($c['finish']); ?></span>
                                    <?php endif; ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="fg-sr__finishes-more">
                        <a href="<?php echo esc_url(home_url('/colour-options/')); ?>"><?php esc_html_e('Every colour we offer', 'fenster'); ?></a>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php /* THE SPECIFICATION PANEL. Every product is here, in the markup,
                 all the time. Only one is visible; the rest are hidden with
                 `hidden` rather than removed, so the served HTML carries the
                 whole range and switching product is a class change. */ ?>
        <aside class="fg-sr__panel" aria-label="<?php esc_attr_e('Product specification', 'fenster'); ?>">
            <?php foreach ($products as $i => $p) : ?>
                <article class="fg-sr__spec" data-sr-spec="<?php echo esc_attr($p['slug']); ?>"
                         <?php echo $p['slug'] === $default['slug'] ? '' : 'hidden'; ?>>
                    <p class="fg-sr__spec-fit"><?php echo esc_html($p['fit']); ?></p>
                    <h2 class="fg-sr__spec-name"><?php echo esc_html($p['name']); ?></h2>
                    <p class="fg-sr__spec-copy"><?php echo esc_html($p['copy']); ?></p>

                    <?php if (! empty($p['usps'])) : ?>
                        <dl class="fg-sr__figures">
                            <?php foreach ($p['usps'] as $u) : ?>
                                <div class="fg-sr__figure">
                                    <dt><?php echo esc_html((string) ($u['label'] ?? '')); ?></dt>
                                    <dd><?php echo esc_html((string) ($u['value'] ?? '')); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>

                    <div class="fg-sr__spec-actions">
                        <a class="fg-sr__btn fg-sr__btn--primary" href="<?php echo esc_url($quote_url); ?>">
                            <?php esc_html_e('Get an instant price', 'fenster'); ?>
                        </a>
                        <a class="fg-sr__btn" href="<?php echo esc_url($p['url']); ?>">
                            <?php printf(esc_html__('All about %s', 'fenster'), esc_html(strtolower($p['name']))); ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </aside>
    </div>

    <?php /* THE RAIL. Modelled products switch the viewer; the rest are links
             to their own page. A photography card is not a broken 3D card —
             same size, same type, different affordance, and it says which it
             is. Eleven of the eighteen range products have a model and there is
             a standing rule against dressing one product's geometry up as
             another's to hide that. */ ?>
    <nav class="fg-sr__rail" aria-label="<?php esc_attr_e('Choose a product', 'fenster'); ?>">
        <h2 class="fg-sr__rail-heading">
            <?php printf(esc_html__('The %s we fit', 'fenster'), esc_html($page['nouns'])); ?>
        </h2>
        <ul class="fg-sr__cards">
            <?php foreach ($products as $p) :
                $has_model = ! empty($p['model']);
                ?>
                <li class="fg-sr__card<?php echo $has_model ? ' is-modelled' : ''; ?>">
                    <?php if ($has_model) : ?>
                        <button type="button" class="fg-sr__card-hit"
                                data-sr-select="<?php echo esc_attr($p['slug']); ?>"
                                data-sr-model="<?php echo esc_attr($p['model']['file']); ?>"
                                data-sr-model-id="<?php echo esc_attr($p['model']['id']); ?>"
                                data-sr-animated="<?php echo $p['model']['animated'] ? '1' : '0'; ?>"
                                data-sr-material="<?php echo esc_attr($p['material']); ?>"
                                aria-pressed="<?php echo $p['slug'] === $default['slug'] ? 'true' : 'false'; ?>">
                            <img src="<?php echo esc_url($p['poster']); ?>" alt=""
                                 width="<?php echo (int) $poster['width']; ?>"
                                 height="<?php echo (int) $poster['height']; ?>"
                                 loading="lazy" decoding="async">
                            <span class="fg-sr__card-name"><?php echo esc_html($p['name']); ?></span>
                            <span class="fg-sr__card-fit"><?php echo esc_html($p['fit']); ?></span>
                            <span class="fg-sr__card-tag"><?php esc_html_e('3D', 'fenster'); ?></span>
                        </button>
                    <?php else : ?>
                        <a class="fg-sr__card-hit" href="<?php echo esc_url($p['url']); ?>">
                            <?php if ($p['photo'] !== '') : ?>
                                <img src="<?php echo esc_url($p['photo']); ?>"
                                     alt="<?php echo esc_attr($p['photo_alt'] !== '' ? $p['photo_alt'] : $p['name']); ?>"
                                     width="<?php echo (int) $p['photo_w']; ?>"
                                     height="<?php echo (int) $p['photo_h']; ?>"
                                     loading="lazy" decoding="async">
                            <?php else : ?>
                                <span class="fg-sr__card-blank" aria-hidden="true"></span>
                            <?php endif; ?>
                            <span class="fg-sr__card-name"><?php echo esc_html($p['name']); ?></span>
                            <span class="fg-sr__card-fit"><?php echo esc_html($p['fit']); ?></span>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($photo_only !== []) : ?>
            <p class="fg-sr__rail-note">
                <?php
                printf(
                    esc_html__('%1$d of the %2$d %3$s in our range can be turned round in 3D here. The rest have their own page, with photographs of installations we have fitted.', 'fenster'),
                    count($modelled),
                    count($products),
                    esc_html($page['nouns'])
                );
                ?>
            </p>
        <?php endif; ?>
    </nav>

    <?php if ($decision_columns !== []) : ?>
        <section class="fg-sr__decision">
            <div class="fg-sr__decision-head">
                <p class="fg-sr__eyebrow"><?php echo esc_html((string) ($hub['decision_eyebrow'] ?? '')); ?></p>
                <h2><?php echo esc_html((string) ($hub['decision_heading'] ?? '')); ?></h2>
                <p><?php echo esc_html((string) ($hub['decision_intro'] ?? '')); ?></p>
            </div>
            <div class="fg-sr__decision-cols">
                <?php foreach ($decision_columns as $col) : ?>
                    <div class="fg-sr__decision-col">
                        <h3><?php echo esc_html((string) ($col['title'] ?? '')); ?></h3>
                        <p class="fg-sr__decision-meta"><?php echo esc_html((string) ($col['meta'] ?? '')); ?></p>
                        <dl>
                            <?php foreach ((array) ($col['points'] ?? []) as $pt) : ?>
                                <div>
                                    <dt><?php echo esc_html((string) ($pt['label'] ?? '')); ?></dt>
                                    <dd><?php echo esc_html((string) ($pt['value'] ?? '')); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                        <p class="fg-sr__decision-note"><?php echo esc_html((string) ($col['note'] ?? '')); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-sr__how">
        <div class="fg-sr__how-inner">
            <p class="fg-sr__eyebrow"><?php esc_html_e('How this works', 'fenster'); ?></p>
            <h2><?php esc_html_e('These are the models we quote from.', 'fenster'); ?></h2>
            <p>
                <?php
                printf(
                    esc_html__('Every %1$s on this page is the manufacturer\'s own geometry, taken straight from the software our surveyors price in — not a photograph of somebody else\'s house and not an artist\'s impression. The frame you turn round is the frame that turns up.', 'fenster'),
                    esc_html($page['noun'])
                );
                ?>
            </p>
            <p>
                <?php
                printf(
                    esc_html__('When you have found the %1$s you want, the instant price tool asks for the opening size and gives you a guide figure. We confirm it at survey, because a %1$s that fits is worth more than a quote that arrives quickly.', 'fenster'),
                    esc_html($page['noun'])
                );
                ?>
            </p>
            <p class="fg-sr__how-actions">
                <a class="fg-sr__btn fg-sr__btn--primary" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                <a class="fg-sr__btn" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
            </p>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/enquiry-form', null, [
        'class' => 'fg-form fg-sr__form',
        'source' => $group === 'doors' ? 'Door showroom' : 'Window showroom',
        'button_label' => $group === 'doors' ? __('Send my door details', 'fenster') : __('Send my window details', 'fenster'),
        'project_type' => $group === 'doors' ? 'Doors' : 'Windows',
        'compact' => true,
    ]);

    get_template_part('template-parts/components/review-showcase', null, [
        'limit' => 3,
    ]);

    if ($faqs !== []) {
        get_template_part('template-parts/components/faq-block', null, [
            'faqs' => $faqs,
            'eyebrow' => __('Before you enquire', 'fenster'),
            'heading' => (string) ($hub['faq_heading'] ?? __('The questions we get asked on the phone.', 'fenster')),
            'id' => 'fg-sr-faq-title',
        ]);
    }
    ?>
</section>

<?php
/* THE BOOTSTRAPPER.
 *
 * Deliberately inline and deliberately tiny. Its only job is to decide whether
 * the 3D upgrade is worth offering, and to import it if the visitor asks for
 * it. `three` is roughly 170KB gzipped, and the difference between this page
 * and the one the audit failed is entirely that those kilobytes are never
 * fetched unless somebody wants them.
 */
$viewer_src = FENSTER_THEME_URI . '/assets/showroom/showroom.js';
?>
<script type="module">
(function () {
    var root = document.querySelector('[data-sr-viewer]');
    var section = document.querySelector('[data-showroom]');
    if (!root || !section) return;

    var frame = root.querySelector('.fg-sr__frame');

    /* ---- product switching, with no dependency on anything ----------------
       This is the whole of the page's interactivity without the 3D upgrade,
       and it is why the page is complete before three.js exists. Every
       product's specification is already in the DOM; selecting one is a class
       change and a `hidden` toggle, so a crawler reads all nine and a visitor
       with a failed script still sees the default. */
    function select(slug, id) {
        section.querySelectorAll('[data-sr-spec]').forEach(function (el) {
            el.hidden = el.getAttribute('data-sr-spec') !== slug;
        });
        section.querySelectorAll('[data-sr-select]').forEach(function (el) {
            el.setAttribute('aria-pressed', String(el.getAttribute('data-sr-select') === slug));
        });
        if (id) {
            root.querySelectorAll('[data-sr-poster]').forEach(function (el) {
                el.classList.toggle('is-current', el.getAttribute('data-sr-poster') === id);
            });
        }
        section.dispatchEvent(new CustomEvent('showroom:select', { detail: { slug: slug, id: id } }));
    }

    section.querySelectorAll('[data-sr-select]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            select(btn.getAttribute('data-sr-select'), btn.getAttribute('data-sr-model-id'));
        });
    });

    /* ---- the 3D upgrade --------------------------------------------------
       Asked for, never assumed. `three` is about 170KB gzipped and the only
       thing separating this page from the 12.3MB one the audit failed is that
       those kilobytes are not fetched unless somebody wants them. */
    var ok = (function () {
        try {
            var c = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
        } catch (e) { return false; }
    })();
    if (!ok) return;

    var enter = root.querySelector('[data-sr-enter]');
    if (enter) enter.hidden = false;

    var started = false;
    function start() {
        if (started) return;
        started = true;
        import(<?php echo wp_json_encode($viewer_src); ?>)
            .then(function (m) { return m.mount(root, section); })
            /* A handle for the QA harness, the same way the earlier 3D page
               exposes one. Verification has to be able to sample material
               colour and read renderer.info; looking at a screenshot cannot
               tell you whether the glass was recoloured along with the frame. */
            .then(function (v) { window.__showroom = v; return v; })
            .catch(function (e) {
                started = false;
                if (enter) enter.hidden = false;
                if (frame) frame.classList.remove('is-live');
                console.warn('[showroom] viewer unavailable', e);
            });
    }

    if (enter) enter.addEventListener('click', function () { enter.hidden = true; start(); });
})();
</script>
