/**
 * SPATIAL INFORMATION.
 *
 * Pass one put the page's copy in a fixed column on the left of the viewport.
 * It read as a hero banner with a 3D background, which is the opposite of the
 * intent: the moment there is a paragraph pinned to the glass, the scene is
 * wallpaper behind a website.
 *
 * So the information moved into the room. This module is the vocabulary for
 * that — a small, consistent set of marks borrowed from architectural drawings
 * and product photography, not from web layout:
 *
 *   CALLOUT     a node on the object, a hairline leader, a block of type at
 *               the end of it. The workhorse.
 *   FLOOR TEXT  words lying on the floor, read in perspective.
 *   SWING ARC   the dashed arc and arrowhead that shows which way a sash opens.
 *   PLAQUE      a small pane of etched glass standing near a product.
 *   STEP        a numbered marker, for the pricing approach.
 *
 * Everything here is depth-tested, so the geometry occludes it. A label that
 * floats in front of the product it is pointing at is a HUD; a label the door
 * can pass in front of is in the room.
 */
import * as THREE from 'three';
import { BRAND, linearColour } from './materials.js';

const FONT = '"Gibson", system-ui, sans-serif';

/* ------------------------------------------------------------------ text */

/**
 * Draw a hierarchical block to a canvas: a title, a spec line, and optional
 * meta. One canvas per callout rather than three planes — the layout is then
 * typographic rather than a stack of transforms, and it costs one draw call.
 */
