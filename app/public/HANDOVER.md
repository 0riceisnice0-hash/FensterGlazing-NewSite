# Fenster Glazing Handover

Last updated: 2026-07-06

This file gives a new AI agent the current context needed to work on the whole site.

Use:

- `AI.md` for coding rules and QA standards.
- `AUDIT.md` for the 2026-07-03 master site audit, launch-blocker remediation status and remaining backlog.
- `STYLE.md` for site-wide visual styling, continuous background rules, section rhythm and mobile design expectations.
- `HOMEPAGE.md` for homepage-specific design and implementation context.
- `PROGRESS.md` for dated progress reports.

## Important Updates

- GitHub is live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. It versions the custom theme and docs only, not the full WordPress install.
- Local development uses the standard WordPress path `wp-content\themes\fenster`, but SiteGround test/live are verified Bedrock installs. Server theme paths are `~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/` and `~/www/fensterglazing.com/public_html/web/app/themes/fenster/`.
- Deployment should update the `fenster` theme from the GitHub repo while leaving production `.env`, Bedrock config, uploads, database and plugins untouched. Do not deploy `wp-content\fenster-reference`; it is a local-only scrape archive and no runtime code should depend on it.
- Test and live are both running the new `fenster` theme. Keep using the same workflow for changes: local edit -> GitHub -> test deploy -> verify -> fresh live backup -> live deploy -> short post-live check.
- Do not use SiteGround clone/staging tools for this project. The safe model is local -> GitHub -> test -> verify -> backup -> live. This avoids editing test and live at the same time and avoids accidental database URL rewrites.
- Generated pages are theme-owned for SEO. Yoast/Rank Math public head output is suppressed on generated pages to prevent duplicate metadata and stale imported schema/social tags. Do not reset Rank Math for launch; use it only later if there is a clear admin-tool reason.
- Launch SEO hardening is complete for the current technical blockers: homepage title/meta override, generated route 301 normalisation, generated breadcrumb schema, public cache headers, sitemap scrub to 427 URLs, `/commercial-areas/` removed from the header, and footer links to `/areas-we-cover/` and `/terms-conditions/`.
- The residential location matrix has unique generated metadata across the 13 town x 21 product pages. Commercial county metadata is profile-specific, and Isle of Wight commercial glazing has been removed/410'd as inaccessible coverage.
- Mobile launch fixes are complete for the About process cards, Contact page CTA cards and quote-tool controls. Mobile quote embeds use one same-tab `Open quote tool` action; desktop keeps `Expand view` and `Open in new tab`.
- Test and live enquiry delivery have been verified: valid submissions save as private `fenster_enquiry` posts and send office HTML emails to `info@fensterglazing.com`.
- Office email delivery currently uses the old proven envelope: `WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`. Customer confirmation emails are paused unless authenticated SMTP is configured, so public form copy must not promise a confirmation email.
- Enquiry forms support optional file uploads (`attachments[]`) for photos, drawings, schedules and documents. Files are stored against the private enquiry and attached to the office email.
- Live mail deliverability still needs authenticated SMTP for future customer-facing sends. The mailbox MX is Microsoft 365, and unauthenticated PHP mail can show Outlook verification warnings. The theme supports `FENSTER_SMTP_HOST`, `FENSTER_SMTP_PORT`, `FENSTER_SMTP_USERNAME`, `FENSTER_SMTP_PASSWORD`, `FENSTER_SMTP_SECURE`, `FENSTER_MAIL_FROM` and `FENSTER_MAIL_FROM_NAME` from Bedrock `.env` or PHP constants.
- Residential case studies are intentionally hidden for launch. `/case-studies/` and the known residential child case-study routes return 410 and should stay out of menus/sitemaps until that content is rebuilt. Commercial project records under the old case-study URL family remain reachable because `/commercial-projects/` uses them as proof.
- Current phone QA backlog is product-template/mobile focused: `/casement-windows/` has common-choice/product-view overflow that creates sideways page scroll; `/colour-options/` should drop/simplify the hero image on mobile; `/sliding-sash-windows/` needs a mobile redesign for Roseview model stats, corner details and comparison imagery; product hub logos need calmer sizing; product controls need to make extra options obvious.

## Current Goal Of The Site

Fenster Glazing is being rebuilt as a custom, code-driven WordPress theme. The site should feel polished, premium and practical for real customers, while preserving SEO coverage from the imported/generated pages.

