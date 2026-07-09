# Fenster Glazing Live Changes Runbook

Last updated: 2026-07-09

This is the short operational guide for any Codex agent or developer making changes after launch. Read this before touching test or live.

## Current Truth

- Active GitHub repo: `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`
- Latest known deployed live commit after this update: `97d7525` (`Fix product image gallery pools`). Check `git log --oneline -8` and confirm against the live theme before assuming this line is still current.
- Local site root: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public`
- Local theme root: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster`
- Server repo cache: `~/repos/FensterGlazing-NewSite`
- Test WordPress root: `~/www/test.fensterglazing.com/public_html`
- Live WordPress root: `~/www/fensterglazing.com/public_html`
- Test/live are Bedrock installs, so the server theme path is `web/app/themes/fenster`.
- Local development is a normal WordPress install, so the local theme path is `wp-content/themes/fenster`.

SSH:

- Host: `ssh.fensterglazing.com`
- Port: `18765`
- User: `u453-m73mh4m4wev2`
- Local key path currently used by Codex: `C:\Users\zacpl\.ssh\fenster_siteground_codex`

Do not put the private key, passphrase or passwords into this repo.

## Golden Rule

Deploy the theme only.

Do not replace the whole WordPress install. Do not upload WordPress core. Do not overwrite `.env`, Bedrock config, plugins, uploads or the database unless the owner explicitly asks for that exact operation.

## Normal Change Flow

1. Make the change locally.
2. Build assets if SCSS or JS changed.
3. PHP-lint changed PHP files.
4. Check `git diff` and keep the change scoped.
5. Commit and push to GitHub `main`.
6. For small, scoped changes, deploy the committed theme directly to live when the local checks have passed and the owner has not asked for a test stop.
7. For bigger changes, especially new layouts, shared templates, routing, SEO output, forms or broad visual work, deploy to test first and verify visually and technically.
8. Confirm there is a fresh live backup before deploying larger verified changes from test to live.
9. Deploy the same committed theme to live.
10. Flush cache and verify the changed pages.

If a change touches forms, SEO output, redirects, sitemaps, generated routing, enquiry email, or global header/footer behaviour, treat it as higher risk and verify more pages.

Direct-to-live is acceptable for small, low-risk edits after local build/lint and GitHub push. Do not edit live files by hand: local edit, build/lint, commit, push, deploy the theme-only live rsync, flush cache, then verify. Bigger layout/template/routing changes should still go through test first unless the owner explicitly overrides that for the current task.

## Commands Codex Has Been Using

From the local theme directory:

```powershell
npm.cmd run build
```

PHP lint example:

```powershell
& 'C:/Users/zacpl/AppData/Roaming/Local/lightning-services/php-8.2.29+0/bin/win64/php.exe' -l 'app/public/wp-content/themes/fenster/template-parts/sections/generated-page.php'
```

Deploy to test:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/test.fensterglazing.com/public_html && wp cache flush"
```

Deploy to live:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/fensterglazing.com/public_html && wp cache flush"
```

The `rsync --delete` is safe only because the source and target are both the theme folder. Never point it at `public_html`, `web`, `web/app`, uploads, plugins or a path assembled from guesswork.

## PowerShell And SSH Verification Notes

Codex usually runs from Windows PowerShell. Keep remote verification commands simple because quoting loops through PowerShell, SSH and the remote shell can waste time.

- Do not use bare `curl` in local PowerShell for verification. PowerShell aliases `curl` to `Invoke-WebRequest`, so curl flags such as `-w` and shell loops can fail before the command reaches the server.
- For local public URL checks, use `Invoke-WebRequest` directly.
- For one or two server-side checks, use a plain one-line SSH command.
- For multi-route server-side checks, send a small bash script to the server with base64 and pipe it into `bash`. Use this pattern instead of trying to nest multiline loops inside an SSH string:

```powershell
$remote = @'
for route in /what-are-integral-blinds/ /louvre-vents/ /commercial-glazing-buckinghamshire/ /obscured-glass/ /commercial-projects/
do
  tmp=$(mktemp)
  status=$(/usr/bin/curl -sSL -A "Mozilla/5.0 Codex verification" -o "$tmp" -w "%{http_code}" "https://www.fensterglazing.com$route")
  bad=0
  grep -Eiq "live chat|verified product imagery|verified supplier imagery|page stays visually accurate|best route|right glazing route|installation route|colour route|specification route" "$tmp" && bad=1
  echo "$route status=$status bad_copy=$bad"
  rm -f "$tmp"
done
'@
$b64 = [Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes($remote))
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "echo $b64 | base64 -d | bash"
```

## What Not To Touch

