# The Fenster Atrium — `/fenster-new-home-page/`

**Local experiment. Not for test, not for live.** Read this before touching
anything under `src/experimental/`, `assets/experimental/`,
`inc/experimental-home.php` or `template-parts/sections/experimental-home.php`.

A scroll-driven 3D hero built on the real product geometry that comes out of
WindowCAD. It is a sandbox for how far a Fenster page can be pushed, sitting
beside the real homepage rather than replacing it.

---

## 1. What it is

An impossible Fenster showroom: a bright architectural gallery with the mark
suspended in it, the real product range installed along its length, and the
configurator the business quotes from waiting at the far end. Scrolling moves
the camera through it in one continuous shot.

Every product is genuine exported scene geometry from the configurator the
business quotes with. Seven of the models carry a baked `open-close` clip and
scroll **scrubs** it, so scrolling physically opens the product rather than
playing a video of one opening.

## 2. The two passes, and what changed between them

**Pass one** proved the engineering: real geometry, scrubbed animation, an
extruded logo, a live iframe projected into the scene, adaptive rendering, QA
tooling. It rendered in a dark room and carried a fixed column of headline and
body copy down the left of every shot.

**Pass two** is the art direction, and it changed three things fundamentally.

### The copy column is gone

`.fx__phases` — four stacked panels of eyebrow, headline, lede, spec chips and
buttons, crossfaded by scroll — has been deleted. It worked, and it was the
single thing making the page read as a hero banner with a 3D background rather
than as a place.

All of that information is now **geometry**: callouts with hairline leaders
pointing at the part they describe, type lying on the floor, numbered steps
standing in the room. See `lib/annotations.js`. What is left in HTML is the
accessible document underneath the canvas and two links.

### There is an actual building

`lib/architecture.js`. A floor that recedes with a scored grid, side walls with
vertical fins, a portal the casement is installed in, a material bay for the
door, and a pricing chamber. Pass one's own post-mortem identified "the products
exist in a dark void" as the largest remaining gap; this is that gap closed.

### It is a light room, not a dark one

This reversed twice and the reasoning is worth keeping.

Pass one, and the first two thirds of pass two, were a dark architectural
studio. That fought the product range the entire way: almost everything Fenster
sells is specified in **anthracite**, and a dark frame in a dark room is a
silhouette. Every fix was compensation — rim lights, follow keys, a lit backdrop
behind the glazing, and hero finishes lifted to a mid grey that is not a colour
Fenster actually sells.

A white-box gallery removes the problem at source rather than compensating for
it. Anthracite against a pale ground separates on its own, every bevel and
profile change reads as a real change in tone, and the frames are now the
**actual finish**. It is also how premium window and door photography is
genuinely shot: the frame is the dark shape and the room is the light one.

The lighting vocabulary inverts with it. In a dark room you draw with light —
seams, strips, glowing edges. In a light room you draw with **shadow**: the
recessed gap, the reveal, the dark line where two planes meet. Nearly every
`seam()` in `architecture.js` is a dark line now, and contact shadows stopped
being a nicety and became the main thing anchoring an object.

The one exception is the **pricing chamber**, which is deliberately the single
dark volume in the building. The terminal cannot be the brightest thing in frame
in a bright room, so the camera travels out of the gallery, through a doorway,
into a dark room where the screen is the only lit object. That is also the only
background an interface is comfortable to read against.

## 3. What was touched, and what was not

The real homepage is **untouched**. It still renders through
`fenster_get_generated_page('home')` and `home-experience.php` and shares no
code path with this. Verified: the homepage serves zero atrium assets.

Exactly **four** existing files differ from `main`, the same four as pass one:

| File | Change |
|---|---|
| `functions.php` | one `require` line for `inc/experimental-home.php` |
| `package.json` | `three` dependency, `build:atrium` / `watch:atrium` / `trace:logo` scripts |
| `package-lock.json` | consequence of the above |
| `HANDOVER.md` | one pointer block |

Everything else is new. To remove the experiment entirely: delete the require
line, the two `experimental` folders, the two PHP files, and the three scripts.

### New files

```
inc/experimental-home.php                       route, assets, data helpers
template-parts/sections/experimental-home.php   markup + the spec data
src/experimental/atrium.js                      setup, choreography, render loop
src/experimental/atrium.scss                    page styling + page chrome
src/experimental/lib/materials.js               GLB material classification, glass, light sweep
src/experimental/lib/mark.js                    the extruded logo
src/experimental/lib/products.js                model loading and the orbit
src/experimental/lib/architecture.js            PASS TWO. floor, shell, portal, bay, chamber
src/experimental/lib/lighting.js                PASS TWO. the softbox rig and per-shot moods
src/experimental/lib/annotations.js             PASS TWO. callouts, floor type, swing arc, steps
src/experimental/lib/atmosphere.js              dust, ground, backdrop, light wall
src/experimental/lib/studio.js                  the generated environment map
src/experimental/lib/typography.js              monumental world type and dimension lines
src/experimental/lib/terminal.js                the WindowCAD terminal
src/experimental/lib/post.js                    depth of field, bloom, the grade
assets/experimental/atrium.{js,css}             build output (committed, like the theme's own)
assets/experimental/fenster-mark.svg            traced from the brand mark
assets/experimental/models/*.glb                13 products + manifest
scripts/trace-logo.mjs                          PNG mark -> SVG paths
scripts/shot.mjs                                CDP screenshot / probe harness
scripts/contact-sheet.mjs                       whole-timeline contact sheet + exposure metrics
```

## 4. It cannot reach production

`fenster_experimental_home_enabled()` is an **allow-list** on the request host:
`localhost`, `*.local`, `*.test`, `127.0.0.1`. Anything else falls through to a
normal 404 — verified by sending a `Host: fensterglazing.com` header. `AI.md`
records the composite-doors incident — a route with no host gate shipping to
production with the theme — and this is that lesson applied. The page is also
`noindex, nofollow`, sends no-cache headers, and is absent from the sitemap.

The models are **WindowSoftware's IP** (see `3d.md` §11). Local only.

## 5. Build

```bash
npm run build:atrium     # both
npm run watch:atrium     # both, watching
npm run trace:logo       # regenerate the mark SVG from assets/brand/favicon-512.png
```

The atrium build is separate from `npm run build`, so the site's own
`main.css` / `main.js` never grow by a byte because of this.

## 6. The models

