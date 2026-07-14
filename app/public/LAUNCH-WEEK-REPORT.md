# Fenster Glazing — Launch Week Report

Prepared: 2026-07-14 · Covers: launch (6 July) through 13 July · 154 commits deployed
Audience: management summary. Technical detail lives in `AUDIT.md`, `SEO-AUDIT.md`, `COPY-AUDIT.md`, `PROGRESS.md`.

---

## The Short Version

The new fensterglazing.com launched on 6 July and has had an exceptionally active first week: **154 tracked changes**, three same-day incident fixes, and a full measurement system built from scratch. As of today's full crawl, **all 681 pages are healthy with zero technical SEO defects** — no duplicate titles, no broken links, no canonical errors, full schema coverage. Search traffic is slightly **up** on pre-launch (15.7 clicks/day vs 14.2), which for a full-site migration is the best realistic outcome — migrations usually dip. Early rankings on money terms are moving in the right direction, several dramatically.

---

## 1. What Changed This Week (all 154 commits, grouped)

### Launch & infrastructure (~15 commits)
- Theme deployed to SiteGround (Bedrock) test + live, with a documented GitHub → test → verify → backup → live workflow and an emergency-fix rule (`LIVECHANGES.md`).
- Old-site URL inventory fully preserved: every historical URL returns the page, a deliberate redirect, or a deliberate 410.
- Legacy database redirects that hijacked `/terms-conditions/` and a town page were removed; www→apex redirect added; the test site was password-protected and de-indexed after appearing in Google.

### SEO foundation (~35 commits)
- Theme-owned SEO everywhere: unique titles/descriptions across all 681 pages, LocalBusiness schema (with geo coordinates and Google Business Profile links), breadcrumbs sitewide, FAQ schema on product pages, clean XML sitemap, robots.txt fixes.
- Suppressed the old Yoast/Rank Math head output that was double-printing stale metadata.
- Local money-page targeting: every product page titled for Milton Keynes; "roof lights" synonym added after search data showed we ranked for it without using the phrase; meta descriptions capped at 160 characters sitewide.
- **MK suburb expansion: 260 new local pages** (Bletchley, Newport Pagnell, Stony Stratford, Wolverton, Woburn Sands, Olney, Furzton, Oldbrook, Monkston, Great Linford + more × 21 products).
- The flagship `/double-glazing-milton-keynes/` page rebuilt as a ~3,500-word conversion page: product chooser, real price benchmarks from our quote tool, process, proof.
- Price-guide pages built with checked WindowCAD prices and screenshots — currently gated to the test site pending a go decision.

### Content & copy (~20 commits)
- Full site-wide copy audit: removed internal/template language from customer copy, fixed ~25 scraped paragraphs that ended mid-sentence, removed a false "live chat" claim, rewrote the cat-and-dog-flaps page, cleaned review-count claims, rewrote the cookie and privacy policies to match what the site actually does.
- Commercial pages rebuilt: commercial hub v2 plus dedicated templates for curtain walling, louvres, automation, healthcare and commercial windows/doors.
- Careers page rebuilt with a proper "no vacancies" state.

### Design, UX & mobile (~25 commits)
- Product page redesign: clearer image/copy flow, visible information cards, FAQ-only accordions, gallery lightbox, dedicated window-handles hub.
- Mobile fixes: navigation touch layer, quote-tool controls, contact/about layouts, product carousels, header call button.
- Homepage: product selector polish, updated imagery, partner grid (now including Roseview and Constructionline).

### Performance (~10 commits)
- Removed the old forced loading screen; homepage hero video deferred until idle (9.4 MB no longer in the mobile first load); quote iframes load near viewport or on tap; critical CSS inlined; WOFF2 fonts; image dimensions everywhere.
- Result: ~0.3s server response. Our main competitor's homepage takes 4 seconds.

