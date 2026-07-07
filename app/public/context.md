# Fenster Glazing Site Context

Last updated: 2026-07-07

This document is for a personal GPT or strategy assistant. It is not a coding handover. It explains what the Fenster Glazing website is trying to do, how the site is structured, how the customer experience works, what the SEO strategy is, what the important pages mean, what has recently changed, and what still needs thought.

Use this document to have informed conversations about the site, its content, its customer journey, its SEO direction, its strengths, and its risks.

## 1. The Business

Fenster Glazing is a UK glazing company serving homeowners, landlords, developers, businesses and commercial buyers.

The business sells and installs products such as:

- uPVC windows.
- Aluminium windows.
- Sliding sash windows.
- Composite doors.
- uPVC doors.
- Aluminium doors.
- Bifold doors.
- Sliding patio doors.
- French doors.
- Heritage style products.
- Integral blinds.
- Secondary glazing.
- Replacement glazed units.
- Cat flaps and dog flaps in doors/glass.
- Commercial glazing.
- Repairs and other glazing services.

The business needs the website to create trust quickly, explain options clearly, and turn visitors into enquiries, calls, and online quote starts.

The site is not just a brochure. It is the main digital sales journey.

## 2. The Site's Core Job

The website has four main jobs.

1. Help people understand what Fenster does.
2. Help people choose the right product or service route.
3. Build enough confidence for them to enquire.
4. Capture leads through forms, phone calls, and WindowCAD/online quote submissions.

The site needs to work for several different visitor mindsets:

- "I know I need new windows, but I do not know what type."
- "I know exactly what I want and need a price."
- "I am comparing local companies."
- "I need commercial glazing and want proof they can handle it."
- "I have a specific problem, such as blown glass, a door panel, or a cat flap."
- "I came from Google on a town/product search and need to know if they serve my area."

Good pages should move the visitor from uncertainty to a clear next step.

## 3. Brand Positioning

Fenster should come across as:

- Premium but practical.
- Professional without sounding corporate.
- Local and approachable.
- Experienced and trustworthy.
- Clear rather than salesy.
- Helpful rather than pushy.
- Modern but not gimmicky.

Avoid making Fenster sound like:

- A generic national double glazing lead-gen site.
- A cheap local trades directory listing.
- A scraped content site.
- A brochure copied from manufacturers.
- An over-designed agency template.

The tone should be confident, plain-English, and useful.

## 4. Customer Experience Principles

The site should help people make decisions.

Important UX principles:

- Every important page should have a clear next step.
- Product pages should explain choices, not just list features.
- Trust evidence should appear before the user is asked to commit.
- Forms should feel easy and safe.
- Phone and quote routes should be visible.
- Mobile should feel deliberately designed, not squeezed.
- Technical claims should be specific only when known.
- If the user lands on a deep SEO page, they should still understand who Fenster is and what to do next.

The ideal visitor journey is:

1. Arrive from Google, direct, referral, or ad.
2. Quickly understand the relevant product/service.
3. See enough trust proof to keep going.
4. Compare main choices.
5. Start a quote, call, or submit an enquiry.

## 5. The Main Conversion Routes

The site has several lead paths.

### Phone

Phone calls are important because many glazing customers want reassurance before committing.

The phone path should feel immediate and human, especially for:

- Repairs.
- Urgent replacement glass.
- Commercial enquiries.
- Complicated product choices.
- Older or less technical users.

### Enquiry Forms

Forms are for people who want a callback, want to describe a project, or want to attach drawings/photos.

Forms should gather enough context without feeling like a long survey.

Useful form fields include:

- Name.
- Email.
- Phone.
- Postcode/location.
- Project type.
- Timescale.
- Message/details.
- Optional files/photos/drawings.

### Online Quote / WindowCAD

The online quote tool is powered by WindowCAD. It lets people configure windows/doors, view/save a design, and send project details.

Important current fact:

- WindowCAD lead submission should send data to a WordPress endpoint.
- WordPress then relays the lead into AdminBase.
- The user may see "Failed to fetch" if WindowCAD is pointed at a blocked/test endpoint or the browser cannot reach the callback.