function calloutTexture({ title, spec, meta, accent = '#1d8a5a', align = 'left', maxWidth = 300 }) {
  const S = 3;                     // supersample; these are small on screen
  const titleSize = 46 * S;
  /* 34 and 30, up from 30 and 25. The measured on-screen cap heights were 5.3px
     for a spec line and 2.8px for a meta line — a 7px and a 4px font-size
     equivalent. Nothing on a web page is ever set that small; the meta line was
     not small type, it was texture. */
  const specSize = 34 * S;
  const metaSize = 30 * S;
  const gap = 13 * S;
  const pad = 16 * S;
  const rule = 3 * S;
  const MAXW = maxWidth * S;

  const measure = document.createElement('canvas').getContext('2d');
  const track = (size, ls) => size * ls;

  const widthOf = (text, size, weight, ls) => {
    measure.font = weight + ' ' + size + 'px ' + FONT;
    let w = 0;
    for (const ch of text) w += measure.measureText(ch).width + track(size, ls);
    return w - track(size, ls);
  };

  /* WRAPPING, WHICH IS THE WHOLE REASON THE TYPE CAN GET BIGGER.
   *
   * These blocks live in a gutter between the product's outer edge and the
   * edge of frame — measured at roughly 144 screen pixels. A single-line spec
   * such as "LINIAR ENERGYPLUS 70MM UPVC" is 1420 canvas pixels of type being
   * minified into that, which is why it came out at a 7px font-size
   * equivalent.
   *
   * The plate's world width is `height * aspect`, so a long line does not
   * merely look small — it forces the whole block wide, and the block was
   * already touching ndc 0.99. Wrapping turns a 3.8:1 strip into roughly a
   * 1.8:1 column, which buys the height increase at CONSTANT on-screen width.
   * Measured on the casement: 1517x396 becomes 951x525, the world width is
   * unchanged at 0.69m, and the title goes from 8.2px to 13.1px of cap. */
  const wrap = (text, size, weight, ls) => {
    if (!text) return [];
    const words = String(text).split(/\s+/).filter(Boolean);
    const lines = [];
    let cur = '';
    for (const w of words) {
      const trial = cur ? cur + ' ' + w : w;
      if (cur && widthOf(trial, size, weight, ls) > MAXW) { lines.push(cur); cur = w; }
      else cur = trial;
    }
    if (cur) lines.push(cur);
    return lines;
  };

  const titleLines = wrap(title, titleSize, 700, 0.15);
  const specLines = wrap(spec, specSize, 400, 0.045);
  const metaLines = wrap(meta, metaSize, 400, 0.10);

  const lead = 1.08;
  const widest = (lines, size, weight, ls) =>
    lines.reduce((m, l) => Math.max(m, widthOf(l, size, weight, ls)), 0);

  const contentW = Math.max(
    widest(titleLines, titleSize, 700, 0.15),
    widest(specLines, specSize, 400, 0.045),
    widest(metaLines, metaSize, 400, 0.10),
    1
  );
  const hasBody = specLines.length > 0 || metaLines.length > 0;
  const contentH =
    titleLines.length * titleSize * lead
    + (titleLines.length && hasBody ? gap * 0.6 + rule : 0)
    + (specLines.length ? gap + specLines.length * specSize * lead : 0)
    + (metaLines.length ? gap + metaLines.length * metaSize * lead : 0);

  const cw = Math.ceil(contentW + pad * 2);
  const ch = Math.ceil(contentH + pad * 2);

  const canvas = document.createElement('canvas');
  canvas.width = cw; canvas.height = ch;
  const ctx = canvas.getContext('2d');

  /* A FROSTED PLATE BEHIND THE TYPE.
   *
   * These are dark letters, and they are placed in world space against
   * whatever the product happens to be standing in front of. On a pale wall
   * they read perfectly; the moment one lands over a bench, a shadow or a
   * dark aluminium frame it disappears, and which of those happens depends on
   * where the camera is — so it cannot be solved by moving the callout.
   *
   * A very light, very soft plate under the text fixes it everywhere at once.
   * Kept at 62% and heavily feathered so it never reads as a label on a card,
   * which is exactly the web-overlay look this whole page exists to avoid: it
   * should look like the wall behind has been lightened slightly, not like a
   * box has been placed on it.
   */
  const plate = ctx.createLinearGradient(0, 0, 0, ch);
  plate.addColorStop(0, 'rgba(247,249,249,0)');
  plate.addColorStop(0.16, 'rgba(247,249,249,0.62)');
  plate.addColorStop(0.84, 'rgba(247,249,249,0.62)');
  plate.addColorStop(1, 'rgba(247,249,249,0)');
  ctx.fillStyle = plate;
  ctx.fillRect(0, 0, cw, ch);
  // Feather the ends too, so the plate has no vertical edge anywhere.
  const ends = ctx.createLinearGradient(0, 0, cw, 0);
  ends.addColorStop(0, 'rgba(247,249,249,0)');
  ends.addColorStop(0.10, 'rgba(247,249,249,0.32)');
  ends.addColorStop(0.90, 'rgba(247,249,249,0.32)');
  ends.addColorStop(1, 'rgba(247,249,249,0)');
  ctx.globalCompositeOperation = 'lighter';
  ctx.fillStyle = ends;
  ctx.fillRect(0, 0, cw, ch);
  ctx.globalCompositeOperation = 'source-over';

  ctx.textBaseline = 'top';

  const originX = align === 'right' ? cw - pad : pad;
  const draw = (text, size, weight, ls, colour, y) => {
    ctx.font = weight + ' ' + size + 'px ' + FONT;
    ctx.fillStyle = colour;
    const w = widthOf(text, size, weight, ls);
    let x = align === 'right' ? originX - w : originX;
    for (const chr of text) {
      ctx.fillText(chr, x, y);
      x += ctx.measureText(chr).width + track(size, ls);
    }
  };

  let y = pad;
  if (titleLines.length) {
    // Brand ink, not black. Pure black type on a warm white wall is harsher
    // than anything else in the frame and pulls the eye off the product.
    for (const line of titleLines) {
      draw(line, titleSize, 700, 0.15, '#0d2a33', y);
      y += titleSize * lead;
    }
    if (hasBody) {
      /* A short rule under the title. This one detail is most of what makes
         the block read as a drawing callout rather than as a caption. */
      y += gap * 0.6;
      ctx.fillStyle = accent;
      const rw = Math.min(contentW, titleSize * 1.5);
      ctx.fillRect(align === 'right' ? originX - rw : originX, y, rw, rule);
      y += rule;
    }
  }
  if (specLines.length) {
    y += gap;
    for (const line of specLines) {
      draw(line, specSize, 400, 0.045, 'rgba(20,55,66,0.78)', y);
      y += specSize * lead;
    }
  }
  if (metaLines.length) {
    y += gap;
    for (const line of metaLines) {
      draw(line, metaSize, 400, 0.10, accent, y);
      y += metaSize * lead;
    }
  }

  /* The cap height of the title, MEASURED rather than assumed, so the caller
     can size the plate by how big the type needs to be on screen instead of
     by how tall the plate happens to come out. */
  measure.font = '700 ' + titleSize + 'px ' + FONT;
  const m = measure.measureText('H');
  const capPx = m.actualBoundingBoxAscent || titleSize * 0.7;

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  /* 16, not 8. The GPU reports 16 as its maximum and every one of these plates
     is viewed off-axis out near the frame edge, which is precisely the case
     anisotropic filtering exists for. */
  tex.anisotropy = 16;
  return { texture: tex, aspect: cw / ch, capPx, canvasH: ch };
}

