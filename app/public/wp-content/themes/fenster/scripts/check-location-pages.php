<?php
/** Run with wp eval-file scripts/check-location-pages.php on the protected test site. */
if (! defined('ABSPATH') || ! defined('WP_CLI')) { exit(1); }
$errors = [];
$pages = fenster_location_matrix_pages();
$pages['double-glazing-milton-keynes'] = fenster_get_generated_page('double-glazing-milton-keynes');
$editorial = fenster_location_editorial();
$products = fenster_location_matrix_products();
if (array_diff_key($products, $editorial) !== [] || array_diff_key($editorial, $products) !== []) { $errors[] = 'Product editorial and route registry differ'; }
$checked_links = [];
$checked_images = [];
$totals = ['pages' => 0, 'images' => 0, 'links' => 0];
foreach ($pages as $slug => $page) {
    ob_start();
    get_template_part('template-parts/sections/location-service', null, ['page' => $page]);
    $html = (string) ob_get_clean();
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xp = new DOMXPath($doc);
    if ($xp->query('//h1')->length !== 1) { $errors[] = "$slug: expected one H1"; }
    if ($xp->query('//form')->length !== 1) { $errors[] = "$slug: expected one enquiry form"; }
    if ($xp->query('//*[@id="fenster-enquiry"]')->length !== 1) { $errors[] = "$slug: missing or duplicate enquiry anchor"; }
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
            }
            if (count($schema['mainEntity']) !== $xp->query('//details')->length) { $errors[] = "$slug: FAQ count differs"; }
        }
    }
    if ($faq_count !== 1) { $errors[] = "$slug: expected one FAQPage"; }
    $seen_images = [];
    foreach ($xp->query('//figure/img | //a/img') as $img) {
        $src = $img->getAttribute('src');
        $file = fenster_theme_asset_path_from_url($src);
        if ($file === '') { continue; }
        if (isset($seen_images[$file])) { $errors[] = "$slug: repeated photograph $src"; }
        $seen_images[$file] = true;
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
    $totals['pages']++;
}
echo wp_json_encode(['counts' => $totals, 'unique_links' => count($checked_links), 'unique_images' => count($checked_images), 'errors' => $errors], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
if ($errors !== []) { WP_CLI::halt(1); }
