/* The WindowCAD designer, opened over the page instead of leaving the site
   (owner, 10/11/2026: "give them a way out ... make the iframe cover
   everything, but leave in the menu and bars, header etc., on mobile too").

   The homepage A/B variants send a picked product straight into its own
   WindowCAD designer. Rather than navigating to windowsoftware.co.uk, the
   designer opens in a panel that fills the screen below the site header: the
   header, its menu and the phone number stay where they are and stay usable,
   a Back button closes the panel, and so does the phone's or browser's back
   button (one history entry is pushed while it is open).

   The tracking reference is already on the link by the time this runs: main.js
   stamps every WindowCAD link in the capture phase of the click and logs
   quote_opened there. */

const WINDOWCAD = /windowsoftware\.co\.uk\/windowcad7\//i;
let overlay = null;
let pushed = false;
let lastFocus = null;

const headerBottom = () => {
  const header = document.querySelector('.site-header');
  return header ? Math.max(0, Math.round(header.getBoundingClientRect().bottom)) : 0;
};

const place = () => {
  if (overlay && !overlay.hidden) overlay.style.setProperty('--fg-qo-top', `${headerBottom()}px`);
};

const shut = () => {
  if (!overlay || overlay.hidden) return;
  overlay.hidden = true;
  overlay.querySelector('[data-fg-qo-frame]').innerHTML = '';
  document.documentElement.classList.remove('fg-qo-open');
  window.fensterLenis?.start?.();
  if (lastFocus && document.contains(lastFocus)) lastFocus.focus({ preventScroll: true });
};

/* Back, Escape: go back through the entry we pushed, so the browser's own
   back button and ours are the same thing. */
const close = () => {
  if (!overlay || overlay.hidden) return;
  if (pushed) {
    pushed = false;
    window.history.back();
    return;
  }
  shut();
};

const build = () => {
  overlay = document.createElement('div');
  overlay.className = 'fg-qo';
  overlay.hidden = true;
  overlay.setAttribute('role', 'dialog');
  overlay.setAttribute('aria-label', 'Design and price online');
  overlay.innerHTML = '<div class="fg-qo__bar">'
    + '<button type="button" class="fg-qo__back" data-fg-qo-close>'
    + '<svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M10 3.5 5.5 8 10 12.5"/></svg>'
    + '<span>Back</span></button>'
    + '<p class="fg-qo__title" data-fg-qo-title></p>'
    + '</div>'
    + '<div class="fg-qo__frame" data-fg-qo-frame></div>';
  document.body.appendChild(overlay);
  overlay.querySelector('[data-fg-qo-close]').addEventListener('click', close);
  window.addEventListener('resize', place);
  window.addEventListener('popstate', () => {
    pushed = false;
    shut();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') close();
  });
};

/* Opens a WindowCAD address in the panel. False for anything else, so the
   caller can fall back to plain navigation. */
export const openQuote = (href, title = '') => {
  if (!WINDOWCAD.test(href || '')) return false;
  if (!overlay) build();
  lastFocus = document.activeElement;

  const name = String(title || '').replace(/\s+/g, ' ').trim();
  overlay.querySelector('[data-fg-qo-title]').textContent = name ? `Price your ${name.toLowerCase()}` : 'Your instant price';
  const box = overlay.querySelector('[data-fg-qo-frame]');
  box.innerHTML = '';
  const iframe = document.createElement('iframe');
  iframe.src = href;
  iframe.title = name ? `Design and price ${name.toLowerCase()} online` : 'Design and price online';
  iframe.allow = 'fullscreen';
  box.appendChild(iframe);

  overlay.hidden = false;
  document.documentElement.classList.add('fg-qo-open');
  place();
  window.fensterLenis?.stop?.();
  if (!pushed) {
    try {
      window.history.pushState({ fgQuote: true }, '', window.location.href);
      pushed = true;
    } catch (_error) { /* history unavailable: Back still closes it */ }
  }
  overlay.querySelector('[data-fg-qo-close]').focus({ preventScroll: true });
  return true;
};

const plainClick = (event) => event.button === 0 && !event.metaKey && !event.ctrlKey && !event.shiftKey && !event.altKey;

/* Any WindowCAD link inside `root` opens in the panel. Links with their own
   handler (`skip`: the price buttons with a spinner) call openQuote
   themselves, and a link whose own handler already took the click (a category
   tile opening its list) is left alone. */
export const initQuoteOverlay = (root, skip = '') => {
  if (!root) return;
  root.addEventListener('click', (event) => {
    if (event.defaultPrevented || !plainClick(event)) return;
    const link = event.target instanceof Element ? event.target.closest('a[href]') : null;
    if (!link || !root.contains(link) || (skip && link.matches(skip))) return;
    if (!WINDOWCAD.test(link.href)) return;
    const nameEl = link.querySelector('[class*="__name"]');
    if (openQuote(link.href, nameEl ? nameEl.textContent : '')) event.preventDefault();
  });
};
