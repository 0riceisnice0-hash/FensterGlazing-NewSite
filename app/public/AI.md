# Fenster Glazing AI Coding Rules

Last updated: 2026-07-13

This file is the rulebook for AI agents working on the Fenster Glazing codebase.

It should contain durable coding standards, implementation rules, QA expectations and “do not do this again” guidance.

It should not contain dated progress reports, long handover summaries or homepage-specific design notes. Put those in:

- `HANDOVER.md` for current site context.
- `AUDIT.md` for the 2026-07-03 master site audit, remediation status and remaining launch backlog.
- `STYLE.md` for site-wide visual styling, background, section rhythm and design rules.
- `HOMEPAGE.md` for homepage-specific architecture and design.
- `PROGRESS.md` for dated work logs and completed changes.

## Important Updates

- Latest live commit at the time of this update is `882cf47` (`Scope door handle selector routes`). New agents should check `git log --oneline -8` before assuming this is still the latest.
- GitHub is now live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. The repo is intentionally scoped to the custom theme and launch docs; do not add WordPress core, uploads, `wp-config.php`, `node_modules`, backups, Local config or `wp-content\fenster-reference`.
- SiteGround test/live are still Bedrock installs. Local source is standard WordPress at `wp-content\themes\fenster`, but server deploy target is `web/app/themes/fenster`. The verified test deploy path is: GitHub repo cache at `~/repos/FensterGlazing-NewSite`, then rsync `app/public/wp-content/themes/fenster/` into `~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/`.
- Production deploys should swap/update the theme only. Keep the production database, uploads, plugins, `.env`, Bedrock config and `wp-config.php` equivalent in place unless the owner explicitly asks for a full WordPress migration.
- Do not use SiteGround clone/staging tools for this account. Previous cloning/search-replace behaviour caused live/test URL drift. Use theme-only deploys from GitHub: small, scoped, low-risk changes may go straight to live after local build/lint, commit and push; bigger layout/template/routing/form/SEO changes should go to test first, then verified live deploy.
- On generated pages the theme owns public SEO output. Yoast and Rank Math head output is intentionally suppressed to prevent duplicate titles, stale schema and old imported social tags. Do not reset Rank Math before launch; Google Site Kit/Search Console and Microsoft Clarity can be configured after launch for tracking.
- Launch SEO hardening has been completed for the main technical blockers: homepage title/meta override, generated URL trailing-slash/lowercase 301s, public cache headers for logged-out generated pages and sitemaps, generated breadcrumb schema, sitemap scrub to 427 URLs, `/commercial-areas/` removed from public navigation, and footer links to `/areas-we-cover/` and `/terms-conditions/`.
- Thin utility/scrape pages such as `gallery`, `downloads`, `videos`, `customer-portal`, `refer-a-friend`, `brochures`, `apecs-terms-conditions` and `fenster-partners` are intentionally `noindex,follow` and absent from the sitemap.
- Mobile launch fixes are in place for the About process cards, Contact hub cards and quote-tool controls. Do not restore the old mobile quote controls that showed both `Expand view` and `Open in new tab`; mobile should show one same-tab `Open quote tool` action.
- The current product-page model is live: product pages use visible `Product information` cards, `More information on [product]` hubs, full-width specification check cards and FAQ-only accordions. Do not restore non-FAQ accordions, the product-hub survey summary, common-choice strip, quote option card, accreditations/systems filler section or inline window-handle chooser.
- Mobile product-template fixes are in place for the live phone QA pass. Product information hubs must stay viewport-contained on mobile, supplier/proof badges should stay visually balanced, and shared product sections must not create horizontal body scroll.
- Mobile navigation must own the touch layer when open. At `860px` and below, the open fixed header/nav overlay should sit above page content so hero/cards cannot intercept taps on menu rows.
- The test site has verified working enquiry delivery to `info@fensterglazing.com`; valid forms are saved privately as `fenster_enquiry` posts before email delivery.
- Performance has been improved without lowering visual quality by deferring heavy embeds/media instead of removing premium assets: homepage hero video loads after idle, quote iframes use deferred `data-quote-iframe-src` loading, product theatre non-primary media lazy-loads, and quote embeds load near viewport or on interaction. Do not undo this by making every iframe/video eager again.
- The Lighthouse performance pass added critical first-viewport CSS, async activation of the main stylesheet, WOFF2 Gibson fonts with critical font preloads, a homepage hero-poster preload, mobile/constrained-connection hero-video interaction gating, image dimension helpers and below-fold homepage `content-visibility`. Keep the poster as the mobile/slow-network first visual and do not make the 9.36 MB homepage video part of the initial mobile payload again.
- Microsoft Clarity is theme-loaded only, not plugin-loaded. Live Clarity plugins `microsoft-clarity` and `clarity-ad-blocker` were removed after replay debugging.
- Clarity replay styling depends on `inc\consent.php` injecting `style#fenster-clarity-replay-css[data-clarity-unmask="true"]` before loading `https://www.clarity.ms/tag/xi7rk1pic8`. Do not remove this inline replay CSS: it works around SiteGround/WAF bot-fetch failures where Clarity-like resource requests can receive the host's 403 HTML page instead of the real stylesheet.
- Clarity asset links and critical CSS are intentionally marked `data-clarity-unmask="true"` in `inc\assets.php` so stylesheet/font/image URLs are preserved under stricter Clarity masking modes.
- If Clarity recordings look unstyled, giant, or like a 403/error page again, simulate Clarity before changing layout: fetch the page and CSS with bot-style user agents, check for 403s, verify the inline replay CSS exists after accepted consent, and remember old recordings will not be repaired retroactively.
- The 2026-07-13 Search Console baseline says the launch did not cause an obvious search cliff, but Google is still mostly rewarding older informational pages. When doing SEO work next, prioritise CTR and internal-link fixes for pages that already have impressions: `/french-casement-windows/`, `/what-are-double-glazed-glass-windows/`, `/windows-milton-keynes/`, `/double-glazing-milton-keynes/`, `/doors-milton-keynes/`, `/composite-doors/`, `/soundproof-windows/` and `/3d-visualiser/`. Do not make generic SEO filler; make high-impression pages feed quote, visualiser and local money pages.