/* --------------------------------------------------------------- callout */

/**
 * A node, a leader, and a block of type.
 *
 * `anchor` is where it points, `offset` is where the type sits, both local to
 * whatever the group is added to. The leader is drawn as two segments — out,
 * then across — which is how it is done on a real drawing and reads far better
 * than a diagonal.
 *
 * The whole thing draws on: the node appears, the leader extends, the type
 * fades up once the leader has arrived. `setProgress` is a pure function of one
 * number, so it reverses perfectly when the visitor scrolls back up.
 */
export function buildCallout({
  title, spec, meta,
  anchor = [0, 0, 0],
  offset = [0.9, 0.55, 0],
  /* THE WORLD HEIGHT OF A CAPITAL IN THE TITLE LINE, which is the thing that
     actually decides whether any of this can be read.
     *
     * The old parameter was `height`, the plate's world height — and because
     * the canvas grows with the line count while `height` does not, one value
     * produced different type on different blocks. A two-line note and a
     * three-line note were both passed 0.15 and rendered their titles 27%
     * apart, which nobody chose and nobody could see in the source. Driving
     * the plate from the cap height instead makes every block set the same
     * size whatever it contains. */
  titleCap = 0.07,
  height,                       // legacy escape hatch: fixes the plate instead
  accent = BRAND.accent,
  align = 'left',
  maxWidth = 300,
}) {
  const group = new THREE.Group();
  const accentCss = '#' + new THREE.Color(accent).getHexString();
  const { texture, aspect, capPx, canvasH } =
    calloutTexture({ title, spec, meta, accent: accentCss, align, maxWidth });
  const plateH = height !== undefined ? height : titleCap * (canvasH / capPx);

  const a = new THREE.Vector3().fromArray(anchor);
  const o = new THREE.Vector3().fromArray(offset);
  // The elbow: out from the anchor, then across to the type.
  const elbow = new THREE.Vector3(a.x + (o.x - a.x) * 0.42, o.y, a.z + (o.z - a.z) * 0.42);

  /* the node -------------------------------------------------------------- */
  const nodeMat = new THREE.MeshBasicMaterial({
    color: linearColour(accent), transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false, side: THREE.DoubleSide,
  });
  const node = new THREE.Mesh(new THREE.RingGeometry(0.026, 0.038, 20), nodeMat);
  node.position.copy(a);
  group.add(node);

  const dotMat = new THREE.MeshBasicMaterial({
    color: linearColour(0x0d2a33), transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
  });
  const dot = new THREE.Mesh(new THREE.CircleGeometry(0.011, 12), dotMat);
  dot.position.copy(a);
  group.add(dot);

  /* the leader ------------------------------------------------------------ */
  const lineMat = new THREE.LineBasicMaterial({
    color: linearColour(accent), transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
  });
  const pts = new Float32Array(9);
  const lineGeo = new THREE.BufferGeometry();
  lineGeo.setAttribute('position', new THREE.BufferAttribute(pts, 3));
  const line = new THREE.Line(lineGeo, lineMat);
  group.add(line);

  /* the type -------------------------------------------------------------- */
  const textMat = new THREE.MeshBasicMaterial({
    map: texture, transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
  });
  const textGeo = new THREE.PlaneGeometry(plateH * aspect, plateH);
  const text = new THREE.Mesh(textGeo, textMat);
  // Hung off the end of the leader, on the side it travelled toward.
  const tx = o.x + (align === 'right' ? -plateH * aspect / 2 - 0.06 : plateH * aspect / 2 + 0.06);
  text.position.set(tx, o.y, o.z);
  group.add(text);

  const _a = a.clone(), _e = elbow.clone(), _o = o.clone();
  const _m = new THREE.Vector3(), _p = new THREE.Vector3();
  let progress = 0;

  return {
    group,
    setProgress(p) {
      progress = Math.min(1, Math.max(0, p));
      // Segment one draws first (0 -> 0.45), then segment two.
      const p1 = Math.min(1, progress / 0.45);
      const p2 = Math.max(0, (progress - 0.45) / 0.55);
      _m.lerpVectors(_a, _e, p1);
      _p.lerpVectors(_e, _o, p2);
      pts.set([_a.x, _a.y, _a.z, _m.x, _m.y, _m.z, _p.x, _p.y, _p.z]);
      lineGeo.attributes.position.needsUpdate = true;
      lineGeo.computeBoundingSphere();
    },
    setOpacity(v) {
      const o2 = Math.min(1, Math.max(0, v));
      lineMat.opacity = o2 * 0.75;
      nodeMat.opacity = o2 * 0.9;
      dotMat.opacity = o2;
      // Type arrives last, and only once the leader has actually reached it,
      // so the eye follows the line to the words.
      textMat.opacity = o2 * Math.min(1, Math.max(0, (progress - 0.55) / 0.35));
      group.visible = o2 > 0.008;
    },
    /** Turn the type to face the camera; the leader stays fixed in the world. */
    face(cameraPos) {
      text.lookAt(cameraPos);
      node.lookAt(cameraPos);
      dot.lookAt(cameraPos);
    },
    dispose() {
      lineGeo.dispose(); textGeo.dispose(); texture.dispose();
      node.geometry.dispose(); dot.geometry.dispose();
      lineMat.dispose(); textMat.dispose(); nodeMat.dispose(); dotMat.dispose();
    },
  };
}

