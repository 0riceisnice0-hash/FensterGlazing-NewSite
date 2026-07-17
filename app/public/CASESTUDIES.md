# Fenster Case Studies — How To Add And Maintain Them

Last updated: 2026-07-17

This is the complete guide to the residential case studies system at
`/case-studies/`. It is written so a future agent (or developer) can add a new
case study end to end in one pass, with no back and forth. Read it fully before
touching case studies.

The commercial archive at `/commercial-projects/` is a **separate, older**
system driven by `data/pages.json`. Do not confuse the two. Everything below is
about the curated residential case studies only.

---

## 1. What the system is

Residential case studies are a curated, data-driven system. You add one entry
to a PHP data file and everything else (archive card, detail page, routing,
SEO, sitemap, related links, deep links) is generated for you. It is designed
to scale to 100+ studies from one file.

The design is deliberately **clean and text-led**: no big cropped hero banner.
Each detail page is a short lead, a two-column hero (condensed text + one lead
image), a scannable specification strip, a written overview, a specification /
installers aside, and an uncropped masonry photo gallery. It sits on the
continuous page gradient with white panels, per `STYLE.md`.

### Files involved

| File | Role |
|---|---|
| `wp-content/themes/fenster/inc/case-studies-data.php` | The data. `fenster_case_studies()` returns every study. **This is the only file you normally edit.** |
| `wp-content/themes/fenster/template-parts/sections/case-studies-residential.php` | Renders the archive and detail pages from the data. |
| `wp-content/themes/fenster/template-parts/sections/case-studies.php` | Dispatcher. Sends residential slugs to the file above; commercial slugs to the legacy pages.json logic. |
| `wp-content/themes/fenster/inc/generated-pages.php` | Routing. Builds synthetic archive/detail pages, adds them to the sitemap, and keeps the retired residential studies 410. |
| `wp-content/themes/fenster/assets/images/case-studies/` | Optimised project photos. |
| `wp-content/themes/fenster/src/scss/main.scss` | Styling, all under the `fg-cs-*` namespace (search `Residential case studies (clean, text-led system`). |

---

## 2. Adding a new case study (the whole flow)

### Step 1 — Prepare the photos

Put the raw photos somewhere temporary, then optimise them into the theme.
Target: long edge 1600px, JPEG quality ~82, EXIF-stripped, auto-oriented.
Portrait and landscape are both fine — the gallery embraces mixed aspect
ratios, so **do not crop to a fixed shape**.

Use Python + Pillow (available on this machine):

```python
from PIL import Image, ImageOps
import os
SRC = r"C:\path\to\raw\photos"
DST = r"C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\assets\images\case-studies"
MAP = { "raw file.jpeg": "cs-<town>-<product>-<view>" }  # output basenames, no extension
for src, base in MAP.items():
    im = ImageOps.exif_transpose(Image.open(os.path.join(SRC, src))).convert("RGB")
    w, h = im.size
    if max(w, h) > 1600:
        s = 1600 / max(w, h)
        im = im.resize((round(w*s), round(h*s)), Image.LANCZOS)
    im.save(os.path.join(DST, base + ".jpg"), "JPEG", quality=82, optimize=True, progressive=True)
```

Naming convention: `cs-<town>-<product>-<view>.jpg`, kebab-case, honest and
descriptive. Fix any misspellings from the source filenames. Examples:
`cs-mk-whitehouse-bifold-open.jpg`, `cs-leighton-buzzard-slide-fold-closed.jpg`.

Pick the **best single photo of the actual product as the hero** (first in the
`images` array). If only one window/door was done, the hero must clearly show
that one item, not a wide shot of the whole house.

### Step 2 — Add the data entry

Open `inc/case-studies-data.php` and add an entry to the array returned by
`fenster_case_studies()`, keyed by the detail slug (the part after
`case-studies/`). Order is newest first. Use the schema in section 3.

### Step 3 — Build, lint, verify locally

