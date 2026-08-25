<?php
/**
 * Curated residential case studies.
 *
 * Single source of truth for the /case-studies/ archive and each
 * /case-studies/{slug}/ detail page. Add a new entry here to publish a new
 * case study: images live in assets/images/case-studies/, product and colour
 * links point at real routes, and the template renders everything from these
 * fields. The array is ordered newest first.
 *
 * Each detail page is text-led and descriptive: a short lead, a written
 * overview (accurate to the real product pages), a clean specification panel
 * and a captioned image gallery. No large hero imagery.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Return every published residential case study keyed by its detail slug.
 *
 * The key is the path segment after "case-studies/". Each entry is fully
 * self-describing so the archive and detail templates never need to guess.
 * `overview` paragraphs may contain simple <a> links (rendered with wp_kses).
 *
 * @return array<string, array<string, mixed>>
 */
function fenster_case_studies(): array
{
    static $cache = null;
    if (is_array($cache)) {
        return $cache;
    }

    $img = FENSTER_THEME_URI . '/assets/images/case-studies/';
    $casement = esc_url(home_url('/casement-windows/'));
    $flush = esc_url(home_url('/flush-casement-windows/'));
    $bifold = esc_url(home_url('/aluminium-bifold-doors/'));
    $slidefold = esc_url(home_url('/slide-fold-doors/'));
    $sash = esc_url(home_url('/sliding-sash-windows/'));
    $secondary = esc_url(home_url('/secondary-glazing/'));
    $team = esc_url(home_url('/meet-the-team/'));
    $team_img = FENSTER_THEME_URI . '/assets/images/imported/';

    // Colour hub deep links pre-select the swatch and scroll to its material.
    $colour_link = static fn (string $material, string $slug): string => home_url('/colour-options/?material=' . $material . '&colour=' . $slug);
    $colour_basalt = $colour_link('upvc', 'basalt-grey');
    $colour_anthracite = $colour_link('aluminium', 'anthracite-grey');
    $colour_anthracite_upvc = $colour_link('upvc', 'anthracite-grey');
    $colour_white = $colour_link('upvc', 'white');
    // Black Brown is a real Liniar foil, RAL 8022, in the uPVC palette in
    // site-data.php. The slug follows the same sanitize_title derivation the
    // other uPVC deep links here already rely on.
    $colour_black_brown = $colour_link('upvc', 'black-brown');
    /* Agate Grey, RAL 7038, is in the uPVC palette and in the aluminium one.
       It is NOT in the composite door palette, which stops at Buckingham Grey
       and Black Brown among the greys, so there is no composite swatch to deep
       link and this points at the uPVC one. That is the right target anyway on
       Little Horwood, where the windows are the bulk of the job and the door is
       finished to match them. Do not "fix" this by inventing a composite slug:
       check `colour_options.materials.composite` in site-data.php first. */
    $colour_agate = $colour_link('upvc', 'agate-grey');
    /* Colza Yellow is RAL 1021 and it is in the COMPOSITE palette in
       site-data.php, not the uPVC one, so the material segment matters:
       the hub renders every material in `colour_options.materials` and the
       deep-link handler matches `data-fg-colour-material` before it looks
       for the swatch. */
    $colour_colza = $colour_link('composite', 'colza-yellow');

    // The fitters who worked on each job. Each entry links to that person's
    // anchor on Meet the Team, so clicking a name scrolls to their profile.
    // The role must match their job title on Meet the Team.
    $fitter = static function (string $name, string $role, string $image = '', string $image_base = '') use ($team_img): array {
        $person = [
            'name' => $name,
            'role' => $role,
            'url' => home_url('/meet-the-team/#' . sanitize_title($name)),
        ];
        if ($image !== '') {
            $person['image'] = ($image_base !== '' ? $image_base : $team_img) . $image;
        }
        return $person;
    };
    $fitter_tom = $fitter('Tom Carter', 'Installer', 'unnamed-8.jpg');
    $fitter_johnnie = $fitter('Johnnie Greenwell', 'Installer', '1.png');
    $fitter_andy = $fitter('Andy McCullagh', 'Service Engineer', '7.png');
    $fitter_zac = $fitter('Zac Rugman', 'Installer', '8.png');
    $fitter_shane = $fitter('Shane Gowing', 'Installer', '20250617_1628580-scaled.jpg');
    $fitter_aaron = $fitter('Aaron Isaacs', 'Installer', 'aaron-isaacs-cropped-bw.jpg', FENSTER_THEME_URI . '/assets/team/');
    /* Not fitters. Both are named on the Bletchley study, where the people who
       matter are the one who surveyed it and the one who ran it. Roles verified
       against Meet the Team on 2026-08-10 so the anchors and the job titles both
       land: David Foord is Installation Manager, Adam Butcher is Commercial
       Director. That study sets `team_label` accordingly. */
    $surveyor_david = $fitter('David Foord', 'Installation Manager', 'David-Foord.jpg');
    $director_adam = $fitter('Adam Butcher', 'Commercial Director', 'adam-butcher-scaled.jpg');

    $cache = [
        /*
         * Headrow Court is the first Commercial entry in this system; the other
         * commercial studies still sit in the legacy pages.json records. Project
         * facts (108 studios, £12.5m, 16 months, four former office buildings,
         * completed October 2025) are the main contractor's own published figures,
         * and the scope line is deliberately narrow: the main contractor replaced
         * the whole facade, we did the aluminium windows within it. Do not widen
         * that into a claim that we delivered the scheme.
         *
         * THE CONTRACTOR IS NOT NAMED, HERE OR IN THE COPY. Owner rule, 2026-08-10:
         * clients are not named in commercial case studies, because naming the firm
         * that hired us hands a competitor a warm lead. The name was in the overview
         * paragraph and in an image filename; both are gone. See the Commercial
         * Client Anonymity Rule in AI.md before writing any commercial study.
         *
         * Photography is by Ben Harrison Photography, supplied through the main
         * contractor. Credit is kept in the caption because that is an attribution
         * obligation rather than a client name. Confirm the licence covers our own
         * marketing use before this goes to production.
         */
        /*
         * Bletchley rail depot, added 2026-08-10 from the owner's brief and the
         * internal commercial projects deck.
         *
         * THE CLIENT IS NOT NAMED and the CONTRACT VALUE IS NOT PUBLISHED. Both
         * are in the source deck; neither belongs on the website. See the
         * Commercial Client Anonymity Rule in AI.md. We were engaged by the main
         * contractor for the window package, on an existing relationship.
         *
         * Scope is deliberately exact, because it is the thing that goes wrong:
         * 65 windows, 6 doors and 1 curtain wall screen, within a wider depot
         * refurbishment that was not ours. Do not widen it into the refurb.
         *
         * The health and safety material is the substance of this study and it
         * is the contractor's own emphasis, not ours: an operational rail yard,
         * intensive inductions before anyone set foot on the depot, full PPE on
         * and around live rail infrastructure.
         *
         * People confirmed against Meet the Team on 2026-08-10: David Foord is
         * Installation Manager and Adam Butcher is Commercial Director, and the
         * `$fitter` helper slugs those names into real anchors. `team_label` is
         * set because "Installers" would be wrong for a surveyor and a director.
         *
         * SIX PHOTOGRAPHS, all Fenster's own and all at phone resolution. The
         * first version of this study ran a 1600x1200 image lifted out of the
         * deck; that is replaced. The before shot is the same elevation as the
         * hero, which is what makes the pair worth having.
         *
         * THREE FACES ARE BLURRED in the before shot. Depot staff sitting inside
         * and a third party in hi-vis outside, all identifiable at full size and
         * none of them ours. The rust on the mullions, which is the entire point
         * of the photograph, is untouched. A mirrored phone number on a van
         * reflected in the finished elevation was left: it is a company's own
         * advertised number, reversed and tiny at render size.
         */
        /* All Hallows, Bedford, added 2026-08-12 from the owner's brief and his
         * own photographs.
         *
         * THE BUILDING IS NAMED AND THE MAIN CONTRACTOR IS NOT. The brief names
         * them and they are a repeat client, which makes them exactly the
         * poachable warm lead the Commercial Client Anonymity Rule protects.
         * The repeat relationship is stated because it is proof rather than a
         * lead. Heal's is the same case and the worked example.
         *
         * COMPLETION IS KNOWN TO THE MONTH ONLY, so `date_confirmed` is false:
         * the date still orders the study and no day is printed. July 2025 sits
         * in the specification strip, which is where a reader looks for it.
         *
         * PRODUCT NAMES ARE PUBLISHED HERE ON THE OWNER'S RULING, 2026-08-12,
         * which is a deliberate exception to the usual position that a
         * manufacturer is named only where we sell the page around them. These
         * readers are specifiers and STYLE.md already asks commercial pages for
         * the figures a schedule needs. THE MANUFACTURER ATTRIBUTION IS NOT
         * published: the brief says Technal STII and DualFrame 75Si, the owner
         * adds that DualFrame is a Technal product, and DualFrame is published
         * elsewhere as a Senior Architectural Systems range. That was not
         * resolved, so no sentence here says which maker owns which line.
         * Confirm before ever attributing one.
         *
         * NO PERFORMANCE STANDARD IS CLAIMED FOR THE AOVs OR THE DOORSETS. The
         * doorsets are fire rated because the owner says so; no FD rating is
         * printed because none was given. `/automatic-opening-vents/` names no
         * standard either (BS 7346, EN 12101) and the reason is in
         * inc/commercial-product-data.php: this is life safety, and a wrong
         * claim is worse than a missing one. The 1.52m2 geometric free area is
         * attributed to one recorded unit, which is how the brief states it.
         *
         * THE BLACK HARDWARE WRAPPED ON THE HEADS IS THE AOV ACTUATORS, owner
         * confirmed 2026-08-12. Two captions called it protected hardware
         * because nobody had said what it was, and that was the right caution
         * at the time; now it is named. It also means the two works-in-progress
         * photographs are the only ones on the page that show an AOV unit as an
         * AOV, so they are the ones that say so.
         *
         * THREE PHOTOGRAPHS CARRIED REFLECTED FACES and all three are softened:
         * five members of the public reflected in the street screen, and the
         * photographer in the terrace run and in the doorset vision panel. Same
         * treatment as Bletchley, Headrow and Heal's. The first pass blurred
         * them so hard they read as grey discs, which is worse than the
         * reflection; these are feathered and invisible at render size. */
        'all-hallows-bedford' => [
            'title' => 'AOV windows, screens and steel doorsets, All Hallows, Bedford',
            'location' => 'Bedford',
            'type' => 'Commercial',
            'sector' => 'Residential refurbishment',
            'service' => 'Aluminium windows, entrance screens and steel doorsets',
            'sector_url' => home_url('/commercial-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2025-07-01',
            'date_confirmed' => false,
            'summary' => 'Eight automatic opening vent windows, a glazed entrance door and screen, a 3010mm by 3030mm fixed aluminium screen and ten steel doorsets, for the refurbishment of 30 to 34 All Hallows in Bedford.',
            'lead' => 'The refurbishment of 30 to 34 All Hallows turned an existing building over to residential accommodation. Our package was the glazing and the doors within it: eight automatic opening vents forming part of the smoke ventilation strategy, a glazed entrance door and screen, one large fixed aluminium screen and ten steel doorsets.',
            'products' => [
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
                ['label' => 'AOV smoke ventilation', 'url' => home_url('/automatic-opening-vents/')],
                ['label' => 'Commercial windows and doors', 'url' => home_url('/commercial-windows-and-doors/')],
                ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/')],
            ],
            'specs' => [
                ['label' => 'AOV windows', 'value' => '8 aluminium, white'],
                ['label' => 'Fixed screen', 'value' => '3010 x 3030mm, 9 fields'],
                ['label' => 'Doorsets', 'value' => '10 steel, fire rated'],
                ['label' => 'Completed', 'value' => 'July 2025'],
            ],
            'overview' => [
                '30 to 34 All Hallows sits in the middle of Bedford and was refurbished to serve residential accommodation. The wider refurbishment was the main contractor\'s; we were the glazing and doors subcontractor within it. The package was eight white aluminium DualFrame 75Si <a href="' . esc_url(home_url('/automatic-opening-vents/')) . '">automatic opening vent</a> window units, a Technal STII glazed entrance door and screen, one large fixed <a href="' . esc_url(home_url('/aluminium-windows/')) . '">Sheerline Prestige aluminium screen</a>, ten steel doorsets and the specialist glazing that went with them.',
                'The AOVs are the part a specifier will look at first. They form part of the building\'s smoke ventilation strategy, so the opening configuration and the free area each unit had to achieve were coordinated against the design rather than settled on site. One recorded unit achieves an approximate geometric free area of 1.52m². Glazing across the aluminium package is predominantly 28mm double glazed units, laminated and toughened, with a low-E softcoat and argon fill.',
                'The fixed screen is 3010mm by 3030mm and is formed from nine fixed glazed fields. At that size the difficult part is not the specification, it is getting it into the building. Access was restricted, and the larger and heavier items had to be brought in through tight spaces and limited routes, so deliveries and installation sequencing were planned around that. It is the difference between a screen that arrives in one piece and one that arrives damaged.',
                'The other technical requirement was the ten steel doorsets, which are fire rated and had to meet the project specification for that. We were appointed by the main contractor, who we have worked with on other projects. What makes this one worth writing up is the breadth of it: automated aluminium windows, a glazed entrance system, a large fixed screen and specialist steel doors are four different products with four different lead times, and coordinating them is a different job from installing one product a hundred times.',
            ],
            'installed' => [
                '8 white aluminium DualFrame 75Si AOV window units',
                '1 Technal STII glazed entrance door and screen',
                '1 fixed Sheerline Prestige aluminium screen, 3010 x 3030mm in 9 fields',
                '10 steel doorsets, fire rated',
                'Predominantly 28mm laminated and toughened double glazed units, low-E softcoat and argon',
            ],
            /* images[0] is the HERO and the archive card. It was the street
               screen, which proves the nine fields in one frame and is now the
               first gallery cell instead: the owner asked for a stronger lead
               image and the terrace run is the one that carries the job. It is
               also the only landscape source in the set, so it fills the hero
               panel without being cropped to a band. */
            'images' => [
                ['src' => $img . 'cs-all-hallows-bedford-terrace-run.webp', 'caption' => 'The finished run along the terrace elevation, with the opening vents set above the transom.'],
                ['src' => $img . 'cs-all-hallows-bedford-screen.webp', 'caption' => 'The fixed screen from the street. Nine glazed fields in one opening, 3010mm by 3030mm.'],
                ['src' => $img . 'cs-all-hallows-bedford-terrace.webp', 'caption' => 'The terrace elevation finished, with the glazing turning the corner into the entrance door.'],
                ['src' => $img . 'cs-all-hallows-bedford-screen-inside.webp', 'caption' => 'The same glazing from inside, part way through the works, with the AOV actuators still wrapped along the heads.'],
                ['src' => $img . 'cs-all-hallows-bedford-window-inside.webp', 'caption' => 'One of the AOV units from inside, scaffold still up and its actuators still in their wrapping.'],
                ['src' => $img . 'cs-all-hallows-bedford-steel-doorset.webp', 'caption' => 'One of the ten steel doorsets, with vision panels top and bottom and the plate still in its film.'],
                ['src' => $img . 'cs-all-hallows-bedford-doorsets.webp', 'caption' => 'Two more of the doorsets hung and finished, in one of the residential corridors.'],
            ],
            'seo' => [
                'title_tag' => 'All Hallows, Bedford: AOV Windows, Screens and Steel Doorsets',
                'meta_description' => 'A Fenster commercial project: eight AOV windows, a glazed entrance screen, a 3010mm fixed screen and ten steel doorsets at All Hallows, Bedford.',
            ],
        ],
        /* Heal's, Tottenham Court Road, added 2026-08-11.
         *
         * THE BUILDING IS NAMED AND THE CLIENT IS NOT, which is the Commercial
         * Client Anonymity Rule working exactly as written. Heal's is the
         * building and the subject; we were appointed by a main contractor who
         * is a long-standing repeat client, and naming them would hand a
         * competitor a warm lead. "The main contractor" is all the copy needs,
         * and the repeat relationship is worth saying because it is proof.
         *
         * COMPLETION IS KNOWN TO THE MONTH ONLY, so `date_confirmed` is false:
         * the date still orders the study and nothing prints a day we do not
         * have. March 2024 appears in the specification strip instead, which is
         * where a reader looks for it.
         *
         * FOUR FACES ARE BLURRED across two photographs. Two people in the
         * courtyard shot, one of them a third party at the railing, and two
         * more behind the glass in the elevation shot. Same treatment as
         * Bletchley and Headrow.
         *
         * THE PHOTOGRAPHS ARE 1024px, which is under the 1600px the guide asks
         * for, and they are not upscaled. They are what exists of this job.
         *
         * WHAT IS NOT PHOTOGRAPHED: the louvres and the two heritage windows.
         * The scope lists them because we supplied them; no caption claims to
         * show them. Do not caption the toplight over the door as a heritage
         * window without checking, which is the fault the flush aluminium page
         * already paid for. */
        'heals-tottenham-court-road' => [
            'title' => 'Aluminium windows and louvres, Heal\'s, Tottenham Court Road',
            'location' => 'Tottenham Court Road, London',
            'type' => 'Commercial',
            'sector' => 'Retail and offices',
            'service' => 'Aluminium windows, doors and louvres',
            'sector_url' => home_url('/commercial-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2024-03-01',
            'date_confirmed' => false,
            'summary' => 'Sheerline Prestige windows and a door, two heritage windows and six bespoke louvres, fitted into the courtyard elevations of the Heal\'s building during its refurbishment.',
            'lead' => 'The Heal\'s building on Tottenham Court Road was being reworked to put modern offices above the shop. Our part was the courtyard elevations on the first and second floors: a run of aluminium glazing, a door, two heritage windows and six louvres made specially for the openings they went into.',
            /* Retail claim added 2026-08-12: Heal's is a department store, so it
               is the one genuine retail-building study we own and
               /office-and-retail-glazing/ had no proof on it at all. */
            'products' => [
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
                ['label' => 'Office and retail glazing', 'url' => home_url('/office-and-retail-glazing/')],
                ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/')],
                ['label' => 'Heritage windows', 'url' => home_url('/heritage-windows/')],
                ['label' => 'Louvre vents', 'url' => home_url('/louvre-vents/')],
            ],
            'specs' => [
                ['label' => 'Windows', 'value' => '4 Prestige, 2 heritage'],
                ['label' => 'Louvres', 'value' => '6, bespoke'],
                ['label' => 'Finish', 'value' => 'RAL 9005 Jet Black'],
                ['label' => 'Completed', 'value' => 'March 2024'],
            ],
            'overview' => [
                'Heal\'s has stood on Tottenham Court Road since the shop was built around it, and the refurbishment kept the store trading while the floors above became offices. We worked on the courtyard elevations at first and second floor level: four large fixed <a href="' . esc_url(home_url('/aluminium-windows/')) . '">Sheerline Prestige aluminium windows</a>, a single Prestige door, two fixed <a href="' . esc_url(home_url('/heritage-windows/')) . '">heritage aluminium windows</a> and six bespoke <a href="' . esc_url(home_url('/louvre-vents/')) . '">aluminium louvres</a>.',
                'The two heritage windows replaced openings that had been stripped out earlier in the programme, when the building needed a way to get materials and plant inside. That is a common enough sequence on a refurbishment and it leaves you fitting a finished window into an opening that has been working as a doorway for months.',
                'We were appointed through the main contractor, who we have worked with on a long run of projects, and part of what we were asked for was help finalising the design rather than just a price against a drawing. The brief was sleek and contemporary, and the harder half of it was making the new aluminium sit properly against a building that was already there: getting the different finishes and profiles to read as one intention rather than as three separate orders. The windows and door are RAL 9005 Jet Black; the louvres are a golden brown, IGP-HWF Classic 519T.',
                'The work ran in stages across about six months, reached from scaffold the main contractor provided. It was an active construction site throughout and nobody was occupying the floors we were working on, which makes for a straightforward programme by London standards: the constraint was sequence and access rather than working around people.',
            ],
            'installed' => [
                '4 large fixed Sheerline Prestige aluminium windows',
                '1 single Sheerline Prestige aluminium door',
                '2 fixed heritage aluminium windows',
                '6 bespoke aluminium louvres, IGP-HWF Classic 519T Golden Brown',
                'All Prestige frames in RAL 9005 Jet Black',
            ],
            'images' => [
                ['src' => $img . 'cs-heals-tottenham-court-elevation.webp', 'caption' => 'The courtyard elevation glazed, with the fixed Prestige windows in jet black against the existing concrete frame.'],
                ['src' => $img . 'cs-heals-tottenham-court-courtyard.webp', 'caption' => 'The same courtyard partway through, with the openings still bare and the deck being used as the working platform.'],
                ['src' => $img . 'cs-heals-tottenham-court-door.webp', 'caption' => 'The single Prestige door at the end of the run, with a toplight over it.'],
                ['src' => $img . 'cs-heals-tottenham-court-run.webp', 'caption' => 'Looking along the run. The frames follow the existing structural bays rather than cutting across them.'],
                ['src' => $img . 'cs-heals-tottenham-court-looking-up.webp', 'caption' => 'The courtyard from the deck, five floors of the existing building above the new glazing.'],
            ],
            'seo' => [
                'title_tag' => 'Heal\'s, Tottenham Court Road: Commercial Aluminium Glazing',
                'meta_description' => 'A Fenster commercial project: Sheerline Prestige windows and a door, two heritage windows and six bespoke louvres for the refurbishment of the Heal\'s building, Tottenham Court Road.',
            ],
        ],
        'bletchley-rail-depot-refurbishment' => [
            'title' => 'Curtain walling, windows and doors, Bletchley rail depot',
            'location' => 'Bletchley, Milton Keynes',
            'type' => 'Commercial',
            'sector' => 'Rail and logistics',
            'service' => 'Aluminium windows, doors and curtain walling',
            'sector_url' => home_url('/commercial-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2025-09-01',
            'summary' => 'Sixty-five aluminium windows, six doors and a curtain wall screen for the refurbishment of a working rail depot at Bletchley.',
            'lead' => 'A rail depot does not stop for a refurbishment. We supplied and fitted the window, door and curtain walling package across a depot that stayed operational throughout, on a site where getting through the induction takes longer than getting through the first day of work.',
            /* Two claims added 2026-08-12. Both are already in this study's own
               spec rows below — "1 curtain wall" and "65 aluminium windows, 6
               doors" — and neither route was being proved by it, so
               /curtain-walling/ rendered no proof at all while the one job that
               demonstrates it sat here unclaimed. */
            'products' => [
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
                ['label' => 'Curtain walling', 'url' => home_url('/curtain-walling/')],
                ['label' => 'Commercial windows and doors', 'url' => home_url('/commercial-windows-and-doors/')],
                ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/')],
                ['label' => 'Commercial automation', 'url' => home_url('/commercial-automation/')],
            ],
            'specs' => [
                ['label' => 'Windows', 'value' => '65 aluminium'],
                ['label' => 'Doors', 'value' => '6, including automatic entrances'],
                ['label' => 'Screens', 'value' => '1 curtain wall'],
                ['label' => 'Completed', 'value' => 'September 2025'],
            ],
            'overview' => [
                'Bletchley depot was refurbished while it carried on working. Our part was the glazing package: sixty-five <a href="' . esc_url(home_url('/aluminium-windows/')) . '">aluminium windows</a>, six doors and a single curtain wall screen, fitted into a building that had to keep functioning around us. The wider refurbishment was the main contractor\'s; we were brought in for the windows and doors on the back of work we had already done for them.',
                'The doors are the part that varies most. Automatic entrance doors at the two main ways in, fire exit doors where the escape route needed them, and heavy-duty commercial hardware throughout, specified for an industrial building rather than an office. There are fire rated windows in the package as well, and an internal reception screen, which is the sort of thing that never appears in a photograph of a facade but takes as long to get right as anything on the outside.',
                'A rail depot is a strict site, and that is the honest headline of this job. Nobody goes anywhere near it without completing the site induction first, and it is a long one. Full PPE is enforced at all times on and around live rail infrastructure, and every part of the work has to be delivered to the compliance standards a rail environment demands. It changes how you programme a job: access is booked rather than assumed, and the paperwork is part of the build rather than an afterthought.',
                'The finish detail worth mentioning is the flashings. Custom aluminium flashings were powder coated to match the window frames right through the package, so the junctions between new glazing and existing structure read as one thing rather than as a set of patches.',
            ],
            'installed' => [
                '65 aluminium windows across the depot elevations',
                'Automatic entrance doors, fire exit doors and fire rated windows',
                'One curtain wall screen, plus an internal reception screen',
                'Custom aluminium flashings powder coated to match the frames',
            ],
            'team_label' => 'Surveyed and managed by',
            'installers' => [$surveyor_david, $director_adam],
            /* images[0] is the HERO and the rest are the gallery, so the
               finished elevation leads and the before sits first in the gallery
               with a caption that points back at it. The two cannot sit side by
               side because one of them is the hero.

               There WAS a second entrance photograph and it was dropped on
               2026-08-10: it is the same doorset from the ramp, not a second
               entrance, and the caption claimed otherwise. Two angles of one
               door in a gallery this size is repetition, and four gallery images
               also fill two rows exactly where five left a trailing single.
               Check whether two photographs are two THINGS before captioning
               them as such: the CCTV sign, the brick pier and the handrail are
               identical in both. */
            'images' => [
                ['src' => $img . 'cs-bletchley-rail-depot-elevation.webp', 'caption' => 'The finished elevation, with the run of aluminium windows under the new cladding line.'],
                ['src' => $img . 'cs-bletchley-rail-depot-before.webp', 'caption' => 'The same elevation before we started. The old frames had rusted through at the mullions and were staining the sills below them.'],
                ['src' => $img . 'cs-bletchley-rail-depot-entrance.webp', 'caption' => 'One of the automatic entrance doorsets, with fixed sidelights and a screen over.'],
                ['src' => $img . 'cs-bletchley-rail-depot-head-detail.webp', 'caption' => 'The window head against the new cladding line, frames colour-matched through the package.'],
                ['src' => $img . 'cs-bletchley-rail-depot-reception.webp', 'caption' => 'The internal reception screen, with its sliding hatch onto the corridor.'],
            ],
            'seo' => [
                'title_tag' => 'Bletchley Rail Depot: Commercial Windows, Doors and Curtain Walling',
                'meta_description' => 'A Fenster commercial project: 65 aluminium windows, 6 doors and a curtain wall screen for the refurbishment of a working rail depot at Bletchley, completed September 2025.',
            ],
        ],
        'headrow-court-student-accommodation-leeds' => [
            'title' => 'Aluminium windows, Headrow Court, Leeds',
            'location' => 'Leeds city centre',
            'type' => 'Commercial',
            'sector' => 'Student accommodation',
            'service' => 'Aluminium windows',
            'sector_url' => home_url('/student-accommodation-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2025-10-01',
            'summary' => 'Aluminium windows for the conversion of four former office buildings into 108 student studios opposite Leeds Town Hall.',
            'lead' => 'Four tired office buildings in the middle of Leeds became 108 student studios. We supplied and fitted the aluminium windows across the new facade, including the projecting bays that give the building its face on The Headrow.',
            'products' => [
                ['label' => 'Student accommodation glazing', 'url' => home_url('/student-accommodation-glazing/')],
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
            ],
            'specs' => [
                ['label' => 'Building', 'value' => '108 student studios'],
                ['label' => 'Was', 'value' => 'Four former office buildings'],
                ['label' => 'Product', 'value' => 'Aluminium windows'],
                ['label' => 'Completed', 'value' => 'October 2025'],
            ],
            'overview' => [
                'Headrow Court sits opposite Leeds Town Hall, and until recently it was four separate office buildings. The main contractor took the scheme on as a £12.5m, sixteen month conversion into 108 purpose built student studios with reception, study and dining space, finishing in October 2025.',
                'The facade was replaced rather than patched, and our part of that was the <a href="' . esc_url(home_url('/aluminium-windows/')) . '">aluminium windows</a>. On a city centre building of this age that is less about the product and more about the openings: four buildings that were never built to match, brought into one elevation, with the window line expected to read as one thing from the street.',
                'The projecting bays are the part people notice. They wrap the corner of the building in dark framing above the shopfronts, and they are the reason the elevation reads as a single new building rather than four old ones stitched together. Behind them, every studio needed a window that opens safely, keeps street noise down and holds heat in a building now lived in all year rather than occupied nine to five.',
                'The wider scheme connects to the Leeds Pipes district heating network and diverted 98% of its site waste from landfill. That is the contractor\'s achievement rather than ours, but it is the kind of scheme our commercial work tends to sit inside: an existing building kept and upgraded instead of demolished.',
            ],
            'installed' => [
                'Aluminium windows across the replacement facade',
                'Projecting bay windows to the principal elevation',
                'City centre site, four buildings brought into one elevation',
                'Part of a £12.5m conversion into 108 student studios',
            ],
            'images' => [
                ['src' => $img . 'cs-headrow-court-elevation.webp', 'caption' => 'Headrow Court from The Headrow, opposite Leeds Town Hall, after the facade replacement. Photograph by Ben Harrison Photography.'],
                ['src' => $img . 'cs-headrow-court-oriels.webp', 'caption' => 'The projecting bays wrapping the corner above the shopfronts. Photograph by Ben Harrison Photography.'],
                ['src' => $img . 'cs-headrow-court-gables.webp', 'caption' => 'The gabled upper floors, where the window line runs across what were once four separate buildings. Photograph by Ben Harrison Photography.'],
                ['src' => $img . 'cs-headrow-court-bay-detail.webp', 'caption' => 'A closer view of a bay, showing the dark framing against the red brick. Photograph by Ben Harrison Photography.'],
                /* Two of our own, added 2026-08-10, and chosen for what the
                   commissioned set cannot show rather than for being better
                   photographs, which they are not. Ben Harrison's four are
                   finished-building photography: straight verticals, clean
                   light, no clutter. Neither of them shows the job happening or
                   the building at eye level from the pavement.

                   They also reduce this page's dependence on photography whose
                   licence for our own marketing is still unconfirmed, per the
                   note at the top. That note stays until somebody confirms it.

                   ASPECT: this study renders through `.fg-cs-gallery__masonry`,
                   which is two auto-fit columns with `height: auto`, so images
                   keep their own shape and nothing is cropped. Portrait is fine
                   here. It is the OTHER gallery, `.fg-case-gallery__grid`, that
                   crops to fixed landscape cells; the legacy commercial records
                   use that one. Check which component a study renders through
                   before ruling a photograph out on its shape. */
                ['src' => $img . 'cs-headrow-court-bay-lookup.webp', 'caption' => 'A projecting bay from directly beneath it, showing the standing seam cladding and the glazing line above the brick.'],
                ['src' => $img . 'cs-headrow-court-platform.webp', 'caption' => 'Working from a platform with the street closed beneath it. A city centre elevation is reached out of hours, not in the middle of the day.'],
            ],
            'seo' => [
                'title_tag' => 'Headrow Court, Leeds: Student Accommodation Glazing',
                'meta_description' => 'A Fenster commercial project: aluminium windows for the conversion of four former Leeds office buildings into 108 student studios, completed October 2025.',
            ],
        ],
        /*
         * The five studies below were migrated out of the imported pages.json
         * records on 2026-07-28 so all commercial work runs on this system and
         * this format. Facts are carried over from those records rather than
         * rewritten: 37 windows craned into a shell at the Barn Hotel, the
         * dementia setting at Sunrise, the R9 and C70 counts at the Green Man,
         * the colour match on the Kitwood Unit. The old records are left in
         * place; their routes now 301 to /commercial-projects/.
         *
         * Completion months confirmed by the owner on 2026-07-28: Roka Dental
         * October 2022, Herts and Essex April 2023, The Green Man November 2025,
         * Headrow Court October 2025 (from the contractor's announcement). The
         * Barn Hotel and Sunrise are only approximate, so they carry
         * `date_confirmed => false`: the date still orders the archive but the
         * page prints nothing rather than a guessed month. Commercial studies
         * show the month and year only, labelled "Completed".
         */
        'barn-hotel-coventry' => [
            'title' => 'Aluminium windows, The Barn Hotel, Coventry',
            'location' => 'Coventry',
            'type' => 'Commercial',
            'sector' => 'Hospitality',
            'service' => 'Windows and entrance doors',
            'sector_url' => home_url('/hotel-and-hospitality-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2025-05-01',
            /* Owner is not certain of the month, so the page shows no date. */
            'date_confirmed' => false,
            'summary' => '37 aluminium windows and new entrance doors, craned into a hotel that was still a shell with no stairs in it.',
            'lead' => 'We fitted 37 aluminium windows and the entrance doors on this Coventry hotel refurbishment. When we started, the building was a shell with no internal staircases, so the glazing went up by crane.',
            'products' => [
                ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/')],
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
            ],
            'specs' => [
                ['label' => 'Windows', 'value' => '37 aluminium units'],
                ['label' => 'Also fitted', 'value' => 'Commercial entrance doors'],
                ['label' => 'Building', 'value' => 'Stripped to shell'],
                ['label' => 'Access', 'value' => 'Crane lift to first floor'],
            ],
            'overview' => [
                'The hotel had been stripped back to shell condition for redevelopment. Our package was the building envelope: 37 <a href="' . esc_url(home_url('/aluminium-windows/')) . '">aluminium windows</a> to survey dimensions, plus the commercial entrance doors.',
                'The complication was not the glazing, it was getting to it. When we began there were no internal staircases in the building, so there was no way of carrying units to the upper floors. Every first floor unit went up on an industrial crane, and each lift had to be booked into the main contractor\'s programme in advance rather than called for on the day.',
                'Aluminium was specified for the sightlines and the service life, which is what a hotel wants from a window it is not going to touch again for twenty years. The frames were made to measurements taken at survey, so they went into an envelope that was still being finished around them.',
                'Aluminium and modern double glazing also cut the heat loss through the envelope, which on a hotel shows up as steadier room temperatures and lower running costs rather than as a number anyone quotes at you.',
                'Most of our commercial work happens at this stage, months before anyone sees the building. It is rare to get back and photograph the finished thing.',
            ],
            'installed' => [
                '37 aluminium windows to survey dimensions',
                'New commercial entrance doors',
                'Crane lifts sequenced with the main contractor',
                'Fitted from shell stage through to completion',
            ],
            'images' => [
                ['src' => $img . 'cs-barn-hotel-exterior-1400w.webp', 'caption' => 'The Barn Hotel after completion, with the aluminium window line across the timber-clad elevation.'],
                ['src' => $img . 'cs-barn-hotel-entrance.webp', 'caption' => 'The entrance, where the new commercial doors sit under the hotel sign.'],
            ],
            'seo' => [
                'title_tag' => 'Barn Hotel, Coventry: Commercial Window Installation',
                'meta_description' => 'A Fenster commercial project: 37 aluminium windows and entrance doors fitted to a Coventry hotel refurbishment, craned in while the building was still a shell.',
            ],
        ],
        'sunrise-care-home-kettering' => [
            'title' => 'Windows and doors, Sunrise Care Home, Kettering',
            'location' => 'Kettering',
            'type' => 'Commercial',
            'sector' => 'Care homes',
            'service' => 'Windows and doors',
            'sector_url' => home_url('/care-home-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2023-07-01',
            /* Owner has it only as "before July 2023", so the page shows no date. */
            'date_confirmed' => false,
            'summary' => 'Every window and door replaced in a working dementia care home, phased around residents who were in the building throughout.',
            'lead' => 'We replaced all the windows and doors at Sunrise Care Home in Kettering. It is a dementia specific setting, so the specification and the way we worked in the building both had to suit that.',
            'products' => [
                ['label' => 'Care home glazing', 'url' => home_url('/care-home-glazing/')],
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
            ],
            'specs' => [
                ['label' => 'Scope', 'value' => 'All windows and doors'],
                ['label' => 'Setting', 'value' => 'Dementia care, occupied'],
                ['label' => 'Product', 'value' => 'uPVC windows and doors'],
                ['label' => 'Programme', 'value' => 'Phased around residents'],
            ],
            'overview' => [
                'The home was refurbishing while it kept running, and the glazing was part of that. Every existing window and door was replaced to improve thermal performance and security across the building.',
                'A dementia setting changes the brief. Safe opening was specified rather than assumed, and the way our teams worked in the building mattered as much as what we fitted: tools controlled, access controlled, and a calm environment kept for residents who were there the whole time.',
                'The work was phased so the home could carry on operating. That is slower than clearing a floor and working through it, and on an occupied care building it is the only sensible way. See our <a href="' . esc_url(home_url('/care-home-glazing/')) . '">care home glazing</a> page for how we approach these sites.',
            ],
            'installed' => [
                'Full replacement of windows and doors',
                'uPVC systems suited to a care environment',
                'Safe opening specified for a dementia setting',
                'Phased so the home kept operating throughout',
            ],
            'images' => [
                ['src' => $team_img . '668a13f5-3500-420d-8e15-47834268084b.jpg', 'caption' => 'Sunrise Care Home after the window and door replacement.'],
            ],
            'seo' => [
                'title_tag' => 'Sunrise Care Home, Kettering: Window Replacement',
                'meta_description' => 'A Fenster commercial project: all windows and doors replaced at a dementia care home in Kettering, phased around residents living in the building throughout.',
            ],
        ],
        'the-green-man-eversholt' => [
            'title' => 'Period-style windows, The Green Man, Eversholt',
            'location' => 'Eversholt, Bedfordshire',
            'type' => 'Commercial',
            'sector' => 'Hospitality',
            'service' => 'Period-style windows',
            'sector_url' => home_url('/hotel-and-hospitality-glazing/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2025-11-01',
            'summary' => 'Twelve windows in a village pub, mechanically jointed with astragal bars so they read as timber rather than plastic.',
            'lead' => 'The Green Man is a village pub and restaurant near Woburn. We replaced twelve windows across the front and rear, upper and ground floor, in a style that keeps the building looking its age.',
            'products' => [
                ['label' => 'Hotel and hospitality glazing', 'url' => home_url('/hotel-and-hospitality-glazing/')],
                ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/')],
            ],
            'specs' => [
                ['label' => 'Windows', 'value' => '6 Residence R9'],
                ['label' => 'Bay', 'value' => '1 three-part, R9'],
                ['label' => 'Flush casements', 'value' => '5 in white woodgrain C70'],
                ['label' => 'Detail', 'value' => 'Astragal bars, monkey tail handles'],
            ],
            'overview' => [
                'The brief was the one every period building gives you: better performance without the building looking like it has had modern windows put in. On a pub with an 1835 datestone, getting that wrong is obvious from the street.',
                'We fitted six Residence R9 windows, a three part R9 bay, and five white woodgrain C70 <a href="' . esc_url(home_url('/flush-casement-windows/')) . '">flush casements</a>. All of them are mechanically jointed rather than welded, which is what gives the frame a timber style corner instead of a rounded plastic one, and all carry astragal bars and black monkey tail handles.',
                'The work covered the front and rear elevations, upper and ground floors, on a venue that was still trading. It was commissioned by Simon, the pub\'s owner, who we had already worked with at Water End Barn, so the programme was agreed rather than negotiated.',
                'For a pub the practical gains matter as much as the look. The new units cut draughts and hold heat, which is the difference between a bar you can seat people in through winter and one where the window tables go unused. Low maintenance frames and modern locking also mean less to deal with on a building that is open seven days a week.',
            ],
            'installed' => [
                'Six Residence R9 windows',
                'One three part bay window in Residence R9',
                'Five white woodgrain C70 flush casements',
                'Mechanically jointed, with astragal bars and monkey tail handles',
            ],
            'images' => [
                ['src' => $img . 'cs-green-man-front-bay.webp', 'caption' => 'The front elevation, with the three part Residence R9 bay to the right of the entrance.'],
                ['src' => $team_img . '3-1-3.png', 'caption' => 'The pub from the road, showing the astragal bars and the white woodgrain finish against the brick.'],
                ['src' => $img . 'cs-green-man-frontage.webp', 'caption' => 'The frontage as customers see it, with the bay and the ground floor windows replaced.'],
                ['src' => $img . 'cs-green-man-rear.webp', 'caption' => 'The rear elevation, where the upper floor windows were replaced alongside the front.'],
                ['src' => $img . 'cs-green-man-side.webp', 'caption' => 'The side and rear of the building, showing the full run of replacement windows.'],
            ],
            'seo' => [
                'title_tag' => 'The Green Man, Eversholt: Period Pub Window Replacement',
                'meta_description' => 'A Fenster commercial project: twelve period-style uPVC windows fitted to a trading village pub near Woburn, mechanically jointed with astragal bars.',
            ],
        ],
        'roka-dental-woburn-sands' => [
            'title' => 'Entrance doors, Roka Dental, Woburn Sands',
            'location' => 'Woburn Sands',
            'type' => 'Commercial',
            'sector' => 'Healthcare',
            'service' => 'Entrance doors',
            'sector_url' => home_url('/healthcare-construction/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2022-10-01',
            'summary' => 'Aluminium and uPVC doors for a new dental practice, specified around the brand rather than the catalogue.',
            'lead' => 'Roka Dental were opening new premises in Woburn Sands. We supplied and fitted the external doors, chosen to match the way the practice presents itself.',
            'products' => [
                ['label' => 'Healthcare glazing', 'url' => home_url('/healthcare-construction/')],
                ['label' => 'Commercial glazing', 'url' => home_url('/commercial-glazing/')],
            ],
            'specs' => [
                ['label' => 'Scope', 'value' => 'External doors'],
                ['label' => 'Materials', 'value' => 'Aluminium and uPVC'],
                ['label' => 'Setting', 'value' => 'New dental practice'],
                ['label' => 'Driver', 'value' => 'Brand and daily use'],
            ],
            'overview' => [
                'A new practice gets one first impression, and on a high street unit the door is most of it. The brief was doors that matched the practice\'s branding and stood up to the traffic a clinical building gets every day.',
                'We used a combination of aluminium and uPVC systems, chosen for proportion and finish rather than picked off a list, so the entrance reads as part of the building rather than a replacement part. The work was done by our own installers to a fixed date, because the practice had an opening to hit.',
            ],
            'installed' => [
                'Aluminium and uPVC external doors',
                'Finishes matched to the practice branding',
                'Fitted by our own installation teams',
                'Completed to the practice opening date',
            ],
            'images' => [
                ['src' => $team_img . 'dental-practice-glazing.jpg', 'caption' => 'Roka Dental, Woburn Sands, after the doors were fitted.'],
            ],
            'seo' => [
                'title_tag' => 'Roka Dental, Woburn Sands: Commercial Door Replacement',
                'meta_description' => 'A Fenster commercial project: aluminium and uPVC entrance doors for a new dental practice in Woburn Sands, matched to the practice branding.',
            ],
        ],
        'herts-and-essex-community-hospital' => [
            'title' => 'Aluminium windows, Herts and Essex Community Hospital',
            'location' => 'Bishop\'s Stortford',
            'type' => 'Commercial',
            'sector' => 'Healthcare',
            'service' => 'Aluminium windows and doors',
            'sector_url' => home_url('/healthcare-construction/'),
            'service_url' => home_url('/commercial-windows-and-doors/'),
            'date' => '2023-04-01',
            'summary' => 'Colour-matched aluminium windows and doors for the Kitwood Unit, fitted in a working hospital without interrupting it.',
            'lead' => 'The Kitwood Unit is the newest part of Herts and Essex Community Hospital. We supplied and fitted the aluminium windows and doors, matched to what was already on the estate.',
            'products' => [
                ['label' => 'Healthcare glazing', 'url' => home_url('/healthcare-construction/')],
                ['label' => 'Aluminium windows', 'url' => home_url('/aluminium-windows/')],
            ],
            'specs' => [
                ['label' => 'Building', 'value' => 'Kitwood Unit'],
                ['label' => 'Product', 'value' => 'Aluminium windows and doors'],
                ['label' => 'Requirement', 'value' => 'Colour and profile match'],
                ['label' => 'Site', 'value' => 'Live clinical environment'],
            ],
            'overview' => [
                'The requirement was like for like. A new unit that meets existing hospital buildings has to look like it belongs to them, so the <a href="' . esc_url(home_url('/aluminium-windows/')) . '">aluminium windows</a> and doors were matched on both colour and profile rather than simply specified to performance.',
                'The bigger constraint was the site. A hospital does not stop, so the works ran to approved RAMS and site specific protocols, phased so patient care, staff access and hospital services carried on around us. That is normal for <a href="' . esc_url(home_url('/healthcare-construction/')) . '">healthcare work</a> and it is the part that decides the programme.',
            ],
            'installed' => [
                'Aluminium windows and doors to the Kitwood Unit',
                'Colour and profile matched to the existing estate',
                'Approved RAMS and site specific protocols',
                'Phased around live clinical services',
            ],
            'images' => [
                ['src' => $team_img . 'fe2513f8-d557-4972-bb3f-bc0cc6a9d5f3.jpg', 'caption' => 'The Kitwood Unit at Herts and Essex Community Hospital after the glazing works.'],
            ],
            'seo' => [
                'title_tag' => 'Herts & Essex Community Hospital: Aluminium Glazing',
                'meta_description' => 'A Fenster commercial project: colour-matched aluminium windows and doors for the Kitwood Unit, fitted around live clinical services.',
            ],
        ],
        /* The first study on the site whose photographs and words are the
           customer's own. They documented the whole install themselves and
           posted it, and gave us permission to republish it here (owner
           confirmed, 2026-08-25). That is what the `story` field renders: their
           sequence, their line under each photograph, credited and linked back.

           Do NOT quietly reword the `story` quotes. They are somebody else's
           writing, tidied only for emoji and the site's no-em-dash rule, and
           "@fensterglazing" reads as "Fenster" because this is Fenster's own
           site. Everything else in them is theirs.

           The style is the Distinction Rustic Renown shape, boarded inside a
           plain border with a diamond light, matched against the catalogue in
           generated-page.php rather than guessed. The RR03 product code is
           deliberately not printed: the slab geometry is certain from the
           photographs, the code is not. */
        'composite-front-door-milton-keynes' => [
            'title' => 'Composite front door and sidelight, Milton Keynes',
            'location' => 'Milton Keynes',
            'type' => 'Residential',
            'date' => '2026-08-20',
            'summary' => 'An anthracite grey composite front door and a full height sidelight, replacing a white uPVC door and a side panel boarded across its bottom half.',
            'lead' => 'The widest door leaf we do, and a sidelight glazed the full height of the opening. Both decisions were about the same thing: getting daylight down the hallway.',
            'products' => [
                ['label' => 'Composite doors', 'url' => home_url('/composite-doors/')],
            ],
            'colour' => ['label' => 'Anthracite grey', 'url' => $colour_link('composite', 'anthracite-grey')],
            'specs' => [
                ['label' => 'Product', 'value' => 'One composite front door with a sidelight'],
                ['label' => 'Slab', 'value' => 'Distinction Rustic Renown, 44.5mm insulated'],
                ['label' => 'Colour', 'value' => 'Anthracite grey outside, white inside'],
                ['label' => 'Glass', 'value' => 'Diamond light in the slab, obscured sidelight'],
            ],
            'overview' => [
                'The door that came out was white uPVC: four panels under a sunburst arch, a brass letterplate, a brass lever, and a narrow side panel that was glazed at the top and boarded across the bottom half. It had done its years. What went in is a <a href="' . esc_url(home_url('/composite-doors/')) . '">composite door</a> on the Distinction Rustic Renown shape, tongue and groove boards framed by a plain border, with a diamond light set into the upper half of the slab.',
                'Beside it is a sidelight glazed from head to threshold rather than half of one. That, and the widest leaf we do, are the two things the customer asked for, and both were for the same reason: this is a narrow hallway with a corridor running off the back of it, and the old side panel was giving up its lower half to a solid board. The new one does not, so the daylight reaches the floor.',
                'The slab is 44.5mm and insulated, where a typical uPVC door panel is 28mm. It is a compression moulded glass reinforced polyester skin over a foam filled core, with water resistant polymer edges and engineered wood stiles behind it, so it cannot drink rainwater and bow the way a solid timber core can. On Distinction\'s independent testing at the University of Salford\'s Energy House it came out 50% more thermally efficient than a solid timber core door.',
                'Every Distinction door we hang carries AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock, and the slabs are accredited by Secured by Design, the police backed standard. Behind that sits a £5,000 security guarantee, terms applying, and we go through them before you order rather than after.',
                'The colour is <a href="' . $colour_link('composite', 'anthracite-grey') . '">anthracite grey</a> outside and white inside, which is why it reads as two different doors depending on which side of it you are standing. Outside it is dark against yellow brick, with a black lever, a black letterplate and black hinges. Inside it is white, because a dark slab in a hallway this narrow would take back the light the sidelight was widened to let in.',
            ],
            'installed' => [
                'One Distinction composite front door, Rustic Renown shape',
                'Full height glazed sidelight beside it',
                'Diamond light in the slab, obscured glass in the sidelight',
                'Anthracite grey outside, white inside, with black hardware',
                'New cill, with the old door and frame taken out to brick',
            ],
            'installers' => [$fitter_shane, $fitter_andy],
            'story' => [
                'title' => 'The customer photographed the whole day.',
                'intro' => 'They picked up the keys to the house and went abroad for a month, so they were not there to watch it happen. This is their record of it, in the order they posted it.',
                'source' => [
                    'label' => 'The Renovation Files',
                    'url' => 'https://www.instagram.com/p/DcQ_VsNoCYA/',
                ],
                'steps' => [
                    /* No quote on this one and none invented: it is cut from the
                       before half of their own before-and-after card, which
                       carried no line of its own. Our words, and they read as
                       ours because the caption renders a note rather than a
                       quote when `quote` is absent. */
                    [
                        'src' => $img . 'cs-mk-composite-door-before.jpg',
                        'caption' => 'Before: the white uPVC door, four panels under a sunburst arch, with a brass letterplate and a side panel boarded across its bottom half.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-delivered.jpg',
                        'quote' => 'The door I designed with Fenster. Design, order and fit was a smooth process and only a few weeks from start to finish!',
                        'caption' => 'The new door off the van, anthracite grey face out, with the diamond light and the black letterplate already in it.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-inside-face.jpg',
                        'quote' => 'The inside of the door, keeping it nice and bright inside the hallway.',
                        'caption' => 'The other face of the same leaf, white, still wrapped, carried between the two fitters.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-old-frame-out.jpg',
                        'quote' => 'Old door and framework being removed.',
                        'caption' => 'The old frame coming out, seen from the hallway with dust sheets down over the floor.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-opening.jpg',
                        'quote' => 'Big hole in the front of my house!',
                        'caption' => 'The opening stripped back to brick and lintel, with the van on the drive through it.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-cill.jpg',
                        'quote' => 'New sill going in. The front doorstep and porch will be going, but only when I\'ve saved up some money!',
                        'caption' => 'The new cill set down across the quarry tiled step, levelled before anything went on top of it.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-hung.jpg',
                        'quote' => 'New door going in. Great fit!',
                        'caption' => 'The white face of the door hung in the opening, with the lever and cylinder going on.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-sidelight.jpg',
                        'quote' => 'I went for the widest door they did, and a full height side panel to maximise light coming into the hallway and down the corridor.',
                        'caption' => 'Door and sidelight together from inside, the sidelight glazed the full height of the opening in obscured glass.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-open-outside.jpg',
                        'caption' => 'From the front step with the door open, looking down the hallway to the stairs. That is the corridor the sidelight was widened for.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-open-inside.jpg',
                        'quote' => 'Anthracite grey on the outside. Looks smart!',
                        'caption' => 'The anthracite face of the leaf from inside, hung on its hinges with the frame being trimmed in around it.',
                    ],
                    [
                        'src' => $img . 'cs-mk-composite-door-finished.jpg',
                        'quote' => 'Loving the look of it!',
                        'caption' => 'The finished doorset closed, anthracite grey against yellow brick, with the sidelight beside it and the diamond light in the slab.',
                    ],
                ],
            ],
            'review' => [
                'quote' => 'Picking up the keys to my big renovation project house right before being abroad for a month was not great timing. But Fenster did a cracking job today and I can\'t wait to get home to see it in the flesh. So smart!',
                'author' => 'The Renovation Files, on Instagram',
            ],
            /* One image only, so the masonry does not render. The story rail
               already carries all eleven photographs in the order the customer
               told it, and repeating them underneath with captions we wrote
               would be the same job done twice and worse the second time. */
            'images' => [
                ['src' => $img . 'cs-mk-composite-door-finished.jpg', 'caption' => 'The finished composite front door and sidelight, anthracite grey against yellow brick.'],
            ],
            /* Every photograph on this job is portrait 4:5 and the archive card
               is 16:10, so a centre crop of the hero would be a band of boarded
               slab and no doorset. This is cut from the full resolution original
               and keeps the diamond light, the lever, the letterplate and the
               sidelight beside them. */
            'card_image' => ['src' => $img . 'cs-mk-composite-door-card.jpg', 'caption' => 'An anthracite grey composite front door with a diamond light and a full height sidelight, in Milton Keynes.'],
            'seo' => [
                'title_tag' => 'Composite Front Door Case Study, Milton Keynes | Fenster Glazing',
                /* 154 characters against a 160 cap. */
                'meta_description' => 'A real Fenster project in Milton Keynes: an anthracite grey composite front door and a full height sidelight, photographed through the day by the customer.',
            ],
        ],

        'aluminium-bifold-doors-whitehouse-milton-keynes' => [
            'title' => 'Aluminium bifold doors, Whitehouse',
            'location' => 'Whitehouse, Milton Keynes',
            'type' => 'Residential',
            'date' => '2026-07-09',
            'summary' => 'Slim anthracite grey aluminium bifold doors opening the back of a Whitehouse home out to the garden.',
            'lead' => 'We opened up the back of this Whitehouse home with a run of slim aluminium bifold doors in anthracite grey, folding the whole opening back to the garden.',
            'products' => [
                ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/')],
            ],
            'colour' => ['label' => 'Anthracite grey', 'url' => $colour_anthracite],
            'specs' => [
                ['label' => 'Product', 'value' => 'Aluminium bifold doors'],
                ['label' => 'System', 'value' => 'Sheerline Prestige aluminium'],
                ['label' => 'Colour', 'value' => 'Anthracite grey, inside and out'],
                ['label' => 'U-value', 'value' => '1.0 W/m²K'],
            ],
            'overview' => [
                'The owners wanted to open the back of the house right up to the garden, without losing warmth or security once the doors were shut. We fitted <a href="' . $bifold . '">aluminium bifold doors</a> from the Sheerline Prestige system, which uses thermally broken aluminium frames with ultra slim sightlines, so almost all of the opening is glass rather than frame.',
                'The doors fold back against the wall to leave a clear span, with a main traffic door for everyday garden access without opening the full run. A low threshold keeps the step between inside and out to a minimum. Closed, the frames reach a 1.0 W/m²K U-value and lock at several points, so the room stays warm and secure through winter.',
                'We finished the frames in <a href="' . $colour_anthracite . '">anthracite grey</a> inside and out, one of the most popular choices for a modern look that sits well against both brick and render. Sheerline aluminium can be powder coated in any RAL colour if a different shade suits the property.',
            ],
            'installed' => [
                'Sheerline Prestige aluminium bifold doors',
                'Anthracite grey finish, inside and out',
                'Slim sightlines with a low threshold',
                'Double glazed, multi-point locking with a main traffic door',
            ],
            'installers' => [$fitter_johnnie, $fitter_tom],
            'review' => [
                'quote' => 'We are over the moon with the doors! They are excellent! What a difference it has made to our kitchen space! The two lads, <a href="' . $team . '">Tom</a> and <a href="' . $team . '">Johnnie</a>, who came to install were exceptional. Professional, tidy, and the speed they got it installed was mind blowing to us. Thank you to you and your whole team!',
                'author' => 'Conor and Laura',
            ],
            'images' => [
                ['src' => $img . 'cs-mk-whitehouse-bifold-closed.jpg', 'caption' => 'The bifold doors closed, seen from the garden, with the anthracite grey frames sitting neatly to the patio.'],
                ['src' => $img . 'cs-mk-whitehouse-bifold-open.jpg', 'caption' => 'Folded fully back, the doors clear the whole opening between the house and garden.'],
                ['src' => $img . 'cs-mk-whitehouse-bifold-half-open.jpg', 'caption' => 'Part way through folding, showing how the slim panels stack neatly to one side.'],
            ],
            'seo' => [
                'title_tag' => 'Aluminium Bifold Doors Case Study, Milton Keynes | Fenster Glazing',
                'meta_description' => 'A real Fenster project: slim anthracite grey aluminium bifold doors fitted to a home in Whitehouse, Milton Keynes, opening the room out to the garden.',
            ],
        ],

        /*
         * The only study on the site where the blind is the product. Two things
         * are deliberately absent and should stay absent unless the owner
         * confirms them. There is no frame system named: Fenster's uPVC casement
         * is Liniar EnergyPlus, but nothing in the supplied photography proves
         * this window is, and naming it would be a guess. There is no U-value or
         * energy rating either: a Notan blind lives in an NTB 24/28 cavity, so
         * the 0.95 W/m²K figure the other casement studies quote for a 36mm
         * triple unit does not describe this glass and must not be carried over.
         *
         * No slat width is printed, per the Notan Integral Blind Rule in AI.md.
         * The slat colour is White BY001 from `notan_blind_colours`, and the
         * control description matches the visualiser on /integral-blinds/: the
         * top magnet tilts, the bottom one raises and lowers.
         *
         * Owner-confirmed 2026-08-04: a new window rather than a replacement
         * sealed unit into an existing frame, and priced at a home consultation.
         */
        /*
         * Winslow, and the first secondary glazing study on the site. It closes
         * a gap PHOTO-CHECKLIST.md has carried since July: "Secondary glazing,
         * still open. No genuine product image." It is also the first study to
         * claim /secondary-glazing/, which until now was running
         * `fenster_case_studies_for_product()`'s all-studies fallback and
         * showing three unrelated jobs under "Real installs".
         *
         * Owner-confirmed 2026-08-07: the building is LISTED, which is why the
         * original windows stay and is the reason this job exists. It was first
         * offered as "i think its conservation" and then confirmed as listed, so
         * the copy states listed and nothing else. Nothing here says anything
         * about consent or permissions: that is not ours to state.
         *
         * NO U-VALUE, and none may be added. The starred "From 1.8 W/m²K" came
         * off `product_usps['secondary-glazing']` on 2026-08-05 by owner
         * instruction, because a secondary glazed figure depends entirely on the
         * existing window it is fitted inside, so no single number is true of a
         * job.
         *
         * NO `colour` DEEP LINK, deliberately. Secondary glazing has its own
         * colour range, owner-confirmed the same day: white, brown or any RAL.
         * It is NOT the twelve powder-coated finishes on the aluminium window
         * and door routes, which is why /secondary-glazing/ is correctly absent
         * from `$aluminium_colour_routes`. Linking the colour hub here would
         * send people to the wrong swatches, so the frame colour is stated in
         * the specs as plain text.
         *
         * Owner correction on the copy, worth keeping: an earlier draft said a
         * horizontal slider is "the one to fit when the window behind still has
         * to work". That is wrong. Every style except fixed leaves the original
         * window reachable, so it described secondary glazing generally while
         * selling it as particular to the slider. What actually separates a
         * horizontal slider is that it moves sideways and needs no swing space.
         *
         * Six units, five sliders and one lift-out, but only FIVE photographs:
         * two of the six supplied files are pixel-identical, checked by hashing
         * a 64x64 reduction rather than by comparing filenames.
         *
         * `card_image` exists because every photograph is portrait and the
         * archive card is 16/10. It is cut from the 3840x5120 original rather
         * than from the 1600px derivative, the same way Leagrave, Bolbeck Park
         * and Wolverton do it, and the band is chosen to keep the window head
         * and the open casement rather than a strip of wall.
         */
        'secondary-glazing-winslow' => [
            'title' => 'Secondary glazing, Winslow',
            'location' => 'Winslow, Buckinghamshire',
            'type' => 'Residential',
            'date' => '2026-07-21',
            'priced_by' => 'consultation',
            'summary' => 'Six secondary glazing units in a listed Winslow home, five horizontal sliders and one lift-out, fitted inside the original windows in white aluminium.',
            'lead' => 'The house is listed, so the original windows were always staying. We glazed them a second time from the inside instead: six units in slim white aluminium, sitting behind windows that were not touched.',
            'products' => [
                ['label' => 'Secondary glazing', 'url' => $secondary],
            ],
            'specs' => [
                ['label' => 'Product', 'value' => 'Six secondary glazing units'],
                ['label' => 'Styles', 'value' => 'Five horizontal sliders, one lift-out'],
                ['label' => 'Frame', 'value' => 'White slim aluminium'],
                ['label' => 'Original windows', 'value' => 'Kept in place'],
            ],
            'overview' => [
                'On a listed building the windows are part of what is listed, so replacing them was never the job. <a href="' . $secondary . '">Secondary glazing</a> is the other answer: a second window fitted on the inside of the one already there. Nothing came out, nothing was altered, and from the street the house looks exactly as it did. Six openings were done.',
                'Five of them are horizontal sliders. The panes run sideways past each other on a track, so nothing swings out into the room and nothing needs clear space in front of it, which matters where a window sits behind a deep sill, a radiator or furniture. The sixth is a lift-out unit, a single pane held in its frame that comes out in your hands, for an opening that only needs reaching occasionally.',
                'The frames are slim white aluminium and sit inside the reveal, which is what stops a second window reading as a second window. White was the choice here. Brown is the other standard colour, and any RAL can be matched if a frame needs to disappear into a darker reveal or pick up something already in the room.',
            ],
            'installed' => [
                'Five horizontal sliding secondary glazing units',
                'One lift-out secondary glazing unit',
                'White slim aluminium frames throughout',
            ],
            'installers' => [$fitter_shane, $fitter_zac],
            /* MUST be an array. `fenster_case_study_card()` tests
               `is_array($study['card_image'])` and silently falls back to
               images[0] otherwise, which on an all-portrait study is the exact
               centre-cropped band of wall this key exists to prevent. Written as
               a bare string first and it failed without a word. */
            'card_image' => ['src' => $img . 'cs-winslow-secondary-glazing-card.jpg', 'caption' => 'Secondary glazing closed across a leaded window, with the original casement open behind it.'],
            'images' => [
                ['src' => $img . 'cs-winslow-secondary-glazing-open.jpg', 'caption' => 'The secondary glazing closed across the opening, with the original leaded casement standing open behind it.'],
                ['src' => $img . 'cs-winslow-secondary-glazing-bedroom-open.jpg', 'caption' => 'A bedroom window, the original casement swung open behind the glazing and the slider closed in front of it.'],
                ['src' => $img . 'cs-winslow-secondary-glazing-kitchen.jpg', 'caption' => 'The kitchen window, glazed across the full opening above the worktop.'],
                ['src' => $img . 'cs-winslow-secondary-glazing-narrow.jpg', 'caption' => 'A narrow opening with its original timber sill left alone, the glazing sitting back inside the reveal.'],
                ['src' => $img . 'cs-winslow-secondary-glazing-catch.jpg', 'caption' => 'The catch on one of the sliders, with the original leaded light immediately behind it.'],
            ],
            'seo' => [
                'title_tag' => 'Secondary Glazing, Winslow | Fenster Glazing',
                /* 155 characters. The cap is 160 and
                   `fenster_trim_meta_description()` is a regression guard, not a
                   licence to run over: a trailing ellipsis is not finished SEO
                   copy. */
                'meta_description' => 'Secondary glazing in a listed Winslow home, July 2026. Six units inside the original windows: five horizontal sliders and one lift-out, in white aluminium.',
            ],
        ],

        /* Little Horwood, added 2026-08-11 from two photographs and a drone
         * video the owner supplied.
         *
         * FRONT ELEVATION ONLY, owner-confirmed. The copy says so and claims
         * nothing about the rear, because nothing photographed is the rear: the
         * drone piece orbits the front and both stills are taken off the drive.
         * There is also a white uPVC window still in the recess beside the
         * porch, visible in the frontage shot and in the video, which is why
         * "every window" would have been wrong even about the front.
         *
         * NO WINDOW COUNT. The elevation steps back twice and the porch hides
         * part of it, so the openings cannot be counted honestly off these
         * photographs. Bolbeck Park and both Leighton Buzzard studies carry no
         * count either, so this is the archive's normal rather than a gap.
         *
         * SYSTEM IS "Liniar 70mm flush sash", not EnergyPlus. The owner's own
         * note said "liniar energy plus", and EnergyPlus is the 70mm casement
         * system: site-data.php attaches it to /casement-windows/ and never to
         * the flush route, whose figures are 1.2 W/m²K double, A+, 35 dB, and
         * 28mm IGU only with no triple option. The two existing flush studies,
         * Wolverton and Leighton Buzzard, both say flush sash. Carrying 0.95
         * over from a casement study would be the exact fault the guide warns
         * about.
         *
         * NO LOCKING CLAIM ON THE WINDOWS. The casement route publishes a PAS
         * 24 option; the flush route does not, and neither existing flush study
         * claims one. NO U-VALUE ON THE DOOR either, per the composite doors
         * page, which refuses to print one before a doorset is specified.
         *
         * THE NUMBER PLATE IS BLURRED in the street shot. It is a private plate
         * on the customer's own drive and it was legible at full size. Same
         * treatment as the 2019 before/after pairs; see PHOTO-CHECKLIST.md. The
         * same car appears side-on in the frontage shot with no plate showing,
         * so that one is untouched. Neither source file carried EXIF.
         *
         * The plantation shutters are the owners' and are said to be, the way
         * Wolverton says the render and the landscaping were not ours.
         */
        'flush-casement-windows-and-composite-door-little-horwood' => [
            'title' => 'Flush casement windows and a composite door, Little Horwood',
            'location' => 'Little Horwood, Buckinghamshire',
            'type' => 'Residential',
            'date' => '2026-06-24',
            'summary' => 'Agate grey flush casement windows and a matching composite front door across the front of a rendered village cottage in Little Horwood.',
            'lead' => 'We did the front of this Little Horwood cottage in one colour. Agate grey flush casement windows across both floors, and a composite front door in the porch finished to match them.',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => $flush],
                ['label' => 'Composite doors', 'url' => home_url('/composite-doors/')],
            ],
            'colour' => ['label' => 'Agate grey (RAL 7038)', 'url' => $colour_agate],
            'specs' => [
                ['label' => 'Products', 'value' => 'Flush casement windows and a composite door'],
                ['label' => 'System', 'value' => 'Liniar 70mm flush sash uPVC'],
                ['label' => 'Colour', 'value' => 'Agate grey (RAL 7038)'],
                ['label' => 'Energy rating', 'value' => 'A+ (1.2 W/m²K)'],
            ],
            'overview' => [
                'The house is a rendered cottage on a village lane, with red brick heads over the openings and a small tiled porch on the front. We fitted <a href="' . $flush . '">flush casement windows</a> across that elevation on the Liniar 70mm flush sash system, where the sash closes level with the outer frame instead of standing proud of it. On a building of this age the flat face is most of the point. It is how timber windows were made, and it is what stops a replacement window announcing itself from the lane.',
                'The system is A+ rated and reaches 1.2 W/m²K with a 28mm double glazed unit, and Liniar publish 35 dB of sound reduction for it. The main windows open on side hinges, and there are trickle vents in the heads, so a room can be aired without a window standing open on a village road.',
                'The front door is a <a href="' . esc_url(home_url('/composite-doors/')) . '">composite door</a> in the same colour, set back in the brick porch with a full height glazed sidelight on each side. The slab itself is boarded rather than glazed, with a long bar handle and a letterplate, so the daylight comes through the sidelights and the door stays solid. We fit Distinction doors, whose slabs are accredited by Secured by Design, and every composite door we fit carries a £5,000 security guarantee.',
                'The colour is <a href="' . $colour_agate . '">agate grey</a>, RAL 7038, which is a soft green grey rather than a cold one. Against cream render and red brick it settles instead of cutting across them, which is what a dark anthracite would have done here. The windows carry it as a Liniar foil and the door is finished to match, so the front reads as one decision rather than two orders placed in the same month.',
                'The plantation shutters behind the glass are the owners\' own and were already there. We did the windows and the door.',
            ],
            'installed' => [
                'Liniar 70mm flush sash windows across the front elevation',
                /* Not "side hung openers": the small window over the porch is
                   not one, so the bullet was claiming of every opening what is
                   only true of the big ones. The overview says "the main
                   windows" for the same reason. */
                'Agate grey (RAL 7038) foil, with trickle vents in the frame heads',
                'One composite front door, finished to match the windows',
                'Boarded door slab, long bar handle, letterplate and a glazed sidelight each side',
                'A+ rated, 28mm double glazed',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-little-horwood-flush.mp4',
                'poster' => $img . 'cs-little-horwood-flush-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the finished agate grey flush casement windows and composite front door at the Little Horwood cottage',
            ],
            /* Four images and only two source photographs. The door and the open
               window are cut from the 5120x3840 frontage original rather than
               from its 1600px derivative, which is the same move `card_image`
               already makes elsewhere in this file and gives a genuine detail
               shot at full quality. Stills off the video were tried first and
               dropped: the drone is moving in all of them, and the one through
               the open door looks into the customer's hall. */
            'images' => [
                ['src' => $img . 'cs-little-horwood-flush-frontage.jpg', 'caption' => 'The front of the house finished, with the porch at the centre and the flush casements either side of it.'],
                ['src' => $img . 'cs-little-horwood-flush-window-open.jpg', 'caption' => 'One of the three pane windows upstairs with the right hand sash open. The closed sashes finish level with the outer frame.'],
                ['src' => $img . 'cs-little-horwood-composite-door.jpg', 'caption' => 'The composite front door in the brick porch, boarded rather than glazed, with a sidelight each side and a long bar handle.'],
                ['src' => $img . 'cs-little-horwood-flush-street.jpg', 'caption' => 'The house from the drive, where the agate grey sits against the cream render and the red brick heads.'],
            ],
            'card_image' => ['src' => $img . 'cs-little-horwood-flush-card.jpg', 'caption' => 'Agate grey flush casement windows and a matching composite front door on a rendered Little Horwood cottage.'],
            'seo' => [
                'title_tag' => 'Flush Casement Windows and a Composite Door, Little Horwood | Fenster Glazing',
                /* 147 characters against a 160 cap. */
                'meta_description' => 'A real Fenster project in Little Horwood: agate grey Liniar flush casement windows and a matching composite front door on a rendered village cottage.',
            ],
        ],

        'integral-blinds-leagrave-luton' => [
            'title' => 'uPVC window with integral blinds, Leagrave',
            'location' => 'Leagrave, Luton',
            'type' => 'Residential',
            'date' => '2026-06-23',
            'priced_by' => 'consultation',
            'summary' => 'One uPVC casement window in a Leagrave bathroom, with a white Notan blind sealed inside the glass and worked by two magnets on the frame.',
            'lead' => 'This is a small bathroom window in Leagrave, and the blind is inside the glass rather than in front of it. Obscure glass takes the view away through the day, and the blind is the part you can turn up and down.',
            'products' => [
                ['label' => 'Integral blinds', 'url' => home_url('/integral-blinds/')],
                ['label' => 'uPVC casement windows', 'url' => $casement],
            ],
            'colour' => ['label' => 'White', 'url' => $colour_white],
            'specs' => [
                ['label' => 'Product', 'value' => 'One uPVC casement window'],
                ['label' => 'Blind', 'value' => 'Notan magnetic integrated blind'],
                ['label' => 'Control', 'value' => 'Magnetic, tilt and lift'],
                ['label' => 'Slat colour', 'value' => 'White (BY001)'],
            ],
            'overview' => [
                'We fitted the window and the blind as one thing. It is one <a href="' . $casement . '">uPVC casement window</a> with a Notan <a href="' . esc_url(home_url('/integral-blinds/')) . '">integral blind</a> sealed between the panes, so what you are looking at is a glass unit with a venetian inside it. A small opening like this one is a good place to see it, because the whole blind is in view at once.',
                'Obscure glass and a blind do different jobs, and a bathroom is where that shows. The glass keeps the daylight and takes the view away, all day, without anyone touching it. The blind is the part that changes: down and closed at night when the light is on inside, tilted for some shade in the morning, and up out of the way when you want the window clear.',
                'Two magnetic sliders run up the frame beside the glass. The top one tilts the slats and the bottom one raises and lowers the blind. Nothing crosses the glass, and there is no cord, which is worth having in a room with a bath in it. Because the blind is sealed in, the steam and the dust stay on your side of the glass. You clean the window, and the blind stays as it was.',
                'The slats are white, BY001, chosen to sit with the white frame so the window reads as a plain window when the blind is up. Notan make nine standard slat colours, including anthracite grey and black, with bespoke RAL to order, so the blind can be the thing you notice instead if that suits the room. The frame is <a href="' . $colour_white . '">white</a> uPVC.',
            ],
            'installed' => [
                'One uPVC casement window',
                'Notan magnetic integrated blind sealed inside the glass unit',
                'White slats, BY001',
                'Two magnets on the frame, one to tilt and one to raise and lower',
                'Obscure glass, with a keyed white handle',
            ],
            'installers' => [$fitter_shane, $fitter_zac],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-luton-leagrave-integral-blinds.mp4',
                'poster' => $img . 'cs-luton-leagrave-integral-blinds-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the integral blind being raised, lowered and tilted in the Leagrave bathroom window',
            ],
            'images' => [
                ['src' => $img . 'cs-luton-leagrave-integral-blinds-closed.jpg', 'caption' => 'The blind down and closed, filling the sash. It is sealed inside the glass unit, so nothing hangs in the room.'],
                ['src' => $img . 'cs-luton-leagrave-integral-blinds-open.jpg', 'caption' => 'The blind raised, gathered at the head, with the obscure glass clear behind it. The window is open on the latch here.'],
                ['src' => $img . 'cs-luton-leagrave-integral-blinds-controls.jpg', 'caption' => 'The two magnetic sliders on the frame beside the glass. The top one tilts the slats, the bottom one raises and lowers the blind.'],
                ['src' => $img . 'cs-luton-leagrave-integral-blinds-handle.jpg', 'caption' => 'The white handle on the opening sash, keyed, with the closed blind alongside it.'],
            ],
            /* All four photographs are portrait and the archive card is 16:10,
               so a centre crop of the hero would show a band of slats and no
               window. This crop is taken from the full-resolution original and
               keeps the head of the blind, both magnets and the handle. */
            'card_image' => ['src' => $img . 'cs-luton-leagrave-integral-blinds-card.jpg', 'caption' => 'The blind down and closed in the white uPVC window, with the two magnetic sliders on the frame.'],
            'seo' => [
                'title_tag' => 'Integral Blinds Case Study, Luton | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Leagrave, Luton: a uPVC casement window with a white Notan blind sealed inside the glass, worked by two magnets on the frame.',
            ],
        ],

        'upvc-casement-windows-broughton-milton-keynes' => [
            'title' => 'uPVC casement window, Broughton',
            'location' => 'Broughton, Milton Keynes',
            'type' => 'Residential',
            'date' => '2026-07-02',
            'summary' => 'A single two-tone Liniar casement in Broughton, replacing a boarded-up dormer window with a warm, secure one.',
            'lead' => 'We replaced a boarded-up dormer window on this Broughton home with a single two-tone Liniar casement, basalt grey outside and white inside.',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'Basalt grey (RAL 7012)', 'url' => $colour_basalt],
            'specs' => [
                ['label' => 'Product', 'value' => 'One uPVC casement window'],
                ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'Basalt grey outside, white inside'],
                ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
            ],
            'overview' => [
                'The dormer window at the top of the house had been boarded up. We replaced it with a single <a href="' . $casement . '">uPVC casement window</a> on the 70mm Liniar EnergyPlus system, an A+ rated, multi-chambered profile with a co-extruded bubble gasket that seals continuously around the frame against draughts and driving rain.',
                'The system is A+ rated, reaching 0.95 W/m²K with a 36mm triple glazed unit, and locks with a PAS 24 security option, so the room behind it is warmer, quieter and far more secure than the boarded opening it replaced.',
                'The owner chose a two-tone finish: <a href="' . $colour_basalt . '">basalt grey (RAL 7012)</a> on the outside to match the other frames on the house, with a white interior so the room stays bright. It is a popular way to get a dark modern frame without darkening the room inside.',
            ],
            'installed' => [
                'One Liniar EnergyPlus casement window',
                'Basalt grey (RAL 7012) outside, white inside',
                'A+ rated, energy efficient double glazing',
                'Multi-point locking with a PAS 24 option',
            ],
            'installers' => [$fitter_andy],
            'images' => [
                ['src' => $img . 'cs-mk-broughton-casement-side.jpg', 'caption' => 'The finished dormer window in basalt grey, the single window we replaced.'],
                ['src' => $img . 'cs-mk-broughton-casement-before.jpg', 'caption' => 'Before: the dormer window boarded up at the top of the house.'],
                ['src' => $img . 'cs-mk-broughton-casement-after.jpg', 'caption' => 'The house frontage with the reglazed dormer window back in place at the top.'],
                ['src' => $img . 'cs-mk-broughton-casement-inside.jpg', 'caption' => 'Seen from inside, the frame is white so the room stays bright and neutral.'],
            ],
            'seo' => [
                'title_tag' => 'uPVC Casement Window Case Study, Milton Keynes | Fenster Glazing',
                'meta_description' => 'How we replaced a boarded-up dormer window with a single two-tone Liniar casement window for a home in Broughton, Milton Keynes.',
            ],
        ],

        'upvc-casement-windows-bolbeck-park-milton-keynes' => [
            'title' => 'uPVC casement windows, Bolbeck Park',
            'location' => 'Bolbeck Park, Milton Keynes',
            'type' => 'Residential',
            'date' => '2026-03-26',
            'summary' => 'Anthracite grey Liniar casement windows fitted to a Bolbeck Park home, set against the brickwork.',
            'lead' => 'We replaced the windows on this Bolbeck Park home with anthracite grey Liniar casements, keeping the new frames sharp against the brick elevation.',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => $casement],
            ],
            'colour' => ['label' => 'Anthracite grey', 'url' => $colour_anthracite_upvc],
            'specs' => [
                ['label' => 'Product', 'value' => 'uPVC casement windows'],
                ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'Anthracite grey'],
                ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
            ],
            'overview' => [
                'The old windows on this Bolbeck Park home had reached the point where the frames and glass were letting the elevation down. We replaced them with <a href="' . $casement . '">uPVC casement windows</a> on the 70mm Liniar EnergyPlus system, keeping the proportions familiar while bringing the opening up to a current specification.',
                'The multi-chambered profile and co-extruded bubble gasket help seal the frame against draughts and rain. The system is A+ rated and reaches 0.95 W/m²K with a 36mm triple glazed unit, with a PAS 24 security option available as part of the Liniar specification.',
                'The owners chose <a href="' . $colour_anthracite_upvc . '">anthracite grey</a>, a dark neutral that sits neatly against the red brick and the existing roofline. The finish does the visual work here: no extra decoration, just a clear frame colour carried across the elevation.',
            ],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Anthracite grey finish',
                'A+ rated, energy efficient double glazing',
                'Multi-point locking with a PAS 24 option',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-mk-bolbeck-park-casement.mp4',
                'poster' => $img . 'cs-mk-bolbeck-park-casement-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the finished anthracite grey casement windows at the Bolbeck Park home',
            ],
            'images' => [
                ['src' => $img . 'cs-mk-bolbeck-park-casement-front.jpg', 'caption' => 'The finished anthracite grey casement windows across the side elevation.'],
                ['src' => $img . 'cs-mk-bolbeck-park-casement-before.jpg', 'caption' => 'Before: the existing windows on the brick elevation.'],
                ['src' => $img . 'cs-mk-bolbeck-park-casement-side.jpg', 'caption' => 'A side view showing the new frames and their position against the brickwork.'],
            ],
            'card_image' => ['src' => $img . 'cs-mk-bolbeck-park-casement-card.jpg', 'caption' => 'The finished anthracite grey casement windows across the side elevation.'],
            'seo' => [
                'title_tag' => 'uPVC Casement Windows Case Study, Bolbeck Park | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Bolbeck Park, Milton Keynes: anthracite grey Liniar EnergyPlus casement windows fitted to a brick home.',
            ],
        ],

        'flush-casement-and-slide-fold-doors-leighton-buzzard' => [
            'title' => 'Flush windows and slide and fold doors, Leighton Buzzard',
            'location' => 'Leighton Buzzard, Bedfordshire',
            'type' => 'Residential',
            'date' => '2025-05-08',
            'summary' => 'A full package for a Leighton Buzzard home: flush casement windows and an aluminium slide and fold door that opens the room right out.',
            'lead' => 'We handled the windows and the main garden opening together for this Leighton Buzzard home, pairing flush casement windows with an aluminium slide and fold door.',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/')],
                ['label' => 'Slide and fold doors', 'url' => home_url('/slide-fold-doors/')],
            ],
            'colour' => null,
            'specs' => [
                ['label' => 'Products', 'value' => 'Flush casement windows and an aluminium slide and fold door'],
                ['label' => 'Window system', 'value' => 'Liniar 70mm flush sash uPVC'],
                ['label' => 'Windows', 'value' => 'A+ rated, timber-style flush line'],
                ['label' => 'Door security', 'value' => '10-point locking'],
            ],
            'overview' => [
                'The owners wanted a consistent look across the back of the house, so we surveyed and fitted the windows and the door as one package. The windows are <a href="' . $flush . '">flush casement windows</a> on the Liniar 70mm flush sash system, where the sash sits level with the outer frame for a flatter, timber-style line, with A+ rated performance.',
                'For the main opening we installed an <a href="' . $slidefold . '">aluminium slide and fold door</a>. The panels slide along the track and swing open individually, so one section opens for everyday access and the whole run stacks back when the weather is worth it. A main traffic-door leaf works like a normal door, and interlocking panels with 10-point locking close it down to a secure wall of glass.',
                'Handling both products together meant the sightlines, colour and glazing match across the elevation, so the back of the house reads as one considered design rather than separate jobs.',
            ],
            'installed' => [
                'Liniar flush casement windows',
                'Aluminium slide and fold door with a main traffic leaf',
                'Flush, timber-style window sightlines',
                'Energy efficient double glazing throughout',
            ],
            'installers' => [$fitter_zac, $fitter_shane],
            'images' => [
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-closed.jpg', 'caption' => 'The slide and fold door closed, forming a secure glazed wall across the opening.'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-opening.jpg', 'caption' => 'Opening the door part way, one panel at a time.'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-open.jpg', 'caption' => 'Folded fully open, the panels stack to the side and clear the opening.'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-side.jpg', 'caption' => 'A side view showing how the panels stack along the track.'],
                ['src' => $img . 'cs-leighton-buzzard-flush-casement.jpg', 'caption' => 'One of the flush casement windows, with the sash sitting level with the frame.'],
                ['src' => $img . 'cs-leighton-buzzard-flush-casement-side.jpg', 'caption' => 'A side view of the flush window, showing the flatter external line.'],
            ],
            'seo' => [
                'title_tag' => 'Flush Windows and Slide and Fold Doors Case Study | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Leighton Buzzard: flush casement windows and an aluminium slide and fold door fitted together as one package.',
            ],
        ],

        'upvc-casement-windows-leighton-buzzard' => [
            'title' => 'uPVC casement windows, Leighton Buzzard',
            'location' => 'Leighton Buzzard, Bedfordshire',
            'type' => 'Residential',
            'date' => '2026-07-16',
            'summary' => 'A crisp white Liniar casement replacement in Leighton Buzzard, for warmer, brighter rooms and a tidier frontage.',
            'lead' => 'We replaced the windows on this Leighton Buzzard home with crisp white Liniar casements, for warmer, brighter rooms and a tidier frontage.',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'White', 'url' => $colour_white],
            'specs' => [
                ['label' => 'Product', 'value' => 'uPVC casement windows'],
                ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'White (16 options available)'],
                ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
            ],
            'overview' => [
                'The owners wanted a straightforward, well-fitted set of white windows that would make the rooms brighter and hold their heat far better than the old units. We fitted <a href="' . $casement . '">uPVC casement windows</a> on the 70mm Liniar EnergyPlus system, which is A+ rated and reaches 0.95 W/m²K with a 36mm triple glazed unit.',
                'A co-extruded bubble gasket seals continuously around each frame against draughts and rain, and the windows lock at several points with a PAS 24 security option. We combined side and top opening sashes to suit each room, on smooth, quality hardware.',
                'The frames are finished in classic <a href="' . $colour_white . '">white</a>, which keeps the frontage clean and bright, though the same window is available in 16 colours and foiled woodgrain finishes. uPVC frames never need repainting and simply wipe clean.',
            ],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Crisp white finish',
                'A+ rated, energy efficient double glazing',
                'Multi-point locking with quality handles',
            ],
            'installers' => [$fitter_aaron, $fitter_shane],
            'images' => [
                ['src' => $img . 'cs-leighton-buzzard-casement-front.jpg', 'caption' => 'The finished white casements across the front of the home.'],
                ['src' => $img . 'cs-leighton-buzzard-casement-inside.jpg', 'caption' => 'Seen from inside, the new window brightens the room.'],
                ['src' => $img . 'cs-leighton-buzzard-casement-street.jpg', 'caption' => 'The home in its street, with the replacement windows in place.'],
                ['src' => $img . 'cs-leighton-buzzard-casement-handle-open.jpg', 'caption' => 'The window handle in the open position.'],
                ['src' => $img . 'cs-leighton-buzzard-casement-handle-closed.jpg', 'caption' => 'The handle turned down to the closed, locked position.'],
            ],
            'seo' => [
                'title_tag' => 'uPVC Casement Windows Case Study, Leighton Buzzard | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Leighton Buzzard: crisp white Liniar casement windows replacing tired units for warmer, brighter rooms.',
            ],
        ],

        /* Owner's own job, photographed over two years: the rear "before" is from
           September 2023, the back door October 2024, the front elevation and the
           rear flush windows August 2026. The install itself was February 2024.

           The two D3300 details are from a later shoot, 2026-01-20, and the owner
           has confirmed they are this house. They were held out for a while on the
           reasoning that they showed black internal faces where the video showed
           white; that was wrong, and instructively so. The video only ever framed
           an upstairs window, and this house is black inside downstairs and white
           upstairs, so a single window was being read as if it described the whole
           house. The third frame from that shoot is not used: it is composed
           portrait as a macro and turns to mush at the 4:3 the gallery needs.

           Colour is owner-stated: black brown externally front and back, black
           internally downstairs with black handles, white upstairs. */
        'flush-casement-windows-and-composite-door-wolverton' => [
            'title' => 'Flush casement windows and a composite door, Wolverton',
            'location' => 'Wolverton, Milton Keynes',
            'type' => 'Residential',
            'date' => '2024-02-01',
            'summary' => 'Black brown flush casements, a composite front door and a uPVC back door on a 1930s Wolverton semi, as part of a full restyle.',
            'lead' => 'We replaced every window and both doors on this 1930s Wolverton semi, in black brown against a white elevation, while the owners restyled the rest of the house around them.',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => $flush],
                ['label' => 'Composite doors', 'url' => home_url('/composite-doors/')],
                ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/')],
            ],
            'colour' => ['label' => 'Black brown (RAL 8022)', 'url' => $colour_black_brown],
            /* Four terse rows, as the rest of the archive does it. The internal
               colour split is a good detail but it is a sentence, not a spec
               value: it lives in the overview instead of wrapping this box onto
               three lines. */
            'specs' => [
                ['label' => 'Products', 'value' => 'Flush casement windows, composite and uPVC doors'],
                ['label' => 'System', 'value' => 'Liniar 70mm flush sash uPVC'],
                ['label' => 'Colour', 'value' => 'Black brown (RAL 8022)'],
                ['label' => 'Energy rating', 'value' => 'A+ (1.2 W/m²K)'],
            ],
            'overview' => [
                'The house came to us with white frames and a pink bow motif worked into the leaded glass, in the front door and in the bay alongside it. It is a period detail that dates a house very precisely, and it was the thing the owners most wanted gone. The rest of the frontage was cream render and white uPVC that had done its years.',
                'We fitted <a href="' . $flush . '">flush casement windows</a> throughout, on the Liniar 70mm flush sash system, where the sash closes level with the outer frame instead of standing proud of it. That flat face is what makes uPVC read like painted joinery from the pavement, and it matters more than usual on a 1930s bay: the curve of a bay shows up a stepped sash from right across the road. They are A+ rated and reach 1.2 W/m²K with a 28mm double glazed unit.',
                'The finish is <a href="' . $colour_black_brown . '">black brown</a>, RAL 8022, on every external face front and back. Inside, the house is split by floor: black with black handles downstairs, white upstairs to keep the bedrooms bright. Each face is specified on its own, so the inside does not have to follow the outside, or match itself from floor to floor.',
                'The front door is a <a href="' . home_url('/composite-doors/') . '">composite door</a> in the same black brown, with a long glazed sidelight to keep light in the hall now the leaded panel has gone, and a <a href="' . home_url('/upvc-doors/') . '">uPVC door</a> serves the back between two flush casements. The chequerboard tiling at the threshold is the original and was kept.',
                'Worth saying plainly, because the after photographs show it: the render was painted, the drive block paved and the garden landscaped as part of the same restyle, and none of that was our work. We did the windows and the doors. The colour was chosen knowing the walls were going white, which is the part of the job that needed us and the owners to agree early rather than in sequence.',
            ],
            'installed' => [
                'Liniar 70mm flush casement windows throughout',
                'Black brown outside, black downstairs and white upstairs inside',
                'Composite front door with a glazed sidelight',
                'uPVC back door between two flush casements',
                'A+ rated, 28mm double glazed',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie, $fitter_shane],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-wolverton-restyle.mp4',
                'poster' => $img . 'cs-wolverton-restyle-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the finished black brown flush casement windows and composite front door on the Wolverton semi',
            ],
            /* Eight images, every one of them 4:3. The gallery is a two-column
               grid at `height: auto` with `align-items: start`, so a portrait
               beside a landscape leaves dead space under the shorter one; its own
               comment says the two columns exist to put a pair on one row. One
               ratio throughout is what makes the rows line up.

               Read as four rows: the front pair, the rear pair, then two rows of
               detail. The front door pair came out — owner, too forced — and the
               bow motif it carried is still in the front-before shot and the
               opening paragraph, so nothing is lost by dropping it. */
            'images' => [
                ['src' => $img . 'cs-wolverton-restyle-front-before.jpg', 'caption' => 'Before: cream render, white frames, and the pink bow motif in the bay glass.'],
                ['src' => $img . 'cs-wolverton-restyle-front-after.jpg', 'caption' => 'After: black brown flush casements across the bay and the front elevation.'],
                ['src' => $img . 'cs-wolverton-restyle-rear-before.jpg', 'caption' => 'Before: the rear extension in bare brick, with white uPVC.'],
                ['src' => $img . 'cs-wolverton-restyle-rear-after.jpg', 'caption' => 'After: the same elevation. The paintwork and the garden were done by others as part of the restyle.'],
                ['src' => $img . 'cs-wolverton-restyle-rear-doors.jpg', 'caption' => 'The uPVC back door, set between two flush casements.'],
                ['src' => $img . 'cs-wolverton-restyle-flush-rear.jpg', 'caption' => 'The flush sash line at the rear, where the sash closes level with the frame.'],
                ['src' => $img . 'cs-wolverton-restyle-window-detail.jpg', 'caption' => 'A black handle on a black internal frame downstairs, with obscured glass.'],
                ['src' => $img . 'cs-wolverton-restyle-door-detail.jpg', 'caption' => 'The composite door hardware, on the black brown woodgrain finish.'],
            ],
            'card_image' => ['src' => $img . 'cs-wolverton-restyle-card.jpg', 'caption' => 'Black brown flush casement windows and a composite front door on a 1930s Wolverton semi.'],
            'seo' => [
                'title_tag' => 'Flush Casement Windows and Composite Door Case Study, Wolverton | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Wolverton, Milton Keynes: black brown Liniar flush casement windows, a composite front door and a uPVC back door on a 1930s semi.',
            ],
        ],

        /* Drayton Parslow doors, added 2026-08-18 from five photographs and two
         * videos the owner supplied. Fitters Tom and Johnnie, owner-stated.
         *
         * COLZA YELLOW IS RAL 1021, NOT 1012. The owner's folder note said
         * 1012, which is Lemon Yellow. Colza Yellow is RAL 1021 both in
         * Distinction's own range and in `colour_options.materials.composite`
         * in site-data.php, which is what the deep link below resolves against,
         * and the saturated yellow in the photographs is 1021 rather than the
         * paler 1012. Do not "correct" this back to the folder name.
         *
         * TRAFFIC ORANGE, RAL 2009, IS NOT IN THE STANDARD PALETTE and there is
         * therefore no swatch to deep link. That is not a gap: the composite
         * palette copy says any RAL can be matched beyond the standard range,
         * and this door is what that sentence looks like on a house. The single
         * `colour` field points at the yellow, which does have a swatch.
         *
         * SECURED BY DESIGN IS CLAIMED FOR THE FRONT DOOR ONLY. The composite
         * doors page is explicit that the accreditation covers the slabs
         * "though not the stable doors", so the security sentence sits with the
         * front door and the stable door paragraph makes no accreditation
         * claim. The £5,000 guarantee is a Fenster-wide claim on every composite
         * door we hang and is stated once, for both.
         *
         * NO U-VALUE ON EITHER DOOR, per the composite doors page, which
         * refuses to print one before a doorset is specified. Same call as
         * Little Horwood.
         *
         * NO STYLE NAME ON THE FRONT DOOR. Its slab is grooved on the diagonal
         * and no such design is in the 33-style catalogue the composite page
         * renders, so it is described rather than named. The stable door does
         * match `stable-half-glazed` exactly, and "half glazed" is used here as
         * a description of what is in the photograph, not as a catalogue code.
         *
         * THE NUMBER PLATE IS BLURRED in the front-door before shot. It is a
         * private plate on the customer's own drive and it was legible at full
         * size; blurred at full resolution before the downscale, the same
         * treatment as Little Horwood. No source file carried EXIF.
         *
         * ONE OF THE TWO VIDEOS IS USED. The stable door clip is the one that
         * shows the thing being sold, the top leaf opening while the bottom
         * stays shut, and it is native 392x848 portrait so it goes in the hero
         * slot and the CSS squares it. The front door clip is 848x478, mostly
         * extreme close-ups, and its last five seconds look into the customer's
         * hall, which is the same reason Little Horwood dropped a frame. Note
         * that the phone's white balance reads the orange redder in the video
         * than in the stills; the photographs carry the true colour.
         *
         * The garage, its doors and the "Dad's Garage" sign are the owners' own
         * and are not ours, the way Wolverton says the render and the
         * landscaping were not ours.
         */
        /* Hanslope barn conversion, added 2026-08-19 from five photographs and
         * the owner's film. Fitters Shane and Tom, owner-stated.
         *
         * THIS IS THE STUDY THAT UNGATES `/tilt-turn-windows/`. That route was
         * in `$no_case_study_routes` in generated-page.php with
         * `/aluminium-windows/`, rendering no proof at all rather than falling
         * through to unrelated jobs. CASE-STUDY-PRIORITIES-2026-08-17.md lists
         * it as Tier 2 and says to add the study first and remove the gate
         * second, which is what this commit does. Aluminium windows stay gated:
         * nothing here claims that route.
         *
         * THE TILT AND TURN IS VERIFIED AS FAR AS A PHOTOGRAPH CAN. The site
         * has already published a "tilt and turn" that was not one: the note in
         * site-data.php records `tilt-turn-brick-1600w.webp` showing two barrel
         * hinges on the OUTER FRAME, which is a side-hung casement opening
         * outward. So the jamb here was checked at full resolution before this
         * was written, and the outer frame is clean: no barrel hinges, hardware
         * concealed, one large sash in a deep frame. That plus the owner's own
         * label is the basis for the claim.
         *
         * 1.3 W/m²K, NOT 0.95 OR 1.2. Owner-confirmed 2026-08-19 that the tilt
         * and turn is double glazed, and this route is the one Liniar line off
         * the 0.95/1.2 pair: `glazing_u_values` carries 1.3 double and 0.93
         * triple for it, on an owner ruling of 2026-08-12 that its own note
         * says not to reconcile back to casement's figures. The flush casement
         * keeps 1.2 and A+, which is determinate because that system is 28mm
         * double only and has no triple option.
         *
         * THERE IS NO STABLE DOOR AND THE COPY DOES NOT CLAIM ONE. The folder
         * note listed "upvc stable door", but the only door on that elevation
         * in any photograph or any frame of the film is a single fully glazed
         * uPVC door, one leaf, unbroken from head to threshold. Owner confirmed
         * on 2026-08-19 that the note was loose and there is no stable door on
         * this job. Do not add one back from the folder name.
         *
         * THE COMPOSITE DOUBLE DOOR EXISTS ONLY IN THE FILM, AND ITS IMAGE
         * IS THE WHOLE FRAME, UNCROPPED. Owner instruction, 2026-08-19: "dont
         * crop, watermark is fine." It is the 12.6s frame at its native
         * 720x1280, saved as it came out of the film.
         *
         * That is not a compromise, it is the best of the three versions tried,
         * and the reason is worth keeping. The square cell shows a window as
         * wide as the source and centred, so on a 720x1280 frame it lands on y
         * 280 to 1000 and the doorset sits at roughly y 330 to 990. The cell
         * frames the whole door by itself, with the stone lintel above it and
         * the threshold below.
         *
         * The two cropped versions were both worse. 470x700 was cut to dodge
         * the `@FENSTERGLAZING` watermark and the slate sign naming the house,
         * and at 0.671 the cell then showed 67% of its height and took the head
         * and threshold off the door, the same fault the owner caught on the
         * Drayton Parslow front door. Recutting to 515x545 recovered most of it
         * but could never recover all, because the door is about 600px tall and
         * only about 515px of width was clear of the watermark, and a square
         * cell can never show more height than its source has width. Dodging
         * the watermark was the whole constraint, and the owner lifted it.
         *
         * So the watermark and the house sign are both in this image
         * deliberately. The film carries both anyway, on the same instruction.
         * That the slab is composite is owner-stated; a drone frame cannot
         * prove a material.
         *
         * SQUARE GALLERY, NOT THE 3:4 CELL. Five photographs are portrait, the
         * gable shot is landscape and the door still is neither, so this
         * gallery mixes orientations and `gallery_shape` must stay off. See the
         * note on it in the template: the tall cell is only for a gallery whose
         * every image is portrait.
         *
         * THE FILM IS THE OWNER'S SOCIAL REEL and goes on whole, on his
         * instruction of 2026-08-19 after being asked. It carries an
         * `@FENSTERGLAZING` watermark on every frame, the van in shot and an
         * Instagram end card, none of which any other film in this archive has.
         * Re-encoded at native 720x1280 with `-an`, crf 27, 6.89MB from 13.8MB.
         * No crop: the CSS squares a portrait hero, so cropping here would crop
         * it twice.
         */
        'flush-casement-tilt-turn-and-doors-hanslope' => [
            'title' => 'Flush casements, tilt and turn windows and doors, Hanslope',
            /* Hanslope sits in the Milton Keynes borough but is its own village,
               and "Milton Keynes" in this field would put the study on twelve
               suburb routes at once. CASE-STUDY-PRIORITIES-2026-08-17.md is
               explicit that a thirteenth MK study adds nothing to town coverage,
               so the honest narrower field is the right one. */
            'location' => 'Hanslope, Buckinghamshire',
            'type' => 'Residential',
            // Folder "24-7-24", day first, as "17-02-2025" was on the Wolverton
            // sash job and "26-07-25" on Drayton Parslow.
            'date' => '2024-07-24',
            'summary' => 'Anthracite grey Liniar windows and two doors across a stone barn conversion in Hanslope, with flush casements on the elevations and a tilt and turn that opens two ways.',
            'lead' => 'A stone barn conversion in Hanslope, done in one colour throughout. Flush casements across the walls, a tilt and turn that opens two ways, a composite double door on the courtyard and a fully glazed uPVC door onto the decking.',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => $flush],
                ['label' => 'Tilt and turn windows', 'url' => home_url('/tilt-turn-windows/')],
                ['label' => 'Composite doors', 'url' => home_url('/composite-doors/')],
                ['label' => 'uPVC doors', 'url' => home_url('/upvc-doors/')],
            ],
            'colour' => ['label' => 'Anthracite grey (RAL 7016)', 'url' => $colour_anthracite_upvc],
            'specs' => [
                ['label' => 'Products', 'value' => 'Flush casement and tilt and turn windows, two doors'],
                ['label' => 'System', 'value' => 'Liniar 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'Anthracite grey (RAL 7016)'],
                ['label' => 'Glazing', 'value' => 'Double glazed'],
            ],
            'overview' => [
                'The building is a stone barn conversion, rubble limestone walls a couple of feet thick, stone cills and deep reveals, with a brick cill under one opening where the wall was made good. That kind of wall decides the job before anyone picks a product: the openings are irregular, the reveals are deep, and anything that stands proud of the stone announces itself from the yard. Everything we fitted here is <a href="' . $colour_anthracite_upvc . '">anthracite grey</a>, RAL 7016, so the glazing reads as one decision against the limestone rather than as several orders.',
                'Most of the elevations take <a href="' . $flush . '">flush casement windows</a> on the Liniar 70mm flush sash system, where the sash closes level with the outer frame instead of sitting on top of it. On a stone building that flat face is most of the point, because it is how a timber window sat in the same opening. The system is A+ rated and reaches 1.2 W/m²K with a 28mm double glazed unit, and there are trickle vents in the frame heads, so a room can be aired with the window shut.',
                'One opening takes a <a href="' . esc_url(home_url('/tilt-turn-windows/')) . '">tilt and turn</a> instead, and it is worth knowing why. It opens two ways from one handle: tilt the top of the sash inwards for ventilation, or swing the whole sash inwards like a door to clean the outside face from indoors. On a first floor above a border, where an outward opening sash has to clear the planting and the outside of the glass is otherwise a ladder job, that is the difference between a window you can maintain and one you cannot. It is the same Liniar 70mm frame and it is double glazed here, which Liniar publish at 1.3 W/m²K for this window. The hardware is concealed in the frame, so from outside there is nothing on the face of it but the sash line.',
                'Two doors. The courtyard side has a <a href="' . esc_url(home_url('/composite-doors/')) . '">composite double door</a>, two leaves on a woodgrain slab, with ten small diamond panes of decorative glass set in a fan across the pair and a long bar handle on each leaf. We fit Distinction doors, whose slabs are accredited by Secured by Design, and every composite door we fit carries a £5,000 security guarantee, terms applying. The garden side has a <a href="' . esc_url(home_url('/upvc-doors/')) . '">uPVC door</a> onto the decking, glazed in a single pane from head to threshold with a trickle vent above it and a lever handle, so the room behind keeps the view out over the fields.',
                'The timber lintel and surround around that garden door are the building\'s own and were kept. So were the stone cills. We did the windows and the doors.',
            ],
            'installed' => [
                'Liniar 70mm flush casement windows, with trickle vents in the heads',
                'Liniar 70mm tilt and turn, opening two ways from one handle',
                'Anthracite grey (RAL 7016), double glazed',
                'A composite double door with decorative diamond glazing',
                'A fully glazed uPVC door onto the decking',
            ],
            'installers' => [$fitter_shane, $fitter_tom],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-hanslope-barn.mp4',
                'poster' => $img . 'cs-hanslope-barn-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Film of the finished anthracite grey windows and doors around the Hanslope barn conversion',
            ],
            'images' => [
                ['src' => $img . 'cs-hanslope-flush-casement-wide.jpg', 'caption' => 'A two pane flush casement in a stone opening, with trickle vents in the head and a brick cill under it.'],
                ['src' => $img . 'cs-hanslope-flush-casement-angle.jpg', 'caption' => 'The same detail from the side, where the sash closes level with the outer frame rather than standing proud of it.'],
                ['src' => $img . 'cs-hanslope-flush-casement-pair.jpg', 'caption' => 'A flush casement on a stone cill, the two sashes meeting on a central mullion.'],
                ['src' => $img . 'cs-hanslope-tilt-turn.jpg', 'caption' => 'The tilt and turn in its reveal. There are no hinges on the outer frame because the hardware sits inside it.'],
                /* A row of its own, uncropped. Owner instruction, 2026-08-19: "the window
                   and door in same shot need to not be cropped". The window sits at
                   about x 140 and the door ends at about x 1420 of a 1600x1200 frame,
                   and a square cell shows only as many pixels of width as the image
                   has height, so at 1200 it clipped the window's frame at one edge and
                   the door's at the other. Recropping cannot fix it; the span is about
                   80px wider than the arithmetic allows. */
                ['src' => $img . 'cs-hanslope-gable-tilt-turn-and-door.jpg', 'wide' => true, 'caption' => 'The garden elevation, with the tilt and turn on the left and the fully glazed uPVC door onto the decking on the right.'],
                ['src' => $img . 'cs-hanslope-composite-double-door.jpg', 'caption' => 'The composite double door on the courtyard, its diamond panes set in a fan across both leaves.'],
            ],
            'card_image' => ['src' => $img . 'cs-hanslope-card.jpg', 'caption' => 'Anthracite grey windows and doors on a stone barn conversion in Hanslope.'],
            'seo' => [
                'title_tag' => 'Flush Casement and Tilt and Turn Windows, Hanslope | Fenster Glazing',
                /* 156 characters against a 160 cap. */
                'meta_description' => 'A real Fenster project in Hanslope: anthracite grey Liniar flush casement and tilt and turn windows, a composite double door and a uPVC door on a stone barn.',
            ],
        ],

        'composite-front-door-and-stable-door-drayton-parslow' => [
            'title' => 'Composite front door and stable door, Drayton Parslow',
            'location' => 'Drayton Parslow, Buckinghamshire',
            'type' => 'Residential',
            // Owner-confirmed 2026-08-18: the folder name "26-07-25" is
            // day-first, the way "17-02-2025" on the Wolverton sash job was, so
            // this is 26 July 2025 and not 25 July 2026.
            'date' => '2025-07-26',
            // No `priced_by`. Owner-confirmed 2026-08-18 that this job was
            // priced on the quote tool, which is the archive default, so the
            // page's claim about this customer is checked rather than assumed.
            'summary' => 'Two Distinction composite doors on one Drayton Parslow bungalow: a colza yellow front door in the porch and a traffic orange stable door round the side.',
            'lead' => 'Two doors on the same bungalow, and neither of them is a quiet colour. A colza yellow front door off the drive, and a traffic orange stable door in the passage by the garage.',
            'products' => [
                ['label' => 'Composite doors', 'url' => home_url('/composite-doors/')],
            ],
            'colour' => ['label' => 'Colza yellow (RAL 1021)', 'url' => $colour_colza],
            'specs' => [
                ['label' => 'Products', 'value' => 'Two Distinction composite doors'],
                ['label' => 'Front door', 'value' => 'Colza yellow (RAL 1021)'],
                ['label' => 'Stable door', 'value' => 'Traffic orange (RAL 2009)'],
                ['label' => 'Slab', 'value' => '44.5mm insulated composite'],
            ],
            'overview' => [
                'Two <a href="' . esc_url(home_url('/composite-doors/')) . '">composite doors</a> on one bungalow, in two colours, doing two different jobs. The front door is in a small porch off the block paved drive. The stable door is round the side, in the passage between the house and the garage, up a brick step. Neither opening was new: there was a yellow front door there already, with a leaded rose in the glass, and a painted side door with a blind hanging behind it that had done its years.',
                'The front door slab is solid, with grooves cut across it on the diagonal, so no light comes through the door itself. It comes through the full height glazed sidelight next to it instead, which is what keeps the hall as bright as it was. A long brushed bar handle runs most of the height of the opening edge, with a black letterplate low down. Every Distinction door we hang carries AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock, and the slab is accredited by Secured by Design, the police-backed standard.',
                'The side door is a stable door, split across the middle so the top half opens on its own while the bottom stays shut and locked. That is the whole reason to fit one: air and daylight into the back of the house without the opening standing wide, and something still across it at knee height for a dog or a small child. Each half locks on its own, with the lever handle and a cylinder on the top leaf and a second cylinder on the bottom. The top leaf is glazed in a single square pane, both halves carry vertical boards, and a weather bar sits across the joint to throw rain off the split.',
                'The colours are <a href="' . $colour_colza . '">colza yellow</a>, RAL 1021, on the front and traffic orange, RAL 2009, on the stable door. The house had a yellow front door before this one, so the colour is not the change, the door around it is. The orange is not on the standard chart: Distinction match to any RAL on request, which is worth knowing before you settle for the nearest colour that is on it. Both doors sit in dark grey frames against red brick, and every composite door we fit carries a £5,000 security guarantee, terms applying.',
                'Both are the same 44.5mm insulated slab, which is a compression moulded glass reinforced polyester skin over a foam filled core, with polymer edges and engineered wood stiles behind it. The colour is in the skin rather than painted onto it, and that matters more on these two than it would on a white door: a bright yellow and a traffic orange are exactly the colours nobody wants to be repainting every few summers.',
            ],
            'installed' => [
                'One Distinction composite front door, colza yellow (RAL 1021)',
                'Solid slab grooved on the diagonal, with a full height glazed sidelight',
                'Long brushed bar handle and a letterplate',
                'One Distinction composite stable door, traffic orange (RAL 2009)',
                'Split leaves, each locking on its own, with a glazed pane in the top half',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie],
            /* All five photographs are portrait, so the gallery takes the 3:4
               cell rather than the square one. Owner call, 2026-08-18: the
               square crop was "way too zoomed in" on the front door, and it
               was. `object-fit: cover` makes the visible window exactly as wide
               as the source file, so at 739px wide the square window is 739px
               tall and the door is 960px, and the head of the door and the
               porch it was reshot to show both fell outside it. A 3:4 window is
               985px and holds the whole door. Nothing else on the site changes,
               and the rows still line up because every image here shares the
               new shape. See the note on `gallery_shape` in the template.

               The front door file is also re-cut, 739x1600 down to 739x1366.
               That is NOT a crop to the cell shape, which the guide forbids: at
               0.541 it is still its own aspect, nowhere near the cell's 0.75.
               What came off was the out-of-focus rose foliage across the
               bottom, which was pushing the door far enough down the frame that
               the 3:4 window still clipped the head of it. With that gone the
               window holds the doorset whole, head to threshold. The handle
               shot keeps its full height on purpose: it is a detail of the
               lever and the two cylinders and the cell frames it already. */
            'gallery_shape' => 'tall',
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-drayton-parslow-stable-door.mp4',
                'poster' => $img . 'cs-drayton-parslow-stable-door-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the traffic orange stable door, with the top half opening on its own while the bottom stays shut',
            ],
            'images' => [
                ['src' => $img . 'cs-drayton-parslow-front-door-before.jpg', 'caption' => 'Before: the old front door in the porch, yellow already, with a leaded rose in the glass and a sidelight beside it.'],
                ['src' => $img . 'cs-drayton-parslow-front-door-after.jpg', 'caption' => 'After: the colza yellow door in the porch, its slab grooved on the diagonal, with a long bar handle and the glazed sidelight carrying the light into the hall.'],
                ['src' => $img . 'cs-drayton-parslow-stable-door-before.jpg', 'caption' => 'Before: the side door in the passage between the house and the garage, painted, with a blind hanging behind the glass.'],
                ['src' => $img . 'cs-drayton-parslow-stable-door-after.jpg', 'caption' => 'After: the traffic orange stable door closed, with the weather bar across the joint and the glazed pane in the top half.'],
                ['src' => $img . 'cs-drayton-parslow-stable-door-handle.jpg', 'caption' => 'The hardware. Lever and cylinder on the top leaf, a second cylinder on the bottom, so each half locks on its own.'],
            ],
            /* Every photograph on this job is portrait and the archive card is
               16:10, so a centre crop of the hero would be a band of orange
               board and no door. This one is cut from the full-resolution
               stable door original at the split, which keeps the mid rail, the
               weather bar, both cylinders, the lever and the glazed top leaf. */
            'card_image' => ['src' => $img . 'cs-drayton-parslow-doors-card.jpg', 'caption' => 'A traffic orange composite stable door on a Drayton Parslow bungalow, split across the middle.'],
            'seo' => [
                'title_tag' => 'Composite Front Door and Stable Door, Drayton Parslow | Fenster Glazing',
                /* 151 characters against a 160 cap. */
                'meta_description' => 'A real Fenster project in Drayton Parslow: two Distinction composite doors on one bungalow, a colza yellow front door and a traffic orange stable door.',
            ],
        ],

        'sheerline-roof-lantern' => [
            'title' => 'Sheerline roof lantern, Drayton Parslow',
            'location' => 'Drayton Parslow',
            'type' => 'Residential',
            'date' => '2025-06-08',
            'summary' => 'A large Sheerline S1 aluminium roof lantern with automated opening vents, flooding an extension with daylight.',
            'lead' => 'We installed a large Sheerline S1 aluminium roof lantern over this extension, bringing far more daylight into the room below.',
            'products' => [
                ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/')],
            ],
            'colour' => ['label' => 'White', 'url' => $colour_link('aluminium', 'pure-white')],
            'specs' => [
                ['label' => 'Product', 'value' => 'Sheerline S1 roof lantern'],
                ['label' => 'System', 'value' => 'Sheerline S1 aluminium, Thermlock'],
                ['label' => 'Glazing', 'value' => '28mm, solar-control options'],
                ['label' => 'Ventilation', 'value' => 'SheerVent automated openers'],
            ],
            'overview' => [
                'The owners wanted to open the roof of their extension up to the sky. We installed a large <a href="' . esc_url(home_url('/roof-lanterns/')) . '">Sheerline S1 roof lantern</a>, an aluminium lantern system with a slim, low-line external profile so more of the roof is glass and less is frame.',
                'Inside the frame, Sheerline Thermlock multi-chamber technology works with 28mm glazing to keep the room insulated, with solar-control glass options to manage heat and glare. This lantern also uses SheerVent automated openers, so the vents open for fresh air and close on their own if it starts to rain.',
                'The lantern is finished in white to sit cleanly against the existing roof and windows. Sheerline aluminium can be powder coated in a wide range of finishes, which you can browse on our <a href="' . $colour_link('aluminium', 'pure-white') . '">colour options</a> page.',
            ],
            'installed' => [
                'Sheerline S1 aluminium roof lantern',
                'White frame finish',
                '28mm glazing with solar-control options',
                'SheerVent automated opening vents',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-big-roof-lantern.mp4',
                'poster' => $img . 'cs-big-roof-lantern-poster.jpg',
                'orientation' => 'landscape',
                'label' => 'Video of the installed Sheerline roof lantern with its vents open',
            ],
            'images' => [
                ['src' => $img . 'cs-big-roof-lantern-14.jpg', 'caption' => 'The finished lantern from above, with the SheerVent openers open for ventilation.'],
                ['src' => $img . 'cs-big-roof-lantern-19.jpg', 'caption' => 'A closer look at the slim white frame and opening vents along the lantern.'],
            ],
            'seo' => [
                'title_tag' => 'Sheerline Roof Lantern Case Study, Drayton Parslow | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Drayton Parslow: a large Sheerline S1 aluminium roof lantern with SheerVent automated openers, bringing daylight into an extension.',
            ],
        ],

        'roof-lantern-and-heritage-doors' => [
            'title' => 'Roof lantern and heritage doors, Northampton',
            'location' => 'Northampton',
            'type' => 'Residential',
            'date' => '2025-04-22',
            'summary' => 'A Sheerline roof lantern paired with black steel-look heritage aluminium doors on a brick extension.',
            'lead' => 'We fitted a Sheerline roof lantern and a set of black heritage aluminium doors on this extension, pairing overhead daylight with a sharp steel-look opening to the garden.',
            'products' => [
                ['label' => 'Roof lanterns', 'url' => home_url('/roof-lanterns/')],
                ['label' => 'Heritage aluminium doors', 'url' => home_url('/heritage-aluminium-doors/')],
            ],
            'colour' => ['label' => 'Black', 'url' => $colour_link('aluminium', 'jet-black')],
            'specs' => [
                ['label' => 'Products', 'value' => 'Roof lantern and heritage doors'],
                ['label' => 'Lantern', 'value' => 'Sheerline S1 aluminium'],
                ['label' => 'Doors', 'value' => 'Sheerline Classic, 1.4 W/m²K'],
                ['label' => 'Colour', 'value' => 'Black, inside and out'],
            ],
            'overview' => [
                'This extension needed both overhead light and a smart opening to the garden. We installed a <a href="' . esc_url(home_url('/roof-lanterns/')) . '">Sheerline S1 roof lantern</a> over the room, with a slim low-line aluminium frame and 28mm glazing, so the space is bright from above through the day.',
                'To the garden we fitted <a href="' . esc_url(home_url('/heritage-aluminium-doors/')) . '">heritage aluminium doors</a> on the Sheerline Classic system. These give the steel-look styling of traditional doors, with slim sightlines, glazing bars and toplights, in a modern thermally broken aluminium frame that reaches a 1.4 W/m²K U-value and locks at several points.',
                'The lantern and the doors are finished in <a href="' . $colour_link('aluminium', 'jet-black') . '">black</a> inside and out, so the glazing reads as one crisp, contemporary detail across the extension.',
            ],
            'installed' => [
                'Sheerline S1 aluminium roof lantern',
                'Sheerline Classic heritage aluminium doors',
                'Black finish, inside and out',
                'Steel-look glazing bars, toplights and multi-point locking',
            ],
            'installers' => [$fitter_johnnie, $fitter_tom],
            'award' => [
                'title' => 'Installation of the Month',
                'source' => 'Sheerline',
                'date' => 'August 2025',
                'logo' => FENSTER_THEME_URI . '/assets/partners/sheerline.png',
                'note' => 'Sheerline chose this project as their Installation of the Month in August 2025.',
            ],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-roof-lantern-heritage-doors.mp4',
                'poster' => $img . 'cs-roof-lantern-heritage-doors-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video of the installed roof lantern and heritage doors',
            ],
            'images' => [
                ['src' => $img . 'cs-lantern-doors-interior.jpg', 'caption' => 'Looking out through the black heritage doors to the garden, with the roof lantern above.'],
                ['src' => $img . 'cs-lantern-doors-up.jpg', 'caption' => 'The roof lantern from inside the room, framing the sky.'],
                ['src' => $img . 'cs-lantern-doors-6.jpg', 'caption' => 'The black heritage aluminium doors and the roof lantern above, seen from the garden.'],
                ['src' => $img . 'cs-lantern-doors-16.jpg', 'caption' => 'The roof lantern from above, with its slim black frame on the flat roof.'],
            ],
            'seo' => [
                'title_tag' => 'Roof Lantern and Heritage Doors Case Study, Northampton | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Northampton: a Sheerline roof lantern and black steel-look heritage aluminium doors fitted to a brick extension.',
            ],
        ],

        'heritage-aluminium-doors-wolverton' => [
            'title' => 'Heritage aluminium doors, Wolverton',
            'location' => 'Wolverton',
            'type' => 'Residential',
            'date' => '2026-05-13',
            // Owner-confirmed: this job was priced at a consultation, not on
            // the quote tool.
            'priced_by' => 'consultation',
            'summary' => 'Two timber openings at the back of a Victorian terrace, replaced in jet black heritage aluminium, with the narrow one turned into a single wide leaf.',
            'lead' => 'This Victorian terrace in Wolverton had painted timber doors on two openings at the back. Both are now Sheerline Classic heritage aluminium: French doors to the patio again, and the narrow side path opening turned into a single wide leaf.',
            'products' => [
                ['label' => 'Heritage aluminium doors', 'url' => home_url('/heritage-aluminium-doors/')],
            ],
            'colour' => ['label' => 'Jet Black', 'url' => $colour_link('aluminium', 'jet-black')],
            'specs' => [
                ['label' => 'Products', 'value' => 'Heritage aluminium doors'],
                ['label' => 'System', 'value' => 'Sheerline Classic, 1.4 W/m²K'],
                ['label' => 'Configuration', 'value' => 'French doors and a single, both with toplights'],
                ['label' => 'Colour', 'value' => 'Jet Black, with black handles'],
            ],
            'overview' => [
                'Two openings at the back of this terrace, both still in painted timber and both French doors. One opens onto the patio, the other onto the side path, and each had a toplight above it.',
                'The patio opening is French doors again, in <a href="' . esc_url(home_url('/heritage-aluminium-doors/')) . '">Sheerline Classic heritage aluminium</a>. The side path is where the layout actually changed. Splitting a narrow opening in two gives you two narrow ways through and no useful one, so that opening is now a single wide leaf in the same brickwork.',
                'Both toplights were kept. That let the new frames sit in the existing openings without losing glass above the door, and it keeps the proportions the back of the house already had.',
                'Both are two bar, so the glazing bars line up across the French doors and the single even though the two openings are different widths. Finished in <a href="' . $colour_link('aluminium', 'jet-black') . '">Jet Black</a> with black handles, against the red brick.',
                'Powder-coated aluminium replaces painted timber on both, so neither needs repainting, and both lock at several points up the frame rather than on a single latch.',
            ],
            'installed' => [
                'Sheerline Classic heritage aluminium French doors to the patio',
                'Sheerline Classic heritage aluminium single door to the side path',
                'Narrow French opening turned into one wide leaf',
                'Two bar glazing on both, with the existing toplights retained',
                'Jet Black finish with black handles',
            ],
            'installers' => [$fitter_zac, $fitter_shane],
            /* The first entry is spent on the hero and the card, so it is the
               open shot, which belongs to no pair. That leaves the gallery
               itself reading after, before, after, before, then indoors. */
            'images' => [
                ['src' => $img . 'cs-wolverton-heritage-doors-open.webp', 'caption' => 'Both leaves open onto the patio, looking back through the kitchen.'],
                ['src' => $img . 'cs-wolverton-heritage-doors-exterior.webp', 'caption' => 'After: the patio opening, French doors with two bar glazing.'],
                ['src' => $img . 'cs-wolverton-heritage-doors-before-double.webp', 'caption' => 'Before: the painted timber French doors on the same opening.'],
                ['src' => $img . 'cs-wolverton-heritage-doors-single.webp', 'caption' => 'After: the side path as one wide single leaf.'],
                ['src' => $img . 'cs-wolverton-heritage-doors-before-single.webp', 'caption' => 'Before: the side path as narrow timber French doors.'],
                ['src' => $img . 'cs-wolverton-heritage-doors-interior.webp', 'caption' => 'The patio doors from inside, with the toplight above the head.'],
            ],
        ],
        'white-charisma-rose-sash-windows-wolverton' => [
            'title' => 'White Charisma Rose sash windows, Wolverton',
            'location' => 'Wolverton, Milton Keynes',
            'type' => 'Residential',
            'date' => '2025-02-17',
            'summary' => 'White Roseview Charisma Rose sash windows fitted to a red-brick Wolverton home, with traditional glazing-bar detail.',
            'lead' => 'We fitted white Charisma Rose sash windows to this Wolverton home, keeping the vertical proportions and glazing-bar detail that belong on the red-brick frontage.',
            'products' => [
                ['label' => 'Sliding sash windows', 'url' => $sash],
                ['label' => 'uPVC casement windows', 'url' => $casement],
            ],
            'colour' => ['label' => 'White', 'url' => $colour_white],
            'specs' => [
                ['label' => 'Product', 'value' => 'White Charisma Rose sash windows'],
                ['label' => 'System', 'value' => 'Roseview Charisma Rose'],
                ['label' => 'Colour', 'value' => 'White'],
                ['label' => 'Energy rating', 'value' => 'A rated'],
            ],
            'overview' => [
                'This Wolverton job called for sash windows that respected the house rather than flattening its proportions into a generic replacement. We fitted white Charisma Rose windows from <a href="' . $sash . '">Roseview</a>, with vertical sliding sashes, glazing bars and the deep external detail that suits the red brick and existing cills.',
                'Charisma Rose is the simpler Rose Collection specification, with a 60mm meeting rail and welded uPVC construction. It keeps the familiar sash operation and period shape while giving the house modern sealed double glazing, lower maintenance and an A-rated energy specification.',
                'The wider project photography also catches a Liniar casement on the same elevation, and the short walkthrough briefly shows another finished composite door. They are left visible because this is the supplied record of the completed property; the case study itself is about the white Charisma Rose sash windows.',
            ],
            'installed' => [
                'White Charisma Rose sash windows',
                'Vertical sliding sash operation',
                'Georgian-style glazing bars',
                'A-rated energy-efficient double glazing',
            ],
            'installers' => [$fitter_tom, $fitter_johnnie],
            'video' => [
                'src' => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-wolverton-charisma-sash.mp4',
                'poster' => $img . 'cs-wolverton-charisma-sash-poster.jpg',
                'orientation' => 'portrait',
                'label' => 'Video walkthrough of the white Charisma Rose sash windows and finished glazing at the Wolverton home',
            ],
            'images' => [
                ['src' => $img . 'cs-wolverton-charisma-sash-front.jpg', 'caption' => 'A white Charisma Rose sash window fitted into the red-brick frontage.'],
                ['src' => $img . 'cs-wolverton-charisma-sash-elevation.jpg', 'caption' => 'The wider elevation, with a Liniar casement visible beside the sash window.'],
                ['src' => $img . 'cs-wolverton-charisma-sash-side.jpg', 'caption' => 'The lower-floor sash window viewed from the side passage.'],
                ['src' => $img . 'cs-wolverton-charisma-sash-frontage.jpg', 'caption' => 'The upper and lower windows working together across the red-brick frontage.'],
                ['src' => $img . 'cs-wolverton-charisma-sash-detail.jpg', 'caption' => 'A closer view of the white frame, glazing bars and projecting cill.'],
            ],
            'card_image' => ['src' => $img . 'cs-wolverton-charisma-sash-card.jpg', 'caption' => 'A white Charisma Rose sash window fitted into the red-brick frontage.'],
            'seo' => [
                'title_tag' => 'White Charisma Rose Sash Windows Case Study, Wolverton | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Wolverton: white Roseview Charisma Rose sash windows fitted to a red-brick Milton Keynes home.',
            ],
        ],
    ];

    // Newest first, so the archive and related sections stay in date order
    // regardless of the order entries are written above.
    uasort($cache, static function (array $a, array $b): int {
        return strcmp((string) ($b['date'] ?? ''), (string) ($a['date'] ?? ''));
    });

    return $cache;
}

