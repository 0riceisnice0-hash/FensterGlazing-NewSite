<?php
/**
 * Winter guide: the hero. One window, as you see it and as a thermal camera would.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$hero = (array) ($warm['hero'] ?? []);
?>
<section class="fg-warm-hero" aria-labelledby="fg-warm-title">
    <div class="container fg-warm-hero__grid">
        <div class="fg-warm-hero__copy">
            <p class="eyebrow"><?php echo esc_html($hero['eyebrow']); ?></p>
            <h1 id="fg-warm-title"><?php echo esc_html($hero['title']); ?></h1>
            <p class="fg-warm-hero__lead"><?php echo esc_html($hero['lead']); ?></p>
            <div class="fg-warm-hero__actions">
                <a class="button" href="#tonight"><?php esc_html_e('See tonight\'s fixes', 'fenster'); ?></a>
                <a class="button button--steel" href="#find"><?php esc_html_e('Find your draught', 'fenster'); ?></a>
            </div>
            <ul class="fg-warm-hero__facts">
                <?php foreach ((array) $hero['facts'] as $fact) : ?>
                    <li><strong><?php echo esc_html($fact['value']); ?></strong><span><?php echo esc_html($fact['label']); ?></span></li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-warm-source fg-warm-hero__byline">
                <?php echo esc_html($hero['byline']); ?>
                <?php
                /* translators: %s: month and year the guide was last checked. */
                printf(esc_html__('Updated %s.', 'fenster'), esc_html($warm['updated_label']));
                ?>
            </p>
        </div>
        <figure class="fg-warm-scope" data-fg-warm-scope>
            <div class="fg-warm-scope__stage">
                <svg class="fg-warm-scope__svg" viewBox="0 0 480 620" role="img" aria-label="<?php echo esc_attr($hero['scope_alt']); ?>">
                    <g class="fg-warm-scope__room"><?php echo fenster_warm_window_scene('room', 'fgw-hr') . fenster_warm_window_draughts(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></g>
                    <clipPath id="fgw-hero-wipe"><rect x="0" y="0" width="240" height="620" data-fg-warm-wipe/></clipPath>
                    <g class="fg-warm-scope__thermal" clip-path="url(#fgw-hero-wipe)"><?php echo fenster_warm_window_scene('thermal', 'fgw-ht'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></g>
                </svg>
                <span class="fg-warm-scope__handle" aria-hidden="true"><span></span></span>
                <span class="fg-warm-scope__tag fg-warm-scope__tag--thermal" aria-hidden="true"><?php esc_html_e('Thermal view', 'fenster'); ?></span>
                <span class="fg-warm-scope__tag fg-warm-scope__tag--room" aria-hidden="true"><?php esc_html_e('As you see it', 'fenster'); ?></span>
                <input class="fg-warm-scope__range" type="range" min="0" max="100" value="50" step="1" aria-label="<?php esc_attr_e('Move to reveal the thermal view', 'fenster'); ?>">
            </div>
            <figcaption><?php echo esc_html($hero['scope_caption']); ?> <span><?php echo esc_html($hero['scope_note']); ?></span></figcaption>
        </figure>
    </div>
    <?php
    /* The page in one line. A long guide needs a way to jump, and these are
       the in-page links a search result can show under the title. */
    ?>
    <nav class="container fg-warm-hero__nav" aria-label="<?php esc_attr_e('On this page', 'fenster'); ?>">
        <span><?php esc_html_e('On this page', 'fenster'); ?></span>
        <ul>
            <?php foreach ((array) $hero['nav'] as $link) : ?>
                <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</section>
