# Fenster Glazing Progress Log

Last updated: 2026-07-09

## 2026-07-09 - Door Handle Section Scope

- Removed `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` from the shared long-plate `door_handles` route list because those systems use different handle families.
- Kept the selector active for relevant entrance/French-style door routes such as `/upvc-doors/` and `/french-doors/`.
- Pushed and deployed commit `882cf47` (`Scope door handle selector routes`) to live with a theme-only SiteGround rsync and cache flush.
- Verified locally that the affected three routes return 200 without `#fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still render the section.
- Verified live server-side that `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` return 200 without `fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still include it.

## 2026-07-09 - Product Image Pool Audit

- Audited the product image source path after uPVC door pages were showing aluminium, composite and other wrong-material images.
- Found the issue in `inc\site-data.php`: several product routes shared broad gallery pools such as `entrance_doors`, `wide_span_doors` and `aluminium_doors`, so unrelated product families bled into each other.
- Split curated gallery pools by material/product family for uPVC doors, composite doors, patio doors, French doors, aluminium doors, aluminium bifolds, slide-fold doors and aluminium sliding doors.
- Cleaned uPVC and aluminium window pools so they no longer borrow obvious wrong-material product images just to fill the gallery.
- Updated `template-parts\sections\location-service.php` so generated town/service routes reuse the same curated product media and gallery pools instead of falling back to raw imported scrape images.
- Pushed and deployed commit `97d7525` (`Fix product image gallery pools`) to live with a theme-only SiteGround rsync and cache flush.
- Verified representative main product and matrix routes locally, including `/upvc-doors/`, `/composite-doors/`, `/patio-doors/`, `/french-doors/`, `/aluminium-doors/`, `/aluminium-bifold-doors/`, `/aluminium-sliding-doors/`, `/upvc-doors-milton-keynes/`, `/french-doors-milton-keynes/`, `/patio-doors-milton-keynes/` and aluminium/composite matrix equivalents.
- Verified the live `/upvc-doors/` route server-side after deployment; it returns 200 and includes the curated uPVC/front-door image set (`fenster-upvc-door.jpg`, `Residential_Door_08.jpg`, `Residential_Door_01.jpg`, `new-front-door-in-Milton-Keynes.jpeg`, `house-front-door.jpeg`, `secure-front-door.jpeg`).

## 2026-07-09 - Microsoft Clarity Replay Rendering Fix

- Debugged broken Clarity recordings by simulating Clarity-style page/resource fetches rather than changing visible layout again.
- Found that the real browser site was styled correctly, but browser-like bot/resource requests could receive the SiteGround/nginx `403 - Forbidden` HTML page. That explained Clarity recordings showing raw/default navigation, huge graphics/images and missing CSS.
- Removed the live Clarity plugins (`microsoft-clarity` and `clarity-ad-blocker`) so Clarity is loaded only through the theme consent layer.
- Kept Clarity project ID `xi7rk1pic8` in `inc\consent.php`, gated behind accepted optional-cookie consent.
- Added `data-clarity-unmask="true"` to stylesheet links, critical CSS, font preloads and key image preloads in `inc\assets.php` so stricter Clarity masking preserves resource URLs.
- Added the accepted workaround in commit `f820b87`: after accepted consent, fetch the live `main.css`, inject it into the DOM as `style#fenster-clarity-replay-css[data-clarity-unmask="true"]`, and only then load Clarity. This gives new recordings a self-contained copy of the theme stylesheet even if Clarity's backend/player cannot fetch external CSS later.
- Verified live that the inline replay CSS is present before `clarity.ms/tag` and before `q.clarity.ms/collect`; owner confirmed new Clarity recording renders correctly.

## 2026-07-07 - Commercial Product Template Local Rebuild

- Put the wider live audit on hold to address poor commercial product pages first, especially `/curtain-walling/`.
- Added a dedicated commercial product data layer and template for `/commercial-windows-and-doors/`, `/curtain-walling/`, `/louvre-vents/`, `/commercial-automation/` and `/healthcare-construction/` so these routes no longer depend on the generic generated product journey or rough scraped body sections.
- Curated commercial imagery from the imported theme assets for hero, gallery and related cards, including the curtain walling and real commercial project photos.
- Rebuilt compiled CSS and verified PHP syntax for the touched files.
- Local route checks confirmed all five routes return 200, render the new `fg-commercial-product` template, have no old designer/WindowCAD scrape copy, no broken images, no horizontal overflow and no console errors at desktop and mobile widths.
- Deployed commit `26f3b43` to the password-protected test site and repeated server/browser checks there. This still needs explicit approval before live.

