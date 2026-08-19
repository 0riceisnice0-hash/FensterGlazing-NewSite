<?php
/**
 * Care and maintenance guide content.
 *
 * These are Fenster's own guides, written for the customer standing in front of
 * the product. They deliberately do not link out to manufacturer PDFs: half the
 * systems we fit publish nothing, the ones that do publish it for fabricators,
 * and a customer with a sticking bifold wants the steps, not a download.
 *
 * Each guide carries three things in a fixed order: the routine that keeps it
 * working, the fixes worth trying yourself, and the point at which to stop and
 * call us. The last one is not a sales line. Hinge geometry, sash balances and
 * lock gearboxes are adjusted in a set order with the right tools, and a guess
 * at them costs more than the visit.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Grouped by what actually shares a maintenance routine, which is material and
 * mechanism, not the marketing category. A flush sash and a tilt and turn are
 * different windows to buy and the same window to look after.
 */
function fenster_care_guides(): array
{
    static $guides = null;

    if (is_array($guides)) {
        return $guides;
    }

    $guides = [
        'upvc-windows' => [
            'name' => 'uPVC windows',
            'group' => 'Windows',
            'covers' => 'Casement, flush sash, tilt and turn, French casement, bow and bay',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg',
            'image_alt' => 'Close view of a white uPVC casement window and its handle',
            'intro' => 'A uPVC window asks for very little: a wash twice a year, clear drainage slots and a drop of oil on the moving parts. Almost every window we get called out to has one of those three things behind it.',
            'routine' => [
                [
                    'title' => 'Wash the frames twice a year',
                    'body' => 'Warm water, a little washing up liquid and a soft cloth. Rinse and dry. Spring and autumn is the usual rhythm, more often if you are on a main road or under trees. For marks that will not shift, a proper uPVC cream cleaner works, but put it on the cloth rather than straight on the frame. Nothing abrasive, no bleach, no solvent, no pressure washer.',
                ],
                [
                    'title' => 'Keep the drainage slots clear',
                    'body' => 'Along the bottom of the outer frame there are small slots, sometimes hidden behind a hinged cover. Rain is meant to get into the frame and these are how it gets back out. Brush them clear with a soft brush or a blast of air. Do not push wire or a screwdriver into them, because the channel behind turns and you can dislodge the seal at the bottom of the glass.',
                ],
                [
                    'title' => 'Oil the moving parts once a year',
                    'body' => 'Open the window fully. You are looking for the hinge arms along the top and bottom of the sash, the mushroom cams along the opening edge and the keeps they sit into. A drop of light machine oil or a spray of silicone on each, then work the handle ten or twelve times to spread it. This one job prevents most stiff handles.',
                ],
                [
                    'title' => 'A note on WD-40',
                    'body' => 'It is a water dispersant, not a lubricant. It will free something that has seized, and that is a fair use for it, but it thins out within weeks and the film it leaves behind holds dust. If you use it to free a stiff hinge, follow it with a proper oil once it is moving.',
                ],
                [
                    'title' => 'Wipe the seals, but do not dress them',
                    'body' => 'The rubber gasket around the glass and against the frame only needs a damp cloth. Leave silicone sprays and rubber dressings off it. Oil based products can make the gasket swell and then it holds the sash off its seat.',
                ],
                [
                    'title' => 'Work the trickle vents',
                    'body' => 'If your windows have vents in the head, open and close them a couple of times a year and brush the outer grille. They block with dust and cobwebs and then the room stops getting its background ventilation.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The handle has gone stiff',
                    'steps' => [
                        'Open the window and look at the hinge arms. If they are dry or gritty, that is your answer.',
                        'Put a drop of oil on every pivot point in the hinge, on each mushroom cam along the edge of the sash, and in each keep on the frame.',
                        'Work the handle a dozen times with the window open, then close and try again.',
                    ],
                    'note' => 'If it is still stiff after oiling, the sash has usually dropped slightly and the cams are no longer meeting the keeps square. That is a hinge adjustment.',
                ],
                [
                    'problem' => 'The window catches on one corner as it closes',
                    'steps' => [
                        'Check the frame rebate and the seal for grit, leaves or a stray bit of packaging.',
                        'Look at the gap around the sash when it is nearly shut. If it is even all the way round, it is debris. If it is tight at one corner and wide at the opposite one, the sash has dropped.',
                    ],
                    'note' => 'A dropped sash needs the hinges resetting. It is a small job for us and an easy one to make worse by eye.',
                ],
                [
                    'problem' => 'There is condensation on the inside of the glass',
                    'steps' => [
                        'This is moisture in the room, not a fault in the window. Drying washing indoors, showers and cooking all put it there.',
                        'Use the trickle vents, run extractor fans for longer than feels necessary, and leave a gap behind furniture on external walls.',
                    ],
                    'note' => 'New windows seal a house far better than old ones did, so moisture that used to leak out now has to be ventilated out instead. It is the commonest call we get after an installation and it is almost never the glass.',
                ],
                [
                    'problem' => 'There is condensation on the outside of the glass',
                    'steps' => [
                        'Nothing to do. It clears as the morning warms up.',
                    ],
                    'note' => 'It means the outer pane is staying cold because so little heat is escaping through the unit. It is a sign the glazing is working properly.',
                ],
                [
                    'problem' => 'There is misting between the panes',
                    'steps' => [
                        'Nothing you can do from the outside, and nothing you should try.',
                    ],
                    'note' => 'This one is a genuine fault. The seal around the sealed unit has gone and moisture is inside the cavity, where no amount of cleaning reaches. Tell us and we will look at it. If it is within guarantee we replace the unit.',
                ],
            ],
            'call_us' => 'Misting between the panes, a sash that has dropped, a handle that will not turn after oiling, or a lock that feels like it is grinding. Those all need the hardware resetting rather than more force.',
        ],

        'sliding-sash-windows' => [
            'name' => 'Sliding sash windows',
            'group' => 'Windows',
            'covers' => 'Ultimate Rose, Heritage Rose and Charisma Rose',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-sliding-sash-window.jpg',
            'image_alt' => 'White sliding sash window in a period property',
            'intro' => 'A modern sliding sash carries its weight on spiral balances hidden in the frame, and both sashes tilt in so you can clean the outside from indoors. Learning the tilt properly is most of the maintenance.',
            'routine' => [
                [
                    'title' => 'Tilt the sashes in to clean them',
                    'body' => 'Slide the bottom sash up a few inches. Push the two catches on the top edge of the sash inwards at the same time, then tilt the top of the sash towards you until it rests. Clean the outer face, then push it back until both catches click home. The top sash tilts the same way once the bottom one is out of its path.',
                ],
                [
                    'title' => 'Keep both hands on a tilted sash',
                    'body' => 'A tilted sash is off its balances and its whole weight is on your hands and the tilt pivots. Do not let go of it, do not rest it against the sill, and do not walk away from a window mid-tilt. It is the one part of this job worth being deliberate about.',
                ],
                [
                    'title' => 'Wipe the run of the frame',
                    'body' => 'With the sash tilted you can reach the channels the sash slides in. A damp cloth along both sides twice a year is enough. Do not put grease or oil in the channel; the sash runs on a low friction strip and oil just collects dust against it.',
                ],
                [
                    'title' => 'Wash the frames and check the sill',
                    'body' => 'Warm soapy water on a soft cloth, same as any uPVC frame. While you are there, run a finger along the outer sill and clear anything sitting in the drainage path.',
                ],
                [
                    'title' => 'Oil the locks, not the balances',
                    'body' => 'The fitch or sash locks on the meeting rail take a spot of light oil once a year. The spiral balances in the frame are sealed and set to the weight of your sash. They are not a user serviceable part and they should be left alone.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The sash will not stay where I put it',
                    'steps' => [
                        'Check first that both tilt catches are fully home. A sash that is not properly latched back sits wrong and drags.',
                        'If the catches are home and it still creeps down or springs up, stop there.',
                    ],
                    'note' => 'The spiral balance has lost its tension or its setting. It is adjusted with a specific tool against the weight of that particular sash, and it is genuinely not a guess-and-see job. Call us.',
                ],
                [
                    'problem' => 'The sash is stiff to slide',
                    'steps' => [
                        'Tilt it in and wipe both channels and the edges of the sash.',
                        'Look for a build up of dirt at the very bottom of the run, which is where it collects.',
                        'Slide it a few times after cleaning before deciding it is still stiff.',
                    ],
                    'note' => 'Resist the urge to lubricate the channel. Nine times in ten it is dirt, and oil turns dirt into paste.',
                ],
                [
                    'problem' => 'The tilt catches will not release',
                    'steps' => [
                        'Both catches have to be pushed at the same time, and the sash needs to be raised clear of its stop first.',
                        'Push inwards rather than downwards, and keep an even pressure on both.',
                    ],
                    'note' => 'Do not force a single catch on its own. If one is stiff, oil it lightly and try again rather than levering it.',
                ],
                [
                    'problem' => 'The meeting rails do not line up',
                    'steps' => [
                        'Check the bottom sash is fully down and the top sash is fully up before judging it.',
                    ],
                    'note' => 'If they still sit out of line, one sash is running unevenly on its balances. That needs setting rather than adjusting by hand.',
                ],
            ],
            'call_us' => 'Any balance problem, a sash that will not hold its position, a tilt pivot that feels loose, or misting inside the glass. Sash gear is set to the weight of the specific sash and is the wrong thing to experiment on.',
        ],

        'aluminium-windows' => [
            'name' => 'Aluminium windows',
            'group' => 'Windows',
            'covers' => 'Casement, flush and heritage aluminium windows',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png',
            'image_alt' => 'Close view of a slim aluminium window frame and corner detail',
            'intro' => 'The frame is aluminium under a powder coated finish, and that finish is what you are looking after. Treat it like car paint rather than like plastic and it will outlast everything around it.',
            'routine' => [
                [
                    'title' => 'Wash twice a year, more if you are exposed',
                    'body' => 'Warm water and a mild detergent on a soft cloth or sponge, then rinse and dry. Twice a year covers most houses. If you are near the coast, beside a busy road or on an industrial estate, make it quarterly, because salt and traffic film sit on the coating and work at it.',
                ],
                [
                    'title' => 'Nothing solvent based, ever',
                    'body' => 'No white spirit, no cellulose thinners, no acetone, no oven cleaner, no abrasive pad. A powder coat is a baked finish and once a solvent has dulled or lifted an area there is no polishing it back. This is the single rule worth remembering on aluminium.',
                ],
                [
                    'title' => 'Rinse before you wipe',
                    'body' => 'On a frame with grit on it, wiping first drags the grit across the coating. Rinse it off with clean water, then wash. It is a small habit that keeps a dark finish looking right for years, and dark finishes show everything.',
                ],
                [
                    'title' => 'Clear the drainage slots',
                    'body' => 'Same as any window. Small slots along the bottom of the outer frame, brushed clear twice a year.',
                ],
                [
                    'title' => 'Oil the hardware once a year',
                    'body' => 'Hinges, the locking cams along the sash edge and the keeps they engage. Light machine oil or silicone. Wipe off the excess, because oil left on a frame collects dust and shows on a dark coating.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'There are white or dull patches on a dark frame',
                    'steps' => [
                        'Wash the area with mild detergent and plenty of water first. Traffic film and hard water deposits both look like damage until they come off.',
                        'Dry it and look again in daylight.',
                    ],
                    'note' => 'If the patch is in the finish rather than on it, tell us. Sheerline guarantee the powder coated finish for 25 years, and a genuine coating fault is a warranty matter rather than a cleaning one.',
                ],
                [
                    'problem' => 'The handle is stiff',
                    'steps' => [
                        'Open the window and oil the hinge pivots, the cams and the keeps.',
                        'Work the handle a dozen times, then try it closed.',
                    ],
                    'note' => 'Aluminium sashes are heavier than uPVC ones for the same size, so they show a dry hinge sooner. Annual oiling is worth more here than on any other window we fit.',
                ],
                [
                    'problem' => 'The window feels draughty in a wind',
                    'steps' => [
                        'Check the gasket all the way round for anything caught in it.',
                        'Close the window and look at the compression: the sash should pull evenly onto the seal along its whole length.',
                    ],
                    'note' => 'Uneven compression is a keep adjustment. It is quick to do and easy to overdo.',
                ],
            ],
            'call_us' => 'Anything in the powder coat itself, a sash that has dropped, misting inside the glass, or a lock that will not engage after oiling.',
        ],

        'bifold-doors' => [
            'name' => 'Bifold doors',
            'group' => 'Doors',
            'covers' => 'Aluminium bifolds and slide and fold doors',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-doors.jpg',
            'image_alt' => 'Aluminium bifold doors folded back onto a garden',
            'intro' => 'A bifold runs on rollers in a track, and the track is nearly the whole of the maintenance. Keep it clean and a bifold glides for twenty years. Let grit build up in it and you are grinding the rollers against the running surface every time you open the doors.',
            'routine' => [
                [
                    'title' => 'Clean the bottom track every month or two',
                    'body' => 'Vacuum it end to end with the crevice tool, including the section under the panels when they are parked. Then a damp cloth along the running surface, then dry it. Run a fingertip along afterwards: if you can feel grit, it is still binding the rollers.',
                ],
                [
                    'title' => 'Do the top track too, twice a year',
                    'body' => 'The top guide collects less but it does collect. A vacuum and a wipe is enough.',
                ],
                [
                    'title' => 'Do not grease or oil the track',
                    'body' => 'This is the mistake we see most often. Grease and oil hold every bit of grit that lands in the track and turn it into a grinding paste, and the doors get worse rather than better. A clean dry track is what you want. If it needs anything at all, a light dry PTFE or silicone spray on an already clean track, and sparingly.',
                ],
                [
                    'title' => 'Oil the hinges once a year',
                    'body' => 'The hinges between the panels do take a drop of light oil at each knuckle. Wipe off what does not go in.',
                ],
                [
                    'title' => 'Keep the threshold drainage clear',
                    'body' => 'There are drainage points in or just outside the threshold. Brush out leaves and silt, particularly in autumn. A blocked threshold is how water ends up standing in the track.',
                ],
                [
                    'title' => 'Wash the frames and wipe the gaskets',
                    'body' => 'Warm soapy water on the frames, damp cloth on the seals. On dark aluminium, rinse the grit off before you wipe.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The doors have started dragging or stuck',
                    'steps' => [
                        'Start with the track, because this is the cause about nine times in ten. Vacuum the full length, including under where the panels park, then wipe and dry it.',
                        'Look for the obvious single culprit as you go: a stone, a screw, a bottle top, a build up of silt at one end.',
                        'Check the panels are being folded in the order they were designed to fold in. A bifold stacks in a set sequence and forcing a panel out of turn jams the whole set.',
                        'Try the traffic door on its own first, before the full stack. If the single door works and the stack does not, the problem is in the folding sequence or a hinge, not the lock.',
                        'Open and close the set a few times after cleaning before you judge it.',
                    ],
                    'note' => 'If it still drags on a genuinely clean track, the doors have dropped and need the hinges resetting. Bifold hinges adjust in more than one plane and in a particular order, and getting it wrong puts the load on the wrong roller. That is the point to call us.',
                ],
                [
                    'problem' => 'The handle will not lift or the door will not lock',
                    'steps' => [
                        'Make sure the door is fully closed into the frame before you try the handle. On a bifold the panels have to be square in the opening first.',
                        'Lift the handle in one full movement to its stop, then turn the key. A multipoint lock only throws its points on a complete lift.',
                        'Check the keeps in the frame and the threshold for grit.',
                    ],
                    'note' => 'Do not force a handle that will not lift. The gearbox inside the door is the expensive part and forcing a misaligned lock is how it breaks. Something is out of line, and that is worth looking at rather than muscling through.',
                ],
                [
                    'problem' => 'The doors are stiffer than usual in cold weather',
                    'steps' => [
                        'Note whether it eases again as the temperature comes up.',
                    ],
                    'note' => 'Aluminium moves a little with temperature and a set that is slightly firmer in a hard frost and fine again in milder weather is behaving normally. A set that stays stiff once the cold has passed is a different matter and worth a look.',
                ],
                [
                    'problem' => 'Water is sitting in the track',
                    'steps' => [
                        'Clear the drainage points in and around the threshold with a soft brush.',
                        'Check the outside of the threshold is not blocked by decking, gravel, a raised patio or leaf litter built up against it.',
                    ],
                    'note' => 'If the drainage is clear and it still holds water, tell us and we will look at the threshold detail.',
                ],
                [
                    'problem' => 'There is a draught at the bottom of the stack',
                    'steps' => [
                        'Check the brush seals along the bottom of the panels for grit or damage.',
                        'Close the set and look along the meeting edges for an even gap.',
                    ],
                    'note' => 'Uneven gaps mean alignment rather than seals, and alignment is an adjustment job.',
                ],
            ],
            'call_us' => 'A set that still drags on a clean track, a handle that will not lift, a panel that has dropped, water standing after the drainage is clear, or any hinge that feels loose. Bifold hinges are adjustable on purpose and adjusting them by eye is how a working set becomes a worn one.',
        ],

        'sliding-doors' => [
            'name' => 'Sliding and patio doors',
            'group' => 'Doors',
            'covers' => 'Aluminium sliding doors and lift and slide patio doors',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-sliding-door.jpg',
            'image_alt' => 'Large aluminium sliding door onto a garden',
            'intro' => 'A sliding door carries a lot of glass on a small number of rollers. As with a bifold, the track is where the work is, and a clean track is worth more than anything you can spray into it.',
            'routine' => [
                [
                    'title' => 'Vacuum and wipe the track every month or two',
                    'body' => 'Crevice tool along the full run, then a damp cloth, then dry. Pay attention to the ends of the track where silt gathers and to the section that sits under the parked panel.',
                ],
                [
                    'title' => 'Keep the track dry, not greased',
                    'body' => 'The same rule as bifolds. Oil and grease collect grit and accelerate wear on the rollers. Clean and dry is the target, with a light dry silicone spray at most.',
                ],
                [
                    'title' => 'Let the door lift before you push it',
                    'body' => 'On a lift and slide, turning the handle down lifts the whole panel onto its rollers and off its seals. If the door feels heavy to move, it has not lifted. Complete the handle movement first and it will run with one hand.',
                ],
                [
                    'title' => 'Clear the drainage in the threshold',
                    'body' => 'Brush out the drainage points twice a year and more often in autumn. Check outside too, because raised decking or gravel piled against the threshold blocks it just as effectively as leaves.',
                ],
                [
                    'title' => 'Wipe the interlock and the gaskets',
                    'body' => 'The upright where the two panels meet closes onto a seal. A damp cloth along it twice a year keeps the seal doing its job.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The door is heavy to slide',
                    'steps' => [
                        'On a lift and slide, check you are turning the handle fully. Most heavy doors are doors that have not been lifted.',
                        'Vacuum and wipe the full track, including under the parked panel.',
                        'Look along the running surface for a dent, a stone or a screw.',
                    ],
                    'note' => 'If it is still heavy on a clean track with the panel properly lifted, the rollers are worn or out of adjustment. That is ours.',
                ],
                [
                    'problem' => 'The door will not lock',
                    'steps' => [
                        'Slide it fully home into the jamb before trying the handle. A sliding door that is an inch short will not engage.',
                        'On a lift and slide, lower the handle fully so the panel drops onto its seals and the hooks line up with the keeps.',
                        'Check the keeps for grit.',
                    ],
                    'note' => 'Do not force the handle. Hook locks engage cleanly when the door is where it should be, and forcing them when it is not is what damages the mechanism.',
                ],
                [
                    'problem' => 'There is a draught along the meeting upright',
                    'steps' => [
                        'Check the brush or gasket seal on the interlock for grit and damage.',
                        'On a lift and slide, confirm the door is fully lowered when closed, because it seals only in the down position.',
                    ],
                    'note' => 'A door left slightly lifted will never seal properly and it is an easy habit to fall into.',
                ],
            ],
            'call_us' => 'Worn or noisy rollers, a panel that has dropped, a lock that will not engage on a properly closed door, or water standing after the drainage is clear.',
        ],

        'composite-doors' => [
            'name' => 'Composite doors',
            'group' => 'Doors',
            'covers' => 'Distinction composite entrance doors and stable doors',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/distinction-composite-door-installed.jpg',
            'image_alt' => 'Composite entrance door fitted to a home',
            'intro' => 'A composite door is a solid insulated slab with a moulded skin, and it never needs painting. What it does need is a wash, a bit of attention to the hardware, and the habit of lifting the handle fully before you turn the key.',
            'routine' => [
                [
                    'title' => 'Wash it with warm water and a soft cloth',
                    'body' => 'Warm water and a lint free cloth is genuinely all the skin wants, two or three times a year. If you are on a coast, near a main road or the door faces the weather, do it more often. No abrasive cleaners, no scouring pads, no pressure washer, no steam cleaner, no bleach and no solvents.',
                ],
                [
                    'title' => 'Do not paint it',
                    'body' => 'The colour is in the skin and the finish is factory applied. Painting a composite door affects the warranty and it never looks right for long, because paint sits on a surface designed not to hold it.',
                ],
                [
                    'title' => 'Damp cloth on the hardware, nothing else',
                    'body' => 'Handles, letterplate, knocker and hinges take a wipe with a damp cloth and a dry off. Chrome, satin and black finishes all mark permanently under chemical cleaners, and that includes the ones sold for bathrooms.',
                ],
                [
                    'title' => 'Graphite or PTFE in the cylinder, never oil',
                    'body' => 'A lock cylinder wants a dry lubricant: a puff of graphite or a PTFE lock spray once a year. Oil and general purpose sprays gum up the pins and collect dust, and a cylinder treated with oil will eventually get worse rather than better. Keep the oil for the hinges.',
                ],
                [
                    'title' => 'A drop of oil on the hinges',
                    'body' => 'Once a year at each knuckle, then wipe the excess off before it runs down the door face.',
                ],
                [
                    'title' => 'Lift the handle fully, then turn the key',
                    'body' => 'The multipoint lock only throws its hooks and rollers on a complete lift. Half lifting and turning is what wears a gearbox out early, and it is the commonest habit behind a door that stops locking after a couple of years.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The door is hard to close or lock',
                    'steps' => [
                        'Check the threshold and the frame for grit, a stone or a stray bit of draught excluder.',
                        'Close the door and look at the gap around the slab. It should be even top to bottom down the lock side.',
                        'Lift the handle in one full movement before turning the key.',
                        'Note the weather. A slab that is tighter in a hot spell and fine again in autumn is moving with the temperature, which is normal.',
                    ],
                    'note' => 'If it stays tight once the weather has changed, the door needs adjusting at the hinges or the keeps. Both are designed to be adjusted and both want doing properly.',
                ],
                [
                    'problem' => 'The key is stiff in the cylinder',
                    'steps' => [
                        'Try the key with the door open. If it turns freely open and stiffly closed, the lock is fine and the door is out of alignment.',
                        'If it is stiff either way, put a puff of graphite or PTFE lock spray into the keyway and work the key in and out several times.',
                    ],
                    'note' => 'Do not put oil or a general purpose spray in the cylinder. It feels better for a fortnight and worse thereafter.',
                ],
                [
                    'problem' => 'There is a draught down one side',
                    'steps' => [
                        'Run your hand down the seal with the door closed and locked, not just pushed to.',
                        'Check the gasket for grit or a section that has come out of its groove.',
                        'Confirm you are locking the door rather than just latching it, because the door only compresses onto its seals when the multipoint is thrown.',
                    ],
                    'note' => 'If it is draughty when fully locked and the seal is sound, the keeps need adjusting to pull the slab in further.',
                ],
                [
                    'problem' => 'The door has a squeak or a creak',
                    'steps' => [
                        'A drop of light oil at each hinge knuckle, then open and close it a few times.',
                        'Wipe off anything that has run.',
                    ],
                    'note' => 'Almost always just a dry hinge, and almost always fixed in a minute.',
                ],
                [
                    'problem' => 'There is a scuff or a mark on the skin',
                    'steps' => [
                        'Warm soapy water and a soft cloth first. Most scuffs are transfer from something that touched the door rather than damage to it.',
                    ],
                    'note' => 'Do not attack it with an abrasive or a solvent, because that turns a mark into a dull patch. If it will not wash off, show us.',
                ],
            ],
            'call_us' => 'A door that stays hard to lock once the weather has settled, a handle that will not lift, a lock that grinds, a draught that survives a proper lock, or damage to the skin. Every Distinction door we fit runs AI Secure locking with an APECS three star cylinder and an ILH Duplex multipoint, and it is worth keeping that working properly rather than forcing it.',
        ],

        'upvc-doors' => [
            'name' => 'uPVC doors',
            'group' => 'Doors',
            'covers' => 'uPVC entrance, back and French doors',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-upvc-door.jpg',
            'image_alt' => 'uPVC door fitted to a home',
            'intro' => 'A uPVC door is looked after much like a uPVC window, with one addition: the multipoint lock does the real work and it responds well to being used properly and oiled once a year.',
            'routine' => [
                [
                    'title' => 'Wash the frame and panel twice a year',
                    'body' => 'Warm soapy water and a soft cloth. A uPVC cream cleaner on the cloth for stubborn marks. No abrasives, no solvents, no bleach, no pressure washer.',
                ],
                [
                    'title' => 'Oil the locking points once a year',
                    'body' => 'Open the door and lift the handle so the hooks and rollers come out along the edge. A drop of light oil on each, and on the keeps in the frame, then work the handle several times.',
                ],
                [
                    'title' => 'Dry lubricant in the cylinder',
                    'body' => 'Graphite or a PTFE lock spray once a year. Not oil, which collects dust inside the mechanism.',
                ],
                [
                    'title' => 'Lift the handle fully before turning the key',
                    'body' => 'Same rule as a composite door and the same reason. A gearbox worn out by half lifted operation is the most avoidable door fault there is.',
                ],
                [
                    'title' => 'Keep the threshold and drainage clear',
                    'body' => 'Brush the threshold out and check the drainage slots in the bottom of the frame, especially on a French pair where the low threshold catches more.',
                ],
                [
                    'title' => 'On a French pair, work the shootbolts',
                    'body' => 'The passive leaf is held by bolts top and bottom. Operate them a few times a year and put a drop of oil on each so they do not seize in one position.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The door will not lock without a shove',
                    'steps' => [
                        'Check the keeps and the threshold for grit.',
                        'Look at the gap down the lock side with the door closed. Even top to bottom is right.',
                        'Lift the handle in one complete movement.',
                    ],
                    'note' => 'A door needing a shove is a door out of alignment, and the shove is going through the gearbox every time. Worth fixing rather than living with.',
                ],
                [
                    'problem' => 'The handle is floppy or the lock feels vague',
                    'steps' => [
                        'Stop using it beyond what you need to get in and out.',
                    ],
                    'note' => 'That is usually the gearbox on its way out. Continuing to force it is how you end up locked out rather than booked in. Call us.',
                ],
                [
                    'problem' => 'One leaf of a French pair drags',
                    'steps' => [
                        'Check both shootbolts on the passive leaf are fully home before judging the active one.',
                        'Clear the threshold.',
                    ],
                    'note' => 'French pairs rely on the passive leaf being properly secured. Half a shootbolt throws the whole pair out.',
                ],
            ],
            'call_us' => 'A vague or floppy handle, a door needing force to lock, a dropped leaf, or misting inside the glass.',
        ],

        'integral-blinds' => [
            'name' => 'Integral blinds',
            'group' => 'Glass and extras',
            'covers' => 'Magnetic and electric blinds sealed inside the glass',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg',
            'image_alt' => 'Integrated blind slats inside a sealed glass unit',
            'intro' => 'The blind is sealed inside the glazed unit, which is the whole point of it: there is nothing to dust, nothing to wash and no cords. Care comes down to cleaning the glass normally and working the control gently.',
            'routine' => [
                [
                    'title' => 'Clean the glass exactly as you would any other',
                    'body' => 'Glass cleaner or warm soapy water on the inner and outer faces. The blind is behind sealed glass so nothing you use on the surface reaches it.',
                ],
                [
                    'title' => 'Move the magnetic slider slowly and keep it flat',
                    'body' => 'The slider on the outside of the glass holds the carrier inside through the glass. Slide it steadily and keep it against the frame rather than pulling it away. Rushing it or lifting it is what breaks the magnetic link.',
                ],
                [
                    'title' => 'Do not run the slider off the end of its travel',
                    'body' => 'It has a defined stop at each end. Forcing it past is the one way to leave the internal carrier stranded.',
                ],
                [
                    'title' => 'On electric blinds, check the power first',
                    'body' => 'If a motorised blind stops responding, batteries in the remote and the supply to the unit account for most of it before anything else is worth considering.',
                ],
                [
                    'title' => 'Never try to open the unit',
                    'body' => 'It is a sealed double glazed unit with the blind inside the cavity. Opening it ends the seal, the blind and the guarantee in one go.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The slats have stopped responding to the slider',
                    'steps' => [
                        'Slide the outer control slowly back to the bottom of its travel and pause there.',
                        'The internal carrier usually sits waiting at the bottom, and moving the magnet slowly over it lets the two pick each other up again.',
                        'Once you feel it engage, work it gently through its range a couple of times.',
                    ],
                    'note' => 'This is the commonest thing that happens with a magnetic blind and it is almost always recoverable in a minute. Slowly is the operative word: moving fast is what lost the connection in the first place.',
                ],
                [
                    'problem' => 'The slats tilt but will not raise',
                    'steps' => [
                        'Check you are using the right part of the control travel. Tilt and lift are different movements on the same slider.',
                        'Return to the bottom of the travel and start again slowly.',
                    ],
                    'note' => 'If the tilt works and the lift does not after that, the internal cord or carrier needs looking at, and that is a unit level job.',
                ],
                [
                    'problem' => 'One or two slats sit crooked',
                    'steps' => [
                        'Run the blind fully down and fully up again a couple of times, slowly.',
                    ],
                    'note' => 'A slat that stays out of line after that will not correct itself, and the fix is at the unit rather than through the glass. Tell us.',
                ],
            ],
            'call_us' => 'A blind that will not re-engage after a slow reset, slats that stay crooked, a motor that does not respond on known good power, or any misting inside the unit. The blind is inside sealed glass, so a real fault means the unit is replaced rather than repaired in place.',
        ],

        'roof-lanterns' => [
            'name' => 'Roof lanterns and rooflights',
            'group' => 'Glass and extras',
            'covers' => 'Roof lanterns and flat rooflights',
            'image' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-roof-lantern-interior.jpg',
            'image_alt' => 'Interior view of a roof lantern over a kitchen',
            'intro' => 'The first thing to say about a rooflight is the thing nobody wants to hear: do not go up to it. Everything a homeowner should do here is done from inside or from the ground.',
            'routine' => [
                [
                    'title' => 'Stay off the roof',
                    'body' => 'A rooflight is glass in a roof, usually over a hard floor, often above a single storey extension with nothing beside it to stand on. Cleaning it is not worth a ladder on a flat roof or a foot on a frame. If the outside needs doing, ask us or a window cleaner set up for it.',
                ],
                [
                    'title' => 'Clean the inside face normally',
                    'body' => 'Glass cleaner or warm soapy water on a cloth, from a proper stepladder on a level floor with somebody else in the house. The internal rafters and frame take a damp cloth at the same time.',
                ],
                [
                    'title' => 'Let self cleaning glass do its job',
                    'body' => 'Most rooflights we fit have a self cleaning coating on the outer face. Daylight breaks down what lands on it and rain carries it off, so it wants leaving alone rather than treating. Keep silicone based products, waxes and abrasives off it, because those are what spoil the coating.',
                ],
                [
                    'title' => 'Watch the edges from the ground',
                    'body' => 'Twice a year, look at where the rooflight meets the roof. Leaves, moss and silt building up against the upstand or in the surrounding gutter is the thing worth catching, and you can see all of it from the garden.',
                ],
                [
                    'title' => 'Keep the gutters and valleys clear',
                    'body' => 'Not the rooflight itself, but the drainage around it. Water that cannot get away sits against a detail that was designed to shed it.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'There is condensation on the outside in the morning',
                    'steps' => [
                        'Nothing to do. It burns off as the sun comes up.',
                    ],
                    'note' => 'It happens on clear still nights because the outer pane is losing heat to the sky and staying cold, which it can only do if almost no warmth is coming through from inside. On a rooflight it is more noticeable than anywhere else in the house and it is a sign the glass is performing.',
                ],
                [
                    'problem' => 'There is condensation on the inside',
                    'steps' => [
                        'This is room moisture, and a kitchen or a bathroom under a rooflight produces a lot of it.',
                        'Run the extractor for longer, especially after cooking or showering, and give the room some background ventilation.',
                    ],
                    'note' => 'Warm wet air rises and a rooflight is the coldest surface it reaches, so it shows there first. Ventilation is the answer rather than anything done to the glass.',
                ],
                [
                    'problem' => 'The outside has gone green or streaked',
                    'steps' => [
                        'Note how it looks after a good spell of rain, because a self cleaning coating needs weather to work and a dry month will let a film build up.',
                    ],
                    'note' => 'If it does not clear, it wants cleaning properly by someone equipped to work at that height. Ask us rather than going up.',
                ],
                [
                    'problem' => 'A vent or opener has stopped working',
                    'steps' => [
                        'Check the power or the remote batteries on an electric opener.',
                        'Do not climb up to inspect it.',
                    ],
                    'note' => 'Openers and actuators at that height are ours to look at.',
                ],
            ],
            'call_us' => 'Anything on the outside face, anything at the perimeter or upstand, misting inside the glass, an opener that has stopped, or a mark you can only really see from up there. Access is the reason this one has a shorter list of things to try yourself, and it is a good reason.',
        ],
    ];

    return $guides;
}

/**
 * Guide keys in the order they should appear, grouped for the selector.
 */
function fenster_care_guide_groups(): array
{
    $groups = [];

    foreach (fenster_care_guides() as $slug => $guide) {
        $group = (string) ($guide['group'] ?? 'Other');
        $groups[$group][$slug] = $guide;
    }

    return $groups;
}
