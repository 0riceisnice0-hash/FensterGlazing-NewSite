<?php
/**
 * Commercial product page data.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * A specification figure nobody has confirmed yet.
 * ---------------------------------------------------------------------------
 * The commercial audit of 2026-08-12 found TEN OF ELEVEN commercial pages
 * carrying no specification figure at all, on pages written for people who
 * price work. `STYLE.md`, Commercial Pages: "Give them the number they have to
 * put in a schedule. A commercial page that describes a product without its
 * figures has not done its job."
 *
 * Most of those numbers do not exist in this repository yet. The louvre
 * standard is real figures or none, never an invented one, so every value we
 * have not been given is this single sentinel rather than a guess, a rounded
 * number or a silent omission. Three things follow from that:
 *
 *   - `grep -c FENSTER_SPEC_TBC inc/commercial-product-data.php` is the exact
 *     count of what is outstanding.
 *   - `fenster_commercial_spec_pending()` prints the owner's checklist, per
 *     route, in one call. It is the only place that list is maintained.
 *   - The template renders a pending row as a visible "confirming on request"
 *     line rather than hiding it, because a specifier reading a spec table with
 *     a row missing concludes we do not do it. A row that says we are checking
 *     is an invitation to ask; an absent row is a lost enquiry.
 *
 * TO FILL ONE IN: replace the sentinel with the confirmed value. Nothing else
 * changes anywhere, which is the whole point of the indirection.
 */
const FENSTER_SPEC_TBC = '__fenster_spec_tbc__';

/**
 * Is this specification value still waiting on the owner?
 */
function fenster_spec_is_pending($value): bool
{
    return ! is_string($value) || $value === '' || $value === FENSTER_SPEC_TBC;
}

/**
 * Every outstanding specification figure, grouped by route.
 * ---------------------------------------------------------------------------
 * The single source for "what do you still need from me". Do not keep a second
 * copy of this list in a document: a hand-kept list drifts, and this one cannot,
 * because it reads the same array the pages render from.
 *
 * @return array<string, array{title: string, pending: string[]}>
 */
function fenster_commercial_spec_pending(): array
{
    $out = [];

    foreach (fenster_commercial_product_pages() as $slug => $page) {
        $rows = is_array($page['specification'] ?? null) ? $page['specification'] : [];
        $pending = [];

        foreach ($rows as $row) {
            if (! fenster_spec_is_pending($row['value'] ?? null)) {
                continue;
            }

            $pending[] = (string) ($row['pending'] ?? ($row['label'] ?? 'Unnamed figure'));
        }

        if ($pending !== []) {
            $out[$slug] = [
                'title' => (string) ($page['title'] ?? $slug),
                'pending' => $pending,
            ];
        }
    }

    return $out;
}

