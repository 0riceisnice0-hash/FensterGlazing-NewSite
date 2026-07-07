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
$summary = is_array($product['summary'] ?? null) ? array_values($product['summary']) : [];
$stats = is_array($product['stats'] ?? null) ? array_values($product['stats']) : [];
$checkpoints = is_array($product['checkpoints'] ?? null) ? array_values($product['checkpoints']) : [];
$gallery = is_array($product['gallery'] ?? null) ? array_values($product['gallery']) : [];
$use_cases = is_array($product['use_cases'] ?? null) ? array_values($product['use_cases']) : [];
$all_products = function_exists('fenster_commercial_product_pages') ? fenster_commercial_product_pages() : [];
$related_products = array_filter($all_products, static fn ($item, $item_slug): bool => $item_slug !== $slug, ARRAY_FILTER_USE_BOTH);
$related_products = array_slice($related_products, 0, 3, true);
$hero_image = (string) ($product['hero_image'] ?? '');
$hero_alt = (string) ($product['hero_alt'] ?? $title);
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
            <div>
                <p class="eyebrow"><?php esc_html_e('Project fit', 'fenster'); ?></p>
                <h2><?php echo esc_html('Plan ' . strtolower($title) . ' around the building, not a generic product list.'); ?></h2>
            </div>
            <div class="fg-commercial-product-intro__copy">
                <?php foreach ($summary as $line) : ?>
                    <p><?php echo esc_html((string) $line); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (! empty($checkpoints)) : ?>
        <section class="fg-commercial-product-checks">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Specification checkpoints', 'fenster'); ?></p>
                    <h2><?php esc_html_e('The questions worth answering before pricing.', 'fenster'); ?></h2>
                </div>
                <div class="fg-commercial-product-checks__grid">
                    <?php foreach ($checkpoints as $index => $checkpoint) : ?>
                        <article>
                            <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <h3><?php echo esc_html((string) ($checkpoint['title'] ?? '')); ?></h3>
                            <p><?php echo esc_html((string) ($checkpoint['copy'] ?? '')); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (! empty($gallery)) : ?>
        <section class="fg-commercial-product-gallery">
            <div class="container">
                <div class="fg-commercial-product-section-head">
                    <p class="eyebrow"><?php esc_html_e('Commercial glazing imagery', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Real project and system references.', 'fenster'); ?></h2>
                </div>
                <div class="fg-commercial-product-gallery__grid">
                    <?php foreach ($gallery as $index => $image) : ?>
                        <figure class="<?php echo $index === 0 ? 'is-large' : ''; ?>">
                            <img src="<?php echo esc_url(fenster_generated_url((string) ($image['src'] ?? ''))); ?>" alt="<?php echo esc_attr((string) ($image['alt'] ?? $title)); ?>" loading="lazy">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-commercial-product-fit">
        <div class="container fg-commercial-product-fit__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Where it fits', 'fenster'); ?></p>
                <h2><?php esc_html_e('Common commercial settings.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Every site still needs a proper review, but these are the kinds of projects where this package usually belongs.', 'fenster'); ?></p>
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
                    <p class="eyebrow"><?php esc_html_e('Related commercial routes', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Keep the package connected.', 'fenster'); ?></h2>
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
            ]);
            ?>
        </div>
    </section>
</article>
