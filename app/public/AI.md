# Fenster Glazing AI Coding Rules

Last updated: 2026-08-07

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

- **The live SHA lives in `LIVECHANGES.md` and nowhere else.** This line used to carry its own copy and was three days and four releases out of date by 2026-08-04, while `HANDOVER.md` and `nick.md` each carried a different stale one. One pointer, one file. **Re-establish live by checksum immediately before any deploy anyway**, on more than one file and on files the candidate commits actually differ in: three of five once tied across two candidates and only two separated them.
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
- **The multi-point lock in a uPVC casement is the Kenrick Excalibur.** Confirmed by the owner on 2026-08-04, closing an item that was deliberately left unbranded while it was only "pretty sure". `/casement-windows/` now names it and carries Kenrick's own published figures for the mechanism: a ten year mechanical guarantee, 100,000 operating cycles, and a minimum 240 hours salt spray exceeding BS EN 1670:2007, from `kenricks.co.uk/products/window-hardware/excalibur`. **Two things about it are load-bearing.** Kenrick describe it as "PAS24 Capable" and a Secured by Design product — *capable* is their word and it must survive any rewrite, because a PAS 24 approval belongs to a tested complete window and never to a component. And every one of those figures describes the lock, not a Fenster window, so none of them may be restated as our own performance number or folded into the key-specification strip. The page carries a footnote saying exactly that; do not delete it as clutter.
- **We clear up after ourselves on install day, and that is worth saying.** Owner instruction, 2026-07-29: clearing up matters to customers, so the installation step says it plainly. It is a real commitment, not a flourish, so do not remove it as an unsubstantiated claim; nothing else on the site carried it before this date, which is why it is recorded here. Do not extend it into promises the business has not made, such as removing the old frames, dust sheets throughout or a guaranteed same-day finish.
- **Consultations are free, and the site must say so wherever it invites one.** Owner instruction, 2026-07-28. We visit the property, go through the options and price the job at no charge, and there is nothing to pay if the customer decides against the work. Do not quietly drop the word "free" from a consultation CTA, and do not extend the claim into promises the business has not made, such as a fixed visit length or a guaranteed appointment slot. The same fact is in `fenster_legend_verified_business_context()` so Legend cannot contradict the page.
- **Free is the reassurance, not the headline. The expert advice is the offer.** Owner instruction, 2026-08-02, correcting copy that led on the price of the visit. What a customer is buying into is an hour with someone who knows windows and doors, walking their property with them. Say that first and let "and it is free, whether you go ahead or not" land at the end. The header CTA stays `Free Consultation`, matching the length and title case of `Instant Quote` beside it.
- **We do not measure at the consultation.** Owner correction, 2026-08-02. Any sizes taken there are rough, and exist only so the price is right. **The proper measurements are the technical survey**, which happens later, after a deposit. This was wrong in nine places across the site on 2026-08-02, including Legend's verified facts and the `/book-a-consultation/` meta description, because the earlier version of this rule said "measure up" and everything copied it. Do not reintroduce measuring into any consultation sentence.
- **The consultation process, confirmed by the owner on 2026-07-28 and corrected on 2026-08-02.** It is low pressure and normally an hour at most, with no long presentation. A window and door expert goes through the options for the property, then builds and prices the job on an iPad using the same software and price list as the online quote tool, which is why the figure matches. **We do not negotiate: the price is the price**, so no page may imply a discount, a limited-time offer or a figure that moves. Every decision maker does not need to be present. Colour swatches travel to the visit; full product samples are at the showroom only. Afterwards the quote is sent over and normally holds for 30 days; going ahead means a contract and a deposit request, typically 50%, and then a full technical survey before anything is made. Keep the deposit figure hedged as "typically" and never imply the survey precedes the deposit. The customer-facing tool is always "the online quote tool" or "the quote tool" — **never WindowCAD**, which is an internal supplier name.
- **Fenster's composite door collections are Traditional, Esprit, Rustic Renown, Renown, Infinity and Stable Doors.** These come from the WindowCAD retail door designer and the website must match it, because the customer meets the same names when they get a price. Distinction's own Signature/Contemporary split is not used anywhere customer-facing. Side panels are a configuration option, not a collection. See `COMPOSITE-DOOR-REDESIGN.md` for how to re-verify the list.
- **French doors are a configuration, not a product.** Owner instruction, 2026-07-29, given alongside the bay point below. A French door is a pair on a door system we already sell, so its specification follows that system rather than being its own.
- **French casement is a configuration too, and the owner has confirmed its scope: available with every window except tilt and turn and sliding sash.** Those two are excluded because of how they open. Its own hub card already called it "An opening, not a style".
- **Configuration routes must not print a specification figure of their own.** This is why `/french-doors/`, `/french-casement-windows/` and `/bow-bay-windows/` render no U-value in the EnergyPlus banner: the glazing follows whichever system the pair or the bay is built from, so there is no single number that is true for the route. `fenster_tech_banner_args()` defaults to no figure and only names one for a route where it is confirmed. Do not "fill in the gap" from a sibling route; that is exactly what produced the flush casement contradiction.
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
- **The blind visualiser on `/integral-blinds/` is a deliberate exception and does not breach this.** It is 2D canvas, no library and no new dependency. It is 2D because the owner asked for the unit face on and fully straight, and with no perspective a slat projects to a plain rectangle of height `slat * |sin phi| + thickness * |cos phi|`, which is exact rather than approximated. WebGL would buy no accuracy there. Do not "upgrade" it to Three.js.

## Notan Integral Blind Rule

- Notan publish **nine** standard slat colours for the magnetic system, not eleven. `notan.co.uk/our-blinds/` still says "11 standard colour choices" and is wrong; the official brochure at `notan.co.uk/wp-content/uploads/2024/05/Notan-Magnetic-Integrated-blinds.pdf` lists nine, and that is what `notan_blind_colours` in `inc\site-data.php` carries.
- The hex values are sampled from Notan's own swatch assets under `notan.co.uk/wp-content/uploads/2021/02/`, which carry an embedded sRGB profile, so they need no conversion.
- **Two of them look wrong and are not.** Notan's `CREAM BY010` is a warm grey, not a cream, and `ROSE GOLD BY014` is a greige, not a pink. Both were checked against the web swatch and the printed brochure page on 2026-08-03 and they agree. Do not "correct" them towards what the name suggests. Neither carries anything but a BY code, so the swatch is the only source there is.
- **The physical slat sample card is the colour source**, photographed by the owner on 2026-08-04 and better than either earlier source: real slats, one frame, one light. It is under-exposed and the slats are glossy, so it is reliable for hue and for the relationship between colours, not for absolute lightness. The stored values are its hues, exposure-corrected against the paper and anchored so White reads white and the RAL codes keep their published values.
- **`glitter` is a finish, not a colour.** Metallic Silver and Rose Gold are flake finishes and sparkle plainly on the real slats. The renderer and all three swatch surfaces read the flag. Swatch sparkle comes from an inline SVG of thresholded turbulence: tiled radial-gradients line up into a visible weave at swatch size and read as printed fabric.
- **The brochure is the range, and that is settled.** The sample card carries a `BY005` charcoal the brochure does not list, and lacks `BY012` White/Anthracite, which the brochure has. Owner ruling, 2026-08-04: **BY005 is not offered and must not be added from a sample card**, and BY012 stays. Do not reopen this from a future photograph.
- **`BY012` is not a colour of its own.** It is `BY001` White and `RAL7016` Anthracite Grey, one on each face. Its two values must stay equal to those two entries; change one and change the other, or the same paint gets drawn two ways on one page.
- **Where a colour carries a RAL code, prefer the code over the swatch.** `RAL 7016` is `#383E42`, a grey. Notan's own swatch disc reads `#1A1C1B`, which is all but black and is almost certainly a reproduction problem; the owner describes the colour as grey, agreeing with the standard. Corrected 2026-08-04.
- `WHITE/ANTHRACITE BY012` is the only two-sided slat: white on the room side, anthracite outside. It is the only entry with a `reverse` value. **The visualiser flips it with the tilt**, because a venetian presents opposite faces in its two closed positions; the swap lands at edge on, where the slat is invisible. The cassette stays on the room-side colour, so the frame on this option is white however the slats are turned.
- **No slat width is published.** The 30mm figure Notan give is the profile housing the mechanism, not the slat. The renderer assumes the standard 12.5mm integral-blind slat for geometry only and **no slat dimension is printed on the page**. If Notan confirm a width it can be added and shown; until then it must not be.

