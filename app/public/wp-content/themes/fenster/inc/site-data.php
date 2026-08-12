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
                            ['label' => 'uPVC Casement', 'url' => home_url('/casement-windows/')],
                            ['label' => 'uPVC Flush Sash', 'url' => home_url('/flush-casement-windows/')],
                            ['label' => 'Sliding Sash', 'url' => home_url('/sliding-sash-windows/')],
                            ['label' => 'uPVC Tilt & Turn', 'url' => home_url('/tilt-turn-windows/')],
                            ['label' => 'Aluminium Casement', 'url' => home_url('/aluminium-windows/')],
                            ['label' => 'Aluminium Flush', 'url' => home_url('/aluminium-flush-windows/')],
                            ['label' => 'Aluminium Heritage', 'url' => home_url('/heritage-windows/')],
                            ['label' => 'French Casement', 'url' => home_url('/french-casement-windows/')],
                            ['label' => 'Bow and Bay', 'url' => home_url('/bow-bay-windows/')],
                        ],
                    ],
                    [
                        'label' => 'Doors',
                        'url' => home_url('/doors-milton-keynes/'),
                        'items' => [
                            ['label' => 'Aluminium Bifold', 'url' => home_url('/aluminium-bifold-doors/')],
                            ['label' => 'Slide & Fold', 'url' => home_url('/slide-fold-doors/')],
                            ['label' => 'Aluminium Sliding', 'url' => home_url('/aluminium-sliding-doors/')],
                            ['label' => 'Aluminium Doors', 'url' => home_url('/aluminium-doors/')],
                            ['label' => 'Aluminium Heritage', 'url' => home_url('/heritage-aluminium-doors/')],
                            ['label' => 'Composite Doors', 'url' => home_url('/composite-doors/')],
                            ['label' => 'uPVC Doors', 'url' => home_url('/upvc-doors/')],
                            ['label' => 'uPVC Sliding Patio', 'url' => home_url('/patio-doors/')],
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
                            ['label' => 'Replacement Glazing', 'url' => home_url('/commercial-replacement-glazing/')],
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
                            ['label' => 'Industrial and Logistics', 'url' => home_url('/industrial-and-logistics-glazing/')],
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
            /* Two tiles corrected 2026-08-10 against Sheerline's own published
               specification for the Prestige system.

               "Energy rating: A+ rated" became "Up to A+", which is Sheerline's
               wording. The old phrasing asserted a rating every build achieves;
               a WER depends on the glass and the configuration.

               "Outer frame: 80mm" is gone. Sheerline describes ONE "72-80mm wide
               system" across the range, and we were quoting the top of that range
               on flush and the bottom of it on `aluminium-windows`, which made
               flush look like the chunkier product when it is the same system. It
               is also a frame DEPTH, which no customer is choosing on. Replaced
               with the sightline, which is the number that decides how much glass
               you get: 46mm on a fixed pane, 88mm on a casement, so "From 46mm"
               is the honest floor of a published range. */
            'aluminium-flush-windows' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Energy rating', 'value' => 'Up to A+'],
                /* "From 46mm" was removed on 2026-08-10 after the owner
                   explained the system: Prestige standard and flush are the same
                   window on a different outer frame, and FLUSH IS THE LARGER of
                   them. 46mm is the slimmest published sightline in the range,
                   which makes it a standard-casement figure and not this
                   product's. Replaced with the system, which is true, specific
                   and not a number that can be read as a promise. */
                ['label' => 'System', 'value' => 'Sheerline Prestige'],
            ],
            /* Two of these four were corrected on 2026-08-11 during the page
               rebuild, and both faults are ones this file has recorded before.
               "Sightlines: Ultra slim" was an adjective in a strip whose whole
               job is figures, so it is now Sheerline's published beaded
               casement sightline — 60.5mm, owner-confirmed on 2026-08-11 as the
               variant we fit, and the same figure the heritage door strip
               already prints because it is the same Classic system. And "A+
               rated" is now "Up to A+", because Sheerline give A with double
               glazing and A+ with triple, which their own page notes is only
               available in certain styles. The identical correction was made on
               the flush aluminium strip a day earlier. */
            'heritage-windows' => [
                ['label' => 'U-value', 'value' => '1.4 W/m²K'],
                ['label' => 'Colour choice', 'value' => 'Any RAL colour'],
                ['label' => 'Sightlines', 'value' => '60.5mm'],
                /* "A rated", not "Up to A+", and this follows directly from the
                   triple decision above. Sheerline give the Classic window an A
                   WER double glazed and A+ triple glazed. We do not offer
                   triple on the stepped sash, so A+ is a rating for a window we
                   do not sell and the honest tile is the one we do. Corrected
                   2026-08-11, an hour after "A+ rated" was corrected to "Up to
                   A+" for a different reason — worth noticing that a figure can
                   be true of the system and still untrue of the product. */
                ['label' => 'Energy rating', 'value' => 'A rated'],
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
            /* THE U-VALUE IS THE TRIPLE GLAZED FIGURE and the star says so, which is
               why the note under the strip has to stay. Owner-confirmed 2026-08-12,
               and it matches Liniar's own published 0.99 W/m²K whole-door figure for
               the 70mm residential door triple glazed. LINIAR PUBLISH NO DOUBLE
               GLAZED FIGURE for this door, so there is no second number to print and
               none may be inferred from the window range.

               "14 options" was wrong: the door takes the same foil range as the
               windows, owner-confirmed 2026-08-12, which is 16. "Design: Fully
               customisable" was an adjective sitting in a strip whose whole effect is
               that the numbers count up, and it is the claim the whole page now
               makes, so the slot carries the guarantee instead. */
            'upvc-doors' => [
                ['label' => 'U-value*', 'value' => '1.0 W/m²K'],
                /* THIRTEEN ON A DOOR, not the sixteen the windows carry. Owner
                   ruling 2026-08-12, against Liniar's own list for the 70mm
                   residential door. It also means the theme holds a render for
                   every finish offered, which is why the page can say so. */
                ['label' => 'Colour choice', 'value' => '13 options'],
                ['label' => 'Guarantee', 'value' => '10 years'],
                ['label' => 'Security', 'value' => 'Multi-point locking'],
            ],
            /* "Style: Traditional" was the fourth tile until 2026-08-06 and was
               the only one of the four that was not a measurement, sitting in a
               strip whose whole effect is that the numbers count up. It was also
               half wrong: this window goes on modern elevations as often as period
               ones. Liniar publish 35 (-1;-4) for the 70mm flush sash, so the slot
               now carries the acoustic figure. Owner's call between that and PAS
               24; the decibel number counts and the standard does not. */
            'flush-casement-windows' => [
                ['label' => 'U-value', 'value' => '1.2 W/m²K'],
                ['label' => 'Colour choice', 'value' => '16 options'],
                ['label' => 'Energy rating', 'value' => 'A+ rated'],
                ['label' => 'Sound reduction', 'value' => '35 dB'],
            ],
            'patio-doors' => [
                ['label' => 'U-value', 'value' => '1.2 W/m²K'],
                ['label' => 'Colour choice', 'value' => '14 options'],
                ['label' => 'Design', 'value' => 'Space-saving'],
                ['label' => 'Configuration', 'value' => 'Up to 4 panes'],
            ],
            /* THE FIGURES ON THIS ROUTE ARE LINIAR'S OWN FOR THE 70mm TILT AND
               TURN, not the 0.95/1.2 the rest of the Liniar range carries.
               Owner ruling 2026-08-12, reversing the 2026-08-03 "one figure for
               all Liniar" decision for this route only. See the note against
               `glazing_u_values` below for why, and do not "correct" it back.

               "Opening style: Highly versatile" was the fourth tile until
               2026-08-12. It was an adjective sitting in a strip whose whole
               effect is that the numbers count up, and it is the same fault
               that put "Design: Fully customisable" on the door and "Style:
               Traditional" on the flush casement. Liniar publish 37 (-2;-5) for
               this window, which is their best acoustic uPVC figure and beats
               the 35 the flush casement already prints, so the slot carries a
               measurement that also happens to be the one number where this
               window wins. */
            'tilt-turn-windows' => [
                ['label' => 'U-value*', 'value' => '0.93 W/m²K'],
                ['label' => 'Colour choice', 'value' => '16 options'],
                ['label' => 'Energy rating', 'value' => 'A++ rated'],
                ['label' => 'Sound reduction', 'value' => '37 dB'],
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
            /* The strip itself no longer renders on this route, for the reasons
               in `generated-page.php`, but this array is KEPT and kept accurate
               because Legend reads its verified product facts from here.

               "Energy rating: A+ rated" was removed on 2026-08-10. A+ is a
               Window Energy Rating and it belongs to a complete window: frame,
               glass and hardware rated together. A sealed unit going into
               somebody else's frame cannot carry one, so the claim was not true
               of anything we sell on this route and Legend could have repeated
               it in chat. Replaced with the fact that actually defines the
               product, in the words the page uses.

               "Guarantee: 10 years" is CORRECT and owner-confirmed 2026-08-10:
               "we guarantee sealed units for 10 years (what we get from
               manufacturer). same for integral blinds and secondary." It is not
               CPA-backed and no copy anywhere says it is. */
            'double-glazing-replacement' => [
                ['label' => 'Glazing option', 'value' => 'Made-to-measure units'],
                ['label' => 'Fitted into', 'value' => 'Your existing frames'],
                ['label' => 'Gas fill', 'value' => 'Argon'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            'secondary-glazing' => [
                /* The U-value claim was removed on 2026-08-05, owner instruction.
                   It read "From 1.8 W/m²K" against a starred label that nothing
                   on the route explained, and a secondary glazed figure depends
                   entirely on the existing window it is fitted inside, so a
                   single number could not be true of the job. Do not put a
                   figure back here without one confirmed for this product.

                   The tile is replaced rather than deleted because the strip
                   only renders with four, and it states the thing that actually
                   defines the product, in the words the page already uses:
                   "sits inside the original window line". It is also gone from
                   Legend, which reads its verified product facts from here. */
                ['label' => 'Fitting', 'value' => 'Inside the existing window'],
                /* Owner-confirmed 2026-08-07: the offer is white, brown or any
                   RAL. It read "Full RAL range", which was not wrong but hid the
                   two standard colours, and it also invited the assumption that
                   this product shares the twelve powder-coated finishes on the
                   aluminium window and door routes. It does not: secondary
                   glazing has its own range, which is why `/secondary-glazing/`
                   is correctly absent from `$aluminium_colour_routes` and must
                   stay absent. Legend reads its verified product facts from
                   here, so the two standard colours belong in it. */
                ['label' => 'Colour choice', 'value' => 'White, brown or any RAL'],
                ['label' => 'Frame type', 'value' => 'Slim aluminium'],
                ['label' => 'Guarantee', 'value' => '10 years'],
            ],
            /* THIS NO LONGER RENDERS. The key-specification strip is gated off
               for this route: a repair has no specification, so a box headed
               "Key specifications" made no sense on it. Owner, 2026-08-06.
               The page carries a reassurance strip in that slot instead, built
               in `window-door-repairs.php`.

               It is kept, and kept accurate, because Legend reads
               `product_usps` for its verified product facts, so a stale entry
               here becomes a wrong answer in chat even though no visitor can
               see it. It previously claimed "Guarantee: 10 years", which is CPA
               cover on NEW windows and doors and does not apply to repairs.

               The charge line states the condition, because the condition is
               the whole point of it: it is a floor on the work and applies only
               if the customer goes ahead. Quoting is normally free. */
            'window-and-door-repairs' => [
                ['label' => 'We repair', 'value' => 'Windows and doors, any installer'],
                ['label' => 'Materials', 'value' => 'uPVC, aluminium, composite'],
                ['label' => 'Quoting', 'value' => 'Normally free, often without a visit'],
                ['label' => 'Minimum charge', 'value' => '£96 inc VAT, only if you go ahead'],
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
           all Liniar triple and 1.2 the double. ~~Liniar publish 1.3 double on
           tilt and turn; ours is the tighter claim and is deliberate.~~
           SUPERSEDED FOR TILT AND TURN, 2026-08-12: that route now carries
           Liniar's own 1.3 / 0.93 pair on the owner's ruling, and it is the
           only Liniar route off the shared figures. The reason is written
           against the entry itself so it cannot be tidied away as drift.

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
            /* TILT AND TURN IS THE ONE LINIAR ROUTE OFF THE 0.95/1.2 RULE, and
               that is deliberate as of 2026-08-12 rather than a value that has
               drifted. The 2026-08-03 ruling above set one pair across the whole
               Liniar range and knowingly published the tighter number here; the
               owner reversed it for this route on 2026-08-12 and asked for
               Liniar's own published pair for the 70mm tilt and turn, 1.3 double
               and 0.93 triple.

               It is the safer figure as well as the truer one. Liniar's spec
               table also carries 0.85 W/m²K whole window, which is almost
               certainly their 40mm IGU — and 40mm is not offered on any uPVC we
               fit, so that number describes a window we do not sell. 0.93 is the
               body-copy figure for triple glazing and matches the 36mm unit that
               is our actual ceiling. The A++ on the key-specification strip comes
               from the same Liniar page as this pair and is attributed to them on
               the page, not restated as ours. Do not reconcile this back to
               casement's 0.95/A+ without asking: same system, different sash and
               different gasket compression, and the owner has ruled on it. */
            'tilt-turn-windows'       => ['double' => '1.3 W/m²K', 'triple' => '0.93 W/m²K'],
            // 28mm IGU only, so no triple. Liniar's own specification confirms it.
            'flush-casement-windows'  => ['double' => '1.2 W/m²K'],
            /* uPVC DOORS. The triple figure is Liniar's own published 0.99
               W/m2K whole-door on the 70mm residential door, rounded to the 1.0
               the strip has always shown. THE DOUBLE FIGURE IS THE WINDOW'S,
               1.2, on the owner's ruling of 2026-08-12: Liniar publish no double
               glazed figure for this door, and rather than leave the standard
               specification with no number at all we state the figure for the
               same 70mm EnergyPlus system in a window. It is a borrowed figure
               and that is a deliberate decision, not an oversight — if Liniar
               ever publish a door-specific double, use theirs. */
            'upvc-doors'              => ['double' => '1.2 W/m²K', 'triple' => '1.0 W/m²K'],
            // Sheerline Prestige
            'aluminium-windows'       => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-flush-windows' => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-doors'         => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-bifold-doors'  => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            'aluminium-sliding-doors' => ['double' => '1.4 W/m²K', 'triple' => '1.0 W/m²K'],
            // Sheerline Classic
            /* NO TRIPLE ON HERITAGE WINDOWS. Owner, 2026-08-11: triple glazing
               can be done on the Classic CONTEMPORARY sash, but we do not offer
               it on the STEPPED one, deliberately, so the Classic offering does
               not muddy against Prestige. So this route has one glazing unit
               and the strip prints 1.4 plain — no star and no "lowest
               achievable" note, because there is no lower figure to qualify.
               Sheerline's published 1.1 belongs to a sash we do not sell here.
               Do not add it back off their website. */
            'heritage-windows'          => ['double' => '1.4 W/m²K'],
            /* The door follows the window, owner-confirmed 2026-08-11: same
               Classic system, same answer. Triple is only available on the
               contemporary sash and we fit the stepped one, so there is no
               triple figure for this route either. This also empties the triple
               row out of the Thermlock banner, which reads these values, so the
               banner and the strip cannot end up disagreeing. */
            'heritage-aluminium-doors'  => ['double' => '1.4 W/m²K'],
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
                /* Sheerline's own photograph, added 2026-08-10 on the owner's
                   instruction that the page "cant just have the one project that
                   is pretty niche". A 1930s red brick house with a bay, which
                   carries the page's argument that flush aluminium suits an
                   older building far better than our single Cotswold cottage can
                   on its own. Our photographs stay, and stay captioned as ours. */
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-flush/afw-hero-brick-house-1920w.jpg', 'alt' => 'Pale grey flush aluminium windows and a bay on a red brick house'],
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
            /* Hero replaced 2026-08-10. It was a stock photograph of a uPVC
               profile corner sample standing on a windowsill, from the same
               stock shoot as its one gallery mate, and it showed neither our
               work nor a failed unit. The route now leads on a Fenster job: a
               window where one sealed unit has gone and the pane beside it has
               not, which is the whole product in one frame.

               The crop was chosen at the size the hero renders. A tighter band
               read as texture rather than as a window, which is exactly the
               fault the secondary glazing hero shipped with on 2026-08-07;
               enough mullion is kept for it to read as glass in a room. */
            'double-glazing-replacement' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-hero-misted-view-1920w.jpg', 'alt' => 'A large window with one failed sealed unit veiling the countryside beyond it, beside a pane that is still clear'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-view-misted-1400w.jpg', 'alt' => 'A picture window with a misted sealed unit, the view beyond it veiled and streaked'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-view-clear-1400w.jpg', 'alt' => 'The same picture window after the failed unit was replaced, with the view sharp through it'],
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
            /* Owner audit, 2026-08-06. The hero here was `flush-stone-elevation`,
               which is aluminium: slim square sightlines, thin sash sections, a
               contemporary elevation. We sell aluminium flush windows as a separate
               product, so the lead image on the uPVC flush page was selling the
               wrong one. `flush-grey-top-vents` in the mosaic below is the same
               mistake, with visible metal restrictor arms, and comes out too.

               Both are replaced with our own installations. Judge a replacement by
               the sash-to-frame junction, not by the filename: everything in this
               set is called flush-something and two of them were not. */
            'flush-casement-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-hero-black-open-2400w.webp', 'alt' => 'Two black flush casement windows standing open on a white painted brick elevation'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-detail-1400w.webp', 'alt' => 'White flush casement window in red brick, the sashes closing level with the outer frame'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-cream-bars-1400w.webp', 'alt' => 'Cream flush casement windows with Georgian bars on a buff brick house'],
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
            /* THE OLD HERO WAS NOT A TILT AND TURN. `tilt-turn-brick-1600w.webp`
               (Liniar's own `Tilt__Turn_02.jpg`) shows two barrel hinges mounted
               on the jamb and the sash standing proud of the frame: it is a
               side-hung casement opening OUTWARD. A tilt and turn opens inwards
               and carries no exposed jamb hinge. Its alt text also claimed the
               sash was "tilted open at the top", so the page was asserting the
               product's one distinguishing feature over a photograph of a
               different window. Removed 2026-08-12. The file is left on disk
               unreferenced rather than deleted, because a deletion has to be
               asserted by name through the deploy guard and nothing needs it.

               What replaced it is the interior shot, cropped to the hero band.
               It is the only real photograph we own that does not contradict the
               product, and the context is right: an upper-floor flat with a city
               view is exactly who buys these. It is Liniar's, so it is
               unattributed in the hero, per the split this site holds to —
               supplier imagery unattributed, our own work always captioned as
               ours. The `card` is a 4:3 cut of the same photograph, because the
               hub tile falls back to `hero` and a 3.2:1 band centre-cropped into
               a 4:3 cell would show a wall and a lampshade. */
            'tilt-turn-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/tilt-turn/tilt-turn-room-hero-1920w.webp', 'alt' => 'Two tall uPVC windows in a top-floor apartment living room, looking out over the street'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/products/tilt-turn/tilt-turn-room-card-1200w.webp', 'alt' => 'A tall white uPVC window in an apartment living room, the handle set on the side of the sash'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-1.jpeg', 'alt' => 'Tilt and turn window tilted inwards at the top, with the stay arm and sash gearing visible'],
                    ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-2.jpeg', 'alt' => 'The stay at the top corner of a tilt and turn sash, holding it in the tilt position'],
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
                    /* Owner-supplied 2026-08-12, "a sheerline casement for use in
                       resi". Anthracite aluminium casements across three storeys
                       of a brick block, and the SECOND photograph of our own
                       aluminium work in the bank.

                       IT LIVES HERE RATHER THAN IN `product_gallery_pools`, and
                       the distinction is worth knowing because the first attempt
                       put it in the pool and it rendered nowhere.
                       `product_media[slug].gallery` is what the product page and
                       the town matrix routes actually draw from. The pool is
                       merged AFTER the `pages.json` images and the visuals band
                       then takes only items five to eight of what is left, so a
                       pool entry on a route with a full scraped image set never
                       surfaces. Check the rendered page, not the array.

                       The alt names no town: this entry reaches around twenty
                       `/aluminium-windows-<town>/` routes and a location claim
                       would be false on nineteen of them. GPS stripped. */
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/alu-casement-brick-block-1600w.jpg', 'alt' => 'Anthracite aluminium casement windows across three storeys of a red brick building'],
                    /* The only other photograph of a Fenster aluminium install in
                       the image bank. PHOTO-CHECKLIST listed 'aluminium windows on
                       a local home' as a standing gap; this closes it. */
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-windows/aluminium-window-grey-stone.webp', 'alt' => 'Grey aluminium window in a stone elevation, fitted on a local home'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Slim aluminium windows installed on a coastal property'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Aluminium window frame profile detail'],
                ],
            ],
            /* Rebuilt 2026-08-11. The hero was a 1200px-wide photograph of an
               almshouse terrace being asked to fill a 1440px letterbox, and it
               showed a row of windows from across a green rather than the thing
               the page sells. The hero now crops the steel-look interior, which
               is the one image in the bank that says "Crittall" before a word is
               read: a tall dark grid against a panelled wall, with the right
               half quiet enough to carry the hero copy. Supplier photography,
               unattributed in the hero per the split already documented on the
               flush aluminium route — our own work is captioned as ours in the
               page's gallery instead. */
            'heritage-windows' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-windows/hw-hero-steel-look-2048w.webp', 'alt' => 'Tall steel-look aluminium window with slim dark glazing bars in a paneled living room'],
                'card' => ['src' => '/wp-content/themes/fenster/assets/images/imported/C08-Classic-Windows-Heritage-Style-Anthracite-2048x1366-1.jpg', 'alt' => 'Steel-look heritage aluminium windows seen from inside a living room'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-windows/hw-install-stone-gable-1200w.webp', 'alt' => 'White heritage aluminium windows fitted into the stone mullioned openings of a cottage gable'],
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
                /* The second entry here was `sheerline-heritage-door`, a Sheerline
                   Classic steel-look door on the modern door route. Same
                   correction as the gallery pool below. */
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-brick-sidescreens.webp', 'alt' => 'Purple aluminium entrance door between two obscured glazed side screens in a brick elevation'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-timber-clad.webp', 'alt' => 'Dark grey aluminium entrance door with a recessed groove pattern, beside timber cladding'],
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
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-half-glazed.webp', 'alt' => 'White uPVC stable door with both halves glazed, in a brick opening'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-boarded-panel.webp', 'alt' => 'White uPVC back door with a glazed upper panel over a boarded lower panel, with black handle and hinges'],
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
            /* Rebuilt 2026-08-07 with the page. The hero was
               `Joined-Vertical-Slider-Bay.jpg`, an old-site scrape image of a bay
               so overexposed that the windows read as flat white and the product
               could not be seen at all. It is now one of our own installs,
               cropped to the hero's 3.2:1 letterbox: leaded diamond lights in a
               stone mullioned reveal, which says period property in one glance
               and is exactly who this page is for.

               The gallery entries were a sealed-unit sample and the stock
               man-with-a-screwdriver photograph, neither of which is secondary
               glazing. */
            'secondary-glazing' => [
                /* Second hero in a day. The first was a 1200x375 band cut from a
                   1200x1600 photograph of a stone mullioned reveal, and the
                   owner's read was right on both counts: too low resolution,
                   because the hero box renders 1440 wide so a 1200 source is
                   upscaled, and too zoomed in, because a tight band of stone and
                   leaded glass reads as texture rather than as a room.

                   This is banded from the 3840x5120 Winslow original at 1920
                   wide, so nothing is upscaled, and the band is taken low enough
                   to catch the bottom rail, the timber sill and the curtains
                   either side, with the original casement standing open. It
                   reads as a window in a room, which is what a hero has to do
                   when the four sections below it are doing the explaining.

                   A genuinely generic image was considered and there is not an
                   honest one: every wide, high-resolution photograph in the
                   theme is a different product (replacement glazing, heritage
                   aluminium windows, rooflights), and putting one of those here
                   is exactly the mistake `/aluminium-doors/` is still carrying. */
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/secondary-glazing/sg-hero-winslow-1920w.jpg', 'alt' => 'Secondary glazing across a leaded window in a period room, with the original casement standing open behind it and a deep timber sill below'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/secondary-glazing/sg-stone-mullion-leaded.jpg', 'alt' => 'White secondary glazing inside a stone mullioned reveal, with the original leaded window behind'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/secondary-glazing/sg-leaded-iron-handles.jpg', 'alt' => 'Secondary glazing across a pair of leaded casements with their original black iron handles behind the glass'],
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
            /* Hero changed 2026-08-06 to the handle photograph, because the
               hardware IS the subject of a repairs page and a general frame
               close-up was not saying anything. It also feeds the tile on
               /other-services/, which crops to a 384x225 landscape cell; at
               1400x934 this one takes that crop without losing the handle.

               Deliberately NOT `imported/window-repair-milton-keynes-scaled.jpg`,
               which pages.json still carries as this route's imported hero. It
               is stock: a man in blue dungarees holding a screwdriver, shot on
               a white background. It is the exact tradesman-stock register the
               rest of the site avoids, and nothing should reinstate it. */
            'window-and-door-repairs' => [
                'hero' => ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-handle-detail-1400w.webp', 'alt' => 'Chrome handle on an open uPVC window sash, seen from inside'],
                'gallery' => [
                    ['src' => '/wp-content/themes/fenster/assets/images/products/casement/casement-friction-stay-1200w.webp', 'alt' => 'Friction stay hinge along the bottom of an open window sash'],
                    ['src' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg', 'alt' => 'Sealed double glazed unit sample cut through to show the cavity'],
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
                    ['slug' => 'casement-windows', 'name' => 'uPVC Casement Windows', 'fit' => 'The everyday all-rounder', 'copy' => 'Side or top hung, in almost any combination. Most of the homes we work on end up with these.'],
                    ['slug' => 'flush-casement-windows', 'name' => 'uPVC Flush Sash Windows', 'fit' => 'Sits level with the frame', 'copy' => 'The sash closes flush into the outer frame rather than sitting proud of it, which is how timber windows were made.'],
                    ['slug' => 'sliding-sash-windows', 'name' => 'Sliding Sash Windows', 'fit' => 'Period proportions', 'copy' => 'Vertical sliders on the Roseview system, with the horns and bar layouts a period frontage needs.'],
                    ['slug' => 'tilt-turn-windows', 'name' => 'uPVC Tilt & Turn Windows', 'fit' => 'Two ways to open', 'copy' => 'Tilt the top inwards for ventilation without unlocking, or swing the whole sash in to clean the outside from indoors.'],
                    ['slug' => 'aluminium-windows', 'name' => 'Aluminium Casement Windows', 'fit' => 'Slim frames, more glass', 'copy' => 'Thinner sightlines than uPVC for the same opening, powder coated in the RAL colour you choose.'],
                    ['slug' => 'aluminium-flush-windows', 'name' => 'Aluminium Flush Windows', 'fit' => 'Flat outside face', 'copy' => 'The aluminium version of a flush sash, where the sash and the frame finish on the same plane.'],
                    ['slug' => 'heritage-windows', 'name' => 'Aluminium Heritage Windows', 'fit' => 'The steel-window look', 'copy' => 'Slim sections and stepped bars that read like original steel, in thermally broken aluminium.'],
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
                    ['slug' => 'patio-doors', 'name' => 'uPVC Sliding Doors', 'fit' => 'Nothing swings into the room', 'copy' => 'Up to four panes sliding past each other, so the floor space either side of the opening stays usable.'],
                    ['slug' => 'aluminium-sliding-doors', 'name' => 'Aluminium Sliding Doors', 'fit' => 'The largest panes', 'copy' => 'Sheerline lift and slide, with interlocks as slim as 52mm, so the frame gets out of the way of the view.'],
                    ['slug' => 'aluminium-bifold-doors', 'name' => 'Aluminium Bifold Doors', 'fit' => 'Folds right back', 'copy' => 'Panels stack to one or both sides, so in summer the opening is almost entirely clear.'],
                    ['slug' => 'french-doors', 'name' => 'French Doors', 'fit' => 'A pair, opening from the centre', 'copy' => 'Two doors opening together, with the option of fixed side panels. Built in uPVC, aluminium or heritage.'],
                    ['slug' => 'slide-fold-doors', 'name' => 'Slide & Fold Doors', 'fit' => 'Fold one, or fold them all', 'copy' => 'Each panel slides and opens on its own, so a wide opening stops being an all-or-nothing choice. Ten point locking.'],
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
            /* Given its own pool on 2026-08-11. It had been sharing
               `aluminium_windows`, which is the fault the window routes were
               split to fix on 2026-07-24 and which had simply been missed here:
               a steel-look route was illustrating itself with contemporary
               Prestige frames, on this page and on every
               `/heritage-windows-<town>/` matrix page with it. */
            'heritage-windows' => 'heritage_windows',
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
            /* The two aluminium frames are gone from here too, and our own
               installations lead. `flush-grey-interior` also came out: flushness is
               an external characteristic, so a photograph taken from inside the room
               cannot show it, and it was occupying a slot on the one page where that
               is the whole argument. See the note on the hero above. */
            'flush_casement_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-modern-black-1600w.webp', 'alt' => 'Black flush casement windows in a white painted brick extension'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-detail-1400w.webp', 'alt' => 'White flush casement window in red brick, the sashes closing level with the outer frame'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-cream-bars-1400w.webp', 'alt' => 'Cream flush casement windows with Georgian bars on a buff brick house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-white-bay-brick-1400w.webp', 'alt' => 'White flush casement bay window on a tile hung house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/flush-casement/flush-oak-dormers-1400w.webp', 'alt' => 'Golden oak flush casement windows in two dormer gables'],
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
            /* TWO CAME OUT ON 2026-08-12 AND NEITHER SHOULD COME BACK.
               `tilt-turn-brick-1600w.webp` is a side-hung casement opening
               outward, not a tilt and turn — see the note against the hero in
               `product_media` for the evidence. And `tilt-turn-apartments` is a
               CGI render, which is the first thing the eye lands on in a row of
               photographs; it came off the doors hub tile for the same reason on
               2026-07-29.

               This pool also feeds every `/tilt-turn-windows-<town>/` matrix
               page, so a wrong image here is wrong on about twenty pages, which
               is why both were removed from the pool and not only from the
               route. What is left is one real interior and four of Liniar's
               studio renders of the mechanism. That is a thin pool and it is
               honestly thin: nobody has photographed a tilt and turn of ours
               tilting or turning. See `PHOTO-CHECKLIST.md`. */
            'tilt_turn_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt__Turn_14.jpg', 'alt' => 'Two tall uPVC windows in an apartment living room with roman blinds'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-1.jpeg', 'alt' => 'Tilt and turn window tilted inwards at the top, with the stay arm and sash gearing visible'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-ventilation-2.jpeg', 'alt' => 'The stay at the top corner of a tilt and turn sash, holding it in the tilt position'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-keep-1.jpeg', 'alt' => 'A steel keep set into the frame of a tilt and turn window'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Tilt-turn-keep-2.jpeg', 'alt' => 'A second steel keep, screw-fixed on the sash side of a tilt and turn window'],
            ],
            'bow_bay_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/imported/bay-window.jpg', 'alt' => 'White uPVC bay window with leaded glazing on a red brick house'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/bow-bay/bay-white-brick-dusk-1600w.webp', 'alt' => 'White bay window with Georgian bars on a brick and render home'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_10.jpg', 'alt' => 'Curved white uPVC bow window on a red brick wall'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_02.jpg', 'alt' => 'Golden oak bow window curving out from a light brick elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Bow_08.jpg', 'alt' => 'Golden oak bay window with leaded lights'],
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
            /* The owner's 2026-08-12 casement photograph is deliberately NOT in
               this pool. It went here first and rendered on nothing: this pool is
               merged after the `pages.json` images and the visuals band then takes
               only items five to eight of the remainder. It lives in
               `product_media['aluminium-windows'].gallery` instead, which is what
               the product page and the town routes actually draw from. */
            'aluminium_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window.jpg', 'alt' => 'Aluminium windows installed on a coastal property'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-aluminium-window-closeup.png', 'alt' => 'Aluminium window profile detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', 'alt' => 'Heritage aluminium windows on a period property'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Steel-look aluminium glazing bar detail'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-french-window.jpg', 'alt' => 'Woodgrain French casement window in a kitchen diner'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/C08-Classic-Windows-Heritage-Style-Anthracite-2048x1366-1.jpg', 'alt' => 'Heritage aluminium windows with dark slim frames'],
            ],
            /* Heritage windows own their range as of 2026-08-11. EVERY ENTRY
               HAS TO BE A CLASSIC STEEL-LOOK WINDOW, and that is narrower than
               it sounds: two Sheerline lifestyle shots were pulled straight
               back out on the owner's eye, because one of them is the SAME
               HOUSE, SAME SHOOT as the `/aluminium-flush-windows/` hero — the
               same cordyline palm and the same sign in the window — and the
               other could not be shown to be the stepped sash rather than the
               contemporary one. Both sat on Sheerline's Classic page, which is
               not the same thing as being this product. **Check a supplier
               photograph against the flush and aluminium routes before adding
               it here.** The first entry is deliberately our own install: this
               pool feeds the town matrix pages too, and a real local job
               outranks supplier photography there. */
            'heritage_windows' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/heritage-windows/hw-install-stone-gable-1200w.webp', 'alt' => 'White heritage aluminium windows in the stone mullioned openings of a cottage gable'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-windows.jpg', 'alt' => 'Heritage aluminium windows along a traditional terrace'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/sheerline-heritage-window-closeup.jpg', 'alt' => 'Slim steel-look glazing bar detail on a heritage aluminium window'],
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
            /* Curated 2026-08-07, and it needed it: five of the nine entries
               were not this product. `sheerline-heritage-door`,
               `sheerline-french-doors` and `Classic-French-Internal-open-B` are
               Sheerline CLASSIC, which is the steel-look heritage system with
               its own route and its own `heritage_aluminium_doors` pool;
               `sheerline-heritage-window-closeup` is a heritage WINDOW, and
               `sheerline-aluminium-window-closeup` is a window profile. This
               pool is modern aluminium entrance doors, which is what AI.md has
               said it is since the heritage pool was split out of it, and it
               feeds every `/aluminium-doors-<town>/` matrix page as well as this
               route. Every image below was opened and checked rather than taken
               on its filename.

               Two deliberate omissions. `aluminium-doors-northampton-2.jpg` is a
               dusk CGI render of a whole house, and a render sitting in a row of
               photographs is the first thing the eye lands on — it was pulled
               off the hub tile on 2026-07-29 for exactly that reason, so it does
               not belong in the gallery either. `Aluminium-Doors-Northampton-7-1`
               is a genuine photograph and only 300x300, which is smaller than
               the cell it would render into. */
            'aluminium_doors' => [
                /* First, because it is the only one of these that is ours.
                   Owner-supplied and owner-confirmed 2026-08-07 as aluminium
                   French doors with flush aluminium windows either side. */
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-french-flag-install-1600w.webp', 'alt' => 'Black aluminium French doors we fitted, with a flush aluminium window either side and blinds sealed inside the glass'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-brick-sidescreens.webp', 'alt' => 'Purple aluminium entrance door between two obscured glazed side screens in a brick elevation'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-timber-clad.webp', 'alt' => 'Dark grey aluminium entrance door with a recessed groove pattern, beside timber cladding'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/aluminium-doors-northampton-2-1.jpg', 'alt' => 'Sage green aluminium entrance door with a full-height bar handle in a recessed porch'],
                ['src' => '/wp-content/themes/fenster/assets/images/imported/Prestige-aluminium-door-in-stone-web.webp', 'alt' => 'White aluminium entrance door in a stone surround'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-cylinder-handle.webp', 'alt' => 'Cylinder lock and full-height bar handle on a dark grey aluminium door'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/aluminium-doors/alu-door-low-threshold.webp', 'alt' => 'Low aluminium threshold under a sage green door, almost flush with the paving outside'],
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
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-half-glazed.webp', 'alt' => 'White uPVC stable door with both halves glazed, in a brick opening'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/upvc-doors/upvc-door-white-boarded-panel.webp', 'alt' => 'White uPVC back door with a glazed upper panel over a boarded lower panel, with black handle and hinges'],
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
            /* Rebuilt 2026-08-10. Every one of the five was the WRONG PRODUCT:
               a stock sealed-unit sample, a casement close-up, casements on a
               house, a flush window and a bay — all of them whole new windows,
               which is the one thing this route is not, and all carrying alt
               text asserting they were replacement glazing.

               The band that renders this pool is gated off for the route, so it
               was dormant rather than visible, but a dormant pool of wrong
               images with confident alt text is a trap for whoever ungates it.
               These are the real photographs the owner supplied. */
            'replacement_glazing' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-view-misted-1400w.jpg', 'alt' => 'A picture window with a failed sealed unit, the view beyond it veiled and streaked'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-view-clear-1400w.jpg', 'alt' => 'The same picture window after the failed unit was replaced, with the view sharp through it'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-failed-unit-leaded-1600w.jpg', 'alt' => 'A failed sealed unit in a leaded window, with condensation trapped between the panes'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-bead-out-1000w.jpg', 'alt' => 'A glazing bead being cut away from a uPVC frame beside a broken glass unit'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/integral-blinds/ib-retrofit-open-1600w.jpg', 'alt' => 'Integral blinds drawn up inside the glass of a retrofitted window'],
            ],
            /* Rebuilt 2026-08-07. All four previous entries were the wrong
               product and all four carried alt text asserting they were not:
               a sealed-unit sample described as "Secondary glazing panel shown
               inside a window opening"; `window-repair-milton-keynes-scaled.jpg`,
               which is STOCK, a man in blue dungarees holding a screwdriver, and
               which the Repair Imagery Rule already forbids, described as "existing
               window opening checked for secondary glazing"; a Liniar casement
               close-up; and a generic old-window shot. This pool feeds every
               `/secondary-glazing-<town>/` matrix page as well as the product
               route, so it was wrong across the matrix.

               Every replacement is a Fenster installation. Two came from the
               owner directly, four from the Winslow job that is now a case study,
               and they are referenced from `assets/images/case-studies/` rather
               than copied so there is one file per photograph. */
            'secondary_glazing' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/secondary-glazing/sg-stone-mullion-leaded.jpg', 'alt' => 'White secondary glazing inside a stone mullioned reveal, with the original leaded diamond window behind'],
                ['src' => '/wp-content/themes/fenster/assets/images/case-studies/cs-winslow-secondary-glazing-open.jpg', 'alt' => 'Secondary glazing closed across a leaded window with the original casement open behind it'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/secondary-glazing/sg-leaded-iron-handles.jpg', 'alt' => 'Secondary glazing across leaded casements with their original black iron handles behind the glass'],
                ['src' => '/wp-content/themes/fenster/assets/images/case-studies/cs-winslow-secondary-glazing-kitchen.jpg', 'alt' => 'Secondary glazing across a kitchen window above the worktop'],
                ['src' => '/wp-content/themes/fenster/assets/images/case-studies/cs-winslow-secondary-glazing-narrow.jpg', 'alt' => 'A narrow window with its original timber sill, the secondary glazing set back in the reveal'],
                ['src' => '/wp-content/themes/fenster/assets/images/case-studies/cs-winslow-secondary-glazing-catch.jpg', 'alt' => 'The catch on a secondary glazing slider, with the original leaded light behind it'],
            ],
            'window_repairs' => [
                ['src' => '/wp-content/themes/fenster/assets/images/products/curated/liniar-casement-closeup.jpg', 'alt' => 'Window opening detail used for repair checks'],
                ['src' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-failed-unit-leaded-1600w.jpg', 'alt' => 'A misted sealed unit, the fault that sends a repair call to replacement glazing'],
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
            /* Rewritten 2026-08-10 with the page. Two things changed beyond the
               register. The old copy sold this as a thermal upgrade, which the
               owner corrected: a new unit can improve things, "but thats not
               really why we do it as a lot of energy will be lost in an old
               frame so often a false economy". And the hedging was doing damage
               — "can often", "can sometimes", "where suitable" on every answer
               reads as a company that will not commit to anything. The facts are
               all owner-confirmed, so the answers say them.

               Only FIVE FAQs render on this route (`$product_faq_limit`), so
               these are the five questions that actually arrive, in order. Adding
               a sixth here renders nothing; raise the limit as well. */
            'double-glazing-replacement' => [
                'intro' => 'Replacement glazing is a new sealed unit, made to fit the frame you already have. When the seal around a unit fails, damp air gets into the gap between the panes and mists the glass from a side no cloth will ever reach. Fenster measures the opening, checks what the position needs and fits a new unit into the existing frame.',
                'benefits' => [
                    ['title' => 'The frame stays put', 'copy' => 'The beads come off, the failed unit lifts out and a new one goes in. Frame, hinges, handles and locks are left exactly as they are, and the beads and gaskets already on the window are almost always the ones that go back on it.'],
                    ['title' => 'Every frame, and doors too', 'copy' => 'uPVC, aluminium and timber, beaded or putty glazed, windows and doors alike. Leaded and Georgian bar patterns are matched into the new unit so a period window comes back looking like itself.'],
                    ['title' => 'Made to your measurements', 'copy' => 'We measure the glass, the spacer and the frame it has to go back into before anything is ordered, and check whether the position calls for toughened or laminated glass.'],
                    ['title' => 'The cheapest moment to change something', 'copy' => 'The unit is built from scratch, so integral blinds, obscure glass, a pet flap aperture or acoustic and solar control glass cost far less now than as a job of their own later.'],
                    ['title' => 'One unit is a job', 'copy' => 'There is no minimum. Send rough sizes and a photograph and we can usually price it without coming out, and the survey is free either way.'],
                ],
                'faqs' => [
                    ['question' => 'Can misted double glazing be replaced without a new window?', 'answer' => 'Usually, yes. If the frame is sound and still opening and closing properly, the failed unit comes out and a new one made to the same size goes back into it. The frame, the hinges and the handles all stay. Where the frame is rotten or no longer closing properly we will tell you what we think is worth doing.'],
                    ['question' => 'Why does cleaning it make no difference?', 'answer' => 'Because the moisture is sealed between the two panes rather than on either surface. Once the seal has failed, damp air gets into that gap and condenses against the inside of the glass, which is why the haze comes back whatever you clean it with and why it often looks worse on a cold morning.'],
                    ['question' => 'How long does it take?', 'answer' => 'Around one to two weeks from the order, because every unit is made to your measurements. We measure first, then come back to fit, and a typical unit takes about an hour once we are there. We need to get to the window from inside and out, and the old glass leaves with us.'],
                    ['question' => 'What does it cost?', 'answer' => 'It depends on the size of the unit, the glass in it and how many there are, so we price each one rather than publish a range. Send rough sizes and a photograph and we can usually give you a price without coming out, or price it yourself on our online tool. There is no minimum.'],
                    ['question' => 'Will new glass make the room warmer?', 'answer' => 'A new unit performs the way a working one should, so where the old one had failed you will notice it. How much difference it makes overall depends on the frame around it, which is why we would rather look at the window than promise a figure. If warmth across the whole house is the aim, that is a conversation about the windows rather than the glass, and we will say so.'],
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
            /* REWRITTEN 2026-08-12 with the bespoke middle. The old copy failed
               three ways at once and each is a documented site-wide fault:
               "Fenster specifies them for..." is the third-person voice
               `STYLE.md` bans, "shown in the key specification strip" is the UI
               self-talk `COPY-AUDIT.md` §2 catalogued, and the five benefit
               cards argued the same two-way-opening point four times, which is
               the "a page built by adding says everything twice" fault the uPVC
               doors audit closed a day earlier.

               The benefits array does not render on this route any more — the
               bespoke middle stands in for `fg-product-why` — but it is kept
               accurate, on the same reasoning as the repairs entry: a stale
               array is invisible to everyone until something ungates it. The
               FAQs DO still render. */
            'tilt-turn-windows' => [
                'intro' => 'A tilt and turn is the only window we fit that opens into the room. Tip the top in for air without unlocking anything, or swing the whole sash inwards to reach the outside of the glass from where you are standing. It is why they end up in flats, in upper-floor bedrooms and anywhere a sash swinging outwards would be in the way.',
                'benefits' => [
                    ['title' => 'One lever, two positions', 'copy' => 'A quarter turn tilts the top inwards for air. Carry on turning and the whole sash swings in. There is no second handle and nothing to prop.'],
                    ['title' => 'The outside of the glass, from inside', 'copy' => 'With the sash turned in you can reach the outer face standing in the room. On a third-floor flat that is the difference between cleaning your own windows and paying someone with a pole.'],
                    ['title' => 'It can be locked to tilt only', 'copy' => 'Leave the key a quarter turn and the handle still reaches tilt but will not go round to the full opening. The room airs and the window cannot be swung open.'],
                    ['title' => 'Nothing swings outwards', 'copy' => 'No sash over a balcony, a walkway, a path or a neighbour\'s boundary, which is what rules an outward-opening casement out of a lot of flats.'],
                ],
                'faqs' => [
                    ['question' => 'How does a tilt and turn window open?', 'answer' => 'One handle does both. Turn it a quarter and the top of the sash tips inwards a few inches for ventilation. Keep turning and the whole sash swings into the room on its side hinges, like a door.'],
                    ['question' => 'Can you stop it opening fully?', 'answer' => 'Yes, and it is the setting most people want upstairs. The handle locks with a key, and the middle key position lets the handle reach tilt but not the full opening, so the room airs without the sash being able to swing in.'],
                    ['question' => 'Are they good for upper floors and flats?', 'answer' => 'It is the main reason people choose them. The sash turns into the room so you can clean the outside of the glass from inside, and nothing swings out over a balcony or a walkway.'],
                    ['question' => 'What glazing do they take?', 'answer' => 'A 28mm double glazed unit as standard, or a 36mm triple. Liniar publish 1.3 W/m²K for the double glazed window and 0.93 for the triple, and rate the system A++.'],
                    ['question' => 'Do they suit an older house?', 'answer' => 'They can, but they read as modern, and on a period elevation a casement, a flush sash or a sliding sash usually looks more at home. Tell us the property and we will say so honestly.'],
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
            /* Rewritten 2026-08-11 with the page. The old copy was written about
               the category rather than about the window we fit: five benefits
               that would suit any aluminium window, and FAQs answering
               questions nobody types. `intro` is the hero lead on this route,
               so it is the first thing a visitor reads.

               Every figure here is Sheerline's published Classic specification
               and the 60.5mm is the BEADED casement sightline, owner-confirmed
               on 2026-08-11 as the variant we fit. Do not swap in the beadless
               59mm without asking, and do not reach for the 36.5mm fixed-frame
               figure as though it described a casement — that is the mistake
               the flush aluminium route made with 46mm. */
            'heritage-windows' => [
                'intro' => 'Original steel windows look wonderful and behave badly. This is the aluminium answer to them: the same slim dark grid and the same stepped sash face, with a thermal break through the frame, modern glass and nothing left to rub down and repaint.',
                'benefits' => [
                    ['title' => 'It reads as steel from the pavement', 'copy' => 'The Sheerline Classic stepped sash carries the shoulder and shadow line an original steel window has. It is the only sash profile we fit on this system, because the flatter contemporary one loses exactly the detail people come to this page for.'],
                    ['title' => 'Slim where it counts', 'copy' => 'Beaded casement sightlines of 60.5mm, and fixed panes from 36.5mm, so a small opening keeps its glass instead of losing it to frame.'],
                    ['title' => 'Warm, which steel never was', 'copy' => 'Sheerline put their Thermlock multi-chamber thermal break through the frame, and double glazed it reaches 1.4 W/m²K, against a single-glazed steel window that runs with condensation every winter morning.'],
                    ['title' => 'Bars where you want them', 'copy' => 'A Georgian grid or the horizontal 1920s layout, on every pane or only some, planned against the elevation rather than dropped on it.'],
                    ['title' => 'The doors match, because it is one system', 'copy' => 'Our heritage aluminium doors are the same Sheerline Classic system in the same twelve colours, so a run of windows and a garden door line up rather than nearly matching.'],
                ],
                'faqs' => [
                    ['question' => 'Are heritage windows the same as steel windows?', 'answer' => 'No, and that is the point. They are thermally broken aluminium shaped to look like steel, so you get the slim gridded appearance of an original Crittall style window without the cold frame, the rust or the repainting.'],
                    ['question' => 'Can you replace original steel windows with these?', 'answer' => 'Yes, and it is what the system was drawn for. Old steel frames are usually set straight into the masonry, so we survey the opening first and tell you what making good will involve before you order anything.'],
                    ['question' => 'What bar layouts can I have?', 'answer' => 'A Georgian grid, or the horizontal layout that suits a 1920s and 1930s house. Bars can go on every pane or only the ones that need them, and you can put the layout together with the sizes and the colour on our online designer, which prices it as you go.'],
                    ['question' => 'Will they be warmer than what I have now?', 'answer' => 'If you are replacing single glazed steel, considerably. Sheerline publish 1.4 W/m²K for the Classic window double glazed, and the thermal break through the frame is what stops the condensation an old steel window collects, which is the thing people actually notice on a February morning.'],
                    ['question' => 'Do they match your heritage doors?', 'answer' => 'Exactly, because they are the same Sheerline Classic system. The stepped face, the bar spacing and the twelve powder-coated colours are shared, so windows and doors specified together look like one job.'],
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
                /* Rewritten 2026-08-07 with the page rebuild. The five they
                   replace were the generated set and answered nothing: "Are
                   aluminium doors thermally efficient?" was answered with
                   "Modern aluminium doors use thermal breaks and appropriate
                   glazing", which is true of every aluminium door on earth.
                   These answer what the office is actually asked, and they
                   deliberately do not restate the sections above them. Note the
                   cap: `$product_faq_limit` is 5 on this route, so a sixth
                   question here would be silently sliced off the render. Raise
                   the limit in the same commit if you add one. */
                'faqs' => [
                    ['question' => 'Is an aluminium front door cold?', 'answer' => 'Aluminium conducts heat, so the thermal break in the middle of the frame is what decides the answer. Sheerline use a multi-chamber core there rather than a polyamide strip, and the doors we fit reach 1.4 W/m²K double glazed and 1.0 triple. A modern aluminium door is not the cold aluminium of the 1980s, which is where the reputation comes from.'],
                    ['question' => 'Will the door match my aluminium windows?', 'answer' => 'Yes, and it is the usual reason people choose one. The door comes off the same Sheerline frames and the same powder-coated colour range as our aluminium windows, bifolds and sliders, so it can be ordered to the same finish rather than matched by eye afterwards.'],
                    ['question' => 'What colours can I have?', 'answer' => 'Twelve standard powder-coated colours, and any RAL colour beyond them. The inside and the outside can be specified separately if you want a dark face to the street and something lighter in the hall.'],
                    ['question' => 'Can I have glass in an aluminium door?', 'answer' => 'Yes. Glazed panels in the door, side screens beside it and a toplight above it are all configurations of the same system, and obscured glass keeps the daylight without the view in. Which ones your opening will take is settled at survey.'],
                    ['question' => 'What maintenance does an aluminium door need?', 'answer' => 'Washing the frames down two or three times a year is genuinely it. Powder coating does not need painting and will not rot or warp, and the moving parts are the hinges and the lock, both of which we can adjust or replace without touching the door itself.'],
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
                'intro' => 'A uPVC door is not one thing. The same Liniar system makes a single front or back door, French doors that open from the centre, or a stable door split across the middle so the top half opens on its own. Which one suits you is usually decided by the opening and how the room is used.',
                'benefits' => [
                    ['title' => 'Efficient Liniar profiles', 'copy' => 'Multi-chambered uPVC profiles help reduce heat transfer and support a warmer entrance specification.'],
                    ['title' => 'Single, French or stable', 'copy' => 'One leaf for a front or back door, French doors for a wider opening onto a garden, or a stable door where you want air in without the whole thing open. All on the same system.'],
                    ['title' => 'Secure locking options', 'copy' => 'uPVC doors can include multi-point locking, secure cylinders and reinforced hardware for everyday peace of mind.'],
                    ['title' => 'Low threshold choices', 'copy' => 'Threshold details can be reviewed where easier access, garden access or trip reduction is important.'],
                    ['title' => 'Low-maintenance finish', 'copy' => 'uPVC doors do not need painting and can be cleaned easily, with foiled finishes available for a timber-style look.'],
                ],
                'faqs' => [
                    ['question' => 'What configurations do uPVC doors come in?', 'answer' => 'A single leaf for a front, back or side entrance; French doors that open from the centre for a wider opening; or a stable door split across the middle, so the top half can open on its own. The style is drawn on top of whichever you pick: transoms and mullions divide the leaf, and each opening they make is filled with glass or with a panel.'],
                    ['question' => 'Are uPVC doors good for front doors?', 'answer' => 'Yes. Front, rear, side or utility, all on the same system, with the style drawn to suit the opening and the multi-point locking that comes as standard.'],
                    ['question' => 'How secure are uPVC doors?', 'answer' => 'Every door we fit has a multi-point mechanism as standard, throwing hooks or bolts into the frame at several points up the leaf. The cylinder that comes with it is a one star, and a three star cylinder is an upgrade worth asking for, because it is the part that resists snapping.'],
                    ['question' => 'Can uPVC doors be coloured?', 'answer' => 'Thirteen foils, bonded to the profile at the factory rather than painted on. Most carry a woodgrain you can feel and a few are smooth. The colour is the outside face and inside is white as standard, or the same colour on both faces if you prefer.'],
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
                /* Rewritten 2026-08-07 with the page rebuild. The five they
                   replace were the generated set, answered in the third person
                   ("Fenster will help choose") and told nobody anything they
                   could act on. These answer what the office is actually asked
                   and deliberately do not restate the sections above them. The
                   cap on this route is five, so a sixth would be sliced off the
                   render silently; raise `$product_faq_limit` in the same commit
                   if you add one.

                   No decibel figure and no U-value in any answer. We publish
                   neither, and a secondary glazed figure depends entirely on the
                   window it is fitted inside. */
                'faqs' => [
                    ['question' => 'Will it stop me opening my window?', 'answer' => 'No, unless you choose a fixed panel. Horizontal sliders, vertical sliders and hinged units all open, so you reach through, work the original catch and open the window behind exactly as you did before. Fixed panels are for openings nobody uses, and even those can be specified as lift-out so the pane comes away in your hands.'],
                    ['question' => 'Can I have it on a listed building?', 'answer' => 'It is one of the main reasons people have it. Nothing is removed and nothing is cut, the original window stays exactly as it is, and the outside of the building does not change. Your local authority sets the rules for your property, so check with them before you order, and we will work to whatever they tell you.'],
                    /* Even-handed on purpose. An earlier draft answered "is it
                       better than replacing the windows for noise" with "often
                       the stronger answer", which positions our own replacement
                       windows as the weaker choice and is exactly what the
                       comparison rule in TONEOFVOICE.md forbids. Both are things
                       we sell and fit; each gets what it is genuinely best at. */
                    ['question' => 'How does it compare with replacing the windows?', 'answer' => 'They do different jobs. A new window brings the frame, the seals and the glass up to standard in one go, and it is the answer where the existing window is past saving or has to come out anyway. Secondary glazing leaves the original where it is, and the run of air between the two windows is far deeper than the cavity inside a sealed unit, which is the part that works on sound. Ask for the laminated glass upgrade if noise is the whole reason you are doing it.'],
                    ['question' => 'Will it look obvious?', 'answer' => 'The frames are slim aluminium and are made to sit back inside the reveal rather than stand proud of it, so from inside the room the eye reads the original window first. White and brown are the standard colours and any RAL can be matched if a frame needs to disappear into a darker reveal.'],
                    ['question' => 'Can I get a price online?', 'answer' => 'Yes. Secondary glazing is on our online designer alongside the windows and doors, so you can size it, choose the style and get a real figure without waiting for anybody to call you back.'],
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
            /* Rewritten 2026-08-06 with the page. Everything here was
               third-person ("Fenster checks the fault"), which STYLE.md rules
               out, and it described a service without telling anyone what
               anything costs or what to do next.

               The benefits array no longer renders on this route: the generic
               `fg-product-why` block is gated off and the bespoke section
               carries its own content. It stays accurate because Legend reads
               `product_content` for its answers, and a stale benefit list
               would put the old third-person copy into chat replies. */
            'window-and-door-repairs' => [
                'intro' => 'Something has stopped working: a handle has snapped, a door will not lock, a window will not shut. Tell us what it is doing and we will tell you what it usually is, roughly what it costs, and whether it is worth repairing at all. We repair windows and doors we did not fit as readily as ones we did.',
                'benefits' => [
                    ['title' => 'We diagnose before we quote', 'copy' => 'We fit these systems every week, so we know what a symptom usually means before we arrive. A window that will not lock is almost always the mechanism, not the whole window.'],
                    ['title' => 'Repair first, where repair is right', 'copy' => 'If the frame is sound, a repair is the sensible answer and we will say so. We will also tell you when it is not worth it, which is the more useful half of that advice.'],
                    ['title' => 'Windows and doors, any installer', 'copy' => 'uPVC, aluminium and composite, whether we fitted it or somebody else did. Parts availability on older systems is the one thing that decides it.'],
                    ['title' => 'Fairly priced', 'copy' => 'Priced off a set list rather than judged on the doorstep, so the same fault costs the same whoever we send. Quoting is normally free and usually does not need a visit.'],
                    ['title' => 'Our own engineers', 'copy' => 'The same team that installs, not a subcontractor sent out under our name.'],
                ],
                'faqs' => [
                    /* No average and no range. Owner instruction, 2026-08-06: what a
                       repair costs depends entirely on the fault and the parts,
                       and a typical spread invites somebody to hold us to a
                       number that was never about their window. State the floor
                       and state that they get the figure before work starts,
                       which is the part that actually reassures.

                       Two drafts to get this right and both faults are worth
                       knowing. "Rather than quote you an average" explained our
                       thinking to a customer who never asked. And "what it
                       comes to after that" read as though the bill could climb
                       from the £96 without limit, which is the opposite of
                       reassuring on a page about trust.

                       What fixes it is tying the variable to something
                       physical: the price depends on WHICH PART it needs. A
                       part is a bounded thing a customer can picture, where
                       "what it comes to" is open-ended. Do not reintroduce
                       open-ended phrasing next to the from-figure. */
                    ['question' => 'How much does a window or door repair cost?', 'answer' => 'Repairs start from £96 including VAT. The price depends on which part your window or door needs, and you will know the exact figure before any work begins. Nothing changes on the day without a conversation. Tell us what it is doing, send a photograph if you can, and we will come back to you.'],
                    ['question' => 'Do you charge to come out and quote a repair?', 'answer' => 'Normally, no. Most faults we can diagnose and price without coming out at all, from a description and a photograph or two, and where it does need looking at, that visit is normally free.'],
                    ['question' => 'Do you repair windows and doors you did not fit?', 'answer' => 'Yes, and most of our repair work is exactly that. We fit uPVC, aluminium and composite systems every week, so we know the hardware other installers use. The only real limit is parts: on a very old system the gear may no longer be made.'],
                    ['question' => 'My double glazing has gone misty. Is that a repair?', 'answer' => 'It is a glass job rather than a hardware one. The seal around the double glazed unit has failed and moisture is in the cavity, which cannot be dried out, but the glass changes on its own and the frame stays. See our replacement glazed units page for how that works.'],
                    ['question' => 'Can you still get parts for an older window or door?', 'answer' => 'Usually. Hardware is more standardised than it looks, and a mechanism is matched on backset, centres and faceplate rather than on the brand of the window. Where a part genuinely is obsolete we will tell you, and we will say what the alternatives are rather than leaving you with a window that does not lock.'],
                    ['question' => 'Should I repair it or replace the whole window?', 'answer' => 'Repair, if the frame is sound and the fault is hardware or glass, because those are the parts designed to be replaced. Replace, if the frame itself has gone: distorted sashes, failed welds, or a window where you would be repairing the same thing again next year. We will tell you which one you have.'],
                    ['question' => 'Do you cover Milton Keynes and the surrounding area?', 'answer' => 'Yes. We are based on Alston Drive in Bradwell Abbey and cover Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire.'],
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
        /* Heritage window layouts — the data behind the bar planner on
           /heritage-windows/.
           ---------------------------------------------------------------
           It lives here rather than in the template because these are product
           options a customer can order, and this file is where those belong.
           The planner draws from this list, the copy beside it reads from the
           same list, and the colours come from `colour_options` rather than
           being repeated, per the Swatch Provenance Rule.

           NO BAR WIDTH IS PUBLISHED and none is printed. Sheerline give
           sightlines for the frame and nothing for the applied bar, so the
           planner draws a bar at a believable width and dimensions only the
           60.5mm frame, which is sourced. Same position the integral blind
           visualiser takes on slat width. */
        'heritage_window_layouts' => [
            /* Sheerline's own two decorative bar layouts. Their wording for the
               second is a "1920's Art Deco aesthetic"; ours says what it looks
               like, because a customer searching for this describes the house
               rather than the movement. */
            'bars' => [
                ['key' => 'none', 'label' => 'No bars', 'copy' => 'The frame and the mullions do all the work. Right where the openings are already small, or where the original had no bars in it.'],
                ['key' => 'georgian', 'label' => 'Georgian grid', 'copy' => 'Bars both ways, squaring the glass up. The layout most people picture when they picture a steel window.'],
                ['key' => 'horizontal', 'label' => 'Horizontal', 'copy' => 'Bars across only, wider apart. The 1920s and 1930s pattern, and the one that suits a bay or a long low opening.'],
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
            /* Step 04 for the routes that are outside both schemes.
               Owner-confirmed 2026-08-07, in two parts:

                 1. FENSA is not relevant to secondary glazing, roofline,
                    integral blinds or double glazing replacement. A FENSA
                    certificate covers replacement windows and doors and none of
                    those four is one, so the canonical step was promising a
                    document that never arrives.

                 2. **"all non fensa are non CPA too, they're linked."** That is
                    the actual rule and it is worth having written down: FENSA
                    eligibility and the ten year CPA insurance-backed guarantee
                    go together. So a route outside one is outside the other, and
                    there is no such thing as a non-FENSA route that still
                    carries the CPA cover.

               That second point is why this string no longer mentions the
               guarantee at all. An earlier version kept the canonical sentence
               on the grounds that it is scoped to "new windows and doors" and
               therefore still technically true. It is, but leading the aftercare
               step of a secondary glazing page with a ten year insurance-backed
               guarantee that does not apply to what the visitor is buying invites
               exactly the wrong conclusion. Scoping is not the same as honesty.

               It also says nothing about what these products do NOT get, because
               the owner ruled out that register on 2026-08-02: the site does not
               write copy stating what is not covered. What is left is what is
               true and positive, which is that you deal with us.

               One string, not four copies. Six step sets across three templates
               is the mess the 2026-07-29 consolidation cleaned up. */
            'aftercare_outside_fensa_and_cpa' => 'Anything afterwards, you ring us rather than a call centre, and you are talking to the same people who fitted it. We look after our own work rather than passing you on.',
        ],
        /* Repairs: what we fix, and where it lives on the window.
           ------------------------------------------------------------------
           Rebuilt 2026-08-06 (third time) on the owner's brief: the page was
           reading as a one-man-band service list, and it should read like a
           marque's servicing pages. Aston Martin, not the local garage.

           NO PRICES. Owner instruction: the office price list is now the source
           of WHAT WE OFFER and nothing else. Every figure came off the page,
           the price table went, and the services below are the line items from
           that list expressed as work rather than as a tariff. Do not put
           prices back without asking; see the Repair Pricing Rule in AI.md.

           SHAPE. `repair_parts` is the component library: each entry is a real
           part with real studio photography and what actually happens to it.
           `repair_diagnostics` maps a symptom to one of those parts, per
           product. The page draws a technical schematic, and choosing a symptom
           highlights the part on the drawing and shows its photograph. That is
           why `part` here must always match a key in `repair_parts`, and why
           `svg` must match a `data-part` group in the schematic markup — three
           places, and the render harness asserts all three line up.

           The copy stays SHORT. This is the third pass at that: a paragraph per
           item is what made the last two versions a wall of text. */
        'repair_parts' => [
            /* WINDOWS */
            'w-handle' => [
                'name' => 'Handle',
                'sub' => 'Window',
                'image' => '/wp-content/themes/fenster/assets/images/products/handles/s2-chrome-cutout.png',
                'alt' => 'Chrome window handle with its key, off the window',
                'cutout' => true,
                'what' => 'The part you touch every day, so it wears before anything else on the window.',
                'fix' => 'Matched to the spindle length and fixing centres already in the sash, in a finish that suits the rest of the house.',
            ],
            'w-mechanism' => [
                'name' => 'Multi-point mechanism',
                'sub' => 'Window',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-kenrick-excalibur.webp',
                'alt' => 'Multi-point locking mechanism removed from a sash, showing the gearbox and cams',
                'cutout' => true,
                'what' => 'Runs the height of the sash edge and drives the locking points. When a window seizes shut, this is the part.',
                'fix' => 'Identified from the backset, centres and faceplate, then replaced with the correct gear.',
            ],
            'w-realign' => [
                'name' => 'Realignment',
                'sub' => 'Window',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-security-keep.webp',
                'alt' => 'Steel keep set into a window frame, the part a locking cam closes into',
                'what' => 'Not a broken part at all. The sash has settled out of square, so it meets the frame before it meets its keeps.',
                'fix' => 'We square the sash and reset the keeps and hinge packers so it closes under its own weight rather than being pulled to.',
            ],
            'w-draught' => [
                'name' => 'Hinges, or the seal',
                'sub' => 'Window',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/casement-friction-stay-1200w.webp',
                'alt' => 'Stainless friction stay along the bottom of an open window sash',
                'what' => 'One of two things: the hinges are holding the sash off its seal, or the gasket itself has flattened and let go.',
                'fix' => 'We check both. Stays reset or replaced, and the gasket re-run in one length round the sash if it has gone.',
            ],
            /* The image was a stock cutaway of a HEALTHY unit illustrating copy
               about a failed one. Replaced 2026-08-10 with one of ours where the
               moisture is actually visible in the cavity, which is the whole
               point of the entry. Here a close-up is right, because the subject
               is the moisture rather than the window.

               `d-glass` below deliberately KEEPS the generic cutaway: we have no
               photograph of a misted door panel, and a window under a heading
               that says Door is the wrong-product error this file is littered
               with corrections for. A generic sample is the honest placeholder
               until somebody photographs a door. */
            'w-glass' => [
                'name' => 'Sealed unit',
                'sub' => 'Window',
                'image' => '/wp-content/themes/fenster/assets/images/products/replacement-glazing/rg-failed-unit-leaded-1600w.jpg',
                'alt' => 'A failed sealed unit with condensation and water trapped between the two panes',
                'what' => 'When the perimeter seal fails, moisture gets into the cavity and cannot be dried out.',
                'fix' => 'Measured and replaced on its own. The frame stays where it is.',
                'link' => '/double-glazing-replacement/',
                'link_label' => 'Replacement glazed units',
            ],
            /* DOORS */
            'd-lock' => [
                'name' => 'Gearbox, or alignment',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-locking-strip.webp',
                'alt' => 'Locking cams along a door edge and the keeps they close into',
                'what' => 'Either the multi-point gear has failed, or the door has moved and the cams no longer line up with their keeps.',
                'fix' => 'We check the alignment first, because a new gearbox in a dropped door fails again. Then the gear, if it needs it.',
            ],
            'd-cylinder' => [
                'name' => 'Cylinder',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/imported/Lock.jpg',
                'alt' => 'Euro profile cylinder with a thumbturn, three star rated',
                'what' => 'Seizes, or a key snaps in it. Also the part to change when you move in or lose a set of keys.',
                'fix' => 'Replaced to the door thickness, and keyed alike if you want one key for the front and the back.',
            ],
            'd-handle' => [
                'name' => 'Door handle',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/door-handles/chrome-long-plate.png',
                'alt' => 'Chrome long-plate door handle with a cylinder keyhole',
                'cutout' => true,
                'what' => 'The return spring goes, or the spindle rounds off. On a door it happens gradually and then all at once.',
                'fix' => 'Matched to the existing backplate centres and spindle, so the door is not left with holes in it.',
            ],
            'd-realign' => [
                'name' => 'Realignment',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-security-keep.webp',
                'alt' => 'Steel keep set into a door frame, the part a locking cam closes into',
                'what' => 'The door has moved in its frame. It is much the most common door fault, and it is an adjustment rather than a part.',
                'fix' => 'We re-hang the door square and reset the keeps, so it closes and locks without being lifted. Hinges only rarely need changing.',
            ],
            'd-glass' => [
                'name' => 'Sealed unit',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/curated/fenster-double-glazed-unit.jpeg',
                'alt' => 'Sealed double glazed unit cut through to show the two panes and the cavity',
                'what' => 'A door panel is a sealed unit like any other, so when the seal fails it mists in exactly the same way.',
                'fix' => 'The glazed panel is measured and changed on its own. The door stays on its hinges.',
                'link' => '/double-glazing-replacement/',
                'link_label' => 'Replacement glazed units',
            ],
            'd-catflap' => [
                'name' => 'Cat or dog flap',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/pet-flaps/pet-flap-round-glass-closeup.webp',
                'alt' => 'Round pet flap fitted into a glazed door panel',
                'what' => 'The one job on this page nobody is unhappy about. It goes into the door panel, or into a new sealed unit made with the aperture already in it.',
                'fix' => 'A sealed unit cannot be cut once it is made, so which of the two your door needs is settled before anything is ordered.',
                'link' => '/cat-and-dog-flaps/',
                'link_label' => 'Cat and dog flaps',
            ],
            'd-draught' => [
                'name' => 'Realignment',
                'sub' => 'Door',
                'image' => '/wp-content/themes/fenster/assets/images/products/casement/studio/cas-profile-cutaway.webp',
                'alt' => 'Cut-through of a profile showing the chambers and the seal the sash closes onto',
                'what' => 'A draught round a door is nearly always alignment rather than a perished seal: the leaf is not pulling evenly onto its gasket.',
                'fix' => 'We adjust the hinges and keeps so the door compresses its seal along the whole edge instead of at one end.',
            ],
        ],
        /* Symptom to part. Corrected against the owner's own diagnosis,
           2026-08-06, and every change here is him overruling what the page
           said:

             WINDOWS
             - "It will not lock" REMOVED. It was the first symptom on the
               list and it is not a useful one.
             - "Will not open" is the MECHANISM, not the friction stays.
             - "Catches or not flush" is REALIGNMENT, not the keeps as a part.
             - "Draught" is hinges OR the gasket, not the gasket alone.

             DOORS
             - "Will not lock" is the gearbox OR realignment.
             - "Dropped" is REALIGNMENT, hinges only rarely. It was hinges.
             - "Draught" is REALIGNMENT. It was the gasket.
             - The handle entry was showing a WINDOW handle on a door.

           The through-line, and it is worth keeping in the copy: most door
           faults are an adjustment rather than a broken part. Three of the
           five door symptoms answer realignment.

           `svg` is space separated and may name more than one group, which is
           how "hinges or the seal" lights both on the drawing. Every id must
           exist in the schematic markup; the harness asserts it. */
        'repair_diagnostics' => [
            'window' => [
                'label' => 'Windows',
                'caption' => 'Casement, flush, tilt and turn, bay. uPVC and aluminium.',
                'symptoms' => [
                    ['id' => 'w-open', 'symptom' => 'It will not open, or it is stiff', 'part' => 'w-mechanism', 'svg' => 'mechanism'],
                    ['id' => 'w-handle', 'symptom' => 'The handle is broken or loose', 'part' => 'w-handle', 'svg' => 'handle'],
                    ['id' => 'w-catch', 'symptom' => 'It catches, or will not sit flush', 'part' => 'w-realign', 'svg' => 'realign keeps'],
                    ['id' => 'w-draught', 'symptom' => 'There is a draught round it', 'part' => 'w-draught', 'svg' => 'stays gasket'],
                    ['id' => 'w-glass', 'symptom' => 'The glass is misted or broken', 'part' => 'w-glass', 'svg' => 'glass'],
                ],
            ],
            'door' => [
                'label' => 'Doors',
                'caption' => 'Composite, uPVC and aluminium. French, patio, bifold.',
                'symptoms' => [
                    /* Lock side only. It lit the whole leaf outline as well, on the
                       reasoning that the answer is "gearbox OR alignment", but
                       the owner's call is that the drawing should point at the
                       lock. The copy still carries both causes; lighting the
                       entire leaf for a lock fault says less, not more. */
                    ['id' => 'd-lock', 'symptom' => 'It will not lock', 'part' => 'd-lock', 'svg' => 'gearbox'],
                    ['id' => 'd-key', 'symptom' => 'The key will not turn, or has snapped', 'part' => 'd-cylinder', 'svg' => 'cylinder'],
                    ['id' => 'd-handle', 'symptom' => 'The handle is floppy or snapped', 'part' => 'd-handle', 'svg' => 'dhandle'],
                    /* Hinges only on the drawing. The ANSWER is still realignment,
                       which is what the panel says and what the owner confirmed
                       earlier; this is about where the drawing points. A
                       dropped door is a hinge-side story, and lighting the
                       whole leaf outline as well said less rather than more.
                       Same call he made on "it will not lock". */
                    ['id' => 'd-drop', 'symptom' => 'It has dropped, or catches on the frame', 'part' => 'd-realign', 'svg' => 'hinges'],
                    ['id' => 'd-draught', 'symptom' => 'There is a draught round it', 'part' => 'd-draught', 'svg' => 'drealign dgasket'],
                    /* Owner, 2026-08-06: keep glass on doors. It was dropped
                       when his door list did not mention it, which made the
                       drawn panel an orphan group; it is a real fault and a
                       door panel mists exactly like a window. */
                    ['id' => 'd-glass', 'symptom' => 'The glass is misted or broken', 'part' => 'd-glass', 'svg' => 'dglass'],
                    /* Last on the door list, owner instruction 2026-08-06. The
                       only entry that is a request rather than a fault, which
                       is why it is at the bottom and why its copy says so. */
                    ['id' => 'd-catflap', 'symptom' => 'My cat cannot get out', 'part' => 'd-catflap', 'svg' => 'catflap'],
                ],
            ],
        ],
        /* The four things that are true about the way we repair, owner-supplied
           2026-08-06. These are the USPs and they replace "professional
           service" adjectives with something checkable. Two of them — the
           service engineers and the parts sourcing — carry their own sections
           because they are the ones a photograph can prove. */
        'repair_usps' => [
            ['title' => 'Quick and efficient', 'copy' => 'Most faults are diagnosed and priced without a visit, so the first thing that happens is an answer rather than an appointment.'],
            ['title' => 'Dedicated service engineers', 'copy' => 'Two of them, with decades each behind them, and a van carrying the parts that fail most often.'],
            ['title' => 'Transparent', 'copy' => 'You get the figure and the reason for it before anything is agreed, and nothing changes on the day without a conversation.'],
            ['title' => 'Fairly priced', 'copy' => 'Priced off a set list rather than judged on the doorstep, so the same fault costs the same whoever we send.'],
        ],
        /* Scope, taken from the office price list and expressed as work rather
           than as a tariff. This IS the list, minus the money: realignments,
           hinges, mechanisms, handles, adjustments, gaskets, cylinders, gaining
           entry, make-safe, sills, glazing reports and pet flaps. If a service
           is not on that list it does not belong here. */
        'repair_services' => [
            'Window mechanisms and locks',
            'Window hinges and friction stays',
            'Window handles, all finishes',
            'Sash adjustment and realignment',
            'Weather seals and gaskets',
            'Door realignment, single and French',
            'Patio and bifold realignment',
            'Door gearboxes and multi-point locks',
            'Euro and rim cylinders, keyed alike',
            'Door handles and backplates',
            'Door hinges',
            'Gaining entry after a lockout',
            'Making a door safe after a break-in',
            'Sill repairs',
            'Misted and broken sealed units',
            'Cat and dog flaps, into glass or panel',
            'Written glazing surveys and reports',
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
        /* THIRTEEN uPVC DOOR RENDERS, one door in thirteen colours, 1300x867
           on white and all from the same angle and light. They have been in
           `assets/images/products/colours/liniar-door` since launch, referenced
           by nothing, with a note on the Colour Hub Rule reserving them "for
           later door-page use". This is that use.

           THE RANGE IS 16 AND THESE ARE 13 OF IT, so nothing on the page states
           a count against these renders and the colour card still sends people
           to `/colour-options/`, which carries the lot. Smooth White, Silver
           Grey, Basalt Grey and Slate Grey have no door render.

           THEY ARE ALL THE SAME DOOR. That is the constraint the randomiser is
           built around: it may shuffle the finish, because a real render exists
           for each one, and it may NOT shuffle the panel style, because we hold
           one style and captioning a shiplap panel over a flat-panel render
           would be a lie about a product somebody is about to order. When
           WindowCAD supply per-style renders at this size and angle, add a
           `style` key here and the controller picks it up without a rewrite.

           CROPPED THROUGH ONE SHARED WINDOW, 2026-08-12. The supplied renders
           are 1300x867 with the door occupying a 258x762 strip in the middle,
           so on the page the door sat tiny in a field of white. All thirteen
           turned out to be pixel-registered — identical content boxes — so one
           crop, `320x800+522+28`, fits every one of them and the doors stay the
           same size as each other. Same rule as the heritage configuration
           renders and the tilt and turn handles: never re-trim them
           individually. Originals are untouched in
           `assets/images/products/colours/liniar-door`.

           Names are the site's own, and each one joins to `colour_options` by
           name at render time so the chip and the swatch cannot drift apart.
           See the Swatch Provenance Rule in AI.md. */
        'upvc_door_renders' => [
            ['colour' => 'White', 'file' => 'upvc-door-render-white.webp'],
            ['colour' => 'Cream', 'file' => 'upvc-door-render-cream.webp'],
            ['colour' => 'Chartwell Green', 'file' => 'upvc-door-render-chartwell-green.webp'],
            ['colour' => 'Irish Oak', 'file' => 'upvc-door-render-irish-oak.webp'],
            ['colour' => 'Golden Oak', 'file' => 'upvc-door-render-golden-oak.webp'],
            ['colour' => 'Rosewood', 'file' => 'upvc-door-render-rosewood.webp'],
            ['colour' => 'Anthracite Grey', 'file' => 'upvc-door-render-anthracite-grey.webp'],
            ['colour' => 'Black Brown', 'file' => 'upvc-door-render-black-brown.webp'],
            ['colour' => 'Agate Grey', 'file' => 'upvc-door-render-agate-grey.webp'],
            ['colour' => 'Gale Grey Finesse (Anthracite Smooth)', 'file' => 'upvc-door-render-gale-grey-finesse.webp'],
            ['colour' => 'Blue', 'file' => 'upvc-door-render-blue.webp'],
            ['colour' => 'Dark Green', 'file' => 'upvc-door-render-dark-green.webp'],
            ['colour' => 'Dark Red', 'file' => 'upvc-door-render-dark-red.webp'],
        ],
        'door_handles' => [
            /* Owner instruction, 2026-07-29: composite, uPVC, aluminium and
               heritage aluminium only. French doors and aluminium sliding doors
               came off, on the understanding that neither system takes the
               long-plate handle.

               FRENCH DOORS REVERSED, owner 2026-08-07: "can have handle options
               on french doors in hindsight they all use the same". A French door
               is a pair on a door system we already sell, which is exactly what
               AI.md says under the configuration rule, so it takes the same
               long-plate handle as the single leaf. It is back on the list.

               Aluminium sliding doors stay OFF and that is not an oversight: a
               slider takes the architeQ Aspire lift-and-slide furniture, which
               has been its own family in `lift_slide_handles` since 2026-08-03.
               Do not widen this list to it. */
            'slugs' => [
                'composite-doors',
                'upvc-doors',
                'french-doors',
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
                /* Satin is smooth. It was drawn with an feTurbulence fractalNoise layer at
               0.55 opacity, which is a generator of mottle — the one thing real
               satin does not have. Acid-etched glass is an even, flat frost, so it
               is an even, flat wash now: a soft diagonal for a little depth and a
               faint sheen off one corner, and no grain at all. */
            ['name' => 'Satin', 'privacy' => 5, 'texture' => 'radial-gradient(circle at 32% 24%, rgba(255,255,255,0.85), rgba(255,255,255,0) 62%), linear-gradient(135deg, #f7fbfb 0%, #eef6f7 46%, #e4f0f1 100%)', 'copy' => 'Plain satin frosting for maximum privacy with a clean, minimal finish.'],
                ['name' => 'Arctic', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Arctic-privacy-5.webp', 'copy' => 'A strong frosted texture for maximum privacy with a clean, bright look.'],
                ['name' => 'Autumn', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Autumn-privacy-3.webp', 'copy' => 'Soft organic movement that keeps the view diffused without feeling too heavy.'],
                /* Brightness matters as much as contrast here, because the stage multiplies the
               texture over the scene. The first correction fixed the invisibility and
               created the opposite fault: lifting contrast dropped the mean to 106 against
               a set that runs 121 to 178, and a dark texture under `multiply` turns the
               whole pane to mud. Rebalanced to mean 158, stddev 46 — pattern still reads,
               brightness back inside the set.

               The filename carries a suffix because the CONTENT changed. Texture images are
               emitted without a version string, unlike the stylesheet, so replacing a
               .webp in place leaves every browser and proxy that has seen it serving the
               old one — the corrected Cassini was live and invisible for exactly that
               reason. Changing the name changes the URL, which is the only thing that
               reliably busts it. Do the same for any other texture whose pixels change.

               Sized rather than left to `cover`. The stage paints the texture at 122% on
               top of cover, so a photographed pattern is enlarged twice over and
               reads as coarse blobs instead of glass. Pinning the width fixes the
               pattern's scale wherever it is painted — swatch, wall or stage. */
            ['name' => 'Cassini', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Cassini-privacy-5-rev2.webp', 'size' => '500px auto', 'copy' => 'High privacy with a subtle directional texture and a modern finish.'],
                ['name' => 'Chantilly', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Chantilly-privacy-2.webp', 'copy' => 'Decorative and lighter in privacy, useful where pattern matters as much as screening.'],
                ['name' => 'Charcoal Sticks', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Charcoal-Sticks-privacy-4.webp', 'copy' => 'A sharper linear pattern that gives strong screening and a distinctive style.'],
                ['name' => 'Contora', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Contora-privacy-4.webp', 'copy' => 'A classic obscure pattern with confident privacy for everyday glazing.'],
                ['name' => 'Digital', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Digital-privacy-3.webp', 'copy' => 'A crisp modern texture with medium privacy and a more architectural look.'],
                ['name' => 'Everglade', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Everglade-privacy-5.webp', 'copy' => 'Dense texture for stronger privacy in exposed or overlooked glazing.'],
                ['name' => 'Florielle', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Florielle-privacy-4.webp', 'copy' => 'A floral pattern that balances decoration with a useful level of screening.'],
                ['name' => 'Mayflower', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Mayflower-privacy-4.webp', 'copy' => 'Traditional patterning for entrance doors, side panels and character properties.'],
                ['name' => 'Minster', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Minster-privacy-2.webp', 'size' => '450px auto', 'copy' => 'A lighter traditional texture where soft distortion is enough.'],
                ['name' => 'Oak', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Oak-privacy-4.webp', 'copy' => 'Leaf-like movement with strong privacy and a warmer decorative feel.'],
                ['name' => 'Pelerine', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Pelerine-privacy-4.webp', 'copy' => 'Flowing vertical texture for privacy with a quieter, more elegant pattern.'],
                /* The real photograph, scaled rather than redrawn. Two attempts at inventing
               this in CSS were rejected — the flat stripes read as wallpaper and the
               shaded gradient was still a guess at what glass does. The picture is
               the picture.

               What was wrong was never the image, it was `background-size: cover`
               everywhere. The source is 900x474 with about 20 reeds in it, so a reed
               is ~46px of source. `cover` on a 58px swatch scales that to fill the
               box and you see barely one reed; on the stage you see five. Hence
               'too big' at every size.

               `size` pins it instead, so a reed is the same width everywhere rather
               than a function of the box it lands in. 180px puts a reed at ~9px: six
               on the 58px swatch, twenty-seven on a hero tile and about seventy across
               the full stage. Seventy reeds of ~10mm is roughly 700mm of glass, which
               is a real door pane, so the big view is the one that is honest and the
               others follow from it. Rendered 140, 180 and 220 side by side at all
               three box sizes before settling on it.
               Height 100% because the reeds run vertically, so stretching that axis
               costs nothing and avoids a horizontal seam where the tile repeats. */
            ['name' => 'Reeded', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Reeded-privacy-2.webp', 'size' => '180px 100%', 'copy' => 'Linear ribbing with partial privacy and a contemporary look.'],
                ['name' => 'Stippolyte', 'privacy' => 4, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Stippolyte-privacy-4.webp', 'size' => '380px auto', 'copy' => 'Fine broken texture that gives reliable privacy without a large pattern.'],
                ['name' => 'Sycamore', 'privacy' => 2, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Sycamore-privacy-2.webp', 'copy' => 'A lighter patterned option for softer privacy and decorative daylight.'],
                ['name' => 'Taffeta', 'privacy' => 3, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Taffeta-privacy-3.webp', 'copy' => 'Medium privacy with a woven texture that feels subtle from a distance.'],
                ['name' => 'Tribal', 'privacy' => 5, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Tribal-privacy-5.webp', 'copy' => 'High privacy with a bolder decorative pattern for statement glass.'],
                /* Owner correction, 2026-08-06: Warwick is privacy 1, not 0. Zero is a real
               category on this page — the picker prints "Decorative" instead of a
               number and the copy said outright it was not a privacy choice — so this
               was not a rounding difference, it was the wrong category. The filename
               still says privacy-0; left as is, since renaming the asset is a bigger
               change than the owner asked for and nothing reads the filename itself. */
            ['name' => 'Warwick', 'privacy' => 1, 'image' => '/wp-content/themes/fenster/assets/images/products/obscure-glass/Warwick-privacy-0.webp', 'copy' => 'A handmade-style texture with character and the lightest level of privacy.'],
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
