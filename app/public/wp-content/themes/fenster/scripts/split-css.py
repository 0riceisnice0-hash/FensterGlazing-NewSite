"""Split assets/css/main.css into the shared sheet and one sheet per template part.

SEO plan 10/11/2026, 5.4. main.css was one 891 KB render-blocking file on every
page, much of it rules for one product page or another.

WHICH RULES MAY MOVE

1. Ownership. A class is OWNED by a template part when its name appears, as a
   whole word, in exactly one file of the theme, and that file is under
   template-parts/ (not layout/, not NEVER_SPLIT). A selector belongs to a part
   when one of the classes it requires (outside :not/:is/:where/:has) is owned
   by that part: it can only match on a page that rendered that part. A rule
   is a candidate when every selector in its list belongs to the same part.

2. Cascade order. A part sheet loads after main.css, so a moved rule now comes
   after every rule left in main.css, and part sheets come in the order the
   parts render. That only changes the result where two rules set the same
   property on the same element WITH EQUAL SPECIFICITY (a more specific rule
   wins wherever it is; a less specific one never won). The first attempt on
   10/11/2026 skipped this and the per-element comparison on test caught it:
   phone layouts on the commercial hub, casement, contact and roof lantern
   pages changed. So a candidate stays in main.css when any rule outside its
   own part, later in the original source (or earlier, if in another part),
   has the same specificity and pseudo-element, sets an overlapping property,
   appears with it on one page of the site (every class each requires, as far
   as the site's markup shows them), and could match the same element:
     - their subjects share a class, or
     - an element seen on the site carries both subjects' classes
       (scripts/split-css-classsets.json, every class attribute on the 743
       sitemap pages of test on 10/11/2026), or
     - either subject has no class the site's markup shows (a tag, or a state
       class added by JavaScript), and their tags are compatible.
   This repeats until nothing changes, because keeping one rule changes what
   the others are compared against.

3. Parts whose moved rules come to under MIN_BYTES stay whole.

Run after sass (npm run build:css does it); it rewrites main.css in place, so
it must run on fresh sass output. Refresh the class sets when templates gain
new class combinations: scratch crawl, then replace split-css-classsets.json.

    python scripts/split-css.py            # split
    python scripts/split-css.py --report   # sizes only, writes nothing
"""

import json
import os
import re
import sys

THEME = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CSS = os.path.join(THEME, 'assets', 'css', 'main.css')
OUT_DIR = os.path.join(THEME, 'assets', 'css', 'parts')
MANIFEST = os.path.join(OUT_DIR, 'manifest.json')
CLASS_SETS = os.path.join(THEME, 'scripts', 'split-css-classsets.json')
MIN_BYTES = 6000

NEVER_SPLIT = {
    # The classic homepage is live's homepage, and test cannot render it (3.0
    # holds the homepage there), so its rules could not be checked: kept whole.
    'template-parts/sections/home-experience.php',
    # Rendered on nearly every page (742, 682 and 565 of 742 sitemap URLs on
    # 10/11/2026): a separate sheet would only add a request.
    'template-parts/components/legend-assistant.php',
    'template-parts/components/enquiry-form.php',
    'template-parts/components/review-showcase.php',
    # The shells every generated page renders through.
    'template-parts/sections/generated-page.php',
    'template-parts/sections/generated-simple.php',
    'template-parts/sections/content-page.php',
}

GROUPING = ('@media', '@supports', '@container')


def read(path):
    with open(path, encoding='utf-8', errors='replace') as handle:
        return handle.read()


def corpus():
    files = {}
    for root, dirs, names in os.walk(THEME):
        rel_root = os.path.relpath(root, THEME).replace('\\', '/')
        if rel_root.startswith(('node_modules', 'assets', '.git', 'scripts', 'vendor')):
            dirs[:] = []
            continue
        for name in names:
            if name.endswith(('.php', '.js', '.json', '.html', '.mjs', '.cjs')):
                rel = (rel_root + '/' + name) if rel_root != '.' else name
                files[rel] = read(os.path.join(root, name))
    return files


