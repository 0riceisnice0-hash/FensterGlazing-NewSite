# Fenster Glazing AI Coding Rules

Last updated: 2026-07-15

This file is the rulebook for AI agents working on the Fenster Glazing codebase.

It should contain durable coding standards, implementation rules, QA expectations and “do not do this again” guidance.

It should not contain dated progress reports, long handover summaries or homepage-specific design notes. Put those in:

- `HANDOVER.md` for current site context.
- `AUDIT.md` for the 2026-07-03 master site audit, remediation status and remaining launch backlog.
- `STYLE.md` for site-wide visual styling, background, section rhythm and design rules.
- `HOMEPAGE.md` for homepage-specific architecture and design.
- `PROGRESS.md` for dated work logs and completed changes.
- `LIVECHAT.md` for the complete Legend AI assistant implementation and test handover.

## Important Updates

- **Live is at `8052f65` as of 2026-07-29.** Live, `main` and test are all level. Five releases landed on 28 and 29 July: `01dba14` (two sessions at once: casement rebuild, commercial mega menu, six sector pages, `/commercial-projects/`, sitewide tag restyle), `2f78837` (footer trust tiles and social links), `5b7a612` (Leeds rewrite, casement technical data, uPVC colour grid), and `8052f65` (handle finishes, hover). Verify the live theme by checksum rather than trusting this line.
- **`main` is not a release branch on this project.** Two agent sessions have run concurrently in this repo, so `main` can hold several people's unapproved work at once. Always establish what production is actually running before deploying (checksum a few theme files against history: `assets/css/main.css`, `inc/adminbase.php`, `template-parts/sections/generated-page.php`), then run the `git log --oneline <LIVE_SHA>..<SHA>` range check. If the range contains anything unapproved, branch from the live SHA and re-apply only the approved hunks, rebuild the compiled assets from that tree, and verify the compiled output is free of the other work before shipping.
- Never deploy `origin/main` to live. Reset the server repo cache to the explicit approved SHA and check `git log --oneline <LIVE_SHA>..<SHA>` first. Deploying `main` wholesale put unapproved composite-door work on production on 2026-07-18; see `LIVECHANGES.md` and the 2026-07-20 entry in `PROGRESS.md`.
- Any feature intended to stay off production needs a real gate, not just an absence of approval. Composite Doors V2 had no host gate and shipped with the theme. `fenster_price_guides_enabled()` shows the host-gate pattern — but note that gate was itself silently opened to live inside an unrelated SEO commit, so changes to a gate must be called out in the commit message and the docs.
- GitHub is now live at `https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`. The repo is intentionally scoped to the custom theme and launch docs; do not add WordPress core, uploads, `wp-config.php`, `node_modules`, backups, Local config or `wp-content\fenster-reference`.
- SiteGround test/live are still Bedrock installs. Local source is standard WordPress at `wp-content\themes\fenster`, but server deploy target is `web/app/themes/fenster`. The verified test deploy path is: GitHub repo cache at `~/repos/FensterGlazing-NewSite`, then rsync `app/public/wp-content/themes/fenster/` into `~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/`.
- Production deploys should swap/update the theme only. Keep the production database, uploads, plugins, `.env`, Bedrock config and `wp-config.php` equivalent in place unless the owner explicitly asks for a full WordPress migration.
- Do not use SiteGround clone/staging tools for this account. Previous cloning/search-replace behaviour caused live/test URL drift. Use theme-only deploys from GitHub and always deploy the committed change to the password-protected test site before any live deployment, regardless of size or risk.
- Owner workflow requirement: every completed code or design change must be committed, pushed and deployed to the password-protected test site. There is no direct-to-live exception for small changes. Do not stop at a local-only result or skip test unless the owner explicitly asks for that exception in the current task.
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

## Owner-Confirmed Business Facts

These are settled. Do not re-flag them as unverified claims, do not raise them in audits, and do not "helpfully" suggest softening or removing them.

