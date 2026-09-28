<?php
/** Product decisions for the town landing pages. Facts, not spun town copy. */
if (! defined('ABSPATH')) {
    exit;
}

function fenster_location_editorial(): array
{
    // Keep these aligned with the main product pages. No invented local jobs,
    // performance figures, prices or manufacturer options belong in this map.
    return [
        'double-glazing' => [
            'lead' => 'Replacement windows, new doors or just the glass. We help you work out what your home needs, price the choices and fit the finished job with our own team.',
            'heading' => 'Start with what you want to change.',
            'decisions' => [
                ['New windows', 'Choose how each room opens and ventilates first. Casement, flush and sliding sash windows offer different frame lines and opening styles; uPVC and aluminium give you different finishes.', 'windows-milton-keynes'],
                ['New doors', 'A front entrance needs a different layout from a wide garden opening. Compare composite entrance doors, paired French doors, bifolds and sliding doors around the space you use.', 'doors-milton-keynes'],
                ['Replacement glass', 'If your frames are sound and the glass has misted between the panes, we can assess the sealed units on their own. Send a photograph of the whole window and a close-up of the glass.', 'double-glazing-replacement'],
            ],
            'question' => 'Can you replace the glass and keep my existing frames?',
            'answer' => 'We can replace sealed glass units in suitable existing frames. Send us photographs and approximate sizes so we can check the frame condition and identify the glass. For handles, hinges or locks, our repairs team can advise separately.',
            'related' => ['casement-windows', 'flush-casement-windows', 'composite-doors', 'aluminium-bifold-doors'],
        ],
        'casement-windows' => [
            'lead' => 'Liniar uPVC casement windows, made to your sizes. Mix fixed panes, side openers and top openers, then choose the colour, glass and handles for each room.',
            'heading' => 'Choose the opening before the finish.',
            'decisions' => [
                ['Room-by-room openings', 'A fixed pane keeps the view open. A side or top opener provides ventilation. We check handle reach, outside clearance and the layout of adjoining panes.', 'casement-windows'],
                ['Colour and handles', 'Compare white and foiled finishes with the S2 Signature handle range. Swatches come to your consultation so you can see the finish against your own brickwork.', 'colour-options'],
                ['Glass and privacy', 'Choose clear glass for the view or obscured glass where you need privacy. We check ventilation and the glazing specification as part of your window order.', 'obscured-glass'],
            ],
            'question' => 'Can I mix fixed panes and opening windows?',
            'answer' => 'Yes. A casement frame can combine fixed panes with top or side openers. We help choose the layout for ventilation, handle access and the appearance of the elevation, then confirm the dimensions at technical survey.',
            'related' => ['flush-casement-windows', 'tilt-turn-windows', 'french-casement-windows'],
        ],
        'flush-casement-windows' => [
            'lead' => 'uPVC windows with the opening sash sitting flush with the outer frame. Choose the frame colour, glazing bars and handles to suit the proportions of your home.',
            'heading' => 'The flat frame line is the starting point.',
            'decisions' => [
                ['Flush appearance', 'The sash closes level with the outside frame. Look at the whole elevation when choosing where openers and fixed panes sit.', 'flush-casement-windows'],
                ['Colour and hardware', 'White, coloured and timber-effect foils change the appearance of the frame. Compare them with handle finishes using actual samples.', 'colour-options'],
                ['Glazing bars', 'Bars divide the glass visually. Their position should follow the proportions of your windows and any adjoining windows you are keeping.', 'windows-milton-keynes'],
            ],
            'question' => 'What is the difference between flush and standard casements?',
            'answer' => 'A flush sash closes level with the outer frame on the outside. A standard casement sash projects from it. Both open on hinges; the choice changes the frame lines you see from the street.',
            'related' => ['casement-windows', 'aluminium-flush-windows', 'sliding-sash-windows'],
        ],
        'sliding-sash-windows' => [
            'lead' => 'Roseview sliding sash windows with vertical opening and traditional proportions. Compare the sash models, meeting rails, horns and furniture before choosing your finish.',
            'heading' => 'Compare the details at eye level.',
            'decisions' => [
                ['Model and proportions', 'The Roseview models differ in their frame detailing. Compare the meeting rail, joints and sash horns on the main product page, then see the samples in person.', 'sliding-sash-windows'],
                ['Bars and furniture', 'Choose glazing-bar positions and sash furniture together. The result should work with the size of the opening and the other windows on the elevation.', 'sliding-sash-windows'],
                ['Colour and glass', 'Look at finishes in daylight and tell us which rooms need privacy glass. Where an existing appearance must be retained, bring the relevant requirements to the consultation.', 'obscured-glass'],
            ],
            'question' => 'Can replacement sash windows follow my existing window layout?',
            'answer' => 'We can review the proportions, glazing-bar layout, horns and furniture against photographs of your existing windows. Bring any property-specific requirements with you so the proposed specification can be checked before ordering.',
            'related' => ['flush-casement-windows', 'secondary-glazing', 'heritage-windows'],
        ],
        'french-casement-windows' => [
            'lead' => 'Paired opening sashes with a central mullion that moves with the window. Open both sides for a clear aperture, with uPVC and aluminium options to compare.',
            'heading' => 'Two opening sashes, one clear opening.',
            'decisions' => [
                ['The opening', 'The centre section travels with one sash when both sides open. We check the usable aperture and the space outside for the sashes to swing.', 'french-casement-windows'],
                ['Frame material', 'French casement describes the arrangement. Compare the compatible uPVC and aluminium systems on the configuration page before choosing a finish.', 'french-casement-windows'],
                ['Everyday access', 'Handle positions and the order in which the sashes open affect daily use. Try the mechanism and explain how you want to ventilate the room.', 'book-a-consultation'],
            ],
            'question' => 'Is French casement a material or a window layout?',
            'answer' => 'It is a layout: two side-hung sashes open without a fixed centre mullion remaining in the aperture. We offer this arrangement in compatible uPVC and aluminium systems; the main configuration page shows the choices.',
            'related' => ['casement-windows', 'aluminium-windows', 'flush-casement-windows'],
        ],
        'tilt-turn-windows' => [
            'lead' => 'uPVC windows that tilt inward for ventilation and turn inward for opening and cleaning. The handle operates both modes, with the room layout checked before manufacture.',
            'heading' => 'Allow room for both opening modes.',
            'decisions' => [
                ['Tilt ventilation', 'The sash tilts inward from the top for ventilation. We help you choose handle positions that are comfortable to reach.', 'tilt-turn-windows'],
                ['Inward opening', 'Turning the sash brings the outside face within reach. Curtains, blinds, taps and furniture need space around the full swing.', 'tilt-turn-windows'],
                ['Finish and privacy', 'Choose the frame finish, handle and glass for the room. Bathroom privacy and bedroom ventilation can be considered in the same order.', 'obscured-glass'],
            ],
            'question' => 'Will a tilt and turn window open into the room?',
            'answer' => 'Yes. Both the tilt and turn modes open inward. We check the sash swing against curtains, blinds, taps and furniture at survey so you can use both modes.',
            'related' => ['casement-windows', 'flush-casement-windows', 'windows-milton-keynes'],
        ],
        'bow-bay-windows' => [
            'lead' => 'Replacement bow and bay windows, specified around the shape of the existing opening. Compare the frame systems, pane layout and opening positions as one complete elevation.',
            'heading' => 'Keep the shape of the bay in the discussion.',
            'decisions' => [
                ['Shape and projection', 'The angles, projection and support are part of the survey. Photographs of the full bay, inside and outside, help us understand the job from the start.', 'bow-bay-windows'],
                ['Window system', 'Bow and bay describes the arrangement. The main configuration page shows the compatible window systems and their different frame details.', 'bow-bay-windows'],
                ['Openers and finishes', 'Decide which panes need to open and how you will reach the handles. We check the cill and internal finishing alongside the frame colour and glass.', 'windows-milton-keynes'],
            ],
            'question' => 'Can you keep the shape of my existing bay?',
            'answer' => 'We survey the existing angles, projection, support and opening sizes before manufacture. Send photographs of the whole bay from inside and outside so we can discuss the replacement layout and finishing details.',
            'related' => ['casement-windows', 'sliding-sash-windows', 'aluminium-windows'],
        ],
        'aluminium-windows' => [
            'lead' => 'Sheerline aluminium casement windows with slim frames and a powder-coated finish. Choose the pane layout, openers and colour around the view and the rooms you use.',
            'heading' => 'Frame lines, opening positions and colour.',
            'decisions' => [
                ['Pane layout', 'Fixed panes and opening casements have different frame lines. Compare the complete window arrangement rather than a single profile measurement.', 'aluminium-windows'],
                ['Powder-coated finish', 'Choose the aluminium colour using physical samples. Think about the outside elevation and how the frame looks from inside the room.', 'colour-options'],
                ['Glass specification', 'Tell us which rooms need privacy and how much sun reaches the glass. We check the glazing, ventilation and opening sizes before manufacture.', 'obscured-glass'],
            ],
            'question' => 'Can aluminium windows match new aluminium doors?',
            'answer' => 'We can review the frame colour and product systems together so windows and doors form one specification. Physical colour samples help you compare the finish before you order.',
            'related' => ['aluminium-flush-windows', 'heritage-windows', 'aluminium-doors'],
        ],
        'aluminium-flush-windows' => [
            'lead' => 'Flush aluminium windows with the opening sash closing level with the frame. Compare the sightlines, finish and pane layout against the windows you are replacing.',
            'heading' => 'A flush sash changes the outside frame line.',
            'decisions' => [
                ['Flush detail', 'Look at the whole window, including its opening sashes. Fixed panes and openers have different sightlines, so one minimum figure does not describe every layout.', 'aluminium-flush-windows'],
                ['Colour choice', 'Use powder-coat samples to compare the frame with your brick, stone or render. We can consider adjoining doors in the same specification.', 'colour-options'],
                ['Survey and finishing', 'We check how the frame sits in the reveal, the opening clearances and the cill detail before anything is made.', 'book-a-consultation'],
            ],
            'question' => 'Do all panes have the same sightline?',
            'answer' => 'No. A fixed pane and an opening casement use different sections. We help compare the sightlines of your actual layout so the finished elevation has the proportions you expect.',
            'related' => ['aluminium-windows', 'flush-casement-windows', 'heritage-windows'],
        ],
        'heritage-windows' => [
            'lead' => 'Steel-look aluminium windows with slim frames and glazing bars. Plan the bar positions, opening sections and colour around the proportions of your home.',
            'heading' => 'The bar layout should follow the building.',
            'decisions' => [
                ['Glazing bars', 'Bring a photograph of the existing elevation. We can compare the positions and proportions of the bars across adjoining windows.', 'heritage-windows'],
                ['Opening sections', 'Decide which panes need to open for ventilation and where the handles will sit. The layout is confirmed for each opening at survey.', 'heritage-windows'],
                ['Matching doors', 'Heritage aluminium doors can be considered alongside the windows. Compare the frame colour and bar arrangement across both.', 'heritage-aluminium-doors'],
            ],
            'question' => 'Are heritage windows made from steel?',
            'answer' => 'These windows are aluminium, with slim frames and glazing bars that give a steel-look appearance. We can review photographs of existing windows and any property-specific requirements when discussing replacements.',
            'related' => ['heritage-aluminium-doors', 'aluminium-windows', 'secondary-glazing'],
        ],
        'aluminium-bifold-doors' => [
            'lead' => 'Aluminium bifold doors that fold back to open your home to the garden. Choose the panel arrangement, everyday access door and finish, then we survey the opening before manufacture.',
            'heading' => 'Decide how you will use the doors every day.',
            'decisions' => [
                ['Panel arrangement', 'Panel count and folding direction determine where the doors stack. Think about the furniture inside and the usable patio space outside.', 'aluminium-bifold-doors'],
                ['Everyday access', 'Some arrangements include a traffic door for going in and out without folding the whole set. We can show you which layouts allow it.', 'aluminium-bifold-doors'],
                ['Threshold and glass', 'Floor levels, external drainage and the threshold are surveyed together. Choose the frame colour and discuss glass and integral blinds while the specification is being prepared.', 'integral-blinds'],
            ],
            'question' => 'Can I use one bifold panel as an everyday door?',
            'answer' => 'Some panel arrangements include a traffic door that opens independently. The available layouts depend on the opening and panel configuration. Tell us how you use the garden access so we can show you suitable arrangements.',
            'related' => ['aluminium-sliding-doors', 'slide-fold-doors', 'integral-blinds'],
        ],
        'slide-fold-doors' => [
            'lead' => 'Aluminium slide and fold doors with panels that move individually. Open one panel for everyday access or move the set aside for a wider opening.',
            'heading' => 'Each panel moves on its own.',
            'decisions' => [
                ['Independent panels', 'The panels slide and turn individually rather than folding as a linked concertina. Try the movement at our Milton Keynes showroom.', 'slide-fold-doors'],
                ['Parking space', 'We check where the panels will gather and how the open doors relate to the room and patio. Bring a sketch or photograph of the full opening.', 'slide-fold-doors'],
                ['Finish and floor levels', 'Choose the powder-coated finish while we review the threshold, floor levels and glass. The technical survey confirms the manufacture dimensions.', 'colour-options'],
            ],
            'question' => 'How do slide and fold doors differ from bifolds?',
            'answer' => 'Slide and fold panels move independently along the track and turn at the end. Bifold panels are linked together and fold as a concertina. The showroom has a slide and fold display so you can feel the movement before deciding.',
            'related' => ['aluminium-bifold-doors', 'aluminium-sliding-doors', 'french-doors'],
        ],
        'aluminium-sliding-doors' => [
            'lead' => 'Sheerline aluminium sliding doors for broad panes and garden views. Compare the track layout, moving panels and handle operation before choosing your colour and glass.',
            'heading' => 'Choose the view and the clear opening together.',
            'decisions' => [
                ['Tracks and panels', 'A sliding panel moves behind another pane. The number of tracks and moving panels determines how much of the overall width opens.', 'aluminium-sliding-doors'],
                ['Lift and slide operation', 'The handle lifts the moving sash for sliding and lowers it into position when closed. Try the operation with a full-size sample.', 'aluminium-sliding-doors'],
                ['Threshold and finish', 'We survey the floor levels, drainage and access for installation. Colour samples help you compare the aluminium with the rest of the extension.', 'colour-options'],
            ],
            'question' => 'How much of a sliding door opening will be clear?',
            'answer' => 'It depends on the number of panels, the track arrangement and which panels move. Sliding panes overlap when open. We can compare configurations against your approximate opening width before technical survey.',
            'related' => ['aluminium-bifold-doors', 'slide-fold-doors', 'patio-doors'],
        ],
        'aluminium-doors' => [
            'lead' => 'Aluminium entrance doors with powder-coated frames, glass and panel choices. Plan the opening direction, threshold and hardware around the entrance you use each day.',
            'heading' => 'Specify the entrance as a complete doorset.',
            'decisions' => [
                ['Panel and glazing', 'Choose how much of the door is glazed and whether you want adjoining side panels. We can review privacy glass for overlooked entrances.', 'aluminium-doors'],
                ['Hardware', 'Compare handles, locking and hinge details on the main product page. The final hardware specification belongs with the door you order.', 'aluminium-doors'],
                ['Access and finish', 'Opening direction, clear width and threshold height affect daily use. We check them alongside the frame colour and the surrounding opening.', 'colour-options'],
            ],
            'question' => 'Can you include glazed panels beside the door?',
            'answer' => 'We can review a door with adjoining glazing as one entrance. Send a photograph of the whole opening and approximate dimensions so we can discuss the layout before survey.',
            'related' => ['composite-doors', 'heritage-aluminium-doors', 'aluminium-windows'],
        ],
        'heritage-aluminium-doors' => [
            'lead' => 'Steel-look aluminium doors and screens with slim glazing bars. Choose a single or paired opening, then plan the bar layout and side panels around the room.',
            'heading' => 'Make the doors and the screen one composition.',
            'decisions' => [
                ['Single or paired doors', 'Choose the opening around the space and how often you pass through it. The main page shows the available door arrangements.', 'heritage-aluminium-doors'],
                ['Bars and side panels', 'Align the bars across the doors and adjoining glass. We review the proportions using the full opening dimensions.', 'heritage-aluminium-doors'],
                ['Threshold and colour', 'Opening clearances and floor levels are checked at survey. Compare powder-coat samples and handles before the order is made.', 'colour-options'],
            ],
            'question' => 'Can the glazing bars line up across doors and side panels?',
            'answer' => 'We review the bar layout across the full opening when preparing the specification. The door arrangement, frame dimensions and any adjoining screens are considered together.',
            'related' => ['heritage-windows', 'aluminium-doors', 'french-doors'],
        ],
        'composite-doors' => [
            'lead' => 'Distinction composite front doors, fitted by our own team. Choose the door design, colour, decorative glass and furniture, with a price you can build online.',
            'heading' => 'Choose the door, then the details you touch.',
            'decisions' => [
                ['Door style and glass', 'Compare the door designs and their available glass layouts. Think about daylight in the hallway and privacy from the street.', 'composite-doors'],
                ['Colour and furniture', 'Choose the slab colour and coordinate the handle, letterplate and knocker. Physical samples help you judge the finish against your entrance.', 'composite-doors'],
                ['Frame and access', 'Tell us about side panels, a toplight or an access requirement. The threshold, opening direction and clear width are confirmed at technical survey.', 'book-a-consultation'],
            ],
            'question' => 'Can I design and price my composite door online?',
            'answer' => 'Yes. Our online tool lets you choose a door style, colour, glass and furniture and build a price. A free consultation uses the same software and price list, with colour swatches brought to your home.',
            'related' => ['aluminium-doors', 'upvc-doors', 'obscured-glass'],
        ],
        'upvc-doors' => [
            'lead' => 'uPVC doors for front, back and side entrances, with glazed and panelled options. Choose the opening direction, finish and glass around the way you use the entrance.',
            'heading' => 'Balance daylight, privacy and access.',
            'decisions' => [
                ['Glass and panels', 'Choose the balance of solid panel and glazing, then decide where obscured glass would be useful. Photographs help us match the existing opening.', 'upvc-doors'],
                ['Hardware and security', 'Compare handles and locking choices. Laminated glass and a three-star cylinder are available security upgrades to discuss with the door specification.', 'upvc-doors'],
                ['Finish and threshold', 'Use physical colour samples to compare the door with adjoining windows. We check floor levels and opening clearances before manufacture.', 'colour-options'],
            ],
            'question' => 'Can a new uPVC door match my existing windows?',
            'answer' => 'We can compare the available colours and foils with your existing frames using samples. Send photographs of the door and nearby windows when you enquire.',
            'related' => ['composite-doors', 'french-doors', 'patio-doors'],
        ],
        'patio-doors' => [
            'lead' => 'uPVC sliding patio doors that open along the frame, leaving the room and patio clear of a swinging door. Choose your pane layout, colour, handle and glass.',
            'heading' => 'Garden access without a door swing.',
            'decisions' => [
                ['Moving and fixed panes', 'Decide which side you want to open from and how the moving pane relates to the room. We check the full frame dimensions at survey.', 'patio-doors'],
                ['Handle and security', 'Compare the available handle finishes and locking specification on the main product page. Handle access matters when curtains or furniture sit beside the frame.', 'patio-doors'],
                ['Colour and glass', 'Coordinate the frame with nearby windows and discuss privacy glass or integral blinds while the glazing specification is being prepared.', 'integral-blinds'],
            ],
            'question' => 'Do sliding patio doors need space to swing open?',
            'answer' => 'The moving pane slides along the frame rather than swinging into the room or patio. You still need clear access to the handle and threshold, which we review with the layout.',
            'related' => ['aluminium-sliding-doors', 'french-doors', 'upvc-doors'],
        ],
        'french-doors' => [
            'lead' => 'Paired French doors for garden access, available in uPVC and aluminium. Compare the frame systems, opening direction and adjoining glass before choosing a finish.',
            'heading' => 'A paired opening, in the material you choose.',
            'decisions' => [
                ['Door arrangement', 'Choose how the doors open and which leaf you use first. We check the swing against the room, patio and nearby walls.', 'french-doors'],
                ['Frame system', 'French doors describe the paired layout. Compare compatible uPVC and aluminium systems for their frame detail, hardware and finish.', 'french-doors'],
                ['Adjoining glass', 'Side panels and toplights can be considered with the doors. We review the whole opening and the threshold as one specification.', 'book-a-consultation'],
            ],
            'question' => 'Are your French doors available in more than one material?',
            'answer' => 'Yes. French doors are a paired opening arrangement available in compatible uPVC and aluminium systems. The main configuration page compares the options so you can choose the frame style and finish.',
            'related' => ['upvc-doors', 'aluminium-doors', 'heritage-aluminium-doors'],
        ],
        'integral-blinds' => [
            'lead' => 'Notan blinds sealed inside the glass for privacy and daylight control. Send us the window or door details so we can check compatibility and quote for the units you need.',
            'heading' => 'Choose the blind with the glass unit.',
            'decisions' => [
                ['Sealed inside the glass', 'The blind sits between the panes. For an existing window or door, we assess a replacement sealed unit and the frame it needs to fit.', 'integral-blinds'],
                ['Controls and colours', 'Compare the blind colours and how the controls work. The main product page has an interactive demonstration of lifting and tilting the blind.', 'integral-blinds'],
                ['Compatibility', 'Send a photograph of the whole door or window, approximate glass sizes and any system details you have. We use those to check the options before quoting.', 'contact'],
            ],
            'question' => 'Can you add integral blinds to my existing windows?',
            'answer' => 'Integral blinds are supplied inside a sealed glass unit. We need to check whether a suitable replacement unit will fit your existing frames. Send photographs, approximate glass sizes and any window or door system details you have.',
            'related' => ['aluminium-bifold-doors', 'patio-doors', 'double-glazing-replacement'],
        ],
        'roof-lanterns' => [
            'lead' => 'S1 roof lanterns for flat-roof extensions and garden rooms. Plan the size, glass and frame colour with the roof opening and the way you use the space below.',
            'heading' => 'Choose the lantern around the room beneath it.',
            'decisions' => [
                ['Position and size', 'Think about the kitchen island, dining table and lighting below. We review the structural opening and upstand details with the roof design.', 'roof-lanterns'],
                ['Glass choice', 'The glazing affects daylight and solar gain. Tell us how much sun reaches the roof so we can discuss an appropriate glass specification.', 'roof-lanterns'],
                ['Frame and installation', 'Compare the frame colour inside and out. Access, the upstand and the roof finish are checked before the lantern is ordered.', 'book-a-consultation'],
            ],
            'question' => 'Should I choose a roof lantern or a flat rooflight?',
            'answer' => 'A lantern rises above the roof with an angled glazed structure; a flat rooflight has a flatter profile. The room layout, roof opening and appearance you want help determine the choice. We can review both with your drawings.',
            'related' => ['flat-rooflights', 'aluminium-bifold-doors', 'aluminium-sliding-doors'],
        ],
    ];
}

