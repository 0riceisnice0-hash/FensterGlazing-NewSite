<?php
/**
 * The winter guide's three diagrams.
 *
 * Each one explains a single idea from the paragraph beside it, and that
 * paragraph says the same thing in words, so nothing is lost to a screen
 * reader, a search engine or anyone with images off (the SVGs are
 * aria-hidden for that reason).
 *
 * Moving parts carry a class the stylesheet animates (`fgw-flow`, `fgw-pulse`).
 * With reduced motion asked for they stand still and still make sense.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_warm_diagram(string $key): string
{
    switch ($key) {
        /* A sash cut through the middle: room on the left, street on the
           right. Outside air comes in at the meeting rail and under the bottom
           rail; air beside the glass cools, falls and runs across the floor. */
        case 'two-ways':
            return '<svg viewBox="0 0 560 300" focusable="false" aria-hidden="true">
                <defs>
                    <marker id="fgw-arrow-draught" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="3.2" markerHeight="3.2" orient="auto-start-reverse"><path d="M0 0L10 5L0 10z" fill="#2a5fa8"/></marker>
                    <marker id="fgw-arrow-cold" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="3.2" markerHeight="3.2" orient="auto-start-reverse"><path d="M0 0L10 5L0 10z" fill="#6fa4d4"/></marker>
                </defs>
                <rect x="0" y="0" width="300" height="300" fill="#fff6ec"/>
                <rect x="340" y="0" width="220" height="300" fill="#edf4f9"/>
                <rect x="300" y="0" width="40" height="64" fill="#d8e1e0"/>
                <rect x="300" y="236" width="40" height="64" fill="#d8e1e0"/>
                <rect x="236" y="236" width="70" height="10" rx="2" fill="#ffffff" stroke="#b9c8c8"/>
                <rect x="0" y="286" width="300" height="14" fill="#efe4d6"/>
                <rect x="322" y="64" width="12" height="90" fill="#ffffff" stroke="#9fb3b3"/>
                <rect x="326" y="72" width="4" height="74" fill="#a9c8de"/>
                <rect x="306" y="150" width="12" height="84" fill="#ffffff" stroke="#9fb3b3"/>
                <rect x="310" y="158" width="4" height="68" fill="#a9c8de"/>
                <path class="fgw-flow fgw-flow--draught" d="M540 152H200" marker-end="url(#fgw-arrow-draught)"/>
                <path class="fgw-flow fgw-flow--draught fgw-flow--late" d="M540 232H360c-14 0-20 6-36 4H210" marker-end="url(#fgw-arrow-draught)"/>
                <path class="fgw-flow fgw-flow--cold" d="M300 84c-4 40 2 90-2 140c-2 14-22 30-60 40c-60 14-140 18-220 18" marker-end="url(#fgw-arrow-cold)"/>
                <path class="fgw-flow fgw-flow--cold fgw-flow--late" d="M296 176c-2 22 0 40-4 54c-10 22-60 40-130 46" marker-end="url(#fgw-arrow-cold)"/>
                <text x="24" y="40" class="fgw-svg-label">Inside</text>
                <text x="536" y="40" class="fgw-svg-label" text-anchor="end">Outside</text>
            </svg>';

        /* The front of a sash window, with a pulsing marker at each place it
           usually leaks and the name of the place beside it. */
        case 'leak-points':
            $points = [
                ['x' => 254, 'y' => 58, 'lx' => 200, 'ly' => 58, 'anchor' => 'end', 'lines' => ['The pulleys']],
                ['x' => 254, 'y' => 300, 'lx' => 200, 'ly' => 300, 'anchor' => 'end', 'lines' => ['Down the sides']],
                ['x' => 420, 'y' => 112, 'lx' => 444, 'ly' => 112, 'anchor' => 'start', 'lines' => ['Round the frame']],
                ['x' => 386, 'y' => 218, 'lx' => 444, 'ly' => 218, 'anchor' => 'start', 'lines' => ['Where the', 'sashes meet']],
                ['x' => 330, 'y' => 386, 'lx' => 444, 'ly' => 360, 'anchor' => 'start', 'lines' => ['Under the', 'bottom rail']],
            ];

            $marks = '';
            foreach ($points as $index => $point) {
                $lead_from = $point['anchor'] === 'end' ? $point['lx'] + 6 : $point['lx'] - 6;
                $marks .= sprintf('<path class="fgw-leader" d="M%d %dL%d %d"/>', $point['x'], $point['y'], $lead_from, $point['ly']);
                $marks .= sprintf(
                    '<g class="fgw-pulse" style="--fgw-delay:%1$.1fs"><circle class="fgw-pulse__ring" cx="%2$d" cy="%3$d" r="8"/><circle class="fgw-pulse__dot" cx="%2$d" cy="%3$d" r="7"/></g>',
                    $index * 0.4,
                    $point['x'],
                    $point['y']
                );

                $first_y = $point['ly'] + 7 - (count($point['lines']) - 1) * 12;
                $marks .= sprintf('<text class="fgw-svg-label" x="%d" y="%d" text-anchor="%s">', $point['lx'], $first_y, $point['anchor']);
                foreach ($point['lines'] as $line_index => $line) {
                    $marks .= sprintf('<tspan x="%d" dy="%d">%s</tspan>', $point['lx'], $line_index === 0 ? 0 : 24, esc_html($line));
                }
                $marks .= '</text>';
            }

            return '<svg viewBox="0 0 640 420" focusable="false" aria-hidden="true">
                <rect x="220" y="30" width="200" height="366" fill="#e6ecea" stroke="#b9c8c8"/>
                <rect x="236" y="42" width="168" height="346" fill="#ffffff" stroke="#c3d0d0"/>
                <rect x="254" y="50" width="132" height="170" fill="#ffffff" stroke="#9fb3b3" stroke-width="2"/>
                <rect x="264" y="60" width="112" height="150" fill="#cfe0ec"/>
                <path d="M320 60v150M264 135h112" stroke="#ffffff" stroke-width="5"/>
                <rect x="254" y="214" width="132" height="172" fill="#ffffff" stroke="#9fb3b3" stroke-width="2"/>
                <rect x="264" y="226" width="112" height="150" fill="#cfe0ec"/>
                <path d="M320 226v150M264 301h112" stroke="#ffffff" stroke-width="5"/>
                <rect x="308" y="208" width="24" height="10" rx="3" fill="#9a7a31"/>
                <rect x="204" y="388" width="232" height="14" rx="3" fill="#ffffff" stroke="#b9c8c8"/>
                ' . $marks . '
            </svg>';

        /* The same window twice: single glass with heat flowing straight
           through, then with a second pane inside and still air between, where
           only a thin trickle gets out. */
        case 'secondary':
            $panel = static function (bool $secondary): string {
                $arrow = $secondary ? 'fgw-arrow-heat-b' : 'fgw-arrow-heat-a';
                $end = ' marker-end="url(#' . $arrow . ')"';
                $svg = '<svg viewBox="0 0 260 220" focusable="false" aria-hidden="true">'
                    . '<defs><marker id="' . $arrow . '" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="3" markerHeight="3" orient="auto"><path d="M0 0L10 5L0 10z" fill="#e8743a"/></marker></defs>'
                    . '<rect x="0" y="0" width="160" height="220" fill="#fff6ec"/>'
                    . '<rect x="160" y="0" width="100" height="220" fill="#edf4f9"/>'
                    . '<rect x="160" y="0" width="22" height="34" fill="#d8e1e0"/><rect x="160" y="186" width="22" height="34" fill="#d8e1e0"/>'
                    . '<rect x="166" y="34" width="6" height="152" fill="#a9c8de" stroke="#7d9fb8"/>';

                if ($secondary) {
                    $svg .= '<rect x="124" y="34" width="42" height="152" fill="#f3f8fc"/>'
                        . '<rect x="118" y="30" width="6" height="160" fill="#a9c8de" stroke="#7d9fb8"/>'
                        . '<path class="fgw-flow fgw-flow--heat" d="M14 80H112"/><path class="fgw-flow fgw-flow--heat" d="M14 110H112"/><path class="fgw-flow fgw-flow--heat" d="M14 140H112"/>'
                        . '<path class="fgw-flow fgw-flow--heat fgw-flow--thin" d="M128 110H246"' . $end . '/>';
                } else {
                    $svg .= '<path class="fgw-flow fgw-flow--heat" d="M14 80H244"' . $end . '/><path class="fgw-flow fgw-flow--heat" d="M14 110H244"' . $end . '/><path class="fgw-flow fgw-flow--heat" d="M14 140H244"' . $end . '/>';
                }

                return $svg . '</svg>';
            };

            return '<div class="fgw-pair">'
                . '<div class="fgw-pair__item">' . $panel(false) . '<p>Single glass</p></div>'
                . '<div class="fgw-pair__item">' . $panel(true) . '<p>With secondary glazing</p></div>'
                . '</div>';
    }

    return '';
}
