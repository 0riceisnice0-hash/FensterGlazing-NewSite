# Case Study Priorities — 17 August 2026

Date: 2026-08-17

What this is: the pages and towns that actually earn clicks, checked against the
case studies we own, and a shot list ordered by what each new study would
unblock.

Sources:

- `SEO-PERFORMANCE-AUDIT-2026-08-17.md` — Google Search Console, 12 months to
  2026-08-15. Town and intent figures come from here.
- `HIGH-INTENT-SEARCH-PLAN.md` §5 — the striking-distance table, 2026-07-22.
- `SEO-LEAD-AUDIT-2026-08-05.md` §F3 — the town matrix measurement.
- Coverage is not estimated. It is the output of the theme's own matching
  helpers, `fenster_case_studies_for_product()` and
  `fenster_case_studies_for_town()`, run over the live data file for all 26
  product routes and all 25 town routes.

---

## 1. Read this before using the list: a case study is not a traffic asset

The 22 case study URLs earn almost nothing directly. `SEO-LEAD-AUDIT-2026-08-05.md`
measured 16 of them at **472 impressions and 2 clicks**, and adding six more has
not changed the shape. Nothing in this document should be sold to anyone as an
SEO play, and no new study should be justified by the traffic it will earn.

What they actually do, all three of which are measurable:

1. **They ungate the product case-study strip.** Four routes currently render no
   proof at all because no residential study claims them, and the strip falls
   through to unrelated jobs if it is turned on. That is a live hole on a
   product page, not a theoretical one.
2. **They are the only local proof the site owns.** The town strip renders
   nothing where there is no honest match, which is deliberate and correct, and
   means 10 of 25 town routes currently make no claim of local work.
3. **They are the answer to the CTR problem.** The site's whole 2026 gain has
   been CTR on flat impressions. Proof is what converts a visit once the click
   is won.

So the ordering below is by **what each study unblocks**, not by search volume.

---

## 2. Where the clicks actually are

### Towns, 12 months to 2026-08-15

| Town | Clicks | Impressions | CTR | Read |
| --- | --- | --- | --- | --- |
| **Hitchin** | **68** | 6,114 | **1.11%** | Best town on the site by a distance |
| Milton Keynes | — | — | 0.21% | The volume, five times worse per impression |
| Northampton | — | — | 0.03% | See below — most of it is not human |

Hitchin is the outlier and `bifold door installation hitchin` alone converts at
**23.2%**. That is a low-volume long-tail query, so do not read the percentage
as a forecast — read it as evidence that **Hitchin traffic is real people**,
which is exactly what Northampton's is not.

**Northampton is a trap.** `northampton bay windows` sits at position 3.5 with
924 impressions and **zero clicks**; `northampton sliding sash windows` at 5.5
with 984 and zero; `roof lights northampton` at 8.0 with 2,220 and zero. Ninety-two
queries in the top 1,000 hold position 12 or better with literally no clicks at
all. The August audit's reading is that this is rank-tracking software, not
customers, on four independent grounds. **Do not commission a case study to
serve a Northampton query.**

### The Milton Keynes striking-distance cluster

Real commercial intent, positions 8–19, from `HIGH-INTENT-SEARCH-PLAN.md` §5:

| Query | Impressions | Position | Do we have proof? |
| --- | --- | --- | --- |
| double glazing milton keynes | 1,742 | 16.1 | No exact study on `/double-glazing/` |
| upvc windows milton keynes | 882 | 12.3 | Yes — 3 casement studies |
| composite doors milton keynes | 813 | 7.9 | Yes — Little Horwood, Wolverton |
| front doors milton keynes | 619 | 10.5 | Yes — Wolverton uPVC doors |
| replacement windows milton keynes | 578 | 16.1 | **No** |
| window repair milton keynes | 545 | 13.8 | Deliberately none, see §5 |
| **aluminium windows milton keynes** | **521** | **18.6** | **No, and the strip is gated off** |
| bifold doors milton keynes | 508 | 14.7 | Yes — Whitehouse |
| casement windows milton keynes | 363 | 10.0 | Yes |
| window installer milton keynes | 353 | 10.2 | n/a |

---

## 3. What we own: 22 studies

**13 residential**

