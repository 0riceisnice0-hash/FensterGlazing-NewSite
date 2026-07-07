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
$location = is_array($location) ? $location : $locations['milton-keynes'];

$location_name = $location['name'];
$service_label = $service['label'];
$service_name = $service['name'];
$thing = $service['thing'];
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
$product_links = [
    ['text' => 'Windows', 'url' => home_url('/windows-milton-keynes/')],
    ['text' => 'Doors', 'url' => home_url('/doors-milton-keynes/')],
    ['text' => 'Composite Doors', 'url' => home_url('/composite-doors/')],
    ['text' => 'Aluminium Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/')],
    ['text' => 'Integral Blinds', 'url' => home_url('/integral-blinds/')],
    ['text' => 'Replacement Glazing', 'url' => home_url('/double-glazing-replacement/')],
];
?>

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
                            <img src="<?php echo esc_url($trust['item']['src']); ?>" alt="<?php echo esc_attr($trust['item']['alt']); ?>" loading="lazy">
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
