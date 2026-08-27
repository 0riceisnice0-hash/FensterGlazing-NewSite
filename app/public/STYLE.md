# Fenster Glazing Styling And Design Contract

Last updated: 2026-08-14

This file is the source of truth for how the site should look and feel.

Read this before changing any page layout, section styling, hero, card, form, responsive behaviour, background, animation or visual component.

Use:

- `TONEOFVOICE.md` for how the words should sound. This file governs how a page looks; that one governs what it says. A page is not finished until it passes both. Where a rule here is about wording, `TONEOFVOICE.md` is the fuller version and wins on detail.
- `AI.md` for coding rules, build rules, QA gates and implementation constraints.
- `HANDOVER.md` for the current site architecture and route/template context.
- `HOMEPAGE.md` for homepage-only layout, order and interaction details.
- `PROGRESS.md` for dated work logs.

## The Reference Pages

Five pages are the standard. When this file and one of them disagree, look at the page first: it is usually the newer thinking, and the rule here is what needs updating.

- `/about/` — the voice. `TONEOFVOICE.md` was derived from this page's copy.
- `/composite-doors/` — **rebuilt 2026-08-27 and it is the reference for a LONG product page with a shape.** Five chapters rather than a stack of sections: a hero that fills the fold and carries its own facts and credential, a choosing chapter with the range and the quiz on one surface, a construction chapter whose drawing highlights whatever layer is open, a finishes chapter that makes glass, colour and handles one decision, then proof and price. Copy the chapter idea and the heading scale from it, and read the Composite Doors Chapter Rule in `AI.md` before changing it. **What it is no longer a reference for:** the collection cards and the approved-installer band, both absorbed, and the old boxed 6/5 hero media, which crops a portrait photograph to a letterbox.
- `/sliding-sash-windows/` — the richer product page: model comparison, spec comparison, image-led detail sections.
- `/heritage-aluminium-doors/` — a focused single-system product page.
- `/roof-lanterns/` — hero pattern and image-led proof.

`/casement-windows/` is deliberately **not** on that list and is a sanctioned
exception. The owner's instruction on 2026-08-04 was to follow this file loosely
and ignore it where it constrains, because the house product template was not
serving the site's most-viewed page: he asked for a car maker's register rather
than a double glazing one. So it runs its own `.fg-cas` namespace, one display
size, full-bleed photography, dark technical chapters and no cards or drop
shadows. **Do not "fix" it back towards this document**, and do not treat it as
a new standard to copy either until he says so — it is one page with one
brief. If you are changing it, read the casement section of `HANDOVER.md` first.

Two cautions before copying from them:

- **They are not uniformly ahead of this file.** The heritage and roof lantern pages still render the hero phone number as a text link and use `button--outline` / `button--ghost` / `button--light` as secondary actions. Both of those contradict the owner's instruction of 2026-07-22 recorded under Customer-Facing Copy. There the rule is newer than the page, and the rule wins. Copy their composition, not their CTA markup.
- Check the dated entry in `PROGRESS.md` before treating any detail as deliberate. Some of what is on these pages is simply older than the current standard.

## Important Updates

