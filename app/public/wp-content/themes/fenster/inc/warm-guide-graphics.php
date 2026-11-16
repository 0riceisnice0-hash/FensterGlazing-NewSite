<?php
/**
 * The winter guide's drawings.
 *
 * ONE WINDOW, DRAWN ONCE, IN TWO PALETTES. `fenster_warm_window_scene()` draws
 * a single-glazed sliding sash seen from inside the room. Called with `room` it
 * is the window as you see it; called with `thermal` it is the same geometry
 * coloured the way a thermal camera would show it. The hero wipes between the
 * two, and the leak finder opens a thermal lens over whichever spot is picked.
 * Because both come from the same coordinates they can never drift apart.
 *
 * THESE ARE ILLUSTRATIONS AND THE PAGE SAYS SO. The thermal view is drawn, not
 * photographed, and carries no temperatures: nothing here is a measurement.
 *
 * Every id is prefixed, because the scene appears more than once on the page
 * and SVG ids are document-wide.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Where each draught path sits on the 480 x 620 scene, as percentages, so the
 * HTML hotspots and the thermal lens are placed from the same numbers the
 * drawing uses.
 */
function fenster_warm_window_points(): array
{
    return [
        'meeting-rail' => ['x' => 240, 'y' => 257],
        'sash-sides' => ['x' => 100, 'y' => 345],
        'bottom-rail' => ['x' => 300, 'y' => 446],
        'pulleys' => ['x' => 378, 'y' => 92],
        'frame-wall' => ['x' => 74, 'y' => 170],
        'glass' => ['x' => 306, 'y' => 170],
        'putty' => ['x' => 174, 'y' => 418],
    ];
}

