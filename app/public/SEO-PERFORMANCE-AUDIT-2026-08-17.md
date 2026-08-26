# Fenster Glazing — SEO And Performance Check, 17 August 2026

Date: 2026-08-17

Sources:

- Google Search Console export, Web search, **2025-08-16 to 2026-08-15** (Chart/Queries/Pages/Countries/Devices/Search-appearance). 365 days, 6,468 clicks, 1,859,370 impressions.
- Rank tracker export, desktop, Milton Keynes localised, **18 Jul – 17 Aug 2026**, 100 keywords. Diffed line by line against the 5 August export of the same tool.
- Live checks run today: robots, sitemap (715 URLs), schema on three routes, response times on five routes, all seven price guides fetched and parsed, and a real browser page-weight measurement at a 375px viewport.

Reads alongside and does not replace `SEO-AUDIT-AUG-2026.md` (03 Aug, owns the 16-month history and the `&num=100` explanation), `SEO-LEAD-AUDIT-2026-08-05.md` (05 Aug, owns the launch measurement and the conversion picture) and `COMMERCIAL-AUDIT-2026-08-12.md`. Everything those documents concluded still stands. This one adds twelve days of new search data, a first proper diagnosis of the price guides, and one large performance defect nobody had measured.

---

## 1. The launch gains are holding, and August is the best month since February

Clicks per day from the daily chart, the only series safe to read across the whole window:

| Month | Clicks/day | Month | Clicks/day |
| --- | --- | --- | --- |
| 2025-09 | 19.7 | 2026-03 | 18.7 |
| 2025-10 | 20.4 | 2026-04 | 15.7 |
| 2025-11 | 18.4 | 2026-05 | 14.1 |
| 2025-12 | 12.0 | 2026-06 | 14.2 |
| 2026-01 | 22.4 | 2026-07 | 16.6 |
| 2026-02 | 21.5 | **2026-08 (15d)** | **18.1** |

Post-launch, week by week:

| Week | Clicks/day | CTR | Position |
| --- | --- | --- | --- |
| W1 05–11 Jul | 15.9 | 0.347% | 24.5 |
| W2 12–18 Jul | 16.1 | 0.375% | 23.7 |
| W3 19–25 Jul | 19.1 | 0.470% | 22.6 |
| W4 26 Jul–01 Aug | 17.0 | 0.421% | 22.7 |
| W5 02–08 Aug | 17.6 | 0.414% | 22.5 |
| **W6 09–15 Aug** | **19.4** | 0.416% | 22.8 |

Six full weeks of new site against the five weeks before launch:

| | Pre-launch (1 Jun–4 Jul) | New site (5 Jul–15 Aug) | Change |
| --- | --- | --- | --- |
| Clicks/day | 14.0 | **17.5** | +25% |
| CTR | 0.321% | **0.406%** | +26% |
| Impressions/day | 4,357 | 4,319 | −1% |
| Position | 23.8 | 23.1 | +0.7 |

The 5 August audit called this on 30 days of data and said two weeks was a signal, not a verdict. Twelve more days have gone by and it has not decayed: W6 is the best week of the entire post-launch period, and the shape is unchanged — **impressions flat, CTR up a quarter**. That is a titles-and-metadata win, and it is now a verdict rather than a signal.

Two things to keep honest about it:

- **It is a recovery, not a new high.** January ran at 22.4 clicks/day. The site fell every month to a June trough of 14.2 and has clawed back about half of that. The only year-on-year overlap this export allows is mid-August, and it is slightly down (20.2/day in late Aug 2025 against 18.1/day so far in Aug 2026).
- **Mobile is still the better half.** Mobile takes 3,381 clicks from 748,629 impressions at 0.45% and position 14.7; desktop spends 1,088,091 impressions to return 2,935 clicks at 0.27% and position 27.6. See §3 and §6 — both of those numbers matter more than they look.

---

## 2. This export cannot answer the question it was pulled to answer

