# Fenster Glazing Handover

## Current state, 2026-08-31 — read this before touching either environment

**Read in this order if you are picking this up cold:** this section, then the
Current Truth section of `LIVECHANGES.md` (the only authority on what is live
and the deploy runbook), then the START HERE block in `PROGRESS.md`. `AI.md`
carries the standing rules, including the Configuration Page Rule that governs
three of the routes touched most recently.


**LIVE IS `47838b36`**, tag `live-seo-2026-08-31b`, verified by
checksum rather than copied from a document. **It is NOT an ancestor of `main`.**

| | SHA | theme tree |
| --- | --- | --- |
| live | `47838b36` (tag `live-seo-2026-08-31b`) | `85f5af69` |
| test | `9dac1c0b` | `cd192d3a` |
| `main` | `9dac1c0b` (docs commit above it) | `cd192d3a` |

Test and `main` are theme-identical. Live is a **separate line** and 246 theme
files differ from `main` — one fewer than before this release, because it
spliced `inc/commercial-product-data.php` across, so the two lines now agree
on that one file.

### Why live is not on `main`, and what that means for you

On 2026-08-30 the owner asked for the obscured glass page live. `main` at that
point was 181 commits ahead of live and only about 73 of them were that work;
the rest was the composite doors overhaul and the showroom/experimental strand,
none of it approved. **The wanted work could not be lifted out as a commit
range** — replaying it onto live applied 2 of 73, reverting the rest off test
left 145 conflicts — so it was spliced hunk by hunk onto a branch cut from the
old live, and every release since has been cut from the previous release the
same way.

So:

- **Checksumming live matches no commit on `main`. That is the arrangement, not
  drift.** It matches the newest release tag.
- **NEVER cut a release from a superseded tag.** There are five, and only the
  newest is live. Building on any older one silently reverts everything that
  shipped after it — the "release branch became a loaded gun" failure
  `LIVECHANGES.md` records from 2026-08-05.

  ```
  live-obscured-glass-2026-08-30   c11cece9   superseded
  live-obscured-glass-2026-08-30b  c07a7c3c   superseded
  live-obscured-glass-2026-08-30c  0718b840   superseded
  live-blinds-2026-08-30d          2d8bfab7   superseded
  live-configuration-2026-08-30e   10a596a7   superseded
  live-commercial-2026-08-30f      30e3a543   superseded
  live-commercial-2026-08-30g      873234ed   superseded
  live-seo-2026-08-31              12c7732e   superseded
  live-seo-2026-08-31b             47838b36   LIVE
  ```

- **Either build on `47838b36`, or ship a range from `main`** once the rest of
  `main` is approved and the line can be retired.

### How a release is cut on this line

Branch from the current live tag, apply the wanted diff, rebuild the bundles
from that tree, and prove the isolation before shipping. The proof that has
worked every time is a **rule-level diff of the compiled CSS against live's
own** — assert that every rule added or removed belongs to the strand you meant
to ship — plus a byte-comparison of the JS. Four of the five releases moved the
JS not at all, and that was checkable in one line.

The first release needed hunk-by-hunk classification because the work was
interleaved. Every one since has applied cleanly with `git apply --3way`,
because everything on `main` since has been a single strand. Full mechanics,
guard hashes and backup procedure: `LIVECHANGES.md`.

### What shipped on 2026-08-30

Five releases in one day, all owner-driven, all on `/obscured-glass/`,
`/integral-blinds/` and the three configuration routes:

1. **`c11cece9`** — the obscured glass page: SEO rebuild, privacy-scale section,
   onward routes, FAQ schema, and a 2.29MB PNG taken off fourteen routes.
2. **`c07a7c3c`** — the visualiser's reading order and a mobile pass.
3. **`0718b840`** — satin stopped showing the sharp scene through the blurred
   copy, and the rail layout settled.
4. **`2d8bfab7`** — the integral blind's bunched stack halved.
5. **`10a596a7`** — `/french-casement-windows/`, `/french-doors/` and
   `/bow-bay-windows/` became CONFIGURATION pages on a shared template.

### Still on `main` and NOT live, none of it approved

The composite doors V2 overhaul and its 148 images, `/why-distinction/`,
decorative glass, the quiz, the finishes pass, the site-footer
`/why-distinction/` link, and the whole showroom and experimental strand.
`main` is a content superset of live.

### What is open

- **The related band on `/bow-bay-windows/` repeats its seven product
  thumbnails**, because the configuration band and the related band both resolve
  images from `fenster_link_card_image()`. Raised with the owner and left alone:
  it is a navigation change, not a bug.
- **Five spec figures are still blocked on the owner** and no copy may quote a
  light-transmission number until they land.
- The obscured glass renderer's lens outlines are still softer than the
  Pilkington reference. Pre-existing `hatchlens` character, not a regression.

### What needs the owner

- Whether to retire the isolated line by approving the rest of `main`, or keep
  cutting releases from it. Every release on this line is another splice.
- The composite doors V2 overhaul has been on test since 2026-08-27 and has
  never been approved for live.

## Superseded: state before the release, 2026-08-30 (obscured glass: Reeded uninverted, Cassini re-plated — ON TEST, NOT LIVE)

**Live is still `b2420743` and has never carried any of this. That SHA was
re-established by CHECKSUM this session, not copied from a document** — four
theme files hashed on the live server (`assets/js/main.js`, `assets/css/main.css`,
`inc/site-data.php`, `template-parts/sections/generated-page.php`) match it 4/4.
Read that as *consistent*, not *unique*: those four files are unchanged across a
run of neighbouring commits, so the hash matches all of them. It rules out live
having drifted; it does not pin the SHA on its own.

The test SITE runs the theme from `e0bd7c56`. `main` runs a docs commit or two
further on, and **the theme tree is `3690e8cd` at every one of them** — check
that hash rather than a SHA, because it does not go stale as documentation
lands. Test is **171 commits ahead of live and none of it is approved** — seven
of those are this session (`88c1180f..fac10b8f`, docs after that), and the rest
is three earlier sessions of obscured-glass
and composite-doors work. **The range now contains four sessions' unapproved
work; do not ship it wholesale.** This session: fourteen files, **ten added,
four modified, zero deleted**. Working tree clean.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, which
carries every finding below in full; then the comment above `cassini:` in
`src/js/main.js`, and the `rib` family header above `reeded:`; then the
docstrings of `scripts/build-cassini-clock.py` and
`scripts/build-cassini-windowcad.py`, which record why the plate was rebuilt
twice and what each source is actually good for.

### What changed

**Reeded stopped inverting, because the reference does not.** Owner, on the live
page: *"the physics are weird, like it inverts everything too much."* `flip:
true` ran the sample backwards inside every flute. Removing it is a one-word
change; proving the direction was the work, and the test is cheap and
re-runnable — see below. The near scene's `close.spread` went 1.5 -> 2.5 to put
back the obscuration the mirror had been doing; the house stays at 3.0, so the
far scene still scrambles harder than the near one.

**Cassini's plate was replaced twice in one session, and the second time was the
owner redirecting the SOURCE.** Every earlier plate came from a photograph of a
sample held to the light, and gave a mat of rounded pebbles packed edge to edge.
Real Cassini is pointed, overlapping leaves over a ruled hatch in angular
sectors. The first rebuild took that from a screen recording of the WindowCAD
quote tool; the owner then said *"texture and opacity are good now. you need to
exactly copy the shapes and layout from the clock image though"*, and they were
right — at matched leaf scale WindowCAD draws rounded blobs while the Pallot
clock photograph shows pointed teardrops with a strong dome shade, in many
sizes. **WindowCAD renders an approximation; the clock is a photograph of the
real sheet.** The shipped plate is `-clock`; the `-wcad` pair is left in place
rather than deleted, so a revert is a one-line change in `inc/site-data.php`.

**Two renderer faults were fixed on the way.** The page was drawing broad
black-and-white diagonal bars over everything — that was `fluteShade` at 1.30,
now 0.25. And `faceFlat` had effectively been equal to `groundFlat` across two
plates, which is most of why this glass has read as amorphous blobs through
several rebuilds; 0.96 against 0.62 now, with `heightBlur` 9 -> 4 so a 58px
teardrop keeps its point.

### The six things worth carrying forward

- **`faceFlat` AND `groundFlat` MUST NOT BE EQUAL.** A lens is visible only
  because its FACE is flatter than the ground around it. Set the two within a
  few percent of each other — 0.55/0.58, then 0.80/0.84 — and everything
  flattens equally and the shapes stop reading at all. This sat in the material
  in plain sight for weeks while rebuild after rebuild went looking at the
  assets.

- **NEVER BAND-PASS SOMETHING WHOSE EDGES ARE THE POINT.** Removing the clock
  from behind the glass was first tried as `gaussian(2) - gaussian(30)`.
  Subtracting a wide blur haloes every hard step, so the teardrops came out as
  soft grey blobs with their outlines gone — a plate measurably worse than the
  photograph it came from. Mean gradient magnitude: photograph 32.6, band-pass
  11, **local contrast normalisation 18.9**. Dividing by the local standard
  deviation leaves a step a step.

- **BIN-QUANTISED MEASUREMENTS INVENT GRADIENTS.** The WindowCAD frame's hatch
  pitch reads 6.5px one side and 5.0px the other, which looks exactly like the
  pane receding, and a whole horizontal rectification was nearly built for it.
  Measured with 512px windows and a **sub-bin parabolic peak fit** rather than
  the raw FFT bin, the scale is constant to within 4%; the apparent gradient was
  the hatch ANGLE changing between sectors.

- **A MIRROR INSIDE A FLUTE HAS A SIGNATURE: BUTTERFLY CHEVRONS.** Reflecting
  about each flute centre turns a single diagonal into symmetric V and X shapes
  straddling every seam — Legend's polo shirt carried one the width of the pane.
  The reference has none; its clock hands break into a **sawtooth whose teeth
  all lean the same way**. Learn it on sight and this is a five-second diagnosis
  rather than a session.

- **THE TILE IS DATA, NOT A PICTURE, AND IT SHIPS LOSSLESS.** The renderer
  derives its height field, oval segmentation and hatch steering from those
  pixels, so a lossy encode MOVES the render: q95 against lossless shifts 20% of
  output pixels by more than two levels, and **q90 lands closer to lossless than
  q95 does**. Non-monotonic, so it cannot be tuned by picking a quality number.
  The display copy is the opposite case — only ever looked at — and is 700px at
  q74.

- **KNOCKOUT BEATS READING THE CODE ON A RENDERER THIS ENTANGLED.** The zebra
  bars were found in two renders by zeroing one term at a time (`hatch: 0`
  changed almost nothing, `fluteShade: 0` removed them completely) after reading
  the shading path had not found it.

### What is open

- **THE THING THAT WAS ASKED FOR IS NOT DONE: the reference's lenses have HARD
  OUTLINES and `hatchlens` cannot draw one.** It expresses a lens only as a
  difference in how the scene is displaced and flattened, never as a boundary.
  Everything available was tried — the blur terms down, `washMix` up to 0.95
  (almost no visible effect at all), the face/ground split above, and
  `rim2`/`rimDark` up, which draws a literal dark line round every region and is
  exactly the topographic-map failure this repo already records for that
  gradient. **This needs a new mechanism, not a parameter, and that is a
  decision for the owner rather than a tweak.** The current build is closer than
  the WindowCAD one on layout and softer on edges; **`1a80e85e` is the WindowCAD
  build if the owner prefers it** — but reverting there also takes back
  `heightBlur` 4 -> 9 and the `faceFlat`/`groundFlat` split, which are the
  RENDERER fix rather than the plate. Swapping only the one asset line in
  `inc/site-data.php` keeps those; that combination has not been rendered.
- **Cassini's tile REPEATS where the old plate did not**, and this is a
  deliberate trade rather than an oversight. 800x533 is the largest copy of that
  clock photograph in existence (every smaller WordPress variant 404s), so after
  the banner crop and the seam cut there are about 5.9 x 4.8 leaves of real
  layout, and the pane holds more than that.
- **Reeded's caustics.** The reference carries pale washed bands either side of
  every flute seam; ours are hard edges. That is the next real difference
  between us and the photograph, it is a separate change, and it should not be
  bundled into a tuning pass.
- **The `-wcad` assets are superseded but not deleted.** The deletion list is
  EMPTY on purpose, because they are the revert target.
- Carried unchanged from 2026-08-29 and still true: **the canvas is sized in CSS
  pixels** with no `devicePixelRatio`; `.fg-obscure-stage__scene--glass` is dead
  CSS; `layTexture`'s mirror-brick was measured seam-neutral to remove and the
  removal was not taken; the default scene is `house` and the owner never
  answered whether to flip it; **nobody has used this page on a real touch
  device.**

### What needs the owner

1. **Cassini: clock plate or WindowCAD plate.** Both are on disk and the switch
   is one line in `inc/site-data.php` — `-clock` against `-wcad`, with image and
   tile on the same line. A `git revert` to `1a80e85e` is the other route and
   takes the renderer numbers with it; see above.
2. **Whether to commission the outline mechanism at all**, knowing it is a new
   piece of renderer rather than a tuning pass.
3. **Approval to ship anything.** Nothing in the 171-commit range has been
   approved for live, and the range spans four sessions.

## Current state, 2026-08-29 (obscured glass tuned by the owner's eye — ON TEST, NOT LIVE)

**Superseded by the block above, which covers the same page. Its findings and
its architecture stand; its SHA and its commit range do not.**

**Live is still `b2420743` and has never carried any of this.** The test SITE
runs the theme from `819b374d`, **162 commits ahead of live and none of it
approved**; `main` is a commit or two further on docs only, whose theme trees
are byte-identical, so either is the same answer to "what is on test". Nineteen of
those are this session (`8cfb7207..819b374d`); the rest is the obscured-glass
rebuild from the session before and the composite-doors overhaul before that.
**The range therefore contains three sessions' unapproved work — do not ship it
wholesale.** This session: fourteen files, **eight added, six modified, zero
deleted**.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, which
carries every finding below in full; then `GLASS_MATERIALS` in `src/js/main.js`
(3623-4028), whose per-glass comments hold the reasoning; then
`scripts/build-unmirrored-plates.py`, whose header explains the plate fault.

### How this session ran, and why that matters to whoever picks it up

Every change answered a specific defect the OWNER saw on the test site, in
their own words, one at a time — Stippolyte too coarse, Contora "a bit of a mister
effect", Cotswold "shows a bit like reeded", Minster "too clean", "a shitty
mirror repeat", the cat "looks like a gremlin lol", Satin "kinda dark now",
Reeded's "obvious white angled lines that look too computerised". **There is no
metric in this session that was chased for its own sake.** The measurements
below exist to explain faults the owner had already found, or to prove a fix
reached the served page. That is the working mode this page responds to: the
previous session's most careful optical work was thrown out wholesale, and this
session's small answers to plain complaints have all stood.

### What changed

**Four glasses were moved or re-tuned, and two of the four needed a different
FAMILY rather than different numbers.** Contora (`dapple` -> `frost`) and
Cotswold (`rib` -> `frost`) were showing a fully legible scene with visible
distortion over it, because **only `kind: 'frost'` samples a pre-blurred copy of
the scene** — every other kind displaces the sharp one. Stippolyte went back to
laying at its data pin instead of `cover`. Minster gained granularity with its
blobs defined by SHADOW rather than highlight.

**Seven plates were re-cut, because the mirror was in the photograph.** Not in
the renderer, not in the tiler. See below; this is the single most useful thing
in this session.

**The stage is 4:3 again and driven from the column width**, so the Legend
photograph fits it, and the pane, its caption and the card edge line up. Both
scenes lay at `cover` — `contain` was letterboxing on mobile.

**Two segmented switches replaced one relabelling button.** Scene is a
house/cat icon pair; privacy is a 5-4-3-2-1-All filter with live counts that
hides patterns by class. Both are `aria-pressed` button groups with
screen-reader labels.

**Satin varies by scene and Reeded now can too**, through a new `close: {}`
override block on a material.

### The six things worth carrying forward

- **THE MIRROR WAS IN THE PHOTOGRAPH, AND THE FIRST SWEEP LOOKED IN THE WRONG
  PLACE.** Seven plates were extended by reflecting about a vertical axis at
  **68%** across. They lay at `cover` — once, no tiling, no mirroring in the
  path — and the reflection still lands on the pane, because the axis is inside
  the visible window at every width. The sweep that cleared them tested each
  plate about its **centre**; Sycamore scored -0.011 and was called clean while
  the fault was plain in the owner's screenshot. **Search for the axis; do not
  assume the middle.** And the corrected files are named `-unmirrored` because
  texture URLs carry no version string — replacing one in place leaves proxies
  serving the old bytes.

- **CHECK THE MATERIAL FAMILY BEFORE SPENDING A SWEEP ON THE PARAMETERS.**
  `const src = mat.kind === 'frost' ? soft : scene;` decides whether a glass can
  obscure at all. A privacy 4 or 5 built outside `frost` reads as a distorted
  but readable view no matter how the numbers are set — which is exactly what
  "a bit of a mister effect" describes.

- **`emboss` CAN ONLY PUSH TOWARD WHITE; `shade` IS THE OTHER HALF.** The
  positive lobe adds a fraction of the remaining headroom, so sharpening a
  feature with emboss necessarily bleaches it. When the owner says something is
  "too defined and too white", the answer is emboss down and `shade` up.

- **COMPRESSION STRAIGHTENS.** Reeded's "computerised" white lines were the
  SCENE: `spread` squeezes horizontally inside each flute, a soft diagonal cloud
  edge squeezed 4.2x becomes a hard straight streak, and the flute pitch repeats
  it exactly. Lower spread, break the pitch with `wander`/`jitter`, and take the
  rib crown down so what is left does not read white.

- **OBSCURATION IS A FUNCTION OF SUBJECT DISTANCE, so a material can vary by
  scene.** `close: {}` is merged over the base when the near scene is active.
  Reeded takes half its spread close up; at the house setting the near subject's
  eyes were gathered into three flutes at once.

- **RENDER SMALL ARTWORK AT A SIZE YOU CAN SEE.** Four passes were spent judging
  a 22px icon inside full-page screenshots. A 190px standalone preview found the
  fault immediately.

### What is open

- **The canvas is sized in CSS pixels.** `getBoundingClientRect()` with no
  `devicePixelRatio` (`src/js/main.js:4189-4198`, capped 900x675), while three
  other components in the same file do apply one. This is the likeliest reason
  the pane reads softer on the owner's retina screen than in a headless capture,
  and it is a two-line change plus a re-verify of every glass.
- **`layTexture`'s mirror-brick** (`src/js/main.js:4117-4118`) was measured
  seam-neutral to remove. Removal was offered and not taken; it is unrelated to
  the plate fault above, which is why removing it would not have helped.
- **Dead CSS:** `.fg-obscure-stage__scene--glass` (`src/scss/main.scss:10605`)
  targets an element that is not in the DOM. Three passes were spent tuning it.
  Left in place and flagged rather than removed mid-session.
- **The default scene is `house`** (index 0 of `['house','cat']`, unchanged and
  not a regression). The owner noticed it and was asked whether to flip the
  default to the close scene; **they did not answer, so it stands.**
- **The owner has not yet judged Reeded's `close` override.** A `spread: 1.2`
  variant was rendered alongside the shipped `1.5` if they want it sharper.
- **Nobody has used this page on a real touch device.** Same standing limit as
  every other headless-verified thing here.

## Current state, 2026-08-28 (obscured glass rebuilt — ON TEST, NOT LIVE)

**Superseded by the block above, which covers the same page. Its findings and
its architecture stand; its SHA and its commit range do not.** Live is still
`b2420743` and has never carried any of this. The test SITE ran the theme from
`db684e2a` when this was written; `main` is a little ahead of that on docs-only
commits, whose theme trees are byte-identical, so either is the same answer to
"what is on test". **141 commits ahead of live**, none of it approved. Forty-five of those are
this session (`d92b0c39..db684e2a`); the rest is the composite-doors overhaul
from the session before. **The range therefore contains two people's unapproved
work — do not ship it wholesale.** 244 files added, 10 modified, zero deleted.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, which
carries every finding below in full; then the `cassini` block in
`src/js/main.js`, whose comment holds the model and the measurements behind it.

### What changed

**Cassini's optics were rebuilt from the owner's own glass sample.** It is no
longer a texture composited over a photograph: the pane is segmented into the
plate's real lens outlines, each lens refracts what is behind it, the ground
between them is fluted at a measured pitch and bearing, and overlaps carry both
impressions crossed. The plate tiles seamlessly by a measured minimum-error seam
cut. **The other twenty glasses are byte-identical throughout** — verified by
pixel diff on every commit that touched shared code.

