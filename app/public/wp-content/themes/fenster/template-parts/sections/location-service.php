<?php
/**
 * Location + service landing page template.
 *
 * @package Fenster
 */

$page = is_array($args['page'] ?? null) ? $args['page'] : [];
$slug = (string) ($page['slug'] ?? '');
$title = (string) ($args['title'] ?? ($page['title'] ?? 'Fenster Glazing'));
$hero_image = $args['hero_image'] ?? null;
$gallery_images = is_array($args['gallery_images'] ?? null) ? $args['gallery_images'] : [];
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$related_links = is_array($args['links'] ?? null) ? $args['links'] : [];

$locations = [
    'leighton-buzzard' => [
        'name' => 'Leighton Buzzard',
        'area' => 'market-town homes, village properties and commuter households west of Milton Keynes',
        'fit' => 'careful detailing around older brickwork, newer estates and busy family entrances',
        'angle' => 'practical upgrades that improve comfort without making the property feel overworked',
    ],
    'northamptonshire' => [
        'name' => 'Northamptonshire',
        'area' => 'homes and larger properties across Northamptonshire',
        'fit' => 'robust specifications for exposed elevations, larger openings and mixed-age properties',
        'angle' => 'survey-led glazing choices for projects that need durability as well as style',
    ],
    'milton-keynes' => [
        'name' => 'Milton Keynes',
        'area' => 'Milton Keynes homes, extensions and renovation projects',
        'fit' => 'clean modern lines, reliable security and measured installation planning',
        'angle' => 'joined-up window and door choices for properties that often have larger openings',
    ],
    'bletchley' => [
        'name' => 'Bletchley',
        'area' => 'Bletchley homes, terraces and family properties',
        'fit' => 'warmer rooms, secure doors and straightforward survey access',
        'angle' => 'practical window and door upgrades for established Milton Keynes homes',
    ],
    'wolverton' => [
        'name' => 'Wolverton',
        'area' => 'Wolverton terraces, older homes and conservation-sensitive streets',
        'fit' => 'sympathetic frame choices, sightlines and ventilation',
        'angle' => 'careful glazing choices for older properties and everyday comfort',
    ],
    'stony-stratford' => [
        'name' => 'Stony Stratford',
        'area' => 'Stony Stratford period homes, town houses and village-edge properties',
        'fit' => 'character-friendly styling, colour choice and careful fitting',
        'angle' => 'replacement glazing that respects the look of the property',
    ],
    'newport-pagnell' => [
        'name' => 'Newport Pagnell',
        'area' => 'Newport Pagnell family homes, older properties and extensions',
        'fit' => 'secure doors, efficient windows and tidy survey-led installation',
        'angle' => 'joined-up window and door upgrades for busy family homes',
    ],
    'woburn-sands' => [
        'name' => 'Woburn Sands',
        'area' => 'Woburn Sands homes, village properties and modern extensions',
        'fit' => 'balanced style, weathering and low-maintenance finishes',
        'angle' => 'glazing choices that balance character, comfort and easy upkeep',
    ],
    'great-linford' => [
        'name' => 'Great Linford',
        'area' => 'Great Linford homes, estates and family renovation projects',
        'fit' => 'practical window styles, ventilation and secure fitting',
        'angle' => 'measured glazing upgrades for warmer rooms and better everyday use',
    ],
    'shenley-church-end' => [
        'name' => 'Shenley Church End',
        'area' => 'Shenley Church End family homes and replacement glazing projects',
        'fit' => 'thermal comfort, colour choices and neat installation details',
        'angle' => 'window and door upgrades planned around the whole property',
    ],
    'furzton' => [
        'name' => 'Furzton',
        'area' => 'Furzton homes near lakeside streets, estates and extensions',
        'fit' => 'warmth, security and practical room-by-room ventilation',
        'angle' => 'efficient glazing choices for comfortable, secure family spaces',
    ],
    'oldbrook' => [
        'name' => 'Oldbrook',
        'area' => 'Oldbrook homes, town houses and replacement glazing projects',
        'fit' => 'reliable security, efficient frames and tidy fitting',
        'angle' => 'straightforward window and door upgrades with survey-led detail',
    ],
    'monkston' => [
        'name' => 'Monkston',
        'area' => 'Monkston modern homes, extensions and family properties',
        'fit' => 'clean frame lines, energy performance and made-to-measure fitting',
        'angle' => 'modern glazing choices for warmer, sharper-looking homes',
    ],
    'brooklands' => [
        'name' => 'Brooklands',
        'area' => 'Brooklands newer homes, extensions and family spaces',
        'fit' => 'modern styling, secure doors and measured installation',
        'angle' => 'low-maintenance window and door upgrades for newer properties',
    ],
    'whitehouse' => [
        'name' => 'Whitehouse',
        'area' => 'Whitehouse new-build homes, extensions and growing family spaces',
        'fit' => 'colour matching, ventilation and low-maintenance frames',
        'angle' => 'replacement glazing planned around colour, specification and survey detail',
    ],
    'buckinghamshire' => [
        'name' => 'Buckinghamshire',
        'area' => 'Buckinghamshire homes, rural properties and family houses',
        'fit' => 'balanced glazing choices for character homes, modern extensions and exposed locations',
        'angle' => 'performance-led upgrades that still respect the look of the building',
    ],
    'northampton' => [
        'name' => 'Northampton',
        'area' => 'Northampton homes, terraces, detached houses and extension projects',
        'fit' => 'secure, weather-tight products that suit mixed property ages and busier roads',
        'angle' => 'comfortable everyday glazing with clear product choices and careful survey checks',
    ],
    'letchworth' => [
        'name' => 'Letchworth',
        'area' => 'Letchworth homes, garden city properties and sympathetic renovations',
        'fit' => 'neat sightlines, colour choices and installation details that respect the architecture',
        'angle' => 'upgrades that improve warmth and security while keeping the home considered',
    ],
    'stevenage' => [
        'name' => 'Stevenage',
        'area' => 'Stevenage homes, extensions and replacement glazing projects',
        'fit' => 'low-maintenance frames, reliable locking and survey-led fitting',
        'angle' => 'straightforward product decisions for warmer, quieter and more secure rooms',
    ],
    'toddington' => [
        'name' => 'Toddington',
        'area' => 'Toddington village homes, period properties and modern extensions',
        'fit' => 'made-to-measure products that handle character details and newer openings',
        'angle' => 'a measured finish that keeps the property practical, warm and well proportioned',
    ],
    'aylesbury' => [
        'name' => 'Aylesbury',
        'area' => 'Aylesbury homes, new estates, older properties and growing family spaces',
        'fit' => 'secure, energy-conscious products planned around survey, access and finish',
        'angle' => 'a local glazing upgrade that brings comfort, style and installation detail together',
    ],
    'dunstable' => [
        'name' => 'Dunstable',
        'area' => 'Dunstable homes near exposed roads, hillsides and established estates',
        'fit' => 'noise-aware glass choices, weather-tight frames and dependable hardware',
        'angle' => 'sensible upgrades for homes that need warmth, quiet and day-to-day durability',
    ],
    'flitwick' => [
        'name' => 'Flitwick',
        'area' => 'Flitwick homes, commuter properties and family renovations',
        'fit' => 'efficient frames, neat thresholds and low-maintenance finishes',
        'angle' => 'measured glazing choices that make busy homes easier to live with',
    ],
    'ampthill' => [
        'name' => 'Ampthill',
        'area' => 'Ampthill homes, character properties and modernised family houses',
        'fit' => 'careful sightlines, colour choices and installation around existing details',
        'angle' => 'a more comfortable home without losing the property character',
    ],
    'hitchin' => [
        'name' => 'Hitchin',
        'area' => 'Hitchin homes, town properties and conservation-sensitive upgrades',
        'fit' => 'balanced style, slim profiles and practical performance improvements',
        'angle' => 'windows and doors that feel properly matched to the street and property',
    ],
    'bedford' => [
        'name' => 'Bedford',
        'area' => 'Bedford homes, riverside properties and family renovations',
        'fit' => 'secure, thermally efficient products with careful fitting around varied property styles',
        'angle' => 'a clearer route from initial enquiry to properly surveyed installation',
    ],
    'buckingham' => [
        'name' => 'Buckingham',
        'area' => 'Buckingham homes, village properties and extensions',
        'fit' => 'traditional proportions, modern performance and reliable installation detailing',
        'angle' => 'upgrades that make the home warmer and easier to maintain',
    ],
    'luton' => [
        'name' => 'Luton',
        'area' => 'Luton homes, busy streets, extensions and replacement projects',
        'fit' => 'secure hardware, noise-aware glazing and low-maintenance frames',
        'angle' => 'practical improvements for warmth, security and everyday use',
    ],
];

