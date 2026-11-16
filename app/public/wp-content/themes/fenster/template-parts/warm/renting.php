<?php
/**
 * Winter guide: renting, and the letter to the landlord.
 *
 * Two halves. The three points say what a tenant may do, what the landlord
 * must do and what is changing. The letter tool beside them turns a few ticks
 * into a letter the tenant sends themselves.
 *
 * The letter tool is a calculator, not an enquiry form: there is no <form>, no
 * action and no submit, and nothing typed into it leaves the browser. With
 * JavaScript off the controls stay hidden and an example letter, built here
 * from the defaults and fallbacks, is shown instead.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$renting = (array) ($warm['renting'] ?? []);
$letter = (array) ($renting['letter'] ?? []);
$letter_fields = (array) ($letter['fields'] ?? []);
$letter_template = (array) ($letter['template'] ?? []);
$letter_fallbacks = (array) ($letter['fallbacks'] ?? []);
$letter_defaults = (array) ($letter['defaults'] ?? []);
$letter_problems = (array) ($letter['problems'] ?? []);
$letter_asks = (array) ($letter['asks'] ?? []);
$default_problems = (array) ($letter_defaults['problems'] ?? []);
$default_asks = (array) ($letter_defaults['asks'] ?? []);

/* "a", "a and b", "a, b and c": the same join the browser uses. */
$letter_join = static function (array $items): string {
    $items = array_values(array_filter(array_map('strval', $items), 'strlen'));
    if (count($items) < 2) {
        return (string) ($items[0] ?? '');
    }
    $last = array_pop($items);

    return implode(', ', $items) . ' and ' . $last;
};

$letter_fill = static function (string $text, array $values): string {
    return (string) preg_replace_callback('/\{(\w+)\}/', static function ($m) use ($values) {
        return array_key_exists($m[1], $values) ? (string) $values[$m[1]] : $m[0];
    }, $text);
};

/* The example letter for readers without JavaScript: the defaults ticked and
   every field left empty, so it reads exactly as the live tool first does
   (less the date, which the browser adds). */
$example_problems = [];
foreach ($letter_problems as $problem) {
    if (in_array($problem['key'], $default_problems, true)) {
        $example_problems[] = $problem['text'];
    }
}
$example_asks = [];
foreach ($letter_asks as $ask) {
    if (in_array($ask['key'], $default_asks, true)) {
        $example_asks[] = $ask['text'];
    }
}
$example_values = [
    'landlord' => (string) ($letter_fallbacks['landlord'] ?? ''),
    'address' => (string) ($letter_fallbacks['address'] ?? ''),
    'rooms' => '',
    'problems' => $letter_join($example_problems),
    'asks' => $letter_join($example_asks),
];
$example_blocks = [
    [$letter_fill((string) $letter_template['greeting'], $example_values)],
    [$letter_fill((string) $letter_template['opening'], $example_values)],
    array_filter([
        $example_problems !== [] ? $letter_fill((string) $letter_template['problem'], $example_values) : '',
        $letter_fill((string) $letter_template['effect'], $example_values),
    ], 'strlen'),
    array_filter([$example_asks !== [] ? $letter_fill((string) $letter_template['ask'], $example_values) : ''], 'strlen'),
    [$letter_fill((string) $letter_template['access'], $example_values)],
];
$example_sign = array_filter([(string) $letter_template['sign'], (string) ($letter_fallbacks['tenant'] ?? '')], 'strlen');

/* What the browser needs to build the letter. Words only, all from the data. */
$letter_config = [
    'template' => $letter_template,
    'fallbacks' => $letter_fallbacks,
    'subject' => (string) ($letter['subject'] ?? ''),
    'problems' => array_column($letter_problems, 'text', 'key'),
    'asks' => array_column($letter_asks, 'text', 'key'),
    'copy' => (string) ($letter['copy_label'] ?? ''),
    'copied' => (string) ($letter['copied_label'] ?? ''),
];