The site is not meant to become an Elementor/ACF build unless the owner explicitly changes direction.

## Local Environment

- Site root: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public`
- Local URL: `http://fenster-glazing.local/`
- Active theme: `wp-content\themes\fenster`
- Main theme directory: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster`

Build command from the theme directory:

```powershell
npm.cmd run build
```

PHP lint:

```powershell
& 'C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe' -l '<changed php file>'
```

## SiteGround Launch Workflow

Current server reality:

- SSH host: `ssh.fensterglazing.com`, port `18765`, user `u453-m73mh4m4wev2`.
- Repo cache on server: `~/repos/FensterGlazing-NewSite`.
- Test root: `~/www/test.fensterglazing.com/public_html`.
- Live root: `~/www/fensterglazing.com/public_html`.
- Bedrock theme folder on both: `web/app/themes/fenster`.

Accepted deploy model:

1. Make code changes locally in `C:\Users\zacpl\Local Sites\fenster-glazing`.
2. Run the relevant build/lint checks.
3. Commit and push to GitHub.
4. Pull/reset the server repo cache to GitHub `main`.
5. Rsync only `app/public/wp-content/themes/fenster/` into the test Bedrock theme folder.
6. Verify test visually and technically.
7. Before live, take a fresh SiteGround backup and get explicit owner approval.
8. Rsync the same theme folder into the live Bedrock theme folder, activate/keep `fenster`, clear cache, and verify key routes/forms.

For future live changes, use the same route. Do not edit live files directly except for a genuine emergency, and if that happens, copy the emergency fix back into GitHub immediately.

## Main Theme Map

- `style.css` — WordPress theme metadata.
- `functions.php` — theme bootstrap.
- `inc\assets.php` — asset registration, generated asset helpers and video asset URLs.
- `inc\generated-pages.php` — generated/virtual page routing.
- `inc\site-data.php` — shared navigation, product data, brand data and USP data.
- `inc\enquiries.php` — enquiry post type and form handling.
- `template-parts\sections\generated-page.php` — main generated page/product/location template.
- `template-parts\sections\home-experience.php` — homepage template.
- `template-parts\components\enquiry-form.php` — one shared live form.
- `template-parts\layout\site-header.php` — header/navigation.
- `template-parts\layout\site-footer.php` — footer.
- `src\scss\main.scss` — source styling.
- `src\js\main.js` — source interactions.
- `assets\css\main.css` — compiled CSS.
- `assets\js\main.js` — compiled JS.
- `data\pages.json` — imported/generated page data.

## Architecture Principles

- The site is code-driven and hardcoded through the theme.
- Shared data belongs in `inc\site-data.php`.
- Generated content comes from `data\pages.json` plus explicit virtual routes.
- Shared UI should be implemented once and reused.
- Visual work must follow `STYLE.md`, especially the continuous page background rule.
- Mobile and desktop must be designed together.
- Desktop-only cinematic effects need mobile/reduced-motion fallbacks.
- Product + location generated routes use the central matrix in `inc\generated-pages.php`: 13 towns x 21 sensible residential products. They render through `template-parts\sections\location-service.php` with product/location-specific copy and a hero enquiry form. Keep these pages on that shared template rather than reviving scraped per-page layouts.

## Current Navigation

Navigation data is centralised in `inc\site-data.php`.

Desktop and mobile navigation should share the same source data so links do not drift.

Top-level navigation currently covers:

- Products
- Commercial
- About Us
- Contact
- Instant Quote

Mobile navigation activates at `860px` and below. Future work should keep the mobile header, mobile navigation, CSS replacements and JavaScript breakpoint logic aligned at `860px`.

## Generated Pages And Routing

Generated pages are driven by `data\pages.json`.

Important runtime pieces:

- `inc\generated-pages.php`
- `template-parts\sections\generated-page.php`

Generated pages preserve SEO coverage while applying the new shared visual template. Related links are context-aware and route-checked; do not restore scraped footer/legal/promo links into related-link panels.

Imported SEO data is filtered before rendering. The head output should not include old designer-tool schema, `test.fensterglazing.com` JSON-LD, placeholder OpenGraph values such as `0`/`1`, raw JSON blobs in social tags or inherited alias-page social URLs.

Structured data is generated, not imported: a site-wide LocalBusiness block from `fenster_render_site_schema()` and per-product `FAQPage` JSON-LD in the product journey template. Imported `schema_json_ld` is never rendered.

Debris routes are handled centrally in `inc\generated-pages.php`: test pages return 410, duplicate town slugs and all `*-designer` pages 301 to their real targets, and ad landers, thin utility/scrape shells, `category/`, `tag/`, `author/` and `blog/page/` archives carry `noindex,follow`. The custom sitemap at `/sitemap.xml` (advertised in robots.txt; core `wp-sitemap.xml` is disabled) skips all of those routes.

Imported blog posts and guides render through `template-parts\sections\generated-article.php` (readable article layout with a compact enquiry CTA). Product/commercial routing uses explicit slug whitelists in `template-parts\sections\generated-page.php`, not slug-substring matching.

Virtual or explicitly exposed product routes include products such as:

- `/aluminium-flush-windows/`
- `/aluminium-sliding-doors/`
- `/slide-fold-doors/`
- `/heritage-aluminium-doors/`

Utility and special routes:

- `/terms-conditions/` is a hardcoded virtual utility page in `inc\generated-pages.php` and renders through the generated simple utility layout.
- `/why-trust-fenster/` is a hardcoded virtual trust page in `inc\generated-pages.php`. It renders through `template-parts\sections\trust-page.php`, reuses the shared review showcase and is promoted by a small centred link beneath the homepage trust cards.
- `/obscured-glass/` is a hardcoded virtual product-adjacent page in `inc\generated-pages.php`. It is intentionally not in the menu; product journey pages link to it from the `Gallery and choices` / finish options card.
- `/obscure-glass/` 301 redirects to `/obscured-glass/`; use "obscured glass" in visible copy, while the legacy asset/data key and folder remain `obscure_glass` / `assets\images\products\obscure-glass`.
- `/colour-options/`, `/upvc-colours/` and `/aluminium-colours/` are hardcoded virtual product-adjacent pages in `inc\generated-pages.php`. They are intentionally specification hubs rather than menu-level product pages; product journey pages link to the colour hub from the specification choices section.
- `/commercial-glazing-buckinghamshire/` is a hardcoded virtual commercial page in `inc\generated-pages.php`.
- `/commercial-projects/` is a hardcoded virtual commercial page in `inc\generated-pages.php`.
- `/privacy-policy/` and `/cookie-policy/` come from generated/imported page data and render through the generated simple utility layout.
- `/areas-we-cover/` is a customer-facing local coverage page. It is not linked from the header menu; the About page and footer link to it. It groups generated area routes by town for customers who want to check local services.
- `/wcad-thank-you/` has been removed from `data\pages.json` and excluded from the custom sitemap. Do not restore it unless a fresh thank-you journey is explicitly requested.

## Product Page Template

Most residential product pages use `template-parts\sections\generated-page.php`.

Current product page model:

- Hero with primary CTA linking to the enquiry form and secondary CTA linking to the in-page instant quote embed when a product collection exists.
- Four-tile `Key specifications` strip using `inc\site-data.php` product USP data.
- Manufacturer/product hub badges, system data, spec tabs and choice strips from `inc\product-hub-data.php`.
- Optional product-specific WindowCAD quote embed placed after the main product journey/trust/accreditation content.
- Product narrative/content sections from generated data.
- A compact `Specification choices` section linking to focused colour, privacy-glass and hardware decisions.
- Shared enquiry form.
- Context-aware related products/service areas.

Current mobile QA notes from live phone review:

- On `/casement-windows/`, the top product page content is broadly good, but there is too much vertical space between "Why choose this product" and the product information hub.
- Product hub logos such as Liniar and Energy Plus appear much larger than the A+ rated and PAS 24 proof options. Keep supplier/proof badge sizing visually balanced on mobile.
- The common-choice/product-view control section can break out of its frame and cause full-page horizontal scrolling. This is a priority fix before deeper polish.
- Product-view controls are not intuitive enough when there are more than two options. Add clearer affordance such as dots, count text, visible partial next card, labelled tabs, or a better stacked mobile model.

The old product-page mini-gallery above the colour choices has been removed. It was fed by imported `images` arrays from `data\pages.json`, including old copied stock uploads such as `stock-04.jpg` and `stock-05.jpg`. Product pages should not revive that scraped gallery rail; use curated hero/feature media and the specification hubs instead.

Product USP rules:

- Data lives in `inc\site-data.php` under `product_usps`.
- Curated visible copy/FAQ overrides live in `inc\site-data.php` under `product_content`.
- Do not invent U-values or unsupported specifications.
- Composite Doors and Integral Blinds currently do not display invented U-values.
- Integral Blinds controls are `Magnetic or electric`.
- Generated product FAQs should skip scraped designer, brochure, FAQ-intro, footer, social and area-list debris before rendering.

### Product Quote Embeds

Product-specific WindowCAD quote embeds are mapped in:

`template-parts\sections\generated-page.php`

The embed section id is:

`#fenster-product-quote`

