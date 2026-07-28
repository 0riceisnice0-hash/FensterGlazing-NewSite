# Fenster Glazing Legend Live Chat

Last updated: 2026-07-16

This document explains the Legend AI assistant deployed on the Fenster website. It covers the customer experience, frontend animation, WordPress and OpenAI integration, privacy and consent rules, deployment status, main files and implementation commits.

## Current Status

**Legend is complete, live and fully verified. There is no outstanding Legend work and nothing awaiting testing or approval.** Treat this section as settled unless a new Legend feature is deliberately started.

- Legend is deployed on both `https://test.fensterglazing.com/` and `https://fensterglazing.com/`.
- The complete approved Legend follow-up is deployed on test and production through source commit `cd5b430` (latest theme-code commit `d9b9ffc`). This includes the 10-second post-close sleep delay, iOS prompt handling, footer-only Cookie settings, restricted launcher hit area, chat continuity, team-profile context, deterministic Zac answer, unified header redesign and reliable product links.
- Four later refinements are also live through `af4cfc2` (2026-07-18): cookie consent kept above the chat (`716e918`), an easier-to-dismiss prompt (`a4f7276`), and Legend hidden on mobile and then all quote iframes (`8f04e7a`, `af4cfc2`) so he cannot overlay the WindowCAD tool.
- Live and test are byte-identical as of 2026-07-20, so there is no Legend delta between environments.
- Production has a separately configured OpenAI connection and returned `AI_CONFIGURED=yes` during the post-deploy check.
- The source is committed to GitHub `main`, but production uses a separate manual theme deployment. A commit existing in GitHub does not mean the live server has received it.
- Test and production OpenAI connections are configured through their separate Bedrock `.env` files. No API key is stored in the theme or this repository.

## What Was Implemented

Legend is Fenster's animated, site-wide AI assistant. He is presented as Fenster's real office cat and Chief Meow Officer while remaining clearly identified as an AI assistant.

The current experience includes:

- A standalone animated Legend launcher. Its `Need a hand?` speech bubble starts hidden, appears after the visitor scrolls 240px, and has a correctly nested action plus its own close button rather than an X positioned independently over the component.
- A soft white halo behind the closed Legend sprite so the dark character remains visible over dark page backgrounds.
- A full-height chat drawer fixed to the right edge of the viewport rather than a floating chat box.
- A drawer that slides in from and out to the right.
- A single-character handoff. The launcher Legend jumps into the drawer header instead of creating a second visible Legend.
- A full-width animated header stage where Legend idles, runs right, idles, runs left and repeats at deliberate timings.
- A unified deep-teal header treatment with a soft mint floor glow. The stage has no separate pale panel or hard vertical gradient seam, while retaining a `224px` desktop route and `190px` mobile route for standing, running and curled sleeping poses.
- A `Who is Legend?` link to `/meet-the-team/#legend`.
- An accessible live message log, typing indicator, auto-growing textarea, Enter-to-send, Shift+Enter for a new line, Escape-to-close and keyboard focus management.
- Safe `**bold**` formatting and one route-checked same-site `[label](/route/)` link in assistant replies without allowing model-generated HTML.
- Server-normalised links: full test or production Fenster URLs are converted to portable relative routes, and a known bold product recommendation is made the single primary link when the model omits or chooses a less useful destination.
- An immediately available composer, followed by a compact agreement that using live chat permits AI processing. The full disclosure is behind `Read chat terms`.
- A direct Privacy Policy link and a persistent accuracy/non-binding warning beneath the enabled composer.
- The full `By using this live chat` disclosure disappears after the visitor sends their first message; the compact accuracy and privacy warning remains available beneath the composer.
- The drawer's open state follows the visitor through same-site page navigation, including links generated in Legend's replies and the `Who is Legend?` link. Restored drawers open immediately without replaying the entrance animation and return to the newest message.
- The transcript is a self-contained mouse-wheel and touch-scroll region. It is excluded from Lenis page smoothing, contains scroll chaining and keeps the page behind the drawer stationary.

## Drawer And Cookie-Control Behaviour

On desktop the drawer is `420px` wide, limited by the available viewport width, and covers the viewport from top to bottom. On mobile the drawer becomes full width and full height.

There is no persistent floating Cookies button. The `Cookie settings` control lives in the footer and reopens the consent banner from there. Legend observes only the actual consent banner for launcher positioning. The launcher's large positioning wrapper does not accept pointer events; only the visible Legend button and speech bubble do, so its transparent area cannot block footer or cookie controls.

Opening or using chat must never accept, reject or overwrite the visitor's optional-cookie choice.

