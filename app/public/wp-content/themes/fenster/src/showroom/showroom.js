/**
 * The showroom viewer.
 *
 * A turntable, not a tour. One product on a plain ground, drag to turn it, a
 * button to open it, a button to put it back. It is imported only when the
 * visitor asks for 3D — the page it sits in is complete and indexable without
 * a byte of this file.
 *
 * THREE DECISIONS WORTH THE COMMENT:
 *
 * 1. RENDER ON DEMAND. There is no permanent animation loop. A frame is drawn
 *    when something changes and never otherwise, so a parked turntable costs
 *    nothing at all — no battery on a phone, no fan on a laptop, and no frames
 *    spent on a product that is standing still. The audited page's constant
 *    loop ran at 17-19fps whether anything was moving or not.
 *
 * 2. THE PAGE KEEPS THE WHEEL. Vertical drag scrolls the document, horizontal
 *    drag turns the product; `touch-action: pan-y` in the stylesheet is what
 *    splits them. Nothing here calls preventDefault on a scroll.
 *
 * 3. ONE MODEL IN MEMORY. Switching product disposes the previous one before
 *    fetching the next. three.js will happily leak every geometry and material
 *    you stop referencing, and the acceptance gate for these pages is that
 *    `renderer.info.memory` returns to baseline after ten switches.
 */

import { buildStage } from './lib/stage.js';
import { loadProduct } from './lib/loader.js';

const REST_YAW = 0.44;
const REST_PITCH = 0.12;
const YAW_LIMIT = 0.61;   // ~35 degrees either side of rest
const PITCH_MIN = -0.10;
const PITCH_MAX = 0.34;

