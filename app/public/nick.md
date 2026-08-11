# Nick's Laptop (macOS)

Last updated: 2026-08-11

## Read this first

**If you were told to read this document, you are working on Nick's laptop, the owner's machine. It is a Mac. Tailor everything you do to macOS.**

If nobody pointed you here, this file does not apply to you. The other machine on this project is Zac's Windows PC, and every Windows path and PowerShell command in the other docs belongs to that machine. Do not follow this file there.

Nothing here changes a single project rule. `LIVECHANGES.md` is still law, `AI.md` is still the rulebook, `STYLE.md` and `TONEOFVOICE.md` still decide how pages look and sound. This file only tells you where things live on this machine and how to translate the commands.

## Translating the other docs

Every doc in this folder was written on Windows. When you read a path or a command in `AI.md`, `HANDOVER.md` or `LIVECHANGES.md`, translate it:

| In the other docs (Windows) | On this machine (Mac) |
| --- | --- |
| `C:\Users\zacpl\Local Sites\fenster-glazing\app\public` | `~/Desktop/Claude - website/FensterGlazing-NewSite/app/public` |
| `C:/Users/zacpl/.ssh/fenster_siteground_codex` | `~/.ssh/fenster_siteground_boss` |
| `npm.cmd run build` | `npm run build` |
| `& 'C:\...\php.exe' -l 'file.php'` | `php -l file.php` |
| Backslashes in any path | Forward slashes |
| PowerShell `Invoke-WebRequest` | `curl` behaves normally here |

Note the repo folder name has spaces in it. Quote the path or the command will break.

## Where things are

- Repo: `~/Desktop/Claude - website/FensterGlazing-NewSite`
- Theme: `app/public/wp-content/themes/fenster` (build and lint from here)
- Docs: `app/public/` (the root `AI.md` and `HANDOVER.md` are legacy pointers)

There is no Local by Flywheel install and no local WordPress on this machine. There is no local site to look at. Every visual check happens on the password-protected test site after a deploy, which is what the workflow required anyway.

## SSH

This laptop has its own key. The previous machine's key stayed on the previous machine.

- Key: `~/.ssh/fenster_siteground_boss`
- Host `ssh.fensterglazing.com`, port `18765`, user `u453-m73mh4m4wev2`
- Imported into SiteGround Site Tools on 2026-07-28 and verified working

The private key never goes into this repo, into a commit, into a document or into a chat message. If a key ever needs replacing, generate a new pair and import the public half; never move the private one between machines.

## Installed tooling

- Homebrew at `/opt/homebrew`, on the PATH through `~/.zprofile`
- **PHP 8.2.32**, keg-only at `/opt/homebrew/opt/php@8.2/bin`, already on the PATH. This deliberately matches the version SiteGround runs, so a clean lint here means the same thing it means on the server.
- Node 26 and npm, with the theme's dependencies installed
- `gh`, authenticated as `0riceisnice0-hash` with git wired in through `gh auth setup-git`
- ImageMagick (`magick`, `convert`) and `cwebp`/`dwebp` for the image work this project does constantly
- GNU coreutils, so `gmd5sum` is available when you want output that matches the server's `md5sum`
- Google Chrome at `/Applications/Google Chrome.app`, which is the reliable way to see a page on this project (see below)

All verified present on 2026-07-29, but only once `/opt/homebrew/bin` is on the PATH. See the first trap.

## The commands you actually need

Build, from the theme directory:

```bash
npm run build
```

Lint changed PHP:

```bash
php -l app/public/wp-content/themes/fenster/inc/site-data.php
```

Lint every theme PHP file at once, which takes a couple of seconds:

```bash
find app/public/wp-content/themes/fenster -name '*.php' ! -path '*/node_modules/*' -exec php -l {} \; | grep -v 'No syntax errors'
```

Deploy to test, which is the same command as the docs with this machine's key path:

```bash
ssh -i ~/.ssh/fenster_siteground_boss -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/test.fensterglazing.com/public_html && wp cache flush && wp sg purge"
```

**`wp sg purge` is not optional on test.** `wp cache flush` alone leaves SiteGround's optimiser serving the previous stylesheet over HTTP while the file on disk is already correct. On 2026-07-29 that made a deployed footer change look like it had never shipped, and cost a round of wrong diagnosis. Purge both, on both environments.

Deploy to live, only after the range check and explicit owner approval, replacing `<SHA>` with the exact commit verified on test. Never `origin/main`:

```bash
ssh -i ~/.ssh/fenster_siteground_boss -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin --prune && git reset --hard <SHA> && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/fensterglazing.com/public_html && wp cache flush"
```

**`git fetch origin --prune`, not `git fetch origin main`.** A release SHA usually sits on a release branch, and fetching only `main` leaves it unknown to the server, so the `reset --hard` fails.

**`wp sg purge` does not exist on live and errors there**, which is correct: sg-cachepress is deliberately inactive on live because `siteground_optimizer_lazyload_images` is `1`. Purge live with the Unix socket instead, which touches no plugin state and returns `"msg":"OK"`:

```bash
ssh -i ~/.ssh/fenster_siteground_boss -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/www/fensterglazing.com/public_html && php -r '
\$fp = stream_socket_client(\"unix:///chroot/tmp/site-tools.sock\", \$e, \$s, 5);
fwrite(\$fp, json_encode(array(
  \"api\"=>\"domain-all\",\"cmd\"=>\"update\",
  \"params\"=>array(\"flush_cache\"=>\"1\",\"id\"=>\"fensterglazing.com\",\"path\"=>\"/(.*)\"),
  \"settings\"=>array(\"json\"=>1),
), JSON_FORCE_OBJECT).\"\n\");
echo fgets(\$fp, 32*1024);
'"
```

**A clean push and a clean rsync are not evidence that anything shipped.** On 2026-08-04 a commit made while checked out on a release branch was pushed with `git push origin main`, which pushed the unmoved local `main` ref, reported success, and the server then deployed the previous commit. Nothing failed loudly. **After every deploy, grep the deployed file for a string from the change**, and remember the compiled JS is minified so grep a numeric literal rather than a variable name:

```bash
ssh -i ~/.ssh/fenster_siteground_boss -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "grep -c '<a string from the change>' ~/www/fensterglazing.com/public_html/web/app/themes/fenster/<file>"
```

**Establish live by checksum in the seconds before the rsync, not at the start of the work.** Another session shipped to live mid-session on 2026-08-04 and the release cut from the older live silently removed it. A SHA verified twenty minutes earlier says nothing about the one being overwritten.

For multi-step checks on the server, the base64 trick in `LIVECHANGES.md` exists to survive PowerShell quoting and is not needed here. A quoted heredoc is clearer and safer:

```bash
ssh -i ~/.ssh/fenster_siteground_boss -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com 'bash -s' <<'REMOTE'
for route in / /casement-windows/ /windows-milton-keynes/; do
  echo "$route $(curl -sL -o /dev/null -w '%{http_code}' "https://fensterglazing.com$route")"
done
REMOTE
```

Use the apex host and keep `-L`. The live site 301s `www` to apex, so dropping either turns a healthy page into a confusing `301`. Verified returning `200` on all three routes on 2026-07-28.

## Traps specific to this machine

**`/opt/homebrew/bin` is not on the PATH in a non-interactive shell.** It is added by `~/.zprofile`, which a login shell reads and a command run through a tool does not. So `npm`, `magick`, `cwebp` and `gh` all appear to be missing when they are installed and working. On 2026-07-29 this led to a written conclusion that the machine had no image tooling, and a workaround built on that false premise. Export the PATH at the start of any command that needs them:

```bash
export PATH="/opt/homebrew/bin:/opt/homebrew/opt/php@8.2/bin:$PATH"
```

If a tool reports as missing, check with that export before believing it.

**zsh eats `$sha:path`.** The shell here is zsh, where `$sha:a` is a parameter modifier. Writing `git show "$sha:app/public/..."` silently produces a mangled argument, `git show` returns nothing, and a checksum loop then reports the md5 of an empty string (`d41d8cd98f00b204e9800998ecf8427e`) for every commit. It looks like a working table of results. Always brace it:

```bash
git show "${sha}:app/public/wp-content/themes/fenster/assets/css/main.css" | md5 -q
```

If any verification loop returns the same hash for every input, check for that empty-input hash before believing it. This matters because establishing the live commit by checksum is a safety check, and a quietly wrong answer is worse than an error.

**`md5` is not `md5sum`.** macOS gives you `md5 -q` for a bare hash. The server gives `md5sum`. Use `gmd5sum` here if you want identical output to compare directly.

**`.DS_Store` cannot be gitignored inside the theme.** Line 18 of `.gitignore` re-includes everything under the theme folder, so Finder's `.DS_Store` files show up as untracked there and a global ignore will not catch them. Check `git status` before staging and never run `git add -A` blind.

