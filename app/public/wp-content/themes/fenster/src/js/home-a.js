/* Homepage A/B test, variant A ("Open House"): template-parts/sections/home-a.php,
   styles in the .fg-ha block at the end of src/scss/main.scss.

   - Picking a product (the four tiles are real links, so this is only an
     enhancement) wipes its photo onto the stage and turns the bar into the
     kinds the quote tool prices; each is a link straight into the tool.
     Conversion first (owner, 10/11/2026): nothing stands between a choice
     and the tool. Bifolds have one kind, so that tile is a plain link.
   - The chosen product is carried into every price button on the page
     ([data-fg-ha-price]) and into the footer's phone price bar, and kept for
     the visitor's next visit.
   - Price buttons show a spinner, a tick and a pulse, then go.
   - The before/after wipes once when it comes into view; a tap on the switch
     takes over.
   - Reduced motion: every state changes at once. */
export function initHomeA() {
  const root = document.querySelector('[data-fg-ha]');
  if (!root) return;

  let config = {};
  try { config = JSON.parse(root.dataset.fgHa || '{}'); } catch (_error) { return; }
  const P = config.products || {};
  const $ = (selector, scope = root) => scope.querySelector(selector);
  const $$ = (selector, scope = root) => [...scope.querySelectorAll(selector)];
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  const still = () => reduce.matches;
  const plainClick = (event) => event.button === 0 && !event.metaKey && !event.ctrlKey && !event.shiftKey && !event.altKey;

  /* Carry the chosen product into every price button and the phone price bar. */
  const deep = (k) => {
    if (P[k] && P[k].url) return P[k].url;
    const url = new URL(config.quote || '/online-quote/', window.location.href);
    if (P[k]) url.searchParams.set('product', P[k].slug);
    return url.toString();
  };
  const priceBar = document.querySelector('.fg-price-bar__price');
  const carry = (k) => {
    if (!P[k]) return;
    $$('[data-fg-ha-price]').forEach((link) => { link.href = deep(k); });
    if (priceBar) {
      priceBar.href = deep(k);
      priceBar.textContent = P[k].bar;
    }
  };

  /* The hero journey. */
  const hero = $('[data-fg-ha-hero]');
  const lineup = $('[data-fg-ha-lineup]');
  const detail = $('[data-fg-ha-detail]');
  const stage = $('[data-fg-ha-stage]');
  const name = $('[data-fg-ha-name]');
  const asks = config.asks || {};
  let current = null;

  /* The photo stage: the new photo wipes in over the last (a clip-path mask). */
  const show = (k) => {
    if (!stage) return;
    const next = $(`img[data-k="${k}"]`, stage);
    if (!next || next.classList.contains('is-on')) return;
    $$('img', stage).forEach((img) => {
      img.classList.remove('is-was');
      if (img.classList.contains('is-on')) {
        img.classList.remove('is-on');
        img.classList.add('is-was');
      }
      img.setAttribute('aria-hidden', String(img !== next));
    });
    next.loading = 'eager';
    next.style.transition = 'none';
    void next.offsetWidth;
    next.style.transition = '';
    next.classList.add('is-on');
  };

  const open = (k, focus = true) => {
    const p = P[k];
    if (!p || !hero || !lineup || !detail) return;
    current = k;
    if (!asks[k]) return;
    name.textContent = asks[k];
    $$('[data-fg-ha-types]').forEach((list) => { list.hidden = list.dataset.fgHaTypes !== k; });
    carry(k);
    try { window.localStorage.setItem('fg_ha_pick', k); } catch (_error) { /* storage off */ }
    lineup.hidden = true;
    detail.hidden = false;
    hero.classList.add('is-chosen');
    show(k);
    if (hero.getBoundingClientRect().top < 0) hero.scrollIntoView({ behavior: still() ? 'auto' : 'smooth', block: 'start' });
    if (focus) name.focus({ preventScroll: true });
  };

  const back = () => {
    if (!hero || !lineup || !detail) return;
    detail.hidden = true;
    lineup.hidden = false;
    hero.classList.remove('is-chosen');
    show('home');
    const tile = $(`[data-fg-ha-pick="${current}"]`) || $('[data-fg-ha-pick]');
    if (tile) tile.focus({ preventScroll: true });
  };

  $$('[data-fg-ha-pick]').forEach((tile) => tile.addEventListener('click', (event) => {
    if (!plainClick(event) || !P[tile.dataset.fgHaPick]) return;
    event.preventDefault();
    open(tile.dataset.fgHaPick);
  }));
  const backButton = $('[data-fg-ha-back]');
  if (backButton) backButton.addEventListener('click', back);

  /* Price buttons: a spinner, then a tick and a pulse, then the browser goes. */
  $$('[data-fg-ha-go]').forEach((link) => link.addEventListener('click', (event) => {
    if (!plainClick(event)) return;
    event.preventDefault();
    if (link.classList.contains('is-loading') || link.classList.contains('is-done')) return;
    const href = link.href;
    link.classList.add('is-loading');
    link.setAttribute('aria-busy', 'true');
    window.setTimeout(() => {
      link.classList.remove('is-loading');
      link.classList.add('is-done');
    }, still() ? 0 : 650);
    window.setTimeout(() => { window.location.href = href; }, still() ? 50 : 1000);
  }));
  /* Coming back with the browser's back button: the buttons are buttons again. */
  window.addEventListener('pageshow', () => $$('[data-fg-ha-go]').forEach((link) => {
    link.classList.remove('is-loading', 'is-done');
    link.removeAttribute('aria-busy');
  }));

  /* Before and after: wipes to "after" once, the first time it is in view,
     unless the visitor has already used the switch. */
  const ba = $('[data-fg-ha-ba]');
  if (ba) {
    const knob = $('[data-fg-ha-knob]', ba);
    const frame = $('[data-fg-ha-ba-frame]', ba);
    let touched = false;
    const setBA = (after) => {
      if (ba.classList.contains('is-after') === after) return;
      if (knob && !still()) {
        knob.classList.remove('is-moving');
        void knob.offsetWidth;
        knob.classList.add('is-moving');
      }
      ba.classList.toggle('is-after', after);
      $$('[data-fg-ha-ba-v]', ba).forEach((button) => button.setAttribute('aria-pressed', String((button.dataset.fgHaBaV === 'after') === after)));
    };
    $$('[data-fg-ha-ba-v]', ba).forEach((button) => button.addEventListener('click', () => {
      touched = true;
      setBA(button.dataset.fgHaBaV === 'after');
    }));
    /* It used to fire the moment 60% of the frame was in view, which a
       visitor scrolling past was still above: by the time they looked it had
       already happened (owner, 10/11/2026). Now the whole frame has to be on
       screen, and stay there for 900ms, before it plays; scrolling away
       first cancels it. */
    if (frame && 'IntersectionObserver' in window) {
      let timer = 0;
      const io = new IntersectionObserver((entries) => {
        const entry = entries[entries.length - 1];
        window.clearTimeout(timer);
        if (!entry.isIntersecting || entry.intersectionRatio < 0.9) return;
        timer = window.setTimeout(() => {
          io.disconnect();
          if (!touched) setBA(true);
        }, still() ? 0 : 900);
      }, { threshold: [0, 0.9, 1] });
      io.observe(frame);
    }
  }

  /* A returning visitor's product is already in every price button. QA hook:
     #pick=door opens that product on load. */
  let saved = null;
  try { saved = window.localStorage.getItem('fg_ha_pick'); } catch (_error) { /* storage off */ }
  if (saved && P[saved]) carry(saved);
  const hashPick = window.location.hash.match(/pick=(\w+)/);
  if (hashPick && P[hashPick[1]]) open(hashPick[1], false);
}
