# About Page Redesign Handover

Written 2026-07-20 by the previous agent, after four failed attempts. Read this
before touching the page. It exists so you do not repeat the same mistakes.

## The job

Redesign `/about/` from scratch. The owner is not happy with any version so far
and wants a genuinely well-designed page, not another iteration of mine.

Ignore every other outstanding task on this site. Only this page matters.

## Read first

1. `WORK-AT-HOME.md` — the owner is on the home PC. Different SSH key, no local
   WordPress. GitHub is the source of truth.
2. `STYLE.md` — the design contract.
3. `AI.md` — coding rules and the QA gate.
4. `CASESTUDIES.md` — the owner's favourite page on the site.

## The files

- `app/public/wp-content/themes/fenster/template-parts/sections/about.php`
- The `.fg-about` block in `app/public/wp-content/themes/fenster/src/scss/main.scss`
  (starts at `.fg-about {`, ends just before `.fg-enquiry {`)

The route is dispatched from `generated-page.php` on `$slug === 'about'`.

## Read this bit twice: I built this page four times without ever looking at it

Every failure below traces back to that. I verified with `curl` and `grep`,
checked status codes and class names, and reported the page as working. It was
not. Do not repeat this.

**Use the Chrome extension and actually look at the rendered page.** The
in-app browser pane's screenshot times out on this site every time; the
`claude-in-chrome` tools work. `STYLE.md` says the screenshot wins over computed
values, and it is right.

Bugs a single glance would have caught, that measurement did not:

1. **The gallery images never loaded.** `height: auto` + `loading="lazy"` + no
   width/height attributes means zero intrinsic height, so the container never
   enters the viewport, so the lazy loader never fires. The section rendered as
   eight empty caption boxes and I shipped it. Use
   `fenster_image_attr_string($url, $attrs)` so images carry real dimensions.
2. **Then the portraits rendered at 170x2560.** Once images carry a real
   `height` attribute, that attribute is a presentational hint that beats
   `aspect-ratio` unless one dimension is `auto`. Always set an explicit CSS
   `height` or `height: auto`.
3. **A six-cell mosaic in a four-column grid where the lead spans 2x2** strands
   one cell alone on a third row beside ~950px of dead space. Five cells closes
   the rectangle.
4. **A `str_replace` on `class="fg-about-pricing__grid"` silently matched
   nothing**, because the markup is `class="container fg-about-pricing__grid"`.
   Verify your edits actually applied.

## What the owner has rejected, with reasons

- **"We fit our own work"** and **"A Milton Keynes glazing company that shows you
  the price"** as headlines. Too wordy, or did not make sense.
- **"Fenster is German for window" as the H1.** It is true and he likes it, but
  as a small nod in the copy, not the page's identity.
- **The founding story** (two people, one did not fancy work on Monday). He said
  it was a joke, not website copy. Do not publish it in any form.
- **Half-viewport founder portraits** (574x718). Also rejected them at 170px as
  too small. Somewhere in between.
- **A ragged masonry gallery.** Reads as a dump. He liked the fixed-cell mosaic.
- **The colour-hub coverflow carousel** on this page. When he said "look at the
  colour options page" he meant take inspiration from the interactivity, not
  transplant that component.
- **The five-step process band with large ghost numerals behind the text.** His
  words: "looks shit", "weird numbers behind it".
- **Text links as primary CTAs.** He wants buttons, and he is right per STYLE.md.
- **Strong parallax on several images at once.** At `data-fg-depth="0.05"` it
  moved 8.66px, which is invisible and he kept asking where it was. At 0.30-0.60
  it moves up to 99px and he said it made him feel drunk scrolling. The honest
  read is that heavy multi-image parallax is wrong here. Find a better idea.

## What he has asked for

- Something that looks genuinely designed and "sick", in his words.
- Cascading left/right/left/right rhythm down the page.
- Interactivity and movement, but not nausea.
- Image-heavy. Borrowing imagery from elsewhere on the site is explicitly fine.
- The two founders, Adam and Nick, on the page.
- Positioning around instant pricing: a real figure quickly, rather than an
  appointment and a callback days later.
- Bits from `/why-trust-fenster/`.
- The Sheerline award.
- Links through to everything: quote, consultation, case studies, meet the team,
  trust, colours.
- He does not want his spitballed phrasing transcribed onto the page. Write it
  properly.

