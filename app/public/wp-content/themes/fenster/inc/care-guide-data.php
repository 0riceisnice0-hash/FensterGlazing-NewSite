<?php
/**
 * Care and maintenance guide content.
 *
 * These are Fenster's own guides, written for the customer standing in front of
 * the product. They deliberately do not link out to manufacturer PDFs: half the
 * systems we fit publish nothing, the ones that do publish it for fabricators,
 * and somebody with a bifold that will not shut wants the steps, not a download.
 *
 * TONE, and this is the part to hold on to. Owner instruction, 2026-08-19: the
 * first version read as condescending because it kept correcting the reader.
 * "This is moisture in the room, not a fault in the window" tells somebody they
 * are wrong before it tells them anything useful. Two rules came out of that:
 *
 *   1. NO "IT IS NOT X, IT IS Y". Say what the thing is and why it happens.
 *      Where the old copy negated, the new copy explains and reassures.
 *   2. SAY WHAT TO REACH FOR, NOT WHAT TO FEAR. "Rollers run best on a clean dry
 *      surface" carries the same advice as "grease ruins your track" and does
 *      not sell by describing damage. Same rule TONEOFVOICE.md sets out.
 *
 * Structure per guide: what you need to hand, the routine with a frequency
 * against each item, the questions people actually ask, then where to hand over
 * to us. That last one is not a sales line. Hinge geometry, sash balances and
 * lock gearboxes are set in a particular order with the right tools.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Grouped by what actually shares a maintenance routine, which is material and
 * mechanism rather than the marketing category. A flush sash and a tilt and turn
 * are different windows to buy and the same window to look after.
 *
 * `image` is the wide hero for the open guide; `thumb` is the square-ish crop
 * for the picker card. Two crops because one asset cannot do both jobs: a wide
 * establishing shot turns to mush in a 4:3 cell.
 */