## Project Basics

- Local site root: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public`
- Active theme: `wp-content\themes\fenster`
- Main SCSS source: `wp-content\themes\fenster\src\scss\main.scss`
- Main JS source: `wp-content\themes\fenster\src\js\main.js`
- Compiled CSS: `wp-content\themes\fenster\assets\css\main.css`
- Compiled JS: `wp-content\themes\fenster\assets\js\main.js`
- Generated/source page data: `wp-content\themes\fenster\data\pages.json`

Build from the theme directory:

```powershell
npm.cmd run build
```

PHP lint example:

```powershell
& 'C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe' -l 'C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\template-parts\sections\generated-page.php'
```

## Editing Rules

- Edit source files, not compiled assets directly.
- After SCSS or JS changes, run `npm.cmd run build`.
- Lint any changed PHP template or PHP include.
- Preserve user changes in the working tree. Do not reset, checkout or delete unrelated work.
- Do not rebuild the site around ACF, Elementor or editable admin fields unless the owner explicitly changes direction.
- The theme is intentionally code-driven and hardcoded where appropriate.
- Do not add new one-off helper systems when an existing shared component or data source already owns the behaviour.

## Documentation Rules

- `AI.md` is for rules about how to work on the codebase.
- `HANDOVER.md` is for the current site state and architecture an AI needs to get caught up.
- `AUDIT.md` is for the master audit, remediation table, open launch issues and prioritised backlog from the 2026-07-03 site audit.
- `STYLE.md` is for site-wide styling, visual direction, gradient/background rules, section rhythm, cards, typography and mobile design expectations.
- `HOMEPAGE.md` is only for homepage-specific information.
- `LIVECHANGES.md` is for SSH, test/live deploys, cache flushing, live safety rules and what not to touch.
- `PROGRESS.md` is for dated progress reports and change history.
- When a task changes the accepted model of the site, update the relevant source-of-truth doc.
- Do not paste temporary experiments into the permanent docs. Document the final accepted model and any important rejected approach only when it prevents future regressions.

## Styling Source Of Truth

- Before changing any page layout, section styling, hero, card, form, background, responsive behaviour or visual component, read `STYLE.md`.
- The continuous page background rule in `STYLE.md` is site-wide: do not repaint the same page gradient on every section or wrapper.
- The moderate heading rule in `STYLE.md` is site-wide: do not default page H1/H2/H3 text to hero scale. For normal content/trust/proof/utility pages, keep page H1s capped around `clamp(2.1rem, 3.6vw, 3.6rem)` and let H2/H3 share a smaller supporting scale around `clamp(1.45rem, 2.2vw, 2rem)`.
- Page-specific docs can add detail, but they do not override the site-wide design contract unless the owner explicitly asks for a new direction.

## Visual Recovery Rule

- Do not try to rescue a page with more sections after its composition has been rejected. Stop, identify the repeated claims, redundant CTAs, empty space and weak image use, then rebuild the content order around the page's one primary action.
- A functional component review is not visual QA. Before shipping a new conversion page, inspect the whole rendered page at desktop, tablet and mobile widths, including every below-the-fold section and the space between sections.
- The first viewport must make the main action obvious. Put the strongest trust signals immediately beside or beneath the action that asks for customer details, not in a disconnected proof strip.
- Every section must have a job. Do not repeat the form flow in explanatory cards, repeat a proof row later in the page, or append generic related links simply to fill space.
- Scan local image assets before designing. Choose real images that carry a distinct role in the page story; do not add tiny decorative image tiles merely to claim a page has imagery.

## Three.js / Canvas Rule

- Three.js is not an active dependency in the live theme.
- `wp-content\themes\fenster\package.json` currently ships `lenis` as the only runtime dependency; there is no `three` package.
- Do not assume the old homepage 3D/canvas experiment is live. The remaining `fg-home-hero-3d`, `data-fg-home-3d` and `THREE.*` references are inactive legacy source/style hooks and are not present in the compiled JS.
- Do not reintroduce Three.js, a WebGL hero or a canvas product scene unless the owner explicitly asks for that feature.
- If 3D is deliberately reintroduced, add the dependency/import/enqueue intentionally, provide mobile and reduced-motion fallbacks, and verify the canvas is nonblank in desktop and mobile browser QA.

## Shared Form Rule

- The live theme must have exactly one customer-facing form definition:
  - `template-parts\components\enquiry-form.php`
- Do not add raw standalone `<form>` markup to templates.
- If a new form context is needed, extend the shared component arguments and shared handler.
- The reusable consultation mode is an argument on the shared component, not a separate form: it must keep the date/time request validation in `inc\enquiries.php`, save the preferred appointment with the private enquiry, and clearly state that the office confirms availability. Its JavaScript experience is one compact consultation panel with distinct date, time and details stages, not a stacked form. The date stage must be sized to its natural calendar content rather than stretched to the hero; keep the Monday-Friday, 9am-4pm and bank-holiday-excluded availability rule visible as a concise booking strip, and exclude England-and-Wales bank holidays from both the picker and server-side validation. Use compact arrow-only back controls between stages, with accessible labels, rather than verbose change links. The final details stage needs its own light-surface field treatment with a selected-slot summary, legible labels/required markers, bordered inputs and a clear consent/submit finish; do not let the shared dark-form defaults leak into it. The dedicated indexable route is `/book-a-consultation/`; it owns its title, meta description, canonical, sitemap entry and visible FAQ content while still using the same component. Keep its Trustpilot/FENSA reassurance directly beneath the booking panel; do not create a disconnected homepage-style proof strip or repeat booking mechanics lower down the page.
- All forms should use the AJAX enhancement in `src\js\main.js`, with the no-JavaScript fallback preserved.
- Submissions are handled in `inc\enquiries.php`.
- Valid enquiries are saved as private `fenster_enquiry` posts before email delivery is attempted.
- Default office recipient is `info@fensterglazing.com`, unless overridden by a supported config constant.
- Email templates must keep the Fenster logo visible in common email clients. The current launch email uses a light header with the white-background brand asset; do not place that asset back onto a dark header.
- Mobile forms must be one column, full width, with `16px` input text and comfortable touch targets.
- Form-section headings are content headings, not heroes. Keep shared enquiry h2 sizes moderate across the site.
- Article/blog CTA forms use the shared component with the extra `fg-article-form` class from `template-parts\sections\generated-article.php`. Keep that page-specific styling so labels/inputs stay readable inside article CTA cards.
- AdminBase lead relay lives in `inc\adminbase.php`. It restores the old `wraith` WindowCAD endpoint at `/wp-json/fenster/v1/windowcad` and relays normal saved enquiries through the `fenster_enquiry_created` hook. Do not commit AdminBase credentials; configure them through constants, environment variables or WordPress options.
- Website attribution is theme-owned in `inc\website-tracking.php` and `src\js\main.js`, with the Marketing Dashboard as the aggregate/reporting surface. Its code and durable tracker documentation are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`; do not duplicate its API/UI logic in the theme. `FG2-…` is an opaque consented quote/journey reference; `FGV-…` is an opaque consented browser visitor reference. Do not put names, emails, phones, addresses, raw WindowCAD fields or ad click IDs into the dashboard.
- Only accepted optional-cookie choices may create `FG2`/`FGV`, page/click/time events, WindowCAD joins or dashboard conversion events. A WindowCAD quote after rejection must use the separate WindowCAD **Tracking** field value `rejected-cookies`; before a choice it uses `cookie-consent-not-accepted`. Both still go to the office, but neither may be relayed into the dashboard.
- Consent reporting is deliberately aggregate-only: the dashboard may count accepts and rejects per day, but must never attach those records to a visitor, URL, source, device or journey. Do not bring back banner-impression totals: without pre-consent identity they are not a dependable metric and can be inflated by anonymous sessions/crawlers.
- Consent-safe journey detail may include page time, scroll milestones, CTA labels/destinations and form-field *names* that failed validation, but never customer-entered values. Lead status is a dashboard-only manual business outcome tied to an existing consented completed lead.