/* ------------------------------------------------------------ floor text */

/**
 * Words lying on the floor.
 *
 * Read in extreme perspective, which is exactly why they work: the visitor
 * sees them as part of the room instead of as a caption. Used for the
 * provenance line under the window — "REAL WINDOWCAD GEOMETRY" etched into the
 * floor beats the same sentence set in a paragraph.
 */
export function buildFloorText(text, {
  height = 0.5, colour = 0x6fb8c8, opacity = 0.5, weight = 500, tracking = 0.42,
} = {}) {
  const S = 3;
  const size = 60 * S;
  const measure = document.createElement('canvas').getContext('2d');
  measure.font = weight + ' ' + size + 'px ' + FONT;
  const sp = size * tracking;
  let w = 0;
  for (const ch of text) w += measure.measureText(ch).width + sp;
  w -= sp;

  const canvas = document.createElement('canvas');
  canvas.width = Math.ceil(w + size * 0.6);
  canvas.height = Math.ceil(size * 1.6);
  const ctx = canvas.getContext('2d');
  ctx.font = weight + ' ' + size + 'px ' + FONT;
  ctx.textBaseline = 'middle';
  ctx.fillStyle = '#ffffff';
  let x = size * 0.3;
  for (const ch of text) { ctx.fillText(ch, x, canvas.height / 2); x += ctx.measureText(ch).width + sp; }

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  tex.anisotropy = 8;

  const aspect = canvas.width / canvas.height;
  const mat = new THREE.MeshBasicMaterial({
    map: tex, transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
    color: linearColour(colour),
    /* Normal blending, not additive.
       On the dark floor these were additive so they read as light let into the
       slab. On a pale floor adding light to something already near white does
       nothing at all — the type simply vanished. Normal blending over a light
       ground is ordinary dark lettering painted on concrete, which is both
       visible and what a real wayfinding graphic is. */
  });
  const geo = new THREE.PlaneGeometry(height * aspect, height);
  const mesh = new THREE.Mesh(geo, mat);
  mesh.rotation.x = -Math.PI / 2;
  mesh.renderOrder = -1;

  return {
    mesh, width: height * aspect,
    setOpacity(v) { mat.opacity = v * opacity; mesh.visible = v > 0.01; },
    dispose() { geo.dispose(); mat.dispose(); tex.dispose(); },
  };
}

