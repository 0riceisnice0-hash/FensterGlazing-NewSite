<?php
/** Commercial county enquiries, using the current commercial product library. */
if (! defined('ABSPATH')) { exit; }
$page = (array) ($args['page'] ?? []);
$slug = (string) ($page['slug'] ?? '');
$county_slug = str_replace('commercial-glazing-', '', $slug);
$profile = fenster_commercial_county_profiles()[$county_slug] ?? null;
if (! is_array($profile)) { return; }
$county = (string) $profile['county'];
$brand = (array) fenster_data('brand', []);
$phone = (string) $brand['phone'];
$phone_url = 'tel:' . preg_replace('/[^+0-9]/', '', $phone);
$products = fenster_commercial_product_pages();
$window_data = $products['commercial-windows-and-doors'];
$service_copy = [
    'commercial-windows-and-doors' => ['Commercial windows and doors', 'Aluminium and uPVC windows, doorsets and entrance screens. Send the opening schedule, frame and glazing requirements, hardware specification and proposed finishes.'],
    'curtain-walling' => ['Curtain walling', 'Facade glazing and entrance screens. Bring elevations, structural opening details, glass specifications and performance requirements to the design discussion.'],
    'commercial-replacement-glazing' => ['Replacement glazing', 'Replacement sealed units and larger panes in existing frames. Photographs, glass markings, approximate sizes and access details help define the scope.'],
    'louvre-vents' => ['Louvre vents', 'Louvred panels and plant-room doorsets. State the required airflow or free area, overall dimensions, colour and any acoustic requirements in the enquiry.'],
];
$services = [];
$used = [];
foreach ($service_copy as $service_slug => [$title, $copy]) {
    $data = $products[$service_slug] ?? [];
    $image = null;
    foreach (['hero', 'intro'] as $role) {
        $src = (string) ($data[$role . '_image'] ?? '');
        if ($src !== '' && ! isset($used[$src]) && is_file(fenster_theme_asset_path_from_url($src))) {
            $image = ['src' => $src, 'alt' => (string) ($data[$role . '_alt'] ?? $title)];
            $used[$src] = true;
            break;
        }
    }
    $services[] = ['slug' => $service_slug, 'title' => $title, 'copy' => $copy, 'image' => $image];
}
$faqs = [
    ['question' => 'Which parts of ' . $county . ' do you cover?', 'answer' => 'We review commercial projects across ' . $county . ', including ' . implode(', ', $profile['towns']) . '. Send the site postcode, scope and target dates so we can confirm the practical arrangements.'],
    ['question' => 'What do you need to prepare a commercial quotation?', 'answer' => 'Send the site address, drawings or photographs, an opening schedule and the required frame, glass and hardware specifications. Include performance targets, access restrictions and the programme where these are available.'],
    ['question' => 'Can you work in occupied buildings?', 'answer' => 'We can plan the work around occupied sites, including phased access, segregated working areas, delivery timing and protection. Tell us how the building is used and any hours or dates that need to be considered.'],
    ['question' => 'Where can I see completed commercial projects?', 'answer' => 'Our commercial projects archive records the buildings, products and scope of our completed work, with photographs from the jobs. It includes education, workplace and accommodation projects.'],
];
?>
<article class="fg-local fg-local--commercial">
    <section class="fg-local__hero"><div class="container fg-local__hero-grid"><div class="fg-local__hero-copy">
        <nav class="fg-local__crumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url(home_url('/commercial-glazing/')); ?>">Commercial glazing</a><span aria-hidden="true">/</span><span><?php echo esc_html($county); ?></span></nav>
        <p class="eyebrow">Supply and installation</p><h1><?php echo esc_html('Commercial glazing in ' . $county); ?></h1>
        <p class="fg-local__lead">Windows, doors, curtain walling and replacement glazing for contractors, facilities managers and building owners. Send your drawings, schedules and site details to our commercial team.</p>
        <div class="button-row"><a class="button" href="#commercial-county-enquiry">Send a commercial enquiry</a><a class="button button--steel" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>">View our projects</a></div>
        <a class="button button--steel fg-local__phone" href="<?php echo esc_url($phone_url); ?>"><?php echo esc_html('Call ' . $phone); ?></a>
    </div><aside class="fg-local__hero-form fg-local__form" id="commercial-county-enquiry" aria-labelledby="commercial-hero-enquiry-title">
        <p class="eyebrow">Commercial enquiry</p>
        <h2 id="commercial-hero-enquiry-title"><?php echo esc_html('Tell us about your ' . $county . ' site.'); ?></h2>
        <p>Attach drawings, photographs or schedules and tell us what you want priced.</p>
        <?php get_template_part('template-parts/components/enquiry-form', null, ['class' => 'fg-form', 'source' => 'Commercial glazing ' . $county, 'project_type' => 'Commercial glazing', 'show_company' => true, 'audience' => 'business', 'compact' => true, 'button_label' => 'Send project enquiry']); ?>
    </aside></div></section>
    <section class="fg-local__range"><div class="container"><div class="fg-local__section-head"><div><p class="eyebrow">Define the scope</p><h2>The information that gets a quotation started.</h2></div></div><div class="fg-local__range-grid">
        <?php foreach ($services as $service) : ?><div><?php if ($service['image']) : ?><a href="<?php echo esc_url(home_url('/' . $service['slug'] . '/')); ?>"><img <?php echo fenster_location_image_attrs($service['image'], ['sizes' => '(max-width: 760px) calc(50vw - 24px), 290px']); ?>></a><?php endif; ?><h3><a href="<?php echo esc_url(home_url('/' . $service['slug'] . '/')); ?>"><?php echo esc_html($service['title']); ?></a></h3><p><?php echo esc_html($service['copy']); ?></p></div><?php endforeach; ?>
    </div></div></section>
    <section class="fg-local__visit"><div class="container fg-local__visit-grid"><div><p class="eyebrow">Site planning</p><h2>Agree the work around the building's use.</h2><p>Tell us which areas stay occupied, how deliveries reach the site and when the work can take place. We use that information to discuss phasing, protection and installation access with your team.</p><a class="button" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>">See completed projects</a></div><div class="fg-local__visit-details"><h3><?php echo esc_html('Projects across ' . $county . '.'); ?></h3><p><?php echo esc_html(implode(', ', $profile['towns']) . ' and the surrounding area.'); ?></p><h3>Include with your enquiry.</h3><ul><li>Site postcode, drawings and an opening schedule.</li><li>Glass, frame, hardware and performance requirements.</li><li>Access arrangements, project dates and phasing.</li></ul><a href="<?php echo esc_url('mailto:' . $brand['commercial_email']); ?>"><?php echo esc_html($brand['commercial_email']); ?></a></div></div></section>
    <?php fenster_render_faq_page_schema($faqs); ?>
    <section class="fg-local__faq"><div class="container fg-local__faq-grid"><div><p class="eyebrow">Commercial enquiries</p><h2>Before you send the specification.</h2></div><div><?php foreach ($faqs as $faq) : ?><details><summary><?php echo esc_html($faq['question']); ?></summary><p><?php echo esc_html($faq['answer']); ?></p></details><?php endforeach; ?></div></div></section>
    <section class="fg-local__links"><div class="container"><p class="eyebrow">Our commercial work</p><h2>Services, completed projects and credentials.</h2><?php get_template_part('template-parts/components/link-cards', null, ['show_images' => false, 'links' => [
        ['text' => 'Commercial glazing services', 'url' => home_url('/commercial-glazing/')],
        ['text' => 'Completed commercial projects', 'url' => home_url('/commercial-projects/')],
        ['text' => 'Constructionline Gold', 'url' => home_url('/constructionline-gold/')],
        ['text' => 'Health and safety', 'url' => home_url('/ssip-health-and-safety/')],
    ]]); ?></div></section>
</article>
