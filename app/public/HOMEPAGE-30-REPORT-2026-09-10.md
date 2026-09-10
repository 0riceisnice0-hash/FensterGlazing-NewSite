# Homepage 3.0: what it did to leads, and what happened next

**Written 2026-09-10. Covers 4 – 10 September 2026.**

Homepage 3.0 — the Rightmove-style homepage with the typed headline and the
product finder — went live on 4 September. Enquiries fell from **4.8/day to
1.5/day** and stayed there for five days. It was reverted on 9 September. This
records what the data actually showed, including the parts that were kind to the
new homepage, and the two figures reported during the investigation that turned
out to be wrong.

**The finding in one line:** traffic never fell. The homepage stopped passing
people to `/online-quote/`, which produces very nearly every lead this site gets.

---

## 1. Timeline

| Date | Event |
| --- | --- |
| **4 Sep** | Homepage 3.0 goes live. Tag `live-homepage-2026-09-04`, `9921fda2`. |
| 5 Sep | Homepage quote-frame tracking fixed (`ca9793c2`). Enquiries: **0 that day**. |
| 3–7 Sep | *Separate incident:* Brevo rejected all website email. Fixed 7 Sep 08:11. Ruled out as a cause — see §4. |
| 5–8 Sep | Enquiries run at 0, 2, 3, 1. |
| **9 Sep ~13:00** | Hero CTA, square quote frame, fixed-height hero, WindowCAD tracking, iOS fix. Tag `live-homepage-2026-09-09`, `caf75c2e`. |
| **9 Sep ~15:00** | **Reverted to the classic homepage** at the host gate. `cc911eb0`. |
| 9 Sep evening | 4 enquiries, all WindowCAD. |
| 10 Sep | Homepage 3.0 remains live on `test` only. |

---

## 2. What the data showed — against Homepage 3.0

### 2.1 Leads (live WordPress database — the ground truth)

| Window | Enquiries/day |
| --- | --- |
| 23 Aug – 4 Sep (13 days) | **4.8** |
| 5 – 8 Sep (4 days) | **1.5** |

Daily from 28 Aug: `1, 3, 7, 6, 4, 5, 7, 5, —, 2, 3, 1, 4`
(5 Sep produced **zero**.)

**Nearly every lead is a WindowCAD quote completed on `/online-quote/`.** Of 190
enquiries ever recorded, **140 carry `_fenster_windowcad_fields`**. Everything
else — contact page, consultation, product pages — is a trickle of 0–1/day.

### 2.2 Traffic did not fall

Real journeys — bots and no-action sessions excluded:

| | Before (28 Aug–3 Sep) | After (4–9 Sep) | |
| --- | --- | --- | --- |
| real journeys | 46.6/day | 47.5/day | **+2%** |
| clicked anything | 17.0/day | 15.2/day | −11% |
| saw the quote tool | 19.4/day | 11.6/day | **−40%** |
| opened the quote | 5.3/day | 2.5/day | **−53%** |
| completed a quote | 2.4/day | 1.1/day | **−56%** |
| sent a form | 1.3/day | 0.4/day | **−72%** |
| tapped phone | 0.6/day | 0.9/day | **+56%** |

Conversion rates off real journeys, which removes any traffic-volume effect
entirely:

| | Before | After |
| --- | --- | --- |
| saw the quote tool | 41.7% | 24.4% |
| opened the quote | 11.3% | 5.3% |
| completed a quote | 5.2% | 2.3% |
| sent a form | 2.8% | 0.8% |

### 2.3 Where the people went instead

Of real journeys that touched the homepage:

| Onward destination | Before | After | |
| --- | --- | --- | --- |
| → `/online-quote/` | 19.4% | **4.8%** | −14.7pp |
| → `/contact/` | 8.3% | **25.0%** | **+16.7pp** |
| → `/book-a-consultation/` | 2.8% | 1.2% | −1.6pp |
| dead end, no second page | 40.3% | 42.9% | +2.6pp |

**The new homepage swapped "get a price" for "ask a question."** That is an
expensive swap, because `/contact/` does not convert:

- `/contact/` arrivals: 2.4/day → **5.5/day**
- forms sent from it: **1 in the whole before period, 1 in the whole after period**
- contact → sent rate: 5.9% → **3.2%**

### 2.4 The server logs, which involve no tracking assumption at all

Referrers on real (non-bot) requests to `/online-quote/`:

| Referrer | Before | After | |
| --- | --- | --- | --- |
| **fensterglazing.com** (internal) | 17.7/day | **3.4/day** | **−81%** |
| www.google.com | 1.4/day | **3.4/day** | **+138%** |
| none / typed | 7.1/day | 5.4/day | −24% |

**Google referrals to the quote page rose while internal ones collapsed.**
Demand was intact; the site stopped routing it.

### 2.5 The control that makes the case

Journeys that reached `/online-quote/`, split by how they entered the site:

| Entry route | Before | After | |
| --- | --- | --- | --- |
| landed straight on `/online-quote/` | 4.57/day | 1.25/day | −73%\* |
| landed on the homepage → reached quote | 2.14/day | 0.89/day | −58% |
| **landed on another page → reached quote** | **0.71/day** | **0.71/day** | **unchanged** |

Every other route into the quote tool worked exactly as before. Only the two
involving the homepage broke.

\* *See §5 — this figure is overstated.*

### 2.6 WindowCAD webhooks (raw access logs)

Successful `fenster/v1/windowcad` deliveries:

- 19 Aug – 4 Sep: **2.8/day**
- 5 – 8 Sep: **1.0/day** (−65%)

**Every `200` webhook produced an enquiry**, checked timestamp by timestamp. The
pipeline never dropped anything — the quotes simply stopped being started.

---

## 3. What the data showed — *for* Homepage 3.0

This is not a one-sided case and the revert is not a judgement on the design.

- **Homepage traffic rose.** Pageviews on `/` went **40.4/day → 49.1/day (+22%)**.
  More people were landing on it and staying on it.
- **Homepage-referred visitors were the BEST quote traffic.** Of journeys that
  reached `/online-quote/`, those that came via the homepage completed at **24%**,
  against **12%** for everyone else. It was actively qualifying people, not
  skimming easy ones.
- **The dead-end rate is not its fault.** 40.3% of homepage visitors reached no
  second page under the classic homepage; 42.9% under 3.0. Essentially unchanged,
  and a bigger long-term problem than anything in this report.
- **No technical fault was found.** No 5xx, no error-rate change (404s ran
  400–1,100/day both before and after), zero console errors, all routes 200.

**The fault was routing, not design.** People arrived, engaged, and were pointed
at a contact form instead of a price.

---

## 4. What was ruled out, with evidence

| Suspect | Why it is not the cause |
| --- | --- |
| **Brevo email outage (3–7 Sep)** | It hid mail; it did not stop enquiries being *created*. The database records stopped too. |
| **WindowCAD webhook payload cap** | Live carried the 64MB fix. Every `200` produced an enquiry. |
| **Google Ads** | `google/cpc` journeys **doubled** over the window. |
| **Organic / GSC** | Stable-to-up, confirmed by the owner and by rising Google referrals. |
| **The weekend** | Sun 30 Aug produced 7 enquiries; Sun 6 Sep produced 2. Mon/Tue 7–8 Sep gave 3 and 0 against 5,3 and 7,7 on the two prior Mon/Tues. |
| **Meta paid social** | Ran **14–17 August only** and stopped three weeks before the drop. See §5. |
| **Bots** | 59.6% of journeys are one page with no action — but that is constant across both windows, and bots do not complete quotes or send forms. |

---

## 5. Two figures reported during the investigation that were wrong

Recorded because they were quoted before they were checked.

**"Landing straight on the quote page fell 73%."** That came from journey data,
which depends on consent and JavaScript. The raw access logs put the real fall at
about **35–50%**, depending on whether a 77-request spike on 31 August is treated
as genuine. The direction held; the magnitude did not.

**A Meta campaign appeared to be a cause and was not.** Widening the comparison
window back to 14 August imported a paid-social campaign — *"LEADS | Fenster
Glazing | 08/26"* — that ran **14–17 August**, sent 55 journeys straight to
`/online-quote/` at 2.6/day, and then stopped. It had been dead for three weeks
before the homepage shipped. **Widen a window far enough and you import a
campaign that was never running in the period you are explaining.**

---

## 6. How it was reverted

**Not a git revert.** `fenster_h30_enabled()` in `inc/home-30.php` is a host
allowlist. The two live hosts were **commented out, not deleted**:

```php
// 'fensterglazing.com',      // live, 2026-09-04 to 2026-09-09
// 'www.fensterglazing.com',  // live, 2026-09-04 to 2026-09-09
```

Consequences of doing it this way:

- Homepage 3.0 stays whole in git and **stays live on `test`**.
- Live falls through to `home-experience` — the classic homepage — which is
  itself one of the five held-back Distinction files, so what serves now is
  byte-for-byte what ran before 4 September.
- Putting it back is one edit.

Release record: `cc911eb0`, one file, zero deletions, residual **0**, backup
`fenster-pre-cc911eb0` (460M) proven by extraction, socket purge `msg:OK`.
Verified after: `fg-h30` returns **0** on live, classic markers 67, one `h1`, six
links to `/online-quote/`, zero console errors, all routes `200`, `test` still
serving 3.0.

---

## 7. Tracking added along the way

The investigation had to be run off the live database and raw access logs because
the instrumentation could not answer it. That has been fixed.

