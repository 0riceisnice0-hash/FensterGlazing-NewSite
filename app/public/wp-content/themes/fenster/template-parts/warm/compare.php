<?php
/**
 * Winter guide: the heat and noise comparison.
 *
 * One single-glazed sash cut through the middle, warm room on the left and
 * the street on the right. Five states (as it is, then each fix on its own,
 * never stacked) and two modes (heat, noise). Every word and figure comes
 * from $warm['compare'].
 *
 * HOW THE DRAWING IS BUILT. Two SVGs share one viewBox. The first is the
 * still drawing (the role="img"): wall, sashes, radiator, car, and the four
 * layers a state switches on (seals, curtain, secondary panel, double-glazed
 * sashes). The second sits on top and holds only what moves: heat dots, the
 * air leaking through the three gaps, and the sound waves. Keeping the moving
 * parts on their own layer means a frame repaints a few dozen small shapes,
 * not the whole picture.
 *
 * The amounts are not drawn by JavaScript. The section carries three numbers
 * as custom properties (--fgw-heat = U / 4.5, --fgw-leak = leak, --fgw-loud =
 * how loud the street sounds inside, halving every 10 dB from 29 dB), and
 * each dot, wisp or wave has an index --i. CSS shows the first N of them with
 * clamp(), so the density is right with JavaScript off and under reduced
 * motion too. JavaScript only swaps the three numbers.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$warm = (array) ($args['warm'] ?? []);
$compare = (array) ($warm['compare'] ?? []);
$states = (array) ($compare['states'] ?? []);
$modes = (array) ($compare['modes'] ?? []);

if ($states === []) {
    return;
}

/* The numbers the drawing and the bars read, per state. */
$cmp_vars = static function (array $state): array {
    return [
        'heat' => round(((float) $state['heat_u']) / 4.5, 4),
        'leak' => round((float) $state['leak'], 4),
        'loud' => round(2 ** (-(((float) $state['noise_db']) - 29) / 10), 4),
        'noise' => round(((float) $state['noise_db']) / 50, 4),
    ];
};
$first = $states[0];
$first_vars = $cmp_vars($first);

/*
 * Heat dots: fourteen lanes, interleaved between the top sash's glass
 * (x 373) and the bottom sash's glass (x 345) so that whichever N are shown
 * are spread over both panes. Each lane has one dot that goes through and one
 * that turns back into the room; CSS fades between them.
 */
$cmp_lanes = [];
$lower = [256, 230, 290, 244, 272, 222, 298];
$upper = [140, 112, 168, 126, 154, 106, 178];
for ($k = 0; $k < 7; $k++) {
    foreach ([[$lower[$k], 345], [$upper[$k], 373]] as $j => $glass) {
        $i = ($k * 2) + $j;
        $yg = $glass[0];
        $xg = $glass[1];
        $x0 = 120 + (($k * 37 + $j * 61) % 120);
        $y0 = min(372, $yg + 60 + (($k * 17 + $j * 9) % 40));
        $x1 = 560 + (($k * 31 + $j * 23) % 70);
        $slope = ($yg - $y0) / ($xg - $x0);
        $y1 = $yg + $slope * ($x1 - $xg);
        $tx = 248 - (($k * 11 + $j * 7) % 26) - $x0;
        $ty = $slope * $tx;
        $cmp_lanes[] = [
            'x' => $x0,
            'y' => $y0,
            'style' => sprintf(
                '--i:%d;--dx:%.1fpx;--dy:%.1fpx;--tx:%.1fpx;--ty:%.1fpx;--t:%.2fs;--d:%.2fs;--p:%.2f',
                $i,
                $x1 - $x0,
                $y1 - $y0,
                $tx,
                $ty,
                5.2 + (($k + $j) % 3) * 0.55,
                -1 * ($i * 0.83),
                0.28 + (($i * 0.37) - floor($i * 0.37)) * 0.62
            ),
        ];
    }
}

/*
 * Air leaking round the sashes: three gaps (meeting rails, sill, head), three
 * wisps each, ordered so the first ones shown are spread over the gaps. Each
 * path threads the real gap in the drawing.
 */