## Shared Form Rule

- The live theme must have exactly one customer-facing form definition:
  - `template-parts\components\enquiry-form.php`
- The enquiry-type gate is pre-selected, not blank. It opens on the audience the page is already speaking to: `homeowner` everywhere, `business` where `show_company` is passed. Override with the `audience` argument. Both buttons must stay rendered so a visitor who landed on the wrong page can switch, and pre-selection must not move focus on page load. The homeowner button carries the page's own `project_type` so a lead from `/handle-options/` still reports `Windows` rather than being flattened to `Residential windows and doors`. Commercial routes currently pass `lock_project_type`, so they render no gate at all and are already fixed to `Commercial glazing`.
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
- Cookie consent is versioned and granular in `fenster_cookie_consent`: `analytics` controls Clarity plus `FG2`/`FGV` website journeys, and `marketing` controls Meta, advertising tags and persisted ad click IDs. Both optional categories default off. The first-visit native modal must remain open until the visitor chooses **Customise** or **Accept all**. **Use necessary only** remains on the Customise layer, whose switches must not be preselected. This two-button first layer is the owner's explicit 2026-07-30 instruction, despite being weaker than the ICO's equal-ease refusal guidance; do not describe it as equally easy to reject. A saved choice lasts 180 days. Footer **Cookie settings** must reopen it, and withdrawing a category must remove its first-party identifiers and reload without that tool. Old `accepted`/`rejected` string values are deliberately invalid so the granular version is collected afresh.
- Only analytics consent may create `FG2`/`FGV`, page/click/time events, WindowCAD joins or dashboard journey events. Marketing consent is separate and may not silently create an analytics identity. A WindowCAD quote without analytics consent must use the separate WindowCAD **Tracking** field value `rejected-cookies`; before a valid choice it uses `cookie-consent-not-accepted`. Both still go to the office, but neither may be relayed into the dashboard as individual events. A WindowCAD completion without a consented `FG2` value is relayed only into the aggregate-only statistical path (`quote_completed`, device class `server`) so total completions stay measurable without creating a journey.
- WindowCAD's Tracking capture is invisible and URL-driven: the app reads the `tracking=` URL parameter at boot and includes it in the submission under the Tracking info property regardless of the visible form field list. This was verified end-to-end on 2026-07-21 with intercepted submissions and a live owner test (`FG2-ZACLIVETEST0721` arrived in WindowCAD, WordPress, AdminBase notes and the dashboard). A lead with no tracking value therefore means the session did not start from a site URL carrying the parameter, such as office-entered projects or direct/re-opened WindowCAD links; it is not evidence of theme or form-config breakage. Theme defences in `inc/adminbase.php`/`inc/website-tracking.php`: any submitted field carrying a valid `FG2-` value is accepted, a submission with no tracking value logs a warning and adds a "Website tracking: none" line to the AdminBase notes, and the aggregate `quote_completed` relay keeps totals measurable.
- Google Ads attribution uses three separate values and they must not be collapsed. The ad URL's `ads={adgroupid}` ValueTrack suffix is copied into WindowCAD's `ads` field as its readable source tracker; `tracking=FG2-...` remains the consented dashboard journey join; and `gclid`/`gbraid`/`wbraid` is stored only in WordPress. For accepted visitors, `/wp-json/fenster/v1/ad-attribution` keeps the click ID against the opaque FG2 journey for 90 days so the WindowCAD callback can attach it to the private enquiry for offline Ads import. Ad click IDs never enter the Marketing Dashboard or AdminBase notes. Quote-tool opens and iframe loads are diagnostic starts, not conversions; the WindowCAD callback is the completed-quote event.
- **A paid click is identified by its click identifier, not by its UTM tags.** `paidClickChannel()` in `src\js\main.js` sets the journey's `source`/`medium` to `google`/`cpc` whenever `gclid`, `gbraid` or `wbraid` is present and non-empty, and real `utm_source`/`utm_medium` values still take precedence. This exists because a campaign missing its Final URL suffix **fails silently**: the journey lands with an empty source behind a `google.com` referrer and is indistinguishable from organic, which is how only 15 of roughly 183 Google journeys read as `cpc` on 2026-08-05. **This is a safety net for the channel label only.** It cannot recover campaign, keyword or ad-group detail, so the Final URL suffix documented in `GOOGLE-ADS-SETUP.md` still has to be set on every campaign. Do not read the click identifier into `source`, `medium`, `campaign`, `content` or `term`; only the two fixed labels may be derived from it, which is what keeps the never-in-the-dashboard rule above intact.
- The AdminBase relay depends on TLS trust that WordPress' bundled CA file may lack. In July 2026 AdminBase renewed its certificate onto the newer Sectigo R46 root and `wp_remote_post()` began failing with cURL error 60 while system curl verified fine; leads saved in WordPress but never reached AdminBase. `fenster_adminbase_http_ssl_args()` now points AdminBase requests at the host system trust store, and the WindowCAD handler relays the dashboard `quote_completed` event before attempting AdminBase so attribution never depends on the office CRM being reachable. If AdminBase relays fail again, check `_fenster_adminbase_sent = 0` enquiries and the `php_errorlog` before suspecting the theme.
- Consent reporting is deliberately aggregate-only: the dashboard may count the day's choices per environment, but must never attach those records to a visitor, URL, source, device or journey. The split is four-way and granular (`necessary_only`, `analytics_only`, `marketing_only`, `all`), not the old accepted/rejected pair.
- **Banner impressions are recorded, and that is settled.** Owner instruction, 2026-08-02, superseding the 2026-07-13 removal. `inc\consent.php` posts `shown` when the mandatory first-visit modal opens, once per page load, and the dashboard increments `banner_shown` in `website_consent_daily_v2`. Do not strip the metric out again; do not re-raise it as an open question. Its job is a health check: a live figure of zero means the modal or the consent endpoint has broken, which is worth knowing within a day.
- **It must never become a rate, and the reason is not crawler noise.** `banner_shown` structurally undercounts against choices, so any percentage built on it can exceed 100%; production read 562 choices against 499 impressions on 2026-08-03. Two causes, both deterministic. Footer **Cookie settings** reopens the modal through `openDialog(false)`, which records no impression, while saving from it still records a choice. And pre-31-July rows in the v1 `website_consent_daily` table carry choices with no impressions, because impression recording was removed on 2026-07-13 and the dashboard's state query `UNION`s that table. Pre-consent crawler and prefetch traffic moves it in both directions on top of that. **Impressions minus choices is therefore not a sound abandonment figure either.** Verified 2026-08-03: `banner_shown` is a denominator nowhere in the dashboard. Consent Health's percentage is analytics-accepted over choices-answered, and the Overview headline is the page-view split. Keep it that way.
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
- Pass `steps` to the component only where the journey is genuinely a different one. That is commercial and pet flaps, both **owner-confirmed on 2026-07-29**: a pet flap is a different job, nothing is manufactured to survey sizes and it sits outside the ten year guarantee. Nothing else qualifies without the owner saying so.
- **The step 4 guarantee wording is scoped on purpose.** The rail renders on `/roofline/`, `/integral-blinds/` and `/cat-and-dog-flaps/`, all of which sit outside the ten year insurance-backed guarantee. It says "on new windows and doors" for that reason. Do not shorten it to "your installation carries".
- **FENSA ELIGIBILITY AND THE CPA GUARANTEE ARE LINKED.** Owner, 2026-08-07: "all non fensa are non CPA too, they're linked." This is the durable rule and it settles a question that had been answered ad hoc for months. A route outside FENSA is outside the ten year CPA insurance-backed guarantee as well. **There is no route that is non-FENSA but still carries the CPA cover**, so do not reason about the two separately.
- **Four routes are outside both: `/secondary-glazing/`, `/roofline/`, `/integral-blinds/` and `/double-glazing-replacement/`.** A FENSA certificate covers replacement windows and doors. Secondary glazing is an additional window inside the one already there, roofline is fascia, soffit and guttering with no glazing in it, integral blinds are not a replacement window, and replacing a sealed unit into a frame that stays put is not one either. All four were promising a certificate that never arrives.
- **Step 04 on those four loses the certificate AND the guarantee.** They take the canonical steps and replace one sentence, from `order_process.aftercare_outside_fensa_and_cpa` in `inc/site-data.php`. An earlier pass kept the guarantee sentence because it is scoped to "new windows and doors" and therefore still technically true. **Scoping is not the same as honesty**: leading the aftercare step of a secondary glazing page with a ten year insurance-backed guarantee that does not apply to it invites exactly the wrong conclusion.
- **The replacement states nothing about what these products do not get**, per the owner's 2026-08-02 ruling that the site does not write copy stating what is not covered. What is left is the part that is true and positive: you deal with us, and with the people who fitted it.
- **They are NOT given four hand-written journeys.** One shared string, one sentence changed. Four near-identical aftercare paragraphs is how the six-step-sets mess of 2026-07-29 starts again. Commercial and pet flaps still pass genuinely different journeys, because theirs genuinely are different; these four are the same journey with one untrue clause in it.
- **The canonical step 04 keeps its "new windows and doors" scoping**, which is now belt and braces rather than load-bearing, since every route that was relying on it has its own variant. Leave it alone; the Order Process Rule still forbids shortening it to "your installation carries".
- **`/window-and-door-repairs/` no longer renders the rail**, changed 2026-08-06 with the page rebuild and flagged to the owner rather than done quietly. The rail describes buying windows: price, technical survey, installation, FENSA certificate. Nobody having a hinge replaced gets a survey or a certificate, so every step was answering a question that route's visitor had not asked. It carries a four-step repair process of its own inside `template-parts/sections/window-door-repairs.php` instead. If the owner wants the shared rail back there, it needs its own `steps` argument, not the default set.
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

