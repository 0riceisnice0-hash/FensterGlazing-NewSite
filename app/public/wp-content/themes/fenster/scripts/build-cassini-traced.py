#!/usr/bin/env python3
"""Build Cassini's plate from the oval layout the OWNER traced by hand.

Run from the theme directory:

    python3 scripts/build-cassini-traced.py
    python3 scripts/build-cassini-seamless.py \
        assets/images/products/obscure-glass/Cassini-privacy-5-traced-flat.webp \
        assets/images/products/obscure-glass/Cassini-privacy-5-traced-tile.webp 0 100

WHY THE LAYOUT IS NO LONGER DERIVED FROM THE PHOTOGRAPH. Every earlier plate
took BOTH its texture and its arrangement out of the clock photograph by local
contrast normalisation, and the arrangement was wrong every time -- through the
sample plates, the WindowCAD plate and the clock plate, across several
rebuilds. Owner, 2026-08-30, on the clock plate: the shapes still did not read.

Four detectors were then written and all four failed, which is the finding
worth keeping: edge chains, junction cut-and-relink, RANSAC on Canny edges, and
RANSAC on the smooth/hatched boundary. The best of them recovered 2 of the 9
ovals in a patch the owner marked by hand. **The reason is that a Cassini lens
shows as a TONAL FORM, not as a hard edge** -- neighbouring lenses differ by a
few levels and the boundary between them often has no gradient at all -- so an
edge-driven detector finds the crossings and misses the lenses. At 630x533,
which is the largest copy of that photograph in existence, they are not
recoverable.

So the owner marked all 82 by hand, in three colours, and those ARE the layout.
`scripts/cassini-oval-layout.json` is the result and
`scripts/reference-cassini-owner-ovals.png` is the markup it came from, so the
whole thing can be re-derived. Measured against the owner's strokes the fitted
ovals account for 90.1% of them, and the two independent markups he made an
hour apart agree on density to within 5% (2.0 against 2.1 ovals per 10k px).

WHAT THIS SCRIPT KEEPS FROM THE PHOTOGRAPH, which is everything except the
arrangement: the hatch, the grain, the sectored ruling, and each lens's own
dome direction. The last is fitted as a least-squares ramp through the real
pixels inside each traced oval, so which edge of a lens is dark and which is
bright agrees with the sheet instead of being invented.

WHAT IT DELIBERATELY DOES NOT CARRY, having been tried and measured: each
oval's overall TONE. A lens is dark or pale in that photograph because of what
is behind it -- the red clock, the room -- and not because the glass sits lower
or higher there. The plate is a height field, so carrying it would bake the
clock's image into the geometry, which is the fault this repo already records
against deriving a height map from a photograph. It also broke the renderer
outright: dark ovals fall below the seed percentile and cannot seed at all, and
recovery fell from 65 of 82 to 35. The DOME stays, because a lens genuinely is
brighter on one edge than the other and that is curvature rather than scene.

THE PLATE IS READ BY THE RENDERER, NOT LOOKED AT, AND THAT SETS TWO MATERIAL
NUMBERS. `renderGlass` segments lenses out of these pixels: seeds are pixels
above `ovalSeedLevel`, grown by breadth-first search down to `ovalEdgeLevel`,
and where two fronts meet is the join. The owner's ovals cover 82% of the sheet
where the previous plate's covered about 66%, so both thresholds had to move
with it -- `ovalSeedLevel` 0.74 -> 0.91 and `ovalEdgeLevel` 0.34 -> 0.18. With
those, the renderer reads back 75 regions covering 82.3% against the layout's
82.1%. **Change this file and re-check those two numbers**;
`scripts/check-cassini-plate.py` re-implements the segmentation and prints them.

THE RENDERER CANNOT HOLD ONE OVAL LYING OVER ANOTHER, and that is a known
ceiling rather than a fault here. Its segmentation partitions space, so each
pixel belongs to exactly one lens: of the 82, it recovers 65 on centre and axes
and merges the rest into overlapping pairs. 26.5% of this layout is two or more
deep, so some merging is unavoidable until the renderer carries real depth.

If this file changes, RENAME THE OUTPUTS. Theme images carry no version string.
"""

import json
import sys
from pathlib import Path

import numpy as np
from PIL import Image
from scipy.ndimage import gaussian_filter

CLOCK = Path("scripts/reference-cassini-clock.png")
LAYOUT = Path("scripts/cassini-oval-layout.json")
GLASS = Path("assets/images/products/obscure-glass")
FLAT = GLASS / "Cassini-privacy-5-traced-flat.webp"
SHOW = GLASS / "Cassini-privacy-5-traced.webp"

LCN_SIGMA, LCN_FLOOR = 40.0, 6.0
TARGET_MEAN, TARGET_STD = 158.0, 21.5
SHOW_MEAN, SHOW_STD, SHOW_WIDTH, SHOW_QUALITY = 158.0, 46.0, 700, 74

