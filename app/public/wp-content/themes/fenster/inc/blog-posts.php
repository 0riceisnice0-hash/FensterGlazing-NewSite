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
                    'heading' => 'Heat makes door panels grow',
                    'body' => [
                        'Every door material expands as it warms up, and a bifold has more panels, more hinges and more meeting points than any other door in the house. A long run of panels in direct afternoon sun picks up a surprising amount of heat, and each panel grows by a small amount. Add that growth up across three or four panels and the gaps the door was set up with start to close.',
                        'Dark colours absorb more heat than light ones, and south or west facing openings get the longest exposure. If your door only sticks late on sunny days and frees itself by morning, expansion is almost certainly what you are feeling.',
                    ],
                ],
                [
                    'heading' => 'The track matters as much as the panels',
                    'body' => [
                        'Bifolds run on rollers in a track, and summer is when tracks collect the most grit: dry soil, grass cuttings, sand and general garden traffic. Debris under a roller makes a door feel heavy long before anything is actually worn out.',
                        'Vacuum the track rather than sweeping it, because sweeping tends to push grit into the corners and under the rollers. A soft brush attachment gets into the channel. Avoid oiling the track itself; oil holds dust and makes the problem worse. If anything needs lubricating it is the hinges and locking points, and a silicone spray is the right thing there.',
                    ],
                ],
                [
                    'heading' => 'What you can safely check yourself',
                    'body' => [
                        'Clear and vacuum the track, then open and close the door slowly and watch where it catches. If one panel rubs at the top on hot days only, that is expansion. If the door drags along the bottom in all weathers, the rollers or the alignment need attention.',
                        'Check the gaskets too. Rubber seals soften in heat, and a seal that has come loose from its groove can fold over and act like a brake. A loose gasket can usually be pressed back in by hand.',
                    ],
                ],
                [
                    'heading' => 'When it needs an engineer',
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
                        'It is the most common worry we hear about roof lanterns, usually from someone standing in a bright kitchen in August: will all that overhead glass turn the room into a greenhouse? It is the right question to ask, and the honest answer is that it depends entirely on the glass specification — which is decided before the lantern is ordered, not after.',
                    ],
                ],
                [
                    'heading' => 'Why overhead glass is different from a window',
                    'body' => [
                        'A vertical window only faces the sun directly for part of the day. A roof lantern faces the sky all day, so in summer it collects sunlight from morning to evening. That is exactly why lanterns make rooms feel so much brighter than windows of the same area, and it is also why the glass choice matters more overhead than anywhere else in the house.',
                    ],
                ],
                [
                    'heading' => 'Solar control glass does the heavy lifting',
                    'body' => [
                        'Modern lantern glazing can carry a solar control coating: a metallic layer inside the sealed unit that reflects a large share of the sun\'s heat while letting the visible light through. The room stays bright, but much less of the energy lands as heat.',
                        'Solar control glass usually carries a light tint, most often a soft blue or neutral grey seen from outside, which also takes the harsh edge off direct glare. On the Sheerline S1 lanterns we fit, the glass specification is chosen per job — solar control, self-cleaning coatings and tint are all decided at the point of order.',
                    ],
                ],
                [
                    'heading' => 'Ventilation is the other half of the answer',
                    'body' => [
                        'Heat that does get in needs somewhere to go, and warm air collects at the highest point of the room, which under a lantern is the lantern itself. That is why the extension design around the lantern matters: opening doors or windows on two sides of the room lets the warm air actually leave rather than sit under the glass.',
                        'It is also worth thinking about at the design stage rather than after: a lantern over a kitchen that already runs warm from cooking deserves a more cautious glass specification than one over a north-facing dining room.',
                    ],
                ],
                [
                    'heading' => 'The winter side of the same question',
                    'body' => [
                        'The same engineering that manages summer heat matters in reverse from November. A lantern is a roof, and a poorly insulated one leaks heat all winter. The aluminium lantern systems we fit use thermally broken profiles — an insulating barrier inside the frame between the outside metal and the inside — alongside modern double glazing, so the lantern is not the cold spot in the room.',
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
            'meta_description' => 'External condensation on new double glazing is a sign the glass is insulating well, not a fault. What causes it, when it appears and the one type that is a problem.',
            'products' => ['casement-windows', 'double-glazing-replacement'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'From late August the first misty mornings arrive, and every year they bring the same worried phone calls: new windows, fitted months ago, suddenly fogged over — on the outside. It looks like a fault. It is actually the windows doing their job, and understanding why saves an unnecessary complaint or, worse, an unnecessary repair bill from someone less honest.',
                    ],
                ],
                [
                    'heading' => 'Why efficient glass mists on the outside',
                    'body' => [
                        'Condensation forms on any surface that is colder than the air around it, the same way a cold drink mists on a summer afternoon. An old, inefficient window leaks enough heat from the house to keep its outer pane slightly warm overnight, so dew never forms on it.',
                        'A modern double glazed unit holds the heat inside the room instead. The outer pane stays cold overnight because barely any heat is escaping through the glass to warm it. On a clear, still night at the end of summer, that cold outer pane drops below the dew point and mists over, exactly like the grass and car windscreens around it.',
                    ],
                ],
                [
                    'heading' => 'When it appears and when it clears',
                    'body' => [
                        'External condensation is most common in late summer and autumn, when nights are cool and clear but the air still carries plenty of moisture. You will usually see it in the early morning, often only on the windows facing open sky, and it clears on its own as the sun warms the glass — typically by mid-morning.',
                        'It may be patchy, misting some windows and not their neighbours. That is down to tiny differences in exposure, shelter and sky view, not a difference in the glass.',
                    ],
                ],
                [
                    'heading' => 'The condensation that IS a problem',
                    'body' => [
                        'Where condensation appears matters far more than how much of it there is. On the outside face: a sign of efficient glass, no action needed. On the inside face, in the room: the room needs more ventilation or less moisture, common in kitchens, bathrooms and bedrooms overnight.',
                        'Between the two panes, where you cannot wipe it: that is a failed sealed unit. The gap between the panes is meant to be sealed and dry, and misting inside it means the seal has gone. The unit will not recover, but it can be replaced on its own without changing the frame, which is a far smaller job than a new window.',
                    ],
                ],
                [
                    'heading' => 'A quick way to tell the three apart',
                    'body' => [
                        'Run a finger across the misted glass. If it wipes clear from inside the room, it is internal condensation and the answer is ventilation. If it wipes clear from outside, it is external condensation and the glass is performing well. If it will not wipe from either side, the mist is inside the unit and the sealed unit has failed — that one is for us.',
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
            'meta_description' => 'Not every draughty window needs replacing. A straightforward checklist for what can be fixed — seals, hinges, locks — and the signs the whole window is done.',
            'products' => ['window-and-door-repairs', 'casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A company that only sells new windows will tell you a draughty window needs replacing. We do repairs as well as replacements, so we can afford to be straight about it: a good share of the draughty windows we look at can be fixed for far less than the cost of a new window, and some cannot. Here is how to tell which yours is before anyone quotes you anything.',
                    ],
                ],
                [
                    'heading' => 'First, find where the draught actually gets in',
                    'body' => [
                        'On a breezy day, hold the back of your hand around the edge of the window, slowly, all the way round. The back of your hand feels air movement better than your palm. A lit candle moved around the frame shows the same thing if the air is still.',
                        'Note whether the cold air comes from between the opening part and the frame, from between the frame and the wall, or seems to come off the glass itself. Those three point to three completely different problems.',
                    ],
                ],
                [
                    'heading' => 'Draughts that are usually repairable',
                    'body' => [
                        'Air between the sash and the frame is the most common and the most fixable. The rubber gaskets that seal the window compress and harden over the years, and hinges drop so the window no longer pulls up square against its seals. New gaskets and a hinge adjustment restore the seal on most windows.',
                        'A window that needs slamming to lock, or that rattles in wind, usually needs its locking keeps adjusted or its hinges replaced rather than the whole window. Friction hinges are a standard replaceable part. If the handle no longer pulls the window in tight, the lock mechanism can be adjusted or swapped.',
                    ],
                ],
                [
                    'heading' => 'Draughts that point at the end of the road',
                    'body' => [
                        'If the frame itself has warped, cracked or opened at its corner joints, sealing around it is a patch, not a fix. Single glazed windows and early double glazing with failed units are usually not worth sequential repairs: by the time the seals, hinges and glass have all been done, a new window would have cost little more and performed far better.',
                        'The clearest sign is repetition. If you fixed a draught last winter and it is back, the window is moving or the material is past holding a seal. Money spent repairing it again is money towards the window you will end up buying anyway.',
                    ],
                ],
                [
                    'heading' => 'The honest middle ground',
                    'body' => [
                        'Plenty of houses have a mix: two or three windows genuinely done, the rest fixable. There is no rule that says a house does the whole lot at once. Replacing the worst windows and repairing the rest is a legitimate plan, and it spreads the cost across years instead of one bill.',
                        'When we survey, we will tell you which windows fall on which side of the line. Sometimes that survey ends with a repair sheet instead of a window order. That is fine with us — the replacement work comes back around when it is actually due.',
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
            'meta_description' => 'Cloudy double glazing you cannot wipe clean means the sealed unit has failed. Why it happens, why it will not recover and how replacement works without new frames.',
            'products' => ['double-glazing-replacement', 'window-and-door-repairs'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'A double glazed window that has gone permanently cloudy, foggy or streaky between the panes has not just got dirty — it has failed. The mist sits inside the sealed unit where no cloth can reach it, and it will not clear on its own. The good news is that fixing it almost never means buying a new window.',
                    ],
                ],
                [
                    'heading' => 'What a sealed unit actually is',
                    'body' => [
                        'The glass in a double glazed window is a factory-made sandwich: two panes bonded to a spacer bar around the edge, with the cavity between them sealed and dry. That dry gap is what does the insulating. Around the edge, the seal keeps moisture out, and a drying agent inside the spacer bar mops up any damp air that was trapped at manufacture.',
                        'The unit is a single component, separate from the frame that holds it. That distinction is the whole story when it comes to repair.',
                    ],
                ],
                [
                    'heading' => 'Why units fail',
                    'body' => [
                        'The edge seal lives a hard life. The glass expands and contracts with every warm day and cold night, flexing the seal season after season. Eventually it lets damp air creep in faster than the drying agent can absorb it, and once that drying agent is saturated, moisture condenses on the inside faces of the glass where you cannot touch it.',
                        'That is why misting starts as faint fogging in a corner on cold mornings, then spreads and eventually leaves permanent streaks and mineral marks. South-facing windows and units above radiators tend to go first, because they cycle through bigger temperature swings.',
                    ],
                ],
                [
                    'heading' => 'Why it matters beyond the view',
                    'body' => [
                        'A misted unit has lost its insulating gap to damp air, so it no longer performs the way it did new. The room loses more heat through that window, and the fog itself tends to arrive exactly when you would like the light: cold, bright mornings.',
                        'It does not fix itself, and drilling the glass or so-called demisting treatments only hide the symptom — the failed seal and saturated spacer are still there, and the fog comes back.',
                    ],
                ],
                [
                    'heading' => 'How replacement actually works',
                    'body' => [
                        'If the frame is sound, we measure the failed unit, have a new sealed unit made to that size and specification, and swap it into the existing frame. The frame, sill, handles and opening parts all stay. It is a fraction of the disruption of a window replacement, and the new unit brings current glass performance into the old frame.',
                        'This is also the moment to upgrade the glass itself if you want to: the replacement unit can carry modern low-emissivity coatings, acoustic glass or obscure patterns, whatever the room needs. If the frame has gone as well — warped, cracked or draughty around the edges — we will say so, because a new unit in a failed frame wastes the unit.',
                    ],
                ],
            ],
            'next_steps' => [
                'eyebrow' => 'Cloudy glass?',
                'title' => 'Replace the failed unit, keep the frame.',
                'copy' => 'If the mist is between the panes, the sealed unit needs replacing. We measure it, make it and fit it into your existing frame — and tell you honestly if the frame is past it.',
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
                        'Every January we take calls about doors that will not lock and windows that whistle, and most of them were quietly announcing the problem back in September. Twenty minutes with the checklist below, while the weather is still kind, catches nearly all of it — and the fixes are smaller, cheaper and easier to book before the cold arrives.',
                    ],
                ],
                [
                    'heading' => 'Walk the seals',
                    'body' => [
                        'Open each window and door and look at the rubber gasket that runs around it. You are looking for sections that have hardened, cracked, shrunk back at the corners or come loose from the groove. Press any loose lengths back in by hand.',
                        'Then close each one and check it pulls up snug against the seal. A sheet of paper closed in the door or window edge should grip when you pull it; if it slides out freely, that section is not sealing and will be a draught by November.',
                    ],
                ],
                [
                    'heading' => 'Work every handle and lock now, not in December',
                    'body' => [
                        'Locks fail at the coldest, least convenient moment because that is when the mechanism is stiffest and the door has swollen or shifted. In September, every handle should lift smoothly and every key should turn without force.',
                        'A handle that needs lifting with effort, a key that needs jiggling or a door you have to pull or shoulder to lock is telling you the mechanism and the frame are no longer lined up. That is an adjustment now, or a jammed door in January.',
                    ],
                ],
                [
                    'heading' => 'Clear the drainage',
                    'body' => [
                        'uPVC window and door frames have small drainage slots along the bottom edge that let rainwater out of the frame. Over summer they collect dust, moss and cobwebs. Blocked slots mean water sits inside the frame through winter, which is where mystery leaks and swollen sills come from.',
                        'Find the slots on the outside bottom edge and clear them with a thin plastic tool or a pipe cleaner. While you are down there, clear leaves out of door thresholds and patio door tracks.',
                    ],
                ],
                [
                    'heading' => 'Look for the early signs of bigger problems',
                    'body' => [
                        'Fog between the panes of glass that you cannot wipe off means a sealed unit has failed — it will get worse through winter and the window will lose heat faster. Hairline cracks in glass grow in cold weather. A door that scrapes its frame in September will likely stop locking after a wet October.',
                        'None of these mend themselves, and all of them are easier to sort in autumn than midwinter.',
                    ],
                ],
                [
                    'heading' => 'What to do with what you find',
                    'body' => [
                        'Loose gaskets, dirty tracks and blocked drainage are yours — ten minutes and no tools. Stiff locks, dropped hinges, failed units and doors that no longer meet their frames are ours: they need adjustment or parts, and they are quick jobs in autumn when the diary is not full of emergencies.',
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
            'meta_description' => 'What actually happens when you replace your windows: quote, technical survey, manufacture and fitting day, and what each stage decides. No mystery, no hard sell.',
            'products' => ['casement-windows', 'flush-casement-windows'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Most people replace windows once or twice in a lifetime, so the process is a mystery right up until it happens. If you are weighing it up for this autumn, here is the whole thing from first price to fitted windows — what happens at each stage, and which decisions actually matter.',
                    ],
                ],
                [
                    'heading' => 'Stage one: a price you can look at without commitment',
                    'body' => [
                        'The old-fashioned route starts with a salesperson on your sofa. Ours starts online: our quote tool prices windows and doors from your measurements and choices, so you can see realistic numbers before anyone visits. Rough measurements are fine at this stage — pricing works from approximate sizes, and nothing is manufactured from them.',
                        'This is the stage for comparing styles and materials against your budget: casement against flush casement, uPVC against aluminium, colour against cost. Change your mind freely; it costs nothing here.',
                    ],
                ],
                [
                    'heading' => 'Stage two: the technical survey',
                    'body' => [
                        'Once you want to go ahead, a surveyor measures every opening properly. This is the stage that makes made-to-measure mean something: brick-to-brick sizes, squareness, sill depths, reveal condition, trickle vent requirements and how each window opens and in which direction.',
                        'The survey is also where practical details get agreed rather than assumed: which rooms need obscure glass, where fire escape openings are required, how the existing sills and plaster will be treated. Everything the fitters do later is built from this document, so a careful survey is what a tidy fitting day looks like in advance.',
                    ],
                ],
                [
                    'heading' => 'Stage three: manufacture',
                    'body' => [
                        'Your windows are then made to those measurements. Made-to-order is why replacement windows are not an off-the-shelf, next-day product, and why the survey has to be right. We confirm the expected timescale when the order is placed rather than quoting a number here — it varies by product, colour and time of year, and we would rather tell you the true figure than a marketing one.',
                    ],
                ],
                [
                    'heading' => 'Stage four: fitting day',
                    'body' => [
                        'Fitting runs room by room: the old window comes out, the opening is cleaned up, the new frame goes in, gets fixed, sealed, and the room is closed off again before the next one is opened. Your house is not left open to the weather — each opening is out and refilled the same day.',
                        'Expect some dust and noise around each window for the hour or so it is being worked on, and clear a working space in front of each one before the team arrives. At the end, every window should open, close and lock smoothly, with the trims and sealant finished, and the old frames and glass leave with the fitters.',
                    ],
                ],
                [
                    'heading' => 'What decides whether the job goes well',
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
            'meta_description' => 'Composite and uPVC front doors compared honestly: warmth, security, colour, feel and cost logic — and which one actually suits your house before winter.',
            'products' => ['composite-doors', 'upvc-doors'],
            'sections' => [
                [
                    'heading' => '',
                    'body' => [
                        'Autumn is front door season. The draught you ignored all summer becomes obvious the first cold evening, and if a new door is going to happen before winter, the decision usually comes down to two candidates: composite or uPVC. We sell and fit both, so this is the comparison we give customers face to face rather than the one that steers you at the expensive option.',
                    ],
                ],
                [
                    'heading' => 'What the two doors actually are',
                    'body' => [
                        'A uPVC door is built like a uPVC window: a reinforced plastic frame with panels or glass filling it. A composite door is a solid slab construction — a dense core wrapped in a tough skin, usually finished to look like painted timber — hung in a frame.',
                        'The construction difference is what you feel. A composite door is noticeably heavier and closes with a more solid action; a uPVC door is lighter in the hand. Neither of those is automatically better, but people tend to have a strong preference within seconds of trying both, which is a good reason to visit a showroom before deciding.',
                    ],
                ],
                [
                    'heading' => 'Warmth and weather',
                    'body' => [
                        'Both door types seal well when properly fitted and adjusted — the gaskets and multi-point locks do that work on either door. The solid core of a composite gives the slab itself more insulation than a hollow uPVC panel, which matters most on exposed doorways that take direct wind and rain.',
                        'Fitting quality matters more than material here. A well-fitted uPVC door beats a badly fitted composite every time, because most heat loss around doors happens at the edges, not through the middle.',
                    ],
                ],
                [
                    'heading' => 'Looks, colour and how they age',
                    'body' => [
                        'This is where composite has pulled ahead in most streets: the timber-look skin, deeper colours and traditional styles suit older and character homes in a way flat uPVC panels struggle to match. Modern uPVC doors have improved, and in white or on a modern house the difference is much smaller.',
                        'Dark colours are worth a thought either way. They look sharp and they absorb more sun, which any door material has to be engineered for — another detail that gets checked at survey rather than left to luck.',
                    ],
                ],
                [
                    'heading' => 'Security and locks',
                    'body' => [
                        'Security is decided mostly by the locking hardware and the fitting, and both door types carry the same style of multi-point locks. The composite\'s heavier slab shrugs off brute force a little better, but a quality uPVC door with a good cylinder is a secure door. Whichever you choose, the cylinder — the part the key goes in — is the component worth asking about by name.',
                    ],
                ],
                [
                    'heading' => 'The honest cost logic',
                    'body' => [
                        'uPVC is the value option and composite is the premium one, and the honest way to choose is by the house and how long you are staying. A composite earns its extra cost on a home you will keep, a doorway the street sees, or an exposed position that will test the door. A uPVC door makes complete sense on a budget, a rental, a side or back entrance, or a modern house it visually suits.',
                        'Price both before deciding rather than guessing the gap — our online quote tool prices doors the same way it prices windows, so you can see the real difference for your doorway rather than a brochure generality.',
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
