# Fenster Glazing Homepage

Last updated: 2026-07-03

This file is the dedicated source of truth for the homepage only.

Use:

- `AI.md` for site-wide coding and QA rules.
- `HANDOVER.md` for whole-site architecture/context.
- `STYLE.md` for site-wide visual styling, including the continuous page background rule.
- `PROGRESS.md` for dated progress reports.

Homepage URL:

`http://fenster-glazing.local/`

Main template:

`wp-content\themes\fenster\template-parts\sections\home-experience.php`

Homepage route and data handoff:

`wp-content\themes\fenster\template-parts\sections\generated-page.php`

Main styles:

`wp-content\themes\fenster\src\scss\main.scss`

Main interactions:

`wp-content\themes\fenster\src\js\main.js`

Optimised hero video:

`wp-content\themes\fenster\assets\videos\home\fenster-home-hero.mp4`

## Current Boundary Note

The 2026-07-03 Roseview/sliding-sash work was product-page work, not a homepage architecture change.

Do not copy the sash model comparison, Roseview furniture grid or product-hub badge treatment into the homepage product theatre unless the owner explicitly asks for a homepage sash feature. The homepage should keep its broader customer journey and route users into `/sliding-sash-windows/` for the detailed Roseview comparison.

## Homepage Direction

The homepage should feel premium, useful and interactive without becoming heavy or confusing.

The intended balance is:

- customer-facing and easy to understand,
- visually impressive,
- focused on instant pricing as the strongest buyer path,
- restrained enough to perform well,
- mobile-friendly with no sticky scroll traps,
- built over one continuous moving page gradient below the hero.

Avoid internal/template language such as:

- systems overview,
- choose the right system,
- product path,
- journey,
- route,
- proof layer.

## Current Page Order

1. Video hero
2. Combined trust cards
3. Interactive homeowner product theatre
4. Instant-pricing conversion bridge
5. Project/case-study proof
6. Manufacturer and system partners
7. Curated customer review showcase
8. Homepage enquiry form
9. Small local-service link area
10. Expanded site footer

## Hero

The hero keeps the full-width background video.

Current behaviour:

- Desktop height: `clamp(600px, 78svh, 760px)`.
- Mobile height is content-driven so text/actions are not clipped.
- Primary CTA: `Get an instant price`, linking to `/online-quote/`.
- Secondary CTA: `Explore our products`, scrolling to `#fenster-products`.
- The hero contains no showroom information box.
- The large visual instant-pricing card was removed from the hero because it competed with the video.

Do not restore:

- the Milton Keynes showroom box,
- a large instant-pricing screenshot panel over the hero,
- a full-viewport hero height,
- scroll-linked transforms on the playing video.

### Hero Video Performance

The old reference source was unsuitable for production:

- 95.05 MB,
- 2720 x 1530,
- about 39 Mbps,
- contained unused audio.

The live homepage uses:

`wp-content\themes\fenster\assets\videos\home\fenster-home-hero.mp4`

Current live file:

- 9.36 MB,
- 1440px wide,
- silent,
- H.264,
- fast-start enabled,
- 30 fps.

Do not replace it with the 95 MB reference source.

## Trust Cards

The homepage has four combined trust cards:

1. Google — `200+ five-star reviews`
2. Trustpilot — `Rated Excellent`
3. FENSA — `FENSA approved`
4. Consumer Protection Association — `Insurance-backed protection`

The trust row and product theatre should feel connected. Avoid a large empty transition area between them.

The homepage also includes a simple Google-style review widget lower down the page, after the systems/backing partner strip and before the enquiry form.

Current behaviour:

- Review data lives in `inc\site-data.php` under `customer_reviews`.
- Reviews are manually curated short excerpts from public Google/Trustpilot sources.
- Each review links back to its source platform.
- Desktop uses a white review widget with a centred `EXCELLENT` summary, Google wordmark and a horizontal review-card carousel.
- Mobile keeps the same summary and uses the same native horizontal review rail.
- Review carousel controls use left/right buttons and auto-advance unless reduced motion is enabled or the user is interacting with the carousel.
- This is intentionally a hardcoded interim model until a cached API/plugin feed is added.
- Do not move the review widget back under the hero; only the small four-card trust bar belongs there.

## Interactive Product Theatre

Main wrapper:

`.fg-home-product-theatre`

Interaction hook:

`[data-fg-product-theatre]`

This is the main interactive homepage feature.

### Products Included

The theatre contains five homeowner-facing product groups:

1. Windows
2. Doors
3. Roof Lanterns
4. Integral Blinds
5. Other Services

Other Services groups replacement glass, glazing repairs, cat and dog flaps, porches and smaller upgrades into one route card. Commercial Glazing is intentionally excluded. Commercial users should use the Commercial navigation and dedicated commercial content.

