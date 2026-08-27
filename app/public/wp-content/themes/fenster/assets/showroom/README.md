# The showrooms — `/window-showroom/` and `/door-showroom/`

Two pages that let a homeowner examine the actual product they are considering —
real WindowCAD geometry, in the colour they want, opening — and then get a price.

Built from `PRODUCT-VIEWER-BRIEF-2026-08-24.md`, which was itself written off the
audit of the earlier 3D page at `/fenster-new-home-page/`. **That page is not the
model to copy.** It was measured at 12.3 MB, 2,223 draw calls, 17–19 fps and 170
crawlable words. Everything here is arranged so those numbers cannot recur.

---

## 1. The one architectural rule

**The 3D viewer is never on the critical path.**

The page is complete, readable, indexable and converting as HTML plus a poster
image. `three` is imported dynamically, only when the visitor presses *View in
3D*. Nothing about the page's content, its ranking or its call-to-action depends
on a byte of it.

Everything else follows from that:

- the **LCP element is an `<img>`**, never the canvas
- the poster, the canvas and the loading state share one grid cell in a box
  reserved by `aspect-ratio`, so **CLS is zero**
- **all nine products' specifications are in the served HTML** — one visible,
  the rest `hidden` — so a crawler reads the whole range and switching product
  is a class change
- with JavaScript off, the page still shows a product, its figures, and both
  calls to action

## 2. Measured

| | Audited 3D page | Showroom |
|---|---|---|
| Page's own assets | — | **139 KB / 10 requests** |
| Models, all 11 | 9,125 KB | **1,087 KB** |
| Largest single model | 2,288 KB | **184 KB** |
| Draw calls | 2,223 | **51–111** |
| Frame time | 57 ms | **1.1–2.12 ms** |
| Crawlable words | 170 | **5,477 / 5,541** |
| CLS | — | **0** |
| LCP | — | **828 ms**, on an `<img>` |
| Geometry leak over 12 switches | — | **0** |

Frame time measured by timing `renderer.render()` directly. Do not measure this
through `requestAnimationFrame` in the headless harness — it is throttled to
30 fps there and you will be measuring the compositor, not the scene.

## 3. The asset pipeline

```bash
npm run models:optimise     # GLB -> optimised GLB + optimise-report.json
npm run models:verify       # does every animation still work?
npm run posters             # one poster per product, from the optimised model
node scripts/render-card-thumbs.mjs   # thumbnails for the photography cards
npm run build:showroom      # scss + js
```

**Material merge is the point, not compression.** A WindowCAD export gives every
gasket and bead its own material. Quantising the PBR values and merging the
duplicates is what collapses the draw calls, and it leaves exactly one material
named `fenster:frame` per product — which is what makes the finish switcher one
assignment rather than a hunt through forty. Roles are written into material
names (`fenster:frame`, `fenster:glass`, `fenster:hardware`, `fenster:trim`)
because a material index is not stable across a rebuild.

**Codec: meshopt, decided by measurement.** Draco compresses harder — 799 KB
against 1,087 KB across the set — but its decoder is 73.6 KB gzipped against
meshopt's 6.3 KB. Break-even is the third model a visitor opens. Meshopt wins the
first interaction by 42 KB and decodes faster, and the first interaction is the
one that decides whether there is a session at all.

**`flatten()` and `palette()` are deliberately not used.** `flatten` collapses
the node hierarchy the animation channels point at; `palette` would merge
materials harder by baking them into a texture, which would make the finish
switcher impossible and add the only texture in the set.

## 4. Model coverage — the constraint that shapes both pages

**Eleven of the eighteen range products have a model.** Windows 4 of 9, doors
7 of 9. The rest get a photography card in the same grid at the same size.

That gap is not papered over, and it must not be: there is a standing rule on
this project against presenting one product's geometry under another product's
name, and four files in `assets/experimental/models/` are static twins of the
animated ones precisely so nobody does it by accident.

## 5. Traps found building this

### `renderer.info.memory` comparisons must be like-for-like

A leak test that loads product A, switches ten times, and compares the geometry
count against A's baseline will report a leak whenever it happens to finish on a
product with more meshes than A. It reported **39 leaked geometries**, which was
a 45-mesh composite baseline measured against an 84-geometry heritage door.
There was no leak. Switch away and back to the *same* product, then compare.

### `Box3.setFromObject` inside a per-frame camera update

It walks every mesh in the object and transforms its bounding box. On a
hundred-mesh door, called every frame from the camera framing, that is real
work. The box is measured once when a product loads and passed in from then on —
which also gives the better shot, because a camera that backs off as a door
swings open reads as the camera flinching.

### Clicking through the rail faster than models load

A second switch disposes the first product, then the *first* load resolves and
assigns itself as `current`, orphaning a model nothing will ever dispose. Guarded
with a load token. This is not an edge case; it is what browsing looks like.

### A tinted contact shadow multiplied in turns the floor pink

Multiplying the ground by `(1 − shadowColour)` with a blue-grey shadow removes
more blue than red. A shadow has no hue of its own here. Pure black with a
varying alpha, blended normally.

### Any difference between floor and background draws a horizon

A seam behind a product reads as a join in the image rather than as a room. They
are the same value, and the contact shadow does the grounding alone.

### The default product could not demonstrate the best feature

Composite is neither a foil nor a powder coat, so it fell through both palettes —
and it is the door page's default. `colour_options.materials.composite` existed
all along. Check that your default case is covered before checking the others.

## 6. Known, and not ours to fix

**`legend-spritesheet.webp` is 1,996 KB and loads on every page of the site**,
including the homepage — 2,118 KB with its companion, roughly half the homepage's
total payload. It is nothing to do with these pages and it dwarfs everything on
them. The earlier 3D page hid the widget with CSS, which does not stop the
download. Flagged for the owner rather than changed, because the mascot is a
brand decision.

**`lang="en-US"` on a UK site.** Site-wide, in the header.

**The Legend assistant popup overlaps the specification panel on a phone.**
Site-wide widget behaviour.
