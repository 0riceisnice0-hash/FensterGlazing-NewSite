<?php
/**
 * Everything the winter guide says, in one place.
 *
 * REWRITTEN 17/11/2026 AS A PLAIN ARTICLE. The first version was a set of
 * interactive panels (a thermal wipe, a leak finder, a filterable table, a
 * picker). The owner's verdict was that it was too much information in a
 * confusing way, and that someone renting still came away not knowing what to
 * do. This version is text first: question headings, the short answer at the
 * top, a section a renter can follow in order, and three small diagrams that
 * each explain one idea. Keep it that way. If something new is worth adding,
 * add it as a paragraph under the question it answers.
 *
 * Inline markup in the strings below, rendered by fenster_warm_inline():
 *   **bold**          strong text
 *   [text](/path/)    a link; a path starting with / goes through home_url()
 *   [[key]]           a citation of `sources[key]`, printed as "(Short name)"
 *
 * EVERY FIGURE HERE HAS A NAMED SOURCE, AND NOTHING ELSE IS A FIGURE. Checked
 * 16/11/2026:
 *
 * - Heat figures are Historic Scotland Technical Paper 1 (Baker, 2008): a
 *   single-glazed timber sash at 4.5 W/m2K as a whole window, and the measured
 *   reductions for curtains (14%, the low end; other tests found more), blinds
 *   (36%), shutters (51%) and secondary glazing (63%, 66% with curtains). The
 *   page quotes the reductions, not the paper's centre-of-glass U-values.
 * - Draught-proofing cut AIR LEAKAGE by 86% in that test. It did not change
 *   the U-value, and the page never says it did.
 * - There is no credible test of shrink film or bubble wrap. The page says so.
 * - The only noise figure is secondary glazing's, from a manufacturer's data
 *   sheet, attributed as one.
 * - Rental law is England only and dated. EPC C by 2030 is a stated plan, not
 *   law. No grant is claimed, because none currently lists glazing.
 * - Shelter's advice is to get a landlord's agreement in writing before making
 *   improvements. The page does not tell a tenant they can fit things without
 *   asking.
 * - No Fenster price, lead time or performance figure appears here. Shop prices
 *   are ranges seen at UK retailers in November 2026.
 * - Timber sash draught-proofing is a sash restorer's trade. The page sends
 *   people to one, and brings us in for secondary glazing, repairs to modern
 *   windows and replacement, which is the work we do.
 *
 * Copy follows TONEOFVOICE.md: we/you, no em dashes, no exclamation marks, and
 * a window is never a "light". Headings are the questions people type into a
 * search box or ask an assistant, because that is how this page gets found.
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

    $sources = [
        'tp1' => ['label' => 'Historic Scotland Technical Paper 1: Thermal performance of traditional windows (Dr Paul Baker, Glasgow Caledonian University, October 2008)', 'short' => 'Historic Scotland', 'url' => 'https://www.historicenvironment.scot/archives-and-research/publications/publication/?publicationId=f3e97c76-b4fa-4c76-a197-a59400be931b'],
        'tp23' => ['label' => 'Historic Scotland Technical Paper 23: Thermal assessment of internal shutters and window film applied to traditional single glazed sash and case windows (2014)', 'short' => 'Historic Scotland', 'url' => 'https://www.historicenvironment.scot/archives-and-research/publications/publication/?publicationid=4a1a95dd-9e9f-4b9d-8381-a59400ac0be8'],
        'part-l' => ['label' => 'Approved Document L, Volume 1: Dwellings, which sets 1.4 W/m²K or Window Energy Rating band B for a replacement window (HM Government)', 'short' => 'Approved Document L', 'url' => 'https://www.gov.uk/government/publications/conservation-of-fuel-and-power-approved-document-l'],
        'est-draught' => ['label' => 'Energy Saving Trust: Draught-proofing (updated May 2026)', 'short' => 'Energy Saving Trust', 'url' => 'https://energysavingtrust.org.uk/advice/draught-proofing/'],
        'hse' => ['label' => 'Health and Safety Executive: Gas appliances, get them checked, keep them safe (INDG238)', 'short' => 'HSE', 'url' => 'https://books.hse.gov.uk/gempdf/indg238.pdf'],
        'part-b' => ['label' => 'Approved Document B, Volume 1: Dwellings, paragraph 2.10, emergency escape windows (HM Government)', 'short' => 'Approved Document B', 'url' => 'https://www.gov.uk/government/publications/fire-safety-approved-document-b'],
        'damp' => ['label' => 'GOV.UK: Understanding and addressing the health risks of damp and mould in the home (updated April 2026)', 'short' => 'GOV.UK', 'url' => 'https://www.gov.uk/government/publications/damp-and-mould-understanding-and-addressing-the-health-risks-for-rented-housing-providers/understanding-and-addressing-the-health-risks-of-damp-and-mould-in-the-home--2'],
        'citizens' => ['label' => 'Citizens Advice: Check if your landlord has to do repairs', 'short' => 'Citizens Advice', 'url' => 'https://www.citizensadvice.org.uk/housing/repairs-and-housing/repairs-and-housing-conditions/whos-responsible-for-repairs/check-if-your-landlord-has-to-do-repairs/'],
        'shelter' => ['label' => 'Shelter England: Making improvements to your rented home', 'short' => 'Shelter', 'url' => 'https://england.shelter.org.uk/housing_advice/repairs/making_improvements_to_your_rented_home'],
        'mees' => ['label' => 'GOV.UK: Improving the energy performance of privately rented homes, government response (January 2026)', 'short' => 'GOV.UK', 'url' => 'https://www.gov.uk/government/consultations/improving-the-energy-performance-of-privately-rented-homes-2025-update'],
        'mk' => ['label' => 'Milton Keynes City Council: Conservation areas in Milton Keynes', 'short' => 'Milton Keynes City Council', 'url' => 'https://www.milton-keynes.gov.uk/planning-and-building/conservation-and-archaeology/conservation-areas-milton-keynes'],
        'he' => ['label' => 'Historic England: What permission might I need to make changes to my older home?', 'short' => 'Historic England', 'url' => 'https://historicengland.org.uk/advice/your-home/improvement/permission/'],
        'he-secondary' => ['label' => 'Historic England: Modifying historic windows as part of retrofitting energy saving measures (updated July 2024)', 'short' => 'Historic England', 'url' => 'https://historicengland.org.uk/advice/technical-advice/retrofit-and-energy-efficiency-in-historic-buildings/modifying-windows-and-doors-in-historic-buildings/modifying-historic-windows-as-part-of-retrofitting-energy-saving-measures/'],
        'he-draught' => ['label' => 'Historic England: Draught-proofing', 'short' => 'Historic England', 'url' => 'https://historicengland.org.uk/advice/your-home/energy-efficiency/making-changes-to-save-energy/draught-proofing/'],
        'selecta' => ['label' => 'Selectaglaze data sheet DS-056: sound reduction values for secondary glazing by cavity, measured behind 6 mm glass (manufacturer data)', 'short' => 'Selectaglaze data sheet', 'url' => 'https://selectaglaze.co.uk/media/images/ds-056-afrwdbvaluesforselectaglazesystems1_8351.pdf'],
    ];

    $letter = "Dear [landlord or agent's name],\n\n"
        . "I am writing about the windows at [address], in particular [which windows, for example the two sash windows in the front bedroom].\n\n"
        . "[Say what is wrong, for example: There are draughts coming in around the frames and the windows rattle in the wind. One of them does not lock properly.]\n\n"
        . "Please could you arrange for the windows to be inspected and repaired before the coldest part of the winter.\n\n"
        . "I would also like your written permission to fit removable draught-proofing at my own cost, such as caulk rope and a window film kit. I will take it out when I leave.\n\n"
        . "Would you also consider secondary glazing? It adds a second window on the inside and leaves the existing windows as they are.\n\n"
        . "I am happy to arrange access at a time that suits you. Could you let me know in writing what you propose, and roughly when?\n\n"
        . "Thank you,\n"
        . "[Your name]";

    $data = [
        'updated' => '2026-11-17',
        'title' => 'How to fix cold, draughty windows',
        'eyebrow' => 'Winter guide',
        'lead' => 'Heat leaves a window two ways: through the gaps round the parts that open, and straight through the glass. You can close most of the gaps tonight for nothing, and cover the glass for under £20. This guide covers single glazing, sash windows, rented homes and conservation areas.',
        'description' => 'Free fixes for draughty sash and single-glazed windows, what to do if you rent, what is allowed in conservation areas, and what each fix costs.',

        /* The answer an assistant or a search snippet can lift whole, and the
           answer a reader in a cold room needs before anything else. */
        'answer' => [
            'title' => 'The short answer.',
            'items' => [
                '**Tonight, for free:** close the curtains at dusk, turn the window catch all the way round, wedge any sash that rattles, and lay a rolled towel along the bottom of the window.',
                '**This weekend, for under £20:** press removable caulk rope into the gaps, or stick brush strip where the sashes meet. Cover the glass with a film kit.',
                '**For good:** add [secondary glazing](/secondary-glazing/) inside the window you have, or replace it with [double glazing](/windows-milton-keynes/). Secondary glazing is usually allowed in conservation areas.',
                '**If you rent:** do the free fixes now, then ask your landlord in writing for a repair and for permission to fit removable fixes. [There is a letter you can copy](#renting-letter).',
                '**Never** block an air vent, or seal every window in a room shut.',
            ],
        ],

        'jump' => [
            'label' => 'Jump to your situation',
            'links' => [
                ['label' => 'I rent', 'url' => '#i-rent'],
                ['label' => 'Single glazing', 'url' => '#single-glazing'],
                ['label' => 'Sash windows', 'url' => '#find-the-draught'],
                ['label' => 'Conservation area or listed', 'url' => '#conservation-areas'],
                ['label' => 'Noise', 'url' => '#noise'],
            ],
        ],

        'sections' => [
            [
                'id' => 'why',
                'heading' => 'Why do my windows feel so cold?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'There are two separate problems, and they need different fixes.'],
                    ['type' => 'ul', 'items' => [
                        '**Draughts.** Outside air leaks in round the edges of the parts that open and round the frame. You can feel it move on the back of your hand. Sealing the gaps fixes it.',
                        '**Cold glass.** A single pane is a few millimetres thick. The air touching it cools, sinks and rolls across the floor, which feels just like a draught. Sealing cannot fix this one. Covering the glass can.',
                    ]],
                    ['type' => 'anim', 'key' => 'two-ways', 'caption' => 'A sash window cut through the middle. Draughts come in through the gaps, and the glass chills the air beside it, which sinks to the floor.', 'legend' => [
                        ['swatch' => 'draught', 'label' => 'Outside air through the gaps'],
                        ['swatch' => 'cold', 'label' => 'Air cooled by the glass, sinking'],
                    ]],
                    ['type' => 'p', 'text' => 'A single-glazed timber sash lost heat at 4.5 W/m²K as a whole window in a laboratory test [[tp1]]. Building Regulations ask a replacement window for 1.4 or lower [[part-l]], so the old window loses about three times as much heat through the same space. That figure is the window\'s [U-value](/a-guide-to-understanding-u-values/), and lower is better.'],
                    ['type' => 'p', 'text' => 'That is why the fixes below come in two kinds: the ones that close gaps and the ones that cover glass. Most cold rooms need a bit of both.'],
                ],
            ],
            [
                'id' => 'tonight',
                'heading' => 'What can I do tonight to stop a draughty window?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'None of these needs a tool, a shop or anyone\'s permission, and none of them changes the building, so they are fine in a rented home.'],
                    ['type' => 'h3', 'text' => 'Close the curtains at dusk.'],
                    ['type' => 'p', 'text' => 'A lined curtain holds a layer of still air in front of the glass. Close it as it gets dark, before the room has given up its heat. Heavy curtains cut the heat lost through a single-glazed sash by 14% in one test, and other tests have measured more [[tp1]]. If there is a radiator under the window, let the curtain stop at the sill so the heat goes into the room and not up behind the fabric.'],
                    ['type' => 'h3', 'text' => 'Turn the catch all the way round.'],
                    ['type' => 'p', 'text' => 'The catch where the two sashes meet pulls them together as it turns. Turned fully, it closes the widest gap on the window. On a [hinged casement window](/casement-windows/), push the handle all the way down so the lock draws the window onto its seals. If the catch turns but the sashes still part, it has worn, and a new one is a screwdriver job.'],
                    ['type' => 'h3', 'text' => 'Wedge any sash that rattles.'],
                    ['type' => 'p', 'text' => 'A rattle means air is moving round the sash. Push folded card or a cork between the sash and the strip of wood beside it until it stops moving. It quietens the window and slows the draught at the same time.'],
                    ['type' => 'h3', 'text' => 'Lay a rolled towel along the bottom rail.'],
                    ['type' => 'p', 'text' => 'Cold air comes in under the bottom of the window and spills onto the sill. A rolled towel or a fabric draught excluder along that joint stops it. Lift it in the morning so the sill can dry.'],
                    ['type' => 'h3', 'text' => 'Leave one window free to open.'],
                    ['type' => 'p', 'text' => 'Every room still needs airing, and a bedroom needs a way out in a fire. Seal the others, and keep one you can open in each room.'],
                ],
            ],
            [
                'id' => 'find-the-draught',
                'heading' => 'Where do sash windows leak, and how do I find the draught?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'On a breezy day, run the back of your hand slowly round the window. It feels moving air better than your palm does. Smoke from a stick of incense, held well clear of the curtains, bends at the same places.'],
                    ['type' => 'anim', 'key' => 'leak-points', 'caption' => 'The five places a sash window usually lets air in.', 'legend' => []],
                    ['type' => 'ul', 'items' => [
                        '**Where the two sashes meet.** Turn the catch fully. For longer, stick brush strip along the meeting rail so the two close onto it.',
                        '**Down both sides.** A sash has to be loose enough to slide. Use brush strip here, not foam, because foam tears the first time the sash slides past it. For a window you will not open until spring, caulk rope is quicker.',
                        '**Under the bottom rail.** A rolled towel tonight. For longer, a foam or rubber strip on the sill, which works here because the sash closes onto it rather than sliding along it.',
                        '**The pulleys at the top.** Each one is a hole into the hollow box where the weights hang. Leave these to a sash restorer: the cords have to run free, so nothing should be pushed in.',
                        '**Round the outside of the frame.** Timber and brick move differently, so a crack opens between them. A bead of flexible decorator\'s caulk fills it and takes paint.',
                    ]],
                    ['type' => 'p', 'text' => 'Loose putty or a cracked pane lets air in too. Clear tape over a crack will do for now, then have it reglazed. For what draught-proofing can and cannot do on an old sash, read [sash windows in winter](/sash-windows-in-winter/).'],
                    ['type' => 'p', 'text' => 'Not a sash window? On a hinged window the draught is usually worn seals, [dropped hinges](/repair-case-studies/window-hinge-replacement-kempston/) or a lock that no longer pulls tight, and all three are [repairs we can do](/window-and-door-repairs/). [Draughty windows: repair or replace](/draughty-windows-repair-or-replace/) walks through them.'],
                ],
            ],
            [
                'id' => 'weekend',
                'heading' => 'What can I fix this weekend for under £20?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'Everything here is sold at DIY shops and online. Prices are ranges we saw at UK retailers in November 2026.'],
                    ['type' => 'ul', 'items' => [
                        '**Removable caulk rope, about £17 a pack.** A soft putty cord you press into a gap with your thumb and peel out in spring, with nothing left behind. It suits the gaps a towel cannot reach.',
                        '**Brush pile strip, £12 to £19 a pack.** Self-adhesive brush for where the sashes meet and down the sides of a sash.',
                        '**Foam or rubber strip, £5 to £15.** For places a window closes onto: the bottom of a sash, and round the frame of a hinged window.',
                        '**A window film kit, £9 to £19.** Clear film fixed round the frame with tape and tightened with a hairdryer. It traps still air in front of the glass.',
                        '**Decorator\'s caulk, a few pounds a tube.** For the crack between the frame and the wall.',
                    ]],
                    ['type' => 'p', 'text' => 'The Energy Saving Trust\'s draught-proofing advice covers the same ground for the rest of the house: doors, letterboxes, floorboards and chimneys [[est-draught]].'],
                ],
            ],
            [
                'id' => 'single-glazing',
                'heading' => 'How do I keep a room warm with single glazing?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'Once the gaps are sealed, the glass is what is left. Every fix for it works the same way: it holds a layer of still air against the pane. In Historic Scotland\'s tests on a single-glazed sash [[tp1]]:'],
                    ['type' => 'ul', 'items' => [
                        '**Heavy curtains** cut the heat lost through the window by 14%.',
                        '**An insulating honeycomb blind** cut it by 36%.',
                        '**Shutters, closed** cut it by 51%.',
                        '**[Secondary glazing](/secondary-glazing/)** cut it by 63%, and by 66% with the curtains closed as well.',
                    ]],
                    ['type' => 'anim', 'key' => 'secondary', 'caption' => 'The same window, as it is and with secondary glazing inside it. The still air between the two panes is what slows the heat down.', 'legend' => []],
                    ['type' => 'p', 'text' => 'Film kits and bubble wrap work on the same idea, and plenty of people find them worth doing. We could not find a reliable test of either, so we have not put a number on them. The nearest is a low-emissivity film, which improved single glass by 17% in a later test [[tp23]].'],
                    ['type' => 'p', 'text' => '**Secondary glazing** is a second window fitted on the room side of the one you have. It leaves the old window untouched, which is why it suits rented, listed and conservation-area homes. [See secondary glazing](/secondary-glazing/).'],
                ],
            ],
            [
                'id' => 'what-not-to-do',
                'heading' => 'What should I not do?',
                'blocks' => [
                    ['type' => 'ul', 'items' => [
                        '**Do not stuff the gaps with wet tissue or newspaper.** It holds water against the timber and shrinks out of the gap as it dries. Caulk rope does the job properly and peels out clean.',
                        '**Do not put parcel or duct tape on the paintwork.** It takes the paint with it in spring, which matters twice over in a rented home. Use low-tack decorator\'s tape if you must tape.',
                        '**Never cover a vent, an airbrick or a [trickle vent](/trickle-vents-explained/).** A gas fire, an open fire or an open-flued boiler needs that air to burn safely [[hse]].',
                        '**Do not seal every window shut.** A bedroom window is often the way out in a fire [[part-b]], and a room with no fresh air gets damp.',
                    ]],
                    ['type' => 'note', 'text' => '**Why the room still needs airing.** Draughts were doing one useful job: carrying the damp from cooking, washing and breathing out of the room. Seal them and that damp settles on the coldest surface, which is the glass. Open a window wide for a few minutes each morning. It clears the damp and costs far less heat than a draught running all night [[damp]]. If you already wake to wet windows, read [how to stop morning condensation](/stop-morning-condensation-inside-windows/) and [how to prevent window condensation in winter](/how-to-prevent-window-condensation-in-winter/).'],
                ],
            ],
            [
                'id' => 'i-rent',
                'heading' => 'I rent. What can I do about cold, draughty windows?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'This is for England, as of November 2026. Scotland, Wales and Northern Ireland have their own rules. Here is what to do, in the order to do it.'],
                    ['type' => 'h3', 'text' => 'Tonight: do the free fixes.'],
                    ['type' => 'p', 'text' => 'Curtains, the catch, a wedge and a rolled towel change nothing about the building, so you can do them now without asking. Hold off on anything you would stick, screw or seal on until you have permission.'],
                    ['type' => 'h3', 'text' => 'This week: tell your landlord in writing.'],
                    ['type' => 'p', 'text' => 'Windows are part of the structure and exterior of the home, which the law makes the landlord\'s to keep in repair [[citizens]]. That covers a window that is broken, rotten or will not close or lock. Email is fine. Keep a copy.'],
                    ['type' => 'p', 'text' => 'In the same message, ask for permission to fit removable draught-proofing yourself. Shelter\'s advice is to get your landlord\'s agreement in writing before making any improvement, even one you are paying for [[shelter]]. Here is a letter you can copy and fill in.'],
                    ['type' => 'letter', 'id' => 'renting-letter', 'title' => 'A letter to your landlord', 'text' => $letter, 'copy_label' => 'Copy the letter', 'copied_label' => 'Copied', 'hint' => 'Replace the words in square brackets, and delete any request you do not want to make.'],
                    ['type' => 'h3', 'text' => 'Once you have a yes: fit the removable fixes.'],
                    ['type' => 'p', 'text' => 'Caulk rope and a window film kit come away cleanly when you take them down. Self-adhesive brush strip can lift paint when it comes off, so mention it by name if you want to use it. Keep the receipts, and take everything out when you move.'],
                    ['type' => 'h3', 'text' => 'If nothing happens.'],
                    ['type' => 'p', 'text' => 'If the windows are broken, rotten or will not close and your landlord does not act, contact your council\'s private housing or environmental health team, who can inspect the home. Shelter and Citizens Advice both explain the steps and can help you with them.'],
                    ['type' => 'h3', 'text' => 'Worth knowing.'],
                    ['type' => 'p', 'text' => 'A window that works but is simply single glazed is not, on its own, a repair your landlord has to make. That is why the letter asks about [secondary glazing](/secondary-glazing/) politely rather than demanding it. It may help that rented homes need an energy rating of E today, and the government has said that rises to C by 1 October 2030, with a cap of £10,000 on what a landlord must spend [[mees]]. That is a plan and not yet law, but it is worth mentioning.'],
                ],
            ],
            [
                'id' => 'conservation-areas',
                'heading' => 'Can I do anything in a conservation area or a listed building?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'Yes. A protected building limits what you can replace. It limits very little of what you can add inside or seal. This is the general position in England, from Historic England\'s guidance on [permission](https://historicengland.org.uk/advice/your-home/improvement/permission/), [secondary glazing](https://historicengland.org.uk/advice/technical-advice/retrofit-and-energy-efficiency-in-historic-buildings/modifying-windows-and-doors-in-historic-buildings/modifying-historic-windows-as-part-of-retrofitting-energy-saving-measures/) and [draught-proofing](https://historicengland.org.uk/advice/your-home/energy-efficiency/making-changes-to-save-energy/draught-proofing/):'],
                    ['type' => 'table', 'caption' => 'What needs permission in a conservation area and in a listed building', 'columns' => ['', 'Conservation area', 'Listed building'], 'rows' => [
                        ['Draught-proofing', 'No permission needed.', 'Stick-on strips are fine. Ask before seals are cut into the timber.'],
                        ['Secondary glazing', 'No planning permission, because it is fitted inside.', 'Usually no consent needed, Historic England says. Check for exceptions.'],
                        ['New windows', 'Usually fine if they match the old ones, unless an Article 4 direction applies.', 'Listed building consent, always.'],
                    ]],
                    ['type' => 'p', 'text' => 'In a flat, check your lease before you change anything, and expect new windows to need planning permission. Your council decides in every case, and its conservation officer is the person to ask. Our guide to [checking your planned home improvements are legal](/how-to-check-whether-your-planned-home-improvements-are-legal/) covers the wider rules.'],
                    ['type' => 'photo', 'src' => '/assets/images/case-studies/cs-winslow-secondary-glazing-card.jpg', 'alt' => 'Secondary glazing closed across a leaded window in a listed Winslow home, with the original casement open behind it.', 'caption' => 'A listed home in Winslow, July 2026. We fitted six secondary glazing units inside the original windows, in slim white aluminium, and nothing original was touched. [See the Winslow job](/case-studies/secondary-glazing-winslow/).'],
                    ['type' => 'p', 'text' => 'Sound sash windows are worth keeping. Draught-proofing by a sash restorer cut air leakage through a sash by 86% in Historic Scotland\'s tests [[tp1]], and secondary glazing inside it deals with the glass. If the timber is past saving, [new sliding sash windows](/sliding-sash-windows/) keep the look, [heritage aluminium windows](/heritage-windows/) do the same for old steel frames, and we check what your council asks for before anything is ordered.'],
                    ['type' => 'p', 'text' => 'Milton Keynes has 27 conservation areas, among them [Stony Stratford](/double-glazing-stony-stratford/), Olney, [Newport Pagnell](/double-glazing-newport-pagnell/), [Wolverton](/double-glazing-wolverton/), [Woburn Sands](/double-glazing-woburn-sands/) and [Great Linford](/double-glazing-great-linford/). Olney and Wolverton also have Article 4 directions, so ask the council before changing a window there [[mk]]. We have written more about [replacing windows in the Wolverton conservation area](/replacing-windows-doors-in-wolverton-mk/).'],
                ],
            ],
            [
                'id' => 'noise',
                'heading' => 'How do I cut traffic noise through old windows?',
                'blocks' => [
                    ['type' => 'p', 'text' => 'Seal the gaps first, because sound gets in wherever air does. The wedges, caulk rope and brush strip above all help.'],
                    ['type' => 'p', 'text' => 'After that, the distance between two panes does the work. [Secondary glazing](/secondary-glazing/) with a 100 mm gap behind 6 mm glass reduces sound by 43 to 45 dB on one manufacturer\'s figures [[selecta]], and a wider gap is quieter still. If you would rather have one new window, ask for [acoustic laminated glass](/which-is-better-triple-or-acoustic-glazing/), which is made for the job. Our [guide to noise insulation for windows](/guide-noise-insulation-for-windows/) goes further, and [how to soundproof your windows](/soundproof-windows/) covers the DIY options.'],
                ],
            ],
            [
                'id' => 'repair-or-replace',
                'heading' => 'Should I repair, add secondary glazing or replace?',
                'blocks' => [
                    ['type' => 'ul', 'items' => [
                        '**Double glazed but draughty:** usually a repair. Seals, hinges and locks are standard parts, and [misted glass](/misted-double-glazing-cloudy-windows/) can be swapped for [new double glazed units](/double-glazing-replacement/) without a new frame. [Window and door repairs](/window-and-door-repairs/).',
                        '**The windows have to stay, or you want to keep them:** secondary glazing. [See secondary glazing](/secondary-glazing/).',
                        '**Timber sashes that are soft, sticking or painted shut:** new sash windows with double glazing. [See sliding sash windows](/sliding-sash-windows/) and [sash window prices](/sash-window-prices/).',
                        '**Single glazing you are happy to replace:** new [double glazing](/windows-milton-keynes/). You can [price it online](/online-quote/) in a few minutes, or read [what double glazing costs](/double-glazing-cost/).',
                    ]],
                    ['type' => 'p', 'text' => 'Not sure which you have? Read [how to know when to replace windows](/how-to-know-when-to-replace-windows/), or [book a consultation](/book-a-consultation/) and we will come and look, and tell you which windows are worth keeping.'],
                ],
            ],
            [
                'id' => 'costs',
                'heading' => 'What each fix costs, at a glance.',
                'blocks' => [
                    ['type' => 'table', 'caption' => 'Fixes for cold, draughty windows, with cost and measured effect', 'columns' => ['Fix', 'Fixes', 'Cost', 'Measured effect'], 'rows' => [
                        ['Lined curtains, closed at dusk', 'Cold glass', 'Free if you have them', '14% less heat lost, at least [[tp1]]'],
                        ['Turning the catch fully', 'Draughts', 'Free', 'Not measured'],
                        ['Card, cork or sash wedges', 'Draughts', 'Free', 'Not measured'],
                        ['Rolled towel on the bottom rail', 'Draughts', 'Free', 'Not measured'],
                        ['Shutters, closed at night', 'Cold glass', 'Free if they are there', '51% less heat lost [[tp1]]'],
                        ['Removable caulk rope', 'Draughts', 'About £17 a pack', 'Not measured'],
                        ['Insulating honeycomb blind', 'Cold glass', 'Varies by window', '36% less heat lost [[tp1]]'],
                        ['Brush pile strip', 'Draughts', '£12 to £19 a pack', 'Not measured as a DIY job'],
                        ['Window film kit', 'Cold glass', '£9 to £19 a kit', 'No reliable test'],
                        ['Sash draught-proofing by a restorer', 'Draughts', 'Often £150 to £400 a window', '86% less air leakage [[tp1]]'],
                        ['Secondary glazing, fitted', 'Both', '[Priced per window](/secondary-glazing/)', '63% less heat lost [[tp1]]'],
                        ['New double-glazed windows', 'Both', '[Priced online](/online-quote/)', '[U-value](/a-guide-to-understanding-u-values/) of 1.4 or lower, against 4.5 [[part-l]]'],
                    ]],
                    ['type' => 'p', 'text' => 'A laboratory figure is for one window in one test, so treat it as a guide to the size of the effect rather than a promise for yours.'],
                ],
            ],
        ],

        'faq' => [
            'eyebrow' => 'Questions people ask us',
            'title' => 'Cold and draughty windows: quick answers.',
            'items' => [
                ['question' => 'Can I stuff the gaps in my window with wet tissue or newspaper?', 'answer' => 'It is better not to. Wet paper holds water against the timber and shrinks out of the gap as it dries. Removable caulk rope costs about £17 a pack, seals the same gaps properly and peels out clean in spring. For tonight, a rolled towel along the bottom rail and a wedge in any rattling sash will do more.'],
                ['question' => 'How do I stop draughts coming through a sash window?', 'answer' => 'Turn the catch fully so the two sashes pull together, wedge any sash that rattles, and lay a rolled towel along the bottom rail. For longer, stick brush pile strip where the sashes meet and down the sides. Use brush strip and not foam, because foam tears when a sash slides past it. A sash restorer can fit permanent seals.'],
                ['question' => 'How do I keep a room warm with single-glazed windows?', 'answer' => 'Seal the gaps, then cover the glass. Close lined curtains at dusk, and close shutters if you have them: in Historic Scotland\'s tests curtains cut the heat lost through a single-glazed sash by 14% and shutters by 51%. Secondary glazing, a second window fitted inside, cut it by 63%.'],
                ['question' => 'I rent and my windows are draughty. What can I do?', 'answer' => 'Start with the free fixes that change nothing about the building: curtains closed at dusk, the catch turned fully, wedges and a rolled towel. Then write to your landlord. In England a landlord must keep windows in repair, which covers windows that are broken, rotten or will not close. Ask in the same letter for written permission to fit removable draught-proofing such as caulk rope or a film kit.'],
                ['question' => 'My landlord will not fix my draughty windows. What can I do?', 'answer' => 'Report the problem in writing and keep a copy. If the windows are broken, rotten or will not close and nothing happens, your council\'s private housing or environmental health team can inspect the home. Shelter and Citizens Advice both explain the steps.'],
                ['question' => 'Does window film or bubble wrap actually work?', 'answer' => 'Both trap a layer of still air against the glass, which is the same principle as secondary glazing, and many people find them worth doing. We could not find a reliable test of either, so we will not quote a figure. A low-emissivity film improved single glass by 17% in a Historic Scotland test.'],
                ['question' => 'Is secondary glazing better than double glazing?', 'answer' => 'They are best at different things. Secondary glazing keeps your existing windows, needs no planning permission in most homes and has the widest gap between panes, which makes it the quietest. New double glazing has the lower heat loss, a U-value of 1.4 or below, in a single window with new seals.'],
                ['question' => 'Can I have secondary glazing in a conservation area or a listed building?', 'answer' => 'In a conservation area, yes: it is fitted inside, so it needs no planning permission. On a listed building, Historic England says secondary glazing does not generally need listed building consent, with a few exceptions, so check with the conservation officer at your council before ordering.'],
                ['question' => 'Will draught-proofing cause condensation?', 'answer' => 'It can if you seal a room completely, because draughts were carrying moisture out. Leave vents open, keep one window free to open, and air the room for a few minutes each morning. Never block a vent in a room with a gas fire, an open fire or an open-flued boiler.'],
                ['question' => 'How do I reduce traffic noise through old windows?', 'answer' => 'Seal the gaps first, since sound gets in wherever air does. After that it is the distance between two panes that counts. Secondary glazing with a 100 mm gap reaches 43 to 45 dB on one manufacturer\'s figures, and a wider gap is quieter still.'],
            ],
        ],

        'next' => [
            'eyebrow' => 'When the free fixes have done what they can',
            'title' => 'We repair windows, add a second one inside, and fit new ones.',
            'copy' => 'Price new windows online in a few minutes, or book a visit and we will tell you which windows are worth keeping.',
            'routes' => [
                ['label' => 'Window and door repairs', 'meta' => 'Seals, hinges, locks and misted glass', 'url' => '/window-and-door-repairs/'],
                ['label' => 'Secondary glazing', 'meta' => 'A second window, fitted inside the one you have', 'url' => '/secondary-glazing/'],
                ['label' => 'Sliding sash windows', 'meta' => 'New sashes for period homes', 'url' => '/sliding-sash-windows/'],
            ],
        ],

        /* Further reading after the winter blog posts, which the template
           lists itself from fenster_warm_guide_related_posts() once each is
           live, so the guide never links to an address that is not there. */
        'related' => [
            ['label' => 'Noise insulation for windows', 'url' => '/guide-noise-insulation-for-windows/'],
            ['label' => 'A guide to understanding U-values', 'url' => '/a-guide-to-understanding-u-values/'],
            ['label' => 'Replacement double glazed units', 'url' => '/double-glazing-replacement/'],
            ['label' => 'Misted double glazing: causes and fixes', 'url' => '/misted-double-glazing-cloudy-windows/'],
            ['label' => 'Trickle vents explained', 'url' => '/trickle-vents-explained/'],
            ['label' => 'Dealing with condensation', 'url' => '/deal-with-condensation/'],
            ['label' => 'Condensation on new windows', 'url' => '/condensation-on-new-windows/'],
            ['label' => 'Are my windows energy efficient?', 'url' => '/are-my-windows-energy-efficient/'],
            ['label' => 'Window maintenance', 'url' => '/window-maintenance/'],
        ],

        'sources_title' => 'Where the figures come from.',
        'sources_intro' => 'Checked in November 2026.',
        'sources' => $sources,
        'enquiry_source' => 'Winter guide: cold, draughty windows',
    ];

    return $data;
}

/**
 * Escapes a string from the data above and renders its three bits of inline
 * markup: **bold**, [text](url) and [[source]].
 */
function fenster_warm_inline(string $text): string
{
    $sources = (array) (fenster_warm_guide_data()['sources'] ?? []);
    $html = esc_html($text);

    $html = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $html);

    $html = preg_replace_callback('/\[\[([a-z0-9-]+)\]\]/', static function (array $match) use ($sources): string {
        $source = $sources[$match[1]] ?? null;
        if (! is_array($source)) {
            return '';
        }

        return '<span class="fgw-cite">(<a href="' . esc_url($source['url']) . '" target="_blank" rel="noopener">' . esc_html($source['short']) . '</a>)</span>';
    }, $html);

    $html = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)\)/u', static function (array $match): string {
        $url = html_entity_decode($match[2], ENT_QUOTES);
        if (str_starts_with($url, '/')) {
            $url = home_url($url);
        }

        return '<a href="' . esc_url($url) . '">' . $match[1] . '</a>';
    }, $html);

    return (string) $html;
}
