"""Check a saved composite page response against this theme's real catalogue/assets.

Usage: python scripts/check-composite-page.py /path/to/response.html
Read-only. No browser, network access, credentials or form submissions.
"""
import collections
import hashlib
import json
import re
import sys
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import parse_qs, unquote, urlsplit


class Node:
    def __init__(self, tag='', attrs=()):
        self.tag, self.attrs, self.children = tag, dict(attrs), []

    def text(self):
        return ''.join(c.text() if isinstance(c, Node) else c for c in self.children)

    def find(self, predicate):
        return [n for n in self.walk() if predicate(n)]

    def walk(self):
        yield self
        for child in self.children:
            if isinstance(child, Node):
                yield from child.walk()


class Document(HTMLParser):
    VOID = {'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'}

    def __init__(self, html):
        super().__init__(convert_charrefs=True)
        self.root = Node()
        self.stack = [self.root]
        self.feed(html)

    def handle_starttag(self, tag, attrs):
        node = Node(tag, attrs)
        self.stack[-1].children.append(node)
        if tag not in self.VOID:
            self.stack.append(node)

    def handle_endtag(self, tag):
        for index in range(len(self.stack) - 1, 0, -1):
            if self.stack[index].tag == tag:
                self.stack = self.stack[:index]
                break

    def handle_data(self, data):
        self.stack[-1].children.append(data)


theme = Path(__file__).resolve().parents[1]
document = Document(Path(sys.argv[1]).read_text(encoding='utf-8')).root
article, = document.find(lambda n: 'data-composite-page' in n.attrs)
checks = {}


def check(name, condition):
    checks[name] = bool(condition)


normalise = lambda s: re.sub(r'\s+', ' ', s).strip()
headings = article.find(lambda n: n.tag == 'h1')
check('one product-led H1', len(headings) == 1 and normalise(headings[0].text()) == 'Distinction composite doors')
why_distinction_links = article.find(lambda n: n.tag == 'a' and urlsplit(n.attrs.get('href', '')).path == '/why-distinction/')
check('Why Distinction is linked in the hero and product information', len(why_distinction_links) >= 2)
hero_facts = article.find(lambda n: 'fg-cdoor-hero__facts' in n.attrs.get('class', ''))
check('hero carries three concrete facts', len(hero_facts) == 1 and len(hero_facts[0].find(lambda n: n.tag == 'li')) == 3)
product_info = article.find(lambda n: n.attrs.get('aria-labelledby') == 'composite-distinction-title')
check('Distinction product information is present', len(product_info) == 1 and all(term in normalise(product_info[0].text()) for term in ['BS 6375-1', '25-year slab warranty', 'CFC-free polyurethane core', 'four million doors']))
doorset_info = article.find(lambda n: n.attrs.get('aria-labelledby') == 'composite-spec-title')
check('complete doorset guidance is present', len(doorset_info) == 1 and all(term in normalise(doorset_info[0].text()) for term in ['U-value', 'threshold', 'hinge side', 'ten-year insurance-backed installation guarantee']))
ordered_markers = [
    'composite-distinction-title',
    'composite-build-title',
    'composite-spec-title',
    'composite-range-title',
    'composite-glass-title',
    'composite-colour-title',
    'fg-door-handle-finishes-title',
    'composite-proof-title',
    'composite-faq-title',
    'composite-quote-title',
    'composite-enquiry-title',
]
article_ids = [n.attrs['id'] for n in article.walk() if 'id' in n.attrs]
check('sections run from reasons and specification to choices and enquiry', all(marker in article_ids for marker in ordered_markers) and [article_ids.index(marker) for marker in ordered_markers] == sorted(article_ids.index(marker) for marker in ordered_markers))
check('door finder quiz is absent', not article.find(lambda n: 'data-cdoor-assist' in n.attrs or 'fg-cdoor-assist' in n.attrs.get('class', '')))
ids = [n.attrs['id'] for n in document.walk() if 'id' in n.attrs]
duplicates = [value for value, count in collections.Counter(ids).items() if count > 1]
check('unique document IDs', not duplicates)
description, = document.find(lambda n: n.tag == 'meta' and n.attrs.get('name') == 'description')
check('complete meta description within 160 characters', 50 < len(description.attrs['content']) <= 160 and description.attrs['content'].endswith('.'))
canonical, = document.find(lambda n: n.tag == 'link' and n.attrs.get('rel') == 'canonical')
check('production canonical', canonical.attrs['href'] == 'https://fensterglazing.com/composite-doors/')

