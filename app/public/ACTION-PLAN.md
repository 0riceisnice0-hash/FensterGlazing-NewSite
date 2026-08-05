# Fenster Glazing — Content, Imagery, Design & SEO Action Plan

Date: 2026-07-16
Scope: full review of live site output, theme code, `data/pages.json` copy sources, git history and project docs. This is the post-launch quality plan; it assumes the technical/SEO launch hardening in `AUDIT.md` is done and holding.

## Evidence base

- All project docs read (`AI.md`, `HANDOVER.md`, `LIVECHANGES.md`, `STYLE.md`, `AUDIT.md`, `PROGRESS.md`).
- Git history reviewed; local `main` is clean and in sync with GitHub. Recent work is almost entirely Legend chat (now visible on live pages).
- Live crawl of 12 representative pages at `1440x900` and `390x844` via CDP headless Chrome with full-page screenshots, rendered text extraction, heading maps and layout metrics.
- Theme image pools inspected visually (actual image files opened, not just filenames).

Verified healthy while auditing: zero horizontal overflow on any tested page at 390px, one H1 per page, clean canonicals, unique titles, repo scoped and synced. The problems below are content, imagery and composition, not plumbing.

### Page metrics from the live crawl

| Page | Words | Meaningful images | Mobile page height | Read |
|---|---|---|---|---|
| `/sliding-sash-windows/` | 1,818 | 19 | **21,488px (~25 phone screens)** | Wall of text on mobile |
| `/composite-doors/` | 1,446 | 23 | 17,294px | Long but better image rhythm |
| `/upvc-doors/` | 1,231 | 16 | 14,983px | Wrong images, self-describing copy |
| ~~`/casement-windows/`~~ | ~~1,132~~ | ~~**8**~~ | ~~14,022px~~ | **Superseded by the 2026-08-04 rebuild — see below** |
| `/casement-windows/` (rebuilt, on test at `e697b12`) | 2,715 | 44 | **22,283px (~26 phone screens)** | Now the longest page on the site |
| `/double-glazing-bletchley/` (matrix example) | 1,115 | 6 | 11,984px | 1,100 words, 6 images |
| `/contact/` | 723 | **1** | 7,086px | Contact hub has almost no imagery left |
| `/windows-milton-keynes/` | 565 | 10 | 5,960px | Thin for a money page |
| `/book-a-consultation/` | 589 | 1 | 4,768px | OK (approved composition) |

**The casement row was re-measured on 2026-08-05 and it inverts this table's
worst case.** The rebuild answered the owner's brief — more imagery, a car
maker's register, versatility and EnergyPlus and security each given room — and
the cost is length: 22,283px at 390px wide, past `/sliding-sash-windows/` and
onto the top of this list, on the site's most-viewed page. Two cautions before
anyone acts on point 4 below. The image counts are **not** comparable: the
original column was a hand-picked "meaningful images" judgement and 44 is every
`<img>` inside `.fg-cas`, which includes the colour and handle grids. And the
length is the brief, not an accident — the owner rejected a shorter, more
interactive version of this page on 2026-08-04. Condensing it is an owner
decision, not a tidy-up. Measured with the harness in `nick.md`; headless
Chrome clamps at 500px, so this is through a 390px iframe.

---

## Theme 1 — Copy rewrite programme (biggest problem, biggest win)

The copy fails in four repeatable ways, and because most of it comes from **shared template strings**, fixing one string fixes 25+ pages at once.

### 1a. The template talks about the website, not the product

Live examples from `/upvc-doors/`:

- "Every image is chosen to show this product family clearly." — [generated-page.php:3068](wp-content/themes/fenster/template-parts/sections/generated-page.php:3068)
- "Move from the product into the details that make it yours." — [generated-page.php:3081](wp-content/themes/fenster/template-parts/sections/generated-page.php:3081)
- "Choose your colours, privacy glass and hardware in three quick guides; each one helps narrow the detail before survey." — [generated-page.php:3082](wp-content/themes/fenster/template-parts/sections/generated-page.php:3082). **Also a bug: door pages render only two cards, the "three" is hardcoded.**
- "Installed examples and close-up frame details." / "Useful for comparing frame depth, glass area, opening style and colour direction." — gallery bullets describing what a gallery is for.
- "Choose the handle finish with the door, not after it." / "…gives a practical set of finish directions…" — designer-speak.

