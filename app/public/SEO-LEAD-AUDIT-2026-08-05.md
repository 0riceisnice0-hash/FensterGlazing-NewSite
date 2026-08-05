# Fenster Glazing — SEO And Lead Audit, 5 August 2026

Date: 2026-08-05
Scope: organic search performance **and** what that traffic does once it lands. This is the first audit to join the two.

Sources:

- Google Search Console export, Web search, **2026-05-04 to 2026-08-03** (Chart/Queries/Pages/Countries/Devices/Search-appearance). The new site went live **5 July 2026**, so this window splits into 62 days of old site and 30 days of new site.
- Rank tracker export, desktop, 2026-07-06 to 2026-08-05, 101 tracked keywords, Milton Keynes localised.
- Marketing Dashboard D1 (`marketing_dashboard`), read live on 2026-08-05. Tracker data starts **13 July 2026**, so the conversion window is 24 days.
- Live checks run today: sitemap (705 URLs), schema types on three routes.

Read alongside `SEO-AUDIT-AUG-2026.md` (2026-08-03), which this does not replace. That document owns the 16-month history and the September 2025 `&num=100` explanation, and both still stand. This one owns the launch measurement and the conversion picture.

Dashboard figures follow `WEBSITE-TRACKER.md`. Where a metric there is marked unreliable, it is treated as unreliable here.

---

## 1. The launch worked, and it worked in one specific way

Splitting the export at 5 July, comparing the last 30 days of the old site against the first 30 days of the new one:

| | 30d old site | 30d new site | Change |
| --- | --- | --- | --- |
| Clicks | 404 | **519** | +28% |
| Clicks/day | 13.5 | **17.3** | +28% |
| CTR | 0.31% | **0.41%** | +33% |
| Impressions/day | 4,383 | 4,227 | −4% |
| Average position | 24.2 | 23.3 | +0.9 |

**The entire gain is CTR.** Impressions fell slightly and average position barely moved. The site is not being shown to more people; the same impressions are earning more clicks.

That is precisely what a theme-owned title and meta rewrite is supposed to produce, and it is the outcome `SEO-AUDIT.md` predicted in July and `LAUNCH-WEEK-REPORT.md` was too early to measure. **Treat this as confirmation that the launch SEO work paid, and as the measured close of that prediction.**

Post-launch weeks:

| Week | Clicks/day | CTR | Position |
| --- | --- | --- | --- |
| 05–11 Jul | 15.9 | 0.35% | 24.5 |
| 12–18 Jul | 16.1 | 0.37% | 23.7 |
| 19–25 Jul | **19.1** | **0.47%** | 22.6 |
| 26 Jul–01 Aug | 17.0 | 0.42% | 22.7 |

The trend is upward and still moving. Many SEO changes shipped across this month, so no single commit owns the gain, but the direction is consistent week on week rather than a single spike.

Mobile is the better half of the site and by some distance: **0.48% CTR at position 16.1**, against desktop's 0.26% at position 27.5. Mobile is 710 of 1,397 clicks from 148,524 impressions; desktop takes 244,776 impressions to return 641 clicks.

---

## 2. Rankings are genuinely up, with one reading caveat

The tracker records **28 keywords up, 25 down, 47 unchanged** over the month, with 14 sitting at position 1. The climbs are real and several are large:

| Keyword | Move |
| --- | --- |
| what are integral blinds | 33 → 2 |
| double glazing northampton | 100 → 17 |
| double glazing bedford | 100 → 29 |
| glazing company milton keynes | 33 → 7 |
| double glazing stony stratford | 100 → 34 |
| bifold doors milton keynes | 15 → 5 |
| double glazing wolverton | 7 → 1 |
| bifold doors newport pagnell | 8 → 2 |
| bay windows milton keynes | 9 → 3 |
| double glazing prices milton keynes | 11 → 3 |

Three towns entering the top 35 from unranked is the most commercially interesting movement on the sheet, because Northampton and Bedford are real markets rather than long tail.

**The caveat: this tracker is desktop, Milton Keynes localised, single sample.** GSC averages every location and device, so the two disagree, sometimes sharply:

| Keyword | Tracker | GSC average position |
| --- | --- | --- |
| windows milton keynes | 7 | 31.4 |
| sash windows milton keynes | 7 | 36.8 |
| aluminium windows milton keynes | 1 | 12.9 |
| composite doors milton keynes | 2 | 8.1 |
| **front doors milton keynes** | **37** | **9.8** |

