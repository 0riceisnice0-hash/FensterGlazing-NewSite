# Fenster Glazing — High-Intent Search Plan

Date: 2026-07-22
Goal: **maximise high-intent clicks** — people in Fenster's actual service area who are shopping for windows and doors now.
Evidence: 3 months of Google Search Console data (20 Apr – 21 Jul 2026, exported 22 Jul), live location-encoded SERP checks for the money terms, the consented Website Tracker, and the live theme code.

Read alongside:
- `SEO-AUDIT.md` — the 2026-07-07 strategy audit. Its technical findings are done; its predictions are now **measured** here.
- `ACTION-PLAN.md` — the 2026-07-16 content/imagery plan.
- `CASESTUDIES.md` — the proof system this plan leans on heavily.

---

## 1. The verdict

The site is technically excellent and commercially invisible. That is a much better problem than the reverse, because the expensive part is already built.

Three numbers tell the whole story:

| Measure | Value | What it means |
| --- | --- | --- |
| Brand share of clicks | **42.7%** | Nearly half your search traffic is people who already knew your name |
| Local commercial clicks | **49 in 3 months** | The buyers are barely reaching you |
| Town matrix CTR | **0.09%** (64,607 impressions → 60 clicks) | 205 pages Google shows but nobody clicks |

The launch on 5 July was **neutral** — it protected what existed and cost nothing, but it has not yet won anything new.

| | Clicks/day | Impressions/day | Avg position |
| --- | --- | --- | --- |
| Old site (1 Jun – 4 Jul) | 14.0 | 4,357 | 23.8 |
| New site (5 – 21 Jul) | 15.5 | 4,364 | 24.0 |
| Week 1 (6–12 Jul) | 15.7 | 4,588 | 24.3 |
| Week 2 (13–19 Jul) | 15.6 | 4,184 | 23.3 |

---

## 2. Where the traffic actually comes from

Every query in the export, classified by intent:

| Intent bucket | Queries | Clicks | % of clicks | Impressions | CTR | Avg pos |
| --- | --- | --- | --- | --- | --- | --- |
| **Brand** (`fenster …`) | 10 | 183 | **42.7%** | 1,783 | 10.26% | 7.4 |
| Product, no location | 553 | 144 | 33.6% | 135,376 | 0.11% | 28.8 |
| **Local commercial** | 259 | **49** | **11.4%** | 49,055 | 0.10% | 19.9 |
| Informational | 77 | 34 | 7.9% | 16,174 | 0.21% | 28.3 |
| Other | 78 | 17 | 4.0% | 21,062 | 0.08% | 24.6 |

### Two structural leaks

**32% of all impressions cannot buy anything.** Of 398,174 total impressions, 126,739 are outside the UK — 45,225 United States, 13,410 India, 9,109 Australia. They come almost entirely from imported informational guides. `/what-is-a-door-lintel/` alone draws 56,431 impressions for 186 clicks.

**Brand search is under-owned.** `fenster glazing` sits at **position 4.0** on 712 impressions. That is your own name. Position 1 would roughly double those 145 clicks on its own.

| Brand query | Impressions | Clicks | Position |
| --- | --- | --- | --- |
| fenster glazing | 712 | 145 | 4.0 |
| fenster windows | 238 | 16 | 11.9 |
| fenster | 545 | 7 | 8.2 |
| fenster glazing milton keynes | 34 | 6 | 1.7 |

---

## 3. The CTR anomaly, explained

CTR is 60–90× below industry norm at **every** position band:

| Position band | Queries | Impressions | Clicks | Our CTR | Expected |
| --- | --- | --- | --- | --- | --- |
| 1–3 | 53 | 10,279 | 34 | **0.33%** | ~20–30% |
| 3–5 | 45 | 19,301 | 36 | **0.19%** | ~8–12% |
| 5–10 | 127 | 24,014 | 73 | **0.30%** | ~3–6% |
| 10–20 | 225 | 49,068 | 74 | 0.15% | ~1–2% |
| 20–50 | 389 | 90,736 | 29 | 0.03% | <0.5% |