Do not add visible product numbers back to the theatre.

### Desktop Layout

Desktop uses:

- a sticky full-width product theatre,
- product navigation buttons above the image stage,
- a large clickable visual frame,
- one active copy panel beside/under the image stage depending on viewport,
- one progress timeline beneath the stage.

The sticky stage contains:

- active product image,
- product counter,
- active product copy,
- `Explore [product]` action,
- a link covering the entire image stage.

The stage link, text, image and accessible label update to the selected product.

The active content panel contains:

- product name,
- `Best for`,
- customer-facing description,
- `Why homeowners choose it`,
- `Explore [product]`.

### Product Copy

Descriptions should explain:

- available choices,
- likely use cases,
- key benefits,
- what Fenster helps the customer decide or specify.

Useful Windows benchmark:

`Compare uPVC, aluminium, flush casement, sash and heritage styles, with help choosing the right warmth, security, colour and sightlines.`

### State Activation

The theatre uses section scroll progress to calculate the active product scene.

Current behaviour:

- desktop calculates progress from `.fg-home-product-theatre` against the viewport,
- scene index is derived from progress across the five products,
- nav buttons jump to the corresponding scene,
- keyboard support on the nav buttons uses Arrow Up, Arrow Down, Home and End,
- the visual frame updates its link and accessible label to the active product.

The old directional trigger-line product story controller is inactive legacy JavaScript unless matching markup is restored. Do not document or rebuild new homepage work around `[data-fg-home-product-story]`.

### Mobile Product Theatre

At `860px` and below:

- sticky stage is hidden,
- all five product groups appear as normal image-led cards,
- every card is directly tappable,
- no artificial final runway is used,
- no scroll trapping is introduced.

Mobile product cards live in `.fg-home-product-theatre__mobile-carousel`, with the scroll track and dots owned by that wrapper.

Reduced-motion users keep content with transitions disabled.

## Instant Pricing

Instant pricing is the strongest homepage buyer path.

It is promoted in:

1. The primary hero CTA.
2. The dedicated pricing bridge immediately after the product theatre.

Current heading:

`Get an instant quote for your windows and doors.`

Supporting points:

- Available straight away
- No callback needed to begin
- Final specification checked by Fenster

The live default WindowCAD iframe is displayed in the pricing bridge:

- the iframe sits in a large white framed preview,
- the wrapper uses `data-lenis-prevent`,
- the section keeps a primary `Get an instant quote` CTA to `/online-quote/`,
- an `Open in new tab` CTA points directly to the WindowCAD URL.

Do not:

- use `Open WindowCAD` as public-facing text,
- replace the live iframe with a static screenshot,
- restore a second duplicate pricing section later on the page.

Product pages have their own compact product-specific WindowCAD embeds further down the product template. The homepage pricing bridge uses the default quote iframe, not a product-specific collection.

## Project Proof

The old `Proof in the work` case-card strip was removed from the homepage because the commercial-heavy wording was not right for the main residential homepage flow. Keep the `Systems and backing` section.

This section provides visible evidence after the product and pricing decision path.

Cards should remain image-led and customer-facing.

## Partners

The partner strip currently includes:

- Sheerline
- Liniar
- Distinction Doors

This is supporting proof, not a major navigation section.

## Homepage Enquiry Form

The homepage uses the shared enquiry form component:

`template-parts\components\enquiry-form.php`

Do not create a homepage-only form.

The form is live-ready through the shared AJAX/enquiry system.

Current fields include:

- Name
- Phone
- Email
- Postcode/location
- Project type
- Timescale
- Project details
- Privacy consent

Desktop field rows can use two columns. Mobile fields collapse to one column.

Homepage form typography follows the site-wide form rules in `STYLE.md`: form headings should stay at supporting content scale, not hero scale.

## Local-Service Links

The homepage intentionally shows a small curated set, not the full SEO URL inventory.

Visible useful links:

- Double Glazing Milton Keynes
- Double Glazing Northampton
- Double Glazing Bedford
- Double Glazing Buckingham
- Double Glazing Ampthill
- Double Glazing Toddington
- Windows Milton Keynes
- Doors Milton Keynes

## Footer

The footer is expanded and structured.

Current columns:

- Brand/about and accreditations
- Products
- Fenster
- Contact

The Products column includes key residential and commercial services.

The Fenster column includes:

- About Fenster
- Meet the Team
- Case Studies
- Commercial Projects
- Contact
- Instant Quote

## Continuous Background

This is the homepage-specific implementation of the site-wide continuous background rule in `STYLE.md`.

The homepage uses the shared moving page gradient below the hero:

`--fg-page-gradient`

Full-width section wrappers are transparent. Do not paint another copy of `--fg-page-gradient` on inner homepage flow wrappers or mobile carousel wrappers, because separately anchored gradients create visible section seams.

