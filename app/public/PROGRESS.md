# Fenster Glazing Progress Log

Last updated: 2026-07-06

## 2026-07-06 - Launch Documentation, GitHub And Mobile Polish

- Pushed the scoped project to GitHub at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`, keeping the repo focused on the custom theme and docs rather than WordPress core, uploads, `wp-config.php`, local backups or the `wp-content\fenster-reference` archive.
- Clarified the launch deploy model in the docs: update/swap `wp-content\themes\fenster` from the repo, leave production database/uploads/plugins/config in place, and keep reference archives out of production.
- Fixed mobile About page process cards so text has proper internal padding and no longer touches the card border.
- Fixed mobile Contact page CTA cards so the image overlays, headings, body copy and action arrows are readable and no longer overlap.
- Simplified mobile quote-tool actions on `/online-quote/` and product quote embeds: mobile now shows one same-tab `Open quote tool` action, while desktop keeps `Expand view` and `Open in new tab`.
- Rebuilt compiled CSS and linted changed PHP templates for the mobile quote/link changes, then browser-checked the About, Contact, online quote and product quote embed views at mobile size.
- Updated `AI.md`, `HANDOVER.md`, `HOMEPAGE.md`, `STYLE.md`, `PROGRESS.md` and `AUDIT.md` with the launch state, GitHub scope, SEO work, deploy boundary and mobile quote behaviour.

## 2026-07-06 - Launch SEO Hardening Pass

- Overrode the imported homepage SEO with a launch-focused title and meta description targeting double glazing, windows and doors in Milton Keynes, Bedfordshire and Buckinghamshire.
- Added per-request memoisation for `fenster_get_generated_page()` so repeated title/meta/schema/preload/router lookups do not rebuild the same generated page payload within one request.
- Removed the remaining public no-cache behaviour for generated pages and XML sitemaps by replacing WordPress default headers with short public cache headers for logged-out visitors.
- Added generated `BreadcrumbList` JSON-LD on deep generated routes, rolling commercial county pages up to `/commercial-glazing/` and residential product/location pages up to `/areas-we-cover/`.
- Added 301 normalisation for generated routes without trailing slashes and for mixed-case generated URLs, verified with `/casement-windows` and `/Casement-Windows/`.
- Tightened sitemap hygiene: thin utility/scrape shell pages (`gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `brochures`, `apecs-terms-conditions`, `fenster-partners`) now render `noindex,follow` and are excluded from the sitemap.
- Removed the temporary `/commercial-areas/` developer shortcut from the public header navigation.
- Added `/areas-we-cover/` to the footer company links and `/terms-conditions/` to the footer legal links.
- Verified rendered output locally: homepage title/meta/canonical correct, breadcrumb schema present on `casement-windows-toddington`, homepage no longer links to `/commercial-areas/`, noindex pages render noindex, sitemap excludes the utility debris and contains 427 URLs, cache headers are public on generated pages/sitemaps, and PHP lint passed for all changed PHP files.

## 2026-07-03 - Residential Location Metadata De-Duplication

- Reworked generated residential product/location metadata in `inc\generated-pages.php` so the 13 town x 21 product matrix no longer uses one duplicate meta-description template.
- Added town profile and product profile data for residential matrix SEO titles/descriptions, varying snippets by property context, local planning priority and product decision points.
- Verified all 273 residential matrix pages render unique meta descriptions, with zero duplicate meta groups and zero fetch errors.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Commercial County Coverage And Meta Tightening

- Removed `/commercial-glazing-isle-of-wight/` from the generated commercial county profile set because ferry/island access is not credible normal commercial coverage for Fenster.
- Added the removed Isle of Wight commercial route to the central 410 Gone list so it does not remain indexable or appear as an ambiguous missing page.
- Reworked commercial county title tags and meta descriptions so they use each profile's county, town examples and project context rather than one near-duplicate metadata template with only the county swapped.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Launch Blocker Fixes (Schema, Reference Assets, Sitemap, Debris Routes, Article Template)