schemas = [json.loads(n.text()) for n in document.find(lambda n: n.tag == 'script' and n.attrs.get('type') == 'application/ld+json')]
faq_schemas = [s for s in schemas if s.get('@type') == 'FAQPage']
faq_section, = article.find(lambda n: n.attrs.get('aria-labelledby') == 'composite-faq-title')
visible_faqs = faq_section.find(lambda n: n.tag == 'details')
visible_answers = [normalise(n.find(lambda c: c.tag == 'p')[0].text()) for n in visible_faqs]
schema_answers = [normalise(n['acceptedAnswer']['text']) for n in faq_schemas[0]['mainEntity']] if len(faq_schemas) == 1 else []
check('six FAQ answers match structured data exactly', len(visible_answers) == 6 and visible_answers == schema_answers)
check('FAQ answers render without JavaScript', all(len(answer) > 80 for answer in visible_answers))

styles = article.find(lambda n: 'data-cdoor-style' in n.attrs)
style_keys = []
for node in styles:
    link, = node.find(lambda n: n.tag == 'a')
    query = parse_qs(urlsplit(link.attrs['href']).query)
    check('style ' + query.get('style', ['MISSING'])[0], query.get('interface') == ['composite'] and query.get('product') == ['4'])
    style_keys.extend(query.get('style', []))
check('142 unique server-rendered styles', len(styles) == len(set(style_keys)) == 142)
check('six collections', len(article.find(lambda n: 'data-cdoor-collection' in n.attrs)) == 6)

urls = set()
for node in article.walk():
    for key in ('src', 'data-image'):
        if node.attrs.get(key):
            urls.add(node.attrs[key])
    for part in node.attrs.get('srcset', '').split(','):
        if part.strip():
            urls.add(part.strip().split(' ')[0])
missing = []
for url in urls:
    path = unquote(urlsplit(url).path)
    if '/themes/fenster/' not in path:
        continue
    relative = path.split('/themes/fenster/', 1)[1]
    if not (theme / relative).is_file():
        missing.append(relative)
check('all referenced local images exist', not missing)

photo_hashes = collections.defaultdict(list)
for node in article.find(lambda n: n.tag == 'img' and n.attrs.get('src')):
    path = unquote(urlsplit(node.attrs['src']).path)
    if '/themes/fenster/' not in path or path.endswith('.svg'):
        continue
    relative = path.split('/themes/fenster/', 1)[1]
    asset = theme / relative
    if asset.is_file():
        photo_hashes[hashlib.sha256(asset.read_bytes()).hexdigest()].append(relative)
repeated_photos = [paths for paths in photo_hashes.values() if len(paths) > 1]
check('no repeated raster images in page content', not repeated_photos)
check('no empty iframe src', not article.find(lambda n: n.tag == 'iframe' and n.attrs.get('src') == ''))
enquiry_sections = article.find(lambda n: n.tag == 'section' and 'fg-enquiry' in n.attrs.get('class', '').split())
enquiry_forms = article.find(lambda n: n.tag == 'form' and 'fg-enquiry-form' in n.attrs.get('class', ''))
check('one shared enquiry section and form', len(enquiry_sections) == 1 and len(enquiry_forms) == 1 and 'fg-form' in enquiry_forms[0].attrs.get('class', '').split())
check('no composite-specific form skin', not article.find(lambda n: 'fg-cdoor-form' in n.attrs.get('class', '').split()))
check('no legacy composite page assembly', not document.find(lambda n: 'generated-page--composite-doors' in n.attrs.get('class', '')))

internal_links = sorted(set(n.attrs['href'] for n in article.find(lambda n: n.tag == 'a' and '/windowcad7/' not in n.attrs.get('href', '') and n.attrs.get('href', '').startswith('http'))))
result = {'passed': sum(checks.values()), 'total': len(checks), 'failed': [n for n, passed in checks.items() if not passed], 'missing_assets': missing, 'duplicate_ids': duplicates, 'repeated_photos': repeated_photos, 'styles': len(styles), 'asset_urls': len(urls), 'faqs': len(visible_faqs), 'description': description.attrs['content'], 'internal_and_review_links': internal_links}
print(json.dumps(result, indent=2, ensure_ascii=False))
sys.exit(0 if all(checks.values()) else 1)