$services = [
    'double-glazing' => [
        'name' => 'double glazing',
        'label' => 'Double glazing',
        'thing' => 'windows, doors and glass upgrades',
        'opening' => 'Upgrade the glass and frames that affect comfort every day.',
        'benefits' => [
            ['title' => 'Warmer rooms', 'copy' => 'Modern sealed units and well-fitted frames help reduce heat loss, draughts and cold spots.'],
            ['title' => 'Quieter living spaces', 'copy' => 'Glass specification, seals and frame choice can soften everyday outside noise.'],
            ['title' => 'A joined-up upgrade', 'copy' => 'Windows, doors, replacement glass and related details can be planned together.'],
        ],
        'cards' => [
            ['title' => 'Windows', 'copy' => 'Casement, flush, sash and aluminium windows can be matched to the age and style of the home.'],
            ['title' => 'Doors', 'copy' => 'Composite, uPVC, aluminium, French, patio and bifold doors can be specified alongside the glazing.'],
            ['title' => 'Glass upgrades', 'copy' => 'Misted units, replacement glass, integral blinds and pet flap options can be reviewed during survey.'],
        ],
    ],
    'casement-windows' => [
        'name' => 'casement windows',
        'label' => 'Casement windows',
        'thing' => 'made-to-measure casement windows',
        'opening' => 'Choose a practical window style with strong everyday performance.',
        'benefits' => [
            ['title' => 'Reliable ventilation', 'copy' => 'Side-hung and top-hung openings make rooms easy to air without complicating the design.'],
            ['title' => 'Secure by design', 'copy' => 'Modern locking, robust profiles and quality hardware help each opening feel reassuring.'],
            ['title' => 'Easy to maintain', 'copy' => 'Durable frame finishes keep regular cleaning simple and help the window retain its look.'],
        ],
        'cards' => [
            ['title' => 'Room-by-room design', 'copy' => 'Opening styles can be planned around bedrooms, kitchens, bathrooms and living spaces.'],
            ['title' => 'Frame and colour choice', 'copy' => 'Choose a finish that suits the property rather than settling for a standard replacement.'],
            ['title' => 'Surveyed for fit', 'copy' => 'Each aperture is checked before manufacture so reveals, handles and ventilation details work properly.'],
        ],
    ],
    'flush-casement-windows' => [
        'name' => 'flush casement windows',
        'label' => 'Flush casement windows',
        'thing' => 'flush casement windows',
        'opening' => 'Get a cleaner, more traditional-looking window with modern performance built in.',
        'benefits' => [
            ['title' => 'Neater sightlines', 'copy' => 'The sash sits flush in the frame for a more refined appearance inside and out.'],
            ['title' => 'Character-friendly style', 'copy' => 'Flush frames can suit older properties while still giving modern insulation and security.'],
            ['title' => 'Modern comfort', 'copy' => 'Weather seals, glazing and hardware are specified for warmth and daily use.'],
        ],
        'cards' => [
            ['title' => 'Traditional look', 'copy' => 'A balanced frame style works well where standard casements would look too heavy.'],
            ['title' => 'Colour flexibility', 'copy' => 'Frame colours and hardware can be chosen around brickwork, render and interior finishes.'],
            ['title' => 'Measured detail', 'copy' => 'Survey checks the reveal depth and frame position so the flush look lands cleanly.'],
        ],
    ],
    'sliding-sash-windows' => [
        'name' => 'sliding sash windows',
        'label' => 'Sliding sash windows',
        'thing' => 'sliding sash windows',
        'opening' => 'Keep the vertical sash look while improving comfort, security and operation.',
        'benefits' => [
            ['title' => 'Period proportions', 'copy' => 'Sash styling keeps the familiar vertical rhythm many older homes need.'],
            ['title' => 'Smoother operation', 'copy' => 'Modern balances and hardware make everyday opening easier than tired older units.'],
            ['title' => 'Better insulation', 'copy' => 'Modern glazing and seals help reduce draughts while retaining the sash appearance.'],
        ],
        'cards' => [
            ['title' => 'Heritage styling', 'copy' => 'Horn details, glazing bars and colour choices can be matched to the property.'],
            ['title' => 'Practical ventilation', 'copy' => 'Sliding openings give controllable airflow without projecting into the room or outside space.'],
            ['title' => 'Surveyed carefully', 'copy' => 'Openings, reveals and existing trim are checked so the replacement feels intentional.'],
        ],
    ],
    'french-casement-windows' => [
        'name' => 'French casement windows',
        'label' => 'French casement windows',
        'thing' => 'wide-opening French casement windows',
        'opening' => 'Open up the view with paired sashes and no fixed central mullion.',
        'benefits' => [
            ['title' => 'Clearer openings', 'copy' => 'Both sashes can open to create a broad, unobstructed aperture.'],
            ['title' => 'Useful ventilation', 'copy' => 'Flexible opening positions help rooms feel fresher through warmer months.'],
            ['title' => 'Balanced appearance', 'copy' => 'Paired casements can suit front elevations, bedrooms and feature windows.'],
        ],
        'cards' => [
            ['title' => 'Open views', 'copy' => 'The design is useful where a central bar would interrupt the outlook.'],
            ['title' => 'Secure hardware', 'copy' => 'Modern locking keeps the wide opening practical as well as attractive.'],
            ['title' => 'Made to measure', 'copy' => 'Survey checks clearances, hinges and frame position before manufacture.'],
        ],
    ],
    'tilt-turn-windows' => [
        'name' => 'tilt and turn windows',
        'label' => 'Tilt and turn windows',
        'thing' => 'tilt and turn windows',
        'opening' => 'Add flexible ventilation and easy cleaning with a smart dual-opening window.',
        'benefits' => [
            ['title' => 'Two opening modes', 'copy' => 'Tilt for gentle ventilation or turn inward for access and cleaning.'],
            ['title' => 'Good for upper floors', 'copy' => 'Inward opening can make maintenance easier where outside access is awkward.'],
            ['title' => 'Clean modern lines', 'copy' => 'The style works well for contemporary homes and practical family spaces.'],
        ],
        'cards' => [
            ['title' => 'Ventilation control', 'copy' => 'Tilt mode helps rooms breathe without opening the sash fully.'],
            ['title' => 'Practical cleaning', 'copy' => 'Turn mode brings the outside pane within reach from inside the home.'],
            ['title' => 'Specification support', 'copy' => 'Fenster checks handle positions, clearances and safety details during survey.'],
        ],
    ],
    'bow-bay-windows' => [
        'name' => 'bow and bay windows',
        'label' => 'Bow and bay windows',
        'thing' => 'bow and bay windows',
        'opening' => 'Refresh a feature window that shapes both the room and the front elevation.',
        'benefits' => [
            ['title' => 'More daylight', 'copy' => 'Angled and curved window shapes help draw light deeper into the room.'],
            ['title' => 'Kerb appeal', 'copy' => 'A properly detailed bay can change how the whole front of the home feels.'],
            ['title' => 'Careful structure', 'copy' => 'Survey checks support, projection, drainage and internal finish before work starts.'],
        ],
        'cards' => [
            ['title' => 'Feature proportions', 'copy' => 'Frame layout can be planned around the room, elevation and existing bay shape.'],
            ['title' => 'Thermal upgrade', 'copy' => 'Modern glazing and sealed frames help older bays feel less draughty.'],
            ['title' => 'Detailed survey', 'copy' => 'Bays need careful measurement so angles, cills and trims finish neatly.'],
        ],
    ],
    'aluminium-windows' => [
        'name' => 'aluminium windows',
        'label' => 'Aluminium windows',
        'thing' => 'slim aluminium windows',
        'opening' => 'Bring slimmer frames, strong profiles and a crisp modern finish to the home.',
        'benefits' => [
            ['title' => 'Slim sightlines', 'copy' => 'Aluminium frames can maximise glass area while keeping the structure strong.'],
            ['title' => 'Durable finish', 'copy' => 'Powder-coated aluminium is built for long-term colour stability and low maintenance.'],
            ['title' => 'Modern performance', 'copy' => 'Thermally broken frames and efficient glazing help balance style with comfort.'],
        ],
        'cards' => [
            ['title' => 'Sharper appearance', 'copy' => 'Clean frame lines suit extensions, larger openings and contemporary replacements.'],
            ['title' => 'Colour choice', 'copy' => 'RAL colours can be chosen to match doors, roof lanterns or external details.'],
            ['title' => 'Strong frames', 'copy' => 'Aluminium is well suited to larger panes and exposed elevations.'],
        ],
    ],
    'aluminium-flush-windows' => [
        'name' => 'aluminium flush windows',
        'label' => 'Aluminium flush windows',
        'thing' => 'flush aluminium windows',
        'opening' => 'Combine slim aluminium strength with a cleaner flush frame appearance.',
        'benefits' => [
            ['title' => 'Flush finish', 'copy' => 'The sash sits neatly in the frame for a sharper, more architectural window line.'],
            ['title' => 'Slim aluminium', 'copy' => 'Strong aluminium profiles support larger glass areas and crisp sightlines.'],
            ['title' => 'Low maintenance', 'copy' => 'Powder-coated frames keep their finish with simple cleaning and routine care.'],
        ],
        'cards' => [
            ['title' => 'Modern replacement', 'copy' => 'A good choice where standard windows would look too bulky or traditional.'],
            ['title' => 'Colour control', 'copy' => 'RAL finishes can coordinate with doors, roof lanterns and exterior details.'],
            ['title' => 'Surveyed lines', 'copy' => 'Frame position, reveal depth and opening style are checked before manufacture.'],
        ],
    ],
    'heritage-windows' => [
        'name' => 'heritage windows',
        'label' => 'Heritage windows',
        'thing' => 'heritage-style windows',
        'opening' => 'Choose slimmer, character-led frames for homes that need a more considered finish.',
        'benefits' => [
            ['title' => 'Character detail', 'copy' => 'Heritage styling can echo traditional metal windows without losing modern comfort.'],
            ['title' => 'Slim divisions', 'copy' => 'Narrow glazing bars and frame profiles help the window feel lighter.'],
            ['title' => 'Modern specification', 'copy' => 'Security, glazing and frame performance are built into the finished design.'],
        ],
        'cards' => [
            ['title' => 'Sensitive replacements', 'copy' => 'Useful where ordinary frames would look too bulky or plain.'],
            ['title' => 'Finish options', 'copy' => 'Colours and hardware can be selected around the character of the building.'],
            ['title' => 'Survey-led fitting', 'copy' => 'Existing openings are checked carefully so the new frames sit neatly.'],
        ],
    ],
    'aluminium-bifold-doors' => [
        'name' => 'aluminium bifold doors',
        'label' => 'Aluminium bifold doors',
        'thing' => 'aluminium bifold doors',
        'opening' => 'Open the back of the home with folding panels, slim frames and a stronger garden connection.',
        'benefits' => [
            ['title' => 'Wide openings', 'copy' => 'Panels fold back to create a flexible connection between inside and outside.'],
            ['title' => 'Slim aluminium frames', 'copy' => 'Strong profiles keep sightlines neat without making the door feel heavy.'],
            ['title' => 'Made for daily use', 'copy' => 'Thresholds, traffic doors and opening direction can be planned around how the room works.'],
        ],
        'cards' => [
            ['title' => 'Extension ready', 'copy' => 'Bifolds are often ideal for kitchens, dining rooms and renovation projects.'],
            ['title' => 'Configurable panels', 'copy' => 'Panel count, opening direction, colour and hardware can be tailored to the aperture.'],
            ['title' => 'Surveyed thresholds', 'copy' => 'Survey checks levels, drainage, access and structure before manufacture.'],
        ],
    ],
    'slide-fold-doors' => [
        'name' => 'slide and fold doors',
        'label' => 'Slide and fold doors',
        'thing' => 'slide and fold doors',
        'opening' => 'Create a flexible glazed opening with panels that can move around the space differently to standard bifolds.',
        'benefits' => [
            ['title' => 'Flexible opening', 'copy' => 'Panels can be configured around the way the room connects to the garden or adjoining space.'],
            ['title' => 'Strong glazed panels', 'copy' => 'Modern profiles and hardware keep large glass sections stable and secure.'],
            ['title' => 'Practical access', 'copy' => 'Traffic flow, furniture positions and threshold details can be planned together.'],
        ],
        'cards' => [
            ['title' => 'Room-led layout', 'copy' => 'The configuration can be shaped around kitchens, dining spaces and extensions.'],
            ['title' => 'Hardware choices', 'copy' => 'Handles, locking and running gear are specified around daily use.'],
            ['title' => 'Measured threshold', 'copy' => 'Survey checks levels, drainage and structure before doors are ordered.'],
        ],
    ],
    'aluminium-sliding-doors' => [
        'name' => 'aluminium sliding doors',
        'label' => 'Aluminium sliding doors',
        'thing' => 'slim aluminium sliding doors',
        'opening' => 'Use larger panes and slim frames to keep garden views open while saving floor space.',
        'benefits' => [
            ['title' => 'Wide glass areas', 'copy' => 'Aluminium sliders can carry larger panes for a more open view.'],
            ['title' => 'Space-saving movement', 'copy' => 'Sliding panels do not swing into the room or out onto the patio.'],
            ['title' => 'Smooth operation', 'copy' => 'Tracks, rollers and locking are chosen so the door feels easy to use.'],
        ],
        'cards' => [
            ['title' => 'Large openings', 'copy' => 'Dual and triple-track options can suit wider apertures and extension projects.'],
            ['title' => 'Slim sightlines', 'copy' => 'Narrow aluminium profiles help keep the focus on the glass and the view.'],
            ['title' => 'Surveyed tracks', 'copy' => 'Track position, drainage, thresholds and access are checked before manufacture.'],
        ],
    ],
    'aluminium-doors' => [
        'name' => 'aluminium doors',
        'label' => 'Aluminium doors',
        'thing' => 'aluminium doors',
        'opening' => 'Choose strong, crisp aluminium doors for entrances, side doors and glazed openings.',
        'benefits' => [
            ['title' => 'Robust frames', 'copy' => 'Aluminium gives strength and stability for busy entrances and larger glazed designs.'],
            ['title' => 'Modern styling', 'copy' => 'Clean profiles and colour choice help the door match contemporary homes and extensions.'],
            ['title' => 'Secure hardware', 'copy' => 'Modern locking and quality components keep the finished door reassuring.'],
        ],
        'cards' => [
            ['title' => 'Entrance options', 'copy' => 'Aluminium can work for front doors, side doors and feature glazed entrances.'],
            ['title' => 'Colour matching', 'copy' => 'Door frames can be coordinated with aluminium windows, bifolds or sliders.'],
            ['title' => 'Surveyed fit', 'copy' => 'Thresholds, access and frame positions are checked before the order is made.'],
        ],
    ],
    'heritage-aluminium-doors' => [
        'name' => 'heritage aluminium doors',
        'label' => 'Heritage aluminium doors',
        'thing' => 'heritage-style aluminium doors',
        'opening' => 'Add steel-look character with modern aluminium performance and secure hardware.',
        'benefits' => [
            ['title' => 'Heritage detail', 'copy' => 'Slim bars and classic proportions suit character homes, extensions and internal-style openings.'],
            ['title' => 'Modern aluminium', 'copy' => 'Thermally broken frames, durable finishes and modern glazing improve everyday comfort.'],
            ['title' => 'Secure specification', 'copy' => 'Locking, hinges and glass are selected around the opening and use of the door.'],
        ],
        'cards' => [
            ['title' => 'Steel-look style', 'copy' => 'A heritage aluminium door can add character without the upkeep of traditional steel.'],
            ['title' => 'Colour and bars', 'copy' => 'Frame colour, glazing bars and hardware can be chosen around the property.'],
            ['title' => 'Careful survey', 'copy' => 'Fenster checks reveals, thresholds and clearances so the design fits neatly.'],
        ],
    ],
    'composite-doors' => [
        'name' => 'composite doors',
        'label' => 'Composite doors',
        'thing' => 'secure composite doors',
        'opening' => 'Give the entrance a stronger, warmer and more personal front door.',
        'benefits' => [
            ['title' => 'Secure entrance', 'copy' => 'Composite construction, modern locking and robust hardware help protect the home.'],
            ['title' => 'Warmer threshold', 'copy' => 'A well-fitted composite door can reduce draughts around tired entrances.'],
            ['title' => 'Designed around you', 'copy' => 'Choose colour, glazing, furniture and style to suit the property.'],
        ],
        'cards' => [
            ['title' => 'Front door refresh', 'copy' => 'A new entrance can improve kerb appeal as well as everyday security.'],
            ['title' => 'Style choices', 'copy' => 'Traditional, modern and glazed door designs can be matched to the home.'],
            ['title' => 'Measured threshold', 'copy' => 'Survey checks the opening, cill, frame and threshold detail before manufacture.'],
        ],
    ],
    'upvc-doors' => [
        'name' => 'uPVC doors',
        'label' => 'uPVC doors',
        'thing' => 'low-maintenance uPVC doors',
        'opening' => 'Choose a practical, efficient and easy-care door for everyday entrances.',
        'benefits' => [
            ['title' => 'Low maintenance', 'copy' => 'uPVC is straightforward to clean and suits busy homes that need practical finishes.'],
            ['title' => 'Good insulation', 'copy' => 'Modern glazing, panels and seals help the entrance feel warmer.'],
            ['title' => 'Everyday security', 'copy' => 'Multi-point locking and robust hardware give reliable day-to-day protection.'],
        ],
        'cards' => [
            ['title' => 'Front and back doors', 'copy' => 'uPVC works well for main entrances, utility doors and garden access.'],
            ['title' => 'Glazed choices', 'copy' => 'Panel and glass layouts can balance privacy, daylight and style.'],
            ['title' => 'Neat installation', 'copy' => 'Survey checks thresholds, drainage and frame position before manufacture.'],
        ],
    ],
    'patio-doors' => [
        'name' => 'patio doors',
        'label' => 'Patio doors',
        'thing' => 'sliding patio doors',
        'opening' => 'Add a smooth garden opening without needing swing space inside or outside.',
        'benefits' => [
            ['title' => 'Space-saving access', 'copy' => 'Sliding panels are useful where hinged or folding doors would interrupt the room.'],
            ['title' => 'More glass', 'copy' => 'Large panes help bring daylight into kitchens, dining rooms and living spaces.'],
            ['title' => 'Smooth operation', 'copy' => 'Tracks, rollers and locking are specified so the door feels easy to use.'],
        ],
        'cards' => [
            ['title' => 'Garden connection', 'copy' => 'Patio doors keep views open and make everyday access simple.'],
            ['title' => 'Large apertures', 'copy' => 'Configurations can be chosen around the width and use of the opening.'],
            ['title' => 'Surveyed levels', 'copy' => 'Track, threshold and drainage details are checked before the door is made.'],
        ],
    ],
    'french-doors' => [
        'name' => 'French doors',
        'label' => 'French doors',
        'thing' => 'French doors',
        'opening' => 'Create a classic double-door opening for gardens, patios and smaller apertures.',
        'benefits' => [
            ['title' => 'Classic style', 'copy' => 'French doors suit traditional homes and neat garden openings.'],
            ['title' => 'Flexible access', 'copy' => 'Open one leaf for everyday use or both for a wider connection.'],
            ['title' => 'Secure and efficient', 'copy' => 'Modern glazing, seals and locking bring the classic design up to date.'],
        ],
        'cards' => [
            ['title' => 'Balanced openings', 'copy' => 'Useful where a bifold or slider would be unnecessary for the size of aperture.'],
            ['title' => 'Frame options', 'copy' => 'Colours, handles and glazing can be matched to existing windows and doors.'],
            ['title' => 'Surveyed swing', 'copy' => 'Opening direction, clearances and threshold height are checked before manufacture.'],
        ],
    ],
    'integral-blinds' => [
        'name' => 'integral blinds',
        'label' => 'Integral blinds',
        'thing' => 'integral blinds between glass',
        'opening' => 'Add privacy and solar control with blinds sealed inside the glass unit.',
        'benefits' => [
            ['title' => 'No loose cords', 'copy' => 'The blind sits between panes, keeping the room cleaner and the operation tidy.'],
            ['title' => 'Useful privacy', 'copy' => 'Ideal for doors, kitchens, bathrooms and overlooked rooms.'],
            ['title' => 'Protected finish', 'copy' => 'Because the blind is sealed inside the unit, it is protected from dust and handling.'],
        ],
        'cards' => [
            ['title' => 'Door glazing', 'copy' => 'Integral blinds work especially well in bifold, patio and French door glass.'],
            ['title' => 'Light control', 'copy' => 'Tilt and raise options help manage privacy and glare through the day.'],
            ['title' => 'Specification check', 'copy' => 'Fenster confirms glass sizes, compatibility and operation before ordering.'],
        ],
    ],
    'roof-lanterns' => [
        'name' => 'roof lanterns',
        'label' => 'Roof lanterns',
        'thing' => 'roof lanterns',
        'opening' => 'Bring daylight from above into extensions, kitchens and flat roof spaces.',
        'benefits' => [
            ['title' => 'Overhead daylight', 'copy' => 'A lantern can brighten the centre of a room where wall glazing is limited.'],
            ['title' => 'Slim structure', 'copy' => 'Modern aluminium profiles keep the rooflight crisp and elegant.'],
            ['title' => 'Thermal glass', 'copy' => 'Glazing choices can help balance light, heat retention and solar control.'],
        ],
        'cards' => [
            ['title' => 'Extension focus', 'copy' => 'Roof lanterns often transform kitchens, dining rooms and flat roof additions.'],
            ['title' => 'Glass options', 'copy' => 'Solar control, self-cleaning and thermal glass can be discussed during specification.'],
            ['title' => 'Opening checks', 'copy' => 'Survey confirms upstand, size and installation details before manufacture.'],
        ],
    ],
];

