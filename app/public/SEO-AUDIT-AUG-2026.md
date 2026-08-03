# Fenster Glazing — SEO Audit, August 2026

Date: 2026-08-03
Sources: the owner's 16-month GSC export (Web search, 2025-04-02 → 2026-08-03: Chart/Queries/Pages/Countries/Devices/Search-appearance CSVs), all prior SEO documents (`SEO-AUDIT.md` 2026-07-07 + reconciliations, `LAUNCH-WEEK-REPORT.md` 2026-07-14, `ACTION-PLAN.md` 2026-07-16, `HIGH-INTENT-SEARCH-PLAN.md` 2026-07-22), git history since 22 July, and live checks today (TTFB 0.30s, robots.txt clean, sitemap 703 URLs).

New site went live **5 July 2026**. This export is the first full month of post-launch data.

---

## 1. First, the September 2025 question — the "position spike" was not a ranking event

Between roughly **11–13 September 2025** average position jumped from ~36 to ~18 and impressions **halved** (7,083/day → 4,264/day) while clicks did not move (21.6/day → 20.0/day):

| Window | Clicks/day | Impressions/day | Weighted position | CTR |
| --- | --- | --- | --- | --- |
| 10 Aug – 10 Sep 2025 | 21.6 | 7,083 | 35.8 | 0.30% |
| 13 Sep – 13 Oct 2025 | 20.0 | 4,264 | 20.2 | 0.47% |

That is the signature of **Google removing the `&num=100` SERP parameter on 12–14 September 2025** — an industry-wide reporting change, not anything that happened to Fenster. Rank-tracking tools had been loading 100 results per page, and every one of those bot page-loads registered as a GSC impression at whatever deep position the site held. When Google killed the parameter, ~88% of all sites lost impressions and average position "improved" overnight, because positions 20–100 stopped being counted for synthetic queries. Fenster's own data carries the fingerprint:

- **Clicks never moved.** Real humans behaved identically before and after. No ranking change occurred.
- **The desktop skew.** Over 16 months: desktop 1.68M impressions at position 32.1 / 0.25% CTR vs mobile 1.03M at position 18.2 / 0.47% CTR. Scrapers emulate desktop; that deep-position desktop pile is largely bot debris from the pre-September era.
- **Position never went back.** Every month since sits at 17–24. The 30s-era numbers were never real.

**"How do we recreate this": we can't and shouldn't try — nothing improved.** No user saw anything different; not one extra click was earned. The lesson it teaches instead:

1. **Never compare GSC data across 12 Sep 2025.** Impressions and average position before that date are inflated/deflated by bots. Any "16-month average" mixing both sides (including the Queries/Pages tables in this very export) understates true positions and overstates true impressions for the early period.
2. **A real spike looks like clicks and CTR rising together at stable impressions.** That is exactly what the last two weeks of this export show (see §3) — small, but genuine.
3. The only chart-level events that matter in this 16-month window are: the num=100 artifact (Sep 2025), the December 2025 seasonal dip (12 clicks/day — nobody buys windows at Christmas), and the launch (5 July 2026, no crash, now trending up).

