/**
 * THE FENSTER ATRIUM
 * ==========================================================================
 * A scroll-driven cinematic scene for /fenster-new-home-page/.
 *
 * An impossible Fenster showroom: a dark architectural gallery with the mark
 * suspended in it, the real product range installed along its length, and the
 * configurator the business quotes from waiting at the far end. Scrolling
 * moves the camera through it in one continuous shot.
 *
 * Every product is genuine WindowCAD geometry — the same scene the business
 * quotes from, exported as real meshes. Seven models carry a baked open/close
 * clip and scroll SCRUBS it, so scrolling physically opens the product rather
 * than playing a video of one opening.
 *
 * ------------------------------------------------------------------------
 * PASS TWO
 *
 * Pass one proved the engineering. It also had a fixed column of headline and
 * body copy down the left of every shot, which meant the honest description of
 * the result was "a website with a very impressive 3D background". Pass two is
 * the art direction:
 *
 *   - The copy column is gone. Information is now geometry — callouts with
 *     hairline leaders, type lying on the floor, numbered steps standing in
 *     the room. See lib/annotations.js.
 *   - There is an actual building. Floor, fins, portal, material bay, pricing
 *     chamber, light in the shadow gaps. See lib/architecture.js.
 *   - The rig is built around two travelling softboxes, which is how a dark
 *     object is photographed in a dark room. See lib/lighting.js. (Pass one's
 *     RectAreaLights were never initialised and emitted nothing at all.)
 *   - The camera runs on a keyframe track with real interpolation instead of
 *     a sum of overlapping bell curves, which is where most of the jank was.
 *   - Everything with mass moves on a critically damped spring, so a door
 *     lags scroll slightly and settles rather than tracking it exactly.
 *   - Depth of field, and contact shadows under everything.
 *
 * Structure:
 *   atrium.js            this file — setup, choreography, render loop
 *   lib/materials.js     GLB material classification, glass, the light sweep
 *   lib/mark.js          the extruded logo
 *   lib/products.js      model loading and the orbit
 *   lib/architecture.js  the room: floor, shell, portal, bay, chamber
 *   lib/lighting.js      the softbox rig and the per-shot lighting moods
 *   lib/annotations.js   spatial information — callouts, floor type, steps
 *   lib/atmosphere.js    dust, glass, ground, backdrop, light wall
 *   lib/typography.js    monumental world type and dimension lines
 *   lib/terminal.js      the WindowCAD terminal
 *   lib/post.js          depth of field, bloom, the finishing grade
 *
 * See `assets/experimental/README.md` for the whole architecture.
 */
import * as THREE from 'three';
import Lenis from 'lenis';

import { buildStudioEnvironment } from './lib/studio.js';
import { BRAND, FINISHES, linearColour, recolour, setSweep, setGlassRefraction } from './lib/materials.js';
import { buildMark } from './lib/mark.js';
import { ProductLoader } from './lib/products.js';
import { buildLightRig } from './lib/lighting.js';
import {
  buildFloor, buildShell, buildChamber,
  buildGlassHall, buildContactShadow, buildColonnade, buildVWall, buildScreen, buildFloorMirror, mergeStatic, resetSeamMaterials, PORTAL_SILL,
} from './lib/architecture.js';
import { buildDust, buildBackdrop, buildLightWall } from './lib/atmosphere.js';
import { buildWord, buildDimension } from './lib/typography.js';
import { buildCallout, buildFloorText, buildSwingArc, buildStep } from './lib/annotations.js';
import { buildTerminal } from './lib/terminal.js';
import { buildComposer } from './lib/post.js';
import { buildStepper } from './lib/stepper.js';

/* ========================================================================== */
/* small maths                                                                */
/* ========================================================================== */

const clamp = (v, a = 0, b = 1) => Math.min(b, Math.max(a, v));
const lerp = (a, b, t) => a + (b - a) * t;
/** 0 before `a`, 1 after `b`, smoothly in between. The workhorse. */
const span = (t, a, b) => {
  const x = clamp((t - a) / (b - a));
  return x * x * (3 - 2 * x);
};
/** A pulse peaking at `centre`. Used for one-off beats inside a phase. */
const bell = (t, centre, width) => {
  const x = clamp(Math.abs(t - centre) / width);
  return 1 - x * x * (3 - 2 * x);
};
const easeInOutCubic = (x) => (x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2);

/** Shared, because several blocks build a camera basis from it. */
const WORLD_UP = new THREE.Vector3(0, 1, 0);

/** Deterministic RNG so the composition is identical on every load. */
function makeRng(seed) {
  let s = seed >>> 0;
  return () => {
    s = (s + 0x6d2b79f5) >>> 0;
    let x = Math.imul(s ^ (s >>> 15), 1 | s);
    x = (x + Math.imul(x ^ (x >>> 7), 61 | x)) ^ x;
    return ((x ^ (x >>> 14)) >>> 0) / 4294967296;
  };
}

/* -------------------------------------------------------------- the track */

/**
 * Sample a keyframe track with a cardinal spline.
 *
 * PASS ONE'S CAMERA WAS A SUM OF BELL CURVES, AND THAT IS WHERE THE JANK WAS.
 * `lerp(11.6, 8.4, span(...)) - 3.0 * bell(t, 0.27, 0.09) + ...` looks
 * controllable and is not: every term contributes acceleration everywhere, two
 * overlapping bells can cancel and then un-cancel, and a `Math.max(2.4, dolly)`
 * clamp puts a corner in the velocity at the exact moment the camera is moving
 * fastest. There is no way to reason about the result except by watching it.
 *
 * A track is the opposite. Each beat is a pose the camera passes through, the
 * spline guarantees continuous position and velocity between them, and a beat
 * can be retimed by editing one number without disturbing its neighbours.
 */
function sampleTrack(keys, t, outPos, outLook) {
  let i = 0;
  while (i < keys.length - 2 && t > keys[i + 1].t) i++;

  const k1 = keys[i];
  const k2 = keys[i + 1];
  const k0 = keys[Math.max(0, i - 1)];
  const k3 = keys[Math.min(keys.length - 1, i + 2)];

  const dt = k2.t - k1.t;
  const u = dt > 1e-6 ? clamp((t - k1.t) / dt) : 0;
  const u2 = u * u;
  const u3 = u2 * u;

  /* Cardinal spline. Tangents come from the neighbours, scaled by this
     segment's share of their spacing so uneven beat lengths do not produce a
     kick at the join — which they do with a uniform Catmull-Rom, and it shows
     as a lurch every time a long beat meets a short one. */
  /* TENSION. A cardinal spline through monotonic points is not itself
     monotonic — it overshoots each key by an amount proportional to the
     tangent, and on a camera that only ever moves forward that overshoot IS a
     backward step. Measured at full tangent: a worst single reversal of 0.77m
     and six metres of total backtracking over the run. Scaling the tangents
     costs a little of the ease into each pose and removes almost all of it. */
  const TENSION = 0.62;
  const s1 = TENSION * dt / Math.max(1e-6, k2.t - k0.t);
  const s2 = TENSION * dt / Math.max(1e-6, k3.t - k1.t);

  const h1 = 2 * u3 - 3 * u2 + 1;
  const h2 = -2 * u3 + 3 * u2;
  const h3 = u3 - 2 * u2 + u;
  const h4 = u3 - u2;

  for (const [out, field] of [[outPos, 'p'], [outLook, 'l']]) {
    for (let a = 0; a < 3; a++) {
      const p0 = k0[field][a], p1 = k1[field][a], p2 = k2[field][a], p3 = k3[field][a];
      const m1 = (p2 - p0) * s1;
      const m2 = (p3 - p1) * s2;
      out.setComponent(a, h1 * p1 + h2 * p2 + h3 * m1 + h4 * m2);
    }
  }
  // Scalars ride along on plain smoothstep; they are never fast enough to need
  // spline continuity and this keeps them predictable.
  const e = u2 * (3 - 2 * u);
  return {
    roll: lerp(k1.roll ?? 0, k2.roll ?? 0, e),
    fov: lerp(k1.fov ?? 38, k2.fov ?? 38, e),
  };
}

/* --------------------------------------------------------- arc length */

/**
 * How far the camera has actually travelled by `t`.
 *
 * Built once, by walking the track at fine resolution and accumulating
 * distance. It exists so the mark can spin like a WHEEL: rotation proportional
 * to ground covered, which means it turns while the camera is moving between
 * stations and comes to rest by itself when the camera arrives at one. No
 * timers, no state — and because it is a pure function of `t` the whole thing
 * stays reversible, which a velocity integrator would not be.
 */
function buildArcTable(keys, samples = 400) {
  const table = new Float32Array(samples + 1);
  const a = new THREE.Vector3();
  const b = new THREE.Vector3();
  const junk = new THREE.Vector3();
  sampleTrack(keys, 0, a, junk);
  let total = 0;
  for (let i = 1; i <= samples; i++) {
    sampleTrack(keys, i / samples, b, junk);
    total += a.distanceTo(b);
    table[i] = total;
    a.copy(b);
  }
  return { table, total, samples };
}

/** Distance travelled at `t`, in metres, interpolated between samples. */
function arcAt(arc, t) {
  const x = Math.min(1, Math.max(0, t)) * arc.samples;
  const i = Math.floor(x);
  const f = x - i;
  const lo = arc.table[i];
  const hi = arc.table[Math.min(arc.samples, i + 1)];
  return lo + (hi - lo) * f;
}

/* ------------------------------------------------------------ mass */

/**
 * A critically damped spring.
 *
 * The brief asked for objects that feel heavy — a door that lags scroll very
 * slightly and settles, never overshoots, never springs. That is exactly a
 * critically damped second-order system, and the closed-form solution below is
 * unconditionally stable at any timestep, which a naive `pos += (target-pos)*k`
 * is not: that one is frame-rate dependent, so the same scroll feels different
 * at 60Hz and 144Hz. This was a real source of the "slightly janky" reading.
 */
class Spring3 {
  constructor(omega = 9) {
    this.omega = omega;
    this.value = new THREE.Vector3();
    this.velocity = new THREE.Vector3();
    this._dx = new THREE.Vector3();
  }

  step(target, dt) {
    const w = this.omega;
    const e = Math.exp(-w * dt);
    this._dx.subVectors(this.value, target);
    // x(t) = target + (dx + (v + w*dx)t) e^{-wt}
    // v(t) = (v - w(v + w*dx)t) e^{-wt}
    for (let i = 0; i < 3; i++) {
      const dx = this._dx.getComponent(i);
      const v = this.velocity.getComponent(i);
      const c = v + w * dx;
      this.value.setComponent(i, target.getComponent(i) + (dx + c * dt) * e);
      this.velocity.setComponent(i, (v - w * c * dt) * e);
    }
    return this.value;
  }

  /** Land on the target immediately. Used when the QA harness seeks. */
  snap(target) {
    this.value.copy(target);
    this.velocity.set(0, 0, 0);
    return this.value;
  }
}

/* ========================================================================== */
/* capability tiers                                                           */
/* ========================================================================== */

/**
 * Pick a quality tier. Depth of field and transmissive glass are the expensive
 * parts — each costs a whole extra render of the scene per frame — so they are
 * the first things to go, and the tier is gated on a real GPU rather than on
 * screen width, because a Mac laptop at 1440 and a cheap Android at 1440 are
 * not the same machine.
 */
function detectQuality() {
  const canvas = document.createElement('canvas');
  const gl = canvas.getContext('webgl2') || canvas.getContext('webgl');
  if (!gl) return { tier: 'none', reason: 'no webgl' };

  const dbg = gl.getExtension('WEBGL_debug_renderer_info');
  const renderer = dbg ? String(gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL)) : '';
  const mem = navigator.deviceMemory || 4;
  const cores = navigator.hardwareConcurrency || 4;
  const coarse = window.matchMedia('(pointer: coarse)').matches;
  const narrow = window.innerWidth < 860;

  const software = /swiftshader|llvmpipe|software|microsoft basic/i.test(renderer);
  if (software) return { tier: 'low', reason: 'software renderer', renderer };
  if (narrow || coarse) {
    return { tier: mem >= 6 && cores >= 6 ? 'medium' : 'low', reason: 'touch/narrow', renderer };
  }
  if (mem <= 4 || cores <= 4) return { tier: 'medium', reason: 'modest desktop', renderer };
  return { tier: 'high', reason: 'desktop', renderer };
}

/* ========================================================================== */
/* the gallery plan                                                           */
/* ========================================================================== */

/**
 * Where each set stands, in metres along the room.
 *
 * The camera travels the length of the gallery rather than staying put while
 * scenery is flown past it. That is the difference between a stage and a
 * building, and it is what lets the camera move behind things.
 */
const FLOOR_Y = -2.6;
/* EVERY STATION NEEDS ABOUT EIGHTEEN METRES OF RUN, AND ONE OF THEM HAD TEN.
 *
 * The grammar in buildCameraTrack asks for a hold 8.5m in front of the product
 * plane, and an approach behind that. v1 -> v2 is 18m and v3 -> v4 is 18m, but
 * dropping the bifold screen in at -42 left only 10m between it and v3.
 *
 * The camera cannot reverse, so the backstop quietly clamped v3's hold 4.5m
 * further down the gallery than it was authored — and at that distance the
 * composite door and the heritage door project to ndc +/-1.12. Both products at
 * the door station were entirely outside the frame at their own hero beat, and
 * nothing errored, because a camera pose that has been clamped is still a
 * perfectly valid camera pose. Only comparing authored against actual found it:
 * v1, v2 and v4 came back shifted by 0.0 and v3 by -4.5.
 *
 * So v3 and everything past it moves back 8m. The screen gets the same run-out
 * as every other station instead of being wedged into a gap.
 */
/**
 * TWO ROUTES THROUGH THE SAME BUILDING.
 *
 * The gallery was originally one hard-coded run of four stations covering the
 * whole catalogue. It is now laid out from a list, because the windows and the
 * doors each want their own walk: a homeowner looking at bifolds is not also
 * shopping for a sliding sash, and a route that mixes them makes both journeys
 * longer than they need to be.
 *
 * Everything that used to be a hand-tuned constant — the z of each station,
 * the timeline beat of each pose — is DERIVED from this list now. That is not
 * tidiness for its own sake: the old table had four stations' worth of beats
 * typed out to three decimal places, and moving one station meant re-timing
 * every pose after it by hand. Twice that was got wrong in a way that only
 * showed up as a clamped camera pose, which looks exactly like an authored one.
 *
 * Add a station, or drop one, and the timeline re-lays itself.
 */
const GROUPS = {
  windows: {
    /* Four models, so two stations. A pair per station is the arrangement that
       works — two related products, seen together, with both specifications in
       the same frame. */
    stations: [
      { key: 'w1', left: 'casement', right: 'sash', splay: 0.42, sill: PORTAL_SILL },
      { key: 'w2', left: 'alu-window', right: 'flush', splay: 0.38, sill: PORTAL_SILL, finish: true },
    ],
    screen: null,
    /* The word standing in the room, and the floor legend. */
    word: 'WINDOWS',
  },
  /* THE EXPERIMENT'S OWN ROUTE — the whole catalogue in one walk, which is what
     /fenster-new-home-page/ has always been. Kept as a named group so
     parameterising the engine for the showrooms did not quietly re-cut a page
     that was already signed off. It is also the only route that still uses the
     unoptimised models and the plain `manifest.json`. */
  catalogue: {
    stations: [
      { key: 'v1', left: 'casement', right: 'sash', splay: 0.42, sill: PORTAL_SILL },
      { key: 'v2', left: 'alu-window', right: 'flush', splay: 0.38, sill: PORTAL_SILL },
      { key: 'v3', left: 'composite', right: 'heritage-door', splay: 0.46, sill: 0, finish: true },
      { key: 'v4', left: 'alu-slider', right: 'upvc-slider', splay: 0.40, sill: 0 },
    ],
    screen: { id: 'bifold', after: 2 },
    word: 'WINDOWS',
  },
  doors: {
    stations: [
      { key: 'd1', left: 'composite', right: 'heritage-door', splay: 0.46, sill: 0, finish: true },
      { key: 'd2', left: 'alu-door', right: 'slide-fold', splay: 0.40, sill: 0 },
      { key: 'd3', left: 'alu-slider', right: 'upvc-slider', splay: 0.44, sill: 0 },
    ],
    /* The bifold gets the screen: glazed across the whole route, folding open
       to let the visitor through. It is the one product in the range whose
       entire purpose is that the opening goes away, and standing it in a wall
       like the others would waste it. Inserted after the first station. */
    screen: { id: 'bifold', after: 1 },
    word: 'DOORS',
  },
};

