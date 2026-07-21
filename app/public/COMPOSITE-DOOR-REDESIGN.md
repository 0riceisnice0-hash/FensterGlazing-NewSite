# Composite Door Page Redesign V2

## Purpose

This document records the route-specific redesign of `/composite-doors/`. The finished page is a compact buying journey for the Distinction doors Fenster actually installs. It replaces the rejected card-heavy first version with one range studio and one finish configurator.

The implementation lives in:

- V2 section: `wp-content/themes/fenster/template-parts/sections/composite-doors-v2.php`
- Route assembly: `wp-content/themes/fenster/template-parts/sections/generated-page.php`
- Product facts: `wp-content/themes/fenster/inc/site-data.php` and `inc/product-hub-data.php`
- Styling: `wp-content/themes/fenster/src/scss/main.scss`
- Interaction: `wp-content/themes/fenster/src/js/main.js`
- Optimised imagery: `wp-content/themes/fenster/assets/images/products/composite-distinction/`
- Image build: `wp-content/themes/fenster/scripts/build-composite-door-assets.py`

## Product truth

Fenster is an approved installer of Distinction Doors. The page only presents the ranges Fenster sells:

- Signature for traditional designs;
- Contemporary for cleaner grooves and glass layouts;
- Rustic Renown as the cottage-style Signature design.

`nxt-gen` and Grandeur are not sold and must not be reintroduced. Rustic Renown is not described as a separate manufacturer collection. The old blanket `Any RAL colour` claim is also removed. Current colour, glass and compatible hardware availability is confirmed during consultation and survey.

## V2 design model

The page uses the site-wide `--fg-page-gradient` as one continuous canvas. The only full dark interruptions are functional: the hero, the approved-installer banner, the configurator action strip and the final enquiry section.

The main journey is deliberately short:

1. Category hero and direct calls to action.
2. Approved Distinction installer proof.
3. One range studio for Signature, Contemporary and Rustic Renown.
4. One tabbed configurator for colour, glass and hardware.
5. FAQs, quote, reviews and a product-scoped enquiry.

The generic four-card specification pulse is suppressed for this route. The V1 collection grid, comparison table, inspiration gallery, separate colour wall, separate glass wall and standalone hardware band are not rendered.

## Range studio

The range studio keeps one large door image visible. Tabs change the image, product description, best-use guidance and compact specification list. Three small facts above it provide the shared slab, installer and security information without creating another card section.

Desktop and tablet use the available width for a two-column visual and control layout. Narrow phones use one large image followed by three compact tabs and one detail panel.

## Finish configurator

Colour, glass and hardware occupy the same component and only one panel is visible at a time.

- Colour shows eight photographed examples as compact swatches and names, plus `And more`, with one large door preview.
- Glass shows compact design names, including Chatsworth and Wentworth, with one large close-detail preview.
- Hardware uses eight finish controls and one dark presentation stage. The selected handle and supporting text change without collapsing the media box.

The selector thumbnails were deliberately removed. The customer chooses a label or swatch and sees one useful image rather than scanning a wall of repeated doors.

## Source imagery

The approved imagery comes from:

`C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape`

The repeatable build creates 75 responsive WebP assets. The V2 hero uses an approved Signature entrance, family images are portrait-led, colour examples show real doors, glass uses visible close-ups and hardware retains fixed-size transparent product imagery.

## Responsive rules

- Section H2 headings resolve to 24.8px on phone and tablet and 28.8px at 1440px.
- Phone is designed at 390 × 844 with no horizontal overflow.
- Tablet is designed at 768 × 1024 and uses the compact two-column studio.
- Desktop is designed at 1440 × 900 with both main interactive compositions kept within the viewport height.
- Preview boxes have explicit dimensions, so changing an image cannot collapse or jump the page.
- Only one range image, range panel and configurator panel may be visible at once.

## Verification

Protected-test browser QA on theme revision `7aae3b0` confirmed:

- no broken images at 390, 768 or 1440 pixels;
- no horizontal overflow at any tested width;
- phone configurator height 842.9px inside an 844px viewport;
- tablet configurator height 804.5px inside a 1024px viewport;
- desktop configurator height 814.6px inside a 900px viewport;
- Rustic Renown updates the range image and copy;
- Chatsworth updates the glass preview;
- Chrome updates the hardware image and supporting panel;
- the continuous route gradient remains visible behind FAQ, quote and review sections.

**Status: LIVE (verified 2026-07-20).** `/composite-doors/` serves this V2 template on production.

**Update 2026-07-21 (test, `54281d4`).** The owner judged the live page "not good enough" and asked for major improvements using the Distinction scrape content. The substance pass on test adds a `What is inside the slab.` construction section (cutaway asset under `assets/images/products/composite-distinction/anatomy/`, six numbered layers, a four-stat strip and the Salford Energy House thermal-test footnote), `Best for` panels on both collection cards, a one-in-four proof line in the installer banner, a route-gated `Send an enquiry` hero CTA and a page-wide copy rewrite in the `TONEOFVOICE.md` voice, including factual FAQ answers. Accuracy rules from the scrape: Chatsworth and Wentworth glass are double glazed while most other designs are triple glazed and laminated; Secured by Design covers the slab but not stable doors, so SBD is claimed only in the security FAQ with that caveat.

It reached live unintentionally. The route never had a host gate, so it deployed with the theme as soon as live moved past `13e7f95` — see the 2026-07-20 entry in `PROGRESS.md` for the full account. The owner reviewed the live result on 2026-07-20 and decided to keep it up and continue work directly on live rather than pull it back to test.

Note that the doc previously described V2 as suppressing the inspiration gallery and comparison table. That is out of date: `0610753` and `46a961f` rebuilt the range around the full Distinction set and added a deterministic gallery mosaic, and that is what production serves.

## Maintenance rules

- Keep the sold-range list accurate.
- Do not turn Rustic Renown into a standalone manufacturer collection.
- Do not restore the inspiration gallery or separate selector sections without a new customer-journey reason.
- Add a colour or glass option only when a suitable visual asset exists; otherwise retain `And more`.
- Preserve fixed preview heights and single-panel tab behaviour.
- Build and verify all three target viewports before promotion.