- **THERE WAS A THIRD BLANKET `!important` HEADING RULE, ON `h3`, AND IT SURVIVED THE FIRST CLEAR-OUT.** It sat twelve lines below the `h2` rule that was fixed, and it forced all twenty-eight h3s on `/composite-doors/` to one size. **When you find a blanket `!important` heading rule, read the whole block it lives in before assuming it is alone.** The expensive case was a quiz built around a large question where the question rendered smaller than the standfirst above it.
- **AN AUDIT THAT COUNTS SHADOWS MUST SEPARATE ELEVATION FROM ILLUSTRATION.** The composite page reported twenty-nine distinct box-shadows as a systems failure; about twenty belong to the slab cutaway, where every layer and material carries its own inset shadow as lighting. Those are drawing, not UI, and tokenising them would flatten the graphic. The real count of untokenised UI surfaces was nine.
- **`/composite-doors/` now carries a five-step heading scale and three radius and shadow tokens, scoped to that route.** It is the reference page, so it is where a scale gets proved before anyone proposes sweeping the site. See the Composite Doors Design System Rule in `AI.md` for the values and for what is deliberately left off the scale.
- **A HERO IS A COMPOSITION, NOT A BETTER PHOTOGRAPH IN THE SAME BOX.** Owner review, 2026-08-27, of the first `/composite-doors/` overhaul pass: *"the hero image is not a hero image, it shouldn't be in that little box."* The image had been improved and the component had not, and the component was the shared boxed 6/5 media pattern, which is a product-page device. The composite hero is full bleed with the copy on a scrim. **When a hero is criticised, check whether the pattern is a hero before changing the picture.**
- **THE HOUSE POSITION ON STUDIO RENDERS VERSUS OUR OWN PHOTOGRAPHY, settled 2026-08-27.** A hero's job is the first impression, so it takes the best-lit, highest-resolution image available, which on the composite route is a supplier studio render. Proof sections take our own installation photography, because proof is their job. Both are in this file already and they are not in conflict; the deciding question is what the section is for.
- **A RESTYLED COMPONENT FIGHTS ITS OWN OLD RULES AND THE OLD RULES USUALLY WIN.** Rebuilding the composite quiz as a dark band left three earlier rules live: a white `.container` card that hid a white heading inside the new band, a fixed pip width that stopped the new progress bar filling, and a two-column result grid that squeezed the reveal beside an empty iframe. None of it errored. **Read the component's existing block before writing its replacement.**
- **A BLANKET `!important` HEADING RULE IS HOW A PAGE LOSES ITS HIERARCHY, AND ONE WAS FOUND ON 2026-08-27.** `/composite-doors/` carried `.generated-page--composite-doors h2` twice, 1,450 lines apart, each setting every h2 on the route with `!important`. The later one won at 28.8px and beat every namespaced heading rule underneath it, so fourteen headings on a 13,909px page were identical and nothing could be made more important than anything else. **When a page reads flat, check whether a rule is forbidding hierarchy before redesigning the page.** Removing it exposed four sections' own oversized rules, including an enquiry-form heading at `--fg-font-size-max` exactly, which this file already says must stay moderate; those rules are site-wide and are still open.
- **The grid min-width trap cost two blank phone viewports on the same page.** A grid track's minimum is `auto`, which is the max-content width of its widest child, so a wide `auto-fit` swatch grid inside a `display: grid` chapter laid that chapter out 1,180px wide on a 390px screen. It did **not** trip a horizontal-overflow check, because an ancestor clipped it. Use `minmax(0, 1fr)` on any grid track whose children can be intrinsically wide, and do not treat an overflow check as proof that nothing is off-screen.
- **THE GLOBAL `h2` RULE WAS A MALFORMED CLAMP AND SHIPPED A FLAT 48px FOR MONTHS. Fixed 2026-08-13.** It read `clamp(2rem, 3rem, 3.4rem)`: the preferred value was a constant rather than viewport-relative, so the clamp collapsed to 3rem at every width and no H2 on the site was responsive. It is now `clamp(1.45rem, 2.2vw, 2rem)`, which is the H2 scale this file has specified all along. **This changed 26 desktop and 25 mobile routes and it is the largest visual change of that session**, approved by the owner after review on test. If a heading now looks small next to an older screenshot, this is why, and the old size was the bug.
- **A design token layer exists as of 2026-08-13, and it is deliberately half-migrated.** `:root` gained spacing, type and shadow scales chosen to match values already in use, and roughly 594 declarations that were byte-identical to a token were migrated onto it. **Nothing renders differently**; that was the constraint, and it was proved by compiling both sides and substituting the tokens back. The rest is untouched on purpose: ~527 font-size declarations, mostly clamps and one-offs, and ~680 gap declarations. Migrate incrementally and only where the value is provably identical. Before this the stylesheet had **349 distinct font sizes, 514 padding values, 212 hand-typed shadows against two tokens, and `.eyebrow` defined 205 times** — that is the scale of what is left.
- **The audit of 2026-08-13 is in `FULL-SITE-AUDIT-2026-08-13.md`** and it is the current record of what is visually inconsistent across the site. Its main design findings, all verified and none yet actioned: three different hero patterns across twelve product routes, with the light "brief" hero this file nominates as *the* product hero used by only three of them; one action carrying three different labels; seven button heights; and eleven product pages exceeding 15,000px on mobile. **Read it before proposing a design-system project**, and note the owner has already rejected the hero consolidation and the mobile length restructure.
- The theme now defines `--fg-font-size-max: 3.6rem` as the site-wide display-type ceiling. No heading or decorative text may exceed it at any breakpoint. Existing oversized clamps have been capped at this token.
- The article/blog CTA form layout has been fixed with a page-specific `fg-article-form` wrapper. Do not let shared form styles render white-on-white or low-contrast labels inside article CTA panels again.
- The commercial glazing hub has been simplified into a proof-led conversion page. Commercial pages should avoid decorative micro-parallax, oversized form headings and vague "where this fits" card grids that do not help a buyer submit an enquiry.
- Performance polish should preserve the premium feel by deferring heavy media/embeds and right-sizing assets before removing visual proof.
- Launch SEO/deploy state is documented in `AI.md`, `HANDOVER.md`, `AUDIT.md` and `PROGRESS.md`; visual work should not undo those constraints while polishing pages.
- Mobile Contact hub cards now require readable overlay contrast, contained heading/copy sizing and no overlapping labels or buttons.
- Mobile About process cards require proper internal padding and bordered containment; text must not hit the card edge.
- Quote-tool embeds should stay premium and calm: desktop can show `Expand view` and `Open in new tab`, but mobile should show one clear same-tab `Open quote tool` action.
- Product page redesign rules are now in place as a regression standard: no generated product section may create horizontal body scroll; product pages should use visible information cards, full-width specification check cards and FAQ-only accordions; colour hub hero imagery can be removed on mobile if it weakens the page; sash comparison/model sections need a designed mobile layout, not squeezed desktop tables/images.
- The loading screen has been removed for lead performance. Do not add another blocking entrance animation before the page content.
- Enquiry email HTML is part of the customer experience. Keep it simple, table-based and email-client-safe; the launch template uses a light header so the Fenster logo remains visible.
- **Product and service page H1s are the product name, not a tagline.** Owner instruction, 2026-07-22. Applied to `/heritage-aluminium-doors/` and `/roof-lanterns/` on the same day. Full rule under Customer-Facing Copy.
- `TONEOFVOICE.md` now exists and is a required read alongside this file. It was derived from the About page, which the owner considers the best copy on the site.
- The five reference pages are listed near the top of this file. Prefer copying from them over inventing a new pattern, but check their CTA markup against the current rule rather than assuming it is current.