/** Curated media only, deduplicated after URL normalisation. */
function fenster_location_photo_key(string $src): string
{
    $path = fenster_theme_asset_path_from_url($src);
    // The product WebP and the case-study JPEG are exports of the same photo.
    // Reserve the scene, not just a filename, when the local case study renders.
    if (in_array(basename($path), ['sf-lb-closed-1200w.webp', 'cs-leighton-buzzard-slide-fold-closed.jpg'], true)) {
        return 'leighton-buzzard-slide-fold-closed';
    }
    return $path;
}

function fenster_location_images(string $product): array
{
    $media = (array) fenster_data('product_media.' . $product, []);
    $pool = (string) fenster_data('product_gallery_groups.' . $product, '');
    $candidates = array_merge([$media['hero'] ?? []], (array) ($media['gallery'] ?? []), (array) fenster_data('product_gallery_pools.' . $pool, []));
    $images = [];
    foreach ($candidates as $image) {
        $src = (string) ($image['src'] ?? '');
        if ($src === '') {
            continue;
        }
        $path = fenster_theme_asset_path_from_url($src);
        if ($path === '' || ! is_file($path)) {
            continue;
        }
        $key = realpath($path);
        if (! isset($images[$key])) {
            $images[$key] = ['src' => $src, 'alt' => (string) ($image['alt'] ?? '')];
        }
    }
    return array_values($images);
}

/** Responsive versions are generated from the existing photographs, never AI. */
function fenster_location_image_attrs(array $image, array $attrs = []): string
{
    $source = (string) ($image['src'] ?? '');
    $path = fenster_theme_asset_path_from_url($source);
    $relative = str_replace('\\', '/', substr($path, strlen(FENSTER_THEME_DIR)));
    $stem = substr(hash('sha256', $relative), 0, 12);
    $sources = [];
    foreach ([480, 960, 1600] as $width) {
        $file = '/assets/images/landing/' . $stem . '-' . $width . 'w.webp';
        if (is_file(FENSTER_THEME_DIR . $file)) {
            $sources[] = FENSTER_THEME_URI . $file . ' ' . $width . 'w';
        }
    }
    if ($sources !== []) {
        $attrs['srcset'] = implode(', ', $sources);
        $attrs['sizes'] = $attrs['sizes'] ?? '(max-width: 860px) calc(100vw - 32px), (max-width: 1200px) 50vw, 640px';
    }
    return fenster_image_attr_string($source, array_merge(['alt' => (string) ($image['alt'] ?? ''), 'loading' => 'lazy'], $attrs));
}
