<?php
/**
 * Manufacturer-backed product intelligence for generated product pages.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_product_hub_data(string $slug): array
{
    $systems = [
        'liniar' => ['label' => 'Liniar', 'logo' => FENSTER_THEME_URI . '/assets/partners/liniar-logo.png', 'alt' => 'Liniar'],
        'roseview' => ['label' => 'Roseview', 'logo' => '/wp-content/themes/fenster/assets/partners/roseview-logo-new.png', 'alt' => 'Roseview'],
        'sheerline' => ['label' => 'Sheerline', 'logo' => FENSTER_THEME_URI . '/assets/partners/sheerline.png', 'alt' => 'Sheerline'],
        'distinction' => ['label' => 'Distinction Doors', 'logo' => FENSTER_THEME_URI . '/assets/partners/distinction-doors.png', 'alt' => 'Distinction Doors'],
        'notan' => ['label' => 'Notan Integrated Blinds', 'logo' => '/wp-content/themes/fenster/assets/partners/notan.png', 'alt' => 'Notan Integrated Blinds'],
    ];
    $energyplus_badge = ['label' => 'EnergyPlus', 'image' => FENSTER_THEME_URI . '/assets/partners/liniar-energyplus.png', 'alt' => 'EnergyPlus by Liniar'];
    $thermlock_badge = ['label' => 'Thermlock', 'image' => FENSTER_THEME_URI . '/assets/partners/sheerline-thermlock.png', 'alt' => 'Thermlock'];

    $default = [
        'eyebrow' => 'Product guide',
        'heading' => 'The details worth checking before you choose.',
        'copy' => 'Compare the choices that affect comfort, security, appearance and day-to-day use before the final survey confirms the exact specification.',
        'systems' => [],
        'badges' => [],
        'specs' => [],
        'choices' => [],
    ];

    $data = [
        'casement-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => [$energyplus_badge, 'A+ rated', 'PAS 24 option'],
            'heading' => 'More information on casement windows.',
            'copy' => 'Casement windows are usually the best value option for replacing older uPVC or timber windows. Fenster specifies the 70mm Liniar EnergyPlus system, with the final layout, glass and hardware confirmed after survey.',
            'specs' => [
                ['label' => 'Profile system', 'value' => '70mm Liniar EnergyPlus uPVC profile'],
                ['label' => 'Weather seal', 'value' => 'Co-extruded bubble gasket for continuous draught and rain protection'],
                ['label' => 'Security', 'value' => 'Multi-point locking with PAS 24 and Secured by Design options where specified'],
                ['label' => 'Best for', 'value' => 'Everyday replacement windows, bedrooms, kitchens and mixed fixed/opening layouts'],
            ],
            'choices' => ['Side-hung, top-hung and fixed lights', 'White, foiled woodgrain and selected colours', 'S2 Signature handle finishes', 'Obscure, acoustic, toughened or laminated glass where required'],
        ],
        'flush-casement-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => [$energyplus_badge, 'Timber-look finish', 'Conservation-friendly style'],
            'heading' => 'Flush uPVC windows with timber-look details made clear.',
            'copy' => 'Flush casements are chosen for the flatter sash line, but the convincing result comes from the details: mechanical-look joints, colour, handle finish, glazing bars and how the frame sits in the reveal.',
            'specs' => [
                ['label' => 'System family', 'value' => 'Liniar 70mm flush sash profile'],
                ['label' => 'Appearance', 'value' => 'Flush sash, optional heritage hardware and timber-effect foils'],
                ['label' => 'Performance', 'value' => 'Multi-chamber uPVC profile with modern double glazing options'],
                ['label' => 'Where it fits', 'value' => 'Period-style homes, conservation-sensitive streets and modern homes wanting a flatter line'],
            ],
            'choices' => ['Mechanical-style or welded corner detailing depending on system', 'Astragal or Georgian bar options', 'Cream, Chartwell Green, Irish Oak, Anthracite Grey and other foils', 'Locking handle finishes'],
        ],
        // Systems only, no specs or choices, so the product hub section on the
        // page stays gated off. This exists so the selector hub can show the
        // right mark: both are Liniar uPVC, like every other uPVC window route.
        'bow-bay-windows' => [
            'systems' => [$systems['liniar']],
        ],
        'french-casement-windows' => [
            'systems' => [$systems['liniar']],
        ],
        'tilt-turn-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => ['Secure ventilation', 'Easy cleaning', 'Large opening option'],
            'heading' => 'Tilt and turn windows for safe ventilation and easier cleaning.',
            'copy' => 'Tilt and turn windows are a practical choice for upper floors, flats, bedrooms and larger openings because one sash can tilt inwards for ventilation or turn inwards for cleaning and escape-style access.',
            'specs' => [
                ['label' => 'Operation', 'value' => 'Dual-action inward opening: tilt for ventilation, turn for access and cleaning'],
                ['label' => 'Profile system', 'value' => 'Liniar uPVC profile options, including higher-performance choices where suitable'],
                ['label' => 'Security', 'value' => 'Locking handle and multi-point locking around the sash'],
                ['label' => 'Best for', 'value' => 'Upper floors, restricted outside access and rooms needing controlled ventilation'],
            ],
            'choices' => ['Single large sashes or mixed fixed/opening layouts', 'Safety glass where Building Regulations require it', 'Obscured glass for bathrooms', 'Restrictor and ventilation conversations during survey'],
        ],
        'sliding-sash-windows' => [
            'systems' => [$systems['roseview']],
            'badges' => ['Ultimate Rose', 'Heritage Rose', 'Charisma Rose'],
            'heading' => 'Roseview sliding sash windows with the heritage details kept visible.',
            'copy' => 'Sash windows are not only about the up-and-down movement. Compare the Roseview model, meeting rail, joint detail, sash furniture and finish so the period look stays credible.',
            'specs' => [
                ['label' => 'System family', 'value' => 'Roseview Ultimate Rose, Heritage Rose or Charisma Rose'],
                ['label' => 'Operation', 'value' => 'Vertical sliding sashes with tilt-in cleaning options'],
                ['label' => 'Furniture', 'value' => 'Globe or Acorn sash furniture, confirmed around the selected Rose model'],
                ['label' => 'Best for', 'value' => 'Victorian, Georgian and cottage-style properties where proportions matter'],
            ],
            'choices' => ['Ultimate Rose, Heritage Rose or Charisma Rose model choice', 'Globe or Acorn locks, pole eyes, sash lifts and tilt knobs', 'Obscured glass for landings and bathrooms', 'Acoustic glass for road-facing rooms'],
        ],
        'aluminium-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Prestige', $thermlock_badge, 'SBD option'],
            'heading' => 'Sheerline Prestige aluminium windows with slim, measurable details.',
            'copy' => 'Aluminium windows give slim sightlines with important engineering behind them: thermally broken frames, bead options, security upgrades, concealed drainage and broad colour choice.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline Prestige aluminium window system'],
                ['label' => 'Sightlines', 'value' => 'Slim frame options with exact sightlines confirmed by opening style'],
                ['label' => 'Thermal design', 'value' => 'Sheerline Thermlock multi-chamber thermal break technology'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design options available with suitable glass and hardware'],
            ],
            'choices' => ['Standard or flush casement styles', 'Beaded or beadless options where the system allows', 'Concealed drainage and ventilation shroud conversations', 'Any RAL colour and selected textured/metallic finishes'],
        ],
        'aluminium-flush-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => [$thermlock_badge, 'Flush aluminium', 'RAL colour'],
            'heading' => 'Flush aluminium windows for a cleaner external line.',
            'copy' => 'Flush aluminium windows give a flatter sash appearance than standard aluminium casements, with aluminium strength, colour freedom and modern glazing.',
            'specs' => [
                ['label' => 'Appearance', 'value' => 'Flush sash line for a flatter, more architectural aluminium finish'],
                ['label' => 'System', 'value' => 'Sheerline aluminium profiles specified around opening style and sightline target'],
                ['label' => 'Thermal design', 'value' => 'Thermally broken frame and modern insulated glass unit'],
                ['label' => 'Security', 'value' => 'Locking, glass and hardware selected around the final security requirement'],
            ],
            'choices' => ['Contemporary or softer heritage colour palettes', 'RAL, matt, gloss and textured finish conversations', 'Obscure, acoustic or laminated glass', 'Handle finish coordination'],
        ],
        'heritage-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Classic', $thermlock_badge, 'Steel-look styling'],
            'heading' => 'Sheerline Classic heritage windows for steel-look projects.',
            'copy' => 'Heritage aluminium windows give steel-look styling through glazing bars, slim sightlines, beadless construction, colour choice and a secure modern system.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline Classic heritage-style aluminium window system'],
                ['label' => 'Sightlines', 'value' => 'Slim fixed and opening sightline options for steel-look proportions'],
                ['label' => 'Design details', 'value' => 'Decorative bars, transoms and mullions can create industrial or period-style layouts'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design upgrades where specified'],
            ],
            'choices' => ['Fixed, casement and French-window style openings', 'Black, Anthracite, Agate, White and RAL colours', 'Decorative bar layouts', 'Obscure or laminated glass for doors and lower panes'],
        ],
        'aluminium-bifold-doors' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Prestige', $thermlock_badge, '1.0 W/m²K option'],
            'heading' => 'Sheerline Prestige bifold doors with configuration detail up front.',
            'copy' => 'Choose the pane count, traffic door, threshold, sash weight and security specification around how the doors need to fold and open day to day.',
            'specs' => [
                ['label' => 'Configurations', 'value' => 'Up to seven panes, with traffic door options depending on layout'],
                ['label' => 'Panel capacity', 'value' => 'Large sash sizes and heavy-duty hardware are specified around the opening'],
                ['label' => 'Thresholds', 'value' => 'Weathered, low and access threshold conversations at survey'],
                ['label' => 'Security', 'value' => 'Multi-point locking, shootbolts/deadbolts and security interlocks where specified'],
            ],
            'choices' => ['Open-in or open-out where suitable', 'Traffic door position', 'RAL colour and dual colour options', 'Solar-control, laminated or integral blind glass options'],
        ],
        'slide-fold-doors' => [
            'badges' => ['Independent panels', 'Partial opening', 'No visible intermediate hinges'],
            'heading' => 'Slide and fold doors with more control than a standard bifold.',
            'copy' => 'Slide and fold doors are useful when you want more control than a standard bifold. The panels slide and swing independently, so you can open one section, part of the wall, or the full run depending on the day.',
            'specs' => [
                ['label' => 'Operation', 'value' => 'Panels slide along the track and swing independently for flexible everyday opening'],
                ['label' => 'Everyday use', 'value' => 'Useful when you want ventilation or access without stacking the full door set'],
                ['label' => 'Appearance', 'value' => 'Cleaner intermediate lines with concealed hardware rather than visible central hinges'],
                ['label' => 'Weathering', 'value' => 'Track, seals and drainage are checked carefully at survey'],
            ],
            'choices' => ['Partial opening or full opening', 'Traffic-door style daily access', 'Frame colour and glass specification', 'Threshold and drainage details'],
        ],
        'aluminium-sliding-doors' => [
            'systems' => [$systems['sheerline']],
            'badges' => [$thermlock_badge, 'Large glass panels', 'Slim interlock'],
            'heading' => 'Aluminium sliding doors for wide views and heavy glass.',
            'copy' => 'Aluminium sliders differ from uPVC patio doors through bigger glass, slimmer interlocks, heavier sash capacity, smooth tracks and more architectural colour options.',
            'specs' => [
                ['label' => 'System family', 'value' => 'Sheerline lift and slide style aluminium patio door options'],
                ['label' => 'Glass area', 'value' => 'Large panels with slim interlock options, final sizes confirmed by survey'],
                ['label' => 'Track detail', 'value' => 'Dual or triple-track layouts with drainage and threshold choices'],
                ['label' => 'Hardware', 'value' => 'Lift-slide operation, secure locking and stainless track details where specified'],
            ],
            'choices' => ['Two, three or four-panel style layouts', 'Large fixed pane with sliding access', 'RAL colour and dual colour options', 'Solar-control glass for sunny elevations'],
        ],
        'aluminium-doors' => [
            'systems' => [$systems['sheerline']],
            'badges' => [$thermlock_badge, 'PAS 24 option', 'Low threshold option'],
            'heading' => 'Aluminium residential doors with window-matching options.',
            'copy' => 'Aluminium doors are a robust, slim-framed option for front, rear, side and utility entrances, especially when the door needs to match aluminium windows or sliders.',
            'specs' => [
                ['label' => 'Door styles', 'value' => 'Single doors, glazed entrance doors and paired/French-style aluminium sets'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design options with suitable glass, locks and hardware'],
                ['label' => 'Thresholds', 'value' => 'Standard, weathered and low-threshold conversations depending on exposure and access'],
                ['label' => 'Finish', 'value' => 'Powder-coated aluminium in RAL colours and selected textured finishes'],
            ],
            'choices' => ['Clear, obscure, laminated or decorative glass', 'Lever, pull and lock hardware options', 'Sidelights and toplights where the opening allows', 'Colour matched to aluminium windows'],
        ],
        'heritage-aluminium-doors' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Classic', $thermlock_badge, 'SBD option'],
            'heading' => 'Classic heritage aluminium doors for internal or external steel-look openings.',
            'copy' => 'Heritage doors are shaped around single doors, French doors, toplights, bar layouts, open-in/open-out options and secure external-use specifications.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline Classic heritage-style aluminium door system'],
                ['label' => 'Layouts', 'value' => 'Single doors, French doors, sidelights, toplights and decorative bar patterns'],
                ['label' => 'Where used', 'value' => 'External doors and selected internal-style projects, depending on specification'],
                ['label' => 'Security', 'value' => 'Secured by Design style upgrades available where the full doorset specification supports it'],
            ],
            'choices' => ['Single or French door layouts', 'No bars, 2 bar or 4 bar glazing patterns', 'Open-in or open-out options', 'Obscure, reeded or laminated glass'],
        ],
        'composite-doors' => [
            'systems' => [$systems['distinction']],
            'badges' => ['Approved installer', 'Signature range', 'Contemporary range'],
            'heading' => 'Distinction composite doors with style, colour and glass choice made clearer.',
            'copy' => 'Composite doors start with style, then security and construction. Compare the broad design range, GRP skins, foam-filled cores, water-resistant rails and complete doorset specification.',
            'specs' => [
                ['label' => 'Range', 'value' => 'Signature and Contemporary doors, including Rustic Renown and glazed designs'],
                ['label' => 'Construction', 'value' => 'GRP door skin, insulated core and reinforced structural elements depending on chosen slab'],
                ['label' => 'Door slab', 'value' => '44.5mm insulated GRP composite slab'],
                ['label' => 'Security', 'value' => 'Secure locks, cylinders, laminated decorative glass and SBD options by specification'],
            ],
            'choices' => ['Standard and premium colour choices', 'Dual colour options where available', 'Decorative, obscure and laminated glass', 'Long bar, lever, urn, knocker and letterplate hardware'],
        ],
        'upvc-doors' => [
            'systems' => [$systems['liniar']],
            'badges' => ['Liniar uPVC', $energyplus_badge, 'Multi-point locking'],
            'heading' => 'Liniar uPVC doors for practical front, rear and side entrances.',
            'copy' => 'uPVC doors are a sensible, secure and affordable option with practical panel and glass choices, locking, cylinders, hinges, thresholds and colour foils.',
            'specs' => [
                ['label' => 'System', 'value' => 'Liniar uPVC door profile options'],
                ['label' => 'Security', 'value' => 'Multi-point locking with anti-snap cylinder and hinge choices confirmed by specification'],
                ['label' => 'Design', 'value' => 'Full panel, half panel, glazed, side panel and obscured glass combinations'],
                ['label' => 'Finish', 'value' => 'White, woodgrain foils and selected colours depending on system'],
            ],
            'choices' => ['Front, rear, side and utility doors', 'Sidelights and toplights', 'Low-threshold access conversations', 'Lever/lever or lever/pad hardware options'],
        ],
        'patio-doors' => [
            'systems' => [$systems['liniar']],
            'badges' => ['uPVC slider', $energyplus_badge, 'Space-saving'],
            'heading' => 'uPVC patio doors, separate from aluminium sliders.',
            'copy' => 'Patio doors are the value-led sliding option for garden access, with a uPVC frame, practical track, up to four-pane layouts and reliable everyday security.',
            'specs' => [
                ['label' => 'Material', 'value' => 'Liniar-style uPVC sliding patio door profile'],
                ['label' => 'Configurations', 'value' => 'Two, three and four-pane styles depending on opening width'],
                ['label' => 'Operation', 'value' => 'Smooth sliding panels without swing space into the room or patio'],
                ['label' => 'Survey check', 'value' => 'Track, drainage, floor level, threshold and locking alignment'],
            ],
            'choices' => ['Left or right sliding directions', 'White and foiled colour options', 'Obscure or solar-control glass where suitable', 'Handle and locking options'],
        ],
        'french-doors' => [
            'systems' => [$systems['liniar']],
            'badges' => ['ModLok option', $energyplus_badge, 'A+ rated'],
            'heading' => 'Liniar French doors with threshold and security details included.',
            'copy' => 'French doors are familiar, but the important buying details are open-in/open-out, flying mullion, threshold, security, Georgian bars and whether the door is being used as a main entrance or occasional garden opening.',
            'specs' => [
                ['label' => 'System', 'value' => 'Liniar uPVC French door profiles, including ModLok style reinforcement options where specified'],
                ['label' => 'Opening', 'value' => 'Open-in or open-out configurations depending on space and exposure'],
                ['label' => 'Thresholds', 'value' => 'Weathered, low and Part M style access threshold conversations'],
                ['label' => 'Security', 'value' => 'Multi-point locking with PAS 24, SBD and Part Q options by specification'],
            ],
            'choices' => ['Full glass or panel/glass combinations', 'Georgian or astragal bars', 'Obscure, toughened or laminated glass', 'Door handle and hinge finishes'],
        ],
        'roof-lanterns' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline S1', $thermlock_badge, 'SheerVent option'],
            'heading' => 'Sheerline S1 roof lanterns with size, glass and ventilation detail.',
            'copy' => 'Plan daylight, overheating control, roof opening size, tie bars, glass choice and ventilation before the survey.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline S1 aluminium roof lantern'],
                ['label' => 'Sizes', 'value' => 'Large lantern sizes possible, with final span and structural needs confirmed by survey'],
                ['label' => 'Glazing', 'value' => '28mm glazing, solar-control, acoustic and toughened glass options'],
                ['label' => 'Ventilation', 'value' => 'SheerVent automated vent and rain sensor options where suitable'],
            ],
            'choices' => ['Two-way, three-way, square and rectangular lantern styles', 'RAL colours inside and outside', 'Solar-control glass for south-facing roofs', 'Security glazing and anti-tamper details'],
        ],
        'roofline' => [
            'systems' => [$systems['liniar']],
            'badges' => ['5m boards', 'Low maintenance', 'Ventilation details'],
            'heading' => 'Liniar roofline details for fascias, soffits and guttering.',
            'copy' => 'Roofline work protects the roof edge through suitable board thickness, lengths, trims, ventilation, gutter runs, corners, finials and colour matching to the wider exterior.',
            'specs' => [
                ['label' => 'Products', 'value' => 'Fascias, soffits, trims, ventilators, corners, finials and guttering details'],
                ['label' => 'Board details', 'value' => 'Long board lengths and robust fascia thickness options depending on installation'],
                ['label' => 'Ventilation', 'value' => 'Soffit and over-fascia ventilation considered where the roof requires it'],
                ['label' => 'Finish', 'value' => 'White and foiled colour choices to coordinate with windows and doors'],
            ],
            'choices' => ['Full replacement or targeted roofline work', 'Ventilated or non-ventilated soffits', 'Gutter profile and colour', 'Colour-matched trims'],
        ],
        'integral-blinds' => [
            'systems' => [$systems['notan']],
            'badges' => ['Magnetic control', 'Electric option', '11 standard colours'],
            'heading' => 'Notan integral blinds with control, size and glass-unit detail.',
            'copy' => 'Integral blinds are sealed inside the glass unit, so the key choices are cavity size, glass make-up, controls, colour, maximum blind size and warranty cover.',
            'specs' => [
                ['label' => 'Glass unit', 'value' => 'NTB 24/28 style cavity options with Low-E, toughened and argon-filled glass options'],
                ['label' => 'Controls', 'value' => 'Magnetic manual control or electric remote/battery options'],
                ['label' => 'Testing', 'value' => 'Cycle-tested blind mechanisms, with final warranty depending on control type'],
                ['label' => 'Colours', 'value' => 'Standard blind colours with RAL conversations where available'],
            ],
            'choices' => ['Tilt-only or lift-and-tilt blinds depending on size', 'Sliding doors, bifolds, windows and replacement glass units', 'White, grey, black and neutral blind colours', 'Electric charging and remote-control options'],
        ],
        'double-glazing-replacement' => [
            'badges' => ['Low-E glass', 'Argon option', 'Safety glass checked'],
            'heading' => 'Replacement glass units specified around the existing frame.',
            'copy' => 'Replacement glass is made to measure around glass type, spacer, safety requirements, toughened or laminated needs, acoustic or solar options and whether the existing frame is worth keeping.',
            'specs' => [
                ['label' => 'Glass types', 'value' => 'Low-E, argon-filled, toughened, laminated, acoustic and solar-control options where suitable'],
                ['label' => 'Spacer', 'value' => 'Spacer bar and unit thickness matched to the existing frame'],
                ['label' => 'Safety', 'value' => 'Critical locations checked for toughened or laminated safety glass'],
                ['label' => 'Best for', 'value' => 'Misted, blown, cracked or failed sealed units where frames remain sound'],
            ],
            'choices' => ['Like-for-like replacement glass', 'Obscured glass upgrades', 'Pet-flap apertures in new sealed units', 'Integral blind units where suitable'],
        ],
        'secondary-glazing' => [
            'badges' => ['Acoustic improvement', 'Internal aluminium frame', 'RAL colour'],
            'heading' => 'Secondary glazing options for retained windows.',
            'copy' => 'Secondary glazing is specified around the existing window, including sliding, hinged, fixed or lift-out panels, reveal depth, shutters, handles, condensation risk and air-gap performance.',
            'specs' => [
                ['label' => 'Styles', 'value' => 'Horizontal sliding, vertical sliding, hinged, fixed and lift-out panels'],
                ['label' => 'Acoustics', 'value' => 'Glass choice and air gap can significantly improve noise reduction'],
                ['label' => 'Thermal comfort', 'value' => 'Adds an internal glazed layer to reduce heat loss through existing windows'],
                ['label' => 'Survey checks', 'value' => 'Reveal depth, handles, shutters, ventilation and original-frame condition'],
            ],
            'choices' => ['Discreet RAL frame colours', 'Acoustic laminated glass', 'Removable panels for occasional access', 'Opening styles matched to existing sashes'],
        ],
        'window-and-door-repairs' => [
            'badges' => ['Repair-first', 'Clear quotes', 'Parts checked'],
            'heading' => 'Repair information before you replace.',
            'copy' => 'Repair advice stays straightforward: common faults, diagnosis, parts availability and frame condition all decide whether repair or replacement is sensible.',
            'specs' => [
                ['label' => 'Common repairs', 'value' => 'Locks, handles, hinges, cylinders, dropped doors, stiff windows and failed gaskets'],
                ['label' => 'Glass faults', 'value' => 'Misted sealed units and damaged glass can often be replaced separately'],
                ['label' => 'Diagnosis', 'value' => 'Operation, alignment, seals, frame condition and security are checked before quoting'],
                ['label' => 'Limitations', 'value' => 'Very old or damaged systems may need replacement if safe parts are not available'],
            ],
            'choices' => ['Repair versus replacement advice', 'Security upgrades such as cylinders and handles', 'Draught and gasket checks', 'Maintenance guidance after repair'],
        ],
        'cat-and-dog-flaps' => [
            'badges' => ['Glass or panel', 'Microchip option', 'New unit required'],
            'heading' => 'Pet flap fitting decided before the glass or panel is ordered.',
            'copy' => 'A clean pet-flap installation starts with the right fitting method. Fenster checks whether the opening needs a new sealed glass unit, a replacement door panel or a panel cut-out, then confirms the flap model and position before manufacture.',
            'specs' => [
                ['label' => 'Glass fitting', 'value' => 'A new sealed glass unit is made with the correct aperture for the chosen flap'],
                ['label' => 'Panel fitting', 'value' => 'Suitable uPVC or door panels can often accept a flap after material and position checks'],
                ['label' => 'Access control', 'value' => 'Manual, lockable and microchip-controlled flap options can be discussed'],
                ['label' => 'Survey checks', 'value' => 'Pet size, flap height, glass type, door construction, threshold and outside access'],
            ],
            'choices' => ['Cat flaps and selected dog flap sizes', 'Clear or obscure replacement glass', 'Microchip access control', 'Weather, threshold and security positioning advice'],
        ],
    ];

    $hub = array_replace_recursive($default, $data[$slug] ?? []);

    $spec_copy = [
        'casement-windows' => [
            'Profile system' => 'EnergyPlus is the 70mm uPVC profile system used for Fenster casement windows, with layout and glazing chosen around each room.',
            'Weather seal' => 'The continuous gasket helps keep draughts and driving rain out, which is especially noticeable on exposed elevations.',
            'Security' => 'Locks, hinges, handles and glass are specified together so the finished window matches the security level needed for the room.',
            'Best for' => 'Casements are flexible enough for most homes because fixed panes, top openers and side openers can be combined in one frame.',
        ],
        'flush-casement-windows' => [
            'System family' => 'The Liniar flush sash keeps the opening sash level with the outer frame for a flatter, more traditional-looking window.',
            'Appearance' => 'Foiled finishes, glazing bars and heritage hardware make the biggest difference when the aim is a timber-style result.',
            'Performance' => 'The multi-chamber uPVC frame and modern double-glazed units improve comfort without changing the clean flush appearance.',
            'Where it fits' => 'Flush casements work well where standard uPVC would look too modern or too bulky against the building.',
        ],
        'tilt-turn-windows' => [
            'Operation' => 'Tilt mode gives secure background ventilation, while turn mode opens the sash inwards for cleaning and wider access.',
            'Profile system' => 'The profile is chosen around the opening size, required performance and the amount of frame visible from inside.',
            'Security' => 'A tilt and turn window relies on the full sash locking correctly, so hardware and installation accuracy matter.',
            'Best for' => 'They are especially useful upstairs, in flats or anywhere outside cleaning access is awkward.',
        ],
        'sliding-sash-windows' => [
            'System family' => 'Ultimate Rose, Heritage Rose and Charisma Rose each give a different balance of authenticity, budget and detail.',
            'Operation' => 'The sashes slide vertically for the traditional look, with tilt-in cleaning available where the selected model supports it.',
            'Furniture' => 'Locks, lifts, pole eyes and tilt knobs are chosen to suit the Roseview model and the style of the property.',
            'Best for' => 'These are strongest on homes where proportions, meeting rails and sash details need to look right from the street.',
        ],
        'aluminium-windows' => [
            'System' => 'Prestige is the main aluminium window system for slim frames, strong sections and a modern powder-coated finish.',
            'Sightlines' => 'Opening style affects how slim the finished window looks, so fixed panes, casements and dummy sashes are planned together.',
            'Thermal design' => 'Thermlock technology separates the inside and outside aluminium to reduce heat transfer through the frame.',
            'Security' => 'The security specification depends on glass, locks and hardware as a complete window specification, not one isolated part.',
        ],
        'aluminium-flush-windows' => [
            'Appearance' => 'The flush sash gives aluminium a cleaner external line, useful on modern homes and sharper renovation projects.',
            'System' => 'The exact aluminium profile is matched to the opening style, frame size and sightline target.',
            'Thermal design' => 'A thermally broken frame and insulated glass unit help reduce cold transfer through the aluminium.',
            'Security' => 'Locks, glass and hardware are chosen together so the finished window suits the location and access risk.',
        ],
        'heritage-windows' => [
            'System' => 'Sheerline Classic gives steel-look styling with modern aluminium performance and powder-coated finishes.',
            'Sightlines' => 'Slim fixed and opening sections help create the industrial or period proportions people expect from heritage glazing.',
            'Design details' => 'Bars, mullions and transoms are planned around the room, view and original architecture rather than added at random.',
            'Security' => 'External heritage windows can be specified with stronger security options where the full design supports them.',
        ],
        'aluminium-bifold-doors' => [
            'Configurations' => 'Pane count and traffic door position decide how the doors work every day, not just how they look fully open.',
            'Panel capacity' => 'Larger panes need the right hardware, glass weight and frame design so operation stays smooth over time.',
            'Thresholds' => 'The threshold choice balances weather protection, access and internal floor levels.',
            'Security' => 'The locking plan covers the main traffic door, intermediate panels and the meeting points between sashes.',
        ],
        'slide-fold-doors' => [
            'Operation' => 'Each panel can move independently, which gives more flexible ventilation and access than a standard bifold stack.',
            'Everyday use' => 'You can open one panel for quick access or move several panels when the room needs a wider opening.',
            'Appearance' => 'The system reduces the visual clutter of intermediate hinges, giving a cleaner line across the opening.',
            'Weathering' => 'Track position, seals and drainage need careful planning because the doors move differently from a conventional slider.',
        ],
        'aluminium-sliding-doors' => [
            'System family' => 'Aluminium sliding doors are chosen for larger glass panels, slimmer interlocks and a more architectural finish than uPVC patio doors.',
            'Glass area' => 'Big panes need the right glass thickness, panel weight and access plan so the doors remain practical.',
            'Track detail' => 'The track layout controls how many panels move, how they stack and how water drains away.',
            'Hardware' => 'Lift-slide hardware helps larger panels move smoothly while maintaining secure locking when closed.',
        ],
        'aluminium-doors' => [
            'Door styles' => 'Single, glazed and paired aluminium doors can be matched to nearby aluminium windows or sliders for a consistent finish.',
            'Security' => 'Locks, cylinders, glass and hardware are chosen as a complete doorset specification.',
            'Thresholds' => 'Threshold choice depends on exposure, drainage, accessibility and whether the door is a main entrance.',
            'Finish' => 'Powder coating gives a broad colour choice, including dual-colour options where the inside and outside need different looks.',
        ],
        'heritage-aluminium-doors' => [
            'System' => 'Classic heritage doors create the steel-look style with modern aluminium sections and external-door security options.',
            'Layouts' => 'Bars, sidelights and toplights are planned around the opening so the design feels balanced rather than busy.',
            'Where used' => 'The specification changes depending on whether the doors are external, internal-style or part of a larger glazed screen.',
            'Security' => 'External heritage doors can use stronger locking and glass options where the layout supports them.',
        ],
        'composite-doors' => [
            'Range' => 'The door style sets the overall look, from cottage and traditional designs through to modern slabs with long glazing.',
            'Construction' => 'The slab, core, rails and frame are selected to give a solid-feeling entrance door with good insulation.',
            'Door depths' => 'Different door depths suit different performance, appearance and budget needs, so this is checked before ordering.',
            'Security' => 'Locks, cylinders, hinges and glass are specified together so the entrance door is secure as a complete set.',
        ],
        'upvc-doors' => [
            'System' => 'A Liniar uPVC door is a practical option for rear, side and utility openings where durability and value matter.',
            'Security' => 'Multi-point locking and suitable cylinders are chosen around how exposed and frequently used the door is.',
            'Design' => 'Panels, clear glass and obscure glass can be combined to balance light, privacy and everyday use.',
            'Finish' => 'White and foiled finishes can be coordinated with existing uPVC windows or a wider replacement project.',
        ],
        'patio-doors' => [
            'Material' => 'uPVC patio doors are the cost-effective sliding option when aluminium sightlines and very large panes are not needed.',
            'Configurations' => 'The number of panes depends on opening width, access position and how much fixed glass you want.',
            'Operation' => 'Sliding panels save space because they do not swing into the room or out onto the patio.',
            'Survey check' => 'The survey confirms floor levels, drainage, track condition and locking alignment before manufacture.',
        ],
        'french-doors' => [
            'System' => 'The Liniar system gives a familiar French door with modern uPVC performance and reinforcement options where needed.',
            'Opening' => 'Open-in and open-out choices affect furniture, weathering, room layout and how the doors are used day to day.',
            'Thresholds' => 'Thresholds are chosen around access, weather exposure and the finished floor level inside and outside.',
            'Security' => 'Locking, glass and reinforcement are specified together, especially when the doors are used as a main garden entrance.',
        ],
        'roof-lanterns' => [
            'System' => 'The S1 lantern is the aluminium rooflight system, designed for strong frames and slim internal sightlines.',
            'Sizes' => 'The opening span, upstand and roof structure decide the final lantern size before it is ordered.',
            'Glazing' => 'Glass choice affects heat, glare, noise and safety, especially on sunny or exposed roof elevations.',
            'Ventilation' => 'Powered ventilation can help release heat and moisture where the roof lantern sits over a busy living space.',
        ],
        'roofline' => [
            'Products' => 'Fascias, soffits, trims and gutters are considered together so the roof edge drains and ventilates properly.',
            'Board details' => 'Board thickness and length affect durability, joint positions and the final appearance along the roofline.',
            'Ventilation' => 'Ventilation is checked so the roof space can breathe where the existing construction requires it.',
            'Finish' => 'White or foiled roofline finishes can be matched to windows, doors, gutters and the wider exterior.',
        ],
        'integral-blinds' => [
            'Glass unit' => 'The blind sits sealed between the panes, so the glass unit size and cavity are chosen around the door or window.',
            'Controls' => 'Manual magnetic controls are simple and reliable, while electric controls suit larger sets or easier operation.',
            'Testing' => 'Cycle testing and warranty detail matter because the blind mechanism cannot be adjusted like a room-side blind.',
            'Colours' => 'Blind colour is chosen alongside frame colour, glass tone and the room finish so it does not feel like an afterthought.',
        ],
        'double-glazing-replacement' => [
            'Glass types' => 'The replacement unit can improve safety, privacy, sound control or solar control while keeping the existing frame.',
            'Spacer' => 'Spacer type and unit thickness must match the frame rebate so the new glass seals correctly.',
            'Safety' => 'Doors, low panes and side panels are checked for safety glass requirements before the unit is ordered.',
            'Best for' => 'This is usually the right option when the glass has failed but the frame still operates and seals properly.',
        ],
        'secondary-glazing' => [
            'Styles' => 'The opening style is matched to the existing window so the original sashes or casements can still be reached.',
            'Acoustics' => 'Noise reduction depends on glass type, air gap and how well the secondary frame seals around the reveal.',
            'Thermal comfort' => 'The extra internal glazed layer can make retained windows feel warmer and reduce draughts.',
            'Survey checks' => 'Handles, shutters, reveals and ventilation are checked because they can all affect the best secondary glazing layout.',
        ],
        'window-and-door-repairs' => [
            'Common repairs' => 'Most repair calls start with operation faults: dropped doors, failed handles, stiff hinges, broken locks or draughty seals.',
            'Glass faults' => 'Misted or cracked sealed units can often be changed without replacing the full window or door.',
            'Diagnosis' => 'A proper check looks at alignment, frame condition, locks, gaskets and whether replacement parts are still available.',
            'Limitations' => 'Repair is not always sensible if parts are obsolete, the frame is distorted or security would still be poor afterwards.',
        ],
        'cat-and-dog-flaps' => [
            'Glass fitting' => 'Sealed glass cannot be cut on site, so a new unit is manufactured with the aperture already in the right place.',
            'Panel fitting' => 'Panel installs depend on the door material, panel thickness and whether the flap will sit at a usable height.',
            'Access control' => 'Manual, lockable and microchip flaps suit different pets, security needs and household routines.',
            'Survey checks' => 'Pet size, outside access, threshold height and door construction all affect where the flap should go.',
        ],
    ];

    if (! empty($hub['specs']) && isset($spec_copy[$slug])) {
        foreach ($hub['specs'] as $index => $spec) {
            $label = (string) ($spec['label'] ?? '');
            if ($label !== '' && empty($hub['specs'][$index]['copy']) && isset($spec_copy[$slug][$label])) {
                $hub['specs'][$index]['copy'] = $spec_copy[$slug][$label];
            }
        }
    }

    return $hub;
}

/**
 * Named-technology banner arguments for a product route.
 *
 * Owner instruction, 2026-07-27: Thermlock on every aluminium product
 * including roof lanterns but not slide and fold; EnergyPlus on every Liniar
 * product except patio doors.
 *
 * Roofline is Liniar but is deliberately absent: EnergyPlus is a glazed-profile
 * technology and roofline has no chambers and no glass.
 *
 * @param string $slug Product route slug.
 * @return array<string, mixed> Args for template-parts/components/tech-banner, or [] for none.
 */
