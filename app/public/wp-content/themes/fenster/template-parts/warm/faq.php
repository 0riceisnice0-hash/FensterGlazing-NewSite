<?php
/**
 * Winter guide: the questions people actually type.
 *
 * Rendered through the shared FAQ block, which owns both the markup and the
 * FAQPage JSON-LD, so the two cannot drift (`AI.md`, Generated SEO Rule). The
 * questions are worded the way they are asked of a search engine or an
 * assistant, and each answer leads with the answer.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$faq = (array) ($warm['faq'] ?? []);

if (empty($faq['items'])) {
    return;
}
?>
<div class="fg-warm-faq" id="questions">
    <?php
    get_template_part('template-parts/components/faq-block', null, [
        'faqs' => (array) $faq['items'],
        'heading' => (string) $faq['title'],
        'eyebrow' => (string) $faq['eyebrow'],
        'id' => 'fg-warm-faq-title',
    ]);
    ?>
</div>
