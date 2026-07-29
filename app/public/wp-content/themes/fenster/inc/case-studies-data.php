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
    $team = esc_url(home_url('/meet-the-team/'));
    $team_img = FENSTER_THEME_URI . '/assets/images/imported/';

    // Colour hub deep links pre-select the swatch and scroll to its material.
    $colour_link = static fn (string $material, string $slug): string => home_url('/colour-options/?material=' . $material . '&colour=' . $slug);
    $colour_basalt = $colour_link('upvc', 'basalt-grey');
    $colour_anthracite = $colour_link('aluminium', 'anthracite-grey');
    $colour_anthracite_upvc = $colour_link('upvc', 'anthracite-grey');
    $colour_white = $colour_link('upvc', 'white');

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

    $cache = [
        /*
         * Headrow Court is the first Commercial entry in this system; the other
         * commercial studies still sit in the legacy pages.json records. Project
         * facts (108 studios, £12.5m, 16 months, four former office buildings,
         * completed October 2025) are the main contractor's own published figures,
         * and the scope line is deliberately narrow: Fortis Vision replaced the
         * whole facade, we did the aluminium windows within it. Do not widen that
         * into a claim that we delivered the scheme.
         *
         * Photography is by Ben Harrison Photography, supplied through Fortis
         * Vision. Credit is kept in the caption. Confirm the licence covers our
         * own marketing use before this goes to production.
         */
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
                'Headrow Court sits opposite Leeds Town Hall, and until recently it was four separate office buildings. Fortis Vision took the scheme on as main contractor for a £12.5m, sixteen month conversion into 108 purpose built student studios with reception, study and dining space, finishing in October 2025.',
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
                ['src' => $team_img . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg', 'caption' => 'Roka Dental, Woburn Sands, after the doors were fitted.'],
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
            'summary' => 'A full package for a Leighton Buzzard home: flush casement windows and a uPVC slide and fold door that opens the room right out.',
            'lead' => 'We handled the windows and the main garden opening together for this Leighton Buzzard home, pairing flush casement windows with a uPVC slide and fold door.',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/')],
                ['label' => 'Slide and fold doors', 'url' => home_url('/slide-fold-doors/')],
            ],
            'colour' => null,
            'specs' => [
                ['label' => 'Products', 'value' => 'Flush casement windows and a slide and fold door'],
                ['label' => 'Window system', 'value' => 'Liniar 70mm flush sash uPVC'],
                ['label' => 'Windows', 'value' => 'A+ rated, timber-style flush line'],
                ['label' => 'Door security', 'value' => '10-point locking'],
            ],
            'overview' => [
                'The owners wanted a consistent look across the back of the house, so we surveyed and fitted the windows and the door as one package. The windows are <a href="' . $flush . '">flush casement windows</a> on the Liniar 70mm flush sash system, where the sash sits level with the outer frame for a flatter, timber-style line, with A+ rated performance.',
                'For the main opening we installed a <a href="' . $slidefold . '">uPVC slide and fold door</a>. Unlike a standard bifold, the panels slide and swing independently, so one section can open for everyday access or the whole run can fold back in good weather. A main traffic-door leaf works like a normal door, and interlocking panels with 10-point locking close it down to a secure wall of glass.',
                'Handling both products together meant the sightlines, colour and glazing match across the elevation, so the back of the house reads as one considered design rather than separate jobs.',
            ],
            'installed' => [
                'Liniar flush casement windows',
                'uPVC slide and fold door with a main traffic leaf',
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
                'meta_description' => 'A real Fenster project in Leighton Buzzard: flush casement windows and a uPVC slide and fold door fitted together as one package.',
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
 */
function fenster_case_studies_for_town(string $town_slug, int $limit = 2): array
{
    $town_slug = sanitize_key($town_slug);
    if ($town_slug === '') {
        return [];
    }

    $studies = fenster_case_studies();
    $town_words = str_replace('-', ' ', $town_slug);
    $is_mk_suburb = isset(fenster_milton_keynes_town_slugs()[$town_slug]);

    $exact = [];
    $area = [];

    foreach ($studies as $short => $study) {
        $location = strtolower((string) ($study['location'] ?? ''));
        if ($location === '') {
            continue;
        }

        if (str_contains($location, $town_words)) {
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

function fenster_case_studies_for_product(string $slug, int $limit = 3): array
{
    $studies = fenster_case_studies();
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
function fenster_case_studies_for_product_group(array $slugs, int $limit = 3): array
{
    if ($slugs === []) {
        return [];
    }

    $targets = [];
    foreach ($slugs as $slug) {
        $targets['/' . trim((string) $slug, '/') . '/'] = true;
    }

    $matched = [];
    foreach (fenster_case_studies() as $short => $study) {
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