/* Metres between one station and the next. Every station needs about this much:
   the camera grammar asks for a hold ~8m in front of the product plane with an
   approach behind it, and squeezing the bifold screen into a 10m gap once left
   a station's hold clamped 4.5m off its mark, with both doors at ndc +/-1.12 —
   entirely outside the frame at their own hero beat. */
const SPACING = 18;

let STATION = { mark: 0, pricing: -96 };
let V_STATIONS = [];
let SCREEN = null;          // { id, z, in, read, open, through } or null
let HERO_IDS = [];
let GROUP_WORD = 'WINDOWS';

/**
 * Lay the route out in space and in time.
 *
 * Space: the mark at 0, then a stop every SPACING metres, the pricing chamber
 * one spacing past the last.
 *
 * Time: the mark keeps the first 9%, the terminal the last 7%, and everything
 * between is divided evenly between the stops. Each station spends its slice
 * on the same four poses the grammar has always used — approach, hold, push,
 * leave — and the screen on its own four.
 */
function configureGroup(name) {
  const group = GROUPS[name] || GROUPS.windows;
  GROUP_WORD = group.word;

  // --- space -------------------------------------------------------------
  const stops = [];
  group.stations.forEach((st, i) => {
    stops.push({ kind: 'station', def: st });
    if (group.screen && group.screen.after === i + 1) {
      stops.push({ kind: 'screen', def: group.screen });
    }
  });

  STATION = { mark: 0 };
  stops.forEach((stop, i) => {
    stop.z = -SPACING * (i + 1);
  });
  STATION.pricing = -SPACING * (stops.length + 1);

  // --- time --------------------------------------------------------------
  const START = 0.09;         // the mark has everything before this
  const END = 0.93;           // the terminal has everything after
  const slice = (END - START) / stops.length;

  V_STATIONS = [];
  SCREEN = null;

  stops.forEach((stop, i) => {
    const t0 = START + slice * i;
    if (stop.kind === 'station') {
      V_STATIONS.push({
        ...stop.def,
        z: stop.z,
        gap: 1.5,
        in: t0 + slice * 0.02,
        hold: t0 + slice * 0.46,
        push: t0 + slice * 0.72,
        out: t0 + slice * 0.98,
      });
    } else {
      SCREEN = {
        id: stop.def.id,
        z: stop.z,
        in: t0 + slice * 0.02,
        /* `read` is not a camera beat, it is where the DOORS are most worth
           looking at: about two-thirds folded, so the concertina is legible as
           a concertina and there is still door in the opening. */
        read: t0 + slice * 0.44,
        open: t0 + slice * 0.62,
        through: t0 + slice * 0.98,
      };
    }
  });

  HERO_IDS = V_STATIONS.flatMap((v) => [v.left, v.right]);
  if (SCREEN) HERO_IDS.push(SCREEN.id);
}

/* A default so anything evaluated at module load has real numbers to work
   with. The instance re-runs this from its own group before it builds. */
configureGroup('catalogue');

/* Kept as a name because a great deal of the choreography reads it, and the
   screen beat is simply absent on a route that has no screen. */
const BIFOLD_BEAT_FALLBACK = { in: 0.54, read: 0.57, open: 0.59, through: 0.62 };

/* THE DWELL WARP IS GONE, and it is worth saying why rather than just
 * deleting it.
 *
 * It bent scroll position into timeline position so that more scrolling was
 * spent at the station holds than in the gallery between them — the answer to
 * "it should slow right down at a USP section" while the timeline was still
 * scrubbed. It worked: measured, a hold ran at 0.5-2.0 metres of camera travel
 * per 2.5% of page scroll against 5-9.9 in the gallery.
 *
 * Then the model changed. The timeline is stepped now: seven stops, one
 * gesture each, and the camera stops dead at every one of them. "Slow right
 * down at a USP section" is no longer something the scroll mapping has to
 * arrange — it is what a stop IS. Keeping a monotonic 2048-entry lookup table
 * to redistribute a scroll position nothing reads any more would be a fair
 * amount of machinery in service of nothing.
 *
 * The runway went with it: 3200vh of empty div became 100vh, because scroll
 * position no longer means anything to the choreography. See buildStepper in
 * lib/stepper.js.
 */


/** The screen's own beat: approach shut, fold open, travel through. */

/**
 * The camera track, generated from the station table.
 *
 * Each station contributes the same five-pose grammar, and it is a grammar
 * rather than a set of coordinates because there are four of them now and
 * hand-authoring forty keyframes produces a wall of numbers nobody will ever
 * re-time:
 *
 *   IN    wide and central, both leaves of the V in shot at an angle
 *   NEAR  swung to one side, the near wall raking, its product the subject
 *   FAR   swung across, the other product the subject
 *   LINE  back to the centre line, squared up on the gap
 *   OUT   through the gap
 *
 * `OUT` and the next `IN` are deliberately continuous in x and close in z, so
 * the handover between stations is a travel rather than a cut.
 */
/**
 * Where a product ends up in a V station, in world space.
 *
 * The camera track is built at module load, before any model has been fetched,
 * so it cannot ask the geometry where anything is — but it can work it out.
 * Every product is normalised to the same 2.35m height, so every opening is
 * the same 2.09m wide, and the rest is the leaf's own hinge geometry.
 *
 * This matters because aiming the camera at a guessed position is what put it
 * INSIDE the casement: the "near" pose looked at x = -1.3 while the product it
 * was meant to be framing sat at x = -4.14, so the window filled the left edge
 * of frame and the lens passed through it.
 */
/* Clear reveal on both jambs and the head. The wall is drawn in a ~0.09
   module (the lining bar, the 0.05 shadow gap), so 0.20 clears the lining and
   leaves about one module of visible lining face between the product edge and
   the wall face. Under 0.09 reproduces the interpenetration this replaced;
   much over 0.25 brings back the door station's field of empty wall. */
const REVEAL_MARGIN = 0.20;

/* The lens the holds are composed for, in one place, because two separate
   pieces of code have to agree about it: the one that decides how far back to
   stand, and the one that measures whether everything fitted. */
const FRAME = {
  tanHalf: Math.tan((38 * Math.PI) / 360),   // 38 deg vertical
  get perMetre() { return this.tanHalf * (16 / 9); },  // half-WIDTH per metre
  edgeX: 0.94,      // how near the frame edge a block may sit
  edgeY: 0.43,      // half-height a product may occupy
};
/* The narrow pier beside the gap. 0.34, not the old 0.6: the openings grew to
   fit their products, so the pier is where the width has to come back from if
   the pair is to sit closer to the centre line. */
const INNER_PIER = 0.34;

/* THE MEASURED SLOT, WITH A PREDICTION ONLY AS A FALLBACK.
 *
 * This used to be pure arithmetic off V_OPENING_W, a module-level constant, so
 * the camera aimed at where a product WOULD be if every opening were the same
 * size. They are not any more — each hole is built to its own product — so the
 * prediction is now wrong by up to half a metre, and it was already the reason
 * an earlier pass flew the lens through the casement.
 *
 * `geom` is filled in by buildStations once the models have actually been
 * measured, and the camera track is rebuilt from it. The fallback exists only
 * so the track can be constructed before any model has loaded. */
function slotAt(v, side, geom) {
  const g = geom && geom[v.key];
  if (g) {
    const sl = g.slots[side < 0 ? 0 : 1];
    return { x: sl.x, z: v.z + sl.z };
  }
  const lx = INNER_PIER + 1.2;
  return {
    x: side * (v.gap / 2 + lx * Math.cos(v.splay)),
    z: v.z + lx * Math.sin(v.splay),
  };
}

/* How far in front of the product plane the hold sits.
 *
 * It was a flat 8.5 metres at every station, which is only right if every
 * station is the same width — and once the openings are built per product they
 * are emphatically not. The two doors span ±1.74 where the windows span ±2.44,
 * so a fixed distance leaves the doors as a pair of slivers in the middle of
 * an empty frame. Solving for the distance that puts the outermost thing in
 * shot at a fixed fraction of frame width makes every station read at the same
 * scale, which is the whole point of a hold. */
function holdDistance(v, geom) {
  const g = geom && geom[v.key];
  if (!g) return 8.5;
  const TAN_HALF = FRAME.tanHalf;
  const PER_METRE = FRAME.perMetre;
  const EDGE = FRAME.edgeX;
  const BLOCK = 0.74;         // first-pass estimate, before anything exists

  /* TWO CONSTRAINTS, AND THE BINDING ONE WINS.
   *
   * Width alone is not enough, and solving it that way is a good illustration
   * of why: the two doors are narrow, so a width-only solution pulled the
   * camera in to 5.3m — at which point a 2.35m door measured 1.21 and 1.27 of
   * NDC height, i.e. taller than the frame, and both were cropped top and
   * bottom. A station is framed by whichever of its dimensions runs out first. */
  let outer = 0, tallest = 0;
  g.slots.forEach((sl, k) => {
    const productW = g.openings[k].width - REVEAL_MARGIN * 2;
    const productH = g.openings[k].height - REVEAL_MARGIN;
    outer = Math.max(outer, Math.abs(sl.x) + productW / 2);
    tallest = Math.max(tallest, productH);
  });
  /* `g.outer` is the real extent including the annotation blocks, filled in by
     measureStationExtents once they exist. BLOCK is only the estimate used on
     the first pass, before there is anything to measure. */
  /* `g.needD` is the distance SOLVED from the geometry that actually got
     built, and it is the one to trust. A plain x-extent is not enough: the
     leaves are splayed toward the camera, so an annotation block sits about
     1.8m nearer the lens than the product plane the hold is measured from, and
     the same world x projects a good deal wider there. Solving |x| / ((D -
     zOffset) * perMetre) = edge for D is what accounts for it — measuring x
     alone put the blocks at ndc 1.12 while reporting an outer extent that
     looked comfortable. */
  const byWidth = g.needD !== undefined
    ? g.needD
    : (outer + BLOCK) / (EDGE * PER_METRE);
  const byHeight = (tallest / 2) / (FRAME.edgeY * TAN_HALF);
  return clamp(Math.max(byWidth, byHeight), 4.2, 14.0);
}

function buildCameraTrack(geom) {
  const keys = [];

  /* BUILT IN STRICT TIMELINE ORDER, and that is the whole trick.
   *
   * Every pose is authored relative to its own station — "sixteen metres in
   * front of station two" — which is right in isolation and wrong in sequence,
   * because the previous station's exit may already have carried the camera
   * past that point. The camera then runs back up the gallery to reach it.
   *
   * A running `cursor` fixes it, but only if the beats are emitted in the
   * order the visitor meets them. An earlier version ran the station loop
   * first and pushed the hand-authored specials in afterwards, so by the time
   * the bifold screen asked "how far have we got?" the cursor had already seen
   * station four, seventy metres further on — and the screen's own approach
   * was clamped to beyond the end of the building. The screen simply never
   * appeared in shot.
   *
   * So the beats are collected, sorted by `t`, and only then emitted.
   */
  const beats = [];

  /* --- the mark: a straight push in, the mark doing all the turning ------ */
  beats.push({ t: 0.000, emit: (at) => {
    at(0.000, [0, -0.95, 9.60], [0, 0.30, 0.0], 34, 0.000);
    at(0.030, [0, -0.72, 8.55], [0, 0.32, 0.0], 35, 0.002);
    at(0.060, [0, -0.48, 7.20], [0, 0.32, -0.4], 36, 0.004);
    at(0.082, [0, -0.80, 4.40], [0, -0.3, -4.0], 38, 0.006);
  } });

  /* --- the four stations -------------------------------------------------
     Each contributes the same four poses, and it is a grammar rather than a
     list of coordinates because hand-authoring this many keyframes produces a
     wall of numbers nobody will ever re-time:

       IN     as far back as the room allows, the whole station reading small
       HOLD   both products and both blocks of specification inside one frame
       PUSH   nearer, on the same line, so the beat has somewhere to go
       OUT    through the gap, already looking at the next station           */
  for (const v of V_STATIONS) {
    beats.push({ t: v.in, emit: (at, approach) => {
      const z = v.z;
      /* Look height follows the opening: a window on a cill is looked at from
         slightly below its centre, a door standing on the floor from level. */
      const ly = FLOOR_Y + v.sill + 1.175 - 0.32;
      const slot = slotAt(v, -1, geom); // both leaves are mirrored, so either
      const D = holdDistance(v, geom);  // derived from THIS station's spread
      const holdZ = slot.z + D;         // both products AND both spec blocks
      const pushZ = slot.z + D * 0.61;  // closer; the specs fall outside frame

      at(v.in, [0, -1.00, approach(z, 16.0)], [0, ly + 0.10, z + 2.0], 44, 0);
      at(v.hold, [0, -0.98, holdZ], [0, ly + 0.02, slot.z], 38, 0);
      at(v.push, [0, -1.00, pushZ], [0, ly, slot.z - 0.6], 39, 0);

      const next = V_STATIONS[V_STATIONS.indexOf(v) + 1];
      const aheadZ = next ? next.z + 2.0 : z - 12.0;
      at(v.out, [0, -1.04, z - 2.6], [0, ly + 0.16, aheadZ], 41, 0);
    } });
  }

  /* --- the screen: approach it shut, watch it fold, travel through ------- */
  if (SCREEN) beats.push({ t: SCREEN.in, emit: (at, approach) => {
    const z = SCREEN.z;
    /* 8.0, not 4.2. Every station hold is solved to stand a 2.35m product at
       about 86% of frame height, which works out near eight metres. The bifold
       beat was authored at 4.2 — half that — so the doors measured 1.62 of NDC
       height at the open beat and were cropped off the bottom of frame. The
       one product meant to be the transition was the one you could not see. */
    at(SCREEN.in, [0, -1.00, approach(z, 11.0)], [0, -1.02, z], 40, 0);
    at(SCREEN.open, [0, -1.00, z + 8.0], [0, -1.02, z], 38, 0);
    at(SCREEN.through, [0, -1.02, z - 2.4], [0, -1.02, z - 10], 40, 0);
  } });

  /* --- into the chamber, and the terminal square on ---------------------
     The last pose is INSIDE the chamber: the arrival has to happen on the far
     side of the doorway, in the dark room, which is also the only place the
     interface is comfortable to read. */
  beats.push({ t: 0.966, emit: (at) => {
    const z = STATION.pricing;
    /* Backed off from 5.9 to 6.6. Levelling the camera and settling on a
       single 38-degree lens made the terminal fill more of the frame, and its
       top 28px ended up behind the site header — which is a fixed DOM bar and
       not part of the scene, so nothing in the 3D framing could see the
       problem. The iframe is a real form; none of it can sit under chrome. */
    at(0.966, [0, -0.92, z + 12.6], [0, -0.85, z + 5.0], 39, 0);
    at(0.984, [0, -0.80, z + 9.8], [0, -0.72, z + 2.2], 38, 0);
    at(1.000, [0, -0.62, z + 7.2], [0, -0.56, z], 36, 0);
  } });

  /* Emit in the order the visitor meets them, carrying the cursor forward. */
  let cursor = 1e9;
  const at = (t, p, l, fov = 38, roll = 0) => {
    cursor = Math.min(cursor, p[2]);
    keys.push({ t, p, l, fov, roll });
  };
  const approach = (z, want) => Math.min(z + want, cursor - 1.8);

  beats.sort((a, b) => a.t - b.t);
  for (const beat of beats) beat.emit(at, approach);

  /* LEVEL, AND AT ONE HEIGHT, IMPOSED ON EVERY KEY.
   *
   * "A straight line and no tilt" is four separate things in this file and
   * only one of them is called roll, so they are settled here in one place
   * rather than left to whoever authors the next pose:
   *
   *   - **Pitch.** The largest by far, and it has no name in the source at
   *     all: `camera.lookAt(target)` tilts the camera whenever the target's y
   *     differs from the camera's. Measured across the run it swung 12.4
   *     degrees — +7.4 at the mark, -0.8 at the windows, -5.0 at the doors.
   *     Forcing the look target to the camera's own height is what makes it
   *     exactly zero.
   *   - **Roll.** Authored on the four mark keys, up to 0.34 degrees.
   *   - **Height.** The track rose and fell through 0.42m over its length.
   *   - **Lens.** fov was authored 34 to 44. Not a tilt, but a lens change
   *     during a straight dolly reads as movement the camera is not making —
   *     and every hold distance in this file is solved for 38 degrees, so a
   *     44-degree approach silently mis-frames the thing it is approaching.
   *
   * CAM_Y is a compromise and worth being honest about: a window centres at
   * -0.72 and a door at -1.43, because a door goes to the floor and a window
   * stands on a cill. No single level height centres both. Halfway puts each
   * about 0.36m off centre, which is 0.13 of NDC at the hold distance — the
   * windows sit slightly high in frame and the doors slightly low, by equal
   * amounts. The alternative is reintroducing the pitch that was asked to go. */
  const CAM_Y = -1.05;
  for (const k of keys) {
    k.p[1] = CAM_Y;
    k.l[1] = CAM_Y;
    k.fov = 38;
    k.roll = 0;
  }

  /* A backstop. `cursor` guarantees the AUTHORED positions never go backwards;
     this catches anything the grammar itself produced out of order. If it is
     ever moving a key by more than a metre, the pose above it is wrong and
     this is hiding it. */
  for (let i = 1; i < keys.length; i++) {
    if (keys[i].p[2] > keys[i - 1].p[2] - 1.1) {
      keys[i].p[2] = keys[i - 1].p[2] - 1.1;
    }
  }
  return keys;
}

