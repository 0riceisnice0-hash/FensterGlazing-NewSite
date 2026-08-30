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
        'french-doors',
        'bow-bay-windows',
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
                'heading' => 'The centre stile is carried on the closing sash.',
                'copy' => 'A standard pair of windows has a mullion fixed to the frame between them, and it stays there whether the sashes are open or shut. On a French casement the two sashes are side-hung and close against each other, with the meeting stile carried on the closing leaf. Open both and the aperture is the full width of the frame.',
                'aside' => 'The arrangement changes how the opening works rather than what the window is made of, so it is specified on the window you were already choosing.',
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
            'products_copy' => 'The profile, colour, glass and hardware stay whatever that window already offers.',
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
            'highlight' => [
                'eyebrow' => 'Means of escape',
                'heading' => 'The clear opening is the full width of the frame.',
                'copy' => 'Where a habitable room needs a means of escape window, what decides it is the clear opening once the window is open. A fixed central mullion costs you twice: it takes width out of the middle, and it splits what is left into two apertures rather than one. A French pair opens the whole way across.',
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
                ['label' => 'Order of opening', 'value' => 'One leaf is the master and carries the handle, chosen at survey'],
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

        /* FRENCH DOORS. Owner, 2026-08-30: "possible in upvc, ali and heritage."
           Same arrangement as the French casement and the thing that names it --
           a pair of leaves closing against each other rather than against a
           fixed post -- so the page is built on the same template with its own
           products. No escape-window band here: a door is already a door, and
           the thing worth knowing is what the second leaf gives you. */
        'french-doors' => [
            'eyebrow' => 'Door configuration',
            'mechanic' => [
                'heading' => 'One leaf carries the stile the other closes against.',
                'copy' => 'A French door is a pair of hinged doors closing against one another rather than against a mullion. The meeting stile is carried on one leaf, so it swings away when that leaf does and the opening is the width of the frame rather than the width of one door.',
                'aside' => 'You choose the door, in uPVC or in aluminium, and have it hung as a pair.',
            ],
            'products_heading' => 'Three doors can be built as a pair.',
            'products_copy' => 'The profile, colour, glass and hardware stay whatever that door already offers.',
            'products' => [
                ['slug' => 'upvc-doors', 'material' => 'uPVC', 'note' => 'The standard uPVC door, hung as a pair rather than a single leaf.'],
                ['slug' => 'aluminium-doors', 'material' => 'Aluminium', 'note' => 'Sheerline aluminium, for slimmer frames around more glass.'],
                ['slug' => 'heritage-aluminium-doors', 'material' => 'Aluminium', 'note' => 'Steel-look heritage sections, with or without bars across the pair.'],
            ],
            'highlight' => [
                'eyebrow' => 'The opening you get',
                'heading' => 'One leaf for every day. Both when the width matters.',
                'copy' => 'Most of the time a French pair is used as a single door: one leaf carries the handle and is the one you walk through. The second is held shut top and bottom until you release it, and then the whole width is open. That is what the configuration is for, and it is the reason it suits a garden room, a patio or anywhere furniture has to come through.',
                'note' => 'Which leaf carries the handle, which way the pair opens, and the threshold detail underneath are all decided at the technical survey against how the room and the outside space are actually used.',
            ],
            'detail_heading' => 'How the pair is held shut.',
            'detail' => [
                ['label' => 'Meeting stile', 'value' => 'Carried on one leaf, so it travels with the door rather than staying in the opening'],
                ['label' => 'Master leaf', 'value' => 'Takes the handle and the multi-point lock, and is the leaf used day to day'],
                ['label' => 'Second leaf', 'value' => 'Held into the head and the cill by shootbolts, released when the full width is needed'],
                ['label' => 'Opening', 'value' => 'Inward or outward, and which leaf leads, both confirmed at survey'],
                ['label' => 'Glazing', 'value' => 'The same options as the door it is built in, including obscured glass and bars across the pair'],
            ],
            'colours' => [
                'copy' => 'The colour range is the range of the door you choose rather than anything the configuration decides, so a French pair is available in the full uPVC foil range or in any RAL colour on aluminium.',
                'links' => [
                    ['slug' => 'upvc-colours', 'label' => 'uPVC colours'],
                    ['slug' => 'aluminium-colours', 'label' => 'Aluminium colours'],
                ],
            ],
        ],

        /* BOW AND BAY. Owner, 2026-08-30: "available on all of our windows."
           The widest scope of the three, and the one where the configuration is
           a SHAPE rather than a pair: frames joined at an angle so the run
           projects past the wall. Every window we fit can sit in one, tilt and
           turn and sliding sash included, which is why all seven are listed. */
        'bow-bay-windows' => [
            'eyebrow' => 'Window configuration',
            'mechanic' => [
                'heading' => 'Frames joined at an angle, standing proud of the wall.',
                'copy' => 'A bay is a run of frames joined by angled posts, so the run steps out past the face of the wall. A bow does the same across more facets at shallower angles, which reads as a curve. What projects is the window you already chose, built as three, four or five lights rather than one, and the room gains the depth it projects.',
                'aside' => 'The shape is the arrangement of the frames. The window inside it is specified exactly as it would be on a flat elevation.',
            ],
            'products_heading' => 'Any of our windows can form a bay.',
            'products_copy' => 'The lights in a bay are ordinary windows joined together. Fixed panes, openers, or a mixture across the run.',
            'products' => [
                ['slug' => 'casement-windows', 'material' => 'uPVC', 'note' => 'The usual replacement for an existing uPVC or timber bay.'],
                ['slug' => 'flush-casement-windows', 'material' => 'uPVC', 'note' => 'Flush sashes across the run, for a period elevation.'],
                ['slug' => 'sliding-sash-windows', 'material' => 'uPVC', 'note' => 'Vertical sliders in a bay, as most Victorian bays were originally built.'],
                ['slug' => 'tilt-turn-windows', 'material' => 'uPVC', 'note' => 'Inward opening lights, cleaned from inside the room.'],
                ['slug' => 'aluminium-windows', 'material' => 'Aluminium', 'note' => 'Slim Prestige sightlines, so the angled posts take less of the glass.'],
                ['slug' => 'aluminium-flush-windows', 'material' => 'Aluminium', 'note' => 'The flush aluminium outer frame across the run.'],
                ['slug' => 'heritage-windows', 'material' => 'Aluminium', 'note' => 'Steel-look sections for a bay on a period frontage.'],
            ],
            'highlight' => [
                'eyebrow' => 'What holds it up',
                'heading' => 'A bay carries the wall above it.',
                'copy' => 'A bay stands proud of the wall, which means the wall above it is sitting on the bay rather than on the brickwork behind. On most houses that load is already carried by the existing frames, and replacing them is the moment it has to be handled properly rather than assumed.',
                'criteria_heading' => 'What we check before it is ordered',
                'criteria' => [
                    ['label' => 'What is above', 'value' => 'Roof, brickwork or a second bay'],
                    ['label' => 'How it is carried', 'value' => 'Existing loading, and what replaces it'],
                    ['label' => 'The angle', 'value' => 'Set angles for a bay, shallower facets for a bow'],
                ],
                'note' => 'This is a survey question rather than a catalogue one, and it is the reason a bay is measured and specified before anything is priced as fitted. Where support is needed it is specified as part of the job.',
            ],
            'detail_heading' => 'What gets decided on a bay.',
            'detail' => [
                ['label' => 'Shape', 'value' => 'Bay in set angles, or bow across more facets for a curve'],
                ['label' => 'Lights', 'value' => 'Three, four or five across the run, fixed or opening in any mix'],
                ['label' => 'Posts', 'value' => 'The angled joints between lights, in the same colour as the frames'],
                ['label' => 'Below the glass', 'value' => 'Cill, and the board or brickwork carrying the run'],
                ['label' => 'Colour', 'value' => 'Matched across the whole run inside and out, so it reads as a single window'],
            ],
            'colours' => [
                'copy' => 'The colour range is the range of the window you choose rather than anything the shape decides, so a bay is available in the full uPVC foil range or in any RAL colour on aluminium.',
                'links' => [
                    ['slug' => 'upvc-colours', 'label' => 'uPVC colours'],
                    ['slug' => 'aluminium-colours', 'label' => 'Aluminium colours'],
                ],
            ],
        ],
    ];

    return $data[$slug] ?? [];
}