| Study | Location | Products claimed |
| --- | --- | --- |
| Aluminium bifold doors | Whitehouse, MK | aluminium-bifold-doors |
| Secondary glazing | Winslow, Bucks | secondary-glazing |
| Flush casement + composite door | Little Horwood, Bucks | flush-casement, composite-doors |
| uPVC window with integral blinds | Leagrave, Luton | casement-windows, integral-blinds |
| uPVC casement window | Broughton, MK | casement-windows |
| uPVC casement windows | Bolbeck Park, MK | casement-windows |
| Flush windows + slide and fold doors | Leighton Buzzard | flush-casement, slide-fold-doors |
| uPVC casement windows | Leighton Buzzard | casement-windows |
| Flush casement + composite door | Wolverton, MK | flush-casement, composite-doors, upvc-doors |
| Sheerline roof lantern | Drayton Parslow | roof-lanterns |
| Roof lantern + heritage doors | Northampton | roof-lanterns, heritage-aluminium-doors |
| Heritage aluminium doors | Wolverton | heritage-aluminium-doors |
| White Charisma Rose sash windows | Wolverton, MK | sliding-sash-windows |

**9 commercial** — Bedford (All Hallows), Tottenham Court Road (Heal's),
Bletchley depot, Leeds (Headrow Court), Coventry (Barn Hotel), Kettering
(Sunrise), Eversholt (Green Man), Woburn Sands (Roka Dental), Bishop's
Stortford (Herts and Essex Hospital).

Commercial studies do not appear on residential product or town pages by
design, so they count for nothing in the coverage below.

---

## 4. The coverage gaps, measured

### Product routes with no exact residential study — 15 of 26

Four of these are **gated off in code**, meaning the page currently shows no
case-study strip at all rather than showing the wrong jobs:

| Route | State | Unblocked by |
| --- | --- | --- |
| `/aluminium-windows/` | **Gated** (`$no_case_study_routes`) | A residential aluminium window study |
| `/tilt-turn-windows/` | **Gated** (`$no_case_study_routes`) | A tilt and turn study |
| `/heritage-windows/` | **Gated** (`$is_heritage_bespoke`) | A residential heritage window study |
| `/window-and-door-repairs/` | **Gated, permanently** | Nothing — see §5 |

The other eleven render a fallback strip under an honest "other work" heading
rather than the exact-match wording, so they are softer gaps:
`/double-glazing/`, `/french-casement-windows/`, `/bow-bay-windows/`,
`/aluminium-flush-windows/`, `/aluminium-sliding-doors/`, `/aluminium-doors/`,
`/patio-doors/`, `/french-doors/`, `/double-glazing-replacement/`,
`/roofline/`, `/cat-and-dog-flaps/`.

### Town routes with no local proof — 10 of 25

`ampthill`, `aylesbury`, **`bedford`**, `buckingham`, `dunstable`, `flitwick`,
**`hitchin`**, `letchworth`, `stevenage`, `toddington`.

Two notes that change how this list reads:

- **Hitchin is on it.** The best-performing town on the site makes no claim of
  local work, and `/aluminium-bifold-doors-hitchin/` is a live route.
- **Bedford is on it and it is not for want of a job.** The All Hallows study is
  in Bedford, but it is commercial, and commercial studies were correctly
  filtered off residential town pages on 2026-08-12.
- The 12 Milton Keynes suburbs all share the same two studies (Whitehouse and
  Broughton), because "Milton Keynes" in a location field reaches all of them.
  **A thirteenth MK study adds almost nothing to town coverage.**

---

## 5. Two things that are correctly absent — do not "fix" them

- **`/window-and-door-repairs/` will never have a case study.** The strip is
  gated deliberately: a repair is not a job we photograph as an install, and the
  route already carries its own four-step repair process. `window repair milton
  keynes` at 545 impressions is real demand, but the answer to it is the page,
  not a study.
- **Northampton and the zero-click town queries.** Covered in §2. A study
  commissioned for these serves software.

---

## 6. The priority list

Ordered by what each one unblocks. Every entry names why it is where it is.

### Tier 1 — do these first

**1. An aluminium bifold or window job in Hitchin.**
The single highest-value study available. It is the only entry that scores on
every axis at once: the best town on the site by CTR (1.11%, 68 clicks), a town
with **no local proof at all**, a live matrix route
(`/aluminium-bifold-doors-hitchin/`), and the best-converting query we own. If
the job happens to be aluminium windows rather than bifolds, it also clears
Tier 1 entry 2 in the same visit.

**2. A residential aluminium window install, anywhere in the patch.**
`aluminium windows milton keynes` is 521 impressions at position 18.6, and
`/aluminium-windows/` currently renders **no proof section whatsoever** because
the strip is gated. This is the largest live hole on a product page with real
search demand behind it. `PHOTO-CHECKLIST.md` records that exactly one
photograph exists, which is why the route is still gated.

**3. A misted-unit replacement, before and after.**
`replacement windows milton keynes` is 578 impressions at position 16.1 and
`/double-glazing-replacement/` has no exact study. **The brief is already
written** in `PHOTO-CHECKLIST.md` under "the misted-unit before/after pair", the
page is already built around a drag-across slider that needs the pair, and every
existing pair is from 2019. Lowest effort of the three because the specification
exists and nobody has to decide anything.

### Tier 2 — clears a gated route, weaker search case

**4. A tilt and turn install, shot from inside the room.**
`/tilt-turn-windows/` is gated and the page runs entirely on Liniar studio
renders. `PHOTO-CHECKLIST.md` calls this "the largest gap on any window route"
and notes we own **no photograph of one opening**. The search case is weak —
the Northampton tilt-and-turn queries are in the zero-click cluster — so this is
here on content-integrity grounds, not traffic.

**5. A heritage window job, ideally replacing steel.**
`/heritage-windows/` is gated and has been through three attempts at un-gating
it. `PHOTO-CHECKLIST.md` calls a steel before-and-after "the single most
valuable shot on this list". A dark frame (anthracite or jet black) would be
worth more than another white one.

### Tier 3 — fills a soft gap, take it if the job turns up

**6. Bedford, residential.** A town with a live route, real Bedfordshire
presence, and a commercial job we cannot use for it.
**7. Aluminium doors or aluminium sliding doors.** `/aluminium-doors/` currently
leads on an interior shot that reads as uPVC, and the bank's folder is empty.
**8. Bow or bay windows.** A configuration route with no study; `northampton bay
windows` is bot-shaped, so this is coverage rather than demand.
**9. A roofline run.** `PHOTO-CHECKLIST.md` calls the wide shot "the biggest
single asset gap on the site", but it unblocks the page's hero and gallery more
than it needs a full study.

### Explicitly not on the list

- A thirteenth Milton Keynes study. Twelve suburb routes already share two, and
  a new one adds no town coverage.
- A fourth casement or flush casement study. Three each already.
- Anything commissioned for Northampton, or for a repairs page.

---

## 7. What to do with this

The shot rules, the EXIF warning and the per-product briefs live in
`PHOTO-CHECKLIST.md` and are not repeated here. The route from a photograph to a
published study is `CASESTUDIES.md`, which is a complete one-pass guide.

The one operational note worth adding: **the location field decides town reach.**
A study written as "Hitchin, Hertfordshire" reaches the Hitchin route; one
written as "Milton Keynes" reaches twelve suburb routes at once. Check that
field against the town you meant to serve before publishing.

---

## 8. Addendum, 2026-08-26: what has happened to this list since

**The list above is a snapshot of 17 August and its dates are part of the
record. This section says what moved; it does not rewrite the list.** Three
studies shipped in the nine days after it was written and the coverage table in
§4 is stale by exactly those three.

- **Tier 2 entry 4 is half done.** The Hanslope barn study shipped on
  2026-08-19 and **ungated `/tilt-turn-windows/`**, which was the outcome this
  entry existed to buy. `$no_case_study_routes` is now `['aluminium-windows']`
  alone, so the §4 table's "Gated" row for tilt and turn is out of date.
  **The photograph is not done**: Hanslope's tilt and turn is shut in every
  frame, so `PHOTO-CHECKLIST.md`'s "no photograph of one opening" stands and the
  shot brief is unchanged.
- **Tier 1 is untouched.** No Hitchin job, no residential aluminium window, no
  new misted-unit pair. `/aluminium-windows/` is still gated and is still the
  largest live hole on a product page with real search demand behind it.
- **A thirteenth Milton Keynes study shipped, and §6 explicitly ruled one out.**
  That exclusion was written about **town coverage**, which is still correct —
  it adds none. The 2026-08-25 composite front door study was taken for a
  different reason: the customer photographed and captioned the whole install
  themselves and gave permission to republish it, which is the only study on the
  site whose words and pictures are not ours. **A study can be worth publishing
  for what it is rather than for the route it claims**, and this list only ever
  scored the second thing.
- **Also shipped: Drayton Parslow** (2026-08-18), two Distinction composite
  doors. Composite was already well covered, so it changes no priority here.

**Before using §4 or §6 again, re-run the coverage helpers rather than reading
the table.** It was generated output on the day and there are three more studies
in the file now.
