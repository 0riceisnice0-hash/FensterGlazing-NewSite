# Sliding Sash Page Redesign

## Purpose

This document records how the sliding sash window page was turned from a long, repetitive product brochure into a visual, responsive buying journey.

The finished page is not the result of one decorative CSS pass. The improvement came from treating content, imagery, interaction, technical information, responsiveness and customer intent as one design problem.

The page is available at:

- Live route: `/sliding-sash-windows/`
- Theme template: `wp-content/themes/fenster/template-parts/sections/generated-page.php`
- Main styling: `wp-content/themes/fenster/src/scss/main.scss`
- Interactions: `wp-content/themes/fenster/src/js/main.js`

## The original problems

The first audit identified several connected problems:

- The mobile page was a wall of text.
- The page repeated similar benefits, specifications and calls to action.
- All three sash products were presented with too little visual emphasis.
- The original mobile carousel was taller than the viewport and felt like another long section.
- Technical comparison information was difficult to scan on a phone.
- There were not enough installation photographs to help a customer imagine the product in a home.
- The handles section behaved like a catalogue dump rather than a useful choice.
- Desktop and mobile felt like separate designs rather than the same journey adapted to different screens.
- The route to pricing or consultation was too easy to lose within the page.

These were customer-journey problems before they were styling problems.

## The central design decision

The page was rebuilt around the order in which a customer naturally makes a decision:

1. Understand the product category.
2. Compare the three Roseview models visually.
3. See the meaningful technical differences.
4. Look at real installations.
5. Move towards a quote or consultation.
6. Choose colours, glass and furniture.
7. Resolve common buying questions.
8. See relevant social proof.
9. Send the project details.

Every section had to earn its position in that sequence. Information that repeated an earlier section without helping the next decision was removed.

## 1. Starting with mobile

Mobile was treated as the content-editing tool, not merely the smallest breakpoint.

A phone quickly exposes unnecessary copy because every paragraph adds physical page length. The mobile version was therefore designed first around one decision per screen area.

The three Roseview products became a single-card carousel on mobile. Each card contains:

- A large product render.
- A meeting-rail close-up.
- A short positioning label.
- The model name.
- One practical “best for” statement.

The card width is constrained to the viewport and the carousel controls remain attached to the product context. A customer can compare models without scrolling through three complete product blocks.

Desktop uses the same cards and information, but presents all three together in a balanced grid. This preserves one content model while using the available desktop width.

## 2. Making the products visually legible

The product images were enlarged because windows are bought visually. The imagery needed to communicate proportion, sightlines and period character before the customer read a table.

Responsive WebP variants were created for each model so the larger visual treatment did not require serving oversized source files to phones.

Each model also received a meeting-rail inset:

- Ultimate Rose: 35 mm.
- Heritage Rose: 44.5 mm.
- Charisma Rose: 60 mm.

This turns an abstract specification into a visible product difference. It also makes the model cards useful even before the customer reaches the full comparison.

## 3. Editing the comparison rather than shrinking it

The comparison table was audited row by row. Repeated or weak rows were removed, and the remaining values were checked for consistency.

The core comparison now focuses on information that genuinely distinguishes the models:

- Meeting rail.
- Corner detail.
- Profile detail.
- Bottom rail.
- Horn options.
- Glass unit.
- Best U-value option.
- Furniture compatibility.

Desktop retains a conventional comparison table because four columns are readable at that width.

Mobile converts the selected model into a compact specification list below the carousel. This avoids forcing a wide table into a narrow screen or making customers horizontally pan through technical data.

The principle is important: responsive design does not mean making a desktop table smaller. It means choosing the best information structure for each screen.

## 4. Building an image-led gallery

The Roseview source material was visually reviewed rather than copied blindly into the page.

Images were approved based on whether they added a distinct buying context:

- Exterior period character.
- Interior light and room context.
- A full-property replacement.
- A bay window.
- A large elevation.
- A special-shaped installation.

Near-duplicates were rejected. The gallery was built to show range, not simply image count.

The desktop gallery uses an editorial mosaic with one large anchor image and supporting images. Mobile turns the same set into a swipeable image rail. Captions describe what the customer should notice rather than using vague lifestyle language.

Responsive 480, 800 and 1400 pixel WebP versions were generated where appropriate. The markup uses `srcset` and `sizes` so the browser selects a suitable file for the rendered position.

## 5. Connecting inspiration to action

A quote and consultation prompt was placed immediately after the installation gallery.

This is deliberate. The gallery is the point at which visual interest is highest, so the next action should be available before the page returns to detailed specification choices.

The call to action offers two routes:

- Start a sash window quote.
- Book a design consultation.

Mobile uses one direct pricing action instead of loading the large desktop quote interface inside the page. Desktop keeps the embedded pricing experience because it has enough space to be useful.

## 6. Turning the furniture guide into a selector

The supplied Rose Collection furniture colour guide was rendered and visually inspected. The lock photographs were then cropped into individual product assets.

The guide established two furniture families:

- Globe furniture for Ultimate Rose.
- Acorn furniture for Ultimate, Heritage and Charisma Rose.

It also established the available finishes and the newer Graphite and Pewter options.

Thirteen individual WebP assets were produced. Together they are approximately 69 KB, allowing the full set to load eagerly without a meaningful performance penalty.

The new selector separates two decisions:

1. Choose Globe or Acorn furniture.
2. Choose the finish.