## Secondary Glazing Rule

- **`/secondary-glazing/` is a bespoke middle and renders NO key-specification strip.** Rebuilt 2026-08-07 in `template-parts/sections/secondary-glazing-v2.php`. Owner instruction: keep the strip "only if we actually have relevant stats, dont want filler there". This product publishes no numbers at all, so `product_pulse` is gated off for the slug alongside `fg-product-why`, `fg-product-intel` and `fg-product-visuals`. `product_usps` is **kept and kept accurate** because Legend reads its verified product facts from there; it simply renders nowhere. Same arrangement as repairs.
- **No U-value and no acoustic figure, ever, without a confirmed one.** The starred "From 1.8 W/m²K" came off on 2026-08-05 because a secondary glazed figure depends entirely on the window it is fitted inside. We publish no decibel figure either, so the noise copy talks about what the air gap and the glass do, never by how much.
- **The USP leads and it is that you keep your own windows.** Owner steer, 2026-08-07. It is the first section and the first of the three reason cards, not a bullet in the middle. Listed buildings, conservation areas, flats where the windows are not yours to change, and original leaded or stained glass worth keeping.
- **Four styles, owner-confirmed:** horizontal slider, vertical slider, hinged, and fixed including lift-out. A lift-out **is** the fixed one; it does not open, it comes out. Do not present it as a fifth style.
- **A laminated glass upgrade is offered** and is the answer when noise is the reason for the job.
- **Colours are white, brown or any RAL, and that is its own range.** Not the twelve powder-coated finishes on the aluminium window and door routes, which is why `/secondary-glazing/` is absent from `$aluminium_colour_routes` and must stay absent.
- **It IS on the online designer**, mapped in `$product_quote_embeds` to a UUID collection rather than a numeric one. A `productCollection=(\d+)` grep therefore finds nothing and is not evidence it is unmapped.
- **The comparison with replacing the windows is even-handed on purpose.** A first draft called secondary glazing "often the stronger answer" for noise, which positions our own replacement windows as the weaker choice and is what `TONEOFVOICE.md` forbids. Both are things we sell. Give each what it is genuinely best at.
- **The dispatch must sit OUTSIDE the specification-choices wrapper.** That wrapper is gated on `! $is_secondary_glazing_page`, which predates the rebuild and stops the colour, glass and hardware band rendering where none of those is a decision. Putting the bespoke middle inside it gated the entire page middle on a condition about swatches and the sections silently did not render. The repairs dispatch carries the same warning; this is the second time it has caught someone.
- **FENSA is not relevant to secondary glazing, and the rail no longer says it is.** Owner-confirmed 2026-08-07. See the Order Process Rule: this is one of three routes that take the canonical steps with the certificate clause swapped out. Secondary glazing takes one further change, to step 02, because "thresholds" is a measurement it does not have and reveal depth is what it turns on.

## Secondary Glazing Imagery Rule

- **Every photograph on the route is a Fenster installation as of 2026-08-07**, two supplied by the owner and four from the Winslow job that is now a case study. This closes a gap `PHOTO-CHECKLIST.md` carried from July.
- **The gallery pool held four images and none of them was secondary glazing**, each with alt text asserting it was: a sealed-unit sample, a Liniar casement close-up, a generic old-window shot, and `window-repair-milton-keynes-scaled.jpg`, which is stock, is a man in blue dungarees holding a screwdriver, and is already forbidden by the Repair Imagery Rule. That pool feeds every `/secondary-glazing-<town>/` matrix page, so it was wrong across the matrix. Do not reinstate any of them.
- **The hero was an old-site scrape of a bay so overexposed the product could not be seen.** It is now one of our own leaded windows in a stone mullioned reveal, cropped to the hero's 3.2:1. **Check what a hero crop actually shows before choosing it**: the first candidate tried here was a brighter photograph whose letterbox band turned out to be mostly trees, with no secondary glazing legible at all.
- **The section photographs are portrait and the media panel is 16:10**, so each is cropped to 4:3 centred on the window and the panel carries `.fg-cw-media--4x3`. Crop the box to the picture, never the picture to the box.

## Repair Pricing Rule

