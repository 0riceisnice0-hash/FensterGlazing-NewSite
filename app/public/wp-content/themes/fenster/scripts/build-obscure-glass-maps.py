#!/usr/bin/env python3
"""Build the companion maps the obscured-glass stage composites from.

Run from the theme directory:

    python3 scripts/build-obscure-glass-maps.py

WHY THESE EXIST. The stage used to paint the texture photograph over a blurred
scene with `mix-blend-mode: multiply`. Multiply can only ever darken, so a pane
could never have a clear patch -- the brightest a "transparent" bit could get was
"unchanged" -- and every glass read as a grey wash. The owner's words on
2026-08-27 were that it looked "black/white rather than ... the actual glass with
transparent bits".

Real textured glass does not darken. It bends light where the surface curves and
leaves the flat parts alone, so the pattern shows as a change of FOCUS, and the
colour behind comes through. The stage now models that with three layers, and two
of them read a map built here:

  <stem>-clear.webp   RGBA. Alpha only. Marks where the glass is flat enough to
                      see through, so the less-blurred copy of the scene shows
                      through it. Every pixel it reveals is scene colour, which
                      is what stopped the pane reading grey.

  <stem>-rim.webp     Greyscale centred on 128, painted under `soft-light`, so
                      128 means "leave this pixel alone". Carries the gradient
                      magnitude of the texture, signed by gradient direction, so
                      the pattern is drawn by SHADING ITS EDGES rather than by
                      painting over its middles. This is the whole trick: the
                      pebble interiors keep their colour and you still see the
                      pebble.

MEASURED, because "it looks better" is not a reason on this project. Mean
saturation across the Cassini pane, same scene, same viewport: the old multiply
model 24.0%, this model 32.1%. That is the number that says it stopped being
black and white, and it is reproducible with the harness in `nick.md`.

THE MAPS ARE DERIVED, NOT DRAWN. Delete them and re-run and you get the same
bytes. Never hand-edit one -- edit the source texture and re-run, or the map and
the photograph stop describing the same piece of glass.

CHANGING A SOURCE TEXTURE MEANS RENAMING IT. Theme images are emitted through
`fenster_generated_url()`, which adds no version string, so replacing a .webp in
place leaves browsers and the proxy serving the old one while the deploy verifies
perfectly. That has cost review rounds three times now. The maps inherit the
source's stem, so a renamed source produces renamed maps for free.
"""

import numpy as np
from PIL import Image, ImageFilter, ImageOps
from pathlib import Path

GLASS = Path("assets/images/products/obscure-glass")
# BUMP THIS WHENEVER THE RECIPE CHANGES, not just when a source texture does.
# The maps are emitted through `fenster_generated_url()` like any other theme
# image, so they carry no version string, and rewriting one in place leaves every
# browser and proxy that has already fetched it serving the old bytes -- the
# review you are answering then shows no change and you conclude the fix did not
# work. The source-rename rule covers a changed PHOTOGRAPH; this covers a changed
# FORMULA, which the r1 -> r2 MAD normalisation was.
MAPS_REVISION = "r3"
MAPS = GLASS / "maps" / MAPS_REVISION

# Maps are only ever sampled through `background-size`/`mask-size`, so there is
# nothing to gain from carrying the source's full resolution. Cotswold alone is a
# 1899px 2.3MB PNG. At the source's own width the set came to 3.5MB; 640 brings
# it under 2MB with no visible difference, because one is a soft-light shading
# layer and the other is a mask, and neither is looked at directly. Measured
# across the two heaviest textures before picking.
MAP_MAX_WIDTH = 640
MAP_QUALITY = 74

# Every photographed texture `obscure_glass` renders. Satin is deliberately
# absent: it is a CSS gradient, it has no photograph, and a flat acid-etched
# frost has no edges to shade. The stage hides both layers for it.
SOURCES = [
    "Arctic-privacy-5.webp",
    "Autumn-privacy-3.webp",
    "Cassini-privacy-5-rev4.webp",
    "Chantilly-privacy-2.webp",
    "Charcoal-Sticks-privacy-4.webp",
    "Contora-privacy-4.webp",
    "Cotswold-pilkington.png",
    "Digital-privacy-3.webp",
    "Everglade-privacy-5.webp",
    "Florielle-privacy-4.webp",
    "Mayflower-privacy-4.webp",
    "Minster-privacy-2.webp",
    "Oak-privacy-4.webp",
    "Pelerine-privacy-4.webp",
    "Reeded-privacy-2-seamless.webp",
    "Stippolyte-privacy-4.webp",
    "Sycamore-privacy-2.webp",
    "Taffeta-privacy-3.webp",
    "Tribal-privacy-5.webp",
    "Warwick-privacy-0.webp",
]