## Related Links Rule

- Do not restore the old generic related-link merge.
- Do not render raw scraped footer/legal/promo links as related products or service areas.
- Related links must be context-aware and route-checked before rendering.
- Valid related links should come from:
  - the current product family,
  - matching location routes,
  - relevant residential/commercial route groups,
  - page-topic matches.
- Self-links, nonexistent routes, files, external promo/legal links and pagination debris must not appear.

## Generated SEO Rule

- Do not render raw imported SEO tags blindly.
- Write generated meta descriptions as complete, useful sentences at 160 characters or fewer. `fenster_trim_meta_description()` is a regression guard only; do not treat its trailing ellipsis as finished SEO copy.
- Generated pages suppress Yoast/Rank Math public head output. Keep theme-owned titles, descriptions, canonicals, robots, social meta, LocalBusiness schema, FAQ schema, breadcrumb schema and sitemaps as the source of truth unless the architecture deliberately changes.
- Skip imported OpenGraph, Twitter and JSON-LD values that are placeholders, JSON blobs, old designer-tool schema, `test.fensterglazing.com` references or other scraped development-domain debris.
- Imported `schema_json_ld` from the scrape is never rendered. It contains old designer-tool VideoObject markup and unsubstantiated aggregateRating values. Structured data is generated fresh instead: `fenster_render_site_schema()` in `inc\generated-pages.php` outputs a LocalBusiness block site-wide, product journey pages output `FAQPage` JSON-LD built from the same FAQs shown on the page, and generated deep routes output `BreadcrumbList` JSON-LD. Do not add aggregateRating/Review schema unless a verifiable review feed exists.
- Debris routes are handled centrally in `inc\generated-pages.php`: `fenster_gone_slugs()` (410), `fenster_redirect_target()` (301, including all `*-designer` pages and duplicate town slugs) and `fenster_slug_is_noindex()` (ad landers, thin utility/scrape shells plus `category/`, `tag/`, `author/`, `blog/page/` archives). Add new debris to these lists rather than only excluding it from the sitemap; sitemap exclusion alone does not stop indexing.
- Core `wp-sitemap.xml` is intentionally disabled; robots.txt advertises the theme sitemap at `/sitemap.xml`. Do not re-enable core sitemaps.
- Alias pages must render their own canonical URL rather than inherited source-page social URLs.
- Generated routes should 301 to the lowercase, trailing-slash canonical URL.
- Do not restore `/wcad-thank-you/` from imported data. It was removed because it only exposed stale social/filler copy.
- `/terms-conditions/` is intentionally a hardcoded virtual utility page in `inc\generated-pages.php`.

