# Fenster Glazing Master Context

Last updated: 2026-07-06

This document is a master handover for another AI or developer. It explains what the Fenster Glazing site is, how it is built, what the SEO and UX model is, what has already been fixed, what is still risky, and how to work without undoing the accepted architecture.

If you are a new AI, read this first, then read the source-of-truth docs listed below before editing code.

## 1. Site Identity

Fenster Glazing is a UK glazing company serving residential and commercial customers, with a strong Northamptonshire and wider service-area footprint. The website is a lead-generation and trust-building site. Its core jobs are:

- Explain products clearly enough for homeowners and commercial buyers to choose the right route.
- Convert visitors into enquiries, phone calls and online quote starts.
- Rank for local and product-led searches without publishing thin duplicate pages.
- Present the company as premium, practical, local and credible.
- Avoid the "template WordPress brochure" feel.

The site should feel:

- Premium but not flashy.
- Practical rather than abstract.
- Local and established.
- Dense enough to be useful, but not cluttered.
- Smooth and modern without making performance worse.

The public site should not feel like scraped content, a generic product catalogue, or a landing-page factory.

## 2. Current Canonical State

Canonical live domain:

- `https://fensterglazing.com/`

Canonical test domain:

- `https://test.fensterglazing.com/`
- The test site is intentionally protected with Basic Auth to avoid being indexed as a duplicate.
- Username: `fenster`
- Password: `Fenster`

GitHub:

- `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`

Local project root:

- `C:\Users\zacpl\Local Sites\fenster-glazing\app\public`

Local theme root:

- `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster`

Server installs:

- Test root: `~/www/test.fensterglazing.com/public_html`
- Live root: `~/www/fensterglazing.com/public_html`
- Test and live are Bedrock installs.
- Server theme path is `web/app/themes/fenster`.

Latest live sequence at this handover:

- `aa45896 Strip residual pixel snippets before consent`
- `0b1fac2 Gate tracking behind cookie consent`
- `77798b8 Document deploy policy preference`
- `da4711d Rewrite cat and dog flaps page`
- `0ec487a Improve Lighthouse performance path`
- `e660a4b Update launch handover docs`
- `aff62a0 Fix article CTA form layout`
- `7c973b5 Defer heavy media and quote embeds`
- `5696140 Rework commercial glazing hub`

Always run `git log --oneline -12` before assuming this is still current.

## 3. Source Of Truth Docs

Project docs live in `app/public`.

Read these before work:

- `AI.md` - coding rules, generated-page rules, SEO rules, form rules, product rules, verification expectations.
- `HANDOVER.md` - current architecture and recent site state.
- `LIVECHANGES.md` - SSH, deploy commands, live/test runbook and safety rules.
- `STYLE.md` - visual design contract and responsive design rules.
- `AUDIT.md` - audit findings, open risks and remediation backlog.
- `PROGRESS.md` - dated change history.
- `HOMEPAGE.md` - homepage-specific architecture and "do not undo" list.

This `context.md` does not replace those files. It is the briefing document that explains the whole picture.

## 4. WordPress And Legacy Admin Content

The site used to rely on imported WordPress content and ACF-style fields. Some old page content may still appear in the WordPress admin if you edit a page.

That is normally not a public-site problem.

The current site is intentionally code-driven. For generated routes and key pages, the theme controls public output through PHP templates and data arrays. The editor body or old ACF fields can remain in the database as legacy/reference content without affecting the live page, as long as the route is still handled by the theme.

Do not try to rebuild the site around ACF, Elementor or editable admin fields unless the owner explicitly changes direction.

Risk rule:

- If a route is theme-handled, edit theme code/data.
- If a route falls back to normal WordPress page rendering, admin content may matter.
- If unsure, inspect the rendered HTML and route handling in `inc/generated-pages.php` before editing database content.

## 5. Architecture Overview

The active theme is `fenster`.

Important files and directories:

- `wp-content/themes/fenster/functions.php`
- `wp-content/themes/fenster/inc/generated-pages.php`
- `wp-content/themes/fenster/inc/site-data.php`
- `wp-content/themes/fenster/inc/product-hub-data.php`
- `wp-content/themes/fenster/inc/enquiries.php`
- `wp-content/themes/fenster/inc/consent.php`
- `wp-content/themes/fenster/inc/security.php`
- `wp-content/themes/fenster/template-parts/sections/generated-page.php`
- `wp-content/themes/fenster/template-parts/sections/generated-article.php`
- `wp-content/themes/fenster/template-parts/components/enquiry-form.php`
- `wp-content/themes/fenster/src/scss/main.scss`
- `wp-content/themes/fenster/src/js/main.js`
- `wp-content/themes/fenster/assets/css/main.css`
- `wp-content/themes/fenster/assets/js/main.js`
- `wp-content/themes/fenster/data/pages.json`

Build from the theme folder:

```powershell
npm.cmd run build
```

PHP lint example:

```powershell
& 'C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe' -l 'C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\template-parts\sections\generated-page.php'
```

The repo is intentionally scoped to the theme and launch docs. Do not add WordPress core, uploads, Local config, database dumps, `wp-config.php`, Bedrock `.env`, plugins, node modules or backups.

## 6. Generated Routes Are The Core

The generated-page system is the route truth for much of the site.

Key responsibilities in `inc/generated-pages.php` include:

- Matching generated slugs.
- Owning theme SEO output.
- Handling 301 redirects.
- Handling 410 gone routes.
- Handling noindex routes.
- Serving sitemap output.
- Suppressing stale SEO plugin output where the theme owns SEO.
- Rendering hardcoded utility routes such as `/terms-conditions/`.

Key rendering happens in:

- `template-parts/sections/generated-page.php`
- `template-parts/sections/generated-article.php`

Product and commercial routing uses explicit slug whitelists. Do not replace that with substring matching. A previous issue forced blog/article pages through the product template because slugs contained product-like words.

Imported scraped data is useful background but not trusted blindly. The live theme should filter, override or replace scraped content when it contains:

- Footer/legal debris.
- Old social snippets.
- Placeholder JSON-LD.
- Test-domain URLs.
- Brochure prompts where a real buying guide is needed.
- Generic supplier copy.
- Wrong aliases.
- Duplicated or scraped boilerplate.

## 7. SEO Model

Theme-owned SEO is intentional.

Generated pages suppress Yoast/Rank Math public head output to prevent stale titles, duplicate meta, old schema and imported social tags from leaking into public pages.

The theme owns:

- Titles.
- Meta descriptions.
- Canonicals.
- Robots tags.
- OpenGraph/Twitter output where applicable.
- LocalBusiness schema.
- FAQ schema.
- Breadcrumb schema.
- XML sitemap output.
- 301 and 410 route handling.

Do not restore raw imported `schema_json_ld`. It contained old designer-tool schema, placeholder VideoObject data and unsubstantiated rating claims.

Do not add aggregateRating or Review schema unless there is a verifiable review feed and the claim can be substantiated.

Core WordPress sitemaps are intentionally disabled. The theme serves:

- `/sitemap.xml`
- `/page-sitemap.xml`

Robots should advertise the theme sitemap. Check live robots ownership if changing this because a physical/plugin robots file has previously introduced crawl-delay and sitemap ownership drift.

Thin or utility pages should be `noindex,follow` and absent from the sitemap where appropriate.

Known intentionally noindex/thin examples include:

- `gallery`
- `downloads`
- `videos`
- `customer-portal`
- `refer-a-friend`
- `brochures`
- `apecs-terms-conditions`
- `fenster-partners`
- some temporary/review surfaces

## 8. Canonicals, Redirects And Server-Level Issues

Current canonical host is apex:

- `https://fensterglazing.com/`

The `www` host was previously serving as a 200 duplicate. A server `.htaccess` redirect has now been added so `https://www.fensterglazing.com/` should 301 to the apex host.

Legacy redirect issues fixed in this session:

- `/terms-conditions/` no longer 301s to malformed `/privacy-policy//`.
- `/aluminium-bifold-doors-northampton/` no longer 301s to the parent product route.

These issues came from live database/server redirect handling, not the theme. Future agents should remember that redirect collisions can live outside the theme.

When diagnosing a route:

1. Check theme route handling.
2. Check generated redirects/gone/noindex arrays.
3. Check WordPress redirect-manager/database rows.
4. Check `.htaccess` and SiteGround config.
5. Check cache.

## 9. Consent, Analytics And Tracking

