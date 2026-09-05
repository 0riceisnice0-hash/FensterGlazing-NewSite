/**
 * HOMEPAGE 3.0 — the instant pricing frame.
 *
 * THIS FILE USED TO LOAD THE FRAME, AND THAT WAS THE FAULT. It set the bare
 * WindowCAD URL, so a quote started on the homepage carried no Tracking value
 * and nothing recorded that it had started. Found 2026-09-05 while chasing a
 * dip in leads: `/online-quote/` stamped `&tracking=FG2-...` on its frame and
 * the homepage stamped nothing, and the dashboard's quote-start count could
 * only see the former.
 *
 * Loading now belongs to `main.js`, which owns every other quote frame on the
 * site through `[data-quote-frame-wrap]`: it stamps the journey reference (or
 * the ad reference, or the consent state) into the URL, fires
 * `quote_iframe_loaded`, re-stamps if the visitor changes their consent, and
 * will not reload a frame somebody has started using. The load button and the
 * full-screen button are wired to it in the template. Do not add a second
 * loader here; two loaders is exactly how the stamp got lost.
 *
 * What is left is the reveal: the frame is kept invisible until the third
 * party reports back, so a slow WindowCAD shows the placeholder rather than a
 * white rectangle. `main.js` loads after this bundle's dependency, so the
 * `load` event is the only hook this file needs.
 */

export function initQuoteFrame() {
    var host = document.querySelector('[data-h30-quote]');

    if (!host) {
        return;
    }

    var frame = host.querySelector('iframe');

    if (!frame) {
        return;
    }

    frame.addEventListener('load', function () {
        // An empty iframe can fire `load` for about:blank; only a real
        // WindowCAD load reveals the frame.
        if (frame.getAttribute('src')) {
            host.classList.add('is-ready');
        }
    });
}