/**
 * Return a single case study by its short slug (no "case-studies/" prefix).
 *
 * @param string $short_slug Detail slug segment.
 * @return array<string, mixed>|null
 */
function fenster_case_study(string $short_slug): ?array
{
    $studies = fenster_case_studies();

    return isset($studies[$short_slug]) && is_array($studies[$short_slug]) ? $studies[$short_slug] : null;
}

/**
 * Build the lightweight card array a case-study card partial renders from.
 *
 * @param string               $short Short slug (no "case-studies/" prefix).
 * @param array<string, mixed> $study Full study entry.
 * @return array<string, mixed>
 */
/**
 * Route segment a study lives under.
 *
 * Commercial work sits at /commercial-projects/, residential at /case-studies/.
 * Owner instruction, 2026-07-28: the two audiences are different and a facilities
 * manager should not have to read past a bungalow to find a hospital. Both use
 * the same renderer, only the base differs.
 */
function fenster_case_study_base(array $study): string
{
    return strtolower((string) ($study['type'] ?? 'Residential')) === 'commercial'
        ? 'commercial-projects'
        : 'case-studies';
}

/**
 * Studies of one type, keyed by short slug.
 *
 * @return array<string, array<string, mixed>>
 */
function fenster_case_studies_of_type(string $type): array
{
    $type = strtolower($type);

    return array_filter(
        fenster_case_studies(),
        static fn (array $study): bool => strtolower((string) ($study['type'] ?? 'Residential')) === $type
    );
}

