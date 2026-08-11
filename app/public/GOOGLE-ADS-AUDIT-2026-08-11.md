# Google Ads Audit And Restructure Plan — 11 August 2026

Date: 2026-08-11
Window audited: **28 July – 10 August 2026** (12 days with delivery; campaigns enabled 30 July).
Spend: **£164.38**. Clicks: **51**. Impressions: **634**. Conversions: **0**.

Sources:

- Google Ads Overview export, 28 Jul – 10 Aug (campaigns, time series, devices, demographics, day/hour, search keywords, search terms, word report, biggest changes).
- Google Ads Overview export, 31 Jul – 6 Aug — the only export carrying **impression share** and the **geographic report**.
- Google Ads full account export, 13 Apr 2018 – 24 Jul 2026 (the pre-rebuild history).
- Google Search Console export, 4 May – 3 Aug 2026, used to size local product demand.
- Live checks run today: landing page HTTP status, robots meta, the quote page and a price guide page at 375px, the conversion firing code in `src/js/main.js` and `inc/website-tracking.php`.
- `GOOGLE-ADS-PLAN.md`, `GOOGLE-ADS-SETUP.md`, `SEO-LEAD-AUDIT-2026-08-05.md`, `PROGRESS.md`.

This does not replace `GOOGLE-ADS-PLAN.md`. That document's strategy — local, search-only, no broad match, measure before you spend — was correct and is still correct. This document reports what happened when it met the live auction, and changes the **structure**, not the strategy.

---

## 1. Read this before anything else: zero conversions is not the finding

The instinct to read "0 conversions" as "the ads do not work" is the one conclusion this data cannot support.

| Step | Figure | Source |
| --- | --- | --- |
| Clicks bought | 51 | Ads export |
| Site journey-to-lead rate | 5.1% | `SEO-LEAD-AUDIT-2026-08-05.md` §4 |
| Expected leads from 51 clicks | **2.6** | 51 × 5.1% |
| Share of journeys that are attributable | 35.5% | `SEO-LEAD-AUDIT-2026-08-05.md` §4 |
| Expected **recorded** conversions | **0.9** | 2.6 × 0.355 |

**The account was expected to record about one conversion. It recorded none.** That is an entirely ordinary outcome for this sample size, and it would look identical whether the campaigns were excellent or mediocre. Twelve days and 51 clicks cannot tell you which.

That matters for two reasons:

1. **Do not judge the campaigns on it, and do not switch bidding strategy on it.** Nothing here justifies a verdict.
2. **The real problem is that the account is not buying enough traffic to ever find out.** At the current rate — about 127 clicks a month, of which roughly 2.3 conversions would be *recorded* — it reaches the ~30 conversions needed for smart bidding some time around **September 2027**. An account that cannot learn is a worse problem than an account that converts badly, because it never improves.

The rest of this audit therefore rests on evidence that needs no conversion data: the search terms themselves, the geography, the budget arithmetic, and where the clicks were sent.

---

## 2. The account is spending 42% of the money it has been given

| | Authorised | Actual |
| --- | --- | --- |
| Daily budget | £33.00 | **£13.70** |
| Over 12 delivery days | £396 | **£164.38** |

Impression share on `MK — Price Intent`, 31 Jul – 6 Aug, ran at **43–71%, averaging about 58%**. So even inside the narrow slice of the market the account is contesting, roughly two impressions in five are going to somebody else.

This is the single most actionable fact in the audit, because **fixing it costs nothing.** There is already £19 a day of committed, authorised, unspent budget. Restructuring to spend it turns 51 clicks a fortnight into roughly 120 at the same monthly cost. That is the difference between learning by October and learning by February.

Campaign split of what did spend:

| Campaign | Cost | Share | Clicks | CPC |
| --- | --- | --- | --- | --- |
| MK — Price Intent | £91.15 | **55%** | 29 | £3.14 |
| MK — Windows | £57.42 | 35% | 18 | £3.19 |
| MK — Doors | £15.81 | **10%** | 4 | £3.95 |

Doors — the product the plan itself called "the strongest converting surface on the site", with the highest job value per click and the shortest decision cycle — received **one pound in ten**.

---

## 3. The biggest line item in the account is a keyword that never matched its own intent