That last row is the tell. The tracker reports a 33-place collapse on a term GSC shows sitting at 9.8 with 647 impressions and 3 clicks. Both cannot be right. **Do not plan work off an individual tracker move.** The aggregate direction is trustworthy; single rows are not. The same applies to the apparent losses (`shopfront glazing milton keynes` 7 → 36, `french doors milton keynes` 2 → 11): verify against GSC before treating one as a problem.

Also unresolved: 19 tracked keywords are **Not ranked** or **Unstable**, including `integral blinds`, `french casement windows`, `composite door prices`, `sash window prices`, `bifold doors cost` and `new windows cost`. Five of those are price terms the price guides were built for. See §5.

---

## 3. What the traffic is actually made of

The headline click number flatters the site. Stripping it down:

- **1,397 clicks in three months. 999 are UK.** The other 398 (28.5%) are USA, India, Canada, Ireland, Australia, South Africa and Pakistan, drawn almost entirely by the door lintel and window frame guides. Spanish `dintel de la puerta` and `dintel de puerta` alone account for 4,704 impressions.
- GSC names only 468 of the 1,397 clicks (the export caps at 1,000 queries and anonymises the rest). **Of those named clicks, brand is 224, or 47.9%.** `HIGH-INTENT-SEARCH-PLAN.md` measured 42.7% in July on a different basis, so these are not directly comparable, but nothing here suggests brand dependence is shrinking.
- **Local non-brand commercial queries returned 57 clicks in three months**, from 51,547 impressions at 0.111% CTR and average position 19.0. That is roughly **19 in-area buyers a month arriving from organic search**.

Top pages are informational or tool pages, not money pages:

| Page | Clicks | Impressions | CTR | Position |
| --- | --- | --- | --- | --- |
| `/` | 279 | 23,250 | 1.20% | 35.2 |
| `/what-is-a-door-lintel/` | 158 | 57,016 | 0.28% | 6.1 |
| `/3d-visualiser/` | **136** | 7,710 | **1.76%** | 14.7 |
| `/different-types-of-window-frame-materials/` | 60 | 14,508 | 0.41% | 6.9 |
| `/soundproof-windows/` | 57 | 16,143 | 0.35% | 26.5 |
| `/meet-the-team/` | 52 | 1,714 | 3.03% | 14.9 |
| `/what-are-integral-blinds/` | 45 | 8,512 | 0.53% | 26.7 |
| `/instant-pricing/` | 44 | 7,559 | 0.58% | 24.1 |

`/what-are-double-glazed-glass-windows/` remains the worst asset on the site by ratio: **49,890 impressions, 25 clicks, 0.05% CTR**. `ACTION-PLAN.md` and `SEO-AUDIT.md` both flagged it; it has not improved.

---

## 4. The conversion picture, from the dashboard

Tracked window **13 July to 5 August, 24 days**. All figures below read `environment IN ('production','legacy')` per the documented fix for the 31 July blackout.

**Attributable share: 35.5%.** 1,778 consented page views against 3,228 recorded without analytics consent. Everything in this section describes roughly a third of the site's traffic, and the section says so first, as the tracker guide requires.

Consented event totals:

| Event | Count |
| --- | --- |
| page_view | 1,778 |
| link_click | 967 |
| quote_iframe_loaded (exposure, not a start) | 459 |
| cta_click | 179 |
| chat_opened | 62 |
| form_started | 28 |
| quote_opened (deliberate) | 32 |
| quote_completed | 28 |
| form_submitted | 15 |
| phone_click | 9 |
| email_click | 8 |

At journey level, from 410 consented journeys:

**182 journeys saw the quote tool → 21 deliberately opened it → 12 completed a quote.** A further 9 journeys sent a form. **21 journeys produced a lead, a 5.1% journey-to-lead rate.**

Adding the aggregate-only path for non-consented traffic gives 59 further WindowCAD completions and 15 further forms. Note the caveat in `HANDOVER.md`: completions with no tracking value include office-entered projects and re-opened WindowCAD links, so that 59 is **not** all website-generated and must not be reported as such.

First touch on consented journeys:

| Source | Journeys |
| --- | --- |
| Google organic | 168 |
| Direct | 120 |
| Own site (fensterglazing.com) | 48 |
| Google Ads (cpc, tagged) | 15 |
| Facebook | 17 |
| Bing | 11 |
| chatgpt.com | 2 |

---

## 5. The five findings that decide lead volume

### F1. The visualiser is the best-performing organic page and it has converted nobody

`/3d-visualiser/` earns 136 clicks at 1.76% CTR, the highest of any significant page, and it anchors a genuine demand pocket where Fenster ranks 4 to 17: `door visualiser`, `window visualiser tool`, `online window designer`, `upvc window visualiser`, `window visualiser upload photo uk`.

In the tracked window, **21 consented journeys reached the visualiser. Zero produced a lead.** The 389 journeys that did not touch it produced 21 leads, a 5.4% rate.

**Read this as directional, not proven.** At the base rate, 21 journeys would be expected to yield about one lead, so zero is not statistically significant on its own. But it points the same way as a second fact: visualiser search demand is national, and the town names never appear in those queries. The page is doing brilliant top-of-funnel work for an audience that largely cannot buy from Fenster.

The question to answer is whether the visualiser hands over to the quote tool or to a consultation at all, and for in-area visitors specifically.

### F2. Quote tool exposure is not the problem; opening it is

182 journeys were shown the embedded tool and 21 opened it, a **11.5% open rate**. Of those who opened, 12 completed, a **57% completion rate**.

That shape is unambiguous. The tool converts well once someone commits to it. The loss is entirely at the point of commitment, and `quote_iframe_loaded` proves it is not a visibility problem. This is the largest single conversion gap measured anywhere on the site.

### F3. The town matrix is still not working

342 URLs carrying a town or county name produced **115 clicks from 97,581 impressions, 0.118% CTR, average position 32.8.**

`HIGH-INTENT-SEARCH-PLAN.md` measured 0.09% on 22 July. A month later it is 0.118%. That is not movement. The matrix is a quarter of all site impressions returning 8% of clicks.

Worth separating out: `/windows-milton-keynes/` alone is **13,903 impressions at position 19.2 for 23 clicks (0.17%)**, and `/doors-milton-keynes/` is 7,700 impressions at position 40.6 for 10 clicks. The hubs are visible and not clicked; the deep matrix pages mostly sit past position 30 where CTR is near zero regardless of copy.

Those are two different problems and should not get the same fix.

### F4. The price guides are invisible

The seven price guide pages returned **15 impressions and 1 click in the whole window.** They are in the sitemap (verified today, 705 URLs, all seven present). Five of the matching tracked keywords are **Not ranked** or **Unstable**.

These are the highest purchase-intent pages on the site and Google is not ranking them at all. `HANDOVER.md` notes they went live bundled into an unrelated SEO commit around 18 July, so they have had two to three weeks. That is early, but 15 impressions is not a slow start, it is absence.

### F5. The measurement loop is open at both ends

Three gaps, all of which limit how much any of the above can be optimised:

- **Google Ads is largely untagged.** 15 journeys carry `google/cpc` against 168 organic. The tracker guide names this exact symptom and its cause: the live ad destination URLs are not carrying UTM parameters. `GOOGLE-ADS-PLAN.md` budgets £1,000/month; most of it is currently arriving as untagged direct or organic.
- **Lead outcomes are unused.** The `website_lead_outcomes` table holds **one row**, status `won`. Nothing is being marked contacted, qualified, appointment, won or lost. Without that, no channel, page or campaign can be judged on jobs rather than form fills, and the Google Ads offline conversion feed has nothing to send.
- **Only 35.5% of page views are attributable.** Consent choices for 31 July to 5 August were 117 accept-all and 35 necessary-only, with zero analytics-only and zero marketing-only. Acceptance among people who answer is healthy at 77%; the issue is how few answer.

On that last point, `banner_shown` recorded 1,120 against 152 choices in the same period. **Do not turn that into an abandonment rate.** `AI.md` and `WEBSITE-TRACKER.md` both record that this metric is unsound as a denominator, it counts once per page load, and 3 August alone contributed 466 impressions against 35 choices, which looks like crawler or prefetch noise. The sound statement is the attributable share, and it is 35.5%.