- **"Phone lines open 24/7" is accurate and approved.** Fenster runs a genuine 24/7 answering service alongside showroom hours of Monday to Friday, 8.30am to 5pm. The footer claim stays exactly as written. This was queried in the 2026-07-03 audit and in `COPY-AUDIT.md`, confirmed by the owner on 2026-07-16, and reconfirmed on 2026-07-20. It is closed. Any future doc or audit that lists it as an open item is stale and should be corrected rather than acted on.
- **The composite door £5,000 guarantee is a break-in guarantee, and these are its terms.** Confirmed by the owner on 2026-07-22, closing the open item `AUDIT.md` raised. Every Distinction door Fenster fits is secured with **AI Secure locking, an APECS 3-star cylinder and an ILH Duplex multipoint lock**; should either fail in a break-in the customer is covered for **up to £5,000 in compensation**, terms and conditions apply. Always call it a break-in guarantee rather than a vague "security guarantee", always name the three lock components when the claim is made prominently, and always keep the terms-apply caveat. Do not invent payout conditions beyond this.
- **We clear up after ourselves on install day, and that is worth saying.** Owner instruction, 2026-07-29: clearing up matters to customers, so the installation step says it plainly. It is a real commitment, not a flourish, so do not remove it as an unsubstantiated claim; nothing else on the site carried it before this date, which is why it is recorded here. Do not extend it into promises the business has not made, such as removing the old frames, dust sheets throughout or a guaranteed same-day finish.
- **Consultations are free, and the site must say so wherever it invites one.** Owner instruction, 2026-07-28. We visit the property, measure up and price the job at no charge, and there is nothing to pay if the customer decides against the work. The visible label is `Book a free consultation` (the header CTA is `Free Consultation`, matching the length and title case of `Instant Quote` beside it). Do not quietly drop the word "free" from a consultation CTA, and do not extend the claim into promises the business has not made, such as a fixed visit length or a guaranteed appointment slot. The same fact is in `fenster_legend_verified_business_context()` so Legend cannot contradict the page.
- **The consultation process, confirmed by the owner on 2026-07-28.** It is low pressure and normally an hour at most, with no long presentation. A window and door expert goes through the options, measures, then builds and prices the job on an iPad using the same software and price list as the online quote tool, which is why the figure matches. **We do not negotiate: the price is the price**, so no page may imply a discount, a limited-time offer or a figure that moves. Every decision maker does not need to be present. Colour swatches travel to the visit; full product samples are at the showroom only. Afterwards the quote is sent over and normally holds for 30 days; going ahead means a contract and a deposit request, typically 50%, and then a full technical survey before anything is made. Keep the deposit figure hedged as "typically" and never imply the survey precedes the deposit. The customer-facing tool is always "the online quote tool" or "the quote tool" — **never WindowCAD**, which is an internal supplier name.
- **Fenster's composite door collections are Traditional, Esprit, Rustic Renown, Renown, Infinity and Stable Doors.** These come from the WindowCAD retail door designer and the website must match it, because the customer meets the same names when they get a price. Distinction's own Signature/Contemporary split is not used anywhere customer-facing. Side panels are a configuration option, not a collection. See `COMPOSITE-DOOR-REDESIGN.md` for how to re-verify the list.
- **A bay or bow is a configuration, not a product.** Owner instruction, 2026-07-29. We can build a bay from most of the range and from **all** of the window styles, so `/bow-bay-windows/` describes a shape rather than a system. It therefore owns no handle, no system of its own and no specification that contradicts the window style it is built from. The existing hub line, "A bay turns at angles and a bow curves", has the right idea but names only casement, flush sash and sliding sash; that list is narrower than what we actually offer, so widen it rather than repeating it elsewhere. Keep the route: it is a real search term and a real customer question.

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
- `TONEOFVOICE.md` is the customer-facing copy voice reference, derived from the owner-approved About page. Read it before writing or rewriting page copy.
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

- When a visual critique arrives, preserve the approved layout and make the smallest coherent fix that addresses the specific weaknesses named. Do not replace approved or working page structure because a critique mentioned problems with parts of it.
- A full page redesign or recomposition requires clear, explicit owner approval. An agent must not infer that a page has been "rejected wholesale" from feedback about spacing, imagery or individual sections.
- Do not delete established proof, page rhythm or working sections to make room for a new design idea. Improve the weak element in place first; only escalate to structural change when the owner asks for it.
- Do not add imagery just to satisfy an "add imagery" style instruction. Images must earn their place by improving an existing section; a grid of tall generic image cards is not an improvement.
- A functional component review is not visual QA. Before shipping visual changes to a conversion page, inspect the whole rendered page at desktop, tablet and mobile widths, including every below-the-fold section and the space between sections.
- When the owner gives an explicit visual hierarchy for a page, treat that as approval for a coherent recomposition. Build that hierarchy directly instead of preserving legacy sections that undermine it. For the consultation model, this is: booking-first hero, one art-directed advice/image section, close reassurance without duplicate proof, concise booking answers, then real reviews.

## Three.js / Canvas Rule

- Three.js is not an active dependency in the live theme.
- `wp-content\themes\fenster\package.json` currently ships `lenis` as the only runtime dependency; there is no `three` package.
- Do not assume the old homepage 3D/canvas experiment is live. The remaining `fg-home-hero-3d`, `data-fg-home-3d` and `THREE.*` references are inactive legacy source/style hooks and are not present in the compiled JS.
- Do not reintroduce Three.js, a WebGL hero or a canvas product scene unless the owner explicitly asks for that feature.
- If 3D is deliberately reintroduced, add the dependency/import/enqueue intentionally, provide mobile and reduced-motion fallbacks, and verify the canvas is nonblank in desktop and mobile browser QA.

## Shared Form Rule

- The live theme must have exactly one customer-facing form definition:
  - `template-parts\components\enquiry-form.php`
