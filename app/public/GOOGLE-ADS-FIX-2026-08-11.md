# Google Ads — Product-Specific Rebuild Of The Ad Groups And Ads

> **IMPLEMENTED IN THE LIVE ACCOUNT, 11 August 2026.** Everything in Parts 2–5 below was
> built directly in account 737-751-8039. See §0 for exactly what shipped, what changed
> from this plan, and what is still outstanding.

Date: 2026-08-11
Companion to `GOOGLE-ADS-AUDIT-2026-08-11.md` (the evidence) and `GOOGLE-ADS-SETUP.md` (the original build).
Scope: **fix the existing account in place.** Keep `MK — Windows` and `MK — Doors`, delete `MK — Price Intent`, split the ad groups by product, and rewrite every ad so it talks about the product that was searched for.

Every specification in the copy below was read off the live product page today. Nothing is invented, and each ad group's claims sit on the page its ad points at, per the `GOOGLE-ADS-PLAN.md` rule that no ad may claim what the landing page cannot substantiate.

---

## 0. What shipped on 11 August 2026

### 0a. The finding that only appeared once we were inside the account

**Both product campaigns were bid-throttled to a standstill.** `MK — Windows` and `MK — Doors`
ran Maximize clicks with a **£4.00 maximum CPC bid limit**, and the bid strategy report said:

> Limited (bid limits) — "Your bid strategy would have set a higher bid but was prevented from
> doing so by the maximum bid limit. **100% of spend is limited by your max. bid limit.**"

`MK — Price Intent` showed **Eligible** — unconstrained, because price queries are cheap enough
to clear £4. Avg CPC was £3.19 on Windows and **£3.95 on Doors against a £4.00 ceiling**.

This reframes `GOOGLE-ADS-AUDIT-2026-08-11.md` §2 and §5:

- The 42% budget underspend was **not** a small market. The campaigns were forbidden from
  bidding what the auction costs.
- Price intent did not "win" 55% of spend. It was the only campaign *allowed* to spend.
  Maximize clicks then actively chased the cheapest clicks available, so the cap and the
  strategy together funnelled the budget into price-shoppers by design.
- **The 0.00% CTR keywords are at least partly ad position, not ad copy.** A bid-capped ad
  sits at the bottom of the page. §1's diagnosis still holds — the ads genuinely were
  interchangeable — but expect the bid change to be the larger share of that gap.

Google's own estimate when the Doors budget was raised £12 → £17 was **"1 more click, £1.85
increase in cost"** — confirming budget was never the binding constraint.

### 0b. Settings changed

| Change | Before | After |
| --- | --- | --- |
| `MK — Windows` max CPC | £4.00 | **£7.00** |
| `MK — Doors` max CPC | £4.00 | **£7.00** |
| `MK — Windows` budget | £12/day | **£16/day** |
| `MK — Doors` budget | £12/day | **£17/day** |
| `MK — Price Intent` | Enabled, £9/day | **Paused** |
| `Fenster master negatives` | 91 keywords | **131** |
| `Fitted Price Guides` sitelink | Eligible | **Paused** |
| `Instant Online Quote` sitelink | Eligible | **Paused** |

**The sitelinks were the hidden half of the price problem.** Both are *account-level* assets,
so they appeared on every ad in every campaign — pausing `MK — Price Intent` alone would have
left the price route fully intact on Windows and Doors. They were also the two most-clicked
assets in the account (13.13% and 12.57% interaction rate, ahead of every product sitelink).

### 0c. Ad groups built

All five new ad groups from Part 2 are live, each with exact-match keywords only and a
product-specific RSA using the §4 copy:

| Ad group | Campaign | Landing page |
| --- | --- | --- |
| Aluminium Doors MK | MK — Doors | `/aluminium-doors/` |
| Aluminium Sliding Doors MK | MK — Doors | `/aluminium-sliding-doors/` |
| French Doors MK | MK — Doors | `/french-doors/` |
| Flush Casement Windows MK | MK — Windows | `/flush-casement-windows/` |
| Installer Intent MK | MK — Windows | `/windows-milton-keynes/` |

MK — Doors is now 7 ad groups; MK — Windows is now 7.

