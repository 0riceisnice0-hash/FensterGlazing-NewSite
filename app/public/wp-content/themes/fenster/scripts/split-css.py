"""Split assets/css/main.css into the shared sheet and one sheet per template part.

SEO plan 10/11/2026, 5.4. main.css was one 882 KB render-blocking file on every
page, most of it rules for one product page or another.

The rule for moving a rule out is mechanical and conservative:

- A class is OWNED by a template part when its name appears, as a whole word,
  in exactly one file of the theme: one file under template-parts/ (not the
  layout files, which render on every page) and nowhere in inc/, data/, the
  JavaScript or any other template. A class that appears nowhere (built by
  concatenation, added by a plugin) is owned by nobody.
- A selector belongs to a part when one of the classes it REQUIRES (outside
  :not(), :is(), :where() and :has()) is owned by that part. Such a selector
  can only match on a page that rendered that part.
- A rule moves only when every selector in its list belongs to the same part.
  Anything else, every @font-face, @keyframes and @import, stays in main.css.

Each part's sheet is written to assets/css/parts/<part>.css, and
inc/assets.php prints its <link> just before the part renders
(fenster_print_part_stylesheet). Parts whose rules come to under MIN_BYTES stay
in main.css; another request costs more than that saves.

Run after `sass` (npm run build does it):

    python scripts/split-css.py

It rewrites assets/css/main.css in place, so it must run on fresh sass output.
"""

import json
import os
import re
import sys

THEME = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CSS = os.path.join(THEME, 'assets', 'css', 'main.css')
OUT_DIR = os.path.join(THEME, 'assets', 'css', 'parts')
MANIFEST = os.path.join(THEME, 'assets', 'css', 'parts', 'manifest.json')
MIN_BYTES = 6000

# Rendered on every page, or the shell around every page: never a split target.
NEVER_SPLIT = {
    'template-parts/sections/generated-page.php',
    'template-parts/sections/generated-simple.php',
    'template-parts/sections/content-page.php',
}


def read(path):
    with open(path, encoding='utf-8', errors='replace') as handle:
        return handle.read()


def corpus():
    """Every theme file a class name could come from, keyed by theme-relative path."""
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


def parse_blocks(text, start=0, end=None):
    """Top-level blocks of a compressed stylesheet: (prelude, body) pairs.

    A prelude starting with @ and carrying a nested body is returned with its raw
    body; statements such as @charset/@import come back with body None.
    """
    end = len(text) if end is None else end
    blocks = []
    i = start
    while i < end:
        j = i
        quote = None
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
        depth = 1
        k = j + 1
        quote = None
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


def split_selector_list(prelude):
    parts, depth, quote, current = [], 0, None, ''
    for ch in prelude:
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
        elif ch == ',' and depth == 0:
            parts.append(current)
            current = ''
            continue
        current += ch
    parts.append(current)
    return [part.strip() for part in parts if part.strip()]


FUNCTIONAL = re.compile(r':(?:not|is|where|has|matches|-webkit-any|-moz-any)\(')


def required_classes(selector):
    out, i = '', 0
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
            i = k
            continue
        out += selector[i]
        i += 1
    out = re.sub(r'\[[^\]]*\]', '', out)
    return set(re.findall(r'\.(-?[_a-zA-Z][_a-zA-Z0-9-]*)', out))