FACE_LIFT = 30.0      # how far a lens core sits above the ground
DOME_AMP = 0.55       # share of that lift given to the photograph's own ramp
OVERLAP_LIFT = 7.0    # each further covering oval lifts a little more
FACE_GRAIN = 0.62     # faces keep less fine texture: measured 22 rms against 33
EDGE_SOFT = 2.0       # shoulder on the lens boundary, px
CORE_POW = 2.2        # sharpens each core so touching lenses seed separately


def norm(a):
    return (a - a.mean()) / max(a.std(), 1e-6)


def lcn(a, sigma=LCN_SIGMA, floor=LCN_FLOOR):
    """Scene removal that PRESERVES EDGES -- never band-pass this."""
    mu = gaussian_filter(a, sigma, mode="reflect")
    var = gaussian_filter((a - mu) ** 2, sigma, mode="reflect")
    sd = np.maximum(np.sqrt(np.maximum(var, 1e-6)), floor)
    return (a - mu) / sd


def oval_fields(E, h, w, ref):
    yy, xx = np.mgrid[0:h, 0:w].astype(float)
    depth = np.zeros((h, w), np.int16)
    core = np.zeros((h, w))
    dome = np.zeros((h, w))
    for cx, cy, A, B, th in E:
        ct, st = np.cos(th), np.sin(th)
        dx, dy = xx - cx, yy - cy
        u = (dx * ct + dy * st) / A
        v = (-dx * st + dy * ct) / B
        r = np.sqrt(u * u + v * v)
        ins = r <= 1.0
        if not ins.any():
            continue
        depth += ins
        core = np.maximum(core, np.clip(1.0 - r, 0, 1) * ins)
        sx, sy, vals = dx[ins], dy[ins], ref[ins]
        M = np.column_stack([sx, sy, np.ones(sx.size)])
        try:
            coef, *_ = np.linalg.lstsq(M, vals - vals.mean(), rcond=None)
        except np.linalg.LinAlgError:
            continue
        gx, gy = coef[0], coef[1]
        n = np.hypot(gx, gy)
        if n < 1e-9:
            continue
        reach = max(A * abs(gx / n) + B * abs(gy / n), 1e-6)
        dome = np.where(ins, np.clip((dx * (gx / n) + dy * (gy / n)) / reach, -1, 1), dome)
    return depth, core, dome


def main():
    if not CLOCK.exists():
        sys.exit(f"missing {CLOCK}")
    if not LAYOUT.exists():
        sys.exit(f"missing {LAYOUT}")
    E = np.array([[o["cx"], o["cy"], o["a"], o["b"], o["theta"]]
                  for o in json.loads(LAYOUT.read_text())])
    ref = np.asarray(Image.open(CLOCK).convert("L"), dtype=float)
    h, w = ref.shape
    print(f"  {len(E)} traced ovals over a {w}x{h} reference")

    plate0 = np.clip(norm(lcn(ref)) * TARGET_STD + TARGET_MEAN, 0, 255)
    depth, core, dome = oval_fields(E, h, w, plate0)
    print(f"    lens coverage {(depth > 0).mean() * 100:.1f}%   two or more deep "
          f"{(depth > 1).mean() * 100:.1f}%   deepest {depth.max()}")

    fine = plate0 - gaussian_filter(plate0, 6.0, mode="reflect")
    face = gaussian_filter((depth > 0).astype(float), EDGE_SOFT, mode="reflect")
    grain = FACE_GRAIN + (1.0 - FACE_GRAIN) * (1.0 - face)
    coreS = gaussian_filter(np.power(np.clip(core, 0, 1), CORE_POW), EDGE_SOFT, mode="reflect")

    plate = (FACE_LIFT * coreS
             + OVERLAP_LIFT * np.clip(depth - 1, 0, None)
             + FACE_LIFT * DOME_AMP * dome * face
             + fine * grain)
    plate = np.clip(norm(plate) * TARGET_STD + TARGET_MEAN, 0, 255)
    print(f"    mean {plate.mean():5.1f}  std {plate.std():5.1f}  "
          f"clipped {(((plate <= 0) | (plate >= 255)).mean() * 100):.2f}%")

    Image.fromarray(plate.astype(np.uint8)).save(FLAT, "WEBP", lossless=True, method=6)
    print(f"  wrote {FLAT.name} (lossless -- the tile is data)")

    show = np.clip(norm(plate) * SHOW_STD + SHOW_MEAN, 0, 255)
    im = Image.fromarray(show.astype(np.uint8)).convert("RGB")
    im = im.resize((SHOW_WIDTH, round(SHOW_WIDTH * h / w)), Image.LANCZOS)
    im.save(SHOW, "WEBP", quality=SHOW_QUALITY, method=6)
    print(f"  wrote {SHOW.name}")


if __name__ == "__main__":
    main()