- The enquiry-type gate is pre-selected, not blank. It opens on the audience the page is already speaking to: `homeowner` everywhere, `business` where `show_company` is passed. Override with the `audience` argument. Both buttons must stay rendered so a visitor who landed on the wrong page can switch, and pre-selection must not move focus on page load. The homeowner button carries the page's own `project_type` so a lead from `/window-handles/` still reports `Windows` rather than being flattened to `Residential windows and doors`. Commercial routes currently pass `lock_project_type`, so they render no gate at all and are already fixed to `Commercial glazing`.
- Do not add raw standalone `<form>` markup to templates.
- If a new form context is needed, extend the shared component arguments and shared handler.
- The reusable consultation mode is an argument on the shared component, not a separate form: it must keep the date/time request validation in `inc\enquiries.php`, save the preferred appointment with the private enquiry, and clearly state that the office confirms availability. Its JavaScript experience is one compact consultation panel with distinct date, time and details stages, not a stacked form. The date stage must be sized to its natural calendar content rather than stretched to the hero; keep the Monday-Friday, 9am-4pm and bank-holiday-excluded availability rule visible as a concise booking strip, and exclude England-and-Wales bank holidays from both the picker and server-side validation. Use compact arrow-only back controls between stages, with accessible labels, rather than verbose change links. The final details stage needs its own light-surface field treatment with a selected-slot summary, legible labels/required markers, bordered inputs and a clear consent/submit finish; do not let the shared dark-form defaults leak into it. The dedicated indexable route is `/book-a-consultation/`; it owns its title, meta description, canonical, sitemap entry and visible FAQ content while still using the same component. Its proof row reuses the homepage four-card reviews/accreditations treatment directly beneath the hero booking panel, not a separate logo strip.
- All forms should use the AJAX enhancement in `src\js\main.js`, with the no-JavaScript fallback preserved.
- Submissions are handled in `inc\enquiries.php`.
- Valid enquiries are saved as private `fenster_enquiry` posts before email delivery is attempted.
- Default office recipient is `info@fensterglazing.com`, unless overridden by a supported config constant.
- Email templates must keep the Fenster logo visible in common email clients. The current launch email uses a light header with the white-background brand asset; do not place that asset back onto a dark header.
- Mobile forms must be one column, full width, with `16px` input text and comfortable touch targets.
- Form-section headings are content headings, not heroes. Keep shared enquiry h2 sizes moderate across the site.
- Article/blog CTA forms use the shared component with the extra `fg-article-form` class from `template-parts\sections\generated-article.php`. Keep that page-specific styling so labels/inputs stay readable inside article CTA cards.
- AdminBase lead relay lives in `inc\adminbase.php`. It restores the old `wraith` WindowCAD endpoint at `/wp-json/fenster/v1/windowcad` and relays normal saved enquiries through the `fenster_enquiry_created` hook. Do not commit AdminBase credentials; configure them through constants, environment variables or WordPress options.
- Website attribution is theme-owned in `inc\website-tracking.php` and `src\js\main.js`, with the Marketing Dashboard as the aggregate/reporting surface. Its code and durable tracker operating guide are hosted at `https://github.com/0riceisnice0-hash/Marketing-Dashboard` (`WEBSITE-TRACKER.md`); read that guide before altering collection or interpreting a metric, and do not duplicate its API/UI logic in the theme. `FG2-…` is an opaque consented quote/journey reference; `FGV-…` is an opaque consented browser visitor reference. Do not put names, emails, phones, addresses, raw WindowCAD fields or ad click IDs into the dashboard.
- Only accepted optional-cookie choices may create `FG2`/`FGV`, page/click/time events, WindowCAD joins or dashboard conversion events. A WindowCAD quote after rejection must use the separate WindowCAD **Tracking** field value `rejected-cookies`; before a choice it uses `cookie-consent-not-accepted`. Both still go to the office, but neither may be relayed into the dashboard as individual events. A WindowCAD completion without a consented `FG2` value is relayed only into the aggregate-only statistical path (`quote_completed`, device class `server`) so total completions stay measurable without creating a journey.
- WindowCAD's Tracking capture is invisible and URL-driven: the app reads the `tracking=` URL parameter at boot and includes it in the submission under the Tracking info property regardless of the visible form field list. This was verified end-to-end on 2026-07-21 with intercepted submissions and a live owner test (`FG2-ZACLIVETEST0721` arrived in WindowCAD, WordPress, AdminBase notes and the dashboard). A lead with no tracking value therefore means the session did not start from a site URL carrying the parameter, such as office-entered projects or direct/re-opened WindowCAD links; it is not evidence of theme or form-config breakage. Theme defences in `inc/adminbase.php`/`inc/website-tracking.php`: any submitted field carrying a valid `FG2-` value is accepted, a submission with no tracking value logs a warning and adds a "Website tracking: none" line to the AdminBase notes, and the aggregate `quote_completed` relay keeps totals measurable.
- The AdminBase relay depends on TLS trust that WordPress' bundled CA file may lack. In July 2026 AdminBase renewed its certificate onto the newer Sectigo R46 root and `wp_remote_post()` began failing with cURL error 60 while system curl verified fine; leads saved in WordPress but never reached AdminBase. `fenster_adminbase_http_ssl_args()` now points AdminBase requests at the host system trust store, and the WindowCAD handler relays the dashboard `quote_completed` event before attempting AdminBase so attribution never depends on the office CRM being reachable. If AdminBase relays fail again, check `_fenster_adminbase_sent = 0` enquiries and the `php_errorlog` before suspecting the theme.
- Consent reporting is deliberately aggregate-only: the dashboard may count accepts and rejects per day, but must never attach those records to a visitor, URL, source, device or journey. Do not bring back banner-impression totals: without pre-consent identity they are not a dependable metric and can be inflated by anonymous sessions/crawlers.
- The dashboard also has a separate statistical-only aggregate path for non-consented traffic. It may store hourly totals for page views, engagement, quote/form starts or sends and contact intent, grouped by page, broad device class and referrer host. It must never receive `FGV`/`FG2`, fingerprinting values, IP-derived identifiers, ad click IDs, individual timelines or lead joins. Keep it solely for improving the website and preserve the footer opt-out.
- Consent-safe journey detail may include page time, scroll milestones, CTA labels/destinations and form-field *names* that failed validation, but never customer-entered values. Lead status is a dashboard-only manual business outcome tied to an existing consented completed lead.
- **Narrow exception — Legend QA.** The Legend assistant may send its actual user/assistant transcript to the authenticated Marketing Dashboard when a visitor uses chat. It is retained for 30 days, disclosed in the chat terms and Privacy Policy, and must never be put in `website_events`, AdminBase or general analytics. With optional-cookie acceptance it is linked to `FGV`/`FG2`; after rejection it is chat-only, with no `FGV`/`FG2`, journey or website-event record.