def parse_blocks(text):
    """Top-level (prelude, body) pairs of compressed CSS; body None for statements."""
    blocks, i, end = [], 0, len(text)
    while i < end:
        j, quote = i, None
        while j < end:
            ch = text[j]
            if quote:
                if ch == '\\':
                    j += 2
                    continue
                if ch == quote:
                    quote = None
            elif ch in '"\'':
                quote = ch
            elif ch in '{;':
                break
            j += 1
        if j >= end:
            break
        prelude = text[i:j].strip()
        if text[j] == ';':
            blocks.append((prelude, None))
            i = j + 1
            continue
        depth, k, quote = 1, j + 1, None
        while k < end and depth:
            ch = text[k]
            if quote:
                if ch == '\\':
                    k += 2
                    continue
                if ch == quote:
                    quote = None
            elif ch in '"\'':
                quote = ch
            elif ch == '{':
                depth += 1
            elif ch == '}':
                depth -= 1
            k += 1
        blocks.append((prelude, text[j + 1:k - 1]))
        i = k
    return blocks


def split_top(text, sep):
    parts, depth, quote, current = [], 0, None, ''
    for ch in text:
        if quote:
            current += ch
            if ch == quote:
                quote = None
            continue
        if ch in '"\'':
            quote = ch
        elif ch in '([':
            depth += 1
        elif ch in ')]':
            depth -= 1
        elif ch == sep and depth == 0:
            parts.append(current)
            current = ''
            continue
        current += ch
    parts.append(current)
    return [part.strip() for part in parts if part.strip()]


FUNCTIONAL = re.compile(r':(?:not|is|where|has|matches|-webkit-any|-moz-any)\(')


def strip_functional(selector):
    """The selector with functional pseudo-classes removed, plus their bodies."""
    out, inner, i = '', [], 0
    while i < len(selector):
        match = FUNCTIONAL.match(selector, i)
        if match:
            depth, k = 1, match.end()
            while k < len(selector) and depth:
                if selector[k] == '(':
                    depth += 1
                elif selector[k] == ')':
                    depth -= 1
                k += 1
            inner.append((match.group(0)[1:-1], selector[match.end():k - 1]))
            i = k
            continue
        out += selector[i]
        i += 1
    return out, inner


def required_classes(selector):
    out, _ = strip_functional(selector)
    out = re.sub(r'\[[^\]]*\]', '', out)
    return set(re.findall(r'\.(-?[_a-zA-Z][_a-zA-Z0-9-]*)', out))


def specificity(selector):
    out, inner = strip_functional(selector)
    ids = len(re.findall(r'#[_a-zA-Z-]', out))
    attrs = len(re.findall(r'\[[^\]]*\]', out))
    out = re.sub(r'\[[^\]]*\]', '', out)
    classes = len(re.findall(r'\.[_a-zA-Z-]', out))
    pseudo_el = len(re.findall(r'::[a-zA-Z-]+', out)) + len(re.findall(r'(?<!:):(?:before|after|first-line|first-letter)\b', out))
    pseudo_cl = len(re.findall(r'(?<!:):(?!:)[a-zA-Z-]+', out)) - len(re.findall(r'(?<!:):(?:before|after|first-line|first-letter)\b', out))
    tags = len(re.findall(r'(?:^|[\s>+~])([a-zA-Z][a-zA-Z0-9]*)', out))
    spec = [ids, classes + attrs + pseudo_cl, tags + pseudo_el]
    for name, body in inner:
        if name == 'where':
            continue
        best = max((specificity(part) for part in split_top(body, ',')), default=(0, 0, 0))
        spec = [spec[0] + best[0], spec[1] + best[1], spec[2] + best[2]]
    return tuple(spec)