## Page Classification Rule

- Product/commercial routing in `template-parts\sections\generated-page.php` uses explicit slug whitelists (`$product_route_slugs`, `$commercial_route_slugs`), not slug-substring matching. Substring heuristics previously forced ~40 blog articles through the product journey with broken headings.
- Imported blog posts and guides render through `template-parts\sections\generated-article.php`. New informational pages should default there; add a slug to the whitelists only when it is genuinely a product/commercial route.

## Product Data Rule

- Product USP/specification data belongs in `inc\site-data.php` under `product_usps`.
- Product visible copy overrides for generated product pages belong in `inc\site-data.php` under `product_content`.
- Manufacturer-backed product hub system/badge/spec data belongs in `inc\product-hub-data.php`.
- Use `product_content` when scraped content is correct in broad source data but the generated template would otherwise surface aliases, brochure prompts, FAQ intro text, footer/social debris or generic fallback copy.
- Product pages should render the shared four-tile `Key specifications` strip.
- Do not invent product values such as U-values.
- Products with supplied U-values show them first.
- Colour choice should be second where supplied.
- Composite Doors and Integral Blinds currently do not have supplied U-values.
- Integral Blinds controls must be described as `Magnetic or electric`.

## Product Quote Embed Rule

- Product-specific WindowCAD quote URLs are mapped in `template-parts\sections\generated-page.php`.
- Product page instant quote links should jump to `#fenster-product-quote` when a product-specific collection exists.
- Do not place large iframe embeds before scroll-following or cinematic product sections; they can break scroll measurement and pacing.
- Product quote embeds should stay compact and sit after the main product journey/trust content.
- Product quote embeds auto-load the iframe on page load; do not restore the old `Load tool` gate.
- Embedded quote tools include both `Expand view` and `Open in new tab` actions on desktop/tablet layouts.
- On mobile, hide the desktop quote controls and show one same-tab `Open quote tool` action. The owner rejected the mobile new-tab/expand controls because they add friction and confuse the lead path.
- The iframe wrapper should use `data-lenis-prevent` so the embedded tool remains usable with smooth scrolling.
- Product pages should not render the imported mini-gallery from scraped `images` data. That export contains old stock/placeholder images, so product pages should use curated hero/feature media and link to focused specification hubs instead.
- Product gallery pools in `inc\site-data.php` must stay material/product specific. Do not map uPVC doors, composite doors, French doors, patio doors, aluminium doors, aluminium bifolds or aluminium sliders into one broad entrance/wide-span pool; that reintroduces wrong-material imagery across the main product routes and town/service matrix pages.
- Location/service pages rendered by `template-parts\sections\location-service.php` intentionally reuse the same curated `product_media` and `product_gallery_pools` source as the main product pages. Do not fall back to raw imported scrape images for product matrix routes when a curated product image source exists.
- Product gallery thumbnails should open the in-page lightbox with dark overlay, arrows and no visible caption/alt text. Do not make gallery clicks open a raw image URL or new browser tab.
- On mobile, product hub specification cards and any remaining horizontal components must not create horizontal body scroll.
- Colour choices live in the `/colour-options/`, `/upvc-colours/` and `/aluminium-colours/` virtual routes using `inc\site-data.php` under `colour_options`; do not rebuild huge inline colour grids on every product page.
- Product-page specification cards should link to colour options, obscured glass and relevant hardware choices rather than making the product template carry every possible finish.
- Product hub system logos must use local theme assets and be rendered through `fenster_generated_url()`. Do not point product hubs at `wp-content\fenster-reference` or raw scrape URLs.
- `/sliding-sash-windows/` is a Roseview product route, not a Liniar route. Its product hub system is `Roseview`, its local logo is `assets\partners\roseview-logo-new.png`, and its model badges are `Ultimate Rose`, `Heritage Rose` and `Charisma Rose`.

