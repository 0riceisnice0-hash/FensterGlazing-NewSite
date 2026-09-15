# Composite doors: full audit and rebuild

Started 15 September 2026, 08:38 UTC. Owner requested a full audit and rebuild
with a two-hour working window, after rejecting incremental layout fixes.
Baseline production theme: `c6853022a1bda96909362cbfb73bbc3462ccd174`.

## Measured baseline

Browser measurements of the public page, after the scroll-snap fix:

| Section | Desktop 1440 × 780 | Phone 390 × 844 |
| --- | ---: | ---: |
| Hero | 707px | 926px |
| Door range | 782px | 2,057px |
| Construction | 797px | 1,275px |
| Security / secondary CTA | 713px | 1,314px |
| Glass | 793px | 1,600px |
| Colour | 728px | 1,653px |
| Handles | 707px | 719px |
| FAQ | 707px | 1,893px |
| Quote | 714px | 665px |
| Reviews | 707px | 911px |
| Case studies | 797px | 1,747px |
| Quiz | 773px | 700px |
| Enquiry | 788px | 1,150px |
| Whole document | 10,360px | 18,228px |

The page contains 223 image elements. Image elements include line drawings,
hidden quiz choices and selector previews, so this is not a claim that 223
photographs are downloaded at first paint.

## Findings

1. **Forced screen height, rather than content-led spacing.** Every desktop
   section inherits a 707px minimum, including short utility blocks. Flex
   centring distributes the empty space around the content. This contradicts
   the purpose of the viewport budget: a ceiling became a floor.
2. **Nested spacing and shared selectors.** The finishes wrapper, step,
   component and container each influence spacing. The source contains multiple
   rounds of overrides, so local padding changes do not describe the result.
3. **Repeated reassurance.** The same slab, guarantee and installation facts
   appear in the hero, construction statistics, security panel and FAQs.
4. **A long catalogue dominates mobile.** Twenty tiles before expansion is too
   much for a two-column phone view. The catalogue needs compact pagination,
   useful filtering and an explicit link from each door to its quote.
5. **The content has stale naming.** Product data still describes Signature and
   Contemporary, while the actual quote catalogue has six named collections.
   Some security text uses a generic guarantee label instead of the confirmed
   break-in guarantee and its required terms.
6. **Proof is spread across several large sections.** Review strips, repeating
   statistics and three case cards obscure the strongest specific installation.
7. **The quote section can become a blank frame.** A third-party interface
   needs a loading state and a visible direct-opening fallback. It still
   loads automatically when visible, as required by the site's quote workflow.
8. **Legacy CSS must stop owning this route.** Replacing a template while
   retaining its old class names made the earlier release inherit incompatible
   rules. A dedicated page namespace and stylesheet remove that dependency.

The SEO audit dated 14 September records 51 clicks and 24,886 impressions for
this URL in the supplied export. Preserve its canonical route, product intent,
price-guide link and useful internal links. Do not interpret page totals as
brand-filtered query totals.

## Design decision

The visitor is choosing a front door and deciding how to get it priced.
An exterior entrance photograph leads the first viewport; the primary action
opens the composite quote route. The range shows real catalogue drawings,
finishes show real supplier artwork, and a separate installed-door photograph
provides local proof. No generated installation photography or colour tinting.

The new route has its own template, stylesheet and small interaction module.
It keeps the site's Gibson typography, steel/green palette, buttons, header,
footer and established enquiry backend. Section heights follow their content;
there is no document snapping or forced viewport minimum.

### Section inventory

| Existing content | Decision |
| --- | --- |
| Hero and installer proof | Rebuild as one legible exterior-led composition |
| Range and collection descriptions | Retain data; rebuild compact, keyboard-accessible browser |
| Construction | Replace overlapping CSS illustration with a clearly labelled cutaway |
| Security | Combine with construction; preserve confirmed hardware and terms |
| Glass, colour, handles | Rebuild as coordinated finish sections with fixed preview dimensions |
| Generic secondary CTA | Remove; actions belong beside choices and at the end |
| Reviews and case cards | Replace with specific local installation proof and verified customer feedback |
| FAQs | Rebuild native disclosures; visible copy and schema use the same source |
| Quote | Preserve product selection and tracking hooks; load when visible with direct fallback |
| Quiz | Retain its five questions and scoring, as an optional compact section near the bottom |
| Enquiry | Retain shared backend, honeypot, attribution and product context; rebuild layout |

## Validation plan

Inspect full composition at 1440 × 780, 1280 × 720, 768 × 1024, 390 × 844
and 360 × 800. Check section/content gaps, clipping, image crops, heading
hierarchy, legibility, keyboard focus, tabs, filters, pagination, colour/glass
choices, FAQ disclosures, quiz result and quote fallback. Check no-JavaScript
content, reduced motion, internal links, image HTTP responses, canonical and
FAQ schema parity. Test the committed release on protected test before live;
preserve unrelated SEO work and use checksummed, backed-up theme-only deployment.

