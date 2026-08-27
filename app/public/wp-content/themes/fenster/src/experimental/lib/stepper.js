/**
 * DISCRETE SECTION STEPPING.
 *
 * One gesture, one section. The timeline is no longer scrubbed by scroll
 * position: the visitor pushes the wheel once, the camera travels to the next
 * stop under its own power, and it holds there until they push again.
 *
 * That is a different contract from the scrubbed version and it is worth being
 * explicit about why it is better here. A scrubbed timeline makes the visitor
 * responsible for the pacing of a piece that has been carefully paced already —
 * they arrive at a station mid-transition, or fly past the specification
 * because a trackpad flick carried 900 pixels. Stepping hands the pacing back
 * to the thing that knows it, and the only decision left to the visitor is the
 * one they actually care about: *next*.
 *
 * The awkward part of any implementation like this is deciding what "one
 * gesture" means, because a wheel does not emit gestures. It emits a burst of
 * deltas — a trackpad flick can fire fifty events over a second and a half of
 * inertia, and a notched mouse wheel fires one big one. So:
 *
 *   - deltas accumulate rather than each one counting;
 *   - crossing the threshold fires exactly one step;
 *   - after firing, further deltas are SWALLOWED until the input has been
 *     quiet for `quiet` ms. That is what stops one flick becoming four steps.
 *
 * Touch is a swipe measured start-to-end, and the keyboard is one press per
 * step, which needs none of the above.
 */

/* Time-based, not frame-based. A tween driven by frame count runs at half
   speed on a 30fps machine and nobody notices until it is on a phone. */
const easeInOutCubic = (x) => (x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2);