## Colour Hub Rule

- Colour data belongs in `inc\site-data.php` under `colour_options`.
- The colour hub routes are `/colour-options/`, `/upvc-colours/` and `/aluminium-colours/`.
- The colour hub is customer-facing. Do not expose supplier names, scrape folder names, manufacturer scrape labels, internal provenance or applicability dumps unless the owner explicitly asks for public supplier branding.
- Use simple visible labels: `uPVC colours`, `Aluminium colours`, finish names and short customer-useful details only.
- The uPVC colour carousel uses optimised swatch assets from `assets\images\products\colours\liniar-swatches`.
- The door render assets under `assets\images\products\colours\liniar-door` are reserved for later door-page use, not the colour hub.
- The accepted carousel interaction is a coverflow-style carousel with buttons, keyboard support and draggable scrub behaviour. Dragging should scrub the coverflow state itself; do not translate the whole carousel stage sideways.
- Dragging can move through multiple colours, then release snaps to the nearest colour. Keep the drag sensitivity calm enough for mobile.
- The colour hub hero visual should be simple and controlled. Do not create overlapping random card piles or crop swatch images so their content is chopped off.
- Do not add uPVC/aluminium tab buttons that imply separate pages when the page already shows both sections.

## Window Handle Section Rule

- Window handle data belongs in `inc\site-data.php` under `window_handles`.
- Window handles are now a standalone specification hub at `/window-handles/`, registered in `inc\generated-pages.php` and rendered from `template-parts\sections\generated-page.php`.
- Handle finish images live under `wp-content\themes\fenster\assets\images\products\handles`.
- Product pages no longer render the full handle chooser inline. Selected window routes link to `/window-handles/` from the specification choice cards.
- Tilt & Turn Windows and Sliding Sash Windows should not get the generic inline handle chooser because there is no inline chooser anymore.
- The accepted hub model is a compact finish selector with White, Black, Chrome, Gold, Satin Silver and Monkey Tail, plus three feature tiles and a static technical specification card.
- Do not restore the handle accordion, egress conversion copy, monkey-tail copy, spindle length row or retrofit-ready card unless the owner explicitly asks for them.

