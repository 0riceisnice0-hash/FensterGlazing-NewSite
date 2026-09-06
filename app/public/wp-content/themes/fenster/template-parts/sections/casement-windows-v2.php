<?php
/**
 * Casement windows: 70mm Liniar EnergyPlus.
 *
 * Rebuilt 2026-08-04 on the owner's brief: order the page around the customer's
 * journey, lead on the three things that actually sell this window, and hold it
 * to the register of a luxury vehicle site rather than a double glazing one.
 *
 * The journey, in the order a buyer asks the questions:
 *   what is it, does it suit my house -> the overture
 *   will it be warm                   -> 01 EnergyPlus
 *   will it be safe, does it cost more-> 02 Security
 *   can I have it the way I want it   -> 03 Versatility
 *   are you any good                  -> the proof
 *   what does it cost                 -> the quote tool
 *
 * Reordered 2026-09-05 on the owner's instruction: versatility moved to last
 * "as that feeds nicely into the detail with bars/horns etc". The two technical
 * proofs are now delivered while attention is highest, and the chapter about
 * choosing sits next to the sections about choosing.
 *
 * Imagery rule for this page: the best image wins, and manufacturer studio
 * photography beats a rough job photograph everywhere except the proof
 * sections, where the whole point is that the work is ours. The studio set
 * under assets/images/products/casement/studio was converted from CMYK
 * originals; see the note in PROGRESS.md before regenerating it.
 *
 * The shared hero and four-tile specification strip render above this partial.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$quote_url = (string) ($args['quote_url'] ?? '');
$quote_label = (string) ($args['quote_label'] ?? 'uPVC Windows');
$phone = (string) ($brand['phone'] ?? '01908 429200');
$base = '/wp-content/themes/fenster/assets/images/products/casement/';
$studio = $base . 'studio/';

/* The film slot. Set $film_src to a theme path when the installation film is
   delivered and the band plays it in place of the poster; nothing else needs to
   change. A chip keeps it honest until then rather than looking unfinished. */
$film_src = '';

/* The two openers had each other's photograph until 2026-08-05. A friction stay
   is fitted on the members square to the hinge line, so which member carries the
   stay names the window: `cas-stay-open` runs its long track along the head and
   cill with the keep on the jamb, which is a side hung sash, and `cas-hinge-open`
   carries its stay on the jamb, which is a top hung one. Owner caught it; the
   photographs read that way round too. Judge these by the stay, not the filename.

   `focus` is the object-position for the 4/3 crop. It is only set where centring
   cuts the subject: the fixed pane photograph is 820x857, so a centred crop puts
   the transom across the middle and halves the pane the tile is named after.
   Owner instruction, 2026-08-05, to lift the split toward the top. */
$styles = [
    [
        'name' => 'Side hung',
        'copy' => 'Hinged on the stile and held at any angle by a stainless friction stay. Where a bedroom needs its escape route, egress hinges swing the sash to ninety degrees so the clear opening meets the Building Regulations minimum of 0.33m², at least 450mm each way.',
        'image' => $studio . 'cas-stay-open.webp',
        'w' => 1250,
        'h' => 857,
        'alt' => 'Friction stay along the cill of a white uPVC side hung casement, the sash swung open on its stile hinges',
    ],
    [
        'name' => 'Top hung',
        'copy' => 'Hinged in the head with the handle on the bottom rail. The open sash sheds rain clear of the opening, which is why top-hung sashes sit above fixed panes and over kitchen worktops. A restrictor holds the first opening to around 100mm where children sleep.',
        'image' => $studio . 'cas-hinge-open.webp',
        'w' => 1250,
        'h' => 857,
        'alt' => 'Friction stay on the jamb of a white uPVC top hung casement, the sash held open from the head',
    ],
    [
        'name' => 'Fixed pane',
        'copy' => 'No hinges, no gearing, no handle. The glass is bedded straight into the frame, so a fixed pane costs less than an opener the same size and carries a slimmer border and more glass. Ventilation and escape come from the openers around it.',
        'image' => $studio . 'cas-sash-proud-w.webp',
        'w' => 820,
        'h' => 857,
        'focus' => '50% 92%',
        'alt' => 'White uPVC casement window at a transom, the opening sash standing proud of the frame above a directly glazed fixed pane',
    ],
];
$versus_rows = [
    ['label' => 'The sash', 'a' => 'Stands proud of the frame', 'b' => 'Closes level with the frame'],
    ['label' => 'Fixed panes', 'a' => 'Glazed into the frame, so more glass', 'b' => 'Matched dummy sash, so equal lines'],
    ['label' => 'Glazing', 'a' => '28mm double or 36mm triple', 'b' => '28mm double'],
    ['label' => 'Whole window U-value', 'a' => '0.95 W/m²K', 'b' => '1.2 W/m²K'],
    ['label' => 'Energy rating', 'a' => 'A+', 'b' => 'A+'],
    ['label' => 'Suits', 'a' => 'Most homes, and the wider specification', 'b' => 'Period and cottage elevations'],
];

/* Four dressings, four photographs, each checked at full size before it was
   labelled. The bay bars are Georgian: the reflection of the street runs
   straight over them, so they are inside the sealed unit. The brick bay bars
   are astragal: moulded, standing proud of the glass and casting a shadow. */
$details = [
    /* Owner's photograph, 2026-08-05, and checked the same way the wrong one was
       caught: at full size the obscured glass stipple runs unbroken across the
       faces of the bars, so they are behind the glass surface inside the sealed
       unit. No moulding, no step, no shadow. That is this tile's own copy, and
       the opposite of the astragal tile below it.

       Note the filename is reused. `casement-georgian-bar-900w` previously held
       a crop of `casement-bay-white-1080w` whose bars carried a highlight and a
       cast shadow, so they sat on the face of the glass: astragal, not a bar
       inside the unit, which is why this slot held a placeholder. Nothing else
       referenced it, so the name now holds a photograph that matches it.

       Shot on a phone on its side and rotated upright, then cropped from the
       whole bathroom window to the bar cross on the left sash, keeping the sash
       stile and handle for structure and leaving the sill, the bath and the
       towel rail out. 980x734 of the original down to 900x675, so a downscale,
       at the astragal tile's ratio. */
    ['name' => 'Georgian bars', 'copy' => 'An 18mm flat bar inside the sealed unit, colour matched to the frame. The pane still wipes clean.', 'image' => $base . 'casement-georgian-bar-900w.webp', 'w' => 900, 'h' => 675, 'alt' => 'Georgian bars set inside the sealed unit of a white uPVC casement window, the obscured glass reading unbroken across the bars'],
    ['name' => 'Astragal bars', 'copy' => 'A moulded bar bonded to the face of the glass, so it catches the light and throws a shadow.', 'image' => $base . 'casement-astragal-bar-900w.webp', 'w' => 900, 'h' => 675, 'alt' => 'Close up of moulded astragal bars standing proud of the glass on a white uPVC bay window'],
    /* The horn photograph was wrong until 2026-08-05: `casement-mock-horn-900w`
       is a studio shot of a mullion meeting the cill and shows no horn at all.
       So are `casement-astragal-horn-1250w` and `studio/cas-mock-horn` — all
       three are the same subject under three names, so pick by looking, not by
       filename. This one is the only asset in the theme that actually shows
       horns: the curved projections on the bottom corners of the open sashes.
       It is 600x600 and the trio crops to 4/3, which keeps both of them. */
    ['name' => 'Mock sash horns', 'copy' => 'Turned on the bottom corners of the sash, the way a period sash window was always finished.', 'image' => $base . 'casement-mockhorn-detail-600w.webp', 'w' => 600, 'h' => 600, 'alt' => 'Mock sash horns turned on the bottom corners of open white uPVC casement sashes'],
    ['name' => 'Leaded glass', 'copy' => 'Lead laid over the pane in diamonds or squares, then sealed into the unit against the weather.', 'image' => $base . 'casement-diamond-lead-900w.webp', 'w' => 900, 'h' => 660, 'alt' => 'Diamond leaded glass in a white uPVC casement window, fitted by us in Rushden'],
];
/* ---------- Glass make-up ------------------------------------------------
   Owner, 2026-09-04: "explains the glass make up options. as per our windowcad,
   so people actually know what they're choosing", then "wants to go with
   privacy glass", then "needs to look WAYYYY cleaner. not a list, but side by
   side, not lines of text - maybe use an icon system? think apple or dyson
   website level".

   So: five columns side by side, the drawing doing the explaining, a caption of
   a few words and a set of marks. No paragraphs.

   WHAT "ECO" IS, owner-confirmed 2026-09-04: low-E coated glass, argon filled,
   warm edge spacer. It is common to all five, so it is stated once above the
   columns and the spacer is drawn into every unit. Before he confirmed it the
   line read "the energy efficient build we price as standard", which said
   nothing. Do not go back to that.

   STILL NO FIGURES. No U-values, no decibels, no cavity widths, no coating
   brand. The marks name what an option adds, they do not rank or measure it.

   FIGURES COME FROM THIS PAGE, NOT FROM ANYWHERE ELSE. Owner: "you know the
   figures for double/triple too." The page already publishes a 28mm double and
   a 36mm triple, and 0.95 W/m2K whole window with the triple, in the energy
   strip and the sealed unit anatomy. Those are reused verbatim.

   THE DOUBLE IS 1.2 W/m2K AND IT WAS WRONG TO LEAVE IT OUT. I read the
   standard-against-flush comparison, which gives flush 1.2 with a 28mm double,
   and concluded 1.2 was the flush figure alone. The anatomy band on THIS page
   states it for THIS system in its own right: "0.95 W/m2K with 36mm triple
   glazing / 1.2 W/m2K with 28mm double glazing". The owner caught it.

   0.95 IS A WHOLE WINDOW FIGURE, not a glass one, and is labelled as such.

   NO ACOUSTIC FIGURE, AND IT IS NOT AN OVERSIGHT. Asked for one on 2026-09-04.
   Every dB figure on the site belongs to a different product: 35 dB is the
   FLUSH casement (Liniar's figure for that system), 37 dB is tilt and turn, and
   31 dB is the Distinction composite door. Nothing is published for the 70mm
   EnergyPlus casement this page is about.

   Two of those would also be the wrong KIND of number even if the frame
   matched. They are whole-window system figures; what an Eco Acoustic Laminated
   unit does is a property of the glass and its interlayer, which is a separate
   figure from a separate source. Do not borrow one from a neighbouring product
   to fill the gap.

   THE DRAWING DOES NOT LABEL INSIDE OR OUTSIDE. Which face the laminate sits on
   is not confirmed, so the section makes no claim about it.

   The five names and the colour coding are lifted from the WindowCAD designer
   so the page and the tool agree on sight. */