## Email And SMTP Rule

- Authenticated email is configured through Bedrock `.env`: `FENSTER_SMTP_HOST`, `FENSTER_SMTP_PORT`, `FENSTER_SMTP_USERNAME`, `FENSTER_SMTP_PASSWORD`, `FENSTER_MAIL_FROM`, optional `FENSTER_MAIL_FROM_NAME` and `FENSTER_SMTP_AUTH_TYPE`. Never commit these.
- **Auth type is pinned to `LOGIN`** in `fenster_configure_smtp()`, overridable via `FENSTER_SMTP_AUTH_TYPE`. This is for determinism, not because negotiation is broken: PHPMailer otherwise picks whichever mechanism the relay advertises first, which can differ between environments and makes failures harder to reason about. Brevo authenticates fine with CRAM-MD5 and with LOGIN. **A `535` almost always means wrong credentials, not the wrong mechanism** — check the username before changing anything in code.
- **Microsoft 365 SMTP is not available to this tenant.** It returns `535 5.7.139 SmtpClientAuthentication is disabled for the Tenant`. Enabling it requires a tenant-wide switch that re-opens basic authentication, and Microsoft is retiring the protocol anyway. The site sends through a transactional relay instead.
- Brevo's SMTP login is the generated `…@smtp-brevo.com` value shown on its SMTP page, not the account email, and the password must be an SMTP key (`xsmtpsib-…`) rather than an API key (`xkeysib-…`).
- **`fenster_smtp_is_configured()` only checks that a host is set, and `fenster_configure_smtp()` routes every `wp_mail()` call through SMTP once it is.** Broken credentials therefore break office lead notifications too, not just customer mail. Always prove credentials on the test site before adding them to live.
- Customer confirmation emails are gated on `fenster_smtp_is_configured()` and switch on automatically once SMTP works. Public copy may promise a confirmation only while that is true.
- The website cannot know when an installation is complete; that lives in AdminBase. Post-install review requests belong there, not in the theme.

## Review Showcase Rule

- Live Google reviews are owned by `inc\google-reviews.php` and rendered by `template-parts\components\review-showcase.php`. The rating, review count and latest reviews come from the Google Places API, cached for six hours.
- **Configuration (server-side only, never committed):** set `FENSTER_GOOGLE_PLACES_API_KEY` in Bedrock `.env` — the same place as `FENSTER_OPENAI_API_KEY`. `FENSTER_GOOGLE_PLACE_ID` is optional; without it the place is resolved once from the business name/address and stored in the `fenster_google_place_id` option. The key must never reach JavaScript, HTML, screenshots or documentation. Restrict it to the Places API in Google Cloud.
- Without a key the section still renders from the curated `customer_reviews` in `inc\site-data.php` plus the owner-verified `brand.google_rating` / `brand.google_review_count`. Those fallback figures are checked by hand; review them quarterly or they rot.
- Google's terms require attribution for review content. Keep the reviewer's own name and photo on each card and keep the card linking to the review on Google. Do not strip attribution to tidy the design.
- Review links must point at the real review panel (`search.google.com/local/reviews?placeid=…`) or the write-review form, both built from the place ID. **Never point a review link at a Google search query** — that was the pre-2026-07-22 bug and it sent customers to search results instead of the reviews.
- Do not add `aggregateRating` to the LocalBusiness/Organization schema. Google does not show review rich results for self-serving reviews about the business itself, so it adds risk without producing stars. Star ratings in organic snippets need a genuine third-party source, not self-published markup.
- `fenster_review_cards()` accepts a context string so a page can lead with relevant proof. Use the town or product name on local and product pages.

## Legend AI Assistant Rule

