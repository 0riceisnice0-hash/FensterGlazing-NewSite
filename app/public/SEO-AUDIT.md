# Fenster Glazing — Master SEO Audit: The Road to #1 in Milton Keynes

Date: 2026-07-07
Goal: rank #1 in Milton Keynes and surrounding areas for residential windows, doors and glazing.
Method: full technical crawl of all 421 live URLs, content-scope internal link graph (header/footer excluded), keyword-to-page targeting map, live SERP checks for the money terms, competitor content benchmarking, schema and performance inspection, GBP verification.

---

## The Honest Verdict

The technical SEO is now better than every competitor checked — genuinely. 421/421 URLs healthy, zero duplicate titles, zero duplicate descriptions, unique H1s, self-consistent canonicals, LocalBusiness + breadcrumb schema on every page, FAQ schema on 35 product pages, 100% og:image coverage, clean redirects, scrubbed sitemap. Fenster is already appearing on page one for "double glazing Milton Keynes" and top-3 in web results for "windows and doors Milton Keynes installer" within days of launch.

What stands between here and #1 is **not more technical polish**. It's four things, in order of leverage:

1. **The local pack** (map results) — decided by Google Business Profile signals, reviews, and proximity, barely by the website. GBP is already strong (4.9★, 99 reviews) but the site isn't feeding it (no `geo`/`sameAs`/`hasMap` in schema, citations unaudited).
2. **Authority** — the incumbents (Custom Glaze est. 1981, T&K 40+ years, Win-Dor est. 1978, Gallaghers 25+ years) have decades of accumulated links, citations and brand searches. Fenster has one known press link. This is the long pole.
3. **Two internal-architecture own-goals** (findings F1–F2) that starve exactly the pages the goal depends on.
4. **Content gaps where buyers actually search** — prices/cost intent, MK's own suburbs, conservatories/porches, repairs.

Pillar scores:

| Pillar | Score | Summary |
|---|---|---|
| Technical & indexation | 9.5/10 | Near-perfect; 3 residual items |
| On-page targeting | 8/10 | Clean 1:1 keyword map; 4 titles missing MK; legacy "…Prices UK" suffixes |
| Internal architecture | 6.5/10 | Two critical pages starved of links (F1, F2) |
| Local SEO | 6.5/10 | GBP strong; schema-GBP linkage missing; suburbs uncovered; citations unaudited |
| Content coverage | 7/10 | Strong product depth; missing price-intent, suburb, conservatory, repair content |
| Authority & E-E-A-T | 4.5/10 | One press link vs 40-year incumbents; biggest gap |
| Performance / CWV | 6.5/10 | TTFB 0.69s fine; no responsive images; Lighthouse mobile baseline was 62; PSI re-check needed |
| Measurement | 5/10 | GTM + Clarity live; lead events and rank tracking still not confirmed |

---

## F1 — CRITICAL: The head-term page has one internal link

`/double-glazing-milton-keynes/` targets the single most valuable phrase in the business — and the content-link graph gives it **1 in-link across the entire site**. For comparison: `/double-glazing-replacement/` has 357, `/windows-milton-keynes/` 327, `/composite-doors/` 306, even `/privacy-policy/` has 405. The page that should be the strongest is the most starved.

Compounding it, the **homepage targets the same term** (title "Double Glazing Milton Keynes | Windows & Doors | Fenster Glazing", H1 "Double Glazing in Milton Keynes") — so the two pages split the query between them, and Google gets to choose which to show.

**Fix (recommended sequence):**
1. Add `/double-glazing-milton-keynes/` prominently to the related-links bands on all window/door product pages and to the footer, and link it from the homepage local-links block with exact-match anchor (it may already be there — verify; the graph shows only one content link total).
2. Differentiate the two pages by intent rather than merging: homepage = brand + head term; `/double-glazing-milton-keynes/` = the deep local page (prices guidance, MK estates/suburbs served, MK installs, MK reviews, showroom directions). Its 1,573 words are a decent base — make it the best "double glazing in MK" page in the market (3,000+ words, photos of MK installs, suburb list, price-guide section feeding the instant quote tool).
3. Watch GSC for 4–6 weeks: if Google keeps flip-flopping which URL ranks, consolidate (301 the dedicated page into the homepage). Don't 301 pre-emptively — the dedicated page currently ranks.