| Fix | What was wrong |
| --- | --- |
| **`cta_click` selector** | Matched `a.button, button.button`. Homepage 3.0 buttons are `.fg-h30-btn`, so **`cta_click` on `/` was exactly zero from the day it shipped**. "Nobody clicks the CTAs" was a hole in a selector, not a fact about visitors. The nav's `.site-nav__mega-cta` had never been counted anywhere either. |
| **WindowCAD step bridge** | Between `quote_iframe_loaded` and `quote_completed` there was *nothing*. A funnel losing people inside the designer looked identical to one nobody opened. The tool now reports its own screens: product, style, colour, depth, where they stop. |
| **iOS search results** | Tapping a search result on iPhone did nothing at all. Safari does not focus a link on tap, so `focusout` fired with `relatedTarget === null`, the handler hid the results *between touchend and click*, and the tap landed on nothing. Desktop could never reproduce it. |
| **Dead-journey filter** | **2,631 of 4,242 journeys** opened a page and did nothing else. Now excluded from every count, with the excluded number shown. Quotes, forms and clicks are untouched — the filter drops **zero** of them. |
| **Unattributed quotes** | ~18% of WindowCAD quotes come from visitors who **refuse cookies** (`Tracking: rejected-cookies`). They are real leads, in WordPress and AdminBase, but have no journey. They were missing from the WindowCAD tab entirely. |
| **Header height, 1px** | `--site-header-main-height` is the header's content box; its border makes it render 73px. Every `calc(100svh - …)` section was 1px too tall. 15 of 17 uses are still wrong. |

**A dedicated WindowCAD tab** now carries the quote funnel (seen → opened →
completed), a daily chart, where quotes are started, what brings the people who
finish one, and the in-tool step detail.

**Note on the bridge:** whether somebody *finished* is not measured by the
snippet. The `FG2-` reference on the quote already tells us that, and it is
counted in the funnel from the tracking data. The snippet is only for what
happens *inside* the designer.

---

## 8. What is on test now

`test.fensterglazing.com` runs Homepage 3.0 with everything built on 9 September:

- **A price CTA above the fold** — "Instant Quote" and "Book a free visit". The
  first in-content price ask had been at **58% page depth**; everything above it
  was header nav.
- **A square quote frame**, 536×536. It had been `align-self: stretch` with a
  280px floor, so its height was whatever the paragraph beside it needed —
  WindowCAD was rendering a tall configurator into a letterbox.
- **A fixed 640px hero**, not `calc(100svh - header)`. At 1440×1200 the old one
  rendered **1127px for 621px of content** — 506px of nothing, and 582px of dead
  photograph between the search box and the bottom of the band.
- **One rhythm down the middle** — equal gaps between the typed line, the
  buttons and the search box, all reading one token.
- **The one-viewport rule generalised** in `STYLE.md`. It already existed, added
  2026-09-03 with the correct 707px budget, but was scoped to
  `/sliding-sash-windows/` and hedged as "the standard for any page he reviews
  next". That hedge is how a 937px band shipped on the homepage six days later.

**None of this has been tested against real traffic.** It went live for roughly
two hours on 9 September before the revert.

---

## 9. What to watch

`/online-quote/` internal referrals are the leading indicator, and they come from
the server log, so no tracking assumption is involved.

| | |
| --- | --- |
| before the new homepage | **17.7/day** |
| during it | **3.4/day** |
| target | back toward 17/day |

Leads follow a day or two behind. **Five to seven days gives a clear read** — at
these rates the difference between recovered and not is unmistakable, not a
judgement call.

**9 September showed 4 enquiries, all WindowCAD** — the first day above 3 since
4 September. Three of the four arrived after the revert. One day is not a trend,
and part of that day's traffic was this session's own QA.

---

## 10. Open questions

1. **Is Homepage 3.0 recoverable?** The evidence says the design was not the
   problem — its traffic converted at **24% against 12%**. The routing was. A
   hero CTA above the fold plus removing the embed's competition with it may be
   the whole fix, and it is one edit to put back.
2. **The 43% dead-end rate** belongs to both homepages and is larger than
   anything in this report.
3. **`data-quote-autoload="near"`** still self-opens the embed on scroll,
   offering a second, worse place to do the same job as the CTA beside it.
4. **One WindowCAD session on 9 Sep produced no step detail** despite completing
   two quotes, while the bridge worked for two other people three minutes later
   on the same page. Unexplained. Most likely a new tab or a device where
   `requestFullscreen` falls through to `window.open`, where the snippet returns
   by design — **not proven**.
5. **15 of 17 header-height subtractions** are still 1px out.

---

## Sources

Everything here is from one of four places, and which one matters:

- **Live WordPress database** (`wr_posts`, `post_type='fenster_enquiry'`) — the
  lead ledger. Unaffected by consent, JavaScript or bots.
- **Raw SiteGround access logs** (`~/www/fensterglazing.com/logs/*.gz`) — real
  HTTP requests and referrers. Note the file dated *D* holds traffic from *D−1*;
  read the timestamps inside, not the filename.
- **Marketing Dashboard D1** (`website_events`, `website_journeys`) — consented
  journeys only, and inflated by bots until 9 September.
- **Google Search Console** — owner-reported, stable to rising throughout.

Where they disagree, the first two win.