## 2026-07-07 - Clarity Consent Session Fix

- Fixed the Clarity consent setup so accepted visitors receive Microsoft Clarity Consent API v2 signals instead of being treated as no-consent page views.
- Aligned the theme-loaded Clarity project ID with the WordPress Clarity plugin setting (`xi7rk1pic8`) while keeping third-party tracking blocked until the site cookie banner is accepted.
- Local browser verification confirmed no Clarity/GTM/Facebook tracking scripts or `_cl*` cookies before consent, then persistent `_clck` and `_clsk` cookies after acceptance across `/aluminium-doors/` to `/sliding-sash-windows/` navigation.

## 2026-07-07 - Cookie Policy Copy Cleanup

- Replaced the imported `/cookie-policy/` wording with a site-specific policy that matches the current consent banner and tracking setup.
- Deployed the corrected policy copy to test and live through commit `bc625f4`.
- Removed irrelevant claims about customer accounts, logged-in areas, newsletter subscriptions and on-site surveys.
- Clarified that optional Google Tag Manager, Microsoft Clarity and Meta Pixel only load after consent, and that visitors can still use the site after rejecting optional cookies.
- Updated `/privacy-policy/` copy to state that the website does not currently provide customer account registration or an email newsletter sign-up.

## 2026-07-07 - Site-Wide Copy Audit Cleanup To Test

- Verified the 2026-07-06 AI copy audit against current theme source before editing.
- Deployed the verified copy cleanup live through commit `4ce91a6`, after first deploying and checking the same commit on test.
- Removed customer-facing template self-talk from product galleries and specification-choice cards, including `verified product imagery`, `verified supplier imagery`, `page stays visually accurate` and finish-guide architecture wording.
- Replaced visible internal `route` wording across commercial county pages, the trust page, contact page, product hubs, pet-flap copy, handle copy and legacy generated sections with customer-facing terms such as option, approach, process, system and fitting method.
- Lower-cased mid-sentence `obscured glass` copy, while keeping route/title naming where `Obscured Glass` is the page name.
- Rewrote copied article/data fragments in `data/pages.json` that ended mid-sentence or promised non-existent live chat; contact copy now points visitors to phone or email, and the verified 24/7 phone-line footer claim remains in place.
- Verified JSON parsing, PHP lint for all touched PHP files, targeted source greps and local rendered checks on representative product, article, commercial county, commercial projects and obscured-glass routes.

## 2026-07-07 - Product Template Live Polish, Gallery Lightbox And Mobile Nav Fix

- Deployed the shared product-page redesign and follow-up polish live through commit `3ac98c2`.
- Product sections now use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems filler section from generated product pages.
- Product galleries now open in an in-page lightbox rather than a raw image URL/new tab. The accepted lightbox has no visible caption/alt text, no white image card, close/backdrop/Escape handling, previous/next arrows and keyboard left/right navigation.
- Fixed the mobile navigation touch layer so the open menu owns the viewport and page hero/content layers cannot intercept taps on mobile menu rows.
- Verification covered `npm.cmd run build`, PHP lint for changed templates, and browser checks on `/casement-windows/` for the lightbox and mobile nav behaviour.

## 2026-07-07 - Product Page Layout Redesign To Test

- Reworked the shared generated product-page journey toward a clearer 50/50 image-and-copy flow before live approval.
- Replaced the non-FAQ "Why choose this product?" accordion with visible benefit cards, and replaced the tabbed product information explorer with visible specification check cards. FAQs remain the only accordion-style content on product pages.
- Added a no-repeat image queue for product pages: the body image pool excludes the hero image, and later gallery moments draw from later unique images rather than recycling the same visual.
- Moved window handle selection out of inline product pages into a dedicated `/window-handles/` specification hub, with product pages linking to that hub from the specification choices area.
- Refined the test template copy so product intro sections use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems section from generated product pages.
- Expanded the product-hub specification check cards to fill the section width, and made product-gallery images open through the site lightbox with a hover affordance.
- This change was reviewed, refined and later deployed live through commit `3ac98c2`.

## 2026-07-06 - Reviews Copy And Privacy Policy Cleanup