$glass_marks = [
    'safety'   => ['label' => __('Safety', 'fenster'),   'path' => 'M12 3 4 6v5.5c0 4.3 3.2 8.3 8 9.5 4.8-1.2 8-5.2 8-9.5V6l-8-3Z'],
    'security' => ['label' => __('Security', 'fenster'), 'path' => 'M7 10V7a5 5 0 0 1 10 0v3M5.5 10h13v10h-13z'],
    'quiet'    => ['label' => __('Quiet', 'fenster'),    'path' => 'M4 9v6h4l5 4V5L8 9H4ZM17 9.5a4 4 0 0 1 0 5M20 7a8 8 0 0 1 0 10'],
    'warmth'   => ['label' => __('Warmth', 'fenster'),   'path' => 'M14 14.8V5a2 2 0 1 0-4 0v9.8a4 4 0 1 0 4 0Z'],
];

$glass_options = [
    [
        'name'    => __('Eco Toughened', 'fenster'),
        'tint'    => '#2eac66',
        'panes'   => ['plain', 'plain'],
        'uvalue'  => '1.2 W/m&sup2;K',
        'caption' => __('Our standard. If it is ever broken it goes to blunt granules rather than shards.', 'fenster'),
        'build'   => __('28mm unit, toughened both panes.', 'fenster'),
        'marks'   => ['safety'],
    ],
    [
        'name'    => __('Eco Laminated', 'fenster'),
        'tint'    => '#9b8ec9',
        'panes'   => ['plain', 'lam'],
        'uvalue'  => '1.2 W/m&sup2;K',
        'caption' => __('Stays in the frame if it is broken, so it is far harder to get through.', 'fenster'),
        'build'   => __('28mm unit, one pane bonded to a clear interlayer.', 'fenster'),
        'marks'   => ['safety', 'security'],
    ],
    [
        'name'    => __('Eco Acoustic Laminated', 'fenster'),
        'tint'    => '#e0a2a2',
        'panes'   => ['plain', 'lam-acoustic'],
        'uvalue'  => '1.2 W/m&sup2;K',
        'caption' => __('Takes the edge off a busy road or a flight path.', 'fenster'),
        'build'   => __('6.8mm Pilkington Optiphon, 18mm cavity, 4mm outer pane.', 'fenster'),
        'marks'   => ['safety', 'security', 'quiet'],
    ],
    [
        'name'    => __('Triple Glazed Eco Toughened', 'fenster'),
        'tint'    => '#8fb6d4',
        'panes'   => ['plain', 'plain', 'plain'],
        'uvalue'  => '0.95 W/m&sup2;K',
        'caption' => __('The warmest rooms on the list.', 'fenster'),
        'build'   => __('36mm unit, three panes and two cavities.', 'fenster'),
        'marks'   => ['safety', 'warmth'],
    ],
    [
        'name'    => __('Triple Glazed Eco Acoustic Laminated', 'fenster'),
        'tint'    => '#d98f9e',
        'panes'   => ['plain', 'plain', 'lam-acoustic'],
        'uvalue'  => '0.95 W/m&sup2;K',
        'caption' => __('Quietest and warmest together.', 'fenster'),
        'build'   => __('36mm unit with the Optiphon laminate in one pane.', 'fenster'),
        'marks'   => ['safety', 'security', 'quiet', 'warmth'],
    ],
];

$energy_stats = [
    ['figure' => '0.95', 'unit' => 'W/m²K', 'note' => 'Whole window, with the 36mm triple glazed unit'],
    ['figure' => 'A+', 'unit' => 'rated', 'note' => 'On the specification we list'],
    ['figure' => 'Six', 'unit' => 'chambers', 'note' => 'Through every frame section, against four as standard'],
];

$anatomy = [
    /* Trimmed 2026-09-06 on a whole-page read. It said "run the length of every
       frame section", which the stat note beside it and the chapter lead above
       it both also said, and it closed on "the difference between the EnergyPlus
       profile and a standard one", which is the chapter heading. It also still
       carried "upgrade tier", which the owner called trade jargon a homeowner
       does not use back on 2026-09-05 and which was taken out of the overture
       then but survived here. What is left is the only thing this item alone can
       say: why six pockets are better than four. */
    ['name' => 'Six chambers', 'copy' => 'Six sealed air pockets, and each one interrupts the route heat takes out of the room. They sit inside the frame where you never see them, so nothing about the window looks different for it.'],
    ['name' => 'The gasket', 'copy' => 'The weather seal is formed with the profile as it is extruded rather than pushed into a groove afterwards, so it cannot shrink back or work loose at a corner. Corners are where a pushed-in gasket fails first.'],
    /* "Reinforcement" WAS HERE AND IS GONE, 2026-09-06. Owner: "this doesnt
       make sense and isnt true. we dont specify reinforcment."

       Worth recording because I got this wrong twice in two days and in
       opposite directions. On 2026-09-06 the same sentence was cut from
       $security_points as a duplicate, and the note there argued this copy was
       its CORRECT home and that it was really about wind load and thermal
       movement. That defence was of a claim the owner says we do not make:
       reinforcement is not something we size window by window and not a survey
       decision, so "a large dark sash on an exposed elevation is stiffened
       differently" was invented reasoning, not a fact off this business.

       Not rewritten. There is no confirmed statement about how reinforcement is
       decided on this system, and the whole point of the security note below is
       that inventing one is worse than saying nothing. THE ACCORDION READS
       FINE AT FOUR: the numbers are printed from the loop index, so they close
       up on their own.

       THE THREE FAQ MENTIONS ARE GONE TOO, 2026-09-06: "fix the reinforcement
       mentions in the faqs." Two listed reinforcement among the things we
       confirm or that move the U-value, which is the same claim this item was
       removed for making; a third offered "reinforced frames" as a security
       option. That last one also disagreed with the security chapter's own
       heading -- "Multi-point locking is not an upgrade. / It is what we fit."
       -- by listing the lock as something to be specified, so it now says what
       the chapter says. Ask the owner before any reinforcement claim returns
       anywhere on this page. */
    ['name' => 'The sealed unit', 'copy' => 'Panes, coatings, argon fill and a warm edge spacer decide most of the whole window figure. A 28mm double or a 36mm triple, with the triple reaching 0.95 W/m²K. The number we agree follows your glass rather than a brochure.'],
    ['name' => 'The installation', 'copy' => 'Fixing, sealing and finishing are what connect a tested window to your actual wall. Our own installers do it, which is why the ten year guarantee on the work is ours to give.'],
];

$security_points = [
    /* Owner instruction, 2026-08-05: security is the whole window, not the
       mechanism with the glass as a footnote. So the lock keeps its place as one
       part of five rather than a branded headline of its own, what it pulls
       against is a point in its own right, and the glass is named for what it
       actually does instead of trailing at the end as an upsell. The Kenrick
       test figures live in the guarantee point; they are Kenrick's figures for a
       mechanism, and the approval point says what belongs to a whole tested
       window. */
    /* Renamed 2026-09-06, and it lost its opening "Not an upgrade." The chapter
       heading above this list is now "Multi-point locking is not an upgrade. /
       It is what we fit.", written FROM this item, so the two were making the
       identical claim in the identical words about 200px apart. The heading
       keeps the claim; the item goes back to doing what the others do, which is
       explain one thing. */
    ['name' => 'One turn, the whole edge', 'copy' => 'The Kenrick Excalibur strip runs the length of the sash, and one turn of the handle throws steel shoot bolts into the frame and bi-directional claws into keeps down the sash edge, so the window is held into its seals along its whole length rather than at the handle.'],
    /* "The frame it pulls against" WAS HERE AND IS GONE, 2026-09-06. Owner:
       "'The frame it pulls against' mini section is nonsense." He is right, and
       for a reason worth writing down so it does not come back.

       It was the anatomy accordion's Reinforcement item repeated almost word
       for word, one screen away on the same page, under a heading that
       misdescribed it. Reinforcement is sized for WIND LOAD AND THERMAL
       MOVEMENT: that is what "a large dark sash on an exposed elevation"
       is about, dark frames absorbing heat and exposed walls catching wind.
       None of that is what a lock pulls against, so the heading promised a
       security fact and the sentence delivered a structural one.

       Not rewritten, because there is no published fact to rewrite it with. The
       page says the bolts throw into the frame and the claws into keeps down
       the sash edge, but nothing anywhere states what those keeps are fixed
       into. Inventing one would be worse than the sentence that was here.

       IF THERE IS A REAL ANSWER, this is the slot for it: the point that a lock
       is only as good as what it is fixed into is a good one, and the owner has
       it. Ask before adding it back. */
    ['name' => 'Tested, and guaranteed ten years', 'copy' => 'Kenrick test the mechanism to 100,000 opening cycles and 240 hours of salt spray, beyond what BS EN 1670 asks, and guarantee it for ten years.'],
    /* Tightened 2026-09-06. Owner: "this is also waffle". It was three
       sentences where two were caveats: what Part Q asks for, then a
       disclaimer that the approval belongs to a tested complete window rather
       than to a profile or a lock. That disclaimer is load-bearing and stays
       TRUE here, but it is now carried by saying we specify a complete window
       tested to it, which puts the approval at the window instead of
       announcing where it does not sit. Same fact, one clause, no lecture. */
    ['name' => 'PAS 24 and Secured by Design', 'copy' => 'Both available. Part Q asks for PAS 24 on new dwellings and some extensions, so tell us at survey if yours is covered and we will specify a complete window tested to it.'],
    /* LAST, AND NAMED AS AN OPTION, 2026-09-06. Owner: "This should be the last
       point in that section and shouldn't undermine the locking. It's an
       optional upgrade."

       It was second of four and called "The glass does half the work", which
       says in its own title that the lock only does the other half -- directly
       under a heading whose whole job is "Multi-point locking is not an
       upgrade. It is what we fit." The copy never undermined anything; the
       title did.

       The order now runs: what is fitted as standard, the proof behind it, the
       approvals available, and then the one thing a buyer can choose to add.
       The option belongs at the end of that argument, not interrupting it. */
    ['name' => 'Laminated glass, an optional upgrade', 'copy' => 'A laminated pane has a bonded interlayer, so it holds together instead of breaking through. That is the difference between a broken window and an open one, and it is the upgrade we would point at first on a ground floor or any window out of sight from the road.'],
];
/* Kenrick's own published figures for the Excalibur, taken from
   kenricks.co.uk/products/window-hardware/excalibur on 2026-08-04. They belong
   to the mechanism, not to our finished window, which is why the PAS 24 line
   says capable rather than certified: the approval sits with a tested complete
   window and the security list below already makes that distinction. Do not
   restate any of these as a Fenster figure. */