function fenster_case_study_card(string $short, array $study): array
{
    return [
        'short' => $short,
        'url' => home_url('/' . fenster_case_study_base($study) . '/' . $short . '/'),
        'title' => (string) ($study['title'] ?? ''),
        'location' => (string) ($study['location'] ?? ''),
        'type' => (string) ($study['type'] ?? 'Residential'),
        'summary' => (string) ($study['summary'] ?? ''),
        'image' => is_array($study['card_image'] ?? null)
            ? $study['card_image']
            : (is_array($study['images'][0] ?? null) ? $study['images'][0] : null),
        'products' => is_array($study['products'] ?? null) ? $study['products'] : [],
        'date' => (string) ($study['date'] ?? ''),
        'date_confirmed' => ($study['date_confirmed'] ?? true) !== false,
        'sector' => (string) ($study['sector'] ?? ''),
        'sector_url' => (string) ($study['sector_url'] ?? ''),
        'service' => (string) ($study['service'] ?? ''),
        'service_url' => (string) ($study['service_url'] ?? ''),
    ];
}

/**
 * Case-study cards relevant to a product route.
 *
 * Matches on the products[] links each study already carries, so there is no
 * separate tagging to maintain. Falls back to the newest studies when nothing
 * matches, which keeps the section alive on routes with no direct study yet.
 *
 * @param string $slug  Current page slug, e.g. "casement-windows".
 * @param int    $limit Cards to return.
 * @return array<int, array<string, mixed>> Card arrays for the card partial.
 */