- Do not use SiteGround clone/staging tools. They previously caused URL/database confusion.
- Do not run database search-replace on live.
- Do not edit live files directly except for a genuine emergency.
- Do not deploy `wp-content\fenster-reference`.
- Do not deploy Local by Flywheel config, database dumps, backups, `node_modules`, WordPress core, uploads, plugins or `wp-config.php`/Bedrock `.env`.
- Do not reset Rank Math/Yoast before launch. Generated pages use theme-owned SEO output and suppress plugin head output there.
- Do not re-enable customer confirmation emails until authenticated SMTP is configured.
- Do not restore the old mobile quote controls with separate expand/new-tab options.
- Do not reintroduce the removed loading screen.

## Before Deploy Checklist

- `git status --short` is understood. Unrelated user changes are not reverted.
- SCSS/JS changes have been built and compiled files are included.
- PHP changes have been linted.
- Forms still include the shared enquiry component unless the task is explicitly to alter forms.
- Generated route changes do not accidentally affect blog articles, noindex rules, 301s, 410s or the sitemap.
- Mobile layout changes are checked for horizontal overflow.
- Image/video changes use theme assets, not `fenster-reference`.

## After Deploy Checklist

Minimum checks:

- Changed page loads.
- Homepage loads.
- `/online-quote/` loads.
- A representative product page such as `/casement-windows/` loads.
- A representative generated location page loads.
- `/sitemap.xml` still loads if SEO/routing changed.
- Enquiry form is tested if form/email code changed.

Known host note: command-line HTTP requests from the local machine may receive a SiteGround 403/WAF page even when the browser works. If that happens, verify through WP-CLI/server-side checks and real browser/phone testing rather than assuming the site is down.

## Emergency Fix Rule

If a live-only emergency edit is unavoidable:

1. Keep it tiny.
2. Record exactly what changed.
3. Copy the fix back into the local repo immediately.
4. Commit and push it.
5. Redeploy from GitHub so live matches source control again.

Live must not become the source of truth.

## Current Launch Notes

- Live and test are both running the new `fenster` theme.
- Recent live change sequence to understand before continuing: `f5191f8` product-page journey redesign, `99d3cd5` product-template refinements, `fd0d9ea` mobile nav touch-layer fix, `8cf8f3f` product gallery lightbox and `3ac98c2` lightbox control polish.
- Enquiries save as private `fenster_enquiry` posts and send office HTML email to `info@fensterglazing.com`.
- Customer confirmation emails are paused until authenticated SMTP is configured.
- Optional enquiry file uploads are supported and attached to office emails.
- Residential case studies are intentionally 410/inaccessible for launch.
- `/obscured-glass/` is canonical; `/obscure-glass/` redirects there.
- Product mobile QA fixes and the newer product-page template/lightbox work through `3ac98c2` are deployed live.
- `/upvc-colours/` and `/aluminium-colours/` redirect to canonical `/colour-options/`.
- The theme serves `/sitemap.xml` and `/page-sitemap.xml` before Rank Math can output its own XML; live verification after the hardening pass showed 421 canonical sitemap URLs.
- `inc/security.php` owns public WordPress hardening: REST user enumeration is blocked, XML-RPC is disabled through the WordPress filter, `X-Pingback` is removed, and WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output is stripped.
- Performance hotfix `7c973b5` defers heavy media and quote embeds without removing premium visuals. Do not make the homepage hero video or WindowCAD iframes eager again unless there is a measured reason.
- Microsoft Clarity had unstyled/giant-image recordings because Clarity-like replay/resource fetches could receive the SiteGround/nginx `403 - Forbidden` HTML page instead of the real stylesheet. The live fix is theme-owned: Clarity plugins are removed, `inc\assets.php` adds `data-clarity-unmask="true"` to CSS/font/image resource links, and `inc\consent.php` injects `style#fenster-clarity-replay-css[data-clarity-unmask="true"]` after accepted consent and before loading `clarity.ms/tag/xi7rk1pic8`. Do not remove this inline replay CSS or reinstall the Clarity plugins without retesting recordings.
- Public tracking is gated by the theme consent layer in `inc\consent.php`. Do not re-add raw GTM, Clarity or Meta Pixel snippets in Insert Headers/Footers or plugin settings unless they remain blocked until consent.
- `test.fensterglazing.com` is intentionally Basic Auth protected to avoid a public duplicate. Username: `fenster`; password: `Fenster`. The test `.htaccess` also serves public `robots.txt` with `Allow: /` and uses a custom 401 handler so blocked test URLs return `X-Robots-Tag: noindex, nofollow, noarchive`; keep that combination so Google can drop already-discovered test URLs.