- Captured the full 2026-07-03 master site audit and remediation status in `AUDIT.md`, keeping the audit/backlog separate from this chronological progress log.
- Fixed the structured-data bug where the shared bad-SEO-content check rejected every JSON-LD block (all valid JSON starts with `{`), so no schema ever rendered. Imported scrape schema is now intentionally dropped (it contained old designer-tool VideoObject markup, `test.fensterglazing.com` image URLs and unsubstantiated aggregateRating values) and replaced with generated schema: a site-wide `HomeAndConstructionBusiness` LocalBusiness block from brand data in `inc\generated-pages.php`, plus `FAQPage` JSON-LD on product journey pages built from the same FAQs rendered on the page.
- Removed the runtime dependency on the 2.4 GB `wp-content\fenster-reference` scrape export. Copied the 356 images actually referenced by templates and `data\pages.json` into `assets\images\imported`, rewrote all references (2,577 in `pages.json` plus eight PHP files), re-encoded the 2.9 MB PNG homepage hero poster to a 175 KB JPEG (`home-hero-poster.jpg`), and deleted the dead bifold scroll-video branch that referenced reference-folder media. The reference folder must not be deployed to production and is no longer needed at runtime.
- Fixed sitemap/robots plumbing: disabled core `wp-sitemap.xml` (it advertised a parallel incomplete URL set and a users sitemap), and the robots.txt filter now strips stale Sitemap lines and appends `home_url('/sitemap.xml')`. The custom sitemap index loc also uses `home_url()`.
- Added debris-route handling in `inc\generated-pages.php`: 410 Gone for test pages (`nick-test-baboon`, `our-new-website`, `case-studies/test`, `case-studies/template-new`); 301 redirects for duplicate town slugs (`dunstable-casement-windows`, `bow-and-bay-windows-northampton`, `tilt-and-turn-windows-northampton`), `commercial-glazing-london-2`, `healthcare_safeguarding_in_construction`, `enquire-now`, `instant-pricing` and all `*-designer` pages (to their base product, else `/online-quote/`); `noindex,follow` for the live ad landers (`pricing-gads`, `instant-pricing-meta-ads`, `ppc-landing-page-composite-doors`, `roof-lanterns-landing-page`) and all `category/`, `tag/`, `author/` and `blog/page/` archive shells. The custom sitemap skips gone/redirected/noindex slugs (486 down to 436 URLs).
- Replaced the slug-substring product heuristic in `template-parts\sections\generated-page.php` with explicit product/commercial route whitelists, so ~40 blog and guide articles no longer render the product journey with broken headings ("Why choose Are My Windows Energy-Efficient??").
- Added `template-parts\sections\generated-article.php`: a readable article layout (moderate hero, constrained article body with real scraped headings/paragraphs, inline images, compact shared enquiry form CTA, related links) plus `.fg-article-page` SCSS, hooked into the guardrail heading scale.
- Kept `/other-services/` on the simple layout via the utility list so it does not read as a fake product page.
- Verified via rendered checks: LocalBusiness schema on every page, FAQPage on product pages, robots.txt points at the custom sitemap, wp-sitemap 404s, all redirects/410s/noindex resolve correctly with 200 targets, articles render the new template, product/location/commercial/hub/utility pages unchanged, homepage internal links all 200, PHP lint and `npm.cmd run build` pass.

## 2026-07-03 - Sliding Sash Windows Roseview Model Page

- Reworked `/sliding-sash-windows/` with a dedicated Roseview comparison section for Ultimate Rose, Heritage Rose and Charisma Rose.
- Added curated Roseview export imagery under `assets\images\products\sash-roseview` so the page shows clear model and detail differences rather than relying only on generic product gallery images.
- Added customer-facing model guidance covering best-fit use cases, meeting rail sizes, corner construction, frame depth, glass unit depth, energy rating and ThermoVFlex routes without inventing unsupported Fenster specifications.
- Added sash-specific visual detail sections for meeting rails and mechanical/welded joints, using the existing `data-fg-depth` scroll-depth behaviour for desktop parallax and static mobile fallbacks.
- Replaced the generic window-handle treatment on `/sliding-sash-windows/` with Roseview-specific sash furniture: Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, extra Shark Fin/D Handle options and the Roseview under/over 700mm furniture-count rule.
- Replaced the inherited Liniar product-hub system badge on `/sliding-sash-windows/` with a Roseview system entry and local Roseview logo from the Roseview scrape. The first copied logo was white/invisible on the white badge, so the route now uses the visible local `assets\partners\roseview-logo-new.png` file and product hub system logos are routed through `fenster_generated_url()`.
- Styled the new sections inside the existing continuous page background model from `STYLE.md`, with responsive model cards, a horizontally scrollable mobile comparison table and no standalone forms.
- Verified in the rendered local page: Liniar is not visible on the sash page, the Roseview logo loads, all 10 sash furniture images load after lazy scroll, the furniture cards align on desktop, the new sash furniture section does not cause mobile overflow, PHP lint passes and `npm.cmd run build` passes.

## 2026-07-02 - Commercial County Landing Pages