/**
 * Milton Keynes suburbs covered by the location matrix.
 *
 * A study in one MK suburb is still genuine local proof for another, so these
 * routes can share the Milton Keynes studies. Towns outside this list only ever
 * show a study from their own town.
 */
function fenster_milton_keynes_town_slugs(): array
{
    return [
        'bletchley' => true,
        'wolverton' => true,
        'stony-stratford' => true,
        'newport-pagnell' => true,
        'woburn-sands' => true,
        'great-linford' => true,
        'shenley-church-end' => true,
        'furzton' => true,
        'oldbrook' => true,
        'monkston' => true,
        'brooklands' => true,
        'whitehouse' => true,
    ];
}

/**
 * Case-study cards that are genuine local proof for a town route.
 *
 * Matches the study `location` field, exact town first, then the wider Milton
 * Keynes area for MK suburbs. Deliberately returns nothing when there is no
 * honest local match: a Northampton job is not proof of work in Luton, and a
 * filler card would undermine the page rather than support it.
 *
 * COMMERCIAL STUDIES ARE EXCLUDED, for the same reason and by the same owner
 * instruction of 2026-08-11 as `fenster_case_studies_for_product()`. The only
 * caller is `location-service.php`, which is the residential town and product
 * matrix, and its heading reads "Jobs we have finished in <town>" above cards
 * introduced as real installations with our own photographs. A contractor's
 * rail depot is not that, on a page selling windows for somebody's house.
 *
 * THIS WAS LEAKING ON LIVE, verified 2026-08-11 by reading inside the strip
 * markup on `/casement-windows-bletchley/` and `/double-glazing-bletchley/`:
 * both led with the Bletchley rail depot. It reached every MK suburb route as
 * well as the Bletchley ones, because a study whose location carries "Milton
 * Keynes" is treated as area proof for all twelve suburbs. The product helper
 * was filtered on 11 August and this one was missed; it takes the same
 * `$type` argument so a commercial page can ask for commercial proof.
 *
 * Filtering can turn one fault into another, so check what the strip does
 * next: a town whose only match was commercial now renders no strip at all,
 * which is the intended outcome and the same call made for `/aluminium-
 * windows/`. A route showing the wrong proof is worse than a route showing
 * none.
 */
