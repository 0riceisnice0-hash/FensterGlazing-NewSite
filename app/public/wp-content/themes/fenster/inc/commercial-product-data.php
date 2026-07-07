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
            'eyebrow' => 'Commercial glazing package',
            'title' => 'Commercial windows and doors',
            'subtitle' => 'Aluminium, uPVC and glazed entrance packages planned around building use, performance, access and programme.',
            'hero_image' => $asset_base . 'commercial-1.jpg',
            'hero_alt' => 'Commercial glazing and entrance package',
            'summary' => [
                'Fenster supports commercial window and door projects where the details matter: frame system, glass specification, access, security, thresholds, ironmongery, ventilation and installation sequencing.',
                'The useful first step is a clear brief. Send drawings, schedules, photographs or a site address and the commercial team can shape the right route before anything is priced as a generic package.',
            ],
            'stats' => [
                ['value' => 'Windows', 'label' => 'aluminium and uPVC systems'],
                ['value' => 'Doors', 'label' => 'entrances, fire exits and access routes'],
                ['value' => 'Live sites', 'label' => 'phased work around occupied buildings'],
            ],
            'checkpoints' => [
                ['title' => 'System choice', 'copy' => 'Frame material, sightlines, thermal performance, security and maintenance are reviewed against the building use.'],
                ['title' => 'Door hardware', 'copy' => 'Handles, closers, access control, thresholds and panic hardware can be coordinated with the entrance design.'],
                ['title' => 'Glazing make-up', 'copy' => 'Safety glass, acoustic glass, solar control, obscure glass and low-e units are selected around the location.'],
                ['title' => 'Programme control', 'copy' => 'Survey, lead times, access, protection and installation sequencing are planned before site work begins.'],
            ],
            'gallery' => [
                ['src' => $asset_base . 'commercial-4.jpg', 'alt' => 'Commercial glazed frontage'],
                ['src' => $asset_base . 'commercial-5.jpg', 'alt' => 'Commercial window and door installation'],
                ['src' => $asset_base . 'Airbus-Commercial.jpg', 'alt' => 'Large commercial glazing project'],
            ],
            'use_cases' => [
                'Office refurbishments',
                'Retail and showroom frontages',
                'Schools and public buildings',
                'Healthcare and care settings',
                'Hospitality entrances',
                'Multi-site maintenance programmes',
            ],
        ],
        'curtain-walling' => [
            'eyebrow' => 'Facade glazing',
            'title' => 'Curtain walling',
            'subtitle' => 'Commercial curtain walling for entrances, stairwells, showrooms and glazed elevations where structure, sightlines and weathering all need to work together.',
            'hero_image' => $asset_base . 'curtain-walling.jpg',
            'hero_alt' => 'Curtain walling on a commercial building',
            'summary' => [
                'Curtain walling is not a dressed-up window. The right result depends on the supporting structure, water management, mullion and transom layout, glass specification, interfaces and safe installation access.',
                'Fenster reviews the elevation as a package so the finished wall reads cleanly and performs properly, whether it is a new glazed entrance or a replacement commercial facade.',
            ],
            'stats' => [
                ['value' => 'Facades', 'label' => 'glazed elevations and entrances'],
                ['value' => 'Interfaces', 'label' => 'structure, roofline and adjacent trades'],
                ['value' => 'Performance', 'label' => 'weather, thermal and safety glass'],
            ],
            'checkpoints' => [
                ['title' => 'Elevation review', 'copy' => 'Mullion spacing, opening positions, sightlines and the visual rhythm of the wall are checked together.'],
                ['title' => 'Structural interfaces', 'copy' => 'Head, sill, jamb and movement details are coordinated with the building fabric and any existing structure.'],
                ['title' => 'Glass specification', 'copy' => 'Safety, solar control, acoustic, insulated and specialist glass requirements are reviewed early.'],
                ['title' => 'Access and sequencing', 'copy' => 'Delivery, lifting, protection, working area and occupied-building constraints are built into the plan.'],
            ],
            'gallery' => [
                ['src' => $asset_base . 'curtain-walling-2.jpg', 'alt' => 'Curtain walling detail'],
                ['src' => $asset_base . 'curtain-walling-4.jpg', 'alt' => 'Large glazed commercial elevation'],
                ['src' => $asset_base . 'curtain-walling-5.jpg', 'alt' => 'Commercial curtain walling installation'],
                ['src' => $asset_base . 'curtain-walling-6-1.jpeg', 'alt' => 'Curtain walling close-up'],
            ],
            'use_cases' => [
                'Glazed entrances',
                'Showroom frontages',
                'Stairwell glazing',
                'Office elevations',
                'Retail refurbishments',
                'Replacement facades',
            ],
        ],
        'louvre-vents' => [
            'eyebrow' => 'Ventilation and screening',
            'title' => 'Louvre vents',
            'subtitle' => 'Commercial louvres and ventilation panels coordinated with windows, doors and facade packages.',
            'hero_image' => $asset_base . 'commercial-4.jpg',
            'hero_alt' => 'Commercial glazing with ventilation requirements',
            'summary' => [
                'Louvres are usually part of a bigger building requirement: plant ventilation, airflow, screening, drainage, weather protection or a facade detail that must not look like an afterthought.',
                'Fenster can review louvre positions alongside the surrounding glazing package so performance, appearance and installation details stay aligned.',
            ],
            'stats' => [
                ['value' => 'Airflow', 'label' => 'plant and building ventilation'],
                ['value' => 'Screening', 'label' => 'privacy and service areas'],
                ['value' => 'Facade fit', 'label' => 'matched into the glazing package'],
            ],
            'checkpoints' => [
                ['title' => 'Airflow brief', 'copy' => 'Required free area, plant needs and ventilation intent should be confirmed before product selection.'],
                ['title' => 'Weathering', 'copy' => 'Blade type, drainage and exposure are checked so the louvre suits the wall it sits in.'],
                ['title' => 'Visual match', 'copy' => 'Colour, frame depth and surrounding glazing details are coordinated for a cleaner finish.'],
                ['title' => 'Maintenance access', 'copy' => 'Positioning and fixings are reviewed around future cleaning, service and replacement access.'],
            ],
            'gallery' => [
                ['src' => $asset_base . 'commercial-5.jpg', 'alt' => 'Commercial glazing package with service access'],
                ['src' => $asset_base . 'SM-037-001.jpg', 'alt' => 'Aluminium commercial glazing detail'],
                ['src' => $asset_base . 'Smart-043-003.jpg', 'alt' => 'Commercial aluminium system detail'],
            ],
            'use_cases' => [
                'Plant rooms',
                'Bin stores and service zones',
                'Schools and public buildings',
                'Retail back-of-house areas',
                'Office refurbishments',
                'Screened ventilation openings',
            ],
        ],
        'commercial-automation' => [
            'eyebrow' => 'Access and entrances',
            'title' => 'Commercial automation',
            'subtitle' => 'Automatic entrance and access-control conversations connected to the wider commercial glazing package.',
            'hero_image' => $asset_base . 'electric-door.jpg',
            'hero_alt' => 'Commercial automatic entrance door',
            'summary' => [
                'Commercial doors often need more than a good-looking frame. Automation, access control, safety sensors, thresholds, traffic flow and maintenance all affect whether the entrance works in daily use.',
                'Fenster can help shape the glazing and door package around those requirements, then coordinate the right specialist input where automation forms part of the brief.',
            ],
            'stats' => [
                ['value' => 'Entrances', 'label' => 'shops, offices and public buildings'],
                ['value' => 'Access', 'label' => 'traffic flow and control needs'],
                ['value' => 'Coordination', 'label' => 'door, glass and hardware package'],
            ],
            'checkpoints' => [
                ['title' => 'Entrance use', 'copy' => 'Footfall, opening width, accessibility and security needs shape the right route.'],
                ['title' => 'Hardware package', 'copy' => 'Closers, locks, sensors, access control and emergency egress need early coordination.'],
                ['title' => 'Threshold detail', 'copy' => 'Weathering, level access and daily use are checked alongside the door system.'],
                ['title' => 'Service planning', 'copy' => 'Maintenance access and future support should be considered before finalising the entrance design.'],
            ],
            'gallery' => [
                ['src' => $asset_base . 'commercial-1.jpg', 'alt' => 'Commercial entrance glazing'],
                ['src' => $asset_base . 'aluminium-doors-northampton-2.jpg', 'alt' => 'Aluminium commercial door detail'],
                ['src' => $asset_base . 'Residential_Door_08.jpg', 'alt' => 'Glazed entrance door'],
            ],
            'use_cases' => [
                'Retail entrances',
                'Office receptions',
                'Healthcare buildings',
                'Public access routes',
                'Education estates',
                'High-traffic doors',
            ],
        ],
        'healthcare-construction' => [
            'eyebrow' => 'Sector support',
            'title' => 'Healthcare construction glazing',
            'subtitle' => 'Commercial glazing support for care, clinical and healthcare-adjacent buildings where access, safety and programme discipline matter.',
            'hero_image' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg',
            'hero_alt' => 'Healthcare commercial glazing project',
            'summary' => [
                'Healthcare and care settings put extra pressure on planning. Occupied areas, privacy, safety glass, infection-control routines, opening restrictors, access and programme windows all need careful handling.',
                'Fenster reviews the glazing requirement as part of the building use, not as a standalone product list.',
            ],
            'stats' => [
                ['value' => 'Safety', 'label' => 'glass, restrictors and access details'],
                ['value' => 'Occupied', 'label' => 'phased work around live settings'],
                ['value' => 'Privacy', 'label' => 'screening, obscurity and comfort'],
            ],
            'checkpoints' => [
                ['title' => 'Live-site planning', 'copy' => 'Work areas, timing, protection and communication are planned around staff, patients, visitors or residents.'],
                ['title' => 'Safety specification', 'copy' => 'Glass type, restrictors, manifestation, thresholds and access details are checked against the building use.'],
                ['title' => 'Privacy and comfort', 'copy' => 'Obscure glass, solar control, ventilation and acoustic performance can be reviewed together.'],
                ['title' => 'Documentation', 'copy' => 'Drawings, schedules, access notes and maintenance information help keep the package clear.'],
            ],
            'gallery' => [
                ['src' => $asset_base . 'ROKA-Dental-Post-Fitting-2-1-scaled.jpg', 'alt' => 'Healthcare glazing installation after fitting'],
                ['src' => $asset_base . 'SM_019_00005.jpg', 'alt' => 'Commercial aluminium glazing detail'],
                ['src' => $asset_base . 'Window_23.jpg', 'alt' => 'Commercial window installation'],
            ],
            'use_cases' => [
                'Dental and healthcare practices',
                'Care homes',
                'Clinics and treatment rooms',
                'Public-sector buildings',
                'Occupied refurbishments',
                'Safety-led replacement glazing',
            ],
        ],
    ];
}

function fenster_commercial_product_page(string $slug): ?array
{
    $pages = fenster_commercial_product_pages();

    return $pages[$slug] ?? null;
}
