#!/usr/bin/env python3
"""Derive the two Reeded assets from the original photograph.

Run from the theme directory:

    python3 scripts/build-reeded-texture.py

This is all that survives of the 2026-08-27 obscured-glass rewrite. Everything
else on that route went back to the original Pilkington photographs and the
original compositing on the owner's instruction: four attempts at a better live
effect, and a pre-render, were all worse than what was already there. **Read that
before proposing another one.**

Reeded stayed because its two faults were in the ASSET, not in any effect:

  Reeded-privacy-2-seamless.webp   the TILE. Only the stage paints it, because
                                   the stage is the only surface that repeats.
  Reeded-privacy-2-levelled.webp   the PHOTOGRAPH. Every surface that merely
                                   displays it uses this -- swatches, the hero
                                   wall, the glass card.

WHY TWO. Handing the mirrored tile to a 58px swatch puts its mirror axis dead
centre, and the ribs fan slightly, so it reads as a bold chevron rather than as
glass. Seamlessness is a property of tiling; a portrait does not tile.

THE PHOTOGRAPH IS LIT FROM ONE SIDE, which is what caused the seam in the first
place: low-frequency spread 130 against a set median of 49, left edge 148 against
right edge 100. Cropping to a whole number of ribs only moved the seam from 125
to 55, because the rib phase was never the problem. Flat-fielding first and then
mirroring takes it to 0.00 exactly.

MIRRORING IS RIGHT HERE AND WRONG ALMOST EVERYWHERE ELSE. Ribs are near-identical
to their own reflection so the symmetry is invisible; the same trick on an
organic pattern goes visibly kaleidoscopic. Do not generalise this.

If either file changes, rename it. Theme images are emitted through
`fenster_generated_url()` with no version string, so replacing one in place
leaves browsers serving the old bytes.
"""

import numpy as np
from PIL import Image, ImageFilter, ImageOps
from pathlib import Path

GLASS = Path("assets/images/products/obscure-glass")
SRC = GLASS / "Reeded-privacy-2.webp"

# The display copy is lifted towards the set's own mean brightness. It sits in a
# column of nineteen others and this is the second-darkest source in the set, so
# untouched it reads as the one near-black square in a pale column. The TILE is
# deliberately not lifted: the pane was approved as photographed.
SET_MEAN = 148.0
DISPLAY_CONTRAST = 0.82


def main() -> None:
    im = Image.open(SRC).convert("L")
    a = np.asarray(im, dtype=float)

    illum = np.asarray(im.filter(ImageFilter.GaussianBlur(40)), dtype=float)
    flat = a / np.maximum(illum, 1e-6)
    flat = flat / flat.mean()
    levelled = Image.fromarray(np.clip(flat * a.mean(), 0, 255).astype(np.uint8))

    mirrored = Image.new("L", (levelled.width * 2, levelled.height))
    mirrored.paste(levelled, (0, 0))
    mirrored.paste(ImageOps.mirror(levelled), (levelled.width, 0))
    tile_path = GLASS / "Reeded-privacy-2-seamless.webp"
    mirrored.save(tile_path, "WEBP", quality=90, method=6)

    disp = np.asarray(levelled, dtype=float)
    disp = SET_MEAN + (disp - disp.mean()) * DISPLAY_CONTRAST
    display = Image.fromarray(np.clip(disp, 0, 255).astype(np.uint8))
    display_path = GLASS / "Reeded-privacy-2-levelled.webp"
    display.save(display_path, "WEBP", quality=90, method=6)

    m = np.asarray(mirrored, dtype=float)
    before = abs(a[:, :8].mean() - a[:, -8:].mean())
    after = abs(m[:, :8].mean() - m[:, -8:].mean())
    print(f"  {tile_path.name}: {im.width} -> {mirrored.width}px, seam {before:.1f} -> {after:.2f}")
    print("    the tile doubled in width, so its pin is 360px, not 180px, or every")
    print("    rib renders twice as wide as it did")
    print(f"  {display_path.name}: mean {np.clip(disp,0,255).mean():.1f} "
          f"(set mean {SET_MEAN:.0f}), from {a.mean():.1f}")


if __name__ == "__main__":
    main()