function fenster_warm_window_scene(string $palette, string $id): string
{
    $thermal = $palette === 'thermal';
    $p = $thermal ? [
        'wall_a' => '#f7b944', 'wall_b' => '#f29a38',
        'halo' => '#d9cf5c',
        'arch' => '#8fcb6b', 'arch_shade' => '#63bb80', 'arch_line' => '#4aa98a',
        'sash' => '#35a7a4', 'sash_shade' => '#2a8fa3', 'sash_line' => '#217a98',
        'glass_a' => '#2c44a6', 'glass_b' => '#3a2a8a', 'glass_c' => '#23155f',
        'bar' => '#2f97a5',
        'sill' => '#5fbf86', 'sill_shade' => '#3fae96',
        'brass' => '#2a8fa3', 'brass_dark' => '#217a98',
        'rad' => '#fff5bd', 'rad_shade' => '#ffd24f', 'rad_line' => '#f7b236',
        'curtain' => '#f08a2e', 'curtain_fold' => '#de6c2a', 'curtain_hi' => '#f6a640',
        'pole' => '#f2a53c',
        'skirt' => '#f4ad40', 'skirt_line' => '#ee9a36',
        'gap' => '#140a3c',
    ] : [
        'wall_a' => '#edf3f2', 'wall_b' => '#e2ebe9',
        'halo' => '#ffffff',
        'arch' => '#ffffff', 'arch_shade' => '#eef3f2', 'arch_line' => '#c3d0d0',
        'sash' => '#fbfdfc', 'sash_shade' => '#e6eeed', 'sash_line' => '#b9c8c8',
        'glass_a' => '#6d91b1', 'glass_b' => '#a9c2d4', 'glass_c' => '#e3ecf0',
        'bar' => '#f6f9f8',
        'sill' => '#ffffff', 'sill_shade' => '#e3ebea',
        'brass' => '#c9a24b', 'brass_dark' => '#9a7a31',
        'rad' => '#ffffff', 'rad_shade' => '#e8efee', 'rad_line' => '#c1cece',
        'curtain' => '#4c7b86', 'curtain_fold' => '#3a6570', 'curtain_hi' => '#6392a0',
        'pole' => '#002d3a',
        'skirt' => '#ffffff', 'skirt_line' => '#c9d5d5',
        'gap' => '#8fa4a8',
    ];

    $panes = [
        [110, 80, 127, 166],
        [243, 80, 127, 166],
        [110, 264, 127, 156],
        [243, 264, 127, 156],
    ];

    ob_start();
    ?>
    <defs>
        <linearGradient id="<?php echo $id; ?>-wall" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="<?php echo $p['wall_a']; ?>"/>
            <stop offset="1" stop-color="<?php echo $p['wall_b']; ?>"/>
        </linearGradient>
        <linearGradient id="<?php echo $id; ?>-glass" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="<?php echo $p['glass_a']; ?>"/>
            <stop offset="0.62" stop-color="<?php echo $p['glass_b']; ?>"/>
            <stop offset="1" stop-color="<?php echo $p['glass_c']; ?>"/>
        </linearGradient>
        <linearGradient id="<?php echo $id; ?>-curtain" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="<?php echo $p['curtain_fold']; ?>"/>
            <stop offset="0.3" stop-color="<?php echo $p['curtain_hi']; ?>"/>
            <stop offset="0.55" stop-color="<?php echo $p['curtain']; ?>"/>
            <stop offset="0.8" stop-color="<?php echo $p['curtain_hi']; ?>"/>
            <stop offset="1" stop-color="<?php echo $p['curtain_fold']; ?>"/>
        </linearGradient>
        <linearGradient id="<?php echo $id; ?>-rad" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="<?php echo $p['rad_shade']; ?>"/>
            <stop offset="0.45" stop-color="<?php echo $p['rad']; ?>"/>
            <stop offset="1" stop-color="<?php echo $p['rad_shade']; ?>"/>
        </linearGradient>
        <filter id="<?php echo $id; ?>-soft" x="-30%" y="-30%" width="160%" height="160%"><feGaussianBlur stdDeviation="7"/></filter>
        <filter id="<?php echo $id; ?>-softer" x="-40%" y="-40%" width="180%" height="180%"><feGaussianBlur stdDeviation="14"/></filter>
        <filter id="<?php echo $id; ?>-hair" x="-10%" y="-10%" width="120%" height="120%"><feGaussianBlur stdDeviation="1.6"/></filter>
        <?php foreach ($panes as $i => $pane) : ?>
            <clipPath id="<?php echo $id; ?>-pane-<?php echo $i; ?>"><rect x="<?php echo $pane[0]; ?>" y="<?php echo $pane[1]; ?>" width="<?php echo $pane[2]; ?>" height="<?php echo $pane[3]; ?>"/></clipPath>
        <?php endforeach; ?>
        <clipPath id="<?php echo $id; ?>-panes">
            <?php foreach ($panes as $pane) : ?>
                <rect x="<?php echo $pane[0]; ?>" y="<?php echo $pane[1]; ?>" width="<?php echo $pane[2]; ?>" height="<?php echo $pane[3]; ?>"/>
            <?php endforeach; ?>
        </clipPath>
    </defs>

    <?php /* The wall. */ ?>
    <rect width="480" height="620" fill="url(#<?php echo $id; ?>-wall)"/>
    <?php if ($thermal) : ?>
        <?php /* A wall is coldest where it meets the window, and warmest above the radiator. */ ?>
        <rect x="44" y="18" width="392" height="462" rx="30" fill="<?php echo $p['halo']; ?>" opacity="0.85" filter="url(#<?php echo $id; ?>-softer)"/>
        <ellipse cx="240" cy="500" rx="170" ry="46" fill="#ffe27a" opacity="0.9" filter="url(#<?php echo $id; ?>-softer)"/>
    <?php endif; ?>

    <?php /* Curtain pole. */ ?>
    <rect x="26" y="19" width="428" height="6" rx="3" fill="<?php echo $p['pole']; ?>"/>
    <circle cx="24" cy="22" r="6" fill="<?php echo $p['pole']; ?>"/>
    <circle cx="456" cy="22" r="6" fill="<?php echo $p['pole']; ?>"/>

    <?php /* Architrave and box frame. */ ?>
    <rect x="70" y="40" width="340" height="410" rx="3" fill="<?php echo $p['arch']; ?>" stroke="<?php echo $p['arch_line']; ?>" stroke-width="1.5"/>
    <rect x="80" y="50" width="320" height="400" rx="2" fill="<?php echo $p['arch_shade']; ?>" stroke="<?php echo $p['arch_line']; ?>" stroke-width="1"/>
    <rect x="92" y="62" width="296" height="386" fill="<?php echo $thermal ? $p['gap'] : '#9fb2b4'; ?>"/>

    <?php /* Top sash, the outer of the two. */ ?>
    <rect x="96" y="66" width="288" height="192" fill="<?php echo $p['sash_shade']; ?>" stroke="<?php echo $p['sash_line']; ?>" stroke-width="1"/>
    <?php /* Bottom sash, nearer the room, lapping the top one at the meeting rails. */ ?>
    <rect x="96" y="250" width="288" height="196" fill="<?php echo $p['sash']; ?>" stroke="<?php echo $p['sash_line']; ?>" stroke-width="1"/>

    <?php /* Glass. */ ?>
    <g>
        <?php foreach ($panes as $pane) : ?>
            <rect x="<?php echo $pane[0]; ?>" y="<?php echo $pane[1]; ?>" width="<?php echo $pane[2]; ?>" height="<?php echo $pane[3]; ?>" fill="url(#<?php echo $id; ?>-glass)"/>
        <?php endforeach; ?>
    </g>

    <?php if (! $thermal) : ?>
        <?php /* The street outside: rooftops, a few lit windows, snow. */ ?>
        <g clip-path="url(#<?php echo $id; ?>-panes)">
            <path d="M96 392 L128 362 L160 392 L160 372 L204 372 L204 350 L236 322 L268 350 L268 380 L300 380 L318 360 L350 360 L350 386 L384 386 L384 448 L96 448 Z" fill="#5c7d95" opacity="0.5"/>
            <path d="M96 410 L150 410 L150 396 L196 396 L222 374 L248 396 L290 396 L290 404 L340 404 L360 388 L384 404 L384 448 L96 448 Z" fill="#4a6a82" opacity="0.62"/>
            <rect x="170" y="404" width="7" height="9" fill="#ffd27a"/>
            <rect x="216" y="392" width="7" height="9" fill="#ffd27a"/>
            <rect x="308" y="410" width="7" height="8" fill="#ffd27a" opacity="0.8"/>
            <rect x="140" y="376" width="6" height="8" fill="#ffd27a" opacity="0.7"/>
            <rect x="330" y="372" width="6" height="8" fill="#ffd27a" opacity="0.7"/>
            <g class="fg-warm-snow" fill="#ffffff">
                <?php
                $flakes = [[124, 96, 1.6], [156, 150, 1.2], [188, 110, 1.8], [214, 196, 1.3], [262, 90, 1.5], [288, 160, 1.9], [322, 118, 1.2], [352, 200, 1.6], [136, 300, 1.4], [176, 340, 1.8], [206, 284, 1.2], [270, 320, 1.6], [304, 286, 1.3], [336, 350, 1.8], [360, 300, 1.2], [148, 220, 1.5], [300, 232, 1.4], [232, 132, 1.1]];
                foreach ($flakes as $n => $flake) :
                    ?>
                    <circle cx="<?php echo $flake[0]; ?>" cy="<?php echo $flake[1]; ?>" r="<?php echo $flake[2]; ?>" opacity="0.9" style="--fg-warm-flake: <?php echo $n; ?>"/>
                <?php endforeach; ?>
            </g>
        </g>
        <?php /* Glass sheen. */ ?>
        <g clip-path="url(#<?php echo $id; ?>-panes)" fill="#ffffff" opacity="0.16">
            <path d="M120 80 L170 80 L96 190 L96 116 Z"/>
            <path d="M254 80 L282 80 L243 138 L243 96 Z"/>
            <path d="M118 264 L150 264 L110 324 L110 276 Z"/>
            <path d="M330 264 L370 264 L370 290 L296 400 L268 400 Z" opacity="0.6"/>
        </g>
    <?php else : ?>
        <?php /* Single glass is colder still towards its edges and at the bottom, where the cold air pools. */ ?>
        <g clip-path="url(#<?php echo $id; ?>-panes)">
            <rect x="100" y="372" width="280" height="60" fill="#1c1050" opacity="0.6" filter="url(#<?php echo $id; ?>-soft)"/>
            <rect x="100" y="214" width="280" height="40" fill="#1c1050" opacity="0.45" filter="url(#<?php echo $id; ?>-soft)"/>
            <ellipse cx="176" cy="150" rx="46" ry="52" fill="#3d5cc4" opacity="0.55" filter="url(#<?php echo $id; ?>-soft)"/>
            <ellipse cx="306" cy="150" rx="46" ry="52" fill="#3d5cc4" opacity="0.55" filter="url(#<?php echo $id; ?>-soft)"/>
            <ellipse cx="176" cy="326" rx="44" ry="40" fill="#3d5cc4" opacity="0.4" filter="url(#<?php echo $id; ?>-soft)"/>
            <ellipse cx="306" cy="326" rx="44" ry="40" fill="#3d5cc4" opacity="0.4" filter="url(#<?php echo $id; ?>-soft)"/>
        </g>
    <?php endif; ?>

    <?php /* Glazing bars. */ ?>
    <rect x="237" y="80" width="6" height="166" fill="<?php echo $p['bar']; ?>"/>
    <rect x="237" y="264" width="6" height="156" fill="<?php echo $p['bar']; ?>"/>

    <?php if (! $thermal) : ?>
        <?php /* Light and shade on the timber. */ ?>
        <rect x="96" y="250" width="288" height="3" fill="#ffffff"/>
        <rect x="96" y="443" width="288" height="3" fill="#d5e0df"/>
        <rect x="96" y="255" width="288" height="1" fill="#cfdada"/>
        <path d="M110 264 H370 M110 80 H370" stroke="#8aa0a6" stroke-width="1" opacity="0.5"/>
        <?php /* Sash cords. */ ?>
        <path d="M94 66 V250 M386 66 V250" stroke="#d9c9a3" stroke-width="2"/>
        <?php /* Pulleys at the head of each side. */ ?>
        <rect x="90" y="84" width="6" height="18" rx="2" fill="<?php echo $p['brass']; ?>"/>
        <rect x="384" y="84" width="6" height="18" rx="2" fill="<?php echo $p['brass']; ?>"/>
    <?php else : ?>
        <?php /* The draught paths: where the sashes meet, down each side, under the bottom rail, the pulleys. */ ?>
        <g filter="url(#<?php echo $id; ?>-hair)">
            <rect x="96" y="250" width="288" height="7" fill="<?php echo $p['gap']; ?>"/>
            <rect x="92" y="62" width="5" height="386" fill="<?php echo $p['gap']; ?>"/>
            <rect x="383" y="62" width="5" height="386" fill="<?php echo $p['gap']; ?>"/>
            <rect x="92" y="443" width="296" height="6" fill="<?php echo $p['gap']; ?>"/>
            <rect x="92" y="62" width="296" height="5" fill="<?php echo $p['gap']; ?>"/>
            <rect x="88" y="82" width="9" height="22" rx="3" fill="<?php echo $p['gap']; ?>"/>
            <rect x="383" y="82" width="9" height="22" rx="3" fill="<?php echo $p['gap']; ?>"/>
        </g>
        <?php /* Cold air spilling in at the meeting rail and falling off the sill. */ ?>
        <path d="M108 256 C150 270 190 262 240 274 C290 262 330 270 372 256 L372 300 C330 318 290 300 240 316 C190 300 150 318 108 300 Z" fill="#3f35b5" opacity="0.5" filter="url(#<?php echo $id; ?>-soft)"/>
        <path d="M84 446 H396 L404 488 C360 508 300 492 240 508 C180 492 120 508 76 488 Z" fill="#4458c6" opacity="0.62" filter="url(#<?php echo $id; ?>-soft)"/>
        <rect x="84" y="60" width="18" height="390" fill="#4a3fb8" opacity="0.5" filter="url(#<?php echo $id; ?>-soft)"/>
        <rect x="378" y="60" width="18" height="390" fill="#4a3fb8" opacity="0.5" filter="url(#<?php echo $id; ?>-soft)"/>
    <?php endif; ?>

    <?php /* Fastener on the meeting rail, lifts on the bottom rail. */ ?>
    <ellipse cx="240" cy="257" rx="15" ry="5.5" fill="<?php echo $p['brass']; ?>"/>
    <rect x="236" y="247" width="8" height="12" rx="3" fill="<?php echo $p['brass_dark']; ?>"/>
    <path d="M166 436 q8 -9 16 0 M298 436 q8 -9 16 0" fill="none" stroke="<?php echo $p['brass']; ?>" stroke-width="3" stroke-linecap="round"/>

    <?php /* Window board. */ ?>
    <rect x="54" y="448" width="372" height="15" rx="4" fill="<?php echo $p['sill']; ?>" stroke="<?php echo $p['arch_line']; ?>" stroke-width="1"/>
    <rect x="66" y="463" width="348" height="8" fill="<?php echo $p['sill_shade']; ?>"/>

    <?php /* Radiator. */ ?>
    <g>
        <rect x="118" y="506" width="244" height="88" rx="6" fill="url(#<?php echo $id; ?>-rad)" stroke="<?php echo $p['rad_line']; ?>" stroke-width="1.2"/>
        <?php for ($c = 0; $c < 11; $c++) : ?>
            <rect x="<?php echo 128 + ($c * 21); ?>" y="514" width="13" height="72" rx="6" fill="<?php echo $p['rad']; ?>" stroke="<?php echo $p['rad_line']; ?>" stroke-width="1"/>
        <?php endfor; ?>
        <rect x="104" y="574" width="14" height="8" rx="2" fill="<?php echo $p['rad_line']; ?>"/>
        <circle cx="103" cy="578" r="7" fill="<?php echo $thermal ? $p['rad'] : '#002d3a'; ?>"/>
        <rect x="134" y="594" width="6" height="12" fill="<?php echo $p['rad_line']; ?>"/>
        <rect x="340" y="594" width="6" height="12" fill="<?php echo $p['rad_line']; ?>"/>
    </g>
    <?php if ($thermal) : ?>
        <?php /* The radiator's heat rising to meet the cold coming off the window. */ ?>
        <path d="M130 506 C150 486 180 498 204 482 C230 496 252 480 276 494 C300 480 330 496 350 506 Z" fill="#fff3b0" opacity="0.8" filter="url(#<?php echo $id; ?>-soft)"/>
    <?php endif; ?>

    <?php /* Skirting board. */ ?>
    <rect x="0" y="606" width="480" height="14" fill="<?php echo $p['skirt']; ?>"/>
    <rect x="0" y="606" width="480" height="1.5" fill="<?php echo $p['skirt_line']; ?>"/>

    <?php /* Curtains, drawn back. */ ?>
    <g>
        <path d="M30 25 H70 C72 120 60 210 66 300 C70 400 58 500 64 590 H28 C34 500 24 400 30 300 C34 210 26 120 30 25 Z" fill="url(#<?php echo $id; ?>-curtain)"/>
        <path d="M42 25 C46 160 38 300 44 590 M56 25 C60 180 50 320 54 590" fill="none" stroke="<?php echo $p['curtain_fold']; ?>" stroke-width="1.5" opacity="0.7"/>
        <path d="M410 25 H450 C454 120 446 210 450 300 C456 400 446 500 452 590 H416 C410 500 422 400 414 300 C420 210 408 120 410 25 Z" fill="url(#<?php echo $id; ?>-curtain)"/>
        <path d="M424 25 C430 180 420 320 426 590 M438 25 C442 160 434 300 440 590" fill="none" stroke="<?php echo $p['curtain_fold']; ?>" stroke-width="1.5" opacity="0.7"/>
        <?php foreach ([34, 46, 58, 414, 426, 438] as $ring) : ?>
            <circle cx="<?php echo $ring + 4; ?>" cy="22" r="4.5" fill="none" stroke="<?php echo $p['pole']; ?>" stroke-width="1.6"/>
        <?php endforeach; ?>
    </g>
    <?php

    return (string) ob_get_clean();
}

/**
 * The draughts themselves, drawn over the room view: cold air curling in at
 * the meeting rail, down the sides and under the bottom rail.
 */
function fenster_warm_window_draughts(): string
{
    $wisps = [
        'M150 258 c14 12 30 -4 44 10 s26 -6 40 8',
        'M262 258 c14 12 30 -4 44 10 s26 -6 40 8',
        'M98 150 c16 6 10 22 26 26 s8 20 24 22',
        'M98 330 c16 6 10 22 26 26 s8 20 24 22',
        'M382 200 c-16 6 -10 22 -26 26 s-8 20 -24 22',
        'M382 360 c-16 6 -10 22 -26 26 s-8 20 -24 22',
        'M170 448 c10 14 28 4 40 18 s26 0 40 12',
        'M280 448 c10 14 28 4 40 18 s26 0 40 12',
    ];

    $out = '<g class="fg-warm-draughts" fill="none" stroke-linecap="round" aria-hidden="true">';
    foreach ($wisps as $n => $d) {
        $out .= sprintf('<path d="%s" pathLength="100" style="--fg-warm-wisp:%d"/>', $d, $n);
    }

    return $out . '</g>';
}
