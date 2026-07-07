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
            'subtitle' => 'Fenster supplies and installs commercial window and door packages for offices, schools, healthcare buildings, retail units and occupied premises.',
            'hero_image' => $asset_base . 'commercial-1.jpg',
            'hero_alt' => 'Commercial glazed entrance and window package',
            'intro_image' => $asset_base . 'commercial-4.jpg',
            'intro_alt' => 'Commercial glazing installed on a business frontage',
            'summary' => [
                'Fenster can replace failed commercial windows and doors, fit new aluminium or uPVC frames, install glazed entrances and coordinate glass, hardware and threshold details as one package.',
                'The team can work from drawings, window schedules, photographs or a site visit. For occupied buildings, survey and fitting can be planned around access, staff, visitors and trading hours.',
            ],
            'stats' => [
                ['value' => 'Windows', 'label' => 'aluminium or uPVC frames'],
                ['value' => 'Doors', 'label' => 'entrances, exits and access routes'],
                ['value' => 'Glass', 'label' => 'safety, solar, acoustic or obscure'],
            ],
            'capabilities' => [
                ['title' => 'Window replacement', 'copy' => 'Like-for-like commercial window replacement, frame upgrades and planned replacement programmes.'],
                ['title' => 'Glazed doors', 'copy' => 'Aluminium and glazed entrance doors with suitable locks, handles, closers and threshold details.'],
                ['title' => 'Glass specification', 'copy' => 'Toughened, laminated, acoustic, solar-control, low-e and obscure glass options where required.'],
                ['title' => 'Live-site fitting', 'copy' => 'Phased work for premises that need to stay open or partially occupied during installation.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Frames and glass',
                    'title' => 'Fenster can match the frame and glazing to the building use.',
                    'copy' => 'Commercial work can involve more footfall, larger openings and stricter safety requirements than a normal home installation. Fenster checks the frame material, glass make-up, ventilation, restrictors, colour and hardware before the final quotation.',
                    'image' => $asset_base . 'commercial-5.jpg',
                    'alt' => 'Commercial glazing and window detail',
                    'points' => ['Aluminium or uPVC frames', 'Safety and performance glass', 'Hardware and colour options'],
                ],
                [
                    'eyebrow' => 'Entrances',
                    'title' => 'Door packages can include the practical hardware around the leaf.',
                    'copy' => 'Where doors are part of the package, Fenster can review handles, locks, closers, low thresholds, side screens and access requirements so the entrance is usable as well as neat.',
                    'image' => $asset_base . 'aluminium-doors-northampton-2.jpg',
                    'alt' => 'Commercial aluminium door detail',
                    'points' => ['Door furniture', 'Closers and locks', 'Threshold and side-screen checks'],
                ],
            ],
            'use_cases' => ['Offices', 'Schools', 'Retail units', 'Healthcare buildings', 'Care settings', 'Hospitality premises'],
        ],
        'curtain-walling' => [
            'eyebrow' => 'Curtain walling',
            'title' => 'Curtain walling',
            'subtitle' => 'Fenster can supply and install aluminium curtain walling for glazed entrances, stairwells, showrooms, offices and commercial elevations.',
            'hero_image' => $asset_base . 'curtain-walling.jpg',
            'hero_alt' => 'Curtain walling on a commercial building',
            'intro_image' => $asset_base . 'curtain-walling-2.jpg',
            'intro_alt' => 'Curtain walling glazing detail',
            'summary' => [
                'Curtain walling is used where a building needs a larger glazed screen rather than individual windows. Fenster can review the opening, mullion and transom layout, glass type, colour, drainage and fixing details.',
                'For replacement work, the team can look at the existing facade and advise whether the job is a full curtain walling package, a glazed entrance, localised glass replacement or a repair-led route.',
            ],
            'stats' => [
                ['value' => 'Screens', 'label' => 'large glazed elevations'],
                ['value' => 'Entrances', 'label' => 'doors and side screens'],
                ['value' => 'Glass', 'label' => 'safety and performance options'],
            ],
            'capabilities' => [
                ['title' => 'Glazed screens', 'copy' => 'Curtain walling for entrances, stairwells, office frontages and showroom glazing.'],
                ['title' => 'Mullion layouts', 'copy' => 'Vertical and horizontal bar layouts planned around the opening and the look of the elevation.'],
                ['title' => 'Door integration', 'copy' => 'Commercial doors, side screens and toplights can be worked into the curtain walling package.'],
                ['title' => 'Replacement glass', 'copy' => 'Failed or damaged units can be reviewed where a full facade replacement is not needed.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Facade layout',
                    'title' => 'The layout needs to suit the opening, structure and glass sizes.',
                    'copy' => 'Fenster can review mullion spacing, transom positions, door locations and glass unit sizes so the finished screen looks deliberate and can be manufactured sensibly.',
                    'image' => $asset_base . 'curtain-walling-4.jpg',
                    'alt' => 'Large glazed commercial curtain walling elevation',
                    'points' => ['Mullion and transom layout', 'Door and side-screen positions', 'Glass unit sizing'],
                ],
                [
                    'eyebrow' => 'Weathering and access',
                    'title' => 'Fixing, drainage and fitting access are part of the job.',
                    'copy' => 'Curtain walling has to deal with water, movement and the surrounding building fabric. Fenster can check head, sill and jamb details, plus delivery and fitting access before the work is booked.',
                    'image' => $asset_base . 'curtain-walling-5.jpg',
                    'alt' => 'Commercial curtain walling installation',
                    'points' => ['Head, sill and jamb checks', 'Drainage and weathering', 'Delivery and site access'],
                ],
            ],
            'use_cases' => ['Glazed entrances', 'Stairwells', 'Showrooms', 'Office elevations', 'Retail frontages', 'Replacement facades'],
        ],
        'louvre-vents' => [
            'eyebrow' => 'Louvre vents',
            'title' => 'Louvre vents',
            'subtitle' => 'Fenster can include commercial louvres and ventilation panels within window, door and facade packages.',
            'hero_image' => $asset_base . 'commercial-4.jpg',
            'hero_alt' => 'Commercial glazing with ventilation requirements',
            'intro_image' => $asset_base . 'SM-037-001.jpg',
            'intro_alt' => 'Commercial aluminium glazing detail',
            'summary' => [
                'Louvres are usually needed for airflow, plant rooms, service areas, screening or background ventilation. Fenster can review louvre positions alongside the surrounding glazing so they do not look like an afterthought.',
                'The team can check colour, frame integration, weather exposure, free-area requirements and maintenance access before specifying the final panel.',
            ],
            'stats' => [
                ['value' => 'Airflow', 'label' => 'plant and building ventilation'],
                ['value' => 'Screening', 'label' => 'service and back-of-house areas'],
                ['value' => 'Colour', 'label' => 'matched to frames where possible'],
            ],
            'capabilities' => [
                ['title' => 'Vent panels', 'copy' => 'Louvre panels fitted into suitable commercial openings or frame packages.'],
                ['title' => 'Plant airflow', 'copy' => 'Ventilation requirements can be reviewed against the opening and required free area.'],
                ['title' => 'Screening', 'copy' => 'Louvres can help screen service areas while keeping airflow.'],
                ['title' => 'Frame matching', 'copy' => 'Colour and framing can be coordinated with the surrounding commercial glazing.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Airflow',
                    'title' => 'The required free area should be known before the louvre is priced.',
                    'copy' => 'If the louvre is serving plant or a specific ventilation duty, Fenster needs the airflow/free-area requirement or the consultant schedule so the panel is not guessed from appearance alone.',
                    'image' => $asset_base . 'commercial-5.jpg',
                    'alt' => 'Commercial glazing package with service access',
                    'points' => ['Free-area checks', 'Plant or ventilation brief', 'Suitable panel size'],
                ],
                [
                    'eyebrow' => 'Appearance',
                    'title' => 'Louvres should sit neatly inside the wider glazing package.',
                    'copy' => 'Fenster can coordinate louvre colour, frame depth and surrounding trims so the panel sits cleanly alongside windows, doors or curtain walling.',
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
            'subtitle' => 'Fenster can help with commercial entrance door packages where automation, access control or specialist hardware needs to be considered.',
            'hero_image' => $asset_base . 'electric-door.jpg',
            'hero_alt' => 'Commercial automatic entrance door',
            'intro_image' => $asset_base . 'commercial-1.jpg',
            'intro_alt' => 'Commercial entrance glazing',
            'summary' => [
                'Some commercial entrances need more than a standard door leaf. Fenster can review the glazing, door frame, side screens, thresholds and hardware requirements, then coordinate the right specialist input where automatic operation is part of the brief.',
                'The team can discuss footfall, accessibility, security, emergency exit requirements and the practical space around the entrance before the final route is chosen.',
            ],
            'stats' => [
                ['value' => 'Entrances', 'label' => 'shops, offices and public buildings'],
                ['value' => 'Access', 'label' => 'automation or access-control brief'],
                ['value' => 'Hardware', 'label' => 'locks, closers, sensors and thresholds'],
            ],
            'capabilities' => [
                ['title' => 'Entrance review', 'copy' => 'Fenster can check whether the opening suits a manual, assisted or automated entrance route.'],
                ['title' => 'Access control', 'copy' => 'Door and frame details can be coordinated around access-control requirements.'],
                ['title' => 'Glazed screens', 'copy' => 'Side screens, toplights and entrance glazing can be included in the package.'],
                ['title' => 'Specialist coordination', 'copy' => 'Automation elements can be coordinated with the right specialist rather than treated as an afterthought.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Entrance use',
                    'title' => 'Footfall and access requirements change the door choice.',
                    'copy' => 'Fenster can review how the door will be used day to day, including opening width, access routes, threshold height, locking and whether the entrance needs automatic operation.',
                    'image' => $asset_base . 'aluminium-doors-northampton-2.jpg',
                    'alt' => 'Commercial aluminium door detail',
                    'points' => ['Footfall and opening width', 'Threshold and accessibility', 'Locking and access control'],
                ],
                [
                    'eyebrow' => 'Glazing around the door',
                    'title' => 'The surrounding screens matter as much as the door leaf.',
                    'copy' => 'Automatic and access-controlled doors often sit inside a wider glazed entrance. Fenster can coordinate side screens, toplights, safety glass and manifestation requirements.',
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
            'subtitle' => 'Fenster can support glazing packages for healthcare, dental, care and clinical settings where safety, privacy and occupied-site working matter.',
            'hero_image' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg',
            'hero_alt' => 'Healthcare commercial glazing project',
            'intro_image' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg',
            'intro_alt' => 'Healthcare glazing installation after fitting',
            'summary' => [
                'Healthcare and care settings often need careful access planning, safety glass, privacy glass, restrictors, ventilation and low-disruption fitting. Fenster can review those requirements before the package is priced.',
                'For live buildings, the team can discuss phasing, working areas, protection and timing so staff, visitors, patients or residents are considered from the start.',
            ],
            'stats' => [
                ['value' => 'Safety', 'label' => 'glass and restrictor checks'],
                ['value' => 'Privacy', 'label' => 'obscure or screening options'],
                ['value' => 'Occupied', 'label' => 'planned work around live areas'],
            ],
            'capabilities' => [
                ['title' => 'Clinical and care settings', 'copy' => 'Window, door and glazing packages for healthcare-adjacent and care environments.'],
                ['title' => 'Safety glass', 'copy' => 'Toughened, laminated or other suitable glass can be discussed where the setting requires it.'],
                ['title' => 'Privacy and comfort', 'copy' => 'Obscure glass, solar control, acoustic glass and ventilation can be reviewed together.'],
                ['title' => 'Phased fitting', 'copy' => 'Work can be planned around live areas, staff access and sensitive rooms.'],
            ],
            'detail_sections' => [
                [
                    'eyebrow' => 'Safety and privacy',
                    'title' => 'The glass choice needs to match the room and the people using it.',
                    'copy' => 'Fenster can review whether the opening needs safety glass, obscure glass, solar control, acoustic performance, restrictors or other practical details before manufacture.',
                    'image' => $asset_base . 'Window_23.jpg',
                    'alt' => 'Commercial window installation',
                    'points' => ['Safety glass', 'Privacy and screening', 'Restrictor and ventilation checks'],
                ],
                [
                    'eyebrow' => 'Occupied buildings',
                    'title' => 'Live healthcare and care settings need careful fitting plans.',
                    'copy' => 'Where a building stays in use, Fenster can discuss working areas, protection, timing, access routes and communication before installation starts.',
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
