<?php
/**
 * The configuration page middle.
 *
 * Renders whatever `fenster_configuration_page_data()` hands it, so this file is
 * shared: `french-doors` and `bow-bay-windows` are expected to use it next with
 * their own products, and neither should need a line changed here. See the head
 * of `inc/configuration-pages.php` for why a configuration is not a product.
 *
 * WHAT IT STANDS IN FOR. On a configuration route the generic journey's
 * `fg-product-why` and `fg-product-intel` are gated off, as are the Liniar
 * EnergyPlus tech banner and the uPVC colour chart -- all four describe one
 * material, and the whole point of the page is that the arrangement is not tied
 * to one. The shared tail below this (FAQs, process, quote, reviews, enquiry,
 * related links) still runs.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$config = is_array($args['config'] ?? null) ? $args['config'] : [];
if ($config === []) {
    return;
}

$product_names = function_exists('fenster_location_matrix_products') ? fenster_location_matrix_products() : [];
$mechanic = is_array($config['mechanic'] ?? null) ? $config['mechanic'] : [];
$products = is_array($config['products'] ?? null) ? $config['products'] : [];
$excluded = is_array($config['excluded'] ?? null) ? $config['excluded'] : [];
$egress = is_array($config['egress'] ?? null) ? $config['egress'] : [];
$detail = is_array($config['detail'] ?? null) ? $config['detail'] : [];
$media = is_array($args['media'] ?? null) ? $args['media'] : [];
?>

<?php if ($mechanic !== []) : ?>
    <section class="fg-cw-intro" aria-labelledby="fg-cfg-mechanic-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <?php if (! empty($media['mechanic']['src'])) : ?>
                <figure class="fg-cw-media">
                    <img <?php echo fenster_image_attr_string($media['mechanic']['src'], [
                        'alt' => (string) ($media['mechanic']['alt'] ?? ''),
                        'loading' => 'lazy',
                    ]); ?>>
                </figure>
            <?php endif; ?>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php echo esc_html((string) ($config['eyebrow'] ?? 'Configuration')); ?></p>
                <h2 id="fg-cfg-mechanic-title"><?php echo esc_html((string) ($mechanic['heading'] ?? '')); ?></h2>
                <p><?php echo esc_html((string) ($mechanic['copy'] ?? '')); ?></p>
                <?php if (! empty($mechanic['aside'])) : ?>
                    <p class="fg-cfg-aside"><?php echo esc_html((string) $mechanic['aside']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($products !== []) : ?>
    <?php /* THE BAND THE PAGE EXISTS FOR. Labels come from
             `fenster_location_matrix_products()` and images from
             `fenster_link_card_image()`, the same two sources the related band
             uses, so a product renamed once is renamed here too. */ ?>
    <section class="fg-cfg-products" aria-labelledby="fg-cfg-products-title">
        <div class="container">
            <div class="section-heading section-heading--wide">
                <p class="eyebrow"><?php esc_html_e('Where you can have it', 'fenster'); ?></p>
                <h2 id="fg-cfg-products-title"><?php echo esc_html((string) ($config['products_heading'] ?? '')); ?></h2>
                <?php if (! empty($config['products_copy'])) : ?>
                    <p><?php echo esc_html((string) $config['products_copy']); ?></p>
                <?php endif; ?>
            </div>
            <ul class="fg-cfg-products__grid">
                <?php foreach ($products as $product) : ?>
                    <?php
                    $product_slug = (string) ($product['slug'] ?? '');
                    if ($product_slug === '') {
                        continue;
                    }
                    $product_url = home_url('/' . $product_slug . '/');
                    $product_name = (string) ($product_names[$product_slug] ?? $product_slug);
                    $product_image = function_exists('fenster_link_card_image') ? fenster_link_card_image($product_url) : '';
                    ?>
                    <li class="fg-cfg-products__card">
                        <a href="<?php echo esc_url($product_url); ?>">
                            <?php if ($product_image !== '') : ?>
                                <span class="fg-cfg-products__media">
                                    <img <?php echo fenster_image_attr_string($product_image, [
                                        'alt' => sprintf(
                                            /* translators: %s: product name. */
                                            __('%s, which can be built as this configuration', 'fenster'),
                                            $product_name
                                        ),
                                        'loading' => 'lazy',
                                    ]); ?>>
                                </span>
                            <?php endif; ?>
                            <span class="fg-cfg-products__body">
                                <span class="fg-cfg-products__material"><?php echo esc_html((string) ($product['material'] ?? '')); ?></span>
                                <strong><?php echo esc_html($product_name); ?></strong>
                                <span class="fg-cfg-products__note"><?php echo esc_html((string) ($product['note'] ?? '')); ?></span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<?php if ($excluded !== []) : ?>
    <?php /* Saying what it CANNOT go on is not a caveat, it is the other half of
             the answer, and it is the half that otherwise turns up at survey. */ ?>
    <section class="fg-cfg-excluded" aria-labelledby="fg-cfg-excluded-title">
        <div class="container">
            <h2 id="fg-cfg-excluded-title" class="fg-cfg-excluded__title"><?php echo esc_html((string) ($config['excluded_heading'] ?? '')); ?></h2>
            <ul class="fg-cfg-excluded__list">
                <?php foreach ($excluded as $item) : ?>
                    <li>
                        <?php
                        $excluded_slug = (string) ($item['slug'] ?? '');
                        $excluded_name = (string) ($item['name'] ?? '');
                        ?>
                        <strong>
                            <?php if ($excluded_slug !== '') : ?>
                                <a href="<?php echo esc_url(home_url('/' . $excluded_slug . '/')); ?>"><?php echo esc_html($excluded_name); ?></a>
                            <?php else : ?>
                                <?php echo esc_html($excluded_name); ?>
                            <?php endif; ?>
                        </strong>
                        <span><?php echo esc_html((string) ($item['why'] ?? '')); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<?php if ($egress !== []) : ?>
    <section class="fg-cw-intro fg-cfg-egress" aria-labelledby="fg-cfg-egress-title">
        <div class="container fg-cw-split">
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Means of escape', 'fenster'); ?></p>
                <h2 id="fg-cfg-egress-title"><?php echo esc_html((string) ($egress['heading'] ?? '')); ?></h2>
                <p><?php echo esc_html((string) ($egress['copy'] ?? '')); ?></p>
                <?php if (! empty($egress['note'])) : ?>
                    <p class="fg-cfg-aside"><?php echo esc_html((string) $egress['note']); ?></p>
                <?php endif; ?>
            </div>
            <?php if (! empty($egress['criteria'])) : ?>
                <div class="fg-cfg-criteria">
                    <p class="fg-cfg-criteria__title"><?php echo esc_html((string) ($egress['criteria_heading'] ?? '')); ?></p>
                    <dl>
                        <?php foreach ((array) $egress['criteria'] as $criterion) : ?>
                            <div>
                                <dt><?php echo esc_html((string) ($criterion['label'] ?? '')); ?></dt>
                                <dd><?php echo esc_html((string) ($criterion['value'] ?? '')); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($detail !== []) : ?>
    <section class="fg-cw-intro fg-cfg-detail" aria-labelledby="fg-cfg-detail-title">
        <div class="container fg-cw-split fg-cw-split--media-first">
            <?php if (! empty($media['detail']['src'])) : ?>
                <figure class="fg-cw-media">
                    <img <?php echo fenster_image_attr_string($media['detail']['src'], [
                        'alt' => (string) ($media['detail']['alt'] ?? ''),
                        'loading' => 'lazy',
                    ]); ?>>
                </figure>
            <?php endif; ?>
            <div class="fg-cw-copy">
                <p class="eyebrow"><?php esc_html_e('Specification', 'fenster'); ?></p>
                <h2 id="fg-cfg-detail-title"><?php echo esc_html((string) ($config['detail_heading'] ?? '')); ?></h2>
                <dl class="fg-cfg-specs">
                    <?php foreach ($detail as $spec) : ?>
                        <div>
                            <dt><?php echo esc_html((string) ($spec['label'] ?? '')); ?></dt>
                            <dd><?php echo esc_html((string) ($spec['value'] ?? '')); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <?php if (! empty($config['colours']['copy'])) : ?>
                    <p class="fg-cfg-aside"><?php echo esc_html((string) $config['colours']['copy']); ?></p>
                    <?php if (! empty($config['colours']['links'])) : ?>
                        <p class="fg-cfg-colour-links">
                            <?php foreach ((array) $config['colours']['links'] as $index => $link) : ?>
                                <?php if ($index > 0) : ?><span aria-hidden="true">·</span><?php endif; ?>
                                <a class="text-link" href="<?php echo esc_url(home_url('/' . (string) ($link['slug'] ?? '') . '/')); ?>"><?php echo esc_html((string) ($link['label'] ?? '')); ?></a>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