There is no evidence the modal is costing traffic: CTR rose 33% post-launch with the modal live throughout. It is costing **measurement**, not visitors.

---

## 6. What to do, in priority order

Ranked by leads per unit of effort, not by how interesting the work is.

### P1. Close the quote-tool commitment gap (F2)

The measured shape says 88.5% of people shown the tool never open it, while 57% of those who do finish. Nothing else on the site has that ratio.

Work: establish what the embed looks like at the moment of decision on the pages carrying it, on mobile first since mobile is the stronger half of the traffic. The `Get an instant price` CTA already leads clicks at 29, and `Open quote tool` at 15, so intent exists and is being lost between the click and the tool.

Verify with: `quote_opened` journeys over `quote_iframe_loaded` journeys, weekly. Target is the 11.5% rate, and it should be measured before and after any change.

### P2. Tag the Google Ads destination URLs (F5)

Cheapest item on the list and it unblocks the whole paid analysis. Until it is done, `GOOGLE-ADS-PLAN.md` cannot be evaluated against anything.

Verify with: journeys grouped by `source`/`medium`, expecting cpc journeys to rise toward the true click volume.

### P3. Start recording lead outcomes (F5)

One row exists. Until the office marks outcomes, "leads" means form fills, and no one can say which town page, product page or campaign produced a job. This is an operational habit rather than a code change, and it gates every future claim about ROI.

### P4. Give the visualiser an in-area exit (F1)

Not a rewrite. The page works, and its national audience is not a fault. The task is a route from the visualiser to the quote tool or the free consultation for someone who is in the service area, and then a re-measure of the same segment in 30 days with a larger sample.

Do not remove or de-prioritise the page on the strength of a 21-journey sample.

### P5. Split the town matrix problem in two (F3)

- **The hubs** (`/windows-milton-keynes/`, `/doors-milton-keynes/`) are visible at positions 19 and 41 with 21,603 combined impressions and 33 clicks. These are worth a title, meta and first-screen pass, because they are close enough to earn clicks.
- **The deep matrix** sits at average position 32.8. Copy will not fix position 32. Either it earns authority through internal links and real local proof, or it is accepted as an impression-only asset and stops being counted as a lead channel.

The case study system is the honest lever here: 16 case study URLs currently return 472 impressions and 2 clicks, but they are the only genuine local proof the site owns, and `/double-glazing-luton/` only gained its first one on 4 August.

### P6. Diagnose the price guides before writing more (F4)

15 impressions is an indexation or authority signal, not a copy signal. Check coverage in Search Console, internal links into the seven pages, and whether they are competing with the money pages that already rank. Writing more price content before knowing why these seven are invisible would repeat the mistake.

---

## 7. Two things to check that this data cannot settle

**Review snippets appear to have stopped at launch.** GSC reports a `Review snippet` search appearance with 104 clicks and 44,453 impressions across the window. Live schema was checked today on three routes and emits `HomeAndConstructionBusiness`, `Service`, `Offer`, `FAQPage` and `BreadcrumbList` only, with **no `aggregateRating` or `Review` anywhere** — correct, and exactly what the `AI.md` review rule requires. So those snippets are almost certainly old-site legacy from the imported schema `AUDIT.md` described as carrying unsubstantiated `aggregateRating` values.

That is the right call to have made, but it means a SERP feature was lost at launch, and it partly explains why impressions are flat while CTR climbed. Worth confirming by date-filtering the appearance in the GSC UI, which the export cannot do.

**The map pack is not in this data at all.** Every figure here is organic web search. Milton Keynes lead volume for this trade largely lives in the local pack, and nothing in GSC, the rank tracker or the dashboard measures it. Google Business Profile insights are the missing source, and the existing note that this is a prominence problem rather than a configuration one still stands.

---

## 8. Summary

The site is winning the argument it was set up to win. Post-launch CTR is up 33% and clicks per day up 28%, on flat impressions, which is the signature of better titles and metadata rather than better rankings. Local rankings are genuinely climbing, with three new towns entering the top 35.

What has not changed is the size of the lead engine. Roughly 19 in-area non-brand organic clicks a month reach the site, 5.1% of consented journeys produce a lead, and the largest measured loss is 182 people shown a quote tool of whom 21 opened it.

The next meaningful gain is not more traffic. It is the 88.5% who see the quote tool and do not touch it.
