<?php
/**
 * HOMEPAGE 3.0 — markup.
 *
 * See `inc/home-30.php` for why this strand is self-contained. Every class is
 * namespaced `fg-h30-`; the shared header and footer are untouched.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$h30_asset = static function (string $path): string {
    return esc_url(FENSTER_THEME_URI . '/assets/' . ltrim($path, '/'));
};

$h30_groups = fenster_h30_search_groups();
// Category links also work with JavaScript disabled.
$h30_requested = isset($_GET['fg_category']) && is_string($_GET['fg_category'])
    ? sanitize_key(wp_unslash($_GET['fg_category'])) : '';
$h30_active = isset($h30_groups[$h30_requested]) ? $h30_requested : 'windows';
$h30_hero = $h30_groups[$h30_active];
$h30_categories = fenster_h30_categories();
$h30_projects = fenster_h30_projects(6);
$h30_map = fenster_h30_map_data();
$h30_reviews = function_exists('fenster_review_summary') ? fenster_review_summary() : [];
$h30_rating = number_format((float) ($h30_reviews['rating'] ?? 4.9), 1);
$h30_review_count = (int) ($h30_reviews['count'] ?? 0);
/* One real review to quote. `fenster_review_cards()` returns the live Google set
   when the Places key is configured and the curated fallback when it is not;
   either way it is a real customer's words, never copy written here. */
$h30_review = function_exists('fenster_review_cards') ? (fenster_review_cards(1, 'home')[0] ?? null) : null;
/* There is no /reviews/ page on this site and never has been: the review
   showcase is a component other pages render. The Google profile is where a
   rating should send someone anyway, and `fenster_review_summary()` carries
   its address. Falls back to the About page, which renders the showcase. */
$h30_reviews_url = (string) ($h30_reviews['maps_url'] ?? '');
$h30_reviews_url = $h30_reviews_url !== '' ? $h30_reviews_url : home_url('/about/');
$h30_quote_url = home_url('/online-quote/');
$h30_quote_embed = fenster_h30_quote_embed_url();
$h30_headlines = array_values(array_filter(array_map('strval', fenster_h30_headlines())));
$h30_headline = $h30_headlines[0] ?? 'What would you like to change?';
$h30_case_url = static function (string $slug): string {
    return home_url('/case-studies/' . $slug . '/');
};
?>