export async function mount(root, section) {
  const canvas = root.querySelector('[data-sr-canvas]');
  const frame = root.querySelector('.fg-sr__frame');
  const tools = root.querySelector('[data-sr-tools]');
  const openBtn = root.querySelector('[data-sr-open]');
  const resetBtn = root.querySelector('[data-sr-reset]');
  const loading = root.querySelector('[data-sr-loading]');
  const progress = root.querySelector('[data-sr-progress]');
  const base = root.getAttribute('data-model-base') || '';
  if (!canvas || !frame) return null;

  const rect = frame.getBoundingClientRect();
  const stage = buildStage(canvas, {
    width: Math.max(320, Math.round(rect.width)),
    height: Math.max(240, Math.round(rect.height)),
  });

  let current = null;      // the loaded product
  let currentId = null;
  let yaw = REST_YAW;
  let pitch = REST_PITCH;
  let open = 0;
  let frameQueued = false;
  let disposed = false;
  let currentBox = null;   // measured once per product, see stage.frame()
  let loadToken = 0;       // guards against a switch landing out of order

  /* One frame, on the next tick, however many times it is asked for. */
  function invalidate() {
    if (frameQueued || disposed) return;
    frameQueued = true;
    requestAnimationFrame(() => {
      frameQueued = false;
      if (disposed || !current) return;
      stage.frame(current.holder, { fill: 0.80, yaw, pitch, box: currentBox });
      stage.render();
    });
  }

  function setLoading(on, pct) {
    if (!loading) return;
    loading.hidden = !on;
    if (progress) progress.style.width = `${Math.round((pct || 0) * 100)}%`;
  }

  async function show(file, id, material) {
    if (!file || disposed) return;
    /* A TOKEN, because clicking through the rail faster than the models load
       is not an edge case, it is what browsing looks like. Without it a second
       switch disposes the first product, then the FIRST load resolves and
       assigns itself as `current` — orphaning a model that nothing will ever
       dispose. Measured: ten quick switches leaked 39 geometries. */
    const token = ++loadToken;
    setLoading(true, 0);

    if (current) {
      current.dispose();
      current = null;
      currentBox = null;
    }

    let product;
    try {
      product = await loadProduct(base + file, {
        targetHeight: 2.0,
        onProgress: (p) => { if (token === loadToken) setLoading(true, p * 0.95); },
      });
    } catch (e) {
      /* The poster is still underneath and the page still works. A viewer that
         fails should look like a viewer that was never asked for. */
      setLoading(false, 0);
      frame.classList.remove('is-live');
      console.warn('[showroom] could not load', file, e);
      return;
    }
    // Superseded while it was in flight, or the whole viewer went away.
    if (disposed || token !== loadToken) { product.dispose(); return; }

    current = product;
    currentId = id;
    stage.scene.add(product.holder);
    currentBox = stage.standOn(product.holder);
    open = 0;
    product.setOpen(0);

    /* The open control only exists for products that open. A disabled button
       beside a fixed pane is an answer to a question nobody asked. */
    if (openBtn) {
      openBtn.hidden = !product.animated;
      openBtn.setAttribute('aria-pressed', 'false');
      openBtn.textContent = openBtn.getAttribute('data-label-open') || openBtn.textContent;
    }

    setLoading(false, 1);
    frame.classList.add('is-live');
    if (tools) tools.hidden = false;
    showFinishesFor(material);
    invalidate();
  }

  /* ---- turning it ------------------------------------------------------- */

  let dragging = false;
  let lastX = 0;
  let lastY = 0;

  function onDown(e) {
    if (!current) return;
    dragging = true;
    lastX = e.clientX;
    lastY = e.clientY;
    canvas.setPointerCapture?.(e.pointerId);
    canvas.style.cursor = 'grabbing';
  }
  function onMove(e) {
    if (!dragging || !current) return;
    const dx = e.clientX - lastX;
    const dy = e.clientY - lastY;
    lastX = e.clientX;
    lastY = e.clientY;
    yaw = Math.max(REST_YAW - YAW_LIMIT, Math.min(REST_YAW + YAW_LIMIT, yaw + dx * 0.006));
    pitch = Math.max(PITCH_MIN, Math.min(PITCH_MAX, pitch - dy * 0.004));
    invalidate();
  }
  function onUp(e) {
    dragging = false;
    canvas.releasePointerCapture?.(e.pointerId);
    canvas.style.cursor = 'grab';
  }

  canvas.style.cursor = 'grab';
  canvas.addEventListener('pointerdown', onDown);
  canvas.addEventListener('pointermove', onMove);
  canvas.addEventListener('pointerup', onUp);
  canvas.addEventListener('pointercancel', onUp);

  /* Keyboard, because a drag-only control is not operable without a mouse. */
  canvas.tabIndex = 0;
  canvas.setAttribute('role', 'img');
  canvas.addEventListener('keydown', (e) => {
    if (!current) return;
    const step = 0.09;
    if (e.key === 'ArrowLeft') { yaw = Math.max(REST_YAW - YAW_LIMIT, yaw - step); }
    else if (e.key === 'ArrowRight') { yaw = Math.min(REST_YAW + YAW_LIMIT, yaw + step); }
    else if (e.key === 'ArrowUp') { pitch = Math.min(PITCH_MAX, pitch + step * 0.6); }
    else if (e.key === 'ArrowDown') { pitch = Math.max(PITCH_MIN, pitch - step * 0.6); }
    else return;
    e.preventDefault();
    invalidate();
  });

  /* ---- opening it ------------------------------------------------------- */

  let openAnim = null;
  const REDUCED = window.matchMedia
    && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function animateOpen(to) {
    if (!current || !current.animated) return;
    /* Reduced motion gets the RESULT, not the journey. The door still opens —
       withholding the information would be the wrong reading of the setting —
       it just arrives there without the travel. */
    if (REDUCED) {
      open = to;
      current.setOpen(open);
      invalidate();
      return;
    }
    const from = open;
    const start = performance.now();
    const dur = 900;
    if (openAnim) cancelAnimationFrame(openAnim);
    const tick = (now) => {
      if (disposed || !current) return;
      const p = Math.min(1, (now - start) / dur);
      // smootherstep, so it eases at both ends without overshooting
      const e = p * p * p * (p * (p * 6 - 15) + 10);
      open = from + (to - from) * e;
      current.setOpen(open);
      stage.frame(current.holder, { fill: 0.80, yaw, pitch, box: currentBox });
      stage.render();
      if (p < 1) openAnim = requestAnimationFrame(tick);
      else openAnim = null;
    };
    openAnim = requestAnimationFrame(tick);
  }

  openBtn?.addEventListener('click', () => {
    const next = open > 0.5 ? 0 : 1;
    openBtn.setAttribute('aria-pressed', String(next === 1));
    animateOpen(next);
  });

  resetBtn?.addEventListener('click', () => {
    yaw = REST_YAW;
    pitch = REST_PITCH;
    if (openBtn) openBtn.setAttribute('aria-pressed', 'false');
    if (current && current.animated) animateOpen(0); else invalidate();
  });

  /* ---- the finish -------------------------------------------------------
     The frame only. Glass keeps whatever it had, because a "finish" on a
     window is the frame colour and tinting the glazing would be a different
     product. `loadProduct` indexes materials by the role written into their
     name by the optimiser, so this is one assignment. */
  function setFinish(hex) {
    if (!current) return;
    const frames = current.materials.frame || [];
    if (!frames.length) return;
    for (const m of frames) {
      m.color.set(hex);
      /* Powder coat and foil are both close to matt. Left alone, a pale colour
         on the default roughness reads as plastic. */
      m.roughness = Math.min(0.85, Math.max(0.35, m.roughness));
      m.needsUpdate = true;
    }
    invalidate();
  }

  function showFinishesFor(material) {
    section.querySelectorAll('[data-sr-finishes]').forEach((el) => {
      el.hidden = el.getAttribute('data-sr-finishes') !== material;
    });
  }

  section.querySelectorAll('[data-sr-finish]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const group = btn.closest('[data-sr-finishes]');
      group?.querySelectorAll('[data-sr-finish]').forEach((b) => b.setAttribute('aria-pressed', 'false'));
      btn.setAttribute('aria-pressed', 'true');
      setFinish(btn.getAttribute('data-sr-finish'));
    });
  });

  /* ---- switching product ------------------------------------------------ */

  section.addEventListener('showroom:select', (e) => {
    const btn = section.querySelector(`[data-sr-select="${e.detail.slug}"]`);
    if (!btn) return;
    const file = btn.getAttribute('data-sr-model');
    if (!file || e.detail.id === currentId) return;
    show(file, e.detail.id, btn.getAttribute('data-sr-material'));
  });

  /* ---- size --------------------------------------------------------------
     Observed rather than listened for on window resize, so a layout change
     that is not a window resize (the panel becoming sticky, a font landing)
     is still handled. */
  const ro = new ResizeObserver((entries) => {
    for (const entry of entries) {
      const w = Math.max(320, Math.round(entry.contentRect.width));
      const h = Math.max(240, Math.round(entry.contentRect.height));
      stage.resize(w, h);
      invalidate();
    }
  });
  ro.observe(frame);

  /* ---- go --------------------------------------------------------------- */

  const active = section.querySelector('[data-sr-select][aria-pressed="true"]')
    || section.querySelector('[data-sr-select]');
  if (active) {
    await show(
      active.getAttribute('data-sr-model'),
      active.getAttribute('data-sr-model-id'),
      active.getAttribute('data-sr-material')
    );
  }

  return {
    destroy() {
      disposed = true;
      ro.disconnect();
      if (openAnim) cancelAnimationFrame(openAnim);
      current?.dispose();
      stage.dispose();
      frame.classList.remove('is-live');
    },
    /** Exposed for verification probes. */
    get product() { return current; },
    setFinish,
    get renderer() { return stage.renderer; },
    /* The stage itself, so a probe can time a render directly rather than
       inferring cost from requestAnimationFrame — which in a headless browser
       is throttled and tells you about the compositor, not the scene. */
    get stage() { return stage; },
    invalidate,
  };
}
