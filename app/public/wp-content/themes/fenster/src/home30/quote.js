/**
 * HOMEPAGE 3.0 — the instant pricing frame.
 *
 * The WindowCAD tool is a third-party origin and the heaviest thing on the
 * page, so the iframe ships with no `src` at all. It is filled in when the
 * band is nearly in view, or straight away if someone presses the button in
 * the placeholder. Either way it loads once.
 *
 * The frame is only revealed after it reports back, so a slow third party
 * shows the placeholder rather than a white rectangle.
 */

export function initQuoteFrame() {
    var host = document.querySelector('[data-h30-quote]');

    if (!host) {
        return;
    }

    var frame = host.querySelector('iframe');
    var button = host.querySelector('[data-h30-quote-load]');
    var src = host.getAttribute('data-h30-quote-src');
    var loaded = false;

    if (!frame || !src) {
        return;
    }

    function load() {
        if (loaded) {
            return;
        }
        loaded = true;

        frame.addEventListener('load', function () {
            host.classList.add('is-ready');
        });

        frame.setAttribute('src', src);
        host.setAttribute('data-h30-quote-state', 'loading');
    }

    if (button) {
        button.addEventListener('click', load);
    }

    /* FULL SCREEN. The tool is a designer, and a designer in a half column is
       cramped on any screen. This is the same move the other quote pages make:
       ask the wrapper to go full screen, and if the browser will not, open the
       designer in a tab so the visitor is never left with nothing. */
    var expand = host.querySelector('[data-h30-quote-expand]');

    if (expand) {
        expand.addEventListener('click', function () {
            load();

            if (host.requestFullscreen) {
                host.requestFullscreen().catch(function () {
                    window.open(src, '_blank', 'noopener');
                });
                return;
            }

            if (host.webkitRequestFullscreen) {   // older iOS Safari
                host.webkitRequestFullscreen();
                return;
            }

            window.open(src, '_blank', 'noopener');
        });
    }

    // No observer, no waiting: an older browser gets the tool immediately.
    if (typeof IntersectionObserver !== 'function') {
        load();
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }
            observer.disconnect();
            load();
        });
    }, {rootMargin: '400px 0px'});

    observer.observe(host);
}