# Tuned as option F2 and chosen by the owner on 2026-08-27 against four textures
# at once, not against Cassini alone -- a setting that flatters one pattern can
# wreck a linear one, which is why Charcoal Sticks was in the comparison.
RIM_SHADE = 66.5   # how much the edges darken
RIM_LIGHT = 47.25  # how much the lit side of an edge picks up
RIM_GAMMA = 0.85   # <1 lifts faint edges so fine patterns still register

# EVERY MAP IS THEN SCALED TO THE SAME MEAN ABSOLUTE DEVIATION FROM 128, and this
# is the fix for the owner's second review on 2026-08-27: Chantilly's outlines
# were "too inky" and Cassini was "not defined enough". Both complaints were the
# same number. Native MAD across the set ran Cassini 13.6 to Chantilly 29.4, a
# 2.2x spread, because MAD measures how much of the pane gets shaded and by how
# much -- a dense floral has edges everywhere and a soft pebble pattern barely
# any. Normalising on standard deviation was tried first and barely moved either,
# because spread is not coverage. 21 is a little under the set median of 22.5, so
# Cassini gains ~55% definition, Chantilly loses ~30% of its ink, and the dozen
# textures already near the median move less than a tenth.

# The clear mask runs between these percentiles of the texture's own luminance,
# so a flat pattern and a contrasty one both end up with a comparable share of
# the pane readable. A fixed 0-255 window put Contora at 4% clear and Chantilly
# at 61%, which is the same fault the Cassini vignette had: absolute numbers on
# photographs that were not lit the same way.
RIM_TARGET_MAD = 21.0

CLEAR_LO_PCT = 58.0
CLEAR_HI_PCT = 80.0


# Textures that also get a FACET DISPLACEMENT MAP. Opt-in per texture, because it
# only makes sense where the glass is genuinely made of discrete lenses. Cassini
# is the worked example: the owner pointed at Pilkington's own photograph, where
# every petal carries its own displaced sample of the room behind it -- green from
# the window in one, pink from the cushion in the next -- with hard edges between.
# Blur variation cannot produce that no matter how it is tuned, because blur does
# not MOVE anything. Roll it out to another texture by adding its filename here
# and a `facet` key in `obscure_glass`.
FACET_SOURCES = {
    "Cassini-privacy-5-rev4.webp": 8,   # value = how many facet bands
}


def facet_map(grey: Image.Image, bands: int) -> Image.Image:
    """Per-facet displacement, encoded R = x shift, G = y shift, 128 = no shift.

    QUANTISED ON PURPOSE. A smooth gradient of the photograph was tried first and
    rendered as heat haze: continuous displacement smears the scene instead of
    breaking it into lenses. Real Cassini is discrete facets with hard edges, so
    the map is quantised into bands on the texture's own luminance and each band
    is pushed a fixed distance in its own direction around a circle. The step
    between bands lands exactly on the pattern's own boundaries, which is what
    gives the hard edge, and neighbouring facets then sample genuinely different
    parts of the scene.
    """
    a = np.asarray(grey.filter(ImageFilter.GaussianBlur(2.5)), dtype=float)
    cuts = np.percentile(a, np.linspace(0, 100, bands + 1))
    level = np.clip(np.digitize(a, cuts[1:-1]), 0, bands - 1)
    theta = np.linspace(0, 2 * np.pi, bands, endpoint=False) + 0.6
    dx = np.cos(theta)[level]
    dy = np.sin(theta)[level]
    r = np.clip(128 + dx * 115, 0, 255)
    g = np.clip(128 + dy * 115, 0, 255)
    b = np.full_like(r, 128.0)
    return Image.fromarray(np.dstack([r, g, b]).astype(np.uint8), "RGB")


def rim_map(grey: Image.Image) -> Image.Image:
    """Edge shading, centred on 128 so `soft-light` leaves flat areas alone."""
    a = np.asarray(grey.filter(ImageFilter.GaussianBlur(1.2)), dtype=float)
    gy, gx = np.gradient(a)
    mag = np.hypot(gx, gy)
    # Normalise on a high percentile rather than the max: one dust speck or one
    # compression artefact owns the max and flattens everything else to nothing.
    mag = np.clip(mag / max(float(np.percentile(mag, 99.3)), 1e-6), 0.0, 1.0) ** RIM_GAMMA
    gxn = gx / max(float(np.abs(gx).max()), 1e-6)
    gyn = gy / max(float(np.abs(gy).max()), 1e-6)
    lit = 0.7 * gxn + 0.7 * gyn
    lit = lit / max(float(np.percentile(np.abs(lit), 99.0)), 1e-6)
    out = 128.0 + RIM_LIGHT * np.clip(lit, -1.0, 1.0) * mag - RIM_SHADE * mag
    native = float(np.abs(out - 128.0).mean())
    out = 128.0 + (out - 128.0) * (RIM_TARGET_MAD / max(native, 1e-6))
    return Image.fromarray(np.clip(out, 0, 255).astype(np.uint8)), native


