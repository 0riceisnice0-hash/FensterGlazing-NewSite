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
                ['key' => '247', 'name' => '3 Quarter Lite', 'label' => '3 Quarter Lite', 'poa' => false, 'slab' => '3 Quarter Lite', 'glass_options' => 4, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '0', 'name' => 'Elegance', 'label' => 'Elegance', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 17, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '1', 'name' => 'Elegance Arch', 'label' => 'Elegance Arch', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 13, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 1]],
                ['key' => '4', 'name' => 'Elegance with Grid', 'label' => 'Elegance with Grid', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 1, 'traits' => ['glass' => 3, 'detail' => 2, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '5', 'name' => 'Elegance Arch  with Grid', 'label' => 'Elegance Arch  with Grid', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 1, 'traits' => ['glass' => 2, 'detail' => 2, 'curved' => 1, 'modern' => 0, 'apertures' => 1]],
                ['key' => '6', 'name' => 'New England Solid', 'label' => 'New England Solid', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 0]],
                ['key' => '7', 'name' => 'Esteem', 'label' => 'Esteem', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 16, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 2]],
                ['key' => '8', 'name' => 'Esteem Arch', 'label' => 'Esteem Arch', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 14, 'traits' => ['glass' => 3, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 2]],
                ['key' => '9', 'name' => 'Esteem Eyebrow', 'label' => 'Esteem Eyebrow', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 14, 'traits' => ['glass' => 3, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 2]],
                ['key' => '15', 'name' => 'New England Quarter', 'label' => 'New England Quarter', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 4, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '249', 'name' => 'ES08', 'label' => 'ES08', 'poa' => false, 'slab' => '4 Panel', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 2]],
                ['key' => '16', 'name' => 'Eclat Arch', 'label' => 'Eclat Arch', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 15, 'traits' => ['glass' => 0, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 1]],
                ['key' => '17', 'name' => 'Eclat Arch with Grid', 'label' => 'Eclat Arch with Grid', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 1, 'traits' => ['glass' => 0, 'detail' => 2, 'curved' => 1, 'modern' => 0, 'apertures' => 1]],
                ['key' => '18', 'name' => 'Eclat', 'label' => 'Eclat', 'poa' => false, 'slab' => '4 Panel Blank', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 2, 'curved' => 1, 'modern' => 0, 'apertures' => 3]],
                ['key' => '25', 'name' => '6 Panel Solid', 'label' => '6 Panel Solid', 'poa' => false, 'slab' => '6 Panel', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 0]],
                ['key' => '26', 'name' => 'Classical', 'label' => 'Classical', 'poa' => false, 'slab' => '6 Panel', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 2]],
                ['key' => '28', 'name' => 'Classical Half Glaze', 'label' => 'Classical Half Glaze', 'poa' => false, 'slab' => '6 Panel', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '33', 'name' => 'Craftsman', 'label' => 'Craftsman', 'poa' => false, 'slab' => 'Craftsman', 'glass_options' => 8, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 1]],
                ['key' => '6690602e-3ebe-4634-922e-31e819a9a4bf', 'name' => 'Prestige', 'label' => 'Prestige', 'poa' => false, 'slab' => '9 Panel', 'glass_options' => 2, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
            ],
        ],
        [
            'name'   => 'Esprit',
            'styles' => [
                ['key' => '105', 'name' => 'ESC06C', 'label' => 'ESC06C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 2]],
                ['key' => '104', 'name' => 'ESC06L', 'label' => 'ESC06L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 2]],
                ['key' => '106', 'name' => 'ESC06R', 'label' => 'ESC06R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 2]],
                ['key' => '108', 'name' => 'ESC07R', 'label' => 'ESC07R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 5]],
                ['key' => '107', 'name' => 'ESC07L', 'label' => 'ESC07L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 5]],
                ['key' => '111', 'name' => 'ESC09C', 'label' => 'ESC09C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '110', 'name' => 'ESC09L', 'label' => 'ESC09L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '112', 'name' => 'ESC09R', 'label' => 'ESC09R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '117', 'name' => 'ESC12C', 'label' => 'ESC12C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '116', 'name' => 'ESC12L', 'label' => 'ESC12L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '118', 'name' => 'ESC12R', 'label' => 'ESC12R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '120', 'name' => 'ESC16C', 'label' => 'ESC16C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 13, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '119', 'name' => 'ESC16L', 'label' => 'ESC16L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 13, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '121', 'name' => 'ESC16R', 'label' => 'ESC16R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 13, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '123', 'name' => 'ESC17C', 'label' => 'ESC17C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '122', 'name' => 'ESC17L', 'label' => 'ESC17L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '124', 'name' => 'ESC17R', 'label' => 'ESC17R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '126', 'name' => 'ESC18C', 'label' => 'ESC18C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '125', 'name' => 'ESC18L', 'label' => 'ESC18L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '127', 'name' => 'ESC18R', 'label' => 'ESC18R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '139', 'name' => 'ESC23C', 'label' => 'ESC23C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '138', 'name' => 'ESC23L', 'label' => 'ESC23L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '140', 'name' => 'ESC23R', 'label' => 'ESC23R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '142', 'name' => 'ESC25', 'label' => 'ESC25', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 0, 'detail' => 1, 'curved' => 1, 'modern' => 1, 'apertures' => 2]],
                ['key' => '144', 'name' => 'ESC26C', 'label' => 'ESC26C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '143', 'name' => 'ESC26L', 'label' => 'ESC26L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '145', 'name' => 'ESC26R', 'label' => 'ESC26R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '95', 'name' => 'Flush', 'label' => 'Flush', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '101', 'name' => 'ESC05L', 'label' => 'ESC05L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '102', 'name' => 'ESC05C', 'label' => 'ESC05C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '103', 'name' => 'ESC05R', 'label' => 'ESC05R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '109', 'name' => 'ESC08 POA', 'label' => 'ESC08 POA', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 3, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 4]],
                ['key' => '113', 'name' => 'ESC10L', 'label' => 'ESC10L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '114', 'name' => 'ESC10C', 'label' => 'ESC10C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '115', 'name' => 'ESC10R', 'label' => 'ESC10R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '128', 'name' => 'ESC19L', 'label' => 'ESC19L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '129', 'name' => 'ESC19C', 'label' => 'ESC19C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '130', 'name' => 'ESC19R', 'label' => 'ESC19R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '141', 'name' => 'ESC24', 'label' => 'ESC24', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 17, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '148', 'name' => 'ESC29L', 'label' => 'ESC29L', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '149', 'name' => 'ESC29C', 'label' => 'ESC29C', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '150', 'name' => 'ESC29R', 'label' => 'ESC29R', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '154', 'name' => 'ESC33', 'label' => 'ESC33', 'poa' => false, 'slab' => 'Flush', 'glass_options' => 14, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
            ],
        ],
        [
            'name'   => 'Rustic Renown',
            'styles' => [
                ['key' => '68', 'name' => 'RR01', 'label' => 'RR01', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 0]],
                ['key' => '69', 'name' => 'RR02', 'label' => 'RR02', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 13, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '70', 'name' => 'RR03', 'label' => 'RR03', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 14, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '71', 'name' => 'RR04', 'label' => 'RR04', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '72', 'name' => 'RR05L', 'label' => 'RR05L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '73', 'name' => 'RR05C', 'label' => 'RR05C', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '74', 'name' => 'RR05R', 'label' => 'RR05R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '75', 'name' => 'RR06L', 'label' => 'RR06L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '76', 'name' => 'RR06R', 'label' => 'RR06R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '77', 'name' => 'RR07', 'label' => 'RR07', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '78', 'name' => 'RR08', 'label' => 'RR08', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 2]],
                ['key' => '79', 'name' => 'RR09', 'label' => 'RR09', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '80', 'name' => 'RR10', 'label' => 'RR10', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 16, 'traits' => ['glass' => 0, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 2]],
                ['key' => '81', 'name' => 'RR11L', 'label' => 'RR11L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '82', 'name' => 'RR11C', 'label' => 'RR11C', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '83', 'name' => 'RR11R', 'label' => 'RR11R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '84', 'name' => 'RR12L', 'label' => 'RR12L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '85', 'name' => 'RR12C', 'label' => 'RR12C', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '86', 'name' => 'RR12R', 'label' => 'RR12R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '87', 'name' => 'RR13L', 'label' => 'RR13L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '88', 'name' => 'RR13C', 'label' => 'RR13C', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '89', 'name' => 'RR13R', 'label' => 'RR13R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '90', 'name' => 'RR15', 'label' => 'RR15', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '91', 'name' => 'RR16L', 'label' => 'RR16L', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '92', 'name' => 'RR16R', 'label' => 'RR16R', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '93', 'name' => 'RR17', 'label' => 'RR17', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 4, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '94', 'name' => 'RR18', 'label' => 'RR18', 'poa' => false, 'slab' => 'Retail Cottage', 'glass_options' => 17, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
            ],
        ],
        [
            'name'   => 'Renown',
            'styles' => [
                ['key' => '250', 'name' => 'RE01', 'label' => 'RE01', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 0]],
                ['key' => '251', 'name' => 'RE02', 'label' => 'RE02', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 13, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '252', 'name' => 'RE03', 'label' => 'RE03', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 14, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '253', 'name' => 'RE04', 'label' => 'RE04', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '276', 'name' => 'RE05', 'label' => 'RE05', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 3, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '262', 'name' => 'RE06', 'label' => 'RE06', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 16, 'traits' => ['glass' => 0, 'detail' => 1, 'curved' => 1, 'modern' => 0, 'apertures' => 2]],
                ['key' => '275', 'name' => 'REC39', 'label' => 'REC39', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 4, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '261', 'name' => 'REC05C', 'label' => 'REC05C', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '259', 'name' => 'REC06', 'label' => 'REC06', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '254', 'name' => 'REC09L', 'label' => 'REC09L', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '255', 'name' => 'REC09C', 'label' => 'REC09C', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '256', 'name' => 'REC09R', 'label' => 'REC09R', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '266', 'name' => 'REC10L', 'label' => 'REC10L', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '267', 'name' => 'REC10C', 'label' => 'REC10C', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '268', 'name' => 'REC10R', 'label' => 'REC10R', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '263', 'name' => 'REC14L', 'label' => 'REC14L', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '264', 'name' => 'REC14C', 'label' => 'REC14C', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '265', 'name' => 'REC14R', 'label' => 'REC14R', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '272', 'name' => 'REC15', 'label' => 'REC15', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '269', 'name' => 'REC19L', 'label' => 'REC19L', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '270', 'name' => 'REC19C', 'label' => 'REC19C', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '271', 'name' => 'REC19R', 'label' => 'REC19R', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 14, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 3]],
                ['key' => '260', 'name' => 'REC27', 'label' => 'REC27', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 2]],
                ['key' => '257', 'name' => 'REC35L', 'label' => 'REC35L', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
                ['key' => '258', 'name' => 'REC35R', 'label' => 'REC35R', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 17, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 0, 'apertures' => 4]],
            ],
        ],
        [
            'name'   => 'Infinity',
            'styles' => [
                ['key' => '46', 'name' => 'GD01', 'label' => 'GD01', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '47', 'name' => 'GD02L', 'label' => 'GD02L', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '48', 'name' => 'GD02C', 'label' => 'GD02C', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '49', 'name' => 'GD02R', 'label' => 'GD02R', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '50', 'name' => 'GD03', 'label' => 'GD03', 'poa' => false, 'slab' => 'GD03', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '51', 'name' => 'GD04L', 'label' => 'GD04L', 'poa' => false, 'slab' => 'GD04', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '52', 'name' => 'GD04R', 'label' => 'GD04R', 'poa' => false, 'slab' => 'GD04', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '53', 'name' => 'GD05L', 'label' => 'GD05L', 'poa' => false, 'slab' => 'GD04', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '54', 'name' => 'GD05R', 'label' => 'GD05R', 'poa' => false, 'slab' => 'GD04', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '55', 'name' => 'GD06L', 'label' => 'GD06L', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '56', 'name' => 'GD06C', 'label' => 'GD06C', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '57', 'name' => 'GD06R', 'label' => 'GD06R', 'poa' => false, 'slab' => 'GD01', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '58', 'name' => 'GD07', 'label' => 'GD07', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 0]],
                ['key' => '59', 'name' => 'GD08L', 'label' => 'GD08L', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '60', 'name' => 'GD08C', 'label' => 'GD08C', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '61', 'name' => 'GD08R', 'label' => 'GD08R', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
                ['key' => '62', 'name' => 'GD09L', 'label' => 'GD09L', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '63', 'name' => 'GD09C', 'label' => 'GD09C', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '64', 'name' => 'GD09R', 'label' => 'GD09R', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 5, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '65', 'name' => 'GD10L', 'label' => 'GD10L', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '66', 'name' => 'GD10C', 'label' => 'GD10C', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '67', 'name' => 'GD10R', 'label' => 'GD10R', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 16, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 1, 'apertures' => 1]],
                ['key' => '4044a810-10ec-4319-a9d5-1b4a638e27bf', 'name' => 'GD08C - Copy', 'label' => 'GD08C - Copy', 'poa' => false, 'slab' => 'GD07', 'glass_options' => 15, 'traits' => ['glass' => 2, 'detail' => 1, 'curved' => 0, 'modern' => 1, 'apertures' => 3]],
            ],
        ],
        [
            'name'   => 'Stable Doors',
            'styles' => [
                ['key' => '38', 'name' => 'RES05', 'label' => 'RES05', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 4, 'traits' => ['glass' => 2, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '37', 'name' => 'RES04', 'label' => 'RES04', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 15, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '36', 'name' => 'RES03', 'label' => 'RES03', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 14, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '35', 'name' => 'RES02', 'label' => 'RES02', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 13, 'traits' => ['glass' => 1, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 1]],
                ['key' => '34', 'name' => 'RES01', 'label' => 'RES01', 'poa' => false, 'slab' => 'Cottage', 'glass_options' => 0, 'traits' => ['glass' => 0, 'detail' => 0, 'curved' => 0, 'modern' => 0, 'apertures' => 0]],
            ],
        ],
    ];
}