function fenster_case_studies_for_town(string $town_slug, int $limit = 2, string $type = 'residential'): array
{
    $town_slug = sanitize_key($town_slug);
    if ($town_slug === '') {
        return [];
    }

    $studies = function_exists('fenster_case_studies_of_type')
        ? fenster_case_studies_of_type($type)
        : fenster_case_studies();
    $town_words = str_replace('-', ' ', $town_slug);
    $is_mk_suburb = isset(fenster_milton_keynes_town_slugs()[$town_slug]);

    $exact = [];
    $area = [];

    foreach ($studies as $short => $study) {
        $location = strtolower((string) ($study['location'] ?? ''));
        if ($location === '') {
            continue;
        }

        /* WORD BOUNDARIES, NOT A BARE SUBSTRING. `str_contains()` matched
           "bedford" inside "Leighton Buzzard, Bedfordshire", so every Bedford
           route printed "Jobs we have finished in Bedford" over a Leighton
           Buzzard job and the Green Man at Eversholt. Verified on live
           2026-08-12; the heading makes it a false claim of local work rather
           than a loose match. A county name in a `location` field is not a
           town match. */
        if (preg_match('/\b' . preg_quote($town_words, '/') . '\b/', $location) === 1) {
            $exact[$short] = $study;
            continue;
        }

        if ($is_mk_suburb && str_contains($location, 'milton keynes')) {
            $area[$short] = $study;
        }
    }

    $matched = $exact + $area;
    if ($matched === []) {
        return [];
    }

    $cards = [];
    foreach (array_slice($matched, 0, max(1, $limit), true) as $short => $study) {
        $cards[] = fenster_case_study_card((string) $short, $study);
    }

    return $cards;
}