$aliases = [
    'bow-and-bay-windows' => 'bow-bay-windows',
];

$location_slug = '';
$location = null;
foreach ($locations as $candidate_slug => $candidate_location) {
    if ($slug === 'double-glazing-' . $candidate_slug || str_ends_with($slug, '-' . $candidate_slug)) {
        $location_slug = $candidate_slug;
        $location = $candidate_location;
        break;
    }
}

$service_slug = $location_slug !== '' ? preg_replace('/-' . preg_quote($location_slug, '/') . '$/', '', $slug) : 'double-glazing';
$service_slug = $aliases[$service_slug] ?? $service_slug;
$service = $services[$service_slug] ?? $services['double-glazing'];
$location_product_media = fenster_data('product_media.' . $service_slug, []);
$location_product_media = is_array($location_product_media) ? $location_product_media : [];
$location_gallery_group_map = fenster_data('product_gallery_groups', []);
$location_gallery_group_map = is_array($location_gallery_group_map) ? $location_gallery_group_map : [];
$location_gallery_group = (string) ($location_gallery_group_map[$service_slug] ?? '');
$location_gallery_pool = $location_gallery_group !== '' ? fenster_data('product_gallery_pools.' . $location_gallery_group, []) : [];
$location_gallery_pool = is_array($location_gallery_pool) ? $location_gallery_pool : [];
$normalise_location_image = static function ($image) use ($title): ?array {
    if (! is_array($image)) {
        return null;
    }

    $src = trim((string) ($image['src'] ?? ''));
    if ($src === '') {
        return null;
    }

    $alt = trim((string) ($image['alt'] ?? ''));

    return [
        'src' => $src,
        'alt' => $alt !== '' ? $alt : $title,
    ];
};

if (! empty($location_product_media['hero'])) {
    $normalised_hero_image = $normalise_location_image($location_product_media['hero']);
    if (is_array($normalised_hero_image)) {
        $hero_image = $normalised_hero_image;
    }
}

$curated_location_images = [];
$curated_location_seen = [];
$location_hero_src = is_array($hero_image) ? trim((string) ($hero_image['src'] ?? '')) : '';
foreach (array_merge((array) ($location_product_media['gallery'] ?? []), $location_gallery_pool) as $image) {
    $normalised_image = $normalise_location_image($image);
    if (is_array($normalised_image)) {
        $image_src = (string) $normalised_image['src'];
        if ($image_src === $location_hero_src || isset($curated_location_seen[$image_src])) {
            continue;
        }

        $curated_location_seen[$image_src] = true;
        $curated_location_images[] = $normalised_image;
    }
}

if (! empty($curated_location_images)) {
    $gallery_images = $curated_location_images;
}
$location = is_array($location) ? $location : $locations['milton-keynes'];

$location_name = $location['name'];
$service_label = $service['label'];
$service_name = $service['name'];
$thing = $service['thing'];
$is_mk_double_glazing_page = $slug === 'double-glazing-milton-keynes';
$hero_media_src = is_array($hero_image) ? (string) ($hero_image['src'] ?? '') : '';
$side_image = $gallery_images[0] ?? $hero_image;
$second_image = $gallery_images[1] ?? null;
$third_image = $gallery_images[2] ?? null;

$town_profiles = [
    'ampthill' => [
        'hero' => 'character properties, careful colour choices and upgrades that do not overpower the home',
        'intro' => 'Ampthill projects often need a balance of improved comfort, sympathetic styling and tidy fitting around established brickwork or older details.',
        'survey' => 'Survey checks focus on existing reveals, frame depth and external finish so the installation sits naturally with the property.',
        'property' => 'character homes, modernised family houses and compact town properties',
    ],
    'aylesbury' => [
        'hero' => 'family homes, newer estates and older properties that need practical, good-looking glazing',
        'intro' => 'Aylesbury homes can vary street by street, so the best result usually comes from choosing the right product style before sizes are confirmed.',
        'survey' => 'Survey checks cover access, thresholds, existing openings and finishing details before anything is ordered.',
        'property' => 'newer estates, older houses, extensions and busy family spaces',
    ],
    'bedford' => [
        'hero' => 'mixed property styles, riverside locations and family renovations where detail matters',
        'intro' => 'Bedford projects often need glazing that suits varied property ages while improving warmth, security and day-to-day use.',
        'survey' => 'Survey checks look closely at opening condition, drainage, surrounding trim and how the finish will meet the building.',
        'property' => 'riverside homes, town properties, terraces and family renovation projects',
    ],
    'buckingham' => [
        'hero' => 'village homes, traditional proportions and extensions that need a measured finish',
        'intro' => 'Buckingham homes often benefit from products that improve comfort while keeping the building balanced from the outside.',
        'survey' => 'Survey checks focus on proportions, cills, reveals and details that affect how the finished work looks from the street.',
        'property' => 'village properties, family houses, older homes and extensions',
    ],
    'dunstable' => [
        'hero' => 'homes where road noise, weather exposure and low-maintenance finishes often matter',
        'intro' => 'Dunstable projects frequently call for practical product choices that improve comfort without adding unnecessary upkeep.',
        'survey' => 'Survey checks include seals, frame condition, exposure and fitting details that help the final installation perform properly.',
        'property' => 'established estates, hillside homes, busy-road properties and family houses',
    ],
    'flitwick' => [
        'hero' => 'commuter homes, family spaces and renovations that need reliable everyday performance',
        'intro' => 'Flitwick homeowners often want glazing that is easy to maintain, secure and well matched to the rest of the property.',
        'survey' => 'Survey checks focus on access, thresholds, reveals and finishes so the installation runs smoothly around daily life.',
        'property' => 'commuter homes, family properties, extensions and practical replacement projects',
    ],
    'hitchin' => [
        'hero' => 'town properties, character homes and upgrades where appearance is as important as performance',
        'intro' => 'Hitchin homes often need careful style decisions, especially where frame proportions, colour and sightlines affect the final look.',
        'survey' => 'Survey checks help confirm how the product will sit with brickwork, render, existing trim and nearby openings.',
        'property' => 'town houses, period homes, modern extensions and conservation-sensitive upgrades',
    ],
    'leighton-buzzard' => [
        'hero' => 'market-town homes, village properties and commuter households that need a tidy, durable finish',
        'intro' => 'Leighton Buzzard projects often combine older brickwork, newer estates and family entrances, so survey detail is important.',
        'survey' => 'Survey checks include access, existing frame condition and the details that affect a clean finish around the opening.',
        'property' => 'market-town homes, nearby village properties, commuter houses and extensions',
    ],
    'letchworth' => [
        'hero' => 'garden city homes, considered renovations and glazing that needs clean proportions',
        'intro' => 'Letchworth projects often call for neat sightlines, sympathetic colours and upgrades that do not feel heavy on the building.',
        'survey' => 'Survey checks consider proportions, frame position and visible finishing details before the order is confirmed.',
        'property' => 'garden city properties, family homes, renovations and carefully styled replacements',
    ],
    'luton' => [
        'hero' => 'busy homes, replacement projects and glazing where security and noise control are often priorities',
        'intro' => 'Luton homeowners often need products that are practical, secure and able to handle everyday use without fussy upkeep.',
        'survey' => 'Survey checks cover access, frame condition, threshold details and practical fitting around lived-in homes.',
        'property' => 'busy streets, family homes, extensions and replacement glazing projects',
    ],
    'northampton' => [
        'hero' => 'terraces, detached homes, extensions and mixed-age properties that need robust products',
        'intro' => 'Northampton projects often need secure, weather-tight glazing that suits varied property styles and busy family use.',
        'survey' => 'Survey checks focus on opening condition, fixing points, seals and the practical finish around each aperture.',
        'property' => 'terraces, detached homes, extensions and established residential streets',
    ],
    'stevenage' => [
        'hero' => 'family homes, extensions and straightforward upgrades for warmer, quieter rooms',
        'intro' => 'Stevenage projects often work best with low-maintenance products, clear specification choices and efficient fitting.',
        'survey' => 'Survey checks include existing openings, access, hardware positions and the details that keep installation tidy.',
        'property' => 'family houses, estates, extensions and replacement projects',
    ],
    'toddington' => [
        'hero' => 'village homes, period properties and modern extensions that need measured detailing',
        'intro' => 'Toddington homes often need products that handle character details while still improving comfort and security.',
        'survey' => 'Survey checks focus on older openings, trim, thresholds and how new frames will meet existing finishes.',
        'property' => 'village homes, period properties, cottages and newer extensions',
    ],
];

