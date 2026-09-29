# Fenster Glazing — SEO Master Audit, 28 September 2026

Date: 2026-09-28. New site live since **5 July 2026** (12 weeks).

Sources, all read or measured today:

- **Six Google Search Console exports** (Web search), pulled by the owner: last 16 months all countries / UK / UK excluding "fenster"; last 3 months all countries / UK / UK excluding "fenster". Charts run to **25 September 2026**. Also re-read from Downloads: the 2 September July-vs-August comparison export and the 2 September post-launch UK export.
- **Rank tracker**, desktop, Milton Keynes localised, 100 keywords, 28 September, diffed line by line against the 2 September export.
- **Raw access logs from the live server**, 29 August to 28 September (30 days, 397,354 lines; the server keeps 30 days).
- **Marketing Dashboard D1**: every website journey since 13 July and the lead events inside it.
- **Live WordPress database**: enquiry records per week and their source field (counts only).
- **A full crawl of live**: all 737 sitemap URLs, every internal link found on them, and 822 URLs Search Console has shown impressions for.
- **Lighthouse 12** (mobile, simulated slow 4G) on seven representative pages. PageSpeed Insights refused: keyless daily quota exhausted, as in July.
- **Live Google results** for three head terms, searched as if from Milton Keynes (`uule`), and compared with the 22 July checks in `HIGH-INTENT-SEARCH-PLAN.md`.

Reads alongside `SEO-AUDIT.md` (7 Jul), `SEO-AUDIT-AUG-2026.md` (3 Aug), `SEO-LEAD-AUDIT-2026-08-05.md`, `SEO-PERFORMANCE-AUDIT-2026-08-17.md` and the 14 September landing-page note that lives only on `origin/codex/seo-live-release-2026-09` (§13). Where this document contradicts one of them, it says so and shows the evidence.

---

## 0. The short version