UK PECR/GDPR consent matters.

Before this handover, GTM and Microsoft Clarity were firing without a consent banner. That has been fixed with a theme-owned consent layer.

Current consent implementation:

- File: `inc/consent.php`
- Included by: `functions.php`
- Styles: `src/scss/main.scss`
- Built CSS: `assets/css/main.css`

The consent layer:

- Suppresses known raw GTM, Clarity and Meta Pixel snippets before consent.
- Blocks Insert Headers/GTM/Clarity output that would otherwise fire too early.
- Renders a cookie banner and settings button.
- Loads tracking only after analytics consent.
- Supports rejection without firing tracking.

Known IDs used by the site:

- GTM: `GTM-K89BCS9`
- Clarity: `xi7rk1pic8`
- Meta Pixel: `4315058575189194`

Do not paste raw tracking snippets into plugin settings or header/footer fields unless they remain blocked until consent.

Remaining conversion-tracking work:

- Add meaningful `dataLayer` events for enquiry success.
- Add phone-click tracking.
- Add online quote / WindowCAD open tracking.
- Make sure events respect consent state.

## 10. Forms And Enquiries

There should be exactly one customer-facing form component:

- `template-parts/components/enquiry-form.php`

Do not add raw standalone forms to templates.

Form submissions are handled in:

- `inc/enquiries.php`

Current model:

- Forms use AJAX enhancement from `src/js/main.js`.
- No-JavaScript fallback should remain.
- Valid enquiries save as private `fenster_enquiry` posts.
- Office emails go to `info@fensterglazing.com`.
- Customer confirmation emails are paused until authenticated SMTP is configured.
- Optional file uploads are supported and attached to office emails.

Open form risk:

- Spam protection still needs hardening. The old honeypot/speed gate was disabled or is not sufficient. Add a safe honeypot, Turnstile or equivalent approach without breaking genuine leads.
- Add an unsent-email alert or admin visibility if mail delivery fails.
- Do not re-enable customer confirmations until authenticated SMTP is configured.

## 11. UX And Design Direction

Read `STYLE.md` before changing visual work.

The site should avoid repeated section cards and repeated gradients. It uses a continuous page background model rather than repainting the same gradient on every wrapper.

Design principles:

- Premium and practical.
- Warm but not beige-template.
- Clear routes to enquiry, phone and quote.
- Trust evidence should be visible but compact.
- Product pages should be decision tools, not brochure dumps.
- Mobile should be designed intentionally, not squeezed after desktop.
- Use real content and assets, not decorative filler.

Typography:

- Do not make every H1/H2 huge.
- Normal content pages should use moderate heading scale.
- Hero-scale type belongs only on real heroes.
- Form headings and compact panels should stay smaller.

Cards:

- Use cards for repeated items, modals and genuinely framed tools.
- Do not place cards inside cards.
- Do not make every page section a floating card.

Mobile:

- Primary breakpoint is `860px`.
- Test `390 x 844` for phone.
- Test `768 x 1024` for tablet edge cases.
- Avoid horizontal body scroll.
- Tap targets should be at least 44px.
- Inputs should use at least 16px font size on mobile.
- Hover-only interactions need touch equivalents.

## 12. Homepage Model

Read `HOMEPAGE.md` before editing the homepage.

The homepage is a premium first impression and conversion page. It should not become a generic marketing page.

Accepted homepage ideas:

- Hero with video/poster treatment.
- Strong trust cards.
- Product theatre / strong product browsing.
- Instant pricing route.
- Review/trust block.
- Local service-area links.
- Continuous background and controlled section rhythm.

Performance-sensitive homepage rules:

- The homepage hero video is heavy and must not become part of the initial mobile payload again.
- Mobile/slow connections should see the poster first.
- Heavy media should be deferred or gated appropriately.
- Keep first viewport lightweight.

Do not restore the old loading screen.

## 13. Product Page Model

Product pages are not meant to show raw scraped galleries or generic manufacturer boilerplate.

Product source files:

- Product USP/specification data: `inc/site-data.php` under `product_usps`.
- Product visible copy overrides: `inc/site-data.php` under `product_content`.
- Manufacturer/system hub data: `inc/product-hub-data.php`.
- Product route template: `template-parts/sections/generated-page.php`.

