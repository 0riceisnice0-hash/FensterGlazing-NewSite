<?php
/**
 * Structured content for the dedicated window product pages.
 *
 * Product facts are distilled from the Liniar and Sheerline manufacturer
 * literature held in the project research archive. Installation language,
 * product availability and final specification remain Fenster-owned.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Return the shared window product-page data.
 *
 * @return array<string, array<string, mixed>>
 */
function fenster_window_product_pages(): array
{
    $upvc_choices = [
        ['title' => 'Colour and foil', 'copy' => 'Compare solid colours, woodgrain foils and dual-colour combinations.', 'url' => '/upvc-colours/'],
        ['title' => 'Privacy glass', 'copy' => 'See the available obscurity levels before choosing glass for each room.', 'url' => '/obscured-glass/'],
        ['title' => 'Handles', 'copy' => 'Compare contemporary, traditional and colour-matched window furniture.', 'url' => '/window-handles/'],
    ];
    $aluminium_choices = [
        ['title' => 'Powder-coated colour', 'copy' => 'Start with the 12 stocked Sheerline finishes, then ask about bespoke colour options.', 'url' => '/aluminium-colours/'],
        ['title' => 'Privacy glass', 'copy' => 'Choose the obscurity level room by room without changing the window style.', 'url' => '/obscured-glass/'],
        ['title' => 'Handles', 'copy' => 'Match the handle finish to the frame, glass and surrounding ironmongery.', 'url' => '/window-handles/'],
    ];

    return [
        'casement-windows' => [
            'eyebrow' => 'Liniar uPVC windows',
            'title' => 'uPVC casement windows',
            'lead' => 'Casement windows are the flexible starting point for most homes. We combine fixed panes with side-hung and top-hung openings, then confirm the glass, ventilation and hardware room by room.',
            'hero' => 'casement/casement-stone-cottage-1600w.webp',
            'hero_alt' => 'White uPVC casement windows fitted to a stone cottage',
            'reassurance' => ['Opening layout checked room by room', 'EnergyPlus multi-chamber uPVC system', 'Measured, supplied and fitted locally'],
            'facts' => [
                ['value' => '70mm', 'label' => 'Liniar EnergyPlus frame depth'],
                ['value' => 'Side or top hung', 'label' => 'Opening positions can be mixed with fixed panes'],
                ['value' => 'Up to A++', 'label' => 'Energy rating depends on the complete glass and frame specification'],
                ['value' => 'PAS 24 option', 'label' => 'Security specification available where required'],
            ],
            'selector' => [
                'eyebrow' => 'Plan the openings',
                'title' => 'Choose how each pane needs to work.',
                'intro' => 'The outside appearance can stay balanced while the opening pattern changes to suit furniture, access, ventilation and escape requirements.',
                'options' => [
                    ['title' => 'Side hung', 'kicker' => 'Full opening', 'copy' => 'A hinged side opening gives the clearest route for ventilation and cleaning. We check the swing against curtains, blinds and outside obstructions.', 'image' => 'casement/casement-open-brick-1400w.webp', 'alt' => 'Open side-hung uPVC casement window'],
                    ['title' => 'Top hung', 'kicker' => 'Controlled ventilation', 'copy' => 'A top-hung opener is useful above furniture or in a smaller pane. Restrictors can be discussed where opening control matters.', 'image' => 'casement/casement-sill-interior-1200w.webp', 'alt' => 'Casement window viewed from the interior sill'],
                    ['title' => 'Fixed and mixed', 'kicker' => 'More glass, fewer openings', 'copy' => 'Fixed panes reduce visible hardware. Combine them with the openings a room actually needs rather than making every pane open.', 'image' => 'window-systems/liniar-casement-window.webp', 'alt' => 'Liniar casement window configuration'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'Frame and glass', 'title' => 'Specify the complete window, not one headline number.', 'copy' => 'The EnergyPlus frame uses multi-chamber uPVC construction. The finished U-value and energy rating also depend on the sealed unit, spacer bar, reinforcement, size and opening layout, so we confirm performance against the actual design.', 'image' => 'casement/casement-handle-detail-1400w.webp', 'alt' => 'Close view of a casement frame, gasket and handle'],
                ['eyebrow' => 'Room-by-room detail', 'title' => 'Ventilation, privacy and access are separate decisions.', 'copy' => 'A bathroom may need privacy glass and controlled ventilation. A bedroom may need an escape opening. A landing may only need light. We schedule those differences before the order is signed off.', 'image' => 'casement/casement-sill-interior-1200w.webp', 'alt' => 'Interior view through a white casement window'],
            ],
            'system' => [
                'label' => 'Liniar EnergyPlus',
                'title' => 'A 70mm uPVC system with flexible opening layouts.',
                'copy' => 'EnergyPlus is the Liniar casement platform used for standard side-hung, top-hung and fixed configurations. Multi-chamber profiles, co-extruded gaskets and the chosen glazing specification work together as one window.',
                'image' => 'window-systems/liniar-casement-window.webp',
                'alt' => 'Liniar casement window shown against a neutral background',
                'specs' => [['Frame', '70mm EnergyPlus uPVC'], ['Openings', 'Side hung, top hung and fixed'], ['Glazing', 'Double or triple glazing, subject to design'], ['Security', 'PAS 24 specification available']],
            ],
            'choices' => $upvc_choices,
            'faqs' => [
                ['q' => 'Which way should a casement window open?', 'a' => 'It depends on access, furniture, ventilation and any escape requirement. We mark the handing and opening direction on the final schedule before manufacture.'],
                ['q' => 'Can fixed and opening panes be combined?', 'a' => 'Yes. A casement frame can combine fixed panes with side-hung and top-hung openings to keep the elevation balanced.'],
                ['q' => 'Can casement windows use triple glazing?', 'a' => 'Yes, subject to pane size, weight and the chosen configuration. We confirm the complete glass and hardware specification rather than treating triple glazing as an automatic upgrade.'],
                ['q' => 'Are trickle vents always required?', 'a' => 'Not in every situation, but replacement and new-build work must meet the applicable ventilation requirements. We check this before the windows are ordered.'],
                ['q' => 'Can I use a different colour inside and outside?', 'a' => 'Dual-colour and foil combinations are available within the selected Liniar colour range. Availability can vary by profile and component.'],
            ],
            'quote_label' => 'Design and price uPVC windows',
            'project_type' => 'uPVC casement windows',
        ],
        'flush-casement-windows' => [
            'eyebrow' => 'Liniar flush sash windows',
            'title' => 'uPVC flush casement windows',
            'lead' => 'A flush sash closes in line with the outside face of the frame. That simple change gives a flatter elevation while keeping the insulation, glazing and everyday care of a modern uPVC window.',
            'hero' => 'flush-casement/flush-stone-elevation-1600w.webp',
            'hero_alt' => 'Flush casement windows fitted to a stone house',
            'reassurance' => ['Flush outside face', 'Mechanical joint option for a timber-style finish', 'Surveyed and specified before manufacture'],
            'facts' => [
                ['value' => '70mm', 'label' => 'Liniar flush sash system'],
                ['value' => '1.2 W/m²K', 'label' => 'Published whole-window U-value, configuration dependent'],
                ['value' => 'A+', 'label' => 'Published energy rating'],
                ['value' => 'PAS 24', 'label' => 'Security specification available'],
            ],
            'selector' => [
                'eyebrow' => 'Compare the outside face',
                'title' => 'Flush sash or projecting casement?',
                'intro' => 'Both are modern uPVC windows. The difference is the way the opening sash sits against the outer frame when it is closed.',
                'options' => [
                    ['title' => 'Flush sash', 'kicker' => 'One flat outside plane', 'copy' => 'The closed sash aligns with the outside frame. This suits restrained elevations, older properties and projects where the frame detail should stay quiet.', 'image' => 'flush-casement/flush-frame-detail-1200w.webp', 'alt' => 'Close-up of a flush casement window frame'],
                    ['title' => 'Mechanical joints', 'kicker' => 'A more traditional corner', 'copy' => 'Mechanical jointing can create a straighter timber-style corner rather than a fully welded appearance. We confirm which joints and foils are available together.', 'image' => 'flush-casement/flush-dual-colour-closeup-1200w.webp', 'alt' => 'Close-up of a dual-colour flush window corner'],
                    ['title' => 'Standard casement', 'kicker' => 'Projecting opening sash', 'copy' => 'A standard casement sash sits forward of the frame. Choose it where the flatter flush face is not part of the design brief.', 'image' => 'window-systems/liniar-flush-profile.webp', 'alt' => 'Liniar flush sash window shown from outside'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'The visual difference', 'title' => 'The flush detail is clearest across a whole elevation.', 'copy' => 'Colour, joint style, glazing bars and the balance between fixed and opening panes all affect the result. We set those details together so one window does not look disconnected from the next.', 'image' => 'flush-casement/flush-oak-dormers-1400w.webp', 'alt' => 'Woodgrain flush casement windows fitted to dormers'],
                ['eyebrow' => 'Inside and outside', 'title' => 'A traditional outside face can have a different inside finish.', 'copy' => 'Dual-colour options allow a foil outside and a lighter finish inside. The available pairing depends on the frame, sash and joint specification, so it is checked before order.', 'image' => 'flush-casement/flush-grey-interior-1400w.webp', 'alt' => 'Grey flush casement window viewed from indoors'],
            ],
            'system' => [
                'label' => 'Liniar flush sash',
                'title' => 'A flush 70mm sash with modern seals and glazing.',
                'copy' => 'The Liniar flush sash uses a co-extruded bubble gasket and can be specified with mechanically jointed corners. Published performance reaches an A+ rating and a 1.2 W/m²K whole-window U-value for the tested configuration.',
                'image' => 'window-systems/liniar-flush-profile.webp',
                'alt' => 'White Liniar flush sash window product view',
                'specs' => [['Outside face', 'Sash closes flush with the outer frame'], ['Frame', '70mm uPVC platform'], ['Published performance', 'A+ and 1.2 W/m²K, configuration dependent'], ['Security', 'PAS 24 and Secured by Design options']],
            ],
            'choices' => $upvc_choices,
            'faqs' => [
                ['q' => 'What makes a flush casement window flush?', 'a' => 'When closed, the opening sash aligns with the outside face of the frame instead of projecting forward like a standard casement sash.'],
                ['q' => 'Do flush casement windows look like timber?', 'a' => 'The flat sash, woodgrain foils, glazing bars and mechanical joint options can create a more traditional appearance, but the window remains a modern uPVC system.'],
                ['q' => 'Can flush windows be used in a bay?', 'a' => 'Yes. The Liniar flush system can be configured for bow and bay arrangements, subject to the survey, support and connector design.'],
                ['q' => 'Are flush casement windows secure?', 'a' => 'PAS 24 and Secured by Design specifications are available. The final security level depends on the complete frame, glass and hardware schedule.'],
                ['q' => 'Can the inside be white if the outside is coloured?', 'a' => 'Often, yes. Dual-colour combinations are available, but the exact foil pairing must be checked against the selected profiles and joints.'],
            ],
            'quote_label' => 'Design and price flush windows',
            'project_type' => 'Flush casement windows',
        ],
        'french-casement-windows' => [
            'eyebrow' => 'Liniar French windows',
            'title' => 'French casement windows',
            'lead' => 'French casements use two opening leaves without a fixed centre bar. Open the main leaf for everyday ventilation or release both leaves when you need the full width.',
            'hero' => 'french-casement/french-casement-bedroom-1400w.webp',
            'hero_alt' => 'French casement window open in a bedroom',
            'reassurance' => ['Clear opening without a fixed centre mullion', 'Handing and escape requirements checked', 'Built on the Liniar 70mm platform'],
            'facts' => [
                ['value' => 'Two opening leaves', 'label' => 'Main and slave sash arrangement'],
                ['value' => 'No fixed centre bar', 'label' => 'Clear opening when both leaves are released'],
                ['value' => '70mm', 'label' => 'Liniar uPVC platform'],
                ['value' => 'Room checked', 'label' => 'Handing, restrictors and escape use confirmed at survey'],
            ],
            'selector' => [
                'eyebrow' => 'How it opens',
                'title' => 'One leaf for daily use. Both when you need the space.',
                'intro' => 'The main sash carries the everyday handle. The second sash releases after the first, leaving the centre open.',
                'options' => [
                    ['title' => 'Main leaf', 'kicker' => 'Everyday ventilation', 'copy' => 'Use the primary sash like a normal side-hung casement. We confirm whether it should be left or right handed.', 'image' => 'french-casement/french-casement-bedroom-1400w.webp', 'alt' => 'French casement with the main leaf open'],
                    ['title' => 'Both leaves', 'kicker' => 'Clear centre opening', 'copy' => 'Release the second leaf to remove the centre obstruction. This can help with access, cleaning and escape layouts.', 'image' => 'window-systems/liniar-french-window.webp', 'alt' => 'White French window with both leaves open'],
                    ['title' => 'Restricted opening', 'kicker' => 'Control where needed', 'copy' => 'Safety restrictors and suitable hardware can be discussed for upper floors and rooms where opening control matters.', 'image' => 'casement/casement-handle-detail-1400w.webp', 'alt' => 'Casement window handle and frame detail'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'Before manufacture', 'title' => 'The handing is part of the specification.', 'copy' => 'We record which leaf opens first, which way both leaves swing and how they sit against curtains, furniture and the outside reveal. That avoids treating a French window as a standard pair of casements.', 'image' => 'window-systems/liniar-french-window.webp', 'alt' => 'Liniar French window with a clear centre opening'],
                ['eyebrow' => 'Escape and ventilation', 'title' => 'A wide opening still needs the right hardware.', 'copy' => 'Where the window is intended for escape, the clear opening has to work in the real reveal. We also check restrictors, ventilation and accessible handle height for the room.', 'image' => 'french-casement/french-casement-bedroom-1400w.webp', 'alt' => 'Open French casement in a finished room'],
            ],
            'system' => [
                'label' => 'Liniar French window',
                'title' => 'Two sashes built into one 70mm uPVC frame.',
                'copy' => 'Liniar describes a French window as two panes that open from the centre without a fixed obstruction. The frame, sealed units and hardware are specified as one complete opening.',
                'image' => 'window-systems/liniar-french-window.webp',
                'alt' => 'Liniar French window product photograph',
                'specs' => [['Arrangement', 'Main leaf plus secondary leaf'], ['Centre', 'No fixed mullion when both leaves open'], ['Frame', '70mm Liniar uPVC platform'], ['Options', 'Restrictors, privacy glass and trickle ventilation as required']],
            ],
            'choices' => $upvc_choices,
            'faqs' => [
                ['q' => 'What is a French casement window?', 'a' => 'It is a pair of opening sashes with no fixed centre mullion. The secondary sash releases after the main sash to leave a clear central opening.'],
                ['q' => 'Do both sides have a normal handle?', 'a' => 'The main sash has the everyday handle. The secondary sash normally uses internal shoot-bolt controls that are reached after the first sash is open.'],
                ['q' => 'Can a French window be used as a fire escape?', 'a' => 'It can help provide a wide clear opening, but compliance depends on the actual clear dimensions, height and location. We check the intended use at survey.'],
                ['q' => 'Can the leaves be restricted?', 'a' => 'Suitable restrictors can be specified where opening control is needed. The release and escape requirements must be considered at the same time.'],
                ['q' => 'Can French casements match the other uPVC windows?', 'a' => 'Yes. They can use the same Liniar profile family, colour, glass and handle finish as surrounding casement windows.'],
            ],
            'quote_label' => 'Design and price French windows',
            'project_type' => 'French casement windows',
        ],
        'tilt-turn-windows' => [
            'eyebrow' => 'Liniar dual-opening windows',
            'title' => 'Tilt and turn windows',
            'lead' => 'One handle controls two distinct opening modes. Tilt the top inwards for background ventilation, or turn the sash inwards for a wide opening and straightforward cleaning from inside.',
            'hero' => 'tilt-turn/tilt-turn-brick-1600w.webp',
            'hero_alt' => 'Tilt and turn windows fitted to a brick apartment building',
            'reassurance' => ['Two opening modes in one sash', 'Inward opening checked against the room', 'Hardware sequence explained at handover'],
            'facts' => [
                ['value' => 'Tilt', 'label' => 'Top opens inward for controlled ventilation'],
                ['value' => 'Turn', 'label' => 'Sash opens inward from the side'],
                ['value' => '70mm', 'label' => 'Liniar uPVC platform'],
                ['value' => 'Inside cleaning', 'label' => 'Outside glass can be reached from the room'],
            ],
            'selector' => [
                'eyebrow' => 'Two handle positions',
                'title' => 'Compare tilt mode with turn mode.',
                'intro' => 'The window must be fully closed before changing mode. The two positions solve different ventilation and access needs.',
                'options' => [
                    ['title' => 'Tilt mode', 'kicker' => 'Top ventilation', 'copy' => 'The top of the sash leans inward while the bottom stays engaged. It provides controlled ventilation without the full sash swinging into the room.', 'image' => 'window-systems/liniar-tilt-turn.webp', 'alt' => 'Tilt and turn window in tilted ventilation mode'],
                    ['title' => 'Turn mode', 'kicker' => 'Wide inward opening', 'copy' => 'The side-hinged sash swings into the room. Check clear space around taps, furniture, blinds and deep window boards.', 'image' => 'tilt-turn/tilt-turn-apartments-1400w.webp', 'alt' => 'Large tilt and turn windows in an apartment elevation'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'Room planning', 'title' => 'Allow for the inward swing before choosing the size.', 'copy' => 'The turn mode needs clear space inside. We check the sash against kitchen taps, desks, curtains and the reveal so the useful opening is not compromised after installation.', 'image' => 'window-systems/liniar-tilt-turn.webp', 'alt' => 'Liniar tilt and turn window open inward'],
                ['eyebrow' => 'Larger openings', 'title' => 'Useful where outside access is difficult.', 'copy' => 'The inward turn can make outside glass easier to clean from the room. It is especially useful on upper floors, but sash weight, restrictors and safe use still need to be specified.', 'image' => 'tilt-turn/tilt-turn-apartments-1400w.webp', 'alt' => 'Tilt and turn windows used across a multi-storey building'],
            ],
            'system' => [
                'label' => 'Liniar tilt and turn',
                'title' => 'Dual-action hardware on the Liniar uPVC platform.',
                'copy' => 'The tilt and turn arrangement uses perimeter hardware to move between a top-tilt position and a side-hinged inward opening. The exact sash limits depend on size, glass weight and hardware.',
                'image' => 'window-systems/liniar-tilt-turn.webp',
                'alt' => 'White Liniar tilt and turn window',
                'specs' => [['Modes', 'Top tilt and inward turn'], ['Operation', 'Single handle with sequenced positions'], ['Frame', '70mm Liniar uPVC platform'], ['Survey check', 'Inward clearance, restrictors and accessible use']],
            ],
            'choices' => $upvc_choices,
            'faqs' => [
                ['q' => 'How does a tilt and turn window work?', 'a' => 'With the sash closed, one handle selects either a top-tilt ventilation position or a side-hinged inward opening. The sash should be closed before switching modes.'],
                ['q' => 'Do tilt and turn windows open inwards?', 'a' => 'Yes. Both the top tilt and the full turn move into the room, so the available internal clearance matters.'],
                ['q' => 'Are they easier to clean upstairs?', 'a' => 'Turn mode brings the outside face of the glass within reach from the room, which can make cleaning easier where safe external access is limited.'],
                ['q' => 'Can the opening be restricted?', 'a' => 'Restrictors and controlled-opening hardware can be specified, subject to the intended ventilation and escape requirements.'],
                ['q' => 'Can tilt and turn windows match other Liniar windows?', 'a' => 'Yes. Colour, glass and handle choices can be coordinated with casement, French and flush windows, subject to component availability.'],
            ],
            'quote_label' => 'Design and price tilt and turn windows',
            'project_type' => 'Tilt and turn windows',
        ],
        'bow-bay-windows' => [
            'eyebrow' => 'Projected uPVC windows',
            'title' => 'Bow and bay windows',
            'lead' => 'Both options project beyond the wall, but they create different shapes. A bay uses defined angles. A bow uses more sections to form a gentler curve.',
            'hero' => 'bow-bay/bay-white-brick-dusk-1600w.webp',
            'hero_alt' => 'White bay window projecting from a brick house',
            'reassurance' => ['Existing support and roof checked', 'Opening panes planned before manufacture', 'Casement, flush or tilt and turn sections available'],
            'facts' => [
                ['value' => 'Bay', 'label' => 'Defined angled projection'],
                ['value' => 'Bow', 'label' => 'Softer curve formed from several sections'],
                ['value' => 'Structure first', 'label' => 'Support, cill, roof and connectors checked at survey'],
                ['value' => 'Mixed openings', 'label' => 'Fixed and opening panes can be combined'],
            ],
            'selector' => [
                'eyebrow' => 'Compare the plan shape',
                'title' => 'Bay or bow?',
                'intro' => 'The choice affects the projection, internal board, roof treatment and the proportions of every window section.',
                'options' => [
                    ['title' => 'Bay window', 'kicker' => 'Clear angles', 'copy' => 'A square or splayed bay uses defined corners and usually fewer, wider window sections. It can create a deeper internal ledge.', 'image' => 'bow-bay/bay-white-brick-dusk-1600w.webp', 'alt' => 'Angled bay window on a brick house'],
                    ['title' => 'Bow window', 'kicker' => 'Gentler curve', 'copy' => 'A bow uses several narrower sections and shallower angles to create a curved appearance. The number of facets controls the finished shape.', 'image' => 'window-systems/liniar-bay-window.webp', 'alt' => 'White Liniar bow window with multiple facets'],
                    ['title' => 'Opening layout', 'kicker' => 'Plan each section', 'copy' => 'Not every facet needs to open. Fixed panes keep sightlines quieter, while selected side or top openings provide ventilation where it is useful.', 'image' => 'casement/casement-open-brick-1400w.webp', 'alt' => 'Casement opening used within a projected window'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'The part below the glass', 'title' => 'The support detail matters as much as the window style.', 'copy' => 'We check the existing base, cill, internal board, corner posts and any roof above. Replacing a projected window is not simply a row of casements joined together.', 'image' => 'window-systems/liniar-bay-window.webp', 'alt' => 'Liniar projected bay window product view'],
                ['eyebrow' => 'Sightlines around the curve', 'title' => 'Use opening panes where they earn their place.', 'copy' => 'Hardware and thicker opening sashes can make a busy elevation. We normally start with the ventilation the room needs, then use fixed panes to keep the remaining sections cleaner.', 'image' => 'bow-bay/bay-white-brick-dusk-1600w.webp', 'alt' => 'Bay window with balanced fixed and opening panes'],
            ],
            'system' => [
                'label' => 'Liniar projected windows',
                'title' => 'Casement, flush and tilt and turn sections can form the projection.',
                'copy' => 'Liniar window systems can be connected into bow and bay arrangements. The connector angles, reinforcement and support are designed around the surveyed opening rather than selected from one standard bay size.',
                'image' => 'window-systems/liniar-bay-window.webp',
                'alt' => 'White multi-section Liniar bay window',
                'specs' => [['Bay shape', 'Square or splayed with defined corners'], ['Bow shape', 'Several facets forming a softer curve'], ['Window styles', 'Casement, flush or tilt and turn, subject to design'], ['Survey', 'Support, projection, angles and roof treatment checked']],
            ],
            'choices' => $upvc_choices,
            'faqs' => [
                ['q' => 'What is the difference between a bow and a bay window?', 'a' => 'A bay uses defined corner angles and usually fewer sections. A bow uses more facets at gentler angles to create a curved appearance.'],
                ['q' => 'Can an existing flat window be changed to a bay?', 'a' => 'Sometimes, but it is a structural alteration rather than a standard replacement. Support, planning, roof and weathering requirements must be checked first.'],
                ['q' => 'Do all sections need to open?', 'a' => 'No. Fixed panes can be combined with selected opening panes to provide ventilation without adding unnecessary hardware to every facet.'],
                ['q' => 'Can a flush casement be used in a bay?', 'a' => 'Yes. The Liniar flush sash can form part of a bow or bay design, subject to the connector, size and support specification.'],
                ['q' => 'Will you replace the internal board and roof?', 'a' => 'We survey the complete assembly and state what is included in the quotation. The required work depends on the condition and construction of the existing bay.'],
            ],
            'quote_label' => 'Plan and price a bow or bay window',
            'project_type' => 'Bow or bay windows',
        ],
        'aluminium-windows' => [
            'eyebrow' => 'Sheerline Prestige',
            'title' => 'Aluminium windows',
            'lead' => 'Sheerline Prestige combines slim aluminium sightlines with a Thermlock multi-chamber core. We use it for casement, French and tilt and turn layouts where larger glass areas and a powder-coated finish suit the project.',
            'hero' => 'aluminium-windows/aluminium-windows-black-house-1600w.webp',
            'hero_alt' => 'Dark aluminium windows fitted to a contemporary house',
            'reassurance' => ['Prestige casement, French and tilt and turn styles', '12 stocked finishes plus bespoke colour options', 'Glass and security specification confirmed before order'],
            'facts' => [
                ['value' => '88mm', 'label' => 'Slim casement sightline in the published configuration'],
                ['value' => '1.4 W/m²K', 'label' => 'Published double-glazed whole-window U-value'],
                ['value' => '1.0 W/m²K', 'label' => 'Published triple-glazed whole-window U-value'],
                ['value' => '12 colours', 'label' => 'Stocked powder-coated finishes, with bespoke options'],
            ],
            'selector' => [
                'eyebrow' => 'Choose the opening style',
                'title' => 'One system, three useful window types.',
                'intro' => 'Prestige uses different sash and hardware arrangements for casement, French and tilt and turn windows while keeping the finish coordinated.',
                'options' => [
                    ['title' => 'Casement', 'kicker' => 'Side, top or fixed', 'copy' => 'The standard choice for mixed elevations. Published frame and sash sightlines start at 88mm in the relevant casement configuration.', 'image' => 'aluminium-windows/aluminium-windows-card-1000w.webp', 'alt' => 'Slim dark aluminium casement window'],
                    ['title' => 'French window', 'kicker' => 'Clear centre opening', 'copy' => 'Two sashes open without a fixed centre mullion. Handing, escape use and restrictors are confirmed for the real opening.', 'image' => 'window-systems/sheerline-prestige-frames.webp', 'alt' => 'Sheerline Prestige outer frame options'],
                    ['title' => 'Tilt and turn', 'kicker' => 'Tilt and inward turn', 'copy' => 'Dual-action hardware provides controlled ventilation and a wide inward opening. Published sightlines differ from the casement arrangement.', 'image' => 'aluminium-windows/aluminium-flush-open-1200w.webp', 'alt' => 'Open aluminium window showing the slim frame'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'Thermal construction', 'title' => 'The insulation sits inside the aluminium frame.', 'copy' => 'Prestige uses Sheerline Thermlock multi-chamber construction to reduce heat transfer through the frame. The stated whole-window values depend on the glazing and tested configuration.', 'image' => 'window-systems/sheerline-prestige-frames.webp', 'alt' => 'Three Sheerline Prestige aluminium outer frame options'],
                ['eyebrow' => 'Colour and sightlines', 'title' => 'Start with proportions, then choose the finish.', 'copy' => 'Prestige has 12 stocked colours including metallic-effect finishes, with bespoke colours available separately. We check frame depth, mullions and opening sash sightlines before colour is signed off.', 'image' => 'aluminium-windows/aluminium-windows-black-house-1600w.webp', 'alt' => 'Black aluminium windows across a modern house elevation'],
            ],
            'system' => [
                'label' => 'Sheerline Prestige',
                'title' => 'A 72 to 80mm aluminium platform with Thermlock insulation.',
                'copy' => 'Prestige covers casement, French and tilt and turn window styles. Sheerline publishes 1.4 W/m²K with double glazing and 1.0 W/m²K with triple glazing for the relevant configurations.',
                'image' => 'window-systems/sheerline-prestige-frames.webp',
                'alt' => 'Sheerline Prestige aluminium frame depth options',
                'specs' => [['Frame depths', '72mm, 76.5mm and 80mm options'], ['Casement sightlines', '88mm, 102mm or 112mm by configuration'], ['Published U-values', '1.4 double glazed and 1.0 triple glazed'], ['Security', 'PAS 24; Secured by Design with the required laminate specification']],
            ],
            'choices' => $aluminium_choices,
            'faqs' => [
                ['q' => 'Which aluminium window system do you use?', 'a' => 'This page covers Sheerline Prestige, used for casement, French and tilt and turn aluminium window configurations.'],
                ['q' => 'Are aluminium windows cold?', 'a' => 'Modern thermally broken systems are designed to reduce heat transfer. Prestige uses a multi-chamber Thermlock core, and the finished performance depends on the complete frame and glazing specification.'],
                ['q' => 'Can I choose any RAL colour?', 'a' => 'Prestige has 12 stocked powder-coated finishes. Bespoke colours are also available, but lead time, price and component matching need to be checked.'],
                ['q' => 'Can aluminium windows be triple glazed?', 'a' => 'Yes, subject to the chosen configuration. Sheerline publishes whole-window values down to 1.0 W/m²K for the relevant triple-glazed Prestige window.'],
                ['q' => 'Can the windows match aluminium doors?', 'a' => 'Yes. We can coordinate stocked or bespoke powder-coated finishes across compatible Sheerline windows and doors, while checking that visible components match.'],
            ],
            'quote_label' => 'Design and price aluminium windows',
            'project_type' => 'Aluminium windows',
        ],
        'aluminium-flush-windows' => [
            'eyebrow' => 'Sheerline Prestige flush',
            'title' => 'Aluminium flush windows',
            'lead' => 'Prestige flush windows keep the opening sash level with the outside frame. The result is a flatter aluminium elevation with the same Thermlock construction and glazing choices as the wider Prestige range.',
            'hero' => 'aluminium-windows/aluminium-flush-open-1200w.webp',
            'hero_alt' => 'Open aluminium flush window in a dark finish',
            'reassurance' => ['Flush outside sash', 'Thermlock multi-chamber insulation', '12 stocked finishes plus bespoke colour options'],
            'facts' => [
                ['value' => 'Flush outside', 'label' => 'Sash aligns with the outer frame'],
                ['value' => '72 to 80mm', 'label' => 'Prestige outer frame options'],
                ['value' => '1.0 W/m²K', 'label' => 'Published triple-glazed performance, configuration dependent'],
                ['value' => 'PAS 24', 'label' => 'Security specification available'],
            ],
            'selector' => [
                'eyebrow' => 'Compare the sash detail',
                'title' => 'Flush or stepped aluminium?',
                'intro' => 'The material and thermal core are shared. The visual decision is whether the closed opening sash should align with the outside frame or sit forward of it.',
                'options' => [
                    ['title' => 'Flush sash', 'kicker' => 'Flat outside face', 'copy' => 'The sash aligns with the outer frame when closed. This keeps the shadow lines controlled across contemporary and restrained elevations.', 'image' => 'window-systems/sheerline-prestige-flush.webp', 'alt' => 'Anthracite Sheerline Prestige flush window corner'],
                    ['title' => 'Stepped sash', 'kicker' => 'Visible sash projection', 'copy' => 'A stepped casement shows a clearer distinction between frame and opener. It may suit a project where a more articulated frame is wanted.', 'image' => 'window-systems/sheerline-prestige-frames.webp', 'alt' => 'Sheerline Prestige stepped frame options'],
                    ['title' => 'Fixed beside opening', 'kicker' => 'Keep the elevation quieter', 'copy' => 'Use opening sashes only where ventilation or access is needed. Fixed panes reduce hardware and preserve a larger uninterrupted glass area.', 'image' => 'aluminium-windows/aluminium-windows-card-1000w.webp', 'alt' => 'Dark fixed and opening aluminium window combination'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'The outside face', 'title' => 'Flush works best when mullions and openings are planned together.', 'copy' => 'An isolated flush sash is only part of the elevation. We set fixed panes, opening positions, drainage and vent requirements together before the glass sizes are finalised.', 'image' => 'window-systems/sheerline-prestige-flush.webp', 'alt' => 'Flush aluminium window in anthracite grey'],
                ['eyebrow' => 'Performance', 'title' => 'The complete tested configuration sets the U-value.', 'copy' => 'Thermlock chambers reduce heat transfer through the aluminium frame. Glass build-up, spacer, size and opening arrangement still affect the whole-window result.', 'image' => 'aluminium-windows/aluminium-flush-open-1200w.webp', 'alt' => 'Open flush aluminium window showing the inside and outside faces'],
            ],
            'system' => [
                'label' => 'Sheerline Prestige flush',
                'title' => 'A flush sash option within the insulated Prestige platform.',
                'copy' => 'Prestige flush uses the same aluminium and Thermlock approach as the main Prestige range, with a sash profile that sits level with the outer frame on the exterior.',
                'image' => 'window-systems/sheerline-prestige-flush.webp',
                'alt' => 'Sheerline Prestige flush contemporary window product view',
                'specs' => [['Outside face', 'Opening sash flush with outer frame'], ['Frame depths', '72mm, 76.5mm and 80mm options'], ['Published performance', 'Down to 1.0 W/m²K with triple glazing'], ['Finish', '12 stocked powder-coated colours plus bespoke options']],
            ],
            'choices' => $aluminium_choices,
            'faqs' => [
                ['q' => 'What is an aluminium flush window?', 'a' => 'Its opening sash aligns with the outside face of the frame when closed, instead of sitting forward like a stepped casement sash.'],
                ['q' => 'Is flush a different aluminium system?', 'a' => 'It is a sash style within the Sheerline Prestige platform, sharing the Thermlock construction, frame options and finish range.'],
                ['q' => 'Can flush and standard aluminium windows be mixed?', 'a' => 'They can, but the elevations and visible sash lines should be reviewed together. We normally keep the treatment consistent across connected areas.'],
                ['q' => 'How many colours are available?', 'a' => 'Sheerline offers 12 stocked powder-coated finishes for Prestige, with bespoke colours available separately subject to checks.'],
                ['q' => 'Where do trickle vents and drainage go?', 'a' => 'Ventilation and drainage are designed into the final frame schedule. We discuss their position before order because both can affect the visible detail.'],
            ],
            'quote_label' => 'Design and price flush aluminium windows',
            'project_type' => 'Aluminium flush windows',
        ],
        'heritage-windows' => [
            'eyebrow' => 'Sheerline Classic',
            'title' => 'Heritage aluminium windows',
            'lead' => 'Sheerline Classic uses slimmer aluminium sections for steel-look and heritage-style glazing. Choose beadless or beaded opening sashes, then set the bars, colour and matching doors as one elevation.',
            'hero' => 'window-systems/sheerline-classic-styles.webp',
            'hero_alt' => 'Four Sheerline Classic heritage aluminium window corner styles',
            'reassurance' => ['Slim Classic sightlines', 'Beadless and beaded sash styles', 'Decorative bar layouts planned across the elevation'],
            'facts' => [
                ['value' => '36.5mm', 'label' => 'Published fixed-light sightline'],
                ['value' => '59mm', 'label' => 'Published beadless opening sightline'],
                ['value' => '1.1 W/m²K', 'label' => 'Published triple-glazed value for relevant styles'],
                ['value' => '12 colours', 'label' => 'Stocked finishes, with bespoke options'],
            ],
            'selector' => [
                'eyebrow' => 'Choose the face detail',
                'title' => 'Four Classic styling combinations.',
                'intro' => 'The opening sash can be beadless or beaded, then paired with a stepped or flush outside style. We compare the corners before the bar layout is drawn.',
                'options' => [
                    ['title' => 'Beadless', 'kicker' => '59mm opening sightline', 'copy' => 'The glass is retained without a visible interior bead, creating the narrowest published Classic opening sightline.', 'image' => 'window-systems/sheerline-classic-styles.webp', 'alt' => 'Sheerline Classic beadless and beaded corner styles'],
                    ['title' => 'Beaded', 'kicker' => '60.5mm opening sightline', 'copy' => 'A visible glazing bead changes the inside detail while retaining the same slim overall character.', 'image' => 'window-systems/sheerline-classic-styles.webp', 'alt' => 'Comparison of Sheerline Classic window corner treatments'],
                    ['title' => 'Flush or stepped', 'kicker' => 'Set the outside shadow line', 'copy' => 'Pair the sash detail with a flush contemporary or stepped exterior. The right choice depends on the building and surrounding doors.', 'image' => 'window-systems/sheerline-classic-styles.webp', 'alt' => 'Four flush and stepped Sheerline Classic window options'],
                ],
            ],
            'stories' => [
                ['eyebrow' => 'Bars and proportions', 'title' => 'Draw the grid across the whole opening.', 'copy' => 'Decorative bars create the steel-look character, but too many divisions can make small panes busy. We set bar width, spacing and alignment across windows and doors before manufacture.', 'image' => 'window-systems/sheerline-classic-styles.webp', 'alt' => 'Sheerline Classic slim window corner and glazing bar styles'],
                ['eyebrow' => 'Matched openings', 'title' => 'Coordinate windows with Classic doors.', 'copy' => 'The Classic family includes windows and heritage-style doors. Matching the powder-coated finish and bar lines helps the combined elevation read as one design.', 'image' => 'aluminium-windows/aluminium-windows-black-house-1600w.webp', 'alt' => 'Dark slim aluminium glazing across a house elevation'],
            ],
            'system' => [
                'label' => 'Sheerline Classic',
                'title' => 'Slim aluminium sections for heritage-style glazing.',
                'copy' => 'Classic publishes a 36.5mm fixed-light sightline, 59mm beadless opening sightline and 60.5mm beaded opening sightline. Relevant configurations achieve 1.4 W/m²K double glazed and 1.1 W/m²K triple glazed.',
                'image' => 'window-systems/sheerline-classic-styles.webp',
                'alt' => 'Sheerline Classic four-corner window style comparison',
                'specs' => [['Fixed sightline', '36.5mm'], ['Opening sightlines', '59mm beadless or 60.5mm beaded'], ['Published U-values', '1.4 double glazed and 1.1 triple glazed'], ['Security', 'PAS 24; Secured by Design upgrade available']],
            ],
            'choices' => $aluminium_choices,
            'faqs' => [
                ['q' => 'Which system do you use for heritage aluminium windows?', 'a' => 'This page covers Sheerline Classic, a slim aluminium window and door system designed for heritage-style and steel-look elevations.'],
                ['q' => 'What is the difference between beadless and beaded?', 'a' => 'A beaded sash has a visible internal glazing bead. The beadless option retains the glass without that visible bead and has a published 59mm opening sightline.'],
                ['q' => 'Are the glazing bars structural?', 'a' => 'The heritage grid is generally created with decorative bars. The actual structural divisions are agreed separately in the frame design.'],
                ['q' => 'Can Classic windows match heritage doors?', 'a' => 'Yes. Classic windows and compatible heritage doors can share colours and aligned bar patterns, subject to the final product configuration.'],
                ['q' => 'Can heritage aluminium windows be triple glazed?', 'a' => 'Relevant Classic styles can be triple glazed, with published whole-window performance down to 1.1 W/m²K. The final value depends on the tested configuration.'],
            ],
            'quote_label' => 'Design and price heritage windows',
            'project_type' => 'Heritage aluminium windows',
        ],
    ];
}

/**
 * Return one page definition or an empty array.
 *
 * @param string $slug Generated page slug.
 * @return array<string, mixed>
 */
function fenster_window_product_page(string $slug): array
{
    $pages = fenster_window_product_pages();
    return is_array($pages[$slug] ?? null) ? $pages[$slug] : [];
}
