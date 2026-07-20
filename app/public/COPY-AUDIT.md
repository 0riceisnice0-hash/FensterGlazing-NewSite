# Fenster Glazing — Site-Wide Copy Audit

Date: 2026-07-06
Re-scan: 2026-07-07 — identical live crawl re-run after the cleanup deploy (`4ce91a6`). See "Re-Scan Results" below; the findings tables in §1–§8 are kept for history.

## Re-Scan Results (2026-07-07)

Heuristic flags dropped from 152 to 96, and everything left in the flag list is legitimate copy (legal-page "this website" language, list-intro colons, "journey" used in its normal customer sense). Verified **fixed on live**: the gallery meta sentence and both gallery bullets, the "focused guides" self-talk, both product-intro self-references, "key specifications strip", "commercial records", every "route" instance including "monkey tail handle routes" and the ×47 county CTA, the live-chat claim, all mid-sentence "Obscured" casing, and ~22 of the ~25 truncated article paragraphs — the repaired ones now end in real sentences. The new product-template copy ("Product information", "More information on […]") reads cleanly.

**Still outstanding after the cleanup:**

1. `/other-services/` intro — "**Fenster glazing are** home improvements specialists…" (lower-case brand + broken agreement) appears twice, one copy ending in an ellipsis, plus the keyword-string h3 "Glazing, Integral Blinds & Cat Flaps Milton Keynes & Buckinghamshire". The §6 fix missed this page entirely.
2. Two truncations survived: `/what-is-a-door-lintel/` "…seek help from a building expert with experience installing a door lintel **and**" *(ends)*; `/how-to-choose-the-right-style-windows-for-your-home/` "…because they offer a variety **of**" *(ends)*.
3. One repair reads awkwardly: `/choosing-the-right-front-door-for-your-home/` now says "…performance standards set out by **the U.K.'s government's commitment** to improve energy efficiency" (double possessive — suggest "set out by the UK government's energy-efficiency requirements").
4. Untouched low-priority items from §7/§8, all previously graded medium/low: the matrix "This helps the finished installation work properly once it is fitted." suffix repetition (×21), "Market Leading Double Glazing in X" link labels (×20), "Get in Touch" title case (×42), mixed review date formats (ISO "2025-06-01" next to "14 Nov 2025", ×318 pages), the ASCII "->" arrow on form buttons (×314), and the footer's stray space in "Made in house by Zac **.**" (×421).

Nothing new or regressed was introduced by the cleanup or the product-template redesign.
Method: crawled all 421 live sitemap URLs, extracted every visible text block (8,832 unique strings after de-duplication), ran pattern checks for internal/meta/truncated/robotic language, then manually read all 935 repeated template strings plus the unique copy on the homepage, hubs, product, trust, about, contact, colour, glass and commercial pages.

**Overall verdict:** the hand-written copy is good — the why-trust page, team bios, product intros, sash comparison and commercial hub all read like a real company talking to real customers. The problems cluster into seven repeatable patterns, almost all coming from three sources: template strings written for the site rather than the customer, the internal "route/specification" vocabulary leaking into public copy, and scraped article paragraphs that were truncated mid-sentence when the old site's inline links were stripped.

---

## 1. HIGH — Truncated scraped paragraphs that end mid-sentence

The scrape dropped inline link text, so ~25 paragraphs across ~20 article/guide pages stop dead or start mid-thought. These read as broken English to any customer. All live in `data/pages.json`. The worst examples:

| Page | Broken copy |
|---|---|
| `/glass-and-glazing-federation-ggf-standards/` | "we proudly follow the guidance set out by the" *(ends)* |
| `/what-are-integral-blinds/` | "you should specify integral blinds at the" *(ends)*; another paragraph **starts** ". Because the blinds are actually part of…"; "instead of hanging outside the window. This creates a" *(ends)* |
| `/are-my-windows-energy-efficient/` | "upgrade to triple or" *(ends)*; "contact us at" *(ends)* |
| `/condensation-on-new-windows/` | "Simply give us a call at" *(ends)* |
| `/how-to-know-when-to-replace-windows/` | "contact us at" *(ends)*; "can be tough to open for many reasons:" *(orphan fragment)* |
| `/choosing-the-right-front-door-for-your-home/` | "We are Fenster Glazing, specialise in the supply and installation of" *(ends)* |
| `/what-is-the-difference-between-upvc-vs-composite-doors/` | "Energy Efficient: Our composite doors," *(ends)*; "Our uPVC doors, built with" *(ends)* |
| `/different-types-of-window-frame-materials/` | "grows much faster and plentiful, making this less of an expensive option. In comparison," *(orphan fragment)*; "contact us at" *(ends)* |
| `/how-to-clean-your-upvc-windows-at-home/` | "For more information on UPVC windows, contact us at" *(ends)* |
| `/how-to-check-whether-your-planned-home-improvements-are-legal/` | "visit the" *(ends)*; "said," *(orphan)* |
| `/which-is-better-triple-or-acoustic-glazing/` | "get in" *(ends)* |
| `/a-guide-to-understanding-u-values/` | "get in touch with our team by filling our" *(ends)* |
| `/replacing-windows-doors-in-wolverton-mk/` | "explore product pricing using our" *(ends)* |
| `/what-front-doors-provide-the-best-security-for-your-home/` | "on fitting a" *(ends)* |
| `/choosing-the-right-colour-for-your-front-door/` | "please do contact us at" *(ends)* |
| `/what-is-a-door-lintel/` | "seek help from a building expert with experience installing a door lintel and" *(ends)* |
| `/healthcare-construction/` | "Thermal efficiency is a critical consideration in" *(ends)* |
| `/commercial-window-installation-in-healthcare/` | "One often overlooked but critical element is" *(ends)* |
| `/louvre-vents/` | "The louvre vents at" *(ends)* |
| `/soundproofing-solutions-how-to-choose-windows-for-a-quieter-home/` | "If you live on a busy street or in a noisy neighbourhood," *(ends)* |
| `/what-are-double-glazed-glass-windows/` | "(including traditional wood and uPVC) and" *(ends)* |
| `/glass-and-glazing-federation-ggf-standards/` | "the distance is" *(ends)*; "You can read it here:" *(link gone)* |

**Fix:** edit the paragraphs in `pages.json` — either complete the sentence ("…contact us at **01908 429200**", "…set out by the **Glass and Glazing Federation**") or delete the dangling clause. Most are one-line fixes and the missing words are obvious from context.

---

## 2. HIGH — Template copy that talks about the website, not to the customer

These render on every product page and are the clearest "non-customer-facing" offenders:

1. **The gallery paragraph — 25 pages** (`generated-page.php:541`):
   > "This casement windows gallery brings together **verified product imagery**, close-up frame details and related specification examples **so homeowners can compare**… before requesting a quote."
   Talks about the imagery's provenance and refers to the reader in the third person. Also produces mangled titles when the product name is long ("This double glazing replacement glass in milton keynes gallery…", "This exceptional roofline services gallery…", lowercase "french"/"upvc").
   *Suggested:* "See the styles, finishes and installed details up close — compare frame lines, glass options and colours before you ask for a price."

2. **The gallery bullets — 24 pages** (`generated-page.php:~2830`):
   > "Installed product examples and close-up details **from verified supplier imagery**." / "Matched to the product family **so the page stays visually accurate**."
   "Verified supplier imagery" and "the page stays visually accurate" are internal QA notes, not benefits.
   *Suggested:* "Real installed examples and close-up frame details." / "Every image shows this product family, so what you see is what gets fitted."

3. **The specification-choices paragraph — 33 pages** (`generated-page.php`):
   > "Colours, privacy glass and hardware **now live in focused guides so the product pages stay useful instead of turning into endless finish catalogues**."
   Explains the site's information architecture to the customer.
   *Suggested:* "Choose your colours, privacy glass and hardware in three quick guides — each one takes a minute."

4. **Product intro self-talk** (`inc/site-data.php` `product_content`):
   - `/aluminium-sliding-doors/`: "…rather than **treating the page as** a generic patio-door option."
   - `/patio-doors/`: "**On this site**, patio doors refer to uPVC sliding patio doors…" → "Our patio doors are uPVC sliding doors; if you want slimmer frames and bigger glass, see aluminium sliding doors."
   - `/casement-windows/` FAQ: "…supplied U-value information shown **in the key specifications strip**." ("strip" is UI-speak → "shown at the top of this page").

5. **Commercial projects "records"** (`/commercial-projects/`, x5 strings): "Additional commercial **records**", "Project **record**" — database language. → "More commercial projects" / "Project details".

---

## 3. HIGH — The internal "route" vocabulary has leaked into customer copy at scale

`HOMEPAGE.md` bans "route/journey/path" as internal template language, but it now appears in visible copy across ~60+ pages:

- **×47 county pages** (`commercial-county.php`): "…and the team can **confirm the best route**."
- `/why-trust-fenster/`: "A clear **route** from first conversation to aftercare", "Choose the right **route**", "a properly supported **installation route**", "compare … and **installation route**".
- `/commercial-glazing/`: "Confirm the **route**", "A practical **route** from brief to install", "identify the right glazing **route**".
- `/casement-windows/`: "usually the best value **route**", "Fenster specifies the 70mm Liniar EnergyPlus **route**".
- **×5 product pages** (window-handles card, `generated-page.php`): "Compare white, black, chrome, gold, satin silver and **monkey tail handle routes**" — "handle routes" is meaningless to a homeowner.

