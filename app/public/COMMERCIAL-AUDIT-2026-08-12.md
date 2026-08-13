# Commercial Pages — Audit And Rebuild Plan

Date: 2026-08-12
Scope: the commercial hub, the eleven commercial product and sector routes, the
commercial project archive and the county pages.
Standard: `/louvre-vents/`, rebuilt 2026-08-11 and the only commercial route
that currently meets it.

Method: every commercial page fetched from **live** and read as rendered, not
from source. Templates, `inc/commercial-product-data.php`, the image references
and the asset URLs checked directly. Traffic evidence from
`SEO-AUDIT-AUG-2026.md`, `SEO-LEAD-AUDIT-2026-08-05.md` and
`GOOGLE-ADS-AUDIT-2026-08-11.md`.

---

## 0. Read this first: four client names are public in image URLs

> **SUPERSEDED THE SAME DAY BY AN OWNER RULING, AND THE FINDING WAS WRONG.**
> Owner, 2026-08-12: *"end client name is fine. just not contractor unless that
> is themselves!"* All four files below name an **end client on their own
> building** — Airbus, ROKA Dental, BFI, Greensand Country — so not one of them
> was ever a breach. The rule protects against poaching a **main contractor** who
> buys glazing repeatedly, and none of these is that.
>
> The rename in `888e98ce` shipped anyway, because it was written, verified on
> test and owner-approved before the ruling arrived, and unpicking an approved
> commit mid-job is worse than carrying a redundant one. **Do not read that
> commit as evidence the rule forbids these names.** The corrected rule is in
> `AI.md` under the Commercial Client Anonymity Rule and it is now one line:
> name the end client, never the main contractor unless the contractor owns the
> building.
>
> The section below is kept as the record of what was believed at the time.

**This breaches the Commercial Client Anonymity Rule in `AI.md` and it is live
right now.** All four return `200` on production:

| File | Where it is used |
|---|---|
| `Airbus-Commercial.jpg` | **Nine references**, including the commercial hub hero, the county page hero, the homepage commercial card and the case-studies section |
| `ROKA-Dental-Post-Fitting-2-1-scaled.jpg` | Healthcare pages, twice |
| `BFI.jpg` | Commercial imagery |
| `Greensand-Country.jpg` | Commercial imagery |

The rule exists because of exactly this. It was written on 2026-08-10 after
`Fortis-Vision-Headrow-From-Above.jpg` was found publicly reachable, and it says:
**"Check filenames, alt text, captions and `pages.json` records, not only body
copy — an asset URL is as public as a paragraph and nobody proofreads it."**
That pass fixed the one file it had found and never swept the commercial set.

Whether these are current clients, past clients or names attached to stock is
not knowable from here, and it does not change the position: the URL asserts
the relationship either way. **This should be fixed before any of the styling
work below**, and it is a contained job — rename, update references, assert the
deletion list by name, redeploy.

---

## 1. The structural fault: the hub has a replacement-glazing slot with no page behind it

The owner's read is right and the mechanism is slightly worse than described.
`/commercial-glazing/` is not itself the replacement glazing page. It carries a
five-card product row, and four cards go to real commercial routes:

| Card | Goes to |
|---|---|
| Commercial windows and doors | `/commercial-windows-and-doors/` |
| Curtain walling | `/curtain-walling/` |
| Louvres and ventilation | `/louvre-vents/` |
| AOV and automation | `/commercial-automation/` |
| **Replacement glazing** | **`/double-glazing-replacement/`** |

The fifth leaves the commercial section entirely and lands on a **homeowner**
page whose H1 is *"Misted and Blown Double Glazing"*, whose whole premise per
the Replacement Glazing Rule is a domestic frame that stays put, and which then
says *"Larger and commercial work is handled through commercial glazing"* —
sending the visitor back to the hub they arrived from.

**A commercial buyer who clicks the one card most likely to describe their job
completes a loop and lands nowhere.**

### The fix