Current accepted behaviour:

- Product-page instant quote links jump to the in-page embed when a matching `productCollection` exists.
- The embed sits after the main product journey sections, including trust/accreditations, so scroll-following product video sections are not disturbed.
- The embed is intentionally compact, not a full-height page takeover.
- Product embed iframes auto-load on page load.
- Desktop quote cards include `Expand view` and `Open in new tab` controls.
- Mobile quote cards hide those desktop controls and show one same-tab `Open quote tool` action.
- The iframe wrapper uses `data-lenis-prevent` so users can interact with the embedded quote tool while Lenis/smooth scrolling is enabled.

Mapped product collections include:

- Composite Doors
- uPVC Windows
- Sash Windows
- Aluminium Windows
- uPVC Doors
- uPVC French Doors
- uPVC Sliding Patio Doors
- Aluminium Bifolding Doors
- Aluminium Sliding Patio Doors
- Heritage Aluminium Doors
- Aluminium Doors
- Slide & Fold Doors
- Replacement Glazed Units
- Secondary Glazing

### Window Handle Section

Window handle information is shared data in:

`inc\site-data.php`

The section renders from:

`template-parts\sections\generated-page.php`

Current accepted behaviour:

- Appears on selected window product routes only.
- Tilt & Turn Windows is intentionally excluded.
- Uses supplied S2 finish images from `assets\images\products\handles`.
- Includes an interactive finish selector for White, Black, Chrome, Gold and Titanium.
- Includes three feature tiles: Push-to-release, Secure locking and Coordinated finish.
- Includes one static technical specification card.
- No handle accordion is used.
- Monkey-tail, egress conversion, spindle length and retrofit-ready content have been removed.

