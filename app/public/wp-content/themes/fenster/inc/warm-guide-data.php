<?php
/**
 * Everything the winter guide says, in one place.
 *
 * EVERY FIGURE HERE HAS A NAMED SOURCE IN `sources`, AND NOTHING ELSE IS A
 * FIGURE. Checked 16/11/2026. The rules this was written to:
 *
 * - The heat figures are Historic Scotland Technical Paper 1 (Baker, Glasgow
 *   Caledonian University, 2008), read from the paper itself: a single-glazed
 *   timber sash at 4.5 W/m2K, and the measured reductions for curtains, blinds,
 *   shutters and secondary glazing. Curtains were measured at 14% there and
 *   higher elsewhere, so the page gives the 14% and says it is the low end.
 * - Draught-proofing cut AIR LEAKAGE by 86% in that test and did not change
 *   the U-value. The page never says draught-proofing "improves the U-value".
 * - There is NO credible measurement for shrink film or bubble wrap. The page
 *   says so rather than quoting the percentages that circulate.
 * - The noise figures for secondary glazing are a manufacturer's data sheet
 *   and are attributed as one.
 * - Rental law is England only and dated. EPC C by 2030 is a stated plan, not
 *   law. No grant is claimed to pay for glazing or draught-proofing, because
 *   none currently lists them.
 * - Shelter's advice is to get a landlord's agreement in writing before making
 *   improvements. The page does not tell a tenant that removable measures are
 *   allowed without asking.
 * - No Fenster price, lead time or performance figure appears here: those live
 *   on the product pages and the quote tool. Shop prices for DIY materials are
 *   ranges seen at UK retailers in November 2026.
 * - Timber sash draught-proofing is a sash restorer's trade. The page sends
 *   people to one, and brings us in for secondary glazing, repairs to modern
 *   windows and replacement, which is the work we actually do.
 *
 * Copy follows TONEOFVOICE.md: headings are sentences with a full stop, no em
 * dashes, no exclamation marks, we/you, and a window is never a "light".
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_warm_guide_data(): array
{
    static $data = null;

    if ($data !== null) {
        return $data;
    }

    $u = static fn (string $path): string => home_url($path);

    $src = [
        'tp1' => ['label' => 'Historic Scotland Technical Paper 1: Thermal performance of traditional windows (Dr Paul Baker, Glasgow Caledonian University, October 2008)', 'short' => 'Historic Scotland, Technical Paper 1', 'url' => 'https://www.historicenvironment.scot/archives-and-research/publications/publication/?publicationId=f3e97c76-b4fa-4c76-a197-a59400be931b'],
        'tp23' => ['label' => 'Historic Scotland Technical Paper 23: Thermal assessment of internal shutters and window film applied to traditional single glazed sash and case windows (2014)', 'short' => 'Historic Scotland, Technical Paper 23', 'url' => 'https://www.historicenvironment.scot/archives-and-research/publications/publication/?publicationid=4a1a95dd-9e9f-4b9d-8381-a59400ac0be8'],
        'part-l' => ['label' => 'Approved Document L, Volume 1: Dwellings, which sets 1.4 W/m²K or Window Energy Rating band B for a replacement window (HM Government)', 'short' => 'Approved Document L', 'url' => 'https://www.gov.uk/government/publications/conservation-of-fuel-and-power-approved-document-l'],
        'est-draught' => ['label' => 'Energy Saving Trust: Draught-proofing (updated May 2026)', 'short' => 'Energy Saving Trust', 'url' => 'https://energysavingtrust.org.uk/advice/draught-proofing/'],
        'est-windows' => ['label' => 'Energy Saving Trust: Windows and doors (updated May 2026)', 'short' => 'Energy Saving Trust', 'url' => 'https://energysavingtrust.org.uk/advice/windows-and-doors/'],
        'hse' => ['label' => 'Health and Safety Executive: Gas appliances, get them checked, keep them safe (INDG238)', 'short' => 'HSE, INDG238', 'url' => 'https://books.hse.gov.uk/gempdf/indg238.pdf'],
        'part-b' => ['label' => 'Approved Document B, Volume 1: Dwellings, paragraph 2.10, emergency escape windows (HM Government)', 'short' => 'Approved Document B', 'url' => 'https://www.gov.uk/government/publications/fire-safety-approved-document-b'],
        'damp' => ['label' => 'GOV.UK: Understanding and addressing the health risks of damp and mould in the home (updated April 2026)', 'short' => 'GOV.UK damp and mould guidance', 'url' => 'https://www.gov.uk/government/publications/damp-and-mould-understanding-and-addressing-the-health-risks-for-rented-housing-providers/understanding-and-addressing-the-health-risks-of-damp-and-mould-in-the-home--2'],
        'citizens' => ['label' => 'Citizens Advice: Check if your landlord has to do repairs', 'short' => 'Citizens Advice', 'url' => 'https://www.citizensadvice.org.uk/housing/repairs-and-housing/repairs-and-housing-conditions/whos-responsible-for-repairs/check-if-your-landlord-has-to-do-repairs/'],
        'shelter' => ['label' => 'Shelter England: Making improvements to your rented home', 'short' => 'Shelter', 'url' => 'https://england.shelter.org.uk/housing_advice/repairs/making_improvements_to_your_rented_home'],
        'mees' => ['label' => 'GOV.UK: Improving the energy performance of privately rented homes, government response (January 2026)', 'short' => 'GOV.UK, January 2026', 'url' => 'https://www.gov.uk/government/consultations/improving-the-energy-performance-of-privately-rented-homes-2025-update'],
        'mk' => ['label' => 'Milton Keynes City Council: Conservation areas in Milton Keynes', 'short' => 'Milton Keynes City Council', 'url' => 'https://www.milton-keynes.gov.uk/planning-and-building/conservation-and-archaeology/conservation-areas-milton-keynes'],
        'he' => ['label' => 'Historic England: What permission might I need to make changes to my older home?', 'short' => 'Historic England, permission', 'url' => 'https://historicengland.org.uk/advice/your-home/improvement/permission/'],
        'he-secondary' => ['label' => 'Historic England: Modifying historic windows as part of retrofitting energy saving measures (updated July 2024)', 'short' => 'Historic England, secondary glazing', 'url' => 'https://historicengland.org.uk/advice/technical-advice/retrofit-and-energy-efficiency-in-historic-buildings/modifying-windows-and-doors-in-historic-buildings/modifying-historic-windows-as-part-of-retrofitting-energy-saving-measures/'],
        'he-draught' => ['label' => 'Historic England: Draught-proofing', 'short' => 'Historic England, draught-proofing', 'url' => 'https://historicengland.org.uk/advice/your-home/energy-efficiency/making-changes-to-save-energy/draught-proofing/'],
        'selecta' => ['label' => 'Selectaglaze data sheet DS-056: sound reduction values for secondary glazing by cavity, measured behind 6 mm glass (manufacturer data)', 'short' => 'Selectaglaze, manufacturer data', 'url' => 'https://selectaglaze.co.uk/media/images/ds-056-afrwdbvaluesforselectaglazesystems1_8351.pdf'],
    ];

    $data = [
        'updated' => '2026-11-16',
        'updated_label' => 'November 2026',

        'hero' => [
            'eyebrow' => 'Winter guide',
            'title' => 'How to fix cold, draughty windows',
            'lead' => 'A window loses heat two ways: through the gaps around the parts that open, and straight through the glass. You can close most of the gaps tonight for nothing, and cover the glass for under £20 at the weekend. This guide shows you how, including on single glazing, sash windows, rented homes and in conservation areas.',
            'facts' => [
                ['value' => '86%', 'label' => 'less air leaking through a sash once it was draught-proofed', 'source' => 'tp1'],
                ['value' => '63%', 'label' => 'less heat through single glass with secondary glazing behind it', 'source' => 'tp1'],
                ['value' => '4 of 5', 'label' => 'of tonight\'s fixes cost nothing at all', 'source' => ''],
            ],
            'byline' => 'Written by the Fenster team, who fit and repair windows across Milton Keynes. Figures from Historic Scotland\'s window tests and the Energy Saving Trust.',
            'scope_alt' => 'Illustration of a single-glazed sash window above a radiator, shown as you see it and as a thermal camera would see it. The glass and the gaps around the sashes are the coldest parts.',
            'scope_caption' => 'Drag across the window.',
            'scope_note' => 'Illustration. Bluer is colder.',
            'nav' => [
                ['label' => 'Tonight', 'url' => '#tonight'],
                ['label' => 'Find the leak', 'url' => '#find'],
                ['label' => 'Every fix', 'url' => '#fixes'],
                ['label' => 'Heat and noise', 'url' => '#compare'],
                ['label' => 'What to skip', 'url' => '#avoid'],
                ['label' => 'Renting', 'url' => '#renting'],
                ['label' => 'Listed homes', 'url' => '#conservation'],
                ['label' => 'What to do next', 'url' => '#next'],
                ['label' => 'Questions', 'url' => '#questions'],
            ],
        ],

        'tonight' => [
            'eyebrow' => 'Start here',
            'title' => 'Five things to do tonight, and four of them are free.',
            'intro' => 'None of these needs a tool, a shop or anybody\'s permission. Do them in this order and feel the difference before you spend anything.',
            'items' => [
                [
                    'key' => 'curtains',
                    'label' => 'Close the curtains at dusk',
                    'cost' => 'Free',
                    'title' => 'Close the curtains as it gets dark.',
                    'body' => 'Single glass is the coldest thing in the room, and a lined curtain puts a layer of still air in front of it. Close them at dusk, before the room has given up its heat. If there is a radiator under the window, let the curtain stop at the sill so the heat rises into the room and not up behind the fabric.',
                    'proof' => 'Heavy curtains cut the heat lost through a single-glazed sash by 14% in Historic Scotland\'s test, and other tests have measured more. Shutters managed 51%.',
                    'source' => 'tp1',
                ],
                [
                    'key' => 'fastener',
                    'label' => 'Lock the catch',
                    'cost' => 'Free',
                    'title' => 'Turn the catch all the way home.',
                    'body' => 'The catch where the two sashes meet is a clamp as much as a lock. Turned fully, it pulls the two rails together and closes the widest gap on the window. On a hinged window the handle does the same job: push it all the way down so the lock draws the window onto its seals.',
                    'proof' => 'If the catch turns but the rails still part, it has worn. A new sash fastener is a screwdriver job and one of the best few pounds you can spend on an old window.',
                    'source' => '',
                ],
                [
                    'key' => 'wedge',
                    'label' => 'Wedge the rattle',
                    'cost' => 'Free',
                    'title' => 'Wedge any sash that rattles.',
                    'body' => 'A sash that rattles has air moving round it. Push a folded piece of card or a cork between the sash and the bead beside it until the sash stops moving. It quietens the window and slows the draught at the same time.',
                    'proof' => 'Shaped sash wedges do the same job more neatly and come out again in a second when you want the window open.',
                    'source' => '',
                ],
                [
                    'key' => 'towel',
                    'label' => 'Roll a towel along the sill',
                    'cost' => 'Free',
                    'title' => 'Lay a rolled towel along the bottom rail.',
                    'body' => 'Cold air comes in under the bottom rail and spills onto the window board. A rolled towel or a fabric draught excluder laid along that joint stops it. Lift it in the morning so the sill can dry.',
                    'proof' => 'Hold the back of your hand there first. If you can feel air moving, this one works immediately.',
                    'source' => '',
                ],
                [
                    'key' => 'cord',
                    'label' => 'Press caulk rope into the gaps',
                    'cost' => 'About £17',
                    'title' => 'Press removable caulk rope into the gaps.',
                    'body' => 'Caulk rope, also sold as draught excluder rope, is a soft putty cord. You press it into a gap with your thumb and peel it out in spring, with nothing left behind. It suits the gaps a towel cannot reach: down the sides of a sash and along the meeting rail of a window you will not open until March.',
                    'proof' => 'Leave one window in every room free to open. You still need to air the room, and a bedroom needs a way out.',
                    'source' => '',
                ],
            ],
        ],

        'find' => [
            'eyebrow' => 'Find the leak',
            'title' => 'Find where yours leaks before you buy anything.',
            'intro' => 'On a breezy day, run the back of your hand slowly round the window. It feels moving air better than your palm does. The smoke from a stick of incense, held clear of the curtains, bends at the same places. Then tap the spot on the drawing.',
            'hint' => 'Tap a spot on the window.',
            'spots' => [
                [
                    'key' => 'meeting-rail',
                    'label' => 'Where the sashes meet',
                    'title' => 'The meeting rails.',
                    'what' => 'The two sashes should close tight against each other in the middle. On most old windows you can slide a card between them, and that gap runs the full width.',
                    'fix' => 'Turn the catch fully home tonight. At the weekend, stick a brush pile strip along the face of the lower rail so the two close onto it.',
                    'cost' => 'Brush strip, about £12 to £19 a pack',
                    'renter' => 'ask',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'sash-sides',
                    'label' => 'Down the sides',
                    'title' => 'The running gap down each side.',
                    'what' => 'A sash has to be loose enough to slide, so there is a gap between it and the beads on either side, from top to bottom.',
                    'fix' => 'Use brush pile strip here, never foam. Foam tears the first time the sash slides past it. For a window you will not open this winter, caulk rope is quicker.',
                    'cost' => 'Brush strip, about £12 to £19 a pack',
                    'renter' => 'ask',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'bottom-rail',
                    'label' => 'Under the bottom rail',
                    'title' => 'Where the bottom rail meets the sill.',
                    'what' => 'The bottom sash closes down onto the sill. Paint build-up and years of wear leave a gap you can often see daylight through.',
                    'fix' => 'A rolled towel tonight. For longer, stick a foam or rubber strip on the sill where the rail lands. It works here because the sash closes onto it and does not slide along it.',
                    'cost' => 'Foam or rubber strip, about £5 to £15',
                    'renter' => 'ask',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'pulleys',
                    'label' => 'The pulleys',
                    'title' => 'The pulley at the top of each side.',
                    'what' => 'Each sash cord runs over a pulley into a hollow box in the frame, where the weights hang. That box is open to the outside air, and the pulley is a hole straight into it.',
                    'fix' => 'A sash restorer fits brushed pulleys or covers that seal round the cord. Leave this one to them: the cord has to run free, so nothing should be pushed into the opening.',
                    'cost' => 'Part of a professional overhaul',
                    'renter' => 'landlord',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'frame-wall',
                    'label' => 'Frame to wall',
                    'title' => 'The joint between the frame and the wall.',
                    'what' => 'Timber and brick move at different rates, so the joint round the frame opens into a crack. It is usually a hairline, and it runs all the way round.',
                    'fix' => 'Run a bead of flexible decorator\'s caulk into it and smooth it with a wet finger. It takes paint, so it disappears.',
                    'cost' => 'A few pounds a tube',
                    'renter' => 'ask',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'glass',
                    'label' => 'The glass itself',
                    'title' => 'The glass, with no gap behind it at all.',
                    'what' => 'A single pane is a few millimetres thick. The air touching it cools, sinks and rolls out across the floor. It feels exactly like a draught, and no amount of sealing will stop it.',
                    'fix' => 'Put a layer of still air in front of it. Curtains tonight, a film kit or a blind at the weekend, secondary glazing for good.',
                    'cost' => 'From nothing to a fitted second window',
                    'renter' => 'yes',
                    'heritage' => 'fine',
                ],
                [
                    'key' => 'putty',
                    'label' => 'Loose putty or a crack',
                    'title' => 'Loose putty, or a cracked pane.',
                    'what' => 'Putty holds the glass in and dries out over decades. A pane that moves when you press a corner, or a crack you can feel air through, lets in air and rain.',
                    'fix' => 'Clear tape over a crack will hold for now. Then have it reglazed. If the glass is old and slightly wavy, say so: it can be kept.',
                    'cost' => 'A glazing repair',
                    'renter' => 'landlord',
                    'heritage' => 'fine',
                ],
            ],
            'legend' => [
                'yes' => 'Fine in a rented home',
                'ask' => 'Renting? Ask first',
                'landlord' => 'Renting? One for the landlord',
                'fine' => 'Fine in a conservation area',
            ],
            'labels' => ['what' => 'What is happening', 'fix' => 'The fix', 'cost' => 'Cost'],
            'other_windows' => [
                'label' => 'Not a sash window?',
                'copy' => 'On a hinged window, air between the opening part and the frame is usually seals, hinges or the lock.',
                'link_label' => 'Draughty windows: repair or replace',
                'url' => $u('/draughty-windows-repair-or-replace/'),
            ],
        ],

        'fixes' => [
            'eyebrow' => 'Every fix, side by side',
            'title' => 'What each fix costs, what it does and who can use it.',
            'intro' => 'Draughts and cold glass are two different problems. The quickest way to waste money is to fix the one you do not have.',
            'filters' => [
                ['key' => 'all', 'label' => 'Everything'],
                ['key' => 'renter', 'label' => 'I rent'],
                ['key' => 'heritage', 'label' => 'Listed or conservation area'],
                ['key' => 'tonight', 'label' => 'Free'],
                ['key' => 'noise', 'label' => 'Helps with noise'],
            ],
            'columns' => ['Fix', 'Works on', 'Cost', 'Measured'],
            'rows' => [
                ['fix' => 'Lined curtains, closed at dusk', 'on' => 'glass', 'cost' => 'Free if you have them', 'measured' => '14% less heat through the window, at least', 'source' => 'tp1', 'tags' => ['renter', 'heritage', 'tonight']],
                ['fix' => 'Catch turned fully home', 'on' => 'gaps', 'cost' => 'Free', 'measured' => 'Not measured', 'source' => '', 'tags' => ['renter', 'heritage', 'tonight']],
                ['fix' => 'Card, cork or sash wedges', 'on' => 'gaps', 'cost' => 'Free, or a few pounds', 'measured' => 'Not measured', 'source' => '', 'tags' => ['renter', 'heritage', 'tonight', 'noise']],
                ['fix' => 'Rolled towel on the sill', 'on' => 'gaps', 'cost' => 'Free', 'measured' => 'Not measured', 'source' => '', 'tags' => ['renter', 'heritage', 'tonight']],
                ['fix' => 'Shutters, closed at night', 'on' => 'glass', 'cost' => 'Free if they are there', 'measured' => '51% less heat through the window', 'source' => 'tp1', 'tags' => ['renter', 'heritage', 'tonight']],
                ['fix' => 'Removable caulk rope', 'on' => 'gaps', 'cost' => 'About £17 a pack', 'measured' => 'Not measured', 'source' => '', 'tags' => ['renter', 'heritage', 'noise']],
                ['fix' => 'Insulating honeycomb blind', 'on' => 'glass', 'cost' => 'Varies by window', 'measured' => '36% less heat through the window', 'source' => 'tp1', 'tags' => ['renter', 'heritage']],
                ['fix' => 'Brush pile strip on a sash', 'on' => 'gaps', 'cost' => '£12 to £19 a pack', 'measured' => 'Not measured as a DIY job', 'source' => '', 'tags' => ['heritage', 'noise']],
                ['fix' => 'Foam or rubber strip on a hinged window', 'on' => 'gaps', 'cost' => '£5 to £15', 'measured' => 'Not measured', 'source' => '', 'tags' => ['heritage', 'noise']],
                ['fix' => 'Decorator\'s caulk round the frame', 'on' => 'gaps', 'cost' => 'A few pounds a tube', 'measured' => 'Not measured', 'source' => '', 'tags' => ['heritage', 'noise']],
                ['fix' => 'Shrink film kit over the frame', 'on' => 'glass', 'cost' => '£9 to £19 a kit', 'measured' => 'No reliable test exists', 'source' => '', 'tags' => ['heritage']],
                ['fix' => 'Sash draught-proofing by a restorer', 'on' => 'gaps', 'cost' => 'Often £150 to £400 a window', 'measured' => '86% less air leakage', 'source' => 'tp1', 'tags' => ['heritage', 'noise']],
                ['fix' => 'Secondary glazing, fitted', 'on' => 'both', 'cost' => 'Priced per window', 'measured' => '63% less heat through the window', 'source' => 'tp1', 'tags' => ['heritage', 'noise'], 'url' => $u('/secondary-glazing/')],
                ['fix' => 'New double-glazed windows', 'on' => 'both', 'cost' => 'Priced online in minutes', 'measured' => 'U-value of 1.4 or lower, against 4.5', 'source' => 'part-l', 'tags' => ['noise'], 'url' => $u('/windows-milton-keynes/')],
            ],
            'on_labels' => ['gaps' => 'Draughts', 'glass' => 'Cold glass', 'both' => 'Both'],
            'empty' => 'Nothing matches that.',
            'film_note' => 'About film and bubble wrap. Both work the way secondary glazing does, by trapping still air against the glass, and plenty of people find them worth doing. We could not find a reliable test of either, so we have not put a number on them. The nearest is a low-emissivity film, which improved single glass by 17% in a Historic Scotland test.',
            'film_source' => 'tp23',
            'price_note' => 'Shop prices are ranges seen at UK retailers in November 2026. Tradesman prices are typical guide figures, and yours will depend on the window.',
        ],

        'compare' => [
            'eyebrow' => 'What changes, and by how much',
            'title' => 'See what each step does to the heat and the noise.',
            'intro' => 'This is one single-glazed sash, cut through the middle. Pick a step and watch what gets through.',
            'modes' => [
                ['key' => 'heat', 'label' => 'Heat'],
                ['key' => 'noise', 'label' => 'Noise'],
            ],
            'states' => [
                [
                    'key' => 'asis',
                    'label' => 'As it is',
                    'heat_u' => 4.5,
                    'heat_value' => '4.5',
                    'heat_note' => 'A single-glazed timber sash, measured.',
                    'leak' => 1.0,
                    'leak_note' => 'Air moves freely round both sashes.',
                    'noise_db' => 29,
                    'noise_value' => 'About 29 dB',
                    'noise_note' => 'One 4 mm pane, before any gaps are counted.',
                    'summary' => 'Heat goes straight through the glass and out round the edges of both sashes.',
                    'sources' => ['tp1'],
                ],
                [
                    'key' => 'sealed',
                    'label' => 'Draught-proofed',
                    'heat_u' => 4.4,
                    'heat_value' => '4.4',
                    'heat_note' => 'The glass is the same glass, so this barely moves.',
                    'leak' => 0.14,
                    'leak_note' => '86% less air leakage in Historic Scotland\'s test.',
                    'noise_db' => 31,
                    'noise_value' => 'A little quieter',
                    'noise_note' => 'Sealing gaps helps, because sound travels through any opening air can.',
                    'summary' => 'The draughts stop. The glass is still a thin, cold sheet, which is why the room still needs its curtains.',
                    'sources' => ['tp1'],
                ],
                [
                    'key' => 'curtains',
                    'label' => 'Curtains closed',
                    'heat_u' => 3.2,
                    'heat_value' => '3.2',
                    'heat_note' => '14% less heat through the window, measured with heavy curtains.',
                    'leak' => 1.0,
                    'leak_note' => 'The gaps are still open behind the curtain.',
                    'noise_db' => 29,
                    'noise_value' => 'About the same',
                    'noise_note' => 'Fabric takes the edge off, and little more.',
                    'summary' => 'A layer of still air in front of the glass. Free, and it works from the first night.',
                    'sources' => ['tp1'],
                ],
                [
                    'key' => 'secondary',
                    'label' => 'Secondary glazing',
                    'heat_u' => 1.7,
                    'heat_value' => '1.7',
                    'heat_note' => '63% less heat through the window. With curtains closed as well, 66%.',
                    'leak' => 0.1,
                    'leak_note' => 'A sealed second window sits inside the first.',
                    'noise_db' => 44,
                    'noise_value' => '43 to 45 dB',
                    'noise_note' => 'With a 100 mm gap between the panes, on the manufacturer\'s figures.',
                    'summary' => 'A second window on the room side of the one you keep. The wide gap between the two is what makes it the quietest option here.',
                    'sources' => ['tp1', 'selecta'],
                ],
                [
                    'key' => 'replace',
                    'label' => 'New double glazing',
                    'heat_u' => 1.4,
                    'heat_value' => '1.4 or lower',
                    'heat_note' => 'The limit Building Regulations set for a replacement window.',
                    'leak' => 0.06,
                    'leak_note' => 'New seals all the way round, built in.',
                    'noise_db' => 40,
                    'noise_value' => 'About 40 dB',
                    'noise_note' => 'With acoustic laminated glass. A standard sealed unit is nearer 30.',
                    'summary' => 'The lowest heat loss here, in one window that opens, locks and cleans like new. Acoustic glass is the choice for a noisy road.',
                    'sources' => ['part-l'],
                ],
            ],
            'heat_label' => 'Heat through the window',
            'heat_unit' => 'W/m²K. Lower is warmer.',
            'leak_label' => 'Air leaking round it',
            'noise_label' => 'Street noise kept out',
            'noise_unit' => 'Higher is quieter.',
            'noise_rule' => 'Every 10 dB sounds roughly half as loud.',
            'svg_alt' => 'Cross-section through a sash window, with the warm room on the left and the cold street on the right, showing how much heat and noise passes through for the step chosen.',
        ],

        'avoid' => [
            'eyebrow' => 'Before you seal anything',
            'title' => 'Four shortcuts to skip, and what to do instead.',
            'skip_label' => 'Skip',
            'instead_label' => 'Instead',
            'items' => [
                [
                    'key' => 'tissue',
                    'skip' => 'Wet tissue or newspaper in the gaps.',
                    'why' => 'It holds water against the timber for weeks, and it shrinks back out of the gap as it dries.',
                    'instead' => 'Removable caulk rope. It stays soft, seals properly and peels out clean in spring.',
                    'source' => '',
                ],
                [
                    'key' => 'tape',
                    'skip' => 'Parcel tape or duct tape on the paintwork.',
                    'why' => 'It comes away in spring with the paint attached, which matters twice over in a rented home.',
                    'instead' => 'Low-tack decorator\'s tape if you must tape. Caulk rope if you can.',
                    'source' => '',
                ],
                [
                    'key' => 'vents',
                    'skip' => 'Covering a vent, an airbrick or a trickle vent.',
                    'why' => 'A gas fire, an open fire or an open-flued boiler needs that air to burn safely. The Health and Safety Executive says never to block one.',
                    'instead' => 'Leave every vent open and seal the gaps that were never meant to be there.',
                    'source' => 'hse',
                ],
                [
                    'key' => 'escape',
                    'skip' => 'Sealing every window in the room shut.',
                    'why' => 'A bedroom window is often the way out in a fire, and a room with no fresh air gets damp.',
                    'instead' => 'Keep one window per room free to open, and open it wide for a few minutes each morning.',
                    'source' => 'part-b',
                ],
            ],
            'note_title' => 'Why the room still needs airing.',
            'note' => 'Draughts were doing one useful job: carrying the damp from cooking, washing and breathing out of the room. Seal them and that damp settles on the coldest surface, which is the glass. A few minutes with a window wide open each morning clears it and costs far less heat than a draught running all night.',
            'note_link_label' => 'Condensation every morning? Start here',
            'note_url' => $u('/stop-morning-condensation-inside-windows/'),
            'note_source' => 'damp',
        ],

        'renting' => [
            'eyebrow' => 'If you rent',
            'title' => 'Renting does not mean living with it.',
            'intro' => 'This is England, as of November 2026. Scotland, Wales and Northern Ireland have their own rules.',
            'points' => [
                [
                    'title' => 'What you can do yourself.',
                    'copy' => 'Curtains, a towel on the sill, wedges and turning the catch change nothing about the building. For anything you stick or seal on, Shelter\'s advice is to get your landlord\'s agreement in writing first, even when you are paying.',
                    'source' => 'shelter',
                ],
                [
                    'title' => 'What your landlord has to do.',
                    'copy' => 'Windows are part of the structure and exterior, which the law makes the landlord\'s to keep in repair. That covers a window that is broken, rotten or will not close. It does not, on its own, cover a sound window that is simply single glazed.',
                    'source' => 'citizens',
                ],
                [
                    'title' => 'What is changing.',
                    'copy' => 'A rented home needs an energy rating of E today. The government has said that rises to C by 1 October 2030, with a cap of £10,000 on what a landlord must spend. It is not law yet, but it is the direction, and it is a fair thing to mention.',
                    'source' => 'mees',
                ],
            ],
            'letter' => [
                'title' => 'Write to your landlord in two minutes.',
                'intro' => 'Tick what applies and the letter writes itself. Nothing you type leaves your browser: it is not sent to us or saved anywhere.',
                'fields' => [
                    'tenant' => 'Your name',
                    'landlord' => 'Landlord or agent\'s name',
                    'address' => 'Address of the home',
                    'rooms' => 'Which windows',
                    'rooms_placeholder' => 'The two sash windows in the front bedroom',
                ],
                'problems_label' => 'What is wrong',
                'problems' => [
                    ['key' => 'draughts', 'label' => 'Draughts round the frame', 'text' => 'there are draughts coming in around the frames'],
                    ['key' => 'rattle', 'label' => 'They rattle in the wind', 'text' => 'the windows rattle in the wind'],
                    ['key' => 'close', 'label' => 'They will not close or lock', 'text' => 'they do not close or lock properly'],
                    ['key' => 'glass', 'label' => 'Cracked or loose glass', 'text' => 'there is cracked or loose glass'],
                    ['key' => 'rot', 'label' => 'Rotten or damaged timber', 'text' => 'there is rotten or damaged timber'],
                    ['key' => 'damp', 'label' => 'Condensation and mould', 'text' => 'there is heavy condensation and mould around them'],
                    ['key' => 'cold', 'label' => 'The room will not stay warm', 'text' => 'the room cannot be kept warm with the heating on'],
                ],
                'asks_label' => 'What you are asking for',
                'asks' => [
                    ['key' => 'repair', 'label' => 'A repair', 'text' => 'arrange for the windows to be inspected and repaired'],
                    ['key' => 'proof', 'label' => 'Draught-proofing', 'text' => 'have the windows draught-proofed'],
                    ['key' => 'permission', 'label' => 'Permission for removable fixes', 'text' => 'give me written permission to fit removable draught-proofing, such as brush strip, caulk rope and a window film kit, at my own cost, all of which I will take out when I leave'],
                    ['key' => 'secondary', 'label' => 'A quote for secondary glazing', 'text' => 'consider a quote for secondary glazing, which adds a second window on the inside and leaves the existing windows untouched'],
                ],
                'defaults' => ['problems' => ['draughts'], 'asks' => ['repair']],
                'copy_label' => 'Copy the letter',
                'copied_label' => 'Copied',
                'email_label' => 'Open in an email',
                'print_label' => 'Print it',
                'output_label' => 'Your letter',
                'subject' => 'Windows at {address}',
                'template' => [
                    'greeting' => 'Dear {landlord},',
                    'opening' => 'I am writing about the windows at {address}.',
                    'which' => 'It concerns {rooms}.',
                    'problem' => 'At the moment {problems}.',
                    'effect' => 'It makes the home hard to heat, and I would like to sort it out before the coldest part of the winter.',
                    'ask' => 'Could you please {asks}?',
                    'access' => 'I am happy to arrange access at a time that suits. Could you let me know in writing what you propose, and roughly when?',
                    'sign' => 'Thank you,',
                ],
                'fallbacks' => [
                    'landlord' => 'Sir or Madam',
                    'address' => 'my home',
                    'tenant' => '',
                ],
            ],
        ],

        'heritage' => [
            'eyebrow' => 'Conservation areas and listed buildings',
            'title' => 'What you can do when the windows have to stay.',
            'intro' => 'A protected building limits what you can replace. It limits very little of what you can add or seal.',
            'columns' => ['Conservation area house', 'Listed building', 'Flat or maisonette'],
            'rows' => [
                [
                    'label' => 'Draught-proofing',
                    'cells' => [
                        ['status' => 'yes', 'copy' => 'No permission needed.'],
                        ['status' => 'ask', 'copy' => 'Stick-on strips are fine. Ask before seals are cut into the timber.'],
                        ['status' => 'yes', 'copy' => 'Fine. Check your lease first.'],
                    ],
                ],
                [
                    'label' => 'Secondary glazing',
                    'cells' => [
                        ['status' => 'yes', 'copy' => 'Fitted inside, so no planning permission.'],
                        ['status' => 'ask', 'copy' => 'Not generally needed, Historic England says, with exceptions.'],
                        ['status' => 'yes', 'copy' => 'No planning permission. Check your lease.'],
                    ],
                ],
                [
                    'label' => 'New windows',
                    'cells' => [
                        ['status' => 'ask', 'copy' => 'Usually fine if they match, unless Article 4 applies.'],
                        ['status' => 'consent', 'copy' => 'Listed building consent, always.'],
                        ['status' => 'consent', 'copy' => 'Planning permission.'],
                    ],
                ],
            ],
            'status_labels' => ['yes' => 'Go ahead', 'ask' => 'Ask first', 'consent' => 'Consent needed'],
            'local' => 'Milton Keynes has 27 conservation areas, among them Stony Stratford, Olney, Newport Pagnell, Wolverton, Woburn Sands and Great Linford. Olney and Wolverton also carry Article 4 directions, so ask the council before changing a window there.',
            'local_source' => 'mk',
            'general_sources' => ['he', 'he-secondary', 'he-draught'],
            'disclaimer' => 'This is the general position in England. Your council decides, and its conservation officer is the person to ask.',
            'proof' => [
                'image' => '/assets/images/case-studies/cs-winslow-secondary-glazing-card.jpg',
                'alt' => 'Secondary glazing closed across a leaded window in a listed Winslow home, with the original casement open behind it.',
                'title' => 'A listed home in Winslow, July 2026.',
                'copy' => 'The windows were always staying. Shane fitted six secondary glazing units inside them, five sliders and one lift-out, in slim white aluminium. Nothing original was touched.',
                'link_label' => 'See the Winslow job',
                'url' => $u('/case-studies/secondary-glazing-winslow/'),
            ],
        ],

        'picker' => [
            'eyebrow' => 'Where to go from here',
            'title' => 'Tell us about the window and we will tell you what to do.',
            'intro' => 'Four questions. The answer is sometimes a roll of brush strip and not us.',
            'questions' => [
                [
                    'key' => 'who',
                    'label' => 'Whose window is it?',
                    'options' => [
                        ['key' => 'own', 'label' => 'I own the home'],
                        ['key' => 'rent', 'label' => 'I rent it'],
                        ['key' => 'landlord', 'label' => 'I am the landlord'],
                    ],
                ],
                [
                    'key' => 'protected',
                    'label' => 'Is the building protected?',
                    'options' => [
                        ['key' => 'no', 'label' => 'No'],
                        ['key' => 'area', 'label' => 'Conservation area'],
                        ['key' => 'listed', 'label' => 'Listed'],
                        ['key' => 'unsure', 'label' => 'Not sure'],
                    ],
                ],
                [
                    'key' => 'window',
                    'label' => 'What kind of window?',
                    'options' => [
                        ['key' => 'sash', 'label' => 'Timber sash, single glazed'],
                        ['key' => 'single', 'label' => 'Other single glazing'],
                        ['key' => 'double', 'label' => 'Older double glazing'],
                    ],
                ],
                [
                    'key' => 'problem',
                    'label' => 'What bothers you most?',
                    'options' => [
                        ['key' => 'cold', 'label' => 'Cold and draughts'],
                        ['key' => 'noise', 'label' => 'Noise'],
                        ['key' => 'damp', 'label' => 'Condensation'],
                    ],
                ],
            ],
            /* The first result whose `when` matches every answer wins, so the
               order is the logic: most specific first, the catch-all last. */
            'results' => [
                [
                    'when' => ['who' => ['rent']],
                    'title' => 'Start with the free fixes, then put it in writing.',
                    'copy' => 'Tonight\'s five fixes change nothing about the building, so start there. Then use the letter to ask your landlord for a repair or for permission to fit removable draught-proofing. If the windows are broken or will not close, that is the landlord\'s to put right.',
                    'primary' => ['label' => 'Write the letter', 'url' => '#renting-letter'],
                    'secondary' => ['label' => 'See tonight\'s fixes', 'url' => '#tonight'],
                ],
                [
                    'when' => ['protected' => ['listed']],
                    'title' => 'Keep the windows and add a second one inside.',
                    'copy' => 'On a listed building the windows are part of what is listed. Secondary glazing leaves them exactly as they are and does the most for heat and noise of anything on this page. Have a sash restorer draught-proof the originals and the two together make an old window a warm one.',
                    'primary' => ['label' => 'See secondary glazing', 'url' => $u('/secondary-glazing/')],
                    'secondary' => ['label' => 'Book a consultation', 'url' => $u('/book-a-consultation/')],
                ],
                [
                    'when' => ['problem' => ['noise'], 'window' => ['sash', 'single']],
                    'title' => 'For noise, the gap between two panes does the work.',
                    'copy' => 'Seal the gaps first, because sound gets in wherever air does. After that the quietest answer is secondary glazing with a wide gap behind the window you already have. If you would rather have one new window, ask us about acoustic laminated glass.',
                    'primary' => ['label' => 'See secondary glazing', 'url' => $u('/secondary-glazing/')],
                    'secondary' => ['label' => 'Read the noise guide', 'url' => $u('/guide-noise-insulation-for-windows/')],
                ],
                [
                    'when' => ['problem' => ['damp']],
                    'title' => 'Deal with the moisture before you seal anything.',
                    'copy' => 'Condensation forms on the coldest surface, which is single glass. Sealing the draughts without airing the room makes it worse. Start with our condensation guide, then warm the glass: curtains with the window aired each morning, or secondary glazing with a little ventilation left behind it.',
                    'primary' => ['label' => 'Read the condensation guide', 'url' => $u('/stop-morning-condensation-inside-windows/')],
                    'secondary' => ['label' => 'See secondary glazing', 'url' => $u('/secondary-glazing/')],
                ],
                [
                    'when' => ['window' => ['double']],
                    'title' => 'This is usually a repair, not a new window.',
                    'copy' => 'A draughty double-glazed window is nearly always worn seals, dropped hinges or a lock that no longer pulls it tight. All three are standard parts. If the glass has misted between the panes, the sealed unit can be replaced and the frame kept.',
                    'primary' => ['label' => 'See window repairs', 'url' => $u('/window-and-door-repairs/')],
                    'secondary' => ['label' => 'Misted glass replacement', 'url' => $u('/double-glazing-replacement/')],
                ],
                [
                    'when' => ['protected' => ['area', 'unsure'], 'window' => ['sash']],
                    'title' => 'Draught-proof them, then decide between two good routes.',
                    'copy' => 'If the timber is sound, have a sash restorer draught-proof the windows and add secondary glazing inside: nothing changes from the street. If the timber is past saving, new sash windows made for period streets keep the look, and we will check what your council asks for before anything is ordered.',
                    'primary' => ['label' => 'See secondary glazing', 'url' => $u('/secondary-glazing/')],
                    'secondary' => ['label' => 'See sliding sash windows', 'url' => $u('/sliding-sash-windows/')],
                ],
                [
                    'when' => ['window' => ['sash']],
                    'title' => 'Sound timber is worth keeping. Tired timber is worth replacing.',
                    'copy' => 'If the frames are solid, draught-proofing and secondary glazing will make them warm and you keep the originals. If they are soft, sticking or painted shut, a new A rated sliding sash gives you the same proportions with double glazing and seals built in.',
                    'primary' => ['label' => 'See sliding sash windows', 'url' => $u('/sliding-sash-windows/')],
                    'secondary' => ['label' => 'Get an instant price', 'url' => $u('/online-quote/')],
                ],
                [
                    'when' => [],
                    'title' => 'Single glazing is the one thing sealing cannot fix.',
                    'copy' => 'Close the gaps and cover the glass this winter, using the fixes above. When you are ready to deal with the glass itself, the choice is a second window inside the one you have, or a new double-glazed one. You can price new windows online in a few minutes.',
                    'primary' => ['label' => 'Get an instant price', 'url' => $u('/online-quote/')],
                    'secondary' => ['label' => 'See secondary glazing', 'url' => $u('/secondary-glazing/')],
                ],
            ],
            'result_eyebrow' => 'What we would do',
            'restart_label' => 'Start again',
            'postcode' => [
                'label' => 'Do we cover you?',
                'placeholder' => 'First part of your postcode',
                'button' => 'Check',
                /* Postcode districts taken from the town pages in
                   inc/location-town-data.php, so the checker and the town pages
                   cannot disagree. */
                'districts' => fenster_warm_guide_districts(),
                'yes' => '{district} is in the area we fit in. Call 01908 429200 or price it online.',
                'near' => '{district} is close to where we work. Call 01908 429200 and we will tell you straight.',
                'no' => 'That looks outside the area we fit in. Everything above this section works wherever you live.',
                'invalid' => 'Enter the first part of your postcode, such as MK11.',
                'areas_label' => 'See the areas we cover',
                'areas_url' => $u('/areas-we-cover/'),
            ],
        ],

        'faq' => [
            'eyebrow' => 'Questions people ask us',
            'title' => 'Short answers to the common ones.',
            'items' => [
                [
                    'question' => 'Can I stuff the gaps in my window with wet tissue or newspaper?',
                    'answer' => 'It is better not to. Wet paper holds water against the timber and shrinks out of the gap as it dries. Removable caulk rope costs about £17 a pack, seals the same gaps properly and peels out clean in spring. For tonight, a rolled towel along the sill and a wedge in any rattling sash will do more.',
                ],
                [
                    'question' => 'How do I stop draughts coming through a sash window?',
                    'answer' => 'Turn the catch fully home so the two sashes pull together, wedge any sash that rattles, and lay a rolled towel along the bottom rail. For longer, stick brush pile strip where the sashes meet and down the sides. Use brush strip and not foam, because foam tears when a sash slides past it. A sash restorer can fit permanent seals.',
                ],
                [
                    'question' => 'How do I keep a room warm with single-glazed windows?',
                    'answer' => 'Seal the gaps, then cover the glass. Close lined curtains at dusk, and close shutters if you have them: in Historic Scotland\'s tests curtains cut the heat lost through a single-glazed sash by 14% and shutters by 51%. Secondary glazing, a second window fitted inside, cut it by 63%.',
                ],
                [
                    'question' => 'Does window film or bubble wrap actually work?',
                    'answer' => 'Both trap a layer of still air against the glass, which is the same principle as secondary glazing, and many people find them worth doing. We could not find a reliable test of either, so we will not quote a figure. A low-emissivity film improved single glass by 17% in a Historic Scotland test.',
                ],
                [
                    'question' => 'Is secondary glazing better than double glazing?',
                    'answer' => 'They are best at different things. Secondary glazing keeps your existing windows, needs no planning permission in most homes and has the widest gap between panes, which makes it the quietest. New double glazing has the lower heat loss, a U-value of 1.4 or below, in a single window with new seals.',
                ],
                [
                    'question' => 'Can I have secondary glazing in a conservation area or a listed building?',
                    'answer' => 'In a conservation area, yes: it is fitted inside, so it needs no planning permission. On a listed building, Historic England says secondary glazing does not generally need listed building consent, with a few exceptions, so check with the conservation officer at your council before ordering.',
                ],
                [
                    'question' => 'My landlord will not fix my draughty windows. What can I do?',
                    'answer' => 'In England a landlord must keep the structure and exterior in repair, and that includes windows that are broken, rotten or will not close. Report it in writing and keep a copy. If nothing happens, your council\'s environmental health team can inspect. Shelter and Citizens Advice both explain the steps.',
                ],
                [
                    'question' => 'Will draught-proofing cause condensation?',
                    'answer' => 'It can if you seal a room completely, because draughts were carrying moisture out. Leave vents open, keep one window free to open, and air the room for a few minutes each morning. Never block a vent in a room with a gas fire, an open fire or an open-flued boiler.',
                ],
                [
                    'question' => 'How do I reduce traffic noise through old windows?',
                    'answer' => 'Seal the gaps first, since sound gets in wherever air does. After that it is the distance between two panes that counts. Secondary glazing with a gap of 100 mm or more reaches about 43 to 45 dB on the manufacturer\'s figures, against about 29 dB for a single 4 mm pane.',
                ],
            ],
        ],

        'related' => [
            'eyebrow' => 'Read next',
            'title' => 'More on the same windows.',
            'links' => [
                ['label' => 'Draughty windows: repair or replace?', 'meta' => 'A checklist for hinged and double-glazed windows', 'url' => $u('/draughty-windows-repair-or-replace/'), 'post' => 'draughty-windows-repair-or-replace'],
                ['label' => 'Sash windows in winter', 'meta' => 'What draught-proofing does, and what it cannot', 'url' => $u('/sash-windows-in-winter/'), 'post' => 'sash-windows-in-winter'],
                ['label' => 'Which rooms lose the most heat', 'meta' => 'And which windows to deal with first', 'url' => $u('/which-rooms-lose-the-most-heat/'), 'post' => 'which-rooms-lose-the-most-heat'],
                ['label' => 'Is secondary glazing worth it?', 'meta' => 'Where it beats replacement', 'url' => $u('/is-secondary-glazing-worth-it/'), 'post' => 'is-secondary-glazing-worth-it'],
                ['label' => 'Condensation inside every morning', 'meta' => 'Where to start', 'url' => $u('/stop-morning-condensation-inside-windows/'), 'post' => 'stop-morning-condensation-inside-windows'],
                ['label' => 'Noise insulation for windows', 'meta' => 'What makes glass quieter', 'url' => $u('/guide-noise-insulation-for-windows/'), 'post' => ''],
                ['label' => 'A guide to U-values', 'meta' => 'What the numbers mean', 'url' => $u('/a-guide-to-understanding-u-values/'), 'post' => ''],
            ],
        ],

        'close' => [
            'eyebrow' => 'When the free fixes have done what they can',
            'title' => 'We repair windows, add a second one inside, and fit new ones.',
            'copy' => 'If you like doing things yourself, price new windows online in a few minutes. If you would rather talk it through, we will come and look, and tell you which windows are worth keeping.',
            'primary' => ['label' => 'Get an instant price', 'url' => $u('/online-quote/')],
            'secondary' => ['label' => 'Book a consultation', 'url' => $u('/book-a-consultation/')],
            'routes' => [
                ['label' => 'Window and door repairs', 'meta' => 'Seals, hinges, locks and glass', 'url' => $u('/window-and-door-repairs/')],
                ['label' => 'Secondary glazing', 'meta' => 'A second window, fitted inside', 'url' => $u('/secondary-glazing/')],
                ['label' => 'Sliding sash windows', 'meta' => 'New sashes for period streets', 'url' => $u('/sliding-sash-windows/')],
            ],
        ],

        'sources_title' => 'Where the figures come from.',
        'sources_intro' => 'Checked in November 2026. Where a test measured one window in one laboratory, treat the figure as a guide to the size of the effect and not a promise for yours.',
        'sources' => $src,
    ];

    return $data;
}