## Sliding Sash Roseview Rule

- `/sliding-sash-windows/` has dedicated Roseview content in `template-parts\sections\generated-page.php`, with local assets under `assets\images\products\sash-roseview`.
- Keep the Roseview model comparison for Ultimate Rose, Heritage Rose and Charisma Rose. Do not replace it with generic uPVC window content.
- Sash furniture data belongs in `inc\site-data.php` under `sash_furniture`. It covers Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, extra Shark Fin/D Handle options and the Roseview under/over 700mm furniture-count rule.
- Use local copied Roseview scrape assets only. The source scrape can inform copy/assets, but runtime code must not depend on the scrape export folder.
- The visible sash detail sections should stay sash-specific: meeting rails, mechanical/welded joints, sash furniture and Roseview model differences. Remove or rewrite generic non-sash hardware/specification content if it appears on this page.

## Door Handle Section Rule

- Door handle data belongs in `inc\site-data.php` under `door_handles`.
- Door handle crop assets live under `wp-content\themes\fenster\assets\images\products\door-handles`.
- The door handle section renders from `template-parts\sections\generated-page.php` on selected door routes.
- The accepted model uses the same compact selector pattern as window handles: finish swatches, active handle image/copy, three feature tiles and a static compatibility note.
- Do not show the long-plate door handle selector on `/patio-doors/`, `/aluminium-bifold-doors/` or `/slide-fold-doors/`; those systems use different handle families and should not share the entrance/French door handle section.
- Do not replace the cropped handle assets with the original nine-handle sheet in templates.

