# Fenster Glazing Progress Log

Last updated: 2026-08-04

## START HERE, 2026-08-02 (end of session)

**The live SHA in this block is stale. `LIVECHANGES.md` is authoritative** and
records live as `c97aff4` on 2026-08-03, established by checksum. The rest of
this block still holds.

**Live, `main` and test are all level at `0b0affe`.** Re-establish live by
checksum before any release anyway, and on **more than one file**:
`assets/css/main.css` was byte-identical across two candidate commits earlier
today and would have given a false read on its own. The recorded pointer was
correct at the last two releases, which is not a reason to stop checking.

**Nothing is waiting on an owner decision.** The banner-impressions
contradiction that sat here was closed on 2026-08-03: the metric stays, the rule
was rewritten to match, and the reason it must never become a rate is now
recorded in `AI.md`. See the 2026-08-03 entry below. Do not raise it again.

**Two traps added 2026-08-02, both about diagnosing before fixing:**

- **Ask what colour it went.** The contact hub cards were reported turning to
  block colour. The first diagnosis, the consent modal's backdrop dimming them,
  was reproducible and wrong. "Green and blue" was the tell: those are
  `--color-accent` and `--color-steel`, the fallback layers beneath the images
  in the same `background` shorthand, so the image layer was not painting at
  all. A symptom that looks like dimming and a symptom that looks like a missing
  layer are not the same thing.
- **A rule that states a fact is a source, not a description.** `AI.md` said the
  consultation includes measuring up. Nine places across the site had copied it,
  including Legend's verified facts, so the fix had to start with the rule
  rather than the page that was reported.

**Closed since the last session, so do not reopen:**

- **Aluminium sliding doors ordering.** Was listed here as wanting a decision on
  a dedicated template. Separately, the owner confirmed on 2026-08-02 that the
  patio handle grid must **not** be added to that route, despite Mila's
  literature saying the handle suits aluminium patio doors. See the Patio Handle
  Rule in `AI.md`.
- **The handle hub's "patio to come" note.** `/handle-options/` now carries all
  four families: windows, tilt and turn, hinged doors and sliding patio.

**Four traps worth not repeating:**

- **The image bank is not the scrape.** A note here said there is no scrape on
  this Mac, and that was taken to mean no supplier assets at all. The Sheerline
  turntables, patio stills and several unused animations were in OneDrive at
  `Marketing/Image Bank/Legacy Marketing/Sheerline web assets` the whole time.
  Look there before concluding an asset does not exist.
- **A duplicate check on filenames cannot see a duplicate photograph.** An image
  added to the slider pool turned out to be the hero at a different crop, 0.85%
  RMSE apart against 39% for two genuinely different shots. Compare pixels:
  `magick compare -metric RMSE` on two resized copies.
- **Measuring the wrong axis passes a broken layout.** Twice in one day a change
  was verified by measuring what had been changed rather than what it affected: a
  colour-grid heading checked for columns and overflow but never placement, and
  case-study cards checked for flex-direction and width but never height, which
  shipped text sitting on top of photographs on five pages. If a change touches
  layout, measure the thing next to it too, and look at it.
- **`pdfimages` returns Adobe CMYK JPEGs inverted.** Converted straight to sRGB
  they come back as the subject lit on a black field, which reads as deliberate
  product photography rather than a broken extraction. Negate before the
  colourspace convert, and check against a `pdftoppm` render of the page. This
  cost a wrong conclusion about the Mila handle assets on 2026-08-02.


## 2026-08-04 - A casement configurator, built and then removed the same day (test)

Owner, on the redesign below: stop plastering the leaks and rebuild the pipe,
with one real wow factor. Then, on what came back: stop that section, we
already have a far better tool for the same thing, and think showcase for a
high end product rather than internet game graphics.

**Both corrections were right, and the second is the one worth keeping.**

- What was built: a canvas configurator at the top of the page drawing the
  specified window across six layouts, seventeen foils, three bar treatments,
  horns, six handle finishes, two interior faces and a continuous size. It was
  honest work. The open sash was exact orthographic projection, every value
  came from `site-data`, nothing hit-tested the canvas, and nine rendered
  states were checked by hashing the canvas before and after every control,
  which is what caught a toggle that changed no pixel.
- **It was still the wrong thing to build, for two reasons neither of which is
  a bug.** The site already has a configurator that does the same job and then
  gives a real price: the WindowCAD tool is the documented differentiator and
  the strongest lead route on the site. A second one that only draws competes
  with it for the same click and wins nothing. And a vector drawing of a
  premium product reads as a game asset next to real photography, however
  carefully the light is derived. A showcase page for a high end product is
  photographs.
- **Removed in full**: the component, the controller, the stylesheet block and
  the `grain` flag added to `colour_options` for the renderer. Nothing is left
  behind; `fg-cwd` returns zero in source and in both compiled assets.
- `HANDOVER.md` records the decision on the casement section so the next
  session does not rebuild it, and points any future demand for interactivity
  at the quote embed instead.
- **The lesson, written down because it cost a day.** Before building an
  interactive feature, check what the site already does. The test in `AI.md`
  is whether a configurator answers a question a photograph cannot; the test
  it does not state, and now does by way of this entry, is whether something
  on the site already answers it better.

## 2026-08-04 - Casement page redesigned around film, personalisation and the flush comparison (test, cf54f3b)

Owner brief: the most viewed page needs redesigning into the best page on the
site. More images, a placeholder near the top for a video being made, the
opening styles section sense-checked, a clear comparison with the uPVC flush,
and something like Liniar's own customise block for bars, shaped frames and
mock horns. STYLE.md to be followed loosely and ignored where it constrains.

- **The film slot is a variable, not a to-do.** `$film_src` at the top of
  `casement-windows-v2.php` is empty; the dark cinematic band under the spec
  strip renders the installer poster with a pulsing "In production" chip until
  an mp4 path is set, at which point the same frame plays an autoplaying muted
  loop. The placeholder explains itself to a customer instead of reading as
  unfinished.
- **The personalisation stage reuses `[data-fg-door-selector]` unchanged.**
  Five looks, each a real photograph: clean, Georgian bars, astragal bars and
  mock horns, leaded glass, and two-tone colour. The astragal close-up came
  from `imported/Sash-horn-astragal.jpeg`, unused since the scrape import, and
  the leaded bay is the 1649px `bay-window.jpg` original from the image bank,
  which is the high-resolution sibling of the 600px Flitwick copy. Chip thumbs
  are dedicated 160w files so five buttons do not pull five full images.
- **The sense check found the opening styles claim was wrong.** The copy said
  the Leighton Buzzard photo "uses three of the four" layouts; the photograph
  shows two side-hung sashes around a fixed pane, which is two. It now says
  that. The egress line also claimed bedrooms get egress hinges outright; it
  is now scoped to where a bedroom needs its escape route. Mixed layout was
  renamed Combinations, because it is not a layout.
- **The flush comparison is annotated photography, not adjectives.** Cranfield
  carries both differences in one frame: numbered markers point at the proud
  sash and at the fixed pane glazed straight into the frame, against the flush
  stone three-light where every face closes level. A four-row table separates
  them on figures, both shown A+ per the even-handed comparison rule, and the
  new FAQ carries the same answer into the FAQPage schema.
- **The gallery grew to six** with the anthracite bay from the bank's casement
  folder (`ce32a4c8`), and the mosaic was re-cut 4/3 over 2/3/2. The base
  five-cell cut only existed for this page; heritage overrides its own cells
  and is unaffected.
- **A portrait in a 4:3 stage crops to wall.** The Broughton two-tone stage
  option first used the 900x1200 portrait, and cover-cropping put the dormer
  at the edge and showed mostly brick. Caught by rendering the crop at stage
  size before it shipped anywhere visible; the stage now uses a 1200x900 crop
  of the case-study side photo centred on the lower basalt grey window.
- Compiled JS is byte-identical: the stage, anatomy and lightbox all run on
  controllers that already exist. CSS gained the film, stage and versus blocks
  inside the `.fg-cw` scope, plus a scoped screen-reader utility because the
  theme has no global one.
- Verified on test by rendering the deployed markup with local assets: all
  four new sections present, zero PHP notices, every new asset serving 200.
  A 390px iframe probe proved `innerWidth=390`, `scrollWidth=390`, max heading
  39px against the 57.6px cap, all five stage swaps updating image, name and
  copy, four markers, six gallery cells and the versus table fitting without
  scroll. Desktop reviewed as full-height renders at 1280.
- Test deployment only. Live is untouched; the owner reviews on test.

## 2026-08-04 - Leagrave integral blinds case study, live (4c85f4a)

- The eleventh case study and the only one where the blind is the product: one
  uPVC casement in a Luton bathroom with a Notan magnetic blind sealed inside
  the glass, fitted by Shane and Zac Rugman on 23 June 2026. Owner confirmed a
  new window rather than a reglaze, and that it was priced at a home
  consultation, so `priced_by` is set. It is also the first genuine local proof
  on `/double-glazing-luton/`, which previously matched nothing.
- **Two specs are deliberately absent and should stay absent.** No frame system:
  Fenster's uPVC casement is Liniar EnergyPlus, but nothing in the supplied
  photography proves this one is. No U-value or energy rating: a Notan blind
  lives in an NTB 24/28 cavity, so the `0.95 W/m²K` / A+ the other casement
  studies quote for a 36mm triple unit does not describe this glass. The fourth
  spec slot went to the control, which is visible in the photographs, rather
  than to a figure carried over from a product page.
- **`CASESTUDIES.md` was wrong about portrait video and has been corrected.** It
  said to centre-square the source when encoding. `fg-cs-hero__media--video`
  already sets `aspect-ratio: 1/1` with `object-fit: cover`, and all three
  portrait studies ship full portrait, so following it would have cropped the
  clip twice. Also newly recorded there: the archive card is `16 / 10`, so a job
  photographed entirely in portrait needs a `card_image` cut from the
  full-resolution original or the card shows a band of wall and no window.
- Verification traps worth keeping, all hit in this session. `ffmpeg -i` reports
  a phone clip's stored size and auto-rotates before `-vf`, so this source reads
  `1024x576` and displays `576x1024`; plan crops against the displayed size.
  Test is Bedrock, so a hand-built `/wp-content/` asset URL 404s on a file that
  deployed fine. `captureBeyondViewport` does not trigger `loading="lazy"`, so a
  full-page shot showed two gallery images and two bare captions and looked like
  a broken masonry that measured perfectly. And see `LIVECHANGES.md` for the
  `www` 301 and the tag-stripping issue, which produced false MISS readings
  against a page that was correct.

## 2026-08-04 - Frame colour card shows real finishes (1a11109)

- The six dots on the Frame colours card were six hexes written into the
  stylesheet. Four landed on real finishes; the other two, a sage green and a
  navy, matched nothing anyone can order. They now come from the real uPVC range
  by name: White, Chartwell Green, Golden Oak, Anthracite Grey, Agate Grey,
  Blue. The CSS reads them through `--dot-N` with the same real values as
  fallbacks, so a card that sets none still shows orderable colours.
- **A commit made on a release branch, then pushed with `git push origin main`,
  goes nowhere and says nothing.** It pushed the unmoved local `main`, reported
  success, and the server's `reset --hard origin/main` deployed the previous
  commit. It was only caught by grepping the deployed file for a string from the
  change. Do that after every deploy; a clean push and a clean rsync are not
  evidence that the change shipped.
- The colour hub hero wall was checked at the same time and was already correct:
  it is built from the real range and had picked up the new slat colours.

## 2026-08-04 - Blinds visualiser live, after it briefly took the blog down (6e98351)

- **The visualiser is live and so is the blog. Getting there took two deploys
  because the first one removed work that was already in production.**
- The integral-blinds release was cut from `13354b4` and deliberately excluded
  the concurrent session's blog system, which was the standing instruction from
  three previous releases. In the hour before, that session had shipped the blog
  to live as `4f910f0` with the owner's approval. `rsync --delete` then removed
  `inc/blog-posts.php`, the blog template and the `functions.php` registration,
  and every scheduled post 404'd until the combined release restored them.
- **The checksum sweep did not catch it because it ran too early.** Live was
  established as `13354b4` at the start of the release work and verified again
  after the deploy — both correct at the time. Nothing checked live in the
  seconds before the rsync, which is the only check that would have shown
  `4f910f0` underneath. Re-establish live immediately before overwriting it.
- **A scoping instruction can go stale without anyone telling you.** "Just mine"
  was right while the blog was unapproved and wrong the moment it was approved
  elsewhere. With two strands in flight, cut from `main` and subtract what is
  unapproved, rather than cutting from an old live and adding your own: the
  subtractive version fails safe, the additive version silently drops whatever
  arrived in between.
- The fix was a release from `main`, which already held both strands, with the
  compiled assets rebuilt from its own source. Selector diff against `4f910f0`
  confirmed it added exactly `.fg-blind-visualiser` and `.fg-blind-colours` and
  removed nothing.

## 2026-08-03 - Notan blind visualiser built on test (fa9ccc8, since superseded and live)

- **On test only at the time.** Superseded: the visualiser went live on
  2026-08-04 and live is now `1a11109`. The entries above this one carry the
  corrections that followed; read them before treating anything here as current.
- `/integral-blinds/` now carries an interactive visualiser: one glazed unit
  drawn face on and fully straight, worked by the two magnets on its own
  profile, in the nine real Notan slat colours. Accepted behaviour is written
  up in `HANDOVER.md` under Integral Blinds Page; the colour facts are in
  `AI.md` under the Notan Integral Blind Rule.
- **The controls are part of the product, and the first build got that wrong.**
  It shipped page sliders next to a picture of the unit. The owner corrected
  it: on a Notan magnetic unit the two magnets run in a channel on the colour
  matched frame sealed inside the glass, the upper one tilting and the lower
  one lifting. They are now drawn on the right hand stile and dragged there,
  and the profile takes the selected slat colour with them. The lesson is the
  ordinary one: the control surface is a fact about the product and needed
  checking against the supplier's own photography, exactly as the colours did.
- One function, `magnetTracks()`, owns both where a magnet is drawn and where
  it can be grabbed, so the two cannot drift apart.
- **A measuring function with a side effect blanked the canvas.** `layout()`
  sized the backing store as well as measuring, and assigning to `canvas.width`
  clears the canvas even when the value has not changed. The pointer handling
  calls `layout()` on every move to hit-test the magnets, so moving the mouse
  across the unit wiped it to black, and because nothing is scheduled once the
  easing has settled it stayed black. The owner reported it as "keeps on going
  black after clicking". `layout()` is now measurement only. The general
  lesson: anything the pointer path calls at pointer rate has to be pure.
- **A photograph of the real thing beat two rounds of careful sourcing.** The
  slat colours had been taken from Notan's web swatches and cross-checked
  against their brochure, and were still wrong: Cream was a near-neutral grey
  and is a warm greige, Rose Gold was a taupe and is a champagne gold, Metallic
  Silver was a dark grey and is a bright silver. The owner's photograph of the
  physical sample card settled all three. Where a product exists, ask for a
  picture of it before trusting a supplier's marketing asset.
- **The brochure is the range.** The physical sample card and the brochure
  disagreed: the card had a BY005 charcoal the brochure omits, and omitted the
  BY012 White/Anthracite the brochure lists. Settled by the owner: BY005 is not
  offered, BY012 stays, and BY012 is not a separate colour but White and
  Anthracite Grey one on each face, so its two values track those entries.
- **Any lattice reads as a lattice.** The glitter finishes were built from tiled
  radial-gradients, which line up into a visible weave at swatch size and read
  as printed fabric rather than metallic flake. Replaced with an inline SVG of
  fractal turbulence thresholded to its brightest tail.
- **The page around the visualiser needed the same scrutiny as the visualiser.**
  Once the blind itself was right, the owner found four things wrong with the
  page it sits on: three of the five photographs had no blind in them, the
  specification choices offered frame colours that are not chosen on this
  route, the slat colours were nowhere on the colour hub, and the hero offered
  instant pricing for a product the tool cannot price. All four were inherited
  from the generic product template and none of them would have shown up in a
  check of the new component alone.
- **A pointerdown handler cannot cancel a scroll that has already started.** The
  owner reported that dragging on mobile pulled the whole page. The stage was
  `touch-action: pan-y` and the code switched it to `none` on `pointerdown`,
  which is too late: the browser commits a touch to a scroll before the handler
  runs. Fixed by putting two grab elements over the drawn magnets and giving
  only those `touch-action: none`, so a drag on a magnet is a drag and a drag
  anywhere else on the glass is still a scroll. If an element needs to take a
  drag on touch, it has to declare that in CSS before the gesture begins.
- **The two-sided slat now flips with the tilt.** A venetian presents opposite
  faces in its two closed positions, so White/Anthracite gives the room white
  one way and anthracite the other, with the swap landing at edge on where the
  slat is invisible. The cassette stays on the room-side colour, so the frame on
  that option stays white. It was previously showing white always and only a
  sliver of the reverse through the gaps, which understated the option.
- **A RAL code beats a sampled swatch.** RAL 7016 was carrying `#1A1C1B` from
  Notan's own swatch disc, which is all but black; the published standard is
  `#383E42`, a grey, Notan cite the code themselves, and the owner describes the
  colour as grey. The BY colours have no such standard, so their swatches stand.
- **The cassette is 50mm and colour matched to the slats**, from a second
  photograph of a bare unit. The magnets slot onto the slim rail at the inner
  edge of the frame rather than sitting in the middle of the member. The window
  frame had to come down in section to make room: at the showroom sample's full
  thickness plus a 50mm cassette, the two borders together swallowed the glass.
- **The blind's framework is a U, not a border.** Sides and head, nothing across
  the bottom, with the bottom rail resting on the edge of the glass. The head
  rail belongs to the blind, so it takes the slat colour; the cassette belongs
  to the unit, so it stays matched to the window frame. Lift is also inverted:
  the magnet at the top is the blind down and closed, and pulling it down
  raises it open, which is how the geared magnet runs.
- **The frame and the controls were rebuilt from the owner's photograph of the
  showroom unit**, supplied 2026-08-04. Three things were wrong and none of
  them would have been caught without it: the wide colour matched border round
  the inside of the glass does not exist, the magnets are chunky glossy blocks
  rather than slim capsules, and the frame is a stepped anthracite uPVC section
  rather than a flat bezel. Woodgrain also has to run along each profile; doing
  it both ways over the whole frame gave a crosshatch that read as fabric.
- The range inputs stayed, moved off screen rather than hidden, and are
  mirrored to the magnets both ways. Hiding them properly would have left the
  visualiser operable by pointer alone.
- **Investigate the supplier before building the thing.** The colour range was
  taken from Notan's official brochure PDF, not from their site: `our-blinds/`
  still advertises "11 standard colour choices" and the brochure lists nine.
  Two of the nine also contradict their own names, Cream being a warm grey and
  Rose Gold a greige. Both were checked twice, against the web swatch and the
  printed page, before being written down. Nothing was eyedropped from a
  photograph and nothing was invented.
- **Face on is why a canvas was enough.** With no perspective a slat projects to
  a rectangle of height `slat * |sin phi| + thickness * |cos phi|`, which is
  exact, so WebGL would have added a forbidden dependency for no accuracy. The
  Three.js rule in `AI.md` now records this as a deliberate exception so the
  next session does not read it as a breach or try to "upgrade" it.
- **Deriving the light beat tuning it.** The exterior sun never reaches the room
  face of a slat, so the base term is room ambient alone plus sky bouncing off
  the slat below. Three separate defects came from ignoring that: a near-black
  gap shadow that made the gaps read as painted stripes when in life the gap is
  the brightest thing on the window; a flat white fringe that read as a printed
  rule until it was made to thin the slat instead of paint over it, letting the
  scene tint it; and that same fringe applied equally to every colour, which
  blew White, Cream and Metallic Silver into one indistinguishable pale wash
  because a white slat has no headroom left to take glare.
- **Perfect geometry was the biggest tell.** Fifty exactly level, exactly
  pitched slats read as a printed pattern no matter how good the shading was.
  A deterministic per-slat wobble in position, brightness and about a fifth of
  a degree of lean fixed it. Derived from the index rather than `Math.random`
  so a slat keeps its character between frames instead of shimmering.
- Caching the garden, the glare, the glass and the frame, and holding the grain
  back for the settled frame, took a frame from 9.2ms to 6.0ms with the GPU
  disabled. None of those four depend on tilt, lift or colour, so recomputing
  a dozen gradients for them during a slider drag bought nothing.
- **Headless Chrome clamps its viewport to 500px wide.** A 390px screenshot is
  a 500px layout cropped to 390, which looks exactly like a mobile overflow bug
  and is not one. Load the page in a 390px iframe and measure
  `documentElement.scrollWidth` inside it instead. This cost a wrong conclusion
  about mobile overflow before it was caught.
- Verified on test by rendering the real page: controller live, canvas painting
  real pixels, `scrollWidth` equal to the viewport, every tilt and lift state
  behaving, all nine colours distinct, and a scripted colour click plus slider
  move updating both the canvas and the readout.


## 2026-08-03 - Casement and lift-and-slide promoted to live (ac6f372)

- **Live established by checksum on six theme files**, with the empty-input hash
  printed alongside so a silent miss could not read as a match. All six matched
  `d57c970`, so the recorded pointer was right for once. It was **not** an
  ancestor of `main`, so the branches had diverged.
- **The range check is what made this release safe, and the explicit-SHA rule
  would not have.** `d57c970..origin/main` was 21 commits from two authors, and
  the seven that were not mine included the scheduled blog system: 607 lines of
  `inc/blog-posts.php` wired into `functions.php`, a blog template and 299 lines
  of SCSS. The other session's own commit said the batch was awaiting review on
  test. Those commits are **ancestors of the tip**, not commits landing after
  the one being shipped, which is exactly the case the explicit-SHA rule does
  not catch. Deploying `main` would have started publishing posts to production.
- Put to the owner, who chose to ship only this session's work. Cut
  `release/casement-and-liftslide` from `d57c970` and cherry-picked the fourteen
  commits. **All applied cleanly**, because live's `d57c970` and `main`'s
  `9761138` are the same change under different hashes, so the base content
  matched.
- **Proved the compiled CSS carried none of the blog work** rather than assuming:
  rebuilt from the branch and `main.css` came back byte-identical to the
  committed one, and `fg-blog` returns zero in both source and compiled. No
  `blog-posts.php`, no `blog-post.php`, and `functions.php` does not load them.
- Whole-theme PHP lint clean. The candidate went to test first and was verified
  there before live, then test was restored to `main` so the other session's
  blog batch is still available to review.
- Backup `fenster-pre-ac6f372-20260803-162526.tar.gz` (379M, 1,783 entries)
  confirmed by grepping the SHA, not by reading the tail of `ls`. Deployed at an
  explicit SHA with a theme-only rsync.
- **`wp sg purge` failed on live: `sg-cachepress` is inactive there.** It is
  active on test, which is why the same one-liner works on one half and not the
  other. There is no CLI purge on live either: `/bin/sg` has no cache group and
  wp-cli exposes no cache commands.
- **That mattered, and briefly read as a failed deploy.** Two of the three
  changed routes served stale HTML on their plain URLs (`x-proxy-cache: HIT`,
  `s-maxage=3600`) while the files on disk were byte-identical to the commit.
  A cache-busted fetch showed the correct page throughout. **Verify a live deploy
  with a cache-buster, or the proxy will tell you the release did not land.**
- **Verified on production individually rather than by status code:** seven theme
  files byte-identical to `ac6f372`; fourteen routes 200 with the head-term
  marker intact; the casement gallery at five cells in the right order; the
  survey copy corrected and the old claim returning zero; the stock installer
  photo and its "Our own installers" caption gone; the Cranfield photo and the
  inside-shot layouts image serving; five lift-and-slide finishes on the slider
  and five switchable on the hub; five handle families on `/handle-options/`;
  zero blog markup; zero PHP notices.

## 2026-08-03 - Banner impressions verified against the tracker and the rule rewritten (docs only)

Owner: the banner is a consent popup now. Read the docs on it, verify it against
the Website Tracker, then update the docs so this stops being raised.

- **The component genuinely changed, so the old rule was written about a
  different thing.** `inc/consent.php` is a native `<dialog>` opened with
  `showModal()`. With no stored preference it opens mandatory: the `cancel`
  event is prevented so Escape cannot dismiss it, and the close control is
  hidden until a valid choice already exists. The 2026-07-13 rule was written
  against a dismissible bottom banner that reappeared on every page load, which
  is why it said impressions could not be depended on.
- **Verified end to end rather than assumed.** The theme posts
  `{choice: 'shown'}` once per page load, guarded by `bannerShownRecorded` and
  fired only from `openDialog(true)`. The dashboard maps `shown` to the
  `banner_shown` column of `website_consent_daily_v2`, keyed on environment and
  day, and rejects any other value with a 400. Nothing about a visitor, URL,
  source, device or journey is attached, so the aggregate-only privacy boundary
  holds.
- **The metric stays.** Owner instruction, 2026-08-02. `AI.md` now says so
  outright, and `HANDOVER.md` and `AUDIT.md` no longer claim impressions were
  removed. Its dependable use is a health check: a live figure of zero means the
  modal or the consent endpoint has broken.
- **It must never become a rate, and the cause is not crawler noise.** The
  tracker's own guide records 562 choices against 499 impressions on
  2026-08-03, which had rendered as "113% of visitors answered". Two
  deterministic causes were found, either of which is enough on its own.
  Footer **Cookie settings** reopens the modal through `openDialog(false)`,
  which records no impression, while saving from that panel still records a
  choice. And the v1 `website_consent_daily` rows the state query `UNION`s carry
  choices with no impressions, because impression recording was removed on
  2026-07-13 while accepts and rejects kept being written. Crawler and prefetch
  traffic moves it in both directions on top of that.
- **So impressions minus choices is not a sound abandonment figure either**, and
  the dashboard guide's line offering it for abandonment overstates what the
  number can carry. Flagged for the separate `Marketing-Dashboard` repo rather
  than edited from here.
- **Confirmed the dashboard does not misuse it.** `banner_shown` is a
  denominator nowhere in `public/app.js`: Consent Health's percentage is
  analytics-accepted over choices-answered, so it cannot exceed 100%, and the
  Overview headline is the page-view split. `shown` is read once, as an
  empty-state guard.
- Docs only. No theme change, no build, no deployment. Docs are not part of the
  theme rsync, so nothing here reaches production. Live was `c97aff4` when this
  was written, per `LIVECHANGES.md`; re-establish by checksum as always.

## 2026-08-02 - Review stars and the submit arrow, live (0b0affe)

- Live established by checksum as `32dcba6` on the files the candidates actually
  differ in, with the empty-input hash printed alongside. Range
  `1e690a2..0b0affe` was 1 commit, one author, two files. Backup
  `fenster-pre-0b0affe-20260802-154451.tar.gz` confirmed at 379M and 1,782
  entries. Explicit SHA, theme-only rsync, both caches purged.
- **The star fill floored instead of rounding.** For a 4.9 rating the fifth star
  asked `4.9 >= 5`, got no, fell through to the half case and drew four and a
  half stars beside a headline reading 4.9. So the graphic contradicted both our
  own number and the Google profile it links to, which shows five. **The
  function's docblock already said "filled to the nearest half"; the code did
  not.** Rounding the value before filling fixes every case: 4.9, 4.8 and 4.75
  give five, 4.7 and 4.4 give four and a half, 4.2 gives four.
- The accessible label still carries the true unrounded figure, so a screen
  reader hears "4.9 out of 5 stars" while the visual rounds the way Google does.
  Do not round the label to match the stars; they are answering different
  questions.
- One renderer serves the fifteen templates that show the review showcase, so
  the fix landed everywhere at once. Verified five full and zero half on seven
  production routes.
- **Submit buttons drew a literal ASCII `->`.** Now the same right-arrow glyph
  the rest of the site already used. `COPY-AUDIT.md` section 8, open since July,
  is closed.
- Incidental, and worth knowing: the summary is serving **136 reviews** where the
  hardcoded fallback in `site-data.php` says 133, which confirms the Google
  Places API is live and that the count is not the stale fallback. The fallback
  figures still rot on their own and are due a quarterly check.
- **Verified on production:** both files byte-identical to the commit; five full
  stars on seven routes; zero ASCII arrows on three; seven routes 200 with the
  head-term marker intact; no PHP notices on three routes.
- Live, `main` and test are level at `0b0affe`.

## 2026-08-02 - Bifold scrub, contact page and the consultation facts, live (32dcba6)

- **Live established by checksum as `3ec2d76` first**, with the empty-input hash
  printed alongside. **Three of the five files checked tied across two candidate
  commits**, because the last change touched neither; only `enquiry-form.php`
  and `site-data.php` separated them. That is the 2026-08-02 lesson repeating in
  a different shape: pick files the candidates actually differ in.
- Range `d7e5f34..32dcba6` was **5 commits, one author**, all reviewed on test in
  the same session and approved together. Backup
  `fenster-pre-32dcba6-20260802-152248.tar.gz` confirmed at 378M and 1,777
  entries, found by grepping the SHA rather than reading the tail of `ls`.
  Explicit SHA, theme-only rsync, both caches purged.
- **The bifold turntable stays in the first box** rather than travelling in from
  the hero, matching the heritage door. Re-encoded all-intra from the webm alpha
  master; a normal-GOP source would have reproduced the seek lag already logged
  against `prestige-slider`. `object-fit` is `contain`, not the traveller's
  `cover`, which crops the outer panels off a 900x900 render in a wide box. The
  traveller mechanism now renders nowhere and is left in place, documented, for
  a separate decision.
- **"We measure at the consultation" was false and was live in nine places**,
  including Legend's verified facts and the `/book-a-consultation/` meta
  description. The root cause was `AI.md` itself saying "measure up", which
  everything then copied. Corrected at source and in all nine: an expert goes
  through the options, any sizes taken are rough and only enough to price the
  job, and the proper measurements are the technical survey later. **A rule that
  states a fact is a source, not a description; when the fact changes, the rule
  is the first thing to fix.**
- One knock-on caught in QA: the rewritten booking meta description came out at
  177 characters against the 160 cap, and was trimmed to 146.
- **The contact page had no general enquiry form**, and it was not deliberate.
  `931c7ef` converted the existing one into the consultation booker in place,
  taking the heading, source, button label and mode with it, so the page the
  header and footer point at for "get in touch" demanded an appointment date and
  time. Restored, with the booker removed because `/book-a-consultation/` owns
  that journey and the hub card already links to it. Lead attribution goes back
  to source `Contact page`.
- **The two hub cards stopped hanging their photograph off a `z-index: -2`
  pseudo-element.** The owner reported them turning solid green and blue, which
  are the fallback colours under the images in the same shorthand. It could not
  be reproduced in headless Chrome or the in-app browser, and the images serve
  200 at full size, so the fragile construction went rather than the compositor
  being chased: a real `<img>`, no negative z-index, no reliance on the isolated
  stacking context under the consent modal's `backdrop-filter`. Right-sized on
  the way past, 2.56MB to 154KB.
- **A wrong diagnosis, recorded because it cost a round.** The first answer was
  that the consent backdrop was dimming the cards. It produces a similar-looking
  symptom and was reproducible, so it was reported with confidence. The owner's
  detail that the boxes went *green and blue* is what disproved it: those are
  `--color-accent` and `--color-steel`, the fallback layers, not a dark scrim.
  Ask what colour before concluding what dimmed it.
- **Verified on production:** seven theme files byte-identical to the commit;
  fourteen routes 200 with the head-term marker intact; the enquiry form on
  `/contact/` with zero booker markup and zero appointment inputs; the booking
  journey intact on its own page; the bifold scrub rendering once with no
  traveller markup; new image and video assets serving; the measuring claim
  returning zero on three routes; no PHP notices on five routes. Live browser
  pass at 1440 and a proven 390: card images loaded, scrub picking the mobile
  source at 390, no horizontal overflow, headings within the cap.
- Live, `main` and test are level at `32dcba6`.

## 2026-08-02 - Patio door handles promoted to live (3ec2d76)

- **Live established by checksum on four theme files**, with the empty-input
  hash printed alongside so a silent miss could not read as a match. Production
  matched `6fdf9ff` and `036c02e`, which are theme-identical, so `036c02e` was
  the range base to yield a superset. **The recorded pointer was right this
  time**, ending the run of three releases where it was not. Check it anyway.
- Range `036c02e..3ec2d76` was **2 commits, one author**, touching only the
  patio handle work: the data, the two call sites, the SCSS, the compiled CSS
  and five new image assets. No concurrent-session work in this batch.
- Backup `fenster-pre-3ec2d76-20260802-141450.tar.gz` confirmed at 378M and
  1,771 entries before deploying, found by grepping the SHA rather than reading
  the tail of `ls`, since the backups sort alphabetically. Explicit SHA,
  theme-only rsync, `wp cache flush`, `wp sg purge`.
- **Verified on production individually rather than by status code:** five
  theme files byte-identical to the commit; fifteen routes 200 with
  `/double-glazing-milton-keynes/` still carrying its head-term marker; all five
  handle assets serving `200 image/webp`; the grid on `/patio-doors/` with five
  distinct images, the foil colour grid retained beside it, and zero matches for
  "Smokey" or the long-plate markup; four families on `/handle-options/`; the
  patio grid returning zero on six other routes including the town matrix; no
  PHP notices on five routes.
- **Live browser pass at 1440 and a proven 390.** Five equal 222x249 tiles on
  one row at 1440 and 177x204 over two columns at 390, every image loaded, zero
  image/label overlap, no rectangle overlap with the colour grid above, no
  horizontal overflow, largest heading 48px against the 57.6px cap. The 390
  reading was taken through an iframe because headless Chrome on this Mac
  clamps `--window-size` to 500px.
- **Owner decision recorded: do not extend this to `/aluminium-sliding-doors/`.**
  Mila's literature says the ProLinea suits aluminium patio doors, so the
  question would otherwise be reopened by the next person to read it. `AI.md`
  now says the answer is no rather than leaving it open.
- Live, `main` and test are level at `3ec2d76` for theme content.

## 2026-08-02 - Patio door handles, the fourth handle family (test)

Owner: patio door handles are missing from the site along with their colour
options, in the same style as the other products' handles, from the Mila
ProLinea literature, and we do not offer Smokey Chrome.

- **The frame colour grid was already there.** `/patio-doors/` has carried the
  sixteen Liniar foils since 2026-07-29; checked on production before changing
  anything. What was missing was the handle and its five finishes, so "colour
  options" was read as the handle finishes. Nothing was done to the foil grid.
- **This closes the "patio to come" note** the handle hub has carried in
  `AI.md` since it was built on 2026-07-29. `/handle-options/` now runs four
  choosers; `/patio-doors/` now renders the compact grid, after the foil grid,
  which is where the other product routes put it.
- **It is its own family, not another entry in `door_handles`.** A slider moves
  sideways under its own weight and takes a fixed D-pull, not a lever on a
  backplate. That is also the reason patio, aluminium sliding, bifold and slide
  and fold were kept off the long-plate list in the first place, so adding it
  there would have contradicted an existing owner instruction.
- **Assets came out of the PDF, and the first extraction was silently wrong.**
  `pdfimages` pulled the six finishes as Adobe CMYK JPEGs, which are stored
  inverted; converted straight to sRGB they came back as a handle lit on black.
  They look like deliberate product shots on a dark background rather than
  corrupt files, which is what makes it worth recording: negate before the
  colourspace convert. Verified by rendering the page with `pdftoppm` and
  comparing. Five assets at native 299x307, one shared framing, 3-7KB each.
- **Five finishes, not six.** Smokey Chrome dropped on owner instruction. Five
  means the grid reuses the tilt and turn `--five` column count rather than
  introducing a sixth, and that modifier is already named in both breakpoint
  lists, so the specificity trap recorded twice in `AI.md` does not apply here.
- **The imagery is a different shape from the other three families** and needed
  its own rule. Mila photographs the handle on a door panel at roughly square;
  the other three are portrait cutouts on white containing into a 3:4 box.
  Contained, the patio shot letterboxes and the handle shrinks to nothing, so
  `--patio` covers a square instead, and the hub stage frames it rather than
  floating it over the shelf glow that suits a cutout.
- **The white tile needed an edge.** A white handle on a pale panel on a white
  card reads as an empty slot, the same fault already recorded for Smooth White
  on the colour rail. The hairline goes on all five so they stay a set.
- **Finish names follow the site, not the supplier.** Mila's Polished Gold,
  Polished Chrome and Smooth Satin Chrome are Gold, Chrome and Satin Silver
  here, matching the other three families. Recorded in `AI.md` so a later pass
  does not "correct" them against the literature, which is the same rule
  already written against the greenteQ bulletin.
- **Left alone deliberately, and needing the owner:** `/aluminium-sliding-doors/`
  still renders no handle section. Mila's literature says the ProLinea suits
  aluminium patio doors, but the owner asked for uPVC and Sheerline's slider has
  not been confirmed as taking it, so an assumed section would be a claim rather
  than a fact.
- Promoted to live the same day as `3ec2d76`; see the release entry above.

## 2026-08-02 - Case study card overlap fixed, live (6fdf9ff)

- Owner reported text sitting on top of the photographs in the case-study strip
  on mobile, on several pages. Self-inflicted, by this morning's change of that
  strip from grid to flex.
- **The cause was an axis, not a rule.** The desktop rule is `flex: 1 1 15rem`,
  and a flex basis is measured along the main axis, so `flex-direction: column`
  on mobile turned a 15rem width into a 15rem height. The card is a two-row
  grid, `auto 1fr`; locked to 240px its media row computed to `0px`, the image
  overflowed a zero-height row and the body started at the same y.
  `flex: 0 0 auto` on mobile hands the height back to the content.
- Measured before: `gridTemplateRows: 0px 299.953px`, media and body both at
  y 11866. After: `218.125px 299.953px`, zero overlap on every card, on casement
  windows and composite doors, with desktop unchanged at three 377px cards and a
  24px gap.
- **The verification that let it through** looked at flex-direction and card
  width and never at height. Recorded because it is the second time today a
  layout change was checked on the axis that was edited rather than the one that
  broke.
- Live established by checksum as `79cf9d4`, range two commits, backup taken,
  explicit SHA, both caches purged. Verified on production at 375: zero overlap,
  no horizontal overflow.

## 2026-08-02 - Aluminium sliding doors rebuilt, live (79cf9d4)

- Live established by checksum as `c88412d` on four theme files, with the
  empty-input hash printed alongside. `assets/css/main.css` was identical across
  both candidates, so the JavaScript, `site-data.php` and `assets.php` were what
  discriminated; one file is not a checksum sweep. Range `c88412d..79cf9d4` was
  12 commits, one author. Backup `fenster-pre-79cf9d4-20260802-120522.tar.gz`
  (378M, 1,767 entries) taken first. Explicit SHA, theme-only rsync, both caches
  purged.
- **The page was measured against Sheerline's own patio page.** The gap was not
  imagery, it was that ours carried no figure a customer could act on: "lift and
  slide style", "large panels with slim interlock options", "stainless track
  details where specified". It now states 106mm frame and sash, 80mm or 52mm
  interlock, 6.5m by 2.5m maximum, 400kg a sash, three threshold heights and
  PAS 24, in a two-part detail section built on the casement split grammar the
  heritage page already reuses.
- **The slider turntable existed after all.** `alislider.mp4` was in OneDrive
  under Marketing/Image Bank/Legacy Marketing/Sheerline web assets. A previous
  session's note that there is no scrape on this Mac was taken too far; the
  image bank is a separate place and it is worth looking there first.
- Section order moved onto the heritage rhythm: the technology banner sits with
  the sections that explain it rather than stacked on the specification strip,
  the detail sections come before the gallery, and the process rail is gone.
- **Two image faults, one reported and one self-inflicted.** The owner spotted a
  bifold photograph in the slider gallery, alt text and all. Removing it dropped
  the pool from nine entries to eight and the mosaic vanished silently, because
  it renders `array_slice($images, 4)` and wants four of them. The replacement
  then turned out to be the same photograph as the hero at a different crop,
  0.85% RMSE apart against 39% for two genuinely different shots. **A duplicate
  check on filenames cannot see that**; compare the pixels.
- Hero is now the aspirational three-pane and the old brick hero is reused in
  the mosaic, on the owner's instruction. Flagged at the time: the new hero is a
  render where the one it replaces was a photograph.
- **The scrub window was wrong at both ends before it was right.** Across a full
  pass the last frames only arrived after the element had left the top of the
  viewport, so the handle turn was never seen. Finishing at centre fixed that
  and pushed the opening frames below the fold. It now runs from half visible to
  centred, which is half a viewport of scroll whatever the element's height.
- **The lag was the encoding, not the controller.** `prestige-slider.mp4` had
  one keyframe in 101 frames, so every seek decoded from frame zero. All three
  scrub videos are all-intra now, with a half-width mobile encode listed first.
  Measured on production: seeks median 2.2ms at 1440 and 1.5ms at 375, against a
  16.7ms frame budget.
- **Verified on production:** seven theme files byte-identical; fourteen routes
  200 with the head-term marker; the turntable and its mobile source present;
  twelve swatches; no process rail; the bifold photograph gone; nine slider
  images with no duplicates; the 106mm and 6.5m figures serving; no PHP notices
  on five routes; no console errors; no horizontal overflow; headings at cap.

## 2026-08-02 - Heritage doors and the aluminium colour grids, live (c88412d)

- Live established by checksum as `64f4e51` on four theme files, with the
  empty-input hash printed alongside so a silent miss could not read as a match.
  Range `64f4e51..c88412d` was 7 commits, one author, all of it reviewed on test
  in the same session. Backup `fenster-pre-c88412d-20260802-110844.tar.gz`
  (378M, 1,763 entries) confirmed before deploying. Explicit SHA, theme-only
  rsync, `wp cache flush`, `wp sg purge`.
- **Heritage doors:** the Classic turntable now fills the first slot after the
  hero, scrubbing in place rather than travelling like the bifold. The kitchen
  photograph it displaced moved into the second "Two jobs" card, which removes
  the one repeated image on the page. Numbering off those two cards, Real homes
  given its own padding, the Wolverton install added as the gallery's lead in a
  tall cell so the portrait is not cropped, the mechanical corner-cleat shot
  removed so the thermal cut-through takes the column, and the case-study strip
  rebuilt on flex.
- **The case-study spacing had a specific cause.** `auto-fit` collapsed the empty
  tracks and split the row between the survivors, so two studies sat in 578px
  tracks holding 416px cards: a 186px visual gap while `gap` read 24px. Flex
  fixes it for every count and wraps as more studies load.
- **Aluminium windows** show the Prestige profile turning instead of a still of
  the same corner. Scrub routes now live in `fenster_product_scrub_videos()`,
  separate from the traveller map, because anything in the traveller map gets
  traveller markup rendered for it and would otherwise get both treatments.
- **The five aluminium routes carry the colour grid** in the heritage layout,
  through `aluminium-colour-grid.php`, the counterpart to the existing uPVC
  grid. Both read `colour_options`, so the hub stays the single source. Heritage
  doors is deliberately excluded: its range stops at dual and bespoke on
  request rather than the any-RAL match these five carry.
- **Agate Grey is RAL 7038**, owner-confirmed. `site-data.php` said 7018, which
  is Umbra Grey, and disagreed with the heritage door page. It fed the colour
  hub as well as the five new grids.
- **A layout bug reached the owner and should not have.** The colour grid was
  added to the container rule and to none of the three rules that place its
  children, so the eyebrow lost its full-width span, the h2 auto-placed into
  the second column at default size and the copy fell beneath the eyebrow. The
  selectors had been added by script and reported "8 of 8", which was the script
  counting its own patterns rather than proof the layout was complete, and the
  browser pass measured columns, tiles and overflow but never the heading. The
  check is now a diff of every selector naming the uPVC or heritage colour grid
  against its aluminium counterpart.
- **Verified on production** rather than assumed: seven theme files byte-identical
  to the commit; thirteen routes 200 with the head-term marker intact; the
  turntable, four-cell gallery, Wolverton image and heritage-windows link all
  present; corner-cleat and 01/02 numbering returning zero; the colour grid on
  exactly the five routes with twelve swatches each; RAL 7038 serving and 7018
  returning zero on all five and on the colour hub; the new video and image
  assets serving; no PHP notices on five routes; and a live browser pass showing
  the corrected heading placement, no horizontal overflow and no console errors.

## 2026-08-02 - Promoted to live (64f4e51)

- **Live established by checksum first**, not read from a doc: four theme files
  matched `289b2c2` (theme-identical to tip `f37e05d`) byte for byte. The
  empty-input hash was printed alongside the sweep so a silent miss could not
  read as a match, and the `${sha}:path` brace trap was respected.
- Range `f37e05d..64f4e51` was **74 commits, two authors**: the tracking-repair
  merge and its six fixes, the heritage doors rebuild, the casement intro and
  banner move, the Wolverton case study and gallery ordering, the privacy glass
  card run including the Satin swatch correction, the cookie consent polish and
  the case-study pricing default. All had been verified on test. The range was
  put to the owner, who reviewed test and approved shipping it whole.
- Backup `fenster-pre-64f4e51-20260802-093342.tar.gz` confirmed at 375M and
  1,739 entries before deploying. Theme-only rsync at an explicit SHA,
  `wp cache flush`, `wp sg purge`.
- **Verified on production individually rather than by status code.** Eight
  theme files byte-identical to the commit; fifteen routes 200;
  `/double-glazing-milton-keynes/` still carries its head-term marker. Heritage
  doors serves the `productCollection=12` embed with the false "not on the
  instant quote tool" sentence returning zero matches, and the shared
  full-width hero. The Wolverton study returns 200 and reads consultation while
  Broughton reads the quote tool. `/obscured-glass/` serves `feTurbulence`
  grain. No PHP notices leak on four routes.
- **Security fix confirmed live.** The conversion feed returns 401 for no auth,
  for the default username with an empty password, and for a wrong password.
  A 503 would have meant the fix broke the configuration; it did not. The
  non-blocking Meta relay and the shared phone helper are both present, and the
  old `'0'`-before-`'0044'` branch returns zero matches in both files.
- **Live, `main` and test are now level at `64f4e51`.** The divergence that
  opened on 2026-07-30 is closed in both directions.
- Banner impressions stay, on the owner's explicit instruction. `AI.md` still
  carries the older rule against them; that rule is superseded for the consent
  modal and should be read as such. **Closed 2026-08-03: the rule was rewritten
  and no longer contradicts the metric.**

## 2026-08-02 - Tracking repair merged into main, with six fixes on top

The `codex/tracking-repair` divergence is closed. `main` is now a superset of
the live runtime, so a release from it no longer deletes the Ads work.

- **Merge.** Six conflicts, none of them in the product templates the earlier
  note warned about: `heritage-aluminium-doors.php`, `casement-windows-v2.php`,
  `case-studies-residential.php` and `generated-page.php` all merged cleanly,
  because the branch had been cut after that work landed. The real conflicts
  were `inc/consent.php` and `src/js/main.js`, where every hunk was the branch
  evolving main's own code rather than competing with it, plus the two compiled
  assets and two docs. Compiled CSS and JS were **rebuilt from merged source**
  rather than hand-merged, then checked to carry both sides (`fg-colour-rail`,
  `fg-cw-`, `fg-handle-finishes` and `fg-cs-quote-note` alongside
  `fg-cookie-consent` and `fenster_form_submitted`).
- **Auth bypass in the conversion feed, closed.** `hash_equals('', '')` is true,
  so with a feed token configured and the password left unset, the hardcoded
  default username plus an empty password authorised the whole feed: up to 500
  records of click IDs and SHA-256 email and phone hashes. Live was never
  exposed, confirmed by probing production for status codes only (401 on no
  auth, on an empty password and on a wrong password), because the password is
  configured there. It was one config change away: the token path exists
  *because* Data Manager's fetcher loses the Authorization header, so dropping
  the password is the natural next step for whoever operates it. Basic auth is
  now only offered when both halves are set, and fails closed otherwise.
- **The Meta CAPI call no longer blocks the lead path.** It ran `blocking` with
  an 8 second timeout immediately before the enquiry success response, so an
  unreachable `graph.facebook.com` would have held every customer's form
  submission for up to eight seconds. Now non-blocking. Same lesson as the
  AdminBase cURL 60 outage on 2026-07-21: attribution must not be able to take
  the lead down with it.
- **Meta access token moved out of the query string** into the request body, so
  it cannot land in whatever logs a failed request.
- **UK phone normalisation was silently dropping `0044` numbers**, in both the
  feed and the Meta payload. Digits are stripped first, so `0044...` also
  starts with `0` and took that branch: `00441908...` became `440441908...`,
  failed the E.164 check and was discarded. The `0044` branch could never run.
  One shared `fenster_normalise_uk_phone()` now serves both, longest prefix
  first, unit-tested across seven formats.
- **The feed no longer truncates the newest conversions.** It read 500 posts
  ordered oldest-first over an 89 day window, so once volume outgrew the cap it
  was the new rows that fell off. Now newest-first at 2000; Google dedupes on
  `order_id`, so re-sending an older row is free.
- **Client-asserted consent flags: documented, not "fixed".** The review called
  for verifying `analytics_consent` and `marketing_consent` server-side. That
  is not possible: `fenster_cookie_consent` lives in local storage and is never
  written to a cookie, and the generated Privacy Policy tells visitors exactly
  that. Mirroring consent into a cookie to satisfy the check would have made a
  published policy statement false. The trust boundary is now recorded in
  `inc/enquiries.php` instead, with a warning not to "harden" it without
  changing the policy first.
- **Flagged, not changed: banner impressions are back.** The branch records a
  `shown` consent metric on the mandatory modal. `AI.md` and the 2026-07-13
  entry both say not to reinstate banner-impression counts, because pre-consent
  crawler traffic makes them undependable. It is already live, and the
  dashboard may now depend on the value, so it was left alone rather than
  silently reverted. ~~**Owner decision needed.**~~ **Closed 2026-08-03:** the
  metric stays and `AI.md` now says so. The crawler objection turned out not to
  be the real problem either; see the 2026-08-03 entry.
- `GOOGLE-ADS-PLAN.md` section 3b was stale in both directions and now reads
  true: Consent Mode v2 defaults do exist, gclid capture is done, and the part
  that genuinely remains open is that GTM still only loads after a choice, so
  refusing visitors send no denied-state pings.
- All theme PHP lints clean on PHP 8.2.32. Production build passes.
- **Live is untouched and has not moved.** Re-establish it by checksum before
  the next release.

## 2026-07-31 - Polished cookie consent and Legend fix promoted live (616d673)

- Rebuilt only the approved consent and Legend changes on exact Ads production base `814b8bf` as scoped branch `codex/cookie-consent-live`; `814b8bf..616d673` changes only consent markup/logic, generated policy copy, consent-aware JavaScript, consent styles and their compiled assets. The separate privacy-glass test batch was not included.
- Re-deployed that exact candidate to protected test before release. Candidate checksums matched every deployed test file; six routes returned 200; desktop and 390x844 browser QA confirmed first-layer Customise / Accept all, green enabled switches, zero horizontal overflow, Legend hidden at offset zero while the modal is open, Legend restored afterward and the 420px panel opening normally. No console errors.
- Created `~/backups/fenster-theme/fenster-pre-616d673-20260731-082054.tar.gz` before promotion (375M, 1,739 entries), then extracted it and compared the complete archive with production; no differences were found.
- Promoted exact SHA `616d673` with a theme-only rsync and purged WordPress and SiteGround caches. All changed files and the six production Ads attribution/feed files checksum against the candidate, and homepage, quote, casement, Milton Keynes, Cookie Policy and Privacy Policy routes all return 200.
- Clean-origin live browser QA confirmed optional scripts are absent before consent and after necessary-only, while accept-all loads GTM, Clarity and Meta. Legend stays hidden while consent blocks the page, returns at `0px` after a choice and opens its full 420px panel. No console errors.
- Restored protected test to `main` (`0c1d567` theme code, `5081b4d` docs) after promotion so its separate privacy-glass review batch remains available. The unrelated local `GOOGLE-ADS-SETUP.md` edit was left untouched.

## 2026-07-31 - Legend/native cookie modal regression fixed and consent UI polished (test, 0c1d567)

- Owner correctly reported that the cookie work had disturbed Legend. A full comparison of the pre-cookie production backup with rollback commit `814b8bf` showed no file differences, so the rollback did not delete Legend code. The regression was in the new test code: Legend's offset observer still understood only the old bottom banner's `hidden` state, not a native dialog's `open` state.
- Legend now observes both `hidden` and `open`. An open native cookie modal gives Legend an explicit `is-cookie-modal-open` state, hiding the launcher and panel completely; closing the modal removes that state and restores Legend at `--legend-cookie-offset: 0px`. The old measured offset remains available for the legacy bottom banner.
- Reworked the consent panel into a tighter 680px Fenster card with a steel/green accent rail, softer branded backdrop, clearer hierarchy, an optional-cookie notice, refined buttons/cards and a compact phone layout.
- Found and fixed a second styling fault during browser QA: the consent component used nonexistent token `--color-primary`. It now uses the real `--color-accent` token. The analytics and marketing inputs remain native accessible checkboxes, while separate presentation tracks make their state unambiguous across the test browser's form-control styling.
- Production build and PHP lint pass. Five protected-test routes return 200. At 1280x720, opening the modal hides Legend and closing it restores the launcher and full 420px chat panel at offset zero. At 390x844, the first layer is 374x516, contains only Customise and Accept all, fits fully with no horizontal overflow, and hides Legend. Custom switches render green when enabled. No console errors.
- Test deployment only. Production remains byte-identical to `814b8bf`.

## 2026-07-30 - Cookie consent live release rolled back (814b8bf)

- Owner asked to revert production to the state immediately before the granular consent promotion. Test and source history were left intact.
- Confirmed live was still byte-identical to `23d31c4`, then reset the server repo to explicit pre-release Ads production commit `814b8bf`, performed a theme-only rsync and purged WordPress and SiteGround caches.
- Twelve representative live theme files match `814b8bf`. Homepage, quote, casement, Milton Keynes, Cookie Policy and Privacy Policy routes all return 200.
- Browser verification confirms the previous non-modal Cookie choices banner is restored with Reject and Accept, no Customise control, no inert page, no optional scripts before acceptance, zero horizontal overflow and no console errors.

## 2026-07-30 - Granular cookie consent promoted to live (23d31c4)

- The live checksum preflight found a mixed but coherent production state: the previous `572fe3c` visual baseline plus the separately released Ads attribution/feed work, theme-equivalent to the Ads release tip. Deploying `main` would have removed that live Ads work and shipped the unrelated privacy-glass test batch.
- Rebuilt the approved cookie work as scoped branch `codex/cookie-consent-live` from `814b8bf`. Range `814b8bf..23d31c4` is five commits, one author, and only six theme files: consent markup/logic, generated policy copy, consent-aware JavaScript, consent styles and their compiled assets.
- The final phone pass also gave the footer Cookie settings control a direct listener instead of relying only on delegated page clicks. PHP lint and the combined production CSS/JavaScript build passed.
- Deployed the exact candidate to protected test first. All six changed files matched by SHA-256, five routes returned 200, necessary-only loaded no optional scripts, accept-all loaded GTM/Clarity/Meta, no browser console errors appeared, and the 390x844 modal fitted at 374px wide without page overflow.
- Confirmed fresh rollback archive `~/backups/fenster-theme/fenster-pre-23d31c4-20260730-145622.tar.gz` before live deployment (375M, 1,739 entries). Production used an explicit-SHA theme-only rsync followed by `wp cache flush` and `wp sg purge`.
- Live verification passed: six changed files byte-identical to `23d31c4`; homepage, quote, casement, Milton Keynes, Cookie Policy and Privacy Policy routes all 200; a clean first visit exposed exactly Customise and Accept all with no close control or optional scripts; Escape stayed blocked; Customise started both optional switches off; necessary-only and accept-all behaved correctly; footer settings reopened; no console errors; and the 390x844 dialog fitted without horizontal overflow.

## 2026-07-30 - Mandatory, granular cookie choices (test)

- **Owner follow-up: only Customise and Accept all on the first layer.** Use necessary only remains inside Customise with both switches off by default. This is one more click to refuse than to accept and is therefore weaker than the ICO's equal-ease recommendation; the durable docs say that plainly rather than mislabelling it as equivalent.
- Replaced the dismissible bottom banner with a native first-visit modal. The page remains inert until the visitor chooses **Customise** or **Accept all**; Escape cannot dismiss the mandatory state. The Cookie Policy remains reachable from inside the modal.
- **Superseded by the owner follow-up above.** The initial version kept refusal as easy as acceptance, with necessary-only and accept-all as equal-size first-layer controls. Necessary-only now sits on the custom layer instead. The analytics and marketing switches still start off, and no optional category is required to use the website.
- Versioned `fenster_cookie_consent` as a granular JSON preference lasting 180 days. Old accepted/rejected strings are invalidated so existing visitors see the clearer choice once. Footer **Cookie settings** reopens the same panel, with a close control only after a valid choice already exists.
- Split the tracking boundary. Analytics permits Microsoft Clarity, `FGV`/`FG2` website journeys and analytics tags. Marketing permits Meta, advertising tags, persisted ad click IDs and browser-side advertising conversion events. Google Tag Manager loads only when one of those categories is granted and receives category-specific Consent Mode defaults and updates first.
- Withdrawing a category sends denied signals, removes its known first-party cookies and local identifiers, then reloads without the withdrawn scripts. The Clarity replay stylesheet still loads before Clarity itself.
- Updated the generated Privacy Policy and Cookie Policy with the category purposes, providers, 90-day site identifier retention, 180-day preference duration and withdrawal behaviour.
- **The first protected-site browser pass caught a bypass before handoff.** The close button carried `hidden`, but its later component rule declared `display: grid` and overrode the browser default, so it still appeared on the mandatory first layer. A component-specific hidden rule now wins; the close control appears only when a visitor with a saved choice reopens settings.
- Shipped to the protected test site through theme commit `37222a2`. PHP lint, JavaScript syntax checking and the production CSS/JavaScript build pass. Five representative routes return 200.
- Browser QA passed at 1280x720 and a true 390x844: mandatory Escape leaves the first modal open, the first layer has no close control, all mobile controls fit with no horizontal overflow, the custom switches are off on a fresh choice, necessary-only loads no optional scripts, analytics-only loads Clarity but not Meta, marketing-only loads Meta but not Clarity, accept-all loads both, the Clarity replay stylesheet precedes Clarity, withdrawal reloads without the removed category, footer settings reopens with saved values, and the updated policy sections render. No browser console errors.
- Follow-up verification on `7d6c84c`: a clean first visit exposes exactly **Customise** and **Accept all**, Customise exposes **Use necessary only** with both optional switches off, choosing it closes the modal with zero optional tracking scripts, and the two-button first layer fits at 390x844 with no horizontal overflow.
## 2026-07-30 - Google Ads quote-completion attribution (live release)

- Owner clarified that the quote iframe auto-loads on quote-enabled pages, so `quote_opened` and `quote_iframe_loaded` are funnel diagnostics, not conversions. The paid goal is a completed WindowCAD submission.
- Google campaign suffixes now use `ads={adgroupid}`. The theme preserves that real ad-group number across a consented visit and copies it into every WindowCAD URL while keeping the existing `tracking=FG2-...` journey reference separate.
- Accepted `gclid`, `gbraid` and `wbraid` values are joined to the opaque FG2 journey in WordPress for 90 days through the same-origin `/wp-json/fenster/v1/ad-attribution` endpoint. The WindowCAD callback writes the click ID and `ads` tracker to the private enquiry for offline Google Ads import. Click IDs never enter the Marketing Dashboard or AdminBase notes.
- Website forms now save the same `ads` tracker beside their existing click ID. The enquiry list shows both under `Ad attribution`.
- Corrected the dataLayer event construction so its intended `fenster_*` name cannot be overwritten by the unprefixed payload event, and moved the post-accept visitor/page listener from `document` to the `window` that actually dispatches the consent event.
- Isolated the production release directly on the checksummed live runtime `572fe3c`, avoiding the unrelated visual commits in the original test branch. Built the compiled JS and PHP-linted every changed include/template.
- Deployed exact commit `c87391f` to the protected test site first. The quote link carried `tracking=FG2-284F8566C4E94E7DAC&ads=12345678901`, and WordPress stored the matching test `gclid` and ad-group tracker.
- Took the verified rollback archive `~/backups/fenster-theme/fenster-pre-c87391f-20260730-120759.tar.gz` (375M, 1,738 entries), deployed the same commit to production, and flushed both WordPress and SiteGround caches.
- Production verification passed: all six changed runtime files matched the commit byte for byte; eight representative routes returned `200`; the dedicated head-term marker remained present; and a cache-busted browser test produced `tracking=FG2-AAEEB743178E4E16B3&ads=12345678901` with the matching `gclid` and tracker recoverable server-side.
## 2026-07-29 - Two open handle questions closed by the owner (docs only)

- **Tilt and turn takes a different handle family, not S2.** The open item read as though the page was missing something; it was not. Adding the S2 grid there would have put the wrong hardware on the page, which is the more expensive mistake of the two. Details to follow from the owner, so the grid stays off until they arrive.
- **Bow and bay is a configuration, not a product.** A bay can be built from most of the range and from every window style, so the route owns no handle, no system and no specification of its own. Closed the same open item on that basis.
- Both recorded in `AI.md`, the handle fact under the Window Handle Section Rule and the bay fact under Owner-Confirmed Business Facts, so a later session cannot reopen them as gaps. `nick.md`'s open list struck through rather than deleted, since the reasoning is the useful part.
- **Found while checking:** the bow and bay hub entry named only casement, flush sash and sliding sash. Flagged to the owner, then fixed the same day. See the entry below, including the correction to where that copy actually lives.
- No code change, no build, no deployment.

## 2026-07-29 - Hub range three by three, and the bay claim corrected (test, 9234ca5 + follow-up)

Owner instruction: nine tiles over two uneven rows would look better as a square.

- **Nine tiles now go 3x3** via `.fg-ph-tiles[data-count="9"]`. Seven are untouched at four then three. Tiles measure 384x225 at 1440, a 1.7:1 landscape crop that the photography takes without a problem.
- **A bug introduced and caught before reporting.** An attribute selector is (0,2,1) and beats the bare `.fg-ph-tiles` in the two mobile media queries, so the nine-tile hubs would have kept three columns all the way down to a phone. Every count must be named in both breakpoint lists; there is now a comment saying so. This is the same specificity trap already recorded against `.fg-product-hub > section`, in a second place.
- **Correction on the bay copy, recorded because the first diagnosis was reported to the owner before it was checked.** The hub tile renders only `name` and `fit`; the card paragraph came out on 2026-07-24, so `product_hub_groups[*].products[].copy` is dead data and editing it changes nothing a customer sees. The claim a customer actually reads is the `/bow-bay-windows/` benefit card in `product_content`, and it was narrower still: "other suitable **uPVC** window styles", which excludes the aluminium range outright. That is the one now fixed. The hub field was left corrected as well so it cannot mislead if that paragraph ever returns.
- **The 3x3 grid costs the one-viewport rule, and that needs an owner decision.** Measured at a true 900px viewport: windows ends 1108px down (over by 208), doors 1040px (over by 140). Services is unchanged and still fits at 846px. Three rows plus the hero cannot fit 900px unless tile height drops to about 155px, which is a 2.5:1 letterbox. `AI.md` still carries the 2026-07-24 one-viewport instruction; it has not been rewritten, because reversing an owner rule is the owner's call.
- Verified on test at 1440, 768 and 390: 3 / 2 / 2 columns, no horizontal overflow at any width, the new bay copy serving and the old uPVC-only string returning zero matches, six key routes 200.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Colour hub: an equal-size swipeable rail (test)

Owner: the colour UI should work like the Sheerline frame-corner display, everything the same size and swipeable. At the moment the front one is massive and they stack too much. Apply to all collections.

- **Reference read from the source rather than guessed.** A text fetch of the Sheerline page missed the component entirely, so the markup was inspected instead: a Swiper rail at `w-7/12 lg:w-4/12 xl:w-3/12`, equal slides, no centred hero. That is four across, three at tablet and about 1.7 on a phone, which is what was built.
- **Built as `.fg-colour-rail`, a new component.** `.fg-colour-carousel` and its 225-line coverflow controller are shared with the heritage door configurations, which was not in scope; rewriting the shared class would have changed a page nobody asked about.
- **Then the owner asked for swipe rather than buttons.** Touch and trackpad already scroll natively; the controller adds click-drag for a mouse, disables snapping mid-drag so the rail follows the hand, and suppresses the click that ends a real drag so dragging cannot open a swatch. The counter went too, in the follow-up below.
- **Two sizing bugs, both found by measuring at three widths rather than one.** A percentage flex basis inside an overflowing flex row resolves against the track's scroll width, so slides hit 848px; the list is now the scroller and a column grid. Then the mobile override used `grid-template-columns: 1fr`, whose implicit auto minimum stopped the rail shrinking, so it sized itself to its slide count and each collection came out a different width. `minmax(0, 1fr)` fixed it. **At 1440 both bugs were invisible.**
- **Two content faults the rail exposed.** The Renolit swatches carry a supplier label strip along the bottom, so a square crop published "RENOLIT FOIL S3030700005"; the existing grid already cropped it at `1.42` from the top and the rail now matches. And smooth white, which has no swatch photograph, was rendering white on a white card and reading as an empty tile.
- **Hipca Gloss White had no `image` key at all**, so it fell back to a flat hex while every other aluminium colour showed a Sheerline corner. `Classic-Corner-Gloss-White-600.jpg` was already in the theme and had simply never been wired up. Owner spotted it.
- The colour deep links case studies rely on are carried over intact, including the Lenis pause-and-reassert dance.
- Verified on test: three rails, identical slide widths at 1440, 1000 and a true 390, every image loaded, scrollable at every width, no horizontal overflow, no buttons left in the markup.
- Test deployment only. Live is still `834b424`.

## 2026-07-29 - Privacy glass card: the lone 01, and glass that looks like glass (test, a8428b1)

Owner: the privacy glass box on product pages has a 01 that makes no sense now, and could it be styled like satin glass with the title etched in, might look bad.

- **The number was a real bug.** The three specification cards numbered themselves as they printed, which reads fine at three. On the routes that show the uPVC colour grid and the handle grid inline, both of those cards are suppressed, leaving the glass card alone and labelled "01". A single numbered step is not a sequence. The cards are built as a list first now and numbered only when there is more than one.
- **The card wears the real Satin texture from `obscure_glass`**, not a pattern invented in the stylesheet, so it shows the same glass as the page it links to.
- **Engraved, not etched, and that was a deliberate refusal.** A true etched title is lighter than its background; on a pale pane that is text nobody without good sight can read. Dark type with a crisp white highlight beneath reads as cut into the surface and keeps full contrast.
- **The first attempt was nearly invisible.** Satin is built from 1px dots and 3px stripes, sized for a small swatch. Dropped on a card at its own scale, under a white wash, it read as faint noise. Drawn at 200px on the pane itself with the wash removed, it reads as glass.
- **Two layout faults the card exposed, one of them self-inflicted.** `auto-fit` collapses empty tracks, so the lone card stretched across the full 980px row and looked like an empty pane. Switching the base to `auto-fill` fixed that and broke the two-card case, leaving them at 305px with an empty 337px track hanging off the row. The base is back to `auto-fit` and the one-card case belongs to a `--single` modifier. **The fix for one count broke another count, which measuring only the page that prompted the change would have missed.**
- The modifier is written after the base rule, not above it. Both are single-class selectors, so source order decides, and above it the base `grid-template-columns` simply won.
- Verified on test at 1440: one card centred at 380px with no number, two cards at 474px each filling the row and numbered 01 and 02, no horizontal overflow.
- **Owner rejected the first attempt, and was right about why.** "Satin is a sandblasted finish not pinstripe." The card had been given the Satin swatch straight from the data, and that swatch is a hand-drawn CSS gradient containing a `repeating-linear-gradient`. Faithful to the data, wrong about the product.
- **The same error was live on `/obscured-glass/`.** Every other texture in `obscure_glass` is a photograph of the real glass; Satin was the one drawn by hand, and drawn wrong, so the swatch showed diagonal lines while its own copy called it plain satin frosting. Replaced at source with `feTurbulence` grain, which is what sandblasting looks like, then lifted from 0.38 to 0.55 with a sheen because at the first setting it vanished on a 40px tile and read as a blank white card next to photographed neighbours. **This was a live content fault found only because the owner questioned a decorative choice.**
- **The card rebuilt as a real pane.** Frost is turbulence grain. The brand mark, extracted from the logo artwork rather than redrawn, is cut *through* the frost rather than drawn on top: the frost layer is masked by a full-cover gradient minus the mark, so the smooth pane underneath shows where the mark is. That is how etched signage works, and it is what makes it read as glass. A drop shadow on the frost layer lands along the inside of the cut, which is the catch-light that separates an etched edge from a printed shape.
- Where `mask-composite` is unsupported the mask falls back to covering everything: the mark is lost and a plain frosted pane remains, rather than the card breaking.
- The lone card spans the row again, per the owner. It read as empty when it held only copy; with the pane beside the text it has a reason to be wide.
- Verified on test at 1440: card 980x260, two mask layers composited `xor`, turbulence serving, no horizontal overflow, and the pinstripe gradient returning zero matches on the glass page.
- **Owner rejected the etched version too: not working, and the F behind is glitchy.** The verdict was right and the cause was predictable. Cutting the mark out of a frost layer needed `mask-composite` plus a `drop-shadow` filter applied to a masked pseudo-element, which is exactly the combination browsers implement inconsistently. **Two clever techniques stacked on one element is a bet, not a design.**
- **Rebuilt as a panel of the real patterns.** Eight photographs from `obscure_glass`, curated for variety, gaps reading as the leading between panes, fading into the card on a single-layer linear mask. No compositing, no filters, no invented texture, and it shows the actual product. Four panes as a bottom strip under 720px. The extracted mark asset was deleted rather than left behind.
- **One collision, found by measuring not looking.** The card styles its number badge as `> span`, so the panel, also a span, inherited `position: relative` and `width: fit-content` and collapsed to 15x9px with zero-sized panes. On the render it was a faint dot in a corner and easy to read as "the images did not load". It is an `<i>` now. **A generic child selector on a component is a trap for the next element added to it.**
- Verified on test: panel 587x258 with eight 143x125 panes at 1440, 364x119 with four panes at a true 390, no horizontal overflow at either.
- **Owner: slimmer, one glass square high, and parallax the mark behind the glass.** Card slimmed to 180px, one row of panes, mark behind them shifting on scroll.
- **Square is not the same as one row.** A five-column grid divides the panel width, which gave panes 113 wide by 178 tall: one row, and not square. Flex with `aspect-ratio: 1` takes each pane's width from the card's height instead, so they are actually square at 178x178 and however many fit, fit; the rest run off the left behind the fade.
- **The leading is drawn inside each pane, not as a grid gap.** A gap would show the mark un-glazed between panes, putting the logo in front of the frame rather than behind the glass.
- **No blend mode.** Slightly transparent panes over a blurred mark carry the same read and cannot be composited inconsistently, which is the mistake the etched version made.
- **Two faults in the first parallax, both mine.** Travel was unclamped, so a card far down a long page computed a 120px offset before it had ever been on screen. And updates were gated on an IntersectionObserver, so when the observer did not fire the mark kept its startup offset and never moved. Clamped to one viewport, observer dropped: one `getBoundingClientRect` per scroll for one element is not worth guarding.
- **Verified against geometry, not scroll position.** `window.scrollTo` does not move this page, because Lenis owns the scroll, exactly as `nick.md` warns. Moving the card through the viewport instead and reading the transform gives -5.64, 13.55 then 26: monotonic, within the clamp, and responding to the thing a real scroll actually changes.
- 980x180 card with five 178x178 panes at 1440; 366x163 with 86x86 panes at a true 390; no horizontal overflow at either.
- **Owner: the F icon ruins it, remove it and leave the rest.** Dropped cleanly: the mark element and its background image, the parallax script in full (nothing else read `data-fg-parallax`, confirmed by grep before deleting), the mark's own CSS including its mobile and reduced-motion rules, and the extracted `fenster-mark.png` asset, confirmed unused first. The five-pane panel, its square aspect, the inner leading, the fade into the card, the slim height and the wide single-card layout are all unchanged.
- Verified on test: mark markup absent, panel still serving five real pattern photographs.
- **Owner: mobile text is hard to see, desktop box is not wide enough for the screen.** Two independent faults, both measured before touching CSS.
  - **Desktop:** the choice map caps at 980px so two or three cards do not stretch into empty padding, and a lone card inherited that cap for no reason, sitting 200px narrower than the 1180px container around it. The `--single` modifier now lifts the cap.
  - **Mobile:** measured the actual overlap rather than guessing at it. The CTA line sat 115-141px from the card top; the patch's own fade left the band visible only from about 124px down, so "Compare glass patterns" was printed directly over visible glass texture, dark green on a busy grey pattern. The panel now drops into normal document flow below the copy instead of overlaying it, moved there with `order` since the markup puts it first so it can act as a right-hand backdrop on desktop.
- Verified at both real widths: 1180x180 card exactly filling the container at 1440, zero rectangle overlap between the panel and any of the heading, copy or CTA at a true 390. The desktop bounding boxes still overlap by design, since the panel is a right-hand backdrop that fades to invisible under the text, and that was true before this fix too.
- **Owner: mobile now too disjointed, wanted a bit of a fade back on the images.** The strip filled part of its width with five squares and then stopped dead against blank space, no longer overlapping the copy but not blending into the card either. Added a horizontal mask on the last pane only, checked against the real geometry rather than guessed: five 59px panes fill 0-293px of a 326px strip, and the fade set to start at 72% lands at 234px, exactly the boundary of the fifth pane, so it dissolves the last square rather than fading empty space or cutting into a whole one.
- **Owner: still not faded, and clarified the vision — squares filling the box, fading at the top before the text.** The right-edge fade only touched about a third of the last of five squares and was too subtle to register, confirmed against the owner's own screenshot. Replaced with a vertical fade on the strip's own top edge: it dissolves into the space above rather than starting on a hard line, and the fade sits well below where the copy ends, so it is not a return to the absolute overlay that used to sit behind the text.
- Verified at a true 390: strip 326x66, mask reads `linear-gradient(transparent 0%, #000 55%)`, 23px gap between the CTA and the strip, zero rectangle overlap between the strip and the heading, copy or CTA, screenshot confirms a visible dissolve rather than a hard top edge.
- Test deployment only. Live is `572fe3c`.

## 2026-07-29 - Heritage doors on the shared full-width hero (test, e3af760)

Owner: `/heritage-aluminium-doors/` should have a full width hero image like other pages.

- It was the last product route still on its own boxed hero: a two-column layout with the photo in a 6:5 card beside the copy. It now uses the same `.fg-hero fg-hero--compact` section as casement, sash and the rest.
- **The old hero photo was the wrong shape for the job.** It was the 1600x1334 interior kitchen shot, nearly square, which is fine in a card and poor full-bleed. The new hero is built from `assets/images/imported/Sheerline-Heritage-Doors.jpg`, 1762x1090, the widest heritage shot in the theme and the full-frame original of the courtyard crop already used further down the page. Derivatives at 800, 1200 and 1760 with a srcset.
- **`.fg-hero--compact` hides `.fg-hero__intro` by design**, so the lead paragraph and the three reassurance points were moved into their own block below the hero rather than left marked up and never shown. The page still explains what the product is before it starts quoting numbers.
- Second button switched from `button--steel` to `button--light`, which is what the other heroes use; steel was styled for the old light background.
- Verified on test at 1440 and a true 390: hero spans the full viewport width at both, image loads and picks the right srcset entry at each, the lede block renders, no horizontal overflow.
- **Rebased onto 16 commits from the concurrent session**, which had shipped scoped cookie consent to live in the meantime. Only the compiled CSS conflicted; the SCSS merged cleanly. Resolved by rebuilding the artifact from merged source rather than hand-merging it, then confirming all 51 of their `fg-cookie-consent` rules and my 7 lede rules were both present. Ran `build:css` only, leaving `assets/js/main.js` byte-identical to theirs, since a local esbuild produces a different bundle and would have silently replaced code they had just released.
- Test deployment only. Live is `572fe3c` for this session's work; the other session has since released its own.

## 2026-07-29 - Heritage doors: real homes gallery and the missing case studies (test, 3b32cbb)

Owner: the page needs to be more image heavy near the top, a gallery like the casement Real homes section before configurations, and the case studies section at the bottom was missing.

- **Gallery reuses the casement component rather than growing a second one.** Same mosaic, lightbox, captions and mobile swipe row. A `--heritage` modifier only re-cuts the grid, because that mosaic is hard-coded for six cells with `nth-child` and would otherwise leave holes.
- **Four pictures, not six, and that was the honest limit.** The cutout doors on white in `assets/images/imported` are product renders, and the configurations carousel already shows those; putting them under a heading reading "real homes" would be a claim the picture cannot support. The C08 shot was rejected too: it is a heritage *window*, not a door.
- The kitchen shot is reused here rather than left unused after it stopped being the hero. The Northampton image is our own install and the copy says so, matching how the casement gallery separates our work from the manufacturer's photography.
- **Case studies: exactly one study names these doors**, so the heading carries no count. Casement can say "three jobs" because it has three. Checked deliberately, because `fenster_case_studies_for_product()` falls back to returning *every* study when nothing matches, and its own docblock warns that this makes a page claim unrelated jobs as its own. Verified the rendered strip contains one card and that it is the Northampton heritage door job, not the fallback.
- **The gallery took its text colour from the page wrapper, not from itself.** `.fg-cw .fg-cw-gallery h2` scoped white text to the casement wrapper, so on the heritage page the section painted its own steel background and then rendered an ink heading on it. The hint was worse: even its `display: none` was scoped that way, so it would have shown unstyled on desktop. Both now also match the section's own modifier.
- Verified on test at 1440 and a true 390: heading white on the steel background, four cells filling the mosaic with no holes, all four images loaded, hint hidden on desktop and shown on mobile, mosaic scrolls as a swipe row on the phone, no horizontal overflow at either width.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Casement: intro rewritten, EnergyPlus banner lifted (test, 4dd4e0d)

Owner: the first two info sections repeat each other on opening types, and the EnergyPlus box feels lost at the bottom.

- **The repetition was real and one-directional.** The intro opened by defining the hinge types and listing side-hung, top-hung and fixed lights; the Opening styles section immediately below sets out exactly those four, with the hardware detail. The intro now leads on what the window is instead: the most common window in UK homes, made to measure from a single light to a full bay, sixteen colours, EnergyPlus as standard rather than an upgrade tier, A+ at 0.95.
- **Avoided swapping one duplication for another.** The anatomy section further down owns chambers, gaskets and the sealed unit, which is what explains how 0.95 is reached. The figure is now claimed once in the intro and explained once in anatomy, rather than argued in both.
- **Facts reused rather than rewritten:** sixteen colours with smooth white or the same colour inside, and 0.95 on the listed specification, both already established elsewhere in the theme. **No double-glazed U-value is quoted on this route**, because 1.2 with 28mm belongs to flush casement.
- **The banner was not at the bottom, but it was buried.** Measured at 3,562px of an 11,260px page, 32% down, below the hero, intro, opening styles, details, gallery and the CTA panel. Its original placement had a real reason, which still holds: letting `generated-page.php` render it stacks it straight onto the four-tile spec strip under the hero. So it moved up to just under the intro, the section that now makes the EnergyPlus claim, with the intro still separating it from the spec strip. Now 1,289px, 11% down.
- Verified on test: the three duplicated phrases return zero matches, the new intro serves, all four opening styles remain in their own section, banner at 11% with the spec strip at 5% and the intro at 6% between them, no horizontal overflow.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Heritage doors reordered to the casement rhythm (test, 75ab266)

Owner, after approving the casement order: reorder heritage a bit more like it, it feels disjointed.

- **Two adjacent swaps, nothing else moved.** The four-fact strip now sits directly under the hero with the prose intro after it, matching casement exactly: hero, specification strip, intro, tech banner. The page previously opened hero, prose, facts, banner, so the numbers interrupted the introduction instead of framing it. And the two jobs section now precedes the frame construction section, so the benefit reads before the cutaway, the way casement puts gallery and CTA before its anatomy section.
- **The gallery deliberately stays before configurations.** Casement runs variants, then details, then gallery. The owner asked for the gallery there specifically when it was added, and a general instruction to match casement does not override a specific instruction about that section. Flagged to the owner rather than silently reversed.
- The lede's own SCSS comment described it as sitting between the hero and the fact strip, which the swap made false, so it was corrected along with its top padding.
- Verified on test: rendered order is hero 1%, brief 6%, lede 8%, tech banner 10%, gallery 12%, configurations 20%, detail 29%, use 35%, frame 43%, security 50%, colours 56%, handles 65%, case studies 70%, enquiry 79%, reviews 86%. No horizontal overflow.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Heritage doors rebuilt on the casement components (test, 006df8c)

Owner rejected the first pass, attached the casement intro section and said heritage should look like that, and asked for the hero CTAs to match too.

- **The misaligned box was the specification strip.** Measured before changing anything: every container already sat at 130 to 1310, so it was not the grid. Heritage had its own four-cell strip with no label block, so the numbers began hard against the left edge with nothing introducing them, while casement leads with "Key specifications" and the product name. It now uses the shared `fg-product-pulse` component, so it is the same thing rather than a lookalike.
- **The intro is now casement's section outright**: `fg-cw` for the eyebrow, heading and figure rules, then `fg-cw-split`, `fg-cw-facts`, `fg-cw-actions` and `fg-cw-media`, all already shared. That supplied what the bespoke version was missing rather than imitating it: an eyebrow and H2 above the copy, a second paragraph, the action buttons, and the caption as a pill over the image instead of a bar beneath it. About forty lines of heritage-only grid, figure and caption CSS were deleted as a result.
- **The intro image was wrong twice before it was right.** First there was none. Then it was the product-on-white cutout, which rendered as a small door in a large empty frame, worse than nothing. It is the kitchen photograph now, a real room and the closest match on this page to casement's intro figure, moved out of the gallery so it is not shown twice. The gallery dropped to three and its mosaic was re-cut to fill without holes.
- **Hero CTAs already used the same button pair**, so what was actually missing was casement's full and short label pattern. "Get a heritage door quote" is long enough to wrap on a phone and now shortens to "Get a quote" at the same breakpoint.
- Real homes moved to casement's position, after configurations and detail, reversing where it was first requested. The owner overrode that explicitly.
- Verified on test: order is hero 1%, specs 7%, intro 8%, banner 14%, configurations 16%, detail 24%, gallery 30%, two jobs 37%, frame 45%, security 53%, colours 58%, handles 67%, case studies 72%, enquiry 80%, reviews 87%. No horizontal overflow.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Heritage doors are on the quote tool, and the page said otherwise (test, ae866b2)

Owner: heritage doors ARE on our instant quote tool, this is missing from the page.

- **A live factual error, and the data to disprove it was already in the theme.** `heritage-aluminium-doors` sits in `$product_quote_embeds` in `generated-page.php` as `productCollection=12`, labelled Heritage Aluminium Doors. The route was simply never passed the URL, so it could not render the embed, and the enquiry copy filled the gap with the opposite claim: "Heritage doors are not on the instant quote tool, because the size, the bar layout and the colour change the price too much to guess at." **Written to explain an absence that was a plumbing gap, not a fact.**
- `generated-page.php` now passes `quote_url`, `quote_label` and `brand` to this route, the same three casement receives. The page renders the same embed casement does, guarded on the URL so it disappears rather than breaks if the route is ever taken off the tool.
- CTAs now match casement exactly: hero is consultation then instant pricing, the intro box is get an instant price then call, both pricing buttons pointing at the embed. The phone number comes from brand data rather than being hardcoded in the template.
- Enquiry copy rewritten to point at the tool and offer the form for awkward openings.
- **Worth remembering:** when a page explains why it lacks something, check whether the absence is real before repeating the explanation. This one had been live.
- Verified on test: embed present at 74% of the page with `productCollection=12` and the iframe, the false sentence returning zero matches, hero reading Start your design consultation then Instant pricing, box reading Get an instant price then Call, both pricing links resolving to `#fenster-product-quote`, no horizontal overflow.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Case study: heritage aluminium doors, Wolverton (test, 99bb992)

Owner supplied the job and eight photographs from Downloads: Zac Rugman and Shane Gowing fitted a French pair and a single to the back of a Victorian terrace in Wolverton, both Jet Black with black handles, both two bar, completed 13 May 2026.

- Six of the eight used, chosen as three pairs: the wide opening before and after, the side path before and after, plus the doors open and the view from inside. The two left out were a duller shot of the same elevation and a second interior from further back. Identified from a numbered contact sheet rather than by filename, since WhatsApp names carry no subject.
- **Before and after live in the captions, not in a paired block.** The case study system has no before and after support: `images` is a flat list. The order alternates after, before, after so each pair stays together, and the first entry is what the card uses.
- Route, sitemap entry, the archive and the heritage doors page strip all pick the study up from the data with no further wiring. Verified all four on test, plus the date rendering, both installers, and the Jet Black colour deep link.
- **Flagged, then corrected by the owner and fixed.** `case-studies-residential.php` printed "This customer got their price from our instant quote tool" on every residential study unconditionally. The owner confirmed the Wolverton job was priced at a consultation, so the line was stating the wrong thing about a real person. It now reads `priced_by` from the study: `quote_tool` prints the original line, `consultation` prints a consultation line, anything unset prints nothing. **The claim is therefore gone from the other residential studies, which are live and make it today**, and returns per study as each route is confirmed. Verified on test: Wolverton reads consultation, three other studies return zero matches.
- **Owner corrections, three rounds.** The side path opening was a narrow timber French pair converted to one wide single leaf, not a single throughout; both openings were French timber before. "Plinth" went out as jargon rather than being reworded. The over-long side path caption was cut from 97 characters to 53, so all six now sit between 45 and 66.
- **The gap under the overview was measured, not guessed:** 379px of copy against a 710px sidebar left 331px of dead space. Fixed with content, since the copy needed correcting anyway, and it is 170px now.
- **Photo order took two attempts because the first image never reaches the gallery.** With no video the template spends `images[0]` on the hero and the card and renders the rest, so ordering the array after, before, after, before put the hero on after 1 and left before 1 opening the gallery unpaired. The open shot takes the hero slot instead, as it belongs to no pair.
- **Known limit, flagged to the owner:** `.fg-cs-gallery__masonry` is `columns: 2 22rem`, a column-flow masonry, so it fills column one top to bottom before starting column two. Measured on the rendered page: pair one stacks together in column one, pair two splits across the column break. Source order cannot fix that; a row-first grid could, at the cost of the mixed aspect ratios other studies rely on masonry for.
- Test deployment only. Live is `572fe3c` for this session's work.

## 2026-07-29 - Colour rails no longer grab (test, 8fb4fe2)

Owner: make the sliders better on this page, not grabby.

- **Scoped to the colour rails.** The other rails on the site keep `mandatory`; only `.fg-colour-rail__track` changed, confirmed in the compiled CSS.
- **Two separate causes, and the CSS one was the bigger.** `scroll-snap-type: x mandatory` forces a snap on every scroll, so a touch swipe can never coast and a small nudge is pulled to a boundary it was nowhere near. `proximity` only takes over when the scroll already stopped near a slide. Note Chrome serialises `x proximity` as plain `x`, because proximity is the default strictness, so a computed-style check reading `x` is the change having worked, not the property being dropped.
- **The drag release was the other.** It aligned to the nearest slide every time, however small the drag. It now aligns only when the throw already ended within a third of a slide; past that it keeps where it landed.
- Verified by intercepting `scrollTo` and driving two real drags against a 284px slide step: a 24px nudge releases to 94px and does not sit on a boundary, and a 240px fling releases to 964px rather than being yanked to 851. **A rail that can rest mid-slide is the point, not a regression** — it is what stops it feeling grabby, and proximity still tidies up anything that lands close.
- Promoted to live the same day as `572fe3c`, with the nudge and fling drags re-driven against the production page rather than trusted from test.

## 2026-07-29 - Promoted to live (41ffb83)

- Live re-established by checksum first; three theme files matched `8940ef6..4cd1925`, all theme-identical, so `8940ef6` was the range base to yield a superset. The recorded pointer was accurate for the second release running. Empty-input hash printed alongside the sweep so a silent miss could not read as a match.
- Range `8940ef6..41ffb83`: **19 commits, all one author.** The handle options box, the mobile hero rebuild, the read more on the three collections, and the composite white tile reframe.
- Backup `fenster-pre-41ffb83-20260729-183206.tar.gz` confirmed present at 375M and 1,738 entries before deploying. Theme-only rsync at an explicit SHA, `wp cache flush`, `wp sg purge`.
- **Verified on production at both widths, not just by status code.** Four theme files byte-identical, six routes 200, the box linking to `/handle-options/` with five finishes, three read more controls with matching ids, zero duplicate eyebrows, 336 hero tiles, all three ranges in the owner's order. At a true 390 the collection paragraphs collapse to 51px with their controls showing and the hero carries the fade; at 1440 nothing is clamped, the controls stay hidden and the hero background is `none`. **The mobile-only work needed proving mobile-only, which a desktop check alone would have missed.**

## 2026-07-29 - Handle options box, and a mobile hero worth having (test, 62f1099)

Owner: a box leading to handle options after all the colour options, and the header looks amazing on desktop but not great on mobile.

- **The box sits after all three ranges, before the enquiry form.** Finishes come from `window_handles.finishes` rather than being hardcoded, so the strip cannot fall out of step with the hub it links to. The whole box is the anchor and the button inside it is a `span`, not a nested link.
- **The mobile hero was weak because the colour arrived late.** The band sat under the copy, so the first thing on a phone was a plain white text block. The desktop idea now runs vertically instead: the wall is full strength directly under the header and fades down into white, with the copy pulled up into the tail of the fade so it reads as a backdrop rather than a stripe.
- **Two sizing mistakes, both caught by measuring rather than looking.** The handle photographs are tall and narrow, so card width limited them, not height: five in a 0.85fr column drew at 108px inside a 128px box. Then, after widening the cards, the phone case did not improve at all, because a 22vw height clamp was still capping the image at 86px. Widening had fixed the wrong axis. **The first fix looked right on desktop and did nothing on the size that prompted it.**
- Four handles on a phone rather than five: at 390 five put each at 49px wide, too small to tell the finishes apart.
- Verified on test at 1440, 1000 and a true 390: handles drawn at 90x172, 63x120 and 62x117, five visible on desktop and four on the phone, no horizontal overflow at any width.
- **Follow-up, same day:** owner reported the gap under the CTA looked big on mobile and the text took too much of the frame. Measured at 390 in an 850 viewport: 123px of dead space under the buttons, made of four spacings stacking (hero bottom padding, hub top padding, first material margin and padding), and a copy block of 457px, 54% of the viewport, with the intro alone at 179px. The fade already separates hero from hub, so only one of the four spacings was kept. Intro type and margins tightened on mobile only, no words removed and desktop untouched. Result: gap 123 to 30, intro 179 to 137, copy block 457 to 404, 48% of the viewport.
- **Second follow-up:** owner said it was then too bunched up, and asked whether a read more would work on mobile. The gap, overcorrected to 30px, went back to 49px, still well short of the 123px it started at.
- **The read more went on the wrong paragraph first.** It was put on the hero intro; the owner meant the explainer above each colour rail, which is the text that pushes the swatches themselves off a phone screen. Moved to all three collections, one control each, and taken back off the hero. The controller was already generic, so only the ids and the style hooks needed generalising. **The hero intro keeps its smaller mobile type, which was a separate fix and is not a collapse.**
- **The clamp is applied by the controller, never by the stylesheet or the markup.** Without JavaScript the paragraph shows in full rather than being cut off with no control to open it. The button hides itself when the text is short enough not to need it, and at desktop widths.
- Verified at 390: all three collections collapse from 205px to 77px, all three controls visible, toggling flips `aria-expanded` and the label, no horizontal overflow. The uPVC rail now starts at 937px down the page instead of 1155px.
- **Third follow-up, both faults mine or the data's.** The owner sent a screenshot: the first card's top border read as inconsistent with the other two, and every card repeated itself, heading then subheading.
  - The inconsistent top was the gap fix from the previous round. Zeroing the first card's own padding as well as its outer margin left its content flush against the top border while the other two sat 17.6px in. **A card's internal padding is not spacing between sections, and treating it as such broke the card.** Only the margin goes now; the hub's own top padding absorbs the difference. All three cards now measure 17.6px padding and 19px from border to heading.
  - The repetition was in the data, not the template: every `label` in `colour_options.materials` repeats its own `headline` word for word, so each card said "uPVC colours" twice before saying anything. The eyebrow is no longer rendered. The label is still what names the rail for assistive technology, so it was not deleted.
- Verified at 390 and 1440: three identical cards, no eyebrows, rail accessible names intact, gap from the buttons to the first card 32px, no horizontal overflow.
- **Fourth follow-up:** collections collapse to two lines rather than three, on the owner's call. 77px to 51px each, and the cut still lands after a complete sentence on all three. The uPVC rail now starts 881px down the page, against 937px at three lines and 1155px before any of this.
- **Fifth follow-up, also mine:** the page's green wash lives on `body.fenster-generated-route`, and the hero was given a solid white background when it was built, so the white simply stopped where the section did and left a hard line across the screen. Harmless on desktop where that edge is below the fold; on a phone it landed mid-screen. The white now fades out over the last sixth of the hero and the wash comes through underneath. Mobile only, and confirmed in the compiled CSS to sit inside the `max-width: 900px` block rather than leaking to desktop.
- Test deployment only. Live is `6ea0dba`.

## 2026-07-29 - Promoted to live (6ea0dba)

- **Live re-established by checksum before anything was touched.** Five theme files matched `54451c2..4822e92`, four commits all theme-identical, so `54451c2` was used as the range base to yield a superset. The recorded pointer was accurate this time, ending a run of three releases where it was not. Empty-input hash checked against the sweep so a silent miss could not read as a match.
- Range `54451c2..6ea0dba`: **20 commits, all one author.** No concurrent-session work in this batch, unlike the previous release.
- Backup `fenster-pre-6ea0dba-20260729-175517.tar.gz` taken and confirmed present at 375M and 1,736 entries before deploying. Theme-only rsync at an explicit SHA, `wp cache flush`, `wp sg purge`.
- **Verified on production**, each item individually rather than by status alone: five theme files byte-identical to the committed tree, seven routes 200, the hero wall serving 336 tiles with both CTAs, the old boxed hero photo gone, zero counter markup, five pale tiles carrying the hairline, all three ranges in the owner's order, the composite white tile returning 200, and the uPVC colour grid reordered on `/casement-windows/`.
- **A claim made earlier in the day was wrong and was caught during this verification.** The composite doors page does **not** read `colour_options.materials.composite`: it carries its own hardcoded `$composite_colour_wall` and `$composite_palette` lists in `generated-page.php`. It therefore did not reorder and does not show the new white. The reorder note has been corrected above.
- **Related, and needing the owner:** that hardcoded wall already contains a composite White, with a real photographed door, at `#f2f0e8` rather than `#ffffff`. So composite white already existed on the site. The two surfaces now disagree on tone, and the composite doors page has photographic evidence the colour hub does not.
- **Dead code found, not touched.** `generated-page.php:3187` guards a composite choice selector with `! $is_composite_doors && ! empty($composite_door_families)`, which cannot be satisfied because the families array is only populated when the route *is* composite doors. It renders nowhere, confirmed against three live routes. It also takes `$composite_door_colours[0]`, so had it been reachable the new first-position white would have pointed at a door photograph that does not exist. Left alone as out of scope for this release.

## 2026-07-29 - Composite white added, made from the set (test, 51c7c50)

Owner: fabricate a white for composite, white is white, use the same tone as Smooth White uPVC. Then: add the same texture as the other composite tiles so they are a set.

- **Distinction supplied no white in the sampled range**, which is why the reorder could not place the owner's first composite colour. Added as Standard White, RAL 9003 tone, first in the list.
- **The tiles are photographed brush strokes, not flat colour.** The first pass read them as flat because it sampled a centre crop and the stroke runs across a corner: the numbers said standard deviation 3 to 4 and the eye said paint. **Statistics agreed with a wrong conclusion, and only a screenshot of the rendered rail settled it.**
- **The tile is therefore made from a real tile rather than drawn.** Chartwell Green greyscaled, despeckled and mapped so the mean lands at 250 with a grain deviation near the rest of the palette, neutral across R, G and B. Crop zoomed and offset so it is not a visual twin of Chartwell Green, which appears in the same rail.
- **A near-white swatch on a white card reads as an empty slot**, so pale tiles take a hairline in the rail. Five tiles qualify across the three ranges.
- **Owner-asserted, not supplier-confirmed.** If Distinction's white carries a tint the tile should be replaced with a real sample. Recorded in the data alongside the entry.
- Verified on test: composite serves 24 colours with Standard White first, the tile returns 200, five pale tiles carry the hairline.
- Test deployment only. Live is still `834b424`.

## 2026-07-29 - Colour ranges put in the owner's order (test, b446687)

- Owner supplied an explicit sequence for all three ranges. Applied as a pure line permutation and asserted as one, so no entry could be silently altered or dropped, with comment lines moving alongside the colour they describe.
- **Three gaps in the instruction, resolved rather than guessed at and all flagged to the owner.** The composite list opened with "white", but there is no white in the composite range at all, so it could not be placed. The aluminium list named twelve of thirteen, omitting "Any RAL Colour", which went last on the same logic as the RALs. Five composite standards were not named individually (Slate Grey, Basalt Grey, Buckingham Grey, Steel Blue, Black Brown) and sit after the named ones, before the RALs.
- **One other surface reads these lists and reorders with it**: the uPVC colour grid on product pages, confirmed on live. **The claim that the composite doors page also reorders was wrong** and is corrected in the release entry below: that page carries its own hardcoded colour lists and does not read `colour_options` at all.
- Verified against the served markup on test rather than the source: all three rails print in the requested order.
- Test deployment only. Live is still `834b424`.

## 2026-07-29 - Colour hub hero built from the range itself (test, 4d72959)

Owner: the header looks unexciting, maybe a big colourful hero, imagining a paint splat with tonnes of colour.

- **Argued against the splat and said why.** The frames are not painted: uPVC is a bonded foil and aluminium is powder coated, which is the distinction the page's own opening paragraph turns on. A splat also reads as decorator rather than glazier and would show colours that are not for sale. The instinct was right though, and the material for it was already on the page.
- **The hero is now the range.** 53 real colours pulled from `colour_options`, so the hero cannot drift out of step with the rail below it and a new colour appears in both. Nothing invented, nothing hand-placed.
- **An even shuffle of this range reads almost black.** Most of it is grey, charcoal and dark green; the bright end is nearly all composite. Tiles are weighted by lightness and saturation, which is what made the difference between the first attempt and the one the owner approved.
- **Owner steered the panel from dark teal to white**, so the text sits on white fading into the wall rather than on a dark scrim. Contrast still does not depend on which colours land behind the heading, which is the thing that normally breaks a busy hero.
- **The heading was left alone deliberately.** A mockup headline read "All of them real", the owner called it dumb, and he was right: it is exactly the adjective `TONEOFVOICE.md` says to cut. A count would also contradict the page, which states the composite range is the standard set plus any RAL. The existing heading already works, so the change is the picture and not the words.
- **Two faults found by measuring rather than by looking.** At 1440 a fourteen-column grid made each tile 103px, far chunkier than the proportion the design was approved at; it is 26 columns on a wide screen, 18 at tablet, 12 in the mobile band. And the near-white foils were originally steered away from the fade columns, which only worked while PHP and CSS agreed on a column count. They now carry a hairline instead, so a white tile reads as a tile wherever it lands.
- **Rows are a fixed height with more tiles than the widest grid needs**, so the wall runs off the bottom and clips rather than leaving a bald patch when the column count changes.
- Under 900px the wall becomes a full-strength band beneath the copy. The wall is before the copy in the DOM so it can be the backdrop on a wide screen, so the mobile band is ordered rather than assumed.
- Adds the instant price and consultation buttons, which the hero did not carry.
- Verified on test at 1440, 1000 and a true 390: no horizontal overflow at any width, tiles 55px / 56px / 33px, the wall fully covered at every width, 28 pale tiles carrying the hairline.
- **Not done, and the owner should decide:** the old hero photo of a dual-colour flush casement is now unused, and its caption made a real point ("One frame, two finishes. Black outside, white inside."). That fact no longer appears on the page.
- Test deployment only. Live is still `834b424`.

## 2026-07-29 - Colour rail: the four faults the owner found (test, 3900ff6)

Owner, on the new rail: dragging the image highlights it instead of swiping, the aluminium colours are cropped, it should scroll smoothly, and it does not need the numbers below.

- **The crop was right for one collection and applied to all three.** Every source is square: Renolit uPVC swatches 1200x1200, Sheerline aluminium corners 600x600, composite paint tiles 320x320. Only the Renolit files carry the supplier label strip, so only they need the `1.42` top-anchored crop that hides it. Scoped it to `[data-fg-colour-material="upvc"]`; aluminium and composite are back to 1:1 and show whole. **This is the second time a fix borrowed from a sibling collection has damaged the others**, and the lesson is the same one already in `AI.md`: do not fill a gap from a sibling route without checking the gap is the same shape.
- **Dragging selected the image because the browser gets first refusal.** A native image drag and a text selection both start before any pointer handling. Fixed at all three levels: `draggable = false` on the rail images, `preventDefault()` on `pointerdown`, and `user-select: none` on the track.
- **The first attempt at smooth release was a hand-rolled inertia loop, and it was wrong.** It only moved while `requestAnimationFrame` fired, so it did nothing in a hidden or throttled tab, and no harness available here runs frames. Replaced with the browser's native smooth scroll: the drag velocity projects a throw distance, the nearest slide is picked, and `scrollTo({behavior: 'smooth'})` does the travel. That animates reliably and honours a reduced-motion setting without asking.
- **Snapping has to stay off until the scroll finishes**, or it fights the animation and drops the rail back where the finger let go. Restored on `scrollend` with a 700ms fallback so it cannot get stuck off.
- **Verified by interception, not by watching.** Headless runs about one frame per render and the in-app browser pane is hidden, so both report an animation as "did not move". Wrapping `viewport.scrollTo` instead proved the real behaviour: a drag started on the image scrolls the rail 0 to 220px and releases into `scrollTo({left: 609, behavior: 'smooth'})`, 609 being a real slide boundary two slides past where the finger stopped.
- **A near-miss worth recording.** The rewrite was first applied with a Python slice whose two ends were searched independently; the closing anchor matched the coverflow controller's `endDrag` 4,000 lines earlier, the slice came back empty, and the new block was prepended to line 1 of `main.js` outside any function. `node --check` passed, because it was valid syntax. Caught by grepping for the block, reverted from the last commit and redone with a forward-anchored search. Recorded in `nick.md`.
- Measured on test at 1440, 1000 and a true 390: aluminium and composite media boxes 1:1 at every width, uPVC 1.42, slide widths identical within each rail, roughly 4 / 3 / 1.6 per view, no counter anywhere in the markup, deep links intact.
- Test deployment only. Live is still `834b424`.

## 2026-07-29 - The day's work promoted to live (834b424)

- **Live established by checksum first, and the pointer was wrong again.** `LIVECHANGES.md` said `8052f65`; six theme files checksummed to `d3600ad`, the docs commit immediately after it. Theme content was identical, so nothing was at risk, but that is three releases running where the recorded SHA was not the deployed one. The check took under a minute and is worth doing every time.
- Range `d3600ad..834b424`: **54 commits, 52 from this session and 2 from the concurrent one** adding Google Ads conversion tracking. The owner was told twice that the batch contained both before approving it.
- **The other session's code was read before shipping it**, since deploying it made it mine to answer for. It respects the documented consent boundary: the ad click id is held for the page load but not persisted when consent is refused, and the `dataLayer` push is gated on `trackingConsentAccepted()`. Click ids go to WordPress only, never the dashboard, which is what `GOOGLE-ADS-PLAN.md` specifies.
- Backup `fenster-pre-834b424-20260729-161416.tar.gz` (371M) taken and **confirmed to exist** before deploying. A plain `ls | tail` did not show it, because the backups sort alphabetically and this one sorts early; grep for the SHA instead of trusting the tail.
- Deployed with an explicit SHA, theme-only rsync, `wp cache flush` and `wp sg purge`.
- **Verified on production:** six theme files match the committed tree byte for byte; fifteen routes return 200 including the new `/handle-options/`; `/window-handles/` 301s to it; `/double-glazing-milton-keynes/` still carries its head-term marker, which status alone does not prove. Each change confirmed individually rather than assumed: real uPVC photography with zero references to the old composite slab, four pet-flap installs, the flush casement banner reading 1.2 with 28mm double, three chooser sections on the handle hub, 23 paint tiles on the colour hub, the cat flap tile and menu entry, and the corrected process rail.
- Browser QA at 1440 and 390 on two live pages: every theme image loaded, no heading above the 57.6px cap, no horizontal overflow. The five images reported broken were the external URLs the test harness deliberately blocks, confirmed by printing their `src` rather than assuming.
- Live, `main` and test are now level at `834b424`.

## 2026-07-29 - Cat and dog flaps was missing from its hub (test)

Owner spotted it: the route was not on `/other-services/`.

- **It had a page, its own copy, its own SEO and, as of an hour earlier, its own photography, but it was never added to `product_hub_groups['other-services']`.** So the only ways to reach it were a direct link or search. The homepage product theatre has described Other Services as covering cat and dog flaps since launch, which is what makes it a genuine omission rather than a deliberate exclusion.
- Placed with the glass work rather than maintenance: the job is a flap into a door panel or into a new sealed unit made with the aperture already in it.
- **Eight tiles keep the range's shape.** Seven ran four then three; eight runs four then four. Measured at 1440 the range still ends at 846px against a 900px viewport, so this hub continues to meet the one-viewport rule that windows and doors now knowingly break.
- **Then the owner found it was missing from the Products menu too.** `primary_nav_fallback` is a third registry, separate again from the hub, and it drives both the mega menu and the mobile drawer. So the route genuinely had no navigational way in: not the menu, not the hub, only a direct link or search.
- **Cross-checked both lists afterwards rather than fixing only what was reported.** Every hub slug against every menu URL: nothing else is in a hub and missing from the menu, and the only thing in the menu without a hub is `/commercial-projects/`, which is an archive rather than a product. That check is now written into `AI.md` so it can be repeated.
- Verified on test: eight tiles, four columns, two even rows, all eleven images loaded including the system marks.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - uPVC door configurations, and the image bank sweep (test)

Owner: uPVC doors should say they come as a French pair, a single or a stable door. And look through the whole Legacy Marketing folder for anything good or needed.

- **uPVC doors now says what it actually is.** The intro led on "practical, efficient and highly customisable", which describes nothing. It now says the same Liniar system makes a single leaf, a French pair or a stable door, with a benefit card and a new lead FAQ carrying the same. Owner instruction.
- **The worst find in the sweep: `/cat-and-dog-flaps/` was illustrated with roofline fascia and soffit boards**, a different product entirely, plus a sealed-unit sample. Four real pet-flap installs are in, including a black cat halfway through a flap, and it is now the hero.
- **French doors** dropped four imported scrape images for two real installs, one of them the rosewood woodgrain that also does a job showing the foil range.
- **Aluminium windows** gained the single real Fenster aluminium install in the bank, closing a standing `PHOTO-CHECKLIST` gap.
- **The pool lesson repeated.** `product_media` fixed the product pages while the gallery pools still fed the old images to every town route; both pet flaps and French doors needed the pool fixing as well. That is the second time today. The three places are `product_media`, `product_gallery_pools` and `fenster_link_card_image()`.
- **One apparent defect that was not one:** `/cat-and-dog-flaps/` still shows a roofline photograph, in a related-link card pointing at `/roofline/`. Correct there.
- **Empty folders, so these gaps stay open:** aluminium doors, aluminium sliders, uPVC sliding, tilt and turn, heritage windows and heritage doors all have folders in the bank with nothing in them. `/aluminium-doors/` therefore keeps the interior white-door hero the owner chose to leave.
- **Not yet mined:** `Photos.old` (261 files), `Misc` (30), `Doors/Composite` (51), `Windows/uPVC casement` (22), `bifolds` (13), `uPVC flush` (10), sash (11), roof lanterns and showroom. Those are seams worth a session of their own rather than a skim.
- `PHOTO-CHECKLIST.md` rewritten around what is now closed, still open, and newly discovered, with a pointer to the bank so the next person looks there first.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Real uPVC door photography, and five owner decisions closed (test)

Owner pointed at OneDrive `Marketing/Image Bank/Legacy Marketing/Doors/uPVC Doors` and asked for the gaps on the uPVC doors page to be filled from it.

- **Seven real installs are now in the theme** under `assets/images/products/upvc-doors`, replacing a golden oak slab that reads composite and had represented uPVC since launch. Every file in the folder was opened first; the folder name is not evidence, which is the whole reason the wrong image survived a previous audit.
- **The image was in three separate places, not one.** `product_media` fed the product page and the hub tile; `product_gallery_pools['upvc_doors']` fed those *and the whole town matrix*, so every `/upvc-doors-<town>/` route carried it; and `fenster_link_card_image()` in `inc/assets.php` used it for related-link thumbnails, under a doc comment saying a wrong-material thumbnail is worse than none. **When a product's imagery is wrong, check all three.**
- The pool also held a black door that reads composite and a stock blue timber door. Both gone.
- **Three images in that folder were left out**: a sage green boarded door, an anthracite boarded door with a diamond light, and the same sage door again. They may be composite rather than uPVC and the owner's eye is worth more than my guess.
- **The hub card is the hero centre-cropped, deliberately.** The tile is a wide 384x225 cell rather than the 4:3 the older notes describe, and this door is tall and narrow, so any tighter crop cuts its head or its threshold. The wide crop shows the whole door with its context, which is the better of the two.
- **Five owner decisions recorded in `AI.md` so they are not reopened:** the AI-generated tilt and turn handle images are accepted as the best available; the one-viewport rule is superseded by the 3x3 and the slight scroll is fine; pet flaps keep their own process rail; French casement is a configuration available on every window except tilt and turn and sliding sash; and the uPVC photography question is closed.
- Verified on test: `/upvc-doors/`, `/doors-milton-keynes/` and `/upvc-doors-bletchley/` all serve the real photography with zero references to any of the three replaced assets.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - EnergyPlus banner contradiction, and the real composite colour range (test)

Owner: the key specifications and the EnergyPlus banner contradict each other on flush uPVC windows, which can only be 28mm double at 1.2. And make clear the composite colour range is much wider than the swatches shown: the standard range, of which the tiles are a mix, plus any RAL.

- **The banner was quoting the casement best case on all seven EnergyPlus routes.** On `/flush-casement-windows/` that put "0.95 W/m²K with 36mm triple glazing" directly above a key-specification strip reading 1.2, on a sash that cannot take triple at all. The figure is now route-aware: 1.2 with 28mm double on flush casement, and the shared 0.95 stays on casement, tilt and turn, bow and bay and French casement.
- **The same check found a second contradiction the owner had not reported:** `/upvc-doors/` carried the 0.95 window figure against its own 1.0. It now shows 1.0 on the door. `/french-doors/` has no confirmed U-value anywhere in `product_usps`, so it renders **no** glazing figure rather than inheriting one; a wrong number is worse than an absent one.
- Verified against every EnergyPlus route on test: banner figure and key specification now agree on all six that carry a figure.
- **Composite colours: the range is wider than the tiles.** Owner-confirmed, and it reverses the July removal of the blanket RAL claim, which came off as unsubstantiated at the time. Both `/composite-doors/` and `/colour-options/` now say the swatches are a selection of the standard range and that any RAL can be matched beyond it. `AI.md` and `COMPOSITE-DOOR-REDESIGN.md` both carry the correction, the latter struck through rather than deleted so the reversal is legible.
- **This also resolves the four-colour gap from earlier today.** White, Light Grey, Pale Blue and Ruby Red having no painted tile is a presentation gap, not a gap in what we sell, now the copy says the range runs wider. Still do not tint a swatch to close it.
- **Explicitly not extended to heritage aluminium doors**, which stay at twelve standard powder-coated finishes with dual and bespoke on request. That restriction is a separate owner instruction about a different product.
- **Corrected twice more the same day, both by the owner.** First: French doors are a configuration rather than a product, like bow and bay. That reframed the banner fix above, because a bay built from flush casement does not get the casement figure either. The map now **defaults to no figure** and only names one where it is confirmed for that route, so French doors, French casement and bow and bay print none. Inheriting a sibling's number is the exact mechanism that caused the original contradiction, so the default matters more than the individual entries.
- **Third correction: we do not take door samples to survey.** The confirmed model was already written down in the consultation facts on 2026-07-28, colour swatches come out to the consultation and full product samples are at the showroom only, and the survey is a later visit for measurements. Four sentences said otherwise. Mine on the colour hub was the newest; **`/composite-doors/` has claimed it since July**, and two more said "physical samples" without saying where, which a customer reads as their own house. All four corrected, and the composite FAQ answer feeds `FAQPage` schema so the wrong version was in the structured data too.
- **Concurrency, handled.** The push was rejected mid-task: the other session had landed the Google Ads conversion work (`GOOGLE-ADS-SETUP.md`, `gclid` capture, the form-submit dataLayer event). No file overlap with this work, so the rebase was clean; both sides linted before pushing. Test now carries their work as well, which is the normal consequence of a shared `main`.
- Second: the composite tiles are **a mix of standard colours and RAL matches**, not a selection of the standard range. The copy said the wrong thing on both pages and each tile now carries `Standard colour` or its RAL reference. Rendered counts on test: 11 standard, 10 RAL, 2 woodgrain stain, which is visibly a mix rather than a range.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Composite colours on the hub become paint, not doors (test)

Owner: the composite colours on `/colour-options/` should use the painted tiles from the composite doors page rather than photographs of doors.

- **Eight photographed doors replaced by the twenty-three painted tiles**, the same set `/composite-doors/` already shows. The hub had been a curated shortlist while the product page carried the real range, which is the sort of drift that makes two pages disagree about what we sell.
- **Four of the old eight have no painted tile at all**: White, Light Grey, Pale Blue and Ruby Red. They exist in the Distinction material as photographed doors only. Raised with the owner rather than papered over: tinting a swatch to stand in for a colour is precisely what the composite door wall notes forbid, and it is the one thing that would have made the change look complete while being false.
- **Hex fallbacks are sampled from each tile**, taking the median of the flat half of the image, so the chip behind a slow-loading swatch matches the paint rather than being eyeballed.
- The portrait `4:5` slide override went with the door photographs. Composite images now measure 458x458 at 1440, identical to the uPVC and aluminium swatches, which was the point.
- Verified the composite page is unaffected: it reads `$composite_colour_wall`, not `colour_options`, confirmed by its alt text being absent from the hub data. Twenty-three slides, twenty-three tiles, zero door photographs, no horizontal overflow at 1440 or 390.
- **Method note.** A first splice cut the wrong closing bracket and broke the file; PHP lint caught it before anything shipped. Find an array's bounds by counting bracket depth, not by searching for the next `],`, which `AI.md` already says for `main.scss` and is just as true here.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Tilt and turn handles, on the page and the hub (test)

Owner supplied the finish sheet as one image, plus the VBH product bulletin, and confirmed the locking version only and five finishes.

- **Five assets cut from one sheet**, through a single shared crop window rather than trimming each to its own bounding box, so the handles stay the same size as one another; then scaled together to about 715px to match the existing S2 assets. Each lands at 141x715 and 60-68K, in the same range as the S2 set. The source already had a clean alpha channel.
- **`tilt_turn_handles` is its own family.** A tilt and turn window cannot take the S2 Signature range, so merging it into `window_handles` would have been wrong even though both are windows.
- **Specification is from the bulletin, not invented:** four settings, 40mm spindle, 43mm Eurogroove centres, Secured by Design Police Preferred Specification, and greenteQ's 20 year surface and 10 year mechanical guarantees. Those two are **attributed to greenteQ on purpose**: they cover the handle, and the site already promises a ten year insurance-backed guarantee on the installation. Two different things, and they must not blur.
- **The bulletin lists eight locking finishes; we offer five.** Anthracite Grey, Smokey Chrome and Enduro Steel are deliberately not shown. VBH calls two of ours PVD Gold and Satin Chrome, so a later pass should not "correct" the customer-facing names against the source.
- **Provenance flagged, and recorded in `AI.md`: the supplied sheet is AI-generated**, not supplier photography. It is a likeness of the Alpha TBT that has not been checked against the real product. The bulletin does contain genuine photography, but only of the black handle, and it needs alpha recomposition. Worth replacing with VBH's own finish photography when it exists.
- **Folded three grids into one.** Rather than adding a third near-identical grid file, `window-handle-grid.php` and `door-handle-grid.php` were replaced by a shared `handle-grid.php`, with per-family args in `fenster_window_handle_grid_args()` and `fenster_door_handle_grid_args()`. Both families render from two templates each, which is exactly how the headings would have drifted.
- Five finishes needed their own column count as well, `fg-handle-finishes--five`, named in each breakpoint for the specificity reason now recorded twice in `AI.md`.
- Verified on test: `/tilt-turn-windows/` renders the grid, `/window-handles/` renders all three choosers in order, `/casement-windows/` and `/upvc-doors/` and `/heritage-aluminium-doors/` unchanged, all five assets serve `200 image/png`, and the section was checked by rendering it.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - One process rail, site wide (test)

Owner: bring all the process rails in line site wide, excluding commercial, and make the installation step read as expertly fitted with care rather than as survey logic.

- **There were six step sets, not one.** Product, About and pet flaps in `generated-page.php`; the MK head-term rail and the town-page rail in `location-service.php`, the second of which had its own `.fg-location-process` markup and so did not even look like the others; and the trust page. Every one described the same job differently, and four of the six were in the third-person "Fenster does X" voice that `STYLE.md` bans.
- **Now one source and one component:** `order_process` in `inc/site-data.php`, rendered by `template-parts/components/order-process.php`. Three copies of the markup and five step arrays are gone rather than left dead.
- **Held back deliberately, and flagged:** commercial, as instructed, and pet flaps. A pet flap is a genuinely different job. Nothing is manufactured to survey sizes, and it sits outside the ten year guarantee, so the canonical steps would describe work we are not doing on that route.
- **The commercial set may be unreachable.** Every commercial route checked renders no rail at all, because those templates return before the shared product tail. Left alone, since commercial was excluded, but worth confirming before anyone deletes it.
- **Installation reworded** away from the survey-measurements logic to the craft: trained on the systems we sell, working carefully in a house someone lives in, and clearing up. Word counts across the four cards are 31, 27, 31 and 28.
- Verified on test: `/upvc-doors/`, `/double-glazing-bletchley/`, `/double-glazing-milton-keynes/`, `/why-trust-fenster/` and `/roofline/` all render the same four steps; `/cat-and-dog-flaps/` keeps its own; no `fg-location-process` markup remains anywhere; seven routes 200. Town page checked at 1440 and at a true 390, cards level at 138, 138, 158, 158.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Order process: the real sequence, and a rail that fits a phone (test)

Owner: the section is way too big, especially on mobile, and the steps are off compared with the real process. Entry is either the instant online price or a consultation visit; then the technical survey, which is about getting it right to manufacture rather than choosing options; installation is fine; aftercare needs to say how good it actually is.

- **Steps rewritten** on the product routes. Step 1 now carries both ways in and the fact that the consultation prices on the same list as the online tool, so the figure matches. Step 2 is the technical survey, explicitly not a second sales visit. Step 4 names the CPA-backed ten year guarantee and FENSA registration, and that you deal with us afterwards.
- **The guarantee wording is scoped on purpose.** This rail renders on `/window-and-door-repairs/`, `/roofline/`, `/integral-blinds/` and `/cat-and-dog-flaps/`, and those sit outside the ten year insurance-backed guarantee. The copy says "new window and door installations carry", which stays true on every route it appears on. Do not simplify it to "your installation carries".
- **The four CSS-drawn icons are gone.** They were abstract shapes rather than recognisable marks, and the third drew two crossed bars, so Installation carried what reads as an error icon. The numbered discs already carry the sequence, and `STYLE.md` is clear that an image with no job should not be there.
- **The heading was rendering at 57.6px**, the site-wide ceiling, because it shared a clamp with the trust band. On a supporting strip that is a `STYLE.md` breach, not a style choice; it is now 34px. Section padding also came off a flat `5rem`.
- **Measured against live, which still runs the old version.** At a true 390: 1576px to 1115px, a 29% cut. At 1440: 826px to 722px. The disc drops from 88px to 52px on a phone.
- **The four cards were levelled to 31, 27, 28 and 28 words**, heights 138, 138, 158, 158. Aftercare went first: "more emphasis" was read as more words and at forty it became a wall beside three short cards. **Emphasis on this rail is what the card says, not how long it runs.** Installation was then the short one at nineteen, and was brought up with the link back to the survey, which is a real customer point rather than padding: the units go in as made because the survey settled the sizes.
- **"We clear up after ourselves before we leave" is owner-confirmed, 2026-07-29,** and recorded in `AI.md`. Nothing on the site carried it before, so a later audit would have flagged it as unsupported. Deliberately not extended into removing old frames, dust sheets throughout or a same-day finish, none of which the business has promised.
- **A line was shipped that did not survive being read aloud.** The intro said the first step could be started "at either end", which is meaningless. Now: "The first one has two ways in." Worth reading new copy back before deploying it, not after the owner does.
- **Method note.** Headless Chrome on this Mac clamps `--window-size` to a 500px minimum, so anything reported as "390" from a plain window-size run is really 500. Measure true phone widths through a 390px iframe, and check `innerWidth` in the probe rather than trusting the flag.
- **Left alone:** `location-service.php` and `trust-page.php` render the same component with their own step sets and were not part of the report. The trust page has the same structural fault, a "choose the right option" step before the survey. Worth raising with the owner.
- Verified on test: no horizontal overflow at 390 or 1440, nothing clipped, five routes 200.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Door handle grid: four routes, eight finishes on one row (test)

Owner: put the images on one line, and the applicable products are aluminium doors, heritage, uPVC and composite.

- **Route list is now those four**, set in `door_handles.slugs`. French doors and aluminium sliding doors came off; they had been carrying the section since the door handles were first built.
- **Two of the four needed more than a data change.** `/heritage-aluminium-doors/` returns before the shared product tail, so its own template now calls the grid, sitting after colour because handle finish is the decision that follows frame colour. Composite reaches the tail but was excluded by an explicit `! $is_composite_doors` guard: its inline hardware picker died with the tabbed configurator on 2026-07-22 and renders nowhere, so composite had no handle content at all. Guard removed.
- **Eight tiles on one row** on desktop, dropping to four below `1080px` and two below `560px`. Tiles measure 132x195 with the handle image at 108x144, against 251x371 at the previous four-column layout.
- **Dropped the repeated sub-label** while shortening the row. Every tile read "<name> long-plate handle" under a heading that already says long backplate, it wrapped to two lines on the narrower tile, and it set the row height for no information. The window grid keeps its sub-label, which names the finish method rather than repeating the name.
- Verified on test: the grid renders on exactly the four intended routes and returns zero matches on French doors and aluminium sliding doors; at 1440 and 1280 all eight tiles sit on one row with every image loaded; four columns at 1080 and two at 390; no horizontal overflow at any width. Checked by rendering the section, not only by measuring it.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - The handle hub becomes a real hub, product pages get the grid (test)

Owner instruction: move the door-handle box off the uPVC doors page and onto the handle hub in the same format with all its information, so the hub covers every product, then put the casement-style compact grid on the door pages in its place.

- **`/window-handles/` now carries windows and doors**, both through a new `template-parts\components\handle-chooser.php`. The window block was inline markup and the door block was a near-identical eighty-line copy inside `generated-page.php`; presenting them identically meant either a third copy or a component, so it is a component. The JS controller already scoped every query to its own block, so two choosers on one page needed no JavaScript change.
- **Door routes render `door-handle-grid.php`**, the doors counterpart of the window grid, on `/upvc-doors/`, `/french-doors/`, `/aluminium-doors/` and `/aluminium-sliding-doors/`. `/composite-doors/` is excluded as it always was, since it has its own hardware section.
- **Eight finishes needed their own column count.** The shared grid is six across, which would have left doors as six then two, the exact orphan-row problem raised on the product hub the same day. Doors are four across, and two below `560px`. The doors selector is (0,2,0) and beats the breakpoint overrides, so it is named in the media query it needs to change in as well; that is the third instance of this specificity trap on this project and it is now in `AI.md` twice.
- Hub H1, title tag and meta description rewritten to cover both. The route was kept as `/window-handles/` at this point and flagged for the owner. **Superseded the same day:** the owner chose `/handle-options/`, to pair with `/colour-options/`. See the entry above.
- **`/heritage-aluminium-doors/` rendered no handle section at first**, because its dedicated template returns before the shared tail. Corrected later the same day, below.
- Verified on test at 1440 and 390: hub renders two independent choosers with six and eight swatches and matching panels; `/upvc-doors/` renders eight tiles at four then two columns with all eight images loaded; the old `fenster-door-handles` section returns zero matches on every door route; `/casement-windows/` keeps its window grid; eight routes 200; no horizontal overflow at either width.
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Doors hub imagery: one tile fixed, one blocked on an asset

Owner report: the uPVC doors and aluminium doors tiles are the wrong pictures for those products. Both confirmed by opening the files, not by reading filenames or alt text.

- **Aluminium doors was a CGI render.** `aluminium-doors-northampton-2.jpg` is a dusk render of a dark modern house with a lit interior. On a grid of nine photographs a render is the first thing the eye lands on, which is the defect the hub was always going to expose. Replaced with `aluminium-doors-northampton-2-1.jpg`, an actual aluminium entrance door with a bar handle and glazed side screen. It is supplier photography, not ours, so the alt says what is in the frame and claims no install.
- **uPVC doors is a composite door and is blocked on an asset.** The tile serves the hero, `fenster-upvc-door.jpg`, a golden oak moulded slab with leaded side screens. Every other candidate in the theme was opened and rejected: `Residential_Door_01` is another moulded slab, `Residential_Door_08` duplicates the hero, `house-front-door` is a stock collage of five painted timber doors, `front-door` is a stock timber-look door on Cotswold stone, `Front-door-double-rebate` is a profile diagram. The only correct-product assets are the thirteen white-background Liniar renders. The owner is supplying an asset; there is no scrape on this Mac to pull one from.
- **The July image audit did not catch this because it audited pools, not tiles.** `fenster-upvc-door.jpg` was pulled from the `/upvc-doors/` gallery on 2026-07-16 as reading composite, and left in place as the hero, which is what the hub tile falls back to. Recorded in `AI.md` so a future audit checks the tile source too.
- **Found and left alone on the owner's instruction:** `/aluminium-doors/` has the same problem in its hero. `sheerline-aluminium-door.jpg` is an interior kitchen shot of a white single door, already noted on 2026-07-21 as reading uPVC. The only correct replacements are 600x450, too small for a hero, so it needs a better asset rather than a swap. Recorded in `nick.md`.
- Verified on test: the render is gone from `/doors-milton-keynes/` and the replacement is serving.
- Test deployment only. No live-site deployment was performed.
## 2026-07-28 - Consultations stated as free sitewide (test)

Owner instruction from Nick: wherever the site mentions booking a consultation, make clear it is free.

- **Recorded as an owner-confirmed fact first**, in `AI.md` and `LIVECHAT.md`, so no later session strips the word back out as an unsubstantiated claim.
- Visible label is now `Book a free consultation` across the mega menu, footer, About, product hubs, price guides, case studies, contact and the sliding sash route. The header CTA is `Free Consultation`: it is the same 17 characters as the `Book consultation` it replaces, so the header cannot reflow, and it matches the title case of `Instant Quote` sitting beside it.
- The booking page leads on it: H1 is now `Book a free window and door consultation in Milton Keynes.`, the lead says the visit is free whether you go ahead or not, and a new first FAQ answers `Is the consultation free?` directly, so the answer is in the FAQPage schema and can win the snippet. Route title and meta rewritten to lead on free, at 47 and 147 characters.
- **`Start your design consultation` and the short `Design consultation` were deliberately left alone.** Both point at `#fenster-enquiry` on the same page rather than the booking route, so they are enquiry-form CTAs, not an offer of a free visit, and adding "free" would have described the wrong thing. Worth noting they are also the invented journey language `STYLE.md` bans, which is a separate fix needing owner sign-off.
- `casement-windows-v2.php` said `Book a survey` while linking to the booking route, so it became `Book a free survey`. The About page already describes the survey as free, so the two agree.
- The same fact was added to `fenster_legend_verified_business_context()`. Without it Legend would have kept answering cost questions from older page copy and contradicted every button on the site.
- Thirteen changed PHP files linted clean on PHP 8.2.32, matching the server.
- **Owner then reported the booking hero looked misaligned, and it did.** `.fg-consultation-page__hero h1` carried `max-width: 12ch`, which broke the heading into four uneven lines with "door" orphaned on its own and left it visibly narrower than the `39rem` paragraph beneath, so heading and paragraph read as two different columns. Raised to `20ch` with `text-wrap: balance`, `18ch` on mobile. Heading and paragraph now measure the same 464px and share a left edge.
- **The CSS alone was not enough.** At 390px the heading still ran to five lines and pushed the calendar, which is the entire point of the page, below the fold. The copy was the real problem: the eyebrow directly above already says Milton Keynes and the title tag already says Window & Door, so the H1 was repeating both. Shortened to `Book a free consultation in Milton Keynes.`, which lands in three even lines at both 1440 and 390.
- **Concurrent session collision, handled.** The other session pushed `58d6440` (casement page work) mid-task and the push was rejected. Rebased onto it; only the compiled `main.css` conflicted, which was resolved by rebuilding from the merged SCSS rather than hand-merging a minified file. Verified afterwards that the rebuilt CSS carries both their 179 `fg-cw-` rules and this session's 104 `fg-consultation-page` rules, that the file grew by exactly the 18 bytes of the added declaration, and that their edit to `casement-windows-v2.php` had not reverted the `Book a free survey` label.
- Compiled `assets/js/main.js` was reverted after each build: no JS source changed, and this machine's newer esbuild rewrites the bundle anyway, which would have shipped unrelated churn.
- Verified on test at 1440x900 and 390x844 across fourteen routes: all 200, zero stale consultation labels anywhere, free wording present on every one, no horizontal overflow, no console errors, largest heading 52px against the 57.6px cap.
- Later the same day the page also gained the real consultation process from the owner, the FAQs became dropdowns sharing `.fg-product-faq__items` with the product pages, and the FAQ section was centred because eleven rows in a right-hand column left the left one empty.
- **A live promotion was asked for and deliberately declined by the owner.** Live was re-established by checksum as `984e89c`, unchanged. The range `984e89c..HEAD` was 55 commits, of which only 10 were this session's consultation work; the other 45 were the concurrent session's casement rebuild and the Thermlock/EnergyPlus banner across roughly fifteen product routes, still being committed at the time and never submitted for live approval. Rather than repeat the 2026-07-18 and 2026-07-22 incidents, the range was put to the owner, who chose to hold everything on test until the casement work is finished and reviewed. **Nothing was deployed to production; the only commands run against live were read-only checksums.**
- Test deployment only. No live-site deployment was performed.

## 2026-07-29 - Docs brought current for a fresh session

- Live pointer moved to `8052f65` in `LIVECHANGES.md`, `HANDOVER.md` and `AI.md`. `AI.md` had been left on `984e89c` and was four releases stale, which is exactly the line a new session reads first.
- **The test deploy one-liner in `LIVECHANGES.md` only ran `wp cache flush`**, while the note six lines above it says to run `wp sg purge` after every deploy. The command now matches the rule. That mismatch is what let a deployed footer change look unshipped on 2026-07-29.
- `nick.md` corrected and extended: the PATH trap that makes the Homebrew tooling look uninstalled, the headless Chrome verification recipe, and a short statement of where the work is up to with the owner-confirmed product facts and the open questions.
- **Correction recorded against this session's own work.** The swatch labels were cropped in CSS on the stated grounds that the machine had no `cwebp` or ImageMagick. Both are installed; they were invisible because `/opt/homebrew/bin` is absent from a non-interactive shell's PATH. The CSS crop is still defensible, since it is reversible and leaves assets shared with the colour options page untouched, but the reason given for it was wrong.

## 2026-07-29 - Handle finishes on the page, live (8052f65)

- The six S2 Signature finishes now render on casement, flush casement, aluminium windows, aluminium flush windows and heritage windows, and the card linking to `/window-handles/` is dropped where they do. Scope is `window_handles.slugs`, the list that already decided which pages got the handle card, so no page gained hardware it had not previously claimed.
- Handles are portrait product shots on white rather than flat swatches, so the tile is 3:4 with `object-fit: contain`. Cropping like a colour swatch would cut the handle off.
- **The supplied finish labels are prefixed "Premium"**, which TONEOFVOICE.md rules out and which would have appeared five times in one row. The component strips the prefix and keeps the rest, because the remainder names the real finish method. If the exact S2 wording is ever needed commercially, that is one line in `window-handle-grid.php`.
- Tiles lift 2px and scale 3% on hover, behind `@media (hover: hover)` so a tap does not stick, and cancelled under `prefers-reduced-motion`. None of these tiles are links, so the movement is deliberately too small to read as a button.
- **Open question left with the owner.** Tilt and turn and bow and bay are uPVC casement-family windows that have never carried the handle card and so do not get the grid. If they take the same S2 handles, they are two pages missing it. Pre-existing gap, not introduced here.

## 2026-07-29 - Leeds, casement technical data and the uPVC colour grid, live (5b7a612)

- Two live releases today. `2f78837` (footer trust tiles and social links) and `5b7a612` (this work). Both checksum-verified against live before deploying, both backed up first, both explicit SHA with `wp cache flush` and `wp sg purge`.
- **`wp sg purge` is not optional on test either.** Test deploys had been running `wp cache flush` alone, so SiteGround's optimiser kept serving a stale stylesheet over HTTP while the file on disk was correct. That is why a footer change looked unapplied when it had in fact deployed. Purge both on every environment.
- **`/commercial-glazing-leeds/`** came in from a scrape as a listicle and still fed its numbered headings into the benefit cards, so the visible list began at "2.". It also called Headrow Court an office refurbishment; it is a conversion of former offices into 108 student studios. Replaced with authored copy through `product_content`, which is the existing curated override. Corrected in the scraped sections too so `data/pages.json` stops asserting something untrue.
- **Casement U-value corrected downward.** The page led on 0.8 W/m2K as Liniar's published best case. That needs a 40mm triple unit Fenster does not supply; the real ceiling is 0.95 W/m2K on the 36mm triple, which is the A+ figure. Three case studies had also credited 0.95 to *double* glazing. Added the glazing thicknesses, the acoustic figures, Part Q and the two separate ten-year guarantees, all from Liniar's published data.
- **uPVC colour grid** on casement, flush casement, French casement, tilt and turn, bow and bay, uPVC doors and patio doors. One shared component, reading the same data as the colour options page. Supplier labels are cropped in CSS rather than by re-cutting the files, because `sips` will not do an offset crop on webp and the assets are shared with the colour options carousel, which was deliberately left alone.
- **Trap worth remembering.** `generated-page.php` already had a `$upvc_colour_routes`. Declaring a keyed map with the same name earlier in the file meant the existing flat list overwrote it, `isset($map[$slug])` stopped matching, and the grid silently vanished from four pages while the hub card it suppresses stayed hidden. Caught only by checking every page after deploying. Grep for a variable name in the whole template before introducing it.

## 2026-07-28 - Two sessions' work promoted to live (01dba14)

- Live re-established by checksum before anything was written: `inc/site-data.php`, `assets/css/main.css` and `inc/case-studies-data.php` matched `984e89c` byte for byte, confirming the pointer had not moved since the 07-27 release.
- Range check `984e89c..01dba14` returned **92 commits from two authors**, 47 from the concurrent session (casement page rebuild, named-technology banner across the Liniar and Sheerline routes) and 45 from this one. The two are interleaved through the history and both edited the compiled `assets/css/main.css`, so cherry-picking one session out was not clean. The range was put to the owner, who chose to ship everything. This is the second time the 07-18 rule has been exercised; it worked as intended both times.
- **Runbook step 8 was skipped: no pre-deploy tarball was taken.** The deploy is still reversible because it is theme-only and `984e89c` was checksum-verified against live minutes before, so `git reset --hard 984e89c` plus the same rsync restores the exact prior state. Take the tarball next time rather than relying on that.
- Deployed with an explicit SHA, theme-only rsync, `wp cache flush` and `wp sg purge`. SiteGround reported file and dynamic cache purge warnings, which are the usual output when those layers are not enabled.
- Verified after: four theme files match `01dba14` byte for byte on the server, nine live routes return 200 including the new `/commercial-projects/`, sector and AOV pages, the old `/case-studies/<commercial>` URLs 301 to their new homes, `--fg-tag-radius: 5px` and `--fg-tag-weight: 600` are serving in the live CSS, and the four mega-menu badges read Quick start, Expert advice, Talk to us, Our work.

## 2026-07-27 - Product-selector hubs promoted to live (984e89c)

- Live re-established by checksum first: six theme files matched `4458fc6` byte for byte, confirming the pointer. Range check `4458fc6..984e89c` returned 26 commits, all one author, no concurrent-session work; `windows-hub.php` removed and `product-hub.php` added as expected. Compiled CSS confirmed to carry the new classes before shipping.
- Backup `fenster-pre-984e89c-20260727-083131.tar.gz` (364M), server repo cache pinned to the explicit SHA, theme-only rsync, WP and SiteGround caches purged.
- Production verification: six deployed files match the committed tree byte for byte and `windows-hub.php` is gone; fourteen routes return 200 including all three hubs and the products that moved into the range; `/double-glazing-milton-keynes/` still carries its head-term marker; `/other-services/` serves its theme-owned H1; `notan.png` serves `200 image/png`; the aluminium window card asset serves `200 image/webp`.
- Browser QA on the live URLs at 1440 and 390: all three hubs render 9, 9 and 7 tiles with every image loaded, the range fits one desktop viewport, the decision panel and four FAQs render, no horizontal overflow, zero console errors.
- This release folds in everything since 2026-07-24: the six-route product imagery split, the three hubs on one template with `/other-services/` no longer a scrape shell, the one-viewport tile grid, the Notan mark, and the even-handed comparison copy.

## 2026-07-24 - Hub decision panel and FAQs, replacing the guide (test, 97ac969)

Owner, before the release: beef the pages out, the "Narrowing it down" section is poor, use `STYLE.md` and put whatever I think belongs there.

- **The guide was three numbered cards asking vague questions.** The shape was not the fault, the vagueness was: it told nobody anything they could act on. Replaced with the one comparison that genuinely narrows the range, built from figures already in `product_usps`.
- **Windows opens by correcting the assumption we hear most:** aluminium is not the warmer of the two. Our uPVC reaches 0.95 W/m²K against 1.0 for aluminium, because metal conducts and plastic does not, and what aluminium actually buys is a thinner frame and more glass. That is the tone-of-voice principle of saying the awkward thing first, and it is also just true. Doors compare the three ways a door gets out of the way with pane counts and the space each needs; services compare the three things that are actually wrong when somebody rings.
- **No photograph in that section, on purpose.** The range above is already the image section, and `STYLE.md` is explicit that an image whose only job is to break up white space should not be used.
- **Four FAQs per hub**, answered from data we hold rather than generalities, including one that names what the ten year guarantee does not cover. The live price guides sit alongside them, so anyone wanting a figure before speaking to a person has one, and three money pages gain internal links.
- Two copy defects caught in QA: a `'` escape that PHP does not interpret inside single quotes had put a literal backslash sequence in an answer, and the new figures were written `W/m2K` and "5,000 pounds" where the rest of the site uses a superscript two and a pound sign.
- Verified on test at 1440, 768 and 390: the range still fits one desktop viewport on all three hubs, decision figures render from the real data, four FAQs each with the first open, price links present, no guide markup left, no horizontal overflow, zero console errors.

## 2026-07-24 - Notan logo for integral blinds (test, 60004d3)

- The `notan` system had an empty logo path, so integral blinds was the one product tile on the services hub with no mark while Liniar and Sheerline sat on the others.
- **The only Notan lockup in the scrape is the reversed one**, whose wordmark is white and would have disappeared completely on the white chip. That is the exact case `STYLE.md` warns about, so the positive variant was built from it: green mark untouched, only the wordmark pixels recoloured, alpha kept so the letter edges stay smooth. The macron on the O survives. Saved as `assets/partners/notan.png` and recorded in `AI.md` so nobody swaps the scrape file back in.
- Verified on test: seven service tiles, three carrying a mark (Sheerline, Notan, Liniar), none broken. The four without one are the services with no manufacturer system, plus flat rooflights, which is still unmapped.

## 2026-07-24 - Product hubs stripped back to a one-viewport grid (test, a3d2174)

Owner: the detail boxes were over-complicating it. The whole range should sit in one viewport so a product can be picked without scrolling, with no categorisation, because there are only nine.

- **Removed, all of it mine from earlier in the day:** the filter chips and their FLIP controller, the spec chips over each photograph, the separate configurations section, and the card body with its paragraph. Configuration items went back into the same list; their wording already says what they are, so the distinction survives without a section.
- **The range is now one grid of photographs**, five across then four, with the name and one line on each and the system mark as a chip. Nothing else.
- **Fitting one viewport took measuring, not styling.** The first attempt ended 1131px down a 900px screen. Tiles are now sized from the viewport with `clamp(146px, 25vh, 250px)` rather than an aspect ratio, because a ratio cannot know how tall the screen is, and the hero was trimmed to what it needs.
- **The last 104px came from a specificity bug.** `.fg-product-hub > section` is (0,1,1), so the plain-class padding overrides on the intro and range never applied no matter where they sat in the file, leaving 52px of padding at three points. Child selectors fixed it. That is the third time today the same trap has cost time; it is now written into `AI.md`.
- Final: 870, 801 and 846 against a 900px viewport at 1440, and 855, 794 and 831 at 1280. All three hubs show their whole range without scrolling.
- Bow/bay and French casement were mapped to Liniar so their tiles carry a mark like the seven around them. Systems only, no specs or choices, so the product hub section on those two pages stays gated off; both still return 200.
- Verified: no horizontal overflow at 1440, 1280, 768 or 390, zero console errors, all images loaded, no filter or spec markup left in the DOM.

## 2026-07-24 - Distinction in the doors panel, no cost framing, even rows (test, 673c6bc)

Owner: add Distinction to the doors hero spec list, lay the products out better, and be careful with the wording, because "Folding, on a budget" for slide and fold is very bad and we should never say budget.

- **Distinction leads the doors systems panel** ahead of Liniar and Sheerline, since composite is the first card on the page.
- **The wording rule is now in `TONEOFVOICE.md`**, because it is durable and applies to every page, not just this one: never position one of our own products as the low-cost option, including the softer forms. Swept the whole hub block against the banned list and found four: "Folding, on a budget", "at a lower cost than the aluminium equivalent" on patio doors, "Warmer for the money" on the uPVC band, and "uPVC costs less" in the windows guide. A fifth, "solvable more cheaply than the caller expects", was friendly rather than damaging but reads better as scope than as price.
- **Slide and fold now says what it actually does.** Its real difference from a bifold, taken from the product intro, is that each panel slides and opens on its own, so a wide opening is not an all-or-nothing choice. That is a reason to choose it, where the old line was a reason not to.
- **Rows are even now.** The doors bands ran four then five, leaving one card alone on a row at three columns. The heritage door is single or French and its own page sells it to a garden, so it moved to the garden set: three then six, no orphan. Windows were already six then three, services two, three and two, all of which sit as complete rows.
- **Card text blocks are the same height.** Copy is clamped to three lines and the View link is pinned to the bottom of the card, so the links across a row land on one line rather than wherever each sentence happened to end.
- Verified on test at 1440, 768 and 390: no horizontal overflow, zero console errors, all cards and images present, badges uncropped.

## 2026-07-24 - Hub cards: close-ups and the system mark (test, 31b83bd)

Owner: put a small system logo in the bottom right of each product image, and make sure the images are close-ups, heritage being a bad example.

- **Audited all 25 card images by rendering them at the real 4:3 card ratio**, not by looking at the source files. Eight were wide establishing shots where the product was small or not the subject: heritage aluminium doors showed a green kitchen with the door at the edge, aluminium doors a room with a door in the distance, heritage windows a row of cottages across a field with a phone box, plus roof lanterns, integral blinds, French doors, slide and fold, and aluminium windows.
- **`product_media[slug].card` added as an optional closer crop**, falling back to `hero`. A hero is a wide banner where an establishing shot works and a card is a small cell where it does not, so they want different pictures. Replacing the heroes would have fixed the grid and broken the pages. Both still live in `product_media`.
- Seven of the eight were solved with photography already in the theme. Aluminium windows had nothing suitable, so its existing hero was re-cropped onto one window stack.
- **Each card now carries its system mark bottom right**, read from `fenster_product_hub_data()` so there is no second product-to-system map to keep in step. Services and unmapped routes get no badge rather than an invented one. White pill, because every supplier mark is dark on transparent and would vanish into a dark corner of a photograph.
- **Two CSS traps, both found by looking rather than by measuring.** A flex item keeps `min-width: auto`, so `max-width: 100%` did not shrink the 8:1 Sheerline mark and it clipped mid-word; sizing from the box with `object-fit: contain` fixed it. Then `.fg-product-hub__media img` turned out to match the badge as well as the photograph, and at equal specificity its `object-fit: cover` won on source order, cutting Distinction down to "ISTINCTIO". The photo rule is now scoped to the direct child. Worth remembering before putting an image inside another image's container.
- Verified on test at 1440, 768 and 390: 9, 9 and 7 cards with every image loaded, all eight system marks rendering inside their pill uncropped, no horizontal overflow, zero console errors.
- **Open for the owner:** `/slide-fold-doors/` and `/flat-rooflights/` have no system mapped in `product-hub-data.php`, so those two cards carry no badge.

## 2026-07-24 - Product hub hero and banded range (test, bf7759b)

Owner feedback on the first pass: the hero needs fixing and styling, add a box with the systems (Liniar, Sheerline and Roseview for windows, Liniar and Sheerline for doors and services), the text box is awkwardly placed and too close to the CTAs, and is there a better way to lay the products out.

- **The hero was a heading in one column and a loose paragraph in the other**, bottom-aligned, with the buttons at `1.15rem` under the sentence. It read as a floating text box rather than a composition. The lead is now one block, eyebrow through to the action pair, capped at `40rem` so the line length is readable, with `clamp(1.6rem, 2.6vw, 2.1rem)` of air above the buttons.
- **The opposite column is now a defined panel** rather than stray text: the systems we fit, each with what it is for. Logos sit in a fixed box because the three marks run from 2.2:1 to 8:1, so height governs Liniar and Roseview while width governs Sheerline. A first attempt at 96x30 squeezed the squarer two to a thumbnail; 132x40 lets all three read.
- **The range is banded rather than one flat list.** Windows split uPVC from aluminium, which is the guide's own third question answered by the layout. Doors split by where the door goes, which is the first thing we ask on the phone and the one that rules most of the list out. Services split roof glazing, glass and blinds, and maintenance. This turns nine equal cards into two or three scannable decisions.
- **Bands cannot drop a product.** Anything no band claims still renders in an unlabelled band at the end, so adding to `products` without touching `bands` fails visibly rather than silently.
- Responsive behaviour: the panel sits beside the lead above 1180, becomes a full-width three-across strip between 620 and 1180, and returns to stacked rows below 620 where three columns would be too narrow for a logo.
- Verified on test at 1440, 900, 768 and 390: no horizontal overflow at any width, zero console errors, all cards and images present, headings inside the cap.

## 2026-07-24 - One real product-selector template for windows, doors and services (test, 55d15bc)

Owner: `/other-services/` needs to be an actual page rather than a scraped template, the windows and doors pages need redesigning, and all three should share one main product selector built from what the good pages (about, sash, composite, roof lanterns) and `STYLE.md` established.

- **`/other-services/` was in `$is_utility_page`**, which is why it rendered as a scrape shell: H1 "Other Services", 1,801 words of imported filler, and a meta description opening with "Discover our other services". It is a product-selector hub like the other two and now runs the same template with theme-owned SEO.
- **The old `windows-hub.php` served windows and doors through a tab control** that showed one product and hid the other eight behind a click. On a page whose only job is to route someone to the right product page, that is the wrong shape. The range is now a grid with every product visible, each carrying the reason to pick it over its siblings.
- **Card imagery reads from `product_media[slug].hero`** rather than being stored a third time. The old template held its own hardcoded list still pointing at scrape assets (`Casement_03.jpg`, `Flush_Sash_001.jpg`), which is exactly how hub and product pages drift apart. Only `/flat-rooflights/` sets an explicit image, because it has no `product_media` entry.
- **H1s are theme-owned now.** They were inherited from the scraped page record. The windows and doors values are byte-identical to what was already ranking; only `/other-services/` changed, to "Roof glazing, blinds, roofline and repairs".
- **Case studies use a new `fenster_case_studies_for_product_group()` with no fallback.** `fenster_case_studies_for_product()` returns every study when nothing matches, which is the documented reason product pages with no study of their own show unrelated jobs. The hub renders nothing rather than making that claim. Windows and doors matched 3 studies each, other services 2.
- **The grid immediately exposed three weak heroes** that were survivable in isolation. Replacement Glazing and Secondary Glazing shared one photograph, so the two cards sat side by side showing the identical window; secondary glazing now leads with an original sash bay from inside, which is the situation that work is for. Aluminium Windows led with a coastal cottage where the windows were not the subject, and Aluminium Flush Windows led with a CGI corner profile on white that read as a diagram beside eight photographs. Both now use Sheerline Prestige photography. Verified afterwards that no product shares a hero with any other.
- Removed rather than left dead: the 66-line tab controller in `src/js/main.js` (compiled JS 97.8kb to 96.4kb) and 119 lines of SCSS across five blocks.
- **SCSS removal method worth repeating.** A first attempt with a naive brace scanner left the file two closing braces out of balance, because it counted braces inside comments. Reverted and redone with a pass that maps comment and string spans first, then only scans real code. `AI.md` already warns against index slicing on this file; naive brace matching fails the same way.
- Verified on test at 1440x900, 768x1024 and 390x844 across all three routes: 9, 9 and 7 cards with every image loaded, no horizontal overflow at any width, zero console errors, headings inside the cap, and no trace of the old selector.

## 2026-07-24 - Second release of the day promoted to live (4458fc6)

- Live re-established by checksum first, as the rule now requires: six theme files matched `94e7d0f` byte for byte, confirming the pointer written earlier the same day was still accurate.
- Range check `94e7d0f..4458fc6` returned six commits, all this session's, 16 files, 183 insertions and 239 deletions. Nothing from a concurrent session, so no cherry-picking. Compiled assets were confirmed to carry the changes before shipping, since a stale build has shipped before on this project.
- Backup `fenster-pre-4458fc6-20260724-102814.tar.gz` (364M), server repo cache pinned to the explicit SHA, theme-only rsync, WP and SiteGround caches purged.
- Production verification: six theme files match the committed tree byte for byte; fourteen routes return 200; `/double-glazing-milton-keynes/` still carries its head-term marker. Each change confirmed on live rather than assumed: no `Step 2 of 2` anywhere, the audience gate pre-selected, heritage at six slides with `01 / 06` and no remaining `toplight` string, the lantern wall present with the old carousel slides gone, the colour hero photograph in with the old tiles gone, and the `max-width:none` fix present in the served CSS.
- Browser QA on the live URLs across six routes at 1440x900 and 390x844: no horizontal overflow anywhere, zero console errors, every heading inside the 57.6px cap.

## 2026-07-24 - Roof lantern S1 selector rebuilt on the composite door wall (test, 474e39d)

Owner: the heritage configurations look good now, but the roof lantern selector needs revamping, "maybe do it like the composite door page has it, the slow moving side to side bit".

- **The S1 layouts were running on `fg-colour-carousel`**, the coverflow built for scrubbing paint swatches. Thirteen layouts is a range to browse, not a value to pick, which is why it read wrong. It now uses the composite door wall: a slow sideways drift you can also grab, pausing on hover and for a moment after a drag.
- **Shared, not copied.** Same `.fg-cd3-wall__viewport`, same track, same `[data-fg-door-wall]` controller, so the two walls cannot drift apart. Only the card is new. A lantern render is a wide product shot floating on white, so `.fg-lantern-card` contains it on a soft panel with the label underneath, rather than cover-cropping it under the dark gradient a portrait door photograph wants. The clone-hiding rules for `860px` and reduced motion now name both card classes.
- The old carousel styles were deleted rather than left dead, and the per-slide `01`/`02` numbers went with them.
- Verified on test. Desktop: drift running at ~54px/s (`scrollLeft` 50 to 185 over 2.5s, matching `SPEED 0.9` x 60), 13 real cards plus 13 clones, cards 300x241. Mobile at 390: drift off, clones hidden, cards 250x211, native swipe rail with a partial next-card peek. No horizontal body overflow at either width, zero console errors.
- **A QA trap worth recording.** A first pass reported only 6 of 13 images loaded after scrolling the wall through. That was the test, not the page: the drift writes `viewport.scrollLeft` every frame, so it immediately overwrote the scroll position the test set. Pausing the drift with a `pointerenter` first gave 13 of 13 loaded, 0 broken. Pause the drift before measuring anything that depends on scroll position.

## 2026-07-24 - Four fixes: form audience, heritage configs, colour hub hero, card edge (test, 75245fc)

Four items picked off the owner's backlog. EnergyPlus/Thermlock was explicitly deferred as too broad; the homepage window photo was kept as-is with only the edge defect fixed.

- **The enquiry-type gate now opens pre-selected** on the audience the page is already speaking to, instead of making every visitor answer "homeowner or business?" before seeing a single field. Both buttons stay so a visitor on the wrong page can switch. Two things worth knowing: pre-selection deliberately does not move focus on load, and the homeowner button now carries the page's own `project_type`, so a lead from `/window-handles/` reports `Windows` rather than being flattened to `Residential windows and doors` the moment anyone clicked through. **Commercial routes needed no change** — they already pass `lock_project_type`, so they render no gate and are fixed to `Commercial glazing`. The `audience` default derives from `show_company`, so any future unlocked commercial form is correct without a call-site edit.
- **Heritage configurations cut from nine to six** on owner instruction: the three toplight renders are out, leaving single and French at no bars, 2 bar and 4 bar. The per-slide `01`/`02`/`03` numbers are gone; the carousel's own position counter stays. Copy updated in three places, including the quote-tool paragraph that gave the toplight as the reason we cannot price these online. The removed assets stay on disk. **Toplights remain listed as an available layout in `product-hub-data.php`** — left deliberately, because stocked and available are different things, and flagged to the owner.
- **Colour hub hero replaced.** It was a five-tile collage of cropped swatches, which said nothing a customer could use. It is now one photograph of a flush casement finished black outside and white inside, captioned as such. The uPVC and aluminium sections now explain the actual difference: uPVC colour is a foil bonded to a white profile, which is why you see white on the rebate of an open window unless both faces are specified; aluminium is powder coated, which is why those finishes read as RAL codes with a sheen level rather than names. The retired tile CSS and its mobile overrides were deleted rather than left dead.
- **The dark strip down the right edge of the homepage category card** was not a border. The site-wide `img { max-width: 100% }` reset was clamping that component's intended `width: 106%` back to 100% while `inset: -3%` still shifted the image left, exposing ~18px of the frame's `#082c35` background, curving with the 64px corner radius. Opted the image out of the reset. Bleed measured before: 21.9px left, **-15.5px right**. After: 21.9px both sides.
- Verified on test at 1440x900 and 390x844: no horizontal overflow, zero console errors, six heritage slides with no index numbers, gate pre-selected with `document.activeElement` still `BODY` on load, colour hero serving `200 image/webp` and correctly hidden on mobile per the existing rule.

## 2026-07-24 - Product imagery promoted to live (94e7d0f)

- **Establishing what live actually ran took a checksum sweep again**, because every doc pointer was stale: `LIVECHANGES.md` still claimed `b0ec36a` on the retired `release/heritage-doors` branch, and `AI.md`/`HANDOVER.md` claimed `f4ad6fb`. Production was `fa6596b`. Six of the usual theme files were identical across `5672fb9..fa6596b`; the only discriminators were `inc/generated-pages.php` (the homepage H1 change) and `assets/email/google-reviews.png` (re-exported in `fa6596b`). All four pointers are now corrected.
- Range check `git log --oneline fa6596b..94e7d0f` returned exactly two commits, both this session's, touching one PHP file, 23 new images and three docs. Nothing from a concurrent session.
- Backup `fenster-pre-94e7d0f-20260724-085656.tar.gz` (361M), server repo cache pinned to the explicit SHA, theme-only rsync, WP and SiteGround caches purged.
- Production verification: deployed `inc/site-data.php` matches the committed tree byte for byte; fifteen routes return 200 including all six changed pages, `/`, `/online-quote/`, the three MK head terms, `/areas-we-cover/` and `/sitemap.xml`; `/double-glazing-milton-keynes/` still contains its `Choose the product family first` marker; all ten spot-checked WebP assets serve `200 image/webp`. Browser QA at 1440x900 and 390x844 on the live URLs: no horizontal overflow, zero console errors, max heading 57.6px at the cap, none of the new assets broken, and the six heroes are visibly six different products.

## 2026-07-24 - Six product routes get their own photographs (test, 29f666b)

Owner report: several product pages carry the wrong or the same images, with the instruction to match Sheerline's own products to ours (lift and slide goes to aluminium sliding doors) and to look at every image rather than pick by filename.

- **Confirmed by fetching the pages, not by reading the data.** `/flush-casement-windows/`, `/tilt-turn-windows/`, `/french-casement-windows/` and `/bow-bay-windows/` rendered the *same thirteen* images as each other, because all four were mapped to the one `upvc_windows` gallery pool. `/aluminium-sliding-doors/` had exactly one sliding door on it and otherwise showed composite, uPVC and bifold doors from the shared aluminium pools.
- **Each route now has its own pool** in `inc/site-data.php`: `flush_casement_windows`, `french_casement_windows`, `tilt_turn_windows`, `bow_bay_windows`, `casement_windows`, plus a rebuilt `aluminium_sliding_doors`. `upvc_windows` stays as the deliberately mixed pool for `/double-glazing/` only.
- **`/aluminium-sliding-doors/` is now Sheerline Prestige Lift & Slide**, which is the system this page sells. Hero is the real anthracite install on brick; the pool adds the three-pane interior, the timber-clad run, the handle with its flush hook-lock, the track and threshold.
- **Two heroes were plainly the wrong product.** `/tilt-turn-windows/` led with a casement handle close-up; it now leads with a tilted sash and shows the tilt hardware twice. `/french-casement-windows/` led with a Sheerline *aluminium* window on a uPVC page; it now leads with a French casement opened from the centre and shows the mullion and shootbolts. `/casement-windows/` led with a bay window, which has moved to the bay pool where it belongs.
- **Resolution was a second, quieter problem.** The flush, bay and casement heroes were 600px and 1080px crops standing in for photography that exists at 5,000 to 6,700px in the Liniar source. Those are regenerated at 1400-1600px WebP.
- 23 new assets under `assets/images/products/{aluminium-sliding,flush-casement,casement,tilt-turn,bow-bay,french-casement}/`, every one under 400KB. Sources are the Sheerline and Liniar scrapes plus `product_image_bank_20260710`; runtime code does not touch the exports. Alt text is written from what is in the frame.
- **Found unused correct imagery already in the theme.** `assets/images/imported/` was carrying five tilt and turn photos, five French casement details and five bow/bay shots that nothing referenced, while the pages they belong to showed generic casement stock. Those are now wired up rather than re-imported.
- **One defect caught by looking at the rendered page.** The Liniar French casement bedroom shot put the window in the top-right corner, so the portrait body cell cropped the window out entirely. Re-cropped around the window before shipping. This is the case for viewing the page rather than trusting the image list.
- Verified on test at 1440x900 and 390x844 over CDP: no horizontal overflow at either width, zero console errors, max heading 57.6px at the cap, and all six routes now render distinct product-correct imagery. The remaining shared images on each page are `fg-link-card` thumbnails for *other* products, which is what that component is for.
- The 13-town product matrix shares these pools, so the correction lands on the location variants too. Live is untouched.

## 2026-07-22 - Real local knowledge on the MK suburb pages (test)

- The twelve Milton Keynes suburb routes were interchangeable: swapping the town name changed nothing. `fenster_mk_suburb_profiles()` in `inc/generated-pages.php` now carries genuine local substance per suburb, rendered as a "What we see on {town} homes" section above the case studies.
- The detail is property age and type, which is verifiable and commercially useful: Bletchley's pre-new-town terraces and 1930s bay-fronted semis (and the structural point about bays), Wolverton's 1838 railway terraces wanting their proportions kept, Stony Stratford as a Georgian conservation town, Newport Pagnell's split between historic centre and estates, the 1970s and 1980s grid squares (Oldbrook, Great Linford, Shenley Church End, Furzton) on failing first-generation replacements, Monkston's 1990s uPVC where reglazing often beats replacement, and Whitehouse and Brooklands as new-build upgrade and extension work.
- **Makes no claim about jobs completed in any area.** The case-study section already provides proof where it genuinely exists and renders nothing where it does not; inventing local credibility would undo the point of both sections.
- Renders only on the twelve MK suburbs. Verified on test: Bletchley, Wolverton and Whitehouse each show their own copy, Luton correctly shows none, word count up from roughly 1,440 to 1,570, no overflow and no console errors.
- The other half of plan Tier 1, redistributing internal links away from the far ring, was deliberately skipped: those pages rank 19–66, so link shuffling would be tidying rather than winning. Recorded in the plan.

## 2026-07-22 - MK search push and authenticated email promoted to live (f4ad6fb)

- Range-checked `ef2b6c3..f4ad6fb`: 28 commits, of which seven were this session's (town case-study proof, MK titles and metas, guide routing, the SMTP auth pin and its correction) and the rest the concurrent session's composite-doors mobile and construction work. Owner approved the whole range, consistent with the two earlier releases today.
- Backup `fenster-pre-f4ad6fb-20260722-152836.tar.gz` (361M), server repo cache pinned to the explicit SHA, theme-only rsync, WP and SiteGround caches purged.
- Production verification: authenticated email still sends after the deploy (`AuthType: LOGIN`, send SENT), live Google reviews still return 4.9 from 133 with five cards, and ten routes return 200. Browser QA confirmed the Whitehouse town page renders two real local case studies and the soundproofing guide renders its new next-steps block, with no overflow and no console errors.
- Live and `main` are level at `f4ad6fb`.

## 2026-07-22 - Authenticated email live

- Brevo SMTP is now configured on **live** as well as test. Verified on production: the transport sends, and the customer confirmation template builds and delivers. The owner confirmed the test messages arrived in the **inbox** (not junk) and correctly from `info@fensterglazing.com` rather than a generic no-reply, which is the Brevo domain authentication working.
- Customer confirmation emails are therefore live for real enquirers for the first time since launch. Public copy may now promise a confirmation.
- Office lead notifications now also route through Brevo as `info@` instead of unauthenticated `wordpress@`. The transport was tested explicitly on live before sign-off because a broken relay would silently stop lead delivery.
- Note for future testing: `fenster_enquiry_office_email()` takes `(array $data, int $enquiry_id, array $attachments)` and its rows are strictly typed, so a partial `$data` array throws. Build a complete record, or test the transport with a plain `wp_mail()` call, rather than passing a stub.

## 2026-07-22 - Authenticated email working (test)

- The website has never sent authenticated email, so customer confirmations have been off since launch and every enquirer got silence. Fixed on test.
- **Correction to the first diagnosis.** The `535` failures were initially blamed on PHPMailer negotiating CRAM-MD5. That was wrong: live subsequently authenticated successfully *using* CRAM-MD5 (`235 Authentication succeeded`) before the change was deployed there. The real and only cause throughout was an incorrect `FENSTER_SMTP_USERNAME` (an account email rather than Brevo's generated `…@smtp-brevo.com` login). `AuthType` is still pinned to `LOGIN` for determinism across environments, but the original justification was false and is corrected here so nobody inherits it. **Treat `535` as wrong credentials first.**
- Microsoft 365 was tried first and is unavailable: `535 5.7.139 SmtpClientAuthentication is disabled for the Tenant`. Enabling it needs a tenant-wide switch that re-opens basic auth, and Microsoft is retiring the protocol, so the site now relays through Brevo instead. The connection test also proved SiteGround permits outbound 587 with STARTTLS.
- Brevo domain authentication is in place (DKIM 1 and 2, branded record, redirection records all matching). DMARC needs a `rua` tag added to go green; it does not block sending. A genuine syntax error was also found in the live SPF record: `include:_spf.smtp.com~all` has no space before `~all`, making it an invalid term that can break parsing for all Fenster mail, including Microsoft 365. Owner to fix at the DNS provider.
- Verified on test: SMTP detected, plain send accepted, and the real `fenster_enquiry_customer_email()` template built and delivered. Customer confirmations are therefore live on test.
- **Live is deliberately untouched.** `fenster_configure_smtp()` routes every `wp_mail()` through SMTP once a host is set, so bad credentials would silently stop office lead notifications. Live gets these values only after the owner confirms the test messages arrived in the inbox rather than junk.

## 2026-07-22 - MK search push: town proof, title gaps, guide routing (test)

Four items from `HIGH-INTENT-SEARCH-PLAN.md`, all on test only.

- **Town pages now carry real local proof.** `fenster_case_studies_for_town()` matches the study `location` field, exact town first, then the wider Milton Keynes area for the twelve MK suburb routes. Renders through the existing shared card above the FAQs. Verified: Whitehouse and Wolverton lead with their own job, Bletchley borrows the MK studies, Leighton Buzzard shows both of its own, Northampton shows its one, and Luton and Hitchin correctly show nothing rather than passing off a distant job as local.
- **Brand result investigated and closed with no work.** From a Milton Keynes location the site is already #1 organic for `fenster glazing` with sitelinks and a knowledge panel. The GSC 4.0 average is non-local and international impressions (`fenster` is German for window; the bare query is 545 impressions at position 8.2). Brand CTR is 20.37%. Recorded in the plan so nobody re-opens it.
- **Title and meta gaps closed.** `aluminium-windows` had no override and was serving imported scrape wording ("Aluminium Windows Supply") on 521 impressions at position 18.6. `windows-milton-keynes` is also the landing page for "replacement windows", "uPVC windows" and "window installer" in MK, 1,813 impressions between them, so the title now carries that intent. Both MK head terms lead on instant online pricing. Pages already ranking (`composite-doors` 7.9, `casement-windows` 10.0) were left alone rather than churned. All titles under 60 characters, metas under 160, no em dashes.
- **Guide traffic routed to money pages.** Four guides drawing 32,500 impressions a quarter had no next-steps block: soundproofing, U-values, triple vs acoustic glazing and winter condensation. Each now routes to the commercially correct answer; the condensation guide separates ventilation from a failed sealed unit, which is a repair we sell.
- Verified on test at 1440x950 and iPhone 13: blocks render, all link targets return 200, no horizontal overflow, no console errors.

## 2026-07-22 - Review summary polish to live (ef2b6c3)

- Owner feedback on the new review section: drop `Leave a review`, make Trustpilot a real second button in the site's usual green-then-steel pairing, and reduce the height of the summary panel.
- Removed the leave-a-review action (it targets existing customers on a section meant to convert new ones), promoted Trustpilot to `.button--steel`, and trimmed the panel padding, score figure, heading scale and action-row spacing together rather than squeezing one element. Desktop summary now measures 228px.
- Range-checked `79c464b..ef2b6c3`: 28 commits, only one the review tweak, the rest the other session's composite-doors work from the same day (colour wall replacing the configurator, draggable door wall, collection corrections). The owner again approved shipping the whole range, so this release also promoted that work.
- Backup `fenster-pre-ef2b6c3-20260722-132742.tar.gz` (360M). Verified on production: live Google data still 4.9 from 133 with five cards, eight key routes 200, both buttons rendering the correct green/steel, no overflow and no console errors at 1440 and iPhone 13.

## 2026-07-22 - Live Google reviews released, plus the accumulated main branch (79c464b)

- Replaced the hardcoded review showcase with live Google data. `inc/google-reviews.php` reads the rating, review count and latest reviews from the Places API (New), caches for six hours, resolves and stores the Place ID once, and falls back to the curated set plus owner-verified figures when no key is configured. The API key lives in Bedrock `.env` as `FENSTER_GOOGLE_PLACES_API_KEY` alongside the OpenAI key and is never committed.
- Rebuilt the section: rating panel with half-step gold stars and the real review count, Google branding, reviewer photos and names as Google's terms require, relative dates ("4 weeks ago"), clamped card text, and genuine read/write-review links built from the Place ID. The pre-existing bug where every review link pointed at a Google *search query* instead of the review panel is fixed at the data source; the stale 2025 curated URLs were cleared.
- Schema: `hasOfferCatalog` now lists the real 20-service product range mirroring the Google Business Profile, `areaServed` leads with Milton Keynes and its suburbs before the counties, and `foundingDate`/`currenciesAccepted` were added. `hasMap`/`sameAs` use the canonical `?cid=` place URL with the Places API's per-request `g_mp` tracking parameter stripped. **`aggregateRating` was deliberately not added** — Google does not show review rich results for self-serving reviews about the business itself, so it would carry risk without producing stars.
- **Live incident during setup.** The instructions given for adding the key were written as a shell block beginning with `ssh …`, and were pasted into the live `.env` verbatim. Bedrock's phpdotenv parser throws on any line that is not `NAME=value`, so every production page returned 500. Recovered by backing the file up (`~/env-backup-live-*.bak`) and stripping non-assignment lines. Lesson recorded: when asking the owner to edit `.env`, give exactly one `NAME=value` line and say explicitly that nothing else belongs in the file.
- Live deploy: range-checked `b0ec36a..79c464b` (35 commits) and surfaced that only six were the review work; the owner explicitly approved shipping the rest. Backed up (`fenster-pre-79c464b-20260722-105406.tar.gz`, 348M), pinned the server repo cache to the explicit SHA rather than `origin/main`, rsynced theme-only, flushed WP and SiteGround caches. **This release therefore also promoted composite doors V2, the Bolbeck Park and Wolverton case studies, the archive show-more, the Aaron Isaacs team profile and the heritage door refinements.**
- Production verification: live Places API returns 4.9 from 133 reviews with five live review cards; eleven key routes return 200 (`/`, `/online-quote/`, `/composite-doors/`, `/casement-windows/`, `/heritage-aluminium-doors/`, `/case-studies/`, `/why-trust-fenster/`, `/contact/`, `/double-glazing-milton-keynes/`, `/meet-the-team/`, `/sitemap.xml`). Browser QA at 1440x950 and iPhone 13: real reviewer names and photos, no horizontal overflow, zero console errors.

## 2026-07-21 - Heritage aluminium doors promoted to live (b0ec36a)

- Owner approved the live release while away from the laptop. Fixed the last defect first: the configuration slides overlapped the heading copy. The carousel slides are absolutely positioned at `top: 50%` in a viewport with `overflow: visible`, so a slide taller than that box spills equally above and below it. These portrait door renders measured 517px against a 450px box, so 34px spilled up and ran 18px into the heading paragraph. The roof-lantern carousel the pattern came from uses 16:9 landscape renders and never hit it. Box is now sized from the slide (520px desktop, 460px at 560px and below) and the slide narrowed to `min(28%, 225px)` so the taller box still leaves the section at 799px, inside the ~830px budget. Measured clearance after the fix: 22px desktop, 43px tablet, 19px phone, with the nearest slide 35 to 59px clear of the heading.
- **The release was rebuilt on top of the live commit rather than deployed from `main`.** `git log 658ba34..ce4c76c` was nineteen commits and only seven were this work; the other twelve were another session's composite-door redesign and two new case studies, none approved for production, with an open owner question still recorded against the composite page. Deploying `main` wholesale is exactly what put unapproved composite work on production on 2026-07-18.
- Establishing what live actually ran took a checksum sweep, because the deployed theme has no `.git`: `assets/css/main.css` matched `f2c16ad`, but `inc/adminbase.php`, `template-parts/sections/generated-page.php` and `inc/site-data.php` together pinned it to `d2d5aa3`/`658ba34`. The docs had claimed `af4cfc2` and `de13375`, both stale.
- Built `release/heritage-doors` from `658ba34`, applied only this work's hunks to the four shared PHP files (32 insertions, 8 deletions, verified line by line as heritage-only), composed `main.scss` from live's copy plus the heritage block and the form-selector extension, then rebuilt the compiled assets from that tree. Confirmed absent from the compiled CSS and JS: `fg-cd3-wall`, `fg-cd3-palette`, `fg-cs-show-more` and the case-study show-more handler. The compiled JS came out 94.8kb against `main`'s 95.2kb, which is the other session's JS correctly not shipping.
- Deployed `b0ec36a` to the protected test site first and re-verified, then took a live theme backup (`~/backups/fenster-theme/fenster-pre-b0ec36a-20260721-161757.tar.gz`, 346M) and deployed the same SHA to production with `wp cache flush && wp sg purge`.
- Verified on production: eleven routes return 200 including the homepage, quote tool, `/casement-windows/`, `/double-glazing-milton-keynes/` (head-term template marker present), `/case-studies/` and the Northampton heritage matrix page; `/composite-doors/` still serves the previous live version with no `fg-cd3-wall`, confirming nothing leaked; `page-sitemap.xml` holds 693 URLs including the heritage route; all 29 page images load with none broken; no horizontal overflow at 1440x900, 768x1024 or 390x844; max heading 52px against the 57.6px cap; no console errors; the carousel advances through all nine configurations.
- **Live and `main` have now deliberately diverged.** Before the next promotion, decide with the owner which composite-door and case-study commits are actually wanted, and build that release the same way. `LIVECHANGES.md`, `AI.md` and `HANDOVER.md` all carry the corrected live pointer.

## 2026-07-21 - Heritage aluminium doors: dedicated Sheerline Classic page (test, 2f69c17)

- Owner report: `/heritage-aluminium-doors/` was showing images of uPVC doors. Confirmed by fetching the route. Root cause was in `inc/site-data.php`: `product_gallery_groups` mapped the route to the generic `aluminium_doors` pool, which is mostly modern Sheerline Prestige entrance doors plus two window profile close-ups. The white flat-panel Prestige doors (`sheerline-aluminium-door.jpg`, `Prestige-aluminium-door-in-stone-web.webp`) and the grey threshold crop read as uPVC to a customer. Wrong product, wrong century.
- Owner chose a full dedicated page over an image swap. New `template-parts/sections/heritage-aluminium-doors.php`, dispatched from `generated-page.php` on the slug, following the `roof-lanterns.php` pattern. Nine sections: hero, four-fact specification strip, the nine stocked configurations as a coverflow carousel, period lockbox and stepped-bar detail, Thermlock plus corner-joint construction, two jobs the doors do well, the Secured by Design upgrade, the twelve standard colours, enquiry, reviews.
- 36 local WebP assets under `assets/images/products/heritage-aluminium/`, built from the Sheerline scrape at `Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\sheerline_scrape_20260612`. The nine configuration renders were cropped through **one shared window** rather than trimmed individually, so a toplight door still reads taller than a plain single door. Runtime code does not touch the scrape export.
- The nine renders are in the scrape as `1-anthracite.jpg` through `9-silver-metal.jpg` and map 1:1 onto the configuration headings in `Classic-Heritage-Door-Sheerline.md`. Every label was checked against its render before publishing: bar counts and toplights match.
- Facts are rewritten from the Sheerline source, not pasted: 60.5mm sightlines, 1.4 W/m²K double glazed, max sash 2.2m x 1m, opens in or out, single or French, twelve standard powder-coated colours, dual and bespoke colours available, 25mm and 40mm flat or stepped bars, Thermlock at close to double the insulation of polyamide, cleated corners. Secured by Design is stated as an optional upgrade rather than the standard, because it is.
- `product_usps` for this route dropped the `Any RAL colour` claim. **The same claim is still on seven sibling aluminium routes and one product-hub choices list.** It needs an owner decision rather than a silent sweep; a background task was raised.
- Two defects found by looking at the rendered page rather than the metrics. The shared enquiry form's dark defaults leaked into the new white panel, so every input rendered white on white and the consent row grey on grey; fixed by extending the existing `.fg-roof-lantern-form` light-panel rules to `.fg-heritage-door-form` instead of writing a second copy. The three hero bullets pushed the door photograph below the fold at 390x844; hidden at 560px, matching the roof-lantern hero.
- Verified on test at 1440x900, 768x1024 and 390x844 via CDP headless Chrome: no horizontal overflow at any width, 29 of 29 images loaded with none broken, max heading 52px against the 57.6px cap, zero console errors, carousel advances through all nine slides. Every section I authored fits the ~830px desktop viewport budget; the shared enquiry form is 900px, which `STYLE.md` permits.
- Also committed `src/scss/main.scss`, which had drifted: `b07c12d` shipped a compiled `main.css` whose source was never committed. Source and compiled now match again. Live is untouched.
- **Copy correction after owner review (`29661a1`).** The security section was written against `STYLE.md` without reading `TONEOFVOICE.md`, and the owner rejected it. It failed that document's own self-check: no name, place, date or number in the section, and lines a competitor could have pasted unchanged ("police-backed standard", "passed the scheme testing"). It also opened with "We would rather say this plainly", which is the About page's phrase borrowed rather than earned, and announces plainness instead of being plain. Rewritten to name the industry habit directly, then make the decision physical: a walled courtyard against an unlit alley, a four bar door's five small panes against one sheet of glass at chest height, closing on being happy to say no. The `Ask about the security spec` button was dropped because it scrolled to the same form the hero CTA already targets, which `STYLE.md` rules out as a duplicate primary action. **Read `TONEOFVOICE.md` before writing page copy; `AI.md` already says so and this session did not.**

## 2026-07-22 - Composite doors: button system, light installer panel, verified hero image (test, 834feb1)

Owner feedback after the previous round, some of it repeat feedback that earlier passes had not actually addressed.

- **Site-wide CTA rule captured in `STYLE.md`:** anything acting as a call to action is a button, never a text link, including phone numbers; and the pair is green primary (`.button`) then dark secondary (`.button--steel`, new reusable variant matching the header's `Book consultation`). Applied across the whole route, so no `text-link` CTAs remain (verified zero in the rendered page). **Exception found in testing:** on the dark security and configurator panels a dark secondary is invisible against the panel, so those two use `.button--light`. That exception is documented.
- **Approved installer strip properly rethought rather than re-tinted.** The reason three previous attempts all looked the same is that `assets/partners/distinction-doors.png` is a solid white rectangle with **no alpha**, so against a dark bar it can only ever read as a sticker in a box. The strip is now a light white panel with a green left rule; the logo sits flush on it with `mix-blend-mode: multiply` and no container, and the phone is a dark button.
- **Hero image verified rather than assumed.** Every candidate was rendered at the real 6/5 hero crop before choosing: the previous `venture-urban-entrance` was cut off top and bottom at that ratio. `black-lunna-entrance` is the only one where a whole door sits centred and uncut. Hero decluttered by dropping the three bullets, which duplicated the specification strip immediately below them, and by shortening the lead.
- **Collections relaid out** from six cramped columns to three across on two rows with horizontal cards, so names stop wrapping and the copy is readable. Two columns at 1180, one at 860.
- **The £5,000 treatment is now typographic.** The drawn SVG shield read as a pasted-on knockoff of the supplier badge; the figure itself is now the graphic, at 3-4.2rem above a rule.
- **Mistake made and corrected in this session:** an earlier commit (`dc174b8`) edited `main.scss` with a script whose slice indices were inverted, which duplicated a block, left an unmatched brace and broke the Sass build. That was pushed before the build error was noticed, so the compiled CSS shipped stale for one commit. The stylesheet was reverted to the last good state and every change re-applied as a targeted edit; `230ddc4` carries the fix. **Do not batch-edit `main.scss` with index slicing;** the file has repeated selector names inside and outside media queries, so `str.index` is not safe. Use targeted edits and check brace balance before committing.
- Verified: hero 595 plus brief 137, installer panel 158, collections 854, security 524. No horizontal overflow at 390, 768 or 1440, zero console errors, and `/casement-windows/`, `/roof-lanterns/`, `/heritage-aluminium-doors/` and the homepage all still 200.

## 2026-07-22 - Composite doors: approved hero pattern, real guarantee terms (test, 1a2e909)

Owner promoted `main` to live earlier in the day, then asked for a further round: drop the "a door we actually fitted" kicker, make the hero look like `/roof-lanterns/` and `/heritage-aluminium-doors/`, make the approved-installer bar more premium, turn CTA text links into buttons, and improve the £5,000 lock treatment. They also supplied the guarantee's actual terms.

- **Hero rebuilt on the approved pattern.** Composite no longer uses the shared `.fg-hero` at all; it has its own light hero with copy left, a boxed image with a caption chip right, three ticked bullets and a four-item specification strip. Crucially the styling is **shared, not duplicated**: `.fg-cd3-hero*` and `.fg-cd3-brief*` were added to the existing `.fg-heritage-door-hero*` / `.fg-heritage-door-brief*` selector lists, so the three routes cannot drift. H1 is now `A front door you never have to paint.` with the keyword moved to the eyebrow, matching how those two routes handle it. The price card is gone; the checked figure survives in the quote section, the FAQ and the prices guide. Verified other product routes still render the old dark hero unchanged.
- **£5,000 guarantee terms confirmed by the owner**, closing the open item `AUDIT.md` raised: it is a *break-in* guarantee resting on AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock, paying up to £5,000 in compensation should either fail in a break-in, terms applying. Recorded in `AI.md` under owner-confirmed facts. The band now states this properly and the four supporting points name the actual hardware instead of generic security features. Added an inline SVG shield badge (`.fg-cd3-shield`) so it needs no asset and stays sharp at any size.
- **Approved installer bar made premium:** it was flat steel. It now has a layered gradient with a green wash, inset highlight and shadow lines, a lifted gradient check mark, a framed logo tile and more vertical room.
- **CTA text links became buttons** per the owner's rule: the door wall's `Or price one yourself` is now a `Price one yourself` ghost button, and the quote aside's inline prices-guide link became a `See example prices` button.
- **Fixed stale data the collections change had orphaned:** `product_usps` for composite still advertised `Signature & Contemporary`, a split the page no longer uses anywhere. Now Collections/Door slab/Break-in guarantee/Guarantee.
- Verified on test: hero 595 plus brief 137, installer bar 92, security 573, all other sections unchanged and inside the viewport budget. No horizontal overflow at 390, 768 or 1440, zero console errors, and `/casement-windows/`, `/roof-lanterns/`, `/heritage-aluminium-doors/`, `/upvc-doors/` and the homepage all still return 200 with their own heroes intact.

## 2026-07-22 - Composite doors: mobile pass (test, 165f04a)

Owner asked for the mobile layout to be made properly nice, with the collections behaving like the product carousel on the homepage, and specifically that the doors show at full length rather than being cropped.

- **Collections are a swipeable carousel on mobile and tablet**, matching the homepage product row, with snap points and a dot indicator that reports the card nearest the start edge.
- **Every door in the carousel now lands at the same height.** The six renders range from 0.406 to 0.453 wide-to-tall, so sizing each card to its own door left the row ragged. The image area is a fixed portrait panel on a soft tint and each door is `object-fit: contain`, bottom-aligned, with a drop shadow. Verified on test at 390: all six doors 466px, all six cards 670px, nothing cropped.
- **The caption moved below the door** onto white with a top rule, and the overlay scrim came out. Previously the text sat over the door, which hid part of it and made contrast a fight.
- **Both card rows are a fixed height**, so the caption box is identical on every card and the longest paragraph no longer sets the height of the row. The caption also overlaps the base of the image panel, which the figure reserves as bottom padding so the overlap rides over the tint rather than over the door. Card height came down from 670px to 521px, caption box fixed at 162px, doors 337px and level. Nothing clips at current copy lengths.
- **Colour wall labels no longer truncate.** They were ellipsing to "Anthracite G..." in the four-column mobile grid. Ten of the twenty-seven colours have no door photograph, so the label is the only thing identifying the paint. It now wraps to two lines with the row height reserved, and desktop is unchanged.
- Verified on test: no horizontal overflow at 390, 768 or 1440; zero console errors; all 23 swatch images load and all four hex fallbacks paint. Blank swatches and blank case-study images seen in stitched full-page captures are a lazy-loading artefact of the capture, not a page fault — check in-viewport before chasing them.
- The style-range wall drift stays desktop-only (`min-width: 861px`), which is deliberate: on a touch device the rail is swipeable and a moving track fights the user's finger. Verified drift still runs at 1440 (60px to 141px in 1.5s).
- **Open item for the owner:** the "Real installs, photographed on the day" strip on this page shows uPVC casement window and aluminium bifold case studies, because no case study is tagged to composite doors and `fenster_case_studies_for_product()` falls back to all studies. Only seven product pages have their own studies, so every other product page makes the same mismatched claim. Left alone here because the fix is site-wide, not a composite-doors change.

## 2026-07-22 - Live release: 5672fb9

Deployed on owner instruction ("push everything to live"). Previous live commit was `1cffd68`.

Range check before deploying, per `LIVECHANGES.md`:

```
5672fb9 Docs: record the STYLE.md rewrite and the H1 rule
496e54f Heritage and roof lanterns: make the hero phone a button
b5396a4 Style: product H1s are the product name, and adopt the five reference pages
1675b9e Docs: record the MK suburb local knowledge and why link shuffling was skipped
8cd9a95 Docs: record that the composite work is already live at 1cffd68
64a2173 MK suburb pages: real local knowledge instead of interchangeable copy
```

Two of the six (`64a2173`, `1675b9e`) were the concurrent session's MK suburb work, not verified by this session. Rather than ship them silently, the choice was put to the owner, who confirmed shipping everything. Recording that here because the previous two releases carried unreviewed commits by accident; this one carried them by decision.

Verified on production after deploy: live `main.css` matches the deployed commit byte for byte; all three product H1s serve the product name; both hero phone numbers are `.button--steel`; the Wolverton suburb copy renders; and the composite doors page passes its regression checks (layer accordion opens one at a time, collection cards all 521px with 337px doors, no clipped copy, no horizontal overflow).

## 2026-07-22 - STYLE.md rewritten around the five reference pages (live, 5672fb9)

Owner: STYLE.md should follow the About, composite doors, sliding sash, heritage aluminium and roof lantern pages, with a nod to tone of voice, plus a new rule that a page title should name the product rather than carry a tagline.

- **New rule, enforced immediately: a product or service page H1 is the name of the thing.** `/heritage-aluminium-doors/` went from `The steel-door look, without the steel.` to `Sheerline heritage aluminium doors`, and `/roof-lanterns/` from `Bring more daylight into your extension.` to `Sheerline S1 roof lanterns`. Composite doors and sliding sash already complied. The persuading moves to the lead paragraph, which was already doing that job on all three. No closing full stop on an H1, which is the one place the tone-of-voice full-stop rule does not apply. `/about/` keeps `Simple, honest glazing.` because it is not a product page.
- **STYLE.md now names the five reference pages up front** and tells the reader to trust the page over the file when they disagree.
- **TONEOFVOICE.md is now a required read from STYLE.md**, with a short summary of the parts that change layout decisions, chiefly that facts rather than adjectives do the persuading, so the design has to leave room for a specific number where a template would put a claim.
- **Recorded the product hero pattern** shared by composite, heritage and roof lanterns, and the open-a-detail pattern from the composite construction section, with the caveat that it does not reopen the no-accordions-outside-FAQs rule for ordinary content.
- **Found the reference pages are not uniformly ahead of STYLE.md, and did not weaken the file to match them.** Heritage and roof lanterns still rendered the hero phone number as a bare text link and used mixed secondary button variants, both of which contradict the owner's own CTA instruction from earlier the same day. There the rule was newer than the pages, so the pages were fixed instead: both hero phones are now `.button--steel`, giving the green-then-dark pair. STYLE.md carries a caution to check their CTA markup rather than copy it.

## 2026-07-22 - Composite doors work reached live without its own deploy

Asked to push the composite doors work live, the range check found there was nothing to push: production was already serving all of it.

- **Live is at `1cffd68`.** Its `main.css` and `main.js` match the committed tree byte for byte (`dd22b30e` and `7618f443`), the layer explorer markup and the trimmed cutaway asset are both present on the live server, and the accordion behaves correctly on the production URL.
- **It got there on the back of the mail fix.** The other session committed `71423ee` (SMTP auth) directly on top of `23f3ea8`, the last composite commit, then released. Everything between was carried along: `git merge-base --is-ancestor 23f3ea8 f4ad6fb` confirms the whole composite redesign sits inside the live release.
- **This is the second time.** `LIVECHANGES.md` records the same thing on 2026-07-18, when four Legend fixes took fourteen unapproved composite commits to production with them. Deploying an explicit SHA does not prevent it: the explicit SHA still carries every ancestor. The rule stops you shipping commits that land *after* the one you verified, not ones already underneath it.
- **What would actually prevent it** is not sharing `main` between two concurrent sessions. Until the work is branched, any live release from either session ships whatever the other has merged. Worth deciding before the next unrelated hotfix.
- No rollback proposed: the composite work was verified on test at each step and the owner asked for it to go live. Recording it so the release history is accurate.

## 2026-07-22 - Composite doors: construction rebuilt as a layer explorer (live, 1cffd68)

Owner: the construction section was massive on mobile and looked poor on desktop too, and wanted it changed rather than compressed.

- **Six stacked headings and paragraphs became a stack that opens one layer at a time.** The wall of text is gone on both breakpoints; only one explanation is visible at a time and the stack can be fully collapsed. Verified the behaviour on test: starts with 01 open, opening another closes the first, re-clicking closes it, never more than one open, `aria-expanded` and `hidden` stay in step.
- **The first layer is open in the markup**, so with JavaScript off it degrades to a plain readable list rather than six headings with no copy.
- **The layers are ordered as a section through the door**, outside in, so the list reads as construction rather than as six loose facts.
- **Desktop no longer has a dead column.** The illustration keeps its own proportion and the layer stack stretches to match it, instead of a 330px image marooned in white beside a six-paragraph column.
- **The cutaway asset was carrying ~43px of flat white either side**, which read as a mis-sized image against the panel tint. Trimmed copy saved as `slab-cutaway-trim-341w.webp`; the original is untouched. No build script produces this asset, so a regenerated one will need trimming again.
- Section height on a 390px phone came down from 1,474px to 1,149px, and the collections section from 1,144px to 996px. No horizontal overflow at 390, 768 or 1440.
- I first tried compressing this section (band crop plus tighter type) and it only reached 1,245px while still reading as a wall. Compression was the wrong instinct; recorded here so it is not retried.

## 2026-07-22 - Composite doors: our own collections, and the £5,000 guarantee promoted (test, 783d8dc)

Owner relayed a decision from the business owner: WindowCAD and the website must present the **same** door collections, and the site should stop using Distinction's Signature/Contemporary split. Also: the hero looked poor and ignored the good assets, and the £5,000 security guarantee needed to be a major USP rather than one small stat.

- **Collections verified from source, not guessed.** Loaded the live WindowCAD retail designer over CDP (`?interface=retail&username=fensterglazing&productCollection=4`, forward one step past Sizes) and read the actual `Door style` groups: **Traditional, Esprit, Rustic Renown, Renown, Infinity, Stable Doors**. This matches the business owner's account; the "Esteem" he half-remembered as a seventh is the *selected door name*, not a group. Side panels are a later configuration option, not a door style, which is why they are now a note rather than a card.
- **Six collection cards replace the two supplier collections.** Each shows a real door render chosen to display that collection's panel, plus the panel rule that defines it: Traditional (panelled, glass cut into the panel), Esprit (one flat woodgrain panel), Rustic Renown (shiplap inside a border), Renown (full shiplap, no border), Infinity (long horizontal grooves), Stable Doors (split across the middle). The section states the genuinely useful thing the business owner explained: **within a collection the panel is fixed and only the glass changes**, and that these are the same six, in the same order, as the quote tool.
- **Every door on the wall was relabelled** from Signature/Contemporary to the Fenster collection, and Rustic Renown plus Stable Door renders were added (31 styles) so all six collections appear. `scripts/build-composite-door-wall.py` carries a comment that collections come from WindowCAD and must be changed there first.
- **The stable doors and side panels section was replaced by a security band** giving the £5,000 guarantee a full dark band: headline figure, and four verifiable supports (Secured by Design slabs with the stable-door exclusion stated, laminated decorative glass, multi-point locking, the ten year CPA-backed guarantee).
- **Hero fixed.** The old hero image was a crop so tight the door was unreadable; it now uses the wide `venture-urban-entrance` composition, which was sitting unused after the mosaic came out. The price card dropped the two logo tiles so the £2,000 figure itself carries the card.
- Verified on test at 1440: collections 832, wall 789, construction 789, security 430, configurator 798, palette 742. No horizontal overflow at 390, 768 or 1440, zero console errors; collections fall to three columns at 1180 and two at 860.
- **Open item for the owner:** the £5,000 guarantee is now a headline claim, but its written terms are not recorded anywhere in this repo and `AUDIT.md` still lists it as a claim to substantiate. The copy deliberately does not describe what it pays out or when, and says the written terms come with the doorset. Confirm the terms before this goes to production.

## 2026-07-22 - Composite doors V2: conversion pass over every element (test, 1d73bc2)

Owner asked for a V2 looking at every element down to the approved-installer strip, written to `TONEOFVOICE.md`, with CTR and lead generation in mind. The page showed the product well but **never answered what a door costs and never linked the live `/composite-door-prices/` guide**, which was the biggest gap.

- **Hero rebuilt for the composite route only.** Primary action is now `Get an instant price` into the quote tool rather than the enquiry form, because the WindowCAD tool is what produces priced leads on this route; `Send an enquiry` becomes the alternative. The hero card is back: the product-journey hero hides `.fg-hero__panel` on every route, so a new `fg-hero--composite` modifier opts composite back in with a two-column desktop hero and the card stacked under the copy on phones. It carries the checked WindowCAD example (£2,000 fitted, 900 x 2100 Distinction Esteem, anthracite outside and white inside), the Google and FENSA marks, a route into the prices guide and a phone link. **Keep this figure and its specification in step with `/composite-door-prices/`.**
- **Approved Distinction installer strip** gained a phone lead route (`Talk it through` plus the number, 44px target on mobile) and now states we hang the door with our own fitters rather than subcontractors, instead of the flatter survey/supply/install line.
- **Price question added as the first FAQ**, answering with the checked example and pointing at the prices guide, so it can win the search snippet. This pushed the U-value answer past the five-item FAQ cap, so composite now allows six like sliding sash does; verified six `Question` entries in the FAQPage schema with both the price and U-value answers present.
- **Quote section** rewritten for the route: `Build your door and watch the price move`, with an aside offering the prices guide to anyone who wants a figure before opening a tool, and the mobile action relabelled `Price my composite door`.
- **Door wall** gained an action row (`Send us a style name` plus `Or price one yourself`), so naming a style is a real route rather than an instruction with nowhere to go.
- Copy pass against `TONEOFVOICE.md` throughout, including a stale collections line that still pointed at the removed supplier mosaic.
- Seven distinct lead routes now verified in the rendered page. All composite sections still inside the viewport budget (collections 632, wall 789, construction 789, types 459, configurator 798, palette 742, FAQ 658). No horizontal overflow at 390 or 1440, zero console errors.
- **Concurrency note:** while this work was in the tree, the other session's commit `a200aba` swept up part of it (the hero, banner and FAQ edits landed inside their reviews commit). Nothing was lost and all strings are on `main`, but per `AI.md` two sessions sharing this repo should expect split attribution; check `git status` before `git add -A`.

## 2026-07-22 - Composite doors: duplicated page gradient fixed, supplier mosaic dropped (test, e04a89f)

- **Test had lost the composite work, but nothing was lost from git.** A concurrent session deployed its `release/aaron-isaacs-bio-copy` branch (`8c5c2b3`) to test, which is built from the live SHA and does not contain the composite sections, so `/composite-doors/` on test reverted to the pre-wall version. All composite commits (`e0be345` through `dc0f240`) remained ancestors of `main` and all 100 style/palette assets were present on `main`. Verified `main` is a clean superset of the deployed release branch (`git diff 8c5c2b3 main` over the theme was +1016/-45, the deletions all trivial), then redeployed `main` to test. Both sessions' work is now on test together; live is untouched at `b0ec36a`.
- **Gradient bug found and fixed.** The page canvas is painted once on `body` with `background-attachment: fixed`. `.generated-page--composite-doors` was repainting `--fg-page-gradient` in *two* separate rule blocks (`main.scss` lines ~30983 and ~31392), and those copies scroll, so a second and third moving gradient sat over the fixed one and produced visible banding between sections. Both declarations are removed with a comment explaining why, per the `STYLE.md` continuous background rule. Confirmed zero `generated-page--composite-doors{background:var(--fg-page-gradient)` matches remain in the compiled CSS. Several other route wrappers (`.fg-heritage-door-page`, `.fg-roof-lantern-page`, `.fg-fensa-page`, `.fg-flat-rooflight-page`, `.fg-consultation-page`) still repaint the gradient the same way and are likely showing the same defect; they were left alone because they belong to other pages and other sessions.
- **Removed the Distinction "Real homes" lifestyle mosaic** (782px) on the owner's "whatever you think is best". The new door wall teaches style, glass and colour using cleaner catalogue renders, and the case-study strip lower down proves real installs with Fenster's own photography, so the supplier stock section was a weaker version of both jobs. Its dead data and template plumbing were removed too; restore from git history if the owner wants it back.
- Page is now 8,981px at 1440 (was 9,763px). Every composite section stays inside the ~830px viewport budget: collections 632, wall 736, construction 789, door types 459, configurator 798, paint range 742. No horizontal overflow at 390 or 1440, zero console errors, all 23 paint swatches and the door wall images confirmed loading in a live browser check.
- QA note for future sessions: a full-page `Page.captureScreenshot` with `captureBeyondViewport: true` renders lazy-loaded images as blank boxes even when they are fine. Confirm image state by scrolling the section into view and reading `naturalWidth`, not from a full-page screenshot.

## 2026-07-21 - Composite doors: door style wall and real paint range (test, 81a932c)

- Owner rejected the interactive per-layer construction diagram ("doesn't work at all"): reverted to the single cutaway image, removed the layer buttons, the switching JS and the five extra per-layer assets. Do not rebuild that interaction.
- Owner's two asks were the colours looking good and using the hundreds of door assets in the Distinction scrape. Both are now built from the scrape and committed as theme assets via `scripts/build-composite-door-wall.py`, so the scrape stays a source, never a runtime dependency.
- **Door style wall** (`.fg-cd3-wall`, 736px): the `sign_*` files in the scrape turned out to be the complete Signature catalogue as full-bleed door faces, plus a few Contemporary codes. 27 curated styles render as a wall of real door faces, each labelled with its style name and collection so a customer can ask for it by name. Desktop drifts on a 90s CSS marquee (list rendered twice, second pass `aria-hidden` and `is-clone`) with an edge mask and pause on hover/focus. At 860px and below, and under reduced motion, the animation is off, the clone is hidden and the viewport becomes a native scroll-snap rail with a partial next-card peek. Verified on mobile: clones hidden, animation `none`, 3,871px scrollable, no body overflow.
- **Paint range** (`.fg-cd3-palette`, 742px): 23 real Distinction colours photographed as brush strokes, with the RAL and BS references printed in the Distinction brochure. This replaces flat generated colour blocks as the answer to "the colours section sucks". Copy states plainly that screens shift a shade and that physical samples come to survey, and notes dual-colour inside/out plus single-sided woodgrain stains.
- Style names come from the Distinction Signature and Contemporary product pages in the scrape; do not invent names for door codes those pages do not list. The blanket "any RAL colour" claim from the brochure is still excluded per `AI.md`.
- Verified on test at 1440x900: every composite section is inside the ~830px viewport budget (collections 632, wall 736, gallery 782, anatomy 789, types 459, configurator 798, palette 742). No horizontal overflow at 390 or 1440, zero console errors, all 23 paint swatches and door images lazy-load correctly.
- Open question for the owner: with the door wall now showing the style range, the `Real homes` lifestyle mosaic (782px) may be doing a similar job. It was left in place because removing an established working section needs owner approval under the `AI.md` visual recovery rule.

## 2026-07-21 - Composite doors: one-viewport sections and colour picker rebuild (test, 140d05b)

- Owner follow-up: every composite section must fit one 1440x900 viewport (no section may take two or more scrolls) and the colours section was rejected. Measured real section heights on test via CDP before and after; the viewport budget below the fixed header is about 830px.
- Before: collections 1195px, gallery 959px, anatomy 1035px, configurator 922px. After: collections 632px, gallery 782px, anatomy 789px, types 459px, configurator 798px with the stage at exactly 480px. FAQ 632px, quote embed 607px and reviews 562px already fitted.
- How: desktop collections became horizontal image-beside-copy cards inside a `min-width: 861px` override (mobile keeps the stacked image-first card), gallery mosaic rows dropped to `clamp(140px, 12vw, 172px)`, the anatomy panel/paddings/type scale were compressed, composite section padding tightened to `clamp(2.5rem, 4vw, 3.5rem)`, and the configurator stage went from 520px to 480px including the 641-860px tablet override.
- Colour panel rebuilt: real colour swatch tiles (46px chips with the colour as the control, green ring + bold label when active, five columns on desktop and three below 640px), a dashed `And more` tile, and a `Selected colour` name/copy block beside the controls. The caption box that covered the photographed door is gone; glass got the same clean-photo treatment with its own selected block. The shared `[data-fg-door-selector]` JS needed no changes because name/copy targets are found anywhere inside the selector container.
- Verified on test: all composite sections ≤830px at 1440x900, no horizontal overflow at 1440/390, zero console errors, and a CDP interaction pass confirmed tab switching plus Chatsworth/Ruby Red selection updates. Two shared sitewide components still exceed the budget on this route: the case-study strip (849px) and the shared enquiry form (949px, which STYLE.md permits to run taller); changing those affects every page using them, so they were left for an owner decision.

## 2026-07-21 - TONEOFVOICE.md and composite doors substance pass (test, 54281d4)

- Wrote `TONEOFVOICE.md`, the customer-facing copy voice reference, by reverse-engineering the owner-approved About page copy: facts over adjectives, say the awkward thing first, real people/places/jobs as proof, full-stop sentence-case headings that state a customer truth, no contractions in the About register, one dry aside per page maximum, and a supplier-copy rewrite process. `AI.md` documentation rules now point at it. All future page copy should be checked against it.
- Owner verdict on `/composite-doors/` was "not good enough, redesign or major improvements" with instruction to use the Distinction scrape content. Audit finding: the live V2 was a configurator with no product substance at all, and none of the scrape's construction/thermal/security material was used. Kept the working structure and added the missing substance rather than tearing it down.
- New `What is inside the slab.` construction section (between the real-homes gallery and the stable-doors panel): a cutaway illustration from the scrape (`anatomy/slab-cutaway-428w.webp`, new theme asset), six numbered layers (GRP skin, water-resistant polymer edges, engineered wood stiles, reinforced central board, foam-filled core, decorative glass), a four-stat strip (44.5mm slab vs 28mm uPVC panel, 50% thermal figure, £5,000 security guarantee, 10 year guarantee) and the Salford Energy House footnote attributing the 50% claim to Distinction's independent testing.
- Accuracy notes baked into the copy: most Distinction decorative glass is triple glazed and laminated as standard but Chatsworth and Wentworth are double glazed; Secured by Design accreditation applies to the slab (stable doors sit outside the scheme, so SBD lives in the security FAQ with the caveat rather than the stat strip); no invented U-value, the FAQ explains why and gives the tested comparison instead.
- Page-wide copy rewritten in the About voice: hero CTA is now `Send an enquiry` (route-gated; other product routes keep the sitewide label, verified on `/casement-windows/`), the installer banner carries the one-in-four proof line, collection cards gained `Best for` guidance panels, the collections/gallery/configurator headings state customer truths, and all five FAQs now carry real construction, security, dual-colour, maintenance and U-value answers.
- QA on the protected test site at 1440x900, 768x1024 and 390x844 via CDP headless Chrome: no horizontal overflow at any width, zero console errors, anatomy panel composed on desktop and cleanly stacked on mobile with a 2x2 stat grid. Local Sites was not running, so all verification was on test. Live is untouched; test is at `54281d4` awaiting owner review.

## 2026-07-21 - Live promotion, AdminBase TLS outage fix, and WindowCAD diagnosis corrected (d2d5aa3)

- Promoted the tracking hardening and mobile cookie/Legend fixes to production at `193dc51` (backup `fenster-pre-193dc51-…`), then verified the mobile fixes on live in WebKit iPhone emulation.
- Corrected the earlier WindowCAD diagnosis after owner pushback and direct testing: the Tracking capture is **invisible and URL-driven** and works with the current WindowCAD configuration. Intercepted (aborted) submissions showed the app storing the `tracking=` URL value under the Tracking property key without any visible form field, and the owner's live test (`FG2-ZACLIVETEST0721`) arrived in WindowCAD, WordPress, the AdminBase notes and the dashboard. Leads without tracking values are office-entered projects or direct/re-opened WindowCAD sessions. No WindowCAD settings change is needed.
- Found and fixed a genuine outage the live tests exposed: AdminBase renewed its certificate onto the Sectigo R46 root, which WordPress' bundled CA file predates, so every relay since at least 2026-07-21 failed with cURL error 60 (Carol Jarvis's real lead was stranded in WordPress). `fenster_adminbase_http_ssl_args()` now points AdminBase requests at the host system trust store; deployed to test then live (`d2d5aa3`), both stranded leads re-relayed with HTTP 200, and the handler now fires the dashboard `quote_completed` before the AdminBase attempt so attribution survives CRM outages.
- Remaining cleanups for the office: delete the WindowCAD projects "CLAUDE TEST DO NOT PROCESS" and "Zac - test, delete", and their AdminBase copies.

## 2026-07-21 - Mobile cookie/Legend tap fixes (test, f2c16ad)

- Investigated the owner's report that people cannot accept cookies on mobile. The accept flow itself passed real-WebKit iPhone and Chromium touch testing against live, and the Fanboy cookie-blocklist has no rule matching `.fg-cookie-consent`. Two genuine defects were found next to it and fixed:
- The `.legend-assistant` fixed wrapper defaulted to `pointer-events: auto`, so its transparent ~280x360px box silently swallowed taps on page content beneath it (its interior sits directly above the cookie banner on phones). The wrapper is now `pointer-events: none` with the launcher, prompt and open chat panel explicitly interactive, restoring the documented rule.
- With the Legend drawer open, the cookie banner (z 12000) floated on top of the full-screen chat (z 1100) and buried the composer on mobile. The banner now hides while `legend-chat-open` is set and returns when chat closes; consent still gates all optional tracking. Banner buttons also gained 48px tap targets at mobile widths.
- Verified on the test site in WebKit iPhone emulation and at 1440 desktop: dead zone gone, composer reachable during chat, banner returns after close, accept stores consent at both widths, no horizontal overflow, no page errors. WindowCAD's owner screenshots confirmed the Tracking field definition survives in the account; the missing piece remains its absence from the retail/door designer form field lists.

## 2026-07-21 - Tracking audit, WindowCAD tracking-number root cause, tracker redesign

- Audited every tracking system end to end: consent banner and gated GTM/Clarity/Meta Pixel, consented `FGV`/`FG2` attribution events, the aggregate statistical path, Legend chat QA relay, WindowCAD URL parameter rewriting (links and deferred iframes verified on live), the `/wp-json/fenster/v1/windowcad` callback, AdminBase relay and the Marketing Dashboard D1 store. All theme-side plumbing was verified working on live.
- Root cause of the missing WindowCAD tracking numbers: between 2026-07-14 evening and 2026-07-16 morning the WindowCAD account's website designer form configuration was edited (the required "Where did you hear of us?" dropdown appeared) and the custom **Tracking** info property was removed from the retail and door designer `projectInfoProperties`. The property still exists on the account but is not on the form, so the `tracking=FG2-…` URL parameter has nothing to fill. This is external WindowCAD configuration; the fix is re-adding Tracking to the website designer form field list in WindowCAD settings.
- Found a second concern: zero WindowCAD callbacks reached WordPress between 2026-07-16 09:56 and 2026-07-21 despite 12-25 quote-tool loads per day (historical completion rate ~2/day). The endpoint probes healthy (422 on empty payload, logged), so either quote completions collapsed (the form now requires more fields) or WindowCAD stopped posting; the office should confirm whether quotes arrived in WindowCAD itself during that window.
- Theme hardening in `inc/adminbase.php` and `inc/website-tracking.php`: tracking extraction now accepts a valid `FG2-` value from any submitted field; a submission with no tracking value logs a clear warning and adds "Website tracking: none" to the AdminBase notes; completions without a consented `FG2` are relayed to the dashboard's aggregate-only statistical path as `quote_completed` (device class `server`) so totals remain measurable and breakage is visible within a day. Removed the dead non-consented branch in `journeyReference()`.
- Marketing Dashboard (separate repo, deployed to Cloudflare Pages at `cf8a34e`): Projects → Tools is now a hub with two large tool cards (Fenster Meta Bot, Website Tracker) replacing the cramped toggle tabs; each tool opens full screen with a back control. The Website Tracker was rebuilt around five views: Overview (KPI cards, 30-day stacked consented/anonymous daily traffic chart with lead-day dots, funnel, consent health meter, decision guidance, recent lead outcomes with office status), Acquisition (channels, quote products, top CTAs), Pages (consented top pages with average engaged time, anonymous top pages, device split), Customers (journey timelines) and Legend chats. The API's `website/state` now returns daily series, top pages, device split, top CTAs, form validation fields and product-collection quote activity, and the Overview shows an amber alert counting WindowCAD completions that arrive without a tracking reference.

## 2026-07-20 - Six-fixes batch promoted to live at de13375

Owner approved with one change: the footer social chips looked poor (the outline-style Instagram SVG was being force-filled into a solid blob, and the dark green tint was muddy on the dark footer). They are now white pill chips echoing the trust-logo tiles, with the Instagram mark stroked and the solid glyphs filled.

Promotion followed the rules: `git log a8f15d8..de13375` range check (only this session's commits), server-side theme backup (`~/fenster-theme-backup-before-de13375-20260720-190148.tar.gz`, 346M), reset to the explicit SHA, `wp cache flush && wp sg purge`. Verified on production: all six routes 200, composite section on the colours hub, case-study strip and link cards on `/casement-windows/`, homepage strip, no old picker page-chunks on `/obscured-glass/`, new socials in the footer. The obscured-glass swipe still deserves a quick real-iPhone check when convenient.

## 2026-07-20 - Six fixes from Nick's list, deployed to test only

Each claim in the supplied task list was verified against the codebase before coding; two were inaccurate (there are eight related-link bands plus the price-guide one, not four, and `$product_routes` on the homepage is a five-entry hub list rather than a URL-to-image map). Test is at `146d78a`.

1. **Composite door colours on the colours hub.** The eight-colour array moved from `generated-page.php` into `colour_options.materials.composite` in `inc/site-data.php` with a 480w image per colour. The hub renderer picked it up with no template change; the composite doors V2 page reads the same source (verified: selector renders all eight and previews correctly). Portrait door slides get a scoped 4:5 crop on a narrower slide so the coverflow row holds. Deep links (`?material=composite&colour=ruby-red`) work through the existing generic handler.
2. **Case studies on product pages.** `fenster_case_studies_for_product()` matches on the `products[]` links studies already carry (verified on `/casement-windows/`: both casement studies, not newest-three), newest-first fallback otherwise, rendered as a strip before the enquiry section on product-journey routes.
3. **Homepage case-studies block** after the proof wall: three newest studies via the same shared card partial (`components/case-study-card.php`), which the archive now uses too.
4. **Related-links image cards.** `fenster_link_card_image()` maps ~20 routes to material-correct curated photos; the shared `components/link-cards.php` renders image cards plus text pills for unmapped links (areas, towns). Converted the four `generated-page.php` bands and the two location-service "Keep exploring" bands; the MK-area link clouds stay text by design. Two fixes found by looking: card labels were white-on-white inside the dark links band, and `repeat(auto-fit, minmax(min, max))` counts tracks by the definite max, which forced two columns; the card is capped instead of the track.
5. **Footer socials** restyled as solid brand-tinted 44px chips with 22px icons; markup untouched.
6. **Obscured-glass mobile picker.** Rebuilt the swipe rail: the old full-width page chunks with `scroll-snap-type: x mandatory` plus negative margins is a known WebKit-fragile construct (snaps straight back, so iPhones could not swipe). Now a flat two-row `grid-auto-flow: column` rail with per-card proximity snapping, `touch-action` and `-webkit-overflow-scrolling` overrides removed, matching the site's other iPhone-working rails. Verified at 390: 21 buttons, 1,618px of scrollable overflow, programmatic scroll works, no body overflow. Not tested on a physical iPhone; needs a real-device check.

## 2026-07-20 - Promoted to live: About redesign, price guide redesign, review links

Owner approved promotion after reviewing test. Live deployed from the server repo cache pinned to `a8f15d8` (never `origin/main`), after a server-side theme backup (`~/fenster-theme-backup-before-a8f15d8-20260720-153724.tar.gz`, 346M) and the `git log af4cfc2..a8f15d8` range check.

The range check surfaced one rider: `68b9e6b` (Nick's 2026-07-20 site review: linked Google/Trustpilot logos site-wide, removed the homepage collection counter, expanded the Commercial and Windows nav). It is owner-originated, was verified on test, and shipped with this promotion; noted here so the audit trail is explicit.

Post-deploy verification on production: `/about/` serves the boxed showroom hero, mission H1 and the one-number pricing line; `/window-door-prices-milton-keynes/` serves the round guide figures (£600, £2,000, £3,500) with zero internal-plan copy; all seven price guide routes return 200. Caches flushed with `wp cache flush` and `wp sg purge`.

Later the same day the About hero was reverted from the full-bleed stage to a boxed 16:10 frame beside the mission copy (owner request), and the guide prices were rounded to the owner's figures. Both are included in `a8f15d8`.

## 2026-07-20 - About hero swap and price guide redesign, deployed to test only

Second owner feedback round. Test is at the About/price-guide redesign commit; live untouched.

- **About:** the cinematic mission hero keeps its layout but the media is now the showroom photograph (owner request), with the tag `Our showroom, Milton Keynes`. The `Same software, same price list, same number.` strip was removed as unnecessary; the fact lives in the pricing copy as `One number for the job, not an online teaser and a different figure at the door.` The award video remains the page's only video.
- **Price guides (all seven, shared template):** full customer-facing redesign, prompted by the pages being accidentally live. The internal plan copy (`These rows are the slots we will fill...`, `How we should show it`, the status card) is gone. Placeholder `To confirm from WindowCAD` rows never render publicly; only examples with a confirmed £ price appear. The main page leads with its three checked examples (£583.61 casement, £1,999.20 composite door, £3,469.43 bifold) as photo-led cards pairing the fitted price with our own install photos (Leighton Buzzard casements, Whitehouse bifolds) and the exact WindowCAD configuration as a captioned inset. The hero gains an at-a-glance checked-prices card; guides with no checked examples get a `Your price in minutes` fallback card instead. Factors render as a ticked two-column checklist, FAQs are rewritten for customers, intros in `fenster_price_guide_pages()` are rewritten customer-facing, and the deferred quote-station iframe block is untouched and verified loading.
- Verified at 1440/975 visually and 390 numerically on both routes: no overflow, no heading-cap violations, photo-first stacking and full-width buttons on mobile, and zero leaks of internal copy on any guide checked.

## 2026-07-20 - About page revision after owner feedback, deployed to test only

Owner feedback on the fifth version: open with the mission rather than selling the quote tool, write better copy, present the traditional consultation route as something we offer rather than mock, note that both routes use the same pricing software so the number is identical, drop "at your kitchen table", improve mobile, and add one wow factor. Test is at `2064ea4`.

- **Hero is now the wow factor:** the mission statement (`Simple, honest glazing.`) sits over the Drayton Parslow install video playing full bleed behind a left-to-right scrim. The video is a background, so it is desktop-only; mobile and reduced-motion users get the poster under a vertical scrim with the copy anchored to the bottom of the stage. Marked with `data-fg-video-bg` in `main.js`.
- **Pricing section reframed as two equal routes:** `Online` and `In person` step rails, both green, with the in-person route ending `You get the price on the spot`, and a strip across the panel reading `Same software, same price list, same number.` No route is disparaged.
- **Copy rewritten page-wide** in a tighter voice; the founders section is `Run by the two people who started it.`
- **Mobile polish:** buttons stack full width below 560px, the mosaic and grids collapse as before, hero stage is `min(78vh, 34rem)`.
- Bug fixed on the way: a `width: 100%` override on the hero content span killed `.container`'s auto-margin gutters and pinned the copy to the viewport edge.
- QA note: background tabs produce no frames, so IntersectionObserver-driven video attach and reveals never fire in a hidden automation tab. That is throttling, not a page bug; the video attaches the moment the tab is visible.

## 2026-07-20 - About page redesign (fifth version), deployed to test only

Full recomposition of `/about/` around the instant-pricing positioning, built after reading `ABOUT-PAGE-HANDOVER.md` and verified in a real browser on the test site. Live is untouched; test is at `6918091`.

**Composition (desktop, cascading media right/left/right/left):** hero with H1 `The price comes first.` beside the Drayton Parslow roof lantern install video; fact strip (2018, 1,000+, in-house fitters, 10 year guarantee); dark steel pricing band with a numbered `Pricing with us` vs `The usual way` comparison rail; five-cell fixed mosaic of case-study photos, each linking to its study; founders section with mid-size B/W portraits of Adam and Nick; Sheerline Installation of the Month (August 2025) section playing the actual Northampton job video; accreditation cards with the honest guarantee-exclusions note; showroom visit section; shared review showcase; six-card route grid (quote, consultation, case studies, team, trust, colours).

**Movement without parallax:** the two case-study videos load deferred via `[data-fg-about-video]` (sources carry `data-src`, attached near viewport; reduced-motion users get poster plus controls, no autoplay), plus gentle fade-up reveals via `[data-fg-about-reveal]`. No multi-image parallax and no ghost numerals, both previously rejected.

**Bugs found by looking at the rendered page:**

- Founder name captions rendered as overlay chips across the portraits: the generic `.fg-about figure > figcaption` chip rule out-specified the founder override. Fixed with a more specific selector.
- Hero video measured 498px wide in a 390px viewport: in-flow videos fed intrinsic size into the grid row and the figure `aspect-ratio` derived width from that height. Videos are now absolutely positioned inside their aspect-ratio boxes.
- A dead rule from a pre-redesign About page (`.fg-about-hero__media, .fg-about-feature__media, ... { min-height: 280px }`) squashed the mobile hero to the wrong ratio. Removed; the other selectors exist in no template.
- Fast scrolling could jump a reveal item past the IntersectionObserver in one frame, leaving it permanently invisible. The observer now uses a huge top rootMargin so anything at or above the viewport counts as intersecting.

**Verification:** all 22 reveal items visible after a fast scroll; every image `complete` with real dimensions; no horizontal overflow at 390 or 1440; H1 51.8px within the 57.6px cap; grids collapse correctly at 390 (single column, 2-col mosaic, copy before the pricing panel). Note for future QA sessions: the claude-in-chrome automation browser cannot stream any mp4 (even the live case-study videos stall at readyState 0 there), so video playback must be judged by the 206/range-request check and a human eyeball; posters cover the fallback.

## 2026-07-20 - Live/doc reconciliation: unapproved production release found

Documentation-only session from the home PC. No code or production change was made.

**What was found.** Server-side checks showed live and test theme directories byte-identical (`main.css` md5 `7d3edfc3613998a94884767aca678e6d`), both at `af4cfc2`. Docs claimed live was `13e7f95` with three features held back on test. All three were in fact on production:

- **Composite Doors V2** — `/composite-doors/` serves the V2 template (`fg-cd3-collections` present in live HTML). `COMPOSITE-DOOR-REDESIGN.md` said protected-test only, pending owner approval.
- **Price guides** — all seven routes return `200` and appear in `page-sitemap.xml`. `LAUNCH-WEEK-REPORT.md` said gated to test pending a go decision.
- **Commercial product renderer** (`26f3b43`) — live on `/curtain-walling/` and `/commercial-windows-and-doors/`. `HANDOVER.md` said awaiting approval since 2026-07-07.

**How each happened.**

1. Price guides: commit `68f38ae` (2026-07-09, `Implement local SEO audit quick wins`) added `fensterglazing.com` and `www.fensterglazing.com` to `fenster_price_guides_enabled()`. The un-gating was bundled into an unrelated SEO commit and named in neither its message nor the docs. `68f38ae` is an ancestor of `13e7f95`, so the price guides went live as a silent passenger on the approved 2026-07-17 case-studies promotion.
2. Composite Doors V2: the route has no host gate at all — `generated-page.php:2911` renders it on `$is_composite_doors` alone. It went live the moment the theme moved past `13e7f95`.
3. Root cause for the composite release: the live deploy one-liner in `LIVECHANGES.md` ran `git reset --hard origin/main`, deploying whatever sat on `main` rather than the verified commit. Deploying the four small Legend iframe fixes (2026-07-17/18) therefore also shipped the fourteen composite commits queued in front of them.

**Owner decision (2026-07-20).** Leave Composite Doors V2 and the price guides live and continue work directly on production. No rollback, no re-gating.

**Documentation changes made.**

- `LIVECHANGES.md`: live deploy command now resets to an explicit SHA with a `git log --oneline <LIVE_SHA>..<SHA>` pre-check and an explanation of the incident; `wp sg purge` added to the live one-liner; live commit pointer corrected to `af4cfc2`; before-deploy checklist gained the commit-range check.
- `HANDOVER.md`: live-state pointer corrected, deploy trap documented, and composite/price-guide/commercial-renderer status corrected to live.
- `COMPOSITE-DOOR-REDESIGN.md`, `LAUNCH-WEEK-REPORT.md`: status corrected to live. The composite doc's claim that V2 suppresses the inspiration gallery and comparison table was stale — `0610753` and `46a961f` rebuilt both, and that is what production serves.
- `LIVECHAT.md`: Legend recorded as complete and live with nothing outstanding; the pre-release checklist reframed for future changes only.
- `AI.md`, `AUDIT.md`, `COPY-AUDIT.md`: the footer "Phone lines open 24/7" claim closed permanently as owner-confirmed accurate.

## 2026-07-17 - Case studies expansion live release (13e7f95)

- Promoted commit `13e7f95` to production (backup `fenster-pre-13e7f95-20260717-132541.tar.gz` taken first). Live is confirmed at `13e7f95`; the other agent's concurrent composite-doors commit (`68cfc9d`) is NOT on live.
- This release adds to the live case studies: install dates with automatic date-sorting, fitter panels that link to Meet the Team, a customer review, colour-hub deep links, an in-page lightbox, and two video-led roof lantern studies (landscape video = full-width hero plus a still; portrait video = square hero). The Northampton lantern + heritage doors study carries the customer's real interior photos and a Sheerline "Installation of the Month" award banner.
- Videos were encoded with a bundled ffmpeg (`pip install imageio-ffmpeg`) to ~6.8MB each; they autoplay muted, loop, and only play while in view.
- Cache note now documented: `wp cache flush` does not clear SiteGround's dynamic cache, so `wp sg purge` is part of the deploy flow, otherwise updates look missing behind the proxy cache. Verified live at all breakpoints: archive shows six studies newest-first, videos and the interior photo return `200`, both new studies are in `page-sitemap.xml`.

## 2026-07-17 - Composite Doors V2 studio redesign (test)

- Rebuilt the rejected first composite-door design as one coherent route on the continuous page gradient. The route now has an approved Distinction installer banner, one sold-range studio and one tabbed finish configurator rather than stacked collection cards, a comparison table, an inspiration gallery and three separate option sections.
- Corrected the range to what Fenster sells: Signature and Contemporary, with Rustic Renown presented accurately as a cottage-style Signature design. Removed `nxt-gen`, Grandeur and the blanket `Any RAL colour` claim from composite-door data and page copy.
- The range studio shows one large portrait-led door image and changes the description, best-use guidance and compact specifications when Signature, Contemporary or Rustic Renown is selected.
- Colour, glass and hardware now share one component. Colour has eight photographed examples plus `And more`; glass has compact selectors and visible Chatsworth and Wentworth assets; hardware has eight finishes and one fixed dark presentation stage. Only the selected image and supporting text are shown.
- Retained the 75 responsive WebP assets built from the visually reviewed Distinction scrape, switched the hero to an approved Signature entrance and kept every interactive preview at a fixed size so image changes cannot collapse the layout.
- Built the compiled CSS and JavaScript, linted the changed PHP and deployed theme revision `7aae3b0` to the protected test site only. QA passed at 390 × 844, 768 × 1024 and 1440 × 900 with no broken images or horizontal overflow. The configurator measures 842.9px, 804.5px and 814.6px at those viewports respectively. Rustic Renown, Chatsworth and Chrome interaction tests all updated the correct single preview. Production was not deployed.

## 2026-07-17 - Residential case studies live release

- Promoted the verified case studies work to production. Backed up the live theme first (`~/backups/fenster-theme/fenster-pre-9fba379-20260717-105524.tar.gz`, 320M), then theme-only rsync of commit `9fba379` to live and flushed WP + SiteGround dynamic cache.
- Live verification: `/case-studies/` archive and all four detail pages return `200`; the retired residential studies (`water-stratford`, `double-glazing-rushden`) return `410`; homepage, `/online-quote/`, `/casement-windows/`, a location page, `/commercial-projects/` and `/sitemap.xml` all `200`. Meet the Team carries the new fitter anchors and the colour hub has `data-colour-slug`.
- The plain `page-sitemap.xml` was served from the SiteGround proxy cache (`x-proxy-cache-info: DT:1`) without the new routes; a cache-busted fetch and then `wp sg purge` confirmed and served the fresh sitemap with all four new studies. Note for future sitemap changes: purge or cache-bust when verifying.
- Browser check of the live archive: four cards with dates, trimmed one-line intro, no horizontal overflow, no broken images.
- Updated docs to reflect that residential case studies are now live: `LIVECHANGES.md`, `HANDOVER.md`, `AUDIT.md`, the root `AI.md`/`HANDOVER.md` live-commit pointers, and `CASESTUDIES.md`.

## 2026-07-17 - Case studies: dates, fitters, deep links, lightbox, guide (test)

- Fixed the Broughton study: it was a single dormer window, not multiple. Title, copy and specs are now singular and the hero is the close-up of that one window.
- Every gallery and hero photo opens full screen in the existing in-page lightbox (no new tab).
- Colour links now deep-link the colour hub: they pre-select the swatch (`data-colour-slug`) and scroll to the right material. The scroll pauses Lenis on window load because the colour hero images otherwise keep the page pinned at the top.
- Added install dates (shown on the detail hero and archive cards) and a fitters/Installers panel per job, with links that scroll to each person's Meet the Team profile. Gave every team member an anchor id (`sanitize_title(name)`). People without a profile (Aaron) render as a name-only chip. Never lists marketing Zac Bartley; the fitter is Zac Rugman.
- Widened the archive intro to full width and reworded it around 1,000+ installations, explaining the page will grow over time.
- Scanned the retired residential studies: the Water Stratford cottage and Rushden bungalow have good written stories but no photos, so they cannot be republished in the image-led format without photography.
- Added `CASESTUDIES.md`: a complete guide to adding and maintaining case studies (photo prep, data schema, copy rules, product/colour deep links, fitters, reviews, routing, deploy checklist) so future work is one-pass.

## 2026-07-17 - Case study detail: hero image, spec strip, masonry gallery, installers + review (test)

- Owner feedback on the text-led version: hero was too text-heavy with no image, the specification sat too low, and the gallery cropped photos with small captions.
- Detail hero is now a two-column layout with a lead image, and the key specification is a scannable four-item strip directly under the hero (was a low sidebar).
- Gallery rebuilt as an uncropped masonry: every photo shows whole at its natural aspect ratio, and the portrait/landscape mix becomes the layout, in the spirit of the roof lanterns page. No `object-fit` crop on gallery images.
- Added per-project people: an Installers panel (Tom Carter and Johnnie Greenwell) with their Meet the Team photos linking to `/meet-the-team/`, and a customer review (Conor and Laura) with the installers' names hyperlinked. Attached to the Whitehouse aluminium bifold project because the review is about the doors and kitchen. Both are optional data fields, so other studies render without them.
- Verified on test at 1440x900 and 390x844: section order hero, spec strip, body, gallery, more, CTA; no horizontal overflow; masonry shows whole photos; review and installer links resolve; studies without review/installers render cleanly; no console errors.

## 2026-07-17 - Residential case studies redesigned, clean text-led (test)

- Owner rejected the first version for looking too much like the commercial project pages. Rebuilt the detail and archive templates from scratch in their own `fg-cs-*` namespace, copying nothing from the commercial `fg-case-*` styling.
- New detail layout is descriptive and text-led with no hero imagery: a short lead, a written overview, a sticky specification panel (product, system, colour, U-value/rating) with product/colour/instant-quote links, a "what we fitted" list, and a captioned image gallery where every photo is described (expanded from the owner's filename notes). Sits on the continuous page gradient with clean white panels.
- Expanded the bare project notes into accurate copy by scanning the real product pages: casement `/casement-windows/` (Liniar EnergyPlus 70mm, 0.95 W/m²K, A+, PAS 24), flush `/flush-casement-windows/` (Liniar 70mm flush sash, 1.2 W/m²K, A+), aluminium bifolds `/aluminium-bifold-doors/` (Sheerline Prestige, 1.0 W/m²K, up to 7 panes) and slide/fold `/slide-fold-doors/` (10-point locking, independent panels).
- Archive is a clean two-up card grid. Verified on test at 1440x900 and 390x844: no horizontal overflow, H1 within the ceiling, correct product/colour/quote links, captioned gallery, no broken images, no console errors, grids stack on mobile.

## 2026-07-17 - Residential case studies rebuilt (test, superseded same day)

- Rebuilt `/case-studies/` as a curated, expandable system driven by a new `inc/case-studies-data.php` (`fenster_case_studies()`). Adding an entry there publishes a new archive card and detail page, wires its own routing, SEO, images, product/colour links and related-project cards. Designed to scale to 100+ studies from one data file.
- Added the first four real projects with owner-supplied photography (optimised into `assets/images/case-studies/`): anthracite grey Sheerline aluminium bifolds (Whitehouse, MK), two-tone basalt grey Liniar casements over a boarded-up opening (Broughton, MK), flush casements plus a uPVC slide and fold door (Leighton Buzzard) and white Liniar casements (Leighton Buzzard).
- Each detail page links the products used (e.g. `/aluminium-bifold-doors/`, `/casement-windows/`, `/flush-casement-windows/`, `/slide-fold-doors/`) and the colour (`/colour-options/`), states that the customer priced with the `/online-quote/` instant quote tool, and ends with product plus quote CTAs. Copy is direct we/you voice with no em dashes, per `STYLE.md`, reusing the existing `fg-case-*` styling with residential chip/quote additions.
- Routing: removed the `/case-studies/` 410 and added synthetic archive/detail pages in `fenster_get_generated_page()`; kept `/commercial-projects/` and the commercial detail pages on their existing `pages.json` source by reading the raw index directly. The two retired residential studies (`double-glazing-rushden`, `water-stratford`) stay 410 and no longer appear anywhere.
- Sitewide CTAs: added a footer `Case Studies` link and a homepage proof-wall link.
- Deployed the exact commit to the protected test site only (not live). Server checks: `/case-studies/`, all four detail routes and `/commercial-projects/` return `200`; retired residential routes still `410`; new routes present in `page-sitemap.xml`. Browser DOM QA at 1440x900 and 390x844 confirmed no horizontal overflow, H1 within the `3.6rem` ceiling, correct product/colour/quote links, all images loading and grids stacking on mobile. (Full-page screenshots timed out in the test browser; verification was DOM/text based.)

## 2026-07-16 - Legend follow-up production reconciliation

- Audited the current repository against both SiteGround themes after the owner noticed the header redesign was already live. The live checksum dry run showed all current theme work was already present except `inc/legend-assistant.php`; test matched the repository fully.
- Identified the only unlive code as the reliable hyperlink safeguards from `f01b925` and `d9b9ffc`. Created rollback archive `/home/u453-m73mh4m4wev2/backups/fenster-theme/fenster-before-legend-links-20260716-160023.tar.gz`, deployed the verified source at `cd5b430` and flushed production cache.
- Post-release checksum comparison was empty. Homepage, Meet the Team, windows hub and quote tool returned `200`. Live endpoint checks confirmed `who is zac` returns the verified Marketing Executive answer and the premium-window question links `[aluminium windows](/aluminium-windows/)`.

## 2026-07-16 - Reliable Legend recommendation links

- Fixed product recommendations appearing as bold text without a hyperlink. Link support had not been removed, but model-selected formatting was optional and therefore inconsistent.
- Added server-side link normalisation that converts full test/live Fenster URLs into portable relative routes and automatically links a known product when the model supplies no useful route.
- Prioritised the first bold known product as the single recommendation link, removing a later less-relevant model-selected route when necessary. Endpoint regression for the owner's premium-window question returned `[aluminium windows](/aluminium-windows/)`.

## 2026-07-16 - Website Tracker operating guide

- Added the Marketing Dashboard repository's `WEBSITE-TRACKER.md` as the single operating guide for the consented Website Tracker. It explains FGV/FG2 and WindowCAD Tracking joins, consent and retention, every metric/funnel stage, visitor timelines, Legend QA transcripts, UTM attribution, limits of phone-click data and a troubleshooting checklist.
- Linked the guide from the dashboard README and the theme handover/deployment rules so future work does not treat the dashboard as a CRM or mistake intent metrics for confirmed business outcomes.

## 2026-07-16 - Sliding sash redesign live release

- Completed the final release audit for the rebuilt `/sliding-sash-windows/` journey and promoted the exact protected-test theme commit `8533d4e` to production after owner approval.
- Release checks passed: clean repository and GitHub parity, full CSS/JS build, all 53 theme PHP files linted, test/repository CSS and generated-template checksums matched, and 390 × 844, 768 × 1024 and 1440 × 900 browser QA showed no horizontal overflow.
- Reverified the mobile model carousel, three-product desktop layout, six-image gallery, corrected Roseview specifications, privacy-glass-only choice panel, fixed-height furniture selector, all eagerly loaded furniture finishes, sash-specific review ordering, responsive quote behaviour, footer trust grid and Instagram/Facebook/LinkedIn links.
- Created the fresh rollback archive `/home/u453-m73mh4m4wev2/backups/fenster-theme/fenster-pre-8533d4e-20260716-141859.tar.gz` before the theme-only production rsync.
- Production cache was flushed and live theme CSS/template checksums matched the reviewed repository. The homepage, sash page, online quote, consultation, contact and about routes all returned `200`; critical sash images and compiled assets also returned `200`.
- Post-release browser checks passed on live at all three breakpoints. The sash controls worked, all furniture images were loaded before interaction, the hardware stage stayed fixed, responsive hero sources were selected correctly, and homepage/online-quote smoke tests produced no browser errors.

## 2026-07-16 - Legend drawer header redesign

- Removed the abrupt dark-to-pale header split and replaced it with a continuous deep-teal gradient, soft mint floor glow and restrained lower stage line.
- Restyled the close control for the unified dark surface and retained clear identity copy contrast.
- Preserved dedicated animation geometry: a `224px` desktop stage and `190px` mobile stage accommodate Legend's standing, left/right movement and curled sleeping frames. Protected-site visual QA confirmed desktop standing contrast, mobile sleep containment and zero horizontal overflow.

## 2026-07-16 - Reliable current-page team answers

- Fixed Legend failing to identify Zac Bartley while the visitor was already on Meet the Team. The profile existed in rendered HTML but was buried in the general page snapshot, while the related-page source index did not contain the runtime replacement accurately.
- Promoted every visible team profile into high-priority assistant context and added a backend query-matched excerpt around meaningful words from each question. The prompt now explicitly requires a direct answer when a named staff profile is supplied.
- Protected-site regression confirmed `who is zac bartley` returns Marketing Executive and the published remit, while `what does Zac do at Fenster?` returns the same role details directly.
- A subsequent real-chat failure showed the model could still ignore the supplied profile. Added a deterministic pre-model answer for common Zac identity and role wording, including the exact short message `who is zac`. This was later promoted and verified on production in the reconciliation release above.

## 2026-07-16 - Legend chat continuity and scrolling polish

- Hid the full `By using this live chat` disclosure after the visitor's first sent message while retaining the compact accuracy, non-binding, QA-retention, sensitive-data and Privacy Policy notice.
- Persisted the drawer's open or closed state so same-site hyperlinks keep an active chat open on the destination page. Restored chats skip the entrance animation and do not steal keyboard focus.
- Excluded the drawer from Lenis page smoothing and added contained native wheel/touch transcript scrolling, stable scrollbar space and touch momentum. Wheel and touch reading also reset Legend's inactivity timer.
- Made every normal open and restored open scroll to the newest message after layout. A protected-site mobile test used an overflowing transcript and confirmed chat-only wheel movement, a stationary background page, open-state navigation, hidden disclosure and reopen-to-bottom behaviour.

## 2026-07-16 - Friendlier Legend personality

- Expanded Legend's permitted conversation to include greetings, thanks, goodbyes, meows, purrs, harmless cat jokes and questions about Legend without forcing each reply back to windows, doors or a sales action.
- Made the assistant warmer, cuter and more naturally in character while retaining concise British English, factual accuracy and the boundary against substantive unrelated tasks.
- Added the owner-confirmed relationship that Legend's dad is Nick Baker, Fenster's Sales Director, to both the assistant instructions and authoritative business context. Legend is told not to invent any other biographical details.

## 2026-07-16 - Legend close delay, iOS prompt and footer cookie control

- Changed drawer-close behaviour so Legend returns to idle and waits 10 seconds before curling up; the normal inactivity timeout remains 20 seconds.
- Hardened the scroll-triggered speech bubble for iOS by checking all relevant scroll roots and listening to document, touch and visual-viewport movement. The prompt can now appear while Legend is asleep.
- Removed the persistent viewport Cookie settings button and kept the reopening control in the footer. Limited pointer events to the visible Legend launcher and speech bubble so the transparent positioning wrapper cannot cover cookie or footer controls.
- Built and PHP-linted the theme, isolated the release from unrelated sliding-sash work and deployed it to the protected test site for responsive verification. This was later promoted and verified on production in the reconciliation release above.

## 2026-07-16 - Legend Sleep And Scroll Prompt Live

- Used the approved hatch-pet Legend identity and contact sheet to generate a coherent eight-frame standing-to-curled sleeping animation. The first generation was rejected because two tails touched and produced clipped extraction fragments; the complete row was regenerated with separated poses, then passed deterministic frame inspection and visual contact-sheet review.
- Added the transparent `legend-sleep-strip.webp` as a website-only animation asset. It is deliberately separate from the validated Codex v2 atlas and alternates its final two frames as a quiet breathing loop.
- Added a 20-second Legend-specific inactivity timer in both launcher and open-chat states. Pointer, focus and typing activity wakes him; clicking him reverses the sleep sequence before reopening chat. Clicking the drawer X returns him to the launcher and immediately curls him up.
- Rebuilt the launcher prompt as valid sibling controls instead of nesting an independent X over the old launcher button. The bubble starts invisible, appears after 240px of scroll, opens chat from its copy area and contains its own session-dismiss close button.
- Built, PHP-linted, committed and deployed the work to the protected test site. Desktop QA verified the complete `0` through `7` close-triggered progression, the 20-second trigger at 20.5 seconds, breathing state, wake-to-open path, integrated close geometry and scroll reveal. A true `390 x 844` pass verified the prompt layout and no horizontal overflow. No new console errors were introduced.
- After explicit owner approval, backed up the live theme and promoted commit `400cf10` to production using theme-only rsync. Live checks returned 200 for the homepage, quote tool, casement product, Bletchley location page and About page; every page rendered Legend and the sleep asset. The production AI connection was configured, the scroll prompt rendered correctly and browser QA found no console errors.

## 2026-07-16 - Sliding Sash Desktop Journey Aligned With Mobile

- Carried the approved concise, image-led mobile journey onto desktop without stretching the phone carousel across a wide screen. Desktop retains the useful side-by-side view of all three Roseview models and the full shared comparison table.
- Rebuilt the desktop model cards around much larger, fully contained product renders. Removed the repeated paragraph and per-card specification grids; each card now carries only its model position, name and concise `Best for` guidance, while the table states each technical difference once.
- Promoted the six-image `Real homes` gallery to desktop as an editorial collage: one dominant wisteria installation, two supporting room/elevation images and three compact detail views. Desktop gets dedicated explanatory copy, hover treatment and the existing accessible lightbox; mobile retains its swipe rail and mobile-specific instruction.
- Applied the same content consolidation at desktop widths by removing the repeated sash detail run, generic product-information blocks, order-process repetition and related-link filler. The remaining journey moves from hero/specification summary to model choice, real installations, finish choices, furniture, FAQs and enquiry.
- The rendered desktop page at `1440 x 900` reduced from roughly `11,591px` to `7,278px`; the three-card comparison is about `604px` and the desktop gallery about `910px`. Mobile remains about `7,648px` at `390 x 844` and tablet about `7,251px` at `768 x 1024`.
- Rebuilt compiled CSS, PHP-linted the generated template, pushed through commit `d851e0f`, deployed that exact theme commit to the password-protected test site and flushed its cache. Browser QA passed at `390 x 844`, `768 x 1024`, `1024 x 768` and `1440 x 900`: no horizontal overflow, correct breakpoint-specific gallery copy, desktop/mobile gallery layouts intact, lightbox opens and closes, and no console errors. Nothing was deployed live.

## 2026-07-16 - Sliding Sash Mobile Installation Gallery

- Visually reviewed all `1,064` raster files in the supplied Roseview scrape using labelled contact sheets, then opened the strongest candidates at full resolution. Rejected duplicates, logos, staff/trade graphics, technical diagrams, unfinished-site photography and images that did not clearly support the sash product.
- Added six approved, locally hosted Roseview images: a wisteria-framed sash, finished dining and bay-room interiors, a full Surrey elevation, an arched exterior sash and arched interior detailing. Converted the chosen sources to responsive WebP assets so the production theme has no runtime dependency on the external scrape.
- Added a mobile-only `Real homes` gallery immediately after the Roseview model selector. It is a compact dark swipe rail with a clean next-card peek, concise captions and the existing tap-to-enlarge lightbox; desktop remains unchanged.
- Enlarged the Ultimate, Heritage and Charisma model media areas while retaining the one-card mobile decision flow. The final product artwork uses a fixed responsive object-fit box so the full portrait window is visible instead of being cropped.
- Rebuilt compiled CSS, PHP-linted `generated-page.php`, checked the diff, pushed commits through `880a3f8`, deployed that exact theme commit to the password-protected test site and flushed its cache. The new gallery asset and route both return `200` on test.
- Browser QA passed at `390 x 844`, `768 x 1024` and `1440 x 900`: the phone carousel is about `759px` tall, the six-image gallery is about `472px`, carousel controls update both the name/count and selected specifications, the lightbox opens/closes, mobile/tablet have no horizontal overflow, desktop keeps its three-card comparison/full detail run, and no console errors were recorded. The phone page is about `7,639px` tall after adding the image-led gallery. Nothing was deployed live.

## 2026-07-16 - Sliding Sash Mobile Comparison Redesign

- Preserved the approved desktop Sliding Sash Windows page while rebuilding the Roseview comparison specifically for `860px` and below.
- Replaced the three long stacked Ultimate, Heritage and Charisma cards with a one-card swipe carousel using previous/next controls, a visible model name/count and position indicators.
- Removed the repetitive mobile comparison-table stack. Mobile now shows one compact specification panel for the selected carousel model, updating meeting rail, corner detail, frame depth, glass unit, energy rating and ThermoVFlex information as the customer changes model.
- Kept the full three-card layout and four-column specification table unchanged on desktop.
- Rebuilt the compiled CSS and JavaScript, PHP-linted the generated product template and checked the diff for whitespace errors.
- Committed and pushed the change as `4ff4eb8`, deployed that exact commit to the password-protected test site and flushed its cache. Browser QA at `390 x 844`, `768 x 1024` and `1440 x 900` confirmed working model controls and selected-spec updates, no horizontal overflow, no console errors and no desktop layout regression.
- Reassessed the full phone journey after the first carousel pass remained too long. The rendered mobile page was roughly `18,600px` high because the model decision was repeated through the detail run, generic Product information, More information checks, furniture catalogue, order process and related-link band.
- The whole-page mobile pass removes those repeated detail/product/process/link sections below `860px`, compresses the selector to one viewport-sized decision component, and turns colour/glass and furniture into short horizontal rails. The complete desktop page remains unchanged.
- Final test measurements: about `7,200px` total at `390 x 844` and `6,800px` at `768 x 1024`; the phone carousel itself is about `693px` including its active card, controls, dots and selected-model specification grid. No horizontal overflow or console errors were found, and the desktop comparison cards, table and supporting sections still render normally.

## 2026-07-16 - Week Two: Shared Copy Rewrite And Full Image Audit

- Rewrote the shared customer-facing template copy in `generated-page.php`, `quote-tool.php`, `windows-hub.php`, `home-experience.php`, `about.php`, `contact.php`, `price-guide.php`, `consultation-booking.php` and `enquiry-form.php` from third-person "Fenster does X" into direct we/you voice, reading each string in context rather than find-and-replace. Brand-named copy was deliberately kept where it earns its place: `/why-trust-fenster/`, About-page process labels, the accreditation trust strip, commercial county intros and "the Fenster quote tool".
- Removed the self-describing product gallery bullets ("Every image is chosen to show this product family clearly") and replaced them with an action prompt; replaced the "Move from the product into the details that make it yours" and "Choose the handle finish with the door, not after it" headings with customer-truth headings; fixed the clunky "{Product} styles, details and installed examples" grammar with a colon form.
- Completed the full image audit: all 98 unique images referenced by `product_media` and `product_gallery_pools` in `inc\site-data.php` were opened and classified. Removals: duplicate sash photo (`Sliding-Sash-Windows-Flitwick-9` = curated hero), two US stock interiors from the aluminium windows pool, three same-scene CGI courtyard renders and a duplicate CGI kitchen across the door/bifold pools, the wrong-product `steel-look-patio-hero` render from the sliding pool, a garden photo posing as a casement window, and a French casement window from the French doors pool.
- Promotions and moves: real installs replaced CGI as the bifold hero (`sheerline-bifold-exterior`) and casement hero (`Casement-Windows-Flitwick-10`); the Liniar `7016_grey_patio` photo moved to the uPVC patio pool; two previously unused genuine bifold assets (`Aluminium-Bifold-Doors-Flitwick-6`, `Bifold-Espag-Handle-v1`) were added so the bifold gallery keeps its four-image minimum.
- Rewrote every dishonest alt text: no image claims a material, product or town it does not show (previous alts claimed renders were "installed in Northampton/Letchworth/Milton Keynes" and called the double-glazed unit sample "secondary glazing").
- Added `PHOTO-CHECKLIST.md`: a five-shot per-job photo routine for fitters plus the wishlist of gaps that only real job photography can fill (uPVC door installs, aluminium windows on a local home, secondary glazing, town-spread sash installs).

## 2026-07-16 - Content/Imagery Audit And Week One Quick Fixes

- Completed a full content, imagery, design and SEO audit of the live site (12 pages crawled at desktop and mobile widths with rendered-text extraction and layout metrics) and recorded the prioritised plan in `ACTION-PLAN.md`.
- Made the Products mega-menu CTA badges data-driven through a new `badge` field on the nav CTAs in `inc\site-data.php`, rendered in `inc\template-tags.php` and styled as `.site-nav__mega-cta-badge`. The previously swapped CSS `content` labels are gone: `Get an instant quote` now reads `Quick start` and `Book a consultation` reads `Explore`.
- Fixed the shared product template's hardcoded "three quick guides" claim (door pages only render two specification-choice cards) and stopped `strtolower($title)` breaking product casing in gallery copy ("upvc doors" now renders as "uPVC Doors").
- Curated the `upvc_doors` image pool and `product_media` gallery: removed the cat-flap photo, a CGI render, a painted timber cottage door, a timber colour collage and a duplicated hero image; added two genuine Liniar uPVC door renders from the reserved `assets\images\products\colours\liniar-door` set; rewrote every alt text so no image claims a material it does not show.
- Resolved the sliding sash energy-rating contradiction: the USP strip said `A+ rated` while the on-page comparison table said `A rated`; both now state `A rated`, matching Roseview's published standard rating, and the matching benefit card copy was updated.
- Rewrote the four sash furniture descriptions that exposed supplier-research phrasing ("described by Roseview as", "Roseview lists", "Roseview states", "The Roseview options page also lists") into direct customer-facing statements with the same facts.
- Normalised review card dates at component level in `template-parts\components\review-showcase.php` (`strtotime` + `date_i18n('j M Y')`), so ISO Google dates and human Trustpilot dates render in one format.
- Added `upvc-doors` and `casement-windows` to `fenster_gsc_seo_overrides()` with rewritten titles and meta descriptions, replacing the imported scrape-era metadata ("View our uPVC doors...", "Learn about our casement windows...").
- Retracted one audit finding: the Legend launcher does not overlap hero content; it is fixed to the bottom-right corner and the apparent overlap was a full-page screenshot artifact.
- Rebuilt CSS/JS and PHP-linted all changed files. The footer "Phone lines open 24/7" claim still needs an owner decision before it is changed.

## 2026-07-15 - Legend Chat Quality Assurance Tracking To Test

- Extended the consented Website Tracker with Legend chat opened, acknowledgement, message-sent and reply-received events.
- Added a restricted transcript store in the separate Marketing Dashboard, linked to the existing anonymous `FGV-...` visitor and `FG2-...` journey only where optional cookies were accepted. The tracker has a Legend chats view and visitor journeys link to their saved conversations.
- Set transcript retention to 30 days. Legend still works after rejected optional cookies; its QA transcript is chat-only in that case, with no chat tracking event or `FGV`/`FG2` journey link.
- Updated the pre-chat acknowledgement, persistent chat notice, generated Privacy Policy and `LIVECHAT.md` so visitors are told before chatting that accepted-consent transcripts may be retained for quality assurance for up to 30 days. This remains test-only until Legend itself receives explicit live approval.
- Legend replies now support one safe, same-site route link in `[label](/route/)` form, alongside bold text, so a useful next step such as `/book-a-consultation/` is directly tappable. The browser creates the link only after validating it remains on Fenster; no raw HTML or external links are rendered.

## 2026-07-15 - Legend AI Chat Preview On Test

- Added Legend, Fenster's black office cat mascot, as a site-wide floating AI assistant above the cookie controls. The launcher uses the approved animated Legend sprite and responds with a wave when opened.
- Reworked the closed launcher after owner review: Legend now appears larger and on his own without a pill, portrait circle or other enclosing box. A compact speech bubble pops out beside him with `Need a hand?` and clearly identifies him as Fenster's AI assistant, then withdraws when the chat opens.
- Replaced the duplicate launcher/header characters with a single-character handoff. On open, the clicked Legend uses the verified row-4 five-frame jumping animation at slower timing and follows a curved path into the header stage; only after he lands does the header roaming state appear. Closing reverses the handoff back to the launcher, with an instant accessible fallback for reduced-motion visitors.
- Removed the remaining header wave-on-arrival and hidden thinking/wave code paths after owner review caught two stray raised-paw frames. The assistant now references only atlas rows 0, 1, 2 and 4: idle, running right, running left and jumping.
- Reworked the chat header after owner review into a full-width animated character stage. Legend now moves between both sides with deliberate pauses, the idle sprite cycle runs at a calmer pace, and the chat panel is taller on desktop and mobile.
- Corrected the stage after rendered review showed the idle animation sliding across a dark background. Legend is now about 45% larger on a pale green contrast area, uses the running sprite row only while crossing, and returns to the slower idle row whenever he stops.
- Corrected the travel-row mapping after the first motion fix used row 7, which is the Codex processing/thinking state rather than directional locomotion. The header now uses all eight frames from row 1 while moving right and row 2 while moving left, with row 0 between crossings. Timed browser verification confirmed positive movement on row 1, negative movement on row 2 and no console errors.
- Identified Legend in the welcome copy as Fenster's real office cat and Chief Meow Officer. Added a `Who is Legend?` button that links directly to his newly anchored card on `/meet-the-team/#legend`.
- Built a responsive, keyboard-accessible chat panel with a live message log, safe text-only message rendering, auto-growing composer, Enter-to-send, Shift+Enter for a new line, Escape-to-close, typing feedback and reduced-motion support.
- Replaced the browser-only placeholder with a secure WordPress REST integration at `/wp-json/fenster/v1/legend/chat`, backed by OpenAI's Responses API. The API key remains server-side in Bedrock `.env`; it is never rendered into the page or committed to the theme.
- Added Fenster-specific assistant instructions covering Legend's identity, British-English tone, concise answers, current capabilities, honest uncertainty, privacy, safety boundaries and clear AI disclosure. Page content is explicitly treated as reference material rather than executable instructions.
- Tightened live reply behaviour after real conversation testing showed long, sales-heavy paragraphs and em dashes. Ordinary answers now default to one short paragraph, one or two sentences and roughly 45 words; lists are limited to three bullets when genuinely useful, the output budget is lower, and em dashes are also removed server-side as a final safeguard.
- Added safe inline bold rendering for Legend replies. Only `**bold**` is recognised, using DOM-created `strong` and text nodes, so the assistant can create scan-friendly emphasis without enabling model-supplied HTML, links or scripts.
- Added bounded cross-page retrieval for factual questions. The server searches other published Fenster theme and WordPress pages, excludes the current route, ranks matches with title/description/content weighting and common warranty spelling normalisation, then supplies up to four short excerpts as untrusted reference material. Legend can now consult relevant Fenster pages before falling back to uncertainty, without browsing the open web.
- Live browser QA on `/about/` confirmed that forced bold output rendered as a real `strong` node and a misspelled warranty-transfer question retrieved the Terms and Conditions guarantee wording. The prompt now requires Legend to name a useful related page and prevents the misleading phrase `from this page alone` after cross-page retrieval has been used.
- Restricted Legend to Fenster Glazing and directly related customer questions after testing showed he would answer general programming questions and repeat visitor profanity. Unrelated requests now receive one short Fenster redirect, mixed requests answer only the Fenster portion, and common profanity is redacted server-side from both conversation input and model output so recall prompts cannot make Legend quote it back.
- The browser supplies a bounded current-page snapshot containing the title, meta description, navigation, main content and footer, plus the last eight in-panel messages. The server sanitises and caps every field, rebuilds the URL as a same-site path, uses `store: false`, and does not log prompts or responses.
- Added REST nonce and same-origin checks, anonymous HMAC-based rate limiting, message/history limits, plain-text rendering and safe customer-facing failure states. When no key is configured, the assistant clearly reports that its AI connection has not yet been switched on.
- Rechecked the test server after the chat appeared offline: the key remained configured and a direct `gpt-5.4-mini` request returned 200. The apparent outage was the frontend using its generic connection copy for a rate-limit response after repeated QA. Raised the anonymous allowance from 20 to 40 messages per ten minutes and added an explicit rate-limit message that confirms the AI connection is still online.
- Kept the component independent from enquiry forms, consent decisions and tracking. It observes the existing cookie controls only for layout, moving above both the compact Cookies button and the full choices banner without changing consent behaviour.
- Added an explicit `Before you chat` acknowledgement that keeps the composer unavailable until the visitor chooses `Continue to chat`. The disclosure explains that relevant page content and messages are processed by AI, warns that replies may be inaccurate and do not create quotations, contracts, warranties, professional advice or legally binding commitments, cautions against sensitive data and links to the expanded Privacy Policy. It never changes a rejected or accepted optional-cookie preference; the later continuity update below documents how the acknowledgement and recent history now follow the visitor across Fenster pages and tabs.
- Replaced the floating chat window with a right-edge drawer that slides in and covers the viewport from top to bottom. The compact Cookies control moves left of the open desktop drawer and is temporarily hidden behind the full-width mobile drawer, then returns when chat closes. Added a soft white halo behind the closed Legend sprite so his black fur and uniform remain clear over dark page sections.
- Corrected Legend's drawer-entry jump after the first drawer build measured his landing point while the panel was still translated off-screen. The handoff now targets the drawer's settled position and uses a four-stage lift, apex, descent and landing curve, preventing the rightward fly-off and teleport.
- Added disclosed 24-hour chat continuity across Fenster pages and browser tabs using `fenster_legend_chat_v1`, capped at 16 recent messages with a visible Clear chat control. The storage begins only after Continue to chat and remains separate from `fenster_cookie_consent`. Promoted visible technical/specification panels and canonical `product_usps` records into high-priority assistant context, including cross-page search, so published values such as the flush uPVC window `1.2 W/m²K` U-value are no longer overlooked.
- Ran a broad live question audit against the protected test assistant. The discovery set exposed wrong or incomplete answers for single-attribute product questions, guarantee scope, triple glazing, service areas, FENSA/CPA details and plural product names. The owner then confirmed the canonical business rules used to settle every conflict.
- Added an authoritative owner-confirmed fact layer and query-matched canonical product facts that outrank old imported FAQs and articles. It records the new-window-and-door-only 10-year CPA-backed guarantee, non-transferability, triple-glazing availability and exceptions, residential versus commercial coverage, FENSA handling, starred U-value meaning, Distinction security guarantee, integral-blind controls and instant-quote pricing boundary.
- Aligned the test CPA, FENSA and Terms wording with the confirmed 10-year insurance-backed guarantee on every new Fenster window and door installation, while retaining CPA's correct role as the back-up if Fenster permanently ceases trading.
- Completed 39 post-fix live REST regression calls. A product-card sweep found a systemic singular/plural alias bug; after fixing it, aluminium flush windows returned A+ and 80mm, heritage windows returned 1.1 W/m²K and A+, and uPVC doors returned 14 colours and multi-point locking. The final boundary check still refused an unrelated JavaScript request.
- Rebuilt the theme, PHP-linted the changed integration and page templates, deployed commit `44597e0` to the protected test site, flushed caches and verified live model responses. Production was not deployed.

## 2026-07-15 - FENSA Page Redesign And Fallback Template Audit

- Replaced the scrape-derived `/glass-and-glazing-federation-ggf-standards/` article with a dedicated customer guidance page. It uses the approved FENSA/CPA visual structure and explains GGF guidance without wrongly implying it is FENSA certification, a product guarantee or a claim of GGF membership.
- Added the indexable `/consumer-protection-association/` route using the FENSA page's approved image-led template. It explains the distinct role of a CPA Insurance Backed Guarantee, links to CPA consumer guidance and makes clear that the individual certificate and policy wording define the cover and duration. CPA logos now link to this route.
- Rewrote the CPA page in direct homeowner language after review: Fenster remains the first point of contact and responsible for its written guarantee; CPA-backed insurance is the safety net if Fenster permanently ceases trading. The page now plainly separates what CPA is, what Fenster does and how the customer benefits.
- Linked every theme-rendered FENSA logo to `/fensa-approved-installers/`, including the footer, homepage proof areas, generated product/location hero proof, consultation reassurance, Why Trust Fenster and the FENSA page itself.
- Updated the approved FENSA page copy from the business owner: Fenster applies for the certificate, FENSA sends it directly to the customer, the certificate avoids a separate Building Control sign-off for eligible work, certification matters during a property sale, and eligible registration includes a CPA-supplied Insurance Backed Guarantee that typically lasts 10 years.
- Rebuilt the FENSA page again after owner review showed the first refinement still did not match `STYLE.md`. The page now speaks as the approved installer, says clearly that eligible work will receive a certificate, and removes the third-party `ask before you appoint an installer` wording.
- Replaced the line-heavy hero proof strip, certificate box, dark covered/excluded band and numbered process rail with the calmer `/why-trust-fenster/` composition: one accreditation assurance panel, two alternating image-led explanations and the existing enquiry section.
- Reworked the first FENSA layout after whole-page review against `STYLE.md`. Removed repeated hero reassurance, changed the hero from showroom photography to a relevant finished installation, replaced the second image with one focused certificate question, converted the dark coverage cards into a quieter divided comparison and corrected the desktop compact form to a two-column layout so the final section stays within a sensible viewport rhythm.
- Updated `AI.md`, `HANDOVER.md` and `LIVECHANGES.md` to make test-first deployment mandatory for every completed change. Small and low-risk changes no longer have a documented direct-to-live exception.
- Replaced `/fensa-approved-installers/` generic imported-article output with a dedicated homeowner conversion page in `template-parts/sections/fensa-approved.php`.
- Removed the route's scrape debris from public output, including `ONLINE DESIGNER`, isolated linked words, social-media filler, old footer/service-area copy and generic quote-engine sections.
- Rewrote the page around current FENSA homeowner guidance: what the certificate proves, which replacement work is normally within the scheme, common exclusions, the Fenster survey-to-registration process and one shared enquiry form.
- Added route-owned SEO title and meta description so malformed imported Open Graph/schema values remain irrelevant to the rendered page.
- Reused local showroom, installation and FENSA assets, added responsive page-specific SCSS, rebuilt compiled CSS and PHP-linted the new template plus routing/SEO changes.
- Audited the generic renderer fallbacks. The thin/noindex shells remain `gallery`, `brochures`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `fenster-partners` and `apecs-terms-conditions`; they should be rebuilt only when there is real content or a working customer function. `/glass-and-glazing-federation-ggf-standards/` is the next indexable compliance page that would benefit from a dedicated treatment. `/our-new-website/` and the retired/template case-study records should be reviewed for redirect or removal rather than automatically redesigned.

## 2026-07-15 - Site-Wide Typography Ceiling And First-Pass Design Contract

- Added `--fg-font-size-max: 3.6rem` as the shared site-wide display-type ceiling and replaced every existing font-size clamp above that value with the token. No source heading or display declaration now exceeds `57.6px`.
- Expanded `STYLE.md` with hard first-pass rules for viewport-contained desktop sections, dark text on light backgrounds, continuous gradients, deliberate image compositions, sustained product imagery, direct `we` and `you` copy, no em dashes, plain action-led CTAs, supplier-source rewriting and rendered-page QA.
- Rebuilt the complete theme CSS and confirmed the source contains no remaining font-size maximum above `3.6rem`.

## 2026-07-14 - Roof Lanterns Dedicated Page Redesign

- Replaced the generic generated-product journey on `/roof-lanterns/` with a dedicated roof-lantern conversion page in `template-parts\sections\roof-lanterns.php`.
- Set the page around one clear customer task: compare the suitable roof lantern specification and request a quote. The new order is an installed-lantern hero and enquiry action, concise S1 specification summary, room-planning guidance, thermal/detail explanation, security, ventilation, then the shared enquiry form and real review proof.
- Used the supplied Sheerline S1 scrape as the product-information and image reference. Added four local, deployable S1 assets for thermal, corner, security and SheerVent details under `assets\images\products\roof-lanterns`; the runtime page does not depend on the scrape export.
- Removed the generic product gallery, broad specification hub, generic choice cards, templated process rail and related-link band from this route only. The shared enquiry component remains the only live form.
- Rebuilt CSS, PHP-linted the dedicated template and router, and browser-checked the redesigned route at `1440 x 900`, `768 x 1024` and `390 x 844` with no horizontal overflow.
- V2 visual review caught a contrast regression in the new page SCSS: undefined `--fg-*` colour variables had made the intended dark S1 technical panel and enquiry frame render transparent over the page gradient. The final V2 direction removes that dark/white-text treatment entirely: all roof-lantern page copy now uses the theme's dark ink/muted text on the continuous light canvas, with white reserved only for existing button/review controls. Reworked the hero around a correctly proportioned vertical kitchen image and added a three-image inside/outside/installed roof-lantern sequence using further local copies from the supplied Sheerline source. Rechecked the full desktop and mobile composition, image crops, loaded images and page-level overflow.
- The final art-direction pass combined the repetitive security and ventilation bands into one two-card specification decision, reduced the overall page length, and corrected inherited dark-form styles that had left labels and field borders nearly invisible on the white enquiry panel. The enquiry form now has explicit light-context colours and a stable full-width mobile submit button. Rebuilt the theme and rechecked the route at desktop, tablet and mobile widths with no failed images or horizontal overflow.
- Committed and pushed the V2 pass as `0ad9d13`, deployed that exact commit to the password-protected test site with a theme-only rsync and cache flush, and verified the route, V2 content, new imagery and hero image response on test.
- The V3 composition correction restores the page-long gradient as the visible continuous canvas, removes the two full-width white washes, enforces the STYLE.md typography caps (`3.6rem` H1, `2rem` supporting H2s), and replaces the unequal portrait/landscape collage with three equal, labelled Sheerline landscape views. Desktop sections now fit within the usable viewport at the supplied `1467 x 709` review size; all sections also fit at `768 x 1024`, while the `390 x 844` hero fits and the image sequence becomes an intentional swipe rail. The shared mobile form remains one column for usability.
- Audited the page copy against the supplied Sheerline S1 scrape. S1-specific appearance, Thermlock, 28mm glazing, size, security, Secured by Design, SheerVent and rain-sensor claims are concise rewrites of the manufacturer source; the room-planning, survey, installation and enquiry language is original Fenster service copy rather than presented as Sheerline wording.
- Restored the preferred asymmetric image treatment in **The S1 system** section: the thermal construction image is again the dominant square visual, paired with a narrower portrait corner detail raised slightly beside it. The compact type and spacing remain unchanged, and the section still fits inside the `1467 x 709` review viewport without horizontal overflow.
- Rewrote the complete roof-lantern page in a direct `we` and `you` voice. Removed third-person references to Fenster, every em dash, vague lifestyle phrases and the `Plan my roof lantern` CTA. The primary action is now `Get a roof lantern quote`, the form action is `Send enquiry`, and the supporting copy explains what we supply, what we check, what the customer can send and what happens next. The verified Sheerline S1 facts remain intact.
- Split flat rooflights out of the roof-lantern journey into a dedicated `/flat-rooflights/` page. `/roof-lanterns/` now contains only Sheerline S1 lantern information, imagery and the 13 configuration carousel; a compact related-product panel links to the separate Titan route.
- Added all 13 official Sheerline S1 configuration renders as a dedicated interactive carousel using the site's established colour-options interaction. It supports buttons, keyboard control, drag/swipe and a visible `01 / 13` counter, while the surrounding copy explains the square, 2-way and 3-way choices in Fenster's own voice.
- Built the new flat-rooflights page from the supplied Titan scrape and its image manifest. The page separately explains fixed EDGE, opening EDGE Air, Multipane for larger openings and Walkon for pedestrian areas, with direct Fenster copy, local official Titan imagery, a dedicated enquiry source and its own SEO metadata.
- Added the new flat-rooflights route to the Products menu, footer and sitemap. Both roof pages cross-link without mixing their main product content or enquiry project types.
- Kept the new rooflight sections within the reviewed viewport at `1467 x 709`, `768 x 1024` and `390 x 844`. Mobile product choices, controls and specialist units use deliberate swipe rails, all added images load from local theme assets, and both pages have no horizontal overflow.
- Removed the flat-rooflight manufacturer's name and model branding from all customer-facing copy, metadata, captions and alt text. The page now describes the choices generically as fixed, opening, multi-pane and walk-on. Removed the concealed actuator section diagram and retained only the customer-relevant remote and wall-control image.

## 2026-07-14 - Reusable Consultation Booking Request To Test

- Extended the one shared `enquiry-form.php` component with a reusable `consultation_booking` mode rather than adding a second customer form.
- Added an accessible fixed-panel request flow: the next 30 days of weekdays are replaced by a 9am-4pm preferred-time choice, then the normal contact/privacy details, with back controls rather than a stacked form.
- Added a dark-blue desktop-header `Book consultation` action beside `Instant Quote`.
- Added the dedicated, indexable `/book-a-consultation/` route with route-specific title/meta/canonical, sitemap inclusion, breadcrumb schema, visible FAQ/FAQPage schema, the homepage's four-card reviews/accreditations proof row, review proof and the same shared staged consultation form. The page uses one continuous `--fg-page-gradient` canvas in line with `STYLE.md`. Header, footer and Contact now link to this canonical booking route.
- Added server-side weekday, 30-day-window and 9am-4pm validation in `inc\enquiries.php`; selected date/time are saved with the private enquiry and shown in the branded `info@fensterglazing.com` office email.
- Reworked the calendar after visual review into a compact six-week card sized to its actual content, with a visible three-part availability strip for Monday-Friday, 9am-4pm and bank-holiday exclusions. England-and-Wales bank holidays now come from the official GOV.UK feed and are blocked by both the picker and server validation.
- Rebuilt the final booking-details stage as a light consultation-specific form surface: the chosen slot is clearly summarised, fields and required labels remain legible, and the privacy/submit finish is visually contained.
- Replaced the staged booking flow's `Change date` and `Change time` text links with compact, labelled back-arrow controls.
- Added a compact image pair to the consultation hero using the real Milton Keynes showroom and a completed Fenster installation. Updated `STYLE.md` so future new customer-facing pages must scan available local assets and use relevant real imagery when it adds trust, clarity or conversion value.
- Replaced the Contact consultation link with the new `#book-consultation` section. The customer copy correctly says Fenster confirms the requested appointment.
- Reverted the 2026-07-14 wholesale consultation-page rebuild (commits `40db70d`/`03763c1`/`a0bfbac`). That rebuild overreacted to a visual critique: it replaced the approved page structure with a generic three-column image-card section, removed the established four-card proof row and booking steps, and forced imagery into sections that did not need it. The approved `5e695bf` composition is restored as the baseline — hero copy/imagery beside the booking panel, homepage-style proof row, booking steps, advice/contact, FAQs, review showcase and related links — with three small evidenced fixes kept: tighter section rhythm (`clamp(3rem, 5.5vw, 5rem)` desktop, `3rem` at 560px), subtle icon-led phone/email actions in the `Prefer to speak now?` panel, and no functional changes to the shared consultation booking flow. `AI.md` and `STYLE.md` recovery rules were corrected: preserve approved layout, smallest coherent fix first, and a full redesign requires explicit owner approval.
- Replaced that restored baseline with the owner-approved consultation hierarchy: one booking-first calendar hero, a compact Trustpilot/FENSA reassurance strip, one art-directed bifold-door advice/contact section, concise FAQ answers and real review proof. Removed the legacy process cards, detached proof wall, extra hero image tiles and related-link filler. This is the accepted exception to the preservation rule because the owner explicitly approved the new hierarchy. The Products mega-menu now also presents `Book a consultation` beside `Get an instant quote`.
- Expanded `STYLE.md` with the durable first-pass design direction: identify the customer task, dominant first-view object, retained/removed sections, one image treatment and proof role before coding; build a complete hierarchy rather than patching components; use conversion-page order and a clear stopping point; and reject generic card stacks, duplicate proof/CTAs, filler links and imagery with no job. This is the operating standard for getting future page work right without back-and-forth.

## 2026-07-13 - Complete Generated Meta Description Rewrite

- Replaced the long matrix and commercial-county description formulas with concise, complete page-specific sentences; each retains the product or county intent without clipping the end of the copy.
- Rewrote every remaining legacy/generated description that exceeded 160 characters, including the homepage, trust page, commercial hubs, archive shells and older imported SEO fields.
- Kept `fenster_trim_meta_description()` only as a future-safety guard. Source verification across 754 generated and virtual routes found zero descriptions above 160 characters and zero source descriptions ending in its `...` fallback.
- Applied the final editorial review to six legacy descriptions (`/about/`, `/are-my-windows-energy-efficient/`, `/blog/`, two case studies and `/what-are-integral-blinds/`), correcting grammar, the energy-efficiency meaning, stray punctuation and incomplete sentence endings.

## 2026-07-13 - Live SEO Audit Follow-up

- Replaced the two `/areas-we-cover/` shortcut links that still pointed to legacy `/windows/` and `/doors/` redirects with direct canonical links to the Milton Keynes hubs.
- Rewrote the weak generic title tags on `/about/` and `/blog/`, and replaced the overlong, article-like `/commercial-glazing-leeds/` title with a concise commercial-service title.
- The live 681-URL audit found zero sitemap fetch, canonical, title duplication, description duplication, H1, `noindex`, Open Graph image or JSON-LD coverage errors. The remaining strategic SEO work is earning and publishing genuine local project proof for the suburb cluster.
- Reconciled `SEO-AUDIT.md` against a fresh 681-URL live crawl: marked F1–F4 and the completed F9 work, clearly separated historical GSC/competitor snapshots from current advice, and replaced obsolete lead-tracking guidance with the deployed consent-safe first-party attribution model.
- Restored Milton Keynes to the `/roof-lanterns/` title, removed the repeated location from the pricing-hub title, and replaced the head-term page's internal “routes” wording with customer-facing language.

## 2026-07-13 - MK Matrix Canonicalisation And Metadata Guard

- Removed `milton-keynes` from the residential location matrix. The 21 duplicate `/{product}-milton-keynes/` URLs now 301 to their parent product pages, rather than competing with their existing Milton Keynes product intent.
- Added a shared generated-page metadata guard that trims description and Open Graph description output to 160 characters or fewer at render time, protecting all generated routes from overlong inherited descriptions.
- Removed the Woburn 410 link from `/commercial-projects/` by excluding deliberately retired case-study routes from archive cards.
- Local verification: sitemap reduced from 701 to 680 URLs; no product matrix `-milton-keynes/` URLs remain; all 21 legacy URLs resolve to their parent products; `/composite-doors-bletchley/` renders 151-character description and Open Graph description; the Woburn card is absent.

## 2026-07-13 - Consent-Safe Website Attribution And Marketing Dashboard

- Added the Fenster Marketing Dashboard Website Tracker in the separate `Marketing-Dashboard` Cloudflare Pages project. Its source code, API and tracker documentation are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`. It now reports consented anonymous visitors, first touch, acquisition channels, quote starts, forms, contact intent, completed WindowCAD quotes and a clickable per-visitor event timeline with page views, time on page and meaningful link clicks.
- Extended the accepted-only tracker with CTA clicks, 25/50/75/90% scroll milestones, form starts and first validation warning (field name only). The dashboard now shows a more useful lead funnel and lets the office label completed website leads `new`, `contacted`, `appointment`, `won` or `lost` without copying customer details into D1.
- Changed the aggregate consent request to a simple `text/plain` CORS request so it does not depend on a JSON preflight when someone closes the banner on a privacy-focused/mobile browser.
- Removed banner-impression reporting entirely. The original implementation counted each fresh page load before a choice and even a session-only guard could still be inflated by anonymous crawler sessions. Consent health now truthfully reports recorded accepts and rejects only.
- The theme creates opaque `FGV-…` visitor and `FG2-…` journey values only after optional-cookie acceptance. Both persist for 90 days in the same consenting browser; incognito, cleared storage, a different device or a rejected choice starts no tracked visitor.
- WindowCAD attribution now uses only its dedicated **Tracking** customer field. The office-owned **Reference** field remains untouched. Accepted journeys pass `FG2-…`; rejected-cookie quotes pass `rejected-cookies`, and quotes before a choice pass `cookie-consent-not-accepted`.
- WindowCAD and normal form leads still reach WordPress/AdminBase after a rejection, but the dashboard relay is suppressed without a valid `FG2-…`. This prevents unconsented quotes/forms becoming unattributed dashboard records.
- Added aggregate-only consent health reporting: daily accepts, rejects and acceptance rate. The consent table has no visitor identifier, URL, source, device or personal data; banner impressions were removed as unreliable before-consent crawler/session traffic inflated them.
- Added the mobile green header `Call us` control beside Menu; it records a consented phone-tap intent only. Actual answered/missed call attribution remains pending Focus Group API/webhook or scheduled call-report export.
- The final consent-metric correction is live in theme commit `f6c763e` and Marketing Dashboard commit `4957c7e`. The current consent health panel deliberately reports choices recorded, accepts, rejects and acceptance rate only.
- Refreshed the durable theme handover, audit, live-change and progress documentation to record the tracker architecture, privacy boundary, WindowCAD Tracking-field bridge, dashboard ownership and outstanding Focus Group/CRM work. A clean evidence-based continuation prompt was also prepared for the next chat; it treats the early launch GSC observations as historical context rather than current fact.

## 2026-07-13 - Search Console Launch Baseline And SEO Plan

- Reviewed the Google Search Console exports for `Last 7 days` and `Last 28 days`, ending 2026-07-10. The new site went live on 2026-07-06, so the 7-day report mixes old-site Saturday/Sunday with new-site Monday-Friday, and Google may still be crawling/indexing old templates.
- The cleanest early comparison is old-site weekdays 2026-06-29 to 2026-07-03 versus new-site weekdays 2026-07-06 to 2026-07-10: clicks stayed essentially flat at 86 -> 87, impressions rose slightly from 23,362 -> 23,709, weighted CTR stayed about 0.37%, and average position improved from about 24.7 to 23.7. This is not a launch win yet, but it shows no immediate search cliff.
- The full 28-day baseline was 405 clicks, 127,649 impressions, 0.32% CTR and average position 24.6. The launch-week slice was slightly above that at about 15.1 clicks/day, but this is too early to judge new-site SEO success.
- The main finding is that Google is still carrying the site through older informational and utility pages rather than the new MK money-page structure. Strong existing traffic/visibility includes `/3d-visualiser/`, `/what-is-a-door-lintel/`, `/different-types-of-window-frame-materials/`, `/what-are-double-glazed-glass-windows/`, `/soundproof-windows/` and `/french-casement-windows/`.
- Highest-priority CTR opportunity: `/french-casement-windows/` had 3,614 impressions, average position 3.52 and only 0.19% CTR across the 28-day export. Its title/meta/first-screen/snippet intent should be fixed before lower-signal SEO work.
- Highest-priority visibility-but-no-click opportunity: `/what-are-double-glazed-glass-windows/` had 17,884 impressions, 10 clicks and 0.06% CTR. It needs clearer intent ownership around double-glazed glass, replacement sealed units, misted glass, energy upgrades and commercial routes into quote/repair/product pages.
- Money-page state: `/windows-milton-keynes/` had 4,630 impressions, 7 clicks and average position 18.17; `/double-glazing-milton-keynes/` had 1,115 impressions, 0 clicks and average position 56.47; `/doors-milton-keynes/` had 2,416 impressions, 3 clicks and average position 43.71. These pages need more internal authority, richer local/commercial content and stronger conversion structure before judging them.
- Priority fix plan: improve SERP titles/meta and first-screen relevance for `/french-casement-windows/`, `/what-are-double-glazed-glass-windows/`, `/composite-doors/`, `/soundproof-windows/` and related high-impression pages; turn high-traffic info pages into feeders for quote/visualiser/MK pages; strengthen `/double-glazing-milton-keynes/`, `/windows-milton-keynes/` and `/doors-milton-keynes/` through internal links, product-led sections, local trust/proof, pricing/visualiser CTAs and readable SEO copy.
- Next measurement should compare clean new-site weeks, especially 2026-07-06 to 2026-07-10 versus 2026-07-13 to 2026-07-17, instead of treating the mixed launch export as a final verdict.

## 2026-07-09 - Local MK Page Cluster First Pass To Test

- Added a shared local buying-route section to the residential town/product matrix in `template-parts\sections\location-service.php`.
- The new section appears on normal local pages such as `/double-glazing-bletchley/` and `/composite-doors-bletchley/`, adding an image-led local decision block, three town/product-specific guidance cards, instant quote CTA, MK money-page CTA and internal links back to the relevant product route plus the town double-glazing hub.
- Added responsive styling in `src\scss\main.scss` so the new module stacks cleanly on mobile and preserves the continuous page canvas.
- Local verification covered `/double-glazing-bletchley/` and `/composite-doors-bletchley/`: the section rendered with one image, three decision cards, expected CTAs/internal links and zero horizontal overflow on desktop and 390px mobile.

## 2026-07-09 - Local SEO Quick Wins And Pricing Route Correction

- Shipped GSC/audit-led local SEO quick wins in commit `68f38ae` (`Implement local SEO audit quick wins`), then corrected the accidental exact pricing route in commit `51c3550` (`Remove double glazing prices route`).
- Restored `/areas-we-cover/` into the generated `page-sitemap.xml` virtual-route list and added visible links to it from the footer, homepage local mesh and generated related-link bands.
- Strengthened internal links into `/double-glazing-milton-keynes/` and the agreed live pricing hub `/window-door-prices-milton-keynes/`; the accidental `/double-glazing-prices-milton-keynes/` route was removed, now returns 404, is not in the live sitemap and has no homepage/MK-page internal links.
- Added LocalBusiness schema fields for `geo`, `hasMap` and `sameAs`, and verified live schema renders clean `priceRange` (`££`) without mojibake.
- Cleaned local money-page title/meta overrides for key routes including aluminium bifolds, aluminium flush windows, aluminium sliding doors, window and door repairs, patio doors, sliding sash windows, tilt and turn windows, roofline and similar MK-focused product pages.
- Confirmed the "roof lights" keyword work is already in the GSC override map: `/roof-lanterns/`, `/roof-lanterns-milton-keynes/` and `/roof-lanterns-northampton/` titles/meta include "Roof Lights" alongside "Roof Lanterns".
- Verified live after deployment: `/double-glazing-milton-keynes/`, `/areas-we-cover/`, `/window-door-prices-milton-keynes/`, `/aluminium-bifold-doors/` and `/window-and-door-repairs/` render expected titles/schema/footer links; `page-sitemap.xml` includes `/areas-we-cover/` and `/window-door-prices-milton-keynes/`.

## 2026-07-09 - Door Handle Section Scope

- Removed `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` from the shared long-plate `door_handles` route list because those systems use different handle families.
- Kept the selector active for relevant entrance/French-style door routes such as `/upvc-doors/` and `/french-doors/`.
- Pushed and deployed commit `882cf47` (`Scope door handle selector routes`) to live with a theme-only SiteGround rsync and cache flush.
- Verified locally that the affected three routes return 200 without `#fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still render the section.
- Verified live server-side that `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` return 200 without `fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still include it.

## 2026-07-09 - Product Image Pool Audit

- Audited the product image source path after uPVC door pages were showing aluminium, composite and other wrong-material images.
- Found the issue in `inc\site-data.php`: several product routes shared broad gallery pools such as `entrance_doors`, `wide_span_doors` and `aluminium_doors`, so unrelated product families bled into each other.
- Split curated gallery pools by material/product family for uPVC doors, composite doors, patio doors, French doors, aluminium doors, aluminium bifolds, slide-fold doors and aluminium sliding doors.
- Cleaned uPVC and aluminium window pools so they no longer borrow obvious wrong-material product images just to fill the gallery.
- Updated `template-parts\sections\location-service.php` so generated town/service routes reuse the same curated product media and gallery pools instead of falling back to raw imported scrape images.
- Pushed and deployed commit `97d7525` (`Fix product image gallery pools`) to live with a theme-only SiteGround rsync and cache flush.
- Verified representative main product and matrix routes locally, including `/upvc-doors/`, `/composite-doors/`, `/patio-doors/`, `/french-doors/`, `/aluminium-doors/`, `/aluminium-bifold-doors/`, `/aluminium-sliding-doors/`, `/upvc-doors-milton-keynes/`, `/french-doors-milton-keynes/`, `/patio-doors-milton-keynes/` and aluminium/composite matrix equivalents.
- Verified the live `/upvc-doors/` route server-side after deployment; it returns 200 and includes the curated uPVC/front-door image set (`fenster-upvc-door.jpg`, `Residential_Door_08.jpg`, `Residential_Door_01.jpg`, `new-front-door-in-Milton-Keynes.jpeg`, `house-front-door.jpeg`, `secure-front-door.jpeg`).

## 2026-07-09 - Microsoft Clarity Replay Rendering Fix

- Debugged broken Clarity recordings by simulating Clarity-style page/resource fetches rather than changing visible layout again.
- Found that the real browser site was styled correctly, but browser-like bot/resource requests could receive the SiteGround/nginx `403 - Forbidden` HTML page. That explained Clarity recordings showing raw/default navigation, huge graphics/images and missing CSS.
- Removed the live Clarity plugins (`microsoft-clarity` and `clarity-ad-blocker`) so Clarity is loaded only through the theme consent layer.
- Kept Clarity project ID `xi7rk1pic8` in `inc\consent.php`, gated behind accepted optional-cookie consent.
- Added `data-clarity-unmask="true"` to stylesheet links, critical CSS, font preloads and key image preloads in `inc\assets.php` so stricter Clarity masking preserves resource URLs.
- Added the accepted workaround in commit `f820b87`: after accepted consent, fetch the live `main.css`, inject it into the DOM as `style#fenster-clarity-replay-css[data-clarity-unmask="true"]`, and only then load Clarity. This gives new recordings a self-contained copy of the theme stylesheet even if Clarity's backend/player cannot fetch external CSS later.
- Verified live that the inline replay CSS is present before `clarity.ms/tag` and before `q.clarity.ms/collect`; owner confirmed new Clarity recording renders correctly.

## 2026-07-07 - Commercial Product Template Local Rebuild

- Put the wider live audit on hold to address poor commercial product pages first, especially `/curtain-walling/`.
- Added a dedicated commercial product data layer and template for `/commercial-windows-and-doors/`, `/curtain-walling/`, `/louvre-vents/`, `/commercial-automation/` and `/healthcare-construction/` so these routes no longer depend on the generic generated product journey or rough scraped body sections.
- Curated commercial imagery from the imported theme assets for hero, gallery and related cards, including the curtain walling and real commercial project photos.
- Rebuilt compiled CSS and verified PHP syntax for the touched files.
- Local route checks confirmed all five routes return 200, render the new `fg-commercial-product` template, have no old designer/WindowCAD scrape copy, no broken images, no horizontal overflow and no console errors at desktop and mobile widths.
- Deployed commit `26f3b43` to the password-protected test site and repeated server/browser checks there. This still needs explicit approval before live.

## 2026-07-07 - Clarity Consent Session Fix

- Fixed the Clarity consent setup so accepted visitors receive Microsoft Clarity Consent API v2 signals instead of being treated as no-consent page views.
- Aligned the theme-loaded Clarity project ID with the WordPress Clarity plugin setting (`xi7rk1pic8`) while keeping third-party tracking blocked until the site cookie banner is accepted.
- Local browser verification confirmed no Clarity/GTM/Facebook tracking scripts or `_cl*` cookies before consent, then persistent `_clck` and `_clsk` cookies after acceptance across `/aluminium-doors/` to `/sliding-sash-windows/` navigation.

## 2026-07-07 - Cookie Policy Copy Cleanup

- Replaced the imported `/cookie-policy/` wording with a site-specific policy that matches the current consent banner and tracking setup.
- Deployed the corrected policy copy to test and live through commit `bc625f4`.
- Removed irrelevant claims about customer accounts, logged-in areas, newsletter subscriptions and on-site surveys.
- Clarified that optional Google Tag Manager, Microsoft Clarity and Meta Pixel only load after consent, and that visitors can still use the site after rejecting optional cookies.
- Updated `/privacy-policy/` copy to state that the website does not currently provide customer account registration or an email newsletter sign-up.

## 2026-07-07 - Site-Wide Copy Audit Cleanup To Test

- Verified the 2026-07-06 AI copy audit against current theme source before editing.
- Deployed the verified copy cleanup live through commit `4ce91a6`, after first deploying and checking the same commit on test.
- Removed customer-facing template self-talk from product galleries and specification-choice cards, including `verified product imagery`, `verified supplier imagery`, `page stays visually accurate` and finish-guide architecture wording.
- Replaced visible internal `route` wording across commercial county pages, the trust page, contact page, product hubs, pet-flap copy, handle copy and legacy generated sections with customer-facing terms such as option, approach, process, system and fitting method.
- Lower-cased mid-sentence `obscured glass` copy, while keeping route/title naming where `Obscured Glass` is the page name.
- Rewrote copied article/data fragments in `data/pages.json` that ended mid-sentence or promised non-existent live chat; contact copy now points visitors to phone or email, and the verified 24/7 phone-line footer claim remains in place.
- Verified JSON parsing, PHP lint for all touched PHP files, targeted source greps and local rendered checks on representative product, article, commercial county, commercial projects and obscured-glass routes.

## 2026-07-07 - Product Template Live Polish, Gallery Lightbox And Mobile Nav Fix

- Deployed the shared product-page redesign and follow-up polish live through commit `3ac98c2`.
- Product sections now use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems filler section from generated product pages.
- Product galleries now open in an in-page lightbox rather than a raw image URL/new tab. The accepted lightbox has no visible caption/alt text, no white image card, close/backdrop/Escape handling, previous/next arrows and keyboard left/right navigation.
- Fixed the mobile navigation touch layer so the open menu owns the viewport and page hero/content layers cannot intercept taps on mobile menu rows.
- Verification covered `npm.cmd run build`, PHP lint for changed templates, and browser checks on `/casement-windows/` for the lightbox and mobile nav behaviour.

## 2026-07-07 - Product Page Layout Redesign To Test

- Reworked the shared generated product-page journey toward a clearer 50/50 image-and-copy flow before live approval.
- Replaced the non-FAQ "Why choose this product?" accordion with visible benefit cards, and replaced the tabbed product information explorer with visible specification check cards. FAQs remain the only accordion-style content on product pages.
- Added a no-repeat image queue for product pages: the body image pool excludes the hero image, and later gallery moments draw from later unique images rather than recycling the same visual.
- Moved window handle selection out of inline product pages into a dedicated `/window-handles/` specification hub, with product pages linking to that hub from the specification choices area.
- Refined the test template copy so product intro sections use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems section from generated product pages.
- Expanded the product-hub specification check cards to fill the section width, and made product-gallery images open through the site lightbox with a hover affordance.
- This change was reviewed, refined and later deployed live through commit `3ac98c2`.

## 2026-07-06 - Reviews Copy And Privacy Policy Cleanup

- Replaced hardcoded review-count claims such as `200+ five-star reviews`, `Google 130 reviews` and `Trustpilot 226 reviews` with stable wording around hundreds of customer reviews across Google and Trustpilot.
- Rebuilt `/privacy-policy/` as a theme-owned virtual page with clean title/meta and current plain-English content covering enquiries, uploads, WindowCAD, AdminBase, cookies, analytics, retention and customer rights.

## 2026-07-06 - Test Domain Deindex Hardening

- Rechecked `test.fensterglazing.com` after it appeared in Google results despite Basic Auth.
- Confirmed the test homepage and `robots.txt` were returning `401` without an `X-Robots-Tag`, which could leave stale URL-only search results.
- Updated both the Bedrock root and `/web` test `.htaccess` files on the server so normal test URLs stay password protected but return a custom `401` response with `X-Robots-Tag: noindex, nofollow, noarchive`.
- Added public `robots.txt` files on test with `Allow: /` so crawlers are not blocked from revisiting already-known URLs and seeing the noindex/401 response.

## 2026-07-06 - WindowCAD/AdminBase Relay Restored

- Tracked the missing integration to the inactive live `wraith` theme over SSH.
- Found the old `/wp-json/fenster/v1/windowcad` REST endpoint in `wraith/app/setup.php`, which flattened WindowCAD `json.infoProperties` and posted leads to AdminBase.
- Added `wp-content/themes/fenster/inc/adminbase.php` and included it from `functions.php`.
- Restored the WindowCAD REST endpoint, private WordPress enquiry saving for WindowCAD submissions, AdminBase relay metadata, and normal enquiry relay through `fenster_enquiry_created`.
- Kept AdminBase credentials out of the repo; the new theme reads constants, environment variables or WordPress options.

## 2026-07-06 - Redirect, Duplicate Host And Consent Fixes

- Removed the live `/terms-conditions/` redirect that sent footer legal links to `/privacy-policy//`; the server now returns the Terms page directly.
- Deleted the legacy redirect row hijacking `/aluminium-bifold-doors-northampton/`; the generated Northampton bifold route now returns directly.
- Added a live server redirect from `www.fensterglazing.com` to the apex host before the Bedrock internal rewrite.
- Password-protected `test.fensterglazing.com` with Basic Auth (`fenster` / `Fenster`) so it is no longer a public crawlable duplicate.
- Added theme-owned cookie consent controls that suppress automatic GTM, Clarity and Meta Pixel output until a visitor accepts optional cookies.

## 2026-07-06 - Deploy Policy Clarification

- Historical note: this entry originally allowed small, scoped, low-risk changes to go directly to live. That workflow was superseded on 2026-07-15; every completed change now goes to the password-protected test site first.

## 2026-07-06 - Cat And Dog Flaps Page Rewrite

- Rebuilt `/cat-and-dog-flaps/` at the generated-page source after the imported scrape title and copy produced bad output such as "Need Cat and Dog Flaps?" and double-question headings.
- Added a route-specific generated-page SEO/title override so the page now uses `Cat and Dog Flaps` consistently in the H1, metadata, FAQ heading and internal labels.
- Rewrote the pet-flap product intro, benefits, FAQs, product-hub detail and USP labels around the real customer decision: suitable door panel versus new sealed glass unit, manual/lockable/microchip options, pet size, flap height and survey checks.
- Added a dedicated pet-flap fitting guide section and suppressed the generic product visual gallery/specification-choice block on this route, because frame-colour/privacy-glass catalogue copy does not fit the service.
- Added responsive SCSS for the pet-flap guide cards so the page collapses cleanly on mobile.

## 2026-07-06 - Lighthouse Performance Wave 1 And 2

- Added a performance pass in response to the mobile Lighthouse report showing 62 Performance, 4.3s FCP and 14.5s LCP on slow 4G.
- Added critical first-viewport CSS and changed the main stylesheet link to preload/activate asynchronously with a noscript fallback, reducing render-blocking pressure while keeping the hero/header styled.
- Added WOFF2 versions of the Gibson fonts and updated `@font-face` declarations to prefer WOFF2 with OTF fallback; Regular and SemiBold are preloaded as critical weights.
- Added a homepage hero-poster preload and changed the homepage hero video lazy loader so mobile, reduced-motion and constrained-connection sessions keep the 9.36 MB video out of the initial load until interaction.
- Added `fenster_image_attr_string()` and related helpers in `inc\assets.php` so local theme images can render explicit width/height attributes; applied it to the header logo, homepage product/trust/partner images, and key generated/article/location hero images.
- Added below-fold homepage `content-visibility` guardrails for the quote, partner, review, enquiry and local-link sections.
- Improved review carousel ARIA by giving decorative star/Google label spans explicit image/group roles, and increased mobile product dots/review carousel buttons to 44 px tap targets.
- Verification: `npm.cmd run build` passed; PHP lint passed for all touched PHP files; browser check on the local homepage confirmed poster/font preloads, explicit image dimensions, no desktop/mobile horizontal overflow, mobile hero video source still deferred after 2.5s, 44 px mobile dots and no console errors.
- Static cache headers still need a server/SiteGround step because `app/public/.htaccess` is ignored by the GitHub theme repo. Add long-lived `Cache-Control: public, max-age=31536000, immutable` for theme CSS, JS, fonts, images and video at host/CDN level.

## 2026-07-06 - Article CTA Form Layout Fix

- Fixed generated article/blog CTA form layout and contrast in commit `aff62a0`.
- Added the `fg-article-form` class to the shared enquiry form when rendered from `template-parts\sections\generated-article.php`.
- Added article-specific CTA/form styling so the left copy panel has deliberate contrast and the right form has readable labels, visible input borders, sane textarea height and a mobile one-column layout.
- Rebuilt compiled CSS, pushed to GitHub, deployed to live with the theme-only SiteGround workflow and flushed the WordPress cache.
- Server verification passed: `generated-article.php` had no PHP syntax errors and live CSS/template contained the new article form selectors.

## 2026-07-06 - Performance Deferral Pass

- Improved live loading behaviour in commit `7c973b5` without removing the premium video/quote experience.
- Deferred the homepage hero video until page idle so it is not a blocking first-load dependency.
- Deferred homepage/product/quote WindowCAD iframe source loading through `data-quote-iframe-src`, with near-viewport and click/interaction triggers.
- Kept quote tool placeholders/actions usable while the iframe loads.
- Reduced eager media pressure in the homepage product theatre and heavy generated product sections.
- Rebuilt CSS/JS, pushed to GitHub and deployed live.

## 2026-07-06 - Commercial Glazing Hub V2

- Reworked the main `/commercial-glazing/` page in commit `5696140` to be simpler, proof-led and more conversion-focused.
- Corrected project proof imagery to use commercial-project/theme assets rather than wrong generic images.
- Reworked commercial glazing products/services imagery from available Fenster/theme assets and kept runtime references out of `wp-content\fenster-reference`.
- Removed the tiny decorative parallax drift in the "How enquiries move" area.
- Tightened and simplified awkward page sections such as "Where this fits" so the page is less padded and more practical.
- Restyled the commercial enquiry section so the form inputs are visible and the copy does not use oversized hero text.
- Rebuilt compiled CSS, pushed to GitHub and deployed live.

## 2026-07-06 - Stale Audit Recheck And SEO Hardening

- Rechecked the outdated pre-launch audit claims against live output instead of trusting the old crawl notes.
- Verified social share metadata is already clean on live: homepage and product routes emit current theme-owned OG/Twitter title/image tags using the local showroom image.
- Verified live language output is already `lang="en-GB"` and WordPress `WPLANG` is `en_GB`.
- Fixed the confirmed colour-hub duplicate issue: `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/`.
- Added `inc/security.php` to harden public WordPress output: unauthenticated REST user enumeration returns 401, XML-RPC is disabled via WordPress filter, `X-Pingback` is removed, and WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output is stripped.
- Restored theme sitemap ownership before Rank Math can serve XML, so `/sitemap.xml` points at the theme `page-sitemap.xml`; live verification showed 421 canonical URLs, `/colour-options/` included, and redirected colour URLs excluded.
- PHP lint passed for changed files, changes were pushed to GitHub and deployed live through the theme-only SiteGround workflow.

## 2026-07-06 - Mobile Product Template Fixes

- Fixed the owner phone QA issues from the product template pass and deployed them live in commit `c21bd46`.
- Product information hubs now have calmer mobile spacing between "Why choose this product" and the hub.
- Product hub supplier/proof badges are constrained on mobile so Liniar, Energy Plus, A+ rated and PAS 24 badges sit at more balanced visual sizes.
- The product information tab rail is viewport-contained on mobile, uses native horizontal scroll-snap, hides the scrollbar, and adds a visible "Swipe to see all product checks" affordance when there are more than two checks.
- The common-choice strip stacks on mobile and no longer uses two wide columns that can push the whole page sideways.
- `/colour-options/` hides the hero sample-board visual on mobile so the page starts cleaner.
- `/sliding-sash-windows/` now has mobile-specific sizing for Roseview model cards, comparison rows and detail imagery: smaller contained images, stacked comparison cards and fixed-aspect image panels.
- Verification: `npm.cmd run build` passed, `generated-page.php` passed PHP lint, the theme was pushed to GitHub and deployed to live with cache flushed.

## 2026-07-06 - Live Phone QA Notes

- Captured owner phone QA findings for the next mobile polish pass. These findings were addressed in later product-template/mobile fixes and superseded by the live product-page redesign through `3ac98c2`.
- Product pages such as `/casement-windows/` are broadly strong at the top, but need spacing and mobile component polish around the "Why choose this product" to product hub transition.
- Product hub logo sizing needs balancing on mobile: Liniar and Energy Plus currently feel oversized compared with A+ rated and PAS 24 proof badges.
- The common-choice/product-view control area is a priority bug: it can overflow its frame and create full-page horizontal scrolling on mobile.
- Product-view controls need clearer discoverability when more than two options exist.
- `/colour-options/` should remove or simplify the hero image on mobile; the rest of the page is acceptable.
- `/sliding-sash-windows/` needs mobile-specific redesign work for the Roseview model stats, corner detail, slide-aligned comparisons and large detail imagery.
- No code changes were made in this entry; this was documentation of live phone QA findings before the later fixes.

## 2026-07-06 - SiteGround Test Deploy, SEO Ownership And Forms

- Verified the real SiteGround structure: both test and live are Bedrock installs, so the server theme path is `web/app/themes/fenster` even though local development uses `wp-content/themes/fenster`.
- Deployed the GitHub theme to `https://test.fensterglazing.com` from the server repo cache at `~/repos/FensterGlazing-NewSite`, then activated the `fenster` theme on test. The same theme has since been deployed and activated on live.
- Disabled the test-only `mousewheel-smooth-scroll` plugin because it conflicted with the theme's Lenis scrolling and caused jumpy scroll behaviour. Do not run another smooth-scroll plugin alongside the theme.
- Fixed Bedrock theme asset URLs so generated `/wp-content/themes/fenster/...` references map to the real theme URI under `/app/themes/fenster/...`; this restored imported images and theme-owned media on test.
- Added the aluminium windows story-frame folders to git so the scroll video on `/aluminium-windows/` works on test instead of only locally.
- Suppressed Yoast and Rank Math public head output on generated pages, then added theme-owned title/social meta handling so public SEO tags come from the theme rather than stale plugin/imported data.
- Tightened contact and online-quote titles, zoomed the WindowCAD iframe down for a usable first view, and verified key routes/assets returned 200 on test.
- Verified enquiry delivery on test and live: valid AJAX form submissions save as private `fenster_enquiry` posts and send an office HTML email to `info@fensterglazing.com`.
- Polished the enquiry email HTML header so the Fenster logo sits on a light header and remains visible in email clients.
- Matched the old working office-email envelope (`WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`) after live manual submissions confirmed the office-facing email was the fragile part.
- Paused customer confirmation emails unless authenticated SMTP is configured, and removed public form copy that told customers to wait for or reply to a confirmation email.
- Added optional enquiry file uploads for photos, drawings, schedules and documents; uploaded files are stored against the private enquiry and attached to the office email.
- Temporarily hid the unfinished residential case-study area for launch: `/case-studies/` and known residential child case-study routes now return 410 and are excluded from the sitemap, with public CTAs moved to `/commercial-projects/`. Commercial project records stay reachable for proof.
- Renamed the privacy-glass route to `/obscured-glass/`, added a 301 from `/obscure-glass/`, updated visible copy to "obscured glass", and adjusted the mobile visualiser so it does not trap normal vertical scrolling.
- Documented the future workflow as local code change -> GitHub -> test deploy -> verify -> fresh live backup -> live deploy, avoiding direct live editing and SiteGround clone/staging tools.

## 2026-07-06 - Launch Documentation, GitHub And Mobile Polish

- Pushed the scoped project to GitHub at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`, keeping the repo focused on the custom theme and docs rather than WordPress core, uploads, `wp-config.php`, local backups or the `wp-content\fenster-reference` archive.
- Clarified the launch deploy model in the docs: update/swap `wp-content\themes\fenster` from the repo, leave production database/uploads/plugins/config in place, and keep reference archives out of production.
- Fixed mobile About page process cards so text has proper internal padding and no longer touches the card border.
- Fixed mobile Contact page CTA cards so the image overlays, headings, body copy and action arrows are readable and no longer overlap.
- Simplified mobile quote-tool actions on `/online-quote/` and product quote embeds: mobile now shows one same-tab `Open quote tool` action, while desktop keeps `Expand view` and `Open in new tab`.
- Rebuilt compiled CSS and linted changed PHP templates for the mobile quote/link changes, then browser-checked the About, Contact, online quote and product quote embed views at mobile size.
- Updated `AI.md`, `HANDOVER.md`, `HOMEPAGE.md`, `STYLE.md`, `PROGRESS.md` and `AUDIT.md` with the launch state, GitHub scope, SEO work, deploy boundary and mobile quote behaviour.

## 2026-07-06 - Launch SEO Hardening Pass

- Overrode the imported homepage SEO with a launch-focused title and meta description targeting double glazing, windows and doors in Milton Keynes, Bedfordshire and Buckinghamshire.
- Added per-request memoisation for `fenster_get_generated_page()` so repeated title/meta/schema/preload/router lookups do not rebuild the same generated page payload within one request.
- Removed the remaining public no-cache behaviour for generated pages and XML sitemaps by replacing WordPress default headers with short public cache headers for logged-out visitors.
- Added generated `BreadcrumbList` JSON-LD on deep generated routes, rolling commercial county pages up to `/commercial-glazing/` and residential product/location pages up to `/areas-we-cover/`.
- Added 301 normalisation for generated routes without trailing slashes and for mixed-case generated URLs, verified with `/casement-windows` and `/Casement-Windows/`.
- Tightened sitemap hygiene: thin utility/scrape shell pages (`gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `brochures`, `apecs-terms-conditions`, `fenster-partners`) now render `noindex,follow` and are excluded from the sitemap.
- Removed the temporary `/commercial-areas/` developer shortcut from the public header navigation.
- Added `/areas-we-cover/` to the footer company links and `/terms-conditions/` to the footer legal links.
- Verified rendered output locally: homepage title/meta/canonical correct, breadcrumb schema present on `casement-windows-toddington`, homepage no longer links to `/commercial-areas/`, noindex pages render noindex, sitemap excludes the utility debris and contains 427 URLs, cache headers are public on generated pages/sitemaps, and PHP lint passed for all changed PHP files.

## 2026-07-03 - Residential Location Metadata De-Duplication

- Reworked generated residential product/location metadata in `inc\generated-pages.php` so the 13 town x 21 product matrix no longer uses one duplicate meta-description template.
- Added town profile and product profile data for residential matrix SEO titles/descriptions, varying snippets by property context, local planning priority and product decision points.
- Verified all 273 residential matrix pages render unique meta descriptions, with zero duplicate meta groups and zero fetch errors.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Commercial County Coverage And Meta Tightening

- Removed `/commercial-glazing-isle-of-wight/` from the generated commercial county profile set because ferry/island access is not credible normal commercial coverage for Fenster.
- Added the removed Isle of Wight commercial route to the central 410 Gone list so it does not remain indexable or appear as an ambiguous missing page.
- Reworked commercial county title tags and meta descriptions so they use each profile's county, town examples and project context rather than one near-duplicate metadata template with only the county swapped.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Launch Blocker Fixes (Schema, Reference Assets, Sitemap, Debris Routes, Article Template)

- Captured the full 2026-07-03 master site audit and remediation status in `AUDIT.md`, keeping the audit/backlog separate from this chronological progress log.
- Fixed the structured-data bug where the shared bad-SEO-content check rejected every JSON-LD block (all valid JSON starts with `{`), so no schema ever rendered. Imported scrape schema is now intentionally dropped (it contained old designer-tool VideoObject markup, `test.fensterglazing.com` image URLs and unsubstantiated aggregateRating values) and replaced with generated schema: a site-wide `HomeAndConstructionBusiness` LocalBusiness block from brand data in `inc\generated-pages.php`, plus `FAQPage` JSON-LD on product journey pages built from the same FAQs rendered on the page.
- Removed the runtime dependency on the 2.4 GB `wp-content\fenster-reference` scrape export. Copied the 356 images actually referenced by templates and `data\pages.json` into `assets\images\imported`, rewrote all references (2,577 in `pages.json` plus eight PHP files), re-encoded the 2.9 MB PNG homepage hero poster to a 175 KB JPEG (`home-hero-poster.jpg`), and deleted the dead bifold scroll-video branch that referenced reference-folder media. The reference folder must not be deployed to production and is no longer needed at runtime.
- Fixed sitemap/robots plumbing: disabled core `wp-sitemap.xml` (it advertised a parallel incomplete URL set and a users sitemap), and the robots.txt filter now strips stale Sitemap lines and appends `home_url('/sitemap.xml')`. The custom sitemap index loc also uses `home_url()`.
- Added debris-route handling in `inc\generated-pages.php`: 410 Gone for test pages (`nick-test-baboon`, `our-new-website`, `case-studies/test`, `case-studies/template-new`); 301 redirects for duplicate town slugs (`dunstable-casement-windows`, `bow-and-bay-windows-northampton`, `tilt-and-turn-windows-northampton`), `commercial-glazing-london-2`, `healthcare_safeguarding_in_construction`, `enquire-now`, `instant-pricing` and all `*-designer` pages (to their base product, else `/online-quote/`); `noindex,follow` for the live ad landers (`pricing-gads`, `instant-pricing-meta-ads`, `ppc-landing-page-composite-doors`, `roof-lanterns-landing-page`) and all `category/`, `tag/`, `author/` and `blog/page/` archive shells. The custom sitemap skips gone/redirected/noindex slugs (486 down to 436 URLs).
- Replaced the slug-substring product heuristic in `template-parts\sections\generated-page.php` with explicit product/commercial route whitelists, so ~40 blog and guide articles no longer render the product journey with broken headings ("Why choose Are My Windows Energy-Efficient??").
- Added `template-parts\sections\generated-article.php`: a readable article layout (moderate hero, constrained article body with real scraped headings/paragraphs, inline images, compact shared enquiry form CTA, related links) plus `.fg-article-page` SCSS, hooked into the guardrail heading scale.
- Kept `/other-services/` on the simple layout via the utility list so it does not read as a fake product page.
- Verified via rendered checks: LocalBusiness schema on every page, FAQPage on product pages, robots.txt points at the custom sitemap, wp-sitemap 404s, all redirects/410s/noindex resolve correctly with 200 targets, articles render the new template, product/location/commercial/hub/utility pages unchanged, homepage internal links all 200, PHP lint and `npm.cmd run build` pass.

## 2026-07-03 - Sliding Sash Windows Roseview Model Page

- Reworked `/sliding-sash-windows/` with a dedicated Roseview comparison section for Ultimate Rose, Heritage Rose and Charisma Rose.
- Added curated Roseview export imagery under `assets\images\products\sash-roseview` so the page shows clear model and detail differences rather than relying only on generic product gallery images.
- Added customer-facing model guidance covering best-fit use cases, meeting rail sizes, corner construction, frame depth, glass unit depth, energy rating and ThermoVFlex routes without inventing unsupported Fenster specifications.
- Added sash-specific visual detail sections for meeting rails and mechanical/welded joints, using the existing `data-fg-depth` scroll-depth behaviour for desktop parallax and static mobile fallbacks.
- Replaced the generic window-handle treatment on `/sliding-sash-windows/` with Roseview-specific sash furniture: Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, extra Shark Fin/D Handle options and the Roseview under/over 700mm furniture-count rule.
- Replaced the inherited Liniar product-hub system badge on `/sliding-sash-windows/` with a Roseview system entry and local Roseview logo from the Roseview scrape. The first copied logo was white/invisible on the white badge, so the route now uses the visible local `assets\partners\roseview-logo-new.png` file and product hub system logos are routed through `fenster_generated_url()`.
- Styled the new sections inside the existing continuous page background model from `STYLE.md`, with responsive model cards, a horizontally scrollable mobile comparison table and no standalone forms.
- Verified in the rendered local page: Liniar is not visible on the sash page, the Roseview logo loads, all 10 sash furniture images load after lazy scroll, the furniture cards align on desktop, the new sash furniture section does not cause mobile overflow, PHP lint passes and `npm.cmd run build` passes.

## 2026-07-02 - Commercial County Landing Pages

- Removed `Commercial Buckinghamshire` from the Commercial header dropdown so SEO location pages are not exposed as normal commercial menu items.
- Added a temporary noindex `/commercial-areas/` developer review page and a header `Areas` shortcut listing all generated commercial county landing pages.
- Added generated commercial glazing landing pages for England's county set using `fenster_commercial_county_profiles()` in `inc\generated-pages.php`.
- Generalised `template-parts\sections\commercial-county.php` so every county page renders unique county-specific H1, meta description, town coverage, context copy, FAQs and planning notes.
- Moved the shared compact enquiry form into the county hero and added a clearly visible phone CTA for commercial enquiries.
- Included the commercial county pages in the generated sitemap while keeping `/commercial-areas/` out via `noindex`.
- Rebuilt compiled CSS/JS and verified 48 county pages render, all with unique H1/meta descriptions, one shared form and visible phone number.

## 2026-07-02 - Trust Page And Homepage Trust Link

- Added a hardcoded virtual `/why-trust-fenster/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Built `template-parts\sections\trust-page.php` with stronger buyer-facing trust content: verifiable public reviews, local showroom accountability, why Fenster was made, survey-led process, customer information handling, accreditations and contact routes.
- Revised the page again to use the real customer-facing trust story: started in 2018, 8 years trading, around 25 years combined glazing experience, transparent upfront pricing, honesty and highly trained fitters.
- Reduced the trust-page heading scale so the page header reads as a customer information page rather than an oversized marketing hero, and added a site-wide typography rule to `STYLE.md`/`AI.md` to stop future AI passes making normal page headers too large.
- Added an end-of-stylesheet normal-page H1 guardrail covering contact, simple utility, trust, team, about and areas pages so late page-specific overrides cannot accidentally push them back to oversized hero type.
- Reused the shared review showcase component and existing showroom/trust assets rather than duplicating review data.
- Added a small centred homepage trust-bar link beneath the four logo/review cards, plus a footer company link.
- Reworked the trust page again into a more image-led customer confidence page, using showroom/about imagery, three team portraits and curated product images across a hero collage, visual proof mosaic, team strip and product proof cards.
- Browser-checked `/why-trust-fenster/` at `1440 x 900`, `768 x 1024` and `390 x 844`: 18 trust-page images render in the DOM, the new visual/team/product sections are present, there is no horizontal overflow and no console errors.
- Direct URL checks passed for the new showroom, team and product image assets used on the trust page.
- Replaced the fussy trust-page hero collage and visual proof mosaic with a simpler competitor-style layout: one large hero image, two large image/content proof rows, and a named team strip linking to `/meet-the-team/`.
- Replaced Zac Bartley's Meet the Team portrait with the supplied black-and-white image and made Zac's team-page image load eagerly.
- Reworked the trust page again so the hero uses a 2x2 Google, Trustpilot, FENSA and CPA proof grid instead of a product photo, added a clear mission statement near the top, expanded showroom/survey/customer-choice copy, and changed the team strip to Nick Baker, Adam Butcher and Perry Giffin with job titles.
- Refined the trust page tone and layout: removed the extra practical-reasons block from the hero, gave the mission statement a soft translucent bordered panel, rewrote team/product copy in a calmer UK customer-facing tone, changed product cards back to normal dark text, and replaced the old care section with the product-page order process rail.
- Tightened the trust page follow-up: added showroom and product CTAs to the two feature sections, made team job roles visible as image labels, nudged Perry's portrait crop upward, and removed the separate Products and Choices section entirely.
- Polished the homepage/product/about/contact pass: changed the homepage pricing bridge to a live instant quote iframe with softer quote wording, removed the commercial-heavy Proof in the Work strip, changed product galleries from 4x4 to fixed 2x2 mosaics, auto-loaded product quote iframes, swapped the roof lantern page to better S1 lantern scrape imagery, changed the About hero to the showroom image, and put the instant quote screenshot behind the Contact quote CTA.

## 2026-07-01 - Contact Page Hub Refresh

- Reworked `/contact/` into a stronger first-screen contact hub with two oversized interactive route panels: `Instant quote` and `Consultation`.
- Kept direct phone, email and showroom routes visible beneath the primary panels, then preserved the showroom map, enquiry form, reviews and useful links below.
- Used the existing showroom image as a real visual asset and kept the page on the continuous site background from `STYLE.md`.
- Added final contact-hub SCSS overrides and rebuilt compiled CSS/JS with `npm.cmd run build`.
- PHP lint passed for the contact template.
- Browser-checked `1440 x 900`, `768 x 1024` and `390 x 844`: no horizontal overflow, no console errors, two hub cards render, instant quote links to `/online-quote/`, and consultation targets the showroom section.

## 2026-07-01 - Product Gallery Expansion

- Added a picture-heavy `Product gallery` section to product journeys, rendering a 16-image mosaic with SEO-supporting product copy beside it.
- Added product-family gallery groups and curated image pools in `inc\site-data.php` so pages fill the mosaic from verified scrape-derived assets rather than old scraped page galleries.
- Kept exact product images first, then filled the remaining grid with closely related images from the same product family.
- Styled the gallery as a 4-column desktop grid with a right-side copy panel, collapsing to a 2-column mobile image grid with the copy first.
- Rebuilt compiled CSS/JS with `npm.cmd run build`.
- Verified 25 rendered product/service pages have 16 curated gallery images, zero `/wp-content/fenster-reference/` images in the new gallery, and no New Wave wording on `/slide-fold-doors/`.
- Browser-checked desktop bifold gallery and mobile slide-and-fold gallery for column count, curated paths and horizontal overflow.

## 2026-07-01 - Product Image Curation Pass

- Added curated product media overrides in `inc\site-data.php` so product pages use verified theme assets instead of the old scraped Fenster gallery order.
- Copied 31 checked product images from Liniar, Sheerline, Distinction Doors, Notan, neutral slide-and-fold assets and visibly accurate Fenster-export service images into `assets\images\products\curated`.
- Updated `template-parts\sections\generated-page.php` so curated hero/gallery media replaces scraped hero-adjacent, `Why choose this product?` and feature-card images when available.
- Kept slide-and-fold imagery and alt text neutral, with no New Wave wording on the rendered page.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Spot-checked 25 rendered product/service pages: curated image URLs were present, old `/wp-content/fenster-reference/` image URLs were absent, and `/slide-fold-doors/` contained no New Wave text.

## 2026-07-01 - Product Copy Override Pass

- Added curated `product_content` intros, five benefit cards and five FAQs for all mapped residential product/service routes so product pages no longer depend on scraped section fragments for the `Why choose this product?` and FAQ areas.
- Rewrote previously broken product content including Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs, using existing Fenster product data plus manufacturer scrape facts from Liniar, Sheerline, New Wave, Distinction Doors and Notan.
- Kept specification claims aligned with existing `product_usps` data and avoided invented U-values, especially where Composite Doors and Integral Blinds do not have supplied U-values.
- Tightened generated-page filtering to reject obvious scraped designer/tool debris, one-word fragments, leading punctuation fragments and unfinished body copy before it can be used as generated fallback content.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Verified every mapped product route has a curated intro, five benefits and five FAQs, and spot-checked rendered local pages for Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs.

## 2026-07-01 - Colour Hub Carousel, Swatches And Form Scale

- Reworked the colour options hub so uPVC and aluminium colours are presented as sections on the same customer-facing hub rather than via confusing top tab/menu buttons.
- Replaced the uPVC colour carousel imagery with optimised swatch WebP assets from `images\colours_page_image`, stored under `assets\images\products\colours\liniar-swatches`.
- Kept the door-render colour assets under `assets\images\products\colours\liniar-door` for later door-page use rather than using them on the colour hub.
- Trimmed the uPVC visible colour list to the approved customer-facing set.
- Added `Smooth White` as a separate uPVC colour using the white swatch image and `No foil` detail.
- Renamed `7016 Grey` to `Anthracite Grey`, `7155 Grey` to `Silver Grey`, and `Gale Grey Finesse` to `Gale Grey Finesse (Anthracite Smooth)`.
- Implemented the colour swatch carousel as a coverflow-style browser with buttons, keyboard support and draggable scrub behaviour.
- Updated drag behaviour so dragging controls the coverflow animation state directly, can move across multiple colours, and snaps to the nearest colour on release.
- Tuned carousel drag sensitivity down after review so mobile browsing is less twitchy.
- Reworked the colour hub hero visual away from awkward overlapping cards into a simpler swatch sample board and fixed swatch image cropping by using complete contained images.
- Reduced shared enquiry/form section heading sizing so form intro headings no longer render at hero scale.
- Rebuilt compiled CSS/JS and browser-checked colour hub carousel, hero image behaviour and enquiry heading sizing.

## 2026-06-30 - Product Specification Hub And Colour Pages

- Removed the product-page mini-gallery that was rendering imported `images` data above the colour choices.
- Traced the unwanted stock imagery to old copied export entries in `data\pages.json`, including `stock-04.jpg` and `stock-05.jpg`, then tightened generated-image validation so obvious stock/placeholder filenames are rejected.
- Replaced the huge inline product colour block with compact `Specification choices` cards linking to colour options, Obscured glass and relevant hardware decisions.
- Added the circular interactive choice dial to the product-page `Specification choices` section, not the colour hub pages.
- Added hardcoded virtual colour routes:
  - `/colour-options/`
  - `/upvc-colours/`
  - `/aluminium-colours/`
- Added shared `colour_options` data in `inc\site-data.php` for uPVC and aluminium frame colours.
- Kept the colour pages as straightforward reference hubs without the spinning/orbit interaction.
- Cropped the supplied nine-handle image sheet into separate transparent PNG assets under `assets\images\products\door-handles`.
- Replaced the door-handle placeholder with a real door handle selector section using `door_handles` data in `inc\site-data.php`.
- Removed the separate gradient background from the product-page instant quote section so it sits on the continuous site background from `STYLE.md`.
- Updated `AI.md` and `HANDOVER.md` with the new product-template and colour-hub model.

## 2026-06-29 - Areas Page Customer-Facing Pass

- Removed the temporary `Areas` shortcut from the site header.
- Reworked `/areas-we-cover/` from a noindex developer review grid into a customer-facing local coverage page.
- Made the coverage page indexable and added it to the generated sitemap virtual route list.
- Added a small About-page CTA linking to `/areas-we-cover/`.
- Kept the generated town/service links grouped by location, but changed the page copy and presentation for customers rather than internal QA.

## 2026-06-29 - Contact Page Reworked Against Style Docs

- Rebuilt `/contact/` as a proper showroom-led contact experience, not a rearranged split hero/card stack.
- Pulled the design back into the quieter style used by the quote and team pages: light continuous canvas, moderate hero type, constrained panels and clean contact choices.
- Removed the broken experimental contact-method row layout that was forcing phone/email text into one-character columns.
- Added a dedicated showroom/map section and route rows for home projects, commercial work and instant pricing.
- Kept the page on one continuous `--fg-page-gradient` canvas, with transparent section wrappers and local contrast only on purposeful panels, map and form surfaces.
- Kept the shared enquiry form component as the only live customer form.
- Avoided the old Three.js/canvas direction entirely; the page uses real showroom imagery and standard HTML/CSS only.
- Rebuilt compiled assets, linted the contact template and verified screenshots at `1440 x 900`, `768 x 1024` and `390 x 844` with no horizontal overflow or console errors.

## 2026-06-29 - Documentation Truth Audit

- Audited the handover/rules/homepage/style docs against the current theme code.
- Clarified that Three.js is not active: there is no `three` dependency/import/enqueue, the compiled JS does not contain the old 3D controller, and remaining `fg-home-hero-3d` / `data-fg-home-3d` references are inactive legacy source/style hooks.
- Updated homepage language from the old product-story model to the current five-group product theatre.
- Added the current `/contact/` page model, shared review showcase behaviour, commercial virtual routes and product quote `Load tool` lazy-loading detail to the handover/rules docs.
- Reconfirmed `/wcad-thank-you/` stays removed and the generated matrix remains 13 towns x 21 residential products.

## 2026-06-29 - Styling Source Of Truth Added

- Added `STYLE.md` as the dedicated source of truth for site-wide visual styling, including the continuous page background rule.
- Promoted the rule that `--fg-page-gradient` should be painted once on the page canvas rather than repeated on every section or inner wrapper.
- Added guidance for section continuity, visual assets, cards, colour, typography, forms, mobile design and visual QA.
- Updated `AI.md`, `HANDOVER.md` and `HOMEPAGE.md` so future visual work is directed to read `STYLE.md` first.

## 2026-06-29 - Contact Page Visual Refresh

- Reworked the hardcoded `/contact/` page hero into a richer contact hub with the Milton Keynes showroom photo, overlay showroom details and quick proof facts.
- Expanded the action cards to cover call, email, showroom directions and instant pricing.
- Refined the map, route-choice and enquiry sections so the shared enquiry form remains the single live form while the page feels more polished and practical.
- Added responsive contact-page styling for desktop, tablet and phone layouts.
- Rebuilt compiled CSS/JS, linted the changed contact PHP template and verified `1440 x 900`, `768 x 1024` and `390 x 844` layouts with no horizontal overflow or console errors.

## 2026-06-26 - Obscured glass Visualiser Page

- Added a hardcoded virtual `/obscured-glass/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Kept the page out of the main navigation.
- Added a CTA to the generated product template's `Gallery and choices` / finish options card linking to `/obscured-glass/`.
- Added Obscured glass pattern data in `inc\site-data.php` under `obscure_glass`.
- Converted the supplied Pilkington texture PNGs into web-friendly theme WebP assets under `assets\images\products\obscure-glass`.
- Added the supplied colour Legend photo as `assets\team\legend-colour.webp` for the visualiser.
- Added the supplied house background as `assets\images\products\obscure-glass\birkacre-house.webp`.
- Reworked the visualiser from a light transparent overlay into a split comparison: obscured view on the left, clear reference on the right.
- Added a `Change background` control that cycles between Legend and the house scene.
- Matched the Pilkington visualiser layering more closely: a blurred/brightened duplicate scene sits beneath a separate texture pattern layer.
- Switched the default preview to Cotswold and pointed it at the downloaded Pilkington `Cotswold-pilkington.png` texture.
- Replaced the pointer-follow movement with a draggable comparison slider so the interaction matches the split-preview model.
- Added mobile/tablet layouts with tappable horizontal glass controls and no hover dependency.
- Rebuilt compiled CSS/JS and verified the route, product CTA, no menu link, responsive no-overflow checks and no console errors.

## 2026-06-26 - Utility Route Cleanup

- Added a hardcoded virtual `/terms-conditions/` utility page in `inc\generated-pages.php`.
- Added `/terms-conditions/` to the custom generated sitemap virtual route list.
- Marked `/terms-conditions/` as a generated utility page in `template-parts\sections\generated-page.php` so it uses the simple utility layout.
- Removed the stale `/wcad-thank-you/` imported page from `data\pages.json`.
- Added `wcad-thank-you` to the sitemap exclusion list so the deleted route is not reintroduced through sitemap output.
- Verified `/terms-conditions/` returns `200`, `/wcad-thank-you/` returns `404`, and `page-sitemap.xml` contains `terms-conditions` but not `wcad-thank-you`.
- Clarified the then-current `/areas-we-cover/` developer review model. This was superseded later on 2026-06-29 by the customer-facing coverage page.

## 2026-06-26 - Shared Curated Review Showcase

- Added a shared hardcoded curated review showcase component in `template-parts/components/review-showcase.php`.
- Stored review excerpts in `inc\site-data.php` under `customer_reviews` so the content can later be swapped for a cached API/plugin feed.
- Used short linked excerpts from public Google/Trustpilot review sources.
- Restored the small homepage trust bar under the hero and moved the larger review widget lower, after systems/backing and before the homepage enquiry form.
- Replaced duplicated review/trust sections in generated product pages, location pages, quote page, about page, team page, contact page and windows hub with the shared component.
- Reworked the review design into a simple white Google-style widget with centred `EXCELLENT` summary and four review cards; mobile uses a native horizontal rail.
- Added three more review entries and changed the shared widget into a seven-review carousel with previous/next buttons and reduced-motion-aware auto-advance.

## 2026-06-26 - Online Quote WindowCAD Embed

- Replaced the `/online-quote/` screenshot preview with the live default WindowCAD iframe.
- Passed the default WindowCAD URL into `template-parts/sections/quote-tool.php`.
- Added `Expand view` and `Open in new tab` actions to the quote page embed.
- Added `data-lenis-prevent` and fullscreen styling so the embedded tool remains usable with smooth scrolling enabled.

## 2026-06-26 - Product Page WindowCAD Quote Embeds

- Added compact product-specific WindowCAD iframe embeds to generated product pages with matching `productCollection` URLs.
- Retargeted product-page instant quote links to jump to the embedded quote panel when a product collection is available.
- Positioned the quote embed after the main product journey content so scroll-following product video sections are not affected by the iframe height.
- Added expand-view and new-tab controls for the embedded quote tool.
- Mapped the supplied collections across uPVC windows, sash windows, aluminium windows, composite doors, uPVC doors, French doors, patio doors, bifolds, aluminium sliding doors, heritage doors, aluminium doors, slide and fold doors, replacement glazed units and secondary glazing.
- Rebuilt compiled CSS/JS and verified the mapped local product routes render the embed with the expected collection IDs.

## 2026-06-25 - Window Handle Product Sections

- Added a detailed window handle section to the shared generated product-page template.
- The section appears on the main window product routes:
  - Aluminium Windows
  - Aluminium Flush Windows
  - Heritage Windows
  - Casement Windows
  - Flush Casement Windows
  - Sliding Sash Windows
- Tilt & Turn Windows is intentionally excluded.
- Added the supplied S2 Signature finish images to the theme assets for White, Black, Chrome, Gold and Titanium.
- Reworked the handle section into a compact finish selector with swatches, active handle image/copy, three feature tiles and one static technical specification card.
- Removed the handle accordion model, egress conversion copy, monkey-tail copy, spindle length row and retrofit-ready card.
- Added structured handle data in `inc\site-data.php`, including finish options, locking, material, corrosion testing and cycle testing.
- Rebuilt compiled CSS/JS and verified the target routes render the section while `/tilt-turn-windows/` does not.

## 2026-06-25 - Enquiry Form Steps Removed

- Removed the decorative three-step "what happens next" list from the generated product/page enquiry section.
- Removed the stepped/wizard markup from the shared enquiry form so all fields are visible at once.
- Kept the shared form component and AJAX submission flow intact.
- This supersedes the earlier 2026-06-24 stepped-form experiment. Some inactive stepped-form CSS/JS selectors may still exist, but the shared PHP component no longer renders the stepped data attributes or controls.
- PHP lint passed for:
  - `template-parts\components\enquiry-form.php`
  - `template-parts\sections\generated-page.php`

## 2026-06-25 - Product Content Audit And Cleanup

- Audited the main product routes against the generated product template.
- Added missing four-tile `product_usps` data for:
  - Sliding Sash Windows
  - French Doors
  - Roof Lanterns
  - Roofline
  - Double Glazing Replacement
  - Secondary Glazing
  - Window and Door Repairs
  - Cat and Dog Flaps
- Added `product_content` overrides for product pages where aliases or template fallbacks were surfacing incorrect visible copy:
  - Aluminium Bifold Doors
  - Aluminium Flush Windows
  - Aluminium Sliding Doors
  - Cat and Dog Flaps
- Updated the generated product template to skip scraped designer, brochure, FAQ-intro, footer, social and area-list debris before building product FAQs.
- Verified the main product set now has 4 USP tiles and 5 FAQs per route in the generated data audit.
- Re-audited all 43 menu-visible routes from the header, footer and homepage links against rendered local HTML.
- Added SEO-head filtering so imported social/schema data no longer renders old designer-tool schema, `test.fensterglazing.com` JSON-LD, placeholder OpenGraph values or raw JSON social tags.
- Verified the rendered menu-visible route audit had no missing pages, no visible old scrape debris and no flagged SEO/head artifacts.
- Updated the custom sitemap generator to exclude generated pages whose imported robots value contains `noindex`, removing `/door-designer/` from `page-sitemap.xml`.
- Added temporary noindex `/areas-we-cover/` review page, linked from the header CTA, listing generated area routes by location for manual checking.
- Normalised 110 existing product + location routes onto the shared `location-service.php` layout with a hero enquiry form, product-specific copy, location-specific copy and no old designer-tool scrape text.
- Replaced uneven scraped location coverage with a deliberate product/location matrix: 13 towns x 21 sensible residential products, 273 generated URLs total. Removed category, commercial/county and other nonsensical location one-offs from the temporary area review and custom sitemap.

This file is for dated progress reports and completed-change summaries.

Do not use this as the primary rulebook or handover. Use:

- `AI.md` for coding rules.
- `HANDOVER.md` for current whole-site context.
- `HOMEPAGE.md` for homepage-specific context.

## 2026-06-24 — Documentation Restructure

- Split the project documentation into clearer responsibilities:
  - `AI.md` now contains coding rules, QA rules and implementation standards.
  - `HANDOVER.md` now contains current whole-site context.
  - `HOMEPAGE.md` now contains homepage-only source-of-truth information.
  - `PROGRESS.md` now contains dated progress reports.
- Removed the mixed progress/history blocks from the main rule and handover docs.
- Added explicit instructions at the top of each doc explaining what belongs there.

## 2026-06-24 — Mobile Design Contract

- Added a standing mobile design and implementation contract.
- Standardised expectations around:
  - `860px` breakpoint,
  - `390 x 844`, `768 x 1024` and `1440 x 900` QA,
  - single-column mobile layouts,
  - `44px` tap targets,
  - `16px` form text,
  - carousel control ownership,
  - no horizontal overflow,
  - no distorted media.

## 2026-06-24 — Integral Blinds Reveal Reverted To Full-Hero Overlay

- Reverted the attempted “below hero only” reveal model.
- Current accepted behaviour:
  - desktop reveal covers the full viewport including the hero,
  - page is locked at the top,
  - scroll opens the blinds in reverse,
  - overlay fades away,
  - normal page scrolling resumes from the top.
- Removed the zero-height gate and clip-path model from runtime code.

## 2026-06-24 — Integral Blinds Controls Copy

- Updated Integral Blinds product USP data.
- `Controls` now reads `Magnetic or electric`.
- Change made in `inc\site-data.php`.

## 2026-06-23 — Integral Blinds Reverse Scroll Reveal

- Added supplied `internal blinds.mp4` as a desktop-only scroll-controlled reveal on `/integral-blinds/`.
- Created optimised web asset:
  - `assets\videos\product-scroll\integral-blinds-chroma.mp4`
- Implemented real-time canvas chroma key for green screen `#75F94D`.
- Reversed the blind-closing footage so scrolling opens the blinds.
- Added Lenis-style eased target/current progress to avoid harsh frame jumps.
- Tuned scroll travel to about `1.55` viewport heights.
- Reduced working chroma canvas to `720 x 405` for smoother performance.
- Disabled the effect on mobile and reduced-motion.

## 2026-06-23 — Site-Wide Form Consolidation

- Replaced scattered form shells with one shared form component:
  - `template-parts\components\enquiry-form.php`
- All live customer-facing forms now use the shared component.
- Removed tiny/standalone hero callback form.
- Commercial forms use the same component with commercial arguments.
- Added AJAX submission and in-place success states.
- Preserved no-JavaScript fallback.
- Added branded responsive HTML office email.
- Default/verified recipient: `info@fensterglazing.com`.
- Leads are saved as private `fenster_enquiry` posts before email delivery.

## 2026-06-23 — Related Products And Service Areas Cleanup

- Removed the old generic related-link system that mixed scraped links into every page.
- Eliminated unrelated links such as promotional/legal pages appearing in product panels.
- Related links now come from page context and are route-checked.
- Self-links, nonexistent URLs, external promo/legal links and pagination/file debris are excluded.

## 2026-06-23 — Mobile Product Hero Redesign

- Reworked compact product heroes on mobile.
- Product photo remains visible instead of being covered by oversized buttons.
- Eyebrow/H1 sit over a lower gradient on the image.
- Actions sit in a compact tray below the photo.
- Mobile button height set to `44px`.
- Reset inherited `.button-row` margin that caused an unwanted gap.

## 2026-06-23 — Product Plaque USP Data

- Replaced generic residential product guide strip with real four-tile `Key specifications`.
- Centralised product USP data in `inc\site-data.php`.
- Added/exposed missing product routes including:
  - `/aluminium-flush-windows/`
  - `/aluminium-sliding-doors/`
  - `/slide-fold-doors/`
  - `/heritage-aluminium-doors/`
- Added new/exposed routes to navigation and selector hubs.
- Verified mapped product routes rendered four USP tiles.

## 2026-06-23 — Aluminium Door Video Reassignment

- Moved aluminium door turntable video ownership from Composite Doors to Aluminium Doors.
- `/composite-doors/` now uses its product image.
- `/aluminium-doors/` owns the travelling/docking video feature.
- Mobile keeps the video docked in the primary media position and scrubs it by page scroll.

## 2026-06-23 — Mobile Header And Tablet Breakpoint Fix

- Fixed mobile/tablet issue where header appeared to disappear and homepage looked blank/distorted.
- Root cause was inconsistent breakpoints:
  - navigation switched at `860px`,
  - homepage mobile replacement previously switched lower.
- Standardised the homepage mobile replacement at `860px`.
- Made small-screen header fixed and composited.
- Hid desktop sticky product theatre at mobile/tablet widths.

## 2026-06-22 — Homepage Mobile Spacing Audit

- Established mobile section spacing by visible component joins instead of blanket section padding.
- Grouped carousel cards and dots in shared wrappers.
- Attached carousel dots visually to their carousels.
- Approved mobile joins:
  - product carousel to instant quote: `24px`,
  - proof carousel to systems/backing: `16px`,
  - systems/backing to contact: `32px`,
  - contact form to areas panel: `24px`,
  - areas panel to footer: `28px`.

## 2026-06-22 — Homepage Desktop Spacing Audit

- Audited homepage desktop spacing at normal viewport scale.
- Established desktop rhythm around meaningful content boundaries.
- Preserved deliberate product-theatre-to-quote overlap.
- Corrected product theatre layout to use capped image row and centred complete composition.
- Rejected stretching media to fill tall sticky stages.

## 2026-06-19 — Broad Site Rebuild Context

- Continued custom WordPress theme rebuild based on imported/generated data.
- Established code-driven approach rather than ACF/page-builder editing.
- Expanded generated-page templates, navigation, footer, homepage and product page systems.
- Preserved SEO coverage while replacing visibly broken or generic imported layouts.

## 2026-06-24 - Homepage Gradient Continuity

- Removed the duplicate `--fg-page-gradient` paint from the homepage product-flow wrapper so the page below the hero uses one continuous anchored background.
- Added mobile-only homepage gradient variables at `860px` and below to reduce green/blue intensity and increase the white wash.
- Verified `390 x 844`, `768 x 1024` and `1440 x 900` renders had no horizontal overflow or console errors.

## 2026-06-24 - Enquiry Form Steps

- Updated the shared enquiry form component to present four progressive steps with JavaScript active: project, contact, email/location and final details/privacy.
- Kept no-JavaScript behaviour as a complete normal form using the same shared fields and handler.
- Added step controls, progress text/bar and per-step validation before continuing.

## 2026-07-15 - Constructionline Gold Guidance

- Added a dedicated `/constructionline-gold/` page explaining Fenster's Constructionline Gold membership in plain language for commercial clients.
- Clearly distinguishes supplier pre-qualification from project-specific certification, warranties and Building Regulations paperwork.
- Linked the Constructionline Gold footer badge to the new page.

## 2026-07-15 - SSIP Health And Safety Guidance

- Added a dedicated `/ssip-health-and-safety/` page that explains SSIP health and safety assessment and mutual recognition without presenting it as a product warranty or project-specific approval.
- Linked the SSIP footer badge to the new page.

## 2026-07-15 - Accreditation Page Message Structure

- Standardised the FENSA, CPA, GGF, Constructionline Gold and SSIP pages around three customer questions: what it is, how it works with Fenster and what it means for the visitor or project.

## 2026-06-29 - Contact Page Compact Pass

- Tightened `/contact/` hero, contact dock and section padding to match the quieter quote/team page rhythm.
- Removed the hidden broken contact-methods block from the contact template instead of leaving it suppressed by CSS.
- Kept one continuous page gradient across the contact page.
- Hid the repeated showroom desk panel on mobile; phone, email and quote remain in the mobile contact dock, with full showroom details in the map section.
- Rebuilt compiled CSS/JS and verified `390 x 844`, `768 x 1024` and `1440 x 900` screenshots with no horizontal overflow or console errors.

## 2026-07-16 - Sliding Sash Product Journey And Footer Pass

- Rebuilt `/sliding-sash-windows/` around a shorter, visual purchase journey shared across mobile and desktop.
- Replaced the long mobile product stack with a viewport-contained three-model carousel and retained a three-column desktop comparison.
- Enlarged the Ultimate, Heritage and Charisma Rose product renders and added meeting-rail detail insets.
- Simplified the model comparison data and corrected the Charisma Rose thermal option.
- Added a six-image real-installation gallery using visually approved Roseview assets and responsive WebP sources.
- Added a post-gallery quote/consultation prompt and removed repeated generic product sections from this page.
- Replaced the old furniture catalogue with an interactive Globe/Acorn lock and finish selector derived from the Rose Collection furniture guide.
- Added the supplied Rose Collection furniture PDF as a downloadable page resource.
- Added sash-specific FAQs, a compact mobile quote action, a sash-specific enquiry form and a sash-installation review first in the review rail.
- Reworked the mobile footer trust bar into a consistent two-column grid.
- Added Fenster Instagram, Facebook and LinkedIn links to the footer.
- Rebuilt compiled CSS/JS and verified the protected test page at `390 x 844`, `768 x 1024` and `1440 x 900` with no horizontal overflow; verified selector state changes, social URLs, PDF/image delivery and responsive asset delivery.
- Test deployment only; no live-site deployment was performed.
- Follow-up: removed the customer-facing furniture PDF download, eagerly loaded the 69 KB furniture image set and fixed the responsive image-stage height so finish changes cannot cause mobile layout shift.
- Added `SASH-PAGE-REDESIGN.md` documenting the design strategy, implementation and reusable QA method.
- Follow-up: replaced the sash hero with a visually approved Roseview bay-window photograph and responsive 480/960/1920 WebP sources, with product-specific desktop/mobile crops.
- Removed the generic frame-colour panel from the sash page because the Roseview range differs; retained privacy glass and the dedicated furniture selector.
- Replaced the inaccurate `Colour choice / Full RAL range` hero specification tile with `Sash models / 3 Rose options`.

## 2026-07-27 - Casement Windows EnergyPlus Redesign

- Rebuilt `/casement-windows/` as a dedicated long-form 70mm Liniar EnergyPlus product journey while preserving the approved shared hero and four specification tiles exactly.
- Added detailed sections for opening layouts, room-by-room planning, six-chamber construction, whole-window thermal performance, weather sealing, glazing, security, visual proportions, colours, handles, sustainability, survey decisions, installation stages and related window styles.
- Added an explicit EnergyPlus versus Zero|90 comparison so Passivhaus, acoustic and 90mm product claims cannot be mistaken for the standard 70mm offer.
- Added five locally hosted, optimised manufacturer images from the approved Liniar scrape and kept Zero|90 imagery off the 70mm page.
- Added a keyboard-accessible opening-style selector, ten accordion FAQs with FAQ schema, the correct WindowCAD `productCollection=0` quote journey, review proof and a casement-specific shared enquiry form.
- Built and linted the theme, deployed revision `bfc3e11` to the Basic Auth protected test site, purged caches and verified the page at desktop and `390 x 844`.
- QA confirmed one H1, no horizontal overflow, no broken images after a full-page scan, correct tab keyboard behaviour, ten working FAQs, correct form routing and `200` responses for representative window, door, rooflight and contact routes.
- Trap worth knowing: a page wrapper with base `h2`/`p` rules must close before the shared quote, enquiry, review and FAQ partials. Those rules are `(0,1,1)` and beat the components' own styling, which put an ink-coloured heading on the dark enquiry panel and shrank the quote heading from 48px to 24px until the wrapper was closed early.
- Added the real-homes gallery feature from `/sliding-sash-windows/`: six Liniar casement installations in a desktop mosaic that becomes a scroll-snap rail under `860px`, wired to the existing global `[data-fg-gallery-lightbox]` handler so thumbnails open the shared dark lightbox with previous/next rather than a raw image URL. Responsive 480/800/1400 WebP variants, per-image focal points because the large mosaic cell is portrait and cover-crops a landscape source.
- Test deployment only. No live-site deployment was performed.
- Owner rejected the first card-heavy visual pass. Follow-up revision `b9d5388` replaced it with an image-led editorial design while retaining the researched EnergyPlus information.
- Removed the secondary sticky navigation, abstract CSS window diagrams and repeated boxed-card treatment.
- Reduced the visible journey to nine stronger chapters: introduction, real-image opening selector, EnergyPlus engineering, specification workspace, finishes, product clarity, survey, related styles and conversion/proof.
- Opening and specification controls now swap real product imagery and grouped information without creating a long series of equal-looking sections.
- Rechecked desktop and `390 x 844`: one H1, no horizontal overflow, no broken local images, keyboard-accessible tabs, correct WindowCAD collection `0`, working FAQ schema and unchanged shared hero.

## 2026-07-27 - Casement Windows Page Recomposed

- Rebuilt `/casement-windows/` after the owner rejected the previous pass as too wordy and unlike the reference pages.
- Composed on the `/heritage-aluminium-doors/` vocabulary: copy column one side, photography the other, two or three short paragraphs per section, divided detail lists, white uppercase caption chips, offset image pair on the construction section.
- Type back to the site scale. The superseded pass used `clamp(2.4rem, 5vw, var(--fg-font-size-max))` on every section H2 and 72px stat figures, above the 57.6px ceiling; H2 is now `clamp(1.5rem, 2.2vw, 1.95rem)`.
- Removed the full-width dark bands, the decorative background arcs, the second tab widget, the bare room-plan data table and the uniform `clamp(5rem, 9vw, 8.5rem)` section padding.
- Six body sections: intro, opening styles, inside the frame, glass/locking/hardware, colour, nearby styles. Then quote tool, enquiry, reviews and FAQs.
- **Zero|90 removed on owner instruction: Fenster supplies the 70mm EnergyPlus system only.** The comparison section, its FAQ and its CSS are gone. The caveat that Liniar's published 0.8 W/m²K is a best case stays in the construction section.
- Seven photographs, each used once, none repeating the page hero. Added `casement-bay-white-1080w.webp`. Dropped the duplicated handle crop and stopped a bifold-fronted elevation illustrating a casement layout.
- Real Liniar foil swatches replace flat CSS colour chips, cropped 3/2 from the top so the supplier foil reference does not show.
- Reuses the existing `data-fg-product-intel` tab controller instead of a second copy, and deleted 2,915 lines of superseded casement CSS that had been left in the stylesheet.
- Page height at 1440 went from 15,474px to 7,600px; sections from 1,183-1,664px to 364-779px, matching the heritage-door reference range.
- QA on the test site at `1440 x 900`, `768 x 1024` and `390 x 844`: one H1, no horizontal body overflow, nothing above 57.6px, no broken images, no console errors, tabs working by mouse and keyboard, correct WindowCAD collection and enquiry routing. The only elements extending past the viewport are inside the shared review scroll rail, as on the reference pages.
- Test deployment only. No live-site deployment was performed.

## 2026-07-27 - Named Technology Banners

- Added `template-parts/components/tech-banner.php`: partner mark, eyebrow, technology name, one plain sentence and up to four figures, following the existing `fg-composite-approved` partner-banner pattern.
- `fenster_tech_banner_args()` in `inc/product-hub-data.php` owns the route lists, so the rule lives in one place rather than being repeated per template.
- **Owner instruction, 2026-07-27: Thermlock on every aluminium product including roof lanterns but not slide and fold; EnergyPlus on every Liniar product except patio doors.**
- EnergyPlus routes: casement, flush casement, bow and bay, French casement, tilt and turn, uPVC doors, French doors.
- Thermlock routes: aluminium windows, aluminium flush windows, heritage windows, aluminium bifold doors, aluminium sliding doors, aluminium doors, heritage aluminium doors, roof lanterns.
- `generated-page.php` renders the banner after the key-specification strip. Roof lanterns and heritage aluminium doors return earlier from that template, so they call the component themselves.
- Roofline is a Liniar product but is deliberately excluded: EnergyPlus is a glazed-profile technology and fascia, soffit and guttering have no chambers and no glass. Flagged rather than assumed.
- The supplied Thermlock mark is pale grey (174,176,173) on transparency and disappeared on the white panel, which `STYLE.md` calls out. Added `sheerline-thermlock-ink.png`, the same monochrome wordmark at a legible tone.
- Verified on test: banner present on all fifteen intended routes and absent from patio doors, slide and fold, roofline, sliding sash and composite doors. No horizontal overflow, no oversized text, no broken images and no console errors at `1440 x 900` and `390 x 844` on the pages touched.
- Test deployment only. No live-site deployment was performed.

## 2026-07-27 - Casement Page: Repetition, Ending And Consistency Pass

- The top of the page said the same figures three times inside 1.5 viewports: the key-specification strip, the EnergyPlus banner stacked directly beneath it, and the intro bullets repeating both. The banner now renders from the casement template just before Inside the frame, so the mark names the technology and the section that follows explains it. `generated-page.php` keeps auto-placing the banner for the generic routes, whose templates have no construction section; the auto-render moved below the casement dispatch so it cannot double up.
- Intro bullets replaced with facts nothing else on the page says: layout combinations, sixteen colours inside and out, own installers with the ten year guarantee.
- Ending reordered from quote, enquiry, reviews, FAQ to quote, FAQ, enquiry, reviews: answers before the form, and the page closes on proof like the heritage page, not on an accordion.
- The colour section head referenced `fg-cw-head`, a class that no longer existed after the second rebuild, so it stacked single-column with the right half empty. Defined the shared two-column head and it now matches the gallery and styles heads.
- Related cards get hand-written `View ...` labels instead of a bare floating arrow (and French keeps its capital, which `strtolower` had eaten).
- Tech banner mobile facts switched from stepped flex wrapping (wrapped items kept their left border and indented) to a plain grid.
- QA on test at `1440 x 900`, `768 x 1024` and `390 x 844`: no body overflow, one H1, nothing above 57.6px, no broken images, no console errors. Banner confirmed still present once on the generic Liniar and Sheerline routes.
- Test deployment only. No live-site deployment was performed.

## 2026-07-27 - Casement Opening Styles: Factual Rewrite On Fenster Photography

- Owner feedback: the section explained things everyone knows and needed to be factual and image-based, sourced from the old Fenster site rather than Liniar.
- The old-site export lives in the theme at `assets/images/imported/`, including a full Flitwick casement job. Converted four of those photographs to WebP: a friction stay on an open sash, a top rail hinge, an anthracite fixed pane and a real three-light in a stone wall.
- Card copy replaced with checkable facts: egress hinges swinging to 90 degrees against the Building Regulations escape minimum of 0.33m² and at least 450mm each way; top-hung sashes shedding rain clear of the opening; a fixed pane costing less than an opener the same size; transoms and mullions deciding sightlines.
- The "Works well in" truism chips became one hard fact per card (escape minimum, restrictors to around 100mm, glass area, elevation drawing).
- Comparison table rows are now hardware facts (hinges, handle position, escape, cleaning route, rain behaviour) instead of restating what the names mean. The honest limitation stays in: top-hung is usually cleaned from outside.
- Survey note carries the regulation detail: escape openings, safety glass below 800mm, and trickle vents required on most replacement windows since June 2022.
- Card eyebrows kept to one line so the fact chips align; the side-hung eyebrow wrapping was pushing its chip a line lower than the rest.
- QA on test at `1440 x 900`, `768 x 1024` and `390 x 844`: no body overflow, one H1, nothing above 57.6px, no broken images, no console errors.
- Test deployment only. No live-site deployment was performed.

## 2026-07-28 - Casement Page: The Audit Build

- Implemented the full audit of `/casement-windows/` against the four reference pages. Every addition uses assets that already existed in the theme unused.
- **Local proof.** Case-study strip before the enquiry with the three real casement jobs (Broughton, Bolbeck Park, Leighton Buzzard) via the shared `fenster_case_studies_for_product` + card component. The Real homes mosaic now leads with our own installs: Bolbeck Park in the large cell, Leighton Buzzard in a landscape cell, captioned with the towns, and the head says which images are ours and which are Liniar photography.
- **Construction explorer.** Inside the frame is now the composite-style open-one-part explorer on the EnergyPlus cutaway (chambers, co-extruded gasket, reinforcement, sealed unit, installation), first item open in the markup, driven by the existing `data-fg-anatomy` controller. No new JavaScript.
- **Anchor band** beneath it: 10 year insurance-backed installation guarantee, PAS 24, and a price cell.
- **Glass and handles section.** Six Pilkington obscure patterns with their one-to-five privacy ratings, and the S2 Signature handle in its five finishes, both from image sets already in the theme.
- **Colour.** Swatches carry RAL codes read off the Renolit foil cards (9010, 9001, 7038, 7016, 7015, 8001; Chartwell Green and Rosewood have no RAL on the card so show none), plus the Broughton two-tone feature: basalt grey RAL 7012 outside, white inside, photo of the actual dormer, linking to the case study.
- **Two amber dashed placeholders await owner facts and are a deliberate block on any live deploy of this page:** a real recent casement job price (anchor band) and which foils most casement orders actually come in (colour section). Styled unmistakably as placeholders so they cannot pass a review as finished copy.
- Rebased over `fb02ac7` (sitewide free-consultation copy change) which touched the same files; both intents verified present after the rebase.
- QA on test at `1440 x 900`, `768 x 1024` and `390 x 844`: no body overflow, one H1, nothing above 57.6px, no broken images, no console errors. Probed directly: all six patterns, five handles and the duo photo load; the anatomy accordion opens one item at a time; the strip renders exactly the three casement studies.
- Test deployment only. No live-site deployment was performed, and must not be until both placeholders are resolved.

## 2026-07-28 - Casement Page: Price And Colour Section Removed

- Owner instruction: remove the price estimate and the colour section; it did not read like the other pages, and a wall of small tiles said nothing the photographs were not already saying.
- The `fg-cw-finish` section is gone entirely: swatch grid, RAL codes, the Broughton two-tone feature and the awaiting-foils placeholder, plus all their CSS. The price placeholder cell left the anchor band, now guarantee and PAS 24 only.
- Colour keeps one route: a `See all sixteen colours` link in the glass-and-handles row, and the sixteen-colours intro fact.
- **Both placeholders are gone, so the earlier block on deploying this page live is lifted.**
- Rebased over five consultation-page commits from the parallel session; only the compiled `main.css` conflicted and was regenerated from the merged SCSS.
- QA on test at `1440 x 900` and `390 x 844`: fourteen sections in order, no body overflow, one H1, nothing above 57.6px, no broken images, no console errors.
- Test deployment only. No live-site deployment was performed.

## 2026-07-28 - Casement Page: One Grammar

- The owner's structure critique stood after the colour removal because it was about the whole page. Counted honestly, the body held nearly thirty small bordered components across six different layout grammars; the heritage reference page is one repeated grammar, a big real photograph with copy beside it.
- Opening styles: cards, fact chips, five-row comparison table and survey note box became one split section, the real Leighton Buzzard window photograph beside a divided list of the four layouts, each keeping its regulation or hardware fact.
- New details section in the heritage period-details shape: friction stay and top rail hinge photographs as a pair, easy-clean and gasket facts as copy.
- The glass-and-handles tile section, the related-cards section and the anatomy stat band are gone. Their facts already lived elsewhere (survey list, intro facts, spec strip); the survey section regains the three option links.
- Body now runs: intro, layouts, details, real homes, CTA, EnergyPlus banner, construction explorer, survey, quote, FAQ, case studies, enquiry, reviews. Every section is the split-with-photograph grammar or an approved shared pattern. 9,873px at 1440, down from 11,554px at the audit build's peak.
- All CSS for deleted components removed with the markup; nothing left dead.
- QA on test at `1440 x 900`, `768 x 1024` and `390 x 844`: no body overflow, one H1, nothing above 57.6px, no broken images, no console errors.
- Test deployment only. No live-site deployment was performed.
- Follow-up: the one-grammar CSS cleanup had swallowed the construction explorer styles (a deletion cut spanned the region the audit build had inserted them into), so the explorer shipped unstyled and the owner caught it. Styles restored, and QA now includes a template-classes-versus-compiled-CSS diff so a section cannot ship unstyled again.

## 2026-07-31 - Consent-Safe Tracking Repair

- Rebuilt website attribution around a 90-day opaque visitor and a journey that rotates after 30 minutes of inactivity. A returning campaign starts a new journey rather than overwriting the earlier first touch.
- Fixed the consent race at enquiry submission: journey, visitor, analytics, marketing, click-ID and WindowCAD tracker fields are refreshed immediately before the form request.
- Marketing click IDs and the WindowCAD `ads` value are now strictly marketing-consent-only. Marketing-only visitors use an `FGA-…` attribution reference without creating an analytics visitor or dashboard journey.
- The WindowCAD iframe cannot load before a cookie choice. A deliberate load/expand records `quote_opened`; automatic `quote_iframe_loaded` remains exposure only and cannot inflate quote starts.
- Browser events have stable IDs, retry without PII and deduplicate in the dashboard. Server form/WindowCAD events and aggregate receipt IDs are deterministic, eliminating the browser/server form double count and making reconciliation safe to repeat.
- Test and production dashboard traffic is separated from the real request origin. Production reporting excludes test and legacy rows; unsigned server relays and unsigned completed-lead events are rejected.
- Added granular consent health, office outcomes (`qualified`, `appointment`, `won`, `lost`), actual won values, direct consented Google conversions for enquiry/consultation/phone, standard Meta browser events, optional Meta CAPI, and a protected Google offline feed using click IDs or SHA-256 contact matches.
- Hardened the public WindowCAD endpoint with payload limits, required contact fields, rate limiting and exact-payload deduplication. Shared-secret enforcement is implemented but remains off until the external WindowCAD webhook can be updated with the matching credential.
- Protected-test QA passed accept-all, necessary-only and marketing-only journeys. The deployed theme is commit `289b2c2`; the pre-release live archive is `~/backups/fenster-theme/fenster-pre-289b2c2-20260731-102149.tar.gz`.
- Marketing Dashboard migration `0017_tracking_integrity.sql` and commit `05e7481` were deployed. A 90-day WordPress reconciliation found 71 saved leads: 18 identified and 53 aggregate-only. Running it twice left counts unchanged at 18 and 53.
- Account-side items still require authenticated access: create/store the Google quote-open label if wanted as Secondary, create/map the `Qualified lead` and `Won lead` offline actions, configure a Meta CAPI token, enable the WindowCAD shared secret at both ends, and connect Focus Group call outcomes when an authorised feed exists.

## 2026-07-30 - Google Ads Launch And WindowCAD Conversion Import

- Enabled the three approved search campaigns: `MK — Windows` (£12/day), `MK — Doors` (£12/day) and `MK — Price Intent` (£9/day).
- Added the missing responsive search ad to the `Double Glazing MK` ad group with 15 headlines, four descriptions, the dedicated Milton Keynes landing page, inherited sitelinks and the approved image set.
- Added a private, token-protected HTTPS CSV feed for completed WindowCAD quotes. It exports only consented Google click identifiers, completion time, a stable non-PII transaction ID, £25 value and GBP currency.
- Connected the feed to the Primary `Instant quote submitted` conversion action in Google Ads Data Manager. It runs daily, filters `record_type = conversion`, and excludes the schema-only row used to establish the connection before the first real ad-attributed quote exists.
- Verified live: unauthorised feed requests return 401, the tokenized feed returns CSV with `no-store` and `noindex`, and the existing homepage, quote, product and Milton Keynes routes remain healthy.

