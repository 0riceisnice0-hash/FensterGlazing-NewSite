/**
 * HOMEPAGE 3.0 — the coverage map.
 *
 * One red outline around the whole working area, a pin for every residential
 * case study inside it, and a pin for the showroom. The data comes from PHP
 * (`fenster_h30_map_data()`) as JSON in the page, so the outline and the pins
 * are edited in one place and never here.
 *
 * TWO RENDERERS, ONE DATA SHAPE. If a Google Maps JavaScript API key is
 * configured (`FENSTER_GOOGLE_MAPS_KEY`) the map is Google's. If it is not,
 * the map is Leaflet on OpenStreetMap tiles, which needs no key at all. The
 * outline, the pins and the cards are identical in both, so adding the key
 * later changes the base map and nothing else.
 *
 * LAZY. Nothing loads until the section scrolls near the viewport — a map
 * library is the heaviest thing on the page and most visitors never reach it.
 * With JavaScript off, or if a library fails to load, the description beside
 * the map and the "Every area we cover" link still say where we work.
 */

export function initCoverageMap() {
    var host = document.querySelector('[data-h30-map]');
    var dataNode = document.getElementById('fg-h30-map-data');

    if (!host || !dataNode) {
        return;
    }

    var data;
    try {
        data = JSON.parse(dataNode.textContent || '{}');
    } catch (error) {
        return;
    }

    if (!data || !Array.isArray(data.outline) || data.outline.length < 3) {
        return;
    }

    var started = false;

    function start() {
        if (started) {
            return;
        }
        started = true;
        host.classList.add('is-loading');
        var render = data.googleKey ? renderGoogle : renderLeaflet;
        render(host, data).then(function () {
            host.classList.remove('is-loading');
            host.classList.add('is-ready');
        }).catch(function () {
            host.classList.remove('is-loading');
            host.classList.add('is-failed');
        });
    }

    if (typeof IntersectionObserver !== 'function') {
        start();
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        if (entries.some(function (entry) { return entry.isIntersecting; })) {
            observer.disconnect();
            start();
        }
    }, {rootMargin: '400px 0px'});

    observer.observe(host);
}

/* -------------------------------------------------------------------------
   Shared pieces
   ------------------------------------------------------------------------- */

var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function loadScript(src) {
    return new Promise(function (resolve, reject) {
        var script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = resolve;
        script.onerror = function () { reject(new Error('script failed: ' + src)); };
        document.head.appendChild(script);
    });
}

function loadStyle(href) {
    return new Promise(function (resolve, reject) {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        link.onload = resolve;
        link.onerror = function () { reject(new Error('stylesheet failed: ' + href)); };
        document.head.appendChild(link);
    });
}