A gap that size is not a title-tag problem. It means **the reported position is not the visible position**. On local service searches Google stacks Local Services Ads, then paid ads, then the map pack, then "People also ask" — organic result #2 can sit two full screens down. GSC counts the impression; the human never sees it.

That is the single most important reframing in this document: **ranking organically in a local market is not the same as being visible in it.**

---

## 4. SERP reality check — live map-pack positions

Checked 22 July with location-encoded searches (`uule`) from each town.

| Money term | Impressions/qtr | Map pack | Organic page 1 |
| --- | --- | --- | --- |
| **double glazing milton keynes** | 1,742 | ✅ **#3 Fenster** 4.9 (133) | ❌ absent (GSC 16.1) |
| **composite doors milton keynes** | 813 | ❌ absent | ✅ ~#9 (GSC 7.9) |
| **windows milton keynes** | 1,293 | ❌ absent | ❌ absent (GSC 31.5) |
| **composite doors northampton** | 811 | ❌ absent | ❌ absent (GSC 14.1) |

**You are never in both places at once on any term.** That is the gap between where you are and where the clicks are.

### Milton Keynes competitive set

| Business | Reviews | GBP category | Packs appeared in |
| --- | --- | --- | --- |
| **Gallaghers Windows, Doors & Conservatories** | 4.9 (173) | Double glazing installer | **all 3** |
| Elements Windows & Doors MK | 4.9 (92) | Window supplier | 2 of 3 |
| **Fenster Glazing** | 4.9 (133) | **Double glazing installer** | **1 of 3** |
| Infinite Windows & Doors | 4.8 (52) | Window supplier | 1 of 3 |
| Custom Glaze | 4.4 (92) | Double glazing installer | 1 (sponsored) |
| Martindale Windows | 4.9 (316) | Double glazing installer | 1 (sponsored) |

### The map-pack gap is NOT a configuration problem — verified 22 July

The obvious explanation would be a thin Google Business Profile. It was checked directly and that theory is **wrong**. The profile is well built:

- **Primary category:** Double glazing installer. **Additional:** Door shop, Door supplier, Window supplier, Window installation service — already covering the missed queries.
- **Products populated** and categorised: Composite Doors, Patio Doors, Aluminium Doors, Casement Windows, French Casement Windows, Aluminium Windows, Roof Lanterns, Integral Blinds, Replacement Glazing, Cat and Dog Flaps.
- Full description naming MK suburbs, all four social profiles, service areas, hours, parking and amenities complete.

Which forces a harder conclusion. Compare Fenster with **Infinite Windows & Doors**, who *are* in the composite doors pack:

| | Fenster | Infinite |
| --- | --- | --- |
| Address | 98 Alston Drive | **Unit 51, Alston Drive** — same street |
| Reviews | **4.9 (133)** | 4.8 (52) |
| Relevant category | Window supplier ✅ | Window supplier ✅ |
| In composite doors pack | ❌ | ✅ |

Same street, so proximity is not the cause. Right categories, so relevance configuration is not the cause. Two and a half times the reviews, so volume alone is not the cause. The pack is identical whether searched from the MK centroid or from Wolverton, a mile from the showroom.

**What remains is prominence** — Google's third local ranking pillar, and the one that cannot be edited in a dashboard: off-site citations, links, press, brand mentions and review velocity. `SEO-AUDIT.md` F6 identified this in July and it is still the long pole. Competitors trading 25–45 years have accumulated it; Fenster has been trading since 2018.

One controllable detail worth acting on: **your review excerpts are all generic.** Google surfaces the review text that matches the query, and it shows for Fenster *"We couldn't have been happier with their service and quality of the products"*, *"Excellent experience from start to finish"*. For Gallaghers on the composite door search it shows *"Very happy with our new and distinctive composite front door."* Reviews that name the product are a relevance signal you can legitimately encourage by asking customers what they had fitted.

Also worth testing: the knowledge panel describes Fenster as *"Double glazing installer in **England**"* rather than in Milton Keynes. The service area currently spans 11 towns plus four whole counties. Trimming it to the genuine working radius may sharpen local anchoring. This is a hypothesis, not a certainty — change it and watch, do not assume.

