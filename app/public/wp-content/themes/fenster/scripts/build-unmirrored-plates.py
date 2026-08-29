#!/usr/bin/env python3
"""Re-cut obscured-glass plates that carry a MIRRORED TAIL in the photograph.

Owner, 2026-08-29: "they all have a shitty mirror repeat which they dont have
irl ... sycamore and oak for eg have it. they mirrors vertically."

WHAT WAS WRONG, AND IT WAS NEVER THE RENDERER. Seven of the plates were
extended by reflecting the photograph about a vertical axis at roughly two
thirds across. Laying the plate ONCE at `cover` -- which is what the renderer
does for these, with no tiling and no mirroring anywhere in the path -- still
puts that reflection on the pane, because the axis sits inside the visible
window at every pane width. Proven outside the renderer entirely: replicating
`drawCover`'s arithmetic in isolation and laying the raw plate reproduces the
chevrons meeting on a vertical axis exactly as they appear on the page.

WHY IT WAS MISSED TWICE. The first sweep tested each plate for a mirror about
its CENTRE and came back clean (Sycamore -0.011). The axis is at 68%. Search
the axis position; do not assume the middle.

WHAT THIS DOES. For each affected plate: find the reflection axis, keep the
original (unmirrored) side, and write a NEW FILE.

THE FILENAME MUST CHANGE. Texture images are emitted without a version string,
so replacing a .webp in place leaves every browser and proxy that has seen it
serving the old one -- the corrected Cassini was live and invisible for exactly
that reason. This is the same rule `build-cassini-texture.py` records.

Run from the theme directory:  python3 scripts/build-unmirrored-plates.py
Add --write to actually emit files; without it the script only reports.
"""

import sys
from pathlib import Path

import numpy as np
from PIL import Image
from scipy.ndimage import gaussian_filter

HERE = Path(__file__).resolve().parent
PLATES = HERE.parent / "assets/images/products/obscure-glass"
SUFFIX = "-unmirrored"

# Measured 2026-08-29. Correlation of the strip left of the axis against the
# strip right of it, mirrored, on a high-passed copy. Anything above ~0.55 is a
# reflection rather than a coincidence of the pattern.
TARGETS = [
    "Sycamore-privacy-2.webp",
    "Arctic-privacy-5.webp",
    "Stippolyte-privacy-4.webp",
    "Florielle-privacy-4.webp",
    "Mayflower-privacy-4.webp",
    "Minster-privacy-2.webp",
    "Autumn-privacy-3.webp",
]


def highpass(img):
    a = np.asarray(img.convert("L"), dtype=float)
    return a - gaussian_filter(a, 4)


def find_axis(a):
    """Strongest vertical reflection axis, as a fraction of width."""
    h, w = a.shape
    best = (0.0, 0.5)
    for ax in range(int(w * 0.15), int(w * 0.85), 2):
        k = min(int(w * 0.14), ax, w - ax)
        if k < 20:
            continue
        left = a[:, ax - k:ax]
        right = a[:, ax:ax + k][:, ::-1]
        c = float(np.corrcoef(left.ravel(), right.ravel())[0, 1])
        if c > best[0]:
            best = (c, ax / w)
    return best


def residual(img):
    """Strongest reflection left anywhere in an image."""
    a = highpass(img)
    h, w = a.shape
    best = 0.0
    for ax in range(int(w * 0.15), int(w * 0.85), 3):
        k = min(int(w * 0.14), ax, w - ax)
        if k < 20:
            continue
        c = float(np.corrcoef(a[:, ax - k:ax].ravel(), a[:, ax:ax + k][:, ::-1].ravel())[0, 1])
        best = max(best, c)
    return best


def main():
    write = "--write" in sys.argv
    print(f"{'plate':34s} {'axis':>6s} {'before':>8s} {'after':>7s}  {'kept':>12s}")
    failures = []
    for name in TARGETS:
        src = PLATES / name
        if not src.exists():
            print(f"  {name:32s}  MISSING")
            failures.append(name)
            continue
        img = Image.open(src)
        corr, pos = find_axis(highpass(img))
        w, h = img.size
        ax = int(pos * w)

        # Keep whichever side of the axis is larger -- that is the original
        # photograph; the shorter side is the reflected tail.
        if ax >= w - ax:
            box, kept = (0, 0, ax, h), f"0..{ax}"
        else:
            box, kept = (ax, 0, w, h), f"{ax}..{w}"

        out_img = img.convert("RGB").crop(box)
        after = residual(out_img)
        print(f"  {name:32s} {pos * 100:5.0f}% {corr:+8.3f} {after:+7.3f}  {kept:>12s}")

        # A crop that does not actually remove the reflection is not worth
        # shipping -- assert rather than emit something no better than before.
        if after > 0.45:
            print(f"      ^ STILL MIRRORED after crop, not written")
            failures.append(name)
            continue

        if write:
            stem = src.stem + SUFFIX
            dst = PLATES / f"{stem}.webp"
            out_img.save(dst, "WEBP", quality=92, method=6)
            print(f"      -> {dst.name}  {out_img.size[0]}x{out_img.size[1]}  "
                  f"{dst.stat().st_size // 1024}KB")

    if failures:
        print(f"\n{len(failures)} plate(s) not written: {', '.join(failures)}")
        return 1
    if not write:
        print("\nreport only. re-run with --write to emit the cropped plates.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