/* ------------------------------------------------------------- swing arc */

/**
 * The dashed arc and arrowhead that shows which way a sash swings.
 *
 * Straight off an architect's plan drawing. It appears as the casement opens,
 * which turns a piece of motion into a piece of information at no extra cost.
 */
export function buildSwingArc({ radius = 0.8, sweep = Math.PI * 0.42, colour = BRAND.accent } = {}) {
  const group = new THREE.Group();
  const mat = new THREE.LineDashedMaterial({
    color: linearColour(colour), transparent: true, opacity: 0,
    dashSize: 0.06, gapSize: 0.045, depthWrite: false, toneMapped: false,
  });

  const SEG = 40;
  const pts = [];
  for (let i = 0; i <= SEG; i++) {
    const ang = (i / SEG) * sweep;
    pts.push(new THREE.Vector3(Math.sin(ang) * radius, 0, Math.cos(ang) * radius - radius));
  }
  const geo = new THREE.BufferGeometry().setFromPoints(pts);
  const arc = new THREE.Line(geo, mat);
  arc.computeLineDistances();
  group.add(arc);

  const headMat = new THREE.MeshBasicMaterial({
    color: linearColour(colour), transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false, side: THREE.DoubleSide,
  });
  const head = new THREE.Mesh(new THREE.ConeGeometry(0.035, 0.11, 3), headMat);
  head.position.copy(pts[pts.length - 1]);
  head.rotation.set(Math.PI / 2, 0, -sweep);
  group.add(head);

  const total = geo.attributes.position.count;
  return {
    group,
    setProgress(p) {
      // Draw range rather than opacity, so the arc sweeps out in the direction
      // the sash is actually travelling.
      geo.setDrawRange(0, Math.max(2, Math.floor(total * Math.min(1, Math.max(0, p)))));
      head.visible = p > 0.92;
    },
    setOpacity(v) { mat.opacity = v * 0.7; headMat.opacity = v * 0.8; group.visible = v > 0.01; },
    dispose() { geo.dispose(); mat.dispose(); head.geometry.dispose(); headMat.dispose(); },
  };
}

/* ---------------------------------------------------------------- plaque */

/**
 * A small pane of etched glass standing beside a product.
 *
 * The museum caption, made physical: a thin sheet with the type frosted into
 * it, standing in the room, catching light on its edges.
 */