## Design North Star

Fenster should feel premium, practical and genuinely useful for customers.

The site should look like a confident local glazing company with real products, real proof, clear contact routes and careful installation knowledge. It should not feel like a generic template, a SaaS dashboard, a landing-page theme or a stack of unrelated sections.

Design decisions should prioritise:

- real customer tasks,
- strong first impressions,
- useful product and showroom visuals,
- clear calls to action,
- calm premium polish,
- mobile layouts designed on purpose,
- continuity from section to section.

## Non-Negotiable First-Pass Standard

These rules apply to every new page and substantial redesign. They are hard defaults, not optional polish:

- Keep every visible font size at or below `var(--fg-font-size-max)`, currently `3.6rem` or `57.6px`. Do not introduce a larger desktop or mobile exception.
- Use dark ink on white, pale or gradient backgrounds. White or near-white text is allowed only inside a visibly dark solid panel or over an image with a tested dark overlay. White text on a light page is a release blocker.
- Preserve the continuous page-level gradient when the page family uses it. Do not replace it with a flat white page or restart it on each section.
- At `1440 x 900`, a normal narrative section should be understandable as one complete composition within the available viewport below the header. This includes its heading, useful copy, main media and any controls. Forms, long specifications, comparison tables, FAQs and galleries may be taller when the content genuinely requires it.
- Do not achieve viewport fit by shrinking text below the approved reading scale. Shorten copy, remove repetition, reduce empty padding, choose a shallower crop or simplify the composition.
- Product pages need a sustained image rhythm. Avoid two consecutive text-heavy sections when a relevant product, project, detail or finished-room image exists. Each image must still explain or prove something.
- Never use an accidental image collage. Mixed image sizes require a deliberate grid with aligned edges, controlled aspect ratios and clear visual priority. Narrow leftover columns, stretched portraits, unexplained overlaps and arbitrary crops are defects.
- Write directly as Fenster using `we`, `our` and `you`. Do not describe Fenster in the third person.
- Do not use em dashes in customer-facing copy.
- Use plain CTA labels that describe the action, such as `Get a quote`, `View colours`, `See configurations` or `Call us`. Avoid invented journey language such as `Plan my...`, `Start your journey`, `Discover the difference` or similar campaign-style copy.
- Manufacturer names may appear only when Fenster intentionally sells the page around that named system. Do not expose scrape provenance, source-company names, filenames or internal product labels by accident.
- Information learned from a supplier scrape must be fact-checked and rewritten in Fenster's direct voice. Do not paste supplier paragraphs or mirror their sentence structure.

The owner can override any default for a specific page. In the absence of an override, these rules decide the first implementation rather than waiting for screenshot feedback.

## Design Direction: Get It Right In The First Pass

The expected standard is a finished, intentional page on the first implementation pass — not a collection of reasonable components that are repeatedly rearranged after the fact. An agent must make the design decision before writing the layout.

### Start With The Page Idea

Before coding a new page or a substantial redesign, establish these five things in writing for yourself:

1. The customer's primary task on the page.
2. The single visual object that should command the first viewport: a product, a project image, a quote tool, a calendar or a clear route choice.
3. Which existing sections earn a place because they help that task — and which do not.
4. One deliberate supporting image treatment and what it proves or helps the customer understand.
5. Where reassurance belongs: immediately near the action, as real reviews later in the journey, or both with clearly different jobs.

