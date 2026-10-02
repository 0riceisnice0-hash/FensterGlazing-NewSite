"""Build a Meet the Team photo from a phone selfie taken against the office block wall.

The team cards show only the top of each photo (`1 / 0.92` on desktop, `1 / 0.82` at 860px
and below, top-anchored), so a photo that shows the shirt logo has to be wide. The office
selfies are taken close, with a window frame and a door frame either side, so the frames are
covered rather than cropped out:

1. Un-mirror the selfie (front cameras flip it; the shirt logo reads backwards otherwise).
2. Cut the person out with a person matte (rembg, isnet-general-use, runs locally).
3. Extend the painted block wall over each frame strip: from clean wall on the same row where
   there is some (sliding along the wall past the head), otherwise as a whole strip copied one
   course higher, so every block steps down together and the mortar lines carry on straight.
4. Lay the person back over it by the matte, crop from just above the head, black and white.

The person's own pixels are never altered. Always check the result at full size (the
`-seams.jpg` file) and in both card shapes before shipping it.

    pip install "rembg[cpu]" opencv-python pillow numpy
    python build-team-photo.py <selfie.jpg> <slug> <left_edge> <right_edge> <course> <crop_top> [out_dir]

left_edge / right_edge: columns (in the flipped photo) where clean wall starts and ends, a
little inside each frame so its light render bead is replaced too. course: vertical distance
between mortar lines in pixels; measure it by eye on a clean patch of wall, because
autocorrelation on this wall locks onto sub-harmonics. crop_top: a row ~60-70px above the top
of the head; check that head top to logo bottom fits inside `0.82 x width`.

Used for (2026-10-01/02): lee-judge 268 1220 158 395 (built with an earlier per-block fill),
dan-hodson 255 1130 315 335.
"""
import sys
from pathlib import Path

import cv2
import numpy as np
from PIL import Image, ImageOps
from rembg import new_session, remove

SRC, NAME = sys.argv[1], sys.argv[2]
L_EDGE, R_EDGE, COURSE, CROP_TOP = (int(v) for v in sys.argv[3:7])
OUT = Path(sys.argv[7]) if len(sys.argv) > 7 else Path.cwd()
OUT.mkdir(parents=True, exist_ok=True)
MODEL = 'isnet-general-use'

src = ImageOps.mirror(ImageOps.exif_transpose(Image.open(SRC)).convert('RGB'))
img = np.asarray(src).astype(np.float32)
H, W, _ = img.shape

# --- Person matte (cached, it is the slow step).
matte_path = OUT / f'{NAME}-matte-{MODEL}.png'
if not matte_path.exists():
    remove(src, session=new_session(MODEL), only_mask=True).save(matte_path)
alpha = np.asarray(Image.open(matte_path).convert('L')).astype(np.float32) / 255

# --- Where the wall can be copied from: well clear of the person, and actually painted block.
# The gap between an arm and the body shows the dark door behind, which is not the person but
# is not wall either.
clean = cv2.dilate((alpha > 0.02).astype(np.uint8), np.ones((15, 15), np.uint8)) == 0
hsv = cv2.cvtColor(img.astype(np.uint8), cv2.COLOR_RGB2HSV)
clean &= (img.mean(axis=2) > 150) & (hsv[..., 1] < 40)
plate = img.copy()


def fill(cols, shift, chunk=24):
    """Rows where every block of the strip finds clean wall on the same row are copied from
    there. Rows where the body blocks any part of the strip are copied as a whole strip from one
    course higher in the already-filled plate, with the exact offset picked by matching the rows
    just above the first blocked row."""
    cols = np.array(cols)
    step = 1 if shift > 0 else -1
    blocked = []
    for y in range(H):
        picks = []
        for c0 in range(0, len(cols), chunk):
            cc = cols[c0:c0 + chunk]
            for extra in range(0, 241, chunk):
                sx = cc + shift + step * extra
                if sx.min() >= 0 and sx.max() < W and clean[y, sx].all():
                    picks.append((cc, sx))
                    break
            else:
                picks = None
                break
        if picks is None:
            blocked.append(y)
            continue
        for cc, sx in picks:
            plate[y, cc] = img[y, sx]
    if not blocked:
        return
    r0 = blocked[0]
    ref = plate[r0 - 40:r0, cols].mean(axis=2)
    dy = min(range(COURSE - 15, COURSE + 16),
             key=lambda d: ((plate[r0 - 40 - d:r0 - d, cols].mean(axis=2) - ref) ** 2).mean())
    print(f'strip {cols[0]}-{cols[-1]}: blocked from row {r0}, copied {dy}px up')
    for y in blocked:
        plate[y, cols] = plate[y - dy, cols]


fill(range(0, L_EDGE), L_EDGE)
fill(range(R_EDGE, W), -(W - R_EDGE))

# --- Composite: the plate in the strips, feathered into the original wall; the person on top.
edge = np.zeros((H, W), np.float32)
edge[:, :L_EDGE] = 1
edge[:, R_EDGE:] = 1
edge = cv2.GaussianBlur(edge, (0, 0), 6)
background = img * (1 - edge[..., None]) + plate * edge[..., None]
a = alpha[..., None]
out = Image.fromarray((background * (1 - a) + img * a).clip(0, 255).astype(np.uint8))
out.save(OUT / f'{NAME}-walled-colour.jpg', quality=92)

bw = ImageOps.autocontrast(ImageOps.grayscale(out.crop((0, CROP_TOP, W, H))), cutoff=(0.5, 0.5))
bw.convert('RGB').save(OUT / f'{NAME}-cropped-bw.jpg', quality=86, optimize=True, progressive=True)
print('wrote', OUT / f'{NAME}-cropped-bw.jpg', bw.size)

# Full-size close-ups of both edges, to inspect the joins.
seams = Image.new('RGB', (2 * 400 + 10, H - CROP_TOP), 'white')
seams.paste(out.crop((0, CROP_TOP, 400, H)), (0, 0))
seams.paste(out.crop((W - 400, CROP_TOP, W, H)), (410, 0))
seams.save(OUT / f'{NAME}-seams.jpg', quality=85)
