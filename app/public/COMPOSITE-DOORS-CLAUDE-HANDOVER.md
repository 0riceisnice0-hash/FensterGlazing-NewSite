# Composite Doors Design Handover for Claude

## Why this handover exists

The `/composite-doors/` page has been redesigned twice by Codex and the owner has rejected both results. Codex is failing to build a good composite-door page that meets the owner's design standard. The current protected-test V2 should not be treated as accepted or promoted to production.

This document is an explanation of the work, evidence and feedback to date. It is not a prompt.

## The page the owner likes

The accepted reference is the sliding sash page:

- Live page: `https://fensterglazing.com/sliding-sash-windows/`
- Design record: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\SASH-PAGE-REDESIGN.md`
- Accepted live release recorded in `PROGRESS.md`: `8533d4e`

The sash page is not a template to copy literally. It is the quality reference the owner repeatedly pointed to. It succeeds because it has a clear visual hierarchy, real product imagery at useful sizes, mobile-first interaction, controlled information density and a desktop composition that feels related to the mobile design without being a stretched phone layout.

The owner explicitly asked for the composite page to receive the same level of complete redesign as the sash page.

## Composite page locations

- Protected test page: `https://test.fensterglazing.com/composite-doors/`
- Production page: `https://fensterglazing.com/composite-doors/`
- Current repository head at handover: `4350881`
- Composite page remains test-only. The rejected redesign has not been promoted to production.
- Current V2 section: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\template-parts\sections\composite-doors-v2.php`
- Route assembly: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\template-parts\sections\generated-page.php`
- Styling: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\src\scss\main.scss`
- Interaction: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\src\js\main.js`
- Shared product data: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\inc\site-data.php`
- Product hub data: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\inc\product-hub-data.php`
- Current redesign notes: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\COMPOSITE-DOOR-REDESIGN.md`
- Site design rules: `C:\Users\zacpl\Local Sites\fenster-glazing\app\public\STYLE.md`

## Source assets and evidence

The Distinction Doors scrape supplied by the owner is:

`C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape`

Generated composite assets are under:

`C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\assets\images\products\composite-distinction\`

The repeatable asset script is:

`C:\Users\zacpl\Local Sites\fenster-glazing\app\public\wp-content\themes\fenster\scripts\build-composite-door-assets.py`

The two screenshots attached to the owner's detailed criticism were:

- `C:\Users\zacpl\AppData\Local\Temp\codex-clipboard-2ff4156c-1314-4be6-a796-be0bfcbabf9e.png`
- `C:\Users\zacpl\AppData\Local\Temp\codex-clipboard-7d0fdf3e-f0bb-4dc1-bf70-5d491b90aaf8.png`

The scrape contains the relevant Signature, Contemporary and Rustic Renown material. It also contains more colour and glass imagery than was surfaced successfully in the rejected page designs.

## Confirmed product facts

- Fenster is an approved installer of Distinction Doors. The owner wants this shown as a banner.
- Fenster sells Signature and Contemporary Distinction doors.
- Rustic Renown is relevant and is a Signature cottage-style door design.
- Fenster does not sell `nxt-gen`.
- Fenster does not sell Grandeur.
- `Any RAL colour` is not an acceptable blanket claim for this page.
- The page should acknowledge more colours when suitable photographed assets are not available, using `And more` rather than inventing or omitting the wider choice.
- Chatsworth and Wentworth glass must not appear blank or image-less.

## Commit history for the rejected composite work

These commits are in chronological order. They collectively show the first redesign, repeated corrections and the rejected V2.

| Commit | Description |
| --- | --- |
| `68cfc9d` | Redesign composite doors around Distinction ranges |
| `6aa98a0` | Document composite door test verification |
| `f789cc2` | Refine composite door visuals and selectors |
| `134ebd4` | Cap composite door typography and selector height |
| `a253970` | Apply the composite route heading cap |
| `3acd9ac` | Compact composite selectors on tablet |
| `064deed` | Document composite visual selector refinement |
| `a6a7e04` | Correct and simplify composite door journey |
| `ed361e5` | Build composite doors V2 studio |
| `5ce5dce` | Tighten composite configurator viewport |
| `d3ff4b2` | Fit composite configurator to mobile viewport |
| `7aae3b0` | Refine composite tablet and desktop composition |
| `4350881` | Document composite doors V2 |

An older related commit also exists:

| Commit | Description |
| --- | --- |
| `cbef14c` | Improve enquiry form and composite glass layout |

## What Codex tried

The first redesign used a Distinction-led hero, multiple collection cards, a comparison table, an inspiration gallery and separate colour, glass and hardware areas. It was too busy, used the wrong sold ranges, contained oversized typography, made poor use of portrait door imagery and put too much content on screen at once.

The corrections removed `nxt-gen` and Grandeur, added Rustic Renown, added the approved-installer banner, changed the page to the continuous site gradient, removed the inspiration gallery, reduced headings and made colour, glass and hardware more interactive.

The V2 then replaced the main body with one range studio and one tabbed configurator. Its responsive measurements and interactions passed technical checks, but technical correctness did not make the design good. The owner still considers the result visually unacceptable. The central failure is design judgement, not a missing build, syntax or responsive fix.

## Owner feedback quoted verbatim

The spelling, punctuation and wording below are preserved exactly as written by the owner.

### Original sash page audit request

> C:\Users\zacpl\Local Sites\fenster-glazing
> AI.md
> HANDOVER.md
> app/public/LIVECHANGES.md
> app/public/STYLE.md
> app/public/AUDIT.md
> app/public/PROGRESS.md
> read all fully.
>
> design wise, look at https://fensterglazing.com/sliding-sash-windows/ - tell me your findings design wise and UX and customer jounry

### Sash mobile criticism

> i like the desktop but on mobile its fucked and just a wall of text. lets focus on making the mobile version look nice first. maybe a carosel for the three products like we have for the colour options. and some way to show the table of info without it looking shit yk

### Sash page-length and carousel criticism

> its too long of a page, repeated info etc. also the carosel needs to fit cleanly in the view port. its too long rn. take a step back and look at the page as a hole

### Sash imagery request

> nice a step in the right direction. i feel like there isnt enough images, we need a galary in there. and also the images for the 3 products are too small. people buy with what they see. there is a scrap folder of roseview, see what you can find. visually approve every image C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\roseview_full_site_20260703

### Sash desktop direction after mobile approval

> now i prefer the mobile. make the desktop similar, while still make it designed for desktop

### Sash copy criticism

> "See the difference in the room." sucks - make it less cringe, more informative

### Sash audit request

> do a full audit on the page again, see what you find

### Sash PDF and handles direction

The attached document was:

`C:\Users\zacpl\Downloads\Rose Collection - Furniture Colour Guide.pdf`

> ignore legend, he stays no matter what.
>
> give me the important fixes and design choices in a list, and say how you can incoperate this pdf in the page. i dont like the current handles section one bit

### Sash implementation, footer and socials request

> okay do  it all and 2 other small changes, the trust bar in the footer is fucked on mobile, they are spaced weirdly and also add in our socials in the footer
> * https://www.instagram.com/fensterglazing/
> * https://www.facebook.com/fensterg/
> - https://www.linkedin.com/company/fenster-glazing/

### Sash approval and final selector corrections

> massive upgrade!!!!! write a md document of how you achived such greatness.
>
> few small point, get rid of the download link for the pdf.
> and when you select the colours of the handles on mobile, it gets jumpy as it waits for the images to load. this is due to there not being an image therefore the box collapes. so just have the boxes fit to size and stay there

### Sash route-specific colour and hero correction

The attached screenshot was:

`C:\Users\zacpl\AppData\Local\Temp\codex-clipboard-934c5954-5cef-4d44-ad60-b3f5acf5c67c.png`

> remove the colour options panel from just this page, as its differnt for this product. also the hero image aint good at all

### Sash release approval

> i think we are ready to push live, double check everything

### Initial composite redesign request

> same thing again but with composit doors using the C:\Users\zacpl\Documents\Codex\2026-06-04\i-need-you-to-build-a\outputs\distinctiondoors_scrape distinction scrape. push to test.
>
> complete redesign of the page. like how we did the sash. use [Read SASH-PAGE-REDESIGN.md](C:/Users/zacpl/Local Sites/fenster-glazing/app/public/SASH-PAGE-REDESIGN.md)

### First detailed criticism

> feel like it can be better - alot of the images are landscare when doors are not. bold text is an issue, it looks weird too. the title is fucking massive.
>
> the colour direction could be interactive, we surely have a photo of every colour on a door, so make it interactive.
>
> the glass ones are missnig images for chatsworth and wentworth. i also feel like this sction could be alot more interactive
>
> stop with the massive fucking titles tho. i swear its hardcoded to not allow you to go past a certain bit

### Range, layout and interaction corrections

> we are an imporved installer of disinction doors btw that should be a banner. get the background to be the graident thing. not all seperate, use style.md.
>
> door inspiration makes no sence. unessacary.
>
> we have way more colours than that no? if you dont have the assets then just say and more, and there is too much on the screen for the colour section. have it so you select a colour and then the image comes up, we dont need to see the image on the colour selector. make sure it all fits into one view port aswell on mobile.
>
> same with glass.
>
> do something interesting with handles too.
>
> we also dont sell nxt gen and grandeur.
> we do rusic renown or somthing inteast, surely you can see it in the scrape.

### Rejection of the corrected first version

> looks fucking awful. do a v2 of the page. use your best designing skills

### Assessment after V2

> your not very good at this. create a handover document saying here are the commits, here is the page he liked (sash page) he is quote everything he has said to me on this page. say that you are failing to build a good page. this will be sent to claude. do not prompt it, simply explain

## Current state at handover

The GitHub `main` branch and protected test repository are at `4350881`. The current test page is the rejected V2. It is technically functional, but it is not owner-approved design work.

The current V2 has:

- a Signature hero;
- an approved Distinction installer banner;
- a continuous gradient page background;
- Signature, Contemporary and Rustic Renown range controls;
- a combined colour, glass and hardware selector;
- fixed-height responsive preview areas;
- no `nxt-gen`, Grandeur or inspiration gallery;
- no known broken images or horizontal overflow at the checked breakpoints.

Those points describe implementation state only. They must not be read as evidence that the design is successful. The owner has explicitly rejected it.

## Summary of the failure

Codex responded to each criticism mechanically and met individual checklist items, but failed to turn them into a strong overall composition. The iterations concentrated on component count, viewport height, typography caps and interaction state while the page still lacked the visual confidence, product desirability and coherent customer journey of the accepted sash page.

The result is a technically tidy page that the owner thinks looks awful. That is the honest handover state.
