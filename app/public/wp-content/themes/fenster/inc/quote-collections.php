<?php
/**
 * Which routes the online designer can put a price on, and the collection it
 * opens for each.
 *
 * WHY THIS FILE EXISTS. The homepage finder sends somebody who has just chosen
 * a product to `/online-quote/` with that product preselected, so choosing it
 * once is choosing it. Both ends of that need the same answer to "can this be
 * priced, and which collection is it" -- the finder, to decide whether it may
 * offer a price at all, and `online-quote.php`, to resolve the parameter. One
 * map, read by both.
 *
 * THERE IS A SECOND COPY OF THIS MAP AND IT IS DELIBERATE, FOR NOW.
 * `template-parts/sections/generated-page.php` carries `$product_quote_embeds`
 * for the product-page embeds. That file is one of the five held back from live
 * with the Distinction strand (see `HANDOVER.md`), so folding it onto this
 * function would entangle an unrelated change with that hold-back. **When the
 * hold-back resolves, make `generated-page.php` read this function and delete
 * its own array.** Until then, a collection added in one place has to be added
 * in the other, which is exactly the drift `AI.md` warns about.
 *
 * @package Fenster
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * The base retail designer, with no collection chosen.
 */
function fenster_quote_designer_url(): string
{
    return 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing';
}

/**
 * Route slug to WindowCAD collection.
 *
 * Values are the collection keys the tool itself uses, numeric for most and a
 * UUID for the two that were added later. Read off the account rather than
 * guessed; see the WindowCAD URL Parameter Rule in `AI.md` before adding one.
 *
 * @return array<string, string>
 */
function fenster_quote_collections(): array
{
    return [
        'casement-windows' => '0',
        'flush-casement-windows' => '0',
        'tilt-turn-windows' => '0',
        'double-glazing' => '0',
        'sliding-sash-windows' => '9',
        'aluminium-windows' => '5',
        'aluminium-flush-windows' => '5',
        'heritage-windows' => '5',
        'composite-doors' => '4',
        'upvc-doors' => '1',
        'patio-doors' => '2',
        'aluminium-bifold-doors' => '11',
        'aluminium-sliding-doors' => '7',
        'heritage-aluminium-doors' => '12',
        'aluminium-doors' => '6',
        'slide-fold-doors' => 'ad895968-3d4e-4bf5-901a-d3112b7631d2',
        'double-glazing-replacement' => '3',
        'secondary-glazing' => 'bd73ed10-ee26-4c12-b95e-6220826dc9d3',
    ];
}

/**
 * Routes the online tool cannot price at all.
 *
 * Same list, and the same reasoning, as `$no_instant_price_routes` in
 * `generated-page.php`: a blind unit is a sealed unit made to the host window,
 * and a repair has no specification to configure. Offering a price on either
 * promises a number the visitor cannot get.
 *
 * @return string[]
 */
function fenster_quote_unpriceable_routes(): array
{
    return ['integral-blinds', 'window-and-door-repairs'];
}

/**
 * Whether the online designer can put a price on this route at all.
 *
 * A configuration route counts as priceable and deliberately has no collection:
 * the tool prices one collection at a time, so pointing a page that says "uPVC
 * or aluminium" at either one picks a side the page does not. It falls through
 * to the all-products designer instead. See the Configuration Page Rule.
 */
function fenster_quote_can_price(string $slug): bool
{
    if (in_array($slug, fenster_quote_unpriceable_routes(), true)) {
        return false;
    }

    if (function_exists('fenster_is_configuration_route') && fenster_is_configuration_route($slug)) {
        return true;
    }

    return isset(fenster_quote_collections()[$slug]);
}

/**
 * The designer URL for a route: its own collection where it has one, otherwise
 * the all-products designer. Empty string for a route that cannot be priced.
 */
function fenster_quote_collection_url(string $slug): string
{
    if (! fenster_quote_can_price($slug)) {
        return '';
    }

    $collection = fenster_quote_collections()[$slug] ?? '';

    if ($collection === '') {
        return fenster_quote_designer_url();
    }

    return fenster_quote_designer_url() . '&productCollection=' . rawurlencode($collection);
}