function fenster_care_guides(): array
{
    static $guides = null;

    if (is_array($guides)) {
        return $guides;
    }

    $base = '/wp-content/themes/fenster/assets/images/products/curated/';

    $guides = [
        'upvc-windows' => [
            'name' => 'uPVC windows',
            'group' => 'Windows',
            'covers' => 'Casement, flush sash, tilt and turn, French casement, bow and bay',
            'image' => $base . 'liniar-casement-exterior.jpg',
            'thumb' => $base . 'liniar-casement-closeup.jpg',
            'image_alt' => 'White uPVC casement windows on a home',
            'intro' => 'A uPVC window asks for very little. A wash a couple of times a year, drainage slots kept clear and a drop of oil on the moving parts will keep one working sweetly for decades.',
            'kit' => ['Warm soapy water', 'Soft cloth', 'Light machine oil', 'Soft brush'],
            'routine' => [
                [
                    'when' => 'Twice a year',
                    'title' => 'Give the frames a wash',
                    'body' => 'Warm water, a little washing up liquid and a soft cloth, then rinse and dry. Spring and autumn suits most houses, a bit more often if you are on a main road or under trees. For a mark that wants more persuading, a uPVC cream cleaner works nicely put onto the cloth rather than straight onto the frame.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Brush out the drainage slots',
                    'body' => 'Along the bottom of the outer frame you will find small slots, sometimes tucked behind a little hinged cover. Rain is meant to find its way into the frame and these are how it gets back out again. A soft brush or a puff of air keeps them doing their job.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Oil the moving parts',
                    'body' => 'Open the window fully and you will see the hinge arms top and bottom, the mushroom cams along the opening edge, and the keeps they sit into. A drop of oil on each, then work the handle a dozen times to spread it about. This one job keeps handles feeling new.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'What to reach for',
                    'body' => 'Light machine oil or a silicone spray is what window hardware likes best. If something has properly seized, a penetrating spray will free it off, and following that with a proper oil once it is moving keeps it sweet for the long run.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Wipe the seals',
                    'body' => 'The rubber gasket around the glass enjoys a damp cloth and nothing more. Leaving sprays and dressings off it keeps it supple and sitting exactly where it should.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Work the trickle vents',
                    'body' => 'If your windows have vents in the head, open and close them a couple of times and brush the outer grille. It keeps the background ventilation flowing, which does a lot for the feel of a room.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The handle has gone stiff',
                    'steps' => [
                        'Open the window and take a look at the hinge arms. Dry or gritty arms are usually the whole story.',
                        'Put a drop of oil on every pivot in the hinge, on each mushroom cam along the sash edge, and into each keep on the frame.',
                        'Work the handle a dozen times with the window open, then close it and try again.',
                    ],
                    'note' => 'That sorts the large majority. If it still feels heavy afterwards the sash has usually settled a little and the cams are meeting the keeps at a slight angle, which is a quick hinge adjustment for us.',
                ],
                [
                    'problem' => 'It catches on one corner as it closes',
                    'steps' => [
                        'Have a feel around the frame rebate and the seal for grit, a leaf or a stray bit of packaging.',
                        'Nearly close it and look at the gap around the sash. An even gap all the way round points to debris; tight at one corner and wide at the opposite one points to the sash having settled.',
                    ],
                    'note' => 'A settled sash is a small job to reset and one of the more satisfying ones, because the window goes back to closing with a fingertip.',
                ],
                [
                    'problem' => 'Condensation on the inside of the glass',
                    'steps' => [
                        'Have a think about where the moisture is coming from. Showers, cooking and drying washing indoors all add a surprising amount.',
                        'Use the trickle vents, run extractor fans a good while longer than feels necessary, and leave a little gap behind furniture on outside walls.',
                    ],
                    'note' => 'This is one of the most common things we get asked about after an installation, and there is a straightforward reason for it. New windows seal a house far better than old ones, so moisture that used to drift out through gaps now waits to be ventilated out instead. Get the air moving and it settles down quickly.',
                ],
                [
                    'problem' => 'Condensation on the outside of the glass',
                    'steps' => [
                        'Enjoy it, and let the morning sun clear it.',
                    ],
                    'note' => 'A good sign, this one. The outer pane is staying cold because so little warmth is escaping through the unit, so it tends to show up on the best performing glass on the coldest clear mornings.',
                ],
                [
                    'problem' => 'Misting between the panes',
                    'steps' => [
                        'Send us a photo whenever you spot it.',
                    ],
                    'note' => 'This one is ours. It means the sealed unit is ready for replacing, which is a tidy swap: the old unit comes out, a new one goes in and the frame stays exactly where it is. If it is inside the guarantee there is nothing to pay.',
                ],
            ],
            'call_us' => 'Misting between the panes, a sash that has settled, a handle still heavy after oiling, or a lock that feels like it is working harder than it should. All quick jobs with the right tools.',
        ],

        'sliding-sash-windows' => [
            'name' => 'Sliding sash windows',
            'group' => 'Windows',
            'covers' => 'Ultimate Rose, Heritage Rose and Charisma Rose',
            'image' => $base . 'fenster-sliding-sash-window.jpg',
            'thumb' => $base . 'fenster-sliding-sash-window.jpg',
            'image_alt' => 'White sliding sash window in a period property',
            'intro' => 'A modern sash carries its weight on spiral balances hidden in the frame, and both sashes tilt inwards so you can clean the outside from indoors. Getting comfortable with the tilt is most of the job.',
            'kit' => ['Warm soapy water', 'Soft cloth', 'Light machine oil', 'Both hands free'],
            'routine' => [
                [
                    'when' => 'Twice a year',
                    'title' => 'Tilt the sashes in to clean them',
                    'body' => 'Slide the bottom sash up a few inches, push the two catches on its top edge inwards together, then tilt the top of the sash towards you until it rests. Clean the outer face, then ease it back until both catches click home. The top sash tilts the same way once the bottom one is clear of its path.',
                ],
                [
                    'when' => 'Every time',
                    'title' => 'Keep both hands on a tilted sash',
                    'body' => 'A tilted sash is off its balances, so its weight is resting on your hands and the tilt pivots. Take it steadily, keep hold of it throughout, and finish the window you started before you go and answer the door. It is the one part worth being deliberate about.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Wipe the runs',
                    'body' => 'With the sash tilted you can reach the channels it slides in. A damp cloth down both sides is plenty. The sash runs on a low friction strip that is happiest clean and dry, so a wipe does more good here than anything from a can.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Wash the frames and check the sill',
                    'body' => 'Warm soapy water on a soft cloth, the same as any uPVC frame. While you are there, run a finger along the outer sill and clear anything sitting in the drainage path.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Oil the sash locks',
                    'body' => 'The fitch or sash locks on the meeting rail take a spot of light oil and stay sweet for years. The spiral balances inside the frame come set to the weight of your particular sash and are happiest left exactly as they are.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The sash will not stay where I put it',
                    'steps' => [
                        'Check first that both tilt catches are fully home, because a sash sitting slightly proud of its latch will drag.',
                        'If the catches are home and it still creeps, leave it there and give us a call.',
                    ],
                    'note' => 'The spiral balance wants resetting, and it is adjusted with a particular tool against the weight of that exact sash. Genuinely a two minute job for someone with the tool in the van.',
                ],
                [
                    'problem' => 'The sash is stiff to slide',
                    'steps' => [
                        'Tilt it in and wipe both channels and the sash edges.',
                        'Pay attention to the very bottom of the run, which is where the dirt likes to gather.',
                        'Slide it a few times after cleaning before you decide.',
                    ],
                    'note' => 'Nine times in ten a wipe is the whole fix, and the sash runs better dry than it ever will with anything added.',
                ],
                [
                    'problem' => 'The tilt catches will not release',
                    'steps' => [
                        'Raise the sash clear of its stop first, then push both catches inwards at the same time with an even pressure.',
                        'Push inwards rather than downwards, which is the direction they are made to move.',
                        'A stiff catch appreciates a spot of oil and usually frees up straight after.',
                    ],
                    'note' => 'They are designed to need two hands, which is deliberate: it is what stops a sash tilting when nobody is holding it.',
                ],
                [
                    'problem' => 'The meeting rails do not line up',
                    'steps' => [
                        'Check the bottom sash is fully down and the top sash fully up before judging it, as a few millimetres either way shows here.',
                    ],
                    'note' => 'If they still sit out of line, one sash is running slightly unevenly on its balances and wants setting. Worth a look because it is the detail your eye keeps returning to.',
                ],
            ],
            'call_us' => 'Anything to do with the balances, a sash that will not hold its position, a tilt pivot with any play in it, or misting inside the glass. Sash gear is set to the weight of its own sash, so it responds well to the right tool and not much else.',
        ],

        'aluminium-windows' => [
            'name' => 'Aluminium windows',
            'group' => 'Windows',
            'covers' => 'Casement, flush and heritage aluminium windows',
            'image' => $base . 'sheerline-aluminium-window.jpg',
            'thumb' => $base . 'sheerline-aluminium-window-closeup.png',
            'image_alt' => 'Slim grey aluminium windows on a modern home',
            'intro' => 'The frame is aluminium under a baked powder coated finish, and that finish is the thing you are looking after. Treat it the way you would treat car paint and it will outlast almost everything around it.',
            'kit' => ['Warm water', 'Mild detergent', 'Soft sponge', 'Light machine oil'],
            'routine' => [
                [
                    'when' => 'Twice a year',
                    'title' => 'Wash it down',
                    'body' => 'Warm water and a mild detergent on a soft cloth or sponge, then rinse and dry. Twice a year suits most houses. Near the coast, on a busy road or on an industrial estate, quarterly keeps it looking sharper, because salt and traffic film both like to settle on a coating.',
                ],
                [
                    'when' => 'Every wash',
                    'title' => 'Rinse first, then wipe',
                    'body' => 'On a frame with grit on it, a rinse with clean water before the cloth goes anywhere near keeps the grit off the coating. It is a small habit and it is why some dark frames still look showroom fresh after ten years, because dark finishes show every detail of how they have been treated.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'What the coating likes',
                    'body' => 'Water, mild detergent and a soft cloth, and that really is the list. A powder coat is a baked finish with a deep even colour, and keeping solvents and abrasive pads away from it is what preserves that depth. Sheerline back the finish for 25 years, which tells you how it responds to being left in peace.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Clear the drainage slots',
                    'body' => 'Small slots along the bottom of the outer frame, brushed clear. The same job as any window and just as worth doing.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Oil the hardware',
                    'body' => 'Hinges, the locking cams along the sash edge and the keeps they engage. Light machine oil or silicone, and wipe the excess away afterwards so it stays off the frame face.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'There are dull or white patches on a dark frame',
                    'steps' => [
                        'Wash the area with mild detergent and plenty of water first, because traffic film and hard water deposits both look like marks in the finish until they come off.',
                        'Dry it and have another look in daylight.',
                    ],
                    'note' => 'That lifts most of them. If something is still there afterwards, send us a photo. Sheerline guarantee the powder coated finish for 25 years and we will take it from there.',
                ],
                [
                    'problem' => 'The handle is stiff',
                    'steps' => [
                        'Open the window and oil the hinge pivots, the cams and the keeps.',
                        'Work the handle a dozen times, then try it closed.',
                    ],
                    'note' => 'Aluminium sashes carry more weight than uPVC ones of the same size, so they let you know sooner when a hinge is ready for its annual oil. The yearly habit pays off more here than on any other window we fit.',
                ],
                [
                    'problem' => 'It feels draughty in a strong wind',
                    'steps' => [
                        'Run a finger round the gasket to check nothing is caught in it.',
                        'Close the window and watch the compression: the sash wants to pull evenly onto the seal along its whole length.',
                    ],
                    'note' => 'Even compression is a keep adjustment and a quick one. Getting it exactly even is what makes the difference between good and silent.',
                ],
            ],
            'call_us' => 'Anything in the powder coat itself, a sash that has settled, misting inside the glass, or a lock still stiff after its oil.',
        ],

        'bifold-doors' => [
            'name' => 'Bifold doors',
            'group' => 'Doors',
            'covers' => 'Aluminium bifolds and slide and fold doors',
            'image' => $base . 'sheerline-bifold-exterior.jpg',
            'thumb' => $base . 'sheerline-bifold-doors.jpg',
            'image_alt' => 'Aluminium bifold doors opened onto a garden',
            'intro' => 'A bifold runs on rollers in a track, and the track is very nearly the whole of the maintenance. Keep it clean and a set will glide with one finger for twenty years.',
            'kit' => ['Vacuum with crevice tool', 'Damp cloth', 'Light machine oil', 'Dry silicone spray'],
            'routine' => [
                [
                    'when' => 'Every month or two',
                    'title' => 'Vacuum the bottom track',
                    'body' => 'Crevice tool end to end, including the stretch that sits under the panels when they are parked, then a damp cloth along the running surface and dry it off. Run a fingertip along afterwards: a track that feels smooth to a finger feels smooth to a roller.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Do the top track too',
                    'body' => 'The top guide gathers less, but it gathers. A vacuum and a wipe is the whole job.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'Clean and dry beats anything in a can',
                    'body' => 'Rollers run best on a clean dry surface, so a vacuum and a cloth genuinely is the answer here. Grease and heavy oils tend to hold onto grit, so if you do want to add something after a good clean, a dry PTFE or silicone spray is the one to reach for, used sparingly.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Oil the hinges',
                    'body' => 'The hinges between the panels do enjoy a drop of light oil at each knuckle. Wipe away whatever does not soak in.',
                ],
                [
                    'when' => 'Autumn especially',
                    'title' => 'Keep the threshold drainage flowing',
                    'body' => 'There are drainage points in and just outside the threshold. Brushing out leaves and silt keeps water heading where it was designed to go, which matters most in the months when the garden is dropping things.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Wash the frames and wipe the gaskets',
                    'body' => 'Warm soapy water on the frames and a damp cloth on the seals. On dark aluminium, rinse the grit off before the cloth goes on.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The doors have started dragging or sticking',
                    'steps' => [
                        'Start with the track, because this is the answer about nine times in ten. Vacuum the full length including under where the panels park, then wipe and dry it.',
                        'Keep an eye out for the single culprit as you go: a stone, a screw, a bottle top, or silt built up at one end.',
                        'Check the panels are folding in the order they were designed to fold in. A bifold stacks in a set sequence and it much prefers being taken in turn.',
                        'Try the traffic door on its own before the full stack. If the single door is happy and the stack is not, that points at the folding order or a hinge rather than the lock.',
                        'Open and close the set a few times after cleaning before you judge it.',
                    ],
                    'note' => 'A clean track fixes the majority outright. If it still drags afterwards, the doors have settled a touch and want their hinges resetting. Bifold hinges adjust in more than one plane and in a particular order, so it is a job that goes quickly with the right sequence and the right allen keys.',
                ],
                [
                    'problem' => 'The handle will not lift, or it will not lock',
                    'steps' => [
                        'Make sure the door is fully closed into the frame first, because the panels want to be square in the opening before the handle will do its thing.',
                        'Lift the handle in one full movement to its stop, then turn the key. A multipoint lock throws its points on a complete lift.',
                        'Have a quick look at the keeps in the frame and the threshold for grit.',
                    ],
                    'note' => 'If the handle still will not go, leave it there and give us a ring. Something is sitting a millimetre or two out of line, and finding which millimetre is exactly the sort of thing we are quick at.',
                ],
                [
                    'problem' => 'They are stiffer in cold weather',
                    'steps' => [
                        'Note whether they ease off again as the temperature comes back up.',
                    ],
                    'note' => 'Aluminium moves a little with temperature, so a set that is slightly firmer in a hard frost and back to normal in milder weather is behaving exactly as it should. If it stays firm once the cold has passed, that is worth a look.',
                ],
                [
                    'problem' => 'Water is sitting in the track',
                    'steps' => [
                        'Clear the drainage points in and around the threshold with a soft brush.',
                        'Have a look outside too, since decking, gravel or a raised patio built up against the threshold can cover the outlets.',
                    ],
                    'note' => 'That clears it in most cases. If the drainage is running freely and water is still standing, tell us and we will look at the threshold detail.',
                ],
                [
                    'problem' => 'There is a draught at the bottom of the stack',
                    'steps' => [
                        'Check the brush seals along the bottom of the panels for grit caught in the pile.',
                        'Close the set and look along the meeting edges for an even gap.',
                    ],
                    'note' => 'An even gap all the way along is what you are after, and getting there is an alignment job rather than a seal one.',
                ],
            ],
            'call_us' => 'A set still dragging on a clean track, a handle that will not lift, a panel that has settled, water standing once the drainage is clear, or a hinge with play in it. Bifold hinges are adjustable by design, and they respond very well to being set properly.',
        ],

        'sliding-doors' => [
            'name' => 'Sliding and patio doors',
            'group' => 'Doors',
            'covers' => 'Aluminium sliding doors and lift and slide patio doors',
            'image' => $base . 'sheerline-sliding-door.jpg',
            'thumb' => $base . 'liniar-patio-door.jpg',
            'image_alt' => 'Large aluminium sliding door onto a garden',
            'intro' => 'A sliding door carries a lot of glass on a small number of rollers, and like a bifold it rewards a clean track more than anything else you could do for it.',
            'kit' => ['Vacuum with crevice tool', 'Damp cloth', 'Soft brush'],
            'routine' => [
                [
                    'when' => 'Every month or two',
                    'title' => 'Vacuum and wipe the track',
                    'body' => 'Crevice tool along the full run, then a damp cloth and dry off. The ends of the track and the section under the parked panel are where silt likes to settle, so give those a moment longer.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'Clean and dry is the target',
                    'body' => 'The same principle as a bifold. Rollers are happiest on a clean dry running surface, and a light dry silicone spray after a proper clean is as much as one ever needs.',
                ],
                [
                    'when' => 'Every use',
                    'title' => 'Let the door lift before you push it',
                    'body' => 'On a lift and slide, turning the handle down lifts the whole panel onto its rollers and clear of its seals. Complete that movement first and a very large door will run with one hand, which is the moment these doors show what they are.',
                ],
                [
                    'when' => 'Autumn especially',
                    'title' => 'Clear the threshold drainage',
                    'body' => 'Brush the drainage points out and check outside as well, since decking or gravel piled against the threshold can sit over the outlets.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Wipe the interlock and gaskets',
                    'body' => 'The upright where the two panels meet closes onto a seal. A damp cloth along it keeps that seal doing the quiet work it does.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The door is heavy to slide',
                    'steps' => [
                        'On a lift and slide, check the handle is going all the way round. Most heavy doors turn out to be doors that have not quite lifted.',
                        'Vacuum and wipe the full track, including under the parked panel.',
                        'Have a look along the running surface for a stone, a screw or a dent.',
                    ],
                    'note' => 'If it is still heavy with a clean track and the panel properly lifted, the rollers want adjusting or replacing, and that is ours. A well set sliding door should move with a fingertip.',
                ],
                [
                    'problem' => 'The door will not lock',
                    'steps' => [
                        'Slide it fully home into the jamb before trying the handle, since an inch short is enough to hold the hooks off their keeps.',
                        'On a lift and slide, lower the handle fully so the panel drops onto its seals and the hooks line up.',
                        'Check the keeps for grit.',
                    ],
                    'note' => 'Hook locks engage cleanly and quietly when the door is sitting where it should be, so a lock that needs persuading is telling you about the alignment rather than the lock.',
                ],
                [
                    'problem' => 'There is a draught along the meeting upright',
                    'steps' => [
                        'Check the brush or gasket seal on the interlock for grit in the pile.',
                        'On a lift and slide, confirm the door is fully lowered when closed, since it seals in the down position.',
                    ],
                    'note' => 'Leaving a lift and slide slightly raised is an easy habit to fall into and an easy one to fix, and the difference in a wind is immediate.',
                ],
            ],
            'call_us' => 'Worn or noisy rollers, a panel that has settled, a lock that needs persuading on a properly closed door, or water standing once the drainage is clear.',
        ],

        'composite-doors' => [
            'name' => 'Composite doors',
            'group' => 'Doors',
            'covers' => 'Distinction composite entrance doors and stable doors',
            'image' => $base . 'distinction-composite-door-installed.jpg',
            'thumb' => $base . 'distinction-composite-door.jpg',
            'image_alt' => 'Composite entrance door fitted to a home',
            'intro' => 'A composite door is a solid insulated slab under a moulded skin, and it keeps its colour without ever being painted. What it appreciates is a wash, a little attention to the hardware, and a good firm lift of the handle.',
            'kit' => ['Warm water', 'Lint-free cloth', 'Light machine oil', 'Graphite or PTFE lock spray'],
            'routine' => [
                [
                    'when' => 'Two or three times a year',
                    'title' => 'Wash the skin',
                    'body' => 'Warm water and a lint free cloth is genuinely all it asks for. More often if you are on the coast, near a main road or the door faces the weather square on. The finish is made to shrug all that off and a wipe is what keeps it looking like the day it went in.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'The colour is built in',
                    'body' => 'The finish goes right through the skin and is applied at the factory, so the door holds its colour without painting and keeps its warranty at the same time. One of the quiet pleasures of a composite door is that it is the one thing on the front of the house you never have to get the brushes out for.',
                ],
                [
                    'when' => 'Every wash',
                    'title' => 'A damp cloth on the hardware',
                    'body' => 'Handles, letterplate, knocker and hinges take a wipe with a damp cloth and a dry off. Chrome, satin and black finishes all keep their depth beautifully on water alone.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Graphite or PTFE in the cylinder',
                    'body' => 'A lock cylinder likes a dry lubricant: a puff of graphite or a PTFE lock spray, once a year, and the key will turn like new. Keep the oil for the hinges, which want the opposite thing.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'A drop of oil on the hinges',
                    'body' => 'At each knuckle, then wipe the excess before it finds its way down the door face.',
                ],
                [
                    'when' => 'Every time',
                    'title' => 'Lift the handle fully, then turn the key',
                    'body' => 'The multipoint lock throws all its hooks and rollers on a complete lift, so one firm movement to the stop is what you are after. It is the single habit that keeps a door locking sweetly for years, and it takes no longer than a half hearted one.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'It is hard to close or lock',
                    'steps' => [
                        'Have a look at the threshold and frame for grit or a stray bit of draught excluder.',
                        'Close the door and check the gap around the slab, which wants to be even top to bottom down the lock side.',
                        'Lift the handle in one full movement before turning the key.',
                        'Note the weather. A slab that is a little tighter in a hot spell and easy again in autumn is simply moving with the temperature.',
                    ],
                    'note' => 'If it stays tight once the weather has turned, the door wants adjusting at the hinges or the keeps. Both are designed to be adjusted, and a properly set door closes with a satisfying click rather than a shoulder.',
                ],
                [
                    'problem' => 'The key feels stiff',
                    'steps' => [
                        'Try the key with the door open. Turning freely open and stiffly closed points at the alignment rather than the lock.',
                        'If it is stiff either way, a puff of graphite or PTFE lock spray into the keyway and a few turns of the key usually transforms it.',
                    ],
                    'note' => 'Cylinders respond wonderfully to a dry lubricant and it takes about ten seconds.',
                ],
                [
                    'problem' => 'There is a draught down one side',
                    'steps' => [
                        'Run your hand down the seal with the door closed and locked rather than just pushed to.',
                        'Check the gasket for grit or a section that has eased out of its groove.',
                        'Confirm you are locking it rather than latching it, since the slab pulls onto its seals when the multipoint is thrown.',
                    ],
                    'note' => 'If it is still draughty when fully locked and the seal looks sound, the keeps want adjusting to draw the slab in a touch further.',
                ],
                [
                    'problem' => 'There is a squeak or a creak',
                    'steps' => [
                        'A drop of light oil at each hinge knuckle, then open and close it a few times.',
                        'Wipe away anything that has run.',
                    ],
                    'note' => 'Almost always a hinge ready for its oil, and almost always sorted inside a minute.',
                ],
                [
                    'problem' => 'There is a scuff on the skin',
                    'steps' => [
                        'Warm soapy water and a soft cloth first. Most scuffs turn out to be transfer from whatever touched the door and lift straight off.',
                    ],
                    'note' => 'If it stays put after a wash, send us a photo and we will tell you what we are looking at.',
                ],
            ],
            'call_us' => 'A door still tight once the weather has settled, a handle that will not lift, a lock working harder than it should, a draught that survives a proper lock, or anything in the skin. Every Distinction door we fit runs AI Secure locking with an APECS three star cylinder and an ILH Duplex multipoint, and that gear is worth keeping properly set.',
        ],

        'upvc-doors' => [
            'name' => 'uPVC doors',
            'group' => 'Doors',
            'covers' => 'uPVC entrance, back and French doors',
            'image' => $base . 'fenster-upvc-door.jpg',
            'thumb' => $base . 'fenster-upvc-door.jpg',
            'image_alt' => 'uPVC door fitted to a home',
            'intro' => 'A uPVC door is looked after much like a uPVC window, with one addition: the multipoint lock does the real work, and it responds beautifully to a yearly oil and a full lift of the handle.',
            'kit' => ['Warm soapy water', 'Soft cloth', 'Light machine oil', 'PTFE lock spray'],
            'routine' => [
                [
                    'when' => 'Twice a year',
                    'title' => 'Wash the frame and panel',
                    'body' => 'Warm soapy water and a soft cloth, with a uPVC cream cleaner on the cloth for anything that wants more persuading.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Oil the locking points',
                    'body' => 'Open the door and lift the handle so the hooks and rollers come out along the edge. A drop of oil on each of those and on the keeps in the frame, then work the handle several times.',
                ],
                [
                    'when' => 'Once a year',
                    'title' => 'Dry lubricant in the cylinder',
                    'body' => 'Graphite or a PTFE lock spray, which is what a cylinder is happiest with.',
                ],
                [
                    'when' => 'Every time',
                    'title' => 'Lift the handle fully, then turn the key',
                    'body' => 'The same habit as a composite door and for the same reason: a full lift throws the whole mechanism and keeps it feeling new.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Keep the threshold clear',
                    'body' => 'Brush the threshold out and check the drainage slots in the bottom of the frame, especially on a French pair where a low threshold catches more of what blows in.',
                ],
                [
                    'when' => 'A few times a year',
                    'title' => 'Work the shootbolts on a French pair',
                    'body' => 'The passive leaf is held top and bottom by bolts. Operating them now and then with a drop of oil on each keeps them moving freely and keeps the pair sitting square.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'It needs a shove to lock',
                    'steps' => [
                        'Check the keeps and the threshold for grit.',
                        'Look at the gap down the lock side with the door closed, which wants to be even top to bottom.',
                        'Lift the handle in one complete movement.',
                    ],
                    'note' => 'A door that wants a shove is telling you it is sitting slightly out of line, and setting it right is quick. A properly aligned uPVC door locks with two fingers.',
                ],
                [
                    'problem' => 'The handle feels loose or vague',
                    'steps' => [
                        'Use it gently for now and give us a ring.',
                    ],
                    'note' => 'That is usually the gearbox letting you know it is ready for replacing, and catching it at the vague stage is much easier than catching it later. A same day job in most cases.',
                ],
                [
                    'problem' => 'One leaf of a French pair drags',
                    'steps' => [
                        'Check both shootbolts on the passive leaf are fully home before judging the active one.',
                        'Clear the threshold.',
                    ],
                    'note' => 'French pairs rely on the passive leaf being properly secured top and bottom, and squaring that up often sorts the whole pair.',
                ],
            ],
            'call_us' => 'A vague handle, a door that wants a shove, a leaf that has settled, or misting inside the glass.',
        ],

        'integral-blinds' => [
            'name' => 'Integral blinds',
            'group' => 'Glass and extras',
            'covers' => 'Magnetic and electric blinds sealed inside the glass',
            'image' => $base . 'notan-integral-blinds.jpg',
            'thumb' => $base . 'notan-integral-blinds-closeup.jpg',
            'image_alt' => 'Integrated blinds inside a sealed glass unit',
            'intro' => 'The blind lives inside the sealed glazed unit, which is rather the point of it. There is nothing to dust, nothing to wash and no cords, so care comes down to cleaning the glass and working the control at a gentle pace.',
            'kit' => ['Glass cleaner or soapy water', 'Soft cloth', 'An unhurried hand'],
            'routine' => [
                [
                    'when' => 'As often as you like',
                    'title' => 'Clean the glass as you would any other',
                    'body' => 'Glass cleaner or warm soapy water on the inner and outer faces. The blind sits behind sealed glass, so it stays exactly as clean as the day it was made no matter what you use on the surface.',
                ],
                [
                    'when' => 'Every use',
                    'title' => 'Move the slider slowly and keep it flat',
                    'body' => 'The slider on the outside holds the carrier inside through the glass. Sliding it steadily and keeping it against the frame is what maintains that magnetic link, and it becomes second nature within a day or two.',
                ],
                [
                    'when' => 'Every use',
                    'title' => 'Let it find its stops',
                    'body' => 'The control has a defined stop at each end of its travel, and stopping where it stops keeps the inner carrier and the outer magnet paired up.',
                ],
                [
                    'when' => 'If electric',
                    'title' => 'Check the power first',
                    'body' => 'On a motorised blind, the remote batteries and the supply to the unit account for the great majority of anything that changes.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'The unit is sealed for life',
                    'body' => 'Everything that makes the blind work is inside a sealed double glazed unit, which is what keeps it permanently clean and free of dust. It is a closed system by design and it stays that way.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'The slats have stopped responding',
                    'steps' => [
                        'Slide the outer control slowly back to the bottom of its travel and pause there a moment.',
                        'The inner carrier usually sits waiting at the bottom, and moving the magnet slowly over it lets the two find each other again.',
                        'Once you feel it engage, work it gently through its range a couple of times.',
                    ],
                    'note' => 'This is the most common thing that happens with a magnetic blind and it is almost always back to normal inside a minute. Slowly is the word that does the work.',
                ],
                [
                    'problem' => 'It tilts but will not raise',
                    'steps' => [
                        'Check which part of the travel you are in, since tilt and lift are different movements on the same slider.',
                        'Return to the bottom of the travel and start again slowly.',
                    ],
                    'note' => 'If the tilt is happy and the lift is not after that, the inner carrier wants looking at, and that is a unit level job for us.',
                ],
                [
                    'problem' => 'One or two slats sit crooked',
                    'steps' => [
                        'Run the blind fully down and fully up again a couple of times, slowly.',
                    ],
                    'note' => 'That squares most of them up. Anything still sitting out of line afterwards is worth telling us about, since the fix is at the unit rather than through the glass.',
                ],
            ],
            'call_us' => 'A blind that will not re-engage after a slow reset, slats still crooked after a cycle, a motor that stays quiet on known good power, or misting inside the unit.',
        ],

        'roof-lanterns' => [
            'name' => 'Roof lanterns and rooflights',
            'group' => 'Glass and extras',
            'covers' => 'Roof lanterns and flat rooflights',
            'image' => $base . 'sheerline-roof-lantern-interior.jpg',
            'thumb' => $base . 'sheerline-roof-lantern.jpg',
            'image_alt' => 'Roof lantern over a kitchen, seen from inside',
            'intro' => 'Everything a rooflight needs from you is done from inside or from the ground. The outside is our job, and we would much rather it was.',
            'kit' => ['Glass cleaner', 'Soft cloth', 'A stepladder on a level floor'],
            'routine' => [
                [
                    'when' => 'Leave to us',
                    'title' => 'The outside is ours',
                    'body' => 'A rooflight sits above a hard floor with very little safe to stand on around it, so give us a ring when the outside wants doing and we will bring the kit for it. It is a short job with the right access and it is one we are glad to take off your hands.',
                ],
                [
                    'when' => 'As often as you like',
                    'title' => 'Clean the inside face',
                    'body' => 'Glass cleaner or warm soapy water on a cloth, from a proper stepladder on a level floor with somebody else in the house. The internal rafters and frame take a damp cloth at the same time.',
                ],
                [
                    'when' => 'Good to know',
                    'title' => 'Self cleaning glass does the outer face for you',
                    'body' => 'Most rooflights we fit carry a self cleaning coating outside. Daylight breaks down what lands on it and rain carries it away, so the weather handles the maintenance and the coating stays at its best simply left to get on with it.',
                ],
                [
                    'when' => 'Twice a year',
                    'title' => 'Have a look from the garden',
                    'body' => 'From the ground you can see everything worth seeing: how the rooflight meets the roof, and whether leaves or moss are gathering against the upstand or in the gutter beside it. Two minutes with a cup of tea covers it.',
                ],
                [
                    'when' => 'Autumn especially',
                    'title' => 'Keep the gutters and valleys clear',
                    'body' => 'Not the rooflight itself, but the drainage around it. Water that can get away freely keeps the whole detail doing what it was designed to do.',
                ],
            ],
            'fixes' => [
                [
                    'problem' => 'Condensation on the outside in the morning',
                    'steps' => [
                        'Have a look at it before the sun gets to it, because it is rather beautiful.',
                    ],
                    'note' => 'It appears on clear still nights because the outer pane loses heat to the sky and stays cold, which it can only manage when almost no warmth is coming through from inside. A rooflight shows it more clearly than anywhere else in the house, and it is your glazing performing at its best.',
                ],
                [
                    'problem' => 'Condensation on the inside',
                    'steps' => [
                        'Run the extractor a good while longer after cooking or showering.',
                        'Give the room some background ventilation through the day.',
                    ],
                    'note' => 'Warm damp air rises and a rooflight is the first cool surface it reaches, so a kitchen or bathroom will show it there before anywhere else. Getting the air moving sorts it quickly.',
                ],
                [
                    'problem' => 'The outside is looking green or streaked',
                    'steps' => [
                        'Have a look again after a good spell of rain, since a self cleaning coating wants weather to do its work and a dry month lets a film build up.',
                    ],
                    'note' => 'If it is still there afterwards, give us a ring and we will get up and do it properly. That is exactly the sort of thing we would rather you called us about.',
                ],
                [
                    'problem' => 'A vent or opener has stopped',
                    'steps' => [
                        'Check the power, or the remote batteries on an electric opener.',
                        'Then give us a call and stay on the ground.',
                    ],
                    'note' => 'Openers and actuators at that height are ours, and we have the access kit for them.',
                ],
            ],
            'call_us' => 'Anything on the outside face, anything at the perimeter or upstand, misting inside the glass, an opener that has stopped, or something you can only really see from up there. This one has a shorter list to try yourself, and that is entirely deliberate.',
        ],
    ];

    return $guides;
}

/**
 * Guide keys grouped for the picker, in render order.
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
