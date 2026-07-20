# Fenster Glazing — Master Site Audit

Audit date: 2026-07-03
Last updated: 2026-07-06 (GitHub upload, live theme deploy, launch SEO hardening, office forms verified, mobile product QA fixes)
Audited: full theme code (`wp-content/themes/fenster`), `data/pages.json`, rendered local/live site output, SEO surface, performance, UX, conversion path.

**How to read this:** issues are grouped by severity. "Critical" items either lose leads directly, will break at launch, or actively damage Google's view of the site. Each item says where the problem lives so it can be fixed quickly. Items resolved since the original audit are marked **✅ FIXED** with a note on what was done; full detail is in `PROGRESS.md` (2026-07-03 entry).

## Important Updates (2026-07-06)

- **Tracking/consent status superseded on 2026-07-13.** The historical L3/L6 and 2.7 findings below describe the pre-consent/pre-attribution state. The live theme now blocks optional tracking until acceptance and the separate Marketing Dashboard records consented no-PII visitors/journeys, pages/time, scroll depth, CTA/link clicks, form/quote starts, phone/email intent, WindowCAD completions and per-visitor timelines. The dashboard is hosted as the separate `0riceisnice0-hash/Marketing-Dashboard` repository on GitHub. Consent health counts accepts/rejects only in aggregate; banner impressions were removed after anonymous crawler/session traffic made them unreliable. Focus Group answered/missed call outcomes, a WindowCAD project-level ID, and downstream sale outcomes remain open integration work.

- Latest known live commit after this update is `aff62a0` (`Fix article CTA form layout`). Recent live fixes not in the original audit: `5696140` commercial hub v2, `7c973b5` heavy media/quote iframe deferral, `aff62a0` article CTA form contrast/layout.
- GitHub is live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. The repo is scoped to the custom theme and launch docs, excluding WordPress core, uploads, `wp-config.php`, local backups/config, `node_modules` and `wp-content\fenster-reference`.
- SiteGround test/live are verified Bedrock installs. Deployment should update/swap only the `fenster` theme at `web/app/themes/fenster` from the repo while leaving the production database, uploads, plugins, `.env` and config intact. The reference scrape archive must not be deployed.
- The test and live sites are running the new `fenster` theme. Future changes should still go local -> GitHub -> test -> verify -> backup -> live.
- Theme-owned SEO is now the launch source of truth on generated pages. Yoast/Rank Math head output is suppressed there to avoid duplicate titles, stale schema and broken imported social metadata; do not reset Rank Math before launch.
- Launch SEO hardening has moved the site materially closer to live-ready: homepage title/meta fixed, generated routes normalise with 301s, generated deep routes output breadcrumb schema, generated pages/sitemaps use short public cache headers, and the live theme sitemap currently exposes 421 canonical URLs.
- Navigation/indexation cleanup is complete for known launch debris: `/commercial-areas/` is out of the header/sitemap, thin utility/scrape pages are `noindex,follow`, `/areas-we-cover/` and `/terms-conditions/` are visible in the footer, and inaccessible Isle of Wight commercial coverage is 410'd.
- Mobile conversion polish is complete for the reported launch blockers: About process cards have padding, Contact CTA cards are readable with no text/action overlap, and mobile quote embeds show a single same-tab `Open quote tool` action.
- Form delivery is verified end-to-end on live: enquiries save privately in WordPress and send office HTML emails to `info@fensterglazing.com`. Customer confirmations are paused unless SMTP is configured, and the customer-facing form copy no longer promises one.
- Optional enquiry file uploads are supported for photos, drawings, schedules and documents; uploads are attached to the private enquiry and office email.
- Residential case studies were rebuilt and went live 2026-07-17: `/case-studies/` is now a curated, data-driven system (`inc/case-studies-data.php`, `CASESTUDIES.md`) with real projects, in the sitemap. Only the retired scrape-era residential child routes still return 410. Commercial project records remain on the separate `/commercial-projects/` pages.json system.
- The privacy-glass route is now `/obscured-glass/`; `/obscure-glass/` redirects there.
- Phone QA product-template fixes are now deployed: product common-choice controls are viewport-contained on mobile, the product hub tab rail has a swipe affordance, supplier/proof logos are constrained, `/colour-options/` hides the hero visual on mobile, and `/sliding-sash-windows/` has tighter mobile model/spec/detail image layouts.
- The stale pre-launch re-audit findings were rechecked live on 2026-07-06. Social share metadata and `lang="en-GB"` were already clean. Confirmed remaining theme-level issues have been fixed: `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/`, the public REST users endpoint returns 401, WordPress generator/RSD/oEmbed/wp-json head links are removed, and the theme sitemap is served before Rank Math with redirected colour URLs excluded.
- Performance has had a safe launch pass: the loader is gone, homepage hero video is deferred until idle, WindowCAD iframes defer until near viewport/interaction, and heavier media is less eager. The main remaining performance work is responsive/right-sized media, WOFF2 fonts, image dimensions/srcsets and further asset optimisation.
- Commercial hub v2 is live and should be treated as the current baseline for `/commercial-glazing/`: corrected project proof imagery, better product/service imagery, no decorative micro-parallax, clearer sections and a readable commercial enquiry form.
- Article/blog generated pages now have a readable CTA form layout through `fg-article-form`, resolving the white-on-white form issue in generated article CTA cards.

## Post-Launch Live Audit (2026-07-06)

Full crawl of all 421 live sitemap URLs on `https://fensterglazing.com` (421/421 fetched, redirect-aware HEAD sweep included), plus host, header, analytics and new-code review. Overall: the live SEO surface is in excellent shape — zero duplicate titles (bar the hijack below), unique descriptions, one H1 everywhere, LocalBusiness + breadcrumb schema on every page, FAQPage on 36 product pages, **100% og:image coverage**, no missing alt text, and only one broken internal link.

### Live findings — high priority

