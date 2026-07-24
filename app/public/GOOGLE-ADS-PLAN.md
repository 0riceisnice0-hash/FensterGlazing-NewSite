# Fenster Glazing — Google Ads Rebuild Plan

Date: 2026-07-24
Budget: £1,000/month. Goal: high-intent Milton Keynes leads that become jobs.
Evidence: the full 2018–2026 Google Ads account export (Overview cards CSVs, 24 Jul), all project docs (`HIGH-INTENT-SEARCH-PLAN.md`, `SEO-AUDIT.md`, `ACTION-PLAN.md`, `LAUNCH-WEEK-REPORT.md`, `AUDIT.md`, `TONEOFVOICE.md`), live SERP checks run from Milton Keynes on 24 Jul, the live price-guide pages, and the theme code.

Read alongside `HIGH-INTENT-SEARCH-PLAN.md` — this is the paid half of the same fight. The organic plan concluded the map pack is a slow authority grind; ads are the only fast route to the top of the page, and the SERP checks below show that slot is cheaper than it should be.

---

## 1. The autopsy: why last year's £7,158 bought zero jobs

The account ran one campaign, **"BOF [2026 Edit] Instant pricing"**: £7,157.98, 3,867 clicks, and **5.00 recorded conversions** across its whole life (Q2 2025 – Q2 2026). Every failure below is visible in the export.

### 1a. Every single keyword was broad match

All 50 keywords in the account are broad match. That let Google expand "upvc windows quote" into whatever it liked, and the search-terms report shows where the money actually went:

| Where it leaked | Evidence from the actual search terms | Rough cost |
| --- | --- | --- |
| **DIY / supply-only buyers** | "buy upvc window online", "sealed units online", "doors for sale", "upvc front doors supplied and fitted", "glass cut to size near me", "glass suppliers near me" | £200+ visible, far more implied — the keywords themselves ("buy aluminium bifold doors" £673, "buy upvc window online" £202, "sliding door price online" £480) *targeted* this intent |
| **Internal doors** — not even the trade | "internal doors with glass", "sliding doors internal", "internal sliding doors", "bedroom doors", "interior doors", "howdens doors" £48, "wickes doors" £22, "b&q doors" | £150+ |
| **Competitor and supplier brands** | eurocell (£15), crown windows, city glass, apex windows luton, ak windows luton, green doors luton, unicorn windows leighton buzzard, solidor, endurance, cloudy2clear, first home improvements | £75+ |
| **Your own brand** | "fenster glazing" £48 + "fenster" £23 — traffic you already get free at organic #1 with sitelinks | £71 |
| **Wrong products** | velux windows (£10), crittall, secondary/trade glass, "types of windows" homework queries | £50+ |
| **Wrong geography** | Luton (£24), Stevenage, Bicester (£15), Aylesbury, Ampthill, Flitwick, Northampton glass | £75+ visible |

Not one search term in the export has a recorded conversion. The five conversions the account ever saw were invisible noise against £7,158.

### 1b. Display and Search Partners were on

467 Display clicks at £0.24 and 575 Search Partner clicks at £0.82 — over £580 on the two lowest-intent sources Google sells. Q2 2026's whole spend (£289 at £0.40 CPC) looks like the campaign degraded into display junk before being paused.

### 1c. Ads ran to a nocturnal, national audience

~8,400 impressions between midnight and 6am (about 15% of all impressions). Combined with broad match and no visible geo discipline, the ads were serving the whole country's insomniac window browsing.

### 1d. Google was blind, so it optimised toward nothing

5 conversions on 3,867 clicks means conversion tracking effectively did not exist. The theme confirms it today: **there is not a single `dataLayer` push, gtag call or Ads conversion tag anywhere in the theme**. Smart bidding had no signal, so it chased clicks. The 30 leads you counted arrived through channels Google couldn't see — so it kept buying the clicks that *didn't* produce them.