Competitors are also buying sponsored map placements (Custom Glaze, Martindale, Double Glazing Direct, British Glass). On `windows milton keynes` two Local Services Ads sit above everything.

### Northampton is a different market

| Business | Reviews | Based |
| --- | --- | --- |
| Martindale Windows | 4.9 (**317**) | Northampton |
| Park Lane Windows | 4.7 (**213**) | Northampton |
| Doors & Windows For Life | 4.9 (141) | Kettering |

Local incumbents with 141–317 reviews and physical Northampton addresses. Fenster is 25 miles away with 133 reviews and no local presence. **Northampton's ~4,000 quarterly impressions are not winnable on current assets** and should not receive further investment. Same conclusion for Luton, Stevenage, Hitchin and Letchworth.

---

## 5. The winnable ground

94 local commercial terms sit at positions 11–25 with **23,775 impressions currently returning 20 clicks**. The Milton Keynes cluster is the prize:

| Query | Impressions | Position | Status |
| --- | --- | --- | --- |
| double glazing milton keynes | 1,742 | 16.1 | In map pack, not organic |
| upvc windows milton keynes | 882 | 12.3 | Striking distance |
| composite doors milton keynes | 813 | 7.9 | Organic p1, not in pack |
| front doors milton keynes | 619 | 10.5 | Striking distance |
| replacement windows milton keynes | 578 | 16.1 | Striking distance |
| window repair milton keynes | 545 | 13.8 | Striking distance |
| aluminium windows milton keynes | 521 | 18.6 | Striking distance |
| bifold doors milton keynes | 508 | 14.7 | Striking distance |
| casement windows milton keynes | 363 | 10.0 | Striking distance |
| window installer milton keynes | 353 | 10.2 | Striking distance |

There are also **64 local commercial terms already on page 1** producing 15 clicks from 9,208 impressions — including `northampton bay windows` at **position 2.0 with zero clicks**. Those are already-won rankings being wasted by the visibility problem in §3.

---

## 6. Diagnosis

Ranked by how much high-intent traffic each is costing:

1. **Not in the map pack for 2 of the 3 biggest MK terms.** Highest cost, and — now that the GBP has been verified as correctly configured — **not a quick fix**. It is a prominence problem: reviews, citations and authority against competitors with decades of accumulated signals. Treat as a sustained programme, not a task.
2. **The 205-page town matrix is spread too thin.** 64,607 impressions, 60 clicks. Google ranks these pages at positions 19–66 — it sees them and declines to promote them. Meanwhile `/composite-doors/`, with no town in the URL at all, ranks 7.9 for `composite doors milton keynes`. Google is telling you it prefers one strong product page to 205 templated town pages.
3. **No review stars in organic snippets.** T&K (5.0/124), Aspire (5.0/97) and Checkatrade (5.0/332) all show ratings on these searches; Fenster does not. Star ratings lift CTR everywhere you already rank.
4. **Brand result at position 4.**
5. **Impression base polluted by non-buying international informational traffic.**

---

## 7. The plan

### Strategic consequence of the GBP finding

Because the profile is already correct, **the map pack is a slow authority grind, not a quick fix.** That reverses the priority order this plan started with. The faster route to high-intent clicks is **organic page 1 for the Milton Keynes cluster**, where Fenster's genuine advantage lives: the best technical site in the market, real case studies, and 94 terms already in striking distance. Win organic first; let the pack follow the reviews and citations.

### Tier 0 — Owner actions, no code

**0.1 Review velocity — target 200+, with product names in them.** Gallaghers has 173 and appears in every pack. Two things matter: the count, and the words. Ask customers what was fitted — "our new composite front door", "the bifolds" — because that text is what Google matches to product queries. Every completed install becomes a review request with a direct review link in the aftercare email. The case-study customers (Whitehouse, Broughton, Bolbeck Park, Leighton Buzzard ×2, Drayton Parslow, Wolverton) are the warmest asks and are already photographed and documented.