WindowCAD is an important conversion asset, but it should not be the only lead path because some users prefer a normal form or phone call.

### AdminBase

AdminBase is the CRM/lead system that should receive leads from WindowCAD and website enquiries.

The intended flow is:

WindowCAD or site form -> website receives lead -> website relays lead to AdminBase -> Fenster can manage the lead in the business process.

If AdminBase leads do not appear, the first question is whether the website received the lead at all. If WordPress has no saved WindowCAD enquiry, the problem is upstream from the website relay.

## 6. Website Structure In Plain English

The site has several page types.

### Homepage

The homepage is the first impression and broad routing page.

It should:

- Show Fenster as a serious glazing company.
- Establish trust quickly.
- Route users into products, quote, contact, and service areas.
- Give people enough confidence to continue.
- Avoid looking like a generic template.

The homepage uses premium visual assets, but performance matters. Heavy video/media should not make the first mobile load feel slow.

### Product Pages

Product pages explain specific windows, doors, and glazing products.

They should answer:

- What is this product?
- Who is it for?
- What choices matter?
- What are the key performance/security/appearance benefits?
- What should the customer do next?

Product pages should not be generic manufacturer brochures. They should connect the product to real customer decisions.

The current product-page direction is deliberately cleaner than the earlier version. Product pages should have a clear reading path, a balanced rhythm between images and text, and no repeated images. The main explanatory section is called `Product information` followed by the product name, not "Why choose this product?" The deeper product hub uses `More information on [product]`, not "explained properly" wording.

Only FAQs should use accordions. Product information, benefits and specification details should be visible without making the visitor open lots of panels. The old survey summary, common choices strip, quote option card, accreditations/systems filler block and inline window-handle chooser have been removed because they made the page feel busy rather than useful.

### Service Pages

Service pages cover specific jobs such as repairs, replacement glass, cat flaps/dog flaps, secondary glazing, and other practical needs.

These pages should be straightforward and problem-led. People landing on them usually have a specific issue and want to know if Fenster can solve it.

### Commercial Pages

Commercial pages are for businesses, landlords, developers, schools, offices, retail spaces, and larger projects.

Commercial users need:

- Proof of competence.
- Clear scope.
- Professional tone.
- Fast contact options.
- Confidence that Fenster can handle complexity.

Commercial pages should not read like residential homeowner pages with the word "commercial" added.

### Location Pages

Location pages help people searching by area and product.

They should:

- Confirm Fenster covers the area.
- Match the product/service intent.
- Avoid thin duplicate copy.
- Link users back into useful product and contact routes.

The risk with location SEO is creating lots of pages that feel duplicated or low value. The site should use location pages carefully and make them useful.

### Guide / Article Pages

Guides and articles should answer research questions and support SEO.

They are useful for:

- Long-tail informational searches.
- Explaining choices.
- Helping customers before they are ready to enquire.
- Building topical authority.

Guides should still include a sensible next step, but they should not feel like hard-sell landing pages.

### Legal / Utility Pages

Pages such as terms and privacy policy must be reliable and reachable. A previous issue meant the Terms link sent people to Privacy Policy, which was a legal/navigation problem.

These pages are not conversion pages, but they affect trust.

## 7. Homepage Experience

The homepage should feel like a polished front door to the business.

Key homepage roles:

- Create immediate confidence.
- Show the breadth of products.
- Offer fast quote/contact routes.
- Display reviews/trust/accreditations.
- Route people into product categories.
- Support local relevance.

The homepage should not become:

- A giant generic hero with no usable route.
- A decorative page with weak information.
- A slow media-heavy page that hurts mobile experience.
- A list of SEO links without brand feel.

Good homepage discussion topics:

- Is the hero saying enough about Fenster?
- Are the next steps obvious?
- Does the page make the business feel trustworthy?
- Does it help both homeowners and commercial buyers?
- Are reviews/trust signals visible enough without taking over?
- Is the online quote path obvious but not overbearing?

## 8. Product Experience

The product pages are central to the site.

A strong product page should include:

- Clear product title.
- Plain-English intro.
- Key benefits.
- Important specs where known.
- Real choices the customer needs to make.
- Trust proof.
- Quote/contact route.
- Links to related decisions such as colours, glass, handles, or hardware.

Product pages should avoid:

- Scraped copy.
- Overly generic "beautiful addition to your home" wording.
- Unsupported technical claims.
- Huge irrelevant galleries.
- Too many choices on one page.
- Hiding the quote/contact action.
- Repeating the same hero or product image further down the page.
- Internal or supplier-facing wording that sounds like a developer note rather than customer copy.

The best product pages behave like buying guides, not just SEO landing pages.

## 9. Important Product Routes

### Casement Windows

Likely one of the main residential window pages. It should cover everyday uPVC window replacement, energy performance, security, colour/hardware choices, and quote route.

### Flush Casement Windows

Should explain the cleaner, flatter appearance and why someone might choose flush casements over standard casements.

### Tilt And Turn Windows

Should explain ventilation, inward opening, cleaning access, and suitability for certain rooms/buildings.

### Sliding Sash Windows

This is a Roseview-led page. It should not be generic uPVC window copy.

Important details:

- Roseview is the key product system.
- Models include Ultimate Rose, Heritage Rose, and Charisma Rose.
- The page should explain sash-specific details and traditional appearance.
- It should be useful for period homes and conservation-sensitive projects.

### Aluminium Windows

Should emphasise slimmer sightlines, strength, modern appearance, durability, and suitability for contemporary projects.

### Composite Doors

Should focus on entrance security, appearance, colour choices, insulation, and kerb appeal.

### uPVC Doors

Should feel practical and value-focused while still premium enough for Fenster.

### Aluminium Bifold Doors

Should explain opening up spaces, sightlines, thresholds, panels, security, and survey/installation considerations.

### Aluminium Sliding Doors

Should explain large glass areas, slim frames, views, and modern patio/opening designs.

### Heritage Aluminium Doors

Should speak to steel-look style, partitions, heritage appearance, and design-led buyers.

### Integral Blinds

Should explain blinds sealed inside glazing, privacy, low maintenance, and control options such as magnetic or electric.

### Secondary Glazing

Should explain noise reduction, thermal improvement, listed/period suitability, and when it is preferable to full replacement.

### Replacement Glazed Units

Should be problem-led: misted/blown glass, failed sealed units, cracked panes, upgraded glass.

### Cat And Dog Flaps

This page was rewritten because the old scraped copy was poor.

It should explain:

- Whether a flap goes into a door panel or a new sealed glass unit.
- Manual, lockable, and microchip options.
- Pet size and fitting height.
- Why a survey/check matters.
- Why not every existing glass unit can simply be cut.

The page should feel practical and reassuring, not like a generic pet product page.

## 10. Colour And Detail Hubs

The site uses supporting hubs for product choices.

### Colour Options

The canonical colour hub is `/colour-options/`.

It should help customers understand available colour/finish choices across uPVC and aluminium without overwhelming every product page.

The colour hub should be customer-friendly. It should not expose supplier scrape labels or internal provenance.

### Obscured Glass

The canonical route is `/obscured-glass/`.

This page should help people understand privacy glass choices for bathrooms, doors, side panels, and overlooked spaces.

### Handles And Hardware

Hardware details are useful but should not dominate product pages. They should support decisions such as colour, finish, appearance, and security.

Window handles now have a separate `/window-handles/` hub rather than a full chooser embedded on every product page. Product pages can link to that hub from specification-choice cards. The accepted customer-facing finishes include White, Black, Chrome, Gold, Satin Silver and Monkey Tail. The point is to help customers understand finish and locking choices without making every product page feel like a catalogue.

## 11. Commercial Glazing

Commercial glazing should have its own feel.

Commercial buyers care about:

- Reliability.
- Professional communication.
- Scope and capability.
- Timescales.
- Compliance and safety.
- Previous project proof.
- Clear contact routes.

Commercial pages should use stronger proof and more direct language than residential pages.

Good commercial content should answer:

- What kinds of commercial projects does Fenster handle?
- Who does Fenster work with?
- What information should a buyer provide?
- How quickly can someone speak to the team?
- What makes Fenster credible for commercial work?

Known issue to keep in mind:

- Some older commercial/project links may need review because old residential case-study routes were intentionally removed or hidden.

## 12. Local And SEO Strategy

The site needs local SEO, but it must avoid becoming a duplicate-page farm.

The local SEO strategy is broadly:

- Main product/service pages for core intent.
- Location/product pages where there is useful search demand.
- Area coverage pages that confirm service areas.
- Commercial county/location pages where they make sense.
- Guides/articles for informational searches.

SEO should prioritise:

- Accurate titles and descriptions.
- Clear H1s.
- Useful page copy.
- Strong internal linking.
- Avoiding duplicate/thin pages.
- Correct canonical URLs.
- Noindexing weak utility pages.
- Clean sitemap/indexation.
- Avoiding old test-domain or scraped metadata.

The site previously had many imported pages from old/scraped content. The live strategy is to clean and control those pages rather than blindly publish everything.

## 13. Indexation And Duplicate Risks

Important SEO risks that have been addressed or need watching:

- The test site was publicly crawlable and could dilute the live domain. It is now password protected.
- `www.fensterglazing.com` previously served a duplicate 200 version. It should redirect to the apex domain.
- Some old redirects hijacked useful pages, including Terms and a Northampton bifold page. These were fixed.
- Thin utility pages should not be in the sitemap.
- Old imported metadata/schema can be harmful if rendered publicly.
- Old test-domain references should not appear in public SEO output.

The canonical public domain is:

`https://fensterglazing.com/`

## 14. Trust And Proof

Trust is central in glazing because customers are making expensive, home-impacting decisions.

Useful trust signals include:

- Reviews.
- Local presence.
- Accreditations.
- Product/system partners.
- Real project imagery.
- Clear contact details.
- Professional email/form experience.
- Useful technical explanations.
- Transparent next steps.

Trust signals should be visible but not fake-looking. Avoid exaggerated or unsupported claims.

Review/platform claims should be kept accurate. If a review count or platform rating is shown, it should match visible evidence.

## 15. Accessibility And Mobile Experience

Mobile matters heavily because many users will browse from phones.

Mobile pages should:

- Load quickly enough.
- Avoid horizontal scrolling.
- Keep buttons easy to tap.
- Keep forms readable.
- Avoid tiny controls.
- Put important actions near the user.
- Avoid hover-only interactions.
- Use clear text hierarchy.

Accessibility matters because it affects both real users and site quality.

Important accessibility concerns:

- Text contrast.
- Touch target size.
- Links distinguishable beyond colour.
- Correct form labels.
- Correct ARIA use.
- Keyboard/focus behaviour.

## 16. Performance

Performance is important because the site uses strong visuals and media.

The current performance direction is:

- Keep the premium feel.
- Avoid loading heavy video/iframes too early.
- Use lightweight first visuals on mobile.
- Defer quote tools and heavy media until needed.
- Compress/optimise images where possible.
- Keep first content and main content fast.

The site previously had poor mobile Lighthouse symptoms, especially around FCP/LCP and total payload. Performance has improved, but it remains a topic to watch because videos, iframes, fonts and images can easily make glazing sites slow.

Good performance conversation topics:

- Does the homepage need lighter mobile video?
- Are images sized correctly?
- Are quote iframes loading only when useful?
- Are tracking scripts gated and not slowing first load?
- Are the most important visual assets compressed?

## 17. Consent And Tracking

The site uses tracking such as GTM, Microsoft Clarity and Meta Pixel.

Because this is a UK site, optional tracking should not run before consent.

Current principle:

- Tracking should be consent-gated.
- Clarity/GTM/Meta should not fire before acceptance.
- Conversion events should eventually be tracked for forms, phone calls, and quote tool starts/submissions.

Useful future tracking events:

- Form successfully submitted.
- Phone link clicked.
- Online quote opened.
- WindowCAD project saved/submitted.
- Contact route clicked.
- Commercial enquiry submitted.

