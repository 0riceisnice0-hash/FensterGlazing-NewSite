# Composite Door Page Redesign

## Purpose

This document records how `/composite-doors/` was rebuilt from a long generic product page into a visual, responsive buying journey based on the Distinction Doors range.

It follows the method documented in `SASH-PAGE-REDESIGN.md`: make the customer decisions clear first, approve the imagery, then build separate mobile and desktop presentations around the same content.

The implementation lives in:

- Template: `wp-content/themes/fenster/template-parts/sections/generated-page.php`
- Shared product facts: `wp-content/themes/fenster/inc/site-data.php`
- Styling: `wp-content/themes/fenster/src/scss/main.scss`
- Interaction: `wp-content/themes/fenster/src/js/main.js`
- Optimised imagery: `wp-content/themes/fenster/assets/images/products/composite-distinction/`
- Repeatable image build: `wp-content/themes/fenster/scripts/build-composite-door-assets.py`

## Original problems

The inherited product template made the route much longer than the decision required. It repeated the introduction and benefits through several generic sections, sent visitors to a global colour page that did not explain the Distinction range, showed eleven decorative-glass cards in one wall, and used the same large universal door-handle selector as unrelated door systems.

The page had products and choices, but not a useful order for making them.

## Customer journey used

The rebuilt route now follows this order:

1. See a strong entrance image and understand the category.
2. Scan four truthful key facts.
3. Compare Signature, Contemporary, nxt-gen and Grandeur visually.
4. Read the meaningful construction and design differences.
5. Browse six entrance, glass and interior contexts.
6. Start a price or consultation while intent is high.
7. Refine colour, decorative glass and hardware in one route-specific section.
8. Resolve product questions.
9. Open the preselected Composite Doors quote tool.
10. Read relevant customer proof and send a compact, pre-scoped enquiry.

The generic product-introduction, product-intel, visual-gallery, colour-hub, glass-wall, universal-hardware, order-process and related-link sections are suppressed at the PHP level for this route. They are not merely hidden with CSS.

## Distinction source work

The source scrape was:

`C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape`

The scrape contained 1,098 image files. Images were narrowed by source page, file dimensions and subject, then every selected source was visually inspected before use.

Approved imagery covers:

- a Grandeur entrance for the responsive hero;
- one visually distinct image for each of the four collections;
- six inspiration views covering traditional, modern, large-glass, colour-led and interior contexts;
- six close decorative-glass details.

The build script creates WebP variants rather than shipping the original multi-megabyte files. The hero has 480, 960 and 1920 pixel sources; family images have 400 and 800 pixel sources; gallery images have 480, 800 and 1400 pixel sources.

## Product facts and claim handling

The page distinguishes between the standard 44mm composite slab and the Grandeur 70mm double-rebated option. Grandeur's 50mm triple-glazed laminated glass and the supplier's 35% thermal-efficiency comparison are labelled as collection-specific facts, with a note that final doorset performance depends on frame, glass and the complete specification.

The old blanket `Any RAL colour` statement was removed. The new colour section describes stock, bespoke and dual-colour directions and tells customers to confirm from a physical sample. Glass and hardware availability is also described as dependent on collection, aperture and lock-compatible specification.

This matters because Distinction supplies components and Fenster specifies and installs the finished doorset.

## Mobile design

Mobile is deliberately one decision at a time:

- the hero uses a 480 pixel responsive image and a controlled crop;
- the four collections are a full-width swipe carousel with previous/next controls, position dots and a selected-collection specification panel;
- the wide comparison table is removed from the mobile layout;
- the inspiration gallery is a snap-scrolling rail with one large image in view;
- colour remains a visual card instead of becoming another link panel;
- glass and hardware are fixed-size horizontal rails, so image loading cannot collapse the layout;
- the external Composite Doors quote tool opens directly instead of embedding a cramped iframe;
- the final enquiry form is compact and locked to Composite Doors.

## Desktop design

Desktop uses the width to compare without imitating a stretched phone layout:

- all four collections are visible together in equal-height image-led cards;
- one five-column table states the shared differences once;
- the six-image inspiration gallery becomes an editorial collage;
- colour uses a large two-column image-and-swatch composition;
- glass becomes a six-item visual grid;
- hardware is a compact four-finish strip;
- the quote tool remains embedded for visitors who want to design in-page.

## Maintenance rules

- Keep the four family descriptions tied to current Distinction collection information.
- Do not add a claimed whole-door U-value without a confirmed complete doorset specification.
- Do not promise that every colour, glass or handle works with every collection.
- Add gallery images only after visual inspection and create all responsive variants.
- Keep mobile family cards at one per viewport.
- Preserve fixed media dimensions in the glass and hardware rails.
- If the Distinction range changes, update both the family data and comparison values together.

## Verification standard

Before promotion from protected test to live, verify:

- 390 × 844 mobile;
- 768 × 1024 tablet;
- 1440 × 900 desktop;
- family next, previous, dots and swipe;
- selected mobile specification updates;
- hero `srcset` selection;
- gallery and glass/hardware image loading;
- no horizontal page overflow;
- direct mobile quote action and desktop quote embed;
- FAQ, review and compact enquiry order;
- homepage and `/online-quote/` smoke checks.

The page must remain test-only until the owner explicitly approves promotion to production.
