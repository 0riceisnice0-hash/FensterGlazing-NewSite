<?php
/**
 * Scheduled blog posts.
 *
 * Each post is a virtual route rendered through the existing article template.
 * A post stays invisible everywhere — route, /blog/ hub, sitemap — until its
 * publish_date, so a batch can be committed months ahead and release itself
 * weekly with no cron and no manual step.
 *
 * Editorial rules (agreed with the owner, 2026-08-03):
 * - Straight and helpful tone. No swearing, no template-speak, we/you voice.
 * - Every post maps to a money page through next_steps; the CTA answers the
 *   question the post raises, never a generic "contact us".
 * - 'products' drives imagery: photos come from the real product_media pools
 *   for the products the post actually discusses. Never attach a photo of a
 *   product the post does not mention.
 * - No prices, lead times or performance figures unless verified on the
 *   matching product page first. See SEO-AUDIT-AUG-2026.md for the strategy.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * All posts keyed by slug, including future-dated ones.
 */
function fenster_blog_posts(): array
{
    return [
        'why-bifold-doors-stick-in-hot-weather' => [
            'title' => 'Why bifold doors stick in hot weather',
            'publish_date' => '2026-08-03',
            'title_tag' => 'Why Bifold Doors Stick in Hot Weather | Fenster Glazing',
            'meta_description' => 'Bifold doors that glide in spring can drag in a heatwave. What summer heat does to doors and tracks, what you can fix yourself and when to call us.',
            'products' => ['aluminium-bifold-doors', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A bifold door that glided open in April can start catching, dragging or refusing to lock by the middle of a hot week in August. It feels like something has broken, but most of the time nothing has. Heat changes the door, and a door built to fine tolerances shows it.',
                    ],
                ],
                [
                    'heading' => 'Heat makes door panels grow.',
                    'body' => [
                        'Every door material expands as it warms up, and a bifold has more panels, more hinges and more meeting points than any other door in the house. A long run of panels in direct afternoon sun picks up a surprising amount of heat, and each panel grows by a small amount. Add that growth up across three or four panels and the gaps the door was set up with start to close.',
                        'Dark colours absorb more heat than light ones, and south or west facing openings get the longest exposure. If your door only sticks late on sunny days and frees itself by morning, expansion is almost certainly what you are feeling.',
                    ],
                ],
                [
                    'heading' => 'The track matters as much as the panels.',
                    'body' => [
                        'Bifolds run on rollers in a track, and summer is when tracks collect the most grit: dry soil, grass cuttings, sand and general garden traffic. Debris under a roller makes a door feel heavy long before anything is actually worn out.',
                        'Vacuum the track rather than sweeping it, because sweeping tends to push grit into the corners and under the rollers. A soft brush attachment gets into the channel. Avoid oiling the track itself; oil holds dust and makes the problem worse. If anything needs lubricating it is the hinges and locking points, and a silicone spray is the right thing there.',
                    ],
                ],
                [
                    'heading' => 'What you can safely check yourself.',
                    'body' => [
                        'Clear and vacuum the track, then open and close the door slowly and watch where it catches. If one panel rubs at the top on hot days only, that is expansion. If the door drags along the bottom in all weathers, the rollers or the alignment need attention.',
                        'Check the gaskets too. Rubber seals soften in heat, and a seal that has come loose from its groove can fold over and act like a brake. A loose gasket can usually be pressed back in by hand.',
                    ],
                ],
                [
                    'heading' => 'When it needs an engineer.',
                    'body' => [
                        'Bifold hardware is adjustable by design. The hinges and rollers carry adjustment points that set the panel gaps, and a door that has dropped or drifted out of alignment can usually be brought back without replacing anything. That adjustment is a job for someone who knows the hardware, because each change moves the panel in more than one direction at once.',
                        'If your door sticks in all weathers, will not lock without lifting or slamming, or shows daylight at a corner of the seals, have it looked at before winter. A door fighting its own alignment wears its rollers and gearbox faster than it should.',
                    ],
                ],
                [
                    'heading' => 'Thinking about a bifold that behaves better?',
                    'body' => [
                        'If you are living with an older bifold that has never run well, the difference in a current aluminium system is mostly in the engineering you cannot see: stiffer profiles that move less in heat, better rollers and adjustable hardware throughout. We fit and set up aluminium bifolds across Milton Keynes, and we survey the opening before anything is ordered so the door is built to the space it has to live in.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Sticking door?',
                'title' => 'Get the door running properly again.',
                'copy' => 'If clearing the track has not fixed it, the door needs its alignment checked. We repair and adjust bifold hardware, and if the door is past helping we can price a replacement properly.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Adjustments, rollers, locks and seals'],
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'Current systems, surveyed and fitted'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'do-roof-lanterns-make-a-room-too-hot' => [
            'title' => 'Do roof lanterns make a room too hot?',
            'publish_date' => '2026-08-10',
            'title_tag' => 'Do Roof Lanterns Make a Room Too Hot? | Fenster Glazing',
            'meta_description' => 'Overhead glazing and summer heat: how solar control glass, ventilation and lantern position decide whether a kitchen stays comfortable under a roof lantern.',
            'products' => ['roof-lanterns'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'It is the most common worry we hear about roof lanterns, usually from someone standing in a bright kitchen in August: will all that overhead glass turn the room into a greenhouse? It is the right question to ask, and the honest answer is that it depends entirely on the glass specification, which is decided before the lantern is ordered, not after.',
                    ],
                ],
                [
                    'heading' => 'Why overhead glass is different from a window.',
                    'body' => [
                        'A vertical window only faces the sun directly for part of the day. A roof lantern faces the sky all day, so in summer it collects sunlight from morning to evening. That is exactly why lanterns make rooms feel so much brighter than windows of the same area, and it is also why the glass choice matters more overhead than anywhere else in the house.',
                    ],
                ],
                [
                    'heading' => 'Solar control glass does the heavy lifting.',
                    'body' => [
                        'Modern lantern glazing can carry a solar control coating: a metallic layer inside the sealed unit that reflects a large share of the sun\'s heat while letting the visible light through. The room stays bright, but much less of the energy lands as heat.',
                        'Solar control glass usually carries a light tint, most often a soft blue or neutral grey seen from outside, which also takes the harsh edge off direct glare. On the Sheerline S1 lanterns we fit, the glass specification is chosen per job: solar control, self-cleaning coatings and tint are all decided at the point of order.',
                    ],
                ],
                [
                    'heading' => 'Ventilation is the other half of the answer.',
                    'body' => [
                        'Heat that does get in needs somewhere to go, and warm air collects at the highest point of the room, which under a lantern is the lantern itself. That is why the extension design around the lantern matters: opening doors or windows on two sides of the room lets the warm air actually leave rather than sit under the glass.',
                        'It is also worth thinking about at the design stage rather than after: a lantern over a kitchen that already runs warm from cooking deserves a more cautious glass specification than one over a north-facing dining room.',
                    ],
                ],
                [
                    'heading' => 'The winter side of the same question.',
                    'body' => [
                        'The same engineering that manages summer heat matters in reverse from November. A lantern is a roof, and a poorly insulated one leaks heat all winter. The aluminium lantern systems we fit use thermally broken profiles, an insulating barrier between the outside metal and the inside, alongside modern double glazing, so the lantern is not the cold spot in the room.',
                        'If you have an older lantern or a polycarbonate roof that bakes in summer and freezes in winter, replacing the roof glazing is often the single biggest comfort upgrade the room can get.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Planning a lantern?',
                'title' => 'Get the glass specification right before you order.',
                'copy' => 'The difference between a bright room and a hot one is decided in the specification. We survey the roof, talk through the room and how it is used, and confirm the glass before anything is made.',
                'links' => [
                    ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/'), 'meta' => 'Sheerline S1, layouts and glass options'],
                    ['label' => 'Flat rooflights', 'url' => home_url('/flat-rooflights/'), 'meta' => 'The lower-profile alternative'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk it through at your home'],
                ],
            ],
        ],

        'condensation-on-the-outside-of-windows' => [
            'title' => 'Condensation on the outside of your windows? That\'s good news',
            'publish_date' => '2026-08-17',
            'title_tag' => 'Condensation Outside Your Windows Explained | Fenster Glazing',
            'meta_description' => 'External condensation on new double glazing is the glass insulating well, not a fault. What causes it, when it clears, and the one misting that is a problem.',
            'products' => ['casement-windows', 'double-glazing-replacement'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'From late August the first misty mornings arrive, and every year they bring the same worried phone calls: new windows, fitted months ago, suddenly fogged over, on the outside. It looks like a fault. It is actually the windows doing their job, and understanding why saves an unnecessary complaint or, worse, an unnecessary repair bill from someone less honest.',
                    ],
                ],
                [
                    'heading' => 'Why efficient glass mists on the outside.',
                    'body' => [
                        'Condensation forms on any surface that is colder than the air around it, the same way a cold drink mists on a summer afternoon. An old, inefficient window leaks enough heat from the house to keep its outer pane slightly warm overnight, so dew never forms on it.',
                        'A modern double glazed unit holds the heat inside the room instead. The outer pane stays cold overnight because barely any heat is escaping through the glass to warm it. On a clear, still night at the end of summer, that cold outer pane drops below the dew point and mists over, exactly like the grass and car windscreens around it.',
                    ],
                ],
                [
                    'heading' => 'When it appears and when it clears.',
                    'body' => [
                        'External condensation is most common in late summer and autumn, when nights are cool and clear but the air still carries plenty of moisture. You will usually see it in the early morning, often only on the windows facing open sky, and it clears on its own as the sun warms the glass, typically by mid-morning.',
                        'It may be patchy, misting some windows and not their neighbours. That is down to tiny differences in exposure, shelter and sky view, not a difference in the glass.',
                    ],
                ],
                [
                    'heading' => 'The condensation that is a problem.',
                    'body' => [
                        'Where condensation appears matters far more than how much of it there is. On the outside face: a sign of efficient glass, no action needed. On the inside face, in the room: the room needs more ventilation or less moisture, common in kitchens, bathrooms and bedrooms overnight.',
                        'Between the two panes, where you cannot wipe it: that is a failed sealed unit. The gap between the panes is meant to be sealed and dry, and misting inside it means the seal has gone. The unit will not recover, but it can be replaced on its own without changing the frame, which is a far smaller job than a new window.',
                    ],
                ],
                [
                    'heading' => 'A quick way to tell the three apart.',
                    'body' => [
                        'Run a finger across the misted glass. If it wipes clear from inside the room, it is internal condensation and the answer is ventilation. If it wipes clear from outside, it is external condensation and the glass is performing well. If it will not wipe from either side, the mist is inside the unit and the sealed unit has failed. That one is for us.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Mist you can\'t wipe off?',
                'title' => 'Misting between the panes means the unit has failed.',
                'copy' => 'External mist clears itself and internal mist is ventilation, but fog trapped inside the glass means the sealed unit needs replacing. We do that without changing the frame.',
                'links' => [
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'New sealed units in existing frames'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Seals, hinges, locks and glass'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'draughty-windows-repair-or-replace' => [
            'title' => 'Draughty windows: repair or replace? An honest checklist',
            'publish_date' => '2026-08-24',
            'title_tag' => 'Draughty Windows: Repair or Replace? | Fenster Glazing',
            'meta_description' => 'Not every draughty window needs replacing. A straightforward checklist of what can be fixed, seals, hinges and locks, and the signs the window is done.',
            'products' => ['window-and-door-repairs', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A company that only sells new windows will tell you a draughty window needs replacing. We do repairs as well as replacements, so we can afford to be straight about it: a good share of the draughty windows we look at can be fixed for far less than the cost of a new window, and some cannot. Here is how to tell which yours is before anyone quotes you anything.',
                    ],
                ],
                [
                    'heading' => 'First, find where the draught actually gets in.',
                    'body' => [
                        'On a breezy day, hold the back of your hand around the edge of the window, slowly, all the way round. The back of your hand feels air movement better than your palm. A lit candle moved around the frame shows the same thing if the air is still.',
                        'Note whether the cold air comes from between the opening part and the frame, from between the frame and the wall, or seems to come off the glass itself. Those three point to three completely different problems.',
                    ],
                ],
                [
                    'heading' => 'Draughts that are usually repairable.',
                    'body' => [
                        'Air between the sash and the frame is the most common and the most fixable. The rubber gaskets that seal the window compress and harden over the years, and hinges drop so the window no longer pulls up square against its seals. New gaskets and a hinge adjustment restore the seal on most windows.',
                        'A window that needs slamming to lock, or that rattles in wind, usually needs its locking keeps adjusted or its hinges replaced rather than the whole window. Friction hinges are a standard replaceable part. If the handle no longer pulls the window in tight, the lock mechanism can be adjusted or swapped.',
                    ],
                ],
                [
                    'heading' => 'Draughts that point at the end of the road.',
                    'body' => [
                        'If the frame itself has warped, cracked or opened at its corner joints, sealing around it is a patch, not a fix. Single glazed windows and early double glazing with failed units are usually not worth sequential repairs: by the time the seals, hinges and glass have all been done, a new window would have cost little more and performed far better.',
                        'The clearest sign is repetition. If you fixed a draught last winter and it is back, the window is moving or the material is past holding a seal. Money spent repairing it again is money towards the window you will end up buying anyway.',
                    ],
                ],
                [
                    'heading' => 'The honest middle ground.',
                    'body' => [
                        'Plenty of houses have a mix: two or three windows genuinely done, the rest fixable. There is no rule that says a house does the whole lot at once. Replacing the worst windows and repairing the rest is a legitimate plan, and it spreads the cost across years instead of one bill.',
                        'When we survey, we will tell you which windows fall on which side of the line. Sometimes that survey ends with a repair sheet instead of a window order. That is fine with us. The replacement work comes back around when it is actually due.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Cold coming in?',
                'title' => 'Find out which side of the line your windows fall on.',
                'copy' => 'We repair seals, hinges, locks and glass, and we replace windows when repair has stopped making sense. Either way you get a straight answer about which is which.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Gaskets, hinges, locks and adjustments'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When the window is past fixing'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'misted-double-glazing-cloudy-windows' => [
            'title' => 'Misted double glazing: why windows go cloudy and how it\'s fixed',
            'publish_date' => '2026-08-31',
            'title_tag' => 'Misted Double Glazing: Causes and Fixes | Fenster Glazing',
            'meta_description' => 'Cloudy glazing you cannot wipe clean means the sealed unit has failed. Why it happens, why it will not recover and how replacement works without new frames.',
            'products' => ['double-glazing-replacement', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A double glazed window that has gone permanently cloudy, foggy or streaky between the panes has not just got dirty. It has failed. The mist sits inside the sealed unit where no cloth can reach it, and it will not clear on its own. The good news is that fixing it almost never means buying a new window.',
                    ],
                ],
                [
                    'heading' => 'What a sealed unit actually is.',
                    'body' => [
                        'The glass in a double glazed window is a factory-made sandwich: two panes bonded to a spacer bar around the edge, with the cavity between them sealed and dry. That dry gap is what does the insulating. Around the edge, the seal keeps moisture out, and a drying agent inside the spacer bar mops up any damp air that was trapped at manufacture.',
                        'The unit is a single component, separate from the frame that holds it. That distinction is the whole story when it comes to repair.',
                    ],
                ],
                [
                    'heading' => 'Why units fail.',
                    'body' => [
                        'The edge seal lives a hard life. The glass expands and contracts with every warm day and cold night, flexing the seal season after season. Eventually it lets damp air creep in faster than the drying agent can absorb it, and once that drying agent is saturated, moisture condenses on the inside faces of the glass where you cannot touch it.',
                        'That is why misting starts as faint fogging in a corner on cold mornings, then spreads and eventually leaves permanent streaks and mineral marks. South-facing windows and units above radiators tend to go first, because they cycle through bigger temperature swings.',
                    ],
                ],
                [
                    'heading' => 'Why it matters beyond the view.',
                    'body' => [
                        'A misted unit has lost its insulating gap to damp air, so it no longer performs the way it did new. The room loses more heat through that window, and the fog itself tends to arrive exactly when you would like the light: cold, bright mornings.',
                        'It does not fix itself, and drilling the glass or so-called demisting treatments only hide the symptom: the failed seal and saturated spacer are still there, and the fog comes back.',
                    ],
                ],
                [
                    'heading' => 'How replacement actually works.',
                    'body' => [
                        'If the frame is sound, we measure the failed unit, have a new sealed unit made to that size and specification, and swap it into the existing frame. The frame, sill, handles and opening parts all stay. It is a fraction of the disruption of a window replacement, and the new unit brings current glass performance into the old frame.',
                        'This is also the moment to upgrade the glass itself if you want to: the replacement unit can carry modern low-emissivity coatings, acoustic glass or obscure patterns, whatever the room needs. If the frame has gone as well, warped, cracked or draughty around the edges, we will say so, because a new unit in a failed frame wastes the unit.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Cloudy glass?',
                'title' => 'Replace the failed unit, keep the frame.',
                'copy' => 'If the mist is between the panes, the sealed unit needs replacing. We measure it, make it and fit it into your existing frame, and tell you honestly if the frame is past it.',
                'links' => [
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'New sealed units in existing frames'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'When seals or hinges have gone too'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'winter-ready-window-and-door-checklist' => [
            'title' => 'The 20-minute autumn check that saves winter callouts',
            'publish_date' => '2026-09-07',
            'title_tag' => 'Autumn Window & Door Check: 20-Minute Guide | Fenster Glazing',
            'meta_description' => 'A practical September walk-round of your windows and doors: seals, hinges, locks, drainage and the small fixes that stop midwinter failures and cold rooms.',
            'products' => ['window-and-door-repairs', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Every January we take calls about doors that will not lock and windows that whistle, and most of them were quietly announcing the problem back in September. Twenty minutes with the checklist below, while the weather is still kind, catches nearly all of it, and the fixes are smaller, cheaper and easier to book before the cold arrives.',
                    ],
                ],
                [
                    'heading' => 'Walk the seals.',
                    'body' => [
                        'Open each window and door and look at the rubber gasket that runs around it. You are looking for sections that have hardened, cracked, shrunk back at the corners or come loose from the groove. Press any loose lengths back in by hand.',
                        'Then close each one and check it pulls up snug against the seal. A sheet of paper closed in the door or window edge should grip when you pull it; if it slides out freely, that section is not sealing and will be a draught by November.',
                    ],
                ],
                [
                    'heading' => 'Work every handle and lock now, not in December.',
                    'body' => [
                        'Locks fail at the coldest, least convenient moment because that is when the mechanism is stiffest and the door has swollen or shifted. In September, every handle should lift smoothly and every key should turn without force.',
                        'A handle that needs lifting with effort, a key that needs jiggling or a door you have to pull or shoulder to lock is telling you the mechanism and the frame are no longer lined up. That is an adjustment now, or a jammed door in January.',
                    ],
                ],
                [
                    'heading' => 'Clear the drainage.',
                    'body' => [
                        'uPVC window and door frames have small drainage slots along the bottom edge that let rainwater out of the frame. Over summer they collect dust, moss and cobwebs. Blocked slots mean water sits inside the frame through winter, which is where mystery leaks and swollen sills come from.',
                        'Find the slots on the outside bottom edge and clear them with a thin plastic tool or a pipe cleaner. While you are down there, clear leaves out of door thresholds and patio door tracks.',
                    ],
                ],
                [
                    'heading' => 'Look for the early signs of bigger problems.',
                    'body' => [
                        'Fog between the panes of glass that you cannot wipe off means a sealed unit has failed. It will get worse through winter and the window will lose heat faster. Hairline cracks in glass grow in cold weather. A door that scrapes its frame in September will likely stop locking after a wet October.',
                        'None of these mend themselves, and all of them are easier to sort in autumn than midwinter.',
                    ],
                ],
                [
                    'heading' => 'What to do with what you find.',
                    'body' => [
                        'Loose gaskets, dirty tracks and blocked drainage are yours: ten minutes and no tools. Stiff locks, dropped hinges, failed units and doors that no longer meet their frames are ours: they need adjustment or parts, and they are quick jobs in autumn when the diary is not full of emergencies.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Found something?',
                'title' => 'Book the small fix before it becomes a winter callout.',
                'copy' => 'Stiff locks, dropped doors, failed units and perished seals are all quicker and cheaper to sort now. Tell us what you found on the walk-round and we will take it from there.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, hinges, seals and glass'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'For units that have misted up'],
                    ['label' => 'Contact the showroom', 'url' => home_url('/contact/'), 'meta' => 'Describe the fault, get a straight answer'],
                ],
            ],
        ],

        'how-window-replacement-actually-works' => [
            'title' => 'How window replacement actually works, from survey to fitting',
            'publish_date' => '2026-09-14',
            'title_tag' => 'How Window Replacement Works: Survey to Fitting | Fenster Glazing',
            'meta_description' => 'What actually happens when you replace windows: quote, technical survey, manufacture and fitting day, and what each stage decides. No mystery, no hard sell.',
            'products' => ['casement-windows', 'flush-casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Most people replace windows once or twice in a lifetime, so the process is a mystery right up until it happens. If you are weighing it up for this autumn, here is the whole thing from first price to fitted windows: what happens at each stage, and which decisions actually matter.',
                    ],
                ],
                [
                    'heading' => 'Stage one: a price you can look at without commitment.',
                    'body' => [
                        'The old-fashioned route starts with a salesperson on your sofa. Ours starts online: our quote tool prices windows and doors from your measurements and choices, so you can see realistic numbers before anyone visits. Rough measurements are fine at this stage. Pricing works from approximate sizes, and nothing is manufactured from them.',
                        'This is the stage for comparing styles and materials against your budget: casement against flush casement, uPVC against aluminium, colour against cost. Change your mind freely; it costs nothing here.',
                    ],
                ],
                [
                    'heading' => 'Stage two: the technical survey.',
                    'body' => [
                        'Once you want to go ahead, a surveyor measures every opening properly. This is the stage that makes made-to-measure mean something: brick-to-brick sizes, squareness, sill depths, reveal condition, trickle vent requirements and how each window opens and in which direction.',
                        'The survey is also where practical details get agreed rather than assumed: which rooms need obscure glass, where fire escape openings are required, how the existing sills and plaster will be treated. Everything the fitters do later is built from this document, so a careful survey is what a tidy fitting day looks like in advance.',
                    ],
                ],
                [
                    'heading' => 'Stage three: manufacture.',
                    'body' => [
                        'Your windows are then made to those measurements. Made-to-order is why replacement windows are not an off-the-shelf, next-day product, and why the survey has to be right. We confirm the expected timescale when the order is placed rather than quoting a number here, because it varies by product, colour and time of year, and we would rather tell you the true figure than a marketing one.',
                    ],
                ],
                [
                    'heading' => 'Stage four: fitting day.',
                    'body' => [
                        'Fitting runs room by room: the old window comes out, the opening is cleaned up, the new frame goes in, gets fixed, sealed, and the room is closed off again before the next one is opened. Your house is not left open to the weather. Each opening is out and refilled the same day.',
                        'Expect some dust and noise around each window for the hour or so it is being worked on, and clear a working space in front of each one before the team arrives. At the end, every window should open, close and lock smoothly, with the trims and sealant finished, and the old frames and glass leave with the fitters.',
                    ],
                ],
                [
                    'heading' => 'What decides whether the job goes well.',
                    'body' => [
                        'Almost everything that goes wrong in window replacement traces back to skipped steps early on: prices produced without honest sizes, surveys done in a hurry, details assumed rather than asked. The stages above are boring on purpose. Boring is what you want from the people replacing the holes in your walls.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Weighing it up?',
                'title' => 'Start with a real number, not a sales visit.',
                'copy' => 'Price your windows online with rough sizes and see where the budget lands. If the numbers work, the survey puts real measurements behind them before anything is made.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Realistic pricing in minutes'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare the main window styles'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk it through at your home'],
                ],
            ],
        ],

        'new-front-door-before-winter-composite-or-upvc' => [
            'title' => 'A new front door before winter: composite or uPVC, honestly',
            'publish_date' => '2026-09-21',
            'title_tag' => 'Composite or uPVC Front Door Before Winter? | Fenster Glazing',
            'meta_description' => 'Composite and uPVC front doors compared honestly: warmth, security, colour, feel and cost logic, and which one actually suits your house before winter.',
            'products' => ['composite-doors', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Autumn is front door season. The draught you ignored all summer becomes obvious the first cold evening, and if a new door is going to happen before winter, the decision usually comes down to two candidates: composite or uPVC. We sell and fit both, so this is the comparison we give customers face to face rather than the one that steers you at the expensive option.',
                    ],
                ],
                [
                    'heading' => 'What the two doors actually are.',
                    'body' => [
                        'A uPVC door is built like a uPVC window: a reinforced plastic frame with panels or glass filling it. A composite door is a solid slab construction: a dense core wrapped in a tough skin, usually finished to look like painted timber, hung in a frame.',
                        'The construction difference is what you feel. A composite door is noticeably heavier and closes with a more solid action; a uPVC door is lighter in the hand. Neither of those is automatically better, but people tend to have a strong preference within seconds of trying both, which is a good reason to visit a showroom before deciding.',
                    ],
                ],
                [
                    'heading' => 'Warmth and weather.',
                    'body' => [
                        'Both door types seal well when properly fitted and adjusted. The gaskets and multi-point locks do that work on either door. The solid core of a composite gives the slab itself more insulation than a hollow uPVC panel, which matters most on exposed doorways that take direct wind and rain.',
                        'Fitting quality matters more than material here. A well-fitted uPVC door beats a badly fitted composite every time, because most heat loss around doors happens at the edges, not through the middle.',
                    ],
                ],
                [
                    'heading' => 'Looks, colour and how they age.',
                    'body' => [
                        'This is where composite has pulled ahead in most streets: the timber-look skin, deeper colours and traditional styles suit older and character homes in a way flat uPVC panels struggle to match. Modern uPVC doors have improved, and in white or on a modern house the difference is much smaller.',
                        'Dark colours are worth a thought either way. They look sharp and they absorb more sun, which any door material has to be engineered for, another detail that gets checked at survey rather than left to luck.',
                    ],
                ],
                [
                    'heading' => 'Security and locks.',
                    'body' => [
                        'Security is decided mostly by the locking hardware and the fitting, and both door types carry the same style of multi-point locks. The composite\'s heavier slab shrugs off brute force a little better, but a quality uPVC door with a good cylinder is a secure door. Whichever you choose, the cylinder, the part the key goes in, is the component worth asking about by name.',
                    ],
                ],
                [
                    'heading' => 'The honest cost logic.',
                    'body' => [
                        'uPVC is the value option and composite is the premium one, and the honest way to choose is by the house and how long you are staying. A composite earns its extra cost on a home you will keep, a doorway the street sees, or an exposed position that will test the door. A uPVC door makes complete sense on a budget, a rental, a side or back entrance, or a modern house it visually suits.',
                        'Price both before deciding rather than guessing the gap. Our online quote tool prices doors the same way it prices windows, so you can see the real difference for your doorway rather than a brochure generality.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Door before winter?',
                'title' => 'Price both doors and see the real difference.',
                'copy' => 'The composite-versus-uPVC gap is different for every doorway. Price both online in a few minutes, then come and feel the difference at the showroom before you commit.',
                'links' => [
                    ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Styles, colours and glazing options'],
                    ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/'), 'meta' => 'The value option, honestly made'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Price both in minutes'],
                ],
            ],
        ],

        'trickle-vents-explained' => [
            'title' => 'Trickle vents explained: why new windows have them',
            'publish_date' => '2026-09-28',
            'title_tag' => 'Trickle Vents Explained: Why New Windows Have Them | Fenster Glazing',
            'meta_description' => 'Since 2022, most replacement windows in England need trickle vents. What they do, why the rule exists, whether you can refuse them and how to use them properly.',
            'products' => ['casement-windows', 'flush-casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'If you last bought windows more than a few years ago, the small vent strip along the top of a new frame is probably unfamiliar, and plenty of customers ask us to leave it off. Most of the time we cannot, and the reason is worth understanding before you order rather than on fitting day.',
                    ],
                ],
                [
                    'heading' => 'What a trickle vent is.',
                    'body' => [
                        'A trickle vent is a small closable slot built into the window frame that lets a steady trickle of fresh air through even when the window is shut. It has a flap or slider inside so you can close it down, and a cowl outside that keeps rain out.',
                        'It is not a draught, or at least it should not be. A working vent moves a small, controlled amount of air. If you can feel wind through a closed vent, the vent is open, and closing the flap is the fix.',
                    ],
                ],
                [
                    'heading' => 'Why the rules require them.',
                    'body' => [
                        'Since June 2022, the building regulations in England expect replacement windows to provide at least as much background ventilation as the windows they replace, and in most homes to add it where there was none. The logic is simple: modern windows seal far better than old ones, and a house that used to breathe through its leaky frames stops breathing when they are replaced.',
                        'Without background ventilation, the moisture from cooking, showers and sleeping has nowhere to go, and it shows up as condensation and mould. The vent is the regulation answer to a problem that better windows genuinely create.',
                    ],
                ],
                [
                    'heading' => 'Can you refuse them?',
                    'body' => [
                        'There are limited situations where vents are not required, and a survey is where that gets decided rather than a preference expressed at the quote stage. If another compliant ventilation route exists, the surveyor can take it into account.',
                        'What we will not do is leave required vents off to win an order. The installation gets certified for building regulations compliance, and the certificate matters when you sell the house.',
                    ],
                ],
                [
                    'heading' => 'How to live with them.',
                    'body' => [
                        'Leave bedroom vents open overnight; that is when a room generates the most moisture with the least ventilation. Close them when it is windy or cold enough to notice, and open them again after. They are there to be used, not taped over.',
                        'If a room with open vents still streams with condensation every morning, something else is going on, and it is worth a proper look rather than more gadgets.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Replacing windows?',
                'title' => 'Get the ventilation answer at survey, not after fitting.',
                'copy' => 'Vent requirements are decided by the room and the regulations, and our surveyor confirms them before anything is made. Price your windows first and ask us anything at survey.',
                'links' => [
                    ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'The most fitted window style'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare the main ranges'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'why-upvc-doors-stick-in-wet-weather' => [
            'title' => 'Why uPVC doors stick in wet weather',
            'publish_date' => '2026-10-05',
            'title_tag' => 'Why uPVC Doors Stick in Wet Weather | Fenster Glazing',
            'meta_description' => 'A door that locked fine all summer and drags in October is a seasonal pattern with a mechanical cause. What autumn does to doors, and the fix.',
            'products' => ['upvc-doors', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Every October the same call starts coming in: the back door locked fine all summer and now needs a shoulder against it. It feels like the door has warped, but a uPVC door rarely has. The season has changed, and the door is telling you about it.',
                    ],
                ],
                [
                    'heading' => 'Cold and damp move the door.',
                    'body' => [
                        'uPVC expands in heat and contracts in cold, and the steel reinforcement inside the frame moves at a different rate to the plastic around it. A door set up in July is a few millimetres different by late October, and a lock keep only needs a millimetre or two of misalignment to start grabbing.',
                        'Damp plays its part through the house rather than the door: autumn air swells timber floors and frames around the opening, and a settled frame moves the door with it. The door is the moving part, so the door gets the blame.',
                    ],
                ],
                [
                    'heading' => 'The five-minute checks before you call anyone.',
                    'body' => [
                        'First, try the door with the handle lifted firmly. Multi-point locks need a full, confident lift, and half a lift in cold weather is the most common non-fault we see. Second, look at the gap around the door edge from inside. It should be roughly even all the way round; a gap that tapers means the door has dropped on its hinges.',
                        'Third, clean and lightly lubricate the locking points and hinges with a silicone spray. October grime plus summer dust is a genuinely common cause of a stiff lock.',
                    ],
                ],
                [
                    'heading' => 'The adjustment that fixes most of them.',
                    'body' => [
                        'uPVC door hinges carry adjusters that move the door up, down, in, out and sideways. A dropped or drifted door can usually be brought back into line in one visit without any parts, and the keeps on the frame side can be fine-tuned so the lock throws smoothly rather than fighting the frame.',
                        'If a door needs a seasonal adjustment every single year, or the lock gearbox has started grinding, it is worth asking whether the hardware is on its way out. A worn gearbox is replaceable; waiting for it to fail usually happens at the least convenient moment of the year.',
                    ],
                ],
                [
                    'heading' => 'When the door itself is the problem.',
                    'body' => [
                        'An old door with failed seals, a cracked panel or a frame that has genuinely distorted is past adjustment, and there is a point where paying for repeated callouts stops making sense. We fit uPVC and composite doors and we repair them, so you will get a straight answer about which side of that line your door is on.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Door dragging?',
                'title' => 'A seasonal adjustment beats a winter of slamming.',
                'copy' => 'If the handle lift and a clean have not fixed it, the door needs its hinges and keeps adjusted. Booked in autumn, it is a quick job rather than a January emergency.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Hinges, locks, keeps and seals'],
                    ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/'), 'meta' => 'When the door is past adjusting'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'how-integral-blinds-work' => [
            'title' => 'Integral blinds: how blinds inside the glass work',
            'publish_date' => '2026-10-12',
            'title_tag' => 'How Integral Blinds Inside Glass Work | Fenster Glazing',
            'meta_description' => 'Integral blinds are sealed between the panes of a double glazed unit, so they never need dusting. How they operate and where they make sense.',
            'products' => ['integral-blinds', 'patio-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'An integral blind is a venetian blind sealed inside the double glazed unit itself, in the dry gap between the two panes. Nothing hangs in the room, nothing collects dust, and there is no cord for a child or a dog to find. They answer a specific set of problems well, and this is how they actually work.',
                    ],
                ],
                [
                    'heading' => 'The blind lives in the sealed unit.',
                    'body' => [
                        'The slats sit inside the cavity of the glass unit, which is sealed at manufacture the same way any double glazed unit is. Because the cavity is sealed and dry, the blind never gets dirty. Whatever the kitchen throws at the glass stays on the outside faces, which wipe clean like any window.',
                        'The unit fits standard frames, which is why integral blinds are most often specified in doors: French doors, patio sliders and the glazed panels beside a front door, where a normal blind would swing, catch and tangle every time the door moved.',
                    ],
                ],
                [
                    'heading' => 'How you operate them.',
                    'body' => [
                        'Control is either magnetic or electric. The magnetic version uses a slider on the face of the glass that couples through the pane to raise, lower and tilt the slats. The electric version does the same by motor, from a switch or remote, which suits glazing that is out of reach.',
                        'Both are chosen at the point of order along with slat colour and glass specification. This is a decision that has to be made before the unit is manufactured, because the blind cannot be added to an existing unit later.',
                    ],
                ],
                [
                    'heading' => 'Where they earn their money.',
                    'body' => [
                        'Doors are the honest answer. A blind inside the glass cannot swing or rattle when the door opens, which is the daily annoyance that kills ordinary blinds on French and patio doors. They also suit anywhere hygiene or dust matters, and rooms where a clean, bare window line is the look you are after.',
                        'For an ordinary bedroom window, curtains or a normal blind remain cheaper and give a wider choice of fabrics and blackout levels. We will say so when that is the better answer for the room.',
                    ],
                ],
                [
                    'heading' => 'What to check before ordering.',
                    'body' => [
                        'Decide the control type per door or window rather than per house, because reachability differs room to room. Pick the slat colour against the frame colour, not in isolation. And if you are replacing glazing anyway, price the integral blind at the same time; it is a manufacture-stage option, and the door only needs surveying once.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'No more dusting slats?',
                'title' => 'Specify the blinds with the glazing, not after it.',
                'copy' => 'Integral blinds are built into the unit at manufacture, so the right time to decide is while the doors or windows are being priced. We can talk through magnetic against electric at survey.',
                'links' => [
                    ['label' => 'Integral blinds', 'url' => home_url('/integral-blinds/'), 'meta' => 'Controls, colours and glass options'],
                    ['label' => 'Patio doors', 'url' => home_url('/patio-doors/'), 'meta' => 'Where integral blinds work hardest'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'dark-evenings-front-door-security' => [
            'title' => 'Dark evenings and front door security: what actually matters',
            'publish_date' => '2026-10-19',
            'title_tag' => 'Front Door Security For Dark Evenings | Fenster Glazing',
            'meta_description' => 'When the clocks go back, houses sit dark by teatime. The parts of a front door that actually resist a break-in, and the habits that matter more.',
            'products' => ['composite-doors', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The clocks go back this month, and from then until spring most houses sit in darkness for hours before anyone gets home. That is the season opportunist burglary prefers, and the front door is where most attempts start. Here is what actually matters about a door, without the scare copy.',
                    ],
                ],
                [
                    'heading' => 'The cylinder is the part worth naming.',
                    'body' => [
                        'On most uPVC and composite doors, the weak point historically was never the door. It was the euro cylinder, the barrel the key goes into, which on older doors can be snapped with hand tools in seconds. It is the best-known attack on domestic doors, and the industry answered it years ago.',
                        'Modern anti-snap cylinders are designed to break in a controlled way that leaves the lock working and the door shut. If your door is more than roughly a decade old and the cylinder has never been changed, upgrading it is the single most effective security improvement you can buy, and it does not need a new door.',
                    ],
                ],
                [
                    'heading' => 'What the rest of the door contributes.',
                    'body' => [
                        'A multi-point lock throws hooks and bolts into the frame at several heights, which is what makes kicking a modern door largely pointless; the load spreads along the whole frame rather than one latch. The keeps those hooks land in need to be solid and correctly adjusted, which is part of what a door survey checks.',
                        'The slab itself matters most on composite doors, where a solid core resists blunt force better than a hollow panel. Glazing beside or inside the door should be secured from the inside so beading cannot simply be levered out.',
                    ],
                ],
                [
                    'heading' => 'The habits that out-perform the hardware.',
                    'body' => [
                        'Lift the handle and turn the key every time you close the door. An unlifted multi-point lock is just a latch, and plenty of insurance claims fail on exactly that detail. A light on a timer or a sensor light over the door removes the darkness that makes a doorstep comfortable to work at.',
                        'And the unglamorous one: do not leave the key in the inside of the cylinder overnight if the door has glazing nearby or a letterbox within reach. Fishing keys through letterboxes is old, boring and still works on the right layout.',
                    ],
                ],
                [
                    'heading' => 'If the door itself is the weak point.',
                    'body' => [
                        'A door that never locks without a fight, flexes visibly when pushed, or shows gaps at the frame is not going to be improved by a better cylinder. We repair locks, keeps and hinges where repair is the honest answer, and we fit composite and uPVC doors with modern locking when it is not.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Before the dark months',
                'title' => 'Sort the lock while it is a choice, not an emergency.',
                'copy' => 'A cylinder upgrade or a lock adjustment is a small autumn job. A failed lock in December is a cold evening on the doorstep. Tell us what the door is doing and we will take it from there.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, cylinders, keeps and hinges'],
                    ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Solid doors with modern locking'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'stop-morning-condensation-inside-windows' => [
            'title' => 'Condensation inside your windows every morning? Start here',
            'publish_date' => '2026-10-26',
            'title_tag' => 'Stop Morning Condensation Inside Windows | Fenster Glazing',
            'meta_description' => 'Wet windows every morning from October is moisture meeting cold glass. The daily routine that stops most of it, and the two cases that need more.',
            'products' => ['windows', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'From late October the morning wipe-down starts: bedroom windows streaming, sills damp, and the worry that something is wrong with the glazing. Condensation on the room side of the glass is not a window fault. It is the house telling you its moisture has nowhere to go, and most of it responds to routine rather than spending.',
                    ],
                ],
                [
                    'heading' => 'Where the water actually comes from.',
                    'body' => [
                        'An ordinary household puts litres of water into its own air every day: cooking, kettles, showers, drying clothes indoors, and simply breathing overnight. Warm air holds that moisture invisibly until it touches a cold surface, and the coldest smooth surface in most rooms is the glass. Overnight, a closed bedroom with two sleeping people is a moisture factory with the ventilation switched off, which is why mornings are the worst.',
                    ],
                ],
                [
                    'heading' => 'The routine that fixes most of it.',
                    'body' => [
                        'Open trickle vents in bedrooms and keep them open overnight. Crack the bathroom window or run the extractor during and after showers, with the bathroom door shut so the moisture leaves the house instead of touring it. Put lids on pans and run the kitchen extractor when cooking.',
                        'Dry clothes outdoors, in a vented tumble dryer, or in one closed room with the window cracked, never on radiators through the whole house. And air the bedrooms for ten minutes in the morning; a short, sharp air change costs almost no heat and clears the overnight moisture load.',
                    ],
                ],
                [
                    'heading' => 'Wipe it, do not leave it.',
                    'body' => [
                        'While you improve the routine, keep wiping the glass and sills dry in the morning. Water left standing every day soaks silicone, stains sills and feeds the black mould spots along the gasket line. A window vac or a folded towel takes a minute per room.',
                    ],
                ],
                [
                    'heading' => 'The two cases the routine will not fix.',
                    'body' => [
                        'If the misting is between the panes where you cannot wipe it, the sealed unit has failed and needs replacing; no amount of ventilation touches it. And if one room streams every morning despite open vents and honest ventilation habits, the glazing in that room may simply be old, cold, single glazed or long past its insulating best, and the room is fighting physics.',
                        'Both of those are our side of the line rather than yours. A failed unit is replaceable without changing the frame, and a persistently cold, wet window is exactly the case replacement glazing exists for.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Still wet every morning?',
                'title' => 'Find out if it is the room or the glazing.',
                'copy' => 'If the routine has not fixed it, the glass is telling you something. Misting between the panes is a failed unit; a room that streams against cold single glazing is a replacement case. We will tell you which, straight.',
                'links' => [
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Failed units, replaced in the frame'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When the whole window is the problem'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Seals, vents and hardware'],
                ],
            ],
        ],

        'which-rooms-lose-the-most-heat' => [
            'title' => 'Which rooms lose the most heat, and which windows to replace first',
            'publish_date' => '2026-11-02',
            'title_tag' => 'Which Windows To Replace First For Heat Loss | Fenster Glazing',
            'meta_description' => 'Few households replace every window at once. How to rank the rooms that leak the most heat, so a phased replacement spends the first pound well.',
            'products' => ['windows', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Most houses do not replace every window in one go, and nothing about phasing the work is wrong. What matters is the order. Done well, the first phase pays for itself in comfort immediately; done by guesswork, the money lands on the windows that were annoying rather than the ones leaking the heat.',
                    ],
                ],
                [
                    'heading' => 'Read the house before ranking the windows.',
                    'body' => [
                        'Heat loss through a window depends on the glass, the frame condition and how much time the room spends heated. A draughty single glazed window in a heated living room is bleeding money every evening; the same window in a spare room heated twice a year barely matters.',
                        'North and east facing rooms run coldest, and big glazed areas move more heat than small ones simply by size. A large north-facing living room window with early double glazing from the nineties is usually a better first candidate than a small, newer window that happens to rattle.',
                    ],
                ],
                [
                    'heading' => 'The signs a window is a heavy loser.',
                    'body' => [
                        'Cold radiating off the glass that you can feel from an armchair away. Heavy morning condensation in a room with reasonable ventilation habits. Curtains that move on a windy night with the window shut. Misting between the panes, which means the insulating cavity has failed even if the room feels fine.',
                        'Run a winter evening walk round the house with the backs of your hands near frames and glass. Ten minutes tells you more than any brochure, and the ranking usually becomes obvious.',
                    ],
                ],
                [
                    'heading' => 'A sensible phasing order.',
                    'body' => [
                        'First: the heated rooms you live in every evening, starting with the biggest and coldest glass. Second: bedrooms, where comfort and condensation both improve overnight habits. Third: kitchens and bathrooms, which generate moisture but also generate their own heat. Last: hallways, landings and rooms you rarely heat.',
                        'If any window has a failed sealed unit, price replacing just the unit in the same visit regardless of phase; it is a smaller job than a window and stops the worst leak immediately.',
                    ],
                ],
                [
                    'heading' => 'Phase it without paying twice.',
                    'body' => [
                        'Choose the style, colour and specification for the whole house at the start, even if you only order phase one. Matching windows fitted two years apart looks intentional; near-matching windows chosen twice looks like what it is. Our quote tool prices per window, so you can build the full house once and order it in stages.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Phasing the work?',
                'title' => 'Price the whole house, order the worst rooms first.',
                'copy' => 'Build every window in the quote tool once, see the total honestly, then phase the order in the sequence that stops the biggest heat loss first. The survey confirms the details before anything is made.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Priced per window, phased how you like'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare styles for the whole house'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Failed units fixed ahead of phase one'],
                ],
            ],
        ],

        'sash-windows-in-winter' => [
            'title' => 'Sash windows in winter: draught-proofing heritage homes honestly',
            'publish_date' => '2026-11-09',
            'title_tag' => 'Sash Windows In Winter: Honest Draught-Proofing | Fenster Glazing',
            'meta_description' => 'Original timber sashes are beautiful and cold. What draught-proofing genuinely achieves, and how modern uPVC sash windows keep the look without the winter.',
            'products' => ['sliding-sash-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Nobody who owns original sash windows needs telling that November is when they earn their reputation. The rattle in wind, the cold sheet of air off the glass, the draught you can find with a wet finger. The affection is real and so is the heat loss, so here is the honest version of the choices.',
                    ],
                ],
                [
                    'heading' => 'Why sashes are cold by design.',
                    'body' => [
                        'A sliding sash works because its panels move past each other, and anything that slides needs clearance. Every clearance is a draught path: between the sashes, along the staff beads, through the pulley holes, under the meeting rail. Add single glazing, which is simply a thin sheet of cold, and a well-loved Victorian window can move more air than a trickle vent ever will.',
                    ],
                ],
                [
                    'heading' => 'What draught-proofing genuinely does.',
                    'body' => [
                        'A good draught-proofing service routs brush seals into the beads and rails, re-cords and eases the sashes, and closes most of the moving-air paths. On a sound timber window it makes a real difference to draughts and rattle, and it preserves original fabric, which matters in conservation settings and to plenty of owners besides.',
                        'What it cannot change is the glass. Single glazing stays single glazed, the cold radiating surface stays cold, and the room still needs the curtains drawn at dusk. Draught-proofing is the right call when the frames are good, the budget is focused, or the building is listed. It is half the answer, honestly sold.',
                    ],
                ],
                [
                    'heading' => 'The modern sash option.',
                    'body' => [
                        'A modern uPVC sliding sash keeps the proportions, the run-through horns, the deep bottom rail and the mechanical action of a traditional sash, with double glazing and proper seals engineered in rather than retrofitted. The ones we fit are A rated for energy, and they still slide, tilt and lock the way a sash should.',
                        'On the right house the difference from the street is close to nil, and the difference from the armchair is the whole point: no rattle, no moving air, and glass that is not the coldest thing in the room.',
                    ],
                ],
                [
                    'heading' => 'Choosing between them.',
                    'body' => [
                        'If the building is listed, the conversation starts with the conservation officer, not a catalogue. If the frames are rotten, draught-proofing is money into failing timber. If the frames are sound and originality matters most, draught-proof and enjoy them. And if what you want is the look with a warm room behind it, the modern sash is the honest recommendation, and we would rather you chose it knowing exactly what the traditional route can and cannot do.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Cold heritage windows?',
                'title' => 'Keep the look. Lose the winter.',
                'copy' => 'We fit uPVC sliding sash windows that hold their own on period streets, and we will tell you straight if draught-proofing your originals is the better answer for your house.',
                'links' => [
                    ['label' => 'Sliding sash windows', 'url' => home_url('/sliding-sash-windows/'), 'meta' => 'Ranges, glazing bars and furniture'],
                    ['label' => 'Heritage windows', 'url' => home_url('/heritage-windows/'), 'meta' => 'The wider heritage range'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'storm-season-windows-and-doors' => [
            'title' => 'Storm season: how windows and doors cope with wind and rain',
            'publish_date' => '2026-11-16',
            'title_tag' => 'How Windows And Doors Cope With Storms | Fenster Glazing',
            'meta_description' => 'Named storms arrive from November. How modern windows and doors handle wind and driven rain, what leaks really mean and what to check after a storm.',
            'products' => ['aluminium-windows', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The named storms start arriving about now, and after each one comes a run of calls that begin with a puddle on a sill. Modern glazing is engineered for British weather with room to spare, so when water does get in, it is a signal worth reading properly rather than a sign the window has failed at its job.',
                    ],
                ],
                [
                    'heading' => 'What windows are built to take.',
                    'body' => [
                        'Windows and doors sold in the UK are tested for air tightness, water tightness and wind resistance, with driven rain thrown at them by machine long before weather does it for real. The engineering assumption is exactly the storm you are watching through the glass: sustained wind with rain arriving horizontally.',
                        'Frames also drain by design. The slots along the outside bottom edge let any water that enters the frame chamber run back out. Water appearing there during a storm and draining away afterwards is the system working, not leaking.',
                    ],
                ],
                [
                    'heading' => 'What a genuine leak usually means.',
                    'body' => [
                        'Water on the inside sill most often comes from one of three places, and only one is the window. Blocked drainage slots hold water in the frame until it finds the room. Failed silicone or perished gaskets let driven rain past the seal line. And a good share of storm leaks are not the window at all: they are the wall, the sill above, or a gap in the render, with the window frame simply being where the water becomes visible.',
                        'The pattern is the clue. Water only in extreme driven rain points at seals or drainage. Water in ordinary rain, or damp that lingers days after, points at the building rather than the glazing.',
                    ],
                ],
                [
                    'heading' => 'The after-storm check.',
                    'body' => [
                        'Once the weather passes, walk the outside. Clear leaves and grit from door thresholds and drainage slots. Look for silicone that has cracked or peeled at the frame edges, gaskets that have popped out of their groove, and any movement in trims. Open and close everything; a door or window that suddenly catches after a big blow is worth attention while it is a small fault.',
                    ],
                ],
                [
                    'heading' => 'If a storm finds the same window every time.',
                    'body' => [
                        'A window that leaks in every serious blow has a specific fault, and it is findable: drainage, seals, sealant line or the surrounding wall. We repair seals and hardware where that is the answer, and where a window is genuinely past it, modern aluminium and uPVC frames handle exposed positions with engineering the old window never had.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'After the storm',
                'title' => 'Find the leak while the evidence is fresh.',
                'copy' => 'Tell us which window, which weather and where the water showed up. The pattern usually names the fault, and most storm leaks are a repair rather than a replacement.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Seals, drainage and hardware'],
                    ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/'), 'meta' => 'Strength for exposed positions'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Describe it, get a straight answer'],
                ],
            ],
        ],

        'is-secondary-glazing-worth-it' => [
            'title' => 'Is secondary glazing worth it? Where it beats replacement',
            'publish_date' => '2026-11-23',
            'title_tag' => 'Is Secondary Glazing Worth It? | Fenster Glazing',
            'meta_description' => 'Secondary glazing adds an internal pane behind existing windows. Where it beats replacement, for noise and listed buildings, and where it does not.',
            'products' => ['secondary-glazing'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Secondary glazing is a second, independent pane fitted to the room side of your existing window. The original window stays exactly as it is. It is the least glamorous product we fit and one of the most misunderstood, because in its right situations it beats full replacement, and in the wrong ones it is a compromise nobody needed to make.',
                    ],
                ],
                [
                    'heading' => 'Noise is where it wins outright.',
                    'body' => [
                        'For traffic and neighbour noise, secondary glazing is genuinely the strongest tool in domestic glazing, and the reason is the air gap. Sound insulation improves with the distance between panes, and a secondary pane sits far deeper from the original glass than the cavity inside any sealed unit can be. That large gap, plus glass of a different thickness to the original, takes the edge off exactly the frequencies that make roads tiring.',
                        'If your problem is a busy road rather than a cold room, secondary glazing behind sound existing windows will usually out-perform replacing them.',
                    ],
                ],
                [
                    'heading' => 'Listed buildings and windows you cannot touch.',
                    'body' => [
                        'In a listed building, replacing the windows is often simply not on the table, and even in conservation areas it can be a negotiation. Secondary glazing leaves the historic window untouched and is fitted discreetly on the room side, which is why conservation officers generally view it kindly. It is frequently the only route to warmer, quieter rooms behind protected glass.',
                    ],
                ],
                [
                    'heading' => 'What it does for warmth, honestly.',
                    'body' => [
                        'A secondary pane adds a still air layer in front of the old glass, which cuts draughts and takes the raw chill off single glazing. It is a real improvement, and it is not the equal of a modern A rated sealed unit with coated glass. If the existing windows are also rotten, draughty at the frame or failing, secondary glazing is a lid on a problem rather than a fix.',
                    ],
                ],
                [
                    'heading' => 'The practical trade-offs.',
                    'body' => [
                        'You live with two windows: opening the original means sliding or hinging the secondary pane first, and both need cleaning. Modern slimline units are far tidier than the clunky panels people remember, but the trade-off is real and worth going in with open eyes.',
                        'The decision rule we give customers: noise problem or protected building, secondary glazing first. Failing windows in a house you are free to change, replacement first. Sound windows, tight budget, cold rooms: secondary glazing is a legitimate middle answer, honestly costed.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Noise or heritage?',
                'title' => 'Match the fix to the actual problem.',
                'copy' => 'Tell us the room, the noise and whether the building is protected, and we will tell you straight whether secondary glazing or replacement serves you better.',
                'links' => [
                    ['label' => 'Secondary glazing', 'url' => home_url('/secondary-glazing/'), 'meta' => 'Slimline internal panes'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When you are free to change them'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk it through at your home'],
                ],
            ],
        ],

        'frozen-door-locks-what-to-do' => [
            'title' => 'Frozen and stiff door locks: what to do, what never to do',
            'publish_date' => '2026-11-30',
            'title_tag' => 'Frozen And Stiff Door Locks: What To Do | Fenster Glazing',
            'meta_description' => 'A lock that will not turn on a frosty morning is usually recoverable. The safe ways to free it, the tricks that cause damage, and prevention that works.',
            'products' => ['window-and-door-repairs', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The first hard frosts arrive about now, and with them the morning ritual of a key that goes in and will not turn. A frozen or cold-stiffened lock is nearly always recoverable in a few minutes. Most of the permanent damage we see was done not by the cold but by the rescue attempt.',
                    ],
                ],
                [
                    'heading' => 'Why locks seize in the cold.',
                    'body' => [
                        'Sometimes it is genuine ice: moisture in the cylinder or around the latch freezing overnight. Just as often it is mechanics rather than ice. Cold thickens old grease inside the mechanism, the door and frame contract by different amounts, and a lock that was already borderline in November becomes a fight in December. If the key turns but the handle will not lift, the problem is usually the alignment of the door, not the cylinder.',
                    ],
                ],
                [
                    'heading' => 'The safe ways to free it.',
                    'body' => [
                        'Warm the key gently in your hand or with warm water, dry it, and work it in and out without force. Repeat two or three times; a warm key melts cylinder ice from the inside. A squirt of a silicone or PTFE lubricant into the keyway helps both ice and stiff grease, and it is worth keeping a can indoors rather than in the car you are locked out of.',
                        'If the handle lifts but stiffly, try again while pulling or pushing the door towards its hinges; you are taking the pressure off misaligned keeps, and if that works it has also told you the real fault.',
                    ],
                ],
                [
                    'heading' => 'What never to do.',
                    'body' => [
                        'Do not force the key. A snapped key in a frozen cylinder turns a two-minute problem into a locksmith visit. Do not pour boiling water over the lock or door; it finds its way inside, refreezes deeper, and can shock uPVC and glass. Do not use a lighter on the key or the cylinder face, which damages seals and finishes for the sake of a trick that barely works. And WD-40 is a water displacer rather than a lubricant; it will free things today and gum them worse next month.',
                    ],
                ],
                [
                    'heading' => 'Stop it happening again.',
                    'body' => [
                        'A lock that froze once will freeze again, because the moisture got in somehow: a worn gasket, a leaking letterbox surround, or a cylinder proud of its handle plate. A service visit that cleans and lubricates the mechanism, adjusts the keeps and replaces tired seals sorts the cause. If the gearbox has started grinding or the handle needs real effort in any weather, the mechanism is telling you it is on its way out, and replacing it in November beats replacing it as an emergency in January.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Lock fighting you?',
                'title' => 'A stiff lock in November fails in January.',
                'copy' => 'Cleaning, adjustment and worn-part replacement are quick jobs booked ahead of the freeze. Tell us what the lock is doing and we will sort it before it strands you on the doorstep.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, gearboxes, keeps and seals'],
                    ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/'), 'meta' => 'When the door is past helping'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Phone lines open 24/7'],
                ],
            ],
        ],

        'plan-new-windows-in-december' => [
            'title' => 'Why December is the month to plan windows, not fit them',
            'publish_date' => '2026-12-07',
            'title_tag' => 'Plan New Windows In December | Fenster Glazing',
            'meta_description' => 'December is a poor month for fitting windows and a quietly ideal one for choosing them. Plan now and start January at the front of the queue.',
            'products' => ['windows', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Nobody particularly wants their windows out of the wall the week before Christmas, and we understand why. But the quietest month in glazing is a genuinely good one for the deciding part of the job, and the people who use it that way start January at the front of the queue instead of the back.',
                    ],
                ],
                [
                    'heading' => 'Winter is when the evidence is on display.',
                    'body' => [
                        'You choose windows best in the season that exposes them. Right now, your house is showing you exactly which rooms run cold, which glass streams with condensation, which frames whistle in wind. In June, every window in the house feels fine. A December walk-round with the backs of your hands near the glass produces a better replacement plan than any summer guesswork.',
                    ],
                ],
                [
                    'heading' => 'The decisions that take longer than people expect.',
                    'body' => [
                        'Style is quick. The details are what eat time pleasantly rather than under pressure: colour against your brick, flush or standard casements, glazing bars or clean glass, obscure glass for which rooms, handles, and how the budget phases across the house. Made-to-measure windows are manufactured to the survey, so every one of those decisions has to be settled before anything gets built.',
                        'Doing that thinking over the quiet weeks, with the quote tool and a couple of showroom visits, costs nothing and rushes nobody.',
                    ],
                ],
                [
                    'heading' => 'How the timing actually works.',
                    'body' => [
                        'Price the house online now, book a survey, and the specification is settled at your pace. Manufacture then runs while the calendar does its January thing, and fitting lands in the new year with everything decided and nothing hurried. The alternative is joining the January rush with everyone else who spent Christmas in a cold living room and wants it fixed by February.',
                    ],
                ],
                [
                    'heading' => 'And if something fails over Christmas.',
                    'body' => [
                        'Planning is December\'s job, but faults do not check the calendar. A failed lock, a cracked pane or a door that will not secure is a repair call whenever it happens, and our phone lines are open around the clock. Do not live with an unlockable door through the holidays because the diary looked festive.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Cold rooms on show',
                'title' => 'Decide in December, fit in the new year.',
                'copy' => 'Build the house in the quote tool while winter shows you the evidence, then get surveyed and specified ahead of the January rush. The fitting happens when everything is already right.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare the main styles'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk it through at your home'],
                ],
            ],
        ],

        'christmas-window-door-security-check' => [
            'title' => 'Home for the holidays: a ten-minute security check',
            'publish_date' => '2026-12-14',
            'title_tag' => 'Christmas Window And Door Security Check | Fenster Glazing',
            'meta_description' => 'Presents on show, dark afternoons and houses left empty for visits. A ten-minute walk-round that closes the gaps burglars actually use in December.',
            'products' => ['composite-doors', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'December stacks the deck oddly: houses fill up with new, boxed, resellable things, the afternoons are dark by four, and then everyone leaves for two days to eat elsewhere. None of that needs alarm-company fear copy. It needs ten minutes and a walk round the house.',
                    ],
                ],
                [
                    'heading' => 'Walk the outside like a stranger.',
                    'body' => [
                        'Stand at the pavement after dark and look at your own house. Can you see the tree with the presents under it from the street? A lamp on a timer in that room, curtains drawn, solves in one evening what no lock can. Check what is lying around outside too; ladders, bins by fences and unlocked side gates do more for burglars than any tool they carry.',
                    ],
                ],
                [
                    'heading' => 'Test every lock, not just the front door.',
                    'body' => [
                        'Work round every window and external door and actually lock each one with its key. Window keys wander over a year, and a window lock without its key is decoration. Lift the handle fully on every uPVC and composite door so the multi-point lock throws all its bolts; unlifted, the door is held by a latch you could card open.',
                        'Pay attention to the doors nobody uses: the garage side door, the old back door behind the utility. The least-used door in the house is the most-tried one from outside, and the one whose stiff lock has been ignored longest.',
                    ],
                ],
                [
                    'heading' => 'The faults to fix before you travel.',
                    'body' => [
                        'A lock that needs a wiggle, a door that only locks when pulled hard, a handle that lifts loosely without resistance: each of those is a mechanism partway through failing, and cold weather finishes what autumn started. Locking up for a two-day absence is precisely the wrong moment to discover the back door will not secure.',
                        'Those are quick repair visits in mid-December and miserable emergencies on the 27th.',
                    ],
                ],
                [
                    'heading' => 'While you are away.',
                    'body' => [
                        'Lights on timers in a living room and a bedroom, a neighbour bringing the bin in, and no countdown of your absence posted publicly before you go. Boring advice, still the advice that works. And if the doorstep drop of parcels is part of your December, redirect deliveries for the days away rather than letting boxes announce the empty house.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Before you travel',
                'title' => 'Fix the lock that almost works.',
                'copy' => 'Almost-locking is the fault that ruins Christmas. A stiff mechanism, a dropped door or a missing window key is a quick pre-holiday visit, and the phone lines stay open right through.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, keeps and adjustments'],
                    ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Solid doors, modern locking'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Phone lines open 24/7'],
                ],
            ],
        ],

        'wet-window-sills-every-morning' => [
            'title' => 'Wet window sills every morning: condensation, leak or failed unit?',
            'publish_date' => '2026-12-21',
            'title_tag' => 'Wet Window Sills: Condensation, Leak Or Failed Unit? | Fenster Glazing',
            'meta_description' => 'A wet sill has three possible causes and each has a different fix. How to tell condensation from a leak from a failed sealed unit, in two minutes.',
            'products' => ['window-and-door-repairs', 'double-glazing-replacement'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Deep winter is wet sill season, and the water pooling on the inside sill each morning has exactly three possible sources. They look similar by the time the water has landed, they cost very different amounts to fix, and two minutes of looking tells them apart.',
                    ],
                ],
                [
                    'heading' => 'Cause one: condensation running down the glass.',
                    'body' => [
                        'By far the most common. The glass mists overnight, the mist gathers into drops, the drops run down and pool where glass meets frame. The tell is the pattern: the glass itself is wet or was wet, the water sits in a line along the bottom edge of the glass, and it is worst on cold, still mornings after the room has been shut up all night.',
                        'This one is a ventilation and habits problem, not a window fault. The fixes are the unglamorous ones: trickle vents open in bedrooms, extractors used properly, washing dried somewhere sensible and a morning wipe-down while the routine improves.',
                    ],
                ],
                [
                    'heading' => 'Cause two: the sealed unit has failed.',
                    'body' => [
                        'If the mist sits between the two panes where no cloth can reach it, the unit itself has failed, and some failed units weep moisture at their bottom edge as temperatures swing. The tell is fog or streaking you cannot wipe from either side, often with a wet line appearing along the glazing bead.',
                        'The fix is a new sealed unit in the existing frame. The frame, handles and opening parts all stay; it is a measured swap rather than a new window.',
                    ],
                ],
                [
                    'heading' => 'Cause three: a genuine leak.',
                    'body' => [
                        'Rarest, and the tell is timing. Leak water arrives during or just after rain rather than on clear cold mornings, it often stains or tracks down the reveal beside the window rather than the glass, and it can appear at the top of the frame as easily as the bottom. Blocked frame drainage, failed silicone or a fault in the wall above are the usual suspects.',
                        'A leak does not care about your ventilation habits and will not improve with them, which is itself a useful diagnostic: if the wet mornings continue through a dry week, it was never a leak.',
                    ],
                ],
                [
                    'heading' => 'The two-minute test.',
                    'body' => [
                        'Wipe everything bone dry one evening: glass, frame, sill. Next morning, look before you touch. Wet glass above a wet sill is condensation. Dry glass with fog trapped inside it is a failed unit. Dry glass, dry frame and a wet patch after overnight rain is a leak. From there you know whose job it is: yours to ventilate, ours to reglaze, or ours to find where the water gets in.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Done the test?',
                'title' => 'Two of the three causes are ours to fix.',
                'copy' => 'Failed units get replaced in the existing frame, and leaks get traced to drainage, seals or sealant. Tell us what the morning-after test showed and we will pick it up from there.',
                'links' => [
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'New units in existing frames'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Drainage, seals and silicone'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Describe it, get a straight answer'],
                ],
            ],
        ],

        'new-year-warmer-house-where-to-start' => [
            'title' => 'New year, warmer house: where to actually start',
            'publish_date' => '2026-12-28',
            'title_tag' => 'A Warmer House In 2027: Where To Start | Fenster Glazing',
            'meta_description' => 'If 2027 is the year you fix the cold house, the order of work matters. A practical sequence for draughts, glazing and doors that spends money where the cold is.',
            'products' => ['windows', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Somewhere between Christmas and New Year, sitting in the one warm room of a cold house, the resolution forms: this year it gets sorted. Good. The difference between that resolution surviving January and dying with the gym membership is a plan with an order to it, so here is the order.',
                    ],
                ],
                [
                    'heading' => 'January: gather evidence while it is free.',
                    'body' => [
                        'The house is currently demonstrating its faults daily, so write them down while it does. Which rooms never warm up. Which windows stream every morning. Where you feel moving air with the back of your hand. Which doors whistle or need a shoulder. A week of casual notes in the coldest month beats any assessment you could commission in May.',
                    ],
                ],
                [
                    'heading' => 'First money: stop the moving air.',
                    'body' => [
                        'Draughts make rooms feel several degrees colder than the thermostat claims, and they are the cheapest thing on the list to fix. Perished gaskets, dropped doors and misaligned locks are repair visits, not replacements. Letterbox brushes and keyhole covers cost pennies. If the budget is tight, this layer alone changes how the house feels in the evening.',
                    ],
                ],
                [
                    'heading' => 'Second money: the glazing that is actually failing.',
                    'body' => [
                        'Misted units are dead insulation and replaceable one unit at a time in their existing frames, so they jump the queue ahead of whole-window decisions. Then rank the remaining windows by the notes you took: the big cold glass in rooms you heat every evening first, spare rooms last. Nobody has to do the whole house at once; phasing in the right order is how most houses get done.',
                    ],
                ],
                [
                    'heading' => 'Doors, and the trap to avoid.',
                    'body' => [
                        'An old external door is often the single leakiest opening in the house, and unlike windows there are only one or two of them, which makes a door an efficient early win. The trap to avoid is buying gadgets before fixing fabric: no smart thermostat warms a room whose window has been leaking heat since 2003. Fabric first, gadgets after.',
                        'Price the whole plan in one sitting with the quote tool, phase it across the year as budget allows, and by next December the resolution is a memory rather than a repeat.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'This is the year',
                'title' => 'Turn the cold-house notes into a costed plan.',
                'copy' => 'Build the windows and doors in the quote tool, see the whole number honestly, and phase it in the order that kills the biggest heat loss first. Survey confirms everything before manufacture.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'The whole house, priced in a sitting'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'The cheap draught layer first'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare styles for the phased plan'],
                ],
            ],
        ],

        'cold-snap-quick-fixes' => [
            'title' => 'Cold snap survival: fast fixes for freezing rooms and iced-up windows',
            'publish_date' => '2027-01-04',
            'title_tag' => 'Cold Snap Fixes For Windows And Doors | Fenster Glazing',
            'meta_description' => 'When a cold snap lands, rooms freeze, locks seize and windows ice up inside. Same-day fixes that help now, and what the cold is diagnosing for later.',
            'products' => ['window-and-door-repairs', 'windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'When a proper cold snap lands, the houses that were coping stop coping: rooms that will not reach temperature, ice flowering on the inside of glass, doors frozen shut. Some of that has same-day fixes, and all of it is the most accurate survey of your house you will ever get for free. Here is the triage.',
                    ],
                ],
                [
                    'heading' => 'Ice on the inside of the glass.',
                    'body' => [
                        'Frost on the room side means the glass surface fell below freezing while carrying the room\'s moisture, which points at single glazing or a long-failed unit. Today: wipe it as it melts so the water does not soak the sills, and drop the moisture load by keeping doors of unused cold rooms shut and lids on everything in the kitchen.',
                        'What it diagnoses: that pane is the coldest surface in your house by a distance. Single glazing and dead units are exactly the replacements that pay you back in comfort first.',
                    ],
                ],
                [
                    'heading' => 'The room the radiator cannot warm.',
                    'body' => [
                        'If the radiator runs hot and the room stays cold, the heat is leaving as fast as it arrives, and in most rooms the glass and its edges are the biggest open tap. Today: curtains drawn at dusk, and a rolled towel on the worst sill draught embarrassingly effective. Feel around the frames with the back of your hand and note exactly where the cold pours in; in this weather you will find it in seconds.',
                        'What it diagnoses: whether the leak is the seals, the frame edges or the glass area itself, which decides later between a repair visit and a replacement window.',
                    ],
                ],
                [
                    'heading' => 'Doors and locks that froze.',
                    'body' => [
                        'Warm the key in your hand, work it gently, and use silicone or PTFE spray rather than force; never boiling water, which refreezes deeper and can crack cold glass nearby. A door frozen to its gaskets frees with gentle pressure at the corners rather than a heave at the handle, which can tear the seal off in one pull.',
                        'A door that freezes shut regularly has moisture sitting in its seals or drainage, and that has a findable cause once the weather lifts.',
                    ],
                ],
                [
                    'heading' => 'Burst-pipe weather and your part in it.',
                    'body' => [
                        'The same draught paths that freeze your toes freeze pipework in cellars, garages and under sills. Closing up the worst air leaks is pipe protection as much as comfort, and it is another reason the cheap draught layer earns its place at the top of any warming plan.',
                    ],
                ],
                [
                    'heading' => 'When it thaws, act on the list.',
                    'body' => [
                        'A cold snap writes you a prioritised work list: this pane iced, this room lost, this door seized, this frame poured cold air. The mistake is warm-weather amnesia; the first mild week deletes the list from memory but not from the house, and next winter runs the same test with the same results. Book the fixes while the evidence is fresh.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The freeze found the faults',
                'title' => 'Fix the list before the thaw erases it.',
                'copy' => 'Frozen locks, iced glass and unheatable rooms are the house diagnosing itself. Send us the list while it is fresh; repairs and failed units are quick wins, and the worst windows now have their ranking.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Seals, locks and same-week fixes'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Dead units, replaced in frame'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Price the worst windows first'],
                ],
            ],
        ],

        'how-much-heat-do-old-windows-lose' => [
            'title' => 'How much heat do old windows actually lose?',
            'publish_date' => '2027-01-11',
            'title_tag' => 'How Much Heat Do Old Windows Lose? | Fenster Glazing',
            'meta_description' => 'U-values, cold glass and the heating bill. How window heat loss works, how to read your own rooms and what genuinely improves with modern glazing.',
            'products' => ['windows', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'January heating bills raise the question every year: how much of this is going out through the windows? The honest answer is that it depends on your house, and anyone quoting you a universal percentage is selling rather than measuring. What we can do is show you how the loss works and how to read your own rooms.',
                    ],
                ],
                [
                    'heading' => 'The U-value, in plain terms.',
                    'body' => [
                        'Window heat loss is measured as a U-value: how much heat passes through a square metre of the window for each degree of temperature difference. Lower is better. Single glazing sits several times higher than a modern double glazed window, which is a way of saying it leaks heat several times faster through every square metre, every hour the heating runs.',
                        'When we quote a window, we can tell you its real U-value, so you compare actual figures rather than brochure adjectives. That is also the figure building regulations set minimum standards for in replacement windows.',
                    ],
                ],
                [
                    'heading' => 'Why the room feels colder than the thermostat says.',
                    'body' => [
                        'Cold glass punishes you twice. It conducts heat out, and it chills you directly: your body radiates warmth towards any cold surface it faces, which is why sitting near a big single glazed window feels draughty even in still air. Add the convection loop, where room air cools against the glass and slides down as a cold current across the floor, and a glass-heavy room can feel two or three degrees meaner than its own thermostat reading.',
                        'That is why new glazing changes comfort faster than it changes bills: the cold-surface effects vanish the day the window goes in.',
                    ],
                ],
                [
                    'heading' => 'What actually changed in modern units.',
                    'body' => [
                        'A modern sealed unit is not just two sheets of glass. A low-emissivity coating reflects the room\'s warmth back inward, the cavity is filled with a heavier gas than air to slow conduction, and warm-edge spacers cut the cold bridge around the perimeter where old units frost first. The frames changed too, with multiple chambers in uPVC and thermal breaks in aluminium doing for the frame what the coating does for the glass.',
                    ],
                ],
                [
                    'heading' => 'Read your own house before buying anything.',
                    'body' => [
                        'On a cold evening, hold the back of your hand a few centimetres from each pane. Glass that feels like a cold radiator, frames that leak moving air, and rooms whose radiators fight all evening are your measurements, and they rank your windows more honestly than any generic saving claim. Replace in that order and the spend follows the loss.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Want real figures?',
                'title' => 'Compare windows on numbers, not adjectives.',
                'copy' => 'We will tell you the actual specification of what we quote, and the online tool gives you the price to weigh against it. Rank your coldest rooms first and the sums make themselves.',
                'links' => [
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'The main ranges compared'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                    ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'The workhorse style, specified properly'],
                ],
            ],
        ],

        'spring-extension-order-glazing-first' => [
            'title' => 'Planning a spring extension? Sort the glazing before the builder starts',
            'publish_date' => '2027-01-18',
            'title_tag' => 'Extension Glazing: Decide It Before The Build | Fenster Glazing',
            'meta_description' => 'Bifolds, roof lanterns and big glass are made to measure and made to order. Why extension glazing decided in January keeps a spring build off the critical path.',
            'products' => ['roof-lanterns', 'aluminium-bifold-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'If a builder is pencilled in for spring, January is when the glazing decisions stop being browsing and start being schedule. The doors and roof glass are usually the longest-lead items in the whole extension, and the most common glazing-related delay we see is simply that nobody ordered them early enough.',
                    ],
                ],
                [
                    'heading' => 'Why glazing sits on the critical path.',
                    'body' => [
                        'Bifolds, sliders and lanterns are manufactured to the exact structural opening, in your chosen colour and glass, after survey. That is a made-to-order chain with real lead time, not a warehouse shelf. Meanwhile the build cannot weatherproof until the openings are filled, so late glazing does not just arrive late; it holds the trades behind it.',
                        'The fix is sequencing: specification and pricing settled now, survey as soon as the openings exist, manufacture running while the build does.',
                    ],
                ],
                [
                    'heading' => 'The decisions to settle in January.',
                    'body' => [
                        'Door format first, because it shapes the room: bifolds that open the whole wall, a slider with bigger glass and no stacking panels, or French doors on a smaller opening. Then the lantern or rooflight over the top, sized to the flat roof and specified for heat and glare. Then colour, inside and out, threshold detail and glass specification.',
                        'Every one of those choices changes the structural opening or the order details, which is exactly why the builder wants them settled before steels are ordered, not after.',
                    ],
                ],
                [
                    'heading' => 'Coordinate the two surveys.',
                    'body' => [
                        'Glazing this size is surveyed against the actual structure. What works well is pricing and choosing now from drawings, then our technical survey as soon as the openings are formed, with manufacture starting immediately after. That squeezes the made-to-order period into the weeks the builder is busy with roof and first fix, instead of adding it to the end of the job.',
                        'Give your builder and your glazing supplier each other\'s details early. One phone call between them about opening sizes and threshold build-up saves the classic on-site argument about who measured what.',
                    ],
                ],
                [
                    'heading' => 'The part everyone forgets.',
                    'body' => [
                        'The doors and lantern are the stars, but the extension usually touches other glazing: a window that becomes internal, a door that moves, a kitchen window that should really match the new doors. Sweeping those into the same order means one survey, one colour match and one fitting visit rather than a mismatched afterthought in June.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Building this spring?',
                'title' => 'Get the glazing off the critical path now.',
                'copy' => 'Price the doors and lantern from your drawings this month, and we will survey the openings as soon as they exist. The build stays on schedule and the glass arrives when the builder needs it.',
                'links' => [
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'Open the whole back wall'],
                    ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/'), 'meta' => 'Daylight over the new room'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Price from the drawings today'],
                ],
            ],
        ],

        'bifolds-sliders-or-french-doors' => [
            'title' => 'Bifolds, sliders or French doors: choosing for how you actually live',
            'publish_date' => '2027-01-25',
            'title_tag' => 'Bifolds, Sliders Or French Doors? | Fenster Glazing',
            'meta_description' => 'The three garden door formats suit three different houses and habits. An honest comparison of opening, glass, space and cost so you choose for your actual life.',
            'products' => ['aluminium-bifold-doors', 'aluminium-sliding-doors', 'french-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Garden doors get chosen a season ahead, and the January decision shapes every summer after it. Bifolds, sliders and French doors all fill the same hole in the wall and suit noticeably different houses and habits, so this is the comparison we give across the showroom table, including the parts each format\'s fans skip.',
                    ],
                ],
                [
                    'heading' => 'Bifolds: the whole wall, when open.',
                    'body' => [
                        'A bifold concertinas its panels to one or both ends, opening most of the aperture. On a warm day the kitchen and garden genuinely become one room, which is the trick no other format performs, and the reason bifolds carried the last decade of extensions.',
                        'The honest trade-offs: closed, a bifold shows more frame than glass, because every panel brings its own surround. The stacked panels need somewhere to stand, eating a slice of patio or room. And the folding hardware asks for a clean track and an occasional service to stay sweet.',
                    ],
                ],
                [
                    'heading' => 'Sliders: the biggest glass, all year.',
                    'body' => [
                        'A slider moves big panes along a track, so the panels are few and enormous. Closed, which is what a door in Britain is for ten months of the year, a slider is mostly glass and the garden view is the wall. Panels do not need parking space, and the action on a quality slider is one-finger smooth.',
                        'The trade-offs: the opening is at most about half the aperture on a two-panel door, because panes park in front of each other rather than leaving. And big glass is heavy glass, which is why the engineering, and the price, sit at the aluminium end of the market.',
                    ],
                ],
                [
                    'heading' => 'French doors: the honest classic.',
                    'body' => [
                        'A pair of hinged doors, opening fully to a clear aperture with no track across the threshold and no panels to park. On openings under about two and a half metres, French doors are frequently the right answer rather than the budget one: simplest mechanism, easiest everyday use, happiest with a dog and a laundry basket.',
                        'The trade-off is scale. Two leaves can only span so much wall, so on a wide opening French doors either gain fixed side panels or give way to the other formats.',
                    ],
                ],
                [
                    'heading' => 'Choose on the closed position and the wall.',
                    'body' => [
                        'The buying mistake is choosing on the open-door fantasy. Ask instead: how does it look shut in February, how wide is the actual wall, and where would panels park? Wide wall plus summer entertaining points at bifolds. View first, doors-shut-mostly points at a slider. Modest opening and everyday practicality points at French doors, proudly.',
                        'All three are priced in our online tool, so you can put real numbers on the comparison for your actual opening before anyone visits.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Summer starts in January',
                'title' => 'Price all three against your actual opening.',
                'copy' => 'The formats price differently at every size, so compare them on your wall rather than in general. Ordered in late winter, the doors are fitted and run in before the first barbecue.',
                'links' => [
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'The whole wall, opened'],
                    ['label' => 'Aluminium sliding doors', 'url' => home_url('/aluminium-sliding-doors/'), 'meta' => 'The biggest glass, year round'],
                    ['label' => 'French doors', 'url' => home_url('/french-doors/'), 'meta' => 'The classic for modest openings'],
                ],
            ],
        ],

        'do-new-windows-add-value' => [
            'title' => 'Do new windows add value to your home? A straight answer',
            'publish_date' => '2027-02-01',
            'title_tag' => 'Do New Windows Add Value To Your Home? | Fenster Glazing',
            'meta_description' => 'New windows and what they really do for a sale: kerb appeal, EPC, surveys and buyer confidence. The honest version, without the invented percentage claims.',
            'products' => ['windows', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The industry loves telling you new windows add ten per cent to your house price. We will not, because nobody can honestly promise that, and you would be right not to believe them. Here is what new windows genuinely do to a sale, which is worth having straight before you spend.',
                    ],
                ],
                [
                    'heading' => 'Where windows genuinely move a sale.',
                    'body' => [
                        'Kerb appeal is real and windows are most of it: frames and front door set the first impression before the photos are even taken, and tired frames photograph worse than almost any other fault. Below the surface, windows feed the EPC rating that now appears on every listing, and glazing is one of the fabric items the assessment looks at directly.',
                        'Then there is the survey. Rotten frames, failed units and non-opening windows appear on the buyer\'s homebuyer report, and every flagged item becomes a renegotiation lever. New, certificated windows remove a whole category of those levers before they exist.',
                    ],
                ],
                [
                    'heading' => 'The certificate matters as much as the glass.',
                    'body' => [
                        'Replacement windows fitted since 2002 need building regulations sign-off, and conveyancers ask for the certificate as routine. Our installations are certificated through FENSA, which means the paperwork exists, is registered, and answers the solicitor\'s enquiry with a document rather than an indemnity policy. A drawer with the certificates in it is an underrated selling asset.',
                    ],
                ],
                [
                    'heading' => 'When the spend makes selling sense.',
                    'body' => [
                        'If your windows are visibly failing, misted, rotten or mismatched, replacement before marketing usually earns its keep, because failing windows cost you twice: once in first impressions and again in the survey negotiation. If the windows are sound but dated, the honest answer is that a deep clean, new handles and decorating may serve the sale better than a full replacement bought in a hurry.',
                        'And if you are staying five years or more, the sale maths is secondary anyway. You are buying warmth, quiet and lower bills for yourself, with the sale benefit banked for later.',
                    ],
                ],
                [
                    'heading' => 'Buy it once, with the paperwork.',
                    'body' => [
                        'Whatever you decide, decide it with real numbers: our quote tool prices the actual house rather than a national average, and everything we fit comes with the guarantee and the certification a future buyer\'s solicitor will ask about. That is the version of adding value we can promise, because we hand it to you in writing.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Selling or staying?',
                'title' => 'Put a real number against the decision.',
                'copy' => 'Price the windows for your actual house in minutes, then decide with the facts. Everything we fit is FENSA certificated with a ten year guarantee, and the paperwork does its own talking at sale time.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Your house, not an average'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Styles that suit the street'],
                    ['label' => 'Why trust Fenster', 'url' => home_url('/why-trust-fenster/'), 'meta' => 'Accreditations and guarantees'],
                ],
            ],
        ],

        'what-fensa-certifies' => [
            'title' => 'What FENSA actually certifies, and why solicitors ask for it',
            'publish_date' => '2027-02-08',
            'title_tag' => 'What FENSA Certifies And Why It Matters | Fenster Glazing',
            'meta_description' => 'Replacement windows need building regulations sign-off, and FENSA is how most installers provide it. What the certificate covers and why sales stall without it.',
            'products' => ['windows', 'double-glazing'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'FENSA is one of those logos every window company shows and almost nobody explains. Since it is the piece of paper a solicitor will one day demand about work you did years earlier, it is worth two minutes of plain explanation now, while it is a detail rather than a problem.',
                    ],
                ],
                [
                    'heading' => 'The rule underneath it.',
                    'body' => [
                        'Since April 2002, replacing windows and external doors in England and Wales has been building-regulations-controlled work. The regulations set standards for the thermal performance of the new windows, safety glazing in critical locations, ventilation, and fire escape openings where they are required. Every replacement legally needs sign-off that those standards were met.',
                        'There are two routes to that sign-off: pay the council to inspect each job through building control, or use an installer registered with a competent person scheme who can self-certify their own compliant work. FENSA is the best known of those schemes for glazing.',
                    ],
                ],
                [
                    'heading' => 'What the certificate actually says.',
                    'body' => [
                        'A FENSA certificate records that the installation was declared compliant with building regulations by a registered installer, and it is logged centrally so replacements can be ordered years later if the paperwork goes missing. Registered installers are also subject to scheme inspections rather than simply signing their own homework unchecked.',
                        'What it is not: a product warranty or a quality mark on the glass itself. The certificate is about legal compliance of the installation. The guarantee on the windows and workmanship is a separate document, and you should hold both.',
                    ],
                ],
                [
                    'heading' => 'Why your solicitor will ask.',
                    'body' => [
                        'When a house sells, the buyer\'s conveyancer checks that notifiable work has its sign-off, and replacement windows are on the standard enquiry list. No certificate means delay, and usually ends with the seller buying an indemnity insurance policy to paper over the gap. It is rarely fatal to a sale, but it is friction, cost and a bad look, all avoidable by using a registered installer in the first place.',
                        'If you have lost a FENSA certificate for past work, replacements can be ordered from FENSA directly for a small fee, which is considerably cheaper than an indemnity policy negotiated under time pressure.',
                    ],
                ],
                [
                    'heading' => 'What to check when you order windows.',
                    'body' => [
                        'Ask who provides the building regulations sign-off before you sign anything; a registered installer will answer in one sentence. We are FENSA registered, the certificate arrives after installation as part of the job, and it sits alongside the ten year guarantee on new windows and doors rather than instead of it.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Paperwork sorted',
                'title' => 'Windows with the certificate included.',
                'copy' => 'Every installation we complete is FENSA certificated as standard, so the compliance question is answered before your solicitor ever asks it. The price online is the place to start.',
                'links' => [
                    ['label' => 'Why trust Fenster', 'url' => home_url('/why-trust-fenster/'), 'meta' => 'Accreditations, explained properly'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare the main ranges'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'condensation-and-mould-around-windows' => [
            'title' => 'Black mould around window frames: what is actually fixable',
            'publish_date' => '2027-02-15',
            'title_tag' => 'Black Mould Around Window Frames: The Fixes | Fenster Glazing',
            'meta_description' => 'Mould on gaskets, sealant and reveals grows where condensation keeps surfaces damp. How to clean it safely, stop it returning and when glazing is the cause.',
            'products' => ['windows', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'By late winter it shows up in the corners: black speckling along the window gaskets, dots climbing the sealant line, a shadow on the plaster beside the frame. Mould around windows is a moisture symptom with a mechanical explanation, and most of it is fixable without drama once you know which kind you are looking at.',
                    ],
                ],
                [
                    'heading' => 'Why it grows exactly there.',
                    'body' => [
                        'Mould needs a surface that stays damp, and the coldest spots in a room are where condensation forms and lingers: the glass edge, the gasket line, the frame corners and the reveal beside them. Months of morning condensation that never quite dries is a standing invitation, which is why the speckling appears at the end of winter rather than the start.',
                        'It concentrates in bedrooms because they generate moisture all night with the ventilation shut, and behind curtains and furniture because still air lets surfaces stay cold and wet longest.',
                    ],
                ],
                [
                    'heading' => 'Cleaning it off properly.',
                    'body' => [
                        'For the typical speckling on frames, gaskets and paint, a household mould spray or diluted bleach on a cloth deals with the growth; wipe, leave to work, rinse and dry. Wear gloves, ventilate the room while you work, and bin the cloth. Vinegar-based cleaners suit those avoiding bleach.',
                        'Two cautions. Scrubbing bare silicone sealant rarely rescues it once mould has rooted through it; stained silicone is for cutting out and renewing, which is a small job done properly. And large areas, anything beyond a patch or two, or mould paired with a musty room and damp walls, is a building damp problem beyond a window cloth, and worth a professional look at the cause.',
                    ],
                ],
                [
                    'heading' => 'Stopping it coming back.',
                    'body' => [
                        'Cleaning without changing the moisture routine buys you one season. The permanent fix is the boring one: vents open in bedrooms, extractors used with doors shut, washing dried sensibly, a morning wipe of wet glass, and curtains and furniture given a little distance from the coldest walls. Dry surfaces cannot grow mould, and everything above exists to keep them dry.',
                    ],
                ],
                [
                    'heading' => 'When the glazing is the cause.',
                    'body' => [
                        'Some windows make the problem: single glazing and failed units run cold enough to stream every morning regardless of reasonable habits, perished gaskets hold water against the frame, and old frames with cold bridges keep one corner permanently damp. If one window regrows its mould while the rest of the house behaves, that window is the suspect, and the fix is gaskets, a new sealed unit or a replacement window rather than a stronger cleaner.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'One window always worst?',
                'title' => 'Fix the cold surface, not just the stain.',
                'copy' => 'If the same frame regrows its mould every winter, the window is running too cold or holding water. Gaskets, sealed units and sealant are all renewable, and we will say which it needs.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Gaskets, seals and silicone renewed'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Failed units, replaced in frame'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'When the frame is the cold bridge'],
                ],
            ],
        ],

        'planning-permission-and-new-windows' => [
            'title' => 'Planning permission and new windows: when you actually need to ask',
            'publish_date' => '2027-02-22',
            'title_tag' => 'Planning Permission For New Windows | Fenster Glazing',
            'meta_description' => 'Most window replacement needs no planning permission, but conservation areas, listed buildings and flats change the answer. The plain-English rules.',
            'products' => ['heritage-windows', 'sliding-sash-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The planning question stalls more window projects than price does, usually because the answer online is a fog of exceptions. The actual shape of it is simple: most houses need no permission at all, a few situations genuinely do, and finding out which you are in costs one enquiry before you order rather than a dispute after.',
                    ],
                ],
                [
                    'heading' => 'The default: permitted development.',
                    'body' => [
                        'For an ordinary house, replacing windows and doors with ones of a similar appearance falls under permitted development, meaning no planning application is needed. Like-for-like style swaps, uPVC for tired uPVC, and sensible changes of colour or material generally pass without anyone needing to be asked.',
                        'Planning permission is a separate question from building regulations, which apply to every replacement everywhere and are handled by the installer\'s certification. Do not let anyone blur the two: regulations always, planning rarely.',
                    ],
                ],
                [
                    'heading' => 'Conservation areas: usually fine, check first.',
                    'body' => [
                        'In a conservation area, permitted development still applies to most window replacement, provided the appearance stays sympathetic. The exception is where the council has issued an Article 4 direction, which removes those rights for named streets and makes window changes need an application. Milton Keynes has its share of conservation areas in the older towns and villages, and the council\'s conservation pages or one phone call tells you whether an Article 4 covers your street.',
                        'This is where heritage-styled modern windows earn their keep: flush casements and sash designs that satisfy a conservation officer while behaving like current glazing behind the sightlines.',
                    ],
                ],
                [
                    'heading' => 'Listed buildings: always consent, no shortcuts.',
                    'body' => [
                        'A listed building needs listed building consent for window changes, and fitting replacements without it is a criminal offence rather than a paperwork gap. Consent conversations start with the conservation officer and take the time they take; secondary glazing behind the original windows is often the pragmatic route to warmth in the meantime, since it leaves the protected fabric untouched.',
                    ],
                ],
                [
                    'heading' => 'Flats, leases and the other permissions.',
                    'body' => [
                        'Flats and maisonettes sit outside householder permitted development, so window changes usually need planning permission, and the lease frequently requires the freeholder\'s consent as well; many blocks also insist replacements match a building-wide specification. If you rent out a house or run one as an HMO, check the paperwork side before ordering too.',
                        'None of this is a reason to stall. It is a fortnight of asking the right two questions before survey, and we are happy to advise on which situation your property is actually in when we quote.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Heritage street?',
                'title' => 'Windows that satisfy the conservation officer.',
                'copy' => 'Flush casements and sliding sashes in heritage styles pass the street test while fixing the winter one. Tell us the street and we will flag anything worth checking with the council first.',
                'links' => [
                    ['label' => 'Heritage windows', 'url' => home_url('/heritage-windows/'), 'meta' => 'Sympathetic styles, modern glazing'],
                    ['label' => 'Sliding sash windows', 'url' => home_url('/sliding-sash-windows/'), 'meta' => 'The traditional look, engineered'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk it through at your home'],
                ],
            ],
        ],

        'march-survey-season' => [
            'title' => 'March is survey season: why summer glazing gets ordered now',
            'publish_date' => '2027-03-01',
            'title_tag' => 'Why Summer Glazing Gets Ordered In March | Fenster Glazing',
            'meta_description' => 'Bifolds fitted for June and windows done before the school holidays both start with a March survey. How the made-to-order timeline really works across spring.',
            'products' => ['windows', 'aluminium-bifold-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Every June someone rings wanting bifolds for July, and every June the honest answer disappoints them. Windows and doors are made to measure after a survey, and the pleasant months are when everyone wants the fitting done. The people enjoying new doors at the first barbecue are the ones who were surveyed in March.',
                    ],
                ],
                [
                    'heading' => 'The chain that sets the timing.',
                    'body' => [
                        'Nothing we fit comes off a shelf. The sequence is fixed: you choose and price, we survey the openings properly, the order goes to manufacture in your sizes and colours, and fitting is booked when the products land. Each link takes real time, and the only link you control the timing of is the first one.',
                        'Colour choices can stretch the middle link; standard white uPVC generally moves through manufacture faster than special colours and foils, which are made to order at the factory too. If a specific finish matters to you, that is one more reason to start the chain early rather than compromise in May.',
                    ],
                ],
                [
                    'heading' => 'Why spring is the pinch.',
                    'body' => [
                        'Demand for fitting is seasonal even though the products are not. Everyone wants garden doors before summer and windows done in decent weather, so the diary fills from late spring and stays full past September. Starting in March means your survey, manufacture and fitting all happen ahead of that squeeze instead of inside it.',
                        'There is a comfort bonus too: fitting in mild weather means rooms open to the air for an hour are a non-event, where the same job in January needs more choreography.',
                    ],
                ],
                [
                    'heading' => 'What starting now actually involves.',
                    'body' => [
                        'An evening with the online quote tool puts real prices against real sizes without anyone visiting. If the numbers work, the technical survey pins down every measurement and detail, and that is the moment the timeline becomes a commitment rather than an estimate; we confirm the expected timescale when the order is placed, based on what is actually in it.',
                        'From there the wait happens at the factory, not in your diary. There is nothing further for you to chase; the next event is us booking the fitting.',
                    ],
                ],
                [
                    'heading' => 'And if you are reading this in June.',
                    'body' => [
                        'Start anyway. The chain is the chain, and beginning it today always beats beginning it after the holiday. Autumn fitting means the doors are run in and adjusted long before they earn their keep next summer, and the winter windows are simply done a season early.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Summer in mind?',
                'title' => 'Start the chain while spring is still early.',
                'copy' => 'Price it online tonight, survey this month, and the fitting lands ahead of the summer squeeze. The timescale gets confirmed honestly at order, not guessed at in a blog.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Real prices against real sizes'],
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'The summer favourite, surveyed properly'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Done before the holidays'],
                ],
            ],
        ],

        'upvc-or-aluminium-windows' => [
            'title' => 'uPVC or aluminium windows: an honest comparison',
            'publish_date' => '2027-03-08',
            'title_tag' => 'uPVC Or Aluminium Windows Compared Honestly | Fenster Glazing',
            'meta_description' => 'We fit both, so this is the real comparison: sightlines, colour, warmth, lifespan and cost logic, and which suits which house without the salesmanship.',
            'products' => ['aluminium-windows', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The uPVC against aluminium question produces more one-sided answers than any other in glazing, usually depending on which one the company happens to sell. We fit both, which frees us to give you the version where each material wins the arguments it actually wins.',
                    ],
                ],
                [
                    'heading' => 'The look: frame versus glass.',
                    'body' => [
                        'Aluminium\'s strength lets it hold the same glass with visibly less frame, so an aluminium window reads as slimmer lines and more daylight, and it carries dark and bold colours with a crispness uPVC struggles to match. On a modern house, or anywhere the architecture leans contemporary, that sightline difference is the whole argument.',
                        'Modern uPVC has closed much of the gap, and in white or cream on an ordinary street the difference is smaller than brochures imply. Flush casement uPVC in particular gives a clean, joinery-like face that suits traditional houses well.',
                    ],
                ],
                [
                    'heading' => 'Warmth: closer than the folklore says.',
                    'body' => [
                        'The old line that aluminium is cold belongs to the last century. Current aluminium frames carry thermal breaks, insulating barriers inside the profile, and both materials comfortably meet the regulations with the right glass. uPVC\'s multi-chambered sections still hold a modest natural edge at similar spec, and on most houses the glass choice moves the room\'s warmth more than the frame material does.',
                    ],
                ],
                [
                    'heading' => 'Living with them.',
                    'body' => [
                        'Both are low maintenance in the wipe-down sense, with no painting ever. Aluminium is the more rigid material: it shrugs off knocks, holds big panes without complaint and its powder-coated finish stays crisp for decades. uPVC is forgiving, quietly durable and easier on the budget, with colour foils that have improved enormously but bold, dark, sun-baked colours remain aluminium\'s home ground.',
                        'For large openings, heavy glass and slim modern grids, the engineering case tips aluminium. For a standard casement in a standard opening, uPVC does the job with nothing to apologise for.',
                    ],
                ],
                [
                    'heading' => 'The cost logic, plainly.',
                    'body' => [
                        'uPVC is the value answer and aluminium the premium one, window for window. The honest way to choose: match the material to the house and the opening rather than the brochure. Plenty of our jobs mix them, aluminium for the big garden opening where the slim frames show, uPVC for the bedrooms where nobody studies the sightlines. Price both in the online tool and the difference stops being abstract.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Material undecided?',
                'title' => 'Price both and let the house choose.',
                'copy' => 'The tool prices uPVC and aluminium against your actual openings, and mixing materials across the house is normal, not a compromise. The survey settles the details either way.',
                'links' => [
                    ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/'), 'meta' => 'Slim frames, bold colours'],
                    ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'The uPVC workhorse'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Both materials, real numbers'],
                ],
            ],
        ],

        'obscure-glass-privacy-explained' => [
            'title' => 'Obscure glass, explained: privacy for bathrooms and front doors',
            'publish_date' => '2027-03-15',
            'title_tag' => 'Obscure Glass Privacy Levels Explained | Fenster Glazing',
            'meta_description' => 'Obscure glass comes in patterns and privacy levels, and a bathroom needs a different level to a front door. How the scale works and how to choose.',
            'products' => ['upvc-doors', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Every house has glass that needs to let light through and stop eyes doing the same: the bathroom, the cloakroom, the panels beside the front door. Obscure glass does that job with a surprising range of styles and strengths, and it is chosen per pane at ordering time, which is exactly when most people discover they have opinions about it.',
                    ],
                ],
                [
                    'heading' => 'How the privacy levels work.',
                    'body' => [
                        'Obscure patterns are graded on a privacy scale, running from a level one, a light texture that blurs detail while keeping the glass bright, up to a level five, where shapes dissolve entirely at any distance. The pattern is worked into one face of the glass at manufacture, and the unit then behaves like any other double glazing: same warmth, same toughened options, same cleaning.',
                        'The grading measures distortion, not darkness. A high privacy level does not mean a gloomy room; it means what is behind the glass stays unreadable even close up.',
                    ],
                ],
                [
                    'heading' => 'Matching the level to the room.',
                    'body' => [
                        'Bathrooms and shower rooms deserve the top of the scale; level four or five is the standard advice, because steam-lit silhouettes at night are precisely what the higher grades exist to prevent. Cloakrooms and en-suites follow the same logic.',
                        'Front door glass and side panels sit lower, commonly around level three: enough that a caller reads as a shape rather than a face, while the hallway keeps its daylight. Landings, garages and utility rooms are taste rather than necessity, and a gentle level one or two texture often looks better than full frosting.',
                    ],
                ],
                [
                    'heading' => 'The styles, briefly.',
                    'body' => [
                        'The familiar families are the soft satin etch, all-over stipple textures, and linear reeded or fluted designs that are enjoying their architectural moment. Some patterns have a direction, which matters: reeded glass runs its lines vertically or horizontally depending on how the unit is made, and it is worth saying which you want out loud at order rather than assuming.',
                        'Remember the neighbours-eye view too: obscure glass reads differently after dark with the room lit, which is why the bathroom gets graded pessimistically.',
                    ],
                ],
                [
                    'heading' => 'Changing it without changing the window.',
                    'body' => [
                        'Privacy is a sealed unit property, so if a clear window overlooks somewhere it should not, or a dated pattern offends you daily, the unit can be swapped for an obscure one in the existing frame. It is the same job as replacing a misted unit, and considerably cheaper than tolerating a towel pinned over the landing window for another decade.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Glass with modesty',
                'title' => 'Choose the pattern and level per pane.',
                'copy' => 'Our obscure glass hub shows the patterns side by side, and the survey confirms level and direction for each pane before manufacture. Swaps into existing frames are a small job.',
                'links' => [
                    ['label' => 'Obscured glass options', 'url' => home_url('/obscured-glass/'), 'meta' => 'Patterns and privacy levels'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Swap a clear unit for obscure'],
                    ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/'), 'meta' => 'Door glass and side panels'],
                ],
            ],
        ],

        'spring-window-maintenance-after-winter' => [
            'title' => 'Spring maintenance: what winter did to your windows',
            'publish_date' => '2027-03-22',
            'title_tag' => 'Spring Window Maintenance After Winter | Fenster Glazing',
            'meta_description' => 'Winter leaves windows with tired seals, stiff hinges and clogged drainage. A spring once-over that takes an hour and prevents next winter\'s faults.',
            'products' => ['window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The autumn check protects you going into winter; the spring one collects the bill for it. Months of rain, frost, condensation and slammed-shut living leave every window and door slightly worse than October found them, and an hour of spring attention resets most of it before summer bakes the faults in.',
                    ],
                ],
                [
                    'heading' => 'Wash the frames, and mind the products.',
                    'body' => [
                        'Winter grime is mildly acidic city film plus mould food, and it sits hardest on sills and lower frames. Warm soapy water and a soft cloth is the whole recipe for uPVC and aluminium alike. Avoid abrasive creams, solvent cleaners and anything bleach-strong on coloured frames and gaskets; they win the afternoon and dull the finish for good.',
                        'While washing, you are also inspecting. Cleaning is how the hairline crack in the silicone or the gasket working loose actually gets noticed.',
                    ],
                ],
                [
                    'heading' => 'Ease what winter stiffened.',
                    'body' => [
                        'Open every window fully, including the ones winter kept shut. Hinges that grind or squeal get a dose of silicone spray; handles and locks the same at the moving parts. A window that was avoided all winter often just needs working through its motion a few times to redistribute the lubricant it already had.',
                        'Doors get the same treatment plus a seasonal note: a door adjusted tight against the cold may run slightly proud in warm weather, and one that starts catching as temperatures climb is asking for its hinges tweaked back, a five-minute adjustment.',
                    ],
                ],
                [
                    'heading' => 'Clear the drainage before the spring rains.',
                    'body' => [
                        'The drainage slots along the bottom of frames spent winter collecting silt, moss and the neighbourhood\'s leaf fragments. Clear them with a pipe cleaner or a thin plastic tool so the frames drain outward all summer. Do the patio door track and door thresholds at the same time; grit in a track is the main killer of smooth sliding.',
                    ],
                ],
                [
                    'heading' => 'Log the damage winter actually did.',
                    'body' => [
                        'Look for gaskets that shrank back at corners, silicone that cracked, units that misted for the first time, and any handle that no longer pulls its window in snug. None of these are urgent in April, which is precisely why April is the month to book them; the same faults ignored become December emergencies, and the diary is kinder now.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Winter left a list?',
                'title' => 'Book the small fixes in the quiet season.',
                'copy' => 'Perished gaskets, tired silicone, first-time misted units and dropped doors are all quick spring jobs. Send us what the wash-down turned up and we will work through it in one visit.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Seals, hinges, locks and glass'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Units that misted over winter'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'One visit, the whole list'],
                ],
            ],
        ],

        'bow-and-bay-window-replacement' => [
            'title' => 'Bow and bay windows: what replacement actually involves',
            'publish_date' => '2027-03-29',
            'title_tag' => 'Bow And Bay Window Replacement Explained | Fenster Glazing',
            'meta_description' => 'Bays can carry the wall above them, which makes replacing one a structural job as well as a glazing one. The bow-bay difference and what a proper survey checks.',
            'products' => ['bow-bay-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Bay windows are the feature buyers photograph and the replacement quote that surprises people, because a bay is not simply three windows in a row. Some bays hold up part of the house, and knowing what is structural before anything is ordered is the difference between a proper job and a sagging one.',
                    ],
                ],
                [
                    'heading' => 'Bow versus bay, since the names blur.',
                    'body' => [
                        'A bay projects from the house in defined angles, square or splayed, usually with its own roof and often rising through more than one storey. A bow is the gentler curve: typically four or five equal windows in a faceted arc, sometimes projecting only modestly from a flat wall.',
                        'The distinction matters mechanically. The deeper and older the projection, the more likely the window frames themselves have been made to carry load they were never really designed to advertise.',
                    ],
                ],
                [
                    'heading' => 'The structural question that decides everything.',
                    'body' => [
                        'On many period and inter-war bays, the mullions between the windows help support the bay roof or the wall and bedroom bay above. Pull those frames out without accounting for the load and the structure above settles, which shows up as cracked render, dropped roofs and windows that jam within the year. It is the classic botched-bay story and it is entirely avoidable.',
                        'The answer is load assessment at survey and, where needed, structural bay poles and jacks fitted within the new mullions so the replacement carries what the original carried. This is decided by looking, measuring and understanding the construction, not by assuming.',
                    ],
                ],
                [
                    'heading' => 'The parts a bay quote properly includes.',
                    'body' => [
                        'Beyond the frames: the corner posts that join them at the correct angles, structural support where the survey demands it, the sills and soffits that close the projection, and the making-good inside where old frames leave their mark. If the bay roof itself is tired, spring is the moment to say so, since scaffolding and access are already part of the conversation.',
                        'A bow on a flat wall is usually a simpler affair, closer to a run of casements with angled couplings, which is why like-for-like bow quotes tend to land gentler than bay ones.',
                    ],
                ],
                [
                    'heading' => 'What you get back for the fuss.',
                    'body' => [
                        'A replaced bay transforms the two rooms it serves: the draughtiest, coldest corner of most period houses becomes the warmest seat, and the street face of the house gets its feature back crisp instead of flaking. Style-wise, modern uPVC and flush casement ranges reproduce the period look convincingly, and the survey is where those details get matched to the house rather than the catalogue.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Feature window, proper job',
                'title' => 'Get the structure surveyed before the style chosen.',
                'copy' => 'Bays get load-checked at survey and supported where the house needs it; that is non-negotiable with us. The style, colour and glass conversation is the enjoyable part after.',
                'links' => [
                    ['label' => 'Bow and bay windows', 'url' => home_url('/bow-bay-windows/'), 'meta' => 'Styles and construction detail'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Have the bay looked at properly'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'roof-lantern-or-flat-rooflight' => [
            'title' => 'Roof lantern or flat rooflight: choosing overhead glazing',
            'publish_date' => '2027-04-05',
            'title_tag' => 'Roof Lantern Or Flat Rooflight? | Fenster Glazing',
            'meta_description' => 'Both flood a flat-roofed room with daylight; they do it differently. Height, light spread, the view from upstairs and where each one actually wins.',
            'products' => ['roof-lanterns'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Extension season brings the same fork in the road every spring: lantern or flat rooflight over the new room? Both put daylight where windows cannot reach, both are made to order for the opening, and the right answer comes from the room, the roof and the views of it, not from fashion.',
                    ],
                ],
                [
                    'heading' => 'What each one actually is.',
                    'body' => [
                        'A roof lantern is a pitched structure of glazed panels standing proud of the flat roof, a small glass roof in its own right. A flat rooflight is a sealed glazed unit sitting flush or nearly flush with the roof line, from fixed panes through opening versions to walk-on units for terraces.',
                        'Both use the same modern glass science: solar control against summer heat, self-cleaning coatings, and thermally broken aluminium frames. The difference is geometry, and geometry decides most of what follows.',
                    ],
                ],
                [
                    'heading' => 'Light and the feel of the room.',
                    'body' => [
                        'The lantern\'s pitch catches light from every direction and throws it deeper into the room, and the upward void adds a sense of height a flat ceiling cannot fake; standing under one is the showroom moment that sells them. The rooflight gives a purer, simpler shaft of sky, reads as minimal from inside, and suits rooms where the design language is clean planes rather than features.',
                        'For sheer wow over a kitchen island, the lantern usually wins. For a calm bathroom or a study, the rooflight often feels more right.',
                    ],
                ],
                [
                    'heading' => 'The looks nobody thinks to check.',
                    'body' => [
                        'Walk upstairs before deciding. The view down onto the extension roof is where the choice shows daily: a lantern is an intentional glass structure from above, a rooflight a discreet pane. From the garden, a lantern announces the extension; a rooflight lets the brickwork and doors do the talking.',
                        'Height limits matter too. Planning conditions and neighbour sightlines sometimes cap what can stand proud of the roof, and a low-profile rooflight sails under constraints a lantern cannot. Ventilation runs the other way: opening rooflights are the neat way to vent a hot kitchen upward, and worth specifying at order rather than regretting after.',
                    ],
                ],
                [
                    'heading' => 'Structure and the practical bits.',
                    'body' => [
                        'Both need a properly built upstand and both are sized to the structural opening, which is why this decision belongs in the build drawings rather than after the roofers leave. Very large lanterns spread their load through their frame; very large rooflights become heavy single units with their own handling questions. Either way the survey against the actual roof is what turns the choice into an order.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Daylight from above',
                'title' => 'Match the glazing to the room and the roof.',
                'copy' => 'Compare both formats properly, then let the survey settle sizes, upstands and glass. Specified in the drawings, the roof glazing arrives when the builder needs it.',
                'links' => [
                    ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/'), 'meta' => 'Pitched glass with presence'],
                    ['label' => 'Flat rooflights', 'url' => home_url('/flat-rooflights/'), 'meta' => 'Fixed, opening and walk-on'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'french-doors-or-patio-sliders' => [
            'title' => 'French doors or patio sliders for a smaller opening',
            'publish_date' => '2027-04-12',
            'title_tag' => 'French Doors Or Patio Sliders For Smaller Openings | Fenster Glazing',
            'meta_description' => 'Under about 2.5 metres, the garden-door choice is really French doors against a patio slider. How swing space, glass area and daily habits decide it honestly.',
            'products' => ['french-doors', 'patio-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'All the garden-door attention goes to the great glass walls, but most British houses have an opening under two and a half metres, and down here the real contest is French doors against a patio slider. Both are honest, proven formats, and choosing between them is about your room, not about which is fancier.',
                    ],
                ],
                [
                    'heading' => 'What the opening size rules out.',
                    'body' => [
                        'Bifolds want width to earn their folding hardware, and below roughly 2.4 metres they spend your money on frames and hinges for panels too narrow to enjoy. That is why the classic aperture from a nineties dining room or a modest kitchen comes down to the hinged pair or the slider, and why we will say so rather than upsell a fold nobody needed.',
                    ],
                ],
                [
                    'heading' => 'The case for French doors.',
                    'body' => [
                        'Hinged doors open the entire aperture, corner to corner, with a flat accessible threshold and nothing parked in the view. One leaf works alone for the everyday letting-the-dog-out; both thrown open is the full summer gesture. Mechanically they are the simplest thing we fit, which shows up over the years as the least to go wrong.',
                        'The costs: the leaves swing, so furniture and pots must live outside their arc, and wind treats an open leaf as a sail, which is what restrictor stays are for. Glass area is decent but framed twice, once per leaf.',
                    ],
                ],
                [
                    'heading' => 'The case for the slider.',
                    'body' => [
                        'A patio slider trades opening width for glass. Its two panels are large and mostly glazing, so the closed view, which is the British default ten months a year, is garden rather than frame. Nothing swings, so a sofa can sit right beside it and the doorway works in a gale.',
                        'The costs: only one half of the aperture ever opens, the threshold carries a track underfoot, and the sliding gear deserves a clean track and the occasional service to stay light-fingered.',
                    ],
                ],
                [
                    'heading' => 'Deciding it in one evening.',
                    'body' => [
                        'Stand in the room and ask three questions. Where would swinging leaves collide with life? How much does the closed-door view matter against the fully open one? And who uses the threshold, since buggies, wheels and unsteady feet all prefer the flat sill on French doors. Then price both in the online tool; at these sizes the difference is usually modest, which frees the decision to be about living rather than budget.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Modest opening, big choice',
                'title' => 'Pick the format that suits the room shut and open.',
                'copy' => 'Both formats are priced in the tool against your actual sizes, and the survey settles thresholds, opening directions and glass. Either way the garden gets closer this summer.',
                'links' => [
                    ['label' => 'French doors', 'url' => home_url('/french-doors/'), 'meta' => 'The full-opening classic'],
                    ['label' => 'Patio doors', 'url' => home_url('/patio-doors/'), 'meta' => 'Big glass, nothing swinging'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Compare both in minutes'],
                ],
            ],
        ],

        'who-suits-tilt-and-turn-windows' => [
            'title' => 'Tilt and turn windows: who they actually suit',
            'publish_date' => '2027-04-19',
            'title_tag' => 'Who Tilt And Turn Windows Actually Suit | Fenster Glazing',
            'meta_description' => 'The continental window with two openings in one frame: tilt for secure ventilation, turn for cleaning from inside. Where it genuinely earns its place.',
            'products' => ['tilt-turn-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The tilt and turn is the continental habit that never fully caught on in Britain, which is a shame for the specific houses it suits perfectly. One frame, one handle, two completely different openings, and a shortlist of situations where nothing else does the job as well.',
                    ],
                ],
                [
                    'heading' => 'Two openings, one handle.',
                    'body' => [
                        'Turn the handle one way and the window tilts inward from the top, opening a secure ventilation gap along its head. Turn it further and the whole sash swings inward like a door, opening the frame completely into the room. The positions are mechanical and deliberate; there is nothing to remember beyond which way you turned.',
                        'Tilt is the everyday mode: air moving at the top of the room, rain kept out by geometry, and an opening that offers nothing useful to anyone outside.',
                    ],
                ],
                [
                    'heading' => 'The upstairs argument: cleaning and escape.',
                    'body' => [
                        'Swing the sash inward and the outside face of the glass presents itself to you, in the room, at arm\'s length. For upstairs windows, windows over conservatories and anywhere a ladder is unwelcome, that is the feature that sells the format on its own: every pane in the house cleanable from inside it.',
                        'The full turn opening is also generous and unobstructed, which is exactly what escape routes want, and worth weighing for upper bedrooms; the survey confirms what each room requires and the format meets it comfortably.',
                    ],
                ],
                [
                    'heading' => 'Flats, exposure and night air.',
                    'body' => [
                        'Above the ground floor the tilt mode becomes a security answer: ventilation you can leave while out or asleep without offering an opening worth anyone\'s time. The inward swing suits balconies and walkways where an outward sash would fight the space or the wind. And the continental gasket-and-lock engineering seals hard, which suits exposed elevations that punish lighter windows.',
                    ],
                ],
                [
                    'heading' => 'The honest trade-offs.',
                    'body' => [
                        'The sash opens into the room, so deep sills styled with plants and curtains that hug the frame both need a rethink on turn days. The frames run chunkier than a casement\'s, since the hardware does two jobs, so the look is more engineered than dainty; it reads best on modern houses and apartment buildings. And the mechanism deserves respect at the handle: positions changed with the window shut, not mid-swing.',
                        'For the ordinary front-of-house window on a traditional street, a casement usually still wins on looks. For upstairs, flats, exposure and the cleaning argument, tilt and turn is the quiet expert\'s choice.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Upstairs and awkward spots',
                'title' => 'The window that cleans from inside the room.',
                'copy' => 'If ladders, escape routes or leave-it-open ventilation are the problem, tilt and turn is probably the answer. Price it online and we will confirm the details room by room at survey.',
                'links' => [
                    ['label' => 'Tilt and turn windows', 'url' => home_url('/tilt-turn-windows/'), 'meta' => 'Openings, sizes and colours'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Compare against casements'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'heritage-aluminium-doors-steel-look' => [
            'title' => 'Heritage aluminium doors: the steel look, explained honestly',
            'publish_date' => '2027-04-26',
            'title_tag' => 'Heritage Aluminium Doors: The Steel Look | Fenster Glazing',
            'meta_description' => 'The black-framed, slim-gridded doors filling design magazines are usually aluminium, not steel. What heritage aluminium doors are and why they won.',
            'products' => ['heritage-aluminium-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The door every renovation account posts, black slender frames, fine glazing bars, glass to the floor, is called a steel door and is usually nothing of the sort. Genuine steel glazing is beautiful, bespoke and priced accordingly. The look that conquered kitchens is mostly heritage aluminium, and it is worth understanding what you are actually buying.',
                    ],
                ],
                [
                    'heading' => 'Where the look comes from.',
                    'body' => [
                        'The style quotes the metal-framed windows and doors of factories, studios and inter-war houses: thin frames only steel could manage, divided into small panes because glass came small. Crittall is the famous name, which is why the whole genre gets called the Crittall look regardless of who made it.',
                        'Modern aluminium systems recreate those proportions deliberately, with slim sightlines and applied or structural glazing bars laying the grid across modern double glazing. The ones we fit run 60.5mm sightlines, which is what makes the silhouette read as period metal rather than modern frame.',
                    ],
                ],
                [
                    'heading' => 'Why aluminium rather than steel.',
                    'body' => [
                        'Steel is the original and still the bespoke option, made to order at bespoke prices, with the maintenance habits of steel. Aluminium delivers the same visual language with a thermal break inside the profile, modern gaskets and locking, powder-coated colour that never needs painting, and a price that belongs to home renovation rather than architecture prizes.',
                        'From across a kitchen, honestly, you are not telling them apart. Up close the aluminium door is the one whose glass is quietly a modern sealed unit meeting current regulations.',
                    ],
                ],
                [
                    'heading' => 'Where the style earns its drama.',
                    'body' => [
                        'Internally, a heritage-gridded pair between kitchen and snug turns a wall into a feature while keeping light moving through the house; it is the most requested version of the look. To the garden, single and French formats do the classic black-frame elegance, and the grid carries surprisingly well on period and modern houses alike, which is the trick that made the style ubiquitous.',
                        'The colour convention is black first, bronze and anthracite close behind, but the powder-coat palette is wide; ours runs to twelve colours, and a deep green or burgundy grid on the right house beats the default beautifully.',
                    ],
                ],
                [
                    'heading' => 'Buying it well.',
                    'body' => [
                        'Two details decide whether the door looks the part: the sightlines, where slimmer is the whole point, and the bars, where a proper grid with depth and shadow beats a flat stuck-on lattice. Both are specification questions settled at order, which is exactly the conversation a survey and a showroom visit are for.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The magazine door',
                'title' => 'The steel look, with modern engineering behind it.',
                'copy' => 'Nine stocked configurations, twelve colours and the slim grid that makes the style. Price it online, then come and stand in front of one at the showroom before you decide.',
                'links' => [
                    ['label' => 'Heritage aluminium doors', 'url' => home_url('/heritage-aluminium-doors/'), 'meta' => 'Configurations and colours'],
                    ['label' => 'Aluminium doors', 'url' => home_url('/aluminium-doors/'), 'meta' => 'The wider aluminium range'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'ordering-bifolds-for-summer' => [
            'title' => 'Ordering bifolds for summer: how the timing really works',
            'publish_date' => '2027-05-03',
            'title_tag' => 'Ordering Bifold Doors For Summer | Fenster Glazing',
            'meta_description' => 'Bifolds are surveyed, then manufactured to the millimetre in your colour and glass. What happens between ordering in May and opening the wall in summer.',
            'products' => ['aluminium-bifold-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'May is when bifold intentions get serious, and the most useful thing we can tell you is what actually happens between deciding and sliding the wall open. Not sales urgency, just the real sequence, so the timing is yours to plan instead of ours to apologise for.',
                    ],
                ],
                [
                    'heading' => 'Why there is no bifold warehouse.',
                    'body' => [
                        'Every bifold we fit is manufactured for its exact opening: the aperture measured to the millimetre at survey, panels balanced across it, your colour powder-coated, your glass specification sealed into units. That is why the doors fit and run the way showroom doors do, and it is also why the wait between order and fitting is manufacture, not stock-picking.',
                        'We confirm the expected timescale when the order is placed, because it genuinely varies with colour, glass and the factory\'s season. What we can promise in a blog is only the shape of the process.',
                    ],
                ],
                [
                    'heading' => 'The decisions that are yours to make early.',
                    'body' => [
                        'Panel count and folding direction: which way the stack parks, and whether a single traffic door lets you nip out without folding anything. Colour inside and out, which can differ. Threshold: flush to the floor for the barefoot summer look, or weathered for full exposure. Glass: solar control if the opening faces south, obscure panels if the neighbours are close.',
                        'Each of these is fixed at manufacture. The couple of days spent deciding them well is the highest-value part of the whole project.',
                    ],
                ],
                [
                    'heading' => 'Survey and fitting, briefly.',
                    'body' => [
                        'The technical survey checks the structural opening, the lintel above it, levels, drainage and how the floor finishes meet the threshold; on a new extension this happens as soon as the opening exists. Fitting itself is typically a focused day or two: frame in, panels hung, hardware balanced, and the final hour spent on the adjustments that make panels glide rather than merely move.',
                        'Then the part nobody warns you about: the first month, the doors get used constantly and the house rearranges itself around an open wall. Budget for one more piece of garden furniture.',
                    ],
                ],
                [
                    'heading' => 'The May arithmetic.',
                    'body' => [
                        'Order chains started in late spring generally deliver their summer; chains started at the first heatwave deliver someone\'s summer, possibly next year\'s. If the bifold is this year\'s project, the survey belongs in the diary now, and the online price is tonight\'s job.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Wall open by summer?',
                'title' => 'Start the made-to-order chain this month.',
                'copy' => 'Price the opening online, get surveyed, and the manufacture happens while June arrives. The timescale is confirmed honestly at order, and the doors are run in before the first proper barbecue.',
                'links' => [
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'Panels, colours and thresholds'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                    ['label' => 'Book a consultation', 'url' => home_url('/book-a-consultation/'), 'meta' => 'Talk the opening through at home'],
                ],
            ],
        ],

        'keeping-bedrooms-cool-in-summer' => [
            'title' => 'Keeping bedrooms cool in summer: glass, vents and shading',
            'publish_date' => '2027-05-10',
            'title_tag' => 'Keeping Bedrooms Cool In Summer | Fenster Glazing',
            'meta_description' => 'Hot bedrooms are a glazing problem before they are a fan problem. How solar control glass, night ventilation and shading tame south and west facing rooms.',
            'products' => ['windows', 'integral-blinds'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The first warm spell of May finds the hot bedrooms, and by July they are unbearable at bedtime for the same physical reasons every year. Fans move the heat around; the actual levers are the glass, the ventilation pattern and the shading, and all three are improvable.',
                    ],
                ],
                [
                    'heading' => 'Why bedrooms overheat on schedule.',
                    'body' => [
                        'West and south facing rooms bank solar energy through their glass all afternoon, into walls, carpets and the mattress itself, then release it exactly when you want the room cooling down. Upstairs rooms also collect the whole house\'s rising warmth. That is why the bedroom is hotter at eleven at night than the garden is, and why the fan feels like it is losing: it is fighting stored heat, not air temperature.',
                    ],
                ],
                [
                    'heading' => 'The glass is the intake valve.',
                    'body' => [
                        'Solar control glazing reflects a large share of the sun\'s heat before it enters, while keeping the room bright; it is the same specification logic as a roof lantern over a kitchen, applied to a west-facing bedroom window. If a bedroom window is being replaced anyway, facing south or west, specifying solar control glass costs a conversation at order and works every afternoon for decades.',
                        'It is a between-the-panes property, so a failed or dated unit in a sound frame can be swapped for a solar control unit without changing the window.',
                    ],
                ],
                [
                    'heading' => 'Ventilate on the night shift.',
                    'body' => [
                        'The classic mistake is windows wide open through the hot afternoon, importing heat, then shut at bedtime for security. The winning pattern is the reverse: shaded and closed against the afternoon peak, then opened wide from evening to morning while the outside air is cooler than the room. Cross-ventilation, two openings on different walls or floors, moves multiples of what one window manages.',
                        'Security is what makes the night half difficult, and it is a solvable specification: night-vent locking positions on casements hold a window secure on a small opening, and tilt and turn windows make leave-it-open-all-night genuinely reasonable above the ground floor.',
                    ],
                ],
                [
                    'heading' => 'Shade before the glass, not after.',
                    'body' => [
                        'Any shading beats none, but position matters: stopping sun before or at the glass beats absorbing it in a curtain that then radiates into the room. Integral blinds, sealed inside the unit, drop that shade at the glass line itself without a dusty slat in sight, and they never flap over an open window the way curtains do on the crucial ventilating nights. For garden-facing bedroom doors they are the tidy answer to both problems at once.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Hot room, every year',
                'title' => 'Fix the bedroom before July does its thing.',
                'copy' => 'Solar control glass, night-vent security and integral blinds are all specification choices we can make for the rooms that cook. Tell us which windows face the afternoon sun.',
                'links' => [
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Specified for the room\'s aspect'],
                    ['label' => 'Integral blinds', 'url' => home_url('/integral-blinds/'), 'meta' => 'Shade sealed inside the glass'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Solar control into existing frames'],
                ],
            ],
        ],

        'cat-flap-in-a-glass-door' => [
            'title' => 'A cat flap in a glass door: how it is actually done',
            'publish_date' => '2027-05-17',
            'title_tag' => 'Cat Flap In A Glass Door: How It Works | Fenster Glazing',
            'meta_description' => 'You cannot cut a hole in toughened double glazing. A flap in a glass door means a new sealed unit made with the aperture built in. How the job really works.',
            'products' => ['cat-and-dog-flaps', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Every spring the kitten arrives, and a few months later somebody stands in front of a fully glazed back door wondering who cuts the hole. The honest answer is that nobody does, because you cannot cut toughened glass after manufacture. The job is done a different way, it is routine, and it is worth understanding before you book anyone.',
                    ],
                ],
                [
                    'heading' => 'Why the glass cannot be cut.',
                    'body' => [
                        'Door glazing is toughened safety glass, tempered under heat so that it crumbles into granules rather than shards if it ever breaks. That temper is also why it cannot be drilled or cut afterwards; interfere with a toughened pane and it does not take a neat hole, it takes the whole pane. And a double glazed unit is a sealed assembly besides, so any opening through it would kill the seal even if the glass allowed it.',
                    ],
                ],
                [
                    'heading' => 'What actually happens instead.',
                    'body' => [
                        'We measure your existing sealed unit and have a new one manufactured with the flap aperture built in at the factory, the hole formed before the glass is toughened, then the unit sealed around it. The new unit goes into your existing door, the flap fits the aperture, and the door is otherwise exactly as it was: same frame, same handles, same warmth around the flap itself.',
                        'Doors with a solid lower panel are the simpler case; a panel can be cut on site, which is one reason we ask what the door is made of before quoting. Glass means a made-to-order unit; panel means a neat cut and fit.',
                    ],
                ],
                [
                    'heading' => 'Standard or microchip.',
                    'body' => [
                        'A standard flap lets anything cat-sized through, which in some gardens means next door\'s cat eating first. Microchip flaps read your pet\'s chip and unlock for your animals only, which settles the food theft, the unwanted visitor and the neighbourhood tom in one specification decision. We fit both, and we are approved SureFlap installers, which is the microchip name most people arrive asking about.',
                        'Dogs are welcome in this conversation too: larger flaps for glass and panels exist, sized at order against the actual dog rather than optimism.',
                    ],
                ],
                [
                    'heading' => 'Booking it sensibly.',
                    'body' => [
                        'Because the glass unit is made to order, the flap job has a short manufacture wait; we confirm the timing when we have measured. If the existing unit is misted or tired anyway, this is the moment to renew it, since the new unit is being made regardless, and the upgrade rides along for the cost of the better specification alone.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Pet at the door',
                'title' => 'Measure once, and the flap arrives built into the glass.',
                'copy' => 'Tell us whether the door is glazed or panelled and roughly what size the pet is, and we will handle the unit, the flap and the fitting in one tidy job.',
                'links' => [
                    ['label' => 'Cat and dog flaps', 'url' => home_url('/cat-and-dog-flaps/'), 'meta' => 'Standard and microchip options'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Renew a tired unit while you are at it'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Describe the door, get a straight answer'],
                ],
            ],
        ],

        'how-lift-and-slide-doors-work' => [
            'title' => 'How lift and slide doors work, and why the handle matters',
            'publish_date' => '2027-05-24',
            'title_tag' => 'How Lift And Slide Doors Work | Fenster Glazing',
            'meta_description' => 'A lift and slide door lifts off its seals to glide, then drops back down to lock tight. The mechanism explained, and what the big handle really does.',
            'products' => ['aluminium-sliding-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Big sliding doors have a physics problem: a panel heavy enough to carry that much glass has to press hard into its seals to be weathertight, and anything pressed hard into seals does not want to slide. The lift and slide mechanism is the elegant answer, and once you know what the handle is doing, the whole door makes sense.',
                    ],
                ],
                [
                    'heading' => 'The trick: two positions, not one.',
                    'body' => [
                        'Turn the big handle down and the mechanism lifts the entire panel a few millimetres, up off its gaskets and onto its rollers. In that raised state the door is free, and a pane weighing as much as a person glides with two fingers. Slide it where you want it, including partway, turn the handle back, and the panel sets down onto its seals again: compressed, weathertight and mechanically parked.',
                        'That is the difference from an ordinary slider, which rolls in permanent light contact with its seals. The lift and slide is either sealed or moving, never compromising between the two.',
                    ],
                ],
                [
                    'heading' => 'What that means day to day.',
                    'body' => [
                        'Set down, the door seals harder than a conventional slider can, which shows in weathertightness on exposed elevations and in how solidly the closed door ignores wind. It also parks anywhere: lowered mid-track, the panel is fixed in place, which turns a two-metre pane into a controllable ventilation gap that a gust cannot slam.',
                        'The action itself is the showroom moment. People expect a heave and get a glide, then spend a minute lifting and setting the panel just to feel the mechanism work.',
                    ],
                ],
                [
                    'heading' => 'Why the handle is the tell.',
                    'body' => [
                        'The long lever handle is the giveaway and the working part: it drives the lifting gear, so it is sized for leverage and it stays parallel with the door when closed rather than sitting like a latch. It is also the part your hand meets every day, which is why we treat the handle finish as a real decision rather than an afterthought; the finishes are chosen alongside the frame colour at order.',
                    ],
                ],
                [
                    'heading' => 'Choosing it over a standard slider.',
                    'body' => [
                        'The lift and slide earns its premium where the panels are biggest, the weather is most exposed, and the park-anywhere ventilation matters. A quality conventional slider remains the right answer for plenty of openings, and both live on our aluminium sliding door range, priced against your actual sizes. The survey and a showroom visit settle it better than any comparison table.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Glass walls that glide',
                'title' => 'Feel the mechanism before you choose it.',
                'copy' => 'Lift and slide is a thing hands understand faster than words. Price the opening online, then come and work the handle at the showroom before the survey settles the details.',
                'links' => [
                    ['label' => 'Aluminium sliding doors', 'url' => home_url('/aluminium-sliding-doors/'), 'meta' => 'Sliders and lift and slide'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Showroom hours and directions'],
                ],
            ],
        ],

        'what-roofline-actually-does' => [
            'title' => 'Fascias, soffits and guttering: what roofline actually does',
            'publish_date' => '2027-05-31',
            'title_tag' => 'What Fascias, Soffits And Guttering Do | Fenster Glazing',
            'meta_description' => 'Roofline is the unglamorous plastic and timber where roof meets wall, and it quietly protects the whole house. What each part does and the signs it is failing.',
            'products' => ['roofline'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Nobody daydreams about fascias. But the strip of material where your roof meets your walls is protecting the rafters, the loft and the brickwork below it every wet day of the year, and when it fails it fails expensively. Here is what the parts actually do, in the plain terms the trade rarely bothers with.',
                    ],
                ],
                [
                    'heading' => 'The cast, from the gutter inward.',
                    'body' => [
                        'The fascia is the vertical board along the roof edge; it carries the guttering and caps the ends of the rafters, which is the structural timber it exists to protect. The soffit is the horizontal board tucked underneath, closing the gap between fascia and wall so weather and birds stay out of the roof. Bargeboards are the same idea running up the gable ends. The guttering hangs off the lot, moving roof water away from the walls.',
                        'Together they are the house\'s raincoat collar. Individually cheap materials, collectively guarding the most awkward-to-repair timber in the building.',
                    ],
                ],
                [
                    'heading' => 'How it fails, and what that costs.',
                    'body' => [
                        'Timber roofline rots, usually from the top edge where you cannot see it, and rot spreads from board to rafter quietly. Painted boards need scaffolding-grade access every few years, which is why they rarely get painted and rot on schedule. Failed or sagging gutters overflow down the wall instead of the downpipe, and years of that shows up indoors as the damp patch nobody can explain.',
                        'The warning signs from ground level: peeling or spongy-looking boards, green streaks on walls under the gutter line, sparrows disappearing into the eaves, and gutters that drip long after the rain stopped.',
                    ],
                ],
                [
                    'heading' => 'What replacement involves.',
                    'body' => [
                        'A proper roofline replacement strips the old boards back to sound timber rather than cladding over rot, replaces any rafter ends that need it, then fits uPVC fascias, ventilated soffits and new guttering. The ventilation detail matters: lofts need airflow to stay dry, and modern soffit systems build it in where old boards relied on leaky luck.',
                        'The result is a roof edge that needs washing rather than painting, sized gutters that actually cope with the rain we get now, and rafters that stay dry inside their plastic collar for decades.',
                    ],
                ],
                [
                    'heading' => 'When to deal with it.',
                    'body' => [
                        'Dry season is roofline season: the work is outside, at height, and pleasant weather makes for a better job of it. If your boards are flaking now, this is the summer job that prevents the winter damp patch, and it pairs naturally with any window work since the house is being measured and accessed anyway.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The roof\'s edge',
                'title' => 'Sort the raincoat collar in the dry months.',
                'copy' => 'If the boards look tired from the pavement, they are worse up close. We will inspect, tell you what is sound and what is not, and quote the honest scope rather than the maximum one.',
                'links' => [
                    ['label' => 'Roofline services', 'url' => home_url('/roofline/'), 'meta' => 'Fascias, soffits and guttering'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Book an inspection'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Pair it with the small fixes'],
                ],
            ],
        ],

        'why-window-quotes-vary' => [
            'title' => 'Why quotes for the same windows vary so much',
            'publish_date' => '2027-06-07',
            'title_tag' => 'Why Window Quotes Vary So Much | Fenster Glazing',
            'meta_description' => 'Three quotes for one house can land thousands apart. What is genuinely different between them, what is sales theatre, and how to compare window quotes properly.',
            'products' => ['windows', 'double-glazing'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Get three quotes for the same house and the numbers can land absurdly far apart, which leaves most people suspecting all three. Some of the spread is real differences in what is being sold. A lot of it is how the industry prices. Knowing which is which is the entire skill of buying windows well.',
                    ],
                ],
                [
                    'heading' => 'The legitimate differences.',
                    'body' => [
                        'Specification moves money honestly: frame system and reinforcement, glass coatings and spacers, hardware quality, colour and foils, and whether the price includes making good, waste disposal and the building regulations certification. Installation quality is real too; a good survey and careful fitters cost more than a subcontracted rush, and the difference lives in your walls for decades.',
                        'That is why quotes only compare once the specification is written down line by line. A cheaper quote for thinner glass, standard cylinders and no certification is not the same product at a better price; it is a different product.',
                    ],
                ],
                [
                    'heading' => 'The theatre.',
                    'body' => [
                        'The industry\'s bad habit is the invented discount: an opening number designed to be halved by a manager\'s phone call if you will sign tonight. The final figure was the real price all along; the rest was choreography, and its purpose is to stop you comparing anything calmly.',
                        'Our answer to it is structural rather than rhetorical: the price is on the website. One number for the job, not an online teaser and a different figure at the door. You can build your windows in the quote tool tonight and see what we would actually charge, before anyone has sat on your sofa.',
                    ],
                ],
                [
                    'heading' => 'How to compare quotes properly.',
                    'body' => [
                        'Insist on the specification in writing: system, glass, hardware, colour, certification, guarantee, and exactly what happens to the old frames and the mess. Ask every quoter the same questions and watch which answers arrive in sentences rather than brochures. Ignore any price that expires when the salesperson leaves; a real price survives a week of thinking.',
                        'Then weigh the installer as heavily as the product. Who surveys, who actually fits, who answers the phone in year six: those are specification items too, just unwritten ones.',
                    ],
                ],
                [
                    'heading' => 'What we will put against anyone.',
                    'body' => [
                        'Our price is public in the tool, the specification is stated, the installation is by our own fitters, the job is FENSA certificated, and new windows and doors carry the ten year guarantee. Compare that line by line with any quote on the table; that comparison is one we are happy to lose the theatrical rounds of.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Comparing quotes?',
                'title' => 'Start with a price nobody has to perform for.',
                'copy' => 'Build the job in the online tool and you have our real number in minutes, specification attached. Put it next to the others and ask each of them the same written questions.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'The public number, tonight'],
                    ['label' => 'Why trust Fenster', 'url' => home_url('/why-trust-fenster/'), 'meta' => 'Guarantees and accreditations'],
                    ['label' => 'Replacement windows', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'The ranges, specified openly'],
                ],
            ],
        ],

        'front-door-colours-that-last' => [
            'title' => 'Front door colours you will still like in ten years',
            'publish_date' => '2027-06-14',
            'title_tag' => 'Choosing A Front Door Colour That Lasts | Fenster Glazing',
            'meta_description' => 'A composite door colour is a decade-plus commitment. How to choose against your brick and street rather than a showroom wall, and when to be bold.',
            'products' => ['composite-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A painted timber door forgives a colour mistake; a composite door\'s colour is baked into a skin that will still be exactly that colour when the toddler leaves for university. That permanence is a feature, not a trap, but it changes how the decision deserves to be made.',
                    ],
                ],
                [
                    'heading' => 'Choose against the house, not the swatch.',
                    'body' => [
                        'The colour never appears alone. It sits inside your brick or render, beside your window frames, under your porch light, and the same green reads garden-gate charming against buff brick and municipal against red. Take samples to the actual doorstep and look at them at midday and again at dusk, because low light shifts colours more than showrooms admit.',
                        'The frame around the door is its own decision, and white frames with a coloured slab is the combination that keeps bolder colours from swallowing the whole entrance.',
                    ],
                ],
                [
                    'heading' => 'What time does to the fashionable choice.',
                    'body' => [
                        'Every era has a door colour, and the surrounding streets are a museum of previous ones. The way to use fashion without being dated by it: let trend pick between finalists rather than nominate them. If a colour only makes the shortlist because this year\'s feeds are full of it, it fails the ten year test by definition.',
                        'The perennials earn their reputation: deep blues, racing and sage greens, burgundy, classic black and quiet anthracite all age with the street rather than against it. Within those families there is plenty of room to be yours rather than beige.',
                    ],
                ],
                [
                    'heading' => 'The practical notes nobody mentions.',
                    'body' => [
                        'Dark colours on sun-baked south elevations run hot, and quality door engineering accounts for that; it is a survey detail rather than a reason for fear, but it is worth saying out loud if your heart is set on black in full sun. Very pale colours show boot scuffs and paw prints sooner around the bottom rail. And the furniture, handle, knocker and letterplate finish, changes a colour\'s character more cheaply than changing the colour.',
                    ],
                ],
                [
                    'heading' => 'Commit with confidence, not caution.',
                    'body' => [
                        'The ten year rule is not an argument for grey. A front door is the one place a house gets to have a personality per square metre, and the well-chosen bold door is usually the best thing on the street. Choose slowly, against the real brick, in real light, and then be brave; the door will hold its nerve longer than you will.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The decade decision',
                'title' => 'See the colours on a real door, in real light.',
                'copy' => 'The composite range runs from the perennials to the properly bold, with frame and furniture choices that change everything. Price the door online, then come and stand in front of the colours.',
                'links' => [
                    ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'Styles, colours and glazing'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Showroom hours and directions'],
                ],
            ],
        ],

        'check-the-windows-before-you-buy-a-house' => [
            'title' => 'Buying a house? Check the windows before you offer',
            'publish_date' => '2027-06-21',
            'title_tag' => 'Check The Windows Before Buying A House | Fenster Glazing',
            'meta_description' => 'Windows are one of the few big-ticket items you can assess at a viewing without tools. A buyer\'s ten-minute check and what each finding is worth.',
            'products' => ['windows', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Moving season peaks in summer, and viewings reward the buyer who looks past the staging. Windows are one of the few genuinely expensive items you can assess yourself in ten minutes with no tools, and what you find belongs in your offer arithmetic rather than in your first month\'s surprises.',
                    ],
                ],
                [
                    'heading' => 'The ten-minute viewing check.',
                    'body' => [
                        'Look through the glass at an angle in every room: fog, milkiness or streaks trapped between panes means failed units, and each one is a replacement. Open a window in each elevation; stiffness, drops and handles that need persuading are hardware age showing. Look at gaskets for shrinkage and corners for mould shadows, which tell you about cold surfaces and condensation history.',
                        'Outside, sight along the frames: flaking timber, bowed sills, cracked silicone and moss lines under the gutters all speak. Mismatched windows tell you replacement happened piecemeal, which is normal, but ask when and by whom.',
                    ],
                ],
                [
                    'heading' => 'Ask for the paperwork by name.',
                    'body' => [
                        'Replacement windows fitted since 2002 should have building regulations sign-off, usually a FENSA certificate, and any surviving guarantees. Ask the agent for both. Missing certificates are rarely fatal, replacements can be ordered and indemnity policies exist, but the asking itself tells you how the house has been kept, and the answer arrives before your solicitor would have found it.',
                    ],
                ],
                [
                    'heading' => 'Pricing what you found.',
                    'body' => [
                        'A misted unit here and a stiff handle there are hundreds, not thousands; useful negotiation notes, not alarm bells. A house full of failing frames or original single glazing is a real line in your budget, and worth pricing properly rather than guessing: our online tool will put numbers on a full replacement in an evening, using the room sizes from the listing floorplan for a first pass.',
                        'That number is negotiating information either way, whether it trims the offer or simply enters year-one planning with its eyes open.',
                    ],
                ],
                [
                    'heading' => 'After the keys.',
                    'body' => [
                        'First month in: change what needs changing on security grounds, get the failed units and dead locks sorted while the boxes are still packed, and let a full replacement decision wait for a winter in the house, which will rank the windows for you honestly. We do the small jobs as gladly as the big ones, which is exactly what a new house tends to need first.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'New keys, old windows?',
                'title' => 'Price the findings before or after you offer.',
                'copy' => 'Use the tool for the big number, and send us the small list once you have the keys. Failed units, tired locks and dropped doors are quick first-month fixes.',
                'links' => [
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Budget the worst case in an evening'],
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'The first-month fix list'],
                    ['label' => 'Replacement double glazing', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Misted units from the viewing'],
                ],
            ],
        ],

        'slide-and-fold-doors-smaller-spaces' => [
            'title' => 'Slide and fold doors: the folding option for practical openings',
            'publish_date' => '2027-06-28',
            'title_tag' => 'Slide And Fold Doors Explained | Fenster Glazing',
            'meta_description' => 'Slide and fold doors move along a track and fold to stack, opening most of the aperture. Where they fit between French doors and premium bifolds, honestly.',
            'products' => ['slide-fold-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Between classic French doors and the premium aluminium bifold sits a format fewer people know to ask about: the slide and fold door. Panels slide along a track and fold to stack at the side, opening most of the wall, with a practicality-first character that suits real family kitchens and sensible budgets.',
                    ],
                ],
                [
                    'heading' => 'How the format works.',
                    'body' => [
                        'Like a bifold, the panels are hinged in sequence and gather at one end when open; the everyday difference is in the running gear and the way panels are moved, sliding along the track and folding as they go. Configurations run from three panels upward, and most set-ups include a lead door that opens on its own for the hundred daily trips that do not deserve a full fold.',
                        'Closed, it behaves like any modern glazed door wall: multi-point locking into the frame, sealed panels, and glass specified at order like every unit we fit.',
                    ],
                ],
                [
                    'heading' => 'What it does well.',
                    'body' => [
                        'Opened right up, the room gets most of the aperture, which is the whole folding-door promise: the kitchen and the garden joining for the afternoon. The stacked panels need their parking space at one end, so the survey conversation covers where the stack lives and which way the fold runs, exactly as it does for any folding format.',
                        'The value case is honest rather than shameful. For a family after the open-wall summer without the premium aluminium ticket, slide and fold is frequently the right-sized answer, and we would rather fit the format that matches the budget than talk anyone upward on principle.',
                    ],
                ],
                [
                    'heading' => 'The trade-offs, stated plainly.',
                    'body' => [
                        'More panels means more frame in the closed view, so a slide and fold shows more sightline than a big slider and the glass reads as a rhythm of panes rather than a single sheet. The folding hardware, as on any bifold, likes a clean track and an occasional service. And on very wide or very exposed openings, the heavier engineering of the aluminium systems starts earning its premium back.',
                    ],
                ],
                [
                    'heading' => 'Choosing within the folding family.',
                    'body' => [
                        'The decision between slide and fold and a full aluminium bifold usually comes down to budget, opening size and how hard the doors will live. Price both against your actual aperture in the online tool, then let the survey and a showroom handle-feel settle it; the difference is easier felt than described.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The open wall, sensibly',
                'title' => 'Price the folding options against your real opening.',
                'copy' => 'Slide and fold against aluminium bifold is a budget and usage decision, not a status one. Both are in the tool, and the survey makes sure whichever you pick is built to the space.',
                'links' => [
                    ['label' => 'Slide and fold doors', 'url' => home_url('/slide-fold-doors/'), 'meta' => 'Configurations and glass options'],
                    ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'The premium folding system'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Compare both in minutes'],
                ],
            ],
        ],

        'holiday-window-and-door-security' => [
            'title' => 'Going on holiday: the window and door check before you fly',
            'publish_date' => '2027-07-05',
            'title_tag' => 'Holiday Window And Door Security Check | Fenster Glazing',
            'meta_description' => 'Two weeks away is the longest your locks work unsupervised all year. A pre-holiday walk-round for windows, doors and the garden, and the fixes first.',
            'products' => ['composite-doors', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The school holidays empty whole streets at once, and a fortnight away is the longest stretch your locks will ever work unsupervised. The pre-holiday check takes fifteen minutes, costs nothing, and beats every gadget bought in a panic at the airport.',
                    ],
                ],
                [
                    'heading' => 'Windows first, because summer forgets them.',
                    'body' => [
                        'Warm weeks leave windows habitually ajar, and the night flight is not the moment to remember which ones. Walk every room and lock every window with its key, including upstairs, since ladders live in gardens and flat roofs offer routes nobody considers at ground level. Bathroom and landing windows are the classics left open for airing and forgotten.',
                        'If any window will not lock, or its key has wandered since winter, that is this week\'s fix rather than a note for September.',
                    ],
                ],
                [
                    'heading' => 'Doors, done properly.',
                    'body' => [
                        'Every external door gets the full ritual: handle lifted firmly so the multi-point bolts throw, key turned, key removed. Include the garage side door, the shed and the gate, because the tools that open houses usually live thirty feet from them. If any door needs a shoulder, a jiggle or a special technique only you know, book the adjustment before you go; mechanisms partway through failing choose their moments badly, and a neighbour cannot coax a lock they have never met.',
                    ],
                ],
                [
                    'heading' => 'Make the house look lived in.',
                    'body' => [
                        'Lights on timers in the rooms that would naturally be lit, a neighbour parking on the drive occasionally and taking the bins round, post and parcels intercepted rather than accumulating. Say nothing public about the dates before or during; the holiday montage posts perfectly well from the sofa afterwards.',
                        'Leave the garden unhelpful too: ladders locked away, bins moved from beside fences, and the barbecue tools that double as pry bars back in the shed.',
                    ],
                ],
                [
                    'heading' => 'The insurance detail people learn too late.',
                    'body' => [
                        'Many policies expect doors and windows locked when the house is empty, and claims can founder on a window left on the latch or a door that was closed but never deadlocked. The fifteen-minute walk-round is also, quietly, you keeping your own policy honest. Fly relaxed; the house is doing its boring job.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Before the flight',
                'title' => 'Fix the lock with the special technique.',
                'copy' => 'A door that needs a knack is a claim dispute waiting to happen. Adjustments, cylinders and window keys are quick jobs in early July, and the phone lines are open around the clock while you are away.',
                'links' => [
                    ['label' => 'Window and door repairs', 'url' => home_url('/window-and-door-repairs/'), 'meta' => 'Locks, keys and adjustments'],
                    ['label' => 'Composite doors', 'url' => home_url('/composite-doors/'), 'meta' => 'When the door itself is the weak point'],
                    ['label' => 'Contact us', 'url' => home_url('/contact/'), 'meta' => 'Phone lines open 24/7'],
                ],
            ],
        ],

        'flush-casement-windows-cottage-look' => [
            'title' => 'Flush casement windows: the joinery look on a modern frame',
            'publish_date' => '2027-07-12',
            'title_tag' => 'Flush Casement Windows: The Joinery Look | Fenster Glazing',
            'meta_description' => 'Flush casements close level with the frame, the way traditional timber windows did. Why the flat-faced style suits period and modern homes, and how it differs.',
            'products' => ['flush-casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Stand across the road from a standard uPVC window and you can see the opening sash sitting proud of its frame, a little stepped shoulder on the face of the house. A flush casement closes level, one flat plane, the way joiners made windows for a couple of centuries. That single detail is the whole product, and it is why the style has quietly taken over new-build and renovation alike.',
                    ],
                ],
                [
                    'heading' => 'What flush actually means.',
                    'body' => [
                        'In a standard casement, the opening sash overlaps and stands proud of the outer frame; practical, weathertight and unmistakably modern uPVC. In a flush casement the sash closes into the frame until the faces align, giving a flat elevation with clean shadow lines. From the street it reads as timber joinery, which is precisely the illusion the style exists to perform.',
                        'Behind the flat face it is a fully modern window: double glazed, multi-point locked, gasketed and maintenance-free, available in uPVC and aluminium.',
                    ],
                ],
                [
                    'heading' => 'The houses it flatters.',
                    'body' => [
                        'Cottages, farmhouses and anything pre-war are the obvious home; flush casements with woodgrain foils and heritage colours replace tired timber without the parish noticing, which is why they carry so much conservation-area work. The surprise is the other end: on crisp modern houses the flat plane and slim shadow gaps read as contemporary minimalism, and plenty of new developments specify flush as standard for exactly that reason.',
                        'The style stretches further with the details: glazing bars for the Georgian rhythm, dummy sashes to keep every pane matching, and hardware from period pewter to bare modern.',
                    ],
                ],
                [
                    'heading' => 'Flush against standard, honestly.',
                    'body' => [
                        'The premium over a standard casement buys the elevation, not the engineering; warmth, security and lifespan are level between the two at like-for-like specification. So the question is how much the house\'s face matters to you and the street. On a period frontage the answer is usually a lot, and the flush window is the difference between replaced and restored at a glance. On an elevation nobody studies, standard casements spend the difference better elsewhere.',
                        'Mixing is legitimate: flush on the front where the house shows its face, standard behind, matched in colour. The survey keeps the sightlines and colours honest across both.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The flat-faced window',
                'title' => 'See flush and standard side by side.',
                'copy' => 'The difference is easier seen than described, and the showroom has both. Price the house online in either style and the premium becomes a real number instead of a maybe.',
                'links' => [
                    ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/'), 'meta' => 'Colours, bars and hardware'],
                    ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'The standard to compare against'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'Both styles, real numbers'],
                ],
            ],
        ],

        'french-casement-windows-full-opening' => [
            'title' => 'French casement windows: the full-opening option most people miss',
            'publish_date' => '2027-07-19',
            'title_tag' => 'French Casement Windows: The Full Opening | Fenster Glazing',
            'meta_description' => 'A French casement opens both sashes to one clear aperture with no fixed post in the middle. Why that matters for fire escape, furniture moves and summer air.',
            'products' => ['french-casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Most double windows hide a bar down the middle: open both sashes and a fixed mullion still divides the aperture in two. The French casement is the version without the bar. Open one sash, then the second, and the whole width clears in one uninterrupted opening. It is a small engineering difference with outsized practical value, and most people have never been offered one.',
                    ],
                ],
                [
                    'heading' => 'How it works without the post.',
                    'body' => [
                        'The trick is the flying mullion: the dividing post is attached to the second sash rather than the frame, so it swings away with it. Closed, the window looks like any handsome pair of casements and seals like one, each sash locking into the mullion as normal. Open, there is simply nothing in the middle.',
                        'It is an old French habit, hence the name, engineered into modern uPVC with the same glass, gaskets and locking as the rest of the casement family.',
                    ],
                ],
                [
                    'heading' => 'Where the clear opening earns its keep.',
                    'body' => [
                        'Fire escape is the serious argument. Escape windows need a clear openable area, and a full-width unobstructed aperture is about as good as an escape opening gets; for upstairs bedrooms, that can be the difference between a window that technically complies and one you would genuinely want in the moment. The survey confirms which rooms need escape provision, and this is one of the tidiest ways to provide it.',
                        'The civilian arguments are good too: sofas and mattresses pass through a clear opening during moves, and on a still July night the full width catches whatever breeze exists, which two half-openings never quite manage.',
                    ],
                ],
                [
                    'heading' => 'The look, while we are here.',
                    'body' => [
                        'A French casement brings a little of the French-door romance up to window height: the symmetry of the pair, both sashes thrown open on a summer morning. On period and cottage-styled houses it sits beautifully alongside flush casements, and glazing bars carry the traditional rhythm across it when the house asks for them.',
                    ],
                ],
                [
                    'heading' => 'Worth asking for by name.',
                    'body' => [
                        'Because the format is less known, it rarely appears in quotes unless requested, and wide single sashes or fixed-mullion pairs get specified where a French casement would have served the room better. If a bedroom needs escape provision, a wall needs its full width of air, or you simply like the both-doors-open gesture, ask for it by name and we will price it alongside the alternatives.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'No bar in the middle',
                'title' => 'The window that opens all the way.',
                'copy' => 'For escape rooms, awkward furniture and proper summer air, the French casement is the specification worth knowing exists. Price it with the rest of the house online.',
                'links' => [
                    ['label' => 'French casement windows', 'url' => home_url('/french-casement-windows/'), 'meta' => 'The flying mullion, explained'],
                    ['label' => 'Casement windows', 'url' => home_url('/casement-windows/'), 'meta' => 'The wider casement family'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],

        'aluminium-front-doors-modern-entrances' => [
            'title' => 'Aluminium front doors: the modern entrance, explained',
            'publish_date' => '2027-07-26',
            'title_tag' => 'Aluminium Front Doors For Modern Entrances | Fenster Glazing',
            'meta_description' => 'Wide, flat, architectural front doors are usually aluminium. What the material offers an entrance, how it compares with composite, and where it suits the house.',
            'products' => ['aluminium-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'The front doors on architectural self-builds and serious renovations, wide, flat, glazed down one edge, in a colour brochures call anthracite, are almost always aluminium. The material brings a specific set of strengths to an entrance, and knowing them is the difference between buying the look and buying the door.',
                    ],
                ],
                [
                    'heading' => 'What aluminium gives an entrance.',
                    'body' => [
                        'Rigidity is the headline. Aluminium holds dead-flat faces and crisp edges at sizes where other doors need visual tricks, which is what makes the wide, minimal, oversized entrance possible at all. The material also carries glazing confidently, from a slot of obscure glass to full side screens, and its powder-coated finish keeps colour crisp for decades with a wash-down rather than repainting.',
                        'Behind the face it is a modern thermal door: insulated core, thermally broken frame, multi-point locking and the same certification and guarantee as everything else we fit.',
                    ],
                ],
                [
                    'heading' => 'Aluminium against composite, fairly.',
                    'body' => [
                        'Composite is the traditionalist of the two: panelled styles, woodgrain skins, cottage and Victorian looks, at a friendlier price. Aluminium is the modernist: flat slabs, big formats, integrated pulls and glazing used graphically. Warmth and security are specification questions on both rather than a materials war, so the real chooser is the house\'s face and the budget.',
                        'On a Victorian terrace, composite usually wins the argument. On a rendered modern frontage or a serious remodel, aluminium is the door the architecture is asking for.',
                    ],
                ],
                [
                    'heading' => 'The details that make the look.',
                    'body' => [
                        'The doors people photograph get three things right: proportion, with the door sized generously rather than standard; restraint, one colour, one pull, glazing doing the decoration; and consistency, the door\'s colour and sightlines agreeing with the windows beside it. That last one is why entrance doors are best chosen alongside window decisions rather than after them, and why the survey looks at the elevation, not just the opening.',
                    ],
                ],
                [
                    'heading' => 'Buying one well.',
                    'body' => [
                        'Decide the glazing early, since side screens change the structural opening. Choose the pull handle at the door, not from a grid of thumbnails, because scale on a wide slab surprises people. And put the colour against your render and brick the way you would a front door colour in any material: at the house, in real light, at dusk as well as noon.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'The architectural entrance',
                'title' => 'Match the door to the elevation, not the brochure.',
                'copy' => 'Aluminium entrances are specified door, glazing and colour together against the house. Price it online, then bring the elevation photos and we will talk proportions properly.',
                'links' => [
                    ['label' => 'Aluminium doors', 'url' => home_url('/aluminium-doors/'), 'meta' => 'Entrances and garden doors'],
                    ['label' => 'Heritage aluminium doors', 'url' => home_url('/heritage-aluminium-doors/'), 'meta' => 'The gridded steel look instead'],
                    ['label' => 'See your price online', 'url' => home_url('/online-quote/'), 'meta' => 'A guide price in minutes'],
                ],
            ],
        ],
    ];
}

/**
 * A single post, or null when it does not exist or has not reached its
 * publish date. Pass $include_future = true for editorial tooling only —
 * never for routing, listing or sitemap output.
 */
function fenster_blog_post(string $slug, bool $include_future = false): ?array
{
    $posts = fenster_blog_posts();
    $post = $posts[$slug] ?? null;

    if (! is_array($post)) {
        return null;
    }

    if (! $include_future && ! fenster_blog_post_is_live($post)) {
        return null;
    }

    $post['slug'] = $slug;

    return $post;
}

function fenster_blog_post_is_live(array $post): bool
{
    $publish_date = (string) ($post['publish_date'] ?? '');

    return $publish_date !== '' && $publish_date <= current_time('Y-m-d');
}

/**
 * Published posts, newest first.
 */
function fenster_live_blog_posts(): array
{
    $live = [];

    foreach (fenster_blog_posts() as $slug => $post) {
        if (fenster_blog_post_is_live($post)) {
            $post['slug'] = $slug;
            $live[$slug] = $post;
        }
    }

    uasort($live, static fn (array $a, array $b): int => strcmp((string) ($b['publish_date'] ?? ''), (string) ($a['publish_date'] ?? '')));

    return $live;
}

/**
 * Images for a post, pulled from the product_media pools of the products the
 * post declares. Hero first, then gallery picks, deduplicated, capped at four
 * (the article template renders one hero and up to three inline figures).
 */
function fenster_blog_post_images(array $post): array
{
    $images = [];
    $seen = [];

    foreach ((array) ($post['products'] ?? []) as $product_slug) {
        $media = fenster_data('product_media.' . $product_slug, []);
        if (! is_array($media)) {
            continue;
        }

        $candidates = [];
        if (! empty($media['hero']['src'])) {
            $candidates[] = $media['hero'];
        }
        if (! empty($media['card']['src'])) {
            $candidates[] = $media['card'];
        }
        foreach ((array) ($media['gallery'] ?? []) as $gallery_image) {
            $candidates[] = $gallery_image;
        }

        foreach ($candidates as $candidate) {
            $src = (string) ($candidate['src'] ?? '');
            if ($src === '' || isset($seen[$src])) {
                continue;
            }
            $seen[$src] = true;
            $images[] = ['src' => $src, 'alt' => (string) ($candidate['alt'] ?? '')];
            if (count($images) >= 4) {
                return $images;
            }
        }
    }

    return $images;
}

/**
 * The full generated-page array for a live post, shaped for the existing
 * article pipeline. Null when the slug is not a live post, which leaves the
 * route a 404 until its publish date arrives.
 */
function fenster_blog_post_page(string $slug): ?array
{
    $post = fenster_blog_post($slug);
    if ($post === null) {
        return null;
    }

    return [
        'slug' => $slug,
        'title' => (string) $post['title'],
        'url' => home_url('/' . $slug . '/'),
        'sections' => (array) ($post['sections'] ?? []),
        'images' => fenster_blog_post_images($post),
        'links' => [],
        'next_steps' => (array) ($post['next_steps'] ?? []),
        'seo' => [
            'title_tag' => (string) ($post['title_tag'] ?? ($post['title'] . ' | Fenster Glazing')),
            'meta_description' => (string) ($post['meta_description'] ?? ''),
            'canonical' => 'https://fensterglazing.com/' . $slug . '/',
            'robots' => 'max-image-preview:large',
        ],
    ];
}