def subject(selector):
    """(classes, tag, pseudo-element) of the rightmost compound selector."""
    out, _ = strip_functional(selector)
    compounds = re.split(r'\s*[\s>+~]\s*', out.strip())
    last = compounds[-1] if compounds else ''
    pseudo = ''
    match = re.search(r'::?(before|after|placeholder|marker|selection|first-line|first-letter|backdrop|-webkit-[a-z-]+|-moz-[a-z-]+)', last)
    if match:
        pseudo = match.group(1)
    bare = re.sub(r'\[[^\]]*\]', '', last)
    tag_match = re.match(r'([a-zA-Z][a-zA-Z0-9]*)', bare)
    if ':root' in bare:
        return set(), 'html', pseudo
    return set(re.findall(r'\.(-?[_a-zA-Z][_a-zA-Z0-9-]*)', bare)), (tag_match.group(1).lower() if tag_match else ''), pseudo


ROOTS = {'top': 'inset', 'right': 'inset', 'bottom': 'inset', 'left': 'inset', 'inset': 'inset',
         'row': 'gap', 'column': 'gap', 'gap': 'gap', 'place': 'align', 'align': 'align', 'justify': 'align',
         'line': 'font', 'font': 'font', 'overflow': 'overflow', 'grid': 'grid', 'flex': 'flex', 'order': 'flex'}


def prop_roots(body):
    roots = set()
    for decl in split_top(body, ';'):
        name = decl.split(':', 1)[0].strip().lower()
        if not name:
            continue
        if name.startswith('--'):
            roots.add(name)  # a custom property only collides with itself
            continue
        name = re.sub(r'^-(webkit|moz|ms|o)-', '', name)
        head = name.split('-')[0]
        roots.add(ROOTS.get(head, head))
    return roots


