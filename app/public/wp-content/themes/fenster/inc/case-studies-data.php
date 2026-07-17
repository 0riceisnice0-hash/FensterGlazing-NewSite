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

    $cache = [
        'aluminium-bifold-doors-whitehouse-milton-keynes' => [
            'title' => 'Aluminium bifold doors, Whitehouse',
            'location' => 'Whitehouse, Milton Keynes',
            'type' => 'Residential',
            'summary' => 'Slim aluminium bifold doors in anthracite grey, opening the back of a Whitehouse home straight out to the garden.',
            'intro' => 'We supplied and installed a run of slim aluminium bifold doors in anthracite grey, opening the back of this Whitehouse home straight out to the garden.',
            'outcome' => 'Garden opened up',
            'finish' => 'Anthracite grey aluminium',
            'products' => [
                ['label' => 'Aluminium bifold doors', 'url' => home_url('/aluminium-bifold-doors/')],
            ],
            'colour' => ['label' => 'Anthracite grey', 'url' => home_url('/colour-options/')],
            'installed' => [
                'Sheerline aluminium bifold doors',
                'Anthracite grey finish inside and out',
                'Slim sightlines with a low threshold',
                'Double glazed with multi-point locking',
            ],
            'story' => [
                [
                    'label' => 'The brief',
                    'title' => 'Open the house up to the garden',
                    'copy' => 'The owners wanted to connect the back of the house to the garden with a wide, slim-framed door that still felt warm through winter and secure all year round.',
                ],
                [
                    'label' => 'The doors',
                    'title' => 'Slim aluminium bifolds',
                    'copy' => 'We fitted a Sheerline aluminium bifold set. Aluminium keeps the frames slim and strong, so more of the opening is glass and less is frame, and the panels fold neatly back against the wall to leave the whole span clear.',
                ],
                [
                    'label' => 'The colour',
                    'title' => 'Anthracite grey inside and out',
                    'copy' => 'Anthracite grey is one of our most popular finishes and sits well against both brick and render. We matched it inside and out so the doors read as one clean detail from the garden and from the room.',
                ],
                [
                    'label' => 'The result',
                    'title' => 'Light, space and a clean line',
                    'copy' => 'Folded back, the doors give an almost uninterrupted opening between house and garden. Closed, they stay warm and secure with modern double glazing and multi-point locking.',
                ],
            ],
            'images' => [
                ['src' => $img . 'cs-mk-whitehouse-bifold-closed.jpg', 'alt' => 'Anthracite grey aluminium bifold doors closed at the rear of a Whitehouse home in Milton Keynes'],
                ['src' => $img . 'cs-mk-whitehouse-bifold-open.jpg', 'alt' => 'Aluminium bifold doors folded fully open onto the garden'],
                ['src' => $img . 'cs-mk-whitehouse-bifold-half-open.jpg', 'alt' => 'Aluminium bifold doors part-way through folding open'],
            ],
            'seo' => [
                'title_tag' => 'Aluminium Bifold Doors Case Study, Milton Keynes | Fenster Glazing',
                'meta_description' => 'How we supplied and fitted slim anthracite grey aluminium bifold doors for a home in Whitehouse, Milton Keynes, opening the room out to the garden.',
            ],
        ],

        'upvc-casement-windows-broughton-milton-keynes' => [
            'title' => 'uPVC casement windows, Broughton',
            'location' => 'Broughton, Milton Keynes',
            'type' => 'Residential',
            'summary' => 'A two-tone Liniar casement replacement in Broughton, turning a boarded-up opening back into a warm, secure window.',
            'intro' => 'We replaced the failed windows on this Broughton home with two-tone Liniar casements, basalt grey outside and white inside, and turned a boarded-up opening back into a proper window.',
            'outcome' => 'Boarded-up opening fixed',
            'finish' => 'Basalt grey outside, white inside',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'Basalt grey (RAL 7012)', 'url' => home_url('/colour-options/')],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Basalt grey (RAL 7012) outside, white inside',
                'Energy efficient double glazing',
                'Multi-point locking throughout',
            ],
            'story' => [
                [
                    'label' => 'The brief',
                    'title' => 'Replace failing windows, one boarded up',
                    'copy' => 'One of the front openings had been boarded up and the rest were tired and draughty. The owners wanted secure, energy efficient windows that lifted the look of the front of the house.',
                ],
                [
                    'label' => 'The windows',
                    'title' => 'Liniar casement windows',
                    'copy' => 'We fitted Liniar EnergyPlus casement windows. They are low maintenance, thermally efficient and lock at several points around the frame, so the house is warmer and more secure than the units they replaced.',
                ],
                [
                    'label' => 'The colour',
                    'title' => 'Two-tone: grey outside, white inside',
                    'copy' => 'The owners chose a basalt grey (RAL 7012) exterior for a modern kerbside look, with a white interior so the rooms stay bright and neutral. Two-tone finishes like this are a popular way to get a contemporary outside without a dark room inside.',
                ],
                [
                    'label' => 'The result',
                    'title' => 'A sharper, warmer frontage',
                    'copy' => 'The boarded opening is a proper window again, the frontage looks sharper from the street, and the rooms behind hold their heat far better.',
                ],
            ],
            'images' => [
                ['src' => $img . 'cs-mk-broughton-casement-after.jpg', 'alt' => 'New basalt grey uPVC casement windows on a Broughton home in Milton Keynes'],
                ['src' => $img . 'cs-mk-broughton-casement-before.jpg', 'alt' => 'The same home before, showing a boarded-up window opening'],
                ['src' => $img . 'cs-mk-broughton-casement-inside.jpg', 'alt' => 'The new casement window seen from inside, showing the white interior frame'],
                ['src' => $img . 'cs-mk-broughton-casement-side.jpg', 'alt' => 'Close side view of the basalt grey casement frame'],
            ],
            'seo' => [
                'title_tag' => 'uPVC Casement Windows Case Study, Milton Keynes | Fenster Glazing',
                'meta_description' => 'How we replaced failing windows, including a boarded-up opening, with two-tone Liniar casement windows for a home in Broughton, Milton Keynes.',
            ],
        ],

        'flush-casement-and-slide-fold-doors-leighton-buzzard' => [
            'title' => 'Flush windows and slide and fold doors, Leighton Buzzard',
            'location' => 'Leighton Buzzard, Bedfordshire',
            'type' => 'Residential',
            'summary' => 'A full package for a Leighton Buzzard home: flush casement windows and a uPVC slide and fold door that opens the room right out.',
            'intro' => 'We supplied and installed a full window and door package for this Leighton Buzzard home, pairing flush casement windows with a uPVC slide and fold door that opens the whole span.',
            'outcome' => 'Windows and doors together',
            'finish' => 'Clean flush frames',
            'products' => [
                ['label' => 'Flush casement windows', 'url' => home_url('/flush-casement-windows/')],
                ['label' => 'Slide and fold doors', 'url' => home_url('/slide-fold-doors/')],
            ],
            'colour' => null,
            'installed' => [
                'Liniar flush casement windows',
                'uPVC slide and fold door',
                'Flush, timber-style sightlines',
                'Energy efficient double glazing',
            ],
            'story' => [
                [
                    'label' => 'The brief',
                    'title' => 'One team for windows and doors',
                    'copy' => 'The owners wanted their windows and their patio opening handled together, with a consistent look across the back of the house and a wide door that could open the room out to the garden.',
                ],
                [
                    'label' => 'The windows',
                    'title' => 'Flush casement windows',
                    'copy' => 'We fitted flush casement windows, where the sash sits level with the frame for a clean, timber-style line. They give the property a smart, understated look while keeping the low maintenance and thermal performance of modern uPVC.',
                ],
                [
                    'label' => 'The doors',
                    'title' => 'A slide and fold door',
                    'copy' => 'For the main opening we installed a uPVC slide and fold door. The panels fold and slide back to one side, so the room opens right out in good weather and closes down to a warm, secure wall of glass the rest of the year.',
                ],
                [
                    'label' => 'The result',
                    'title' => 'A joined-up finish',
                    'copy' => 'Windows and doors were surveyed and fitted as one package, so the back of the house reads as a single, considered design rather than a set of separate jobs.',
                ],
            ],
            'images' => [
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-closed.jpg', 'alt' => 'uPVC slide and fold door closed at the rear of a Leighton Buzzard home'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-opening.jpg', 'alt' => 'The slide and fold door part-way through opening'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-open.jpg', 'alt' => 'The slide and fold door folded fully open onto the garden'],
                ['src' => $img . 'cs-leighton-buzzard-slide-fold-side.jpg', 'alt' => 'Side view of the folded slide and fold door panels'],
                ['src' => $img . 'cs-leighton-buzzard-flush-casement.jpg', 'alt' => 'Flush casement windows fitted to the same home'],
                ['src' => $img . 'cs-leighton-buzzard-flush-casement-side.jpg', 'alt' => 'Side view of a flush casement window showing the level sash and frame'],
            ],
            'seo' => [
                'title_tag' => 'Flush Windows and Slide and Fold Doors Case Study | Fenster Glazing',
                'meta_description' => 'How we fitted flush casement windows and a uPVC slide and fold door as one package for a home in Leighton Buzzard, Bedfordshire.',
            ],
        ],

        'upvc-casement-windows-leighton-buzzard' => [
            'title' => 'uPVC casement windows, Leighton Buzzard',
            'location' => 'Leighton Buzzard, Bedfordshire',
            'type' => 'Residential',
            'summary' => 'A crisp white Liniar casement replacement in Leighton Buzzard, warmer and more secure inside and out.',
            'intro' => 'We replaced the windows on this Leighton Buzzard home with white Liniar EnergyPlus casements, for a crisp finish and a warmer, more secure home.',
            'outcome' => 'Warmer, brighter rooms',
            'finish' => 'Crisp white uPVC',
            'products' => [
                ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
            ],
            'colour' => ['label' => 'White', 'url' => home_url('/colour-options/')],
            'installed' => [
                'Liniar EnergyPlus casement windows',
                'Crisp white finish',
                'Energy efficient double glazing',
                'Multi-point locking with quality handles',
            ],
            'story' => [
                [
                    'label' => 'The brief',
                    'title' => 'A clean, energy efficient replacement',
                    'copy' => 'The owners wanted a straightforward, well-fitted set of white windows that would make the rooms brighter and hold their heat better than the old units.',
                ],
                [
                    'label' => 'The windows',
                    'title' => 'Liniar casement windows',
                    'copy' => 'We fitted Liniar EnergyPlus casement windows in white. They open on quality hardware, lock at several points around the frame and use energy efficient double glazing to keep the rooms comfortable.',
                ],
                [
                    'label' => 'The detail',
                    'title' => 'Hardware that feels right',
                    'copy' => 'Small details matter on a window you use every day. The handles operate smoothly through open and locked positions, and the frames are low maintenance and easy to keep clean.',
                ],
                [
                    'label' => 'The result',
                    'title' => 'Brighter rooms, warmer home',
                    'copy' => 'The finished windows give the house a crisp, tidy look from the street and noticeably warmer, brighter rooms inside.',
                ],
            ],
            'images' => [
                ['src' => $img . 'cs-leighton-buzzard-casement-front.jpg', 'alt' => 'White uPVC casement windows on a Leighton Buzzard home'],
                ['src' => $img . 'cs-leighton-buzzard-casement-inside.jpg', 'alt' => 'The new white casement window seen from inside a room'],
                ['src' => $img . 'cs-leighton-buzzard-casement-street.jpg', 'alt' => 'Street view of the home with its new white windows'],
                ['src' => $img . 'cs-leighton-buzzard-casement-handle-open.jpg', 'alt' => 'The casement window handle in the open position'],
                ['src' => $img . 'cs-leighton-buzzard-casement-handle-closed.jpg', 'alt' => 'The casement window handle in the closed and locked position'],
            ],
            'seo' => [
                'title_tag' => 'uPVC Casement Windows Case Study, Leighton Buzzard | Fenster Glazing',
                'meta_description' => 'How we replaced tired windows with crisp white Liniar casement windows for a home in Leighton Buzzard, for warmer, brighter rooms.',
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
