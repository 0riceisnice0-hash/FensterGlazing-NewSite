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

## Door style wall and paint range (2026-07-21)

Two sections are built from the Distinction scrape and committed as theme assets by `scripts/build-composite-door-wall.py`. Re-run that script rather than hand-editing the assets; the scrape must never become a runtime dependency.

- `.fg-cd3-wall` renders 27 real door faces from the Signature and Contemporary catalogues (`assets/images/products/composite-distinction/styles/`). Every door carries its real style name so a customer can ask for it by name. Style names come from the Distinction Signature and Contemporary product pages in the scrape; do not invent names for door codes those pages do not list.
- The wall list is deliberately rendered twice. The second pass is `aria-hidden` with class `is-clone` and exists only so the desktop marquee loops seamlessly. At `860px` and below, and under `prefers-reduced-motion`, the animation stops, the clone is hidden and the viewport becomes a native scroll-snap rail. Keep all three of those behaviours together; an auto-running marquee fights touch scrolling.
- `.fg-cd3-palette` renders 23 Distinction paint colours photographed as brush strokes (`assets/images/products/composite-distinction/palette/`), with the RAL and BS references printed in the Distinction brochure. Do not replace these with flat CSS colour blocks; the texture is the point. The blanket "any RAL colour" claim stays excluded per `AI.md`.

The construction section uses one static cutaway. An interactive per-layer version was built and rejected by the owner on 2026-07-21; do not rebuild it.

Every composite section is held inside a single `1440x900` viewport (about `830px` below the header). Measure before and after any change to this route.

## Collections: WindowCAD is the source of truth (2026-07-22)

The business owner's decision is that the quote tool and the website must name the same collections, and that Distinction's own Signature/Contemporary split is not used anywhere customer-facing.

Fenster's composite collections, read from the live WindowCAD retail designer:

| Collection | What defines it |
| --- | --- |
| Traditional | Panelled, with the glazed section cut into the panel. By far the biggest group. |
| Esprit | One flat woodgrain panel, no panel detail. |
| Rustic Renown | Shiplap boards inside a plain border. |
| Renown | Full shiplap edge to edge, no border. |
| Infinity | Long horizontal grooves, the most modern end. |
| Stable Doors | Split across the middle, top half opens alone. |

Representative door per collection, set by the owner on 2026-07-22:

| Collection | Owner's door | What is actually rendering |
| --- | --- | --- |
| Traditional | Esteem | Esteem |
| Esprit | ESC09 | **ESC19** — ESC09 is not in the scrape |
| Rustic Renown | RR03 | RR03, cropped from a lifestyle photograph |
| Renown | (unchanged) | Renown RE02 |
| Infinity | GD02C | **GD01** — GD02C is not in the scrape |
| Stable Doors | RES05 | RES05 |

**`RES*` codes are stable doors, not Rustic Renown.** They carry the horizontal split across the middle. Three door-wall entries were mislabelled as Rustic Renown until the owner corrected it; do not reintroduce that mapping. The only Rustic Renown asset anywhere in the scrape is `Diamond-rustic-Renown-Basalt-Grey@2x.jpg`, a lifestyle photograph, cropped to the door face by the build script. Replace it with a flat render the moment one is supplied.

Rules:

- **Within a collection the panel is the constant and the glass varies.** That is the useful thing to tell a customer and the reason the collections exist; say it rather than listing style codes.
- Side panels are a configuration option that attaches to any collection, not a collection. Keep them as a note.
- To verify or update this list, open `https://www.windowsoftware.co.uk/windowcad7/?interface=retail&username=fensterglazing&productCollection=4`, advance one step past Sizes, and read the `Door style` group headings. Change `scripts/build-composite-door-wall.py` and `$composite_collections` together, then rebuild the assets.
- Do not reintroduce Signature, Contemporary, Venture, Grandeur or nxt-gen as customer-facing groupings. Distinction style *names* (Elegance, Esteem, Renown Diamond) are fine; their *collections* are not.

## The £5,000 break-in guarantee

Terms confirmed by the owner on 2026-07-22, so this is settled and is also recorded in `AI.md`. Every Distinction door we fit is secured with **AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock**. Should either fail in a break-in the customer is covered for **up to £5,000 in compensation**, terms and conditions apply.

- Call it a **break-in guarantee**, not a vague "security guarantee".
- Name the three lock components wherever the claim is made prominently; they are what the guarantee rests on.
- Keep the terms-apply caveat, and do not invent payout conditions beyond the above.
- Secured by Design covers the door slabs but **not** stable doors. Keep that exclusion stated.
- The band uses an inline SVG shield (`.fg-cd3-shield`) rather than an image, so it stays sharp at any size and needs no asset pipeline. It sits in a two-column lockup beside the copy; floating it above the copy is what made it look pasted on, and removing it altogether was a mistake the owner corrected on 2026-07-22. **Keep the badge.**
- **There is no APECS logo asset anywhere in this project** and there never has been: not in `assets/`, not in uploads, not in the Distinction scrape, not in git history. The only APECS material is two scraped content pages (`apecs-ingenious-locks-and-hardware`, `apecs-terms-conditions`). If the owner wants an APECS mark on this band, the artwork has to be supplied first.

## Hero pattern

The hero follows `/roof-lanterns/` and `/heritage-aluminium-doors/`: light page canvas, copy left, boxed image with a caption chip right, three ticked reassurance bullets, then a four-item specification strip. **The styling is shared, not duplicated** — `.fg-cd3-hero*` and `.fg-cd3-brief*` are added to the same selector lists as `.fg-heritage-door-hero*` and `.fg-heritage-door-brief*` in `main.scss`, so the three routes stay in step. If you restyle one, you restyle all three; that is deliberate.

Composite no longer uses the shared `.fg-hero` at all. Other product routes are untouched and keep the dark photo hero.

Any link that acts as a call to action on this route is a button, not a text link.

## Conversion model (2026-07-22)

The route is built around the question visitors actually arrive with, which is what a fitted door costs.

- The hero card carries the checked WindowCAD example published on `/composite-door-prices/`. **If that guide's figure or specification changes, change it here too**; a price that disagrees with the guide is worse than no price.
- `fg-hero--composite` exists purely to opt this route back into the hero card, which `.fg-hero--compact` hides everywhere else. Do not remove the modifier without moving the price anchor somewhere equally prominent.
- Primary hero action is the instant quote tool, not the enquiry form. The quote tool is what generates priced WindowCAD leads on this route.
- The page carries seven lead routes on purpose: instant price, enquiry, prices guide, phone in the proof bar, phone in the hero card, the door wall action row, and the quote embed. Do not collapse these into one CTA.
- Composite allows six FAQs rather than the usual five so the price question and the U-value answer can both render. Check `$product_faq_limit` before adding another.

## Maintenance rules

- Keep the sold-range list accurate.
- Do not turn Rustic Renown into a standalone manufacturer collection.
- Do not restore the inspiration gallery or separate selector sections without a new customer-journey reason.
- Add a colour or glass option only when a suitable visual asset exists; otherwise retain `And more`.
- Preserve fixed preview heights and single-panel tab behaviour.
- Build and verify all three target viewports before promotion.