```powershell
cd app/public/wp-content/themes/fenster
npm.cmd run build            # only if you touched SCSS or JS
& '<php>' -l inc/case-studies-data.php
& '<php>' -l template-parts/sections/case-studies-residential.php
```

Quick data sanity check (stub harness) to confirm every image path exists and
there are no em dashes:

```php
define('ABSPATH','/tmp/'); define('FENSTER_THEME_URI','https://x/wp-content/themes/fenster');
function home_url($p=''){return 'https://fensterglazing.com'.$p;}
function esc_url($u){return $u;} function sanitize_title($s){return strtolower(preg_replace('/[^a-z0-9]+/i','-',trim($s)));}
require 'inc/case-studies-data.php';
foreach (fenster_case_studies() as $slug=>$cs) { /* check $cs['images'] files exist, etc. */ }
```

### Step 4 — Deploy to test and verify

Follow `LIVECHANGES.md`: commit, push to GitHub `main`, rsync the theme to the
password-protected test site, flush its cache, then verify. **Never deploy
straight to live.** Verify at 1440x900 and 390x844: no horizontal overflow, H1
within the `3.6rem` ceiling, product/colour/quote links correct, gallery
lightbox opens, images load. Only promote to live after the owner approves.

That is the whole flow. No routing, template or SCSS edits are needed to add a
normal case study — it is pure data.

---

## 3. The data schema

Every entry is fully self-describing. Fields:

```php
'<detail-slug>' => [
    'title'    => 'uPVC casement window, Broughton',   // shown as H1 and card title
    'location' => 'Broughton, Milton Keynes',
    'type'     => 'Residential',                        // shown in eyebrow / card meta
    'date'     => '2026-07-02',                         // ISO yyyy-mm-dd, shown as "Installed 2 July 2026"
    'summary'  => 'One-sentence card excerpt.',         // archive card + snapshot fallback
    'lead'     => 'One or two sentence hero intro.',    // condensed, sits next to the hero image

    'products' => [                                     // internal product links (real routes only)
        ['label' => 'uPVC casement windows', 'url' => home_url('/casement-windows/')],
    ],
    'colour'   => ['label' => 'Basalt grey (RAL 7012)', 'url' => $colour_basalt],  // or null
    'specs'    => [                                     // the four-item spec strip under the hero
        ['label' => 'Product', 'value' => 'One uPVC casement window'],
        ['label' => 'System', 'value' => 'Liniar EnergyPlus 70mm uPVC'],
        ['label' => 'Colour', 'value' => 'Basalt grey outside, white inside'],
        ['label' => 'Energy rating', 'value' => 'A+ (0.95 W/m²K)'],
    ],
    'overview' => [                                      // written body; each string is a <p>. May contain <a> links.
        'Paragraph one ... <a href="' . $casement . '">uPVC casement window</a> ...',
        'Paragraph two ...',
        'Paragraph three (colour) ... <a href="' . $colour_basalt . '">basalt grey</a> ...',
    ],
    'installed' => [                                     // "What we fitted" bullet list in the aside
        'One Liniar EnergyPlus casement window',
    ],
    'installers' => [$fitter_andy],                     // fitters (see section 6). Optional.
    'review'    => [                                    // customer review (see section 7). Optional.
        'quote'  => 'Great work ... <a href="' . $team . '">Tom</a> ...',
        'author' => 'Conor and Laura',
    ],
    'images' => [                                        // first = hero; rest = gallery. Whole photos, no crop.
        ['src' => $img . 'cs-...-hero.jpg', 'caption' => 'What this photo shows, expanded from the filename.'],
        ['src' => $img . 'cs-...-2.jpg',    'caption' => '...'],
    ],
    'seo' => [
        'title_tag'        => '... | Fenster Glazing',
        'meta_description' => 'Under 160 chars, specific to this project.',
    ],
],
```

Helper variables available at the top of the function: `$img` (case-studies
image base), `$casement`, `$flush`, `$bifold`, `$slidefold` (product URLs),
`$colour_basalt`/`$colour_anthracite`/`$colour_white` (colour deep links),
`$colour_link($material,$slug)` (build more), the `$fitter_*` people, and
`$team` (Meet the Team URL).

