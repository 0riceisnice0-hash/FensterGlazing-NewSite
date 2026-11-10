"""Write data/sitemap-lastmod.json: the day each published route last changed.

SEO plan 10/11/2026, 4.2. Only 16 of 217 URLs in page-sitemap.xml carried a
<lastmod>, so Google had no signal for which pages had been worked on.

A date is only written where git can show the page itself changed:

- the last commit touching a line that defines the route's own data, i.e. a
  line containing `'<slug>' =>` under inc/ or template-parts/ (its title and
  description override, its product hub entry, its FAQ block and so on);
- the last commit to a template named after the route
  (template-parts/sections/<slug>.php or <slug>-v2.php).

The later of the two wins. A route with neither gets no date rather than a
guessed one: a sitemap that dates every page "today" teaches Google to ignore
the field. Families rendered by one template (commercial counties, price
guides) take that template's date under "_templates".

Run it after committing, from the theme folder:

    python scripts/build-sitemap-lastmod.py

and commit the JSON it writes. It reads git only; it changes nothing else.
"""

import json
import os
import re
import subprocess
import sys

THEME = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
PATHS = ['inc', 'template-parts']


def git(*args):
    out = subprocess.run(['git', *args], cwd=THEME, capture_output=True, text=True, encoding='utf-8')
    return out.stdout.strip()


def last_line_change(slug):
    return git('log', '-1', '--format=%cs', '-G', "'" + re.escape(slug) + "' =>", '--', *PATHS)


def last_file_change(path):
    if not os.path.isfile(os.path.join(THEME, path)):
        return ''
    return git('log', '-1', '--format=%cs', '--', path)


def main():
    with open(os.path.join(THEME, 'data', 'pages.json'), encoding='utf-8') as handle:
        payload = json.load(handle)
    pages = payload if isinstance(payload, list) else payload.get('pages', [])
    slugs = sorted({str(page.get('slug', '')).strip('/') for page in pages if page.get('slug')})

    with open(os.path.join(THEME, 'inc', 'generated-pages.php'), encoding='utf-8') as handle:
        source = handle.read()
    match = re.search(r'function fenster_price_guide_pages\(\).*?\n}\n', source, re.S)
    if match:
        slugs += re.findall(r"^        '([a-z0-9-]+)' => \[$", match.group(0), re.M)

    # Routes the sitemap adds outside pages.json: the fixed list in
    # fenster_generated_sitemap_entries(), case studies and blog posts.
    virtual = re.search(r"foreach \(array_merge\(\[(.*?)\], \$case_study_slugs", source, re.S)
    if virtual:
        slugs += re.findall(r"'([a-z0-9-]+)'", virtual.group(1))
    for data_file in ('case-studies-data.php', 'blog-posts.php'):
        with open(os.path.join(THEME, 'inc', data_file), encoding='utf-8') as handle:
            slugs += re.findall(r"^        '([a-z0-9-]+)' => \[$", handle.read(), re.M)

    dates = {}
    for index, slug in enumerate(sorted(set(slugs))):
        candidates = [
            last_line_change(slug),
            last_file_change(f'template-parts/sections/{slug}.php'),
            last_file_change(f'template-parts/sections/{slug}-v2.php'),
        ]
        candidates = [day for day in candidates if day]
        if candidates:
            dates[slug] = max(candidates)
        if index % 25 == 0:
            print(f'{index} routes read', file=sys.stderr)

    dates['_templates'] = {
        'commercial-county': last_file_change('template-parts/sections/commercial-county.php'),
        'price-guide': last_file_change('template-parts/sections/price-guide.php'),
    }

    target = os.path.join(THEME, 'data', 'sitemap-lastmod.json')
    with open(target, 'w', encoding='utf-8', newline='\n') as handle:
        json.dump(dates, handle, indent=1, sort_keys=True)
        handle.write('\n')
    print(f'{len(dates) - 1} routes dated, written to {target}')


if __name__ == '__main__':
    main()