## Animation System

The website uses the packaged `legend-spritesheet.webp` atlas. The runtime intentionally references only these verified rows:

- Row `0`: idle.
- Row `1`: running right.
- Row `2`: running left.
- Row `4`: jumping.

Thinking, waving and other atlas rows must not be added to the website animation sequences unless the owner explicitly requests them and the frames are visually checked first.

The launcher-to-header handoff uses the five verified jumping frames at slower timings. The travelling sprite follows a four-stage motion path:

1. Lift away from the launcher.
2. Reach the arc apex.
3. Descend towards the drawer header.
4. Land at the final header-roamer position.

The landing point is calculated from the drawer's settled right-edge position. Do not measure the target against the drawer's temporary off-screen transform. That earlier mistake made Legend fly right towards the opening keyframe and then teleport back when the header sprite appeared.

Reduced-motion visitors receive an instant handoff without the travel animation.

Legend also uses the separate transparent eight-frame `legend-sleep-strip.webp` generated from the approved character through the hatch-pet workflow. It progresses from standing, sitting and tucking his paws through to a compact curled sleeping ball. The last two frames alternate slowly as a breathing loop.

- Clicking the chat drawer X returns Legend to the launcher in his idle state, then waits 10 seconds before playing the curl-up sequence.
- Twenty seconds without interaction with Legend plays the same sequence, whether the drawer is open or closed.
- Pointer, focus, typing or launcher interaction resets the inactivity timer. Clicking a sleeping Legend reverses the sleep frames before the normal jump into chat.
- The speech bubble reveal checks window, document, touch and `visualViewport` scrolling so it also appears on iOS. Sleeping does not suppress a scroll-triggered bubble.
- Reduced-motion visitors move directly between the final sleeping frame and normal idle state.

## How The Chat Works

The browser collects a bounded current-page context containing:

- Page title.
- Canonicalised same-site page URL with credentials, query string and hash removed.
- Meta description.
- High-priority visible specification and technical panels.
- High-priority visible Meet the Team profiles, including each person's name, role and published biography.
- Canonical theme `product_usps` values for the current product route.
- Header and navigation text.
- Main page content.
- Footer text.
- The most recent messages from the current in-panel conversation.

The browser sends this context and the visitor's message to:

`POST /wp-json/fenster/v1/legend/chat`

The WordPress REST handler validates the request, adds Fenster-specific instructions and calls the OpenAI Responses API. The response is returned to the browser and rendered as inert text, with only the small safe `**bold**` subset and a single same-site `[label](/route/)` link converted into DOM-created `strong` and `a` elements. External, full-URL and malformed links remain plain text.

For every question, the backend also extracts a focused passage around the first meaningful matching term in the current page. This query-matched excerpt prevents relevant names and facts from being overlooked inside the larger page snapshot. A named profile visible on Meet the Team must be answered directly rather than treated as unknown.

Zac Bartley's identity and role also have an owner-approved deterministic server response for common identity and role questions. This runs before the model and returns his Marketing Executive remit even if page context is missing or the model would otherwise ignore it.

After chat use, the browser keeps up to 16 recent messages in `fenster_legend_chat_v1` for up to 24 hours from the latest activity. This restores and synchronises the conversation across Fenster pages and browser tabs in the same browser. It does not submit the chat as a Fenster enquiry, create a customer account, add a CRM lead or claim that a staff member has received the message.

The same state records whether the drawer is open and whether a message has been sent. This keeps an active chat open during same-site navigation and prevents the introductory disclosure from reappearing after use. Closing the drawer records the closed state. Opening or restoring always scrolls the transcript to its newest message.

When a visitor uses chat, each user message and Legend reply is copied to the authenticated Marketing Dashboard Website Tracker for quality assurance and automatically expires 30 days after each message. If the visitor has accepted optional cookies, the copy is linked to the existing anonymous `FGV-...` visitor and `FG2-...` journey, start page and timestamps; the dashboard has a dedicated Legend chats view and the visitor journey links to that transcript. If optional cookies are rejected, the transcript remains chat-only: it has no `FGV`, `FG2`, journey or website-event record.

## Cross-Page Fenster Search

Legend is not limited to the visible page. When a factual Fenster question needs more information, the backend searches a bounded local index of other published Fenster theme and WordPress pages.

The search process:

- Excludes the current route.
- Normalises search terms, including common warranty spelling variants.
- Scores titles, descriptions and page content.
- Prepends canonical `product_usps` specifications so values are not lost inside long generated pages.
- Selects up to four relevant sources.
- Supplies short excerpts with page titles and URLs.
- Caps the complete related-page context before it reaches the model.

