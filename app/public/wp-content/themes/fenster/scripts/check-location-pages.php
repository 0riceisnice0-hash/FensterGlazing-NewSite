<?php
/** Run with wp eval-file scripts/check-location-pages.php on the protected test site. */
if (! defined('ABSPATH') || ! defined('WP_CLI')) { exit(1); }
$errors = [];
$pages = fenster_location_matrix_pages();
$pages['double-glazing-milton-keynes'] = fenster_get_generated_page('double-glazing-milton-keynes');
$pages = array_merge($pages, fenster_commercial_county_pages());
$editorial = fenster_location_editorial();
$products = fenster_location_matrix_products();
if (array_diff_key($products, $editorial) !== [] || array_diff_key($editorial, $products) !== []) { $errors[] = 'Product editorial and route registry differ'; }
$checked_links = [];
$checked_images = [];
$totals = ['pages' => 0, 'images' => 0, 'links' => 0];
foreach ($pages as $slug => $page) {
    $commercial = str_starts_with($slug, 'commercial-glazing-');
    $enquiry_id = $commercial ? 'commercial-county-enquiry' : 'fenster-enquiry';
    ob_start();
    get_template_part('template-parts/sections/' . ($commercial ? 'commercial-county' : 'location-service'), null, ['page' => $page]);
    $html = (string) ob_get_clean();
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xp = new DOMXPath($doc);
    if ($xp->query('//h1')->length !== 1) { $errors[] = "$slug: expected one H1"; }
    if ($xp->query('//form')->length !== 1) { $errors[] = "$slug: expected one enquiry form"; }
    if ($xp->query('//section[contains(concat(" ", normalize-space(@class), " "), " fg-local__hero ")]//form')->length !== 1) { $errors[] = "$slug: enquiry form is not in the hero"; }
    if ($xp->query('//section[contains(concat(" ", normalize-space(@class), " "), " fg-local__hero ")]//figure[contains(concat(" ", normalize-space(@class), " "), " fg-local__hero-media ")]')->length !== 0) { $errors[] = "$slug: hero still contains the replaced image"; }
    if ($xp->query('//*[@id="' . $enquiry_id . '"]')->length !== 1) { $errors[] = "$slug: missing or duplicate enquiry anchor"; }
    $ids = [];
    foreach ($xp->query('//*[@id]') as $element) {
        $id = $element->getAttribute('id');
        if (isset($ids[$id])) { $errors[] = "$slug: duplicate id $id"; }
        $ids[$id] = true;
    }
    $faq_count = 0;
    foreach ($xp->query('//script[@type="application/ld+json"]') as $script) {
        $schema = json_decode($script->textContent, true);
        if (! is_array($schema)) { $errors[] = "$slug: invalid JSON-LD"; continue; }
        if (($schema['@type'] ?? '') === 'FAQPage') {
            $faq_count++;
            foreach ($schema['mainEntity'] as $faq) {
                if (! str_contains(html_entity_decode(strip_tags($html)), $faq['name'])) { $errors[] = "$slug: schema question absent from page"; }
                if (! str_contains(html_entity_decode(strip_tags($html)), strip_tags($faq['acceptedAnswer']['text'] ?? ''))) { $errors[] = "$slug: schema answer absent from page"; }
            }
            if (count($schema['mainEntity']) !== $xp->query('//details')->length) { $errors[] = "$slug: FAQ count differs"; }
        }
    }
    if ($faq_count !== 1) { $errors[] = "$slug: expected one FAQPage"; }
    $seen_images = [];
    foreach ($xp->query('//img[not(ancestor::section[contains(@class,"fg-review-showcase")])]') as $img) {
        $src = $img->getAttribute('src');
        $file = fenster_theme_asset_path_from_url($src);
        if ($file === '') { continue; }
        $photo_key = fenster_location_photo_key($src);
        if (isset($seen_images[$photo_key])) { $errors[] = "$slug: repeated photograph $src"; }
        $seen_images[$photo_key] = true;
        if (! isset($checked_images[$file])) {
            if (! is_file($file)) { $errors[] = "$slug: missing image $src"; }
            $checked_images[$file] = true;
        }
        if ($img->getAttribute('alt') === '') { $errors[] = "$slug: image missing descriptive alt"; }
        foreach (explode(',', $img->getAttribute('srcset')) as $candidate) {
            $parts = preg_split('/\s+/', trim($candidate));
            if (empty($parts[0])) { continue; }
            $responsive_file = fenster_theme_asset_path_from_url($parts[0]);
            if (! is_file($responsive_file)) { $errors[] = "$slug: missing responsive image"; }
        }
        $totals['images']++;
    }
    foreach ($xp->query('//a[@href]') as $a) {
        $url = $a->getAttribute('href');
        if (str_starts_with($url, '#')) {
            if (! isset($ids[substr($url, 1)])) { $errors[] = "$slug: missing anchor $url"; }
            continue;
        }
        if (! str_starts_with($url, home_url('/'))) { continue; }
        $target = trim((string) wp_parse_url($url, PHP_URL_PATH), '/');
        if ($target === $slug) { $errors[] = "$slug: self-link"; }
        if (! isset($checked_links[$target])) {
            $redirect = fenster_redirect_target($target);
            if ($redirect === '' && ! is_array(fenster_get_generated_page($target))) { $errors[] = "$slug: unknown route $target"; }
            $checked_links[$target] = true;
        }
        $totals['links']++;
    }
    if (str_starts_with($slug, 'integral-blinds-') || str_starts_with($slug, 'roof-lanterns-')) {
        if (str_contains($html, '>Get an instant price<')) { $errors[] = "$slug: unpriceable product promises instant pricing"; }
    }
    if ($slug !== 'double-glazing-milton-keynes' && ($page['seo']['canonical'] ?? '') !== 'https://fensterglazing.com/' . $slug . '/') { $errors[] = "$slug: incorrect canonical"; }
    if (! $commercial && $slug !== 'double-glazing-milton-keynes') {
        $description = (string) ($page['seo']['meta_description'] ?? '');
        if (strlen($description) > 160 || ! str_ends_with($description, '.')) { $errors[] = "$slug: incomplete or overlong meta description"; }
    }
    $totals['pages']++;
}