function fenster_tech_banner_args(string $slug): array
{
    $energyplus_routes = [
        'casement-windows',
        'flush-casement-windows',
        'bow-bay-windows',
        'french-casement-windows',
        'tilt-turn-windows',
        'upvc-doors',
        'french-doors',
    ];

    $thermlock_routes = [
        'aluminium-windows',
        'aluminium-flush-windows',
        'heritage-windows',
        'aluminium-bifold-doors',
        'aluminium-sliding-doors',
        'aluminium-doors',
        'heritage-aluminium-doors',
        'roof-lanterns',
    ];

    if (in_array($slug, $energyplus_routes, true)) {
        /* The banner is shared across seven routes but the glazing figure is
           not. Quoting the casement best case everywhere put 0.95 W/m²K with
           36mm triple directly above a key-specification strip reading 1.2 on
           flush casement, which cannot take triple at all, and above 1.0 on
           uPVC doors. Owner-reported contradiction, 2026-07-29. A route with
           no confirmed figure gets no figure rather than an inherited one. */
        $glazing_fact = ['value' => '0.95', 'label' => 'W/m²K with 36mm triple glazing'];

        if ($slug === 'flush-casement-windows') {
            // Owner-confirmed: 28mm double is the only unit this sash takes.
            $glazing_fact = ['value' => '1.2', 'label' => 'W/m²K with 28mm double glazing'];
        } elseif ($slug === 'upvc-doors') {
            $glazing_fact = ['value' => '1.0', 'label' => 'W/m²K on the door'];
        } elseif ($slug === 'french-doors') {
            $glazing_fact = null;
        }

        $facts = [['value' => '6', 'label' => 'chambers through the frame']];
        if ($glazing_fact !== null) {
            $facts[] = $glazing_fact;
        }
        $facts[] = ['value' => 'Lead-free', 'label' => 'profile formulation'];

        return [
            'logo' => '/wp-content/themes/fenster/assets/partners/liniar-energyplus.png',
            'logo_alt' => 'EnergyPlus by Liniar',
            'eyebrow' => 'The profile we specify',
            'title' => 'Liniar EnergyPlus',
            'copy' => 'Liniar\'s six-chamber profile. The chambers sit inside the frame where you never see them, and the weather seal is extruded as part of the profile rather than pushed into a groove afterwards, so it cannot work loose at a corner.',
            'facts' => $facts,
        ];
    }

    if (in_array($slug, $thermlock_routes, true)) {
        return [
            // Ink variant: the supplied mark is pale grey and disappears on a
            // white panel. Same monochrome wordmark, legible tone.
            'logo' => '/wp-content/themes/fenster/assets/partners/sheerline-thermlock-ink.png',
            'logo_alt' => 'Thermlock by Sheerline',
            'eyebrow' => 'Inside every Sheerline frame',
            'title' => 'Sheerline Thermlock',
            'copy' => 'Most aluminium systems break the cold bridge with a polyamide strip. Sheerline designed their own multi-chamber core instead and put it at close to double the insulation. It is built into every Sheerline product we fit.',
            'facts' => [
                ['value' => 'Multi-chamber', 'label' => 'thermal core, not a polyamide strip'],
                ['value' => 'Verified', 'label' => 'independent U-value reports'],
            ],
        ];
    }

    return [];
}

