<?php
/**
 * The composite doors hero, in the shared product format (`fg-hero--compact`),
 * matching generated-page.php's product hero: eyebrow, H1, then the enquiry
 * button and the instant pricing button. `.fg-hero__intro` is hidden on compact
 * heroes, so there is no lead paragraph to write here.
 *
 * Args: image (URL), srcset (string).
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$hero_image = (string) ($args['image'] ?? '');
$hero_srcset = (string) ($args['srcset'] ?? '');
?>
<section class="fg-hero fg-hero--compact fg-hero--composite" aria-labelledby="composite-title">
    <?php if ($hero_image !== '') : ?>
        <img class="fg-hero__image" src="<?php echo esc_url($hero_image); ?>"<?php if ($hero_srcset !== '') : ?> srcset="<?php echo esc_attr($hero_srcset); ?>" sizes="100vw"<?php endif; ?> width="1400" height="1094" alt="A glazed composite front door beneath a canopy on a brick house" loading="eager" fetchpriority="high">
    <?php endif; ?>
    <div class="fg-hero__shade"></div>
    <div class="container fg-hero__inner">
        <div class="fg-hero__copy">
            <div class="fg-hero__heading">
                <p class="eyebrow"><?php esc_html_e('Composite doors in Milton Keynes', 'fenster'); ?></p>
                <h1 id="composite-title"><?php esc_html_e('Distinction composite doors', 'fenster'); ?></h1>
            </div>
            <div class="button-row">
                <a class="button" href="#fenster-enquiry">
                    <span class="fg-hero-cta__full"><?php esc_html_e('Send an enquiry', 'fenster'); ?></span>
                    <span class="fg-hero-cta__short"><?php esc_html_e('Send an enquiry', 'fenster'); ?></span>
                </a>
                <a class="button button--light" href="#fenster-product-quote"><?php esc_html_e('Instant pricing', 'fenster'); ?></a>
            </div>
        </div>
    </div>
</section>