This is same-site, read-only retrieval. It is not unrestricted internet browsing. All visible-page and retrieved-page text is labelled as untrusted reference material and cannot override the server's assistant instructions.

## Verified Fenster Facts And Source Priority

The backend also supplies an owner-confirmed fact block on every request. These facts outrank imported FAQs, older articles, generic page copy and previous conversation messages when sources conflict. Query-matched product specifications are injected directly from `product_usps`, independently of related-page excerpt ranking.

The confirmed business facts are:

- Every new window and door installation receives a 10-year insurance-backed guarantee through the Consumer Protection Association. Repairs, replacement glass, roofline, integral blinds and pet flaps are not automatically included in that insurance-backed guarantee.
- Fenster handles covered guarantee issues while trading. CPA is the insurance back-up if Fenster permanently ceases trading, subject to the policy terms.
- Fenster guarantees are not transferable to a new homeowner.
- Double glazing is standard. Triple glazing is a specification option on most new windows and doors, except uPVC flush casement windows, slide and fold doors, and sash windows.
- Residential coverage is Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. Commercial coverage is nationwide across England and Wales.
- Eligible domestic replacement windows and doors receive FENSA registration. Fenster applies after installation and FENSA sends the certificate directly to the customer.
- Product-card specifications are authoritative. A starred U-value is the lowest achievable value and must not be presented as guaranteed for every size and configuration.
- Current Distinction composite doors include the published £5,000 security guarantee. Integral blinds have magnetic or electric controls and a 10-year guarantee.
- Prices must not be estimated. Use the instant quote tool unless an exact price is explicitly published.
- Showroom hours are Monday to Friday, 8.30am to 5pm, with phone lines open 24/7. Fenster is closed at weekends.
- Consultation dates and times are requests until the team confirms them by phone or email.
- Consultations are free. Fenster visits, measures up and prices the job at no charge, and there is nothing to pay if the customer decides against the work.

Articles and guides may still supply general advice, but they cannot establish current product availability, certification eligibility, hours or guarantee terms by themselves.

## Legend's Behaviour Rules

Legend must:

- Answer questions about Fenster Glazing, its products, services, pages, customer journey, team, Legend and directly related glazing decisions.
- Treat greetings, thanks, goodbyes, meows, purrs, harmless cat jokes and questions about Legend as welcome social conversation. Reply warmly in Legend's gentle cat personality without forcing every exchange into a sales prompt.
- Know that the real Legend is Fenster's black office cat and Chief Meow Officer, and that his dad is Nick Baker, Fenster's Sales Director. Do not invent additional biographical details.
- Redirect substantive unrelated programming, homework, general knowledge, politics, entertainment and creative-writing requests back to Fenster in one short, naturally worded response.
- Use concise British English with short paragraphs rather than walls of text.
- Avoid em dashes.
- Be honest when the available Fenster information does not support an answer.
- Direct visitors to the real contact, quote or consultation routes when human action is required.
- Never claim to book appointments, send enquiries, check customer accounts or pass a message to the team.
- Avoid repeating or generating profanity, slurs or abusive language. Input history and model output are filtered server-side as an additional safeguard.
- Treat its answers as general guidance, not a quotation, technical specification, warranty decision, contract, professional advice or legally binding commitment.

## Privacy And Chat Acknowledgement

The composer is immediately available. The compact terms below it explain that using chat means:

- Legend uses AI.
- The message and relevant page content are processed to generate a reply.
- Replies may be inaccurate.
- Replies do not form quotations, contracts, warranties, professional advice or legally binding commitments.
- Sensitive personal information should not be entered.
- The Privacy Policy contains further information.

The alternative `Not now` action closes the drawer.

Up to 16 recent messages are stored in `fenster_legend_chat_v1` for up to 24 hours from the latest chat activity so the visitor can continue across Fenster pages and tabs. `Clear chat` removes the browser-stored message history, and the expired state is removed when Legend next loads. The separate QA copy is retained for 30 days and is not deleted by Clear chat; it is linked to anonymous analytics only when optional cookies were accepted. This assistant storage is deliberately separate from analytics and marketing cookie consent and must never change `fenster_cookie_consent`. A visitor who rejected optional cookies remains rejected before, during and after using Legend.

The Privacy Policy now contains a dedicated `Legend AI assistant` section explaining the processing, limitations, lead-record position and separation from optional cookies.

## Security And Data Limits

The backend currently includes:

- A WordPress REST nonce.
- Same-site request validation.
- An anonymous HMAC-based request fingerprint.
- A limit of 40 requests per ten-minute rate-limit window.
- Message, history, page-context, search-context and output length limits.
- Profanity redaction on visitor conversation input and assistant output.
- A server-side OpenAI key only.
- OpenAI request setting `store: false`.
- A request timeout and clear customer-facing error states.
- No WordPress theme logging of prompts, page snapshots or model replies. The only retained QA copy is the consent-linked 30-day transcript in the authenticated Marketing Dashboard, as disclosed before chat and in the Privacy Policy.

Do not expose the OpenAI key in PHP-rendered HTML, JavaScript, screenshots, commits, documentation or browser storage.

## OpenAI Configuration

The Bedrock environment variables are:

```dotenv
FENSTER_OPENAI_API_KEY='replace-with-the-server-key'
FENSTER_OPENAI_MODEL='gpt-5.4-mini'
```

`FENSTER_OPENAI_API_KEY` is required. `FENSTER_OPENAI_MODEL` is optional because the backend currently defaults to `gpt-5.4-mini`.

Test configuration belongs in:

`~/www/test.fensterglazing.com/public_html/.env`

A future live configuration would belong in the live Bedrock `.env`, not the theme. Do not copy or expose the test key when preparing a live deployment.

## Main Files

- `wp-content/themes/fenster/template-parts/components/legend-assistant.php`: drawer, launcher, immediately available composer, compact chat terms and customer-facing notices.
- `wp-content/themes/fenster/inc/legend-assistant.php`: environment configuration, instructions, validation, rate limiting, same-site search and OpenAI request.
- `wp-content/themes/fenster/src/js/main.js`: current-page context, chat transport, safe formatting, focus behaviour, sprite timing, roaming and jump handoff.
- `wp-content/themes/fenster/src/scss/main.scss`: launcher, white halo, drawer, cookie-control movement, responsive layout and animation styling.
- `wp-content/themes/fenster/assets/js/main.js`: compiled browser JavaScript. Rebuild rather than editing directly.
- `wp-content/themes/fenster/assets/css/main.css`: compiled CSS. Rebuild rather than editing directly.
- `wp-content/themes/fenster/assets/images/assistant/legend-spritesheet.webp`: website animation atlas.
- `wp-content/themes/fenster/footer.php`: loads the shared component site-wide.
- `wp-content/themes/fenster/functions.php`: loads the Legend REST backend.
- `wp-content/themes/fenster/inc/generated-pages.php`: Legend disclosure on the generated Privacy Policy.
- `Marketing-Dashboard` repository: `migrations/0015_legend_chat_qa.sql`, `functions/api/[[path]].js` and `public/app.js` store and present the restricted 30-day transcript QA view.

## Build And Test Workflow

After changing source JS or SCSS, run from the theme directory:

```powershell
npm.cmd run build
```

For every functional or visual change:

1. Make the change locally.
2. Rebuild compiled assets.
3. Run `git diff --check` and PHP-lint changed PHP files.
4. Commit and push to GitHub `main`.
5. Deploy the committed theme to the password-protected test site only.
6. Flush WordPress and SiteGround caches.
7. Check closed, opening, open, sending and closing states.
8. Check desktop and mobile viewports.
9. Confirm the Cookies control and existing rejection remain correct.
10. Do not deploy live without explicit owner approval.

## Verification Completed On Test And Live

The implementation has been checked on the protected test site for:

- Live OpenAI responses.
- Current-page identification and answers.
- Cross-page Fenster retrieval.
- Safe bold rendering.
- Fenster-only scope enforcement.
- Profanity redaction and recall protection.
- Rate-limit and connection failure copy.
- Immediate composer with compact terms and expandable disclosure.
- Optional-cookie rejection remaining unchanged after chat use.
- Desktop drawer dimensions at `1440 x 900`.
- Mobile full-height drawer dimensions at `390 x 844`.
- Footer Cookie settings control, consent-banner reopening and unobstructed pointer access.
- No horizontal page overflow.
- Correct animation rows only.
- Jump-path landing coordinates with no rightward overshoot or teleport.
- A 39-call post-fix live regression through the protected REST endpoint, covering owner-confirmed business facts, product specifications, guarantee scope, triple-glazing exceptions, residential and commercial areas, FENSA, CPA, pricing boundaries and unrelated-request refusal.
- A full canonical product-card sweep. This caught and fixed plural product-name matching so `aluminium flush windows`, `heritage windows` and `uPVC doors` now resolve to their own specifications rather than generic or missing results.

## Before Any Future Legend Change

The initial production release is done — steps 1 to 4 below were completed on 2026-07-16 and the live OpenAI key, model and cost controls are configured. This checklist now applies only to *new* Legend work:

1. Obtain explicit owner approval for the changed experience and any altered legal wording.
2. Run `git log --oneline <LIVE_SHA>..<SHA>` and confirm the release contains only what you verified. Do not deploy `origin/main` — see the deploy trap note in `LIVECHANGES.md`.
3. Confirm the Privacy Policy and non-binding language still match the behaviour you changed.
4. Recheck rate limits, failure handling and mobile drawer behaviour.
5. Back up or record the live theme checkpoint.
6. Deploy the approved theme commit using the theme-only process in `LIVECHANGES.md`.
7. Flush live caches (`wp cache flush` *and* `wp sg purge`) and repeat the chat, consent and responsive tests on production.

## Legend Commit History

All commits below were created on 2026-07-15. They are listed in implementation order.

| Commit | Change |
| --- | --- |
| `876c480` | Added the first Legend AI chat preview. |
| `62389e5` | Corrected the initial mobile panel alignment. |
| `e23a54a` | Kept the assistant clear of the cookie banner. |
| `6504a6e` | Documented the initial test deployment. |
| `ed4944f` | Expanded the animated Legend header. |
| `af9ef91` | Documented the refined header behaviour. |
| `18ce5a5` | Added Legend movement across the chat header. |
| `12ef19a` | Documented the first motion correction. |
| `89b4529` | Corrected movement to directional running rows. |
| `cb6068b` | Documented the verified running rows. |
| `9885f52` | Connected the WordPress chat route to the OpenAI Responses API. |
| `179b907` | Documented the server-side OpenAI configuration. |
| `2b08351` | Refined the standalone launcher, reply length and tone. |
| `277f02a` | Added cross-page Fenster search and safe bold rendering. |
| `50eea15` | Clarified how related-page sources are presented to Legend. |
| `2bfee01` | Improved local site-search ranking. |
| `9f1e81a` | Preserved richer relevant search sources. |
| `6f62fb3` | Strengthened related-page grounding. |
| `30e8a36` | Normalised uncertainty after cross-page retrieval. |
| `299930a` | Replaced duplicate characters with the jump handoff. |
| `3e425e3` | Restricted website animation rows and clarified AI limitations. |
| `20fb5df` | Restricted Legend to Fenster-related support and added profanity safeguards. |
| `15f6905` | Added the explicit chat acknowledgement and Privacy Policy disclosure. |
| `377da55` | Converted the floating chat panel into a full-height side drawer. |
| `46d9289` | Kept the mobile drawer above the fixed site header. |
| `0fb84b5` | Rebuilt the jump path around the drawer's settled position to remove the fly-off and teleport. |
| `42c78eb` | Added 24-hour cross-page/tab chat continuity, Clear chat and high-priority canonical product specifications. |
| `a7e1edc` | Restricted direct published specification answers to one sentence without an unnecessary offer or call to action. |
| `017d704` | Added owner-confirmed business facts, query-matched product specifications and aligned CPA/FENSA guarantee wording. |
| `77da806` | Clarified the new-window-and-door guarantee scope and instant-quote pricing route. |
| `44597e0` | Fixed singular/plural product matching and verified the failed product questions on test. |
| `1a7be33` | Added the generated curl-up sleep strip, 20-second inactivity state, close-to-sleep behaviour and scroll-triggered prompt. |
| `0f614d1` | Restored the launcher character dimensions after the prompt was separated into valid sibling controls. |
| `e04fa89` | Added the 10-second post-close sleep delay, iOS scroll handling and footer-only Cookie settings control. |
| `debe566` | Allowed the scroll-triggered prompt to remain visible while Legend is asleep. |
| `9fb8309` | Limited pointer input to the visible launcher and prompt so the transparent wrapper cannot cover footer controls. |
| `611985b` | Added disclosure dismissal after first send, same-site open-state continuity, independent wheel/touch transcript scrolling and reopen-to-latest behaviour. |
| `4a40824` | Promoted team profiles and query-matched current-page passages so Legend reliably identifies visible Fenster staff. |
| `4ba8b4b` | Added a deterministic server answer for Zac Bartley identity and role questions. |
| `368093b` | Rebuilt the drawer header as a unified dark stage with dedicated walking and sleeping space. |
| `f01b925` | Added safe automatic product links and normalised full Fenster URLs into portable relative routes. |
| `d9b9ffc` | Made the primary bold product recommendation take priority over a later secondary link. |

Use `git log --oneline -- app/public/LIVECHAT.md` for later documentation-only updates, and `git log --oneline --grep="Legend\|legend"` for subsequent implementation commits.
