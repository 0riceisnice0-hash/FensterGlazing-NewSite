# Fenster Glazing Styling And Design Contract

Last updated: 2026-07-07

This file is the source of truth for how the site should look and feel.

Read this before changing any page layout, section styling, hero, card, form, responsive behaviour, background, animation or visual component.

Use:

- `AI.md` for coding rules, build rules, QA gates and implementation constraints.
- `HANDOVER.md` for the current site architecture and route/template context.
- `HOMEPAGE.md` for homepage-only layout, order and interaction details.
- `PROGRESS.md` for dated work logs.

## Important Updates

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

## Visual Assets

Use real, relevant visuals whenever a page needs personality or trust.

- Every new page or substantial new page section must begin with a scan of the local theme image assets and use the best relevant real image(s) where they improve understanding, local proof or conversion. Do not leave a new customer-facing page text-only by default when suitable project, product, team or showroom imagery exists.
- Product pages should show the product, finish, handle, glass, project, showroom or quote experience where useful.
- Contact and about pages should use real Fenster/team/showroom imagery where available.
- Avoid dark, blurred, vague or purely atmospheric imagery when customers need to understand the thing.
- Never stretch images or videos to fill space. Use `object-fit` and intentional crop positions.
- Product/gallery mosaics should use fixed aspect-ratio cells, usually `4 / 3` or `16 / 10`, with `object-fit: cover`; tall source images must not be allowed to stretch the whole section.
- Mobile image crops need a clear focal point.

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

- Use hero-scale headings only for true hero moments.
- Default page headers should be moderate, not oversized. Unless a page is the homepage, a major product hero, a case-study hero or another deliberately cinematic first screen, cap page H1s around `clamp(2.1rem, 3.6vw, 3.6rem)`.
- For normal trust, about, utility, contact-support, proof, policy, guide and content pages, H2 and H3 headings should usually share the same calm supporting scale, around `clamp(1.45rem, 2.2vw, 2rem)`, rather than stepping up toward hero size.
- If an AI is unsure whether a heading should be large, choose the smaller size first and let layout, proof, imagery and copy carry the importance.
- Use tighter headings inside cards, sidebars, forms and compact panels.
- Enquiry/form section headings are supporting content headings, not page heroes. Keep them moderate site-wide.
- Do not scale font size directly with viewport width.
- Letter spacing should normally be `0`, except small uppercase eyebrow labels.
- Long words, email addresses and phone/action text must not overflow their containers.

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

## New Conversion Page Review

Before building a new customer-facing conversion page, write down the intended reading order: primary action, immediately adjacent reassurance, decision-supporting content, human contact route, then secondary exploration. This prevents a stack of individually acceptable components becoming a generic page.

- The primary task must be visible in the first viewport on desktop. Do not place explanatory process cards ahead of a calendar, form or tool the page exists to promote.
- Use real local imagery only where it has a role: a showroom for local reassurance, a project/product image for a decision, or a finished-home image for outcome. Do not force imagery into every section or add generic image-card grids to claim a page is image-led.
- Keep the page compact. Genuinely excessive vertical gaps and duplicated explanations are defects, but do not delete established proof or working sections to fix them; tighten spacing and copy in place.
- Do a full-page screenshot pass at `1440 x 900`, `768 x 1024` and `390 x 844`; inspect the first fold, every section transition, form states, footer approach, text wrapping and horizontal overflow.
- When a page's composition is criticised, preserve the approved layout and make the smallest coherent fix first. A wholesale rebuild of an existing page requires clear owner approval; it must never be inferred from a visual critique.
- When the owner does give a clear page brief, commit to its hierarchy. A conversion page should have one dominant task, one supporting visual treatment and only the supporting sections that move a customer toward that task. Do not keep legacy proof rows, process cards, decorative image grids or link bands merely because they already exist.
