# Fenster Theme

Hardcoded WordPress theme for the live Fenster Glazing site.

Read these first from the repo/public root before making changes:

- `app/public/AI.md` for coding rules and QA gates.
- `app/public/HANDOVER.md` for current architecture and route context.
- `app/public/LIVECHANGES.md` for GitHub/SiteGround deploy workflow.
- `app/public/STYLE.md` for visual/design rules.
- `app/public/AUDIT.md` for launch backlog and SEO/performance status.

Latest known live commit when this README was updated: `aff62a0`.

## Rules

- No ACF or page-builder controlled core content.
- Prefer explicit PHP template parts over clever abstractions.
- Keep hardcoded shared data in `inc/site-data.php`.
- Create one readable template part per reusable section.
- Do not make runtime code depend on `wp-content/fenster-reference`; it is a local-only archive and is not deployed.
- Keep `functions.php` as a bootstrap file only.
- Use the shared enquiry form component rather than standalone forms.
- Build after SCSS/JS edits and lint changed PHP.

## Tooling

Run from this theme directory:

```powershell
npm install
npm.cmd run build
```

Local path:

`C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster`

Server deploy target on both test/live Bedrock installs:

`web/app/themes/fenster`

Do not deploy WordPress core, uploads, plugins, `.env`, `wp-config.php`, `node_modules`, backups or the local scrape archive.
