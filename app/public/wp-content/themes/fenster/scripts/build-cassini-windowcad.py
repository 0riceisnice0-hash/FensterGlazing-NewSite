#!/usr/bin/env python3
"""Build Cassini's plate from the WindowCAD designer's own render.

Run from the theme directory:

    python3 scripts/build-cassini-windowcad.py
    python3 scripts/build-cassini-seamless.py \
        assets/images/products/obscure-glass/Cassini-privacy-5-wcad-flat.webp \
        assets/images/products/obscure-glass/Cassini-privacy-5-wcad-tile.webp

WHY THIS EXISTS. The owner, 2026-08-30: "currently its opacity is ok but the
pattern is completely wrong." It was. Every earlier plate came from a
photograph of a sample held to the light, and what those photographs gave us
was a mat of ROUNDED PEBBLES PACKED EDGE TO EDGE. Real Cassini is not that. It
is POINTED, OVERLAPPING LEAVES floating over a ruled hatch, and the hatch runs
in large straight-edged angular sectors rather than one direction. Pallot's own
`Textured-Cassini_5.jpg` shows the same leaves, which is what corroborates the
source: three images, two of them independent of us, agree with each other and
disagree with the plate we were shipping.

THE SOURCE IS A SCREEN RECORDING OF THE QUOTE TOOL, and that is a better
reference than a photograph even though it is synthetic. It is evenly rendered,
in focus everywhere, at high resolution, and it carries no torch falloff, no
hand shake and no perspective on the pattern itself. `PROGRESS.md` records four
separate rounds lost to measuring a badly lit photograph; this has none of
those problems.

THE BLUE TINT IN THE RECORDING IS NOT THE GLASS. It is the quote tool's
toughened-glass indicator. Owner instruction: ignore it. Everything here works
on luminance only, so the tint never reaches the plate.

WHAT THIS DOES NOT DO, and the reason is worth keeping. It does NOT rectify
perspective. The first pass measured the vertical hatch pitch running 6.5px on
the left to 5.0px on the right and read it as the pane receding, and a whole
horizontal rectification was nearly built for it. Measured properly -- 512px
windows, sub-bin parabolic peak fit rather than the raw FFT bin -- the scale is
CONSTANT to within 4% across x=500..1550, and the apparent gradient was the
HATCH ANGLE changing between sectors: a sector whose lines run closer to
horizontal shows a wider vertical pitch at the same true pitch. The crop is
taken inside that constant band. **If this crop is ever moved, re-measure
before assuming the scale is flat**, and do not reintroduce a rectification
without evidence that survives sub-bin fitting.

LIGHTING IS REMOVED BY LOCAL CONTRAST NORMALISATION, not by flat-fielding.
Dividing by a heavy blur only took the coarse spread from 124 to about 75
because the render's lighting varies in CONTRAST as well as in brightness --
the specular sweep flattens the pattern where it lands. Subtracting the local
mean and dividing by the local standard deviation fixes both, and lands at 11
against the previous plate's 15, measured at a scale coarser than one leaf.

A NOTE ON MEASURING THAT COST TIME: the first version of this computed the
local variance with a PIL Gaussian blur, which round-trips through uint8. The
squared deviations saturate at 255 and the variance is silently wrong; the tell
was an output whose global standard deviation came back at 52 when the
normalisation had been asked for 21.5. The blurs here are `scipy.ndimage`
float. **If a normalisation ever reports a standard deviation it was not
asked for, suspect the blur before the maths.**

SCALE IS MATCHED TO WHAT THE OWNER ALREADY APPROVED. The complaint was the
pattern, not the size, so the tile is cut so that a leaf lands at about 62px on
the stage against the old plate's 64px, with the material's `texSize` pin
unchanged. Leaf period is measured by radial autocorrelation of a band-passed
copy, which is what stops the hatch dominating the answer.

If this file changes, RENAME THE OUTPUTS. Theme images carry no version string,
so replacing one in place leaves browsers and the proxy serving the old bytes.
"""

import sys
from pathlib import Path

import numpy as np
from PIL import Image
from scipy.ndimage import gaussian_filter

REF = Path("scripts/reference-cassini-windowcad.png")
GLASS = Path("assets/images/products/obscure-glass")
FLAT = GLASS / "Cassini-privacy-5-wcad-flat.webp"
SHOW = GLASS / "Cassini-privacy-5-wcad.webp"