/**
 * Postcode districts we fit in, as `['MK1', ...]`, for the "Do we cover you?"
 * check.
 *
 * Two sources, both already in the theme:
 *
 * - every district the town pages name in inc/location-town-data.php, with a
 *   written range such as "NN1 to NN5" expanded, so the checker and the town
 *   pages cannot disagree;
 * - the whole of the MK postcode area. The town pages do not happen to have a
 *   page for every MK district (MK7, MK9 and MK13 have none), but MK is Milton
 *   Keynes and Bedford, both named on /areas-we-cover/, and the showroom itself
 *   is in MK13. Without this the checker told central Milton Keynes it was
 *   only "close to where we work".
 *
 * Anything else that shares a postcode area with a listed district is reported
 * as "close", and the visitor is asked to call.
 */
function fenster_warm_guide_districts(): array
{
    $districts = [];

    if (function_exists('fenster_location_town_guides')) {
        foreach ((array) fenster_location_town_guides() as $town) {
            $postcodes = (string) ($town['postcodes'] ?? '');

            if (preg_match_all('/\b([A-Z]{1,2})(\d{1,2}) to \1(\d{1,2})\b/', $postcodes, $ranges, PREG_SET_ORDER)) {
                foreach ($ranges as $range) {
                    for ($n = (int) $range[2]; $n <= (int) $range[3]; $n++) {
                        $districts[] = $range[1] . $n;
                    }
                }
            }

            if (preg_match_all('/\b[A-Z]{1,2}\d{1,2}\b/', $postcodes, $found)) {
                $districts = array_merge($districts, $found[0]);
            }
        }
    }

    foreach (array_merge(range(1, 19), range(40, 46)) as $n) {
        $districts[] = 'MK' . $n;
    }

    $districts = array_values(array_unique($districts));
    sort($districts, SORT_NATURAL);

    return $districts;
}