def main():
    css = read(CSS)
    files = corpus()
    blocks = parse_blocks(css)

    every_class = set()
    for prelude, body in blocks:
        if body is None:
            continue
        if prelude.startswith('@'):
            if prelude.startswith(('@media', '@supports', '@container', '@layer')):
                for inner, _ in parse_blocks(body):
                    for sel in split_selector_list(inner):
                        every_class |= required_classes(sel)
            continue
        for sel in split_selector_list(prelude):
            every_class |= required_classes(sel)

    # Whole-word occurrences, indexed once: a word is a run of [A-Za-z0-9_-],
    # the same boundary a class name has in markup.
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

    def rule_part(prelude):
        parts = set()
        for sel in split_selector_list(prelude):
            owners = {owner[c] for c in required_classes(sel) if c in owner}
            if len(owners) != 1:
                return None
            parts |= owners
        return parts.pop() if len(parts) == 1 else None

    kept, moved = [], {}

    def emit(target, text):
        if target is None:
            kept.append(text)
        else:
            moved.setdefault(target, []).append(text)

    for prelude, body in blocks:
        if body is None:
            kept.append(prelude + ';')
            continue
        if prelude.startswith('@'):
            if prelude.startswith(('@media', '@supports', '@container')):
                inner_kept, inner_moved = [], {}
                for inner_prelude, inner_body in parse_blocks(body):
                    rule = inner_prelude + '{' + (inner_body or '') + '}'
                    target = None if inner_body is None or inner_prelude.startswith('@') else rule_part(inner_prelude)
                    if target is None:
                        inner_kept.append(rule)
                    else:
                        inner_moved.setdefault(target, []).append(rule)
                if inner_kept:
                    kept.append(prelude + '{' + ''.join(inner_kept) + '}')
                for target, rules in inner_moved.items():
                    moved.setdefault(target, []).append(prelude + '{' + ''.join(rules) + '}')
            else:
                kept.append(prelude + '{' + body + '}')
            continue
        emit(rule_part(prelude), prelude + '{' + body + '}')

    # Small parts go back where they came from. Order inside main.css is the
    # original order for everything kept; a part that is put back is appended,
    # so instead, rebuild with the small parts never removed.
    small = {part for part, rules in moved.items() if sum(len(r) for r in rules) < MIN_BYTES}
    if small:
        kept, moved_final = [], {}
        for prelude, body in blocks:
            if body is None:
                kept.append(prelude + ';')
                continue
            if prelude.startswith('@'):
                if prelude.startswith(('@media', '@supports', '@container')):
                    inner_kept, inner_moved = [], {}
                    for inner_prelude, inner_body in parse_blocks(body):
                        rule = inner_prelude + '{' + (inner_body or '') + '}'
                        target = None if inner_body is None or inner_prelude.startswith('@') else rule_part(inner_prelude)
                        if target in small:
                            target = None
                        if target is None:
                            inner_kept.append(rule)
                        else:
                            inner_moved.setdefault(target, []).append(rule)
                    if inner_kept:
                        kept.append(prelude + '{' + ''.join(inner_kept) + '}')
                    for target, rules in inner_moved.items():
                        moved_final.setdefault(target, []).append(prelude + '{' + ''.join(rules) + '}')
                else:
                    kept.append(prelude + '{' + body + '}')
                continue
            target = rule_part(prelude)
            if target in small:
                target = None
            if target is None:
                kept.append(prelude + '{' + body + '}')
            else:
                moved_final.setdefault(target, []).append(prelude + '{' + body + '}')
        moved = moved_final

    report = '--report' in sys.argv
    total = len(css)
    moved_bytes = sum(sum(len(r) for r in rules) for rules in moved.values())
    print(f'main.css {total:,} bytes; {moved_bytes:,} move to {len(moved)} part sheets; {total - moved_bytes:,} stay')
    for part, rules in sorted(moved.items(), key=lambda item: -sum(len(r) for r in item[1])):
        print(f'  {sum(len(r) for r in rules):>9,}  {part}')
    if report:
        return

    os.makedirs(OUT_DIR, exist_ok=True)
    for name in os.listdir(OUT_DIR):
        if name.endswith('.css'):
            os.remove(os.path.join(OUT_DIR, name))
    manifest = {}
    for part, rules in moved.items():
        slug = part[len('template-parts/'):-len('.php')]
        filename = slug.replace('/', '--') + '.css'
        with open(os.path.join(OUT_DIR, filename), 'w', encoding='utf-8', newline='\n') as handle:
            handle.write(''.join(rules))
        manifest['template-parts/' + slug] = filename
    with open(MANIFEST, 'w', encoding='utf-8', newline='\n') as handle:
        json.dump(manifest, handle, indent=1, sort_keys=True)
        handle.write('\n')
    with open(CSS, 'w', encoding='utf-8', newline='\n') as handle:
        handle.write(''.join(kept))


if __name__ == '__main__':
    main()
