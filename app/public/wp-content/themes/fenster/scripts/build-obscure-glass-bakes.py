#!/usr/bin/env python3
"""Bake the obscured-glass stage: one image per texture per scene.

Run from the theme directory:

    python3 scripts/build-obscure-glass-bakes.py

WHY THIS REPLACED LIVE COMPOSITING. The stage used to build the obscured half in
the browser: a blurred scene, a second copy showing through a mask, the pattern's
edges shaded on top, and latterly an `feDisplacementMap`. Four rounds of tuning
never reached the reference, and the reason is structural rather than a setting.

In Pilkington's own photograph every facet is a FLAT WASH of one tone with a hard
edge to the next, because a lens averages what it magnifies down to almost a
single colour. `feDisplacementMap` moves pixels; it does not average within a
region. So a displaced photograph keeps its internal gradients and reads as a
smear, at every scale that was tried -- below about 16 the pattern vanishes into
plain blur, above it the facets smear, and nothing sits between.

Averaging per facet is trivial offline and impossible in a CSS filter. And the
obscured half is a static composite of one texture over one of two fixed scenes,
so there was never a reason to compute it per visit.

WHAT THE OWNER RULED OUT ALONG THE WAY, so nobody re-tests them:
  - the aspect stretch. Rebuilt with preserveAspectRatio="xMidYMid slice" and it
    looked worse, blobbier and muddier.
  - the displacement scale. Seven values rendered; see above.
  - the rim map as a source of shine. It cannot brighten -- its shade term
    exceeds its light term everywhere, so it never rises above 128.
  - the scene being too smooth to bend. Measured: ours carries MORE local
    contrast at petal scale than the reference's room, 21.1 against 16.5.

THE COST, stated plainly: the effect is fixed to the scenes baked here. Adding a
third scene means re-running this, not editing a stylesheet.
"""

import numpy as np
from PIL import Image, ImageFilter
from pathlib import Path

THEME = Path(".")
GLASS = THEME / "assets/images/products/obscure-glass"

# Bump when the recipe changes. Bakes are emitted through `fenster_generated_url()`
# like any theme image, so they carry no version string and rewriting one in place
# leaves the reviewer's browser serving the old bytes.
BAKE_REVISION = "b1"
OUT = GLASS / "baked" / BAKE_REVISION

# The stage is `aspect-ratio: 4 / 3` capped at 900px wide, so this is its exact
# desktop size. Mobile drops to a free height and takes `cover`, which crops
# rather than distorts.
W, H = 900, 675

SCENES = {
    "house": (GLASS / "birkacre-house.webp", "cover"),
    # The cat is drawn `contain` on the live stage, so it is letterboxed here on
    # the viewport's own background colour rather than cropped.
    "cat": (THEME / "assets/team/legend-colour.webp", "contain"),
}
VIEWPORT_BG = (205, 218, 219)  # #cddadb, the stage's own backdrop

# name -> (texture file or None for a CSS-gradient pattern, privacy, css size)
# Mirrors `obscure_glass` in inc/site-data.php. A texture with no file is a flat
# etched frost with no facets to average, so it bakes as blur plus frost.
TEXTURES = [
    ("Cotswold", "Cotswold-pilkington.png", 5, "cover"),
    ("Satin", None, 5, "cover"),
    ("Arctic", "Arctic-privacy-5.webp", 5, "cover"),
    ("Autumn", "Autumn-privacy-3.webp", 3, "cover"),
    ("Cassini", "Cassini-privacy-5-rev4.webp", 5, "cover"),
    ("Chantilly", "Chantilly-privacy-2.webp", 2, "cover"),
    ("Charcoal Sticks", "Charcoal-Sticks-privacy-4.webp", 4, "cover"),
    ("Contora", "Contora-privacy-4.webp", 4, "cover"),
    ("Digital", "Digital-privacy-3.webp", 3, "cover"),
    ("Everglade", "Everglade-privacy-5.webp", 5, "cover"),
    ("Florielle", "Florielle-privacy-4.webp", 4, "cover"),
    ("Mayflower", "Mayflower-privacy-4.webp", 4, "cover"),
    ("Minster", "Minster-privacy-2.webp", 2, "cover"),
    ("Oak", "Oak-privacy-4.webp", 4, "cover"),
    ("Pelerine", "Pelerine-privacy-4.webp", 4, "cover"),
    ("Reeded", "Reeded-privacy-2-seamless.webp", 2, "360px 100%"),
    ("Stippolyte", "Stippolyte-privacy-4.webp", 4, "cover"),
    ("Sycamore", "Sycamore-privacy-2.webp", 2, "cover"),
    ("Taffeta", "Taffeta-privacy-3.webp", 3, "cover"),
    ("Tribal", "Tribal-privacy-5.webp", 5, "cover"),
    ("Warwick", "Warwick-privacy-0.webp", 1, "cover"),
]