export function buildStepper({
  stops,
  onArrive = () => {},
  onDepart = () => {},
  onExit = () => {},
  duration = 1600,
  quiet = 420,
  wheelThreshold = 40,
  swipeThreshold = 46,
} = {}) {
  if (!Array.isArray(stops) || stops.length < 2) {
    throw new Error('buildStepper needs at least two stops');
  }

  let index = 0;
  let from = stops[0];
  let to = stops[0];
  let elapsed = 0;
  let travelling = false;
  let value = stops[0];

  /* `armed` is the whole gesture-detection state machine. It starts true,
     goes false the moment a step fires, and comes back only after `quiet` ms
     with no input at all. */
  let armed = true;
  let accum = 0;
  let quietTimer = null;
  let enabled = true;
  let destroyed = false;
  /* PASSIVE is not the same as disabled, and the difference matters at the
     last stop. Disabled means the wheel is ignored entirely; passive means the
     document gets the wheel back — so the page can scroll on and a cross-origin
     iframe can be used — while a backward gesture made at the very top of the
     document still steps back into the sequence. Without it the visitor
     arrives at the final stop and has no way to return to the one before. */
  let passive = false;

  const clampIndex = (i) => Math.max(0, Math.min(stops.length - 1, i));

  function rearmAfterQuiet() {
    if (quietTimer) clearTimeout(quietTimer);
    quietTimer = setTimeout(() => {
      armed = true;
      accum = 0;
      quietTimer = null;
    }, quiet);
  }

  function step(dir) {
    const next = index + dir;

    /* Off either end is not a no-op — it is how the visitor leaves. Past the
       last stop hands the page back to the document below; before the first,
       back to whatever is above. The caller decides what that means. */
    if (next < 0 || next > stops.length - 1) {
      onExit(dir > 0 ? 'forward' : 'back');
      return false;
    }

    from = value;                 // from where it ACTUALLY is, not from the
    to = stops[next];             // stop it was supposed to be sitting on
    elapsed = 0;
    travelling = true;
    const previous = index;
    index = next;
    onDepart(index, previous);
    return true;
  }

  function gesture(dir) {
    if (!enabled || destroyed) return;
    if (!armed) { rearmAfterQuiet(); return; }
    armed = false;
    accum = 0;
    rearmAfterQuiet();
    step(dir);
  }

  /* ---- input ------------------------------------------------------------ */

  const onWheel = (e) => {
    if (!enabled || destroyed) return;

    if (passive) {
      /* Hand the wheel to the document, but watch for someone pushing back up
         while already at the top — that is a request to re-enter, not a scroll. */
      if (e.deltaY < 0 && window.scrollY <= 1 && armed) {
        armed = false;
        rearmAfterQuiet();
        step(-1);
      }
      return;
    }

    /* The stage owns the wheel while the experience is running. Without this
       the document scrolls underneath a fixed canvas, which looks like the
       page is broken rather than like it is being driven. */
    e.preventDefault();

    if (!armed) { rearmAfterQuiet(); return; }

    /* deltaMode 1 is lines, 2 is pages. Chrome reports pixels, Firefox lines,
       and a line is worth about sixteen pixels of intent. */
    const unit = e.deltaMode === 1 ? 16 : e.deltaMode === 2 ? 100 : 1;
    const d = e.deltaY * unit;

    // A change of direction abandons whatever was accumulating.
    if (accum !== 0 && Math.sign(d) !== Math.sign(accum)) accum = 0;
    accum += d;
    rearmAfterQuiet();

    if (Math.abs(accum) >= wheelThreshold) gesture(Math.sign(accum));
  };

  let touchY = null;
  const onTouchStart = (e) => { touchY = e.touches[0] ? e.touches[0].clientY : null; };
  const onTouchMove = (e) => {
    if (!enabled || destroyed || touchY === null) return;
    e.preventDefault();
    const y = e.touches[0] ? e.touches[0].clientY : touchY;
    const dy = touchY - y;
    if (Math.abs(dy) >= swipeThreshold) {
      touchY = null;              // one swipe, one step
      gesture(Math.sign(dy));
    }
  };
  const onTouchEnd = () => { touchY = null; };

  const FORWARD_KEYS = ['ArrowDown', 'PageDown', 'Space', ' ', 'ArrowRight'];
  const BACK_KEYS = ['ArrowUp', 'PageUp', 'ArrowLeft'];
  const onKey = (e) => {
    if (!enabled || destroyed) return;
    /* Never steal a key from something the visitor is typing into — the
       pricing configurator is a real form inside this page. */
    const el = document.activeElement;
    if (el && (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA'
      || el.tagName === 'IFRAME' || el.isContentEditable)) return;

    if (FORWARD_KEYS.includes(e.key) || FORWARD_KEYS.includes(e.code)) {
      e.preventDefault();
      if (!travelling) { armed = true; gesture(1); }
    } else if (BACK_KEYS.includes(e.key) || BACK_KEYS.includes(e.code)) {
      e.preventDefault();
      if (!travelling) { armed = true; gesture(-1); }
    } else if (e.key === 'Home') {
      e.preventDefault(); goTo(0);
    } else if (e.key === 'End') {
      e.preventDefault(); goTo(stops.length - 1);
    }
  };

  function attach(target) {
    /* `passive: false` or preventDefault is ignored and the page scrolls
       anyway — silently, because the browser only warns in the console. */
    target.addEventListener('wheel', onWheel, { passive: false });
    target.addEventListener('touchstart', onTouchStart, { passive: true });
    target.addEventListener('touchmove', onTouchMove, { passive: false });
    target.addEventListener('touchend', onTouchEnd, { passive: true });
    window.addEventListener('keydown', onKey);
  }

  function detach(target) {
    target.removeEventListener('wheel', onWheel);
    target.removeEventListener('touchstart', onTouchStart);
    target.removeEventListener('touchmove', onTouchMove);
    target.removeEventListener('touchend', onTouchEnd);
    window.removeEventListener('keydown', onKey);
  }

  /* ---- output ----------------------------------------------------------- */

  function update(dtMs) {
    if (!travelling) return value;
    elapsed += dtMs;
    const p = Math.min(1, elapsed / duration);
    value = from + (to - from) * easeInOutCubic(p);
    if (p >= 1) {
      value = to;
      travelling = false;
      onArrive(index);
    }
    return value;
  }

  function goTo(i, { instant = false } = {}) {
    const next = clampIndex(i);
    const previous = index;
    index = next;
    if (instant) {
      from = to = value = stops[next];
      travelling = false;
      onArrive(index);
    } else {
      from = value; to = stops[next]; elapsed = 0; travelling = true;
      onDepart(index, previous);
    }
  }

  return {
    attach, detach, update, goTo,
    get index() { return index; },
    get value() { return value; },
    get travelling() { return travelling; },
    get count() { return stops.length; },
    setEnabled(on) {
      enabled = !!on;
      if (!enabled) { accum = 0; armed = true; }
    },
    setPassive(on) { passive = !!on; accum = 0; armed = true; },
    get passive() { return passive; },
    /* Used when the visitor scrolls back UP into the experience from the
       document below: re-enter sitting on the last stop rather than snapping
       to wherever the tween was abandoned. */
    resetTo(i) { goTo(i, { instant: true }); },
    /* Take on a timeline position that came from somewhere else — the QA
       harness seeks by beat, not by section — and settle onto the nearest stop
       so the next gesture goes somewhere sensible. Without this the render
       loop would immediately tween back to whatever stop it thought it was on
       and every screenshot would be of the wrong beat. */
    adopt(v) {
      value = from = to = v;
      travelling = false;
      elapsed = 0;
      let best = 0;
      for (let i = 1; i < stops.length; i++) {
        if (Math.abs(stops[i] - v) < Math.abs(stops[best] - v)) best = i;
      }
      index = best;
    },
    destroy(target) { destroyed = true; if (quietTimer) clearTimeout(quietTimer); detach(target); },
  };
}
