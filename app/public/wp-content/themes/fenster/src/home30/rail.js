/**
 * HOMEPAGE 3.0 — the case-study rail.
 *
 * One row of cards that scrolls sideways with snap points, prev/next arrows,
 * and a slow auto-advance. The rail is plain CSS overflow, so it scrolls by
 * finger, by trackpad and by keyboard with no script at all; this module only
 * adds the arrows and the drift.
 *
 * THE DRIFT IS POLITE. It waits until the rail is on screen, pauses while the
 * pointer is over it, while anything inside it has focus, and while a finger
 * is on it; it stops for good the first time someone uses an arrow, because
 * a carousel that fights the person driving it is worse than none; and it
 * never runs at all when the visitor has asked their system for reduced
 * motion. It also skips hidden cards, so the filters and the drift agree.
 */

export function initProjectRail() {
    var section = document.querySelector('[data-h30-projects]');
    var rail = section && section.querySelector('[data-h30-rail]');

    if (!rail) {
        return;
    }

    var prev = section.querySelector('[data-h30-rail-prev]');
    var next = section.querySelector('[data-h30-rail-next]');
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var behavior = reduceMotion ? 'auto' : 'smooth';

    function cards() {
        return Array.prototype.filter.call(rail.children, function (card) { return !card.hidden; });
    }

    /** Index of the card whose left edge is nearest the rail's left edge. */
    function currentIndex() {
        var list = cards();
        var left = rail.scrollLeft;
        var best = 0;
        var bestDistance = Infinity;
        list.forEach(function (card, index) {
            var distance = Math.abs(card.offsetLeft - left);
            if (distance < bestDistance) {
                bestDistance = distance;
                best = index;
            }
        });
        return best;
    }

    function goTo(index) {
        var list = cards();
        if (!list.length) {
            return;
        }
        var target = list[(index + list.length) % list.length];
        rail.scrollTo({left: target.offsetLeft - rail.offsetLeft, behavior: behavior});
    }

    function syncArrows() {
        var atStart = rail.scrollLeft <= 2;
        var atEnd = rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 2;
        if (prev) { prev.disabled = atStart; }
        if (next) { next.disabled = atEnd; }
    }

    /* ---- Arrows ------------------------------------------------------- */

    var driven = false;   // once true, the drift stays off

    if (prev) {
        prev.addEventListener('click', function () { driven = true; goTo(currentIndex() - 1); });
    }
    if (next) {
        next.addEventListener('click', function () { driven = true; goTo(currentIndex() + 1); });
    }

    rail.addEventListener('scroll', syncArrows, {passive: true});
    window.addEventListener('resize', syncArrows);
    syncArrows();

    /* ---- Drift -------------------------------------------------------- */

    if (reduceMotion || typeof IntersectionObserver !== 'function') {
        return;
    }

    var onScreen = false;
    var paused = false;
    var timer = null;
    var INTERVAL = 5500;

    function tick() {
        if (driven || !onScreen || paused || document.hidden) {
            return;
        }
        var list = cards();
        if (list.length < 2) {
            return;
        }
        var atEnd = rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 2;
        goTo(atEnd ? 0 : currentIndex() + 1);
    }

    function arm() {
        if (timer) { return; }
        timer = window.setInterval(tick, INTERVAL);
    }

    function disarm() {
        if (timer) { window.clearInterval(timer); timer = null; }
    }

    rail.addEventListener('pointerenter', function () { paused = true; });
    rail.addEventListener('pointerleave', function () { paused = false; });
    rail.addEventListener('touchstart', function () { paused = true; }, {passive: true});
    rail.addEventListener('touchend', function () { window.setTimeout(function () { paused = false; }, 4000); }, {passive: true});
    rail.addEventListener('focusin', function () { paused = true; });
    rail.addEventListener('focusout', function (event) { if (!rail.contains(event.relatedTarget)) { paused = false; } });

    new IntersectionObserver(function (entries) {
        onScreen = entries.some(function (entry) { return entry.isIntersecting; });
        if (onScreen) { arm(); } else { disarm(); }
    }, {threshold: 0.4}).observe(rail);

    section.setAttribute('data-h30-rail-drift', 'armed');
}