`window quote online`, phrase match, in the `Instant Quote` ad group:

- **£50.79 — 31% of everything the account spent.**
- 132 impressions, 15 clicks, 11.36% CTR.
- The whole `Instant Quote` ad group: **£56.08, 34% of account spend, 17 clicks.**

Now the search terms report for the same period, all 100 disclosed queries and all 105 disclosed words:

> **Not one contains the word "quote".**

Phrase match has not been a literal string match for years; it matches on meaning. Google read `window quote online` as *"someone wants a window price"* and spent the budget on `triple glazed windows cost calculator`, `how much to replace a window`, `window pane cost`, `upvc window glass replacement cost`, `3 section bay window price`, `cost of aluminium windows`, `secondary glazing cost per m2`.

The four other keywords in that ad group — `instant window quote`, `double glazing quote online`, `online window quote tool`, `double glazing instant quote` — spent **£0.00** and took **0 clicks** between them. One loose keyword ate the ad group.

### And the whole campaign should go, not just that keyword

**Owner correction, 11 August — this section originally recommended keeping price intent on exact match. That was wrong, and the account's own history says so.**

The objection: a price searcher asks the price, takes the number, costs £4, and does not convert. They are not high intent.

The 2018–2026 export settles it. Of the £6,979 in lifetime keyword spend:

| | Keywords | Lifetime spend | Share |
| --- | --- | --- | --- |
| **Price / quote / cost intent** | 23 of 50 | **£4,217.88** | **60%** |
| Everything else | 27 of 50 | £2,761.44 | 40% |

The account's five highest-spending keywords of all time include `upvc windows quote` (£757.26), `quote for sliding doors` (£714.84), `sliding door price online` (£479.86) and `door quote online` (£466.38). **£4,218 on price intent across eight years produced part of a five-conversion total.**

And the detail that matters most: those keywords ran at **8.64% and 10.49% CTR**. `GOOGLE-ADS-PLAN.md` §1 read that as "the one genuine positive". That reading was wrong, and this is the correction:

> **A high CTR on a price keyword is a warning, not a positive.** It means the ad is extremely attractive to somebody whose entire goal is a number. They click enthusiastically, take the figure, and leave. You pay full price for a click whose purpose is to extract the one thing you had to trade.

The current fortnight repeats it in miniature. Price intent took 55% of spend. And the CTRs now run the *other* way, which removes even the last argument for price terms:

| Price keywords | CTR | Product + geo keywords | CTR |
| --- | --- | --- | --- |
| `front door cost` | 3.85% | `bifold doors milton keynes` | 20.00% |
| `new front door price` | 5.71% | `replacement windows milton keynes` | 15.38% |
| `double glazing prices` | 7.41% | `window installers milton keynes` | 14.29% |
| `composite door cost` | 12.50% | `double glazing milton keynes` | 12.90% |

Product and installer terms are now both better intent *and* better CTR. There is no case left for buying price traffic.

**The price guides are not the problem, and they keep their job.** `/composite-door-prices/` showing "£2,000 inc VAT, fitted" on arrival is a superb *closing* asset for somebody already on a product page weighing Fenster up. It is a bad *acquisition* asset, because as an ad landing page it gives the number away for £3.20 and asks nothing back. Link to them from the product pages. Never point an ad at them.

**Decision: delete `MK — Price Intent` entirely.** Not exact match, not paused — gone, along with the quote-tool keyword theme, which has exactly the same eight-year record (`instant window quote` £272.98, `online quote upvc windows` £382.41, `door quote online` £466.38). The quote tool is an excellent on-site conversion mechanism. It is not a keyword theme worth buying.

---

## 4. 55% of the visible search-term spend cannot become an installation lead

The search terms report discloses £71.60 of the £164.38 (Google withholds low-volume terms). Within what it does disclose:

| Category | Cost | Examples |
| --- | --- | --- |
| **Glass and repair work** | £13.32 | `upvc window glass replacement cost`, `milton keynes glaziers`, `double glazed door glass replacement cost`, `double glazed glass replacement`, `window glass replacement milton keynes` |
| **Competitors and rival brands** | £10.83 | `gallagher and crompton`, `windor milton keynes`, `rock door prices uk`, `express bifolds milton keynes`, `solidor doors`, `schuco milton keynes`, `new city glass milton keynes`, `cloudy to clear milton keynes` |
| **Products not sold** | £5.94 | `replacement roof windows`, `stained glass front doors`, plus timber/wooden window queries |
| **Total that can never be a lead** | **£30.09 of £71.60 = 42%** | |
| Sold, but no ad group and nowhere to send them | £9.03 | `secondary glazing cost per m2`, `secondary glazing costs`, `triple glazed windows cost calculator` |
| **Combined misdirected spend** | **£39.12 = 55%** | |

### Why the negative list did not catch these

The `Fenster master negatives` list is well designed and it still let all of the above through, for two distinct reasons worth understanding separately.

**Reason one — negatives match words, not meanings.** Unlike keywords, negative keywords are literal. The list contains:

| On the list | The query that got through | Why it missed |
| --- | --- | --- |
| `win-dor` | `windor milton keynes` | Hyphen. Different string. |
| `gallaghers` | `gallagher and crompton` | Plural. Different string. |
| `cloudy2clear` | `cloudy to clear milton keynes` | Digit vs word. |
| `velux` | `replacement roof windows` | Different brand, same product. |

**Reason two — a whole category was never on the list.** `repair`, `repairs`, `misted`, `blown`, `hinge` and `resealing` are all negatives. But `glass replacement`, `replacement glass`, `glazier`, `glaziers` and `sealed unit` are not — and that is where £13.32 went. These queries are repair work wearing different words. They belong to `/window-and-door-repairs/`, not to a £1,000 acquisition budget.

Note the trap: `replacement` cannot be negatived wholesale, because `replacement windows milton keynes` is a target keyword with a 15.38% CTR. The negatives have to be the phrases, not the word.

---

## 5. People search for products. The account sells "windows and doors in Milton Keynes"

**Of the 100 disclosed search terms, 76 named no town at all.** The queries are things like `front doors`, `flush casement windows`, `corner bifold doors`, `anthracite grey composite door`, `1930 style composite door`, `black upvc windows`, `composite back door`, `sound proof bifold doors`, `aluminium picture window`, `3 section bay window price`.

That is how people actually shop for this: by product, style and colour. The account has nine ad groups covering about eight products, and the site has **seventeen residential product pages, each with a full town matrix already built**.

Sizing this properly against Search Console, three months of local non-brand impressions:

| Product | Local impressions | Ad group today | Landing page |
| --- | --- | --- | --- |
| Double glazing (generic) | 5,792 | ✅ | `/double-glazing-milton-keynes/` |
| Composite / front doors | 2,186 | ✅ | `/composite-doors/` |
| Bifold doors | 1,139 | ✅ | `/aluminium-bifold-doors/` |
| uPVC windows | 961 | ✅ | `/casement-windows/` |
| Sash windows | 889 | ✅ | `/sliding-sash-windows/` |
| Patio / sliding doors | 869 | ✅ | `/patio-doors/` |
| Casement windows | 813 | ✅ | `/casement-windows/` |
| Aluminium windows | 620 | ✅ | `/aluminium-windows/` |
| **Aluminium doors** | **494** | ❌ **none** | `/aluminium-doors/` exists |
| French doors | 401 | ⚠️ folded into patio | `/french-doors/` exists |
| Integral blinds | 308 | ❌ none | `/integral-blinds/` exists |
| uPVC doors | 292 | ✅ | `/upvc-doors/` |
| Roof lanterns | 271 | ❌ none | `/roof-lanterns/` exists |
| Flush casement windows | 129 | ❌ none | `/flush-casement-windows/` exists |
| Secondary glazing | 116 | ❌ none | `/secondary-glazing/` exists |
| Triple glazing | 92 | ❌ none | — |

**Aluminium doors is the clearest case in the account.** 494 local impressions a quarter — `aluminium doors near me` (210), `aluminium doors buckinghamshire` (164), `aluminium doors milton keynes` (94). A finished landing page with its own town matrix. No ad group, no keyword, no ad. Somebody who wants an aluminium door does not search "windows and doors Milton Keynes", and nothing in this account is currently able to show them anything.

