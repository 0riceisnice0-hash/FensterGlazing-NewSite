# Fenster Glazing Progress Log

Last updated: 2026-07-21

## 2026-07-21 - Heritage aluminium doors: dedicated Sheerline Classic page (test, 2f69c17)

- Owner report: `/heritage-aluminium-doors/` was showing images of uPVC doors. Confirmed by fetching the route. Root cause was in `inc/site-data.php`: `product_gallery_groups` mapped the route to the generic `aluminium_doors` pool, which is mostly modern Sheerline Prestige entrance doors plus two window profile close-ups. The white flat-panel Prestige doors (`sheerline-aluminium-door.jpg`, `Prestige-aluminium-door-in-stone-web.webp`) and the grey threshold crop read as uPVC to a customer. Wrong product, wrong century.
- Owner chose a full dedicated page over an image swap. New `template-parts/sections/heritage-aluminium-doors.php`, dispatched from `generated-page.php` on the slug, following the `roof-lanterns.php` pattern. Nine sections: hero, four-fact specification strip, the nine stocked configurations as a coverflow carousel, period lockbox and stepped-bar detail, Thermlock plus corner-joint construction, two jobs the doors do well, the Secured by Design upgrade, the twelve standard colours, enquiry, reviews.
- 36 local WebP assets under `assets/images/products/heritage-aluminium/`, built from the Sheerline scrape at `Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\sheerline_scrape_20260612`. The nine configuration renders were cropped through **one shared window** rather than trimmed individually, so a toplight door still reads taller than a plain single door. Runtime code does not touch the scrape export.
- The nine renders are in the scrape as `1-anthracite.jpg` through `9-silver-metal.jpg` and map 1:1 onto the configuration headings in `Classic-Heritage-Door-Sheerline.md`. Every label was checked against its render before publishing: bar counts and toplights match.
- Facts are rewritten from the Sheerline source, not pasted: 60.5mm sightlines, 1.4 W/m²K double glazed, max sash 2.2m x 1m, opens in or out, single or French, twelve standard powder-coated colours, dual and bespoke colours available, 25mm and 40mm flat or stepped bars, Thermlock at close to double the insulation of polyamide, cleated corners. Secured by Design is stated as an optional upgrade rather than the standard, because it is.
- `product_usps` for this route dropped the `Any RAL colour` claim. **The same claim is still on seven sibling aluminium routes and one product-hub choices list.** It needs an owner decision rather than a silent sweep; a background task was raised.
- Two defects found by looking at the rendered page rather than the metrics. The shared enquiry form's dark defaults leaked into the new white panel, so every input rendered white on white and the consent row grey on grey; fixed by extending the existing `.fg-roof-lantern-form` light-panel rules to `.fg-heritage-door-form` instead of writing a second copy. The three hero bullets pushed the door photograph below the fold at 390x844; hidden at 560px, matching the roof-lantern hero.
- Verified on test at 1440x900, 768x1024 and 390x844 via CDP headless Chrome: no horizontal overflow at any width, 29 of 29 images loaded with none broken, max heading 52px against the 57.6px cap, zero console errors, carousel advances through all nine slides. Every section I authored fits the ~830px desktop viewport budget; the shared enquiry form is 900px, which `STYLE.md` permits.
- Also committed `src/scss/main.scss`, which had drifted: `b07c12d` shipped a compiled `main.css` whose source was never committed. Source and compiled now match again. Live is untouched.
- **Copy correction after owner review (`29661a1`).** The security section was written against `STYLE.md` without reading `TONEOFVOICE.md`, and the owner rejected it. It failed that document's own self-check: no name, place, date or number in the section, and lines a competitor could have pasted unchanged ("police-backed standard", "passed the scheme testing"). It also opened with "We would rather say this plainly", which is the About page's phrase borrowed rather than earned, and announces plainness instead of being plain. Rewritten to name the industry habit directly, then make the decision physical: a walled courtyard against an unlit alley, a four bar door's five small panes against one sheet of glass at chest height, closing on being happy to say no. The `Ask about the security spec` button was dropped because it scrolled to the same form the hero CTA already targets, which `STYLE.md` rules out as a duplicate primary action. **Read `TONEOFVOICE.md` before writing page copy; `AI.md` already says so and this session did not.**

## 2026-07-21 - Composite doors: door style wall and real paint range (test, 81a932c)

- Owner rejected the interactive per-layer construction diagram ("doesn't work at all"): reverted to the single cutaway image, removed the layer buttons, the switching JS and the five extra per-layer assets. Do not rebuild that interaction.
- Owner's two asks were the colours looking good and using the hundreds of door assets in the Distinction scrape. Both are now built from the scrape and committed as theme assets via `scripts/build-composite-door-wall.py`, so the scrape stays a source, never a runtime dependency.
- **Door style wall** (`.fg-cd3-wall`, 736px): the `sign_*` files in the scrape turned out to be the complete Signature catalogue as full-bleed door faces, plus a few Contemporary codes. 27 curated styles render as a wall of real door faces, each labelled with its style name and collection so a customer can ask for it by name. Desktop drifts on a 90s CSS marquee (list rendered twice, second pass `aria-hidden` and `is-clone`) with an edge mask and pause on hover/focus. At 860px and below, and under reduced motion, the animation is off, the clone is hidden and the viewport becomes a native scroll-snap rail with a partial next-card peek. Verified on mobile: clones hidden, animation `none`, 3,871px scrollable, no body overflow.
- **Paint range** (`.fg-cd3-palette`, 742px): 23 real Distinction colours photographed as brush strokes, with the RAL and BS references printed in the Distinction brochure. This replaces flat generated colour blocks as the answer to "the colours section sucks". Copy states plainly that screens shift a shade and that physical samples come to survey, and notes dual-colour inside/out plus single-sided woodgrain stains.
- Style names come from the Distinction Signature and Contemporary product pages in the scrape; do not invent names for door codes those pages do not list. The blanket "any RAL colour" claim from the brochure is still excluded per `AI.md`.
- Verified on test at 1440x900: every composite section is inside the ~830px viewport budget (collections 632, wall 736, gallery 782, anatomy 789, types 459, configurator 798, palette 742). No horizontal overflow at 390 or 1440, zero console errors, all 23 paint swatches and door images lazy-load correctly.
- Open question for the owner: with the door wall now showing the style range, the `Real homes` lifestyle mosaic (782px) may be doing a similar job. It was left in place because removing an established working section needs owner approval under the `AI.md` visual recovery rule.

## 2026-07-21 - Composite doors: one-viewport sections and colour picker rebuild (test, 140d05b)

- Owner follow-up: every composite section must fit one 1440x900 viewport (no section may take two or more scrolls) and the colours section was rejected. Measured real section heights on test via CDP before and after; the viewport budget below the fixed header is about 830px.
- Before: collections 1195px, gallery 959px, anatomy 1035px, configurator 922px. After: collections 632px, gallery 782px, anatomy 789px, types 459px, configurator 798px with the stage at exactly 480px. FAQ 632px, quote embed 607px and reviews 562px already fitted.
- How: desktop collections became horizontal image-beside-copy cards inside a `min-width: 861px` override (mobile keeps the stacked image-first card), gallery mosaic rows dropped to `clamp(140px, 12vw, 172px)`, the anatomy panel/paddings/type scale were compressed, composite section padding tightened to `clamp(2.5rem, 4vw, 3.5rem)`, and the configurator stage went from 520px to 480px including the 641-860px tablet override.
- Colour panel rebuilt: real colour swatch tiles (46px chips with the colour as the control, green ring + bold label when active, five columns on desktop and three below 640px), a dashed `And more` tile, and a `Selected colour` name/copy block beside the controls. The caption box that covered the photographed door is gone; glass got the same clean-photo treatment with its own selected block. The shared `[data-fg-door-selector]` JS needed no changes because name/copy targets are found anywhere inside the selector container.
- Verified on test: all composite sections ≤830px at 1440x900, no horizontal overflow at 1440/390, zero console errors, and a CDP interaction pass confirmed tab switching plus Chatsworth/Ruby Red selection updates. Two shared sitewide components still exceed the budget on this route: the case-study strip (849px) and the shared enquiry form (949px, which STYLE.md permits to run taller); changing those affects every page using them, so they were left for an owner decision.

## 2026-07-21 - TONEOFVOICE.md and composite doors substance pass (test, 54281d4)

- Wrote `TONEOFVOICE.md`, the customer-facing copy voice reference, by reverse-engineering the owner-approved About page copy: facts over adjectives, say the awkward thing first, real people/places/jobs as proof, full-stop sentence-case headings that state a customer truth, no contractions in the About register, one dry aside per page maximum, and a supplier-copy rewrite process. `AI.md` documentation rules now point at it. All future page copy should be checked against it.
- Owner verdict on `/composite-doors/` was "not good enough, redesign or major improvements" with instruction to use the Distinction scrape content. Audit finding: the live V2 was a configurator with no product substance at all, and none of the scrape's construction/thermal/security material was used. Kept the working structure and added the missing substance rather than tearing it down.
- New `What is inside the slab.` construction section (between the real-homes gallery and the stable-doors panel): a cutaway illustration from the scrape (`anatomy/slab-cutaway-428w.webp`, new theme asset), six numbered layers (GRP skin, water-resistant polymer edges, engineered wood stiles, reinforced central board, foam-filled core, decorative glass), a four-stat strip (44.5mm slab vs 28mm uPVC panel, 50% thermal figure, £5,000 security guarantee, 10 year guarantee) and the Salford Energy House footnote attributing the 50% claim to Distinction's independent testing.
- Accuracy notes baked into the copy: most Distinction decorative glass is triple glazed and laminated as standard but Chatsworth and Wentworth are double glazed; Secured by Design accreditation applies to the slab (stable doors sit outside the scheme, so SBD lives in the security FAQ with the caveat rather than the stat strip); no invented U-value, the FAQ explains why and gives the tested comparison instead.
- Page-wide copy rewritten in the About voice: hero CTA is now `Send an enquiry` (route-gated; other product routes keep the sitewide label, verified on `/casement-windows/`), the installer banner carries the one-in-four proof line, collection cards gained `Best for` guidance panels, the collections/gallery/configurator headings state customer truths, and all five FAQs now carry real construction, security, dual-colour, maintenance and U-value answers.
- QA on the protected test site at 1440x900, 768x1024 and 390x844 via CDP headless Chrome: no horizontal overflow at any width, zero console errors, anatomy panel composed on desktop and cleanly stacked on mobile with a 2x2 stat grid. Local Sites was not running, so all verification was on test. Live is untouched; test is at `54281d4` awaiting owner review.

## 2026-07-21 - Live promotion, AdminBase TLS outage fix, and WindowCAD diagnosis corrected (d2d5aa3)

- Promoted the tracking hardening and mobile cookie/Legend fixes to production at `193dc51` (backup `fenster-pre-193dc51-…`), then verified the mobile fixes on live in WebKit iPhone emulation.
- Corrected the earlier WindowCAD diagnosis after owner pushback and direct testing: the Tracking capture is **invisible and URL-driven** and works with the current WindowCAD configuration. Intercepted (aborted) submissions showed the app storing the `tracking=` URL value under the Tracking property key without any visible form field, and the owner's live test (`FG2-ZACLIVETEST0721`) arrived in WindowCAD, WordPress, the AdminBase notes and the dashboard. Leads without tracking values are office-entered projects or direct/re-opened WindowCAD sessions. No WindowCAD settings change is needed.
- Found and fixed a genuine outage the live tests exposed: AdminBase renewed its certificate onto the Sectigo R46 root, which WordPress' bundled CA file predates, so every relay since at least 2026-07-21 failed with cURL error 60 (Carol Jarvis's real lead was stranded in WordPress). `fenster_adminbase_http_ssl_args()` now points AdminBase requests at the host system trust store; deployed to test then live (`d2d5aa3`), both stranded leads re-relayed with HTTP 200, and the handler now fires the dashboard `quote_completed` before the AdminBase attempt so attribution survives CRM outages.
- Remaining cleanups for the office: delete the WindowCAD projects "CLAUDE TEST DO NOT PROCESS" and "Zac - test, delete", and their AdminBase copies.

## 2026-07-21 - Mobile cookie/Legend tap fixes (test, f2c16ad)

- Investigated the owner's report that people cannot accept cookies on mobile. The accept flow itself passed real-WebKit iPhone and Chromium touch testing against live, and the Fanboy cookie-blocklist has no rule matching `.fg-cookie-consent`. Two genuine defects were found next to it and fixed:
- The `.legend-assistant` fixed wrapper defaulted to `pointer-events: auto`, so its transparent ~280x360px box silently swallowed taps on page content beneath it (its interior sits directly above the cookie banner on phones). The wrapper is now `pointer-events: none` with the launcher, prompt and open chat panel explicitly interactive, restoring the documented rule.
- With the Legend drawer open, the cookie banner (z 12000) floated on top of the full-screen chat (z 1100) and buried the composer on mobile. The banner now hides while `legend-chat-open` is set and returns when chat closes; consent still gates all optional tracking. Banner buttons also gained 48px tap targets at mobile widths.
- Verified on the test site in WebKit iPhone emulation and at 1440 desktop: dead zone gone, composer reachable during chat, banner returns after close, accept stores consent at both widths, no horizontal overflow, no page errors. WindowCAD's owner screenshots confirmed the Tracking field definition survives in the account; the missing piece remains its absence from the retail/door designer form field lists.

## 2026-07-21 - Tracking audit, WindowCAD tracking-number root cause, tracker redesign

- Audited every tracking system end to end: consent banner and gated GTM/Clarity/Meta Pixel, consented `FGV`/`FG2` attribution events, the aggregate statistical path, Legend chat QA relay, WindowCAD URL parameter rewriting (links and deferred iframes verified on live), the `/wp-json/fenster/v1/windowcad` callback, AdminBase relay and the Marketing Dashboard D1 store. All theme-side plumbing was verified working on live.
- Root cause of the missing WindowCAD tracking numbers: between 2026-07-14 evening and 2026-07-16 morning the WindowCAD account's website designer form configuration was edited (the required "Where did you hear of us?" dropdown appeared) and the custom **Tracking** info property was removed from the retail and door designer `projectInfoProperties`. The property still exists on the account but is not on the form, so the `tracking=FG2-…` URL parameter has nothing to fill. This is external WindowCAD configuration; the fix is re-adding Tracking to the website designer form field list in WindowCAD settings.
- Found a second concern: zero WindowCAD callbacks reached WordPress between 2026-07-16 09:56 and 2026-07-21 despite 12-25 quote-tool loads per day (historical completion rate ~2/day). The endpoint probes healthy (422 on empty payload, logged), so either quote completions collapsed (the form now requires more fields) or WindowCAD stopped posting; the office should confirm whether quotes arrived in WindowCAD itself during that window.
- Theme hardening in `inc/adminbase.php` and `inc/website-tracking.php`: tracking extraction now accepts a valid `FG2-` value from any submitted field; a submission with no tracking value logs a clear warning and adds "Website tracking: none" to the AdminBase notes; completions without a consented `FG2` are relayed to the dashboard's aggregate-only statistical path as `quote_completed` (device class `server`) so totals remain measurable and breakage is visible within a day. Removed the dead non-consented branch in `journeyReference()`.
- Marketing Dashboard (separate repo, deployed to Cloudflare Pages at `cf8a34e`): Projects → Tools is now a hub with two large tool cards (Fenster Meta Bot, Website Tracker) replacing the cramped toggle tabs; each tool opens full screen with a back control. The Website Tracker was rebuilt around five views: Overview (KPI cards, 30-day stacked consented/anonymous daily traffic chart with lead-day dots, funnel, consent health meter, decision guidance, recent lead outcomes with office status), Acquisition (channels, quote products, top CTAs), Pages (consented top pages with average engaged time, anonymous top pages, device split), Customers (journey timelines) and Legend chats. The API's `website/state` now returns daily series, top pages, device split, top CTAs, form validation fields and product-collection quote activity, and the Overview shows an amber alert counting WindowCAD completions that arrive without a tracking reference.

## 2026-07-20 - Six-fixes batch promoted to live at de13375

Owner approved with one change: the footer social chips looked poor (the outline-style Instagram SVG was being force-filled into a solid blob, and the dark green tint was muddy on the dark footer). They are now white pill chips echoing the trust-logo tiles, with the Instagram mark stroked and the solid glyphs filled.