- `/commercial-glazing/` becomes the hub **only**. It already behaves as one and
  it is the right URL to keep: the old site's `/commercial/` carries **81k GSC
  impressions** and 301s into it, and the commercial cluster
  (`commercial window installation / installers / contractors / replacement`)
  sits at **~9,800 impressions, positions 4–10** against it.
- A new commercial replacement-glazing route is created and the fifth card
  points there.
- `/double-glazing-replacement/` keeps its residential hand-off line but points
  at the new route instead of the hub, which closes the loop properly.

**URL not yet chosen — see §6.**

---

## 2. Ten of eleven pages carry no specification figure at all

`STYLE.md`, Commercial Pages: *"**Give them the number they have to put in a
schedule.** Free areas, blade centres, depths, RAL. A commercial page that
describes a product without its figures has not done its job."*

| Route | Figures on the page |
|---|---|
| `/louvre-vents/` | Blade centres, both free areas, EN 13030:2002, frame depths, four systems |
| `/healthcare-construction/` | one incidental `34mm` |
| **The other nine** | **none** |

Curtain walling names no system, no mullion or transom sizes, no U-value, no
wind-load standard. Commercial windows and doors names no system at all.
Automatic opening vents names no standard, no free area, no control type. These
are pages written for people who price work.

---

## 3. Every page except louvre is the same page

Eleven routes share `commercial-product.php` and, below the hero, the same four
bands in the same order. Three headings are **identical across all of them**:

- "What Fenster can check, supply and install."
- "Buildings Fenster can look at for this type of work."
- "Send Fenster your `<product>` brief."

Word counts sit in a 1,613–1,785 band for ten of the eleven; louvre is 2,340.
The sector pages are the partial exception and deserve credit: their opening
headings are genuinely in the Fenster voice — *"Nobody moves out while we
work."*, *"The students arrive in September whether the building is ready or
not."*, *"Every room we are working in is a room you are not selling."* Those
are good and should survive the rebuild. It is the middle of each page that is
template.

---

## 4. The copy is in the third person, in headings, on eleven live pages

`STYLE.md` and `TONEOFVOICE.md` both require we/our/you. The commercial set says
**"Fenster can"** 12 times in the data and 3 more hardcoded in the template,
including in H2s a visitor reads first. This is the fault `COPY-AUDIT.md` §2
catalogued for the residential template and fixed there; commercial was never
swept.

---

## 5. The imagery is scrape-era and partly wrong-product

Every commercial page draws from `assets/images/imported/`, the scrape archive.
Beyond the client names in §0:

- **`Residential_Door_08.jpg` is on a commercial page.** `AI.md` already records
  this exact file as a wrong-product image: a cottage-style slab that reads
  composite, pulled from the uPVC doors pool for that reason.
- **`aluminium-doors-northampton-2.jpg` is used twice.** `AI.md` records it as a
  dusk CGI render deliberately removed from the doors hub tile on 2026-07-29,
  because a render in a row of photographs is the first thing the eye lands on.
- **`Smart-043-003.jpg`, `SM-033-006.jpg`, `SM_019_00005.jpg`** are Smart Systems
  marketing photography. We sell Sheerline, and the Heritage Windows Rule
  explicitly says not to name that competitor on a page. Using their product
  photography is the same issue wearing a different coat.
- Four images are reused across two pages each, so the set already looks thin
  before anything is removed.

---

## 6. What I need from you

**Updated 2026-08-12, after the rebuild.** Everything that could be built without
your input has been built. What is left is genuinely blocked on facts only you
have, and the pages are already carrying the rows — each one renders as
"Confirming — ask and we will send it" until a real value replaces it.

**Filling one in is a one-line edit.** Every unconfirmed figure is the single
sentinel `FENSTER_SPEC_TBC` in `inc/commercial-product-data.php`. Replace it with
the value and the page updates; nothing else moves. The list below is generated
from that file by `fenster_commercial_spec_pending()`, so it cannot drift out of
step with what the site is actually showing.

### 6a. Decisions

1. ~~**The new commercial replacement-glazing URL.**~~ **Done:**
   `/commercial-replacement-glazing/`, live on test.
