# Fenster Glazing AI Notes

This root-level file is a legacy pointer only.

The tracked, current AI rulebook is:

`app/public/AI.md`

For a new chat, start by reading these tracked docs in order:

1. `app/public/AI.md` — the rulebook.
2. `app/public/HANDOVER.md` — current state and architecture.
3. `app/public/LIVECHANGES.md` — **read the Current Truth section before anything else if you are deploying.** It is the only authority on what is live.
4. `app/public/STYLE.md` — the visual contract.
5. `app/public/TONEOFVOICE.md` — required before writing or rewriting any customer-facing copy.
6. `app/public/LIVECHAT.md` — the Legend assistant.
7. `app/public/CASESTUDIES.md` — required before touching a case study.
8. `app/public/PROGRESS.md` — dated work log. Its START HERE block runs behind `LIVECHANGES.md`; where they disagree, `LIVECHANGES.md` is right.
9. `app/public/AUDIT.md` — the 2026-07-03 master audit, largely historical.

The GitHub repo is:

`https://github.com/0riceisnice0-hash/FensterGlazing-NewSite`

**This file no longer carries a live SHA, and that is deliberate.** `app/public/AI.md` has required since 2026-08-04 that the live pointer lives in `LIVECHANGES.md` and nowhere else, because three files each carried a different stale copy of it. This one carried `dac7007` from 2026-08-06 for twenty days, along with the claim that live was deliberately not the tip of `main` — which stopped being true on 2026-08-16 and has been false through five consecutive releases since. **Read the Current Truth section of `app/public/LIVECHANGES.md`, and re-establish live by checksum before any deploy rather than trusting any recorded line.**

If you are working from the home PC rather than the work machine, also read `app/public/WORK-AT-HOME.md`.