**A rebuild alone changes the compiled JavaScript.** The esbuild version here is newer than the one the previous machine used, so `npm run build` with no source change still produces a byte-different `assets/js/main.js`. If you built only to check the toolchain, `git checkout` the compiled assets so the tree matches `main`. If you built because you genuinely changed source, commit it as normal.

**The in-app browser is not reliable on this site, and headless Chrome is.** Two things defeat it: the site uses Lenis smooth scrolling, so `scrollTo` and `scrollIntoView` move the DOM position without moving what is painted, and the test site's Basic Auth session drops on its own, returning a `401` page that reads as a working page unless you check. Both produce confident, wrong answers.

The dependable route is to pull the real markup and the real deployed stylesheet, point the asset URLs at the local theme so nothing needs authentication, and render it:

```bash
curl -s -u fenster:Fenster -L "https://test.fensterglazing.com/casement-windows/" -o page.html
curl -s -u fenster:Fenster -L "https://test.fensterglazing.com/app/themes/fenster/assets/css/main.css" -o page.css
# extract the section you care about, rewrite
# https://test.fensterglazing.com/app/themes/fenster -> file:///<theme path>
"/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless --disable-gpu \
  --allow-file-access-from-files --hide-scrollbars --window-size=1280,900 \
  --virtual-time-budget=5000 --screenshot=out.png "file://$PWD/fragment.html"
```

For measurements rather than a picture, link a small script that writes results into a `<pre>` and read them back with `--dump-dom`. That is how the footer swatch overflow was found: the tiles looked fine and were measurably 87px tall inside a 64px box. Note `document.styleSheets[..].cssRules` throws on a `file://` stylesheet, so read CSS from the file with `grep`, not from the DOM.

**A Python slice between two searched indices can silently become an empty string, and replacing an empty string prepends to the top of the file.** `main.js` is over 5,000 lines and has more than one `endDrag`. Taking `start = s.index(comment)` and `end = s.index(closing_line)` looks safe, but `index` with no offset returns the *first* match in the whole file, which here sat 4,000 lines above the start. The slice came back empty, `s.replace('', new, 1)` inserted the new block at line 1 outside any function, and `node --check` still passed because it was valid syntax. Always pass the start offset, `s.index(closing_line, start)`, and assert on the slice before using it. This happened on 2026-07-29 and was caught only by grepping for the block afterwards.

**A whole-page Chrome render hangs because of the network, not the page weight.** Once the theme URLs are rewritten to `file://`, the saved markup still points at fonts, analytics and uploads on real hosts, and headless waits on every one of them. Add `--host-resolver-rules="MAP * ~NOTFOUND"` and the whole page renders in a couple of seconds. That is better than extracting a fragment, because a fragment loses the ancestor cascade and the measurements stop being the real ones.

**Headless Chrome here will not go below a 500px viewport.** `--window-size=390,844` reports `innerWidth` of 500, so a run that claims to be a phone check is really a 500px one, and any conclusion about a sub-500 breakpoint from it is unverified. Load the page inside a 390px iframe and measure through `contentWindow`, and have the probe print `innerWidth` so the number is proved rather than assumed. To photograph a section rather than the top of the page, walk up from it and `display: none` the preceding siblings at each level: that keeps the ancestor chain intact so the cascade still applies.

**Nothing animated can be verified by watching it.** `--virtual-time-budget` runs about one `requestAnimationFrame` per run, and the in-app Browser pane is hidden, which throttles rAF to nothing there too. A scroll animation, a transition or an inertia loop will read as "did not move" in both. Verify the intent instead: wrap the method the code calls, for example `viewport.scrollTo`, and assert on the arguments it was given. That is how the colour rail's release was proved on 2026-07-29, and it is why the rail uses the browser's native smooth scroll rather than a hand-rolled rAF loop, which silently did nothing in a throttled tab.

**Full-page screenshots lie about lazy-loaded images.** Already recorded in `PROGRESS.md`, still true here: scroll the section into view and read `naturalWidth` rather than trusting a stitched capture.

## What has not changed

- Deploy the theme only. Never core, plugins, uploads, the database, Bedrock config or `.env`.
- Local edit, build if SCSS or JS changed, PHP lint, scoped commit, push, deploy to test, verify on test, and only then live with explicit approval.
- Re-establish the live commit by checksum before any deploy rather than trusting a doc, then run `git log --oneline <LIVE_SHA>..<SHA>` and confirm every commit in the range is approved.
- Two sessions have shared `main` on this project, so check `git status` before staging and never assume the range is only your work.
- The factual claims on the site are load-bearing. The 24/7 phone line is a real answering service and sash windows are A rated, not A+.