2. ~~**The client-name files — fix now, separately?**~~ **Closed 2026-08-12 by
   owner ruling:** the end client may be named; only a main contractor may not,
   unless the contractor owns the building. All four flagged filenames were end
   clients on their own buildings, so none was a breach. The rename shipped
   anyway because it was already written and approved.
3. **Do we take industrial and logistics work?** Still open. That sector page is
   still deliberately not built.
4. **Blanking panels on the louvre page** — still open, never ruled on.
5. **May Constructionline Gold and SSIP be stated as tendering credentials on
   the commercial service pages**, not just in the site-wide trust strip? The hub
   links both existing pages; it makes no new claim.

### 6b. The specification figures still outstanding

**Five, down from thirty-one.** The owner answered on 2026-08-12 and everything
confirmed is on the pages. What is left is genuinely unknown or hedged, and the
rows render as "Confirming — ask and we will send it" until a value replaces the
`FENSTER_SPEC_TBC` sentinel. One-line swap each.

**Curtain walling** (`/curtain-walling/`)

- Achievable U-value for the system, and at what glazing specification
- Maximum panel size and glass weight we can handle
- Structural glazing or capped only? Answered "capped only (i think)" — needs confirming before it is published

**Automatic opening vents** (`/automatic-opening-vents/`)

- The standard we install AOV units to (EN 12101-2 or otherwise)
- Aerodynamic free area figures for the units we fit

**Two answers deliberately did not become published figures.** Mullion and
transom sizes were answered "irrelevant", so that row was removed rather than
left pending: a row nobody should ask about is worse than no row. And structural
versus capped was answered "capped only (i think)" — a hedge is not a
confirmation, and this repository has a written history of confident invented
figures reaching test.

### 6c. Photographs

**No route ships a marked placeholder any more.** The owner supplied four images
on 2026-08-12 and every slot is filled. The remaining gaps are quality rather
than absence, and the full list — written to be forwarded to the commercial team
— is in `PHOTO-CHECKLIST.md`. In priority order the top five are:

1. A wide commercial elevation for the hub hero.
2. Curtain walling, a second job. One exists and it is the most searched
   commercial product we sell.
3. An automatic entrance showing the operator, on a job of ours.
4. Inside a live clinical or care setting.
5. A distribution or manufacturing building.

---

## 7. Suggested order of work


**Status as of 2026-08-12, end of the rebuild session.**

1. ~~**The client-name files.**~~ **Shipped to test** in `888e98ce`, and then
   ruled unnecessary by the owner the same day. See the banner on §0.
2. ~~**The hub split.**~~ **Done.** `/commercial-glazing/` is a hub only and
   `/commercial-replacement-glazing/` exists. The rebuild also found a second
   structural fault the audit missed: **the hub linked five of the twelve
   commercial routes.** AOV and all six sector pages had no way in from it. Two
   card rows now cover all twelve, asserted by the render harness.
3. ~~**The third-person sweep and the template headings.**~~ **Done.** Zero
   third-person references survive in commercial copy. The three shared headings
   are per-route, and the harness fails if any two routes share an H2 — which it
   did catch, because the first pass replaced three identical headings with
   three new identical ones.
4. ~~**Curtain walling and commercial windows and doors.**~~ **Rebuilt**, with
   specification tables carrying marked pending rows for the figures in §6b.
   Curtain walling now has real proof: the Bletchley depot study claims it.
5. ~~**AOV and automation.**~~ **Rebuilt.** AOV runs on the All Hallows
   photography, which was sitting unused in the case-study library while the
   route ran on a scrape-era facade shot. Automation ships a marked placeholder,
   because we own no photograph of a powered entrance.
6. ~~**The five sector pages.**~~ **Done**, and lighter than expected: their
   copy was already good, so they took specification tables, per-route headings
   and their case-study proof rather than new middles.

**What is left is §6b and §6c** — figures and photographs. Both are owner-held,
both are one-line swaps when they arrive, and every page already renders the row
or the placeholder that is waiting for them.