Fix: rewrite every shared section heading/intro to state a customer truth ("Colours, glass and handles you can pick from", "uPVC doors we have fitted locally"), and delete bullets whose only job is to explain the section. One pass through `generated-page.php` covers every product page.

### 1b. Third-person "Fenster" voice, violating STYLE.md's own we/you rule

Sitewide shared strings: "Tell Fenster what you want to change…" ([generated-page.php:827](wp-content/themes/fenster/template-parts/sections/generated-page.php:827), [:2614](wp-content/themes/fenster/template-parts/sections/generated-page.php:2614)), "Fenster keeps the process simple…" ([:777](wp-content/themes/fenster/template-parts/sections/generated-page.php:777)), "Fenster supports the installation…", "Tell Fenster what you are looking for." (online quote), "Build a window online, then let Fenster check the details." (windows MK), plus dozens of `product_content` entries in `inc/site-data.php` ("Fenster specifies Liniar door systems around…"). STYLE.md already mandates we/our/you; the templates predate the rule. One sweep: replace third-person Fenster with we/us across `generated-page.php`, `site-data.php` `product_content`, and the quote/location templates.

### 1c. Supplier-citation phrasing exposed to customers

`/sliding-sash-windows/` furniture section reads like research notes: "The Globe range **is described by Roseview as**…", "**Roseview lists** Acorn furniture as standard…", "**The Roseview options page also lists**…", "**Roseview states that** windows under 700mm…". Rewrite as direct statements ("Ultimate Rose windows come with the premium Globe furniture set…"). STYLE.md already bans mirroring supplier sourcing; this page slipped through.

### 1d. Copy that answers no customer question

