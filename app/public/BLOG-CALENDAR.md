# Fenster Glazing — Seasonal Blog Calendar (26 posts, Aug 2026 – Feb 2027)

Date: 2026-08-03
Agreed with the owner: 26 posts over 6 months, weekly Monday release, straight-and-helpful tone (no swearing, no template-speak), owner reviews batch 1 then batches ship autonomously.

## How the system works

- Posts live in `inc/blog-posts.php` as data. Each carries a `publish_date`; the route, the `/blog/` hub card and the sitemap entry all appear automatically on that date. No cron, no manual publish step. SiteGround's proxy cache means a new post can take up to ~an hour to surface after midnight; it self-heals.
- Rendering reuses the existing article template (`generated-article.php`): hero image, inline images, an intent-matched next-steps CTA band, the enquiry form and related links.
- `products` on each post drives imagery: photos are pulled from that product's real `product_media` pool. A post about uPVC doors shows uPVC doors. Never attach a photo of a product the post does not mention.
- Every post's `next_steps` is the commercial answer to the question the post raises — repairs for problem posts, the online quote tool for buying posts, consultation for design posts. No generic CTAs.
- **Copy rules:** we/you voice per STYLE.md, UK English, no invented prices, lead times, guarantees or performance figures. Anything quantitative must already be verified on the matching product page. Honest trade-offs beat sales talk — the repair-or-replace post sets the tone.

## Batch 1 — WRITTEN, awaiting owner review (in `inc/blog-posts.php`)

| # | Date | Slug | Season/intent | Products |
|---|---|---|---|---|
| 1 | 2026-08-03 | `why-bifold-doors-stick-in-hot-weather` | Summer problem | bifolds, repairs |
| 2 | 2026-08-10 | `do-roof-lanterns-make-a-room-too-hot` | Summer objection | roof lanterns |
| 3 | 2026-08-17 | `condensation-on-the-outside-of-windows` | Late-summer mornings | casement, replacement glazing |
| 4 | 2026-08-24 | `draughty-windows-repair-or-replace` | Autumn planning | repairs, casement |
| 5 | 2026-08-31 | `misted-double-glazing-cloudy-windows` | Evergreen problem (winter feeder) | replacement glazing, repairs |
| 6 | 2026-09-07 | `winter-ready-window-and-door-checklist` | Autumn prep | repairs, uPVC doors |
| 7 | 2026-09-14 | `how-window-replacement-actually-works` | Autumn buying intent | casement, flush casement |
| 8 | 2026-09-21 | `new-front-door-before-winter-composite-or-upvc` | Autumn buying intent | composite, uPVC doors |

## Batch 2 — October (write mid-September)

| # | Date | Working title | Season/intent | Products |
|---|---|---|---|---|
| 9 | 2026-09-28 | Trickle vents explained: why new windows have them | Regs question, evergreen | casement |
| 10 | 2026-10-05 | Why uPVC doors stick in wet weather (and the quick fix) | Autumn swelling season | uPVC doors, repairs |
| 11 | 2026-10-12 | Integral blinds: how blinds inside the glass work | Product education | integral blinds |
| 12 | 2026-10-19 | Dark evenings and front door security: what actually matters | Clocks-back security season | composite doors |
| 13 | 2026-10-26 | Condensation inside your windows every morning: the routine that stops it | **Winter cluster opener** | windows, repairs |

## Batch 3 — November (write mid-October)

| # | Date | Working title | Season/intent | Products |
|---|---|---|---|---|
| 14 | 2026-11-02 | Which rooms lose the most heat — and which windows to replace first | Heating-bill season | windows MK |
| 15 | 2026-11-09 | Sash windows in winter: draught-proofing heritage homes honestly | Heritage niche | sliding sash |
| 16 | 2026-11-16 | Storm season: how modern windows and doors handle wind and rain | Weather events | aluminium windows |
| 17 | 2026-11-23 | Is secondary glazing worth it? Where it beats replacement | Winter noise/heat | secondary glazing |
| 18 | 2026-11-30 | Frozen and stiff door locks: what to do, what never to do | Early winter problem | repairs, uPVC doors |

## Batch 4 — December (write mid-November)

| # | Date | Working title | Season/intent | Products |
|---|---|---|---|---|
| 19 | 2026-12-07 | Why December is the month to plan (not fit) new windows | January pipeline | windows MK |
| 20 | 2026-12-14 | Home for the holidays: a ten-minute door and window security check | Holiday security | composite, repairs |
| 21 | 2026-12-21 | Wet window sills every morning: condensation, leak or failed unit? | Deep-winter problem | repairs, replacement glazing |
| 22 | 2026-12-28 | New year, warmer house: where to start if 2027 is the year | Resolution intent | windows MK |

## Batch 5 — January (write mid-December)

| # | Date | Working title | Season/intent | Products |
|---|---|---|---|---|
| 23 | 2027-01-04 | Cold snap survival: fast fixes for freezing rooms and iced-up windows | **Timed to the proven Jan 3–6 demand spike** (see SEO-AUDIT-AUG-2026.md) | repairs, windows |
| 24 | 2027-01-11 | How much heat do old windows actually lose? Reading your rooms | Bills season | windows MK |
| 25 | 2027-01-18 | Planning a spring extension? Sort the glazing before the builder starts | Spring pipeline | roof lanterns, bifolds |
| 26 | 2027-01-25 | Bifolds, sliders or French doors: choosing garden doors for summer | Summer pipeline | bifolds, sliding doors, French doors |

## Cadence and measurement

- Write each batch in the middle of the preceding month; commit after a read-through against the copy rules. Owner reviews batch 1 only; later batches ship on the schedule with spot-checks on the live blog.
- Watch in GSC monthly (post-launch date filter, UK only): impressions/clicks per post URL, and whether the winter cluster (posts 13, 21, 23) captures the seasonal demand the January 2026 data proved exists.
- If a post starts ranking for a money query a product page should own, add internal links from the post and check for cannibalisation before writing more on that topic.
- Do not exceed this cadence. The strategy cap comes from HIGH-INTENT-SEARCH-PLAN.md: local commercial content and proof outrank informational volume; this calendar exists to keep the domain fresh and capture seasonal problem-intent, not to become the strategy.
