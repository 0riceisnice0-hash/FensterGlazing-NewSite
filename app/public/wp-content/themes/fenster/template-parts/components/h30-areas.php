<?php
/**
 * Where we work: the Homepage 3.0 coverage map, pinned with finished projects.
 *
 * Moved out of template-parts/sections/home-30.php (10/11/2026) so the homepage
 * A/B variants can show the same thing. It must sit inside a `.fg-h30` wrapper
 * (the 3.0 styles are scoped to it), and the page must load the home30 assets:
 * see fenster_h30_assets(). Its script starts itself when this markup is there.
 *
 * Args: map (fenster_h30_map_data()), title, notes (list of paragraphs), kicker.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$h30_map = (array) ($args['map'] ?? fenster_h30_map_data());
$h30_title = (string) ($args['title'] ?? 'Recent installs, pinned across the area we cover.');
$h30_kicker = (string) ($args['kicker'] ?? 'Where we work');
$h30_notes = array_values(array_filter(array_map('strval', (array) ($args['notes'] ?? [
    'Milton Keynes and everything around it: up to Northampton and Wellingborough, across to Bedford and Sandy, down through Stevenage and St Albans to Berkhamsted and Aylesbury, and out west to Brackley.',
    'Thousands of double glazing installations later, the green pins are the most recent ones we have written up. Click one to see the house.',
]))));
?>
        <section class="fg-h30-areas" aria-labelledby="fg-h30-areas-title">
            <!-- The map fills the section, which fills the screen. Loads when scrolled
                 into view; see src/home30/map.js. Renders on Google Maps when
                 FENSTER_GOOGLE_MAPS_KEY is set, Leaflet + OpenStreetMap when it is not. -->
            <div class="fg-h30-map" data-h30-map role="region" aria-label="Map of the area Fenster covers, with pins on completed projects">
                <p class="fg-h30-map__placeholder">Loading the map&hellip;</p>
            </div>
            <script type="application/json" id="fg-h30-map-data"><?php echo wp_json_encode($h30_map, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?></script>

            <div class="fg-h30-areas__panel" data-h30-map-panel>
                <?php if ($h30_kicker !== '') : ?><p class="fg-h30-kicker"><?php echo esc_html($h30_kicker); ?></p><?php endif; ?>
                <h2 id="fg-h30-areas-title"><?php echo esc_html($h30_title); ?></h2>
                <?php if ($h30_notes) : ?>
                    <!-- The count is the owner's own figure. The claim about the pins is
                         one the data actually supports: every residential case study is
                         pinned, so nothing newer is being held back. -->
                    <?php foreach ($h30_notes as $h30_note) : ?>
                        <p class="fg-h30-areas__note"><?php echo esc_html($h30_note); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <ul class="fg-h30-map__legend" aria-label="Map key">
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--line"></span> Our working area</li>
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--pin"></span> A finished project</li>
                    <li><span class="fg-h30-map__swatch fg-h30-map__swatch--showroom"></span> The showroom</li>
                </ul>
                <a class="fg-h30-head__more" href="<?php echo esc_url(home_url('/areas-we-cover/')); ?>">
                    Every area we cover
                    <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </section>
