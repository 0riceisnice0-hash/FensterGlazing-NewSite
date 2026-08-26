# Fenster Glazing Handover

This root-level file is a legacy pointer only.

The tracked, current handover is:

`app/public/HANDOVER.md`

Deployment/live-change instructions are in:

`app/public/LIVECHANGES.md`

The active local theme is:

`app/public/wp-content/themes/fenster`

Do not use the old notes that mentioned a live Three.js homepage as the current architecture. The live site is the custom `fenster` theme deployed through GitHub/SiteGround theme-only rsync, with current docs under `app/public`.

**This file no longer carries a live SHA, and that is deliberate.** `AI.md` has required since 2026-08-04 that the live pointer lives in `LIVECHANGES.md` and nowhere else, because three files each carried a different stale copy of it. This one carried `dac7007` from 2026-08-06 for twenty days, along with the claim that live was deliberately not the tip of `main` — which stopped being true on 2026-08-16 and has been false through five consecutive releases since. **Read the Current Truth section of `app/public/LIVECHANGES.md`, and re-establish live by checksum before any deploy rather than trusting any recorded line.**