- **No exact repair prices on the website, ever.** Owner instruction, 2026-08-06, after the first build published eight rows of the office tariff as a table. A published price list encourages people to shop it round, hands a competitor a line-by-line undercut, and turns us into somebody else's benchmark. Every figure on `/window-and-door-repairs/` reads **"From"**, and there is no price table anywhere on it.
- **As shipped 2026-08-07 there is exactly ONE price on the whole route**, and it is in the FAQ: "Repairs start from £96 including VAT." No table, no range, no per-card figure, no worked examples. The owner's position hardened over three passes and this is where it landed — **do not add a second price back**, in any form, without asking.
- **The wording of that one answer is settled and took three rejected drafts.** "Average" was rejected (a repair really does depend on what is needed), then explaining our own reasoning was rejected ("leave out the *rather than quote you an average*"), then an open-ended phrasing was rejected because it "sounds like the price could spiral". The accepted answer works because it ties the variable to a **physical thing**: the price depends on *which part* your window or door needs. Keep that shape.
- **The £96 also appears in `product_usps` as "Minimum charge", which does not render** — it is there for Legend. See the Repair Page Rule.
- **The underlying figures come from the office Customer Repairs Price List and nowhere else.** `OneDrive/Office Information/Price Lists/Repairs Price List/Customer Price List 04022025.pdf`, header "Last updated: 12/02/25". Nothing is priced in a template. Figures are the inc-VAT column, stated as floors. **The `repair_problems` and `repair_prices` arrays these used to live in were deleted with the second-pass build; do not go looking for them.**
- **The source list is dated February 2025 and has not been re-confirmed with the office.** This has been flagged three times and is still outstanding. Anything that surfaces a figure from it is a live-content responsibility, the same standing the price guides have.
- **Do not claim a guarantee on repair work.** The ten year insurance-backed CPA cover is on new windows and doors and repairs sit outside it. The key-specification strip on that route claimed "Guarantee: 10 years" until 2026-08-06 while the process rail on the same page correctly said "new windows and doors"; the page contradicted itself for months. Nothing on a repair route may state or imply that cover, and no accreditation mark belongs in repair copy either — FENSA and CPA sit in the site-wide trust strip, where they are about the company rather than about the repair.
- **Do not invent response times, callout windows, same-day or emergency service, or free diagnosis.** The price list supports none of them, and the page is deliberately written without them.

## Repair Service Facts

Owner-supplied, 2026-08-06. None of this is inferable from the price list and
none of it may be softened or dropped, because between them these three facts
are the repair proposition.

- **Quoting a repair is normally free, including coming out to look.** "Generally" and "normally" are the owner's own hedges and stay; do not harden them into a guarantee.
- **The office can usually diagnose and quote remotely**, over the phone or by email, from a description and photographs. Most faults never need a visit at all. This is why the page asks for a photograph in step 1 of the process: it is not a nicety, it is what lets us skip the visit.
- **The minimum charge is a floor on the WORK and applies only if the customer goes ahead.** It is not a callout fee and not the price of a visit. Its purpose is that we are not sending an engineer out to fit a £20 handle. **Never state it without that condition attached** — an earlier draft called it "the least a repair visit costs", which read as a charge for turning up and was the opposite of the truth.
- It is therefore the one exact figure allowed on the route, because a minimum is a threshold rather than a job price and "from £96 minimum" would be incoherent. Everything else reads "From".

## Repair Page Rule

- **A repair has no specification, so `/window-and-door-repairs/` renders no key-specification strip.** Owner, 2026-08-06: "repairs dont have spec so having a box for it makes no sense." `product_pulse` is gated off for the slug and a four-USP proposition strip stands in that slot instead, saying what to expect from the service rather than inventing four product facts for something that has none. The four come from `repair_usps` in `inc/site-data.php`.
- **The repairs data now lives in four arrays and they are a contract, not a list.** `repair_parts`, `repair_diagnostics`, `repair_usps` and `repair_services` in `inc/site-data.php`. Every symptom in `repair_diagnostics` names a `part` that must exist in `repair_parts` **and** an `svg` group that must exist in the inline drawing — `svg` is space-separated so one symptom can light several. Change one without the other and the drawing silently highlights nothing. There is no runtime guard; the check is the render harness.
- **The two rejected builds are not in the docs as options.** Pass one was "a big page of text", pass two was a filterable fifteen-card problem finder with prices. Both were rejected outright by the owner. If an audit or a plan proposes either shape, it is proposing something already refused.
- **Two copy registers are banned on this route by owner instruction.** Anything that talks down to the reader ("you do not need to know what it is called") — the owner's words were that it sounded condescending — and any claim that our service engineers are "not installers between jobs", which is sometimes untrue. The van-stock claim replaced the latter and is the supportable version of the same idea.
- `product_usps['window-and-door-repairs']` is kept and kept accurate even though it no longer renders, because **Legend reads `product_usps` for its verified product facts**. A stale entry there becomes a wrong answer in chat that no visitor can see and nobody will catch. That entry claimed a ten year guarantee until 2026-08-06.

## Aluminium Doors Rule

- **`/aluminium-doors/` is a bespoke middle, not an early return.** Built 2026-08-07 in `template-parts/sections/aluminium-doors-v2.php` on the shared `.fg-cw` split grammar, the same shape flush casement uses. It stands in for `fg-product-why`, `fg-product-intel` and `fg-product-visuals`, which are gated off for the slug in `generated-page.php`. The hero, the key-specification strip, the Thermlock banner and the whole tail from the specification choices down are the shared ones and must stay shared.
- **The middle states no U-value, deliberately.** 1.4 W/m²K double and 1.0 triple are already on the key-specification strip **and** on the Thermlock banner, both of which render immediately above it. A third statement inside 1.5 viewports is the exact defect the casement page was corrected for on 2026-07-27. The banner names the technology and the section below explains it; that division is the point. Do not add the figures back into the middle.
- **The system is "Sheerline", never "Sheerline Prestige".** The windows, bifolds and sliders are named Prestige in `inc/product-hub-data.php`. The residential door is not, so the page does not name it that either.
- **Do not claim flush hook-locks on this route.** The doors hub FAQ says "the aluminium doors add flush hook-locks on top", but every other reference in the theme puts hook-locks on the lift-and-slide interlock (`aluminium-sliding-doors`, `lift-slide-detail.php`, `product-hub-data.php`). A hinged residential door is not that product.
- **PAS 24 is "available to", never asserted flat.** The standard belongs to a tested complete doorset, not to a component, which is the same distinction already recorded for the Kenrick Excalibur.
- **Exactly one photograph on this route is ours, and it is owner-confirmed.** `alu-door-french-flag-install-1600w.webp` is **aluminium French doors with flush aluminium windows either side, with integral blinds sealed in the glass**, confirmed by the owner on 2026-08-07 as a Fenster installation. He supplied it as "the only one i can find we actually installed". Everything else on the route is supplier photography, so **nothing may make a blanket claim over the imagery** — that is the fault already recorded against the casement proof mosaic. Only this one is captioned "Our install".
- **The confirmation was necessary, not a formality.** The frames read chunky and glossy in the source and the handles are the long-plate family, so it was not usable until the owner said what it was. This route's standing defect is a hero that reads as uPVC; putting a possibly-uPVC door on it under our own name would have repeated it.
- **It is not the hero, and the reason is measured.** The hero is a 3.2:1 letterbox. A band that shallow across a tall symmetric subject shows handles and blinds and no door, so it would breach the rule against forcing tall imagery into a wide box. It sits in the opening section instead, whose heading is the claim it happens to prove. The hero therefore still needs a genuinely wide asset and remains the owner's deferred decision.
- **The `aluminium_doors` gallery pool is modern aluminium entrance doors only.** Corrected 2026-08-07, when five of its nine entries turned out not to be this product: three were Sheerline **Classic** heritage doors, which have their own route and their own `heritage_aluminium_doors` pool, and two were window profiles. That pool feeds every `/aluminium-doors-<town>/` matrix page as well as this route, so a wrong image there is wrong on about twenty pages. `aluminium-doors-northampton-2.jpg` is deliberately excluded: it is a dusk CGI render, and a render in a row of photographs is the first thing the eye lands on, which is why it came off the hub tile on 2026-07-29.