- Replaced hardcoded review-count claims such as `200+ five-star reviews`, `Google 130 reviews` and `Trustpilot 226 reviews` with stable wording around hundreds of customer reviews across Google and Trustpilot.
- Rebuilt `/privacy-policy/` as a theme-owned virtual page with clean title/meta and current plain-English content covering enquiries, uploads, WindowCAD, AdminBase, cookies, analytics, retention and customer rights.

## 2026-07-06 - Test Domain Deindex Hardening

- Rechecked `test.fensterglazing.com` after it appeared in Google results despite Basic Auth.
- Confirmed the test homepage and `robots.txt` were returning `401` without an `X-Robots-Tag`, which could leave stale URL-only search results.
- Updated both the Bedrock root and `/web` test `.htaccess` files on the server so normal test URLs stay password protected but return a custom `401` response with `X-Robots-Tag: noindex, nofollow, noarchive`.
- Added public `robots.txt` files on test with `Allow: /` so crawlers are not blocked from revisiting already-known URLs and seeing the noindex/401 response.

## 2026-07-06 - WindowCAD/AdminBase Relay Restored

- Tracked the missing integration to the inactive live `wraith` theme over SSH.
- Found the old `/wp-json/fenster/v1/windowcad` REST endpoint in `wraith/app/setup.php`, which flattened WindowCAD `json.infoProperties` and posted leads to AdminBase.
- Added `wp-content/themes/fenster/inc/adminbase.php` and included it from `functions.php`.
- Restored the WindowCAD REST endpoint, private WordPress enquiry saving for WindowCAD submissions, AdminBase relay metadata, and normal enquiry relay through `fenster_enquiry_created`.
- Kept AdminBase credentials out of the repo; the new theme reads constants, environment variables or WordPress options.

## 2026-07-06 - Redirect, Duplicate Host And Consent Fixes

- Removed the live `/terms-conditions/` redirect that sent footer legal links to `/privacy-policy//`; the server now returns the Terms page directly.
- Deleted the legacy redirect row hijacking `/aluminium-bifold-doors-northampton/`; the generated Northampton bifold route now returns directly.
- Added a live server redirect from `www.fensterglazing.com` to the apex host before the Bedrock internal rewrite.
- Password-protected `test.fensterglazing.com` with Basic Auth (`fenster` / `Fenster`) so it is no longer a public crawlable duplicate.
- Added theme-owned cookie consent controls that suppress automatic GTM, Clarity and Meta Pixel output until a visitor accepts optional cookies.

## 2026-07-06 - Deploy Policy Clarification

- Updated `AI.md`, `HANDOVER.md` and `LIVECHANGES.md` with the owner's deployment preference: small, scoped, low-risk changes can go directly from local checks/GitHub to live, while bigger layout/template/routing/form/SEO changes should still use test first and then live verification.

## 2026-07-06 - Cat And Dog Flaps Page Rewrite

- Rebuilt `/cat-and-dog-flaps/` at the generated-page source after the imported scrape title and copy produced bad output such as "Need Cat and Dog Flaps?" and double-question headings.
- Added a route-specific generated-page SEO/title override so the page now uses `Cat and Dog Flaps` consistently in the H1, metadata, FAQ heading and internal labels.
- Rewrote the pet-flap product intro, benefits, FAQs, product-hub detail and USP labels around the real customer decision: suitable door panel versus new sealed glass unit, manual/lockable/microchip options, pet size, flap height and survey checks.
- Added a dedicated pet-flap fitting guide section and suppressed the generic product visual gallery/specification-choice block on this route, because frame-colour/privacy-glass catalogue copy does not fit the service.
- Added responsive SCSS for the pet-flap guide cards so the page collapses cleanly on mobile.

## 2026-07-06 - Lighthouse Performance Wave 1 And 2

- Added a performance pass in response to the mobile Lighthouse report showing 62 Performance, 4.3s FCP and 14.5s LCP on slow 4G.
- Added critical first-viewport CSS and changed the main stylesheet link to preload/activate asynchronously with a noscript fallback, reducing render-blocking pressure while keeping the hero/header styled.
- Added WOFF2 versions of the Gibson fonts and updated `@font-face` declarations to prefer WOFF2 with OTF fallback; Regular and SemiBold are preloaded as critical weights.
- Added a homepage hero-poster preload and changed the homepage hero video lazy loader so mobile, reduced-motion and constrained-connection sessions keep the 9.36 MB video out of the initial load until interaction.
- Added `fenster_image_attr_string()` and related helpers in `inc\assets.php` so local theme images can render explicit width/height attributes; applied it to the header logo, homepage product/trust/partner images, and key generated/article/location hero images.
- Added below-fold homepage `content-visibility` guardrails for the quote, partner, review, enquiry and local-link sections.
- Improved review carousel ARIA by giving decorative star/Google label spans explicit image/group roles, and increased mobile product dots/review carousel buttons to 44 px tap targets.
- Verification: `npm.cmd run build` passed; PHP lint passed for all touched PHP files; browser check on the local homepage confirmed poster/font preloads, explicit image dimensions, no desktop/mobile horizontal overflow, mobile hero video source still deferred after 2.5s, 44 px mobile dots and no console errors.
- Static cache headers still need a server/SiteGround step because `app/public/.htaccess` is ignored by the GitHub theme repo. Add long-lived `Cache-Control: public, max-age=31536000, immutable` for theme CSS, JS, fonts, images and video at host/CDN level.