$cmp_gap_paths = [
    'meet' => 'M%1$d %2$d C300 %3$d 336 178 352 190 L359 196 L359 210 C364 218 392 222 428 228 C460 233 486 242 520 252',
    'sill' => 'M%1$d %2$d C296 %3$d 318 329 336 329 L360 329 C380 327 404 320 440 316 C472 313 496 318 526 326',
    'head' => 'M%1$d %2$d C296 %3$d 330 79 356 79 L392 79 C414 79 436 86 470 98 C496 107 516 116 540 126',
];
$cmp_starts = [
    'meet' => [[236, 236, 200], [214, 252, 214], [250, 214, 190]],
    'sill' => [[230, 300, 312], [210, 316, 320], [246, 288, 304]],
    'head' => [[232, 128, 96], [214, 144, 104], [250, 112, 90]],
];
$cmp_wisps = [];
for ($n = 0; $n < 9; $n++) {
    $gap = ['meet', 'sill', 'head'][$n % 3];
    $row = intdiv($n, 3);
    $s = $cmp_starts[$gap][$row];
    $cmp_wisps[] = [
        'd' => sprintf($cmp_gap_paths[$gap], $s[0], $s[1], $s[2]),
        'style' => sprintf('--i:%d;--d:%.2fs', $n, -1 * ($n * 0.47 + $row * 0.31)),
    ];
}

$cmp_icon = [
    'heat' => '<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M10 2.5c.6 2.7 4.5 4.6 4.5 8.6a4.5 4.5 0 0 1-9 0c0-2 1-3.2 2-4.2.2 1.4.9 2.3 1.9 2.6C9 7.6 9.2 4.8 10 2.5Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>',
    'noise' => '<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M13 7.2a4 4 0 0 1 0 5.6M15.4 5a7 7 0 0 1 0 10" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
];
?>
<section
    class="fg-warm-section fg-warm-compare"
    id="compare"
    aria-labelledby="fg-warm-compare-title"
    data-fg-warm-compare
    data-state="<?php echo esc_attr($first['key']); ?>"
    data-mode="heat"
    style="<?php echo esc_attr(sprintf('--fgw-heat:%s;--fgw-leak:%s;--fgw-loud:%s', $first_vars['heat'], $first_vars['leak'], $first_vars['loud'])); ?>"
