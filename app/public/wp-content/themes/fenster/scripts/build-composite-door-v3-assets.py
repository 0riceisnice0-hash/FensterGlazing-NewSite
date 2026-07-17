"""Additional composite-door assets for the V3 page composition.

Runs alongside build-composite-door-assets.py. Adds the in-situ lifestyle
imagery the V3 layout leads with: the Contemporary Infinity hallway and the
Signature Stable-door cottage kitchen.
"""
from pathlib import Path

from PIL import Image, ImageOps

SOURCE = Path(r"C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape\images")
TARGET = Path(__file__).resolve().parents[1] / "assets" / "images" / "products" / "composite-distinction"

# stem -> (source file, ratio height/width, widths)
RATIO_ASSETS = {
    "collections/contemporary-hall": ("GD03-V4-FLAT-1024x1024-1.jpg", 1.0, (400, 800)),
    "types/stable-kitchen": ("Stable-Top-Pastel-Blue-Lunna-1024x1024-1.jpg", 0.75, (800, 1200)),
}


def write_ratio_variant(source: Path, stem: str, ratio: float, width: int) -> None:
    with Image.open(source) as image:
        image = ImageOps.exif_transpose(image).convert("RGB")
        output_size = (width, round(width * ratio))
        image = ImageOps.fit(
            image,
            output_size,
            method=Image.Resampling.LANCZOS,
            centering=(0.5, 0.42),
        )
        output = TARGET / f"{stem}-{width}w.webp"
        output.parent.mkdir(parents=True, exist_ok=True)
        image.save(output, "WEBP", quality=84, method=6)


count = 0
for output_stem, (source_name, ratio, widths) in RATIO_ASSETS.items():
    source_path = SOURCE / source_name
    if not source_path.exists():
        raise FileNotFoundError(source_path)
    for target_width in widths:
        write_ratio_variant(source_path, output_stem, ratio, target_width)
        count += 1

print(f"Built {count} composite-door V3 assets in {TARGET}")
