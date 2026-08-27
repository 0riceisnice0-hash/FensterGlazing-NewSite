# Composite Doors and Why Distinction: visual overhaul brief

Written 2026-08-27, against test at `b2420743 + 18`. Two pages:
`/composite-doors/` and `/why-distinction/`.

Part 1 is the audit, measured rather than felt. Part 2 is the master prompt that
runs the overhaul. Read Part 1 before trusting Part 2, because every instruction
in the prompt is answering something in the audit.

---

# Part 1: the audit

## What was measured, and how

Both pages rendered on test through `scripts/shot.mjs` (CDP, real viewport
emulation) at `1440x900`, `768x1024` and `390x844`, then probed for section
heights, computed heading sizes, image counts and overflow. Nothing here is
inferred from the source.

| | `/composite-doors/` | `/why-distinction/` |
| --- | --- | --- |
| Sections | 17 | 5 |
| Desktop height | 13,909px | 4,689px |
| Tablet height | 18,805px | not captured |
| Mobile height | 21,513px | 7,569px |
| Page `h2` sizes | 28.8px × 14 | 28.8px × 4 |
| Images on page | 200+ | **0** |
| Console errors | none | none |
| Horizontal overflow | none | none |
| Failed requests | none | none |

Nothing is broken. That is worth saying first, because the problem is not a bug
list. Both pages render clean at every width.

## The diagnosis, in one sentence

**Seventeen sections of equal weight, fourteen headings of identical size, and
nothing on the page is permitted to be more important than anything else.**

`STYLE.md` asks for "continuity from section to section" and for "deliberate
variation between narrative and utility sections". What is there instead is
uniformity: every chapter heading is 28.8px, most sections are a heading plus a
grid, and the reader gets no signal about where the page is going or when it is
nearly over. Seven of the seventeen sections are taller than a 900px desktop
viewport, against the 680–780px this file asks for. The page is not badly built.
It is unled.

`/why-distinction/` has the opposite problem and the same cause: four sections,
each one a heading over a wall of text, zero photographs, and 700px of empty
viewport to the right of every paragraph on a 1440 screen.

## `/composite-doors/`, section by section

Heights are at `1440x900`.

**1. Hero — `.fg-cd3-hero`, 514px.**
A 514px hero in a 900px viewport does not own the fold: the spec strip and part
of the installer badge are visible under it, so the first impression is three
stacked bands rather than one door. The copy column bottoms out roughly 100px
above the base of the image, so the two halves of the grid visibly disagree. The
image is the 800w asset in a box about 617px wide, when `hero/` holds a 1920w
one that is unused. The `Distinction composite door` caption chip is uppercase
bold over the bottom-left of the photo and reads as an asset label rather than a
caption. On mobile the door does not appear until roughly 500px down, below both
CTAs, so the first mobile fold is text and two buttons.

**2. Specification strip — `.fg-cd3-brief`, 209px.**
Four facts in a hairline box. The same treatment returns 4,000px later as the
anatomy stats strip, so the page repeats its own device. `Six collections /
The same six you meet in our quote tool` is a navigation note in a slot the other
three fill with a number.

**3. Approved installer — `.fg-composite-approved`, 214px.**
A third bordered utility band inside 400px. The page has now spent three
sections on strips and has shown the customer one photograph.

**4. Collections — `.fg-cd3-collections`, 912px.**
Six cards, each forcing a tall door render into a column about 105px wide. The
doors are cut off, the render backgrounds are three different colours, the two
rows are different heights, and the copy lengths leave large voids inside
individual cards. This is the case `STYLE.md` names directly: "Never force
portrait or unusually tall source imagery into a repeated card grid."
It is also **duplicated content** — the six collections are the six tabs of the
style range immediately below it.

**5. Style range — `.fg-cds`, 1,474px.**
The second-tallest section on the page and the heaviest visually: eight columns
of black line art with no tonal relief. Traditional holds 19 doors, so the last
row is an orphan of three. Labels that wrap to two lines push their neighbours
out of alignment. And the drawings read backwards — black fill marks *glass*, so
a solid door looks empty and a fully glazed one looks solid. There is no visual
affordance that each drawing is a link into the quote tool, which is the entire
purpose of the section.

