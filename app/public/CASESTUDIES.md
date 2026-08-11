# Fenster Case Studies — How To Add And Maintain Them

Last updated: 2026-08-11

This is the complete guide to the residential case studies system at
`/case-studies/`. It is written so a future agent (or developer) can add a new
case study end to end in one pass, with no back and forth. Read it fully before
touching case studies.

**Commercial studies now use the SAME system.** This was true when the line
below was written and is no longer: `/commercial-projects/` still has legacy
entries driven by `data/pages.json`, but a study added today goes in
`inc/case-studies-data.php` with `'type' => 'Commercial'` regardless of which
archive it belongs to. `fenster_case_study_base()` reads that field and routes
it to `/commercial-projects/<slug>/`; `case-studies-residential.php` renders
both archives from an `is_commercial` flag. Heal's, Tottenham Court Road
(2026-08-11) is the worked example to copy — a main-contractor job, which is
how most commercial work reaches us, so the client field names the end client
and the overview says we were appointed through the contractor.

**Commercial and residential studies must NOT mix on product pages.**
`fenster_case_studies_for_product()` takes a `$type` argument defaulting to
`residential`; the commercial template passes `commercial`. Before this filter
existed, Heal's appeared on residential product pages, which is what surfaced
it. Two consequences to know before you "fix" anything:

- `/aluminium-windows/` and `/heritage-windows/` have their case-study strip
  **deliberately gated off**, because with no residential study of their own the
  helper falls back to whatever else matches — secondary glazing and uPVC
  casements — which is worse than showing nothing. Add a residential study for
  either route and remove it from the gate; do not remove the gate first.
- `fenster_case_studies_for_product_group()` is filtered to residential too, for
  the product hubs.
- `fenster_case_studies_for_town()` is filtered to residential as of
  2026-08-12. It was missed in the original pass and was live: the commercial
  Bletchley rail depot was leading the local-proof strip on every MK suburb
  town route, because that helper matches on `location` and a study carrying
  "Milton Keynes" counts as area proof for all twelve suburbs. **A town whose
  only local match was commercial now renders no strip**, which is deliberate.
- **The location field decides town reach, so check it when you add a study.**
  An exact town-name match puts a study on that town's product matrix pages;
  "Milton Keynes" anywhere in the field puts it on twelve suburb routes at
  once. All three helpers are residential-only now, so a commercial study
  reaches neither, but the same field is what a future commercial town page
  would read.

Everything below is about the curated case studies system, residential unless
it says otherwise.

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

Two traps when verifying by screenshot rather than by eye:

- **Test is Bedrock, so theme assets are at `/app/themes/fenster/...`.** Hand
  building a `/wp-content/themes/fenster/...` URL to check a photo returns a
  404 page and looks like a broken deploy. Pull the URLs out of the rendered
  HTML instead of composing them.
- **`Page.captureScreenshot` with `captureBeyondViewport` does not trigger
  `loading="lazy"`.** A full-page shot of a case study shows the first two
  gallery images and then bare captions, which looks exactly like a broken
  masonry and is not. Set every `img.loading = 'eager'`, scroll to the bottom
  and back, and await `decode()` before capturing. See the
  `local-browser-qa-workaround` memory for the CDP harness.

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
    'priced_by' => 'consultation',                      // omit for the quote tool (the default). See below.
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

`priced_by` controls the "how they got their price" line under the overview.
**The instant quote tool is the default**, so only set it when the job was
priced another way: `'consultation'` prints the home-consultation line instead.
Wolverton heritage doors is the one study that sets it, after the page claimed
the quote tool for a job that was priced at a consultation. This is a claim
about a real customer, so check which route the job actually took before
leaving a new study on the default. A route with no branch in
`case-studies-residential.php` needs one adding rather than being left to fall
through. Commercial studies never print the line.

---

### Fields added since this guide was written

- **`team_label`** (optional, string). The heading over the named people in the
  aside. Defaults to `Installers`, which is right for residential studies and
  wrong for a commercial one whose named people are a surveyor and a director.
  Bletchley sets `Surveyed and managed by`. Added 2026-08-10.
- **`date_confirmed`** (optional, `false`). Use when a completion date is
  approximate rather than guessing one.

### Gallery images are squared, and you do not crop the sources

Every gallery image renders `aspect-ratio: 1 / 1` with `object-fit: cover`, on
`.fg-cs-shot img`. Owner rule, 2026-08-10: galleries line up, commercial and
residential alike. **Do not pre-crop source files to square** — the crop happens
at render time, so the originals stay whole and a future change of shape costs
one line. Publish at the photograph's natural aspect.

### Commercial studies: name the building, not the firm that hired you

Full rule in `AI.md`. In short: the property is the subject and keeps its name;
the organisation that engaged us does not appear, in copy, captions, filenames,
`pages.json` or source comments. **Where the client and the building are the same
organisation** — a council on its own building, a university on its own campus —
**name it**, because the poaching risk the rule protects against is a contractor
or developer who buys glazing repeatedly, not a body procuring its own estate.

### Never publish a contract value

