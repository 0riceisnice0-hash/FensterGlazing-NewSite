/* The winter guide, /stop-window-draughts/. Built to assets/warm/warm.js by
   `npm run build:warm` and loaded on that one route by inc/warm-guide.php.

   Everything here is progressive enhancement: the page reads top to bottom
   with JavaScript off, and each part below only adds the interaction.

   Tracking: nothing here talks to the dashboard. Buttons and anything marked
   `data-fg-cta` are already counted by the site's own `cta_click` listener in
   main.js, with the label and the destination. */
import { initCompare } from './compare.js';
import { initTools } from './tools.js';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* The thermal scope: wipe between the room view and the thermal view. */
function initScope(scope) {
  const stage = scope.querySelector('.fg-warm-scope__stage');
  const range = scope.querySelector('.fg-warm-scope__range');
  const clip = scope.querySelector('[data-fg-warm-wipe]');
  if (!stage || !range || !clip) return;

  let touched = false;
  const set = (value) => {
    const v = Math.min(1, Math.max(0, value));
    stage.style.setProperty('--fgw-wipe', v.toFixed(4));
    clip.setAttribute('width', (v * 480).toFixed(1));
    if (Math.round(v * 100) !== Number(range.value)) range.value = String(Math.round(v * 100));
  };

  range.addEventListener('input', () => {
    touched = true;
    set(Number(range.value) / 100);
  });

  /* Open on the room, then sweep the thermal view in once, the first time
     the drawing is on screen, so nobody has to guess that it moves. */
  set(reduceMotion ? 0.5 : 0.04);
  if (reduceMotion || !('IntersectionObserver' in window)) return;

  const sweep = () => {
    const from = 0.04;
    const to = 0.56;
    const start = performance.now();
    const step = (now) => {
      if (touched) return;
      const t = Math.min(1, (now - start) / 1500);
      const eased = 1 - Math.pow(1 - t, 3);
      set(from + (to - from) * eased);
      if (t < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver((entries) => {
    if (!entries.some((entry) => entry.isIntersecting)) return;
    observer.disconnect();
    window.setTimeout(sweep, 500);
  }, { threshold: 0.5 });
  observer.observe(stage);
}

/* Tonight's fixes: a vertical tab list beside one open panel. Arrow keys move
   between tabs, as the tab pattern expects; every panel stays in the markup. */
function initTabs(section) {
  const tabs = Array.from(section.querySelectorAll('[data-fg-warm-tab]'));
  const panels = Array.from(section.querySelectorAll('[data-fg-warm-panel]'));
  if (!tabs.length || tabs.length !== panels.length) return;

  const select = (index, focus) => {
    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.classList.toggle('is-active', on);
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
      tab.tabIndex = on ? 0 : -1;
      panels[i].classList.toggle('is-active', on);
    });
    if (focus) {
      tabs[index].focus();
      tabs[index].scrollIntoView({ block: 'nearest', inline: 'nearest' });
    }
  };

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => select(index, false));
    tab.addEventListener('keydown', (event) => {
      const step = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 }[event.key];
      if (step) {
        event.preventDefault();
        select((index + step + tabs.length) % tabs.length, true);
      } else if (event.key === 'Home' || event.key === 'End') {
        event.preventDefault();
        select(event.key === 'Home' ? 0 : tabs.length - 1, true);
      }
    });
  });
}

/* The leak finder: a spot on the drawing or a name in the list opens the
   thermal lens over that part of the window and shows its panel. */
function initFind(section) {
  const stage = section.querySelector('.fg-warm-find__stage');
  const controls = Array.from(section.querySelectorAll('[data-fg-warm-spot]'));
  const panels = Array.from(section.querySelectorAll('[data-fg-warm-spot-panel]'));
  if (!stage || !controls.length) return;

  const select = (key) => {
    controls.forEach((control) => {
      const on = control.dataset.fgWarmSpot === key;
      control.classList.toggle('is-active', on);
      control.setAttribute('aria-pressed', on ? 'true' : 'false');
      if (on && control.dataset.x) {
        stage.style.setProperty('--fgw-x', `${control.dataset.x}%`);
        stage.style.setProperty('--fgw-y', `${control.dataset.y}%`);
      }
    });
    panels.forEach((panel) => panel.classList.toggle('is-active', panel.dataset.fgWarmSpotPanel === key));
  };

  controls.forEach((control) => {
    control.addEventListener('click', () => select(control.dataset.fgWarmSpot));
  });
}

/* The fixes table: the filters only hide rows. */
function initFixes(section) {
  const filters = Array.from(section.querySelectorAll('[data-fg-warm-filter]'));
  const rows = Array.from(section.querySelectorAll('[data-fg-warm-tags]'));
  const empty = section.querySelector('.fg-warm-fixes__empty');
  if (!filters.length || !rows.length) return;

  filters.forEach((filter) => {
    filter.addEventListener('click', () => {
      const key = filter.dataset.fgWarmFilter;
      let shown = 0;
      filters.forEach((other) => {
        const on = other === filter;
        other.classList.toggle('is-active', on);
        other.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      rows.forEach((row) => {
        const match = key === 'all' || row.dataset.fgWarmTags.split(' ').includes(key);
        row.hidden = !match;
        if (match) shown += 1;
      });
      if (empty) empty.hidden = shown > 0;
    });
  });
}

function init() {
  const root = document.querySelector('[data-fg-warm]');
  if (!root) return;
  root.classList.add('is-enhanced');
  root.querySelectorAll('[data-fg-warm-scope]').forEach(initScope);
  root.querySelectorAll('[data-fg-warm-tabs]').forEach(initTabs);
  root.querySelectorAll('[data-fg-warm-find]').forEach(initFind);
  root.querySelectorAll('[data-fg-warm-fixes]').forEach(initFixes);
  initCompare(root);
  initTools(root);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
