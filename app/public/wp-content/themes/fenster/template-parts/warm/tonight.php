<?php
/**
 * Winter guide: five things to do tonight.
 *
 * Every panel is in the markup. With JavaScript off they stack and read as a
 * list; with it on, the list on the left picks one and its drawing plays once.
 * Not numbered, on purpose: STYLE.md asks that steps and choices never are.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$tonight = (array) ($warm['tonight'] ?? []);
$items = (array) ($tonight['items'] ?? []);

if ($items === []) {
    return;
}

/* The five drawings. Each is 240 x 180, drawn in the same hand as the window
   in the hero, and each has one moving part (class `fgw-move`) that the
   stylesheet animates when its panel becomes the active one. */
$drawings = [
    'curtains' => '
        <rect x="76" y="30" width="88" height="104" rx="2" fill="#fff" stroke="#b9c8c8"/>
        <rect x="84" y="38" width="33" height="88" fill="#3d5f7c"/><rect x="123" y="38" width="33" height="88" fill="#3d5f7c"/>
        <circle cx="142" cy="58" r="8" fill="#f4ecd0"/><circle cx="96" cy="52" r="1.4" fill="#fff"/><circle cx="106" cy="76" r="1.2" fill="#fff"/><circle cx="134" cy="92" r="1.3" fill="#fff"/>
        <rect x="84" y="80" width="72" height="5" fill="#fff"/>
        <rect x="66" y="134" width="108" height="8" rx="3" fill="#fff" stroke="#b9c8c8"/>
        <rect x="84" y="150" width="72" height="22" rx="4" fill="#fff" stroke="#b9c8c8"/>
        <path d="M92 150v22M100 150v22M108 150v22M116 150v22M124 150v22M132 150v22M140 150v22M148 150v22" stroke="#c9d6d6"/>
        <rect x="52" y="20" width="136" height="4" rx="2" fill="#002d3a"/>
        <g class="fgw-move fgw-move--curtain-l"><path d="M58 24h62c2 38-2 74 0 110H58c3-36-3-72 0-110z" fill="#4c7b86"/><path d="M72 24c2 40-2 76 0 110M88 24c2 40-2 76 0 110M104 24c2 40-2 76 0 110" stroke="#3a6570" fill="none"/></g>
        <g class="fgw-move fgw-move--curtain-r"><path d="M120 24h62c3 38-3 74 0 110h-62c2-36-2-72 0-110z" fill="#4c7b86"/><path d="M136 24c2 40-2 76 0 110M152 24c2 40-2 76 0 110M168 24c2 40-2 76 0 110" stroke="#3a6570" fill="none"/></g>
        <path class="fgw-heat" d="M100 146c-3-5 3-7 0-12M120 146c-3-5 3-7 0-12M140 146c-3-5 3-7 0-12" stroke="#f59a3c" stroke-width="2.2" stroke-linecap="round" fill="none"/>',
    'fastener' => '
        <rect x="20" y="28" width="200" height="56" fill="#e6eeed" stroke="#b9c8c8"/>
        <rect x="30" y="28" width="180" height="40" fill="#8fb0c8"/>
        <g class="fgw-move fgw-move--rail"><rect x="20" y="92" width="200" height="60" fill="#fbfdfc" stroke="#b9c8c8"/><rect x="30" y="112" width="180" height="40" fill="#a9c2d4"/></g>
        <rect class="fgw-gap" x="20" y="84" width="200" height="8" fill="#2a5fa8"/>
        <circle cx="120" cy="100" r="13" fill="#c9a24b"/><circle cx="120" cy="100" r="4" fill="#9a7a31"/>
        <rect x="100" y="70" width="40" height="10" rx="3" fill="#9a7a31"/>
        <g class="fgw-move fgw-move--catch"><rect x="116" y="96" width="46" height="8" rx="4" fill="#9a7a31"/><circle cx="160" cy="100" r="6" fill="#c9a24b"/></g>',
    'wedge' => '
        <rect x="24" y="14" width="56" height="152" fill="#eef3f2" stroke="#c3d0d0"/>
        <rect x="92" y="14" width="124" height="152" fill="#fbfdfc" stroke="#b9c8c8"/>
        <rect x="110" y="30" width="106" height="136" fill="#a9c2d4"/>
        <rect class="fgw-gap" x="80" y="14" width="12" height="152" fill="#2a5fa8"/>
        <g class="fgw-rattle" stroke="#002d3a" stroke-width="2" stroke-linecap="round" fill="none"><path d="M222 60l8-4M222 74h9M222 88l8 4"/></g>
        <g class="fgw-move fgw-move--wedge"><path d="M78 52h16l-4 46h-8z" fill="#2eac66"/><path d="M78 52h16" stroke="#20824c" stroke-width="3" stroke-linecap="round"/></g>',
    'towel' => '
        <rect x="20" y="20" width="200" height="78" fill="#fbfdfc" stroke="#b9c8c8"/>
        <rect x="34" y="20" width="172" height="52" fill="#a9c2d4"/>
        <rect x="10" y="106" width="220" height="14" rx="4" fill="#fff" stroke="#b9c8c8"/>
        <rect x="24" y="120" width="192" height="8" fill="#e3ebea"/>
        <rect class="fgw-gap" x="20" y="98" width="200" height="8" fill="#2a5fa8"/>
        <g class="fgw-wisps" stroke="#2a5fa8" stroke-width="2.2" stroke-linecap="round" fill="none"><path d="M60 110c6 8 14 2 18 12M120 110c6 8 14 2 18 12M176 110c6 8 14 2 18 12"/></g>
        <g class="fgw-move fgw-move--towel"><rect x="26" y="88" width="188" height="20" rx="10" fill="#4c7b86"/><path d="M50 88v20M82 88v20M114 88v20M146 88v20M178 88v20" stroke="#6392a0" stroke-width="5"/><ellipse cx="212" cy="98" rx="5" ry="10" fill="#3a6570"/></g>',
    'cord' => '
        <rect x="20" y="24" width="200" height="56" fill="#e6eeed" stroke="#b9c8c8"/>
        <rect x="30" y="24" width="180" height="40" fill="#8fb0c8"/>
        <rect x="20" y="92" width="200" height="64" fill="#fbfdfc" stroke="#b9c8c8"/>
        <rect x="30" y="112" width="180" height="44" fill="#a9c2d4"/>
        <rect class="fgw-gap" x="20" y="80" width="200" height="12" fill="#2a5fa8"/>
        <path class="fgw-move fgw-move--cord" d="M22 86h196" pathLength="100" stroke="#f4ecd0" stroke-width="10" stroke-linecap="round" fill="none"/>
        <g class="fgw-move fgw-move--thumb"><circle cx="0" cy="0" r="15" fill="#f1c9a8" stroke="#d9a47c" stroke-width="1.5"/><path d="M-8-5a9 9 0 0 1 16 0" stroke="#fff" stroke-width="2.5" fill="none" stroke-linecap="round"/></g>',
];
?>
<section class="fg-warm-section fg-warm-tonight" id="tonight" aria-labelledby="fg-warm-tonight-title" data-fg-warm-tabs>
    <div class="container">
        <div class="fg-warm-head">
            <p class="eyebrow"><?php echo esc_html($tonight['eyebrow']); ?></p>
            <h2 id="fg-warm-tonight-title"><?php echo esc_html($tonight['title']); ?></h2>
            <p><?php echo esc_html($tonight['intro']); ?></p>
        </div>

        <div class="fg-warm-tonight__grid">
            <div class="fg-warm-tonight__list" role="tablist" aria-labelledby="fg-warm-tonight-title" aria-orientation="vertical">
                <?php foreach ($items as $index => $item) : ?>
                    <button class="fg-warm-tonight__tab<?php echo $index === 0 ? ' is-active' : ''; ?>" type="button" role="tab" id="fg-warm-tonight-tab-<?php echo esc_attr($item['key']); ?>" aria-controls="fg-warm-tonight-panel-<?php echo esc_attr($item['key']); ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"<?php echo $index === 0 ? '' : ' tabindex="-1"'; ?> data-fg-warm-tab>
                        <span class="fg-warm-tonight__tab-label"><?php echo esc_html($item['label']); ?></span>
                        <span class="fg-warm-tonight__tab-cost"><?php echo esc_html($item['cost']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="fg-warm-tonight__panels">
                <?php foreach ($items as $index => $item) : ?>
                    <article class="fg-warm-tonight__panel fg-warm-panel<?php echo $index === 0 ? ' is-active' : ''; ?>" role="tabpanel" id="fg-warm-tonight-panel-<?php echo esc_attr($item['key']); ?>" aria-labelledby="fg-warm-tonight-tab-<?php echo esc_attr($item['key']); ?>" data-fg-warm-panel>
                        <div class="fg-warm-tonight__art fg-warm-tonight__art--<?php echo esc_attr($item['key']); ?>" aria-hidden="true">
                            <svg viewBox="0 0 240 180" focusable="false"><?php echo $drawings[$item['key']] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
                        </div>
                        <div class="fg-warm-tonight__copy">
                            <p class="fg-warm-chip fg-warm-chip--plain"><?php echo esc_html($item['cost']); ?></p>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['body']); ?></p>
                            <p class="fg-warm-tonight__proof"><?php echo esc_html($item['proof']); ?></p>
                            <?php
                            if ($item['source'] !== '') {
                                echo fenster_warm_source_line($warm, $item['source']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                            ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