Compatibility is shown directly on the style controls. Selecting a finish changes the large lock image and updates the pressed state of the controls.

The visual stage has a fixed responsive height:

- 500 px on desktop.
- 300 px on tablet.
- 260 px on small mobile screens.

Images use `object-fit: contain` and a maximum height of 100%. The box therefore remains stable when changing between images with slightly different aspect ratios. Because the full 69 KB set is loaded up front, the stage does not temporarily become empty while waiting for the newly selected image.

The original PDF download was initially included as a supporting resource, then removed from the customer-facing interface once the useful choices had been incorporated directly into the page.

## 7. Removing repetition

The page previously inherited generic sections that repeated information already covered by the sash-specific journey.

For this page, redundant detail runs, generic benefits, generic buying-process content and repeated related-link sections were removed at template level. They were not merely hidden visually.

This reduced both page length and DOM weight while making every remaining section more relevant.

The page also received sash-specific FAQs covering questions that affect a purchase:

- Choosing between the Roseview models.
- Planning permission.
- Conservation areas.
- Tilt-in operation.
- Price factors.
- Security options.

## 8. Using relevant proof

The review rail was adjusted to prioritise a review that specifically mentions sash window installation.

Contextual proof is stronger than a random positive review. The customer has just spent time evaluating sash windows, so the first review should confirm that Fenster has successfully fitted that product for another customer.

## 9. Improving the final enquiry route

The enquiry form is pre-scoped to sliding sash windows. It does not ask the customer to identify the product category again.

Mobile uses the compact form presentation so the final action remains manageable after a long consideration journey. The customer can still provide contact details, postcode, project information and files without navigating to an unrelated generic page.

## 10. Footer improvements

The mobile accreditation and review marks were normalised into a two-column, three-row trust grid.

Each item receives the same minimum card height and a consistent white background. This removes the uneven spacing caused by mixing several differently proportioned logos in a loose flexible row.

Instagram, Facebook and LinkedIn links were added directly beneath the trust grid. Each link includes an icon, a readable label and an accessible name.

## Responsive rules used

The redesign follows a small number of repeatable rules:

- Mobile shows one primary item at a time when comparison cards would otherwise create excessive length.
- Desktop uses grids where simultaneous comparison is valuable.
- Wide technical tables become selected-item summaries on mobile.
- Image stages have explicit dimensions when changing media could cause layout shift.
- Horizontal rails are reserved for short, understandable choice sets.
- Important calls to action appear after moments of high intent, not only at the top and bottom.
- Repeated content is removed from the template rather than hidden with CSS.
- Responsive source images are generated whenever imagery is enlarged.

## Technical implementation

The work is concentrated in the existing theme rather than a separate page builder implementation.

### PHP

`template-parts/sections/generated-page.php` contains the sash-specific data and markup for:

- Model cards.
- Meeting-rail details.
- Desktop comparison data.
- Mobile selected-model specifications.
- Installation gallery.
- Gallery call to action.
- Furniture selector.
- Sash-specific conditional section removal.

### JavaScript

`src/js/main.js` controls:

- Mobile model carousel state.
- Furniture family selection.
- Furniture finish selection.
- Image visibility.
- Accessible `aria-pressed` states.

The interactions enhance normal HTML controls rather than replacing them with canvas or inaccessible custom widgets.

### SCSS

`src/scss/main.scss` controls:

- Desktop model grid and mobile carousel geometry.
- Rail-detail insets.
- Comparison presentation.
- Gallery mosaic and mobile image rail.
- CTA layout.
- Furniture visual stage and controls.
- Mobile footer trust grid and social links.

The compiled assets are:

- `assets/css/main.css`
- `assets/js/main.js`

## Quality assurance process

The final implementation was built and deployed to the protected test site before sign-off.

It was checked at:

- 390 × 844 mobile.
- 768 × 1024 tablet.
- 1440 × 900 desktop.

The checks included:

- Horizontal overflow.
- Carousel sizing.
- Product-image prominence.
- Comparison readability.
- Gallery composition.
- Furniture style changes.
- Every furniture finish state.
- Fixed furniture-stage dimensions.
- Quote behaviour at each breakpoint.
- Relevant first review.
- Footer trust-grid alignment.
- Exact social URLs.
- Responsive image delivery.
- Browser warnings and errors.

Visual inspection was used alongside DOM and geometry checks. A page can technically avoid overflow and still feel cramped, unbalanced or difficult to use, so both forms of QA are necessary.

## Reusable method for other product pages

This process can be repeated elsewhere on the site:

1. Audit the page as one journey, not a list of sections.
2. Identify the actual decisions a customer needs to make.
3. Order the page around those decisions.
4. Remove inherited sections that repeat an earlier answer.
5. Select images by the distinct context they communicate.
6. Make product differences visible before presenting detailed tables.
7. Use mobile to expose excessive copy and weak hierarchy.
8. Adapt information structures by breakpoint instead of only resizing them.
9. Place actions immediately after high-intent content.
10. Use product-specific proof and FAQs.
11. Prevent layout shift in any interactive media stage.
12. Test real interactions and viewport geometry on the protected site.

## Result

The page now behaves like a guided product consultation:

- It shows before it explains.
- It compares before it overwhelms.
- It uses technical information where it helps a choice.
- It places conversion routes at natural decision points.
- It gives mobile and desktop the same journey in layouts suited to each screen.

That combination—not any single carousel, gallery or CSS treatment—is what produced the upgrade.
