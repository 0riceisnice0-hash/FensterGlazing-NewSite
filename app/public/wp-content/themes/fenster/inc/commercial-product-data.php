<?php
/**
 * Commercial product page data.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_commercial_product_pages(): array
{
    $asset_base = '/wp-content/themes/fenster/assets/images/imported/';

    return [
        'commercial-windows-and-doors' => [
            'eyebrow' => 'Commercial windows and doors',
            'title' => 'Commercial windows and doors',
            'subtitle' => 'Commercial aluminium and uPVC windows, glazed doors, entrance screens and replacement glazing for business, education, healthcare and public-sector buildings.',
            'intro_heading' => 'Window and door replacement, refurbishment and new installation.',
            'hero_image' => $asset_base . 'commercial-1.jpg',
            'hero_alt' => 'Commercial glazed entrance and window package',
            'intro_image' => $asset_base . 'commercial-4.jpg',
            'intro_alt' => 'Commercial glazing installed on a business frontage',
            'summary' => [
                'Fenster carries out commercial window and door works across Milton Keynes, Bedfordshire, Buckinghamshire, Northamptonshire and surrounding areas. Work can include aluminium windows, uPVC windows, glazed doors, entrance screens, replacement sealed units and associated hardware.',
                'Projects can be surveyed from drawings, schedules, photographs or site attendance. For live buildings, the work can be planned in phases around staff, visitors, trading hours, access routes and other contractors.',
            ],
            'stats' => [
                ['value' => 'Windows', 'label' => 'aluminium or uPVC systems'],
                ['value' => 'Doors', 'label' => 'commercial entrances and access routes'],
                ['value' => 'Glass', 'label' => 'safety, solar, acoustic or obscure'],
            ],
            'capabilities' => [
                ['title' => 'Commercial window replacement', 'copy' => 'Replacement aluminium or uPVC windows for offices, schools, healthcare buildings, retail units and managed properties.'],
                ['title' => 'Glazed doors and entrances', 'copy' => 'Commercial door sets, side screens, toplights, handles, locks, closers and threshold details.'],
                ['title' => 'Glass and sealed units', 'copy' => 'Toughened, laminated, low-e, solar-control, acoustic and obscure glass options where the building needs them.'],
                ['title' => 'Occupied-site installation', 'copy' => 'Planned works for buildings that need to stay open, with phasing and access agreed before installation.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Frames and glass',
                    'title' => 'Commercial frames, glazing and hardware specified as one package.',
                    'copy' => 'Window and door projects often involve more than a frame swap. Fenster can check opening sizes, glass type, restrictors, ventilation, colour, locks, closers, handles and threshold details before ordering.',
                    'image' => $asset_base . 'commercial-5.jpg',
                    'alt' => 'Commercial glazing and window detail',
                    'points' => ['Aluminium and uPVC windows', 'Glazed doors and entrance screens', 'Safety and performance glass'],
                ],
                [
                    'eyebrow' => 'Refurbishment and replacement',
                    'title' => 'Suitable for planned replacement programmes and individual problem openings.',
                    'copy' => 'Fenster can look at a single failed door, a run of tired windows or a wider refurbishment package. Survey notes and photographs help confirm whether the best route is repair, replacement glass or full frame replacement.',
                    'image' => $asset_base . 'aluminium-doors-northampton-2.jpg',
                    'alt' => 'Commercial aluminium door detail',
                    'points' => ['Single openings', 'Phased programmes', 'Repair or replacement advice'],
                ],
            ],
            'use_cases' => ['Offices', 'Schools', 'Retail units', 'Healthcare buildings', 'Care settings', 'Hospitality premises'],
        ],
        'curtain-walling' => [
            'eyebrow' => 'Curtain walling',
            'title' => 'Curtain walling',
            'subtitle' => 'Aluminium curtain walling, glazed screens and entrance facades for commercial buildings, shopfronts, offices, schools and public-sector projects.',
            'intro_heading' => 'Aluminium curtain walling for glazed facades and entrance screens.',
            'hero_image' => $asset_base . 'curtain-walling.jpg',
            'hero_alt' => 'Curtain walling on a commercial building',
            'intro_image' => $asset_base . 'curtain-walling-2.jpg',
            'intro_alt' => 'Curtain walling glazing detail',
            'summary' => [
                'Curtain walling is a non-structural external glazing system used to form large glazed elevations, stairwell screens, shopfronts and entrance facades. It carries its own weight and is designed to resist weather, wind loading and day-to-day building movement.',
                'Fenster can survey, supply and install aluminium curtain walling for new openings, replacement facades and commercial refurbishments. The system can incorporate glazed doors, opening vents, insulated panels, louvres and a wide choice of powder-coated finishes.',
            ],
            'stats' => [
                ['value' => 'Facades', 'label' => 'large glazed screens'],
                ['value' => 'Entrances', 'label' => 'doors, toplights and side screens'],
                ['value' => 'Finish', 'label' => 'powder-coated aluminium'],
            ],
            'capabilities' => [
                ['title' => 'Curtain wall screens', 'copy' => 'Aluminium mullion and transom screens for commercial elevations, atriums, stairwells and entrances.'],
                ['title' => 'Integrated doors', 'copy' => 'Commercial door sets, side screens and toplights worked into the curtain walling layout.'],
                ['title' => 'Panels and louvres', 'copy' => 'Insulated panels, ventilation louvres and solid infill options where the elevation requires them.'],
                ['title' => 'Glazing options', 'copy' => 'Single or double glazed specifications, with safety, solar-control, acoustic or obscure glass where needed.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'System layout',
                    'title' => 'Mullions, transoms, doors and glass sizes set out before manufacture.',
                    'copy' => 'A curtain walling elevation needs the vertical mullions, horizontal transoms, door positions and glass unit sizes planned together. Fenster can work from drawings or survey the opening before confirming the layout.',
                    'image' => $asset_base . 'curtain-walling-4.jpg',
                    'alt' => 'Large glazed commercial curtain walling elevation',
                    'points' => ['Mullion and transom layout', 'Glazed entrances', 'Opening vents and panels'],
                ],
                [
                    'eyebrow' => 'Building interfaces',
                    'title' => 'Head, sill, jamb and drainage details checked before installation.',
                    'copy' => 'Curtain walling must meet the surrounding building fabric properly. Fenster can review fixing points, sill details, drainage, access for fitting and the condition of any existing facade before works begin.',
                    'image' => $asset_base . 'curtain-walling-5.jpg',
                    'alt' => 'Commercial curtain walling installation',
                    'points' => ['Weathering and drainage', 'Fixing and access checks', 'Replacement facade works'],
                ],
            ],
            'use_cases' => ['Glazed entrances', 'Stairwells', 'Showrooms', 'Office elevations', 'Retail frontages', 'Replacement facades'],
        ],
        'louvre-vents' => [
            'eyebrow' => 'Louvre vents',
            'title' => 'Louvre vents',
            'subtitle' => 'Aluminium louvre vents and ventilation panels for plant rooms, service areas, commercial facades and glazing packages.',
            'intro_heading' => 'Ventilation louvres integrated into commercial glazing and facades.',
            'hero_image' => $asset_base . 'commercial-4.jpg',
            'hero_alt' => 'Commercial glazing with ventilation requirements',
            'intro_image' => $asset_base . 'SM-037-001.jpg',
            'intro_alt' => 'Commercial aluminium glazing detail',
            'summary' => [
                'Louvres are used where a building needs airflow, screening or ventilation without leaving an opening exposed. They are common around plant rooms, service areas, bin stores, back-of-house spaces and commercial facades.',
                'Fenster can include louvre panels within aluminium window, door and curtain walling packages, matching colour and frame details where practical. Free-area requirements, weather exposure and maintenance access should be confirmed before specification.',
            ],
            'stats' => [
                ['value' => 'Airflow', 'label' => 'plant and service ventilation'],
                ['value' => 'Screening', 'label' => 'back-of-house and service areas'],
                ['value' => 'Finish', 'label' => 'frame-matched where practical'],
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
                    'copy' => 'If the panel serves plant, mechanical ventilation or a specific building-service requirement, Fenster needs the free-area target or consultant schedule so the louvre can be sized properly.',
                    'image' => $asset_base . 'commercial-5.jpg',
                    'alt' => 'Commercial glazing package with service access',
                    'points' => ['Free-area checks', 'Plant or ventilation brief', 'Suitable panel size'],
                ],
                [
                    'eyebrow' => 'Facade appearance',
                    'title' => 'Louvres should sit neatly within the surrounding windows or screens.',
                    'copy' => 'Fenster can coordinate louvre colour, frame depth, surrounding trims and maintenance access so the panel forms part of the glazing package rather than a separate add-on.',
                    'image' => $asset_base . 'Smart-043-003.jpg',
                    'alt' => 'Commercial aluminium system detail',
                    'points' => ['Frame integration', 'Powder-coated finishes', 'Maintenance access'],
                ],
            ],
            'use_cases' => ['Plant rooms', 'Service zones', 'Back-of-house areas', 'Schools', 'Retail units', 'Office refurbishments'],
        ],
        'commercial-automation' => [
            'eyebrow' => 'Commercial automation',
            'title' => 'Commercial automation',
            'subtitle' => 'Commercial entrance packages involving automatic doors, access-control requirements, glazed screens and door hardware coordination.',
            'intro_heading' => 'Automatic and access-controlled entrances built around the door package.',
            'hero_image' => $asset_base . 'electric-door.jpg',
            'hero_alt' => 'Commercial automatic entrance door',
            'intro_image' => $asset_base . 'commercial-1.jpg',
            'intro_alt' => 'Commercial entrance glazing',
            'summary' => [
                'Commercial entrances often involve more than one trade: glazing, door frames, access control, automation, safety sensors, locks, closers, manifestation and threshold requirements all need to work together.',
                'Fenster can survey and supply the glazed entrance package, then coordinate the relevant specialist input where automatic operation or access control is part of the project brief.',
            ],
            'stats' => [
                ['value' => 'Entrances', 'label' => 'shops, offices and public buildings'],
                ['value' => 'Access', 'label' => 'automation and control requirements'],
                ['value' => 'Hardware', 'label' => 'locks, closers, sensors and thresholds'],
            ],
            'capabilities' => [
                ['title' => 'Entrance screens', 'copy' => 'Glazed entrance screens, doors, side screens and toplights.'],
                ['title' => 'Automatic-door coordination', 'copy' => 'Door package reviewed around automatic operation and specialist hardware requirements.'],
                ['title' => 'Access control', 'copy' => 'Frames, locks and door details coordinated around access-control equipment.'],
                ['title' => 'Safety and use', 'copy' => 'Thresholds, traffic flow, manifestation and safety glass considered before order.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Door operation',
                    'title' => 'Footfall, access and emergency-use requirements set the door route.',
                    'copy' => 'Before an automated or access-controlled entrance is priced, Fenster can review the opening width, traffic flow, threshold, locking, emergency exit route and space for the required hardware.',
                    'image' => $asset_base . 'aluminium-doors-northampton-2.jpg',
                    'alt' => 'Commercial aluminium door detail',
                    'points' => ['Opening width and traffic flow', 'Threshold and accessibility', 'Locking and access control'],
                ],
                [
                    'eyebrow' => 'Glazing around the entrance',
                    'title' => 'Side screens and toplights can be supplied as part of the entrance package.',
                    'copy' => 'Automatic and controlled doors often sit inside a wider glazed screen. Fenster can coordinate safety glass, side screens, toplights and manifestation so the entrance works as a complete assembly.',
                    'image' => $asset_base . 'Residential_Door_08.jpg',
                    'alt' => 'Glazed entrance door',
                    'points' => ['Side screens and toplights', 'Safety glass', 'Manifestation checks'],
                ],
            ],
            'use_cases' => ['Retail entrances', 'Office receptions', 'Healthcare buildings', 'Public access routes', 'Education estates', 'High-traffic doors'],
        ],
        'healthcare-construction' => [
            'eyebrow' => 'Healthcare glazing',
            'title' => 'Healthcare construction glazing',
            'subtitle' => 'Commercial glazing, windows and doors for dental practices, care settings, clinics and healthcare refurbishment projects.',
            'intro_heading' => 'Glazing works for healthcare, dental and care environments.',
            'hero_image' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg',
            'hero_alt' => 'Healthcare commercial glazing project',
            'intro_image' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg',
            'intro_alt' => 'Healthcare glazing installation after fitting',
            'summary' => [
                'Healthcare and care settings need careful product choices: safety glass, privacy, ventilation, restrictors, acoustic comfort, solar control and occupied-site working can all affect the final specification.',
                'Fenster can survey and install replacement windows, doors, glazed screens and sealed units for live healthcare, dental, clinic and care environments, with phasing agreed around rooms that must stay in use.',
            ],
            'stats' => [
                ['value' => 'Safety', 'label' => 'glass and restrictor checks'],
                ['value' => 'Privacy', 'label' => 'obscure or screening options'],
                ['value' => 'Occupied', 'label' => 'planned work around live areas'],
            ],
            'capabilities' => [
                ['title' => 'Healthcare glazing', 'copy' => 'Windows, doors, screens and replacement glass for dental, clinical and care settings.'],
                ['title' => 'Safety and restrictors', 'copy' => 'Suitable safety glass, opening restrictors and hardware reviewed before order.'],
                ['title' => 'Privacy and comfort', 'copy' => 'Obscure glass, solar control, acoustic glass and ventilation options where required.'],
                ['title' => 'Phased works', 'copy' => 'Installation planning around rooms, residents, patients, staff and access routes.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Glass specification',
                    'title' => 'Safety, privacy and comfort are part of the glazing specification.',
                    'copy' => 'Fenster can review whether the opening needs toughened or laminated glass, obscure glass, solar-control glass, acoustic performance, restrictors or ventilation before the unit or frame is made.',
                    'image' => $asset_base . 'Window_23.jpg',
                    'alt' => 'Commercial window installation',
                    'points' => ['Safety glass', 'Privacy and screening', 'Restrictor and ventilation checks'],
                ],
                [
                    'eyebrow' => 'Live buildings',
                    'title' => 'Occupied healthcare and care premises need a practical installation plan.',
                    'copy' => 'Where the building remains in use, Fenster can discuss room access, protection, timing, parking, waste removal and communication before installation starts.',
                    'image' => $asset_base . 'SM_019_00005.jpg',
                    'alt' => 'Commercial aluminium glazing detail',
                    'points' => ['Work-area planning', 'Protection and access', 'Phased installation'],
                ],
            ],
            'use_cases' => ['Dental practices', 'Care homes', 'Clinics', 'Treatment rooms', 'Public-sector buildings', 'Occupied refurbishments'],
        ],
    ];
}

function fenster_commercial_product_page(string $slug): ?array
{
    $pages = fenster_commercial_product_pages();

    return $pages[$slug] ?? null;
}