- Legend's backend lives in `inc\legend-assistant.php` and uses the theme REST route `POST /wp-json/fenster/v1/legend/chat`. Keep the OpenAI key server-only in Bedrock `.env` as `FENSTER_OPENAI_API_KEY`; never expose it to JavaScript, HTML, version control, screenshots or documentation. `FENSTER_OPENAI_MODEL` is optional and currently defaults to `gpt-5.4-mini`.
- The assistant may use a bounded, sanitised snapshot of the current page and recent chat history so it can answer in context. Keep page content labelled as untrusted reference material, not instructions, and retain the Fenster-specific identity, accuracy, privacy, safety and capability boundaries in the server instruction block.
- For factual questions that are not answered by the current page, the backend may add the highest-scoring excerpts from other published Fenster pages. Keep this retrieval same-site and read-only, exclude the current route, cap the result count/content, and continue treating every retrieved excerpt as untrusted reference material rather than instructions.
- Preserve the owner-confirmed `VERIFIED_BUSINESS_FACTS` and query-matched `VERIFIED_PRODUCT_FACTS` layers in `inc\legend-assistant.php`. They outrank imported FAQs, articles, guides and generic page copy when sources conflict. Keep product values sourced from `product_usps`, preserve starred U-values as lowest-achievable figures, and update `LIVECHAT.md` whenever the owner changes a canonical business fact.
- Assistant messages support only a deliberately small Markdown subset: `**bold**` and one same-site route link in `[label](/route/)` form. Render these with DOM-created text, `strong` and `a` nodes. Reject anything external or outside that exact route-link form; do not introduce raw HTML rendering or a general Markdown parser.
- Preserve the nonce and same-origin checks, anonymous rate limit, input/history caps, plain-text output rendering, request timeout and `store: false`. Do not log message text, page snapshots, model replies or the API key.
- Keep the composer available immediately when Legend opens. The compact agreement below it must state that using live chat permits AI processing and caution against sensitive information; a `Read chat terms` disclosure must expose AI processing, possible inaccuracy, non-binding replies, the 24-hour same-browser history, 30-day QA retention and the Privacy Policy. `fenster_legend_chat_v1` may hold up to 16 recent messages for continuity across Fenster pages and tabs. Keep the TTL, Clear chat control and disclosure. This must never accept, overwrite or otherwise change the visitor's separate optional-cookie choice.
- Legend is an AI assistant, not a staffed live-chat channel. It must not claim to submit enquiries, book appointments, check accounts or pass messages to the team. Direct users to the real contact routes when human action is required.
- Legend's scope is strictly Fenster Glazing and directly related customer questions. It must refuse programming, homework, general knowledge, entertainment and other unrelated requests with a brief Fenster redirect. Preserve server-side profanity redaction on both conversation input and assistant output so it cannot repeat or generate abusive language, including when asked to recall an earlier message.

## Order Process Rule

- **There is one process rail and one set of steps.** Owner instruction, 2026-07-29. The steps live in `inc\site-data.php` under `order_process` and render through `template-parts\components\order-process.php`. Before this there were six step sets across three templates, and the town pages had their own markup as well, so the same job was described six different ways and looked different in two of them.
- Pass `steps` to the component only where the journey is genuinely a different one. That is currently commercial and pet flaps, and nothing else should qualify without the owner saying so.
- **The step 4 guarantee wording is scoped on purpose.** The rail renders on `/window-and-door-repairs/`, `/roofline/`, `/integral-blinds/` and `/cat-and-dog-flaps/`, all of which sit outside the ten year insurance-backed guarantee. It says "on new windows and doors" for that reason. Do not shorten it to "your installation carries".
- Keep the four cards within a few words of each other. Emphasis on this rail comes from what a card says, not from how long it runs; the aftercare step was rewritten twice on 2026-07-29 for exactly that.
- The rail is a supporting strip, not a major section. Its H2 shares no clamp with the trust band and should stay near `clamp(1.6rem, 2.4vw, 2.1rem)`.
- **The commercial step set may now be unreachable.** Every commercial route checked on 2026-07-29 renders no rail at all, because the commercial templates return before the shared product tail. It was left in place because the owner excluded commercial from the alignment; confirm before deleting it.

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
- The same rule applies to the window routes. `casement-windows`, `flush-casement-windows`, `french-casement-windows`, `tilt-turn-windows` and `bow-bay-windows` each own a pool named after them; do not map them back to `upvc_windows`. That pool is now the deliberately mixed set for `/double-glazing/` alone, and sharing it made those five pages render the same photographs as each other. `aluminium-sliding-doors` owns Sheerline Prestige Lift & Slide imagery, which is the system that route sells.
- Before changing product imagery, open the images. Filenames and imported alt text lie: `Casement-Windows-Flitwick-10.jpg` is a bay window and was the `/casement-windows/` hero, the `/french-casement-windows/` hero was a Sheerline aluminium window on a uPVC page, `fenster-upvc-door.jpg` is a moulded slab that reads composite, and `sheerline-aluminium-door.jpg` is an interior shot of a white single door.
- **A hub tile is where a wrong image gets caught, so audit the tile source, not just the pool.** The tile reads `product_media[slug].card` and falls back to `hero`, so an image pulled from a gallery for being wrong can still be serving as the tile. That is exactly what happened to `/upvc-doors/`: the composite-looking hero was removed from the gallery on 2026-07-16 and left as the hero until 2026-07-29. Check the rendered page as well as the data, because a photograph whose subject sits in a corner will be cropped out of a body or gallery cell.
- `assets\images\imported` already holds product-specific photography that nothing references. Search it before importing anything new from a scrape export.
- Location/service pages rendered by `template-parts\sections\location-service.php` intentionally reuse the same curated `product_media` and `product_gallery_pools` source as the main product pages. Do not fall back to raw imported scrape images for product matrix routes when a curated product image source exists.
- Product gallery thumbnails should open the in-page lightbox with dark overlay, arrows and no visible caption/alt text. Do not make gallery clicks open a raw image URL or new browser tab.
- On mobile, product hub specification cards and any remaining horizontal components must not create horizontal body scroll.
- Colour choices live in the `/colour-options/`, `/upvc-colours/` and `/aluminium-colours/` virtual routes using `inc\site-data.php` under `colour_options`; do not rebuild huge inline colour grids on every product page.
- Product-page specification cards should link to colour options, obscured glass and relevant hardware choices rather than making the product template carry every possible finish.
- Product hub system logos must use local theme assets and be rendered through `fenster_generated_url()`. Do not point product hubs at `wp-content\fenster-reference` or raw scrape URLs.
- `/sliding-sash-windows/` is a Roseview product route, not a Liniar route. Its product hub system is `Roseview`, its local logo is `assets\partners\roseview-logo-new.png`, and its model badges are `Ultimate Rose`, `Heritage Rose` and `Charisma Rose`.