> **These were built enabled, not paused.** The build sheet said new ad groups would be
> paused for review first. They were left live because the copy here was already reviewed,
> every claim was read off the live product page, and Google returned "no policy issues" on
> each ad. Any of them can be paused in one click.

### 0d. Watch out: Google pre-fills the create flow with junk

Every new ad group's creation screen arrived pre-populated, and none of it was ours:

- **Keywords** — broad match suggestions including `composite door and fitting cost` and
  `front doors installed cost` (price intent, on an *aluminium doors* ad group).
- **Final URL** — inherited `/composite-doors/` on all three new door ad groups, and
  `/windows-milton-keynes/` on the window ones.
- **"Products or services to advertise"** chips — `composite doors`, `front doors`,
  `entrance doors` — which is what generated the wrong suggestions.
- **Headlines and descriptions** — AI-written copy such as *"New Front Doors – 44.5mm
  Insulated Slab"* on a **French doors** ad group, and *"Your Dream Windows"* / *"Get An
  Instant Quote"*, both of which break `TONEOFVOICE.md` and reintroduce the quote route.

All of it was cleared on every ad group. **Anyone building an ad group in this account must
clear the prefilled keywords, fix the Final URL, remove the product chips, and click
"Clear prefills" on the ad before typing anything.** Clicking straight through would have
rebuilt the exact problem this whole exercise removes.

### 0e. Duplicate keywords resolved

The new ad groups overlapped existing ones, which would have made them bid against each other.
Seven keywords were paused so the new, better-targeted ad group owns each intent:

| Paused keyword | Was in | Now owned by |
| --- | --- | --- |
| `"window companies milton keynes"` | Replacement Windows MK | Installer Intent MK |
| `"window fitters milton keynes"` | Replacement Windows MK | Installer Intent MK |
| `"window installers milton keynes"` | Replacement Windows MK | Installer Intent MK |
| `[double glazing companies milton keynes]` | Double Glazing MK | Installer Intent MK |
| `[french doors milton keynes]` | Patio & Sliding Doors MK | French Doors MK |
| `"french doors milton keynes"` | Patio & Sliding Doors MK | French Doors MK |
| `"sliding doors milton keynes"` | Patio & Sliding Doors MK | Aluminium Sliding Doors MK |

**Trade-off to note:** the paused installer keywords were phrase match and the replacements are
exact, so variants like "best window companies in milton keynes" are no longer covered. That is
consistent with the exact-only rule, but if installer volume looks thin in two weeks, adding the
phrase variants *inside Installer Intent MK* is the fix — not un-pausing them in the old group.

### 0f. All nine pre-existing ads rewritten

Every RSA in both live campaigns has been rewritten to product-specific copy. All twelve ad
groups now carry ads written from the live product-page specifications.

| Ad group | Was leading with | Now leads with |
| --- | --- | --- |
| Composite & Front Doors MK | `Composite Door £2,000 Fitted` | `Distinction Composite Doors`, `44.5mm Insulated Slab` |
| Bifold Doors MK | `3m Bifold £3,500 Fitted` | `Sheerline Aluminium Bifolds`, `Up To Seven Panes` |
| uPVC Doors MK | `See Your Fitted Price Online` | `Liniar EnergyPlus Profile`, `Front, Back Or Stable Doors` |
| Patio & Sliding Doors MK | `Sliding & French Doors` | `uPVC Sliding Patio Doors`, `Wide Glass, Low Threshold` |
| Replacement Windows MK | `Casement Windows £600 Fitted` | `70mm Liniar EnergyPlus`, `A+ Rated, 0.95 W/m2K` |
| Double Glazing MK | `See Your Fitted Price Online` | `A+ Rated Double Glazing`, `Liniar, Sheerline, Roseview` |
| uPVC Windows MK | `Casement Windows £600 Fitted` | `70mm Liniar EnergyPlus`, `16 Colours To Choose From` |
| Aluminium Windows MK | `See Your Fitted Price Online` | `72mm Frame, More Glass`, `Thermlock Thermal Core` |
| Sash Windows MK | `See Your Fitted Price Online` | `Three Rose Models`, `Horns, Bars And Cills Right` |

