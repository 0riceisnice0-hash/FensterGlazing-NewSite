"""Build the smaller copies of every photograph the blog shows.

Blog cards are 280-370px wide and the article hero about 560px, but the product
photographs they come from are often 1600-2560px JPEGs. This writes WebP copies
at 480, 960 and 1440px wide (never wider than the source) to assets/blog/img/,
named <first 12 of md5(theme-relative path)>-<width>w.webp. PHP finds them from
the source path alone (fenster_blog_image_variants() in inc/blog-posts.php), so
there is no manifest to keep in step, and a photograph without copies simply
falls back to the original.

Which photographs: the first six of each product pool (hero, card, gallery, as
fenster_blog_post_image_pool() orders them) for every product a post names, and
the first four photographs of each imported guide. Re-run after adding posts
or changing product_media; it only writes what is missing or stale.

Run from the theme directory:  python scripts/build-blog-images.py
"""

import hashlib
import json
import re
from pathlib import Path

from PIL import Image, ImageOps

THEME = Path(__file__).resolve().parents[1]
OUT = THEME / "assets" / "blog" / "img"
WIDTHS = (480, 960, 1440)
POOL_DEPTH = 6
GUIDE_DEPTH = 4


def theme_relative(src: str) -> str | None:
    marker = "/themes/fenster/"
    if marker not in src:
        return None
    relative = src.split(marker, 1)[1].split("?", 1)[0]
    return relative if (THEME / relative).is_file() else None


def post_products() -> list[str]:
    source = (THEME / "inc" / "blog-posts.php").read_text(encoding="utf-8")
    products: list[str] = []
    for block in re.findall(r"'products'\s*=>\s*\[([^\]]*)\]", source):
        for slug in re.findall(r"'([a-z0-9-]+)'", block):
            if slug not in products:
                products.append(slug)
    return products


def product_pools() -> dict[str, list[str]]:
    """Each product's photographs from product_media in inc/site-data.php, in
    the order the blog uses them: hero, card, then gallery."""
    source = (THEME / "inc" / "site-data.php").read_text(encoding="utf-8")
    start = source.index("'product_media' => [")
    pools: dict[str, list[str]] = {}
    current = None
    hero: list[str] = []
    card: list[str] = []
    gallery: list[str] = []

    def close() -> None:
        if current is not None:
            ordered: list[str] = []
            for src in hero + card + gallery:
                if src not in ordered:
                    ordered.append(src)
            pools[current] = ordered

    for line in source[start:].splitlines()[1:]:
        product = re.match(r"^ {12}'([a-z0-9-]+)' => \[", line)
        if product:
            close()
            current, hero, card, gallery = product.group(1), [], [], []
            continue
        if re.match(r"^ {8}\],?\s*$", line):
            break
        src = re.search(r"'src' => '([^']+)'", line)
        if current is None or not src:
            continue
        if "'hero' =>" in line:
            hero.append(src.group(1))
        elif "'card' =>" in line:
            card.append(src.group(1))
        else:
            gallery.append(src.group(1))
    close()
    return pools


def guide_photographs() -> list[str]:
    source = (THEME / "inc" / "blog-posts.php").read_text(encoding="utf-8")
    listing = source[source.index("function fenster_blog_legacy_article_slugs"):]
    listing = listing[: listing.index("];")]
    guides = set(re.findall(r"'([a-z0-9-]+)'", listing))
    pages = json.loads((THEME / "data" / "pages.json").read_text(encoding="utf-8"))["pages"]
    photographs: list[str] = []
    for page in pages:
        if page.get("slug") in guides:
            photographs += [image.get("src", "") for image in (page.get("images") or [])[:GUIDE_DEPTH]]
    return photographs


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    pools = product_pools()
    sources: list[str] = []
    for product in post_products():
        sources += pools.get(product, [])[:POOL_DEPTH]
    sources += guide_photographs()

    written = kept = skipped = 0
    total_bytes = 0
    seen: set[str] = set()
    for src in sources:
        relative = theme_relative(src)
        if relative is None or relative in seen:
            skipped += relative is None
            continue
        seen.add(relative)
        path = THEME / relative
        key = hashlib.md5(relative.encode("utf-8")).hexdigest()[:12]
        with Image.open(path) as opened:
            image = ImageOps.exif_transpose(opened)
            image = image.convert("RGBA" if image.mode in ("RGBA", "LA", "P") else "RGB")
            for width in WIDTHS:
                if width >= image.width:
                    continue
                target = OUT / f"{key}-{width}w.webp"
                if target.exists() and target.stat().st_mtime >= path.stat().st_mtime:
                    kept += 1
                    total_bytes += target.stat().st_size
                    continue
                height = round(image.height * width / image.width)
                image.resize((width, height), Image.LANCZOS).save(target, "WEBP", quality=80, method=6)
                written += 1
                total_bytes += target.stat().st_size
    print(f"{len(seen)} photographs, {written} copies written, {kept} kept, {skipped} not theme files; {total_bytes / 1024:.0f} KB in {OUT.relative_to(THEME)}")


if __name__ == "__main__":
    main()