<div class="fg-h30">

    <!-- Product finder: real links without JS, live filtering with JS. -->
    <section class="fg-h30-hero" aria-labelledby="fg-h30-hero-title">
        
        
        <!-- The banner and its search panel are deliberately the shape a
             homeowner already knows from finding their house. -->
        
        <div class="fg-h30-hero__stage">
            <figure class="fg-h30-hero__photo" data-h30-hero-photo data-fg-depth="0.06">
                                                    <img class="fg-h30-hero__single"
                                                        src="<?php echo $h30_asset('images/case-studies/' . $h30_hero['image']); ?>"
                                                        style="--h30-hero-focus: <?php echo esc_attr($h30_hero['focus'] ?? '42% 42%'); ?>; --h30-hero-focus-narrow: <?php echo esc_attr($h30_hero['focus_narrow'] ?? $h30_hero['focus'] ?? '38% 46%'); ?>"
                                                        alt="<?php echo esc_attr($h30_hero['alt']); ?>"
                                                        width="<?php echo (int) $h30_hero['width']; ?>" height="<?php echo (int) $h30_hero['height']; ?>"
                                                        fetchpriority="high" loading="eager" decoding="async">
                                                    <a class="fg-h30-hero__trust" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>">
                                                        Why trust Fenster
                                                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </a>
                                                    <figcaption>
                                                        <span data-h30-photo-label>Fitted by Fenster</span>
                                                        <span data-h30-photo-title><?php echo esc_html($h30_hero['location']); ?></span>
                                                        <span data-h30-photo-description class="fg-h30-visually-hidden"><?php echo esc_html($h30_hero['caption']); ?></span>
                                                        <a href="<?php echo esc_url($h30_case_url($h30_hero['project'])); ?>"><span data-h30-photo-action>See this project</span> <span aria-hidden="true">&rarr;</span></a>
                                                    </figcaption>
                                                </figure>

            <div class="fg-h30-hero__inner">
                <div class="fg-h30-hero__intro">
                    <!-- THE HEADING IS THE LINE THAT SAYS WHAT THIS IS.
                         The typed question below is the thing a visitor looks at, but
                         it changes every few seconds and names no product and no town,
                         so it cannot be the heading of the page. This line can: it is
                         visible, it is fixed, and it says what we do and where. The
                         classic homepage led with the same sentence. -->
                    <h1 class="fg-h30-hero__eyebrow" id="fg-h30-hero-title">Windows and doors, fitted across Milton Keynes</h1>
                    <!-- Decoration, and hidden from assistive technology, so a screen
                         reader is never read a sentence that rewrites itself. -->
                    <p class="fg-h30-hero__title" aria-hidden="true">
                        <span class="fg-h30-hero__typed" data-h30-type
                            data-h30-phrases="<?php echo esc_attr((string) wp_json_encode($h30_headlines, JSON_UNESCAPED_UNICODE)); ?>"><span data-h30-type-text><?php echo esc_html($h30_headline); ?></span><span class="fg-h30-hero__caret"></span></span>
                    </p>
                </div>

                <div class="fg-h30-finder" id="fg-h30-finder" data-h30-finder>
                                                            <nav class="fg-h30-finder__tabs" aria-label="Choose what to change">
                                                                <?php foreach ($h30_groups as $h30_key => $h30_group) : ?>
                                                                    <a
                                                                        class="fg-h30-finder__tab<?php echo $h30_key === $h30_active ? ' is-active' : ''; ?>"
                                                                        id="fg-h30-tab-<?php echo esc_attr($h30_key); ?>"
                                                                        href="<?php echo esc_url(add_query_arg('fg_category', $h30_key, home_url('/'))); ?>"
                                                                        data-h30-tab="<?php echo esc_attr($h30_key); ?>"
                                                                        <?php if ($h30_key === $h30_active) : ?>aria-current="true"<?php endif; ?>
                                                                    >
                                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                                            <?php if ($h30_key === 'windows') : ?><rect x="4" y="3" width="16" height="18" rx="1"/><path d="M12 3v18M4 12h16"/>
                                                                            <?php elseif ($h30_key === 'doors') : ?><path d="M5 21V3h14v18M3 21h18M8 6h8v6H8zM15 16h1"/>
                                                                            <?php else : ?><path d="m3 10 9-7 9 7M5 9v12h14V9M10 21v-7h4v7M8 10h2M14 10h2"/>
                                                                            <?php endif; ?>
                                                                        </svg>
                                                                        <span><?php echo esc_html($h30_group['label']); ?></span>
                                                                        <small aria-hidden="true"><?php echo count($h30_group['options']); ?></small>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </nav>

                                                            <?php foreach ($h30_groups as $h30_key => $h30_group) : ?>
                                                                <div class="fg-h30-finder__panel"
                                                                    id="fg-h30-panel-<?php echo esc_attr($h30_key); ?>"
                                                                    data-h30-panel="<?php echo esc_attr($h30_key); ?>"
                                                                    data-h30-label="<?php echo esc_attr($h30_group['label']); ?>"
                                                                    data-h30-image="<?php echo $h30_asset('images/case-studies/' . $h30_group['image']); ?>"
                                                                    data-h30-alt="<?php echo esc_attr($h30_group['alt']); ?>"
                                                                    data-h30-location="<?php echo esc_attr($h30_group['location']); ?>"
                                                                    data-h30-caption="<?php echo esc_attr($h30_group['caption']); ?>"
                                                                    data-h30-project="<?php echo esc_url($h30_case_url($h30_group['project'])); ?>"
                                                                    data-h30-focus="<?php echo esc_attr($h30_group['focus'] ?? '42% 42%'); ?>"
                                                                    data-h30-focus-narrow="<?php echo esc_attr($h30_group['focus_narrow'] ?? $h30_group['focus'] ?? '38% 46%'); ?>"

                                                                    <?php if ($h30_key !== $h30_active) : ?>hidden<?php endif; ?>>
                                                                    <div class="fg-h30-finder__body">
                                                                        <div class="fg-h30-finder__filter" hidden data-h30-filter>
                                                                            <label for="fg-h30-query-<?php echo esc_attr($h30_key); ?>">Search windows, doors and more</label>
                                                                            <div class="fg-h30-finder__search-row">
                                                                            <div class="fg-h30-finder__input-wrap">
                                                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.5 15.5 5 5"/></svg>
                                                                                <input type="search" id="fg-h30-query-<?php echo esc_attr($h30_key); ?>"
                                                                                    placeholder="<?php echo esc_attr($h30_group['placeholder']); ?>"
                                                                                    autocomplete="off" spellcheck="false" maxlength="100"
                                                                                    aria-controls="fg-h30-options-<?php echo esc_attr($h30_key); ?>"
                                                                                    data-h30-query>
                                                                                <button type="button" class="fg-h30-finder__clear" aria-label="Clear search" data-h30-clear hidden>&times;</button>
                                                                            </div>
                                                                            <button type="button" class="fg-h30-finder__search" data-h30-search aria-expanded="false" aria-controls="fg-h30-results-<?php echo esc_attr($h30_key); ?>">Search <span aria-hidden="true">&rarr;</span></button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="fg-h30-finder__results" id="fg-h30-results-<?php echo esc_attr($h30_key); ?>" data-h30-results>
                                                                        <div class="fg-h30-finder__results-head">
                                                                            <p class="fg-h30-finder__count" data-h30-count role="status" aria-live="polite" aria-atomic="true">Choose an option to see more</p>
                                                                            <button type="button" class="fg-h30-finder__dismiss" data-h30-dismiss hidden aria-label="Close product options">Close <span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <ul class="fg-h30-finder__options" id="fg-h30-options-<?php echo esc_attr($h30_key); ?>" data-lenis-prevent>
                                                                            <?php foreach ($h30_group['options'] as $h30_option) : ?>
                                                                                <li data-h30-option data-h30-category="<?php echo esc_attr($h30_group['label']); ?>" data-h30-terms="<?php echo esc_attr(implode(' ', [$h30_option['label'], $h30_option['meta'], $h30_option['keywords']])); ?>">
                                                                                    <?php $h30_preview = fenster_h30_option_preview($h30_option['value']); ?>
                                                                                    <a class="fg-h30-finder__option" href="<?php echo esc_url(home_url('/' . $h30_option['value'] . '/')); ?>"
                                                                                        <?php if (! empty($h30_preview['src'])) : ?>
                                                                                            data-h30-preview-src="<?php echo esc_url(fenster_generated_url($h30_preview['src'])); ?>"
                                                                                            data-h30-preview-alt="<?php echo esc_attr($h30_preview['alt'] ?? $h30_option['label']); ?>"
                                                                                        <?php endif; ?>>
                                                                                        <span class="fg-h30-finder__thumb" aria-hidden="true">
                                                                                            <?php if (! empty($h30_preview['src'])) : ?>
                                                                                                <?php /* A purpose-built 128px square. The list is rebuilt from cloned
                                                                                                          nodes when it filters, so anything that fills these in later by
                                                                                                          script fills the wrong copies and every swatch comes up blank. */ ?>
                                                                                                <img src="<?php echo esc_url(fenster_h30_option_thumb(fenster_generated_url($h30_preview['src']))); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                                                                                            <?php else : ?>
                                                                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 3h14v18H5zM8 7h8M8 11h8M8 15h5"/></svg>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                        <span class="fg-h30-finder__option-copy"><strong><?php echo esc_html($h30_option['label']); ?></strong><small><?php echo esc_html($h30_option['meta']); ?></small><em data-h30-result-category hidden><?php echo esc_html($h30_group['label']); ?></em></span>
                                                                                        <span class="fg-h30-finder__arrow" aria-hidden="true">&rarr;</span>
                                                                                    </a>
                                                                                </li>
                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                        <div class="fg-h30-finder__empty" data-h30-empty hidden>
                                                                            <strong>No close matches yet</strong>
                                                                            <p>Try a product name like &ldquo;sash&rdquo;, &ldquo;bifold&rdquo; or &ldquo;rooflight&rdquo;.</p>
                                                                            <button type="button" data-h30-reset>Browse all options in this category <span aria-hidden="true">&rarr;</span></button>
                                                                        </div>

                                                                        <p class="fg-h30-finder__help">Not sure where to start? <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Let us help you choose &rarr;</a></p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
            </div>
        </div>

        <div class="fg-h30-shell">
            <div class="fg-h30-assurance" aria-label="About your installation">
                                                        <a class="fg-h30-hero__rating" href="<?php echo esc_url($h30_reviews_url); ?>"><span aria-hidden="true">★★★★★</span> <strong><?php echo esc_html($h30_rating); ?>/5</strong> on Google</a>
                                                        <a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>"><span aria-hidden="true">✓</span> FENSA registered</a>
                                                        <a href="<?php echo esc_url(home_url('/about/')); ?>"><span aria-hidden="true">✓</span> Our own installation team</a>
                                                        <a href="<?php echo esc_url(home_url('/contact/')); ?>"><span aria-hidden="true">↗</span> Visit our Milton Keynes showroom</a>
                                                    </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────────────────────────
         BROWSE. Homeowner language on the card, industry terms as the
         links underneath, so nobody has to know what "flush sash" means
         before they can start.
         ───────────────────────────────────────────────────────────────── -->
    <section class="fg-h30-browse" aria-labelledby="fg-h30-browse-title">
        <div class="fg-h30-shell">
            <div class="fg-h30-head">
                <h2 id="fg-h30-browse-title">A closer look at your double glazing options</h2>
                <p>Styles, materials and the details that make each one different.</p>
            </div>

            <ul class="fg-h30-browse__grid" data-h30-reveal>
                <?php foreach ($h30_categories as $h30_cat) : ?>
                    <li class="fg-h30-cat">
                        <a class="fg-h30-cat__media" href="<?php echo esc_url($h30_cat['url']); ?>" tabindex="-1" aria-hidden="true">
                            <img
                                src="<?php echo esc_url(fenster_generated_url($h30_cat['image'])); ?>"
                                alt=""
                                width="800"
                                height="600"
                                loading="lazy"
                                decoding="async"
                            >
                        </a>
                        <div class="fg-h30-cat__body">
                            <h3><a href="<?php echo esc_url($h30_cat['url']); ?>"><?php echo esc_html($h30_cat['title']); ?></a></h3>
                            <p><?php echo esc_html($h30_cat['copy']); ?></p>
                            <ul class="fg-h30-cat__links">
                                <?php foreach ($h30_cat['links'] as $h30_link) : ?>
                                    <li><a href="<?php echo esc_url(home_url($h30_link[1])); ?>"><?php echo esc_html($h30_link[0]); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>


    <!-- ─────────────────────────────────────────────────────────────────
         INSTANT PRICING. The strongest thing the site has, so it gets a
         band of its own after the project examples rather than a button in a
         list. The claim that the figure matches a home visit is
         owner-confirmed: the quote tool runs the same price list.
         ───────────────────────────────────────────────────────────────── -->
    <section class="fg-h30-price" aria-labelledby="fg-h30-price-title">
        <div class="fg-h30-shell">
            <div class="fg-h30-price__panel">
                <div class="fg-h30-price__lede">
                    <p class="fg-h30-kicker">Instant quotes</p>
                    <h2 id="fg-h30-price-title">See your price online, in minutes</h2>
                    <p>
                        Build your windows or doors, set the sizes and choose the colours. You get a real quote
                        from the same price list we use on a home visit, so the figure does not change when we
                        turn up.
                    </p>
                    <p class="fg-h30-price__actions">
                        <a class="fg-h30-btn fg-h30-btn--primary" href="<?php echo esc_url($h30_quote_url); ?>">Start your price</a>
                        <a class="fg-h30-btn fg-h30-btn--ghost" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Book a free visit</a>
                    </p>
                </div>
                <!-- The pricing tool itself, rather than a description of it. The frame
                     stays empty until the band is reached (or the button is pressed), so a
                     third-party origin never delays the rest of the page. -->
                <div class="fg-h30-price__quote" data-h30-quote data-h30-quote-src="<?php echo esc_url($h30_quote_embed); ?>">
                    <div class="fg-h30-price__quote-note" data-h30-quote-note>
                        <strong>Instant pricing</strong>
                        <span>Loads as you reach this section.</span>
                        <button class="fg-h30-btn fg-h30-btn--primary" type="button" data-h30-quote-load>Load the pricing tool</button>
                    </div>
                    <iframe
                        title="Fenster instant pricing tool"
                        loading="lazy"
                        allow="fullscreen"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <!-- The same expand control the other quote pages carry. -->
                    <button class="fg-h30-price__expand" type="button" data-h30-quote-expand>
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 2H2v4M10 2h4v4M10 14h4v-4M6 14H2v-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Full screen
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────────────────────────
         PROJECTS AS LISTINGS. Real installs, presented the way a property
         result is: photograph, place, what was done, the finish, the date.
         ───────────────────────────────────────────────────────────────── -->
    <?php if ($h30_projects !== []) : ?>
        <section class="fg-h30-projects" id="fg-h30-projects" data-h30-projects aria-labelledby="fg-h30-projects-title">
            <div class="fg-h30-shell">
                <div class="fg-h30-head fg-h30-head--row">
                    <div>
                        <p class="fg-h30-kicker">A little local inspiration</p>
                        <h2 id="fg-h30-projects-title">Real homes. A fresh look.</h2>
                        <p>Real homes, real streets. Have a look at what your neighbours chose.</p>
                    </div>
                    <a class="fg-h30-head__more" href="<?php echo esc_url(home_url('/case-studies/')); ?>">
                        See all projects
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="fg-h30-projects__toolbar" data-h30-project-toolbar hidden>
                    <div class="fg-h30-projects__filters" aria-label="Filter recent projects">
                        <button type="button" data-h30-project-filter="all" aria-pressed="true">All projects</button>
                        <button type="button" data-h30-project-filter="windows" aria-pressed="false">Windows</button>
                        <button type="button" data-h30-project-filter="doors" aria-pressed="false">Doors</button>
                        <button type="button" data-h30-project-filter="together" aria-pressed="false">Windows &amp; doors</button>
                    </div>
                    <div class="fg-h30-projects__nav">
                        <p data-h30-project-count role="status" aria-live="polite"></p>
                        <button type="button" class="fg-h30-projects__arrow" data-h30-rail-prev aria-label="Previous projects">
                            <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M10 3 5 8l5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="fg-h30-projects__arrow" data-h30-rail-next aria-label="Next projects">
                            <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="m6 3 5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>
                <ul class="fg-h30-projects__grid fg-h30-projects__rail" id="fg-h30-project-results" data-h30-rail data-h30-reveal aria-roledescription="carousel" aria-label="Recent projects">
                    <?php foreach ($h30_projects as $h30_project) : ?>
                        <li class="fg-h30-listing" data-h30-project-types="<?php echo esc_attr(implode(' ', $h30_project['types'])); ?>">
                            <a class="fg-h30-listing__link" href="<?php echo esc_url($h30_project['url']); ?>">
                                <span class="fg-h30-listing__media">
                                    <img
                                        src="<?php echo esc_url((string) ($h30_project['image']['src'] ?? $h30_project['image']['url'] ?? '')); ?>"
                                        alt="<?php echo esc_attr((string) ($h30_project['image']['alt'] ?? $h30_project['location'])); ?>"
                                        width="800"
                                        height="600"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <?php if ($h30_project['colour'] !== '') : ?>
                                        <span class="fg-h30-listing__tag"><?php echo esc_html($h30_project['colour']); ?></span>
                                    <?php endif; ?>


                                </span>
                                <span class="fg-h30-listing__body">
                                    <span class="fg-h30-listing__place"><?php echo esc_html($h30_project['location']); ?></span>
                                    <?php if ($h30_project['products'] !== []) : ?>
                                        <span class="fg-h30-listing__what"><?php echo esc_html(implode(' · ', $h30_project['products'])); ?></span>
                                    <?php endif; ?>
                                    <span class="fg-h30-listing__summary"><?php echo esc_html($h30_project['summary']); ?></span>
                                    <?php if ($h30_project['date'] !== '') : ?>
                                        <span class="fg-h30-listing__meta">Completed <?php echo esc_html($h30_project['date']); ?><span aria-hidden="true">&rarr;</span></span>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <!-- ─────────────────────────────────────────────────────────────────
         PROOF. Evidence rather than a "why choose us" wall.
         ───────────────────────────────────────────────────────────────── -->
    <section class="fg-h30-proof" aria-labelledby="fg-h30-proof-title">
        <div class="fg-h30-shell">
            <div class="fg-h30-head">
                <p class="fg-h30-kicker">Why homeowners choose Fenster</p>
                <h2 id="fg-h30-proof-title">Real reviews. A real showroom. Our own fitters.</h2>
                <p>The things you can check for yourself before anyone comes to the house.</p>
            </div>

            <div class="fg-h30-proof__grid" data-h30-reveal>

                <article class="fg-h30-proof__card fg-h30-proof__card--reviews">
                    <div class="fg-h30-proof__media fg-h30-proof__media--rating">
                        <img class="fg-h30-proof__badge" src="<?php echo $h30_asset('trust/google-5-stars.png'); ?>" alt="Google reviews" width="150" height="67" loading="lazy" decoding="async">
                        <p class="fg-h30-proof__score">
                            <strong><?php echo esc_html($h30_rating); ?></strong>
                            <span>out of 5<?php if ($h30_review_count > 0) : ?> &middot; <?php echo esc_html((string) $h30_review_count); ?> reviews<?php endif; ?></span>
                        </p>
                    </div>
                    <div class="fg-h30-proof__body">
                        <?php if (is_array($h30_review) && ($h30_review['quote'] ?? '') !== '') : ?>
                            <blockquote class="fg-h30-proof__quote">
                                <p>&ldquo;<?php echo esc_html((string) $h30_review['quote']); ?>&rdquo;</p>
                                <footer>
                                    <?php echo esc_html((string) ($h30_review['author'] ?? '')); ?><?php if (($h30_review['context'] ?? '') !== '') : ?><span> &middot; <?php echo esc_html((string) $h30_review['context']); ?></span><?php endif; ?>
                                </footer>
                            </blockquote>
                        <?php else : ?>
                            <h3>Rated by the people we fitted for</h3>
                            <p>Reviews come straight from our Google profile, not a hand-picked list.</p>
                        <?php endif; ?>
                        <a href="<?php echo esc_url($h30_reviews_url); ?>">Read <?php echo $h30_review_count > 0 ? 'all ' . esc_html((string) $h30_review_count) . ' reviews' : 'the reviews'; ?></a>
                    </div>
                </article>

                <article class="fg-h30-proof__card">
                    <a class="fg-h30-proof__media" href="<?php echo esc_url(home_url('/contact/')); ?>" tabindex="-1" aria-hidden="true">
                        <img src="<?php echo $h30_asset('images/about/fenster-showroom.png'); ?>" alt="" width="1536" height="1024" loading="lazy" decoding="async">
                    </a>
                    <div class="fg-h30-proof__body">
                        <h3>A showroom you can walk into</h3>
                        <p>Alston Drive, Bradwell Abbey. Monday to Friday, 8.30am to 5pm, with the full samples on the floor rather than in a brochure.</p>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>">Find the showroom</a>
                    </div>
                </article>

                <article class="fg-h30-proof__card">
                    <!-- Our own fitters on a real job, never a supplier's library shot:
                         Shane and Andy taking the old frame out on the Milton Keynes
                         composite door, from that case study's own photo set. -->
                    <a class="fg-h30-proof__media fg-h30-proof__media--crew" href="<?php echo esc_url(home_url('/about/')); ?>" tabindex="-1" aria-hidden="true">
                        <img src="<?php echo $h30_asset('images/case-studies/cs-mk-composite-door-old-frame-out.jpg'); ?>" alt="" width="1152" height="1440" loading="lazy" decoding="async">
                    </a>
                    <div class="fg-h30-proof__body">
                        <h3>Fitted by our own team</h3>
                        <p>That&rsquo;s Shane and Andy, taking an old door frame out in Milton Keynes. Your survey and installation are done by people who work for us, and we clear up after ourselves on the day.</p>
                        <a href="<?php echo esc_url(home_url('/about/')); ?>">Meet the team</a>
                    </div>
                </article>

                <article class="fg-h30-proof__card fg-h30-proof__card--badges">
                    <div class="fg-h30-proof__media fg-h30-proof__media--logos">
                        <ul class="fg-h30-proof__logos">
                            <li><img src="<?php echo $h30_asset('trust/fensa.png'); ?>" alt="FENSA approved installer" width="215" height="114" loading="lazy" decoding="async"></li>
                            <li><img src="<?php echo $h30_asset('trust/cpa.png'); ?>" alt="Consumer Protection Association" width="654" height="400" loading="lazy" decoding="async"></li>
                            <li><img src="<?php echo $h30_asset('trust/constructionline-gold-member.png'); ?>" alt="Constructionline Gold member" width="768" height="386" loading="lazy" decoding="async"></li>
                        </ul>
                    </div>
                    <div class="fg-h30-proof__body">
                        <h3>Accredited and insured</h3>
                        <p>FENSA registered, with an insurance-backed guarantee on every installation of new windows and doors.</p>
                        <a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>">See our accreditations</a>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────────────────────────
         AREAS. Real routes out of the location matrix, presented the way
         a portal presents its saved searches.
         ───────────────────────────────────────────────────────────────── -->
        <section class="fg-h30-areas" aria-labelledby="fg-h30-areas-title">
            <!-- The map fills the section, which fills the screen. Loads when scrolled
                 into view; see src/home30/map.js. Renders on Google Maps when
                 FENSTER_GOOGLE_MAPS_KEY is set, Leaflet + OpenStreetMap when it is not. -->
            <div class="fg-h30-map" data-h30-map role="region" aria-label="Map of the area Fenster covers, with pins on completed projects">
                <p class="fg-h30-map__placeholder">Loading the map&hellip;</p>
            </div>
            <script type="application/json" id="fg-h30-map-data"><?php echo wp_json_encode($h30_map, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?></script>

            <div class="fg-h30-areas__panel" data-h30-map-panel>
                <p class="fg-h30-kicker">Where we work</p>
                <h2 id="fg-h30-areas-title">Everything inside the red line is home turf.</h2>
                <p class="fg-h30-areas__note">
                    Milton Keynes and everything around it: up to Northampton and Wellingborough, across to
                    Bedford and Sandy, down through Stevenage and St Albans to Berkhamsted and Aylesbury, and
                    out west to Brackley.
                </p>
                <!-- The count is the owner's own figure. The claim about the pins is
                     one the data actually supports: every residential case study is
                     pinned, so nothing newer is being held back, and thirteen of the
                     sixteen were finished in 2025 or later. -->
                <p class="fg-h30-areas__note">
                    Thousands of double glazing installations later, the green pins are the most recent
                    ones we have written up. Click one to see the house.
                </p>
                <ul class="fg-h30-map__legend" aria-label="Map key">
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--line"></span> Our working area</li>
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--pin"></span> A finished project</li>
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--showroom"></span> The showroom</li>
                </ul>
                <a class="fg-h30-head__more" href="<?php echo esc_url(home_url('/areas-we-cover/')); ?>">
                    Every area we cover
                    <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </section>

    <!-- ───────────────────────────────────────────────────────────────── -->
    <section class="fg-h30-close" id="fenster-enquiry" aria-labelledby="fg-h30-close-title">
        <div class="fg-h30-shell">
            <div class="fg-h30-close__panel">
                <h2 id="fg-h30-close-title">Get a quote when you are ready</h2>
                <p>
                    Quote it yourself online, or have someone walk the property with you and talk it through.
                    The consultation is free and there is nothing to pay if you decide against the work.
                </p>
                <p class="fg-h30-close__actions">
                    <a class="fg-h30-btn fg-h30-btn--primary" href="<?php echo esc_url($h30_quote_url); ?>">Get a price online</a>
                    <a class="fg-h30-btn fg-h30-btn--ghost" href="<?php echo esc_url(home_url('/contact/')); ?>">Talk to us</a>
                </p>
            </div>
        </div>
    </section>

</div>