// Our own work only. The studio photography carries the rest of the page; proof
// has to be the real thing.
/* Our own installations only. The stone elevation that used to sit here is
   Liniar photography of a job that is not ours; it carries the overture now,
   where nothing claims it. The Leighton Buzzard frame is cropped to the
   downstairs window because the upstairs windows on that terrace are not ours.
   Every tag below is read off its own photograph. */
$gallery = [
    ['file' => 'casement-bolbeck-park', 'width' => 1000, 'focus' => '50% 40%', 'caption' => 'Bolbeck Park, Milton Keynes', 'tags' => ['Anthracite grey', 'Two-storey bay', 'Top opening sashes'], 'alt' => 'Anthracite Liniar casement windows stacked over two floors on a corner elevation in Bolbeck Park, fitted by us'],
    ['file' => 'casement-anthracite-bay', 'width' => 1600, 'focus' => '50% 45%', 'caption' => 'Anthracite grey bay', 'tags' => ['Anthracite grey', 'Splayed bay', 'Obscure glass'], 'alt' => 'Anthracite grey uPVC casement bay window with obscured lower panes, fitted by us'],
    ['file' => 'casement-rushden-leaded', 'width' => 1400, 'focus' => '45% 45%', 'caption' => 'Rushden', 'tags' => ['White', 'Diamond lead', 'Side hung openers'], 'alt' => 'White uPVC casement windows with diamond leaded glazing on a red brick house in Rushden, fitted by us'],
    ['file' => 'casement-stony-stratford', 'width' => 1400, 'focus' => '30% 50%', 'caption' => 'Stony Stratford', 'tags' => ['White', 'Splayed bay', 'Top opening sashes'], 'alt' => 'White uPVC casement windows in a bay on a red brick Victorian terrace in Stony Stratford, fitted by us'],
    ['file' => 'casement-leighton-downstairs', 'width' => 490, 'focus' => '50% 50%', 'caption' => 'Leighton Buzzard', 'tags' => ['White', 'Fixed pane and opener', 'Tile-hung elevation'], 'alt' => 'White Liniar casement window with a wide fixed pane and a side hung opener on a tile hung terrace in Leighton Buzzard, fitted by us'],
];
$faqs = [
    ['question' => 'What is a casement window?', 'answer' => 'A window with sashes hinged at the side or the top, opening outwards. Opening sashes and fixed panes are made into one frame, so a single window can do more than one job.'],
    ['question' => 'What is the difference between casement and flush casement windows?', 'answer' => 'The sash. On a standard casement it stands slightly proud of the frame, and fixed panes are glazed straight into the frame so they hold more glass. On a flush casement the sash closes level with the frame for a traditional joinery look, with fixed panes matched to the openers so every pane reads the same. Standard takes 28mm double or 36mm triple glazing and reaches 0.95 W/m²K; flush takes 28mm double and reaches 1.2 W/m²K. Both are A+ rated.'],
    ['question' => 'Which Liniar system do you fit?', 'answer' => 'The 70mm Liniar EnergyPlus system in the sculptured profile, a six-chamber uPVC platform used for both replacement and new-build work. Glass and hardware are confirmed for your individual job.'],
    /* WHY THIS SYSTEM, and deliberately NOT a comparison. Owner decision,
       2026-08-15: drop competitor copy where it does not flatter us. The right
       way to act on that is to drop the comparison whole rather than keep the
       half we win, because a comparison that only shows our side is selective
       rather than persuasive, and it is the version that gets challenged.

       So the named-system version of this answer is gone. It ran six chambers
       against the aluplast Ideal 70's five and 0.95 W/m²K against their
       published 1.2, and it carried the balancing admission that their range is
       rated A++ where ours is A+ because A++ needs a 40mm unit we do not fit.
       All of it was accurate and sourced from their 2025 technical brochure.
       **If a comparison is ever wanted here again, it comes back with that
       admission attached or it does not come back.**

       It also removed a second problem: the versus table further up this page
       already prints 1.2 W/m²K for the Liniar flush sash, so the page carried
       two unrelated 1.2s and a reader could reasonably conflate them.

       Every figure below is already stated elsewhere on this route. */
    ['question' => 'Why do you fit Liniar?', 'answer' => 'The 70mm EnergyPlus frame carries six chambers, sculptured rather than chamfered, and welded at the corners rather than screwed. Triple glazed it reaches 0.95 W/m²K, and the profile is lead-free. Liniar guarantee the frame for ten years and we guarantee the installation for ten, which are two different things and both worth having.'],
    ['question' => 'What U-value can an EnergyPlus casement reach?', 'answer' => '0.95 W/m²K, with the 36mm triple glazed unit, which makes it an A+ window. Size, layout and glass all move the complete-window figure, so the number we agree follows your final specification rather than a brochure.'],
    ['question' => 'Are casement windows secure?', 'answer' => 'Multi-point locking is what we fit as standard, not an upgrade, and PAS 24 or Secured by Design can be specified on top. Part Q asks for PAS 24 on new dwellings and some extensions, so tell us at survey if yours is covered and we will specify a complete window tested to it.'],
    ['question' => 'Can I have triple glazing?', 'answer' => 'Yes. The 70mm frame takes a 28mm double glazed unit or a 36mm triple. Whether triple is worth it depends on the sash size, the weight and what you are actually trying to improve, so we will compare it with you rather than treating it as an automatic upgrade.'],
    ['question' => 'Will new casements make the house quieter?', 'answer' => 'They can, when the whole specification is designed for it. Liniar publish around 33 decibels for a standard double glazed unit and up to 37 decibels, rated 37 (-2;-5), where the window is built for acoustics. Reaching the higher figure is the glass doing the work rather than the frame. Pane thicknesses, frame seals and the ventilation path all affect the result, and the ventilation path is the one people forget.'],
    ['question' => 'How many colours are there?', 'answer' => 'Sixteen foils, plus smooth white as the unfoiled profile. The colour you pick is the external face, with the same colour or smooth white on the inside. Liniar publish a wider foil catalogue, but availability, lead time and cost vary by colour, so we confirm before you order.'],
    ['question' => 'Can I have bars, horns or leaded glass?', 'answer' => 'Yes. Georgian bars sit inside the sealed unit, astragal bars are bonded to the glass face, mock sash horns dress the sash corners, and leaded glass comes in squares or diamonds. All of them are priced with the window rather than added afterwards.'],
    ['question' => 'Can you copy my existing window layout?', 'answer' => 'Usually, though an exact copy is not always the best answer. At survey we check escape, ventilation, handle reach, outside clearance and how the sightlines sit before the drawing is signed off.'],
    ['question' => 'What guarantee comes with them?', 'answer' => 'Two separate ones. Liniar guarantee the frame for ten years, and we guarantee our installation for ten years. They cover different things and come from different people, which is worth knowing if something ever needs putting right.'],
    ['question' => 'Are the frames recyclable?', 'answer' => 'Liniar describe their uPVC profiles as lead-free and recyclable at the end of their useful life. The profiles are designed, extruded and tested in Derbyshire.'],
];

// FAQPage markup comes from the shared emitter in `inc/generated-pages.php`.
// Seven separate copies of this block existed across the theme until
// 2026-08-15, which is seven places for the shape to drift and five that
// had already been missed when the schema itself needed changing.
?>