>
    <div class="container">
        <div class="fg-warm-head">
            <p class="eyebrow"><?php echo esc_html($compare['eyebrow']); ?></p>
            <h2 id="fg-warm-compare-title"><?php echo esc_html($compare['title']); ?></h2>
            <p><?php echo esc_html($compare['intro']); ?></p>
        </div>

        <div class="fg-warm-compare__grid">
            <div class="fg-warm-compare__visual">
                <div class="fg-warm-compare__stage">
                    <svg class="fg-warm-compare__svg" viewBox="0 0 720 430" preserveAspectRatio="xMidYMid meet" role="img" aria-label="<?php echo esc_attr($compare['svg_alt']); ?>">
                        <defs>
                            <pattern id="fgw-cmp-brick" width="26" height="24" patternUnits="userSpaceOnUse">
                                <rect width="26" height="24" fill="#f1e9df"/>
                                <path d="M0 11.5H26M0 23.5H26M13 0V11.5M0.5 12V24M25.5 12V24" stroke="#e2d5c5" stroke-width="1"/>
                            </pattern>
                        </defs>

                        <?php /* Room and street, drawn well past the viewBox so a wider or taller stage just shows more of both. */ ?>
                        <rect x="-500" y="-400" width="820" height="900" fill="#fdf3ec"/>
                        <rect class="fg-warm-compare__wash" x="-500" y="-400" width="800" height="900" fill="#fbd5bd"/>
                        <rect x="380" y="-400" width="840" height="900" fill="#edf3f9"/>

                        <?php /* Room: floor and skirting. */ ?>
                        <rect x="-500" y="400" width="800" height="330" fill="#f2e4d4"/>
                        <path d="M-500 412H300M-500 426H300" stroke="#e7d6c3" stroke-width="1"/>
                        <rect x="-500" y="398" width="800" height="3" fill="#e4d2bf"/>
                        <rect x="286" y="386" width="14" height="13" fill="#ffffff" stroke="#e1d3c4" stroke-width="1"/>

                        <?php /* An armchair, so the room reads as a room. */ ?>
                        <g>
                            <path d="M58 318 C58 300 70 292 86 292 H146 C162 292 172 300 172 318 V352 H58 Z" fill="#e9cdb6"/>
                            <rect x="44" y="336" width="34" height="50" rx="12" fill="#e2bfa4"/>
                            <rect x="152" y="336" width="34" height="50" rx="12" fill="#e2bfa4"/>
                            <rect x="70" y="346" width="104" height="34" rx="8" fill="#edd5c1"/>
                            <path d="M58 386 V398 M172 386 V398" stroke="#c9a487" stroke-width="5" stroke-linecap="round"/>
                        </g>

                        <?php /* Street: far houses, a lamp post, snow, the pavement and road. */ ?>
                        <path d="M430 300 V246 L462 222 L494 246 V300 Z M500 300 V236 H560 V214 L590 196 L620 214 V300 Z M630 300 V230 L664 206 L698 230 V300 Z M704 300 V240 H900 V300 Z" fill="#dce7f1"/>
                        <g fill="#f8f1d8">
                            <rect x="452" y="256" width="10" height="13" rx="1.5"/>
                            <rect x="520" y="248" width="10" height="13" rx="1.5"/>
                            <rect x="596" y="232" width="10" height="13" rx="1.5"/>
                            <rect x="660" y="244" width="10" height="13" rx="1.5"/>
                        </g>
                        <rect x="400" y="300" width="820" height="98" fill="#e6eef5"/>
                        <rect x="400" y="396" width="820" height="12" fill="#d9e3ea"/>
                        <rect x="400" y="408" width="820" height="322" fill="#ccd9e2"/>
                        <path d="M430 424 H470 M510 424 H550 M590 424 H630 M670 424 H710" stroke="#e9eff3" stroke-width="2.5" stroke-linecap="round"/>
                        <g fill="#b8c8d3">
                            <rect x="686" y="196" width="4" height="202" rx="2"/>
                            <path d="M688 198 C688 184 676 180 664 182 L664 186 C674 185 684 188 684 198 Z"/>
                            <rect x="656" y="184" width="14" height="6" rx="3"/>
                        </g>
                        <g fill="#ffffff">
                            <circle cx="430" cy="62" r="2.2"/><circle cx="476" cy="118" r="1.6"/><circle cx="522" cy="40" r="2"/><circle cx="566" cy="96" r="1.5"/><circle cx="612" cy="54" r="2.2"/><circle cx="650" cy="132" r="1.6"/><circle cx="700" cy="76" r="2"/><circle cx="452" cy="176" r="1.5"/><circle cx="600" cy="160" r="1.8"/>
                        </g>

                        <?php /* The car, side on, in the road. */ ?>
                        <g>
                            <ellipse cx="562" cy="418" rx="96" ry="5" fill="#b9c9d4"/>
                            <path d="M476 404 C470 404 468 398 470 390 L474 378 C476 372 482 369 490 368 L512 366 L532 346 C537 341 543 339 552 339 H604 C612 339 618 342 623 348 L638 366 L650 368 C656 369 660 374 660 380 V396 C660 401 656 404 650 404 Z" fill="#4c7b86"/>
                            <path d="M520 366 L537 349 C540 346 544 345 549 345 H572 V366 Z M578 366 V345 H602 C607 345 611 347 614 350 L629 366 Z" fill="#e3eef4"/>
                            <rect x="472" y="378" width="10" height="7" rx="2" fill="#ffe1a1"/>
                            <rect x="652" y="378" width="8" height="7" rx="2" fill="#f2826b"/>
                            <path d="M560 374 H572 M612 374 H622" stroke="#3a6570" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="510" cy="404" r="15" fill="#2c3f46"/><circle cx="510" cy="404" r="6" fill="#d7e2e7"/>
                            <circle cx="620" cy="404" r="15" fill="#2c3f46"/><circle cx="620" cy="404" r="6" fill="#d7e2e7"/>
                        </g>

                        <?php /* The wall, cut through above and below the window, plaster on the room face. */ ?>
                        <rect x="300" y="-400" width="100" height="462" fill="url(#fgw-cmp-brick)"/>
                        <rect x="300" y="346" width="100" height="400" fill="url(#fgw-cmp-brick)"/>
                        <rect x="304" y="44" width="96" height="18" fill="#e7eaec"/>
                        <path d="M300 -400V62H400V-400M300 746V346H400V746" fill="none" stroke="#cdbba6" stroke-width="1.4"/>
                        <rect x="295" y="-400" width="5" height="462" fill="#fbf7f2"/>
                        <rect x="295" y="344" width="5" height="402" fill="#fbf7f2"/>

                        <?php /* Beyond the cut: the side reveal, the box frame's lining and the outer brick reveal. */ ?>
                        <rect x="300" y="62" width="22" height="284" fill="#f6eee5"/>
                        <rect x="322" y="62" width="78" height="284" fill="#e6eeed"/>

                        <?php /* Box head, then the three gaps: over the top sash, between the meeting rails, under the bottom sash. */ ?>
                        <rect x="320" y="62" width="78" height="14" fill="#ffffff" stroke="#8aa0a6" stroke-width="1.2"/>
                        <rect x="392" y="62" width="8" height="30" fill="#ffffff" stroke="#8aa0a6" stroke-width="1.2"/>
                        <g fill="#bccbce">
                            <rect x="362" y="76" width="22" height="6"/>
                            <rect x="356" y="196" width="6" height="10"/>
                            <rect x="334" y="326" width="22" height="6"/>
                        </g>

                        <?php /* Each sash's stiles, seen beyond the cut, so the sashes read as solid frames. */ ?>
                        <g fill="#f7fafa" stroke="#c3d0d1" stroke-width="1">
                            <rect x="362" y="82" width="22" height="124"/>
                            <rect x="334" y="196" width="22" height="130"/>
                        </g>

                        <?php /* Top sash (outer) and bottom sash (nearer the room), cut through their rails, lapping at the meeting rails. */ ?>
                        <g fill="#ffffff" stroke="#8aa0a6" stroke-width="1.2" stroke-linejoin="round">
                            <rect x="362" y="82" width="22" height="18" rx="1.5"/>
                            <path d="M362 186 H384 V206 H366 L362 200 Z"/>
                            <path d="M334 196 H356 V214 H334 Z"/>
                            <path d="M334 304 H356 V326 H334 Z"/>
                        </g>
                        <circle cx="345" cy="316" r="2.6" fill="#c9a24b"/>
                        <rect x="338" y="191" width="13" height="5" rx="2" fill="#c9a24b"/>

                        <?php /* Single glass: one thin pane in each sash. */ ?>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--single" fill="#7aa6c4">
                            <rect x="371.5" y="100" width="3.5" height="86"/>
                            <rect x="343.5" y="214" width="3.5" height="90"/>
                        </g>
                        <?php /* New double-glazed sashes: two panes and a spacer in each. */ ?>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--double">
                            <g fill="#86afcb">
                                <rect x="365.5" y="100" width="3" height="86"/>
                                <rect x="377.5" y="100" width="3" height="86"/>
                                <rect x="337.5" y="214" width="3" height="90"/>
                                <rect x="349.5" y="214" width="3" height="90"/>
                            </g>
                            <g fill="#e3ecf2">
                                <rect x="368.5" y="105" width="9" height="76"/>
                                <rect x="340.5" y="219" width="9" height="80"/>
                            </g>
                            <g fill="#6f858d">
                                <rect x="368.5" y="100" width="9" height="5"/>
                                <rect x="368.5" y="181" width="9" height="5"/>
                                <rect x="340.5" y="214" width="9" height="5"/>
                                <rect x="340.5" y="299" width="9" height="5"/>
                            </g>
                        </g>

                        <?php /* Outer sill and the window board inside. */ ?>
                        <path d="M322 332 H398 L422 340 V350 H414 V346 H322 Z" fill="#ffffff" stroke="#8aa0a6" stroke-width="1" stroke-linejoin="round"/>
                        <rect x="272" y="332" width="54" height="12" rx="3" fill="#ffffff" stroke="#a9b9bd" stroke-width="1.2"/>

                        <?php /* Seals in the three gaps, ringed so they read without colour. */ ?>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--seals">
                            <g fill="none" stroke="#2eac66" stroke-width="1.5" stroke-dasharray="3 3">
                                <circle cx="373" cy="79" r="14"/>
                                <circle cx="359" cy="201" r="14"/>
                                <circle cx="345" cy="329" r="14"/>
                            </g>
                            <g fill="#2eac66" stroke="#20824c" stroke-width="0.8">
                                <rect class="fg-warm-compare__seal" x="362.5" y="76.5" width="21" height="5" rx="2.5"/>
                                <rect class="fg-warm-compare__seal" x="356.5" y="196.5" width="5" height="9" rx="2.5"/>
                                <rect class="fg-warm-compare__seal" x="334.5" y="326.5" width="21" height="5" rx="2.5"/>
                            </g>
                        </g>

                        <?php /* Radiator under the window, on its brackets. */ ?>
                        <rect x="292" y="358" width="4" height="4" fill="#c1cece"/>
                        <rect x="292" y="384" width="4" height="4" fill="#c1cece"/>
                        <rect x="266" y="352" width="26" height="42" rx="5" fill="#ffffff" stroke="#c1cece" stroke-width="1.2"/>
                        <path d="M274 357 V389 M284 357 V389" stroke="#e1e9e8" stroke-width="2" stroke-linecap="round"/>
                        <rect x="260" y="389" width="7" height="6" rx="1.5" fill="#c1cece"/>
                        <circle cx="259" cy="392" r="4" fill="#002d3a"/>
                        <path d="M250 342 c-5 -8 5 -12 0 -20 M238 346 c-5 -8 5 -12 0 -20 M226 350 c-5 -8 5 -12 0 -20" fill="none" stroke="#f59a3c" stroke-width="2" stroke-linecap="round" opacity="0.6"/>

                        <?php /* Curtain pole, and the curtain, drawn closed. */ ?>
                        <rect x="232" y="34" width="68" height="6" rx="3" fill="#002d3a"/>
                        <circle cx="233" cy="37" r="5.5" fill="#002d3a"/>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--open">
                            <path d="M236 40 H256 C258 120 252 230 257 330 H234 C231 230 238 120 236 40 Z" fill="#4c7b86"/>
                            <path d="M243 42 C246 140 240 230 244 328 M250 42 C253 140 247 230 251 328" fill="none" stroke="#6392a0" stroke-width="2"/>
                        </g>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--curtain">
                            <path d="M262 40 H290 C292 120 287 220 291 328 H261 C258 230 264 130 262 40 Z" fill="#4c7b86"/>
                            <path d="M270 42 C273 140 266 230 270 326 M281 42 C284 140 278 230 282 326" fill="none" stroke="#6392a0" stroke-width="2"/>
                            <path d="M266 44 C268 140 262 236 265 326" fill="none" stroke="#3a6570" stroke-width="1.4"/>
                            <g fill="none" stroke="#002d3a" stroke-width="1.6"><circle cx="268" cy="37" r="4"/><circle cx="284" cy="37" r="4"/></g>
                        </g>

                        <?php /* Secondary glazing on the room side of the reveal, with the gap marked. */ ?>
                        <g class="fg-warm-compare__layer fg-warm-compare__layer--secondary">
                            <rect x="300" y="62" width="11" height="12" rx="1.5" fill="#f4f7f8" stroke="#9fb2b4" stroke-width="1"/>
                            <rect x="300" y="320" width="11" height="12" rx="1.5" fill="#f4f7f8" stroke="#9fb2b4" stroke-width="1"/>
                            <rect x="300.5" y="74" width="10" height="246" fill="#f4f7f8" stroke="#c3d0d1" stroke-width="1" opacity="0.8"/>
                            <rect x="304.5" y="74" width="3" height="246" fill="#7aa6c4"/>
                            <path d="M307 262 H343 M307 256 V268 M343 256 V268" stroke="#002d3a" stroke-width="1.3"/>
                            <text class="fg-warm-compare__dim" x="296" y="266" text-anchor="end"><?php esc_html_e('100 mm gap', 'fenster'); ?></text>
                        </g>

                        <text class="fg-warm-compare__tag" x="20" y="30"><?php esc_html_e('Warm room', 'fenster'); ?></text>
                        <text class="fg-warm-compare__tag fg-warm-compare__tag--cold" x="700" y="30" text-anchor="end"><?php esc_html_e('Cold street', 'fenster'); ?></text>
                    </svg>

                    <?php /* What moves, on its own layer. */ ?>
                    <svg class="fg-warm-compare__fx" viewBox="0 0 720 430" preserveAspectRatio="xMidYMid meet" aria-hidden="true" focusable="false">
                        <g class="fg-warm-compare__heat">
                            <g fill="none" stroke="#e8553a" stroke-width="2.6" stroke-linecap="round">
                                <?php foreach ($cmp_wisps as $wisp) : ?>
                                    <g class="fg-warm-compare__wisp" style="<?php echo esc_attr($wisp['style']); ?>"><path class="fg-warm-compare__trail" d="<?php echo esc_attr($wisp['d']); ?>"/><path class="fg-warm-compare__puff" d="<?php echo esc_attr($wisp['d']); ?>" pathLength="100"/></g>
                                <?php endforeach; ?>
                            </g>
                            <g>
                                <?php foreach ($cmp_lanes as $lane) : ?>
                                    <g class="fg-warm-compare__lane" style="<?php echo esc_attr($lane['style']); ?>">
                                        <g class="fg-warm-compare__go"><circle cx="<?php echo esc_attr((string) $lane['x']); ?>" cy="<?php echo esc_attr((string) $lane['y']); ?>" r="3.8"/></g>
                                        <g class="fg-warm-compare__stay"><circle cx="<?php echo esc_attr((string) $lane['x']); ?>" cy="<?php echo esc_attr((string) $lane['y']); ?>" r="3.8"/></g>
                                    </g>
                                <?php endforeach; ?>
                            </g>
                        </g>
                        <g class="fg-warm-compare__noise" fill="none" stroke-linecap="round">
                            <g class="fg-warm-compare__waves-out">
                                <?php for ($w = 0; $w < 4; $w++) : ?>
                                    <path d="M307.5 311 A220 220 0 0 1 463 155.5" style="--i:<?php echo (int) $w; ?>"/>
                                <?php endfor; ?>
                            </g>
                            <g class="fg-warm-compare__waves-in">
                                <?php for ($w = 0; $w < 4; $w++) : ?>
                                    <g class="fg-warm-compare__wave" style="--i:<?php echo (int) $w; ?>"><path d="M151 95 A230 230 0 0 0 151 325"/></g>
                                <?php endfor; ?>
                            </g>
                        </g>
                    </svg>
                </div>

                <div class="fg-warm-compare__states" role="group" aria-label="<?php esc_attr_e('Steps to compare', 'fenster'); ?>">
                    <?php foreach ($states as $n => $state) : ?>
                        <?php $v = $cmp_vars($state); ?>
                        <button
                            type="button"
                            class="fg-warm-compare__state-btn"
                            data-key="<?php echo esc_attr($state['key']); ?>"
                            data-heat="<?php echo esc_attr((string) $v['heat']); ?>"
                            data-leak="<?php echo esc_attr((string) $v['leak']); ?>"
                            data-loud="<?php echo esc_attr((string) $v['loud']); ?>"
                            aria-pressed="<?php echo $n === 0 ? 'true' : 'false'; ?>"
                        ><?php echo esc_html($state['label']); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="fg-warm-compare__side">
                <div class="fg-warm-compare__modes" role="group" aria-label="<?php esc_attr_e('What to show', 'fenster'); ?>">
                    <?php foreach ($modes as $n => $mode) : ?>
                        <button type="button" class="fg-warm-compare__mode-btn" data-mode="<?php echo esc_attr($mode['key']); ?>" aria-pressed="<?php echo $n === 0 ? 'true' : 'false'; ?>"><?php echo $cmp_icon[$mode['key']] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal SVG above. ?><span><?php echo esc_html($mode['label']); ?></span></button>
                    <?php endforeach; ?>
                </div>

                <div class="fg-warm-panel fg-warm-compare__readout">
                    <?php foreach ($states as $n => $state) : ?>
                        <?php $v = $cmp_vars($state); ?>
                        <article class="fg-warm-compare__card<?php echo $n === 0 ? ' is-active' : ''; ?>" data-key="<?php echo esc_attr($state['key']); ?>">
                            <p class="fg-warm-compare__name"><?php echo esc_html($state['label']); ?></p>
                            <p class="fg-warm-compare__summary"><?php echo esc_html($state['summary']); ?></p>

                            <div class="fg-warm-compare__sets">
                                <div class="fg-warm-compare__set fg-warm-compare__set--heat">
                                    <div class="fg-warm-compare__meter">
                                        <p class="fg-warm-compare__label"><span class="fg-warm-compare__key fg-warm-compare__key--heat" aria-hidden="true"></span><?php echo esc_html($compare['heat_label']); ?></p>
                                        <p class="fg-warm-compare__value"><strong data-count><?php echo esc_html($state['heat_value']); ?></strong> <span><?php echo esc_html($compare['heat_unit']); ?></span></p>
                                        <span class="fg-warm-compare__bar fg-warm-compare__bar--heat" aria-hidden="true"><span style="--v:<?php echo esc_attr((string) $v['heat']); ?>"></span></span>
                                        <p class="fg-warm-compare__note"><?php echo esc_html($state['heat_note']); ?></p>
                                    </div>
                                    <div class="fg-warm-compare__meter">
                                        <p class="fg-warm-compare__label"><span class="fg-warm-compare__key fg-warm-compare__key--leak" aria-hidden="true"></span><?php echo esc_html($compare['leak_label']); ?></p>
                                        <span class="fg-warm-compare__bar fg-warm-compare__bar--leak" aria-hidden="true"><span style="--v:<?php echo esc_attr((string) $v['leak']); ?>"></span></span>
                                        <p class="fg-warm-compare__note"><?php echo esc_html($state['leak_note']); ?></p>
                                    </div>
                                </div>

                                <div class="fg-warm-compare__set fg-warm-compare__set--noise">
                                    <div class="fg-warm-compare__meter">
                                        <p class="fg-warm-compare__label"><span class="fg-warm-compare__key fg-warm-compare__key--noise" aria-hidden="true"></span><?php echo esc_html($compare['noise_label']); ?></p>
                                        <p class="fg-warm-compare__value"><strong data-count><?php echo esc_html($state['noise_value']); ?></strong> <span><?php echo esc_html($compare['noise_unit']); ?></span></p>
                                        <span class="fg-warm-compare__bar fg-warm-compare__bar--noise" aria-hidden="true"><span style="--v:<?php echo esc_attr((string) $v['noise']); ?>"></span></span>
                                        <p class="fg-warm-compare__note"><?php echo esc_html($state['noise_note']); ?></p>
                                    </div>
                                    <p class="fg-warm-compare__rule"><?php echo esc_html($compare['noise_rule']); ?></p>
                                </div>
                            </div>

                            <?php echo fenster_warm_source_line($warm, ...(array) $state['sources']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside. ?>
                        </article>
                    <?php endforeach; ?>
                    <p class="fg-warm-sr" aria-live="polite" data-fg-warm-compare-status></p>
                </div>
            </div>
        </div>
    </div>
</section>
