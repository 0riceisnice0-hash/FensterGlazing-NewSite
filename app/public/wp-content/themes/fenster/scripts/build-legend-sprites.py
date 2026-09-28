"""Build the sprite sheets Legend actually loads from his master artwork.

`legend-spritesheet.webp` is the master: 88 cells of 192x208 on an 8x11 grid,
2 MB lossless. Pages only ever show 27 of those cells, so they no longer load
the master at all. This writes three smaller files on the SAME 1536x2288 grid,
which is what lets `.legend-sprite img` keep its percentage geometry unchanged:

- legend-sprite-idle.webp    idle and jump only. Loads with the page, because
                             the corner launcher idles on first paint and jumps
                             into the chat panel on the first click.
- legend-sprite-motion.webp  every cell the site uses. Fetched only when a
                             visitor reaches for Legend (hover, tap, focus, or
                             the chat reopening), because only the chat panel's
                             roamer runs.
- legend-sprite-sleep.webp   the sleep strip, re-encoded. Loads with the page;
                             Legend falls asleep after 20 seconds untouched.

Cells a file does not carry are fully transparent, which WebP stores almost
for free. Quality 95 with lossless alpha was judged against the master at 3x
zoom and is indistinguishable at the sizes Legend is drawn (96-118 CSS px).

USED must match `spriteSequences` in src/js/main.js. Showing a cell that is not
listed here draws an empty frame, so add the cell here and rebuild first.

Run from the theme directory:  python scripts/build-legend-sprites.py
"""

from pathlib import Path

import numpy as np
from PIL import Image

ASSISTANT = Path(__file__).resolve().parents[1] / "assets" / "images" / "assistant"
MASTER = ASSISTANT / "legend-spritesheet.webp"
MASTER_SLEEP = ASSISTANT / "legend-sleep-strip.webp"

COLUMNS, ROWS = 8, 11

# row -> columns, as used by spriteSequences in src/js/main.js
IDLE = {0: range(0, 6)}
RUNNING_RIGHT = {1: range(0, 8)}
RUNNING_LEFT = {2: range(0, 8)}
JUMPING = {4: range(0, 5)}

USED = {**IDLE, **RUNNING_RIGHT, **RUNNING_LEFT, **JUMPING}
ON_LOAD = {**IDLE, **JUMPING}

ENCODE = {"quality": 95, "alpha_quality": 100, "method": 6, "exact": False}


def keep_cells(master: np.ndarray, cells: dict) -> Image.Image:
    height, width = master.shape[:2]
    cell_w, cell_h = width // COLUMNS, height // ROWS
    out = np.zeros_like(master)
    for row, columns in cells.items():
        for column in columns:
            y, x = row * cell_h, column * cell_w
            out[y:y + cell_h, x:x + cell_w] = master[y:y + cell_h, x:x + cell_w]
    out[out[..., 3] == 0] = 0
    return Image.fromarray(out, "RGBA")


def main() -> None:
    master = np.array(Image.open(MASTER).convert("RGBA"))
    if master.shape[:2] != (2288, 1536):
        raise SystemExit(f"unexpected master size {master.shape[1]}x{master.shape[0]}")

    outputs = {
        "legend-sprite-idle.webp": keep_cells(master, ON_LOAD),
        "legend-sprite-motion.webp": keep_cells(master, USED),
        "legend-sprite-sleep.webp": Image.open(MASTER_SLEEP).convert("RGBA"),
    }
    for name, image in outputs.items():
        target = ASSISTANT / name
        image.save(target, "WEBP", **ENCODE)
        print(f"{name}: {target.stat().st_size:,} bytes")


if __name__ == "__main__":
    main()
