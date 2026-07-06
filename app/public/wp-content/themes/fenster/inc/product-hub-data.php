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
        'notan' => ['label' => 'Notan Integrated Blinds', 'logo' => '', 'alt' => 'Notan Integrated Blinds'],
    ];
    $energyplus_badge = ['label' => 'EnergyPlus', 'image' => FENSTER_THEME_URI . '/assets/partners/liniar-energyplus.png', 'alt' => 'EnergyPlus by Liniar'];
    $thermlock_badge = ['label' => 'Thermlock', 'image' => FENSTER_THEME_URI . '/assets/partners/sheerline-thermlock.png', 'alt' => 'Thermlock'];

    $default = [
        'eyebrow' => 'Product information hub',
        'heading' => 'The details worth checking before you choose.',
        'copy' => 'Use this section to compare the practical specification points that affect comfort, security, appearance and long-term use. Fenster confirms the final specification after survey, so the page stays useful without pretending every property needs the same answer.',
        'systems' => [],
        'badges' => [],
        'specs' => [],
        'choices' => [],
    ];

    $data = [
        'casement-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => [$energyplus_badge, 'A+ rated', 'PAS 24 option'],
            'heading' => 'Liniar uPVC casement windows, explained properly.',
            'copy' => 'Casement windows are usually the best value route for replacing older uPVC or timber windows, but the profile choice still matters. Fenster can specify Liniar Standard, EnergyPlus or Zero|90 style performance routes depending on budget, opening depth and the target energy rating.',
            'specs' => [
                ['label' => 'Profile options', 'value' => '70mm Standard or EnergyPlus, with 90mm Zero|90 style upgrades where suitable'],
                ['label' => 'Weather seal', 'value' => 'Co-extruded bubble gasket for continuous draught and rain protection'],
                ['label' => 'Security', 'value' => 'Multi-point locking with PAS 24 and Secured by Design routes where specified'],
                ['label' => 'Best for', 'value' => 'Everyday replacement windows, bedrooms, kitchens and mixed fixed/opening layouts'],
            ],
            'choices' => ['Side-hung, top-hung and fixed lights', 'White, foiled woodgrain and selected colours', 'S2 Signature handle finishes', 'Obscure, acoustic, toughened or laminated glass where required'],
        ],
        'flush-casement-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => [$energyplus_badge, 'Timber-look finish', 'Conservation-friendly style'],
            'heading' => 'Flush uPVC windows with the timber-look details customers ask about.',
            'copy' => 'Flush casements are chosen for the flatter sash line, but the convincing result comes from the details: mechanical-look joints, colour, handle finish, glazing bars and how the frame sits in the reveal.',
            'specs' => [
                ['label' => 'System family', 'value' => 'Liniar 70mm flush sash, with Resurgence-style deeper flush options where specified'],
                ['label' => 'Appearance', 'value' => 'Flush sash, optional heritage hardware and timber-effect foils'],
                ['label' => 'Performance', 'value' => 'Multi-chamber uPVC profile with modern double or triple glazing options'],
                ['label' => 'Use case', 'value' => 'Period-style homes, conservation-sensitive streets and modern homes wanting a flatter line'],
            ],
            'choices' => ['Mechanical-style or welded corner detailing depending on system', 'Astragal or Georgian bar options', 'Cream, Chartwell Green, Irish Oak, Anthracite Grey and other foils', 'Locking handle finishes'],
        ],
        'tilt-turn-windows' => [
            'systems' => [$systems['liniar']],
            'badges' => ['Secure ventilation', 'Easy cleaning', 'Large opening option'],
            'heading' => 'Tilt and turn windows for safe ventilation and easier cleaning.',
            'copy' => 'Tilt and turn windows are a practical choice for upper floors, flats, bedrooms and larger openings because one sash can tilt inwards for ventilation or turn inwards for cleaning and escape-style access.',
            'specs' => [
                ['label' => 'Operation', 'value' => 'Dual-action inward opening: tilt for ventilation, turn for access and cleaning'],
                ['label' => 'Profile route', 'value' => 'Liniar uPVC profile options, including higher-performance routes where suitable'],
                ['label' => 'Security', 'value' => 'Locking handle and multi-point locking around the sash'],
                ['label' => 'Best for', 'value' => 'Upper floors, restricted outside access and rooms needing controlled ventilation'],
            ],
            'choices' => ['Single large sashes or mixed fixed/opening layouts', 'Safety glass where Building Regulations require it', 'Obscure glass for bathrooms', 'Restrictor and ventilation conversations during survey'],
        ],
        'sliding-sash-windows' => [
            'systems' => [$systems['roseview']],
            'badges' => ['Ultimate Rose', 'Heritage Rose', 'Charisma Rose'],
            'heading' => 'Roseview sliding sash windows with the heritage details kept visible.',
            'copy' => 'Sash windows are not only about the up-and-down movement. Customers often need to understand which Roseview model fits the property, how the meeting rail and joints differ, what furniture is used and which finish keeps the period look credible.',
            'specs' => [
                ['label' => 'System family', 'value' => 'Roseview Ultimate Rose, Heritage Rose or Charisma Rose'],
                ['label' => 'Operation', 'value' => 'Vertical sliding sashes with tilt-in cleaning options'],
                ['label' => 'Furniture', 'value' => 'Globe or Acorn sash furniture, confirmed around the selected Rose model'],
                ['label' => 'Best for', 'value' => 'Victorian, Georgian and cottage-style properties where proportions matter'],
            ],
            'choices' => ['Ultimate Rose, Heritage Rose or Charisma Rose model route', 'Globe or Acorn locks, pole eyes, sash lifts and tilt knobs', 'Obscure glass for landings and bathrooms', 'Acoustic glass for road-facing rooms'],
        ],
        'aluminium-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Prestige', $thermlock_badge, 'SBD option'],
            'heading' => 'Sheerline Prestige aluminium windows with slim, measurable details.',
            'copy' => 'Aluminium windows sell on slim sightlines, but the page should also explain the engineering: thermally broken frames, bead options, security upgrades, concealed drainage and colour choice.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline Prestige aluminium window system'],
                ['label' => 'Sightlines', 'value' => 'Slim frame options with exact sightlines confirmed by opening style'],
                ['label' => 'Thermal design', 'value' => 'Sheerline Thermlock multi-chamber thermal break technology'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design routes available with suitable glass and hardware'],
            ],
            'choices' => ['Standard or flush casement styles', 'Beaded or beadless options where the system allows', 'Concealed drainage and ventilation shroud conversations', 'Any RAL colour and selected textured/metallic finishes'],
        ],
        'aluminium-flush-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => [$thermlock_badge, 'Flush aluminium', 'RAL colour'],
            'heading' => 'Flush aluminium windows for a cleaner external line.',
            'copy' => 'Flush aluminium windows need a clearer distinction from standard aluminium casements. The important customer point is the flatter sash appearance, combined with aluminium strength, colour freedom and modern glazing.',
            'specs' => [
                ['label' => 'Appearance', 'value' => 'Flush sash line for a flatter, more architectural aluminium finish'],
                ['label' => 'System route', 'value' => 'Sheerline aluminium profiles specified around opening style and sightline target'],
                ['label' => 'Thermal design', 'value' => 'Thermally broken frame and modern insulated glass unit'],
                ['label' => 'Security', 'value' => 'Locking, glass and hardware selected around the final security requirement'],
            ],
            'choices' => ['Contemporary or softer heritage colour palettes', 'RAL, matt, gloss and textured finish conversations', 'Obscure, acoustic or laminated glass', 'Handle finish coordination'],
        ],
        'heritage-windows' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Classic', $thermlock_badge, 'Steel-look styling'],
            'heading' => 'Sheerline Classic heritage windows for steel-look projects.',
            'copy' => 'Heritage aluminium windows should clearly explain steel-look styling without suggesting they are original steel replacements in every scenario. The useful details are glazing bars, slim sightlines, beadless construction, colour and security route.',
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
            'badges' => ['Sheerline Prestige', $thermlock_badge, '1.0 W/m2K option'],
            'heading' => 'Sheerline Prestige bifold doors with configuration detail up front.',
            'copy' => 'Bifold pages work best when customers can understand pane count, traffic doors, threshold choice, sash weight, security and how the doors will fold before they ask for a price.',
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
            'heading' => 'Slide and fold doors for customers who want more control than a standard bifold.',
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
            'copy' => 'A strong sliding-door page should explain why aluminium sliders are different from uPVC patio doors: bigger glass, slimmer interlocks, heavier sash capacity, smooth tracks and more architectural colour options.',
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
            'badges' => [$thermlock_badge, 'PAS 24 route', 'Low threshold option'],
            'heading' => 'Aluminium residential doors with window-matching options.',
            'copy' => 'Aluminium doors should be positioned as a robust, slim-framed alternative for front, rear, side and utility entrances, especially where the customer wants the door to match aluminium windows or sliders.',
            'specs' => [
                ['label' => 'Door styles', 'value' => 'Single doors, glazed entrance doors and paired/French-style aluminium sets'],
                ['label' => 'Security', 'value' => 'PAS 24 and Secured by Design routes with suitable glass, locks and hardware'],
                ['label' => 'Thresholds', 'value' => 'Standard, weathered and low-threshold conversations depending on exposure and access'],
                ['label' => 'Finish', 'value' => 'Powder-coated aluminium in RAL colours and selected textured finishes'],
            ],
            'choices' => ['Clear, obscure, laminated or decorative glass', 'Lever, pull and lock hardware options', 'Sidelights and toplights where the opening allows', 'Colour matched to aluminium windows'],
        ],
        'heritage-aluminium-doors' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline Classic', $thermlock_badge, 'SBD option'],
            'heading' => 'Classic heritage aluminium doors for internal or external steel-look openings.',
            'copy' => 'Heritage doors need more than a style label. Customers want to know about single doors, French doors, toplights, bar layouts, open-in/open-out options and whether the result can be specified securely for external use.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline Classic heritage-style aluminium door system'],
                ['label' => 'Layouts', 'value' => 'Single doors, French doors, sidelights, toplights and decorative bar patterns'],
                ['label' => 'Use', 'value' => 'External doors and selected internal-style projects, depending on specification'],
                ['label' => 'Security', 'value' => 'Secured by Design style upgrades available where the full doorset specification supports it'],
            ],
            'choices' => ['Black steel-look layouts', 'Softer heritage greys and RAL colours', 'Open-in or open-out options', 'Obscure, reeded or laminated glass'],
        ],
        'composite-doors' => [
            'systems' => [$systems['distinction']],
            'badges' => ['300+ styles', 'Any RAL option', '70mm Grandeur route'],
            'heading' => 'Distinction composite doors with style, colour and glass choice made clearer.',
            'copy' => 'Composite door customers compare design first, then security and construction. The page should make the range feel broad while still explaining GRP skins, foam-filled cores, water-resistant rails and why the final U-value depends on the complete doorset.',
            'specs' => [
                ['label' => 'Range', 'value' => 'Hundreds of door styles, including traditional, cottage, contemporary and glazed designs'],
                ['label' => 'Construction', 'value' => 'GRP door skin, insulated core and reinforced structural elements depending on chosen slab'],
                ['label' => 'Door depths', 'value' => 'Signature-style 44.5mm and Grandeur-style 70mm routes where available'],
                ['label' => 'Security', 'value' => 'Secure locks, cylinders, laminated/triple-glazed decorative glass and SBD routes by specification'],
            ],
            'choices' => ['Standard colours, premium colours and any RAL colour', 'Dual colour options', 'Decorative, obscure, triple-glazed and laminated glass', 'Long bar, lever, urn, knocker and letterplate hardware'],
        ],
        'upvc-doors' => [
            'systems' => [$systems['liniar']],
            'badges' => ['Liniar uPVC', $energyplus_badge, 'Multi-point locking'],
            'heading' => 'Liniar uPVC doors for practical front, rear and side entrances.',
            'copy' => 'uPVC doors should feel like a sensible, secure and affordable option, not a weaker version of composite. The page needs to explain panel/glass choices, locking, cylinders, hinges, thresholds and colour foils.',
            'specs' => [
                ['label' => 'System', 'value' => 'Liniar uPVC door profile options'],
                ['label' => 'Security', 'value' => 'Multi-point locking with anti-snap cylinder and hinge choices confirmed by specification'],
                ['label' => 'Design', 'value' => 'Full panel, half panel, glazed, side panel and obscure-glass combinations'],
                ['label' => 'Finish', 'value' => 'White, woodgrain foils and selected colours depending on system'],
            ],
            'choices' => ['Front, rear, side and utility doors', 'Sidelights and toplights', 'Low-threshold access conversations', 'Lever/lever or lever/pad hardware options'],
        ],
        'patio-doors' => [
            'systems' => [$systems['liniar']],
            'badges' => ['uPVC slider', $energyplus_badge, 'Space-saving'],
            'heading' => 'uPVC patio doors, separate from aluminium sliders.',
            'copy' => 'Patio doors are the value-led sliding option for garden access. The page should make the difference from aluminium sliding doors clear: uPVC frame, practical track, up to four-pane layouts and reliable everyday security.',
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
            'copy' => 'French doors are familiar, but the important buying details are open-in/open-out, flying mullion, threshold, security, Georgian bars and whether the door is being used as a main route or occasional garden opening.',
            'specs' => [
                ['label' => 'System route', 'value' => 'Liniar uPVC French door profiles, including ModLok style reinforcement options where specified'],
                ['label' => 'Opening', 'value' => 'Open-in or open-out configurations depending on space and exposure'],
                ['label' => 'Thresholds', 'value' => 'Weathered, low and Part M style access threshold conversations'],
                ['label' => 'Security', 'value' => 'Multi-point locking with PAS 24, SBD and Part Q routes by specification'],
            ],
            'choices' => ['Full glass or panel/glass combinations', 'Georgian or astragal bars', 'Obscure, toughened or laminated glass', 'Door handle and hinge finishes'],
        ],
        'roof-lanterns' => [
            'systems' => [$systems['sheerline']],
            'badges' => ['Sheerline S1', $thermlock_badge, 'SheerVent option'],
            'heading' => 'Sheerline S1 roof lanterns with size, glass and ventilation detail.',
            'copy' => 'A roof lantern page should help customers understand daylight, overheating, roof opening size, tie bars, glass choice and ventilation before the survey.',
            'specs' => [
                ['label' => 'System', 'value' => 'Sheerline S1 aluminium roof lantern'],
                ['label' => 'Sizes', 'value' => 'Large lantern sizes possible, with final span and structural needs confirmed by survey'],
                ['label' => 'Glazing', 'value' => '28mm glazing routes, solar-control, acoustic and toughened glass options'],
                ['label' => 'Ventilation', 'value' => 'SheerVent automated vent and rain sensor options where suitable'],
            ],
            'choices' => ['Two-way, three-way, square and rectangular lantern styles', 'RAL colours inside and outside', 'Solar-control glass for south-facing roofs', 'Security glazing and anti-tamper details'],
        ],
        'roofline' => [
            'systems' => [$systems['liniar']],
            'badges' => ['5m boards', 'Low maintenance', 'Ventilation details'],
            'heading' => 'Liniar roofline details for fascias, soffits and guttering.',
            'copy' => 'Roofline copy should explain practical protection: board thickness, lengths, trims, ventilation, gutter runs, corners, finials and colour matching to the wider exterior.',
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
            'copy' => 'Integral blinds need a more technical explanation than standard blinds because the blind is part of the sealed glass unit. Customers need to know about cavity size, glass make-up, controls, colour, maximum blind size and warranty differences.',
            'specs' => [
                ['label' => 'Glass unit', 'value' => 'NTB 24/28 style cavity routes with Low-E, toughened and argon-filled glass options'],
                ['label' => 'Controls', 'value' => 'Magnetic manual control or electric remote/battery options'],
                ['label' => 'Testing', 'value' => 'Cycle-tested blind mechanisms, with final warranty depending on control type'],
                ['label' => 'Colours', 'value' => 'Standard blind colours with RAL conversations where available'],
            ],
            'choices' => ['Tilt-only or lift-and-tilt blinds depending on size', 'Sliding doors, bifolds, windows and replacement glass units', 'White, grey, black and neutral blind colours', 'Electric charging and remote-control options'],
        ],
        'double-glazing-replacement' => [
            'badges' => ['Low-E glass', 'Argon option', 'Safety glass checked'],
            'heading' => 'Replacement glass units specified around the existing frame.',
            'copy' => 'This service page should explain that the glass is made to measure: glass type, spacer, safety requirements, toughened or laminated needs, acoustic/solar options and whether the existing frame is worth keeping.',
            'specs' => [
                ['label' => 'Glass types', 'value' => 'Low-E, argon-filled, toughened, laminated, acoustic and solar-control options where suitable'],
                ['label' => 'Spacer', 'value' => 'Spacer bar and unit thickness matched to the existing frame'],
                ['label' => 'Safety', 'value' => 'Critical locations checked for toughened or laminated safety glass'],
                ['label' => 'Best for', 'value' => 'Misted, blown, cracked or failed sealed units where frames remain sound'],
            ],
            'choices' => ['Like-for-like replacement glass', 'Obscure glass upgrades', 'Pet-flap apertures in new sealed units', 'Integral blind units where suitable'],
        ],
        'secondary-glazing' => [
            'badges' => ['Acoustic improvement', 'Internal aluminium frame', 'RAL colour'],
            'heading' => 'Secondary glazing options for retained windows.',
            'copy' => 'Secondary glazing needs to explain configuration more clearly than a normal window page: sliding, hinged, fixed, lift-out, reveal depth, shutters, handles, condensation and air-gap performance.',
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
            'heading' => 'Repair information that helps customers decide before replacing.',
            'copy' => 'The repairs page should be direct: list common faults, explain diagnosis and be honest that parts availability and frame condition decide whether repair or replacement is sensible.',
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
            'heading' => 'Pet flap fitting explained before the glass is ordered.',
            'copy' => 'Pet flap pages should prevent the most common confusion: existing toughened double glazing cannot simply be cut on site. A new sealed unit or suitable panel is normally made for the flap.',
            'specs' => [
                ['label' => 'Glass fitting', 'value' => 'A new sealed glass unit is made with the correct aperture for the chosen flap'],
                ['label' => 'Panel fitting', 'value' => 'Suitable uPVC door panels can often accept a flap after material and position checks'],
                ['label' => 'Flap types', 'value' => 'Manual, lockable and microchip-controlled options'],
                ['label' => 'Survey checks', 'value' => 'Pet size, flap height, glass type, door style and route outside'],
            ],
            'choices' => ['Cat flaps and selected dog flap sizes', 'Clear or obscure replacement glass', 'Microchip access control', 'Weather and security positioning advice'],
        ],
    ];

    return array_replace_recursive($default, $data[$slug] ?? []);
}
