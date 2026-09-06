<?php
/**
 * Named-technology banner.
 *
 * A shared strip for a system technology we sell the page around: Liniar
 * EnergyPlus on the uPVC routes, Sheerline Thermlock on the aluminium ones.
 * Follows the fg-composite-approved partner-banner pattern.
 *
 * Args:
 *   logo      string  Theme-relative path to the partner mark. Required.
 *   logo_alt  string  Alt text for the mark. Required.
 *   eyebrow   string  Short noun phrase above the name.
 *   title     string  The technology name as a customer would recognise it.
 *   copy      string  One or two plain sentences. No supplier phrasing.
 *   facts     array   Up to four ['value' => '', 'label' => ''] pairs.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$logo = (string) ($args['logo'] ?? '');
$logo_alt = (string) ($args['logo_alt'] ?? '');
$eyebrow = (string) ($args['eyebrow'] ?? '');
$title = (string) ($args['title'] ?? '');
$copy = (string) ($args['copy'] ?? '');
$facts = is_array($args['facts'] ?? null) ? array_slice($args['facts'], 0, 4) : [];

if ($logo === '' || $title === '') {
    return;
}
?>

<section class="fg-tech-banner" aria-label="<?php echo esc_attr($title); ?>">
    <div class="container fg-tech-banner__panel">
        <div class="fg-tech-banner__brand">
            <?php
            /* THE MARK MUST CARRY ITS OWN PIXEL SIZE OR IT SHIFTS THE PAGE.
               Found 2026-09-06 from "seems buggy on mobile, seems to skip
               around at points": the stylesheet sets `width: clamp(...)` and
               `height: auto`, so with no intrinsic size the box is 0px tall
               until the file arrives. It is `loading="lazy"`, so it arrives
               while the reader is roughly 2,000px above it, and the banner then
               snapped from 0 to ~40px and pushed EVERYTHING BELOW IT down by
               40px mid-scroll. Measured on the casement page: the document grew
               20,567 -> 20,606 and six landmark sections moved together.

               Read rather than hard-coded, because this component takes a
               different mark on every route -- EnergyPlus, Thermlock, Roseview,
               Distinction -- and their ratios differ. `fenster_image_dimensions`
               is the theme's own helper and statically caches per URL. */
            $logo_dimensions = function_exists('fenster_image_dimensions')
                ? fenster_image_dimensions($logo)
                : [];
            ?>
            <img
                class="fg-tech-banner__logo"
                src="<?php echo esc_url(fenster_generated_url($logo)); ?>"
                alt="<?php echo esc_attr($logo_alt); ?>"
                <?php if (! empty($logo_dimensions['width']) && ! empty($logo_dimensions['height'])) : ?>
                    width="<?php echo esc_attr((string) $logo_dimensions['width']); ?>"
                    height="<?php echo esc_attr((string) $logo_dimensions['height']); ?>"
                <?php endif; ?>
                loading="lazy"
                decoding="async"
            >
        </div>
        <div class="fg-tech-banner__copy">
            <?php if ($eyebrow !== '') : ?>
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <h3><?php echo esc_html($title); ?></h3>
            <?php if ($copy !== '') : ?>
                <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
        </div>
        <?php if (! empty($facts)) : ?>
            <dl class="fg-tech-banner__facts">
                <?php foreach ($facts as $fact) : ?>
                    <div>
                        <dt><?php echo esc_html((string) ($fact['value'] ?? '')); ?></dt>
                        <dd><?php echo esc_html((string) ($fact['label'] ?? '')); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>
    </div>
</section>
