<?php
/**
 * Care and maintenance guides for the window and door systems Fenster fits.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$asset = static function (string $path): string {
    return fenster_generated_url('/wp-content/themes/fenster/assets/' . ltrim($path, '/'));
};

$guides = [
    [
        'name' => 'Sheerline',
        'logo' => 'partners/sheerline.png',
        'role' => 'Aluminium windows and doors',
        'body' => 'Sheerline do not currently publish a maintenance guide. We checked their downloads page and searched their own site for "maintenance"; nothing came up beyond installation guides and brochures. Until they publish one, our general advice for aluminium frames applies: clean with mild soapy water, avoid abrasive pads and solvents, and keep the drainage slots along the bottom of the frame clear.',
        'link_url' => 'https://www.sheerline.com/',
        'link_label' => 'Visit Sheerline',
    ],
    [
        'name' => 'Liniar',
        'logo' => 'partners/liniar-logo.png',
        'role' => 'uPVC windows and doors',
        'body' => 'Liniar publish their own PVCu care advice: cleaning, what to use on stubborn marks, and how to keep hardware moving freely.',
        'link_url' => 'https://www.liniar.co.uk/articles/pvcu-maintenance-dos-and-donts',
        'link_label' => "Read Liniar's PVCu maintenance guide",
    ],
    [
        'name' => 'Roseview',
        'logo' => 'partners/roseview-logo-new.png',
        'role' => 'Sliding sash windows',
        'body' => "Roseview's own Operation and Maintenance Manual covers the Rose Collection: tilting the sashes to clean both faces of the glass, hardware care and seasonal checks.",
        'link_url' => 'https://dashboard.roseview.co.uk/storage/media/587/Rose%20Collection%20-%20Operation%20and%20Maintenance%20Manual_V4.0.pdf',
        'link_label' => 'Download the Roseview Operation and Maintenance Manual',
    ],
    [
        'name' => 'Distinction',
        'logo' => 'partners/distinction-doors.png',
        'role' => 'Composite doors',
        'body' => 'Distinction set out their door care as FAQ answers rather than a PDF: warm water and a lint-free cloth only, and no abrasives, pressure washers, bleach, solvents or repainting.',
        'link_url' => 'https://www.distinctiondoors.co.uk/faqs/',
        'link_label' => "Read Distinction's door care FAQs",
    ],
    [
        'name' => 'Notan',
        'logo' => 'partners/notan.png',
        'role' => 'Integrated blinds',
        'body' => "Notan's magnetic and electric blinds are designed to need very little attention: wipe the glass with a soft cloth and clear the blind itself with a soft brush or compressed air. They publish product brochures rather than a separate maintenance guide.",
        'link_url' => 'https://notan.co.uk/brochures/',
        'link_label' => "See Notan's brochures",
    ],
    [
        'name' => 'Slide & Fold Doors',
        'logo' => '',
        'role' => 'Track-mounted doors',
        'body' => 'Slide and fold doors run on a track rather than a hinge, so the track is what needs attention. Keep it clear of grit and leaves so the rollers do not bind, wipe the frame down with mild soapy water, and give the track a light silicone spray once a year to keep everything moving freely.',
        'link_url' => home_url('/slide-fold-doors/'),
        'link_label' => 'See our slide and fold doors',
        'external' => false,
    ],
];
?>

<div class="fg-fensa-page fg-guides-page">
    <article>
        <section class="fg-fensa-hero">
            <div class="container fg-fensa-hero__grid">
                <div class="fg-fensa-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Looking after what we fit', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Care and maintenance guides, by system.', 'fenster'); ?></h1>
                    <p class="fg-fensa-hero__lead"><?php esc_html_e('uPVC, aluminium and composite need different upkeep, so here is the actual guide for what is fitted rather than one generic leaflet. Where a manufacturer has not published a guide, we say so and give the general advice we give customers instead.', 'fenster'); ?></p>
                    <div class="fg-fensa-hero__actions">
                        <a class="button" href="#fenster-guides-enquiry"><?php esc_html_e("Not sure which system you have?", 'fenster'); ?></a>
                        <a class="fg-fensa-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-fensa-hero__assurance" aria-label="Systems covered on this page">
                    <p class="eyebrow"><?php esc_html_e('What this page covers', 'fenster'); ?></p>
                    <h2><?php esc_html_e('The systems we install.', 'fenster'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Sheerline aluminium windows and doors', 'fenster'); ?></li>
                        <li><?php esc_html_e('Liniar uPVC windows and doors', 'fenster'); ?></li>
                        <li><?php esc_html_e('Roseview sliding sash windows', 'fenster'); ?></li>
                        <li><?php esc_html_e('Distinction composite doors', 'fenster'); ?></li>
                        <li><?php esc_html_e('Notan integrated blinds', 'fenster'); ?></li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="fg-simple-content">
            <div class="container">
                <div class="fg-simple-section-head">
                    <p class="eyebrow"><?php esc_html_e('By manufacturer', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Find the guide for your system', 'fenster'); ?></h2>
                </div>
                <div class="fg-simple-grid">
                    <?php foreach ($guides as $guide) : ?>
                        <?php $is_external = (bool) ($guide['external'] ?? true); ?>
                        <article class="fg-simple-card">
                            <div>
                                <?php if ($guide['logo'] !== '') : ?>
                                    <span class="fg-product-hub__systems-logo">
                                        <img <?php echo fenster_image_attr_string($asset($guide['logo']), [
                                            'alt' => (string) $guide['name'],
                                            'loading' => 'lazy',
                                        ]); ?>>
                                    </span>
                                <?php endif; ?>
                                <h3><?php echo esc_html((string) $guide['name']); ?></h3>
                                <p class="fg-product-hub__systems-role"><?php echo esc_html((string) $guide['role']); ?></p>
                                <p><?php echo esc_html((string) $guide['body']); ?></p>
                                <a class="text-link" href="<?php echo esc_url((string) $guide['link_url']); ?>"<?php echo $is_external ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html((string) $guide['link_label']); ?></a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="fenster-guides-enquiry" class="fg-fensa-enquiry">
            <div class="container fg-fensa-enquiry__grid">
                <div class="fg-fensa-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e("Can't find your system?", 'fenster'); ?></p>
                    <h2><?php esc_html_e("Tell us what you're looking at and we'll point you in the right direction.", 'fenster'); ?></h2>
                    <p><?php esc_html_e("Send a photo of the hardware or frame profile if you're not sure who made it. We can usually identify the system and, if it's something we fit, the local supplier who can help with parts too.", 'fenster'); ?></p>
                    <p class="fg-fensa-enquiry__reassurance"><?php esc_html_e('No charge for the advice, whether or not it turns out to be ours.', 'fenster'); ?></p>
                </div>
                <div class="fg-fensa-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'Care and maintenance guides page',
                        'button_label' => 'Ask about your windows or doors',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