function escapeHtml(value) {
    return String(value == null ? '' : value)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/** The card that opens from a case-study pin. Same markup in both renderers. */
function pinCard(pin) {
    var html = '<article class="fg-h30-map__card">';
    if (pin.image) {
        html += '<img class="fg-h30-map__card-image" src="' + escapeHtml(pin.image) + '" alt="" width="240" height="150" loading="lazy" decoding="async">';
    }
    html += '<div class="fg-h30-map__card-body">';
    html += '<strong class="fg-h30-map__card-place">' + escapeHtml(pin.location) + '</strong>';
    if (pin.products) {
        html += '<span class="fg-h30-map__card-what">' + escapeHtml(pin.products) + '</span>';
    }
    if (pin.url) {
        html += '<a class="fg-h30-map__card-link" href="' + escapeHtml(pin.url) + '">See this project &rarr;</a>';
    }
    html += '</div></article>';
    return html;
}

function showroomCard(showroom) {
    var html = '<article class="fg-h30-map__card fg-h30-map__card--showroom">';
    if (showroom.image) {
        html += '<img class="fg-h30-map__card-image" src="' + escapeHtml(showroom.image) + '" alt="" width="240" height="150" loading="lazy" decoding="async">';
    }
    html += '<div class="fg-h30-map__card-body">'
        + '<strong class="fg-h30-map__card-place">' + escapeHtml(showroom.label) + '</strong>'
        + '<span class="fg-h30-map__card-what">' + escapeHtml(showroom.address) + '</span>'
        + (showroom.url ? '<a class="fg-h30-map__card-link" href="' + escapeHtml(showroom.url) + '">Find the showroom &rarr;</a>' : '')
        + '</div></article>';
    return html;
}

/** A brand-coloured pin as inline SVG, used by both renderers. */
function pinSvg(fill, stroke) {
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 36" width="28" height="36" aria-hidden="true">'
        + '<path d="M14 1C7.4 1 2 6.3 2 12.9 2 21.6 14 35 14 35s12-13.4 12-22.1C26 6.3 20.6 1 14 1z" fill="' + fill + '" stroke="' + stroke + '" stroke-width="2"/>'
        + '<circle cx="14" cy="13" r="4.5" fill="#fff"/></svg>';
}

/**
 * The words float over the map in a card. Fit the outline into the part of
 * the frame the card leaves free: beside it on a wide screen, above it on a
 * phone, where the card sits along the bottom. Measured, not assumed.
 */
function panelPadding(host) {
    var panel = document.querySelector('[data-h30-map-panel]');
    var pad = {top: 40, right: 40, bottom: 40, left: 40};
    if (!panel) {
        return pad;
    }
    var box = panel.getBoundingClientRect();
    var frame = host.getBoundingClientRect();
    if (window.innerWidth > 900) {
        pad.left = Math.round(box.right - frame.left) + 40;
    } else {
        pad.bottom = Math.round(frame.bottom - box.top) + 24;
    }
    return pad;
}

var PIN_GREEN = {fill: '#2eac66', stroke: '#002d3a'};
var PIN_NAVY = {fill: '#002d3a', stroke: '#ffffff'};
var OUTLINE = {color: '#d62828', weight: 3, fillColor: '#d62828', fillOpacity: 0.06};

/* -------------------------------------------------------------------------
   Leaflet + OpenStreetMap (no key)
   ------------------------------------------------------------------------- */

function renderLeaflet(host, data) {
    var base = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/';

    return Promise.all([loadStyle(base + 'leaflet.css'), loadScript(base + 'leaflet.js')]).then(function () {
        var L = window.L;
        if (!L) {
            throw new Error('Leaflet did not initialise');
        }

        var map = L.map(host, {
            scrollWheelZoom: false,       // the page scroll must not become a zoom
            zoomControl: false,           // added below, in the corner the panel leaves free
            zoomSnap: 0,                  // any zoom, not the nearest step: the opening glide is continuous
            zoomAnimation: !reduceMotion,
            fadeAnimation: !reduceMotion,
            markerZoomAnimation: !reduceMotion,
            attributionControl: true
        });
        L.control.zoom({position: 'topright'}).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var outline = L.polygon(data.outline, {
            color: OUTLINE.color, weight: OUTLINE.weight, fillColor: OUTLINE.fillColor, fillOpacity: OUTLINE.fillOpacity,
            lineJoin: 'round'
        }).addTo(map);

        var icon = function (colours) {
            return L.divIcon({
                className: 'fg-h30-map__pin',
                html: pinSvg(colours.fill, colours.stroke),
                iconSize: [28, 36],
                iconAnchor: [14, 35],
                popupAnchor: [0, -30]
            });
        };

        var jobs = (data.pins || []).map(function (pin) {
            var marker = L.marker([pin.lat, pin.lng], {icon: icon(PIN_GREEN), title: pin.location, alt: pin.location})
                .bindPopup(pinCard(pin), {className: 'fg-h30-map__popup', maxWidth: 260})
                .addTo(map);
            marker.fgPhoto = pin.image || '';   // the reveal fetches this ahead of opening the card
            return marker;
        });

        var home = null;

        if (data.showroom) {
            home = L.marker([data.showroom.lat, data.showroom.lng], {icon: icon(PIN_NAVY), title: data.showroom.label, alt: data.showroom.label, zIndexOffset: 1000})
                .bindPopup(showroomCard(data.showroom), {className: 'fg-h30-map__popup', maxWidth: 260})
                .addTo(map);
        }

        host.setAttribute('data-h30-map-renderer', 'leaflet');

        if (reduceMotion || !home || jobs.length < 2) {
            settle(map, outline, host, false);
            return;
        }

        revealTour(L, map, outline, home, jobs, host);
    });
}

/**
 * Put the whole working area in the frame, which is where every route ends.
 */
function settle(map, outline, host, animate) {
    var pad = panelPadding(host);
    var options = {
        paddingTopLeft: [pad.left, pad.top],
        paddingBottomRight: [pad.right, pad.bottom]
    };

    if (!animate) {
        map.fitBounds(outline.getBounds(), options);
        return;
    }

    options.duration = 1.4;
    map.flyToBounds(outline.getBounds(), options);
}

/**
 * THE OPENING MOVE.
 *
 * The map starts tight on the showroom with its card open, then glides out in
 * one continuous movement, never leaving that spot, until the whole red line
 * is in the frame. As the widening frame reaches each job, that job's card
 * opens and the one before it closes, so there is always exactly one card up
 * and it always has a photograph in it. The showroom is simply the first of
 * them; its card goes when the first job arrives.
 *
 * WHY ONE AT A TIME. These cards are 250px across and 260 tall, and at the
 * zoom this map comes to rest at, the pins sit closer together than that. Two
 * of them on screen at once would overlap far more often than not, so they
 * take turns instead, each held long enough to read.
 *
 * IT GIVES WAY IMMEDIATELY. A touch, a key or a reach for the zoom buttons
 * stops it where it is and it never moves the map again. Under reduced motion
 * it does not run at all; the finished view is simply set.
 */
function revealTour(L, map, outline, home, jobs, host) {
    var GLIDE = 7;        // seconds, the whole way out
    var HOLD = 1100;      // on the showroom before it starts to move
    var DWELL = 700;      // the least time a card stays before another takes over
    var REVEALS = 3;      // jobs shown, which with the showroom's card makes four
    var start = home.getLatLng();
    var pad = panelPadding(host);
    var stopped = false;
    var shown = [];
    var lastAt = 0;
    var timer = null;

    function stop() {
        stopped = true;
        if (timer) { window.clearTimeout(timer); }
        map.off('move zoom', reveal);
        host.setAttribute('data-h30-map-tour', 'stopped');
    }

    ['mousedown', 'touchstart', 'keydown'].forEach(function (type) {
        host.addEventListener(type, stop, {passive: true});
    });

    /* The zoom the map comes to rest at: what `fitBounds` would choose for the
       outline once the floating card has taken its share of the frame. */
    var endZoom = map.getBoundsZoom(
        outline.getBounds(),
        false,
        L.point(pad.left + pad.right, pad.top + pad.bottom)
    );

    /* A card that pans the map to fit itself is the one thing this move cannot
       have, since the whole point is that the map does not wander. */
    jobs.concat([home]).forEach(function (marker) {
        var popup = marker.getPopup();
        if (popup) {
            popup.options.autoPan = false;
        }
    });

    /* FOUR CARDS, SPACED ALONG THE WAY OUT.
       Every job in turn was too many to take in, and because they are ordered
       by how far out they sit and most of them are in Milton Keynes, they all
       arrived in the first second and then nothing happened for the rest of
       the move. Three are picked instead, spread along that same order: one
       close in, one halfway out, one at the edge. The widening frame reaches
       each at a different moment, so a card turns over as the map travels. */
    var byDistance = jobs.slice().sort(function (a, b) {
        return start.distanceTo(a.getLatLng()) - start.distanceTo(b.getLatLng());
    });

    var queue = [];

    for (var pick = 1; pick <= REVEALS && byDistance.length; pick++) {
        var at = Math.min(byDistance.length - 1, Math.round((byDistance.length - 1) * pick / REVEALS));
        if (queue.indexOf(byDistance[at]) === -1) {
            queue.push(byDistance[at]);
        }
    }

    /* A card's photograph only starts downloading when the card opens, and a
       card is up for under a second, so without this the picture arrives after
       the card has already gone. Fetching one ahead keeps every card whole
       without pulling down the whole set of photographs up front. */
    function warm(index) {
        var next = queue[index];
        if (next && next.fgPhoto) {
            var picture = new Image();
            picture.decoding = 'async';
            picture.src = next.fgPhoto;
        }
    }

    function reveal() {
        if (stopped || Date.now() - lastAt < DWELL) {
            return;
        }

        var bounds = map.getBounds();

        for (var i = 0; i < queue.length; i++) {
            var marker = queue[i];
            if (shown.indexOf(marker) !== -1 || !bounds.contains(marker.getLatLng())) {
                continue;
            }
            shown.push(marker);
            lastAt = Date.now();
            marker.openPopup();   // which closes whichever card was up before it
            warm(i + 1);
            return;
        }
    }

    function finish() {
        map.off('move zoom', reveal);
        if (stopped) {
            return;
        }
        /* The last card closes with the move. Cards are held in place while the
           map glides, so one still standing when the frame makes its final
           adjustment ends up hanging over the edge. The area is the point by
           this stage; the cards have already done their work. */
        map.closePopup();
        settle(map, outline, host, true);
        host.setAttribute('data-h30-map-tour', 'done');
        jobs.concat([home]).forEach(function (marker) {
            var popup = marker.getPopup();
            if (popup) {
                popup.options.autoPan = true;
            }
        });
    }

    host.setAttribute('data-h30-map-tour', 'running');
    map.setView(start, Math.min(13.5, endZoom + 4), {animate: false});
    home.openPopup();
    lastAt = Date.now();
    warm(0);   // the first job's photograph, fetched while the showroom is up

    timer = window.setTimeout(function () {
        if (stopped) {
            return;
        }
        map.on('move zoom', reveal);
        map.once('moveend', finish);
        map.flyTo(start, endZoom, {duration: GLIDE, easeLinearity: 0.4});
    }, HOLD);
}

/* -------------------------------------------------------------------------
   Google Maps JavaScript API (when a key is configured)
   ------------------------------------------------------------------------- */

function renderGoogle(host, data) {
    return new Promise(function (resolve, reject) {
        var callbackName = 'fgH30MapReady';
        window[callbackName] = function () {
            try {
                var g = window.google.maps;
                var map = new g.Map(host, {
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true,
                    gestureHandling: 'cooperative',
                    clickableIcons: false
                });

                var path = data.outline.map(function (point) { return {lat: point[0], lng: point[1]}; });
                var outline = new g.Polygon({
                    paths: path,
                    strokeColor: OUTLINE.color, strokeOpacity: 1, strokeWeight: OUTLINE.weight,
                    fillColor: OUTLINE.fillColor, fillOpacity: OUTLINE.fillOpacity
                });
                outline.setMap(map);

                var bounds = new g.LatLngBounds();
                path.forEach(function (point) { bounds.extend(point); });
                map.fitBounds(bounds, panelPadding(host));

                var info = new g.InfoWindow();
                var icon = function (colours) {
                    return {
                        url: 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(pinSvg(colours.fill, colours.stroke)),
                        scaledSize: new g.Size(28, 36),
                        anchor: new g.Point(14, 35)
                    };
                };

                (data.pins || []).forEach(function (pin) {
                    var marker = new g.Marker({position: {lat: pin.lat, lng: pin.lng}, map: map, title: pin.location, icon: icon(PIN_GREEN)});
                    marker.addListener('click', function () {
                        info.setContent(pinCard(pin));
                        info.open({anchor: marker, map: map});
                    });
                });

                if (data.showroom) {
                    var showroom = new g.Marker({position: {lat: data.showroom.lat, lng: data.showroom.lng}, map: map, title: data.showroom.label, icon: icon(PIN_NAVY), zIndex: 1000});
                    showroom.addListener('click', function () {
                        info.setContent(showroomCard(data.showroom));
                        info.open({anchor: showroom, map: map});
                    });
                }

                host.setAttribute('data-h30-map-renderer', 'google');
                resolve();
            } catch (error) {
                reject(error);
            }
        };

        loadScript('https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(data.googleKey) + '&callback=' + callbackName).catch(reject);
    });
}