- **L1 — Legacy database redirects hijack two live sitemap URLs.** Old-site redirect rules still in the live database (Rank Math/redirect plugin) send `/terms-conditions/` → `/privacy-policy//` (malformed double slash) and `/aluminium-bifold-doors-northampton/` → `/aluminium-bifold-doors/`. The footer's Terms & Conditions link therefore lands on the privacy policy sitewide, and one matrix town page is unreachable. Fix: delete these two rules in the live redirects manager (wp-admin), then re-verify; also scan the redirect list for other rules that collide with new theme routes.
- **L2 — The live enquiry form has no spam protection.** The honeypot server check (`d40ae84`) and the speed gate (`38b95a7`) were both disabled, leaving only the nonce — which any bot obtains by loading the page. With file uploads now enabled, spam can also attach files (disk + mailbox abuse). Fix: reinstate an autofill-safe honeypot (renamed field, `autocomplete="off"`, flag-don't-discard so real leads are never lost), and/or add Cloudflare Turnstile; consider per-IP rate limiting on the AJAX endpoint.
- **L3 — GTM + Microsoft Clarity run with no consent banner.** Clarity sets cookies; under UK PECR that needs prior consent. Fix: add a consent banner wired to GTM Consent Mode before the tags fire.
- **L4 — `test.fensterglazing.com` is a public, indexable duplicate of the entire site.** It returns 200, has no noindex, and its robots.txt allows crawling. Google can index it and dilute the live site. Fix: HTTP-auth the test vhost, or send `X-Robots-Tag: noindex` on the test host and enable "discourage search engines" there — ideally both.
- **L5 — `www.fensterglazing.com` serves the full site as 200** instead of 301ing to the apex. Canonical tags point to non-www (mitigates), but the host-level 301 should be added in SiteGround.
- **L6 — No lead-event tracking despite GTM being live** (`GTM-K89BCS9`). The theme JS pushes nothing to the dataLayer on form success, so enquiries aren't measurable as conversions. Fix: `dataLayer.push({event: 'enquiry_submitted', enquiry_source: ...})` in the AJAX success handler + a GTM trigger/GA4 event; add phone-click and WindowCAD-open events at the same time.

### Live findings — medium priority

- **L7 — Resolved locally on 2026-07-13:** `/commercial-projects/` no longer renders cards for any case-study route intentionally marked 410, removing the broken Woburn link without reviving a retired case study.
- **L8 — robots.txt is not the theme's output**: a physical/plugin file with `Crawl-delay: 10` (throttles Bing) and the `sitemap_index.xml` pointer (which does resolve to the theme index). Remove the crawl-delay and align ownership.
- **L9 — og:image is the 2.3 MB showroom PNG.** It works, but social crawlers prefer <300 KB at 1200×630. Create a dedicated compressed social card.
- **L10 — SiteGround dynamic cache is off** (`X-Cache-Enabled: False`). The theme's Cache-Control headers help, but enabling SG's dynamic cache would cut TTFB across all 421 pages. No HSTS header either.
- **L11 — 362 meta descriptions still exceed ~175 chars** (matrix/county templates; carried over from R6).
- **L12 — Quote-intent split remains:** `/online-quote/`, `/3d-visualiser/` and `/design-your-windows-and-doors/` are all indexable near-duplicates of the same tool (carried from earlier audits).

### Verified healthy on live

HTTPS with valid cert and http→https 301; theme sitemap served at both `/sitemap.xml` and `/sitemap_index.xml` (421 URLs, all 200 apart from L1); REST users endpoint 401; XML-RPC disabled; generator/RSD/oEmbed/emoji output stripped; `lang="en-GB"`; theme-owned social metadata with working Bedrock-path og:images; hero video deferred via `data-src`; case-study 410s working; colour-hub 301s working; matrix pages rendering unique titles/descriptions/canonicals; upload handling uses `wp_handle_upload` with a MIME whitelist and 5×8 MB caps; customer emails correctly gated behind SMTP config.

## Remediation Status (2026-07-03)

| # | Blocker | Status |
|---|---|---|
| 2.1 | JSON-LD schema never renders | ✅ Fixed — generated LocalBusiness site-wide + FAQPage on product pages; junk imported schema intentionally dropped |
| 2.2 | 2.4 GB `fenster-reference` runtime dependency | ✅ Fixed — 356 used images migrated to `assets/images/imported/` (~245 MB), all references rewritten, poster re-encoded 2.9 MB → 175 KB |
| 2.3 | robots.txt / sitemap plumbing | ✅ Fixed — core sitemaps disabled, robots.txt advertises `/sitemap.xml` |
| 2.4 | Test/debris pages indexable | ✅ Fixed — 410s, 301s and noindex applied; current live theme sitemap exposes 421 canonical URLs |
| 2.5 | Blog articles render as broken product pages | ✅ Fixed — explicit route whitelists + new `generated-article.php` template |
| 2.6 | Duplicate competing town pages | ✅ Fixed — 301s to the canonical matrix slugs |
| 2.7 | No analytics / conversion tracking | 🟡 Partially fixed — GTM (`GTM-K89BCS9`) and Microsoft Clarity are live, but no lead events fire from the theme (L6) and there is no consent banner (L3) |
| 2.8 | No git history | ✅ Fixed — initial scoped GitHub push completed; theme/docs are versioned without WordPress core, uploads, reference archives or local config |
| 2.9 | Form delivery unproven on host | ✅ Fixed — test submission saved enquiry ID `8781` and sent office/customer emails via SiteGround |

### Post-Audit Product-Page Progress

- `/sliding-sash-windows/` has been upgraded from a generic product journey into a Roseview-specific sash page: Ultimate Rose, Heritage Rose and Charisma Rose comparison, meeting-rail and joint detail sections, and Roseview sash furniture.
- The inherited Liniar product-hub badge was removed from the sash route and replaced with a local Roseview logo from `assets/partners/roseview-logo-new.png`.
- Roseview furniture assets were copied locally into `assets/images/products/sash-roseview`; runtime code should not depend on the Roseview scrape export.
- The generic window-handle section no longer renders on the sash page; sash furniture now covers Globe, Acorn, Shark Fin Limit Stop, D Handle and the under/over 700mm furniture-count rule.

### Post-Audit Launch-Readiness Progress

- The forced first-visit splash/loading screen has been removed from live header markup, source JS and source SCSS; compiled CSS/JS were rebuilt and live files no longer contain loader hooks.
- Commercial county coverage has been pruned for credibility: `/commercial-glazing-isle-of-wight/` was removed from the generated county set, added to the central 410 Gone list, and confirmed absent from the sitemap.
- Commercial county title tags and meta descriptions now use each county profile's town examples and project context rather than one near-duplicate metadata sentence.
- Residential location matrix metadata has been de-duplicated: all 273 town x product pages now generate unique meta descriptions from town and product profiles; a local crawl confirmed 273 unique descriptions, zero duplicate groups and zero fetch errors.
- The launch SEO hardening pass removed the public `/commercial-areas/` header shortcut, added footer links to `/areas-we-cover/` and `/terms-conditions/`, replaced the inherited homepage title/meta, added breadcrumb schema on generated deep pages, normalised generated URL casing/trailing slashes with 301s, set public cache headers for generated pages/sitemaps, and removed thin utility pages from the sitemap via `noindex,follow`. Live verification after the stale-audit recheck shows 421 canonical sitemap URLs.
- Mobile launch polish fixed the About process-card padding, Contact page CTA readability/overlap, and mobile quote-tool action model. Mobile quote embeds now use one same-tab `Open quote tool` action instead of showing desktop expand/new-tab controls.
- Mobile product-template polish fixed the reported `/casement-windows/` product hub overflow, balanced product-hub badge sizing, added clearer multi-option discovery, hid the weak colour-hub hero visual on mobile, and tightened Roseview sash comparison/detail layouts for phones.
- SiteGround test deployment proved the launch path: the server repo cache pulls from GitHub, then the theme folder is copied into the Bedrock `web/app/themes/fenster` directory. Bedrock asset URL handling, aluminium story frames, WindowCAD iframe scale, and form email delivery have all been verified on test.

## Pre-Launch Re-Audit (2026-07-06)

Original snapshot: a full re-crawl of every sitemap URL (427/427 fetched) plus a hardening verification pass, run before go-live. This section has since been updated with live 2026-07-06 rechecks; the current live theme sitemap contains 421 canonical URLs after redirected duplicate colour URLs were removed.

### Verified clean

- **Zero duplicate title tags** across all 427 indexable pages; zero missing titles, zero over-length titles.
- **Zero duplicate meta descriptions** in the matrix/county sets (one 3-page group remains — see finding R2).
- **Exactly one H1 on every page**, no missing H1s.
- **Canonical tags present and self-consistent on all 427 pages** (path matches URL, production host, trailing slash).
- **Structured data on every page and all of it valid JSON**: LocalBusiness + BreadcrumbList on 426 pages, plus FAQPage on the 35 product pages; homepage correctly carries LocalBusiness only.
- **No noindex pages inside the sitemap**; ad landers, thin utility shells and archives all carry `noindex,follow` and are excluded.
- **No broken internal content links** found across the full crawl (only WP head plumbing endpoints flagged — see R3).
- **No images missing alt text** flagged anywhere in the crawl.
- All 2026-07-06 hardening claims verified live: homepage title/meta override, trailing-slash and case-insensitive 301s, cache headers on pages (`max-age=600, s-maxage=3600`) and sitemaps, splash loader fully gone, `/commercial-areas/` noindexed and out of the header, Isle of Wight 410, all earlier 301/410/noindex rules still holding, 404s return 404.

### New findings — high priority (fix before launch)

- **R1 — Social share metadata is stale/broken sitewide — ✅ Already fixed when rechecked 2026-07-06.** The old audit finding was not current on live. Homepage and product routes now emit theme-owned OG/Twitter title and image tags, with `og:image`/`twitter:image` pointing at the local theme showroom image rather than old `/app/uploads/` URLs.
- **R2 — Colour hub triplication — ✅ Fixed 2026-07-06.** Live verification confirmed this was still true before the fix. `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/`, and `page-sitemap.xml` includes only the canonical `/colour-options/` URL.
- **R3 — WordPress attack/leak surface — ✅ Fixed 2026-07-06.** Live verification confirmed public user enumeration and WordPress head leaks were still real. The theme now blocks unauthenticated `/wp-json/wp/v2/users` and user REST search with 401, disables XML-RPC via `xmlrpc_enabled`, removes `X-Pingback`, and removes WordPress generator, RSD, shortlink, REST discovery, oEmbed discovery and emoji head output. The remaining visible `generator` tag is from Google Site Kit, not WordPress core.
- **R4 — `<html lang="en-US">` on a UK business — ✅ Already fixed when rechecked 2026-07-06.** Live output now emits `lang="en-GB"` and `WPLANG` is `en_GB`.
- **R5 — Host-level launch config (cannot be done locally).** HTTPS certificate, one canonical host with 301s (http→https, www→non-www), SMTP + SPF/DKIM/DMARC for enquiry deliverability, GA4/consent (still open from 2.7), Search Console + GBP verification at go-live.
- **R6 — Mobile product-template overflow and discoverability — ✅ Fixed 2026-07-06.** The mobile product hub now constrains the tab rail and common-choice strip to the viewport, stacks common choices, balances product-hub badge sizes and adds a "Swipe to see all product checks" affordance when more than two product checks exist. Regression check: confirm no horizontal body scroll at 390px on `/casement-windows/` and sibling product routes.
- **R7 — Mobile colour hub hero image — ✅ Fixed 2026-07-06.** `/colour-options/` now hides the hero sample-board visual on mobile, letting the page start with cleaner copy and controls.
- **R8 — Mobile sash page layout — ✅ Fixed 2026-07-06.** `/sliding-sash-windows/` now has phone-specific Roseview model/spec/detail styling: contained model images, stacked comparison rows, card-like spec rows and fixed-aspect detail image panels. Regression check on a real phone remains worthwhile because this section is image-heavy.

### New findings — medium priority

- **R9 — 338 meta descriptions exceed ~175 characters** (matrix pages run 235–280 chars; several counties and articles too). Unique and well-written, but Google truncates around 155–165 chars, so the templates' calls-to-action get cut off. Trim the matrix/county description templates to ~150–160 chars.
- **R10 — Head bloat/cleanup — partly fixed 2026-07-06**: wp-emoji scripts/styles, `rel="shortlink"`, REST discovery, RSD and oEmbed discovery are removed by the theme hardening layer. Feed links and plugin-owned tags such as Google Site Kit remain.
- **R11 — Homepage weight ~11.7 MB** (9.4 MB hero video + ~2.3 MB other assets). Acceptable for launch given `preload="metadata"`, but a ~720p mobile rendition and responsive images remain the biggest post-launch performance win (see Section 4).
- **R11 update 2026-07-06:** partly improved. The hero video now defers until idle and quote iframes defer until near viewport/interaction, so first-load pressure is lower without losing the premium media. Still open: 720p/mobile video rendition, responsive images, image dimensions, WOFF2 fonts and asset optimisation.
- **R12 — Thin-ish indexable pages**: the case-study pages run 390–600 words. Real content, fine to launch, but enriching them (more photos, scope details, town names) strengthens the local-proof cluster.

---

## 1. Executive Summary

The site is in genuinely good shape in many areas: the theme is clean, hand-built, escape-hardened PHP with no plugin bloat; the enquiry system is robust (AJAX + no-JS fallback, honeypot, saved-before-email leads); the interactive features (product theatre, obscure glass visualiser, colour coverflow, sash comparison) are well-engineered with reduced-motion and mobile fallbacks; and the documentation discipline (AI.md/HANDOVER.md/etc.) is far above average.

But the audit found **five launch-blocking problems** and a long tail of SEO/content issues that would materially cap lead generation:

1. **Structured data is completely broken** — a filter bug means zero JSON-LD renders anywhere on the site. No LocalBusiness, no FAQ, no Review schema. For a local lead-gen business this is leaving rich results and map-pack signals on the table.
2. **The live site depends on a 2.4 GB scrape folder** (`wp-content/fenster-reference/`) for the homepage hero poster, homepage product images, hub heroes, commercial imagery and roof-lantern media. Deploy without it and the homepage breaks; deploy with it and 2.4 GB of raw scrape ships to production.
3. **robots.txt points Google at the wrong sitemap.** The custom sitemap (486 URLs) exists but nothing advertises it; robots.txt advertises the default `wp-sitemap.xml`, which is missing every generated page and exposes an author/user sitemap.
4. **~40 blog/guide articles render as broken product pages** — headings like "Why choose Are My Windows Energy-Efficient??", product CTAs and fake FAQs stapled onto informational articles. Their article content is effectively destroyed.
5. **There is no analytics or conversion tracking at all.** You cannot maximise leads you cannot measure.

Also notable: **the git repository has no commits** — the entire build is untracked working files. One bad disk or accidental delete loses everything.

---

## 2. Critical Issues (fix before launch)

### 2.1 JSON-LD schema never renders (site-wide SEO bug) — ✅ FIXED 2026-07-03

> **Resolution:** imported schema is now intentionally never rendered (sampling showed it was old designer-tool VideoObject markup and an unsubstantiated 4.8/81 aggregateRating with `test.fensterglazing.com` URLs — a manual-action risk). Instead, `fenster_render_site_schema()` outputs a generated `HomeAndConstructionBusiness` LocalBusiness block (real NAP, hours, areaServed) on every page, and product journey pages output `FAQPage` JSON-LD built from the FAQs shown on the page. Verified rendering site-wide.
`inc/generated-pages.php` — `fenster_render_generated_seo()`.
The `$is_bad_seo_content` closure (line ~709) rejects any string starting with `{` or `[` (meant to catch JSON blobs leaking into meta tags). But the same closure is applied to the `schema_json_ld` entries at line ~792 — and **valid JSON-LD always starts with `{`**, so every schema is skipped. The `json_decode`/re-encode code below it is dead. Verified live: `grep ld+json` returns 0 on every page.

Impact: no LocalBusiness, Organization, Product, FAQPage, BreadcrumbList or Review markup anywhere. For local "double glazing milton keynes"-type queries this is a significant rankings/rich-result handicap.

Fix direction: use a separate, schema-appropriate validity check for JSON-LD (parse it; reject only if it fails to parse or contains `test.fensterglazing.com` etc.). Then go further — the imported schema is old scrape anyway; the bigger win is generating fresh schema from theme data:
- `LocalBusiness` (name, address, phone, hours, geo, review aggregate) on every page.
- `FAQPage` on product pages (the FAQs already exist in `product_content`).
- `Product`/`Service` with `areaServed` on product and location pages.
- `BreadcrumbList` site-wide.

### 2.2 The 2.4 GB `fenster-reference` scrape folder is a hard runtime dependency — ✅ FIXED 2026-07-03

> **Resolution:** the 356 images actually referenced by templates and `pages.json` (~245 MB of the 2.4 GB) were copied to `assets/images/imported/`; all 2,577 `pages.json` references and eight PHP files were rewritten; the 2.9 MB PNG hero poster was re-encoded to a 175 KB JPEG; the dead bifold scroll-video branch that referenced reference-folder media was removed. Nothing at runtime touches `fenster-reference` any more — it must not be deployed.
`template-parts/sections/generated-page.php` line ~424 sets
`$asset_base = '/wp-content/fenster-reference/fenster_full_site_export_20260605_125010/assets/images/'`
and it feeds: the homepage hero poster (`1-3.png`, **2.9 MB PNG**), all five homepage product-theatre images, the windows/doors hub heroes, commercial hub and project images, the roof-lanterns hero + gallery (in `inc/site-data.php` `product_media`), the home category tiles, case cards in `home-experience.php`, and two videos (`Bifold-Video.mp4`, WindowCAD rebrand video).

Impact:
- If the folder isn't deployed, the homepage and several key pages lose all imagery.
- If it is deployed, 2.4 GB of raw scrape (including old-site exports, generated JSON maps, Yoast backups and assets you may not have licences to republish) sits publicly accessible and crawlable on production.
- The filenames/paths leak implementation history (`fenster_full_site_export_20260605_125010`).

Fix direction: copy the ~20 images the site actually uses into `assets/images/` (optimised, renamed, WebP), update the references, and keep `fenster-reference` out of production entirely. The docs already did this for product galleries — the homepage, hubs, commercial pages and roof lanterns were missed.

### 2.3 robots.txt / sitemap plumbing is wrong — ✅ FIXED 2026-07-03

> **Resolution:** core sitemaps disabled via `wp_sitemaps_enabled`; the robots filter now strips stale Sitemap lines and appends `home_url('/sitemap.xml')`; the sitemap index loc uses `home_url()` so staging and production are both correct. Verified: robots.txt advertises the theme sitemap, `wp-sitemap.xml` returns 404.
- `fenster_generated_robots_txt()` only appends the custom sitemap line "if no Sitemap: line exists" — but WordPress core already adds `Sitemap: .../wp-sitemap.xml`, so the custom line **never** gets added. Verified: local robots.txt advertises only `wp-sitemap.xml`.
- `wp-sitemap.xml` (still enabled) contains none of the 486 generated URLs, and includes a **users sitemap** (author enumeration — mild security/privacy leak) plus posts/pages/taxonomy stubs that don't match the real site.
- The custom sitemap hardcodes `https://fensterglazing.com/...` URLs (correct for production, wrong on any staging domain).
- Sitemap `lastmod` for the index uses "now" on every request — meaningless signal.

Fix direction: disable core sitemaps (`wp_sitemaps_enabled` filter), make the robots filter replace/append correctly, and submit `sitemap.xml` in Search Console at launch.

### 2.4 Test pages, PPC leftovers and scrape debris are live and indexable — ✅ FIXED 2026-07-03

> **Resolution:** central debris handling added to `inc/generated-pages.php` — test pages (`nick-test-baboon`, `our-new-website`, `case-studies/test`, `case-studies/template-new`) return **410 Gone**; duplicate/renamed slugs, `enquire-now`, `instant-pricing` and all `*-designer` pages **301** to their real targets; the four ad landers stay live for campaigns but carry **noindex,follow**, as do all `category/`, `tag/`, `author/` and `blog/page/` shells. The sitemap skips every gone/redirected/noindex route and known thin utility shells such as gallery, downloads, videos, customer portal, brochures and refer-a-friend (486 → 427 URLs).
All of these return HTTP 200, have **self-referencing canonical tags**, no `noindex`, and render publicly:

- `/nick-test-baboon/` (title: "Construction: Linkedin") — a test post.
- `/our-new-website/`, `/case-studies/test/`, `/case-studies/template-new/`
- Old ad landers: `/ppc-landing-page-composite-doors/`, `/pricing-gads/`, `/instant-pricing-meta-ads/`, `/roof-lanterns-landing-page/`, `/enquire-now/`, `/instant-pricing/`
- Slug debris: `/commercial-glazing-london-2/` (the `-2` duplicate), `/healthcare_safeguarding_in_construction/` (underscores)
- Thin archive shells rendered as generated pages: `/category/*`, `/tag/*`, `/author/adam/`, `/author/chris/page/2`, `/blog/page/2` etc.
- Scrape-shell utility pages with near-empty or nonsense bodies: `/gallery/`, `/downloads/`, `/videos/`, `/customer-portal/` (promises an order-tracking portal that doesn't exist), `/refer-a-friend/`, `/brochures/`, `/apecs-terms-conditions/`, `/fenster-partners/`.

Being excluded from the sitemap does **not** stop Google indexing them — most were indexed on the old site and every one is telling Google "index me" via canonical. This is a large volume of thin/duplicate/test content dragging down sitewide quality signals.

Fix direction: triage `data/pages.json` into keep / 301-redirect / 410-gone. Test pages and `-2`/underscore debris → 410 or 301 to the real page. Ad landers → `noindex` (if the campaigns still point there) or 301. Category/tag/author/pagination → 301 to `/blog/` or the closest hub, or `noindex,follow`. Thin utility shells → rebuild with real content or 301 to relevant pages.

### 2.5 Blog/guide articles render as broken product pages — ✅ FIXED 2026-07-03

> **Resolution:** the slug-substring heuristic was replaced with explicit `$product_route_slugs` / `$commercial_route_slugs` whitelists, and a new `template-parts/sections/generated-article.php` template renders guides as readable articles (moderate hero, full article body with the real scraped headings restored, inline images, compact enquiry CTA, related links). Verified across the affected articles; product/location/commercial/hub/utility pages confirmed unchanged. Remaining nicety: a quick visual QA of the article layout at 390/768/1440.
`generated-page.php` line ~172: `$is_product` is a slug-keyword heuristic (`str_contains($slug, 'window') || 'door' || 'glazing'...`). Every article whose slug mentions windows/doors/glazing gets the **full product journey template**. Verified live:

- `/are-my-windows-energy-efficient/` → H2: "Why choose Are My Windows Energy-Efficient??" (double question mark)
- `/soundproof-windows/` → "Why choose How to Soundproof Your Windows: The Ultimate DIY Guide?"
- `/what-is-a-door-lintel/`, `/how-to-clean-your-upvc-windows-at-home/`, `/window-maintenance/`, `/door-maintenance/` and ~35 more — same pattern.

The article body is chopped into "benefit" cards and fake FAQs, product CTAs ("Instant pricing", "Start a product enquiry") are attached to how-to guides, and the actual long-form article content largely disappears. These pages carry the site's informational keyword footprint — as rendered they will lose those rankings and look broken to any visitor arriving from search.

Fix direction: maintain an explicit product-route whitelist (they're already enumerated in `$window_routes`/`$door_routes`/`$other_service_routes`) instead of the substring heuristic, and route everything else with sections through an article layout (`generated-simple` extended with proper article typography, author/date if available, and a soft CTA).

### 2.6 Duplicate competing town pages — ✅ FIXED 2026-07-03
Both slugs were live, each canonicalising to itself:
- `/dunstable-casement-windows/` **and** `/casement-windows-dunstable/`
- `/bow-and-bay-windows-northampton/` **and** `/bow-bay-windows-northampton/`
- `/tilt-and-turn-windows-northampton/` (imported) vs the matrix `tilt-turn-windows-*` naming

> **Resolution:** the imported variants now 301 to the matrix slugs (verified, targets return 200) and are excluded from the sitemap.

### 2.7 No analytics, no conversion tracking, no consent tooling
Verified: zero references to GA4/GTM/Meta/Clarity anywhere. There is also no thank-you URL (success is shown in-place via AJAX), so even after adding GA there is no conversion endpoint — you'd need to fire an event from the form success handler in `src/js/main.js` (there's a natural hook: the `fetch` success block, or the existing `fenster_enquiry_created` action server-side).

For "max leads" this is the single biggest operational gap: no call tracking, no form-source attribution reporting (source **is** captured per-enquiry in the CPT — good), no idea which of the 486 pages produce enquiries.

Fix direction: GA4 via GTM + a `generate_lead` event on form success + WindowCAD outbound-click events + a consent banner (required under PECR/UK GDPR once tracking cookies exist — the cookie policy page already exists but there is no consent mechanism).

### 2.8 No version control history
`git status` shows the entire project untracked — **zero commits**. Combined with an empty `wp-content/uploads` and everything hardcoded in the theme, the theme *is* the site. An accidental delete, disk failure or bad AI pass has no undo. Commit now, push to a private remote, and commit at every milestone.

> **Update 2026-07-06:** fixed. The project was committed and pushed to `0riceisnice0-hash/FensterGlazing-NewSite`, scoped to the custom theme and launch docs while excluding WordPress core, uploads, `wp-config.php`, `node_modules`, backups, logs, Local config and reference archives.

---

## 3. High-Priority SEO Issues

### 3.1 Forced 1.85-second splash loader
`header.php` + `main.js`: every first pageview per browser session sits behind a branded loader for a minimum of 1850 ms (`minimumLoaderMs = 1850`), even if the page is ready sooner. Every new visitor — i.e. every potential lead clicking a Google result or ad — waits ~2 s before seeing anything. This also inflates LCP (Core Web Vitals is a ranking input) because the real content paints late. Recommendation: remove it, or cap it at ~300–400 ms as a fade only, or show it only while fonts/hero actually load.

> **Update 2026-07-03:** fixed. The loader markup/session script was removed from `header.php`; the loader controller was removed from `src/js/main.js`; the loader SCSS was removed from `src/scss/main.scss`; compiled assets were rebuilt and checked for remaining live loader hooks.

### 3.2 Every page sends no-cache headers
`fenster_maybe_render_generated_page()` calls `nocache_headers()` on every generated route (which is nearly every page). Combined with:
- the 4.6 MB `data/pages.json` being `json_decode`d **on every request** (static cache is per-request only),
- form nonces embedded in every page (which is presumably why caching was disabled),

…the site cannot use page caching or a CDN effectively, and TTFB on shared hosting will suffer under crawl + traffic load. Fix direction: drop `nocache_headers()`, fetch the nonce via a small AJAX call (or accept nonce-less submissions for logged-out users with honeypot + time-trap as the spam gate, which is a standard pattern), and cache `pages.json` parsing in a transient/opcache-friendly PHP export.

> **Update 2026-07-06:** mostly fixed for launch. Generated 200 pages and XML sitemaps now replace WordPress' default no-cache headers with short public cache headers for logged-out visitors, while 410/debris responses remain uncached. `fenster_get_generated_page()` also memoises route results per request. A deeper nonce refactor and persistent PHP/export cache can wait until after launch.

### 3.3 No trailing-slash canonicalisation
`/casement-windows` and `/casement-windows/` both return 200 (the router exits before `redirect_canonical` runs at `template_redirect` priority 10 — the generated renderer runs at priority 0). Canonical tags mitigate, but a proper 301 to the trailing-slash form is cleaner. Same applies to uppercase paths (`/Casement-Windows/` → 404 rather than redirect).

> **Update 2026-07-06:** fixed for generated routes. `/casement-windows` now 301s to `/casement-windows/`, and `/Casement-Windows/` now 301s to the lowercase canonical URL.

### 3.4 Doorway-page risk on the generated matrices
- **273 town×product pages** (13 towns × 21 products) with templated copy and identical meta-description patterns.
- **48 commercial county pages covering all of England** — Cornwall, Cumbria, Tyne & Wear — for a Milton Keynes company. Beyond the Google doorway-page policy risk, this is a credibility problem: a facilities manager in Truro who calls and learns the firm is 300 miles away is a wasted lead; a competitor can screenshot "Commercial Glazing Cornwall" as evidence of spammy SEO.

Recommendation: keep the 13-town residential matrix (it's local and defensible) but invest in making town pages genuinely distinct (local landmarks, real jobs completed in that town, town-specific reviews). For the counties, either genuinely commit to national commercial delivery (and say so credibly with case studies per region) or cut the set back to the realistic delivery radius. At minimum, monitor Search Console for a quality reassessment after launch.

> **Update 2026-07-03:** partially improved. The residential matrix no longer has duplicate meta descriptions: all 273 generated town/product pages now use town and product profile data, and a local crawl confirmed 273 unique meta descriptions. Commercial county metadata has also been made profile-specific, and the clearly impractical Isle of Wight page was removed and marked 410. The broader commercial footprint still needs an owner decision on true delivery radius before launch.

### 3.5 Sitemap contents need a scrub
The custom sitemap (486 URLs) currently includes: `*-designer` scrape pages (thin; only `/door-designer/` carries noindex), `apecs-terms-conditions`, `gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `enquire-now`, `instant-pricing`, blog pagination/category/tag/author URLs, and the duplicate town slugs from 2.6. A sitemap should be your curated "index this" list — right now it's telling Google to index the debris too.

> **Update 2026-07-06:** fixed for the known launch debris. The thin utility/scrape-shell pages now carry `noindex,follow` and are excluded from `page-sitemap.xml`; verified absent: `gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `commercial-areas`, and `commercial-glazing-isle-of-wight`. Current live sitemap count after colour duplicate redirects is 421 canonical URLs.

### 3.6 Quote-page cannibalisation
`/online-quote/`, `/instant-pricing/`, `/enquire-now/`, `/3d-visualiser/`, `/instant-pricing-meta-ads/`, `/pricing-gads/` all serve near-identical quote-tool experiences and all are indexable. Keep `/online-quote/` as the canonical quote page; noindex or 301 the rest (keep ad landers only if live campaigns need them, with `noindex`).

### 3.7 Meta titles/descriptions
- Homepage description is a truncated scrape: "…From energy-efficient uPVC" (cut mid-sentence). Verified in rendered head.
- Homepage title "Fenster Glazing - Double glazing Installers, Buckinghamshire" — leads with brand instead of the money keyword; inconsistent capitalisation. Suggest: "Double Glazing Milton Keynes | Windows & Doors | Fenster Glazing".
- Imported titles are inconsistent in pattern (`– Fenster Glazing` vs `| Fenster Glazing` vs none). Worth a one-pass normalisation of `seo.title_tag`/`meta_description` across `pages.json` for the ~60 pages that matter most.
- Matrix meta descriptions are one identical template ("…specified and installed by Fenster Glazing with survey-led advice, secure products and guarantee-backed fitting.") × 273.

> **Update 2026-07-03:** matrix metadata issue fixed for generated residential location pages. The 273 residential town/product pages now render unique title/meta combinations built from town and product profile data. Commercial county metadata was also changed to use profile-specific town/context data. Homepage/imported-page title and description normalisation remains open.

> **Update 2026-07-06:** homepage metadata fixed for launch. Rendered homepage title is now `Double Glazing Milton Keynes | Windows & Doors | Fenster Glazing`, with a complete local-service meta description.

### 3.8 The noindex dev page is in the public header
"Areas" in the main nav points to `/commercial-areas/`, a self-described "temporary review index … so the full England county set can be checked quickly during development". Real customers see a dev tool in prime navigation space; it also mass-links the 48 county pages sitewide. Remove it from `primary_nav_fallback` in `inc/site-data.php` before launch (the docs already flag it as temporary).

> **Update 2026-07-06:** fixed. The header no longer links to `/commercial-areas/`; the route remains `noindex,follow` and is absent from the sitemap.

### 3.9 Review counts and claims are inconsistent and hardcoded
- Homepage trust card: "200+ five-star reviews (Google)".
- Review widget: "Google — 130 reviews" and "Trustpilot — 226 reviews", hardcoded in `review-showcase.php`.
- Homepage proof band: "1,000+ installations completed".

Two different Google review counts on the same page is a trust wobble, and hardcoded numbers rot. Also, review cards link to a Google **search results** URL (`google.com/search?q=Fenster+Glazing+...reviews`) rather than the Google Business Profile review panel — a weaker, flakier destination. Under the UK DMCC fake-reviews rules (in force since April 2025) you should also be able to substantiate the "EXCELLENT" aggregate. Recommendation: single source of truth for counts (update quarterly or pull via API later, as HANDOVER already plans), link to the real GBP/Trustpilot profile URLs, and align the trust-card copy with the widget.

### 3.10 Internal linking gaps
- `/why-trust-fenster/` is well-built but only linked from a small homepage link + footer.
- `/areas-we-cover/` is only linked from the About page — yet it's the hub that distributes equity to all 273 town pages. Add it to the footer.
- `/terms-conditions/` exists but isn't linked anywhere visible (footer has only Privacy/Cookie). Consumer-facing terms should be findable.
- Breadcrumbs don't exist anywhere — cheap win for both UX and schema.

> **Update 2026-07-06:** `/areas-we-cover/` is now linked from the footer company column, `/terms-conditions/` is linked from the footer legal row, and generated deep routes now output `BreadcrumbList` JSON-LD.

---

## 4. Performance

### 4.1 Homepage weight (measured)
| Asset | Size | Note |
|---|---|---|
| Hero video | 9.36 MB | already optimised vs the 95 MB source, but still heavy on mobile data; consider a 720p mobile rendition or `media`-gated source |
| Hero poster `1-3.png` | **2.9 MB PNG** | loads before/behind the video; should be a ~80 KB WebP |
| 5 theatre images (fenster-reference JPEGs) | ~1.65 MB | all `loading="eager"`, duplicated in desktop + mobile DOM |
| WindowCAD iframe | third-party app | `loading="lazy"` on homepage (good), `eager` on /online-quote/ |
| main.css | 340 KB (55 KB gz) | single bundle on all pages |
| Fonts | 4 × ~100 KB OTF | should be woff2 (~50–60% smaller), consider preloading Regular + Bold |

A realistic first mobile load is well over 12 MB. For a lead site competing on Core Web Vitals, target < 2 MB above-the-fold before the video streams in.

### 4.2 No responsive images anywhere
Every `<img>` in the theme is a bare `src` — no `srcset`, no `sizes`, no `width`/`height` attributes (CLS risk). The 16-tile product galleries load full-size JPEGs into ~300 px cells. Since images are hardcoded, adding a small helper that emits `srcset` from pre-generated size variants would be the highest-leverage performance fix after the reference-folder cleanup.

### 4.3 Unoptimised individual assets spotted
- `assets/partners/liniar-energyplus.png` — 900 KB
- `assets/quote/instant-quote-screenshot.png` — 309 KB
- `assets/trust/google-5-stars.png` — 105 KB (it's a tiny logo strip)
- `assets/images/about/fenster-showroom.png` — PNG for a photo; should be JPEG/WebP
- Several obscure-glass WebPs are 300–400 KB each (texture files can be much smaller).

### 4.4 Server-side
- 4.6 MB JSON decode per request (see 3.2).
- `fenster_get_generated_page()` is called at least 4× per request (router, title filter, SEO head, preload hook) with no memoisation of the *result* — cheap fix: static-cache per slug.
- `fenster_preload_product_scroll_video()` ends in an unconditional `return;` after computing `$video`/`$type` — dead tail; the video preload it was written for never happens.

---

## 5. Content Quality & Placeholder Content

- **Blog articles destroyed by the product template** — see 2.5; this is also a content problem, since the actual article copy no longer renders meaningfully.
- **Customer portal page** promises "use our online order tracking portal" with no portal, and its intro paragraph renders twice. Either integrate the real portal link or remove the page.
- **Gallery / Downloads / Videos / Brochures** are scrape shells whose "content" is largely leftover CSS/meta text. Rebuild or remove.
- **`/refer-a-friend/`** — check whether the scheme still exists; if yes, it deserves a proper page (referral schemes are cheap lead sources), if no, remove.
- **Repeated boilerplate**: the product gallery paragraph ("This X gallery brings together verified product imagery, close-up frame details…") is byte-identical on 25+ pages, and the review-showcase heading block repeats sitewide. Fine functionally, but it dilutes uniqueness on pages that are already template-heavy.
- **Fallback FAQ answers** reference things that may not be on the page ("Popular colours are shown on this page") when they fire on non-product routes.
- **Review dates render in mixed formats** — ISO (`2025-06-12`) for Google, human (`4 Nov 2025`) for Trustpilot. Normalise to one human format.
- ~~**"Phone lines open 24/7"** in the footer hours vs Mon–Fri 8.30–5 — verify this is a real answering service before shipping the claim.~~ **✅ Closed 2026-07-16, reconfirmed 2026-07-20.** The owner confirmed a genuine 24/7 answering service. The claim is accurate and stays as written. Do not raise it again — see the confirmed-facts section in `AI.md`.
- **Trust claims to substantiate before launch**: "200+ five-star reviews", "1,000+ installations", "£5,000 security guarantee" (composite doors), "10 year insurance-backed guarantee" on repairs (10-year guarantee on *repairs* is unusual — confirm).
- **Alias pages** (`aluminium-flush-windows`, `aluminium-sliding-doors`) reuse the source page's scraped sections — spot-check that no source-product-specific copy (e.g. patio-door wording on the sliding-doors alias) leaks through.
- **`/wcad-thank-you/` was removed** — verify the WindowCAD account isn't still configured to redirect completed quotes there, or paying users will finish a quote on a 404. If it is, either re-point WindowCAD or create a proper thank-you page (which you want anyway for conversion tracking).

---

## 6. UX & Design Review

### What works well
- The product theatre, obscure-glass split visualiser, colour coverflow and sash model comparison are genuinely differentiating for this sector — most competitor sites are static brochureware.
- One shared form with in-place AJAX success, clear validation messages and a no-JS fallback is exactly right.
- Mobile discipline (860 px breakpoint, single-column forms, 16 px inputs, 44 px targets, scroll-snap rails with attached dots) is consistently applied.
- The continuous gradient canvas gives the site a coherent feel; contact and trust pages read as designed pages, not templates.
- Phone number persistent in the header; tel: links everywhere they should be.

### Issues and opportunities
1. **The splash loader** (3.1) — the single worst first-impression decision on the site.
2. **"Areas" dev link in the header** (3.8).
3. **Blog articles look broken** (2.5) — a real user landing on "How to clean your uPVC windows" gets a sales page for a product called "How To Clean Your UPVC Windows At Home".
4. **Strict postcode gate on every form.** The postcode field rejects anything that isn't a valid UK postcode. Homeowners are fine; commercial enquirers (the `show_company` variant also requires it) often enquire for a site whose postcode they don't have to hand. Consider relaxing to "postcode or town" for the commercial form — a lost lead costs more than a vaguer location.
5. **No secondary contact channels.** No WhatsApp link, no callback-request micro-form, no live chat. In this sector, WhatsApp photo-of-my-window enquiries convert well and cost nothing to add as a `wa.me` link.
6. **Review "Read more" links go to a Google search page** (3.9) — take users to the actual profile.
7. **Terms & Conditions missing from the footer**; no social profile links anywhere (if the business has active profiles, footer links are standard trust furniture).
8. **Submit button arrow is ASCII** (`-&gt;` in an `<i>` tag) — renders as "->". Tiny, but it's on every form.
9. **The office-dog "Legend" background** in the obscure-glass visualiser is charming, but the toggle label "Show Legend background" is meaningless to a visitor who doesn't know Legend is a dog. Caption it ("Meet Legend, our showroom dog") and it becomes a personality moment instead of a confusion.
10. **Hyphen-replacement script** (`preventHyphenatedWordSplits`) rewrites every text node to use U+2011 non-breaking hyphens. Copy-pasted text (addresses, product names) carries non-standard characters, and it's a blunt instrument for what CSS `hyphens`/`overflow-wrap` handles. Low priority, but worth knowing it's there.
11. **Duplicate H2 on product pages** — the USP strip's H2 repeats the H1 (`Composite Doors` twice). Make the strip heading a styled `<p>` or differentiate the text.
12. **No breadcrumbs** on deep pages (product → location pages especially) — users landing on `/casement-windows-toddington/` have no path back up.
13. **Enquiry admin quality-of-life**: enquiries save as private posts with meta columns (good). There's no email-failure alerting though — if SMTP breaks silently, leads pile up unseen in wp-admin. Consider a daily "unsent enquiries" check or at least an admin notice when `_fenster_email_sent = 0` rows exist.

> **Update 2026-07-06:** reported mobile UX blockers on About and Contact are fixed. Keep them as regression checks: process cards need internal padding, Contact CTA cards need readable image overlays with no label/title/copy/action overlap, and mobile quote embeds should use one same-tab action.

---

## 7. Accessibility

Overall better than average: skip-link present, real buttons, aria-pressed/aria-current maintained by JS, reduced-motion respected across every effect, accessible labels on carousels and dots.

Remaining items:
- Obscure-glass and window-selector options activate on **focus** — keyboard users tabbing through change state as they pass. Use selection-on-Enter/Space (activation on focus is a known WCAG pattern smell).
- The integral-blinds reveal hijacks wheel/keyboard/touch scrolling until complete; Escape/skip is not offered. Reduced-motion users skip it, but a keyboard user without that setting must scroll through ~1.55 viewport-heights of video. Offer a "Skip" affordance.
- Review-showcase star ratings are CSS-only with aria-labels (fine), but the "EXCELLENT" summary block has no machine-readable rating.
- Form error feedback focuses correctly and uses role=alert (good). The success state replaces the form — ensure focus moves to the feedback (there is `tabindex="-1"` on the feedback div; verify `.focus()` is called — it isn't in the JS success path).
- Decorative theatre images use `alt=""` correctly, but the stage is a link whose only text is the aria-label — fine, keep it synced (it is).

---

## 8. Code Quality & Architecture

Strengths: consistent escaping (`esc_html`/`esc_url`/`esc_attr` everywhere checked), nonce + honeypot + time-trap on the form, no SQL, no file uploads, sane CPT for enquiries, `filemtime` cache-busting, no plugin dependencies.

Issues:
1. **`generated-page.php` is 3,179 lines** doing routing, data-shaping and markup for ~12 page types. It contains ~250 lines of *unreachable* legacy homepage markup (the `$is_home` branches after line 1934 — the real homepage returns at line 1208) including the old `fg-home-hero-3d` canvas and a section that literally says "Use the visualiser when the site is on the live Fenster domain". Dead weight and a trap for future AI passes (the docs warn about exactly this).
2. **~620 lines of `if (false)` Three.js code** in `src/js/main.js` (esbuild strips it from the bundle — verified compiled JS has no `THREE`), plus the inactive `[data-fg-home-product-story]` controller and stepped-form logic whose markup no longer renders. Delete; the docs already declare them dead.
3. **`$sick_video`** as the hero-video variable name — rename before someone ships it in a class name.
4. **Slug heuristics** (`$is_product`, `$is_commercial` via `str_contains`) are the root cause of 2.5 and will keep misfiring as pages are added. Explicit route lists exist already — use them.
5. **`fenster_get_generated_page()` result isn't memoised** despite 4+ calls per request; `pages.json` (4.6 MB) is decoded per request.
6. **Hardcoded production URLs** in canonical/sitemap generation (`https://fensterglazing.com/...`) — intentional, but centralise into one constant so staging can override.
7. **Duplicate docs**: `AI.md`/`HANDOVER.md` exist at both the repo root and `app/public/` — two copies will drift. Pick one location.
8. Duplicate partner logo files (`liniar.png` = `liniar-logo.png`, byte-identical).

---

## 9. Email / Enquiry Deliverability

- No SMTP constants are defined in `wp-config.php` locally — on production, `wp_mail()` will fall back to PHP `mail()`, which lands in spam or fails silently on most hosts. The constants system exists (`FENSTER_SMTP_*`); it must actually be configured at launch.
- Office mail currently sends with the old proven envelope `WordPress <wordpress@fensterglazing.com>`, which live testing confirmed reaches `info@fensterglazing.com`. Authenticated SMTP plus SPF/DKIM/DMARC is still needed before enabling customer confirmation emails again.
- The office email's "View saved enquiry" button links to wp-admin — correct, but make sure the office staff have accounts.
- Leads are saved before email (excellent). Add the unsent-lead alerting from 6.13.
- GDPR: enquiries store personal data indefinitely as private posts. The privacy policy should state retention, and a periodic purge (e.g. 24 months) is worth scheduling.

---

## 10. Launch Checklist (beyond the fixes above)

1. Commit everything to git; push to a private remote. (2.8) **Done; scoped GitHub repo is live.**
2. Decide the `fenster-reference` strategy; migrate needed assets into the theme. (2.2) **Done for runtime references; keep the reference export out of production.**
3. Build the 301 redirect map: old-site URLs → new slugs, debris → targets, duplicate town slugs → matrix slugs, `-designer` pages → parent products. **Partially done in central route handling; full old-site redirect import still needs review.**
4. Fix schema rendering + add LocalBusiness/FAQ/Breadcrumb schema. (2.1) **LocalBusiness + product FAQPage + generated BreadcrumbList done.**
5. Fix robots/sitemap plumbing; disable core sitemaps; scrub sitemap contents. (2.3, 3.5) **Core plumbing and known launch-debris sitemap scrub done; ongoing curation continues as pages are removed or rebuilt.**
6. Fix blog-article routing. (2.5) **Done.**
7. Remove "Areas" nav item and noindex-or-remove `/commercial-areas/`. (3.8) **Done; route remains noindex and absent from sitemap.**
8. GA4 + GTM + consent banner + form-success conversion event + WindowCAD click events. (2.7)
9. Configure SMTP + SPF/DKIM/DMARC; send test enquiries end-to-end. (9)
10. Remove/shorten the splash loader. (3.1) **Done; loader removed.**
11. Image pass: hero poster, theatre images, partner PNGs, srcset/width/height. (4)
12. Verify WindowCAD post-quote redirect doesn't point at the deleted `/wcad-thank-you/`. (5)
13. Set up Google Business Profile ↔ site consistency (NAP matches footer exactly) and Search Console + Bing Webmaster at launch.
14. Caching plan compatible with the nonce'd form (see 3.2) + a CDN for the video. **Launch baseline done with short public cache headers; deeper nonce refactor can follow.**
15. Reconcile review counts and claims; link review cards to real profiles. (3.9)
16. Decide the commercial-county footprint honestly. (3.4) **Started: Isle of Wight removed/410; broader county footprint still needs owner decision.**
17. Deploy from the scoped GitHub theme repo, not by copying the full local WordPress install. **Ready as a theme swap/update path; production uploads/database/config stay in place.**

---

## 11. Prioritised Action Plan

**Week 1 — stop the bleeding (all cheap, high impact):**
git init+commit · schema filter bug · robots/sitemap fix · remove Areas nav · noindex/410 debris pages · fix duplicate town slugs · remove splash loader · homepage meta title/description · GA4+consent+lead event.

**Week 2 — content integrity:**
blog-article routing fix · migrate fenster-reference assets into theme (optimised) · thin-page triage (gallery/downloads/videos/portal/refer-a-friend) · review-count reconciliation · terms link in footer · WindowCAD thank-you check.

**Week 3–4 — performance & depth:**
responsive images + width/height · woff2 fonts · caching strategy (nonce refactor) · pages.json parse caching · LocalBusiness/FAQ schema build-out · breadcrumbs · town-page uniqueness pass · commercial-county decision · dead-code deletion (Three.js block, legacy home branches, product-story, stepped form).

**Ongoing:**
Search Console monitoring after the index reshuffle · quarterly review-count updates until an API feed exists · enquiry-delivery monitoring · substantiation file for marketing claims.

---

## 12. What's Genuinely Good (don't break these)

- One shared enquiry form + handler with save-before-send and spam traps.
- Route-checked related links (no scrape debris in link panels — verified on sampled pages; zero broken internal links found on the homepage).
- Reduced-motion and mobile fallbacks on every cinematic feature.
- Curated product USP/content data with a "don't invent specs" rule that's actually followed.
- Documentation system that lets any new contributor (human or AI) get oriented in minutes.
- Clean, plugin-free codebase with consistent escaping and a coherent design language.

The bones of this site are better than most agency builds. The gap between "impressive local build" and "lead-generating machine" is almost entirely in Section 2 and 3 — indexation hygiene, the schema bug, measurement, and the launch plumbing.