## Mobile Design And Implementation Rules

These rules apply to every new section, page change, form, carousel, product page and responsive interaction.

### Mobile Is Designed, Not Squashed

- Design mobile at the same time as desktop.
- Do not finish desktop first and then compress it until it fits.
- Use a real mobile content order: title, key image/content, primary action, supporting content, secondary detail.
- If a desktop feature is sticky, cinematic, hover-led or multi-column, define its mobile equivalent deliberately.
- Mobile can simplify an interaction, but it must not remove the user's ability to understand or act.
- Do not duplicate content/data just to make a mobile version. Render desktop and mobile from the same data source where possible.

### Breakpoints

- Primary mobile breakpoint: `860px` and below.
- Header, navigation, homepage mobile replacements and JavaScript interaction boundaries must all use the same `860px` breakpoint unless a different breakpoint is documented.
- Test tablet-width edge cases, especially `768 x 1024`.
- Use `390 x 844` as the default phone QA viewport unless the owner supplies a different screenshot size.

### Layout Shape

- Mobile sections should normally be single-column.
- Use two-column mobile layouts only for compact, scannable content such as trust logos, small spec tiles or short link grids.
- Product specification strips can use compact `2 x 2` grids for four short tiles.
- Forms must be one column on mobile.
- Avoid cramped side-by-side CTAs unless both labels remain readable and tap targets stay comfortable.

### Spacing And Rhythm

- Judge spacing by visible content edges, not just section padding.
- Do not use one global mobile padding value everywhere.
- Compact utility sections need less vertical space than major narrative sections.
- Controls belong visually to the component they operate.
- Carousel dots, progress bars and button trays must not look stranded between sections.
- Do not fix spacing problems with negative margins unless there is a documented, measured reason.
- If a gap looks wrong in a screenshot, measure the actual rendered elements before changing padding.

### Tap Targets And Text

- Interactive targets should be at least `44px` high.
- Inputs, selects and textareas must use at least `16px` text on mobile to prevent iOS zoom.
- Buttons may use short labels where needed, but the action must remain clear.
- Links in cards, menus and rails must be directly tappable.
- Touch interactions must not depend on hover.
- Mobile menus must use consistent row alignment and the same navigation source as desktop.

### Media

- Never distort images or videos to fill a gap.
- Use `object-fit` and intentional crop positions rather than stretching.
- Mobile hero images need a clear focal point and must not be buried under oversized buttons.
- Autoplay, scroll-controlled or cinematic desktop media needs reduced-motion and mobile fallbacks.
- Heavy effects that are desktop-only must not attach their source or initialise on mobile.