1. **September is the best month for organic search in the 16 months the data covers.** 26.1 clicks/day worldwide and **20.0/day from the UK**, against 10.4 UK in June. On the only clean year-on-year window (14–25 September, both sides after Google's September 2025 reporting change), UK clicks are **+92%**, UK impressions **+39%**, and average UK position has moved from 23.1 to 19.6. This is no longer only a CTR story: rankings and impressions are now moving too.
2. **The measure adopted on 17 August undercounts non-brand search about five-fold.** Filtering Search Console to queries without "fenster" also silently drops every *anonymised* query, which is **58.5% of UK clicks**. The filtered export shows 205 UK non-brand clicks in the last quarter; the real figure is about **1,067**. §2 replaces the KPI.
3. **Google organic is the largest attributable lead source on the site.** 54 leads from 1,278 consented Google journeys since 13 July (4.2%), rising month on month (4 in the last half of July, 23 in August, 27 in September to date).
4. **The town pages, written off in August as an "impression-only asset", convert best of anything on the site.** Visitors landing on a town page from Google became leads at **10.6%**, against 4.2% for product pages and 0.5% for articles. Nine leads, from pages like `/french-doors-leighton-buzzard/` and `/roof-lanterns-northampton/`.
5. **The map pack held, and for the first time the site is in the pack and on page one for the same term.** "Double glazing milton keynes": 2nd in the pack (3rd on 22 July), and `/windows-milton-keynes/` 9th organically (absent in July). Still absent from both for "windows milton keynes" and "composite doors milton keynes", where firms with **4 and 6 reviews** now hold pack places.
6. **The flagship head-term page was flattened into a town page on 15 September**, and Google has chosen a different page anyway. `/double-glazing-milton-keynes/` is now **85–87% word-for-word identical** to the Aylesbury, Bedford and Bletchley double-glazing pages, carries 24 internal links against 153 for `/windows-milton-keynes/`, and sits at position 40 while the windows hub takes the query. §5 asks for a decision.
7. **The whole content library is cut off from the site.** Nothing links to `/blog/`. None of the 37 older articles (lintel, soundproofing, frame materials — with the new posts, **27.5% of real Google visits**) has a single internal link, header and footer included. The nine weekly posts are linked only from `/blog/`. Result, measured: **Googlebot has not fetched 7 of the 9 new posts in 30 days, and the 31 August and 7 September posts have never been crawled or shown.** Bing, meanwhile, crawled all of them.
8. **The town-page matrix is 71% of the site and 84% duplicate.** 526 pages, same product across different towns sharing 84% of their text on average. Googlebot fetched only 224 of them in 30 days, and 91 have had no impressions at all in three months. This is the site's biggest quality risk and, per point 4, also a real lead source. §7 says how to hold both.
9. **Page speed has not moved since July.** Mobile Lighthouse 33–63, LCP 14–29 seconds on six of seven pages. The 2 MB Legend cat spritesheet — the top code item on 17 August — is still loaded eagerly on all 737 pages and is **61% of the homepage's weight**. `/composite-doors/` has regressed from 73 responsive images to 3.
10. **The SEO release Google is now indexing is not in `main`.** Live runs the unmerged `codex/seo-live-release-2026-09` version of 18 theme files, including the town-page template and data. A routine deploy of any of them from `main` reverts the 15 September release. §13.
11. **Three measurement traps found and closed**: **79%** of Google-referred page hits in the access log are not visits, and nine in ten of those are Chrome's search-result prefetching; the rank tracker contradicted two of three live checks by 20–30 places; and August's "Hitchin is the best town" came from one query whose 140 impressions all predate 26 June.

---

## 1. Search performance

### 1.1 Month by month

Clicks per day from the daily charts. Positions are impression-weighted. September 2025 and earlier carry the pre-12-September-2025 `num=100` inflation on impressions and position (see `SEO-AUDIT-AUG-2026.md` §1); clicks are safe across the whole window.

| Month | All countries | UK | UK named non-brand | UK position |
| --- | ---: | ---: | ---: | ---: |
| 2025-10 | 20.4 | 12.0 | 2.8 | 26.7 |
| 2025-11 | 18.4 | 11.2 | 2.3 | 24.7 |
| 2025-12 | 12.0 | 7.0 | 0.7 | 27.6 |
| 2026-01 | 22.4 | 11.8 | 1.5 | 26.9 |
| 2026-02 | 21.5 | 13.5 | 2.4 | 24.6 |
| 2026-03 | 18.7 | 11.8 | 2.4 | 21.1 |
| 2026-04 | 15.7 | 9.7 | 1.7 | 24.5 |
| 2026-05 | 14.1 | 9.1 | 1.7 | 26.4 |
| 2026-06 | 14.2 | 10.4 | 1.6 | 26.9 |
| 2026-07 (launch 5th) | 16.6 | 12.6 | 2.1 | 26.8 |
| 2026-08 | 21.7 | 17.2 | 2.3 | 25.1 |
| **2026-09 (1–25)** | **26.1** | **20.0** | **2.6** | **20.3** |

Worldwide, September beats every full month in the window (previous best January, 22.4). For the UK it is not close: the previous best month was February at 13.5.

"UK named non-brand" is the column the 17 August audit proposed as the KPI. It barely moves, and §2.1 explains why that is a property of the filter, not of the site.

### 1.2 Year on year, on the one clean comparison

Google removed the `num=100` parameter on 12–13 September 2025; the export shows impressions halving overnight on the 13th. So the only window that can be compared year on year without that distortion is **14–25 September**:

| 14–25 September | 2025 | 2026 | Change |
| --- | ---: | ---: | ---: |
| Clicks/day, all countries | 20.6 | 28.6 | **+39%** |
| Clicks/day, UK | 11.6 | 22.3 | **+92%** |
| Impressions/day, UK | 2,436 | 3,377 | **+39%** |
| CTR, UK | 0.48% | 0.66% | +38% |
| Average position, UK | 23.1 | 19.6 | 3.5 places better |
| UK named non-brand clicks/day | 2.1 | 2.8 | +32% |

### 1.3 Since launch

| UK | Pre-launch 1 Jun–4 Jul | 5 Jul–15 Aug | 16 Aug–4 Sep | 10–25 Sep |
| --- | ---: | ---: | ---: | ---: |
| Clicks/day | 10.1 | 13.6 | 20.0 | **20.5** |
| Impressions/day | 2,950 | 2,995 | 3,670 | 3,303 |
| CTR | 0.34% | 0.45% | 0.54% | **0.62%** |
| Average position | 27.0 | 26.4 | 23.6 | **19.7** |

The five days Homepage 3.0 was live (5–9 September) are left out: 18.8 UK clicks/day, which is within the run of the weeks either side.

Weekly UK clicks/day since launch: 11.7, 12.4, 15.9, 12.3, 13.0, 16.0, **19.6, 21.7**, 17.0, 19.1, 18.6, **24.8** (week of 20 September, six days). The step up happened in the week of 16 August and has held.

**The shape has changed since August.** The 5 and 17 August audits measured a pure CTR gain on flat impressions and called it a titles-and-metadata win. That was right then. Since mid-August impressions are up 12–24% on pre-launch and average position has improved by more than seven places. The site is now being *shown* more, not just clicked more.

### 1.4 Where the growth sits

UK clicks split three ways. Brand is every query containing "fenster" (or a misspelling) in the UK query table; named non-brand is the "-fenster" export; anonymised is the remainder of the UK chart total (method in §2.1).

| UK clicks/day | Old site, 26 May 2025–25 Jun 2026 | 5 Jul–31 Aug | 1–25 Sep (estimate) |
| --- | ---: | ---: | ---: |
| Brand (named "fenster" queries) | 2.0 | 4.2 | ~5.8 |
| Named non-brand | 2.1 | 2.2 | 2.6 |
| Anonymised (almost entirely non-brand long tail) | 6.9 | 8.9 | ~11.7 |
| **Total** | 11.0 | 15.3 | 20.0 |
| **Non-brand, true (named + anonymised)** | **9.0** | **11.1** | **~14.3** |

Brand searches have nearly trebled. Nothing in these files says why; the likely contributors are the map-pack presence, paid search and social campaigns, and vans and word of mouth, none of which Search Console can separate. **True non-brand is up about 60% on the old site's average**, and it is the anonymised long tail that carries it.

### 1.5 Which kinds of page gained

All-country page table (the only page table that keeps anonymised clicks, §2.2), clicks per day:

| Page type | Old-site period | Last 3 months | Change |
| --- | ---: | ---: | ---: |
| Brand and company pages (mostly `/`) | 3.75 | 6.93 | +85% |
| Product and service pages | 2.09 | 3.48 | **+67%** |
| Quote, price guides, visualiser | 1.21 | 2.01 | +66% |
| Town pages | 1.30 | 1.22 | −6% |
| Milton Keynes hubs | 0.55 | 0.49 | −11% |
| Commercial hubs | 0.47 | 0.33 | −30% |
| Commercial county pages | 0.01 | 0.23 | new |
| Articles and blog (the 46 live ones) | 8.03 | 6.21 | **−23%** |
| Old article URLs, now redirected | 1.23 | 0.05 | retired |

The product pages are the real non-brand winner. Articles are down by about a quarter; that is mostly the lintel article's overseas audience (non-UK clicks ran at 7–10/day through autumn 2025 and 4–6/day since June), consistent with AI Overviews answering definitional questions. It does not touch leads (§3).

### 1.6 Devices and countries

UK, last three months: mobile 762 clicks at 0.79% CTR and position 17.6; desktop 654 at 0.33% and position 27.7. Desktop's position is dragged down by rank-checking tools, which emulate desktop (§4.4). In the access log, **54.7% of real visitors from Google are on mobile**. The UK is 77% of clicks (1,474 of 1,912); the US, India, Canada and South Africa make up most of the rest, all informational.

Search appearance: review snippets fell from 7,716 impressions in July to 76 in August and are effectively gone. That is the old site's self-serving `aggregateRating` falling out of the index, and the decision not to re-add it stands.

---

## 2. Five corrections to how this site's search is measured

### 2.1 58.5% of UK clicks are anonymised, and the "-fenster" filter deletes them

Search Console withholds rare queries ("anonymised queries") from its query tables. The chart total still counts them, **unless a query filter is applied**, in which case they are dropped from the chart too, because Google cannot tell whether they match.

For the last three months, UK:

| | Clicks | Share |
| --- | ---: | ---: |
| UK chart total | 1,474 | 100% |
| Brand, named in the query table | 407 | 27.6% |
| Non-brand, named (= the "-fenster" chart) | 205 | 13.9% |
| **Anonymised (the remainder)** | **862** | **58.5%** |

Over 16 months the anonymised share is 61.7%. For a local installer this is expected: "french doors leighton buzzard" is exactly the kind of query Google anonymises. Brand queries are high-volume and therefore named, so the anonymised pool is overwhelmingly non-brand.

**Consequence:** the KPI the 17 August audit set in §11.2 — "UK non-brand clicks" from a "-fenster" export — measures one seventh of UK clicks and misses the part that is growing. The 14 September note built its whole comparison on that export. Its direction was right (non-brand is up); its level is about five times too low.

**Replacement:** `UK non-brand = UK chart total − UK brand-named clicks`. Both numbers are in the ordinary UK export; no filter needed.

### 2.2 UK-filtered page tables drop the same clicks; the all-country page table keeps them

| Export | Chart clicks | Page-table clicks | Page table as % of chart |
| --- | ---: | ---: | ---: |
| All countries, 16 months | 9,312 | 9,395 | 101% |
| All countries, 3 months | 1,912 | 1,939 | 101% |
| UK, 16 months | 5,828 | 2,270 | **39%** |
| UK, 3 months | 1,474 | 627 | **43%** |

Once a country filter is on, the page table only carries named-query clicks. **Page-level analysis must use the all-country page table.** For local commercial pages the difference between "all countries" and "UK" is negligible; for articles it is not, so treat article rows as worldwide.

### 2.3 79% of Google-referred hits in the access log are not visits

The access log records 4,088 page requests in 30 days that arrive with a Google referrer, no ad parameters and a browser user agent — 136 a day, five times Search Console's 26 clicks a day. **3,228 of them never load a stylesheet, script or image, and 2,973 of those come from Chrome's prefetch proxy**, confirmed against the IP list Google publishes (`gstatic.com/chrome/prefetchproxy/prefetch_proxy_geofeed`). Chrome fetches top results in the background before anyone clicks.

Requiring the visitor to load a theme asset within two minutes of the page leaves **808 real landings in 30 days (26.9/day)**, against Search Console's 25.6 clicks/day for the same weeks. That agreement is the validation.

**Any count of "Google visitors" taken from the raw log without that test is inflated about five-fold**, and the lintel article, which ranks in the top ten for a large query, is inflated most (1,644 prefetches against 72 real visits). The dashboard is not affected, because prefetches do not run JavaScript.

### 2.4 The rank tracker failed two of three live checks

| Term | Tracker 28 Sep | Search Console, UK average | Live Google from MK |
| --- | ---: | ---: | --- |
| double glazing milton keynes | 10 | 11.1 | 9th organic, 2nd in pack ✅ |
| composite doors milton keynes | 4 | 7.1 | **not in the top 10** |
| windows milton keynes | **2** | **33.7** | **not in the top 10** |

This is the third audit running to find single tracker rows contradicted. Read it only as a whole (§4.3).

### 2.5 Hitchin was never a market

The 17 August audit called Hitchin "the site's best town by a distance", on the strength of `bifold door installation hitchin`: 32 clicks from 140 impressions, 23% CTR. **All 140 of those impressions fall before 26 June; the query has had none since.** A handful of people searching the same phrase repeatedly produced a CTR no market produces. Hitchin is an ordinary ring town. Do not plan anything on it.

### 2.6 The measurement set from here

| Measure | How | Now |
| --- | --- | --- |
| **UK non-brand clicks/day** | UK chart − UK brand-named | ~14.3/day in September (old site 9.0) |
| **Organic leads per month** | D1 journeys with a Google referrer containing a quote completion or form submission | Aug 23 · Sep 27 |
| Human Google landings by page type | Access log, asset-load test (Appendix A) | 26.9/day |
| Map pack + page one, three MK terms | `uule` search, monthly | pack 1 of 3; both at once 1 of 3 |
| Google reviews | GBP | 139 |
| New-post crawl | Googlebot fetches of each new post in the log | 2 of 9 in 30 days |

Retire: "-fenster" filtered totals, impressions and CTR for anything town-shaped, single tracker rows.

---

## 3. What organic search produces: leads

### 3.1 Enquiries since launch

Enquiry records in the live database per week (Monday start). Before 24 September some WindowCAD records were the office's "Print to CRM", so treat these as a ceiling.

| Week | 6 Jul | 13 Jul | 20 Jul | 27 Jul | 3 Aug | 10 Aug | 17 Aug | 24 Aug | 31 Aug | 7 Sep | 14 Sep | 21 Sep |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Enquiries | 30 | 15 | 14 | 12 | 21 | 19 | 14 | 31 | 28 | 29 | 33 | 24 |

Enquiries recovered to 24–33 a week after Homepage 3.0 was switched off on 9 September.

### 3.2 Leads by channel

Consented journeys only, 13 July to 28 September. About half of the enquiry records in that period can be tied to a journey (126 of 241), so these are proportions, not totals. Part of the gap was found later the same day: when a crawler refills a page's cache, the next hour's visitors get a copy with all tracking off, which hit **14.5% of real page views and 18.6% of real Google landings** in the last 30 days (`LIVECHANGES.md`, 28 September). Pages differ, so treat per-page comparisons with that in mind.

| Channel | Journeys | Leads | Rate |
| --- | ---: | ---: | ---: |
| **Google organic** | **1,278** | **54** | **4.2%** |
| Direct / no referrer | 4,603 | 33 | 0.7% |
| Own site (self-referral) | 404 | 17 | 4.2% |
| Bing | 55 | 6 | 10.9% |
| AI assistants (ChatGPT, Gemini) | 43 | 5 | 11.6% |
| Google Ads | 94 | 4 | 4.3% |
| Meta ads | 137 | 3 | 2.2% |
| Other search, social, referral | 173 | 4 | 2.3% |

Google organic is 43% of attributable leads. Organic leads by month: 4 (13–31 July), **23** (August), **27** (September to the 28th).

### 3.3 Organic leads by the page people landed on

| Landing page type | Journeys | Leads | Rate | Share of organic leads |
| --- | ---: | ---: | ---: | ---: |
| Brand and company (mostly the homepage) | 380 | 23 | 6.1% | 43% |
| **Town pages** | **85** | **9** | **10.6%** | 17% |
| Quote and price pages | 108 | 10 | 9.3% | 19% |
| Product pages | 236 | 10 | 4.2% | 19% |
| Articles and blog | 406 | 2 | 0.5% | 4% |
| Commercial hubs and county pages | 34 | 0 | — | — |
| Milton Keynes hubs | 21 | 0 | — | — |
| Case studies | 8 | 0 | — | — |

Inside those rows: `/online-quote/` 51 journeys → 10 leads; `/3d-visualiser/` 54 → **0**; `/what-is-a-door-lintel/` 128 → 0; `/secondary-glazing/` 7 → 3; `/window-and-door-repairs/` 30 → 2 (forms, as the repair rule requires); the first seasonal post, `/why-bifold-doors-stick-in-hot-weather/`, 8 → 1.

The nine town-page leads came from `composite-doors-stevenage`, `slide-fold-doors-luton`, `integral-blinds-northampton`, `integral-blinds-aylesbury`, `aluminium-sliding-doors-flitwick`, `bow-bay-windows-woburn-sands`, `french-doors-leighton-buzzard`, `flush-casement-windows-leighton-buzzard` and `roof-lanterns-northampton`.

### 3.4 What this overturns

- **"The town matrix is an impression-only asset"** (`SEO-LEAD-AUDIT-2026-08-05.md` F3; `SEO-PERFORMANCE-AUDIT-2026-08-17.md` §3). Wrong on the evidence now available. Town pages bring very few visitors — 39 real Google landings in 30 days across 35 different pages — but those visitors arrive having searched "product + town" and buy at the highest rate on the site. Nine leads is a small number; it is also more than the commercial pages, the MK hubs and the entire article library combined.
- **The visualiser still converts nobody.** Third audit, same result, now on 54 organic journeys. It has no internal links in at all (§6), so the few who find it arrive from search, look and leave.
- **Articles bring traffic, not buyers**, with one exception: fault posts. The bifold post converted 1 of 8; the other 398 article journeys produced one lead between them. The 17 August addendum was right to separate the two.

---

## 4. The results page, as a searcher in Milton Keynes sees it

### 4.1 Three head terms, 28 September against 22 July

| Term | Map pack 22 Jul | Map pack 28 Sep | Organic page one 22 Jul | Organic page one 28 Sep |
| --- | --- | --- | --- | --- |
| double glazing milton keynes | ✅ 3rd | ✅ **2nd** — Gallaghers (177), **Fenster (139)**, Elements (92) | ❌ | ✅ **9th**, `/windows-milton-keynes/` |
| composite doors milton keynes | ❌ | ❌ Elements (92), Gallaghers (177), **Vision (6 reviews, 3.7★)** | ✅ ~9th | ❌ not in top 10 |
| windows milton keynes | ❌ | ❌ Elements (92), Gallaghers (177), **Crown (4 reviews)** | ❌ | ❌ |

The 22 July plan noted "you are never in both places at once on any term". On the biggest term, that is no longer true.

The packs Fenster misses now contain businesses with 4 and 6 reviews, so review volume alone does not decide them. What the pack does show is Google quoting review text that names the product: *"Just had a new front door installed"* (Elements, composite doors), *"They fit me some brand new uPVC windows"* (Crown, windows). The 22 July plan's advice — ask customers to name what was fitted — is now visibly how the pack justifies its picks.

### 4.2 Reviews

99 on 7 July, 133 on 22 July, **139 on 28 September**: six in ten weeks after a burst of 34 in two. The July push worked; the habit did not stick. The GBP itself was verified as correctly configured on 22 July and nothing here suggests re-opening that.

### 4.3 Rank tracker, read as a whole

| Band | 2 Sep | 28 Sep |
| --- | ---: | ---: |
| 1–3 | 28 | **34** |
| 4–10 | 32 | 29 |
| 11–20 | 12 | 14 |
| 21–50 | 9 | 5 |
| Not ranking | 19 | 18 |

25 up, 24 down, 31 unchanged; median position 6 → 4. The useful signal is in the **URL column: thirteen keywords changed ranking page, most of them to the right one** — `double glazing woburn sands` from a commercial case study to `/double-glazing-woburn-sands/`, `double glazing wolverton` to the Wolverton page, `commercial glazing buckinghamshire` from `/secondary-glazing/` to the county page, `integral blinds` from the article to the product page, `misted double glazing milton keynes` from repairs to replacement glass. That is Google absorbing the 15 September landing-page release. Three moved the wrong way, to the homepage: `doors milton keynes`, `windows bletchley`, `double glazing bletchley`. Lost: `double glazing bedford` (15 → not ranking). Gained: `double glazing northampton` (17), `french casement windows` (22).

Still ranking the wrong page: `upvc doors milton keynes`, `bay windows milton keynes` and `replacement glass milton keynes` all return `/windows-milton-keynes/` rather than `/upvc-doors/`, `/bow-bay-windows/` and `/double-glazing-replacement/`.

### 4.4 Striking distance, and the noise to ignore

UK, post-launch quarter, commercial queries at positions 4–20 with the most impressions: `double glazing milton keynes` (1,567 impressions, 11.1), `french casement windows` (1,422, 13.5), `commercial glazing contractors` (890, 12.7 — up from 38.7), `heritage aluminium windows` (885, 16.2), `composite doors northampton` (708, 14.6), `front doors milton keynes` (608, 8.3), `upvc windows milton keynes` (563, **5.6**, from 14.4), `aluminium windows milton keynes` (403, **4.7**, from 13.0), `replacement windows milton keynes` (540, 16.2).

Ignore: 51 non-brand queries sit in the top five with zero clicks (5,801 impressions), including both word orders of the same Northampton phrases and the typo `tild and turn windows northampton`. That is rank-checking software, exactly as the 17 August audit described, and it is the same list. Do not optimise for it.

---

## 5. The flagship page was flattened, and Google picked the other one

`/double-glazing-milton-keynes/` was the July F1 deliverable: a dedicated head-term page, recorded on 13 July at "~4,300 words" with fourteen real content sections.

Today it renders **2,278 words in nine sections**, with the same heading sequence as every town page ("Ask about double glazing in Milton Keynes", "A clear process from first quote to aftercare", "Buying double glazing in Milton Keynes", "What our customers say", "Product guides and local services"). Measured on five-word sequences, it is **85.2% identical to `/double-glazing-aylesbury/` and `/double-glazing-bedford/`, and 86.7% to `/double-glazing-bletchley/`**. The 23 September live-log entry records why: the 15 September SEO release rebuilt it on the shared template, and its "Choose the product family first" marker survives only in `main`.

Meanwhile the site tells Google, in every way available, that a different page is the double-glazing page:

| | `/double-glazing-milton-keynes/` | `/windows-milton-keynes/` |
| --- | --- | --- |
| Pages linking to it from content | 24 | **153** |
| Most-used anchor | "Double Glazing Milton Keynes" (22) | **"Double Glazed Windows Milton Keynes" (37)** |
| H1 | Double glazing in Milton Keynes | **Double glazed windows in Milton Keynes** |
| Search Console, last 3 months | 5 clicks, 3,530 impressions, position 40.4 | 20 clicks, 11,952 impressions, position 21.2 |
| What Google shows for the head term | — | **this page, 9th organic** |

July's F1 note said: watch for 4–6 weeks, and if Google keeps choosing the other URL, consolidate. It has been twelve weeks, and Google has chosen.

**Owner decision, one of two, and not neither:**

- **(A) Consolidate — recommended.** 301 `/double-glazing-milton-keynes/` to `/windows-milton-keynes/`, give the windows hub the head-term title, and keep its product role. Google already ranks it; this stops two pages splitting one query and hands it the other page's links. Cheap and reversible.
- **(B) Restore.** Rebuild `/double-glazing-milton-keynes/` as a genuinely distinct flagship (July depth, Milton Keynes installs, proof), and move the 37 "Double Glazed Windows Milton Keynes" anchors to it. Costlier and slower; only worth it if the owner wants that URL specifically.

Leaving it as it is — two pages on one query, one of them a town-template copy — is the current state, and the current state is position 40.

---

## 6. The content library is cut off from the site

### 6.1 No links in

From the crawl of all 737 pages, counting every link on every page, header and footer included:

| Page | Pages linking to it |
| --- | ---: |
| `/blog/` | **0** |
| `/3d-visualiser/` | **0** |
| `/what-is-a-door-lintel/` and the other 36 older articles | **0** each |
| Each of the nine new weekly posts | 1 (from `/blog/` only) |

The header has 110 links and the footer 35; neither has a "Guides", "Blog" or "Advice" entry. `/blog/` lists only the nine new posts and never the 37 older articles. The only way a crawler reaches any of it is the sitemap, which has no `<lastmod>` on any URL.

These pages are not marginal: **222 of 808 real Google landings in the last 30 days (27.5%) were on these 46 pages**, and 571 clicks in the last three months (29% of all page clicks). The fault posts are the only ones that convert.

### 6.2 What it costs, measured

Googlebot page fetches in the 30-day log:

| Post | Published | Googlebot fetches, 30 days | Search Console, 3 months |
| --- | --- | ---: | --- |
| Why bifold doors stick in hot weather | 3 Aug | 0 | 9 clicks, 203 impressions, pos 7.4 · **1 lead** |
| Do roof lanterns make a room too hot? | 10 Aug | 0 | 3 clicks, 392 impressions |
| Condensation on the outside of windows | 17 Aug | 0 | 5 clicks, 1,757 impressions, pos 10.5 |
| Draughty windows: repair or replace? | 24 Aug | 0 | 2 clicks, 51 impressions |
| **Misted double glazing: why windows go cloudy** | 31 Aug | **0** | **nothing — not indexed** |
| **Winter-ready window and door checklist** | 7 Sep | **0** | **nothing — not indexed** |
| How window replacement actually works | 14 Sep | fetched | 7 impressions |
| New front door before winter | 21 Sep | fetched | 5 impressions |
| Trickle vents explained | 28 Sep | 0 | — |

The early posts rank well once found (7.4, 10.5). The problem is being found. The misted-glass post is squarely a replacement-glass lead generator and has not been seen by Google at all.

### 6.3 Bing and the AI crawlers found them anyway

Bing fetched the condensation post 23 times, the bifold post 18, the misted post 11, the winter checklist 8. Bing reads the sitemap aggressively; Google weighs internal links. So this is not a technical block — it is Google's crawler reading the site's own signals about what matters, and concluding the articles do not.

### 6.4 The fix

1. A **"Guides"** entry in the header and footer pointing at `/blog/`.
2. `/blog/` lists **every** article, the 37 older ones included, grouped by topic (faults and repairs; glass and energy; doors; windows; buying).
3. Two or three contextual links from each product page to its own guides: repairs → the fault posts; replacement glass → misted glass and condensation; secondary glazing → soundproofing; composite doors → the front-door posts.
4. `BlogPosting` schema with `datePublished`, `dateModified` and author on every article. None carries article schema today; the 35 pages that do are the case studies.
5. `<lastmod>` in `page-sitemap.xml` (and an index `lastmod` that is not simply the request time).

**Verify with the log**: Googlebot fetches of each new post inside a week of publishing, and Search Console impressions for the misted-glass and winter posts within a fortnight.

---

## 7. The town matrix: the best-converting pages on the site, and its largest risk

| | |
| --- | --- |
| Town pages in the sitemap | **526 of 737 (71%)** |
| Same product, different town: shared text | **84.3% average** (72–92%, 420 pairs across 60 pages) |
| Example | `/composite-doors-aylesbury/` vs `/composite-doors-bedford/`: only 50 of Aylesbury's 1,207 five-word sequences are not also on the Bedford page |
| With Search Console impressions, last 3 months | 435 |
| With at least one click | 69 (111 clicks) |
| With no impressions at all | **91** |
| Real Google landings, 30-day log | 39, on 35 different pages |
| Fetched by Googlebot in 30 days | **224 of 526** |
| Organic leads since July | **9, at 10.6%** |

Google's doorway policy lists "pages targeted at specific regions or cities that funnel users to one page" and "substantially similar pages" among its examples, and Google has said its helpfulness signals are assessed at site level as well as page by page. These pages each carry their own enquiry form, so they are not pure funnels, but the similarity is exactly the pattern the policy describes. Google is already rationing its attention: it left 302 of them unfetched for a month. At 71% of the site, the matrix is the largest single influence on how Google judges Fenster's quality.

It is also, per §3, where the most purchase-ready visitors land. Both are true, so neither "expand it" nor "delete it" is the answer:

1. **Freeze.** No new town or product combinations. (Unchanged since 22 July.)
2. **Differentiate what earns.** The towns that have produced leads or clicks — Leighton Buzzard, Stevenage, Northampton, Aylesbury, Letchworth, Dunstable, Luton, Flitwick, Woburn Sands — get the proof the rest cannot have: that town's case studies, photographs and reviews. The case-study system already attaches studies to pages by product and town; it needs more real jobs feeding it.
3. **Decide on the dead weight.** The 91 town pages with no impressions at all in three months have nothing to lose. Owner decision: `noindex` them (reversible, keeps them for visitors) and re-test in a quarter.

---

## 8. Technical health

### 8.1 Still clean

| Check | Result |
| --- | --- |
| Sitemap URLs returning 200 | **737 / 737** |
| Missing or duplicate titles / descriptions | **0 / 0** |
| Descriptions over 160 characters | 0 |
| Canonicals | 737 self-referencing |
| H1 | exactly one on every page |
| `aggregateRating` / `Review` schema | 0 pages (correct) |
| `og:image` | 737 / 737 |
| JSON-LD | valid everywhere; `FAQPage` on 628, `BreadcrumbList` on 736 |
| Server response | median **0.23 s**, even on a cache miss |
| http → https, www → apex | 301 |
| Lighthouse SEO category | 100 on all seven pages tested |

### 8.2 Defects

| # | Defect | Evidence | Fix |
| --- | --- | --- | --- |
| 1 | Content library unlinked | §6 | §6.4 |
| 2 | **Three legacy routes indexable, outside the sitemap** | `/double-glazing-northamptonshire/` (11,626 impressions in 16 months), `/double-glazing-buckinghamshire/` (1,661 in the last 3), `/commercial-glazing-milton-keynes/` — old copy ("in across Northamptonshire areas"), "What Milton Keynes homeowners say" on a county page, and the **instant quote tool on a commercial page**, against the commercial routing rule | 301 to `/double-glazing-northampton/`, `/areas-we-cover/`, `/commercial-glazing/` |
| 3 | `/wcad-thank-you/` indexable | Rank Math "index, follow", two H1s, mojibake (`�`) | `noindex`, or remove the DB page |
| 4 | **`/windows/` and `/doors/` redirect to double-slash URLs** | `/windows/` → `/windows-milton-keynes//` (200); `/windows/casement-windows/` takes **3 hops**; Googlebot fetched the `//` variants 9 times this month | fix the redirect map entries |
| 5 | Moved URLs return 404 to crawlers | `/case-studies/all-hallows-bedford/`, `/bletchley-rail-depot-refurbishment/`, `/pincents-kiln-reading/` (now under `/commercial-projects/`); `/case-studies/window-handle-replacement-haddenham/` (now `/repair-case-studies/`); `/window-showroom/`, `/door-showroom/`, `/showroom/` (still requested by Bing); `/design_windows_and_doors/` | 301 each to its current page (showrooms to `/contact/`) |
| 6 | **20,357 font 404s in 30 days** | `/fonts/Gibson-*` requested page-relative (the documented Clarity replay fault, plus Google's own renderer: 1,103 from GoogleOther). Each is a full WordPress 404 render, ~0.22 s | one static rule sending `/fonts/Gibson-*` to the theme's font folder |
| 7 | Duplicate visualiser | `/design-your-windows-and-doors/` shares its H1 with `/3d-visualiser/`; 0 clicks, 35 impressions | 301 to `/3d-visualiser/` (closes July F9's open "quote-intent trio" item) |
| 8 | No article or post has article schema | §6.4 | `BlogPosting` |
| 9 | Sitemap has no `<lastmod>` | 737 URLs, `changefreq` only | §6.4 |
| 10 | 78 titles over 60 characters | 43 national commercial pages (Manchester: 89 characters, *"5 Powerful Refurbishment Strategies…"*), 17 case studies, the lintel article (84) | trim the county and case-study templates; leave the lintel title, it ranks |
| 11 | No HSTS header | carried from July | low priority |

Note for `AI.md` line 332: `max-image-preview:large` **is** emitted on all 737 pages — by WordPress core, not the theme. Harmless; the rulebook's statement is wrong.

---

## 9. Page speed: no progress since July

Lighthouse 12, mobile, simulated slow 4G:

| Page | Performance | LCP | Blocking time | Page weight | Legend spritesheet share |
| --- | ---: | ---: | ---: | ---: | ---: |
| `/` | 63 | 15.8 s | 80 ms | 3.3 MB | **61%** |
| `/online-quote/` | 37 | 24.7 s | 1,400 ms | **9.7 MB** | 21% |
| `/windows-milton-keynes/` | 33 | **29.2 s** | 1,810 ms | 6.7 MB | 30% |
| `/composite-doors/` | 38 | 14.3 s | 1,660 ms | 4.2 MB | 47% |
| `/composite-doors-leighton-buzzard/` | 33 | 22.9 s | 1,860 ms | 3.9 MB | 51% |
| `/what-is-a-door-lintel/` | 53 | 4.2 s | 1,650 ms | 4.0 MB | 50% |
| `/window-and-door-repairs/` | 47 | 15.6 s | 540 ms | **8.4 MB** | 24% |

July's baseline was 62 with a 14.5 s LCP. Nothing has improved. What is driving it:

1. **The Legend spritesheet, again.** `legend-spritesheet.webp` is 2,043,360 bytes, emitted twice per page without `loading="lazy"`, on all 737 pages. It was the first code item on 17 August and is still the heaviest thing on every page tested. Load it when the chat launcher is first touched.
2. **Two oversized PNGs on the repairs page**: `5-2.png` (2.45 MB) and `7.png` (2.16 MB), more than half that page's weight. Re-encode as WebP at display size.
3. **Responsive images went backwards.** Town pages gained `srcset` on 15 September; `/composite-doors/` fell from **73 responsive images to 3 of 197**; the homepage (36 images), `/windows-milton-keynes/` (43), `/doors-milton-keynes/` (42) and the main product pages have none. 156 pages carry three or more images and no `srcset`.
4. **Third-party tags on first paint.** On five of the seven pages tested (not the homepage or the repairs page), GTM, the Google Ads tag (loaded twice: directly and again through GTM), GA4, Universal Analytics, the Meta pixel, call tracking and Clarity all start before any interaction, most within the first second, which is where the 1.4–1.9 s of blocking time comes from. That timing follows from the granted-by-default consent model, which `AI.md` records as an **open owner decision**; this audit notes only the speed cost. The duplicate Google Ads load is a separate, fixable fault either way.
5. **`/online-quote/` is 9.7 MB**, most of it WindowCAD (a 2.2 MB account payload, 2.2 MB of scripts, a 0.5 MB 3D environment map). It is the page that produces most leads, so it is worth asking WindowCAD whether the tool can defer its 3D assets until the designer opens.

No real-user Core Web Vitals are available: PageSpeed's keyless quota is exhausted, and the site may be below the Chrome UX Report traffic threshold. A free PageSpeed API key would fix the first.

---

## 10. Price guides

The 15 September release removed the false *"Are the prices on this page real? Yes"* answer from the three guides that had no prices, and `/online-quote/` now links to all seven (28–30 internal links each). Both 17 August accuracy items are closed.

What remains: `/sash-window-prices/`, `/aluminium-window-prices/` and `/patio-french-door-prices/` still carry **no price at all**, have shrunk to ~365 words, and between them earned 1 click in three months. The tracker has `sash window prices`, `patio door prices`, `composite door prices`, `bifold doors cost` and `new windows cost` all not ranking. The 17 August owner question — are organic price guides worth continuing, given price searchers do not convert in Ads? — is still unanswered. Until it is, spend nothing more here.

---

## 11. Commercial pages

- **The national county pages have produced real enquiries.** Two journeys that landed on county pages since July ended in an enquiry form (Dorset via another search engine, Nottinghamshire via Bing), and the enquiry records show one sourced "Commercial glazing Nottinghamshire". The 17 August recommendation treated these pages as dead weight for places Fenster does not serve; commercial work does travel (Leeds, Northwood, Reading), so the owner decision should weigh this. 32 of the 51 county pages have no internal link from any page on the site.
- Commercial hubs: 34 organic journeys, no leads. `commercial glazing contractors` improved from 38.7 to 12.7 and `commercial glazing companies` from 50.7 to 19.7, so visibility is building.
- `/commercial-glazing-milton-keynes/` should go (§8.2 #2): it offers the instant quote tool on a commercial page.

---

## 12. AI search and Bing

Crawler requests in 30 days:

| Crawler | Page fetches | What it is |
| --- | ---: | --- |
| bingbot | 5,105 | Bing search, which also feeds Copilot and, in part, ChatGPT search |
| Amazonbot | 2,653 | Alexa / Amazon answers |
| **ChatGPT-User** | **1,456** | ChatGPT fetching a page live because a user asked something |
| Googlebot | 1,151 | Google search |
| Applebot | 665 | Siri / Spotlight / Apple Intelligence |
| PerplexityBot | 576 | Perplexity |
| OAI-SearchBot | 207 | ChatGPT search index |
| DuckAssist | 74 | DuckDuckGo answers |

**ChatGPT fetches a Fenster page about 49 times a day on users' behalf**: the homepage 586 times, `/louvre-vents/` 399, `/sliding-sash-windows/` 64, `/roof-lanterns/` 32. Real visits arriving from AI assistants are still small (22 from ChatGPT in the log, 30 journeys in September), but they and Bing convert at ~11% (§3.2).

Bing already crawls four to five times as much as Google. Two cheap things make that count:

1. **Confirm Bing Webmaster Tools is verified** (nothing on the site shows it; it can be imported from Search Console in minutes) and submit the sitemap.
2. **IndexNow on publish** for the weekly posts, so Bing, and the assistants that draw on it, pick each one up the day it goes live.

---

## 13. The live SEO state is not in `main`

Hashing live's theme against both lines: **18 files on live match `origin/codex/seo-live-release-2026-09` and not `main`**, including `inc/location-page-data.php`, `template-parts/sections/location-service.php`, `commercial-county.php`, `price-guide.php`, `online-quote.php`, `generated-article.php`, `link-cards.php`, `review-showcase.php` and `inc/assets.php`. Six more (`functions.php`, `inc/generated-pages.php`, `inc/site-data.php`, `site-footer.php`, `generated-page.php`, `composite-doors.php`) match neither line; live has been patched file by file since.

`LIVECHANGES.md` already records that an untagged SEO release went live on 15 September. The SEO consequences are these:

- Everything this audit credits to that release — the corrected ranking URLs in §4.3, the corrected price guides, the town-page `srcset` — exists **only on an unmerged branch**. A deploy of any of those 18 files from `main` silently reverts it.
- `main`'s `location-service.php` still carries the old flagship page (§5), so work done on `main` against these templates starts from a version live no longer runs.
- The branch's own note, `SEO-PERFORMANCE-AUDIT-2026-09-14.md`, still says "Not pushed or deployed to test or production". It is live.

Reconcile the branch into `main` before anyone next touches a location, price-guide or article template.

---

## 14. Standing items from earlier audits

| Item | Source | Status 28 September |
| --- | --- | --- |
| Launch titles and metadata pay off | `SEO-AUDIT.md` | **Closed, and exceeded**: now rankings and impressions too (§1.3) |
| Defer the Legend spritesheet | 17 Aug, code #1 | **Not done.** 2.04 MB, eager, 737/737 pages |
| Prices on the three empty guides | 17 Aug, code #2 | Half: false claim removed 15 Sep; still no prices |
| Link price guides from `/online-quote/` | 17 Aug, code #3 | **Done** |
| `srcset` on homepage and hubs | 17 Aug, code #4 | Town pages done; homepage and hubs still 0; **composite regressed 73 → 3** |
| Price guides: continue at all? | 17 Aug, owner #5 | **Open** |
| National commercial county pages | 17 Aug, owner #6 | **Open**, now with two enquiries on record (§11) |
| Reviews with product names, citations, photography | every audit | Reviews +6 in 10 weeks; case studies grew to 31 URLs |
| Post-launch UK export | 17 Aug, #8 | Done |
| "UK non-brand" KPI from a "-fenster" export | 17 Aug §11.2 | **Replaced** (§2.1) |
| Judge the town matrix on clicks | 17 Aug, #9 | **Superseded**: judge it on leads (§3.4) |
| Visualiser in-area exit | 5 Aug, P4 | No change: 54 organic journeys, 0 leads, 0 internal links in |
| Lead outcomes | 5 Aug, P3 | Corrected 2 Sep: outcomes live in WindowCAD |
| No self-serving review schema | July | Holding |
| Head-term page (F1) | July | **Regressed** (§5) |
| Quote-intent duplicates (F9) | July | `/design-your-windows-and-doors/` still duplicates the visualiser (§8.2 #7) |
| Publishing cadence (F7.5) | July | Weekly since 3 Aug; **not linked** (§6) |
| "Hitchin is the best town" | 17 Aug §4 | **Withdrawn** (§2.5) |

---

## 15. What to do, in order

**Code**

1. **Reconnect the content library** (§6.4): a "Guides" link in header and footer, `/blog/` listing all 46 articles by topic, product-to-guide links, `BlogPosting` schema, sitemap `lastmod`. Highest leverage on the list: 27.5% of real organic visits, fourteen scheduled fault posts, and two posts Google has never seen.
2. **Defer the Legend spritesheet.** Two megabytes off every page; third audit asking.
3. **Redirect and 404 sweep** (§8.2 #2–7): the three legacy routes, the double-slash redirects, the moved case studies, the showroom URLs, the duplicate visualiser, the `/fonts/Gibson-*` rule, `noindex` on `/wcad-thank-you/`.
4. **Images**: the two repairs PNGs; `srcset` for the homepage, both MK hubs and the product pages; restore it on `/composite-doors/`. Remove the duplicate Google Ads tag load.
5. **Merge the 15 September SEO release into `main`** (§13) and correct the 14 September note's status line.

**Owner decisions**

6. **The head-term page** (§5): consolidate into `/windows-milton-keynes/` (recommended) or restore it properly.
7. **The town matrix** (§7): freeze; put proof into the nine towns named in §7; decide whether to `noindex` the 91 pages with no impressions.
8. **Reviews**: ask every completed customer, naming the product. Two of the three MK packs now hold firms with 4 and 6 reviews; the barrier is words, not count.
9. **Price guides** and **national commercial pages** (§10, §11): both still open from 17 August.
10. **Bing Webmaster Tools and IndexNow** (§12): confirm and switch on.

**Measurement** (§2.6)

11. Next month, pull: UK, last 3 months (chart and queries); **all countries, last 3 months (pages)**; UK, 16 months (chart and queries). Report UK non-brand as chart minus brand-named. Pull the access logs before they rotate (30-day retention).
12. Read the rank tracker only as a distribution. Re-run the three `uule` checks monthly.

**Do not do**: expand the town matrix; optimise for the zero-click top-five queries; re-add review schema; buy price keywords; write more templated town copy; plan anything on Hitchin.

---

## 16. Summary

Search is working better than at any point in the sixteen months of data. UK clicks have doubled since launch and are up 92% year on year on the one clean comparison; since mid-August rankings and impressions have started moving too, not only click-through. Google organic is now the largest attributable source of leads on the site and grew every month.

The measurement set adopted in August could not see most of this. Three-fifths of UK clicks come from anonymised long-tail queries, which the "-fenster" filter throws away; the replacement is one subtraction.

What holds the site back now is structure, not content. The article library, including the weekly posts meant to create new visibility, is linked from nowhere, and Google has stopped crawling it. The flagship Milton Keynes page was rebuilt into a copy of a town page while the site's own links point Google at a different page. The town matrix that converts best is also 84% duplicate across 71% of the site. And every page still carries a two-megabyte cat.

The site is in the Milton Keynes map pack and on page one for its biggest term at the same time, for the first time. The two packs it misses are held by firms with a handful of reviews that happen to name the product. That is the cheapest remaining win, and it is not a code change.

---

## Appendix A — Method notes, so next month can repeat this

- **Brand-named clicks**: UK query table, rows matching `fenster|fensta|fenstar|fenser`. **Anonymised** = UK chart total − brand-named − the "-fenster" chart total.
- **Page-level data**: always the all-country page table. The UK-filtered page table holds only ~40% of UK clicks (§2.2).
- **Human Google landings** from `~/www/fensterglazing.com/logs/*.gz`: `GET` for a page (not an asset), referrer host `google.*` or the Google app, no `gclid`/`gbraid`/`wbraid`/`gad_source`, user agent not a bot, **and the same IP requests a `/app/themes/fenster/` asset within 120 seconds**; deduplicate the same IP and path within 30 minutes. Without the asset test, Chrome's prefetch proxy inflates the count about five-fold (IP list: `https://www.gstatic.com/chrome/prefetchproxy/prefetch_proxy_geofeed`). The log file dated D holds traffic from D−1.
- **Leads by channel**: D1 `website_journeys` since the start date, `environment IN ('production','legacy')`, `traffic_class IN ('human','unclassified')`, joined to `website_events`; a lead is a journey with `quote_completed` or `form_submitted`. Channel from `referrer_host`, `source` and `medium`.
- **Duplication**: five-word shingles over the page's `<main>` text with the enquiry form removed, Jaccard similarity.
- **Crawl**: all `page-sitemap.xml` URLs plus every internal link found and every URL in the Search Console page tables; no redirects followed; honest user agent, three workers, 0.35 s spacing.
- **Lighthouse**: `npx lighthouse@12`, default mobile, simulated throttling, local Chrome.
- **SERP**: `https://www.google.com/search?q=…&gl=uk&hl=en&pws=0&uule=w+CAIQICIkTWlsdG9uIEtleW5lcyxFbmdsYW5kLFVuaXRlZCBLaW5nZG9t` (Milton Keynes).

## Appendix B — Where real Google visitors landed, 29 August–27 September

808 landings that loaded the page (§2.3). Brand and company pages 275, articles and blog 222, product pages 171, quote and visualiser 65, town pages 39 (35 different pages), MK hubs 17, commercial 15, other 4.

| Page | Landings |
| --- | ---: |
| `/` | 230 |
| `/what-is-a-door-lintel/` | 72 |
| `/soundproof-windows/` | 38 |
| `/online-quote/` | 37 |
| `/integral-blinds/` | 33 |
| `/3d-visualiser/` | 26 |
| `/meet-the-team/` | 24 |
| `/different-types-of-window-frame-materials/` | 23 |
| `/louvre-vents/` | 22 |
| `/what-are-double-glazed-glass-windows/` | 18 |
| `/what-are-integral-blinds/` | 17 |
| `/window-and-door-repairs/` | 16 |
| `/cat-and-dog-flaps/` | 14 |
| `/obscured-glass/` | 14 |
| `/the-history-of-upvc-windows/` | 11 |
| `/contact/` | 11 |
| `/windows-milton-keynes/` | 11 |
| `/composite-doors/` | 9 |
| `/flush-casement-windows/` | 8 |

Weekly: 169, 164, 177, **241** (week of 20 September).
