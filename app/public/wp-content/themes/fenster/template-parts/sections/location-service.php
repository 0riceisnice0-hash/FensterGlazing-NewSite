<?php
/** Residential landing pages: product decisions and honest local proof. */
if (! defined('ABSPATH')) { exit; }
$page = (array) ($args['page'] ?? []);
$slug = (string) ($page['slug'] ?? '');
$brand = (array) fenster_data('brand', []);
$towns = array_merge(['milton-keynes' => 'Milton Keynes'], fenster_location_matrix_towns());
$town_slug = '';
foreach ($towns as $key => $name) {
    if (str_ends_with($slug, '-' . $key)) { $town_slug = $key; break; }
}
$product_slug = $town_slug !== '' ? substr($slug, 0, -strlen('-' . $town_slug)) : '';
$editorial = fenster_location_editorial();
if (! isset($editorial[$product_slug], $towns[$town_slug])) { return; }
$content = $editorial[$product_slug];
$town = $towns[$town_slug];
$labels = fenster_location_matrix_products();
$label = str_replace(['Glazing', 'Casement', 'Windows', 'Flush', 'Sash', 'Sliding', 'Tilt', 'Turn', 'Bow', 'Bay', 'Heritage', 'Aluminium', 'Bifold', 'Doors', 'Slide', 'Fold', 'Composite', 'Integral', 'Blinds', 'Roof', 'Lanterns'], ['glazing', 'casement', 'windows', 'flush', 'sash', 'sliding', 'tilt', 'turn', 'bow', 'bay', 'heritage', 'aluminium', 'bifold', 'doors', 'slide', 'fold', 'composite', 'integral', 'blinds', 'roof', 'lanterns'], $labels[$product_slug]);
$heading = (str_starts_with($label, 'uPVC') ? $label : ucfirst($label)) . ' in ' . $town;
$label = str_starts_with($label, 'French') ? $label : lcfirst($label);
$is_double = $product_slug === 'double-glazing';
$can_price = fenster_quote_can_price($product_slug);
$quote_url = $is_double ? home_url('/online-quote/') : add_query_arg('product', $product_slug, home_url('/online-quote/'));
$phone = (string) $brand['phone'];
$phone_url = 'tel:' . preg_replace('/[^+0-9]/', '', $phone);
$process_steps = (array) fenster_data('order_process.steps', []);
$process_copy = (string) fenster_data('order_process.intro', '');
if (! $can_price) {
    $process_steps[0]['copy'] = 'Send photographs, approximate sizes and your postcode, or book a free consultation. We review the product and fitting requirements with you and prepare your quote.';
    $process_copy = 'Your specification and price first, then technical survey, installation and aftercare.';
}
$has_installation_cover = ! in_array($product_slug, ['integral-blinds', 'roof-lanterns'], true);
if (! $has_installation_cover) {
    $process_steps[3]['copy'] = (string) fenster_data('order_process.aftercare_outside_fensa_and_cpa', '');
}
$cases = fenster_case_studies_for_town($town_slug, 2);
$used = [];
$image_key = static fn (array $image): string => fenster_location_photo_key((string) ($image['src'] ?? ''));
// Reserve case-study photographs first. Product illustrations never claim a town.
foreach ($cases as $case) {
    if (is_array($case['image'] ?? null)) { $used[$image_key($case['image'])] = true; }
}
$take_image = static function (array $images) use (&$used, $image_key): ?array {
    foreach ($images as $image) {
        $key = $image_key($image);
        if ($key !== '' && ! isset($used[$key])) { $used[$key] = true; return $image; }
    }
    return null;
};
$images = fenster_location_images($product_slug);
$feature = $is_double ? $take_image((array) fenster_data('product_media.casement-windows.gallery', [])) : $take_image($images);
$tiles = [];
if ($is_double) {
    foreach ($content['related'] as $tile_slug) {
        $tiles[] = ['slug' => $tile_slug, 'label' => $labels[$tile_slug], 'image' => $take_image(fenster_location_images($tile_slug))];
    }
}
$suburb = fenster_mk_suburb_profiles()[$town_slug] ?? null;
$faqs = [
    ['question' => $content['question'], 'answer' => $content['answer']],
    ['question' => 'How do I get a price for ' . $label . '?', 'answer' => $can_price
        ? 'Build your price online using approximate sizes, or book a free consultation and we price the job with you. Both use the same software and price list. Once you decide to go ahead, a technical survey confirms the measurements and fitting details before anything is made.'
        : 'Send us photographs, approximate sizes and your postcode. We review the specification with you and prepare a quote. You can also book a free consultation to discuss the options at home.'],
    ['question' => 'Do you supply and fit in ' . $town . '?', 'answer' => 'Yes. We cover ' . $town . ' from our Milton Keynes base. Everyone who surveys and fits works for us. Tell us your postcode and what you want to change when you enquire.'],
    ['question' => 'When do you take the final measurements?', 'answer' => 'The technical survey takes place after you decide to go ahead and before manufacture. We check the dimensions, access, opening clearances and finishing details. Approximate sizes taken at a consultation are used for the quote.'],
    ['question' => 'Can I see samples before I choose?', 'answer' => 'Colour swatches come to your free consultation. Full product samples are at our Milton Keynes showroom, where you can compare the frames, handles and opening mechanisms in person.'],
];
$links = [];
$add_link = static function (string $target, string $text) use (&$links, $slug): void {
    if ($target !== $slug && is_array(fenster_get_generated_page($target))) { $links[$target] = ['text' => $text, 'url' => home_url('/' . $target . '/')]; }
};
$add_link($is_double ? 'windows-milton-keynes' : $product_slug, $is_double ? 'Compare all windows' : $labels[$product_slug] . ': full product guide');
if (! $is_double) { $add_link('double-glazing-' . $town_slug, 'Windows and doors in ' . $town); }
foreach ($content['related'] as $related_slug) {
    $target = isset($labels[$related_slug]) && $town_slug !== 'milton-keynes' ? $related_slug . '-' . $town_slug : $related_slug;
    $add_link($target, ($labels[$related_slug] ?? ucwords(str_replace('-', ' ', $related_slug))) . (str_ends_with($target, '-' . $town_slug) ? ' in ' . $town : ''));
}
if (fenster_price_guides_enabled()) {
    foreach (fenster_price_guide_pages() as $guide_slug => $guide) {
        if (($guide['product_slug'] ?? '') === $product_slug) { $add_link($guide_slug, (string) $guide['title']); break; }
    }
}
?>
<article class="fg-local generated-page generated-page--location" data-location-product="<?php echo esc_attr($product_slug); ?>">
    <section class="fg-local__hero"><div class="container fg-local__hero-grid">
        <div class="fg-local__hero-copy">
            <nav class="fg-local__crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url(home_url('/areas-we-cover/')); ?>">Areas we cover</a><span aria-hidden="true">/</span><span><?php echo esc_html($town); ?></span></nav>
            <p class="eyebrow">Supply and installation</p><h1><?php echo esc_html($heading); ?></h1>
            <p class="fg-local__lead"><?php echo esc_html($content['lead']); ?></p>
            <div class="button-row"><a class="button" href="<?php echo esc_url($can_price ? $quote_url : '#fenster-enquiry'); ?>"><?php echo esc_html($can_price ? 'Get an instant price' : 'Ask for a quote'); ?></a><a class="button" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Book a free consultation</a></div>
            <a class="button button--steel fg-local__phone" href="<?php echo esc_url($phone_url); ?>"><?php echo esc_html('Talk to us: ' . $phone); ?></a>
            <p class="fg-local__service-note"><?php echo esc_html('Serving ' . $town . ' from our Milton Keynes showroom.'); ?></p>
        </div>
        <aside class="fg-local__hero-form fg-local__form" id="fenster-enquiry" aria-labelledby="local-hero-enquiry-title">
            <p class="eyebrow">Request a quote</p>
            <h2 id="local-hero-enquiry-title"><?php echo esc_html('Ask about ' . $label . ' in ' . $town . '.'); ?></h2>
            <p>Send your postcode, rough sizes and any photographs you have. We will review the job and come back to you.</p>
            <?php get_template_part('template-parts/components/enquiry-form', null, ['class' => 'fg-form', 'source' => $labels[$product_slug] . ' - ' . $town, 'project_type' => $labels[$product_slug] . ' in ' . $town, 'project_options' => [$labels[$product_slug] . ' in ' . $town, 'Windows', 'Doors', 'Bifold or sliding doors', 'Repairs or replacement glass'], 'button_label' => 'Send enquiry', 'compact' => true]); ?>
        </aside>
    </div></section>
    <div class="container fg-local__reassurance" aria-label="Installation reassurance">
        <a href="<?php echo esc_url(home_url('/about/')); ?>"><strong>Our own installers</strong><span>From survey to fitting.</span></a>
        <a href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><strong>Free consultation</strong><span>Advice and colour samples at home.</span></a>
        <?php if ($has_installation_cover) : ?>
        <a href="<?php echo esc_url(home_url('/fensa-approved-installers/')); ?>"><strong>FENSA registered</strong><span>Certification for qualifying installations.</span></a>
        <a href="<?php echo esc_url(home_url('/consumer-protection-association/')); ?>"><strong>Ten year guarantee</strong><span>Insurance-backed cover on new windows and doors.</span></a>
        <?php else : ?>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>"><strong>Milton Keynes showroom</strong><span>See the product samples in person.</span></a>
        <a href="<?php echo esc_url(home_url('/about/')); ?>"><strong>Direct aftercare</strong><span>Speak to the team who fitted it.</span></a>
        <?php endif; ?>
    </div>
    <section class="fg-local__choices" id="product-options"><div class="container fg-local__choice-grid<?php echo ! $feature ? ' fg-local__choice-grid--text' : ''; ?>">
        <?php if ($feature) : ?><figure class="fg-local__feature"><img <?php echo fenster_location_image_attrs($feature); ?>><figcaption><?php echo esc_html($feature['alt']); ?></figcaption></figure><?php endif; ?>
        <div><p class="eyebrow"><?php echo esc_html($is_double ? 'What needs replacing?' : 'Choosing ' . $label); ?></p><h2><?php echo esc_html($content['heading']); ?></h2><div class="fg-local__decisions">
            <?php foreach ($content['decisions'] as [$decision_title, $copy, $target]) : ?><div><h3><?php echo esc_html($decision_title); ?></h3><p><?php echo esc_html($copy); ?></p><?php if (is_array(fenster_get_generated_page($target))) : ?><a href="<?php echo esc_url(home_url('/' . $target . '/')); ?>"><?php echo esc_html('View ' . strtolower($decision_title)); ?><span aria-hidden="true"> ↗</span></a><?php endif; ?></div><?php endforeach; ?>
        </div></div>
    </div></section>
    <?php if ($tiles !== []) : ?><section class="fg-local__range"><div class="container">
        <div class="fg-local__section-head"><div><p class="eyebrow">Windows and doors</p><h2>Compare the styles before choosing a finish.</h2></div><a href="<?php echo esc_url(home_url('/windows-milton-keynes/')); ?>">View all windows <span aria-hidden="true">↗</span></a></div>
        <div class="fg-local__range-grid"><?php foreach ($tiles as $tile) : ?><a href="<?php echo esc_url(home_url('/' . $tile['slug'] . '/')); ?>"><?php if ($tile['image']) : ?><img <?php echo fenster_location_image_attrs($tile['image'], ['sizes' => '(max-width: 760px) calc(50vw - 24px), 290px']); ?>><?php endif; ?><h3><?php echo esc_html($tile['label']); ?><span aria-hidden="true"> ↗</span></h3></a><?php endforeach; ?></div>
    </div></section><?php endif; ?>
    <section class="fg-local__visit"><div class="container fg-local__visit-grid">
        <div><p class="eyebrow"><?php echo esc_html('Your project in ' . $town); ?></p><h2>See the samples. Talk through the job.</h2><p><?php echo esc_html('We cover ' . $town . ' from our base in Milton Keynes. A free consultation brings advice and colour swatches to your home. For full-size product samples, visit the showroom.'); ?></p><a class="button" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>">Book a free consultation</a></div>
        <div class="fg-local__visit-details"><h3>Bring these to the conversation.</h3><ul><li>Photographs of the whole opening, inside and outside.</li><li>Approximate sizes and the postcode for the work.</li><li>Your preferred style, colour and anything you want to work differently.</li></ul><div class="fg-local__address"><span>Our showroom</span><p><?php echo esc_html(is_array($brand['address']) ? implode(', ', $brand['address']) : (string) $brand['address']); ?></p><a href="<?php echo esc_url(home_url('/contact/')); ?>">Opening times and directions <span aria-hidden="true">↗</span></a></div></div>
    </div></section>
    <?php if (is_array($suburb)) : ?><section class="fg-local__knowledge"><div class="container"><p class="eyebrow"><?php echo esc_html($town); ?></p><h2>Before choosing replacement windows.</h2><div class="fg-local__knowledge-grid"><p><?php echo esc_html($suburb['homes']); ?></p><p><?php echo esc_html($suburb['means']); ?></p><p><?php echo esc_html($suburb['check']); ?></p></div></div></section><?php endif; ?>
    <?php if ($cases !== []) : ?><section class="fg-local__cases"><div class="container"><div class="fg-local__section-head"><div><p class="eyebrow">Our work</p><h2>From our installation diary.</h2><p>The location, products and photographs from each job.</p></div><a href="<?php echo esc_url(home_url('/case-studies/')); ?>">All case studies <span aria-hidden="true">↗</span></a></div><div class="fg-local__case-grid"><?php foreach ($cases as $case) : ?><?php get_template_part('template-parts/components/case-study-card', null, ['card' => $case, 'heading' => 'h3', 'responsive_images' => true]); ?><?php endforeach; ?></div></div></section><?php endif; ?>
    <?php get_template_part('template-parts/components/order-process', null, ['class' => 'fg-local__process', 'steps' => $process_steps, 'copy' => $process_copy, 'action_label' => 'Send your project details', 'action_href' => '#fenster-enquiry']); ?>
    <?php fenster_render_faq_page_schema($faqs); ?>
    <section class="fg-local__faq"><div class="container fg-local__faq-grid"><div><p class="eyebrow">Your questions</p><h2><?php echo esc_html('Buying ' . $label . ' in ' . $town . '.'); ?></h2><p>Product choices, pricing and what happens before we fit.</p></div><div><?php foreach ($faqs as $faq) : ?><details><summary><?php echo esc_html($faq['question']); ?></summary><p><?php echo esc_html($faq['answer']); ?></p></details><?php endforeach; ?></div></div></section>
    <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-local__reviews', 'heading_override' => 'What our customers say.', 'limit' => 7, 'prioritise_context' => $product_slug]); ?>
    <?php if ($links !== []) : ?><section class="fg-local__links"><div class="container"><p class="eyebrow">Keep comparing</p><h2>Product guides and local services.</h2><?php get_template_part('template-parts/components/link-cards', null, ['links' => array_values($links), 'show_images' => false]); ?></div></section><?php endif; ?>
</article>
