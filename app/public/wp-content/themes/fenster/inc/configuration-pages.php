<?php
/**
 * Configuration pages.
 *
 * A CONFIGURATION IS NOT A PRODUCT, and this file exists because the site had
 * no way to say so. Owner, 2026-08-30, on French casement: "it's aimed
 * currently as just a liniar window thing but it's actually a configuration
 * where the mullion is floating like french doors ... it's a configuration page
 * rather than a true product so take that into account and link clearly to the
 * applicable products."
 *
 * A product page answers "what is this and why buy it". A configuration page
 * answers a different question: "what is this arrangement, which of your
 * products can I have it on, and which can I not". Run through the product
 * journey it inherits three bands that are true of ONE material and therefore
 * wrong here -- the Liniar EnergyPlus tech banner, the uPVC colour chart, and a
 * systems badge naming a single supplier -- which is exactly what the owner saw.
 *
 * BUILT TO BE CARRIED OVER. The owner: "french doors and bay windows will also
 * be config pages rather than true products so the template can be carried over
 * (albeit different applicable products)." So everything route-specific lives in
 * the data below and the template renders whatever it is handed. Adding
 * `french-doors` or `bow-bay-windows` is a data entry plus one slug in
 * `fenster_configuration_routes()`; no template change.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Routes that are configurations rather than products.
 *
 * This is the single source of truth. `fenster_tech_banner_args()` and the uPVC
 * colour list both consult it so a configuration route cannot pick up a
 * single-material band by being left in a list somewhere -- which is how the
 * Liniar banner survived the first pass at this page.
 */
function fenster_configuration_routes(): array
{
    return [
        'french-casement-windows',
        /* 'french-doors' and 'bow-bay-windows' are configurations too and are
           expected here next. They are NOT listed yet: both still render their
           product content, and adding a slug here strips their tech banner and
           colour chart the moment it lands. Add the data entry below in the same
           commit as the slug. */
    ];
}

function fenster_is_configuration_route(string $slug): bool
{
    return in_array($slug, fenster_configuration_routes(), true);
}

/**
 * Content for one configuration page.
 *
 * `products` are rendered as links, so every slug here must be a real route --
 * the template resolves the label and the card image from the same helpers the
 * related band uses, rather than repeating names that would drift.
 */