def main():
    css = read(CSS)
    files = corpus()

    # Flatten: one record per rule, in source order, with its grouping at-rule.
    records = []
    for prelude, body in parse_blocks(css):
        if body is not None and prelude.startswith(GROUPING):
            for inner_prelude, inner_body in parse_blocks(body):
                records.append({'group': prelude, 'prelude': inner_prelude, 'body': inner_body})
        else:
            records.append({'group': None, 'prelude': prelude, 'body': body})

    every_class = set()
    for rec in records:
        if rec['body'] is not None and not rec['prelude'].startswith('@'):
            for sel in split_top(rec['prelude'], ','):
                every_class |= required_classes(sel)

    seen_in = {}
    for path, text in files.items():
        for word in set(re.findall(r'[A-Za-z0-9_-]+', text)):
            seen_in.setdefault(word, []).append(path)

    owner = {}
    for name in every_class:
        where = seen_in.get(name, [])
        if len(where) == 1 and where[0].startswith('template-parts/') \
                and not where[0].startswith('template-parts/layout/') \
                and where[0] not in NEVER_SPLIT:
            owner[name] = where[0]

    data = json.load(open(CLASS_SETS, encoding='utf-8'))
    class_sets = [{data['classes'][i] for i in s} for s in data['elements']]
    page_sets = [{data['classes'][i] for i in p} for p in data['pages']]
    observed = set(data['classes'])
    pages_with = {}
    for index, page in enumerate(page_sets):
        for name in page:
            pages_with.setdefault(name, set()).add(index)

    def share_a_page(classes):
        """Whether one page of the site carries every one of `classes`."""
        indexes = None
        for name in classes:
            found = pages_with.get(name, set())
            indexes = found if indexes is None else indexes & found
            if not indexes:
                return False
        return True
    sets_with = {}
    for index, s in enumerate(class_sets):
        for name in s:
            sets_with.setdefault(name, set()).add(index)

    def co_classes(classes):
        """Every class seen on an element that also carries all of `classes`."""
        indexes = None
        for name in classes:
            found = sets_with.get(name, set())
            indexes = found if indexes is None else indexes & found
        out = set()
        for index in indexes or ():
            out |= class_sets[index]
        return out

    for index, rec in enumerate(records):
        rec['index'] = index
        rec['target'] = None
        rec['subjects'] = []
        if rec['body'] is None or rec['prelude'].startswith('@'):
            continue
        parts = set()
        for sel in split_top(rec['prelude'], ','):
            owners = {owner[c] for c in required_classes(sel) if c in owner}
            parts = parts | owners if len(owners) == 1 else {None, 'x', 'y'}
            classes, tag, pseudo = subject(sel)
            known = classes & observed
            # A class only this part prints that no page of the site shows: the
            # selector matches nothing anywhere the site was measured, so it
            # cannot override or be overridden there.
            if any(c in owner and c not in observed for c in required_classes(sel)):
                continue
            rec['subjects'].append({'spec': specificity(sel), 'classes': classes, 'known': known, 'tag': tag,
                                    'page': required_classes(sel) & observed,
                                    'pseudo': pseudo, 'co': co_classes(known) if known else None})
        rec['target'] = parts.pop() if len(parts) == 1 else None
        rec['props'] = prop_roots(rec['body'])

    # Index every style rule by (specificity, pseudo-element) for the pair check.
    by_key = {}
    for rec in records:
        for sub in rec['subjects']:
            by_key.setdefault((sub['spec'], sub['pseudo']), []).append((rec, sub))

    def same_element(a, b):
        if not share_a_page(a['page'] | b['page']):
            return False
        if a['classes'] & b['classes']:
            return True
        if not a['known'] or not b['known']:
            return not a['tag'] or not b['tag'] or a['tag'] == b['tag']
        return b['known'] <= (a['co'] or set())

    def unsafe(rec):
        for sub in rec['subjects']:
            for other, osub in by_key.get((sub['spec'], sub['pseudo']), ()):
                if other is rec or other['target'] == rec['target']:
                    continue
                if other['index'] < rec['index'] and other['target'] is None:
                    continue  # an earlier rule left in main.css still comes first
                if not (rec['props'] & other['props']):
                    continue
                if same_element(sub, osub):
                    return True
        return False

    def settle():
        changed = True
        while changed:
            changed = False
            for rec in records:
                if rec['target'] is not None and unsafe(rec):
                    rec['target'] = None
                    changed = True

    settle()
    while True:
        sizes = {}
        for rec in records:
            if rec['target']:
                sizes[rec['target']] = sizes.get(rec['target'], 0) + len(rec['prelude']) + len(rec['body']) + 2
        small = {part for part, size in sizes.items() if size < MIN_BYTES}
        if not small:
            break
        for rec in records:
            if rec['target'] in small:
                rec['target'] = None
        settle()

    def render(recs):
        out, open_group = [], None
        for rec in recs:
            text = rec['prelude'] + (';' if rec['body'] is None else '{' + rec['body'] + '}')
            if rec['group'] != open_group:
                if open_group is not None:
                    out.append('}')
                if rec['group'] is not None:
                    out.append(rec['group'] + '{')
                open_group = rec['group']
            out.append(text)
        if open_group is not None:
            out.append('}')
        return ''.join(out)

    kept = [rec for rec in records if rec['target'] is None]
    moved = {}
    for rec in records:
        if rec['target']:
            moved.setdefault(rec['target'], []).append(rec)

    total = len(css)
    main_css = render(kept)
    print(f'main.css {total:,} bytes -> {len(main_css):,}; {len(moved)} part sheets')
    for part, recs in sorted(moved.items(), key=lambda item: -len(render(item[1]))):
        print(f'  {len(render(recs)):>9,}  {part}')
    if '--report' in sys.argv:
        return

    os.makedirs(OUT_DIR, exist_ok=True)
    for name in os.listdir(OUT_DIR):
        if name.endswith('.css'):
            os.remove(os.path.join(OUT_DIR, name))
    manifest = {}
    for part, recs in moved.items():
        slug = part[len('template-parts/'):-len('.php')]
        filename = slug.replace('/', '--') + '.css'
        with open(os.path.join(OUT_DIR, filename), 'w', encoding='utf-8', newline='\n') as handle:
            handle.write(render(recs))
        manifest['template-parts/' + slug] = filename
    with open(MANIFEST, 'w', encoding='utf-8', newline='\n') as handle:
        json.dump(manifest, handle, indent=1, sort_keys=True)
        handle.write('\n')
    with open(CSS, 'w', encoding='utf-8', newline='\n') as handle:
        handle.write(main_css)


if __name__ == '__main__':
    main()
