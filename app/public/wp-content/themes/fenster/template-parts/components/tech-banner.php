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
            <img
                class="fg-tech-banner__logo"
                src="<?php echo esc_url(fenster_generated_url($logo)); ?>"
                alt="<?php echo esc_attr($logo_alt); ?>"
                loading="lazy"
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