**6. Quiz — `.fg-cdq`, 877px.**
A second large white card starting immediately under the first, with a visible
seam between them: the "stack of white cards" `STYLE.md` warns against. Content
is left-aligned inside an 1180 container with the right half empty. The third
answer on question one, "Honestly, neither", renders as an empty bordered box
beside two illustrated ones.

**7. Construction — `.fg-cd3-anatomy`, 969px.**
The flat bitmap on the left and the accordion on the right are not connected to
each other. Opening a layer highlights nothing. A leader line and dot sit in the
middle of the image pointing at nothing in particular. Five of the six rows are
empty space whenever one is open. **The supplied design handoff replaces this
section and is the best-specified piece of work in the whole brief.**

**8. Security — `.fg-cd3-security`, 558px.**
The best-composed section on the page, and the only dark moment. Two faults: the
drawn `£5000 GUARANTEE` shield is crude enough to undercut the claim it carries,
and the four supporting points are mid-grey on dark navy.

**9. Through-link — `.fg-wd-cta`, 316px.**
A stranded band with roughly 135px of empty canvas above it. Copy sits left, the
button floats vertically centred at the far right with a large gap between them.
This is the only route to `/why-distinction/` on the entire site.

**10. Decorative glass — `.fg-composite-glass`, 1,532px.**
The tallest section on the page. Eleven items in a five-column grid leaves one
card alone in row three beside four empty cells. Images within the same row are
different heights, so the captions do not sit on a line. The numbered badges
imply a ranking that does not exist. Chatsworth and Wentworth are near-featureless
white rectangles that read as broken images. The section then closes with three
consecutive note blocks in three different treatments.

**11. Colour — `.fg-cd3-colour`, 1,170px.**
A visible horizontal seam where the section's background changes against the
page canvas: the banding fault `STYLE.md` records against this exact page. Two
lead paragraphs run together with no separation. The swatch grid is ragged
(6/6/6/3). The preview is a wide photograph of a porch in which the door is a
small part of the frame, so the thing being previewed is the least visible thing
in the picture. Its caption is the only centred text on the page.

**12. Handles — `.fg-handle-finishes`, 510px.**
Competent and generic. It is the third consecutive "pick a finish" grid and is
not grouped with the other two.

**13. FAQ — `.fg-product-faq`, 738px.**
A two-column layout in which the left column holds a heading and then roughly
425px of pure empty space for the full height of the accordion. `FAQs about
Composite Doors` is Title Case against sentence case everywhere else on the page.

**14–17. Quote embed 723px, reviews 704px, case studies 946px, enquiry 957px.**
The quote embed leaves a large white void. The reviews rail clips its fourth
card under the arrow control. The case-study cards have meta lines that wrap on
two of three, so the three titles do not align, and the first card carries a
bottom void. The enquiry panel is dark with roughly 555px of empty left column
below the phone number.

## `/why-distinction/`

**Zero images on a 4,689px page.** `STYLE.md`: "Do not leave a new
customer-facing page text-only by default when suitable project, product, team
or showroom imagery exists." The theme holds 30 composite gallery images, 6 hero
assets and a fourteen-photograph sequence of one Milton Keynes door going in.

- **Hero, 439px.** Eyebrow, H1, lead, two buttons, then roughly 180px of blank
  gradient. No visual anchor of any kind.
- **The slab, 898px.** Six layers in a four-column grid, so row two is two cards
  beside a two-cell hole. Cards 4 and 5 carry large internal voids.
- **The 50% figure, 635px.** Six hundred pixels of left-aligned prose with about
  700px of empty viewport beside it. `50%` is the largest green display type on
  the site and floats with nothing to anchor it.
- **The rest of it, 777px.** Six cards, four columns, the same orphan row and the
  same internal voids.
- **The judgement, 461px.** Text, then two buttons.

**Three em dashes in customer-facing copy**, at `why-distinction.php:116` and
`:142`. Both `STYLE.md` and `TONEOFVOICE.md` forbid them without exception. They
render on test today.

## The cross-page findings

These matter most, because they are the ones neither page can see on its own.

**1. The layer list is written twice.** `/composite-doors/` explains the slab as
GRP skin, polymer edges, engineered wood stiles, reinforced central board,
foam-filled core, decorative glass. `/why-distinction/` explains it as the skin,
the edges, the engineered timber, the reinforced board, the core, the glass.
Same six layers, same order, different words, both presented as the definitive
account. The split between the two pages is in the wrong place.