## 2026-07-06 - Article CTA Form Layout Fix

- Fixed generated article/blog CTA form layout and contrast in commit `aff62a0`.
- Added the `fg-article-form` class to the shared enquiry form when rendered from `template-parts\sections\generated-article.php`.
- Added article-specific CTA/form styling so the left copy panel has deliberate contrast and the right form has readable labels, visible input borders, sane textarea height and a mobile one-column layout.
- Rebuilt compiled CSS, pushed to GitHub, deployed to live with the theme-only SiteGround workflow and flushed the WordPress cache.
- Server verification passed: `generated-article.php` had no PHP syntax errors and live CSS/template contained the new article form selectors.

## 2026-07-06 - Performance Deferral Pass

- Improved live loading behaviour in commit `7c973b5` without removing the premium video/quote experience.
- Deferred the homepage hero video until page idle so it is not a blocking first-load dependency.
- Deferred homepage/product/quote WindowCAD iframe source loading through `data-quote-iframe-src`, with near-viewport and click/interaction triggers.
- Kept quote tool placeholders/actions usable while the iframe loads.
- Reduced eager media pressure in the homepage product theatre and heavy generated product sections.
- Rebuilt CSS/JS, pushed to GitHub and deployed live.

## 2026-07-06 - Commercial Glazing Hub V2

- Reworked the main `/commercial-glazing/` page in commit `5696140` to be simpler, proof-led and more conversion-focused.
- Corrected project proof imagery to use commercial-project/theme assets rather than wrong generic images.
- Reworked commercial glazing products/services imagery from available Fenster/theme assets and kept runtime references out of `wp-content\fenster-reference`.
- Removed the tiny decorative parallax drift in the "How enquiries move" area.
- Tightened and simplified awkward page sections such as "Where this fits" so the page is less padded and more practical.
- Restyled the commercial enquiry section so the form inputs are visible and the copy does not use oversized hero text.
- Rebuilt compiled CSS, pushed to GitHub and deployed live.

## 2026-07-06 - Stale Audit Recheck And SEO Hardening

- Rechecked the outdated pre-launch audit claims against live output instead of trusting the old crawl notes.
- Verified social share metadata is already clean on live: homepage and product routes emit current theme-owned OG/Twitter title/image tags using the local showroom image.
- Verified live language output is already `lang="en-GB"` and WordPress `WPLANG` is `en_GB`.
- Fixed the confirmed colour-hub duplicate issue: `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/`.
- Added `inc/security.php` to harden public WordPress output: unauthenticated REST user enumeration returns 401, XML-RPC is disabled via WordPress filter, `X-Pingback` is removed, and WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output is stripped.
- Restored theme sitemap ownership before Rank Math can serve XML, so `/sitemap.xml` points at the theme `page-sitemap.xml`; live verification showed 421 canonical URLs, `/colour-options/` included, and redirected colour URLs excluded.
- PHP lint passed for changed files, changes were pushed to GitHub and deployed live through the theme-only SiteGround workflow.

## 2026-07-06 - Mobile Product Template Fixes

- Fixed the owner phone QA issues from the product template pass and deployed them live in commit `c21bd46`.
- Product information hubs now have calmer mobile spacing between "Why choose this product" and the hub.
- Product hub supplier/proof badges are constrained on mobile so Liniar, Energy Plus, A+ rated and PAS 24 badges sit at more balanced visual sizes.
- The product information tab rail is viewport-contained on mobile, uses native horizontal scroll-snap, hides the scrollbar, and adds a visible "Swipe to see all product checks" affordance when there are more than two checks.
- The common-choice strip stacks on mobile and no longer uses two wide columns that can push the whole page sideways.
- `/colour-options/` hides the hero sample-board visual on mobile so the page starts cleaner.
- `/sliding-sash-windows/` now has mobile-specific sizing for Roseview model cards, comparison rows and detail imagery: smaller contained images, stacked comparison cards and fixed-aspect image panels.
- Verification: `npm.cmd run build` passed, `generated-page.php` passed PHP lint, the theme was pushed to GitHub and deployed to live with cache flushed.