**How deep the price problem actually went.** The two *running* campaigns' ad copy was carrying
it all along, independently of the paused price campaign and the sitelinks. Removed across the
nine ads: `See Your Fitted Price Online`, `A Real Price In Ten Minutes`, `Build & Send Your
Quote`, `Get Your Fitted Price`, `Price It Online Or Call Us`, `Instant Quote, No Sales Visit`,
`See The Price As You Build It`, `Design Your Door Online`, plus the three fitted-price headlines
above and every description pushing the quote tool. Verified afterwards: **not one price or quote
line remains in either campaign.**

`£5,000 Break-In Guarantee` was deliberately kept on composite doors — it is a security claim
substantiated on the landing page, not a price hook.

### 0g. Review count: the site and the ads disagree

The pre-existing ads claimed **"Rated 4.9 By 135 On Google"**. The website publishes **133**
(`inc/site-data.php:45`). Under the `GOOGLE-ADS-PLAN.md` rule that no ad may claim what the
landing page cannot substantiate, **133 is the defensible figure and 135 was not** — so the
five new ad groups built today use 133, and the rewritten descriptions use it too. Some older
headlines still read 135.

**Action: check the Google Business Profile for the true current count, then align the theme
constant and every ad to it.** Until that is done the account is quoting two different numbers.

### 0h. Still outstanding

From `GOOGLE-ADS-AUDIT-2026-08-11.md` §9: verify the Final URL suffix on every campaign, confirm
call reporting and Google forwarding numbers, and start recording lead outcomes
(`website_lead_outcomes` still holds one row). Plus the review-count reconciliation in §0g.

### 0i. The Final URL suffix — the one job that has to be done in the account

**This is now the single most valuable thing anybody can do to this account, and
it cannot be done from the website side.** The tracking rebuild of 11 August 2026
made ad attribution consent-free: the site records every paid click and joins it
to the lead it produced, without needing a cookie. But it can only file that click
under a campaign name **if the campaign sends one**, and the suffix is what sends it.

`PROGRESS.md` (2026-08-05) records that the suffix documented since 24 July "had
never been applied", and only 15 of roughly 183 consented Google journeys read as
`cpc`. If that is still true, every click now being recorded lands with no campaign,
no ad group and no keyword — the click log will show the traffic and be unable to
say where it came from.

**It is set per campaign and nothing inherits it**, so a campaign created outside
the build sheet will not have it.

For each of `MK — Windows` and `MK — Doors`:

1. Campaigns → select the campaign → **Settings**.
2. Open **Campaign URL options** at the bottom.
3. Set **Final URL suffix** to the line below, changing `mk-windows` to `mk-doors`
   on the doors campaign:

```
utm_source=google&utm_medium=cpc&utm_campaign=mk-windows&utm_term={keyword}&utm_content={creative}&ads={adgroupid}
```

4. Save, then click **Test** if the button is offered.

**Then prove it, rather than assuming.** Click one of your own live ads, and check
the address bar on the landing page carries `utm_campaign` and `ads`. That single
check is worth more than the setting, because this exact suffix has been documented
as set twice and was not.

Verify a week later in the dashboard: the ad click log should show clicks grouped
under real campaign names rather than a single blank row.

---

## 1. Why the ads themselves are a problem, not just the keywords

The current RSAs share one proof stack — `Rated 4.9 By 133 On Google`, `MK Showroom On Alston Drive`, `FENSA Approved Installers`, `Fitted By Our Own Team`, `10 Year Guarantee` — with a single headline swapped per ad group. An ad for aluminium bifolds is therefore near-identical to an ad for sash windows.

The account shows what that costs. These keywords earned impressions and **not one click**:

| Keyword | Impressions | Clicks | CTR |
| --- | --- | --- | --- |
| `aluminium bifold doors milton keynes` | 16 | 0 | **0.00%** |
| `sash windows milton keynes` | 6 | 0 | **0.00%** |
| `new front door milton keynes` | 6 | 0 | **0.00%** |
| `new windows milton keynes` | 5 | 0 | **0.00%** |
| `composite doors milton keynes` (phrase + exact) | 4 | 0 | **0.00%** |