## Results

The final release is `4f6afab5b6d5fbcb4f94ed04a6bf92713e4a9910`, tagged
`live-composite-replay-2026-09-15`. The first publication in this working
window was `dbd29ce9`; the styling pass `1966c57d` and delayed-stylesheet
correction supersede it. This was a new
composition, not a restoration of the previous template.

### Layout and scrolling

| Section | Final desktop 1440 × 780 |
| --- | ---: |
| Hero | 620px |
| Door range | 706px |
| Glass | 606px |
| Colour | 639px |
| Handles | 492px |
| Construction and security | 616px |
| Local installation and review | 559px |
| FAQs, closed | 463px |
| Quote | 625px |
| Enquiry | 646px |

Every primary desktop section fits the owner's 707px content budget. These
are content heights, not forced minimums. The optional finder is collapsed
initially; its first question is 594px on desktop and about 506px at 390px.

The default document is 6,686px on desktop instead of 10,360px (35.5% shorter),
and 10,595px at 390 × 844 instead of 18,228px (41.9% shorter). All 142 styles
remain in the server HTML. The catalogue shows ten at a time on desktop and
six on phones, with stable pagination and a glass filter.

| Tested width | Document height | Horizontal overflow |
| --- | ---: | --- |
| 1440px | 6686px | None |
| 1280px | 6670px | None |
| 1024px | 6820px | None |
| 768px | 8025px | None |
| 600px | 9734px | None |
| 390px | 10595px | None |
| 360px | 10969px | None |
| 320px | 11504px | None |

The final matrix was repeated on production with replay CSS present at every width.

Viewport checks assert the actual `window.innerWidth`; the in-app viewport
control applies to the newest tab, so earlier attempts that remained at 1440px
were discarded. Intentional horizontal handle browsing is confined to its rail.

The composite route skips Lenis initialization, uses native wheel/touch scrolling,
has no document or section snapping, and uses immediate native anchor navigation.
Other routes retain their existing scroll controller. The rebuilt JavaScript
contains no page scroll, wheel or touch-move listener. There are no pinned chapters.
Image dimensions and stable preview frames prevent the selectors moving the page.

The final public check exposed another cause of shifting layout: the site's
`fenster-clarity-replay-css` style element inserts the shared CSS after the
page stylesheet. Equal-specificity rules then changed the mobile handle rail
to four rows, adding about 500px. Shared components now carry the page root in
their selectors. This was checked with a local harness deliberately loading
shared CSS last, then published as a two-file correction. Do not remove this
specificity protection or judge the layout only before replay CSS has loaded.

The final design sweep removed numbered section labels and large dark content
bands, following `STYLE.md`. Construction, enquiry and the finder use light
backgrounds. The desktop hero retains a photographic scrim; the phone hero
uses a light text area. Form fields, hints and the consent block were checked
after changing the background; the shared consent's important white text rule
is overridden only inside this form. Main button text is white on `#26814e`,
a 4.85:1 contrast ratio. This is not a claim of a complete WCAG conformance audit.

### Product content, imagery and SEO

- Six real collections and 142 unique styles replace stale range descriptions.
- The page distinguishes photographed doors, manufacturer images and paint
  samples. No synthetic tinting or invented installation photograph is used.
- Six glass previews, five additional decorative patterns, 27 colour choices
  and eight handle finishes remain available. Preview captions explain what
  is shown; glazing availability still depends on the chosen doorset.
- Construction and security use the confirmed 44.5mm slab, APECS 3-star cylinder,
  ILH Duplex lock and conditional break-in compensation of up to £5,000.
- A real Milton Keynes installation and an attributed review replace repetitive
  reassurance strips. The case publication date is not presented as a fitting date.
- The canonical route and Milton Keynes title are preserved. The description
  now reflects the actual range, local fitting, installation proof and quote route.
- Six visible, server-rendered FAQs use exactly the same answer data as the
  single FAQPage schema. The fitted-price answer keeps the checked £2,000
  including-VAT example and explains specification/survey dependency.
- Relevant links include the price guide, installation case study, service areas,
  handle choices, consultation and the published `/why-distinction/` evidence page.

SEO improvements are content and technical changes. No ranking uplift can be
measured at publication; retain the non-brand GSC methodology from the September
14 audit when comparing subsequent performance.

### Validation evidence

- `scripts/check-composite-page.py`: **155/155** checks on the final protected-test
  HTML. One descriptive H1, no duplicate IDs, complete description, production
  canonical, six matching FAQs, 142 unique product/style quote links, all image
  references on disk, no repeated raster bytes in page content, one shared form.
- **222/222** linked assets and internal URLs returned HTTP 200 on protected test,
  including the linked handle anchor. The final pass adds no new image/link URLs.
- All **30 collection × glass filter states** were exercised, including empty
  combinations and reset. Pagination traversed all 142 styles without omissions
  or duplicates. Arrow-key tab switching moved selection and focus together.