$product_profiles = [
    'double-glazing' => [
        'hero' => 'whole-home comfort, efficient sealed units and frame choices that work together',
        'choices' => 'glass specification, frame material, opening style and matching doors or replacement units',
        'detail' => 'thermal performance, seals, security and how different products meet across the home',
        'style' => 'frame style, glass choice and hardware can be matched across windows and doors for a more consistent finish',
        'package' => 'Fenster can review related windows, doors, failed units and glass upgrades together so the work feels joined up.',
    ],
    'casement-windows' => [
        'hero' => 'practical window openings, dependable ventilation and secure everyday use',
        'choices' => 'side-hung or top-hung openings, frame colour, handle positions and glazing options',
        'detail' => 'room-by-room opening direction, ventilation, security and easy maintenance',
        'style' => 'casement layout, colour and hardware can be matched to the rest of the property',
        'package' => 'Fenster can also discuss matching doors, replacement glass or other window styles during the same enquiry.',
    ],
    'flush-casement-windows' => [
        'hero' => 'clean flush lines, traditional character and modern weather performance',
        'choices' => 'flush frame style, colour, glazing bars, hardware finish and sightline balance',
        'detail' => 'reveal depth, frame position and the details that make the flush finish look intentional',
        'style' => 'colours, handles and glazing bar options can be chosen to suit character homes or cleaner contemporary elevations',
        'package' => 'Fenster can compare flush windows with casement, sash or heritage options if the property needs a specific look.',
    ],
    'sliding-sash-windows' => [
        'hero' => 'vertical sash styling, smoother operation and improved comfort in older-looking openings',
        'choices' => 'sash proportions, horn detail, glazing bars, colour and hardware finish',
        'detail' => 'balance, ventilation, frame depth and the features that keep sash windows easy to use',
        'style' => 'sash proportions and decorative details can be chosen around the age and frontage of the home',
        'package' => 'Fenster can review other front-elevation windows at the same time so the property does not feel mismatched.',
    ],
    'french-casement-windows' => [
        'hero' => 'wide-opening paired sashes, clearer views and useful ventilation',
        'choices' => 'paired sash layout, hinge direction, locking, colour and glass choice',
        'detail' => 'clear opening width, handle positions, secure locking and how the window works day to day',
        'style' => 'the paired layout can be matched to bedrooms, front elevations or feature windows where a central mullion would look heavy',
        'package' => 'Fenster can compare French casements with standard casements if only some rooms need the wider opening.',
    ],
    'tilt-turn-windows' => [
        'hero' => 'dual-opening windows for ventilation, access and easier cleaning',
        'choices' => 'tilt and turn operation, handle positions, frame colour and safety details',
        'detail' => 'clearances, inward opening space, ventilation control and secure operation',
        'style' => 'tilt and turn windows can be specified with a clean modern finish for practical rooms and upper floors',
        'package' => 'Fenster can review which rooms suit tilt and turn operation and where another window style may feel better.',
    ],
    'bow-bay-windows' => [
        'hero' => 'feature window shapes, more daylight and careful detailing around projection and support',
        'choices' => 'bay shape, frame layout, glass choice, cills, trims and internal finish',
        'detail' => 'support, angles, drainage, sightlines and the finish inside the room',
        'style' => 'frame divisions and colour can be chosen to suit the frontage and the proportions of the bay',
        'package' => 'Fenster can review adjoining windows or doors so the feature bay works with the rest of the home.',
    ],
    'aluminium-windows' => [
        'hero' => 'slimmer frames, strong profiles and crisp modern sightlines',
        'choices' => 'aluminium profile, colour, glass specification, opening style and hardware',
        'detail' => 'sightlines, frame strength, thermal break, locking and finish around the opening',
        'style' => 'aluminium colours and slim profiles can be coordinated with bifolds, sliders or modern entrance doors',
        'package' => 'Fenster can discuss aluminium doors alongside the windows where a consistent modern finish matters.',
    ],
    'aluminium-flush-windows' => [
        'hero' => 'flush aluminium lines, slim frames and a clean contemporary finish',
        'choices' => 'flush profile, powder-coated colour, glazing, opening layout and hardware',
        'detail' => 'flush alignment, sightline balance, reveal depth and colour matching',
        'style' => 'flush aluminium can be specified for a cleaner look where standard windows would feel too bulky',
        'package' => 'Fenster can compare flush aluminium with standard aluminium or heritage-style frames before you decide.',
    ],
    'heritage-windows' => [
        'hero' => 'slim heritage styling, glazing bar detail and modern performance for character openings',
        'choices' => 'heritage profile, glazing bars, colour, hardware and opening layout',
        'detail' => 'bar spacing, frame depth, sightlines and how new frames relate to existing architecture',
        'style' => 'heritage-style windows can be chosen to suit older properties without giving up modern security and glazing options',
        'package' => 'Fenster can review matching heritage doors or aluminium alternatives if the project covers several openings.',
    ],
    'aluminium-bifold-doors' => [
        'hero' => 'folding panels, slim frames and a stronger connection to the garden',
        'choices' => 'panel count, opening direction, threshold, colour, glass and integral blind options',
        'detail' => 'threshold height, drainage, traffic door position, panel stack and access through the room',
        'style' => 'frame colour, handle finish and glass options can be matched to surrounding windows or other aluminium doors',
        'package' => 'Fenster can review side windows, roof lanterns or matching doors if the bifold is part of a larger extension.',
    ],
    'slide-fold-doors' => [
        'hero' => 'flexible opening panels, practical access and a wide glazed connection outside',
        'choices' => 'panel configuration, traffic door, threshold detail, colour and glass specification',
        'detail' => 'stacking space, access, drainage, panel weight and how the door is used every day',
        'style' => 'slide and fold doors can be styled to match aluminium windows, roof lanterns or other garden doors',
        'package' => 'Fenster can compare slide-fold, bifold and sliding door options if you are not sure which opening style suits the room.',
    ],
    'aluminium-sliding-doors' => [
        'hero' => 'large panes of glass, smooth sliding operation and slim modern frames',
        'choices' => 'track layout, sash size, threshold, colour, glass and locking options',
        'detail' => 'sightlines, drainage, opening width, track position and the size of the fixed glass panels',
        'style' => 'sliding doors can be matched with aluminium windows, roof lanterns or slim modern glazing elsewhere in the home',
        'package' => 'Fenster can compare sliders with bifolds where you want more glass but still need practical access.',
    ],
    'aluminium-doors' => [
        'hero' => 'strong aluminium frames, modern styling and secure everyday entrances',
        'choices' => 'door style, panel design, colour, glass, hardware and threshold detail',
        'detail' => 'locking, traffic flow, frame strength, weathering and how the door meets the existing opening',
        'style' => 'aluminium doors can be matched to modern windows, bifolds or sliding doors for a consistent finish',
        'package' => 'Fenster can review entrance, side and garden doors together if several openings need upgrading.',
    ],
    'heritage-aluminium-doors' => [
        'hero' => 'heritage-style aluminium, slim glazing bars and secure modern operation',
        'choices' => 'bar layout, door configuration, colour, glass and handle finish',
        'detail' => 'bar spacing, threshold, locking, frame depth and how the door works with older details',
        'style' => 'heritage aluminium can suit character homes, internal-style partitions or garden rooms that need slim framing',
        'package' => 'Fenster can review matching heritage windows or alternative aluminium door styles where the project needs consistency.',
    ],
    'composite-doors' => [
        'hero' => 'secure entrance doors, insulated slabs and a strong first impression',
        'choices' => 'door style, colour, glass design, hardware, letterplate and threshold',
        'detail' => 'security, weathering, slab style, frame finish and how the entrance is used each day',
        'style' => 'door colour, glass and furniture can be chosen around the age and frontage of the home',
        'package' => 'Fenster can also discuss side panels, matching windows or other entrance doors during the same enquiry.',
    ],
    'upvc-doors' => [
        'hero' => 'low-maintenance doors, reliable security and practical everyday access',
        'choices' => 'door style, colour, glass panel, hardware, threshold and opening direction',
        'detail' => 'locking, weather seals, threshold height and the finish around busy entrances',
        'style' => 'uPVC doors can be chosen to match existing windows or provide a simple clean entrance upgrade',
        'package' => 'Fenster can review front, rear and side doors together where a property needs several practical upgrades.',
    ],
    'patio-doors' => [
        'hero' => 'sliding garden access, straightforward operation and more useful daylight',
        'choices' => 'sliding configuration, threshold, frame colour, glass and locking',
        'detail' => 'track condition, drainage, opening width, handle position and everyday access',
        'style' => 'patio doors can be matched with surrounding windows or chosen as a simpler alternative to bifolds',
        'package' => 'Fenster can compare patio, bifold and French doors if the garden opening needs a new approach.',
    ],
    'french-doors' => [
        'hero' => 'paired garden doors, traditional styling and flexible ventilation',
        'choices' => 'opening direction, threshold, side panels, colour, glass and hardware',
        'detail' => 'clearance, locking, weathering, traffic route and how both leaves open in the space',
        'style' => 'French doors can be specified to suit older homes, extensions or garden rooms where hinged access feels right',
        'package' => 'Fenster can review adjacent windows or alternative patio and bifold options before you choose.',
    ],
    'integral-blinds' => [
        'hero' => 'privacy and light control sealed safely inside the glass',
        'choices' => 'magnetic or electric controls, blind colour, glass unit, door compatibility and operation',
        'detail' => 'glass sizes, control type, privacy needs and compatibility with doors or windows',
        'style' => 'blind colour and control style can be chosen to suit kitchens, doors and overlooked rooms',
        'package' => 'Fenster can discuss integral blinds as part of new doors, replacement glass or wider glazing upgrades.',
    ],
    'roof-lanterns' => [
        'hero' => 'overhead daylight, slim aluminium structure and better light in extensions',
        'choices' => 'lantern size, frame colour, glass specification, upstand detail and solar control',
        'detail' => 'upstand size, drainage, glass weight, thermal performance and how the lantern sits over the room',
        'style' => 'roof lantern frame colour and glass can be chosen around the extension, kitchen or dining space below',
        'package' => 'Fenster can review roof lanterns alongside bifolds, sliding doors or windows for a complete extension package.',
    ],
];

$town_profile = $town_profiles[$location_slug] ?? [
    'hero' => $location['angle'],
    'intro' => 'Fenster helps match the product, survey and installation detail to the property rather than treating every opening the same.',
    'survey' => 'Survey checks confirm sizes, access and finishing details before anything is ordered.',
    'property' => $location['area'],
];
$product_profile = $product_profiles[$service_slug] ?? $product_profiles['double-glazing'];
$copy_variants = [
    [
        'hero_join' => 'For ' . $location_name . ', we factor in',
        'survey_title' => 'Checked before ordering',
        'process_review' => 'Compare the right options',
    ],
    [
        'hero_join' => 'Around ' . $location_name . ', we plan for',
        'survey_title' => 'Measured before manufacture',
        'process_review' => 'Shape the specification',
    ],
    [
        'hero_join' => 'In ' . $location_name . ', the survey considers',
        'survey_title' => 'Surveyed for the property',
        'process_review' => 'Choose the right finish',
    ],
];
$copy_variant = $copy_variants[abs((int) crc32($slug)) % count($copy_variants)];
$hero_copy = $service['opening'] . ' ' . $copy_variant['hero_join'] . ' ' . $town_profile['hero'] . '. The specification focuses on ' . $product_profile['hero'] . '.';
$intro_copy = $town_profile['intro'] . ' We help you compare ' . $product_profile['choices'] . ' so the survey can confirm exact sizes and fitting details.';

if ($is_mk_double_glazing_page) {
    $hero_copy = 'Windows, doors, bifolds, roof lanterns and replacement glass fitted across Milton Keynes. Get an online guide price, then Fenster checks the exact sizes, vents, cills, glass and fitting details at survey.';
    $intro_copy = 'Fenster helps you compare the main product options, see what changes the price, and choose the right specification before anything is ordered.';
}