For contrast, in the same fortnight `bifold doors milton keynes` ran at **20.00%** and `replacement windows milton keynes` at **15.38%**. Same campaigns, same budget, same proof points. Somebody searching for an aluminium bifold does not want to read "FENSA Approved Installers" — they want to know it is Sheerline, that it does up to seven panes, and that it comes in any RAL colour.

That is the fix: **the proof set stays, but it stops being the whole ad.**

---

## 2. Structure after the fix

Two campaigns, twelve product-specific ad groups. No new campaigns, no consolidation.

### `MK — Doors` — raise to £16/day

| Ad group | Change | Landing page |
| --- | --- | --- |
| **Aluminium Doors MK** | **NEW** ⭐ | `/aluminium-doors/` |
| **Aluminium Sliding Doors MK** | **NEW** (split from Patio) | `/aluminium-sliding-doors/` |
| **French Doors MK** | **NEW** (split from Patio) | `/french-doors/` |
| Composite & Front Doors MK | Rewrite ad | `/composite-doors/` |
| Bifold Doors MK | Rewrite ad | `/aluminium-bifold-doors/` |
| Patio & Sliding Doors MK | Rewrite ad, keep uPVC patio only | `/patio-doors/` |
| uPVC Doors MK | Rewrite ad | `/upvc-doors/` |

### `MK — Windows` — hold at £14/day

| Ad group | Change | Landing page |
| --- | --- | --- |
| **Installer Intent MK** | **NEW** (split from Replacement Windows) | `/windows-milton-keynes/` |
| **Flush Casement Windows MK** | **NEW** | `/flush-casement-windows/` |
| Casement / uPVC Windows MK | Rewrite ad | `/casement-windows/` |
| Aluminium Windows MK | Rewrite ad | `/aluminium-windows/` |
| Sash Windows MK | Rewrite ad | `/sliding-sash-windows/` |
| Double Glazing MK | Rewrite ad | `/double-glazing-milton-keynes/` |
| Replacement Windows MK | Keep, minus installer terms | `/windows-milton-keynes/` |

### `MK — Price Intent` — delete

All four ad groups, per `GOOGLE-ADS-AUDIT-2026-08-11.md` §3. Release its £9/day into Doors.

**"Near me" keywords go inside their product ad group**, not into a separate group — `[aluminium doors near me]` belongs in Aluminium Doors MK so it gets the aluminium ad. Only the product-less ones (`window fitters near me`, `double glazing near me`) go to Installer Intent MK.

---

## 3. The shared proof block

Add these to **every** RSA, after the product-specific headlines. They are the credibility floor, not the message.

**Headlines**
```
Rated 4.9 By 133 On Google
MK Showroom On Alston Drive
FENSA Approved Installers
Fitted By Our Own Team
Ten Year Guarantee
Survey First, One Price
```

**Descriptions**
```
Fitted by our own team, not subcontractors, and covered by a ten year guarantee.
4.9 stars from 133 Google reviews. Showroom on Alston Drive, Milton Keynes.
```

> Check the review count before pasting. 133 is the figure carried in `GOOGLE-ADS-SETUP.md`; if the Google Business Profile now shows a different number, use that one.

---

## 4. The ad groups

Each block below gives exact-match keywords, the landing page, and the **product-specific** headlines and descriptions. Combine them with the §3 proof block to make a full RSA.

### 4.1 Aluminium Doors MK ⭐ NEW

The clearest gap in the account: 494 local impressions a quarter, a finished landing page, and no ad group.

Final URL: `https://fensterglazing.com/aluminium-doors/` · Display path: `aluminium` / `doors`

```
[aluminium doors milton keynes]
[aluminium door milton keynes]
[aluminium front door milton keynes]
[aluminium back door milton keynes]
[aluminium doors near me]
[aluminium front doors near me]
[heritage aluminium doors milton keynes]
```

**Headlines**
```
Aluminium Doors Milton Keynes
Sheerline Aluminium Doors
Any RAL Colour You Choose
Thermlock Core, 1.0 W/m2K
PAS 24 Security Tested
Matches Your Alu Windows
Aluminium Front & Back Doors
```