# SEGMENTATION SETTINGS, and the mode filter is the one that matters. Quantising
# straight off the photograph splits it into thousands of speckled fragments and
# the bake reads as noise rather than glass; a mode filter merges each fragment
# into its neighbours and leaves coherent facets. 14 bands with no filtering was
# tried first and is what that noise looked like.
BANDS = 8
PRE_BLUR = 4.0      # smooths the photograph before banding, so facets are whole
MODE_FILTER = 9     # despeckles the band map into contiguous regions
OFFSET_RADIUS = 34  # how far each band samples from, in output pixels
QUALITY = 78


def slug(name: str) -> str:
    return name.lower().replace(" ", "-")


def fit(im: Image.Image, mode: str) -> Image.Image:
    """`cover` crops to fill; `contain` letterboxes on the viewport colour."""
    if mode == "contain":
        s = min(W / im.width, H / im.height)
        r = im.resize((max(1, round(im.width * s)), max(1, round(im.height * s))), Image.LANCZOS)
        out = Image.new("RGB", (W, H), VIEWPORT_BG)
        out.paste(r, ((W - r.width) // 2, (H - r.height) // 2))
        return out
    s = max(W / im.width, H / im.height)
    r = im.resize((max(1, round(im.width * s)), max(1, round(im.height * s))), Image.LANCZOS)
    l, t = (r.width - W) // 2, (r.height - H) // 2
    return r.crop((l, t, l + W, t + H))


def lay_texture(path: Path, css_size: str) -> np.ndarray:
    """Paint the texture across the canvas the way the stylesheet would.

    Only the two forms the data actually uses are handled -- `cover`, and a pinned
    `<n>px <n>px|auto|100%` that tiles. Anything else should fail loudly rather
    than silently render at the wrong scale, which is how Reeded once shipped
    with ribs five times too fat.
    """
    im = Image.open(path).convert("L")
    if css_size == "cover":
        return np.asarray(fit(im, "cover"), dtype=float)

    parts = css_size.split()
    if len(parts) != 2 or not parts[0].endswith("px"):
        raise SystemExit(f"unhandled background-size {css_size!r}")
    tw = int(parts[0][:-2])
    th = H if parts[1] in ("100%", "auto") and parts[1] == "100%" else round(im.height * tw / im.width)
    tile = im.resize((tw, th), Image.LANCZOS)
    out = Image.new("L", (W, H))
    for y in range(0, H, th):
        for x in range(0, W, tw):
            out.paste(tile, (x, y))
    return np.asarray(out, dtype=float)


def bake(scene, tex, privacy):
    """One texture over one scene.

    Each facet shows a flat wash: the scene sampled from somewhere else and
    averaged down, which is what a lens does and what the live filter could not.
    """
    # Privacy drives how completely each facet averages, and how much etched
    # frost sits over the whole pane. On the live stage this used to drive
    # opacity across a 12% range, which is why privacy 2 and 5 looked identical.
    wash_blur = 5.0 + privacy * 2.2
    frost = 0.10 + privacy * 0.028

    if tex is None:
        out = np.asarray(
            Image.fromarray(scene.astype(np.uint8)).filter(ImageFilter.GaussianBlur(wash_blur * 1.9)),
            dtype=float,
        )
        return Image.fromarray(
            np.clip(out * (1 - frost * 1.5) + 255 * frost * 1.5, 0, 255).astype(np.uint8))

    smooth = np.asarray(
        Image.fromarray(tex.astype(np.uint8)).filter(ImageFilter.GaussianBlur(PRE_BLUR)), dtype=float)
    cuts = np.percentile(smooth, np.linspace(0, 100, BANDS + 1))
    level = np.clip(np.digitize(smooth, cuts[1:-1]), 0, BANDS - 1).astype(np.uint8)
    level = np.asarray(Image.fromarray(level).filter(ImageFilter.ModeFilter(MODE_FILTER)))

    # Offsets walk around a circle in a stride that keeps neighbouring bands far
    # apart, so two facets that touch rarely sample the same place.
    theta = (np.arange(BANDS) * 5 % BANDS) / BANDS * 2 * np.pi
    pad = OFFSET_RADIUS + 2
    out = np.zeros_like(scene)
    for k in range(BANDS):
        dy = int(round(np.sin(theta[k]) * OFFSET_RADIUS))
        dx = int(round(np.cos(theta[k]) * OFFSET_RADIUS))
        # Edge-replicated rather than wrapped. `np.roll` brings the far side of
        # the photograph round to the near one, so a facet near the top could
        # show the dark pond from the bottom -- it landed as a black blotch in
        # the corner of several bakes before this.
        shifted = np.pad(scene, ((pad, pad), (pad, pad), (0, 0)), mode="edge")
        shifted = shifted[pad - dy:pad - dy + H, pad - dx:pad - dx + W]
        wash = np.asarray(
            Image.fromarray(shifted.astype(np.uint8)).filter(ImageFilter.GaussianBlur(wash_blur)),
            dtype=float)
        out = np.where((level == k)[..., None], wash, out)

    # The etched boundary. A dark line with a light one just inside it is what
    # makes a facet read as a piece of glass rather than a flat colour patch.
    edge = np.zeros((H, W), dtype=bool)
    edge[:, :-1] |= level[:, :-1] != level[:, 1:]
    edge[:-1, :] |= level[:-1, :] != level[1:, :]
    e = np.asarray(
        Image.fromarray((edge * 255).astype(np.uint8)).filter(ImageFilter.GaussianBlur(0.8)),
        dtype=float) / 255.0
    out = out * (1 - 0.30 * e[..., None]) + 255 * 0.20 * e[..., None]

    # A whisper of the photograph itself, so the surface keeps its grain.
    grain = (tex - tex.mean()) * 0.10
    out = out + grain[..., None]

    return Image.fromarray(np.clip(out * (1 - frost) + 255 * frost, 0, 255).astype(np.uint8))


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    scenes = {k: np.asarray(fit(Image.open(p).convert("RGB"), m), dtype=float)
              for k, (p, m) in SCENES.items()}

    total = 0
    print(f"{'texture':<18}{'privacy':>8}{'house':>10}{'cat':>10}")
    for name, fn, privacy, css in TEXTURES:
        tex = lay_texture(GLASS / fn, css) if fn else None
        sizes = []
        for scene_key, scene in scenes.items():
            img = bake(scene, tex, privacy)
            path = OUT / f"{slug(name)}--{scene_key}.webp"
            img.save(path, "WEBP", quality=QUALITY, method=6)
            sizes.append(path.stat().st_size)
            total += path.stat().st_size
        print(f"{name:<18}{privacy:>8}{sizes[0]:>9,}{sizes[1]:>10,}")

    print(f"\n{len(TEXTURES) * 2} bakes, {total:,} bytes at {W}x{H}.")
    print("One is fetched per pattern per background, not the set.")


if __name__ == "__main__":
    main()
