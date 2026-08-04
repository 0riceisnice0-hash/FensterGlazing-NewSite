# Fenster Glazing Handover

Last updated: 2026-08-04

This file gives a new AI agent the current context needed to work on the whole site.

Use:

- `AI.md` for coding rules and QA standards.
- `AUDIT.md` for the 2026-07-03 master site audit, launch-blocker remediation status and remaining backlog.
- `STYLE.md` for site-wide visual styling, continuous background rules, section rhythm and mobile design expectations.
- `HOMEPAGE.md` for homepage-specific design and implementation context.
- `PROGRESS.md` for dated progress reports.
- `LIVECHANGES.md` for the exact SSH/deploy workflow, live safety rules and what not to touch.
- `LIVECHAT.md` for the complete Legend AI assistant architecture, live behaviour and commit history.
- `https://github.com/0riceisnice0-hash/Marketing-Dashboard/blob/main/WEBSITE-TRACKER.md` for the Website Tracker operating model, consent boundary and how to interpret its data. This is the tracker source of truth; do not infer meaning from a dashboard card label alone.

## Important Updates

- **The live SHA lives in `LIVECHANGES.md` and nowhere else.** This line used to carry its own copy and was three days and four releases out of date by 2026-08-04, while `HANDOVER.md` and `nick.md` each carried a different stale one. One pointer, one file. **Re-establish live by checksum immediately before any deploy anyway**, on more than one file and on files the candidate commits actually differ in: three of five once tied across two candidates and only two separated them.
- **`/patio-doors/` and `/handle-options/` carry the sliding patio handle** as of 2026-08-02: `patio_handles` in `inc\site-data.php`, assets under `assets\images\products\handles-patio`, five Mila ProLinea finishes. It is a separate family from `door_handles` because a slider takes a D-pull rather than a lever, and it is deliberately not on `/aluminium-sliding-doors/`. See the Patio Handle Rule in `AI.md`.
- **Deploy trap — read before any live deploy.** The live deploy one-liner in `LIVECHANGES.md` runs `git reset --hard origin/main`, so it ships *everything on `main`*, not the specific commit you verified. On 2026-07-18 a deploy of the small Legend iframe fixes swept fourteen unapproved composite-door commits onto production with them. If you need to release one approved commit, reset the server repo cache to that exact SHA instead of `origin/main`.
- GitHub is live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. It versions the custom theme and docs only, not the full WordPress install.
- Local development uses the standard WordPress path `wp-content\themes\fenster`, but SiteGround test/live are verified Bedrock installs. Server theme paths are `~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/` and `~/www/fensterglazing.com/public_html/web/app/themes/fenster/`.
- Deployment should update the `fenster` theme from the GitHub repo while leaving production `.env`, Bedrock config, uploads, database and plugins untouched. Do not deploy `wp-content\fenster-reference`; it is a local-only scrape archive and no runtime code should depend on it.
- Test and live are both running the new `fenster` theme. Every completed change follows local edit -> build/lint -> commit/push -> test deploy -> test verification. A later live deployment uses that same committed theme after the appropriate approval and backup checks.
- Do not use SiteGround clone/staging tools for this project. The safe model is always a theme-only test deployment from GitHub before live, regardless of change size. This avoids editing test and live at the same time and avoids accidental database URL rewrites.
- Generated pages are theme-owned for SEO. Yoast/Rank Math public head output is suppressed on generated pages to prevent duplicate metadata and stale imported schema/social tags. Do not reset Rank Math for launch; use it only later if there is a clear admin-tool reason.
- Launch SEO hardening is complete for the current technical blockers: homepage title/meta override, generated route 301 normalisation, generated breadcrumb schema, public cache headers, sitemap scrub to 421 currently verified canonical URLs, `/commercial-areas/` removed from the header, and footer links to `/areas-we-cover/` and `/terms-conditions/`.
- The stale pre-launch audit was rechecked on live on 2026-07-06. Current verified state: social metadata is theme-owned and clean, `lang="en-GB"` is active, `/upvc-colours/` and `/aluminium-colours/` redirect to `/colour-options/`, public REST user enumeration returns 401, WordPress generator/RSD/oEmbed/wp-json/shortlink head links are stripped, and the theme sitemap is served before Rank Math with 421 canonical URLs.
- Latest local SEO quick-win state: commit `68f38ae` restored `/areas-we-cover/` to the generated sitemap/link graph, added LocalBusiness `geo`/`hasMap`/`sameAs`, cleaned local money-page title/meta overrides and strengthened links into `/double-glazing-milton-keynes/` plus the agreed pricing hub `/window-door-prices-milton-keynes/`. Commit `51c3550` removed the accidental `/double-glazing-prices-milton-keynes/` route and all internal links to it; do not recreate that exact route unless the owner explicitly asks. Roof-light keyword coverage is already handled in title/meta overrides for `/roof-lanterns/`, `/roof-lanterns-milton-keynes/` and `/roof-lanterns-northampton/`.
- The residential location matrix has unique generated metadata across the 13 town x 21 product pages. Commercial county metadata is profile-specific, and Isle of Wight commercial glazing has been removed/410'd as inaccessible coverage.
- Mobile launch fixes are complete for the About process cards, Contact page CTA cards and quote-tool controls. Mobile quote embeds use one same-tab `Open quote tool` action; desktop keeps `Expand view` and `Open in new tab`.
- Test and live enquiry delivery have been verified: valid submissions save as private `fenster_enquiry` posts and send office HTML emails to `info@fensterglazing.com`.
- The shared form's reusable `consultation_booking` mode has a dedicated indexable `/book-a-consultation/` page, and **that is the only place it renders** as of 2026-08-02. The Contact page carries the general enquiry form instead: `931c7ef` had converted that page's enquiry form into a second booker in place, leaving `/contact/` with no way to send a plain message, so the site repeated one journey and offered the other nowhere. The Contact hub card links here. Its accepted journey is deliberately short: a booking-first hero with the calendar as the dominant action and concise Trustpilot/FENSA reassurance directly beneath it; one large, art-directed bifold-door image paired with consultation advice and icon-led phone/email contact; concise visible FAQs/FAQPage schema; then the real review showcase. Do not restore process cards, a detached homepage proof wall, generic image-card grids or related-link filler. Its date stage is a compact six-week calendar card sized to the interaction, with a concise availability strip: Monday-Friday, 9am-4pm, excluding England-and-Wales bank holidays. The final details stage is a dedicated light-surface form with an appointment summary, legible bordered fields and a clearly contained consent/submit area rather than the shared dark-form styling. The official GOV.UK holiday feed is cached and enforced in both the picker and submission validation. Its background is one continuous `--fg-page-gradient` canvas, per `STYLE.md`. The desktop header, Products menu CTA and Contact consultation card lead to this canonical route. It saves and emails the selected date/time as a consultation request. It is a request flow, not live availability; the office must confirm the appointment.
- WindowCAD/AdminBase lead relay is theme-owned again through `inc\adminbase.php`. The old `wraith` REST endpoint `/wp-json/fenster/v1/windowcad` is restored, normal saved enquiries also relay through `fenster_enquiry_created`, and credentials must stay in server config/options rather than committed code.
- The live Marketing Dashboard Website Tracker is the consented, no-PII attribution surface. Its source code, API implementation and tracker README are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard`. It stores opaque `FGV-…` visitors and `FG2-…` journeys for 90 days in the same consenting browser, first-touch attribution, pages/time, meaningful link/quote/form/phone/email events, completed WindowCAD quotes and a clickable journey timeline. It is not a CRM: personal lead data stays in WordPress/AdminBase.
- WindowCAD must keep its office **Reference** field untouched. The website URL parameter maps only to WindowCAD’s separate **Tracking** field. Accepted visitors receive `FG2-…`; rejected-cookie quotes write `rejected-cookies`, and no-choice quotes write `cookie-consent-not-accepted`. Those latter two values still create office leads but are intentionally excluded from dashboard joins.
- 2026-07-21 tracking audit outcome (corrected): WindowCAD's tracking capture is invisible and URL-driven and was never broken. The app reads the `tracking=` URL parameter and includes it in the submission's Tracking info property independent of the visible form field list; verified end-to-end the same day via intercepted submissions plus a live owner test (`FG2-ZACLIVETEST0721` reached WindowCAD, WordPress, AdminBase and the dashboard). Leads without a tracking value are sessions that did not start from a site URL (office-entered projects, direct or re-opened WindowCAD links). The genuine 2026-07-21 outage was AdminBase's renewed TLS certificate (Sectigo R46 root missing from WordPress' bundled CA file): relays failed with cURL error 60, leaving leads in WordPress but not AdminBase; fixed by `fenster_adminbase_http_ssl_args()` using the host system trust store, the two stranded leads were re-relayed, and the WindowCAD handler now sends the dashboard `quote_completed` before attempting AdminBase. Customer retail submissions were genuinely quiet 2026-07-16 to 2026-07-21; volume is now observable through the dashboard's consented and aggregate quote-completion counts.
- Google Ads quote attribution is completion-led. Campaign suffixes carry `ads={adgroupid}` into the Fenster landing URL; the theme preserves that tracker and copies it into every WindowCAD URL alongside the existing `tracking=FG2-...` value. Accepted ad clicks also store `gclid`/`gbraid`/`wbraid` in WordPress against the FG2 journey through `/wp-json/fenster/v1/ad-attribution`. When WindowCAD posts a completed quote back, the private `fenster_enquiry` receives the ads tracker and click ID needed for offline conversion import. The click ID never goes to the Marketing Dashboard or AdminBase. `quote_opened` and `quote_iframe_loaded` remain diagnostic funnel events only.
- Consent health is aggregate-only and granular: `necessary_only`, `analytics_only`, `marketing_only` and `all`, per day and per environment. Rejected visitors must never get a visitor/journey ID or browsing event. **Banner impressions are counted again** (`shown` from the mandatory modal into `banner_shown`), on the owner's 2026-08-02 instruction; they are a health check only and must never be used as a denominator, because they structurally undercount against choices. See the consent rules in `AI.md` before touching either. Future Focus Group call integration should send actual call outcomes into the dashboard only after an API/webhook or scheduled export is available; phone taps alone remain intent, not confirmed calls.
- Non-consented traffic now has a separate statistical-only aggregate path. It records hourly totals for page views, engagement, quote/form starts or sends and contact intent, grouped by page, broad device class and referrer host. It never creates `FGV`/`FG2`, visitor timelines, fingerprinting values, IP-derived identifiers, ad joins or lead joins. The footer provides an anonymous-statistics opt-out.
- Office email delivery currently uses the old proven envelope: `WordPress <wordpress@fensterglazing.com>` to `Fenster Glazing <info@fensterglazing.com>`. Customer confirmation emails are paused unless authenticated SMTP is configured, so public form copy must not promise a confirmation email.
- Enquiry forms support optional file uploads (`attachments[]`) for photos, drawings, schedules and documents. Files are stored against the private enquiry and attached to the office email.
- Live mail deliverability still needs authenticated SMTP for future customer-facing sends. The mailbox MX is Microsoft 365, and unauthenticated PHP mail can show Outlook verification warnings. The theme supports `FENSTER_SMTP_HOST`, `FENSTER_SMTP_PORT`, `FENSTER_SMTP_USERNAME`, `FENSTER_SMTP_PASSWORD`, `FENSTER_SMTP_SECURE`, `FENSTER_MAIL_FROM` and `FENSTER_MAIL_FROM_NAME` from Bedrock `.env` or PHP constants.
- Legend's AI chat backend is theme-owned in `inc\legend-assistant.php` and exposed only through `POST /wp-json/fenster/v1/legend/chat`. Both test and live Bedrock environments are separately configured with `FENSTER_OPENAI_API_KEY`; `FENSTER_OPENAI_MODEL` is optional and defaults to `gpt-5.4-mini`. Never commit, publish, place in JavaScript or paste either key into project documentation. The complete approved Legend release is live through source commit `cd5b430` (latest theme-code commit `d9b9ffc`) as of 2026-07-16.
- Legend receives a bounded snapshot of the current page (title, description, navigation, main content and footer) and recent in-panel conversation. The server supplies Fenster-specific identity, tone, accuracy, privacy and safety instructions; treats page text as untrusted reference material; validates the WordPress nonce and same-site request; rate-limits anonymous clients; and sends OpenAI requests with `store: false`. Prompts and responses are not written to theme logs.
- Visible `.fg-team-person` profiles are promoted into high-priority current-page facts. The backend also injects a query-matched excerpt from the current page around the first meaningful question term. Keep both mechanisms: the rendered Zac Bartley profile is created by the team template and is not represented accurately by the older imported source record, so generic related-page retrieval alone cannot be trusted for staff-name questions.
- `fenster_legend_verified_direct_reply()` is the final safeguard for common Zac Bartley identity and role questions. It returns the owner-approved Marketing Executive remit before calling OpenAI, so model variation or missing browser context cannot make the answer uncertain. Keep verified direct replies narrow and owner-approved.
- `fenster_legend_normalise_reply_link()` enforces consistent useful links after the model responds. It converts full Fenster test/live Markdown URLs to relative routes, preserves at most one useful route and automatically links the first known bold product recommendation. This prevents production replies pointing at test and avoids relying on the model to format every recommendation consistently.
- When a visitor asks a factual Fenster question, Legend's backend first supplies owner-confirmed business facts and query-matched canonical `product_usps`, then searches a bounded local index of other published theme/WordPress pages and supplies up to four relevant excerpts if matches exist. Verified facts outrank imported FAQs, articles and generic copy. This is same-site retrieval, not open-web browsing. The chat renderer supports `**bold**` through safe DOM text/`strong` nodes only; all other model output remains inert text.
- Legend remains focused on Fenster, but normal social interaction is deliberately allowed. Greetings, thanks, goodbyes, meows, purrs, harmless cat jokes and questions about Legend should receive a friendly in-character answer rather than the unrelated-request redirect. The verified context identifies the real Legend as Fenster's black office cat and Chief Meow Officer and Nick Baker, Sales Director, as his dad. Substantive unrelated tasks such as programming and homework are still declined, while server-side conversation and response filtering redacts common profanity before it can reach or be repeated by the model.
- Legend's composer is protected by an explicit acknowledgement covering AI processing, possible inaccuracies, non-binding replies, sensitive-data caution and 24-hour same-browser history, with a direct Privacy Policy link. After acknowledgement, `fenster_legend_chat_v1` stores up to 16 recent messages and synchronises them across Fenster pages and tabs; Clear chat removes the history. This is deliberately separate from analytics/marketing-cookie consent: using the chat never changes `fenster_cookie_consent`, and a rejected choice must remain rejected.
- Legend's launcher prompt is a valid sibling-control component: it stays invisible until 240px of page scroll, with window, document, touch and `visualViewport` listeners covering iOS scrolling. Its copy opens chat and its integrated close button dismisses it for the browser session. The transparent positioning wrapper must remain non-interactive; only the visible launcher and prompt receive pointer input. `legend-sleep-strip.webp` is a separate eight-frame transparent strip generated from the approved Legend pet. The drawer X returns him home in idle, waits 10 seconds and then plays the sleep sequence; 20 seconds without Legend interaction also sleeps him; interaction reverses the strip and wakes him. Keep the sleep asset separate from the validated 8x11 app atlas.
- Cookie settings is deliberately a footer control, not a persistent viewport button. It reopens the consent modal. First visits are blocked by that native modal until the visitor chooses Customise or Accept all; Use necessary only remains inside Customise. Analytics and marketing are separate, off by default, remembered for 180 days and removable again from the same footer control. Do not reintroduce the floating `.fg-cookie-settings` control, and do not let Legend hide, close or alter the modal.
- Legend persists whether the drawer is open and whether the visitor has sent a message in `fenster_legend_chat_v1`. Same-site links therefore restore the drawer immediately without replaying the entrance animation, while an explicit close stores the closed state. The full pre-use disclosure hides after the first sent message, but the compact accuracy, QA-retention, sensitive-data and Privacy Policy notice remains. The panel carries `data-lenis-prevent`; the transcript uses native contained wheel/touch scrolling and always returns to the newest message when opened or restored.
- The drawer header is intentionally one continuous deep-teal surface. `.legend-assistant__stage` adds only a soft mint floor glow and line, not a separate background block. Preserve the `224px` desktop and `190px` mobile stage widths plus their current roam distances so standing, running and curled sleep frames remain contained.
- Residential case studies are LIVE (2026-07-17). `/case-studies/` is a curated, data-driven system: add a study in `inc/case-studies-data.php` and it generates its archive card, detail page, routing, SEO and sitemap entry. See `CASESTUDIES.md` for the full guide. The retired scrape-era residential routes (`double-glazing-rushden`, `water-stratford`, `bespoke-windows-woburn-water-end-barn`, `test`, `template-new`) still return 410. Commercial project records under `/commercial-projects/` remain on the separate legacy pages.json system.
- The current shared product-page redesign is deployed on live. Product pages now use a clearer image-and-copy flow, visible `Product information` cards, `More information on [product]` hubs, full-width specification check cards, FAQ-only accordions, a standalone `/handle-options/` hub, and an in-page product-gallery lightbox. The old survey summary, common choices strip, quote option card, accreditations/systems filler block and inline handle chooser should stay removed.
- The mobile nav touch-layer fix is deployed on live. At `860px` and below, the open fixed header/nav owns the full viewport so page hero content cannot intercept taps on menu rows.
- Commercial hub v2 is deployed on live. The main commercial page was simplified and rebuilt for clearer lead generation: project proof now uses commercial-project imagery, the product/services imagery was corrected from theme assets rather than scrape-reference paths, the useless tiny parallax motion was removed, the "where this fits" section was made more practical, and the commercial form area was restyled so inputs are visible and the copy is not oversized.
- Performance baseline was improved on live without degrading the premium visuals. Heavy media and quote iframes are deferred: the homepage hero video waits for idle, quote iframes load near viewport or on click, product theatre media avoids eager-loading everything, and quote-tool pages keep a usable placeholder/action state until the iframe loads. Future performance work should continue this approach before compressing/removing signature visuals.
- A Lighthouse-focused performance pass has added critical first-viewport CSS, async activation of the main stylesheet, WOFF2 Gibson fonts, Regular/SemiBold font preloads, a homepage hero-poster preload, image dimension helpers, and mobile/constrained-connection interaction gating for the homepage hero video. The mobile/slow-network first impression should be the lightweight poster, not the 9.36 MB video download.
- `/cat-and-dog-flaps/` has a route-specific generated-page override because the imported scrape title/copy was poor. Keep the clean title/SEO in `inc\generated-pages.php`, the pet-flap product copy in `inc\site-data.php`, the fitting-route detail in `inc\product-hub-data.php`, and the custom pet-flap guide/suppressed generic product-choice block in `template-parts\sections\generated-page.php`.
- `/fensa-approved-installers/` uses `template-parts\sections\fensa-approved.php`. It is a dedicated homeowner conversion page and must not fall back to imported article sections, which contain old designer, social, footer and link-fragment debris. Its accepted composition follows the image-led rhythm of `/why-trust-fenster/`: direct Fenster-to-customer hero copy, one purposeful FENSA assurance panel that says eligible work will receive a certificate, two alternating installation-image explanations and the two-column desktop shared form. Do not restore third-party-installer advice, repeated certificate proof, divider-heavy comparisons, process rails, dark list bands or generic card grids. Its route-owned metadata lives in `inc\generated-pages.php`.
- Server cleanup on 2026-07-06 removed the stale `/terms-conditions/` and `/aluminium-bifold-doors-northampton/` redirects, added the live `www` to apex redirect, and password-protected `test.fensterglazing.com` with Basic Auth (`fenster` / `Fenster`). Theme code owns the cookie consent modal in `inc\consent.php`. Analytics consent gates Clarity and the individual Website Tracker; marketing consent gates Meta Pixel, advertising tags and persisted ad click IDs. Google Tag Manager loads only where at least one optional category is granted and receives category-specific Google Consent Mode signals first. Clarity is loaded through the theme with project ID `xi7rk1pic8` and receives Consent API v2 granted/denied signals so consenting users keep multi-page session recordings. The live Clarity plugins were removed; do not reinstall them unless there is a deliberate tracking architecture change.
- Imported blog/guide articles use `template-parts\sections\generated-article.php`. The article CTA form now has article-specific styling through `fg-article-form`, fixing the previous white-on-white labels/input contrast problem shown on generated article pages.
- Microsoft Clarity is not the visual source of truth, but the accepted replay fix is now documented and live. SiteGround/WAF can return a host `403 - Forbidden` HTML page to browser-like bot/resource fetches, which made Clarity recordings look unstyled with huge graphics/images. To work around this, `inc\consent.php` fetches the live `main.css` after accepted cookie consent, injects it as `style#fenster-clarity-replay-css[data-clarity-unmask="true"]`, and only then loads Clarity. `inc\assets.php` also marks stylesheet/font/image resource links as `data-clarity-unmask="true"`. Keep this ordering and markup intact.
- Search Console launch baseline was reviewed on 2026-07-13 from exports ending 2026-07-10. New-site weekdays 2026-07-06 to 2026-07-10 were broadly flat versus old-site weekdays 2026-06-29 to 2026-07-03: 87 vs 86 clicks, 23,709 vs 23,362 impressions, about 0.37% CTR and average position improving about 24.7 -> 23.7. Treat this as a no-cliff baseline, not proof that Google has fully crawled/indexed the new site.
- Current SEO priority is to turn existing visibility into money-page and quote traffic. Fix SERP/first-screen intent first on `/french-casement-windows/` (3,614 impressions, position 3.52, 0.19% CTR) and `/what-are-double-glazed-glass-windows/` (17,884 impressions, 0.06% CTR), then strengthen `/double-glazing-milton-keynes/`, `/windows-milton-keynes/` and `/doors-milton-keynes/` with internal links from high-traffic guides, product-led sections, local proof/trust, pricing guidance and visualiser/instant quote CTAs. Recompare clean new-site weeks, especially 2026-07-06 to 2026-07-10 versus 2026-07-13 to 2026-07-17.
- The dedicated commercial product renderer for `/commercial-windows-and-doors/`, `/curtain-walling/`, `/louvre-vents/`, `/commercial-automation/` and `/healthcare-construction/` is **live** (commit `26f3b43`, confirmed on production 2026-07-20). It uses `inc\commercial-product-data.php` plus `template-parts\sections\commercial-product.php` and bypasses the generic generated product journey for those routes.
- **Composite Doors V2 is live** on `/composite-doors/`. It reached production unintentionally on 2026-07-18 (the route has no host gate, so it shipped with the theme). Reviewed on 2026-07-20 and kept; further work happens directly on live. See `COMPOSITE-DOOR-REDESIGN.md`.
- **The seven price-guide pages are live**: `/window-door-prices-milton-keynes/`, `/composite-door-prices/`, `/bifold-door-cost/`, `/sash-window-prices/`, `/double-glazing-cost/`, `/aluminium-window-prices/` and `/patio-french-door-prices/`. `fenster_price_guides_enabled()` in `inc\generated-pages.php` lists the live hosts; commit `68f38ae` added them while bundled into an unrelated SEO commit, so the pages went live with the approved `13e7f95` promotion. Reviewed on 2026-07-20 and kept live. Prices are checked WindowCAD figures — keep them accurate, since they are public and indexable.

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

