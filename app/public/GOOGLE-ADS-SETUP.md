# Google Ads Setup — Click-By-Click Build Guide

Date: 2026-07-24. Companion to `GOOGLE-ADS-PLAN.md` (the strategy and the reasoning).
This is the execution manual: follow it top to bottom. Everything is filled out — names, budgets, keywords, ads, character-checked copy you can paste.

**One rule before you start: everything gets built PAUSED.** You will build all three campaigns first (Parts 1–5, your request), then wire the tracking (Part 6), and only then press Enable (Part 7). Spending before tracking is how last year happened.

---

## Part 0 — Account hygiene (10 minutes, do first)

1. Sign in at **ads.google.com** to the existing account (the one with "BOF [2026 Edit] Instant pricing").
2. **Pause the old campaign for good:** Campaigns → tick "BOF [2026 Edit] Instant pricing" → Edit → Pause. Do not reuse or rename it — its history teaches Google the wrong lessons.
3. **Kill auto-apply:** left menu **Recommendations** → top right **Auto-apply** → untick **everything** on both tabs (Maintain your ads / Grow your business) → Save. If a Google rep ever emails offering a "free account review", decline.
4. **Confirm auto-tagging is ON:** Admin (or Tools & Settings ⚙) → **Account settings** → Auto-tagging → "Tag the URL that people click through from my ad" = **Yes**. This is what puts the gclid on clicks.
5. **Turn call reporting ON:** Account settings → **Call reporting** → On. This gives you Google forwarding numbers so calls from ads are measured.
6. Check **Billing** is active and the card is current.

---

## Part 1 — Shared negative keyword list (15 minutes)

Tools & Settings ⚙ → Shared library → **Exclusion lists** (or "Negative keyword lists") → **+** → Name: `Fenster master negatives`

Paste this block in (one per line, leave them as broad negatives exactly as written):

```
supply only
diy
trade
wholesale
buy online
for sale
delivered
self fit
how to fit
how to install
howdens
wickes
b&q
screwfix
wren
magnet
eurocell
selco
travis perkins
jewson
dunster
internal
interior
bedroom
wardrobe
shower
garage door
velux
skylight
conservatory roof
curtains
greenhouse
shed
caravan
car
windscreen
jobs
careers
vacancies
apprenticeship
course
training
second hand
used
ebay
gumtree
marketplace
grants
free windows
council
housing association
anglian
everest
safestyle
crown windows
custom glaze
gallaghers
t&k
win-dor
window pains
elements windows
infinite windows
martindale
park lane windows
dovista
cloudy2clear
checkatrade
trustatrader
fenster
northampton
luton
stevenage
bedford
hitchin
letchworth
dunstable
corby
kettering
wellingborough
banbury
oxford
london
meaning
german
translation
repair
repairs
misted
blown
hinge
resealing
```

Save. Then: inside the list → **Apply to campaigns** — you'll do this after the campaigns exist (Part 5, step 2).

> Two notes: `fenster` is negative because you're organic #1 with sitelinks — don't pay for your own name. `repair/misted/blown` are negative because a £1k budget is for installations; if you later want a repairs campaign, it gets its own campaign and these come off there only.

---

## Part 2 — Campaign 1: "MK — Windows"

Campaigns → **+ New campaign**.

**The creation wizard, screen by screen:**