def clear_map(grey: Image.Image) -> Image.Image:
    """Alpha-only mask marking the see-through parts of the pattern.

    Alpha rather than a luminance mask on purpose. `mask-mode: luminance` needs a
    recent browser and its failure mode is the worst one available: the mask
    reads as fully opaque, the clear layer shows everywhere, and a privacy 5
    glass renders see-through. A plain alpha mask works in every browser
    `-webkit-mask-image` does.
    """
    a = np.asarray(grey, dtype=float)
    lo = float(np.percentile(a, CLEAR_LO_PCT))
    hi = float(np.percentile(a, CLEAR_HI_PCT))
    m = np.clip((a - lo) / max(hi - lo, 1e-6), 0.0, 1.0)
    rgba = np.zeros(a.shape + (4,), dtype=np.uint8)
    rgba[..., :3] = 255
    rgba[..., 3] = (m * 255).astype(np.uint8)
    return Image.fromarray(rgba)


def derive_cassini() -> None:
    """Cassini rev4: flatten the lighting, then put the pattern contrast back.

    The photograph is a 150mm sample lit from one side. Its illumination ran 105
    at the top to 192 in the middle and 198 left to 113 right -- a low-frequency
    spread of 143 levels where the set's median is 49, the worst in the set. The
    lit dome read as clear glass, the vignetted edges read as black, and tiled it
    put a dark band down the pane.

    rev3 fixed that and overshot the other way: gain 0.55 dropped the pattern to
    stddev 18 and the pebbles stopped reading. rev4 keeps the flat field and
    restores the contrast at gain 0.90, which is what option F2 was tuned and
    approved against.

    THE CHECK THAT CATCHES THIS CLASS OF FAULT is the low-frequency spread --
    blur hard, measure max minus min. Not mean and stddev: rev2 measured mean 158
    stddev 46, both inside the set, and was still wrong.
    """
    src = GLASS / "Cassini-privacy-5-rev2.webp"
    dst = GLASS / "Cassini-privacy-5-rev4.webp"
    grey = Image.open(src).convert("L")
    a = np.asarray(grey, dtype=float)
    illum = np.asarray(grey.filter(ImageFilter.GaussianBlur(50)), dtype=float)
    flat = a / np.maximum(illum, 1e-6)
    flat = flat / flat.mean()
    out = np.clip((1.0 + (flat - 1.0) * 0.90) * 196.0, 0, 255)
    im = Image.fromarray(out.astype(np.uint8))
    im.save(dst, "WEBP", quality=90, method=6)
    blurred = np.asarray(im.filter(ImageFilter.GaussianBlur(60)), dtype=float)
    print(f"  {dst.name}: mean {out.mean():.0f} sd {out.std():.1f} "
          f"low-freq spread {blurred.max() - blurred.min():.0f} (rev2 was 143, set median 49)")