## Heritage Aluminium Doors Rule

- `/heritage-aluminium-doors/` has a dedicated template at `template-parts\sections\heritage-aluminium-doors.php`, not the generic product journey.
- Assets live under `assets\images\products\heritage-aluminium`. The Sheerline scrape is a source only; runtime code must not depend on the export folder.
- The route owns a `heritage_aluminium_doors` gallery pool in `inc\site-data.php`. Do not map it back to the shared `aluminium_doors` pool. That pool is modern Prestige entrance doors and is what put uPVC-looking imagery on this page and its town variants in the first place.
- Product facts on this route come from the Sheerline Classic Heritage Door specification: 60.5mm sightlines, 1.4 W/m²K double glazed, maximum sash 2.2m x 1m, opens in or out, single or French, twelve standard colours. Do not add values the source does not support.
- Secured by Design is an optional upgrade on this system. Do not present it as the standard specification.
- The configuration renders share one crop window so relative door heights stay truthful. Do not re-trim them individually. The section shows **six** as of 2026-07-24: single and French, each with no bars, 2 bar and 4 bar. The three toplight renders were removed on owner instruction and their assets are still in `assets\images\products\heritage-aluminium\configurations` (`config-04`, `config-05`, `config-06`) if they are ever wanted back. Toplights remain listed as an available layout in `inc\product-hub-data.php`; that is deliberate, because stocked and available are different things.
- Configuration slides carry no `01`/`02`/`03` index numbers. The carousel's own position counter stays.

## Product Hub Rule

- `/windows-milton-keynes/`, `/doors-milton-keynes/` and `/other-services/` are the three product-selector hubs. They share `template-parts\sections\product-hub.php` and are driven by `product_hub_groups` in `inc\site-data.php`. `/other-services/` used to sit in `$is_utility_page` and render as a scrape shell; do not put it back there.
- **Hub card imagery is read from `product_media[slug]`, never stored in the hub data.** A hub card and the product page it links to must never show different photographs of the same product. Only set an explicit `image` on a hub item for a route with no `product_media` entry, currently just `/flat-rooflights/`.
- `product_media[slug].card` is an optional closer crop for the 4:3 hub cell, falling back to `hero`. A hero is a wide banner where an establishing shot works; a card is a small square-ish cell where it does not. Add a `card` rather than replacing a hero that is doing its own job properly. Both stay in `product_media`, so there is still one place to look.
- `assets\partners
otan.png` is a **positive variant built in this repo**, not a supplier file. The only lockup in the Notan scrape is reversed, with a white wordmark that vanishes on a white chip. The green mark is untouched and only the wordmark pixels were recoloured, keeping their alpha. Do not replace it with `logo_notan.png` from the scrape.
- Each card carries its system mark bottom right, read from `fenster_product_hub_data($slug)['systems'][0]`. Do not add a second product-to-system map. Routes with no system mapped, and the services, get no badge rather than an invented one; `/slide-fold-doors/` and `/flat-rooflights/` are currently unmapped and are worth confirming with the owner.
- Two CSS traps caught while building that badge, both worth knowing before adding an image inside another image's container. A flex item keeps `min-width: auto`, so `max-width: 100%` will not shrink a wide logo and it clips: size from the box with `object-fit: contain` instead. And `.fg-product-hub__media img` matched the badge as well as the photograph at equal specificity, so its `object-fit: cover` won on source order and cropped the mark; the photo rule is scoped to the direct child for that reason.
- Hub H1s live in `product_hub_groups[group].h1`, not in the scraped page record. The windows and doors values are the ones already ranking; do not churn them for style.
- The hub shows the whole range at once. Do not put the products back behind a tab, coverflow or one-at-a-time preview: this page exists to send someone to the right product page, and hiding eight of nine options behind a click works against that.
- Use `fenster_case_studies_for_product_group()` on hubs, not `fenster_case_studies_for_product()`. The latter returns **every** study when nothing matches, which is why product pages with no study of their own show unrelated jobs under a heading claiming they are that product. The group version has no fallback and renders nothing instead.
- A hub grid is also the best defect detector on the site: nine heroes side by side make a shared image, a stock lifestyle shot or a CGI render obvious in a way a single product page never does. After changing `product_media`, look at the hub.
- **The range is one grid of tiles, with no filters, no category bands, no per-card spec boxes and no separate configurations section.** With nine items there is nothing to narrow down, and every control added pushes the range further off screen. Owner instruction, 2026-07-24, after all four were tried and rejected as over-complication.
- **The one-viewport half of that instruction is currently unresolved, and is on test in breach of it.** The same instruction said the whole range must fit a single desktop viewport. On 2026-07-29 the owner asked for the nine tiles as a 3x3 square, which adds a third row: measured at a true 900px viewport, windows now ends 208px below the fold and doors 140px. Both cannot hold unless tile height drops to roughly 155px, a 2.5:1 letterbox. Do not quietly rewrite either instruction to make the conflict go away, and do not promote these hubs to live until the owner has chosen. Tile height stays `clamp(146px, 25vh, 250px)` in the meantime.
- **Every tile count must be named in both the `1180px` and `780px` breakpoint lists.** `.fg-ph-tiles[data-count="9"]` is (0,2,1) and beats the bare class, so a count missing from those lists silently keeps its desktop column count down to a phone. Caught on 2026-07-29 before it shipped; it is the `.fg-product-hub > section` specificity trap in a second place.
- Tile height is `clamp(146px, 25vh, 250px)`, sized from the viewport rather than an aspect ratio, because a ratio cannot know how tall the screen is. Verify the fit by measuring, not by eye: the last tile's `getBoundingClientRect().bottom` must be inside `window.innerHeight` at 1440x900 and 1280x900. Below 780px a ratio takes over, since scrolling is expected there.
- **`.fg-product-hub > section` is (0,1,1) and beats a plain-class override.** The intro and range padding overrides have to be child selectors or they silently lose and the range drops below the fold. This cost 104px before it was spotted.
- Below the range each hub runs a decision panel and four FAQs. The decision panel is the one comparison that genuinely narrows the range, built from figures already in `product_usps` rather than adjectives, and it deliberately carries no photograph: the range above is the image section, and a shot there would be an image with no job. It replaced three numbered cards of vague questions; do not put those back.
- **Comparison copy must praise both sides and let the figures do the separating.** Owner instruction, 2026-07-24, after the windows panel opened with "Aluminium is not the warmer of the two". Every system on these pages is one we sell and are glad to fit; framing one as the weaker choice sells against our own range. Give each option the thing it is genuinely best at, in parallel phrasing, and state the numbers without a verdict. Related to the no-cheap-positioning rule in `TONEOFVOICE.md`: same principle, applied to specification instead of price.
- Keep the guarantee FAQ that names what the ten years does **not** cover. That is a caveat about our terms, not a criticism of a product, and it is the kind of thing the About page voice is built on.
- The hero is one lead block (eyebrow, H1, a single paragraph, then the action pair) with the systems panel beside it. Do not go back to a heading in one column and a loose paragraph in the other, and keep the clear air above the buttons: the first version had them crowding the sentence and it read as a floating text box.
- The systems panel is declared per group in `product_hub_groups[group].suppliers`. Windows carries Liniar, Sheerline and Roseview; doors and services carry Liniar and Sheerline. Logos are contained in a fixed box because the marks run from 2.2:1 to 8:1, so height governs the squarer ones and width governs Sheerline.
- The range is banded through `product_hub_groups[group].bands`, which answers a choosing question with the layout rather than only in prose: windows split uPVC from aluminium, doors split by where the door goes, services split roof glazing from glass work from maintenance. Any product a band does not claim still renders in an unlabelled band at the end, so adding to `products` without touching `bands` can never make a product silently vanish.