## InvisiHinge Rule

- **The concealed hinge has its own section on `/aluminium-doors/`**, owner instruction 2026-08-07. It earns one because it is the rare piece of door hardware a customer sees the point of immediately, and the supplied image argues it without help: a conventional knuckle standing off the frame beside the concealed hinge set into the door edge.
- **Two things the owner excluded in the same breath, and neither may come back without asking.** The option of a **fourth hinge at stress points** is not mentioned. Nothing is said about the hinge being **easy to install**, because the doors arrive with it already fitted, so installation is a fabricator's concern and not a customer benefit.
- **Adjustment after hanging is a different thing and is kept.** It is what lets a dropped door be trued up later without taking anything off the face, which is a real customer benefit and is in the owner's own supplied wording.
- The image is a supplier composite taken from a third-party installer's site and supplied by the owner. It is marketing artwork rather than our photography, so it is captioned as a comparison and claims no installation of ours. **Replace it if Sheerline publish their own.**

## Repair Imagery Rule

- **Wharfside Supplies are our supplier for repair parts and are content for us to use their product photography.** Owner-confirmed, 2026-08-06. The espagnolette, friction stay, door gearbox and cat flap on the parts wall at `/window-and-door-repairs/` are theirs, stored under `assets/images/products/repair-parts`. **This is settled: do not re-raise it as a licence question in an audit, and do not replace them with weaker imagery on provenance grounds.** It is a different situation from the Roseview and Sheerline scrapes, which are source material rather than a supplier relationship.
- **The parts wall must not become all handles again.** It was fourteen handle finishes until 2026-08-06 and the owner's read was that a handle range makes "most parts for most systems" look narrower rather than broader. Keep hardware and handles interleaved at roughly half each.
- **Where we own a photograph of the real thing, it beats a supplier product shot at large sizes.** The cat flap tile on the wall is Wharfside's isolated shot because it sits in a grid of cut-outs; the cat flap panel inside the diagnostics is our own photograph of a round flap in glass, because at that size a real install is worth more than a render.

## Repair Diagnosis Facts

- **Keeps do not fail.** Owner correction, 2026-08-06. A keep is a folded piece of steel with nothing in it to wear out; what moves is the sash or the door around it, which is a realignment job rather than a part failure. The first build of the repairs page listed keeps as one of the three things that fail, which was invented. **The check that would have caught it: all three should map to a line on the repairs price list, and keeps are not on it.** The three that are, and that the page now names, are the mechanism, the hinges and the handle.
- **Handles are the most common single repair.** The part you touch every day, so it wears first, and usually the spindle rounding off rather than the handle itself breaking.
- **A window that will not lock is nearly always the multi-point mechanism**, not the whole window. A window that will not open is nearly always the friction stays. A door that catches or has dropped has moved in its frame, which then puts the whole load on the gearbox, which is how a dropped door becomes a door that will not lock.

## Repair Schematic Rule

The two inline SVGs on `/window-and-door-repairs/` are technical drawings, not
illustrations, and the owner corrected them part by part against his own
reference photographs over three rounds. Treat them as measured drawings.