- All six glass and 27 colour previews loaded with the matching name, image and
  caption. Their frames kept stable dimensions.
- Native FAQ disclosures work by mouse and keyboard and keep one answer open.
- Four complete finder paths covering glass levels 0–3 produced matching doors;
  chosen colour 129, product 4 and composite-interface URLs were preserved.
  Back, restart and shared result URLs were checked. Keyboard focus moves to
  the next question or result. This page's finder opens the designer directly
  and does not add a second iframe.
- The shared form retains its required fields, UK validation patterns, file
  upload, consent, nonce, honeypot and attribution hooks. No enquiry, email or
  vendor lead was submitted during testing.
- Changed PHP files pass syntax validation. The main JS build was reproduced
  against the live baseline; the baseline bundle matched exactly before the
  scoped native-scroll and quiz changes were built.
- The combined SEO branch on protected test passes WordPress checks for all
  **573 area pages and seven price guides**, with no reported errors.

Public browser FAQ text is also subject to the existing typographic script,
which changes some hyphens to non-breaking hyphens. That explains a literal
post-JavaScript string comparison difference; the server HTML/schema answers
match exactly and their wording is unchanged.

### Quote provider limitation

The direct WindowCAD retail URL opened a usable door/size interface in the
browser. Its cross-origin iframe remained blank in this in-app browser even
in a bare HTML harness with no site code. A local iframe in the same harness
loaded normally. Therefore this audit does **not** establish that the vendor
embed works in this particular browser, or blame the rebuilt layout for that
external embedding failure.

The page autoloads the desktop frame when visible, shows a loading state,
always exposes a direct link and shows a larger fallback action after 12 seconds
without a load event. Both the timeout state and successful load handling were
verified; successful handling used a local iframe test double. Phones have one
same-tab designer action. The known vendor `interface=composite` attribution
limitation recorded in August remains; no claim is made that it was repaired.

### Release and preservation

The initial 17-file theme release was guarded against exact live `c6853022`,
then the four-file styling pass was guarded against exact `dbd29ce9`, and the
two-file delayed-stylesheet correction against exact `1966c57d`.
All full-theme checksum residuals were zero. No files were deleted and no
database, upload, plugin, config or account setting was changed. WordPress
cache flush and SiteGround socket purge succeeded for every live publication.

Durable server backups:

- `~/fenster-pre-composite-rebuild-20260915.tar.gz`: original affected files,
  new-file manifest and guard evidence for the complete rebuild.
- `~/fenster-pre-composite-final-20260915.tar.gz`: four files before the final
  styling pass. Restore this only to inspect that intermediate release, not as
  the preferred design.
- `~/fenster-pre-composite-replay-20260915.tar.gz`: the two CSS files before
  the delayed-stylesheet correction.

Server evidence is under `/tmp/fenster-composite-rebuild-20260915/` and
`/tmp/fenster-composite-final-20260915/`, with final correction evidence in
`/tmp/fenster-composite-replay-20260915/`. The final theme also exists in the
isolated Git release tag, so recovery does not depend on temporary directories.

The rebuild is backported into `codex/seo-landing-pages-2026-09`. Protected test
now matches combined theme revision `30d7731826b9eaf7317f75fc35b2de947fcd0d48`
with full-tree residual zero. Its backup/evidence is under
`/tmp/fenster-composite-seo-20260915/`. The server repository checkout was not
reset; deployments used committed archives. Do not deploy the SEO branch
wholesale to production as part of a composite-page follow-up.

### Follow-up: product evidence and Why Distinction route

The owner's follow-up review found that the new composition had removed too
much useful manufacturer evidence and omitted the intended handoff to
`/why-distinction/`. The correction makes the H1 product-led, restores the
green/dark CTA pair, adds three concrete hero facts and introduces a light,
image-led `Product information` section. The new section distinguishes the
Distinction slab from the complete doorset and covers layered construction,
BS 6375-1 weather testing, 26 dB OITC / 29 dB STC acoustic results, the scoped
25-year manufacturer slab warranty and Distinction's published installation
figures. Its image is not repeated elsewhere on the page.

The production route had deliberately remained unregistered in the release
line and returned 404 when the new link was first checked. The final focused
release registers it, gives it a canonical/title/description and adds it to
the page sitemap. Public HTTP verification now returns 200 and the sitemap
contains `https://fensterglazing.com/why-distinction/`.

The final public page passes **158/158** composite checks. At 1440×780 the new
product-information section is 618px high and every top-level composite section
remains at or below the 707px desktop budget. Browser checks at 390px and 320px
show no page-level horizontal overflow. Live theme revision is
`49bbb55a661ac66dca77fc8d8c564cb67b6a1386`; combined protected-test revision is
`a1d357f8afd4578390cae42eedfb69527066438e`. Additional rollback archives are
`~/fenster-pre-composite-depth-20260915.tar.gz` and
`~/fenster-pre-why-distinction-20260915.tar.gz`.