## Configuration Wall Rule

- `/roof-lanterns/` and `/composite-doors/` share one browsing component: the `.fg-cd3-wall__viewport` / `.fg-cd3-wall__track` markup plus the `[data-fg-door-wall]` controller in `src\js\main.js`. It is a slow sideways drift driven by `scrollLeft` (not a CSS animation) that pauses on hover, during a drag and briefly after one. The track is rendered twice so the loop rewinds by half the scroll width without a seam.
- Extend the shared selector lists rather than copying the component. Only the card differs per route: `.fg-cd3-door` cover-crops a portrait door photograph under a dark gradient label; `.fg-lantern-card` contains a wide product render on a soft panel with the label underneath. A new caller should add a card class, not a second wall.
- The clone-hiding rules for `860px` and `prefers-reduced-motion` must name every card class. Miss one and that route keeps a duplicate list on phones and fights the user's finger.
- Do not use `fg-colour-carousel` for product configurations. It is the colour hub's coverflow, built for picking one value from a list of finishes, and it was the wrong shape for browsing 13 lantern layouts.
- QA note: the drift owns `scrollLeft`, so a test that writes `scrollLeft` without first pausing the drift measures nothing and will report images as unloaded. Dispatch `pointerenter` on the viewport first.

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
- **`/window-handles/` is the handle hub for the whole site, windows and doors.** Owner instruction, 2026-07-29. Both families render through one shared component, `template-parts\components\handle-chooser.php`, so they are presented identically and there is only one copy of that markup. The route name is deliberately unchanged: it is indexed and linked from every window and door page, so renaming it would trade that for a redirect. Raise it with the owner rather than renaming it in passing.
- Window handles are registered in `inc\generated-pages.php` and rendered from `template-parts\sections\generated-page.php`.
- Handle finish images live under `wp-content\themes\fenster\assets\images\products\handles`.
- Product pages no longer render the full handle chooser inline. Selected window routes link to `/window-handles/` from the specification choice cards.
- Tilt & Turn Windows and Sliding Sash Windows should not get the generic inline handle chooser because there is no inline chooser anymore.
- **The five routes in `window_handles.slugs` are the whole S2 story, and that is correct rather than incomplete.** Owner-confirmed, 2026-07-29. Tilt and turn takes a different handle family, so putting the S2 grid on it would be wrong, not generous; the owner is supplying the details. Bow and bay is a configuration, not a product, so its handle comes from whichever window style the bay is built from. Do not "fix" either page by widening the slug list.
- The accepted hub model is a compact finish selector with White, Black, Chrome, Gold, Satin Silver and Monkey Tail, plus three feature tiles and a static technical specification card.
- Do not restore the handle accordion, egress conversion copy, monkey-tail copy, spindle length row or retrofit-ready card unless the owner explicitly asks for them.

