<?php
/**
 * Care and maintenance guides, selected by product.
 *
 * Progressive enhancement: every guide panel renders in the markup and the
 * JavaScript only hides the ones that are not selected. With JavaScript off the
 * page is one long readable document, which is the right fallback for something
 * somebody may well be reading on a phone in a cold porch.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$guides = function_exists('fenster_care_guides') ? fenster_care_guides() : [];

if ($guides === []) {
    return;
}

$groups = function_exists('fenster_care_guide_groups') ? fenster_care_guide_groups() : [];
$first_slug = (string) array_key_first($guides);
?>

<div class="fg-care-page">
    <article>
        <section class="fg-care-hero">
            <div class="container fg-care-hero__grid">
                <div class="fg-care-hero__copy">
                    <p class="eyebrow"><?php esc_html_e('Care and maintenance', 'fenster'); ?></p>
                    <h1><?php esc_html_e('Window and door care guides', 'fenster'); ?></h1>
                    <p class="fg-care-hero__lead"><?php esc_html_e('Pick what you have and you get the routine that keeps it working, the questions people actually ask us, and a straight answer on which bits are ours. Most of it is ten minutes with a cloth and an oil can.', 'fenster'); ?></p>
                    <p class="fg-care-hero__lead"><?php esc_html_e('Have a go at the steps first. If they do not sort it, tell us and we will come and look.', 'fenster'); ?></p>
                    <div class="fg-care-hero__actions">
                        <a class="button" href="#fenster-care-selector"><?php esc_html_e('Choose your product', 'fenster'); ?></a>
                        <a class="fg-care-hero__call" href="tel:01908429200"><?php esc_html_e('Call 01908 429200', 'fenster'); ?></a>
                    </div>
                </div>
                <aside class="fg-care-hero__rules" aria-labelledby="fg-care-rules-title">
                    <p class="eyebrow"><?php esc_html_e('True of everything we fit', 'fenster'); ?></p>
                    <h2 id="fg-care-rules-title"><?php esc_html_e('Four habits that cover most of it.', 'fenster'); ?></h2>
                    <ol>
                        <li>
                            <strong><?php esc_html_e('Warm soapy water and a soft cloth.', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Genuinely all any frame we fit asks for, twice a year.', 'fenster'); ?></span>
                        </li>
                        <li>
                            <strong><?php esc_html_e('Keep the drainage flowing.', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Rain is meant to get into a frame and back out through the slots along the bottom.', 'fenster'); ?></span>
                        </li>
                        <li>
                            <strong><?php esc_html_e('Oil the hinges and locks once a year.', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Light machine oil on hinges. Graphite or a PTFE spray in a lock cylinder.', 'fenster'); ?></span>
                        </li>
                        <li>
                            <strong><?php esc_html_e('Tracks like clean and dry.', 'fenster'); ?></strong>
                            <span><?php esc_html_e('A vacuum does more for a sliding door than anything that comes in a can.', 'fenster'); ?></span>
                        </li>
                    </ol>
                </aside>
            </div>
        </section>

        <section id="fenster-care-selector" class="fg-care-selector" data-fg-care-guides>
            <div class="container">
                <div class="fg-care-selector__head">
                    <p class="eyebrow"><?php esc_html_e('Pick your product', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Which one are you looking at.', 'fenster'); ?></h2>
                </div>

                <div class="fg-care-picker" role="tablist" aria-label="<?php esc_attr_e('Choose a product to see its care guide', 'fenster'); ?>">
                    <?php foreach ($groups as $group_name => $group_guides) : ?>
                        <div class="fg-care-picker__group">
                            <p class="fg-care-picker__group-title"><?php echo esc_html((string) $group_name); ?></p>
                            <div class="fg-care-picker__cards">
                                <?php foreach ($group_guides as $slug => $guide) : ?>
                                    <button
                                        type="button"
                                        class="fg-care-card"
                                        role="tab"
                                        id="fg-care-tab-<?php echo esc_attr($slug); ?>"
                                        aria-controls="fg-care-panel-<?php echo esc_attr($slug); ?>"
                                        aria-selected="<?php echo $slug === $first_slug ? 'true' : 'false'; ?>"
                                        data-fg-care-tab="<?php echo esc_attr($slug); ?>"
                                    >
                                        <span class="fg-care-card__media">
                                            <img <?php echo fenster_image_attr_string((string) ($guide['thumb'] ?? $guide['image']), [
                                                'alt' => '',
                                                'loading' => 'lazy',
                                            ]); ?>>
                                        </span>
                                        <span class="fg-care-card__label">
                                            <span class="fg-care-card__name"><?php echo esc_html((string) $guide['name']); ?></span>
                                            <span class="fg-care-card__covers"><?php echo esc_html((string) $guide['covers']); ?></span>
                                        </span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="fg-care-panels">
                    <?php foreach ($guides as $slug => $guide) : ?>
                        <section
                            class="fg-care-guide"
                            id="fg-care-panel-<?php echo esc_attr($slug); ?>"
                            role="tabpanel"
                            aria-labelledby="fg-care-tab-<?php echo esc_attr($slug); ?>"
                            tabindex="0"
                            data-fg-care-panel="<?php echo esc_attr($slug); ?>"
                        >
                            <header class="fg-care-guide__hero">
                                <img <?php echo fenster_image_attr_string((string) $guide['image'], [
                                    'alt' => (string) ($guide['image_alt'] ?? $guide['name']),
                                    'loading' => 'lazy',
                                ]); ?>>
                                <div class="fg-care-guide__hero-copy">
                                    <p class="fg-care-guide__covers"><?php echo esc_html((string) $guide['covers']); ?></p>
                                    <h3><?php echo esc_html((string) $guide['name']); ?></h3>
                                </div>
                            </header>

                            <div class="fg-care-guide__opening">
                                <p class="fg-care-guide__lead"><?php echo esc_html((string) $guide['intro']); ?></p>
                                <?php if (! empty($guide['kit'])) : ?>
                                    <div class="fg-care-kit">
                                        <p class="fg-care-kit__title"><?php esc_html_e('What you need', 'fenster'); ?></p>
                                        <ul>
                                            <?php foreach ((array) $guide['kit'] as $item) : ?>
                                                <li><?php echo esc_html((string) $item); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="fg-care-section">
                                <div class="fg-care-section__head">
                                    <p class="eyebrow"><?php esc_html_e('The routine', 'fenster'); ?></p>
                                    <h4><?php esc_html_e('Looking after it.', 'fenster'); ?></h4>
                                </div>
                                <div class="fg-care-routine">
                                    <?php foreach ((array) ($guide['routine'] ?? []) as $item) : ?>
                                        <article class="fg-care-step">
                                            <?php if (! empty($item['when'])) : ?>
                                                <span class="fg-care-step__when"><?php echo esc_html((string) $item['when']); ?></span>
                                            <?php endif; ?>
                                            <h5><?php echo esc_html((string) $item['title']); ?></h5>
                                            <p><?php echo esc_html((string) $item['body']); ?></p>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="fg-care-section">
                                <div class="fg-care-section__head">
                                    <p class="eyebrow"><?php esc_html_e('Worth knowing', 'fenster'); ?></p>
                                    <h4><?php esc_html_e('Things people ask us about.', 'fenster'); ?></h4>
                                </div>
                                <div class="fg-care-fixes">
                                    <?php foreach ((array) ($guide['fixes'] ?? []) as $index => $fix) : ?>
                                        <article class="fg-care-fix">
                                            <h5><?php echo esc_html((string) $fix['problem']); ?></h5>
                                            <ol>
                                                <?php foreach ((array) ($fix['steps'] ?? []) as $step) : ?>
                                                    <li><?php echo esc_html((string) $step); ?></li>
                                                <?php endforeach; ?>
                                            </ol>
                                            <?php if (! empty($fix['note'])) : ?>
                                                <p class="fg-care-fix__note"><?php echo esc_html((string) $fix['note']); ?></p>
                                            <?php endif; ?>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <?php if (! empty($guide['call_us'])) : ?>
                                <aside class="fg-care-callus">
                                    <div>
                                        <p class="eyebrow"><?php esc_html_e('Happy to take these on', 'fenster'); ?></p>
                                        <h4><?php esc_html_e('When to give us a shout.', 'fenster'); ?></h4>
                                        <p><?php echo esc_html((string) $guide['call_us']); ?></p>
                                    </div>
                                    <a class="button" href="#fenster-care-enquiry"><?php esc_html_e('Tell us what it is doing', 'fenster'); ?></a>
                                </aside>
                            <?php endif; ?>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-care-promise">
            <div class="container fg-care-promise__inner">
                <div>
                    <p class="eyebrow"><?php esc_html_e('If the steps do not sort it', 'fenster'); ?></p>
                    <h2><?php esc_html_e('We will come out and look at it.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Tell us what it is doing and what you have already tried. If we installed it and it is inside the guarantee, we sort it. If it is older, or somebody else fitted it, we will still come and tell you honestly what it needs.', 'fenster'); ?></p>
                    <p><?php esc_html_e('A photo or a short video saves a visit surprisingly often, because it usually tells us which part is involved before we set off.', 'fenster'); ?></p>
                </div>
                <div class="fg-care-promise__contact">
                    <a href="tel:01908429200"><?php esc_html_e('01908 429200', 'fenster'); ?></a>
                    <a href="mailto:info@fensterglazing.com"><?php esc_html_e('info@fensterglazing.com', 'fenster'); ?></a>
                    <p><?php esc_html_e('Showroom open Monday to Friday, 8.30am to 5pm. Phone lines open 24/7.', 'fenster'); ?></p>
                </div>
            </div>
        </section>

        <section id="fenster-care-enquiry" class="fg-care-enquiry">
            <div class="container fg-care-enquiry__grid">
                <div class="fg-care-enquiry__copy">
                    <p class="eyebrow"><?php esc_html_e('Tell us about it', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Send us the details.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Say which window or door it is, what it is doing, and which of the steps above you have already had a go at. That last part genuinely speeds things up, because it tells us where to start before we set off.', 'fenster'); ?></p>
                    <p class="fg-care-enquiry__reassurance"><?php esc_html_e('If we fitted it and it is inside the guarantee, there is nothing to pay.', 'fenster'); ?></p>
                </div>
                <div class="fg-care-enquiry__form">
                    <?php get_template_part('template-parts/components/enquiry-form', null, [
                        'class' => 'fg-form',
                        'source' => 'Care and maintenance guides page',
                        'button_label' => 'Send the details',
                        'project_type' => 'Existing windows or doors',
                        'compact' => true,
                    ]); ?>
                </div>
            </div>
        </section>
    </article>
</div>