**0.2 Citations and authority — the long pole.** This is the one thing separating Fenster from firms trading since 1978–2001, and no code change substitutes for it. Work the list in `SEO-AUDIT.md` F6: Bing Places, Apple Business Connect, Yell, FreeIndex, MK Chamber of Commerce, Destination Milton Keynes, supplier directories (Liniar, Sheerline, Roseview, Distinction installer finders — these are high-relevance and free), FENSA and CPA directory entries, plus local press around real installs.

**0.3 Test the service area.** Currently 11 towns plus four counties, and Google describes the business as "in England" rather than in Milton Keynes. Consider trimming to the realistic working radius and watch whether local anchoring sharpens.

**0.4 Decide on paid local placement.** Competitors are buying sponsored map slots on exactly the terms where Fenster is absent. This is a budget decision, not an SEO one, but on `windows milton keynes` it is currently the only fast route to the top of the page.

### Tier 1 — Concentrate the matrix on ground you can hold

The current matrix is 25 towns × 21 products in `inc/generated-pages.php` (`fenster_location_matrix_towns()`, `fenster_location_matrix_products()`).

Split it into three tiers by winnability, and put the effort where proximity is a genuine advantage:

| Tier | Towns | Treatment |
| --- | --- | --- |
| **1 — MK suburbs** | Bletchley, Wolverton, Stony Stratford, Newport Pagnell, Woburn Sands, Great Linford, Shenley Church End, Furzton, Oldbrook, Monkston, Brooklands, Whitehouse | Full investment: real proof, install photos, local reviews, internal links |
| **2 — Near ring** | Leighton Buzzard, Buckingham, Bedford, Aylesbury, Dunstable, Flitwick, Ampthill | Keep, moderate investment as proof becomes available |
| **3 — Far ring** | Northampton, Luton, Stevenage, Hitchin, Letchworth, Toddington | Keep indexed, stop investing. Expect nothing. Do not add internal links |

Fenster is physically in Milton Keynes. Tier 1 is where proximity — the strongest local ranking factor there is — actually works for you. It is also where the case studies already exist.

**Do not mass-delete Tier 3.** `SEO-AUDIT.md` F5 is right that rebuilding the matrix is not the answer; the change is where the *effort and internal links* point.

### Tier 2 — Put real proof on the town pages

The single biggest quality gap between a templated town page and a page Google promotes is evidence that the work happened there.

`inc/case-studies-data.php` already carries a `location` per study:

| Study location | Town tier |
| --- | --- |
| Whitehouse, Milton Keynes | Tier 1 |
| Broughton, Milton Keynes | Tier 1 |
| Bolbeck Park, Milton Keynes | Tier 1 |
| Wolverton, Milton Keynes | Tier 1 |
| Leighton Buzzard, Bedfordshire ×2 | Tier 2 |
| Drayton Parslow | Tier 2 |
| Northampton | Tier 3 |

**Code change:** add `fenster_case_studies_for_town(string $town_slug, int $limit = 3)` to `inc/case-studies-data.php`, mirroring the existing `fenster_case_studies_for_product()` (line 502) but matching against the `location` field. Render it in `template-parts/sections/location-service.php` above the enquiry form, reusing `components/case-study-card.php`.

Result: `/casement-windows-whitehouse/` stops being templated copy and starts carrying photographs of a real Whitehouse install. That is the difference between a doorway page and a local page.

### Tier 3 — Fix CTR on rankings you already hold

**3.1 Review snippets.** `AI.md` currently forbids `aggregateRating` schema without a verifiable review feed — that was the correct call when written. With 133 Google reviews (verified live on the GBP, 22 July) the rating is now substantiable. Implement it properly:
- maintain owner-verified counts in `inc/site-data.php`, reviewed quarterly, or pull from a real feed;
- output `aggregateRating` within the existing LocalBusiness block in `fenster_render_site_schema()` (`inc/generated-pages.php:2003`);
- keep `sameAs` pointed at checkable profiles.

