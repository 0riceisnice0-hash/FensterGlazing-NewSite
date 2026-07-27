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
    'inc/window-product-data.php',
    'inc/setup.php',
    'inc/security.php',
    'inc/consent.php',
    'inc/legend-assistant.php',
    'inc/assets.php',
    'inc/template-tags.php',
    'inc/website-tracking.php',
    'inc/enquiries.php',
    'inc/adminbase.php',
    'inc/generated-pages.php',
];

foreach ($fenster_required_files as $fenster_file) {
    require_once FENSTER_THEME_DIR . '/' . $fenster_file;
}
