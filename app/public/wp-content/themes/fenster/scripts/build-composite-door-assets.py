from pathlib import Path

from PIL import Image, ImageOps


SOURCE = Path(r"C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape\images")
TARGET = Path(__file__).resolve().parents[1] / "assets" / "images" / "products" / "composite-distinction"


ASSETS = {
    "hero/distinction-signature-entrance": ("colour-main.jpg", (480, 960, 1920)),
    "families/signature": ("Signature-Eclat-with-Lunna-GlazingDOF-1024x1024-2.jpg", (400, 800)),
    "families/contemporary": ("Contemporary-1-V5MAIN-DOF-1024x1024-2.jpg", (400, 800)),
    "families/rustic-renown": ("Diamond-rustic-Renown-Basalt-Grey@2x.jpg", (400, 800)),
    "glass/lunna": ("Lunna.jpg", (360, 720)),
    "glass/chatsworth": ("Chatsworth-Close-Up-3.jpg", (360, 720)),
    "glass/wentworth": ("Wentworth-Close-Up-2.jpg", (360, 720)),
    "glass/andorra": ("Andorra-Zinc.jpg", (360, 720)),
    "glass/scotia": ("Scotia-Brass2-min.jpg", (360, 720)),
    "glass/kara-zinc": ("Kara-Zinc.jpg", (360, 720)),
}

PORTRAIT_ASSETS = {
    "gallery/anthracite-entrance": ("GD01-Anthracite-V1-1024x1024-1.jpg", (480, 800)),
    "gallery/black-lunna-entrance": ("Signature-Eclat-with-Lunna-GlazingDOF-1024x1024-2.jpg", (480, 800)),
    "gallery/ruby-red-entrance": ("GD02-Ruby-Red-Canvas-V2-1024x1024@2x.jpg", (480, 800)),
    "gallery/chartwell-entrance": ("Next-Generation-Eclat-Arch-in-New-Nan-Ya-Chartwell_v3-DOF-Lunna-1024x1024-1.jpg", (480, 800)),
    "gallery/black-chatsworth-entrance": ("Three-quarter-9k-Chatsworth-Black-grey91.jpg", (480, 800)),
    "gallery/white-wentworth-interior": ("REC05-70mm-White-Wentworth-1.jpg", (480, 800)),
    "colours/anthracite-grey": ("GD01-Anthracite-V1-1024x1024-1.jpg", (240, 480, 800)),
    "colours/black": ("Esteem-black-Palma-1024x1024-2.jpg", (240, 480, 800)),
    "colours/light-grey": ("Elegance-Arch-Light-Grey-Monza-1024x1024-1.jpg", (240, 480, 800)),
    "colours/pale-blue": ("colour-main.jpg", (240, 480, 800)),
    "colours/distant-blue": ("GD08L-Distant-Blue-1180x1197-1.jpg", (240, 480, 800)),
    "colours/ruby-red": ("GD02-Ruby-Red-Canvas-V2-1024x1024@2x.jpg", (240, 480, 800)),
    "colours/green": ("green-door.jpg", (240, 480, 800)),
    "colours/white": ("grey-door.jpg", (240, 480, 800)),
    "glass-doors/lunna": ("Signature-Eclat-with-Lunna-GlazingDOF-1024x1024-2.jpg", (240, 480, 800)),
    "glass-doors/chatsworth": ("Three-quarter-9k-Chatsworth-Black-grey91.jpg", (240, 480, 800)),
    "glass-doors/wentworth": ("REC05-70mm-White-Wentworth-1.jpg", (240, 480, 800)),
    "glass-doors/andorra": ("nxt-gen-Eclat-Arch-andorra-blue-V1-1024x1024-1.jpg", (240, 480, 800)),
    "glass-doors/scotia": ("nxt-gen-Classical-Sable-Scotia-Brass-1024x1024-1.jpg", (240, 480, 800)),
    "glass-doors/kara-zinc": ("nxt-gen-Classical-Half-Glazed-Pale-Green-Kara@2x.jpg", (240, 480, 800)),
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


def write_portrait_variant(source: Path, stem: str, width: int) -> None:
    with Image.open(source) as image:
        image = ImageOps.exif_transpose(image).convert("RGB")
        output_size = (width, round(width * 1.25))
        image = ImageOps.fit(
            image,
            output_size,
            method=Image.Resampling.LANCZOS,
            centering=(0.5, 0.5),
        )
        output = TARGET / f"{stem}-{width}w.webp"
        output.parent.mkdir(parents=True, exist_ok=True)
        image.save(output, "WEBP", quality=84, method=6)


for output_stem, (source_name, widths) in ASSETS.items():
    source_path = SOURCE / source_name
    if not source_path.exists():
        raise FileNotFoundError(source_path)
    for target_width in widths:
        write_variant(source_path, output_stem, target_width)

for output_stem, (source_name, widths) in PORTRAIT_ASSETS.items():
    source_path = SOURCE / source_name
    if not source_path.exists():
        raise FileNotFoundError(source_path)
    for target_width in widths:
        write_portrait_variant(source_path, output_stem, target_width)

asset_count = sum(len(widths) for _, widths in ASSETS.values()) + sum(len(widths) for _, widths in PORTRAIT_ASSETS.values())
print(f"Built {asset_count} composite-door assets in {TARGET}")