## F2 — CRITICAL: `/areas-we-cover/` is fully orphaned (regression)

The hub that organises all 273 town×product pages is now: **absent from the live sitemap** (every other virtual route is present), **no longer linked from the footer** (the 07-06 footer link is gone from live), and the About-page CTA was removed in commit `6d65c1b`. Zero content in-links. It's a 200, indexable page that nothing on the site points to — and it's the "surrounding areas" half of the ranking goal.

**Fix:** restore it to the sitemap's virtual-route list, restore the footer link, and give it a link from `/double-glazing-milton-keynes/` and the homepage areas block. Town pages currently survive on product-page related-links + sitemap alone; the hub restores a proper crawl path and a rankable "areas we cover" asset.

## F3 — HIGH: Four money titles don't mention Milton Keynes

`/aluminium-bifold-doors/` ("Aluminium Bifold Doors | Fenster Glazing"), `/aluminium-sliding-doors/`, `/aluminium-flush-windows/` and `/window-and-door-repairs/` have no geo term at all. "Bifold doors Milton Keynes" is one of the highest-value queries in this niche. Also: several titles carry legacy "…Prices UK" / "…Supply UK" suffixes ("Sash Windows Prices UK", "Patio Sliding Doors Supply UK", "Roofline Installation UK") — a national signal diluting local relevance on otherwise local pages.

**Fix:** normalise the pattern to `{Product} Milton Keynes | {benefit/secondary} | Fenster Glazing` across all 24 product pages; kill every "UK" suffix on local money pages. One pass in `pages.json`/title overrides.

## F4 — HIGH: Schema isn't wired to the Google Business Profile

The LocalBusiness block is missing exactly the fields that connect site ↔ GBP ↔ map pack:
- **No `geo`** (lat/long for MK13 9HF), **no `hasMap`** (GBP maps URL), **no `sameAs`** (GBP listing, social profiles, FENSA/CPA directory entries).
- `priceRange` renders as mojibake: `Â£Â£` (double-encoded UTF-8) — visible to every validator.
- Product pages carry FAQPage but no `Service`/`Product` markup with `areaServed` (optional, worthwhile later).

**Fix:** add geo/hasMap/sameAs to `fenster_render_site_schema()` and fix the encoding. Fifteen-minute change, direct map-pack relevance.

## F5 — HIGH: Milton Keynes' own suburbs are uncovered

The 13-town matrix covers the ring (Bedford, Northampton, Aylesbury, Buckingham…) but **not one MK suburb**. Custom Glaze explicitly targets Bletchley, Newport Pagnell and more. People search "double glazing Bletchley", "windows Newport Pagnell", "composite doors Wolverton" — and Fenster, the company *based in MK*, has nothing for them. There's even an orphan proof-page already (`/replacing-windows-doors-in-wolverton-mk/`).

**Fix:** add an MK-suburb ring to the matrix (or better, hand-build 6–8 richer pages): Bletchley, Newport Pagnell, Stony Stratford, Wolverton, Woburn Sands, Olney, Buckingham-side estates. Hand-built beats matrix here — these are proximity queries where genuine local detail (estate names, install photos) wins.

## F6 — HIGH: Authority deficit (the long pole)

Known backlink profile: one Milton Keynes Citizen article. The incumbents have decades of citations, supplier listings, sponsorships and brand equity. No amount of on-site work outranks that alone. The playbook, roughly in effort order:

1. **Supplier installer-finder pages** — Liniar, Sheerline, Roseview, Distinction Doors and Notan all maintain "find an installer" directories. Fenster is an active customer of all five; these are free, high-relevance links. Ask the reps.
2. **Accreditation profiles** — FENSA's public register entry, CPA member profile, GGF if applicable; make sure each links the site and matches NAP exactly.
3. **Citations audit + build** — Google Business Profile (done), Bing Places, Apple Business Connect, Yell, Thomson Local, FreeIndex, Trustpilot profile (exists — verify website link), Checkatrade/TrustATrader (decide — they also *compete* in SERPs, but the citation + reviews help), MK-specific directories (MK Chamber of Commerce, Destination Milton Keynes).
4. **Local PR cadence** — the instant-pricing-tool story already worked once with the MK Citizen; repeat quarterly (showroom events, charity sponsorship, apprentice hires, notable local installs). MKFM, MK Citizen, OneMK.
5. **Review velocity** — 99 Google reviews at 4.9★ is good; the incumbents have volume. Systemise the ask: post-installation SMS/email with the GBP review link (the enquiry system already emails customers once SMTP lands — add the review ask to the aftercare touchpoint).