### Carousels And Horizontal Scrollers

- Use native horizontal scroll-snap for mobile rails.
- Show a partial next card where helpful so users understand the section scrolls sideways.
- Dots or picker controls must live inside the carousel wrapper.
- Dots must be native buttons with accessible labels.
- Cards must be direct links where the whole card is visually presented as clickable.
- Confirm the rail does not create page-level horizontal overflow.

### Mobile QA

- Build compiled assets after SCSS or JS changes.
- Reload the local page after build.
- Check at minimum:
  - `390 x 844`,
  - `768 x 1024`,
  - `1440 x 900` to confirm desktop was not harmed.
- At mobile sizes, check:
  - first viewport,
  - every major section transition,
  - carousel/rail controls,
  - menu open and closed,
  - forms and success states,
  - horizontal overflow.
- A compressed full-page screenshot is not enough for important transitions.
- No mobile work is complete if there is horizontal overflow, clipped text, distorted media, stranded controls, unusable tap targets or console errors.

## Responsive Page-Build Protocol

- Define the component before styling it.
- Decide which visual parts belong together: heading, copy, image, controls, progress indicator, cards, form and following section.
- Decide desktop and mobile behaviour at the same time.
- Separate internal component spacing, component inset and section transition spacing.
- Do not solve one type of spacing by changing another.
- For sticky or viewport-height sections, calculate available stage height from the outside in.
- Treat scroll-runway height separately from visible stage layout.
- Measure visible content boundaries, not just CSS boxes.
- If the screenshot looks wrong but computed values look right, the screenshot wins.
- Change one layout responsibility at a time.
- Rebuild and inspect before stacking unrelated margin/padding fixes.

## Desktop Section Rhythm Rules

- Desktop spacing must be evaluated between meaningful content boundaries, not only section boxes.
- Do not give every desktop section identical top and bottom padding.
- Major narrative handoffs generally sit around `72–80px`.
- Compact utility/logo transitions generally sit around `48–64px`.
- Preserve deliberate overlaps such as the homepage theatre-to-instant-quote bridge.

## Asset And Cache Rules

- Scrape-derived imagery lives in `wp-content\themes\fenster\assets\images\imported`. Never reference `wp-content\fenster-reference` from theme code or `data\pages.json`; that folder is a local-only archive and is not deployed.
- Use `fenster_image_attr_string()` for theme images where practical so rendered images get explicit width/height attributes from local files. Prioritise hero, header, above-the-fold and generated-template images before lower-risk decorative images.
- Local BrowserSync can serve stale built CSS if edits are not rebuilt.
- If a browser check contradicts source code, verify the compiled asset timestamp and reload after build.
- Do not replace optimised video assets with huge reference originals.
- Static asset cache lifetimes are a host/CDN concern for deployed Bedrock assets because the local `app/public/.htaccess` is ignored by the scoped theme repo. SiteGround/CDN should serve theme CSS, JS, WOFF2, images and videos with long-lived immutable cache headers while HTML/generated pages keep short public cache headers.
- Optimised homepage hero video:
  - `assets\videos\home\fenster-home-hero.mp4`
- Integral Blinds reveal video:
  - `assets\videos\product-scroll\integral-blinds-chroma.mp4`

## Accessibility Rules

- Interactive controls should be real buttons or links.
- Cards that visually act as links should be direct links.
- Updating visual states should also update accessible labels where relevant.
- Do not rely on hover-only controls.
- Respect `prefers-reduced-motion`.
- Reduced-motion users should receive static or simplified content, not broken content.

## Verification Gate

A change is not complete until the relevant checks pass:

- Build passes when SCSS/JS changed.
- PHP lint passes when PHP changed.
- Desktop was not harmed by mobile changes.
- Mobile has no horizontal overflow.
- Console has no relevant errors.
- Forms still submit in place.
- Shared components remain shared.
- Documentation is updated in the correct file.
