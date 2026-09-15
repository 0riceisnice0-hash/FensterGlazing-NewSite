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
   should load on request and always have a visible direct-opening fallback.
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
| Quote | Preserve product selection and tracking hooks; click-to-load with direct fallback |
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

To be completed from the rendered candidate and final deployment evidence.
