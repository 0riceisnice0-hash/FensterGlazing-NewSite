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
                'With modern double glazing the window reaches a 0.95 W/m²K U-value and locks with a PAS 24 security option, so the room behind it is warmer, quieter and far more secure than the boarded opening it replaced.',
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
                'The multi-chambered profile and co-extruded bubble gasket help seal the frame against draughts and rain. With modern double glazing the windows reach a 0.95 W/m²K U-value and an A+ energy rating, with a PAS 24 security option available as part of the Liniar specification.',
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
                'The owners wanted a straightforward, well-fitted set of white windows that would make the rooms brighter and hold their heat far better than the old units. We fitted <a href="' . $casement . '">uPVC casement windows</a> on the 70mm Liniar EnergyPlus system, which is A+ rated and reaches a 0.95 W/m²K U-value with modern double glazing.',
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
function fenster_case_study_card(string $short, array $study): array
{
    return [
        'short' => $short,
        'url' => home_url('/case-studies/' . $short . '/'),
        'title' => (string) ($study['title'] ?? ''),
        'location' => (string) ($study['location'] ?? ''),
        'type' => (string) ($study['type'] ?? 'Residential'),
        'summary' => (string) ($study['summary'] ?? ''),
        'image' => is_array($study['card_image'] ?? null)
            ? $study['card_image']
            : (is_array($study['images'][0] ?? null) ? $study['images'][0] : null),
        'products' => is_array($study['products'] ?? null) ? $study['products'] : [],
        'date' => (string) ($study['date'] ?? ''),
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
