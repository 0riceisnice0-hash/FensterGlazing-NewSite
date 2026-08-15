<?php
/**
 * Shared FAQ block: rendered questions plus the FAQPage JSON-LD for them.
 * ---------------------------------------------------------------------------
 * Built 2026-08-15 for the commercial set, which carried NO FAQ content and no
 * FAQPage markup on any of its thirteen routes while every residential product
 * page had both. That gap mattered more here than it looks: an extractable
 * question and answer is the format an answer engine quotes, and the commercial
 * audience arrives with exactly the kind of specific question a FAQ answers.
 *
 * ONE SOURCE FOR THE MARKUP AND THE SCHEMA, DELIBERATELY. The residential
 * version of this is still inline in `generated-page.php` and is not changed
 * here: that template is the most heavily used and most heavily owner-approved
 * file in the theme, and moving its FAQ rendering is a refactor with no visible
 * benefit and real regression risk. If it is ever worth unifying, this is the
 * component to unify onto, and the thing to watch is that route's FAQ LIMIT,
 * which has silently sliced correctly written answers off three routes.
 *
 * THERE IS NO LIMIT HERE, on purpose. The caller decides what to pass. A cap
 * that quietly drops the last question is the exact bug recorded against the
 * product template, and repeating it in a new component would be inexcusable.
 *
 * The answers are plain text and are escaped. Do not add HTML support: a FAQ
 * answer that carries markup also has to carry it into the JSON-LD, where it is
 * not valid, and the two would drift.
 *
 * Args:
 *   faqs     array<array{question: string, answer: string}>  required
 *   heading  string  the H2. Required; there is no sensible default.
 *   eyebrow  string  optional label above the heading.
 *   id       string  optional id for the aria-labelledby pair.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$faqs = isset($args['faqs']) && is_array($args['faqs']) ? array_values($args['faqs']) : [];

// Drop anything incomplete before it reaches the schema. A Question with an
// empty acceptedAnswer is invalid markup, and it is worth failing quietly here
// rather than publishing it.
$faqs = array_values(array_filter($faqs, static function ($faq): bool {
    return is_array($faq)
        && trim((string) ($faq['question'] ?? '')) !== ''
        && trim((string) ($faq['answer'] ?? '')) !== '';
}));

if (empty($faqs)) {
    return;
}

$faq_heading = (string) ($args['heading'] ?? '');
$faq_eyebrow = (string) ($args['eyebrow'] ?? '');
$faq_id = (string) ($args['id'] ?? 'fg-cm-faq-title');

// The schema comes from the shared emitter in `inc/generated-pages.php`, which
// every FAQ surface on the site now uses. This component owns the markup; it
// deliberately does not own a second copy of the JSON-LD.
fenster_render_faq_page_schema($faqs);
?>

<section class="fg-cm-faq" aria-labelledby="<?php echo esc_attr($faq_id); ?>">
    <div class="container fg-cm-faq__grid">
        <div>
            <?php if ($faq_eyebrow !== '') : ?>
                <p class="eyebrow"><?php echo esc_html($faq_eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($faq_heading !== '') : ?>
                <h2 class="fg-cm-faq__title" id="<?php echo esc_attr($faq_id); ?>"><?php echo esc_html($faq_heading); ?></h2>
            <?php endif; ?>
        </div>
        <div class="fg-product-faq__items">
            <?php foreach ($faqs as $index => $faq) : ?>
                <details <?php echo $index === 0 ? 'open' : ''; ?>>
                    <summary><?php echo esc_html($faq['question']); ?></summary>
                    <div class="fg-product-faq__answer">
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