- Removed `Commercial Buckinghamshire` from the Commercial header dropdown so SEO location pages are not exposed as normal commercial menu items.
- Added a temporary noindex `/commercial-areas/` developer review page and a header `Areas` shortcut listing all generated commercial county landing pages.
- Added generated commercial glazing landing pages for England's county set using `fenster_commercial_county_profiles()` in `inc\generated-pages.php`.
- Generalised `template-parts\sections\commercial-county.php` so every county page renders unique county-specific H1, meta description, town coverage, context copy, FAQs and planning notes.
- Moved the shared compact enquiry form into the county hero and added a clearly visible phone CTA for commercial enquiries.
- Included the commercial county pages in the generated sitemap while keeping `/commercial-areas/` out via `noindex`.
- Rebuilt compiled CSS/JS and verified 48 county pages render, all with unique H1/meta descriptions, one shared form and visible phone number.

## 2026-07-02 - Trust Page And Homepage Trust Link

- Added a hardcoded virtual `/why-trust-fenster/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Built `template-parts\sections\trust-page.php` with stronger buyer-facing trust content: verifiable public reviews, local showroom accountability, why Fenster was made, survey-led process, customer information handling, accreditations and contact routes.
- Revised the page again to use the real customer-facing trust story: started in 2018, 8 years trading, around 25 years combined glazing experience, transparent upfront pricing, honesty and highly trained fitters.
- Reduced the trust-page heading scale so the page header reads as a customer information page rather than an oversized marketing hero, and added a site-wide typography rule to `STYLE.md`/`AI.md` to stop future AI passes making normal page headers too large.
- Added an end-of-stylesheet normal-page H1 guardrail covering contact, simple utility, trust, team, about and areas pages so late page-specific overrides cannot accidentally push them back to oversized hero type.
- Reused the shared review showcase component and existing showroom/trust assets rather than duplicating review data.
- Added a small centred homepage trust-bar link beneath the four logo/review cards, plus a footer company link.
- Reworked the trust page again into a more image-led customer confidence page, using showroom/about imagery, three team portraits and curated product images across a hero collage, visual proof mosaic, team strip and product proof cards.
- Browser-checked `/why-trust-fenster/` at `1440 x 900`, `768 x 1024` and `390 x 844`: 18 trust-page images render in the DOM, the new visual/team/product sections are present, there is no horizontal overflow and no console errors.
- Direct URL checks passed for the new showroom, team and product image assets used on the trust page.
- Replaced the fussy trust-page hero collage and visual proof mosaic with a simpler competitor-style layout: one large hero image, two large image/content proof rows, and a named team strip linking to `/meet-the-team/`.
- Replaced Zac Bartley's Meet the Team portrait with the supplied black-and-white image and made Zac's team-page image load eagerly.
- Reworked the trust page again so the hero uses a 2x2 Google, Trustpilot, FENSA and CPA proof grid instead of a product photo, added a clear mission statement near the top, expanded showroom/survey/customer-choice copy, and changed the team strip to Nick Baker, Adam Butcher and Perry Giffin with job titles.
- Refined the trust page tone and layout: removed the extra practical-reasons block from the hero, gave the mission statement a soft translucent bordered panel, rewrote team/product copy in a calmer UK customer-facing tone, changed product cards back to normal dark text, and replaced the old care section with the product-page order process rail.
- Tightened the trust page follow-up: added showroom and product CTAs to the two feature sections, made team job roles visible as image labels, nudged Perry's portrait crop upward, and removed the separate Products and Choices section entirely.
- Polished the homepage/product/about/contact pass: changed the homepage pricing bridge to a live instant quote iframe with softer quote wording, removed the commercial-heavy Proof in the Work strip, changed product galleries from 4x4 to fixed 2x2 mosaics, auto-loaded product quote iframes, swapped the roof lantern page to better S1 lantern scrape imagery, changed the About hero to the showroom image, and put the instant quote screenshot behind the Contact quote CTA.

## 2026-07-01 - Contact Page Hub Refresh

- Reworked `/contact/` into a stronger first-screen contact hub with two oversized interactive route panels: `Instant quote` and `Consultation`.
- Kept direct phone, email and showroom routes visible beneath the primary panels, then preserved the showroom map, enquiry form, reviews and useful links below.
- Used the existing showroom image as a real visual asset and kept the page on the continuous site background from `STYLE.md`.
- Added final contact-hub SCSS overrides and rebuilt compiled CSS/JS with `npm.cmd run build`.
- PHP lint passed for the contact template.
- Browser-checked `1440 x 900`, `768 x 1024` and `390 x 844`: no horizontal overflow, no console errors, two hub cards render, instant quote links to `/online-quote/`, and consultation targets the showroom section.

## 2026-07-01 - Product Gallery Expansion

- Added a picture-heavy `Product gallery` section to product journeys, rendering a 16-image mosaic with SEO-supporting product copy beside it.
- Added product-family gallery groups and curated image pools in `inc\site-data.php` so pages fill the mosaic from verified scrape-derived assets rather than old scraped page galleries.
- Kept exact product images first, then filled the remaining grid with closely related images from the same product family.
- Styled the gallery as a 4-column desktop grid with a right-side copy panel, collapsing to a 2-column mobile image grid with the copy first.
- Rebuilt compiled CSS/JS with `npm.cmd run build`.
- Verified 25 rendered product/service pages have 16 curated gallery images, zero `/wp-content/fenster-reference/` images in the new gallery, and no New Wave wording on `/slide-fold-doors/`.
- Browser-checked desktop bifold gallery and mobile slide-and-fold gallery for column count, curated paths and horizontal overflow.

## 2026-07-01 - Product Image Curation Pass

- Added curated product media overrides in `inc\site-data.php` so product pages use verified theme assets instead of the old scraped Fenster gallery order.
- Copied 31 checked product images from Liniar, Sheerline, Distinction Doors, Notan, neutral slide-and-fold assets and visibly accurate Fenster-export service images into `assets\images\products\curated`.
- Updated `template-parts\sections\generated-page.php` so curated hero/gallery media replaces scraped hero-adjacent, `Why choose this product?` and feature-card images when available.
- Kept slide-and-fold imagery and alt text neutral, with no New Wave wording on the rendered page.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Spot-checked 25 rendered product/service pages: curated image URLs were present, old `/wp-content/fenster-reference/` image URLs were absent, and `/slide-fold-doors/` contained no New Wave text.

## 2026-07-01 - Product Copy Override Pass

- Added curated `product_content` intros, five benefit cards and five FAQs for all mapped residential product/service routes so product pages no longer depend on scraped section fragments for the `Why choose this product?` and FAQ areas.
- Rewrote previously broken product content including Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs, using existing Fenster product data plus manufacturer scrape facts from Liniar, Sheerline, New Wave, Distinction Doors and Notan.
- Kept specification claims aligned with existing `product_usps` data and avoided invented U-values, especially where Composite Doors and Integral Blinds do not have supplied U-values.
- Tightened generated-page filtering to reject obvious scraped designer/tool debris, one-word fragments, leading punctuation fragments and unfinished body copy before it can be used as generated fallback content.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Verified every mapped product route has a curated intro, five benefits and five FAQs, and spot-checked rendered local pages for Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs.

## 2026-07-01 - Colour Hub Carousel, Swatches And Form Scale

- Reworked the colour options hub so uPVC and aluminium colours are presented as sections on the same customer-facing hub rather than via confusing top tab/menu buttons.
- Replaced the uPVC colour carousel imagery with optimised swatch WebP assets from `images\colours_page_image`, stored under `assets\images\products\colours\liniar-swatches`.
- Kept the door-render colour assets under `assets\images\products\colours\liniar-door` for later door-page use rather than using them on the colour hub.
- Trimmed the uPVC visible colour list to the approved customer-facing set.
- Added `Smooth White` as a separate uPVC colour using the white swatch image and `No foil` detail.
- Renamed `7016 Grey` to `Anthracite Grey`, `7155 Grey` to `Silver Grey`, and `Gale Grey Finesse` to `Gale Grey Finesse (Anthracite Smooth)`.
- Implemented the colour swatch carousel as a coverflow-style browser with buttons, keyboard support and draggable scrub behaviour.
- Updated drag behaviour so dragging controls the coverflow animation state directly, can move across multiple colours, and snaps to the nearest colour on release.
- Tuned carousel drag sensitivity down after review so mobile browsing is less twitchy.
- Reworked the colour hub hero visual away from awkward overlapping cards into a simpler swatch sample board and fixed swatch image cropping by using complete contained images.
- Reduced shared enquiry/form section heading sizing so form intro headings no longer render at hero scale.
- Rebuilt compiled CSS/JS and browser-checked colour hub carousel, hero image behaviour and enquiry heading sizing.

## 2026-06-30 - Product Specification Hub And Colour Pages

- Removed the product-page mini-gallery that was rendering imported `images` data above the colour choices.
- Traced the unwanted stock imagery to old copied export entries in `data\pages.json`, including `stock-04.jpg` and `stock-05.jpg`, then tightened generated-image validation so obvious stock/placeholder filenames are rejected.
- Replaced the huge inline product colour block with compact `Specification choices` cards linking to colour options, obscure glass and relevant hardware decisions.
- Added the circular interactive choice dial to the product-page `Specification choices` section, not the colour hub pages.
- Added hardcoded virtual colour routes:
  - `/colour-options/`
  - `/upvc-colours/`
  - `/aluminium-colours/`
- Added shared `colour_options` data in `inc\site-data.php` for uPVC and aluminium frame colours.
- Kept the colour pages as straightforward reference hubs without the spinning/orbit interaction.
- Cropped the supplied nine-handle image sheet into separate transparent PNG assets under `assets\images\products\door-handles`.
- Replaced the door-handle placeholder with a real door handle selector section using `door_handles` data in `inc\site-data.php`.
- Removed the separate gradient background from the product-page instant quote section so it sits on the continuous site background from `STYLE.md`.
- Updated `AI.md` and `HANDOVER.md` with the new product-template and colour-hub model.

## 2026-06-29 - Areas Page Customer-Facing Pass

- Removed the temporary `Areas` shortcut from the site header.
- Reworked `/areas-we-cover/` from a noindex developer review grid into a customer-facing local coverage page.
- Made the coverage page indexable and added it to the generated sitemap virtual route list.
- Added a small About-page CTA linking to `/areas-we-cover/`.
- Kept the generated town/service links grouped by location, but changed the page copy and presentation for customers rather than internal QA.

## 2026-06-29 - Contact Page Reworked Against Style Docs

- Rebuilt `/contact/` as a proper showroom-led contact experience, not a rearranged split hero/card stack.
- Pulled the design back into the quieter style used by the quote and team pages: light continuous canvas, moderate hero type, constrained panels and clean contact choices.
- Removed the broken experimental contact-method row layout that was forcing phone/email text into one-character columns.
- Added a dedicated showroom/map section and route rows for home projects, commercial work and instant pricing.
- Kept the page on one continuous `--fg-page-gradient` canvas, with transparent section wrappers and local contrast only on purposeful panels, map and form surfaces.
- Kept the shared enquiry form component as the only live customer form.
- Avoided the old Three.js/canvas direction entirely; the page uses real showroom imagery and standard HTML/CSS only.
- Rebuilt compiled assets, linted the contact template and verified screenshots at `1440 x 900`, `768 x 1024` and `390 x 844` with no horizontal overflow or console errors.

## 2026-06-29 - Documentation Truth Audit

- Audited the handover/rules/homepage/style docs against the current theme code.
- Clarified that Three.js is not active: there is no `three` dependency/import/enqueue, the compiled JS does not contain the old 3D controller, and remaining `fg-home-hero-3d` / `data-fg-home-3d` references are inactive legacy source/style hooks.
- Updated homepage language from the old product-story model to the current five-group product theatre.
- Added the current `/contact/` page model, shared review showcase behaviour, commercial virtual routes and product quote `Load tool` lazy-loading detail to the handover/rules docs.
- Reconfirmed `/wcad-thank-you/` stays removed and the generated matrix remains 13 towns x 21 residential products.

## 2026-06-29 - Styling Source Of Truth Added

- Added `STYLE.md` as the dedicated source of truth for site-wide visual styling, including the continuous page background rule.
- Promoted the rule that `--fg-page-gradient` should be painted once on the page canvas rather than repeated on every section or inner wrapper.
- Added guidance for section continuity, visual assets, cards, colour, typography, forms, mobile design and visual QA.
- Updated `AI.md`, `HANDOVER.md` and `HOMEPAGE.md` so future visual work is directed to read `STYLE.md` first.

## 2026-06-29 - Contact Page Visual Refresh

- Reworked the hardcoded `/contact/` page hero into a richer contact hub with the Milton Keynes showroom photo, overlay showroom details and quick proof facts.
- Expanded the action cards to cover call, email, showroom directions and instant pricing.
- Refined the map, route-choice and enquiry sections so the shared enquiry form remains the single live form while the page feels more polished and practical.
- Added responsive contact-page styling for desktop, tablet and phone layouts.
- Rebuilt compiled CSS/JS, linted the changed contact PHP template and verified `1440 x 900`, `768 x 1024` and `390 x 844` layouts with no horizontal overflow or console errors.

## 2026-06-26 - Obscure Glass Visualiser Page

- Added a hardcoded virtual `/obscure-glass/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Kept the page out of the main navigation.
- Added a CTA to the generated product template's `Gallery and choices` / finish options card linking to `/obscure-glass/`.
- Added obscure glass pattern data in `inc\site-data.php` under `obscure_glass`.
- Converted the supplied Pilkington texture PNGs into web-friendly theme WebP assets under `assets\images\products\obscure-glass`.
- Added the supplied colour Legend photo as `assets\team\legend-colour.webp` for the visualiser.
- Added the supplied house background as `assets\images\products\obscure-glass\birkacre-house.webp`.
- Reworked the visualiser from a light transparent overlay into a split comparison: obscured view on the left, clear reference on the right.
- Added a `Change background` control that cycles between Legend and the house scene.
- Matched the Pilkington visualiser layering more closely: a blurred/brightened duplicate scene sits beneath a separate texture pattern layer.
- Switched the default preview to Cotswold and pointed it at the downloaded Pilkington `Cotswold-pilkington.png` texture.
- Replaced the pointer-follow movement with a draggable comparison slider so the interaction matches the split-preview model.
- Added mobile/tablet layouts with tappable horizontal glass controls and no hover dependency.
- Rebuilt compiled CSS/JS and verified the route, product CTA, no menu link, responsive no-overflow checks and no console errors.