Tracking should help understand user behaviour without breaking consent rules.

## 18. Legal And Utility Pages

Legal and utility pages are not glamorous, but they matter.

The footer Terms link previously went to Privacy Policy because of a bad redirect. This was fixed.

Important utility pages:

- Terms and Conditions.
- Privacy Policy.
- Contact.
- Areas covered.
- Sitemap.

These pages should be reliable, reachable and consistent.

## 19. Current Known Issues And Discussion Topics

These are the main issues worth discussing with a personal GPT or strategy assistant.

### WindowCAD / AdminBase

The intended flow is restored. A previous "Failed to fetch" episode was caused by WindowCAD still pointing at the protected test endpoint from an old session; once refreshed/pointed correctly, the lead path worked again. If the same message returns, it usually means the WindowCAD callback URL is blocked, wrong, or failing in the browser before WordPress receives the payload.

The correct live callback should be:

`https://fensterglazing.com/wp-json/fenster/v1/windowcad`

If leads do not arrive:

- Check whether a private WindowCAD enquiry was saved in WordPress.
- If not, WindowCAD likely did not reach the website.
- If yes, check whether AdminBase accepted the relay.

### Spam Protection

The forms need stronger spam protection, but it must not hurt conversions.

Possible approaches:

- A simple honeypot.
- A time-based check.
- Cloudflare Turnstile.
- Server-side scoring.

### Conversion Tracking

The site still needs better lead event tracking.

Priorities:

- Successful enquiry submission.
- Phone clicks.
- Quote tool opens.
- WindowCAD save/submission.
- Commercial enquiry.

### Commercial Proof

Commercial pages should continue to improve with stronger proof, better project examples, and clearer buyer language.

### Meta Descriptions

Some pages may still have long or weak meta descriptions. These should be tightened for search snippets and clarity.

### Social Sharing Image

The OpenGraph/social image should be compressed and appropriate for sharing.

### Duplicate Or Thin Pages

The site should continue to avoid publishing weak duplicated pages just for SEO coverage.

## 20. Content Quality Rules

Good Fenster content should:

- Sound like a real local glazing company.
- Explain practical decisions.
- Use plain English.
- Avoid generic filler.
- Avoid unsupported claims.
- Be clear about product differences.
- Make the next step obvious.
- Match the search intent of the page.

Weak content usually:

- Repeats "stunning addition to your home" style language.
- Talks around the topic without answering practical questions.
- Uses scraped fragments.
- Mentions brands/systems inaccurately.
- Makes every page sound the same.
- Pushes a quote before building enough context.

## 21. How To Talk About The Site

When discussing the site with a GPT, useful prompts include:

- "How can this page better match the visitor's intent?"
- "What trust objections would a customer still have?"
- "Is this product page helping someone choose, or just describing?"
- "What would make this commercial page more credible?"
- "Where is the next step unclear?"
- "Could this SEO page be seen as thin or duplicate?"
- "What questions would a homeowner ask before enquiring?"
- "What would stop someone from using the online quote tool?"
- "How can we improve conversion without making the site feel pushy?"

The GPT should think like a mix of:

- SEO strategist.
- UX researcher.
- Conversion copywriter.
- Local business advisor.
- Customer journey analyst.

It should not assume it is editing code.

## 22. Big Picture Summary

Fenster Glazing's site is a custom, premium, SEO-aware lead-generation website for a real glazing company.

The strongest version of the site is:

- Fast enough on mobile.
- Clear enough for homeowners.
- Credible enough for commercial buyers.
- Structured enough for SEO.
- Practical enough to answer real product questions.
- Trustworthy enough to earn enquiries.
- Connected enough that WindowCAD/forms/phone leads flow into the business.

The main ongoing challenge is balance:

- Premium visuals without slow load.
- SEO coverage without thin duplication.
- Conversion prompts without pushiness.
- Technical product detail without overwhelming users.
- Automation into AdminBase without losing reliability.

For strategic discussion, always ask: does this make it easier for the right customer to trust Fenster and take the next useful step?