`SEO-AUDIT-AUG-2026.md` §5 set the measurement rule: *"Re-export GSC monthly, filtered to post-2026-07-05 date ranges for the new site, and UK-only when judging local performance. Never quote a number that spans 12 Sep 2025."* It also set the headline KPI: **local commercial clicks per quarter.**

This export is **Last 12 months, unfiltered**. That breaks the rule twice:

1. It contains **27 days of pre-`num=100` data** (16 Aug – 11 Sep 2025): 190,611 impressions at position 35.9, which is **10.3% of the window's impressions** and all of it inflated bot debris. Every position in `Queries.csv` and `Pages.csv` is therefore roughly 1.5 places pessimistic, and every impression count is a ceiling.
2. The query and page tables have no date dimension, so **the quarterly KPI cannot be computed from this file at all.** Eleven months of it are the old site.

This is not a criticism of the pull, it is the single most useful correction available: the next export should be **Custom range 2026-07-05 → today, Country = United Kingdom**, and the one after it the same. Two of those, a month apart, answer more than a year of unfiltered data.

What can still be read from this file: the daily chart (§1), the structure of demand (§3, §7), and anything checked live (§5, §6).

---

## 3. A meaningful share of these impressions are not people

This is new, and it changes how the town matrix should be judged.

Ninety-two queries in the top-1000 sit at **position 12 or better with literally zero clicks**, carrying 57,480 impressions — 6.8% of all named-query impressions. Fifty-three of them contain a town or county name. A sample:

| Query | Position | Impressions | Impr/day | Clicks |
| --- | --- | --- | --- | --- |
| roof lights milton keynes | 2.1 | 714 | 1.96 | 0 |
| upvc casement windows in milton keynes | 2.2 | 506 | 1.39 | 0 |
| aluminium windows in milton keynes | 2.8 | 544 | 1.49 | 0 |
| upvc wood effect windows in milton keynes | 3.2 | 486 | 1.33 | 0 |
| northampton bay windows | 3.5 | 924 | 2.53 | 0 |
| upvc roofline installation milton keynes | 4.4 | 537 | 1.47 | 0 |
| northampton tilt and turn windows | 4.6 | 980 | 2.68 | 0 |
| tilt & turn windows northampton | 5.2 | 547 | 1.50 | 0 |
| northampton sliding sash windows | 5.5 | 984 | 2.70 | 0 |
| roof lights northampton | 8.0 | 2,220 | 6.08 | 0 |

At position 3 a page normally takes something like 10% of clicks. Nine hundred impressions at position 3.5 should return fifty to a hundred clicks. It returned none, and it returned none while running at a flat two-and-a-half impressions a day, every day, for a year.

Four things point the same way:

- **The rate is flat and small.** Human demand for a phrase like *upvc wood effect windows in milton keynes* is lumpy and near zero; it is not 1.33 a day for 365 days.
- **The phrasing is generated, not spoken.** Both word orders are present (`northampton tilt and turn windows` and `tilt and turn windows northampton`), and the `X in <town>` construction runs across twenty queries — 10,834 impressions and 2 clicks between them. That is a keyword matrix someone built, not a way people type.
- **It is desktop-shaped.** Desktop carries 58.5% of impressions and 45.4% of clicks at position 27.6, against mobile's 14.7. Rank-checking tools emulate desktop.
- **It survives `num=100` exactly as you would predict.** Killing that parameter in September 2025 removed synthetic impressions at depth 20–100. What is left is tools checking page one only — which is precisely where this cluster sits.

Some of it is Fenster's own tracker: eleven of the 100 tracked keywords have zero GSC clicks in twelve months at a median 2.4 impressions/day. The rest is somebody else's.

**GSC cannot prove this, so treat it as a strong reading rather than a fact.** The consequences are practical either way:

- **Judge the town matrix on clicks, never on impressions or CTR.** `SEO-LEAD-AUDIT-2026-08-05.md` F3 measured 342 town URLs at 0.118% CTR and read it as "visible but not clicked". Part of that visibility was never human, so the denominator is wrong. The matrix reaches fewer real people than the impression count implies — which makes the "impression-only asset" verdict *more* right, not less.
- **Stop chasing snippet fixes for zero-click top-10 rankings.** `SEO-AUDIT-AUG-2026.md` §5 made "verify roof lights appears in on-page copy" the first code action, on the strength of ~4,400 impressions at positions 1.8 and 6.7. Checked live today: the phrase is now in both titles and both meta descriptions, appears once or twice in body copy, and in **zero H2s** — and it has still earned zero clicks. Adding it to an H2 will not change that, because there is most likely nobody there. **Close the item; do not do the work.**

---

## 4. The rank tracker turned down, and it disagrees with the clicks

The tool's own summary moved from **28 up / 25 down / 47 unchanged** on 5 August to **25 up / 34 down / 41 unchanged** today. Diffing the two exports keyword by keyword over those twelve days:

**17 improved · 27 declined · 32 unchanged · 3 fell out of the top 100.**

Position distribution today: 26 keywords at 1–3, 32 at 4–10, 9 at 11–20, 11 at 21–50, 1 at 51–100, **21 not ranking**. Fifty-eight of 100 in the top ten is a genuinely strong sheet.

Biggest falls, and the three that vanished:

| Keyword | 5 Aug | 17 Aug |
| --- | --- | --- |
| sash windows milton keynes | 7 | 35 |
| glass replacement milton keynes | 18 | 31 |
| what are integral blinds | 2 | 10 |
| double glazing hitchin | 9 | **not ranking** |
| curtain walling milton keynes | 10 | **not ranking** |
| double glazing northampton | 17 | **not ranking** |

Biggest gains: `shopfront glazing milton keynes` 36 → 14, `front doors milton keynes` 37 → 15, `aluminium bifold doors milton keynes` 11 → 3, `french doors milton keynes` 11 → 3.

**Do not act on this.** The 5 August audit already established the rule — the tracker is desktop, single-sample, MK-localised, and its individual rows contradict GSC routinely. This export proves the rule again: `front doors milton keynes` is the same keyword that "collapsed" 33 places last time and has now "recovered" 22, while GSC has had it sitting quietly at position 10.1 the whole time. All three pages that "fell out" return HTTP 200, are in the sitemap, carry self-referencing canonicals and hold real GSC impressions (`/double-glazing-hitchin/` at position 16.1, `/curtain-walling/` at 25.4, `/double-glazing-northampton/` at 30.0). Nothing is broken.

The honest summary is that **tracked rankings drifted down over twelve days while actual clicks hit their post-launch high**. When the two disagree, the clicks are the business.

One thing in it is worth keeping: Hitchin is the site's best town by a distance — 12 queries, 68 clicks from 6,114 impressions, **1.11% CTR**, against Milton Keynes' 0.21% and Northampton's 0.03%. Whatever is different about Hitchin (`bifold door installation hitchin` alone converts at 23.2%) is worth understanding before more effort goes into Northampton.

---

## 5. The price guides, finally diagnosed: three of the seven have no prices on them

`SEO-LEAD-AUDIT-2026-08-05.md` F4 recorded 15 impressions and 1 click and called it "absence", and asked for an indexation or authority diagnosis before more price content was written. Twelve months of data now shows **21 impressions and 1 click** across the four that register at all; three do not appear in the page table whatsoever.

It is not indexation. All seven return 200, sit in the 715-URL sitemap, carry unique titles and descriptions, self-referencing canonicals, no `noindex`, and 740–960 words. Fetched and parsed live today:

| Page | Distinct £ figures | Worked examples | Words |
| --- | --- | --- | --- |
| /window-door-prices-milton-keynes/ | 3 | 3 | 955 |
| /composite-door-prices/ | 1 | 1 | 813 |
| /bifold-door-cost/ | 1 | 1 | 819 |
| /double-glazing-cost/ | 1 | 1 | 819 |
| **/sash-window-prices/** | **0** | **0** | 746 |
| **/aluminium-window-prices/** | **0** | **0** | 743 |
| **/patio-french-door-prices/** | **0** | **0** | 749 |

The entire price programme rests on **three real fitted figures** — £600, £2,000 and £3,500 — and the hub page holds all three. Four product pages split one each between them and three have none at all.

Worse than the ranking problem, there is an accuracy problem. `/sash-window-prices/` carries this FAQ, live right now:

> *Are the prices on this page real? Yes. Each checked example is a real fitted price from our pricing software for the exact specification shown, including VAT.*

There are no checked examples on that page and no prices. The same block is on the other two price-free pages. A page that promises prices, answers a question about its prices, and shows none is not going to rank for a price query, and it should not be live in that state regardless of ranking. This is the same class of fault the repository already has rules about, arriving from the opposite direction: not an invented figure, but an assertion with no figure behind it.

Second, and cheaper: **the pricing hub does not link to the price guides.** `/instant-pricing/` — 209 clicks and 28,921 impressions in this window — 301s to `/online-quote/`, and `/online-quote/` links to none of the seven. Nor does the homepage. The only routes in are the four product pages and `/windows-milton-keynes/`.

**Before any of this is fixed, there is a commercial question the owner should answer.** The Google Ads record is that price and cost keywords were where £4,218 of £6,979 lifetime spend went, for five conversions, and the standing rule from that is not to buy them. These seven pages are the same intent pursued organically. Organic clicks are free, so the economics are genuinely different and the pages may still be worth having — but "our price traffic does not convert" is evidence in hand, and it should be weighed before more effort goes in. Putting the missing three prices on the three empty pages is worth doing either way, because the pages currently make a claim that is not true.

---

## 6. Two thirds of the mobile homepage is a picture of a cat

This is the largest measured defect in the check and nobody had looked at it. Loaded live at a 375×812 viewport:

| | |
| --- | --- |
| Total transfer | **3,130 KB** |
| Images | 2,628 KB of it |
| `legend-spritesheet.webp` | **1,996 KB — 63.8% of the entire page** |
| `legend-sleep-strip.webp` | 122 KB |
| **Legend's two sprites together** | **2,118 KB — 67.7% of the page** |
| Everything else | ~1,012 KB |

The spritesheet is 1536×2288, `alt=""`, and it is emitted twice per page from `template-parts/components/legend-assistant.php` — once inside the hidden chat panel (line 47) and once inside the always-visible launcher button (line 125). Neither carries `loading="lazy"`. It is on **every page on the site**: checked and confirmed on the homepage, `/composite-doors/`, `/curtain-walling/`, `/contact/`, `/double-glazing-hitchin/`, `/sash-window-prices/` and `/3d-visualiser/`.

In the trace it starts at 174 ms and does not finish until 801 ms, holding the connection for 627 ms and gating the load event at 814 ms — on a fast desktop connection. On 4G that becomes seconds, and mobile is 52% of the site's clicks.

Nothing is wrong with having Legend. Two megabytes downloaded before anyone has asked to chat, on all 715 pages, is the fault. The launcher renders the sprite at roughly 64px.

**The related parked item, `srcset`, turns out to be half done.** `/composite-doors/` ships 73 responsive images with proper `sizes`; the homepage and `/windows-milton-keynes/` ship **zero**, so a phone downloads the full desktop file every time — `S1-Lantern-Kitchen-A-min-scaled.jpg` is declared at 2560px wide and weighs 451 KB. The work was done for the composite-door image set and never extended.

Also cheap and daft: `google-5-stars.png` (103 KB) and `constructionline-gold-member.png` (102 KB) are trust badges declared at 2797×1244, and the homepage serves 17 PNGs where photographs should be WebP.

Everything else on the performance side is genuinely healthy — TTFB 0.10 s on the homepage and 0.30–0.54 s on inner pages, 24 requests, 25 KB of HTML, no render-blocking CSS, fonts preloaded, CLS 0, schema clean (`HomeAndConstructionBusiness`, `WebSite`, `BreadcrumbList`, `FAQPage`, `Service`, and still **no `aggregateRating` or `Review` anywhere**, exactly as required).

---

## 7. Where the revenue engine actually stands

Classifying the top-1000 queries by intent, and running the identical classifier over the 5 August three-month export for comparison:

| Class | 12 months | | | Last quarter (05-04 → 08-03) |
| --- | --- | --- | --- | --- |
| | clicks | share | CTR | share |
| brand | 853 | 38.3% | 10.78% | **47.9%** |
| product, no location | 780 | 35.1% | 0.15% | 30.8% |
| **local commercial** | **342** | **15.4%** | **0.171%** | **12.4%** |
| informational | 196 | 8.8% | 0.211% | 7.7% |
| foreign-language | 54 | 2.4% | 0.208% | 1.3% |

Both exports name about a third of total clicks (34.4% and 33.5%), so the shares are comparable.

Local commercial clicks, normalised to a 91-day quarter:

- Earlier nine months of the window: **~95 per quarter**
- Trailing twelve months: **~85 per quarter**
- Most recent quarter (04 May – 03 Aug): **57**

That reads as a decline, and **it should not be read as one**. Sixty-two of those 92 days are the old site, so the recent quarter is mostly pre-launch and mostly the 2026 trough. What it does say is that the local commercial engine has not yet demonstrably recovered, and that **brand share is rising** (47.9% against 38.3%) — meaning the post-launch CTR gain is landing disproportionately on people already searching for Fenster by name, not on new in-area buyers.

The one number that settles it does not exist yet. It needs the date-filtered export from §2.

> **This section under-reads the informational engine. See §11**, added after the owner corrected the record: the seasonal blog went live on 3 August and has already produced a lead, and fault-shaped informational queries behave nothing like the definitional ones described here.

Structurally nothing else has moved. 62.7% of clicks are UK, 2,412 clicks (37.3%) are overseas and almost all informational. `/what-is-a-door-lintel/` alone takes 1,631 clicks from 373,477 impressions. `/what-are-double-glazed-glass-windows/` remains the worst asset on the site at **124,933 impressions and 61 clicks (0.049%)**, flagged in three prior audits and still untouched; `/what-is-double-glazing-and-how-does-it-work/` is beside it at 101,238 and 57. `/consider-energy-efficient-windows-for-your-home/` returns 35,137 impressions and **zero** clicks at position 53.

Two structural bits of dead weight worth a decision rather than a fix: the **national commercial county pages** — 47 URLs in the sitemap covering Sheffield, Leeds, Cornwall, Cumbria, Merseyside and the rest — returned **14 clicks from 9,187 impressions in twelve months** and describe a service area Fenster does not work in; and `/videos/` holds 13,317 impressions for 2 clicks.

---

## 8. Standing items from the prior audits — status today

| Item | Source | Status |
| --- | --- | --- |
| Titles/metadata rewrite pays off | `SEO-AUDIT.md`, predicted Jul | **Confirmed and closed.** +25% clicks/day, +26% CTR, flat impressions, six weeks |
| "roof lights" in on-page copy | `SEO-AUDIT-AUG-2026.md` §5 code #1 | **Close without doing.** In titles and metas; the impressions are not human (§3) |
| Commercial hub snippet pass | `SEO-AUDIT-AUG-2026.md` §5 code #2 | **Done** in the 12 Aug rebuild. Hub now titled *Commercial Glazing Contractors \| Our Own Fitters* |
| Responsive images (`srcset`) | `SEO-AUDIT.md` F8, parked | **Half done.** Composite doors yes; homepage and town hubs no (§6) |
| Price guides invisible | `SEO-LEAD-AUDIT-2026-08-05.md` F4 | **Diagnosed** (§5). Not indexation — three of seven have no prices |
| Town matrix not working | `SEO-LEAD-AUDIT-2026-08-05.md` F3 | **Unchanged, and the metric was wrong** (§3). Judge on clicks only |
| No self-serving `aggregateRating` | `HIGH-INTENT-SEARCH-PLAN.md` | **Holding.** Verified clean on three routes today |
| Quote-tool commitment gap (11.5% open) | `SEO-LEAD-AUDIT-2026-08-05.md` P1 | **Still the biggest conversion item.** Not measurable from these two files |
| Google Ads UTM tagging | `SEO-LEAD-AUDIT-2026-08-05.md` P2 | Not visible in these files; check the dashboard |
| Lead outcomes recording | `SEO-LEAD-AUDIT-2026-08-05.md` P3 | Not visible in these files; owner/office |
| Commercial spec figures ×5, photography | `COMMERCIAL-AUDIT-2026-08-12.md` §6 | Owner-held, unchanged |

---

## 9. What to do, in order

**Code, and short.**

1. **Defer Legend's spritesheet.** Two megabytes on every page for a chat nobody has opened. Load the sprite when the launcher is first interacted with, or ship a small launcher-sized image and fetch the full sheet on open. This is a single component file and it is worth more than every other technical item on this list combined, because it lands on all 715 pages and on the 52% of clicks that are mobile.
2. **Put prices on the three price pages that have none**, or remove the "Are the prices on this page real? Yes" block from them until there are. `/sash-window-prices/`, `/aluminium-window-prices/`, `/patio-french-door-prices/`. The page currently answers a question about content it does not have.
3. **Link the price guides from `/online-quote/`.** The site's pricing destination links to none of them.
4. **Extend `srcset` to the homepage and the town hubs**, the same way it was already done for the composite-door set, and re-encode the trust badges and the 17 homepage PNGs.

**Owner decisions, each a yes or no.**

5. **Are the price guides worth continuing at all?** The paid record says price intent does not convert for Fenster. Item 2 should happen regardless because the pages make an untrue claim; item 3 and anything beyond it depends on this answer.
6. **The 47 national commercial county pages.** Sheffield, Leeds, Cornwall, Cumbria and the rest — 14 clicks in a year, for places Fenster does not serve. Keep, trim or redirect.
7. Unchanged and still the long pole: reviews with product names, citations, job photography, and the five commercial specification figures in `COMMERCIAL-AUDIT-2026-08-12.md` §6b.

**Measurement, and this one gates the next audit.**

8. **Pull GSC as Custom range 2026-07-05 → today, Country = United Kingdom.** Not "last 12 months". That single change makes the KPI computable for the first time since it was set on 3 August. **And change the KPI itself** — see §11.2; local commercial clicks per quarter cannot see a blog lead.
9. **Report clicks, not impressions or CTR, for anything town-shaped.** §3 is the reason.
10. Keep the rank tracker, read only its aggregate direction, and never plan work off one row of it. It has now produced a false alarm on the same keyword twice.

**Do not do:** the roof-lights H2 work; any further town matrix expansion; anything to the titles shipped in July; any new price content before item 5 is answered.

---

## 10. Summary

The launch verdict is in and it is good: six weeks on, clicks per day are up 25% and CTR up 26% on flat impressions, and the best week of the whole period is the most recent one. August is the strongest month since February. That gain is real, it is made of titles and metadata, and it is holding.

Three things this check adds. **A material share of the impressions the town matrix has been judged on were never human** — ninety-two queries sit at position 12 or better with zero clicks and a flat one-to-three impressions a day, which is what rank-checking looks like, and it means one of the previously scheduled code jobs should be cancelled rather than done. **The price guides are not an indexation problem** — three of the seven have no price on them at all while telling the reader their prices are real. And **two thirds of the mobile homepage is a two-megabyte cat**, loaded on every page of the site before anyone has asked for a chat.

The rank tracker drifted down over the same twelve days that produced the site's best click week since launch. That disagreement is not a mystery; it is the tracker, and the clicks are the business.

What has still not changed since 5 August is the thing that matters most: 88.5% of the people shown the quote tool never open it. Nothing in either of these two files touches that, and nothing in this list will move it.

---

## 11. Addendum, same day: the blog, and a correction to §7

Added after the owner pointed out that the seasonal blog had already produced a lead. Both of the things in this section were missed by the audit above, and the second was actively got wrong.

### 11.1 Fault queries are not the informational traffic described in §7

`/why-bifold-doors-stick-in-hot-weather/` went live on **3 August 2026** — twelve days before this export ends — and produced a real residential enquiry on **16 August**, recorded against source *"Blog: Why bifold doors stick in hot weather"*.

§7 grouped all informational traffic into one bucket and dismissed it on the evidence of the lintel article: global, definitional, 0.211% CTR, converts nobody. That reading does not survive contact with a fault query, and the two are different species:

| | Definitional (`what is a door lintel`) | Fault (`why bifold doors stick in hot weather`) |
| --- | --- | --- |
| Searcher | anyone, anywhere | someone who owns it, and it is failing now |
| Geography | 37% of site clicks are overseas | necessarily local, it needs a person to attend |
| AI Overview exposure | high, it is a one-paragraph answer | low, the answer ends in "get someone to look at it" |
| Commercial intent | none | immediate |

The evidence was already in this export and §7 walked past it: **`how to soundproof windows` is the best non-brand informational earner on the site** — 19 clicks at position 13.2 — and it is a problem query, not a definition.

**What is loaded:** 52 posts, written, validated and self-publishing every Monday to 26 July 2027 (`inc/blog-posts.php`, calendar generated from the data in `BLOG-CALENDAR.md`). **Fourteen are fault posts** — sticking bifolds, sticking uPVC doors, misted units, draughts, three condensation variants, frozen locks, storm damage, black mould, cold snap. **Sixteen route to `/window-and-door-repairs/`**, a page currently at position 30.8 on 26,849 impressions in a category with little serious local competition.

This matters more than anything else in the audit for one reason: **it is the only item on the board that creates new impressions.** §1 and §2 establish that impressions have been flat at ~4,350/day for five months and that the CTR lever is spent. Every other recommendation here redistributes existing visibility. The blog makes more of it, it is already written, and it requires nobody to do anything further.

Sizing it against this site's own matured articles (frame materials 185 clicks/yr, history of uPVC 130, soundproofing 105 — so roughly 6–15 clicks/month each once settled): if 25–30 of the 52 mature to that, it is **+5 to +9 clicks/day by August 2027**, back-loaded, since the final post publishes in July 2027. Total clicks therefore move less than the effort suggests, especially net of AI Overview erosion on the lintel cluster. **The composition changes far more than the total**, and that is the point: today 37% of clicks are overseas and 38–48% are brand, while blog clicks are UK, non-brand and warm.

### 11.2 The KPI set in §9 would have scored this lead as zero

`SEO-AUDIT-AUG-2026.md` made **local commercial clicks per quarter** the headline KPI, and §9 item 8 of this document carried it forward. That KPI counts queries containing a town name. `why bifold doors stick in hot weather` contains none, so the first blog lead is invisible to it.

**Replace it.** The measure should be UK non-brand clicks, and beneath that, leads by source — which the site already records (§11.3). Keep local commercial clicks as a secondary; it still measures the town matrix, which is what it was built for.

### 11.3 Correction: the lead loop is fully built, and this audit implied otherwise

An earlier draft of the recommendations said entry-page attribution needed wiring before the autumn posts landed, reasoning from the 5 August observation that D1's `website_lead_outcomes` held one row. **That was wrong, and it conflated two different systems.** `inc/enquiries.php` records on every enquiry:

| Field | What it holds |
| --- | --- |
| `_fenster_source` | the originating page, shown in the admin Source column |
| `_fenster_page_url` | the full URL |
| `_fenster_journey_ref` | link to the tracked journey |
| `_fenster_visitor_id` | the anonymous visitor |
| `_fenster_ad_click_id` / `_fenster_ad_click_type` / `_fenster_ads_tracker` | paid attribution |
| `_fenster_outcome_status` | new → contacted → qualified → appointment → won → lost |
| `_fenster_outcome_value` | won value in £ |

Saving an outcome calls `fenster_dashboard_track_outcome()` into the Marketing Dashboard, and a `won` fires a Meta `Purchase` event. Source, journey, outcome, value and offline-conversion eligibility are all in place.

**Nothing needs building.** The 5 August finding was that the office had not been setting outcome statuses, which is a usage question, not an architecture gap — and the only thing worth checking is whether that has changed since. The blog's attribution question is already answered by the Source column.
