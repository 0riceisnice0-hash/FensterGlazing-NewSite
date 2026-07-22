"""Build the composite door wall and paint palette assets.

Source: the owner-supplied Distinction Doors scrape at
    C:\\Users\\zacpl\\Documents\\Codex\\2026-06-04\\i-need-you-to-build-a\\outputs\\distinctiondoors_scrape

Outputs (committed to the theme, so the scrape is never a runtime dependency):
    assets/images/products/composite-distinction/styles/<slug>-{300,600}w.webp
    assets/images/products/composite-distinction/palette/<slug>-{160,320}w.webp

Style names are taken from the Distinction Signature and Contemporary product
pages in the same scrape; do not invent names for door codes that are not
listed there.

Run:  python scripts/build-composite-door-wall.py
"""

import os

from PIL import Image

SCRAPE = (
    r"C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a"
    r"\outputs\distinctiondoors_scrape\images"
)
THEME = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
STYLES_OUT = os.path.join(
    THEME, "assets", "images", "products", "composite-distinction", "styles"
)
PALETTE_OUT = os.path.join(
    THEME, "assets", "images", "products", "composite-distinction", "palette"
)
COLOUR_DOORS_OUT = os.path.join(
    THEME, "assets", "images", "products", "composite-distinction", "colour-doors"
)

# (source file, slug, visible style name, collection)
#
# Collections are FENSTER's, taken from the WindowCAD retail door designer
# (Traditional, Esprit, Rustic Renown, Renown, Infinity, Stable Doors), NOT
# Distinction's own Signature/Contemporary split. The website and the quote
# tool must agree, so if WindowCAD's door-style groups change, change these.
DOORS = [
    ("sign_CL01-6panel.jpg", "6-panel", "6 Panel", "Traditional"),
    ("sign_CL02-classical.jpg", "classical", "Classical", "Traditional"),
    ("sign_CL03-classical-half-glazed.jpg", "classical-half-glazed", "Classical Half Glazed", "Traditional"),
    ("sign_EC01-eclat.jpg", "eclat", "Eclat", "Traditional"),
    ("sign_EC02-eclat-arch.jpg", "eclat-arch", "Eclat Arch", "Traditional"),
    ("sign_EC04-eclat-arch.jpg", "eclat-arch-grid", "Eclat Arch with Grid", "Traditional"),
    ("sign_EC05-eclat-craftsman.jpg", "eclat-craftsman", "Eclat Craftsman", "Traditional"),
    ("sign_EC06-eclat-craftsman-half-glaze.jpg", "eclat-craftsman-half-glazed", "Eclat Craftsman Half Glazed", "Traditional"),
    ("sign_EL01-elegance.jpg", "elegance", "Elegance", "Traditional"),
    ("sign_EL02-elegance-arch.jpg", "elegance-arch", "Elegance Arch", "Traditional"),
    ("sign_EL05-elegance-with-grid.jpg", "elegance-grid", "Elegance with Grid", "Traditional"),
    ("sign_EL06-elegance-arch-with-grid.jpg", "elegance-arch-grid", "Elegance Arch with Grid", "Traditional"),
    ("sign_ES01-new-england.jpg", "new-england", "New England", "Traditional"),
    ("sign_ES02-esteem.jpg", "esteem", "Esteem", "Traditional"),
    ("sign_ES03-esteem-arch.jpg", "esteem-arch", "Esteem Arch", "Traditional"),
    ("sign_ES04-esteem-eyebrow-1.jpg", "esteem-eyebrow", "Esteem Eyebrow", "Traditional"),
    ("sign_ES10-new-england-quarter-scaled.jpg", "new-england-quarter", "New England Quarter", "Traditional"),
    ("sign_PR01-9panel.jpg", "9-panel", "9 Panel", "Traditional"),
    ("sign_ESP01-flush.jpg", "esp01-flush", "Flush", "Esprit"),
    ("ESC19C_Duck-Egg.jpg", "esprit-esc19", "Esprit ESC19", "Esprit"),
    # Stable doors. The horizontal bar across the middle IS the stable split,
    # confirmed by the owner picking RES05_02 (which has it) over RES05 (which
    # does not). RES05 itself is therefore not a stable door and is left out.
    ("sign_RES05_02-scaled.jpg", "stable-half-glazed", "Stable, half glazed", "Stable Doors"),
    ("sign_RES03-scaled.jpg", "stable-diamond", "Stable, diamond glass", "Stable Doors"),
    ("sign_RES01-scaled.jpg", "stable-solid", "Stable, solid", "Stable Doors"),
    ("door-sign-stable.jpg", "stable-cottage", "Stable, cottage", "Stable Doors"),
    # Rustic Renown: tongue and groove boards inside a border. This is RR03
    # Diamond in Basalt Grey, taken from the Rustic Renown pages of the
    # Distinction brochure, which are flat renders rather than photographs.
    ("../pdf_images/Premium-DD-Brochure-page-25-image-01.jpeg", "rustic-renown-rr03", "Rustic Renown RR03", "Rustic Renown"),
    ("../pdf_images/Premium-DD-Brochure-page-24-image-23.jpeg", "rustic-renown-glazed", "Rustic Renown, glazed", "Rustic Renown"),
    ("sign_RE01-cottage-scaled.jpg", "retail-cottage", "Cottage", "Renown"),
    ("sign_RE02-renown-scaled.jpg", "renown", "Renown", "Renown"),
    ("sign_RE03-renown-diamond-scaled.jpg", "renown-diamond", "Renown Diamond", "Renown"),
    ("sign_RE04-renown-top-scaled.jpg", "renown-top", "Renown Top", "Renown"),
    ("sign_RE06-renown-full-moon-horizontal-scaled.jpg", "renown-full-moon", "Renown Full Moon", "Renown"),
    ("GD01-70-Slate.jpg", "infinity-gd01", "Infinity GD01", "Infinity"),
    ("GD12-Purple-Violet.jpg", "infinity-gd12", "Infinity GD12", "Infinity"),
]