Product pages should:

- Explain the product in plain customer language.
- Show key specifications without inventing values.
- Link to focused hubs for colours, obscure glass and hardware where needed.
- Use curated media and local assets.
- Keep quote routes visible.
- Avoid surfacing scraped footer/legal/promo debris.

Do not invent U-values or technical claims. Products with supplied U-values show them first. Composite Doors and Integral Blinds currently do not have supplied U-values. Integral Blinds controls should be described as `Magnetic or electric`.

Product quote embeds:

- Product-specific WindowCAD URLs are mapped in `generated-page.php`.
- Product instant quote links should jump to `#fenster-product-quote` where a product-specific collection exists.
- Desktop/tablet quote embeds can show `Expand view` and `Open in new tab`.
- Mobile should show one same-tab `Open quote tool` action.
- Do not put large iframes before scroll-following or cinematic product sections.
- Quote iframe wrappers should use `data-lenis-prevent`.

## 14. Key Product And Content Routes

### `/cat-and-dog-flaps/`

This page was badly scraped and has been rewritten.

Current model:

- Route title/SEO override in `inc/generated-pages.php`.
- Product copy in `inc/site-data.php`.
- Product hub data in `inc/product-hub-data.php`.
- Custom pet-flap guide section in `generated-page.php`.
- Generic product gallery/spec block suppressed for this route.

It should read as a proper cat flap and dog flap glazing service page, not as scraped fragments.

### `/sliding-sash-windows/`

This is a Roseview route, not generic Liniar uPVC.

Rules:

- System: Roseview.
- Logo: `assets/partners/roseview-logo-new.png`.
- Models: `Ultimate Rose`, `Heritage Rose`, `Charisma Rose`.
- Keep sash-specific detail: meeting rails, mechanical/welded joints, sash furniture and Roseview model differences.
- Do not render the generic window handle section on this route.

### `/colour-options/`

Canonical colour hub. `/upvc-colours/` and `/aluminium-colours/` redirect to this route.

Rules:

- Colour data lives in `inc/site-data.php` under `colour_options`.
- Keep it customer-facing.
- Do not expose internal supplier scrape names or provenance dumps.
- uPVC swatches use optimised assets in `assets/images/products/colours/liniar-swatches`.

### `/obscured-glass/`

Canonical route for obscure glass. `/obscure-glass/` redirects there.

Keep terminology and internal links consistent.

### `/terms-conditions/`

This is a hardcoded virtual utility page in `inc/generated-pages.php`.

Important history:

- A legacy redirect previously sent it to malformed `/privacy-policy//`.
- That was a legal-page problem and has been fixed.

Do not remove the hardcoded route unless replacing it with an equally reliable legal-page route.

### `/contact/`

The accepted contact model is a bold route-card hub with obvious jump targets. Keep the shared enquiry form below the hub.

Contact-page work should follow the established "in your face" routing style, not a quiet generic contact page.

### `/online-quote/`

This is a key conversion route. Verify it after deploys. Do not make quote embeds eager in ways that harm homepage/product performance.

### `/areas-we-cover/`

This is a public service-area route and footer target. It should remain useful and indexable unless SEO strategy changes.

### `/commercial-areas/`

Temporary/review-style route in the commercial/location work. Treat indexation carefully. Check current noindex/nav status before changing.

## 15. Commercial And Location SEO

The site has a commercial SEO/location model that includes county-style generated pages and local service-area routes.

Important principles:

- Avoid duplicated town/county boilerplate.
- Keep H1/meta unique.
- Use the hero form and visible phone route for commercial conversion.
- Do not publish huge sets of weak location pages without meaningful differentiation.
- Check the sitemap after route changes.

Commercial hub work was recently changed in `5696140 Rework commercial glazing hub`.

Known issue:

- There is a broken internal `/commercial-projects/` link to a residential case-study area that returns 410. This should be fixed by either replacing the link with a live commercial route or creating a proper commercial projects page.

## 16. Performance Strategy

Recent performance work focused on first-viewport speed without destroying visual quality.

Implemented performance improvements include:

- WOFF2 Gibson fonts.
- Critical first-viewport CSS.
- Async activation of main stylesheet.
- Homepage hero-poster preload.
- Image dimension helpers.
- Mobile/constrained-connection hero video interaction gate.
- Below-fold homepage `content-visibility`.
- Deferred heavy media and WindowCAD embeds.
- Lazy loading non-primary product theatre media.

