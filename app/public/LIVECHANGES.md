# Fenster Glazing Live Changes Runbook

Last updated: 2026-08-07

This is the short operational guide for any Codex agent or developer making changes after launch. Read this before touching test or live.

- **Live and test use the mandatory granular cookie-consent modal.** A first visit cannot continue until the visitor uses Customise or Accept all; Customise exposes necessary-only, analytics and marketing choices. Analytics and marketing are separate and off by default, choices last 180 days, and footer Cookie settings supports withdrawal. Analytics gates Clarity and `FGV`/`FG2`; marketing gates Meta, advertising tags and persisted ad click IDs. Google Tag Manager receives category-specific Consent Mode signals before it loads. Legacy accepted/rejected strings are intentionally re-prompted.

## Current Truth

- **Live is `7785f877` on `release/online-quote-restore` as of 2026-08-07 (09:39), established by checksum on `assets/css/main.css` and `generated-page.php` in the seconds before the rsync and re-verified on the deployed files after it.** **Live is deliberately NOT the tip of `main`.** The range `58e5295e..main` held seven commits and only one was this session's; the other six are the other session's unreleased Winslow case study, aluminium doors rebuild, French doors handle change and secondary glazing copy, which their own note says are being held back. So this was cut from live and cherry-picked, and **the compiled assets were rebuilt from the branch's own source**: the cherry-picked `main.css` carried their aluminium-door styling and rebuilding stripped it. Verified `.fg-alu-door-*` returns zero in the shipped bundle while `.fg-cw`, `.fg-rp` and `.fg-contact-list`, which predate the release, are still present.
- **The checksum guard was in the deploy script, not in a person's head.** The expected hashes were baked in and the script written to `exit 1` rather than warn. It passed this time; the point is that on 2026-08-05 it was the only thing that stopped an `rsync --delete` reverting the casement rebuild while reporting success.
- **The backup was proven, not trusted.** `~/backups/fenster-theme/fenster-pre-7785f877-20260807-093933.tar.gz` (396M, 1,879 entries), with `generated-page.php` extracted straight out of the tarball and hashed to `b10d7b18…`, matching the live checksum, so it really is the pre-deploy theme rather than a same-named file. Pruned to the newest three.
- **What this release restores.** `1201228e` ("Glass textures") committed a stale copy of four shared files and removed 685 lines net that had nothing to do with glass: the `/online-quote/` dispatch, the whole `.fg-oq` block and the 24 light-form selector joins, the tool cue controller, and the SEO title plus breadcrumb name. **New files survived and edits to shared files died**, which is the signature of that kind of loss and the thing to look for. Restored surgically rather than by reverting, which would have taken the genuine glass work with it.
- Socket purge returned `msg:OK`. Verified as a visitor with no cache-buster: fifteen canonical routes `200`, the head-term marker still rendering on `/double-glazing-milton-keynes/`, the served stylesheet md5 matching the file on disk (`1137156a…`, so the proxy is serving the new one and not a cached copy), all six walkthrough screenshots `200` at their exact byte sizes, and the removed spin assets correctly `404`. `/window-and-door-repairs/` and `/flush-casement-windows/` still render their own `fg-rp` and `fg-cw` markup, so none of the other session's live work was disturbed.
- **Live is `5cde867` on `release/repairs-diagnostics` as of 2026-08-07 (06:11), established by checksum on five theme files in the seconds before the rsync and re-verified on the same five after it.** **Live is deliberately NOT the tip of `main`**, for the same reason as the entry below: `main` still carries the unapproved online-quote strand. Cut from live `dac7007` with this session's **18 repairs commits** cherry-picked oldest-first; the 31 flush/glass commits in the range were skipped because their *content* is already live under different hashes. Content: `/window-and-door-repairs/` rebuilt from the ground up as a bespoke middle — a symptom-led diagnostic with two to-scale AutoCAD-style schematics (window and door) that highlight the failing part, a parts wall of real supplier photography, the van and the two Service Engineers, and a cross-link through to `/double-glazing-replacement/`. The generic product bands (`fg-product-why`, `fg-product-intel`, `fg-product-visuals`, the spec-choices strip, the order-process rail, the case-study strip and the key-specifications pulse) are gated off for this route, and instant pricing is disabled. Backup: `fenster-pre-5cde867-20260807-061137.tar.gz` (396M, 1,871 entries), **proven** by extracting `generated-page.php` out of the tarball and hashing it to `8300f1fe…`, the pre-deploy value. Pruned to the newest three. Socket purge `msg:OK`. Verified as a visitor with no cache-buster: page `200` with zero PHP notices, **all 41 referenced images `200`**, **all 62 internal links on the page `200`**, served CSS and JS byte-identical to the build, `fg-oq` zero in both, the diagnostic shell shipping `hidden` with the symptom text server-rendered for no-JS and SEO, and fifteen canonical routes `200`.
- **The compiled assets came back byte-identical to the cherry-picked artefacts on this release**, which is the *good* outcome, not a reason to skip the rebuild — it is the evidence that the artefact matches what the branch's own source produces. Run `npm run build` on the release branch every time and check the hash, because a clean rebuild costs 30ms and the alternative is shipping another session's styling.
- **Three "404s" in the first route sweep were invented slugs, not a regression.** `/replacement-glazed-units/`, `/upvc-windows/` and `/bifold-doors/` do not exist on this site; the real routes are `/double-glazing-replacement/` and `/aluminium-bifold-doors/`. Two other checks in the same sweep were also probe faults — `curl` fed URLs straight out of a JSON-LD block where slashes are escaped as `\/`, and a `grep` for `glaz` in an href matched every asset URL because the domain is *fensterglazing*.com. **Take route names from `page-sitemap.xml`, not from memory**, and remember the standing rule in this file: a verification failure is not evidence until the probe is checked.
- Superseded: live was `dac7007` on `release/flush-and-glass` as of 2026-08-06, established by checksum before every rsync and re-verified after it.** **Live is deliberately NOT the tip of `main`.** `main` carries an online-quote strand from another session that the owner has not signed off, so this release was cut from live `56015ba` and only this session's flush/glass commits cherry-picked onto it. Content: `/flush-casement-windows/` rebuilt as a bespoke middle, and `/obscured-glass/` (hero wall on the colour-hub fade, house-first scene, real touch dragging, texture corrections). Backup: `fenster-pre-flushglass-20260806-122356.tar.gz`, proven by extracting the casement template out of the tarball and hashing it. Verified as a visitor after each step: routes `200`, the FAQ rendering six questions, the corrected textures serving, and `/online-quote/` still `200` because that route predates the other session's template and falls back to the shared one without it.
- **The other strand is still on `main` and NOT on live. Do not deploy `main` without asking.** Cherry-picking around it was verified rather than assumed: `fg-oq` appears zero times in the released CSS and JS, their template and spin videos are absent, and every file of this strand is byte-identical to `main`'s copy, so the release is exactly "main minus their work". The compiled assets were rebuilt from this branch's own source, per the rule below — a cherry-picked artefact resolves to a side, not to what the branch compiles to. **Delete `release/flush-and-glass` once the online-quote strand ships**, or it becomes the loaded gun this file already describes twice.
- **A texture image replaced in place is a fix nobody can see.** Theme images go through `fenster_generated_url()`, which rewrites the path and adds **no version string** — unlike the stylesheet, which carries `?ver=` and updates fine. Cassini's pixels were corrected under the same filename, so every browser and proxy that had already seen it kept serving the old one while the deploy verified perfectly, because the file on disk was right. It cost three rounds of "it doesn't look like you did anything" and sent me hunting a bug that did not exist. **If the pixels change, change the filename.** The same trap took a review round on the case study crops earlier the same day, so this is the second occurrence and the note about the first was already in this file.
- **A texture on the glass stage is judged on brightness as well as contrast, because that layer is `multiply`.** Cassini was invisible at stddev 15 against a set running 20 to 73. Lifting the contrast fixed that and created the opposite fault: the mean dropped to 106 against a set running 121 to 178, and a dark texture under `multiply` does not add pattern, it turns the pane to mud. Judge a new texture on **both** numbers against the rest of the set, then look at it on the stage.
- **The stage and the swatches want opposite things from a texture, so `--texture-size` applies to the stage only.** Pinning a photographed texture's size stops it being enlarged to fill a 900px pane. Applying the same pin to a 58px swatch turns it into a 58/500 crop of one petal. The stage shows glass at true scale; a swatch shows the whole pattern so it can be told apart from its neighbour. Anything added with an `image` should get a `size` for the stage and leave the swatches on `cover`.
- **Look at the page, not the file.** Every fault in the last stretch — the FAQ that never rendered, the cached texture, the over-dark Cassini, the ruined swatch — passed a source check and a checksum and was obvious in one screenshot of the live page. Checksums prove what was deployed, not what a visitor sees.
- **A FAQ can be appended correctly and still never render.** The triple glazing answer was added to `$product_faqs` in the right place — after the array is built, before it renders, verified by line number — and did not appear on the page. `$product_faq_limit` caps the render at five per route and flush already had five of its own, so the sixth was sliced off. The source said it was there and the page disagreed, which is the worst shape for this class of bug. **Verify a FAQ by reading the questions the page actually rendered, not by grepping the template**, and remember that anything appending to a route which already fills its limit has to raise the limit too. Composite doors hit the identical wall; flush now sits beside it at six.
- Superseded: live was `56015ba` as of 2026-08-05 (21:36), established by checksum on `assets/css/main.css` and `generated-page.php` against `13afe6d` immediately before the rsync, and re-verified on four files after it.** Tip of `main`. Ten commits, one of them docs. `assets/js/main.js` untouched across the range (`git diff --quiet`, not assumed) and `main.css` rebuilt to a byte-identical artefact before shipping. Content: the Wolverton case study (flush casements, a composite front door and a uPVC back door, February 2024, with a 31.7s portrait video and eight 4:3 stills), the handle hub's hero replaced with a photograph on a colour-hub-style fade plus a banner through to `/colour-options/`, and one factual correction — an invented "that split costs nothing" claim about internal foil, removed from the case study and the true relationship added to Legend's verified facts. Backup: `fenster-pre-56015ba-20260805-213620.tar.gz` (385M, 1,851 entries), proven in the deploy script by extracting the template out of the tarball and hashing it against the pre-deploy value. Socket purge `msg:OK`. Verified as a visitor: case study `200` with all copy, fitters and the corrected sentence present and the false claim gone, the new study now claiming `/flush-casement-windows/`, `/upvc-doors/` and `/composite-doors/`, handle hub carrying the photo hero and the banner with the old swatch hero gone, twelve routes `200`, served stylesheet byte-identical, and the 5.9MB video and hero image both `200` at their exact byte sizes.
- **A case study attaches itself to product pages through its `products` URLs, so adding one silently changes other pages.** `fenster_case_studies_for_product()` matches on the path of each `products` entry and, when nothing matches, falls back to showing *any* three studies. `/upvc-doors/` had been running on that fallback — a bifold job and two casement jobs — because no study claimed it. The Wolverton entry lists flush casements, composite doors and uPVC doors, so three product pages changed content without being edited. **Check the product pages after adding a study**, and read a strip that looks unrelated as a sign that nothing matches rather than as a bug.
- **`magick` without an output path writes into the current directory, which was the theme.** A stray `zoom-door.jpg` sat untracked in the theme root for most of this session and would have shipped had it been committed; `git status` before the deploy caught it. The server rsyncs from its own clean checkout, so an untracked local file cannot reach production on its own — but do not rely on that, because a `git add -A` would have promoted it. Write scratch images to the scratchpad, and check `git status --porcelain` is empty before every release.
- Superseded: live was `13afe6d` as of 2026-08-05 (19:50), established by checksum on `assets/css/main.css` and the casement template against `2781545` immediately before the rsync, and re-verified on all three files after it.** It is the tip of `main`. Three commits, three theme files, `main.js` untouched across the range and `main.css` rebuilt to a byte-identical artefact before shipping. Content: the 04 and 05 chapter heads come off the casement page and those sections leave the stack, so the plates are the opening plus 01, 02, 03 and everything below security scrolls normally. Every sub heading is kept. Backup: `fenster-pre-13afe6d-20260805-195012.tar.gz` (385M, 1,851 entries), **proven in the deploy script** by extracting the template out of the tarball and hashing it against the pre-deploy value rather than trusting the filename. Socket purge `msg:OK`. Verified as a visitor: chapter numbers render exactly `01 02 03`, both removed headings absent, five sub headings present, four panels in the stack, all six following sections confirmed **outside** the stack by byte offset, twelve routes `200`, served stylesheet byte-identical and carrying the new rules with the three dead ones gone.
- **The hash-transcription trap from the previous entry is now designed out, not just noted.** This deploy computed every expected and target hash with `git show "${sha}:path" | md5sum` into shell variables, asserted each was 32 characters, and passed them to the remote script as environment variables. No hash was ever read off a terminal and retyped, which is the only reliable way to stop a truncated one becoming a fabricated one. Keep this shape: **a hash a human can read is a hash a human can get wrong.**
- **Two probes in a row reported a MISS that was the probe's own fault, both in the verification step.** `curl` was handed an empty URL from a regex that did not match and returned the md5 of the empty string, `d41d8cd9…`, which looks exactly like a deployed-wrong stylesheet; separately a bare `grep "handle"` placed the handle grid inside the stack because chapter 01's copy says "the handle on the bottom rail". **A verification failure is not evidence until the probe is checked** — hash the empty string once and you will recognise `d41d8cd98f00b204e9800998ecf8427e` forever. Assert on a real class name, not an English word that appears in body copy.
- Superseded: live was `2781545` as of 2026-08-05 (17:54), established by checksum on `assets/css/main.css` and the casement template against `18aa909` immediately before the rsync, and re-verified on all three files after it.** It is the tip of `main`. The range over the previous live is six commits and **three theme files**: `casement-windows-v2.php`, `src/scss/main.scss` and the `main.css` built from it. `assets/js/main.js` is untouched across the range (`git diff --quiet`, not assumed), so the compiled-asset hazard applied to the stylesheet alone — `npm run build` was run and `main.css` came back byte-identical to the committed artefact, so what shipped is what the source produces. Content: the casement page restacked from three chapters to five, with options and finishes as plates of their own, head spacing levelled across all five, and the chapter leads rewritten to concrete customer benefit. Backup: `~/backups/fenster-theme/fenster-pre-2781545-20260805-175401.tar.gz` (385M, 1,851 entries), and its copy of the casement template was hashed to `fdbc015e…` to confirm it really is the pre-deploy state. Pruned to the newest three. Socket purge returned `msg:OK`. Verified as a visitor with no cache-buster: page `200`, all five chapter heads in order, all six stack panels present, every copy edit on the page, zero PHP notices, the served stylesheet byte-identical to the new build and carrying the new panel rules, and fourteen canonical routes `200` including `/blog/`.
- **A guard is only as good as the hash you put in it, and a truncated hash silently becomes a fabricated one.** The first run of this deploy aborted on its own guard. The cause was not live moving: the expected hashes had been read off an earlier `md5sum | cut -c1-12` sweep, so only the first twelve characters were real and the remaining twenty were invented to make a full-length-looking constant. The guard compared full strings, matched the first twelve, and refused. **Capture full hashes, never a prefix you then complete.** The failure was benign only because the guard was strict; the same fabricated constant in a check that compared prefixes would have passed while proving nothing. Note this is the inverse risk of the entry below: that one is a guard catching a real change, this one is a guard catching a bad expectation, and both are arguments for the guard being in the script rather than in someone's head.
- Superseded: live was `18aa909` as of 2026-08-05, established by checksum on `assets/js/main.js` and `assets/css/main.css` against every commit in the last 25 on `main` until one matched both.** It is the tip of `main` and carries the whole casement rebuild plus the paid-channel tracking fix. **Deployed by another session, not by this one.** This session found it already on disk and **unserved**: the proxy was still returning the previous `main.js` (126,973 bytes, `504b10b9…`) against the new templates and stylesheet, so production was running new PHP with old assets. The socket purge below returned `msg:OK` and live then served `f3832fd4…` with both strands present. **A live deploy is not finished until the socket purge runs** — the rsync half had been done correctly and the deploy still was not reaching visitors.
- **The checksum guard is worth scripting, not just doing.** This session was about to release a branch cut from `4c85f4a` and had verified live matched it minutes earlier. Between that check and the rsync, another session deployed the casement work to production. The deploy script re-hashed `main.js` immediately before the rsync, saw `f3832fd4…` instead of the expected `504b10b9…`, and aborted. Without that guard the `rsync --delete` would have reverted the entire casement rebuild off live while reporting success. **Re-checksumming twenty minutes early is not a check; put the expected hash in the deploy script and let it refuse.**
- **"Ship only my strand" expired again, and the branch became the hazard.** A `release/ads-channel-attribution` branch was cut from the old live with only the tracking fix on it, correctly rebuilt so no casement code leaked into its bundle. The casement strand then went live in another session, which made that branch a loaded gun: deploying it later would have reverted casement. It was deleted rather than left lying around. This is the same lesson already recorded below about the blog, arriving a second time from the other direction.
- **`main` is ahead of live by the whole casement rebuild, and none of it is approved for live.** *(Superseded 2026-08-05: the casement rebuild is now live in `18aa909`.)* `4c85f4a..e697b12` is 28 commits and 42 theme files: `/casement-windows/` rewritten around the customer's journey, the `.fg-cas` block in `main.scss`, `template-parts/components/privacy-glass-card.php`, the starred single U-value on the Liniar routes (`single_u_value_routes` in `inc/site-data.php`, which changes **seven** product pages, not just casement), both glazing figures on the EnergyPlus banner via `inc/product-hub-data.php`, the Kenrick Excalibur security band, and 34 new image assets. **A release cut from `main` ships all of it**, because these are ancestors of the tip rather than commits landing after it — the explicit-SHA rule alone does not catch that. It is verified on test at `e697b12` and is waiting on the owner. **`assets/css/main.css` changed in this range and `assets/js/main.js` did not** (checked with `git diff --quiet` on each, not assumed), so the cherry-pick and build-artefact hazard below applies to the stylesheet only if any of this is released piecemeal: rebuild it from the branch's own source and diff, never deploy a resolved artefact.
- Superseded: live was `4c85f4a` as of 2026-08-04 (10:44), established by checksum on eight theme files immediately before the rsync and re-verified on the deployed file after it. Deployed straight from `main`, no release branch.** It adds one thing to `1a11109`: the Leagrave integral blinds case study. The theme diff over the previous live is exactly seven new assets and 74 lines in `inc/case-studies-data.php`, with **no compiled asset touched** (`main.css` and `main.js` hash identical across the range), so none of the cherry-pick and build-artefact hazards below applied. The three intervening commits are docs only. Backup: `~/backups/fenster-theme/fenster-pre-4c85f4a-20260804-104404.tar.gz` (380M), and its copy of `inc/case-studies-data.php` was hashed to `ed1c019…` to confirm it really is the pre-deploy state rather than a same-named file. Pruned to the newest three. Socket purge returned `msg:OK`. Verified as a visitor with no cache-buster: the study `200` with all nine assertions, six assets `200` including the 2.1MB mp4, one sitemap entry, the archive card present, the study now linked from `/double-glazing-luton/`, and thirteen canonical routes `200` with the head-term marker intact. `/blog/` still `200`, checked deliberately because that is what the 2026-08-04 double-deploy broke.
- **Live no longer emits `x-proxy-cache: HIT`/`MISS`, only `x-proxy-cache-info: DT:1`.** The instruction below to confirm `MISS` cannot be followed literally any more. Confirm freshness by asserting new content on a plain, non-cache-busted URL instead, which is what the header was ever standing in for. `cache-control` is unchanged at `public, max-age=600, s-maxage=3600, stale-while-revalidate=86400`.
- **`https://www.fensterglazing.com` 301s to the apex.** A verification curl without `-L` reports `301` and no body, which reads as a failed deploy on every single route. Use `-L`, or verify against `https://fensterglazing.com` directly.
- **Strip tags before asserting on rendered text.** `grep -F "Installed 23 June 2026"` fails on a page that displays exactly that, because the markup is `Installed <time datetime="…">23 June 2026</time>`. Two false MISS readings came from this in one session. Pipe through `sed 's/<[^>]*>/ /g'` first.
- Superseded: live was `1a11109` as of 2026-08-04, established by checksum on six theme files in the seconds before the rsync and verified on eight after it. On `release/blog-year-and-blinds`, level with `main`. Carries the blog year, the integral blinds visualiser, the quieter slat variation and the frame-colour card fix.
- **`git push origin main` from a release branch is a silent no-op.** A commit made while checked out on `release/blog-year-and-blinds` pushed the unmoved local `main` ref, reported success, and the server's `reset --hard origin/main` then deployed the previous commit. Nothing failed loudly; the change simply was not there. **After any deploy, grep the deployed file for a string from the change** rather than trusting that the push and rsync reported success.
- Superseded: live was `6e98351` as of 2026-08-04 (midday), established by checksum on eight theme files, and it is the tip of `main`.** It sits on `release/blog-year-and-blinds` and carries **both** the scheduled blog system and the integral blinds visualiser. Compiled assets rebuilt from this branch's own source and byte-identical to `main`'s committed pair. Verified as a visitor with no cache-buster: `/blog/`, blog post 1, `/integral-blinds/`, `/colour-options/`, the homepage, `/casement-windows/` and `page-sitemap.xml` all `200`.
- **TWO SESSIONS DEPLOYED TO LIVE WITHIN AN HOUR AND THE SECOND UNDID THE FIRST.** The blog release `4f910f0` went live at 08:46. The integral-blinds release `00ca9f9` went live shortly after, cut from `13354b4` and deliberately excluding the blog — which by then was owner-approved and already in production. `rsync --delete` therefore removed `inc/blog-posts.php`, `template-parts/sections/blog-post.php` and the `functions.php` registration, and every scheduled post 404'd until `6e98351` restored them. **Before any live deploy, re-read `LIVECHANGES.md` from `origin/main` and re-establish live by checksum immediately before the rsync, not at the start of the work.** A live SHA verified twenty minutes earlier is not evidence about the SHA you are overwriting.
- **"Ship only my strand" is a decision with an expiry date.** It was right for three releases while the blog was unapproved. It became wrong the moment the owner approved the blog in another session, and nothing in this repo told the session holding the older instruction. When two strands are in flight, cut the release from `main` and subtract only what is genuinely unapproved, rather than cutting from an old live and adding only your own.
- Superseded: live was `4f910f0` as of 2026-08-04 (morning), established by checksum, on `release/blog-year`. The scheduled blog system is LIVE, owner-approved.** Cut from the previous live `13354b4` plus the five blog commits cherry-picked from `main` (`e5f4131`, `71dde11`, `73240d4`, `0ea2cd4`, `d0f5951`) and a `main.css` rebuilt from this branch's own source per the compiled-asset rule below; `main.js` stayed byte-identical to live's. 52 posts release themselves every Monday to 26 July 2027 (see `BLOG-CALENDAR.md`); post 1 verified live with `X-Proxy-Cache: MISS`, future posts 404, sitemap carries exactly the published set, all canonical routes `200` with the head-term marker. Backup: `~/backups/fenster-theme/fenster-pre-4f910f0-20260804-084625.tar.gz`; older tarballs pruned to the newest three.
- **The Unix-socket purge DOES work on live** and was used for this release (second time; also the `d57c970` release). The "no CLI purge on live" line below is about `wp sg purge`/`/bin/sg`, which indeed cannot purge — but the base64→php socket script under "Purge live without touching plugin state" returns `msg:OK` and plain-URL requests serve `MISS` immediately after. Use it after every live deploy.
- **`main` remains ahead of live by the integral-blinds strand** (blinds visualiser and colour grid components, `src/js` work, `product-hub-data`/`site-data` changes, through `7d40063`). Not test-verified for release. The next release from `main` ships it — read the range, not just the tip, or cherry-pick again.
- Superseded: live was `13354b4` as of 2026-08-03 (evening), established by checksum, on `release/spec-strip-and-lanterns`. Cut from the previous live `ac6f372`, carrying the glazing spec strip and the roof lantern rebuild. The blog system was again cherry-picked around. Backup: `~/backups/fenster-theme/fenster-pre-13354b4-20260803-181620.tar.gz` (380M, 1,799 entries), confirmed by grepping the SHA. Five theme files byte-identical on production; twelve routes `200`.
- **A compiled asset resolves to a side, not to your source.** The cherry-picked `main.css` carried 6,058 bytes of blog styling from `main`, because a conflict on a build artefact takes whichever version you pick rather than what the branch's own source produces. Rebuilding from source stripped it; `fg-blog` returns zero on live. **Always rebuild compiled CSS and JS after a cherry-picked release and diff the result** — deploying the resolved artefact would have put unapproved styling on production.
- Superseded: live was `ac6f372` on `release/casement-and-liftslide`. Cut from the previous live `d57c970` and carrying only the fourteen casement, consent and lift-and-slide commits from this session, cherry-picked so the scheduled blog system did **not** ship. Backup: `~/backups/fenster-theme/fenster-pre-ac6f372-20260803-162526.tar.gz` (379M, 1,783 entries), confirmed present by grepping the SHA before deploying. Seven theme files verified byte-identical to the commit on production; fourteen routes `200`; the head-term marker intact.
- **`wp sg purge` cannot run on live: `sg-cachepress` is inactive there**, though it is active on test, so the deploy one-liner in this file will always error on the live half. **There is no CLI purge on live** — `/bin/sg` has no cache group and wp-cli exposes no cache commands. The proxy cache is real regardless (`x-proxy-cache: HIT`, `s-maxage=3600`), so after a live deploy the changed routes keep serving the old HTML until that expires or someone flushes from SiteGround Site Tools. Verify with a cache-busted URL, and expect a plain-URL check to read as a failed deploy when it is not.
- Superseded: live was `d57c970` on `release/seo-quick-wins`. It is `adad8f8` plus the SEO quick-wins commit (the `/commercial/` → `/commercial-glazing/` redirect, roof-lights phrasing on `/roof-lanterns/`, French-casement description). The same change sits on `main` as the rebased `9761138`. Backup: `~/backups/fenster-theme/fenster-pre-dac7873-20260803-145719.tar.gz` — named for a superseded release SHA but its content is the pre-deploy `adad8f8` theme. Older tarballs pruned to the newest three per policy. Socket purge returned OK; verified `X-Proxy-Cache: MISS` plus new content, and all canonical routes `200` with the head-term marker present.
- **The casement/consent/lift-and-slide strand is now shipped** as `ac6f372`. **`main` remains ahead of live by the scheduled blog system** (`inc/blog-posts.php`, batch 1 of 8 posts — **awaiting owner review on test before any live deploy**; see `BLOG-CALENDAR.md`). A release from `main` still ships it, because those commits are ancestors of the tip rather than commits landing after it, which the explicit-SHA rule alone does not catch. **Read the range, not just the tip.**
- Historical, and no longer the case: live is level with `main` as of `1a11109`. **Live was not an ancestor of `main`, deliberately.** `ac6f372` was a cherry-pick of work whose originals are already on `main`, so `main` holds the same content minus nothing; only the blog system separates them. Do not merge the release branch back to tidy the graph. Re-establish live by checksum next time as usual.
- **The pointer below was stale AGAIN on 2026-08-03: it said `c97aff4` while live checksummed to `adad8f8`** (deployed ~10:30 that morning; the `~/backups` tarball name was the tell). Fourth consecutive release where this line was wrong at deploy time. The checksum step caught it and prevented an accidental revert of the scrub-videos fix.
- Superseded 2026-08-03 morning line: live was `c97aff4` on `fix/windowcad-payload-limit`; that branch is now merged into `main` history via `adad8f8`'s lineage.
- **WindowCAD leads were dead from 31 July to 3 August.** The tracking-repair branch added a 100,000-byte payload cap to the webhook's permission callback. Every genuine WindowCAD submission exceeds it: the webhook posts the whole quote document while the parser keeps only the `infoProperties` values, a few hundred bytes once stored, so the cap had been sized against the parsed result rather than the request. The access log is unambiguous — 51 consecutive `200`s from 6 to 30 July, then three `413`s on 31 July at 14:30, 14:34 and 14:38, and no enquiry post created until the fix. **Never gate that webhook on body size.** The ceiling is now 5 MB and logs rather than dropping.
- **Diagnose lead loss from the access log first; `php_errorlog` will be empty.** A rejection inside a REST `permission_callback` happens before any theme logging runs. One command dates the breakage exactly:

  ```bash
  zcat ~/www/fensterglazing.com/logs/*.gz | grep 'POST /wp-json/fenster/v1/windowcad'
  ```

