<?php
/**
 * Distinction composite door styles, as WindowCAD holds them.
 *
 * THE QUOTING TOOL IS THE SOURCE OF TRUTH AND THIS FILE MIRRORS IT. Every style
 * here is one a customer can actually configure and be priced for. Distinction
 * publish more designs than we carry, and the ruling is that the site shows what
 * our own quoting system can price rather than the full catalogue, so a visitor
 * never falls for a door we cannot quote. Captured 2026-08-26.
 *
 * SIDE PANELS ARE DELIBERATELY ABSENT. WindowCAD carries them as a seventh
 * collection; they are a configuration option rather than a door, which is the
 * position `AI.md` already records.
 *
 * THE COLLECTION NAMES ARE OURS, NOT DISTINCTION'S. Their own site is organised
 * as Signature, Contemporary, Grandeur and nxt-gen. Those names appear nowhere
 * customer-facing, because these six are what the customer meets in the quote
 * tool and on the showroom board.
 *
 * The line drawings in `assets/images/products/composite-distinction/styles-line/`
 * are generated from the same source and are named by style key.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * The quote tool, opened on one specific door.
 *
 * `style=` is only read by the composite designer. `interface=retail` accepts
 * `productCollection` and `product` and silently ignores everything else, so
 * this must stay `interface=composite`. Verified 2026-08-26 by loading both and
 * watching which slab each one fetched.
 *
 * ONE REAL COST, ACCEPTED BY THE OWNER 2026-08-26: the composite designer does
 * not carry `tracking=` through to the submission the way the retail one does,
 * so a lead starting here arrives with no FG2 journey and no ad attribution.
 * The parameter is still appended, so nothing here changes if it is ever fixed.
 */
function fenster_composite_door_quote_url(string $style_key, string $tracking = ''): string
{
    $url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=composite&username=fensterglazing&product=4&style='
        . rawurlencode($style_key);

    return $tracking !== '' ? $url . '&tracking=' . rawurlencode($tracking) : $url;
}

/**
 * The six collections a customer can buy, in the order the range is presented.
 */