Promotion followed the rules: `git log a8f15d8..de13375` range check (only this session's commits), server-side theme backup (`~/fenster-theme-backup-before-de13375-20260720-190148.tar.gz`, 346M), reset to the explicit SHA, `wp cache flush && wp sg purge`. Verified on production: all six routes 200, composite section on the colours hub, case-study strip and link cards on `/casement-windows/`, homepage strip, no old picker page-chunks on `/obscured-glass/`, new socials in the footer. The obscured-glass swipe still deserves a quick real-iPhone check when convenient.

## 2026-07-20 - Six fixes from Nick's list, deployed to test only

Each claim in the supplied task list was verified against the codebase before coding; two were inaccurate (there are eight related-link bands plus the price-guide one, not four, and `$product_routes` on the homepage is a five-entry hub list rather than a URL-to-image map). Test is at `146d78a`.

1. **Composite door colours on the colours hub.** The eight-colour array moved from `generated-page.php` into `colour_options.materials.composite` in `inc/site-data.php` with a 480w image per colour. The hub renderer picked it up with no template change; the composite doors V2 page reads the same source (verified: selector renders all eight and previews correctly). Portrait door slides get a scoped 4:5 crop on a narrower slide so the coverflow row holds. Deep links (`?material=composite&colour=ruby-red`) work through the existing generic handler.
2. **Case studies on product pages.** `fenster_case_studies_for_product()` matches on the `products[]` links studies already carry (verified on `/casement-windows/`: both casement studies, not newest-three), newest-first fallback otherwise, rendered as a strip before the enquiry section on product-journey routes.
3. **Homepage case-studies block** after the proof wall: three newest studies via the same shared card partial (`components/case-study-card.php`), which the archive now uses too.
4. **Related-links image cards.** `fenster_link_card_image()` maps ~20 routes to material-correct curated photos; the shared `components/link-cards.php` renders image cards plus text pills for unmapped links (areas, towns). Converted the four `generated-page.php` bands and the two location-service "Keep exploring" bands; the MK-area link clouds stay text by design. Two fixes found by looking: card labels were white-on-white inside the dark links band, and `repeat(auto-fit, minmax(min, max))` counts tracks by the definite max, which forced two columns; the card is capped instead of the track.
5. **Footer socials** restyled as solid brand-tinted 44px chips with 22px icons; markup untouched.
6. **Obscured-glass mobile picker.** Rebuilt the swipe rail: the old full-width page chunks with `scroll-snap-type: x mandatory` plus negative margins is a known WebKit-fragile construct (snaps straight back, so iPhones could not swipe). Now a flat two-row `grid-auto-flow: column` rail with per-card proximity snapping, `touch-action` and `-webkit-overflow-scrolling` overrides removed, matching the site's other iPhone-working rails. Verified at 390: 21 buttons, 1,618px of scrollable overflow, programmatic scroll works, no body overflow. Not tested on a physical iPhone; needs a real-device check.

## 2026-07-20 - Promoted to live: About redesign, price guide redesign, review links

Owner approved promotion after reviewing test. Live deployed from the server repo cache pinned to `a8f15d8` (never `origin/main`), after a server-side theme backup (`~/fenster-theme-backup-before-a8f15d8-20260720-153724.tar.gz`, 346M) and the `git log af4cfc2..a8f15d8` range check.

The range check surfaced one rider: `68b9e6b` (Nick's 2026-07-20 site review: linked Google/Trustpilot logos site-wide, removed the homepage collection counter, expanded the Commercial and Windows nav). It is owner-originated, was verified on test, and shipped with this promotion; noted here so the audit trail is explicit.

Post-deploy verification on production: `/about/` serves the boxed showroom hero, mission H1 and the one-number pricing line; `/window-door-prices-milton-keynes/` serves the round guide figures (£600, £2,000, £3,500) with zero internal-plan copy; all seven price guide routes return 200. Caches flushed with `wp cache flush` and `wp sg purge`.

Later the same day the About hero was reverted from the full-bleed stage to a boxed 16:10 frame beside the mission copy (owner request), and the guide prices were rounded to the owner's figures. Both are included in `a8f15d8`.

## 2026-07-20 - About hero swap and price guide redesign, deployed to test only

Second owner feedback round. Test is at the About/price-guide redesign commit; live untouched.

- **About:** the cinematic mission hero keeps its layout but the media is now the showroom photograph (owner request), with the tag `Our showroom, Milton Keynes`. The `Same software, same price list, same number.` strip was removed as unnecessary; the fact lives in the pricing copy as `One number for the job, not an online teaser and a different figure at the door.` The award video remains the page's only video.
- **Price guides (all seven, shared template):** full customer-facing redesign, prompted by the pages being accidentally live. The internal plan copy (`These rows are the slots we will fill...`, `How we should show it`, the status card) is gone. Placeholder `To confirm from WindowCAD` rows never render publicly; only examples with a confirmed £ price appear. The main page leads with its three checked examples (£583.61 casement, £1,999.20 composite door, £3,469.43 bifold) as photo-led cards pairing the fitted price with our own install photos (Leighton Buzzard casements, Whitehouse bifolds) and the exact WindowCAD configuration as a captioned inset. The hero gains an at-a-glance checked-prices card; guides with no checked examples get a `Your price in minutes` fallback card instead. Factors render as a ticked two-column checklist, FAQs are rewritten for customers, intros in `fenster_price_guide_pages()` are rewritten customer-facing, and the deferred quote-station iframe block is untouched and verified loading.
- Verified at 1440/975 visually and 390 numerically on both routes: no overflow, no heading-cap violations, photo-first stacking and full-width buttons on mobile, and zero leaks of internal copy on any guide checked.

## 2026-07-20 - About page revision after owner feedback, deployed to test only

Owner feedback on the fifth version: open with the mission rather than selling the quote tool, write better copy, present the traditional consultation route as something we offer rather than mock, note that both routes use the same pricing software so the number is identical, drop "at your kitchen table", improve mobile, and add one wow factor. Test is at `2064ea4`.

- **Hero is now the wow factor:** the mission statement (`Simple, honest glazing.`) sits over the Drayton Parslow install video playing full bleed behind a left-to-right scrim. The video is a background, so it is desktop-only; mobile and reduced-motion users get the poster under a vertical scrim with the copy anchored to the bottom of the stage. Marked with `data-fg-video-bg` in `main.js`.
- **Pricing section reframed as two equal routes:** `Online` and `In person` step rails, both green, with the in-person route ending `You get the price on the spot`, and a strip across the panel reading `Same software, same price list, same number.` No route is disparaged.
- **Copy rewritten page-wide** in a tighter voice; the founders section is `Run by the two people who started it.`
- **Mobile polish:** buttons stack full width below 560px, the mosaic and grids collapse as before, hero stage is `min(78vh, 34rem)`.
- Bug fixed on the way: a `width: 100%` override on the hero content span killed `.container`'s auto-margin gutters and pinned the copy to the viewport edge.
- QA note: background tabs produce no frames, so IntersectionObserver-driven video attach and reveals never fire in a hidden automation tab. That is throttling, not a page bug; the video attaches the moment the tab is visible.

## 2026-07-20 - About page redesign (fifth version), deployed to test only

Full recomposition of `/about/` around the instant-pricing positioning, built after reading `ABOUT-PAGE-HANDOVER.md` and verified in a real browser on the test site. Live is untouched; test is at `6918091`.

**Composition (desktop, cascading media right/left/right/left):** hero with H1 `The price comes first.` beside the Drayton Parslow roof lantern install video; fact strip (2018, 1,000+, in-house fitters, 10 year guarantee); dark steel pricing band with a numbered `Pricing with us` vs `The usual way` comparison rail; five-cell fixed mosaic of case-study photos, each linking to its study; founders section with mid-size B/W portraits of Adam and Nick; Sheerline Installation of the Month (August 2025) section playing the actual Northampton job video; accreditation cards with the honest guarantee-exclusions note; showroom visit section; shared review showcase; six-card route grid (quote, consultation, case studies, team, trust, colours).

**Movement without parallax:** the two case-study videos load deferred via `[data-fg-about-video]` (sources carry `data-src`, attached near viewport; reduced-motion users get poster plus controls, no autoplay), plus gentle fade-up reveals via `[data-fg-about-reveal]`. No multi-image parallax and no ghost numerals, both previously rejected.

**Bugs found by looking at the rendered page:**

- Founder name captions rendered as overlay chips across the portraits: the generic `.fg-about figure > figcaption` chip rule out-specified the founder override. Fixed with a more specific selector.
- Hero video measured 498px wide in a 390px viewport: in-flow videos fed intrinsic size into the grid row and the figure `aspect-ratio` derived width from that height. Videos are now absolutely positioned inside their aspect-ratio boxes.
- A dead rule from a pre-redesign About page (`.fg-about-hero__media, .fg-about-feature__media, ... { min-height: 280px }`) squashed the mobile hero to the wrong ratio. Removed; the other selectors exist in no template.
- Fast scrolling could jump a reveal item past the IntersectionObserver in one frame, leaving it permanently invisible. The observer now uses a huge top rootMargin so anything at or above the viewport counts as intersecting.

**Verification:** all 22 reveal items visible after a fast scroll; every image `complete` with real dimensions; no horizontal overflow at 390 or 1440; H1 51.8px within the 57.6px cap; grids collapse correctly at 390 (single column, 2-col mosaic, copy before the pricing panel). Note for future QA sessions: the claude-in-chrome automation browser cannot stream any mp4 (even the live case-study videos stall at readyState 0 there), so video playback must be judged by the 206/range-request check and a human eyeball; posters cover the fallback.

## 2026-07-20 - Live/doc reconciliation: unapproved production release found

Documentation-only session from the home PC. No code or production change was made.

**What was found.** Server-side checks showed live and test theme directories byte-identical (`main.css` md5 `7d3edfc3613998a94884767aca678e6d`), both at `af4cfc2`. Docs claimed live was `13e7f95` with three features held back on test. All three were in fact on production:

- **Composite Doors V2** — `/composite-doors/` serves the V2 template (`fg-cd3-collections` present in live HTML). `COMPOSITE-DOOR-REDESIGN.md` said protected-test only, pending owner approval.
- **Price guides** — all seven routes return `200` and appear in `page-sitemap.xml`. `LAUNCH-WEEK-REPORT.md` said gated to test pending a go decision.
- **Commercial product renderer** (`26f3b43`) — live on `/curtain-walling/` and `/commercial-windows-and-doors/`. `HANDOVER.md` said awaiting approval since 2026-07-07.

**How each happened.**

1. Price guides: commit `68f38ae` (2026-07-09, `Implement local SEO audit quick wins`) added `fensterglazing.com` and `www.fensterglazing.com` to `fenster_price_guides_enabled()`. The un-gating was bundled into an unrelated SEO commit and named in neither its message nor the docs. `68f38ae` is an ancestor of `13e7f95`, so the price guides went live as a silent passenger on the approved 2026-07-17 case-studies promotion.
2. Composite Doors V2: the route has no host gate at all — `generated-page.php:2911` renders it on `$is_composite_doors` alone. It went live the moment the theme moved past `13e7f95`.
3. Root cause for the composite release: the live deploy one-liner in `LIVECHANGES.md` ran `git reset --hard origin/main`, deploying whatever sat on `main` rather than the verified commit. Deploying the four small Legend iframe fixes (2026-07-17/18) therefore also shipped the fourteen composite commits queued in front of them.

**Owner decision (2026-07-20).** Leave Composite Doors V2 and the price guides live and continue work directly on production. No rollback, no re-gating.

**Documentation changes made.**

- `LIVECHANGES.md`: live deploy command now resets to an explicit SHA with a `git log --oneline <LIVE_SHA>..<SHA>` pre-check and an explanation of the incident; `wp sg purge` added to the live one-liner; live commit pointer corrected to `af4cfc2`; before-deploy checklist gained the commit-range check.
- `HANDOVER.md`: live-state pointer corrected, deploy trap documented, and composite/price-guide/commercial-renderer status corrected to live.
- `COMPOSITE-DOOR-REDESIGN.md`, `LAUNCH-WEEK-REPORT.md`: status corrected to live. The composite doc's claim that V2 suppresses the inspiration gallery and comparison table was stale — `0610753` and `46a961f` rebuilt both, and that is what production serves.
- `LIVECHAT.md`: Legend recorded as complete and live with nothing outstanding; the pre-release checklist reframed for future changes only.
- `AI.md`, `AUDIT.md`, `COPY-AUDIT.md`: the footer "Phone lines open 24/7" claim closed permanently as owner-confirmed accurate.

## 2026-07-17 - Case studies expansion live release (13e7f95)

- Promoted commit `13e7f95` to production (backup `fenster-pre-13e7f95-20260717-132541.tar.gz` taken first). Live is confirmed at `13e7f95`; the other agent's concurrent composite-doors commit (`68cfc9d`) is NOT on live.
- This release adds to the live case studies: install dates with automatic date-sorting, fitter panels that link to Meet the Team, a customer review, colour-hub deep links, an in-page lightbox, and two video-led roof lantern studies (landscape video = full-width hero plus a still; portrait video = square hero). The Northampton lantern + heritage doors study carries the customer's real interior photos and a Sheerline "Installation of the Month" award banner.
- Videos were encoded with a bundled ffmpeg (`pip install imageio-ffmpeg`) to ~6.8MB each; they autoplay muted, loop, and only play while in view.
- Cache note now documented: `wp cache flush` does not clear SiteGround's dynamic cache, so `wp sg purge` is part of the deploy flow, otherwise updates look missing behind the proxy cache. Verified live at all breakpoints: archive shows six studies newest-first, videos and the interior photo return `200`, both new studies are in `page-sitemap.xml`.

## 2026-07-17 - Composite Doors V2 studio redesign (test)

- Rebuilt the rejected first composite-door design as one coherent route on the continuous page gradient. The route now has an approved Distinction installer banner, one sold-range studio and one tabbed finish configurator rather than stacked collection cards, a comparison table, an inspiration gallery and three separate option sections.
- Corrected the range to what Fenster sells: Signature and Contemporary, with Rustic Renown presented accurately as a cottage-style Signature design. Removed `nxt-gen`, Grandeur and the blanket `Any RAL colour` claim from composite-door data and page copy.
- The range studio shows one large portrait-led door image and changes the description, best-use guidance and compact specifications when Signature, Contemporary or Rustic Renown is selected.
- Colour, glass and hardware now share one component. Colour has eight photographed examples plus `And more`; glass has compact selectors and visible Chatsworth and Wentworth assets; hardware has eight finishes and one fixed dark presentation stage. Only the selected image and supporting text are shown.
- Retained the 75 responsive WebP assets built from the visually reviewed Distinction scrape, switched the hero to an approved Signature entrance and kept every interactive preview at a fixed size so image changes cannot collapse the layout.
- Built the compiled CSS and JavaScript, linted the changed PHP and deployed theme revision `7aae3b0` to the protected test site only. QA passed at 390 × 844, 768 × 1024 and 1440 × 900 with no broken images or horizontal overflow. The configurator measures 842.9px, 804.5px and 814.6px at those viewports respectively. Rustic Renown, Chatsworth and Chrome interaction tests all updated the correct single preview. Production was not deployed.

## 2026-07-17 - Residential case studies live release

- Promoted the verified case studies work to production. Backed up the live theme first (`~/backups/fenster-theme/fenster-pre-9fba379-20260717-105524.tar.gz`, 320M), then theme-only rsync of commit `9fba379` to live and flushed WP + SiteGround dynamic cache.
- Live verification: `/case-studies/` archive and all four detail pages return `200`; the retired residential studies (`water-stratford`, `double-glazing-rushden`) return `410`; homepage, `/online-quote/`, `/casement-windows/`, a location page, `/commercial-projects/` and `/sitemap.xml` all `200`. Meet the Team carries the new fitter anchors and the colour hub has `data-colour-slug`.
- The plain `page-sitemap.xml` was served from the SiteGround proxy cache (`x-proxy-cache-info: DT:1`) without the new routes; a cache-busted fetch and then `wp sg purge` confirmed and served the fresh sitemap with all four new studies. Note for future sitemap changes: purge or cache-bust when verifying.
- Browser check of the live archive: four cards with dates, trimmed one-line intro, no horizontal overflow, no broken images.
- Updated docs to reflect that residential case studies are now live: `LIVECHANGES.md`, `HANDOVER.md`, `AUDIT.md`, the root `AI.md`/`HANDOVER.md` live-commit pointers, and `CASESTUDIES.md`.

## 2026-07-17 - Case studies: dates, fitters, deep links, lightbox, guide (test)

- Fixed the Broughton study: it was a single dormer window, not multiple. Title, copy and specs are now singular and the hero is the close-up of that one window.
- Every gallery and hero photo opens full screen in the existing in-page lightbox (no new tab).
- Colour links now deep-link the colour hub: they pre-select the swatch (`data-colour-slug`) and scroll to the right material. The scroll pauses Lenis on window load because the colour hero images otherwise keep the page pinned at the top.
- Added install dates (shown on the detail hero and archive cards) and a fitters/Installers panel per job, with links that scroll to each person's Meet the Team profile. Gave every team member an anchor id (`sanitize_title(name)`). People without a profile (Aaron) render as a name-only chip. Never lists marketing Zac Bartley; the fitter is Zac Rugman.
- Widened the archive intro to full width and reworded it around 1,000+ installations, explaining the page will grow over time.
- Scanned the retired residential studies: the Water Stratford cottage and Rushden bungalow have good written stories but no photos, so they cannot be republished in the image-led format without photography.
- Added `CASESTUDIES.md`: a complete guide to adding and maintaining case studies (photo prep, data schema, copy rules, product/colour deep links, fitters, reviews, routing, deploy checklist) so future work is one-pass.

## 2026-07-17 - Case study detail: hero image, spec strip, masonry gallery, installers + review (test)

- Owner feedback on the text-led version: hero was too text-heavy with no image, the specification sat too low, and the gallery cropped photos with small captions.
- Detail hero is now a two-column layout with a lead image, and the key specification is a scannable four-item strip directly under the hero (was a low sidebar).
- Gallery rebuilt as an uncropped masonry: every photo shows whole at its natural aspect ratio, and the portrait/landscape mix becomes the layout, in the spirit of the roof lanterns page. No `object-fit` crop on gallery images.
- Added per-project people: an Installers panel (Tom Carter and Johnnie Greenwell) with their Meet the Team photos linking to `/meet-the-team/`, and a customer review (Conor and Laura) with the installers' names hyperlinked. Attached to the Whitehouse aluminium bifold project because the review is about the doors and kitchen. Both are optional data fields, so other studies render without them.
- Verified on test at 1440x900 and 390x844: section order hero, spec strip, body, gallery, more, CTA; no horizontal overflow; masonry shows whole photos; review and installer links resolve; studies without review/installers render cleanly; no console errors.

## 2026-07-17 - Residential case studies redesigned, clean text-led (test)

- Owner rejected the first version for looking too much like the commercial project pages. Rebuilt the detail and archive templates from scratch in their own `fg-cs-*` namespace, copying nothing from the commercial `fg-case-*` styling.
- New detail layout is descriptive and text-led with no hero imagery: a short lead, a written overview, a sticky specification panel (product, system, colour, U-value/rating) with product/colour/instant-quote links, a "what we fitted" list, and a captioned image gallery where every photo is described (expanded from the owner's filename notes). Sits on the continuous page gradient with clean white panels.
- Expanded the bare project notes into accurate copy by scanning the real product pages: casement `/casement-windows/` (Liniar EnergyPlus 70mm, 0.95 W/m²K, A+, PAS 24), flush `/flush-casement-windows/` (Liniar 70mm flush sash, 1.2 W/m²K, A+), aluminium bifolds `/aluminium-bifold-doors/` (Sheerline Prestige, 1.0 W/m²K, up to 7 panes) and slide/fold `/slide-fold-doors/` (10-point locking, independent panels).
- Archive is a clean two-up card grid. Verified on test at 1440x900 and 390x844: no horizontal overflow, H1 within the ceiling, correct product/colour/quote links, captioned gallery, no broken images, no console errors, grids stack on mobile.

## 2026-07-17 - Residential case studies rebuilt (test, superseded same day)

- Rebuilt `/case-studies/` as a curated, expandable system driven by a new `inc/case-studies-data.php` (`fenster_case_studies()`). Adding an entry there publishes a new archive card and detail page, wires its own routing, SEO, images, product/colour links and related-project cards. Designed to scale to 100+ studies from one data file.
- Added the first four real projects with owner-supplied photography (optimised into `assets/images/case-studies/`): anthracite grey Sheerline aluminium bifolds (Whitehouse, MK), two-tone basalt grey Liniar casements over a boarded-up opening (Broughton, MK), flush casements plus a uPVC slide and fold door (Leighton Buzzard) and white Liniar casements (Leighton Buzzard).
- Each detail page links the products used (e.g. `/aluminium-bifold-doors/`, `/casement-windows/`, `/flush-casement-windows/`, `/slide-fold-doors/`) and the colour (`/colour-options/`), states that the customer priced with the `/online-quote/` instant quote tool, and ends with product plus quote CTAs. Copy is direct we/you voice with no em dashes, per `STYLE.md`, reusing the existing `fg-case-*` styling with residential chip/quote additions.
- Routing: removed the `/case-studies/` 410 and added synthetic archive/detail pages in `fenster_get_generated_page()`; kept `/commercial-projects/` and the commercial detail pages on their existing `pages.json` source by reading the raw index directly. The two retired residential studies (`double-glazing-rushden`, `water-stratford`) stay 410 and no longer appear anywhere.
- Sitewide CTAs: added a footer `Case Studies` link and a homepage proof-wall link.
- Deployed the exact commit to the protected test site only (not live). Server checks: `/case-studies/`, all four detail routes and `/commercial-projects/` return `200`; retired residential routes still `410`; new routes present in `page-sitemap.xml`. Browser DOM QA at 1440x900 and 390x844 confirmed no horizontal overflow, H1 within the `3.6rem` ceiling, correct product/colour/quote links, all images loading and grids stacking on mobile. (Full-page screenshots timed out in the test browser; verification was DOM/text based.)

## 2026-07-16 - Legend follow-up production reconciliation

- Audited the current repository against both SiteGround themes after the owner noticed the header redesign was already live. The live checksum dry run showed all current theme work was already present except `inc/legend-assistant.php`; test matched the repository fully.
- Identified the only unlive code as the reliable hyperlink safeguards from `f01b925` and `d9b9ffc`. Created rollback archive `/home/u453-m73mh4m4wev2/backups/fenster-theme/fenster-before-legend-links-20260716-160023.tar.gz`, deployed the verified source at `cd5b430` and flushed production cache.
- Post-release checksum comparison was empty. Homepage, Meet the Team, windows hub and quote tool returned `200`. Live endpoint checks confirmed `who is zac` returns the verified Marketing Executive answer and the premium-window question links `[aluminium windows](/aluminium-windows/)`.

## 2026-07-16 - Reliable Legend recommendation links

- Fixed product recommendations appearing as bold text without a hyperlink. Link support had not been removed, but model-selected formatting was optional and therefore inconsistent.
- Added server-side link normalisation that converts full test/live Fenster URLs into portable relative routes and automatically links a known product when the model supplies no useful route.
- Prioritised the first bold known product as the single recommendation link, removing a later less-relevant model-selected route when necessary. Endpoint regression for the owner's premium-window question returned `[aluminium windows](/aluminium-windows/)`.

## 2026-07-16 - Website Tracker operating guide

- Added the Marketing Dashboard repository's `WEBSITE-TRACKER.md` as the single operating guide for the consented Website Tracker. It explains FGV/FG2 and WindowCAD Tracking joins, consent and retention, every metric/funnel stage, visitor timelines, Legend QA transcripts, UTM attribution, limits of phone-click data and a troubleshooting checklist.
- Linked the guide from the dashboard README and the theme handover/deployment rules so future work does not treat the dashboard as a CRM or mistake intent metrics for confirmed business outcomes.

## 2026-07-16 - Sliding sash redesign live release

- Completed the final release audit for the rebuilt `/sliding-sash-windows/` journey and promoted the exact protected-test theme commit `8533d4e` to production after owner approval.
- Release checks passed: clean repository and GitHub parity, full CSS/JS build, all 53 theme PHP files linted, test/repository CSS and generated-template checksums matched, and 390 × 844, 768 × 1024 and 1440 × 900 browser QA showed no horizontal overflow.
- Reverified the mobile model carousel, three-product desktop layout, six-image gallery, corrected Roseview specifications, privacy-glass-only choice panel, fixed-height furniture selector, all eagerly loaded furniture finishes, sash-specific review ordering, responsive quote behaviour, footer trust grid and Instagram/Facebook/LinkedIn links.
- Created the fresh rollback archive `/home/u453-m73mh4m4wev2/backups/fenster-theme/fenster-pre-8533d4e-20260716-141859.tar.gz` before the theme-only production rsync.
- Production cache was flushed and live theme CSS/template checksums matched the reviewed repository. The homepage, sash page, online quote, consultation, contact and about routes all returned `200`; critical sash images and compiled assets also returned `200`.
- Post-release browser checks passed on live at all three breakpoints. The sash controls worked, all furniture images were loaded before interaction, the hardware stage stayed fixed, responsive hero sources were selected correctly, and homepage/online-quote smoke tests produced no browser errors.

## 2026-07-16 - Legend drawer header redesign

- Removed the abrupt dark-to-pale header split and replaced it with a continuous deep-teal gradient, soft mint floor glow and restrained lower stage line.
- Restyled the close control for the unified dark surface and retained clear identity copy contrast.
- Preserved dedicated animation geometry: a `224px` desktop stage and `190px` mobile stage accommodate Legend's standing, left/right movement and curled sleeping frames. Protected-site visual QA confirmed desktop standing contrast, mobile sleep containment and zero horizontal overflow.

## 2026-07-16 - Reliable current-page team answers

- Fixed Legend failing to identify Zac Bartley while the visitor was already on Meet the Team. The profile existed in rendered HTML but was buried in the general page snapshot, while the related-page source index did not contain the runtime replacement accurately.
- Promoted every visible team profile into high-priority assistant context and added a backend query-matched excerpt around meaningful words from each question. The prompt now explicitly requires a direct answer when a named staff profile is supplied.
- Protected-site regression confirmed `who is zac bartley` returns Marketing Executive and the published remit, while `what does Zac do at Fenster?` returns the same role details directly.
- A subsequent real-chat failure showed the model could still ignore the supplied profile. Added a deterministic pre-model answer for common Zac identity and role wording, including the exact short message `who is zac`. This was later promoted and verified on production in the reconciliation release above.

## 2026-07-16 - Legend chat continuity and scrolling polish

- Hid the full `By using this live chat` disclosure after the visitor's first sent message while retaining the compact accuracy, non-binding, QA-retention, sensitive-data and Privacy Policy notice.
- Persisted the drawer's open or closed state so same-site hyperlinks keep an active chat open on the destination page. Restored chats skip the entrance animation and do not steal keyboard focus.
- Excluded the drawer from Lenis page smoothing and added contained native wheel/touch transcript scrolling, stable scrollbar space and touch momentum. Wheel and touch reading also reset Legend's inactivity timer.
- Made every normal open and restored open scroll to the newest message after layout. A protected-site mobile test used an overflowing transcript and confirmed chat-only wheel movement, a stationary background page, open-state navigation, hidden disclosure and reopen-to-bottom behaviour.

## 2026-07-16 - Friendlier Legend personality

- Expanded Legend's permitted conversation to include greetings, thanks, goodbyes, meows, purrs, harmless cat jokes and questions about Legend without forcing each reply back to windows, doors or a sales action.
- Made the assistant warmer, cuter and more naturally in character while retaining concise British English, factual accuracy and the boundary against substantive unrelated tasks.
- Added the owner-confirmed relationship that Legend's dad is Nick Baker, Fenster's Sales Director, to both the assistant instructions and authoritative business context. Legend is told not to invent any other biographical details.

## 2026-07-16 - Legend close delay, iOS prompt and footer cookie control

- Changed drawer-close behaviour so Legend returns to idle and waits 10 seconds before curling up; the normal inactivity timeout remains 20 seconds.
- Hardened the scroll-triggered speech bubble for iOS by checking all relevant scroll roots and listening to document, touch and visual-viewport movement. The prompt can now appear while Legend is asleep.
- Removed the persistent viewport Cookie settings button and kept the reopening control in the footer. Limited pointer events to the visible Legend launcher and speech bubble so the transparent positioning wrapper cannot cover cookie or footer controls.
- Built and PHP-linted the theme, isolated the release from unrelated sliding-sash work and deployed it to the protected test site for responsive verification. This was later promoted and verified on production in the reconciliation release above.

## 2026-07-16 - Legend Sleep And Scroll Prompt Live

- Used the approved hatch-pet Legend identity and contact sheet to generate a coherent eight-frame standing-to-curled sleeping animation. The first generation was rejected because two tails touched and produced clipped extraction fragments; the complete row was regenerated with separated poses, then passed deterministic frame inspection and visual contact-sheet review.
- Added the transparent `legend-sleep-strip.webp` as a website-only animation asset. It is deliberately separate from the validated Codex v2 atlas and alternates its final two frames as a quiet breathing loop.
- Added a 20-second Legend-specific inactivity timer in both launcher and open-chat states. Pointer, focus and typing activity wakes him; clicking him reverses the sleep sequence before reopening chat. Clicking the drawer X returns him to the launcher and immediately curls him up.
- Rebuilt the launcher prompt as valid sibling controls instead of nesting an independent X over the old launcher button. The bubble starts invisible, appears after 240px of scroll, opens chat from its copy area and contains its own session-dismiss close button.
- Built, PHP-linted, committed and deployed the work to the protected test site. Desktop QA verified the complete `0` through `7` close-triggered progression, the 20-second trigger at 20.5 seconds, breathing state, wake-to-open path, integrated close geometry and scroll reveal. A true `390 x 844` pass verified the prompt layout and no horizontal overflow. No new console errors were introduced.
- After explicit owner approval, backed up the live theme and promoted commit `400cf10` to production using theme-only rsync. Live checks returned 200 for the homepage, quote tool, casement product, Bletchley location page and About page; every page rendered Legend and the sleep asset. The production AI connection was configured, the scroll prompt rendered correctly and browser QA found no console errors.

## 2026-07-16 - Sliding Sash Desktop Journey Aligned With Mobile

- Carried the approved concise, image-led mobile journey onto desktop without stretching the phone carousel across a wide screen. Desktop retains the useful side-by-side view of all three Roseview models and the full shared comparison table.
- Rebuilt the desktop model cards around much larger, fully contained product renders. Removed the repeated paragraph and per-card specification grids; each card now carries only its model position, name and concise `Best for` guidance, while the table states each technical difference once.
- Promoted the six-image `Real homes` gallery to desktop as an editorial collage: one dominant wisteria installation, two supporting room/elevation images and three compact detail views. Desktop gets dedicated explanatory copy, hover treatment and the existing accessible lightbox; mobile retains its swipe rail and mobile-specific instruction.
- Applied the same content consolidation at desktop widths by removing the repeated sash detail run, generic product-information blocks, order-process repetition and related-link filler. The remaining journey moves from hero/specification summary to model choice, real installations, finish choices, furniture, FAQs and enquiry.
- The rendered desktop page at `1440 x 900` reduced from roughly `11,591px` to `7,278px`; the three-card comparison is about `604px` and the desktop gallery about `910px`. Mobile remains about `7,648px` at `390 x 844` and tablet about `7,251px` at `768 x 1024`.
- Rebuilt compiled CSS, PHP-linted the generated template, pushed through commit `d851e0f`, deployed that exact theme commit to the password-protected test site and flushed its cache. Browser QA passed at `390 x 844`, `768 x 1024`, `1024 x 768` and `1440 x 900`: no horizontal overflow, correct breakpoint-specific gallery copy, desktop/mobile gallery layouts intact, lightbox opens and closes, and no console errors. Nothing was deployed live.

## 2026-07-16 - Sliding Sash Mobile Installation Gallery

- Visually reviewed all `1,064` raster files in the supplied Roseview scrape using labelled contact sheets, then opened the strongest candidates at full resolution. Rejected duplicates, logos, staff/trade graphics, technical diagrams, unfinished-site photography and images that did not clearly support the sash product.
- Added six approved, locally hosted Roseview images: a wisteria-framed sash, finished dining and bay-room interiors, a full Surrey elevation, an arched exterior sash and arched interior detailing. Converted the chosen sources to responsive WebP assets so the production theme has no runtime dependency on the external scrape.
- Added a mobile-only `Real homes` gallery immediately after the Roseview model selector. It is a compact dark swipe rail with a clean next-card peek, concise captions and the existing tap-to-enlarge lightbox; desktop remains unchanged.
- Enlarged the Ultimate, Heritage and Charisma model media areas while retaining the one-card mobile decision flow. The final product artwork uses a fixed responsive object-fit box so the full portrait window is visible instead of being cropped.
- Rebuilt compiled CSS, PHP-linted `generated-page.php`, checked the diff, pushed commits through `880a3f8`, deployed that exact theme commit to the password-protected test site and flushed its cache. The new gallery asset and route both return `200` on test.
- Browser QA passed at `390 x 844`, `768 x 1024` and `1440 x 900`: the phone carousel is about `759px` tall, the six-image gallery is about `472px`, carousel controls update both the name/count and selected specifications, the lightbox opens/closes, mobile/tablet have no horizontal overflow, desktop keeps its three-card comparison/full detail run, and no console errors were recorded. The phone page is about `7,639px` tall after adding the image-led gallery. Nothing was deployed live.

## 2026-07-16 - Sliding Sash Mobile Comparison Redesign

- Preserved the approved desktop Sliding Sash Windows page while rebuilding the Roseview comparison specifically for `860px` and below.
- Replaced the three long stacked Ultimate, Heritage and Charisma cards with a one-card swipe carousel using previous/next controls, a visible model name/count and position indicators.
- Removed the repetitive mobile comparison-table stack. Mobile now shows one compact specification panel for the selected carousel model, updating meeting rail, corner detail, frame depth, glass unit, energy rating and ThermoVFlex information as the customer changes model.
- Kept the full three-card layout and four-column specification table unchanged on desktop.
- Rebuilt the compiled CSS and JavaScript, PHP-linted the generated product template and checked the diff for whitespace errors.
- Committed and pushed the change as `4ff4eb8`, deployed that exact commit to the password-protected test site and flushed its cache. Browser QA at `390 x 844`, `768 x 1024` and `1440 x 900` confirmed working model controls and selected-spec updates, no horizontal overflow, no console errors and no desktop layout regression.
- Reassessed the full phone journey after the first carousel pass remained too long. The rendered mobile page was roughly `18,600px` high because the model decision was repeated through the detail run, generic Product information, More information checks, furniture catalogue, order process and related-link band.
- The whole-page mobile pass removes those repeated detail/product/process/link sections below `860px`, compresses the selector to one viewport-sized decision component, and turns colour/glass and furniture into short horizontal rails. The complete desktop page remains unchanged.
- Final test measurements: about `7,200px` total at `390 x 844` and `6,800px` at `768 x 1024`; the phone carousel itself is about `693px` including its active card, controls, dots and selected-model specification grid. No horizontal overflow or console errors were found, and the desktop comparison cards, table and supporting sections still render normally.

## 2026-07-16 - Week Two: Shared Copy Rewrite And Full Image Audit

- Rewrote the shared customer-facing template copy in `generated-page.php`, `quote-tool.php`, `windows-hub.php`, `home-experience.php`, `about.php`, `contact.php`, `price-guide.php`, `consultation-booking.php` and `enquiry-form.php` from third-person "Fenster does X" into direct we/you voice, reading each string in context rather than find-and-replace. Brand-named copy was deliberately kept where it earns its place: `/why-trust-fenster/`, About-page process labels, the accreditation trust strip, commercial county intros and "the Fenster quote tool".
- Removed the self-describing product gallery bullets ("Every image is chosen to show this product family clearly") and replaced them with an action prompt; replaced the "Move from the product into the details that make it yours" and "Choose the handle finish with the door, not after it" headings with customer-truth headings; fixed the clunky "{Product} styles, details and installed examples" grammar with a colon form.
- Completed the full image audit: all 98 unique images referenced by `product_media` and `product_gallery_pools` in `inc\site-data.php` were opened and classified. Removals: duplicate sash photo (`Sliding-Sash-Windows-Flitwick-9` = curated hero), two US stock interiors from the aluminium windows pool, three same-scene CGI courtyard renders and a duplicate CGI kitchen across the door/bifold pools, the wrong-product `steel-look-patio-hero` render from the sliding pool, a garden photo posing as a casement window, and a French casement window from the French doors pool.
- Promotions and moves: real installs replaced CGI as the bifold hero (`sheerline-bifold-exterior`) and casement hero (`Casement-Windows-Flitwick-10`); the Liniar `7016_grey_patio` photo moved to the uPVC patio pool; two previously unused genuine bifold assets (`Aluminium-Bifold-Doors-Flitwick-6`, `Bifold-Espag-Handle-v1`) were added so the bifold gallery keeps its four-image minimum.
- Rewrote every dishonest alt text: no image claims a material, product or town it does not show (previous alts claimed renders were "installed in Northampton/Letchworth/Milton Keynes" and called the double-glazed unit sample "secondary glazing").
- Added `PHOTO-CHECKLIST.md`: a five-shot per-job photo routine for fitters plus the wishlist of gaps that only real job photography can fill (uPVC door installs, aluminium windows on a local home, secondary glazing, town-spread sash installs).

## 2026-07-16 - Content/Imagery Audit And Week One Quick Fixes

- Completed a full content, imagery, design and SEO audit of the live site (12 pages crawled at desktop and mobile widths with rendered-text extraction and layout metrics) and recorded the prioritised plan in `ACTION-PLAN.md`.
- Made the Products mega-menu CTA badges data-driven through a new `badge` field on the nav CTAs in `inc\site-data.php`, rendered in `inc\template-tags.php` and styled as `.site-nav__mega-cta-badge`. The previously swapped CSS `content` labels are gone: `Get an instant quote` now reads `Quick start` and `Book a consultation` reads `Explore`.
- Fixed the shared product template's hardcoded "three quick guides" claim (door pages only render two specification-choice cards) and stopped `strtolower($title)` breaking product casing in gallery copy ("upvc doors" now renders as "uPVC Doors").
- Curated the `upvc_doors` image pool and `product_media` gallery: removed the cat-flap photo, a CGI render, a painted timber cottage door, a timber colour collage and a duplicated hero image; added two genuine Liniar uPVC door renders from the reserved `assets\images\products\colours\liniar-door` set; rewrote every alt text so no image claims a material it does not show.
- Resolved the sliding sash energy-rating contradiction: the USP strip said `A+ rated` while the on-page comparison table said `A rated`; both now state `A rated`, matching Roseview's published standard rating, and the matching benefit card copy was updated.
- Rewrote the four sash furniture descriptions that exposed supplier-research phrasing ("described by Roseview as", "Roseview lists", "Roseview states", "The Roseview options page also lists") into direct customer-facing statements with the same facts.
- Normalised review card dates at component level in `template-parts\components\review-showcase.php` (`strtotime` + `date_i18n('j M Y')`), so ISO Google dates and human Trustpilot dates render in one format.
- Added `upvc-doors` and `casement-windows` to `fenster_gsc_seo_overrides()` with rewritten titles and meta descriptions, replacing the imported scrape-era metadata ("View our uPVC doors...", "Learn about our casement windows...").
- Retracted one audit finding: the Legend launcher does not overlap hero content; it is fixed to the bottom-right corner and the apparent overlap was a full-page screenshot artifact.
- Rebuilt CSS/JS and PHP-linted all changed files. The footer "Phone lines open 24/7" claim still needs an owner decision before it is changed.

## 2026-07-15 - Legend Chat Quality Assurance Tracking To Test

- Extended the consented Website Tracker with Legend chat opened, acknowledgement, message-sent and reply-received events.
- Added a restricted transcript store in the separate Marketing Dashboard, linked to the existing anonymous `FGV-...` visitor and `FG2-...` journey only where optional cookies were accepted. The tracker has a Legend chats view and visitor journeys link to their saved conversations.
- Set transcript retention to 30 days. Legend still works after rejected optional cookies; its QA transcript is chat-only in that case, with no chat tracking event or `FGV`/`FG2` journey link.
- Updated the pre-chat acknowledgement, persistent chat notice, generated Privacy Policy and `LIVECHAT.md` so visitors are told before chatting that accepted-consent transcripts may be retained for quality assurance for up to 30 days. This remains test-only until Legend itself receives explicit live approval.
- Legend replies now support one safe, same-site route link in `[label](/route/)` form, alongside bold text, so a useful next step such as `/book-a-consultation/` is directly tappable. The browser creates the link only after validating it remains on Fenster; no raw HTML or external links are rendered.

## 2026-07-15 - Legend AI Chat Preview On Test

- Added Legend, Fenster's black office cat mascot, as a site-wide floating AI assistant above the cookie controls. The launcher uses the approved animated Legend sprite and responds with a wave when opened.
- Reworked the closed launcher after owner review: Legend now appears larger and on his own without a pill, portrait circle or other enclosing box. A compact speech bubble pops out beside him with `Need a hand?` and clearly identifies him as Fenster's AI assistant, then withdraws when the chat opens.
- Replaced the duplicate launcher/header characters with a single-character handoff. On open, the clicked Legend uses the verified row-4 five-frame jumping animation at slower timing and follows a curved path into the header stage; only after he lands does the header roaming state appear. Closing reverses the handoff back to the launcher, with an instant accessible fallback for reduced-motion visitors.
- Removed the remaining header wave-on-arrival and hidden thinking/wave code paths after owner review caught two stray raised-paw frames. The assistant now references only atlas rows 0, 1, 2 and 4: idle, running right, running left and jumping.
- Reworked the chat header after owner review into a full-width animated character stage. Legend now moves between both sides with deliberate pauses, the idle sprite cycle runs at a calmer pace, and the chat panel is taller on desktop and mobile.
- Corrected the stage after rendered review showed the idle animation sliding across a dark background. Legend is now about 45% larger on a pale green contrast area, uses the running sprite row only while crossing, and returns to the slower idle row whenever he stops.
- Corrected the travel-row mapping after the first motion fix used row 7, which is the Codex processing/thinking state rather than directional locomotion. The header now uses all eight frames from row 1 while moving right and row 2 while moving left, with row 0 between crossings. Timed browser verification confirmed positive movement on row 1, negative movement on row 2 and no console errors.
- Identified Legend in the welcome copy as Fenster's real office cat and Chief Meow Officer. Added a `Who is Legend?` button that links directly to his newly anchored card on `/meet-the-team/#legend`.
- Built a responsive, keyboard-accessible chat panel with a live message log, safe text-only message rendering, auto-growing composer, Enter-to-send, Shift+Enter for a new line, Escape-to-close, typing feedback and reduced-motion support.
- Replaced the browser-only placeholder with a secure WordPress REST integration at `/wp-json/fenster/v1/legend/chat`, backed by OpenAI's Responses API. The API key remains server-side in Bedrock `.env`; it is never rendered into the page or committed to the theme.
- Added Fenster-specific assistant instructions covering Legend's identity, British-English tone, concise answers, current capabilities, honest uncertainty, privacy, safety boundaries and clear AI disclosure. Page content is explicitly treated as reference material rather than executable instructions.
- Tightened live reply behaviour after real conversation testing showed long, sales-heavy paragraphs and em dashes. Ordinary answers now default to one short paragraph, one or two sentences and roughly 45 words; lists are limited to three bullets when genuinely useful, the output budget is lower, and em dashes are also removed server-side as a final safeguard.
- Added safe inline bold rendering for Legend replies. Only `**bold**` is recognised, using DOM-created `strong` and text nodes, so the assistant can create scan-friendly emphasis without enabling model-supplied HTML, links or scripts.
- Added bounded cross-page retrieval for factual questions. The server searches other published Fenster theme and WordPress pages, excludes the current route, ranks matches with title/description/content weighting and common warranty spelling normalisation, then supplies up to four short excerpts as untrusted reference material. Legend can now consult relevant Fenster pages before falling back to uncertainty, without browsing the open web.
- Live browser QA on `/about/` confirmed that forced bold output rendered as a real `strong` node and a misspelled warranty-transfer question retrieved the Terms and Conditions guarantee wording. The prompt now requires Legend to name a useful related page and prevents the misleading phrase `from this page alone` after cross-page retrieval has been used.
- Restricted Legend to Fenster Glazing and directly related customer questions after testing showed he would answer general programming questions and repeat visitor profanity. Unrelated requests now receive one short Fenster redirect, mixed requests answer only the Fenster portion, and common profanity is redacted server-side from both conversation input and model output so recall prompts cannot make Legend quote it back.
- The browser supplies a bounded current-page snapshot containing the title, meta description, navigation, main content and footer, plus the last eight in-panel messages. The server sanitises and caps every field, rebuilds the URL as a same-site path, uses `store: false`, and does not log prompts or responses.
- Added REST nonce and same-origin checks, anonymous HMAC-based rate limiting, message/history limits, plain-text rendering and safe customer-facing failure states. When no key is configured, the assistant clearly reports that its AI connection has not yet been switched on.
- Rechecked the test server after the chat appeared offline: the key remained configured and a direct `gpt-5.4-mini` request returned 200. The apparent outage was the frontend using its generic connection copy for a rate-limit response after repeated QA. Raised the anonymous allowance from 20 to 40 messages per ten minutes and added an explicit rate-limit message that confirms the AI connection is still online.
- Kept the component independent from enquiry forms, consent decisions and tracking. It observes the existing cookie controls only for layout, moving above both the compact Cookies button and the full choices banner without changing consent behaviour.
- Added an explicit `Before you chat` acknowledgement that keeps the composer unavailable until the visitor chooses `Continue to chat`. The disclosure explains that relevant page content and messages are processed by AI, warns that replies may be inaccurate and do not create quotations, contracts, warranties, professional advice or legally binding commitments, cautions against sensitive data and links to the expanded Privacy Policy. It never changes a rejected or accepted optional-cookie preference; the later continuity update below documents how the acknowledgement and recent history now follow the visitor across Fenster pages and tabs.
- Replaced the floating chat window with a right-edge drawer that slides in and covers the viewport from top to bottom. The compact Cookies control moves left of the open desktop drawer and is temporarily hidden behind the full-width mobile drawer, then returns when chat closes. Added a soft white halo behind the closed Legend sprite so his black fur and uniform remain clear over dark page sections.
- Corrected Legend's drawer-entry jump after the first drawer build measured his landing point while the panel was still translated off-screen. The handoff now targets the drawer's settled position and uses a four-stage lift, apex, descent and landing curve, preventing the rightward fly-off and teleport.
- Added disclosed 24-hour chat continuity across Fenster pages and browser tabs using `fenster_legend_chat_v1`, capped at 16 recent messages with a visible Clear chat control. The storage begins only after Continue to chat and remains separate from `fenster_cookie_consent`. Promoted visible technical/specification panels and canonical `product_usps` records into high-priority assistant context, including cross-page search, so published values such as the flush uPVC window `1.2 W/m²K` U-value are no longer overlooked.
- Ran a broad live question audit against the protected test assistant. The discovery set exposed wrong or incomplete answers for single-attribute product questions, guarantee scope, triple glazing, service areas, FENSA/CPA details and plural product names. The owner then confirmed the canonical business rules used to settle every conflict.
- Added an authoritative owner-confirmed fact layer and query-matched canonical product facts that outrank old imported FAQs and articles. It records the new-window-and-door-only 10-year CPA-backed guarantee, non-transferability, triple-glazing availability and exceptions, residential versus commercial coverage, FENSA handling, starred U-value meaning, Distinction security guarantee, integral-blind controls and instant-quote pricing boundary.
- Aligned the test CPA, FENSA and Terms wording with the confirmed 10-year insurance-backed guarantee on every new Fenster window and door installation, while retaining CPA's correct role as the back-up if Fenster permanently ceases trading.
- Completed 39 post-fix live REST regression calls. A product-card sweep found a systemic singular/plural alias bug; after fixing it, aluminium flush windows returned A+ and 80mm, heritage windows returned 1.1 W/m²K and A+, and uPVC doors returned 14 colours and multi-point locking. The final boundary check still refused an unrelated JavaScript request.
- Rebuilt the theme, PHP-linted the changed integration and page templates, deployed commit `44597e0` to the protected test site, flushed caches and verified live model responses. Production was not deployed.

## 2026-07-15 - FENSA Page Redesign And Fallback Template Audit

- Replaced the scrape-derived `/glass-and-glazing-federation-ggf-standards/` article with a dedicated customer guidance page. It uses the approved FENSA/CPA visual structure and explains GGF guidance without wrongly implying it is FENSA certification, a product guarantee or a claim of GGF membership.
- Added the indexable `/consumer-protection-association/` route using the FENSA page's approved image-led template. It explains the distinct role of a CPA Insurance Backed Guarantee, links to CPA consumer guidance and makes clear that the individual certificate and policy wording define the cover and duration. CPA logos now link to this route.
- Rewrote the CPA page in direct homeowner language after review: Fenster remains the first point of contact and responsible for its written guarantee; CPA-backed insurance is the safety net if Fenster permanently ceases trading. The page now plainly separates what CPA is, what Fenster does and how the customer benefits.
- Linked every theme-rendered FENSA logo to `/fensa-approved-installers/`, including the footer, homepage proof areas, generated product/location hero proof, consultation reassurance, Why Trust Fenster and the FENSA page itself.
- Updated the approved FENSA page copy from the business owner: Fenster applies for the certificate, FENSA sends it directly to the customer, the certificate avoids a separate Building Control sign-off for eligible work, certification matters during a property sale, and eligible registration includes a CPA-supplied Insurance Backed Guarantee that typically lasts 10 years.
- Rebuilt the FENSA page again after owner review showed the first refinement still did not match `STYLE.md`. The page now speaks as the approved installer, says clearly that eligible work will receive a certificate, and removes the third-party `ask before you appoint an installer` wording.
- Replaced the line-heavy hero proof strip, certificate box, dark covered/excluded band and numbered process rail with the calmer `/why-trust-fenster/` composition: one accreditation assurance panel, two alternating image-led explanations and the existing enquiry section.
- Reworked the first FENSA layout after whole-page review against `STYLE.md`. Removed repeated hero reassurance, changed the hero from showroom photography to a relevant finished installation, replaced the second image with one focused certificate question, converted the dark coverage cards into a quieter divided comparison and corrected the desktop compact form to a two-column layout so the final section stays within a sensible viewport rhythm.
- Updated `AI.md`, `HANDOVER.md` and `LIVECHANGES.md` to make test-first deployment mandatory for every completed change. Small and low-risk changes no longer have a documented direct-to-live exception.
- Replaced `/fensa-approved-installers/` generic imported-article output with a dedicated homeowner conversion page in `template-parts/sections/fensa-approved.php`.
- Removed the route's scrape debris from public output, including `ONLINE DESIGNER`, isolated linked words, social-media filler, old footer/service-area copy and generic quote-engine sections.
- Rewrote the page around current FENSA homeowner guidance: what the certificate proves, which replacement work is normally within the scheme, common exclusions, the Fenster survey-to-registration process and one shared enquiry form.
- Added route-owned SEO title and meta description so malformed imported Open Graph/schema values remain irrelevant to the rendered page.
- Reused local showroom, installation and FENSA assets, added responsive page-specific SCSS, rebuilt compiled CSS and PHP-linted the new template plus routing/SEO changes.
- Audited the generic renderer fallbacks. The thin/noindex shells remain `gallery`, `brochures`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `fenster-partners` and `apecs-terms-conditions`; they should be rebuilt only when there is real content or a working customer function. `/glass-and-glazing-federation-ggf-standards/` is the next indexable compliance page that would benefit from a dedicated treatment. `/our-new-website/` and the retired/template case-study records should be reviewed for redirect or removal rather than automatically redesigned.

## 2026-07-15 - Site-Wide Typography Ceiling And First-Pass Design Contract

- Added `--fg-font-size-max: 3.6rem` as the shared site-wide display-type ceiling and replaced every existing font-size clamp above that value with the token. No source heading or display declaration now exceeds `57.6px`.
- Expanded `STYLE.md` with hard first-pass rules for viewport-contained desktop sections, dark text on light backgrounds, continuous gradients, deliberate image compositions, sustained product imagery, direct `we` and `you` copy, no em dashes, plain action-led CTAs, supplier-source rewriting and rendered-page QA.
- Rebuilt the complete theme CSS and confirmed the source contains no remaining font-size maximum above `3.6rem`.

## 2026-07-14 - Roof Lanterns Dedicated Page Redesign

- Replaced the generic generated-product journey on `/roof-lanterns/` with a dedicated roof-lantern conversion page in `template-parts\sections\roof-lanterns.php`.
- Set the page around one clear customer task: compare the suitable roof lantern specification and request a quote. The new order is an installed-lantern hero and enquiry action, concise S1 specification summary, room-planning guidance, thermal/detail explanation, security, ventilation, then the shared enquiry form and real review proof.
- Used the supplied Sheerline S1 scrape as the product-information and image reference. Added four local, deployable S1 assets for thermal, corner, security and SheerVent details under `assets\images\products\roof-lanterns`; the runtime page does not depend on the scrape export.
- Removed the generic product gallery, broad specification hub, generic choice cards, templated process rail and related-link band from this route only. The shared enquiry component remains the only live form.
- Rebuilt CSS, PHP-linted the dedicated template and router, and browser-checked the redesigned route at `1440 x 900`, `768 x 1024` and `390 x 844` with no horizontal overflow.
- V2 visual review caught a contrast regression in the new page SCSS: undefined `--fg-*` colour variables had made the intended dark S1 technical panel and enquiry frame render transparent over the page gradient. The final V2 direction removes that dark/white-text treatment entirely: all roof-lantern page copy now uses the theme's dark ink/muted text on the continuous light canvas, with white reserved only for existing button/review controls. Reworked the hero around a correctly proportioned vertical kitchen image and added a three-image inside/outside/installed roof-lantern sequence using further local copies from the supplied Sheerline source. Rechecked the full desktop and mobile composition, image crops, loaded images and page-level overflow.
- The final art-direction pass combined the repetitive security and ventilation bands into one two-card specification decision, reduced the overall page length, and corrected inherited dark-form styles that had left labels and field borders nearly invisible on the white enquiry panel. The enquiry form now has explicit light-context colours and a stable full-width mobile submit button. Rebuilt the theme and rechecked the route at desktop, tablet and mobile widths with no failed images or horizontal overflow.
- Committed and pushed the V2 pass as `0ad9d13`, deployed that exact commit to the password-protected test site with a theme-only rsync and cache flush, and verified the route, V2 content, new imagery and hero image response on test.
- The V3 composition correction restores the page-long gradient as the visible continuous canvas, removes the two full-width white washes, enforces the STYLE.md typography caps (`3.6rem` H1, `2rem` supporting H2s), and replaces the unequal portrait/landscape collage with three equal, labelled Sheerline landscape views. Desktop sections now fit within the usable viewport at the supplied `1467 x 709` review size; all sections also fit at `768 x 1024`, while the `390 x 844` hero fits and the image sequence becomes an intentional swipe rail. The shared mobile form remains one column for usability.
- Audited the page copy against the supplied Sheerline S1 scrape. S1-specific appearance, Thermlock, 28mm glazing, size, security, Secured by Design, SheerVent and rain-sensor claims are concise rewrites of the manufacturer source; the room-planning, survey, installation and enquiry language is original Fenster service copy rather than presented as Sheerline wording.
- Restored the preferred asymmetric image treatment in **The S1 system** section: the thermal construction image is again the dominant square visual, paired with a narrower portrait corner detail raised slightly beside it. The compact type and spacing remain unchanged, and the section still fits inside the `1467 x 709` review viewport without horizontal overflow.
- Rewrote the complete roof-lantern page in a direct `we` and `you` voice. Removed third-person references to Fenster, every em dash, vague lifestyle phrases and the `Plan my roof lantern` CTA. The primary action is now `Get a roof lantern quote`, the form action is `Send enquiry`, and the supporting copy explains what we supply, what we check, what the customer can send and what happens next. The verified Sheerline S1 facts remain intact.
- Split flat rooflights out of the roof-lantern journey into a dedicated `/flat-rooflights/` page. `/roof-lanterns/` now contains only Sheerline S1 lantern information, imagery and the 13 configuration carousel; a compact related-product panel links to the separate Titan route.
- Added all 13 official Sheerline S1 configuration renders as a dedicated interactive carousel using the site's established colour-options interaction. It supports buttons, keyboard control, drag/swipe and a visible `01 / 13` counter, while the surrounding copy explains the square, 2-way and 3-way choices in Fenster's own voice.
- Built the new flat-rooflights page from the supplied Titan scrape and its image manifest. The page separately explains fixed EDGE, opening EDGE Air, Multipane for larger openings and Walkon for pedestrian areas, with direct Fenster copy, local official Titan imagery, a dedicated enquiry source and its own SEO metadata.
- Added the new flat-rooflights route to the Products menu, footer and sitemap. Both roof pages cross-link without mixing their main product content or enquiry project types.
- Kept the new rooflight sections within the reviewed viewport at `1467 x 709`, `768 x 1024` and `390 x 844`. Mobile product choices, controls and specialist units use deliberate swipe rails, all added images load from local theme assets, and both pages have no horizontal overflow.
- Removed the flat-rooflight manufacturer's name and model branding from all customer-facing copy, metadata, captions and alt text. The page now describes the choices generically as fixed, opening, multi-pane and walk-on. Removed the concealed actuator section diagram and retained only the customer-relevant remote and wall-control image.

## 2026-07-14 - Reusable Consultation Booking Request To Test

- Extended the one shared `enquiry-form.php` component with a reusable `consultation_booking` mode rather than adding a second customer form.
- Added an accessible fixed-panel request flow: the next 30 days of weekdays are replaced by a 9am-4pm preferred-time choice, then the normal contact/privacy details, with back controls rather than a stacked form.
- Added a dark-blue desktop-header `Book consultation` action beside `Instant Quote`.
- Added the dedicated, indexable `/book-a-consultation/` route with route-specific title/meta/canonical, sitemap inclusion, breadcrumb schema, visible FAQ/FAQPage schema, the homepage's four-card reviews/accreditations proof row, review proof and the same shared staged consultation form. The page uses one continuous `--fg-page-gradient` canvas in line with `STYLE.md`. Header, footer and Contact now link to this canonical booking route.
- Added server-side weekday, 30-day-window and 9am-4pm validation in `inc\enquiries.php`; selected date/time are saved with the private enquiry and shown in the branded `info@fensterglazing.com` office email.
- Reworked the calendar after visual review into a compact six-week card sized to its actual content, with a visible three-part availability strip for Monday-Friday, 9am-4pm and bank-holiday exclusions. England-and-Wales bank holidays now come from the official GOV.UK feed and are blocked by both the picker and server validation.
- Rebuilt the final booking-details stage as a light consultation-specific form surface: the chosen slot is clearly summarised, fields and required labels remain legible, and the privacy/submit finish is visually contained.
- Replaced the staged booking flow's `Change date` and `Change time` text links with compact, labelled back-arrow controls.
- Added a compact image pair to the consultation hero using the real Milton Keynes showroom and a completed Fenster installation. Updated `STYLE.md` so future new customer-facing pages must scan available local assets and use relevant real imagery when it adds trust, clarity or conversion value.
- Replaced the Contact consultation link with the new `#book-consultation` section. The customer copy correctly says Fenster confirms the requested appointment.
- Reverted the 2026-07-14 wholesale consultation-page rebuild (commits `40db70d`/`03763c1`/`a0bfbac`). That rebuild overreacted to a visual critique: it replaced the approved page structure with a generic three-column image-card section, removed the established four-card proof row and booking steps, and forced imagery into sections that did not need it. The approved `5e695bf` composition is restored as the baseline — hero copy/imagery beside the booking panel, homepage-style proof row, booking steps, advice/contact, FAQs, review showcase and related links — with three small evidenced fixes kept: tighter section rhythm (`clamp(3rem, 5.5vw, 5rem)` desktop, `3rem` at 560px), subtle icon-led phone/email actions in the `Prefer to speak now?` panel, and no functional changes to the shared consultation booking flow. `AI.md` and `STYLE.md` recovery rules were corrected: preserve approved layout, smallest coherent fix first, and a full redesign requires explicit owner approval.
- Replaced that restored baseline with the owner-approved consultation hierarchy: one booking-first calendar hero, a compact Trustpilot/FENSA reassurance strip, one art-directed bifold-door advice/contact section, concise FAQ answers and real review proof. Removed the legacy process cards, detached proof wall, extra hero image tiles and related-link filler. This is the accepted exception to the preservation rule because the owner explicitly approved the new hierarchy. The Products mega-menu now also presents `Book a consultation` beside `Get an instant quote`.
- Expanded `STYLE.md` with the durable first-pass design direction: identify the customer task, dominant first-view object, retained/removed sections, one image treatment and proof role before coding; build a complete hierarchy rather than patching components; use conversion-page order and a clear stopping point; and reject generic card stacks, duplicate proof/CTAs, filler links and imagery with no job. This is the operating standard for getting future page work right without back-and-forth.

## 2026-07-13 - Complete Generated Meta Description Rewrite

- Replaced the long matrix and commercial-county description formulas with concise, complete page-specific sentences; each retains the product or county intent without clipping the end of the copy.
- Rewrote every remaining legacy/generated description that exceeded 160 characters, including the homepage, trust page, commercial hubs, archive shells and older imported SEO fields.
- Kept `fenster_trim_meta_description()` only as a future-safety guard. Source verification across 754 generated and virtual routes found zero descriptions above 160 characters and zero source descriptions ending in its `...` fallback.
- Applied the final editorial review to six legacy descriptions (`/about/`, `/are-my-windows-energy-efficient/`, `/blog/`, two case studies and `/what-are-integral-blinds/`), correcting grammar, the energy-efficiency meaning, stray punctuation and incomplete sentence endings.

## 2026-07-13 - Live SEO Audit Follow-up

- Replaced the two `/areas-we-cover/` shortcut links that still pointed to legacy `/windows/` and `/doors/` redirects with direct canonical links to the Milton Keynes hubs.
- Rewrote the weak generic title tags on `/about/` and `/blog/`, and replaced the overlong, article-like `/commercial-glazing-leeds/` title with a concise commercial-service title.
- The live 681-URL audit found zero sitemap fetch, canonical, title duplication, description duplication, H1, `noindex`, Open Graph image or JSON-LD coverage errors. The remaining strategic SEO work is earning and publishing genuine local project proof for the suburb cluster.
- Reconciled `SEO-AUDIT.md` against a fresh 681-URL live crawl: marked F1–F4 and the completed F9 work, clearly separated historical GSC/competitor snapshots from current advice, and replaced obsolete lead-tracking guidance with the deployed consent-safe first-party attribution model.
- Restored Milton Keynes to the `/roof-lanterns/` title, removed the repeated location from the pricing-hub title, and replaced the head-term page's internal “routes” wording with customer-facing language.

## 2026-07-13 - MK Matrix Canonicalisation And Metadata Guard

- Removed `milton-keynes` from the residential location matrix. The 21 duplicate `/{product}-milton-keynes/` URLs now 301 to their parent product pages, rather than competing with their existing Milton Keynes product intent.
- Added a shared generated-page metadata guard that trims description and Open Graph description output to 160 characters or fewer at render time, protecting all generated routes from overlong inherited descriptions.
- Removed the Woburn 410 link from `/commercial-projects/` by excluding deliberately retired case-study routes from archive cards.
- Local verification: sitemap reduced from 701 to 680 URLs; no product matrix `-milton-keynes/` URLs remain; all 21 legacy URLs resolve to their parent products; `/composite-doors-bletchley/` renders 151-character description and Open Graph description; the Woburn card is absent.

## 2026-07-13 - Consent-Safe Website Attribution And Marketing Dashboard

- Added the Fenster Marketing Dashboard Website Tracker in the separate `Marketing-Dashboard` Cloudflare Pages project. Its source code, API and tracker documentation are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`. It now reports consented anonymous visitors, first touch, acquisition channels, quote starts, forms, contact intent, completed WindowCAD quotes and a clickable per-visitor event timeline with page views, time on page and meaningful link clicks.
- Extended the accepted-only tracker with CTA clicks, 25/50/75/90% scroll milestones, form starts and first validation warning (field name only). The dashboard now shows a more useful lead funnel and lets the office label completed website leads `new`, `contacted`, `appointment`, `won` or `lost` without copying customer details into D1.
- Changed the aggregate consent request to a simple `text/plain` CORS request so it does not depend on a JSON preflight when someone closes the banner on a privacy-focused/mobile browser.
- Removed banner-impression reporting entirely. The original implementation counted each fresh page load before a choice and even a session-only guard could still be inflated by anonymous crawler sessions. Consent health now truthfully reports recorded accepts and rejects only.
- The theme creates opaque `FGV-…` visitor and `FG2-…` journey values only after optional-cookie acceptance. Both persist for 90 days in the same consenting browser; incognito, cleared storage, a different device or a rejected choice starts no tracked visitor.
- WindowCAD attribution now uses only its dedicated **Tracking** customer field. The office-owned **Reference** field remains untouched. Accepted journeys pass `FG2-…`; rejected-cookie quotes pass `rejected-cookies`, and quotes before a choice pass `cookie-consent-not-accepted`.
- WindowCAD and normal form leads still reach WordPress/AdminBase after a rejection, but the dashboard relay is suppressed without a valid `FG2-…`. This prevents unconsented quotes/forms becoming unattributed dashboard records.
- Added aggregate-only consent health reporting: daily accepts, rejects and acceptance rate. The consent table has no visitor identifier, URL, source, device or personal data; banner impressions were removed as unreliable before-consent crawler/session traffic inflated them.
- Added the mobile green header `Call us` control beside Menu; it records a consented phone-tap intent only. Actual answered/missed call attribution remains pending Focus Group API/webhook or scheduled call-report export.
- The final consent-metric correction is live in theme commit `f6c763e` and Marketing Dashboard commit `4957c7e`. The current consent health panel deliberately reports choices recorded, accepts, rejects and acceptance rate only.
- Refreshed the durable theme handover, audit, live-change and progress documentation to record the tracker architecture, privacy boundary, WindowCAD Tracking-field bridge, dashboard ownership and outstanding Focus Group/CRM work. A clean evidence-based continuation prompt was also prepared for the next chat; it treats the early launch GSC observations as historical context rather than current fact.

## 2026-07-13 - Search Console Launch Baseline And SEO Plan

- Reviewed the Google Search Console exports for `Last 7 days` and `Last 28 days`, ending 2026-07-10. The new site went live on 2026-07-06, so the 7-day report mixes old-site Saturday/Sunday with new-site Monday-Friday, and Google may still be crawling/indexing old templates.
- The cleanest early comparison is old-site weekdays 2026-06-29 to 2026-07-03 versus new-site weekdays 2026-07-06 to 2026-07-10: clicks stayed essentially flat at 86 -> 87, impressions rose slightly from 23,362 -> 23,709, weighted CTR stayed about 0.37%, and average position improved from about 24.7 to 23.7. This is not a launch win yet, but it shows no immediate search cliff.
- The full 28-day baseline was 405 clicks, 127,649 impressions, 0.32% CTR and average position 24.6. The launch-week slice was slightly above that at about 15.1 clicks/day, but this is too early to judge new-site SEO success.
- The main finding is that Google is still carrying the site through older informational and utility pages rather than the new MK money-page structure. Strong existing traffic/visibility includes `/3d-visualiser/`, `/what-is-a-door-lintel/`, `/different-types-of-window-frame-materials/`, `/what-are-double-glazed-glass-windows/`, `/soundproof-windows/` and `/french-casement-windows/`.
- Highest-priority CTR opportunity: `/french-casement-windows/` had 3,614 impressions, average position 3.52 and only 0.19% CTR across the 28-day export. Its title/meta/first-screen/snippet intent should be fixed before lower-signal SEO work.
- Highest-priority visibility-but-no-click opportunity: `/what-are-double-glazed-glass-windows/` had 17,884 impressions, 10 clicks and 0.06% CTR. It needs clearer intent ownership around double-glazed glass, replacement sealed units, misted glass, energy upgrades and commercial routes into quote/repair/product pages.
- Money-page state: `/windows-milton-keynes/` had 4,630 impressions, 7 clicks and average position 18.17; `/double-glazing-milton-keynes/` had 1,115 impressions, 0 clicks and average position 56.47; `/doors-milton-keynes/` had 2,416 impressions, 3 clicks and average position 43.71. These pages need more internal authority, richer local/commercial content and stronger conversion structure before judging them.
- Priority fix plan: improve SERP titles/meta and first-screen relevance for `/french-casement-windows/`, `/what-are-double-glazed-glass-windows/`, `/composite-doors/`, `/soundproof-windows/` and related high-impression pages; turn high-traffic info pages into feeders for quote/visualiser/MK pages; strengthen `/double-glazing-milton-keynes/`, `/windows-milton-keynes/` and `/doors-milton-keynes/` through internal links, product-led sections, local trust/proof, pricing/visualiser CTAs and readable SEO copy.
- Next measurement should compare clean new-site weeks, especially 2026-07-06 to 2026-07-10 versus 2026-07-13 to 2026-07-17, instead of treating the mixed launch export as a final verdict.

## 2026-07-09 - Local MK Page Cluster First Pass To Test

- Added a shared local buying-route section to the residential town/product matrix in `template-parts\sections\location-service.php`.
- The new section appears on normal local pages such as `/double-glazing-bletchley/` and `/composite-doors-bletchley/`, adding an image-led local decision block, three town/product-specific guidance cards, instant quote CTA, MK money-page CTA and internal links back to the relevant product route plus the town double-glazing hub.
- Added responsive styling in `src\scss\main.scss` so the new module stacks cleanly on mobile and preserves the continuous page canvas.
- Local verification covered `/double-glazing-bletchley/` and `/composite-doors-bletchley/`: the section rendered with one image, three decision cards, expected CTAs/internal links and zero horizontal overflow on desktop and 390px mobile.

## 2026-07-09 - Local SEO Quick Wins And Pricing Route Correction

- Shipped GSC/audit-led local SEO quick wins in commit `68f38ae` (`Implement local SEO audit quick wins`), then corrected the accidental exact pricing route in commit `51c3550` (`Remove double glazing prices route`).
- Restored `/areas-we-cover/` into the generated `page-sitemap.xml` virtual-route list and added visible links to it from the footer, homepage local mesh and generated related-link bands.
- Strengthened internal links into `/double-glazing-milton-keynes/` and the agreed live pricing hub `/window-door-prices-milton-keynes/`; the accidental `/double-glazing-prices-milton-keynes/` route was removed, now returns 404, is not in the live sitemap and has no homepage/MK-page internal links.
- Added LocalBusiness schema fields for `geo`, `hasMap` and `sameAs`, and verified live schema renders clean `priceRange` (`££`) without mojibake.
- Cleaned local money-page title/meta overrides for key routes including aluminium bifolds, aluminium flush windows, aluminium sliding doors, window and door repairs, patio doors, sliding sash windows, tilt and turn windows, roofline and similar MK-focused product pages.
- Confirmed the "roof lights" keyword work is already in the GSC override map: `/roof-lanterns/`, `/roof-lanterns-milton-keynes/` and `/roof-lanterns-northampton/` titles/meta include "Roof Lights" alongside "Roof Lanterns".
- Verified live after deployment: `/double-glazing-milton-keynes/`, `/areas-we-cover/`, `/window-door-prices-milton-keynes/`, `/aluminium-bifold-doors/` and `/window-and-door-repairs/` render expected titles/schema/footer links; `page-sitemap.xml` includes `/areas-we-cover/` and `/window-door-prices-milton-keynes/`.

## 2026-07-09 - Door Handle Section Scope

- Removed `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` from the shared long-plate `door_handles` route list because those systems use different handle families.
- Kept the selector active for relevant entrance/French-style door routes such as `/upvc-doors/` and `/french-doors/`.
- Pushed and deployed commit `882cf47` (`Scope door handle selector routes`) to live with a theme-only SiteGround rsync and cache flush.
- Verified locally that the affected three routes return 200 without `#fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still render the section.
- Verified live server-side that `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` return 200 without `fenster-door-handles`, while `/upvc-doors/` and `/french-doors/` still include it.

## 2026-07-09 - Product Image Pool Audit

- Audited the product image source path after uPVC door pages were showing aluminium, composite and other wrong-material images.
- Found the issue in `inc\site-data.php`: several product routes shared broad gallery pools such as `entrance_doors`, `wide_span_doors` and `aluminium_doors`, so unrelated product families bled into each other.
- Split curated gallery pools by material/product family for uPVC doors, composite doors, patio doors, French doors, aluminium doors, aluminium bifolds, slide-fold doors and aluminium sliding doors.
- Cleaned uPVC and aluminium window pools so they no longer borrow obvious wrong-material product images just to fill the gallery.
- Updated `template-parts\sections\location-service.php` so generated town/service routes reuse the same curated product media and gallery pools instead of falling back to raw imported scrape images.
- Pushed and deployed commit `97d7525` (`Fix product image gallery pools`) to live with a theme-only SiteGround rsync and cache flush.
- Verified representative main product and matrix routes locally, including `/upvc-doors/`, `/composite-doors/`, `/patio-doors/`, `/french-doors/`, `/aluminium-doors/`, `/aluminium-bifold-doors/`, `/aluminium-sliding-doors/`, `/upvc-doors-milton-keynes/`, `/french-doors-milton-keynes/`, `/patio-doors-milton-keynes/` and aluminium/composite matrix equivalents.
- Verified the live `/upvc-doors/` route server-side after deployment; it returns 200 and includes the curated uPVC/front-door image set (`fenster-upvc-door.jpg`, `Residential_Door_08.jpg`, `Residential_Door_01.jpg`, `new-front-door-in-Milton-Keynes.jpeg`, `house-front-door.jpeg`, `secure-front-door.jpeg`).

## 2026-07-09 - Microsoft Clarity Replay Rendering Fix

- Debugged broken Clarity recordings by simulating Clarity-style page/resource fetches rather than changing visible layout again.
- Found that the real browser site was styled correctly, but browser-like bot/resource requests could receive the SiteGround/nginx `403 - Forbidden` HTML page. That explained Clarity recordings showing raw/default navigation, huge graphics/images and missing CSS.
- Removed the live Clarity plugins (`microsoft-clarity` and `clarity-ad-blocker`) so Clarity is loaded only through the theme consent layer.
- Kept Clarity project ID `xi7rk1pic8` in `inc\consent.php`, gated behind accepted optional-cookie consent.
- Added `data-clarity-unmask="true"` to stylesheet links, critical CSS, font preloads and key image preloads in `inc\assets.php` so stricter Clarity masking preserves resource URLs.
- Added the accepted workaround in commit `f820b87`: after accepted consent, fetch the live `main.css`, inject it into the DOM as `style#fenster-clarity-replay-css[data-clarity-unmask="true"]`, and only then load Clarity. This gives new recordings a self-contained copy of the theme stylesheet even if Clarity's backend/player cannot fetch external CSS later.
- Verified live that the inline replay CSS is present before `clarity.ms/tag` and before `q.clarity.ms/collect`; owner confirmed new Clarity recording renders correctly.

## 2026-07-07 - Commercial Product Template Local Rebuild

- Put the wider live audit on hold to address poor commercial product pages first, especially `/curtain-walling/`.
- Added a dedicated commercial product data layer and template for `/commercial-windows-and-doors/`, `/curtain-walling/`, `/louvre-vents/`, `/commercial-automation/` and `/healthcare-construction/` so these routes no longer depend on the generic generated product journey or rough scraped body sections.
- Curated commercial imagery from the imported theme assets for hero, gallery and related cards, including the curtain walling and real commercial project photos.
- Rebuilt compiled CSS and verified PHP syntax for the touched files.
- Local route checks confirmed all five routes return 200, render the new `fg-commercial-product` template, have no old designer/WindowCAD scrape copy, no broken images, no horizontal overflow and no console errors at desktop and mobile widths.
- Deployed commit `26f3b43` to the password-protected test site and repeated server/browser checks there. This still needs explicit approval before live.

## 2026-07-07 - Clarity Consent Session Fix

- Fixed the Clarity consent setup so accepted visitors receive Microsoft Clarity Consent API v2 signals instead of being treated as no-consent page views.
- Aligned the theme-loaded Clarity project ID with the WordPress Clarity plugin setting (`xi7rk1pic8`) while keeping third-party tracking blocked until the site cookie banner is accepted.
- Local browser verification confirmed no Clarity/GTM/Facebook tracking scripts or `_cl*` cookies before consent, then persistent `_clck` and `_clsk` cookies after acceptance across `/aluminium-doors/` to `/sliding-sash-windows/` navigation.

## 2026-07-07 - Cookie Policy Copy Cleanup

- Replaced the imported `/cookie-policy/` wording with a site-specific policy that matches the current consent banner and tracking setup.
- Deployed the corrected policy copy to test and live through commit `bc625f4`.
- Removed irrelevant claims about customer accounts, logged-in areas, newsletter subscriptions and on-site surveys.
- Clarified that optional Google Tag Manager, Microsoft Clarity and Meta Pixel only load after consent, and that visitors can still use the site after rejecting optional cookies.
- Updated `/privacy-policy/` copy to state that the website does not currently provide customer account registration or an email newsletter sign-up.

## 2026-07-07 - Site-Wide Copy Audit Cleanup To Test

- Verified the 2026-07-06 AI copy audit against current theme source before editing.
- Deployed the verified copy cleanup live through commit `4ce91a6`, after first deploying and checking the same commit on test.
- Removed customer-facing template self-talk from product galleries and specification-choice cards, including `verified product imagery`, `verified supplier imagery`, `page stays visually accurate` and finish-guide architecture wording.
- Replaced visible internal `route` wording across commercial county pages, the trust page, contact page, product hubs, pet-flap copy, handle copy and legacy generated sections with customer-facing terms such as option, approach, process, system and fitting method.
- Lower-cased mid-sentence `obscured glass` copy, while keeping route/title naming where `Obscured Glass` is the page name.
- Rewrote copied article/data fragments in `data/pages.json` that ended mid-sentence or promised non-existent live chat; contact copy now points visitors to phone or email, and the verified 24/7 phone-line footer claim remains in place.
- Verified JSON parsing, PHP lint for all touched PHP files, targeted source greps and local rendered checks on representative product, article, commercial county, commercial projects and obscured-glass routes.

## 2026-07-07 - Product Template Live Polish, Gallery Lightbox And Mobile Nav Fix

- Deployed the shared product-page redesign and follow-up polish live through commit `3ac98c2`.
- Product sections now use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems filler section from generated product pages.
- Product galleries now open in an in-page lightbox rather than a raw image URL/new tab. The accepted lightbox has no visible caption/alt text, no white image card, close/backdrop/Escape handling, previous/next arrows and keyboard left/right navigation.
- Fixed the mobile navigation touch layer so the open menu owns the viewport and page hero/content layers cannot intercept taps on mobile menu rows.
- Verification covered `npm.cmd run build`, PHP lint for changed templates, and browser checks on `/casement-windows/` for the lightbox and mobile nav behaviour.

## 2026-07-07 - Product Page Layout Redesign To Test

- Reworked the shared generated product-page journey toward a clearer 50/50 image-and-copy flow before live approval.
- Replaced the non-FAQ "Why choose this product?" accordion with visible benefit cards, and replaced the tabbed product information explorer with visible specification check cards. FAQs remain the only accordion-style content on product pages.
- Added a no-repeat image queue for product pages: the body image pool excludes the hero image, and later gallery moments draw from later unique images rather than recycling the same visual.
- Moved window handle selection out of inline product pages into a dedicated `/window-handles/` specification hub, with product pages linking to that hub from the specification choices area.
- Refined the test template copy so product intro sections use `Product information` plus the product name, and product hubs use `More information on [product]`.
- Removed the product hub survey summary, common choices strip, quote option card and separate accreditations/systems section from generated product pages.
- Expanded the product-hub specification check cards to fill the section width, and made product-gallery images open through the site lightbox with a hover affordance.
- This change was reviewed, refined and later deployed live through commit `3ac98c2`.

## 2026-07-06 - Reviews Copy And Privacy Policy Cleanup

- Replaced hardcoded review-count claims such as `200+ five-star reviews`, `Google 130 reviews` and `Trustpilot 226 reviews` with stable wording around hundreds of customer reviews across Google and Trustpilot.
- Rebuilt `/privacy-policy/` as a theme-owned virtual page with clean title/meta and current plain-English content covering enquiries, uploads, WindowCAD, AdminBase, cookies, analytics, retention and customer rights.

## 2026-07-06 - Test Domain Deindex Hardening

- Rechecked `test.fensterglazing.com` after it appeared in Google results despite Basic Auth.
- Confirmed the test homepage and `robots.txt` were returning `401` without an `X-Robots-Tag`, which could leave stale URL-only search results.
- Updated both the Bedrock root and `/web` test `.htaccess` files on the server so normal test URLs stay password protected but return a custom `401` response with `X-Robots-Tag: noindex, nofollow, noarchive`.
- Added public `robots.txt` files on test with `Allow: /` so crawlers are not blocked from revisiting already-known URLs and seeing the noindex/401 response.

## 2026-07-06 - WindowCAD/AdminBase Relay Restored

- Tracked the missing integration to the inactive live `wraith` theme over SSH.
- Found the old `/wp-json/fenster/v1/windowcad` REST endpoint in `wraith/app/setup.php`, which flattened WindowCAD `json.infoProperties` and posted leads to AdminBase.
- Added `wp-content/themes/fenster/inc/adminbase.php` and included it from `functions.php`.
- Restored the WindowCAD REST endpoint, private WordPress enquiry saving for WindowCAD submissions, AdminBase relay metadata, and normal enquiry relay through `fenster_enquiry_created`.
- Kept AdminBase credentials out of the repo; the new theme reads constants, environment variables or WordPress options.

## 2026-07-06 - Redirect, Duplicate Host And Consent Fixes

- Removed the live `/terms-conditions/` redirect that sent footer legal links to `/privacy-policy//`; the server now returns the Terms page directly.
- Deleted the legacy redirect row hijacking `/aluminium-bifold-doors-northampton/`; the generated Northampton bifold route now returns directly.
- Added a live server redirect from `www.fensterglazing.com` to the apex host before the Bedrock internal rewrite.
- Password-protected `test.fensterglazing.com` with Basic Auth (`fenster` / `Fenster`) so it is no longer a public crawlable duplicate.
- Added theme-owned cookie consent controls that suppress automatic GTM, Clarity and Meta Pixel output until a visitor accepts optional cookies.

## 2026-07-06 - Deploy Policy Clarification

- Historical note: this entry originally allowed small, scoped, low-risk changes to go directly to live. That workflow was superseded on 2026-07-15; every completed change now goes to the password-protected test site first.

## 2026-07-06 - Cat And Dog Flaps Page Rewrite

- Rebuilt `/cat-and-dog-flaps/` at the generated-page source after the imported scrape title and copy produced bad output such as "Need Cat and Dog Flaps?" and double-question headings.
- Added a route-specific generated-page SEO/title override so the page now uses `Cat and Dog Flaps` consistently in the H1, metadata, FAQ heading and internal labels.
- Rewrote the pet-flap product intro, benefits, FAQs, product-hub detail and USP labels around the real customer decision: suitable door panel versus new sealed glass unit, manual/lockable/microchip options, pet size, flap height and survey checks.
- Added a dedicated pet-flap fitting guide section and suppressed the generic product visual gallery/specification-choice block on this route, because frame-colour/privacy-glass catalogue copy does not fit the service.
- Added responsive SCSS for the pet-flap guide cards so the page collapses cleanly on mobile.

## 2026-07-06 - Lighthouse Performance Wave 1 And 2

- Added a performance pass in response to the mobile Lighthouse report showing 62 Performance, 4.3s FCP and 14.5s LCP on slow 4G.
- Added critical first-viewport CSS and changed the main stylesheet link to preload/activate asynchronously with a noscript fallback, reducing render-blocking pressure while keeping the hero/header styled.
- Added WOFF2 versions of the Gibson fonts and updated `@font-face` declarations to prefer WOFF2 with OTF fallback; Regular and SemiBold are preloaded as critical weights.
- Added a homepage hero-poster preload and changed the homepage hero video lazy loader so mobile, reduced-motion and constrained-connection sessions keep the 9.36 MB video out of the initial load until interaction.
- Added `fenster_image_attr_string()` and related helpers in `inc\assets.php` so local theme images can render explicit width/height attributes; applied it to the header logo, homepage product/trust/partner images, and key generated/article/location hero images.
- Added below-fold homepage `content-visibility` guardrails for the quote, partner, review, enquiry and local-link sections.
- Improved review carousel ARIA by giving decorative star/Google label spans explicit image/group roles, and increased mobile product dots/review carousel buttons to 44 px tap targets.
- Verification: `npm.cmd run build` passed; PHP lint passed for all touched PHP files; browser check on the local homepage confirmed poster/font preloads, explicit image dimensions, no desktop/mobile horizontal overflow, mobile hero video source still deferred after 2.5s, 44 px mobile dots and no console errors.
- Static cache headers still need a server/SiteGround step because `app/public/.htaccess` is ignored by the GitHub theme repo. Add long-lived `Cache-Control: public, max-age=31536000, immutable` for theme CSS, JS, fonts, images and video at host/CDN level.

## 2026-07-06 - Article CTA Form Layout Fix

- Fixed generated article/blog CTA form layout and contrast in commit `aff62a0`.
- Added the `fg-article-form` class to the shared enquiry form when rendered from `template-parts\sections\generated-article.php`.
- Added article-specific CTA/form styling so the left copy panel has deliberate contrast and the right form has readable labels, visible input borders, sane textarea height and a mobile one-column layout.
- Rebuilt compiled CSS, pushed to GitHub, deployed to live with the theme-only SiteGround workflow and flushed the WordPress cache.
- Server verification passed: `generated-article.php` had no PHP syntax errors and live CSS/template contained the new article form selectors.

## 2026-07-06 - Performance Deferral Pass

- Improved live loading behaviour in commit `7c973b5` without removing the premium video/quote experience.
- Deferred the homepage hero video until page idle so it is not a blocking first-load dependency.
- Deferred homepage/product/quote WindowCAD iframe source loading through `data-quote-iframe-src`, with near-viewport and click/interaction triggers.
- Kept quote tool placeholders/actions usable while the iframe loads.
- Reduced eager media pressure in the homepage product theatre and heavy generated product sections.
- Rebuilt CSS/JS, pushed to GitHub and deployed live.

## 2026-07-06 - Commercial Glazing Hub V2

- Reworked the main `/commercial-glazing/` page in commit `5696140` to be simpler, proof-led and more conversion-focused.
- Corrected project proof imagery to use commercial-project/theme assets rather than wrong generic images.
- Reworked commercial glazing products/services imagery from available Fenster/theme assets and kept runtime references out of `wp-content\fenster-reference`.
- Removed the tiny decorative parallax drift in the "How enquiries move" area.
- Tightened and simplified awkward page sections such as "Where this fits" so the page is less padded and more practical.
- Restyled the commercial enquiry section so the form inputs are visible and the copy does not use oversized hero text.
- Rebuilt compiled CSS, pushed to GitHub and deployed live.

## 2026-07-06 - Stale Audit Recheck And SEO Hardening

- Rechecked the outdated pre-launch audit claims against live output instead of trusting the old crawl notes.
- Verified social share metadata is already clean on live: homepage and product routes emit current theme-owned OG/Twitter title/image tags using the local showroom image.
- Verified live language output is already `lang="en-GB"` and WordPress `WPLANG` is `en_GB`.
- Fixed the confirmed colour-hub duplicate issue: `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/`.
- Added `inc/security.php` to harden public WordPress output: unauthenticated REST user enumeration returns 401, XML-RPC is disabled via WordPress filter, `X-Pingback` is removed, and WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output is stripped.
- Restored theme sitemap ownership before Rank Math can serve XML, so `/sitemap.xml` points at the theme `page-sitemap.xml`; live verification showed 421 canonical URLs, `/colour-options/` included, and redirected colour URLs excluded.
- PHP lint passed for changed files, changes were pushed to GitHub and deployed live through the theme-only SiteGround workflow.

## 2026-07-06 - Mobile Product Template Fixes

- Fixed the owner phone QA issues from the product template pass and deployed them live in commit `c21bd46`.
- Product information hubs now have calmer mobile spacing between "Why choose this product" and the hub.
- Product hub supplier/proof badges are constrained on mobile so Liniar, Energy Plus, A+ rated and PAS 24 badges sit at more balanced visual sizes.
- The product information tab rail is viewport-contained on mobile, uses native horizontal scroll-snap, hides the scrollbar, and adds a visible "Swipe to see all product checks" affordance when there are more than two checks.
- The common-choice strip stacks on mobile and no longer uses two wide columns that can push the whole page sideways.
- `/colour-options/` hides the hero sample-board visual on mobile so the page starts cleaner.
- `/sliding-sash-windows/` now has mobile-specific sizing for Roseview model cards, comparison rows and detail imagery: smaller contained images, stacked comparison cards and fixed-aspect image panels.
- Verification: `npm.cmd run build` passed, `generated-page.php` passed PHP lint, the theme was pushed to GitHub and deployed to live with cache flushed.

## 2026-07-06 - Live Phone QA Notes

- Captured owner phone QA findings for the next mobile polish pass. These findings were addressed in later product-template/mobile fixes and superseded by the live product-page redesign through `3ac98c2`.
- Product pages such as `/casement-windows/` are broadly strong at the top, but need spacing and mobile component polish around the "Why choose this product" to product hub transition.
- Product hub logo sizing needs balancing on mobile: Liniar and Energy Plus currently feel oversized compared with A+ rated and PAS 24 proof badges.
- The common-choice/product-view control area is a priority bug: it can overflow its frame and create full-page horizontal scrolling on mobile.
- Product-view controls need clearer discoverability when more than two options exist.
- `/colour-options/` should remove or simplify the hero image on mobile; the rest of the page is acceptable.
- `/sliding-sash-windows/` needs mobile-specific redesign work for the Roseview model stats, corner detail, slide-aligned comparisons and large detail imagery.
- No code changes were made in this entry; this was documentation of live phone QA findings before the later fixes.

## 2026-07-06 - SiteGround Test Deploy, SEO Ownership And Forms

- Verified the real SiteGround structure: both test and live are Bedrock installs, so the server theme path is `web/app/themes/fenster` even though local development uses `wp-content/themes/fenster`.
- Deployed the GitHub theme to `https://test.fensterglazing.com` from the server repo cache at `~/repos/FensterGlazing-NewSite`, then activated the `fenster` theme on test. The same theme has since been deployed and activated on live.
- Disabled the test-only `mousewheel-smooth-scroll` plugin because it conflicted with the theme's Lenis scrolling and caused jumpy scroll behaviour. Do not run another smooth-scroll plugin alongside the theme.
- Fixed Bedrock theme asset URLs so generated `/wp-content/themes/fenster/...` references map to the real theme URI under `/app/themes/fenster/...`; this restored imported images and theme-owned media on test.
- Added the aluminium windows story-frame folders to git so the scroll video on `/aluminium-windows/` works on test instead of only locally.
- Suppressed Yoast and Rank Math public head output on generated pages, then added theme-owned title/social meta handling so public SEO tags come from the theme rather than stale plugin/imported data.
- Tightened contact and online-quote titles, zoomed the WindowCAD iframe down for a usable first view, and verified key routes/assets returned 200 on test.
- Verified enquiry delivery on test and live: valid AJAX form submissions save as private `fenster_enquiry` posts and send an office HTML email to `info@fensterglazing.com`.
- Polished the enquiry email HTML header so the Fenster logo sits on a light header and remains visible in email clients.
- Matched the old working office-email envelope (`WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`) after live manual submissions confirmed the office-facing email was the fragile part.
- Paused customer confirmation emails unless authenticated SMTP is configured, and removed public form copy that told customers to wait for or reply to a confirmation email.
- Added optional enquiry file uploads for photos, drawings, schedules and documents; uploaded files are stored against the private enquiry and attached to the office email.
- Temporarily hid the unfinished residential case-study area for launch: `/case-studies/` and known residential child case-study routes now return 410 and are excluded from the sitemap, with public CTAs moved to `/commercial-projects/`. Commercial project records stay reachable for proof.
- Renamed the privacy-glass route to `/obscured-glass/`, added a 301 from `/obscure-glass/`, updated visible copy to "obscured glass", and adjusted the mobile visualiser so it does not trap normal vertical scrolling.
- Documented the future workflow as local code change -> GitHub -> test deploy -> verify -> fresh live backup -> live deploy, avoiding direct live editing and SiteGround clone/staging tools.

## 2026-07-06 - Launch Documentation, GitHub And Mobile Polish

- Pushed the scoped project to GitHub at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`, keeping the repo focused on the custom theme and docs rather than WordPress core, uploads, `wp-config.php`, local backups or the `wp-content\fenster-reference` archive.
- Clarified the launch deploy model in the docs: update/swap `wp-content\themes\fenster` from the repo, leave production database/uploads/plugins/config in place, and keep reference archives out of production.
- Fixed mobile About page process cards so text has proper internal padding and no longer touches the card border.
- Fixed mobile Contact page CTA cards so the image overlays, headings, body copy and action arrows are readable and no longer overlap.
- Simplified mobile quote-tool actions on `/online-quote/` and product quote embeds: mobile now shows one same-tab `Open quote tool` action, while desktop keeps `Expand view` and `Open in new tab`.
- Rebuilt compiled CSS and linted changed PHP templates for the mobile quote/link changes, then browser-checked the About, Contact, online quote and product quote embed views at mobile size.
- Updated `AI.md`, `HANDOVER.md`, `HOMEPAGE.md`, `STYLE.md`, `PROGRESS.md` and `AUDIT.md` with the launch state, GitHub scope, SEO work, deploy boundary and mobile quote behaviour.

## 2026-07-06 - Launch SEO Hardening Pass

- Overrode the imported homepage SEO with a launch-focused title and meta description targeting double glazing, windows and doors in Milton Keynes, Bedfordshire and Buckinghamshire.
- Added per-request memoisation for `fenster_get_generated_page()` so repeated title/meta/schema/preload/router lookups do not rebuild the same generated page payload within one request.
- Removed the remaining public no-cache behaviour for generated pages and XML sitemaps by replacing WordPress default headers with short public cache headers for logged-out visitors.
- Added generated `BreadcrumbList` JSON-LD on deep generated routes, rolling commercial county pages up to `/commercial-glazing/` and residential product/location pages up to `/areas-we-cover/`.
- Added 301 normalisation for generated routes without trailing slashes and for mixed-case generated URLs, verified with `/casement-windows` and `/Casement-Windows/`.
- Tightened sitemap hygiene: thin utility/scrape shell pages (`gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `brochures`, `apecs-terms-conditions`, `fenster-partners`) now render `noindex,follow` and are excluded from the sitemap.
- Removed the temporary `/commercial-areas/` developer shortcut from the public header navigation.
- Added `/areas-we-cover/` to the footer company links and `/terms-conditions/` to the footer legal links.
- Verified rendered output locally: homepage title/meta/canonical correct, breadcrumb schema present on `casement-windows-toddington`, homepage no longer links to `/commercial-areas/`, noindex pages render noindex, sitemap excludes the utility debris and contains 427 URLs, cache headers are public on generated pages/sitemaps, and PHP lint passed for all changed PHP files.

## 2026-07-03 - Residential Location Metadata De-Duplication

- Reworked generated residential product/location metadata in `inc\generated-pages.php` so the 13 town x 21 product matrix no longer uses one duplicate meta-description template.
- Added town profile and product profile data for residential matrix SEO titles/descriptions, varying snippets by property context, local planning priority and product decision points.
- Verified all 273 residential matrix pages render unique meta descriptions, with zero duplicate meta groups and zero fetch errors.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Commercial County Coverage And Meta Tightening

- Removed `/commercial-glazing-isle-of-wight/` from the generated commercial county profile set because ferry/island access is not credible normal commercial coverage for Fenster.
- Added the removed Isle of Wight commercial route to the central 410 Gone list so it does not remain indexable or appear as an ambiguous missing page.
- Reworked commercial county title tags and meta descriptions so they use each profile's county, town examples and project context rather than one near-duplicate metadata template with only the county swapped.
- PHP lint passed for `inc\generated-pages.php`.

## 2026-07-03 - Launch Blocker Fixes (Schema, Reference Assets, Sitemap, Debris Routes, Article Template)

- Captured the full 2026-07-03 master site audit and remediation status in `AUDIT.md`, keeping the audit/backlog separate from this chronological progress log.
- Fixed the structured-data bug where the shared bad-SEO-content check rejected every JSON-LD block (all valid JSON starts with `{`), so no schema ever rendered. Imported scrape schema is now intentionally dropped (it contained old designer-tool VideoObject markup, `test.fensterglazing.com` image URLs and unsubstantiated aggregateRating values) and replaced with generated schema: a site-wide `HomeAndConstructionBusiness` LocalBusiness block from brand data in `inc\generated-pages.php`, plus `FAQPage` JSON-LD on product journey pages built from the same FAQs rendered on the page.
- Removed the runtime dependency on the 2.4 GB `wp-content\fenster-reference` scrape export. Copied the 356 images actually referenced by templates and `data\pages.json` into `assets\images\imported`, rewrote all references (2,577 in `pages.json` plus eight PHP files), re-encoded the 2.9 MB PNG homepage hero poster to a 175 KB JPEG (`home-hero-poster.jpg`), and deleted the dead bifold scroll-video branch that referenced reference-folder media. The reference folder must not be deployed to production and is no longer needed at runtime.
- Fixed sitemap/robots plumbing: disabled core `wp-sitemap.xml` (it advertised a parallel incomplete URL set and a users sitemap), and the robots.txt filter now strips stale Sitemap lines and appends `home_url('/sitemap.xml')`. The custom sitemap index loc also uses `home_url()`.
- Added debris-route handling in `inc\generated-pages.php`: 410 Gone for test pages (`nick-test-baboon`, `our-new-website`, `case-studies/test`, `case-studies/template-new`); 301 redirects for duplicate town slugs (`dunstable-casement-windows`, `bow-and-bay-windows-northampton`, `tilt-and-turn-windows-northampton`), `commercial-glazing-london-2`, `healthcare_safeguarding_in_construction`, `enquire-now`, `instant-pricing` and all `*-designer` pages (to their base product, else `/online-quote/`); `noindex,follow` for the live ad landers (`pricing-gads`, `instant-pricing-meta-ads`, `ppc-landing-page-composite-doors`, `roof-lanterns-landing-page`) and all `category/`, `tag/`, `author/` and `blog/page/` archive shells. The custom sitemap skips gone/redirected/noindex slugs (486 down to 436 URLs).
- Replaced the slug-substring product heuristic in `template-parts\sections\generated-page.php` with explicit product/commercial route whitelists, so ~40 blog and guide articles no longer render the product journey with broken headings ("Why choose Are My Windows Energy-Efficient??").
- Added `template-parts\sections\generated-article.php`: a readable article layout (moderate hero, constrained article body with real scraped headings/paragraphs, inline images, compact shared enquiry form CTA, related links) plus `.fg-article-page` SCSS, hooked into the guardrail heading scale.
- Kept `/other-services/` on the simple layout via the utility list so it does not read as a fake product page.
- Verified via rendered checks: LocalBusiness schema on every page, FAQPage on product pages, robots.txt points at the custom sitemap, wp-sitemap 404s, all redirects/410s/noindex resolve correctly with 200 targets, articles render the new template, product/location/commercial/hub/utility pages unchanged, homepage internal links all 200, PHP lint and `npm.cmd run build` pass.

## 2026-07-03 - Sliding Sash Windows Roseview Model Page

- Reworked `/sliding-sash-windows/` with a dedicated Roseview comparison section for Ultimate Rose, Heritage Rose and Charisma Rose.
- Added curated Roseview export imagery under `assets\images\products\sash-roseview` so the page shows clear model and detail differences rather than relying only on generic product gallery images.
- Added customer-facing model guidance covering best-fit use cases, meeting rail sizes, corner construction, frame depth, glass unit depth, energy rating and ThermoVFlex routes without inventing unsupported Fenster specifications.
- Added sash-specific visual detail sections for meeting rails and mechanical/welded joints, using the existing `data-fg-depth` scroll-depth behaviour for desktop parallax and static mobile fallbacks.
- Replaced the generic window-handle treatment on `/sliding-sash-windows/` with Roseview-specific sash furniture: Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, extra Shark Fin/D Handle options and the Roseview under/over 700mm furniture-count rule.
- Replaced the inherited Liniar product-hub system badge on `/sliding-sash-windows/` with a Roseview system entry and local Roseview logo from the Roseview scrape. The first copied logo was white/invisible on the white badge, so the route now uses the visible local `assets\partners\roseview-logo-new.png` file and product hub system logos are routed through `fenster_generated_url()`.
- Styled the new sections inside the existing continuous page background model from `STYLE.md`, with responsive model cards, a horizontally scrollable mobile comparison table and no standalone forms.
- Verified in the rendered local page: Liniar is not visible on the sash page, the Roseview logo loads, all 10 sash furniture images load after lazy scroll, the furniture cards align on desktop, the new sash furniture section does not cause mobile overflow, PHP lint passes and `npm.cmd run build` passes.

## 2026-07-02 - Commercial County Landing Pages

- Removed `Commercial Buckinghamshire` from the Commercial header dropdown so SEO location pages are not exposed as normal commercial menu items.
- Added a temporary noindex `/commercial-areas/` developer review page and a header `Areas` shortcut listing all generated commercial county landing pages.
- Added generated commercial glazing landing pages for England's county set using `fenster_commercial_county_profiles()` in `inc\generated-pages.php`.
- Generalised `template-parts\sections\commercial-county.php` so every county page renders unique county-specific H1, meta description, town coverage, context copy, FAQs and planning notes.
- Moved the shared compact enquiry form into the county hero and added a clearly visible phone CTA for commercial enquiries.
- Included the commercial county pages in the generated sitemap while keeping `/commercial-areas/` out via `noindex`.
- Rebuilt compiled CSS/JS and verified 48 county pages render, all with unique H1/meta descriptions, one shared form and visible phone number.

## 2026-07-02 - Trust Page And Homepage Trust Link

- Added a hardcoded virtual `/why-trust-fenster/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Built `template-parts\sections\trust-page.php` with stronger buyer-facing trust content: verifiable public reviews, local showroom accountability, why Fenster was made, survey-led process, customer information handling, accreditations and contact routes.
- Revised the page again to use the real customer-facing trust story: started in 2018, 8 years trading, around 25 years combined glazing experience, transparent upfront pricing, honesty and highly trained fitters.
- Reduced the trust-page heading scale so the page header reads as a customer information page rather than an oversized marketing hero, and added a site-wide typography rule to `STYLE.md`/`AI.md` to stop future AI passes making normal page headers too large.
- Added an end-of-stylesheet normal-page H1 guardrail covering contact, simple utility, trust, team, about and areas pages so late page-specific overrides cannot accidentally push them back to oversized hero type.
- Reused the shared review showcase component and existing showroom/trust assets rather than duplicating review data.
- Added a small centred homepage trust-bar link beneath the four logo/review cards, plus a footer company link.
- Reworked the trust page again into a more image-led customer confidence page, using showroom/about imagery, three team portraits and curated product images across a hero collage, visual proof mosaic, team strip and product proof cards.
- Browser-checked `/why-trust-fenster/` at `1440 x 900`, `768 x 1024` and `390 x 844`: 18 trust-page images render in the DOM, the new visual/team/product sections are present, there is no horizontal overflow and no console errors.
- Direct URL checks passed for the new showroom, team and product image assets used on the trust page.
- Replaced the fussy trust-page hero collage and visual proof mosaic with a simpler competitor-style layout: one large hero image, two large image/content proof rows, and a named team strip linking to `/meet-the-team/`.
- Replaced Zac Bartley's Meet the Team portrait with the supplied black-and-white image and made Zac's team-page image load eagerly.
- Reworked the trust page again so the hero uses a 2x2 Google, Trustpilot, FENSA and CPA proof grid instead of a product photo, added a clear mission statement near the top, expanded showroom/survey/customer-choice copy, and changed the team strip to Nick Baker, Adam Butcher and Perry Giffin with job titles.
- Refined the trust page tone and layout: removed the extra practical-reasons block from the hero, gave the mission statement a soft translucent bordered panel, rewrote team/product copy in a calmer UK customer-facing tone, changed product cards back to normal dark text, and replaced the old care section with the product-page order process rail.
- Tightened the trust page follow-up: added showroom and product CTAs to the two feature sections, made team job roles visible as image labels, nudged Perry's portrait crop upward, and removed the separate Products and Choices section entirely.
- Polished the homepage/product/about/contact pass: changed the homepage pricing bridge to a live instant quote iframe with softer quote wording, removed the commercial-heavy Proof in the Work strip, changed product galleries from 4x4 to fixed 2x2 mosaics, auto-loaded product quote iframes, swapped the roof lantern page to better S1 lantern scrape imagery, changed the About hero to the showroom image, and put the instant quote screenshot behind the Contact quote CTA.

## 2026-07-01 - Contact Page Hub Refresh

- Reworked `/contact/` into a stronger first-screen contact hub with two oversized interactive route panels: `Instant quote` and `Consultation`.
- Kept direct phone, email and showroom routes visible beneath the primary panels, then preserved the showroom map, enquiry form, reviews and useful links below.
- Used the existing showroom image as a real visual asset and kept the page on the continuous site background from `STYLE.md`.
- Added final contact-hub SCSS overrides and rebuilt compiled CSS/JS with `npm.cmd run build`.
- PHP lint passed for the contact template.
- Browser-checked `1440 x 900`, `768 x 1024` and `390 x 844`: no horizontal overflow, no console errors, two hub cards render, instant quote links to `/online-quote/`, and consultation targets the showroom section.

## 2026-07-01 - Product Gallery Expansion

- Added a picture-heavy `Product gallery` section to product journeys, rendering a 16-image mosaic with SEO-supporting product copy beside it.
- Added product-family gallery groups and curated image pools in `inc\site-data.php` so pages fill the mosaic from verified scrape-derived assets rather than old scraped page galleries.
- Kept exact product images first, then filled the remaining grid with closely related images from the same product family.
- Styled the gallery as a 4-column desktop grid with a right-side copy panel, collapsing to a 2-column mobile image grid with the copy first.
- Rebuilt compiled CSS/JS with `npm.cmd run build`.
- Verified 25 rendered product/service pages have 16 curated gallery images, zero `/wp-content/fenster-reference/` images in the new gallery, and no New Wave wording on `/slide-fold-doors/`.
- Browser-checked desktop bifold gallery and mobile slide-and-fold gallery for column count, curated paths and horizontal overflow.

## 2026-07-01 - Product Image Curation Pass

- Added curated product media overrides in `inc\site-data.php` so product pages use verified theme assets instead of the old scraped Fenster gallery order.
- Copied 31 checked product images from Liniar, Sheerline, Distinction Doors, Notan, neutral slide-and-fold assets and visibly accurate Fenster-export service images into `assets\images\products\curated`.
- Updated `template-parts\sections\generated-page.php` so curated hero/gallery media replaces scraped hero-adjacent, `Why choose this product?` and feature-card images when available.
- Kept slide-and-fold imagery and alt text neutral, with no New Wave wording on the rendered page.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Spot-checked 25 rendered product/service pages: curated image URLs were present, old `/wp-content/fenster-reference/` image URLs were absent, and `/slide-fold-doors/` contained no New Wave text.

## 2026-07-01 - Product Copy Override Pass

- Added curated `product_content` intros, five benefit cards and five FAQs for all mapped residential product/service routes so product pages no longer depend on scraped section fragments for the `Why choose this product?` and FAQ areas.
- Rewrote previously broken product content including Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs, using existing Fenster product data plus manufacturer scrape facts from Liniar, Sheerline, New Wave, Distinction Doors and Notan.
- Kept specification claims aligned with existing `product_usps` data and avoided invented U-values, especially where Composite Doors and Integral Blinds do not have supplied U-values.
- Tightened generated-page filtering to reject obvious scraped designer/tool debris, one-word fragments, leading punctuation fragments and unfinished body copy before it can be used as generated fallback content.
- PHP lint passed for `inc\site-data.php` and `template-parts\sections\generated-page.php`.
- Verified every mapped product route has a curated intro, five benefits and five FAQs, and spot-checked rendered local pages for Sliding Sash Windows, Composite Doors, Roof Lanterns and Window and Door Repairs.

## 2026-07-01 - Colour Hub Carousel, Swatches And Form Scale

- Reworked the colour options hub so uPVC and aluminium colours are presented as sections on the same customer-facing hub rather than via confusing top tab/menu buttons.
- Replaced the uPVC colour carousel imagery with optimised swatch WebP assets from `images\colours_page_image`, stored under `assets\images\products\colours\liniar-swatches`.
- Kept the door-render colour assets under `assets\images\products\colours\liniar-door` for later door-page use rather than using them on the colour hub.
- Trimmed the uPVC visible colour list to the approved customer-facing set.
- Added `Smooth White` as a separate uPVC colour using the white swatch image and `No foil` detail.
- Renamed `7016 Grey` to `Anthracite Grey`, `7155 Grey` to `Silver Grey`, and `Gale Grey Finesse` to `Gale Grey Finesse (Anthracite Smooth)`.
- Implemented the colour swatch carousel as a coverflow-style browser with buttons, keyboard support and draggable scrub behaviour.
- Updated drag behaviour so dragging controls the coverflow animation state directly, can move across multiple colours, and snaps to the nearest colour on release.
- Tuned carousel drag sensitivity down after review so mobile browsing is less twitchy.
- Reworked the colour hub hero visual away from awkward overlapping cards into a simpler swatch sample board and fixed swatch image cropping by using complete contained images.
- Reduced shared enquiry/form section heading sizing so form intro headings no longer render at hero scale.
- Rebuilt compiled CSS/JS and browser-checked colour hub carousel, hero image behaviour and enquiry heading sizing.

## 2026-06-30 - Product Specification Hub And Colour Pages

- Removed the product-page mini-gallery that was rendering imported `images` data above the colour choices.
- Traced the unwanted stock imagery to old copied export entries in `data\pages.json`, including `stock-04.jpg` and `stock-05.jpg`, then tightened generated-image validation so obvious stock/placeholder filenames are rejected.
- Replaced the huge inline product colour block with compact `Specification choices` cards linking to colour options, Obscured glass and relevant hardware decisions.
- Added the circular interactive choice dial to the product-page `Specification choices` section, not the colour hub pages.
- Added hardcoded virtual colour routes:
  - `/colour-options/`
  - `/upvc-colours/`
  - `/aluminium-colours/`
- Added shared `colour_options` data in `inc\site-data.php` for uPVC and aluminium frame colours.
- Kept the colour pages as straightforward reference hubs without the spinning/orbit interaction.
- Cropped the supplied nine-handle image sheet into separate transparent PNG assets under `assets\images\products\door-handles`.
- Replaced the door-handle placeholder with a real door handle selector section using `door_handles` data in `inc\site-data.php`.
- Removed the separate gradient background from the product-page instant quote section so it sits on the continuous site background from `STYLE.md`.
- Updated `AI.md` and `HANDOVER.md` with the new product-template and colour-hub model.

## 2026-06-29 - Areas Page Customer-Facing Pass

- Removed the temporary `Areas` shortcut from the site header.
- Reworked `/areas-we-cover/` from a noindex developer review grid into a customer-facing local coverage page.
- Made the coverage page indexable and added it to the generated sitemap virtual route list.
- Added a small About-page CTA linking to `/areas-we-cover/`.
- Kept the generated town/service links grouped by location, but changed the page copy and presentation for customers rather than internal QA.

## 2026-06-29 - Contact Page Reworked Against Style Docs

- Rebuilt `/contact/` as a proper showroom-led contact experience, not a rearranged split hero/card stack.
- Pulled the design back into the quieter style used by the quote and team pages: light continuous canvas, moderate hero type, constrained panels and clean contact choices.
- Removed the broken experimental contact-method row layout that was forcing phone/email text into one-character columns.
- Added a dedicated showroom/map section and route rows for home projects, commercial work and instant pricing.
- Kept the page on one continuous `--fg-page-gradient` canvas, with transparent section wrappers and local contrast only on purposeful panels, map and form surfaces.
- Kept the shared enquiry form component as the only live customer form.
- Avoided the old Three.js/canvas direction entirely; the page uses real showroom imagery and standard HTML/CSS only.
- Rebuilt compiled assets, linted the contact template and verified screenshots at `1440 x 900`, `768 x 1024` and `390 x 844` with no horizontal overflow or console errors.

## 2026-06-29 - Documentation Truth Audit

- Audited the handover/rules/homepage/style docs against the current theme code.
- Clarified that Three.js is not active: there is no `three` dependency/import/enqueue, the compiled JS does not contain the old 3D controller, and remaining `fg-home-hero-3d` / `data-fg-home-3d` references are inactive legacy source/style hooks.
- Updated homepage language from the old product-story model to the current five-group product theatre.
- Added the current `/contact/` page model, shared review showcase behaviour, commercial virtual routes and product quote `Load tool` lazy-loading detail to the handover/rules docs.
- Reconfirmed `/wcad-thank-you/` stays removed and the generated matrix remains 13 towns x 21 residential products.

## 2026-06-29 - Styling Source Of Truth Added

- Added `STYLE.md` as the dedicated source of truth for site-wide visual styling, including the continuous page background rule.
- Promoted the rule that `--fg-page-gradient` should be painted once on the page canvas rather than repeated on every section or inner wrapper.
- Added guidance for section continuity, visual assets, cards, colour, typography, forms, mobile design and visual QA.
- Updated `AI.md`, `HANDOVER.md` and `HOMEPAGE.md` so future visual work is directed to read `STYLE.md` first.

## 2026-06-29 - Contact Page Visual Refresh

- Reworked the hardcoded `/contact/` page hero into a richer contact hub with the Milton Keynes showroom photo, overlay showroom details and quick proof facts.
- Expanded the action cards to cover call, email, showroom directions and instant pricing.
- Refined the map, route-choice and enquiry sections so the shared enquiry form remains the single live form while the page feels more polished and practical.
- Added responsive contact-page styling for desktop, tablet and phone layouts.
- Rebuilt compiled CSS/JS, linted the changed contact PHP template and verified `1440 x 900`, `768 x 1024` and `390 x 844` layouts with no horizontal overflow or console errors.

## 2026-06-26 - Obscured glass Visualiser Page

- Added a hardcoded virtual `/obscured-glass/` page in `inc\generated-pages.php` and included it in the generated sitemap virtual route list.
- Kept the page out of the main navigation.
- Added a CTA to the generated product template's `Gallery and choices` / finish options card linking to `/obscured-glass/`.
- Added Obscured glass pattern data in `inc\site-data.php` under `obscure_glass`.
- Converted the supplied Pilkington texture PNGs into web-friendly theme WebP assets under `assets\images\products\obscure-glass`.
- Added the supplied colour Legend photo as `assets\team\legend-colour.webp` for the visualiser.
- Added the supplied house background as `assets\images\products\obscure-glass\birkacre-house.webp`.
- Reworked the visualiser from a light transparent overlay into a split comparison: obscured view on the left, clear reference on the right.
- Added a `Change background` control that cycles between Legend and the house scene.
- Matched the Pilkington visualiser layering more closely: a blurred/brightened duplicate scene sits beneath a separate texture pattern layer.
- Switched the default preview to Cotswold and pointed it at the downloaded Pilkington `Cotswold-pilkington.png` texture.
- Replaced the pointer-follow movement with a draggable comparison slider so the interaction matches the split-preview model.
- Added mobile/tablet layouts with tappable horizontal glass controls and no hover dependency.
- Rebuilt compiled CSS/JS and verified the route, product CTA, no menu link, responsive no-overflow checks and no console errors.

## 2026-06-26 - Utility Route Cleanup

- Added a hardcoded virtual `/terms-conditions/` utility page in `inc\generated-pages.php`.
- Added `/terms-conditions/` to the custom generated sitemap virtual route list.
- Marked `/terms-conditions/` as a generated utility page in `template-parts\sections\generated-page.php` so it uses the simple utility layout.
- Removed the stale `/wcad-thank-you/` imported page from `data\pages.json`.
- Added `wcad-thank-you` to the sitemap exclusion list so the deleted route is not reintroduced through sitemap output.
- Verified `/terms-conditions/` returns `200`, `/wcad-thank-you/` returns `404`, and `page-sitemap.xml` contains `terms-conditions` but not `wcad-thank-you`.
- Clarified the then-current `/areas-we-cover/` developer review model. This was superseded later on 2026-06-29 by the customer-facing coverage page.

## 2026-06-26 - Shared Curated Review Showcase

- Added a shared hardcoded curated review showcase component in `template-parts/components/review-showcase.php`.
- Stored review excerpts in `inc\site-data.php` under `customer_reviews` so the content can later be swapped for a cached API/plugin feed.
- Used short linked excerpts from public Google/Trustpilot review sources.
- Restored the small homepage trust bar under the hero and moved the larger review widget lower, after systems/backing and before the homepage enquiry form.
- Replaced duplicated review/trust sections in generated product pages, location pages, quote page, about page, team page, contact page and windows hub with the shared component.
- Reworked the review design into a simple white Google-style widget with centred `EXCELLENT` summary and four review cards; mobile uses a native horizontal rail.
- Added three more review entries and changed the shared widget into a seven-review carousel with previous/next buttons and reduced-motion-aware auto-advance.

## 2026-06-26 - Online Quote WindowCAD Embed

- Replaced the `/online-quote/` screenshot preview with the live default WindowCAD iframe.
- Passed the default WindowCAD URL into `template-parts/sections/quote-tool.php`.
- Added `Expand view` and `Open in new tab` actions to the quote page embed.
- Added `data-lenis-prevent` and fullscreen styling so the embedded tool remains usable with smooth scrolling enabled.

## 2026-06-26 - Product Page WindowCAD Quote Embeds

- Added compact product-specific WindowCAD iframe embeds to generated product pages with matching `productCollection` URLs.
- Retargeted product-page instant quote links to jump to the embedded quote panel when a product collection is available.
- Positioned the quote embed after the main product journey content so scroll-following product video sections are not affected by the iframe height.
- Added expand-view and new-tab controls for the embedded quote tool.
- Mapped the supplied collections across uPVC windows, sash windows, aluminium windows, composite doors, uPVC doors, French doors, patio doors, bifolds, aluminium sliding doors, heritage doors, aluminium doors, slide and fold doors, replacement glazed units and secondary glazing.
- Rebuilt compiled CSS/JS and verified the mapped local product routes render the embed with the expected collection IDs.

## 2026-06-25 - Window Handle Product Sections

- Added a detailed window handle section to the shared generated product-page template.
- The section appears on the main window product routes:
  - Aluminium Windows
  - Aluminium Flush Windows
  - Heritage Windows
  - Casement Windows
  - Flush Casement Windows
  - Sliding Sash Windows
- Tilt & Turn Windows is intentionally excluded.
- Added the supplied S2 Signature finish images to the theme assets for White, Black, Chrome, Gold and Titanium.
- Reworked the handle section into a compact finish selector with swatches, active handle image/copy, three feature tiles and one static technical specification card.
- Removed the handle accordion model, egress conversion copy, monkey-tail copy, spindle length row and retrofit-ready card.
- Added structured handle data in `inc\site-data.php`, including finish options, locking, material, corrosion testing and cycle testing.
- Rebuilt compiled CSS/JS and verified the target routes render the section while `/tilt-turn-windows/` does not.

## 2026-06-25 - Enquiry Form Steps Removed

- Removed the decorative three-step "what happens next" list from the generated product/page enquiry section.
- Removed the stepped/wizard markup from the shared enquiry form so all fields are visible at once.
- Kept the shared form component and AJAX submission flow intact.
- This supersedes the earlier 2026-06-24 stepped-form experiment. Some inactive stepped-form CSS/JS selectors may still exist, but the shared PHP component no longer renders the stepped data attributes or controls.
- PHP lint passed for:
  - `template-parts\components\enquiry-form.php`
  - `template-parts\sections\generated-page.php`

## 2026-06-25 - Product Content Audit And Cleanup

- Audited the main product routes against the generated product template.
- Added missing four-tile `product_usps` data for:
  - Sliding Sash Windows
  - French Doors
  - Roof Lanterns
  - Roofline
  - Double Glazing Replacement
  - Secondary Glazing
  - Window and Door Repairs
  - Cat and Dog Flaps
- Added `product_content` overrides for product pages where aliases or template fallbacks were surfacing incorrect visible copy:
  - Aluminium Bifold Doors
  - Aluminium Flush Windows
  - Aluminium Sliding Doors
  - Cat and Dog Flaps
- Updated the generated product template to skip scraped designer, brochure, FAQ-intro, footer, social and area-list debris before building product FAQs.
- Verified the main product set now has 4 USP tiles and 5 FAQs per route in the generated data audit.
- Re-audited all 43 menu-visible routes from the header, footer and homepage links against rendered local HTML.
- Added SEO-head filtering so imported social/schema data no longer renders old designer-tool schema, `test.fensterglazing.com` JSON-LD, placeholder OpenGraph values or raw JSON social tags.
- Verified the rendered menu-visible route audit had no missing pages, no visible old scrape debris and no flagged SEO/head artifacts.
- Updated the custom sitemap generator to exclude generated pages whose imported robots value contains `noindex`, removing `/door-designer/` from `page-sitemap.xml`.
- Added temporary noindex `/areas-we-cover/` review page, linked from the header CTA, listing generated area routes by location for manual checking.
- Normalised 110 existing product + location routes onto the shared `location-service.php` layout with a hero enquiry form, product-specific copy, location-specific copy and no old designer-tool scrape text.
- Replaced uneven scraped location coverage with a deliberate product/location matrix: 13 towns x 21 sensible residential products, 273 generated URLs total. Removed category, commercial/county and other nonsensical location one-offs from the temporary area review and custom sitemap.

This file is for dated progress reports and completed-change summaries.

Do not use this as the primary rulebook or handover. Use:

- `AI.md` for coding rules.
- `HANDOVER.md` for current whole-site context.
- `HOMEPAGE.md` for homepage-specific context.

## 2026-06-24 — Documentation Restructure

- Split the project documentation into clearer responsibilities:
  - `AI.md` now contains coding rules, QA rules and implementation standards.
  - `HANDOVER.md` now contains current whole-site context.
  - `HOMEPAGE.md` now contains homepage-only source-of-truth information.
  - `PROGRESS.md` now contains dated progress reports.
- Removed the mixed progress/history blocks from the main rule and handover docs.
- Added explicit instructions at the top of each doc explaining what belongs there.

## 2026-06-24 — Mobile Design Contract

- Added a standing mobile design and implementation contract.
- Standardised expectations around:
  - `860px` breakpoint,
  - `390 x 844`, `768 x 1024` and `1440 x 900` QA,
  - single-column mobile layouts,
  - `44px` tap targets,
  - `16px` form text,
  - carousel control ownership,
  - no horizontal overflow,
  - no distorted media.

## 2026-06-24 — Integral Blinds Reveal Reverted To Full-Hero Overlay

- Reverted the attempted “below hero only” reveal model.
- Current accepted behaviour:
  - desktop reveal covers the full viewport including the hero,
  - page is locked at the top,
  - scroll opens the blinds in reverse,
  - overlay fades away,
  - normal page scrolling resumes from the top.
- Removed the zero-height gate and clip-path model from runtime code.

## 2026-06-24 — Integral Blinds Controls Copy

- Updated Integral Blinds product USP data.
- `Controls` now reads `Magnetic or electric`.
- Change made in `inc\site-data.php`.

## 2026-06-23 — Integral Blinds Reverse Scroll Reveal

- Added supplied `internal blinds.mp4` as a desktop-only scroll-controlled reveal on `/integral-blinds/`.
- Created optimised web asset:
  - `assets\videos\product-scroll\integral-blinds-chroma.mp4`
- Implemented real-time canvas chroma key for green screen `#75F94D`.
- Reversed the blind-closing footage so scrolling opens the blinds.
- Added Lenis-style eased target/current progress to avoid harsh frame jumps.
- Tuned scroll travel to about `1.55` viewport heights.
- Reduced working chroma canvas to `720 x 405` for smoother performance.
- Disabled the effect on mobile and reduced-motion.

## 2026-06-23 — Site-Wide Form Consolidation

- Replaced scattered form shells with one shared form component:
  - `template-parts\components\enquiry-form.php`
- All live customer-facing forms now use the shared component.
- Removed tiny/standalone hero callback form.
- Commercial forms use the same component with commercial arguments.
- Added AJAX submission and in-place success states.
- Preserved no-JavaScript fallback.
- Added branded responsive HTML office email.
- Default/verified recipient: `info@fensterglazing.com`.
- Leads are saved as private `fenster_enquiry` posts before email delivery.

## 2026-06-23 — Related Products And Service Areas Cleanup

- Removed the old generic related-link system that mixed scraped links into every page.
- Eliminated unrelated links such as promotional/legal pages appearing in product panels.
- Related links now come from page context and are route-checked.
- Self-links, nonexistent URLs, external promo/legal links and pagination/file debris are excluded.

## 2026-06-23 — Mobile Product Hero Redesign

- Reworked compact product heroes on mobile.
- Product photo remains visible instead of being covered by oversized buttons.
- Eyebrow/H1 sit over a lower gradient on the image.
- Actions sit in a compact tray below the photo.
- Mobile button height set to `44px`.
- Reset inherited `.button-row` margin that caused an unwanted gap.

## 2026-06-23 — Product Plaque USP Data

- Replaced generic residential product guide strip with real four-tile `Key specifications`.
- Centralised product USP data in `inc\site-data.php`.
- Added/exposed missing product routes including:
  - `/aluminium-flush-windows/`
  - `/aluminium-sliding-doors/`
  - `/slide-fold-doors/`
  - `/heritage-aluminium-doors/`
- Added new/exposed routes to navigation and selector hubs.
- Verified mapped product routes rendered four USP tiles.

## 2026-06-23 — Aluminium Door Video Reassignment

- Moved aluminium door turntable video ownership from Composite Doors to Aluminium Doors.
- `/composite-doors/` now uses its product image.
- `/aluminium-doors/` owns the travelling/docking video feature.
- Mobile keeps the video docked in the primary media position and scrubs it by page scroll.

## 2026-06-23 — Mobile Header And Tablet Breakpoint Fix

- Fixed mobile/tablet issue where header appeared to disappear and homepage looked blank/distorted.
- Root cause was inconsistent breakpoints:
  - navigation switched at `860px`,
  - homepage mobile replacement previously switched lower.
- Standardised the homepage mobile replacement at `860px`.
- Made small-screen header fixed and composited.
- Hid desktop sticky product theatre at mobile/tablet widths.

## 2026-06-22 — Homepage Mobile Spacing Audit

- Established mobile section spacing by visible component joins instead of blanket section padding.
- Grouped carousel cards and dots in shared wrappers.
- Attached carousel dots visually to their carousels.
- Approved mobile joins:
  - product carousel to instant quote: `24px`,
  - proof carousel to systems/backing: `16px`,
  - systems/backing to contact: `32px`,
  - contact form to areas panel: `24px`,
  - areas panel to footer: `28px`.

## 2026-06-22 — Homepage Desktop Spacing Audit

- Audited homepage desktop spacing at normal viewport scale.
- Established desktop rhythm around meaningful content boundaries.
- Preserved deliberate product-theatre-to-quote overlap.
- Corrected product theatre layout to use capped image row and centred complete composition.
- Rejected stretching media to fill tall sticky stages.

## 2026-06-19 — Broad Site Rebuild Context

- Continued custom WordPress theme rebuild based on imported/generated data.
- Established code-driven approach rather than ACF/page-builder editing.
- Expanded generated-page templates, navigation, footer, homepage and product page systems.
- Preserved SEO coverage while replacing visibly broken or generic imported layouts.

## 2026-06-24 - Homepage Gradient Continuity

- Removed the duplicate `--fg-page-gradient` paint from the homepage product-flow wrapper so the page below the hero uses one continuous anchored background.
- Added mobile-only homepage gradient variables at `860px` and below to reduce green/blue intensity and increase the white wash.
- Verified `390 x 844`, `768 x 1024` and `1440 x 900` renders had no horizontal overflow or console errors.

## 2026-06-24 - Enquiry Form Steps

- Updated the shared enquiry form component to present four progressive steps with JavaScript active: project, contact, email/location and final details/privacy.
- Kept no-JavaScript behaviour as a complete normal form using the same shared fields and handler.
- Added step controls, progress text/bar and per-step validation before continuing.

## 2026-07-15 - Constructionline Gold Guidance

- Added a dedicated `/constructionline-gold/` page explaining Fenster's Constructionline Gold membership in plain language for commercial clients.
- Clearly distinguishes supplier pre-qualification from project-specific certification, warranties and Building Regulations paperwork.
- Linked the Constructionline Gold footer badge to the new page.

## 2026-07-15 - SSIP Health And Safety Guidance

- Added a dedicated `/ssip-health-and-safety/` page that explains SSIP health and safety assessment and mutual recognition without presenting it as a product warranty or project-specific approval.
- Linked the SSIP footer badge to the new page.

## 2026-07-15 - Accreditation Page Message Structure

- Standardised the FENSA, CPA, GGF, Constructionline Gold and SSIP pages around three customer questions: what it is, how it works with Fenster and what it means for the visitor or project.

## 2026-06-29 - Contact Page Compact Pass

- Tightened `/contact/` hero, contact dock and section padding to match the quieter quote/team page rhythm.
- Removed the hidden broken contact-methods block from the contact template instead of leaving it suppressed by CSS.
- Kept one continuous page gradient across the contact page.
- Hid the repeated showroom desk panel on mobile; phone, email and quote remain in the mobile contact dock, with full showroom details in the map section.
- Rebuilt compiled CSS/JS and verified `390 x 844`, `768 x 1024` and `1440 x 900` screenshots with no horizontal overflow or console errors.

## 2026-07-16 - Sliding Sash Product Journey And Footer Pass

- Rebuilt `/sliding-sash-windows/` around a shorter, visual purchase journey shared across mobile and desktop.
- Replaced the long mobile product stack with a viewport-contained three-model carousel and retained a three-column desktop comparison.
- Enlarged the Ultimate, Heritage and Charisma Rose product renders and added meeting-rail detail insets.
- Simplified the model comparison data and corrected the Charisma Rose thermal option.
- Added a six-image real-installation gallery using visually approved Roseview assets and responsive WebP sources.
- Added a post-gallery quote/consultation prompt and removed repeated generic product sections from this page.
- Replaced the old furniture catalogue with an interactive Globe/Acorn lock and finish selector derived from the Rose Collection furniture guide.
- Added the supplied Rose Collection furniture PDF as a downloadable page resource.
- Added sash-specific FAQs, a compact mobile quote action, a sash-specific enquiry form and a sash-installation review first in the review rail.
- Reworked the mobile footer trust bar into a consistent two-column grid.
- Added Fenster Instagram, Facebook and LinkedIn links to the footer.
- Rebuilt compiled CSS/JS and verified the protected test page at `390 x 844`, `768 x 1024` and `1440 x 900` with no horizontal overflow; verified selector state changes, social URLs, PDF/image delivery and responsive asset delivery.
- Test deployment only; no live-site deployment was performed.
- Follow-up: removed the customer-facing furniture PDF download, eagerly loaded the 69 KB furniture image set and fixed the responsive image-stage height so finish changes cannot cause mobile layout shift.
- Added `SASH-PAGE-REDESIGN.md` documenting the design strategy, implementation and reusable QA method.
- Follow-up: replaced the sash hero with a visually approved Roseview bay-window photograph and responsive 480/960/1920 WebP sources, with product-specific desktop/mobile crops.
- Removed the generic frame-colour panel from the sash page because the Roseview range differs; retained privacy glass and the dedicated furniture selector.
- Replaced the inaccurate `Colour choice / Full RAL range` hero specification tile with `Sash models / 3 Rose options`.
