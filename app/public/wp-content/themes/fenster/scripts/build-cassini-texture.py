#!/usr/bin/env python3
"""Flat-field the Cassini plate for the optical renderer.

Run from the theme directory:

    python3 scripts/build-cassini-texture.py

WHY. The renderer picks Cassini's lens faces out of the plate by threshold: it
blurs the plate to get the broad relief and takes everything above a percentile
of that as a petal face. A percentile is a GLOBAL cut, so it only finds the real
petals if the plate is evenly lit.

Cassini's is not. Measured low-frequency spread 168 against a set median of 70 --
the worst of any glass texture in the set, worse than Reeded was at 154. There is
a hot spot at lower-left and a dark corner at top-right, so the global cut ran
below the ground in the bright half and above the petals in the dark half. The
petals came out as connected white amoebas in one corner and vanished in the
other: a contour map of the lighting, not the pattern.

Dividing by a heavy blur of itself removes the lighting and leaves the pattern,
after which the same threshold finds the same petals everywhere on the sheet.

TWO FILES, for the reason set out in build-reeded-texture.py: this one is the
`tile`, used only by the stage, which is the only surface that renders optics.
Every surface that merely DISPLAYS Cassini keeps the original photograph via
`image` -- swatches, the hero wall, the glass card -- because those were approved
as photographed and a flat-fielded plate looks flat when shown as a picture.

If this file changes, rename it. Theme images are emitted through
`fenster_generated_url()` with no version string, so replacing one in place
leaves browsers serving the old bytes.
"""

import numpy as np
from PIL import Image, ImageFilter
from pathlib import Path

GLASS = Path("assets/images/products/obscure-glass")
SRC = GLASS / "Cassini-privacy-5-rev2.webp"
OUT = GLASS / "Cassini-privacy-5-flat.webp"

# Wide enough to be pure illumination. The petals run to about 110px on this
# plate, so a 40px blur would still be tracking them and dividing the pattern
# out along with the light.
ILLUM_BLUR = 90


def spread(a: np.ndarray) -> float:
    b = np.asarray(Image.fromarray(a.astype(np.uint8)).filter(
        ImageFilter.GaussianBlur(40)), dtype=float)
    return float(b.max() - b.min())


def main() -> None:
    im = Image.open(SRC).convert("L")
    a = np.asarray(im, dtype=float)

    illum = np.asarray(im.filter(ImageFilter.GaussianBlur(ILLUM_BLUR)), dtype=float)
    flat = a / np.maximum(illum, 1e-6)
    flat = flat / flat.mean() * a.mean()
    out = np.clip(flat, 0, 255)

    Image.fromarray(out.astype(np.uint8)).save(OUT, "WEBP", quality=92, method=6)
    print(f"  {OUT.name}: {im.width}x{im.height}")
    print(f"    low-frequency spread {spread(a):.1f} -> {spread(out):.1f} "
          f"(set median 70)")
    print(f"    mean {a.mean():.1f} -> {out.mean():.1f}, "
          f"detail std {a.std():.1f} -> {out.std():.1f}")


if __name__ == "__main__":
    main()