For the full operational runbook, read `LIVECHANGES.md` first. This section is a summary only.

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

The owner requires every completed change to go to the password-protected test site first. GitHub remains the source of truth: build and lint locally, commit, push, deploy the committed theme to test with the theme-only rsync, flush cache, and verify the changed route. Do not deploy directly to live, including for small or low-risk edits, unless the owner explicitly overrides this rule for the current task.

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

When the mobile menu is open, `.site-header.is-nav-open` should own the viewport and `.site-nav` should sit above page content. If menu rows stop responding to taps, check for hero/content layers intercepting the touch target before changing the navigation data.

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
- `/heritage-aluminium-doors/` (dedicated template, see below)

### Heritage Aluminium Doors Page

Route: `/heritage-aluminium-doors/`

Template: `template-parts\sections\heritage-aluminium-doors.php`, dispatched from `template-parts\sections\generated-page.php`.

Current accepted behaviour:

- The page is built around the Sheerline Classic Heritage Door and bypasses the generic product journey, in the same way `/roof-lanterns/` does.
- Section order is hero, four-fact specification strip, the six stocked configurations, period lockbox and glazing-bar detail, Thermlock and corner construction, two use cases, the Secured by Design upgrade, the twelve standard colours, shared enquiry form, review showcase.
- Assets are local WebP copies under `assets\images\products\heritage-aluminium`. Do not point this route at the Sheerline scrape export.
- The configuration renders were cropped through one shared window so their relative heights stay honest; do not re-trim them individually. Six are shown as of 2026-07-24, single and French with no bars, 2 bar and 4 bar. The three toplight renders were removed on owner instruction; the assets remain on disk.
- Configuration labels state real bar counts and colours. Check any new label against its render before publishing.
- The route has its own `heritage_aluminium_doors` gallery pool in `inc\site-data.php`. Do not point it back at the shared `aluminium_doors` pool: that pool is modern Prestige entrance doors and put uPVC-looking imagery on this page and its town variants.
- Secured by Design is an optional upgrade on this system, not the standard specification. Keep that distinction in the copy.
- Colour is twelve standard powder-coated finishes, with dual and bespoke colours available on request. Do not restore the blanket `Any RAL colour` claim here.
- The enquiry form sits on a light panel and shares the `.fg-roof-lantern-form` contrast rules through `.fg-heritage-door-form`. If those rules are refactored, keep both classes covered or the inputs render white on white.