function fenster_composite_door_collections(): array
{
    return [
        [
            'name'   => 'Traditional',
            'styles' => [
                ['key' => '247', 'name' => '3 Quarter Lite', 'slab' => '3 Quarter Lite', 'glass_options' => 4],
                ['key' => '0', 'name' => 'Elegance', 'slab' => '4 Panel Blank', 'glass_options' => 17],
                ['key' => '1', 'name' => 'Elegance Arch', 'slab' => '4 Panel Blank', 'glass_options' => 13],
                ['key' => '4', 'name' => 'Elegance with Grid', 'slab' => '4 Panel Blank', 'glass_options' => 1],
                ['key' => '5', 'name' => 'Elegance Arch  with Grid', 'slab' => '4 Panel Blank', 'glass_options' => 1],
                ['key' => '6', 'name' => 'New England Solid', 'slab' => '4 Panel', 'glass_options' => 0],
                ['key' => '7', 'name' => 'Esteem', 'slab' => '4 Panel', 'glass_options' => 16],
                ['key' => '8', 'name' => 'Esteem Arch', 'slab' => '4 Panel', 'glass_options' => 14],
                ['key' => '9', 'name' => 'Esteem Eyebrow', 'slab' => '4 Panel', 'glass_options' => 14],
                ['key' => '15', 'name' => 'New England Quarter', 'slab' => '4 Panel', 'glass_options' => 4],
                ['key' => '249', 'name' => 'ES08', 'slab' => '4 Panel', 'glass_options' => 15],
                ['key' => '16', 'name' => 'Eclat Arch', 'slab' => '4 Panel Blank', 'glass_options' => 15],
                ['key' => '17', 'name' => 'Eclat Arch with Grid', 'slab' => '4 Panel Blank', 'glass_options' => 1],
                ['key' => '18', 'name' => 'Eclat', 'slab' => '4 Panel Blank', 'glass_options' => 15],
                ['key' => '25', 'name' => '6 Panel Solid', 'slab' => '6 Panel', 'glass_options' => 0],
                ['key' => '26', 'name' => 'Classical', 'slab' => '6 Panel', 'glass_options' => 15],
                ['key' => '28', 'name' => 'Classical Half Glaze', 'slab' => '6 Panel', 'glass_options' => 15],
                ['key' => '33', 'name' => 'Craftsman', 'slab' => 'Craftsman', 'glass_options' => 8],
                ['key' => '6690602e-3ebe-4634-922e-31e819a9a4bf', 'name' => 'Prestige', 'slab' => '9 Panel', 'glass_options' => 2],
            ],
        ],
        [
            'name'   => 'Esprit',
            'styles' => [
                ['key' => '105', 'name' => 'ESC06C', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '104', 'name' => 'ESC06L', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '106', 'name' => 'ESC06R', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '108', 'name' => 'ESC07R', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '107', 'name' => 'ESC07L', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '111', 'name' => 'ESC09C', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '110', 'name' => 'ESC09L', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '112', 'name' => 'ESC09R', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '117', 'name' => 'ESC12C', 'slab' => 'Flush', 'glass_options' => 5],
                ['key' => '116', 'name' => 'ESC12L', 'slab' => 'Flush', 'glass_options' => 5],
                ['key' => '118', 'name' => 'ESC12R', 'slab' => 'Flush', 'glass_options' => 5],
                ['key' => '120', 'name' => 'ESC16C', 'slab' => 'Flush', 'glass_options' => 13],
                ['key' => '119', 'name' => 'ESC16L', 'slab' => 'Flush', 'glass_options' => 13],
                ['key' => '121', 'name' => 'ESC16R', 'slab' => 'Flush', 'glass_options' => 13],
                ['key' => '123', 'name' => 'ESC17C', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '122', 'name' => 'ESC17L', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '124', 'name' => 'ESC17R', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '126', 'name' => 'ESC18C', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '125', 'name' => 'ESC18L', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '127', 'name' => 'ESC18R', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '139', 'name' => 'ESC23C', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '138', 'name' => 'ESC23L', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '140', 'name' => 'ESC23R', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '142', 'name' => 'ESC25', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '144', 'name' => 'ESC26C', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '143', 'name' => 'ESC26L', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '145', 'name' => 'ESC26R', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '95', 'name' => 'Flush', 'slab' => 'Flush', 'glass_options' => 0],
                ['key' => '101', 'name' => 'ESC05L', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '102', 'name' => 'ESC05C', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '103', 'name' => 'ESC05R', 'slab' => 'Flush', 'glass_options' => 16],
                ['key' => '109', 'name' => 'ESC08 POA', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '113', 'name' => 'ESC10L', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '114', 'name' => 'ESC10C', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '115', 'name' => 'ESC10R', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '128', 'name' => 'ESC19L', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '129', 'name' => 'ESC19C', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '130', 'name' => 'ESC19R', 'slab' => 'Flush', 'glass_options' => 15],
                ['key' => '141', 'name' => 'ESC24', 'slab' => 'Flush', 'glass_options' => 17],
                ['key' => '148', 'name' => 'ESC29L', 'slab' => 'Flush', 'glass_options' => 14],
                ['key' => '149', 'name' => 'ESC29C', 'slab' => 'Flush', 'glass_options' => 14],
                ['key' => '150', 'name' => 'ESC29R', 'slab' => 'Flush', 'glass_options' => 14],
                ['key' => '154', 'name' => 'ESC33', 'slab' => 'Flush', 'glass_options' => 14],
            ],
        ],
        [
            'name'   => 'Rustic Renown',
            'styles' => [
                ['key' => '68', 'name' => 'RR01', 'slab' => 'Retail Cottage', 'glass_options' => 0],
                ['key' => '69', 'name' => 'RR02', 'slab' => 'Retail Cottage', 'glass_options' => 13],
                ['key' => '70', 'name' => 'RR03', 'slab' => 'Retail Cottage', 'glass_options' => 14],
                ['key' => '71', 'name' => 'RR04', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '72', 'name' => 'RR05L', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '73', 'name' => 'RR05C', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '74', 'name' => 'RR05R', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '75', 'name' => 'RR06L', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '76', 'name' => 'RR06R', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '77', 'name' => 'RR07', 'slab' => 'Retail Cottage', 'glass_options' => 17],
                ['key' => '78', 'name' => 'RR08', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '79', 'name' => 'RR09', 'slab' => 'Retail Cottage', 'glass_options' => 16],
                ['key' => '80', 'name' => 'RR10', 'slab' => 'Retail Cottage', 'glass_options' => 16],
                ['key' => '81', 'name' => 'RR11L', 'slab' => 'Retail Cottage', 'glass_options' => 5],
                ['key' => '82', 'name' => 'RR11C', 'slab' => 'Retail Cottage', 'glass_options' => 5],
                ['key' => '83', 'name' => 'RR11R', 'slab' => 'Retail Cottage', 'glass_options' => 5],
                ['key' => '84', 'name' => 'RR12L', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '85', 'name' => 'RR12C', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '86', 'name' => 'RR12R', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '87', 'name' => 'RR13L', 'slab' => 'Retail Cottage', 'glass_options' => 14],
                ['key' => '88', 'name' => 'RR13C', 'slab' => 'Retail Cottage', 'glass_options' => 14],
                ['key' => '89', 'name' => 'RR13R', 'slab' => 'Retail Cottage', 'glass_options' => 14],
                ['key' => '90', 'name' => 'RR15', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '91', 'name' => 'RR16L', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '92', 'name' => 'RR16R', 'slab' => 'Retail Cottage', 'glass_options' => 15],
                ['key' => '93', 'name' => 'RR17', 'slab' => 'Retail Cottage', 'glass_options' => 4],
                ['key' => '94', 'name' => 'RR18', 'slab' => 'Retail Cottage', 'glass_options' => 17],
            ],
        ],
        [
            'name'   => 'Renown',
            'styles' => [
                ['key' => '250', 'name' => 'RE01', 'slab' => 'Cottage', 'glass_options' => 0],
                ['key' => '251', 'name' => 'RE02', 'slab' => 'Cottage', 'glass_options' => 13],
                ['key' => '252', 'name' => 'RE03', 'slab' => 'Cottage', 'glass_options' => 14],
                ['key' => '253', 'name' => 'RE04', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '276', 'name' => 'RE05', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '262', 'name' => 'RE06', 'slab' => 'Cottage', 'glass_options' => 16],
                ['key' => '275', 'name' => 'REC39', 'slab' => 'Cottage', 'glass_options' => 4],
                ['key' => '261', 'name' => 'REC05C', 'slab' => 'Cottage', 'glass_options' => 16],
                ['key' => '259', 'name' => 'REC06', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '254', 'name' => 'REC09L', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '255', 'name' => 'REC09C', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '256', 'name' => 'REC09R', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '266', 'name' => 'REC10L', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '267', 'name' => 'REC10C', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '268', 'name' => 'REC10R', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '263', 'name' => 'REC14L', 'slab' => 'Cottage', 'glass_options' => 5],
                ['key' => '264', 'name' => 'REC14C', 'slab' => 'Cottage', 'glass_options' => 5],
                ['key' => '265', 'name' => 'REC14R', 'slab' => 'Cottage', 'glass_options' => 5],
                ['key' => '272', 'name' => 'REC15', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '269', 'name' => 'REC19L', 'slab' => 'Cottage', 'glass_options' => 14],
                ['key' => '270', 'name' => 'REC19C', 'slab' => 'Cottage', 'glass_options' => 14],
                ['key' => '271', 'name' => 'REC19R', 'slab' => 'Cottage', 'glass_options' => 14],
                ['key' => '260', 'name' => 'REC27', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '257', 'name' => 'REC35L', 'slab' => 'Cottage', 'glass_options' => 17],
                ['key' => '258', 'name' => 'REC35R', 'slab' => 'Cottage', 'glass_options' => 17],
            ],
        ],
        [
            'name'   => 'Infinity',
            'styles' => [
                ['key' => '46', 'name' => 'GD01', 'slab' => 'GD01', 'glass_options' => 0],
                ['key' => '47', 'name' => 'GD02L', 'slab' => 'GD01', 'glass_options' => 5],
                ['key' => '48', 'name' => 'GD02C', 'slab' => 'GD01', 'glass_options' => 5],
                ['key' => '49', 'name' => 'GD02R', 'slab' => 'GD01', 'glass_options' => 5],
                ['key' => '50', 'name' => 'GD03', 'slab' => 'GD03', 'glass_options' => 0],
                ['key' => '51', 'name' => 'GD04L', 'slab' => 'GD04', 'glass_options' => 0],
                ['key' => '52', 'name' => 'GD04R', 'slab' => 'GD04', 'glass_options' => 0],
                ['key' => '53', 'name' => 'GD05L', 'slab' => 'GD04', 'glass_options' => 15],
                ['key' => '54', 'name' => 'GD05R', 'slab' => 'GD04', 'glass_options' => 15],
                ['key' => '55', 'name' => 'GD06L', 'slab' => 'GD01', 'glass_options' => 16],
                ['key' => '56', 'name' => 'GD06C', 'slab' => 'GD01', 'glass_options' => 16],
                ['key' => '57', 'name' => 'GD06R', 'slab' => 'GD01', 'glass_options' => 16],
                ['key' => '58', 'name' => 'GD07', 'slab' => 'GD07', 'glass_options' => 0],
                ['key' => '59', 'name' => 'GD08L', 'slab' => 'GD07', 'glass_options' => 15],
                ['key' => '60', 'name' => 'GD08C', 'slab' => 'GD07', 'glass_options' => 15],
                ['key' => '61', 'name' => 'GD08R', 'slab' => 'GD07', 'glass_options' => 15],
                ['key' => '62', 'name' => 'GD09L', 'slab' => 'GD07', 'glass_options' => 5],
                ['key' => '63', 'name' => 'GD09C', 'slab' => 'GD07', 'glass_options' => 5],
                ['key' => '64', 'name' => 'GD09R', 'slab' => 'GD07', 'glass_options' => 5],
                ['key' => '65', 'name' => 'GD10L', 'slab' => 'GD07', 'glass_options' => 16],
                ['key' => '66', 'name' => 'GD10C', 'slab' => 'GD07', 'glass_options' => 16],
                ['key' => '67', 'name' => 'GD10R', 'slab' => 'GD07', 'glass_options' => 16],
                ['key' => '4044a810-10ec-4319-a9d5-1b4a638e27bf', 'name' => 'GD08C - Copy', 'slab' => 'GD07', 'glass_options' => 15],
            ],
        ],
        [
            'name'   => 'Stable Doors',
            'styles' => [
                ['key' => '38', 'name' => 'RES05', 'slab' => 'Cottage', 'glass_options' => 4],
                ['key' => '37', 'name' => 'RES04', 'slab' => 'Cottage', 'glass_options' => 15],
                ['key' => '36', 'name' => 'RES03', 'slab' => 'Cottage', 'glass_options' => 14],
                ['key' => '35', 'name' => 'RES02', 'slab' => 'Cottage', 'glass_options' => 13],
                ['key' => '34', 'name' => 'RES01', 'slab' => 'Cottage', 'glass_options' => 0],
            ],
        ],
    ];
}

/**
 * The line drawing for one style, as a URL, or '' where none exists.
 */
function fenster_composite_door_line_art(string $style_key): string
{
    $rel = '/assets/images/products/composite-distinction/styles-line/' . $style_key . '.svg';

    return is_readable(FENSTER_THEME_DIR . $rel) ? FENSTER_THEME_URI . $rel : '';
}