function fenster_configuration_page_data(string $slug): array
{
    $data = [
        'french-casement-windows' => [
            'eyebrow' => 'Window configuration',
            'mechanic' => [
                'heading' => 'The centre post is not fixed. It travels with the sash.',
                'copy' => 'On a standard pair of windows there is a mullion down the middle, fixed to the frame, and it is still there when both windows are open. A French casement does away with it. The two sashes are side-hung and they meet each other, with the meeting stile carried on the closing leaf, so when the pair is open the aperture is the full width of the frame with nothing standing in it. It is the arrangement a pair of French doors uses, in a window.',
                'aside' => 'This is why it is a configuration rather than a range. It changes how the opening works, not what the window is made of, so it is specified on whichever window you were already choosing.',
            ],
            /* THE OWNER'S ANSWER, ASKED FOR RATHER THAN INFERRED, 2026-08-30.
               The phrasing was "all of our windows except t&t", and taken
               literally that includes sliding sash -- which has no side-hung
               leaves for a floating stile to belong to. Confirmed as: uPVC
               casement and flush, aluminium casement, flush and heritage. */
            'products_heading' => 'Five windows can be built this way.',
            /* SAY WHAT YOU CAN HAVE, NOT WHAT YOU CANNOT. There was a band here
               headed "Two cannot, and it is worth knowing before survey",
               listing tilt and turn and sliding sash with the reason for each. I
               argued it saved a conversation at survey; the owner's read,
               2026-08-30: "why are we stating what 'cant' be done. negative af."
               Theirs is the better call on a page whose job is to sell an
               arrangement. The five below ARE the answer -- anything absent from
               the list is not on it -- so nothing is actually lost except the
               tone. The matching FAQ went with it for the same reason. */
            'products_copy' => 'It is the same window, profile, colour and hardware you would have had, opening differently. Pick the window first and add the configuration to it.',
            'products' => [
                ['slug' => 'casement-windows', 'material' => 'uPVC', 'note' => 'The standard 70mm Liniar EnergyPlus casement, in a French pair.'],
                ['slug' => 'flush-casement-windows', 'material' => 'uPVC', 'note' => 'Flush sash faces, so the pair sits level with the frame all round.'],
                ['slug' => 'aluminium-windows', 'material' => 'Aluminium', 'note' => 'Sheerline Prestige, for the slimmest sightlines across the pair.'],
                ['slug' => 'aluminium-flush-windows', 'material' => 'Aluminium', 'note' => 'The flush Prestige outer frame, in a French pair.'],
                ['slug' => 'heritage-windows', 'material' => 'Aluminium', 'note' => 'Slim heritage sections where the elevation is period.'],
            ],
            /* EGRESS IS THE REASON MOST PEOPLE ARRIVE. Owner, 2026-08-30:
               "egress is totally applicable for french. it's perfect for that."
               An earlier pass had softened this to "we check it at survey",
               which was too cautious -- the wide unobstructed opening is the
               whole point of the configuration.

               The figures are Approved Document B's, stated as what the guidance
               asks for. What is deliberately NOT claimed is that any given unit
               passes: that depends on the size ordered, so the page says we size
               it and confirm it. Quoting the criteria is describing a
               regulation; promising compliance on an unspecified window is not
               ours to make in advance. */
            'egress' => [
                'heading' => 'It is the configuration you want for an escape window.',
                'copy' => 'Where a habitable room needs a means of escape window, the thing that decides it is the CLEAR opening once the window is open. A fixed central mullion works against you twice over: it takes width out of the middle, and the width it leaves is split into two halves rather than one aperture. A French pair opens the whole way across, so the clear opening is the frame.',
                'criteria_heading' => 'What Approved Document B asks for',
                'criteria' => [
                    ['label' => 'Clear openable area', 'value' => 'At least 0.33 m²'],
                    ['label' => 'Clear height and width', 'value' => 'At least 450mm each'],
                    ['label' => 'Height above floor', 'value' => 'Bottom of the opening 800mm to 1100mm'],
                ],
                'note' => 'Those are the criteria in the guidance, not a promise about a particular window: whether a unit meets them depends on the size it is made at. We work the clear opening out against the room at the technical survey, along with restrictors, handle height and safety glass, and confirm it before anything is ordered.',
            ],
            'detail_heading' => 'How the pair is held shut.',
            'detail' => [
                ['label' => 'Meeting stile', 'value' => 'Carried on the closing sash, so it swings away with the leaf rather than staying in the opening'],
                ['label' => 'Locking', 'value' => 'The closing sash shoots bolts into the head and the cill, so both leaves are held into the frame rather than into each other'],
                ['label' => 'Keeps', 'value' => 'Set where the two sashes meet, into the frame around the pair'],
                ['label' => 'Order of opening', 'value' => 'One leaf is the master and carries the handle; which one is a choice made at survey'],
                ['label' => 'Glazing', 'value' => 'The same options as the window it is built in, including obscured glass and Georgian or astragal bars across the pair'],
            ],
            /* REPLACES THE uPVC COLOUR CHART, which is gated off on a
               configuration route. Two links rather than one range, because the
               honest answer is that the colours are whichever window you picked.
               Owner's choice, 2026-08-30. */
            'colours' => [
                'copy' => 'The colour range is the range of the window you choose rather than anything the configuration decides, so a French pair is available in the full uPVC foil range or in any RAL colour on aluminium.',
                'links' => [
                    ['slug' => 'upvc-colours', 'label' => 'uPVC colours'],
                    ['slug' => 'aluminium-colours', 'label' => 'Aluminium colours'],
                ],
            ],
        ],
    ];

    return $data[$slug] ?? [];
}