Do not begin by adding cards, filling a standard section sequence, or treating every supplied instruction as a separate component. The result must read as one idea from top to bottom.

### Required First-Pass Workflow

- Inspect the closest successful existing page patterns and scan relevant local image assets before choosing a layout.
- Create a page inventory: retain, remove, or replace each existing section. Do not accidentally preserve weak legacy filler merely because it already renders.
- Choose the full desktop composition before styling individual sections. Define the first viewport, section order, image role, proof role and final stopping point.
- Build the complete composition in one coherent pass. Do not make a visible page progressively worse through a series of speculative patches.
- Treat visual QA as validation, not as the stage where the design concept is discovered. If the first full-page render does not read as one composed journey, rethink the hierarchy before adding polish.
- Do not call a page complete because individual components look clean in isolation. The page must feel designed as a whole at the actual viewport.

### Conversion-Page Composition

For a conversion page, use this order unless the owner specifies another:

1. A first viewport with one dominant action and only the information needed to make it feel safe and useful.
2. Compact, adjacent reassurance for that action.
3. One art-directed supporting section: a real image and useful decision-supporting copy, not a generic card grid.
4. Only the remaining proof, answers or contact detail that removes genuine friction.
5. A clear end. Do not append a generic link band, duplicate process cards or another CTA merely to make the page longer.

The booking consultation page is the reference: calendar as the first-view object; restrained Trustpilot/FENSA reassurance beneath it; one full image-and-advice section; concise booking answers; then genuine reviews. It does not need a detached proof wall, process cards, decorative hero tiles, product-card grids or filler links.

### Hierarchy, Proof And Imagery

- Give every page one primary action. A second CTA is allowed only when it is a genuine alternative route, not a duplicate of the primary action.
- Do not repeat the same promise in hero copy, notes, process cards, trust strips and FAQ copy. Say it once in the best location.
- Reassurance immediately next to a form or tool should be compact and specific. A fuller review section later should provide different evidence, not repeat the same badges.
- Use one strong image treatment before using several small ones. A single relevant project image beside meaningful copy is more premium than a collection of tiles.
- Every image needs a job: local proof, product understanding, outcome, team confidence or decision support. If its only job is to break up white space, do not use it.
- Never force portrait or unusually tall source imagery into a repeated card grid. Crop it intentionally, use it as a feature image, or select a better asset.
- Do not use excessive empty space as a substitute for hierarchy. Equally, do not compress a page into stacked cards. Space should frame the dominant object and mark a genuine change of thought.

### What Fenster Should Look Like

Fenster pages should feel considered, local and quietly expensive — strong Gibson type, dark steel for confidence, green reserved for action/proof, real work on real homes, restrained panels and clear practical copy. They should never feel like:

- a generic SaaS dashboard;
- a random stack of white cards;
- a marketing template with every section shouting;
- a collage of unrelated images;
- a long page made from repeated proof, process and CTA blocks.

When in doubt, remove the weaker section, make the primary task clearer, use the better image once, and let the page end earlier.

## Site-Wide Background Rule

The page background is a continuous canvas, not a separate background painted on every section.

For pages using `--fg-page-gradient`:

- Paint the gradient once on the outer page wrapper, page body or main page container.
- Full-width section wrappers should usually be transparent.
- Do not paint another copy of `--fg-page-gradient` on each section, inner flow wrapper, carousel wrapper or repeated block.
- Do not anchor the same gradient separately to multiple sections. It creates visible seams and makes the page feel chopped up.
- Use white, dark, soft or glassy panels only where content needs contrast.
- Cards, forms, quote previews, trust widgets and route panels can provide local contrast against the shared page background.
- A full-width solid band is allowed only when it has a clear design purpose, such as a dark CTA, footer, proof strip or major contrast handoff.

If a page looks like stacked coloured bands, repeated gradient panels or disconnected template sections, fix the page canvas before tuning individual cards.

**The canvas is already painted on `body`, with `background-attachment: fixed`.** A route wrapper that sets `background: var(--fg-page-gradient)` again therefore stacks a second, *scrolling* gradient over the fixed one, which reads as banding between sections. This was the cause of the visible gradient bug on `/composite-doors/` fixed on 2026-07-22, where the wrapper repainted it twice. Before adding a gradient to any page wrapper, check whether `body` is already providing it. Several older route wrappers still repaint it (`.fg-heritage-door-page`, `.fg-roof-lantern-page`, `.fg-fensa-page`, `.fg-flat-rooflight-page`, `.fg-consultation-page`) and should be checked for the same defect when those pages are next worked on.

## Section Continuity

Sections should feel like parts of one composed page.

