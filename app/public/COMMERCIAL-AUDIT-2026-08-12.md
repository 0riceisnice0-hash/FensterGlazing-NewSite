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

Two lists. Nothing below can be invented, and the pages cannot reach the louvre
standard without it.

### 6a. Decisions

1. **The new commercial replacement-glazing URL.** My recommendation is
   `/commercial-replacement-glazing/` — it is explicit, it matches the existing
   `commercial-` prefix pattern, and it will not be confused with the
   residential route. Alternatives: `/commercial-glass-replacement/` or
   `/commercial-glazing-replacement/`.
2. **The client-name files in §0 — fix now, separately from this work?**
3. **Do we take industrial and logistics work?** Long-standing open question in
   `PROGRESS.md`; that sector page was deliberately never built.
4. **Blanking panels on the louvre page** — left out when composite panels were
   excluded and never ruled on.

### 6b. Information, per page

**Commercial replacement glazing (new page)**
- What we actually do commercially: failed units only, or full reglazing?
- Do we do emergency board-up and make-safe? Response time if so?
- Maximum unit size and weight we can handle, and do we have access equipment?
- Do we do shopfront glass, toughened and laminated to order?
- Lead time on a commercial made-to-order unit versus the domestic one to two weeks.
- Do we work out of hours to keep a building trading?

**Curtain walling**
- **Which system do we fit?** Nothing on the site names one. Sheerline? Smart? Something else?
- Mullion and transom sizes, and the depth range.
- U-value achievable, and the wind-load standard we work to.
- Maximum panel size and glass weight.
- Do we do structural glazing or capped only?

**Commercial windows and doors**
- Which systems, commercial-side, for aluminium and for uPVC.
- Do we do steel? Do we do fire-rated glazing and to what rating?
- PAS 24 / Secured by Design position on commercial work.
- Do we do curtain-wall-integrated doors, or is that curtain walling's page?

**Automatic opening vents / commercial automation**
- Which AOV system and which control panels.
- The standard we certify to — EN 12101-2? Aerodynamic free area figures?
- Do we commission and hand over the fire strategy paperwork, or fit only?
- Automation: which operators, and do we service and maintain them?

**All five sector pages** (healthcare, education, student, hospitality, care homes, offices and retail)
- One real named job each, or the scope of one, even without photographs.
- Any sector-specific accreditation or compliance we hold that a buyer asks for.
- Restrictor and safety-glass positions per sector, since these differ.

**Across all of them**
- Largest commercial job we have done, by value or scope, that we may describe.
- Do we hold Constructionline Gold and SSIP for commercial tendering — and may
  those be stated on the service pages, not just the trust strip?

### 6c. Photographs I do not have

Every commercial page is currently running on scrape imagery. In rough priority:

1. **A wide shot of a commercial elevation we have glazed.** There is no honest
   hero for the hub. This is the single most valuable one.
2. **Curtain walling, ours.** We have three scrape images and no evidence any is
   our work.
3. **A commercial window and door installation in progress** — access equipment,
   a live site, hoardings. Nothing on the site shows us working commercially.
4. **An AOV**, installed, and ideally its control panel.
5. **An automatic entrance door** we have fitted.
6. **Commercial replacement glazing**: a failed unit in a shopfront or an office
   elevation, and the same opening reglazed.
7. **One building per sector** — a school, a care home, a hotel, a student block,
   an office or retail frontage. Exterior is enough.
8. **The Heal's louvres**, still unphotographed, still noted in
   `PHOTO-CHECKLIST.md`.

Same rules as the residential checklist: square on, daylight, no vans in shot,
and on a scaffolded job five full-resolution shots from the lift on the last day
is worth more than anything taken later.

---

## 7. Suggested order of work

1. **The client-name files.** Contained, and a live rule breach.
2. **The hub split.** Structural, does not need new information, and it stops a
   commercial buyer completing a loop into a homeowner page.
3. **The third-person sweep and the template headings.** One data file and one
   template, fixes eleven pages at once.
4. **Curtain walling and commercial windows and doors**, once §6b lands. These
   two carry the most search demand and the least substance.
5. **AOV and automation.**
6. **The five sector pages.** Their openings are already good; they need the
   middles replaced and one real job each.

Photography gates 4, 5 and 6 reaching the louvre standard fully, but the copy,
figures and structure can all land first.