<div class="fg-cas">

    <?php
    /* ---------- The stack begins ---------------------------------------------
       The opening is the base plate: it anchors, and chapter 01 rises over it,
       so 01 behaves like 02 and 03 rather than arriving in ordinary flow.
       Without something beneath it there is nothing for it to cover.

       The plate is deliberately "the opening", whatever the opening happens to
       contain, rather than one named section. Today that is the overture alone.
       When the installation film is delivered it joins this same panel instead
       of becoming a second plate, because two plates here put two covers on top
       of one another: measured at 1280x900, the film's own cover ran from 258 to
       1071 while chapter 01's began at 737, so 334px of scrolling had both
       running at once. One plate, one cover, whatever the opening holds.

       The page still has a normal-scrolling run-up before any of this: the
       shared hero and the four-tile specification strip render above this
       partial and are untouched.

       NOTHING PINS AND NOTHING OVERLAPS ANY MORE, as of 2026-09-05. A panel is
       now just a grouping that carries an opaque ground, and the seam between
       two chapters is a change of ground rather than one plate sliding over
       another. See the parked note in main.scss for the two measurements that
       killed the sticky version, including the one that shipped: a pinned
       chapter taller than the viewport hides its own tail, and `top: 0` puts it
       under the sticky site header. ---------------------------------------- */
    ?>
    <div class="fg-cas-stack" data-fg-cas-chapters>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--opening">

    <?php /* COPY REWRITTEN 2026-09-05. Owner: "this paragraph sounds dumb and
             ai, especially the second para."

             He was right about both. The first ended "a bathroom window, a full
             bay and everything in between", which is a construction that says
             nothing and reads as filler. The second was worse: three sentence
             fragments in a row ("We fit one." / a profile with no verb /
             "Everything on this page is that window."), "upgrade tier" is trade
             jargon a homeowner does not use, and the last line is the page
             talking about itself rather than to the reader.

             Rewritten as plain sentences that each carry a fact: how a casement
             opens, that it is made to the opening rather than a stock size, what
             we fit, and that it is not charged as an extra. */ ?>
    <?php /* Overture. The claim sits ON the photograph rather than above it,
             on the owner's instruction of 2026-09-05: "combine all of this 'The
             window most British homes are built around.' overlaid onto the image
             below but being reveal with a bit of animation".

             IT REVEALS ON APPROACH, NOT ON LOAD. This was written as a load
             animation on the reasoning that it is the first thing on the page.
             It is not: the hero and the specification strip sit above it and it
             begins around 690px down, so the animation had already finished
             before anyone scrolled to it. The owner caught that. It is a
             `data-fg-cas-reveal` target now, like the chapters below it, and
             the whole thing is off under reduced motion.

             The photograph keeps its alt: it is the product on a real elevation,
             not decoration, even though it is now behind the words. */ ?>
    <?php /* THE TRACK IS SCROLL LENGTH, NOTHING ELSE. The section pins inside it
             while the sentence turns, so the reader arrives at the statement
             first and then turns it, rather than the turn being spent on the
             approach. Owner, 2026-09-05: "needs to be 2 events. scroll, then
             the words animate, because otherwise its over by the tiem you get
             there."

             The pin only exists when JavaScript is running, motion is allowed
             AND the section actually fits below the header, which main.js
             checks and re-checks on resize. With any of those false the track
             has no extra height, nothing is sticky, and the section is an
             ordinary block. That guard is not optional: pinning something
             taller than the space it is pinned in is precisely the bug removed
             from this page earlier today. */ ?>
    <div class="fg-cas-overture-track" data-fg-cas-turn-track>
    <section class="fg-cas-overture fg-cas-overture--onimage" data-fg-cas-reveal aria-labelledby="fg-cas-overture-title">
        <figure class="fg-cas-overture__media">
            <img src="<?php echo esc_url(fenster_generated_url($base . 'gallery/casement-stone-elevation.webp')); ?>"
                alt="<?php esc_attr_e('White uPVC casement windows across the front elevation and dormers of a stone house', 'fenster'); ?>"
                loading="lazy" width="1200" height="803">
        </figure>
        <div class="container fg-cas-overture__inner">
            <?php /* Five terms, BENEFITS RATHER THAN FABRICATION DETAILS, one to
                     a line. Owner, 2026-09-06: "look at our offering and state
                     the things that really make it unique and what a consumer
                     would actaully care about. 'coner welded' for eg like who
                     cares about that?!"

                     He is right, and it applied to more than one of them.
                     corner-welded and six-chambered are how the thing is made;
                     a homeowner has no way to tell whether either is good.
                     argon-filled and draught-sealing were half way there. What
                     someone actually wants to know is whether it will fit their
                     house, whether it will be cold, whether it is secure and
                     who is behind it if it goes wrong.

                       made-to-measure      "made to your opening rather than to
                                            a stock size"
                       draught-sealed       the seal is extruded with the profile
                                            ($anatomy 'The gasket'), and the lock
                                            holds the sash into it full length
                       A+ rated             $energy_stats, "on the specification
                                            we list"
                       multi-point-locked   "Multi-point locking as standard"
                       ten-year-guaranteed  Liniar ten on the frame, ours ten on
                                            the installation

                     Every one is still a published fact and every one is
                     STANDARD, which the resolve line underneath promises. Not
                     used, deliberately: PAS 24 and laminated glass are options
                     rather than standard, and the Kenrick cycle and salt spray
                     figures belong to a mechanism and must not be restated as
                     ours (see the note under $security_points).

                     six-chambered is not lost: it is the whole of chapter 01,
                     which is the right place to explain a word nobody arrives
                     knowing. */ ?>
            <?php
            $overture_terms = [
                __('made-to-measure', 'fenster'),
                __('draught-sealed', 'fenster'),
                __('A+ rated', 'fenster'),
                __('multi-point-locked', 'fenster'),
                __('ten-year-guaranteed', 'fenster'),
            ];
            /* translators: %s is a comma separated list of window specifications. */
            $overture_sentence = sprintf(
                __('It’s not just a uPVC window. It’s a %s uPVC window.', 'fenster'),
                implode(', ', $overture_terms)
            );
            ?>
            <?php /* ONE SENTENCE THAT TURNS, not three stacked beats. " not just"
                     squeezes out of the line while the terms open into the gap
                     it leaves, so the negation becomes the claim without the
                     frame sentence moving.

                     The visible halves are aria-hidden and the whole readable
                     sentence is carried once, first, in .fg-cas-sr. Both states
                     are in it, in order, so what is heard, what renders with
                     JavaScript off and what renders after the turn can never
                     disagree. The h2 still carries the id, so the section's
                     aria-labelledby resolves to a real heading. */ ?>
            <h2 id="fg-cas-overture-title" class="fg-cas-turn fg-cas-turn--overture">
                <span class="fg-cas-sr"><?php echo esc_html($overture_sentence); ?></span>
                <span class="fg-cas-turn__frame" aria-hidden="true">
                    <span class="fg-cas-turn__line"><span><?php esc_html_e('It’s', 'fenster'); ?></span><span class="fg-cas-turn__squeeze"><span class="fg-cas-turn__run"> <?php esc_html_e('not just', 'fenster'); ?></span></span><span> <?php esc_html_e('a', 'fenster'); ?></span></span>
                    <span class="fg-cas-turn__items"><span class="fg-cas-turn__reel"><?php foreach ($overture_terms as $i => $overture_term) : ?><span class="fg-cas-turn__term" style="--fg-term-index: <?php echo (int) $i; ?>"><?php echo esc_html($overture_term); ?></span><?php endforeach; ?></span></span>
                    <span class="fg-cas-turn__line"><span><?php esc_html_e('uPVC window.', 'fenster'); ?></span></span>
                </span>
            </h2>

            <?php /* Never animated and never hidden. This is the one sentence on
                     the page written for somebody who has not bought a window
                     before, and gating it behind the turn to buy screen height
                     is the trade this rebuild refuses to make. */ ?>
            <p class="fg-cas-turn__define"><?php esc_html_e('A casement hinges at the side or the top and opens outwards. Openers and fixed panes are made into one frame, so a single window can do more than one job.', 'fenster'); ?></p>

            <p class="fg-cas-turn__resolve"><?php esc_html_e('It’s the 70mm Liniar EnergyPlus casement. We fit it as standard.', 'fenster'); ?></p>

            <div class="fg-cas-actions">
                    <?php if ($quote_url !== '') : ?>
                        <a class="button" href="#fenster-product-quote"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <?php endif; ?>
                    <a class="button button--steel" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html(sprintf(__('Call %s', 'fenster'), $phone)); ?></a>
                </div>
        </div>
    </section>
    </div><?php /* end the overture track */ ?>

    <?php
    /* The film band. Owner instruction, 2026-08-05: the placeholder comes off the
       page for now. The slot itself is kept rather than deleted, because it is
       reserved work and `$film_src` at the top of this file is already the switch
       for it; set that to a theme path and the band returns here, inside the
       opening plate, and plays the mp4 in the same frame.

       With no source there is nothing to show but an "In production" chip, which
       is the placeholder that was asked to go, so the whole section is gated
       rather than the video element alone. */
    ?>
    <?php if ($film_src !== '') : ?>
        <section class="fg-cas-film" data-fg-cas-reveal aria-labelledby="fg-cas-film-title">
            <div class="container fg-cas-film__grid">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('On this page', 'fenster'); ?></p>
                    <h2 id="fg-cas-film-title" class="fg-cas-display"><?php esc_html_e('A set of casements, going in.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('A real installation with our own fitters, from the first survey measure to the final wipe-down. No actors and no showroom set.', 'fenster'); ?></p>
                </div>
                <figure class="fg-cas-film__media">
                    <video autoplay muted loop playsinline poster="<?php echo esc_url(fenster_generated_url($base . 'casement-installation-900w.webp')); ?>">
                        <source src="<?php echo esc_url(fenster_generated_url($film_src)); ?>" type="video/mp4">
                    </video>
                </figure>
            </div>
        </section>
    <?php endif; ?>

    </div><?php /* end the opening plate */ ?>

    <?php
    /* ---------- The three chapters ---------------------------------------------
       01 EnergyPlus, 02 Security, 03 Versatility, in that order since 2026-09-05.
       They scroll normally. Each one sits on its own opaque ground, soft / white
       / soft, so the run has rhythm and the joins are legible without anything
       being pinned or layered.

       A panel is a chapter AND the sections it owns, because the chapters are not
       adjacent in the flow: EnergyPlus owns the tech banner that closes it, and
       the ground sits on the panel so the banner shares it. Keep a chapter and
       the sections it introduces in one panel.

       THE NUMERALS ARE NOT TYPED. `.fg-cas-num` is empty markup and a CSS counter
       on `.fg-cas-stack` fills it, so the numbers follow DOM order and cannot go
       stale the next time these panels move. They already had, once: the heading
       ids read ch1/ch2/ch3 in a different order from the printed numbers, which
       is why the ids are now named for their topic instead.

       03 is only the ways the window opens. The dressings, the two faces and the
       finishes sit below and carry their own section heads. Three chapters is
       deliberate: this run is for the three things that carry an argument, not
       for everything on the page.
       ------------------------------------------------------------------- */
    ?>
    <div class="fg-cas-stack__panel fg-cas-stack__panel--energy">

    <?php /* THE CHAPTER IS ALREADY THERE AND THE OPENING LIFTS OFF IT. Owner,
             2026-09-05: "the top bit wants to pull up and reveal whats
             underneath - youve got it so the bottom bit lifts up over."

             So this chapter holds still while the opening slides up and away,
             rather than climbing over a stationary opening. That means it has
             to be pinned, and pinning this chapter is exactly what broke the
             page this morning, so the difference matters:

             THE OLD BUILD pinned it with the whole stack as its containing
             block, which gave it an unbounded range. It pinned once and never
             released, later panels rode over it, and 46% of it could not be
             reached at any scroll position.

             THIS ONE IS BOUNDED. The panel is its own containing block and
             carries `padding-bottom: var(--fg-cas-reveal)`, so the sticky range
             is exactly that padding and no more: it holds for the length of one
             opening screen, then lets go and scrolls like anything else. Its
             full height is reachable the moment it releases. */ ?>
    <div class="fg-cas-under">

    <?php /* ---------- 01 ENERGYPLUS ---------- */ ?>
    <section class="fg-cas-energy" data-fg-cas-reveal aria-labelledby="fg-cas-energy-title">
        <?php /* ONE COMPOSED SCREEN, then the detail. Owner, 2026-09-06:
                 "the whole energy part feels a bit like the padding is wrong (as
                 soon as the title is revealed, it scrolls off of it). comoaring
                 it to dysons equivalent section, that is all clearly visible."

                 It read as a stack because it was one: a full width head, then a
                 half width photograph beside a column of figures, then the
                 accordion. Nothing composed, and the heading was gone by the
                 time the photograph arrived.

                 The head and the cutaway are now one two column band, the way
                 the reference sets a claim beside its product, and the three
                 figures run across underneath it. That whole opening is about
                 500px, so it is a single readable screen; the accordion is the
                 layer below it for anyone who wants the detail. */ ?>
        <?php /* THE PROFILE TRAVELS WITH THE DETAIL. Owner, 2026-09-06: "i
                 meant slide it down so it follwos to the side of the accordion."

                 So the chapter is one two column layout rather than a band with
                 a list under it: everything you read runs down the left, and the
                 profile sits in a column of its own on the right and sticks
                 there. It is the subject of every item in the accordion, so
                 having it in view while you open them is the point.

                 The claim and the three figures still get a screen to
                 themselves, which is what `__screen` is for; the accordion
                 simply begins under it in the same column. */ ?>
        <?php /* THE PROFILE TRAVELS WITH THE DETAIL. Owner, 2026-09-06: "i
                 meant slide it down so it follwos to the side of the accordion."

                 So the chapter is one two column layout rather than a band with
                 a list under it: everything you read runs down the left, and the
                 profile sits in a column of its own on the right and sticks
                 there. It is the subject of every item in the accordion, so
                 having it in view while you open them is the point.

                 The claim and the three figures still get a screen to
                 themselves, which is what `__screen` is for; the accordion
                 simply begins under it, in the same column. */ ?>
        <div class="container fg-cas-energy__layout">

            <div class="fg-cas-energy__main">

                <div class="fg-cas-energy__screen">
                    <div class="fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true"></span>
            <div>
                <?php /* "Energy efficiency", not "EnergyPlus". Owner, 2026-09-06:
                         "can change to like energy efficiency or similar - not
                         as niche as enegyplus (consumer friendly language)".

                         It is also the only eyebrow on the page that was a
                         trade name: the other two chapters read Security and
                         Versatility, so a plain noun is what this set already
                         is. The brand is not lost, it moves into the lead
                         below where there is room to say whose name it is,
                         and it still appears a dozen times on this page. */ ?>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Energy efficiency', 'fenster'); ?></p>
                <?php /* Both halves are this page's own words, split. The old
                         heading, "Energy efficiency starts in the frame.", was
                         true and carried no number; this one carries two. Both
                         lines are real text, so nothing is aria-hidden and a
                         screen reader gets one heading. */ ?>
                <?php
                /* The pay-off types itself in, a character at a time, as the
                   chapter is uncovered. Owner, 2026-09-06: "'this one has six'
                   wants to have the almost typewriter animation, not the swipe
                   up that you gave it."

                   THE SAME MECHANISM THE OVERTURE USES, not a second idiom: a
                   single `fr` track opening from nothing while the text inside
                   is clipped, which is exactly how " not just" leaves that
                   sentence and how the terms arrive in it. It reads as typing
                   because the line uncovers left to right at a steady rate.

                   A first attempt split this into per-character spans. It
                   worked, but it was a mechanism this page did not otherwise
                   have, and per-character spans are hostile to screen readers.
                   This needs neither: one wrapper, and the text stays one
                   string.

                   The heading is still carried once as ordinary text in
                   `.fg-cas-sr` with both visible halves aria-hidden, because the
                   clipped half would otherwise be read while it is empty. */
                $energy_set  = __('A standard uPVC profile has four chambers.', 'fenster');
                $energy_land = __('This one has six.', 'fenster');
                ?>
                <h2 id="fg-cas-energy-title" class="fg-cas-turn fg-cas-turn--chapter">
                    <span class="fg-cas-sr"><?php echo esc_html($energy_set . ' ' . $energy_land); ?></span>
                    <span class="fg-cas-turn__set" aria-hidden="true"><?php echo esc_html($energy_set); ?></span>
                    <span class="fg-cas-turn__land" aria-hidden="true"><span class="fg-cas-turn__wipe"><span class="fg-cas-turn__wipe-run"><?php echo esc_html($energy_land); ?></span></span></span>
                </h2>
                <?php /* Names the profile, since the eyebrow above no longer
                         does. Owner: "can maybe mention energyplus instead?"

                         "Liniar call that profile EnergyPlus" rather than just
                         asserting the name, because a reader who has never met
                         it needs to know it is the manufacturer's word and not
                         ours.

                         It deliberately does not end "we fit it as standard":
                         the overture's own resolve line already says exactly
                         that a screen above, and the page should not make the
                         same promise twice in two hundred words. "Specify on
                         every casement we fit" is the same fact in the words
                         the original lead used. */ ?>
                <p class="fg-cas-lead"><?php esc_html_e('Liniar call that profile EnergyPlus, and it is the one we specify on every casement we fit.', 'fenster'); ?></p>
            </div>
        </div>

                    <?php /* The figures arrive one after another as the chapter is
                     reached, rather than being there already. Owner, 2026-09-05:
                     "then maybe bring the rh figures in on a scroll motion too".

                     Entry-triggered off the shared observer with a per-item
                     stagger, NOT scrubbed by scroll like the opening sentence.
                     Two reasons: this chapter is not pinned, so a scrubbed
                     figure would jitter with every wheel notch instead of
                     settling, and a second scrubbed element on the same page is
                     the "toom uch overlapping" the owner pulled the old build
                     up on. It runs once and stops. */ ?>
            <div class="fg-cas-stats-cycle" data-fg-cas-cycle>
            <dl class="fg-cas-stats fg-cas-stats--row" data-fg-cas-reveal>
                <?php foreach ($energy_stats as $i => $stat) : ?>
                    <div class="fg-cas-stats__item" data-fg-cas-cycle-item style="--fg-stat-index: <?php echo (int) $i; ?>">
                        <dt><span><?php echo esc_html($stat['figure']); ?></span><?php echo esc_html($stat['unit']); ?></dt>
                        <dd><?php echo esc_html($stat['note']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            </div>
                </div>

                <?php /* The detail sits BELOW the fold on purpose. Owner, 2026-09-06:
                 "dont have them in the immediate viewport. make the image, title
                 and 3x spec points have their own before the accordion." The
                 band above carries a viewport of its own, so this is what you
                 find when you choose to go further, not what competes with the
                 claim while you are still reading it. */ ?>
                <ol class="fg-cas-anatomy" data-fg-anatomy data-fg-anatomy-collapsible>
                <?php foreach ($anatomy as $i => $item) : ?>
                    <?php $id = 'fg-cas-anatomy-' . $i; ?>
                    <li>
                        <h3>
                            <button type="button" class="fg-cas-anatomy__toggle" data-fg-anatomy-toggle aria-expanded="false" aria-controls="<?php echo esc_attr($id); ?>">
                                <span class="fg-cas-anatomy__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                                <span class="fg-cas-anatomy__name"><?php echo esc_html($item['name']); ?></span>
                                <span class="fg-cas-anatomy__mark" aria-hidden="true"></span>
                            </button>
                        </h3>
                        <div class="fg-cas-anatomy__body" id="<?php echo esc_attr($id); ?>" hidden>
                            <p><?php echo esc_html($item['copy']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>

                <p class="fg-cas-note fg-cas-note--quiet"><?php esc_html_e('Liniar profiles are lead-free and recyclable at the end of their life, designed, extruded and tested in Derbyshire. The frame carries a ten year Liniar guarantee; our installation carries ten years of ours.', 'fenster'); ?></p>
            </div>

            <?php /* Last in the source, so a screen reader and a reader with no
                     CSS meet the claim and the figures before the illustration.
                     The grid puts it in the right hand column regardless. */ ?>
            <span class="fg-cas-energy__aside">
            <?php /* The heat layer is a SECOND IMAGE stacked on the first, not a
                     canvas. A per-pixel canvas version of this was built and
                     measured first: 380,000 pixels a frame, which is fine on a
                     desktop and not something to put in front of a phone. Baking
                     the thermal state once and moving a CSS mask over it gets the
                     same picture for no per-frame work at all, and the mask is a
                     compositor property.

                     It is decorative and it is aria-hidden. The cutaway below it
                     carries the alt text, so nothing is described twice, and a
                     reader who never sees the sweep loses nothing.

                     Both files share one silhouette, generated from the same
                     flood fill, so they register exactly when stacked. */ ?>
            <figure class="fg-cas-energy__media">
                <span class="fg-cas-energy__stack">
                    <img class="fg-cas-energy__profile"
                        src="<?php echo esc_url(fenster_generated_url($studio . 'cas-profile-cutaway-cut.webp')); ?>"
                        alt="<?php esc_attr_e('Cutaway of the six-chamber Liniar EnergyPlus uPVC frame and sash profile', 'fenster'); ?>"
                        loading="lazy" width="1100" height="733">
                    <img class="fg-cas-energy__heat" src="<?php echo esc_url(fenster_generated_url($studio . 'cas-profile-heat.webp')); ?>"
                        alt="" aria-hidden="true" loading="lazy" width="1100" height="733">
                </span>
            </figure>
            </span>
        </div>

    </section>

    <?php get_template_part('template-parts/components/tech-banner', null, fenster_tech_banner_args('casement-windows')); ?>

    </div><?php /* end .fg-cas-under */ ?>
    </div><?php /* end the energy panel */ ?>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--security">

    <?php /* ---------- 02 SECURITY ---------- */ ?>
    <section class="fg-cas-security" data-fg-cas-reveal aria-labelledby="fg-cas-security-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true"></span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Security', 'fenster'); ?></p>
                <?php /* Both halves come from $security_points[0], which is
                         named "Multi-point locking as standard" and opens "Not
                         an upgrade." This answers the question a buyer actually
                         asks first, which is whether it costs extra.

                         It deliberately does NOT promise a tested window. PAS 24
                         and Secured by Design are "Both available", confirmed
                         per configuration, and a pay-off implying every window
                         we fit is certified would harden a claim this page has
                         been pulled back from more than once. */ ?>
                <h2 id="fg-cas-security-title" class="fg-cas-turn fg-cas-turn--chapter">
                    <span class="fg-cas-turn__set"><?php esc_html_e('Multi-point locking is not an upgrade.', 'fenster'); ?></span>
                    <span class="fg-cas-turn__land"><?php esc_html_e('It is what we fit.', 'fenster'); ?></span>
                </h2>
                <?php /* REWRITTEN 2026-09-06. Owner, of the previous version:
                         "This is waffle."

                         It was "Security in a window is a system: the lock, the
                         glass, and the test the finished window passed. A
                         profile name on its own proves none of it." Three
                         faults. It opened on an abstraction. It then listed the
                         four things the list immediately below already lists,
                         so it previewed rather than added. And it closed on
                         profile names, which is a trade argument -- nobody
                         choosing a window for their house is being sold a
                         profile name and needs warning off it.

                         This takes the shape the energy chapter's lead already
                         uses: name the component, then say what a buyer can
                         choose on top of it. "It is" carries straight on from
                         the heading above, so the lock is named without saying
                         "we fit it as standard" a second time.

                         STILL DOES NOT PROMISE A TESTED WINDOW. PAS 24 and
                         Secured by Design are things you can add, which is the
                         same "available, confirmed per configuration" position
                         the rest of the page holds. */ ?>
                <p class="fg-cas-lead"><?php esc_html_e('It is a Kenrick Excalibur. What you can add on top of it is laminated glass, and a window tested to PAS 24 or Secured by Design.', 'fenster'); ?></p>
            </div>
        </div>
        <?php /* Images left, copy right, which is the arrangement the owner
                 preferred. The mechanism and the keep share the media column so
                 the chapter reads as one band rather than a branded feature
                 followed by a list. */ ?>
        <div class="container fg-cas-security__grid">
            <div class="fg-cas-security__media">
                <?php /* Kenrick's studio photograph with the backdrop and its drop
                         shadow cut away, so the part floats on the band. The shadow
                         stays in CSS, not baked into the file, or it cannot sit on
                         any other colour. The arrival rides the wrapper and the
                         drift the image inside it, so the two never share a
                         transform. */ ?>
                <div class="fg-cas-lock__stage" data-fg-depth="0.15">
                    <div class="fg-cas-lock__arrive" data-fg-lock-arrive>
                        <img class="fg-cas-lock__art"
                            src="<?php echo esc_url(fenster_generated_url($studio . 'cas-kenrick-excalibur.webp')); ?>"
                            srcset="<?php echo esc_attr(fenster_generated_url($studio . 'cas-kenrick-excalibur-640w.webp') . ' 640w, ' . fenster_generated_url($studio . 'cas-kenrick-excalibur.webp') . ' 1100w'); ?>"
                            sizes="(max-width: 860px) 76vw, 460px"
                            alt="<?php esc_attr_e('Kenrick Excalibur multi-point window lock, showing the die-cast gearbox, the square spindle hole, the claws and the steel shoot bolts', 'fenster'); ?>"
                            loading="lazy" width="1100" height="1182">
                    </div>
                </div>
                <?php /* Named here rather than as a heading. The mechanism is one of
                         five things that make the window secure, not the subject of
                         the chapter. */ ?>
                <p class="fg-cas-security__caption"><?php esc_html_e('Kenrick Excalibur multi-point mechanism', 'fenster'); ?></p>
                <?php /* THE KEEP PHOTOGRAPH IS GONE, 2026-09-06, on the owner's
                         instruction: "get rid of the keep pic then."

                         It had been a small card under the lock and it never
                         sat right beside a cut-out that floats. De-carding it
                         helped but did not earn its place: it is a cropped
                         frame photograph with content to all four edges, so it
                         can never float the way the mechanism does, and the
                         list beside it already carries the point in words
                         ("The frame it pulls against").

                         The FILE STAYS. `cas-security-keep.webp` is registered
                         twice in inc/site-data.php for other surfaces, so it is
                         removed from this section only, not from the theme. */ ?>
            </div>
            <dl class="fg-cas-list">
                <?php foreach ($security_points as $point) : ?>
                    <div>
                        <dt><?php echo esc_html($point['name']); ?></dt>
                        <dd><?php echo esc_html($point['copy']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    </div><?php /* end the security panel */ ?>

    <div class="fg-cas-stack__panel fg-cas-stack__panel--versatility">

    <?php /* ---------- 03 VERSATILITY ---------- */ ?>
    <section class="fg-cas-chapter" data-fg-cas-reveal aria-labelledby="fg-cas-versatility-title">
        <div class="container fg-cas-chapter__head">
            <span class="fg-cas-num" aria-hidden="true"></span>
            <div>
                <p class="fg-cas-eyebrow"><?php esc_html_e('Versatility', 'fenster'); ?></p>
                <h2 id="fg-cas-versatility-title" class="fg-cas-display"><?php esc_html_e('One system. Every opening in the house.', 'fenster'); ?></h2>
                <?php /* Trimmed to the first sentence. The combinations band two blocks
                         below already prints "Every window is drawn, made and priced
                         for the hole it goes into" verbatim. One statement per
                         chapter. */ ?>
                <p class="fg-cas-lead"><?php esc_html_e('Three ways of opening and any combination of them, in one outer frame, at any size we can make.', 'fenster'); ?></p>
            </div>
        </div>

        <div class="container">
            <?php /* The three words ARE the three card names, so the sub-head
                     and the cards under it are one list at two scales and no
                     explanatory sentence is needed: the cards are the
                     sentence. */ ?>
            <h3 class="fg-cas-staccato"><?php esc_html_e('Side. Top. Fixed.', 'fenster'); ?></h3>
            <div class="fg-cas-styles" data-fg-cas-reveal>
                <?php foreach ($styles as $style) : ?>
                    <article class="fg-cas-style">
                        <figure>
                            <img src="<?php echo esc_url(fenster_generated_url($style['image'])); ?>" alt="<?php echo esc_attr($style['alt']); ?>" loading="lazy" width="<?php echo esc_attr((string) $style['w']); ?>" height="<?php echo esc_attr((string) $style['h']); ?>"<?php if (! empty($style['focus'])) : ?> style="object-position: <?php echo esc_attr($style['focus']); ?>"<?php endif; ?>>
                        </figure>
                        <h3><?php echo esc_html($style['name']); ?></h3>
                        <p><?php echo esc_html($style['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
        /* Combinations is not a fourth opening style, it is what you get from
           mixing the three, so it reads as a band rather than a fourth card.
           That also keeps the three studio photographs above as one matched
           set instead of putting an elevation shot among them. */
        ?>
        <div class="container fg-cas-combi">
            <figure>
                <img src="<?php echo esc_url(fenster_generated_url($base . 'casement-house-rear-1600w.webp')); ?>"
                    alt="<?php esc_attr_e('Anthracite grey uPVC casement windows in several different configurations across the rear elevation of a house', 'fenster'); ?>"
                    loading="lazy" width="1600" height="900">
            </figure>
            <div>
                <h3><?php esc_html_e('And any combination of the three.', 'fenster'); ?></h3>
                <?php /* TRIMMED 2026-09-06, on a sense check of this chapter. The
                         band said the same thing the lead above it says, then
                         said it again in a second paragraph, then the closer
                         below said it a fourth time. Counted across the page,
                         "made to your opening rather than off a shelf" was
                         being made five times:

                           the overture   "made to your opening rather than to a
                                          stock size"
                           this lead      "in one outer frame, at any size we can
                                          make"
                           this paragraph "share one outer frame, in any
                                          arrangement, at any size we can make"
                           its last line  "drawn for your opening rather than
                                          picked from a catalogue"
                           paragraph two  "no standard size... drawn, made and
                                          priced for the hole it goes into"

                         What only this paragraph had was the SIX LAYOUTS, which
                         are concrete and appear nowhere else, so that is what it
                         keeps. The second paragraph is gone outright: every
                         clause in it was already on the page, and "one system
                         covers the whole house" is the chapter heading.

                         Dropping "share one outer frame, in any arrangement"
                         also gives the closer its job back. It reads "One frame,
                         any arrangement.", which was an echo of this sentence
                         and is now the only place that says it. */ ?>
                <p><?php esc_html_e('This is where the range stops being a list: a fixed centre with openers either side, a run of top openers over a worktop, a three pane window, a splayed bay, a bow, a dormer. Transom and mullion positions are drawn for your opening rather than picked from a catalogue.', 'fenster'); ?></p>
            </div>
        </div>

        <?php /* The hand-off into the choosing, and the reason the owner asked
                 for versatility to come last. A <p>, not a heading, so it
                 cannot compete with the h2 immediately below it.

                 "One frame, any arrangement" is lifted from the paragraph above
                 it ("Openers and fixed panes share one outer frame, in any
                 arrangement"). The second half is the payoff, in ink against
                 the muted first half, so it has to be the thing worth reading.

                 THIS LINE HAS BEEN WRONG TWICE, 2026-09-06, and both faults
                 are worth keeping because they are easy to make again.

                 It was "The rest is how it looks", which described everything
                 below as appearance when the section immediately after it is
                 now Glass make-up -- safety, quiet and warmth. The order change
                 on the same day is what exposed it.

                 It was then "The rest is what you choose", and the owner caught
                 the real trap: "what you choose makes it sound like they dont
                 choose the layout which is above?" He is right. The paragraph
                 directly above is nothing BUT choosing -- bays, bows, dormers,
                 transom and mullion positions drawn for the opening -- so any
                 "the rest is..." construction quietly files the layout under
                 things that are not the reader's to pick, which is the opposite
                 of the argument the whole chapter just made.

                 So it no longer sorts the page into chosen and given. It just
                 says what comes next, which is what a reader at this point
                 actually wants: the glass, then the dressings, colour and
                 handles. Nothing is claimed about who decides what, because by
                 here the answer is obviously all of it.

                 IT CARRIES ITS OWN data-fg-cas-reveal. Hanging it off the
                 section's would fire it when the section TOP crossed the
                 threshold, thousands of pixels above this line, which is the
                 exact fault the owner already caught once. */ ?>
        <div class="container fg-cas-close-row">
            <p class="fg-cas-close" data-fg-cas-reveal>
                <span class="fg-cas-turn__set"><?php esc_html_e('One frame, any arrangement.', 'fenster'); ?></span>
                <span class="fg-cas-turn__land"><?php esc_html_e('Now the glass, and the finish.', 'fenster'); ?></span>
            </p>
            <?php /* Skips to the designer. Same target as the hero's own
                     button, and guarded the same way, so a route without a
                     quote tool does not render a link to nothing. */ ?>
            <?php if ($quote_url !== '') : ?>
                <a class="button fg-cas-close__cta" href="#fenster-product-quote"><?php esc_html_e('Design your window', 'fenster'); ?></a>
            <?php endif; ?>
        </div>
    </section>

    </div><?php /* end the versatility panel */ ?>

    </div><?php /* end .fg-cas-stack — versatility is the last plate, and it
                     hands straight into "Bars, horns and lead." below */ ?>

    <?php
    /* ---------- Everything below scrolls normally --------------------------------
       Owner instruction, 2026-08-05 (evening): the 04 and 05 chapter heads come
       off, and these sections stop stacking.

       They were numbered chapters on their own plates for half a day. The stack
       is a device for the three things that carry an argument — how it opens, how
       warm it is, how secure it is — and the choosing that follows reads better at
       ordinary pace than pinned under it. Ending the stack on security also gives
       the dark band a proper close instead of a light plate sliding over it.

       Their own section heads carry them from here, which is what the rest of the
       site already does. The running order below was changed by the owner on
       2026-09-06 and is now Glass make-up, then Detail / Bars, horns and lead,
       then the finishes components, then Our work with Two faces under it.
       Those are untouched. Nothing below this line is inside `.fg-cas-stack`, so
       no sticky, no z-index ladder and no dim overlay applies to any of it.

       The chapter numbers therefore run 01, 02, 03 and stop, which is the whole
       set: there is no 04 or 05 to be missing. ----------------------------- */
    ?>

    <?php /* Moved above the detail 2026-09-06. Owner: "windwocad designer
             section should sit above detail section." This is the WindowCAD
             section -- its five names and colour coding are lifted from that
             designer, per the note on $glass_marks -- so it now opens the
             choosing rather than sitting midway down it, and the glass is
             settled before the dressings that go on top of it. */ ?>
    <section class="fg-glass-makeup" aria-labelledby="fg-glass-makeup-title">
        <div class="container">
            <div class="section-heading section-heading--wide">
                <?php /* "Glass spec", not "Glass make-up", 2026-09-06 at the
                         owner's request. Make-up is the trade word for what a
                         unit is built from; spec is what a buyer calls the same
                         thing when they are choosing one. */ ?>
                <p class="eyebrow"><?php esc_html_e('Glass spec', 'fenster'); ?></p>
                <?php /* RETITLED 2026-09-06. Owner, of "The glass is the part
                         you live with.": "This title is weird. You live with all
                         of it?" -- and he is right, it was true of every part of
                         the window and therefore said nothing about the glass.

                         What it should have carried is the thing a buyer needs
                         before reading five columns: ONE OF THEM IS ALREADY IN
                         THE PRICE. That is in the data already -- the first
                         option is captioned "Our standard" -- but nothing above
                         the row said so, so all five read as equal choices and
                         the reader had to work out which one they were getting
                         by default.

                         The lead's opening moved with it, from "Five to choose
                         from" to "All five", for the same reason: five to choose
                         from implies a blank slate rather than a standard and
                         four upgrades. */ ?>
                <h2 id="fg-glass-makeup-title"><?php esc_html_e('Toughened glass comes as standard. The rest are upgrades.', 'fenster'); ?></h2>
                <p><?php esc_html_e('All five share the same core: a low-E coating, argon in the cavity and a warm edge spacer. What changes is how many panes there are, and how the glass behaves if something hits it or the road outside is loud.', 'fenster'); ?></p>
            </div>
            <ul class="fg-glass-makeup__row">
                <?php foreach ($glass_options as $option) : ?>
                    <li class="fg-glass-makeup__col" style="--gm-tint: <?php echo esc_attr($option['tint']); ?>;">
                        <?php /* A native <details>, so the detail opens on tap and on
                                 keyboard without a line of JavaScript, and the column
                                 shows three things until someone asks for more. */ ?>
                        <details class="fg-glass-makeup__detail">
                            <summary>
                                <span class="fg-glass-makeup__figure" aria-hidden="true">
                                    <span class="fg-glass-makeup__unit">
                                        <?php foreach ($option['panes'] as $pane) : ?>
                                            <span class="fg-glass-makeup__pane fg-glass-makeup__pane--<?php echo esc_attr($pane); ?>"></span>
                                        <?php endforeach; ?>
                                        <span class="fg-glass-makeup__spacer"></span>
                                    </span>
                                </span>
                                <span class="fg-glass-makeup__name"><?php echo esc_html($option['name']); ?></span>
                                <span class="fg-glass-makeup__uvalue"><?php echo wp_kses($option['uvalue'], []); ?></span>
                                <span class="fg-glass-makeup__more"><?php esc_html_e('What it does', 'fenster'); ?></span>
                            </summary>
                            <div class="fg-glass-makeup__panel">
                                <p class="fg-glass-makeup__caption"><?php echo esc_html($option['caption']); ?></p>
                                <ul class="fg-glass-makeup__marks">
                                    <?php foreach ($option['marks'] as $mark) : ?>
                                        <?php $m = $glass_marks[$mark]; ?>
                                        <li>
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr($m['path']); ?>"/></svg>
                                            <?php echo esc_html($m['label']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <p class="fg-glass-makeup__build"><?php echo esc_html($option['build']); ?></p>
                            </div>
                        </details>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="fg-glass-makeup__foot"><?php esc_html_e('U-values are whole window figures. The survey confirms the glass before anything is ordered.', 'fenster'); ?></p>
        </div>
    </section>

    <?php /* The 2026-08-05 instruction that the detail runs before the two
             faces is SPENT: the two faces moved out to sit under Our work on
             2026-09-06, so there is no longer a pair here to order. The detail
             now follows the glass. */ ?>
    <section class="fg-cas-detail" aria-labelledby="fg-cas-detail-title">
        <div class="container">
            <?php /* The SHARED heading, not `fg-cas-section-head`, since
                     2026-09-06. Owner: "also detail headign is formatted
                     different to the others."

                     There are two heading systems in play here and they are far
                     enough apart to read as a mistake: `fg-cas-*` is a 41.6px
                     display with a green 11.5px eyebrow, the shared one a
                     31.7px h2 with a grey 16px eyebrow. That was fine while the
                     detail sat next to Two faces, both of them `fg-cas`. The
                     2026-09-06 reorder moved Glass make-up above it and left
                     the colour and handle grids below it, all three on the
                     shared style, so the detail alone jumped.

                     It joins them rather than the other way round because it
                     belongs with them: it is one of the optional bits a reader
                     is choosing between, not a chapter. `fg-cas-display` and
                     `fg-cas-eyebrow` stay in use by Our work and Two faces,
                     which close the page and are not choices. */ ?>
            <div class="section-heading section-heading--wide">
                <p class="eyebrow"><?php esc_html_e('Detail', 'fenster'); ?></p>
                <h2 id="fg-cas-detail-title"><?php esc_html_e('Bars, horns and lead.', 'fenster'); ?></h2>
                <?php /* REWRITTEN 2026-09-06. Owner: "Weird sentence."

                         It was "The difference between a replacement window and
                         one that belongs on the house. All four are priced with
                         the window, not added afterwards." The first half is a
                         fragment with no verb, so it lands as an unfinished
                         thought, and it sets up an opposition that is not true:
                         a replacement window is not the opposite of one that
                         belongs on a house, it is what most of these are.

                         The second half was the useful part and is kept, in
                         plainer words: these are quoted with the window rather
                         than bolted on later. Note it says QUOTED, not free --
                         see the note on foil colours in the memory for why that
                         distinction is not casual on this site. */ ?>
                <p><?php esc_html_e('These are what make a new window look like it has always been there. All four are quoted with the window rather than added on afterwards.', 'fenster'); ?></p>
            </div>
            <div class="fg-cas-trio">
                <?php foreach ($details as $detail) : ?>
                    <figure>
                        <?php if ($detail['image'] !== '') : ?>
                            <img src="<?php echo esc_url(fenster_generated_url($detail['image'])); ?>" alt="<?php echo esc_attr($detail['alt']); ?>" loading="lazy" width="<?php echo esc_attr((string) $detail['w']); ?>" height="<?php echo esc_attr((string) $detail['h']); ?>">
                        <?php else : ?>
                            <?php /* Holding the slot rather than dropping the tile: the
                                     option is real and sold, only the photograph is
                                     missing. Dashed and labelled so it reads as
                                     deliberate rather than as a failed image. */ ?>
                            <p class="fg-cas-trio__placeholder"><?php esc_html_e('Photograph to follow', 'fenster'); ?></p>
                        <?php endif; ?>
                        <figcaption><strong><?php echo esc_html($detail['name']); ?></strong><span><?php echo esc_html($detail['copy']); ?></span></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>

            <?php /* THE THREE CROSS-LINKS WERE HERE AND ARE GONE, 2026-09-06. Owner:
                     "Also these options are now superfluous."

                     They pointed at /obscured-glass/, /colour-options/ and
                     /handle-options/. When they were written the page said
                     nothing about any of the three. It now carries Glass spec,
                     the sixteen-colour grid and the handle grid inline, and
                     they sit a screen below this line, so the links offered to
                     take a reader away to something the next scroll shows them
                     anyway. */ ?>
        </div>
    </section>


    <?php /* Colour and handles. Each component carries its own heading, so they
             need nothing above them now the 05 head has gone. The glass used to
             be the third of this group and moved above the detail on
             2026-09-06 at the owner's request. */ ?>
    <?php get_template_part('template-parts/components/upvc-colour-grid', null, ['product_noun' => 'casement window']); ?>
    <?php get_template_part('template-parts/components/handle-grid', null, fenster_window_handle_grid_args()); ?>

    <?php /* eyebrow overridden here only. Its default is "Specification
             choices", which sat above a second band also about glass and read
             as a duplicate. Owner: "you have spec choices, then glass. they're
             both glass options". The component is shared, so the override is
             passed rather than edited. */ ?>
    <?php get_template_part('template-parts/components/privacy-glass-card', null, ['eyebrow' => __('Privacy glass', 'fenster')]); ?>

    <?php /* The glass make-up, fourth in the run of choice components and
             directly under privacy glass. Owner, 2026-09-04: "wrong section.
             wants to go with privacy glass. also make it more like the size of
             the privacy bar thing."

             IT BORROWS THE PRIVACY CARD'S OWN CLASSES rather than defining a
             band of its own: `fg-product-gallery-band`, `section-heading
             --wide`, `fg-product-choice-map--single` and
             `fg-product-option-card`. That is what makes it exactly the size of
             the card above it, and it means this block inherits any future
             change to that chrome instead of drifting from it. The only new CSS
             is the rows inside the card.

             The shared component itself was NOT touched. It renders on the
             generic product journey as well as here, so a second card inside it
             would have appeared on pages nobody asked for it on. */ ?>
    <?php /* ---------- PROOF ---------- */ ?>
    <section class="fg-cas-proof" aria-labelledby="fg-cas-proof-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                    <h2 id="fg-cas-proof-title" class="fg-cas-display"><?php esc_html_e('Casements, fitted by us.', 'fenster'); ?></h2>
                </div>
                <p>
                    <span class="fg-cas-proof__desktop"><?php esc_html_e('Every photograph here is one of our installations, taken on the day we finished. Click any of them for a closer look.', 'fenster'); ?></span>
                    <span class="fg-cas-proof__mobile"><?php esc_html_e('Every photograph is one of our installations. Tap any for a closer look.', 'fenster'); ?></span>
                </p>
            </div>
            <div class="fg-cas-mosaic">
                <?php foreach ($gallery as $index => $image) : ?>
                    <?php
                    $stem = $base . 'gallery/' . $image['file'];
                    $srcset = [
                        fenster_generated_url($stem . '-480w.webp') . ' 480w',
                        fenster_generated_url($stem . '-800w.webp') . ' 800w',
                    ];
                    if ((int) $image['width'] >= 1400) {
                        $srcset[] = fenster_generated_url($stem . '-1400w.webp') . ' 1400w';
                    }
                    $srcset[] = fenster_generated_url($stem . '.webp') . ' ' . (int) $image['width'] . 'w';
                    ?>
                    <figure>
                        <a href="<?php echo esc_url(fenster_generated_url($stem . '.webp')); ?>" data-fg-gallery-lightbox aria-label="<?php echo esc_attr(sprintf(__('Open full image: %s', 'fenster'), $image['alt'])); ?>">
                            <img src="<?php echo esc_url(fenster_generated_url($stem . '-800w.webp')); ?>"
                                srcset="<?php echo esc_attr(implode(', ', $srcset)); ?>"
                                sizes="(max-width: 860px) 82vw, <?php echo $index === 0 ? '46vw' : '23vw'; ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy"
                                style="object-position: <?php echo esc_attr($image['focus']); ?>;">
                            <figcaption>
                                <strong><?php echo esc_html($image['caption']); ?></strong>
                                <span class="fg-cas-tags">
                                    <?php foreach ((array) $image['tags'] as $tag) : ?>
                                        <i><?php echo esc_html($tag); ?></i>
                                    <?php endforeach; ?>
                                </span>
                            </figcaption>
                        </a>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p class="fg-cas-swipe" aria-hidden="true"><?php esc_html_e('Swipe', 'fenster'); ?> <span>&rarr;</span></p>
        </div>
    </section>

    <?php /* Moved down here 2026-09-06. Owner: "Two faces section should be
             under our work section." It used to sit directly under the detail,
             above the finishes. It is still INSIDE the `.fg-cas` wrapper, which
             closes a few lines below -- outside it the section loses the
             wrapper's type and rule colours. */ ?>
    <?php /* Standard against flush, in matched studio photography. */ ?>
    <section class="fg-cas-versus" aria-labelledby="fg-cas-versus-title">
        <div class="container">
            <div class="fg-cas-section-head">
                <div>
                    <p class="fg-cas-eyebrow"><?php esc_html_e('Two faces', 'fenster'); ?></p>
                    <h2 id="fg-cas-versus-title" class="fg-cas-display"><?php esc_html_e('Standard or flush.', 'fenster'); ?></h2>
                </div>
                <p><?php esc_html_e('The same 70mm Liniar uPVC, the same sixteen colours, the same fitters. The sash is the difference, and it changes both the look and the glass.', 'fenster'); ?></p>
            </div>

            <div class="fg-cas-versus__body">
            <div class="fg-cas-versus__pair">
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-sash-proud-w.webp')); ?>" alt="<?php esc_attr_e('White uPVC standard casement window, the opening sash standing proud of the outer frame', 'fenster'); ?>" loading="lazy" width="820" height="857">
                    <figcaption><strong><?php esc_html_e('Standard casement', 'fenster'); ?></strong><span><?php esc_html_e('The sash stands proud. Fixed panes glaze straight into the frame, so they carry more glass.', 'fenster'); ?></span></figcaption>
                </figure>
                <figure>
                    <img src="<?php echo esc_url(fenster_generated_url($studio . 'cas-flush-level-w.webp')); ?>" alt="<?php esc_attr_e('White uPVC flush casement window, four sashes closing level with the frame in one plane', 'fenster'); ?>" loading="lazy" width="820" height="857">
                    <?php /* Owner instruction, 2026-08-05: the link belongs in the
                             flush card rather than at the foot of the section, where
                             it read as a footnote to the comparison instead of the
                             way on from the half of it people are choosing. */ ?>
                    <figcaption><strong><?php esc_html_e('Flush casement', 'fenster'); ?></strong><span><?php esc_html_e('Every sash closes level with the frame, in one plane, the way timber joinery sits.', 'fenster'); ?></span><a class="fg-cas-link fg-cas-versus__link" href="<?php echo esc_url(home_url('/flush-casement-windows/')); ?>"><?php esc_html_e('See flush casements', 'fenster'); ?></a></figcaption>
                </figure>
            </div>

            <table class="fg-cas-table">
                <thead>
                    <tr>
                        <th scope="col"><span class="fg-cas-sr"><?php esc_html_e('Specification', 'fenster'); ?></span></th>
                        <th scope="col"><?php esc_html_e('Standard', 'fenster'); ?></th>
                        <th scope="col"><?php esc_html_e('Flush', 'fenster'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($versus_rows as $row) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($row['label']); ?></th>
                            <td><?php echo esc_html($row['a']); ?></td>
                            <td><?php echo esc_html($row['b']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </section>

</div>

<?php
// The wrapper closes here. Its base type rules are (0,1,1) and would otherwise
// repaint the shared quote, FAQ, enquiry and review components.
?>

    <?php if ($quote_url !== '') : ?>
        <section id="fenster-product-quote" class="fg-product-quote-embed" aria-label="<?php echo esc_attr($quote_label . ' instant quote'); ?>">
            <div class="container fg-product-quote-embed__grid">
                <div class="fg-product-quote-embed__copy">
                    <p class="eyebrow"><?php esc_html_e('Instant quote', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Price it online, or let us come to you.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Your sizes, your finishes, a real figure in minutes. Survey confirms the layout, glass and hardware before anything is made.', 'fenster'); ?></p>
                </div>
                <article class="fg-product-quote-embed__card" data-quote-card>
                    <div class="fg-product-quote-embed__bar">
                        <h3><?php esc_html_e('uPVC window quote tool', 'fenster'); ?></h3>
                        <div class="fg-product-quote-embed__actions">
                            <button class="button button--light" type="button" data-fullscreen-quote><?php esc_html_e('Expand view', 'fenster'); ?></button>
                            <a class="button" href="<?php echo esc_url($quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
                            <a class="button fg-product-quote-embed__mobile-open" href="<?php echo esc_url($quote_url); ?>"><?php esc_html_e('Open quote tool', 'fenster'); ?></a>
                        </div>
                    </div>
                    <div class="fg-product-quote-embed__frame" data-quote-frame-wrap data-lenis-prevent data-quote-url="<?php echo esc_url($quote_url); ?>" data-quote-autoload="near">
                        <div class="fg-quote-frame-placeholder fg-product-quote-embed__placeholder">
                            <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                            <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                        </div>
                        <iframe data-quote-iframe-src="<?php echo esc_url($quote_url); ?>" title="<?php echo esc_attr($quote_label . ' instant quote tool'); ?>" loading="lazy" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </article>
            </div>
        </section>
    <?php endif; ?>

    <?php fenster_render_faq_page_schema($faqs); ?>
    <section class="fg-product-faq" aria-labelledby="fg-cas-faq-title">
        <div class="container fg-product-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Casement window questions', 'fenster'); ?></p>
                <h2 id="fg-cas-faq-title"><?php esc_html_e('The details worth settling before you order.', 'fenster'); ?></h2>
                <p><?php esc_html_e('All of these refer to the 70mm Liniar EnergyPlus system on this page.', 'fenster'); ?></p>
            </div>
            <div class="fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer"><p><?php echo esc_html($faq['answer']); ?></p></div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (function_exists('fenster_case_studies_for_product')) : ?>
        <?php
        /* THE HEADING FOLLOWS THE MATCH, 2026-08-13. `fenster_case_studies_for_
           product()` falls back to every study when nothing claims this route,
           and "Three casement jobs" is a promise those three are casement work.
           The helper now reports which case it handed back, so the honest
           heading is chosen rather than the strip being gated off. Same wording
           as the shared strip in generated-page.php. */
        $cas_case_is_fallback = false;
        $cas_studies = fenster_case_studies_for_product('casement-windows', 3, 'residential', $cas_case_is_fallback);
        ?>
        <?php if ($cas_studies !== []) : ?>
            <section class="fg-cs-strip">
                <div class="container">
                    <div class="fg-cs-strip__head">
                        <?php if ($cas_case_is_fallback) : ?>
                            <p class="eyebrow"><?php esc_html_e('Our work', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Recent work across the range.', 'fenster'); ?></h2>
                            <p><?php esc_html_e('Jobs we have finished recently, fitted by our own installers and photographed the day we finished. They cover the range rather than this product.', 'fenster'); ?></p>
                        <?php else : ?>
                            <p class="eyebrow"><?php esc_html_e('From our case studies', 'fenster'); ?></p>
                            <h2><?php esc_html_e('Three casement jobs, start to finish.', 'fenster'); ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="fg-cs-strip__grid">
                        <?php foreach ($cas_studies as $card) : ?>
                            <?php get_template_part('template-parts/components/case-study-card', null, ['card' => $card, 'heading' => 'h3']); ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="button-row fg-cs-strip__cta">
                        <a class="button button--light" href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('See all case studies', 'fenster'); ?></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <section id="fenster-enquiry" class="fg-enquiry">
        <div class="container fg-enquiry__grid">
            <div class="fg-enquiry__copy">
                <p class="eyebrow"><?php esc_html_e('Request a quote', 'fenster'); ?></p>
                <h2><?php esc_html_e('Tell us about the windows.', 'fenster'); ?></h2>
                <p><?php esc_html_e('How many, what sort of property, and the main reason for replacing them. That is enough to start with.', 'fenster'); ?></p>
                <div class="fg-contact-list">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                    <a href="mailto:<?php echo esc_attr((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?>"><?php echo esc_html((string) ($brand['email'] ?? 'info@fensterglazing.com')); ?></a>
                </div>
            </div>
            <?php
            get_template_part('template-parts/components/enquiry-form', null, [
                'class' => 'fg-form',
                'source' => 'Casement Windows',
                'button_label' => 'Send my casement details',
                'project_type' => 'Casement windows',
                'lock_project_type' => true,
                'compact' => true,
            ]);
            ?>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--product',
        'trust_items' => $trust_items,
        'limit' => 7,
        'prioritise_context' => 'windows',
    ]);
    ?>