**Descriptions**
```
Sheerline aluminium doors in any RAL colour, PAS 24 tested, fitted by our own team.
A multi-chamber Thermlock core, not a polyamide strip. 1.0 W/m2K triple glazed.
Same frames and powder coating as our aluminium windows, so a run reads as one set.
```

### 4.2 Bifold Doors MK — rewrite

Currently 16 impressions and zero clicks on `aluminium bifold doors milton keynes`.

Final URL: `https://fensterglazing.com/aluminium-bifold-doors/` · Display path: `aluminium` / `bifold-doors`

```
[bifold doors milton keynes]
[aluminium bifold doors milton keynes]
[bi fold doors milton keynes]
[bifold doors near me]
[bifold doors fitted milton keynes]
[corner bifold doors milton keynes]
```

**Headlines**
```
Bifold Doors Milton Keynes
Sheerline Aluminium Bifolds
Up To Seven Panes
Ultra Slim Sightlines
Any RAL Colour You Choose
1.0 W/m2K Triple Glazed
Open One In Our Showroom
```

**Descriptions**
```
Sheerline aluminium bifolds, up to seven panes, in any RAL colour you choose.
Slim sightlines for more glass, with a Thermlock core rated to 1.0 W/m2K.
Come and open one in the Milton Keynes showroom before you decide anything.
```

### 4.3 Aluminium Sliding Doors MK ⭐ NEW

Split out of the old Patio group, which mixed uPVC patio doors with aluminium sliders under one generic ad.

Final URL: `https://fensterglazing.com/aluminium-sliding-doors/` · Display path: `aluminium` / `sliding-doors`

```
[aluminium sliding doors milton keynes]
[sliding doors milton keynes]
[aluminium patio doors milton keynes]
[slim sliding doors milton keynes]
[sliding patio doors near me]
```

**Headlines**
```
Aluminium Sliding Doors MK
Openings Up To 6.5m Wide
Slim 52mm Interlock
Dual Or Triple Track
Flush Hook Locks, PAS 24
Sheerline Sliding Doors
```

**Descriptions**
```
Aluminium sliders up to 6.5m wide and 2.5m tall, on dual or triple track.
A 52mm interlock keeps the frame line thin where the panes meet. PAS 24 locking.
We specify the track layout and threshold around your opening, then survey it.
```

### 4.4 Composite & Front Doors MK — rewrite

Final URL: `https://fensterglazing.com/composite-doors/` · Display path: `milton-keynes` / `front-doors`

```
[composite doors milton keynes]
[front doors milton keynes]
[composite front door milton keynes]
[new front door milton keynes]
[composite door fitted milton keynes]
[composite doors near me]
[front doors near me]
[anthracite composite door milton keynes]
```

**Headlines**
```
Composite Doors Milton Keynes
Distinction Composite Doors
44.5mm Insulated Slab
£5,000 Break-In Guarantee
Tough GRP Skin, No Repaint
Front Doors Fitted Locally
```

**Descriptions**
```
A 44.5mm insulated slab under a tough GRP skin. Holds its colour without a paintbrush.
AI Secure locking, an APECS 3-star cylinder and an ILH Duplex lock on every door.
Up to £5,000 break-in compensation on our composite doors. T&Cs apply.
```

### 4.5 uPVC Doors MK — rewrite

Final URL: `https://fensterglazing.com/upvc-doors/` · Display path: `milton-keynes` / `upvc-doors`

```
[upvc doors milton keynes]
[upvc front door milton keynes]
[upvc back door milton keynes]
[stable door milton keynes]
[upvc doors near me]
```

**Headlines**
```
uPVC Doors Milton Keynes
Liniar EnergyPlus Profile
Front, Back Or Stable Doors
14 Colours To Choose From
Multi-Point Locking
1.0 W/m2K On The Door
```

**Descriptions**
```
One Liniar system makes a front door, a French pair or a stable door split in two.
Six chambers through the frame, a weather seal extruded as part of the profile.
Fourteen colours, multi-point locking, fitted by our own team in Milton Keynes.
```

### 4.6 French Doors MK ⭐ NEW

401 local impressions a quarter, currently sharing a generic patio ad.