- **They are to scale.** Window is `viewBox="0 0 620 900"` at 1 unit = 1mm; door is `viewBox="0 0 560 1200"` at 1 unit = 1.92mm. Geometry follows the reference photographs exactly, including sculptured profile detail and visible hardware. **Do not redraw a part from imagination** — every one that was drawn that way came back corrected.
- **The register is AutoCAD, not illustration.** Mitres drawn, construction lines, dimension rules, and **concealed hardware as dashed hidden line** (`.fg-rp-svg__hidden`). Strokes carry `vector-effect: non-scaling-stroke` so weights hold at any size.
- **Highlighting works off `data-part` groups**, matched to the space-separated `svg` field on each symptom. A group nobody references and a reference to a group that does not exist are both silent failures; the harness asserts against orphans in both directions.
- **`[hidden]` from the UA stylesheet loses to any class rule that sets `display`.** `.fg-rp` therefore carries explicit `[hidden] { display: none !important }` guards. Without them both drawings render at once and the no-JS fallback never hides — which is exactly what shipped to test once.
- **`hidden` is an `HTMLElement` IDL property and `SVGElement` does not have it.** Setting `svg.hidden = true` does nothing at all. Toggle drawings with `setAttribute('hidden','')` / `removeAttribute('hidden')`. The symptom list switching product while the drawing sat still was this.
- **Owner-set mappings that must not drift:** window "will not open" is the mechanism; door "it has dropped" is the **hinges only**; door "it will not lock" is the **gearbox only**; door draught lights realignment *and* gasket.
- **True scale and legibility genuinely conflict on the door** and this is unresolved. Its fine hardware is under 5px, and the drawing is already at the ceiling of its plate. The correct answer is a detail callout at an enlarged scale. **Do not resolve it by falsifying the scale.**

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
- Integral Blinds controls must be described as `Magnetic or electric`. The blind visualiser demonstrates the **magnetic** system specifically and says so; it must not be allowed to imply magnetic is the only control offered.

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
- **A product route lives in three separate registries and they do not check each other.** `data/pages.json` or the virtual route gives it a page, `product_hub_groups` puts it on its hub, and `primary_nav_fallback` puts it in the menu and the mobile drawer. `/cat-and-dog-flaps/` had a page, copy, SEO and photography but was in neither of the other two until 2026-07-29, so it had no navigational way in at all while the homepage product theatre claimed Other Services covered it. **When adding or reviving a route, add it to all three and then cross-check.** A quick check is to diff every `'slug'` in `product_hub_groups` against every `home_url()` in `primary_nav_fallback`; as of 2026-07-29 the only legitimate difference is `/commercial-projects/`, an archive rather than a product.
- Each card carries its system mark bottom right, read from `fenster_product_hub_data($slug)['systems'][0]`. Do not add a second product-to-system map. Routes with no system mapped, and the services, get no badge rather than an invented one; `/slide-fold-doors/` and `/flat-rooflights/` are currently unmapped and are worth confirming with the owner.
- Two CSS traps caught while building that badge, both worth knowing before adding an image inside another image's container. A flex item keeps `min-width: auto`, so `max-width: 100%` will not shrink a wide logo and it clips: size from the box with `object-fit: contain` instead. And `.fg-product-hub__media img` matched the badge as well as the photograph at equal specificity, so its `object-fit: cover` won on source order and cropped the mark; the photo rule is scoped to the direct child for that reason.
- Hub H1s live in `product_hub_groups[group].h1`, not in the scraped page record. The windows and doors values are the ones already ranking; do not churn them for style.
- The hub shows the whole range at once. Do not put the products back behind a tab, coverflow or one-at-a-time preview: this page exists to send someone to the right product page, and hiding eight of nine options behind a click works against that.
- Use `fenster_case_studies_for_product_group()` on hubs, not `fenster_case_studies_for_product()`. The latter returns **every** study when nothing matches, which is why product pages with no study of their own show unrelated jobs under a heading claiming they are that product. The group version has no fallback and renders nothing instead.
- A hub grid is also the best defect detector on the site: nine heroes side by side make a shared image, a stock lifestyle shot or a CGI render obvious in a way a single product page never does. After changing `product_media`, look at the hub.
- **The range is one grid of tiles, with no filters, no category bands, no per-card spec boxes and no separate configurations section.** With nine items there is nothing to narrow down, and every control added pushes the range further off screen. Owner instruction, 2026-07-24, after all four were tried and rejected as over-complication.
- **The one-viewport half of that instruction has been superseded.** It said the whole range must fit a single desktop viewport; the 3x3 square the owner asked for on 2026-07-29 adds a third row, so windows ends about 208px below the fold and doors 140px. **Owner decision the same day: the slight scroll is accepted.** Keep the 3x3 and the tile height at `clamp(146px, 25vh, 250px)`; do not shrink tiles to chase the old rule, which would letterbox the photography.
- **Every tile count must be named in both the `1180px` and `780px` breakpoint lists.** `.fg-ph-tiles[data-count="9"]` is (0,2,1) and beats the bare class, so a count missing from those lists silently keeps its desktop column count down to a phone. Caught on 2026-07-29 before it shipped; it is the `.fg-product-hub > section` specificity trap in a second place.
- Tile height is `clamp(146px, 25vh, 250px)`, sized from the viewport rather than an aspect ratio, because a ratio cannot know how tall the screen is. Verify the fit by measuring, not by eye: the last tile's `getBoundingClientRect().bottom` must be inside `window.innerHeight` at 1440x900 and 1280x900. Below 780px a ratio takes over, since scrolling is expected there.
- **`.fg-product-hub > section` is (0,1,1) and beats a plain-class override.** The intro and range padding overrides have to be child selectors or they silently lose and the range drops below the fold. This cost 104px before it was spotted.
- Below the range each hub runs a decision panel and four FAQs. The decision panel is the one comparison that genuinely narrows the range, built from figures already in `product_usps` rather than adjectives, and it deliberately carries no photograph: the range above is the image section, and a shot there would be an image with no job. It replaced three numbered cards of vague questions; do not put those back.
- **Comparison copy must praise both sides and let the figures do the separating.** Owner instruction, 2026-07-24, after the windows panel opened with "Aluminium is not the warmer of the two". Every system on these pages is one we sell and are glad to fit; framing one as the weaker choice sells against our own range. Give each option the thing it is genuinely best at, in parallel phrasing, and state the numbers without a verdict. Related to the no-cheap-positioning rule in `TONEOFVOICE.md`: same principle, applied to specification instead of price.
- ~~Keep the guarantee FAQ that names what the ten years does **not** cover.~~ **Superseded 2026-08-02 by owner instruction: the site avoids stating what is not covered.** The hub FAQ still carries that wording and has not been rewritten, because it is live approved copy and the instruction arrived about a different page; put it to the owner rather than changing it silently. New copy must not add exclusions. Scoping a positive claim so it stays true, as the order process rail does with "new windows and doors", is accuracy rather than a negative and stays.
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
- **Nothing physical travels to the technical survey, and door samples never travel at all.** The confirmed model is already in the consultation facts: **colour swatches come out to the consultation**, and **full product samples are at the Milton Keynes showroom only**. The survey is a later visit for measurements, not a viewing. Copy claiming samples come to the survey was live on `/composite-doors/` from July and was corrected on 2026-07-29; check any new sentence about seeing a finish against this before writing it, because "we bring samples out" is an easy and attractive thing to assume.
- **Composite doors: the standard range plus any RAL.** Owner-confirmed, 2026-07-29. The swatches on `/composite-doors/` and `/colour-options/` are **a mix of standard colours and RAL matches**, not the standard range and not the whole of either. Beyond what is shown, the standard range runs wider and any RAL colour can be matched. Each tile carries `Standard colour` or its RAL reference so the mix is legible rather than implied. Both pages must say so. This reverses the July removal of the blanket RAL claim, which came off as unsubstantiated at the time; `COMPOSITE-DOOR-REDESIGN.md` carries the same correction. **It does not extend to heritage aluminium doors**, which stay at twelve standard powder-coated finishes with dual and bespoke colours on request.
- Because the range is wider than the tiles, the four colours with no painted tile are a presentation gap rather than a gap in what we sell. Do not add a tinted swatch to close it.
- **Composite shows the paint, not photographs of doors.** Owner instruction, 2026-07-29. The hub carried eight photographed Distinction doors while `/composite-doors/` showed the real paint range as painted tiles; the hub now shows the same twenty-three from `assets\images\products\composite-distinction\palette`. The slides are square like the uPVC and aluminium swatches, so the old portrait 4:5 override is gone; do not reintroduce it.
- **Four colours have no painted tile and are therefore not on the hub: White, Light Grey, Pale Blue and Ruby Red.** They exist as photographed doors only. Do not tint a swatch or generate a tile to fill the gap, which is the same rule the composite door wall already carries. If the owner wants them back, the tile has to come from Distinction.
- Hex values on the composite colours are **sampled from each tile**, not chosen by eye, so the fallback chip matches the paint. Re-sample if the assets are ever regenerated.
- The colour hub routes are `/colour-options/`, `/upvc-colours/` and `/aluminium-colours/`.
- The colour hub is customer-facing. Do not expose supplier names, scrape folder names, manufacturer scrape labels, internal provenance or applicability dumps unless the owner explicitly asks for public supplier branding.
- Use simple visible labels: `uPVC colours`, `Aluminium colours`, finish names and short customer-useful details only.
- The uPVC colour carousel uses optimised swatch assets from `assets\images\products\colours\liniar-swatches`.
- The door render assets under `assets\images\products\colours\liniar-door` are reserved for later door-page use, not the colour hub.
- **The accepted colour-hub interaction is an equal-size swipeable rail, not a coverflow.** Owner instruction, 2026-07-29, with the Sheerline frame-corner rail as the reference: every card the same size, four across on a wide screen, three at tablet and about one and a half on a phone so the next one is visibly cut. **No buttons**: touch and trackpad scroll natively and the controller adds click-drag for a mouse. A position counter stays, because a rail with no affordance does not say how much more there is.
- The rail is `.fg-colour-rail` and is **separate from `.fg-colour-carousel`**, which is still the coverflow and is still used by the heritage door configurations. Do not merge them; they are different jobs.
- **Size the rail from the scroll container, never a percentage flex basis.** A percentage basis inside an overflowing flex row resolves against the track's scroll width, so slides ballooned to 848px. The list is the scroller and a column grid, and `grid-auto-columns` resolves against the visible width. Any ancestor track must be `minmax(0, 1fr)` rather than `1fr`: a bare `1fr` carries an implicit auto minimum and the rail will size itself to its slide count instead of the viewport. Neither bug was visible at 1440.
- **The Renolit uPVC swatches carry a supplier label strip along the bottom edge.** Both the grid and the rail crop it with a `1.42` aspect anchored to the top. A square crop puts "RENOLIT FOIL S3030700005" on a customer-facing page, which the no-supplier-provenance rule above forbids.
- Smooth white has no swatch photograph, so it falls back to its hex and needs a visible border, or the tile reads as empty on a white card.
- Dragging can move through multiple colours, then release snaps to the nearest colour. Keep the drag sensitivity calm enough for mobile.
- The colour hub hero visual should be simple and controlled. Do not create overlapping random card piles or crop swatch images so their content is chopped off.
- Do not add uPVC/aluminium tab buttons that imply separate pages when the page already shows both sections.

## Window Handle Section Rule