Matrix pages (e.g. Bletchley) run ~1,100 words of abstract specification talk ("The details that make double glazing work properly", "Measured, specified and fitted with care") with no prices context, no timescales, no local jobs, no reasons to pick Fenster over the national brands. Rewrite the matrix copy templates around what a homeowner actually asks: what does it roughly cost, how long does it take, what happens at survey, have you worked near me. Same for `/windows-milton-keynes/` (565 words is thin for the #1 money page — this also serves the existing GSC priority in `AI.md`).

**Order of attack:** shared template strings first (one file, 25+ pages) → `product_content` intros/benefits in `site-data.php` → money pages → matrix templates → hubs/articles.

---

## Theme 2 — Photography accuracy programme

Confirmed the reported problem and found it is worse than described. The `/upvc-doors/` image pool (`upvc_doors` in [site-data.php:635](wp-content/themes/fenster/inc/site-data.php:635)):

- `fenster-upvc-door.jpg` (hero) and `Residential_Door_08.jpg` are **the same photo** — it renders twice on the page, and the door is a cottage-style slab that reads composite, not uPVC.
- `Residential_Door_01.jpg` — black door, looks composite.
- `new-front-door-in-Milton-Keynes.jpeg` — a **painted timber door on a period cottage** (stock photo).
- `secure-front-door.jpeg` — an obvious **CGI render**, not a real installation.
- `fenster-cat-flap-glass.jpg` — **a photo of a cat** next to a cat flap, rendering in the uPVC Doors product gallery directly beneath the bullet "Every image is chosen to show this product family clearly."
- Several alt texts assert "uPVC residential door" on images that are not uPVC — the alt text is actively wrong, which is both a trust and an SEO problem.

Plan:

1. **Image audit table.** Walk every pool in `inc/site-data.php` (`product_media`, `product_gallery_pools`) the way `/upvc-doors/` was walked here: open each file, classify as right-product / wrong-product / stock / render / duplicate. (The 2026-07-09 "Fix product image gallery pools" pass fixed cross-contamination between pools but never verified the images inside each pool are the right product.)
2. **Remove wrong images immediately, even if galleries shrink.** The template already skips gallery moments when there are not enough unique images — a 2-image honest gallery beats a 4-image wrong one. Pull the cat photo back to `/cat-and-dog-flaps/` only.
3. **Build a real photo pipeline.** The reviews prove installs are happening weekly (Shane, James, Tom, Radu are named by customers). Give fitters a 5-shot checklist per job (straight-on exterior, interior, handle/lock close-up, open position, street context). This is the only durable fix for "60/40" and for matrix-page local proof.
4. **Short-term gap fill from the supplier libraries already licensed/scraped** — Liniar has genuine uPVC door photography; the theme already uses Liniar assets elsewhere. Rename files and rewrite alt text honestly.
5. **Alt-text truth pass** at the same time as the audit.

---

## Theme 3 — 60/40 text-to-image rebalance + mobile length

The product template front-loads its images (hero, product info, hub, gallery all in the top 40%) and then runs six consecutive text-only sections (specification choices → handles → FAQs → process rail → quote embed → enquiry form → related links). Casement: 1,132 words, 8 images. Matrix pages: worse. **This no longer describes `/casement-windows/`**, which was rebuilt on 2026-08-04 off the shared product template and interleaves its imagery all the way down; it does still describe the rest of the product set and the matrix pages.

Actions, in order of impact:

1. **Deduplicate before decorating.** Much of the length is repetition, not information (see Theme 4 for the sash page). Cutting repeated sections improves the ratio without needing a single new photo.
2. **Compress the shared back half.** The order-process rail (4 numbered cards + heading + CTA) says nothing product-specific and appears on every page; make it a compact strip. The "Specification choices" cards can be one row. FAQ answers can stay but with tighter intros.
3. **Add one image moment in the back half** once accurate photos exist (an installed shot beside the FAQs or process strip), so pages do not end with ~8 screens of unbroken text.
4. **Mobile-specific condensing for the worst pages** (casement 22.3k px as rebuilt, sash 21.5k, composite 17.3k, uPVC doors 15k — target roughly half, but see the note under the table: casement's length is the owner's brief and shortening it is his call): comparison tables become swipeable/toggle components rather than stacked cards; furniture/hardware card sets become a single rail; related-links band shows fewer items behind a "More areas" toggle.
5. `/contact/` has one image left (tiny showroom strip); restore the showroom photo as a real visual anchor.

---

## Theme 4 — `/sliding-sash-windows/` restructure + the 3-page SEO question

### The structural problem

The page is currently **two product pages stacked on top of each other**: the Roseview-specific build (model cards, comparison table, sightline/joint details, furniture) *followed by the full generic product journey* (Product information + 5 benefit cards, "More information on Sliding Sash Windows" hub, product view cards) which re-explains the same things generically. "Sliding Sash Windows" appears as a heading 5 times. That, not the Roseview content, is why mobile is 25 screens long.

Fix: treat the Roseview half as *the* page. Delete or fold the generic sections whose content the Roseview sections already cover (the 5 generic benefit cards, the generic product-view cards duplicating model/operation/furniture). Keep: key specs strip, model comparison, visible-differences details, furniture (condensed to one rail), FAQs, quote embed, form. Estimated cut: ~40% of page length with zero information loss.

Also fix on this page:

- **Spec contradiction:** the Key Specifications strip says "A+ rated" while the comparison table says "A rated" for all three models (Roseview publishes A-rated/1.5 W/m²K as standard, with upgrade options). Pick the substantiated value once.
- Supplier-citation phrasing (Theme 1c).
- "Full RAL range" colour claim — verify against what Roseview actually offers on each model before keeping it in the USP strip.

### One page or three?

**Recommendation: keep one page. Do not split into Ultimate/Heritage/Charisma pages now.**

- The search demand is on generic intent ("sliding sash windows", "uPVC sash windows", "sash windows milton keynes", "sash window prices") — all of which this single page plus the existing `/sash-window-prices/` pricing route already target. Splitting spreads internal authority across four URLs competing for the same head term.
- The model names are Roseview's brand terms. Those SERPs are owned by [roseview.co.uk](https://www.roseview.co.uk/) and trade directories ([SpecifiedBy](https://www.specifiedby.com/roseview-windows/ultimate-rose-sash-windows), NBS Source); an installer's model page would fight the manufacturer for modest volume.
- Google is still settling post-launch (per the 2026-07-13 GSC baseline); adding three near-duplicate product pages during that evaluation is the wrong moment.

**Cheap hybrid that captures most of the upside:** give each model card a stable anchor (`#ultimate-rose`, `#heritage-rose`, `#charisma-rose`), mention each model name in an H3 (already close), and add `Product` structured data per model. Revisit dedicated child pages only if (a) GSC later shows real query volume for the model names, and (b) each page can carry unique installed photos/case studies — otherwise they will be thin.

**The better use of that SEO effort** (already flagged in `AI.md`, still open): `/french-casement-windows/` CTR fix (position 3.5, 0.19% CTR), `/what-are-double-glazed-glass-windows/` intent ownership (17.9k impressions, 0.06% CTR), and strengthening the three MK money pages. Those have measured demand today; sash model pages do not.

---

## Theme 5 — Menu, navigation and small design fixes

1. **"Explore" / "Quick start" mega-menu badges are swapped** (exactly as suspected). They are hardcoded CSS `content` in [main.scss:752](wp-content/themes/fenster/src/scss/main.scss:752) ("Explore" on the *first* CTA = Get an instant quote) and [main.scss:770](wp-content/themes/fenster/src/scss/main.scss:770) ("Quick start" on the *second* = Book a consultation). Swap them — or better, drop the pseudo-element trick and render the badge text from the CTA data in `site-data.php` so it can never desync again.
2. **"three quick guides" count bug** — [generated-page.php:3082](wp-content/themes/fenster/template-parts/sections/generated-page.php:3082): door pages show two cards. Remove the number or count the cards.
3. **Lowercase "upvc doors" in gallery copy** — [generated-page.php:556](wp-content/themes/fenster/template-parts/sections/generated-page.php:556) uses `strtolower($title)`, destroying brand casing (uPVC → upvc). Use the title as-is or a proper lowercase map.
4. **Duplicate H2s that repeat the H1** — product pages render "uPVC Doors" as H1 plus two more identical H2s (key specs + product info). Differentiate or demote to styled `<p>` (also flagged in the old audit §6.11, still live).
5. **Review card date formats still mixed** — `2025-06-12` (Google) vs `4 Nov 2025` (Trustpilot) side by side in the shared showcase (old audit §5, still live). Normalise; and the newest curated review is Nov 2025 — 8 months stale on a site that claims weekly installs. Refresh the set quarterly as planned.
6. **Weak scrape-era meta descriptions on core products:** `/upvc-doors/` = "View our uPVC doors. We supply double glazed doors across…", `/casement-windows/` = "Learn about our casement windows…". Complete sentences (so they survived the length pass) but poor CTR copy next to the rewritten pages. Rewrite the top ~10 product metas for benefit + location + proof.
7. **Contact H1 "How do you want to start?"** — friendly but says nothing to a first-time visitor or to Google. "Contact Fenster Glazing in Milton Keynes" with the route-choice as supporting copy would serve both.
8. **Legend launcher overlap** — on desktop the cat + "Need a hand?" bubble sits over hero CTAs/cookie controls on several pages at 1440x900. Nudge its resting position clear of interactive hero content.
9. **Footer claim "Phone lines open 24/7"** next to "Monday to Friday, 8.30am to 5pm" — verify the answering service is real (old audit flag, still unresolved); if it is, say what it is ("24/7 answering service"), if not, remove.
10. **`/online-quote/` renders zero images** and the H2 "Tell Fenster what you are looking for" (third person again). Low priority, but it is the most-linked conversion page.

---

## Prioritised roadmap

### Week 1 — quick fixes (each under an hour, mostly one-liners)

1. ✅ Done 2026-07-16 — menu badges are now data-driven (`badge` field on the nav CTAs in `site-data.php`) and correctly assigned: Instant quote = "Quick start", Book a consultation = "Explore".
2. ✅ Done 2026-07-16 — "three quick guides" count removed; gallery copy keeps proper product casing (no more "upvc doors").
3. ✅ Done 2026-07-16 — `upvc_doors` pool curated: cat photo, CGI render, timber cottage door, timber colour collage and duplicate hero removed; two genuine Liniar uPVC door renders added (from the reserved `liniar-door` set); all alt text rewritten honestly.
4. ✅ Done 2026-07-16 — sash USP strip now says "A rated", matching the comparison table and Roseview's published standard rating; benefit card updated to match.
5. ✅ Done 2026-07-16 — sash furniture copy rewritten in direct voice; no "described by Roseview / Roseview lists / Roseview states" phrasing remains.
6. ✅ Done 2026-07-16 — review dates normalised to `j M Y` in `review-showcase.php` (component-level, so future data in either format renders consistently).
7. ✅ Done 2026-07-16 — `/upvc-doors/` and `/casement-windows/` added to `fenster_gsc_seo_overrides()` with rewritten titles and meta descriptions.
8. ❌ Retracted — Legend's launcher is `position: fixed; bottom: 0; right: 0`; the apparent hero overlap was a full-page screenshot artifact (fixed elements paint at odd offsets in `captureBeyondViewport` shots). No change needed.
9. ✅ Resolved 2026-07-16 — owner confirmed a real 24/7 answering service exists; the footer claim stays as written.

### Weeks 2–3 — shared copy + image audit

10. ✅ Done 2026-07-16 — shared template strings rewritten in we/you voice across `generated-page.php`, `quote-tool.php`, `windows-hub.php`, `home-experience.php`, `about.php`, `contact.php`, `price-guide.php`, `consultation-booking.php` and the enquiry form; self-describing gallery bullets removed; "Move from the product..." and door-handle headings replaced with customer-truth headings. Brand-named "Fenster" deliberately kept where it earns its place: the trust page, About-page process/eyebrows, the accreditation trust strip, commercial county intros and "the Fenster quote tool".
11. ✅ Done 2026-07-16 — all 98 unique pool images audited (individually viewed). Removed: a duplicate sash photo, two US stock interiors from the aluminium windows pool, three duplicate CGI courtyard renders and a duplicate CGI kitchen in the door pools, a wrong-product steel-look render from the sliding pool, a garden shot posing as a casement window, and a French window from the French doors pool. Promoted real install photos to the bifold and casement heroes, moved the Liniar 7016 patio shot to the uPVC patio pool, and rewrote every dishonest alt (no more false "installed in [town]" claims). Known remaining gaps are listed in `PHOTO-CHECKLIST.md`.
12. ✅ Done 2026-07-16 — fitter photo checklist created (`PHOTO-CHECKLIST.md`) with a 5-shot per-job routine and a wishlist covering the gaps the audit could not fill from honest assets (real uPVC door installs, aluminium windows, secondary glazing).

### Weeks 3–4 — structure and balance

13. Restructure `/sliding-sash-windows/`: merge the duplicated journeys, condense furniture, mobile-condense the comparison (Theme 4). This is the template for de-duplicating the other long product pages.
14. Compress the shared back half of the product template (process rail, spec choices) and add one back-half image moment (Theme 3).
15. Rewrite `product_content` intros/benefits per product in we/you voice with real decision info (1b, 1d).
16. Strengthen `/windows-milton-keynes/` and the matrix copy templates with cost/timescale/local-proof answers (1d) — dovetails with the existing GSC priority plan.

### Ongoing

17. SEO effort goes to the measured GSC opportunities (French casement CTR, double-glazed-glass intent page, MK money pages) — not sash model pages. Re-check sash model query volume in GSC in ~2 months before reconsidering the 3-page split.
18. Quarterly review-content refresh; photo pipeline review after the first 10 jobs.