/* Provisional, built before any model has loaded so nothing downstream is
   undefined. buildStations replaces it with one built from measurements. */
const CAMERA_TRACK = buildCameraTrack(null);

/* ========================================================================== */
/* the experience                                                             */
/* ========================================================================== */

export default class Atrium {
  constructor(root) {
    this.root = root;
    this.canvas = root.querySelector('[data-fx-canvas]');
    this.layer = root.querySelector('[data-fx-css-layer]');
    this.scroller = root.querySelector('[data-fx-scroller]');
    this.stageEl = root.querySelector('[data-fx-stage]');
    this.modelsUrl = root.dataset.fxModels;
    this.manifestFile = root.dataset.fxManifest || '';
    /* Opt-out rather than opt-in, so the experiment keeps the look it was
       signed off with and the showrooms take the fast path.
       NOT `this.shadows` — that name is already the contact-shadow registry,
       assigned `{}` a few lines further down, and `{}` is truthy. The flag was
       silently overwritten and the gate passed every time.

       The planar floor mirror goes with it. Measured on the doors route with
       the architecture merged and the shadow pass already off: the Reflector
       costs 33.7ms and 293 extra draw calls, because it renders the entire
       scene a second time from a mirrored camera. 8ms against 42ms — the
       reflection was costing five sixths of the frame. The floor keeps its
       environment map and clearcoat, which is most of the wet sheen anyway;
       what goes is the true reflection of the products in it. */
    this.useShadowMap = root.dataset.fxShadows !== '0';
    this.useMirror = root.dataset.fxMirror !== '0';
    this.useTransmission = root.dataset.fxTransmission !== '0';
    /* WHICH ROUTE. Before anything else, because every table below —
       the stations, the timeline, the hero list — is laid out from it. */
    /* No attribute means the experiment, which walks the whole catalogue. The
       showrooms name their route explicitly. */
    this.group = ['windows', 'doors'].includes(root.dataset.fxGroup)
      ? root.dataset.fxGroup
      : 'catalogue';
    configureGroup(this.group);
    this.markUrl = root.dataset.fxMark;
    this.quoteUrl = root.dataset.fxQuote;

    /* The spec text and the range counts come from PHP, which counts them from
       the same registry the site menu is built from. Typing "09 WINDOW
       SYSTEMS" into a shader is how a 3D scene ends up quietly lying about the
       range eighteen months after anyone last looked at it. */
    try {
      this.labels = JSON.parse(root.dataset.fxLabels || '{}');
    } catch {
      this.labels = {};
    }

    this.reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    this.caps = detectQuality();
    /* `?fx=high|medium|low` pins the tier. Headless Chrome under-reports cores
       and memory, so without this every QA shot is of the medium path and the
       tier real visitors get is never actually looked at. */
    const forced = new URLSearchParams(location.search).get('fx');
    this.quality = ['high', 'medium', 'low'].includes(forced)
      ? forced
      : (this.reduced ? 'low' : this.caps.tier);

    this.t = 0;            // eased scroll progress 0..1
    this.rawT = 0;         // unsmoothed, for anything that must not lag
    this.time = 0;
    this.pointer = new THREE.Vector2(0, 0);
    this.pointerSmooth = new THREE.Vector2(0, 0);
    this.running = false;
    this.disposed = false;
    this.products = {};
    this.installed = [];
    this.stations = [];
    this._heroIds = new Set(HERO_IDS);
    this.dimensions = [];
    this.callouts = [];
    this.floorTexts = {};
    this.steps = [];
    this.words = {};
    this.shadows = {};
    this._frames = 0;
    this._slowFrames = 0;
    this._lastFpsCheck = 0;

    /* Everything with mass. The camera is the heaviest; a hero product is
       lighter so it still tracks scroll closely enough to feel connected. */
    this.camSpring = new Spring3(11.0);
    this.lookSpring = new Spring3(9.0);
    this.heroSprings = {
      casement: new Spring3(14),
      bifold: new Spring3(11),
      composite: new Spring3(12),
      terminal: new Spring3(13),
    };
    this._targetPos = new THREE.Vector3();
    this._targetLook = new THREE.Vector3();
    this._scratch = new THREE.Vector3();
    this._heroAim = new THREE.Vector3(0, 0, 0);
    this._aimSpring = new Spring3(6.5);
    this.stationGeom = {};
    this._track = CAMERA_TRACK;
    this._arc = buildArcTable(this._track);
    this._markSpring = new Spring3(7.5);
    this._dir = new THREE.Vector3();
    this._right = new THREE.Vector3();
  }

  /* ---------------------------------------------------------------- boot */

  async init() {
    if (this.caps.tier === 'none') {
      this.fail('WebGL is unavailable in this browser.');
      return;
    }

    this.setupRenderer();
    this.setupScene();
    this.setupInput();

    try {
      await this.buildWorld();
    } catch (err) {
      console.error('[atrium] build failed', err);
      this.fail('The 3D scene could not be built.');
      return;
    }

    this.setupScroll();
    this.root.classList.add('is-ready');
    this.running = true;
    this.clock = new THREE.Clock();
    this.loop();

    // Reveal once the first real frame is on screen, so the loader never hands
    // over to a blank canvas.
    requestAnimationFrame(() => requestAnimationFrame(() => {
      this.root.classList.add('is-live');
      this.progress(1, 'Ready');
    }));
  }

  fail(message) {
    this.root.classList.add('is-failed');
    const note = this.root.querySelector('[data-fx-loader-note]');
    if (note) note.textContent = message;
    // The page keeps working: the static layer under the canvas carries the
    // headline, the products and the CTAs as ordinary HTML.
  }

  progress(v, label) {
    const bar = this.root.querySelector('[data-fx-loader-bar]');
    const pct = this.root.querySelector('[data-fx-loader-pct]');
    const note = this.root.querySelector('[data-fx-loader-note]');
    if (bar) bar.style.transform = `scaleX(${clamp(v)})`;
    if (pct) pct.textContent = `${Math.round(clamp(v) * 100)}`;
    if (label && note) note.textContent = label;
  }