- Active GitHub repo: `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`
- Superseded: live was `0b0affe`, deployed 2026-08-02. Established by checksum as `32dcba6` before deploying. Backup: `~/backups/fenster-theme/fenster-pre-0b0affe-20260802-154451.tar.gz` (379M, 1,782 entries). **Still re-establish by checksum before the next release rather than trusting this line, and pick files the candidate commits actually differ in.** On the release before this one, three of five checksummed files tied across two candidates and only two separated them.
- The previous live runtime was `6fdf9ff` (2026-08-02).
- **The pointer was stale again at deploy time.** This file said `8052f65`; the live theme actually checksummed to `d3600ad`, the docs commit straight after it, so the theme content was the same but the recorded SHA was not the deployed one. That is three releases running where the line was wrong. **Re-establish by checksum every time; it takes under a minute.**
- The previous live runtime was `616d673` (2026-07-30). Before that, `c87391f`, `572fe3c`, `6ea0dba`, `834b424`, `4458fc6` and `94e7d0f`.
- **Re-establish live by checksum before every deploy rather than trusting this line.** It was stale by four commits on 2026-07-24. Checksum a few theme files against history: `inc/site-data.php`, `assets/css/main.css`, `assets/js/main.js` and, when those tie, whatever the candidate commits actually touched. Correct this line as part of the deploy.
- The earlier `release/heritage-doors` divergence is closed: everything on it reached production through the 2026-07-22 releases, and live has been deployed from `main` since.
- The previous approved promotion was `13e7f95` (`Heritage doors case study: real interior photos + Sheerline award`) on 2026-07-17. This is the curated residential case studies system (`/case-studies/`), now with six projects including two video-led roof lantern studies (Drayton Parslow big lantern, Northampton lantern + heritage doors with a Sheerline Installation of the Month award). Studies auto-sort by date.
- **`wp sg purge` FAILS ON LIVE and always has — the deploy one-liner below is wrong for production.** It returns `Error: 'sg' is not a registered wp command` because `sg-cachepress` is **inactive** on `fensterglazing.com`. It is active on test, which is why nobody noticed. The consequence is nasty: the theme rsyncs correctly, `wp cache flush` reports success, the deploy looks green, and SiteGround's proxy keeps serving the OLD page. Verified on the `a8f8388` deploy — `x-proxy-cache: HIT`, none of the new content present, and the page still referencing an image already deleted from disk. Headers are `s-maxage=3600, stale-while-revalidate=86400`, so it self-heals in about an hour and repeated requests will NOT force revalidation.
- **Do not fix that by activating sg-cachepress on live.** `siteground_optimizer_lazyload_images` is set to `1` there, so activating it would switch on lazy-loading and change live rendering, probably fighting the theme's own deferred-media hotfix `7c973b5`.
- **Purge live without touching plugin state.** The plugin's purge is just a JSON message to a Unix socket. Base64 this to the server and run it with `php` after every live deploy:

  ```php
  $fp = stream_socket_client('unix:///chroot/tmp/site-tools.sock', $e, $s, 5);
  fwrite($fp, json_encode(array(
    'api'=>'domain-all','cmd'=>'update',
    'params'=>array('flush_cache'=>'1','id'=>'fensterglazing.com','path'=>'/(.*)'),
    'settings'=>array('json'=>1),
  ), JSON_FORCE_OBJECT)."\n");
  echo fgets($fp, 32*1024);
  ```

  A successful purge returns `{"json":{...,"msg":"OK",...}}`.