$letter_inputs = [
    'tenant' => ['autocomplete' => 'name', 'placeholder' => ''],
    'landlord' => ['autocomplete' => 'off', 'placeholder' => ''],
    'address' => ['autocomplete' => 'street-address', 'placeholder' => ''],
    'rooms' => ['autocomplete' => 'off', 'placeholder' => (string) ($letter_fields['rooms_placeholder'] ?? '')],
];
?>
<section class="fg-warm-section fg-warm-renting" id="renting" aria-labelledby="fg-warm-renting-title" data-fg-warm-renting>
    <div class="container fg-warm-renting__grid">
        <div class="fg-warm-head">
            <p class="eyebrow"><?php echo esc_html($renting['eyebrow']); ?></p>
            <h2 id="fg-warm-renting-title"><?php echo esc_html($renting['title']); ?></h2>
            <p><?php echo esc_html($renting['intro']); ?></p>
        </div>

        <ul class="fg-warm-renting__points">
            <?php foreach ((array) $renting['points'] as $point) : ?>
                <li class="fg-warm-renting__point">
                    <h3><?php echo esc_html($point['title']); ?></h3>
                    <p><?php echo esc_html($point['copy']); ?></p>
                    <?php echo fenster_warm_source_line($warm, (string) $point['source']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper. ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="fg-warm-letter fg-warm-panel" id="renting-letter" aria-labelledby="fg-warm-letter-title" role="group" data-fg-warm-letter>
            <div class="fg-warm-letter__head">
                <h3 id="fg-warm-letter-title"><?php echo esc_html($letter['title']); ?></h3>
                <p><?php echo esc_html($letter['intro']); ?></p>
            </div>

            <?php
            /* Deliberately NOT a <form>: this is a calculator that builds text
               in the page. It has no action, never submits and sends nothing,
               which keeps the promise in the intro above and the site's rule
               against standalone enquiry forms. */
            ?>
            <div class="fg-warm-letter__controls" data-fg-warm-letter-controls hidden>
                <div class="fg-warm-letter__fields">
                    <?php foreach ($letter_inputs as $field_key => $field) : ?>
                        <div class="fg-warm-letter__field fg-warm-letter__field--<?php echo esc_attr($field_key); ?>">
                            <label for="fg-warm-letter-<?php echo esc_attr($field_key); ?>"><?php echo esc_html($letter_fields[$field_key] ?? ''); ?></label>
                            <input type="text" id="fg-warm-letter-<?php echo esc_attr($field_key); ?>" data-fg-warm-letter-field="<?php echo esc_attr($field_key); ?>" autocomplete="<?php echo esc_attr($field['autocomplete']); ?>"<?php echo $field['placeholder'] !== '' ? ' placeholder="' . esc_attr($field['placeholder']) . '"' : ''; ?> maxlength="160">
                        </div>
                    <?php endforeach; ?>
                </div>

                <fieldset class="fg-warm-letter__group">
                    <legend><?php echo esc_html($letter['problems_label']); ?></legend>
                    <div class="fg-warm-letter__chips">
                        <?php foreach ($letter_problems as $problem) : ?>
                            <label class="fg-warm-letter__chip">
                                <input type="checkbox" data-fg-warm-letter-problem value="<?php echo esc_attr($problem['key']); ?>"<?php echo in_array($problem['key'], $default_problems, true) ? ' checked' : ''; ?>>
                                <span class="fg-warm-letter__box" aria-hidden="true"></span>
                                <span><?php echo esc_html($problem['label']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset class="fg-warm-letter__group">
                    <legend><?php echo esc_html($letter['asks_label']); ?></legend>
                    <div class="fg-warm-letter__chips">
                        <?php foreach ($letter_asks as $ask) : ?>
                            <label class="fg-warm-letter__chip">
                                <input type="checkbox" data-fg-warm-letter-ask value="<?php echo esc_attr($ask['key']); ?>"<?php echo in_array($ask['key'], $default_asks, true) ? ' checked' : ''; ?>>
                                <span class="fg-warm-letter__box" aria-hidden="true"></span>
                                <span><?php echo esc_html($ask['label']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </div>

            <div class="fg-warm-letter__output">
                <p class="fg-warm-letter__label" id="fg-warm-letter-output"><?php echo esc_html($letter['output_label']); ?></p>
                <div class="fg-warm-letter__paper" role="region" aria-labelledby="fg-warm-letter-output" tabindex="0" data-fg-warm-letter-paper>
                    <?php foreach ($example_blocks as $block) : ?>
                        <?php if ($block !== []) : ?>
                            <p><?php echo esc_html(implode(' ', $block)); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <p class="fg-warm-letter__sign"><?php echo implode('<br>', array_map('esc_html', $example_sign)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each line escaped. ?></p>
                </div>
                <div class="fg-warm-letter__actions" data-fg-warm-letter-actions hidden>
                    <button type="button" class="fg-warm-letter__action fg-warm-letter__action--copy" data-fg-cta data-fg-warm-letter-copy><?php echo esc_html($letter['copy_label']); ?></button>
                    <button type="button" class="fg-warm-letter__action fg-warm-letter__action--email" data-fg-cta data-fg-warm-letter-email><?php echo esc_html($letter['email_label']); ?></button>
                    <button type="button" class="fg-warm-letter__action fg-warm-letter__action--print" data-fg-cta data-fg-warm-letter-print><?php echo esc_html($letter['print_label']); ?></button>
                </div>
                <p class="fg-warm-sr" role="status" aria-live="polite" data-fg-warm-letter-status></p>
            </div>
            <script type="application/json" data-fg-warm-letter-data><?php echo wp_json_encode($letter_config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON with tags hex-escaped. ?></script>
        </div>
    </div>
</section>
