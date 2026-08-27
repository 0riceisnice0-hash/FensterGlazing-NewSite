/**
 * Typography that lives in the scene rather than over it.
 *
 * The words are drawn to a canvas in Gibson — the real brand face, already
 * loaded by the page — and used as textures on planes placed deep in the
 * world. That is deliberately not TextGeometry: a generic 3D font would lose
 * Gibson, and extruded type at this size reads as a logo rather than as a
 * title. On a plane, far behind the products, the word gets occluded by
 * frames passing in front of it, which is the effect actually wanted.
 *
 * Also here: the engineering annotations. Dimension lines that draw themselves
 * across a product while it is centre stage. They are what make the scene read
 * as architectural visualisation rather than as an advert.
 */
import * as THREE from 'three';
import { BRAND, linearColour } from './materials.js';

const DPR_CAP = 2;

/**
 * Draw a word to a canvas texture at a size that stays crisp when it fills a
 * large part of the screen. Canvas is capped at 4096 because a word plane
 * wider than that gains nothing and costs 64MB of VRAM.
 */
function wordTexture(text, opts = {}) {
  const {
    weight = 800,
    letterSpacing = 0.02,
    fill = '#ffffff',
    font = 'Gibson',
    padding = 0.12,
  } = opts;

  const fontSize = 320;
  const measure = document.createElement('canvas').getContext('2d');
  measure.font = `${weight} ${fontSize}px "${font}", system-ui, sans-serif`;
  const spacing = fontSize * letterSpacing;
  let width = 0;
  for (const ch of text) width += measure.measureText(ch).width + spacing;
  width -= spacing;

  const padX = fontSize * padding;
  const padY = fontSize * 0.34;
  const cw = Math.min(4096, Math.ceil(width + padX * 2));
  const chh = Math.ceil(fontSize + padY * 2);

  const canvas = document.createElement('canvas');
  canvas.width = cw;
  canvas.height = chh;
  const ctx = canvas.getContext('2d');
  ctx.font = `${weight} ${fontSize}px "${font}", system-ui, sans-serif`;
  ctx.textBaseline = 'middle';
  ctx.fillStyle = fill;

  // Draw glyph by glyph so the tracking is real rather than the browser's
  // default, which is far too tight for type at this scale.
  let x = padX;
  const y = chh / 2;
  for (const ch of text) {
    ctx.fillText(ch, x, y);
    x += ctx.measureText(ch).width + spacing;
  }

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  tex.anisotropy = 8;
  tex.needsUpdate = true;
  return { texture: tex, aspect: cw / chh };
}

/**
 * A word as a plane in world space.
 *
 * `depthWrite` is off and `depthTest` is on: the word must be hidden by solid
 * geometry in front of it, but must not itself punch a hole in the glass it
 * sits behind.
 */
export function buildWord(text, opts = {}) {
  const {
    height = 2.4,
    colour = 0xffffff,
    opacity = 1,
    weight = 800,
    letterSpacing = 0.03,
    additive = false,
  } = opts;

  const { texture, aspect } = wordTexture(text, { weight, letterSpacing });
  const mat = new THREE.MeshBasicMaterial({
    map: texture,
    transparent: true,
    opacity,
    depthWrite: false,
    color: linearColour(colour),
    blending: additive ? THREE.AdditiveBlending : THREE.NormalBlending,
    toneMapped: false,
  });
  const geo = new THREE.PlaneGeometry(height * aspect, height);
  const mesh = new THREE.Mesh(geo, mat);
  mesh.renderOrder = 0;
  mesh.userData.baseOpacity = opacity;
  return {
    mesh,
    material: mat,
    width: height * aspect,
    setOpacity(v) { mat.opacity = v; mat.visible = v > 0.004; },
    dispose() { geo.dispose(); mat.dispose(); texture.dispose(); },
  };
}

/**
 * A small technical label — the kind of thing stencilled on a drawing.
 * Used for the micro-detail annotations that float beside products.
 */
