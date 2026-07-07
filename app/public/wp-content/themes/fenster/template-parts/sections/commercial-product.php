<?php
/**
 * Commercial product route template.
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
$phone_href = preg_replace('/\s+/', '', $brand_phone);
$title = (string) ($product['title'] ?? ($page['title'] ?? 'Commercial glazing'));
$subtitle = (string) ($product['subtitle'] ?? '');
$intro_heading = (string) ($product['intro_heading'] ?? ($title . ' for commercial buildings.'));
$summary = is_array($product['summary'] ?? null) ? array_values($product['summary']) : [];
$stats = is_array($product['stats'] ?? null) ? array_values($product['stats']) : [];
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
                <div class="fg-commercial-product-hero__actions">
                    <a class="button button--light" href="#commercial-product-enquiry"><?php esc_html_e('Send project details', 'fenster'); ?></a>
                    <a class="fg-commercial-product-hero__phone" href="tel:<?php echo esc_attr($phone_href); ?>">
                        <span><?php esc_html_e('Commercial enquiries', 'fenster'); ?></span>
                        <strong><?php echo esc_html($brand_phone); ?></strong>
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

    <section class="fg-commercial-product-intro">
        <div class="container fg-commercial-product-intro__grid">
            <?php if ($intro_image !== '') : ?>
                <figure class="fg-commercial-product-intro__media">
                    <img src="<?php echo esc_url(fenster_generated_url($intro_image)); ?>" alt="<?php echo esc_attr($intro_alt); ?>" loading="lazy">
                </figure>
            <?php endif; ?>
            <div class="fg-commercial-product-intro__copy">
                <p class="eyebrow"><?php esc_html_e('Scope of works', 'fenster'); ?></p>
                <h2><?php echo esc_html($intro_heading); ?></h2>
                <?php foreach ($summary as $line) : ?>
                    <p><?php echo esc_html((string) $line); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (! empty($capabilities)) : ?>
        <section class="fg-commercial-product-checks">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Commercial capability', 'fenster'); ?></p>
                    <h2><?php esc_html_e('What Fenster can check, supply and install.', 'fenster'); ?></h2>
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

    <?php if (! empty($detail_sections)) : ?>
        <section class="fg-commercial-product-details">
            <div class="container">
                <?php foreach ($detail_sections as $index => $detail) : ?>
                    <article class="fg-commercial-product-detail <?php echo $index % 2 === 1 ? 'fg-commercial-product-detail--flip' : ''; ?>">
                        <figure>
                            <img src="<?php echo esc_url(fenster_generated_url((string) ($detail['image'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($detail['alt'] ?? $title)); ?>" loading="lazy">
                        </figure>
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

    <section class="fg-commercial-product-fit">
        <div class="container fg-commercial-product-fit__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Common settings', 'fenster'); ?></p>
                <h2><?php esc_html_e('Buildings Fenster can look at for this type of work.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The final route depends on survey, access and the existing building, but these are typical places where this service applies.', 'fenster'); ?></p>
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
                    <h2><?php esc_html_e('Other commercial glazing work Fenster can look at.', 'fenster'); ?></h2>
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

    <section class="fg-commercial-enquiry" id="commercial-product-enquiry">
        <div class="container fg-commercial-enquiry__grid">
            <div class="fg-commercial-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Commercial enquiry', 'fenster'); ?></p>
                <h2><?php echo esc_html('Send Fenster your ' . strtolower($title) . ' brief.'); ?></h2>
                <p><?php esc_html_e('Attach drawings, schedules, site photographs or performance notes if you have them. A postcode and a short description is enough to start the conversation.', 'fenster'); ?></p>
                <ul class="fg-commercial-enquiry__notes">
                    <li><?php esc_html_e('Phone lines are open 24/7.', 'fenster'); ?></li>
                    <li><?php esc_html_e('The showroom and office team handle follow-up during working hours.', 'fenster'); ?></li>
                    <li><a href="mailto:<?php echo esc_attr($brand_email); ?>"><?php echo esc_html($brand_email); ?></a></li>
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
                    'Commercial automation',
                    'Replacement glazing',
                ],
                'show_company' => true,
                'lock_project_type' => true,
            ]);
            ?>
        </div>
    </section>
</article>