  setupRenderer() {
    const renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      antialias: this.quality === 'low',
      alpha: false,
      powerPreference: 'high-performance',
      stencil: false,
    });
    renderer.setClearColor(0xf0efec, 1);
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    // ACES is what makes the highlights roll off instead of clipping to white,
    // and it is most of why the aluminium reads as metal rather than as grey.
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    /* Back down for the light grade. ACES with a pale room needs LESS
       exposure, not more: the environment is already carrying the frame, and
       pushing it further only crushes every white surface together and loses
       the difference between a wall, a reveal and a ceiling panel. The whole
       point of a white-box gallery is that those three tones stay separate. */
    renderer.toneMappingExposure = 0.72;

    if (this.quality === 'high') {
      /* SHADOW MAPS OFF WHERE THE ROUTE ASKS FOR IT, and the showrooms do.
       *
       * Measured on the doors route once the architecture was merged: the
       * shadow pass costs ~24ms of a 52ms frame — 19fps against 67 without it —
       * and puts almost nothing on screen. The light in this room is soft and
       * every product already has a drawn contact shadow under it; comparing
       * the two renders side by side, the difference is a faint gradient on a
       * wall nobody is looking at.
       *
       * Worth noting WHY the earlier audit reached the opposite conclusion.
       * When the scene was issuing 2,223 draw calls it was bound on submitting
       * them, and switching off GPU work changed nothing. Merge the
       * architecture and the bottleneck moves to the GPU, where the shadow
       * pass has been expensive all along. A measurement is only true of the
       * scene you measured. */
      if (this.useShadowMap) {
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
      }
    }

    this.maxDpr = { high: 1.75, medium: 1.35, low: 1 }[this.quality];
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, this.maxDpr));
    renderer.setSize(window.innerWidth, window.innerHeight, false);
    this.renderer = renderer;
  }

  setupScene() {
    this.scene = new THREE.Scene();
    /* Aerial perspective, and in a bright room it works the other way round:
       distance LIFTS toward the haze rather than sinking into the dark. This
       is what gives the gallery its depth without a single dark surface in it,
       and it is why the far end reads as far away rather than as an empty
       white rectangle.

       Density kept LOW. At 0.0125 the haze had a visible effect within ten
       metres and the whole frame went milky — the products lost their edges
       against the wall behind them, which is the one thing a light room is
       supposed to be good at. This only really bites past twenty metres, where
       it is doing depth rather than atmosphere. */
    this.scene.fog = new THREE.FogExp2(0xf0efec, 0.0055);

    this.camera = new THREE.PerspectiveCamera(38, window.innerWidth / window.innerHeight, 0.1, 260);
    this.camera.position.set(0.7, -0.35, 10.6);

    // The camera lives on a rig so mouse parallax composes with the
    // choreographed move rather than fighting it.
    this.camRig = new THREE.Group();
    this.camRig.add(this.camera);
    this.scene.add(this.camRig);

    /* On materials with no textures at all, the environment IS the look. This
       is a purpose-built dark studio rather than three's RoomEnvironment,
       which is a bright white room and puts blown rectangles through every
       pane of glass. See lib/studio.js. */
    this.envMap = buildStudioEnvironment(this.renderer);
    this.scene.environment = this.envMap;
    /* The environment is now doing almost all of the lighting: the room is a
       diffuse daylit gallery and the lamps only shape. Held at 1 rather than
       pushed, because every extra tenth here flattens the products against
       the walls behind them. */
    this.scene.environmentIntensity = 0.78;

    this.lights = buildLightRig(this.scene, this.quality);
    this.backdrop = buildBackdrop(this.scene);
    this.lightWall = buildLightWall(this.scene);
    this.dust = buildDust(this.scene, this.quality);
    this.dust.setPixelRatio(this.renderer.getPixelRatio());

    const rng = makeRng(0xfe5); // deterministic composition

    /* ---- the building ---- */
    this.floor = buildFloor(this.scene, this.quality, this.envMap);
    /* A real planar reflection over the top of it. One extra scene render, so
       high tier only and the first thing the governor drops. */
    this.mirror = this.useMirror
      ? buildFloorMirror(this.scene, this.renderer, this.quality)
      : null;
    this.shell = buildShell(this.scene, this.quality, rng);

    this.sets = new THREE.Group();
    this.scene.add(this.sets);

    /* The stations' own sets are built in buildWorld, once the products have
       been measured: a portal's opening is cut from the window that stands in
       it. A window in a hole plainly too big for it is the tell that neither
       was built for the other. */
    /* A fresh seam-material cache per build: a quality-tier switch tears the
       scene down and rebuilds it, and handing out a disposed material is the
       kind of failure that shows up as an invisible wall. */
    /* Set BEFORE any material exists, because it is read at construction. */
    setGlassRefraction(this.useTransmission);
    resetSeamMaterials();

    this.chamber = buildChamber(this.sets, this.quality);
    /* The chamber begins immediately behind the material bay's wall, so its
       doorway and the chamber mouth are the same opening. */
    this.chamber.group.position.set(0, 0, STATION.pricing + 10);

    /* THE MATERIAL BAY IS NOT PLACED, AND THAT IS THE SECOND DECISION.
     *
     * It went in at -60.5 to fill the stretch the contact sheet called flat at
     * t=0.800 — mean 0.778, spread 0.28. That diagnosis was wrong: the flatness
     * was `buildShell`'s far vista standing across the route (see architecture.js),
     * and moving it fixed the frame on its own.
     *
     * Kept anyway as scenery, it then broke something. Its side bays stand at
     * x +/-2.9 to 5.1 and it is seven metres deep, and station four's hold puts
     * the camera at z -68.9 — INSIDE its footprint, with that station's eight
     * specification blocks at -76 directly behind it. All seven callouts were
     * present, visible, opaque, at valid depth and correctly framed at ndc
     * +/-0.7 to 0.96, and not one of them was drawn.
     *
     * There is nowhere to move it to. The colonnade runs fins in triples every
     * ~1.9m for the whole length of the building, so a seven-metre bay
     * intersects them wherever it goes.
     *
     * So it stays out. It was added for a symptom that had a different cause,
     * the cause is fixed, and scenery that hides a station is worse than no
     * scenery. `buildMaterialBay` remains in architecture.js for whoever wants
     * to design a place for it properly.
     */

    /* A DOORWAY ON THE CHAMBER, so the dark is something you walk into.
     *
     * `buildPortal` was imported and never called — the same as the material
     * bay, and `this.portal?.dispose()` in the teardown has been reaching for
     * something that was never assigned. The chamber's front face is at
     * z = -77.1 and had no mouth in it, so the visitor crossed an invisible
     * line and the gallery simply went black.
     *
     * A threshold you can see coming turns that from a light switch into an
     * arrival. It is also the honest fix for the POP the sweep flags here: the
     * luminance still falls off a cliff, because it should, but now there is a
     * doorway in frame explaining why.
     *
     * buildScreen rather than buildPortal, which is the component that was
     * imported for this. buildPortal builds up from y = 0 and is asymmetric —
     * it measures x -3.8 to +6.4, centred 1.3m off the route — because it was
     * shaped around pass one's off-axis camera. Dropped in here it floated
     * 2.6m above the floor and hung to one side of a doorway the camera now
     * enters dead straight. buildScreen is symmetric, already carries reveals,
     * shadow gaps and a slot light in the head, and is proven at the bifold.
     */
    this.portal = buildScreen(this.sets, this.quality, {
      width: 3.4, height: 3.1, depth: 0.9,
    });
    /* Derived, not pinned. The chamber sits at STATION.pricing + 10 and its
       front face a metre in front of that; hard-coding -77.0 meant the mouth
       stayed put the moment the stations moved. */
    this.portal.group.position.set(0, FLOOR_Y, STATION.pricing + 11);

    this.glassHall = buildGlassHall(this.sets, this.envMap, this.quality, rng);
    this.glassHall.group.position.set(0, 0, STATION.mark);

    /* THE ORBIT IS GONE.
       It was a leftover from the first concept, where the world revolved
       around a fixed camera. Once the camera started travelling the length of
       a building, a ring of products rotating about the origin stopped meaning
       anything, and it showed: products drifted half in and half out of frame,
       cropped at odd angles, at no particular height, belonging to nothing.
       They are installed in the colonnade now. See buildColonnade(). */
    this.colonnade = buildColonnade(this.sets, this.quality, rng, {
      span: 8.6, from: 4, to: STATION.pricing + 8, count: 24,
    });

    this.postFx = buildComposer(this.renderer, this.scene, this.camera, this.quality);
  }

  /* --------------------------------------------------------------- world */

  async buildWorld() {
    this.progress(0.05, 'Tracing the mark');

    // 1. The mark. Nothing else can start until this is on screen, because it
    //    is the first thing the visitor sees.
    this.mark = await buildMark({
      url: this.markUrl,
      envMap: this.envMap,
      quality: this.quality,
      targetHeight: 3.0,
    });
    this.markRig = new THREE.Group();
    this.markRig.add(this.mark.group);
    this.scene.add(this.markRig);
    this.progress(0.18, 'Building the room');

    // 2. Spatial type.
    await (document.fonts ? document.fonts.ready : Promise.resolve());
    this.buildWorldType();

    this.progress(0.26, 'Loading real product geometry');

    // 3. Products, by priority. Priority 1 is everything a phase cannot open
    //    without; the rest streams in behind it.
    this.loader = new ProductLoader({
      manifestFile: this.manifestFile || 'manifest.json',
      transmissive: this.useTransmission,
      baseUrl: this.modelsUrl,
      envMap: this.envMap,
      quality: this.quality,
      onProgress: (n, total) => this.progress(0.26 + (n / Math.max(1, total)) * 0.6, 'Loading real product geometry'),
    });
    const manifest = await this.loader.manifest();
    this.manifest = manifest;
    this.byId = Object.fromEntries(manifest.products.map((p) => [p.id, p]));

    /* THE HERO SET IS NOW SIX PRODUCTS, NOT THREE, so it is defined by the
       station table rather than by the manifest's `priority` field — priority
       described the old four-beat sequence and no longer means anything here.
       Everything a station needs is loaded up front; everything else streams
       in behind the reveal to fill the colonnade. */
    const heroIds = new Set(HERO_IDS);

    const budget = { high: 3, medium: 2, low: 1 }[this.quality];
    const critical = manifest.products.filter((p) => heroIds.has(p.id));
    const rest = manifest.products.filter((p) => !heroIds.has(p.id));
    const secondary = budget >= 2 ? rest.slice(0, 4) : [];
    const tertiary = budget >= 3 ? rest.slice(4) : [];

    /* THE HEROES ARE FINISHED IN ANTHRACITE, AND THAT IS AN EXPOSURE DECISION
       AS MUCH AS A TASTE ONE.
       The exports come out in whatever the configurator was showing, which for
       the casement is white uPVC, and a white frame under a key blows to
       paper. Anthracite Grey is a real Fenster finish, it is the one most of
       this work actually gets specified in, and a mid-tone frame against a
       dark room with a soft edge is the shot the whole scene is trying to be.
       Colour is a runtime change here, per `3d.md`, so this costs nothing and
       invents nothing.

       AND IN A LIGHT ROOM THEY CAN FINALLY BE THE REAL COLOUR.
       Both earlier passes had to fake this. Against a black room a true
       anthracite frame disappeared, so it was lifted to a mid grey, which is
       not a colour Fenster sells and never looked like powder coat. A pale
       gallery removes the problem rather than compensating for it: RAL 7016
       against a white wall separates on its own, and these are now the actual
       finish. */
    /* EVERY HERO GETS A DARK FINISH, and the ones that did not were the
       problem. `flush` and `upvc-slider` kept whatever the configurator was
       showing when they were exported — white uPVC — and a white frame in a
       white opening in a pale wall has nothing to separate against. These are
       all real Fenster finishes, varied across the pairs so a station never
       shows the same colour twice. */
    const HERO_FINISH = {
      casement: 0x3b4247,        // anthracite
      sash: 0x5c646a,            // a lighter grey, so the pair differs
      'alu-window': 0x2c3135,    // aluminium, the darkest
      flush: 0x4a5259,
      bifold: 0x353b40,
      composite: 0x40474c,
      'heritage-door': 0x2f3437,
      'alu-slider': 0x383e42,
      'upvc-slider': 0x565e64,
    };

    /* AND THE REST OF THE RANGE NEEDS ONE TOO.
       Only the three heroes were being finished, and everything else kept
       whatever the configurator happened to be showing when it was exported,
       which is white uPVC. Against a black room that was merely bright;
       against a white gallery wall a white frame is invisible, and the one
       product that caught a key measured as a blown rectangle floating in the
       middle of the shot. These are three real Fenster finishes, spread across
       the range so the room does not read as one product repeated. */
    const RANGE_FINISH = [0x3b4247, 0x2c3135, 0x6d757a];
    this._rangeFinish = (id) => RANGE_FINISH[
      Math.abs([...id].reduce((h, c) => h * 31 + c.charCodeAt(0), 7)) % RANGE_FINISH.length
    ];

    const loaded = await this.loader.loadSet(critical, (e) => ({
      frameColour: HERO_FINISH[e.id] ?? null,
    }));
    loaded.forEach((p) => { this.products[p.entry.id] = p; });

    this.buildStations();
    this.progress(0.9, 'Lighting the room');

    // 4. The terminal.
    this.terminal = buildTerminal({
      scene: this.scene,
      layer: this.layer,
      iframeUrl: this.quoteUrl,
      quality: this.quality,
    });
    this.terminal.group.position.set(0, -0.55, STATION.pricing);
    this.terminal.set(0, 0);

    // 5. The information.
    this.buildInformation();
    /* Only now is the station's real width known — the annotation blocks are
       wider than the products they annotate. See measureStationExtents. */
    this.measureStationExtents();

    // 6. Stream the rest without blocking the reveal.
    this.streamRest(secondary, tertiary);
  }

  /**
   * HOW FAR OUT THE ANNOTATIONS ACTUALLY REACH, measured rather than assumed.
   *
   * `holdDistance` has to know how wide a station is before it can work out
   * where to stand, and the widest thing at a station is not the product — it
   * is the specification block hung off it. That block's world width falls out
   * of the wrap width, the cap height and the length of the words in it, none
   * of which the camera code can reasonably predict. A guessed constant
   * (BLOCK = 0.74) put the blocks at ndc 1.15: off frame, on both sides.
   *
   * So the callouts are built first, measured, and the track re-aimed at the
   * result. It is the same lesson as the openings: measure, then build to the
   * measurement.
   */
  measureStationExtents() {
    this.scene.updateMatrixWorld(true);
    const box = new THREE.Box3();
    for (const st of this.stations) {
      const g = this.stationGeom[st.def.key];
      if (!g) continue;
      /* The plane the hold distance is measured from — the same one
         buildCameraTrack uses. Everything is expressed relative to it. */
      const zRef = st.def.z + g.slots[0].z;
      let outer = 0, needD = 0;
      for (const slot of st.slots) {
        const consider = (obj) => {
          obj.traverse((n) => {
            if (!n.isMesh || !n.geometry) return;
            n.geometry.computeBoundingBox();
            if (!n.geometry.boundingBox) return;
            box.copy(n.geometry.boundingBox).applyMatrix4(n.matrixWorld);
            if (!isFinite(box.min.x) || !isFinite(box.max.x)) return;
            const x = Math.max(Math.abs(box.min.x), Math.abs(box.max.x));
            // Positive means nearer the camera than the product plane.
            const zOff = Math.max(box.min.z, box.max.z) - zRef;
            outer = Math.max(outer, x);
            needD = Math.max(needD, x / (FRAME.edgeX * FRAME.perMetre) + zOff);
          });
        };
        consider(slot.product.pivot);
        slot.callouts.forEach((c) => consider(c.group));
      }
      if (outer > 0) { g.outer = outer; g.needD = needD; }
    }
    this.retrack();
  }

  /**
   * Monumental type, standing in the room.
   *
   * The brief's rule: gigantic typography is allowed, but it has to exist
   * inside the world — a word twenty metres behind the product, partly hidden
   * by it, that the camera eventually travels past. A giant heading pasted on
   * the left of the viewport is the thing being replaced.
   */
  buildWorldType() {
    const mk = (key, text, opts, pos) => {
      const w = buildWord(text, opts);
      w.setOpacity(0);
      w.mesh.position.fromArray(pos);
      this.scene.add(w.mesh);
      this.words[key] = w;
      return w;
    };

    /* Set deep behind each station, so the product physically occludes parts
       of the letters and the camera eventually passes them. */
    /* A tone slightly darker than the wall behind them, so they read as
       painted onto the architecture rather than as glowing signage. The
       products passing in front are darker still, so the occlusion still
       reads, which is the entire reason these are geometry and not a caption. */
    /* One word, behind the last station, whichever route this is. The old
       version set two — WINDOWS and DOORS — because one gallery carried the
       whole catalogue. A window route with the word DOORS eight metres behind
       it would be quite a claim. */
    const lastZ = V_STATIONS.length ? V_STATIONS[V_STATIONS.length - 1].z : -30;
    mk('windows', GROUP_WORD, { height: 4.6, colour: 0xc3cccd, weight: 800, letterSpacing: 0.02 },
      [0, 1.2, lastZ - 8]);
    // The chamber is the one dark volume, so this one goes the other way.
    mk('pricing', 'WINDOWCAD', { height: 1.25, colour: 0x63c9a4, weight: 700, letterSpacing: 0.14 },
      [0, 1.9, STATION.pricing - 2.4]);
  }

  async streamRest(secondary, tertiary) {
    try {
      if (secondary.length) {
        const s = await this.loader.loadSet(secondary, (e) => ({
          frameColour: this._rangeFinish(e.id),
        }));
        if (this.disposed) return;
        s.forEach((p) => { this.products[p.entry.id] = p; });
        this.placeSecondary();
        this.poseRange();
      }
      if (tertiary.length) {
        const t = await this.loader.loadSet(tertiary, (e) => ({
          frameColour: this._rangeFinish(e.id),
        }));
        if (this.disposed) return;
        t.forEach((p) => { this.products[p.entry.id] = p; });
        this.placeTertiary();
        this.poseRange();
      }
    } catch (err) {
      // A product that fails to stream costs one object in the orbit. The
      // experience is designed to survive it rather than stop.
      console.warn('[atrium] a secondary model failed to load', err);
    }
  }

  /**
   * The three hero products go on the STAGE, not the orbit.
   *
   * This was the single biggest structural mistake in the first build and it
   * is worth writing down. Heroes were placed on the orbit and then pulled
   * toward the camera by shortening their radius and pushing their local Z.
   * That cannot work: the holder is rotated to the product's ORIGINAL station
   * angle, so its local +Z points radially outward from where it started, and
   * once the orbit has turned that direction has nothing to do with where the
   * camera is. The window meant to fly through the lens went off the right of
   * frame instead, at ndc.x = 5.0.
   *
   * So the heroes are blocked in world space on a group that does not rotate,
   * exactly as a director blocks a subject separately from the set.
   */
  /**
   * Build every hero station: its setting, its product, its annotations.
   *
   * One loop over `HERO_STATIONS`. A window gets a portal cut to its own
   * measured size; a door gets a plinth and a backdrop. The product is mounted
   * on an unscaled holder — never on `product.pivot`, which carries the
   * millimetre-to-metre scale and would shrink any annotation hung off it to
   * a speck (README trap 3).
   */
  /**
   * Rebuild the camera track from what has actually been measured.
   *
   * Separate from buildStations because the bifold is installed afterwards and
   * moves the screen beat, and because a quality-tier switch rebuilds the
   * world without rebuilding the class.
   */
  retrack() {
    this._track = buildCameraTrack(this.stationGeom);
    this._arc = buildArcTable(this._track);
  }

  buildStations() {
    this.heroStage = new THREE.Group();
    this.heroStage.name = 'heroStage';
    this.scene.add(this.heroStage);

    for (const def of V_STATIONS) {
      const left = this.products[def.left];
      const right = this.products[def.right];
      if (!left && !right) continue;

      /* MEASURE, THEN BUILD THE HOLE TO WHAT YOU MEASURED.
       *
       * This used to read `sample.height * 0.82 + 0.16`, which looks like it
       * derives an opening from the product. It does not. `product.height` is
       * the NORMALISATION TARGET set in products.js — the literal 2.35 that
       * every model is scaled to — so the expression is a constant and every
       * opening in the building came out 2.087 x 2.49 regardless of what stood
       * in it. Only one product of the pair was even consulted (`left ||
       * right`), which is the tell: an opening that fits both members of a
       * pair cannot depend on only one of them.
       *
       * The bifold branch below already did this correctly, with a Box3 off
       * the pivot. The pattern was in the file; it just was not applied here. */
      const openingFor = (product) => {
        const box = new THREE.Box3().setFromObject(product.pivot);
        return {
          width: (box.max.x - box.min.x) + REVEAL_MARGIN * 2,
          height: (box.max.y - box.min.y) + REVEAL_MARGIN,
        };
      };
      const openings = [
        left ? openingFor(left) : openingFor(right),
        right ? openingFor(right) : openingFor(left),
      ];
      /* One centre for both leaves. The openings differ in width, so if the
         inner pier were shared the two products would sit at different
         distances from the gap and the frame would be lopsided; holding the
         centre and varying the pier keeps the pair symmetric. Driven by the
         WIDER of the two so the narrow pier never collapses. */
      const centre = Math.max(openings[0].width, openings[1].width) / 2 + INNER_PIER;

      const set = buildVWall(this.sets, this.quality, {
        openings,
        centre,
        sill: def.sill,
        splay: def.splay,
        gap: def.gap,
      });
      set.group.position.set(0, FLOOR_Y, def.z);
      /* Kept so the camera track, which is built after this, can ask where the
         products actually ended up instead of predicting it from a constant. */
      this.stationGeom[def.key] = {
        centre, openings, slots: set.slots.map((sl) => ({ x: sl.x, z: sl.z, footY: sl.footY })),
      };

      const station = { def, set, slots: [], callouts: [] };

      [['left', left, 0], ['right', right, 1]].forEach(([which, product, k]) => {
        if (!product) return;
        const slot = set.slots[k];

        /* INSTALLED, AND IT STAYS INSTALLED.
         *
         * The products used to rise three metres into place as the camera
         * arrived and sink away as it left. It read exactly as what it was —
         * a model sliding up into a hole — and it is also nonsense: a window
         * in a wall is fitted, it does not arrive. They are simply built into
         * the elevation now and the camera comes to them, which removes the
         * slide, removes the pop at either end of every station, and is what
         * a showroom actually looks like. */
        const holder = new THREE.Group();
        holder.name = product.entry.id + 'Holder';
        /* Stood on `slot.footY`, which is the top of the cill lining, not on
           `def.sill`, which is the structural line 90mm underneath it. Every
           product in the building had its bottom 90mm inside a lining bar. */
        holder.position.set(slot.x, FLOOR_Y + slot.footY + product.height * 0.5, def.z + slot.z);
        holder.rotation.y = slot.rotationY;
        holder.add(product.pivot);
        this.heroStage.add(holder);

        if (this.quality === 'high') {
          product.pivot.traverse((n) => {
            if (n.isMesh) { n.castShadow = true; n.receiveShadow = true; }
          });
        }

        const shadow = buildContactShadow(this.scene, { width: 3.2, depth: 1.5, floorY: FLOOR_Y });
        station.slots.push({
          which, product, holder, shadow, callouts: [],
          /* The product's real width, carried through so the annotations can
             be placed outboard of THIS product rather than of an assumed one. */
          productW: openings[k].width - REVEAL_MARGIN * 2,
        });
      });

      this.stations.push(station);
    }

    /* FOLD THE BUILDING.
     *
     * Everything architectural is in place by this point and none of it moves
     * again. Measured before this ran, the doors route issued 1,315 draw calls
     * at 13fps with under a megabyte of geometry loaded — the colonnade alone
     * was 344 meshes, more than all seven products together. Reprocessing the
     * models fixed the models and left the room untouched; this is the same
     * lesson applied to the room.
     *
     * The hero stage is deliberately NOT passed in: those products animate. */
    for (const part of [this.colonnade, this.shell, this.chamber, this.glassHall, this.screen]) {
      if (part && part.group) mergeStatic(part.group);
    }
    for (const st of this.stations) {
      if (st.set && st.set.group) mergeStatic(st.set.group);
    }

    /* NOW the camera track can be built, because only now does anything know
       where the products actually are. Building it at module load — which is
       what `const CAMERA_TRACK = buildCameraTrack()` did — meant every hold
       pose was aimed at a position derived from a constant. */
    this.retrack();

    /* THE BIFOLD IS INSTALLED, LIKE EVERYTHING ELSE.
       It stands in a glazed screen across the route and folds open to let the
       visitor through. Its opening is measured off the doors themselves, so
       the screen is built to the product rather than the product dropped into
       a guess. */
    const bifold = SCREEN ? this.products[SCREEN.id] : null;
    if (bifold && SCREEN) {
      const box = new THREE.Box3().setFromObject(bifold.pivot);
      /* No floor. `Math.max(3.2, ...)` meant the measured width — 2.785 —
         never won, so the screen was built to a hard-coded 3.42 and the doors
         sat in 318mm of clear air per side while every window in the building
         was jammed into a hole too small for it. The comment three lines up
         says the opening is measured off the doors themselves; the floor made
         that untrue. */
      const bw = box.max.x - box.min.x;
      this.screen = buildScreen(this.sets, this.quality, {
        width: bw + REVEAL_MARGIN * 2, height: bifold.height + REVEAL_MARGIN, depth: 0.5,
      });
      this.screen.group.position.set(0, FLOOR_Y, SCREEN.z);

      const h = new THREE.Group();
      h.name = 'bifoldHolder';
      h.position.set(0, FLOOR_Y + bifold.height * 0.5, SCREEN.z);
      h.add(bifold.pivot);
      this.heroStage.add(h);
      if (this.quality === 'high') {
        bifold.pivot.traverse((n) => {
          if (n.isMesh) { n.castShadow = true; n.receiveShadow = true; }
        });
      }
      this.heroBifold = h;
      this.bifoldShadow = buildContactShadow(this.scene, { width: 4.2, depth: 1.6, floorY: FLOOR_Y });
    }
  }

  /**
   * Install a product in one of the colonnade's bays.
   *
   * Standing on the floor of its recess, not centred in mid-air: the pivot sits
   * on the product's own bounding-box centre, so its base is at
   * `FLOOR_Y + height/2`. Anything else and a window floats inside a niche,
   * which is the exact fault the colonnade replaced.
   */
  installInBay(product, bayIndex, opts = {}) {
    if (!product || !this.colonnade) return;
    const bay = this.colonnade.bays[bayIndex % this.colonnade.bays.length];
    if (!bay) return;
    const holder = new THREE.Group();
    holder.position.set(bay.x, FLOOR_Y + product.height * 0.5 * (opts.scale ?? 1), bay.z);
    holder.rotation.y = bay.rotationY + (opts.turn ?? 0);
    holder.scale.setScalar(opts.scale ?? 1);
    holder.add(product.pivot);
    this.sets.add(holder);
    if (this.quality === 'high') {
      product.pivot.traverse((n) => { if (n.isMesh) { n.castShadow = true; n.receiveShadow = true; } });
    }
    this.installed.push({ product, holder, bay });
  }

  /** Install a product in one of the two bays flanking a doors backdrop. */
  installInWallBay(product, index, opts = {}) {
    if (!product || !this.bay?.wallBays) return;
    const b = this.bay.wallBays[index];
    if (!b) return;
    const holder = new THREE.Group();
    // The material bay group sits at its station, so these are local.
    holder.position.set(b.x, FLOOR_Y + product.height * 0.5 * (opts.scale ?? 1), b.z);
    holder.rotation.y = b.rotationY;
    holder.scale.setScalar(opts.scale ?? 1);
    holder.add(product.pivot);
    this.bay.group.add(holder);
    if (this.quality === 'high') {
      product.pivot.traverse((n) => { if (n.isMesh) { n.castShadow = true; n.receiveShadow = true; } });
    }
    this.installed.push({ product, holder, bay: b });
  }

  /* Whatever is not a hero fills the colonnade. Four of the thirteen models
     are heroes at their own stations now and one is the bifold, so this is the
     remaining six: flush sash, secondary glazing, replacement glazing,
     aluminium door, slide and fold, uPVC slider. Spread down the route rather
     than clustered, so the gallery has something in it the whole way. */
  /* Eight of the thirteen models are heroes built into a station wall and one
     is the bifold, so this is the remaining four: secondary glazing,
     replacement glazing, the aluminium door and slide-and-fold. Spread down
     the route rather than clustered, so the colonnade has something in it the
     whole way. A product has ONE parent, so each appears exactly once. */
  placeSecondary() {
    const p = this.products;
    this.installInBay(p.secondary, 5, { scale: 0.9 });
    this.installInBay(p['alu-door'], 16, { scale: 1.0 });
  }

  placeTertiary() {
    const p = this.products;
    this.installInBay(p['slide-fold'], 28, { scale: 0.94 });
    this.installInBay(p.replacement, 37, { scale: 0.9 });
  }

  /* ------------------------------------------------------- the information */

  /**
   * Everything the page used to say in a paragraph, built as geometry.
   *
   * Callouts attach to the product's own pivot, so they travel with it, turn
   * with it and are occluded by it. Floor type lies in the room at the station
   * it belongs to. The steps stand around the terminal.
   */
  buildInformation() {
    const L = this.labels || {};
    const lite = this.quality === 'low';

    /* EVERYTHING SPATIAL HANGS OFF THE HOLDER, NEVER OFF THE PIVOT.
     * `product.pivot` carries the millimetre-to-metre scale (0.001135), so a
     * callout offset of 1.6 units — meant as 1.6 metres — lands 1.8 MILLIMETRES
     * from its anchor and every annotation collapses to a speck at full
     * opacity. See README trap 3.
     *
     * And they stand CLEAR OF THE WALL. The product is set in an opening 0.85
     * metres thick; annotations a few centimetres off its face are inside the
     * masonry and depth testing eats them silently.
     *
     * The side is chosen by which leaf of the V the product is in: the left
     * leaf annotates to the left, the right leaf to the right, so the
     * annotations open outward from the gap instead of colliding in it.
     */
    for (const st of this.stations) {
      for (const slot of st.slots) {
        const spec = L[slot.product.entry.id];
        if (!spec) continue;

        const h = slot.product.height;
        /* MEASURED, not `h * 0.82`. That factor was a stand-in for a product
           width nobody had measured, and it is wrong by half a metre on the
           doors — which is why their annotations sat marooned out in the wall
           while the windows' were crushed against the frame edge. */
        const w = slot.productW || h * 0.82;
        const dir = slot.which === 'left' ? -1 : 1;
        const front = 0.95;
        // Just clear of the product's own edge, wherever that happens to be.
        const outX = dir * (w * 0.5 + 0.28);

        const add = (opts) => {
          const c = buildCallout(opts);
          slot.holder.add(c.group);
          c.setProgress(0);
          c.setOpacity(0);
          slot.callouts.push(c);
          this.callouts.push({ c, slot, station: st });
          return c;
        };

        add({
          title: spec.title, spec: spec.spec,
          anchor: [dir * w * 0.46, h * 0.30, 0.5],
          /* Pulled in from 1.5. Measured at the hold, the outermost block
             reached ndc x = 1.00 — exactly the frame edge. Both products and
             both specification blocks have to sit comfortably INSIDE one
             frame, which is the whole point of bringing the walls together. */
          /* Measured by the block's EDGE, not its centre. A title block is
             about 0.7 world units wide, which is 0.07 of ndc at the hold
             distance — so a centre at 0.95 puts the far end of the text
             outside the frame, and the first line of every left-hand callout
             was being cut. */
          offset: [outX, h * 0.34, front],
          /* Cap height, not plate height. Measured on screen, the titles were
             running at an 8px cap and the specification lines at 5px — a 7px
             font-size equivalent, which is below any floor anyone uses for
             secondary UI text. These land the titles near 12px. */
          titleCap: 0.078, align: dir < 0 ? 'right' : 'left',
          /* A narrow column. `plateW` works out as titleCap * canvasWidth /
             capHeight, so the wrap width is a direct lever on how far the
             block reaches toward the frame edge — and it is the only lever
             that does not also shrink the type. */
          maxWidth: 210,
        });

        /* TWO NOTES, NOT THREE. The blocks are now roughly twice the size, and
           three of them will not stack down the side of a product without
           colliding. Two large ones communicate more than three unreadable
           ones, and the third was always the weakest claim of the set. */
        (spec.notes || []).slice(0, lite ? 1 : 2).forEach((n, k) => {
          const y = h * (0.05 - k * 0.26);
          add({
            title: n[0], spec: n[1], meta: n[2] || undefined,
            anchor: [dir * w * 0.42, y + 0.06, 0.5],
            offset: [outX, y, front],
            titleCap: 0.068, align: dir < 0 ? 'right' : 'left',
            maxWidth: 210,
          });
        });

        /* The casement alone gets the plan-drawing marks. Repeating them at
           every product would turn a detail into wallpaper. */
        if (slot.product.entry.id === 'casement' && !lite) {
          this.swingArc = buildSwingArc({ radius: w * 0.72 });
          this.swingArc.group.position.set(-w * 0.42, -h * 0.5 + 0.02, 0.5);
          this.swingArc.group.rotation.y = Math.PI;
          slot.holder.add(this.swingArc.group);

          const dimW = buildDimension({
            from: [-w / 2, -h / 2, front], to: [w / 2, -h / 2, front],
            label: '1200 mm', offset: -0.3,
          });
          const dimH = buildDimension({
            from: [w / 2, -h / 2, front], to: [w / 2, h / 2, front],
            label: '1200 mm', offset: -0.3,
          });
          dimW.setOpacity(0); dimH.setOpacity(0);
          slot.holder.add(dimW.group, dimH.group);
          this.dimensions.push(dimW, dimH);
        }
      }
    }

    /* The bifold's two notes travel with it across the wipe. */
    const bifold = SCREEN ? this.products[SCREEN.id] : null;
    /* The `!lite` gate went. On a low-quality device the bifold used to get
       ZERO annotations while every station still got its title and a note —
       the one product in the building that never said its own name, on the
       machines least able to make out what it was. */
    if (bifold && SCREEN && this.heroBifold && L[SCREEN.id]) {
      const bh = bifold.height;
      /* THE TITLE BLOCK, WHICH WAS NEVER BUILT.
         'BIFOLD' and 'SHEERLINE PRESTIGE ALUMINIUM' have been sitting in the
         PHP registry, JSON-encoded onto the element and parsed into
         `this.labels` this whole time — and then dropped, because this branch
         only ever iterated `notes` while the station branch above builds a
         title callout first. Every other product in the room names itself.
         This is a rendering omission, not a content one. */
      const titleC = buildCallout({
        title: L[SCREEN.id].title, spec: L[SCREEN.id].spec,
        anchor: [-0.62, bh * 0.16, 0.30],
        offset: [-1.34, bh * 0.20, 0.62],
        titleCap: 0.078, align: 'right', maxWidth: 210,
      });
      titleC.setOpacity(0);
      this.heroBifold.add(titleC.group);
      this.callouts.push({ c: titleC, bifold: true });

      (L[SCREEN.id].notes || []).slice(0, lite ? 1 : 2).forEach((n, i2) => {
        /* Pulled in hard from +/-1.8. The screen is met from four metres on a
           38-degree lens, which is 2.64m of half-frame; a block hung 2.7m off
           centre is outside the picture, and that is exactly where these two
           were. They also sat at z 0.08, inside a screen half a metre deep, so
           what did survive was depth-tested into the plaster. Forward of the
           face and inboard of the reveal. */
        /* Both notes to the RIGHT, with the title alone on the left. The
           title used to be absent entirely, so the two notes were free to sit
           one per side; adding it back put a title block and a note block on
           the same side at almost the same height. One column each is the
           clearer arrangement and it matches how a station reads. */
        const c = buildCallout({
          title: n[0], spec: n[1],
          anchor: [0.62, bh * (i2 === 0 ? 0.26 : -0.24), 0.30],
          offset: [1.24, bh * (i2 === 0 ? 0.30 : -0.20), 0.62],
          titleCap: 0.068, align: 'left', maxWidth: 210,
        });
        c.setOpacity(0);
        this.heroBifold.add(c.group);
        this.callouts.push({ c, bifold: true });
      });
    }

    /* The finish name, hung under the door demonstrating the runtime colour
       system. One canvas, redrawn as the finish changes. */
    this.finishLabel = buildFloorText('ANTHRACITE GREY', {
      height: 0.30, colour: 0x2d4148, opacity: 0.95, weight: 600, tracking: 0.30,
    });
    const fin = V_STATIONS.find((v) => v.finish);
    this.finishLabel.mesh.position.set(0, FLOOR_Y + 0.02, fin.z + 3.2);
    this.scene.add(this.finishLabel.mesh);

    /* ---- type lying on the floor ---- */
    const floorText = (key, text, z, opts) => {
      const f = buildFloorText(text, opts);
      f.mesh.position.set(0, FLOOR_Y + 0.015, z);
      this.scene.add(f.mesh);
      this.floorTexts[key] = f;
      return f;
    };

    floorText('brand', 'FENSTER GLAZING   ·   MILTON KEYNES', STATION.mark + 2.6,
      { height: 0.34, colour: 0x54686f, opacity: 0.85, tracking: 0.5 });
    floorText('provenance', 'REAL WINDOWCAD GEOMETRY', V_STATIONS[0].z + 4.6,
      { height: 0.62, colour: 0x2d4148, opacity: 0.55, tracking: 0.5, weight: 300 });

    /* The range count, on the floor, counted from the same registry the menu
       is built from — so it cannot drift from the actual range. One legend per
       route rather than the old pair, for the same reason the word is one. */
    const counts = this.labels.counts || {};
    const n = this.group === 'doors' ? counts.doors : counts.windows;
    if (n) {
      floorText('range',
        String(n).padStart(2, '0') + (this.group === 'doors' ? ' DOOR SYSTEMS' : ' WINDOW SYSTEMS'),
        V_STATIONS[V_STATIONS.length - 1].z - 6.0,
        { height: 0.74, colour: 0x2d4148, opacity: 0.5, tracking: 0.42, weight: 300 });
    }

    /* ---- the pricing steps, standing around the terminal ---- */
    const steps = L.steps || [];
    for (const [i, [num, title, sub]] of steps.entries()) {
      const s = buildStep(num, title, { height: 0.30 });
      /* Staggered down the left and right walls of the chamber, receding, so
         the camera passes them one at a time on the way in. That is a sequence
         the visitor moves through rather than a list they read. */
      const side = i % 2 === 0 ? -1 : 1;
      s.mesh.position.set(side * 2.55, 0.55 - i * 0.42, STATION.pricing + 9.5 - i * 2.3);
      s.mesh.rotation.y = side * 0.42;
      this.scene.add(s.mesh);

      /* These stand inside the dark chamber, so unlike every other piece of
         spatial type on this page they stay light. */
      const cap = buildFloorText(sub, {
        height: 0.16, colour: 0x8fd8c0, opacity: 0.75, tracking: 0.3, weight: 400,
      });
      cap.mesh.rotation.x = 0;
      cap.mesh.rotation.y = side * 0.42;
      cap.mesh.position.set(
        side * 2.55 + (side < 0 ? 0.1 : -0.1),
        0.30 - i * 0.42,
        STATION.pricing + 9.52 - i * 2.3
      );
      this.scene.add(cap.mesh);

      this.steps.push({ s, cap, at: 0.900 + i * 0.016 });
    }
  }

  /* --------------------------------------------------------------- input */

  setupInput() {
    this.onPointer = (e) => {
      const x = (e.clientX / window.innerWidth) * 2 - 1;
      const y = (e.clientY / window.innerHeight) * 2 - 1;
      this.pointer.set(x, y);
    };
    window.addEventListener('pointermove', this.onPointer, { passive: true });

    this.onResize = () => {
      const w = window.innerWidth, h = window.innerHeight;
      this.camera.aspect = w / h;
      this.camera.updateProjectionMatrix();
      /* Portrait needs a wider lens or the composition crops to nothing. The
         track's own fov is multiplied by this rather than replaced, so the
         shot-by-shot lens changes survive on a phone. */
      const aspect = w / h;
      this._fovScale = aspect < 0.85 ? 1.42 : (aspect < 1.1 ? 1.16 : 1);

      /* AND A PULL-BACK, because a wider lens alone does not save portrait.
       *
       * Every station is composed for a 16:9 horizontal field: the pair of
       * products lands at ndc +/-0.54 with the specification blocks just inside
       * the edge. On a 390x844 phone the aspect is 0.46, so the horizontal
       * field is a quarter of what the shot was built for. The 1.42 lens
       * widening was already here and it is not close — measured on a phone
       * viewport the two products sit at ndc +/-1.4, i.e. completely outside
       * the picture, and what you actually see is the empty gap between them.
       *
       * Preserving the horizontal field exactly needs a 2.6x pull-back, at
       * which point each window is five per cent of the frame height and the
       * callouts are unreadable. So this is capped: portrait gets the products
       * at about ndc +/-0.80 instead of +/-0.54 and accepts that they are
       * smaller. Square-ish viewports get the full correction, which for them
       * is only about 1.5x.
       *
       * A phone deserves its own camera track showing ONE product at a time
       * rather than a pair. This makes the existing composition coherent on a
       * narrow screen; it does not pretend to be that track. */
      const A0 = 16 / 9, F0 = 38 * Math.PI / 180;
      const f = F0 * this._fovScale;
      const want = (Math.tan(F0 / 2) * A0) / (Math.tan(f / 2) * aspect);
      this._distScale = Math.min(2.10, Math.max(1, want));
      const pr = Math.min(window.devicePixelRatio, this.maxDpr);
      this.renderer.setPixelRatio(pr);
      this.renderer.setSize(w, h, false);
      this.postFx.setSize(w, h, pr);
      this.dust.setPixelRatio(pr);
    };
    window.addEventListener('resize', this.onResize, { passive: true });
    this.onResize();

    this.onVisibility = () => {
      this.running = document.visibilityState === 'visible';
      if (this.running && this.clock) { this.clock.getDelta(); this.loop(); }
    };
    document.addEventListener('visibilitychange', this.onVisibility);
  }

  setupScroll() {
    // Exposed before the reduced-motion early return, or the QA harness cannot
    // see the instance on the one path most likely to be broken.
    window.__fensterAtrium = this;

    /* QA hooks.
     *
     * `__fensterSeek(t)` drives the TIMELINE directly, and that distinction
     * cost a debugging round in pass one: the document is taller than the
     * scroll runway because of the content below it, so a screenshot harness
     * scrolling to "28% of the document" was landing at t = 0.41 and
     * photographing a beat two phases later than the one it named.
     *
     * It also SNAPS every spring. Without that, a seek lands the choreography
     * correctly and then the camera drifts in over the next half second, so a
     * screenshot taken at the wrong moment is of a pose nothing intended. */
    window.__fensterSeek = (target) => {
      /* The stepper has to be told, or the next frame tweens straight back to
         whatever stop it thought it was on and every screenshot is of the
         wrong beat. `adopt` takes the position and settles the index onto the
         nearest stop without moving anything. */
      this.stepper?.adopt(clamp(target));
      this.rawT = clamp(target);
      this.t = this.rawT;
      this._snap = true;
      this.applyChoreography(this.t, 1 / 60);
      this._snap = false;
    };
    /* Kept for older QA snippets, but scroll position and timeline position
       have completely parted company: the page is one screen tall and the
       timeline is stepped. Treats its argument as a fraction of the sequence
       so the old call sites still land somewhere sensible. */
    window.__fensterScrollTo = (y) => {
      const range = Math.max(1, this.scroller.offsetHeight - window.innerHeight);
      window.__fensterSeek(clamp(y / range));
    };
    /* Park the camera square on one product and stop the choreography, so a
       material or lighting question can be answered by looking at the product
       rather than by inferring it from a wide shot where it is 8% of frame. */
    window.__fensterInspect = (id, dist = 4.2) => {
      const product = this.products[id];
      if (!product) return 'no such product: ' + Object.keys(this.products).join(', ');
      this._inspect = { product, dist };
      product.pivot.position.set(0, 0, 0);
      product.pivot.rotation.set(0, -0.42, 0);
      product.pivot.visible = true;
      if (product.pivot.parent) product.pivot.parent.visible = true;
      product.setOpen(0.35);
      return 'inspecting ' + id;
    };

    if (this.reduced) {
      /* Reduced motion: no smoothing, no scroll-driven camera. The scene is
         posed at a strong static composition and the page becomes an ordinary
         document. Still 3D, still lit, just not moving under the reader.
         Both `t` and `rawT`, or the render loop eases `t` back toward zero and
         the carefully chosen static pose drifts off it within a second. */
      this.t = 0.30;
      this.rawT = 0.30;
      this._snap = true;
      this.applyChoreography(this.t, 1 / 60);
      this._snap = false;
      return;
    }

    /* ONE GESTURE, ONE SECTION.
     *
     * The timeline is no longer scrubbed by scroll position at all. Seven
     * stops — the mark, four stations, the bifold, and WindowCAD open — and a
     * push of the wheel travels to the next one and holds there.
     *
     * What that replaces: a Lenis instance smoothing the scroll, a dwell warp
     * bending scroll into timeline, a second smoothing pass on `t`, and a
     * 3200vh runway. Four mechanisms whose combined job was to make a scrubbed
     * timeline feel paced. A stepped one is paced by construction.
     *
     * `STOPS` is derived from the beat table rather than written out, so a
     * station that moves takes its stop with it. */
    /* Built from the route rather than typed out, so a group with two
       stations and a group with three both get a correct stop list without
       anyone re-counting. Sorted, because the screen sits between two
       stations and its beat has to land in the right place in the sequence. */
    const STOPS = [0]
      .concat(V_STATIONS.map((v) => v.hold))
      .concat(SCREEN ? [SCREEN.open] : [])
      .sort((a, b) => a - b)
      .concat([1]);
    this._stops = STOPS;

    this.stepper = buildStepper({
      stops: STOPS,
      duration: 1700,
      onDepart: (i) => {
        this.root.classList.add('is-travelling');
        /* Stepping back out of the final stop retakes the wheel, otherwise the
           visitor is walking the sequence backwards with the document still
           free to scroll out from under them. */
        if (this._released && i < STOPS.length - 1) {
          this._released = false;
          this._wentAway = false;
          this.stepper.setPassive(false);
          window.fensterLenis?.stop?.();
        }
      },
      onArrive: (i) => {
        this.root.classList.remove('is-travelling');
        /* ARRIVING AT THE LAST STOP RELEASES THE PAGE, and that is a fix
           rather than a shortcut. WindowCAD is a real cross-origin iframe
           covering the middle of the screen, and a wheel over a cross-origin
           iframe never reaches a listener on this document — so if the stepper
           still owned the wheel here, the one gesture the visitor needs to
           leave would do nothing for anyone whose cursor is over the
           configurator, which is where it will be. Handing scrolling back the
           moment the terminal is square on means the wheel scrolls the
           configurator when you are pointing at it and the page when you are
           not, which is what both of those gestures should do anyway. */
        if (i === STOPS.length - 1) this.release();
      },
      onExit: (dir) => { if (dir === 'forward') this.release(); },
    });
    this.stepper.attach(window);

    /* The site-wide Lenis in main.js runs on every page and keeps animating
       scroll against a stage that is holding still. Stopped while the sequence
       owns the input, restarted on release — the same stop/start pattern the
       blinds reveal already uses. Never edited: it is exposed as
       `window.fensterLenis` precisely so a page can do this. */
    window.fensterLenis?.stop?.();

    /* A refresh used to restore a scroll position inside a 28800px runway and
       land on the same beat. There is no runway now, so a restored scrollY
       means nothing and would start the sequence part-faded. */
    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
    window.scrollTo(0, 0);

    this.onDocScroll = () => {
      /* The handoff is now driven by real document scroll rather than by
         scroll past a runway. It runs whether or not the sequence released
         voluntarily, so dragging the scrollbar out of the experience fades the
         stage properly instead of leaving it pinned over the footer. */
      this.setHandoff(clamp(window.scrollY / (window.innerHeight * 0.55)));
      /* `_wentAway` guards a bug that is easy to write and hard to see: the
         release happens at scrollY 0, so a re-entry test of "released and at
         the top" is true on the very next scroll event and instantly undoes
         the release. Re-entry has to mean the visitor actually left and came
         back. */
      if (window.scrollY > 24) this._wentAway = true;
      if (this._released && this._wentAway && window.scrollY <= 1) {
        this._released = false;
        this._wentAway = false;
        this.stepper.setPassive(false);
        this.stepper.resetTo(STOPS.length - 1);
        window.fensterLenis?.stop?.();
      }
    };
    window.addEventListener('scroll', this.onDocScroll, { passive: true });

    /* An escape hatch, because the failure this cannot be allowed to have is a
       page that owns the wheel and has stopped responding. */
    this.onEscape = (e) => { if (e.key === 'Escape') this.release(); };
    window.addEventListener('keydown', this.onEscape);
  }

  /** Hand the wheel back to the document. Idempotent. */
  release() {
    if (this._released) return;
    this._released = true;
    /* Passive, not disabled. The document gets the wheel — so the page scrolls
       on and the WindowCAD iframe is usable — but a push back up while still
       at the top steps into the previous stop instead of doing nothing. */
    this.stepper?.setPassive(true);
    window.fensterLenis?.start?.();
  }

  /** Fade the fixed stage out as the document scrolls up over it. */
  setHandoff(over) {
    if (over === this._handoff) return;
    this._handoff = over;
    this.root.classList.toggle('is-handed-over', over > 0.98);
    this.stageEl.style.opacity = String(1 - over);
    // The rail is a SIBLING of the overlay, not a child, so it needs taking
    // down explicitly or it stays pinned over the footer.
    for (const sel of ['.fx__ui', '.fx__rail']) {
      const el = this.root.querySelector(sel);
      if (!el) continue;
      el.style.opacity = String(1 - over);
      el.style.visibility = over > 0.98 ? 'hidden' : 'visible';
    }
    this.stageEl.style.visibility = over > 0.98 ? 'hidden' : 'visible';
  }

  /* --------------------------------------------------- the choreography */

  /**
   * One function, driven by scroll, that poses the entire world.
   *
   * Everything is a function of `t` plus a damped follower, so any frame is
   * reproducible after the springs settle — which is what makes the thing
   * debuggable, and what lets the QA harness photograph a specific beat rather
   * than whatever happened to be on screen. `_snap` makes the springs land
   * immediately, for seeking.
   */
  applyChoreography(t, dt) {
    const time = this.time;
    const snap = this._snap;

    /* ---- phase weights ------------------------------------------------ */
    /* Four phases still, but each now spans several stations. These drive the
       progress rail and the lighting moods; the stations drive themselves. */
    const pFenster = 1 - span(t, 0.065, 0.11);
    const pWindows = span(t, 0.085, 0.14) * (1 - span(t, 0.555, 0.62));
    const pDoors = span(t, 0.615, 0.66) * (1 - span(t, 0.955, 0.975));
    const pPricing = span(t, 0.900, 0.958);

    /* ---- camera ------------------------------------------------------- */
    const extra = sampleTrack(this._track, t, this._targetPos, this._targetLook);

    // Mass. The camera lags the track very slightly and settles into each
    // pose, which is what stops a fast flick reading as a cut.
    const camPos = snap ? this.camSpring.snap(this._targetPos) : this.camSpring.step(this._targetPos, dt);
    const lookAt = snap ? this.lookSpring.snap(this._targetLook) : this.lookSpring.step(this._targetLook, dt);

    this.camera.position.copy(camPos);
    /* Backed off along the view axis on narrow viewports. Applied to the
       camera rather than to `camPos`, which is the spring's own state vector
       and must not be written to. */
    if (this._distScale > 1.001) {
      this.camera.position.sub(lookAt).multiplyScalar(this._distScale).add(lookAt);
    }
    this.camera.lookAt(lookAt);
    // No roll. See the levelling block in buildCameraTrack.

    const fov = extra.fov * (this._fovScale || 1);
    if (Math.abs(this.camera.fov - fov) > 0.01) {
      this.camera.fov = fov;
      this.camera.updateProjectionMatrix();
    }


    /* ---- the mark: hero, then travelling companion ---------------------
     *
     * For the first tenth of the timeline it is the subject — centred, turning
     * toward the lens, the whole frame. After that it does not leave. It moves
     * out to a slot held in CAMERA SPACE, high and to the left, and travels
     * with the visitor for the rest of the journey.
     *
     * And it spins like a wheel. The rotation is proportional to how far the
     * camera has actually travelled (`arcAt`), so it turns while moving
     * between stations and comes to rest by itself on arrival — no timer
     * decides that, the geometry of the route does. At each station it eases
     * onto the nearest whole turn so it presents square-on while the product
     * is being looked at, then picks the spin back up as the camera leaves.
     */
    if (this.mark) {
      const m = this.markRig;
      /* Centred. Pass one held it off to the right so a headline could have
         the left third; there is no headline now, so the mark gets the frame
         it deserves. It rises and turns away as the camera commits to the
         room, and comes back over the terminal to close the sequence. */
      const reveal = span(t, 0.0, 0.095);   // the turn toward the lens
      const handOff = span(t, 0.10, 0.20);  // hero -> companion
      /* Size leads position through the hand-off, and it has to.
         On a single curve the mark is still two thirds of hero size when it is
         already halfway to the corner, and mid-transition its top measured at
         ndc 0.97 — sliced by the page header. Shrinking first means it arrives
         small rather than shrinking once it gets there. */
      const shrink = span(t, 0.095, 0.16);

      /* WHERE IT SITS.
         Below `handOff` it is a fixed object at the mark station. Above it,
         it is carried in camera space: `dir` ahead, `right` across, `up`
         above, so it is always in frame and always clear of the product,
         which is centre or centre-right in nearly every shot. */
      const camPos = this.camera.position;
      this._dir.subVectors(this._targetLook, camPos).normalize();
      this._right.set(-this._dir.z, 0, this._dir.x).normalize();

      /* AIMED AT A SCREEN POSITION, NOT AT A WORLD OFFSET.
         A fixed offset in metres lands somewhere different in every shot,
         because the camera's pitch, yaw and focal length all change through
         the sequence: measured on a plain `camPos.y + 1.95`, the mark sat at
         ndc y between 1.05 and 2.43 — off the top of frame for most of the
         journey, and off the side entirely during the wide pull-back. Solving
         for the frame instead puts it exactly where it is wanted every time.
         Upper left, because the product is centre or centre-right in nearly
         every shot in the sequence. */
      /* Smaller and lower than the first attempt. At ndc y 0.50 and scale
         0.46 the mark's own height took it past the top edge in most shots,
         and it was big enough to compete with the product rather than
         accompany it. A companion should be noticed, not answered. */
      /* TUCKED INTO THE CORNER, and small.
         At ndc (-0.64, 0.40) and scale 0.38 it landed square on top of the
         composite door's title callout. Both are information and neither can
         win that fight, so the mark goes to the corner the annotations never
         reach and gets small enough to read as an emblem accompanying the
         shot rather than an object competing inside it. */
      /* THE DISTANCE HAS TO ADAPT, OR THE MARK ENDS UP INSIDE THE SCENERY.
         Held at a fixed 7.4 metres ahead, the companion was being planted
         behind whatever the camera was looking at: at the windows station that
         put it 11.8 metres out, which is a metre past the far face of the
         portal wall and squarely inside its left pier. It simply disappeared,
         with no error and nothing in the probe to suggest why — the same
         depth-burial that ate the callouts earlier in this project.

         Riding at 45% of the distance to whatever is being looked at keeps it
         reliably in front of the subject in every shot. The world scale is
         divided by the same factor so its APPARENT size on screen does not
         change as the room gets shallower or deeper. */
      const subjectDist = this._targetLook.distanceTo(camPos);
      const MARK_DIST = clamp(subjectDist * 0.45, 2.1, 7.4);
      const distScale = MARK_DIST / 7.4;

      /* BOTTOM LEFT, not top left.
         The composition is symmetrical now — two products, two blocks of
         specification, one down each side — so the top corners belong to the
         callouts and the top edge belongs to the page header. Measured at ndc
         y 0.56 the mark's own top reached 0.89, which is behind the header;
         at 0.44 it sat on the title callout. The lower corner is the one part
         of this frame nothing else wants. */
      /* BOTTOM CENTRE, in the gap the camera is travelling toward.
         The composition is symmetrical now — two products with a block of
         specification down each side — so both top corners belong to the
         callouts, the top edge belongs to the page header, and the bottom left
         belongs to the two links. Measured, every other position collided with
         something: ndc y 0.56 put the mark's own top at 0.89 behind the header,
         0.44 sat it on the title callout, and the lower left clashed with the
         last specification block. The gap between the two leaves is the one
         part of this frame nothing else wants — and a mark hovering in the
         opening the visitor is heading for is a better idea than one stuck in
         a corner anyway. */
      /* EXCEPT at the screen, where the opening IS the centre of the frame.
         Everywhere else the middle of the shot is the one place nothing else
         wants; at the bifold it is the only thing anyone is looking at, and a
         mark hovering in the doorway is a dark smudge across the product. So
         for that one beat it slides out to the pier and sits lower, and the
         existing opacity step-back does the rest. */
      const aside = SCREEN ? bell(t, SCREEN.open, 0.055) : 0;
      const MARK_NDC_X = lerp(0.0, -0.76, aside);
      /* 0.44, not 0.62. The page's own header is a fixed DOM bar across the
         top of the viewport, so anything above roughly ndc 0.75 is behind it —
         the mark was being sliced by a piece of chrome that is not even part
         of the scene. */
      const MARK_NDC_Y = lerp(-0.60, -0.72, aside);

      /* NO DRIFT. These were functions of TIME, not of the timeline, and
         under continuous scroll they hid inside the camera's own movement.
         Parked at a stop — which is now what the whole piece does — they are
         the only thing on screen still moving, and a logo wandering around a
         motionless frame reads as exactly the wobble the levelling was
         supposed to remove. */
      const driftX = 0;
      const driftY = 0;

      // The camera's own basis, built the same way `lookAt` builds it.
      const up = this._up || (this._up = new THREE.Vector3());
      this._right.crossVectors(this._dir, WORLD_UP).normalize();
      up.crossVectors(this._right, this._dir).normalize();

      const halfH = MARK_DIST * Math.tan((this.camera.fov * Math.PI) / 360);
      const halfW = halfH * this.camera.aspect;
      const offX = (MARK_NDC_X + driftX) * halfW;
      const offY = (MARK_NDC_Y + driftY) * halfH;

      const companion = this._scratchB || (this._scratchB = new THREE.Vector3());
      companion.set(
        camPos.x + this._dir.x * MARK_DIST + this._right.x * offX + up.x * offY,
        camPos.y + this._dir.y * MARK_DIST + this._right.y * offX + up.y * offY,
        camPos.z + this._dir.z * MARK_DIST + this._right.z * offX + up.z * offY
      );

      const heroPos = this._scratchC || (this._scratchC = new THREE.Vector3());
      /* -0.72, not 0.35. The mark was hung a metre and a half above the
         camera's own axis, which was fine while the camera pitched up 7.4
         degrees at the opening to look at it. With the pitch gone the mark is
         simply above the frame — the first thing anyone sees, sliced off at
         the top. Levelling a camera moves everything it was looking at. */
      heroPos.set(0, -0.72, STATION.mark);

      const want = this._scratchD || (this._scratchD = new THREE.Vector3());
      want.lerpVectors(heroPos, companion, handOff);
      /* Damped, and noticeably softer than the camera's own spring. The mark
         should lag the view a little as it is carried along — that lag is most
         of what makes it feel like a thing being taken with you rather than a
         sticker on the glass. */
      m.position.copy(snap ? this._markSpring.snap(want) : this._markSpring.step(want, dt));
      /* THE SPIN.
       *
       * `wheel` is turns of the mark per metre the camera covers. The opening
       * reveal is a separate, hand-authored turn — the camera arcs from x=+3.5
       * to centre while the mark counter-rotates, so the two add and it opens
       * from a raking three-quarter face where the extrusion depth reads, to
       * nearly square-on. Past the hand-off the wheel takes over.
       *
       * `settle` is the "key moment": at each station it eases the wheel angle
       * onto the nearest whole turn, so the mark stops mid-journey and presents
       * square while the product beside it is being looked at. Leaving the
       * station, `settle` falls away and the wheel picks up again exactly where
       * the route left it.
       */
      const WHEEL_TURNS_PER_METRE = 0.055;
      const wheel = arcAt(this._arc, t) * WHEEL_TURNS_PER_METRE * Math.PI * 2;

      /* One settle per station, read straight off the table: the mark stops
         spinning wherever the camera stops. Six stations, plus the terminal. */
      /* One settle per product the camera stops on, read straight off the
         station table: the mark stops spinning wherever the camera stops. */
      let settle = span(t, 0.960, 0.985);
      for (const v of V_STATIONS) {
        settle = Math.max(settle, 1 - clamp(Math.abs(t - v.hold) / 0.06));
      }
      settle = clamp(settle);
      // The nearest whole turn, so it lands facing the same way every time.
      const TAU = Math.PI * 2;
      const snapped = Math.round(wheel / TAU) * TAU;
      const spin = lerp(wheel, snapped, settle);

      // Face back down the camera's own axis, then add the spin on top.
      const facing = Math.atan2(-this._dir.x, -this._dir.z);

      /* The spin stays — it is a function of distance travelled, so it is
         still while the camera is still and turns while it moves, which is the
         point of it. The time-driven sines that used to be added on top do
         not, for the same reason as the drift above. */
      m.rotation.y = lerp(
        lerp(0.68, -0.06, reveal),
        facing + spin,
        handOff
      );
      // A little tilt while it is travelling, gone when it settles.
      m.rotation.x = lerp(-0.12, 0.05, reveal) * (1 - handOff)
        + handOff * (0.16 * (1 - settle));
      /* No roll. This ran to -5.7 degrees, and a rolled mark held against a
         perfectly level frame IS the tilt a viewer sees, whatever the camera
         is doing. */
      m.rotation.z = 0;

      /* Grows very slightly into the reveal, shrinks to companion size, and
         comes forward a touch at each station so the settle reads as arriving
         rather than as merely stopping. */
      const size = lerp(
        lerp(0.94, 1.06, reveal),
        0.235 + settle * 0.06,
        shrink
      );
      // `distScale` keeps the apparent size constant as the ride-along
      // distance changes; without it the mark grows every time the camera
      // moves closer to its subject.
      m.scale.setScalar(size * lerp(1, distScale, shrink));

      /* The leaf lights up as it turns to face, dims while travelling, and
         comes back up as it settles at each station. It is the only piece of
         brand colour in most of these frames and it should mean something. */
      this.mark.setGlow(
        lerp(0.2, 0.5, reveal) * (1 - handOff)
        + handOff * (0.18 + settle * 0.34)
        + 0.04 * Math.sin(time * 0.6)
      );

      /* Steps back, rather than disappearing, for the two beats that want the
         screen: the travel through the doorway and the moment the bifold is
         centre frame. It used to vanish entirely, which was right when the
         bifold was 2.6 units from the lens and covered everything — now that
         it is far enough back to read, the mark can stay and simply get
         quieter. A companion that blinks out is a bug; one that hangs back is
         a companion. */
      const clear = SCREEN
        ? Math.max(bell(t, 0.246, 0.02), bell(t, SCREEN.open, 0.05) * 1.15)
        : bell(t, 0.246, 0.02);
      this.mark.setOpacity(1 - clear * 0.72);
      this.mark.update(time);
    }

    /* ---- the tour: four stations, eight products ------------------------
     *
     * Each station is a splayed pair of walls with a product built into each
     * leaf. The camera arrives central with both in shot, swings to the near
     * one, crosses to the far one, then squares up and goes through the gap.
     *
     * NOTHING MOVES INTO PLACE. The products are fitted into the elevation and
     * stay there for the whole run; only their sashes animate and only their
     * annotations come and go. An earlier version flew each one three metres
     * up into its opening as the camera arrived, which read as a model sliding
     * into a hole and popped at both ends of every station.
     */
    let leadSlot = null;
    let leadPower = 0;

    for (const st of this.stations) {
      const d = st.def;
      const active = t > d.in - 0.06 && t < d.out + 0.06;

      for (const slot of st.slots) {
        const isLeft = slot.which === 'left';
        // Each product owns the half of the beat the camera spends on it.
        /* Both products are looked at TOGETHER now, so they share the beat
           rather than taking half each. Focus peaks at the hold and falls away
           either side of it, identically for the pair. */
        const focus = active
          ? 1 - clamp(Math.abs(t - d.hold) / Math.max(0.06, (d.out - d.in) * 0.62))
          : 0;

        /* The baked WindowCAD clip, scrubbed. It opens as the camera comes to
           this product and closes again as it moves to the other one, so at
           any moment one of the pair is open and the other shut — which is
           also how a showroom displays a pair. */
        /* One of the pair opens and the other stays shut, which is how a
           showroom displays two of the same thing — and it means the visitor
           can see the section and the closed face at the same time. */
        slot.product.setOpen(active && isLeft
          ? span(t, d.in + 0.02, d.hold) * (1 - span(t, d.out - 0.03, d.out + 0.03))
          : 0);

        setSweep(slot.product.sweep, lerp(-2.6, 2.8, span(t, d.in, d.out)), focus * 0.5);

        /* The specification blocks reach past the frame edge on the push, so
           they come off as the camera closes in rather than being cropped. */
        const show = focus * (active ? 1 : 0) * (1 - span(t, d.push - 0.02, d.push + 0.03) * 0.85);
        slot.callouts.forEach((c, k) => {
          const stagger = clamp((show - k * 0.1) / Math.max(0.001, 1 - k * 0.1));
          c.setProgress(stagger);
          c.setOpacity(stagger);
        });

        if (slot.product.entry.id === 'casement') {
          const open = slot.product.action ? slot.product.action.time / (slot.product.clipDuration * 0.5) : 0;
          this.swingArc?.setProgress(open);
          this.swingArc?.setOpacity(show * open * 0.9);
          for (const dim of this.dimensions) {
            dim.setProgress(span(t, d.in + 0.03, d.hold));
            dim.setOpacity(show * 0.85);
          }
        }

        /* THE MATERIAL MOMENT, on the composite door only. Runtime recolour
           synced to the blade travelling down the slab: the finish changes as
           the light crosses it. Slow on purpose — a fast cycle reads as a game
           skin selector rather than a material demonstration. */
        if (d.finish && isLeft) {
          const cycle = span(t, d.hold + 0.01, d.out - 0.03);
          const stops = Math.min(4, FINISHES.length);
          const idx = Math.min(stops - 1, Math.floor(cycle * (stops - 0.001)));
          if (this._finishIdx !== idx) {
            this._finishIdx = idx;
            this._finishTarget = FINISHES[idx];
            this.setFinishLabel(FINISHES[idx]?.name);
          }
          const fh = this._finishTarget?.hex ?? 0x808080;
          const fl = (((fh >> 16) & 255) * 0.2126 + ((fh >> 8) & 255) * 0.7152 + (fh & 255) * 0.0722) / 255;
          this._finishStop = 1 - clamp((fl - 0.3) / 0.62) * 0.62;
          if (this._finishTarget) {
            // dt-aware: a fixed per-frame lerp blends faster at 144Hz than at
            // 60Hz, which is the class of frame-rate dependence that reads as
            // jank.
            recolour(slot.product.frames, this._finishTarget.hex, this._finishTarget.metal,
              this._finishTarget.rough, snap ? 1 : clamp(dt * 4.5));
          }
        }

        slot.shadow.set(slot.holder.position, show * 0.55 + 0.12, 1.35);

        if (focus > leadPower) { leadPower = focus; leadSlot = slot; }
      }
    }
    this._leadSlot = leadSlot;
    this._leadPower = leadPower;

    /* ---- the bifold: a screen that opens to let you through -------------
     *
     * It stands across the route, glazed the full width of the opening, and it
     * concertinas open as the camera arrives. No camera-space blocking, no
     * sweep across the lens: it is installed in a wall like every other
     * product here, and the one thing that has to move before the visitor can
     * carry on. The camera goes straight through the opening it makes.
     */
    const bifold = SCREEN ? this.products[SCREEN.id] : null;
    if (bifold && SCREEN && this.heroBifold) {
      const d = SCREEN;
      const fold = span(t, d.in, d.open);
      bifold.setOpen(fold);

      /* THE ASSEMBLY DOES NOT MOVE SIDEWAYS. It used to slide 0.35m left as
         it folded, under a comment claiming the leaves stack to one side.
         Measured in the assembly's own frame, they do not: the product's x
         extent is -1.393..+1.393 at every point in the beat, identical to
         three decimals. What the baked clip actually changes is DEPTH — the z
         size grows 0.272 -> 1.090 as the leaves concertina toward the camera,
         symmetrically about the centre.
         So the slide was not standing in for a stack, it was a bare
         translation bolted on top of a symmetric fold. It drove the outer
         frame 33mm past the opening edge into the pier, slid the doors off the
         floor track buildScreen lays at x = 0, and dragged the two annotation
         blocks (which are children of this group) out to the frame edge. */

      setSweep(bifold.sweep, lerp(-3.2, 3.4, span(t, d.in, d.through)),
        bell(t, d.open, 0.026) * 0.8);

      /* Off before the lens reaches the screen plane, not as it passes it. A
         callout is a flat card a metre or so in front of the doors; carry it
         to the threshold and the last few frames have it wrapping round the
         camera at ndc 6.8. Measured, not guessed. */
      /* Measured, the two blocks were at full opacity for about 0.016 of the
         timeline against roughly 0.25 for a station — a fifth as long, at the
         fastest-moving beat of the tour. They ramp from the start of the beat
         now and hold until the lens is nearly at the threshold. */
      const show = span(t, d.in, d.read)
        * (1 - span(t, d.through - 0.024, d.through - 0.008));
      let bi = 0;
      for (const entry of this.callouts) {
        if (!entry.bifold) continue;
        const stagger = clamp((show - bi * 0.12) / Math.max(0.001, 1 - bi * 0.12));
        entry.c.setProgress(stagger);
        entry.c.setOpacity(stagger);
        bi++;
      }

      this.bifoldShadow?.set(this.heroBifold.position,
        span(t, d.in - 0.02, d.in + 0.02) * (1 - span(t, d.through, d.through + 0.02)) * 0.55, 1.8);
    }

    /* ---- pricing ------------------------------------------------------- */
    if (this.terminal) {
      /* The terminal starts glowing BEFORE the camera is through the
         doorway, which is both better staging and a measured fix. Held until
         0.930, the stretch from the last product station to the reveal was a
         dark hole: t = 0.94 measured mean 0.077 with spread 0.32, the worst
         frame in the sequence by a wide margin. A distant rectangle of light
         resolving into the terminal as you approach is what the beat was
         always described as. */
      const reveal = span(t, 0.895, 0.962);
      const handover = span(t, 0.978, 0.996);
      if (t > 0.80) this.terminal.arm();

      const g = this.terminal.group;
      /* It starts deep in the chamber as a distant rectangle of light and
         comes forward to meet the camera. The approach is most of the theatre,
         so it is given a long, slow travel rather than a scale-up. */
      this._scratch.set(0, -0.55, lerp(STATION.pricing - 5.5, STATION.pricing, span(t, 0.930, 0.995)));
      const pos = snap
        ? this.heroSprings.terminal.snap(this._scratch)
        : this.heroSprings.terminal.step(this._scratch, dt);
      g.position.copy(pos);
      /* Square on, and still. It used to carry `Math.sin(time * 0.2) * 0.008`
         on both axes — imperceptible while the camera was moving, and a slow
         wobble on a page that now comes to a complete stop in front of it with
         a real form inside. */
      g.rotation.y = lerp(0.16, 0, span(t, 0.950, 0.985));
      /* Once that reaches zero the panel is exactly parallel to the image
         plane, and the DOM copy can stop being a 3D-transformed element and
         become an ordinary rectangle — which is the only form of it the
         browser will hit-test. Until then it is flying in and not interactive. */
      this.terminal.setFlat?.(t >= 0.985);
      g.rotation.x = 0;
      g.scale.setScalar(lerp(0.9, 1, span(t, 0.950, 0.985)));
      this.terminal.set(reveal, handover);
    }

    // The steps arrive one at a time as the camera passes them.
    for (const { s, cap, at } of this.steps) {
      const v = span(t, at, at + 0.02) * (1 - span(t, 0.992, 1.0));
      s.setOpacity(v * 0.95);
      cap.setOpacity(v);
    }

    /* ---- world type ---------------------------------------------------- */
    /* Monumental, and deep. WINDOWS sits fifteen metres behind the portal so
       the camera reads it THROUGH the opening, the window occludes parts of
       the letters, and passing through the aperture takes it behind us. */
    this.words.windows?.setOpacity(span(t, 0.13, 0.22) * (1 - span(t, 0.56, 0.62)) * 0.5);
    this.words.doors?.setOpacity(span(t, 0.64, 0.72) * (1 - span(t, 0.95, 0.975)) * 0.5);
    this.words.pricing?.setOpacity(span(t, 0.945, 0.975) * (1 - span(t, 0.995, 1)) * 0.42);

    this.floorTexts.brand?.setOpacity((1 - span(t, 0.05, 0.11)) * span(t, 0.006, 0.03));
    this.floorTexts.provenance?.setOpacity(span(t, 0.13, 0.18) * (1 - span(t, 0.27, 0.31)));
    this.floorTexts.range?.setOpacity(span(t, 0.494, 0.522) * (1 - span(t, 0.556, 0.586)));
    this.floorTexts.doorRange?.setOpacity(span(t, 0.915, 0.945) * (1 - span(t, 0.962, 0.98)));

    /* ---- the room ------------------------------------------------------ */
    /* Calm is the pricing phase's instruction to everything else: fewer motes,
       less bloom, no aberration, no camera drift. The cinematic sequence earns
       the attention; the tool then has to be comfortable to actually use. */
    const calm = pPricing;

    /* Cut right back. A dark room carries a lot of visible particulate and it
       reads as atmosphere; a clean white gallery cannot, and the same motes
       read as a dirty lens. What is left is a faint sparkle where the key is,
       which is all a bright room ever actually shows. */
    this.dust.update(time, (1 - calm * 0.85) * 0.32);
    /* GONE BY THE TIME THE CAMERA REACHES THEM.
       These are the opening set — sheets of glass standing around the mark —
       and they were being held at 10% for the whole sequence. Two faults from
       that: at t = 0.24 a pane at 38% opacity was sitting across the entire
       frame and hazing the casement into looking like white uPVC when the
       material is measurably 0x0b0e10, and the camera's route passes straight
       through the radius they occupy. They belong to the first fifth of the
       timeline and now end there. */
    /* The opening set clears out before the camera reaches the first station:
       panes at 60% opacity were crossing the frame as vertical bars at t=0.10
       and hazing everything behind them. */
    this.glassHall.update(time, 1 - span(t, 0.028, 0.085));
    this.shell.update(time);
    this.backdrop.update(time, time * 0.03);

    if (this.postFx.bloom) {
      /* Kept low, and pulled lower still through the two beats that produced
         the worst blowouts in pass one — the light behind the opening door,
         and the terminal coming up to full brightness. */
      /* Bloom comes UP for the pricing phase rather than down, which is the
         reverse of the dark grade: the chamber is dark, the terminal is the
         only bright thing in it, and a little glow off a screen in a dark room
         is real. Everywhere else it is barely on at all. */
      this.postFx.bloom.strength = lerp(this.quality === 'high' ? 0.13 : 0.09, 0.19, calm);
    }
    const f = this.postFx.finish.uniforms;
    f.uAberration.value = this.quality === 'low' ? 0 : lerp(0.0007, 0.0, calm);
    f.uGrain.value = lerp(0.008, 0.004, calm);
    // The anamorphic streak is a dark-room device. On a pale grade it does not
    // read as a lens, it reads as a smear across the wall.
    f.uStreak.value = 0;
    f.uVignette.value = lerp(0.16, 0.05, calm);
    f.uLift.value = lerp(0.16, 0.05, calm);
    f.uHighlightRoll.value = 0.9;

    /* The haze thins and the exposure comes UP as the camera enters the
       chamber, because the chamber is the one dark volume in the building and
       the exposure that suits a white gallery would black it out. */
    this.scene.fog.density = lerp(0.0055, 0.002, calm);
    /* The exposure comes DOWN slightly into the chamber, not up.
       Lifting it to 1.15 was an instinct carried over from the dark grade,
       where the pricing phase needed help. Here it flattened the one dark
       volume in the building into the same mid grey as everything else, and
       the terminal lost the contrast its whole arrival depends on. */
    this.renderer.toneMappingExposure = lerp(0.72, 0.66, calm);

    /* ---- what is centre stage ------------------------------------------ */
    /* One subject at a time, and the transition between subjects is a blend
       rather than a switch. Pass one used an else-if chain feeding a fixed
       lerp, so handing over from the door to the terminal moved the key
       twelve metres in one step and the room visibly swung. */
    let aimAt = null;
    let aimPower = 0;
    if (this.terminal && pPricing > 0.2) {
      aimAt = this.terminal.group.position; aimPower = pPricing * 0.8;
    } else if (SCREEN && t > SCREEN.in - 0.03 && t < SCREEN.through) {
      aimAt = this.heroBifold.position;
      aimPower = 1 - clamp(Math.abs(t - SCREEN.open) / 0.05);
    } else if (this._leadSlot) {
      /* Whichever product the camera is closest to takes the key. The tour
         loop already works that out — a chain of `else if` per product would
         need rewriting every time a station moved. */
      aimAt = this._leadSlot.holder.position;
      aimPower = this._leadPower
        * (this._leadSlot.product.entry.id === 'composite' ? (this._finishStop ?? 1) : 1);
    } else if (this.markRig) {
      aimAt = this.markRig.position; aimPower = 0.66 * pFenster;
    }

    if (aimAt) {
      this._heroAim.copy(snap ? this._aimSpring.snap(aimAt) : this._aimSpring.step(aimAt, dt));
    }
    const power = clamp(aimPower) * (1 - calm * 0.4);
    const camDist = this.camera.position.distanceTo(this._heroAim);
    this.lights.aimHero(this._heroAim, power, camDist);

    /* ---- the lighting timeline ----------------------------------------- */
    /* Each hero moment has its own art direction, blended rather than
       switched. See MOODS in lib/lighting.js for what each one is doing. */
    let from = 'mark', to = 'windows', mix = span(t, 0.085, 0.15);
    if (t >= 0.53) { from = 'windows'; to = 'doors'; mix = span(t, 0.540, 0.63); }
    /* Centred on the doorway, not started well in front of it. The camera
       crosses the chamber mouth at z = -77.1 at about t = 0.972; blending from
       0.930 had the room 40% into the pricing mood — effectively black — while
       the camera was still five metres out in a lit gallery. */
    if (t >= 0.95) { from = 'doors'; to = 'pricing'; mix = span(t, 0.952, 0.990); }
    this.lights.setMood(from, to, mix, 1);

    /* The boxes slide along their own axis on a slow cycle, plus a push at the
       finish moment. This is the mechanism behind a highlight travelling
       across a surface: the object does not move, the reflection does. */
    const finishBeat = V_STATIONS.find((v) => v.finish);
    const travel = Math.sin(time * 0.13) * 0.5
      + lerp(-1.9, 1.9, span(t, finishBeat.hold + 0.01, finishBeat.out - 0.03)) * pDoors;
    this.lights.placeBoxes(this._heroAim, this.camera.position, travel, 0.55 + power * 0.75);
    this.dust.setBeam(this.lights.boxL.position);

    /* ---- depth of field ------------------------------------------------ */
    /* Focus follows the subject, never the scroll position. The hero stays
       sharp and the architecture behind it falls off; the aperture opens a
       little for the two beats that are about depth rather than about a
       product, and closes for the terminal so the interface is crisp. */
    if (this.postFx.bokeh) {
      /* Opened right up for the detail shot on the sash, so the wall behind
         it goes soft and the eye has nowhere to go but the hardware. This is
         the one place in the sequence a shallow depth of field is the point
         rather than a garnish. */
      const aperture = lerp(0.00048, 0.00012, calm)
        * (1 + bell(t, 0.545, 0.035) * 0.8)
        * (1 + bell(t, 0.246, 0.03) * 1.5);
      this.postFx.focusOn(camDist, aperture);
    }

    /* ---- contact shadows ------------------------------------------------ */
    /* Weaker for the casement: it is on a cill 0.62m up now, so its shadow
       is a soft patch on the floor below the wall rather than a contact
       patch — the blob's own lift-based softening handles the rest. */
    /* Station shadows are set inside the tour loop, where the pose is known.
       Only the bifold's is left here, because it has no station. */
    if (this.bifoldShadow) {
      /* Set inside the bifold block now, where the fold state is known. */
    }

    /* The floor's light pool follows the subject too, which is what stops the
       floor reading as a flat grid with objects sitting on top of it. */
    this.floor.update(time, this._heroAim, power * 0.9);

    /* The lit backdrop follows the same subject. Without it the glazing
       transmits a black room and every product reads as a hole. */
    this.lightWall.update(time);
    this.lightWall.placeBehind(
      this._heroAim,
      lerp(11.5, 8.4, power),
      power * 1.35 * (1 - calm * 0.6) + pFenster * 0.3,
      pDoors * 0.6
    );

    this.updateChrome(t, { pFenster, pWindows, pDoors, pPricing }, calm);
  }

  /**
   * Send a hero off stage.
   *
   * A holder whose `visible` is false keeps whatever pose it last had, because
   * the choreography skips the whole block. Harmless on screen, but it means
   * the scene's state depends on which direction the visitor arrived from,
   * which showed up the moment a reversibility check compared poses in both
   * directions. Resetting makes `applyChoreography` genuinely a pure function
   * of `t` again, and that property is the whole reason any of this is
   * debuggable.
   */
  park(holder) {
    if (!holder || holder.visible) return;
    holder.position.set(0, 0, 0);
    holder.rotation.set(0, 0, 0);
    holder.scale.setScalar(1);
  }

  /** Park a contact shadow under a hero. */
  setShadow(id, holder, opacity, spread) {
    const s = this.shadows[id];
    if (!s) return;
    if (!holder?.visible) { s.set(this._heroAim, 0, 1); return; }
    s.set(holder.position, opacity, spread);
  }

  /** Rewrite the finish caption under the door. */
  setFinishLabel(name) {
    if (!name || !this.finishLabel) return;
    const wasVisible = this.finishLabel.mesh.visible;
    const pos = this.finishLabel.mesh.position.clone();
    this.finishLabel.dispose();
    this.scene.remove(this.finishLabel.mesh);
    this.finishLabel = buildFloorText(name.toUpperCase(), {
      height: 0.30, colour: 0x2d4148, opacity: 0.95, weight: 600, tracking: 0.30,
    });
    this.finishLabel.mesh.position.copy(pos);
    this.finishLabel.mesh.visible = wasVisible;
    this.scene.add(this.finishLabel.mesh);
  }

  /**
   * The page chrome: the progress rail, the scroll cue, the two links.
   *
   * This is all that is left of the HTML overlay. Pass one drove four panels
   * of copy from here with a winner-takes-most curve to stop two headlines
   * being legible at once; none of that exists any more, because none of the
   * copy does.
   */
  updateChrome(t, weights, calm) {
    if (!this._ui) {
      this._ui = {
        rail: this.root.querySelector('[data-fx-rail-fill]'),
        ticks: [...this.root.querySelectorAll('[data-fx-tick]')],
        cue: this.root.querySelector('[data-fx-cue]'),
        actions: this.root.querySelector('[data-fx-actions]'),
        top: this.root.querySelector('.fx__top'),
      };
    }
    const ui = this._ui;
    const raw = [weights.pFenster, weights.pWindows, weights.pDoors, weights.pPricing];

    if (ui.rail) ui.rail.style.transform = `scaleY(${clamp(t)})`;
    const active = raw.indexOf(Math.max(...raw));
    for (let i = 0; i < ui.ticks.length; i++) {
      ui.ticks[i].classList.toggle('is-active', i === active);
      ui.ticks[i].style.setProperty('--fx-tick-weight', String(clamp(raw[i])));
    }
    if (ui.cue) ui.cue.style.opacity = String(clamp(1 - t * 16));
    /* The links stay out of the way for the whole cinematic sequence and come
       up once the terminal is square on — the one moment the visitor might
       actually want to leave for the full tool. */
    if (ui.actions) {
      const v = 0.32 + calm * 0.68;
      ui.actions.style.opacity = String(v);
      ui.actions.style.pointerEvents = calm > 0.4 ? 'auto' : 'none';
    }
    if (ui.top) ui.top.style.opacity = String(0.75 - calm * 0.5);
    this.root.classList.toggle('is-pricing', weights.pPricing > 0.6);
  }

  /* ---------------------------------------------------------------- loop */

  loop = () => {
    if (!this.running || this.disposed) return;
    requestAnimationFrame(this.loop);

    const dt = Math.min(0.05, this.clock.getDelta());
    this.time += dt;

    /* The stepper's own tween is already eased, so there is nothing left for
       the old timeline smoothing to do — it would only add lag between the
       gesture and the move. The camera and look springs still supply the mass. */
    if (this.stepper) {
      this.rawT = this.stepper.update(dt * 1000);
      this.t = this.rawT;
    } else {
      this.t += (this.rawT - this.t) * Math.min(1, dt * 4.4);
    }

    /* Pointer parallax, heavily damped, and cut right back through the pricing
       phase so the interface does not swim under the cursor while it is being
       used. */
    /* NO POINTER PARALLAX. This rig yawed the camera up to 2.4 degrees,
       pitched it 1.5, and slid it 0.22m sideways and 0.13m vertically off the
       centre line — which is literally the thing "goes in a straight line"
       rules out. It was a good idea when the camera was scrubbed and the
       visitor had nothing else to do with the mouse; parked at a stop it is
       the only thing moving, and it reads as drift. */
    this.camRig.rotation.set(0, 0, 0);
    this.camRig.position.set(0, 0, 0);

    if (this._inspect) {
      this.renderInspect();
      return;
    }

    this.applyChoreography(this.t, dt);
    this._calm = span(this.t, 0.86, 0.95);


    /* No per-frame mixer sweep any more.
       This used to walk every loaded product and call `mixer.update(0)`, which
       was the only thing applying the animation bindings — and it was applying
       a time that `setOpen` had never managed to set (see products.js). Now
       `setOpen` writes `action.time` and ticks the zero-length frame itself,
       so the heroes are applied when the choreography poses them and the range
       is applied once at load by `poseRange()`. The bindings write straight to
       the node transforms, so the pose persists without being re-evaluated.
       That is 198 tracks per bifold, thirteen products, sixty times a second
       of binding evaluation that no longer happens. */

    /* Turn the callout type to face the camera. Only the type — the leaders
       and the nodes stay fixed in the world, which is what keeps them reading
       as marks on the object rather than as a HUD. */
    for (const { c } of this.callouts) c.face(this.camera.getWorldPosition(this._scratch));

    if (this._handoff > 0.98) {
      // Off screen. Skip the whole render rather than draw a frame nobody sees.
      this.watchPerformance(dt);
      return;
    }

    this.postFx.update(this.time, dt);
    this.terminal?.update(this.camera, window.innerWidth, window.innerHeight, this.time);
    this.postFx.composer.render();

    this.watchPerformance(dt);
  };

  /** `__fensterInspect` — park on one product and hold. */
  renderInspect() {
    const { product, dist } = this._inspect;
    // Re-assert every frame: a stray seek would otherwise re-run the
    // choreography and hide the thing being inspected.
    product.pivot.visible = true;
    product.pivot.position.set(0, 0, 0);
    if (product.pivot.parent) {
      product.pivot.parent.visible = true;
      product.pivot.parent.position.set(0, 0, 0);
      product.pivot.parent.rotation.set(0, 0, 0);
      product.pivot.parent.scale.setScalar(1);
    }
    const box = new THREE.Box3().setFromObject(product.pivot);
    const c = new THREE.Vector3(); box.getCenter(c);
    this.camRig.position.set(0, 0, 0);
    this.camRig.rotation.set(0, 0, 0);
    this.camera.position.set(c.x + 0.9, c.y + 0.5, c.z + dist);
    this.camera.lookAt(c);
    this.lights.setMood('windows', 'windows', 0, 1);
    this.lights.aimHero(c, 1, dist);
    this.lights.placeBoxes(c, this.camera.position, 0, 1);
    this.lightWall.placeBehind(c, 5.5, 0.85, 0);
    this.lightWall.update(this.time);
    this.floor.update(this.time, c, 1);
    this.postFx.focusOn(dist, 0.0003);
    this.postFx.update(this.time, 0.016);
    this.postFx.composer.render();
  }

  /**
   * Adaptive quality. If the machine cannot hold a reasonable frame rate the
   * pixel ratio drops first, then depth of field goes. Better a scene that
   * runs than one that is correct and stutters.
   */
  watchPerformance(dt) {
    this._frames++;
    if (dt > 0.032) this._slowFrames++;
    if (this.time - this._lastFpsCheck < 3) return;
    this._lastFpsCheck = this.time;
    const ratio = this._slowFrames / Math.max(1, this._frames);
    this._frames = 0; this._slowFrames = 0;
    if (ratio <= 0.45) return;

    if (this.mirror && this.mirror.mirror.visible) {
      /* The floor reflection goes first. It is a whole extra render of the
         scene and it is the one effect the page still looks premium without —
         the floor keeps its environment reflection and its clearcoat either
         way. */
      this.mirror.setEnabled(false);
      console.info('[atrium] disabled the floor reflection');
    } else if (this.maxDpr > 0.8) {
      this.maxDpr = Math.max(0.8, this.maxDpr - 0.25);
      this.onResize();
      console.info('[atrium] reduced pixel ratio to', this.maxDpr);
    } else if (this.postFx.bokeh?.enabled) {
      // Depth of field is a whole extra scene render. It is the most
      // expensive single thing here and the next to go.
      this.postFx.bokeh.enabled = false;
      console.info('[atrium] disabled depth of field');
    }
  }

  /* ------------------------------------------------------------- teardown */

  dispose() {
    this.disposed = true;
    this.running = false;
    window.removeEventListener('pointermove', this.onPointer);
    window.removeEventListener('resize', this.onResize);
    document.removeEventListener('visibilitychange', this.onVisibility);
    this.lenis?.destroy();
    this.stepper?.destroy(window);
    window.removeEventListener('scroll', this.onDocScroll);
    window.removeEventListener('keydown', this.onEscape);
    window.fensterLenis?.start?.();
    this.mark?.dispose();
    this.terminal?.dispose();
    this.floor?.dispose();
    this.mirror?.dispose();
    this.shell?.dispose();
    this.portal?.dispose();
    /* `this.bay` used to be here and is never assigned anywhere — a rename
       that left the teardown pointing at nothing, which optional chaining
       turns into a silent no-op rather than an error. The three below are the
       pieces that actually exist and were all leaking their geometry and
       materials on every quality-tier switch. */
    this.colonnade?.dispose();
    this.screen?.dispose();
    this.chamber?.dispose();
    this.glassHall?.dispose();
    Object.values(this.shadows).forEach((s) => s.dispose());
    Object.values(this.words).forEach((w) => w.dispose());
    Object.values(this.floorTexts).forEach((f) => f.dispose());
    this.steps.forEach(({ s, cap }) => { s.dispose(); cap.dispose(); });
    this.callouts.forEach(({ c }) => c.dispose());
    this.dimensions.forEach((d) => d.dispose());
    this.swingArc?.dispose();
    this.finishLabel?.dispose();
    Object.values(this.products).forEach((p) => p.dispose());
    this.envMap?.dispose();
    this.renderer?.dispose();
    delete window.__fensterScrollTo;
    delete window.__fensterAtrium;
  }
}

/* ------------------------------------------------------------------ boot */

const root = document.querySelector('[data-fx-atrium]');
if (root) {
  const atrium = new Atrium(root);
  atrium.init();
}