- Judge spacing between meaningful content edges, not just section boxes.
- Avoid giving every section identical top and bottom padding.
- Major narrative handoffs can be generous.
- Compact utility handoffs should be tighter.
- Do not hide awkward joins with repeated backgrounds.
- Do not use negative margins unless the layout has a documented, measured reason.
- Controls, dots, progress bars and buttons belong visually to the component they operate.
- On desktop, target a composed section height of roughly `680px` to `780px` for ordinary product storytelling so it remains visible beneath the header at `1440 x 900`.
- Do not apply `min-height: 100vh` to every section. Viewport fit is a composition check, not a reason to create artificial empty space.
- If a section exceeds one desktop viewport, identify the cause before shipping. Usual causes are too much copy, oversized headings, excessive vertical padding, duplicated captions or media without a controlled height.

## Visual Assets

Use real, relevant visuals whenever a page needs personality or trust.

- Every new page or substantial new page section must begin with a scan of the local theme image assets and use the best relevant real image(s) where they improve understanding, local proof or conversion. Do not leave a new customer-facing page text-only by default when suitable project, product, team or showroom imagery exists.
- Product pages should show the product, finish, handle, glass, project, showroom or quote experience where useful.
- Contact and about pages should use real Fenster/team/showroom imagery where available.
- Avoid dark, blurred, vague or purely atmospheric imagery when customers need to understand the thing.
- Never stretch images or videos to fill space. Use `object-fit` and intentional crop positions.
- Product/gallery mosaics should use fixed aspect-ratio cells, usually `4 / 3` or `16 / 10`, with `object-fit: cover`; tall source images must not be allowed to stretch the whole section.
- Mobile image crops need a clear focal point.
- A major product page should normally show at least one relevant image in the hero and continue with useful product or installation imagery through the page. Do not let a page become a mostly textual brochure when suitable assets exist.
- Before coding, inspect image dimensions and subjects. Choose the grid from the actual assets rather than forcing every source into a preselected card pattern.
- For three-image compositions, use a clear dominant image plus two supporting images with aligned outer edges, or use three equal cells. Do not create a thin central strip between two oversized images.
- Captions must sit with the image they describe and must not compete with the main heading.

## Cards And Panels

Cards should add structure, not turn every section into a grid of boxes.

- Use cards for repeated items, forms, route choices, proof items, quote previews and compact technical information.
- Do not put cards inside cards.
- Avoid floating-card page sections unless the section is genuinely a framed tool or form.
- Cards should normally use `8px` border radius or less.
- Cards that visually act as links must be direct links.
- Hover polish is fine, but the interaction cannot depend on hover.

## Colour And Tone

The site should use Fenster's green, teal/steel and soft neutrals with restraint.

- Avoid one-note palettes where the page becomes only green/teal/blue.
- Use green mainly for action, highlights, proof and small emphasis.
- Use dark steel for confidence and contrast.
- Use white and soft neutral panels for readability.
- Do not introduce decorative gradient blobs, orbs or unrelated background effects.
- If the page feels busy, reduce local backgrounds before reducing useful content.

## Typography

Type should be bold and confident, but sized for its container.

- The absolute site-wide ceiling is `var(--fg-font-size-max)`, currently `3.6rem`. This applies to homepage display text, heroes, promotional headings and mobile overrides as well as ordinary page headings.
- New large type must use the shared token as the maximum value, for example `font-size: clamp(2.5rem, 3.6vw, var(--fg-font-size-max));`.
- Use hero-scale headings only for true hero moments. A normal page H1 should usually use `clamp(2.1rem, 3.6vw, var(--fg-font-size-max))`.
- H2 headings should usually stay around `clamp(1.45rem, 2.2vw, 2rem)`. An art-directed product section may rise toward `2.5rem` when the surrounding composition supports it, but it does not inherit hero scale.
- H3 headings should usually stay between `1.15rem` and `1.45rem`.
- Body and lead copy should normally stay between `1rem` and `1.18rem`. Use width and spacing for emphasis before increasing body text.
- If an AI is unsure whether a heading should be large, choose the smaller size first and let layout, proof, imagery and copy carry the importance.
- Use tighter headings inside cards, sidebars, forms and compact panels.
- Enquiry/form section headings are supporting content headings, not page heroes. Keep them moderate site-wide.
- Do not scale font size directly with viewport width.
- Letter spacing should normally be `0`, except small uppercase eyebrow labels.
- Long words, email addresses and phone/action text must not overflow their containers.
- Do not use large type as the main source of visual drama. Composition, photography, contrast and spacing should establish hierarchy.

## Customer-Facing Copy

`TONEOFVOICE.md` is the full account of how Fenster sounds, taken from the About page. Read it before writing any customer-facing words. The short version, because it changes layout decisions too:

- Facts do the persuading, not adjectives. `A 44.5mm insulated slab, against 28mm for a uPVC door panel` beats `exceptionally robust`. This is why the reference pages give real numbers so much room: the design has to leave space for a specific fact where a template would have put a claim.
- Say the awkward thing first. Naming the limitation before the benefit is what makes the rest believable.
- Respect the reader's way of doing things: `If you like X... If you would rather Y...`.
- One dry aside at most per page, and never in a hero.
- British English. No em dashes, no exclamation marks.
- If a section needs a superlative to justify its existence, the section is the problem.

- Write from Fenster to the customer: `We supply and install...`, `Tell us...`, `You can choose...`.
- Prefer short declarative sentences and ordinary punctuation. Do not use em dashes.
- Avoid talking about Fenster as `the installer`, `the company`, `your local specialist` or another third-person entity unless the sentence genuinely refers to a separate party.
- **The H1 on a product or service page is the name of the thing, not a line about it.** Owner instruction, 2026-07-22. `Sheerline heritage aluminium doors`, not `The steel-door look, without the steel.` `Distinction composite doors`, not `A front door you never have to paint.` `Sheerline S1 roof lanterns`, not `Bring more daylight into your extension.` Someone landing from a search wants confirmation they are in the right place before they want persuading.
  - Include the system or brand name when the page is sold around one, in the form the customer would recognise it. Otherwise use the plain product name.
  - No closing full stop on an H1. It is a name, not a sentence. This is the one place `TONEOFVOICE.md`'s full-stop rule does not apply.
  - The persuading moves down one level: the eyebrow carries the location line, and the lead paragraph directly under the H1 does the selling. Nothing is lost, it just stops being the headline.
  - This applies to the H1 only. Section headings below it still state a customer truth, in sentence case, with the closing full stop.
  - Non-product pages keep a voice H1 where it is genuinely the point. `/about/` opens with `Simple, honest glazing.` and should stay that way.
- Headings below the H1 should state a useful customer truth, not advertise the writing. Avoid headings such as `Designed around you`, `The perfect finishing touch`, `Explore the possibilities` and `Everything you need to know`.
- Buttons state the next action. Good labels include `Get a quote`, `Call 01908 429200`, `View flat rooflights`, `See colour options` and `Send an enquiry`.
- **Anything that acts as a call to action is a button, never a text link.** That includes phone numbers. Owner instruction, 2026-07-22.
- **The CTA pair is green then dark, taken from the header:** primary `.button` (green, `--color-accent`), secondary `.button--steel` (dark, `--color-steel`), matching `Instant Quote` and `Book consultation` in the navigation. Use this pairing for every two-action row. The one exception is a dark panel, where a dark secondary disappears into the background: use `.button--light` there instead.
- Do not turn product configuration into role-play copy. Avoid `Plan my roof lantern`, `Build my dream`, `Find my perfect...` and similar phrasing.
- Keep SEO terms inside natural sentences. Repeating a location or product phrase is not worth making the page sound as if it was written about Fenster by somebody else.

## Forms

There is one shared live customer form:

`wp-content\themes\fenster\template-parts\components\enquiry-form.php`

- Do not create standalone customer forms.
- Make page-specific form sections nicer around the shared component.
- Do not let form intro headings dominate the form. The form should remain the primary task surface.
- Mobile forms must be one column.
- Mobile inputs, selects and textareas must use at least `16px` text.
- Tap targets should be at least `44px` high.
- When the shared form is placed inside a strong visual panel, add a context class and make the contrast explicit. Labels, required markers, helper text, consent copy and privacy links must remain readable before and after focus.

## Commercial Pages

- Commercial pages should feel practical, sober and proof-led.
- Use real project and building imagery where possible.
- Keep commercial service cards scannable and customer-facing.
- Remove motion that does not help comprehension or conversion.
- Form sections should make the enquiry task obvious: moderate supporting copy, visible fields, clear file-upload language and a strong submit button.
- Do not expose internal area-review language or commercial county plumbing as customer-facing navigation.
- **Write for the person pricing it, not the person living in it** (owner,
  2026-08-11). The audience on these pages is contractors, architects, QSs,
  estimators and project managers. Lead with the fact and let it carry the
  sentence: "IKL33: 34mm blades at 60 degrees" over "the one we fit most",
  "Five frame options, chosen to suit the opening" over "the frame is specified
  separately from the blade". Three phrasings were rejected on the louvre page
  for reading as marketing warm-up before the information. Still Fenster's
  voice, just with the softening taken out — plainer, not colder, and never a
  spec sheet with the human removed.
- **Give them the number they have to put in a schedule.** Free areas, blade
  centres, depths, RAL. A commercial page that describes a product without its
  figures has not done its job.
- **Do not name the system manufacturer.** Model codes are fine and useful;
  the supplier's brand is not ours to advertise. Check the head as well as the
  body — the louvre meta description kept a brand name four hours past the
  debranding pass because that pass only read rendered text.