Do not undo the performance model by:

- Making every iframe eager.
- Making the homepage hero video part of the initial mobile payload.
- Loading heavy product media before it is near the viewport.
- Removing width/height attributes from images.
- Blocking render with unnecessary CSS/JS.

Remaining likely performance work:

- Create smaller/mobile-specific hero video renditions.
- Improve responsive image `srcset`/`sizes`.
- Compress or replace oversized social/hero images.
- Audit unused CSS and JS.
- Keep third-party tracking blocked before consent.
- Check SiteGround dynamic cache and browser cache behaviour.

Recent Lighthouse symptoms before the performance fixes included:

- FCP around 4.3s on Slow 4G.
- LCP around 14.5s on Slow 4G.
- Render-blocking request savings.
- Large payload around 11.8 MB.
- Image delivery savings.
- Unused CSS/JS warnings.

Expect the score to vary. Use Lighthouse as a guide, then inspect the network waterfall and actual LCP element.

## 17. Accessibility And Best Practices

Recent Lighthouse accessibility was not disastrous but had issues:

- Some prohibited ARIA attributes.
- Some contrast failures.
- Links relying only on colour.
- Touch targets too small or too close.
- Image dimensions missing in places.

When editing:

- Keep focus states visible.
- Do not rely on colour alone for links.
- Maintain contrast on dark overlays and cards.
- Keep tap targets comfortable.
- Avoid adding ARIA unless it is correct.
- Test keyboard interaction for custom controls.
- Keep form labels readable and associated.

## 18. Security And WordPress Hardening

`inc/security.php` owns public WordPress hardening.

Current hardening includes:

- REST user enumeration blocked.
- XML-RPC disabled through WordPress filter.
- `X-Pingback` removed.
- WordPress generator/RSD/shortlink/REST/oEmbed/emoji head output stripped.

Do not remove this unless replacing with equivalent or better protection.

## 19. Deployment Model

Golden rule:

- Deploy the theme only.

Never replace the whole WordPress install. Never overwrite `.env`, Bedrock config, plugins, uploads or database unless explicitly asked.

Normal flow:

1. Make the change locally.
2. Build assets if SCSS or JS changed.
3. PHP-lint changed PHP files.
4. Check `git diff`.
5. Commit and push to GitHub `main`.
6. Small scoped changes can deploy direct to live after checks.
7. Bigger layout/template/routing/form/SEO changes go to test first.
8. Verify on test.
9. Confirm fresh live backup for larger changes.
10. Deploy same committed theme to live.
11. Flush cache.
12. Verify changed pages plus core pages.