/**
 * The line drawing for one style, as a URL, or '' where none exists.
 *
 * VERSIONED ON `filemtime`, WHICH THE REST OF THE THEME'S IMAGES ARE NOT.
 * `AI.md` records what that costs: theme image URLs carry no version string, so
 * replacing one in place leaves every cached browser and the proxy serving the
 * old artwork while the deploy verifies perfectly. It cost a review round on
 * the pet flap crops, and it cost one here — three screenshots of this section
 * showed the previous drawings minutes after the corrected ones were live, and
 * the served files had to be hashed to prove the deploy was fine.
 *
 * These 151 files are generated and will be regenerated, so they are precisely
 * the case that needs it. The general fix — versioning inside the shared image
 * helper — would change every image URL on the site and needs its own pass.
 */
function fenster_composite_door_line_art(string $style_key): string
{
    $rel = '/assets/images/products/composite-distinction/styles-line/' . $style_key . '.svg';
    $abs = FENSTER_THEME_DIR . $rel;

    if (! is_readable($abs)) {
        return '';
    }

    return FENSTER_THEME_URI . $rel . '?v=' . filemtime($abs);
}

/**
 * One version stamp for the whole drawing set.
 *
 * The quiz builds its result image in JavaScript from a key, so it cannot call
 * `fenster_composite_door_line_art()` per door. The 142 files are written by one
 * import in a single pass, so the newest mtime moves whenever any of them is
 * regenerated, which is exactly the cache-busting behaviour needed and the
 * reason three screenshots showed stale drawings before this existed.
 */
function fenster_composite_door_line_art_version(): int
{
    static $version = null;
    if ($version !== null) {
        return $version;
    }

    $dir = FENSTER_THEME_DIR . '/assets/images/products/composite-distinction/styles-line';
    $newest = 0;
    foreach ((array) glob($dir . '/*.svg') as $file) {
        $newest = max($newest, (int) filemtime($file));
    }

    return $version = $newest;
}

/**
 * The drawings' base URL, for building one client-side.
 */
function fenster_composite_door_line_art_base(): string
{
    return FENSTER_THEME_URI . '/assets/images/products/composite-distinction/styles-line/';
}