## Colour And Specification Hubs

- Specification hubs should feel like useful reference tools, not giant catalog dumps.
- Keep colour hub visible copy customer-facing: material names, finish names and concise detail only.
- Do not expose scrape/source/manufacturer provenance in customer UI unless explicitly requested.
- Use interactive controls only where they help browsing. A draggable coverflow-style carousel is acceptable for colour swatches.
- Drag interactions should control the component's animation state directly; avoid dragging an entire stage sideways and snapping it back.
- Hero imagery for colour hubs should be controlled and legible. Use complete swatch/sample images or intentional crops that do not chop off important content.
- Avoid random overlapping or rotated card piles in hero visuals.
- If colour hub hero imagery looks weak or awkward on mobile, hide it and let the page start with clean copy and controls.

## Product Detail Pages

- Product pages should have a clear reading path with a roughly balanced image/text rhythm where useful. Avoid stacking too many cards, controls and text blocks without a visual pause.
- Product intro sections should be labelled `Product information` and then the product name. Avoid returning to generic headings such as `Why choose this product?`.
- Product hub sections should use `More information on [product]`, not `Product name, explained properly`.
- Product pages should not use accordions outside FAQs.
- Do not restore the product-hub survey summary, common choices strip, quote option card or separate accreditations/systems filler section.
- Product-gallery thumbnails should open a dark in-page lightbox with no visible alt/caption text, no white background card and previous/next controls. They should not open a raw image URL in a new tab.
- Product-specific sections should show the real product system, not generic hardware or supplier filler.
- `/sliding-sash-windows/` is the accepted reference for a richer product detail page: model comparison, spec comparison, image-led detail sections and sash-specific furniture. `/composite-doors/`, `/heritage-aluminium-doors/` and `/roof-lanterns/` are the other three references; see The Reference Pages near the top of this file.
- **The product hero pattern** is the one shared by composite doors, heritage doors and roof lanterns: eyebrow carrying the product and location, H1 naming the product, one lead paragraph that does the selling, the CTA pair, then a short reassurance list of three concrete facts, with a single real installation photograph alongside. Verify the hero image yourself at the actual viewport. A crop that cuts the product out of frame is a defect, not a detail.
- **Prefer opening a detail to hiding it.** The composite doors construction section shows six slab layers one at a time rather than as six stacked paragraphs. Use that pattern when a section is genuinely a list of technical detail: it keeps every word on the page while removing the wall. This does not reopen the no-accordions-outside-FAQs rule for ordinary content; it is for spec detail, and the first item must be open in the markup so the section still reads with JavaScript off.
- Sash model cards should keep their `Best for` panels and spec grids visually aligned so Ultimate, Heritage and Charisma can be compared without a chaotic card rhythm.
- Detail image panels that pair with copy cards should match the height of the copy card on desktop, with sensible static stacking on mobile.
- Sash furniture cards should use clean product-object imagery, equal-height range cards and local white/soft panels against the continuous page canvas.
- Do not use white or invisible logos inside white badges. If a copied supplier logo disappears, switch to a visible local variant and keep it routed through the theme asset system.
- Supplier/proof logos in product hubs must feel balanced on mobile. Do not let one or two partner logos dominate smaller accreditations unless there is a deliberate hierarchy.
- Product choice controls on mobile must make the full option count obvious if a control is still used. A user should not have to guess that there are more than two choices.
- Product hub cards and any remaining mobile rails must stay viewport-contained before they risk causing sideways page scroll.

## Mobile Design

Mobile is designed, not squeezed.

- Use the `860px` breakpoint unless a different breakpoint is already documented for the component.
- Design the mobile content order deliberately.
- A sticky, cinematic or multi-column desktop section needs a simpler mobile equivalent.
- Mobile can simplify a feature, but must not remove the user's ability to understand or act.
- Use native horizontal scroll-snap for mobile rails where appropriate.
- Horizontal component scrolling needs an obvious affordance: attached dots, count text, clipped next item, arrows, tabs or clear label text.
- Check `390 x 844` and `768 x 1024` for important visual work.
- No mobile work is complete with horizontal overflow, clipped text, stranded controls, unusable tap targets or distorted media.
- Horizontal body scrolling is a blocker. If any card rail, comparison table, image, iframe or control causes the whole page to scroll sideways at 390px, fix the component before shipping.
- Mobile CTA cards and overlay cards must keep labels, headings, body copy and arrow/action controls in separate readable zones.
- Mobile compact process/list cards need at least comfortable internal padding, especially when borders are visible.
- When mobile navigation is open, its overlay and hit targets must sit above page content. A hero, carousel or product card must never intercept taps meant for the menu.

## Homepage Background Rule

The homepage is the clearest example of the continuous canvas rule.