- Window handle data belongs in `inc\site-data.php` under `window_handles`.
- **`/handle-options/` is the handle hub for the whole site: windows, tilt and turn, doors and sliding patio.** Owner instruction, 2026-07-29; patio added 2026-08-02, which closes the "patio to come" note this line used to carry. Every family renders through one shared component, `template-parts\components\handle-chooser.php`, so they are presented identically and there is only one copy of that markup.
- **The route was renamed from `/window-handles/` on 2026-07-29** once the hub stopped being window-only. `/handle-options/` pairs with `/colour-options/`, and the two sit side by side as sibling cards in the `Specification choices` group, so they should read as a set. The old slug 301s through the map in `fenster_redirect_target()`. If another family is added, the name still holds; do not rename again.
- Window handles are registered in `inc\generated-pages.php` and rendered from `template-parts\sections\generated-page.php`.
- Handle finish images live under `wp-content\themes\fenster\assets\images\products\handles`.
- Product pages no longer render the full handle chooser inline. Selected window routes link to `/handle-options/` from the specification choice cards.
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
- Facts come from the VBH product bulletin `PB_CUS_greenteQ_Alpha_TBT_Handle_101125` (10/11/25): four settings, 40mm spindle as standard, 43mm Eurogroove fixing centres, Secured by Design Police Preferred Specification, and greenteQ's own 20 year surface and 10 year mechanical guarantees. **The spindle and fixing centres are deliberately not shown to customers** (owner instruction, 2026-07-29): they are fitter numbers and nobody choosing a handle needs them. They are recorded here so they do not have to be looked up again.
- **Do not define the range by what we do not stock.** The specification line used to end "We do not fit the non-locking one", which tells a customer nothing they can act on. Say what we fit. This is separate from the say-the-awkward-thing-first principle in `TONEOFVOICE.md`, which is about caveats that affect the customer, not about products we choose not to sell. **Keep those two guarantees attributed to greenteQ.** They cover the handle, not the installation, and must never be read as the Fenster ten year insurance-backed guarantee.
- **How it works, and both halves matter.** The *handle position* selects the opening: a quarter turn tilts the top in, further round swings the whole sash in. The *key* locks the handle, and it also has a middle position that lets the handle reach tilt but not the full opening, so the window airs without being able to swing open. Owner-corrected on the first point and owner-verified on the second, both 2026-07-29, the second by testing a real window. **Do not collapse these into "the key decides how far the window opens".** That was the original error, and it is wrong.
- The tilt-only setting is the strongest thing on this page for a bedroom or anything above a drop. Keep it as a feature rather than burying it in the specification card.
- **It is standard, not a specification choice.** It comes with the locking handle we fit on every tilt and turn window, so there is nothing for a customer to request and nothing to settle at survey. Copy saying otherwise was corrected on 2026-07-29 and is the same mistake as the key-versus-handle one wearing a different coat: do not describe a day-to-day key position as something specified up front.
- **We fit five of the eight greenteQ Suite finishes**: White, Black, Gold, Chrome and Satin Silver. The bulletin also lists Anthracite Grey, Smokey Chrome and Enduro Steel in the locking range; those are deliberately not offered. VBH's own names for two of ours are PVD Gold and Satin Chrome, so do not "correct" the customer-facing names against the bulletin.
- **The finish images are AI-generated, not supplier photography, and the owner has accepted that.** Decision, 2026-07-29: it is the best imagery available for this handle, so the generated sheet stands. They remain a likeness rather than a photograph of the Alpha TBT, so do not cite them as evidence of what a finish looks like, and swap in VBH photography if it ever appears. **Do not remove them on provenance grounds; that has been decided.**
- The five were cut through **one shared crop window** and scaled together, so the handles stay the same size as each other, matching the rule already recorded for the heritage door configuration renders. Do not re-trim them individually.

## Patio Handle Rule

- Sliding patio door handle data belongs in `inc\site-data.php` under `patio_handles`, and the assets under `assets\images\products\handles-patio`. It renders on `/patio-doors/` through the shared grid and on `/handle-options/` through the shared chooser, same as the other three families.
- **It is its own family, and must not be merged into `door_handles`.** A sliding sash moves sideways under its own weight, so it takes a fixed D-pull you brace against, not a lever on a backplate. Putting the long-plate grid on a slider is the same category of error as putting the S2 grid on tilt and turn. This is also why `/aluminium-sliding-doors/`, `/patio-doors/`, `/aluminium-bifold-doors/` and `/slide-fold-doors/` were kept off `door_handles.slugs`.
- **Scope is `/patio-doors/` only, and that is settled.** Owner instruction, 2026-08-02: do not add it to `/aluminium-sliding-doors/`. Mila's literature says the ProLinea suits PVCu, timber and aluminium patio doors, which is why the question was raised; the answer is no. Do not widen `patio_handles.slugs` on the strength of the literature. ~~That route renders no handle section, deliberately.~~ **Superseded 2026-08-03:** `/aluminium-sliding-doors/` now has its own family, the architeQ Aspire lift and slide furniture. See the rule below.
- Facts come from the Mila ProLinea Patio Door Handle literature: aluminium on painted finishes and zinc on plated, reversible for left or right handed doors, 50,000 cycles independently tested, salt spray 240 hours plated and 480 hours powder coated. Do not add values the source does not support.
- **We fit five of Mila's six finishes. Smokey Chrome is not offered** (owner instruction, 2026-08-02) and must not be added back from the literature.
- **Customer-facing finish names follow the site, not Mila.** Ours are White, Black, Chrome, Gold and Satin Silver; Mila calls three of them Polished Gold, Polished Chrome and Smooth Satin Chrome. Do not "correct" ours against the literature — the same rule already recorded for the greenteQ bulletin, and it is what lets a customer compare a window handle with a patio handle without learning two vocabularies.
- **The six lever/blind/blank combinations are deliberately not on the page.** Which face takes a key and which takes a fixed pull is settled at survey from how the doors are used. Recorded in the data comment so it does not need looking up again.
- **The photography is Mila's own and is a handle on a door panel, not a cutout on white.** The five share one framing because they came off one sheet; do not re-trim them individually. That is why `.fg-handle-finishes--patio` covers a square box where the other families contain into 3:4, and why the hub stage frames the image rather than floating it over the shelf glow.
- **Every tile carries a hairline, including the metallic ones.** The white finish is a white handle on a pale panel and reads as an empty slot on a white card without an edge; the border goes on all five so they stay a set rather than singling one out.
- The grid reuses `fg-handle-finishes--five`, the tilt and turn column count, rather than adding a sixth. That modifier is already named in both breakpoint lists, which is the specificity trap recorded twice below.

## Lift And Slide Handle Rule

