/* The heat and noise comparison (template-parts/warm/compare.php).

   The drawing is driven by CSS: this only swaps three custom properties and
   two data attributes on the section. Everything else here is the readout:
   which card shows, the bars easing from the last step to this one (Web
   Animations, on transform), the figures counting, and one polite sentence
   for screen readers. The moving layer is paused while the section is off
   screen or the tab is hidden. */

const reduceMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const NUM = /\d+(?:\.\d+)?/g;

/* Count every number in `el`'s text up (or down) from `from`, then restore the exact text. */
function countUp(el, from) {
  const text = el.dataset.text || (el.dataset.text = el.textContent);
  const nums = text.match(NUM);
  if (!nums || from == null || reduceMotion()) return;
  const places = nums.map((n) => (n.split('.')[1] || '').length);
  const start = performance.now();
  const step = (now) => {
    const t = Math.min(1, (now - start) / 650);
    const e = 1 - Math.pow(1 - t, 3);
    let k = 0;
    el.textContent = t < 1
      ? text.replace(NUM, (n) => (from + (Number(n) - from) * e).toFixed(places[k++]))
      : text;
    if (t < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

const firstNumber = (el) => {
  const m = el && (el.dataset.text || el.textContent).match(NUM);
  return m ? Number(m[0]) : null;
};

export function initCompare(root) {
  const section = root.querySelector('[data-fg-warm-compare]');
  if (!section) return;

  const stateButtons = [...section.querySelectorAll('.fg-warm-compare__state-btn')];
  const modeButtons = [...section.querySelectorAll('.fg-warm-compare__mode-btn')];
  const cards = [...section.querySelectorAll('.fg-warm-compare__card')];
  const status = section.querySelector('[data-fg-warm-compare-status]');
  let current = cards.find((c) => c.classList.contains('is-active')) || cards[0];

  const announce = () => {
    if (!status || !current) return;
    const mode = section.dataset.mode;
    const set = current.querySelector(`.fg-warm-compare__set--${mode} .fg-warm-compare__meter`);
    const label = set.querySelector('.fg-warm-compare__label').textContent.trim();
    const value = set.querySelector('[data-count]');
    const unit = mode === 'heat' ? ` ${set.querySelector('.fg-warm-compare__value span').textContent}` : '.';
    const name = current.querySelector('.fg-warm-compare__name').textContent.trim();
    status.textContent = `${name}. ${label}: ${value.dataset.text || value.textContent}${unit}`;
  };

  const setState = (button) => {
    const key = button.dataset.key;
    const next = cards.find((c) => c.dataset.key === key);
    if (!next || next === current) return;

    section.dataset.state = key;
    section.style.setProperty('--fgw-heat', button.dataset.heat);
    section.style.setProperty('--fgw-leak', button.dataset.leak);
    section.style.setProperty('--fgw-loud', button.dataset.loud);
    stateButtons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));

    const prevBars = [...current.querySelectorAll('.fg-warm-compare__bar > span')];
    const prevValues = [...current.querySelectorAll('[data-count]')];
    current.classList.remove('is-active');
    next.classList.add('is-active');

    if (!reduceMotion()) {
      next.querySelectorAll('.fg-warm-compare__bar > span').forEach((bar, i) => {
        const from = prevBars[i] ? prevBars[i].style.getPropertyValue('--v') : '0';
        const to = bar.style.getPropertyValue('--v');
        if (bar.animate && from !== to) {
          bar.animate(
            [{ transform: `scaleX(${from})` }, { transform: `scaleX(${to})` }],
            { duration: 700, easing: 'cubic-bezier(0.22, 0.7, 0.2, 1)' },
          );
        }
      });
      next.querySelectorAll('[data-count]').forEach((el, i) => countUp(el, firstNumber(prevValues[i])));
    }

    current = next;
    announce();
  };

  const setMode = (button) => {
    if (section.dataset.mode === button.dataset.mode) return;
    section.dataset.mode = button.dataset.mode;
    modeButtons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));
    announce();
  };

  const ready = () => section.classList.add('is-ready');
  stateButtons.forEach((b) => b.addEventListener('click', () => { ready(); setState(b); }));
  modeButtons.forEach((b) => b.addEventListener('click', () => { ready(); setMode(b); }));

  /* Only animate while the section can be seen. */
  let onScreen = false;
  const sync = () => section.classList.toggle('is-paused', !onScreen || document.hidden);
  sync();
  if ('IntersectionObserver' in window) {
    new IntersectionObserver((entries) => {
      onScreen = entries[entries.length - 1].isIntersecting;
      sync();
    }, { rootMargin: '80px 0px' }).observe(section);
  } else {
    onScreen = true;
    sync();
  }
  document.addEventListener('visibilitychange', sync);
}
