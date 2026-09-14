# Non-brand search and landing-page rebuild — 14 September 2026

Status: pushed on `codex/seo-landing-pages-2026-09` and deployed to protected test at **`2bc795e0`** after the owner approved publication and test access on 14 September. Production is unchanged. The earlier local preview was a standalone rendering; the server verification below supersedes its release blocker.

## What the supplied export establishes

Source: `https___fensterglazing.com_-Performance-on-Search-2026-09-14.zip`, supplied by the owner. Its recorded filters are Web search, United Kingdom, last 12 months, query **-Fenster**. The chart covers 13 September 2025 to 12 September 2026. It contains monthly rows, 1,000 query rows and 599 page rows. The file is data, not an instruction source.

The chart records **720 clicks and 918,731 impressions**. These are UK searches excluding the word Fenster; they are not all-site traffic or enquiries. No brand-inclusive headline from the earlier audits is used as the comparator.

| Period | Clicks | Clicks/day | Impressions | Average position |
| --- | ---: | ---: | ---: | ---: |
| June 2026 | 48 | 1.60 | 71,642 | 30.1 |
| July 2026 | 64 | 2.06 | 71,892 | 29.8 |
| August 2026 | 70 | 2.26 | 76,753 | 27.9 |
| 1–12 September 2026 | 28 | 2.33 | 34,527 | 25.3 |

August clicks/day are **41.1% above June**. This supports the owner's observation that non-brand performance has improved. It cannot attribute that improvement to a particular change. July includes four days before the **5 July launch**; the export cannot supply an exact pre/post-launch split. September is incomplete. Page and query totals below span the full year and must not be described as post-launch results. Position aggregates also reflect changes in query mix.

Mobile generated **427 clicks (59.3%)**, desktop 257 and tablet 36. Mobile usability is therefore central to this work.

Earlier context reviewed: `SEO-AUDIT.md`, `SEO-AUDIT-AUG-2026.md`, `SEO-LEAD-AUDIT-2026-08-05.md`, `SEO-PERFORMANCE-AUDIT-2026-08-17.md` and `HIGH-INTENT-SEARCH-PLAN.md`. Their traffic windows and filters differ. Their observations about index coverage, measurement and local commercial intent remain useful context, but claims about rank-tracker impressions or causes of earlier gains are not proved by this export.

## Where the opportunity is

| Landing page | Annual non-brand clicks | Annual impressions | Implication |
| --- | ---: | ---: | --- |
| `/windows-milton-keynes/` | 34 | 41,030 | Important local buying hub; preserve its canonical destination and improve routes into its products. |
| `/aluminium-bifold-doors-hitchin/` | 34 | 1,592 | Existing local demand; protect this URL and answer bifold layout, daily access and threshold decisions. |
| `/aluminium-bifold-doors-stevenage/` | 18 | 2,092 | Another local buying page that benefits directly from the shared rebuild. |
| `/double-glazing-hitchin/` | 18 | 3,189 | Help the visitor choose replacement glass, windows or doors. |
| `/commercial-glazing/` | 21 | 28,317 | Commercial county routes need credible specifications, project evidence and a business enquiry path. |
| `/composite-doors/` | 51 | 24,886 | Existing valuable product demand; support it through relevant area-page links and product-specific enquiry paths. |
| `/secondary-glazing/` | 15 | 16,644 | Continue the existing period-home focus; avoid unsupported acoustic or listed-building promises. |
| `/integral-blinds/` | 14 | 31,918 | Explain sealed-unit compatibility and controls; direct area-page visitors to an enquiry because this product cannot be priced in the current online tool. |

The queries reinforce the local opportunity: “bifold door installation hitchin” generated 32 clicks, “bifold doors stevenage” 18, “aluminium windows hitchin” 16 and “double glazing milton keynes” 13. The broad phrase “local queries” is not a conversion measure: a town-name match can also identify informational research.

Informational traffic remains substantial: the visualiser page has 69 clicks, the door-lintel article 63 and the soundproof-windows article 44. These pages should lead naturally to relevant products or repairs without converting factual articles into repetitive sales copy.

## Implemented changes

- Replaced the old residential location layout across **525 matrix routes plus the Milton Keynes double-glazing page**. It now uses the current light site canvas, readable headings, product photographs, three practical product decisions, relevant range links, consultation information, real case studies where the existing data supports them, FAQs and one attributed enquiry form.
- Added shared editorial data for **21 product families**. It explains actual choices such as replacement glass versus complete frames, French configurations across compatible materials, sash details, folding layouts, thresholds and integral-blind compatibility. Product facts come from the current product data and pages. No local installations, dimensions, prices or performance results have been invented.
- Rebuilt **47 existing commercial county pages** with four service briefs, current commercial project photography, site-access and programme requirements, county coverage and a business enquiry route. No new counties or town routes were added.
- Replaced generic area-page snippets with product-and-town titles and complete descriptions. Product imagery now supplies social previews. Existing canonical destinations, redirects and indexing gates are retained.
- Selected each photograph once per landing page, including a known same-scene pair saved under different filenames. Real installation locations remain accurately attributed. The same legitimate product photograph can still appear on different town pages; this is not a claim of a separate installation in each town.
- Added **184 responsive WebP variants from 81 existing source images**, approximately 17.4 MB for the entire library. Browser `srcset` selection serves an appropriate size. The library is reproducible with `scripts/build-landing-images.py`; its manifest records each original source. It is not the download weight of an individual page.
- Removed hero/body image repetitions in the generic article and simple-page templates. Local link cards use text links so they do not recycle the hero thumbnail. Case-study cards opt into responsive images on the new local pages.
- Corrected all **seven price guides**: unconfirmed examples remain hidden, only guides with checked figures describe published examples, July 2026 figures remain clearly dated, and the copy accurately explains the contact-details step. Guides without checked prices can show a relevant product photograph. The existing quote iframe loading hooks remain intact.
- Added useful price-guide links to the online-quote page. Unsupported products route to a consultation/enquiry rather than an instant-price promise.