Update the `AI.md` rule in the same commit so the reasoning is recorded, not silently reversed.

> **Status 2026-07-22:** 3.1a is **done**, and 3.1 was resolved differently — see the note below. The review showcase now runs on live Google data via `inc/google-reviews.php`, with MK-first framing and the real review/write-review links. `aggregateRating` was deliberately **not** added: Google does not show review rich results for self-serving reviews about the business itself, so it would carry risk without producing stars. Star ratings in organic snippets require a genuine third-party source. The LocalBusiness schema instead gained `hasOfferCatalog` (the real product range, mirroring the GBP Products list), MK suburbs first in `areaServed`, and `foundingDate`.

**3.1a Fix the Google review link — small, and overdue.** `inc/site-data.php:30` sets `google_reviews_url` to a Google *search* query:

```
'google_reviews_url' => 'https://www.google.com/search?q=Fenster+Glazing+Milton+Keynes+reviews',
```

Every review-showcase "read reviews" link across the site therefore sends people to a search results page rather than the Fenster review panel. `AUDIT.md` §3.9 flagged this and it is still live. Replace it with the real Google Business Profile review URL, and use the same canonical profile URL in the schema `sameAs` block (currently a `maps/place` coordinate link, `inc/generated-pages.php:2021`). One line, and it strengthens both the customer journey and the site↔GBP association that feeds the map pack.

**3.2 Brand result.** Investigate what outranks `fensterglazing.com` for `fenster glazing`. Likely candidates: directory listings, the old site's residue, Companies House. Cheapest click gain available.

**3.3 Titles for the striking-distance ten.** The MK cluster in §5 sits at positions 8–19. Review each target page's title and meta against the live SERP competition before touching anything else — these are the pages where a CTR gain compounds with a ranking gain.

### Tier 4 — Stop feeding the wrong audience

The imported informational guides draw 126,739 non-UK impressions. They are not harmful, but they should work for the business:
- add a prominent, geographically explicit CTA into the top-traffic guides (`/what-is-a-door-lintel/`, `/different-types-of-window-frame-materials/`, `/what-are-double-glazed-glass-windows/`) pointing at the MK money pages;
- do not commission more non-local informational content until local commercial is winning.

---

## 8. Measurement

The Website Tracker (Projects → Tools → Website Tracker) is now the feedback loop. Watch weekly:

| Metric | Where | Target direction |
| --- | --- | --- |
| Consented visitors from Google | Acquisition → channels | Up |
| Quote starts → WindowCAD completions | Overview funnel | Completion rate up |
| Untracked WindowCAD quotes | Overview amber alert | Should stay near zero |
| Local commercial clicks | GSC, monthly export | **The headline number: 49/quarter today** |
| Map pack presence | Manual `uule` SERP check, monthly | 1 of 3 → 3 of 3 |
| Google review count | GBP | 133 → 200+ |

Re-export GSC monthly and re-run the intent classification. The scripts used for this analysis are reproducible from the query export alone.

---

## 9. Honest expectations

Milton Keynes is contested by firms trading 20–45 years with 92–316 reviews each. Fenster has been trading since 2018. Nothing here produces a step change in weeks.

The GBP check removed the one shortcut that looked available. There is no configuration switch left to flip; what remains is proof, authority and patience.

What is realistic:
- **Weeks 1–4:** website work lands — review schema, brand result, the Google review link, case-study proof on Tier 1 town pages. Review and citation programmes start; they compound rather than spike.
- **Months 2–3:** town pages carrying real proof get re-evaluated. The striking-distance MK terms are where movement should show first, because organic is where Fenster's advantages actually apply.
- **Month 3+:** the 49-clicks-per-quarter local commercial number is the one that proves it worked. Doubling it is a realistic first target; it would still only be 22% of your click mix.
- **Map pack:** measured in quarters, not weeks. The gate is passing Gallaghers on review count and closing a 20-year citation gap.

The floor is genuinely solid: technically the site is ahead of every competitor checked, the lead plumbing is verified end to end, and the attribution to prove what works is live. The gap is visibility and proof, and both are buildable.
