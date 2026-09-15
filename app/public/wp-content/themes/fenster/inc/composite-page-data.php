<?php
/** Photo-backed colour choices for the dedicated composite page.
 * Names and artwork are carried from the approved colour wall; no tinting.
 */
if (! defined('ABSPATH')) { exit; }
function fenster_composite_page_colours(): array
{
    return [
        ['name' => 'Anthracite Grey', 'ref' => '', 'swatch' => 'anthracite-grey', 'door' => 'anthracite-grey'],
        ['name' => 'Black', 'ref' => '', 'swatch' => 'standard-black', 'door' => 'black'],
        ['name' => 'Slate Grey', 'ref' => '', 'swatch' => 'slate-grey', 'colour_door' => 'slate-grey'],
        ['name' => 'Basalt Grey', 'ref' => '', 'swatch' => 'basalt-grey', 'colour_door' => 'basalt-grey'],
        ['name' => 'Buckingham Grey', 'ref' => '', 'swatch' => 'buckingham-grey', 'colour_door' => 'buckingham-grey'],
        ['name' => 'Light Grey', 'ref' => '', 'hex' => '#a8aaa5', 'door' => 'light-grey'],
        ['name' => 'Chartwell Green', 'ref' => '', 'swatch' => 'chartwell-green', 'door' => 'chartwell-green'],
        ['name' => 'Standard Green', 'ref' => '', 'swatch' => 'standard-green', 'colour_door' => 'standard-green'],
        ['name' => 'Pale Green', 'ref' => 'RAL 6021', 'swatch' => 'pale-green'],
        ['name' => 'Leaf Green', 'ref' => 'RAL 6002', 'swatch' => 'leaf-green'],
        ['name' => 'Distant Blue', 'ref' => 'RAL 5023', 'swatch' => 'distant-blue', 'door' => 'distant-blue'],
        ['name' => 'Pale Blue', 'ref' => '', 'hex' => '#9fbec0', 'door' => 'pale-blue'],
        ['name' => 'Standard Blue', 'ref' => '', 'swatch' => 'standard-blue'],
        ['name' => 'Steel Blue', 'ref' => '', 'swatch' => 'steel-blue'],
        ['name' => 'Ultramarine Blue', 'ref' => 'RAL 5002', 'swatch' => 'ultramarine-blue'],
        ['name' => 'Turquoise Blue', 'ref' => 'RAL 5018', 'swatch' => 'turquoise-blue'],
        ['name' => 'Ruby Red', 'ref' => 'RAL 3003', 'hex' => '#8c1f2b', 'door' => 'ruby-red'],
        ['name' => 'Traffic Red', 'ref' => 'RAL 3020', 'swatch' => 'traffic-red', 'colour_door' => 'traffic-red'],
        ['name' => 'Wine Red', 'ref' => 'RAL 3005', 'swatch' => 'wine-red', 'colour_door' => 'wine-red'],
        ['name' => 'Standard Red', 'ref' => '', 'swatch' => 'standard-red'],
        ['name' => 'Telemagenta', 'ref' => 'RAL 4010', 'swatch' => 'telemagenta'],
        ['name' => 'Purple Violet', 'ref' => 'RAL 4007', 'swatch' => 'purple-violet', 'colour_door' => 'purple-violet'],
        ['name' => 'Colza Yellow', 'ref' => 'RAL 1021', 'swatch' => 'colza-yellow', 'colour_door' => 'colza-yellow'],
        ['name' => 'Black Brown', 'ref' => '', 'swatch' => 'black-brown', 'colour_door' => 'black-brown'],
        ['name' => 'White', 'ref' => '', 'hex' => '#f2f0e8', 'door' => 'white'],
        ['name' => 'Gold Oak', 'ref' => 'Woodgrain stain', 'swatch' => 'gold-oak'],
        ['name' => 'Rosewood', 'ref' => 'Woodgrain stain', 'swatch' => 'rosewood'],
    ];
}
