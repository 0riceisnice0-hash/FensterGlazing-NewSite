<?php
/** Composite doors: one route, one composition, shared product truth. */
if (! defined('ABSPATH')) { exit; }
require_once FENSTER_THEME_DIR . '/inc/composite-door-data.php';
require_once FENSTER_THEME_DIR . '/inc/composite-page-data.php';
require_once FENSTER_THEME_DIR . '/inc/quote-collections.php';
$brand = fenster_data('brand', []);
$content = fenster_data('product_content.composite-doors', []);
$collections = fenster_composite_door_collections();
$door_count = array_sum(array_map(static fn ($c): int => count($c['styles']), $collections));
$colours = fenster_composite_page_colours();
$quote_url = fenster_quote_collection_url('composite-doors');
$art = fenster_composite_door_line_art_base();
$art_version = fenster_composite_door_line_art_version();
$asset = static fn (string $path): string => FENSTER_THEME_URI . '/assets/images/products/composite-distinction/' . $path;
$photo = static function (string $path, string $alt, string $class = '', bool $eager = false): void {
    echo '<img ' . fenster_image_attr_string($path, ['alt' => $alt, 'class' => $class, 'loading' => $eager ? 'eager' : 'lazy', 'decoding' => 'async']) . '>';
};
$colour_preview = static function (array $colour) use ($asset): array {
    if (! empty($colour['door'])) {
        return ['src' => $asset('colours/' . $colour['door'] . '-800w.webp'), 'kind' => 'Photographed door'];
    }
    if (! empty($colour['colour_door'])) {
        return ['src' => $asset('colour-doors/' . $colour['colour_door'] . '-800w.webp'), 'kind' => 'Manufacturer door image'];
    }
    return ['src' => $asset('palette/' . $colour['swatch'] . '-320w.webp'), 'kind' => 'Paint sample'];
};
$glass_doors = [];
$glass_patterns = [];
foreach ($content['glass_styles']['items'] ?? [] as $item) {
    $item['slug'] = sanitize_title($item['name']);
    if (is_readable(FENSTER_THEME_DIR . '/assets/images/products/composite-distinction/glass-doors/' . $item['slug'] . '-800w.webp')) {
        $glass_doors[] = $item;
    } else {
        $glass_patterns[] = $item;
    }
}
$first_glass = $glass_doors[0];
$first_colour = $colour_preview($colours[0]);
$reviews = fenster_review_cards(2, 'front door');
?>
<article class="fg-cdoor-page" data-composite-page>
    <section class="fg-cdoor-hero" aria-labelledby="composite-title">
        <div class="fg-cdoor-hero__image">
            <img src="<?php echo esc_url($asset('gallery/chatsworth-double-lite-1400w.webp')); ?>"
                srcset="<?php echo esc_attr($asset('gallery/chatsworth-double-lite-800w.webp') . ' 800w, ' . $asset('gallery/chatsworth-double-lite-1400w.webp') . ' 1400w'); ?>"
                sizes="(max-width: 760px) 100vw, 64vw" width="1400" height="1094" fetchpriority="high" loading="eager"
                alt="A glazed composite front door beneath a canopy on a brick house">
        </div>
        <div class="fg-cdoor-shell fg-cdoor-hero__inner">
            <div class="fg-cdoor-hero__copy">
                <p class="fg-cdoor-kicker">Composite doors in Milton Keynes</p>
                <h1 id="composite-title">Distinction composite doors</h1>
                <p class="fg-cdoor-lead">Distinction composite doors, made to your specification and fitted by our own team. Choose the style, colour and glass. We take care of the survey and installation.</p>
                <div class="fg-cdoor-actions">
                    <a class="button" href="#fenster-product-quote">Get a quote <span aria-hidden="true">↗</span></a>
                    <a class="button button--steel" href="<?php echo esc_url(home_url('/why-distinction/')); ?>">Why Distinction <span aria-hidden="true">↗</span></a>
                </div>
                <ul class="fg-cdoor-hero__facts" aria-label="Composite door facts">
                    <li><strong>44.5mm</strong><span>insulated slab</span></li>
                    <li><strong><?php echo (int) $door_count; ?></strong><span>door styles</span></li>
                    <li><strong>10 years</strong><span>installation guarantee</span></li>
                </ul>
                <div class="fg-cdoor-hero__credential">
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/partners/distinction-doors.png'); ?>" alt="Distinction Doors" width="473" height="107">
                    <p>Approved installer<br><span>Our surveyors. Our fitters. Your door.</span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-cdoor-section fg-cdoor-range" id="composite-range" aria-labelledby="composite-range-title" data-cdoor-range>
        <div class="fg-cdoor-shell">
            <header class="fg-cdoor-heading">
                <div><p class="fg-cdoor-kicker">Find your style</p><h2 id="composite-range-title"><?php echo (int) $door_count; ?> door styles.</h2></div>
                <p>Browse six collections. Open a style to choose its colour, glass and hardware in the quote tool.</p>
            </header>
            <div class="fg-cdoor-range__tools" hidden data-cdoor-range-tools>
                <div class="fg-cdoor-tabs" role="tablist" aria-label="Door collections">
                    <?php foreach ($collections as $index => $collection) : ?>
                        <button type="button" role="tab" id="cdoor-tab-<?php echo (int) $index; ?>" aria-controls="cdoor-collection-<?php echo (int) $index; ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>" data-cdoor-tab="<?php echo (int) $index; ?>"><?php echo esc_html($collection['name']); ?><span><?php echo count($collection['styles']); ?></span></button>
                    <?php endforeach; ?>
                </div>
                <label class="fg-cdoor-collection-select"><span>Door collection</span><select data-cdoor-collection-select><?php foreach ($collections as $index => $collection) : ?><option value="<?php echo (int) $index; ?>"><?php echo esc_html($collection['name'] . ' (' . count($collection['styles']) . ')'); ?></option><?php endforeach; ?></select></label>
                <label class="fg-cdoor-filter"><span>Glass in the door</span><select data-cdoor-glass><option value="">Any amount</option><option value="3">Lots of glass</option><option value="2">Some glass</option><option value="1">A little glass</option><option value="0">Solid door</option></select></label>
            </div>
            <?php foreach ($collections as $index => $collection) : ?>
                <div id="cdoor-collection-<?php echo (int) $index; ?>" class="fg-cdoor-range__collection" data-cdoor-collection="<?php echo (int) $index; ?>">
                    <h3 class="fg-cdoor-range__fallback"><?php echo esc_html($collection['name']); ?></h3>
                    <p class="fg-cdoor-range__description"><?php echo esc_html($collection['intro']); ?></p>
                    <ul class="fg-cdoor-range__grid">
                        <?php foreach ($collection['styles'] as $style) : ?>
                            <li data-cdoor-style data-glass="<?php echo (int) ($style['traits']['glass'] ?? 0); ?>">
                                <a href="<?php echo esc_url(fenster_composite_door_quote_url((string) $style['key'])); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr('Design and price ' . $style['name'] . ' (opens in a new tab)'); ?>">
                                    <img src="<?php echo esc_url($art . rawurlencode((string) $style['key']) . '.svg?v=' . $art_version); ?>" alt="" width="914" height="2013" loading="lazy">
                                    <span><?php echo esc_html(trim(preg_replace('/\s*\bPOA\b/i', '', $style['name']))); ?></span>
                                    <small><?php echo str_contains($style['name'], 'POA') ? 'Ask for a price' : 'Design & price'; ?> <span aria-hidden="true">↗</span></small>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="fg-cdoor-range__empty" data-cdoor-empty hidden><p>No styles in this collection have that amount of glass.</p><button type="button" data-cdoor-reset-glass>Show every style in this collection</button></div>
                </div>
            <?php endforeach; ?>
            <div class="fg-cdoor-range__footer" hidden data-cdoor-range-footer>
                <p data-cdoor-count role="status" aria-live="polite"></p>
                <div><button type="button" class="fg-cdoor-arrow" data-cdoor-prev aria-label="Previous door styles">←</button><button type="button" class="fg-cdoor-arrow" data-cdoor-next aria-label="Next door styles">→</button></div>
            </div>
            <p class="fg-cdoor-note">Matching glazed side panels can widen the entrance and bring more daylight into your hallway.</p>
        </div>
    </section>

    <div class="fg-cdoor-finishes" aria-label="Glass, colour and hardware choices">
        <section class="fg-cdoor-section" aria-labelledby="composite-glass-title">
            <div class="fg-cdoor-shell fg-cdoor-choice" data-cdoor-picker>
                <div class="fg-cdoor-choice__intro">
                    <p class="fg-cdoor-kicker">The finishing details</p>
                    <h2 id="composite-glass-title">Let the glass<br> set the character.</h2>
                    <p>From a quiet satin panel to bevels and decorative leadwork. The shape of your door sets the opening; the glass gives it its own detail.</p>
                </div>
                <figure class="fg-cdoor-choice__media">
                    <?php $photo($asset('glass-doors/' . $first_glass['slug'] . '-800w.webp'), 'A composite door with ' . $first_glass['name'] . ' decorative glass', 'fg-cdoor-choice__image'); ?>
                    <figcaption><strong data-cdoor-name><?php echo esc_html($first_glass['name']); ?></strong><span data-cdoor-kind>Decorative glass shown in a door</span></figcaption>
                </figure>
                <div class="fg-cdoor-choice__body">
                    <div class="fg-cdoor-glass-options" aria-label="Glass designs">
                        <?php foreach ($glass_doors as $index => $glass) : ?>
                            <button type="button" data-cdoor-choice data-image="<?php echo esc_url($asset('glass-doors/' . $glass['slug'] . '-800w.webp')); ?>" data-name="<?php echo esc_attr($glass['name']); ?>" data-kind="<?php echo in_array($glass['slug'], ['chatsworth', 'wentworth'], true) ? 'Double glazed decorative design' : 'Decorative glass shown in a door'; ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"><?php echo esc_html($glass['name']); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="fg-cdoor-patterns"><p>More decorative patterns</p><ul>
                        <?php foreach ($glass_patterns as $glass) : ?><li><?php $photo($glass['image'], $glass['name'] . ' glass pattern'); ?><span><?php echo esc_html($glass['name']); ?></span></li><?php endforeach; ?>
                    </ul></div>
                    <p class="fg-cdoor-note">Most decorative designs are triple glazed and laminated. Chatsworth and Wentworth are double glazed. The quote tool shows the options for your chosen door; we confirm availability before ordering.</p>
                </div>
            </div>
        </section>
        <section class="fg-cdoor-section" aria-labelledby="composite-colour-title">
            <div class="fg-cdoor-shell fg-cdoor-choice fg-cdoor-choice--reverse" data-cdoor-picker>
                <div class="fg-cdoor-choice__intro">
                    <p class="fg-cdoor-kicker">Colour</p><h2 id="composite-colour-title">A colour that belongs<br> on your home.</h2>
                    <p>Match the windows, pick up the brickwork or give the entrance a colour of its own. You can choose a different finish inside.</p>
                </div>
                <figure class="fg-cdoor-choice__media">
                    <?php $photo($first_colour['src'], $colours[0]['name'] . ' composite door', 'fg-cdoor-choice__image'); ?>
                    <figcaption><strong data-cdoor-name><?php echo esc_html($colours[0]['name']); ?></strong><span data-cdoor-kind><?php echo esc_html($first_colour['kind']); ?></span></figcaption>
                </figure>
                <div class="fg-cdoor-choice__body">
                    <div class="fg-cdoor-swatches" aria-label="Composite door colours">
                        <?php foreach ($colours as $index => $colour) : $preview = $colour_preview($colour); ?>
                            <button type="button" data-cdoor-choice data-image="<?php echo esc_url($preview['src']); ?>" data-name="<?php echo esc_attr($colour['name']); ?>" data-kind="<?php echo esc_attr($preview['kind']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                <?php if (! empty($colour['swatch'])) : ?>
                                    <img src="<?php echo esc_url($asset('palette/' . $colour['swatch'] . '-160w.webp')); ?>" alt="" width="160" height="160" loading="lazy">
                                <?php else : ?><i style="background:<?php echo esc_attr($colour['hex'] ?? '#ffffff'); ?>" aria-hidden="true"></i><?php endif; ?>
                                <span><?php echo esc_html($colour['name']); ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="fg-cdoor-note">This is a selection of the standard range. Any RAL colour can be matched beyond it. We bring physical swatches to your consultation so you can check the colour in your own light.</p>
                </div>
            </div>
        </section>
        <div class="fg-cdoor-section fg-cdoor-hardware">
            <div class="fg-cdoor-shell"><?php get_template_part('template-parts/components/handle-grid', null, fenster_door_handle_grid_args()); ?></div>
        </div>
    </div>

    <section class="fg-cdoor-section fg-cdoor-build" aria-labelledby="composite-build-title">
        <div class="fg-cdoor-shell">
            <div class="fg-cdoor-build__grid">
                <figure><?php $photo($asset('anatomy/slab-cutaway-trim-341w.webp'), 'Cutaway of the GRP skin, insulated core and reinforced structure of a Distinction composite door'); ?><figcaption>The layers inside a 44.5mm Distinction slab.</figcaption></figure>
                <div><p class="fg-cdoor-kicker">Built for everyday life</p><h2 id="composite-build-title">More to it than<br>a good first impression.</h2>
                    <p>The woodgrain comes from real oak. Beneath it, the slab combines insulation, reinforcement and water-resistant edges.</p>
                    <dl class="fg-cdoor-build__facts">
                        <div><dt>GRP outer skin</dt><dd>A textured, low-maintenance surface. Clean with warm water and a soft cloth.</dd></div>
                        <div><dt>Foam-filled core</dt><dd>Polyurethane insulation within the 44.5mm slab helps your entrance hold its heat.</dd></div>
                        <div><dt>Reinforced structure</dt><dd>Engineered wood stiles and a central board support the slab.</dd></div>
                        <div><dt>Water-resistant edges</dt><dd>Polymer rails protect the edges of the door through changing weather.</dd></div>
                    </dl>
                </div>
            </div>
            <div class="fg-cdoor-security"><strong><small>Up to</small>£5,000<span>Break-in guarantee</span></strong><p>Every door we fit has AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock. If either lock component fails in a break-in, you are covered for up to £5,000 in compensation. Terms apply and are confirmed before you order.</p></div>
        </div>
    </section>

    <section class="fg-cdoor-section fg-cdoor-distinction" aria-labelledby="composite-distinction-title">
        <div class="fg-cdoor-shell fg-cdoor-distinction__grid">
            <figure>
                <img src="<?php echo esc_url($asset('gallery/ruby-red-entrance-800w.webp')); ?>"
                    srcset="<?php echo esc_attr($asset('gallery/ruby-red-entrance-480w.webp') . ' 480w, ' . $asset('gallery/ruby-red-entrance-800w.webp') . ' 800w'); ?>"
                    sizes="(max-width: 600px) calc(100vw - 36px), 34vw" width="800" height="1000" loading="lazy" decoding="async"
                    alt="A red Distinction composite front door with decorative glass and a long brushed handle">
                <figcaption>A Distinction entrance door, shown with decorative glass and a long pull handle.</figcaption>
            </figure>
            <div class="fg-cdoor-distinction__content">
                <p class="fg-cdoor-kicker">Product information</p>
                <h2 id="composite-distinction-title">Why we fit Distinction composite doors.</h2>
                <p class="fg-cdoor-distinction__lede">Distinction make the door slab. We specify it as part of a complete doorset, with the frame, glass, threshold and locking chosen for your opening and fitted by our own team.</p>
                <dl class="fg-cdoor-distinction__facts">
                    <div><dt>Made in layers</dt><dd>A high-impact GRP skin, water-resistant polymer sub-frame, engineered timber reinforcement, central board and a CFC-free polyurethane core.</dd></div>
                    <div><dt>Independently tested</dt><dd>Distinction publish testing to BS 6375-1 for weather performance, with acoustic results of 26 dB OITC and 29 dB STC for the slab.</dd></div>
                    <div><dt>25-year slab warranty</dt><dd>The manufacturer covers the slab's structure and surface. Glass, hardware and our installation have their own terms and guarantees.</dd></div>
                    <div><dt>A proven UK system</dt><dd>Distinction report more than four million doors installed since 2004, accounting for one in four UK entrance doors.</dd></div>
                </dl>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/why-distinction/')); ?>">Read why we fit Distinction <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="fg-cdoor-section fg-cdoor-proof" aria-labelledby="composite-proof-title">
        <div class="fg-cdoor-shell fg-cdoor-proof__grid">
            <figure><?php $photo($asset('hero/fenster-mk-front-door-1280w.webp'), 'Our completed anthracite composite front door and glazed sidelight installation in Milton Keynes'); ?><figcaption>Milton Keynes · Fitted by our team</figcaption></figure>
            <div><p class="fg-cdoor-kicker">Fitted by us</p><h2 id="composite-proof-title">A different entrance.<br>The same home.</h2>
                <p>For this Milton Keynes home, we fitted an anthracite grey Rustic Renown style door with a full-height glazed sidelight. White on the inside keeps the hallway bright.</p>
                <p>We survey the opening, check the threshold and hardware, then return with our own installers. Your new door comes with a ten-year insurance-backed installation guarantee.</p>
                <a class="fg-cdoor-link" href="<?php echo esc_url(home_url('/case-studies/composite-front-door-milton-keynes/')); ?>">See this installation <span aria-hidden="true">↗</span></a>
                <?php if (! empty($reviews)) : $review = $reviews[0]; ?>
                    <blockquote class="fg-cdoor-review"><p>“<?php echo esc_html(wp_trim_words((string) ($review['quote'] ?? ''), 48, '…')); ?>”</p><footer><?php echo esc_html((string) ($review['author'] ?? 'Customer review')); ?> · Google review · <a href="<?php echo esc_url((string) (! empty($review['url']) ? $review['url'] : fenster_google_reviews_url())); ?>" target="_blank" rel="noopener">Read in full</a></footer></blockquote>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="fg-cdoor-section fg-cdoor-faq" aria-labelledby="composite-faq-title">
        <div class="fg-cdoor-shell fg-cdoor-faq__grid">
            <header><p class="fg-cdoor-kicker">Useful answers</p><h2 id="composite-faq-title">Before you choose.</h2><p>From fitted prices to colour and maintenance. If you want to talk through your own doorway, we can help.</p><a class="fg-cdoor-link" href="<?php echo esc_url(home_url('/composite-door-prices/')); ?>">Read the price guide <span aria-hidden="true">↗</span></a></header>
            <div><?php foreach ($content['faqs'] ?? [] as $faq) : ?><details><summary><?php echo esc_html($faq['question']); ?><span aria-hidden="true">+</span></summary><div><p><?php echo esc_html($faq['answer']); ?></p></div></details><?php endforeach; ?></div>
        </div>
    </section>

    <section class="fg-cdoor-section fg-cdoor-quote" id="fenster-product-quote" aria-labelledby="composite-quote-title">
        <div class="fg-cdoor-shell fg-cdoor-quote__grid">
            <div><p class="fg-cdoor-kicker">Put a price to it</p><h2 id="composite-quote-title">Your door.<br> Your specification.<br> Your quote.</h2><p>Choose the style, sizes, colour, glass and handles in our online tool. We confirm the final specification and price after survey.</p><p>If you would rather build the quote with us, <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">book a free consultation</a>.</p><a class="button fg-cdoor-quote__mobile" href="<?php echo esc_url($quote_url); ?>">Open the quote tool <span aria-hidden="true">↗</span></a></div>
            <div class="fg-cdoor-quote__card" data-quote-card>
                <div class="fg-cdoor-quote__toolbar"><span>Composite door designer</span><a href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener">Open in a new tab ↗</a></div>
                <div class="fg-cdoor-quote__frame" data-quote-frame-wrap data-quote-autoload="visible" data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>">
                    <div class="fg-cdoor-quote__placeholder"><span class="fg-cdoor-quote__outline" aria-hidden="true"></span><p data-cdoor-quote-status aria-live="polite">Opening your door designer…</p><a class="button" data-cdoor-quote-fallback hidden href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener">Open the door designer ↗</a><noscript><a href="<?php echo esc_url($quote_url); ?>">Open the quote tool</a></noscript></div>
                    <iframe data-quote-iframe-src="<?php echo esc_url($quote_url); ?>" title="Composite door quote tool" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <div class="fg-cdoor-assist fg-cdoor-shell">
        <details data-cdoor-assist>
            <summary><span><strong>Still choosing a style?</strong><span>Try the five-question door finder.</span></span><span aria-hidden="true">+</span></summary>
            <div>
                <?php get_template_part('template-parts/components/composite-door-quiz', null, [
                    'heading' => 'Find your door.',
                    'intro' => 'Five questions about your home and the details you like. We will suggest a style to start with.',
                    'result_heading' => 'Your starting point',
                    'open_label' => 'Design this door',
                    'embed_result' => false,
                    'caveat' => 'A starting point, based on your answers. You can explore all 142 styles in the range above.',
                ]); ?>
                <noscript><p><a href="#composite-range">Browse all door styles above</a>. The door finder needs JavaScript.</p></noscript>
            </div>
        </details>
    </div>

    <section class="fg-cdoor-section fg-cdoor-enquiry" id="fenster-enquiry" aria-labelledby="composite-enquiry-title">
        <div class="fg-cdoor-shell fg-cdoor-enquiry__grid"><div><p class="fg-cdoor-kicker">Talk to our team</p><h2 id="composite-enquiry-title">Tell us about<br>your front door.</h2><p>A photograph and rough sizes are useful. Send what you have, and we will help you choose the right style and specification.</p><div class="fg-cdoor-contact"><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $brand['phone'] ?? '')); ?>"><?php echo esc_html($brand['phone'] ?? ''); ?></a><a href="mailto:<?php echo esc_attr($brand['email'] ?? ''); ?>"><?php echo esc_html($brand['email'] ?? ''); ?></a></div><p class="fg-cdoor-note">Based in Milton Keynes. We also fit doors across Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. <a href="<?php echo esc_url(home_url('/areas-we-cover/')); ?>">See our service areas</a>.</p></div>
            <?php get_template_part('template-parts/components/enquiry-form', null, ['class' => 'fg-form fg-cdoor-form', 'source' => 'Composite Doors', 'button_label' => 'Send my door enquiry', 'project_type' => 'Composite doors', 'lock_project_type' => true, 'compact' => true]); ?>
        </div>
    </section>
</article>
<?php fenster_render_faq_page_schema($content['faqs'] ?? []); ?>