Utility and special routes:

- `/terms-conditions/` is a hardcoded virtual utility page in `inc\generated-pages.php` and renders through the generated simple utility layout.
- `/why-trust-fenster/` is a hardcoded virtual trust page in `inc\generated-pages.php`. It renders through `template-parts\sections\trust-page.php`, reuses the shared review showcase and is promoted by a small centred link beneath the homepage trust cards.
- `/obscured-glass/` is a hardcoded virtual product-adjacent page in `inc\generated-pages.php`. It is intentionally not in the menu; product journey pages link to it from the `Gallery and choices` / finish options card.
- `/obscure-glass/` 301 redirects to `/obscured-glass/`; use "obscured glass" in visible copy, while the legacy asset/data key and folder remain `obscure_glass` / `assets\images\products\obscure-glass`.
- `/colour-options/` is the canonical hardcoded virtual colour hub in `inc\generated-pages.php`. `/upvc-colours/` and `/aluminium-colours/` now 301 to `/colour-options/` to avoid duplicate content; the material sections remain as anchors/sections inside the colour hub.
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
- Visible `Product information` benefit cards headed by the product name; product pages should not use accordions outside FAQ.
- Manufacturer/product hub badges, system data and visible full-width specification check cards from `inc\product-hub-data.php`.
- Product body imagery should not repeat the hero image. The template uses a unique image queue and skips later image blocks if there are not enough distinct product images.
- **The three product-selector hubs are `/windows-milton-keynes/`, `/doors-milton-keynes/` and `/other-services/`**, sharing `template-parts\sections\product-hub.php` and driven by `product_hub_groups` in `inc\site-data.php` (2026-07-24). They show the whole range as a grid of real product photographs, read from `product_media[slug].hero` so a hub card and its product page cannot disagree. `/other-services/` was previously in the utility-page list and rendered as a scrape shell with a "Discover our other services" meta; it now has theme-owned SEO and an H1 naming the actual services. The retired `windows-hub.php` tab selector, its JavaScript controller and its SCSS are deleted.
- Curated product image pools now stay product/material specific in `inc\site-data.php`: uPVC doors, composite doors, patio doors, French doors, aluminium doors, aluminium bifolds and aluminium sliders each have separate pools instead of sharing one mixed entrance-door or wide-span gallery.
- The window routes were split the same way on 2026-07-24. `casement_windows`, `flush_casement_windows`, `french_casement_windows`, `tilt_turn_windows` and `bow_bay_windows` are separate pools; before that, all five shared `upvc_windows` and rendered the same thirteen images as each other. `upvc_windows` is now the mixed pool for `/double-glazing/` only. `aluminium_sliding_doors` was rebuilt on Sheerline Prestige Lift & Slide photography. New assets live under `assets\images\products\{casement,flush-casement,french-casement,tilt-turn,bow-bay,aluminium-sliding}`.
- Location/service matrix pages rendered through `template-parts\sections\location-service.php` reuse those same curated product media pools and skip the hero image for supporting image slots, so town variants such as `/upvc-doors-milton-keynes/` do not fall back to unrelated scraped aluminium/composite imagery.
- Product galleries open an in-page lightbox, not a raw image URL or new tab. The lightbox uses a dark overlay, no visible alt/caption text, no white image card, close/backdrop/Escape handling, previous/next arrows and keyboard left/right navigation.
- Optional product-specific WindowCAD quote embed placed after the main product journey/trust content.
- Product narrative/content sections from generated data.
- A compact `Specification choices` section linking to focused colour, privacy-glass and hardware decisions, including the standalone `/handle-options/` hub where relevant.
- Shared enquiry form.
- Context-aware related products/service areas.

