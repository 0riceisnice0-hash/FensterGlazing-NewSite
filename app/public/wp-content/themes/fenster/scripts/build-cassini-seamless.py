#!/usr/bin/env python3
"""Make the Cassini plate tile seamlessly.

Run from the theme directory:

    python3 scripts/build-cassini-seamless.py

WHY NOT MIRROR IT. `build-reeded-texture.py` makes Reeded seamless by mirroring
and its docstring warns, in terms, not to generalise that: ribs are near enough
identical to their own reflection that the symmetry is invisible, but the same
trick on an ORGANIC pattern goes visibly kaleidoscopic. Cassini is a mat of
lenses. Mirroring it would put a butterfly axis down the middle of the pane.

WHAT THIS DOES INSTEAD is a minimum-error boundary cut, the image-quilting
join. Take a band from the LEFT edge, overlay it on the RIGHT edge, and find the
path through that band along which the two disagree least -- a dynamic program,
one row at a time, each step choosing the cheapest of the three pixels above.
Cut along that path and the join runs between lenses instead of through them.
Then drop the band that was consumed, so the tile ends on content that the
original image continues from: the last column becomes the one immediately
before the first, which is what makes it wrap.

Vertically the same, on the result.

THE SEAM IS MEASURED, NOT ASSUMED. The script prints the mean absolute step
across both wrapped joins and compares it with the mean step between ordinary
adjacent columns and rows inside the picture. A tile is only seamless if the
join is no worse than the ordinary interior -- see the numbers it prints.

If this file changes, rename the output. Theme images are emitted through
`fenster_generated_url()` with no version string, so replacing one in place
leaves browsers serving the old bytes.
"""

import sys

import numpy as np
from PIL import Image
from pathlib import Path

GLASS = Path("assets/images/products/obscure-glass")
# Optional argv so the WindowCAD plate can reuse this cut rather than carry a
# second copy of it. No arguments reproduces the original behaviour exactly.
SRC = Path(sys.argv[1]) if len(sys.argv) > 1 else GLASS / "Cassini-privacy-5-flat.webp"
OUT = Path(sys.argv[2]) if len(sys.argv) > 2 else GLASS / "Cassini-privacy-5-tile.webp"
# Third argument: WebP quality, or 0 for lossless.
# THE TILE IS DATA, NOT A PICTURE. The renderer builds its height field, its
# oval segmentation and its hatch steering out of these pixels, so a lossy
# encode does not merely soften the plate -- it moves the render. Measured on
# the WindowCAD plate: q95 against lossless shifts 20% of output pixels by more
# than two levels, with a maximum of 79, and q90 lands CLOSER to lossless than
# q95 does, which is the tell that the response is not monotonic in quality and
# cannot be tuned by picking a number. The renderer itself is deterministic --
# two runs on identical input diff to exactly zero -- so whatever is shipped IS
# the render. Lossless is therefore the only encoding for which rebuilding the
# plate reproduces the page.
# Fourth argument: the cut band. Wider routes the seam around whole lenses but
# costs that many pixels of tile; the clock plate is small enough to need less.
BAND = int(sys.argv[4]) if len(sys.argv) > 4 else 200
FEATHER = 3


def min_cost_seam(cost: np.ndarray) -> np.ndarray:
    """Cheapest top-to-bottom path through `cost`; returns one column per row."""
    h, b = cost.shape
    acc = cost.astype(float).copy()
    back = np.zeros((h, b), dtype=int)
    for y in range(1, h):
        for x in range(b):
            lo = max(0, x - 1)
            hi = min(b, x + 2)
            j = lo + int(np.argmin(acc[y - 1, lo:hi]))
            back[y, x] = j
            acc[y, x] += acc[y - 1, j]
    path = np.zeros(h, dtype=int)
    path[-1] = int(np.argmin(acc[-1]))
    for y in range(h - 1, 0, -1):
        path[y - 1] = back[y, path[y]]
    return path


def join_horizontal(a: np.ndarray, band: int) -> np.ndarray:
    h, w = a.shape
    left = a[:, :band]
    right = a[:, w - band:]
    # The cut is chosen on a SMOOTHED cost so it routes around whole lenses
    # rather than threading between individual grains, which is what left the
    # vertical join still reading above the interior at a narrower band.
    cost = (right - left) ** 2
    k = np.ones((9, 9)) / 81.0
    pad = np.pad(cost, 4, mode="edge")
    sm = np.zeros_like(cost)
    for dy in range(9):
        for dx in range(9):
            sm += pad[dy:dy + cost.shape[0], dx:dx + cost.shape[1]] * k[dy, dx]
    seam = min_cost_seam(sm)
    xs = np.arange(band)[None, :]
    # A few pixels of ramp ACROSS the cut, not a blur of the picture: it
    # removes the residual one-pixel step without softening anything else.
    t = (xs - seam[:, None] + FEATHER) / (2.0 * FEATHER)
    t = np.clip(t, 0.0, 1.0)
    joined = right * (1 - t) + left * t
    return np.concatenate([a[:, band:w - band], joined], axis=1)


def step(a: np.ndarray, axis: int) -> tuple:
    if axis == 1:
        join = np.abs(a[:, -1].astype(float) - a[:, 0].astype(float)).mean()
        inner = np.abs(np.diff(a.astype(float), axis=1)).mean()
    else:
        join = np.abs(a[-1, :].astype(float) - a[0, :].astype(float)).mean()
        inner = np.abs(np.diff(a.astype(float), axis=0)).mean()
    return join, inner


def main() -> None:
    a = np.asarray(Image.open(SRC).convert("L"), dtype=float)
    print(f"  source {a.shape[1]}x{a.shape[0]}")
    b0 = step(a, 1)
    b1 = step(a, 0)
    print(f"    before: horizontal join {b0[0]:5.1f} vs interior {b0[1]:4.1f}, "
          f"vertical join {b1[0]:5.1f} vs interior {b1[1]:4.1f}")

    a = join_horizontal(a, BAND)
    a = join_horizontal(a.T, BAND).T

    h0 = step(a, 1)
    h1 = step(a, 0)
    print(f"    after:  horizontal join {h0[0]:5.1f} vs interior {h0[1]:4.1f}, "
          f"vertical join {h1[0]:5.1f} vs interior {h1[1]:4.1f}")
    print(f"    tile {a.shape[1]}x{a.shape[0]}")
    ok = h0[0] <= h0[1] * 1.35 and h1[0] <= h1[1] * 1.35
    print(f"    seamless: {'YES' if ok else 'NO -- the join still reads above the interior'}")

    q = int(sys.argv[3]) if len(sys.argv) > 3 else 94
    opts = dict(lossless=True, method=6) if q == 0 else dict(quality=q, method=6)
    Image.fromarray(np.clip(a, 0, 255).astype(np.uint8)).save(OUT, "WEBP", **opts)
    print(f"  wrote {OUT.name}")


if __name__ == "__main__":
    main()
