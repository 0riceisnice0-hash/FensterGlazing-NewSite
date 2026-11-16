<?php
/**
 * Winter guide: the picker. Four questions, one route onward.
 *
 * Every question is on screen at once, as a row of real radio buttons. The
 * first result in the data whose `when` matches every answer is shown, so the
 * order of the results is the logic. The postcode check sits under the result.
 *
 * Nothing here submits or stores anything: there is no <form>, and the answers
 * and the postcode stay in the page. With JavaScript off the questions stay
 * hidden and the catch-all result, the last in the list, is shown with its two
 * buttons, so the section still leads somewhere.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$picker = (array) ($warm['picker'] ?? []);
$picker_questions = (array) ($picker['questions'] ?? []);
$picker_results = array_values((array) ($picker['results'] ?? []));
$picker_postcode = (array) ($picker['postcode'] ?? []);
$picker_fallback = (array) end($picker_results);

/* What the browser needs. Links are escaped here, once. */
$picker_link = static function ($link): array {
    $link = (array) $link;

    return ['label' => (string) ($link['label'] ?? ''), 'url' => esc_url_raw((string) ($link['url'] ?? ''))];
};
$picker_config = [
    'results' => array_map(static function ($result) use ($picker_link) {
        return [
            'when' => (object) ($result['when'] ?? []),
            'title' => (string) ($result['title'] ?? ''),
            'copy' => (string) ($result['copy'] ?? ''),
            'primary' => $picker_link($result['primary'] ?? []),
            'secondary' => $picker_link($result['secondary'] ?? []),
        ];
    }, $picker_results),
    'postcode' => [
        'districts' => array_values((array) ($picker_postcode['districts'] ?? [])),
        'yes' => (string) ($picker_postcode['yes'] ?? ''),
        'near' => (string) ($picker_postcode['near'] ?? ''),
        'no' => (string) ($picker_postcode['no'] ?? ''),
        'invalid' => (string) ($picker_postcode['invalid'] ?? ''),
    ],
];
?>
<section class="fg-warm-section fg-warm-picker" id="next" aria-labelledby="fg-warm-picker-title" data-fg-warm-picker>
    <div class="container fg-warm-picker__grid">
        <div class="fg-warm-picker__ask">
            <div class="fg-warm-head">
                <p class="eyebrow"><?php echo esc_html($picker['eyebrow']); ?></p>
                <h2 id="fg-warm-picker-title"><?php echo esc_html($picker['title']); ?></h2>
                <p><?php echo esc_html($picker['intro']); ?></p>
            </div>

            <div class="fg-warm-picker__questions" data-fg-warm-picker-questions hidden>
                <?php foreach ($picker_questions as $question) : ?>
                    <fieldset class="fg-warm-picker__question" data-fg-warm-question="<?php echo esc_attr($question['key']); ?>">
                        <legend><?php echo esc_html($question['label']); ?></legend>
                        <div class="fg-warm-picker__options">
                            <?php foreach ((array) $question['options'] as $option) : ?>
                                <label class="fg-warm-picker__option">
                                    <input type="radio" name="fg-warm-picker-<?php echo esc_attr($question['key']); ?>" value="<?php echo esc_attr($option['key']); ?>">
                                    <span class="fg-warm-picker__dot" aria-hidden="true"></span>
                                    <span><?php echo esc_html($option['label']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>
                <?php endforeach; ?>
                <button type="button" class="fg-warm-picker__restart" data-fg-warm-picker-restart><?php echo esc_html($picker['restart_label']); ?></button>
            </div>
        </div>

        <div class="fg-warm-picker__panel fg-warm-panel">
            <div class="fg-warm-picker__hint" data-fg-warm-picker-hint hidden>
                <p class="eyebrow"><?php echo esc_html($picker['result_eyebrow']); ?></p>
                <p class="fg-warm-picker__hint-lead"><?php esc_html_e('Answer the four questions and our suggestion appears here.', 'fenster'); ?></p>
                <ul class="fg-warm-picker__progress">
                    <?php foreach ($picker_questions as $question) : ?>
                        <li data-fg-warm-picker-progress="<?php echo esc_attr($question['key']); ?>"><span class="fg-warm-picker__tick" aria-hidden="true"></span><?php echo esc_html($question['label']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="fg-warm-picker__result" data-fg-warm-picker-result>
                <p class="eyebrow"><?php echo esc_html($picker['result_eyebrow']); ?></p>
                <h3 data-fg-warm-picker-title><?php echo esc_html($picker_fallback['title'] ?? ''); ?></h3>
                <p class="fg-warm-picker__copy" data-fg-warm-picker-copy><?php echo esc_html($picker_fallback['copy'] ?? ''); ?></p>
                <div class="fg-warm-picker__actions">
                    <a class="button" href="<?php echo esc_url($picker_fallback['primary']['url'] ?? ''); ?>" data-fg-warm-picker-primary><?php echo esc_html($picker_fallback['primary']['label'] ?? ''); ?></a>
                    <a class="button button--steel" href="<?php echo esc_url($picker_fallback['secondary']['url'] ?? ''); ?>" data-fg-warm-picker-secondary><?php echo esc_html($picker_fallback['secondary']['label'] ?? ''); ?></a>
                </div>
            </div>
            <p class="fg-warm-sr" role="status" aria-live="polite" data-fg-warm-picker-status></p>

            <div class="fg-warm-picker__cover">
                <div class="fg-warm-picker__postcode" data-fg-warm-postcode hidden>
                    <label for="fg-warm-postcode"><?php echo esc_html($picker_postcode['label']); ?></label>
                    <div class="fg-warm-picker__postcode-row">
                        <input type="text" id="fg-warm-postcode" placeholder="<?php echo esc_attr($picker_postcode['placeholder']); ?>" autocomplete="postal-code" autocapitalize="characters" spellcheck="false" maxlength="10" data-fg-warm-postcode-input>
                        <button type="button" class="fg-warm-picker__check" data-fg-warm-postcode-check><?php echo esc_html($picker_postcode['button']); ?></button>
                    </div>
                    <p class="fg-warm-picker__verdict" role="status" aria-live="polite" data-fg-warm-postcode-message></p>
                </div>
                <a class="fg-warm-picker__areas" href="<?php echo esc_url($picker_postcode['areas_url']); ?>"><?php echo esc_html($picker_postcode['areas_label']); ?></a>
            </div>
        </div>
    </div>
    <script type="application/json" data-fg-warm-picker-data><?php echo wp_json_encode($picker_config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON with tags hex-escaped. ?></script>
</section>