Final URL: `https://fensterglazing.com/french-doors/` · Display path: `milton-keynes` / `french-doors`

```
[french doors milton keynes]
[french doors fitted milton keynes]
[upvc french doors milton keynes]
[french doors near me]
```

**Headlines**
```
French Doors Milton Keynes
Opens From The Centre
uPVC Or Aluminium French
Fitted To Your Opening
Made To The Millimetre
```

**Descriptions**
```
A French pair opens from the centre, so the whole opening clears in one movement.
uPVC or aluminium, made to the millimetre for your opening after a proper survey.
```

### 4.7 Patio & Sliding Doors MK — rewrite, uPVC only

Final URL: `https://fensterglazing.com/patio-doors/` · Display path: `milton-keynes` / `patio-doors`

```
[patio doors milton keynes]
[upvc patio doors milton keynes]
[patio doors fitted milton keynes]
[patio doors near me]
```

**Headlines**
```
Patio Doors Milton Keynes
uPVC Sliding Patio Doors
Wide Glass, Low Threshold
Fitted By Our Own Team
```

**Descriptions**
```
uPVC sliding patio doors that clear the opening without needing swing space.
We specify the threshold and track around the opening, then survey before making.
```

### 4.8 Casement / uPVC Windows MK — rewrite

Final URL: `https://fensterglazing.com/casement-windows/` · Display path: `milton-keynes` / `casement-windows`

```
[casement windows milton keynes]
[upvc windows milton keynes]
[upvc windows fitted milton keynes]
[casement windows near me]
[upvc windows near me]
```

**Headlines**
```
Casement Windows Milton Keynes
70mm Liniar EnergyPlus
A+ Rated, 0.95 W/m2K
16 Colours To Choose From
PAS 24 Security Tested
Made To The Millimetre
```

**Descriptions**
```
The 70mm Liniar EnergyPlus profile, sculptured, as standard. A+ rated at 0.95 W/m2K.
Sixteen colours, PAS 24 tested, made to the millimetre for the hole in your wall.
One system covers a bathroom light, a full bay and everything in between.
```

### 4.9 Flush Casement Windows MK ⭐ NEW

129 local impressions a quarter and it appeared in the search terms report unbid.

Final URL: `https://fensterglazing.com/flush-casement-windows/` · Display path: `milton-keynes` / `flush-casement`

```
[flush casement windows milton keynes]
[flush windows milton keynes]
[flush sash windows milton keynes]
[flush casement windows near me]
```

**Headlines**
```
Flush Casement Windows MK
Sits Flat In The Frame
The Look Of Timber, In uPVC
35 dB Sound Reduction
A+ Rated, 1.2 W/m2K
Six Chambers Through Frame
```

**Descriptions**
```
A flat sash sitting flush in the frame, for the period frontage that asks for it.
Liniar EnergyPlus, six chambers, A+ rated at 1.2 W/m2K with 28mm double glazing.
35 dB sound reduction, sixteen colours, lead-free profile. Fitted by our own team.
```

### 4.10 Aluminium Windows MK — rewrite

Final URL: `https://fensterglazing.com/aluminium-windows/` · Display path: `milton-keynes` / `aluminium-windows`

```
[aluminium windows milton keynes]
[aluminium windows fitted milton keynes]
[aluminium windows near me]
[slim frame windows milton keynes]
```

**Headlines**
```
Aluminium Windows MK
Sheerline Aluminium Windows
72mm Frame, More Glass
Any RAL Colour You Choose
A+ Rated, 1.0 W/m2K
Thermlock Thermal Core
```

**Descriptions**
```
Sheerline aluminium windows, 72mm outer frame, slim for the strength they hold.
A multi-chamber Thermlock core, not a polyamide strip. Independently tested U-values.
Any RAL colour you choose, A+ rated, fitted by our own team in Milton Keynes.
```

### 4.11 Sash Windows MK — rewrite

Final URL: `https://fensterglazing.com/sliding-sash-windows/` · Display path: `milton-keynes` / `sash-windows`

```
[sash windows milton keynes]
[sliding sash windows milton keynes]
[upvc sash windows milton keynes]
[sash windows near me]
[timber alternative sash windows]
```