function fenster_commercial_product_pages(): array
{
    $asset_base = '/wp-content/themes/fenster/assets/images/imported/';
    $sector_base = '/wp-content/themes/fenster/assets/images/commercial-sectors/';

    /* OUR OWN COMMERCIAL WORK, 2026-08-12. The audit found every commercial page
       drawing from `assets/images/imported/`, the scrape archive, including a
       residential composite-looking door, a CGI render this repository had
       already removed from a hub tile once, and three Smart Systems marketing
       shots — a competitor's product photography on pages selling Sheerline.

       Meanwhile four real commercial jobs were sitting in the case-study library
       unused by any commercial route: All Hallows (AOV windows, screens and
       steel doorsets), the Bletchley rail depot (curtain walling, windows and
       doors), Headrow Court (student accommodation) and Heal's. Those are our
       work, they are photographed properly, and they prove exactly what these
       pages claim. The commercial/ folder adds the replacement-glazing job.

       Every route below now leads on a real photograph where one exists. Where
       none does, it says so with a marked placeholder rather than borrowing a
       neighbouring product's picture — the fault that put a residential door on
       the automation page in the first place. */
    $cs_base = '/wp-content/themes/fenster/assets/images/case-studies/';
    $commercial_base = '/wp-content/themes/fenster/assets/images/commercial/';

    return [
        'commercial-windows-and-doors' => [
            'eyebrow' => 'Commercial windows and doors',
            'title' => 'Commercial windows and doors',
            'subtitle' => 'Aluminium and uPVC windows, doorsets and entrance screens for commercial buildings, supplied and installed as one package.',
            /* Was "One package, one contractor, one set of interfaces." — jargon
               shaped like a benefit. "A set of interfaces" is not something anybody
               buys or asks for. This is the concrete triad the voice actually
               uses. */
            'intro_heading' => 'One survey, one order, one team on site.',
            /* Was `commercial-1.jpg` and `commercial-4.jpg`, both scrape. This is
               the Bletchley rail depot: curtain walling, windows and doors on one
               building, all ours, and the single best photograph on the site of
               what this page actually sells. */
            'hero_image' => $cs_base . 'cs-bletchley-rail-depot-elevation.webp',
            'hero_alt' => 'Refurbished rail depot elevation with new aluminium curtain walling, windows and entrance doors',
            'intro_image' => $cs_base . 'cs-all-hallows-bedford-terrace-run.webp',
            'intro_alt' => 'A run of new aluminium windows and screens across a terrace elevation at All Hallows, Bedford',
            'summary' => [
                /* THE SECOND SENTENCE WAS NONSENSE and the owner called it: "one
                   contractor then owns the joints between the frame, the glass and
                   the hardware, and they get settled once". Frames, glass and
                   hardware have no joints between them. It was abstract filler
                   wearing technical clothes, and it was also the fourth time this
                   page said "as one package" in different words.

                   What replaces it is the thing a contractor actually cares about
                   and can check: the same firm measures it and fits it, so there is
                   one number to ring. */
                'We survey, supply and install the whole opening: aluminium and uPVC windows, glazed doorsets, entrance screens, the glass in them and the ironmongery on them. The people who measure it are the people who fit it, and there is one firm to ring if anything needs putting right.',
                'We work from your drawings and schedules where you have them, and from a site survey where you do not. On occupied buildings the sequence is agreed before we start: which elevations, in what order, during which hours, and what is handed back at the end of each day. At <a href="' . esc_url(home_url('/commercial-projects/all-hallows-bedford/')) . '">All Hallows in Bedford</a> that package ran to eight AOV window units, a glazed entrance screen, a large fixed screen and ten fire-rated steel doorsets.',
            ],
            'stats' => [
                ['value' => 'Aluminium', 'label' => 'and uPVC, specified per opening'],
                ['value' => 'Doorsets', 'label' => 'screens, toplights and ironmongery'],
                ['value' => 'Occupied', 'label' => 'buildings, phased and sequenced'],
            ],
            /* SPEC TABLE. Almost all of this is outstanding: the audit's §6b asks
               the owner for the commercial-side systems, the fire ratings we can
               claim and our PAS 24 position on commercial work. Every one is a
               question an estimator asks on the first call, so the rows exist and
               say we are confirming rather than being quietly left out. */
            /* Owner-confirmed 2026-08-12. Systems named lightly and never as the
               focus, per the Supplier Naming Rule: these are known brands a
               specifier recognises, not the fabricator, and a spec row is exactly
               the "clause not a section" the rule allows.

               PAS 24 IS PHRASED AS AVAILABLE, NOT ASSERTED. The standard belongs
               to a tested complete doorset, never to a company or a profile —
               the same distinction the Kenrick Excalibur and Liniar PAS 24 notes
               are held to. "We can do it where specified" is true; "our
               commercial glazing is PAS 24" would not be. */
            'specification' => [
                ['label' => 'Aluminium systems', 'value' => 'Technal, Smart and Senior among others, specified to the job.'],
                ['label' => 'uPVC systems', 'value' => 'Liniar.'],
                ['label' => 'Fire rating', 'value' => 'Fire-rated glazing and fire-rated steel doorsets, supplied to the rating the specification calls for.'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design available where the specification calls for them.'],
                /* FIRE ADDED TO THIS ROW 2026-08-30, AND IT IS PROVEN RATHER THAN
                   CLAIMED: All Hallows carried ten steel doorsets, fire rated to
                   the project specification, photographed and written up. The
                   hedge is the same one the glazing row carries, "to the
                   specification", because a rating belongs to a tested doorset
                   and never to us. DO NOT publish an FD or EI figure; none is
                   confirmed. The four other routes carrying the shared fire-rating
                   row are deliberately untouched: none of them supplies doorsets. */
                ['label' => 'Steel doorsets', 'value' => 'Supplied within this package, fire rated to the specification and security rated up to SR3.'],
                ['label' => 'Glass', 'value' => 'Toughened, laminated, low-e, solar control, acoustic and obscure, specified per opening.'],
                ['label' => 'Finish', 'value' => 'Powder coated to any RAL. Dual colour where the inside and outside differ.'],
                ['label' => 'Coverage', 'value' => 'Nationwide across England and Wales.'],
            ],
            'capabilities_heading' => 'What we take on within a window and door package.',
            'capabilities' => [
                ['title' => 'Replacement window runs', 'copy' => 'Aluminium or uPVC, measured opening by opening rather than off the drawing, because a refurbished building rarely matches it.'],
                ['title' => 'Doorsets and entrance screens', 'copy' => 'Commercial doorsets with the side screens, toplights, closers, locks and threshold details specified as one assembly.'],
                ['title' => 'Glass and sealed units', 'copy' => 'Toughened, laminated, low-e, solar control, acoustic and obscure, chosen against what the opening has to do.'],
                ['title' => 'Occupied-building sequencing', 'copy' => 'Phasing, access routes, out-of-hours working and daily handback agreed at quote stage, not discovered in week two.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'One package',
                    'title' => 'Frames, glass and ironmongery specified together.',
                    'copy' => 'Specifying the whole opening at once is how the details end up matching: a restrictor sized to the opening, a closer sized to the door and its exposure, a threshold that meets Part M. We set opening sizes, glass type, restrictors, ventilation, finish, locks, closers, handles and thresholds together before anything is ordered.',
                    'image' => $cs_base . 'cs-all-hallows-bedford-screen.webp',
                    'alt' => 'A new aluminium glazed screen and doorset in a brick elevation at All Hallows, Bedford',
                    'points' => ['Opening sizes surveyed, not assumed', 'Glass specified per opening', 'Ironmongery scheduled with the frames'],
                ],
                [
                    'eyebrow' => 'Scale',
                    'title' => 'One problem opening, or every elevation on the building.',
                    'copy' => 'The same survey answers both. Sometimes the right answer is a replacement sealed unit into a frame that is sound, sometimes it is the whole run, and telling you which is cheaper is worth more to us than selling you the larger job. Send photographs and a schedule and we will say which one we think it is.',
                    'image' => $cs_base . 'cs-heals-tottenham-court-run.webp',
                    'alt' => 'A long run of replacement aluminium windows across a city centre elevation',
                    'points' => ['Single openings', 'Phased replacement programmes', 'Repair, reglaze or replace, said plainly'],
                ],
            ],
            'use_cases_heading' => 'Buildings this package usually goes into.',
            'use_cases' => ['Offices', 'Schools and academies', 'Retail units', 'Healthcare buildings', 'Care settings', 'Hospitality premises', 'Public buildings', 'Industrial offices'],
            /* FAQS, ADDED 2026-08-15 ACROSS ALL THIRTEEN COMMERCIAL ROUTES.
               ------------------------------------------------------------
               EVERY ANSWER RESTATES SOMETHING THIS ROUTE ALREADY PUBLISHES —
               a specification row, a capability, a summary paragraph or a
               named job. Not one introduces a new claim, and that is the rule
               to hold any future addition to. If an answer needs a fact the
               page does not carry, the fact goes to the owner first and the
               page gets it before the FAQ does.

               They are also written in the commercial register: the answer
               opens on the fact rather than warming up to it. No selling by
               describing what goes wrong, and nothing phrased as what we do
               not offer, per the standing rulings in `TONEOFVOICE.md`. */
            'faqs' => [
                [
                    'question' => 'Which window and door systems do you work with?',
                    'answer' => 'Aluminium from Technal, Smart and Senior among others, specified to the job rather than to one supplier relationship, and uPVC from Liniar. We work from your drawings and schedules where you have them, and from a site survey where you do not.',
                ],
                [
                    'question' => 'Can you supply fire-rated and security-rated openings?',
                    'answer' => 'Fire-rated glazing and fire-rated steel doorsets are supplied to the rating the specification calls for. PAS 24 and Secured by Design are available where the specification calls for them, and steel doorsets are supplied within the same package, security rated up to SR3. At All Hallows in Bedford we fitted ten fire-rated steel doorsets alongside the glazing.',
                ],
                [
                    'question' => 'Can you work on a building that stays open?',
                    'answer' => 'Yes. Phasing, access routes, out-of-hours working and daily handback are agreed at quote stage rather than discovered in week two, and openings are measured one by one rather than off the drawing, because a refurbished building rarely matches it.',
                ],
                [
                    'question' => 'What glass can you specify?',
                    'answer' => 'Toughened, laminated, low-e, solar control, acoustic and obscure, chosen per opening against what that opening has to do. Frames are powder coated to any RAL, with dual colour where the inside and outside differ.',
                ],
                [
                    'question' => 'Where do you work?',
                    'answer' => 'Nationwide across England and Wales.',
                ],
            ],
        ],
        /* CURTAIN WALLING is the route the audit rated worst against the standard:
           the most search demand and the least substance. It named no system, no
           mullion or transom size, no U-value and no wind-load standard, on the
           one commercial product where a specifier will not pick up the phone
           without them. Almost every row in the table below is therefore pending,
           and that is the honest state until the owner supplies them. */
        'curtain-walling' => [
            'eyebrow' => 'Curtain walling',
            'title' => 'Curtain walling',
            'subtitle' => 'Aluminium curtain walling, glazed screens and entrance facades, surveyed, supplied and installed on commercial refurbishments and new openings.',
            'intro_heading' => 'A facade that carries its own weight, the weather and the building\'s movement.',
            'hero_image' => $commercial_base . 'comm-curtain-walling-parade-1600w.jpg',
            'hero_alt' => 'A glazed aluminium curtain walling elevation across a commercial parade',
            /* Owner, 2026-08-12: this shot can be used on curtain walling too. It
               earns the slot — the ground floor is a glazed screen with infill
               panels set in a framed grid, which is the thing this page sells —
               and it breaks up a route that was otherwise carrying the Bletchley
               depot three times over. */
            'intro_image' => $commercial_base . 'comm-industrial-unit-install-1600w.jpg',
            'intro_alt' => 'A glazed ground-floor screen with infill panels set into a framed grid on a commercial unit, with new aluminium windows above',
            'summary' => [
                'Curtain walling is a non-structural envelope hung off the building frame. It carries its own dead load, the wind load on the elevation and whatever the structure does underneath it, and it drains itself. That last part is what separates a curtain wall from a big window: water that gets past the outer seal is meant to, and the system takes it back out at the cill.',
                'We survey, supply and install it on replacement facades, refurbishments and new openings, with doors, opening vents, insulated panels and louvres worked into the grid rather than added to it. Our most recent scheme of this type was the <a href="' . esc_url(home_url('/commercial-projects/bletchley-rail-depot-refurbishment/')) . '">Bletchley rail depot refurbishment</a>.',
            ],
            'stats' => [
                ['value' => 'Facades', 'label' => 'replacement and new openings'],
                ['value' => 'Integrated', 'label' => 'doors, vents, panels and louvres'],
                ['value' => 'Any RAL', 'label' => 'powder coated, dual colour available'],
            ],
            /* Owner answers, 2026-08-13, closing all three of the pending rows
               this route carried since 2026-08-12.

               THE FRAMING MATTERS MORE THAN ANY SINGLE FIGURE, and it is the
               owner's own: "as we dont use just one supplier its more of a guide
               than a source of truth with commercial". Commercial work is
               specified per client and per job across several systems, so a
               figure here describes what the systems reach, not a fixed product
               specification. That is what `spec_note` below says out loud, and it
               is why the U-value is deliberately hedged rather than exact.

               U-VALUE: "as low as 0.9", left vague on the owner's instruction
               because the system varies by client request. Written as a floor
               with the reason attached, not as a headline figure, so nobody puts
               0.9 into a schedule without asking us against their elevation.

               CAPPED: confirmed, and the hedge of 2026-08-12 ("capped only (i
               think)") is now a straight answer. STATED POSITIVELY. The owner's
               instruction was "we only offer capped but dont leave that as a
               negative", which is also the 2026-08-02 standing ruling that this
               site does not write copy about what is not offered. So the row
               names the method we use and stops. Do not add "not structural".

               MAXIMUM PANEL: the row is GONE rather than pending, on the owner's
               instruction — "dont know max panel size, leave out max size as
               unsure again due to various products". Same treatment the mullion
               and transom row got for the same reason: a row nobody can answer
               is worse than no row.

               The mullion and transom row remains gone from 2026-08-12: the
               owner's answer was "irrelevant", meaning it varies per job and
               publishing a size would mislead. */
            'specification' => [
                /* STICK SYSTEM, NAMED POSITIVELY AND FOLDED INTO THE SYSTEM ROW.
                   It describes what this page already said rather than adding a
                   capability: the grid is set out and assembled on site, which is
                   what a stick system is. Named the way capped is, per the owner's
                   2026-08-13 instruction that where we offer one method we state it
                   and stop. DO NOT add "not unitised" — that is the standing ruling
                   against writing what is not offered.

                   IT IS ONE ROW RATHER THAN TWO BECAUSE THIS GRID IS ROW-MAJOR AND
                   TWO COLUMNS WIDE. A seventh row leaves the bottom-right cell
                   empty, which is the orphan-cell fault FULL-SITE-AUDIT-2026-08-13
                   records against this whole section. Six rows fill three even rows.
                   Count the rows before adding one here. */
                ['label' => 'System', 'value' => 'Stick system, specified to the job rather than tied to one system, with the mullion and transom grid set out and assembled on site.'],
                ['label' => 'Wind load', 'value' => 'Wind load calculated for the elevation as part of the design.'],
                ['label' => 'U-value', 'value' => 'As low as 0.9 W/m²K, depending on the system and the glazing specified.'],
                ['label' => 'Glazing method', 'value' => 'Capped systems, with the cap profile specified to the elevation.'],
                ['label' => 'Integrated units', 'value' => 'Doorsets, opening vents, AOV units, spandrel and insulated panels, and ventilation louvres within the grid.'],
                ['label' => 'Finish', 'value' => 'Powder coated to any RAL, dual colour available.'],
            ],
            /* Route-specific replacement for the shared specification note. See
               the framing paragraph above: on commercial work we specify across
               several systems, so these figures are a guide rather than a product
               datasheet, and a specifier is better served being told that than
               discovering it at tender. */
            'spec_note' => 'We specify curtain walling across more than one system, chosen for the job rather than for a supplier relationship, so treat these figures as a guide to what the systems reach. Send us the elevation and we will confirm the numbers in writing against your drawings before they go into a schedule.',
            'capabilities_heading' => 'What we take on within a curtain walling package.',
            'capabilities' => [
                ['title' => 'Screens and elevations', 'copy' => 'Stick-built mullion and transom grids across full elevations, atria, stairwells and entrance bays.'],
                ['title' => 'Doors inside the grid', 'copy' => 'Commercial doorsets, side screens and toplights set into the curtain wall rather than butted against it.'],
                ['title' => 'Panels, vents and louvres', 'copy' => 'Insulated infill panels, opening vents, AOV units and ventilation louvres carried in the same framing.'],
                ['title' => 'Replacement facades', 'copy' => 'Stripping and replacing a failed or tired facade on a building that stays in use behind it.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Setting out',
                    'title' => 'The grid is fixed before anything is made.',
                    'copy' => 'Mullion centres, transom heights, door positions and glass sizes are one decision, not four. Move a transom late and the glass schedule, the panel sizes and the door head all move with it. We set the grid out from your drawings, or survey the opening and set it out from the building, and confirm it before manufacture.',
                    'image' => $cs_base . 'cs-bletchley-rail-depot-reception.webp',
                    'alt' => 'Glazed curtain walling reception screen with entrance doors set into the grid',
                    'points' => ['Mullion and transom centres', 'Door and vent positions', 'Glass schedule confirmed before order'],
                ],
                [
                    'eyebrow' => 'Interfaces',
                    'title' => 'Head, cill, jamb and drainage are where a facade is made watertight.',
                    'copy' => 'A curtain wall drains internally and discharges at the cill, so the details where it meets the structure do more work than the ones you can see. We set out fixing points, movement allowance, cill and jamb interfaces and drainage paths against the existing structure before anything is fixed to it.',
                    'image' => $cs_base . 'cs-bletchley-rail-depot-head-detail.webp',
                    'alt' => 'Head detail where new curtain walling meets the existing structure above it',
                    'points' => ['Fixing points and movement', 'Drainage and weathering', 'Existing structure surveyed first'],
                ],
            ],
            'use_cases_heading' => 'Where curtain walling usually goes.',
            'use_cases' => ['Office elevations', 'Glazed entrances', 'Stairwells and atria', 'Retail frontages', 'Reception screens', 'Replacement facades', 'Education blocks', 'Industrial offices'],
            /* THE U-VALUE ANSWER CARRIES ITS OWN HEDGE AND MUST KEEP IT. The
               figure is published as a floor because we specify across several
               systems; an answer engine quoting "0.9" without the condition is
               exactly what the owner's 2026-08-13 framing exists to prevent, so
               the condition is inside the same sentence rather than after it. */
            'faqs' => [
                [
                    'question' => 'What U-value does your curtain walling achieve?',
                    'answer' => 'As low as 0.9 W/m²K, depending on the system and the glazing specified. We specify curtain walling across more than one system, so treat that as a guide to what the systems reach rather than a fixed figure, and send us the elevation so we can confirm it in writing against your drawings.',
                ],
                [
                    'question' => 'Which glazing method do you use?',
                    'answer' => 'Capped systems, with the cap profile specified to the elevation.',
                ],
                [
                    'question' => 'How is the curtain walling assembled?',
                    'answer' => 'As a stick system: the mullion and transom grid is set out and assembled on site, glazed with capped systems and the cap profile specified to the elevation. The grid is set out from your drawings, or from a survey of the opening, and confirmed before manufacture.',
                ],
                [
                    'question' => 'What can be built into the curtain walling grid?',
                    'answer' => 'Doorsets, opening vents, AOV units, spandrel and insulated panels, and ventilation louvres, all carried in the same framing rather than added to it.',
                ],
                [
                    'question' => 'Can you replace a facade on a building that stays in use?',
                    'answer' => 'Yes. Stripping and replacing a failed or tired facade with the building occupied behind it is one of the four things this package covers, alongside screens and elevations, doors inside the grid, and panels, vents and louvres.',
                ],
                [
                    'question' => 'How is wind load handled?',
                    'answer' => 'Wind load is calculated for the elevation as part of the design, and the grid is set out from your drawings or from a survey of the opening and confirmed before manufacture.',
                ],
            ],
        ],
        'louvre-vents' => [
            'eyebrow' => 'Louvre vents',
            'title' => 'Louvre vents',
            'subtitle' => 'Aluminium ventilation louvres supplied and fitted as part of the glazing package: plant rooms, service areas, screened openings and continuous facade runs.',
            'intro_heading' => 'Ventilation louvres for plant, service and screened openings.',
            /* THE HERO IS A LOUVRE NOW. Owner, 2026-08-11: "hero image isnt
               louvres", and it was not — a timber-and-glass entrance with no
               louvre anywhere in it, on the louvre page. This is ours, at
               Headrow Court.

               The note that used to sit here said a wide crop of a single panel
               reads as blade texture rather than as a louvre, and that is true
               when the photograph has to PROVE the product. Behind hero copy,
               under the shade, texture is what a hero background is for, and a
               wall of blades says louvre before a word is read. A wide shot of
               a louvre run in context would still be better; it does not exist
               yet. */
            'hero_image' => '/wp-content/themes/fenster/assets/images/products/louvre/louvre-plant-doors-2048w.webp',
            'hero_alt' => 'Two pairs of louvred aluminium plant room doors in a red brick elevation, labelled Plant and UPS Plant',
            /* Was `SM-037-001.jpg`, a generic aluminium glazing detail. This is
               a page about louvres and it carried no photograph of a louvre
               anywhere on it. This one is ours, from Headrow Court in Leeds.

               The hero above is still a general commercial elevation, which is
               defensible for a banner: a wide crop of a single louvre panel
               reads as blade texture rather than as a louvre, the same trap the
               secondary glazing and replacement glazing heroes both hit. */
            /* The doorset moves up here now the panel is the hero. Two
               photographs, each used once: repeating one across a hero and a
               body section is the fault the residential product template has a
               whole image queue to avoid. */
            /* The scope-of-works image is the one that shows the argument the
               copy makes: a louvre panel and a window in the same frame line,
               being fitted from the same scaffold on the same day. Two fitters
               are in it and neither face is visible — both are turned away —
               so nothing is blurred here, unlike the Heal's study. */
            'intro_image' => '/wp-content/themes/fenster/assets/images/products/louvre/louvre-glazing-line-1200w.webp',
            'intro_alt' => 'A grey aluminium louvre panel and a window in the same frame line, being installed from a scaffold',
            'summary' => [
                'A louvre goes into an opening that has to move air: a plant room, a substation, a bin store, a riser, a car park, or a run across a facade screening something behind it. It has four jobs at once. Pass enough air to meet the mechanical schedule, resist the weather, stop people seeing in, and sit properly in the elevation.',
                'We supply and fit the range as part of the aluminium package, so the louvre is drawn, coloured and fixed alongside the windows and doors either side of it rather than ordered separately and made to fit afterwards. Send the free area required and the opening size and we will confirm which system meets it.',
            ],
            'stats' => [
                ['value' => '43.5-57%', 'label' => 'physical free area across the range'],
                ['value' => '30-95mm', 'label' => 'blade centres, close-pitched to wide open'],
                ['value' => 'Any RAL', 'label' => 'powder coated, or anodised to order'],
            ],
            'capabilities' => [
                ['title' => 'Louvre panels', 'copy' => 'Aluminium louvre panels fitted into suitable commercial openings, windows or facade systems.'],
                ['title' => 'Plant ventilation', 'copy' => 'Panels reviewed against airflow, free area and the available opening.'],
                ['title' => 'Screened openings', 'copy' => 'Louvres for service areas where airflow is needed but visibility should be reduced.'],
                ['title' => 'Integrated frames', 'copy' => 'Colour and frame details coordinated with surrounding glazing where the package allows.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Airflow and free area',
                    'title' => 'Ventilation requirements need to be known before the louvre is priced.',
                    'copy' => 'If the panel serves plant, mechanical ventilation or a specific building-service requirement, send us the free-area target or the consultant\'s schedule and we will size the louvre against it. Physical free area is the number a schedule means, and it is the lower of the two.',
                    /* Was `commercial-5.jpg`, a general commercial glazing shot.
                       This section is about plant and ventilation and now shows
                       one of ours: a fully louvred plant room doorset, which is
                       a different product from the fixed panel in the intro
                       image above and is the thing the `use_cases` list means by
                       plant rooms and back-of-house. Added 2026-08-10. */
                    'image' => '/wp-content/themes/fenster/assets/images/products/louvre/louvre-plant-doorset-1300w.jpg',
                    'alt' => 'A pair of fully louvred aluminium plant room doors set into dark brickwork',
                    'points' => ['Free-area checks', 'Plant or ventilation brief', 'Suitable panel size'],
                ],
                [
                    'eyebrow' => 'Facade appearance',
                    'title' => 'Louvres should sit neatly within the surrounding windows or screens.',
                    'copy' => 'We coordinate louvre colour, frame depth, surrounding trims and maintenance access so the panel forms part of the glazing package rather than a separate add-on bolted into a hole.',
                    /* Was `Smart-043-003.jpg`, Smart Systems marketing photography
                       — a competitor's product on a page we sell around our own
                       supply. Flagged in the commercial audit, 2026-08-12. This is
                       ours, from Heal's, and it shows a louvre sitting in a run of
                       windows, which is the point the copy is making. */
                    'image' => $cs_base . 'cs-heals-tottenham-court-looking-up.webp',
                    'alt' => 'Looking up a city centre elevation where louvre panels sit in line with the window run',
                    'points' => ['Frame integration', 'Powder-coated finishes', 'Maintenance access'],
                ],
            ],
            'use_cases_heading' => 'Openings a louvre usually closes.',
            'use_cases' => ['Plant rooms', 'Substations', 'Bin stores', 'Risers and ducts', 'Car parks', 'Screened facades', 'Back-of-house', 'Office refurbishments'],
            /* NO SUPPLIER NAME IN ANY ANSWER. Model codes are fine and the
               brand is not, per the Louvre Vents Rule and the Supplier Naming
               Rule: they are a fabricator, so naming them hands a specifier a
               route straight past us. The IKL33 answer keeps the page's own
               admission that it is the lowest free area of the four, because a
               page that leads with its commonest product and hides that
               product's weakest number is what a consultant notices. */
            'faqs' => [
                [
                    'question' => 'How is a louvre sized?',
                    'answer' => 'On free area, and there are two kinds of it. Visual free area is what you can see through. Physical free area is what air actually passes through, tested to EN 13030:2002, and it is the lower number and the one a mechanical schedule means. We size from the physical figure.',
                ],
                [
                    'question' => 'Which louvre do you fit most often?',
                    'answer' => 'The IKL33, at 34mm blade centres. It has the lowest physical free area of the four at 43.5%, against 50%, 50% and 57%, so where a schedule needs more we specify up from it.',
                ],
                [
                    'question' => 'Are louvres fitted with the rest of the glazing?',
                    'answer' => 'Yes. We supply and fit the range as part of the aluminium package, so the louvre is drawn, coloured and fixed alongside the windows and doors either side of it rather than ordered separately and made to fit afterwards.',
                ],
                [
                    'question' => 'Where do louvres usually go?',
                    'answer' => 'Plant rooms, substations, bin stores, risers and ducts, car parks, back-of-house areas and screened facade runs. Colour and frame details are coordinated with the surrounding glazing where the package allows.',
                ],
            ],
        ],
        /* COMMERCIAL AUTOMATION carried two of the three wrong-product images the
           audit found: `Residential_Door_08.jpg`, a cottage-style slab already
           pulled from the uPVC doors pool for reading as composite, and
           `aluminium-doors-northampton-2.jpg`, the dusk CGI render removed from
           the doors hub tile on 2026-07-29. Both are gone.

           WE OWN NO PHOTOGRAPH OF AN AUTOMATIC ENTRANCE WE HAVE FITTED. That is
           the honest position, it is on the owner's photography list, and the
           entrance section carries a marked placeholder rather than a borrowed
           picture of a door that opens by hand. */
        'commercial-automation' => [
            'eyebrow' => 'Commercial automation',
            'title' => 'Automatic doors and entrance automation',
            'subtitle' => 'Glazed entrance packages built around automatic operation, access control and the ironmongery that has to work with both.',
            'intro_heading' => 'The entrance is one assembly, however many trades touch it.',
            /* OURS, and it can say so. Owner pointed at it 2026-08-12: the Bletchley
               depot entrance is an automatic doorset we installed — anthracite
               leaves, operator housing across the head, "Automatic Door" signage,
               side screens and a level threshold. It replaces an unattributed
               archive shot as the hero, because a photograph we can claim beats
               one we cannot. */
            'hero_image' => $cs_base . 'cs-bletchley-rail-depot-entrance.webp',
            'hero_alt' => 'An anthracite automatic doorset we installed, with the operator housing across the head, side screens and a level threshold',
            'intro_image' => $cs_base . 'cs-all-hallows-bedford-steel-doorset.webp',
            'intro_alt' => 'A steel entrance doorset with a glazed screen above and beside it',
            'summary' => [
                'An automated entrance is where four trades meet: the glazed screen, the doorset, the operator and the access control. Each is straightforward on its own, and the work is in the joins between them — structure for the operator to fix to, a threshold that meets Part M, a sensor zone that suits the swing path, and a cable route left ready for the maglock.',
                'We supply and install the glazed entrance package and coordinate the automation and access-control specialists into it, so the screen, the door, the operator and the reader are set out together before anything is made.',
            ],
            'stats' => [
                ['value' => 'Entrances', 'label' => 'retail, office and public buildings'],
                ['value' => 'Coordinated', 'label' => 'operator and access control'],
                ['value' => 'Part M', 'label' => 'thresholds and approach checked'],
            ],
            /* Owner-confirmed 2026-08-12. The maintenance row states the boundary
               POSITIVELY, per the 2026-08-02 ruling against writing what is not
               covered: it names who holds servicing rather than announcing that
               we decline it. Same shape as the AOV scope row. */
            'specification' => [
                ['label' => 'Operators', 'value' => 'Swing and sliding operators supplied and installed to the standard your specification sets.'],
                ['label' => 'Standards', 'value' => 'Installed to the standards the project requires.'],
                ['label' => 'Maintenance', 'value' => 'Servicing after handover sits with your facilities or maintenance contractor.'],
                ['label' => 'Access control', 'value' => 'Frames, locks and cable routes coordinated around your access-control specialist\'s equipment.'],
                ['label' => 'Glass', 'value' => 'Toughened or laminated throughout, with manifestation to suit the screen.'],
                ['label' => 'Thresholds', 'value' => 'Level and Part M compliant approaches where the building allows it.'],
            ],
            'capabilities_heading' => 'What we take on within an entrance package.',
            'capabilities' => [
                ['title' => 'Entrance screens', 'copy' => 'The glazed screen the entrance sits in: side screens, toplights and the framing that carries the operator.'],
                ['title' => 'Doorsets', 'copy' => 'Commercial doorsets specified for the traffic they take, with the closers, locks and hinges to match.'],
                ['title' => 'Operator coordination', 'copy' => 'Set-out agreed with the automation specialist so the operator has structure to fix to and a swing path that clears.'],
                ['title' => 'Frames ready for the access control', 'copy' => 'Cable routes, maglock positions and reader locations designed into the frame rather than drilled into it later.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Set-out',
                    'title' => 'Footfall and the escape route decide the door before the finish does.',
                    'copy' => 'Clear opening width, traffic direction, the escape route through the entrance and the space the operator needs above the head are the four things that fix the design. Settle those four and everything after them is finish.',
                    /* Was the hero repeated. `HANDOVER.md` is explicit that product
                       body imagery must not repeat the hero, and the residential
                       template keeps a whole image queue to prevent exactly this.
                       Caught 2026-08-12. The archive shot belongs here anyway: it
                       shows the operator working with somebody walking through,
                       which is what "traffic flow" means. */
                    'image' => $asset_base . 'electric-door.jpg',
                    'alt' => 'An automatic sliding entrance with the operator housing above the door head and a figure walking through',
                    'points' => ['Clear opening width and traffic flow', 'Escape route and emergency release', 'Head space for the operator'],
                ],
                [
                    'eyebrow' => 'The entrance in use',
                    'title' => 'A powered door still has to work when the power is off.',
                    'copy' => 'Every automated entrance needs a manual answer: how it opens in a power cut, how it releases on the fire alarm, and how it locks at night. Those are specification decisions, not commissioning ones, and they belong in the drawing rather than in a conversation on handover day.',
                    /* A manual entrance on purpose: this section is about what a
                       powered door does when the power is off, and a doorset that
                       opens by hand is the honest illustration of the fallback.
                       Ours, from Heal's.

                       NOTE ON THE ARCHIVE SHOT ABOVE. It is unattributed and stays
                       that way — the owner said it could stay, not that it is ours,
                       and archive imagery is never claimed as an install. The
                       Bletchley hero is ours and is captioned accordingly. That
                       split is the rule this site holds everywhere. */
                    'image' => $cs_base . 'cs-heals-tottenham-court-door.webp',
                    'alt' => 'A glazed entrance doorset in a city centre elevation, opened by hand',
                    'points' => ['Power-off and fail-safe behaviour', 'Fire alarm release', 'Night locking and out-of-hours use'],
                ],
            ],
            'use_cases_heading' => 'Where automated entrances usually go.',
            'use_cases' => ['Retail entrances', 'Office receptions', 'Healthcare buildings', 'Education estates', 'Public access routes', 'High-traffic doors'],
            'faqs' => [
                [
                    'question' => 'Do you supply the door operators as well as the glazing?',
                    'answer' => 'Swing and sliding operators are supplied and installed to the standard your specification sets, as part of the glazed entrance package rather than as a separate order.',
                ],
                [
                    'question' => 'How does the access control get coordinated?',
                    'answer' => 'Cable routes, maglock positions and reader locations are designed into the frame rather than drilled into it later. The screen, the door, the operator and the reader are set out together with your specialists before anything is made.',
                ],
                [
                    'question' => 'Who services the entrance after handover?',
                    'answer' => 'Servicing after handover sits with your facilities or maintenance contractor.',
                ],
                [
                    'question' => 'Can you achieve a level threshold?',
                    'answer' => 'Level and Part M compliant approaches where the building allows it. Glass is toughened or laminated throughout, with manifestation to suit the screen.',
                ],
            ],
        ],
        /*
         * Sector pages, added 2026-07-28. Each is written around the constraint that
         * actually differs by sector, not a templated capability list with the noun
         * swapped: `AUDIT.md` flags doorway-page risk on the county set and the same
         * trap applies here. Photography is real Fenster work pulled from the owner's
         * image bank. Industrial and logistics was asked for but is deliberately not
         * built: there is no completed job, no photograph and nothing to write from.
         */
        'school-and-education-glazing' => [
            'eyebrow' => 'Education',
            'title' => 'School and education glazing',
            'subtitle' => 'Window, door and curtain walling replacement for schools, academies and colleges, planned around the school year rather than against it.',
            'intro_heading' => 'Most school glazing is decided by the calendar before it is decided by the specification.',
            'hero_image' => $sector_base . 'sector-education-glazed-run-1400w.webp',
            'hero_alt' => 'New glazed window run being installed in a school building',
            'intro_image' => $sector_base . 'sector-education-window-fitted-1000w.webp',
            'intro_alt' => 'Aluminium window fitted into a school elevation',
            'summary' => [
                'A school is only empty for a few weeks a year, and those weeks are when almost every other trade wants to be on site too. The specification usually turns out to be the easy part. What decides the job is how much of it can be finished before the pupils come back.',
                'We have worked on school sites including Shaftesbury School, Witchford Village College, Merchant Taylor and Leagrave SEN. Send us the elevations and the term dates together, because we cannot price the second one out of the first.',
            ],
            'stats' => [
                ['value' => 'Term time', 'label' => 'or holidays, planned either way'],
                ['value' => 'Occupied', 'label' => 'buildings, phased by block'],
                ['value' => 'DBS', 'label' => 'and site induction as required'],
            ],
            'specification' => [
                ['label' => 'Restrictors', 'value' => 'Fitted to the limit your own risk assessment sets, consistent across the site.'],
                ['label' => 'Safety glass', 'value' => 'Toughened or laminated where the opening needs it, specified per elevation.'],
                ['label' => 'Safeguarding', 'value' => 'DBS-checked operatives and site induction where the school requires it.'],
                ['label' => 'Fire rating', 'value' => 'Fire-rated glazing supplied to the rating the specification calls for.'],
                ['label' => 'Programme', 'value' => 'Phased by block or by holiday, sequenced against your term dates.'],
            ],
            'capabilities_heading' => 'What we take on across a school estate.',
            'capabilities' => [
                ['title' => 'Classroom windows', 'copy' => 'Replacement windows in teaching spaces, with restrictors and safety glass where the opening needs them.'],
                ['title' => 'Entrances and screens', 'copy' => 'Glazed entrance screens and doors, coordinated with access control where the school already has it.'],
                ['title' => 'Curtain walling', 'copy' => 'Larger glazed elevations on halls, atria and newer teaching blocks.'],
                ['title' => 'Phased programmes', 'copy' => 'Work split by block or by holiday so the school keeps running around it.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Working around a live school',
                    'title' => 'The awkward part is not the glazing, it is the safeguarding.',
                    'copy' => 'On an occupied school site the route from the compound to the elevation matters as much as the elevation. Pupil separation, signing in, supervised access and where the skip goes all get agreed before we start rather than argued about on day one.',
                    'image' => $sector_base . 'sector-education-window-fitted-1000w.webp',
                    'alt' => 'Window installation in progress on a school building',
                    'points' => ['Segregated working areas', 'Site induction and sign-in', 'Agreed access and storage'],
                ],
                [
                    'eyebrow' => 'What to send us',
                    'title' => 'Term dates are part of the specification.',
                    'copy' => 'Elevations, a window schedule and the dates the school is empty are enough to start. If the work has to happen in term time we will say so, and we will tell you what realistically fits into a holiday rather than promising the lot and running over into September.',
                    'image' => $sector_base . 'sector-education-glazed-run-1400w.webp',
                    'alt' => 'Glazed run installed in a school block',
                    'points' => ['Elevations and schedule', 'Term and holiday dates', 'Access constraints on site'],
                ],
            ],
            'use_cases_heading' => 'Education settings we work in.',
            'use_cases' => ['Primary schools', 'Secondary schools', 'Academies', 'Sixth form and colleges', 'SEN settings', 'Teaching blocks'],
            'faqs' => [
                [
                    'question' => 'Can the work be done in the school holidays?',
                    'answer' => 'Programmes are phased by block or by holiday and sequenced against your term dates. Send us the elevations and the term dates together, because we cannot price the second one out of the first.',
                ],
                [
                    'question' => 'Are your operatives DBS checked?',
                    'answer' => 'Yes. DBS-checked operatives, and site induction where the school requires it.',
                ],
                [
                    'question' => 'What restrictors do you fit to classroom windows?',
                    'answer' => 'Restrictors fitted to the limit your own risk assessment sets, kept consistent across the site, with toughened or laminated safety glass specified per elevation where the opening needs it.',
                ],
                [
                    'question' => 'Have you worked on school sites before?',
                    'answer' => 'Yes, including Shaftesbury School, Witchford Village College, Merchant Taylor and Leagrave SEN.',
                ],
            ],
        ],
        'student-accommodation-glazing' => [
            'eyebrow' => 'Student accommodation',
            'title' => 'Student accommodation glazing',
            'subtitle' => 'Windows and facade glazing for purpose built student accommodation, worked to a handover date that cannot move.',
            'intro_heading' => 'The students arrive in September whether the building is ready or not.',
            'hero_image' => '/wp-content/themes/fenster/assets/images/case-studies/cs-headrow-court-oriels.webp',
            'hero_alt' => 'Projecting bay windows on a city centre student accommodation building',
            'intro_image' => '/wp-content/themes/fenster/assets/images/case-studies/cs-headrow-court-gables.webp',
            'intro_alt' => 'Upper floors of a converted student accommodation building',
            'summary' => [
                'Every other sector can slip a fortnight. Student accommodation cannot. The academic year fixes the handover date before the drawings are finished, and a scheme that misses it is not late, it is empty for a year.',
                'Most of this work is conversion: a commercial building given a new facade and a new use, or an operator upgrading a block in the weeks between academic years. Either way the glazing is one detail repeated across every room, on a building whose openings were never meant to match.',
                'We supply and install the windows, the bays and the facade glazing that goes with them, working to the main contractor\'s programme. Our most recent scheme of this type was <a href="' . esc_url(home_url('/commercial-projects/headrow-court-student-accommodation-leeds/')) . '">Headrow Court in Leeds</a>.',
            ],
            'stats' => [
                ['value' => 'September', 'label' => 'the date everything works back from'],
                ['value' => 'Repeatable', 'label' => 'one detail, every room'],
                ['value' => 'Conversions', 'label' => 'commercial buildings into homes'],
            ],
            'specification' => [
                ['label' => 'Restricted opening', 'value' => 'Restrictors fitted at height as standard, to the limit your risk assessment sets.'],
                ['label' => 'Acoustic glass', 'value' => 'Specified where the elevation faces a road, a bar or a delivery yard.'],
                ['label' => 'Handover', 'value' => 'Sequenced so the building is watertight before the internal trades need it.'],
                ['label' => 'Acoustic performance', 'value' => 'Acoustic glass specified to the level the project requires.'],
                ['label' => 'Fire rating', 'value' => 'Fire-rated glazing supplied to the rating the specification calls for.'],
            ],
            'capabilities_heading' => 'What we take on across a student scheme.',
            'capabilities' => [
                ['title' => 'Studio windows', 'copy' => 'One window per room, repeated hundreds of times, so the detail that works has to work everywhere.'],
                ['title' => 'Facade replacement', 'copy' => 'New window lines across buildings that were never designed to match each other.'],
                ['title' => 'Bays and feature glazing', 'copy' => 'Projecting bays and street-facing glazing, where the building gets its identity.'],
                ['title' => 'Amenity spaces', 'copy' => 'Reception, study and dining glazing, which is what the operator photographs.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'The immovable date',
                    'title' => 'The programme is set by the academic year, not by the trades.',
                    'copy' => 'On a conversion the glazing usually sits on the critical path, because nothing inside can be finished until the building is watertight. We would rather agree a realistic sequence early and hold it than promise the whole facade and hand back late in the one sector where late has no recovery.',
                    'image' => '/wp-content/themes/fenster/assets/images/case-studies/cs-headrow-court-elevation.webp',
                    'alt' => 'Completed student accommodation elevation in a city centre',
                    'points' => ['Sequenced against handover', 'Watertight before internal trades', 'Lifts and access booked ahead'],
                ],
                [
                    'eyebrow' => 'Lived in, not worked in',
                    'title' => 'An office window and a bedroom window are not the same brief.',
                    'copy' => 'A converted office is suddenly occupied at night, at weekends and through winter, by people who sleep next to the glass. That changes what the window has to do: safe opening at height, street noise kept down, and heat held in a building that is now warm around the clock rather than nine to five.',
                    'image' => '/wp-content/themes/fenster/assets/images/case-studies/cs-headrow-court-bay-detail.webp',
                    'alt' => 'Close view of a projecting bay window on a student accommodation building',
                    'points' => ['Restricted opening at height', 'City centre noise', 'Heat held around the clock'],
                ],
            ],
            'use_cases_heading' => 'Schemes this work suits.',
            'use_cases' => ['Purpose built student accommodation', 'Office to PBSA conversions', 'City centre schemes', 'Studio blocks', 'Amenity spaces', 'Operator refurbishments'],
            'faqs' => [
                [
                    'question' => 'Can you work to a fixed handover date?',
                    'answer' => 'Yes. The academic year fixes the date before the drawings are finished, so the glazing is sequenced so the building is watertight before the internal trades need it, working to the main contractor\'s programme.',
                ],
                [
                    'question' => 'Do you fit restrictors at height?',
                    'answer' => 'Restrictors are fitted at height as standard, to the limit your risk assessment sets.',
                ],
                [
                    'question' => 'What do you specify on a city centre elevation?',
                    'answer' => 'Acoustic glass to the level the project requires, specified where the elevation faces a road, a bar or a delivery yard, with fire-rated glazing supplied to the rating the specification calls for.',
                ],
                [
                    'question' => 'Have you delivered a scheme like this?',
                    'answer' => 'Yes. Our most recent scheme of this type was Headrow Court in Leeds.',
                ],
            ],
        ],
        'hotel-and-hospitality-glazing' => [
            'eyebrow' => 'Hospitality',
            'title' => 'Hotel and hospitality glazing',
            'subtitle' => 'Windows and doors for hotels, pubs and restaurants, phased so the rooms and the covers you lose are the ones you chose to lose.',
            'intro_heading' => 'Every room we are working in is a room you are not selling.',
            'hero_image' => '/wp-content/themes/fenster/assets/images/case-studies/cs-barn-hotel-exterior-1400w.webp',
            'hero_alt' => 'The Barn Hotel, timber-clad elevation with black aluminium windows',
            'intro_image' => $sector_base . 'sector-hospitality-holiday-inn-1400w.webp',
            'intro_alt' => 'Hotel elevation surveyed before window replacement',
            'summary' => [
                'Hospitality glazing is priced in rooms and covers, not just in frames. A floor closed for three weeks is three weeks of lost bookings, so the programme is worth as much argument as the specification.',
                'We have done the work: The Barn Hotel in Coventry, the Holiday Inn at Newport Pagnell and The Green Man at Eversholt. Tell us what you can afford to close and when, and we will build the phasing around that.',
            ],
            'stats' => [
                ['value' => 'Phased', 'label' => 'by floor, wing or room'],
                ['value' => 'Trading', 'label' => 'buildings, guests on site'],
                ['value' => 'Acoustic', 'label' => 'glass where the road is the problem'],
            ],
            'specification' => [
                ['label' => 'Phasing', 'value' => 'By room, floor or wing, with agreed handback at the end of each working day.'],
                ['label' => 'Acoustic glass', 'value' => 'Specified where the elevation faces a road, a car park or a delivery yard.'],
                ['label' => 'Period openings', 'value' => 'Surveyed opening by opening on older buildings rather than taken off a drawing.'],
                ['label' => 'Acoustic performance', 'value' => 'Acoustic glass specified to the level the project requires.'],
                /* Owner-confirmed 2026-08-12: we do work out of hours, and "dont
                   mention pricing". So the row states the capability and stops. */
                ['label' => 'Out of hours', 'value' => 'Early starts, evenings and weekends where the building needs it.'],
            ],
            'capabilities_heading' => 'What we take on across a hospitality building.',
            'capabilities' => [
                ['title' => 'Bedroom windows', 'copy' => 'Replacement windows room by room, with the room handed back clean and usable the same day where the programme allows.'],
                ['title' => 'Bar and restaurant glazing', 'copy' => 'Frontages, bay windows and garden doors on pubs and restaurants, including period buildings.'],
                ['title' => 'Entrances', 'copy' => 'Glazed entrance screens and doors on the arrival elevation, where the first impression is.'],
                ['title' => 'Acoustic and thermal', 'copy' => 'Glass specified for road noise or for guests who control their own heating.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Phasing',
                    'title' => 'We would rather take longer and cost you fewer rooms.',
                    'copy' => 'The fastest programme is almost never the cheapest one for a hotel, because the cost that matters is the rooms out of service. We will price the quick version and the phased version and let you decide which is actually cheaper for your business.',
                    'image' => $sector_base . 'sector-hospitality-holiday-inn-1400w.webp',
                    'alt' => 'Hotel elevation with windows due for replacement',
                    'points' => ['Room, floor or wing at a time', 'Agreed handback each day', 'Quiet hours respected'],
                ],
                [
                    'eyebrow' => 'Period buildings',
                    'title' => 'A pub built in 1835 does not have square openings.',
                    'copy' => 'Older hospitality buildings need surveying opening by opening rather than off a drawing, and the answer is often a sympathetic replacement rather than a modern one. The Green Man kept its bay and its proportions; that was the point of the job.',
                    'image' => '/wp-content/themes/fenster/assets/images/imported/3-1-3.png',
                    'alt' => 'The Green Man, Eversholt, after its window replacement',
                    'points' => ['Opening by opening survey', 'Proportions and bars kept', 'Listed and conservation advice'],
                ],
            ],
            'use_cases_heading' => 'Hospitality buildings we work in.',
            'use_cases' => ['Hotels', 'Pubs', 'Restaurants', 'Period inns', 'Function venues', 'Guest houses'],
            'faqs' => [
                [
                    'question' => 'How is the work phased around bookings?',
                    'answer' => 'By room, floor or wing, with agreed handback at the end of each working day. Tell us what you can afford to close and when, and we will build the phasing around that.',
                ],
                [
                    'question' => 'Can you work outside trading hours?',
                    'answer' => 'Early starts, evenings and weekends where the building needs it.',
                ],
                [
                    'question' => 'How do you handle a period building?',
                    'answer' => 'Period openings are surveyed opening by opening rather than taken off a drawing.',
                ],
                [
                    'question' => 'Which hospitality buildings have you worked on?',
                    'answer' => 'The Barn Hotel in Coventry, the Holiday Inn at Newport Pagnell and The Green Man at Eversholt.',
                ],
            ],
        ],
        'care-home-glazing' => [
            'eyebrow' => 'Care',
            'title' => 'Care home glazing',
            'subtitle' => 'Window and door replacement in care homes and supported living, carried out around residents who are at home all day.',
            'intro_heading' => 'Nobody moves out while we work.',
            'hero_image' => '/wp-content/themes/fenster/assets/images/imported/668a13f5-3500-420d-8e15-47834268084b.jpg',
            'hero_alt' => 'Sunrise Care Home after its window replacement',
            'intro_image' => $sector_base . 'sector-offices-courtyard-1000w.webp',
            'intro_alt' => 'Traditional brick elevation with replacement windows',
            'summary' => [
                'A care home is the hardest kind of occupied building to work in, because the occupants are there all day, some of them are unwell, and a room without a window in it is not a room anybody can sit in. The work has to be planned in single rooms and finished the same day.',
                'We replaced the windows at Sunrise Care Home. The specification questions that came up were the ones you would expect: restrictors, safe opening, and keeping rooms warm while the frame is out.',
            ],
            'stats' => [
                ['value' => 'Room by room', 'label' => 'opened and closed the same day'],
                ['value' => 'Restrictors', 'label' => 'where the opening needs them'],
                ['value' => 'Occupied', 'label' => 'throughout, residents in place'],
            ],
            'specification' => [
                ['label' => 'Restrictors', 'value' => 'Fitted to the limit your own risk assessment sets, consistent across the home.'],
                ['label' => 'Working pattern', 'value' => 'One room opened, glazed, sealed and cleaned within the same day.'],
                ['label' => 'Safety glass', 'value' => 'Toughened or laminated where the opening needs it, specified per room.'],
                ['label' => 'Thermal', 'value' => 'Specified to the performance the project requires; the system is chosen to meet it.'],
                ['label' => 'Vetting', 'value' => 'DBS-checked operatives, and site induction where the home requires it.'],
            ],
            'capabilities_heading' => 'What we take on inside a care home.',
            'capabilities' => [
                ['title' => 'Bedroom windows', 'copy' => 'One room opened at a time, glazed and made good before we leave it.'],
                ['title' => 'Communal areas', 'copy' => 'Lounges, dining rooms and conservatory glazing where the residents actually spend the day.'],
                ['title' => 'Safe opening', 'copy' => 'Restrictors and controlled opening where a resident could otherwise open a window fully.'],
                ['title' => 'Doors and entrances', 'copy' => 'Entrance doors and screens, coordinated with the access control the home already uses.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Working around residents',
                    'title' => 'One room open at a time, closed before we go home.',
                    'copy' => 'We do not strip a corridor of windows and come back tomorrow. A room is opened, glazed, sealed and cleaned within the day so the resident sleeps in it that night. It is slower and it is the only way that works.',
                    'image' => '/wp-content/themes/fenster/assets/images/imported/668a13f5-3500-420d-8e15-47834268084b.jpg',
                    'alt' => 'Care home elevation with replacement windows',
                    'points' => ['Single room working', 'Same day handback', 'Dust and noise kept down'],
                ],
                [
                    'eyebrow' => 'Safe opening',
                    'title' => 'The restrictor question comes up on every care job.',
                    'copy' => 'How far a window should open in a care setting is a decision for you and your own risk assessment, not for us. Tell us what the assessment says and we will fit hardware that matches it, rather than choosing a limit on your behalf.',
                    'image' => $sector_base . 'sector-offices-courtyard-1000w.webp',
                    'alt' => 'Window detail on a residential care building',
                    'points' => ['Restrictors to your assessment', 'Consistent across the home', 'Serviceable hardware'],
                ],
            ],
            'use_cases_heading' => 'Care settings we work in.',
            'use_cases' => ['Care homes', 'Nursing homes', 'Supported living', 'Sheltered housing', 'Extra care schemes', 'Residential settings'],
            'faqs' => [
                [
                    'question' => 'How do you work around residents?',
                    'answer' => 'One room is opened, glazed, sealed and cleaned within the same day, and made good before we leave it, so a resident is not left with a room they cannot sit in.',
                ],
                [
                    'question' => 'Are your operatives DBS checked?',
                    'answer' => 'Yes. DBS-checked operatives, and site induction where the home requires it.',
                ],
                [
                    'question' => 'What restrictors do you fit?',
                    'answer' => 'Restrictors fitted to the limit your own risk assessment sets, kept consistent across the home, with controlled opening where a resident could otherwise open a window fully.',
                ],
                [
                    'question' => 'Have you worked in a care home before?',
                    'answer' => 'Yes. We replaced the windows at Sunrise Care Home, where the specification questions were restrictors, safe opening, and keeping rooms warm while the frame is out.',
                ],
            ],
        ],
        'office-and-retail-glazing' => [
            'eyebrow' => 'Offices and retail',
            'title' => 'Office and retail glazing',
            'subtitle' => 'Shopfronts, entrance screens, windows and curtain walling for offices, shops and workplaces, worked around your trading and working hours.',
            'intro_heading' => 'The building has to keep earning while we are on it.',
            'hero_image' => $sector_base . 'sector-offices-water-end-barn-1400w.webp',
            'hero_alt' => 'Converted barn office complex with replacement windows',
            /* IMAGERY REBALANCED 2026-08-30. This route ran on ONE photograph:
               the hero and the second detail section were the same file, the intro
               and the first detail section were the same file, and all four were
               near-identical drone frames of the same converted barn. A page
               selling offices AND retail showed one rural office park four times.

               Heal's is the obvious fix and it was sitting unused: the study
               already claims this route in its `products` array, so it is in the
               proof band at the foot of the page while none of its photographs
               were on it. It is also the half the barn cannot carry, a city-centre
               building with offices going in above a shop.

               THE HEAL'S FRAMES ARE 1024px AND ARE NOT UPSCALED, which is why they
               are in the intro and detail slots and not the hero: the hero renders
               full bleed at 1440 and wider, and the 1400px barn is the only office
               photograph we own that is big enough for it. A wide commercial
               elevation of our own is commercial gap #1 in PHOTO-CHECKLIST.md and
               it would replace that hero on the day it arrives. */
            /* NOT THE ELEVATION FRAME, AND THE REASON IS THE PROOF BAND. A
               case-study card renders `images[0]`, which for Heal's is
               cs-heals-tottenham-court-elevation, and Heal's is the one study
               claiming this route. Putting that frame in the intro printed the
               same photograph twice on one page, which is the fault this whole
               pass exists to remove. Caught by reading the rendered page rather
               than the data. Check the proof band before taking a frame from a
               study that claims the route. */
            'intro_image' => $cs_base . 'cs-heals-tottenham-court-run.webp',
            'intro_alt' => 'Looking along the glazed run at the Heal\'s building, the new frames following the existing structural bays rather than cutting across them',
            'summary' => [
                'Offices and shops have the same problem from opposite ends of the day: an office needs its desks usable from nine, a shop needs its frontage clear from opening. Both usually mean working early, late or at a weekend, and that belongs in the price rather than as a surprise later.',
                'The work ranges from a converted barn office at Water End Barn to commercial buildings such as Franklin House and Orient House, and from a full shopfront replacement down to a single entrance screen. Tell us the hours the building has to work and we will price around them.',
                /* THIS ROUTE OWNS "SHOPFRONT" AND THE LINK BELOW IS WHAT KEEPS IT
                   THAT WAY. Both this page and /commercial-replacement-glazing/
                   carried shopfront language and a near-identical toughened and
                   laminated claim, so the two were competing for the same query.
                   The split is by intent: a frontage being replaced is this page,
                   glass failing in a frame that stays is the other one. Each links
                   the other on that specific distinction and nowhere else. */
                'A shopfront replacement is the frontage, the entrance doors and the glass in them, ordered as one. Where the frame is sound and only the glass has failed or been broken, that is <a href="' . esc_url(home_url('/commercial-replacement-glazing/')) . '">commercial replacement glazing</a> instead.',
            ],
            'stats' => [
                ['value' => 'Out of hours', 'label' => 'where trading demands it'],
                ['value' => 'Occupied', 'label' => 'floors kept usable'],
                ['value' => 'Shopfronts', 'label' => 'frontages, screens and entrance doors'],
            ],
            'specification' => [
                ['label' => 'Working hours', 'value' => 'Early starts, evenings and weekends where trading demands it.'],
                ['label' => 'Possession', 'value' => 'Floor by floor or unit by unit, with the space usable the next morning.'],
                ['label' => 'Glass', 'value' => 'Solar control, acoustic and safety glass specified against the elevation and the use.'],
                ['label' => 'Thermal', 'value' => 'Specified to the performance the project requires; the system is chosen to meet it.'],
                ['label' => 'Shopfronts', 'value' => 'Frontages, entrance screens and entrance doors, with toughened and laminated glass supplied to order.'],
                /* Manifestation is not a new claim: /commercial-automation/ has
                   published "toughened or laminated throughout, with manifestation
                   to suit the screen" since 2026-08-12, and this route sells the
                   same entrance screens. It is here because it is the word a
                   specifier uses and it appeared nowhere a retail buyer would look. */
                ['label' => 'Manifestation', 'value' => 'Applied to glazed screens and entrance doors to suit the screen.'],
            ],
            'capabilities_heading' => 'What we take on across an office or retail building.',
            'capabilities' => [
                ['title' => 'Office windows', 'copy' => 'Replacement windows floor by floor, with desks moved back and the floor usable the next morning.'],
                ['title' => 'Entrance screens', 'copy' => 'Glazed entrances and reception screens, with manifestation to suit the screen, coordinated with automatic doors and access control.'],
                ['title' => 'Curtain walling', 'copy' => 'Larger glazed elevations, replacement facade panels and phased facade works.'],
                ['title' => 'Shopfronts', 'copy' => 'Shopfront replacement and new frontages: the screen, the entrance doors and the glass in them, with the unit trading around the work where it can be.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Working hours',
                    'title' => 'Say when the building has to be usable and we will work to it.',
                    'copy' => 'Most office and retail jobs come down to when we can be noisy and when we cannot. Early starts, evening work and weekend possessions all cost differently, so it is worth agreeing them at quote stage rather than discovering the constraint in week two.',
                    /* An occupied building mid-job is the subject of this
                       section, so the photograph is the inside of one: the
                       lounge is still furnished and in use while the unit goes
                       in from outside. It also moved Heal's off this section,
                       which had it three times on one page. */
                    'image' => $commercial_base . 'comm-occupied-office-lift-in-1600w.jpg',
                    'alt' => 'A glazed unit lifted in from outside by vacuum lifter while the office lounge it serves stays furnished and in use, with the crane and the scaffold beyond the opening',
                    'points' => ['Out of hours where needed', 'Floor by floor possession', 'Agreed noisy hours'],
                ],
                [
                    'eyebrow' => 'Older commercial buildings',
                    'title' => 'A converted building rarely matches its own drawings.',
                    'copy' => 'Barn conversions, mills and older commercial premises tend to have openings that have moved over a century and a half. We survey them individually rather than working off the original drawing, because the drawing is usually optimistic.',
                    /* The barn stays here and only here, because this section is
                       about converted buildings and it is the right subject for it.
                       The courtyard frame rather than the hero frame, so the page
                       does not print the same photograph twice. */
                    'image' => $sector_base . 'sector-offices-courtyard-1000w.webp',
                    'alt' => 'The converted barn offices at Water End Barn, white replacement windows set into the original brick openings with a glazed entrance screen at the end of the range',
                    'points' => ['Individual opening survey', 'Sympathetic replacements', 'Conservation constraints checked'],
                ],
                /* THE PARADE SHOT CANNOT BE USED HERE, and the reason is not
                   taste. It is the curtain walling card image, and the related
                   strip on this page is POSITIONAL, not semantic:
                   commercial-product.php takes every commercial route, drops the
                   current one and slices the first three in declaration order,
                   so the curtain walling card is on all thirteen pages. Putting
                   the parade in this figure printed the same photograph twice on
                   this page, and it shipped live on 2026-08-30 before a render
                   caught it. This frame is the nearest true subject we own: a
                   glazed screen with the entrance door in it, which is exactly
                   what the copy below describes. Replace it the moment a
                   shopfront of ours is photographed on its own, and check the
                   first three commercial routes before choosing. */
                [
                    'eyebrow' => 'Shopfronts',
                    'title' => 'The frontage, the entrance doors and the glass are one order.',
                    'copy' => 'A shopfront is a screen, a door and the glass in it, and specifying those separately is how the reveal, the threshold and the door swing end up disagreeing on site. We survey the existing frontage, set the screen out from the opening rather than from the drawing, and order the doors and the glass with it. Toughened and laminated glass is supplied to order, and manifestation is applied to suit the screen.',
                    'image' => $cs_base . 'cs-heals-tottenham-court-door.webp',
                    /* Written from the frame itself, not from the filename. The
                       earlier alt on this section described a photograph nobody
                       had opened and asserted a material nobody had confirmed,
                       which took a correction on 2026-08-30. */
                    'alt' => 'A black framed glazed screen at ground level with the entrance door at one end and the fixed lights running on from it, the unit behind still being fitted out',
                    'points' => ['Frontage, doors and glass together', 'Toughened and laminated to order', 'Manifestation to suit the screen'],
                ],
            ],
            'use_cases_heading' => 'Buildings this work suits.',
            'use_cases' => ['Offices', 'Business parks', 'Converted buildings', 'Retail units', 'Shopfronts', 'Workplaces'],
            'faqs' => [
                [
                    'question' => 'Can you work outside office or trading hours?',
                    'answer' => 'Early starts, evenings and weekends where trading demands it. Tell us the hours the building has to work and we will price around them.',
                ],
                [
                    'question' => 'How much of the building comes out of use?',
                    'answer' => 'Possession is taken floor by floor or unit by unit, with the space usable the next morning. On offices that means desks moved back and the floor working again; on retail it means the unit trading around the work where it can.',
                ],
                [
                    'question' => 'What glass do you specify for an office elevation?',
                    'answer' => 'Solar control, acoustic and safety glass specified against the elevation and the use, with thermal performance specified to what the project requires and the system chosen to meet it.',
                ],
                /* FAQ answers are esc_html, so no link is possible here. The
                   route to /commercial-replacement-glazing/ is in the summary
                   above instead; do not paste an anchor into an answer. */
                [
                    'question' => 'Do you replace shopfronts as well as the glass in them?',
                    'answer' => 'Yes. A shopfront replacement is the frontage, the entrance doors and the glass in them specified as one order, with toughened and laminated glass supplied to order and manifestation applied to suit the screen. Where the frame is sound and only the glass has failed or been broken, that is commercial replacement glazing instead.',
                ],
            ],
        ],
        /*
         * INDUSTRIAL AND LOGISTICS, added 2026-08-12 on the owner's instruction —
         * the seventh sector page and the one `PROGRESS.md` had recorded as
         * "deliberately not built" since 2026-07-28, because there was no
         * completed job, no photograph and nothing to write from.
         *
         * TWO OF THOSE THREE ARE STILL TRUE, so read this before adding to it.
         * Nothing on this page claims a job, a portfolio or a named client,
         * because we have none to name in this sector. What it does instead is
         * describe the work honestly and say what we would need — which is the
         * same shape the other sector pages take, minus the proof they can offer.
         *
         * IT RENDERS NO PROOF BAND, and that is correct rather than an omission:
         * no case study claims the route, and the helper has no fallback, so the
         * page shows nothing rather than borrowing a school or a care home.
         *
         * IT HAS NO HERO IMAGE, deliberately. The hero falls back to solid steel
         * with white type, which is a clean established look on this template.
         * Putting an office or a retail parade behind an industrial heading would
         * be the wrong-product fault this whole rebuild removed. One photograph of
         * a distribution centre frontage changes that in one line.
         */
        'industrial-and-logistics-glazing' => [
            'eyebrow' => 'Industrial and logistics',
            'title' => 'Industrial and logistics glazing',
            'subtitle' => 'Office and welfare glazing, personnel doorsets and security rated openings on distribution, warehousing and manufacturing buildings.',
            'intro_heading' => 'A distribution centre does not really have an out of hours.',
            'hero_image' => '',
            'hero_alt' => '',
            'intro_image' => '',
            'intro_alt' => '',
            'summary' => [
                'Industrial buildings put nearly all their glazing in one place: the office and welfare block at the front. That block is hung off a steel frame and wrapped in cladding rather than built into masonry, so the glazing meets a cladding rail and a liner tray instead of a brick reveal. The rest of the elevation is personnel doors, fire escapes and the occasional rooflight, spread across a footprint measured in acres.',
                'The awkward part is usually the shift pattern. A warehouse running around the clock has no quiet week to hand anybody, so the work is sequenced around loading bays, yard traffic and whichever elevation is out of use that day. Send us the elevations and the shift pattern together, because we cannot plan the second one out of the first.',
            ],
            'stats' => [
                ['value' => 'Cladding', 'label' => 'rails and liner trays, not brick reveals'],
                ['value' => 'Shift work', 'label' => 'sequenced around a building that runs on'],
                ['value' => 'Up to SR3', 'label' => 'security rated doorsets where specified'],
            ],
            'specification' => [
                ['label' => 'Aluminium systems', 'value' => 'Technal, Smart and Senior among others, specified to the job.'],
                ['label' => 'uPVC systems', 'value' => 'Liniar.'],
                ['label' => 'Security', 'value' => 'Doorsets security rated up to SR3. PAS 24 and Secured by Design available where specified.'],
                ['label' => 'Fire rating', 'value' => 'Fire-rated glazing supplied to the rating the specification calls for.'],
                ['label' => 'Working hours', 'value' => 'Early starts, nights and weekends where the operation cannot pause.'],
                ['label' => 'Coverage', 'value' => 'Nationwide across England and Wales.'],
            ],
            'capabilities_heading' => 'What we take on across an industrial site.',
            'capabilities' => [
                ['title' => 'Office and welfare glazing', 'copy' => 'The windows, screens and entrance to the block at the front, which is where almost all of the glazing on these buildings lives.'],
                ['title' => 'Personnel and escape doorsets', 'copy' => 'Doors set into cladded elevations, including the escape doors that have to work on a route nobody uses daily.'],
                ['title' => 'Curtain walling to the frontage', 'copy' => 'Glazed elevations on the office block, where the building does its presenting.'],
                ['title' => 'Security rated openings', 'copy' => 'Ground floor and yard-side openings rated up to SR3 where the specification asks for it.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'The front of the shed',
                    'title' => 'The office block is a building within a building.',
                    'copy' => 'It has the windows, the entrance, the meeting rooms and the only elevation anybody photographs, and it is built to a completely different specification from the eighty metres of cladding beside it. So it gets surveyed and specified as its own glazing package rather than as a corner of the shed.',
                    /* PLACEHOLDER RETIRED 2026-08-12, owner-supplied. Our own job:
                       two Fenster vans in the yard, a run of new grey aluminium
                       windows across the first floor and a glazed ground-floor
                       screen, with the work still in progress. It is exactly what
                       the placeholder asked for.

                       THREE THINGS WERE TREATED BEFORE PUBLISHING. A fitter's face
                       visible through the glass is blurred; a third-party security
                       contractor's sign and phone number on the brick pier is
                       blurred, the same call already made on the louvre blade
                       close-up; and a partly legible plate on a car reflected in
                       the screen is blurred. GPS stripped — the original carried
                       coordinates, as every photograph taken on site does. Our own
                       van plate is left alone: it is our vehicle and our phone
                       number is on the side of it. */
                    'image' => $commercial_base . 'comm-industrial-unit-install-1600w.jpg',
                    'alt' => 'A two-storey business unit with a run of new grey aluminium windows and a glazed ground-floor screen, with two Fenster vans in the yard during the fit',
                    'points' => ['Glazing into cladding, not masonry', 'Entrance and reception screens', 'Meeting and welfare spaces'],
                ],
                [
                    'eyebrow' => 'Working round the operation',
                    'title' => 'The yard decides the programme more than the elevation does.',
                    'copy' => 'Loading bays run to a timetable, yard traffic does not stop for a scaffold, and the elevation you most want access to is usually the one with trailers against it. We agree access windows, exclusion zones and which elevations come out of service when, before anything is booked.',
                    /* Owner-identified as industrial, 2026-08-12: the silver louvre
                       screen with the yellow pipe. It shows the back-of-house
                       reality this section is about — a service yard with plant, a
                       refrigeration unit and a boiler alarm, which is where the
                       glazing on an industrial site actually sits. Also used on
                       `/louvre-vents/`; cross-page reuse is normal here, and it is
                       not the hero on either. */
                    'image' => '/wp-content/themes/fenster/assets/images/products/louvre/louvre-screen-boiler-1400w.webp',
                    'alt' => 'A large silver louvre screen in a service yard, beside a boiler alarm and a refrigeration unit',
                    'points' => ['Access windows agreed in advance', 'Yard traffic and exclusion zones', 'Elevations released in sequence'],
                ],
            ],
            'use_cases_heading' => 'Sites this work goes into.',
            'use_cases' => ['Distribution centres', 'Warehousing', 'Manufacturing', 'Logistics parks', 'Trade counters', 'Industrial estates'],
            'faqs' => [
                [
                    'question' => 'Which part of an industrial building do you glaze?',
                    'answer' => 'The office and welfare block at the front, which is where almost all the glazing on these buildings lives: the windows and screens, the entrance, the personnel and escape doorsets, and curtain walling to the frontage.',
                ],
                [
                    'question' => 'Can you supply security rated doorsets?',
                    'answer' => 'Doorsets are security rated up to SR3, with PAS 24 and Secured by Design available where specified. Ground floor and yard-side openings are rated to what the specification asks for.',
                ],
                [
                    'question' => 'Can you work around a 24 hour operation?',
                    'answer' => 'Early starts, nights and weekends where the operation cannot pause, sequenced around loading bays, yard traffic and whichever elevation is out of use that day.',
                ],
                [
                    'question' => 'Where do you work?',
                    'answer' => 'Nationwide across England and Wales.',
                ],
            ],
        ],
        /*
         * AOV. The owner confirmed on 2026-07-28 that we supply and install these.
         * Deliberately not claimed here, because they were not confirmed: any named
         * standard (BS 7346, EN 12101), servicing or maintenance intervals, third
         * party certification, and design of the detection or control strategy. The
         * supplier reference the owner supplied named no standards either, so
         * nothing here is carried over from it. Add those claims only once the
         * owner confirms them; this is life safety and a wrong claim is worse than
         * a missing one.
         */
        /* COMMERCIAL REPLACEMENT GLAZING, split off the hub on 2026-08-12.
           Until then the hub's fifth service card sent commercial buyers to
           /double-glazing-replacement/, a homeowner page headed "Misted and
           Blown Double Glazing" which sent them straight back. This route is
           the page that card always needed.

           EVERY FACT HERE IS OWNER-CONFIRMED OR VISIBLE IN OUR OWN
           PHOTOGRAPHS, and there is deliberately nothing else. No glass
           specification, no standards, no response time, no U-value: none of
           that has been confirmed for commercial work and the louvre standard
           is real figures or none. Owner-confirmed 2026-08-12: no maximum unit
           size, one to two weeks from order depending on specification.

           MAKE-SAFE IS DELIBERATELY NOT ON THE PAGE. Owner: we occasionally do
           it, but do not push it, because there is no out-of-hours cover. A
           page that advertises make-safe invites the 6pm phone call we cannot
           answer, so it is left for the conversation. Do not add it as a
           feature without the out-of-hours position changing first.

           ALL THREE PHOTOGRAPHS ARE OURS, from one job, and they are the only
           images on any commercial route that show us working. Each sits
           against the copy it proves, which is the louvre rule. */
        'commercial-replacement-glazing' => [
            'eyebrow' => 'Commercial replacement glazing',
            'title' => 'Commercial replacement glazing',
            'subtitle' => 'Failed, blown and broken units replaced in offices, schools, shopfronts and public buildings, with the building still in use.',
            'intro_heading' => 'One pane has gone and the building still has to open.',
            'hero_image' => '/wp-content/themes/fenster/assets/images/commercial/comm-failed-unit-office-1200w.jpg',
            'hero_alt' => 'A crazed glass unit in an office elevation, with two of our fitters working from inside the room',
            'intro_image' => '/wp-content/themes/fenster/assets/images/commercial/comm-occupied-office-lift-in-1600w.jpg',
            'intro_alt' => 'A replacement unit lifted into an office elevation on a vacuum lifter, seen from the breakout space inside',
            'summary' => [
                'A commercial unit fails the same way a domestic one does and matters more: a crazed pane in an office elevation, a blown unit in a stairwell, a shopfront that has been put through. The difference is that the building has to keep trading around it, the glass is usually too big and too high to carry in by hand, and the opening it came out of was never designed to be reglazed from a ladder.',
                'We measure the failed unit, order it to the frame it is going into, and fit it with the floor still in use. There is no maximum size. From order it is normally one to two weeks, depending on the specification. Where the frontage itself is being replaced rather than the glass in it, that is <a href="' . esc_url(home_url('/office-and-retail-glazing/')) . '">office and retail glazing</a>.',
            ],
            'stats' => [
                ['value' => 'No maximum', 'label' => 'unit size we will quote'],
                ['value' => '1-2 weeks', 'label' => 'from order, specification depending'],
                ['value' => 'Occupied', 'label' => 'buildings, floor still in use'],
            ],
            /* Owner-confirmed 2026-08-12: no maximum unit size, one to two weeks
               from order. Everything else on this route is genuinely unconfirmed
               and stays pending rather than being filled in from the domestic
               page, whose figures belong to a different job. */
            'specification' => [
                ['label' => 'Maximum unit size', 'value' => 'None. We will quote whatever the opening takes.'],
                ['label' => 'Lead time', 'value' => 'One to two weeks from order, depending on the specification.'],
                ['label' => 'Access', 'value' => 'Tracked lifter and vacuum head where the unit is too large or too high to carry through the building.'],
                ['label' => 'Measuring', 'value' => 'Site measured to the frame it is going into, before anything is ordered.'],
                ['label' => 'Glass', 'value' => 'Toughened and laminated supplied to order, any size.'],
                ['label' => 'Out of hours', 'value' => 'Early starts, evenings and weekends where the building needs it.'],
            ],
            'capabilities_heading' => 'What we take on when a unit has failed.',
            'capabilities' => [
                ['title' => 'Failed and blown units', 'copy' => 'Sealed units that have misted, crazed or lost their seal, measured to the frame they are going back into.'],
                ['title' => 'Broken and impacted glass', 'copy' => 'Shopfronts, entrance screens and elevations that have been put through, measured and reordered to the original opening.'],
                ['title' => 'Glass at height', 'copy' => 'Upper-floor and full-height units reached with a tracked lifter and vacuum head rather than taken out through the room.'],
                ['title' => 'Frames we did not fit', 'copy' => 'The unit is measured to whatever is already there, so the existing frames, beads and gaskets stay where they are.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Access',
                    'title' => 'The glass goes in from outside, so the floor keeps working.',
                    'copy' => 'A full-height commercial unit is too heavy and too awkward to bring through a working office, and taking it through means clearing the route it travels. We reach the opening from outside instead, on a tracked lifter with a vacuum head, and the room loses one bay rather than a floor. The lift equipment is hired in for the job and sized to the unit.',
                    'image' => '/wp-content/themes/fenster/assets/images/commercial/comm-access-spider-crane-1200w.jpg',
                    'alt' => 'A tracked spider crane and mobile tower set up outside a glazed commercial elevation, lifting a unit to first floor level',
                    'points' => ['Tracked lifter and vacuum head', 'Upper floors reached from outside', 'One bay closed, not a floor'],
                ],
                [
                    'eyebrow' => 'Measuring and ordering',
                    'title' => 'Measured to the frame it is going into, not to the drawing.',
                    'copy' => 'A commercial opening is rarely the size the drawing says, and a replacement unit that is close is a unit that comes back. We measure the frame on site before anything is ordered. From order it is normally one to two weeks depending on the specification, and there is no maximum size we will not quote.',
                    'image' => '/wp-content/themes/fenster/assets/images/commercial/comm-failed-unit-office-1200w.jpg',
                    'alt' => 'A crazed full-height glass unit being prepared for removal from inside an office',
                    'points' => ['Site measured before order', 'One to two weeks from order', 'No maximum unit size'],
                ],
            ],
            'use_cases_heading' => 'Buildings we reglaze most often.',
            'use_cases' => ['Offices', 'Shopfronts', 'Schools', 'Stairwells and lobbies', 'Public buildings', 'Occupied refurbishments'],
            'faqs' => [
                [
                    'question' => 'Is there a maximum unit size?',
                    'answer' => 'No. We will quote whatever the opening takes, and toughened and laminated glass is supplied to order at any size.',
                ],
                [
                    'question' => 'How long does a replacement unit take?',
                    'answer' => 'Normally one to two weeks from order, depending on the specification. The unit is site measured to the frame it is going into before anything is ordered.',
                ],
                [
                    'question' => 'Can you replace glass at height?',
                    'answer' => 'Yes, using a tracked lifter and vacuum head where the unit is too large or too high to carry through the building.',
                ],
                [
                    'question' => 'Will you work on frames you did not fit?',
                    'answer' => 'Yes. The unit is measured to whatever is already there, so the existing frames, beads and gaskets stay where they are.',
                ],
            ],
        ],
        'automatic-opening-vents' => [
            'eyebrow' => 'AOV smoke ventilation',
            'title' => 'Automatic opening vents',
            'subtitle' => 'AOV units supplied and installed as part of the commercial glazing package, for the stairwells, corridors and lobbies where smoke has to be cleared from an escape route.',
            'intro_heading' => 'A window that opens itself when the building fills with smoke.',
            /* ALL HALLOWS IS AN AOV JOB AND THIS PAGE WAS NOT USING IT. Seven
               photographs of AOV windows, screens and steel doorsets sat in the
               case-study library while this route ran on a scrape-era facade shot
               and a dealership elevation. Fixed 2026-08-12. */
            'hero_image' => $cs_base . 'cs-all-hallows-bedford-terrace.webp',
            'hero_alt' => 'A terrace elevation at All Hallows, Bedford, with new aluminium AOV windows and screens',
            'intro_image' => $cs_base . 'cs-all-hallows-bedford-window-inside.webp',
            'intro_alt' => 'An AOV window seen from inside the room, closed, in a new aluminium frame',
            'summary' => [
                'An automatic opening vent is a window or roof vent built into the building that opens on its own when smoke or heat is detected. Its job is to keep the escape route usable: the smoke goes out, the stairwell or corridor stays clear enough to walk down, and the fire service can see what they are walking into.',
                'We supply and install them. An AOV is a window before it is anything else, so it is worth specifying alongside the rest of the glazing rather than cutting one into a finished elevation afterwards.',
            ],
            'stats' => [
                ['value' => 'Supply', 'label' => 'and install, both by us'],
                ['value' => 'Escape routes', 'label' => 'stairwells, corridors and lobbies'],
                ['value' => 'Documented', 'label' => 'paperwork for the units we install'],
            ],
            /* SCOPE STATED POSITIVELY, per the 2026-08-02 owner ruling against
               writing what is not covered. Owner-confirmed 2026-07-28: no specific
               system, fit only, no commissioning. So the row names who does the
               commissioning rather than announcing what we decline — same fact,
               and it reads as a division of trades instead of a disclaimer. */
            /* Owner-confirmed 2026-08-12: "we dont fit the control panels, no
               electical works". Stated positively as a division of trades rather
               than as a list of what we decline, per the 2026-08-02 ruling.

               THE TESTING CLAIM CAME OFF WITH IT. The row used to read "Tested
               before handover". With no electrical works in our scope we cannot
               power-test the vent, so that claim could not have been ours to make
               — it now says the unit is installed and its documentation handed
               over, which is what we actually do. Flagged to the owner rather than
               changed silently, because it was approved copy. */
            'specification' => [
                ['label' => 'Scope', 'value' => 'We supply and install the vent within the glazing package. Wiring, control panels and commissioning sit with your fire alarm and electrical contractors.'],
                ['label' => 'Control panels', 'value' => 'Supplied and wired by your fire alarm or electrical contractor.'],
                ['label' => 'Standard', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The standard we install AOV units to (EN 12101-2 or otherwise)'],
                ['label' => 'Aerodynamic free area', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Aerodynamic free area figures for the units we fit'],
                ['label' => 'Position', 'value' => 'Formed within the window or screen line so the elevation still reads as one system.'],
                ['label' => 'Handover', 'value' => 'Documentation for the units we install is passed to you at handover.'],
            ],
            'capabilities_heading' => 'What we take on within an AOV package.',
            'capabilities' => [
                ['title' => 'Vents in the elevation', 'copy' => 'Opening vents formed within the window or screen line so the facade still reads as one system.'],
                ['title' => 'Roof and stairwell vents', 'copy' => 'Vents at the head of a stair or in the roof, where the smoke needs somewhere to go.'],
                ['title' => 'Fitted with the glazing', 'copy' => 'Installed as part of the window and door package rather than cut in as a separate trade afterwards.'],
                /* Was "Tested on completion". With no electrical works in our
                   scope, owner-confirmed 2026-08-12, the powered test is not ours
                   to claim. The documentation still is. */
                ['title' => 'Documented at handover', 'copy' => 'The paperwork for the units we install is passed to you, ready for your commissioning contractor.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Specify it early',
                    'title' => 'An AOV decided late becomes a hole cut in a finished elevation.',
                    'copy' => 'The vent has to sit somewhere that works structurally, keeps the sightlines and still opens far enough to do its job. Knowing where it goes before the frames are made is the difference between a vent that looks like part of the building and one that looks like an afterthought.',
                    'image' => $cs_base . 'cs-all-hallows-bedford-screen.webp',
                    'alt' => 'A new aluminium screen at All Hallows, Bedford, with the vent formed within the window line',
                    'points' => ['Position agreed before manufacture', 'Sightlines kept across the elevation', 'Opening area checked against the brief'],
                ],
                [
                    'eyebrow' => 'What we need from you',
                    'title' => 'Send the fire strategy and we will work to it.',
                    'copy' => 'Where the vents go, how much they open and what triggers them come out of the building fire strategy, not out of a glazing quote. Send us that strategy or the specification written from it and we will price and fit to it. If it has not been written yet, tell us and we will hold the vent positions open rather than guess at them.',
                    /* Was `SM-033-006.jpg`, Smart Systems marketing photography.
                       Flagged in the commercial audit and replaced with ours. */
                    'image' => $cs_base . 'cs-all-hallows-bedford-screen-inside.webp',
                    'alt' => 'A glazed screen at All Hallows, Bedford, seen from inside the stair core',
                    'points' => ['Fire strategy or specification', 'Vent positions and opening area', 'Programme and access on site'],
                ],
            ],
            'use_cases_heading' => 'Where AOV units usually go.',
            'use_cases' => ['Stairwells', 'Corridors and lobbies', 'Apartment blocks', 'Offices', 'Schools', 'Care settings'],
            /* THE SCOPE ANSWER IS THE IMPORTANT ONE ON THIS ROUTE, because the
               question a specifier actually has is where our scope stops and
               their electrical contractor's begins. It states what we do and
               what the other trade does, which is a division of work rather
               than a list of exclusions. */
            'faqs' => [
                [
                    'question' => 'What is an automatic opening vent?',
                    'answer' => 'A window or roof vent built into the building that opens on its own when smoke or heat is detected, so the escape route stays usable: the smoke goes out and the stairwell or corridor stays clear.',
                ],
                [
                    'question' => 'What is included in your AOV scope?',
                    'answer' => 'We supply and install the vent within the glazing package. Control panels are supplied and wired by your fire alarm or electrical contractor, and commissioning sits with them.',
                ],
                [
                    'question' => 'Where does the vent sit in the elevation?',
                    'answer' => 'Formed within the window or screen line so the elevation still reads as one system, and installed as part of the window and door package rather than cut into a finished elevation afterwards.',
                ],
                [
                    'question' => 'What documentation do we get at handover?',
                    'answer' => 'Documentation for the units we install is passed to you at handover, ready for your commissioning contractor.',
                ],
            ],
        ],
        'healthcare-construction' => [
            'eyebrow' => 'Healthcare glazing',
            'title' => 'Healthcare and clinical glazing',
            'subtitle' => 'Windows, doors and glazed screens for dental practices, clinics and healthcare buildings, fitted around a treatment list that does not stop.',
            'intro_heading' => 'A clinic cannot close for a fortnight and neither can its list.',
            /* THE SAME PHOTOGRAPH WAS HERE THREE TIMES on the first pass — hero,
               intro and the first detail section — which is the fault the
               residential template keeps an image queue to prevent. The intro is
               deliberately imageless now, so the copy runs at a single readable
               measure rather than repeating the frontage a second time. */
            'hero_image' => $asset_base . 'dental-practice-glazing.jpg',
            'hero_alt' => 'A dental practice frontage after its glazing was replaced',
            'intro_image' => '',
            'intro_alt' => '',
            'summary' => [
                'Healthcare buildings are the strictest kind of occupied site. A treatment room out of use is a list that slips, infection control decides where dust may travel, and the rooms you most want to reglaze are the ones that can least afford to close. The specification is rarely the hard part.',
                'We survey and install replacement windows, doorsets, glazed screens and sealed units in live clinical settings, agreeing the room-by-room sequence before we start. Our most recent work of this type was the entrance glazing at <a href="' . esc_url(home_url('/commercial-projects/roka-dental-woburn-sands/')) . '">Roka Dental in Woburn Sands</a>.',
            ],
            'stats' => [
                ['value' => 'Room by room', 'label' => 'opened and closed the same day'],
                ['value' => 'Restrictors', 'label' => 'fitted to your risk assessment'],
                ['value' => 'Occupied', 'label' => 'clinical areas kept in use'],
            ],
            'specification' => [
                ['label' => 'Safety glass', 'value' => 'Toughened or laminated to the opening, with laminated available as an upgrade throughout.'],
                ['label' => 'Privacy', 'value' => 'Obscure glass across the full pattern range, specified per room.'],
                ['label' => 'Restrictors', 'value' => 'Fitted to the limit your own risk assessment sets, consistent across the building.'],
                /* Owner answered the vetting question with "dbs checked". He did
                   NOT claim an infection-control accreditation, so this states the
                   vetting we actually hold rather than leaving a row open that
                   hints at one we do not. */
                ['label' => 'Vetting', 'value' => 'DBS-checked operatives, and site induction where the practice requires it.'],
                ['label' => 'Fire rating', 'value' => 'Fire-rated glazing supplied to the rating the specification calls for.'],
                ['label' => 'Acoustic', 'value' => 'Acoustic glass specified to the level consultation-room privacy requires.'],
            ],
            'capabilities_heading' => 'What we take on in a clinical building.',
            'capabilities' => [
                ['title' => 'Treatment and consulting rooms', 'copy' => 'One room opened, glazed, sealed and cleaned within the day so the room is back on the list tomorrow.'],
                ['title' => 'Entrances and reception screens', 'copy' => 'The arrival elevation, where accessibility, door width and the approach all get looked at together.'],
                ['title' => 'Safe and private openings', 'copy' => 'Restrictors to your assessment, obscure glass where a room is overlooked, and safety glass where the opening needs it.'],
                ['title' => 'Phased around the list', 'copy' => 'Sequencing agreed against clinic hours and room availability rather than against our own programme.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Specification',
                    'title' => 'Safety, privacy and noise are decided per room, not per building.',
                    'copy' => 'A waiting room, a consulting room and a treatment room want three different answers from the same window. We go through them opening by opening before anything is made: toughened or laminated, clear or obscure, how far it opens and whether anyone can hear through it.',
                    'image' => $asset_base . '668a13f5-3500-420d-8e15-47834268084b.jpg',
                    'alt' => 'A care building elevation with replacement windows, the openings restricted for safe use',
                    'points' => ['Safety glass per opening', 'Obscure glass where overlooked', 'Restrictors to your assessment'],
                ],
                [
                    'eyebrow' => 'Working in a live clinic',
                    'title' => 'Where the dust goes matters more than where the skip goes.',
                    'copy' => 'Infection control decides the route, the screening and the sequence, so we agree them with your practice manager before day one rather than on it. Rooms are handed back clean and usable at the end of each day, which is slower and is the only way a clinic can absorb the work.',
                    /* Best current fit, 2026-08-12, replacing the last marked
                       placeholder on the commercial set. It is an interior: a new
                       window seen from inside a finished room at All Hallows, which
                       is what "handed back clean" looks like even though the
                       building is not a clinic.

                       THE ALT MAKES NO CLINICAL CLAIM, because it is not a clinical
                       room. That is the compromise in using it here, and it is the
                       reason a real clinical interior is still top of the
                       photography list for this route. */
                    'image' => $cs_base . 'cs-all-hallows-bedford-window-inside.webp',
                    'alt' => 'A new aluminium window seen from inside a finished room, the space cleaned and back in use',
                    'points' => ['Route and screening agreed first', 'Same-day handback per room', 'Sequenced against clinic hours'],
                ],
            ],
            'use_cases_heading' => 'Where this work usually happens.',
            'use_cases' => ['Dental practices', 'GP surgeries', 'Clinics', 'Treatment rooms', 'Care settings', 'Public-sector health buildings'],
            'faqs' => [
                [
                    'question' => 'Can you work in a live clinical setting?',
                    'answer' => 'Yes. One room is opened, glazed, sealed and cleaned within the day so the room is back on the list tomorrow, with the room-by-room sequence agreed against clinic hours before we start.',
                ],
                [
                    'question' => 'Are your operatives DBS checked?',
                    'answer' => 'Yes. DBS-checked operatives, and site induction where the practice requires it.',
                ],
                [
                    'question' => 'How is privacy handled in a consulting room?',
                    'answer' => 'Obscure glass across the full pattern range, specified per room, with acoustic glass specified to the level consultation-room privacy requires.',
                ],
                [
                    'question' => 'Have you worked in a healthcare building?',
                    'answer' => 'Yes. Our most recent work of this type was the entrance glazing at Roka Dental in Woburn Sands.',
                ],
            ],
        ],
    ];
}

/**
 * The louvre range, as IKON publish it.
 * ---------------------------------------------------------------------------
 * Every figure here is IKON's own published specification for the system named,
 * taken from `ikonaluminium.com` on 2026-08-11, and the page attributes them.
 * Nothing is restated as a Fenster performance figure, which is the rule the
 * Kenrick and Sheerline numbers are held to everywhere else.
 *
 * COMPOSITE PANELS ARE DELIBERATELY ABSENT. Owner instruction, 2026-08-11: they
 * are the one product in IKON's louvre range we do not offer. IKON list them
 * alongside these systems; we do not. Do not add them back from their website.
 *
 * The blade centre on IKL33 really is 34mm — the system name and the blade
 * pitch do not match, and that is IKON's naming rather than a typo here.
 *
 * "Visual" and "physical" free area are two different measurements and the page
 * explains the difference, because a consultant's schedule means the physical
 * one and the difference between them is most of the confusion on this product.
 */
function fenster_louvre_systems(): array
{
    return [
        'standard' => [
            ['code' => 'IKL30-PFA50', 'centre' => '30mm', 'angle' => '59°', 'visual' => '58%', 'physical' => '50%', 'depth' => '36.2mm'],
            ['code' => 'IKL33', 'centre' => '34mm', 'angle' => '60°', 'visual' => '59%', 'physical' => '43.5%', 'depth' => '36.2mm', 'common' => true],
            ['code' => 'IKL50', 'centre' => '50mm', 'angle' => '45°', 'visual' => '79%', 'physical' => '50%', 'depth' => '64.2mm'],
            ['code' => 'IKL75', 'centre' => '75mm', 'angle' => '45°', 'visual' => '86%', 'physical' => '57%', 'depth' => '80.8mm'],
        ],
        'continuous' => [
            ['code' => 'IKCL33', 'centre' => '34mm', 'angle' => '60°', 'visual' => '59%', 'physical' => '43.5%'],
            ['code' => 'IKCL50', 'centre' => '50mm', 'angle' => '45°', 'visual' => '79%', 'physical' => '50%'],
            ['code' => 'IKCL75', 'centre' => '75mm', 'angle' => '45°', 'visual' => '86%', 'physical' => '57%'],
            ['code' => 'IKCL95', 'centre' => '95mm', 'angle' => '45°', 'visual' => '81%', 'physical' => '56%'],
        ],
        /* Not blade systems, so they are described rather than tabulated: a
           table with two empty columns invites somebody to fill them in. */
        'specials' => [
            [
                'name' => 'Turret louvres',
                'copy' => 'A roof-mounted box louvred on its sides, for intake and discharge at high level. Built from the 50mm, 75mm or 95mm blade to suit the airflow, flat topped, sloping, hipped or bespoke, and able to serve intake and discharge together using divider plates, insulated or not. Maximum free area is 57%, using the 75mm blade.',
            ],
            [
                'name' => 'Plenum boxes',
                'copy' => 'A folded and welded aluminium box behind the louvre, for connecting mechanical and electrical ventilation equipment. Spigots are usually rectangular or circular, the internal face can be insulated, and each box is fabricated to the job.',
            ],
        ],
        /* The five ways the same louvre meets the opening. This is the part of a
           louvre specification that most often goes wrong on site, because the
           frame has to suit the construction it is going into and that is
           settled at survey rather than on a drawing. */
        'frames' => [
            ['name' => 'Flange frame', 'copy' => 'A flange laps onto the face of the opening and covers the joint.'],
            ['name' => 'Glaze-in frame', 'copy' => 'The louvre glazes into a window or curtain walling system in place of a pane, in 24mm, 28mm or 32mm to suit the sightline.'],
            ['name' => 'Rebate frame', 'copy' => 'The frame sits into a rebate formed in the structural opening.'],
            ['name' => 'Face fix frame', 'copy' => 'Fixed to the face of the building where there is no reveal to work into.'],
            ['name' => 'Structurally glazed frame', 'copy' => 'For elevations where the louvre has to read as part of a structurally glazed line.'],
        ],
        'options' => [
            ['name' => 'Drainage channel', 'copy' => 'Takes water caught by the blades away from the opening rather than down the wall behind.'],
            ['name' => 'Insect and bird mesh', 'copy' => 'Fitted behind the blades where the opening leads somewhere that needs to stay clear of both.'],
            ['name' => 'Any RAL or BS colour', 'copy' => 'Powder coated to match the surrounding glazing or the wall behind. Anodising to special order.'],
        ],
    ];
}

function fenster_commercial_product_page(string $slug): ?array
{
    $pages = fenster_commercial_product_pages();

    return $pages[$slug] ?? null;
}

/**
 * FAQs for the commercial hub.
 * ---------------------------------------------------------------------------
 * The hub sells nothing itself, so its questions are the ones a contractor,
 * architect, QS or estimator asks BEFORE they know which route they want:
 * coverage, credentials, working in an occupied building, and how to get a
 * price. The product-specific questions live on the routes.
 *
 * The credentials answer names the same three as
 * `template-parts/components/commercial-credentials.php` and must stay in step
 * with it. FENSA and the CPA guarantee stay out of it for the reason recorded
 * there: both are residential schemes, and putting either in front of somebody
 * pricing a school is padding at best.
 *
 * @return array<int, array{question: string, answer: string}>
 */
function fenster_commercial_hub_faqs(): array
{
    $brand = fenster_data('brand', []);

    return [
        [
            'question' => 'Where do you carry out commercial glazing?',
            'answer' => 'Nationwide across England and Wales. Our residential work is concentrated around Milton Keynes, but commercial schemes are not limited to that radius.',
        ],
        [
            'question' => 'What can you put on a pre-qualification questionnaire?',
            'answer' => 'Constructionline Gold, SSIP accreditation for health and safety, and DBS-checked operatives for schools, care settings and any site where the check is a condition of access.',
        ],
        [
            'question' => 'Can you work in a building that stays in use?',
            'answer' => 'Yes, and most of this work is. Phasing, access routes, out-of-hours working and daily handback are agreed at quote stage rather than discovered in week two.',
        ],
        [
            'question' => 'Do you work to our drawings or survey it yourselves?',
            'answer' => 'Either. We work from your drawings and schedules where you have them, and from a site survey where you do not. On refurbishments openings are measured one by one, because a refurbished building rarely matches the drawing.',
        ],
        [
            'question' => 'How do we get a price?',
            'answer' => 'Send the drawings, elevations or schedule to ' . (string) ($brand['commercial_email'] ?? 'commercial@fensterglazing.com') . ' and we will price against them. There is an enquiry form on every commercial page that takes attachments if that is easier.',
        ],
    ];
}
