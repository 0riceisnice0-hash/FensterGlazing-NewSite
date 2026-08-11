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
    $sector_base = '/wp-content/themes/fenster/assets/images/commercial-sectors/';

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
                'Curtain walling is a non-structural external glazing system used to form large glazed elevations, stairwell screens, shopfronts and entrance facades. It carries its own weight and is designed to resist weather, wind load and day-to-day building movement.',
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
                    'title' => 'Head, cill, jamb, drainage and wind load details checked before installation.',
                    'copy' => 'Curtain walling must meet the surrounding building fabric properly. Fenster can review fixing points, cill details, drainage, wind load requirements, access for fitting and the condition of any existing facade before works begin.',
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
                    'copy' => 'If the panel serves plant, mechanical ventilation or a specific building-service requirement, Fenster needs the free-area target or consultant schedule so the louvre can be sized properly.',
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
                    'copy' => 'Fenster can coordinate louvre colour, frame depth, surrounding trims and maintenance access so the panel forms part of the glazing package rather than a separate add-on.',
                    'image' => $asset_base . 'Smart-043-003.jpg',
                    'alt' => 'Commercial aluminium system detail',
                    'points' => ['Frame integration', 'Powder-coated finishes', 'Maintenance access'],
                ],
            ],
            'use_cases' => ['Plant rooms', 'Substations', 'Bin stores', 'Risers and ducts', 'Car parks', 'Screened facades', 'Back-of-house', 'Office refurbishments'],
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
        'automatic-opening-vents' => [
            'eyebrow' => 'AOV smoke ventilation',
            'title' => 'Automatic opening vents',
            'subtitle' => 'AOV units supplied and installed as part of the commercial glazing package, for the stairwells, corridors and lobbies where smoke has to be cleared from an escape route.',
            'intro_heading' => 'A window that opens itself when the building fills with smoke.',
            'hero_image' => $asset_base . 'Airbus-Commercial.jpg',
            'hero_alt' => 'Large commercial building with a fully glazed facade',
            'intro_image' => $asset_base . 'curtain-walling-6-1.jpeg',
            'intro_alt' => 'Commercial glazed elevation on a dealership building',
            'summary' => [
                'An automatic opening vent is a window or roof vent built into the building that opens on its own when smoke or heat is detected. Its job is to keep the escape route usable: the smoke goes out, the stairwell or corridor stays clear enough to walk down, and the fire service can see what they are walking into.',
                'We supply and install them. An AOV is a window before it is anything else, so it is worth specifying alongside the rest of the glazing rather than cutting one into a finished elevation afterwards.',
            ],
            'stats' => [
                ['value' => 'Supply', 'label' => 'and install, both by us'],
                ['value' => 'Escape routes', 'label' => 'stairwells, corridors and lobbies'],
                ['value' => 'Handover', 'label' => 'documentation for what we fit'],
            ],
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
                    'image' => $asset_base . 'curtain-walling-4.jpg',
                    'alt' => 'Commercial curtain walling elevation',
                    'points' => ['Position agreed before manufacture', 'Sightlines kept across the elevation', 'Opening area checked against the brief'],
                ],
                [
                    'eyebrow' => 'What we need from you',
                    'title' => 'Send the fire strategy and we will work to it.',
                    'copy' => 'Where the vents go, how much they open and what triggers them come out of the building fire strategy, not out of a glazing quote. Send us that strategy or the specification written from it and we will price and fit to it. If it has not been written yet, tell us and we will hold the vent positions open rather than guess at them.',
                    'image' => $asset_base . 'SM-033-006.jpg',
                    'alt' => 'Commercial aluminium glazing system detail',
                    'points' => ['Fire strategy or specification', 'Vent positions and opening area', 'Programme and access on site'],
                ],
            ],
            'use_cases' => ['Stairwells', 'Corridors and lobbies', 'Apartment blocks', 'Offices', 'Schools', 'Care settings'],
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