## F7 — MEDIUM: Content gaps where buyers search

1. **Price intent** — "double glazing prices Milton Keynes", "how much do bifold doors cost" etc. are the highest-converting queries after the head terms, and Fenster owns the perfect asset (the instant quote tool) with **no price-content pages** feeding it. Build honest price-guide pages/sections ("what affects the price", typical ranges, then the tool). This is the biggest content win available.
2. **Conservatories & porches** — every incumbent sells them; Fenster has no page (porches are one line in other-services). Business decision: if Fenster fits them, this is a whole missing keyword family; if not, ignore.
3. **Repairs** — `/window-and-door-repairs/` exists but no local targeting (F3) and "misted/blown double glazing Milton Keynes" style queries are quick-win volume feeding the replacement-units service.
4. **Residential case studies are 410'd** — understandable pre-launch, but local proof pages ("Sash windows in Stony Stratford", "Bifolds in Woburn Sands") are exactly what suburb pages and E-E-A-T need. Rebuild a few real MK jobs with photos as a priority, not a someday.
5. **Blog freshness** — the imported guides are fine but undated and static; 1–2 new local posts a month (installs, advice, MK-specific) keeps the domain visibly alive.

## F8 — MEDIUM: Performance / Core Web Vitals

- Documented Lighthouse mobile baseline was 62 (4.3s FCP / 14.5s LCP) before deferral waves 1–2; PSI couldn't be re-run today (keyless quota) — re-test and record.
- Images now ship width/height (good) but **no `srcset`** — full-size JPEGs serve to phones. This is the main remaining LCP lever, already noted in HANDOVER as the next performance phase.
- TTFB 0.69s is acceptable; SiteGround dynamic cache appeared off earlier (`X-Cache-Enabled: False`) — enabling it is free TTFB.
- CSS has grown to 85 KB gz (was 55 KB) — worth watching, not urgent. No HSTS header.
- Fonts still OTF, no preload (carried from the original audit).

## F9 — SMALL RESIDUALS (quick sweep-up)

- `robots.txt` still carries `Crawl-delay: 10` — throttles Bing for no benefit. Remove.
- 363 meta descriptions still exceed ~175 chars (matrix/county templates) — unique and well-written, but Google truncates the CTA off. Trim the templates.
- One broken internal link remains: `/commercial-projects/` → 410'd Woburn case study.
- `/videos/` and friends still appear in Google from stale indexing — they're noindexed correctly; request removal in GSC to tidy faster.
- Quote-intent split: `/online-quote/`, `/3d-visualiser/`, `/design-your-windows-and-doors/` all indexable for the same intent (carried finding).

## Measurement (can't hit #1 blind)

- **Google Search Console**: verify property, submit `sitemap.xml`, fix-check the two F1/F2 pages' impressions weekly. (Not confirmable from outside — treat as unchecked.)
- **Lead events**: GTM (`GTM-K89BCS9`) and Clarity are live, consent banner is live — but the theme still pushes no `dataLayer` events on form success/phone clicks/quote-tool opens. Until that lands, "what ranks" can't be tied to "what converts".
- **Rank tracking**: track ~25 terms weekly: head terms (double glazing/windows/doors MK), product×MK (bifold, composite, sash, aluminium…), suburb terms once built, 5 ring-town terms.
- **GBP insights**: calls/direction-requests monthly alongside organic.

---

## The 30 / 60 / 90 Plan

