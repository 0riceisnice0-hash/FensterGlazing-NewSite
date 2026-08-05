<?php
/**
 * Hardcoded site data.
 *
 * This theme intentionally avoids ACF/page-builder content. Put structured content here
 * until a section grows large enough to deserve its own data file.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_site_data(): array
{
    return [
        'brand' => [
            'name' => 'Fenster Glazing',
            'tagline' => 'Windows, doors, glazing, repairs and project support for homes and businesses.',
            'phone' => '01908 429200',
            'email' => 'info@fensterglazing.com',
            'address' => [
                '98 Alston Drive',
                'Bradwell Abbey',
                'Milton Keynes',
                'Buckinghamshire MK13 9HF',
            ],
            /* Two separate facts, kept apart because they are not the same
               opening time. `hours` is the combined line the footer prints;
               `showroom_hours` is the showroom on its own, for anywhere that is
               answering "when can I turn up". Owner instruction, 2026-08-02:
               a showroom opening-hours block must not carry the phone line. */
            'hours' => 'Monday to Friday, 8.30am to 5pm. Phone lines open 24/7.',
            'showroom_hours' => 'Monday to Friday, 8.30am to 5pm',
            // Fallback only. When the Places API is configured, the canonical
            // review and write-review URLs are built from the place ID in
            // inc/google-reviews.php. Never point these at a Google search
            // query: it sends customers to results, not the review panel.
            'google_reviews_url' => 'https://www.google.com/maps/place/Fenster+Glazing+-+Windows+%26+Doors+Showroom/@52.0467571,-0.7936423,17z',
            'trustpilot_url' => 'https://uk.trustpilot.com/review/fensterglazing.com',
            // Owner-verified fallback figures, used only when the live Google
            // rating is unavailable. Check against the profile quarterly.
            'google_rating' => 4.9,
            'google_review_count' => 133,
        ],
        'customer_reviews' => [
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Zak Jessup',
                'date' => '2025-06-12',
                'title' => 'Cannot recommend higher',
                'quote' => 'Cannot recommend higher! Nick and Perry were really helpful in getting my windows sorted ASAP.',
                'context' => 'Windows',
                'url' => '',
            ],
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Norman Cummings',
                'date' => '2025-06-10',
                'title' => 'Great workmen',
                'quote' => 'The best service ever, great workmen, very high standard and in the finish, excellent eye to detail.',
                'context' => 'Installation',
                'url' => '',
            ],
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Josh McMillan',
                'date' => '2025-06-01',
                'title' => 'Very happy',
                'quote' => 'Tom and Radu were great with our install. Very happy with the work done.',
                'context' => 'Installation',
                'url' => '',
            ],
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Nicole',
                'date' => '2025-05-20',
                'title' => 'Very pleased',
                'quote' => 'Shane and James fitted two sash windows for us at the front of our house and we are so pleased.',
                'context' => 'Sash windows',
                'url' => '',
            ],
            [
                'source' => 'Trustpilot',
                'rating' => '5',
                'author' => 'John Tillotson',
                'date' => '4 Nov 2025',
                'title' => 'First class throughout',
                'quote' => 'Clean, tidy - really good.',
                'context' => 'Large window replacement',
                'url' => 'https://uk.trustpilot.com/review/fensterglazing.com',
            ],
            [
                'source' => 'Trustpilot',
                'rating' => '5',
                'author' => 'Brigitta Lazar',
                'date' => '14 Nov 2025',
                'title' => 'Amazing job',
                'quote' => 'A great and quick job. Very efficient.',
                'context' => 'Installation team',
                'url' => 'https://uk.trustpilot.com/review/fensterglazing.com',
            ],
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Pete Dafters',
                'date' => '2025-05-15',
                'title' => 'Highly recommended',
                'quote' => 'I cannot recommend this company enough.',
                'context' => 'Bifold doors',
                'url' => '',
            ],
            [
                'source' => 'Google',
                'rating' => '5',
                'author' => 'Brigid Jordan',
                'date' => '2025-05-10',
                'title' => 'Everything went perfectly',
                'quote' => 'Everything went perfectly with our windows supplied and fitted.',
                'context' => 'Windows',
                'url' => '',
            ],
            [
                'source' => 'Trustpilot',
                'rating' => '5',
                'author' => 'Lisa',
                'date' => '7 Jan 2026',
                'title' => 'Quality local company',
                'quote' => 'Friendly, efficient and a quality installation.',
                'context' => 'French doors',
                'url' => 'https://uk.trustpilot.com/review/fensterglazing.com',
            ],
        ],
        'primary_nav_fallback' => [
            [
                'label' => 'Products',
                'url' => home_url('/windows-milton-keynes/'),
                'mega' => true,
                'columns' => [
                    [
                        'label' => 'Windows',
                        'url' => home_url('/windows-milton-keynes/'),
                        'items' => [
                            ['label' => 'Casement Windows', 'url' => home_url('/casement-windows/')],
                            ['label' => 'Flush Casement', 'url' => home_url('/flush-casement-windows/')],
                            ['label' => 'Sliding Sash', 'url' => home_url('/sliding-sash-windows/')],
                            ['label' => 'Tilt & Turn', 'url' => home_url('/tilt-turn-windows/')],
                            ['label' => 'Aluminium Windows', 'url' => home_url('/aluminium-windows/')],
                            ['label' => 'Aluminium Flush Windows', 'url' => home_url('/aluminium-flush-windows/')],
                            ['label' => 'Heritage Windows', 'url' => home_url('/heritage-windows/')],
                            ['label' => 'French Casement Windows', 'url' => home_url('/french-casement-windows/')],
                            ['label' => 'Bow and Bay Windows', 'url' => home_url('/bow-bay-windows/')],
                        ],
                    ],
                    [
                        'label' => 'Doors',
                        'url' => home_url('/doors-milton-keynes/'),
                        'items' => [
                            ['label' => 'Aluminium Bifold Doors', 'url' => home_url('/aluminium-bifold-doors/')],
                            ['label' => 'Slide & Fold Doors', 'url' => home_url('/slide-fold-doors/')],
                            ['label' => 'Aluminium Sliding Doors', 'url' => home_url('/aluminium-sliding-doors/')],
                            ['label' => 'Aluminium Doors', 'url' => home_url('/aluminium-doors/')],
                            ['label' => 'Heritage Aluminium Doors', 'url' => home_url('/heritage-aluminium-doors/')],
                            ['label' => 'Composite Doors', 'url' => home_url('/composite-doors/')],
                            ['label' => 'uPVC Doors', 'url' => home_url('/upvc-doors/')],
                            ['label' => 'Patio Doors', 'url' => home_url('/patio-doors/')],
                            ['label' => 'French Doors', 'url' => home_url('/french-doors/')],
                        ],
                    ],
                    [
                        'label' => 'Other Services',
                        'url' => home_url('/other-services/'),
                        'items' => [
                            ['label' => 'Roof Lanterns', 'url' => home_url('/roof-lanterns/')],
                            ['label' => 'Flat Rooflights', 'url' => home_url('/flat-rooflights/')],
                            ['label' => 'Roofline', 'url' => home_url('/roofline/')],
                            ['label' => 'Integral Blinds', 'url' => home_url('/integral-blinds/')],
                            ['label' => 'Replacement Glazing', 'url' => home_url('/double-glazing-replacement/')],
                            ['label' => 'Secondary Glazing', 'url' => home_url('/secondary-glazing/')],
                            ['label' => 'Cat & Dog Flaps', 'url' => home_url('/cat-and-dog-flaps/')],
                            ['label' => 'Repairs', 'url' => home_url('/window-and-door-repairs/')],
                        ],
                    ],
                ],
                'ctas' => [
                    [
                        'label' => 'Get an instant quote',
                        'badge' => 'Quick start',
                        'url' => home_url('/online-quote/'),
                        'copy' => 'Price windows and doors through the online quote tool.',
                    ],
                    [
                        'label' => 'Book a free consultation',
                        /* Was 'Free', which the label and the copy underneath both already
                           say. The badge earns its place by naming what you get. */
                        'badge' => 'Expert advice',
                        'variant' => 'accent',
                        'url' => home_url('/book-a-consultation/'),
                        'copy' => 'An expert comes to you, goes through the options and prices the job. The visit costs nothing.',
                    ],
                ],
            ],
            [
                'label' => 'Commercial',
                'url' => home_url('/commercial-glazing/'),
                'mega' => true,
                /*
                 * Same shape as the Products mega menu, so both run through the one
                 * renderer in inc/template-tags.php.
                 *
                 * Sectors holds one page. Healthcare is the only sector landing page on
                 * the site: a sweep of all 695 sitemap URLs on 2026-07-28 found nothing
                 * for education, offices, retail, leisure or industrial. There is real
                 * completed work in two more sectors though, at
                 * /case-studies/barn-hotel-windows-coventry/ and
                 * /case-studies/care-home-window-replacement/, so hospitality and care
                 * are the two sector pages that could be written with genuine proof
                 * rather than invented. Adding them fills this column without touching
                 * the renderer.
                 */
                'columns' => [
                    [
                        'label' => 'Services',
                        'url' => home_url('/commercial-glazing/'),
                        'items' => [
                            ['label' => 'Commercial Glazing', 'url' => home_url('/commercial-glazing/')],
                            ['label' => 'Commercial Windows and Doors', 'url' => home_url('/commercial-windows-and-doors/')],
                            ['label' => 'Curtain Walling', 'url' => home_url('/curtain-walling/')],
                            ['label' => 'Louvre Vents', 'url' => home_url('/louvre-vents/')],
                            ['label' => 'AOV Smoke Ventilation', 'url' => home_url('/automatic-opening-vents/')],
                            ['label' => 'Commercial Automation', 'url' => home_url('/commercial-automation/')],
                        ],
                    ],
                    [
                        'label' => 'Sectors',
                        'url' => home_url('/commercial-glazing/'),
                        'items' => [
                            ['label' => 'Healthcare', 'url' => home_url('/healthcare-construction/')],
                            ['label' => 'Education', 'url' => home_url('/school-and-education-glazing/')],
                            ['label' => 'Student Accommodation', 'url' => home_url('/student-accommodation-glazing/')],
                            ['label' => 'Hospitality', 'url' => home_url('/hotel-and-hospitality-glazing/')],
                            ['label' => 'Care Homes', 'url' => home_url('/care-home-glazing/')],
                            ['label' => 'Offices and Retail', 'url' => home_url('/office-and-retail-glazing/')],
                        ],
                    ],
                ],
                'ctas' => [
                    [
                        'label' => 'Send a commercial enquiry',
                        'badge' => 'Talk to us',
                        'variant' => 'accent',
                        'url' => home_url('/commercial-glazing/#commercial-enquiry'),
                        'copy' => 'Drawings, schedules and site details welcome. We will come back with next steps.',
                    ],
                    [
                        'label' => 'See our commercial projects',
                        'badge' => 'Our work',
                        'url' => home_url('/commercial-projects/'),
                        'copy' => 'Real buildings we have glazed, with the scope and the systems used.',
                    ],
                ],
            ],
            ['label' => 'About Us', 'url' => home_url('/about/')],
            ['label' => 'Contact', 'url' => home_url('/contact/')],
            ['label' => 'Instant Quote', 'url' => home_url('/online-quote/'), 'classes' => ['site-nav__quote']],
            ['label' => 'Free Consultation', 'url' => home_url('/book-a-consultation/'), 'classes' => ['site-nav__consultation']],
        ],
        'product_usps' => [
            'aluminium-bifold-doors' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Configuration', 'value' => 'Up to 7 panes'],
                ['label' => 'Sightlines', 'value' => 'Ultra slim'],
            ],
            'aluminium-windows' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Outer frame', 'value' => '72mm'],
            ],
            'aluminium-doors' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Performance', 'value' => 'Thermally efficient'],
                ['label' => 'Security', 'value' => 'PAS 24'],
            ],
            'aluminium-flush-windows' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Outer frame', 'value' => '80mm'],
            ],
            'heritage-windows' => [
                ['label' => 'U-value*', 'value' => '1.1 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Sightlines', 'value' => 'Ultra slim'],
            ],
            'heritage-aluminium-doors' => [
                ['label' => 'U-value', 'value' => '1.4 W/m²K'],
                ['label' => 'Sightlines', 'value' => '60.5mm'],
                ['label' => 'Colour choice', 'value' => '12 standard colours'],
                ['label' => 'Layouts', 'value' => 'Single or French'],
            ],
            'slide-fold-doors' => [
                ['label' => 'U-value', 'value' => '1.4 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Design', 'value' => 'Versatile'],
                ['label' => 'Security', 'value' => '10 point locking'],
            ],
            // Sheerline Prestige Lift & Slide published specification. Colour came off
            // this strip when the route gained the powder-coated colour section, so
            // the four tiles say something the rest of the page does not.
            'aluminium-sliding-doors' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Maximum opening', 'value' => '6.5m wide, 2.5m tall'],
                ['label' => 'Interlock', 'value' => '80mm or 52mm'],
                ['label' => 'Security', 'value' => 'Flush hook-locks, PAS 24'],
            ],
            // Collections match the WindowCAD door-style groups, not Distinction's
            // Signature/Contemporary split. See COMPOSITE-DOOR-REDESIGN.md.
            'composite-doors' => [
                ['label' => 'Collections', 'value' => 'Six to choose from'],
                ['label' => 'Door slab', 'value' => '44.5mm insulated GRP'],
                ['label' => 'Break-in guarantee', 'value' => '£5,000'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'integral-blinds' => [
                ['label' => 'Maintenance', 'value' => 'Maintenance-free'],
                ['label' => 'Colour choice', 'value' => '9 options'],
                ['label' => 'Controls', 'value' => 'Magnetic or electric'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'casement-windows' => [
                ['label' => 'U-value', 'value' => '0.95 W/m²K'],
                ['label' => 'Colour choice', 'value' => '16 options'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Security', 'value' => 'PAS 24'],
            ],
            'upvc-doors' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => '14 options'],
                ['label' => 'Design', 'value' => 'Fully customisable'],
                ['label' => 'Security', 'value' => 'Multi-point locking'],
            ],
            'flush-casement-windows' => [
                ['label' => 'U-value', 'value' => '1.2 W/m²K'],
                ['label' => 'Colour choice', 'value' => '16 options'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Style', 'value' => 'Traditional'],
            ],
            'patio-doors' => [
                ['label' => 'U-value', 'value' => '1.2 W/m²K'],
                ['label' => 'Colour choice', 'value' => '14 options'],
                ['label' => 'Design', 'value' => 'Space-saving'],
                ['label' => 'Configuration', 'value' => 'Up to 4 panes'],
            ],
            'tilt-turn-windows' => [
                ['label' => 'U-value*', 'value' => '0.95 W/m²K'],
                ['label' => 'Colour choice', 'value' => '16 options'],
                ['label' => 'Energy rating', 'value' => 'A++ rated'],
                ['label' => 'Opening style', 'value' => 'Highly versatile'],
            ],
            'sliding-sash-windows' => [
                ['label' => 'Energy rating', 'value' => 'A rated'],
                ['label' => 'Sash models', 'value' => '3 Rose options'],
                ['label' => 'Profile system', 'value' => 'Roseview'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'french-doors' => [
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Profile system', 'value' => 'Liniar'],
                ['label' => 'Security', 'value' => 'Multi-point locking'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'roof-lanterns' => [
                ['label' => 'Profile system', 'value' => 'Sheerline'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Glazing option', 'value' => 'Solar-control glass'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'roofline' => [
                ['label' => 'Material', 'value' => 'uPVC'],
                ['label' => 'Profile system', 'value' => 'Liniar'],
                ['label' => 'Fascia depth', 'value' => '20mm'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'double-glazing-replacement' => [
                ['label' => 'Glazing option', 'value' => 'Made-to-measure units'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Gas fill', 'value' => 'Argon'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'secondary-glazing' => [
                ['label' => 'U-value*', 'value' => 'From 1.8 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Full RAL range'],
                ['label' => 'Frame type', 'value' => 'Slim aluminium'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'window-and-door-repairs' => [
                ['label' => 'Service scope', 'value' => 'Windows & doors'],
                ['label' => 'Materials', 'value' => 'uPVC, aluminium, composite'],
                ['label' => 'Pricing', 'value' => 'Clear repair quotes'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            /* Two flap types, not three. The old strip listed "Manual, lockable,
               microchip" as if lockable were a separate model; the standard flap
               is the one that locks by hand. Owner correction, 2026-08-02. */
            'cat-and-dog-flaps' => [
                ['label' => 'Flap types', 'value' => 'Standard or microchip'],
                ['label' => 'Fitted into', 'value' => 'Glass or door panel'],
                ['label' => 'Glass route', 'value' => 'A new sealed unit'],
                ['label' => 'Approved installer', 'value' => 'SureFlap'],
            ],
        ],
        /* Both glazing figures per route, so the key-specification tile can show
           what the window actually does on the standard specification and what
           it reaches on the upgrade. Before this the strip printed one number
           and never said which glazing it was, so casement showed its triple
           figure while flush casement showed its double and the two looked
           comparable when they were not.

           `double` is what renders first, because that is the standard
           specification rather than the best case. `triple` absent is the
           signal that the system does not take it, and the tile then says
           "Double glazed" instead of offering a toggle. That is deliberate: it
           makes the incompatibility visible without writing a sentence about
           what is not included, which the owner ruled out on 2026-08-02.

           Sources: Sheerline publish 1.4 double and 1.0 triple across Prestige
           (1.1 on stepped sashes) and 1.4 / 1.1 on Classic, triple in certain
           styles only. Owner-confirmed 2026-08-03 that 0.95 is the figure for
           all Liniar triple and 1.2 the double. Liniar publish 1.3 double on
           tilt and turn; ours is the tighter claim and is deliberate.

           Not listed, and each for a reason. uPVC doors and patio doors are
           awaiting fabricator figures; uPVC doors currently shows a starred 1.0
           that conflicts with the 0.95 rule and must not be paired up until it
           is confirmed. Sliding sash is Roseview and takes no triple. Roof
           lanterns are 1.0 double but render no key-specification strip at all,
           so there is nowhere to put it yet. Configuration routes (French
           doors, French casement, bow and bay) stay absent on purpose: the
           glazing follows whichever system the pair or the bay is built from,
           so no single figure is true for the route. */
        /* `single_u_value_routes` was removed on 2026-08-05 and should not come
           back as a list. It named the routes whose key-specification strip
           printed one figure instead of two, starting with the Liniar pages on
           2026-08-04. The owner then extended that treatment to every strip, so
           a hand-kept list of "the ones we have converted" had nothing left to
           say and could only fall out of step with the figures below it.
           product-pulse.php now derives the whole treatment from this data: the
           lowest figure always, starred only where there are two figures for it
           to be the lowest of. Add a route here and it behaves correctly with no
           second edit. */
        'glazing_u_values' => [
            // Liniar EnergyPlus 70mm
            'casement-windows'        => ['double' => '1.2 W/m²K', 'triple' => '0.95 W/m²K'],
            'tilt-turn-windows'       => ['double' => '1.2 W/m²K', 'triple' => '0.95 W/m²K'],
            // 28mm IGU only, so no triple. Liniar's own specification confirms it.
            'flush-casement-windows'  => ['double' => '1.2 W/m²K'],
            // Sheerline Prestige
            'aluminium-windows'       => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-flush-windows' => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-doors'         => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-bifold-doors'  => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-sliding-doors' => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            // Sheerline Classic
            'heritage-windows'          => ['double' => '1.4 W/m²K', 'triple' => '1.1 W/m²K'],
            'heritage-aluminium-doors'  => ['double' => '1.4 W/m²K', 'triple' => '1.1 W/m²K'],
            // No triple, per the owner-confirmed exclusion list
            'slide-fold-doors'        => ['double' => '1.4 W/m²K'],
            /* Sheerline S1. Owner-confirmed 2026-08-03: the 1.0 is the double
               glazed figure, reached with Pilkington Activ Blue, which is
               standard on lanterns. It is not a triple figure, and it beats
               Sheerline's generic 1.4 double because of the glass rather than a
               third pane. Do not pair it with a triple value without confirming
               one. The owner first called it "blu-active"; the product is
               Pilkington Activ Blue, a self-cleaning solar control glass made
               for roof units, so that is the name the page uses. */
            'roof-lanterns'           => ['double' => '1.0 W/m²K'],
        ],
        /* The nine standard slat colours of the Notan magnetic integrated
           blind, which is the system Fenster supplies on /integral-blinds/.

           These are not invented and they are not eyedropped from a photo. On
           2026-08-03 the official brochure
           `notan.co.uk/wp-content/uploads/2024/05/Notan-Magnetic-Integrated-blinds.pdf`
           was downloaded and confirmed the range is nine, not the "11 standard
           colour choices" the Our Blinds page still claims. The names and the
           BY/RAL codes are transcribed from that brochure. Each `hex` is
           sampled from the centre of Notan's own swatch asset under
           `notan.co.uk/wp-content/uploads/2021/02/`, which carries an embedded
           sRGB IEC61966-2.1 profile, so the numbers are already in the space
           the browser paints in and need no conversion.

           Several of them will look wrong at a glance and are not. Notan's
           CREAM is a warm grey rather than a cream, and their ROSE GOLD is a
           greige rather than a pink. Both were checked twice, against the web
           swatch and against the printed brochure page, and they agree. Do not
           "correct" them towards what the name suggests. Neither has anything
           but a BY code, so the swatch is the only source there is.

           Superseded on 2026-08-04 by the owner's photograph of the physical
           slat sample card, which is a better source than either: real slats,
           in one frame, under one light. The card is under-exposed and the
           slats are glossy, so it is reliable for hue and for the relationship
           between colours but not for absolute lightness; the values below are
           its hues, exposure-corrected against the paper and anchored so White
           reads white and the two RAL entries keep their published values.
           Cream and Rose Gold moved most: Cream is a warm greige rather than
           the near-neutral the disc suggested, and Rose Gold is a champagne
           gold rather than a taupe.

           `glitter` marks the two that are visibly metallic-flake in the
           photograph, Metallic Silver and Rose Gold. It is a finish, not a
           colour, and the renderer and the swatches both read it.

           The card carries a `BY005` charcoal that the brochure does not list,
           and does not carry `BY012` White/Anthracite, which the brochure
           does. Unresolved: BY005 is not added here because there is no
           published name for it, and BY012 is kept because the brochure is the
           published range. Worth asking Notan which is current.

           The two RAL entries are the exception and do not come from the
           swatches. RAL 7016 is a published standard, Notan cite the code
           themselves, and the standard is #383E42, a grey. Their swatch disc
           reads #1A1C1B, which is all but black and is almost certainly a
           reproduction problem. The owner describes the colour as grey, which
           agrees with the standard and not with the disc, so the standard
           wins. Where a colour carries a RAL code, prefer the code.

           WHITE/ANTHRACITE BY012 is the only two-sided slat: white on the room
           face, anthracite on the outward face. `reverse` exists for that one
           reason and the visualiser uses it to paint the back of a slat seen
           through the gap. Leave `reverse` unset on the other eight; the
           renderer treats absent as "same colour both sides", which is true.

           BY012 is not a colour of its own. It is the same two paints as
           BY001 White and RAL7016 Anthracite Grey, one on each face, which is
           how the owner describes it. Its two values must therefore stay equal
           to those two entries: change White or Anthracite and change this to
           match, or the same paint gets drawn two ways on one page.

           Deliberately not stored here: a slat width. Notan publish the 30mm
           profile that houses the mechanism, not the slat dimension, so the
           renderer assumes the standard integral-blind 12.5mm slat for
           geometry only and no figure is printed on the page. If Notan confirm
           a width it can be added and shown; until then it must not be. */
        'notan_blind_colours' => [
            ['key' => 'white',            'name' => 'White',            'code' => 'BY001',   'hex' => '#EDEFEF'],
            ['key' => 'cream',            'name' => 'Cream',            'code' => 'BY010',   'hex' => '#B3AD96'],
            ['key' => 'rose-gold',        'name' => 'Rose Gold',        'code' => 'BY014',   'hex' => '#CFBE9C', 'glitter' => true],
            ['key' => 'anthracite',       'name' => 'Anthracite Grey',  'code' => 'RAL7016', 'hex' => '#383E42'],
            ['key' => 'brown',            'name' => 'Brown',            'code' => 'BY006',   'hex' => '#4A3524'],
            ['key' => 'dark-brown',       'name' => 'Dark Brown',       'code' => 'BY007',   'hex' => '#2E2724'],
            ['key' => 'metallic-silver',  'name' => 'Metallic Silver',  'code' => 'BY004',   'hex' => '#B8BCC0', 'metallic' => true, 'glitter' => true],
            // Same two paints as BY001 and RAL7016 above. Keep all four in step.
            ['key' => 'white-anthracite', 'name' => 'White/Anthracite', 'code' => 'BY012',   'hex' => '#EDEFEF', 'reverse' => '#383E42'],
            ['key' => 'black',            'name' => 'Black',            'code' => 'RAL9005', 'hex' => '#0D0D0F'],
        ],
        'product_media' => [
            'aluminium-bifold-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-exterior.jpg', 'alt' => 'Anthracite aluminium bifold doors fitted to a brick home'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-exterior.jpg', 'alt' => 'Anthracite aluminium bifold doors fitted to a brick home'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Aluminium-Bifold-Doors-Flitwick-8.jpg', 'alt' => 'Grey aluminium bifold doors across a rear extension'],
                ],
            ],
            'aluminium-flush-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/aluminium-flush-open-1200w.webp', 'alt' => 'Grey aluminium flush windows opened outwards on a rendered wall'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Flush aluminium window frame detail'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Aluminium windows installed on a coastal home'],
                ],
            ],
            'aluminium-sliding-doors' => [
                // Owner instruction, 2026-08-02: lead on the big, light,
                // aspirational shot. The brick elevation that was here is now
                // reused further down, in the mosaic.
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-3-pane-interior-1600w.webp', 'alt' => 'Three pane aluminium sliding door framing a lake and mountain view'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-open-valley-1400w.webp', 'alt' => 'Aluminium sliding door open from a bright room onto a deck and open countryside'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-timber-clad-1200w.webp', 'alt' => 'Run of aluminium sliding doors along a timber clad garden room'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-handle-900w.webp', 'alt' => 'Slim handle and flush hook lock on an aluminium sliding door'],
                ],
            ],
            'cat-and-dog-flaps' => [
                /* Was showing roofline fascia and soffit boards, which belong to
                   a different product entirely, plus a sealed-unit sample. These
                   are real Fenster pet-flap installs from the Marketing image
                   bank, added 2026-07-29. */
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-cat-through-flap.webp', 'alt' => 'Black cat coming out through a white pet flap fitted into a glazed door'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-cat-at-the-flap.webp', 'alt' => 'Black cat looking out through a white pet flap fitted into a sealed glass unit'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-round-in-door.webp', 'alt' => 'Clear round pet flap in a glazed door beside a brick wall'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-round-glass-closeup.webp', 'alt' => 'Clear round pet flap in a glazed door, seen close up from outside'],
                ],
            ],
            'roofline' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-fascia.jpg', 'alt' => 'White fascia and soffit boards on a tiled roofline'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-fascia.jpg', 'alt' => 'White fascia and soffit boards on a tiled roofline'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-soffit.jpg', 'alt' => 'Soffit and fascia detail beneath a roof overhang'],
                ],
            ],
            'double-glazing-replacement' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed window unit showing the sealed glass edge'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed window unit showing the sealed glass edge'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'uPVC window opening detail with double glazing'],
                ],
            ],
            'double-glazing' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'New double glazed windows and bifold doors on a modern brick home'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'New double glazed windows and bifold doors on a modern brick home'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed unit showing the sealed glass construction'],
                ],
            ],
            'casement-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-stone-cottage-1600w.webp', 'alt' => 'Grey uPVC casement windows in a stone elevation'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-open-brick-1400w.webp', 'alt' => 'White uPVC casement windows opened outwards on a brick house'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-handle-detail-1400w.webp', 'alt' => 'Casement window opened on its hinges with the handle and gearing visible'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-sill-interior-1200w.webp', 'alt' => 'White casement window and sill seen from inside a room'],
                ],
            ],
            'flush-casement-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-stone-elevation-1600w.webp', 'alt' => 'Anthracite flush casement windows on a rendered and stone elevation'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-bay-brick-1400w.webp', 'alt' => 'White flush casement bay window on a tile hung house'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-grey-interior-1400w.webp', 'alt' => 'Three pane white flush casement window seen from inside'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-dual-colour-closeup-1200w.webp', 'alt' => 'Flush casement window with a black outer frame and white sashes'],
                ],
            ],
            'sliding-sash-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/hero/roseview-sash-bay-1920w.webp', 'alt' => 'White Roseview sliding sash bay window fitted to a red-brick home'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-sliding-sash-window.jpg', 'alt' => 'White sliding sash window with Georgian bars'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Sash-horn-astragal.jpeg', 'alt' => 'Sash horn and astragal glazing bar detail'],
                ],
            ],
            'french-casement-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/imported/French-Casement-Windows-Aylesbury-1.jpg', 'alt' => 'White French casement window opened wide from the centre with no mullion in the way'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/french-casement/french-casement-bedroom-1400w.webp', 'alt' => 'White French casement window in a bedroom with the two handles meeting at the centre'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-opening.jpeg', 'alt' => 'French casement window with both sashes open and a clear unobstructed opening'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-mullion.jpeg', 'alt' => 'Mullion detail on a French casement window frame'],
                ],
            ],
            'tilt-turn-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/tilt-turn/tilt-turn-brick-1600w.webp', 'alt' => 'Grey tilt and turn windows on a red brick elevation, one tilted open at the top'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt__Turn_14.jpg', 'alt' => 'Tilt and turn windows in a living room with roman blinds'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-1.jpeg', 'alt' => 'Tilt and turn window tilted inwards at the top for background ventilation'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-2.jpeg', 'alt' => 'Tilt and turn hardware shown holding the sash in the tilt position'],
                ],
            ],
            'bow-bay-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/imported/bay-window.jpg', 'alt' => 'White uPVC bay window with leaded glazing on a red brick house'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/bow-bay/bay-white-brick-dusk-1600w.webp', 'alt' => 'White bay window with Georgian bars on a brick and render home'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_10.jpg', 'alt' => 'Curved white uPVC bow window on a red brick wall'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_02.jpg', 'alt' => 'Golden oak bow window curving out from a light brick elevation'],
                ],
            ],
            'aluminium-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/aluminium-windows-black-house-1600w.webp', 'alt' => 'Black aluminium windows across the front of a modern brick and render house'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/aluminium-windows-card-1000w.webp', 'alt' => 'Black aluminium windows in a rendered and brick gable'],
                'gallery' => [
                    /* The only photograph of a Fenster aluminium install in the
                       image bank. PHOTO-CHECKLIST listed 'aluminium windows on a
                       local home' as a standing gap; this closes it. */
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/aluminium-window-grey-stone.webp', 'alt' => 'Grey aluminium window in a stone elevation, fitted on a local home'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Slim aluminium windows installed on a coastal property'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Aluminium window frame profile detail'],
                ],
            ],
            'heritage-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', 'alt' => 'Heritage style aluminium windows on a traditional property'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/imported/C08-Classic-Windows-Heritage-Style-Anthracite-2048x1366-1.jpg', 'alt' => 'Steel-look heritage aluminium windows seen from inside a living room'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', 'alt' => 'Heritage style aluminium windows on a traditional property'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Slim heritage glazing bar detail'],
                ],
            ],
            'slide-fold-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/neutral-slide-fold-doors.jpg', 'alt' => 'Closed slide and fold doors across a wide opening'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/imported/Slide-Fold.png', 'alt' => 'Anthracite slide and fold doors across the front of a garden room'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/neutral-slide-fold-doors.jpg', 'alt' => 'Closed slide and fold doors across a wide opening'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/neutral-slide-fold-doors-open.jpg', 'alt' => 'Slide and fold doors partly opened to the garden'],
                ],
            ],
            'aluminium-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-door.jpg', 'alt' => 'Aluminium entrance door opened to a garden view'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/imported/aluminium-doors-northampton-2-1.jpg', 'alt' => 'Sage green aluminium entrance door with a full-height bar handle and a glazed side screen'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-door.jpg', 'alt' => 'Aluminium entrance door opened to a garden view'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-door.jpg', 'alt' => 'Steel-look aluminium door in a kitchen'],
                ],
            ],
            'heritage-aluminium-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-door-kitchen-1600w.webp', 'alt' => 'Steel-look heritage aluminium door and screen in a green kitchen'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-brick-1400w.webp', 'alt' => 'Black heritage aluminium French doors on a red brick courtyard'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-door-kitchen-1600w.webp', 'alt' => 'Steel-look heritage aluminium door and screen in a green kitchen'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-brick-1400w.webp', 'alt' => 'Black heritage aluminium French doors on a red brick courtyard'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-open-1400w.webp', 'alt' => 'Heritage aluminium French doors opened into a living room'],
                ],
            ],
            'upvc-doors' => [
                /* Real Fenster installs, from the Marketing image bank on
                   2026-07-29. Replaces a golden oak slab that read composite
                   and had been representing uPVC since launch; the July image
                   audit pulled it from the gallery but left it as the hero,
                   which is what the hub tile falls back to. Every file here
                   was opened before it was chosen. */
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-anthracite-brick.webp', 'alt' => 'Anthracite uPVC door with two glazed panes, fitted in a brick opening'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-half-glazed.webp', 'alt' => 'White uPVC back door, half glazed over a solid lower panel'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-rosewood-woodgrain.webp', 'alt' => 'uPVC door in a rosewood woodgrain foil with a glazed upper panel'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-arched-leaded.webp', 'alt' => 'White uPVC front door with leaded glass under a brick arch'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-garden-room.webp', 'alt' => 'White uPVC door and windows onto a garden room'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-cream-from-inside.webp', 'alt' => 'Cream uPVC glazed door and window seen from inside the room'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-arch-frame-detail.webp', 'alt' => 'Close detail of a white uPVC arched frame and obscured glass'],
                ],
            ],
            'patio-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-patio-door.jpg', 'alt' => 'uPVC sliding patio doors fitted to a kitchen extension'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-patio-door.jpg', 'alt' => 'uPVC sliding patio doors fitted to a kitchen extension'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/7016_grey_patio-new_build_cladded_house_9.jpg', 'alt' => 'Anthracite grey sliding patio doors on a cedar-clad extension'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio_Door_06.jpg', 'alt' => 'Woodgrain uPVC sliding patio doors on a bungalow'],
                ],
            ],
            'french-doors' => [
                /* Real Fenster French door installs lead; the imported scrape
                   images are gone. Added 2026-07-29 from the Marketing image
                   bank. */
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/french-doors/french-doors-white-brick.webp', 'alt' => 'White uPVC French doors opening onto a patio from a brick home'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/french-doors/french-doors-rosewood-patio.webp', 'alt' => 'uPVC French doors in a rosewood woodgrain finish, opening onto a paved patio'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/french-doors/french-doors-white-brick.webp', 'alt' => 'White uPVC French doors opening onto a patio from a brick home'],
                ],
            ],
            'integral-blinds' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds.jpg', 'alt' => 'Integral blinds inside wide aluminium bifold doors'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg', 'alt' => 'Close-up of a blind sealed between the panes of a glazed door'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds.jpg', 'alt' => 'Integral blinds inside wide aluminium bifold doors'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg', 'alt' => 'Close-up of integral blinds between glass panes'],
                ],
            ],
            'secondary-glazing' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/imported/Joined-Vertical-Slider-Bay.jpg', 'alt' => 'Original sliding sash bay window seen from inside a dining room'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'White uPVC window section showing the sealed glass unit'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/window-repair-milton-keynes-scaled.jpg', 'alt' => 'Existing window opening checked for glazing upgrade work'],
                ],
            ],
            'roof-lanterns' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg', 'alt' => 'Roof lantern bringing daylight into a kitchen extension'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-roof-lantern.jpg', 'alt' => 'Aluminium roof lantern on a flat roof'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg', 'alt' => 'Roof lantern bringing daylight into a kitchen extension'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-B-min-scaled.jpg', 'alt' => 'Roof lantern over a bright living space'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-exterior-min-scaled.jpg', 'alt' => 'Aluminium roof lantern on a flat roof extension'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Lantern-looking-up-04405-min-scaled.jpg', 'alt' => 'Interior view looking up through a roof lantern'],
                ],
            ],
            'window-and-door-repairs' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window opening detail used for repair checks'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window opening detail used for repair checks'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed unit detail for replacement glazing'],
                ],
            ],
            'composite-doors' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/hero/distinction-signature-entrance-1920w.webp', 'alt' => 'Pale blue Signature composite front door with decorative glass'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/gallery/chatsworth-double-lite-1400w.webp', 'alt' => 'Pale composite entrance door with twin Chatsworth glazed panels'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/gallery/venture-urban-entrance-1400w.webp', 'alt' => 'Dark contemporary composite entrance door with a long pull handle'],
                ],
            ],
        ],
        /*
         * The three product-selector hubs: /windows-milton-keynes/,
         * /doors-milton-keynes/ and /other-services/.
         *
         * Card imagery is NOT stored here. It is read from product_media[slug].hero
         * so a hub card and its product page can never show different photographs.
         * Only set 'image' for a route that has no product_media entry.
         *
         * 'fit' is the one-line reason to pick this over its siblings, and 'copy'
         * is the fact that backs it up. Both are for choosing, not for selling;
         * the product page does the selling.
         */
        'product_hub_groups' => [
            'windows' => [
                'eyebrow' => 'Windows',
                // Theme-owned H1s. The windows and doors values are the ones already
                // ranking; do not churn them. No closing full stop, per the H1 rule.
                'h1' => 'Double glazed windows in Milton Keynes',
                'intro' => 'Nine styles, in uPVC and aluminium. The differences that matter are how it looks from the street, how it opens, and how slim the frame is. Pick the one that sounds like your house and we will confirm the specification at survey.',
                'decision_eyebrow' => 'The choice that matters',
                'decision_heading' => 'Both are A+ rated. The difference is the frame.',
                'decision_intro' => 'These are the two systems we fit, and we are glad to fit either. uPVC reaches the lower U-value and comes in the widest range of styles and shapes. Aluminium holds the slimmest frame, so more of the opening is glass, in any RAL colour you name. Both are A+ rated, both are made to measure, and both will outlast the mortgage. The figures below are the ones that actually separate them.',
                'decision_columns' => [
                    [
                        'title' => 'uPVC',
                        'meta' => 'Liniar, 70mm multi-chamber',
                        'points' => [
                            ['label' => 'U-value from', 'value' => '0.95 W/m²K'],
                            ['label' => 'Colours', 'value' => '16 foils'],
                            ['label' => 'Security', 'value' => 'PAS 24'],
                        ],
                        'note' => 'The lower U-value of the two, and the widest choice of styles, shapes and finishes.',
                    ],
                    [
                        'title' => 'Aluminium',
                        'meta' => 'Sheerline, 72mm outer frame',
                        'points' => [
                            ['label' => 'U-value from', 'value' => '1.0 W/m²K'],
                            ['label' => 'Colours', 'value' => 'Any RAL'],
                            ['label' => 'Sightlines', 'value' => 'Slimmer'],
                        ],
                        'note' => 'The slimmest frame of the two, so more of the opening is glass. Any RAL colour you name.',
                    ],
                ],
                'faq_heading' => 'The questions we get asked on the phone.',
                'faqs' => [
                    ['q' => 'Which of these has the lower U-value?', 'a' => 'uPVC, at 0.95 W/m²K against 1.0 for aluminium. The gap comes from the frame rather than the glass, and both are A+ rated and comfortably inside what a replacement window has to reach. It is a small enough difference that most people choose on how the window looks instead.'],
                    ['q' => 'Can I have one colour outside and another inside?', 'a' => 'Yes, in both materials. On uPVC the colour is a foil bonded to the profile, on aluminium it is a powder coat, so a dual finish means two separate treatments rather than one.'],
                    ['q' => 'How secure are they?', 'a' => 'The uPVC range is PAS 24 accredited, which is the enhanced security standard, with multi-point locking as standard. We confirm the exact hardware at survey against where the window is and what it opens onto.'],
                    ['q' => 'What does the guarantee cover?', 'a' => 'Ten years on a new window installation. Repairs, replacement glass on its own, roofline, integral blinds and pet flaps sit outside it. We would rather say that here than leave it in the small print.'],
                ],
                'prices_intro' => 'If you want a figure before you speak to anyone:',
                'prices' => [
                    ['label' => 'Double glazing costs', 'url' => '/double-glazing-cost/'],
                    ['label' => 'Aluminium window prices', 'url' => '/aluminium-window-prices/'],
                    ['label' => 'Sash window prices', 'url' => '/sash-window-prices/'],
                ],
                'quote_heading' => 'Price a window before you speak to anyone.',
                'suppliers_note' => 'Three systems, so a specification conversation is about products we fit every week.',
                'suppliers' => [
                    ['logo' => 'liniar.png', 'name' => 'Liniar', 'role' => 'uPVC windows'],
                    ['logo' => 'sheerline.png', 'name' => 'Sheerline', 'role' => 'Aluminium windows'],
                    ['logo' => 'roseview-logo-new.png', 'name' => 'Roseview', 'role' => 'Sliding sash'],
                ],
                // Bands answer the guide's third question with the layout rather
                // than only in prose. Every slug here must exist in 'products'.
                'products' => [
                    ['slug' => 'casement-windows', 'name' => 'Casement Windows', 'fit' => 'The everyday all-rounder', 'copy' => 'Side or top hung, in almost any combination. Most of the homes we work on end up with these.'],
                    ['slug' => 'flush-casement-windows', 'name' => 'Flush Casement Windows', 'fit' => 'Sits level with the frame', 'copy' => 'The sash closes flush into the outer frame rather than sitting proud of it, which is how timber windows were made.'],
                    ['slug' => 'sliding-sash-windows', 'name' => 'Sliding Sash Windows', 'fit' => 'Period proportions', 'copy' => 'Vertical sliders on the Roseview system, with the horns and bar layouts a period frontage needs.'],
                    ['slug' => 'tilt-turn-windows', 'name' => 'Tilt and Turn Windows', 'fit' => 'Two ways to open', 'copy' => 'Tilt the top inwards for ventilation without unlocking, or swing the whole sash in to clean the outside from indoors.'],
                    ['slug' => 'aluminium-windows', 'name' => 'Aluminium Windows', 'fit' => 'Slim frames, more glass', 'copy' => 'Thinner sightlines than uPVC for the same opening, powder coated in the RAL colour you choose.'],
                    ['slug' => 'aluminium-flush-windows', 'name' => 'Aluminium Flush Windows', 'fit' => 'Flat outside face', 'copy' => 'The aluminium version of a flush sash, where the sash and the frame finish on the same plane.'],
                    ['slug' => 'heritage-windows', 'name' => 'Heritage Windows', 'fit' => 'The steel-window look', 'copy' => 'Slim sections and stepped bars that read like original steel, in thermally broken aluminium.'],
                    ['slug' => 'bow-bay-windows', 'name' => 'Bow and Bay Windows', 'fit' => 'A shape, not a style', 'copy' => 'A bay turns at angles and a bow curves. Both are a shape rather than a system, built from any of the window styles on this page.'],
                    ['slug' => 'french-casement-windows', 'name' => 'French Casement Windows', 'fit' => 'An opening, not a style', 'copy' => 'Two sashes meeting with no fixed mullion between them.'],
                ],
            ],
            'doors' => [
                'eyebrow' => 'Doors',
                'h1' => 'Doors in Milton Keynes',
                'intro' => 'Front doors, back doors and the wide openings onto a garden. The first thing to settle is where it is going and how it needs to open, because that rules most of this list in or out straight away.',
                'decision_eyebrow' => 'The choice that matters',
                'decision_heading' => 'Three ways a door gets out of the way.',
                'decision_intro' => 'For a front or back door there is one sensible answer, and it is hinged. For a garden opening the real question is where the panels go when they are open, because that decides how much of the opening you actually get back and how much room the doors need inside.',
                'decision_columns' => [
                    [
                        'title' => 'Hinged',
                        'meta' => 'Front, back, side and French',
                        'points' => [
                            ['label' => 'Door slab', 'value' => '44.5mm'],
                            ['label' => 'Break-in cover', 'value' => 'Up to £5,000'],
                            ['label' => 'Opening', 'value' => 'One or two leaves'],
                        ],
                        'note' => 'Needs the swing space, inside or out. Where security and insulation matter most.',
                    ],
                    [
                        'title' => 'Sliding',
                        'meta' => 'uPVC patio and aluminium lift and slide',
                        'points' => [
                            ['label' => 'Panes', 'value' => 'Up to 4'],
                            ['label' => 'Tracks', 'value' => 'Dual or triple'],
                            ['label' => 'Swing space', 'value' => 'None'],
                        ],
                        'note' => 'Panels pass each other, so nothing comes into the room and the panes are the largest of the three.',
                    ],
                    [
                        'title' => 'Folding',
                        'meta' => 'Aluminium bifold and slide and fold',
                        'points' => [
                            ['label' => 'Panes', 'value' => 'Up to 7'],
                            ['label' => 'U-value from', 'value' => '1.0 W/m²K'],
                            ['label' => 'Opening', 'value' => 'Nearly all of it'],
                        ],
                        'note' => 'Panels stack to one side, so you get nearly the whole opening back. The stack needs a wall to sit against.',
                    ],
                ],
                'faq_heading' => 'The questions we get asked on the phone.',
                'faqs' => [
                    ['q' => 'Which door is the most secure?', 'a' => 'The composite carries the most on paper: AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock, and if either fails in a break-in you are covered for up to £5,000 in compensation, terms applying. That is not a mark against the rest. Everything we hang is multi-point locked as standard, and the aluminium doors add flush hook-locks on top.'],
                    ['q' => 'How wide can a garden opening go?', 'a' => 'Bifolds run to seven panes and sliding doors to four, on dual or triple tracks. The honest limit is usually the structure above the opening rather than the doors, which is what the survey is for.'],
                    ['q' => 'Sliding or folding for a garden door?', 'a' => 'Folding opens nearly the whole wall, and the panels stack against one side. Sliding keeps the largest single panes and takes up no room at all, and half the opening stays glazed. They are answers to different questions, and which one suits usually comes down to the wall itself, so we would rather look before recommending either.'],
                    ['q' => 'What does the guarantee cover?', 'a' => 'Ten years on a new door installation, and the composite doors carry a separate break-in guarantee on top. Repairs and replacement glass on their own sit outside the ten years.'],
                ],
                'prices_intro' => 'If you want a figure before you speak to anyone:',
                'prices' => [
                    ['label' => 'Composite door prices', 'url' => '/composite-door-prices/'],
                    ['label' => 'Bifold door costs', 'url' => '/bifold-door-cost/'],
                    ['label' => 'Patio and French door prices', 'url' => '/patio-french-door-prices/'],
                ],
                'quote_heading' => 'Price a door before you speak to anyone.',
                'suppliers_note' => 'The three systems behind everything we hang.',
                'suppliers' => [
                    ['logo' => 'distinction-doors.png', 'name' => 'Distinction Doors', 'role' => 'Composite doors'],
                    ['logo' => 'liniar.png', 'name' => 'Liniar', 'role' => 'uPVC doors'],
                    ['logo' => 'sheerline.png', 'name' => 'Sheerline', 'role' => 'Aluminium doors'],
                ],
                // Grouped by where the door goes, which is the first question we
                // ask on the phone and the one that rules most of the list out.
                'products' => [
                    ['slug' => 'composite-doors', 'name' => 'Composite Doors', 'fit' => 'The usual front door choice', 'copy' => 'A 44.5mm insulated slab, against 28mm for a uPVC door panel, with the break-in guarantee behind it.'],
                    ['slug' => 'upvc-doors', 'name' => 'uPVC Doors', 'fit' => 'Straightforward and low upkeep', 'copy' => 'Front, back and utility doors that need washing rather than painting.'],
                    ['slug' => 'aluminium-doors', 'name' => 'Aluminium Doors', 'fit' => 'Matches aluminium windows', 'copy' => 'A front, back or side door in the same frames and powder-coated colours as the windows around it.'],
                    ['slug' => 'heritage-aluminium-doors', 'name' => 'Heritage Aluminium Doors', 'fit' => 'The steel-door look', 'copy' => 'The Sheerline Classic door at 60.5mm sightlines, single or French, opening in or out.'],
                    ['slug' => 'patio-doors', 'name' => 'Patio Doors', 'fit' => 'Nothing swings into the room', 'copy' => 'Up to four panes sliding past each other, so the floor space either side of the opening stays usable.'],
                    ['slug' => 'aluminium-sliding-doors', 'name' => 'Aluminium Sliding Doors', 'fit' => 'The largest panes', 'copy' => 'Sheerline lift and slide, with interlocks as slim as 52mm, so the frame gets out of the way of the view.'],
                    ['slug' => 'aluminium-bifold-doors', 'name' => 'Aluminium Bifold Doors', 'fit' => 'Folds right back', 'copy' => 'Panels stack to one or both sides, so in summer the opening is almost entirely clear.'],
                    ['slug' => 'french-doors', 'name' => 'French Doors', 'fit' => 'A pair, opening from the centre', 'copy' => 'Two doors opening together, with the option of fixed side panels. Built in uPVC, aluminium or heritage.'],
                    ['slug' => 'slide-fold-doors', 'name' => 'Slide and Fold Doors', 'fit' => 'Fold one, or fold them all', 'copy' => 'Each panel slides and opens on its own, so a wide opening stops being an all-or-nothing choice. Ten point locking.'],
                ],
            ],
            'other-services' => [
                'eyebrow' => 'Other services',
                'h1' => 'Roof glazing, blinds, roofline and repairs',
                'intro' => 'Roof glazing, blinds sealed inside the glass, the boards around the roof edge, and the smaller jobs. Some of this we do on its own, and some of it makes sense to do while the scaffolding is already up.',
                'decision_eyebrow' => 'Start here',
                'decision_heading' => 'Most of these are smaller jobs than people expect.',
                'decision_intro' => 'A misted window does not mean new windows, and a cold room does not always mean the frames are at fault. It is worth working out which of these three you actually have before anyone quotes you for a whole house.',
                'decision_columns' => [
                    [
                        'title' => 'The glass has failed',
                        'meta' => 'Misted, blown or broken units',
                        'points' => [
                            ['label' => 'Fix', 'value' => 'New sealed units'],
                            ['label' => 'Frames', 'value' => 'Stay where they are'],
                            ['label' => 'Gas fill', 'value' => 'Argon'],
                        ],
                        'note' => 'If the frames are sound, the glass is changed on its own. Made to measure for the opening you have.',
                    ],
                    [
                        'title' => 'The room is cold or loud',
                        'meta' => 'Where the window has to stay',
                        'points' => [
                            ['label' => 'U-value from', 'value' => '1.8 W/m²K'],
                            ['label' => 'Frames', 'value' => 'Slim aluminium'],
                            ['label' => 'Colours', 'value' => 'Full RAL range'],
                        ],
                        'note' => 'Secondary glazing sits inside the existing window, for listed frontages and noisy roads.',
                    ],
                    [
                        'title' => 'There is no wall left',
                        'meta' => 'Extensions and back returns',
                        'points' => [
                            ['label' => 'Lanterns', 'value' => 'Up to 3.2 x 6m'],
                            ['label' => 'Tie bars', 'value' => 'None needed'],
                            ['label' => 'Glass', 'value' => 'Solar control'],
                        ],
                        'note' => 'Daylight from above when the room has run out of elevation to put a window in.',
                    ],
                ],
                'faq_heading' => 'The questions we get asked on the phone.',
                'faqs' => [
                    ['q' => 'My windows are misted. Do I need new windows?', 'a' => 'Usually not. A misted pane means the seal on that unit has failed, not that the frame has. If the frames are sound we change the glass and leave everything else alone.'],
                    ['q' => 'Do you work on windows you did not fit?', 'a' => 'Yes. Handles, hinges, locks and replacement glass on installations that were never ours are a normal part of the week.'],
                    ['q' => 'Will secondary glazing help with traffic noise?', 'a' => 'It is the better answer than new windows where the existing frontage has to stay, because the gap between the two panes is doing the work. On a listed elevation it is often the only answer.'],
                    ['q' => 'Roof lantern or flat rooflight?', 'a' => 'A lantern stands proud of the roof and throws light further into the room. A flat rooflight sits close to the roof line, which suits a low extension or anywhere a lantern would look too tall from the garden.'],
                ],
                'prices_intro' => 'If you want a figure before you speak to anyone:',
                'prices' => [
                    ['label' => 'Window and door prices', 'url' => '/window-door-prices-milton-keynes/'],
                    ['label' => 'Double glazing costs', 'url' => '/double-glazing-cost/'],
                ],
                'quote_heading' => 'Not sure which of these you need?',
                'suppliers_note' => 'The two systems behind the roof glazing and the frames.',
                'suppliers' => [
                    ['logo' => 'sheerline.png', 'name' => 'Sheerline', 'role' => 'Roof lanterns'],
                    ['logo' => 'liniar.png', 'name' => 'Liniar', 'role' => 'uPVC frames'],
                ],
                'products' => [
                    ['slug' => 'roof-lanterns', 'name' => 'Roof Lanterns', 'fit' => 'Daylight from above', 'copy' => 'Sheerline S1 in square, 2-way and 3-way layouts, up to 3.2 x 6m without tie bars.'],
                    ['slug' => 'flat-rooflights', 'name' => 'Flat Rooflights', 'fit' => 'Flat roof, flat glass', 'copy' => 'Glazing that sits close to the roof line, for extensions where a lantern would stand too tall.', 'image' => '/wp-content/themes/fenster/assets/images/products/roof-lanterns/flat-rooflights/fixed-flat-rooflights-installed-pair.jpg'],
                    ['slug' => 'integral-blinds', 'name' => 'Integral Blinds', 'fit' => 'Blinds inside the glass', 'copy' => 'Sealed between the panes, so there is nothing to dust and nothing to catch. Magnetic or electric control.'],
                    ['slug' => 'double-glazing-replacement', 'name' => 'Replacement Glazing', 'fit' => 'New glass, same frames', 'copy' => 'Misted or broken sealed units changed on their own, without replacing the window around them.'],
                    ['slug' => 'secondary-glazing', 'name' => 'Secondary Glazing', 'fit' => 'A second pane, added inside', 'copy' => 'For listed frontages and noisy roads, where the existing window has to stay exactly as it is.'],
                    /* Missing from this hub until 2026-07-29 even though the
                       homepage product theatre has always said Other Services
                       covers cat and dog flaps. Sits with the glass work,
                       because the job is a flap into a panel or a new sealed
                       unit. Eight tiles still fill two even rows of four. */
                    ['slug' => 'cat-and-dog-flaps', 'name' => 'Cat and Dog Flaps', 'fit' => 'Into a panel or new glass', 'copy' => 'Fitted into a door panel, or into a new sealed unit made with the aperture already in it.'],
                    ['slug' => 'window-and-door-repairs', 'name' => 'Window and Door Repairs', 'fit' => 'Handles, hinges, locks and glass', 'copy' => 'Small jobs on windows and doors, including ones we did not fit ourselves.'],
                    ['slug' => 'roofline', 'name' => 'Roofline', 'fit' => 'Fascias, soffits and guttering', 'copy' => 'The boards and gutters along the roof edge, usually worth doing while the scaffolding is already up.'],
                ],
            ],
        ],
        'product_gallery_groups' => [
            'double-glazing' => 'upvc_windows',
            'casement-windows' => 'casement_windows',
            'flush-casement-windows' => 'flush_casement_windows',
            'sliding-sash-windows' => 'sliding_sash_windows',
            'french-casement-windows' => 'french_casement_windows',
            'tilt-turn-windows' => 'tilt_turn_windows',
            'bow-bay-windows' => 'bow_bay_windows',
            'aluminium-windows' => 'aluminium_windows',
            'aluminium-flush-windows' => 'aluminium_windows',
            'heritage-windows' => 'aluminium_windows',
            'aluminium-bifold-doors' => 'aluminium_bifold_doors',
            'slide-fold-doors' => 'slide_fold_doors',
            'aluminium-sliding-doors' => 'aluminium_sliding_doors',
            'aluminium-doors' => 'aluminium_doors',
            'heritage-aluminium-doors' => 'heritage_aluminium_doors',
            'composite-doors' => 'composite_doors',
            'upvc-doors' => 'upvc_doors',
            'patio-doors' => 'upvc_patio_doors',
            'french-doors' => 'upvc_french_doors',
            'double-glazing-replacement' => 'replacement_glazing',
            'secondary-glazing' => 'secondary_glazing',
            'window-and-door-repairs' => 'window_repairs',
            'cat-and-dog-flaps' => 'pet_flaps',
            'integral-blinds' => 'integral_blinds',
            'roof-lanterns' => 'roof_lanterns',
            'roofline' => 'roofline',
        ],
        'product_gallery_pools' => [
            'upvc_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'uPVC casement windows on a modern home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'uPVC casement window opening detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-flush-window.jpg', 'alt' => 'Flush casement windows set into stonework'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Flush-Casement-Windows-Flitwick-7.jpg', 'alt' => 'Golden oak woodgrain uPVC windows on dormer gables'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-bay-window.jpg', 'alt' => 'White uPVC bay window on a brick property'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-Casement-Windows-Aylesbury.jpg', 'alt' => 'uPVC French casement windows on a brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed window unit detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Aylesbury-French-Casement-Windows.jpg', 'alt' => 'uPVC French casement window opened from a bedroom'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Casement-Windows-Flitwick-10.jpg', 'alt' => 'White uPVC casement bay window with leaded glazing'],
            ],
            'casement_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-stone-cottage-1600w.webp', 'alt' => 'Grey uPVC casement windows in a stone elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-open-brick-1400w.webp', 'alt' => 'White uPVC casement windows opened outwards on a brick house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-handle-detail-1400w.webp', 'alt' => 'Casement window opened on its hinges with the handle and gearing visible'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-sill-interior-1200w.webp', 'alt' => 'White casement window and sill seen from inside a room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'uPVC casement window opening detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'New uPVC casement windows across the rear of a modern brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Casement-Windows-Flitwick-10.jpg', 'alt' => 'Casement windows arranged as a bay on a red brick house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed unit inside a uPVC casement frame'],
            ],
            'flush_casement_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-stone-elevation-1600w.webp', 'alt' => 'Anthracite flush casement windows on a rendered and stone elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-bay-brick-1400w.webp', 'alt' => 'White flush casement bay window on a tile hung house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-grey-interior-1400w.webp', 'alt' => 'Three pane white flush casement window seen from inside'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-dual-colour-closeup-1200w.webp', 'alt' => 'Flush casement window with a black outer frame and white sashes'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-frame-detail-1200w.webp', 'alt' => 'Close-up of a flush casement sash sitting level with its outer frame'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-oak-dormers-1400w.webp', 'alt' => 'Golden oak flush casement windows in two dormer gables'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-grey-top-vents-1400w.webp', 'alt' => 'Grey flush casement windows with the top lights open on a timber clad house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-light-grey-stone-1400w.webp', 'alt' => 'Light grey flush casement windows set into a stone elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Flush-Casement-Windows-Flitwick-6.jpg', 'alt' => 'Flush casement windows fitted to a home in Flitwick'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Flush-Casement-Windows-Flitwick-7.jpg', 'alt' => 'Golden oak woodgrain flush casement windows on dormer gables'],
            ],
            'french_casement_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-Casement-Windows-Aylesbury-1.jpg', 'alt' => 'White French casement window opened wide from the centre with no mullion in the way'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/french-casement/french-casement-bedroom-1400w.webp', 'alt' => 'White French casement window in a bedroom with the two handles meeting at the centre'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-opening.jpeg', 'alt' => 'French casement window with both sashes open and a clear unobstructed opening'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-mullion.jpeg', 'alt' => 'Mullion detail on a French casement window frame'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-shootbolts.jpeg', 'alt' => 'Shootbolt locking on the closing sash of a French casement window'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-casement-centre-keeps.jpeg', 'alt' => 'Centre keeps where the two sashes of a French casement window meet'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/French-Casement-Windows-Aylesbury.jpg', 'alt' => 'French casement window with Georgian bars fitted in Aylesbury'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Aylesbury-French-Casement-Windows.jpg', 'alt' => 'French casement window opened from a bedroom over a garden'],
            ],
            'tilt_turn_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/tilt-turn/tilt-turn-brick-1600w.webp', 'alt' => 'Grey tilt and turn windows on a red brick elevation, one tilted open at the top'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt__Turn_14.jpg', 'alt' => 'Tilt and turn windows in a living room with roman blinds'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/tilt-turn/tilt-turn-apartments-1400w.webp', 'alt' => 'Tilt and turn windows on an apartment block, one sash tilted inwards'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-1.jpeg', 'alt' => 'Tilt and turn window tilted inwards at the top for background ventilation'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-2.jpeg', 'alt' => 'Tilt and turn hardware shown holding the sash in the tilt position'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-keep-1.jpeg', 'alt' => 'Locking keep on the frame of a tilt and turn window'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-keep-2.jpeg', 'alt' => 'Security keep detail on a tilt and turn window frame'],
            ],
            'bow_bay_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/imported/bay-window.jpg', 'alt' => 'White uPVC bay window with leaded glazing on a red brick house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/bow-bay/bay-white-brick-dusk-1600w.webp', 'alt' => 'White bay window with Georgian bars on a brick and render home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_10.jpg', 'alt' => 'Curved white uPVC bow window on a red brick wall'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_02.jpg', 'alt' => 'Golden oak bow window curving out from a light brick elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_08.jpg', 'alt' => 'Golden oak bay window with leaded top lights'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-bay-brick-1400w.webp', 'alt' => 'Bay window built in a flush casement style on a tile hung house'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Joined-Vertical-Slider-Bay.jpg', 'alt' => 'Sliding sash bay window in a dining room'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bay_7-e1699893445270.jpg', 'alt' => 'Bay window on the front elevation of a detached home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Casement-Windows-Flitwick-10.jpg', 'alt' => 'White uPVC bay window with leaded glazing fitted in Flitwick'],
            ],
            'sliding_sash_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-sliding-sash-window.jpg', 'alt' => 'White sliding sash window with Georgian bars'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Sliding-Sash-Windows-Flitwick-8.jpg', 'alt' => 'Sliding sash windows on a white rendered home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Sliding-Sash-Windows-Flitwick-7-1.jpg', 'alt' => 'Sliding sash window with period-style proportions'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Sliding-Sash-Windows-Flitwick-6.jpg', 'alt' => 'White sliding sash window with vertical opening style'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Sash-horn-astragal.jpeg', 'alt' => 'Sash horn and astragal glazing bar detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/ultimate-rose-window-external.png', 'alt' => 'Ultimate Rose sash window viewed externally'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/heritage-rose-window.png', 'alt' => 'Heritage Rose sash window viewed externally'],
            ],
            'aluminium_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Aluminium windows installed on a coastal property'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Aluminium window profile detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', 'alt' => 'Heritage aluminium windows on a period property'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Steel-look aluminium glazing bar detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-french-window.jpg', 'alt' => 'Woodgrain French casement window in a kitchen diner'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/C08-Classic-Windows-Heritage-Style-Anthracite-2048x1366-1.jpg', 'alt' => 'Heritage aluminium windows with dark slim frames'],
            ],
            'aluminium_bifold_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-exterior.jpg', 'alt' => 'Anthracite aluminium bifold doors fitted to a brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Aluminium-Bifold-Doors-Flitwick-8.jpg', 'alt' => 'Grey aluminium bifold doors across a rear extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Aluminium-Bifold-Doors-Flitwick-9.jpg', 'alt' => 'White bifold doors with integral blinds seen from inside'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Aluminium-Bifold-Doors-Flitwick-6.jpg', 'alt' => 'White bifold doors opening a bedroom onto the patio'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-doors.jpg', 'alt' => 'Aluminium bifold doors fully opened to a garden'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bifold-Espag-Handle-v1.webp', 'alt' => 'Flush espagnolette handle on an anthracite bifold door'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bifold-OpenSplit-v1.webp', 'alt' => 'Aluminium bifold doors partly opened'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bifold-4-Thresholds-v2.0-2000x1125-1.webp', 'alt' => 'Aluminium bifold door threshold options'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds.jpg', 'alt' => 'Integral blinds inside wide glazed doors'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg', 'alt' => 'Close-up of blinds between glass panes'],
            ],
            'slide_fold_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/neutral-slide-fold-doors.jpg', 'alt' => 'Slide and fold doors across a wide opening'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/neutral-slide-fold-doors-open.jpg', 'alt' => 'Slide and fold doors partly opened'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Slide-Fold.png', 'alt' => 'Anthracite slide and fold doors on a garden room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-bifold-exterior.jpg', 'alt' => 'Wide glazed door opening on a brick home'],
            ],
            'aluminium_sliding_doors' => [
                // Order is load-bearing. Body images are this pool minus the
                // hero; indices 0 and 1 of that body list render beside the
                // product copy, 2 and 3 render nowhere on this route, and the
                // mosaic takes array_slice(body, 4). So the two close-ups sit
                // in the dead slots, because the lift-and-slide detail section
                // already shows both, and the old hero is reused in the mosaic.
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-3-pane-interior-1600w.webp', 'alt' => 'Three pane aluminium sliding door framing a lake and mountain view'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-open-valley-1400w.webp', 'alt' => 'Aluminium sliding door open from a bright room onto a deck and open countryside'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-timber-clad-1200w.webp', 'alt' => 'Run of aluminium sliding doors along a timber clad garden room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-handle-900w.webp', 'alt' => 'Slim handle and flush hook lock on an aluminium sliding door'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-track-900w.webp', 'alt' => 'Stainless steel running track and threshold on an aluminium sliding door'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-living-room-1200w.webp', 'alt' => 'Aluminium sliding doors across a living room wall'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-view-interior-1500w.webp', 'alt' => 'Two pane aluminium sliding door opening onto a hillside view'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-sliding-door.jpg', 'alt' => 'Aluminium sliding door open onto a decked terrace and countryside'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-sliding/lift-slide-brick-1600w.webp', 'alt' => 'Anthracite aluminium lift and slide patio door on a brick and timber clad elevation'],
            ],
            'aluminium_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-door.jpg', 'alt' => 'Aluminium entrance door opened to a garden'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Prestige-aluminium-door-in-stone-web.webp', 'alt' => 'White aluminium entrance door in a stone surround'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-door.jpg', 'alt' => 'Steel-look aluminium door in a kitchen'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-french-doors.jpg', 'alt' => 'Heritage style aluminium French doors on a brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Classic-French-Internal-open-B-1.0.webp', 'alt' => 'Steel-look aluminium French door opened from a living room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Steel-look glazing bar detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Aluminium frame profile detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/aluminium-doors-northampton-2.jpg', 'alt' => 'Modern aluminium entrance door with full-height glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/aluminium-doors-northampton-6.jpg', 'alt' => 'Aluminium door low threshold detail'],
            ],
            'heritage_aluminium_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-door-kitchen-1600w.webp', 'alt' => 'Steel-look heritage aluminium door and screen in a green kitchen'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-brick-1400w.webp', 'alt' => 'Black heritage aluminium French doors on a red brick courtyard'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-open-1400w.webp', 'alt' => 'Heritage aluminium French doors opened into a living room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-french-courtyard-1100w.webp', 'alt' => 'Heritage aluminium French doors beside a matching window on a rendered wall'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-lockbox-900w.webp', 'alt' => 'Period-style lockbox and lever handles on heritage aluminium French doors'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/heritage-glazing-bar-600w.webp', 'alt' => 'Close-up of a stepped glazing bar on a heritage aluminium frame'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/configurations/config-07-french-no-bars-agate-grey.webp', 'alt' => 'Heritage aluminium French doors with no glazing bars in Agate Grey'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-aluminium/configurations/config-03-single-4-bar-jet-black.webp', 'alt' => 'Single heritage aluminium door with four glazing bars in Jet Black'],
            ],
            'composite_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/distinction-composite-door.jpg', 'alt' => 'Composite front door with half glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/distinction-composite-door-installed.jpg', 'alt' => 'Composite front door installed on a brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/home-theatre-composite-door.jpg', 'alt' => 'Composite front door on a house entrance'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Composite-Doors-Letchworth-1.jpg', 'alt' => 'Anthracite cottage-style composite door with diamond glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Composite-Doors-Flitwick-4.jpeg', 'alt' => 'Composite door with decorative glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Composite-Doors-Flitwick-10.jpg', 'alt' => 'Composite front door style detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Composite-Doors-Flitwick-12-1.jpg', 'alt' => 'Composite entrance door with glass panel'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/composite-doors-milton-keynes-3.jpg', 'alt' => 'Red traditional composite door with decorative glass'],
            ],
            'upvc_doors' => [
                /* Same real installs as product_media. The pool fed the town
                   matrix pages as well, so the composite-looking slab was on
                   every /upvc-doors-<town>/ route too, not just the product
                   page. Replaced 2026-07-29. */
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-anthracite-brick.webp', 'alt' => 'Anthracite uPVC door with two glazed panes, fitted in a brick opening'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-half-glazed.webp', 'alt' => 'White uPVC back door, half glazed over a solid lower panel'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-rosewood-woodgrain.webp', 'alt' => 'uPVC door in a rosewood woodgrain foil with a glazed upper panel'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-arched-leaded.webp', 'alt' => 'White uPVC front door with leaded glass under a brick arch'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-garden-room.webp', 'alt' => 'White uPVC door and windows onto a garden room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-cream-from-inside.webp', 'alt' => 'Cream uPVC glazed door and window seen from inside the room'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-arch-frame-detail.webp', 'alt' => 'Close detail of a white uPVC arched frame and obscured glass'],
            ],
            'upvc_patio_doors' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-patio-door.jpg', 'alt' => 'uPVC sliding patio doors in a kitchen extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/7016_grey_patio-new_build_cladded_house_9.jpg', 'alt' => 'Anthracite grey sliding patio doors on a cedar-clad extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio_Door_06.jpg', 'alt' => 'Woodgrain uPVC sliding patio doors on a bungalow'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio-door-main-image_trans.png', 'alt' => 'uPVC patio door product view'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio-door-lock-and-handle.png', 'alt' => 'uPVC patio door lock and handle detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio-door-lock-hook-dark.png', 'alt' => 'Patio door hook lock detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio-door-low-threshold.png', 'alt' => 'Low threshold detail for patio doors'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Patio-door-threshold.png', 'alt' => 'Patio door threshold section'],
            ],
            'upvc_french_doors' => [
                /* Imported scrape images replaced with real Fenster installs,
                   2026-07-29. */
                ['src' => '/wp-content/themes/fenster/assets/images/products/french-doors/french-doors-white-brick.webp', 'alt' => 'White uPVC French doors opening onto a patio from a brick home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/french-doors/french-doors-rosewood-patio.webp', 'alt' => 'uPVC French doors in a rosewood woodgrain finish, opening onto a paved patio'],
            ],
            'replacement_glazing' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed unit showing sealed glass construction'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Opening window and glazing detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'Double glazed windows on a modern home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-flush-window.jpg', 'alt' => 'Flush window with replacement glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-bay-window.jpg', 'alt' => 'Bay window with multiple glazed units'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Glazing bar and glass detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/window-repair-milton-keynes-scaled.jpg', 'alt' => 'Existing window glass checked for replacement work'],
            ],
            'secondary_glazing' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Secondary glazing panel shown inside a window opening'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/window-repair-milton-keynes-scaled.jpg', 'alt' => 'Existing window opening checked for secondary glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window frame and glazing detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Replace-old-windows.jpeg', 'alt' => 'Existing window considered for glazing improvement'],
            ],
            'window_repairs' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window opening detail used for repair checks'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Double glazed unit detail for replacement glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/window-repair-milton-keynes-scaled.jpg', 'alt' => 'Window hinge and locking gear adjusted during a repair'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Replace-old-windows.jpeg', 'alt' => 'Older window reviewed for repair or replacement'],
            ],
            'pet_flaps' => [
                /* Was roofline boards and a sealed-unit sample. Real installs
                   since 2026-07-29; the pool feeds the town matrix too. */
                ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-cat-through-flap.webp', 'alt' => 'Black cat coming out through a white pet flap fitted into a glazed door'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-cat-at-the-flap.webp', 'alt' => 'Black cat looking out through a white pet flap fitted into a sealed glass unit'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-round-in-door.webp', 'alt' => 'Clear round pet flap in a glazed door beside a brick wall'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-round-glass-closeup.webp', 'alt' => 'Clear round pet flap in a glazed door, seen close up from outside'],
            ],
            /* Every one of these has to show a blind. Three of the five were a
               plain sliding door, a plain bifold and a sealed unit sample, none
               of which had a blind in them, so the page illustrated integral
               blinds mostly with doors. Owner caught it on 2026-08-04. If a
               photograph does not show slats, it does not belong in this pool. */
            'integral_blinds' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds-closeup.jpg', 'alt' => 'Blind sealed between panes of glass'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/notan-integral-blinds.jpg', 'alt' => 'Integral blinds inside wide glazing'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/HiTech-Blinds-Patio-Doors-Blinds-Closed.jpg', 'alt' => 'White patio doors with the integral blinds closed across all three panes'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/HiTech-Blinds-Integral-Blinds-Black-Doors.jpg', 'alt' => 'Anthracite bifold doors with integral blinds lowered inside the glass'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/HiTech-Blinds-French-Doors-open.jpg', 'alt' => 'French doors open, with integral blinds lowered in the side panels'],
            ],
            'roof_lanterns' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-roof-lantern.jpg', 'alt' => 'Roof lantern glazing on a flat roof'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-roof-lantern-interior.jpg', 'alt' => 'Roof glazing bringing daylight into a kitchen'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-A-min-scaled.jpg', 'alt' => 'Roof lantern bringing daylight into a kitchen extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-Kitchen-B-min-scaled.jpg', 'alt' => 'Roof lantern over a bright living space'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/S1-Lantern-exterior-min-scaled.jpg', 'alt' => 'Aluminium roof lantern on a flat roof extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Lantern-looking-up-04405-min-scaled.jpg', 'alt' => 'Interior view looking up through a roof lantern'],
            ],
            'roofline' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-fascia.jpg', 'alt' => 'White fascia and soffit on a tiled roofline'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-roofline-soffit.jpg', 'alt' => 'Close-up of soffit and fascia detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-exterior.jpg', 'alt' => 'Windows and roofline on a modern home'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-bay-window.jpg', 'alt' => 'Bay window below roofline detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Flush-Casement-Windows-Flitwick-9.jpg', 'alt' => 'Flush window near roofline cladding'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-flush-window.jpg', 'alt' => 'Flush windows and stone elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Window and roofline on a home exterior'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window detail near external trim'],
            ],
        ],
        'product_content' => [
            /* This page came in from a scrape as a listicle, "5 Powerful Proven
               Strategies to Control Cost, Compliance and Heat Loss in Office
               Refurbishment". The H1 was corrected in July 2026 but the body was
               left, so the numbered headings were still being fed into both the
               benefit cards and the FAQs, which is why they rendered twice. The
               scrape also called Headrow Court an office refurbishment. It is a
               conversion of former offices into student accommodation, and the
               windows are the part Fenster did. Authored copy replaces it. */
            'commercial-glazing-leeds' => [
                'intro' => 'Fenster carries out commercial glazing in Leeds: window and door replacement, curtain walling, facade glazing and replacement units. In Leeds we fitted the aluminium windows at Headrow Court, a conversion of four former office buildings into 108 student studios, completed in October 2025.',
                'benefits' => [
                    ['title' => 'Surveyed before anything is priced', 'copy' => 'Openings on older commercial buildings rarely match the drawings. We check sizes, structural openings, access and existing frames before specifying, so the price reflects the building rather than an assumption about it.'],
                    ['title' => 'Repair or replace, answered honestly', 'copy' => 'Not every failed window needs a new frame. A blown unit or worn hardware can often be dealt with on its own. We will say so when that is the cheaper answer, and say plainly when it is not.'],
                    ['title' => 'Buildings that stay open', 'copy' => 'Most commercial work happens around staff, tenants or trading hours. Sequence, access routes and which elevations come out in which order get agreed before the first frame is removed.'],
                    ['title' => 'Aluminium for larger openings', 'copy' => 'Thermally broken aluminium carries the spans and glass weights that commercial elevations need, in any RAL colour. Where uPVC is the better fit for the building and the budget, we will specify that instead.'],
                    ['title' => 'Compliance settled at specification', 'copy' => 'Part L, safety glazing and any acoustic requirement belong in the specification, not in a variation after contract. We would rather have that conversation early than reprice the job later.'],
                ],
                'faqs' => [
                    ['question' => 'Do you actually work in Leeds, or just cover it?', 'answer' => 'We work there. Fenster is based in Milton Keynes and travels for commercial projects. The Leeds job we can point you at is Headrow Court, where we fitted the aluminium windows on a conversion of four former office buildings into 108 student studios, completed in October 2025.'],
                    ['question' => 'What kind of commercial buildings do you glaze?', 'answer' => 'Offices, retail units, hotels, care homes, schools, healthcare buildings and student accommodation. The building type matters less than the openings, the access and the programme.'],
                    ['question' => 'Can the work happen while the building is occupied?', 'answer' => 'Usually yes, and most commercial jobs are. It is planned in phases around access, working hours and the parts of the building that have to keep running. The sequence is agreed before work starts rather than settled on site.'],
                    ['question' => 'Do we have to replace every window?', 'answer' => 'No. A survey may find that some openings need new frames, others need new sealed units, and others need nothing. Phased replacement across more than one budget year is a normal way to run this.'],
                    ['question' => 'How do you price a commercial job?', 'answer' => 'From drawings, a window schedule, photographs or a site visit, depending on what exists. The online quote tool is for domestic windows and doors and will not price commercial work, so commercial enquiries come to us directly.'],
                ],
            ],
            'aluminium-bifold-doors' => [
                'intro' => 'Aluminium bifold doors open up kitchens, extensions and living spaces with slim frames, flexible pane layouts and strong weather protection. Fenster specifies the configuration, traffic door, threshold, colour and glazing around how the room will be used.',
                'benefits' => [
                    ['title' => 'Open-plan living', 'copy' => 'Aluminium bifold doors create a wide, flexible opening between your home and garden while keeping strong weather protection when closed.'],
                    ['title' => 'Slim aluminium sightlines', 'copy' => 'Narrow frames help maximise glass area, daylight and views without compromising everyday durability.'],
                    ['title' => 'Configured around the opening', 'copy' => 'Fenster helps plan pane count, traffic doors, thresholds, colours, glazing and hardware around the way the space will be used.'],
                    ['title' => 'Thermally broken frames', 'copy' => 'High-performance aluminium frames and modern glazing help retain warmth, reduce draughts and keep the room comfortable when the doors are closed.'],
                    ['title' => 'Installed with care', 'copy' => 'The opening, levels, drainage and threshold details are checked before manufacture so the doors fold, seal and lock correctly after installation.'],
                ],
                'faqs' => [
                    ['question' => 'How many panes can aluminium bifold doors have?', 'answer' => 'Fenster can specify bifold configurations up to seven panes, depending on the opening size, layout and access requirements.'],
                    ['question' => 'Can bifold doors include a traffic door?', 'answer' => 'Yes. A traffic door can be included in many configurations so you can use one everyday entrance without opening the full set.'],
                    ['question' => 'Are bifold doors thermally efficient?', 'answer' => 'Yes. The aluminium bifold systems are specified with thermally broken frames and high-performance glazing to support comfort through the year.'],
                    ['question' => 'Can I choose the colour and hardware?', 'answer' => 'Yes. Fenster can help you choose RAL frame colours, handle finishes, threshold details and glazing options for the property.'],
                    ['question' => 'Will the doors be surveyed before manufacture?', 'answer' => 'Yes. The opening, threshold, access and installation details are checked before manufacture so the finished doors fit correctly.'],
                ],
            ],
            'aluminium-flush-windows' => [
                'intro' => 'Aluminium flush windows give modern performance a cleaner, flatter external finish. Fenster helps you compare sightlines, colour, opening style, glazing and hardware so the final specification suits the property rather than simply reusing a standard aluminium-window package.',
                'benefits' => [
                    ['title' => 'Flush external finish', 'copy' => 'The sash sits neatly in the frame for a crisp, minimal look that works well on both contemporary and carefully updated homes.'],
                    ['title' => 'Strong thermal performance', 'copy' => 'Thermally broken aluminium and high-performance glazing help improve comfort while keeping the frame profile slim.'],
                    ['title' => 'Made-to-measure colour choice', 'copy' => 'Fenster can specify RAL colours, hardware and glazing details around the building style and the rest of the project.'],
                    ['title' => 'Secure everyday use', 'copy' => 'Multipoint locking, robust aluminium frames and suitable glazing options help give each opening a reassuring secure finish.'],
                    ['title' => 'Surveyed before manufacture', 'copy' => 'Fenster checks sizes, opening styles, frame details and installation conditions before the windows are ordered.'],
                ],
                'faqs' => [
                    ['question' => 'What makes aluminium flush windows different?', 'answer' => 'The flush sash sits flatter within the outer frame, giving a cleaner external line than a standard projecting casement.'],
                    ['question' => 'Are aluminium flush windows suitable for older homes?', 'answer' => 'They can be. Fenster will help compare proportions, colours and sightlines so the window suits the age and style of the property.'],
                    ['question' => 'Can I choose any RAL colour?', 'answer' => 'Yes. Aluminium flush windows can be specified in a wide range of RAL colours, subject to the chosen system and finish.'],
                    ['question' => 'Do they still offer good energy performance?', 'answer' => 'Yes. The system uses thermally broken aluminium frames and modern glazing to support strong thermal performance.'],
                    ['question' => 'Will Fenster survey before ordering?', 'answer' => 'Yes. Measurements, opening styles, frame details and installation constraints are checked before manufacture.'],
                ],
            ],
            'aluminium-sliding-doors' => [
                'intro' => 'Aluminium sliding doors are designed for wide glass areas, slim sightlines and smooth access to the garden. Fenster specifies the track layout, pane size, colour, locking and threshold details around the opening, so the doors suit the room and the way you use the garden.',
                'benefits' => [
                    ['title' => 'Large glass openings', 'copy' => 'Sliding doors suit wide openings where you want more daylight, uninterrupted views and a clean connection to the outside.'],
                    ['title' => 'Dual or triple-track layouts', 'copy' => 'Fenster can help decide whether a dual or triple-track configuration is the right fit for the available space and daily use.'],
                    ['title' => 'Secure aluminium system', 'copy' => 'Flush hook-locks, robust frames and modern glazing keep the design practical as well as minimal.'],
                    ['title' => 'Smooth access to outside', 'copy' => 'Large sliding panels keep the opening easy to use without needing the swing space of hinged doors.'],
                    ['title' => 'Specified around thresholds', 'copy' => 'Survey checks cover drainage, floor levels and access requirements so the finished doors work cleanly with the room and patio.'],
                ],
                'faqs' => [
                    ['question' => 'Are aluminium sliding doors different from standard uPVC sliders?', 'answer' => 'Yes. Aluminium sliding doors use slimmer, stronger aluminium profiles that can support larger glass areas and cleaner sightlines.'],
                    ['question' => 'Can I choose a dual or triple-track design?', 'answer' => 'Yes. Fenster can specify dual or triple tracks depending on opening width, pane layout and how much clear opening you want.'],
                    ['question' => 'Are aluminium sliding doors secure?', 'answer' => 'Yes. The systems are specified with secure locking, strong frames and glazing options suitable for residential installations.'],
                    ['question' => 'Can the doors match my window colours?', 'answer' => 'In most projects, yes. Aluminium frames can be powder coated in a wide range of RAL colours to coordinate with other products.'],
                    ['question' => 'Will the threshold be checked?', 'answer' => 'Yes. Fenster checks threshold height, drainage, access and floor finishes during survey before the final specification is ordered.'],
                ],
            ],
            /* Rewritten 2026-08-02 from the owner's own account of the job.
               Two corrections of substance: we offer two flap types, standard
               and microchip, where the strip used to imply three by listing
               "lockable" separately; and the routes in are a new sealed unit or
               a panel we cut, on doors and windows that are already there as
               well as new ones. Brands are kept vague on purpose because the
               full supplier list is not settled; SureFlap is named because we
               are approved to fit it.

               No line here says what the guarantee does not cover. Owner
               instruction, 2026-08-02: the site avoids stating exclusions. The
               order-process rail still scopes its guarantee step to "new windows
               and doors", which is a positive statement that happens to stay
               accurate on this route; that scoping is accuracy, not a negative,
               and must not be removed. */
            'cat-and-dog-flaps' => [
                'intro' => 'A sealed glass unit cannot be cut once it has been made. So a flap in glass means a new unit with the hole already in it, and a flap in a door panel is one we cut ourselves. Working out which of those two your door needs is the first thing we do, because it decides the rest of the job.',
                'benefits' => [
                    ['title' => 'Two flaps, not a catalogue', 'copy' => 'A standard flap that you lock by hand when you want it shut, or a microchip flap that reads the chip your pet already has and opens only for them. The second one is what people ask for when someone else\'s cat has been letting itself in.'],
                    ['title' => 'Glass means a new unit', 'copy' => 'Toughened and sealed units cannot be cut after they are made, which surprises most people. We measure the opening, order a new unit with the aperture already in the right place, and fit the flap into that.'],
                    ['title' => 'Panels we cut ourselves', 'copy' => 'Where the door has a panel that suits it, we cut the aperture and fit the flap into it. We check the material and the thickness first, because not every panel will take one.'],
                    ['title' => 'It does not have to be our door', 'copy' => 'We fit flaps into doors and windows that are already in the house, not only into ones we are making for you. If we did not install it, we will still tell you straight whether it will take a flap.'],
                    ['title' => 'Approved SureFlap installers', 'copy' => 'We are approved to fit SureFlap, and we fit other makes as well. That means the flap gets chosen around your pet and your door rather than around one brand.'],
                ],
                'faqs' => [
                    ['question' => 'Can you fit a cat flap into a double glazed door?', 'answer' => 'Yes, but not by cutting the glass you already have. A sealed unit cannot be cut once it has been made, so we measure the opening and order a new unit with the aperture already in it. The flap goes into that. Dog flaps and microchip flaps go in the same way, with a bigger aperture for a dog.'],
                    ['question' => 'Can you fit one into a door panel instead?', 'answer' => 'Yes, where the panel suits it. We cut the aperture ourselves and fit the flap into the panel. We check the material and thickness first, because not every panel will take one.'],
                    ['question' => 'What is the difference between the two flaps you fit?', 'answer' => 'A standard flap locks by hand when you want it shut. A microchip flap reads the chip your pet already has and opens only for them, so other animals stay outside. Both go into glass or a panel the same way.'],
                    ['question' => 'Does it have to be a door you installed?', 'answer' => 'No. We fit flaps into doors and windows that are already in the house, as well as into new ones we are making for you.'],
                    ['question' => 'How long does it take?', 'answer' => 'Glass is the longer of the two. The new unit is made to order with the aperture already in it, so allow a week or two from the survey. A panel does not need a new unit made, so it is normally quicker.'],
                ],
            ],
            'roofline' => [
                'intro' => 'Roofline replacement protects the exposed edge of the roof with low-maintenance fascias, soffits and guttering. Fenster checks the existing boards, ventilation, drainage and access so the finished roofline looks neat and performs properly.',
                'benefits' => [
                    ['title' => 'Protects the roof edge', 'copy' => 'Fascias, soffits and guttering help protect the roofline from water ingress, weathering and long-term timber damage.'],
                    ['title' => 'Low-maintenance uPVC', 'copy' => 'Modern uPVC roofline products reduce repainting and routine upkeep compared with older timber boards.'],
                    ['title' => 'Ventilation and drainage', 'copy' => 'Fenster can help review soffit ventilation and gutter performance so the roof edge works as well as it looks.'],
                    ['title' => 'Colour-matched finishing', 'copy' => 'Roofline trims, boards and guttering can be chosen to suit the windows, doors and exterior style of the property.'],
                    ['title' => 'Measured replacement', 'copy' => 'Existing boards, fixing points and drainage runs are checked before replacement so the new roofline is specified properly.'],
                ],
                'faqs' => [
                    ['question' => 'What roofline products can Fenster replace?', 'answer' => 'Fenster can help with roofline items such as fascias, soffits and guttering, depending on the property and project scope.'],
                    ['question' => 'Why replace old timber fascias?', 'answer' => 'Old timber can rot, move and need regular repainting. uPVC roofline products provide a lower-maintenance alternative.'],
                    ['question' => 'Can roofline colours match my windows and doors?', 'answer' => 'In many cases, yes. Fenster can help choose roofline finishes that coordinate with the wider exterior.'],
                    ['question' => 'Will ventilation be considered?', 'answer' => 'Yes. Soffit ventilation and roof-edge condition should be checked as part of the replacement conversation.'],
                    ['question' => 'Is roofline work surveyed first?', 'answer' => 'Yes. Fenster checks the existing roof edge, boards, access and drainage details before confirming the specification.'],
                ],
            ],
            'double-glazing-replacement' => [
                'intro' => 'Double glazing replacement restores failed, misted or damaged sealed units without replacing the whole frame where the frame is still sound. Fenster measures the glass, checks the safety requirements and orders the correct made-to-measure unit.',
                'benefits' => [
                    ['title' => 'Replace failed sealed units', 'copy' => 'Misted, blown or damaged double glazed units can often be replaced without changing the whole frame.'],
                    ['title' => 'Keeps existing frames', 'copy' => 'Where frames are sound, replacement glass restores clarity and performance while keeping disruption lower.'],
                    ['title' => 'Made-to-measure glass', 'copy' => 'Each replacement unit is measured and ordered to suit the existing frame, spacer and glazing requirements.'],
                    ['title' => 'Improves comfort and clarity', 'copy' => 'Fresh sealed units can help address condensation between panes, damaged glass and reduced thermal performance.'],
                    ['title' => 'Surveyed before ordering', 'copy' => 'Fenster checks the unit size, glass type, safety requirements and frame condition before replacement glass is manufactured.'],
                ],
                'faqs' => [
                    ['question' => 'Can blown double glazing be replaced without a new window?', 'answer' => 'Often, yes. If the frame is still sound, Fenster can replace the failed sealed glass unit rather than the whole window.'],
                    ['question' => 'What causes misting between panes?', 'answer' => 'Misting usually means the sealed unit has failed, allowing moisture between the panes of glass.'],
                    ['question' => 'Can replacement glass improve comfort?', 'answer' => 'A new sealed unit can restore performance where the old unit has failed, helping improve clarity and comfort.'],
                    ['question' => 'Do you measure the existing unit first?', 'answer' => 'Yes. The glass size, thickness, spacer, safety requirements and frame condition are checked before ordering.'],
                    ['question' => 'Can pet flaps or integral blinds be included?', 'answer' => 'Where suitable, a new sealed unit can sometimes be specified with options such as a pet-flap aperture or integral blinds.'],
                ],
            ],
            'double-glazing' => [
                'intro' => 'Double glazing improves comfort, security and day-to-day energy performance across the home. Fenster helps you choose the right window or door system, glass, colour and hardware around the property rather than treating double glazing as one generic upgrade.',
                'benefits' => [
                    ['title' => 'Warmer, quieter rooms', 'copy' => 'Modern double glazing helps reduce heat loss and soften outside noise, especially when older single glazing or tired sealed units are being replaced.'],
                    ['title' => 'Window and door options', 'copy' => 'Choose from uPVC, aluminium, flush, sash, heritage, French, patio and entrance door styles with advice on what suits each opening.'],
                    ['title' => 'Security-led specification', 'copy' => 'Frame strength, glazing choice, locking and hardware are considered together so the finished installation feels secure as well as warmer.'],
                    ['title' => 'Made-to-measure survey', 'copy' => 'Every opening is measured and checked before manufacture, including frame condition, thresholds, drainage, access and finishing details.'],
                    ['title' => 'Coordinated finishes', 'copy' => 'Fenster can help coordinate frame colours, handles, obscured glass and door hardware so the full project looks deliberate.'],
                ],
                'faqs' => [
                    ['question' => 'What does double glazing help with?', 'answer' => 'It can improve thermal comfort, reduce draughts, soften outside noise and improve security when specified with suitable frames, glass and locking.'],
                    ['question' => 'Can I replace only some windows?', 'answer' => 'Yes. Fenster can quote individual windows, doors or a staged whole-home upgrade depending on budget, priorities and the condition of the existing frames.'],
                    ['question' => 'Which frame material should I choose?', 'answer' => 'uPVC is a strong value choice for everyday efficiency, while aluminium gives slimmer sightlines and a more contemporary finish. Fenster will help compare both.'],
                    ['question' => 'Do I need a survey before ordering?', 'answer' => 'Yes. Made-to-measure glazing should be surveyed so sizes, openings, thresholds, safety glass and installation details are confirmed before manufacture.'],
                    ['question' => 'Can double glazing be matched to my home style?', 'answer' => 'Yes. Colour, profile shape, sash style, handles and glass options can all be chosen to suit traditional, period and modern properties.'],
                ],
            ],
            'casement-windows' => [
                'intro' => 'Casement windows are the practical all-rounder for warmer, brighter homes. Fenster specifies Liniar uPVC profiles, opening layouts, colour, handles and glazing around each room so the finished windows feel simple to use and properly suited to the property.',
                'benefits' => [
                    ['title' => 'Everyday versatile design', 'copy' => 'Side-hung, top-hung and fixed casement layouts can be combined to suit bedrooms, living spaces, kitchens and hard-working family rooms.'],
                    ['title' => 'Efficient uPVC profile', 'copy' => 'Liniar multi-chambered uPVC profiles and modern double glazing support strong thermal performance without making the window feel bulky.'],
                    ['title' => 'Continuous weather sealing', 'copy' => 'Patented bubble gaskets help form a continuous seal around the frame, reducing draughts and helping keep rain safely outside.'],
                    ['title' => 'Secure hardware choices', 'copy' => 'Casement windows can include multi-point locking, secure handles and suitable glazing options for a reassuring everyday specification.'],
                    ['title' => 'Low-maintenance finish', 'copy' => 'uPVC frames do not need repainting and are available in classic white, foiled finishes and colours to suit the wider exterior.'],
                ],
                'faqs' => [
                    ['question' => 'Are casement windows suitable for most homes?', 'answer' => 'Yes. Casement windows are one of the most flexible window styles and can be configured for most common residential openings.'],
                    ['question' => 'What energy rating can casement windows achieve?', 'answer' => 'Casement windows can achieve A+ rated performance, with supplied U-value information shown near the top of the page.'],
                    ['question' => 'Can I choose different opening layouts?', 'answer' => 'Yes. Fenster will help plan side-hung, top-hung, fixed and mixed layouts around ventilation, access, safety and the look of the elevation.'],
                    ['question' => 'Are uPVC casement windows secure?', 'answer' => 'Yes. The specification can include multi-point locking, secure handles and appropriate glazing, with PAS 24 options available where specified.'],
                    ['question' => 'Can the frames be coloured?', 'answer' => 'Yes. Casement windows can be specified in a range of uPVC finishes, including white, woodgrain-style foils and selected contemporary colours.'],
                ],
            ],
            'flush-casement-windows' => [
                'intro' => 'Flush casement windows bring a traditional timber-inspired look to modern uPVC performance. Fenster helps you compare the frame detail, colour, handles and glazing so the windows suit older properties, newer homes and carefully updated facades.',
                'benefits' => [
                    ['title' => 'Timber-style flush sash', 'copy' => 'The sash sits level within the outer frame, giving a flatter external line than a standard projecting casement window.'],
                    ['title' => 'Liniar weather performance', 'copy' => 'Liniar flush sash systems use modern uPVC profile design and weather sealing to help protect against draughts and rain.'],
                    ['title' => 'A+ rated comfort', 'copy' => 'Flush casement windows can support warmer rooms and improved efficiency with A+ rated performance options.'],
                    ['title' => 'Period or contemporary finish', 'copy' => 'Choose traditional woodgrain-style foils, smooth contemporary colours, hardware finishes and glazing bars where the design calls for them.'],
                    ['title' => 'Surveyed for the detail', 'copy' => 'Fenster checks frame sizes, sightlines, opening styles and installation conditions so the flush detail works cleanly on the property.'],
                ],
                'faqs' => [
                    ['question' => 'What is a flush casement window?', 'answer' => 'It is a casement window where the opening sash sits neatly within the frame, creating a flatter, more timber-like external appearance.'],
                    ['question' => 'Are flush casement windows good for period homes?', 'answer' => 'Often, yes. Their timber-style proportions, foiled finishes and optional heritage details can suit older homes while reducing maintenance.'],
                    ['question' => 'Do flush casement windows need repainting?', 'answer' => 'No. uPVC flush casements are low maintenance and only need normal cleaning and occasional hardware care.'],
                    ['question' => 'Can they be used in bays or larger layouts?', 'answer' => 'Yes. Flush casement styles can often be used in bay and bow arrangements, subject to survey and structural suitability.'],
                    ['question' => 'Can I choose handles and colours?', 'answer' => 'Yes. Fenster can help coordinate frame colour, handle finish, obscured glass and any heritage-style detailing.'],
                ],
            ],
            'sliding-sash-windows' => [
                'intro' => 'Sliding sash windows give period character with modern uPVC performance. Fenster specifies Roseview sash windows around proportions, colour, horns, glazing bars, hardware and survey details so the finished window looks authentic and works smoothly.',
                'benefits' => [
                    ['title' => 'Classic vertical sliding style', 'copy' => 'Sash windows retain the familiar up-and-down opening associated with Georgian, Victorian and Edwardian homes.'],
                    ['title' => 'Modern Roseview system', 'copy' => 'Roseview gives a sash-focused profile system rather than a generic casement window adapted to look traditional.'],
                    ['title' => 'A-rated efficiency', 'copy' => 'Sliding sash windows combine traditional appearance with modern comfort, with A-rated efficiency as standard across the range.'],
                    ['title' => 'Authentic design options', 'copy' => 'Run-through horns, astragal bars, woodgrain-style finishes, colours and hardware can be chosen to suit the age and detail of the property.'],
                    ['title' => 'Security and smooth operation', 'copy' => 'Modern sash balances, locks and glazing choices help the windows open smoothly while giving a more secure everyday specification.'],
                ],
                'faqs' => [
                    ['question' => 'Do sliding sash windows have to be timber?', 'answer' => 'No. Modern uPVC sash windows can recreate traditional proportions while reducing maintenance and improving everyday thermal performance.'],
                    ['question' => 'Are sliding sash windows suitable for period properties?', 'answer' => 'Yes. They are often chosen for older homes because the vertical sliding format, horns and glazing bars can respect original window proportions.'],
                    ['question' => 'Can sash windows reduce outside noise?', 'answer' => 'Modern double glazing and well-sealed frames can help soften outside noise compared with older, loose or single-glazed sash windows.'],
                    ['question' => 'What colours are available?', 'answer' => 'A full RAL colour range can be discussed, with final colour and finish confirmed against the chosen sash system.'],
                    ['question' => 'Will the windows be measured before manufacture?', 'answer' => 'Yes. Fenster surveys sash openings carefully because proportions, frame depth, reveal detail and installation condition all affect the final result.'],
                ],
            ],
            'french-casement-windows' => [
                'intro' => 'French casement windows open from the centre to create a wide, unobstructed aperture. They suit rooms that need more ventilation, clearer views or an upper-floor escape-style opening while keeping the efficiency and finish options of modern uPVC.',
                'benefits' => [
                    ['title' => 'Clear central opening', 'copy' => 'With no fixed centre mullion when both sashes are open, French casement windows create a wider view and more usable ventilation.'],
                    ['title' => 'Useful upper-floor option', 'copy' => 'The wide opening can suit rooms where fire escape, cleaning access or strong purge ventilation needs to be considered.'],
                    ['title' => 'Modern uPVC performance', 'copy' => 'Liniar uPVC profiles support weather protection, low maintenance and energy efficiency in a familiar casement-style format.'],
                    ['title' => 'Coordinated appearance', 'copy' => 'French casements can be matched with other casement, flush or tilt and turn windows across a broader project.'],
                    ['title' => 'Designed around safety', 'copy' => 'Fenster checks opening sizes, restrictors, handles, safety glass and room use before confirming the final specification.'],
                ],
                'faqs' => [
                    ['question' => 'What is a French casement window?', 'answer' => 'It is a pair of casement sashes that open from the centre, creating a wider clear opening than many standard casement layouts.'],
                    ['question' => 'Where do French casement windows work best?', 'answer' => 'They work well where you want a wider opening for ventilation, views, cleaning access or an upper-floor escape-style arrangement.'],
                    ['question' => 'Can they match other uPVC windows?', 'answer' => 'Yes. They can be specified with matching colours, profile styling and handles so they coordinate with other window types.'],
                    ['question' => 'Are French casement windows secure?', 'answer' => 'Yes. They can include modern locking, suitable hardware and glazing options, with the final details confirmed during specification.'],
                    ['question' => 'Will Fenster advise on restrictors?', 'answer' => 'Yes. Fenster will consider room use, height, safety requirements and ventilation needs when specifying openings and restrictors.'],
                ],
            ],
            'tilt-turn-windows' => [
                'intro' => 'Tilt and turn windows give two opening modes in one frame: secure top ventilation and a wider inward opening for cleaning or access. Fenster specifies them for modern homes, upper floors and practical rooms where flexibility matters.',
                'benefits' => [
                    ['title' => 'Two-way opening', 'copy' => 'Tilt the sash inward at the top for ventilation, or turn it fully inward for cleaning, access and stronger airflow.'],
                    ['title' => 'Strong efficiency data', 'copy' => 'Tilt and turn windows can offer strong energy performance, with supplied U-value information shown in the key specification strip.'],
                    ['title' => 'Easy internal cleaning', 'copy' => 'The inward turn mode allows the outside face of the glass to be reached from inside, useful on upper floors or awkward elevations.'],
                    ['title' => 'Secure ventilation', 'copy' => 'The tilt position allows controlled airflow without opening the full sash in the same way as a conventional side-hung window.'],
                    ['title' => 'Modern, practical look', 'copy' => 'Tilt and turn windows suit contemporary homes, apartments and rooms where the clean internal operation is more useful than a traditional outward opening.'],
                ],
                'faqs' => [
                    ['question' => 'How does a tilt and turn window open?', 'answer' => 'The handle controls two modes: a top tilt for ventilation and an inward turn for cleaning, access and a wider opening.'],
                    ['question' => 'Are tilt and turn windows good for upper floors?', 'answer' => 'Yes. The inward opening can make cleaning easier from inside, subject to room layout and safety considerations.'],
                    ['question' => 'Do tilt and turn windows suit older homes?', 'answer' => 'They can, but they usually feel more modern. Fenster will help compare them with casement, flush or sash styles if appearance is important.'],
                    ['question' => 'Are they energy efficient?', 'answer' => 'Yes. Tilt and turn windows can offer strong energy performance, with supplied U-value information shown on the page.'],
                    ['question' => 'Can they provide secure ventilation?', 'answer' => 'Yes. The tilt position allows controlled airflow while keeping the sash partly retained within the frame.'],
                ],
            ],
            'bow-bay-windows' => [
                'intro' => 'Bow and bay windows add light, shape and usable depth to the front of a home. Fenster helps plan the window style, angles, support, colour and glazing so the feature improves the room rather than simply replacing like-for-like frames.',
                'benefits' => [
                    ['title' => 'More light and outlook', 'copy' => 'Projecting window layouts bring more glass area into the room and can make living spaces feel brighter and more open.'],
                    ['title' => 'Bow or bay configuration', 'copy' => 'Bow windows usually create a softer curve, while bay windows form a more angular projection with a stronger architectural shape.'],
                    ['title' => 'Choice of window styles', 'copy' => 'A bay is a shape rather than a system, so we can build it from any of our window styles, in uPVC or aluminium, mixing fixed panes and openers to suit the room.'],
                    ['title' => 'Survey-led structure check', 'copy' => 'Fenster checks existing supports, angles, cills, roof details and installation conditions before specifying replacement bow or bay windows.'],
                    ['title' => 'Coordinated colours and handles', 'copy' => 'Frame finish, handle colour, obscured glass and trickle ventilation can be coordinated with the rest of the home.'],
                ],
                'faqs' => [
                    ['question' => 'What is the difference between bow and bay windows?', 'answer' => 'A bow usually uses several windows to create a curved appearance, while a bay projects more angularly from the property.'],
                    ['question' => 'Can bow and bay windows improve room space?', 'answer' => 'They can add usable depth to the window area and bring in more daylight, making the room feel larger and brighter.'],
                    ['question' => 'Do bow and bay windows need structural checks?', 'answer' => 'Yes. The existing opening, supports, cill, roof or canopy details should be checked before replacement is confirmed.'],
                    ['question' => 'Can I choose opening windows within the bay?', 'answer' => 'Yes. Fenster can combine fixed panes and opening sashes to balance ventilation, views, cleaning and security.'],
                    ['question' => 'Can they match the other windows?', 'answer' => 'Yes. Colours, profile style and handle finishes can be coordinated with other uPVC or aluminium windows on the property.'],
                ],
            ],
            'aluminium-windows' => [
                'intro' => 'Aluminium windows are chosen for slim sightlines, strength and a clean architectural finish. Fenster specifies Sheerline aluminium systems around frame style, colour, glazing, security and installation detail so the finished windows suit the building and the view.',
                'benefits' => [
                    ['title' => 'Slim modern frames', 'copy' => 'Aluminium strength allows narrower-looking frames and larger glass areas, helping bring more daylight into the room.'],
                    ['title' => 'Thermlock technology', 'copy' => 'Sheerline aluminium systems use Thermlock multi-chamber thermal technology to improve insulation compared with older aluminium approaches.'],
                    ['title' => 'Flexible window styles', 'copy' => 'Casement, French, tilt and turn and fixed aluminium windows can be combined to suit contemporary extensions and whole-home upgrades.'],
                    ['title' => 'Powder-coated colour', 'copy' => 'Aluminium frames can be specified in a wide range of RAL colours, including dual-colour options where suitable.'],
                    ['title' => 'Security-focused details', 'copy' => 'Robust aluminium construction, locking hardware and suitable glazing options help each opening feel secure as well as slim.'],
                ],
                'faqs' => [
                    ['question' => 'Why choose aluminium windows?', 'answer' => 'Aluminium is strong, slim and durable, making it a good choice where clean sightlines and larger glass areas are important.'],
                    ['question' => 'Are aluminium windows energy efficient?', 'answer' => 'Yes. Modern thermally broken aluminium systems improve comfort significantly compared with old aluminium frames.'],
                    ['question' => 'Can aluminium windows be coloured?', 'answer' => 'Yes. Aluminium can be powder coated in many RAL colours, with dual-colour options available on some systems.'],
                    ['question' => 'Do aluminium windows suit traditional homes?', 'answer' => 'They can, especially where slim frames or heritage styling is wanted. Fenster will compare standard, flush and heritage options.'],
                    ['question' => 'Will the sightlines be checked before ordering?', 'answer' => 'Yes. Fenster reviews frame sizes, mullions, opening positions and glass areas during specification and survey.'],
                ],
            ],
            'heritage-windows' => [
                'intro' => 'Heritage aluminium windows recreate the slim, gridded character of steel-style glazing while giving modern thermal performance and easier maintenance. Fenster helps choose glazing bars, colours, handles and proportions so the final design feels authentic.',
                'benefits' => [
                    ['title' => 'Steel-style appearance', 'copy' => 'Slim aluminium frames and heritage glazing-bar layouts create the industrial or period-inspired look often associated with old steel windows.'],
                    ['title' => 'Modern aluminium performance', 'copy' => 'Thermally broken aluminium and modern glazing help improve comfort compared with original steel or tired single-glazed frames.'],
                    ['title' => 'Consistent sightlines', 'copy' => 'Fenster helps align bar layouts, sash positions and fixed panes so the heritage pattern looks balanced across the elevation.'],
                    ['title' => 'Durable powder-coated finish', 'copy' => 'Aluminium frames resist routine corrosion and repainting demands, with powder-coated colours chosen around the property style.'],
                    ['title' => 'Window and door coordination', 'copy' => 'Heritage windows can be coordinated with heritage aluminium doors where a full steel-look project is required.'],
                ],
                'faqs' => [
                    ['question' => 'Are heritage windows the same as steel windows?', 'answer' => 'No. They are aluminium windows designed to achieve a steel-inspired look with modern glazing, insulation and lower maintenance.'],
                    ['question' => 'Where do heritage windows work well?', 'answer' => 'They suit period renovations, industrial-style interiors, extensions, cottages and homes where slim dark glazing bars are part of the design.'],
                    ['question' => 'Can heritage windows improve energy performance?', 'answer' => 'Yes. Modern aluminium frames and double glazing can improve comfort compared with old steel or single-glazed windows.'],
                    ['question' => 'Can I choose the bar layout?', 'answer' => 'Yes. Fenster will help plan glazing bars, fixed panes and openings so the pattern looks balanced and practical.'],
                    ['question' => 'Can heritage windows match doors?', 'answer' => 'Yes. Heritage aluminium doors can be specified alongside the windows for a consistent steel-look project.'],
                ],
            ],
            'slide-fold-doors' => [
                'intro' => 'Slide and fold doors give a flexible alternative to conventional bifolds. The panels can slide and open individually, giving everyday ventilation, access and wide opening potential without treating the door as only fully open or fully closed.',
                'benefits' => [
                    ['title' => 'Individual panel control', 'copy' => 'Panels can slide and swing independently, so you can open one section, several sections or the full span depending on the weather and use.'],
                    ['title' => 'Everyday traffic-door use', 'copy' => 'A main access leaf can work like a normal door, making the system more useful for daily garden access than many full bifold arrangements.'],
                    ['title' => 'Space-efficient opening', 'copy' => 'The panels slide along the track before stacking, reducing the need to keep large internal or external swing zones clear.'],
                    ['title' => 'Interlocking security', 'copy' => 'The system uses interlocking panels and concealed operating hardware to create a secure closed wall of doors.'],
                    ['title' => 'Smooth, simple operation', 'copy' => 'The bottom-running action and independent panels are designed for lighter, more flexible everyday use.'],
                ],
                'faqs' => [
                    ['question' => 'How are slide and fold doors different from bifolds?', 'answer' => 'Instead of all panels folding together, slide and fold panels can move independently so you can open as much or as little of the doorway as needed.'],
                    ['question' => 'Can I use one panel as a normal door?', 'answer' => 'Yes. The system can include a main traffic door for everyday access without opening the full set.'],
                    ['question' => 'Are slide and fold doors secure?', 'answer' => 'Yes. The closed panels interlock through the system, with security hardware specified around the chosen configuration.'],
                    ['question' => 'Do the panels take up room when opening?', 'answer' => 'They are designed to slide before stacking, reducing the clearance needed compared with many traditional hinged or folding layouts.'],
                    ['question' => 'Will Fenster survey the opening first?', 'answer' => 'Yes. Track, threshold, drainage, width, floor levels and access all need to be checked before manufacture.'],
                ],
            ],
            'aluminium-doors' => [
                'intro' => 'Aluminium doors create strong, slim and highly configurable entrances for modern homes and extensions. Fenster specifies the door style, threshold, colour, glazing and locking around the opening so the result feels secure, refined and practical.',
                'benefits' => [
                    ['title' => 'Strong aluminium construction', 'copy' => 'Aluminium gives entrance and rear doors a robust frame with clean sightlines and a durable powder-coated finish.'],
                    ['title' => 'Modern design choice', 'copy' => 'Choose single doors, glazed doors, side panels, contemporary panels and colour options to suit the architecture.'],
                    ['title' => 'Thermally broken frames', 'copy' => 'Modern aluminium door systems use thermal breaks and appropriate glazing to support comfort through the year.'],
                    ['title' => 'Threshold planning', 'copy' => 'Fenster checks access, drainage, floor levels and threshold requirements before the final door is ordered.'],
                    ['title' => 'Secure entrance hardware', 'copy' => 'Locks, cylinders, handles and glazing are specified together so the finished door feels reassuring in daily use.'],
                ],
                'faqs' => [
                    ['question' => 'Are aluminium doors suitable for front entrances?', 'answer' => 'Yes. Aluminium doors can be specified as front, side or rear doors with secure hardware, colour choice and suitable glazing.'],
                    ['question' => 'Can aluminium doors include glass?', 'answer' => 'Yes. Glazed panels, side screens and different glass options can be specified depending on privacy, daylight and design needs.'],
                    ['question' => 'Are aluminium doors thermally efficient?', 'answer' => 'Modern aluminium doors use thermal breaks and appropriate glazing to improve comfort compared with older aluminium systems.'],
                    ['question' => 'Can I choose a low threshold?', 'answer' => 'Often, yes. Fenster will check floor levels, drainage and access needs before confirming the best threshold detail.'],
                    ['question' => 'Can the door match aluminium windows?', 'answer' => 'Yes. Colour, frame style and hardware can often be coordinated with aluminium windows, sliders, bifolds or heritage doors.'],
                ],
            ],
            'heritage-aluminium-doors' => [
                'intro' => 'Heritage aluminium doors bring steel-look styling to modern external doors. Fenster specifies the stepped frame detail, glazing-bar layout, colour, threshold and hardware so the finished doors look sharp without losing everyday comfort and security.',
                'benefits' => [
                    ['title' => 'Steel-look door styling', 'copy' => 'Slim aluminium profiles and heritage glazing details create the look of traditional steel doors without the same maintenance demands.'],
                    ['title' => 'Thermlock performance', 'copy' => 'Sheerline heritage-style aluminium systems use modern thermal technology to support comfort behind the period-inspired appearance.'],
                    ['title' => 'Single or French layouts', 'copy' => 'Heritage doors can be specified as single doors or paired French-style openings depending on the room and access required.'],
                    ['title' => 'Secure hardware options', 'copy' => 'Multipoint locking, suitable glass and robust aluminium frames help create a secure external door specification.'],
                    ['title' => 'Matched heritage project', 'copy' => 'Doors can be coordinated with heritage windows for extensions, internal courtyards and full steel-look elevations.'],
                ],
                'faqs' => [
                    ['question' => 'What are heritage aluminium doors?', 'answer' => 'They are aluminium doors designed with slim, steel-inspired sightlines and glazing-bar layouts, but with modern thermal and security features.'],
                    ['question' => 'Can heritage doors be used as French doors?', 'answer' => 'Yes. Depending on the system and opening, they can often be specified as single or French-style door sets.'],
                    ['question' => 'Do heritage aluminium doors need much maintenance?', 'answer' => 'No. Powder-coated aluminium is designed for low maintenance compared with traditional steel or timber alternatives.'],
                    ['question' => 'Can I choose the glazing bar pattern?', 'answer' => 'Yes. Fenster will help plan the bar layout, pane sizes and opening arrangement so the design looks balanced.'],
                    ['question' => 'Are heritage doors secure?', 'answer' => 'Yes. They can include secure locking, strong aluminium frames and suitable glazing, with final details confirmed during specification.'],
                ],
            ],
            'upvc-doors' => [
                'intro' => 'A uPVC door is not one thing. The same Liniar system makes a single front or back door, a French pair that opens from the centre, or a stable door split across the middle so the top half opens on its own. Which one suits you is usually decided by the opening and how the room is used, not by the price.',
                'benefits' => [
                    ['title' => 'Efficient Liniar profiles', 'copy' => 'Multi-chambered uPVC profiles help reduce heat transfer and support a warmer entrance specification.'],
                    ['title' => 'Single, French or stable', 'copy' => 'One leaf for a front or back door, a French pair for a wider opening onto a garden, or a stable door where you want air in without the whole thing open. All on the same system.'],
                    ['title' => 'Secure locking options', 'copy' => 'uPVC doors can include multi-point locking, secure cylinders and reinforced hardware for everyday peace of mind.'],
                    ['title' => 'Low threshold choices', 'copy' => 'Threshold details can be reviewed where easier access, garden access or trip reduction is important.'],
                    ['title' => 'Low-maintenance finish', 'copy' => 'uPVC doors do not need painting and can be cleaned easily, with foiled finishes available for a timber-style look.'],
                ],
                'faqs' => [
                    ['question' => 'What configurations do uPVC doors come in?', 'answer' => 'A single leaf for a front, back or side entrance; a French pair that opens from the centre for a wider opening; or a stable door split across the middle, so the top half can open on its own. Panel design, glass, colour, handles and letterplates are chosen on top of whichever you pick.'],
                    ['question' => 'Are uPVC doors good for front doors?', 'answer' => 'Yes. uPVC doors can be specified for front, rear or side entrances with secure locking, glazing and panel choices.'],
                    ['question' => 'How secure are uPVC doors?', 'answer' => 'uPVC doors can include multi-point locking, with hardware and cylinder options confirmed during the quote and survey process.'],
                    ['question' => 'Can uPVC doors be coloured?', 'answer' => 'Yes. uPVC doors can be specified in white, woodgrain-style foils and selected colours depending on the system.'],
                    ['question' => 'Can I include side panels or glass?', 'answer' => 'Yes. Glazing, sidelights and privacy glass can be included where the opening and design allow.'],
                    ['question' => 'Will a uPVC door be made to measure?', 'answer' => 'Yes. Fenster checks the opening, threshold, frame, hardware and access requirements before manufacture.'],
                ],
            ],
            'patio-doors' => [
                'intro' => 'Patio doors create a smooth, space-saving connection to the garden. Fenster specifies uPVC sliding patio doors around pane layout, track, colour, glazing, security and threshold details so the doors suit both the room and the outside level.',
                'benefits' => [
                    ['title' => 'Space-saving sliding access', 'copy' => 'Sliding panels do not swing into the room or patio, making them useful where space is tight or furniture sits near the opening.'],
                    ['title' => 'Up to four panes', 'copy' => 'Configurations up to four panes can be considered, depending on opening width and survey conditions.'],
                    ['title' => 'Efficient uPVC frame', 'copy' => 'Liniar-style multi-chambered uPVC frames and modern glazing support year-round comfort in a large glazed opening.'],
                    ['title' => 'Secure sliding hardware', 'copy' => 'Locking, keeps, handles and glazing are specified together to make the patio door practical and reassuring.'],
                    ['title' => 'Threshold and drainage check', 'copy' => 'Fenster reviews track position, drainage, floor levels and access before the doors are ordered.'],
                ],
                'faqs' => [
                    ['question' => 'Are patio doors different from aluminium sliding doors?', 'answer' => 'Fenster patio doors are uPVC sliding doors, while aluminium sliding doors use slimmer aluminium frames for larger glass areas.'],
                    ['question' => 'How many panes can patio doors have?', 'answer' => 'Configurations up to four panes can be considered, subject to opening size and survey.'],
                    ['question' => 'Are patio doors energy efficient?', 'answer' => 'Yes. Modern glazing and supplied U-value information help show how the doors support comfort.'],
                    ['question' => 'Can patio doors be secure?', 'answer' => 'Yes. Secure locking, suitable glazing and correct installation are all part of the final specification.'],
                    ['question' => 'Can I choose colours and handles?', 'answer' => 'Yes. Frame colour, handle finish and glazing options can be chosen around the property and wider project.'],
                ],
            ],
            'french-doors' => [
                'intro' => 'French doors give a classic double-door opening for gardens, patios and side entrances. Fenster specifies Liniar uPVC French doors around security, threshold, glazing, colour and hardware so the doors feel traditional, practical and well sealed.',
                'benefits' => [
                    ['title' => 'Classic double opening', 'copy' => 'French doors open from the centre to create a generous garden or patio access point without the complexity of a multi-panel door.'],
                    ['title' => 'Liniar profile system', 'copy' => 'A coordinated Liniar uPVC door system supports efficient profile design and consistent finishing.'],
                    ['title' => 'A+ rated performance', 'copy' => 'French doors can support strong comfort around a heavily glazed entrance when specified with the right frame and glass.'],
                    ['title' => 'Multi-point locking', 'copy' => 'Hardware and cylinders are specified around the final door set.'],
                    ['title' => 'Threshold and glass options', 'copy' => 'Choose threshold detail, privacy glass, decorative glass and handle finishes to suit the way you move in and out of the home.'],
                ],
                'faqs' => [
                    ['question' => 'Where do French doors work best?', 'answer' => 'They work well for patios, gardens, side entrances and rooms where a classic double-door opening suits the property.'],
                    ['question' => 'Are French doors secure?', 'answer' => 'Yes. Multi-point locking, final hardware and glazing are confirmed during specification.'],
                    ['question' => 'Can French doors have a low threshold?', 'answer' => 'Often, yes. Fenster will check access needs, floor levels and drainage before confirming the threshold detail.'],
                    ['question' => 'Can French doors be coloured?', 'answer' => 'Yes. uPVC French doors can be specified in a range of finishes depending on the chosen profile system.'],
                    ['question' => 'Are French doors energy efficient?', 'answer' => 'Yes. Modern glazing and the right uPVC door system can support improved comfort.'],
                ],
            ],
            'integral-blinds' => [
                'intro' => 'Integral blinds sit sealed between panes of glass, giving clean privacy and light control without loose cords, dusty slats or exposed fabric. Fenster offers magnetic or electric control options for suitable windows, doors and glazed units.',
                'benefits' => [
                    ['title' => 'Sealed between glass', 'copy' => 'The blind is protected inside the glazed unit, keeping the slats away from dust, fingerprints, moisture and everyday damage.'],
                    ['title' => 'Magnetic or electric control', 'copy' => 'Magnetic or electric controls can be chosen so the operation matches the room and budget.'],
                    ['title' => 'Low-maintenance privacy', 'copy' => 'Integral blinds give adjustable privacy and shade without separate curtains, cords or traditional internal blinds.'],
                    ['title' => 'Good for doors and busy rooms', 'copy' => 'They are especially useful in sliding doors, bifolds, kitchens, bathrooms and garden-facing glazing where exposed blinds can get in the way.'],
                    ['title' => 'Colour and glazing choices', 'copy' => 'Fenster can help match blind colour, glass type and frame finish so the unit works visually as well as practically.'],
                ],
                'faqs' => [
                    ['question' => 'What are integral blinds?', 'answer' => 'They are blinds sealed inside a double or triple glazed unit, rather than fitted to the room side of the glass.'],
                    ['question' => 'Are integral blinds easy to clean?', 'answer' => 'Yes. Because the blind is sealed between panes, the slats are protected from normal dust and moisture. You clean the glass, not the blind.'],
                    ['question' => 'Can I choose magnetic or electric blinds?', 'answer' => 'Yes. Fenster describes the available control options as magnetic or electric, with suitability confirmed around the unit and project.'],
                    ['question' => 'Are integral blinds safe for children and pets?', 'answer' => 'They avoid dangling cords and exposed slats, making them a neat option for family rooms and busy doors.'],
                    ['question' => 'Can integral blinds be added to existing glass?', 'answer' => 'Usually they require a new glazed unit made with the blind sealed inside, so Fenster will check sizes and suitability first.'],
                ],
            ],
            'secondary-glazing' => [
                'intro' => 'Secondary glazing adds a discreet internal glazed layer to existing windows. It is useful where original frames need to stay in place, but the room would benefit from better comfort, reduced noise and improved usability.',
                'benefits' => [
                    ['title' => 'Keeps existing windows', 'copy' => 'Secondary glazing sits inside the original window line, making it useful for heritage homes, listed-style settings and sensitive facades.'],
                    ['title' => 'Acoustic improvement', 'copy' => 'The extra internal pane and air gap can noticeably reduce outside noise when specified and fitted correctly.'],
                    ['title' => 'Better thermal comfort', 'copy' => 'Adding a secondary glazed layer helps reduce heat loss through older single-glazed or poorly performing windows.'],
                    ['title' => 'Slim aluminium frames', 'copy' => 'Slim aluminium frames and RAL colour choice help keep the internal finish discreet.'],
                    ['title' => 'Made around the opening', 'copy' => 'Fenster checks reveal depth, handles, shutters, existing frame condition and access before confirming the secondary glazing style.'],
                ],
                'faqs' => [
                    ['question' => 'What is secondary glazing?', 'answer' => 'It is an additional internal glazed panel or frame fitted inside an existing window to improve comfort, noise reduction and usability.'],
                    ['question' => 'Is secondary glazing suitable for period homes?', 'answer' => 'Yes. It is often used where original windows need to be retained but performance needs to be improved.'],
                    ['question' => 'Can secondary glazing reduce noise?', 'answer' => 'Yes. A well-specified secondary pane and air gap can significantly soften outside noise compared with the original window alone.'],
                    ['question' => 'Can the frame colour be matched?', 'answer' => 'Yes. A full RAL colour range can be discussed for the slim aluminium frame.'],
                    ['question' => 'Do I still open my original window?', 'answer' => 'That depends on the secondary glazing configuration. Fenster will help choose fixed, sliding or opening designs around access and ventilation.'],
                ],
            ],
            'roof-lanterns' => [
                'intro' => 'Roof lanterns bring controlled daylight into kitchens, extensions and open-plan living spaces. Fenster specifies the Sheerline S1 lantern around size, style, glazing, colour, ventilation and security so the roof opening feels bright without becoming an afterthought.',
                'benefits' => [
                    ['title' => 'Sheerline S1 system', 'copy' => 'Fenster specifies the Sheerline S1 roof lantern, an aluminium lantern system designed around slim sightlines, strength and thermal performance.'],
                    ['title' => 'Clean daylight from above', 'copy' => 'A roof lantern can make flat-roof extensions, kitchens and dining spaces feel taller, brighter and more connected to the sky.'],
                    ['title' => 'Thermlock technology', 'copy' => 'The S1 lantern uses Sheerline Thermlock multi-chamber technology with modern glazing to support year-round comfort.'],
                    ['title' => 'Style and size choice', 'copy' => 'Square, two-way and three-way lantern styles can be considered, with colour and glazing choices confirmed around the project.'],
                    ['title' => 'Security and ventilation options', 'copy' => 'Fenster can discuss security upgrades, roof ventilation, solar-control glass and installation details before manufacture.'],
                ],
                'faqs' => [
                    ['question' => 'Where do roof lanterns work best?', 'answer' => 'They are often used over flat-roof extensions, kitchens, dining areas and open-plan spaces where extra overhead daylight will improve the room.'],
                    ['question' => 'Which roof lantern system does Fenster use?', 'answer' => 'Fenster can specify the Sheerline S1 roof lantern system. Final size, style and glass are confirmed during specification.'],
                    ['question' => 'Can roof lanterns help with thermal comfort?', 'answer' => 'Yes. The S1 system uses aluminium profiles with Thermlock technology and modern glazing to help retain warmth compared with older roof glazing.'],
                    ['question' => 'Can I choose the lantern colour?', 'answer' => 'Yes. Standard and project-specific colour options can be discussed, including colours that coordinate with aluminium windows or doors.'],
                    ['question' => 'Does a roof lantern need a survey?', 'answer' => 'Yes. The opening size, upstand, roof condition, drainage, access and glass requirements should be checked before the lantern is ordered.'],
                ],
            ],
            'window-and-door-repairs' => [
                'intro' => 'Window and door repairs are for restoring security, smooth operation and comfort where replacement is not the right first step. Fenster checks the fault, explains the repair approach and uses suitable replacement parts where the existing product can be saved.',
                'benefits' => [
                    ['title' => 'Repair-first advice', 'copy' => 'Where frames are still sound, Fenster can repair faults rather than pushing straight to full replacement.'],
                    ['title' => 'Windows and doors covered', 'copy' => 'Repairs can include uPVC, aluminium and composite windows or doors, depending on the fault and available parts.'],
                    ['title' => 'Locks, handles and hinges', 'copy' => 'Common issues include stiff hinges, failed handles, broken locks, dropped doors, draughts and poor closing action.'],
                    ['title' => 'Clear repair pricing', 'copy' => 'Fenster explains the repair approach and quote before work goes ahead.'],
                    ['title' => 'Security and comfort restored', 'copy' => 'A good repair can improve locking, weather sealing, operation and everyday confidence without unnecessary disruption.'],
                ],
                'faqs' => [
                    ['question' => 'Can Fenster repair windows and doors instead of replacing them?', 'answer' => 'Often, yes. If the frame and core product are still suitable, repair can be the most practical and cost-effective option.'],
                    ['question' => 'What repair faults can you help with?', 'answer' => 'Typical repair work includes locks, handles, hinges, dropped doors, stiff windows, draughts, failed seals and poor closing action.'],
                    ['question' => 'Do you repair uPVC and aluminium products?', 'answer' => 'Yes. Fenster can review uPVC, aluminium and composite products, subject to fault diagnosis and parts availability.'],
                    ['question' => 'Will you explain the cost before repairing?', 'answer' => 'Yes. Fenster aims to provide a clear repair quote so you understand what is being fixed and why.'],
                    ['question' => 'When is replacement better than repair?', 'answer' => 'Replacement may be better if frames are badly distorted, heavily damaged, inefficient beyond repair or no longer compatible with safe replacement parts.'],
                ],
            ],
            'composite-doors' => [
                'intro' => 'We fit Distinction composite doors, the door on one in four UK front entrances: Signature for traditional homes, Contemporary for clean lines. Price yours online in about ten minutes, or come and slam one in the showroom.',
                'benefits' => [
                    ['title' => 'Strong entrance door construction', 'copy' => 'Composite doors combine a reinforced core, durable skins and secure hardware for a robust front-door upgrade.'],
                    ['title' => 'Wide design choice', 'copy' => 'Fenster can help compare door styles, glass designs, colours and hardware so the entrance suits the property.'],
                    ['title' => 'Secure by design options', 'copy' => 'Security-focused locks, cylinders and hardware options help create a reassuring entrance specification.'],
                    ['title' => 'Weather-resistant finish', 'copy' => 'Composite door skins are designed to handle everyday weather while keeping a smart, low-maintenance appearance.'],
                    ['title' => 'Surveyed and fitted carefully', 'copy' => 'The frame, threshold, opening and hardware details are checked before ordering so the final door fits properly.'],
                ],
                'faqs' => [
                    ['question' => 'How much does a composite door cost fitted?', 'answer' => 'One we fitted recently came to £2,000 including VAT: a 900 x 2100 Distinction Esteem, anthracite grey outside and white inside, with a low aluminium threshold, clear glass and a chrome lever handle. Yours will differ with size, style, glass and hardware, so the honest answer is to price your exact door on our quote tool, which takes about ten minutes. Our composite door prices page shows the checked example and what moves the figure.'],
                    ['question' => 'What is a composite door made from?', 'answer' => 'A 44.5mm slab built in layers: a GRP skin with a woodgrain taken from real oak, water-resistant polymer edges, engineered wood stiles, a reinforced central board and a foam-filled insulating core. A typical uPVC door panel is 28mm, which is why a composite door feels so different the first time you close one.'],
                    ['question' => 'Are composite doors more secure than uPVC doors?', 'answer' => 'The slab is thicker and stiffer than a uPVC panel, most decorative glass designs are laminated, and every doorset we fit has multi-point locking. Distinction door slabs are accredited by Secured by Design, the police security initiative, and our composite doors carry a £5,000 security guarantee.'],
                    ['question' => 'Can I choose the colour and glass design?', 'answer' => 'Yes, and you can have one colour outside and a different one inside. Colour, glass and hardware are chosen against your door style, and the combination is confirmed before anything is ordered. Colour swatches come out to a consultation; the doors themselves are at the showroom.'],
                    ['question' => 'Do composite doors need repainting?', 'answer' => 'No, and you should not paint one; it voids the surface warranty. Warm water and a soft cloth is the whole maintenance routine. Skip abrasive cleaners, pressure washers and solvents.'],
                    ['question' => 'Why is there no U-value shown for composite doors?', 'answer' => 'A real U-value belongs to the complete doorset: slab, frame, glass and threshold together. We will not print an invented number before your door is specified. The tested figure worth knowing is Distinction\'s: up to 50% more thermally efficient than a 48mm solid-timber-core composite door in independent testing at the University of Salford\'s Energy House.'],
                ],
                'glass_styles' => [
                    'intro' => 'Distinction decorative glass gives a composite entrance more character without turning the choice into guesswork. Most decorative units are triple glazed and laminated as standard; availability still depends on the chosen door style, aperture size and final doorset specification.',
                    'note' => 'Sierra, Trieste, Bloom, Matrix and Eclipse are shown by Distinction as stock-limited or being phased, so Fenster will confirm current availability before ordering.',
                    'items' => [
                        ['name' => 'Lunna', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/lunna.jpg', 'copy' => 'A soft decorative pattern for traditional and modern door styles.'],
                        ['name' => 'Aspen', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/aspen.jpg', 'copy' => 'A classic decorative style often used where the glass should feel detailed but not fussy.'],
                        ['name' => 'Monza', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/monza.jpg', 'copy' => 'A stronger pattern choice for entrance doors that need a more confident glazed detail.'],
                        ['name' => 'Chatsworth', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/chatsworth.jpg', 'copy' => 'A frosted satin centre with a fine clear pencil border for a restrained, elegant look.'],
                        ['name' => 'Wentworth', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/wentworth.jpg', 'copy' => 'A satin privacy centre with a wider clear border for a smart framed appearance.'],
                        ['name' => 'Andorra', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/andorra.jpg', 'copy' => 'A zinc-accented design suited to doors where decorative detail is part of the kerb appeal.'],
                        ['name' => 'Scotia', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/scotia.jpg', 'copy' => 'A traditional decorative option that works well with classic and cottage-style doors.'],
                        ['name' => 'Palma', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/palma.jpg', 'copy' => 'A decorative pattern often chosen to add shape and movement to the glazed area.'],
                        ['name' => 'Edwardian', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/edwardian.jpg', 'copy' => 'A period-leaning glass style for entrances with a more traditional character.'],
                        ['name' => 'Kara Zinc', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/kara-zinc.jpg', 'copy' => 'A versatile Kara option with zinc caming for a clean, refined finish.'],
                        ['name' => 'Kara Brass', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-glass/kara-brass.jpg', 'copy' => 'A warmer Kara option for homes using brass, bronze or warmer hardware tones.'],
                    ],
                ],
            ],
        ],
        'sash_furniture' => [
            'slugs' => [
                'sliding-sash-windows',
            ],
            'intro' => 'Roseview sash windows use sash-specific furniture rather than normal casement handles. The chosen furniture depends on the Rose model, the window width and the final survey specification.',
            'finish_note' => 'Furniture finishes are available in classic options such as gold, chrome and white, with final compatibility confirmed before order.',
            'width_rule' => [
                'title' => 'Furniture count changes with sash width',
                'copy' => 'Windows under 700mm wide use one pole eye and one lock instead of two. Windows over 700mm wide use two locks, two tilt knobs, two pole eyes on the top sash and two sash lifts on the bottom sash.',
            ],
            'ranges' => [
                [
                    'name' => 'Globe furniture',
                    'model' => 'Ultimate Rose',
                    'tagline' => 'Premium Ultimate Rose hardware',
                    'copy' => 'Globe is the premium furniture range, exclusive to Ultimate Rose and chosen where the closest timber-style detailing matters.',
                    'items' => [
                        ['name' => 'Globe Hook Lock', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/globe-lock.jpg'],
                        ['name' => 'Globe Tilt Knob', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/ultimate-tilt-knob.jpg'],
                        ['name' => 'Ultimate Pole Eye', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/ultimate-pole-eye.jpg'],
                        ['name' => 'Ultimate Sash Lift', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/ultimate-sash-lift.jpg'],
                    ],
                ],
                [
                    'name' => 'Acorn furniture',
                    'model' => 'Heritage Rose and Charisma Rose',
                    'tagline' => 'Standard Heritage and Charisma hardware',
                    'copy' => 'Acorn furniture comes as standard on Heritage Rose and Charisma Rose, keeping the hardware sash-specific without stepping up to the Ultimate-only Globe range.',
                    'items' => [
                        ['name' => 'Acorn Lock', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/acorn-lock.jpg'],
                        ['name' => 'Acorn Tilt Knob', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/acorn-tilt-knob.jpg'],
                        ['name' => 'Acorn Pole Eye', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/acorn-pole-eye.jpg'],
                        ['name' => 'Acorn Sash Lift', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/acorn-sash-lift.jpg'],
                    ],
                ],
                [
                    'name' => 'Extra furniture',
                    'model' => 'Survey-led extras',
                    'tagline' => 'Additional sash furniture options',
                    'copy' => 'Extra options include a Shark Fin limit stop and D Handle, useful where the sash specification needs additional control or operation detail.',
                    'items' => [
                        ['name' => 'Shark Fin Limit Stop', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/shark-fin-lock.jpg'],
                        ['name' => 'D Handle', 'image' => '/wp-content/themes/fenster/assets/images/products/sash-roseview/d-handle.jpg'],
                    ],
                ],
            ],
        ],
        'window_handles' => [
            'slugs' => [
                'aluminium-windows',
                'aluminium-flush-windows',
                'heritage-windows',
                'casement-windows',
                'flush-casement-windows',
            ],
            'intro' => 'Fenster window specifications can include the S2 Signature cranked handle range, chosen for a sculpted low-profile shape, lockable operation as standard and a choice of finishes. The handle is available in left-hand and right-hand variants so the operation can be matched to the window layout.',
            'features' => [
                ['title' => 'Push-to-release', 'copy' => 'Flush-fitting release button with a clean, sculptured handle shape.'],
                ['title' => 'Lockable as standard', 'copy' => 'The range uses the same lockable handle model across the core finish options.'],
                ['title' => 'Finishes are coordinated', 'copy' => 'Button and screw cover cap are matched to the selected hardware finish.'],
            ],
            'finishes' => [
                [
                    'name' => 'White',
                    'label' => 'Premium White Powder Coat',
                    'hex' => '#f4f4ef',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-white-finish.png',
                    'copy' => 'A crisp, low-contrast choice for white uPVC, pale frames and classic casement window installations.',
                ],
                [
                    'name' => 'Black',
                    'label' => 'Premium Black Powder Coat',
                    'hex' => '#111313',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-black-finish.png',
                    'copy' => 'A strong contemporary finish that works well with black, anthracite and contrast-led window designs.',
                ],
                [
                    'name' => 'Chrome',
                    'label' => 'Premium Chrome Plate',
                    'hex' => '#d7dce0',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-chrome-finish.png',
                    'copy' => 'A bright reflective finish for a cleaner polished detail, especially where other interior hardware is chrome.',
                ],
                [
                    'name' => 'Gold',
                    'label' => 'Premium Gold Electroplate',
                    'hex' => '#c8a545',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-gold-finish.png',
                    'copy' => 'A traditional warmer finish often suited to heritage-style rooms, sash windows and period-inspired choices.',
                ],
                [
                    'name' => 'Satin Silver',
                    'label' => 'Premium Satin Silver Electroplate',
                    'hex' => '#77756d',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-titanium-finish.png',
                    'copy' => 'A softer metallic option that sits between chrome and black for restrained contemporary schemes.',
                ],
                [
                    'name' => 'Monkey Tail',
                    'label' => 'Traditional Monkey Tail Handle',
                    'hex' => '#1f2325',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles/monkey-tail-handle.png',
                    'copy' => 'A more traditional handle style for heritage-led windows, subject to the selected window system and final specification.',
                ],
            ],
            'technical' => [
                ['label' => 'Handing', 'value' => 'Left-hand and right-hand variants'],
                ['label' => 'Locking', 'value' => 'Lockable as standard'],
                ['label' => 'Cycle testing', 'value' => '10,000 cycles under operational load'],
                ['label' => 'Corrosion rating', 'value' => 'BS EN 1670 Grade 5'],
                ['label' => 'Materials', 'value' => 'Zinc alloy and ABS-757 resin'],
            ],
            'technical_intro' => 'The S2 Signature handle is tested and specified as proper window hardware, not a decorative afterthought.',
        ],
        /* The canonical order process. One source, because this rail appears on
           product pages, town pages, the MK head-term page, About and the trust
           page, and those had drifted into six different descriptions of the
           same job. Corrected against the real process on 2026-07-29: two ways
           in, then a technical survey that exists to get manufacture right
           rather than to revisit choices, then installation, then aftercare.
           The guarantee line is scoped to new windows and doors on purpose,
           because this rail also renders on repairs, roofline, integral blinds
           and pet flaps, which sit outside it. Commercial and pet flaps pass
           their own steps; everything else uses these. */
        'order_process' => [
            'eyebrow' => 'Order process',
            'heading' => 'A clear process from first quote to aftercare.',
            'intro' => 'Four steps. The first one has two ways in: price it yourself online, or have us come out. After that it runs the same either way.',
            'steps' => [
                ['step' => '01', 'title' => 'Your price', 'copy' => 'Price it yourself on the online tool, or book a free consultation and we build the same quote with you. Both run on the same price list, so the figure matches.'],
                ['step' => '02', 'title' => 'Technical survey', 'copy' => 'Once you go ahead we survey before anything is made. Not a second sales visit: the measurements, thresholds and fixings the factory needs to build it right.'],
                ['step' => '03', 'title' => 'Installation', 'copy' => 'Fitted by our own installers rather than subcontractors, trained on the systems we sell and working carefully in a house someone lives in. We clear up after ourselves before we leave.'],
                ['step' => '04', 'title' => 'Aftercare', 'copy' => 'A ten year insurance-backed guarantee through the CPA on new windows and doors, and your FENSA certificate sent direct. Anything afterwards, you ring us, not a call centre.'],
            ],
        ],
        /* greenteQ Alpha TBT, the tilt and turn handle. Facts are from the VBH
           product bulletin PB_CUS_greenteQ_Alpha_TBT_Handle_101125 (10/11/25).
           We fit the locking version only, owner instruction 2026-07-29, and
           only these five of the eight greenteQ Suite finishes. The two
           guarantees are greenteQ's on the handle itself and are nothing to do
           with the Fenster ten year installation guarantee: keep them
           attributed so the two are never read as the same thing.
           Imagery: see the note in AI.md before replacing it. */
        'tilt_turn_handles' => [
            'slugs' => ['tilt-turn-windows'],
            /* Two things are true and the copy has to hold both. The handle
               position selects tilt or turn; the key does not. But the key has
               a middle position that limits how far the handle can go, so the
               window will tilt and will not swing open. Owner correction on
               the first, owner-verified on the second: he tested the tilt-safe
               setting on a real window on 2026-07-29 after the VBH bulletin
               described it. Do not let a later edit collapse these back into
               "the key decides how far the window opens", which is what was
               wrong the first time. */
            'intro' => 'Tilt and turn windows take their own handle, because one lever has to do two jobs. Turn it one way and the top tilts inwards for air. Turn it further and the whole sash swings in.',
            'features' => [
                ['title' => 'Two positions, one lever', 'copy' => 'A quarter turn tilts the top inwards for ventilation. Carry on turning and the whole sash swings right in, so the outside face can be cleaned from indoors.'],
                ['title' => 'It can tilt without opening', 'copy' => 'Leave the key a quarter turn and the handle still reaches tilt, but it will not go round to the full opening. The window ventilates without being able to swing open, which is the setting for a bedroom or anything above a drop.'],
                ['title' => 'Locked means locked', 'copy' => 'Turned fully, the key stops the handle moving at all and blocks the hardware being worked from outside. The handle carries the Police Preferred Specification for Secured by Design.'],
            ],
            'technical_intro' => 'greenteQ Alpha TBT, locking version.',
            /* Spindle length and fixing centres were dropped on owner
               instruction, 2026-07-29. They are fitter numbers, not customer
               ones, and nobody choosing a handle needs them. They stay in the
               bulletin if they are ever wanted. */
            'technical' => [
                ['label' => 'Operation', 'value' => 'Tilt and turn from one lever'],
                ['label' => 'Key settings', 'value' => 'Unlocked, tilt only, locked'],
                ['label' => 'Security', 'value' => 'Secured by Design, Police Preferred Specification'],
                ['label' => 'Surface guarantee', 'value' => '20 years, from greenteQ'],
                ['label' => 'Mechanical guarantee', 'value' => '10 years, from greenteQ'],
            ],
            'finishes' => [
                [
                    'name' => 'White',
                    'label' => 'White tilt and turn handle',
                    'hex' => '#f4f4f1',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-tilt-turn/tilt-turn-white.png',
                    'copy' => 'The default on white frames, and the one that disappears against them.',
                ],
                [
                    'name' => 'Black',
                    'label' => 'Black tilt and turn handle',
                    'hex' => '#141414',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-tilt-turn/tilt-turn-black.png',
                    'copy' => 'Reads as deliberate against anthracite and black foiled frames rather than as a compromise.',
                ],
                [
                    'name' => 'Gold',
                    'label' => 'PVD gold tilt and turn handle',
                    'hex' => '#c8a13c',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-tilt-turn/tilt-turn-gold.png',
                    'copy' => 'A warm brass tone for period frontages, on a PVD finish rather than a lacquer.',
                ],
                [
                    'name' => 'Chrome',
                    'label' => 'Polished chrome tilt and turn handle',
                    'hex' => '#d5d8da',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-tilt-turn/tilt-turn-chrome.png',
                    'copy' => 'Bright and reflective, which suits a room where the other ironmongery is polished.',
                ],
                [
                    'name' => 'Satin Silver',
                    'label' => 'Satin tilt and turn handle',
                    'hex' => '#a9adb0',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-tilt-turn/tilt-turn-satin-silver.png',
                    'copy' => 'The muted metallic, bright without the mirror. The most common choice on grey frames.',
                ],
            ],
        ],
        'door_handles' => [
            /* Owner instruction, 2026-07-29: these four routes only. French
               doors and aluminium sliding doors came off, because those
               systems do not take the long-plate handle. */
            'slugs' => [
                'composite-doors',
                'upvc-doors',
                'aluminium-doors',
                'heritage-aluminium-doors',
            ],
            'intro' => 'Pick a handle finish that works with your frame colour, letterplate and locking needs. These long-plate handles cover the popular finishes; we confirm the exact compatible hardware with your chosen door system before ordering.',
            'features' => [
                ['title' => 'Long-plate format', 'copy' => 'A full backplate gives the handle a strong, complete look on entrance and French door styles.'],
                ['title' => 'Cylinder-ready design', 'copy' => 'The visible key aperture keeps lock and cylinder planning part of the same hardware decision.'],
                ['title' => 'Finish coordination', 'copy' => 'Choose a handle finish that works with frame colour, letterplates, hinges, thresholds and other external details.'],
            ],
            'finishes' => [
                [
                    'name' => 'Black',
                    'label' => 'Black long-plate handle',
                    'hex' => '#111313',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/black-long-plate.png',
                    'copy' => 'A sharp modern finish for black, anthracite and contrast-led door specifications.',
                ],
                [
                    'name' => 'White',
                    'label' => 'White long-plate handle',
                    'hex' => '#f2f2ee',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/white-long-plate.png',
                    'copy' => 'A clean, low-contrast option for white uPVC doors and lighter internal finishes.',
                ],
                [
                    'name' => 'Antique Black',
                    'label' => 'Antique black long-plate handle',
                    'hex' => '#18202a',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/textured-black-long-plate.png',
                    'copy' => 'A darker textured finish that adds subtle surface detail to contemporary door sets.',
                ],
                [
                    'name' => 'Anthracite',
                    'label' => 'Anthracite long-plate handle',
                    'hex' => '#323940',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/anthracite-long-plate.png',
                    'copy' => 'A softer dark finish for anthracite grey frames, aluminium systems and modern entrances.',
                ],
                [
                    'name' => 'Satin Silver',
                    'label' => 'Satin silver long-plate handle',
                    'hex' => '#c9ced0',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/satin-silver-long-plate.png',
                    'copy' => 'A muted metallic finish that keeps the handle bright without a mirror-polished look.',
                ],
                [
                    'name' => 'Brushed Steel',
                    'label' => 'Brushed steel long-plate handle',
                    'hex' => '#b8afa2',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/brushed-steel-long-plate.png',
                    'copy' => 'A warmer brushed metallic finish for doors where the hardware should feel tactile and substantial.',
                ],
                [
                    'name' => 'Chrome',
                    'label' => 'Chrome long-plate handle',
                    'hex' => '#edf0f2',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/chrome-long-plate.png',
                    'copy' => 'A polished reflective finish when the door hardware should feel brighter and more decorative.',
                ],
                [
                    'name' => 'Gold',
                    'label' => 'Gold long-plate handle',
                    'hex' => '#d2a72d',
                    'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/gold-long-plate.png',
                    'copy' => 'A warmer traditional finish for classic front doors, heritage styling and period-inspired choices.',
                ],
            ],
            'technical' => [
                ['label' => 'Format', 'value' => 'Lever on long backplate'],
                ['label' => 'Lock prep', 'value' => 'Cylinder aperture shown'],
                ['label' => 'Suitable for', 'value' => 'Entrance, French and patio door specifications'],
                ['label' => 'Finish check', 'value' => 'Confirmed against the selected door system'],
            ],
            'technical_intro' => 'Door handle availability depends on the chosen door system, lock set and colour package, so we confirm the final compatible hardware at specification stage.',
        ],
        /* Mila ProLinea, the uPVC sliding patio door handle. This is the fourth
           handle family and closes the "patio to come" note left on the handle
           hub when it was built on 2026-07-29.

           A sliding patio door cannot take the long-plate handle on
           `door_handles`: that is a lever on a backplate for a door on hinges,
           and a slider needs a fixed D-pull you brace against to move the sash.
           So this is its own family rather than another entry in that list, for
           the same reason tilt and turn is its own family.

           Facts are from the Mila ProLinea Patio Door Handle literature
           (milasecure.com). We fit five of the six finishes; Smokey Chrome is
           deliberately not offered, owner instruction 2026-08-02.

           Mila's own names for three of ours are Polished Gold, Polished Chrome
           and Smooth Satin Chrome. The customer-facing names here match the
           other three handle families instead, so someone comparing a window
           handle with a patio handle sees the same five words. Do not "correct"
           them against the literature; that is the same rule already recorded
           against the greenteQ bulletin. */
        'patio_handles' => [
            'slugs' => ['patio-doors'],
            'intro' => 'A sliding patio door takes a different handle from a door on hinges. There is no lever to turn: the long D-shaped pull is what you brace against to move the sash, so it is fixed to the door and shaped for a full hand rather than fingertips.',
            'features' => [
                ['title' => 'Shaped for pulling, not turning', 'copy' => 'A sliding sash is heavy and moves sideways, so the handle is a long D-pull you can get a whole hand around rather than a lever. It is the same shape inside and out.'],
                ['title' => 'Handed to suit the door', 'copy' => 'The handle is reversible, so it fits whichever way your doors slide. We set the handing at survey rather than asking you to work it out.'],
                ['title' => 'Locks through the same plate', 'copy' => 'The cylinder sits in the backplate below the pull, so locking and lifting are the same piece of hardware rather than two things bolted to the door.'],
            ],
            'technical_intro' => 'Mila ProLinea patio door handle.',
            /* The six lever, blind and blank combinations in the literature are
               a fitter's choice about which side gets a key and which gets a
               fixed pull. It is settled at survey from how the doors are used,
               so it is not on the page. Recorded here so it does not have to be
               looked up again. */
            'technical' => [
                ['label' => 'Format', 'value' => 'Long D-pull on a backplate'],
                ['label' => 'Handing', 'value' => 'Reversible, left or right'],
                ['label' => 'Materials', 'value' => 'Aluminium painted, zinc plated'],
                ['label' => 'Cycle testing', 'value' => '50,000 cycles, independently tested'],
                ['label' => 'Weather resistance', 'value' => 'Salt spray tested to 240 hours plated, 480 powder coated'],
            ],
            /* Photography is Mila's own, from the literature linked above, at
               its native 299x307. The five share one framing because they came
               off one sheet, which is the same reason the heritage door
               configurations and the tilt and turn finishes are not re-cropped
               individually. Do not re-trim them one at a time.

               Hexes are the swatch fallback only, and are the values already
               used for these five finish names on the tilt and turn handle, so
               the chip behind a loading image is consistent between families. */
            'finishes' => [
                [
                    'name' => 'White',
                    'label' => 'White patio door handle',
                    'hex' => '#f4f4f1',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-patio/patio-white.webp',
                    'copy' => 'The default on white frames, and the one most people pick without thinking about it.',
                ],
                [
                    'name' => 'Black',
                    'label' => 'Black patio door handle',
                    'hex' => '#141414',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-patio/patio-black.webp',
                    'copy' => 'Reads as deliberate against anthracite and black foiled frames, and hides marks better than a pale finish on a door this often used.',
                ],
                [
                    'name' => 'Chrome',
                    'label' => 'Polished chrome patio door handle',
                    'hex' => '#d5d8da',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-patio/patio-chrome.webp',
                    'copy' => 'Bright and reflective, which suits a room where the other ironmongery is polished.',
                ],
                [
                    'name' => 'Gold',
                    'label' => 'Polished gold patio door handle',
                    'hex' => '#c8a13c',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-patio/patio-gold.webp',
                    'copy' => 'A warm brass tone, usually chosen to match existing door furniture rather than the frame.',
                ],
                [
                    'name' => 'Satin Silver',
                    'label' => 'Smooth satin chrome patio door handle',
                    'hex' => '#a9adb0',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-patio/patio-satin-silver.webp',
                    'copy' => 'The muted metallic, bright without the mirror. It shows fingerprints least of the five.',
                ],
            ],
        ],
        /* The fifth handle family: architeQ Aspire lift/slide furniture on
           /aluminium-sliding-doors/. It is its own family and must not be
           merged into patio_handles, which is the Mila ProLinea for uPVC
           sliders. A lift/slide sash is raised off its seals before it moves,
           so it takes a geared lever rather than a fixed D-pull, and the owner
           confirmed on 2026-08-02 that the ProLinea does not go on this route.

           Facts come from the VBH product bulletin
           PB_CUS_architeQ_Aspire_Suite_Lift-Slide_Door_Furniture_181125.
           Deliberately not shown to customers, the same way the greenteQ
           spindle and fixing centres are not: VBH order codes, spindle and
           fixing-pack lengths, the with/without cylinder-hole variants and the
           Hi-Grip option, where the lever stands 11mm further off the sash for
           clearance. Those are fitter choices. Recorded here so they do not
           have to be looked up again.

           Finish imagery: three are VBH's own renders lifted from the bulletin,
           Anthracite, Black and Chrome. VBH publish no White lever and no
           brushed lever, so those two are derived from the renders that do
           exist: White from the black lever, Brushed from the polished one with
           its tonal range compressed to satin. Owner instruction, 2026-08-03,
           to make the assets rather than ship colour blocks, which is the same
           decision already recorded for the tilt and turn finishes where the
           imagery is generated and the owner accepted it.

           All five were padded onto one shared canvas before scaling, so the
           handles are the same size as each other. Do not re-trim them
           individually: the same rule already applies to the heritage door
           configurations, the tilt and turn finishes and the Mila patio set.
           Replace the two derived files the moment VBH publish real ones. */
        'lift_slide_handles' => [
            'slugs' => ['aluminium-sliding-doors'],
            'intro' => 'A lift and slide door is not moved like a patio slider. The lever lifts the sash off its seals before it rolls, so the handle is geared rather than fixed, and the two faces of the door do different jobs: a lever on the inside, a flush finger cup on the outside.',
            'features' => [
                ['title' => 'A lever inside, a cup outside', 'copy' => 'The lever does the lifting and sliding from indoors. Outside takes a finger cup set flush into the sash, so nothing projects into the opening you have just spent money widening. The outer face can also be left blank if you never open the door from the garden.'],
                ['title' => 'Geared for the weight', 'copy' => 'The lever runs to 250mm, which is what gives you the leverage to move a sash weighing up to 400kg, depending on the gear it is built with. A spring locates it positively in both the closed and the slide position, so it does not drift between the two.'],
                ['title' => 'One handle or two', 'copy' => 'Fitted inside only with a finger cup opposite, or through-fixed back to back as a pair so the door works from either side. Which you want depends on whether the outside face is a way in or just a way out.'],
            ],
            'technical_intro' => 'architeQ Aspire lift and slide door furniture.',
            'technical' => [
                ['label' => 'Inside', 'value' => '250mm lever on a rounded backplate'],
                ['label' => 'Outside', 'value' => 'Flush finger cup, or a second lever back to back'],
                ['label' => 'Sash weight', 'value' => 'Up to 400kg, depending on the gear'],
                ['label' => 'Security', 'value' => 'Secured by Design Police Preferred Specification'],
                ['label' => 'Surface guarantee', 'value' => '25 years, from architeQ'],
            ],
            /* Hexes match the values already used for these finish names on the
               other families, so a chip reads the same across the site. White
               takes a hairline in the grid for the reason Smooth White does on
               the colour rail: a near-white swatch on a white card reads as an
               empty slot. Chrome is VBH's Polished Stainless Steel; the name
               follows the site rather than the supplier, owner-confirmed
               2026-08-03, which is the rule already recorded against the Mila
               and greenteQ literature. */
            'finishes' => [
                [
                    'name' => 'Anthracite',
                    'label' => 'Anthracite lift and slide door handle',
                    'hex' => '#383b3d',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-liftslide/liftslide-anthracite.webp',
                    'copy' => 'The one that disappears into an anthracite frame, which is what most aluminium sliders are specified in.',
                ],
                [
                    'name' => 'Black',
                    'label' => 'Black lift and slide door handle',
                    'hex' => '#141414',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-liftslide/liftslide-black.webp',
                    'copy' => 'Flatter and darker than anthracite. It reads as a deliberate choice rather than a match.',
                ],
                [
                    'name' => 'White',
                    'label' => 'White lift and slide door handle',
                    'hex' => '#f4f4f1',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-liftslide/liftslide-white.webp',
                    'copy' => 'For a white frame, and the quietest of the five against a pale interior.',
                ],
                [
                    'name' => 'Chrome',
                    'label' => 'Polished chrome lift and slide door handle',
                    'hex' => '#d5d8da',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-liftslide/liftslide-chrome.webp',
                    'copy' => 'A mirror finish that picks up the room. It shows marks more than the brushed one on a door this often used.',
                ],
                [
                    'name' => 'Brushed stainless steel',
                    'label' => 'Brushed stainless steel lift and slide door handle',
                    'hex' => '#b9bcbd',
                    'image' => '/wp-content/themes/fenster/assets/images/products/handles-liftslide/liftslide-brushed-stainless-steel.webp',
                    'copy' => 'The same metal without the mirror, so fingerprints and daylight both sit softer on it.',
                ],
            ],
        ],
        'obscure_glass' => [
            'intro' => 'Obscured glass adds privacy while still letting daylight through. Use the preview to compare how the same real image changes behind each texture before choosing door glass, bathroom glass, side panels or replacement units.',
            'legend_image' => '/wp-content/themes/fenster/assets/team/legend-colour.webp',
            'house_image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/birkacre-house.webp',
            'textures' => [
                ['name' => 'Cotswold', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Cotswold-pilkington.png', 'copy' => 'Heavy distortion for high privacy while retaining a traditional textured feel.'],
                /* Satin is a sandblasted finish, so it is grain rather than lines. This
                   entry used to be a hand-drawn repeating-linear-gradient, which read as
                   pinstripe and contradicted its own description on a customer-facing
                   page. feTurbulence is what actually looks sandblasted. */
                ['name' => 'Satin', 'privacy' => 5, 'texture' => 'url("data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2760%27 height=%2760%27%3E%3Cfilter id=%27s%27%3E%3CfeTurbulence type=%27fractalNoise%27 baseFrequency=%270.9%27 numOctaves=%274%27 stitchTiles=%27stitch%27/%3E%3CfeColorMatrix type=%27saturate%27 values=%270%27/%3E%3C/filter%3E%3Crect width=%2760%27 height=%2760%27 filter=%27url(%23s)%27 opacity=%270.55%27/%3E%3C/svg%3E"), radial-gradient(circle at 30% 26%, rgba(255,255,255,0.95), rgba(255,255,255,0) 58%), linear-gradient(135deg, #f6fbfb, #e3eff0)', 'copy' => 'Plain satin frosting for maximum privacy with a clean, minimal finish.'],
                ['name' => 'Arctic', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Arctic-privacy-5.webp', 'copy' => 'A strong frosted texture for maximum privacy with a clean, bright look.'],
                ['name' => 'Autumn', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Autumn-privacy-3.webp', 'copy' => 'Soft organic movement that keeps the view diffused without feeling too heavy.'],
                ['name' => 'Cassini', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Cassini-privacy-5.webp', 'copy' => 'High privacy with a subtle directional texture and a modern finish.'],
                ['name' => 'Chantilly', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Chantilly-privacy-2.webp', 'copy' => 'Decorative and lighter in privacy, useful where pattern matters as much as screening.'],
                ['name' => 'Charcoal Sticks', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Charcoal-Sticks-privacy-4.webp', 'copy' => 'A sharper linear pattern that gives strong screening and a distinctive style.'],
                ['name' => 'Contora', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Contora-privacy-4.webp', 'copy' => 'A classic obscure pattern with confident privacy for everyday glazing.'],
                ['name' => 'Digital', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Digital-privacy-3.webp', 'copy' => 'A crisp modern texture with medium privacy and a more architectural look.'],
                ['name' => 'Everglade', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Everglade-privacy-5.webp', 'copy' => 'Dense texture for stronger privacy in exposed or overlooked glazing.'],
                ['name' => 'Florielle', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Florielle-privacy-4.webp', 'copy' => 'A floral pattern that balances decoration with a useful level of screening.'],
                ['name' => 'Mayflower', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Mayflower-privacy-4.webp', 'copy' => 'Traditional patterning for entrance doors, side panels and character properties.'],
                ['name' => 'Minster', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Minster-privacy-2.webp', 'copy' => 'A lighter traditional texture where soft distortion is enough.'],
                ['name' => 'Oak', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Oak-privacy-4.webp', 'copy' => 'Leaf-like movement with strong privacy and a warmer decorative feel.'],
                ['name' => 'Pelerine', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Pelerine-privacy-4.webp', 'copy' => 'Flowing vertical texture for privacy with a quieter, more elegant pattern.'],
                ['name' => 'Reeded', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Reeded-privacy-2.webp', 'copy' => 'Linear ribbing with partial screening and a timeless architectural finish.'],
                ['name' => 'Stippolyte', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Stippolyte-privacy-4.webp', 'copy' => 'Fine broken texture that gives reliable privacy without a large pattern.'],
                ['name' => 'Sycamore', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Sycamore-privacy-2.webp', 'copy' => 'A lighter patterned option for softer privacy and decorative daylight.'],
                ['name' => 'Taffeta', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Taffeta-privacy-3.webp', 'copy' => 'Medium privacy with a woven texture that feels subtle from a distance.'],
                ['name' => 'Tribal', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Tribal-privacy-5.webp', 'copy' => 'High privacy with a bolder decorative pattern for statement glass.'],
                ['name' => 'Warwick', 'privacy' => 0, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Warwick-privacy-0.webp', 'copy' => 'A handmade-style texture with character, but it is not a privacy glass choice.'],
            ],
        ],
        'colour_options' => [
            'intro' => 'Frame colour changes how a window or door sits against brick, render, roofline and hardware. The two materials get their colour in completely different ways, which is worth knowing before you choose: uPVC is finished with a foil bonded to the profile, aluminium is powder coated. Both can be a different colour inside and out.',
            'materials' => [
                'upvc' => [
                    'label' => 'uPVC colours',
                    'slug' => 'upvc-colours',
                    'headline' => 'uPVC colours.',
                    'copy' => 'A uPVC colour is a foil, bonded to the profile at the factory rather than painted on afterwards. That is why the woodgrains have a grain you can feel, and why the colour does not need repainting. The frame underneath stays white, so you will see white on the rebate when the window is open unless the foil is specified on both faces.',
                    'colours' => [
                        /* Smooth white is the unfoiled profile, so there is no swatch
                           photograph of it. It was borrowing the foiled White image,
                           which showed the wrong finish under the wrong name. No image
                           means the carousel falls back to the flat hex block, the same
                           way Hipca Gloss White already does. */
                        ['name' => 'Smooth White', 'hex' => '#ffffff', 'finish' => 'No foil, RAL 9003'],
                        ['name' => 'White', 'finish' => 'Foil, RAL 9010', 'hex' => '#f7f6ef', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-White-weiss.webp'],
                        ['name' => 'Cream', 'finish' => 'Foil, RAL 9001', 'hex' => '#efe6d0', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Cream-Cremeweiss.webp'],
                        ['name' => 'Chartwell Green', 'finish' => 'Foil', 'hex' => '#b7c8b6', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Chartwell-green.webp'],
                        ['name' => 'Irish Oak', 'finish' => 'Foil', 'hex' => '#c3a36f', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Irish-Oak.webp'],
                        ['name' => 'Golden Oak', 'finish' => 'Foil, RAL 8001', 'hex' => '#9a5b25', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Golden-Oak.webp'],
                        ['name' => 'Rosewood', 'finish' => 'Foil', 'hex' => '#4d211b', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Rosewood.webp'],
                        ['name' => 'Anthracite Grey', 'finish' => 'Foil, RAL 7016', 'hex' => '#353b3f', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-7016-SM-Grey.webp'],
                        ['name' => 'Black Brown', 'finish' => 'Foil, RAL 8022', 'hex' => '#211d1a', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Black-brown-Schwarzbraun.webp'],
                        ['name' => 'Agate Grey', 'finish' => 'Foil, RAL 7038', 'hex' => '#c2c8bd', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Agate-grey-7038.webp'],
                        ['name' => 'Silver Grey', 'finish' => 'Foil, RAL 7001', 'hex' => '#8d8f8c', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-7155-Grey-Silver-Grey.webp'],
                        ['name' => 'Basalt Grey', 'finish' => 'Foil, RAL 7012', 'hex' => '#555a5b', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-7012-basalt-grey.webp'],
                        ['name' => 'Slate Grey', 'finish' => 'Foil, RAL 7015', 'hex' => '#4f5554', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Slate-grey-7015-grey.webp'],
                        ['name' => 'Gale Grey Finesse (Anthracite Smooth)', 'finish' => 'Foil, RAL 7016', 'hex' => '#8b918e', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Gale-Grey-finesse.webp'],
                        ['name' => 'Blue', 'finish' => 'Foil, RAL 5011', 'hex' => '#243b64', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Blue.webp'],
                        ['name' => 'Dark Green', 'finish' => 'Foil, RAL 6009', 'hex' => '#17382a', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Dark-green.webp'],
                        ['name' => 'Dark Red', 'finish' => 'Foil, RAL 3011', 'hex' => '#702827', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/liniar-swatches/colours_page_image-Dark-red.webp'],
                    ],
                ],
                'aluminium' => [
                    'label' => 'Aluminium colours',
                    'slug' => 'aluminium-colours',
                    'headline' => 'Aluminium colours.',
                    'copy' => 'Aluminium is powder coated: dry pigment sprayed onto the profile and baked on, so the colour is part of the surface rather than a layer sitting on it. The finish is quoted as a RAL number with a matt, satin or gloss level, which is why these read as codes rather than names. Dual colour means two separate coats, one on each face.',
                    'colours' => [
                        ['name' => 'Pure White', 'hex' => '#f7f7f2', 'finish' => 'RAL 9010 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Pure-White-600.jpg'],
                        ['name' => 'Hipca Gloss White', 'hex' => '#ffffff', 'finish' => 'RAL 9910 Gloss', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Gloss-White-600.jpg'],
                        ['name' => 'Anthracite Grey', 'hex' => '#353b3f', 'finish' => 'RAL 7016 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Anthracite-600.jpg'],
                        ['name' => 'Jet Black', 'hex' => '#111111', 'finish' => 'RAL 9005 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Black-600.jpg'],
                        ['name' => 'Cream', 'hex' => '#efe6d0', 'finish' => 'RAL 9001 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Cream-600.jpg'],
                        // Owner-confirmed 2026-08-02: Agate Grey is RAL 7038.
                        // This said 7018, which is Umbra Grey, and disagreed
                        // with the heritage door page's own list.
                        ['name' => 'Agate Grey', 'hex' => '#b4bbb3', 'finish' => 'RAL 7038 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Agate-600.jpg'],
                        ['name' => 'Squirrel Grey', 'hex' => '#8f9187', 'finish' => 'RAL 7000 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Squirrel-600.jpg'],
                        ['name' => 'Pastel Turquoise', 'hex' => '#7facad', 'finish' => 'RAL 6034 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Turquoise-600.jpg'],
                        ['name' => 'Chocolate Brown', 'hex' => '#4d352b', 'finish' => 'RAL 8017 Matt', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Brown-600.jpg'],
                        ['name' => 'Silver Metallic', 'hex' => '#a7acaf', 'finish' => 'Metallic effect', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Silver-Metallic-Effect-600.jpg'],
                        ['name' => 'Mid Bronze Metallic', 'hex' => '#6b5746', 'finish' => 'Metallic effect', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Mid-Bronze-Metallic-Effect-600.jpg'],
                        ['name' => 'Black Metallic', 'hex' => '#1e1f20', 'finish' => 'Metallic effect', 'image' => '/wp-content/themes/fenster/assets/images/products/colours/sheerline/Classic-Corner-Black-Metallic-Effect-600.jpg'],
                        ['name' => 'Any RAL Colour', 'hex' => 'conic-gradient(from 45deg, #e43d30, #f5c542, #43a047, #1e88e5, #7b1fa2, #e43d30)', 'finish' => 'Matched powder-coated finish, confirmed by sample'],
                    ],
                ],
                'composite' => [
                    'label' => 'Composite door colours',
                    'slug' => 'composite-door-colours',
                    'headline' => 'Composite door colours.',
                    /* Paint samples, not door photographs. Owner instruction,
                       2026-07-29: show the same painted tiles as the composite
                       doors page, which is the real Distinction range rather
                       than a shortlist of photographed doors. Hex values are
                       sampled from each tile, so the fallback chip matches the
                       paint instead of being eyeballed. */
                    'copy' => 'A mix of standard colours and RAL matches, shown as the paint itself rather than as a flat colour. The standard range runs wider than this, and any RAL colour can be matched beyond it, so if you have a shade in mind it is worth asking. A screen will always shift a tone, so the doors are worth seeing at the showroom.',
                    'colours' => [
                        /* Owner instruction, 2026-07-29: "white is white". Distinction did not
                           supply a white in the sampled range, so this is a flat swatch at the
                           same tone as Smooth White uPVC, RAL 9003. Replace it if their white
                           turns out to carry a tint. */
                        ['name' => 'Standard White', 'hex' => '#ffffff', 'slug' => 'standard-white', 'finish' => 'Standard colour', 'alt' => 'Standard White paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/standard-white-320w.webp'],
                        ['name' => 'Standard Black', 'hex' => '#181818', 'slug' => 'standard-black', 'finish' => 'Standard colour', 'alt' => 'Standard Black paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/standard-black-320w.webp'],
                        ['name' => 'Standard Blue', 'hex' => '#333d49', 'slug' => 'standard-blue', 'finish' => 'Standard colour', 'alt' => 'Standard Blue paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/standard-blue-320w.webp'],
                        ['name' => 'Standard Green', 'hex' => '#233a27', 'slug' => 'standard-green', 'finish' => 'Standard colour', 'alt' => 'Standard Green paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/standard-green-320w.webp'],
                        ['name' => 'Standard Red', 'hex' => '#8d1d21', 'slug' => 'standard-red', 'finish' => 'Standard colour', 'alt' => 'Standard Red paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/standard-red-320w.webp'],
                        ['name' => 'Gold Oak', 'hex' => '#7e5011', 'slug' => 'gold-oak', 'finish' => 'Woodgrain stain', 'alt' => 'Gold Oak paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/gold-oak-320w.webp'],
                        ['name' => 'Rosewood', 'hex' => '#71342b', 'slug' => 'rosewood', 'finish' => 'Woodgrain stain', 'alt' => 'Rosewood paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/rosewood-320w.webp'],
                        ['name' => 'Anthracite Grey', 'hex' => '#384145', 'slug' => 'anthracite-grey', 'finish' => 'Standard colour', 'alt' => 'Anthracite Grey paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/anthracite-grey-320w.webp'],
                        ['name' => 'Chartwell Green', 'hex' => '#8da286', 'slug' => 'chartwell-green', 'finish' => 'Standard colour', 'alt' => 'Chartwell Green paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/chartwell-green-320w.webp'],
                        ['name' => 'Slate Grey', 'hex' => '#494d50', 'slug' => 'slate-grey', 'finish' => 'Standard colour', 'alt' => 'Slate Grey paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/slate-grey-320w.webp'],
                        ['name' => 'Basalt Grey', 'hex' => '#54554c', 'slug' => 'basalt-grey', 'finish' => 'Standard colour', 'alt' => 'Basalt Grey paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/basalt-grey-320w.webp'],
                        ['name' => 'Buckingham Grey', 'hex' => '#6d6b65', 'slug' => 'buckingham-grey', 'finish' => 'Standard colour', 'alt' => 'Buckingham Grey paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/buckingham-grey-320w.webp'],
                        ['name' => 'Steel Blue', 'hex' => '#142740', 'slug' => 'steel-blue', 'finish' => 'Standard colour', 'alt' => 'Steel Blue paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/steel-blue-320w.webp'],
                        ['name' => 'Black Brown', 'hex' => '#1e1a19', 'slug' => 'black-brown', 'finish' => 'Standard colour', 'alt' => 'Black Brown paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/black-brown-320w.webp'],
                        ['name' => 'Pale Green', 'hex' => '#96a97c', 'slug' => 'pale-green', 'finish' => 'RAL 6021', 'alt' => 'Pale Green paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/pale-green-320w.webp'],
                        ['name' => 'Leaf Green', 'hex' => '#3f7c2e', 'slug' => 'leaf-green', 'finish' => 'RAL 6002', 'alt' => 'Leaf Green paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/leaf-green-320w.webp'],
                        ['name' => 'Distant Blue', 'hex' => '#4075ac', 'slug' => 'distant-blue', 'finish' => 'RAL 5023', 'alt' => 'Distant Blue paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/distant-blue-320w.webp'],
                        ['name' => 'Ultramarine Blue', 'hex' => '#1b3e8d', 'slug' => 'ultramarine-blue', 'finish' => 'RAL 5002', 'alt' => 'Ultramarine Blue paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/ultramarine-blue-320w.webp'],
                        ['name' => 'Turquoise Blue', 'hex' => '#48a99f', 'slug' => 'turquoise-blue', 'finish' => 'RAL 5018', 'alt' => 'Turquoise Blue paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/turquoise-blue-320w.webp'],
                        ['name' => 'Traffic Red', 'hex' => '#c51a16', 'slug' => 'traffic-red', 'finish' => 'RAL 3020', 'alt' => 'Traffic Red paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/traffic-red-320w.webp'],
                        ['name' => 'Wine Red', 'hex' => '#53010f', 'slug' => 'wine-red', 'finish' => 'RAL 3005', 'alt' => 'Wine Red paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/wine-red-320w.webp'],
                        ['name' => 'Telemagenta', 'hex' => '#d54389', 'slug' => 'telemagenta', 'finish' => 'RAL 4010', 'alt' => 'Telemagenta paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/telemagenta-320w.webp'],
                        ['name' => 'Purple Violet', 'hex' => '#51243e', 'slug' => 'purple-violet', 'finish' => 'RAL 4007', 'alt' => 'Purple Violet paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/purple-violet-320w.webp'],
                        ['name' => 'Colza Yellow', 'hex' => '#f3cb2d', 'slug' => 'colza-yellow', 'finish' => 'RAL 1021', 'alt' => 'Colza Yellow paint sample for composite doors', 'image' => '/wp-content/themes/fenster/assets/images/products/composite-distinction/palette/colza-yellow-320w.webp'],
                    ],
                ],
            ],
        ],
        'home' => [
            'eyebrow' => 'Bedfordshire aluminium glazing specialists',
            'title' => 'Fenster Glazing',
            'intro' => 'Windows, doors, bifolds and glazing systems installed across Milton Keynes, Bedfordshire, Buckinghamshire and the surrounding areas.',
            'primary_cta' => ['label' => 'Start an enquiry', 'url' => home_url('/contact/')],
            'secondary_cta' => ['label' => 'View commercial projects', 'url' => home_url('/commercial-projects/')],
            'services' => [
                'Aluminium Windows',
                'Aluminium Doors',
                'Aluminium Bifold Doors',
                'Sliding Doors',
                'Roof Lanterns',
                'Commercial Glazing',
            ],
        ],
    ];
}
