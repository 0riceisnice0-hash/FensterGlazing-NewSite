# Fenster Glazing Handover

This root-level file is a legacy pointer only.

The tracked, current handover is:

`app/public/HANDOVER.md`

Deployment/live-change instructions are in:

`app/public/LIVECHANGES.md`

The active local theme is:

`app/public/wp-content/themes/fenster`

Do not use the old notes that mentioned a live Three.js homepage as the current architecture. The live site is the custom `fenster` theme deployed through GitHub/SiteGround theme-only rsync, with current docs under `app/public`.

Latest known live theme commit when this pointer was updated: `c97aff4` on `fix/windowcad-payload-limit` (2026-08-03 WindowCAD payload-cap fix, on top of the 2 Aug `a8f8388` cat-flaps release). Both were established by checksum, not by trusting a note. This line previously read `616d673` while live had moved on twice, so re-establish by checksum before any deploy rather than trusting it.
