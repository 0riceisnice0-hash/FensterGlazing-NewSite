from pathlib import Path

from PIL import Image, ImageOps


SOURCE = Path(r"C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape\images")
TARGET = Path(__file__).resolve().parents[1] / "assets" / "images" / "products" / "composite-distinction"


ASSETS = {
    "hero/distinction-grandeur-entrance": ("Grandeur-Collection-header-image.jpg", (480, 960, 1920)),
    "families/signature": ("Signature-Eclat-with-Lunna-GlazingDOF-1024x1024-2.jpg", (400, 800)),
    "families/contemporary": ("Contemporary-1-V5MAIN-DOF-1024x1024-2.jpg", (400, 800)),
    "families/nxt-gen": ("Next-Generation-Elegance-Door-in-Ral-3003-Main_v4-DOF-1024x1024-1.jpg", (400, 800)),
    "families/grandeur": ("Grandeur-Collection-header-image.jpg", (400, 800)),
    "gallery/chatsworth-double-lite": ("Chatsworth-Glass-Update-v5-FLAT-1.jpg", (480, 800, 1400)),
    "gallery/venture-urban-entrance": ("new-venture-min.jpg", (480, 800, 1400)),
    "gallery/nxt-gen-interior": ("nxt-gen-main.jpg", (480, 800, 1400)),
    "gallery/pale-blue-glass-detail": ("colour-main.jpg", (480, 800, 1400)),
    "gallery/three-quarter-glass": ("3-quarter.jpg", (480, 800, 1400)),
    "gallery/blue-door-interior": ("mr-blue-sky.jpg", (480, 800, 1400)),
    "glass/lunna": ("Lunna.jpg", (360,)),
    "glass/chatsworth": ("Chatsworth-Close-Up-3.jpg", (360,)),
    "glass/wentworth": ("Wentworth-Close-Up-2.jpg", (360,)),
    "glass/andorra": ("Andorra-Zinc.jpg", (360,)),
    "glass/scotia": ("Scotia-Brass2-min.jpg", (360,)),
    "glass/kara-zinc": ("Kara-Zinc.jpg", (360,)),
}


def write_variant(source: Path, stem: str, width: int) -> None:
    with Image.open(source) as image:
        image = ImageOps.exif_transpose(image).convert("RGB")
        if image.width > width:
            height = round(image.height * width / image.width)
            image = image.resize((width, height), Image.Resampling.LANCZOS)
        output = TARGET / f"{stem}-{width}w.webp"
        output.parent.mkdir(parents=True, exist_ok=True)
        image.save(output, "WEBP", quality=84, method=6)


for output_stem, (source_name, widths) in ASSETS.items():
    source_path = SOURCE / source_name
    if not source_path.exists():
        raise FileNotFoundError(source_path)
    for target_width in widths:
        write_variant(source_path, output_stem, target_width)

print(f"Built {sum(len(widths) for _, widths in ASSETS.values())} composite-door assets in {TARGET}")