**Days 1–30 (mechanical, all in-house):**
F2 areas-hub restoration → F1 internal links to the head-term page → F3 title pass (4 missing-MK + kill "UK" suffixes) → F4 schema geo/sameAs/hasMap + mojibake → F9 sweep (crawl-delay, Woburn link, description templates) → GSC verification + sitemap submission + lead events in GTM → supplier installer-directory requests sent → citations audit.

**Days 31–60 (content offensive):**
Rebuild `/double-glazing-milton-keynes/` as the market's best MK page → build 6–8 MK suburb pages (hand-written, with real install photos) → price-guide content feeding the quote tool → relaunch 3–5 residential case studies from real MK-area jobs → conservatories/porches decision.

**Days 61–90 (authority + iteration):**
Local PR story #2 → review-velocity system live with SMTP → responsive images (`srcset`) + PSI re-test → Bing Places/Apple Business Connect → first rank-tracking review; consolidate or double-down on F1 based on GSC data.

**Ongoing:** 1–2 local posts/month, quarterly PR, monthly rank + GBP review, keep the technical layer clean (it's currently the best in the market — protect that).

---

## Old Site vs New Site: What Made the Old SEO Work, and Where We Stand (added 2026-07-09)

Analysed from `wp-content/fenster-reference/yoast-seo-from-backup.generated.json` (the old site's complete Yoast database from the 2026-06-01 backup) and the full site export (275 crawled URLs). No old-site GitHub repo exists locally or in the docs; the old `wraith` theme survives only on the server, but these two artifacts are the complete SEO record.

**Why the old site ranked:**

1. **Hand-tuned Yoast discipline at real scale** — 265 URL indexables, **199 pages with an individually chosen focus keyword**, 261 hand-written meta descriptions, 286 with OG data. Somebody sat down and mapped one keyword to one page across the whole site.
2. **The dual-geo title formula** — "{Product} Milton Keynes | {Category} Buckinghamshire" (50 titles carrying MK, plus Northampton/Buckinghamshire secondaries). These exact titles are still live today via `pages.json`.
3. **118 town×product location pages averaging 1,860 words** — a genuine local landing-page programme, not thin doorway stubs.
4. **Deep money pages** — casement 2,151w, bifolds 2,361w, sash 2,306w, uPVC doors 2,074w.
5. **~25 informational guides** feeding topical authority, plus fresh commercial posts into 2026.
6. **Domain-level equity that transfers regardless of code** — domain age, accumulated links/citations, the GBP and its reviews. Part of the old ranking power was never "the site" at all.

It was *good, not immaculate*: it also shipped fake aggregateRating schema, indexable test pages, designer-tool debris and truncated copy — all documented and removed in the rebuild.

**Maintained (verified):** every old URL resolves (200 / deliberate 301 / deliberate 410); the Yoast titles and descriptions were carried verbatim into the new money pages; location coverage grew 118 → 273 pages with unique metadata; the 1:1 keyword→page map survived.

**Improved:** technical layer (zero duplicates, breadcrumb+FAQ+LocalBusiness schema, clean canonicals, debris purged), speed, homepage now targets the head term, 421 curated sitemap URLs vs 275.

**Regressed vs the old site (watch these):**
1. **Case studies** — live on the old site, 410'd now. The one content class the old site had that the new one doesn't.
2. **Money-page depth bled during template redesigns** — casement 2,151→1,648 (−23%), bifolds 2,361→1,915 (−19%), uPVC doors 2,074→1,825. Sash and composite grew. Rule going forward: template polish must not delete copy; check word count before/after.
3. **Content cadence** — the old site was still publishing in 2026; the new one froze the imported set (F7.5).

## Mechanical Batch Verification (2026-07-09, checked on live)

**Verified done on live:** F2 `/areas-we-cover/` back in sitemap + footer; F3 titles (bifolds/sliders/flush/repairs/sash/patio all MK-targeted, "UK" suffixes gone); F4 schema complete (GeoCoordinates, hasMap, 5 sameAs entries, clean `££`); roof-lights keyword live in titles; `Crawl-delay` stripped from robots.txt; `/double-glazing-milton-keynes/` heavily interlinked (10 links from six money pages alone) **and substantially rebuilt — now ~4,200 rendered words with 14 real content sections**, further along than the status notes suggest.

**Residual fixes found during verification (all small):**
1. `/roof-lanterns/` title lost "Milton Keynes" in the roof-lights retitle ("Roof Lanterns & Roof Lights | Fenster Glazing") — and since MK isn't a matrix town, this *is* the MK roof lantern page. Restore the geo term.
2. Pricing hub title doubles the location: "Window and Door Prices Milton Keynes | **Fenster Glazing Milton Keynes**".
3. The Woburn broken link on `/commercial-projects/` → 410 target is still live (carried from L7).
4. Matrix meta descriptions are still 260–285 chars — the trim (R6/L11) has not happened.
5. Quote-intent trio (`/online-quote/`, `/3d-visualiser/`, `/design-your-windows-and-doors/`) all still indexable — consolidation decision still open.
6. Copy-vocab regression on the new head-term page copy: "Four **routes** through the page…" — the banned internal vocab is creeping back into new writing; re-check new copy against COPY-AUDIT.md §3 before deploys.
7. What the head-term page still lacks vs the F1 spec: MK suburb/estate coverage, real install photos/local proof, a reviews moment and showroom directions — the skeleton and pricing content are already strong.

**Remaining hard items (agreed backlog):** MK suburb pages · residential case studies (biggest gap vs Crown) · authority/citations (non-code) · lead-event tracking in GTM · responsive images/CWV re-test · price-content strategy beyond the hub · conservatories/porches business decision · measurement rhythm.

## Whole-Site Health Check (2026-07-09, evening crawl — 701 URLs)

The MK suburb expansion is live: sitemap grew 421 → **701 URLs** (280 new = 21 products × ~13 MK suburbs incl. Bletchley, Newport Pagnell, Stony Stratford, Wolverton, Woburn Sands, Furzton, Oldbrook, Monkston, Great Linford, Brooklands, Whitehouse). All 701 fetch 200 with full schema/og:image coverage, zero H1/canonical issues, zero duplicate descriptions.

**New issues introduced by the expansion:**
1. **CANNIBALISATION — "milton-keynes" was included as a matrix town.** The main product pages already ARE the MK pages, so all 21 new `-milton-keynes` matrix pages target the same queries as their parent product pages. Two have byte-identical titles (`/composite-doors/` vs `/composite-doors-milton-keynes/` — both "Composite Doors Milton Keynes | Secure Front Doors"; same for aluminium doors). Fix: remove `milton-keynes` from the suburb matrix and 301 those 21 URLs to the main product pages (or, minimum, differentiate every title/intent — but the 301 is cleaner).
2. **690 of 701 meta descriptions now exceed ~175 chars** — the new pages inherited the long-description template; the trim (R6) is now a 690-page issue and should happen in the template before Google indexes the new set.
3. The suburb pages are matrix-templated rather than the hand-built-with-local-proof pages the plan specified — acceptable to ship, but they will rank materially better once each carries at least one real local job/photo (ties to the case-studies workstream).
4. Woburn broken link on `/commercial-projects/` — still present (third audit in a row).

**Also shipped since last review (verified in git):** a consent-gated first-party attribution pipeline — WindowCAD quote relay/attribution, visitor journey tracking, funnel relay, mobile header call button — which substantially closes the L6 lead-tracking gap. TTFB has improved further to ~0.29s.

## GSC Reality Check (added 2026-07-09, from the 16-month Search Console export)

Source: owner's GSC performance export, Web search, 2025-03-08 → 2026-07-07 (mostly the old site; the new site is only the final days). 9,694 clicks / 2.82M impressions / 358 pages / 1,000 queries.

**1. The old site was in a 16-month decline.** Monthly clicks fell from ~768 (Mar 2025) to ~426 (Jun 2026) — down 45%. The rebuild did not break a healthy site; it caught a falling one. Early July daily clicks (~16/day) are level with June (~14/day): **no post-migration crash is visible so far.** Watch weekly.

**2. "The old SEO was good" was really three concentrated assets:**
- **Brand queries** — 994 clicks ("fenster glazing" #1 at pos 2.6).
- **One article** — `/what-is-a-door-lintel/` earned **3,360 clicks (35% of everything)** at position ~3 nationally, including international variants ("dintel de puerta"). The informational engine, not the money pages, drove the traffic — which is why protecting and expanding the article layer matters (and why the two still-truncated articles should be fixed).
- **The designer/pricing tools** — ~960 clicks across the 3D designer article, visualiser and instant-pricing pages. Search demand for the pricing tool already exists ("window visualiser" pos 9).

**3. The old site never actually won local.** All local queries combined earned just **378 clicks in 16 months**. The money terms hovered at striking distance and stayed there: double glazing MK pos 11, composite doors MK 11.5, aluminium windows MK 10.9, front doors MK 10.4, uPVC windows MK 12.9, bifolds MK 6.9. So the #1 goal is not "recover past glory" — it's winning positions the domain has **never held**, from a base that's already on the page-1/page-2 border.

**4. Proof the town-page strategy converts when it ranks:** "bifold door installation hitchin" — position 3.2, **23% CTR** (32 clicks from 138 impressions). Local searchers click local pages hard; the matrix just needs more terms pushed into the top 5.

**5. The striking-distance hit list (position 5–15, ≥1,500 impressions, commercial intent):** double glazing MK (10.1K impr, pos 11 → F1's direct payoff), french casement windows (13.4K, pos 13 — national term the site already owns), uPVC windows MK (5K, 12.9), composite doors MK (3.8K, 11.5), front doors MK (3.5K, 10.4), bifolds MK (2.5K, 6.9), aluminium windows MK (2.9K, 11), bifold doors Northampton (3.5K, 12.7), commercial window replacement (5.9K, 7.5), commercial window installation (2.8K, 9.3, **zero clicks** — snippet problem), window repair MK (2.3K, 13.2 — F3's missing-MK title exactly), and **"roof lights northampton" (3.2K impressions, position 6.4, zero clicks)** — the roof lanterns pages never use the phrase "roof lights"; add the synonym to titles/copy for a free win.

**6. Devices:** mobile 5,110 clicks vs desktop 4,382 — mobile-first confirmed; the performance work is aimed at the majority segment.

**Reprioritisation this data forces:** F1 (head-term page) is now measurably the single highest-value fix (pos 11 with 10K impressions is one push from page 1); F3's repairs title has a query waiting for it; add "roof lights" synonym work; and treat the article layer as a first-class traffic asset — the lintel page alone out-earned every product page combined.

## Head-to-Head: Fenster vs Crown Windows (primary competitor)

Crown Conservatories, Windows & Doors — crownwindows.co.uk, Unit E Lyon Road, **Bletchley MK1** (same city, so the local pack is a straight GBP fight). Audited 2026-07-07 from their sitemaps, key pages, schema and review footprint.

| Dimension | Crown | Fenster | Winner |
|---|---|---|---|
| Years trading | 20+ | 8 (est. 2018) | Crown |
| Indexed pages | 865 | 421 | — (volume ≠ value) |
| Product pages | 663 (383 door styles, 161 windows, **118 conservatory pages**) | 24 deep product pages | Crown on breadth, Fenster on quality-per-page |
| Case studies | **72 live, MK keywords in slugs** (incl. a celebrity install) | 0 residential live (410'd), 5 commercial | Crown, heavily |
| Blog | 91 posts, monthly cadence (June 2026 fresh) | ~40 imported guides, no cadence | Crown |
| Area pages | 14 rich pages (incl. **Olney, Woburn**, Towcester, Brackley, Bicester, Banbury) | 273 matrix pages + 13 ring towns (no MK suburbs) | Split — Crown depth, Fenster coverage |
| MK money page | ~2,500–3,000 words, video, Trustpilot embed, energy-savings claims, quote form mid-page | 1,573 words, 1 internal link (F1) | Crown |
| Head-term titles | Homepage AND MK page both "Double Glazing Milton Keynes \| Windows & Doors \| Crown" | Same dual structure, near-identical homepage title | Direct collision — this is the fight |
| Accreditations shown | FENSA, GGF, LABC, InstallSure, Guardian, National Trading Standards | FENSA, CPA | Crown |
| Reviews | Trustpilot ~283, Checkatrade, Houzz, active Instagram | Google 99 @ 4.9★, Trustpilot ~226 | Crown on spread, Fenster on Google quality |
| Schema | LocalBusiness ×2 with **GeoCoordinates**, Article, Breadcrumb (Yoast) | LocalBusiness + Breadcrumb + FAQ sitewide, but no geo (F4) | Split — they have the geo Fenster lacks |
| Technical hygiene | Standard Yoast WP | Near-perfect custom (zero dupes, clean canonicals, FAQ schema) | **Fenster** |
| Performance | **TTFB 4.06s**, 180 KB HTML | **TTFB 0.41s**, 78 KB HTML | **Fenster, 10×** |
| Unique weapon | Conservatory range + comparison-intent pages ("window-companies-milton-keynes") | **Instant online pricing tool** (nobody else has one) | Different weapons |

**What Crown is doing that Fenster must answer:**

1. **72 local case studies** — each one is a long-tail local landing page and E-E-A-T proof. Fenster's residential case studies are 410'd. This is the single biggest content gap vs Crown and the fastest to close with real jobs already completed.
2. **Conservatories = 118 pages of keyword surface Fenster doesn't contest.** Business decision first (see F7.2); if Fenster fits conservatories/porches, Crown's biggest content moat opens up; if not, concede that family deliberately.
3. **Comparison-intent capture** — Crown built "window-companies-milton-keynes" and "conservatory-companies-milton-keynes" pages to catch people comparing firms. Fenster already has `/why-choose-fenster-over-anglian/`; the same play works locally ("choosing a window company in Milton Keynes" — honest buying guide, Fenster's transparency story wins on this ground).
4. **Multi-platform review spread** (Trustpilot + Checkatrade + Houzz + Instagram) = citations Fenster is missing (F6.3).
5. **Monthly content cadence** — their domain looks alive to Google every month; Fenster's imported blog is static (F7.5).

**What Fenster holds that Crown can't easily copy:**

1. **10× faster site** — with Core Web Vitals a ranking input and 4-second TTFBs on Crown's side, every performance improvement Fenster ships (srcset, F8) widens a moat Crown would need a rebuild to close.
2. **Vastly cleaner technical layer** — Crown's 865 URLs include huge near-duplicate style trees; Fenster's crawl budget is focused.
3. **The instant pricing tool** — Crown's CTA is "Get a FREE Quote" ×10 (a form). Fenster shows prices online, today. Every price-intent page built (F7.1) weaponises this against Crown's biggest CTA.
4. **Google rating quality** (4.9★) and a genuinely better buying experience (visualisers, colour hub, transparent pricing) — the review velocity system (F6.5) converts that into volume, which is where Crown currently wins.
5. **Broader town coverage** (273 pages) for the ring towns Crown only covers with 14 pages — Fenster can win Bedford/Northampton/Luton-side queries while contesting MK head-on.

**Beat-Crown priority stack (folds into the 30/60/90):** case studies back (target 20+ MK-area jobs in 90 days) → suburb pages incl. Olney/Woburn where Crown already ranks → geo/sameAs schema parity (F4) → price-guide content vs their quote-form CTA → local comparison guide page → review velocity + Trustpilot/Checkatrade/Houzz citations → conservatories decision → protect the speed advantage.

## Competitor Reference (checked 2026-07-07)

| Competitor | Angle | Notable |
|---|---|---|
| Custom Glaze (customglaze.co.uk) | est. 1981, family-run | 2,800-word homepage, Which? Trusted Trader, Trustmark, conservatories, targets MK suburbs |
| Aspire (miltonkeynesdoubleglazing.co.uk) | exact-match domain | Prices-led messaging |
| T&K Home Improvements | 40+ years | Dedicated `/double-glazing-milton-keynes` page |
| Win-Dor, Gallaghers, Crown, Window Pains MK, Double Glazing Direct | 25–45 years each | Conservatory range, area pages |
| Directories in SERP | TrustATrader, Checkatrade | Occupy positions Fenster can't — join or outrank |

Fenster's differentiators to lean on everywhere: **instant online pricing (nobody else has it), 4.9★, showroom, in-house fitters, transparent pricing story.** The incumbents sell longevity; Fenster should sell transparency + speed — and let the reviews carry trust.