## Where the work is up to

`LIVECHANGES.md` carries the live pointer and `PROGRESS.md` the detail. No SHA is repeated here: this line held a stale one for a week while two other docs held two different stale ones. Re-establish live by checksum in the seconds before any deploy rather than trusting any of them.

Owner-confirmed product facts, worth not re-deriving:

- Casement windows are the 70mm Liniar EnergyPlus system, sculptured only. **Glazing is 28mm double or 36mm triple. 40mm is not offered on any uPVC**, which is why 0.95 W/m2K on the 36mm triple is the ceiling and the page must not quote Liniar's lower published figure.
- The uPVC foil range is sixteen colours. **The colour is the external face, with the same colour or smooth white inside.** Mixing freely is not offered and is deliberately not mentioned either way.
- **The casement multi-point lock is the Kenrick Excalibur**, confirmed 2026-08-04. Kenrick's published figures for it are on `/casement-windows/` and attributed to Kenrick. "PAS 24 capable" is their wording and stays that way: the approval belongs to a tested complete window, not to a component. Full terms in `AI.md`.
- Smooth white is RAL 9003 and is the unfoiled profile, so it has no swatch photograph.
- uPVC doors and patio doors share the window foil range. Sliding sash is Roseview and secondary glazing is aluminium, so neither carries it.
- **Heritage windows and heritage doors are Sheerline Classic, stepped sash only**, confirmed 2026-08-11. The stepped sash is what gives the steel look, and the product has largely taken over from Smart's heritage range as the Crittall replacement. **Triple glazing is not offered on either**: it needs the contemporary sash, and we avoid that deliberately so Classic does not blur into Prestige. So A rated, not A+, and 1.4 W/m2K double. Beaded frames, 60.5mm sightline. S2 handles, same as the rest of the range.
- **Louvres are specified by free area, and there are two kinds.** Visual free area is what you see through; physical free area is what air actually gets through, tested to EN 13030:2002, and it is the lower number and the one a schedule means. Blade centres run 30mm to 95mm across the range. IKL33 is what we fit most. **Composite panels are excluded from what we offer.**

Open, and needing the owner rather than a decision from you:

- The Ben Harrison Photography licence for the Headrow Court images is unconfirmed, and those images are live.
- ~~There is no honest uPVC door photograph anywhere in the theme.~~ **Closed 2026-07-29.** The owner pointed at OneDrive: `Marketing/Image Bank/Legacy Marketing/Doors/uPVC Doors`. Seven real installs are now in the theme under `assets/images/products/upvc-doors`. That folder is the first place to look for product photography, and the wider `Image Bank` covers projects, staff and manufacturer logos too. Three images in it may be composite rather than uPVC and were left out pending the owner's eye.
- **`/aluminium-doors/` has the wrong hero**, and the owner has chosen to leave it for now rather than fix it with what exists. `products/curated/sheerline-aluminium-door.jpg` is an interior kitchen shot of a white single door, which is why `PROGRESS.md` recorded on 2026-07-21 that it "reads as uPVC to a customer". The only correct replacements in the theme are 600x450, too small for a hero banner, so this needs a better asset rather than a swap.
- ~~Tilt and turn and bow and bay carry the colour grid but not the handle grid.~~ **Closed 2026-07-29.** Neither page is short. Tilt and turn takes a different handle family, not S2, so the S2 grid would be wrong there; the owner is sending the details. Bow and bay is a configuration rather than a product, so it carries no handle of its own. See the owner-confirmed facts in `AI.md`.
- The Barn Hotel and Sunrise Care Home completion months are still unconfirmed, so those two case studies print no date.
- Whether Fenster takes industrial and logistics work. The sector page was deliberately not built.
- **A residential heritage window study and a residential aluminium window study.** Both routes have their case-study strip switched off for want of one, because the alternative was showing secondary glazing and uPVC casements on an aluminium page.
- **Whether the louvre page should mention blanking panels.** Left out when composite panels were excluded from the range, and never actually ruled on.
- **Which louvre systems the four photographed jobs used**, so the photographs can be captioned honestly.
- **Legend's triple-glazing answer has not been tested in live chat.** It is allowed to offer triple on request, naming the contemporary sash, and forbidden from quoting a U-value for it.