def derive_reeded() -> None:
    """Reeded, flat-fielded and mirrored so it tiles with no seam at all.

    Reeded is the one texture whose pinned scale genuinely matters -- a rib has a
    real width, and at `cover` it renders about five times too fat -- so it keeps
    its pin and needs a real seamless fix rather than being handed to `cover`
    like the other three.

    IT TURNED OUT TO HAVE THE SAME FAULT AS CASSINI. Low-frequency spread 130
    against a set median of 49, left edge 148 and right edge 100: photographed
    lit from one side. That is why cropping to a whole number of ribs only got
    the seam from 125 to 55 -- the rib PHASE was never the problem, the
    illumination was. Two of twenty textures now, so check the spread before
    assuming a repeat is a phase problem.

    Flat-field first, then mirror. Mirroring is the wrong tool for Cassini --
    pebbles go kaleidoscopic and you can see it -- but ribs are near-identical to
    their own reflection, so here it is invisible and gives an exactly zero seam
    rather than an approximately zero one. No cross-fade, so no ghosting.

    Vertically there is nothing to fix: the pin is `<n>px 100%`, so the height is
    stretched to the pane and it never repeats down the frame.
    """
    src = GLASS / "Reeded-privacy-2.webp"
    dst = GLASS / "Reeded-privacy-2-seamless.webp"
    im = Image.open(src).convert("L")
    a = np.asarray(im, dtype=float)

    illum = np.asarray(im.filter(ImageFilter.GaussianBlur(40)), dtype=float)
    flat = a / np.maximum(illum, 1e-6)
    flat = flat / flat.mean()
    levelled = Image.fromarray(np.clip(flat * a.mean(), 0, 255).astype(np.uint8))

    # THE MIRROR IS FOR THE STAGE AND ONLY THE STAGE, and that distinction cost a
    # review round. Seamlessness is a property of TILING, and the stage is the
    # only surface that tiles -- swatches, the hero wall and the glass card each
    # paint one instance at `cover`. Handing them the mirrored tile squeezed all
    # 1800px into a 58px swatch with the mirror axis dead centre, and the ribs
    # fan slightly, so it read as a bold chevron. The owner's words: "reeded
    # looks good but the thumbnail for it doesnt". So two assets: the levelled
    # photograph for anything that displays it, the mirrored one for the tile.
    # LIFTED TOWARDS THE SET, owner instruction 2026-08-27. This copy is only ever
    # shown as a portrait -- a 58px swatch, a wall tile, a card panel -- next to
    # nineteen others, and Reeded is the second-darkest source in the set at mean
    # 118.5 against 148.6. It read as the one near-black square in a pale column.
    # The TILE is untouched, so the pane the owner approved does not move; that is
    # the whole reason the two are separate assets.
    disp = np.asarray(levelled, dtype=float)
    disp = 148.0 + (disp - disp.mean()) * 0.82
    Image.fromarray(np.clip(disp, 0, 255).astype(np.uint8)).save(
        GLASS / "Reeded-privacy-2-levelled.webp", "WEBP", quality=90, method=6)
    print(f"    display copy lifted to mean {np.clip(disp,0,255).mean():.1f} "
          f"(set mean 148.6), tile left alone")

    mirrored = Image.new("L", (levelled.width * 2, levelled.height))
    mirrored.paste(levelled, (0, 0))
    mirrored.paste(ImageOps.mirror(levelled), (levelled.width, 0))
    mirrored.save(dst, "WEBP", quality=90, method=6)

    m = np.asarray(mirrored, dtype=float)
    before = float(abs(a[:, :8].mean() - a[:, -8:].mean()))
    blurred = np.asarray(mirrored.filter(ImageFilter.GaussianBlur(60)), dtype=float)
    print(f"  Reeded-privacy-2-levelled.webp: the display copy, {levelled.width}px, not mirrored")
    print(f"  {dst.name}: {im.width} -> {mirrored.width}px, "
          f"seam {before:.1f} -> {abs(m[:, :8].mean() - m[:, -8:].mean()):.2f}, "
          f"low-freq spread {blurred.max() - blurred.min():.0f} (was 130)")
    print("    the tile doubled in width, so the pin doubles too -- 360px, not")
    print("    180px -- or every rib renders twice as wide as it does today")


def main() -> None:
    MAPS.mkdir(parents=True, exist_ok=True)

    print("Deriving corrected source textures:")
    derive_cassini()
    derive_reeded()
    print()

    missing = [s for s in SOURCES if not (GLASS / s).exists()]
    if missing:
        raise SystemExit("missing source textures: " + ", ".join(missing))

    total = 0
    print(f"{'texture':<34}{'native MAD':>10}{'clear %':>9}{'bytes':>10}")
    print(f"{'':<34}{'(all scaled to ' + str(RIM_TARGET_MAD) + ')':>10}")
    for name in SOURCES:
        grey = Image.open(GLASS / name).convert("L")
        if grey.width > MAP_MAX_WIDTH:
            grey = grey.resize(
                (MAP_MAX_WIDTH, round(grey.height * MAP_MAX_WIDTH / grey.width)),
                Image.LANCZOS,
            )
        stem = Path(name).stem

        rim, native_mad = rim_map(grey)
        rim_path = MAPS / f"{stem}-rim.webp"
        rim.save(rim_path, "WEBP", quality=MAP_QUALITY, method=6)

        clear = clear_map(grey)
        clear_path = MAPS / f"{stem}-clear.webp"
        clear.save(clear_path, "WEBP", quality=MAP_QUALITY, method=6, exact=True)

        if name in FACET_SOURCES:
            facet_map(grey, FACET_SOURCES[name]).save(
                MAPS / f"{stem}-facet.webp", "WEBP", quality=MAP_QUALITY, method=6)

        size = rim_path.stat().st_size + clear_path.stat().st_size
        total += size
        share = (np.asarray(clear)[..., 3] > 127).mean() * 100
        print(f"{stem:<34}{native_mad:>8.1f}{share:>8.0f}%{size:>10,}")

    print(f"\n{len(SOURCES)} textures, {total:,} bytes of maps.")
    print("Only the SELECTED pattern's pair is ever fetched -- they are set as")
    print("custom properties on the stage, not preloaded with the picker.")


if __name__ == "__main__":
    main()