Reference pages he rates: `/roof-lanterns/`, `/case-studies/`,
`/why-trust-fenster/`. Measured at 1440, roof lanterns runs 23 images at about
29% of page area across ten sections averaging under 600px. That density is the
target.

## Facts: verified, unverified, and forbidden

**Confirmed by the owner:**
- Trading since 2018. Milton Keynes showroom and office, 98 Alston Drive,
  Bradwell Abbey, MK13 9HF.
- Showroom Mon-Fri 8.30am-5pm. Phone lines answered 24/7 via a genuine answering
  service. This was queried twice in audits and is closed. Do not re-raise it.
- Fitters are in-house, not subcontracted.
- Ten year insurance-backed guarantee on new window and door installations via
  the CPA. Explicitly excludes repairs, replacement glass, roofline, integral
  blinds and pet flaps. Not transferable to a new owner.
- Sheerline "Installation of the Month", **August 2025**, for the Northampton
  roof lantern and heritage doors job. Fitted by Johnnie Greenwell and Tom Carter.
- Adam Butcher, Commercial Director. Nick Baker, Sales Director. Both founded it
  in 2018 and both have good B/W portraits: `imported/adam-butcher-scaled.jpg`
  and `imported/unnamed-5.jpg` (yes, really).

**Do not claim:** that the instant quote tool returns a price without taking the
customer's details. It does take them. The honest and still strong version is
speed: a real figure in minutes instead of waiting days for a callback. The
seven price-guide pages genuinely are published with no form at all.

**Unverified:** "1,000+ installations" and "100s of reviews" are already live on
the homepage, case studies page and generated pages, but both sit on
`AUDIT.md`'s substantiate-before-launch list. Using them is consistent with the
rest of the site; just know they are not confirmed.

## Imagery

Genuinely Fenster's own:
- `assets/images/case-studies/` — 26 real install photos, mostly portrait
  (1600x2133, 1200x1600). Landscape ones are limited: `cs-big-roof-lantern-14`,
  `-19`, `-poster` (1600x900) and two casement shots (1600x1200).
- `assets/images/about/fenster-showroom.png` — the real shopfront. An audit
  flagged its 1536x1024 dimensions as AI-suspicious; I opened it, it is a genuine
  photograph with real signage. Safe to use.
- `assets/team/` plus the founder portraits above.
- Two real install videos in `assets/videos/case-studies/`.

Supplier libraries (Roseview, Sheerline, Distinction) are higher resolution and
glossier but are not Fenster's own work. The owner is relaxed about borrowing
them; use your judgement.

**Missing entirely:** vans, workshop, showroom interior, staff at work, group
shot. There is no company photography process; `PHOTO-CHECKLIST.md` covers
install photos only.

## Verify like this

1. Build: `npm.cmd run build` from the theme directory.
2. Lint changed PHP with the Local PHP binary at
   `C:\Users\zacpl\AppData\Roaming\Local\lightning-services\php-8.2.27+1\bin\win64\php.exe`.
3. Commit, push, deploy to test only.
4. **Open it in Chrome and look at it**, at 1440 and at 390.
5. Check horizontal overflow, that every image actually loaded
   (`img.complete && img.naturalWidth > 0`), and section heights.

Deploy to test:

```
ssh -i 'C:/Users/zacpl/.ssh/fenster_siteground_home_codex' -p 18765 u453-m73mh4m4wev2@ssh.fensterglazing.com "cd ~/repos/FensterGlazing-NewSite && git fetch origin main && git reset --hard <SHA> && rsync -a --delete ~/repos/FensterGlazing-NewSite/app/public/wp-content/themes/fenster/ ~/www/test.fensterglazing.com/public_html/web/app/themes/fenster/ && cd ~/www/test.fensterglazing.com/public_html && wp cache flush && wp sg purge"
```

Test site is `https://test.fensterglazing.com` with basic auth `fenster` /
`Fenster`.

**Do not deploy to live.** Reset to an explicit SHA, never `origin/main`:
deploying `main` wholesale already pushed unapproved work to production once.

## One last thing

The owner is a marketing executive who knows what good looks like and has been
patient through four bad versions. He does not want to be asked lots of
questions; he wants to be shown something good. Make the design decision, build
it completely, look at it, fix what is ugly, and only then show him.