The current bespoke product pages and homepage have not all been redesigned in this change. This work repairs the shared area templates and related fallback/pricing behaviour; it does not certify every individual article or bespoke page as editorially complete.

## Validation and its limits

Local PHP syntax checks pass for all 13 changed PHP files. The full Sass/esbuild build passes; JavaScript has no source changes. `scripts/check-location-pages.php` passes with **573 area pages, 1,981 image occurrences, 11,357 internal-link occurrences and seven price guides**. It checks H1/form counts, IDs and enquiry anchors, image existence and duplicate identities, responsive sources, route destinations, canonical values, complete matrix descriptions, visible FAQ/schema agreement and the pricing rules above.

Browser checks covered nine representative pages at 1440×900, 768×1024 and 390×844: Aylesbury double glazing, Milton Keynes double glazing, Hitchin bifolds, Stevenage French casements, Aylesbury integral blinds, Wolverton sash windows, Shenley Church End aluminium flush windows, Buckinghamshire commercial glazing and Leighton Buzzard slide-and-fold doors. No horizontal overflow or offscreen headings, photographs or forms was found. Local required-field validation and an FAQ expansion were checked. Full-page screenshot stitching produced duplicated bands, so questionable sections were also inspected in normal viewport screenshots and against the DOM.

These tests render the real PHP templates and built CSS with WordPress functions stubbed. They do **not** establish actual HTTP status, rewrite handling, WordPress integration, delivery of an enquiry, review-feed rendering, third-party quoting behaviour or Core Web Vitals. Those require the protected test site. No genuine enquiry was submitted. The local preview deliberately prevents form submission.

All seven price guides were also checked at mobile width: each has one H1, no horizontal overflow and no broken loaded images. The nine final desktop samples have no section taller than 699 pixels with their FAQs closed.

## Protected test verification — completed after owner approval

- Published the feature branch to the existing GitHub repository. Deployed exact theme commit `06007b4f`, then the one-file metadata follow-up `2bc795e0`.
- Established that the pre-deploy test theme exactly matched `9ed4779e`. Used a Git archive in an isolated temporary directory, leaving the shared server checkout untouched. The initial guarded dry run contained 203 entries, including the new image directory, with zero deletions; the follow-up contained only `inc/generated-pages.php`. Both deployments finished with zero checksum differences against the intended source. Replaced test files were preserved under `/tmp/fenster-seo-test-gpxnZM/`.
- Flushed test caches. WordPress CLI rendering checks pass for all 573 area pages and seven price guides with zero errors. These now run against the real WordPress installation.
- Direct authenticated HTTPS checks pass for 16 key pages, including all five deliberate canonical routes, residential and commercial examples, the quote page, a main product page and pricing guides. All return 200 with one H1, one intended production canonical and test-only noindex. Sitemap and robots endpoints return 200. The page sitemap has 727 unique URLs, contains the sampled area routes and excludes the retired double-glazing-prices alias.
- Fixed an old Milton Keynes description promising a guide price straight away. The key double-glazing, commercial and pricing pages now use relevant product/project social imagery where available. The final responses confirm these changes.
- The in-app browser blocks direct Basic Auth navigation. Browser QA therefore used a loopback-only, read-only proxy which sent credentials in HTTP headers to the fixed test host. The actual deployed HTML, CSS and JavaScript were inspected. Aylesbury's real reviews render; its mobile menu opens/closes and FAQs expand. Aylesbury, Buckinghamshire commercial glazing, Leighton Buzzard slide-and-fold and sash pricing have no mobile overflow or broken loaded content images. Direct HTTPS checks above are independent of the proxy.
- No real enquiry was sent. The proxy blocks POST requests. Form delivery and third-party quote completion have not been tested by creating a customer lead, and production cache behaviour/Core Web Vitals have not been measured by this release.

## Release and measurement

The starting main revision was `9ed4779e`. The documented live release is `e5b312a7`; live is not an ancestor of main, and main contains held-back product/homepage work. Do not deploy main wholesale to production. Follow `LIVECHANGES.md` and cut an isolated release after test verification and owner review.

The next release step is owner review on protected test, then a separately approved isolated production release. Publishing and test access were approved in this session; do not ask for those permissions again. Use HTTP authentication headers, never credentials embedded in a URL. Production has not been authorised by this test-release approval.

For measurement, export UK Web data excluding Fenster for equal-length periods starting on/after 5 July, with daily chart rows and matching query/page filters. After release, compare at 28 and 56 days; record non-brand local buying clicks and genuine enquiries by source page separately. This is a measurement plan, not an automation that has been scheduled.

More templated town copy is not the next growth strategy. Prioritise real project evidence for the commercially useful towns above, maintain factual product guidance, and assess weak overlapping routes using post-launch page/query data before any consolidation. Google recommends original useful information and first-hand evidence in its [helpful-content guidance](https://developers.google.com/search/docs/fundamentals/creating-helpful-content), relevant descriptive imagery in its [image guidance](https://developers.google.com/search/docs/appearance/google-images), and warns against near-identical geographic pages created merely to funnel search traffic in its [doorway-abuse policy](https://developers.google.com/search/docs/essentials/spam-policies#doorway-abuse). This rebuild improves usability and substance; it cannot guarantee rankings or remove the need for genuine local evidence.