### Sliding Sash / Roseview Page

Route: `/sliding-sash-windows/`

Current accepted behaviour:

- The page is Roseview-led, not Liniar-led.
- `inc\product-hub-data.php` maps the product hub system to Roseview with the local logo `assets\partners\roseview-logo-new.png`; the old inherited Liniar badge should not render on this route.
- Dedicated Roseview comparison content lives in `template-parts\sections\generated-page.php` for Ultimate Rose, Heritage Rose and Charisma Rose.
- Roseview model/detail assets live under `assets\images\products\sash-roseview`.
- The page includes model cards, aligned `Best for` boxes, a comparison table, meeting-rail detail and mechanical/welded-joint detail.
- The joint media panel stretches to match the copy card height on desktop.
- The generic S2 window handle section is intentionally removed from this page.
- Sash furniture renders from `inc\site-data.php` under `sash_furniture`: Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, Shark Fin Limit Stop and D Handle extras, plus the Roseview under/over 700mm furniture-count rule.
- Runtime assets are local theme copies from the Roseview scrape. Do not reference the scrape export or `wp-content\fenster-reference` for this page.
- Mobile QA: the top of the page is acceptable, but the Roseview model stats/cards for Ultimate Rose, Heritage Rose and Charisma Rose, the corner-detail section, slide-aligned comparisons and large detail images are not good enough on phone. Treat the sash model/detail area as a mobile redesign, not just a small spacing tweak.

Recent verification:

- PHP lint passed for `inc\site-data.php`, `inc\product-hub-data.php` and `template-parts\sections\generated-page.php`.
- `npm.cmd run build` passed after the Sass changes.
- Rendered checks confirmed the Roseview logo loads, Liniar is not visible, all 10 sash furniture images load after lazy scroll, the three furniture cards align on desktop, and the new sash furniture section does not cause mobile overflow.

### Obscured glass Page

Route: `/obscured-glass/`

Current accepted behaviour:

- The page is hidden from the main navigation.
- Product journey pages link to it from the `Gallery and choices` / finish options area.
- Obscured glass data lives in `inc\site-data.php` under `obscure_glass`.
- Texture assets live under `assets\images\products\obscure-glass`.
- Cotswold is the default preview and uses the downloaded Pilkington source texture at `assets\images\products\obscure-glass\Cotswold-pilkington.png`.
- The visualiser can switch between the colour Legend photo at `assets\team\legend-colour.webp` and the house background at `assets\images\products\obscure-glass\birkacre-house.webp`.
- The accepted preview model is a split comparison: the left side shows the selected Obscured glass treatment and the right side keeps a clear reference view.
- The split is controlled by a draggable range slider, not mouse-follow movement.
- The glass treatment should follow the Pilkington-style layer model: a blurred/brightened duplicate of the current scene, with the texture pattern as a separate unblurred layer above it. Do not blur the texture layer itself or it turns into glow.
- Mobile uses the same texture data with tappable horizontal glass controls, no hover dependency, and touch rules that allow normal vertical page scrolling through the visualiser.

### Colour Options Pages

Routes:

- `/colour-options/`
- `/upvc-colours/`
- `/aluminium-colours/`

Current accepted behaviour:

- The pages are hidden from the main navigation.
- Product journey pages link to `/colour-options/` from the `Specification choices` section.
- Colour data lives in `inc\site-data.php` under `colour_options`.
- `/colour-options/` shows both uPVC and aluminium colour sections on one customer-facing hub. The old top uPVC/aluminium tab buttons were removed because they implied separate journeys when everything is on the same page.
- `/upvc-colours/` and `/aluminium-colours/` still render the same hub route/template with the relevant anchor/material context available.
- The colour pages are straightforward customer-facing reference hubs; do not put the circular choice dial on these pages.
- The circular choice dial belongs on generated product pages in the `Specification choices` section, where it links to colours, privacy glass and handles or quote options.
- Mobile uses the same colour data in a single-column layout.
- Supplier/manufacturer scrape assets may be used as source imagery, but never expose implementation/source wording such as scrape folder names, manufacturer scrape labels, internal provenance, or supplier names unless the owner explicitly asks for customer-facing supplier branding.
- Visible copy should stay simple: `uPVC colours`, `Aluminium colours`, finish names and customer-useful finish details. Do not add source badges, internal notes, or long product applicability lists beneath the colour carousel.
- uPVC colour swatches currently use optimised WebP assets under `assets\images\products\colours\liniar-swatches`, sourced from `images\colours_page_image`.
- Door-render colour assets under `assets\images\products\colours\liniar-door` exist for later door-page use and should not be used for the colour hub swatch carousel.
- The uPVC carousel has a coverflow-style interaction with buttons, keyboard controls and draggable scrub behaviour.
- Dragging the carousel should scrub the coverflow animation itself. Do not move the whole carousel stage sideways and then snap it back.
- Dragging can move across multiple colours; on release it snaps to the nearest colour. Keep sensitivity calm for mobile.
- Current uPVC visible colour names include `Smooth White` with `No foil`, `Anthracite Grey` instead of `7016 Grey`, `Gale Grey Finesse (Anthracite Smooth)` and `Silver Grey` instead of `7155 Grey`.
- Removed uPVC colours should stay out of the customer carousel unless the owner reverses the decision: Anteak, Bright Oak, Swamp Oak, Nussbaum, Windsor, Balmoral, Bronze, Champagne Smooth, Pebble Grey, 7030 Grey, 7039 Grey, 7044 Grey, Black Ultimatt, VLF Black, Burgundy, Flemish Gold, Claystone, Sage, Sheffield Oak Alpine, Turner Oak Malt and Trompet.
- The colour hub hero visual should stay clean and controlled. The accepted direction is a simple sample-board/grid using complete swatch images; avoid random overlapping piles, rotated card stacks and cropped-off swatch content.
- Mobile QA: remove or hide the colour hub hero image on mobile if the crop/visual weakens the page. The page content after the hero is acceptable; the mobile first impression should be clean, not image-led.

### Door Handle Section

Door product pages now include a real door-handle section rather than the earlier placeholder.

Current accepted behaviour:

- Door handle data lives in `inc\site-data.php` under `door_handles`.
- Cropped handle assets live under `assets\images\products\door-handles`.
- The original supplied nine-handle sheet was cropped into separate transparent PNG assets.
- The section appears on selected door routes:
  - Composite Doors
  - uPVC Doors
  - French Doors
  - Patio Doors
  - Aluminium Bifold Doors
  - Aluminium Sliding Doors
  - Heritage Aluminium Doors
  - Aluminium Doors
  - Slide & Fold Doors
- It uses the same selector behaviour as the window handle section: finish swatches, active handle image/copy, feature tiles and a static compatibility note.

## Integral Blinds Desktop Reveal

Route: `/integral-blinds/`

The page has a desktop-only opening reveal made from the supplied `internal blinds.mp4`.

Current accepted behaviour:

- The reveal is a transparent fixed overlay covering the full viewport, including the hero.
- It is the first desktop interaction on the page.
- The document and Lenis smooth-scroll are locked at `scrollY = 0`.
- Scrolling controls the video in reverse so the blinds open.
- The virtual scroll is eased, not direct wheel-to-frame jumping.
- Reveal travel is about `1.55` viewport heights.
- The working chroma canvas is `720 x 405` for responsiveness.
- Once fully open, the overlay fades out and normal page scrolling resumes from the top.
- It is disabled on `860px` and below and for reduced-motion users.

Runtime files:

- Video helper/preload: `inc\assets.php`
- Markup: `template-parts\sections\generated-page.php`
- Controller/chroma key: `src\js\main.js`
- Overlay styling: `src\scss\main.scss`
- Video asset: `assets\videos\product-scroll\integral-blinds-chroma.mp4`

## Enquiry System

The site has one shared live form component:

`template-parts\components\enquiry-form.php`

Do not create standalone forms.

Handler:

`inc\enquiries.php`

Current behaviour:

- JavaScript intercepts `[data-fg-enquiry-form]`.
- The form posts through WordPress AJAX.
- Success appears in place without changing the route.
- The no-JavaScript fallback remains.
- All fields are visible in one form flow; the old stepped/wizard presentation has been removed.
- Shared enquiry section headings should use moderate content-heading scale. Do not let `.fg-obscure-enquiry__grid h2` or related form headings render at hero scale.
- Some old stepped-form CSS/JS selectors may still exist as inactive scaffolding, but the shared PHP component does not currently render the stepped data attributes or step controls.
- Valid leads are saved as private `fenster_enquiry` posts.
- Office notification email is branded HTML.
- Customer acknowledgement is sent.
- Default verified recipient is `info@fensterglazing.com`.
- Live delivery still requires production SMTP/DNS configuration.

SMTP constants supported in `wp-config.php`:

- `FENSTER_SMTP_HOST`
- `FENSTER_SMTP_PORT`
- `FENSTER_SMTP_USERNAME`
- `FENSTER_SMTP_PASSWORD`
- optional `FENSTER_SMTP_SECURE`

## Homepage

Dedicated homepage source of truth:

`HOMEPAGE.md`

Main homepage template:

`template-parts\sections\home-experience.php`

Current homepage direction:

- Full-width optimised video hero.
- Combined trust cards.
- Interactive product theatre.
- Instant-pricing bridge.
- Project proof.
- Partner strip.
- Shared enquiry form.
- Local-service links.
- Expanded footer.

Do not rely on this handover for homepage fine detail; read `HOMEPAGE.md` before homepage work.

## Contact Page

Route: `/contact/`

Main template:

`template-parts\sections\contact.php`

Current accepted behaviour:

- The page is a polished contact hub, not a plain form page.
- Hero uses the Milton Keynes showroom image at `assets\images\about\fenster-showroom.png`.
- Quick action cards cover phone, email, showroom directions and instant pricing.
- The showroom/map, route-choice and enquiry sections wrap around the shared enquiry form.
- The page still uses `template-parts\components\enquiry-form.php` as the only live customer form.

## Shared Review Showcase

Shared component:

`template-parts\components\review-showcase.php`

Current accepted behaviour:

- Review data lives in `inc\site-data.php` under `customer_reviews`.
- The component renders a fixed Google/Trustpilot-style `EXCELLENT` summary and a carousel.
- The default carousel shows seven cards from the curated review data.
- Some templates still pass `eyebrow`, `title` or `copy` arguments, but the component currently ignores those text arguments. Do not describe route-specific review headings as live unless the component is extended.

## Three.js Status

Three.js is not active on the live site.