# Matched to the plate this replaces so the renderer's luminance-keyed oval
# thresholds start from the same place.
TARGET_MEAN = 158.0
TARGET_STD = 21.5
# The display copy keeps its modelling, so it keeps the wider spread the old
# display plate had. A flat-fielded plate looks flat when it is merely shown.
SHOW_MEAN = 158.0
SHOW_STD = 46.0

SHOW_WIDTH = 760
SHOW_QUALITY = 72

LCN_SIGMA = 200.0
LCN_FLOOR = 10.0


def lcn(a: np.ndarray, sigma: float, floor: float, mean: float, std: float) -> np.ndarray:
    """Local contrast normalisation. Float blurs -- see the docstring."""
    mu = gaussian_filter(a, sigma, mode="reflect")
    var = gaussian_filter((a - mu) ** 2, sigma, mode="reflect")
    sd = np.maximum(np.sqrt(np.maximum(var, 1e-6)), floor)
    return np.clip((a - mu) / sd * std + mean, 0.0, 255.0)


def leaf_period(a: np.ndarray) -> int:
    """Dominant LEAF scale, with the hatch banded out so it cannot dominate."""
    s = gaussian_filter(a, 4) - gaussian_filter(a, 40)
    d = s - s.mean()
    f = np.fft.fft2(d)
    ac = np.real(np.fft.ifft2(f * np.conj(f)))
    ac /= ac[0, 0]
    h, w = ac.shape
    prof = []
    for r in range(1, min(h, w) // 2):
        th = np.linspace(0, 2 * np.pi, 180, endpoint=False)
        ys = (np.round(r * np.sin(th)).astype(int)) % h
        xs = (np.round(r * np.cos(th)).astype(int)) % w
        prof.append(ac[ys, xs].mean())
    prof = np.array(prof)
    z = next((i for i in range(1, len(prof)) if prof[i] <= 0), None)
    return 2 * (z + 1) if z else 0


def coarse_spread(a: np.ndarray) -> float:
    """Lighting evenness, sampled COARSER than one leaf so it is not signal."""
    im = Image.fromarray(np.clip(a, 0, 255).astype(np.uint8)).resize((6, 6), Image.BILINEAR)
    s = np.asarray(im, dtype=float)
    return float(s.max() - s.min())


def main() -> None:
    if not REF.exists():
        sys.exit(f"missing {REF} -- see the docstring for how it was cut")
    a = np.asarray(Image.open(REF).convert("L"), dtype=float)
    print(f"  reference {a.shape[1]}x{a.shape[0]}")
    print(f"    before: mean {a.mean():5.1f} std {a.std():5.1f} "
          f"coarse spread {coarse_spread(a):5.1f}")

    flat = lcn(a, LCN_SIGMA, LCN_FLOOR, TARGET_MEAN, TARGET_STD)
    per = leaf_period(flat)
    print(f"    flat:   mean {flat.mean():5.1f} std {flat.std():5.1f} "
          f"coarse spread {coarse_spread(flat):5.1f}")
    print(f"    leaf period {per}px -> {a.shape[1] / per:.1f} leaves across the plate")
    clipped = float(((flat <= 0) | (flat >= 255)).mean() * 100)
    print(f"    clipped {clipped:.2f}%  (a normalisation that clips is losing structure)")

    Image.fromarray(flat.astype(np.uint8)).save(FLAT, "WEBP", quality=95, method=6)
    print(f"  wrote {FLAT.name}")

    # The display copy is only ever LOOKED at -- swatches and the CSS layer at
    # 500px -- so it is sized and compressed for weight, unlike the tile. It is
    # also the eager one: every pattern's display image loads with the page,
    # while a tile is fetched only when its pattern is picked.
    show = lcn(a, LCN_SIGMA * 1.6, LCN_FLOOR, SHOW_MEAN, SHOW_STD)
    show_im = Image.fromarray(show.astype(np.uint8)).convert("RGB")
    show_im = show_im.resize(
        (SHOW_WIDTH, round(SHOW_WIDTH * show_im.size[1] / show_im.size[0])),
        Image.LANCZOS)
    show_im.save(SHOW, "WEBP", quality=SHOW_QUALITY, method=6)
    print(f"    show:   mean {show.mean():5.1f} std {show.std():5.1f} "
          f"coarse spread {coarse_spread(show):5.1f}")
    print(f"  wrote {SHOW.name}")


if __name__ == "__main__":
    main()