## 2026-06-26 - Utility Route Cleanup

- Added a hardcoded virtual `/terms-conditions/` utility page in `inc\generated-pages.php`.
- Added `/terms-conditions/` to the custom generated sitemap virtual route list.
- Marked `/terms-conditions/` as a generated utility page in `template-parts\sections\generated-page.php` so it uses the simple utility layout.
- Removed the stale `/wcad-thank-you/` imported page from `data\pages.json`.
- Added `wcad-thank-you` to the sitemap exclusion list so the deleted route is not reintroduced through sitemap output.
- Verified `/terms-conditions/` returns `200`, `/wcad-thank-you/` returns `404`, and `page-sitemap.xml` contains `terms-conditions` but not `wcad-thank-you`.
- Clarified the then-current `/areas-we-cover/` developer review model. This was superseded later on 2026-06-29 by the customer-facing coverage page.

## 2026-06-26 - Shared Curated Review Showcase

- Added a shared hardcoded curated review showcase component in `template-parts/components/review-showcase.php`.
- Stored review excerpts in `inc\site-data.php` under `customer_reviews` so the content can later be swapped for a cached API/plugin feed.
- Used short linked excerpts from public Google/Trustpilot review sources.
- Restored the small homepage trust bar under the hero and moved the larger review widget lower, after systems/backing and before the homepage enquiry form.
- Replaced duplicated review/trust sections in generated product pages, location pages, quote page, about page, team page, contact page and windows hub with the shared component.
- Reworked the review design into a simple white Google-style widget with centred `EXCELLENT` summary and four review cards; mobile uses a native horizontal rail.
- Added three more review entries and changed the shared widget into a seven-review carousel with previous/next buttons and reduced-motion-aware auto-advance.