/**
 * Studies for a residential product page.
 *
 * COMMERCIAL STUDIES ARE EXCLUDED, and that is an owner instruction of
 * 2026-08-11: "dont mix commercial case studies with resi product pages". A
 * contractor's rail depot under a heading about real installs on a page selling
 * windows for somebody's house is the wrong proof for the reader in front of
 * it, however good the job was.
 *
 * The filter lives here rather than in per-route gates because every caller of
 * this function is a residential product page — the product journey, casement,
 * roof lanterns and heritage doors — and commercial routes render their own
 * templates, which do not call it. One rule, one place. Pass `commercial` if a
 * commercial page ever needs the same behaviour.
 *
 * This was leaking before the instruction, not only after it: `/aluminium-
 * windows/` was showing three commercial studies and `/flush-casement-windows/`
 * was leading with one.
 *
 * THE FALLBACK NOW TELLS THE CALLER IT HAPPENED, added 2026-08-13 on the owner's
 * ruling: "show all case studies where we dont have any applicable". The cards
 * stay, because a page with no proof at all is worse than a page showing our
 * other work. What was wrong was the CLAIM above them — "Real installs,
 * photographed on the day" over three jobs that are not this product. A caller
 * could not tell the two cases apart, which is why every fix so far has been a
 * hard-coded route exclusion in the caller instead.
 *
 * `$is_fallback` is a by-reference out-parameter with a default, so every
 * existing two-argument and three-argument call keeps working untouched and
 * simply does not ask. Pass a variable and it comes back `true` when the cards
 * are the all-studies fallback rather than a real product match, and the caller
 * can change its heading accordingly.
 *
 * `fenster_case_studies_for_product_group()` below deliberately has no fallback,
 * so it has nothing to signal and is unchanged.
 *
 * @param bool|null $is_fallback Set to true when the cards are the all-studies
 *                               fallback rather than studies claiming this route.
 */
