# Fenster Theme

Hardcoded WordPress theme for rebuilding Fenster Glazing from the full public-site scrape.

## Rules

- No ACF or page-builder controlled content.
- Prefer explicit PHP template parts over clever abstractions.
- Keep hardcoded shared data in `inc/site-data.php`.
- Create one readable template part per reusable section.
- Use the scrape in `wp-content/fenster-reference` as source material, then rewrite content and UI in code.
- Keep `functions.php` as a bootstrap file only.

## Tooling

Run from this theme directory:

```powershell
npm install
npm run build
```
