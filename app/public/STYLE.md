# Fenster Glazing Styling And Design Contract

Last updated: 2026-07-15

This file is the source of truth for how the site should look and feel.

Read this before changing any page layout, section styling, hero, card, form, responsive behaviour, background, animation or visual component.

Use:

- `AI.md` for coding rules, build rules, QA gates and implementation constraints.
- `HANDOVER.md` for the current site architecture and route/template context.
- `HOMEPAGE.md` for homepage-only layout, order and interaction details.
- `PROGRESS.md` for dated work logs.

## Important Updates

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

- Write from Fenster to the customer: `We supply and install...`, `Tell us...`, `You can choose...`.
- Prefer short declarative sentences and ordinary punctuation. Do not use em dashes.
- Avoid talking about Fenster as `the installer`, `the company`, `your local specialist` or another third-person entity unless the sentence genuinely refers to a separate party.
- Headings should state a useful customer truth, not advertise the writing. Avoid headings such as `Designed around you`, `The perfect finishing touch`, `Explore the possibilities` and `Everything you need to know`.
- Buttons state the next action. Good labels include `Get a quote`, `Call 01908 429200`, `View flat rooflights`, `See colour options` and `Send an enquiry`.
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
- `/sliding-sash-windows/` is the accepted reference for a richer product detail page: model comparison, spec comparison, image-led detail sections and sash-specific furniture.
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