export function buildPlaque({ title, spec, meta, width = 1.1, envMap, accent = BRAND.accent }) {
  const group = new THREE.Group();
  const accentCss = '#' + new THREE.Color(accent).getHexString();
  const { texture, aspect } = calloutTexture({ title, spec, meta, accent: accentCss });

  const h = width / aspect;
  const pad = width * 0.16;

  const glass = new THREE.MeshPhysicalMaterial({
    color: linearColour(0xdceaee),
    metalness: 0, roughness: 0.12,
    transmission: 0.9, thickness: 0.04, ior: 1.5,
    envMap, envMapIntensity: 0.9,
    transparent: true, opacity: 0, depthWrite: false,
    side: THREE.DoubleSide,
  });
  const pane = new THREE.Mesh(new THREE.BoxGeometry(width + pad * 2, h + pad * 2, 0.012), glass);
  group.add(pane);

  const edgeMat = new THREE.LineBasicMaterial({
    color: linearColour(accent), transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
  });
  const edges = new THREE.LineSegments(new THREE.EdgesGeometry(pane.geometry), edgeMat);
  group.add(edges);

  const textMat = new THREE.MeshBasicMaterial({
    map: texture, transparent: true, opacity: 0,
    depthWrite: false, toneMapped: false,
  });
  const text = new THREE.Mesh(new THREE.PlaneGeometry(width, h), textMat);
  text.position.z = 0.009;
  group.add(text);

  return {
    group,
    setOpacity(v) {
      glass.opacity = v * 0.5;
      edgeMat.opacity = v * 0.5;
      textMat.opacity = v;
      group.visible = v > 0.01;
    },
    dispose() {
      pane.geometry.dispose(); glass.dispose(); edgeMat.dispose();
      edges.geometry.dispose();
      text.geometry.dispose(); textMat.dispose(); texture.dispose();
    },
  };
}

/* ------------------------------------------------------------ step marks */

/**
 * A numbered step marker for the pricing approach.
 *
 * The numeral set large and hairline, the label small beside it, a rule
 * between. Four of these arriving one at a time around the terminal is the
 * whole "how it works" section, told in eight words instead of a paragraph.
 */
/* NOTE: these are the one exception to the light palette. The steps stand
   inside the pricing chamber, which is the single dark volume in the building,
   so they are drawn light-on-dark like everything else in there. */
export function buildStep(number, label, { height = 0.34, accent = BRAND.accent } = {}) {
  const S = 3;
  const numSize = 96 * S, labSize = 34 * S, gap = 16 * S, pad = 12 * S;
  const measure = document.createElement('canvas').getContext('2d');

  measure.font = '200 ' + numSize + 'px ' + FONT;
  const nW = measure.measureText(number).width;
  measure.font = '600 ' + labSize + 'px ' + FONT;
  const track = labSize * 0.18;
  let lW = 0;
  for (const ch of label) lW += measure.measureText(ch).width + track;
  lW -= track;

  const canvas = document.createElement('canvas');
  canvas.width = Math.ceil(nW + gap + lW + pad * 2);
  canvas.height = Math.ceil(numSize * 1.3 + pad * 2);
  const ctx = canvas.getContext('2d');
  ctx.textBaseline = 'middle';
  const midY = canvas.height / 2;

  // The numeral: hairline and dimmed. It is an ordinal, not a shout.
  ctx.font = '200 ' + numSize + 'px ' + FONT;
  ctx.fillStyle = 'rgba(190,222,232,0.55)';
  ctx.fillText(number, pad, midY);

  ctx.fillStyle = '#' + new THREE.Color(accent).getHexString();
  ctx.fillRect(pad + nW + gap * 0.42, midY - numSize * 0.3, 2 * S, numSize * 0.6);

  ctx.font = '600 ' + labSize + 'px ' + FONT;
  ctx.fillStyle = '#ffffff';
  let x = pad + nW + gap;
  for (const ch of label) { ctx.fillText(ch, x, midY); x += ctx.measureText(ch).width + track; }

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  tex.anisotropy = 8;
  const aspect = canvas.width / canvas.height;
  const mat = new THREE.MeshBasicMaterial({
    map: tex, transparent: true, opacity: 0, depthWrite: false, toneMapped: false,
  });
  const geo = new THREE.PlaneGeometry(height * aspect, height);
  const mesh = new THREE.Mesh(geo, mat);

  return {
    mesh, width: height * aspect,
    setOpacity(v) { mat.opacity = v; mesh.visible = v > 0.01; },
    dispose() { geo.dispose(); mat.dispose(); tex.dispose(); },
  };
}