## 2026-06-26 - Online Quote WindowCAD Embed

- Replaced the `/online-quote/` screenshot preview with the live default WindowCAD iframe.
- Passed the default WindowCAD URL into `template-parts/sections/quote-tool.php`.
- Added `Expand view` and `Open in new tab` actions to the quote page embed.
- Added `data-lenis-prevent` and fullscreen styling so the embedded tool remains usable with smooth scrolling enabled.

## 2026-06-26 - Product Page WindowCAD Quote Embeds

- Added compact product-specific WindowCAD iframe embeds to generated product pages with matching `productCollection` URLs.
- Retargeted product-page instant quote links to jump to the embedded quote panel when a product collection is available.
- Positioned the quote embed after the main product journey content so scroll-following product video sections are not affected by the iframe height.
- Added expand-view and new-tab controls for the embedded quote tool.
- Mapped the supplied collections across uPVC windows, sash windows, aluminium windows, composite doors, uPVC doors, French doors, patio doors, bifolds, aluminium sliding doors, heritage doors, aluminium doors, slide and fold doors, replacement glazed units and secondary glazing.
- Rebuilt compiled CSS/JS and verified the mapped local product routes render the embed with the expected collection IDs.

## 2026-06-25 - Window Handle Product Sections

- Added a detailed window handle section to the shared generated product-page template.
- The section appears on the main window product routes:
  - Aluminium Windows
  - Aluminium Flush Windows
  - Heritage Windows
  - Casement Windows
  - Flush Casement Windows
  - Sliding Sash Windows
