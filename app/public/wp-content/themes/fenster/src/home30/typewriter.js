/**
 * HOMEPAGE 3.0 — the typed headline.
 *
 * The headline writes itself out, holds, deletes and moves to the next line,
 * with a caret blinking at the end of it. The point is to show a homeowner
 * the sort of thing they can ask for, in their own words, without making them
 * read a list.
 *
 * WHAT THE MARKUP GUARANTEES, AND WHY THIS FILE CAN BE SAFE TO REMOVE.
 * The <h1> carries a complete, static sentence for screen readers and for
 * anyone without JavaScript. The animated part sits beside it, hidden from
 * assistive technology, so the heading a screen reader announces never
 * changes under it and the section's accessible name stays put. If this
 * script never runs, the page still reads correctly.
 *
 * It also holds its height. The heading reserves two lines whatever is in it,
 * because the hero is fitted to a single screen and a line count that changes
 * every few seconds would push the search box up and down the page.
 */

var TYPE_MS = 55;      // per character, going out
var DELETE_MS = 28;    // per character, coming back
var HOLD_MS = 2400;    // how long a finished line stays up
var GAP_MS = 420;      // the beat between deleting one and typing the next

export function initHeadline() {
    var host = document.querySelector('[data-h30-type]');

    if (!host) {
        return;
    }

    var slot = host.querySelector('[data-h30-type-text]');
    var phrases;

    try {
        phrases = JSON.parse(host.getAttribute('data-h30-phrases'));
    } catch (error) {
        phrases = null;
    }

    if (!slot || !Array.isArray(phrases) || phrases.length < 2) {
        return;
    }

    /* Someone who has asked their system for less motion gets the first line,
       standing still, with no caret pulsing at them. */
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    host.setAttribute('data-h30-type-state', 'running');

    var index = 0;
    var timer = null;

    function after(ms, next) {
        timer = window.setTimeout(next, ms);
    }

    /* Nothing should tick while the tab is in the background: the work is
       invisible there and it only costs the visitor battery. */
    function whenVisible(next) {
        if (!document.hidden) {
            next();
            return;
        }
        var resume = function () {
            if (document.hidden) {
                return;
            }
            document.removeEventListener('visibilitychange', resume);
            next();
        };
        document.addEventListener('visibilitychange', resume);
    }

    function type(text, position) {
        slot.textContent = text.slice(0, position);

        if (position < text.length) {
            // A little jitter, so it reads as typing rather than as a machine.
            after(TYPE_MS * (0.7 + Math.random() * 0.6), function () {
                type(text, position + 1);
            });
            return;
        }

        after(HOLD_MS, function () {
            whenVisible(function () { erase(text, text.length); });
        });
    }

    function erase(text, position) {
        slot.textContent = text.slice(0, position);

        if (position > 0) {
            after(DELETE_MS, function () { erase(text, position - 1); });
            return;
        }

        index = (index + 1) % phrases.length;
        after(GAP_MS, function () {
            whenVisible(function () { type(phrases[index], 0); });
        });
    }

    // The first line is already on the page, so hold it before erasing it.
    after(HOLD_MS, function () {
        whenVisible(function () { erase(phrases[0], phrases[0].length); });
    });

    window.addEventListener('pagehide', function () {
        if (timer) { window.clearTimeout(timer); }
    });
}