# Doors photographed in a named Distinction paint colour, for the colour wall
# preview. The slug matches the PALETTE slug below so the two line up. Only add
# a door here when the source filename names the colour: never guess a colour
# from a render, and never tint one.
COLOUR_DOORS = [
    ("GD01-70-Slate.jpg", "slate-grey"),
    ("REC05-70-Distinction-Buckingham-Grey.jpg", "buckingham-grey"),
    ("EL01-70-Elegance-Green-1.jpg", "standard-green"),
    ("REC09C-70-Traffic-Red-scaled-1.jpg", "traffic-red"),
    ("Cottage-Distinction-Wine-Red-1.jpg", "wine-red"),
    ("GD12-Purple-Violet.jpg", "purple-violet"),
    ("CL01-70-Colza-Yellow.jpg", "colza-yellow"),
    ("RE06-70-Distinction-Black-Brown.jpg", "black-brown"),
    ("Diamond-rustic-Renown-Basalt-Grey@2x.jpg", "basalt-grey", "", "", (0.35, 0.215, 0.65, 0.945)),
]

# Distinction's own paint range, photographed as brush strokes.
# (source file, slug, visible colour name)
PALETTE = [
    ("Standard-Black-min.png", "standard-black", "Standard Black"),
    ("Premium-Anthracite-Grey-min.png", "anthracite-grey", "Anthracite Grey"),
    ("Distinction-Slate-Grey-min.png", "slate-grey", "Slate Grey"),
    ("Distinction-Basalt-Grey-min.png", "basalt-grey", "Basalt Grey"),
    ("Distinction-Buckingham-Grey-min.png", "buckingham-grey", "Buckingham Grey"),
    ("Premium-Distinction-Chartwell-min.png", "chartwell-green", "Chartwell Green"),
    ("Standard-Green-min.png", "standard-green", "Standard Green"),
    ("pale-Green-min.png", "pale-green", "Pale Green"),
    ("leaf-green-min.png", "leaf-green", "Leaf Green"),
    ("Standard-Blue-min.png", "standard-blue", "Standard Blue"),
    ("Distant-Blue-min.png", "distant-blue", "Distant Blue"),
    ("Distinction-Steel-Blue-min.png", "steel-blue", "Steel Blue"),
    ("Ultramarine-Blue-min.png", "ultramarine-blue", "Ultramarine Blue"),
    ("Turquoise-Blue-min.png", "turquoise-blue", "Turquoise Blue"),
    ("Standard-Red-min.png", "standard-red", "Standard Red"),
    ("Traffic-Red-min.png", "traffic-red", "Traffic Red"),
    ("Distinction-Wine-Red-min.png", "wine-red", "Wine Red"),
    ("Telemagenta-min.png", "telemagenta", "Telemagenta"),
    ("Purple-Violet-min.png", "purple-violet", "Purple Violet"),
    ("Colza-Yellow-min.png", "colza-yellow", "Colza Yellow"),
    ("Distinction-Black-Brown-min.png", "black-brown", "Black Brown"),
    ("Gold-Oak-Stain-min.png", "gold-oak", "Gold Oak Stain"),
    ("Rosewood-Stain-min.png", "rosewood", "Rosewood Stain"),
]


def flatten(image):
    """Composite any alpha onto white so JPEG-style sources stay consistent."""
    image = image.convert("RGBA")
    canvas = Image.new("RGBA", image.size, (255, 255, 255, 255))
    canvas.alpha_composite(image)
    return canvas.convert("RGB")


def build(entries, out_dir, widths, quality=82):
    os.makedirs(out_dir, exist_ok=True)
    total = 0
    for source, slug, *rest in entries:
        path = os.path.join(SCRAPE, source)
        if not os.path.exists(path):
            print("MISSING", source)
            continue
        image = flatten(Image.open(path))
        # An optional trailing (left, top, right, bottom) fraction box crops a
        # door out of a lifestyle photograph.
        crop = rest[2] if len(rest) > 2 and isinstance(rest[2], tuple) else None
        if crop:
            width, height = image.size
            image = image.crop((
                int(width * crop[0]), int(height * crop[1]),
                int(width * crop[2]), int(height * crop[3]),
            ))
        for width in widths:
            height = round(image.height * width / image.width)
            out = os.path.join(out_dir, f"{slug}-{width}w.webp")
            image.resize((width, height), Image.LANCZOS).save(
                out, "WEBP", quality=quality, method=6
            )
            total += os.path.getsize(out)
    return total


if __name__ == "__main__":
    doors = build(DOORS, STYLES_OUT, (300, 600))
    print(f"{len(DOORS)} door styles -> {STYLES_OUT} ({doors / 1024:.0f} KB)")
    palette = build(PALETTE, PALETTE_OUT, (160, 320))
    print(f"{len(PALETTE)} paint colours -> {PALETTE_OUT} ({palette / 1024:.0f} KB)")
    doors = build(COLOUR_DOORS, COLOUR_DOORS_OUT, (400, 800))
    print(f"{len(COLOUR_DOORS)} colour doors -> {COLOUR_DOORS_OUT} ({doors / 1024:.0f} KB)")