Secondary glazing makes the same point from the other direction: the account has **already paid £6.22 for secondary glazing clicks** it had no ad group for, so they landed on a generic page.

---

## 6. Two large modifier families have no coverage at all

Both are invisible in the Ads account because nothing bids on them, and both are clearly visible in Search Console.

### "Near me" — 1,355 impressions, no coverage

`double glazing near me` (253), `aluminium doors near me` (210), `window fitters near me` (171), `double glazing with integral blinds near me` (94), `composite doors supplied and fitted near me prices` (65).

These are the purest local buying intent that exists. They carry no town name, which is exactly why the old account was afraid of them — but **Presence geo targeting already solves that**. Only somebody physically in the radius can see the ad. This is the safest possible non-geo keyword family and it has zero coverage.

### County terms — 5,835 impressions, **0 organic clicks**, no coverage

`double glazing buckinghamshire` (584), `window installers buckinghamshire` (424), `windows buckinghamshire` (308), `buckinghamshire doors` (301), `composite doors buckinghamshire` (228), `french doors buckinghamshire` (226), `sash window double glazing buckinghamshire` (215), `bifold doors buckinghamshire` (201).

Average organic positions run between 15 and 44, which is why 5,835 impressions returned nothing. Organic cannot win these this year. **Paid does not have to rank.**

---

## 7. Two thirds of price-intent impressions served in Leighton Buzzard, not Milton Keynes

The geographic report for `MK — Price Intent`, 31 Jul – 6 Aug:

| Where the searcher actually was | Impressions |
| --- | --- |
| **LU7 (Leighton Buzzard)** | **67** |
| MK7 | 16 |
| MK18 (Buckingham) | 12 |
| MK10 | 4 |
| MK15 / MK17 | 2 |

**66% of resolved impressions were in Leighton Buzzard**, roughly fifteen miles from the showroom, where "MK Showroom On Alston Drive" is a much weaker line than it is in Bletchley. Milton Keynes proper contributed 22.

This is not a targeting error — Leighton Buzzard is deliberately targeted. It is a **budget allocation** outcome: the auction there is cheaper, so a budget-limited campaign drifts toward it. Two things follow. The ring towns need their own ads with their own proof rather than inheriting MK copy, and the site already has the pages for it — `composite-doors-leighton-buzzard`, `aluminium-doors-leighton-buzzard`, `double-glazing-leighton-buzzard` and the rest all exist and no ad points at any of them.

---

## 8. Where the clicks were sent

Every landing page in `GOOGLE-ADS-SETUP.md` was checked live today. **All return 200, all are indexable, none are broken.** The problem is not availability, it is the match between what the ad promises and what the page asks for.

| Ad promise | Page | What actually happens |
| --- | --- | --- |
| "See Your Fitted Price Online", "A Real Price In Ten Minutes", "No Salesman Needed For A Price" | `/online-quote/` | Six-screen configurator, then **name, address, phone and email are required before any figure appears**. The page's own FAQ says so. |
| "Real Fitted Prices Online" | `/composite-door-prices/` and the other guides | **£2,000 inc VAT shown immediately**, no form, full specification listed |

The ads pointing at the quote tool are making a promise that page does not keep, at £3.37 a click. Per §3 the resolution is not to re-point those ads at the price guides — it is that **neither page should be an ad destination at all.** The mismatch disappears along with the keyword theme that created it.

Supporting evidence from `SEO-LEAD-AUDIT-2026-08-05.md` §F2, measured on site traffic: **182 journeys were shown the quote tool, 21 opened it (11.5%), and 12 of those completed (57%).** The tool converts well once someone commits; the loss is almost entirely at the moment of commitment. The audit calls it "the largest single conversion gap measured anywhere on the site" — and 34% of the ad budget is being aimed straight into it.

Two smaller landing-page facts, both worth knowing:

- **76% of spend is mobile** (£125.12 of £164.38, 456 of 634 impressions). On a 375px viewport the cookie modal occupies **501px of an 812px screen** on arrival. Every paid click meets it before it meets the page. This is not a reason to weaken the consent layer — CTR rose 33% post-launch with the modal live throughout — but it is the first thing a £3.20 click experiences.
- **The price guides get 15 organic impressions a quarter** (`SEO-LEAD-AUDIT` §F4). Google will not rank them, and per §3 they must not be bought traffic either. Their job is to close somebody who is already on a product page — reachable by internal link, never by ad. A page that hands over a real fitted price for free is worth a great deal to a warm visitor and nothing at all to a £3.20 click.