- Tilt & Turn Windows is intentionally excluded.
- Added the supplied S2 Signature finish images to the theme assets for White, Black, Chrome, Gold and Titanium.
- Reworked the handle section into a compact finish selector with swatches, active handle image/copy, three feature tiles and one static technical specification card.
- Removed the handle accordion model, egress conversion copy, monkey-tail copy, spindle length row and retrofit-ready card.
- Added structured handle data in `inc\site-data.php`, including finish options, locking, material, corrosion testing and cycle testing.
- Rebuilt compiled CSS/JS and verified the target routes render the section while `/tilt-turn-windows/` does not.

## 2026-06-25 - Enquiry Form Steps Removed

- Removed the decorative three-step "what happens next" list from the generated product/page enquiry section.
- Removed the stepped/wizard markup from the shared enquiry form so all fields are visible at once.
- Kept the shared form component and AJAX submission flow intact.
- This supersedes the earlier 2026-06-24 stepped-form experiment. Some inactive stepped-form CSS/JS selectors may still exist, but the shared PHP component no longer renders the stepped data attributes or controls.
- PHP lint passed for:
  - `template-parts\components\enquiry-form.php`
  - `template-parts\sections\generated-page.php`

## 2026-06-25 - Product Content Audit And Cleanup

- Audited the main product routes against the generated product template.
- Added missing four-tile `product_usps` data for:
  - Sliding Sash Windows
  - French Doors
  - Roof Lanterns
  - Roofline
  - Double Glazing Replacement
  - Secondary Glazing
  - Window and Door Repairs
  - Cat and Dog Flaps