Older mobile QA notes from the first phone review were superseded by the later live redesign through `3ac98c2`:

- `/casement-windows/` no longer uses "Why choose this product" wording; the section is now `Product information`.
- Product hub logos such as Liniar and Energy Plus should stay visually balanced against proof/spec cards.
- The old common-choice/product-view control section has been removed from the shared product template.
- Product-view controls were not intuitive enough when there were more than two options. The product hub has since moved away from spec tabs to visible specification check cards.

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
- The embed sits after the main product journey and trust sections, so scroll-following product video sections are not disturbed.
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

### Window Handle Hub

Window handle information is shared data in:

`inc\site-data.php`

The standalone hub renders from:

`template-parts\sections\generated-page.php`

Route:

`/handle-options/`

Current accepted behaviour:

- Product pages no longer render the full window-handle chooser inline. Selected window routes link to `/handle-options/` from the `Specification choices` card grid.
- Tilt & Turn Windows is intentionally excluded.
- Uses supplied S2 finish images from `assets\images\products\handles`.
- Includes an interactive finish selector for White, Black, Chrome, Gold, Satin Silver and Monkey Tail.
- Includes three feature tiles: Push-to-release, Lockable as standard and Finishes are coordinated.
- Includes one static technical specification card.
- No handle accordion is used.
- Egress conversion, spindle length and retrofit-ready content have been removed.

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
- Mobile QA: the top of the page is acceptable. Commit `c21bd46` tightened the Roseview model stats/cards for Ultimate Rose, Heritage Rose and Charisma Rose, corner/detail sections, comparison rows and large detail images for phone layouts. Continue to real-phone regression check this page because it is image-heavy.
- At `860px` and below, the three Roseview model cards use a single-card swipe carousel with previous/next controls, position dots and a visible model counter. The desktop three-card grid remains unchanged.
- The desktop comparison table remains unchanged. Mobile replaces it with a selected-model specification panel that updates with the carousel and shows meeting rail, corner detail, frame depth, glass unit, energy rating and ThermoVFlex information in a compact two-column grid. Do not restore the old mobile pattern that stacked every table row and repeated all three model values down the page.
- The accepted mobile sash journey is deliberately shorter than desktop. At `860px` and below, hide the repeated sash detail run, generic Product information cards, generic More information checks, order-process rail and final related-link band. Their useful model facts are already covered by the selector and its selected-model specifications.
- Mobile colour/glass choices and sash furniture are compact horizontal decision rails. Furniture cards show one representative product object instead of all ten images at once; desktop retains the complete three-range furniture presentation.

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