At `860px` and below, the homepage lowers the green/blue gradient alpha values, reduces the radial gradient sizes and increases the white wash so the compressed mobile layout stays subtle rather than visually intense. Keep the CSS variables and the JavaScript page-gradient motion profile aligned, because the JS writes the live root gradient values during scroll.

Contrast is contained inside:

- trust cards,
- image cards,
- product decision cards,
- forms,
- quote-tool preview,
- partner tiles,
- local-service links.

Do not restore stacked white/dark full-width bands without a clear functional reason.

## Responsive Rules

Important breakpoints:

- `1040px`: larger homepage grids collapse.
- `860px`: sticky product theatre changes to image cards and form rows collapse.
- `430px`: smaller typography and spacing refinements.

Mobile priorities:

- no sticky scroll traps,
- no horizontal overflow,
- full-width buttons where needed,
- full quote screenshot,
- readable product cards,
- no mid-word heading breaks,
- no generic blanket section padding,
- no negative margins on carousel dots,
- no controls visually stranded between sections.

## Mobile Section Spacing

Approved mobile visible joins:

- complete product carousel to instant-quote content: `24px`,
- instant-quote content to systems/backing logos: `16px`,
- systems/backing logos to contact content: `32px`,
- contact form to areas panel: `24px`,
- areas panel to footer content: `28px`.

Carousel rules:

- The product rail and picker dots share `.fg-home-product-theatre__mobile-carousel`.
- Dots sit in attached control trays.
- The section gap begins after the complete carousel component.

## Desktop Section Spacing

Approved desktop rhythm at `1440 x 900`:

- hero copy to trust cards: `72px`,
- trust cards to product theatre: viewport-responsive and judged by the balanced complete composition,
- quote grid to systems/backing logos: `48px`,
- systems/backing logos to contact grid: `64px`,
- contact grid to Areas We Cover heading: `72px`,
- local-area links to footer content: `72px`.

The sticky product theatre and instant-quote bridge retain their deliberate overlap.

## Product Theatre Layout Contract

Desktop theatre model:

- `.fg-home-product-theatre`
  - `height: calc(var(--fg-product-count) * 92svh)`
  - `min-height: 0`
- `.fg-home-product-theatre__stage`
  - sticky below the `72px` header,
  - `height: calc(100svh - 72px)`,
  - `min-height: 520px`
- `.fg-home-product-theatre__shell`
  - rows: `auto clamp(400px, 70vh, 650px) auto`,
  - `align-content: center`,
  - `1rem` top/bottom padding,
  - `1rem` row gap.

Required behaviour:

- image remains between `400px` and `650px` tall,
- image must not stretch vertically to fill a tall viewport,
- heading-to-image gap is `16px`,
- image-to-progress gap is `16px`,
- spare stage height is shared above and below,
- final state releases into quote section without a large empty runway.

Rejected fixes:

- Do not use `align-content: start` with capped rows.
- Do not use `minmax(400px, 1fr)` for the image row.
- Do not restore `min-height: 3500px`.
- Do not remove progress-line clearance just to shorten the section.
- Do not judge theatre only from the first state.

## Accessibility

- The changing sticky image is a real link.
- Its `href` and `aria-label` update with the active product.
- Keyboard focus on a right-hand card activates the matching product state.
- Reduced-motion users do not receive animated transitions.
- Mobile does not rely on hover or sticky interaction.

## Files To Edit

Homepage markup/content:

`wp-content\themes\fenster\template-parts\sections\home-experience.php`

Homepage route and hero-video path:

`wp-content\themes\fenster\template-parts\sections\generated-page.php`

Homepage CSS:

`wp-content\themes\fenster\src\scss\main.scss`

Homepage JS:

`wp-content\themes\fenster\src\js\main.js`

Footer:

`wp-content\themes\fenster\template-parts\layout\site-footer.php`

## Homepage Change Procedure

1. Run `npm.cmd run build`.
2. Lint changed PHP templates.
3. Reload local homepage.
4. Test `390 x 844`, `768 x 1024` and `1440 x 900`.
5. Check opening, middle/final state and section handoff for sticky/carousel sections.
6. Check desktop product-state switching.
7. Check mobile product and proof dots.
8. Check horizontal overflow and console errors.
9. Update this file only with final accepted homepage models.

## Do Not Undo

- Do not restore the hero showroom box.
- Do not restore the large quote screenshot over the hero.
- Do not restore Commercial Glazing as a homepage product theatre item.
- Do not restore the old Three.js/canvas homepage hero. Three.js is not an active dependency and the live homepage is `home-experience.php`, not the inactive generic `fg-home-hero-3d` branch.
- Do not restore visible product numbers.
- Do not reintroduce separate desktop/mobile navigation sources.
- Do not add homepage-only forms.