- Added `product_content` overrides for product pages where aliases or template fallbacks were surfacing incorrect visible copy:
  - Aluminium Bifold Doors
  - Aluminium Flush Windows
  - Aluminium Sliding Doors
  - Cat and Dog Flaps
- Updated the generated product template to skip scraped designer, brochure, FAQ-intro, footer, social and area-list debris before building product FAQs.
- Verified the main product set now has 4 USP tiles and 5 FAQs per route in the generated data audit.
- Re-audited all 43 menu-visible routes from the header, footer and homepage links against rendered local HTML.
- Added SEO-head filtering so imported social/schema data no longer renders old designer-tool schema, `test.fensterglazing.com` JSON-LD, placeholder OpenGraph values or raw JSON social tags.
- Verified the rendered menu-visible route audit had no missing pages, no visible old scrape debris and no flagged SEO/head artifacts.
- Updated the custom sitemap generator to exclude generated pages whose imported robots value contains `noindex`, removing `/door-designer/` from `page-sitemap.xml`.
- Added temporary noindex `/areas-we-cover/` review page, linked from the header CTA, listing generated area routes by location for manual checking.
- Normalised 110 existing product + location routes onto the shared `location-service.php` layout with a hero enquiry form, product-specific copy, location-specific copy and no old designer-tool scrape text.
- Replaced uneven scraped location coverage with a deliberate product/location matrix: 13 towns x 21 sensible residential products, 273 generated URLs total. Removed category, commercial/county and other nonsensical location one-offs from the temporary area review and custom sitemap.

This file is for dated progress reports and completed-change summaries.

Do not use this as the primary rulebook or handover. Use:

- `AI.md` for coding rules.
- `HANDOVER.md` for current whole-site context.
- `HOMEPAGE.md` for homepage-specific context.

## 2026-06-24 — Documentation Restructure

- Split the project documentation into clearer responsibilities:
  - `AI.md` now contains coding rules, QA rules and implementation standards.
  - `HANDOVER.md` now contains current whole-site context.
  - `HOMEPAGE.md` now contains homepage-only source-of-truth information.
  - `PROGRESS.md` now contains dated progress reports.
- Removed the mixed progress/history blocks from the main rule and handover docs.
- Added explicit instructions at the top of each doc explaining what belongs there.

## 2026-06-24 — Mobile Design Contract

- Added a standing mobile design and implementation contract.
- Standardised expectations around:
  - `860px` breakpoint,
  - `390 x 844`, `768 x 1024` and `1440 x 900` QA,
  - single-column mobile layouts,
  - `44px` tap targets,
  - `16px` form text,
  - carousel control ownership,
  - no horizontal overflow,
  - no distorted media.

## 2026-06-24 — Integral Blinds Reveal Reverted To Full-Hero Overlay

- Reverted the attempted “below hero only” reveal model.
- Current accepted behaviour:
  - desktop reveal covers the full viewport including the hero,
  - page is locked at the top,
  - scroll opens the blinds in reverse,
  - overlay fades away,
  - normal page scrolling resumes from the top.
- Removed the zero-height gate and clip-path model from runtime code.

## 2026-06-24 — Integral Blinds Controls Copy

- Updated Integral Blinds product USP data.
- `Controls` now reads `Magnetic or electric`.
- Change made in `inc\site-data.php`.

## 2026-06-23 — Integral Blinds Reverse Scroll Reveal

- Added supplied `internal blinds.mp4` as a desktop-only scroll-controlled reveal on `/integral-blinds/`.
- Created optimised web asset:
  - `assets\videos\product-scroll\integral-blinds-chroma.mp4`
- Implemented real-time canvas chroma key for green screen `#75F94D`.
- Reversed the blind-closing footage so scrolling opens the blinds.
- Added Lenis-style eased target/current progress to avoid harsh frame jumps.
- Tuned scroll travel to about `1.55` viewport heights.
- Reduced working chroma canvas to `720 x 405` for smoother performance.
- Disabled the effect on mobile and reduced-motion.

## 2026-06-23 — Site-Wide Form Consolidation

- Replaced scattered form shells with one shared form component:
  - `template-parts\components\enquiry-form.php`