### Integral Blinds Page

Route: `/integral-blinds/`, rendered through `generated-page.php`.

Current accepted behaviour:

- The page carries an interactive **Notan magnetic blind visualiser**, gated on the route in `generated-page.php` and rendered from `template-parts\components\blinds-visualiser.php`. It sits directly after the why section, on the same reasoning as the obscured glass visualiser: the page has just explained that the blind is sealed inside the glass and cannot be touched, so the next thing to do is let the customer work it. Everything below it is specification and process, which reads better once the product is understood.
- The unit is **face on and fully straight**, which the owner asked for explicitly on 2026-08-03. Do not reintroduce a perspective or angled view.
- **The controls are the two magnets on the unit itself, not sliders beside a picture of it.** The owner corrected this on 2026-08-03: on a Notan magnetic unit the two magnets run on a slim rail sealed inside the glass, the upper one tilting the slats and the lower one raising and lowering the blind. They are drawn near the right of the glass and dragged there. Do not move them back out to page furniture.
- **The unit is built from the owner's photograph of the showroom sample**, supplied 2026-08-04 and the reference for the scale and shape of both the frame and the controls. Check it before changing either.
  - The frame is **anthracite uPVC drawn as a section**: outer face, shadow groove, sash face, second groove, then a bead curving to the glass, every band mitred at forty five degrees. Woodgrain runs **along the length of each profile**, so the head and cill are grained horizontally and the jambs vertically. Graining the whole frame both ways produces a crosshatch that reads as woven fabric.
  - The cassette is **about 50mm on the head and both sides**, and is **colour matched to the slats**, not to the window. It is drawn a shade off the slat colour deliberately: an extrusion beside a rolled slat in the same paint still reads as a different material, and matched exactly the frame and a closed blind merge into one slab. For the same reason there is no separate head rail band any more.
  - The magnets sit **alongside** the slim rail at the inner edge of the frame, near edge against its far edge, on the frame side. The rail is a **guide, not a seat**: centring them on it puts them half over the clear, and putting them in the middle of the member is wrong too.
  - They are **about one to three, and matte**. A hard specular sheet reads as polished plastic; the references show a soft, almost even face falling away to a darker edge each side. The rail is read by the highlight along its clear-side edge, since it is cut into a member of its own colour.
  - The **window frame is deliberately slimmer than the showroom sample** it was drawn from. At the sample's full section plus a 50mm cassette, the two borders together swallowed the glass. The window is the surround; the blind unit is the subject.
  - The blind's framework is a **cassette on the two sides and the head, with nothing across the bottom**. The bottom rail comes to rest straight on the edge of the glass, with only the warm edge spacer and the cill under it. Do not close the U. An earlier pass drew a 24mm profile right round the inside of the glass, which was wrong in both extent and width.
  - The magnets run on the **right hand cassette member** and are wider than it, overhanging onto the glass.
  - The **head rail takes the slat colour**, because it belongs to the blind rather than to the cassette. The cassette itself stays matched to the window frame.
  - The hardware inside the glass is matched to the **window frame**, not to the slats. The reference shows anthracite hardware against silver slats.
  - **The two magnets are not the same size.** The lift one is about half as long again as the tilt one, and both are wider than the angled photographs suggest: a steep angle foreshortens width and not length.
  - **The blind gathers on its own bottom rail as it rises**, so the stack sits at the foot of the drop with the hanging slats above it and the whole group travels up. It is not a band under the head. The bottom rail is drawn outside the slat branch because it is still there when every slat is in the stack.
  - The magnets are **blocks at about one to one point eight**, glossy black with one hard specular sheet, a flat top face catching a glint and crisp turned edges. They were slim capsules at one to three and a half and read as pins. Reading dark, light, dark straight across the width makes them look cylindrical; the face wants to be broad and even with one turned edge near the right.
