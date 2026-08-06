# Fenster Glazing Handover

This root-level file is a legacy pointer only.

The tracked, current handover is:

`app/public/HANDOVER.md`

Deployment/live-change instructions are in:

`app/public/LIVECHANGES.md`

The active local theme is:

`app/public/wp-content/themes/fenster`

Do not use the old notes that mentioned a live Three.js homepage as the current architecture. The live site is the custom `fenster` theme deployed through GitHub/SiteGround theme-only rsync, with current docs under `app/public`.

Latest known live theme commit when this pointer was updated: `dac7007` on `release/flush-and-glass` (2026-08-06, flush casement rebuild and the obscured glass hub). **Live is deliberately NOT the tip of `main`**, which additionally carries an unapproved online-quote strand from a parallel session — deploying `main` ships it. Established by checksum immediately before each rsync and re-verified after it. Re-establish by checksum before any deploy rather than trusting this line.