$totals['price_guides'] = 0;
foreach (fenster_price_guide_pages() as $slug => $page) {
    ob_start();
    get_template_part('template-parts/sections/price-guide', null, ['page' => $page]);
    $html = (string) ob_get_clean();
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xp = new DOMXPath($doc);
    if ($xp->query('//h1')->length !== 1) { $errors[] = "$slug: expected one price guide H1"; }
    $checked = array_filter($page['examples'] ?? [], static fn ($example) => str_starts_with($example['price'] ?? '', '£'));
    if ($xp->query('//article[contains(@class,"fg-price-guide__example ")]')->length !== count($checked)) { $errors[] = "$slug: checked price example count differs"; }
    if (str_contains($html, 'To confirm from WindowCAD') || str_contains($html, 'prices as you go') || str_contains($html, 'watch the price build')) { $errors[] = "$slug: placeholder or inaccurate price flow copy"; }
    if ($checked === [] && str_contains($html, 'What do the example prices include?')) { $errors[] = "$slug: FAQ claims missing examples exist"; }
    if ($xp->query('//*[@data-quote-frame-wrap and @data-quote-url]')->length !== 1 || $xp->query('//iframe[@data-quote-iframe-src]')->length !== 1) { $errors[] = "$slug: quote loading hooks missing"; }
    $photos = [];
    foreach ($xp->query('//img') as $img) {
        $key = fenster_location_photo_key($img->getAttribute('src'));
        if (isset($photos[$key])) { $errors[] = "$slug: repeated price guide image"; }
        $photos[$key] = true;
        if (! is_file(fenster_theme_asset_path_from_url($img->getAttribute('src')))) { $errors[] = "$slug: missing price guide image"; }
    }
    $totals['price_guides']++;
}
echo wp_json_encode(['counts' => $totals, 'unique_links' => count($checked_links), 'unique_images' => count($checked_images), 'image_files' => array_keys($checked_images), 'errors' => $errors], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
if ($errors !== []) { WP_CLI::halt(1); }