- `magnetTracks()` is the single source of both where a magnet is drawn and where it can be grabbed. Keep it that way; a magnet drawn somewhere it cannot be grabbed is the obvious way for this to break.
- **`layout()` must stay free of side effects.** The pointer handling calls it on every move to hit-test the magnets. It used to size the backing store too, and assigning to `canvas.width` clears the canvas even when the value has not changed, so moving the mouse across the unit wiped it to black and it stayed black because nothing is scheduled once the easing has settled. The resize belongs in `draw()`, guarded on the store actually being a different size.
- Tilt runs closed, open, closed across the magnet's travel: `0` and `100` are both fully closed and `50` is edge on, which is the real travel and shows that the blind closes both ways. Rotation is capped at 78 degrees because real tilt mechanisms stop short of 90 and because the slats have already overlapped well before then, so the last stretch would be a dead zone.
- **Lift is inverted, on the owner's instruction of 2026-08-04:** the magnet at the top of its travel is the blind **down and closed**, and pulling it down is what **raises the blind open**. That is how the geared magnet runs. Do not "correct" it to match the blind's direction of travel.
- The two travels are deliberately separated, the tilt one shorter and higher, and the vertical hit padding is tight. Left as they were, the hit areas abutted and the two magnets looked bunched together at rest.
- Two `input type="range"` controls remain in the markup, moved **off screen rather than hidden**, and the controller mirrors them to the magnets in both directions. They are what makes the visualiser operable by keyboard and legible to a screen reader; `display: none` or `visibility: hidden` would drop them out of the tab order and leave it working by pointer alone. Focus on one of them draws a ring round the matching magnet.
- **Shading inside the unit is relative to the colour, not an absolute ratio.** `floor()` in the renderer raises the darkest a shading step may go in proportion to how light the finish is. Without it the rail and the magnets look grey rather than white on the light finishes: the same ratio applied to a much larger number is a much larger drop. The magnet is also close to the frame colour rather than painted towards black; it is the same material and its form comes from the gradient.
- **The ladder cords belong to the blind and come up with it**, running only from the foot of the stack to the bottom rail. Drawn full height they stay put, which leaves a pair of wires hanging over clear glass once the blind is raised.
- **The readout names the colour and nothing else.** The owner removed the tilt and lift commentary on 2026-08-04: the magnets show their own positions, and the two range inputs announce their values to a screen reader already, so it duplicated both. Do not put it back.
- **Touch is handled by two grab elements over the magnets, and this is not decoration.** The stage stays `touch-action: pan-y` so the page scrolls when a thumb lands on the glass, and only the two grabs carry `touch-action: none`. Switching the canvas to `none` on `pointerdown` does **not** work and was the cause of dragging pulling the whole page on mobile: by the time the handler runs, the browser has already committed the touch to a scroll. The grabs are padded to 46x56 so they clear the 44px target, and `placeGrabs()` keeps them on the drawn magnets. Do not go back to hit-testing the canvas.
- The blind is **drawn, not photographed**. Nine colours against a continuous tilt and a continuous lift is far past what a sprite sheet can hold. See the Three.js / Canvas Rule in `AI.md`: this is 2D canvas with no library and is a deliberate exception, not a breach.
- Colour data lives in `inc\site-data.php` under `notan_blind_colours`. See the Notan Integral Blind Rule in `AI.md` before changing any of it, in particular before "fixing" Cream or Rose Gold.
- Slats carry a deterministic per-slat wobble in position, brightness and about a fifth of a degree of lean. It is not decoration. Without it fifty perfectly level slats read as a printed rule rather than as a blind, which was the single biggest thing separating the render from a photograph.
- The bright edge on each slat **thins the slat rather than painting over it**, so the scene tints it: sky coloured at the head of the pane, green down where the lawn is. It also falls away as the slat colour lightens, because a white slat is already as bright as the sky behind it. Left flat, it blew White, Cream and Metallic Silver out until all three read as the same pale wash.
- Costs are cached rather than spent per frame. The garden, the veiling glare, the glass overlay and the aluminium frame rebuild only on resize; the slat tile rebuilds only when tilt, colour or size change; the grain waits for the settled frame. Measured at 6.0ms a frame with the GPU disabled, against 9.2ms before the caches were added.
- The controller adds `is-live` only once it has a context and a first frame. Until then the real Notan close-up photograph is what shows, so a thrown error degrades to a photograph rather than to a black box. A `<noscript>` block would not have covered that case.
- Off-screen the animation loop stops, `prefers-reduced-motion` snaps instead of easing but stays fully interactive, and the stage sets `touch-action: pan-y` so a thumb landing on it still scrolls the page, the same rule the obscured glass visualiser follows.
- The view behind the glass is generated, not a project photograph. At the blur a camera exposed for the room would give it, almost nothing photographic survives except the colour distribution and the large scale light and shade, so it is built from a sky, a treeline, a lawn and dapple. The renderer takes an optional scene image if a real view is ever preferred.
- No slat dimension is stated anywhere on the page. Notan do not publish one.
- **Per-slat variation is deliberately small: position and brightness at `0.04`, lean at `0.00105`.** It exists because fifty perfectly level slats read as a printed rule. It was four times stronger and the blind read as damaged rather than hung; the owner asked for roughly seventy five per cent more consistency. Change all three together, or reducing one only shifts which cue reads as the defect.
- **Metallic Silver and Rose Gold carry `glitter`.** They are flake finishes on the real slats. The canvas widens its tile to 480 for them, because a fleck drawn on the usual 96 stretches into a scratch, and the flecks are deterministic so they do not crawl while a slider moves. The swatches use an inline SVG of thresholded turbulence; tiled gradients lattice into a weave.
- **The `Frame colours` card elsewhere on the site takes its six dots from `colour_options` by name**, not from the stylesheet. See the Swatch Provenance Rule in `AI.md`. This route renders no colour card at all.
- **Every photograph in the `integral_blinds` pool has to show a blind.** Three of the five were a plain sliding door, a plain bifold and a sealed unit sample, so the page illustrated integral blinds mostly with doors. If a shot does not show slats, it does not belong in the pool.
- **The slat colours lay out on the page**, via `template-parts/components/blind-colour-grid.php`, sharing the `.fg-upvc-colours` / `.fg-alu-colours` styles so this route does not look like a different kind of page. Because the grid is inline, the route renders **no colour card at all** in Specification choices: frame colour is not a decision here, and a card pointing at the hub duplicates the grid's own note, which is the same suppression the uPVC foil routes use. The privacy glass card stays, because that choice is real.
- **White/Anthracite is drawn as a split swatch** in the grid, on the hub tile and on the visualiser chip, so the second face is visible without working the blind. **The split is diagonal on the owner's instruction; Notan themselves draw it vertically**, in both their web swatch and their brochure, so this is house style rather than a match. Hard stop, not a blend: two painted faces, not a gradient.
- **The slat colours are on `/colour-options/` as their own section**, anchored `#integral-blind-colours`, built at render time from `notan_blind_colours` rather than copied into `colour_options`. Keep it derived: the hub and the visualiser must not be able to drift apart.
- **Instant pricing is off on this route** via `$offers_instant_price`. A blind unit is a sealed unit specification made to its host window or door, and the online tool prices windows and doors, so the button promised a number nobody could get. Both hero variants and the hero card are gated on the same list; add a slug there rather than deleting buttons, or they fall out of step.

