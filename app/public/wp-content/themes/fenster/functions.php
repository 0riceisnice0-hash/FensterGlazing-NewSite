<?php
/**
 * Fenster theme bootstrap.
 *
 * Keep this file small. Put setup, assets, helpers, and hardcoded site data in inc/.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

define('FENSTER_THEME_VERSION', '0.1.0');
define('FENSTER_THEME_DIR', get_template_directory());
define('FENSTER_THEME_URI', get_template_directory_uri());

$fenster_required_files = [
    'inc/site-data.php',
    'inc/google-reviews.php',
    'inc/commercial-product-data.php',
    'inc/case-studies-data.php',
    'inc/product-hub-data.php',
    'inc/configuration-pages.php',
    'inc/care-guide-data.php',
    'inc/blog-posts.php',
    'inc/setup.php',
    'inc/security.php',
    // Must load before consent and tracking: both ask it whether this request
    // is a visitor worth measuring, and they have to get the same answer.
    'inc/traffic-classification.php',
    'inc/consent.php',
    'inc/legend-assistant.php',
    'inc/assets.php',
    'inc/template-tags.php',
    'inc/website-tracking.php',
    'inc/ad-attribution.php',
    'inc/enquiries.php',
    'inc/adminbase.php',
    'inc/google-ads-conversions.php',
    'inc/generated-pages.php',
    'inc/scan-links.php',
    /* HOMEPAGE 3.0, the Rightmove-UX homepage. Self-contained: this file,
       its template part, `src/home30/` and `assets/home30/`. It is host
       gated inside the file and live is deliberately not on the list, so a
       theme deploy cannot put it on production. Delete this line and those
       paths to remove it; the classic homepage comes back on its own. */
    'inc/home-30.php',
];

foreach ($fenster_required_files as $fenster_file) {
    require_once FENSTER_THEME_DIR . '/' . $fenster_file;
}