### 1e. Why the ~30 leads never became jobs

The keyword set answers this. "Buy X online", "price online", "supplied and fitted" + national reach = **supply-only price checkers and DIYers**, plus out-of-area enquiries you could never survey. The campaign's own name says it: BOF (bottom of funnel) "instant pricing" with no geographic qualifier is a magnet for people who want a number, not an installer. The failure was targeting, not the sales team and not the tool.

**The one genuine positive:** CTRs were strong (8–11% on the quote keywords, 26.9% on "window installers milton keynes") and the blended search CPC was £2.33. The ads and the offer work. The money was simply pointed at the wrong people, and nothing measured the difference.

---

## 2. The market today (SERPs checked from Milton Keynes, 24 Jul 2026)

**"double glazing milton keynes"** — ads: Anglian (national), Safestyle (national), Everest (national), Dunster House (**explicitly DIY supply-only**), and Dovista (new MK showroom on South Row, buying a sponsored map slot). Fenster is **#2 in the organic map pack** on this query. Not one established local installer is buying search ads.

**"composite doors milton keynes"** — ads: Dunster (DIY), Anglian, Everest, Hinson (joinery supplier, Hanslope), and Park Lane Windows (Northampton) buying a sponsored map slot. Fenster ranks organically bottom of page 1.

**"double glazing prices milton keynes"** — ads: only two lead-gen aggregators (WindowCosts.co.uk, LocalWindowPrices.co.uk) reselling enquiries to installers. Aspire owns organic with their exact-match domain.

What this means:

1. **The paid competition on MK-local terms is weak.** Nationals with poor local relevance, a DIY seller, and aggregators. A local advertiser with an MK address, 4.9★ (133), real fitted prices and MK-specific landing pages should win the quality-score fight and pay less per click than any of them.
2. **Price-intent terms are wide open.** The searches with the highest buying intent are being answered by aggregators, while Fenster is the only local firm that actually publishes fitted prices (£600 window / £2,000 composite door / £3,500 bifold, checked WindowCAD figures, live on the seven price-guide routes).
3. **Ads patch your two measured organic holes**: absent from organic page 1 on "double glazing milton keynes" and "windows milton keynes" (GSC positions 16.1 / 31.5), and absent from the map pack on the door terms. Paid presence covers exactly the gap the organic plan says will take quarters to close.
4. Dovista's arrival (new showroom + sponsored placements) means the quiet local ad market may not stay quiet. Being first matters.
5. **Crown (checked 24 Jul via both ad libraries):** on Google, Crown Conservatories Windows and Doors Ltd has 41 lifetime ads, 9 active in the last 30 days, all Text format, last shown 23–24 Jul — yet they surfaced on none of four MK SERPs checked (double glazing, composite doors, prices, even conservatories), so their search spend is light, narrow or heavily dayparted. Their real paid channel is **Meta**: ~35 active ads, video-led, a fresh wave launched 14 Jul with town-split variants for Bicester, Aylesbury, Buckingham and Leighton Buzzard, "Book Your FREE Quote" CTA, 10-year guarantee, and a celebrity install (Zoe Birkett). Two implications: the MK search auction remains effectively uncontested by locals, and Crown is pushing awareness into Fenster's Tier 2 ring towns via Meta rather than fighting on search intent.

---

## 3. Prerequisite: conversion tracking (do not spend £1 before this)

This is the entire difference between this year and last year. Build the measurement first.

### 3a. Define these conversions in Google Ads

| Conversion | Type | Counts as | Value |
| --- | --- | --- | --- |
| Enquiry form submitted | Primary | One per lead | £40 placeholder |
| Phone call click (mobile) + calls from ads ≥60s (Google forwarding number) | Primary | One per lead | £40 |
| WindowCAD quote completed | Primary | One per lead | £25 |
| Consultation booked | Primary | One per lead | £60 |
| **Qualified lead / job won (offline import)** | Primary once volume exists | See 3c | Real job value |