### Casement Windows Page

Route: `/casement-windows/`, the most viewed page on the site.

Template: `template-parts\sections\casement-windows-v2.php`, dispatched from `template-parts\sections\generated-page.php`, which returns early for this slug.

Current accepted behaviour, rebuilt 2026-08-04:

- **The page opens on a designer, not on prose.** `template-parts\components\casement-designer.php` draws the window the visitor specifies on a 2D canvas. See the Casement Designer Rule in `AI.md` before touching it; every value it shows comes from `inc\site-data.php`.
- Section order is designer, evidence strip, film band, intro with the EnergyPlus banner, opening styles, moving parts, casement or flush, construction explorer, real homes gallery, CTA, specification decisions, colour grid, handle grid, quote embed, FAQs, case studies, enquiry, reviews.
- **A slot near the top is reserved for an installation film.** `$film_src` at the top of the template is empty, so the band renders the installer photograph with an in-production chip. Setting that one variable to a theme path plays the mp4 in the same frame; nothing else needs changing.
- **The evidence strip under the designer is not decoration.** Astragal and horn, Georgian bars and leaded glass, photographed, so the drawn options are backed by the real thing the way the foil swatches and handle photographs back the colour and handle choices further down.
- **The casement or flush section is annotated photography.** Numbered markers on the Cranfield window point at the proud sash and the directly glazed fixed pane; the flush three-light beside it shows the level sash and matched dummy lights. Both are stated A+ and both figures shown, per the even-handed comparison rule.
- The five-photograph personalisation stage that briefly stood between these two is gone: the designer answers the same question properly.
- Opening styles describes hardware, not names. The Leighton Buzzard photograph beside it shows two side-hung sashes around a fixed pane, and the copy says so; it previously claimed three of the four layouts.