1. **Objective:** choose **"Create a campaign without a goal's guidance"** (bottom option; if your UI forces a goal, pick "Leads" but untick every goal type it suggests on the next screen — you'll attach real conversions in Part 6).
2. **Campaign type:** **Search**.
3. "Ways to reach your goal": **untick** Website visits / Phone calls prompts if shown (they just add clutter).
4. **Campaign name:** `MK — Windows`
5. **Bidding:** click "or select a bid strategy directly" → **Manual CPC** if offered, otherwise **Clicks** → tick **"Set a maximum cost per click bid limit"** → `£4.00`. Untick "Help increase conversions with Enhanced CPC" if shown.
6. **Networks:** **UNTICK BOTH** "Include Google search partners" and "Include Google Display Network". Non-negotiable.
7. **Locations:** choose "Enter another location" → **Add these, one at a time:**
   - Milton Keynes, England
   - Newport Pagnell
   - Woburn Sands
   - Leighton Buzzard
   - Buckingham, Buckinghamshire
   - Olney, Buckinghamshire
   Then **Location options** (small dropdown): Target = **"Presence: People in or regularly in your targeted locations"** ← this is the setting that stops last year's national bleed. Exclude = Presence.
   **Excluded locations:** Northampton; Luton; Bedford; Stevenage; Dunstable; Aylesbury.
8. **Languages:** English.
9. **Audience segments:** skip (add nothing).
10. **More settings:**
    - **Ad rotation:** Optimise.
    - **Ad schedule:** Monday–Sunday, **07:00–22:00**.
    - **Broad match keywords:** if a toggle "Use broad match" appears — **OFF**.
    - **Automatically created assets:** Off (both text and final URL).
    - **Campaign URL options → Final URL suffix:**
      `utm_source=google&utm_medium=cpc&utm_campaign=mk-windows&utm_term={keyword}&utm_content={creative}&ads={adgroupid}`
11. **Budget:** `£12` per day.

**Now the ad groups.** Create these five (during the wizard or after via Campaigns → MK — Windows → Ad groups → +). Default ad group bid: £2.50.

### Ad group 1: Double Glazing MK
Final URL for its ad: `https://fensterglazing.com/double-glazing-milton-keynes/`

Keywords (paste exactly — quotes mean phrase, brackets mean exact):
```
[double glazing milton keynes]
"double glazing milton keynes"
[double glazing companies milton keynes]
"double glazing installers milton keynes"
"double glazing quote milton keynes"
[double glazing bletchley]
"double glazing newport pagnell"
```

**Responsive Search Ad** (Ads → + → Responsive search ad):
- Final URL: as above. Display path: `milton-keynes` / `double-glazing`
- Headlines (add all; pin nothing except H1 if you want the geo always visible):
  1. `Double Glazing Milton Keynes`
  2. `See Your Fitted Price Online`
  3. `A Real Price In Ten Minutes`
  4. `Casement Windows £600 Fitted`
  5. `Rated 4.9 By 133 On Google`
  6. `MK Showroom On Alston Drive`
  7. `FENSA Approved Installers`
  8. `Fitted By Our Own Team`
  9. `10 Year Guarantee`
  10. `Price It Online Or Call Us`
  11. `Survey First, One Price`
  12. `New Windows, Milton Keynes`
- Descriptions:
  1. `Price your own windows online in ten minutes. Your sizes, your colours, a real figure.`
  2. `A 1200x1200 casement window is £600 fitted inc VAT. Checked prices, published online.`
  3. `Fitted by our own team and covered by a ten year guarantee. Showroom in Milton Keynes.`
  4. `4.9 stars from 133 Google reviews. Survey first, one price, no games.`

### Ad group 2: Replacement Windows MK
Final URL: `https://fensterglazing.com/windows-milton-keynes/`
```
[replacement windows milton keynes]
"replacement windows milton keynes"
[new windows milton keynes]
"window installers milton keynes"
"window fitters milton keynes"
"window companies milton keynes"
"window installation milton keynes"
```
RSA: reuse the Ad group 1 headlines/descriptions but swap H1 → `Replacement Windows MK` (22) and add `Window Installers In MK` (23). Display path: `milton-keynes` / `windows`

### Ad group 3: uPVC Windows MK
Final URL: `https://fensterglazing.com/casement-windows/`
```
[upvc windows milton keynes]
"upvc windows milton keynes"
"upvc windows fitted milton keynes"
[casement windows milton keynes]
"casement windows milton keynes"
```
RSA: H1 `uPVC Windows Milton Keynes` (26); include `Casement Windows £600 Fitted`, `A+ Rated Liniar Windows` (23). Descriptions 1, 2, 4 from Ad group 1 plus:
`Liniar EnergyPlus uPVC windows, A+ rated, fitted by our own team with a 10 year guarantee.`

### Ad group 4: Aluminium Windows MK
Final URL: `https://fensterglazing.com/aluminium-windows/`
```
[aluminium windows milton keynes]
"aluminium windows milton keynes"
"aluminium windows fitted milton keynes"
```
RSA: H1 `Aluminium Windows MK` (20), `Slim Frames, More Glass` (22), `Sheerline Aluminium Windows` (27) + shared proof headlines. Description:
`Sheerline aluminium windows with slim frames and more glass. Price yours online today.`

### Ad group 5: Sash Windows MK
Final URL: `https://fensterglazing.com/sliding-sash-windows/`
```
[sash windows milton keynes]
"sash windows milton keynes"
"sliding sash windows milton keynes"
"upvc sash windows milton keynes"
```
RSA: H1 `Sash Windows Milton Keynes` (26), `Roseview uPVC Sash Windows` (26), `For Period Homes, A Rated` (25) + shared proof headlines. Description:
`Roseview sash windows for period homes. A rated, authentic detail, fitted by our own team.`

---

## Part 3 — Campaign 2: "MK — Doors"

Repeat the Part 2 wizard identically except:
- **Campaign name:** `MK — Doors`
- **Budget:** `£12` per day
- **Final URL suffix:** `utm_source=google&utm_medium=cpc&utm_campaign=mk-doors&utm_term={keyword}&utm_content={creative}&ads={adgroupid}`
- Everything else (bidding £4 cap, networks off, locations, presence, schedule, exclusions) identical.

### Ad group 1: Composite & Front Doors MK
Final URL: `https://fensterglazing.com/composite-doors/`
```
[composite doors milton keynes]
"composite doors milton keynes"
[front doors milton keynes]
"front doors milton keynes"
"composite front door milton keynes"
"new front door milton keynes"
"front door fitted milton keynes"
"composite door fitted milton keynes"
```
RSA — Display path: `milton-keynes` / `front-doors`
- Headlines:
  1. `Composite Doors Milton Keynes`
  2. `Composite Door £2,000 Fitted`
  3. `£5,000 Break-In Guarantee`
  4. `Design Your Door Online`
  5. `See The Price As You Build It`
  6. `Rated 4.9 By 133 On Google`
  7. `MK Showroom On Alston Drive`
  8. `Distinction Doors, Fitted`
  9. `FENSA Approved Installers`
  10. `Fitted By Our Own Team`
  11. `Front Doors Fitted Locally`
- Descriptions:
  1. `A 900x2100 composite door is £2,000 fitted inc VAT. Price your own door online.`
  2. `AI Secure locking, APECS 3-star cylinder and ILH Duplex lock on every door we fit.`
  3. `Up to £5,000 break-in compensation on our composite doors. T&Cs apply.`
  4. `Design your door online and watch the price build. Then we survey and confirm it.`

### Ad group 2: Bifold Doors MK
Final URL: `https://fensterglazing.com/aluminium-bifold-doors/`
```
[bifold doors milton keynes]
"bifold doors milton keynes"
"aluminium bifold doors milton keynes"
"bifold doors fitted milton keynes"
"bi fold doors milton keynes"
```
RSA: H1 `Bifold Doors Milton Keynes` (26), `3m Bifold £3,500 Fitted` (23), `Sheerline Bifolds, Fitted` (25), `Up To 7 Panes, 1.0 W/m²K`* (*only if the character/symbol validates; otherwise `Up To Seven Pane Bifolds` (24)) + shared proof headlines. Descriptions:
  1. `A 3000x2100 aluminium bifold is £3,500 fitted inc VAT. Price your own doors online.`
  2. `Sheerline Prestige bifolds fitted by our own team. See it in the Milton Keynes showroom.`

### Ad group 3: Patio & Sliding Doors MK
Final URL: `https://fensterglazing.com/patio-doors/`
```
[patio doors milton keynes]
"patio doors milton keynes"
"sliding doors milton keynes"
"sliding patio doors milton keynes"
[french doors milton keynes]
"french doors milton keynes"
```
RSA: H1 `Patio Doors Milton Keynes` (25), `Sliding & French Doors` (22) + shared proof set. Description:
`uPVC and aluminium patio, sliding and French doors, fitted. Price yours online in minutes.`

### Ad group 4: uPVC Doors MK
Final URL: `https://fensterglazing.com/upvc-doors/`
```
[upvc doors milton keynes]
"upvc doors milton keynes"
"upvc back door milton keynes"
"upvc front door milton keynes"
```
RSA: H1 `uPVC Doors Milton Keynes` (24) + shared proof set. Description:
`Liniar uPVC front and back doors, fitted by our own team with a ten year guarantee.`

---

## Part 4 — Campaign 3: "MK — Price Intent"

Repeat the wizard again:
- **Campaign name:** `MK — Price Intent`
- **Budget:** `£9` per day
- **Final URL suffix:** `utm_source=google&utm_medium=cpc&utm_campaign=mk-prices&utm_term={keyword}&utm_content={creative}&ads={adgroupid}`
- All other settings identical. The geo targeting is what makes the non-geo price keywords safe: only people physically in the radius ever see them.

### Ad group 1: Double Glazing & Window Prices
Final URL: `https://fensterglazing.com/window-door-prices-milton-keynes/`
```
[double glazing prices milton keynes]
"double glazing prices milton keynes"
"double glazing cost milton keynes"
[window prices milton keynes]
"window prices milton keynes"
"new windows cost"
"how much are new windows"
"replacement windows cost"
"double glazing prices"
"window replacement cost"
```
RSA — Display path: `milton-keynes` / `prices`
- Headlines:
  1. `Window Prices Milton Keynes`
  2. `Real Fitted Prices Online`
  3. `Casement Windows £600 Fitted`
  4. `See Prices In Ten Minutes`
  5. `No Salesman Needed For A Price`
  6. `Prices Include Fitting & VAT`
  7. `Rated 4.9 By 133 On Google`
  8. `Price Your Own Job Online`
  9. `MK Showroom On Alston Drive`
  10. `Checked Prices, Published`
- Descriptions:
  1. `We publish our fitted prices. A 1200x1200 casement window is £600 including VAT.`
  2. `Price your own windows and doors online in ten minutes. No visit needed for a figure.`
  3. `Every published price is one we charge, checked against our own quoting software.`
  4. `Compare us with any quote you have. One number for the job, not a teaser.`

### Ad group 2: Door Prices
Final URL: `https://fensterglazing.com/composite-door-prices/`
```
[composite door prices]
"composite door prices"
"composite door cost"
"front door cost"
"new front door price"
"front door prices fitted"
```
RSA: H1 `Composite Door Prices` (21), `£2,000 Fitted Inc VAT` (21), `£5,000 Break-In Guarantee` + price-campaign proof set. Descriptions 1 & 3 from Doors Ad group 1.

### Ad group 3: Bifold Prices
Final URL: `https://fensterglazing.com/bifold-door-cost/`
```
[bifold door prices]
"bifold door prices"
"bifold doors cost"
"how much are bifold doors"
"aluminium bifold doors price"
```
RSA: H1 `Bifold Door Prices` (18), `3m Bifold £3,500 Fitted` + proof set. Description:
`A 3000x2100 aluminium bifold is £3,500 fitted inc VAT. Price your own size online.`

### Ad group 4: Instant Quote
Final URL: `https://fensterglazing.com/online-quote/`
```
[instant window quote]
"instant window quote"
"window quote online"
"double glazing quote online"
"online window quote tool"
"double glazing instant quote"
```
RSA: H1 `Instant Window & Door Quote` (26), `A Real Price In Ten Minutes`, `Build Your Quote Online` (23) + proof set. Description:
`Choose your windows and doors, sizes and colours, and watch the price build as you go.`

> These "quote online" terms had 8–10% CTRs last year — they were only wasted because the whole country saw them. Presence-only geo fixes that.

---

## Part 5 — Assets (extensions) + attach the negative list

Do this once at **account level** (left menu: Assets → + ):

1. **Sitelinks** (4):
   | Text | Desc line 1 | Desc line 2 | URL |
   |---|---|---|---|
   | Instant Online Quote | Price your own job in minutes | Sizes, colours, a real figure | `/online-quote/` |
   | Fitted Price Guides | Checked prices we publish | Windows, doors and bifolds | `/window-door-prices-milton-keynes/` |
   | Case Studies | Recent local installs | Photographed when finished | `/case-studies/` |
   | Book A Consultation | Home or showroom visit | Mon to Fri, 9am to 4pm | `/book-a-consultation/` |
2. **Callouts:** `Fitted prices online` · `4.9 on Google` · `Milton Keynes showroom` · `FENSA approved` · `10 year guarantee` · `In-house fitters` · `24/7 phone line`
3. **Structured snippet:** Header **Types**: `Casement Windows, Sash Windows, Aluminium Windows, Composite Doors, Bifold Doors, Patio Doors`
4. **Call asset:** `01908 429200` — with call reporting On (Part 0.5).
5. **Location asset:** Assets → Location → link the **Google Business Profile** (sign-in prompt uses the GBP owner account). This is also what makes you eligible for the ad-carrying map pins Dovista and Park Lane buy.
6. **Price asset** (attach to the Price Intent campaign at minimum): Type "Products":
   - `Casement Window` — £600 — "1200x1200, fitted inc VAT" → `/window-door-prices-milton-keynes/`
   - `Composite Door` — £2,000 — "900x2100, fitted inc VAT" → `/composite-door-prices/`
   - `Aluminium Bifold` — £3,500 — "3000x2100, fitted inc VAT" → `/bifold-door-cost/`
7. **Image assets:** upload 4–6 case-study photos (square 1200x1200 + landscape 1200x628 crops) from `assets/images/case-studies/` — real installs only.

Then:

8. **Attach the negative list to all three campaigns:** Tools → Shared library → Exclusion lists → `Fenster master negatives` → Apply to campaigns → tick `MK — Windows`, `MK — Doors`, `MK — Price Intent`.
9. **Confirm all three campaigns show status "Paused".** If any auto-enabled during creation, pause it now.

---

## Part 6 — Tracking (before anything is enabled)

### 6a. What Zac's AI builds on the website (say "go" and it happens via the normal test-site workflow)

1. `dataLayer.push({ event: 'fenster_form_submitted', form_context: ... })` in the enquiry AJAX success handler in `src/js/main.js` — a plain push, **not** `trackWebsiteEvent()` (which would double-count `form_submitted` in the Marketing Dashboard, since the server already relays it).
2. The same for consultation-booking success (`fenster_consultation_booked`).
3. Hidden ad-click and `ads` tracker fields on the shared enquiry form, populated from the landing URL and persisted for 90 days for consented visitors, saved to `fenster_enquiry` post meta by `inc/enquiries.php`. WordPress-only — never sent to the Marketing Dashboard.
4. The same accepted click ID is stored server-side against the opaque `FG2` journey. Every WindowCAD URL receives both `tracking=FG2-...` and `ads={adgroupid}`; the completed WindowCAD callback joins the click ID and tracker to the private enquiry. Quote-tool opens and iframe loads are starts, not conversions.
4. Build, lint, deploy to test, verify with GTM Preview, then owner-approved live deploy per `LIVECHANGES.md`.

### 6b. Conversion actions in Google Ads (you, ~20 minutes)

Left menu **Goals → Conversions → Summary → + New conversion action**:

1. **"Enquiry form submitted"** — Website → enter `fensterglazing.com` → "Add a conversion action manually":
   - Goal category: **Submit lead form** · Value: **£40** (same for each) · Count: **One** · Click-through window: 90 days · Attribution: Data-driven → Save.
   - On the "Tag setup" step choose **Use Google Tag Manager** → note down the **Conversion ID** (`AW-XXXXXXXXX`) and **Conversion label**.
2. **"Phone number clicked"** — same flow → category **Phone call lead** · Value £40 · Count One → note ID + label.
3. **"Instant quote submitted"** — Import → CRM or other data sources → track conversions from clicks → manual upload · Category **Submit lead form** · Value £25 · Count One · Attribution **Data-driven** if offered → **Primary**. Import only WindowCAD callbacks that have a stored `gclid`, `gbraid` or `wbraid`.
   - If the old **"Quote tool opened"** action exists, keep it Secondary or remove it from campaign goals. The tool auto-loads on quote-enabled pages, so an open is not buying intent and must never drive bidding.
4. **"Consultation booked"** — category **Book appointment** · Value £60 · Count One → note ID + label.
5. **"Calls from ads"** — + New conversion action → **Phone calls** → "Calls from ads using call assets" → Call length: **60 seconds** · Value £40 → Save.

### 6c. Google Tag Manager (container `GTM-K89BCS9`, you or Zac's AI with access, ~20 minutes)

In tagmanager.google.com, open the container → Workspace:

1. **Tag: "Conversion Linker"** — New tag → tag type **Conversion Linker** → Trigger: **All Pages** → Save. (Required for Ads conversions to attribute.)
2. **Trigger: "fenster_form_submitted"** — New trigger → type **Custom Event** → Event name `fenster_form_submitted` → Save.
   Repeat for `fenster_phone_click`, `fenster_quote_opened`, `fenster_consultation_booked`.
3. **Tag: "Ads — Enquiry form"** — New tag → **Google Ads Conversion Tracking** → paste the Conversion ID + label from 6b.1 → Trigger: `fenster_form_submitted` → Save.
   Repeat: "Ads — Phone click" (6b.2 label, trigger `fenster_phone_click`), "Ads — Quote opened" (6b.3, trigger `fenster_quote_opened`), "Ads — Consultation" (6b.4, trigger `fenster_consultation_booked`).
4. **Preview** (top right) → enter `https://fensterglazing.com/contact/` → in the debug session: click a phone number (check "Ads — Phone click" fired), submit a real test enquiry with your own details (check "Ads — Enquiry form" fired — this needs 6a live first). Accept the cookie banner first: tags only exist for accepters, by design.
5. **Submit → Publish** the container version, named `Ads conversions v1`.

Known limitation, accepted for now: GTM loads only after cookie acceptance, so Google sees conversions from accepters only. Read the accept rate off the Marketing Dashboard's consent counters and mentally gross CPL down by it. Upgrading to Consent Mode v2 (denied-state pings + modelling) is a separate owner decision because it loosens the deliberately strict consent layer.

### 6d. Verify end to end

- Goals → Conversions → each action's status should move from "Inactive" to **"No recent conversions" / "Recording conversions"** within ~24h of the test firing.
- The test enquiry should sit in WordPress (`fenster_enquiry`) **with a gclid meta value** if you clicked through a paused-then-briefly-enabled ad — or simply append `?gclid=TEST123` to a URL and submit to prove the capture works.

---

## Part 7 — Launch

1. Re-check the three campaigns: budgets £12/£12/£9, max CPC £4, networks off, Presence geo, schedule 07:00–22:00, negative list attached, assets attached, conversions "Recording".
2. Select all three campaigns → **Enable**.
3. **72 hours later:** Campaigns → Insights & reports → **Search terms** → scan every query. Anything off-intent → add to `Fenster master negatives`. This is the single most important habit.
4. **Weekly, 20 minutes:** search terms → negatives; CPL per ad group; pause any ad group at 2× target CPL (£120+) with no qualified lead; check every lead got a 15-minute callback and a recorded disposition (no answer / not our area / supply-only / survey booked / quoted / won).
5. **End of month 1:** offline import of qualified leads (Goals → Conversions → Uploads) keyed by the stored gclids; rebalance budget toward whichever campaign produced *qualified* leads.
6. **After ~30 conversions:** switch each campaign's bidding to **Maximise Conversions**, then add a target CPA ≈ your observed CPL after two more weeks.

## Do-not reminders

- No broad match keywords, ever, in these campaigns.
- Never re-enable Display or Search Partners.
- Auto-apply recommendations stays off; decline rep calls.
- Every price in an ad must match the live price-guide figure — if a guide changes, change the ads the same day.
- Keep the consent layer and the Marketing Dashboard privacy boundary exactly as they are: no ad click IDs in the dashboard.