Optional fields (`installers`, `review`, `colour`) simply don't render when
absent. `overview` and `review['quote']` are passed through `wp_kses` allowing
only `<a>`, `<strong>`, `<em>`.

---

## 4. Writing the copy

Follow `STYLE.md`. In short:

- Write as Fenster, direct **we / you** voice. Never third person ("Fenster
  does X").
- **No em dashes.** Use full stops or commas. (The harness check greps for
  them; keep them out.)
- **Be accurate. Do not invent specs.** Pull real figures from the product
  page you are linking to. Scan the live product page and lift the system
  name, U-value, energy rating and security. Current references:
  - `/casement-windows/` — Liniar EnergyPlus 70mm uPVC, 0.95 W/m²K, A+, PAS 24.
  - `/flush-casement-windows/` — Liniar 70mm flush sash, 1.2 W/m²K, A+.
  - `/aluminium-bifold-doors/` — Sheerline Prestige, 1.0 W/m²K, up to 7 panes.
  - `/slide-fold-doors/` — 10-point locking, panels slide and swing separately.
- **Match reality.** If one window was fitted, write "window" (singular) and
  say "one" in the specs. Do not describe a package when it was a single unit.
- **Captions** describe each photo, expanded from the owner's filename notes
  (e.g. "outside closed" becomes "The bifold doors closed, seen from the
  garden ..."). The caption doubles as the image `alt`.
- **Link the products and the colour** inline in the overview and in the
  aside, and always note the customer priced with the instant quote tool (the
  template adds that line automatically from `quote_url`).
- Keep manufacturer names (Liniar, Sheerline) to where Fenster genuinely sells
  that system, and keep them light.

The three overview paragraphs usually follow: (1) the brief and the product,
(2) performance / security detail, (3) colour / finish.

---

## 5. Product and colour deep links

- **Products**: link to the real family route, e.g. `home_url('/casement-windows/')`.
  Confirm the slug exists before linking (grep `data/pages.json`).
- **Colours**: use a deep link so the colour hub pre-selects the swatch and
  scrolls to it. Build with `$colour_link($material, $slug)` where `$material`
  is `upvc` or `aluminium` and `$slug` is `sanitize_title()` of the colour
  name as it appears in `inc/site-data.php` under `colour_options.materials`.
  Examples already defined: `$colour_basalt` (upvc/basalt-grey),
  `$colour_anthracite` (aluminium/anthracite-grey), `$colour_white` (upvc/white).
  Anthracite Grey exists in **both** materials, so always include `material` to
  target the right one.

  The URL looks like `/colour-options/?material=upvc&colour=basalt-grey`. The
  handler lives in `src/js/main.js` in the `[data-fg-colour-carousel]` block:
  it matches `data-colour-slug` on the swatch, pre-selects it, then (because
  Lenis pins the page at the top while the colour hero images load) pauses
  Lenis on `window.load`, jumps to the swatch, re-asserts, and hands smooth
  scrolling back. If you add a new colour, make sure its name in `site-data.php`
  sanitises to the slug you link to.

---

## 6. Installers (fitters)

Each study can list who fitted it. Clicking a fitter scrolls to their profile
on Meet the Team (every team member now has an `id` of `sanitize_title(name)`,
set in `template-parts/sections/team.php`).

Define people once at the top of `case-studies-data.php` with the `$fitter`
helper: `$fitter('Full Name', 'photo-file.png')` builds `name`, `role`
("Fitter"), `image` (from `assets/images/imported/`) and `url`
(`/meet-the-team/#full-name`). Omit the photo argument for someone with no team
profile yet (e.g. Aaron) — they render as a name-only chip with an initial, no
link.

Current fitters and photos:

| Person | Photo (`assets/images/imported/`) | Anchor |
|---|---|---|
| Tom Carter | `unnamed-8.jpg` | `#tom-carter` |
| Johnnie Greenwell | `1.png` | `#johnnie-greenwell` |
| Andy McCullagh | `7.png` | `#andy-mccullagh` |
| Zac Rugman | `8.png` | `#zac-rugman` |
| Shane Gowing | `20250617_1628580-scaled.jpg` | `#shane-gowing` |
| Aaron | (none yet) | name only |

**Important: there are two Zacs.** Zac **Rugman** is a fitter (`$fitter_zac`).
Zac **Bartley** is Marketing and must **never** appear in an installers list.

Current job → fitters mapping:
- Whitehouse bifolds — Johnnie and Tom
- Broughton — Andy
- Leighton Buzzard flush + slide/fold — Zac (Rugman) and Shane
- Leighton Buzzard casements — Aaron and Shane

If a new fitter joins, add their photo to `assets/images/imported/`, add a
`$fitter_*` line, and confirm their Meet the Team profile exists so the anchor
resolves.

---

## 7. Reviews

Add a real customer review with `'review' => ['quote' => '...', 'author' => '...']`.
The quote may hyperlink the fitters' names to `/meet-the-team/` (use the `$team`
variable). Keep the customer's authentic voice; only tidy obvious noise. No em
dashes. Attach the review to the correct project — match it by what the
customer describes (e.g. a review about "the doors" and "our kitchen" belongs
on the bifold job, not a windows job).

---

## 8. Photos, gallery and lightbox

- The **hero** uses the first image (`object-fit: cover`, capped height) — a
  tidy rectangle is fine there.
- The **gallery** shows every other image **whole** at natural aspect ratio in
  a two-column masonry (`columns: 2 22rem`). Never force a crop here.
- Every hero and gallery image is a lightbox link (`data-fg-gallery-lightbox`).
  Clicking opens the existing in-page lightbox (prev/next, Escape, click
  backdrop) — no new tab. This is wired globally in `src/js/main.js`; you get
  it for free by keeping the `fg-cs-zoom` anchor wrapper in the template.

---

## 9. Routing, sitemap and retired studies

Handled in `inc/generated-pages.php`; you normally don't touch it:

- `fenster_get_generated_page()` builds a synthetic archive page for
  `case-studies` and a synthetic detail page for any `case-studies/<slug>` that
  exists in `fenster_case_studies()`.
- The sitemap loop appends `case-studies` and every detail slug automatically.
- The old scrape-era residential studies (`double-glazing-rushden`,
  `water-stratford`, `bespoke-windows-woburn-water-end-barn`, `test`,
  `template-new`) stay in `fenster_gone_slugs()` and return 410. Their written
  copy exists in `data/pages.json` but they have **no photos**, so they cannot
  be published in this image-led format without real photography. The Water
  Stratford cottage (300-year-old heritage flush sash near Buckingham) and the
  Rushden bungalow (Liniar casements, leaded diamond glass, white uPVC bay) are
  the strongest of them if photos ever turn up.
- `/commercial-projects/` reads its cards from the raw `pages.json` index, so
  repurposing `/case-studies/` for the residential system does not affect it.
  Keep that decoupling intact.

---

## 10. CTAs to the case studies

The page is linked from:
- the site **footer** (`template-parts/layout/site-footer.php`, company column),
- the **homepage** proof-wall link (`template-parts/sections/home-experience.php`).

If you want more entry points, add them tastefully (avoid filler link bands per
`STYLE.md`).

---

## 11. Quick checklist for a new study

1. Optimise photos into `assets/images/case-studies/` (long edge 1600, q82, no crop).
2. Add the data entry (slug, title, location, type, date, summary, lead,
   products, colour deep link, specs, overview, installed, installers, review,
   images with captions, seo).
3. Confirm product routes and colour slugs exist; confirm fitter photos/anchors.
4. No em dashes; singular vs plural matches reality; specs match the product page.
5. `npm.cmd run build` (if SCSS/JS changed), PHP-lint, run the data harness.
6. Commit, push, deploy to test, flush cache, verify at 1440 and 390.
7. Get owner approval, then promote to live.