export function buildLabel(text, opts = {}) {
  const { height = 0.13, colour = BRAND.accent, opacity = 0.9 } = opts;
  const fontSize = 64;
  const measure = document.createElement('canvas').getContext('2d');
  measure.font = `600 ${fontSize}px "Gibson", system-ui, sans-serif`;
  const spacing = fontSize * 0.16;
  let width = 0;
  for (const ch of text) width += measure.measureText(ch).width + spacing;

  const cw = Math.ceil(width + 40);
  const chh = Math.ceil(fontSize * 1.8);
  const canvas = document.createElement('canvas');
  canvas.width = cw; canvas.height = chh;
  const ctx = canvas.getContext('2d');
  ctx.font = `600 ${fontSize}px "Gibson", system-ui, sans-serif`;
  ctx.textBaseline = 'middle';
  ctx.fillStyle = '#ffffff';
  let x = 20;
  for (const ch of text) { ctx.fillText(ch, x, chh / 2); x += ctx.measureText(ch).width + spacing; }

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  const mat = new THREE.MeshBasicMaterial({
    map: tex, transparent: true, opacity, depthWrite: false,
    color: linearColour(colour), toneMapped: false, blending: THREE.AdditiveBlending,
  });
  const geo = new THREE.PlaneGeometry(height * (cw / chh), height);
  const mesh = new THREE.Mesh(geo, mat);
  return { mesh, material: mat, setOpacity(v) { mat.opacity = v; mat.visible = v > 0.004; }, dispose() { geo.dispose(); mat.dispose(); tex.dispose(); } };
}

/**
 * Dimension annotations across a product: two witness lines, an arrowed
 * dimension line between them, and a figure.
 *
 * The lines draw themselves on with a `uProgress` uniform rather than fading
 * in, because a dimension that grows from its origin reads as a measurement
 * being taken and a dimension that fades in reads as a caption.
 */
export function buildDimension({ from, to, label, colour = BRAND.accentDark, offset = 0.32 }) {
  const group = new THREE.Group();
  group.name = 'dimension';

  const a = new THREE.Vector3().fromArray(from);
  const b = new THREE.Vector3().fromArray(to);
  const dir = new THREE.Vector3().subVectors(b, a);
  const len = dir.length();
  const perp = new THREE.Vector3(-dir.y, dir.x, 0).normalize().multiplyScalar(offset);

  const mat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    uniforms: {
      uProgress: { value: 0 },
      uColour: { value: linearColour(colour) },
      uOpacity: { value: 1 },
    },
    vertexShader: `
      attribute float aT;
      varying float vT;
      void main() { vT = aT; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }
    `,
    fragmentShader: `
      uniform float uProgress; uniform vec3 uColour; uniform float uOpacity;
      varying float vT;
      void main() {
        // Reveal along the line, with a brighter head at the drawing tip so it
        // reads as being struck rather than switched on.
        float on = step(vT, uProgress);
        float head = smoothstep(0.06, 0.0, abs(vT - uProgress));
        gl_FragColor = vec4(uColour * (1.0 + head * 2.4), (on * 0.85 + head) * uOpacity);
      }
    `,
  });

  const positions = [];
  const ts = [];
  const push = (p, t) => { positions.push(p.x, p.y, p.z); ts.push(t); };

  // witness lines
  const a1 = a.clone(), a2 = a.clone().add(perp).multiplyScalar(1);
  const aOut = a.clone().add(perp);
  const bOut = b.clone().add(perp);
  push(a, 0.0); push(aOut, 0.16);
  push(b, 0.0); push(bOut, 0.16);
  // dimension line
  push(aOut, 0.2); push(bOut, 1.0);
  // arrow heads
  const arrow = dir.clone().normalize().multiplyScalar(len * 0.045);
  const arrowPerp = perp.clone().normalize().multiplyScalar(len * 0.022);
  push(aOut, 0.22); push(aOut.clone().add(arrow).add(arrowPerp), 0.3);
  push(aOut, 0.22); push(aOut.clone().add(arrow).sub(arrowPerp), 0.3);
  push(bOut, 0.9); push(bOut.clone().sub(arrow).add(arrowPerp), 0.98);
  push(bOut, 0.9); push(bOut.clone().sub(arrow).sub(arrowPerp), 0.98);

  const geo = new THREE.BufferGeometry();
  geo.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
  geo.setAttribute('aT', new THREE.Float32BufferAttribute(ts, 1));
  const lines = new THREE.LineSegments(geo, mat);
  group.add(lines);

  let text = null;
  if (label) {
    text = buildLabel(label, { height: 0.15, colour, opacity: 0 });
    const mid = new THREE.Vector3().addVectors(aOut, bOut).multiplyScalar(0.5);
    text.mesh.position.copy(mid).add(perp.clone().normalize().multiplyScalar(0.13));
    group.add(text.mesh);
  }

  return {
    group,
    setProgress(p) {
      mat.uniforms.uProgress.value = p;
      if (text) text.setOpacity(Math.max(0, (p - 0.82) / 0.18));
    },
    setOpacity(v) {
      mat.uniforms.uOpacity.value = v;
      group.visible = v > 0.01;
    },
    dispose() { geo.dispose(); mat.dispose(); text?.dispose(); },
  };
}