### 3b. Implementation (theme + GTM) — corrected 2026-07-24 after a full tracker audit

The tracker is further along than this plan first credited. For **consented** visitors, `trackWebsiteEvent()` in `src/js/main.js` already pushes every event to `window.dataLayer` as `fenster_*` events — `fenster_phone_click`, `fenster_quote_opened`, `fenster_form_started`, `fenster_cta_click`, `fenster_page_view` all exist today. GTM can trigger Ads conversion tags on those with zero theme changes.

Four real gaps remain:

1. **The form-submit conversion never reaches the browser.** On success, consented submissions are relayed server-side to the dashboard (`inc/enquiries.php:544`); the JS success handler (`src/js/main.js:~2152`) only fires an aggregate stat for *non*-consented users. So GTM cannot see the single most important conversion. Fix: one `dataLayer.push({event: 'fenster_form_submitted', ...})` in the AJAX success block — a plain push, **not** `trackWebsiteEvent()`, which would double-count `form_submitted` in the dashboard.
2. **GTM only exists after Accept.** `inc/consent.php` loads gtm.js post-acceptance with no Google Consent Mode defaults, so conversions from reject/no-choice visitors are invisible and unmodelled. Minimum path: accept the undercount and size it from the dashboard's consent accept/reject counters. Full path: Consent Mode v2 with denied-state pings — an architecture change to a deliberately strict consent layer, so it is an owner decision, not a default.
3. **No gclid capture.** Needed for offline conversion import (3c). Hidden field on the enquiry form → `fenster_enquiry` post meta. The tracker's first-touch context stores UTMs only, and Google auto-tagging uses gclid, not UTMs — so also add manual UTMs to all ads via the account tracking template (`utm_source=google&utm_medium=cpc&utm_campaign={campaignid}`) or the dashboard will file ad clicks as organic Google.
4. **WindowCAD completions are dashboard-only** (`inc/adminbase.php:309`). Use `fenster_quote_opened` as a secondary conversion now; feed completions to Google later via offline import when they become jobs.

- Calls from ads need Google forwarding numbers (account-side setting, no site change); `fenster_phone_click` already covers dial-taps by consented visitors.
- **Privacy boundary (already documented, keep it):** ad click IDs never enter the Marketing Dashboard. Everything here lives in Google's tags and WordPress only.

### 3c. Capture the GCLID and close the loop — the real fix for "leads that never convert"

Add a hidden `gclid` field to the shared enquiry form (populated from the URL/cookie by `main.js`) and store it as meta on the `fenster_enquiry` post. WindowCAD journeys already carry attribution. Then, monthly, mark which leads became surveys and jobs and **import those as offline conversions with real values**. Once ~30 qualified-lead conversions exist, bidding switches to optimising toward *people who become jobs* — the thing last year's campaign structurally couldn't do. WordPress/AdminBase hold the personal data as they already do; Google only receives "this click became a £6,000 job".

### 3d. Lead handling standard

Speed decides close rate on glazing leads. Standard: called back within 15 minutes in office hours; the (real, verified) 24/7 answering service takes evenings; every ad lead gets a disposition recorded (no answer / not our area / supply-only / survey booked / quoted / won). Without dispositions, section 8's measurement loop can't run.

---

## 4. Account structure

Search only. **Display OFF. Search Partners OFF.** One shared negative list. Location: **Presence** (people *in* the targeted area, never "interested in"). Geo: Milton Keynes plus roughly the Tier 1/Tier 2 ring from the search plan — MK postcodes, Newport Pagnell, Woburn Sands, Leighton Buzzard, Buckingham; exclude Northampton, Luton, Stevenage, Bedford town (the far ring the organic plan already wrote off). Ad schedule 7am–10pm to start. Language English. **Auto-apply recommendations OFF, and never accept a Google rep's "optimisation call".**

Three campaigns so budget can be steered by intent:

### Campaign 1 — MK Windows (~£12/day)

| Ad group | Keywords (phrase + exact) | Landing page |
| --- | --- | --- |
| Double glazing MK | "double glazing milton keynes", "double glazing companies milton keynes", "double glazing installers milton keynes", "double glazing quote milton keynes" | `/double-glazing-milton-keynes/` |
| Replacement windows MK | "replacement windows milton keynes", "new windows milton keynes", "window installers milton keynes", "window fitters milton keynes", "window companies milton keynes" | `/windows-milton-keynes/` |
| uPVC windows MK | "upvc windows milton keynes", "upvc windows fitted milton keynes", "casement windows milton keynes" | `/casement-windows/` |
| Aluminium windows MK | "aluminium windows milton keynes" | `/aluminium-windows/` |
| Sash windows MK | "sash windows milton keynes", "sliding sash windows milton keynes" | `/sliding-sash-windows/` |

GSC says these carry real volume: double glazing MK 1,742 impressions/qtr, upvc windows MK 882, replacement windows MK 578, aluminium windows MK 521, casement windows MK 363, window installer MK 353.

### Campaign 2 — MK Doors (~£12/day)

| Ad group | Keywords | Landing page |
| --- | --- | --- |
| Composite / front doors MK | "composite doors milton keynes", "front doors milton keynes", "composite front door fitted milton keynes", "new front door milton keynes" | `/composite-doors/` |
| Bifold doors MK | "bifold doors milton keynes", "aluminium bifold doors milton keynes", "bifold doors fitted milton keynes" | `/aluminium-bifold-doors/` |
| Patio / sliding doors MK | "patio doors milton keynes", "sliding doors milton keynes", "french doors milton keynes" | `/patio-doors/` |
| uPVC doors MK | "upvc doors milton keynes", "upvc back door milton keynes" | `/upvc-doors/` |

GSC volume: composite doors MK 813, front doors MK 619, bifold doors MK 508.

Doors deserve half the account: single-item jobs (£2,000–£3,500 fitted), shorter decision cycles than whole-house window jobs, and the £5,000 break-in guarantee plus the rebuilt `/composite-doors/` page (which deliberately carries the price anchor and seven lead routes) make it the strongest converting surface on the site.

### Campaign 3 — Price intent (~£9/day)

| Ad group | Keywords | Landing page |
| --- | --- | --- |
| Double glazing prices | "double glazing prices milton keynes", "double glazing cost milton keynes", "window prices milton keynes", "how much are new windows" (phrase, geo-constrained) | `/window-door-prices-milton-keynes/` |
| Door prices | "composite door prices", "front door cost", "new front door price" | `/composite-door-prices/` |
| Bifold prices | "bifold door prices", "bifold doors cost" | `/bifold-door-cost/` |
| Instant quote | "instant window quote", "window quote online", "double glazing quote online" (geo-constrained — these produced 8–10% CTRs last year; this time only people *in the radius* see them) | `/online-quote/` |

This campaign is the unfair fight: searchers asking the price question get the only local firm that answers it with a number. Aggregators can't compete with an actual £600 fitted price and a tool that prices your own sizes in ten minutes.

**Do not bid on your own brand.** You are organic #1 with sitelinks and a knowledge panel, and nobody currently bids on "fenster glazing". Add `fenster` as a negative everywhere. Revisit only if a competitor starts hijacking the brand SERP.

---

## 5. The negative keyword list (the lesson of 2025, made permanent)

Shared list, applied to all campaigns from day one. Seed it with every proven waste category from the account's own history:

- **Supply-only / DIY:** supply only, diy, trade, wholesale, buy online, for sale, delivered, self fit, how to fit, how to install, made to measure only
- **Merchants and supplier brands:** howdens, wickes, b&q, screwfix, wren, magnet, eurocell, selco, travis perkins, jewson, dunster
- **Wrong products:** internal, interior, bedroom, wardrobe, shower, garage door, velux, skylight blinds, conservatory roof (until conservatories are a business decision), curtains, blinds only, cat flap (own campaign someday, not this budget), greenhouse, shed, caravan, car, windscreen
- **Wrong intent:** jobs, careers, vacancies, apprenticeship, course, training, second hand, used, ebay, gumtree, facebook marketplace, screwfix, grants, free windows, council, housing association
- **Competitors (don't pay to show next to their brand):** anglian, everest, safestyle, crown windows, custom glaze, gallaghers, t&k, win-dor, window pains, elements windows, infinite windows, martindale, park lane windows, dovista, cloudy2clear, checkatrade, trustatrader
- **Own brand:** fenster
- **Far-ring towns** (belt and braces on top of geo): northampton, luton, stevenage, bedford, hitchin, letchworth, dunstable, corby, kettering, wellingborough, banbury, oxford, london
- **Software noise:** fenster meaning, german, translation (the word is German for window — the old account paid for "fenster" queries at position 8 that were dictionary lookups)
- **Repairs in the sales campaigns:** repair, repairs, misted, blown, resealing, hinge, handle replacement — *unless/until* a dedicated repairs campaign is wanted; repairs feed `/window-and-door-repairs/` but the job values don't fit a £1k acquisition budget yet

Weekly search-terms review adds to this list — that is the core maintenance job (section 8).

---

## 6. Ads: what they say

RSA guidance per the tone the site already owns (`TONEOFVOICE.md` — facts persuade, no "premium/stunning/dream home", no budget framing, never position a product as the cheap option):

**Headlines to rotate (pin location/brand where sensible):**
- Windows & Doors Milton Keynes
- See Your Fitted Price Online
- A Real Price In Ten Minutes
- 4.9★ From 133 Google Reviews
- MK Showroom On Alston Drive
- Fitted Prices Published Online
- Composite Doors From £2,000 Fitted
- Casement Windows £600 Fitted
- £5,000 Break-In Guarantee *(door ads only — must sit with the lock spec on the landing page)*
- FENSA Approved Installers
- Our Own Fitters, Not Subcontractors
- Survey First, One Price, No Games

**Description lines:**
- "Price your own windows and doors online in about ten minutes. Your sizes, your colours, a real figure — then we survey and confirm it."
- "A 1200 x 1200 casement window is £600 fitted including VAT. Every price we publish is one we charge. Showroom in Milton Keynes."
- "Fitted by our own team, backed by a ten year guarantee. 4.9 stars from 133 Google reviews. Come and open a bifold in the showroom."
- Door ads: "Every Distinction door we fit carries AI Secure locking, an APECS 3-star cylinder and an ILH Duplex lock, with up to £5,000 break-in compensation. T&Cs apply."

**Assets (extensions):** sitelinks (Instant quote · Price guides · Case studies · Book a consultation), callouts (Fitted prices online · MK showroom · FENSA approved · 10 year guarantee · In-house fitters), structured snippets (product list), **call asset** (01908 429200 — the 24/7 answering service makes after-hours calls legitimate), **location asset linked to the GBP** (this also puts the ad-eligible map pin in play — the slot Dovista and Park Lane are buying), image assets from the case-study photography, and **price assets** using the three checked fitted prices.

The differentiators, in every ad, in priority order: **published fitted prices / instant online pricing** (nobody else local has it), **4.9★ (133)**, **MK showroom**, **break-in guarantee** (doors). The nationals can't say the first; the aggregators can't say any of them.

---

## 7. Bidding, budget and honest expectations

- **Weeks 1–4:** Manual CPC or Maximise Clicks with a **£4.00 max CPC cap**. £33/day. Expect £2–4 CPCs on MK-local exact terms given the weak local auction (blended £2.33 last year *with* broad-match junk; local exact with better quality score should do better, price terms maybe higher).
- **From ~30 conversions:** switch to Maximise Conversions, then add a tCPA around your observed CPL once stable.
- **From ~30 offline qualified-lead imports:** optimise to qualified leads / value. This is the end state.

Realistic maths at £1,000/month:

| Stage | Conservative | Good |
| --- | --- | --- |
| Clicks (£2.50–£4.00 CPC) | ~250 | ~400 |
| Leads (5–10% — price-transparent LPs earn the top of that) | 15 | 35 |
| Cost per lead | £65 | £30 |
| Jobs (20–35% lead→job with 15-min callbacks and geo-clean leads) | 3 | 8+ |

A single composite door is £2,000; a bifold £3,500; a whole-house window job £4,000–8,000. **One fitted door a month covers the entire ad spend.** Last year's leads converted at 0% because they were the wrong people; the whole design above exists to make them the right people, and the offline import exists to prove it and steer toward it.

Two honest caveats: MK-local exact-match volume is finite — £33/day may not fully spend in month one (fine; don't loosen match types to force spend, widen the *keyword list* within the same intent instead). And months 1–2 are the learning tax; judge the system at month 3 with the disposition data.

---

## 8. The operating rhythm

**Weekly (20 minutes):** search-terms report → add negatives; check CPL per ad group; pause any ad group at 2× target CPL with zero qualified leads; confirm leads got their 15-minute callback and a disposition.

**Monthly:** import offline conversions (survey booked / job won with value); re-export search terms and rerun the intent classification from `HIGH-INTENT-SEARCH-PLAN.md` §8; compare paid vs the Website Tracker's consented Google-channel funnel (aggregate only — no click IDs in the dashboard); adjust budget split toward whichever campaign produces *qualified* leads, not raw leads.

**Quarter 2 candidates (only after the core converts):** Local Services Ads — two LSAs already sit above everything on "windows milton keynes", they charge per *lead* not per click, and the Google Guaranteed badge would sit on top of the map-pack fight; check category eligibility. A sponsored map placement campaign (what Dovista/Park Lane run). A £5/day Leighton Buzzard/Buckingham ring extension using the case-study proof that exists there. Meta retargeting of quote-tool starters. **Not** Performance Max — not until offline conversion values exist to feed it, or it will refill the account with last year's junk automatically.

## 9. Do-not list

- No broad match. Phrase + exact only, reviewed weekly.
- No Display, no Search Partners, no Smart campaigns.
- Auto-apply recommendations OFF; decline Google rep "account reviews".
- No bidding on "fenster".
- No sending paid traffic to the homepage — every ad group has its named landing page.
- No spend before the conversion tracking in section 3 is live and test-fired.
- No ad claims the landing page can't substantiate (the break-in guarantee always names the three lock components on the page; prices always match the live price guides — `/composite-doors/` already enforces this pairing).
- Keep the consent layer intact; ad click IDs stay out of the Marketing Dashboard.

## 10. Launch checklist, in order

1. Theme: `dataLayer` events (form success, tel: clicks, quote completion, consultation) + hidden `gclid` capture on the enquiry form → build, lint, test-site deploy, verify events fire in GTM preview. *(Owner approval, then live per `LIVECHANGES.md`.)*
2. GTM: Ads conversion tags + Consent Mode v2 wiring; link Google Ads ↔ GA4 if GA4 is wanted; test a real submission end to end.
3. Google Ads account: pause/archive "BOF [2026 Edit] Instant pricing" entirely. Fresh campaigns, don't edit the old one — its history teaches Google the wrong lessons.
4. Build the three campaigns, ad groups, keywords, RSAs, assets, shared negative list, geo (Presence), schedule, Display/Partners off, auto-apply off.
5. Google forwarding numbers on call assets; call-length threshold 60s.
6. Launch at £33/day with the £4 CPC cap. First search-terms review after 72 hours, then weekly.
7. Month 1 end: first offline import; review dispositions; rebalance budget.
