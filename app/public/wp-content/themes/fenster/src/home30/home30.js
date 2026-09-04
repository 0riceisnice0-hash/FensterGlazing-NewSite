import {searchCatalogue} from './finder-search.mjs';
import {initCoverageMap} from './map.js';
import {initProjectRail} from './rail.js';
import {initQuoteFrame} from './quote.js';
import {initHeadline} from './typewriter.js';

/** Homepage browsing, local catalogue search and product hero previews. */
(function () {
    'use strict';
    var finder = document.querySelector('[data-h30-finder]');
    if (!finder) return;
    var tabs = Array.from(finder.querySelectorAll('[data-h30-tab]'));
    var panels = Array.from(finder.querySelectorAll('[data-h30-panel]'));
    var active = panels.find(function (panel) { return !panel.hidden; });
    if (!active || !tabs.length) return;
    // Capture the server catalogue once, before rendering any search results.
    var catalogue = [];
    panels.forEach(function (panel) {
        panel.querySelectorAll('[data-h30-option]').forEach(function (item) {
            catalogue.push({
                node: item.cloneNode(true),
                key: panel.dataset.h30Panel,
                label: item.querySelector('strong').textContent,
                terms: item.dataset.h30Terms
            });
        });
    });
    finder.classList.add('is-enhanced');
    var hero = finder.closest('.fg-h30-hero');
    var photo = hero.querySelector('[data-h30-hero-photo]');
    var original = photo.querySelector('.fg-h30-hero__single');
    var previewImage = document.createElement('img');
    previewImage.className = 'fg-h30-hero__preview';
    previewImage.decoding = 'async';
    previewImage.alt = '';
    previewImage.hidden = true;
    photo.insertBefore(previewImage, original.nextSibling);
    var imageCache = new Map();

    function focusOption(link) {
        link.focus({preventScroll: true});
        var list = link.closest('.fg-h30-finder__options');
        var bounds = list.getBoundingClientRect();
        var row = link.getBoundingClientRect();
        // Reveal only inside the results; native focus can also scroll the page.
        if (row.top < bounds.top) list.scrollTop += row.top - bounds.top;
        else if (row.bottom > bounds.bottom) list.scrollTop += row.bottom - bounds.bottom;
    }

    function openResults(open) {
        if (open === undefined) open = true;
        hero.classList.toggle('is-finder-open', open);
        panels.forEach(function (panel) {
            panel.querySelector('[data-h30-results]').hidden = !open || panel !== active;
            panel.querySelector('[data-h30-search]').setAttribute('aria-expanded', String(open && panel === active));
        });
        if (!open && previews.has(active)) previews.get(active).restore();
    }
    var previews = new Map();

    function loadImage(src) {
        if (!imageCache.has(src)) {
            imageCache.set(src, new Promise(function (resolve) {
                var image = new Image();
                image.decoding = 'async';
                image.onload = function () {
                    image.decode().catch(function () {}).then(function () { resolve(image); });
                };
                image.onerror = function () { imageCache.delete(src); resolve(null); };
                image.src = src;
            }));
        }
        return imageCache.get(src);
    }

    function setupPreview(panel) {
        var title = photo.querySelector('[data-h30-photo-title]');
        var description = photo.querySelector('[data-h30-photo-description]');
        var label = photo.querySelector('[data-h30-photo-label]');
        var action = photo.querySelector('[data-h30-photo-action]');
        var destination = action.closest('a');
        var image = previewImage;
        var requested = null;   // the option currently being previewed
        var revision = 0;       // guards against a slow image landing late

        function restore() {
            revision++;
            requested = null;
            if (panel !== active) return;
            original.src = panel.dataset.h30Image;
            original.alt = panel.dataset.h30Alt;
            original.style.setProperty('--h30-hero-focus', panel.dataset.h30Focus || '42% 42%');
            original.style.setProperty('--h30-hero-focus-narrow', panel.dataset.h30FocusNarrow || '38% 46%');
            original.hidden = false;
            image.hidden = true;
            title.textContent = panel.dataset.h30Location;
            description.textContent = panel.dataset.h30Caption;
            label.textContent = 'Fitted by Fenster';
            action.textContent = 'See this project';
            destination.href = panel.dataset.h30Project;
            panel.querySelectorAll('.is-previewing').forEach(function (link) { link.classList.remove('is-previewing'); });
        }
        function show(link) {
            if (requested === link) return;
            if (!link.dataset.h30PreviewSrc) { restore(); return; }
            requested = link;
            var version = ++revision;
            label.textContent = 'Loading preview…';
            loadImage(link.dataset.h30PreviewSrc).then(function (loaded) {
                if (version !== revision || panel.hidden || !panel.contains(link)) return;
                if (!loaded) { restore(); return; }
                image.src = loaded.src;
                image.alt = link.dataset.h30PreviewAlt;
                image.width = loaded.naturalWidth;
                image.height = loaded.naturalHeight;
                title.textContent = link.querySelector('strong').textContent;
                description.textContent = link.querySelector('small').textContent;
                label.textContent = link.closest('[data-h30-option]').dataset.h30Category;
                action.textContent = 'Explore ' + link.querySelector('strong').textContent.toLowerCase();
                destination.href = link.href;
                original.hidden = true;
                image.hidden = false;
                panel.querySelectorAll('.is-previewing').forEach(function (item) { item.classList.remove('is-previewing'); });
                link.classList.add('is-previewing');
            });
        }
        // Delegation also covers newly rendered results from other categories.
        panel.addEventListener('pointerover', function (event) {
            if (event.pointerType === 'touch') return;
            var link = event.target.closest('[data-h30-option] a');
            if (link && panel.contains(link)) show(link);
        });
        panel.addEventListener('focusin', function (event) {
            var link = event.target.closest('[data-h30-option] a');
            if (link) show(link);
        });
        panel.addEventListener('focusout', function (event) {
            if (!hero.contains(event.relatedTarget)) restore();
        });
        previews.set(panel, {restore: restore, show: show});
    }

    function render(panel) {
        var query = panel.querySelector('[data-h30-query]').value.trim();
        // Opening the same results must not replace the list or flash its photo.
        if (panel.dataset.h30RenderedQuery === query) return;
        panel.dataset.h30RenderedQuery = query;
        previews.get(panel).restore();
        var results = query ? searchCatalogue(catalogue, query) : {
            items: catalogue.filter(function (item) { return item.key === panel.dataset.h30Panel; }),
            approximate: false
        };
        var shown = results.items;
        var list = panel.querySelector('.fg-h30-finder__options');
        list.replaceChildren();
        shown.forEach(function (result) {
            var item = result.node.cloneNode(true);
            item.querySelector('[data-h30-result-category]').hidden = !query;
            list.append(item);
        });
        var count = results.items.length;
        panel.querySelector('[data-h30-count]').textContent = query
            ? (results.approximate && count ? 'Closest matches · ' : '') + count + (count === 1 ? ' option' : ' options') + ' across all products'
            : 'Explore ' + count + ' ' + panel.dataset.h30Label.toLowerCase() + ' options';
        panel.querySelector('[data-h30-clear]').hidden = !query;
        panel.querySelector('[data-h30-empty]').hidden = count > 0;
        if (query && shown.length) previews.get(panel).show(list.querySelector('a'));
    }

    function activate(key, query) {
        var next = panels.find(function (panel) { return panel.dataset.h30Panel === key; });
        if (!next) return;
        previews.forEach(function (preview) { preview.restore(); });
        panels.forEach(function (panel) { panel.hidden = panel !== next; });
        tabs.forEach(function (tab) {
            var selected = tab.dataset.h30Tab === key;
            tab.classList.toggle('is-active', selected);
            tab.setAttribute('aria-selected', String(selected));
            tab.tabIndex = selected ? 0 : -1;
        });
        active = next;
        previews.get(next).restore();
        next.querySelector('[data-h30-query]').value = query || '';
        render(next);
        openResults(Boolean(query));
    }

    finder.querySelector('.fg-h30-finder__tabs').setAttribute('role', 'tablist');
    tabs.forEach(function (tab, index) {
        tab.setAttribute('role', 'tab');
        tab.removeAttribute('aria-current');
        tab.setAttribute('aria-controls', 'fg-h30-panel-' + tab.dataset.h30Tab);
        tab.addEventListener('click', function (event) {
            if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
            event.preventDefault();
            activate(tab.dataset.h30Tab);
        });
        tab.addEventListener('keydown', function (event) {
            var next;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            else if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
            else if (event.key === 'Home') next = 0;
            else if (event.key === 'End') next = tabs.length - 1;
            else if (event.key === ' ') { event.preventDefault(); activate(tab.dataset.h30Tab); return; }
            else return;
            event.preventDefault();
            tabs[next].focus({preventScroll: true});
            activate(tabs[next].dataset.h30Tab);
        });
    });

    panels.forEach(function (panel) {
        setupPreview(panel);
        panel.setAttribute('role', 'tabpanel');
        panel.setAttribute('aria-labelledby', 'fg-h30-tab-' + panel.dataset.h30Panel);
        panel.querySelector('[data-h30-filter]').hidden = false;
        panel.querySelector('[data-h30-dismiss]').hidden = false;
        var input = panel.querySelector('[data-h30-query]');
        function change() { openResults(); render(panel); }
        function clear() { input.value = ''; change(); input.focus({preventScroll: true}); }
        input.addEventListener('focus', function () { openResults(); });
        input.addEventListener('input', change);
        input.addEventListener('search', change);
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') { event.preventDefault(); openResults(false); return; }
            if (event.key === 'Enter' || event.key === 'ArrowDown') {
                event.preventDefault();
                openResults();
                var first = panel.querySelector('[data-h30-option] a');
                if (first) focusOption(first);
            }
        });
        panel.querySelector('[data-h30-clear]').addEventListener('click', clear);
        panel.querySelector('[data-h30-reset]').addEventListener('click', clear);
        panel.querySelector('[data-h30-search]').addEventListener('click', function () { openResults(); render(panel); });
        panel.querySelector('[data-h30-dismiss]').addEventListener('click', function () { input.focus({preventScroll: true}); openResults(false); });

        panel.addEventListener('keydown', function (event) {
            var link = event.target.closest('[data-h30-option] a');
            if (!link) return;
            var links = Array.from(panel.querySelectorAll('[data-h30-option] a'));
            var index = links.indexOf(link);
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                var next = event.key === 'ArrowDown' ? index + 1 : index - 1;
                if (next < 0) input.focus({preventScroll: true});
                else focusOption(links[Math.min(next, links.length - 1)]);
            } else if (event.key === 'Escape') {
                event.preventDefault();
                input.focus({preventScroll: true});
                openResults(false);
            }
        });
    });

    document.addEventListener('pointerdown', function (event) {
        if (!finder.contains(event.target) && !photo.contains(event.target)) openResults(false);
    });
    hero.addEventListener('focusout', function (event) {
        if (!hero.contains(event.relatedTarget)) openResults(false);
    });
    hero.addEventListener('pointerleave', function () {
        if (!hero.contains(document.activeElement)) previews.get(active).restore();
    });

    var initialQuery = new URL(window.location.href).searchParams.get('fg_q') || active.querySelector('[data-h30-query]').value;
    activate(active.dataset.h30Panel, initialQuery.slice(0, 100));
    window.addEventListener('pageshow', function () { render(active); });
    window.addEventListener('popstate', function () {
        var url = new URL(window.location.href);
        var key = url.searchParams.get('fg_category');
        activate(panels.some(function (panel) { return panel.dataset.h30Panel === key; }) ? key : 'windows',
            (url.searchParams.get('fg_q') || '').slice(0, 100));
    });

    var projects = document.querySelector('[data-h30-projects]');
    if (projects) {
        var cards = Array.from(projects.querySelectorAll('[data-h30-project-types]'));
        var filters = Array.from(projects.querySelectorAll('[data-h30-project-filter]'));
        function filterProjects(key) {
            var visible = 0;
            cards.forEach(function (card) {
                card.hidden = key !== 'all' && !card.dataset.h30ProjectTypes.split(' ').includes(key);
                if (!card.hidden) visible++;
            });
            filters.forEach(function (button) { button.setAttribute('aria-pressed', String(button.dataset.h30ProjectFilter === key)); });
            projects.dataset.h30Visible = String(visible);
            projects.querySelector('[data-h30-project-count]').textContent = visible + (visible === 1 ? ' project' : ' projects');
        }
        projects.querySelector('[data-h30-project-toolbar]').hidden = false;
        filters.forEach(function (button) {
            button.setAttribute('aria-controls', 'fg-h30-project-results');
            button.hidden = button.dataset.h30ProjectFilter !== 'all' && !cards.some(function (card) { return card.dataset.h30ProjectTypes.split(' ').includes(button.dataset.h30ProjectFilter); });
            button.addEventListener('click', function () { filterProjects(button.dataset.h30ProjectFilter); });
        });
        filterProjects('all');
    }
})();

/**
 * Reveal card grids as they come into view.
 *
 * Deliberately minimal: one IntersectionObserver, one class, fires once per
 * grid and then disconnects. The `is-armed` class is added by script, so with
 * JavaScript off — or if this throws — nothing is ever hidden.
 *
 * Honours prefers-reduced-motion by simply not arming.
 */
(function () {
    'use strict';

    var grids = document.querySelectorAll('[data-h30-reveal]');

    if (!grids.length || typeof IntersectionObserver !== 'function') {
        return;
    }

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }
            entry.target.classList.add('is-in');
            observer.unobserve(entry.target);
        });
    }, {rootMargin: '0px 0px -12% 0px', threshold: 0.06});

    Array.prototype.forEach.call(grids, function (grid) {
        var box = grid.getBoundingClientRect();
        // Anything already on screen at load stays put; only arm what is below.
        if (box.top < window.innerHeight * 0.9) {
            return;
        }
        grid.classList.add('is-armed');
        observer.observe(grid);
    });
})();

initCoverageMap();
initProjectRail();
initQuoteFrame();
initHeadline();