`assets/experimental/models/manifest.json` is the record. Copied from
`C:\Users\zacpl\Desktop\windowcad-spins\models\` — **originals untouched.**

- **13 files, all 13 verified distinct by MD5.** Nothing here shows one product
  twice under two names.
- **Size is not a variable on this page.** `3d.md` records that only bifolds
  genuinely vary by size in the current export set, so offering size options
  would be describing a range that does not exist.
- **Colour is real and is changed at runtime.** These GLBs carry no textures at
  all — a finish is a `baseColorFactor` plus metalness/roughness. That is why
  the composite door changes finish as the light crosses it, and why doing so
  costs nothing. Every product now gets a real Fenster finish applied, not just
  the three heroes: the exports come out in white uPVC, and white uPVC against
  a white gallery wall is invisible.
- Seven carry an `open-close` clip, five seconds, shut → open → shut. Only the
  **first half** is ever used.

### Material classification

There are no node names and no material names in these files, so materials are
classified by what they are, per `3d.md`:

- translucent (`alphaMode BLEND` / opacity < 1) → **glass**
- opaque and neutral (r≈g≈b) → **frame**, or **hardware** if the export gave it
  a high metalness

## 7. The timeline

One function, `applyChoreography(t, dt)`, poses the entire world. The camera
runs on a **keyframe track** (`CAMERA_TRACK`, twenty-six poses) sampled with a
cardinal spline, and everything with mass follows on a critically damped spring.

### The plan

The route is a straight line down the spine of the building at **x = 0**, and
the camera only ever moves forward. It does not swing out to one product and
across to the other; the splayed walls bring both products to it. That is the
shot a dolly down the axis of a gallery actually gives you, it makes the two
products read as a *pair* rather than as a sequence, and it is the only path
that cannot clip anything — the gap between the leaves is the route, so a point
travelling down the centre of a 2.6m gap keeps 1.3m of clearance on both sides
at all times.

| z | What stands there |
|---|---|
| 0 | The mark, and the glass hall dressing the opening frames |
| −14 | **Station 1** — uPVC casement · sliding sash |
| −32 | **Station 2** — aluminium casement · uPVC flush sash |
| −46 | **The screen** — the bifold, glazed across the whole route |
| −60 | **Station 3** — composite door · heritage aluminium door |
| −78 | **Station 4** — aluminium slider · uPVC slider |
| −85 | The chamber mouth |
| −96 | The pricing terminal, inside the chamber |
| −118 | The far vista |

Every station needs about **eighteen metres** of run: the grammar asks for a
hold 8.5m in front of the product plane, with an approach behind that. v1 → v2
is 18m and v3 → v4 is 18m. See the trap in §8 about what happened when the
screen was wedged into a 10m gap.

### The beats

Each station contributes the same four poses, because hand-authoring this many
keyframes produces a wall of numbers nobody will re-time:

- **IN** — as far back as the room allows, the whole station reading small
- **HOLD** — both products *and* both blocks of specification inside one frame
- **PUSH** — nearer, on the same line, so the beat has somewhere to go
- **OUT** — through the gap, already looking at the next station

| t | Beat |
|---|---|
| 0.00–0.08 | The mark, held, then a straight push in — the mark does all the turning. |
| 0.10–0.30 | **Station 1.** Casement and sliding sash. Hold at 0.186, push at 0.246. |
| 0.34–0.51 | **Station 2.** Aluminium casement and uPVC flush sash. Hold at 0.404. |
| 0.54–0.62 | **The screen.** Approached shut; folds open at 0.568–0.586; through it at 0.618. |
| 0.64–0.84 | **Station 3.** Composite and heritage doors, with the runtime finish cycle. |
| 0.86–0.95 | **Station 4.** Aluminium and uPVC sliders. |
| 0.95–0.99 | Through the chamber doorway. The lighting mood crosses on the threshold. |
| 0.97–1.00 | The terminal square on, the room calm, the live iframe takes over. |

At each station one of the pair opens on its baked clip and the other stays
shut, which is how a showroom displays two of the same thing — and it means the
section and the closed face are visible at the same time.

The bifold is **installed, not performed**. It stands in a screen across the
route and folds open to let the visitor through, which is the one reason a
bifold exists. Its specification peaks at `read` (0.568), about two-thirds
folded, while there is still door in the opening — peaking it at `open` put both
blocks at full opacity over an empty doorway with nothing left to annotate.

Past `t = 1` the fixed stage fades and the page hands back to an ordinary
document — the product index and the site footer.

### One gesture, one section

The timeline is not scrubbed by scroll position at all. There are **seven
stops** — the mark, four stations, the bifold, and WindowCAD open — and one
push of the wheel travels to the next one and holds there until the next push.

```js
const STOPS = [
  0,                    // the mark
  V_STATIONS[0].hold,   // casement + sliding sash
  V_STATIONS[1].hold,   // aluminium + flush sash
  BIFOLD_BEAT.open,     // the screen, folded open
  V_STATIONS[2].hold,   // composite + heritage doors
  V_STATIONS[3].hold,   // the two sliders
  1,                    // WindowCAD, open and interactive
];
```

Derived from the beat table rather than written out, so a station that moves
takes its stop with it.

This replaced four mechanisms whose combined job was to make a scrubbed
timeline feel paced: a Lenis instance smoothing the scroll, a dwell warp
bending scroll into timeline, a second smoothing pass on `t`, and a 3200vh
runway. A stepped timeline is paced by construction.

**What "one gesture" means** is the whole difficulty, because a wheel does not
emit gestures — it emits a burst of deltas. A trackpad flick can fire fifty
events over a second and a half of inertia; a notched mouse wheel fires one big
one. So deltas accumulate rather than each one counting, crossing the threshold
fires exactly one step, and after firing everything is swallowed until the
input has been quiet for 420ms. Verified: one synthetic wheel event advances
one stop, and thirty inertia events immediately afterwards advance none.

**Leaving.** Arriving at the last stop hands scrolling back to the document.
That is a fix, not a shortcut — WindowCAD is a real cross-origin iframe
covering the middle of the screen, and *a wheel over a cross-origin iframe
never reaches a listener on this document*. If the stepper still owned the
wheel there, the one gesture needed to move on would do nothing for anyone
whose cursor was over the configurator, which is exactly where it will be.

It goes **passive**, not disabled: the document gets the wheel, but a push back
*up* while still at the top steps into the previous stop. Disabled would leave
the visitor at the final stop with no way back.

**The runway is 100vh**, down from 3200vh. Scroll position no longer means
anything to the choreography; what is left is a one-screen spacer that gives
the section height and lets the document scroll up over the fixed stage.

`__fensterSeek(t)` still takes a **beat** and works unchanged, which is what
keeps every constant in the QA harness meaning what it says. It calls
`stepper.adopt(t)` so the next frame does not tween back to whatever stop the
stepper thought it was on.

### The camera is rigid

"A straight line and no tilt" turned out to be four separate things in the
source, and only one of them was called roll:

| Source | Was | Now |
|---|---|---|
| `camera.lookAt()` pitch | 12.43° of swing | 0° |
| authored roll on the mark keys | 0.34° | 0° |
| pointer parallax yaw / pitch | 2.41° / 1.49° | removed |
| pointer parallax lateral / vertical offset | 0.22m / 0.13m | removed |
| camera height along the track | 0.42m of rise and fall | one value, −1.05 |
| fov | 34 → 44 → 36 | one value, 38 |

The largest of those has no name in the source at all. `camera.lookAt(target)`
tilts the camera whenever the target's y differs from the camera's, so a grep
for `tilt` or `roll` finds everything except the thing doing most of the
tilting. It is settled in one place now — a loop at the end of
`buildCameraTrack` that forces `k.l[1] = k.p[1] = CAM_Y`, `k.fov = 38`,
`k.roll = 0` on every key — rather than left to whoever authors the next pose.

`CAM_Y = −1.05` is a compromise and worth being honest about: a window centres
at −0.72 and a door at −1.43, because a door goes to the floor and a window
stands on a cill. No single level height centres both. Halfway puts each about
0.36m off centre, which is 0.13 of NDC at the hold distance — windows sit
slightly high in frame, doors slightly low, by equal amounts. The alternative
is reintroducing the pitch that was asked to go.

**The timeline is fully reversible.** Verified by seeking a set of positions
forward, then backward, and diffing every visible pose: zero differences.

**The camera never reverses and never leaves the centre line.** Verified by
sampling 501 positions across the timeline: worst backward step 0.000m, maximum
|x| 0.000m.

## 8. Twenty-three traps, all of which fail silently

These cost real debugging time and every one of them looks like something else.

### `RectAreaLight` emits nothing without `RectAreaLightUniformsLib.init()`

Pass one created two travelling strip lights and never called it. They
contributed **exactly nothing** for the entire sequence — no error, no warning,
just a rig quietly missing its two most important sources. This is why "there
should be moments where highlights travel across the surface" never happened.

### `BokehPass` does not render colour

It renders the scene only to get a depth buffer; its colour input is
`readBuffer`. Used as the first pass — as a drop-in replacement for `RenderPass`
— it reads an empty target and outputs **black, the whole frame**. The only
symptom was `renderer.info.render.triangles === 1`, that one triangle being the
final fullscreen quad. It is a filter that sits *after* a `RenderPass`.

### The product pivot is scaled by 0.001135

The GLBs are in millimetres. Anything added as a child of `product.pivot`
inherits that scale, so a callout offset of 1.6 units — intended as 1.6 metres —
lands **1.8 millimetres** from its anchor, and a 0.6-unit block of type renders
0.7mm wide. Every annotation collapsed to an invisible speck at the product's
origin. It probes as visible, at full opacity, in frame.

**Anything spatial hangs off the unscaled holder** (`heroWindow` / `heroDoor` /
`heroBifold`), never off the pivot. Pass one's dimension lines had this bug too
and were never once visible.

### Depth testing eats anything inside a wall

The casement is installed in a portal 1.1 metres thick, so its centre plane is
buried in masonry. Callouts hanging off it at a few centimetres of z offset were
inside the piers and were depth-tested away. Same probe result as above: visible,
full opacity, in frame, renders as nothing. Annotations sit at `FRONT = 1.15`,
clear of the wall's near face.

### Scenery in front of the camera

The material bay's backdrop wall is 4.6m behind the door, which puts it 1.5m in
*front* of the camera by the end of the sequence — occluding the terminal at the
exact moment it arrives. It is a wall with a doorway in it now, and the camera
travels through.

### The baked animations never ran, in either pass

**This is the worst one, and it survived two whole passes.**

`setOpen()` scrubbed the clip with `mixer.setTime(x)`. That method zeroes
`action.time` on every action and then calls `update(x)`, expecting the delta to
carry each action forward. A **paused** action has `_updateTimeScale()` return
zero, so its delta is multiplied to nothing and its time stays at the zero
`setTime` just wrote. The action here is paused deliberately — that is what
stops the clip playing itself on a wall clock — so the combination is silently
inert. `mixer.time` advanced to exactly the right value. Every call looked
correct from outside. `action.time` never left 0.

Net effect: **none of the seven baked open/close clips had ever run.** No sash
ever opened. The composite door never swung, so it never revealed the terminal
through its own doorway. The bifold "concertina" that the entire windows-to-doors
transition is built on was a closed slab sliding across the frame. The page's
central claim — that scroll scrubs real WindowCAD hinge geometry — was not true
until one line changed.

The scrub that works is to write `action.time` directly and tick a zero-length
frame: `mixer.update(0)` still evaluates and applies every action's bindings at
its current time, paused or not.

It was found by measuring the world position of a named animated node at
`setOpen(0)` versus `setOpen(1)` and getting zero. Do that, not a read of
`mixer.time`, if you ever touch this again — and probe a node the clip actually
targets. A first attempt measured the deepest mesh in the tree, which is a
static part, and reported zero travel even after the fix.

### `project()` uses a stale camera matrix straight after a seek

`camera.lookAt()` sets the camera's quaternion. It does **not** update
`matrixWorld`, and `Vector3.project()` reads `matrixWorldInverse`. The renderer
is what normally refreshes those — so any probe that seeks the timeline and
immediately projects a world position is measuring against the camera pose from
the *previous* frame.

This produced a full round of chasing a bug that did not exist: the travelling
mark measured at ndc x = -3.25 and 2.43 in shots where it was plainly sitting
exactly where it was supposed to. Re-measured with the matrices refreshed, the
same frames read -0.58 across the board.

Any probe that projects must do this first:

```js
camera.updateMatrixWorld(true);
camera.matrixWorldInverse.copy(camera.matrixWorld).invert();
scene.updateMatrixWorld(true);
```

### three.js light layers do not do per-object lighting

It is natural to reach for `light.layers.set(1)` plus `mesh.layers.enable(1)` so
the follow rig can light the products without blowing out the pale wall they are
installed in. **It does not work.** three.js tests a light's layers against the
**camera**, not against each object, so all that happens is the lamp is dropped
from the render entirely.

Measured, on the pier beside the window: 0.756 mean with the lamp, 0.510 with
layers set, and 0.756 again the moment the camera was also put on layer 1. That
last number is the tell — it is the signature of a light being collected or not,
not of a light being filtered.

The wall gets albedo headroom instead. See `buildPortal()`.

### Dark colours chosen by eye are black in linear space

`0x21454f` looks like a handsome deep teal as a swatch. sRGB `0x21` is 0.129,
which is **0.014 in linear light** — effectively black to the renderer. Every
dark colour picked from a hex value lands in this trap and produces a shape with
a rim and no faces.

### A missing argument becomes a NaN matrix, and the mesh is simply not drawn

`buildVWall` has a local helper `slab(w, h, d, x, y)`. Two calls left `y` off:

```js
slab(innerPier, TOP, depth, xInner);      // y === undefined
slab(wingOuter, TOP, depth, xOuter);      // y === undefined
```

`position.set(x, undefined, 0)` writes NaN, and three.js draws nothing for a
mesh whose world matrix is not finite — no warning, no console error, no
degenerate geometry on screen. That is **four meshes per station, sixteen in
all**: the narrow pier beside the gap and the broad wing outboard of every
opening. Every V wall in the building stood as a pair of floating reveals with
no wall around them, through several rounds of review.

It was not found by looking. It was found because a camera-clearance probe
reported that it had skipped sixteen bounding boxes it could not evaluate.
**Count what your probes cannot measure, and print the number.**

### The camera track has to be emitted in timeline order, not in code order

`buildCameraTrack` keeps a running `cursor` — the furthest point reached so far
— so that a pose authored as "sixteen metres in front of station two" can be
clamped if the previous station already carried the camera past it. That is
correct, and it only works if the beats are emitted in the order the visitor
meets them.

An earlier version ran the station loop first and pushed the hand-authored
specials in afterwards. By the time the bifold screen asked "how far have we
got?", the cursor had already seen station four, seventy metres further on, so
the screen's own approach was clamped to *beyond the end of the building*. The
screen never appeared in shot at all. Beats are now collected, sorted by `t`,
and only then emitted.

### A clamped camera pose is still a valid camera pose

The monotonic backstop guarantees the camera never reverses. It does not tell
you when it had to intervene, and a pose it has moved is indistinguishable from
one that was authored there.

Station 3's hold wanted to sit at z −42.8, which was 0.8m *behind* the bifold
screen at −42 — there was only 10m between them where the grammar needs about
18. The backstop silently shifted it 4.5m down the gallery, and at that distance
the composite door and the heritage door project to **ndc ±1.12: both products
at the door station were entirely outside the frame at their own hero beat.**

The only way to see this is to compare authored against actual:

```
v1  want -4.8   got -4.8   shifted  0.0
v2  want -22.9  got -22.9  shifted  0.0
v3  want -42.8  got -47.3  shifted -4.5   <-- here
v4  want -60.9  got -60.9  shifted  0.0
```

**If a system has a corrective clamp, audit how often it fires.** A clamp that
never reports is a bug that never surfaces.

### A flat frame can mean far too much in shot, not too little

The contact sheet's `spread` metric (p5–p95) catches frames with no tonal
range. At t=0.800 it collapsed to 0.28 against ~0.75 everywhere else, with a
high mean — the classic signature of a camera pointed down an empty corridor.

It was the exact opposite. `buildShell`'s far vista, a 64 × 28m plane, was
pinned at z −52 with a comment reading "the camera never reaches it". True when
the route ended near −40; after the experience was doubled to −88 that plane
stood **across the middle of the route at station three**. The camera closed to
2.3m of it, so one flat lit surface filled the entire frame, and then it flew
straight through. Low spread says "one surface dominates". It does not say which
side of the lens the problem is on.

### A comment can describe the opposite of what the code does

`buildGlassHall` placed its panes in polar coordinates:

```js
const angle = (rng() - 0.5) * Math.PI * 1.1 + (rng() < 0.5 ? Math.PI * 0.5 : -Math.PI * 0.5);
pane.position.set(Math.cos(angle) * radius, ..., Math.sin(angle) * radius);
```

with a comment reading "pushed out and biased **away** from the route… these now
sit out to the sides and are never entered". But `sin(±π/2) = ±1` and
`cos(±π/2) = 0`, so biasing the angle to the poles puts every pane on x ≈ 0 at
z = ±9…18 — which is not beside the route, it *is* the route. A 1.8 × 5.7m sheet
of glass sat at (−0.3, −16.9) and the camera passed **6cm** from it.

This survives review precisely because the comment sounds right. The keep-out is
now stated as a constant and enforced in Cartesian.

### Scenery placed by eye can delete a station

`buildMaterialBay` was dropped into the gallery to fill a stretch the contact
sheet called flat. Its side bays stand at x ±2.9 to 5.1 and it is seven metres
deep, and station 4's hold puts the camera at z −68.9 — **inside its
footprint**, with that station's eight specification blocks at −76 directly
behind it.

Every one of those callouts was present, visible, opaque, at valid depth and
correctly framed at ndc ±0.7 to 0.96. None of them was drawn. Every property you
would think to check said the callouts were fine, because they were: the fault
was a different object standing in front of them, and nothing in a callout's own
state can tell you that.

It is out. There is nowhere to move it to — the colonnade runs fins in triples
every ~1.9m for the whole length of the building — and scenery that hides a
station is worse than no scenery. It was also solving a symptom whose real cause
was the far vista, above.

### Imported and never called

`buildMaterialBay` and `buildPortal` were both imported at the top of
`atrium.js` and neither was ever invoked, so twenty metres of gallery had
nothing in it and the chamber had no mouth. Their teardown lines —
`this.bay?.dispose()`, `this.portal?.dispose()` — pointed at properties that
were never assigned, and **optional chaining turns a dead teardown into a
silent no-op rather than an error**. The colonnade and the screen were leaking
their geometry on every quality-tier switch for the same reason.

A linter will flag the unused import. Nothing will flag the dispose.

### Widening the lens does not rescue a portrait viewport

Each station is composed for a 16:9 horizontal field, with the pair of products
at ndc ±0.54. A 390 × 844 phone has an aspect of 0.46, so the horizontal field
is a quarter of what the shot was built for. There was already a 1.42× lens
widening for portrait and it is nowhere near enough — measured, the two products
sat at **ndc ±1.4**, entirely outside the picture, and what you actually saw was
the empty gap between them.

Preserving the horizontal field exactly needs a 2.6× pull-back, at which point
each window is 5% of the frame height. The camera is now backed off along its
view axis by a capped factor (2.1×), which puts the pair at ndc ±0.67 — the
whole composition visible, the products small, the callouts cropped. A phone
deserves its own camera track showing one product at a time; this makes the
existing composition coherent on a narrow screen rather than pretending to be
that track.

### An expression that looks derived but is a constant

Every opening in the building was built like this:

```js
const sample = left || right;
buildVWall(this.sets, this.quality, {
  opening: { width: sample.height * 0.82 + 0.16, height: sample.height + 0.14 },
  ...
```

That reads as "derive the hole from the product". It is not. `product.height`
is the **normalisation target** set in products.js — the literal 2.35 every
model is scaled to — so the expression collapses to the constants 2.087 x 2.49
and **every hole in the gallery was identical**, whatever stood in it.

The tell was in the same line and nobody read it: `sample = left || right`. An
opening that has to fit both members of a pair cannot depend on only one of
them.

Measured against the real bounding boxes, six of the eight station products
were **wider than the hole they stood in** — the casement and the flush sash by
524mm, burying 262mm of frame in solid wall on each jamb. The two doors had the
opposite problem: a 1.135m composite in a 2.087m hole, half a metre of bare void
per side. One bug, and the two symptoms look like opposites: "the casement is
overlapping with the frame" and "the door frames are too big".

The correct pattern was already in the same file, in the bifold branch: take a
`Box3` of the pivot and build to what it says.

### A floor that always wins is not a floor

```js
const bw = Math.max(3.2, box.max.x - box.min.x);
```

Three lines under a comment reading "its opening is measured off the doors
themselves, so the screen is built to the product rather than the product
dropped into a guess". The measured width is 2.785, so `Math.max` returns 3.2
every time and the comment is exactly false: it is a guess, and the guess wins.

A defensive floor that is never below the real value is invisible. Check the
range of the thing you are clamping before you clamp it.

### `height` sized the plate, so line count silently resized the type

`buildCallout({ height })` set the world height of the whole plate, and the
canvas height grows with the line count. So one `height` value produced
**different type sizes on different blocks**: every note was passed `0.15`, and
a two-line note rendered its title at 6.6px of cap while a three-line note
rendered the same title at 5.2px — 27% smaller, chosen by nobody, invisible in
the source.

Measured across the four holds, titles were running at 8.1px of cap and the
specification lines — the actual product specifications — at 5.3px, with meta
lines at 2.8px. That is a 4-to-7px font-size equivalent. Nothing on a web page
is ever set that small; the meta line was not small type, it was texture.

The parameter is `titleCap` now — the world height of a capital in the title —
and the plate sizes itself from it. One value gives identical type on every
block whatever it contains.

**It was not a resolution problem.** At 11.7x to 18.5x minification the canvases
already carried an order of magnitude more texel than pixel; the mushiness was
a *symptom* of that minification. Making the plates bigger made them sharper
for free, because they stopped fetching from mip levels that had already
averaged the stems away.

### Wrapping is what buys the type size

The blocks live in a gutter between the product's outer edge and the frame
edge — measured at about 144 screen pixels. `plateW` works out as
`titleCap * canvasWidth / capHeight`, so a long single line does not merely
look small, it forces the whole block **wide**, and the blocks were already
touching ndc 0.99.

Wrapping turns a 3.8:1 strip into roughly a 1.8:1 column, which buys the height
increase at constant on-screen width. On the casement: 1517x396 becomes
951x525, the world width is unchanged, and the title goes from 8.2px to 13.1px
of cap. The wrap width is the only lever on how far a block reaches toward the
frame edge that does not also shrink the type.

### An x-extent is not enough when the thing is nearer the camera

The hold distance is solved so the outermost thing at a station lands at a
fixed fraction of frame width. Solving it from the measured world x put the
blocks at **ndc 1.12 — off frame, on both sides — while reporting an outer
extent that looked comfortable**.

The leaves are splayed toward the camera, so an annotation block sits about
1.8m nearer the lens than the product plane the hold is measured from, and the
same world x projects a good deal wider there. The solve has to be

```
|x| / ((D - zOffset) * perMetre) = edge     ->     D = |x| / (edge * perMetre) + zOffset
```

Measuring extent in one axis and framing in another is the mistake; measure in
the space the answer is expressed in.

### A title in the data that the renderer never builds

`'bifold' => ['title' => 'BIFOLD', 'spec' => 'SHEERLINE PRESTIGE ALUMINIUM', 'notes' => [...]]`
had been in the PHP registry, JSON-encoded onto the element and parsed into
`this.labels` the whole time — and then dropped, because `buildInformation`
builds a title callout for *station* products and the bifold branch only ever
iterated `notes`. The bifold was the one product in the room that never said
its own name, which is precisely what "there are no labels for this" meant.

Checking that the data is present, reaching the client, and parsed proves
nothing about whether anything renders it.

### Levelling a camera moves everything it was looking at

Removing 12.4 degrees of pitch is a one-line change and a two-hour job. Every
composition in the piece had been framed against a camera that pitched up at
the opening and down at the doors, so with the pitch gone:

- the mark was hung 1.4m above the new axis and **sliced off the top of frame**
  — the first thing any visitor sees;
- both door stations dropped 0.26 of NDC, because doors have `sill: 0` and were
  being looked down at by 5 degrees;
- the pricing terminal grew enough that its top 28px went **behind the site
  header**, which is a fixed DOM bar and not part of the scene, so nothing in
  the 3D framing could see the problem.

Do not quietly reintroduce pitch to paper over any of it. Move the subjects.

### `passive` is not the same as `disabled`

At the last stop the page hands scrolling back so the WindowCAD iframe is
usable. Doing that with `setEnabled(false)` leaves the visitor at the final
stop with **no way back** — a wheel up does nothing, because the stepper is
deaf and the document is already at scrollY 0.

Passive keeps listening: the document gets the wheel, but a push back up while
still at the top steps into the previous stop.

### A 3D-transformed element can be painted where you cannot click it

The worst find of the pass, and it had been true since the terminal was built.

At the resting pose the WindowCAD iframe reports
`getBoundingClientRect() = 345,88 911x565` — exactly where it is painted — and
`document.elementFromPoint()` at the centre of that rectangle returns the
**section root**. Every property you would check to diagnose it reads healthy:
`pointer-events: auto` on both the shell and the iframe, `opacity: 1`,
`visibility: visible`, `aria-hidden="false"`, and nothing covering it. It is
simply not in the hit-test tree.

The cause is in the transform chain. The perspective is applied as a transform
FUNCTION on the camera wrapper — `translate(...) perspective(f) translateZ(f)
matrix3d(...)` — which is what makes the render land pixel-exact on the WebGL
panel, and the comment above it records how much work that took. But the
wrapper's own layout box stays **110x63 in the middle of the screen** while its
child is transformed out to 911x604, and hit testing follows the layout box.

So the configurator was visible and completely unclickable, at every viewport
size. It never surfaced because nothing had ever tried to click it — the
sequence used to sweep past this beat. Making the last stop a place the visitor
*rests* is what exposed it.

The fix does not fight the transform chain, it sidesteps it using a fact about
the resting pose: at the final stop the camera has zero roll, pitch and yaw and
the terminal's own rotation has eased to zero, so the panel is exactly parallel
to the image plane — and a plane parallel to the image plane projects to an
axis-aligned rectangle, which a plain 2D translate and scale reproduce
*exactly*. `ProjectedElement.setFlat(true)` swaps to that at t >= 0.985. There
is no pop because there is no difference to pop between: the measured rect is
identical either way.

**The general lesson:** `getBoundingClientRect()` agreeing with what you see on
screen tells you nothing about whether the element can be interacted with. If
something has to be clickable, hit-test it with `elementFromPoint` — that is
the only check that actually asks the question.

### A release that undoes itself on the next event

```js
if (this._released && window.scrollY <= 1) { /* re-enter */ }
```

The release happens at scrollY 0, so this is true on the very next scroll event
and instantly cancels it. Re-entry has to mean the visitor actually left and
came back, which needs a second flag (`_wentAway`, set once scrollY passes 24).

State machines whose entry and exit conditions are both true at the same moment
oscillate, and this one oscillated silently — the only symptom was that
scrolling away from the finished sequence sometimes did not work.

## 9. Three things that are not obvious

### The heroes are blocked in world space, not on the orbit

`this.heroStage` does not rotate. The first build flew the heroes on the orbit by
shortening their radius and pushing their local `+Z`, which cannot work: the
holder is rotated to the product's *original* station angle, so its local `+Z`
has nothing to do with where the camera is once the orbit has turned. The window
meant to fly through the lens went off the right of frame at `ndc.x = 5.0`.

### The terminal is two objects that hand over

`CSS3DRenderer` is the textbook answer and does not work here: it needs the
WebGL canvas transparent with a depth-only occlusion mesh, and a post-processing
chain paints an opaque fullscreen quad over the hole. So there is a WebGL panel
that *is* in the scene (occludable, lit, refracting) and a real `<iframe>`
projected onto the same screen quad, crossfading at the end. **Verified aligned
to within 2px. Do not casually refactor this maths.**

The projection has a unit trap in it: CSS perspective is in **pixels**, the
scene is in **metres**. Both the camera's and the object's translations are
scaled by `pxPerUnit` before the matrix is built, and the centring translate has
to be applied in screen space, not before the camera matrix. Getting either
wrong fails silently — a 5×3px iframe, or one sitting 760px below the panel it
belongs to.

The stand-in texture is drawn **light**, matching the real interface, so the
handover is not a visible cut. Its price card reads a blank figure on purpose:
the real tool takes your details before it shows a number, and drawing an
invented price would be the one untrue claim on the page.

### The environment map is generated, not loaded

`lib/studio.js` builds a daylit gallery out of emissive planes and pre-filters it
with PMREM. Two notes on it:

- A **front scrim** is not optional. Without a source between lens and subject,
  every camera-facing surface has nothing bright to reflect — a dielectric
  returns about four per cent at normal incidence — and the extruded mark
  rendered as a flat black cut-out with a nice rim and no faces.
- A **negative fill** belongs in the environment map and nowhere else. Tried as
  geometry twice; both times it became the composition rather than shaping it.

## 10. The information, and where it comes from

Every figure the scene states is passed from PHP via `data-fx-labels`, and each
one is already published on the route it belongs to:

| Label | Source |
|---|---|
| `LINIAR ENERGYPLUS 70MM UPVC` | `case-studies-data.php` |
| `A+ RATED` / `0.95 W/m²K` / `36MM TRIPLE GLAZED` | ditto — the figure requires the triple glazed unit, so it says so |
| `16 FINISHES` | ditto |
| `PAS 24 SECURITY OPTION` | ditto |
| `SHEERLINE PRESTIGE` / `THERMALLY BROKEN` / `SLIM SIGHTLINES` | ditto |
| `44.5 MM INSULATED SLAB` / `GRP SKIN` / `MULTI-POINT` | ditto |
| `09 WINDOW SYSTEMS` / `09 DOOR SYSTEMS` | **counted** by `fenster_experimental_home_group_counts()` from the same registry the menu is built from |

The pricing steps describe the tool's actual flow, checked against the live
configurator rather than invented. Its own first screen reads "Choose your
product to get a free, no-obligation quote", and it asks for contact details
before it shows a figure — which is why step four reads
`PRICE / DETAILS FIRST, THEN THE FIGURE`. `ABOUT-PAGE-HANDOVER.md` records that
claiming otherwise is the one thing this page must not do.

The counts are derived rather than typed. Type `09` into a shader and the day a
tenth window style is added the 3D scene starts telling visitors something false
and nobody thinks to look in a fragment program.

## 11. QA harness

Two scripts, both worth keeping. The in-app browser pane does not composite on
this machine and plain `--screenshot` runs cannot go below a 500px viewport or
advance more than one animation frame.

```bash
# DENSE MOTION SWEEP - the tool for judging movement rather than composition.
# Measures the difference between neighbouring frames and flags POP (something
# appeared or teleported), DEAD (something stopped moving) and RUSH (faster
# than the eye can follow). Under 25 frames it refuses to be trusted and says
# so, because at 13 frames every adjacent pair differs by design.
node scripts/sweep.mjs "http://fenster-glazing.local/fenster-new-home-page/?fx=high" \
  --mode timeline --frames 51 --w 900 --h 500 --cols 9 --out sweep.png

# ...and the same thing under REAL playback, a frame every 200ms while the page
# actually scrolls. This is the one that exercises Lenis, the springs and the
# mixers; the timeline mode deliberately bypasses all three.
node scripts/sweep.mjs "http://fenster-glazing.local/fenster-new-home-page/?fx=high" \
  --mode play --interval 200 --duration 22000 --cols 11 --out play.png

# one page, several beats, console errors, overflow, arbitrary probe
node scripts/shot.mjs "http://fenster-glazing.local/fenster-new-home-page/?fx=high" \
  --w 1600 --h 900 --at 0,0.3,0.6,0.9 --tag check \
  --pre "window.__fensterInspect('casement')" \
  --eval "({ t: window.__fensterAtrium.t })"

# the whole timeline as one image, plus exposure metrics per beat
node scripts/contact-sheet.mjs "http://fenster-glazing.local/fenster-new-home-page/?fx=high" \
  --w 800 --h 450 --cols 4 --out sheet.png
```

Flags that matter: `--reduced` emulates `prefers-reduced-motion`, `--mobile`
sets a touch viewport, `--at` is a position on the **timeline** and not on the
document (they are different numbers, because the page is taller than its
runway).

Page hooks: `?fx=high|medium|low` pins the quality tier — headless under-reports
cores and memory, so without it every QA shot is of the medium path.
`window.__fensterSeek(t)` drives the timeline directly **and snaps every spring**,
so a screenshot is of the pose the choreography intends rather than one still
settling. `window.__fensterInspect('casement')` parks the camera on one product.

### A coarse sweep turns a gradient into a POP

The 51-frame sweep samples the timeline every 0.02, and in the fast stretches
that is 6.5m of camera travel between neighbouring frames. Any real gradient
steeper than the local median then reads as a POP, which is the detector's
resolution and not the scene's behaviour. Both of the POPs left in the full
sweep dissolve when resampled:

```bash
# the chamber threshold: 3.6x POP at step 0.02
npm run sweep -- "http://fenster-glazing.local/fenster-new-home-page/?fx=high"   --mode timeline --from 0.930 --to 0.995 --frames 27
# -> no pops, no dead frames, no rushes. Mean falls 0.551 -> 0.129 monotonically
#    over 20 frames, spread never leaves 0.75-0.83.
```

`--from` / `--to` exist for exactly this. **Before treating a POP as a defect,
resample the window around it.** The corollary is also worth having: a flag that
survives at fine resolution is real, and the chamber's own numbers say the
transition is a twenty-frame fade rather than a cut.

### Reading the numbers

The contact sheet prints mean luminance, clipped share, black-point share and
**spread** per beat. Targets for the light grade:

| metric | target | what it catches |
|---|---|---|
| mean | 0.45 – 0.72 | a bright room, not a lightbox |
| clip | under 2% | a white wall must still hold tone |
| spread | over 0.45 | there has to be a real black point somewhere in frame |

**`delta` is the metric that finds motion faults, and nothing else does.**
Twelve stills a whole timeline apart cannot tell you whether something popped
between them. Every motion fault this project has had lived in those gaps: the
camera flying through solid geometry at t = 0.42 and 0.46 (mean luminance 0.174
against a run median of 0.60), the bifold crossing the entire frame in 0.015 of
the timeline, twenty-two near-identical frames at the opening. All three were
invisible on the twelve-beat contact sheet and obvious on a 51-frame sweep.

**`spread` is the metric that matters for exposure, and it did not exist on the
dark grade.** A dark scene fails by blowing a hole in the frame, which `clip` catches.
A white-box scene fails a different way: everything drifts to one tone and the
result measures as perfectly exposed while looking like fog. The 5th-to-95th
percentile spread catches exactly that.

Two beats read `BLOWN` and should be ignored:

- **t ≈ 0.96** — the terminal is a lit screen in a deliberately dark room. 4% of
  frame at full brightness is a screen, not a fault. `spread 0.93` confirms it.
- **t = 1.00** — WindowCAD cannot load without network access to
  `windowsoftware.co.uk`, so the live iframe captures as a white rectangle.

Headless occasionally hands back a frame where the WebGL canvas has not
composited — a flat page-coloured rectangle, perhaps one capture in fifty. It is
indistinguishable from a real fault to the delta detector, which duly reports a
POP six times the local median; two 51-frame runs were chased before it was
clear the sequence was fine and the harness was not.

`sweep.mjs` now **detects and retakes** those. A blank frame has almost no tonal
range, so it is caught on `spread` and recaptured up to twice, and the run
reports how many were retaken. If a frame really is uniform three times running
that is a genuine finding and it passes through.

## 12. Quality tiers

| Tier | When | What changes |
|---|---|---|
| high | desktop, ≥6 cores, ≥6GB | depth of field, transmissive glass, shadow maps, SMAA, full annotation set |
| medium | modest desktop | no DOF, no transmission, no SMAA, fewer particles, lower DPR |
| low | touch, narrow, software renderer, or reduced motion | no bloom, no aberration, reduced annotations, minimum geometry |

There is a runtime governor: if more than 45% of frames run long over a three
second window, the pixel ratio drops a step, then depth of field is disabled.

## 13. Reduced motion

The scene still renders — real geometry, real lighting — and holds one pose. No
Lenis, no scroll-driven camera, the runway collapses to one viewport.

**Pass two inverted what shows.** Pass one kept the overlay copy and suppressed
the static hero, because the overlay was the composition the scene was designed
around. There is no overlay copy any more, so the static document comes forward
and the scene sits behind it as a single still frame.

## 11a. The layout: four V stations, eight products

The tour is **eight products in four settings**, not three products in three.

Each station is a pair of walls **splayed toward the camera with a gap between
them** (`buildVWall`), a product built into each leaf. That replaced a flat
wall-with-two-openings repeated six times down the route, which is the opposite
of a designed building: six identical elevations in a row read as a corridor in
a video game.

A splayed pair does four things a flat wall cannot:

- **Two products are in shot at once**, angled, so the visitor sees a range
  rather than a queue of single objects.
- **Each leaf catches the light differently**, which is exactly why a showroom
  splays its display walls instead of lining them up.
- **There is a real gap to travel through.** The camera route IS the gap, so it
  cannot clip a wall — the previous layout threaded a 1.5m doorway and grazed
  jambs.
- **It is never symmetrical in shot.** Approached off-axis, one wall is near and
  raking and the other far and flatter, so the arrangement reads differently at
  every station even though the geometry repeats.

The pairs group the range the way a showroom would: uPVC with uPVC, aluminium
with aluminium. `splay` and `gap` vary per station so the four are not literally
identical.

### Nothing moves into place

Products are **fitted into the elevation and stay there** for the whole run.
Only their sashes animate and only their annotations come and go.

An earlier version flew each product three metres up into its opening as the
camera arrived and sank it away as the camera left. It read as exactly what it
was — a model sliding up into a hole — and it popped at both ends of every
station. A window in a wall is fitted. It does not arrive.

### The camera is aimed at measured positions, not guesses

`slotAt()` computes where a product ends up in a V from the splay, the gap and
the pier module. The track is built at module load, before any model has been
fetched, so it cannot ask the geometry — but every product normalises to the
same 2.35m height, so every opening is the same width and the rest is the
leaf's own hinge geometry.

This matters: aiming at a guessed position is what put the camera **inside** the
casement. The "near" pose looked at x = -1.3 while the product sat at x = -4.14,
so the window filled the left edge and the lens passed through it.

## 11b. The floor is polished, and the walls have tooth

**The floor was a `ShaderMaterial`** — unlit, so it could never reflect
anything, and the whole lower half of the room was a flat drawn surface. It is
a `MeshPhysicalMaterial` now with the studio environment on it and a clearcoat
over the top; every detail the old shader drew (scored module lines, light pools
under the ceiling panels, the green inlay, the aggregate) is injected into its
shader rather than replacing it. The scored joints also raise **roughness**, not
just darken colour — a reflection that runs straight over a scored line is the
tell that a floor is a texture rather than a surface.

**An environment map only reflects the generated studio, never the scene**, and
in a showroom the thing you notice in the floor is the product standing on it.
So `buildFloorMirror()` lays a real planar reflection over the top, with two
departures from the stock `Reflector`:

- **Fresnel-weighted**, because a polished slab reflects almost nothing looked
  at straight down and a great deal at a grazing angle. Flat-strength
  compositing gives a swimming pool.
- **Blurred with distance**, standing in for surface roughness. A perfectly
  sharp reflection reads as glass, not as polished concrete.

It costs one extra scene render, so it is high-tier only and is now the **first
thing the performance governor drops** — the floor keeps its environment
reflection and clearcoat either way.

**Walls are plaster, not flat colour.** `wallMaterial()` adds a fine grain that
moves roughness as well as colour, plus shallow panel joints on a 1.2m/2.4m
module so the elevation has a scale to read against. Flat untextured planes are
what made every pale surface land within a few per cent of the same value and
read as fog.

**Callouts carry a frosted backing plate.** They are dark type placed in world
space against whatever the product happens to stand in front of; on a pale wall
they read perfectly and over a bench, a shadow or a dark frame they vanish — and
which happens depends on where the camera is, so it cannot be fixed by moving
the callout. The plate is 62% and heavily feathered at all four edges so it
reads as the wall being slightly lighter, never as a box.

## 12a. The colonnade fills the gallery between stations

`Orbit` is gone. It was a leftover from the first concept, where the world
revolved around a fixed camera; once the camera started travelling the length of
a building, a ring of products rotating about the origin stopped meaning
anything. It showed, too — products drifted half in and half out of frame at the
edges of shots, cropped at odd angles, at no particular height, belonging to
nothing.

`buildColonnade()` puts them in the building instead: two runs of piers flanking
the route, staggered against each other so the pair reads as a rhythm rather
than a tunnel, with a recessed bay between each pair. Every bay has a head, two
returns, a slot light in the soffit, a threshold strip on the floor and a plinth
course at its base. Products stand in them, angled toward the approaching
camera so they are presented rather than passed edge-on.

Two more bays are cut into the material bay's own backdrop wall, flanking the
doorway. That is not decoration either: measured at the doors station, **not one
of the colonnade's ten products was inside the frame**, because a stopped camera
looks down the room and the bays are ninety degrees off that axis.

The plinth course is worth its own note. Everything in this room was landing
within a few per cent of the same tone — pale piers against a pale wall against
a pale floor — and it measured as well exposed while reading as fog. A darker
band at low level is the oldest fix in architecture: it gives the elevation a
horizontal to read against and puts a real dark value back at the bottom of the
frame without making anything dim.

## 12b. The mark is a travelling companion, and it spins like a wheel

For the first tenth of the timeline it is the subject. After that it does not
leave: it moves to a slot held in **screen space** and travels with the visitor
for the rest of the journey.

Its rotation is proportional to how far the camera has actually travelled —
`buildArcTable()` walks the camera track once at boot and accumulates distance,
and the mark's yaw is that distance times a turns-per-metre constant. So it
turns while moving between stations and comes to rest by itself on arrival. No
timer decides that; the geometry of the route does. At each station a `settle`
weight eases the wheel angle onto the nearest whole turn, so it presents square
while the product beside it is being looked at, then picks the spin back up
exactly where the route left it. Because it is a pure function of `t`, the whole
thing stays reversible — a velocity integrator would not.

Two placement rules, both learned the hard way:

- **Aim at a screen position, not a world offset.** A fixed offset in metres
  lands somewhere different in every shot, because pitch, yaw and focal length
  all change through the sequence. On a plain `camPos.y + 1.95` it measured
  between ndc y 1.05 and 2.43 — off the top of frame for most of the journey.
- **Ride at a fraction of the distance to the subject.** Held at a fixed 7.4
  metres ahead it was planted *behind* whatever the camera was looking at: at
  the windows station that put it a metre past the far face of the portal wall
  and inside its pier, where it silently vanished. It now rides at 45% of the
  subject distance, with the world scale divided by the same factor so its
  apparent size never changes.

## 13a. The portal has two openings, and that is a fix

The wall the casement is installed in carries a window **and** a door-height
void, sharing a head datum.

The second opening is not decoration. The pass-through beat used to aim the
camera straight at the installed casement and fly through it — measured mean
luminance 0.177 against a run median of 0.60, because the camera ended up 0.68
metres from a shut 2.35m window and the frame was entirely dark frame and dark
glazing. It was also nonsense: you cannot walk through a closed window.

Dodging the camera round the wall would have fixed the collision and lost the
move. A second opening fixes both and is what the elevation should always have
been — a single hole in a slab reads as a card with a rectangle cut out of it,
whereas a window and a doorway on a shared datum is how an elevation is
composed. The camera passes the installed window in the near foreground on its
way through the doorway beside it, which is the foreground occlusion the brief
asked for, for free.

The window also stands on a 0.62m **cill** now. A casement whose bottom rail
runs into the floor slab was the detail that most gave away that this was
geometry in a void rather than a window in a building.

## 12c. There is a detail shot

At `t = 0.432` the camera goes in tight on the open sash with a 31mm-equivalent
lens and the aperture opened nearly four times, so the hinge, the gasket and the
depth of the 70mm profile are sharp and the wall behind them falls away.

It exists because a real playback pass measured **thirty of its hundred and ten
frames** as the same window in the same wall from slightly different angles. It
is also the only moment in the sequence that argues the product is well made
rather than merely present, which is the argument the whole page exists to make.

## 13b. The bifold is blocked in camera space

Its sweep is defined against the camera's own axis — `dir` units in front,
`right` units across — not in world coordinates.

World coordinates cannot work here and the measurement says so. The camera pans
left across that beat while the bifold swept right, so their angular velocities
**add**: the product crossed the entire frame in about 0.015 of the timeline and
was measured in frame at zero of eight sampled positions. Camera-space blocking
makes the sweep a fact about the shot rather than about the room.

It sits **6.6 units** in front, not 2.6. The first version overflowed the frame
in both axes: it wiped the screen, and you could not tell what had wiped it. A
transition nobody can identify is just a smear. At 6.6 the whole product is
inside the frame with room around it, so the panels, the stiles and the fold
angle are legible while it crosses.

The parameter also carries a sine, `x + 0.78*sin(2*pi*x)/(2*pi)`, which inverts
the emphasis of an ease: the derivative is `1 + a*cos(2*pi*x)`, so it crosses
the centre of frame at about a fifth of the speed it enters and leaves at. That
is where the concertina happens and it is the only part of the beat worth
spending time on. Measured after: in frame at 13 of 15 sampled positions, and
between t = 0.62 and 0.67 it moves from ndc -0.16 to 0.20 while the fold runs
from 14% to 85% — it hangs almost still, centre frame, while it unfolds.

## 14. Known and deliberate

- **The pricing chamber is dark on purpose.** It is the one dark volume in a
  light building, and it exists so the terminal has something to be bright
  against.
- **Scrolling over the live iframe scrolls the iframe.** Same as the real site's
  quote embed. The page still scrolls from the margins.
- **The four non-hero animated products hold a fixed, varied open pose.**
  `poseRange()` sets flush sash 28%, sliding sash 42%, heritage door 16% and
  aluminium slider 55%. Static rather than animated: these are background
  dressing and a room full of things opening and closing on their own would
  pull the eye off whatever is centre stage. The amounts are uneven on purpose;
  two units ajar by the same 30% look like a copy-paste.
- **There is no per-frame mixer sweep.** `setOpen()` applies the bindings
  itself, and the bindings write straight to the node transforms, so a pose
  persists without being re-evaluated. The heroes are applied when the
  choreography poses them and the range once at load.
- **Smooth White is not in the finish cycle.** A near-white powder coat at the
  door's closest approach blew 33% of frame under the dark grade. It may be
  worth re-testing now the room is light and the exposure is 0.72 — the reason
  it came out no longer necessarily applies. White is still a finish Fenster
  sells; it just is not the one this shot currently demonstrates.

## 15. Not used, and why

`Desktop\windowcad-spins\` also holds ~87 rendered videos across seven motion
sets (spin-360, sweep-open, colour-sweep, colour-cycle, style-cycle,
main-products, 360-smooth), including alpha WebM and green-screen versions.
None is used here: the animated GLBs do everything a pre-rendered spin does and
stay interactive, lit by this scene's own lights, and scrubbable. The videos
remain the obvious source for a **mobile** fallback if the low tier is ever
judged too thin — an alpha WebM of a product turning, composited over the same
page gradient, would cost a fraction of the WebGL path.
