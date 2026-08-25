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
- **A COUNTY NAME IN `location` USED TO READ AS A TOWN MATCH.** The town test
  was a bare substring, so "Leighton Buzzard, Bedfordshire" matched the town
  `bedford` and every Bedford route printed "Jobs we have finished in Bedford"
  over a Leighton Buzzard job and the Green Man at Eversholt. That is a false
  claim of local work, not a loose match, and it was live until 2026-08-12.
  The test is word-boundary now. **Bedford consequently renders no strip**,
  because no residential study is in the town.
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

### Step 3 — Build, lint and run the data harness

**These are the only local checks. The Local site is not where a case study
gets verified** — see the rule under Step 4.


```powershell
cd app/public/wp-content/themes/fenster
npm.cmd run build            # only if you touched SCSS or JS
& '<php>' -l inc/case-studies-data.php
& '<php>' -l template-parts/sections/case-studies-residential.php
```

Then run the data harness. It is a committed script now rather than something
you paste together, it needs no WordPress and no running site, and it exits
non-zero so it can gate a deploy:

```powershell
& '<php>' scripts/check-case-studies.php
```

It checks, across every study: required fields present, the date ISO, **both
SEO fields present and the meta description within 160 characters**, every
referenced image, card image, video and poster actually on disk, every image
carrying a caption (which is its alt text), a `story` carrying its credit and
every step captioned, installers carrying a name and role, and no em or en
dash anywhere in the data.

**It was written on 2026-08-25 because three faults had been sitting in the
data unseen.** One study, the Wolverton heritage doors, carried no `seo` block
at all and had been falling back to its title and its card summary; two
commercial meta descriptions were over the 160 cap this guide has specified all
along. None of them broke a page, which is exactly why nobody saw them. If you
add a rule to this file, add it to the harness in the same pass or expect it to
drift.

**When you extend the harness, prove the new check fails before you trust it
passing.** Injecting the five faults it was written for found that its em dash
branch called `mb_substr()`, which Local's CLI PHP does not have, so it would
have thrown the first time it ever fired. A check whose failure path has never
run is not a check.

### Step 4 — Deploy to test and verify

**Verification happens on the test site, never on the Local site.** Owner
instruction, 2026-08-11. Local by Flywheel is a place to edit files, not a
place to prove a page: it has to be running and it frequently is not (the
router answers `502` while nginx, MySQL and php-cgi are all up, because those
processes belong to a different Local site), its database drifts from
production, and a page that renders there has been proven on nobody's server.
Do not stall a case study waiting for Local to come back, and do not report a
route as checked because it rendered locally. Lint and the data harness in
Step 3 need no site at all; everything past them goes to test.

Follow `LIVECHANGES.md`: commit, push to GitHub `main`, rsync the theme to the
password-protected test site, flush its cache, then verify there. **Never deploy
straight to live.** Verify at 1440x900 and 390x844: no horizontal overflow, H1
within the `3.6rem` ceiling, product/colour/quote links correct, gallery
lightbox opens, images load. Only promote to live after the owner approves.

**Rebase before you push, because `main` moves under you.** This file is a
single array that every case study shares, so a session that edits it against
a stale checkout reverts whatever landed in the meantime. Little Horwood was
written against a `case-studies-data.php` four commits behind `origin/main` and
would have removed the All Hallows study and the town-matching fixes had it
been pushed as written. `git fetch origin main` first, branch from it, and
re-apply your entry on top.

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

### `story`: when the customer documented the install themselves

Added 2026-08-25 for the Milton Keynes composite front door, which is the first
study on the site whose photographs and words are not ours. The customer posted
the whole day as a carousel with a line under each shot, and gave permission to
republish it. `story` renders that sequence as a rail of steps under the
overview.

```php
'story' => [
    'title'  => 'The customer photographed the whole day.',   // the section H2
    'intro'  => 'One or two sentences setting up whose telling this is.',
    'source' => ['label' => 'The Renovation Files', 'url' => 'https://...'],
    'steps'  => [
        ['src' => $img . 'cs-...jpg', 'quote' => 'Their words.', 'caption' => 'Alt text, ours.'],
        ['src' => $img . 'cs-...jpg', 'caption' => 'A step with no line of theirs.'],
    ],
],
```

**A step with a `quote` prints their words; a step without one prints the
`caption` as a note instead.** That difference is the point and it is visible:
the quote is italic behind an accent rule, the note is plain muted text. Never
put our words in a `quote`, and never invent a line for a photograph they did
not caption. `caption` is always ours and is always the image `alt`.

**Their words are tidied only for emoji and the site's no-em-dash rule.** On the
Milton Keynes study `@fensterglazing` also reads as "Fenster", because this is
Fenster's own site. Everything else in a quote is theirs, and rewording it to
sound more like the rest of the page would make it a testimonial we wrote.