### Leads, forms & email (~12 commits)
- Enquiry delivery verified end-to-end on live (saved in WordPress first, then emailed to the office).
- File uploads added (photos/drawings/schedules attach to the enquiry and office email).
- SMTP configuration support added; customer confirmation emails deliberately paused until SMTP is authenticated (so we never promise an email we can't deliver cleanly).
- WindowCAD → AdminBase lead relay restored from the old site, now theme-owned.

### Tracking & measurement (~18 commits) — built from zero this week
- Cookie consent banner gating all optional tracking (GTM, Clarity, Meta) — UK PECR compliant.
- Microsoft Clarity session recordings fixed (replay CSS workaround for a host quirk).
- **A first-party Marketing Dashboard** (separate repo): consented visitor journeys, quote starts, WindowCAD quote completions joined to journeys via an anonymous reference, form starts, phone/email intent, channel breakdown — with customer details staying in WordPress/AdminBase.

### Incidents caught and fixed same-day (3)
1. Areas hub accidentally orphaned from sitemap/links → restored.
2. A bulk redirect rule swallowed the flagship MK page (redirecting it, absurdly, toward an Ampthill page) → exempted within the hour.
3. The same page then rendered the wrong template after a matrix change → routing fixed, and a five-route + content regression check added to the deploy checklist so this class of error is caught before it ships.

---

## 2. What the Data Told Us

**From 16 months of Search Console history (old site):** the old site's traffic was declining 45% year-over-year before the rebuild; a third of all its clicks came from one blog article about door lintels; and it *never* actually ranked top-3 for local money terms — they all sat at positions 7–20. So the goal isn't recovering former glory; it's winning positions this domain has never held, from a genuinely strong technical base now.

**From the first post-launch week:** no migration crash — clicks slightly up. Early ranking movement on the terms we specifically targeted:

| Query | 16-month avg | Now (28-day) |
|---|---|---|
| aluminium windows milton keynes | pos 11 | **pos 4.3** |
| upvc windows milton keynes | pos 12.9 | **pos 5.9** |
| front doors milton keynes | pos 10.4 | **pos 7.9** |
| composite doors milton keynes | pos 11.5 | **pos 8.7** |
| french casement windows (national) | pos 13.1 | **pos 2.4** |
| double glazing milton keynes | pos 11 | pos 18.3 * |

\* The flagship page was hit by the week's incidents; fixed and re-verified today — expect recovery over 2–6 weeks. Google is also still mid-way through re-evaluating the whole relaunch, so all positions will wobble before settling.

**From the new Marketing Dashboard (first days):** 20 consented visitors → 14 quote starts → 7 completed WindowCAD quotes is a strong tool-led funnel. Two watch items: **form completion is 0%** (1 started, 0 sent — needs a real-user test of the form ASAP) and Google organic already delivers the most visitors of any channel.

**From competitor analysis:** our main rival (Crown, Bletchley) beats us on case studies (72 vs our 0 live), conservatory pages (118 vs 0), review platform spread and 20 years of accumulated links. We beat them on site speed (10×), technical quality, Google rating (4.9★) and the instant pricing tool nobody else has.

---

## 3. What's Still To Do (in priority order)

| # | Item | Who | Why it matters |
|---|---|---|---|
| 1 | **Test the live enquiry form as a real customer** | Us, today | Dashboard shows 0% form completion — could be sample noise, could be a blocker eating leads |
| 2 | **Residential case studies** (photos + details from ~10 real jobs) | Business supplies material, we build | Biggest content gap vs Crown; feeds suburb pages and trust |
| 3 | **Decide: publish price guides?** | Business decision | Built, tested, gated to test site. Our biggest differentiator — nobody else shows prices |
| 4 | **Request indexing** for the flagship MK page + retitled pages in Search Console | 10 minutes | Accelerates Google seeing this week's fixes |
| 5 | **Authority building**: supplier installer directories (Liniar/Sheerline/Roseview/Distinction), FENSA/CPA profile links, Bing Places, Apple Business Connect, citations | Mostly business/admin | The gap that decides #1 — competitors have 20–40 years of links |
| 6 | **Review velocity system**: post-install Google review ask | Business process | Map-pack ranking is largely a reviews contest; we're at 99, incumbents have hundreds |
| 7 | Suburb pages: add real local proof to the 260 new pages | After #2 | Templated pages rank; pages with real local jobs rank better |
| 8 | Conservatories/porches | Business decision | 118-page keyword family we currently concede to Crown |
| 9 | SMTP authentication → re-enable customer confirmation emails | Admin + small code | Professional touch, currently paused deliberately |
| 10 | Responsive images (srcset) + Core Web Vitals re-test | Us | Last big performance lever |
| 11 | Residuals: ~96 remaining long descriptions (imported pages), quote-page consolidation decision, monthly GSC/rank review rhythm | Us | Hygiene |

---

## 4. The Outlook

Honest framing for the next quarter: the technical and on-page work — the part an agency would bill months for — is done and measurably ahead of every local competitor. The first ranking responses are visible within one week. What separates us from #1 now is not code: it's **proof** (case studies), **authority** (links, citations, reviews) and **cadence** (publishing, review asks, monthly measurement). Those need business inputs — job photos, supplier contacts, a review-ask habit — and the payoff timeline is: page-one consolidation on money terms over weeks, top-5 contention over a quarter, #1 contention inside 6–12 months, with the map pack likely to respond fastest of all once the GBP/review work compounds.

One asset deserves special mention: the instant pricing tool is already earning its own search traffic ("window visualiser tool" position 5, "instant window quote" position 5) and drives the strongest funnel in the dashboard. Every competitor makes people fill in a form and wait. We show prices. The price-guide pages waiting on the test site are how we turn that advantage into rankings — recommend a go decision this week.