- `wp-content\themes\fenster\package.json` has no `three` dependency.
- `src\js\main.js` imports Lenis only.
- `inc\assets.php` does not enqueue Three.js from a package or CDN.
- The compiled `assets\js\main.js` does not contain `THREE`, `WebGLRenderer`, `data-fg-home-3d` or `fg-home-hero-3d`.
- There is inactive legacy source/styling for an old homepage 3D hero experiment: `fg-home-hero-3d`, `data-fg-home-3d` and an `if (false) { ... THREE.* ... }` block.
- The actual homepage route returns `template-parts\sections\home-experience.php` before that old generic-home hero branch can render.

Do not revive or work around the old Three.js/canvas experiment unless the owner explicitly asks for 3D again.

## Commercial Pages

Commercial pages use the shared generated-page infrastructure plus commercial-specific content and route grouping.

Commercial content should stay commercial. Do not mix residential product links into commercial related-link panels unless contextually appropriate and route-checked.

Commercial county landing pages are generated from `fenster_commercial_county_profiles()` in `inc\generated-pages.php` and render through `template-parts\sections\commercial-county.php`.

Current accepted behaviour:

- The route pattern is `/commercial-glazing-{county}/`.
- The set covers the commercial county routes Fenster is prepared to review, excluding ferry/island-access areas that are not credible normal coverage, such as Isle of Wight.
- County pages are SEO-indexable and included in the generated page sitemap.
- Each county page has unique county-specific H1/title/meta/town/context copy built from its profile data.
- Each county page has the shared enquiry form in the hero and a clearly visible phone CTA.
- `/commercial-areas/` is a temporary noindex developer review page. It must stay out of the public header and sitemap.
- Do not add individual county SEO pages to the normal Commercial dropdown; keep the dropdown focused on the commercial hub and commercial projects.

## Location Pages

Location service pages use generated/imported content and shared templates.

The generated residential product/location matrix uses explicit town and product profile data in `inc\generated-pages.php` for title tags and meta descriptions. Do not restore the old single duplicate meta-description template across all town/product pages. Body copy continues to render through `template-parts\sections\location-service.php`, which varies page copy by town profile, product profile and slug-based copy variant.

Related links for location pages should prefer:

- the same town's double-glazing page,
- sibling real products/services for that town,
- relevant residential/commercial group links.

## Header And Mobile Behaviour

At `860px` and below:

- `.site-header` is fixed.
- `.site-main` reserves the fixed header height.
- The mobile drawer starts under the header.
- Desktop sticky homepage theatre is replaced with mobile normal-flow cards.

This fixed a previous mobile/tablet failure where the header appeared to disappear and the desktop theatre filled tablet viewports.

## Footer

Footer is expanded and structured. It should not collapse into an unstructured list on mobile.

Footer columns cover:

- Brand/about and accreditations.
- Products.
- Fenster links.
- Contact.

Mobile footer has a dedicated panel layout.

## Assets

Important optimised assets:

- Homepage hero video: `assets\videos\home\fenster-home-hero.mp4`
- Homepage hero poster: `assets\images\imported\home-hero-poster.jpg`
- Integral blinds reveal video: `assets\videos\product-scroll\integral-blinds-chroma.mp4`
- Aluminium door turntable assets belong to `/aluminium-doors/`, not Composite Doors.

Scrape-derived imagery used by templates and `data\pages.json` lives in `assets\images\imported`. The `wp-content\fenster-reference` folder is a local-only archive: nothing at runtime references it and it must not be deployed.

Do not replace optimised production assets with huge reference originals.

## Current QA Expectations

Before handing work back:

- Run `npm.cmd run build` after SCSS/JS changes.
- Lint changed PHP.
- Check desktop and mobile where layout changes are involved.
- Minimum responsive checks for important work:
  - `390 x 844`
  - `768 x 1024`
  - `1440 x 900`
- Check no horizontal overflow.
- Check console errors where browser QA is available.
- Update docs in the right place.

## Things To Avoid

- Do not add standalone forms.
- Do not restore raw scraped related links.
- Do not invent product specs.
- Do not use inconsistent mobile breakpoints without documenting why.
- Do not distort images/videos to fill space.
- Do not rely on hover for mobile interactions.
- Do not put dated progress reports in `AI.md` or `HANDOVER.md`.
- Do not edit compiled CSS/JS without updating source and rebuilding.

