# Fenster Glazing Live Changes Runbook

Last updated: 2026-07-16

This is the short operational guide for any Codex agent or developer making changes after launch. Read this before touching test or live.

## Current Truth

- Active GitHub repo: `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`
- **Live is at `6ea0dba` on `main`, deployed 2026-07-29. Test is ahead at `0ea0b54` (handle options box, mobile hero, intro read more) and awaiting approval.** Backup before it: `~/backups/fenster-theme/fenster-pre-6ea0dba-20260729-175517.tar.gz` (375M, 1,736 entries, confirmed to exist before deploying). Live was re-established by checksum first and the recorded pointer was accurate this time: five theme files matched `54451c2..4822e92`, all theme-identical, so `54451c2` was used as the range base to yield a superset. The range `54451c2..6ea0dba` was **20 commits, all one author**, no concurrent-session work in the batch: the colour rail rebuild and its four follow-up fixes, the colour hub hero built from the range, the owner's colour ordering, and the composite white. Verified on production: five theme files byte-identical, seven routes 200, the hero wall serving 336 tiles with both CTAs, the old boxed hero photo gone, zero counter markup, five pale tiles carrying the hairline, all three ranges in the owner's order, and the uPVC grid reordered on product pages too.
- **The pointer was stale again at deploy time.** This file said `8052f65`; the live theme actually checksummed to `d3600ad`, the docs commit straight after it, so the theme content was the same but the recorded SHA was not the deployed one. That is three releases running where the line was wrong. **Re-establish by checksum every time; it takes under a minute.**
- The previous release was `834b424` (2026-07-29). Before that, `4458fc6` (2026-07-24) and `94e7d0f`.
- **Re-establish live by checksum before every deploy rather than trusting this line.** It was stale by four commits on 2026-07-24. Checksum a few theme files against history: `inc/site-data.php`, `assets/css/main.css`, `assets/js/main.js` and, when those tie, whatever the candidate commits actually touched. Correct this line as part of the deploy.
- The earlier `release/heritage-doors` divergence is closed: everything on it reached production through the 2026-07-22 releases, and live has been deployed from `main` since.
- The previous approved promotion was `13e7f95` (`Heritage doors case study: real interior photos + Sheerline award`) on 2026-07-17. This is the curated residential case studies system (`/case-studies/`), now with six projects including two video-led roof lantern studies (Drayton Parslow big lantern, Northampton lantern + heritage doors with a Sheerline Installation of the Month award). Studies auto-sort by date.
- Deploy cache note: `wp cache flush` alone does NOT clear SiteGround's dynamic/proxy cache, so changes can appear missing on test/live. Run `wp sg purge` after every deploy (and it is included in the deploy one-liners below). When verifying, also cache-bust the URL. Verified live on 13e7f95: archive plus all six detail pages `200`, videos and the interior photo `200`, both new studies present in `page-sitemap.xml`.
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
6. Deploy the committed theme to the password-protected test site for every completed change, regardless of size or risk.
7. Flush the test cache and verify the changed route visually and technically.
8. If the change is approved for live, confirm the appropriate backup or checkpoint is in place.
9. Deploy the same verified commit to live.
10. Flush the live cache and verify the changed pages.

If a change touches forms, SEO output, redirects, sitemaps, generated routing, enquiry email, or global header/footer behaviour, treat it as higher risk and verify more pages.

Direct-to-live is not the normal workflow, including for small or low-risk edits. Always use local edit, build/lint, commit, push, theme-only test rsync, test cache flush and test verification first. Do not edit live files by hand. Skip test only when the owner explicitly overrides this rule for the current task.

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
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/test.fensterglazing.com/public_html && wp cache flush && wp sg purge"
```

Deploy to live:

**Deploy an explicit commit, never `origin/main`.** Replace `<SHA>` with the exact commit you verified on test:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard <SHA> && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/fensterglazing.com/public_html && wp cache flush && wp sg purge"
```

> **Why this changed.** The old form of this command used `git reset --hard origin/main`, which deploys whatever happens to be on `main` rather than the commit you approved. On 2026-07-18 a deploy of four small Legend fixes also pushed fourteen unapproved composite-door commits to production, because they were sitting in front of the Legend work on `main`. Resetting to an explicit SHA is what makes "deploy the same verified commit to live" in the Normal Change Flow actually true.
>
> Before deploying, confirm what you are about to ship:
>
> ```powershell
> git log --oneline <LIVE_SHA>..<SHA>
> ```
>
> If that list contains anything you did not verify and approve, stop and cherry-pick instead.

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