**2. `/why-distinction/` is linked from exactly one place on the site.** One CTA
band on one page. `AI.md` records that it is "reached from the composite page and
from the footer, the same way `/care-and-maintenance/` is" — **there is no footer
link.** The documented position and the shipped position disagree.

**3. The FAQ restates the page and does not link to it.** `Why do you fit
Distinction composite doors?` compresses the whole of `/why-distinction/` into
one paragraph, and `Why is there no U-value shown for composite doors?` gives the
50% figure and its source. Neither links through.

**4. The pages share no grammar.** Composite uses `.fg-cd3-*` on a shared white
surface with green numerals and drawn marks. Why-distinction uses `.fg-wd-*`
bordered tiles on bare canvas. A visitor clicking through does not recognise the
second page as part of the first.

## One thing to hold on to

`STYLE.md` names `/composite-doors/` as one of its **five reference pages** —
specifically for "hero pattern, collection cards, the interactive layer explorer,
full-size colour chips, the green-then-dark CTA pair". Overhauling it changes the
standard other pages are copied from. That is not a reason to hold back; it is a
reason to finish `STYLE.md`'s reference-page entry in the same commit, so the
file does not spend the next month describing a page that no longer exists.

---

# Part 2: the master prompt

Everything below is the prompt. Run it as written.

---

## Brief

Overhaul the visual design of `/composite-doors/` and `/why-distinction/` so the
two read as one document with two halves. The owner's instruction: make the hero
a proper hero, lay everything out far better, align both pages with `STYLE.md`,
and link the two pages together. Every section is in scope. Nothing is signed off
as already good.

**Read before writing any code:** `STYLE.md` in full, `TONEOFVOICE.md`, the three
composite rules in `AI.md` (WindowCAD URL Parameter, Composite Door Range,
Composite Door Quiz), and the supplied design handoff at
`design_handoff_composite_door_anatomy/README.md`.

## The page idea, settled before any layout

`STYLE.md` requires these five in writing before code. They are settled here; do
not re-open them mid-build.

1. **The customer's primary task** is getting a real price on one specific door.
   Everything else on the page exists to get them to a door they want and then
   into the quote tool loaded on it.
2. **The object that commands the first viewport** is one real Fenster-fitted
   composite door, large, with the price action on it.
3. **Sections earn their place by narrowing the choice or by making the price
   feel safe.** Anything doing neither is merged or cut.
4. **The supporting image treatment is our own installation photography**, not
   catalogue renders. The theme holds a fourteen-photograph sequence of one
   Milton Keynes door — before, old frame out, delivered, hung, cill, inside
   face, open, finished — and the page currently uses none of it.
5. **Reassurance splits in two.** The £5,000 guarantee and the ten-year IBG sit
   next to the price action. Reviews and case studies come later and carry
   different evidence.

## The structural move: seventeen sections become five chapters

This is the fix for the flatness, and it is not a deletion exercise. Content is
kept and regrouped so the page has a shape.

**Chapter 1 — The door.** Hero, with the four specification facts folded into it
rather than sitting in their own strip below, and the Distinction approved-installer
mark folded in as a credential rather than a third band. One viewport, one action.

**Chapter 2 — Choose one.** The 142-door range and the quiz, on one shared
surface, as a single chapter with one heading. **The collections carousel is
absorbed into this chapter**: the six collections are already the six tabs, and
the slab description each card carries becomes the tab's own intro line. This
removes 912px of duplicated content and a broken image grid in one move.

**Chapter 3 — What it is made of.** The rebuilt peel-back cutaway from the
supplied handoff, then the security guarantee, then the handoff into
`/why-distinction/` as this chapter's own footer rather than a stranded band.

**Chapter 4 — How it will look.** Glass, colour and handles as one finishes
chapter under one heading, because they are one decision made three times. Three
separate grids become three steps of one.

**Chapter 5 — Proof and price.** Case studies led by the MK install sequence,
reviews, the quote tool, the enquiry form.

Then FAQ, which stays where it is and gets its dead left column fixed.