Deploy to test:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/test.fensterglazing.com/public_html && wp cache flush"
```

Deploy to live:

```powershell
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard origin/main && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/fensterglazing.com/public_html && wp cache flush"
```

The `rsync --delete` is safe only because both source and target are the theme folder. Never aim it at `public_html`, `web`, uploads, plugins or a guessed path.

SSH details are in `LIVECHANGES.md`. Do not commit private keys, passphrases or hosting passwords.

## 20. Test Site Indexation

The test site used to be publicly crawlable and indexable, which risked duplicate indexing against the live domain.

Current state:

- Basic Auth is enabled for `test.fensterglazing.com`.
- Unauthenticated access should return 401.
- Authenticated access should return 200.

Keep it protected unless the owner explicitly asks for public temporary review access. If public access is ever needed, add strong `noindex` and robots protection and remove it afterwards.

## 21. Open SEO And Technical Backlog

High or important remaining issues from the audit and current state:

- Add robust spam protection to the enquiry form without harming conversion.
- Add consent-aware lead event tracking for form success, phone clicks and quote-tool opens.
- Fix the broken `/commercial-projects/` internal link or create a valid route.
- Resolve robots.txt ownership and remove/justify any `Crawl-delay: 10` if still present.
- Compress or replace the oversized OG/social image, especially the 2.3 MB showroom PNG issue noted in audit work.
- Confirm SiteGround dynamic cache is enabled where safe.
- Consider HSTS once redirects and HTTPS are stable.
- Shorten overlong meta descriptions.
- Review quote-intent duplicate pages and consolidate where needed.
- Continue performance work on mobile video, responsive images and unused assets.
- Re-check review platform claims and counts so public claims match visible evidence.
- Configure authenticated SMTP before customer confirmation emails.
- Add alerts/admin visibility for unsent enquiry emails.
- Verify `/wcad-thank-you/` remains intentionally absent or replaced with a controlled thank-you path if required.

## 22. Code Cleanup Backlog

Known cleanup themes:

- `generated-page.php` is large and could be split carefully by concern.
- Some legacy homepage/Three.js hooks remain inactive. Do not reintroduce Three.js unless explicitly requested.
- Remove or isolate dead branches only after confirming they are not used by generated routes.
- Keep route memoisation/canonical handling central.
- Consider centralising canonical host constants if host logic grows.
- Keep product data in data files rather than scattering copy inside templates.

Do not perform broad refactors during urgent launch fixes. Keep changes scoped.

## 23. Things Not To Break

Do not break these accepted decisions:

- Theme-owned generated SEO output.
- Theme-only deployment.
- No SiteGround clone/staging workflow.
- Test site Basic Auth.
- Consent-gated tracking.
- Shared enquiry form component.
- Private `fenster_enquiry` saving before email.
- Mobile quote tool single same-tab action.
- Homepage hero poster/mobile video gating.
- Deferred quote embeds and heavy media.
- Roseview model for `/sliding-sash-windows/`.
- Canonical `/colour-options/`.
- Canonical `/obscured-glass/`.
- Hardcoded virtual `/terms-conditions/`.
- Product pages using curated data, not raw scraped galleries.
- Sitemap and route controls in the generated-page system.

## 24. First 30 Minutes For A New AI

Do this before changing code:

1. `cd C:\Users\zacpl\Local Sites\fenster-glazing`
2. `git status --short`
3. `git log --oneline -12`
4. Read `app/public/AI.md`.
5. Read `app/public/HANDOVER.md`.
6. Read `app/public/LIVECHANGES.md`.
7. Read `app/public/STYLE.md` if changing UI.
8. Read `app/public/AUDIT.md` if changing SEO, performance or launch issues.
9. Inspect the exact route/template/data block before editing.
10. Build/lint only what changed.
11. Commit and push scoped changes.
12. Use test first for larger template/routing/form/SEO/layout changes.

## 25. Verification Checklist

After most changes, verify:

- Homepage loads.
- Changed route loads.
- `/online-quote/` loads.
- A representative product route loads, e.g. `/casement-windows/`.
- A representative location/generated route loads.
- `/sitemap.xml` loads if routing/SEO changed.
- `/terms-conditions/` returns 200 if legal/footer/routing changed.
- `https://www.fensterglazing.com/` redirects to apex if server config changed.
- Test site still requires Basic Auth.
- No tracking fires before consent if analytics/header code changed.
- Form submission still works if form/enquiry JS/PHP changed.
- Mobile has no horizontal overflow.
- Lighthouse/network checks if performance was touched.

Useful commands:

```powershell
git status --short
git diff --stat
git diff -- app/public/wp-content/themes/fenster
npm.cmd run build
```

PHP lint changed files individually:

```powershell
& 'C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe' -l 'PATH_TO_CHANGED_FILE.php'
```

## 26. Mental Model

The site is not a normal WordPress content-editing project. It is closer to a custom, code-driven WordPress frontend that uses WordPress as the host/runtime and some database content as legacy source material.

Good changes usually:

- Read the route/data/template first.
- Fix the source of truth rather than hiding symptoms with CSS.
- Keep docs in sync when the accepted model changes.
- Preserve conversion routes.
- Preserve performance deferral.
- Preserve SEO ownership.
- Verify live behaviour, not just local assumptions.

Bad changes usually:

- Edit old admin page content and expect the public route to change.
- Restore raw scraped content.
- Re-enable SEO plugin head output on generated pages.
- Clone or overwrite the live WordPress install.
- Make heavy videos/iframes eager.
- Add new forms outside the shared component.
- Add tracking snippets outside the consent layer.
- Make broad refactors during launch triage.

If in doubt, keep the change small, inspect rendered output, and document the final accepted model in the right source-of-truth doc.