### Colour Options Pages

Routes:

- `/colour-options/`
- `/upvc-colours/` redirects to `/colour-options/`
- `/aluminium-colours/` redirects to `/colour-options/`

Current accepted behaviour:

- The pages are hidden from the main navigation.
- Product journey pages link to `/colour-options/` from the `Specification choices` section.
- Colour data lives in `inc\site-data.php` under `colour_options`.
- `/colour-options/` shows both uPVC and aluminium colour sections on one customer-facing hub. The old top uPVC/aluminium tab buttons were removed because they implied separate journeys when everything is on the same page.
- `/upvc-colours/` and `/aluminium-colours/` no longer render duplicate pages. They redirect to `/colour-options/`; use colour-hub section anchors/material controls for specific uPVC or aluminium context.
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
- Mobile QA: the colour hub hero visual is hidden on mobile as of commit `c21bd46`. The page content after the hero is acceptable; keep the mobile first impression clean, not image-led.

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
- Customer acknowledgements are paused until authenticated SMTP is configured. Do not restore public form copy that promises a confirmation email.
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

- `/commercial-glazing/` is now a stronger v2 commercial landing page, not just a generated service shell. Keep it simple, proof-led and conversion-led: clear project proof, practical service cards, fewer decorative effects, and an obvious commercial enquiry form.
- Do not restore the removed tiny parallax drift in the "How enquiries move" area. It added motion without meaning.
- Commercial project proof should use images from the commercial projects/assets already in the theme. Do not point runtime markup at `wp-content\fenster-reference` or unrelated residential/product stock.
- Commercial form fields must remain visibly bordered/readable. The left-side form copy should be supporting copy, not huge hero-scale text that makes the task feel awkward.
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

## Performance Baseline

Current live performance strategy is "defer, right-size and lazy-load" rather than stripping out all premium media.

Already deployed:

- First-visit loading screen removed.
- Homepage hero video is deferred until idle on normal desktop connections and is interaction-gated on mobile, reduced-motion and constrained-connection sessions.
- Homepage hero poster is preloaded and should remain the intentional first visual for slow/mobile page loads.
- Gibson fonts now have WOFF2 versions; Regular and SemiBold are preloaded as critical weights, with OTF kept only as fallback.
- The main stylesheet is loaded through a preload/activate pattern with critical first-viewport CSS in the head. Re-test the first viewport if this mechanism changes.
- Homepage/product/quote WindowCAD iframes use deferred source loading and near-viewport or interaction triggers.
- Product theatre and heavier image/video sections avoid eagerly loading every asset up front.
- Public generated pages/sitemaps use short cache headers for logged-out visitors.
- Theme image helpers can emit explicit width/height attributes from local files; use `fenster_image_attr_string()` for new local theme image markup where practical.
- Long-lived cache headers for static CSS, JS, fonts, images and video still need to be applied at SiteGround/CDN level because `app/public/.htaccess` is ignored by the scoped GitHub theme repo.

Next high-value performance work:

- Create a 720p/mobile rendition of the homepage hero video and use responsive source/media loading.
- Convert heavy photo PNGs and partner/logo PNGs where suitable to WebP/AVIF or smaller optimised PNGs.
- Add `width`, `height`, `srcset` and `sizes` helpers for hardcoded images.
- Continue adding explicit dimensions/srcsets/sizes to lower-priority hardcoded images beyond the already covered header/homepage/generated hero surfaces.
- Continue memoising/generated-data work carefully; do not break SEO routing to chase a tiny benchmark gain.

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
