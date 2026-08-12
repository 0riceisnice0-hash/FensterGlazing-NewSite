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
            'intro_heading' => 'One package, one contractor, one set of interfaces to argue about.',
            /* Was `commercial-1.jpg` and `commercial-4.jpg`, both scrape. This is
               the Bletchley rail depot: curtain walling, windows and doors on one
               building, all ours, and the single best photograph on the site of
               what this page actually sells. */
            'hero_image' => $cs_base . 'cs-bletchley-rail-depot-elevation.webp',
            'hero_alt' => 'Refurbished rail depot elevation with new aluminium curtain walling, windows and entrance doors',
            'intro_image' => $cs_base . 'cs-all-hallows-bedford-terrace-run.webp',
            'intro_alt' => 'A run of new aluminium windows and screens across a terrace elevation at All Hallows, Bedford',
            'summary' => [
                'We survey, supply and install the whole opening: aluminium and uPVC windows, glazed doorsets, entrance screens, the glass in them and the ironmongery on them. Taking it as one package is the point, because most of what goes wrong on a glazing package goes wrong at the joints between two suppliers.',
                'We work from your drawings and schedules where you have them, and from a site survey where you do not. On occupied buildings the sequence is agreed before we start: which elevations, in what order, during which hours, and what is handed back at the end of each day.',
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
            'specification' => [
                ['label' => 'Aluminium systems', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Which aluminium systems we fit commercially (Technal, Smart, Senior or other)'],
                ['label' => 'uPVC systems', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Which uPVC system we fit commercially'],
                ['label' => 'Fire rating', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Fire ratings we can actually claim on commercial glazing, and to which standard'],
                ['label' => 'Security', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Our PAS 24 / Secured by Design position on commercial work'],
                ['label' => 'Steel doorsets', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether steel doorsets get their own page, and the rating they carry'],
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
                    'copy' => 'Split a glazing package across suppliers and the gaps appear at the interfaces: a restrictor that fouls the opening, a closer that will not hold a door in wind, a threshold that fails Part M by four millimetres. We check opening sizes, glass type, restrictors, ventilation, finish, locks, closers, handles and thresholds as one specification before anything is ordered.',
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
            'intro_image' => $cs_base . 'cs-bletchley-rail-depot-elevation.webp',
            'intro_alt' => 'Curtain walling, windows and entrance doors on a refurbished rail depot elevation',
            'summary' => [
                'Curtain walling is a non-structural envelope hung off the building frame. It carries its own dead load, the wind load on the elevation and whatever the structure does underneath it, and it drains itself. That last part is what separates a curtain wall from a big window, and it is where a badly detailed one fails.',
                'We survey, supply and install it on replacement facades, refurbishments and new openings, with doors, opening vents, insulated panels and louvres worked into the grid rather than added to it. Our most recent scheme of this type was the <a href="' . esc_url(home_url('/commercial-projects/bletchley-rail-depot-refurbishment/')) . '">Bletchley rail depot refurbishment</a>.',
            ],
            'stats' => [
                ['value' => 'Facades', 'label' => 'replacement and new openings'],
                ['value' => 'Integrated', 'label' => 'doors, vents, panels and louvres'],
                ['value' => 'Any RAL', 'label' => 'powder coated, dual colour available'],
            ],
            'specification' => [
                ['label' => 'System', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Which curtain walling system(s) we fit'],
                ['label' => 'Mullion and transom', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Mullion and transom sizes, and the depth range available'],
                ['label' => 'U-value', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Achievable U-value for the system, and at what glazing specification'],
                ['label' => 'Wind load', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The wind-load standard we design and test to'],
                ['label' => 'Maximum panel', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Maximum panel size and glass weight we can handle'],
                ['label' => 'Structural or capped', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we offer structural glazing or capped only'],
                ['label' => 'Integrated units', 'value' => 'Doorsets, opening vents, AOV units, insulated panels and ventilation louvres within the grid.'],
                ['label' => 'Finish', 'value' => 'Powder coated to any RAL, dual colour available.'],
            ],
            'capabilities_heading' => 'What we take on within a curtain walling package.',
            'capabilities' => [
                ['title' => 'Screens and elevations', 'copy' => 'Mullion and transom grids across full elevations, atria, stairwells and entrance bays.'],
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
                    'title' => 'Head, cill, jamb and drainage decide whether it leaks.',
                    'copy' => 'A curtain wall drains internally and discharges at the cill, so the details where it meets the structure matter more than the ones you can see. We check fixing points, movement allowance, cill and jamb interfaces, drainage paths and the condition of the existing structure before anything is fixed to it.',
                    'image' => $cs_base . 'cs-bletchley-rail-depot-head-detail.webp',
                    'alt' => 'Head detail where new curtain walling meets the existing structure above it',
                    'points' => ['Fixing points and movement', 'Drainage and weathering', 'Existing structure surveyed first'],
                ],
            ],
            'use_cases_heading' => 'Where curtain walling usually goes.',
            'use_cases' => ['Office elevations', 'Glazed entrances', 'Stairwells and atria', 'Retail frontages', 'Reception screens', 'Replacement facades', 'Education blocks', 'Industrial offices'],
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
            'hero_image' => $cs_base . 'cs-bletchley-rail-depot-entrance.webp',
            'hero_alt' => 'A glazed commercial entrance screen with double doors set into a curtain walling grid',
            'intro_image' => $cs_base . 'cs-all-hallows-bedford-steel-doorset.webp',
            'intro_alt' => 'A steel entrance doorset with a glazed screen above and beside it',
            'summary' => [
                'An automated entrance is where four trades meet: the glazed screen, the doorset, the operator and the access control. Each is straightforward on its own, and the failures are almost always at the joins — an operator with nothing solid to fix to, a threshold that fails Part M, a sensor zone that overlaps a swing path, a maglock nobody left a cable route for.',
                'We supply and install the glazed entrance package and coordinate the automation and access-control specialists into it, so the screen, the door, the operator and the reader are set out together before anything is made.',
            ],
            'stats' => [
                ['value' => 'Entrances', 'label' => 'retail, office and public buildings'],
                ['value' => 'Coordinated', 'label' => 'operator and access control'],
                ['value' => 'Part M', 'label' => 'thresholds and approach checked'],
            ],
            'specification' => [
                ['label' => 'Operators', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Which door operators we install (swing and sliding), and whose'],
                ['label' => 'Service and maintenance', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we service and maintain operators after handover, and on what interval'],
                ['label' => 'Standards', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The standard we install powered doors to (BS EN 16005 or otherwise)'],
                ['label' => 'Access control', 'value' => 'Frames, locks and cable routes coordinated around your access-control specialist\'s equipment.'],
                ['label' => 'Glass', 'value' => 'Toughened or laminated throughout, with manifestation to suit the screen.'],
                ['label' => 'Thresholds', 'value' => 'Level and Part M compliant approaches where the building allows it.'],
            ],
            'capabilities_heading' => 'What we take on within an entrance package.',
            'capabilities' => [
                ['title' => 'Entrance screens', 'copy' => 'The glazed screen the entrance sits in: side screens, toplights and the framing that carries the operator.'],
                ['title' => 'Doorsets', 'copy' => 'Commercial doorsets specified for the traffic they take, with the closers, locks and hinges to match.'],
                ['title' => 'Operator coordination', 'copy' => 'Set-out agreed with the automation specialist so the operator has structure to fix to and a swing path that clears.'],
                ['title' => 'Access control interfaces', 'copy' => 'Cable routes, maglock positions and reader locations designed into the frame rather than drilled into it later.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Set-out',
                    'title' => 'Footfall and the escape route decide the door before the finish does.',
                    'copy' => 'Clear opening width, traffic direction, the escape route through the entrance and the space the operator needs above the head are the four things that fix the design. Get them right and the rest is finish. Get them wrong and the entrance is rebuilt.',
                    'image' => $cs_base . 'cs-bletchley-rail-depot-entrance.webp',
                    'alt' => 'A commercial glazed entrance with double doors, viewed square on',
                    'points' => ['Clear opening width and traffic flow', 'Escape route and emergency release', 'Head space for the operator'],
                ],
                [
                    'eyebrow' => 'The entrance in use',
                    'title' => 'A powered door still has to work when the power is off.',
                    'copy' => 'Every automated entrance needs a manual answer: how it opens in a power cut, how it releases on the fire alarm, and how it locks at night. Those are specification decisions, not commissioning ones, and they belong in the drawing rather than in a conversation on handover day.',
                    /* MARKED PLACEHOLDER. We have fitted automatic entrances and
                       photographed none of them. Rather than reuse the screen shot
                       above or borrow a manual door, the slot says what it is
                       waiting for — the Marked Placeholders Rule in `AI.md`.
                       Replace with a real operator photograph and delete the flag. */
                    'image' => '',
                    'placeholder' => 'An automatic entrance we have fitted, showing the operator above the door head.',
                    'alt' => '',
                    'points' => ['Power-off and fail-safe behaviour', 'Fire alarm release', 'Night locking and out-of-hours use'],
                ],
            ],
            'use_cases_heading' => 'Where automated entrances usually go.',
            'use_cases' => ['Retail entrances', 'Office receptions', 'Healthcare buildings', 'Education estates', 'Public access routes', 'High-traffic doors'],
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
                ['label' => 'Fire rating', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Fire-rated glazing we can supply for school corridors and escape routes'],
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
                ['label' => 'Acoustic performance', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The dB reduction we can claim on the acoustic units we fit'],
                ['label' => 'Fire rating', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Fire-rated glazing available for PBSA corridors and escape routes'],
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
                ['label' => 'Acoustic performance', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The dB reduction we can claim on the acoustic units we fit'],
                ['label' => 'Out of hours', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we work nights for hospitality, and how that is priced'],
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
                ['label' => 'Thermal', 'value' => FENSTER_SPEC_TBC, 'pending' => 'U-value we quote on the commercial window systems used in care settings'],
                ['label' => 'Accreditation', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Any care-sector accreditation or vetting we hold that a home asks for'],
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
        ],
        'office-and-retail-glazing' => [
            'eyebrow' => 'Offices and retail',
            'title' => 'Office and retail glazing',
            'subtitle' => 'Windows, entrance screens and curtain walling for offices, shops and workplaces, worked around your trading and working hours.',
            'intro_heading' => 'The building has to keep earning while we are on it.',
            'hero_image' => $sector_base . 'sector-offices-water-end-barn-1400w.webp',
            'hero_alt' => 'Converted barn office complex with replacement windows',
            'intro_image' => $sector_base . 'sector-offices-courtyard-1000w.webp',
            'intro_alt' => 'Office courtyard elevation with new glazing',
            'summary' => [
                'Offices and shops have the same problem from opposite ends of the day: an office needs its desks usable from nine, a shop needs its frontage clear from opening. Both usually mean working early, late or at a weekend, and that belongs in the price rather than as a surprise later.',
                'The work ranges from a converted barn office at Water End Barn to commercial buildings such as Franklin House and Orient House. Tell us the hours the building has to work and we will price around them.',
            ],
            'stats' => [
                ['value' => 'Out of hours', 'label' => 'where trading demands it'],
                ['value' => 'Occupied', 'label' => 'floors kept usable'],
                ['value' => 'Frontages', 'label' => 'entrances and shopfront glazing'],
            ],
            'specification' => [
                ['label' => 'Working hours', 'value' => 'Early starts, evenings and weekends where trading demands it, priced at quote stage.'],
                ['label' => 'Possession', 'value' => 'Floor by floor or unit by unit, with the space usable the next morning.'],
                ['label' => 'Glass', 'value' => 'Solar control, acoustic and safety glass specified against the elevation and the use.'],
                ['label' => 'Thermal', 'value' => FENSTER_SPEC_TBC, 'pending' => 'U-value we quote on the commercial window and curtain walling systems'],
                ['label' => 'Shopfront glass', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we supply toughened and laminated shopfront glass to order, and to what size'],
            ],
            'capabilities_heading' => 'What we take on across an office or retail building.',
            'capabilities' => [
                ['title' => 'Office windows', 'copy' => 'Replacement windows floor by floor, with desks moved back and the floor usable the next morning.'],
                ['title' => 'Entrance screens', 'copy' => 'Glazed entrances and reception screens, coordinated with automatic doors and access control.'],
                ['title' => 'Curtain walling', 'copy' => 'Larger glazed elevations, replacement facade panels and phased facade works.'],
                ['title' => 'Shopfronts', 'copy' => 'Retail frontages and doors, with the unit trading around the work where it can be.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Working hours',
                    'title' => 'Say when the building has to be usable and we will work to it.',
                    'copy' => 'Most office and retail jobs come down to when we can be noisy and when we cannot. Early starts, evening work and weekend possessions all cost differently, so it is worth agreeing them at quote stage rather than discovering the constraint in week two.',
                    'image' => $sector_base . 'sector-offices-courtyard-1000w.webp',
                    'alt' => 'Office building elevation during glazing works',
                    'points' => ['Out of hours where needed', 'Floor by floor possession', 'Agreed noisy hours'],
                ],
                [
                    'eyebrow' => 'Older commercial buildings',
                    'title' => 'A converted building rarely matches its own drawings.',
                    'copy' => 'Barn conversions, mills and older commercial premises tend to have openings that have moved over a century and a half. We survey them individually rather than working off the original drawing, because the drawing is usually optimistic.',
                    'image' => $sector_base . 'sector-offices-water-end-barn-1400w.webp',
                    'alt' => 'Converted barn office building with traditional glazing',
                    'points' => ['Individual opening survey', 'Sympathetic replacements', 'Conservation constraints checked'],
                ],
            ],
            'use_cases_heading' => 'Buildings this work suits.',
            'use_cases' => ['Offices', 'Business parks', 'Converted buildings', 'Retail units', 'Shopfronts', 'Workplaces'],
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
                'We measure the failed unit, order it to the frame it is going into, and fit it with the floor still in use. There is no maximum size. From order it is normally one to two weeks, depending on the specification.',
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
                ['label' => 'Glass', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we supply toughened and laminated shopfront glass to order, and to what size'],
                ['label' => 'Out of hours', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Whether we work out of hours to keep a building trading, and how that is priced'],
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
                ['value' => 'Handover', 'label' => 'documentation for what we fit'],
            ],
            /* SCOPE STATED POSITIVELY, per the 2026-08-02 owner ruling against
               writing what is not covered. Owner-confirmed 2026-07-28: no specific
               system, fit only, no commissioning. So the row names who does the
               commissioning rather than announcing what we decline — same fact,
               and it reads as a division of trades instead of a disclaimer. */
            'specification' => [
                ['label' => 'Scope', 'value' => 'We supply and install the vent as part of the glazing package. Commissioning and the detection strategy sit with your fire alarm contractor.'],
                ['label' => 'Standard', 'value' => FENSTER_SPEC_TBC, 'pending' => 'The standard we install AOV units to (EN 12101-2 or otherwise)'],
                ['label' => 'Aerodynamic free area', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Aerodynamic free area figures for the units we fit'],
                ['label' => 'Control panels', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Which control panels we work alongside, and who supplies them'],
                ['label' => 'Position', 'value' => 'Formed within the window or screen line so the elevation still reads as one system.'],
                ['label' => 'Handover', 'value' => 'Tested before handover, with the documentation for what we installed passed to you.'],
            ],
            'capabilities_heading' => 'What we take on within an AOV package.',
            'capabilities' => [
                ['title' => 'Vents in the elevation', 'copy' => 'Opening vents formed within the window or screen line so the facade still reads as one system.'],
                ['title' => 'Roof and stairwell vents', 'copy' => 'Vents at the head of a stair or in the roof, where the smoke needs somewhere to go.'],
                ['title' => 'Fitted with the glazing', 'copy' => 'Installed as part of the window and door package rather than cut in as a separate trade afterwards.'],
                ['title' => 'Tested on completion', 'copy' => 'The vents we install are tested before handover and the paperwork for them goes to you.'],
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
        ],
        'healthcare-construction' => [
            'eyebrow' => 'Healthcare glazing',
            'title' => 'Healthcare and clinical glazing',
            'subtitle' => 'Windows, doors and glazed screens for dental practices, clinics and healthcare buildings, fitted around a treatment list that does not stop.',
            'intro_heading' => 'A clinic cannot close for a fortnight and neither can its list.',
            'hero_image' => $asset_base . 'dental-practice-glazing.jpg',
            'hero_alt' => 'A dental practice frontage after its glazing was replaced',
            'intro_image' => $asset_base . 'dental-practice-glazing.jpg',
            'intro_alt' => 'New glazing on a dental practice, seen from the street',
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
                ['label' => 'Infection control', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Any infection-control or clinical working accreditation we hold that a healthcare buyer asks for'],
                ['label' => 'Fire rating', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Fire-rated glazing we can supply for clinical corridors and escape routes'],
                ['label' => 'Acoustic', 'value' => FENSTER_SPEC_TBC, 'pending' => 'Acoustic performance we can claim where consultation-room privacy is specified'],
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
                    'image' => $asset_base . 'dental-practice-glazing.jpg',
                    'alt' => 'Glazed frontage of a dental practice after replacement',
                    'points' => ['Safety glass per opening', 'Obscure glass where overlooked', 'Restrictors to your assessment'],
                ],
                [
                    'eyebrow' => 'Working in a live clinic',
                    'title' => 'Where the dust goes matters more than where the skip goes.',
                    'copy' => 'Infection control decides the route, the screening and the sequence, so we agree them with your practice manager before day one rather than on it. Rooms are handed back clean and usable at the end of each day, which is slower and is the only way a clinic can absorb the work.',
                    /* MARKED PLACEHOLDER. The Roka frontage is the only healthcare
                       photograph we own and it is already used twice above. Nothing
                       shows us working inside a live clinical setting. */
                    'image' => '',
                    'placeholder' => 'A clinical or care interior we have worked in, showing screening and a room handed back clean.',
                    'alt' => '',
                    'points' => ['Route and screening agreed first', 'Same-day handback per room', 'Sequenced against clinic hours'],
                ],
            ],
            'use_cases_heading' => 'Where this work usually happens.',
            'use_cases' => ['Dental practices', 'GP surgeries', 'Clinics', 'Treatment rooms', 'Care settings', 'Public-sector health buildings'],
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