function fenster_case_studies_for_product(string $slug, int $limit = 3, string $type = 'residential', ?bool &$is_fallback = null): array
{
    $is_fallback = false;
    $studies = function_exists('fenster_case_studies_of_type')
        ? fenster_case_studies_of_type($type)
        : fenster_case_studies();
    $target = '/' . trim($slug, '/') . '/';
    $matched = [];

    foreach ($studies as $short => $study) {
        foreach ((array) ($study['products'] ?? []) as $product) {
            $path = (string) wp_parse_url((string) ($product['url'] ?? ''), PHP_URL_PATH);
            if ($path !== '' && rtrim($path, '/') . '/' === $target) {
                $matched[$short] = $study;
                break;
            }
        }
    }

    if ($matched === []) {
        $matched = $studies;
        $is_fallback = true;
    }

    $cards = [];
    foreach (array_slice($matched, 0, max(1, $limit), true) as $short => $study) {
        $cards[] = fenster_case_study_card((string) $short, $study);
    }

    return $cards;
}

/**
 * Case studies matching any product in a group, for the product-selector hubs.
 *
 * Deliberately has no fallback. fenster_case_studies_for_product() returns every
 * study when nothing matches, which is why product pages with no study of their
 * own show unrelated jobs under a heading claiming they are that product. On a
 * hub we would rather render nothing than make that claim.
 *
 * @param string[] $slugs Product route slugs in the group.
 * @return array<int, array<string, mixed>> Case study cards, empty when none match.
 */