References: [Search Engine Land data analysis](https://searchengineland.com/google-num100-impact-data-462231), [LOCOMOTIVE Agency](https://locomotive.agency/blog/google-removes-num100-parameter-what-this-means-for-your-website/), [Ice Nine Online explainer](https://icenineonline.com/blog/googles-num100-removal-in-september-2025-why-your-search-console-impressions-dropped-and-rankings-look-better/).

---

## 2. What has been done before (the record, reconciled)

Four documents form the prior body of work; their findings and current status:

| Doc | Date | What it did | Standing |
| --- | --- | --- | --- |
| `SEO-AUDIT.md` | 07 Jul + reconciliations to 13 Jul | Master audit: 9 findings F1–F9, competitor head-to-head (Crown), old-site Yoast forensics, first GSC reality check | All code-side findings **done** (F1 head-term page, F2 areas hub, F3 titles, F4 GBP schema, F9 sweep). Open: F5 local proof, F6 authority (owner), F7 content gaps in part, F8 `srcset` |
| `LAUNCH-WEEK-REPORT.md` | 14 Jul | 154 commits; 681 pages zero-defect; early ranking jumps explained mechanically | Historical record; price guides live 20 Jul |
| `ACTION-PLAN.md` | 16 Jul | Copy rewrite programme, photography accuracy audit, template de-jargoning | Largely executed through late July (git shows the copy/image sweeps: cat flaps rewrite, aluminium sliders, heritage doors, contact, case studies) |
| `HIGH-INTENT-SEARCH-PLAN.md` | 22 Jul | Intent classification of 3-month GSC; live `uule` SERP checks; **GBP verified correctly configured → map pack is a prominence problem, not config**; matrix tiering; Tier-1 suburb content shipped; review link fix; `hasOfferCatalog` schema | The current strategy. Its Tier 0 owner actions (reviews with product names, citations, service-area test, paid-map decision) are the open items |

Summary of the technical position: **the code-side work is complete and verified** — 703 sitemap URLs, unique metadata throughout, LocalBusiness schema wired to the GBP, breadcrumbs/FAQ schema, 0.30s TTFB today, case-study proof rendering on Tier-1 town pages, consent-gated first-party attribution live. What was open on 22 July is still open now, and it is all **owner-held**: review velocity with product names in the text, citations/authority, real job photography, and the conservatories decision. One code item remains parked: responsive images (`srcset`).

---

## 3. Post-launch verdict — first genuine growth signal of 2026

Monthly clicks/day from the daily chart (the only metric safe to read across the whole window):

| Month | Clicks/day | Month | Clicks/day |
| --- | --- | --- | --- |
| 2026-01 | 22.4 | 2026-05 | 14.1 |
| 2026-02 | 21.5 | 2026-06 | 14.2 |
| 2026-03 | 18.7 | **2026-07** | **16.6** |
| 2026-04 | 15.7 | 2026-08 (1d) | 12.0 |

The site declined every month of 2026 until the launch. **July is the first month-on-month increase of the year (+17%)**, and it is accelerating inside the month:

| Window | Clicks/day | Impr/day | Position | CTR |
| --- | --- | --- | --- | --- |
| Pre-launch (1 Jun – 4 Jul) | 14.0 | 4,357 | 23.8 | 0.32% |
| Post-launch weeks 1–2 (5–19 Jul) | 15.5 | 4,364 | 24.0 | 0.36% |
| **Post-launch weeks 3–4 (20 Jul – 3 Aug)** | **18.8** | 4,116 | 22.6 | **0.46%** |

Clicks +34% on pre-launch at flat impressions, with CTR up 44% — this is the real-spike shape §1 describes: more humans clicking the same visibility. It coincides with the 20–22 July wave (price guides live, striking-distance retitles, suburb local-substance sections, review showcase on live Google data, informational next-steps blocks). Two weeks is a small sample; it is a signal, not a verdict. The 22 July plan's target — doubling 49 local-commercial clicks/quarter — is the number that decides it, at the next monthly export.

---

## 4. What the 16-month query/page data says (read with the §1 caveat)

The aggregate tables mix 5 bot-inflated months with 11 clean ones, so treat impressions as ceilings and positions as pessimistic. Even so:

### 4.1 Intent mix is unchanged — the business problem is still local visibility

Top-1000 queries classified: brand 1,029 clicks (8.3% CTR, pos 10), informational 1,014 clicks (dominated by the lintel cluster: `/what-is-a-door-lintel/` alone 3,010 clicks / 542k impressions), product-no-location 739 clicks at 0.12% CTR, **local commercial just 462 clicks in 16 months** at position ~19. Nearly half of all impressions (45%) and 42% of clicks are non-UK, almost all informational. The site's traffic engine is still an international blog article; its revenue engine is 5% of clicks.

### 4.2 The striking-distance cluster is intact and still the prize

Everything from the July plans still sits at positions 7–19 with real impression volume (16-month figures): double glazing MK 10,039 impr @ 11.2 · double glazed windows MK 5,515 @ 15.8 · uPVC windows MK 4,955 @ 12.8 · composite doors MK 3,849 @ 11.5 · front doors MK 3,509 @ 10.2 · aluminium windows MK 2,935 @ 11.0 · bifolds MK 2,562 @ 7.3 · window repair MK 2,367 @ 12.8 · uPVC doors MK 1,523 @ 6.9 · doors MK 1,442 @ 9.6. The July retitles targeted exactly these; their post-launch spot positions (launch-week checks had several at 4–9) will only show cleanly in a post-launch-filtered export.

### 4.3 Won rankings that earn nothing — the cheapest wins available

Queries at position ≤10 with high impressions and ~zero clicks:

| Query | Impr | Pos | Clicks | Diagnosis |
| --- | --- | --- | --- | --- |
| roof lights northampton | 3,170 | 6.7 | 0 | Known since 07-07: pages never say "roof lights"; synonym was added to titles — verify it's in on-page copy and H2s too |
| roof lights milton keynes | 1,230 | 1.8 | 0 | Position 1.8, zero clicks. Some is pre-Sept bot noise, but check the live snippet for this query |
| commercial window installation/installers/contractors/replacement (cluster) | ~9,800 | 4–10 | ~4 | The commercial hub ranks and gets no clicks; SERP is dominated by directories/national firms. Snippet/title angle needed ("Commercial glazing, Milton Keynes, in-house fitters") |
| dog flap for upvc door | 1,710 | 5.0 | 0 | Cat-flap page just got a full rewrite (late July) — watch whether this fixes itself |
| casement french window | 1,761 | 1.9 | 0 | Likely SERP-feature cannibalised (image pack/AI overview); low priority |
| double glazing in milton keynes | 1,548 | 9.7 | 0 | Same intent as the head term; should resolve as the flagship page settles |

### 4.4 The suburb matrix has produced nothing measurable yet — hold, don't expand

Sample: every `-bletchley` page has ≤21 impressions in this export; `/areas-we-cover/` has 2. The 260 suburb pages are four weeks old and Google is indexing but not promoting them. This is expected at week 4 and the 22 July decision stands: no more matrix expansion; the only lever that moves these is real proof (photos, named local jobs, reviews) on Tier-1 pages plus GBP/authority growth. Judge them at the October export, not now.

### 4.5 The flagship head-term page

`/double-glazing-milton-keynes/` 16-month aggregate: 11 clicks, 22,407 impressions, position 23.5 — but this mixes its pre-rebuild history and the mid-July churn window. The 22 July live check had the organic position at 16.1 with the map-pack slot at #3 carrying the query. Nothing new to do on-page; this is now a settle-and-watch item with the authority programme behind it.

### 4.6 Search appearance

Review snippets: 808 clicks / 507k impressions at position 39 over 16 months — mostly the old site's (removed) fake `aggregateRating` era plus bot-depth impressions. The 22 July decision not to re-add self-serving `aggregateRating` remains correct; stars must come from third-party profiles (Trustpilot/Checkatrade presence = F6 citations work). Translated results (269 clicks) are the international lintel audience — harmless, ignore.

---

## 5. The plan from here (folds the 22 July plan forward — nothing in this data contradicts it)

**Owner (all of it is still the long pole, unchanged):**
1. Review velocity toward 200+ with product names in the text; ask every completed install; case-study customers first.
2. Citations: Bing Places, Apple Business Connect, supplier installer-finders (Liniar/Sheerline/Roseview/Distinction), FENSA/CPA profile links, MK directories.
3. Job photography pipeline (5-shot checklist per install) → feeds case studies → feeds Tier-1 suburb pages.
4. Decide: conservatories/porches (concede or contest), paid map placement, service-area trim test.

**Code/content (small queue, in order):**
1. Verify "roof lights" appears in on-page copy/H2s on the roof-lantern pages, not only titles (§4.3 — Northampton + MK, ~4,400 impressions waiting).
2. Commercial hub snippet pass: retitle/re-describe against the directory-dominated SERP (§4.3 — ~10k impressions, 4 clicks).
3. Responsive images (`srcset`) + PSI re-test — the last parked performance item, and it serves the mobile majority.
4. Nothing else. Do not touch the matrix, the flagship page, or the titles shipped on 22 July until the September export.

**Measurement discipline:**
- Re-export GSC monthly, **filtered to post-2026-07-05 date ranges** for the new site, and UK-only when judging local performance. Never quote a number that spans 12 Sep 2025.
- Headline KPI stays: **local commercial clicks/quarter** (baseline 49). Secondary: map-pack presence (monthly `uule` checks, baseline 1 of 3), Google review count (baseline 133), clicks/day (July baseline 16.6).

---

## 6. Honest outlook

The launch protected everything (no migration crash), and weeks 3–4 show the first genuine growth of 2026 — clicks +34% on pre-launch at flat impressions. The technical layer needs no further investment; every remaining lever is proof, authority and patience, exactly as the 22 July plan concluded. The September 2025 "spike" the export shows was a measurement artifact the whole industry experienced; the only spike worth chasing is the one already faintly visible in the last two weeks of this export, and it is made of reviews, photographs and citations, not code.