$hero_trust_messages = [
    ['title' => 'Hundreds of customer reviews', 'copy' => 'Feedback across Google and Trustpilot.', 'item' => $trust_items[0] ?? null],
    ['title' => 'Rated Excellent', 'copy' => 'Independent feedback on Trustpilot.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
    ['title' => 'Insurance-backed protection', 'copy' => 'Supported by the Consumer Protection Association.', 'item' => $trust_items[3] ?? null],
];
$local_points = [
    [
        'title' => 'Planned for ' . $location_name,
        'copy' => $service_label . ' projects in ' . $location_name . ' are specified around ' . $town_profile['property'] . ', with attention to ' . $product_profile['detail'] . '.',
    ],
    [
        'title' => 'Choices that suit the home',
        'copy' => 'Fenster helps compare ' . $product_profile['choices'] . ' so the finished installation feels right for the room and the outside of the property.',
    ],
    [
        'title' => $copy_variant['survey_title'],
        'copy' => $town_profile['survey'] . ' This helps the finished installation work properly once it is fitted.',
    ],
];
$service_route_map = [
    'double-glazing' => 'double-glazing-milton-keynes',
    'bow-bay-windows' => 'windows-milton-keynes',
    'french-casement-windows' => 'windows-milton-keynes',
];
$service_route_slug = $service_route_map[$service_slug] ?? $service_slug;
$service_route_url = home_url('/' . $service_route_slug . '/');
$town_double_glazing_url = home_url('/double-glazing-' . $location_slug . '/');
$local_decision_cards = [
    [
        'title' => 'Start with the property',
        'copy' => $location_name . ' projects are not all the same. The first check is the house type, the opening, access, existing frame condition and what you want the room or entrance to do better.',
    ],
    [
        'title' => 'Choose the right product route',
        'copy' => 'Fenster narrows the choice around ' . $product_profile['choices'] . ', then checks whether a related window, door, glass or roof glazing option should be considered at the same time.',
    ],
    [
        'title' => 'Move from idea to price',
        'copy' => 'Use the instant quote tool if you know the rough product and size, or send photos first if you need help choosing before survey.',
    ],
];
$process_steps = [
    ['step' => '01', 'title' => 'Tell us about the property', 'copy' => 'Share the product, rough sizes, photos or plans and what you want to improve.'],
    ['step' => '02', 'title' => $copy_variant['process_review'], 'copy' => 'We talk through ' . $product_profile['choices'] . ' and narrow the options around your ' . $location_name . ' home.'],
    ['step' => '03', 'title' => 'Survey the details', 'copy' => $town_profile['survey']],
    ['step' => '04', 'title' => 'Fit and support', 'copy' => 'The installation is completed carefully, then supported with aftercare and guarantee guidance.'],
];
$faqs = [
    [
        'question' => 'Can Fenster quote for ' . $service_name . ' in ' . $location_name . '?',
        'answer' => 'Yes. Send the basics through the form and the team can discuss ' . $product_profile['choices'] . ', likely survey requirements and installation timing for your ' . $location_name . ' property.',
    ],
    [
        'question' => 'Will the ' . $service_name . ' be surveyed before manufacture?',
        'answer' => 'Yes. ' . $town_profile['survey'],
    ],
    [
        'question' => 'Can the style be matched to the rest of the home?',
        'answer' => 'Yes. ' . ucfirst($product_profile['style']) . '.',
    ],
    [
        'question' => 'Do you handle related windows, doors or glass at the same time?',
        'answer' => 'Yes. ' . $product_profile['package'],
    ],
];

if ($is_mk_double_glazing_page) {
    $local_points = [
        [
            'title' => 'Online prices before the appointment',
            'copy' => 'Fenster can price many standard windows and doors through WindowCAD before a home visit. That gives you a sensible guide price early, not a vague promise to quote later.',
        ],
        [
            'title' => 'Survey confirms the exact specification',
            'copy' => 'The survey checks sizes, cill depth, trickle vents, safety glass, openings, access, reveals and finishing trims. Those details decide the final order and prevent surprises on fitting day.',
        ],
        [
            'title' => 'Made for Milton Keynes homes',
            'copy' => 'Fenster works with older estates, newer developments, extensions and larger glazed openings across MK, so the product choice is matched to the property instead of treated as a one-size job.',
        ],
    ];
    $process_steps = [
        ['step' => '01', 'title' => 'Price the likely products', 'copy' => 'Use the instant pricing tool or send photos, rough sizes and the product type you want. Fenster can help compare uPVC, aluminium, composite, sash, bifold, sliding and roof lantern options.'],
        ['step' => '02', 'title' => 'Check what changes the price', 'copy' => 'Colour, glass, opening style, trickle vents, cill choice, hardware, threshold, access and the number of products all affect the final price.'],
        ['step' => '03', 'title' => 'Survey before manufacture', 'copy' => 'A survey confirms exact sizes, fitting method, safety requirements, ventilation and the finish around the opening before the order is placed.'],
        ['step' => '04', 'title' => 'Install and support', 'copy' => 'The products are fitted by the Fenster team and supported with the relevant certification, guarantee information and aftercare guidance.'],
    ];
    $faqs = [
        [
            'question' => 'Can I get double glazing prices online in Milton Keynes?',
            'answer' => 'Yes. Fenster has an online pricing tool for many windows and doors. It gives a realistic guide price, then a survey confirms the final specification before manufacture.',
        ],
        [
            'question' => 'What changes the price of double glazing?',
            'answer' => 'Size, frame material, colour, glass specification, opening style, trickle vents, cills, handles, thresholds, access and installation complexity can all change the price.',
        ],
        [
            'question' => 'Does Fenster install across Milton Keynes?',
            'answer' => 'Yes. Fenster works across Milton Keynes and nearby towns from its local showroom, covering windows, entrance doors, bifolds, sliders, roof lanterns and replacement glass.',
        ],
        [
            'question' => 'Is the online price the final order price?',
            'answer' => 'It is a guide based on the configuration entered. The final price is confirmed after survey, when the exact sizes, ventilation, glass, cills, trims and fitting details are checked.',
        ],
        [
            'question' => 'Can Fenster quote several products together?',
            'answer' => 'Yes. Windows, doors, bifolds, sliders, roof lanterns and replacement glass can be reviewed together so the specification, colour and installation plan make sense across the property.',
        ],
    ];
}

$mk_detail_cards = [
    [
        'title' => 'What Fenster can install',
        'copy' => 'uPVC windows, aluminium windows, flush casements, sliding sash windows, composite doors, uPVC doors, French doors, patio sliders, aluminium bifolds, roof lanterns, integral blinds and replacement glass.',
    ],
    [
        'title' => 'What affects the price',
        'copy' => 'The biggest drivers are product type, size, frame material, colour, glass, number of openers, trickle vents, cills, handles, thresholds, access and finishing work around the opening.',
    ],
    [
        'title' => 'Why a survey still matters',
        'copy' => 'Online pricing is useful for budgeting, but the survey confirms the measured size, building details, ventilation requirement, safety glass, drainage, trims and installation method.',
    ],
    [
        'title' => 'Local showroom support',
        'copy' => 'You can speak to the Milton Keynes team, compare products and use the online tool before deciding whether to book a survey.',
    ],
];
$mk_area_links = [
    ['text' => 'Bletchley', 'url' => home_url('/double-glazing-bletchley/')],
    ['text' => 'Wolverton', 'url' => home_url('/double-glazing-wolverton/')],
    ['text' => 'Stony Stratford', 'url' => home_url('/double-glazing-stony-stratford/')],
    ['text' => 'Newport Pagnell', 'url' => home_url('/double-glazing-newport-pagnell/')],
    ['text' => 'Woburn Sands', 'url' => home_url('/double-glazing-woburn-sands/')],
    ['text' => 'Great Linford', 'url' => home_url('/double-glazing-great-linford/')],
    ['text' => 'Shenley Church End', 'url' => home_url('/double-glazing-shenley-church-end/')],
    ['text' => 'Furzton', 'url' => home_url('/double-glazing-furzton/')],
    ['text' => 'Oldbrook', 'url' => home_url('/double-glazing-oldbrook/')],
    ['text' => 'Monkston', 'url' => home_url('/double-glazing-monkston/')],
    ['text' => 'Brooklands', 'url' => home_url('/double-glazing-brooklands/')],
    ['text' => 'Whitehouse', 'url' => home_url('/double-glazing-whitehouse/')],
];
$mk_quote_url = 'https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing';
$mk_quote_preview = FENSTER_THEME_URI . '/assets/quote/instant-quote-screenshot.png';
$mk_hero_image = $hero_media_src !== '' ? $hero_media_src : FENSTER_THEME_URI . '/assets/images/products/curated/home-theatre-windows.jpg';
$mk_key_products = [
    ['title' => 'uPVC windows', 'copy' => 'Casement, flush, sash, bay and tilt-turn styles for warmer, quieter rooms. Best when you want a practical whole-home window upgrade with clear choices on glass, vents, cills, handles and colour.', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/liniar-casement-exterior.jpg', 'url' => home_url('/windows-milton-keynes/'), 'meta' => 'Most common home upgrade', 'position' => 'center 58%'],
    ['title' => 'Composite doors', 'copy' => 'Secure front and back doors with colour, glass, furniture and threshold options chosen around the entrance. A strong fit when kerb appeal, security and a warmer hallway matter together.', 'image' => FENSTER_THEME_URI . '/assets/images/imported/front-door.jpeg', 'url' => home_url('/composite-doors/'), 'meta' => 'Popular entrance upgrade', 'position' => 'center 50%'],
    ['title' => 'Aluminium bifold doors', 'copy' => 'Slim folding doors for kitchens, extensions and garden rooms. The survey checks panel count, threshold, drainage and access so the opening works properly once the doors are fitted.', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-bifold-exterior.jpg', 'url' => home_url('/aluminium-bifold-doors/'), 'meta' => 'Open up the rear of the home', 'position' => 'center 56%'],
    ['title' => 'Sliding and patio doors', 'copy' => 'Large glass, smooth access and practical garden openings where a full bifold is not the best fit. Useful for bright rooms, straightforward access and wider views with fewer vertical lines.', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-sliding-door.jpg', 'url' => home_url('/patio-doors/'), 'meta' => 'Bright garden access', 'position' => 'center 55%'],
    ['title' => 'Roof lanterns', 'copy' => 'Aluminium roof lanterns for flat roof extensions, kitchens and open-plan spaces. Designed around daylight, frame colour, glass, upstand details and the way the new room is actually used.', 'image' => FENSTER_THEME_URI . '/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg', 'url' => home_url('/roof-lanterns/'), 'meta' => 'Daylight from above', 'position' => 'center 50%'],
    ['title' => 'Replacement glass', 'copy' => 'Misted units, broken glass, obscure glass, integral blinds and pet flap glass where the frame can stay. Often the fastest route when the existing frame is sound but the sealed unit is not.', 'image' => FENSTER_THEME_URI . '/assets/images/imported/replacement-glazing-milton-keynes-scaled.jpg', 'url' => home_url('/double-glazing-replacement/'), 'meta' => 'Fix the glass', 'position' => 'center 50%'],
];
$mk_cascade_sections = [
    ['eyebrow' => 'Windows', 'title' => 'Replacement windows for Milton Keynes homes', 'copy' => 'Most window projects start with comfort: less draught, less noise, cleaner sightlines and rooms that feel easier to heat. Fenster can compare casement, flush, sash, bay and aluminium options without treating every home as the same white-window job.', 'bullets' => ['Casement and flush options for everyday replacements', 'Sash, bay and aluminium routes for homes that need more design control', 'Glass, vents, cills, handles and colour checked before order'], 'image' => FENSTER_THEME_URI . '/assets/images/imported/Replace-old-windows.jpeg', 'url' => home_url('/windows-milton-keynes/'), 'action' => 'Compare window options'],
    ['eyebrow' => 'Entrance doors', 'title' => 'Composite and uPVC doors that make the entrance feel finished', 'copy' => 'A front door is part security, part insulation and part first impression. Fenster can help choose slab style, colour, glazing, furniture, threshold and cill so the door suits the house from the street and works properly from the hallway.', 'bullets' => ['Composite front doors for colour, security and kerb appeal', 'uPVC and French door routes where practicality matters most', 'Low threshold, handle, glass and letterplate details checked at survey'], 'image' => FENSTER_THEME_URI . '/assets/images/imported/front-door.jpeg', 'url' => home_url('/doors-milton-keynes/'), 'action' => 'Compare door options'],
    ['eyebrow' => 'Garden openings', 'title' => 'Bifolds, sliders and patio doors for bigger glass', 'copy' => 'Rear openings are where the specification really matters. A bifold, slider or patio door needs the right panel layout, traffic door, handle position, threshold, drainage and colour so the finished opening feels effortless rather than awkward.', 'bullets' => ['Bifolds for flexible openings and extension projects', 'Sliding doors where large panes and wide views matter', 'Threshold, drainage and access confirmed before manufacture'], 'image' => FENSTER_THEME_URI . '/assets/images/imported/Bifold-550-GardenView-v1.webp', 'url' => home_url('/aluminium-bifold-doors/'), 'action' => 'View garden doors'],
    ['eyebrow' => 'Roof glazing', 'title' => 'Roof lanterns for flat roof extensions and brighter kitchens', 'copy' => 'A roof lantern can change how a room feels without filling the walls with extra frames. Fenster helps check size, shape, frame colour, glass and upstand details so the lantern works with the extension rather than looking like an afterthought.', 'bullets' => ['Aluminium lanterns for kitchens, dining rooms and open-plan extensions', 'Glass and frame colour choices matched to the room', 'Survey checks the opening before the lantern is ordered'], 'image' => FENSTER_THEME_URI . '/assets/images/imported/S1-Lantern-Lounge-with-LEDs-min-scaled.jpg', 'url' => home_url('/roof-lanterns/'), 'action' => 'View roof lanterns'],
    ['eyebrow' => 'Glass only', 'title' => 'Replacement glazing when the frame can stay', 'copy' => 'Not every problem needs a full frame replacement. If the frame is sound, Fenster can look at misted glass, cracked units, obscure glass, cat flap glass, integral blinds and other sealed unit options that solve the problem more directly.', 'bullets' => ['Misted, cracked and failed sealed units', 'Obscure glass, pet flap glass and integral blind options', 'A practical route when the existing frame is still worth keeping'], 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'url' => home_url('/double-glazing-replacement/'), 'action' => 'View replacement glass'],
    ['eyebrow' => 'Showroom support', 'title' => 'Use the page, then use the team', 'copy' => 'The page should help you narrow the project before you speak to anyone. The team can then use photos, rough sizes, the instant price tool or a showroom conversation to move from browsing to a realistic route forward.', 'bullets' => ['Start with the instant price tool if you know the product and size', 'Send photos if you need help choosing first', 'Visit or contact the showroom when finishes and details matter'], 'image' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png', 'url' => home_url('/contact/'), 'action' => 'Talk to Fenster'],
];
$mk_order_steps = [
    ['step' => '01', 'title' => 'Online price or enquiry', 'copy' => 'Use the instant quote tool for a guide price, or send photos and rough sizes if you want Fenster to help choose the product first.'],
    ['step' => '02', 'title' => 'Product specification', 'copy' => 'Fenster checks the likely frame, glass, colour, handles, vents, cills, thresholds and fitting details before the order is confirmed.'],
    ['step' => '03', 'title' => 'Survey before manufacture', 'copy' => 'A survey confirms exact sizes, access, safety glass, ventilation requirements and the finish around each opening.'],
    ['step' => '04', 'title' => 'Installation and aftercare', 'copy' => 'The products are fitted by Fenster installers, with guarantee information and aftercare support after completion.'],
];
$mk_option_groups = [
    ['title' => 'Product decisions', 'items' => ['Window style', 'Door type', 'Bifold or slider', 'Roof lantern size', 'Glass-only replacement']],
    ['title' => 'Glass and compliance', 'items' => ['Energy rating', 'Safety glass', 'Obscure glass', 'Acoustic upgrade', 'Ventilation needs']],
    ['title' => 'Finish and daily use', 'items' => ['Cills', 'Handles', 'Thresholds', 'Opening direction', 'Colour and foil finish']],
    ['title' => 'Survey checks', 'items' => ['Exact sizes', 'Access', 'Drainage', 'Frame position', 'Making good']],
];
$mk_price_checked = '9 July 2026';
$mk_price_examples = [
    [
        'spec' => '1200 x 1200 uPVC casement window',
        'price' => '600 estimate',
        'details' => 'Rounded from a checked WindowCAD example for a Liniar EnergyPlus casement with white finish, cill, toughened clear glass, trickle vent and white handle.',
        'image' => FENSTER_THEME_URI . '/assets/images/price-guides/windowcad-casement-1200x1200.png',
    ],
    [
        'spec' => '900 x 2100 composite entrance door',
        'price' => '2,000 estimate',
        'details' => 'Rounded from a checked WindowCAD example for a Distinction composite entrance door with anthracite grey outside, white inside, low threshold, cill, clear glass and chrome handle.',
        'image' => FENSTER_THEME_URI . '/assets/images/price-guides/windowcad-composite-door-900x2100.png',
    ],
    [
        'spec' => '3000 x 2100 aluminium bifold door',
        'price' => '3,500 estimate',
        'details' => 'Rounded from a checked WindowCAD example for a Prestige three-pane aluminium bifold with anthracite grey finish, cill, clear glass, black handles and trickle vent.',
        'image' => FENSTER_THEME_URI . '/assets/images/price-guides/windowcad-bifold-product-3000x2100.png',
    ],
];
$mk_trust_reasons = [
    ['title' => 'A real MK showroom', 'copy' => 'Visit the Fenster team, compare products, look at colours and handles, and talk through the survey details before committing to the work.', 'image' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png'],
    ['title' => 'Reviews and recognised cover', 'copy' => 'Customer review proof sits alongside FENSA and Consumer Protection Association backing, so the page is not asking people to trust a blank quote form.', 'image' => FENSTER_THEME_URI . '/assets/images/imported/Fenster-Glazing-Vs-Anglian-home-improvements-Banner-1.png'],
    ['title' => 'Survey before manufacture', 'copy' => 'Every made-to-measure order is checked before manufacture, including safety glass, trickle vents, thresholds, cills, access and finishing trims.', 'image' => FENSTER_THEME_URI . '/assets/images/price-guides/windowcad-casement-1200x1200.png'],
    ['title' => 'Product choice in one place', 'copy' => 'Windows, doors, bifolds, sliders, roof lanterns and replacement glass can be compared together so the final specification feels consistent across the property.', 'image' => FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-bifold-exterior.jpg'],
];
$mk_spec_links = [
    ['title' => 'I know what I need', 'copy' => 'Use the instant quote tool for a guide price, then let Fenster confirm the order details at survey.', 'url' => '#fenster-mk-instant-pricing', 'image' => FENSTER_THEME_URI . '/assets/images/price-guides/windowcad-casement-1200x1200.png'],
    ['title' => 'I need product advice', 'copy' => 'Compare windows, doors, bifolds, roof lanterns and replacement glass before choosing the route.', 'url' => '#fenster-mk-products', 'image' => FENSTER_THEME_URI . '/assets/images/imported/types-of-windows.jpeg'],
    ['title' => 'I want to check trust first', 'copy' => 'Read reviews, accreditations, showroom details and aftercare expectations before enquiring.', 'url' => home_url('/why-trust-fenster/'), 'image' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png'],
    ['title' => 'I want to talk to someone', 'copy' => 'Send photos, rough sizes or a quick description and Fenster can help you choose the next step.', 'url' => '#fenster-mk-enquiry', 'image' => FENSTER_THEME_URI . '/assets/images/imported/front-door.jpeg'],
];
$mk_direction_link = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode('Fenster Glazing Milton Keynes');
$mk_showroom_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';
$product_links = [
    ['text' => 'Windows', 'url' => home_url('/windows-milton-keynes/')],
    ['text' => 'Doors', 'url' => home_url('/doors-milton-keynes/')],
    ['text' => 'Composite Doors', 'url' => home_url('/composite-doors/')],
    ['text' => 'Aluminium Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/')],
    ['text' => 'Integral Blinds', 'url' => home_url('/integral-blinds/')],
    ['text' => 'Replacement Glazing', 'url' => home_url('/double-glazing-replacement/')],
];
?>

<?php if ($is_mk_double_glazing_page) : ?>
<article class="fg-mk-page generated-page generated-page--location">
    <section class="fg-mk-hero">
        <img <?php echo fenster_image_attr_string($mk_hero_image, ['class' => 'fg-mk-hero__image', 'alt' => 'Double glazing installed by Fenster Glazing in Milton Keynes', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>>
        <div class="fg-mk-hero__shade"></div>
        <div class="container fg-mk-hero__grid">
            <div class="fg-mk-hero__copy">
                <p class="eyebrow"><?php esc_html_e('Double Glazing Milton Keynes', 'fenster'); ?></p>
                <h1><?php esc_html_e('Double glazing in Milton Keynes', 'fenster'); ?></h1>
                <p><?php echo esc_html($hero_copy); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--light" href="#fenster-mk-enquiry"><?php esc_html_e('Ask Fenster to quote', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-location-proof-wall" aria-label="<?php esc_attr_e('Reviews and accreditations', 'fenster'); ?>">
        <div class="container">
            <div class="fg-location-proof-wall__bar">
                <?php foreach ($hero_trust_messages as $trust) : ?>
                    <?php if (is_array($trust['item'])) : ?>
                        <article class="fg-location-proof-wall__item">
                            <?php if (! empty($trust['item']['url'])) : ?>
                                <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust['item']['url']); ?>"<?php echo fenster_trust_link_attrs($trust['item']); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $trust['item']['alt'])); ?>">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($trust['item']['src']); ?>" alt="<?php echo esc_attr($trust['item']['alt']); ?>" loading="lazy">
                            <?php if (! empty($trust['item']['url'])) : ?></a><?php endif; ?>
                            <div>
                                <strong><?php echo esc_html($trust['title']); ?></strong>
                                <span><?php echo esc_html($trust['copy']); ?></span>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="container fg-home-proof-wall__link fg-mk-proof-wall__link">
        <a href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('Why you can trust Fenster Glazing', 'fenster'); ?></a>
    </div>

    <section class="fg-mk-products" id="fenster-mk-products">
        <div class="container">
            <div class="fg-location-section-head">
                <p class="eyebrow"><?php esc_html_e('Key products', 'fenster'); ?></p>
                <h2><?php esc_html_e('Choose the product family first. Price and survey make more sense after that.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Most enquiries are not just double glazing in the abstract. They are a mix of windows, doors, glass, roof glazing, access, style and budget. Start with the closest route below, then use the instant price section or enquiry form when you are ready to move.', 'fenster'); ?></p>
            </div>
            <div class="fg-mk-products__grid">
                <?php foreach ($mk_key_products as $index => $product) : ?>
                    <a href="<?php echo esc_url($product['url']); ?>" data-fg-mk-reveal="<?php echo esc_attr($index % 3 === 0 ? 'left' : ($index % 3 === 1 ? 'up' : 'right')); ?>">
                        <img src="<?php echo esc_url(fenster_generated_url($product['image'])); ?>" alt="" loading="lazy" style="<?php echo esc_attr('object-position: ' . ($product['position'] ?? 'center')); ?>">
                        <span><?php echo esc_html($product['meta']); ?></span>
                        <strong><?php echo esc_html($product['title']); ?></strong>
                        <p><?php echo esc_html($product['copy']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-mk-cascade" aria-label="<?php esc_attr_e('How Fenster specifies double glazing', 'fenster'); ?>">
        <div class="container fg-location-section-head">
            <p class="eyebrow"><?php esc_html_e('Product routes', 'fenster'); ?></p>
            <h2><?php esc_html_e('The important choices, split by the thing you are actually changing.', 'fenster'); ?></h2>
            <p><?php esc_html_e('This is where the page earns its keep. Each product route has different decisions, price drivers and survey checks, so the content is split around how people actually buy glazing rather than forcing everything into one generic paragraph.', 'fenster'); ?></p>
        </div>
        <div class="container fg-mk-cascade__stack">
            <?php foreach ($mk_cascade_sections as $index => $section) : ?>
                <article class="fg-mk-cascade__item <?php echo esc_attr($index % 2 ? 'fg-mk-cascade__item--reverse' : ''); ?>" data-fg-mk-reveal="<?php echo esc_attr($index % 2 ? 'right' : 'left'); ?>">
                    <div class="fg-mk-cascade__copy">
                        <p class="eyebrow"><?php echo esc_html($section['eyebrow']); ?></p>
                        <h2><?php echo esc_html($section['title']); ?></h2>
                        <p><?php echo esc_html($section['copy']); ?></p>
                        <?php if (! empty($section['bullets'])) : ?>
                            <ul class="fg-mk-cascade__bullets">
                                <?php foreach ($section['bullets'] as $bullet) : ?>
                                    <li><?php echo esc_html($bullet); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <a class="text-link" href="<?php echo esc_url($section['url']); ?>"><?php echo esc_html($section['action']); ?></a>
                    </div>
                    <figure class="fg-mk-cascade__media">
                        <img src="<?php echo esc_url(fenster_generated_url($section['image'])); ?>" alt="" loading="lazy" data-fg-depth="0.05">
                    </figure>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="fg-mk-trust-slab">
        <div class="container">
            <div class="fg-location-section-head fg-mk-trust-slab__head" data-fg-mk-reveal="up">
                <p class="eyebrow"><?php esc_html_e('Why you can trust Fenster', 'fenster'); ?></p>
                <h2><?php esc_html_e('Proof, product advice and survey control before anything is made.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Once you have narrowed the product route, the confidence question matters. Fenster backs the page with a local showroom, visible review proof, recognised cover and a survey process that checks the specification before manufacture.', 'fenster'); ?></p>
            </div>
            <div class="fg-mk-trust-slab__reasons" data-fg-mk-reveal="up">
                <?php foreach ($mk_trust_reasons as $reason) : ?>
                    <article>
                        <img src="<?php echo esc_url(fenster_generated_url($reason['image'])); ?>" alt="" loading="lazy">
                        <div>
                            <h3><?php echo esc_html($reason['title']); ?></h3>
                            <p><?php echo esc_html($reason['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="fg-mk-trust-slab__action" data-fg-mk-reveal="up">
                <a class="button button--light" href="<?php echo esc_url(home_url('/why-trust-fenster/')); ?>"><?php esc_html_e('Why trust Fenster Glazing', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-mk-price-guide" id="fenster-mk-price-guide">
        <div class="container">
            <div class="fg-mk-price-guide__head">
                <div>
                    <p class="eyebrow"><?php esc_html_e('Price guidance', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Use these examples as a benchmark, then build your own instant price below.', 'fenster'); ?></h2>
                </div>
                <p><?php echo esc_html('Checked ' . $mk_price_checked . '. These are rounded WindowCAD examples for specific configurations, including VAT. They show the likely scale of common projects. For your own sizes, colours and choices, use the instant price tool below.'); ?></p>
            </div>
            <div class="fg-mk-price-guide__grid">
                <?php foreach ($mk_price_examples as $index => $example) : ?>
                    <article data-fg-mk-reveal="<?php echo esc_attr($index === 0 ? 'left' : ($index === 1 ? 'up' : 'right')); ?>">
                        <img <?php echo fenster_image_attr_string($example['image'], ['alt' => $example['spec'] . ' price example', 'loading' => 'lazy']); ?>>
                        <div>
                            <span><?php echo esc_html('Checked ' . $mk_price_checked); ?></span>
                            <h3><?php echo esc_html($example['spec']); ?></h3>
                            <strong><?php echo '&pound;' . esc_html($example['price']); ?></strong>
                            <p><?php echo esc_html($example['details']); ?></p>
                            <a class="text-link" href="#fenster-mk-instant-pricing"><?php esc_html_e('Get exact pricing for your measurements', 'fenster'); ?></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="fg-mk-price-guide__note">
                <div>
                    <strong><?php esc_html_e('Ready to make the number relevant to your home?', 'fenster'); ?></strong>
                    <p><?php esc_html_e('Use the instant price tool for your own product, size, colour and style. The examples above are rounded; the tool gets much closer to your actual measurements before Fenster confirms survey details.', 'fenster'); ?></p>
                </div>
                <a class="button" href="#fenster-mk-instant-pricing"><?php esc_html_e('Go to instant pricing', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-home-quote-station fg-home-quote-station--bridge fg-mk-quote-station" id="fenster-mk-instant-pricing">
        <div class="container fg-home-quote-station__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Instant pricing', 'fenster'); ?></p>
                <h2><?php esc_html_e('Get an instant quote for your windows and doors.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Choose the product, style, colour and approximate size online. You will see an immediate guide price, then Fenster confirms vents, cills, glass, access and fitting details at survey.', 'fenster'); ?></p>
                <ul class="fg-home-quote-station__points">
                    <li><?php esc_html_e('Choose product, style, colour and size', 'fenster'); ?></li>
                    <li><?php esc_html_e('See a guide price online', 'fenster'); ?></li>
                    <li><?php esc_html_e('Final specification checked by Fenster', 'fenster'); ?></li>
                </ul>
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant quote', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url($mk_quote_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open in new tab', 'fenster'); ?></a>
            </div>
            <div class="fg-home-quote-station__preview" data-quote-frame-wrap data-quote-card data-lenis-prevent data-quote-url="<?php echo esc_url($mk_quote_url); ?>" data-quote-autoload="near">
                <div class="fg-quote-frame-placeholder">
                    <strong><?php esc_html_e('Instant quote tool', 'fenster'); ?></strong>
                    <span><?php esc_html_e('Loads when you reach this section, or tap to open it now.', 'fenster'); ?></span>
                    <button class="button" type="button" data-load-quote><?php esc_html_e('Load quote tool', 'fenster'); ?></button>
                </div>
                <iframe data-quote-iframe-src="<?php echo esc_url($mk_quote_url); ?>" title="<?php esc_attr_e('Fenster instant quote tool', 'fenster'); ?>" loading="lazy" allow="fullscreen" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <section class="fg-mk-spec-links">
        <div class="container">
            <div class="fg-location-section-head">
                <p class="eyebrow"><?php esc_html_e('Choose your next step', 'fenster'); ?></p>
                <h2><?php esc_html_e('Four ways to move forward, depending on how ready you are.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Some people arrive knowing the product and size. Others need to understand the options first. This section keeps the decision moving without pushing every visitor into the same button.', 'fenster'); ?></p>
            </div>
            <div class="fg-mk-spec-links__grid">
                <?php foreach ($mk_spec_links as $index => $link) : ?>
                    <article data-fg-mk-reveal="<?php echo esc_attr($index % 2 ? 'right' : 'left'); ?>">
                        <img src="<?php echo esc_url(fenster_generated_url($link['image'])); ?>" alt="" loading="lazy">
                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html($link['title']); ?></h3>
                        <p><?php echo esc_html($link['copy']); ?></p>
                        <a class="text-link" href="<?php echo esc_url($link['url']); ?>"><?php esc_html_e('Open', 'fenster'); ?></a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-mk-options">
        <div class="container fg-mk-options__layout">
            <div>
                <p class="eyebrow"><?php esc_html_e('What changes the number', 'fenster'); ?></p>
                <h2><?php esc_html_e('Instant pricing gets you close. The survey makes it buildable.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The online price is there to stop the first conversation being a guessing game. The survey is where Fenster checks the details that make the order fit the house: exact sizes, frame position, ventilation, safety glass, cill depth, threshold, drainage, handles, colour, access and finishing. That is the jump from a useful estimate to a product that can be manufactured and installed properly.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="#fenster-mk-instant-pricing"><?php esc_html_e('Use instant pricing', 'fenster'); ?></a>
                    <a class="button button--light" href="#fenster-mk-enquiry"><?php esc_html_e('Ask Fenster to check it', 'fenster'); ?></a>
                </div>
            </div>
            <div class="fg-mk-options__grid">
                <?php foreach ($mk_option_groups as $group) : ?>
                    <article data-fg-mk-reveal="up">
                        <h3><?php echo esc_html($group['title']); ?></h3>
                        <ul>
                            <?php foreach ($group['items'] as $item) : ?>
                                <li><?php echo esc_html($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-mk-deep-guide">
        <div class="container fg-mk-deep-guide__grid">
            <div class="fg-mk-deep-guide__copy" data-fg-mk-reveal="left">
                <p class="eyebrow"><?php esc_html_e('Milton Keynes buying guide', 'fenster'); ?></p>
                <h2><?php esc_html_e('A practical way to choose glazing without turning it into homework.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Milton Keynes homes vary a lot. Some enquiries are simple window replacements: tired casements, cold bedrooms, misted panes, old handles and rooms that need to feel warmer. Others are entrance projects where the front door has to look right from the road, feel secure, close cleanly and suit the hallway. Extension projects are different again, because bifolds, sliders and roof lanterns are about daylight, access, threshold levels and how the room will be used every day.', 'fenster'); ?></p>
                <p><?php esc_html_e('That is why this page is split by product instead of pretending every job is one generic double glazing question. If you are replacing windows, focus on frame style, glass, vents, cills and how the frames sit in the existing openings. If you are replacing a door, think about security, threshold, colour, glazing, furniture and the direction the door needs to work. If you are opening up the rear of the house, the right answer may be a bifold, slider or patio door depending on the width, garden access and furniture layout inside.', 'fenster'); ?></p>
                <h3><?php esc_html_e('If windows are the priority', 'fenster'); ?></h3>
                <p><?php esc_html_e('Start with the rooms that annoy you most. Bedrooms may need quieter glass, trickle ventilation and openers that are easy to use. Living rooms may need cleaner sightlines, a better bay layout or a warmer frame. Kitchens and bathrooms may need practical openings, obscure glass or safer glass positions. Looking at each room this way makes the quote more useful than simply counting windows across the house.', 'fenster'); ?></p>
                <h3><?php esc_html_e('If the entrance is the priority', 'fenster'); ?></h3>
                <p><?php esc_html_e('A door decision is rarely just about the slab. The colour has to suit the brickwork, the glass has to balance privacy with daylight, the threshold has to work for daily access, and the furniture has to feel right in the hand. Composite doors are usually chosen for the front of the home, while uPVC, French or back-door options can still be the sensible route for practical entrances.', 'fenster'); ?></p>
                <h3><?php esc_html_e('If the back of the house is changing', 'fenster'); ?></h3>
                <p><?php esc_html_e('Bifolds, sliders and patio doors change the way a room connects to the garden, so the layout matters before the price does. A bifold can create a wide opening, a slider can give bigger glass with fewer vertical lines, and a patio door can be the cleaner answer for straightforward access. The survey checks threshold, drainage, access and frame position so the finished opening works in real life.', 'fenster'); ?></p>
                <h3><?php esc_html_e('If only the glass has failed', 'fenster'); ?></h3>
                <p><?php esc_html_e('Misted or cracked units do not always mean the whole frame needs replacing. If the frame is still sound, replacement glazing can restore the view, improve privacy, add obscure glass, include a pet flap or solve a failed sealed unit without turning the job into a full window replacement. That can keep the project smaller, quicker and more proportionate.', 'fenster'); ?></p>
                <p><?php esc_html_e('For windows, uPVC is usually the most practical route for everyday replacements, while aluminium or flush styles help when slimmer lines or a sharper finish matter. For entrance doors, composite gives more choice on colour, glass and security, while uPVC can still be a sensible back door or utility option. For roof glazing, the lantern has to be considered with the flat roof opening, upstand, glass and frame colour. For failed glass, the best answer may be a new sealed unit rather than a full new frame.', 'fenster'); ?></p>
                <p><?php esc_html_e('Prices change because the details change. Size is only one part of it. Glass type, safety requirements, trickle vents, cill depth, colour, foil finish, threshold type, handles, drainage, access and making-good all affect the final order. The instant price tool is useful because it gives you a realistic starting point. The survey is useful because it checks the details that an online tool cannot see from your house.', 'fenster'); ?></p>
                <p><?php esc_html_e('A good route is simple: use the product cards to decide what you are changing, look at the rounded guide prices to understand the scale, then use instant pricing if you know the rough size. If you are not sure, send photos or speak to the showroom team first. Fenster can then turn that early direction into a checked specification before anything is manufactured.', 'fenster'); ?></p>
                <p><?php esc_html_e('The aim is not to overwhelm you with every possible glazing term. It is to make the next step obvious: pick the product route, get a realistic number, then let the survey confirm the exact sizes, glass, ventilation, thresholds, cills and fitting details for your property.', 'fenster'); ?></p>
            </div>
            <div class="fg-mk-deep-guide__media" data-fg-mk-reveal="right">
                <figure>
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/imported/front-door.jpeg'); ?>" alt="<?php esc_attr_e('Composite front door on a Milton Keynes-style home', 'fenster'); ?>" loading="lazy" data-fg-depth="0.04">
                </figure>
                <figure>
                    <img src="<?php echo esc_url(FENSTER_THEME_URI . '/assets/images/imported/replacement-glazing-milton-keynes-scaled.jpg'); ?>" alt="<?php esc_attr_e('Replacement glazing work in Milton Keynes', 'fenster'); ?>" loading="lazy" data-fg-depth="0.06">
                </figure>
            </div>
        </div>
    </section>

    <section class="fg-order-process fg-mk-order-process">
        <div class="container">
            <div class="section-heading section-heading--wide">
                <p class="eyebrow"><?php esc_html_e('Order process', 'fenster'); ?></p>
                <h2><?php esc_html_e('From guide price to fitted double glazing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Start with a guide price or enquiry, then Fenster confirms the specification, surveys the openings and fits the made-to-measure products.', 'fenster'); ?></p>
            </div>
            <div class="fg-order-process__rail">
                <?php foreach ($mk_order_steps as $step) : ?>
                    <article>
                        <span class="fg-order-process__number"><?php echo esc_html($step['step']); ?></span>
                        <div class="fg-order-process__card">
                            <span class="fg-order-process__icon" aria-hidden="true"></span>
                            <h3><?php echo esc_html($step['title']); ?></h3>
                            <p><?php echo esc_html($step['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="fg-order-process__action">
                <a class="button" href="#fenster-mk-enquiry"><?php esc_html_e('Start your enquiry', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-mk-areas">
        <div class="container fg-mk-areas__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Areas around MK', 'fenster'); ?></p>
                <h2><?php esc_html_e('Fenster quotes across Milton Keynes estates, villages and new developments.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The postcode matters less than the property. Fenster checks the product, glass, ventilation and installation detail around the home you actually have.', 'fenster'); ?></p>
            </div>
            <div class="generated-links">
                <?php foreach ($mk_area_links as $link) : ?>
                    <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-mk-showroom">
        <div class="container fg-mk-showroom__grid">
            <figure class="fg-mk-showroom__media" data-fg-mk-reveal="left">
                <img <?php echo fenster_image_attr_string($mk_showroom_image, ['alt' => 'Fenster Glazing showroom in Milton Keynes', 'loading' => 'lazy', 'data-fg-depth' => '0.04']); ?>>
            </figure>
            <div class="fg-mk-showroom__copy" data-fg-mk-reveal="right">
                <p class="eyebrow"><?php esc_html_e('Showroom and directions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Use the page online, then visit or speak to the team before choosing.', 'fenster'); ?></h2>
                <p><?php esc_html_e('The best version of this page should connect online search intent to real-world confidence. A homeowner can compare prices, understand the product families, check reviews and accreditations, send an enquiry, open directions to the showroom, or start an instant quote without needing to jump around the site.', 'fenster'); ?></p>
                <p><?php esc_html_e('That also makes the page useful for different levels of intent. Someone early in the decision can learn what affects the price. Someone ready to act can build a quote or send photos. Someone nervous about who to trust can see review proof and showroom details in the same journey.', 'fenster'); ?></p>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url($mk_direction_link); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open directions', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Fenster', 'fenster'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-mk-enquiry" id="fenster-mk-enquiry">
        <div class="container fg-mk-enquiry__grid">
            <div class="fg-mk-enquiry__copy" data-fg-mk-reveal="left">
                <p class="eyebrow"><?php esc_html_e('Need help choosing?', 'fenster'); ?></p>
                <h2><?php esc_html_e('Send photos or rough sizes and Fenster will point you in the right direction.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Tell us what you want to replace, where it is, and whether you want an online price, a showroom chat or a survey. The team can then recommend the right window, door or glass option before anything is ordered.', 'fenster'); ?></p>
                <ul class="fg-mk-enquiry__points">
                    <li><?php esc_html_e('Photos of the outside and inside help the team understand the opening.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Rough sizes are enough for an early conversation; exact sizes are checked at survey.', 'fenster'); ?></li>
                    <li><?php esc_html_e('Mention if you want windows, doors, glass replacement, a roof lantern, or several products together.', 'fenster'); ?></li>
                </ul>
            </div>
            <div class="fg-mk-enquiry__form" data-fg-mk-reveal="right">
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form fg-form--mk-page',
                    'source' => 'Double Glazing Milton Keynes',
                    'button_label' => 'Send enquiry',
                    'project_type' => 'Double glazing in Milton Keynes',
                    'compact' => true,
                    'project_options' => [
                        'Double glazing in Milton Keynes',
                        'Windows',
                        'Doors',
                        'Bifold or sliding doors',
                        'Roof lanterns',
                        'Replacement glass',
                    ],
                ]);
                ?>
            </div>
        </div>
    </section>

    <section class="fg-location-faq fg-mk-faq">
        <div class="container fg-location-faq__grid">
            <div>
                <p class="eyebrow"><?php esc_html_e('Milton Keynes FAQs', 'fenster'); ?></p>
                <h2><?php esc_html_e('Questions about double glazing prices, survey and installation.', 'fenster'); ?></h2>
            </div>
            <div class="fg-location-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--location fg-review-showcase--mk-page',
        'eyebrow' => 'Customer proof',
        'title' => 'Reviewed, accredited and backed by proven product systems.',
        'copy' => 'Fenster combines local installation experience with recognised accreditations, real product systems and a Milton Keynes showroom team.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-links-band">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow"><?php esc_html_e('Keep exploring', 'fenster'); ?></p>
                <h2><?php esc_html_e('Products, services and nearby areas', 'fenster'); ?></h2>
            </div>
            <div class="generated-links">
                <?php
                $mk_footer_links = array_values(array_filter(array_merge($product_links, $related_links), static function ($link): bool {
                    $url = (string) ($link['url'] ?? '');
                    return ! preg_match('/(?:price|prices|cost)/i', $url);
                }));
                ?>
                <?php foreach (array_slice($mk_footer_links, 0, 24) as $link) : ?>
                    <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</article>
<?php return; ?>
<?php endif; ?>

<article class="fg-location-page generated-page generated-page--location">
    <section class="fg-location-hero">
        <?php if ($hero_media_src !== '') : ?>
            <img <?php echo fenster_image_attr_string($hero_media_src, ['class' => 'fg-location-hero__image', 'alt' => $service_label . ' in ' . $location_name, 'loading' => 'eager', 'fetchpriority' => 'high', 'data-fg-depth' => '0.05']); ?>>
        <?php endif; ?>
        <div class="fg-location-hero__shade"></div>
        <div class="container fg-location-hero__grid">
            <div class="fg-location-hero__copy">
                <p class="eyebrow"><?php echo esc_html($service_label . ' ' . $location_name); ?></p>
                <h1><?php echo esc_html($service_label . ' in ' . $location_name . ', designed around your home.'); ?></h1>
                <p><?php echo esc_html($hero_copy); ?></p>
            </div>
            <aside class="fg-location-hero__card fg-location-hero__form" aria-label="<?php echo esc_attr('Start a ' . $service_label . ' enquiry'); ?>">
                <span><?php esc_html_e('Start your enquiry', 'fenster'); ?></span>
                <h2><?php echo esc_html('Ask about ' . $service_name . ' in ' . $location_name . '.'); ?></h2>
                <?php
                get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-form fg-form--hero',
                    'source' => $service_label . ' - ' . $location_name,
                    'button_label' => 'Send enquiry',
                    'project_type' => $service_label . ' in ' . $location_name,
                    'compact' => true,
                    'project_options' => [
                        $service_label . ' in ' . $location_name,
                        'Windows',
                        'Doors',
                        'Bifold or sliding doors',
                        'Repairs or replacement glass',
                    ],
                ]);
                ?>
            </aside>
        </div>
    </section>

    <section class="fg-location-proof-wall" aria-label="<?php esc_attr_e('Reviews and accreditations', 'fenster'); ?>">
        <div class="container">
            <div class="fg-location-proof-wall__bar">
                <?php foreach ($hero_trust_messages as $trust) : ?>
                    <?php if (is_array($trust['item'])) : ?>
                        <article class="fg-location-proof-wall__item">
                            <?php if (! empty($trust['item']['url'])) : ?>
                                <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust['item']['url']); ?>"<?php echo fenster_trust_link_attrs($trust['item']); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $trust['item']['alt'])); ?>">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($trust['item']['src']); ?>" alt="<?php echo esc_attr($trust['item']['alt']); ?>" loading="lazy">
                            <?php if (! empty($trust['item']['url'])) : ?></a><?php endif; ?>
                            <div>
                                <strong><?php echo esc_html($trust['title']); ?></strong>
                                <span><?php echo esc_html($trust['copy']); ?></span>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-location-intro">
        <div class="container">
            <div class="fg-location-intro__head">
                <p class="eyebrow"><?php echo esc_html($service_label . ' for ' . $location_name); ?></p>
                <h2><?php echo esc_html($service_label . ' planned around your home.'); ?></h2>
                <p><?php echo esc_html($intro_copy); ?></p>
            </div>
            <div class="fg-location-intro__cards">
                <?php foreach ($service['benefits'] as $card) : ?>
                    <article>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-location-local-guide">
        <div class="container fg-location-local-guide__grid">
            <?php if (is_array($side_image) && ! empty($side_image['src'])) : ?>
                <figure class="fg-location-local-guide__media">
                    <img <?php echo fenster_image_attr_string(fenster_generated_url($side_image['src']), ['alt' => $side_image['alt'] ?? ($service_label . ' in ' . $location_name), 'loading' => 'lazy', 'data-fg-depth' => '0.04']); ?>>
                </figure>
            <?php endif; ?>
            <div class="fg-location-local-guide__copy">
                <p class="eyebrow"><?php echo esc_html($location_name . ' buying route'); ?></p>
                <h2><?php echo esc_html('How to choose ' . $service_name . ' in ' . $location_name . '.'); ?></h2>
                <p><?php echo esc_html('The useful page is not the one that says every product is perfect. It is the one that helps you choose the right route for ' . $town_profile['property'] . ', then gives you a simple next step.'); ?></p>
                <div class="fg-location-local-guide__cards">
                    <?php foreach ($local_decision_cards as $card) : ?>
                        <article>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="button-row">
                    <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                    <a class="button button--light" href="<?php echo esc_url(home_url('/double-glazing-milton-keynes/')); ?>"><?php esc_html_e('View the Milton Keynes guide', 'fenster'); ?></a>
                </div>
                <div class="fg-location-local-guide__links">
                    <a href="<?php echo esc_url($service_route_url); ?>"><?php echo esc_html('Compare ' . $service_name); ?></a>
                    <?php if ($slug !== 'double-glazing-' . $location_slug) : ?>
                        <a href="<?php echo esc_url($town_double_glazing_url); ?>"><?php echo esc_html('View double glazing in ' . $location_name); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if ($is_mk_double_glazing_page) : ?>
        <section class="fg-location-products fg-location-products--mk-depth">
            <div class="container">
                <div class="fg-location-section-head">
                    <p class="eyebrow"><?php esc_html_e('Milton Keynes double glazing guide', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Clear product choices, clear price drivers, then a proper survey.', 'fenster'); ?></h2>
                </div>
                <div class="fg-location-products__grid">
                    <?php foreach ($mk_detail_cards as $index => $card) : ?>
                        <article>
                            <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="fg-location-intro fg-location-intro--mk-areas">
            <div class="container">
                <div class="fg-location-intro__head">
                    <p class="eyebrow"><?php esc_html_e('Areas around MK', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Double glazing across Milton Keynes estates, villages and new developments.', 'fenster'); ?></h2>
                    <p><?php esc_html_e('Fenster quotes and installs across the wider Milton Keynes area. The important part is not just the postcode: it is matching the product, ventilation, glass, colour and installation detail to the property.', 'fenster'); ?></p>
                </div>
                <div class="generated-links">
                    <?php foreach ($mk_area_links as $link) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fg-location-products">
        <div class="container">
            <div class="fg-location-section-head">
                <p class="eyebrow"><?php esc_html_e('What gets planned', 'fenster'); ?></p>
                <h2><?php echo esc_html('The details that make ' . $service_name . ' work properly.'); ?></h2>
            </div>
            <div class="fg-location-products__grid">
                <?php foreach ($service['cards'] as $index => $card) : ?>
                    <article>
                        <span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-location-proof">
        <div class="container fg-location-proof__grid">
            <?php if (is_array($side_image) && ! empty($side_image['src'])) : ?>
                <figure class="fg-location-proof__media">
                    <img src="<?php echo esc_url(fenster_generated_url($side_image['src'])); ?>" alt="<?php echo esc_attr($side_image['alt'] ?? $title); ?>" loading="lazy">
                </figure>
            <?php endif; ?>
            <div class="fg-location-proof__copy">
                <p class="eyebrow"><?php esc_html_e('Survey and installation', 'fenster'); ?></p>
                <h2><?php echo esc_html('Measured, specified and fitted with care.'); ?></h2>
                <div class="fg-location-proof__items">
                    <?php foreach ($local_points as $point) : ?>
                        <article>
                            <h3><?php echo esc_html($point['title']); ?></h3>
                            <p><?php echo esc_html($point['copy']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-location-process">
        <div class="container">
            <div class="fg-location-section-head">
                <p class="eyebrow"><?php esc_html_e('How it works', 'fenster'); ?></p>
                <h2><?php echo esc_html('From ' . $location_name . ' enquiry to installed ' . $service_name . '.'); ?></h2>
            </div>
            <div class="fg-location-process__rail">
                <?php foreach ($process_steps as $step) : ?>
                    <article>
                        <span><?php echo esc_html($step['step']); ?></span>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['copy']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-location-gallery">
        <div class="container fg-location-gallery__grid">
            <?php foreach (array_filter([$second_image, $third_image, $side_image]) as $image) : ?>
                <?php if (is_array($image) && ! empty($image['src'])) : ?>
                    <figure>
                        <img src="<?php echo esc_url(fenster_generated_url($image['src'])); ?>" alt="<?php echo esc_attr($image['alt'] ?? $title); ?>" loading="lazy" data-fg-depth="0.05">
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="fg-location-faq">
        <div class="container fg-location-faq__grid">
            <div>
                <p class="eyebrow"><?php echo esc_html($location_name . ' FAQs'); ?></p>
                <h2><?php echo esc_html('Questions about ' . $service_name . ' in ' . $location_name . '.'); ?></h2>
            </div>
            <div class="fg-location-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part('template-parts/components/review-showcase', null, [
        'class' => 'fg-review-showcase--location',
        'eyebrow' => 'Reviewed and accredited',
        'title' => 'Reviewed, accredited and backed by proven product systems.',
        'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
        'trust_items' => $trust_items,
        'limit' => 7,
    ]);
    ?>

    <section class="fg-links-band">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow"><?php esc_html_e('Keep exploring', 'fenster'); ?></p>
                <h2><?php esc_html_e('Products, services and nearby areas', 'fenster'); ?></h2>
            </div>
            <div class="generated-links">
                <?php foreach (array_slice(array_values(array_merge($product_links, $related_links)), 0, 24) as $link) : ?>
                    <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</article>
