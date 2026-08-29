#!/usr/bin/env python3
"""Build Cassini's plate with its SHAPES traced from the clock photograph.

Run from the theme directory:

    python3 scripts/build-cassini-clock.py
    python3 scripts/build-cassini-seamless.py \
        assets/images/products/obscure-glass/Cassini-privacy-5-clock-flat.webp \
        assets/images/products/obscure-glass/Cassini-privacy-5-clock-tile.webp 0 100

WHY THIS REPLACES THE WINDOWCAD PLATE FOR SHAPE. Owner, 2026-08-30, after the
WindowCAD rebuild landed: "texture and opacity are good now. you need to exactly
copy the shapes and layout from the clock image though." Put the two sources
side by side at MATCHED LEAF SCALE and the reason is obvious, which is the
comparison anyone revisiting this should make first:

  the clock (real glass)   POINTED TEARDROPS -- a broad rounded lobe tapering
                           to a definite point -- densely packed, heavily
                           overlapping, in rosette clusters, every one carrying
                           a strong dome shade dark on one edge and bright on
                           the other. Many sizes, from tiny to large.

  WindowCAD (synthetic)    ROUNDED BLOBS. No point, no taper, no dome, sparser,
                           and far more uniform in size.

WindowCAD's render is an approximation of Cassini, not a photograph of it, and
that is the whole finding. Its shapes are an interpretation. The clock is a
photograph of the real sheet, so the plate comes from there instead -- hatch
included, see below.

THE SCENE IS REMOVED BY LOCAL CONTRAST NORMALISATION, AND THE METHOD MATTERS
MORE THAN IT SOUNDS. Two approaches were tried and the first was wrong in a way
that is easy to repeat. Segmenting petals on local hatch energy -- petals are
smooth, the ground is hatched -- gave a mask too noisy to call a trace. Then a
BAND-PASS, `gaussian(2) - gaussian(30)`, which looked right in isolation and
was not: subtracting a wide blur puts a halo either side of every hard step, so
the teardrops came out as SOFT GREY BLOBS with their outlines gone. That is the
one thing this asset exists to carry, and the plate was measurably worse than
the photograph it came from. **Never band-pass something whose edges are the
point.**

LCN keeps them. Divide by the LOCAL standard deviation instead of subtracting a
blur and the hard boundary survives, because normalising a step leaves it a
step. Measured as mean gradient magnitude: the photograph is 32.6, LCN at
sigma 40 keeps 18.3, the band-pass version 11. Checked by eye against the
photograph as well, which is where the blobs were obvious.

THE HATCH COMES FROM THE CLOCK TOO, and that is a change from the WindowCAD
plate. LCN preserves it, so the real sheet's own hatch is already in the plate
at the real hatch-to-leaf ratio of 21.8 -- WindowCAD's was 16.0, coarser than
the sheet. Adding WindowCAD's hatch on top would lay a second hatch over the
real one. The owner approved the TEXTURE as it reads on the page, and this
carries the same fine sectored ruled character because it is what WindowCAD was
approximating.

THE BANNER. Pallot overlay a green "NEW" triangle across the top-left corner.
The crop starts at x=170 to clear it completely rather than inpainting it,
because inpainting would be inventing layout on the one asset whose whole
purpose is that the layout is real.

WHAT THIS COSTS, and it is the honest trade. 800x533 is the largest copy of that
photograph in existence -- every smaller WordPress variant 404s -- so after the
banner crop and the seam cut there are about 5.9 x 4.8 leaves of real layout.
The pane holds more than that, so the tile REPEATS where the old plate did not.
That is the price of using the real thing at this resolution, and it is a
deliberate trade rather than an oversight.

If this file changes, RENAME THE OUTPUTS. Theme images carry no version string.
"""

import sys
from pathlib import Path

import numpy as np
from PIL import Image
from scipy.ndimage import gaussian_filter

CLOCK = Path("scripts/reference-cassini-clock.png")
GLASS = Path("assets/images/products/obscure-glass")
FLAT = GLASS / "Cassini-privacy-5-clock-flat.webp"
SHOW = GLASS / "Cassini-privacy-5-clock.webp"

LCN_SIGMA = 40.0                  # removes the clock, keeps the teardrops
LCN_FLOOR = 6.0

TARGET_MEAN = 158.0
TARGET_STD = 21.5
SHOW_MEAN = 158.0
SHOW_STD = 46.0
SHOW_WIDTH = 700
SHOW_QUALITY = 74


def norm(a: np.ndarray) -> np.ndarray:
    return (a - a.mean()) / max(a.std(), 1e-6)


def lcn(a: np.ndarray, sigma: float, floor: float) -> np.ndarray:
    """Scene removal that PRESERVES EDGES. See the docstring before changing."""
    mu = gaussian_filter(a, sigma, mode="reflect")
    var = gaussian_filter((a - mu) ** 2, sigma, mode="reflect")
    sd = np.maximum(np.sqrt(np.maximum(var, 1e-6)), floor)
    return (a - mu) / sd


def crispness(a: np.ndarray) -> float:
    """Mean gradient magnitude -- how hard the petal outlines still are."""
    return float((np.abs(np.diff(a, axis=1)).mean() + np.abs(np.diff(a, axis=0)).mean()) / 2)


def leaf_period(a: np.ndarray) -> int:
    s = gaussian_filter(a, 3) - gaussian_filter(a, 35)
    d = s - s.mean()
    f = np.fft.fft2(d)
    ac = np.real(np.fft.ifft2(f * np.conj(f)))
    ac /= ac[0, 0]
    h, w = ac.shape
    prof = []
    for r in range(1, min(h, w) // 2):
        th = np.linspace(0, 2 * np.pi, 180, endpoint=False)
        prof.append(ac[(np.round(r * np.sin(th)).astype(int)) % h,
                       (np.round(r * np.cos(th)).astype(int)) % w].mean())
    prof = np.array(prof)
    z = next((i for i in range(1, len(prof)) if prof[i] <= 0), None)
    return 2 * (z + 1) if z else 0


def main() -> None:
    if not CLOCK.exists():
        sys.exit(f"missing {CLOCK}")
    clock = np.asarray(Image.open(CLOCK).convert("L"), dtype=float)
    h, w = clock.shape
    print(f"  clock reference {w}x{h}  (banner already cropped off)")

    plate = np.clip(norm(lcn(clock, LCN_SIGMA, LCN_FLOOR)) * TARGET_STD + TARGET_MEAN, 0, 255)
    print(f"    outline crispness {crispness(plate):5.2f} against the photograph's "
          f"{crispness(clock):5.2f}  (a band-pass scored 11 and lost the teardrops)")

    per = leaf_period(plate)
    print(f"    leaf period {per}px -> {w / per:.1f} leaves across the plate")
    print(f"    mean {plate.mean():5.1f}  std {plate.std():5.1f}  "
          f"clipped {(((plate <= 0) | (plate >= 255)).mean() * 100):.2f}%")

    Image.fromarray(plate.astype(np.uint8)).save(FLAT, "WEBP", quality=95, method=6)
    print(f"  wrote {FLAT.name}")

    show = np.clip(norm(plate) * SHOW_STD + SHOW_MEAN, 0, 255)
    im = Image.fromarray(show.astype(np.uint8)).convert("RGB")
    im = im.resize((SHOW_WIDTH, round(SHOW_WIDTH * h / w)), Image.LANCZOS)
    im.save(SHOW, "WEBP", quality=SHOW_QUALITY, method=6)
    print(f"  wrote {SHOW.name}")


if __name__ == "__main__":
    main()