- `git log --oneline <LIVE_SHA>..<SHA>` has been run and every commit in the range is intended for this release. This is the check that would have caught the 2026-07-18 composite-door incident.
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
- After any routing, redirect or sitemap change, confirm these deliberate canonical routes all return `200`: `/`, `/double-glazing-milton-keynes/`, `/windows-milton-keynes/`, `/doors-milton-keynes/` and `/areas-we-cover/`. For `/double-glazing-milton-keynes/`, also assert that the response contains `Choose the product family first`; status alone does not prove that its dedicated head-term template rendered.
- `/sitemap.xml` still loads if SEO/routing changed.
- Enquiry form is tested if form/email code changed.

SEO/routing note from 2026-07-09:

- `/areas-we-cover/` is an indexable generated route and must remain in `page-sitemap.xml`, footer links and relevant related-link bands.
- `/window-door-prices-milton-keynes/` is the live pricing hub currently linked from footer/home/generated related links.
- Do not recreate or internally link `/double-glazing-prices-milton-keynes/`; it was an accidental live route, removed in `51c3550`, and should remain unavailable unless the owner explicitly approves that exact page.
- Roof-light keyword coverage is handled through title/meta overrides for `/roof-lanterns/`, `/roof-lanterns-milton-keynes/` and `/roof-lanterns-northampton/`.

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
- Residential case studies are LIVE as of 2026-07-17: `/case-studies/` is a curated, data-driven system in `inc/case-studies-data.php` (see `CASESTUDIES.md`). Only the retired scrape-era residential studies (`double-glazing-rushden`, `water-stratford`, `bespoke-windows-woburn-water-end-barn`, `test`, `template-new`) remain 410. `/commercial-projects/` still uses the legacy pages.json system.
- Composite Doors V2 (`/composite-doors/`) and the seven price-guide routes are LIVE as of 2026-07-20. Both reached production without an explicit promotion decision; the owner reviewed them on 2026-07-20 and chose to keep them up and iterate directly on live. Price-guide figures are public and indexable, so treat their accuracy as a live-content responsibility.
- `/obscured-glass/` is canonical; `/obscure-glass/` redirects there.
- Product mobile QA fixes and the newer product-page template/lightbox work through `3ac98c2` are deployed live.
- `/upvc-colours/` and `/aluminium-colours/` redirect to canonical `/colour-options/`.
- The theme serves `/sitemap.xml` and `/page-sitemap.xml` before Rank Math can output its own XML; live verification after the hardening pass showed 421 canonical sitemap URLs.
- `inc/security.php` owns public WordPress hardening: REST user enumeration is blocked, XML-RPC is disabled through the WordPress filter, `X-Pingback` is removed, and WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output is stripped.
- Performance hotfix `7c973b5` defers heavy media and quote embeds without removing premium visuals. Do not make the homepage hero video or WindowCAD iframes eager again unless there is a measured reason.
- Microsoft Clarity had unstyled/giant-image recordings because Clarity-like replay/resource fetches could receive the SiteGround/nginx `403 - Forbidden` HTML page instead of the real stylesheet. The live fix is theme-owned: Clarity plugins are removed, `inc\assets.php` adds `data-clarity-unmask="true"` to CSS/font/image resource links, and `inc\consent.php` injects `style#fenster-clarity-replay-css[data-clarity-unmask="true"]` after accepted consent and before loading `clarity.ms/tag/xi7rk1pic8`. Do not remove this inline replay CSS or reinstall the Clarity plugins without retesting recordings.
- Public tracking is gated by the theme consent layer in `inc\consent.php`. Do not re-add raw GTM, Clarity or Meta Pixel snippets in Insert Headers/Footers or plugin settings unless they remain blocked until consent.
- The Marketing Dashboard Website Tracker is also consent-gated. Its production code and API are hosted separately at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`; deploy dashboard changes from that repository, not from this theme deployment. Read `WEBSITE-TRACKER.md` in that repository before changing the tracker or interpreting an outcome. Consent acceptance permits opaque `FGV-…` visitor and `FG2-…` journey tracking; rejection permits only aggregate daily accept/reject counters. Banner impressions are deliberately not collected because pre-consent crawler/session traffic made them unreliable. Do not change `src\js\main.js`, `inc\consent.php`, `inc\website-tracking.php` or `inc\adminbase.php` in a way that sends rejected/no-choice browsing, form or WindowCAD events to the dashboard.
- WindowCAD URL attribution belongs in its separate **Tracking** field, never the office-owned **Reference** field. The accepted value is `FG2-…`; rejected/no-choice values are `rejected-cookies` / `cookie-consent-not-accepted` and must remain excluded from dashboard quote-completion relays.
- `test.fensterglazing.com` is intentionally Basic Auth protected to avoid a public duplicate. Username: `fenster`; password: `Fenster`. The test `.htaccess` also serves public `robots.txt` with `Allow: /` and uses a custom 401 handler so blocked test URLs return `X-Robots-Tag: noindex, nofollow, noarchive`; keep that combination so Google can drop already-discovered test URLs.