function fenster_case_studies_for_product_group(array $slugs, int $limit = 3, string $type = 'residential'): array
{
    if ($slugs === []) {
        return [];
    }

    $targets = [];
    foreach ($slugs as $slug) {
        $targets['/' . trim((string) $slug, '/') . '/'] = true;
    }

    /* Residential BY DEFAULT, same owner instruction as the single-product
       helper above: the three product-selector hubs that call this are
       residential pages. Unlike that one this has no fallback, so filtering here
       simply means a hub shows fewer cards rather than the wrong ones.
     *
     * THE COMMERCIAL ROUTES CALL THIS ONE RATHER THAN THE SINGLE-PRODUCT HELPER,
     * added 2026-08-12, and the missing fallback is exactly why. Ask
     * fenster_case_studies_for_product() for a route nothing claims and it hands
     * back EVERY study — the documented fault that put Winslow secondary glazing
     * under "Real installs" on /tilt-turn-windows/ and three commercial jobs on
     * /aluminium-windows/. On a commercial page that would put a care home under
     * a curtain walling heading. A route with no study of its own renders no
     * strip, which is the right answer. */
    $matched = [];
    $pool = function_exists('fenster_case_studies_of_type')
        ? fenster_case_studies_of_type($type)
        : fenster_case_studies();
    foreach ($pool as $short => $study) {
        foreach ((array) ($study['products'] ?? []) as $product) {
            $path = (string) wp_parse_url((string) ($product['url'] ?? ''), PHP_URL_PATH);
            if ($path === '') {
                continue;
            }

            if (isset($targets[rtrim($path, '/') . '/'])) {
                $matched[$short] = $study;
                break;
            }
        }
    }

    $cards = [];
    foreach (array_slice($matched, 0, max(1, $limit), true) as $short => $study) {
        $cards[] = fenster_case_study_card((string) $short, $study);
    }

    return $cards;
}