---

## 9. Measurement gaps that need closing in the account

The website side is in good shape and was verified in code today: `sendGoogleAdsConversion()` in `src/js/main.js` fires `AW-808336148` with live labels for enquiry, consultation and phone, gated on marketing consent; the offline feed in `inc/google-ads-conversions.php` is live and token-protected. Three things remain open, and all three are account-side.

1. **Verify the Final URL suffix is actually set on all three campaigns.** `PROGRESS.md` (2026-08-05) records that the suffix documented since 24 July "had never been applied", and only 15 of ~183 consented Google journeys read as `cpc`. The theme now derives `google`/`cpc` from the `gclid`, so the *channel* is safe either way — but campaign, ad group and keyword reporting still depend entirely on the suffix, and it is set per campaign, so nothing inherits it.
2. **The `website_lead_outcomes` table holds one row.** Until the office marks leads contacted / qualified / appointment / won / lost, the offline feed has nothing to send, and no campaign can be judged on jobs instead of form fills. This is the habit that gates every ROI claim later.
3. **Confirm call reporting and Google forwarding numbers are on.** With 76% of spend on mobile and a genuine 24/7 answering service, the phone is likely the main conversion path for this trade, and it is the one path currently easiest to under-count.

---

# The plan

Five phases. Phase 0 is today and costs nothing. Nothing here raises the £1,000/month budget — the first job is to spend the £19 a day already authorised and currently unspent.

## Phase 0 — Today, about 30 minutes

**0.1 Delete `MK — Price Intent`.** All four ad groups, including `Instant Quote`. This releases **£9/day of budget and stops a £91-per-fortnight leak** — 55% of spend on the one intent the account has eight years of evidence against.

**0.2 Make price intent a negative, account-wide.** This is the step that makes 0.1 actually hold, and it is not obvious. Deleting the campaign does not stop price traffic; it just moves it. Google will happily match `composite door cost` into a `composite doors milton keynes` keyword through close variants, and the account will quietly rebuild the same problem inside the product ad groups. Blocking it has to be explicit:

```
price
prices
pricing
cost
costs
"how much"
quote
quotes
quotation
cheap
cheapest
bargain
discount
```

Two consequences to accept knowingly. Some genuine buyers do type "cost", and this turns them away — that is the trade being made deliberately, and it is the right one at £33/day. And `quote` as a negative means the quote tool is never an ad destination; it stays what it is good at, which is converting people who are already on the site.

**0.3 Add the remaining negatives.** Paste into `Fenster master negatives`. The first block is the repair and glass category the list never covered; the second closes the literal-string misses.

```
"glass replacement"
"replacement glass"
"glass replaced"
glazier
glaziers
"sealed unit"
"sealed units"
"unit replacement"
"cloudy to clear"
"misted unit"
"roof window"
"roof windows"
windor
gallagher
crompton
"rock door"
rockdoor
solidor
schuco
costco
"express bifolds"
"bi fold express"
"new city glass"
"crystal clear"
timber
wooden
"stained glass"
"steel door"
"steel front door"
"picture window"
```

**0.4 Move `£4` more per day to `MK — Doors`.** It took 10% of spend on the highest-value product line.

## Phase 1 — Restructure by product (this week)

**The structural change: stop organising the account by funnel stage, and organise it by product.**

Three campaigns split by intent made sense on paper. In practice it spreads roughly 10 clicks a day across 13 ad groups and 50 keywords, so no single bucket ever accumulates enough signal to learn from, and price keywords end up divorced from the products they are about. Zac's own read of it is the right one: people search for a product.

**Consolidate to one campaign, `MK — Products`, with one ad group per product**, each pointed at that product's own page. The whole account now buys one thing: **somebody who wants the product, or somebody who wants an installer.** Nothing else.

Launch these six first, ranked by local demand × job value:

