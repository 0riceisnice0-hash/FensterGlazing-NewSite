<?php
/**
 * Home hero.
 *
 * @package Fenster
 */

$home = fenster_data('home', []);
?>
<section class="home-hero">
    <div class="container home-hero__inner">
        <p class="eyebrow"><?php echo esc_html($home['eyebrow']); ?></p>
        <h1><?php echo esc_html($home['title']); ?></h1>
        <p class="home-hero__intro"><?php echo esc_html($home['intro']); ?></p>
        <div class="button-row">
            <a class="button" href="<?php echo esc_url($home['primary_cta']['url']); ?>"><?php echo esc_html($home['primary_cta']['label']); ?></a>
            <a class="button button--ghost" href="<?php echo esc_url($home['secondary_cta']['url']); ?>"><?php echo esc_html($home['secondary_cta']['label']); ?></a>
        </div>
    </div>
</section>