- Below the video hero, the homepage uses one moving page gradient via `--fg-page-gradient`.
- Section wrappers under that canvas stay transparent unless they need functional contrast.
- Do not paint `--fg-page-gradient` again on inner homepage wrappers or mobile carousel wrappers.
- The JavaScript gradient motion and CSS variables must remain aligned.

See `HOMEPAGE.md` for homepage-only section order, product theatre behaviour and approved spacing values.

## 3D / Canvas Effects

Three.js is not part of the current live theme.

- Do not use old `fg-home-hero-3d` or `data-fg-home-3d` references as styling guidance.
- Do not add a WebGL/canvas hero as a visual shortcut for polish.
- If the owner asks for 3D later, treat it as a new feature: add the library deliberately, design mobile/reduced-motion fallbacks, and verify that the canvas renders real pixels in browser QA.
- **The integral blind visualiser is the one live canvas and is 2D on purpose.** It draws a glazed unit face on and fully straight, which is what makes 2D exact rather than approximate: with no perspective a slat projects to a plain rectangle. It is not a decorative canvas and is not a precedent for one. See `HANDOVER.md` under Integral Blinds Page before changing it.

## Product Configurators

A configurator earns its place by answering a question a photograph cannot. Nine
colours against a continuous tilt and a continuous lift is thousands of images;
that is the test.

- **Model the product, not a diagram of it.** The controls belong where they are on the real thing. On the blind unit the two magnets sit on the frame inside the glass and are dragged there, because that is how the unit is worked. Sliders parked beside a picture of a product are page furniture, not a configurator.
- **Every value on screen has to be orderable.** Swatches come from the product data, never from hexes written into the stylesheet. Two of the six dots on the Frame colours card were an invented sage green and an invented navy for months, sitting next to four real finishes, which is exactly how that error survives.
- **One colour is drawn one way everywhere.** The same finish appears on the configurator, on the inline grid and on the colour hub; all three read the same source and use the same treatment, including the split swatch for a two-sided slat and the flake texture for a metallic one.
- **Realism comes from the physics, not from filters.** Derive the shading from where the light actually is. Keep a little irregularity, because a perfectly even array reads as a printed rule, but only a little: at four times the right amount the blind read as damaged rather than hung.
- Interactive stages stay pannable on touch. Only the control itself takes the drag, or the page stops scrolling over the component.

## QA For Visual Work

Before handing back visual work:

- Rebuild after SCSS or JS changes.
- Lint changed PHP templates.
- Check desktop and mobile.
- For important visual changes, check `1440 x 900`, `768 x 1024` and `390 x 844`.
- Check no horizontal overflow.
- Check console errors when browser QA is available.
- Inspect section transitions, not only the top of the page.
- If a screenshot looks wrong but the CSS seems reasonable, the screenshot wins.
- At `1440 x 900`, inspect each ordinary section at its natural top edge and confirm its complete composition is visible without another scroll. Record and justify genuine content exceptions.
- Check computed heading sizes. Nothing may exceed `57.6px` while `--fg-font-size-max` is `3.6rem`.
- Search the rendered page for light text on light backgrounds, source-company names, internal filenames, em dashes and campaign-style CTA copy.
- Confirm every image has loaded, keeps its intended aspect ratio and belongs to a deliberate composition. The presence of several images does not excuse a poor grid.
- Review the full page as a sequence. Check that no two adjacent sections repeat the same layout, repeat the same promise or become an unbroken wall of copy.

## New Conversion Page Review

Before building a new customer-facing conversion page, write down the intended reading order: primary action, immediately adjacent reassurance, decision-supporting content, human contact route, then secondary exploration. This prevents a stack of individually acceptable components becoming a generic page.

- The primary task must be visible in the first viewport on desktop. Do not place explanatory process cards ahead of a calendar, form or tool the page exists to promote.
- Use real local imagery only where it has a role: a showroom for local reassurance, a project/product image for a decision, or a finished-home image for outcome. Do not force imagery into every section or add generic image-card grids to claim a page is image-led.
- Keep the page compact. Genuinely excessive vertical gaps and duplicated explanations are defects, but do not delete established proof or working sections to fix them; tighten spacing and copy in place.
- Do a full-page screenshot pass at `1440 x 900`, `768 x 1024` and `390 x 844`; inspect the first fold, every section transition, form states, footer approach, text wrapping and horizontal overflow.
- When a page's composition is criticised, preserve the approved layout and make the smallest coherent fix first. A wholesale rebuild of an existing page requires clear owner approval; it must never be inferred from a visual critique.
- When the owner does give a clear page brief, commit to its hierarchy. A conversion page should have one dominant task, one supporting visual treatment and only the supporting sections that move a customer toward that task. Do not keep legacy proof rows, process cards, decorative image grids or link bands merely because they already exist.