**If a merge cannot be made to work, ship the section improved and separate
rather than half-merged.** A worse page is not an acceptable price for a tidier
structure.

## The hero, specifically

The current hero is a 514px two-column box that does not own the fold.

- **It must fill the first viewport at `1440x900`** below the 72px header, and
  hold one dominant action. Not `min-height: 100vh` on everything — this one
  section, composed to fit.
- **Use the 1920w asset.** `hero/distinction-signature-entrance-1920w.webp` and
  `distinction-grandeur-entrance-1920w.webp` exist and are unused; the page
  currently serves an 800w file into a 617px box. Verify the crop at the real
  viewport: a crop that cuts the door out of frame is a defect, not a detail.
- **The four facts belong in the hero**, as a row beneath the action or inset
  over the image, not as a separate bordered strip. Replace `Six collections`
  with a fact: `44.5mm`, `£5,000`, `10 years` and one more real number.
- **Kill the caption chip** or make it a caption. `DISTINCTION COMPOSITE DOOR` in
  uppercase over the corner of the photo reads as an asset label.
- **On mobile the door must be visible in the first fold.** Today it sits below
  both CTAs. Reorder so the customer sees the product before the buttons.
- The H1 stays `Distinction composite doors`. The eyebrow keeps the location
  line. Both are correct under the Product Naming rule and neither changes.

## Layout rules this overhaul is fixing

Apply these everywhere, not only where the audit named them.

- **No orphan rows.** Every grid on both pages currently strands one or two items
  beside empty cells: 19 doors in eights, 11 glass designs in fives, 6 layers in
  fours, 6 cards in fours. Choose column counts against the real item counts, or
  let the last row centre, or change the item count.
- **Equal cards, equal content boxes.** Where a row is height-matched, the shorter
  card must not carry the difference as an internal void. Balance the copy or
  anchor the card's contents to its edges.
- **One measure per section.** Sections currently mix a 62ch paragraph, a 66ch
  paragraph and a full-1180 note in the same block.
- **Kill the seams.** The colour section paints its own background against the
  page canvas. `STYLE.md` records this exact fault against this exact page.
  Fix it at the canvas, not with another background.
- **Break the 28.8px monotony.** Fourteen identical H2s on a 13,909px page is why
  it reads flat. Chapter openers may rise toward 2.5rem where the composition
  supports it; sub-steps inside a chapter drop to H3. Nothing exceeds
  `var(--fg-font-size-max)`.
- **Vary the register.** The page has one dark moment in 13,909px. Chapters
  should alternate between light canvas and contained surface, with dark used
  where it means something.
- **Fix the empty columns.** The FAQ's left column, the enquiry panel's left
  column and the 50% section on why-distinction each waste 400–700px of width.

## The construction section

Build it from the supplied handoff at
`design_handoff_composite_door_anatomy/README.md`. It is high fidelity: geometry,
masks, materials, callout anchors, tokens and breakpoints are all final numbers
taken from the theme's own stylesheet. Match them exactly rather than
approximating.

Three things in it are load-bearing and easy to lose:

- The sawn-glass element must be a **sibling** of the glass face, not a child;
  the two masks are exact complements and nesting them multiplies to zero.
- It must be a **full-slab element clipped down**, not an element sized to the
  glass rect, or the arc lands in the wrong place.
- **Timber sits inside polymer**, not outside. Distinction's own graphic has this
  the wrong way round. Do not "correct" it back.

Copy, stats and footnote come from `$composite_anatomy` unchanged. Work the
handoff's own definition-of-done list before calling it finished.

## `/why-distinction/`

- **Give it photographs.** A page with zero images is not acceptable under
  `STYLE.md` when the theme holds 30 gallery shots, 6 hero assets and a full
  install sequence. The hero needs one. The judgement section — the part that
  says come and close one — should carry the showroom.
- **Remove the three em dashes** at `why-distinction.php:116` and `:142`. Rewrite
  those sentences; do not swap in a hyphen and leave the rhythm broken.
- **Give it the same grammar as chapter 3 of the composite page**: same numerals,
  same card treatment, same accent handling. A visitor arriving from the CTA
  should recognise where they are.
- Fix both six-item grids so nothing is orphaned.
- Anchor the `50%`. It is a real figure with real conditions and it should read
  as evidence, not as a floating infographic.