- Lift and slide handle data belongs in `inc\site-data.php` under `lift_slide_handles`, with the product image under `assets\images\products\handles-liftslide`. It renders on `/aluminium-sliding-doors/` through the shared grid and on `/handle-options/` through the shared chooser, the same as the other four families. This is the fifth family and it closes the "patio to come" note the hub was built with.
- **It is its own family and must not be merged into `patio_handles`.** A lift and slide sash is raised off its seals before it rolls, so it takes a geared 250mm lever, where a uPVC patio slider takes a fixed D-pull you brace against. Merging them is the same category of error as putting the S2 grid on tilt and turn.
- **The lever is inside and the finger cup is outside.** Owner instruction, 2026-08-03, and it is the thing worth leading on: the cup sits flush in the sash so nothing projects into the opening. The outer face can also take a second lever back to back, or be left blank. Which one is settled with the customer before ordering, not at survey.
- Facts come from the VBH bulletin `PB_CUS_architeQ_Aspire_Suite_Lift-Slide_Door_Furniture_181125`: 250mm lever, sashes up to 400kg depending on the gear, spring location in the closed and slide positions, with or without a profile cylinder hole, Secured by Design Police Preferred Specification, and a 25 year surface guarantee. **Keep that guarantee attributed to architeQ.** It covers the handle finish, not the installation, and must never be read as the Fenster ten year insurance-backed guarantee. The same rule already applies to the greenteQ figures.
- **The spindles, fixing packs, VBH order codes, the cylinder-hole variants and the Hi-Grip option are deliberately not shown to customers.** Hi-Grip stands the lever 11mm further off the sash for clearance. They are fitter choices; nobody choosing a handle needs them. Recorded in the data comment so they do not have to be looked up again.
- **We fit five of the nine finishes: Anthracite, Black, White, Chrome and Brushed stainless steel.** Owner instruction, 2026-08-03. The bulletin also lists Window Grey, PVD Gold, Satin Chrome and Brushed Graphite; those are not offered. **Chrome is VBH's Polished Stainless Steel**, owner-confirmed: the customer-facing name follows the site so a visitor can compare a lift and slide handle against a window or patio handle without learning two vocabularies. Do not "correct" it against the literature, which is the rule already recorded for the Mila and greenteQ bulletins.
- **Three finish images are VBH's own renders and two are derived.** Anthracite, Black and Chrome are lifted from the bulletin. VBH publish no White lever and no brushed lever, so White is derived from the black render and Brushed from the polished one with its tonal range compressed to satin. Owner instruction, 2026-08-03: make the assets rather than ship colour blocks, which is the same call already recorded for the tilt and turn finishes. **Do not present the two derived files as supplier photography, and replace them the moment VBH publish real ones.** An earlier pass shipped colour chips instead and the owner rejected it: this family must look like the other four.
- **All five were padded onto one shared canvas before scaling**, so the handles are the same size as each other. Do not re-trim them individually. The same rule already covers the heritage door configurations, the tilt and turn finishes and the Mila patio set.
- `handle-grid.php` and `handle-chooser.php` both degrade when a finish has no image: the grid draws a chip from `hex`, and the chooser takes a single `fallback_image` rather than emitting an empty `src`. Keep both fallbacks for future families; an empty `src` is a broken image and makes the browser re-request the page. **A chooser with no per-finish images also has nothing for its swatches to switch**, which is the second half of why chips were not good enough here.
- **`pdfimages` hands you the RGB layer and its soft mask as separate files.** Taking the RGB alone puts the handle on a solid black rectangle, which reads as a broken crop on a light page and shipped that way to test on 2026-08-03. Composite each part with its mask before trimming. Related to the CMYK inversion trap recorded for the Mila literature: what the tool extracts is not what the PDF shows, so look at the result.

## Door Handle Section Rule

- Door handle data belongs in `inc\site-data.php` under `door_handles`.
- Door handle crop assets live under `wp-content\themes\fenster\assets\images\products\door-handles`.
- **The full door-handle chooser lives on the hub only.** Owner instruction, 2026-07-29. Door routes render `template-parts\components\door-handle-grid.php`, the compact finish grid, exactly as the window routes render `window-handle-grid.php`. Do not put the chooser back on a product page; the point of the hub is that the detail is in one place.
- ~~**The grid is on four routes only: composite, uPVC, aluminium and heritage aluminium doors.**~~ **Five as of 2026-08-07: French doors are back.** Owner, 2026-08-07: "can have handle options on french doors in hindsight they all use the same". That reverses the 2026-07-29 removal, which took French doors off on the understanding that the system did not take the long-plate handle. It does. This is consistent with the configuration rule elsewhere in this file: a French door is a pair on a door system we already sell, so its hardware follows that system rather than being its own.
- **Aluminium sliding doors stay off, and that is not the same question.** They were removed in the same 2026-07-29 pass and have since been given their own family, the architeQ Aspire lift-and-slide furniture in `lift_slide_handles`. Do not read the French doors reversal as licence to widen the list to sliders. Patio, aluminium bifold and slide and fold were never on it and each has its own reason.
- **Doors have eight finishes where windows have six, so the door grid takes its own column count:** all eight on one row on desktop, four below `1080px`, two below `560px`. `.fg-handle-finishes--doors .fg-handle-finishes__grid` is (0,2,0) and beats the breakpoint overrides, so the doors case must be named in each media query it needs to change in.
- **The door tiles carry no sub-label.** Every `door_handles` label reads "<name> long-plate handle", which the section heading has already said; it wrapped to two lines and set the row height for no information. The window grid keeps its sub-label because there it names the finish method rather than repeating the name.
- **Two routes call the grid themselves rather than inheriting it.** `/heritage-aluminium-doors/` returns before the shared product tail, so `heritage-aluminium-doors.php` calls the component directly, as it already does for the tech banner. Composite reaches the tail but had been excluded by an explicit `! $is_composite_doors`, which is now gone: its old inline hardware picker went with the tabbed configurator on 2026-07-22 and renders nowhere, so the route had no handle content at all until this change.
- Do not show the long-plate door handle grid on `/patio-doors/`, `/aluminium-bifold-doors/`, `/slide-fold-doors/` or `/aluminium-sliding-doors/`; those systems use different handle families. **`/french-doors/` came off this list on 2026-08-07 and now renders the grid**, per the owner reversal above.
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

## Swatch Provenance Rule

- **A colour shown to a customer must come from the product data, never from a hex written into a stylesheet.** The six dots on the Frame colours card were hardcoded in `main.scss`. Four matched real finishes and two, a sage green and a navy, matched nothing anyone could order; that mix is precisely why it went unnoticed. They are read from `colour_options` by name now, through `--dot-N` custom properties, with real values as the CSS fallbacks.
- **The same colour is drawn the same way on every surface.** A finish that appears on a configurator, an inline grid and the colour hub must read one source and share one treatment. That covers the diagonal split for a two-sided slat and the flake texture for a metallic one.
- **Sparkle and texture come from noise, not from tiled gradients.** Any lattice of `radial-gradient`s lines up into a visible weave at swatch size and reads as printed fabric. The glitter finishes use an inline SVG of thresholded `feTurbulence`.
- Before adding a swatch, check whether the value exists in `inc/site-data.php`. If it does not, that is the question to ask, not a gap to fill by eye.

## Asset And Cache Rules

- **Replacing a theme image in place does not reach anyone who has already loaded the page.** Theme image URLs carry no version query, unlike the videos, which get `?ver=filemtime`. Overwrite `foo.webp` with new artwork and every cached browser and proxy keeps serving the old one, so the change is live, correct on the server, and invisible to the person who asked for it. This happened on 2026-08-02 with the pet flap crops: the owner was shown recropped images and reported the originals back, because his browser still had them. **Give recropped or replaced artwork a new filename**, and update every reference. A general fix would be filemtime versioning inside the image helper, which would change every image URL on the site and needs its own verification pass; it has not been done.
- **A replaced crop usually invalidates its alt text.** The same 2026-08-02 pass tightened a shot that turned out to contain a cat looking out, which no alt describing "a sealed glass unit beside a brick wall" still covered. Re-read the alt whenever the framing changes.


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

## Obscured glass textures

- **If a texture's pixels change, change its filename.** Theme images are emitted
  through `fenster_generated_url()`, which adds no version string, so replacing a
  `.webp` in place leaves browsers and the proxy serving the old one while the
  deploy verifies perfectly. This has cost review rounds twice.
- **Judge a texture on mean brightness AND standard deviation** against the rest
  of the set, then look at it on the stage. That layer is `mix-blend-mode:
  multiply`, so a dark texture does not add pattern, it turns the pane to mud.
  The set runs roughly mean 120-180, stddev 25-70.
- **A photographed texture needs a `size`; a CSS gradient does not.** `cover`
  scales to the box rather than to the glass, so the same photo is dense on a
  58px swatch and enormous on the stage. The `size` applies to the **stage only** —
  swatches stay on `cover` because they must show the whole pattern.
- **Pinning a size makes the photo tile,** and these are not seamless, so expect a
  soft join every few hundred pixels. Checked at stage width it reads as variation
  in the glass rather than a repeat.
