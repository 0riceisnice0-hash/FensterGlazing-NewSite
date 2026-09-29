<?php
/**
 * "Where we fit": a product's page in every town of the location matrix,
 * Milton Keynes and its districts first, then the towns around it.
 *
 * Owner, 2026-09-28: "make google visit them". In the 30 days to 28 September
 * Google fetched 223 of the 525 town pages. 455 of them had a single link from
 * the rest of the site, one of 525 on /areas-we-cover/, which Google fetched
 * once in those 30 days. The product pages linked between 0 and 8 towns each,
 * and the homepage, fetched 115 times, linked five. This gives every town page
 * a link from its own product page, and the 25 double glazing town pages,
 * which link on to every other product in their town, a link from the
 * homepage and the Milton Keynes windows hub.
 *
 * Included from footer.php, where it is silent everywhere but the 20 product
 * pages of the matrix and /windows-milton-keynes/ (double glazing has no
 * product page of its own; the hub is its Milton Keynes page). The classic
 * homepage passes `product` itself.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('fenster_location_matrix_products') || ! function_exists('fenster_location_matrix_page')) {
    return;
}

$current = get_query_var('fenster_generated_page');
$current_slug = is_array($current) && isset($current['slug'])
    ? trim((string) $current['slug'], '/')
    : (function_exists('fenster_current_generated_slug') ? fenster_current_generated_slug() : '');
$products = fenster_location_matrix_products();
$product = (string) ($args['product'] ?? ($current_slug === 'windows-milton-keynes' ? 'double-glazing' : $current_slug));

if (! isset($products[$product])) {
    return;
}

$label = implode(' ', array_map(
    static fn (string $word): string => in_array($word, ['uPVC', 'French'], true) ? $word : strtolower($word),
    explode(' ', $products[$product])
));
$mk_page = $product === 'double-glazing' ? 'windows-milton-keynes' : $product;
$mk_districts = function_exists('fenster_milton_keynes_town_slugs') ? fenster_milton_keynes_town_slugs() : [];
$groups = ['Milton Keynes' => [], 'Towns nearby' => []];

if ($mk_page !== $current_slug) {
    $groups['Milton Keynes']['Milton Keynes'] = home_url('/' . $mk_page . '/');
}

foreach (fenster_location_matrix_towns() as $town_slug => $town_name) {
    if (is_array(fenster_location_matrix_page($product . '-' . $town_slug))) {
        $groups[isset($mk_districts[$town_slug]) ? 'Milton Keynes' : 'Towns nearby'][$town_name] = home_url('/' . $product . '-' . $town_slug . '/');
    }
}

$groups = array_filter($groups);

if ($groups === []) {
    return;
}
?>
<section class="fg-town-links" aria-labelledby="fg-town-links-title">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow"><?php esc_html_e('Where we fit', 'fenster'); ?></p>
            <h2 id="fg-town-links-title"><?php echo esc_html((str_starts_with($label, 'uPVC') ? $label : ucfirst($label)) . ' in Milton Keynes and the towns around it.'); ?></h2>
            <p><?php echo esc_html(in_array($product, ['integral-blinds', 'roof-lanterns'], true)
                ? 'Each town has its own page: the homes there and what to check before you order.'
                : 'Each town has its own page: the homes there, what to check before you order, and who to ask about permission.'); ?></p>
        </div>
        <div class="fg-town-links__groups">
            <?php foreach ($groups as $group => $links) : ?>
                <div>
                    <h3><?php echo esc_html($group); ?></h3>
                    <ul>
                        <?php foreach ($links as $town_name => $url) : ?>
                            <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($town_name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