- The H1 stays as it is. This is a support page, not a product page, and a voice
  H1 is correct here.

## Making the two pages link together

Today: one CTA down, two buttons back, no footer link, and a FAQ that restates
the whole argument without linking to it. Fix all four.

1. **Settle the split.** The layer list currently exists on both pages in
   different words. `/composite-doors/` owns the **graphic** — the peel-back
   cutaway, six layers, seen. `/why-distinction/` owns the **argument** — the
   evidence, the attribution, the caveats, the judgement. The long page stops
   re-describing the six layers and starts from what the graphic showed.
2. **Make the handoff a designed moment**, as chapter 3's footer, not a stranded
   band. It should read as "you have seen it, here is why we chose it".
3. **Add the return route in more than one place.** `/why-distinction/` should
   send a reader back to the *range* and to the *quiz* specifically, not only to
   the top of the composite page.
4. **Link the two FAQ answers.** `Why do you fit Distinction composite doors?`
   and `Why is there no U-value shown for composite doors?` both answer with
   material that page carries in full. Link them.
5. **Add the footer link.** `AI.md` already says it is there. It is not. Either
   add it beside `/care-and-maintenance/` or correct the rule; adding it is right.

## Hard constraints

None of these are up for reinterpretation during a visual pass.

- **Do not touch the WindowCAD URLs.** `interface=composite`, `style=` the door
  key, `colour=` the **palette** key. The eight quiz colours are the ones safe
  across both colour collections. A wrong key renders white and looks exactly
  like the parameter being ignored.
- **Glass stays a filter in the quiz, never a score.** Somebody who says no glass
  means no glass. If the questions change at all, re-run the 72-combination sweep.
- **The quiz is not a configurator and must not drift into one.** It narrows and
  hands over. It draws nothing and prices nothing.
- **Ties break on data order, never randomly.** The result URL is shareable and
  must be reproducible.
- **Every fact on `/why-distinction/` stays attributed to Distinction.** The 50%
  keeps its conditions. No U-value anywhere. The owner's own reason stays stated
  as a judgement.
- **Do not name a fabricator or a competitor.** The only comparison the site
  publishes names a construction, not a firm.
- **Line-art URLs are versioned on `filemtime`; the rest of the theme's images
  are not.** If a screenshot disagrees with the code, hash the served file before
  believing the screenshot.
- **No em dashes, British English, no exclamation marks, sentence case below the
  H1.** No CTA is a text link, including the phone number. CTA pairs are green
  then dark, or green then light on a dark panel.

## Definition of done

- Full-page pass at `1440x900`, `768x1024` and `390x844` on **test**, never Local.
- Every ordinary section reads as one complete composition inside a 900px
  viewport, or its excess is recorded and justified.
- No orphan rows, no internal card voids, no empty half-columns, no visible
  background seams.
- Mobile page height reduced from 21,513px. Record the new number. It will not
  reach the 15,000px the SEO audit asks for and should not be forced there by
  deleting working content; it should come down because five chapters need less
  scaffolding than seventeen sections.
- No horizontal overflow at 320px. No console errors. Every image loaded and in
  a deliberate grid.
- Grep the rendered HTML of both pages for em dashes, light-on-light text,
  supplier or fabricator names, internal filenames and campaign CTA copy.
- The construction section passes the handoff's own definition-of-done list.
- Both pages screenshotted after the deploy, with the served asset hashes
  checked, before any claim that a change is live.
- `STYLE.md`'s reference-page entry for `/composite-doors/` updated in the same
  commit, so the file stops describing a page that no longer exists.

## Three calls made here that the owner can veto

1. **The collections carousel is absorbed into the range chapter.** It duplicates
   the six tabs below it and its image grid is the worst on the page. If the six
   collection cards are wanted as their own section, say so and they stay,
   rebuilt.
2. **Glass, colour and handles merge into one finishes chapter.** Three grids
   become three steps. If they are wanted apart, they stay apart.
3. **The construction section and the security guarantee are being restructured**
   even though the owner signed off that middle of the page. The handoff
   replaces the construction graphic outright, and the security panel changes
   register around it. If that middle is meant to stay untouched, the handoff
   cannot be built and chapter 3 becomes a re-skin instead.