- All live customer-facing forms now use the shared component.
- Removed tiny/standalone hero callback form.
- Commercial forms use the same component with commercial arguments.
- Added AJAX submission and in-place success states.
- Preserved no-JavaScript fallback.
- Added branded responsive HTML office email.
- Default/verified recipient: `info@fensterglazing.com`.
- Leads are saved as private `fenster_enquiry` posts before email delivery.

## 2026-06-23 — Related Products And Service Areas Cleanup

- Removed the old generic related-link system that mixed scraped links into every page.
- Eliminated unrelated links such as promotional/legal pages appearing in product panels.
- Related links now come from page context and are route-checked.
- Self-links, nonexistent URLs, external promo/legal links and pagination/file debris are excluded.

## 2026-06-23 — Mobile Product Hero Redesign

- Reworked compact product heroes on mobile.
- Product photo remains visible instead of being covered by oversized buttons.
- Eyebrow/H1 sit over a lower gradient on the image.
- Actions sit in a compact tray below the photo.
- Mobile button height set to `44px`.
- Reset inherited `.button-row` margin that caused an unwanted gap.

## 2026-06-23 — Product Plaque USP Data

- Replaced generic residential product guide strip with real four-tile `Key specifications`.
- Centralised product USP data in `inc\site-data.php`.
- Added/exposed missing product routes including:
  - `/aluminium-flush-windows/`
  - `/aluminium-sliding-doors/`
  - `/slide-fold-doors/`
  - `/heritage-aluminium-doors/`
- Added new/exposed routes to navigation and selector hubs.
- Verified mapped product routes rendered four USP tiles.

## 2026-06-23 — Aluminium Door Video Reassignment

- Moved aluminium door turntable video ownership from Composite Doors to Aluminium Doors.
- `/composite-doors/` now uses its product image.
- `/aluminium-doors/` owns the travelling/docking video feature.
- Mobile keeps the video docked in the primary media position and scrubs it by page scroll.

## 2026-06-23 — Mobile Header And Tablet Breakpoint Fix

- Fixed mobile/tablet issue where header appeared to disappear and homepage looked blank/distorted.
- Root cause was inconsistent breakpoints:
  - navigation switched at `860px`,
  - homepage mobile replacement previously switched lower.
- Standardised the homepage mobile replacement at `860px`.
- Made small-screen header fixed and composited.
- Hid desktop sticky product theatre at mobile/tablet widths.

## 2026-06-22 — Homepage Mobile Spacing Audit

- Established mobile section spacing by visible component joins instead of blanket section padding.
- Grouped carousel cards and dots in shared wrappers.
- Attached carousel dots visually to their carousels.
- Approved mobile joins:
  - product carousel to instant quote: `24px`,
  - proof carousel to systems/backing: `16px`,
  - systems/backing to contact: `32px`,
  - contact form to areas panel: `24px`,
  - areas panel to footer: `28px`.

## 2026-06-22 — Homepage Desktop Spacing Audit

- Audited homepage desktop spacing at normal viewport scale.
- Established desktop rhythm around meaningful content boundaries.
- Preserved deliberate product-theatre-to-quote overlap.
- Corrected product theatre layout to use capped image row and centred complete composition.
- Rejected stretching media to fill tall sticky stages.

## 2026-06-19 — Broad Site Rebuild Context

- Continued custom WordPress theme rebuild based on imported/generated data.
- Established code-driven approach rather than ACF/page-builder editing.
- Expanded generated-page templates, navigation, footer, homepage and product page systems.
- Preserved SEO coverage while replacing visibly broken or generic imported layouts.

## 2026-06-24 - Homepage Gradient Continuity

- Removed the duplicate `--fg-page-gradient` paint from the homepage product-flow wrapper so the page below the hero uses one continuous anchored background.
- Added mobile-only homepage gradient variables at `860px` and below to reduce green/blue intensity and increase the white wash.
- Verified `390 x 844`, `768 x 1024` and `1440 x 900` renders had no horizontal overflow or console errors.

## 2026-06-24 - Enquiry Form Steps

- Updated the shared enquiry form component to present four progressive steps with JavaScript active: project, contact, email/location and final details/privacy.
- Kept no-JavaScript behaviour as a complete normal form using the same shared fields and handler.
- Added step controls, progress text/bar and per-step validation before continuing.

## 2026-06-29 - Contact Page Compact Pass

- Tightened `/contact/` hero, contact dock and section padding to match the quieter quote/team page rhythm.
- Removed the hidden broken contact-methods block from the contact template instead of leaving it suppressed by CSS.
- Kept one continuous page gradient across the contact page.
- Hid the repeated showroom desk panel on mobile; phone, email and quote remain in the mobile contact dock, with full showroom details in the map section.
- Rebuilt compiled CSS/JS and verified `390 x 844`, `768 x 1024` and `1440 x 900` screenshots with no horizontal overflow or console errors.