**The selector fits one screen.** It was 979px tall at 1280x720, so the heading
and the how-to sat below the fold; it is 691px now. The twenty-one patterns were
split ten and eleven either side of the stage and are one two-column panel.

**The view behind the glass parallaxes on scroll**, and the glass does not move
with it — see the render split below.

### The five things worth carrying forward

- **Photograph a glass sample against something DARK and PLAIN.** The owner's
  dark-cladding shots are a dark-field view: smooth lenses pass the dark
  backdrop and read dark, the hatched ground scatters and reads light, so the
  pattern separates itself. They corrected two numbers taken through a busy
  scene — bearings are 55/125deg not 45/145, and the hatch was **1.7x too
  coarse**, the opposite of the direction several rounds had been pushing it.
  The reference is committed at `scripts/reference-cassini-darkfield.png`.
  **Re-measure from it rather than re-guessing.**

- **The render is split so the scene can move without the glass moving.**
  Everything expensive — blurs, flood fills, watershed, sector lattice —
  describes the SHEET and is scene-independent; only the final sampling touches
  the scene. `renderGlass` records per pixel where to sample and what to do with
  the result, and `paint(dx, dy)` does the sampling. **There is only one copy of
  the shading and the first render goes through it too, `paint(0, 0)`** — if it
  were duplicated the two would drift the first time either was edited. Verify
  any change to it the way this was: `paint(0, 0)` must reproduce the previous
  render EXACTLY, checked by per-row checksum across two builds.

- **A metric can look like a triumph while the renderer is dead.** Three
  separate harness faults all produce the same symptom — **byte-identical
  screenshots across inputs that differ**: a render exception falling back to
  the CSS layer in silence, a pinned `?ver=` serving a cached bundle, and the
  local server having died (its bundle hashed to `da39a3ee`, the SHA-1 of the
  empty string). One dead render even measured 0.997 direction entropy, a
  near-perfect score, because a blur has no orientation at all. **Assert the
  images differ before reading any number off them**; `/tmp/guard.sh`-style
  checks belong before every screenshot.

- **Five declaration-order bugs in `renderGlass`, and each cost a full sweep.**
  A `const` left below the code that uses it throws, the render falls back to
  CSS in silence, and every screenshot in that sweep is the fallback. Anything
  used by more than one stage is declared at the top of the function; `hash` is
  hoisted there permanently with a note saying why.

- **Two measurements of my own were worthless and are recorded as such.** A
  "28% lens coverage" figure was obtained by thresholding at the 72nd
  percentile, which forces 28% by construction. And the references' finest
  contrast band is partly camera noise and JPEG sharpening — a candidate that
  matched it exactly was visibly speckled. **Match the structural bands and
  confirm by eye.**

### What needs the owner

- **Nothing here is approved and nothing reached live.** Live is untouched at
  `b2420743`, so customers still see the old CSS compositing.

- **Four photographs would unlock the last real gap.** The plate is a
  photograph, not a height map, so every geometric term is inferred from an
  image whose brightness is a product of that photo's lighting. Photometric
  stereo fixes it: **sample and camera FIXED, only the torch moving** — four
  shots, torch left, right, above, below, held a foot or two back, no zoom or
  refocus between. The three torch-lit frames already supplied cannot do it:
  everything moved, the label registers only to 10-20px, and the hatch pitch is
  11px, so the reconstruction returns the torch's own falloff. **Do not retry it
  on those three.**

- **Cassini is now noticeably more see-through than the old version**, which is
  a product judgement, not a rendering one. It is sold as privacy 5. If that
  reads as too transparent it is one parameter.

- **The scroll parallax has not been exercised end to end.** The paint mechanism
  is proven by direct call — with an offset the pattern's correlation peak sits
  at (0,0), it does not move — but the harness pane reports
  `visibilityState: "hidden"`, which throttles `requestAnimationFrame`, so the
  scroll handler itself wants a real scroll on test.

- **What still separates this from a photograph needs data or a different
  renderer, not tuning.** The renderer displaces rather than refracts, so a flat
  backdrop gives no depth-dependent parallax and no true caustics; and there is
  no environment for the front surface to reflect. Every criterion that can be
  measured now sits inside or beside the reference bands, so further parameter
  work has low expected value.


## Current state, 2026-08-27 pm (composite doors overhauled — ON TEST, NOT LIVE)

**Live is still `b2420743`. Test is twenty-seven commits ahead and none of it is
approved.** Nine commits are this session, `fdee3d6b..03ca2f63`.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, then
`COMPOSITE-DOORS-OVERHAUL-BRIEF-2026-08-27.md` (the measured audit and the brief
it produced), then the two new composite rules in `AI.md`.

### What changed

`/composite-doors/` is **five chapters rather than seventeen sections**: the
door, choose one, what it is made of, how it will look, proof and price. The
hero fills the fold and carries the four facts and the Distinction credential
that used to be two strips below it. The range and the quiz share one surface.
The construction section is a **live cutaway built from the supplied design
handoff**, where opening a layer highlights that component, moves a leader dot
onto it and shows a measurement chip. Glass, colour and handles are one chapter.

`/why-distinction/` has photographs for the first time, no em dashes, both
six-item grids fixed, the 50% figure anchored against its own caveats, and a
closing chapter that sends a reader to the range and the quiz by name.

### The two things worth carrying forward

- **The flatness had a cause and it was a stylesheet rule.** Two blanket
  `.generated-page--composite-doors h2` declarations, 1,450 lines apart, each
  with `!important`. The later won at 28.8px and beat every namespaced heading
  rule under it. Fourteen identical headings on a 13,909px page was not a
  missing design decision, it was a rule forbidding one. **Check for that before
  redesigning a page that reads flat.**
- **A grid track's minimum is `auto`, and it cost two blank phone viewports.**
  Making the finishes chapter a `display: grid` let the colour wall's 27-swatch
  `auto-fit` grid set the chapter's width to its own max-content, so on a 390px
  phone that section laid out 1,180px wide entirely off-screen. **It did not
  trip the horizontal-overflow check**, because an ancestor clipped it.

### What needs the owner

- **Nothing here is approved and nothing was deployed to live.**
- **The oversized heading rules the blanket `!important` was hiding are
  site-wide.** The enquiry form's h2 is `--fg-font-size-max` exactly on every
  route that renders it, against `STYLE.md`'s own rule. Fixed on this page only;
  the site-wide pass is a separate decision.
- **Mobile is 17,818px**, down from 21,513px, and still over the 15,000px
  `SEO-PERFORMANCE-AUDIT-2026-08-17.md` asks for across eleven product pages.
  It came down by sizing things correctly and by making two swatch grids into
  rails, not by deleting content.

## Current state, 2026-08-27 (composite doors rebuilt — ON TEST, NOT LIVE)

**Live is still `b2420743`. Test is eighteen commits ahead and none of it is
approved.** Fourteen are this session's composite doors work, one is another
session's obscure glass fix, three are docs. Nothing was deployed to live.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, then the
three composite rules in `AI.md` — WindowCAD URL Parameter, Composite Door
Range, Composite Door Quiz.

### What `/composite-doors/` gained

- **The style range**: 142 doors, the ones the quoting system can actually price,
  grouped into the six collections a customer meets in the tool. Each opens
  WindowCAD on that exact door. It replaced a drifting wall of 33 photographs
  under the heading "over 300 door styles" — a number describing Distinction's
  catalogue rather than ours, over a section that offered no way to act on a door.
- **The glass section**, which was never missing: it sat in the shared product
  tail behind `! $is_composite_doors`, and composite doors is the only route with
  a `glass_styles` array, so it rendered on no route at all.
- **A five-question quiz** ending on one door with the quote tool open on it, in
  the colour chosen. Scored on traits computed from real cassette geometry.
- **`/why-distinction/`**, a new indexable route carrying the technical case at
  length so the main page does not have to.

### Five traps this paid for, all of which fail silently

- **An SVG loaded through `<img src>` is an isolated document.** It inherits
  nothing from the page, so `currentColor` inside resolves to its own black and
  setting `color` on the `<img>` does nothing. Black drawings shipped onto a
  black stage as empty boxes.
- **A hand-rolled path parser recorded only an arc's endpoint.** A semicircular
  cut-out measured as zero height, and five glazed doors were classified as
  solid — so the quiz answered "no glass at all" with a door that had windows.
  Use the browser's `getBBox()`.
- **`colour=` takes WindowCAD's palette key, not the colour collection entry
  key.** The wrong key renders white, which is indistinguishable from the
  parameter being ignored. A colour changes no network request, so the only
  check is a screenshot.
- **Theme image URLs carry no version string.** Three screenshots showed the
  previous drawings after the corrected ones were live, and the served files had
  to be hashed to prove the deploy was fine.
- **"Delete this block" implemented as "truncate from here" is only the same
  thing when the block is last.** It was last when the helper was written and had
  stopped being last two commits later, which silently destroyed the
  `/why-distinction/` styles for three commits.

### What needs the owner

- **Two asks for WindowSoftware, both proven end to end.** Make the outer frame
  follow `colour=` (or add `framecolour=`) — there is no frame parameter and the
  frame renders white against a coloured slab. And carry `tracking=` through the
  composite designer, which currently loses FG2 and ad attribution on every lead
  the quiz sends.
- **The visual overhaul is unfinished and the owner is taking it on.** Section
  padding was standardised and the "choosing" sections put on a shared surface,
  but the owner's verdict was that it changed nothing worth having.
- **Mobile page length is now 21,210px**, against the 15,000px figure
  `SEO-PERFORMANCE-AUDIT-2026-08-17.md` already flags across eleven product
  pages. The three new sections are most of the increase. Not shortened
  unilaterally.

## Current state, 2026-08-26 (docs catch-up — FIVE RELEASES THIS FILE NEVER RECORDED)

**Live is `3285863b`, level with `main`, and test is level with it. Nothing is
outstanding in either direction.** `origin/main` is `e87d9a64`, one docs-only
commit above live whose theme tree is byte-identical, which is the documented
ambiguity rather than undeployed work. Verified by diffing the theme folder
across the range, not read off a line.

**THIS BLOCK IS A CATCH-UP, NOT A RELEASE NOTE.** Between 2026-08-17 and
2026-08-25 five releases shipped and none of them reached this file, which stood
at 2026-08-16 for ten days while `LIVECHANGES.md` was corrected on the day of
every one. **`LIVECHANGES.md` is the authority and it was right throughout**;
what was lost is the architecture and trap record that belongs here. Five
retroactive "current state" blocks would be fiction, so this is one block.

**Read in this order:** the Current Truth section of `LIVECHANGES.md`, then the
rule in `AI.md` for whichever page you are touching, then `CASESTUDIES.md` if it
is a case study.

### What shipped, oldest first

- **`575eae99`, 17 Aug — the case-studies Show more button had never worked.**
  Every card was visible and the button did nothing. Both archives now open on
  six cards, read from `data-fg-case-studies-initial`.
- **`dbc9cc75`, 18 Aug — the Drayton Parslow study**, two Distinction composite
  doors, plus a `--tall` gallery modifier so an all-portrait study can opt into
  a 3:4 cell instead of the shared square.
- **`f1fbbc94`, 19 Aug — the largest release of the month, twenty-one commits.**
  `/slide-fold-doors/` rebuilt as the twelfth bespoke residential middle, the
  Hanslope barn study, and a new indexable route at `/care-and-maintenance/`.
  **`/tilt-turn-windows/` was ungated in this release** because Hanslope claims
  it, so `$no_case_study_routes` is down to `['aluminium-windows']` alone.
- **`ebc1a157`, 21 Aug — the bi-fold configuration rail** on
  `/aluminium-bifold-doors/`: seventeen Sheerline Prestige layouts, two to seven
  panes, in a swipe rail with pane-count jump buttons.
- **`3285863b`, 25 Aug — the first study on the site whose photographs and words
  are not ours.** A Milton Keynes composite front door, documented by the
  customer and republished with permission through a new `story` rail. Shipped
  with three case-study SEO faults fixed and `scripts/check-case-studies.php`,
  a harness that asserts every rule `CASESTUDIES.md` states.

### `/care-and-maintenance/` is the one genuinely new thing here

Nine guides in `inc/care-guide-data.php`, rendered by
`template-parts/sections/care-guides.php`, dispatched on `$is_care_guides_page`.
**Its way in is the footer, not the menu or a hub, and that is deliberate** — it
is a support page, so the three-registry rule for products does not apply to it.
It had a rule in no document at all until 2026-08-26; it now has one in `AI.md`,
including the two owner tone rules that shaped the copy. **`/downloads/` was
rebuilt into this and the rebuild was reverted** — three commits in the range
cancel out and that route shipped unchanged.

### Five traps, all of which fail silently and all still live in shared code