Customers don't buy "routes"; they buy options. Replace with *option / choice / approach / system / process* per instance ("confirm the best approach", "A clear process from brief to install", "monkey tail handle options").

---

## 4. HIGH — False or unsupportable claims

1. **"Live chat" doesn't exist.** `/commercial-automation/`, `/curtain-walling/` and `/louvre-vents/` (scraped FAQ in `pages.json`): "you can also speak directly to our expert sales team via phone or **live chat**". There is no chat on the site. Remove or change to "phone or email".
2. ~~**"Phone lines open 24/7"** — footer, all 421 pages.~~ **✅ Not a false claim. Closed 2026-07-16, reconfirmed 2026-07-20.** The 24/7 answering service is real, so the claim is accurate and stays as written. Do not re-raise it — see the confirmed-facts section in `AI.md`.

---

## 5. MEDIUM — The obscure→obscured rename left find/replace scars

Mid-sentence capital "Obscured" on live pages (a literal case-sensitive replace of "Obscure"):

- ×33 product pages (`generated-page.php:2865`): "Preview **Obscured** glass patterns and privacy levels…"
- `/obscured-glass/`: "All **Obscured** glass options at a glance.", "Ask Fenster which **Obscured** glass works with your product.", "Products that can use **Obscured** glass"

Lower-case it mid-sentence ("obscured glass"). Worth a repo-wide grep for `[a-z] Obscured` to catch any others.

---

## 6. MEDIUM — Scrape-era grammar and keyword-stuffed fragments still visible

- `/other-services/`: "**Fenster glazing are** home improvements specialists…" (brand lower-cased, "are" with singular brand) — appears twice, once ending in a bare ellipsis. Also the h3 "**Glazing, Integral Blinds & Cat Flaps Milton Keynes & Buckinghamshire**" — a keyword string, not a heading.
- Colon-orphan headings/paragraphs across articles ("Pros:", "Cons:", "Preparation:", "For Reference:", "Find out more about our suppliers here:" with nothing following) — mostly formatting casualties of the same link-stripping as §1; fix alongside it.
- ALL-CAPS scraped headings on `/what-is-a-door-lintel/` ("TIMBER LINTEL", "REINFORCED BRICK LINTEL"…).
- Imported related-link labels used verbatim: "**Market Leading** Double Glazing in X" (×13 towns), "**Exceptional Roofline Services**", "High Quality Double Glazing in Aylesbury" — shouty old-site title case in link text.

---

## 7. MEDIUM — Repetition inside matrix pages

On every town×product page the same "Survey checks…" sentence appears up to three times (benefit card, card + suffix "This helps the finished installation work properly once it is fitted.", and again as the FAQ answer prefixed "Yes."). And all 20 products share the identical sentence tail "…so the finished installation feels right for the room and the outside of the property" (260 pages). Not broken, but it reads templated the moment someone compares two sections. Cheap improvement: vary the FAQ phrasing away from the card phrasing, and write 3–4 alternative tails.

---

## 8. LOW — Micro-polish list

- Footer: "Made in house by Zac **.**" — stray space before the full stop (all 421 pages).
- Review cards mix date formats: "2025-06-01" (ISO) next to "14 Nov 2025". Pick the human format.
- Unit inconsistency: "1.2 **W/m2K**" on the sash spec table vs "W/m²K" elsewhere; also bare "**A rated**" cell vs "A+ rated" elsewhere.
- Title-case drift on scraped CTAs: "Get in Touch", "Book A Consultation" vs the site's sentence case.
- Buttons render a literal ASCII "->" arrow (`<i>-&gt;</i>`) rather than a proper arrow/icon.
- Lazy-load helper copy is slightly techy: "The designer loads after the page settles" / "Loads when you reach this section" — fine, but "settles" is odd; consider "The designer loads in a moment — or tap to open it now."

**Not bugs (checked and cleared):** "Commercial Commercial Glazing", "Aluminium Flush Flush lines…", "Maintenance Maintenance-free" — these looked like duplications in extraction but are nested nav/label+value markup that renders correctly. The consent banner copy, cookie/privacy/terms legal text, team bios (including Legend the Chief Meow Officer), why-trust narrative, colour hub, obscured-glass visualiser guidance and commercial hub v2 copy all read well.

---

## Suggested fix order

1. §4 false claims — only the "live chat" wording remains; the 24/7 claim is confirmed accurate and closed.
2. §2 template self-talk (5 strings in `generated-page.php` + 2 in `site-data.php`) — fixes 30+ pages per string.
3. §5 "Obscured" casing (2 files) — visible on 36 pages.
4. §3 "route" vocabulary — one county template string fixes 47 pages; then trust/commercial/casement instances.
5. §1 + §6 truncated/scrape debris in `pages.json` — ~30 small edits, one sitting.
6. §7 matrix variation and §8 polish — batch when convenient.