## 2026-07-06 - Live Phone QA Notes

- Captured owner phone QA findings for the next mobile polish pass. These findings were addressed in later product-template/mobile fixes and superseded by the live product-page redesign through `3ac98c2`.
- Product pages such as `/casement-windows/` are broadly strong at the top, but need spacing and mobile component polish around the "Why choose this product" to product hub transition.
- Product hub logo sizing needs balancing on mobile: Liniar and Energy Plus currently feel oversized compared with A+ rated and PAS 24 proof badges.
- The common-choice/product-view control area is a priority bug: it can overflow its frame and create full-page horizontal scrolling on mobile.
- Product-view controls need clearer discoverability when more than two options exist.
- `/colour-options/` should remove or simplify the hero image on mobile; the rest of the page is acceptable.
- `/sliding-sash-windows/` needs mobile-specific redesign work for the Roseview model stats, corner detail, slide-aligned comparisons and large detail imagery.
- No code changes were made in this entry; this was documentation of live phone QA findings before the later fixes.

## 2026-07-06 - SiteGround Test Deploy, SEO Ownership And Forms

- Verified the real SiteGround structure: both test and live are Bedrock installs, so the server theme path is `web/app/themes/fenster` even though local development uses `wp-content/themes/fenster`.
- Deployed the GitHub theme to `https://test.fensterglazing.com` from the server repo cache at `~/repos/FensterGlazing-NewSite`, then activated the `fenster` theme on test. The same theme has since been deployed and activated on live.
- Disabled the test-only `mousewheel-smooth-scroll` plugin because it conflicted with the theme's Lenis scrolling and caused jumpy scroll behaviour. Do not run another smooth-scroll plugin alongside the theme.
- Fixed Bedrock theme asset URLs so generated `/wp-content/themes/fenster/...` references map to the real theme URI under `/app/themes/fenster/...`; this restored imported images and theme-owned media on test.
- Added the aluminium windows story-frame folders to git so the scroll video on `/aluminium-windows/` works on test instead of only locally.
- Suppressed Yoast and Rank Math public head output on generated pages, then added theme-owned title/social meta handling so public SEO tags come from the theme rather than stale plugin/imported data.
- Tightened contact and online-quote titles, zoomed the WindowCAD iframe down for a usable first view, and verified key routes/assets returned 200 on test.
- Verified enquiry delivery on test and live: valid AJAX form submissions save as private `fenster_enquiry` posts and send an office HTML email to `info@fensterglazing.com`.
- Polished the enquiry email HTML header so the Fenster logo sits on a light header and remains visible in email clients.
- Matched the old working office-email envelope (`WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`) after live manual submissions confirmed the office-facing email was the fragile part.
- Paused customer confirmation emails unless authenticated SMTP is configured, and removed public form copy that told customers to wait for or reply to a confirmation email.
- Added optional enquiry file uploads for photos, drawings, schedules and documents; uploaded files are stored against the private enquiry and attached to the office email.
- Temporarily hid the unfinished residential case-study area for launch: `/case-studies/` and known residential child case-study routes now return 410 and are excluded from the sitemap, with public CTAs moved to `/commercial-projects/`. Commercial project records stay reachable for proof.
- Renamed the privacy-glass route to `/obscured-glass/`, added a 301 from `/obscure-glass/`, updated visible copy to "obscured glass", and adjusted the mobile visualiser so it does not trap normal vertical scrolling.
- Documented the future workflow as local code change -> GitHub -> test deploy -> verify -> fresh live backup -> live deploy, avoiding direct live editing and SiteGround clone/staging tools.

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
- Replaced the huge inline product colour block with compact `Specification choices` cards linking to colour options, Obscured glass and relevant hardware decisions.
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

## 2026-06-26 - Obscured glass Visualiser Page

- Added a hardcoded virtual `/obscured-glass/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Kept the page out of the main navigation.
- Added a CTA to the generated product template's `Gallery and choices` / finish options card linking to `/obscured-glass/`.
- Added Obscured glass pattern data in `inc\site-data.php` under `obscure_glass`.
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

