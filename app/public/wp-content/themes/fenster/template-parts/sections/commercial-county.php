<?php
/** Commercial area enquiries: local copy from data/commercial-areas.json, real projects by distance. */
if (! defined('ABSPATH')) { exit; }
require_once FENSTER_THEME_DIR . '/inc/commercial-area-detail.php';
$page = (array) ($args['page'] ?? []);
$slug = (string) ($page['slug'] ?? '');
$county_slug = str_replace('commercial-glazing-', '', $slug);
$profiles = fenster_commercial_county_profiles();
$profile = $profiles[$county_slug] ?? null;
if (! is_array($profile)) { return; }
$county = (string) $profile['county'];
$place = fenster_commercial_area_place($county_slug, $county);
$detail = fenster_commercial_area_detail($county_slug);
$base_miles = fenster_commercial_area_base_miles($county_slug);
$projects = fenster_commercial_area_projects($county_slug);
$neighbours = fenster_commercial_area_neighbours($county_slug, $profiles);
$brand = (array) fenster_data('brand', []);
$phone = (string) $brand['phone'];
$phone_url = 'tel:' . preg_replace('/[^+0-9]/', '', $phone);
$products = fenster_commercial_product_pages();
$service_copy = [
    'commercial-windows-and-doors' => ['Commercial windows and doors', 'Aluminium and uPVC windows, doorsets and entrance screens. Send the opening schedule, frame and glazing requirements, hardware specification and proposed finishes.'],
    'curtain-walling' => ['Curtain walling', 'Facade glazing and entrance screens. Bring elevations, structural opening details, glass specifications and performance requirements to the design discussion.'],
    'commercial-replacement-glazing' => ['Replacement glazing', 'Replacement sealed units and larger panes in existing frames. Photographs, glass markings, approximate sizes and access details help define the scope.'],
    'louvre-vents' => ['Louvre vents', 'Louvred panels and plant-room doorsets. State the required airflow or free area, overall dimensions, colour and any acoustic requirements in the enquiry.'],
];
$services = [];
$used = [];
foreach ($projects as $project) {
    if (is_array($project['image'] ?? null)) { $used[fenster_location_photo_key((string) ($project['image']['src'] ?? ''))] = true; }
}
foreach ($service_copy as $service_slug => [$title, $copy]) {
    $data = $products[$service_slug] ?? [];
    $image = null;
    foreach (['hero', 'intro'] as $role) {
        $src = (string) ($data[$role . '_image'] ?? '');
        if ($src !== '' && ! isset($used[fenster_location_photo_key($src)]) && is_file(fenster_theme_asset_path_from_url($src))) {
            $image = ['src' => $src, 'alt' => (string) ($data[$role . '_alt'] ?? $title)];
            $used[fenster_location_photo_key($src)] = true;
            break;
        }
    }
    $services[] = ['slug' => $service_slug, 'title' => $title, 'copy' => $copy, 'image' => $image];
}
$faqs = [];
if (! empty($detail['q']) && ! empty($detail['a'])) {
    $faqs[] = ['question' => (string) $detail['q'], 'answer' => (string) $detail['a']];
}
$faqs[] = ['question' => 'Which parts of ' . $place . ' do you cover?', 'answer' => 'We review commercial projects across ' . $place . ', including ' . implode(', ', $profile['towns']) . '. Send the site postcode, scope and target dates so we can confirm the practical arrangements.'];
$faqs[] = ['question' => 'What do you need to prepare a commercial quotation?', 'answer' => 'Send the site address, drawings or photographs, an opening schedule and the required frame, glass and hardware specifications. Include performance targets, access restrictions and the programme where these are available.'];
$faqs[] = ['question' => 'Where can I see completed commercial projects?', 'answer' => 'Our commercial projects archive records the buildings, products and scope of our completed work, with photographs from the jobs. It includes education, workplace and accommodation projects.'];
$lead = (string) ($detail['lead'] ?? 'Windows, doors, curtain walling and replacement glazing for contractors, facilities managers and building owners.');
?>
<article class="fg-local fg-local--commercial">
    <section class="fg-local__hero"><div class="container fg-local__hero-grid"><div class="fg-local__hero-copy">
        <nav class="fg-local__crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>">Commercial glazing</a><span aria-hidden="true">/</span><span><?php echo esc_html($county); ?></span></nav>
        <h1><?php echo esc_html('Commercial glazing in ' . $place); ?></h1>
        <p class="fg-local__lead"><?php echo esc_html($lead); ?></p>
        <div class="button-row"><a class="button" href="#commercial-county-enquiry">Send a commercial enquiry</a><a class="button button--steel" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>">View our projects</a></div>
        <a class="button button--steel fg-local__phone" href="<?php echo esc_url($phone_url); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
    </div><aside class="fg-local__hero-form fg-local__form" id="commercial-county-enquiry" aria-labelledby="commercial-hero-enquiry-title">
        <h2 id="commercial-hero-enquiry-title">Tell us about your site</h2>
        <p>Attach drawings, photographs or schedules and tell us what you want priced.</p>
        <?php get_template_part('template-parts/components/enquiry-form', null, ['class' => 'fg-form', 'source' => 'Commercial glazing ' . $county, 'project_type' => 'Commercial glazing', 'show_company' => true, 'audience' => 'business', 'compact' => true, 'button_label' => 'Send project enquiry']); ?>
    </aside></div></section>
    <section class="fg-local__visit"><div class="container fg-local__visit-grid"><div>
        <h2><?php echo esc_html('Commercial buildings in ' . $place); ?></h2>
        <?php if (! empty($detail['buildings'])) : ?><p><?php echo esc_html((string) $detail['buildings']); ?></p><?php endif; ?>
        <?php if (! empty($detail['site'])) : ?><h3>Planning the work</h3><p><?php echo esc_html((string) $detail['site']); ?></p><?php endif; ?>
    </div><div class="fg-local__visit-details">
        <h3>Areas we cover</h3>
        <p><?php echo esc_html(implode(', ', $profile['towns']) . ' and the surrounding area.'); ?></p>
        <?php if ($base_miles > 0) : ?><p><?php echo esc_html('About ' . $base_miles . ' miles in a straight line from our base at Bradwell Abbey, Milton Keynes.'); ?></p><?php endif; ?>
        <h3>What to send us</h3>
        <ul><li>Site postcode, drawings and an opening schedule.</li><li>Glass, frame, hardware and performance requirements.</li><li>Access arrangements, project dates and phasing.</li></ul>
        <a href="<?php echo esc_url('mailto:' . $brand['commercial_email']); ?>"><?php echo esc_html($brand['commercial_email']); ?></a>
    </div></div></section>
    <?php if ($projects !== []) : ?>
    <section class="fg-local__range"><div class="container"><div class="fg-local__section-head"><h2>Our nearest projects</h2><a href="<?php echo esc_url(home_url('/commercial-projects/')); ?>">All commercial projects</a></div><div class="fg-local__range-grid">
        <?php foreach ($projects as $project) :
            $image = is_array($project['image'] ?? null) ? $project['image'] : null;
            $rounded = fenster_commercial_area_rounded_miles((float) $project['miles']);
            $where = (string) $project['location'] . ($rounded >= 5 ? ', about ' . $rounded . ' miles away' : '');
            ?><div><?php if ($image) : ?><a href="<?php echo esc_url((string) $project['url']); ?>"><img <?php echo fenster_location_image_attrs(['src' => (string) ($image['src'] ?? ''), 'alt' => (string) ($image['alt'] ?? $image['caption'] ?? $project['title'])], ['sizes' => '(max-width: 760px) calc(50vw - 24px), 290px']); ?>></a><?php endif; ?><h3><a href="<?php echo esc_url((string) $project['url']); ?>"><?php echo esc_html((string) $project['title']); ?></a></h3><p><?php echo esc_html($where); ?></p><p><?php echo esc_html((string) $project['summary']); ?></p></div><?php endforeach; ?>
    </div></div></section>
    <?php endif; ?>
    <section class="fg-local__range"><div class="container"><div class="fg-local__section-head"><h2>What we can price</h2></div><div class="fg-local__range-grid">
        <?php foreach ($services as $service) : ?><div><?php if ($service['image']) : ?><a href="<?php echo esc_url(home_url('/' . $service['slug'] . '/')); ?>"><img <?php echo fenster_location_image_attrs($service['image'], ['sizes' => '(max-width: 760px) calc(50vw - 24px), 290px']); ?>></a><?php endif; ?><h3><a href="<?php echo esc_url(home_url('/' . $service['slug'] . '/')); ?>"><?php echo esc_html($service['title']); ?></a></h3><p><?php echo esc_html($service['copy']); ?></p></div><?php endforeach; ?>
    </div></div></section>
    <?php fenster_render_faq_page_schema($faqs); ?>
    <section class="fg-local__faq"><div class="container fg-local__faq-grid"><div><h2>Common questions</h2></div><div><?php foreach ($faqs as $faq) : ?><details><summary><?php echo esc_html($faq['question']); ?></summary><p><?php echo esc_html($faq['answer']); ?></p></details><?php endforeach; ?></div></div></section>
    <?php if ($neighbours !== []) : ?>
    <section class="fg-local__links"><div class="container"><h2>Nearby areas</h2><?php get_template_part('template-parts/components/link-cards', null, ['show_images' => false, 'links' => $neighbours]); ?></div></section>
    <?php endif; ?>
    <section class="fg-local__links"><div class="container"><h2>Our commercial work</h2><?php get_template_part('template-parts/components/link-cards', null, ['show_images' => false, 'links' => [
        ['text' => 'Commercial glazing services', 'url' => home_url('/commercial-glazing/')],
        ['text' => 'Completed commercial projects', 'url' => home_url('/commercial-projects/')],
        ['text' => 'Constructionline Gold', 'url' => home_url('/constructionline-gold/')],
        ['text' => 'Health and safety', 'url' => home_url('/ssip-health-and-safety/')],
    ]]); ?></div></section>
</article>