/**
 * Args for the shared handle grid, per handle family.
 *
 * Kept here rather than at the call sites because each family renders from
 * more than one template: windows from the generic journey and the casement
 * page, doors from the generic journey and the heritage page. Two copies of
 * the same heading is how they drift apart.
 */
function fenster_window_handle_grid_args(): array
{
    $data = fenster_data('window_handles', []);

    return [
        'data' => is_array($data) ? $data : [],
        'id' => 'window-handle-finishes',
        'eyebrow' => 'Handles',
        'heading' => 'Six handle finishes, lockable as standard.',
        'intro' => 'The S2 Signature range, in left and right hand versions so the operation matches the way the window opens. The release button and the screw cover cap come in the finish you choose rather than defaulting to white.',
        'note' => 'Handing, restrictors and key-locking are settled at survey, alongside how far the sash swings and whether the handle can be reached comfortably.',
        'alt_pattern' => 'S2 Signature window handle in %s',
        'sub_label' => true,
    ];
}

function fenster_door_handle_grid_args(): array
{
    $data = fenster_data('door_handles', []);
    $finishes = is_array($data['finishes'] ?? null) ? $data['finishes'] : [];
    /* Spelled out because TONEOFVOICE.md wants small numbers as words. */
    $words = [2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten'];
    $count = count($finishes);

    return [
        'data' => is_array($data) ? $data : [],
        'id' => 'door-handle-finishes',
        'eyebrow' => 'Door handles',
        'heading' => sprintf('%s handle finishes on a long backplate.', $words[$count] ?? (string) $count),
        'intro' => 'The backplate carries the lever and the cylinder aperture together, so the lock and the handle are settled as one decision rather than two. The finish you pick runs through the letterplate, hinges and threshold as well.',
        'note' => 'Which handles a door can take depends on the slab, the lock set and the colour package, so we confirm the exact hardware at specification stage.',
        'alt_pattern' => 'Long-plate door handle in %s',
        'columns' => 'fg-handle-finishes--doors',
        'link_href' => home_url('/handle-options/#door-handle-finishes'),
    ];
}