| Ad group | Evidence | Landing page |
| --- | --- | --- |
| Composite & Front Doors | 2,186 imp | `/composite-doors/` |
| Double Glazing MK | 5,792 imp | `/double-glazing-milton-keynes/` |
| **Installer Intent** ⭐ | 1,221 imp, buried in a windows ad group today | `/windows-milton-keynes/` |
| Bifold Doors | 1,139 imp | `/aluminium-bifold-doors/` |
| **Aluminium Doors** ⭐ | 494 imp, **no coverage today** | `/aluminium-doors/` |
| **Near Me** ⭐ | 1,355 imp, **no coverage today** | `/windows-milton-keynes/` |

**Installer Intent earns its own ad group and its own promotion.** It is the exact opposite of price intent — somebody typing `window installers milton keynes` wants to *hire* a company, not extract a number — and it is the best-performing intent in both datasets. `window installer milton keynes` (346 imp), `window companies milton keynes` (280), `window fitters near me` (171), `double glazing companies milton keynes`. In the current fortnight these ran at **14.29% and 8.82% CTR**. Today they sit buried inside `Replacement Windows MK`, sharing a budget with generic window terms.

Keywords for the three promoted groups:

```
Installer Intent
[window installers milton keynes]
[window fitters milton keynes]
[window companies milton keynes]
[double glazing companies milton keynes]
[double glazing installers milton keynes]
[window installer milton keynes]
[glazing company milton keynes]

Aluminium Doors
[aluminium doors milton keynes]
[aluminium front door milton keynes]
[aluminium back door]
[aluminium doors near me]
[aluminium sliding doors milton keynes]
[heritage aluminium doors]

Near Me
[double glazing near me]
[window fitters near me]
[window installers near me]
[composite doors near me]
[bifold doors near me]
[aluminium doors near me]
[double glazing companies near me]
```

Every keyword exact match. Presence-only geo makes the "near me" set safe — only somebody standing in the radius can see it. Note that `aluminium door prices` is deliberately absent; per Phase 0.2, price words are negatives everywhere.

**Every ad points at a product or installer page.** No ad points at a price guide, and no ad points at `/online-quote/`. Both keep working as on-site conversion routes for people who are already there — which is what the measured 57% quote-tool completion rate says they are good at.

## Phase 2 — Fill the gaps (week 3, once Phase 1 is spending)

Add as budget allows, in this order:

| Ad group | Evidence | Page |
| --- | --- | --- |
| Casement & Flush Casement | 813 + 129 imp | `/casement-windows/`, `/flush-casement-windows/` |
| Sash Windows | 889 imp | `/sliding-sash-windows/` |
| Patio & Sliding Doors | 869 imp | `/patio-doors/` |
| French Doors | 401 imp | `/french-doors/` |
| uPVC Windows / Doors | 961 / 292 imp | `/casement-windows/`, `/upvc-doors/` |
| **Buckinghamshire** ⭐ | 5,835 imp, 0 organic clicks | county and town pages |

Then a £2/day experiment tier, one ad group each, on products that have a finished page and measured demand and have never been advertised: **integral blinds** (308), **roof lanterns** (271), **secondary glazing** (116). These are small, but they are uncontested and the pages already exist.

## Phase 3 — The ring towns (week 4)

Leighton Buzzard is already taking two thirds of price-intent impressions with MK copy and an MK landing page. Give it its own ad group, its own headline, and its own existing landing pages (`composite-doors-leighton-buzzard`, `aluminium-doors-leighton-buzzard`, `double-glazing-leighton-buzzard`). Same for Buckingham (MK18) and Newport Pagnell. This is a copy and routing change, not new pages — the pages were built months ago.

## Phase 4 — Close the measurement loop (in parallel, account-side)

1. Verify the Final URL suffix on every campaign, including any created outside `GOOGLE-ADS-SETUP.md`.
2. Confirm call reporting and Google forwarding numbers are live; make phone calls a primary conversion.
3. Start recording lead outcomes in the office. One row exists today. Thirty rows is what turns this from a click-buying exercise into something that can be optimised toward jobs.

---

## What to expect, and when to judge it

### First, the uncomfortable arithmetic of cutting price intent

Cutting price intent is right, and it has a consequence that should be said plainly rather than discovered in September.

Of the £13.70/day the account currently spends, **£7.60 was price intent**. Product and installer intent is delivering only about **£6.10/day** today. Getting from there to the authorised £33/day means roughly quintupling the product side. The available levers do not obviously reach that far:

| Lever | Effect |
| --- | --- |
| Add every uncovered product (aluminium doors, french, integral blinds, roof lanterns, flush casement, secondary glazing) + near me | ~8,900 uncovered impressions/qtr against ~13,600 covered — about **1.7×** |
| Recover lost impression share (58% → ~85%) | about **1.45×** |
| Combined, optimistically | **~£15/day** |

**So the honest expectation is that MK-local product and installer intent, on exact match, cannot spend £1,000/month.** It looks more like £450–500. That is not a failure; it is what a town of this size supports at this intent quality. The old account only ever reached £1,000/month by buying national price traffic, which is precisely the £4,218 mistake.

Three ways forward, and this is an owner decision rather than a technical one:

1. **Spend less, convert better.** Run at £15/day, bank £550/month. Best return per pound, slowest learning.
2. **Take the county pool.** `Buckinghamshire` alone is **5,835 impressions a quarter with zero organic clicks** — the single largest uncovered pool in the data, and it is product intent, not price intent. This is the only lever that plausibly closes the gap while keeping intent quality, and it is why it should move up from Phase 2 if spending the full budget matters.
3. **Widen the ring.** Leighton Buzzard already takes two thirds of impressions unprompted; Buckingham, Bedford and Aylesbury all have finished product pages.

My recommendation is 1 + 2: run the product account properly, add Buckinghamshire early, and let spend find its own level rather than forcing it. **Do not loosen match types to spend the budget.** That is the exact mechanism that produced the last eight years.

### What the money buys

| | Now | After restructure |
| --- | --- | --- |
| Daily spend | £13.70 (55% of it price intent) | £15–20, all product/installer |
| Clicks/month | ~125 | ~150–190 |
| Clicks on price intent | ~68 | **0** |
| Products covered | 8 | 15+ |
| Expected leads/month at 5.1% | ~6 nominal | ~8–10, from better intent |
| Time to 30 conversions | ~Sept 2027 | ~mid-2027, or ~Feb 2027 with Buckinghamshire |

The lead figure moves less than the earlier draft of this document claimed, because the earlier draft was counting price clicks as if they converted. They do not. **The gain here is not more leads per pound; it is that the pounds stop going to people who were never going to buy.**

Two honest caveats, and they are the same two the original plan made.

**The first month after a restructure is a learning tax.** Expect the numbers to look untidy until mid-September. The first real judgement point is **month 3, on disposition data**, not on Google's conversion column.

**These are directional figures, not forecasts.** The 5.1% journey-to-lead rate comes from organic and direct traffic; paid traffic is colder and may convert below it, or better, since it lands on matched product pages rather than a homepage. The GSC impression counts size *demand*, not paid search volume — they say which products people in this area are looking for, not how many clicks are for sale.

What can be said without qualification: the account is currently leaving 58% of an authorised budget unspent, sending a third of what it does spend to queries that do not contain the word it bid on, and showing nothing at all to somebody in Milton Keynes searching for an aluminium door.

---

## Do-not list (unchanged from `GOOGLE-ADS-PLAN.md`, plus three)

- No broad match. **And now: no phrase match either on price or quote terms** — phrase match is semantic and cost this account 31% of its budget in a fortnight. Exact only until there is conversion data to loosen against.
- No Display, no Search Partners, no Smart campaigns, no Performance Max.
- Auto-apply recommendations off; decline rep account reviews.
- No bidding on `fenster`.
- **Do not buy price, cost, quote or "how much" intent.** £4,218 across eight years and £91 in the last fortnight bought a searcher whose goal is a number, not an installer. A high CTR on those terms is a warning, not a positive. The price guides and the quote tool convert people who are already on the site; they are not acquisition channels.
- **Do not loosen match types to spend the budget.** If MK-local product intent will not absorb £33/day, it will not — widen the *geography* or the *product list*, never the intent.
- **Never negative a bare word that a target keyword also contains** — `replacement` would have killed `replacement windows milton keynes` and its 15.38% CTR. Negative the phrase.
- Every price in an ad must match the live price guide the same day it changes.
- Keep the consent layer as it is. It costs measurement, not visitors.