- **Verify like a visitor, with NO cache-buster.** Re-request the changed page plainly and confirm `x-proxy-cache: MISS` plus the new content. A cache-busted URL always looks correct and proves nothing. Also note: curling live from the server with a full spoofed Chrome user-agent returns a SiteGround WAF `403`; a plain UA such as `Mozilla/5.0 deploy verification` works.
- Deploy cache note: `wp cache flush` alone does NOT clear SiteGround's dynamic/proxy cache, so changes can appear missing on test/live. `wp sg purge` still works on **test**. When verifying, also cache-bust the URL. Verified live on 13e7f95: archive plus all six detail pages `200`, videos and the interior photo `200`, both new studies present in `page-sitemap.xml`.
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

> **The trailing `wp sg purge` in that live command does nothing** — see Current Truth above. Run the socket purge instead, then verify the changed page with no cache-buster and confirm `x-proxy-cache: MISS`. Until you do, the deploy is on disk but not reaching visitors.

> **Take the pre-deploy backup, then prune.** `~/backups/fenster-theme` gains a ~375 MB tarball per deploy and had no retention policy: 46 files / 17 GB by 3 August 2026, which is most of why the account hit 107% of its disk quota and SiteGround disabled Site Tools. Keep the newest three and delete the rest as part of the deploy. Check `du -sh ~/*` first if anything looks tight — it finds the problem in one command.

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
- Roof-light keyword coverage is handled through title/meta overrides for `/roof-lanterns/` and `/roof-lanterns-northampton/`, plus the two-word form in the `/roof-lanterns/` hero eyebrow. The `/roof-lanterns-milton-keynes/` override is dead code: that route 301s to `/roof-lanterns/` under the blanket `-milton-keynes` consolidation.
- `/commercial/` (the old site's hub URL, 81k GSC impressions) 301s to `/commercial-glazing/` via the theme redirect map as of `d57c970`. Before that, WordPress's 404 guess sent it to `/commercial-automation/`. Do not remove the map entry.

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
- **Ad destination URLs are not carrying UTM parameters.** Nearly every attributed lead in the dashboard shows its source as "Direct or unknown", so paid traffic is invisible as paid and no channel can be credited with a lead. Nothing in the dashboard can recover a source that was never sent — fix the tagging on the ad URLs. Related: WindowCAD completions relay no `product_collection` or `price_amount`, so lead value and cost-per-lead cannot be computed at all.
- The Marketing Dashboard Website Tracker is also consent-gated. Its production code and API are hosted separately at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`; deploy dashboard changes from that repository, not from this theme deployment. Read `WEBSITE-TRACKER.md` in that repository before changing the tracker or interpreting an outcome. Analytics consent permits opaque `FGV-…` visitor tracking and 30-minute `FG2-…` journeys. Non-consented activity is aggregate-only, environment-separated and cannot join a person. Completed lead relays require the shared signing secret and deterministic event IDs. Do not change `src\js\main.js`, `inc\consent.php`, `inc\website-tracking.php` or `inc\adminbase.php` in a way that sends rejected/no-choice browsing, form or WindowCAD events to an identified dashboard journey.
- WindowCAD URL attribution belongs in its separate **Tracking** field, never the office-owned **Reference** field. Analytics uses `FG2-…`; marketing-only attribution uses `FGA-…`; rejected/no-choice values are `rejected-cookies` / `cookie-consent-not-accepted`. Only `FG2-…` may create or join a dashboard journey.
- `test.fensterglazing.com` is intentionally Basic Auth protected to avoid a public duplicate. Username: `fenster`; password: `Fenster`. The test `.htaccess` also serves public `robots.txt` with `Allow: /` and uses a custom 401 handler so blocked test URLs return `X-Robots-Tag: noindex, nofollow, noarchive`; keep that combination so Google can drop already-discovered test URLs.
