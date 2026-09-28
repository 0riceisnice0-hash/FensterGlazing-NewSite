"""Regenerate responsive WebP files from the recorded local source photographs.

Run from any directory with Python and Pillow. No remote or generated imagery.
"""
import hashlib
import json
from pathlib import Path
from PIL import Image, ImageOps

root = Path(__file__).resolve().parents[1]
out = root / 'assets/images/landing'
manifest_path = out / 'manifest.json'
manifest = json.loads(manifest_path.read_text(encoding='utf-8'))
for entry in manifest:
    source = entry['source']
    stem = hashlib.sha256(source.encode()).hexdigest()[:12]
    with Image.open(root / source.lstrip('/')) as original:
        image = ImageOps.exif_transpose(original).convert('RGB')
        outputs = []
        for width in (480, 960, 1600):
            if width > image.width:
                continue
            target = out / f'{stem}-{width}w.webp'
            image.resize((width, round(image.height * width / image.width)), Image.Resampling.LANCZOS).save(target, quality=84, method=6)
            outputs.append({'file': target.name, 'width': width, 'bytes': target.stat().st_size})
        entry['outputs'] = outputs
manifest_path.write_text(json.dumps(manifest, indent=2) + '\n', encoding='utf-8')
print(f'Rebuilt responsive images from {len(manifest)} source photographs.')
