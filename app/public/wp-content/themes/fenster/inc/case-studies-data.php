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
    $colour = esc_url(home_url('/colour-options/'));
    $team = esc_url(home_url('/meet-the-team/'));
    $team_img = FENSTER_THEME_URI . '/assets/images/imported/';

    $cache = [
        'aluminium-bifold-doors-whitehouse-milton-keynes' => [
            'title' => 'Aluminium bifold doors, Whitehouse',
            'location' => 'Whitehouse, Milton Keynes',
            'type' => 'Residential',
            'summary' => 'Slim anthracite grey aluminium bifold doors opening the back of a Whitehouse home out to the garden.',
            'lead' => 'We opened up the back of this Whitehouse home with a run of slim aluminium bifold doors in anthracite grey, folding the whole opening back to the garden.',
            'products' => [
                ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/')],
            ],
            'colour' => ['label' => 'Anthracite grey', 'url' => home_url('/colour-options/')],
            'specs' => [
                ['label' => 'Product', 'value' => 'Aluminium bifold doors'],
                ['label' => 'System', 'value' => 'Sheerline Prestige aluminium'],
                ['label' => 'Colour', 'value' => 'Anthracite grey, inside and out'],
                ['label' => 'U-value', 'value' => '1.0 W/m²K'],
            ],
            'overview' => [
                'The owners wanted to open the back of the house right up to the garden, without losing warmth or security once the doors were shut. We fitted <a href="' . $bifold . '">aluminium bifold doors</a> from the Sheerline Prestige system, which uses thermally broken aluminium frames with ultra slim sightlines, so almost all of the opening is glass rather than frame.',
                'The doors fold back against the wall to leave a clear span, with a main traffic door for everyday garden access without opening the full run. A low threshold keeps the step between inside and out to a minimum. Closed, the frames reach a 1.0 W/m²K U-value and lock at several points, so the room stays warm and secure through winter.',
                'We finished the frames in <a href="' . $colour . '">anthracite grey</a> inside and out, one of the most popular choices for a modern look that sits well against both brick and render. Sheerline aluminium can be powder coated in any RAL colour if a different shade suits the property.',
            ],
            'installed' => [
                'Sheerline Prestige aluminium bifold doors',
                'Anthracite grey finish, inside and out',
                'Slim sightlines with a low threshold',
                'Double glazed, multi-point locking with a main traffic door',
            ],
            'installers' => [
                ['name' => 'Tom Carter', 'role' => 'Installer', 'image' => $team_img . 'unnamed-8.jpg', 'url' => home_url('/meet-the-team/')],
                ['name' => 'Johnnie Greenwell', 'role' => 'Installer', 'image' => $team_img . '1.png', 'url' => home_url('/meet-the-team/')],
            ],
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
            'title' => 'uPVC casement windows, Broughton',
            'location' => 'Broughton, Milton Keynes',
            'type' => 'Residential',
            'summary' => 'A two-tone Liniar casement replacement in Broughton, turning a boarded-up opening back into a warm, secure window.',
            'lead' => 'We replaced the failed windows on this Broughton home, including a boarded-up opening, with two-tone Liniar casements: basalt grey outside and white inside.',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'Basalt grey (RAL 7012)', 'url' => home_url('/colour-options/')],
            'specs' => [
                ['label' => 'Product', 'value' => 'uPVC casement windows'],
                ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'Basalt grey outside, white inside'],
                ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
            ],
            'overview' => [
                'One of the front openings had been boarded up and the rest of the windows were tired and draughty. We fitted <a href="' . $casement . '">uPVC casement windows</a> using the 70mm Liniar EnergyPlus system, an A+ rated, multi-chambered profile with a co-extruded bubble gasket that seals continuously around the frame against draughts and driving rain.',
                'With modern double glazing the windows reach a 0.95 W/m²K U-value and lock at several points with a PAS 24 security option, so the house is warmer and far more secure than the units they replaced. We combined side and top opening sashes to suit each room.',
                'The owners chose a two-tone finish: <a href="' . $colour . '">basalt grey (RAL 7012)</a> on the outside for a contemporary kerbside look, with a white interior so the rooms stay bright and neutral. It is a popular way to get a dark modern frontage without darkening the room inside.',
            ],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Basalt grey (RAL 7012) outside, white inside',
                'A+ rated, energy efficient double glazing',
                'Multi-point locking with a PAS 24 option',
            ],
            'images' => [
                ['src' => $img . 'cs-mk-broughton-casement-after.jpg', 'caption' => 'The finished frontage, with the new basalt grey casements shown from the same angle as before.'],
                ['src' => $img . 'cs-mk-broughton-casement-before.jpg', 'caption' => 'The same elevation beforehand, with one window opening boarded up.'],
                ['src' => $img . 'cs-mk-broughton-casement-inside.jpg', 'caption' => 'Seen from inside, the frames are white so the room stays bright and neutral.'],
                ['src' => $img . 'cs-mk-broughton-casement-side.jpg', 'caption' => 'A closer side view of the basalt grey outer frame and glazing.'],
            ],
            'seo' => [
                'title_tag' => 'uPVC Casement Windows Case Study, Milton Keynes | Fenster Glazing',
                'meta_description' => 'A real Fenster project in Broughton, Milton Keynes: two-tone Liniar casement windows replacing failing units, including a boarded-up opening.',
            ],
        ],

        'flush-casement-and-slide-fold-doors-leighton-buzzard' => [
            'title' => 'Flush windows and slide and fold doors, Leighton Buzzard',
            'location' => 'Leighton Buzzard, Bedfordshire',
            'type' => 'Residential',
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
            'summary' => 'A crisp white Liniar casement replacement in Leighton Buzzard, for warmer, brighter rooms and a tidier frontage.',
            'lead' => 'We replaced the windows on this Leighton Buzzard home with crisp white Liniar casements, for warmer, brighter rooms and a tidier frontage.',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'White', 'url' => home_url('/colour-options/')],
            'specs' => [
                ['label' => 'Product', 'value' => 'uPVC casement windows'],
                ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
                ['label' => 'Colour', 'value' => 'White (16 options available)'],
                ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
            ],
            'overview' => [
                'The owners wanted a straightforward, well-fitted set of white windows that would make the rooms brighter and hold their heat far better than the old units. We fitted <a href="' . $casement . '">uPVC casement windows</a> on the 70mm Liniar EnergyPlus system, which is A+ rated and reaches a 0.95 W/m²K U-value with modern double glazing.',
                'A co-extruded bubble gasket seals continuously around each frame against draughts and rain, and the windows lock at several points with a PAS 24 security option. We combined side and top opening sashes to suit each room, on smooth, quality hardware.',
                'The frames are finished in classic <a href="' . $colour . '">white</a>, which keeps the frontage clean and bright, though the same window is available in 16 colours and foiled woodgrain finishes. uPVC frames never need repainting and simply wipe clean.',
            ],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Crisp white finish',
                'A+ rated, energy efficient double glazing',
                'Multi-point locking with quality handles',
            ],
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
    ];

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
