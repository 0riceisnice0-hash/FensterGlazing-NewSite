# Fenster Glazing Work At Home Handover

Last updated: 2026-07-20

Use this document only when Zac is working from the home PC instead of the normal work machine.

This is not the main project handover and must not replace the normal docs. It exists because the home setup can have different SSH keys, different local paths and no full local WordPress install available.

## Read These First

Before doing any work from home, read the usual tracked project documents in this order:

1. `AI.md`
2. `HANDOVER.md`
3. `LIVECHAT.md`
4. `LIVECHANGES.md`
5. `STYLE.md`
6. `AUDIT.md`
7. `PROGRESS.md`

Use this file after those docs to adjust the workflow for the home-PC environment.

## Home-PC Assumptions

- Do not assume the Local by Flywheel site exists or is usable on the home PC.
- Do not assume there is direct local access to the same files, databases, uploads or WordPress admin state as the work PC.
- Treat GitHub as the source of truth for code and docs.
- Make changes in the cloned Git repo, commit them, push them and deploy from the committed Git state.
- Do not edit live files by hand unless `LIVECHANGES.md` emergency rules are explicitly invoked.
- Do not copy private keys, passwords, API keys, Bedrock `.env` values or WordPress secrets into the repo or documentation.

## SSH Key Difference

The normal docs may mention the work-machine key:

`C:\Users\zacpl\.ssh\fenster_siteground_codex`

On the home PC, Codex has used a separate SiteGround key:

`C:\Users\zacpl\.ssh\fenster_siteground_home_codex`

Use whichever key actually exists on the current machine and has SiteGround access. If one fails, check the key path before assuming the server or GitHub is broken.

SiteGround SSH details remain:

- Host: `ssh.fensterglazing.com`
- Port: `18765`
- User: `u453-m73mh4m4wev2`

Example home-PC SSH prefix:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_home_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com
```

## Home-PC Workflow

1. Pull or fetch the GitHub repo before assuming local files are current.
2. Check `git status --short` and do not overwrite unrelated local changes.
3. Make source edits in the repo.
4. Run `npm.cmd run build` from `app/public/wp-content/themes/fenster` after SCSS or JS changes.
5. PHP-lint changed PHP files where relevant.
6. Commit and push to GitHub.
7. Deploy the committed theme from the server repo cache using the key available on the home PC.
8. Make a server-side theme backup before live deploys.
9. Flush WordPress cache and SiteGround cache.
10. Verify the changed route on live/test with cache-busted URLs.

The live/test deploy model is still theme-only rsync from GitHub. Never rsync the whole WordPress install.

## Extra Home-PC Cautions

- PowerShell may block `npm.ps1`; use `npm.cmd run build`.
- PowerShell may alias `curl`; use `Invoke-WebRequest`, browser tooling or server-side `/usr/bin/curl` through SSH.
- If local browser checks are not possible, verify through the live/test URL, WP-CLI, server-side checks and Playwright/browser tooling.
- If the home PC has no usable local WordPress runtime, do not invent local-only paths or rely on untracked local files.
- The server repo cache at `~/repos/FensterGlazing-NewSite` should be reset to the exact commit being deployed.

## Source Of Truth

For project rules, use `AI.md`.

For current site state, use `HANDOVER.md`.

For deploy commands, backups and live-safety rules, use `LIVECHANGES.md`.

For Legend AI assistant behaviour, use `LIVECHAT.md`.

For visual/design rules, use `STYLE.md`.

This document only explains the home-PC operating constraints.
