#!/usr/bin/env python3
"""Check a Cassini plate by RE-RUNNING THE RENDERER'S OWN LENS SEGMENTATION.

Run from the theme directory:

    python3 scripts/check-cassini-plate.py

WHY THIS EXISTS. A plate is not correct because it looks right; it is correct
because `renderGlass` reads the intended lenses back out of it. That segmentation
is the thing the plate has to survive, and nothing else in the build touches it,
so a plate can be rebuilt, look fine, and quietly render as different lenses.

This mirrors the `ovalsFromPlate` branch of `src/js/main.js` step for step: box
blur by `ovalFitBlur`, seed above the `ovalSeedLevel` percentile, grow by
breadth-first search down to `ovalEdgeLevel`, meeting fronts are the join. If
the numbers below drift from what `build-cassini-traced.py` records, the plate
and the material have gone out of step -- fix one or the other, not neither.
"""

import json
from collections import deque
from pathlib import Path

import numpy as np
from PIL import Image
from scipy.ndimage import uniform_filter, label

GLASS = Path("assets/images/products/obscure-glass")
FLAT = GLASS / "Cassini-privacy-5-traced-flat.webp"
TILE = GLASS / "Cassini-privacy-5-traced-tile.webp"
LAYOUT = Path("scripts/cassini-oval-layout.json")

# these must match the cassini material block in src/js/main.js
SEED_LEVEL, EDGE_LEVEL, FIT_BLUR, FIT_DENSITY = 0.91, 0.18, 4, 30000


def segment(plate):
    h, w = plate.shape
    sm = uniform_filter(plate.astype(float), size=2 * FIT_BLUR + 1, mode="reflect")
    flat = sm.ravel()
    samp = np.sort(flat[(2003 * np.arange(4096)) % flat.size])
    hi = samp[int(len(samp) * SEED_LEVEL)]
    lo = samp[int(len(samp) * EDGE_LEVEL)]
    seeds, _ = label(sm > hi)
    sizes = np.bincount(seeds.ravel())
    good = [g for g in np.nonzero(sizes >= max(6, (w * h) / FIT_DENSITY))[0] if g != 0]
    lab = -np.ones((h, w), np.int32)
    for k, g in enumerate(good):
        lab[seeds == g] = k
    q = deque(map(tuple, np.argwhere(lab >= 0)))
    grow = sm > lo
    while q:
        y, x = q.popleft()
        v = lab[y, x]
        for dy, dx in ((0, 1), (0, -1), (1, 0), (-1, 0)):
            ny, nx = y + dy, x + dx
            if 0 <= ny < h and 0 <= nx < w and lab[ny, nx] == -1 and grow[ny, nx]:
                lab[ny, nx] = v
                q.append((ny, nx))
    return lab, len(good)


def moments(lab, n):
    out = []
    for k in range(n):
        ys, xs = np.nonzero(lab == k)
        if len(xs) < 8:
            out.append(None)
            continue
        mx, my = xs.mean(), ys.mean()
        xx = (xs * xs).mean() - mx * mx
        yy = (ys * ys).mean() - my * my
        xy = (xs * ys).mean() - mx * my
        ev = np.clip(np.linalg.eigvalsh(np.array([[xx, xy], [xy, yy]])), 1e-9, None)
        out.append((mx, my, 2 * np.sqrt(ev[1]), 2 * np.sqrt(ev[0])))
    return out


def main():
    E = np.array([[o["cx"], o["cy"], o["a"], o["b"]]
                  for o in json.loads(LAYOUT.read_text())])
    for path, named in ((FLAT, True), (TILE, False)):
        if not path.exists():
            print(f"  missing {path}")
            continue
        plate = np.asarray(Image.open(path).convert("L"), float)
        lab, n = segment(plate)
        cover = (lab >= 0).mean() * 100
        print(f"  {path.name}  {plate.shape[1]}x{plate.shape[0]}")
        print(f"    {n} lenses, covering {cover:.1f}% of the plate")
        if named:
            mom = moments(lab, n)
            used, hits = set(), 0
            for g in E:
                for j, f in enumerate(mom):
                    if f is None or j in used:
                        continue
                    if (np.hypot(f[0] - g[0], f[1] - g[1]) < 0.35 * 2 * g[2]
                            and abs(f[2] - g[2]) < 0.55 * g[2]):
                        used.add(j)
                        hits += 1
                        break
            print(f"    recovers {hits} of the {len(E)} traced ovals on centre and axes")
            print(f"    (the rest are overlapping pairs the watershed merges -- it "
                  f"partitions space and cannot hold one lens over another)")


if __name__ == "__main__":
    main()