## Sliding Sash Roseview Rule

- `/sliding-sash-windows/` has dedicated Roseview content in `template-parts\sections\generated-page.php`, with local assets under `assets\images\products\sash-roseview`.
- Keep the Roseview model comparison for Ultimate Rose, Heritage Rose and Charisma Rose. Do not replace it with generic uPVC window content.
- Sash furniture data belongs in `inc\site-data.php` under `sash_furniture`. It covers Globe furniture for Ultimate Rose, Acorn furniture for Heritage/Charisma Rose, extra Shark Fin/D Handle options and the Roseview under/over 700mm furniture-count rule.
- Use local copied Roseview scrape assets only. The source scrape can inform copy/assets, but runtime code must not depend on the scrape export folder.
- The visible sash detail sections should stay sash-specific: meeting rails, mechanical/welded joints, sash furniture and Roseview model differences. Remove or rewrite generic non-sash hardware/specification content if it appears on this page.

## Tilt And Turn Handle Rule

- Tilt and turn takes its own handle family, `tilt_turn_handles` in `inc\site-data.php`. It is the **greenteQ Alpha TBT, locking version only** (owner instruction, 2026-07-29). Do not merge it into `window_handles`: that is the S2 Signature range and a tilt and turn window cannot take it.
- Facts come from the VBH product bulletin `PB_CUS_greenteQ_Alpha_TBT_Handle_101125` (10/11/25): four settings, 40mm spindle as standard, 43mm Eurogroove fixing centres, Secured by Design Police Preferred Specification, and greenteQ's own 20 year surface and 10 year mechanical guarantees. **Keep those two guarantees attributed to greenteQ.** They cover the handle, not the installation, and must never be read as the Fenster ten year insurance-backed guarantee.
- **How it works, and both halves matter.** The *handle position* selects the opening: a quarter turn tilts the top in, further round swings the whole sash in. The *key* locks the handle, and it also has a middle position that lets the handle reach tilt but not the full opening, so the window airs without being able to swing open. Owner-corrected on the first point and owner-verified on the second, both 2026-07-29, the second by testing a real window. **Do not collapse these into "the key decides how far the window opens".** That was the original error, and it is wrong.
- The tilt-only setting is the strongest thing on this page for a bedroom or anything above a drop. Keep it as a feature rather than burying it in the specification card.
- **We fit five of the eight greenteQ Suite finishes**: White, Black, Gold, Chrome and Satin Silver. The bulletin also lists Anthracite Grey, Smokey Chrome and Enduro Steel in the locking range; those are deliberately not offered. VBH's own names for two of ours are PVD Gold and Satin Chrome, so do not "correct" the customer-facing names against the bulletin.
- **The finish images are AI-generated, not supplier photography.** The owner supplied a single generated sheet on 2026-07-29 and the five assets under `assets\images\products\handles-tilt-turn` were cut from it. They are a likeness, not a photograph of the Alpha TBT, and they have not been checked against the real product. Replace them with VBH photography when it is available, and do not cite them as evidence of what a finish looks like.
- The five were cut through **one shared crop window** and scaled together, so the handles stay the same size as each other, matching the rule already recorded for the heritage door configuration renders. Do not re-trim them individually.

## Door Handle Section Rule

- Door handle data belongs in `inc\site-data.php` under `door_handles`.
- Door handle crop assets live under `wp-content\themes\fenster\assets\images\products\door-handles`.
- **The full door-handle chooser lives on the hub only.** Owner instruction, 2026-07-29. Door routes render `template-parts\components\door-handle-grid.php`, the compact finish grid, exactly as the window routes render `window-handle-grid.php`. Do not put the chooser back on a product page; the point of the hub is that the detail is in one place.
- **The grid is on four routes only: composite, uPVC, aluminium and heritage aluminium doors.** Owner instruction, 2026-07-29. French doors and aluminium sliding doors were removed from `door_handles.slugs` in the same pass, because those systems do not take the long-plate handle. Patio, aluminium bifold and slide and fold were never on it, for the same reason.
- **Doors have eight finishes where windows have six, so the door grid takes its own column count:** all eight on one row on desktop, four below `1080px`, two below `560px`. `.fg-handle-finishes--doors .fg-handle-finishes__grid` is (0,2,0) and beats the breakpoint overrides, so the doors case must be named in each media query it needs to change in.
- **The door tiles carry no sub-label.** Every `door_handles` label reads "<name> long-plate handle", which the section heading has already said; it wrapped to two lines and set the row height for no information. The window grid keeps its sub-label because there it names the finish method rather than repeating the name.
- **Two routes call the grid themselves rather than inheriting it.** `/heritage-aluminium-doors/` returns before the shared product tail, so `heritage-aluminium-doors.php` calls the component directly, as it already does for the tech banner. Composite reaches the tail but had been excluded by an explicit `! $is_composite_doors`, which is now gone: its old inline hardware picker went with the tabbed configurator on 2026-07-22 and renders nowhere, so the route had no handle content at all until this change.
- Do not show the long-plate door handle grid on `/patio-doors/`, `/aluminium-bifold-doors/`, `/slide-fold-doors/`, `/french-doors/` or `/aluminium-sliding-doors/`; those systems use different handle families. The last two were removed on 2026-07-29 by owner instruction.
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
