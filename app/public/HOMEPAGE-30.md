# Homepage 3.0

Last updated: 2026-09-04

The Rightmove-UX homepage. On `main` as `9d2b73d4` and on the test site since
2026-09-04. **Not live, and gated so that a theme deploy cannot put it live.**
`HOMEPAGE.md` still describes the classic homepage, which is what live serves.

## What renders where

`fenster_h30_enabled()` in `inc/home-30.php` is an allow-list of hosts:
`fenster-glazing-30.local`, `fenster-glazing.local`, `test.fensterglazing.com`,
`localhost` and `127.0.0.1`. On those hosts `/` renders
`template-parts/sections/home-30.php`. Everywhere else, including
`fensterglazing.com`, `generated-page.php` keeps its default and the classic
`home-experience.php` renders unchanged. The theme can therefore go to live with
this strand inside it and nothing changes on production.

**Putting it live is one deliberate edit:** add `fensterglazing.com` and
`www.fensterglazing.com` to that list, in its own commit, named in the commit
message and recorded in `LIVECHANGES.md`. `AI.md` records a gate opened silently
inside an unrelated commit; that is the failure this arrangement exists to stop.

## Source map

Everything is namespaced `fg-h30-` / `home30`. Nothing shared was modified
except one filterable line in `generated-page.php` and one `require` in
`functions.php`.

| Responsibility | File |
| --- | --- |
| Gate, data, asset enqueue, search resolver, map data | `inc/home-30.php` |
| Template | `template-parts/sections/home-30.php` |
| Styles | `src/home30/home30.scss` → `assets/home30/home30.css` |
| Script entry | `src/home30/home30.js` → `assets/home30/home30.js` |
| Ranked catalogue search and spelling fallback | `src/home30/finder-search.mjs` (+ `.test.mjs`) |
| Typewriter headline | `src/home30/typewriter.js` |
| Projects carousel | `src/home30/rail.js` |
| WindowCAD frame | `src/home30/quote.js` |
| Coverage map | `src/home30/map.js` |
| Resized images | `assets/images/home30/tiles/` (6), `assets/images/home30/thumbs/` (25) |

`main.css` and `main.js` still load underneath for the header, footer, consent
layer and Legend. Do not move this strand's CSS into `main.scss` or its script
into `main.js`.

The strand borrows ten theme helpers and all are on `main`: `fenster_site_data`,
`fenster_generated_url`, `fenster_case_studies_of_type`,
`fenster_case_study_card`, `fenster_review_summary`, `fenster_review_cards`,
`fenster_google_config_value`, `fenster_location_matrix_products`,
`fenster_location_matrix_towns` and `fenster_aluminium_windows_story_asset_url`.

## Sections, in order

1. **Hero.** One photograph per tab (Wolverton, Hanslope, Little Horwood), a
   typewriter line, and the finder: Windows / Doors / Whole house tabs with
   ranked search across 27 options. A proof strip sits under it. The H1 is the
   13px eyebrow above the typewriter and carries the same sentence as the
   classic homepage's H1; the typewriter line is not a heading.
2. **Browse.** Six category tiles with product chips.
3. **Price.** Copy beside the WindowCAD retail interface in an iframe, which
   takes its `src` when the band is near the viewport or when the button is
   pressed, with a full-screen control that falls back to a new tab.
4. **Projects.** Six residential case studies as a carousel with product
   filters, from `fenster_case_studies_of_type()`.
5. **Proof.** Google rating, showroom, own fitters, accreditations.
6. **Areas.** Leaflet from cdnjs on OpenStreetMap tiles by default; Google Maps
   when `FENSTER_GOOGLE_MAPS_KEY` is configured. A red working-area outline, a
   pin per residential case study and the showroom, all from
   `fenster_h30_map_data()`.
7. **Close.** Quote and consultation actions.

## Build and checks

From the theme directory: `npm.cmd run build:home30`, then
`npm.cmd run test:home30` (four search tests). Lint `inc/home-30.php` and
`template-parts/sections/home-30.php`. Rebuild after any `src/home30/` edit;
the compiled files are committed and were byte-identical to a fresh build at
`9d2b73d4`.

## Verified on test, 2026-09-04

- Renders on `/` with `.fg-h30-hero`; same title, description and canonical as
  the classic homepage; H1 `Windows and doors, fitted across Milton Keynes`.
- **WindowCAD works on `test.fensterglazing.com`.** The frame loads the retail
  interface, not a licence notice, so the domain licence covers test. The live
  domain is separate and stays unproven until it is tried there.
- Leaflet renders from cdnjs with OpenStreetMap tiles; 17 markers.
- 75 internal links, all `200`. Zero console errors and zero failed requests
  of its own in headless Chrome at 1440x780, 768x1024 and 390x844. No
  horizontal overflow at 1440, 768, 390 or 320; the hero fits under the fixed
  header at each; nothing renders above 32px.
- The only `404`s on the page are eight font requests from the inline Clarity
  replay stylesheet, which is site-wide and older than this strand; see
  `LIVECHANGES.md`.

## Still unproven

- **OpenStreetMap's tile usage policy does not cover a commercial homepage.**
  Fine for the traffic test sees. Before live, set `FENSTER_GOOGLE_MAPS_KEY`
  so the same code renders Google Maps, or agree another tile source.
- No Safari, Firefox or real device has seen it. The typewriter, the
  scroll-snap carousel, the map animation and `requestFullscreen` on a `div`
  are where they differ, and iOS will not full-screen a non-video element.
- Core Web Vitals are unmeasured. Run Lighthouse on test.
- Analytics fire on test exactly as on live. Pre-existing and not introduced
  here, but two homepages now feed the same GA4 and Clarity properties.

## Rolling back

Remove `'inc/home-30.php'` from `functions.php`, or filter
`fenster_home_template` back to `template-parts/sections/home-experience`.
The classic homepage is untouched either way.

## Where it came from

Built in the `fenster-glazing-30` Local sandbox (see the sandbox's own
`LOCAL-EXPERIMENT.md`), then ported as one commit on top of `main` in the
`feat/homepage-3-0` worktree. The sandbox is a 2 September snapshot of the
theme and is now behind `main`; nothing else in it is pending.