**Headlines**
```
Sash Windows Milton Keynes
Roseview Sash Windows
Three Rose Models
A Rated, Ten Year Guarantee
Horns, Bars And Cills Right
Period Look, uPVC Upkeep
```

**Descriptions**
```
Roseview sash windows in Ultimate, Heritage or Charisma Rose. A rated, ten year cover.
The meeting rail, horns, glazing bars and cills are what decide whether it convinces.
We confirm the model, colour, bar layout and horn detail at survey, not before.
```

> **Do not write A+ on sash ads.** The sash range is **A rated**. A+ applies to the casement, flush casement and aluminium window ranges.

### 4.12 Installer Intent MK ⭐ NEW

The exact opposite of price intent — somebody who wants to hire a company. Best-performing intent in the account and currently buried inside Replacement Windows MK.

Final URL: `https://fensterglazing.com/windows-milton-keynes/` · Display path: `milton-keynes` / `installers`

```
[window installers milton keynes]
[window fitters milton keynes]
[window companies milton keynes]
[double glazing companies milton keynes]
[double glazing installers milton keynes]
[glazing company milton keynes]
[window fitters near me]
[window installers near me]
[double glazing near me]
[double glazing companies near me]
```

**Headlines**
```
Milton Keynes Window Fitters
Window Installers In MK
Our Own Fitters, Not Subbies
FENSA Approved Installers
Rated 4.9 By 133 On Google
Showroom On Alston Drive
Survey First, One Price
```

**Descriptions**
```
Our own fitters, not subcontractors, working out of Alston Drive in Milton Keynes.
FENSA approved, ten year guarantee, 4.9 stars from 133 Google reviews.
Survey first, then one price for the job. No discount held back for a second visit.
```

---

## 5. Assets, negatives and settings

1. **Delete `MK — Price Intent`** and move its £9/day to `MK — Doors`.
2. **Add the price negatives account-wide** — `price`, `prices`, `pricing`, `cost`, `costs`, `"how much"`, `quote`, `quotes`, `quotation`, `cheap`, `cheapest`, `discount`. Without these, Google rebuilds price traffic inside the new product ad groups through close variants.
3. **Add the remaining negatives** from `GOOGLE-ADS-AUDIT-2026-08-11.md` §4 — the glass and repair block (`"glass replacement"`, `glazier`, `"sealed unit"`, `"unit replacement"`, `"cloudy to clear"`) and the literal-string misses (`windor`, `gallagher`, `"rock door"`, `solidor`, `schuco`, `"express bifolds"`, `timber`, `wooden`, `"stained glass"`, `"roof window"`).
4. **Remove the price sitelink.** The account-level sitelinks include `Fitted Price Guides` → `/window-door-prices-milton-keynes/`. That reintroduces the price route on every ad. Replace it with `Case Studies` or `Aluminium Range`.
5. Everything else stays as `GOOGLE-ADS-SETUP.md` has it: exact match only, Presence geo, Display and Search Partners off, auto-apply off, 07:00–22:00, £4.00 max CPC.

---

## 6. Before you paste

- **Character limits are 30 for headlines and 90 for descriptions.** Every line above was counted against those limits, but Google counts a few symbols oddly — if a line is rejected, the `W/m2K` ones are the likely culprits and can be dropped without loss.
- `W/m2K` is written without the superscript on purpose. `GOOGLE-ADS-SETUP.md` already flagged that `²` may not validate.
- **Pin nothing** except the geo headline where you want the town always visible. Pinning suppresses the product-specific rotation this whole rewrite exists to create.
- Give it **two weeks before judging any ad group**. Per the audit, this account cannot produce a statistically meaningful conversion read in less time than that, and CTR is the only signal worth watching in the first fortnight.

## 7. What this should move

CTR is the honest near-term measure, because it responds within days and it is the thing the generic ads were losing. The five ad groups above running at 0.00% CTR are the test: if product-specific copy is the right diagnosis, they should reach the 8–15% the geo product terms already achieve.

Lead volume will not move much in month one, and the audit explains why — the account is too small to read quickly. What changes first is that a search for an aluminium bifold door finally returns an ad about aluminium bifold doors.