- **`element.hidden = true` is inert on anything the stylesheet gives a
  `display`.** An author rule outranks the UA sheet's `[hidden] { display:
  none }`, so `.fg-cs-card` at `display: grid` was never hidden and the click
  handler unhid already-visible cards. Add a `[hidden]` override whenever a new
  component both sets `display` and gets hidden from script. This has now caught
  the case-study archives, the repairs drawings and the bi-fold rail controls.
- **`<button>` wraps its children in an anonymous box, so
  `grid-template-columns` on a button does nothing.** The compiled CSS was
  byte-for-byte what was written and the render was still wrong. Nothing catches
  this short of looking at the page, and it survived a deploy.
- **`scroll-behavior: smooth` applies to USER scrolling in Chrome, not only to
  scripted scrolls**, and `scroll-snap-type: proximity` springs every small push
  back on a wide card. Both are absent from the bi-fold and story rails
  deliberately; the colour rail gets away with snap only because its swatches are
  small enough that a real nudge clears a boundary.
- **`assets/css/main.css` alone is not a discriminator when re-establishing live
  by checksum.** It is constant across long stretches, so it narrows a range
  rather than naming a commit and returned a false 4/6 positive on 19 August.
  Key on `assets/js/main.js`, which is rebuilt whenever any asset changes.
- **A deletion inside a range is not a deletion against live.** A directory was
  added and removed inside the 21 August range and nets to nothing. Check the net
  diff, not the commit log.

### What needs the owner

- **The Legend spritesheet is still 2MB and still eager on every page**, named
  the single highest-value technical item in `SEO-PERFORMANCE-AUDIT-2026-08-17.md`
  and untouched since 15 July. See the correction in `LIVECHAT.md`.
- **A wide photograph of a roofline run** remains the biggest asset gap on the
  site, and **no photograph of a tilt and turn opening** is the largest on any
  window route. Both are in `PHOTO-CHECKLIST.md` with the briefs written out.
- Three of the seven price guides still carry no price while telling the reader
  their prices are real, and the 47 national commercial county pages are still
  a keep-or-redirect decision. Both are in the 17 August SEO audit.
- The ICO position on the cookie default is **open, not closed** — see `AI.md`.

## Current state, 2026-08-16 (who-fits-it correction SHIPPED)

**Live is `d042d45a`, level with `main`, and test is level with it.** One theme
file over `0d116b8a`, both compiled assets identical, deletion list empty.

**The own-installers claim does not cover roofline installation** (owner,
2026-08-16). Two shared strings asserted it on that route and both were live: the
canonical order step 03 and the shared outside-FENSA aftercare string. Both are
now overridden for `/roofline/` only. **The route states nothing about who fits
it in either direction — do not restore either string and do not write the
inverse.** The other three outside-FENSA routes keep the shared string. Full rule
in `AI.md`.

**The reusable half:** step 03 was kept on that route deliberately, on the
reasoning that it was "true here". It was assumed, never checked, and it shipped
to live. When a bespoke route takes the canonical rail, every step needs reading
against that product.

## Current state, 2026-08-16 (roofline copy follow-up SHIPPED)

**Live is `0d116b8a`, level with `main`, and test is level with it. Nothing is
outstanding in either direction.** Six commits over `e945c600`, all `/roofline/`
copy: the FAQ rewrite, the access FAQ and three on the process rail. Two files
modified, nothing added or deleted, both compiled assets byte-identical.

**Read in this order:** the newest START HERE block in `PROGRESS.md`, then the
Current Truth section of `LIVECHANGES.md`, then the rule in `AI.md` for whichever
page you are touching.

**Two things worth knowing before touching a shared rail or hub:**

- **`$journey_order_*` is assigned unconditionally**, so a per-route override
  must sit BELOW that block. One placed above it is silently discarded, and the
  page is the only place that shows it. Roofline's overrides are deliberately in
  two blocks either side of the assignment.
- **`$product_quote_embeds` does not cover every product route.** Roofline has no
  collection and renders no embed, so any shared copy that promises an online
  price is false there. Check the map before writing a step or a CTA that assumes
  one.

## Current state, 2026-08-15 (roofline rebuild SHIPPED)

**Live is `e945c600`, level with `main`, and test is level with it.** Forty-four
commits over `34e902d6`, forty-three of them the `/roofline/` rebuild. Working
tree clean, no release branch. **One commit is on test and not live:** `a3e7050e`,
the roofline FAQ rewrite, verified and awaiting the owner.

**Read in this order:** the newest START HERE block in `PROGRESS.md`, then the
Current Truth section of `LIVECHANGES.md`, then the **Roofline Rule** and the
**Roofline Highlight Geometry Rule** in `AI.md` before touching that page.

### The release

27 files added, 6 modified, **zero deleted, zero renamed**, so the deletion list
was asserted EMPTY. **`assets/js/main.js` is provably unchanged across all
forty-four commits** — it is not in the diff, and a rebuild reproduced it to
live's own hash. Guard passed on fifteen files, eight of them expected-unchanged
(the whole tracking strand plus both compiled assets), and all fifteen re-hashed
after. Backup proven by extraction. Socket purge `msg:OK`.

### Three template traps this route exposed, all still live in shared code

- **`product_media[slug]['hero']` drives the body-image queue**
  (`generated-page.php:1081`), which excludes whatever that key names. On a route
  whose visible hero is a canvas rather than that image, the key must still name
  what the canvas shows, or one photograph repeats and another never renders.
- **`fg-product-why__media-stack` declares two rows and stretches**, so a route
  with one body image drew the second row empty at full height. Now fixed with an
  `:only-child` rule; the fix is independent of any route's image count.
- **`$product_faq_limit` is 5 on most routes** and the same slice feeds the
  FAQPage schema. A sixth FAQ renders nowhere and appears in no markup.

### What needs the owner

Two smooth board photographs held back; the six gutter photographs mixing
half-round and square profiles; the mobile heading stack on the uPVC, aluminium
and blind colour sections (pre-existing, deliberately not widened); nobody has
scrolled the story in a real browser; and the wide roofline photograph, still the
biggest asset gap on the site. Six roofline questions customers genuinely ask
remain unanswerable from anything in this repository — cost, timescale, capping
over versus full replacement, scaffolding, waste removal, and guttering on its
own. They are listed in the FAQ data comment.

## Current state, 2026-08-15 (roofline rebuild, ON TEST)

**Live is `34e902d6`. `main` is `d5581c56` and thirty-one commits sit above live,
all deliberately unshipped. Test is `80905485`, one behind `main` — deploy test
before reviewing.** Working tree clean, no release branch. Theme diff over live is
32 files with **zero deletions**, and `assets/js/main.js` is untouched across the
whole range.

**Read in this order:** the newest START HERE block in `PROGRESS.md`, then the
Current Truth section of `LIVECHANGES.md`, then the **Roofline Rule** and the
**Roofline Highlight Geometry Rule** in `AI.md` before touching that page.

### What changed

`/roofline/` was rebuilt around the shared `data-fg-aw-story` scroll canvas, the
same component `/aluminium-windows/` uses. It carries one photograph rather than
a frame sequence, and three components light in turn out of a dark scrim with a
marker naming each. No JavaScript was written: `:has()` reads the class the story
controller already sets.

Everything else on the route was corrected with it — no supplier named, no Liniar
logo, no privacy glass or frame colours, a clean gallery pool, positive copy, and
the guarantee stated as the manufacturer's rather than implying FENSA or the ten
year insurance-backed cover, which roofline does not carry.

### Unfinished, and named plainly

- **The colour rail is not built.** 23 roofline colour photographs are committed
  and ready; nothing renders them. Owner wants a swipeable rail like the colour
  hub's, on this route only, and explicitly NOT added to `/colour-options/`.
- **One of the two roofline photographs is not surfacing** in the gallery.
- **Nobody has scrolled the page in a real browser.**
- **A five-lens page audit was launched and never returned.** No findings exist;
  resume with `Workflow({scriptPath, resumeFromRunId: "wf_430f26a9-029"})`.

### The asset gap that blocks the rest

**A wide photograph of a roofline run is the biggest single asset gap on the
site.** We own two roofline pictures and both are tight detail shots. It is in
`PHOTO-CHECKLIST.md` at the top of the wishlist with the brief written out.

## Current state, 2026-08-13 (end of the forensic audit session)

**Live is `1ccc8bd8` and it is the tip of `main` again.** Established by
checksum, not read off a doc. **Three commits are on test and not live**, all
commercial specification work; test is `068ccefe`. Working tree clean, no release
branch outstanding.

**Read in this order:** the newest START HERE block in `PROGRESS.md`, then the
Current Truth section of `LIVECHANGES.md`, then the rule in `AI.md` for whichever
page you are touching. If you are about to propose site-wide work, read
**`FULL-SITE-AUDIT-2026-08-13.md`** first — it holds 220 verified findings
including the ones the owner rejected, and it will stop you rediscovering them.

**The commercial rebuild is LIVE.** It shipped inside a thirty-four commit
release on 2026-08-13 after the owner confirmed he had reviewed the pages. The
deletion assertion of exactly four by name, which this repository had been
warning about for two days, fired on that deploy and passed.

### The five owner rulings from that session, all 2026-08-13

1. **Secondary glazing has FIVE styles.** A lift-out and a fixed panel are
   different products. Supersedes the 2026-08-07 four-style line.
2. **Show case studies when nothing claims a route, but do not claim they are
   that product.** The fallback stays; the heading changes.
3. **A pending specification row renders nowhere** until the figure exists.
   Reverses the 2026-08-12 "confirming" row. Skipped at render, kept in the data
   so the tracking checklist still works.
4. **Commercial figures are a guide, not a datasheet**, because the work is
   specified across several systems per client.
5. **The internal-linking work is rejected.** The town matrix, the guides and
   `/3d-visualiser/` are landing pages. Do not re-raise it.

### Four traps this session paid for, worth knowing before you repeat them

- **An owner decision can look exactly like a deploy failure.** Optional cookies
  are granted by default on live because the owner reverted consent-first, not
  because a deploy went wrong. Read the log before diagnosing drift.
- **`data/pages.json` records can render nowhere.** Four FAQ blocks duplicated
  across ~122 pages were edited before anyone checked; product routes override
  them with `product_content` and they reach no customer. **Fetch the page.**
- **A copy sweep must never touch the privacy, cookie or terms text.** One did,
  including the processor clause, and had to be reverted.
- **Widening an approved fix is scope creep even when the wider fix is correct.**
  A casing sweep across indexed titles was reverted for this reason.

### What needs the owner

Two AOV figures; five specification tiles that still carry an adjective because
no confirmed figure exists anywhere in the repository; three price guides that
show no prices; the homepage hero lead, which still opens with a banned word; and
a decision on mobile page length, where eleven product pages exceed 15,000px.

## Commercial rebuild, 2026-08-13 — SHIPPED, see the block above

**Read the newest START HERE block in `PROGRESS.md` first.** Live is `47db7aea`
as recorded and was **not** re-established by checksum this session; do that
before any deploy. `main` and test are `6d7d956b`. **Twenty-two commits are on
test and not live**, fourteen of them this rebuild.

**AN OWNER RULING CHANGED A STANDING RULE.** *"end client name is fine. just not
contractor unless that is themselves!"* Name the end client; never the main
contractor unless the contractor owns the building. The four client-name files
the previous handover called urgent were **never a breach** — all four are end
clients on their own buildings. The rename shipped anyway because it was already
approved; **it is not precedent.**

What changed, and what to read before touching any of it:

- **`FENSTER_SPEC_TBC`** is the only way to express an unconfirmed commercial
  figure. **Five outstanding**, down from 31, listed by
  `fenster_commercial_spec_pending()` and printed into the audit doc from it. See
  the Commercial Specification Rule in `AI.md`.
- **The hub is its own template**, `commercial-glazing-v2.php`, and links **all
  thirteen** commercial routes. It linked five: AOV and every sector page had no
  way in. **Adding a commercial route means adding it to a card row here too** —
  see the Commercial Hub Rule in `AI.md`.
- **A commercial route lives in six registries.** The data, the SEO overrides,
  the sitemap virtual list, `$commercial_route_slugs`, the navigation, and the
  hub's card rows. `/industrial-and-logistics-glazing/` is the worked example.
- **Commercial pages show `commercial@fensterglazing.com`** via
  `brand.commercial_email`. The enquiry **form still delivers to `info@`** on
  every route, deliberately; see the note on that data key.
- **`fenster_case_studies_for_product_group()` takes a `$type`**, defaulting to
  residential. Commercial routes use it precisely because it has **no fallback**.
- **No marked placeholders remain** on the commercial set. Eleven photography
  gaps are listed in `PHOTO-CHECKLIST.md`, written to be forwarded.
- **Three copy rules were added to `TONEOFVOICE.md`** after three owner
  corrections: do not sell by describing what goes wrong; abstraction is not
  expertise; a page built by adding says everything twice.

**Still needing the owner:** the five figures, whether commercial form leads
should follow the commercial address, the AOV testing claim removed when no
electrical works was confirmed, and a ruling on three pre-existing negative lines.

## Handover state, 2026-08-12

**Live is `47db7aea`, established by checksum. `main` is `b1d8aed7` and SIX
COMMITS ARE ON TEST AND NOT LIVE.** Test is deliberately ahead. No release
branch outstanding, working tree clean.

**URGENT AND UNSHIPPED: four client names are still public in image URLs on
production.** The fix is written, owner-approved and verified on test; it has
not been deployed. `Airbus-Commercial.jpg`, `ROKA-Dental-Post-Fitting-2-1-scaled.jpg`,
`BFI.jpg` and `Greensand-Country.jpg` all still return 200 on live, which
breaches the Commercial Client Anonymity Rule.

**That deploy needs a deletion assertion of EXACTLY FOUR, BY NAME — not empty.**
Two renames and two deletions, and rsync counts a rename as a deletion even
though `git diff --name-status` prints `R100`. Every other release this month
asserted zero, so a copied-forward guard will abort. The full START HERE block
in `PROGRESS.md` lists the four.
`LIVECHANGES.md` is the authority on what is live; `PROGRESS.md` is a log and
some of its older entries are still titled "(test)" long after shipping.

**Read in this order:** the START HERE block at the top of `PROGRESS.md`, then
the Current Truth section of `LIVECHANGES.md`, then the rule for whichever page
you are touching in `AI.md`.

**ESTABLISH LIVE BY CHECKSUM ON MORE THAN ONE FILE, AND MAKE ONE OF THEM A
COMPILED ASSET.** On 2026-08-12 live was not on `main` at all — it was another
session's tracking release, on no branch this session had — and
`inc/site-data.php` still matched the previous release from this session, so the
PHP looked familiar. Only `assets/js/main.js` gave it away.

**TWO SESSIONS ARE ACTIVE IN THIS REPO AND BOTH SHIP.** Before any release,
diff the theme by file between live and what you intend to deploy. On
2026-08-12 that check turned an alarming forty-three commit range into a
one-line deploy, because every file of the other session's tracking strand was
already byte-identical on live. Cherry-pick only when the file diff says you
have to.

**A REBUILD ALONE MOVES `assets/js/main.js`.** The esbuild on this machine is
newer than the one that built live's bundle, so `npm run build` rewrites it even
when no JavaScript source changed. Check `git status` immediately before any
rsync, and check the artefact back out if the source did not move.

**The ELEVEN residential routes with a bespoke middle** — verified against the
dispatch in `generated-page.php`, not from memory. These do NOT use the generic
product journey, and each has a rule in `AI.md` to read before editing:

| Route | Template |
|---|---|
| `/casement-windows/` | `casement-windows-v2.php` |
| `/flush-casement-windows/` | `flush-casement-windows-v2.php` |
| `/aluminium-doors/` | `aluminium-doors-v2.php` |
| `/aluminium-flush-windows/` | `aluminium-flush-windows-v2.php` |
| `/heritage-windows/` | `heritage-windows-v2.php` |
| `/secondary-glazing/` | `secondary-glazing-v2.php` |
| `/double-glazing-replacement/` | `replacement-glazing-v2.php` |
| `/window-and-door-repairs/` | `window-door-repairs.php` |
| `/composite-doors/` | `composite-doors-v2.php` |
| `/upvc-doors/` | `upvc-doors-v2.php` |
| `/tilt-turn-windows/` | `tilt-turn-windows-v2.php` |

**And ONE commercial route**, dispatched from `commercial-product.php` rather
than `generated-page.php`, which is a separate template with its own bands:

| Route | Template |
|---|---|
| `/louvre-vents/` | `louvre-vents-v2.php` |

`/heritage-aluminium-doors/` has a rule in `AI.md` but **no** bespoke template;
it runs the generic journey with route-specific data.

**Every bespoke dispatch sits OUTSIDE the specification-choices wrapper.** Put
one inside and the whole middle is gated on a condition about colour swatches and
silently renders nothing. That has caught two people; the warning is in the code.

**Commercial and residential case studies do not mix.**
`fenster_case_studies_for_product()` takes a `$type` argument defaulting to
`residential`, and the commercial template passes `commercial`. Filtering it
that way is what gated the strip off `/aluminium-windows/` and
`/heritage-windows/`: with no residential study of their own they fell back to
secondary glazing and uPVC casements, which is worse than showing nothing.

**PRODUCT NAMES WERE ALIGNED WITH THE SHOWROOM AND WINDOWCAD ON 2026-08-12 AND
ARE LIVE (`e3ea19e9`).** Seven renamed, no URL moved. Read the Product Naming
Rule in `AI.md` before touching any product label, because the one thing worth
knowing is that **a product name lives in seven registries and none of them
checks another** — the last two were found by rendering pages, not by grepping,
after the first pass left ~260 town routes with a renamed SERP title and an
un-renamed H1.

| Route | Name |
|---|---|
| `/casement-windows/` | uPVC Casement Windows |
| `/flush-casement-windows/` | uPVC Flush Sash Windows |
| `/tilt-turn-windows/` | uPVC Tilt & Turn Windows |
| `/aluminium-windows/` | Aluminium Casement Windows |
| `/heritage-windows/` | Aluminium Heritage Windows |
| `/patio-doors/` | uPVC Sliding Doors |
| `/slide-fold-doors/` | Slide & Fold Doors (ampersand only) |

Short form in the menus, full name everywhere else. **SEO title tags
deliberately did not follow**, except two where the new name prefixes rather
than displaces the ranking phrase.

**`/tilt-turn-windows/` was rebuilt on 2026-08-12 and IS LIVE (`831bfa44`).**
Read the Tilt And Turn Windows Rule and the Tilt And Turn Imagery Rule in
`AI.md` before touching it. Three things about it are worth knowing before
anything else:

- **Its old hero was a side-hung casement opening outward**, not a tilt and
  turn — barrel hinges on the jamb, sash proud of the frame — and its alt text
  claimed the sash was tilted. Check hinges before trusting a supplier
  filename.
- **It is the only Liniar route off the shared 0.95/1.2**, on the owner's
  ruling: Liniar's own 1.3 double and 0.93 triple. Their lower 0.85 whole-window
  figure is almost certainly the 40mm IGU, which we do not fit. **The figures
  live in two arrays that nothing joins** — `glazing_u_values` and
  `$glazing_by_route` in `fenster_tech_banner_args()`. Change both or neither.
- **Its case-study strip was showing three wrong-product studies and is now
  gated**, alongside `/aluminium-windows/`.

**Open and needing the owner, not code:**

- **Tilt and turn: nothing we own photographs one tilting or turning.** Still
  open, owner confirmed 2026-08-12 that there are no photographs yet. The page
  runs on four Liniar studio renders of the mechanism because they are the only
  assets that show the product working. One phone shot of a sash in tilt from
  inside would change that page more than any other single thing.
- ~~Tilt and turn colours: sixteen or Liniar's nine?~~ **Left at sixteen, owner
  instruction 2026-08-12.** Not ruled wrong, left. The discrepancy against
  Liniar's nine is recorded in `AI.md` so it is not re-raised as a bug.
- ~~Is the tilt and turn chamfered as well as sculptured?~~ **Closed 2026-08-12:
  sculptured only**, the same answer as the casement. On the page and in
  `AI.md`. Note `data/pages.json` still carries dormant scraped "sculptured or
  chamfered" copy that does not currently render.

- **uPVC doors, two answers outstanding.** Maximum sizes for a single leaf,
  French doors and a stable door, and what each of the four thresholds is best
  for beyond "we aim for the low aluminium". **Laminated glass is settled**:
  owner-confirmed 2026-08-12 as an upgrade on every main product, with no figure
  published anywhere because none is confirmed. See the Owner-Confirmed Business
  Facts in `AI.md`.

- Roehampton case study, parked on four facts.
- A typical flush aluminium job with dummy sashes in the fixed lights.
- A Prestige STANDARD corner render from Sheerline.
- A wide, honest hero for `/aluminium-doors/`. Longest-standing gap on the site.
  The Heal's door was tested against it and fails: a 3:1 band cannot hold a door.
- **A residential heritage window study and a residential aluminium window
  study.** Each un-gates a case-study strip that is currently switched off.
- **A second heritage window job, and ideally a steel before-and-after.** One
  residential install exists, plus the two fixed heritage windows inside the
  Heal's commercial study. A dark job would change what the page looks like:
  everything of our own is white.
- **Louvres**: a wide run in context, and the Heal's louvres, unphotographed.
  No caption anywhere names which system a photographed job used, so none do.
- **Blanking panels** on the louvre page: left out when composite panels were
  excluded from the range, and never actually ruled on.
- Fourteen stale `release/*` branches on origin, each one a loaded gun if
  deployed later.
- Two `.DS_Store` files tracked in the theme from an earlier session.

**Known and deliberately not fixed:** all 23 routes that render the
key-specification strip repeat their own H1 as an H2 inside it.
`/aluminium-flush-windows/` overrides it; the rest do not.


Last updated: 2026-08-26

This file gives a new AI agent the current context needed to work on the whole site.

Use:

- `AI.md` for coding rules and QA standards.
- `AUDIT.md` for the 2026-07-03 master site audit, launch-blocker remediation status and remaining backlog.
- `GOOGLE-ADS-AUDIT-2026-08-11.md` and `GOOGLE-ADS-FIX-2026-08-11.md` for the
  11 August paid-search rebuild: the evidence, and what was changed in the
  account. Between them they correct `GOOGLE-ADS-PLAN.md`'s reading of a high
  CTR on price keywords, which was a warning and not the positive it was taken
  for. Read these before acting on `GOOGLE-ADS-PLAN.md`.
- `SEO-LEAD-AUDIT-2026-08-05.md` for the launch measured against Search Console, the rank-tracker read and the dashboard conversion funnel. It is the current source for what organic traffic does after it lands.
- `STYLE.md` for site-wide visual styling, continuous background rules, section rhythm and mobile design expectations.
- `HOMEPAGE.md` for homepage-specific design and implementation context.
- `PROGRESS.md` for dated progress reports.
- `LIVECHANGES.md` for the exact SSH/deploy workflow, live safety rules and what not to touch.
- `LIVECHAT.md` for the complete Legend AI assistant architecture, live behaviour and commit history.
- `https://github.com/0riceisnice0-hash/Marketing-Dashboard/blob/main/WEBSITE-TRACKER.md` for the Website Tracker operating model, consent boundary and how to interpret its data. This is the tracker source of truth; do not infer meaning from a dashboard card label alone.

## Important Updates

- **A LOCAL-ONLY 3D EXPERIMENT EXISTS AT `/fenster-new-home-page/`, added
  2026-08-21.** It is a scroll-driven three.js hero built on real WindowCAD
  geometry, and it is a sandbox beside the homepage rather than a replacement:
  **the live homepage is untouched and shares no code path with it.** Read
  `wp-content/themes/fenster/assets/experimental/README.md` before touching
  anything named `experimental`.
  - **It cannot reach production.** `fenster_experimental_home_enabled()` is a
    host allow-list for local development only, so a deploy serves a 404. That
    is a real gate rather than an absence of approval, per the standing rule
    this file records against the composite-doors incident.
  - **Four existing files changed and nothing else**: one `require` line in
    `functions.php`, `three` plus a separate `build:atrium` script in
    `package.json`, the lockfile, and this pointer. The atrium builds to its
    own `assets/experimental/` bundle, so `main.css` and `main.js` do not grow
    by a byte.
  - **Pass two, 2026-08-21.** The fixed column of hero copy was removed
    entirely and that information moved into the scene as geometry — callouts
    with hairline leaders, type lying on the floor, numbered steps — and the
    room was rebuilt as a **light** architectural gallery rather than a dark
    one, at the owner's request. The inversion is the part worth understanding
    before editing anything visual: nearly everything Fenster sells is
    specified in anthracite, and a dark frame against a pale wall separates on
    its own, so the hero finishes are now the real colour rather than the mid
    grey they had to be lifted to in order to survive a black backdrop.
  - Every specification the scene states is passed in from PHP and is already
    published on the route it belongs to. The range counts are **counted** from
    the same registry the menu is built from, so "09 window systems" cannot
    drift from the actual range.
  - **Pass three, 2026-08-21.** The headline is a bug: the seven baked
    open/close animations had **never run**, in either earlier pass.
    `setOpen()` scrubbed via `mixer.setTime()`, which zeroes the action's time
    and then relies on a delta that a *paused* action ignores — so no sash ever
    opened, the composite door never swung to reveal the terminal, and the
    bifold "concertina" was a closed slab sliding across frame. The page's
    central claim, that scroll scrubs real WindowCAD hinge geometry, was not
    true until one line changed. It was found by measuring the world position
    of a named animated node; `mixer.time` reported the correct value
    throughout, which is why two passes missed it.
  - The README's **"twenty-three traps"** section is the one to read first. All
    of them fail silently, and every one of them looks like a different bug
    than it is.
  - `scripts/sweep.mjs` is new and found most of pass three. It samples the
    timeline densely, or captures a frame every 200ms under real playback, and
    measures the **difference between neighbouring frames** — flagging things
    that pop, stop dead, or move faster than the eye can follow. Motion faults
    live in the gaps between contact-sheet beats and a twelve-still sheet
    cannot see them.
  - **Pass four, 2026-08-21.** The route was rebuilt as a **straight line down
    the spine of the building at x = 0, forward-only** — measured at 0.000m
    worst backward step and 0.000 maximum |x| — with the splayed walls bringing
    both products to the camera instead of the camera swinging between them.
    The bifold stopped being a thing that flew past the lens and became a
    glazed screen standing across the route that folds open to let you through,
    which is the one reason a bifold exists.
  - Four structural faults in that pass were all **invisible rather than
    wrong-looking**, and all four are written up in the README:
    - Two `slab()` calls in `buildVWall` omitted the `y` argument, so
      `position.set()` wrote NaN and three.js drew nothing. **Sixteen meshes —
      the inner pier and outer wing of every V wall — had never rendered.**
    - `buildShell`'s far vista, a 64 × 28m plane, was pinned at z −52 with a
      comment reading "the camera never reaches it". True when the route ended
      near −40; after the length was doubled it stood across the middle of the
      route and the camera flew through it.
    - `buildGlassHall` placed panes in polar coordinates biased to ±π/2, which
      the comment described as "away from the route" and which actually put
      them *on* it. The camera passed 6cm from a sheet of glass.
    - `buildMaterialBay` and `buildPortal` were imported and never called, and
      their teardown lines pointed at properties that were never assigned —
      optional chaining makes a dead `dispose()` a silent no-op.
  - **Scenery placed by eye can delete a station.** The material bay was briefly
    put into the gallery and its side bays stood between the camera and all
    seven of station 4's specification blocks. Each callout reported visible,
    opaque, valid depth and correctly framed — nothing in a callout's own state
    can tell you a different object is in front of it. It is not placed; see
    the README before finding a home for it.
  - **A clamp that never reports is a bug that never surfaces.** The camera
    track's monotonic backstop had silently moved station 3's hold 4.5m, putting
    both doors at ndc ±1.12 — entirely outside the frame at their own hero beat.
    Found only by auditing authored pose against actual pose at every station;
    v1, v2 and v4 came back shifted by 0.0 and v3 by −4.5. If a system has a
    corrective clamp, measure how often it fires.
  - **Scroll no longer advances the timeline at a constant rate**, at the
    owner's request that it "slow right down" at each USP section. Eight beats
    get a dwell; measured, the camera covers 0.5–2.0m per 2.5% of scroll at a
    product hold against 5–9.9m in the gallery between them. The warp is
    monotonic and a pure function of scroll position, so reverse scroll and
    exact seeking both still hold. The runway grew to **3200vh** to pay for it
    rather than making the travel faster.
  - Known limit: **portrait is a compromise.** The stations are composed for a
    16:9 horizontal field and a phone has a quarter of it. The camera is backed
    off along its view axis so the whole composition is visible, but the
    products are small and the callouts crop. A phone deserves its own camera
    track showing one product at a time.
  - **Pass five, 2026-08-24.** The owner asked for a different navigation model
    and named five visual faults. Four of the five turned out to share one root
    cause, which is the entry worth reading:
    - **Every opening in the building was the same hole.** They were sized from
      `sample.height * 0.82 + 0.16`, which looks derived and is a constant:
      `product.height` is the NORMALISATION TARGET, literally 2.35 for all nine
      models. Six of the eight station products were physically WIDER than the
      hole they stood in (the casement and flush sash by 524mm, burying 262mm
      per jamb in solid wall) and the two doors were a metre NARROWER than
      theirs. "The casement overlaps the frame" and "the door frames are too
      big" were the same bug seen from two ends. Openings are now measured off
      each product's own bounding box with a 0.20m reveal.
    - The bifold had the same fault in a different form: `Math.max(3.2,
      measuredWidth)` where the measurement is 2.785, so the floor always won
      and added 415mm nobody asked for.
    - **The specification labels were running at a 4-to-7px font-size
      equivalent.** `buildCallout({height})` sized the PLATE, and the canvas
      grows with line count, so one value produced different type on different
      blocks — a three-line note was silently 27% smaller than a two-line one.
      The parameter is `titleCap` now, the world height of a capital, and the
      plate sizes itself. Wrapping is what paid for it: a 3.8:1 strip becomes a
      1.8:1 column, which buys the size at constant on-screen width.
    - The bifold slid 350mm sideways as it folded, under a comment claiming the
      leaves stack to one side. Measured, they do not — the clip folds
      symmetrically in Z. The translation drove the frame into the pier and off
      its own floor track. Deleted.
    - The bifold never had a title block built, so it was the only product in
      the building that never said its own name, even though 'BIFOLD /
      SHEERLINE PRESTIGE ALUMINIUM' had been in the registry and reaching the
      client all along.
  - **The timeline is stepped, not scrubbed.** Seven stops — the mark, four
    stations, the bifold, WindowCAD — and one wheel gesture travels to the next
    and holds. That replaced a Lenis instance, a dwell warp, a second smoothing
    pass and a 3200vh runway (now 100vh), all of which existed to make a
    scrubbed timeline feel paced. Arriving at the last stop hands scrolling
    back, because **a wheel over a cross-origin iframe never reaches a listener
    on this document** and WindowCAD covers the middle of the screen.
  - **The WindowCAD iframe was painted where it could not be clicked**, and had
    been since it was built. `getBoundingClientRect()` reported it exactly where
    it appears; `elementFromPoint` at the centre of that rectangle returned the
    section root. Everything you would check read healthy — pointer-events auto,
    opacity 1, aria-hidden false, nothing covering it. The perspective is a
    transform FUNCTION on the camera wrapper, which is what makes the render
    land pixel-exact, but the wrapper's layout box stays 110x63 in the middle of
    the screen and hit testing follows the layout box. It never surfaced because
    nothing had tried to click it; making the last stop somewhere the visitor
    RESTS is what exposed it. Fixed by swapping to a plain 2D box once the panel
    is square-on — exact, not approximate, because a plane parallel to the image
    plane projects to an axis-aligned rectangle. **If something must be
    clickable, hit-test it with elementFromPoint; a correct bounding rect proves
    nothing.**
  - **The camera is rigid**: 0 pitch, 0 roll, 0 yaw, x = 0, one height, one
    lens, verified across 250 samples. The largest tilt had no name in the
    source — `camera.lookAt()` pitches whenever the target's y differs from the
    camera's, so grepping for tilt or roll finds everything except the thing
    doing most of the tilting. Levelling then moved every composition: the mark
    was sliced off the top of frame, the door stations dropped 0.26 NDC, and the
    terminal ended up behind the site header. Budget for that.
  - The models are **WindowSoftware's IP** (`3d.md` §11) and are local only.

- **TWO SHOWROOM PAGES EXIST AT `/window-showroom/` AND `/door-showroom/`,
  added 2026-08-24.** They came out of the audit of the 3D experiment: rather
  than replace the homepage with it, the valuable part — real WindowCAD geometry
  with real specifications — was moved onto pages where somebody is actually
  choosing a product. Read
  `wp-content/themes/fenster/assets/showroom/README.md` before touching
  anything named `showroom`, and `PRODUCT-VIEWER-BRIEF-2026-08-24.md` for why
  they are built the way they are.
  - **The one rule: the 3D viewer is never on the critical path.** The page is
    complete, indexable and converting as HTML plus a poster image; `three` is
    imported dynamically only when the visitor presses *View in 3D*. Measured:
    LCP 828ms on an `<img>`, CLS 0, the page's own assets 139 KB across 10
    requests, 5,477 crawlable words. The audited 3D page managed 170.
  - **All nine products' specifications are in the served HTML**, one visible
    and the rest `hidden`, so a crawler reads the whole range and switching
    product is a class change rather than a fetch.
  - **The models were reprocessed, not just compressed.** 9,125 KB to 1,087 KB,
    draw calls from 2,223 to 51–111, frame time from 57ms to 1.1–2.12ms. The win
    is the material merge rather than the codec: a WindowCAD export gives every
    gasket its own material, and merging them leaves exactly one `fenster:frame`
    material per product — which is what makes the finish switcher one
    assignment. `npm run models:optimise`, then `npm run models:verify` to
    confirm every baked animation still moves.
  - **Eleven of the eighteen range products have a model** (windows 4 of 9,
    doors 7 of 9). The rest are photography cards in the same grid. Do not close
    that gap by recolouring one product and relabelling it.
  - **Two site-wide problems surfaced while measuring, neither caused by this
    work and neither changed:**
    - `legend-spritesheet.webp` is **1,996 KB and loads on every page**, 2,118 KB
      with its companion — about half the homepage's entire payload. Hiding the
      widget in CSS, which the 3D experiment does, does not stop the download.
    - `lang="en-US"` in the header on a UK site.
  - Traps worth knowing before editing: a `renderer.info.memory` leak test must
    return to the SAME product before comparing, or it reports a phantom leak;
    `Box3.setFromObject` must not run inside a per-frame camera update; and
    frame rate must be measured by timing `renderer.render()` directly, because
    requestAnimationFrame in the headless harness is throttled to 30fps and
    measures the compositor rather than the scene. All written up in the
    showroom README.

- **`/heritage-windows/` was rebuilt on 2026-08-11 and is live**, as the ninth
  bespoke residential middle. It is written around the steel window it replaces
  rather than the metal it is made of. We fit the Sheerline Classic **stepped**
  sash only. Read the Heritage Windows Rule and the Heritage Windows Imagery
  Rule in `AI.md` before touching it: most of what is there is an owner
  correction, including the removal of a bar-layout planner (WindowCAD is the
  interactive tool on this site, and that is now twice a built one was cut).
- **Triple glazing is NOT available on either Sheerline Classic route.** It
  needs the contemporary sash; we fit the stepped one deliberately, to keep
  Classic distinct from Prestige. It came off `/heritage-windows/` and
  `/heritage-aluminium-doors/` on 2026-08-11, and the energy tile went with it
  to "A rated" because A+ was the triple figure. Legend may offer triple on
  request, naming the contemporary sash, and may not quote a U-value for it.
- **`/upvc-doors/` was rebuilt and then audited on 2026-08-12 and is live**, as
  the tenth bespoke residential middle. Read the uPVC Doors Rule in `AI.md`
  before touching it: nearly all of it is owner correction, including that a
  panel is a component rather than a style, that the style is not a preset list
  and must never be counted, that a door takes thirteen foils where the windows
  take sixteen, and that PAS 24 is Liniar's and attributed. **A door randomiser
  was built here and removed the same day** — the third home-built interactive
  feature this site has cut, after the casement configurator and the heritage
  bar planner.
- **`/louvre-vents/` was rebuilt on 2026-08-11** around the full louvre range
  and is the only commercial route with a bespoke middle. **Do not name the
  system manufacturer anywhere on it** — model codes are fine, the brand is not,
  and the meta description outlived the first debranding pass by four hours
  because that pass read rendered text and never the head.
- **The All Hallows, Bedford commercial case study is ON TEST as of 2026-08-12**,
  and with it two fixes to `fenster_case_studies_for_town()`: commercial studies
  are filtered out of the residential town matrix, and a town match is
  word-boundary rather than substring. Both faults were live. The Bletchley rail
  depot was rendering as local proof across the MK suburb routes, and every
  Bedford route was claiming a Leighton Buzzard job because "Bedfordshire"
  contains "Bedford". Bedford now renders no strip, deliberately.
- **The Heal's, Tottenham Court Road commercial case study went live 2026-08-11.**

- **Live is on `main` lineage again, and has been since 2026-08-07.** The
online-quote strand that forced two cherry-picked releases shipped with `e70bb96`
and the divergence closed in both directions; four releases have gone out from
`main` since, this one included. **The live SHA is in `LIVECHANGES.md` and
deliberately not repeated here** — this line used to carry its own copy and went
four releases stale. **FOURTEEN `release/*` branches survive on origin**, the newest dated
2026-08-07 and the oldest 2026-07-21. None is on live's lineage — they were cut
from live and cherry-picked, so their content is live under different hashes and
the commits themselves diverge. Deploying any of them reverts real work; this
repo has been bitten by exactly that twice.
- **`/window-and-door-repairs/` was rebuilt from the ground up and went live 2026-08-07.** A symptom-led diagnostic with two to-scale AutoCAD-style schematics that highlight the failing part. See the Window And Door Repairs Page section below before touching it — three builds were needed and the first two were rejected, so most of the constraints there are the owner's corrections rather than preferences.
- **Two pages were rebuilt on 2026-08-06 and are live.** `/flush-casement-windows/` now replaces only the *middle* of the generated template (`fg-product-why`, `fg-product-intel`, `fg-product-visuals` are gated off for that slug) with `template-parts/sections/flush-casement-windows-v2.php`, built on the `.fg-cw` split grammar the heritage door page uses. It is deliberately **not** an early return like casement, and deliberately **not** given casement's stacked chapters — the owner wants that device unique to casement. `/obscured-glass/` gained the colour-hub hero treatment, starts on the house scene rather than Legend, and its divider now drags properly on touch.
- **The obscured-glass divider is a `<input type="range">` that no longer takes the pointer.** On iOS a range only drags from its thumb, so the divider was tap-to-position and felt broken. The input is now `pointer-events: none` for keyboard and assistive tech only, and the gesture is handled on the stage with axis-locked pointer events that write the value back to it. `touch-action: pan-y` is retained so a vertical scroll starting on the visualiser still scrolls the page. **This was never verified on a real phone** — it is the one change from that session nobody has touched with a finger.
- **Product claims corrected on 2026-08-06, do not reinstate.** Mechanical jointing is **not** offered on the Liniar flush sash system — Liniar publish it for the profile, which is their capability and not ours, and it had been sold in both copy and the choices list. The flush system takes a **28mm double glazed unit only**, no triple; that answer lives in the FAQ rather than mid-page. Warwick is **privacy 1**, per Pilkington's own decorative glazing page.

- **The live SHA lives in `LIVECHANGES.md` and nowhere else.** This line used to carry its own copy and was three days and four releases out of date by 2026-08-04, while `HANDOVER.md` and `nick.md` each carried a different stale one. One pointer, one file. **Re-establish live by checksum immediately before any deploy anyway**, on more than one file and on files the candidate commits actually differ in: three of five once tied across two candidates and only two separated them.
- Superseded: the casement rebuild described here shipped on 2026-08-05 and the page has since been restacked again. `LIVECHANGES.md` carries the current state; this line is kept only so the "a release from `main` ships the whole range" lesson in it is not lost.
- **`/patio-doors/` and `/handle-options/` carry the sliding patio handle** as of 2026-08-02: `patio_handles` in `inc\site-data.php`, assets under `assets\images\products\handles-patio`, five Mila ProLinea finishes. It is a separate family from `door_handles` because a slider takes a D-pull rather than a lever, and it is deliberately not on `/aluminium-sliding-doors/`. See the Patio Handle Rule in `AI.md`.
- **Deploy trap — read before any live deploy.** The live deploy one-liner in `LIVECHANGES.md` runs `git reset --hard origin/main`, so it ships *everything on `main`*, not the specific commit you verified. On 2026-07-18 a deploy of the small Legend iframe fixes swept fourteen unapproved composite-door commits onto production with them. If you need to release one approved commit, reset the server repo cache to that exact SHA instead of `origin/main`.
- GitHub is live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. It versions the custom theme and docs only, not the full WordPress install.
- Local development uses the standard WordPress path `wp-content\themes\fenster`, but SiteGround test/live are verified Bedrock installs. Server theme paths are `~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/` and `~/www/fensterglazing.com/public_html/web/app/themes/fenster/`.
- Deployment should update the `fenster` theme from the GitHub repo while leaving production `.env`, Bedrock config, uploads, database and plugins untouched. Do not deploy `wp-content\fenster-reference`; it is a local-only scrape archive and no runtime code should depend on it.
- Test and live are both running the new `fenster` theme. Every completed change follows local edit -> build/lint -> commit/push -> test deploy -> test verification. A later live deployment uses that same committed theme after the appropriate approval and backup checks.
- Do not use SiteGround clone/staging tools for this project. The safe model is always a theme-only test deployment from GitHub before live, regardless of change size. This avoids editing test and live at the same time and avoids accidental database URL rewrites.
- Generated pages are theme-owned for SEO. Yoast/Rank Math public head output is suppressed on generated pages to prevent duplicate metadata and stale imported schema/social tags. Do not reset Rank Math for launch; use it only later if there is a clear admin-tool reason.
- Launch SEO hardening is complete for the current technical blockers: homepage title/meta override, generated route 301 normalisation, generated breadcrumb schema, public cache headers, sitemap scrub to 421 currently verified canonical URLs, `/commercial-areas/` removed from the header, and footer links to `/areas-we-cover/` and `/terms-conditions/`.
- The stale pre-launch audit was rechecked on live on 2026-07-06. Current verified state: social metadata is theme-owned and clean, `lang="en-GB"` is active, `/upvc-colours/` and `/aluminium-colours/` redirect to `/colour-options/`, public REST user enumeration returns 401, WordPress generator/RSD/oEmbed/wp-json/shortlink head links are stripped, and the theme sitemap is served before Rank Math with 421 canonical URLs.
- Latest local SEO quick-win state: commit `68f38ae` restored `/areas-we-cover/` to the generated sitemap/link graph, added LocalBusiness `geo`/`hasMap`/`sameAs`, cleaned local money-page title/meta overrides and strengthened links into `/double-glazing-milton-keynes/` plus the agreed pricing hub `/window-door-prices-milton-keynes/`. Commit `51c3550` removed the accidental `/double-glazing-prices-milton-keynes/` route and all internal links to it; do not recreate that exact route unless the owner explicitly asks. Roof-light keyword coverage is already handled in title/meta overrides for `/roof-lanterns/`, `/roof-lanterns-milton-keynes/` and `/roof-lanterns-northampton/`.
- The residential location matrix has unique generated metadata across the 13 town x 21 product pages. Commercial county metadata is profile-specific, and Isle of Wight commercial glazing has been removed/410'd as inaccessible coverage.
- Mobile launch fixes are complete for the About process cards, Contact page CTA cards and quote-tool controls. Mobile quote embeds use one same-tab `Open quote tool` action; desktop keeps `Expand view` and `Open in new tab`.
- Test and live enquiry delivery have been verified: valid submissions save as private `fenster_enquiry` posts and send office HTML emails to `info@fensterglazing.com`.
- The shared form's reusable `consultation_booking` mode has a dedicated indexable `/book-a-consultation/` page, and **that is the only place it renders** as of 2026-08-02. The Contact page carries the general enquiry form instead: `931c7ef` had converted that page's enquiry form into a second booker in place, leaving `/contact/` with no way to send a plain message, so the site repeated one journey and offered the other nowhere. The Contact hub card links here. Its accepted journey is deliberately short: a booking-first hero with the calendar as the dominant action and concise Trustpilot/FENSA reassurance directly beneath it; one large, art-directed bifold-door image paired with consultation advice and icon-led phone/email contact; concise visible FAQs/FAQPage schema; then the real review showcase. Do not restore process cards, a detached homepage proof wall, generic image-card grids or related-link filler. Its date stage is a compact six-week calendar card sized to the interaction, with a concise availability strip: Monday-Friday, 9am-4pm, excluding England-and-Wales bank holidays. The final details stage is a dedicated light-surface form with an appointment summary, legible bordered fields and a clearly contained consent/submit area rather than the shared dark-form styling. The official GOV.UK holiday feed is cached and enforced in both the picker and submission validation. Its background is one continuous `--fg-page-gradient` canvas, per `STYLE.md`. The desktop header, Products menu CTA and Contact consultation card lead to this canonical route. It saves and emails the selected date/time as a consultation request. It is a request flow, not live availability; the office must confirm the appointment.
- WindowCAD/AdminBase lead relay is theme-owned again through `inc\adminbase.php`. The old `wraith` REST endpoint `/wp-json/fenster/v1/windowcad` is restored, normal saved enquiries also relay through `fenster_enquiry_created`, and credentials must stay in server config/options rather than committed code.
- The live Marketing Dashboard Website Tracker is the consented, no-PII attribution surface. Its source code, API implementation and tracker README are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`. It stores opaque `FGV-…` visitors and `FG2-…` journeys for 90 days in the same consenting browser, first-touch attribution, pages/time, meaningful link/quote/form/phone/email events, completed WindowCAD quotes and a clickable journey timeline. It is not a CRM: personal lead data stays in WordPress/AdminBase.
- WindowCAD must keep its office **Reference** field untouched. The website URL parameter maps only to WindowCAD’s separate **Tracking** field. Accepted visitors receive `FG2-…`; a visitor who arrived from an ad receives the consent-free `FGA-…` whatever they chose; rejected-cookie quotes write `rejected-cookies`, and no-choice quotes write `cookie-consent-not-accepted`. The latter two still create office leads but are intentionally excluded from dashboard journey joins. ~~**All four are reachable under consent-first** — the no-choice value was unreachable during the 2026-08-09 to 2026-08-11 granted-by-default period and is live again.~~ **CORRECTED 2026-08-26: granted-by-default was restored on 2026-08-12, so `cookie-consent-not-accepted` should be unreachable again.** An unanswered visitor has `analytics: true`, so `journeyReference()` hands back a real `FG2` and the fallback is never reached. Read from the code rather than measured against production, so **check WindowCAD before relying on it either way** — and if the default is ever flipped back to off, all four go live together.
- 2026-07-21 tracking audit outcome (corrected): WindowCAD's tracking capture is invisible and URL-driven and was never broken. The app reads the `tracking=` URL parameter and includes it in the submission's Tracking info property independent of the visible form field list; verified end-to-end the same day via intercepted submissions plus a live owner test (`FG2-ZACLIVETEST0721` reached WindowCAD, WordPress, AdminBase and the dashboard). Leads without a tracking value are sessions that did not start from a site URL (office-entered projects, direct or re-opened WindowCAD links). The genuine 2026-07-21 outage was AdminBase's renewed TLS certificate (Sectigo R46 root missing from WordPress' bundled CA file): relays failed with cURL error 60, leaving leads in WordPress but not AdminBase; fixed by `fenster_adminbase_http_ssl_args()` using the host system trust store, the two stranded leads were re-relayed, and the WindowCAD handler now sends the dashboard `quote_completed` before attempting AdminBase. Customer retail submissions were genuinely quiet 2026-07-16 to 2026-07-21; volume is now observable through the dashboard's consented and aggregate quote-completion counts.
- Google Ads quote attribution is completion-led. Campaign suffixes carry `ads={adgroupid}` into the Fenster landing URL; the theme preserves that tracker and copies it into every WindowCAD URL alongside the existing `tracking=FG2-...` value. Accepted ad clicks also store `gclid`/`gbraid`/`wbraid` in WordPress against the FG2 journey through `/wp-json/fenster/v1/ad-attribution`. When WindowCAD posts a completed quote back, the private `fenster_enquiry` receives the ads tracker and click ID needed for offline conversion import. The click ID never goes to the Marketing Dashboard or AdminBase. `quote_opened` and `quote_iframe_loaded` remain diagnostic funnel events only.
- Consent health is aggregate-only and granular: `necessary_only`, `analytics_only`, `marketing_only` and `all`, per day and per environment. Rejected visitors must never get a visitor/journey ID or browsing event. **Banner impressions are counted again** (`shown` from the mandatory modal into `banner_shown`), on the owner's 2026-08-02 instruction; they are a health check only and must never be used as a denominator, because they structurally undercount against choices. See the consent rules in `AI.md` before touching either. Future Focus Group call integration should send actual call outcomes into the dashboard only after an API/webhook or scheduled export is available; phone taps alone remain intent, not confirmed calls.
- Non-consented traffic now has a separate statistical-only aggregate path. It records hourly totals for page views, engagement, quote/form starts or sends and contact intent, grouped by page, broad device class and referrer host. It never creates `FGV`/`FG2`, visitor timelines, fingerprinting values, IP-derived identifiers, ad joins or lead joins. The footer provides an anonymous-statistics opt-out.
- Office email delivery currently uses the old proven envelope: `WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`. **Owner-confirmed 2026-08-10 that `info@` is the correct recipient**; there is no override constant and no filter on live, so `fenster_enquiry_recipient()` returns the default. Customer confirmation emails are paused unless authenticated SMTP is configured, so public form copy must not promise a confirmation email.
- Enquiry forms support optional file uploads (`attachments[]`) for photos, drawings, schedules and documents. Files are stored against the private enquiry and attached to the office email.
- Live mail deliverability still needs authenticated SMTP for future customer-facing sends. The mailbox MX is Microsoft 365, and unauthenticated PHP mail can show Outlook verification warnings. The theme supports `FENSTER_SMTP_HOST`, `FENSTER_SMTP_PORT`, `FENSTER_SMTP_USERNAME`, `FENSTER_SMTP_PASSWORD`, `FENSTER_SMTP_SECURE`, `FENSTER_MAIL_FROM` and `FENSTER_MAIL_FROM_NAME` from Bedrock `.env` or PHP constants.
- Legend's AI chat backend is theme-owned in `inc\legend-assistant.php` and exposed only through `POST /wp-json/fenster/v1/legend/chat`. Both test and live Bedrock environments are separately configured with `FENSTER_OPENAI_API_KEY`; `FENSTER_OPENAI_MODEL` is optional and defaults to `gpt-5.4-mini`. Never commit, publish, place in JavaScript or paste either key into project documentation. The complete approved Legend release is live through source commit `cd5b430` (latest theme-code commit `d9b9ffc`) as of 2026-07-16.
- Legend receives a bounded snapshot of the current page (title, description, navigation, main content and footer) and recent in-panel conversation. The server supplies Fenster-specific identity, tone, accuracy, privacy and safety instructions; treats page text as untrusted reference material; validates the WordPress nonce and same-site request; rate-limits anonymous clients; and sends OpenAI requests with `store: false`. Prompts and responses are not written to theme logs.
- Visible `.fg-team-person` profiles are promoted into high-priority current-page facts. The backend also injects a query-matched excerpt from the current page around the first meaningful question term. Keep both mechanisms: the rendered Zac Bartley profile is created by the team template and is not represented accurately by the older imported source record, so generic related-page retrieval alone cannot be trusted for staff-name questions.
- `fenster_legend_verified_direct_reply()` is the final safeguard for common Zac Bartley identity and role questions. It returns the owner-approved Marketing Executive remit before calling OpenAI, so model variation or missing browser context cannot make the answer uncertain. Keep verified direct replies narrow and owner-approved.
- `fenster_legend_normalise_reply_link()` enforces consistent useful links after the model responds. It converts full Fenster test/live Markdown URLs to relative routes, preserves at most one useful route and automatically links the first known bold product recommendation. This prevents production replies pointing at test and avoids relying on the model to format every recommendation consistently.
- When a visitor asks a factual Fenster question, Legend's backend first supplies owner-confirmed business facts and query-matched canonical `product_usps`, then searches a bounded local index of other published theme/WordPress pages and supplies up to four relevant excerpts if matches exist. Verified facts outrank imported FAQs, articles and generic copy. This is same-site retrieval, not open-web browsing. The chat renderer supports `**bold**` through safe DOM text/`strong` nodes only; all other model output remains inert text.
- Legend remains focused on Fenster, but normal social interaction is deliberately allowed. Greetings, thanks, goodbyes, meows, purrs, harmless cat jokes and questions about Legend should receive a friendly in-character answer rather than the unrelated-request redirect. The verified context identifies the real Legend as Fenster's black office cat and Chief Meow Officer and Nick Baker, Sales Director, as his dad. Substantive unrelated tasks such as programming and homework are still declined, while server-side conversation and response filtering redacts common profanity before it can reach or be repeated by the model.
- Legend's composer is protected by an explicit acknowledgement covering AI processing, possible inaccuracies, non-binding replies, sensitive-data caution and 24-hour same-browser history, with a direct Privacy Policy link. After acknowledgement, `fenster_legend_chat_v1` stores up to 16 recent messages and synchronises them across Fenster pages and tabs; Clear chat removes the history. This is deliberately separate from analytics/marketing-cookie consent: using the chat never changes `fenster_cookie_consent`, and a rejected choice must remain rejected.
- Legend's launcher prompt is a valid sibling-control component: it stays invisible until 240px of page scroll, with window, document, touch and `visualViewport` listeners covering iOS scrolling. Its copy opens chat and its integrated close button dismisses it for the browser session. The transparent positioning wrapper must remain non-interactive; only the visible launcher and prompt receive pointer input. `legend-sleep-strip.webp` is a separate eight-frame transparent strip generated from the approved Legend pet. The drawer X returns him home in idle, waits 10 seconds and then plays the sleep sequence; 20 seconds without Legend interaction also sleeps him; interaction reverses the strip and wakes him. Keep the sleep asset separate from the validated 8x11 app atlas.
- Cookie settings is deliberately a footer control, not a persistent viewport button. It reopens the consent modal. **Analytics and marketing are separate and are ON from the first paint until the visitor refuses** (granted-by-default, restored by the owner on 2026-08-12 after one day of consent-first; this line said the opposite until 2026-08-26), remembered for 180 days once a real choice is made and removable again from the same footer control — and turning analytics off now erases what was already collected rather than only stopping future collection. The modal appears on a first visit but does not block, and is not shown to crawlers at all. Use necessary only remains inside Customise. Do not reintroduce the floating `.fg-cookie-settings` control, and do not let Legend hide, close or alter the modal.
- Legend persists whether the drawer is open and whether the visitor has sent a message in `fenster_legend_chat_v1`. Same-site links therefore restore the drawer immediately without replaying the entrance animation, while an explicit close stores the closed state. The full pre-use disclosure hides after the first sent message, but the compact accuracy, QA-retention, sensitive-data and Privacy Policy notice remains. The panel carries `data-lenis-prevent`; the transcript uses native contained wheel/touch scrolling and always returns to the newest message when opened or restored.
- The drawer header is intentionally one continuous deep-teal surface. `.legend-assistant__stage` adds only a soft mint floor glow and line, not a separate background block. Preserve the `224px` desktop and `190px` mobile stage widths plus their current roam distances so standing, running and curled sleep frames remain contained.
- Residential case studies are LIVE (2026-07-17). `/case-studies/` is a curated, data-driven system: add a study in `inc/case-studies-data.php` and it generates its archive card, detail page, routing, SEO and sitemap entry. See `CASESTUDIES.md` for the full guide. The retired scrape-era residential routes (`double-glazing-rushden`, `water-stratford`, `bespoke-windows-woburn-water-end-barn`, `test`, `template-new`) still return 410. Commercial project records under `/commercial-projects/` remain on the separate legacy pages.json system.
- The current shared product-page redesign is deployed on live. Product pages now use a clearer image-and-copy flow, visible `Product information` cards, `More information on [product]` hubs, full-width specification check cards, FAQ-only accordions, a standalone `/handle-options/` hub, and an in-page product-gallery lightbox. The old survey summary, common choices strip, quote option card, accreditations/systems filler block and inline handle chooser should stay removed.
- The mobile nav touch-layer fix is deployed on live. At `860px` and below, the open fixed header/nav owns the full viewport so page hero content cannot intercept taps on menu rows.
- Commercial hub v2 is deployed on live. The main commercial page was simplified and rebuilt for clearer lead generation: project proof now uses commercial-project imagery, the product/services imagery was corrected from theme assets rather than scrape-reference paths, the useless tiny parallax motion was removed, the "where this fits" section was made more practical, and the commercial form area was restyled so inputs are visible and the copy is not oversized.
- Performance baseline was improved on live without degrading the premium visuals. Heavy media and quote iframes are deferred: the homepage hero video waits for idle, quote iframes load near viewport or on click, product theatre media avoids eager-loading everything, and quote-tool pages keep a usable placeholder/action state until the iframe loads. Future performance work should continue this approach before compressing/removing signature visuals.
- A Lighthouse-focused performance pass has added critical first-viewport CSS, async activation of the main stylesheet, WOFF2 Gibson fonts, Regular/SemiBold font preloads, a homepage hero-poster preload, image dimension helpers, and mobile/constrained-connection interaction gating for the homepage hero video. The mobile/slow-network first impression should be the lightweight poster, not the 9.36 MB video download.
- `/cat-and-dog-flaps/` has a route-specific generated-page override because the imported scrape title/copy was poor. Keep the clean title/SEO in `inc\generated-pages.php`, the pet-flap product copy in `inc\site-data.php`, the fitting-route detail in `inc\product-hub-data.php`, and the custom pet-flap guide/suppressed generic product-choice block in `template-parts\sections\generated-page.php`.
- `/fensa-approved-installers/` uses `template-parts\sections\fensa-approved.php`. It is a dedicated homeowner conversion page and must not fall back to imported article sections, which contain old designer, social, footer and link-fragment debris. Its accepted composition follows the image-led rhythm of `/why-trust-fenster/`: direct Fenster-to-customer hero copy, one purposeful FENSA assurance panel that says eligible work will receive a certificate, two alternating installation-image explanations and the two-column desktop shared form. Do not restore third-party-installer advice, repeated certificate proof, divider-heavy comparisons, process rails, dark list bands or generic card grids. Its route-owned metadata lives in `inc\generated-pages.php`.
- Server cleanup on 2026-07-06 removed the stale `/terms-conditions/` and `/aluminium-bifold-doors-northampton/` redirects, added the live `www` to apex redirect, and password-protected `test.fensterglazing.com` with Basic Auth (`fenster` / `Fenster`). Theme code owns the cookie consent modal in `inc\consent.php`. Analytics consent gates Clarity and the individual Website Tracker; marketing consent gates Meta Pixel, advertising tags and persisted ad click IDs. Google Tag Manager loads only where at least one optional category is granted and receives category-specific Google Consent Mode signals first. Clarity is loaded through the theme with project ID `xi7rk1pic8` and receives Consent API v2 granted/denied signals so consenting users keep multi-page session recordings. The live Clarity plugins were removed; do not reinstall them unless there is a deliberate tracking architecture change.
- Imported blog/guide articles use `template-parts\sections\generated-article.php`. The article CTA form now has article-specific styling through `fg-article-form`, fixing the previous white-on-white labels/input contrast problem shown on generated article pages.
- Microsoft Clarity is not the visual source of truth, but the accepted replay fix is now documented and live. SiteGround/WAF can return a host `403 - Forbidden` HTML page to browser-like bot/resource fetches, which made Clarity recordings look unstyled with huge graphics/images. To work around this, `inc\consent.php` fetches the live `main.css` after accepted cookie consent, injects it as `style#fenster-clarity-replay-css[data-clarity-unmask="true"]`, and only then loads Clarity. `inc\assets.php` also marks stylesheet/font/image resource links as `data-clarity-unmask="true"`. Keep this ordering and markup intact.
- Search Console launch baseline was reviewed on 2026-07-13 from exports ending 2026-07-10. New-site weekdays 2026-07-06 to 2026-07-10 were broadly flat versus old-site weekdays 2026-06-29 to 2026-07-03: 87 vs 86 clicks, 23,709 vs 23,362 impressions, about 0.37% CTR and average position improving about 24.7 -> 23.7. Treat this as a no-cliff baseline, not proof that Google has fully crawled/indexed the new site.
- Current SEO priority is to turn existing visibility into money-page and quote traffic. Fix SERP/first-screen intent first on `/french-casement-windows/` (3,614 impressions, position 3.52, 0.19% CTR) and `/what-are-double-glazed-glass-windows/` (17,884 impressions, 0.06% CTR), then strengthen `/double-glazing-milton-keynes/`, `/windows-milton-keynes/` and `/doors-milton-keynes/` with internal links from high-traffic guides, product-led sections, local proof/trust, pricing guidance and visualiser/instant quote CTAs. Recompare clean new-site weeks, especially 2026-07-06 to 2026-07-10 versus 2026-07-13 to 2026-07-17.
- The dedicated commercial product renderer for `/commercial-windows-and-doors/`, `/curtain-walling/`, `/louvre-vents/`, `/commercial-automation/` and `/healthcare-construction/` is **live** (commit `26f3b43`, confirmed on production 2026-07-20). It uses `inc\commercial-product-data.php` plus `template-parts\sections\commercial-product.php` and bypasses the generic generated product journey for those routes.
- **Composite Doors V2 is live** on `/composite-doors/`. It reached production unintentionally on 2026-07-18 (the route has no host gate, so it shipped with the theme). Reviewed on 2026-07-20 and kept; further work happens directly on live. See `COMPOSITE-DOOR-REDESIGN.md`.
- **The seven price-guide pages are live**: `/window-door-prices-milton-keynes/`, `/composite-door-prices/`, `/bifold-door-cost/`, `/sash-window-prices/`, `/double-glazing-cost/`, `/aluminium-window-prices/` and `/patio-french-door-prices/`. `fenster_price_guides_enabled()` in `inc\generated-pages.php` lists the live hosts; commit `68f38ae` added them while bundled into an unrelated SEO commit, so the pages went live with the approved `13e7f95` promotion. Reviewed on 2026-07-20 and kept live. Prices are checked WindowCAD figures — keep them accurate, since they are public and indexable.

## Current Goal Of The Site

Fenster Glazing is being rebuilt as a custom, code-driven WordPress theme. The site should feel polished, premium and practical for real customers, while preserving SEO coverage from the imported/generated pages.

The site is not meant to become an Elementor/ACF build unless the owner explicitly changes direction.

## Local Environment

- Site root: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public`
- Local URL: `http://fenster-glazing.local/`
- Active theme: `wp-content\themes\fenster`
- Main theme directory: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster`

Build command from the theme directory:

```powershell
npm.cmd run build
```

PHP lint:

```powershell
& 'C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe' -l '<changed php file>'
```

## SiteGround Launch Workflow

For the full operational runbook, read `LIVECHANGES.md` first. This section is a summary only.

Current server reality:

- SSH host: `ssh.fensterglazing.com`, port `18765`, user `u453-m73mh4m4wev2`.
- Repo cache on server: `~/repos/FensterGlazing-NewSite`.
- Test root: `~/www/test.fensterglazing.com/public_html`.
- Live root: `~/www/fensterglazing.com/public_html`.
- Bedrock theme folder on both: `web/app/themes/fenster`.
- Search Console ownership token on live: `web/googleadc94090a74b9054.html`. It is not in the repo, because the repo tracks the theme and docs, not the Bedrock root. See `LIVECHANGES.md` "What Not To Touch".

Accepted deploy model:

1. Make code changes locally in `C:\Users\zacpl\Local Sites\fenster-glazing`.
2. Run the relevant build/lint checks.
3. Commit and push to GitHub.
4. Pull/reset the server repo cache to GitHub `main`.
5. Rsync only `app/public/wp-content/themes/fenster/` into the test Bedrock theme folder.
6. Verify test visually and technically.
7. Before live, take a fresh SiteGround backup and get explicit owner approval.
8. Rsync the same theme folder into the live Bedrock theme folder, activate/keep `fenster`, clear cache, and verify key routes/forms.

For future live changes, use the same route. Do not edit live files directly except for a genuine emergency, and if that happens, copy the emergency fix back into GitHub immediately.

The owner requires every completed change to go to the password-protected test site first. GitHub remains the source of truth: build and lint locally, commit, push, deploy the committed theme to test with the theme-only rsync, flush cache, and verify the changed route. Do not deploy directly to live, including for small or low-risk edits, unless the owner explicitly overrides this rule for the current task.

## Main Theme Map

- `style.css` — WordPress theme metadata.
- `functions.php` — theme bootstrap.
- `inc\assets.php` — asset registration, generated asset helpers and video asset URLs.
- `inc\generated-pages.php` — generated/virtual page routing.
- `inc\site-data.php` — shared navigation, product data, brand data and USP data.
- `inc\enquiries.php` — enquiry post type and form handling.
- `template-parts\sections\generated-page.php` — main generated page/product/location template.
- `template-parts\sections\home-experience.php` — homepage template.
- `template-parts\components\enquiry-form.php` — one shared live form.
- `template-parts\layout\site-header.php` — header/navigation.
- `template-parts\layout\site-footer.php` — footer.
- `src\scss\main.scss` — source styling.
- `src\js\main.js` — source interactions.
- `assets\css\main.css` — compiled CSS.
- `assets\js\main.js` — compiled JS.
- `data\pages.json` — imported/generated page data.

## Architecture Principles

- The site is code-driven and hardcoded through the theme.
- Shared data belongs in `inc\site-data.php`.
- Generated content comes from `data\pages.json` plus explicit virtual routes.
- Shared UI should be implemented once and reused.
- Visual work must follow `STYLE.md`, especially the continuous page background rule.
- Mobile and desktop must be designed together.
- Desktop-only cinematic effects need mobile/reduced-motion fallbacks.
- **Scroll-drift is a shared controller, not a per-page script.** Put `data-fg-depth="0.04"`–`0.15` on a container and `transform: translateY(var(--fg-parallax-y))` on the child that should move; `src\js\main.js` writes the variable, already clamps to one viewport, and is deliberately not gated on an IntersectionObserver, which is what broke a hand-rolled parallax on 2026-07-29. It has **no reduced-motion check of its own**, so every consumer needs its own `@media (prefers-reduced-motion: reduce) { transform: none; }`. Never write a second parallax.
- **A page-namespaced element selector outranks a bare class.** `.fg-cas p` is `(0,1,1)` and sets a font size, a margin and a max-width, so a new `.fg-cas-thing` inside it silently loses all three. Qualify new typographic rules with the namespace. The same applies to any element also carrying `.container`: use `margin-top`/`margin-bottom` longhands, because a `margin` shorthand resets the auto margin that centres it.
- Product + location generated routes use the central matrix in `inc\generated-pages.php`: 13 towns x 21 sensible residential products. They render through `template-parts\sections\location-service.php` with product/location-specific copy and a hero enquiry form. Keep these pages on that shared template rather than reviving scraped per-page layouts.

## Current Navigation

Navigation data is centralised in `inc\site-data.php`.

Desktop and mobile navigation should share the same source data so links do not drift.

Top-level navigation currently covers:

- Products
- Commercial
- About Us
- Contact
- Instant Quote

Mobile navigation activates at `860px` and below. Future work should keep the mobile header, mobile navigation, CSS replacements and JavaScript breakpoint logic aligned at `860px`.

When the mobile menu is open, `.site-header.is-nav-open` should own the viewport and `.site-nav` should sit above page content. If menu rows stop responding to taps, check for hero/content layers intercepting the touch target before changing the navigation data.

## Generated Pages And Routing

Generated pages are driven by `data\pages.json`.

Important runtime pieces:

- `inc\generated-pages.php`
- `template-parts\sections\generated-page.php`

Generated pages preserve SEO coverage while applying the new shared visual template. Related links are context-aware and route-checked; do not restore scraped footer/legal/promo links into related-link panels.

Imported SEO data is filtered before rendering. The head output should not include old designer-tool schema, `test.fensterglazing.com` JSON-LD, placeholder OpenGraph values such as `0`/`1`, raw JSON blobs in social tags or inherited alias-page social URLs.

Structured data is generated, not imported: a site-wide LocalBusiness block from `fenster_render_site_schema()` and per-product `FAQPage` JSON-LD in the product journey template. Imported `schema_json_ld` is never rendered.

Debris routes are handled centrally in `inc\generated-pages.php`: test pages return 410, duplicate town slugs and all `*-designer` pages 301 to their real targets, and ad landers, thin utility/scrape shells, `category/`, `tag/`, `author/` and `blog/page/` archives carry `noindex,follow`. The custom sitemap at `/sitemap.xml` (advertised in robots.txt; core `wp-sitemap.xml` is disabled) skips all of those routes.

Imported blog posts and guides render through `template-parts\sections\generated-article.php` (readable article layout with a compact enquiry CTA). Product/commercial routing uses explicit slug whitelists in `template-parts\sections\generated-page.php`, not slug-substring matching.

Virtual or explicitly exposed product routes include products such as:

- `/aluminium-flush-windows/`
- `/aluminium-sliding-doors/`
- `/slide-fold-doors/`
- `/heritage-aluminium-doors/` (dedicated template, see below)

### Heritage Aluminium Doors Page

Route: `/heritage-aluminium-doors/`

Template: `template-parts\sections\heritage-aluminium-doors.php`, dispatched from `template-parts\sections\generated-page.php`.

Current accepted behaviour:

- The page is built around the Sheerline Classic Heritage Door and bypasses the generic product journey, in the same way `/roof-lanterns/` does.
- Section order is hero, four-fact specification strip, the six stocked configurations, period lockbox and glazing-bar detail, Thermlock and corner construction, two use cases, the Secured by Design upgrade, the twelve standard colours, shared enquiry form, review showcase.
- Assets are local WebP copies under `assets\images\products\heritage-aluminium`. Do not point this route at the Sheerline scrape export.
- The configuration renders were cropped through one shared window so their relative heights stay honest; do not re-trim them individually. Six are shown as of 2026-07-24, single and French with no bars, 2 bar and 4 bar. The three toplight renders were removed on owner instruction; the assets remain on disk.
- Configuration labels state real bar counts and colours. Check any new label against its render before publishing.
- The route has its own `heritage_aluminium_doors` gallery pool in `inc\site-data.php`. Do not point it back at the shared `aluminium_doors` pool: that pool is modern Prestige entrance doors and put uPVC-looking imagery on this page and its town variants.
- Secured by Design is an optional upgrade on this system, not the standard specification. Keep that distinction in the copy.
- Colour is twelve standard powder-coated finishes, with dual and bespoke colours available on request. Do not restore the blanket `Any RAL colour` claim here.
- The enquiry form sits on a light panel and shares the `.fg-roof-lantern-form` contrast rules through `.fg-heritage-door-form`. If those rules are refactored, keep both classes covered or the inputs render white on white.

Utility and special routes:

- `/terms-conditions/` is a hardcoded virtual utility page in `inc\generated-pages.php` and renders through the generated simple utility layout.
- `/why-trust-fenster/` is a hardcoded virtual trust page in `inc\generated-pages.php`. It renders through `template-parts\sections\trust-page.php`, reuses the shared review showcase and is promoted by a small centred link beneath the homepage trust cards.
- `/obscured-glass/` is a hardcoded virtual product-adjacent page in `inc\generated-pages.php`. It is intentionally not in the menu; product journey pages link to it from the `Gallery and choices` / finish options card.
- `/obscure-glass/` 301 redirects to `/obscured-glass/`; use "obscured glass" in visible copy, while the legacy asset/data key and folder remain `obscure_glass` / `assets\images\products\obscure-glass`.
- `/colour-options/` is the canonical hardcoded virtual colour hub in `inc\generated-pages.php`. `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/` to avoid duplicate content; the material sections remain as anchors/sections inside the colour hub.
- `/commercial-glazing-buckinghamshire/` is a hardcoded virtual commercial page in `inc\generated-pages.php`.
- `/commercial-projects/` is a hardcoded virtual commercial page in `inc\generated-pages.php`.
- `/privacy-policy/` and `/cookie-policy/` come from generated/imported page data and render through the generated simple utility layout.
- `/areas-we-cover/` is a customer-facing local coverage page. It is not linked from the header menu; the About page and footer link to it. It groups generated area routes by town for customers who want to check local services.
- `/wcad-thank-you/` has been removed from `data\pages.json` and excluded from the custom sitemap. Do not restore it unless a fresh thank-you journey is explicitly requested.

## Product Page Template

Most residential product pages use `template-parts\sections\generated-page.php`.

Current product page model:

- Hero with primary CTA linking to the enquiry form and secondary CTA linking to the in-page instant quote embed when a product collection exists.
- Four-tile `Key specifications` strip using `inc\site-data.php` product USP data.
- Visible `Product information` benefit cards headed by the product name; product pages should not use accordions outside FAQ.
- Manufacturer/product hub badges, system data and visible full-width specification check cards from `inc\product-hub-data.php`.
- Product body imagery should not repeat the hero image. The template uses a unique image queue and skips later image blocks if there are not enough distinct product images.
- **The three product-selector hubs are `/windows-milton-keynes/`, `/doors-milton-keynes/` and `/other-services/`**, sharing `template-parts\sections\product-hub.php` and driven by `product_hub_groups` in `inc\site-data.php` (2026-07-24). They show the whole range as a grid of real product photographs, read from `product_media[slug].hero` so a hub card and its product page cannot disagree. `/other-services/` was previously in the utility-page list and rendered as a scrape shell with a "Discover our other services" meta; it now has theme-owned SEO and an H1 naming the actual services. The retired `windows-hub.php` tab selector, its JavaScript controller and its SCSS are deleted.
- Curated product image pools now stay product/material specific in `inc\site-data.php`: uPVC doors, composite doors, patio doors, French doors, aluminium doors, aluminium bifolds and aluminium sliders each have separate pools instead of sharing one mixed entrance-door or wide-span gallery.
- The window routes were split the same way on 2026-07-24. `casement_windows`, `flush_casement_windows`, `french_casement_windows`, `tilt_turn_windows` and `bow_bay_windows` are separate pools; before that, all five shared `upvc_windows` and rendered the same thirteen images as each other. `upvc_windows` is now the mixed pool for `/double-glazing/` only. `aluminium_sliding_doors` was rebuilt on Sheerline Prestige Lift & Slide photography. New assets live under `assets\images\products\{casement,flush-casement,french-casement,tilt-turn,bow-bay,aluminium-sliding}`.
- Location/service matrix pages rendered through `template-parts\sections\location-service.php` reuse those same curated product media pools and skip the hero image for supporting image slots, so town variants such as `/upvc-doors-milton-keynes/` do not fall back to unrelated scraped aluminium/composite imagery.
- Product galleries open an in-page lightbox, not a raw image URL or new tab. The lightbox uses a dark overlay, no visible alt/caption text, no white image card, close/backdrop/Escape handling, previous/next arrows and keyboard left/right navigation.
- Optional product-specific WindowCAD quote embed placed after the main product journey/trust content.
- Product narrative/content sections from generated data.
- A compact `Specification choices` section linking to focused colour, privacy-glass and hardware decisions, including the standalone `/handle-options/` hub where relevant.
- Shared enquiry form.
- Context-aware related products/service areas.

Older mobile QA notes from the first phone review were superseded by the later live redesign through `3ac98c2`:

- `/casement-windows/` no longer uses "Why choose this product" wording; the section is now `Product information`.
- Product hub logos such as Liniar and Energy Plus should stay visually balanced against proof/spec cards.
- The old common-choice/product-view control section has been removed from the shared product template.
- Product-view controls were not intuitive enough when there were more than two options. The product hub has since moved away from spec tabs to visible specification check cards.

The old product-page mini-gallery above the colour choices has been removed. It was fed by imported `images` arrays from `data\pages.json`, including old copied stock uploads such as `stock-04.jpg` and `stock-05.jpg`. Product pages should not revive that scraped gallery rail; use curated hero/feature media and the specification hubs instead.

Product USP rules:

- Data lives in `inc\site-data.php` under `product_usps`.
- Curated visible copy/FAQ overrides live in `inc\site-data.php` under `product_content`.
- Do not invent U-values or unsupported specifications.
- Composite Doors and Integral Blinds currently do not display invented U-values.
- Integral Blinds controls are `Magnetic or electric`.
- Generated product FAQs should skip scraped designer, brochure, FAQ-intro, footer, social and area-list debris before rendering.

### Product Quote Embeds

Product-specific WindowCAD quote embeds are mapped in:

`template-parts\sections\generated-page.php`

The embed section id is:

`#fenster-product-quote`

Current accepted behaviour:

- Product-page instant quote links jump to the in-page embed when a matching `productCollection` exists.
- The embed sits after the main product journey and trust sections, so scroll-following product video sections are not disturbed.
- The embed is intentionally compact, not a full-height page takeover.
- Product embed iframes auto-load on page load.
- Desktop quote cards include `Expand view` and `Open in new tab` controls.
- Mobile quote cards hide those desktop controls and show one same-tab `Open quote tool` action.
- The iframe wrapper uses `data-lenis-prevent` so users can interact with the embedded quote tool while Lenis/smooth scrolling is enabled.

Mapped product collections include:

- Composite Doors
- uPVC Windows
- Sash Windows
- Aluminium Windows
- uPVC Doors
- uPVC French Doors
- uPVC Sliding Patio Doors
- Aluminium Bifolding Doors
- Aluminium Sliding Patio Doors
- Heritage Aluminium Doors
- Aluminium Doors
- Slide & Fold Doors
- Replacement Glazed Units
- Secondary Glazing

### Window Handle Hub

Window handle information is shared data in:

`inc\site-data.php`

The standalone hub renders from:

`template-parts\sections\generated-page.php`

Route:

`/handle-options/`

Current accepted behaviour:

- Product pages no longer render the full window-handle chooser inline. Selected window routes link to `/handle-options/` from the `Specification choices` card grid.
- Tilt & Turn Windows is intentionally excluded.
- Uses supplied S2 finish images from `assets\images\products\handles`.
- Includes an interactive finish selector for White, Black, Chrome, Gold, Satin Silver and Monkey Tail.
- Includes three feature tiles: Push-to-release, Lockable as standard and Finishes are coordinated.
- Includes one static technical specification card.
- No handle accordion is used.
- Egress conversion, spindle length and retrofit-ready content have been removed.

### Sliding Sash / Roseview Page

Route: `/sliding-sash-windows/`

Current accepted behaviour:

- The page is Roseview-led, not Liniar-led.
- `inc\product-hub-data.php` maps the product hub system to Roseview with the local logo `assets\partners\roseview-logo-new.png`; the old inherited Liniar badge should not render on this route.
- Dedicated Roseview comparison content lives in `template-parts\sections\generated-page.php` for Ultimate Rose, Heritage Rose and Charisma Rose.
- Roseview model/detail assets live under `assets\images\products\sash-roseview`.
- The page includes model cards, aligned `Best for` boxes, a comparison table, meeting-rail detail and mechanical/welded-joint detail.
- The joint media panel stretches to match the copy card height on desktop.
- The generic S2 window handle section is intentionally removed from this page.
- Sash furniture renders from `inc\site-data.php` under `sash_furniture`: Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, Shark Fin Limit Stop and D Handle extras, plus the Roseview under/over 700mm furniture-count rule.
- Runtime assets are local theme copies from the Roseview scrape. Do not reference the scrape export or `wp-content\fenster-reference` for this page.
- Mobile QA: the top of the page is acceptable. Commit `c21bd46` tightened the Roseview model stats/cards for Ultimate Rose, Heritage Rose and Charisma Rose, corner/detail sections, comparison rows and large detail images for phone layouts. Continue to real-phone regression check this page because it is image-heavy.
- At `860px` and below, the three Roseview model cards use a single-card swipe carousel with previous/next controls, position dots and a visible model counter. The desktop three-card grid remains unchanged.
- The desktop comparison table remains unchanged. Mobile replaces it with a selected-model specification panel that updates with the carousel and shows meeting rail, corner detail, frame depth, glass unit, energy rating and ThermoVFlex information in a compact two-column grid. Do not restore the old mobile pattern that stacked every table row and repeated all three model values down the page.
- The accepted mobile sash journey is deliberately shorter than desktop. At `860px` and below, hide the repeated sash detail run, generic Product information cards, generic More information checks, order-process rail and final related-link band. Their useful model facts are already covered by the selector and its selected-model specifications.
- Mobile colour/glass choices and sash furniture are compact horizontal decision rails. Furniture cards show one representative product object instead of all ten images at once; desktop retains the complete three-range furniture presentation.

Recent verification:

- PHP lint passed for `inc\site-data.php`, `inc\product-hub-data.php` and `template-parts\sections\generated-page.php`.
- `npm.cmd run build` passed after the Sass changes.
- Rendered checks confirmed the Roseview logo loads, Liniar is not visible, all 10 sash furniture images load after lazy scroll, the three furniture cards align on desktop, and the new sash furniture section does not cause mobile overflow.

### Obscured glass Page

Route: `/obscured-glass/`

Current accepted behaviour:

- The page is hidden from the main navigation.
- Product journey pages link to it from the `Gallery and choices` / finish options area.
- Obscured glass data lives in `inc\site-data.php` under `obscure_glass`.
- Texture assets live under `assets\images\products\obscure-glass`.
- Cotswold is the default preview and uses the downloaded Pilkington source texture at `assets\images\products\obscure-glass\Cotswold-pilkington.png`.
- The visualiser can switch between the colour Legend photo at `assets\team\legend-colour.webp` and the house background at `assets\images\products\obscure-glass\birkacre-house.webp`.
- The accepted preview model is a split comparison: the left side shows the selected Obscured glass treatment and the right side keeps a clear reference view.
- The split is controlled by a draggable range slider, not mouse-follow movement.
- The glass treatment should follow the Pilkington-style layer model: a blurred/brightened duplicate of the current scene, with the texture pattern as a separate unblurred layer above it. Do not blur the texture layer itself or it turns into glow.
- Mobile uses the same texture data with tappable horizontal glass controls, no hover dependency, and touch rules that allow normal vertical page scrolling through the visualiser.

### Integral Blinds Page

Route: `/integral-blinds/`, rendered through `generated-page.php`.

Current accepted behaviour:

- The page carries an interactive **Notan magnetic blind visualiser**, gated on the route in `generated-page.php` and rendered from `template-parts\components\blinds-visualiser.php`. It sits directly after the why section, on the same reasoning as the obscured glass visualiser: the page has just explained that the blind is sealed inside the glass and cannot be touched, so the next thing to do is let the customer work it. Everything below it is specification and process, which reads better once the product is understood.
- The unit is **face on and fully straight**, which the owner asked for explicitly on 2026-08-03. Do not reintroduce a perspective or angled view.
- **The controls are the two magnets on the unit itself, not sliders beside a picture of it.** The owner corrected this on 2026-08-03: on a Notan magnetic unit the two magnets run on a slim rail sealed inside the glass, the upper one tilting the slats and the lower one raising and lowering the blind. They are drawn near the right of the glass and dragged there. Do not move them back out to page furniture.
- **The unit is built from the owner's photograph of the showroom sample**, supplied 2026-08-04 and the reference for the scale and shape of both the frame and the controls. Check it before changing either.
  - The frame is **anthracite uPVC drawn as a section**: outer face, shadow groove, sash face, second groove, then a bead curving to the glass, every band mitred at forty five degrees. Woodgrain runs **along the length of each profile**, so the head and cill are grained horizontally and the jambs vertically. Graining the whole frame both ways produces a crosshatch that reads as woven fabric.
  - The cassette is **about 50mm on the head and both sides**, and is **colour matched to the slats**, not to the window. It is drawn a shade off the slat colour deliberately: an extrusion beside a rolled slat in the same paint still reads as a different material, and matched exactly the frame and a closed blind merge into one slab. For the same reason there is no separate head rail band any more.
  - The magnets sit **alongside** the slim rail at the inner edge of the frame, near edge against its far edge, on the frame side. The rail is a **guide, not a seat**: centring them on it puts them half over the clear, and putting them in the middle of the member is wrong too.
  - They are **about one to three, and matte**. A hard specular sheet reads as polished plastic; the references show a soft, almost even face falling away to a darker edge each side. The rail is read by the highlight along its clear-side edge, since it is cut into a member of its own colour.
  - The **window frame is deliberately slimmer than the showroom sample** it was drawn from. At the sample's full section plus a 50mm cassette, the two borders together swallowed the glass. The window is the surround; the blind unit is the subject.
  - The blind's framework is a **cassette on the two sides and the head, with nothing across the bottom**. The bottom rail comes to rest straight on the edge of the glass, with only the warm edge spacer and the cill under it. Do not close the U. An earlier pass drew a 24mm profile right round the inside of the glass, which was wrong in both extent and width.
  - The magnets run on the **right hand cassette member** and are wider than it, overhanging onto the glass.
  - The **head rail takes the slat colour**, because it belongs to the blind rather than to the cassette. The cassette itself stays matched to the window frame.
  - The hardware inside the glass is matched to the **window frame**, not to the slats. The reference shows anthracite hardware against silver slats.
  - **The two magnets are not the same size.** The lift one is about half as long again as the tilt one, and both are wider than the angled photographs suggest: a steep angle foreshortens width and not length.
  - **The blind gathers on its own bottom rail as it rises**, so the stack sits at the foot of the drop with the hanging slats above it and the whole group travels up. It is not a band under the head. The bottom rail is drawn outside the slat branch because it is still there when every slat is in the stack.
  - The magnets are **blocks at about one to one point eight**, glossy black with one hard specular sheet, a flat top face catching a glint and crisp turned edges. They were slim capsules at one to three and a half and read as pins. Reading dark, light, dark straight across the width makes them look cylindrical; the face wants to be broad and even with one turned edge near the right.
- `magnetTracks()` is the single source of both where a magnet is drawn and where it can be grabbed. Keep it that way; a magnet drawn somewhere it cannot be grabbed is the obvious way for this to break.
- **`layout()` must stay free of side effects.** The pointer handling calls it on every move to hit-test the magnets. It used to size the backing store too, and assigning to `canvas.width` clears the canvas even when the value has not changed, so moving the mouse across the unit wiped it to black and it stayed black because nothing is scheduled once the easing has settled. The resize belongs in `draw()`, guarded on the store actually being a different size.
- Tilt runs closed, open, closed across the magnet's travel: `0` and `100` are both fully closed and `50` is edge on, which is the real travel and shows that the blind closes both ways. Rotation is capped at 78 degrees because real tilt mechanisms stop short of 90 and because the slats have already overlapped well before then, so the last stretch would be a dead zone.
- **Lift is inverted, on the owner's instruction of 2026-08-04:** the magnet at the top of its travel is the blind **down and closed**, and pulling it down is what **raises the blind open**. That is how the geared magnet runs. Do not "correct" it to match the blind's direction of travel.
- The two travels are deliberately separated, the tilt one shorter and higher, and the vertical hit padding is tight. Left as they were, the hit areas abutted and the two magnets looked bunched together at rest.
- Two `input type="range"` controls remain in the markup, moved **off screen rather than hidden**, and the controller mirrors them to the magnets in both directions. They are what makes the visualiser operable by keyboard and legible to a screen reader; `display: none` or `visibility: hidden` would drop them out of the tab order and leave it working by pointer alone. Focus on one of them draws a ring round the matching magnet.
- **Shading inside the unit is relative to the colour, not an absolute ratio.** `floor()` in the renderer raises the darkest a shading step may go in proportion to how light the finish is. Without it the rail and the magnets look grey rather than white on the light finishes: the same ratio applied to a much larger number is a much larger drop. The magnet is also close to the frame colour rather than painted towards black; it is the same material and its form comes from the gradient.
- **The ladder cords belong to the blind and come up with it**, running only from the foot of the stack to the bottom rail. Drawn full height they stay put, which leaves a pair of wires hanging over clear glass once the blind is raised.
- **The readout names the colour and nothing else.** The owner removed the tilt and lift commentary on 2026-08-04: the magnets show their own positions, and the two range inputs announce their values to a screen reader already, so it duplicated both. Do not put it back.
- **Touch is handled by two grab elements over the magnets, and this is not decoration.** The stage stays `touch-action: pan-y` so the page scrolls when a thumb lands on the glass, and only the two grabs carry `touch-action: none`. Switching the canvas to `none` on `pointerdown` does **not** work and was the cause of dragging pulling the whole page on mobile: by the time the handler runs, the browser has already committed the touch to a scroll. The grabs are padded to 46x56 so they clear the 44px target, and `placeGrabs()` keeps them on the drawn magnets. Do not go back to hit-testing the canvas.
- The blind is **drawn, not photographed**. Nine colours against a continuous tilt and a continuous lift is far past what a sprite sheet can hold. See the Three.js / Canvas Rule in `AI.md`: this is 2D canvas with no library and is a deliberate exception, not a breach.
- Colour data lives in `inc\site-data.php` under `notan_blind_colours`. See the Notan Integral Blind Rule in `AI.md` before changing any of it, in particular before "fixing" Cream or Rose Gold.
- Slats carry a deterministic per-slat wobble in position, brightness and about a fifth of a degree of lean. It is not decoration. Without it fifty perfectly level slats read as a printed rule rather than as a blind, which was the single biggest thing separating the render from a photograph.
- The bright edge on each slat **thins the slat rather than painting over it**, so the scene tints it: sky coloured at the head of the pane, green down where the lawn is. It also falls away as the slat colour lightens, because a white slat is already as bright as the sky behind it. Left flat, it blew White, Cream and Metallic Silver out until all three read as the same pale wash.
- Costs are cached rather than spent per frame. The garden, the veiling glare, the glass overlay and the aluminium frame rebuild only on resize; the slat tile rebuilds only when tilt, colour or size change; the grain waits for the settled frame. Measured at 6.0ms a frame with the GPU disabled, against 9.2ms before the caches were added.
- The controller adds `is-live` only once it has a context and a first frame. Until then the real Notan close-up photograph is what shows, so a thrown error degrades to a photograph rather than to a black box. A `<noscript>` block would not have covered that case.
- Off-screen the animation loop stops, `prefers-reduced-motion` snaps instead of easing but stays fully interactive, and the stage sets `touch-action: pan-y` so a thumb landing on it still scrolls the page, the same rule the obscured glass visualiser follows.
- The view behind the glass is generated, not a project photograph. At the blur a camera exposed for the room would give it, almost nothing photographic survives except the colour distribution and the large scale light and shade, so it is built from a sky, a treeline, a lawn and dapple. The renderer takes an optional scene image if a real view is ever preferred.
- No slat dimension is stated anywhere on the page. Notan do not publish one.
- **Per-slat variation is deliberately small: position and brightness at `0.04`, lean at `0.00105`.** It exists because fifty perfectly level slats read as a printed rule. It was four times stronger and the blind read as damaged rather than hung; the owner asked for roughly seventy five per cent more consistency. Change all three together, or reducing one only shifts which cue reads as the defect.
- **Metallic Silver and Rose Gold carry `glitter`.** They are flake finishes on the real slats. The canvas widens its tile to 480 for them, because a fleck drawn on the usual 96 stretches into a scratch, and the flecks are deterministic so they do not crawl while a slider moves. The swatches use an inline SVG of thresholded turbulence; tiled gradients lattice into a weave.
- **The `Frame colours` card elsewhere on the site takes its six dots from `colour_options` by name**, not from the stylesheet. See the Swatch Provenance Rule in `AI.md`. This route renders no colour card at all.
- **Every photograph in the `integral_blinds` pool has to show a blind.** Three of the five were a plain sliding door, a plain bifold and a sealed unit sample, so the page illustrated integral blinds mostly with doors. If a shot does not show slats, it does not belong in the pool.
- **The slat colours lay out on the page**, via `template-parts/components/blind-colour-grid.php`, sharing the `.fg-upvc-colours` / `.fg-alu-colours` styles so this route does not look like a different kind of page. Because the grid is inline, the route renders **no colour card at all** in Specification choices: frame colour is not a decision here, and a card pointing at the hub duplicates the grid's own note, which is the same suppression the uPVC foil routes use. The privacy glass card stays, because that choice is real.
- **White/Anthracite is drawn as a split swatch** in the grid, on the hub tile and on the visualiser chip, so the second face is visible without working the blind. **The split is diagonal on the owner's instruction; Notan themselves draw it vertically**, in both their web swatch and their brochure, so this is house style rather than a match. Hard stop, not a blend: two painted faces, not a gradient.
- **The slat colours are on `/colour-options/` as their own section**, anchored `#integral-blind-colours`, built at render time from `notan_blind_colours` rather than copied into `colour_options`. Keep it derived: the hub and the visualiser must not be able to drift apart.
- **Instant pricing is off on this route** via `$offers_instant_price`. A blind unit is a sealed unit specification made to its host window or door, and the online tool prices windows and doors, so the button promised a number nobody could get. Both hero variants and the hero card are gated on the same list; add a slug there rather than deleting buttons, or they fall out of step.

### Aluminium Doors Page

Route: `/aluminium-doors/`

Template: `template-parts/sections/aluminium-doors-v2.php`, a bespoke **middle**
dispatched from `generated-page.php`, the same shape flush casement uses. Not an
early return. Styling is `.fg-alu-door` inside the shared `.fg-cw` grammar.

**On test since 2026-08-07, not on live.** Rebuilt because the route was running
the generic product journey and read like it: "Aluminium Doors" as the H1 and
then twice more as an H2, a hub band headed "More information on Aluminium
Doors", and a middle of copy written about no particular system.

Current accepted model:

- **Five sections, in the order the decision gets made in**: where it fits (it
  matches the windows), the InvisiHinge, Thermlock on a dark band, security as a
  card band, then the threshold. The security band is deliberately the one
  section with no photograph, so the page changes shape once in the middle
  instead of running five images down one rhythm.
- **The middle quotes no U-value.** See the Aluminium Doors Rule in `AI.md`; the
  figures are on the specification strip and the Thermlock banner directly above.
- **The InvisiHinge section carries two owner exclusions** — no fourth hinge, and
  nothing about installation. Both are recorded in `AI.md` under the InvisiHinge
  Rule and neither may return without asking.
- **`.fg-alu-door-band` and `.fg-alu-door-list` are added to the `.fg-flush-band`
  and `.fg-flush-list` selector lists** rather than given a copy of the
  component. Restyle one and you restyle both, which is deliberate.
- **`.fg-cw-media` is a 16/10 cover box and is wrong for every image on this
  route.** The usable photography is 4:3 at 600x450 and the InvisiHinge composite
  carries its callout circles hard against the top edge, so cover into 16/10
  clipped the upper circle off. `.fg-alu-door-media--4x3` and
  `--tech` match the box to the source instead. Crop the box to the picture.
- **The hero is still wrong and is still the owner's deferred decision.**
  `products/curated/sheerline-aluminium-door.jpg` is an interior kitchen shot of
  a white door that reads as uPVC, noted since 2026-07-21. Every correct
  replacement in the theme is 600x450 or smaller, which is too small for a
  full-bleed banner, so the 2026-07-29 decision to leave it stands. The rebuild
  did not touch it.
- **Exactly one photograph on the page is ours.** The opening section carries the
  owner's own install, supplied 2026-08-07 and confirmed by him as aluminium
  French doors with flush aluminium windows either side and integral blinds in
  the glass. It is captioned "Our install" and it is the only one that makes that
  claim. Everything else is supplier photography, so there is no "our work"
  gallery and no blanket claim over the imagery, which is the fault already
  recorded against the casement proof mosaic.
- **The case-study strip on this route is on its documented fallback**, showing
  two uPVC casement jobs and a bifold under "Real installs, photographed on the
  day", because no study claims `/aluminium-doors/`. Left alone rather than gated:
  the composite doors entry of 2026-07-22 records that this affects every product
  page without its own study and that the fix is site-wide, not per-route.

### Secondary Glazing Page

Route: `/secondary-glazing/`

Template: `template-parts/sections/secondary-glazing-v2.php`, a bespoke **middle**
dispatched from `generated-page.php`. Styling is `.fg-sg` inside the shared
`.fg-cw` grammar.

**On test since 2026-08-07, not on live.** Rebuilt from the ground up because the
route was running the generic product journey and had nothing of its own: the
product name as the H1 and twice more as an H2, a band headed "More information
on Secondary Glazing", and not one photograph of the product on the page.

Current accepted model:

- **Four sections, in the order the questions arrive in**: what it actually is,
  why people have it, whether you can still open the window behind it, then
  glass and colour. The USP leads and it is that you keep your own windows.
- **No key-specification strip.** This product publishes no numbers, so the
  strip was four facts with no measurement in them. `product_pulse` is gated
  off with `fg-product-why`, `fg-product-intel` and `fg-product-visuals`.
  `product_usps` is kept accurate for Legend. See the Secondary Glazing Rule in
  `AI.md` before adding any of it back.
- **The "can I still open my window" section is media-first on purpose.** It is
  the objection everybody arrives with and the photograph answers it before the
  copy does: one of our own installs with the original casement wide open behind
  the closed glazing.
- **The dispatch sits outside the specification-choices wrapper**, which is
  gated on `! $is_secondary_glazing_page`. Inside it the whole middle rendered
  nowhere. The repairs dispatch carries the same warning.
- **Every photograph is ours**, two from the owner and four from the Winslow
  case study, which the page links to. The old pool was four wrong-product
  images with dishonest alt text and is documented in `AI.md`.
- **Neither FENSA nor the CPA guarantee applies, and the rail claims neither.**
  Owner-confirmed 2026-08-07, along with `/roofline/`, `/integral-blinds/` and
  `/double-glazing-replacement/`, and with the rule behind it: FENSA eligibility
  and the CPA cover are linked, so a route outside one is outside the other. All
  four take the canonical steps with step 04 swapped for
  `order_process.aftercare_outside_fensa_and_cpa`. Secondary glazing alone also
  swaps step 02, since "thresholds" is a measurement it does not have.

### Aluminium Flush Windows Page

Route: `/aluminium-flush-windows/`

- **Bespoke middle** in `template-parts/sections/aluminium-flush-windows-v2.php`,
  dispatched on `$is_alu_flush_bespoke`, OUTSIDE the specification-choices
  wrapper like the other bespoke routes. The generic middle bands are gated off;
  the wrapper itself is KEPT, because the colour grid and handle grid inside it
  are real decisions on this product.
- **The page is about the flat face**, not about fixed lights. See the Aluminium
  Flush Windows Rule in `AI.md` before writing any copy for it.
- **The key-specification pulse is kept**, unlike secondary and replacement
  glazing, because this product has real numbers. Its heading is overridden here
  so it does not repeat the H1 — a fault shared by all 23 routes that render the
  strip, flagged and not yet fixed site-wide.
- **The comparison is Sheerline's own render, cropped hard on the sash edge.**
  At full frame the two renders are nearly identical. Do not widen that crop.
- **Twelve Prestige corner renders** live in
  `assets/images/products/colours/sheerline-prestige-flush/`. The colour grid
  takes a `corner_set` argument; `/aluminium-flush-windows/` and
  `/aluminium-windows/` pass `prestige-flush`, heritage and the door routes do
  not. Sheerline publish no Prestige STANDARD corner.
- **Our one install is atypical.** Its fixed panes are direct glazed rather than
  dummy sashes, so the openers stand proud. Never claim flushness from those
  photographs.

### Heritage Windows Page

Route: `/heritage-windows/`

- **Bespoke middle** in `template-parts/sections/heritage-windows-v2.php`,
  dispatched on `$is_heritage_bespoke`, OUTSIDE the specification-choices
  wrapper like every other bespoke route. The generic middle bands are gated
  off; the wrapper itself is KEPT, because the Classic colour grid and the S2
  handle grid inside it are real decisions on this product. The pulse and the
  instant-price button are kept too.
- **The product is the Sheerline Classic STEPPED sash**, and only that one of
  Sheerline's four aesthetics. Read the Heritage Windows Rule in `AI.md` before
  writing any copy for it, in particular before quoting a sightline.
- **NO CONFIGURATOR, deliberately.** An interactive bar planner was built here
  and the owner removed it: WindowCAD configures and prices in one place, so a
  drawn tool competes with the thing that converts. The dark section carries the
  three bar layouts as copy and hands over to the designer with a
  `Design and price it` button. Casement had the same call in August. Do not
  build a third.
- **No triple glazing on this route.** Owner-confirmed 2026-08-11: triple is
  available on the Classic contemporary sash and deliberately not offered on the
  stepped one, so Classic does not muddy against Prestige. The strip prints
  1.4 W/m²K plain, with no star and no lowest-achievable note.
- **The case-study strip is gated off.** It was briefly on when the Heal's study
  claimed the route, then off again when the owner ruled that commercial studies
  do not belong on residential product pages. It comes back when a RESIDENTIAL
  heritage window study exists.
- **One install of ours and one photograph of it**, in a split rather than a
  gallery, and the copy does not mention that it is the only one. A close crop
  of the same frame was pulled because the finishing on it is not good enough
  to publish. See the Heritage Windows Imagery Rule.
- **It links to `/heritage-aluminium-doors/` and that page links back**, both
  through deliberate sections rather than a line in a list. Owner instruction.

### Replacement Glazing Page

Route: `/double-glazing-replacement/`

- **Bespoke middle** in `template-parts/sections/replacement-glazing-v2.php`,
  dispatched from `generated-page.php` on `$is_replacement_bespoke`. Six
  sections: what has happened, the before-and-after wipe, on the day, what we
  put glass into, while the glass is being made, our work.
- **The dispatch sits OUTSIDE the specification-choices wrapper**, like repairs
  and secondary glazing. Inside it, the whole middle would be gated on a
  condition about colour swatches and would silently render nothing.
- **Gated off for this route:** the key-specification pulse, both generic middle
  bands, the specification-choices band (it offers frame colours, on the one
  page whose premise is that the frame stays) and the case-study strip (no study
  for this product exists and the helper falls back to showing all of them).
- **Not an energy page**, owner-confirmed. See the Replacement Glazing Rule in
  `AI.md` before writing any copy for it, and the standing ban on exclusions.
- **Order process:** steps 01, 02 and 04 are all overridden. 01 because this is
  the one route that can be priced remotely from sizes and a photograph, 02
  because the canonical step names thresholds a sealed unit does not have, and
  04 because it carries the ten year sealed-unit guarantee that the shared
  no-scheme string is silent on.
- **The hero CTA is overridden in two places.** `$cta_label` and the separate
  `fg-hero-cta__short` string for narrow screens. Override one and the phone
  quietly says something else.
- **The wipe is `template-parts/components/compare-wipe.php`**, shared with the
  flush casement page. It takes `base_*` and `overlay_*` plus `ratio`; the base
  layer is underneath and always fills the stage, so it should be the thing the
  page is selling. Renamed from `flush-sash-wipe.php` on 2026-08-10.
- Images live in `assets/images/products/replacement-glazing/`, with the two
  integral blind photographs in `assets/images/products/integral-blinds/`.

### Window And Door Repairs Page

Route: `/window-and-door-repairs/`

Template: `template-parts/sections/window-door-repairs.php`, a bespoke **middle**
dispatched from `generated-page.php`, the same shape flush casement uses. Not an
early return. Styling is `.fg-rp` inside the shared `.fg-cw` grammar.

**LIVE since 2026-08-07.** Owner-approved and deployed. The model
below is the third and accepted rebuild; two earlier builds were rejected and
are described only in `PROGRESS.md`. **If you find notes describing a "problem
finder" with fifteen filterable symptom cards carrying prices, that page no
longer exists** — it was the rejected second pass.

Current accepted model:

- **The page is ordered by the symptom, because that is the only thing the
  visitor knows.** They have not decided to buy anything; something has broken.
  Order is proposition strip, diagnostic schematic, van and engineers, parts
  wall, repair-or-replace with the glass hand-off, then how a repair works.
- **The diagnostic schematic is the page's one feature.** Left column is a list
  of symptoms in the customer's own words ("It will not lock", "My cat cannot
  get out"); the middle is an inline SVG line drawing of a window or a door;
  the right is a panel describing the part. Picking a symptom highlights the
  failing part **on the drawing** and swaps the panel. A window/door toggle
  swaps the whole drawing.
- **Both drawings are to scale and drawn from the owner's own reference
  photographs.** Window is `viewBox="0 0 620 900"` at 1 unit = 1mm; door is
  `viewBox="0 0 560 1200"` at 1 unit = 1.92mm. The register is AutoCAD, not
  illustration: mitres, construction lines, dimension rules, and **concealed
  hardware as dashed hidden line**. Strokes carry
  `vector-effect: non-scaling-stroke`. The owner corrected the geometry of the
  window handle, the door handle, the cylinder, the friction stays and both
  multipoint mechanisms individually, so **do not redraw any of them from
  imagination** — go back to the reference photographs.
- **The symptom-to-part-to-drawing mapping is a three-way contract**, held in
  `repair_diagnostics` and `repair_parts` in `inc/site-data.php`. `svg` is a
  **space-separated** list, so one symptom can light several groups
  (`d-draught` lights `drealign dgasket`). The render harness asserts that every
  symptom maps to a real part, every symptom maps to a group that exists in the
  drawing, and no drawn group is an orphan. Owner-set specifics that must not
  drift: window "will not open" is the mechanism, door "it has dropped" is the
  **hinges only**, and door "it will not lock" is the **gearbox only**.
- **It is progressive enhancement, not a JS page.** The interactive shell ships
  `hidden` in the markup and is revealed by the controller; underneath it every
  symptom and diagnosis is server-rendered, so the page works with JavaScript
  off and the symptom language is indexable. **Do not remove the fallback.**
- **Two traps are already paid for in this section, both of which cost a
  review round.** `[hidden]` from the UA sheet is beaten by any class rule that
  sets `display`, so `.fg-rp` carries explicit `[hidden] { display: none
  !important }` guards — without them both drawings rendered at once. And
  `hidden` is an `HTMLElement` IDL property that `SVGElement` does not have, so
  the controller toggles drawings with `setAttribute`/`removeAttribute`, never
  `el.hidden`. With `el.hidden` the symptom list switched product and the
  drawing did not.
- **No key-specification strip.** A repair has no specification, so
  `product_pulse` is gated off for the slug and the bespoke section opens with a
  four-USP proposition strip in that slot. `product_usps` for the route is kept
  accurate anyway because Legend reads it — and note the old entry claimed
  "Guarantee: 10 years", which was **false** and has been removed.
- **Seven things are gated off for this slug** and the reasons are in the
  comment on `$is_repairs` in `generated-page.php`: `fg-product-why`,
  `fg-product-intel` and `fg-product-visuals` (replaced by the bespoke middle),
  the specification-choices band (nobody picks a foil colour when a handle has
  snapped), the quote embed (WindowCAD prices windows and doors, not repairs —
  the slug is in `$no_instant_price_routes` alongside integral blinds), the
  shared order-process rail (see the Order Process Rule in `AI.md`), and the
  case-study strip (nothing claims this route, so the helper's fallback was
  showing three unrelated installations under a repairs heading). The FAQ limit
  is raised to seven for this slug.
- **Copy is deliberately short.** Owner, 2026-08-06: it read as a big page of
  text. One line per idea, no second paragraphs. The owner also pulled two
  specific registers — anything that **talks down to the reader** ("you do not
  need to know…") and the claim that our engineers are **"not installers between
  jobs"**, which is sometimes untrue. The van-stock claim replaced the latter.
- **There is exactly one price on the whole page** and it is in the FAQ: repairs
  start from £96 including VAT. No table, no range, no average — the owner's
  reasoning is that a published price list invites benchmarking and undercutting.
  See the Repair Pricing Rule in `AI.md`. The FAQ answer went through three
  rejected drafts; the accepted one ties the variable to a physical thing
  ("depends on which part your window or door needs") because anything vaguer
  read as though the price could spiral.
- **Imagery is the parts and the van, not a tradesman.**
  `imported/window-repair-milton-keynes-scaled.jpg` is stock — a man in blue
  dungarees with a screwdriver — and `pages.json` still carries it as this
  route's imported hero. Do not reinstate it.
  - The four repair-part photographs under
    `assets/images/products/repair-parts/` are **Wharfside's** supplier
    photography. They are our supplier and have agreed to our using them.
  - **Every image path must go through `fenster_generated_url()`, including
    inside the JSON block the controller reads.** This shipped broken once: the
    template emitted theme-relative paths, which render fine locally and 404 on
    Bedrock, and all four part images were missing on test. The local harness had
    been rewriting them and hiding it.
  - The handle uses `products/handles/s2-chrome-cutout.png`, not the handle
    hub's `s2-chrome-finish.png`. The hub's file has an alpha channel but an
    opaque `#FAFAFA` backdrop, so a CSS drop-shadow draws round the rectangle.
    The cutout is that file flood-filled to real transparency under a new name.
  - **`.fg-rp-wall__grid li` is `display: block` with `aspect-ratio: 1`, not a
    centred grid, and its `img` is `display: block` too.** Both are load-bearing
    and both cost a review round. `place-items: center` leaves the grid area
    content-sized, so the image's `height: 100%` is circular and silently falls
    back to intrinsic height — the portrait handle drew 537px in a 372px box and
    was clipped. And an image is inline by default, so it sits on the text
    baseline and the descender adds ~8px: the square cells measured 90x98 and the
    wall read as a ragged collage. The comments are in the stylesheet; keep them.
- **Not verified on a real phone.** Everything was measured through a 390px
  headless viewport and driven programmatically; nobody has used the diagnostic
  with a thumb. This is the one outstanding item on the page.
- **The door's fine hardware is under 5px at true scale.** The cylinder in
  particular is barely visible, because the door drawing is already at the
  ceiling of its plate (643px in a 634px box, trimmed to a 292px max-width). The
  correct drafting answer is a detail callout at an enlarged scale, which was
  offered and **not built**. Do not "fix" this by breaking the drawing's scale.
- **Verification harness:** `render-repairs.php` in the session scratchpad stubs
  WordPress, renders the section standalone and runs ~40 assertions, including
  the real `fenster_generated_url()` implementation and every claim the owner has
  pulled. It is not in the repo. If you do substantial work here, rebuild it —
  there is no local WordPress on the Mac, so it is the only pre-deploy check
  short of pushing to test.

### Casement Windows Page

Route: `/casement-windows/`, the most viewed page on the site.

Template: `template-parts\sections\casement-windows-v2.php`, dispatched from `template-parts\sections\generated-page.php`, which returns early for this slug. Styling is the `.fg-cas` namespace.

Current accepted model, rebuilt 2026-08-04:

- **The page is ordered by the customer's journey, not by section type**: overture, film, then three numbered chapters, then proof, then the quote tool. The chapters are the three things that sell this window and the owner named them: **01 Versatility, 02 EnergyPlus, 03 Security**. Do not reorder them or add a fourth without asking.
- **The register is a car maker's product page.** One display size across every chapter and section head, a hairline chapter numeral, full-bleed photography, generous space, and no cards or drop shadows. Both technical chapters sit on dark so the white studio photography reads as lit product.
- **Imagery rule, owner instruction:** the best image wins and staged manufacturer photography is preferred, *except* in the proof mosaic and the case studies, where the point is that the work is ours. Do not put job photographs back into the body.
- **The proof mosaic claims every photograph in it as a Fenster installation, so audit it photograph by photograph.** The stone elevation is Liniar's and belongs in the overture; the Leighton Buzzard frame is cropped to the downstairs window because the upstairs on that terrace is not ours.
- **The key-specification strip prints one U-value on every route: the lowest the system reaches.** Owner instruction 2026-08-04 for the Liniar routes and 2026-08-05 for the rest. **The star is earned, not decorative.** A route with two glazing units shows the lower figure starred, with a one-line note reading `* Lowest achievable.` under it inside the same tile; a route with only one unit has no lower figure to qualify, so it prints plain with no star and no note. Flush casement, slide and fold and roof lanterns are the plain ones today. **There is no route list any more** — `single_u_value_routes` was removed on 2026-08-05, because with the treatment universal a hand-kept list of converted routes could only drift. `template-parts\components\product-pulse.php` derives all of it from `glazing_u_values` in `inc\site-data.php`, so adding a route there is the only edit needed. Note that the Thermlock banner carries no glazing figures, so on the eight Sheerline routes the strip is the only place a U-value appears; the EnergyPlus banner still carries both figures on casement and tilt and turn.
- **The locking mechanism is the Kenrick Excalibur, owner confirmed 2026-08-04.** The figures beside it in `$lock_specs` are Kenrick's own published test data for the mechanism, read off `kenricks.co.uk/products/window-hardware/excalibur` on that date: ten year mechanical guarantee, 100,000 cycles, 240 hours salt spray exceeding BS EN 1670:2007, PAS 24 **capable** and a Secured by Design product. Capable is Kenrick's word and the distinction is load-bearing — a PAS 24 approval belongs to a tested complete window, never to a component, so none of these may be restated as a Fenster window figure. The security list below the hero already carries that distinction; keep it.
- **The Excalibur photograph is Kenrick's studio shot, cut out.** `cas-kenrick-excalibur.webp` is `excalibur-2.jpg` from that page with the backdrop *and its drop shadow* removed. Two things to know before regenerating it: the shadow is an olive grey that reads identically to the matte faceplate, so a colour flood cannot separate them and seeding inside the shadow eats the whole gearbox — the mask that works is a generous fuzz-13 corner flood intersected with a hole-closed, dilated fuzz-24 flood. And the part is **not** mirrored, however the embossing looks at a glance: rotate the bar level before judging and "KENRICK" and "U.K. PAT. 2247788" both read correctly as shot. The contact shadow is CSS `drop-shadow`, deliberately not baked into the file, so the part can sit on any colour.
- **The flush comparison uses the white background Liniar studio pair**, cropped square so both subjects present at one scale. Those originals are **CMYK JPEGs**: a contact sheet will render them as dark brown and they are not. The converted sRGB set lives in `assets\images\products\casement\studio`; regenerate with `-colorspace sRGB` and look at the result.
- A drawn canvas configurator was built here on 2026-08-04 and removed the same day on the owner's instruction: the WindowCAD tool already configures a window *and* prices it, so a second configurator competed with the thing that converts, and a vector drawing read as a game graphic rather than a premium product. Do not rebuild it. If this page needs more interactivity, route harder to `#fenster-product-quote`.
- **A slot near the top is reserved for an installation film.** `$film_src` at the top of the template is empty, so the band renders the installer photograph with an in-production chip. Setting that one variable to a theme path plays the mp4 in the same frame.
- `.fg-cw-gallery` still exists in the stylesheet for `/heritage-aluminium-doors/` only. It is labelled; do not prune it with the next casement rewrite, and never prune CSS by splitting on blank lines, which drops media query wrappers.

### Colour Options Pages

Routes:

- `/colour-options/`
- `/upvc-colours/` redirects to `/colour-options/`
- `/aluminium-colours/` redirects to `/colour-options/`

Current accepted behaviour:

- The pages are hidden from the main navigation.
- Product journey pages link to `/colour-options/` from the `Specification choices` section.
- Colour data lives in `inc\site-data.php` under `colour_options`.
- `/colour-options/` shows both uPVC and aluminium colour sections on one customer-facing hub. The old top uPVC/aluminium tab buttons were removed because they implied separate journeys when everything is on the same page.
- `/upvc-colours/` and `/aluminium-colours/` no longer render duplicate pages. They redirect to `/colour-options/`; use colour-hub section anchors/material controls for specific uPVC or aluminium context.
- The colour pages are straightforward customer-facing reference hubs; do not put the circular choice dial on these pages.
- The circular choice dial belongs on generated product pages in the `Specification choices` section, where it links to colours, privacy glass and handles or quote options.
- Mobile uses the same colour data in a single-column layout.
- Supplier/manufacturer scrape assets may be used as source imagery, but never expose implementation/source wording such as scrape folder names, manufacturer scrape labels, internal provenance, or supplier names unless the owner explicitly asks for customer-facing supplier branding.
- Visible copy should stay simple: `uPVC colours`, `Aluminium colours`, finish names and customer-useful finish details. Do not add source badges, internal notes, or long product applicability lists beneath the colour carousel.
- uPVC colour swatches currently use optimised WebP assets under `assets\images\products\colours\liniar-swatches`, sourced from `images\colours_page_image`.
- Door-render colour assets under `assets\images\products\colours\liniar-door` exist for later door-page use and should not be used for the colour hub swatch carousel.
- The uPVC carousel has a coverflow-style interaction with buttons, keyboard controls and draggable scrub behaviour.
- Dragging the carousel should scrub the coverflow animation itself. Do not move the whole carousel stage sideways and then snap it back.
- Dragging can move across multiple colours; on release it snaps to the nearest colour. Keep sensitivity calm for mobile.
- Current uPVC visible colour names include `Smooth White` with `No foil`, `Anthracite Grey` instead of `7016 Grey`, `Gale Grey Finesse (Anthracite Smooth)` and `Silver Grey` instead of `7155 Grey`.
- Removed uPVC colours should stay out of the customer carousel unless the owner reverses the decision: Anteak, Bright Oak, Swamp Oak, Nussbaum, Windsor, Balmoral, Bronze, Champagne Smooth, Pebble Grey, 7030 Grey, 7039 Grey, 7044 Grey, Black Ultimatt, VLF Black, Burgundy, Flemish Gold, Claystone, Sage, Sheffield Oak Alpine, Turner Oak Malt and Trompet.
- The colour hub hero visual should stay clean and controlled. The accepted direction is a simple sample-board/grid using complete swatch images; avoid random overlapping piles, rotated card stacks and cropped-off swatch content.
- Mobile QA: the colour hub hero visual is hidden on mobile as of commit `c21bd46`. The page content after the hero is acceptable; keep the mobile first impression clean, not image-led.

### Door Handle Section

Door product pages now include a real door-handle section rather than the earlier placeholder.

Current accepted behaviour:

- Door handle data lives in `inc\site-data.php` under `door_handles`.
- Cropped handle assets live under `assets\images\products\door-handles`.
- The original supplied nine-handle sheet was cropped into separate transparent PNG assets.
- **The route list here was four releases stale and is corrected as of 2026-08-07.** It still named Patio, Aluminium Bifold, Aluminium Sliding and Slide & Fold, all of which came off `door_handles.slugs` on 2026-07-29 because those systems take a different handle family. The live list is five:
  - Composite Doors
  - uPVC Doors
  - French Doors *(off on 2026-07-29, put back on 2026-08-07: the owner confirmed a French pair takes the same long-plate handle as the single leaf)*
  - Aluminium Doors
  - Heritage Aluminium Doors
- Patio, aluminium bifold, slide and fold and aluminium sliding each stay off and each has its own family or its own reason. Aluminium sliding in particular has the architeQ Aspire lift-and-slide furniture in `lift_slide_handles`; do not fold it back in.
- The full route rules live in `AI.md` under the Door Handle Section Rule. Treat that as the source and this as a summary, because this list is what went stale.
- It uses the same selector behaviour as the window handle section: finish swatches, active handle image/copy, feature tiles and a static compatibility note.

## Integral Blinds Desktop Reveal

Route: `/integral-blinds/`

The page has a desktop-only opening reveal made from the supplied `internal blinds.mp4`.

Current accepted behaviour:

- The reveal is a transparent fixed overlay covering the full viewport, including the hero.
- It is the first desktop interaction on the page.
- The document and Lenis smooth-scroll are locked at `scrollY = 0`.
- Scrolling controls the video in reverse so the blinds open.
- The virtual scroll is eased, not direct wheel-to-frame jumping.
- Reveal travel is about `1.55` viewport heights.
- The working chroma canvas is `720 x 405` for responsiveness.
- Once fully open, the overlay fades out and normal page scrolling resumes from the top.
- It is disabled on `860px` and below and for reduced-motion users.

Runtime files:

- Video helper/preload: `inc\assets.php`
- Markup: `template-parts\sections\generated-page.php`
- Controller/chroma key: `src\js\main.js`
- Overlay styling: `src\scss\main.scss`
- Video asset: `assets\videos\product-scroll\integral-blinds-chroma.mp4`

## Enquiry System

The site has one shared live form component:

`template-parts\components\enquiry-form.php`

Do not create standalone forms.

Handler:

`inc\enquiries.php`

Current behaviour:

- JavaScript intercepts `[data-fg-enquiry-form]`.
- The form posts through WordPress AJAX.
- Success appears in place without changing the route.
- The no-JavaScript fallback remains.
- All fields are visible in one form flow; the old stepped/wizard presentation has been removed.
- Shared enquiry section headings should use moderate content-heading scale. Do not let `.fg-obscure-enquiry__grid h2` or related form headings render at hero scale.
- Some old stepped-form CSS/JS selectors may still exist as inactive scaffolding, but the shared PHP component does not currently render the stepped data attributes or step controls.
- Valid leads are saved as private `fenster_enquiry` posts.
- Office notification email is branded HTML.
- Customer acknowledgements are paused until authenticated SMTP is configured. Do not restore public form copy that promises a confirmation email.
- Default verified recipient is `info@fensterglazing.com`.
- Live delivery still requires production SMTP/DNS configuration.

SMTP constants supported in `wp-config.php`:

- `FENSTER_SMTP_HOST`
- `FENSTER_SMTP_PORT`
- `FENSTER_SMTP_USERNAME`
- `FENSTER_SMTP_PASSWORD`
- optional `FENSTER_SMTP_SECURE`

## Homepage

Dedicated homepage source of truth:

`HOMEPAGE.md`

Main homepage template:

`template-parts\sections\home-experience.php`

Current homepage direction:

- Full-width optimised video hero.
- Combined trust cards.
- Interactive product theatre.
- Instant-pricing bridge.
- Project proof.
- Partner strip.
- Shared enquiry form.
- Local-service links.
- Expanded footer.

Do not rely on this handover for homepage fine detail; read `HOMEPAGE.md` before homepage work.

## Contact Page

Route: `/contact/`

Main template:

`template-parts\sections\contact.php`

Current accepted behaviour:

- The page is a polished contact hub, not a plain form page.
- Hero uses the Milton Keynes showroom image at `assets\images\about\fenster-showroom.png`.
- Quick action cards cover phone, email, showroom directions and instant pricing.
- The showroom/map, route-choice and enquiry sections wrap around the shared enquiry form.
- The page still uses `template-parts\components\enquiry-form.php` as the only live customer form.

## Shared Review Showcase

Shared component:

`template-parts\components\review-showcase.php`

Current accepted behaviour:

- Review data lives in `inc\site-data.php` under `customer_reviews`.
- The component renders a fixed Google/Trustpilot-style `EXCELLENT` summary and a carousel.
- The default carousel shows seven cards from the curated review data.
- Some templates still pass `eyebrow`, `title` or `copy` arguments, but the component currently ignores those text arguments. Do not describe route-specific review headings as live unless the component is extended.

## Three.js Status

Three.js is not active on the live site.

- `wp-content\themes\fenster\package.json` has no `three` dependency.
- `src\js\main.js` imports Lenis only.
- `inc\assets.php` does not enqueue Three.js from a package or CDN.
- The compiled `assets\js\main.js` does not contain `THREE`, `WebGLRenderer`, `data-fg-home-3d` or `fg-home-hero-3d`.
- There is inactive legacy source/styling for an old homepage 3D hero experiment: `fg-home-hero-3d`, `data-fg-home-3d` and an `if (false) { ... THREE.* ... }` block.
- The actual homepage route returns `template-parts\sections\home-experience.php` before that old generic-home hero branch can render.

Do not revive or work around the old Three.js/canvas experiment unless the owner explicitly asks for 3D again.

## Commercial Pages

Commercial pages use the shared generated-page infrastructure plus commercial-specific content and route grouping.

Commercial content should stay commercial. Do not mix residential product links into commercial related-link panels unless contextually appropriate and route-checked.

Commercial county landing pages are generated from `fenster_commercial_county_profiles()` in `inc\generated-pages.php` and render through `template-parts\sections\commercial-county.php`.

Current accepted behaviour:

- **`/louvre-vents/` is a bespoke middle as of 2026-08-11**, in `template-parts/sections/louvre-vents-v2.php`, dispatched from `commercial-product.php` on the slug. It carries the IKON range with IKON's published figures: the IKL33 we fit most, free area explained in its two kinds, a table of the four standard systems, the continuous versions, turrets and plenum boxes, the five frame types and the options. **Composite panels are excluded and the supplier is not named on the page; the model codes are.** Six photographs, each placed where it supports the copy rather than in a gallery. See the Louvre Vents Rule and the Marked Placeholders Rule in `AI.md`.
- `/commercial-glazing/` is now a stronger v2 commercial landing page, not just a generated service shell. Keep it simple, proof-led and conversion-led: clear project proof, practical service cards, fewer decorative effects, and an obvious commercial enquiry form.
- Do not restore the removed tiny parallax drift in the "How enquiries move" area. It added motion without meaning.
- Commercial project proof should use images from the commercial projects/assets already in the theme. Do not point runtime markup at `wp-content\fenster-reference` or unrelated residential/product stock.
- Commercial form fields must remain visibly bordered/readable. The left-side form copy should be supporting copy, not huge hero-scale text that makes the task feel awkward.
- The route pattern is `/commercial-glazing-{county}/`.
- The set covers the commercial county routes Fenster is prepared to review, excluding ferry/island-access areas that are not credible normal coverage, such as Isle of Wight.
- County pages are SEO-indexable and included in the generated page sitemap.
- Each county page has unique county-specific H1/title/meta/town/context copy built from its profile data.
- Each county page has the shared enquiry form in the hero and a clearly visible phone CTA.
- `/commercial-areas/` is a temporary noindex developer review page. It must stay out of the public header and sitemap.
- Do not add individual county SEO pages to the normal Commercial dropdown; keep the dropdown focused on the commercial hub and commercial projects.

## Location Pages

Location service pages use generated/imported content and shared templates.

The generated residential product/location matrix uses explicit town and product profile data in `inc\generated-pages.php` for title tags and meta descriptions. Do not restore the old single duplicate meta-description template across all town/product pages. Body copy continues to render through `template-parts\sections\location-service.php`, which varies page copy by town profile, product profile and slug-based copy variant.

Related links for location pages should prefer:

- the same town's double-glazing page,
- sibling real products/services for that town,
- relevant residential/commercial group links.

## Header And Mobile Behaviour

At `860px` and below:

- `.site-header` is fixed.
- `.site-main` reserves the fixed header height.
- The mobile drawer starts under the header.
- Desktop sticky homepage theatre is replaced with mobile normal-flow cards.

This fixed a previous mobile/tablet failure where the header appeared to disappear and the desktop theatre filled tablet viewports.

## Footer

Footer is expanded and structured. It should not collapse into an unstructured list on mobile.

Footer columns cover:

- Brand/about and accreditations.
- Products.
- Fenster links.
- Contact.

Mobile footer has a dedicated panel layout.

## Assets

Important optimised assets:

- Homepage hero video: `assets\videos\home\fenster-home-hero.mp4`
- Homepage hero poster: `assets\images\imported\home-hero-poster.jpg`
- Integral blinds reveal video: `assets\videos\product-scroll\integral-blinds-chroma.mp4`
- Aluminium door turntable assets belong to `/aluminium-doors/`, not Composite Doors.

Scrape-derived imagery used by templates and `data\pages.json` lives in `assets\images\imported`. The `wp-content\fenster-reference` folder is a local-only archive: nothing at runtime references it and it must not be deployed.

Do not replace optimised production assets with huge reference originals.

## Performance Baseline

Current live performance strategy is "defer, right-size and lazy-load" rather than stripping out all premium media.

Already deployed:

- First-visit loading screen removed.
- Homepage hero video is deferred until idle on normal desktop connections and is interaction-gated on mobile, reduced-motion and constrained-connection sessions.
- Homepage hero poster is preloaded and should remain the intentional first visual for slow/mobile page loads.
- Gibson fonts now have WOFF2 versions; Regular and SemiBold are preloaded as critical weights, with OTF kept only as fallback.
- The main stylesheet is loaded through a preload/activate pattern with critical first-viewport CSS in the head. Re-test the first viewport if this mechanism changes.
- Homepage/product/quote WindowCAD iframes use deferred source loading and near-viewport or interaction triggers.
- Product theatre and heavier image/video sections avoid eagerly loading every asset up front.
- Public generated pages/sitemaps use short cache headers for logged-out visitors.
- Theme image helpers can emit explicit width/height attributes from local files; use `fenster_image_attr_string()` for new local theme image markup where practical.
- Long-lived cache headers for static CSS, JS, fonts, images and video still need to be applied at SiteGround/CDN level because `app/public/.htaccess` is ignored by the scoped GitHub theme repo.

Next high-value performance work:

- Create a 720p/mobile rendition of the homepage hero video and use responsive source/media loading.
- Convert heavy photo PNGs and partner/logo PNGs where suitable to WebP/AVIF or smaller optimised PNGs.
- Add `width`, `height`, `srcset` and `sizes` helpers for hardcoded images.
- Continue adding explicit dimensions/srcsets/sizes to lower-priority hardcoded images beyond the already covered header/homepage/generated hero surfaces.
- Continue memoising/generated-data work carefully; do not break SEO routing to chase a tiny benchmark gain.

## Current QA Expectations

Before handing work back:

- Run `npm.cmd run build` after SCSS/JS changes.
- Lint changed PHP.
- Check desktop and mobile where layout changes are involved.
- Minimum responsive checks for important work:
  - `390 x 844`
  - `768 x 1024`
  - `1440 x 900`
- Check no horizontal overflow.
- Check console errors where browser QA is available.
- Update docs in the right place.

## Things To Avoid

- Do not add standalone forms.
- Do not restore raw scraped related links.
- Do not invent product specs.
- Do not use inconsistent mobile breakpoints without documenting why.
- Do not distort images/videos to fill space.
- Do not rely on hover for mobile interactions.
- Do not put dated progress reports in `AI.md` or `HANDOVER.md`.
- Do not edit compiled CSS/JS without updating source and rebuilding.
