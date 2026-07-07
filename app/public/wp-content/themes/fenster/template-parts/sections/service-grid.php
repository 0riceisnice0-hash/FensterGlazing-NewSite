<?php
/**
 * Service grid.
 *
 * @package Fenster
 */

$services = fenster_data('home.services', []);
?>
<section class="content-band">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow"><?php esc_html_e('Core services', 'fenster'); ?></p>
            <h2><?php esc_html_e('Windows, doors and glazing handled properly.', 'fenster'); ?></h2>
        </div>
        <div class="service-grid">
            <?php foreach ($services as $service) : ?>
                <article class="service-card">
                    <h3><?php echo esc_html($service); ?></h3>
                    <p><?php esc_html_e('Practical advice, careful measuring and clear product options from the first conversation through to installation.', 'fenster'); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