The internal commercial deck carries them. The website does not.

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
- **A product page figure only transfers if the job actually has that glass.**
  The Leagrave window is a uPVC casement, but it carries a Notan blind in an
  NTB 24/28 cavity, so the `0.95 W/m²K` / A+ the other casement studies quote
  for a 36mm triple unit does not describe it and is not on the page. Same for
  the frame system: Fenster's uPVC casement is Liniar EnergyPlus, but nothing in
  the supplied photography proved that one was, so it is not named. Leaving a
  spec slot for something you can see beats filling it with something you
  assumed. See the Notan Integral Blind Rule in `AI.md` before writing any
  integral blind copy, and note it forbids printing a slat width.
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
helper: `$fitter('Full Name', 'Role', 'photo-file.png')` builds `name`, `role`,
`image` (from `assets/images/imported/`) and `url` (`/meet-the-team/#full-name`).
The **role must match the person's job title on Meet the Team** (e.g. Andy
McCullagh is "Service Engineer", not "Fitter"). Omit the photo argument for
someone with no team profile yet (e.g. Aaron) — they render as a name-only chip
with an initial, no link.

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
- Leagrave integral blinds — Shane and Zac (Rugman)

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
- **The archive card is `16 / 10` with `object-fit: cover`.** When every photo
  on a job is portrait, `images[0]` gets centre-cropped into a horizontal band
  and the card shows no window at all. Add a `card_image` cut from the
  full-resolution original rather than from the 1600px version, and choose the
  band deliberately: on Leagrave it keeps the head of the blind, both magnets
  and the handle. Bolbeck Park and Wolverton sash do the same at `1600x1000`.
- Every hero and gallery image is a lightbox link (`data-fg-gallery-lightbox`).
  Clicking opens the existing in-page lightbox (prev/next, Escape, click
  backdrop) — no new tab. This is wired globally in `src/js/main.js`; you get
  it for free by keeping the `fg-cs-zoom` anchor wrapper in the template.

---

## 8b. Video case studies

A study can lead with a video instead of a hero image. Add a `video` field:

```php
'video' => [
    'src'         => FENSTER_THEME_URI . '/assets/videos/case-studies/cs-....mp4',
    'poster'      => $img . 'cs-...-poster.jpg',   // shown before the video loads
    'orientation' => 'landscape',                  // or 'portrait'
    'label'       => 'Video of the installed ...',  // accessible label
],
```

Treatment depends on `orientation`:
- **`landscape`** → a full-width 16:9 video sits under the title block, in place
  of the hero image (`fg-cs-hero--wide-video`).
- **`portrait`** → the video is shown as a square in the hero image slot
  (`fg-cs-hero__media--video`). **Do not crop it to a square when encoding.**
  `.fg-cs-hero__media--video video` sets `aspect-ratio: 1 / 1` with
  `object-fit: cover`, so the browser centre-crops it for you, and every portrait
  study already on the site ships full portrait: Bolbeck Park and Wolverton are
  `720x1280`, Leagrave is `576x1024`. Encoding a square as well would crop it
  twice. Encode at native portrait size and let the CSS do it. The poster should
  be portrait too, so poster and first frame line up.

When a `video` is present the hero has no still image, so **all** `images` go to
the gallery. Videos autoplay muted, loop and are `playsinline` with the poster
shown first.

Encoding (there is no system ffmpeg; use the bundled one via
`pip install imageio-ffmpeg`, then `python -c "import imageio_ffmpeg as f; print(f.get_ffmpeg_exe())"`):

```bash
# landscape -> 1280x720 web mp4 + poster
ffmpeg -y -i in.mp4 -vf scale=1280:720 -c:v libx264 -pix_fmt yuv420p -crf 26 -preset medium -an -movflags +faststart cs-x.mp4
ffmpeg -y -ss 14 -i in.mp4 -vf scale=1600:900 -frames:v 1 -q:v 3 cs-x-poster.jpg
# portrait -> native size, no crop, no scale. The CSS squares it.
ffmpeg -y -i in.mp4 -c:v libx264 -pix_fmt yuv420p -crf 26 -preset medium -an -movflags +faststart cs-y.mp4
ffmpeg -y -ss 4.5 -i in.mp4 -frames:v 1 -q:v 3 cs-y-poster.jpg
```

Videos live in `assets/videos/case-studies/`; posters and any stills in
`assets/images/case-studies/`. Keep videos short (~20s loop) and ideally under
~7MB. `-an` matters: phone clips carry an audio track, and the player is muted
and looping, so the audio is dead weight. **Check for a rotation matrix before
you plan a crop.** A phone clip is often stored landscape with
`displaymatrix: rotation of -90.00 degrees`; `ffmpeg -i` reports the stored size,
not the displayed one, and ffmpeg auto-rotates before applying `-vf`. The
Leagrave source reads as `1024x576` and displays as `576x1024`.

Note: `date` is required for ordering — the archive and related sections sort by
it automatically (newest first, `uasort` in `fenster_case_studies()`), so the
order you write entries in the file does not matter.

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