**COUNT THE CAPTION BLOCKS AGAINST THE SLIDES BEFORE YOU MAP ANYTHING.** An
Instagram caption is one block of text under the whole carousel, and the
convention is one paragraph per slide, in order. The Milton Keynes post had
eleven paragraphs for eleven photographs and the first pass read the last one
as a sign-off for the whole post rather than as photograph eleven's line. That
single misread shifted steps nine, ten and eleven each one card along, and
lifted the customer's closing words out of the rail into a `review` panel
entirely. The owner caught it by comparing the last card against the post:
"photo 11 has a big bio, but on the site it just has loving the look".

**So do not lift a sign-off out of the sequence into `review`.** If the
customer wrote it under a photograph, it belongs under that photograph. The
last card carrying a longer quote than the others is correct, not a layout
fault: it is the payoff, and it is what the post looks like. This study
therefore has **no `review` field at all** and does not need one, because its
review is step eleven. Only add `review` alongside a `story` if the words come
from somewhere the story does not, such as a Google review, and then check
where it prints relative to the rail.

**Give the study one image and let the rail carry the rest.** The story already
shows every photograph in the order it was told, so `images` holds the hero
alone and `gallery_images` comes out empty, which means the masonry does not
render. A gallery repeating the same shots under the rail is the same job done
twice and worse the second time.

**Two rules the rail inherits from the bi-fold rail, both enforced in
`main.scss` at the point they matter: no scroll snap, and no
`scroll-behavior: smooth`.** A card this wide swallows a small wheel nudge
inside its own snap zone, so snapping springs every small push back to where it
started; and Chrome applies `scroll-behavior: smooth` to user scrolling as well
as to `scrollTo`, so every wheel notch animates towards a target instead of
tracking the input, which reads as lag. The nav buttons pass
`behavior: 'smooth'` to `scrollTo` themselves. Controls ship `hidden` and the
controller reveals them, so with no JavaScript the rail is still a native
scroller with every step in it.

The counter reports the step at the rail's left edge, so at the far right it
reads `09 / 11` rather than `11 / 11` with three cards on screen. That is the
same behaviour as the bi-fold rail and is not a bug.

**Credit and permission are not optional.** `source` prints "Photographs and
words by X, shared with their permission." and links back. Do not add a `story`
from someone else's post without the owner confirming that permission exists.

### Fields added since this guide was written

- **`team_label`** (optional, string). The heading over the named people in the
  aside. Defaults to `Installers`, which is right for residential studies and
  wrong for a commercial one whose named people are a surveyor and a director.
  Bletchley sets `Surveyed and managed by`. Added 2026-08-10.
- **`date_confirmed`** (optional, `false`). Use when a completion date is
  approximate rather than guessing one.
- **`story`** (optional, array). The customer's own sequence as a rail of steps.
  Full rules in the section above; a study with one normally has no `review`
  and leaves `images` holding the hero alone. Added 2026-08-25.
- **`gallery_shape`** (optional, `'tall'`). Renders that study's gallery cells
  at 3:4 instead of the default square. Added 2026-08-18 for Drayton Parslow.
  **Only set it when every image in the gallery is portrait.** Across the 93
  images in the library a 3:4 cell keeps 96% of a portrait's height against 72%
  for a square, but leaves a landscape showing 53% of its width against 71%, so
  one landscape in a tall gallery is worse than the square was. See the next
  section for why this is not a reversal of the alignment rule.

### Gallery images are squared, and you do not crop the sources

Every gallery image renders `aspect-ratio: 1 / 1` with `object-fit: cover`, on
`.fg-cs-shot img`. Owner rule, 2026-08-10: galleries line up, commercial and
residential alike. **Do not pre-crop source files to square** — the crop happens
at render time, so the originals stay whole and a future change of shape costs
one line. Publish at the photograph's natural aspect.

**The rule is one shape per gallery, not square everywhere**, which is why
`gallery_shape => 'tall'` exists and does not break it. An all-portrait gallery
on a 3:4 cell still lines up perfectly; it simply stops paying a crop that only
buys fairness when a landscape is in the row with it.

**Know what `object-fit: cover` actually crops before you argue with a crop.**
The visible window is exactly as wide as the source file, so a 739px wide
photograph gets a 739px tall window in a square cell no matter how tall the file
is. Trimming the source's height does not zoom out, it only slides the window;
the only levers are a wider photograph or a taller cell. This is what made the
Drayton Parslow front door read as a close-up after the owner reshot it wide.

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
   That is the whole local pass. Do not try to verify on the Local site.
6. `git fetch origin main` and rebase onto it, then commit, push, deploy to
   test, flush cache, verify at 1440 and 390 **on test**.
7. Get owner approval, then promote to live.
