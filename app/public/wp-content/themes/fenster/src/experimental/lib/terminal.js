/**
 * The Instant Pricing terminal.
 *
 * This is the climax and it has one hard constraint: the WindowCAD iframe has
 * to stay a real, usable iframe. Somebody must be able to configure a window
 * and get a price at the end of it. So it is never a texture.
 *
 * How it is done, and why not the obvious way:
 *
 *   `CSS3DRenderer` is the textbook answer for putting a live DOM element in a
 *   three.js scene, and it does not work here. It needs the WebGL canvas to be
 *   transparent with a depth-only occlusion mesh punching a hole for the DOM
 *   layer behind it — and the moment there is a post-processing chain, the
 *   composer's output is an opaque fullscreen quad and the hole is painted
 *   over. Dropping post-processing to keep CSS3D would trade the entire grade
 *   for one element.
 *
 *   So the terminal is two objects that hand over to each other:
 *
 *   1. A WebGL panel that IS part of the scene. It can be occluded, it takes
 *      the room's light, the composite door can swing in front of it, and it
 *      refracts through the glass around it. It shows a rendered still of the
 *      interface.
 *   2. A real `<iframe>` in a DOM layer above the canvas, transformed with the
 *      same projection matrix the camera is using, so it occupies exactly the
 *      same screen quad as the panel.
 *
 *   During the reveal the panel is what you see. Once the camera has settled
 *   square-on and nothing is passing in front any more, the iframe crossfades
 *   over the top of it and becomes interactive. The seam is invisible because
 *   both are the same rectangle in the same perspective.
 */
import * as THREE from 'three';
import { BRAND, linearColour, glassRefracts } from './materials.js';

/**
 * Drive a DOM element with a three.js object's world transform.
 *
 * Same maths CSS3DRenderer uses: the container gets the camera's perspective
 * in pixels, and each element gets the camera-relative matrix as `matrix3d`.
 * The Y axis is negated because CSS's Y runs down the page.
 */
class ProjectedElement {
  /**
   * @param {number} pxPerUnit  How many CSS pixels one world unit is worth.
   *
   * THE UNIT MISMATCH IS THE WHOLE DIFFICULTY HERE, and getting it wrong fails
   * silently: the iframe renders at five pixels by three in the corner of the
   * screen and simply looks absent.
   *
   * CSS perspective is expressed in PIXELS. This scene is expressed in metres,
   * and the terminal is about 4.6 of them across. Feed a world position
   * straight into a `matrix3d` and the browser reads `z = 1` as one pixel from
   * the eye rather than one metre, so the element collapses to nothing.
   *
   * So the projection is done in a parallel space where one world unit IS
   * `pxPerUnit` pixels: scale the camera's translation and the object's
   * translation by the same factor, leave rotation alone, and size the element
   * in CSS pixels to match. The DOM rectangle and the WebGL rectangle are then
   * the same rectangle, which is what makes the crossfade between them
   * invisible.
   */
  constructor(element, layer, pxPerUnit) {
    this.element = element;
    this.layer = layer;
    this.pxPerUnit = pxPerUnit;
    // The camera's transform goes on its own wrapper between the perspective
    // container and the element, which is the structure the browser expects.
    this.cameraEl = document.createElement('div');
    this.cameraEl.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;transform-origin:0 0;transform-style:preserve-3d;';
    layer.appendChild(this.cameraEl);
    this.cameraEl.appendChild(element);
    this.object = new THREE.Object3D();
    this._m = new THREE.Matrix4();
    this._camWorld = new THREE.Matrix4();
    this._camInv = new THREE.Matrix4();
    element.style.position = 'absolute';
    element.style.top = '0';
    element.style.left = '0';
    element.style.transformStyle = 'preserve-3d';
    element.style.willChange = 'transform';
    layer.style.transformStyle = 'preserve-3d';
    layer.style.perspective = 'none';
  }

  static cameraCss(m) {
    const e = m.elements;
    const f = (n) => (Math.abs(n) < 1e-7 ? 0 : n);
    return 'matrix3d(' + [
      f(e[0]), f(-e[1]), f(e[2]), f(e[3]),
      f(e[4]), f(-e[5]), f(e[6]), f(e[7]),
      f(e[8]), f(-e[9]), f(e[10]), f(e[11]),
      f(e[12]), f(-e[13]), f(e[14]), f(e[15]),
    ].join(',') + ')';
  }

  static objectCss(m) {
    const e = m.elements;
    const f = (n) => (Math.abs(n) < 1e-7 ? 0 : n);
    return 'matrix3d(' + [
      f(e[0]), f(e[1]), f(e[2]), f(e[3]),
      f(-e[4]), f(-e[5]), f(-e[6]), f(-e[7]),
      f(e[8]), f(e[9]), f(e[10]), f(e[11]),
      f(e[12]), f(e[13]), f(e[14]), f(e[15]),
    ].join(',') + ')';
  }

  /**
   * FLAT MODE, AND WHY THE CONFIGURATOR NEEDS IT.
   *
   * The 3D placement below paints the panel exactly where the WebGL panel is,
   * and it has always done so. What it does NOT do is put the element anywhere
   * the browser will hit-test it: measured at the resting pose, the iframe's
   * getBoundingClientRect() reports 345,88 911x604 while
   * `document.elementFromPoint` at the centre of that rectangle returns the
   * section root. The painted region and the hit region have parted company,
   * because the perspective is applied as a transform FUNCTION on the camera
   * wrapper — which is what makes the render correct — and the wrapper's own
   * layout box stays 110x63 in the middle of the screen.
   *
   * So the configurator was visible and completely unclickable, at every
   * viewport size, and had been since it was built. It never showed up because
   * nothing had asked to click it; the sequence used to sweep past this beat.
   * Now the last stop exists SO THAT it can be used.
   *
   * The fix leans on a fact about the resting pose rather than on fighting the
   * transform chain: at the final stop the camera has zero roll, pitch and yaw
   * and the terminal's own rotation has eased to zero, so the panel is exactly
   * parallel to the image plane. A plane parallel to the image plane projects
   * to an axis-aligned rectangle — which a plain 2D translate and scale
   * reproduce EXACTLY, not approximately. There is no pop, because there is no
   * difference to pop between.
   *
   * While flying in, the 3D path still runs and the panel is not interactive
   * anyway.
   */
  setFlat(on) { this._flat = !!on; }

  updateFlat(camera, width, height) {
    const o = this.object;
    o.updateMatrixWorld();
    const p = new THREE.Vector3().setFromMatrixPosition(o.matrixWorld);
    const centre = p.clone().project(camera);

    /* Scale from the projected height of the panel itself rather than from a
       distance formula, so it stays correct whatever the lens is doing. */
    const half = new THREE.Vector3(0, this.element.offsetHeight / (2 * this.pxPerUnit), 0)
      .applyQuaternion(o.quaternion).add(p);
    const top = half.project(camera);
    const halfPx = Math.abs(top.y - centre.y) * (height / 2);
    const scale = (halfPx * 2) / Math.max(1, this.element.offsetHeight);

    const cx = (centre.x * 0.5 + 0.5) * width;
    const cy = (-centre.y * 0.5 + 0.5) * height;

    // No 3D on the wrapper at all: a plain 2D box the browser can hit-test.
    this.cameraEl.style.transform = 'none';
    this.element.style.transform =
      `translate(${cx}px,${cy}px) translate(-50%,-50%) scale(${scale})`;
  }

  update(camera, width, height) {
    if (this._flat) return this.updateFlat(camera, width, height);
    const k = this.pxPerUnit;
    // Same figure three derives: heightHalf / tan(fovY / 2).
    const fov = camera.projectionMatrix.elements[5] * (height / 2);

    camera.updateMatrixWorld();
    this._camWorld.copy(camera.matrixWorld);
    this._camWorld.elements[12] *= k;
    this._camWorld.elements[13] *= k;
    this._camWorld.elements[14] *= k;
    this._camInv.copy(this._camWorld).invert();

    this.object.updateMatrixWorld();
    this._m.copy(this.object.matrixWorld);
    this._m.elements[12] *= k;
    this._m.elements[13] *= k;
    this._m.elements[14] *= k;

    /* The exact order CSS3DRenderer uses, and every part of it is load-bearing:
       `perspective()` as a TRANSFORM FUNCTION rather than the CSS property, and
       the centring translate AFTER the camera matrix rather than on an
       ancestor. Putting the translate on the parent instead — which looks
       equivalent — moves the perspective origin with it, and the iframe lands
       a couple of hundred pixels down and right of the WebGL panel it is
       supposed to sit exactly on top of. */
    /* Pin the transform origin to the top-left and put the centring translate
       at the FRONT of the chain, so it happens in screen space after the
       projection rather than in world space before it. CSS3DRenderer can put
       it last because its camera element is a zero-height box whose default
       origin compensates; relying on that is how this ended up 760px out in Y
       while being pixel-exact in X. Explicit is better here. */
    this.cameraEl.style.transform =
      `translate(${width / 2}px,${height / 2}px)` +
      `perspective(${fov}px) translateZ(${fov}px)` +
      ProjectedElement.cameraCss(this._camInv);

    this.element.style.transform =
      'translate(-50%,-50%)' + ProjectedElement.objectCss(this._m);
  }
}

/**
 * Draw a convincing still of the configurator for the WebGL panel.
 *
 * IT IS DRAWN LIGHT, AND THAT IS NOT A THEME DECISION.
 * This texture exists to stand in for the real WindowCAD iframe during the
 * approach, and then cross-fade to it. The real interface is a light one. A
 * dark mock that hands over to a light iframe is a visible cut at the exact
 * moment the sequence is trying to convince you that the thing you have been
 * flying toward IS the tool — so the stand-in has to match what it replaces.
 *
 * The price card deliberately reads a blank figure. The real tool takes your
 * details before it shows a number, and drawing an invented price here would
 * be the one claim on this page that is not true.
 */
function interfaceTexture(width = 1024, height = 700) {
  const c = document.createElement('canvas');
  c.width = width; c.height = height;
  const x = c.getContext('2d');

  const bg = x.createLinearGradient(0, 0, 0, height);
  bg.addColorStop(0, '#ffffff');
  bg.addColorStop(1, '#f2f5f6');
  x.fillStyle = bg; x.fillRect(0, 0, width, height);

  // chrome bar
  x.fillStyle = '#ffffff';
  x.fillRect(0, 0, width, 58);
  x.fillStyle = 'rgba(14,45,55,0.10)';
  x.fillRect(0, 57, width, 1);
  x.fillStyle = 'rgba(46,172,102,0.95)';
  x.beginPath(); x.roundRect(26, 18, 132, 22, 4); x.fill();
  x.fillStyle = 'rgba(14,45,55,0.16)';
  for (let i = 0; i < 4; i++) { x.beginPath(); x.roundRect(186 + i * 92, 20, 74, 18, 3); x.fill(); }

  // left panel — option rows
  x.fillStyle = '#f6f8f8';
  x.fillRect(0, 58, 272, height - 58);
  x.fillStyle = 'rgba(14,45,55,0.08)';
  x.fillRect(271, 58, 1, height - 58);
  for (let i = 0; i < 8; i++) {
    const y = 96 + i * 56;
    x.fillStyle = i === 2 ? 'rgba(46,172,102,0.14)' : '#ffffff';
    x.beginPath(); x.roundRect(22, y, 228, 40, 6); x.fill();
    x.strokeStyle = i === 2 ? 'rgba(46,172,102,0.5)' : 'rgba(14,45,55,0.10)';
    x.lineWidth = 1;
    x.beginPath(); x.roundRect(22.5, y + 0.5, 227, 39, 6); x.stroke();
    x.fillStyle = i === 2 ? 'rgba(24,120,74,0.95)' : 'rgba(20,55,66,0.35)';
    x.beginPath(); x.roundRect(38, y + 15, 92 + (i * 13) % 70, 9, 4); x.fill();
  }

  // stage — a window elevation
  const sx = 340, sy = 122, sw = 388, sh = 400;
  x.strokeStyle = 'rgba(40,80,95,0.55)'; x.lineWidth = 12;
  x.strokeRect(sx, sy, sw, sh);
  x.fillStyle = 'rgba(150,196,214,0.20)'; x.fillRect(sx, sy, sw, sh);
  x.lineWidth = 8;
  x.beginPath(); x.moveTo(sx + sw / 2, sy); x.lineTo(sx + sw / 2, sy + sh); x.stroke();
  x.beginPath(); x.moveTo(sx, sy + sh * 0.34); x.lineTo(sx + sw / 2, sy + sh * 0.34); x.stroke();
  // handle
  x.fillStyle = 'rgba(30,66,78,0.85)';
  x.beginPath(); x.roundRect(sx + sw / 2 + 10, sy + sh * 0.6, 10, 46, 5); x.fill();
  // dimension
  x.strokeStyle = 'rgba(24,130,80,0.85)'; x.lineWidth = 2;
  x.beginPath(); x.moveTo(sx, sy + sh + 28); x.lineTo(sx + sw, sy + sh + 28); x.stroke();
  x.fillStyle = 'rgba(24,120,74,0.95)';
  x.font = '600 20px system-ui'; x.textAlign = 'center';
  x.fillText('1200 mm', sx + sw / 2, sy + sh + 54);

  // price card
  x.fillStyle = '#ffffff';
  x.beginPath(); x.roundRect(772, 122, 226, 168, 10); x.fill();
  x.strokeStyle = 'rgba(14,45,55,0.12)'; x.lineWidth = 1;
  x.beginPath(); x.roundRect(772.5, 122.5, 225, 167, 10); x.stroke();
  x.fillStyle = 'rgba(20,55,66,0.45)';
  x.font = '500 15px system-ui'; x.textAlign = 'left';
  x.fillText('YOUR PRICE', 796, 158);
  x.fillStyle = '#0d2a33'; x.font = '700 46px system-ui';
  x.fillText('£  ---', 796, 214);
  x.fillStyle = 'rgba(46,172,102,0.95)';
  x.beginPath(); x.roundRect(796, 238, 178, 34, 6); x.fill();

  for (let i = 0; i < 3; i++) {
    x.fillStyle = '#ffffff';
    x.beginPath(); x.roundRect(772, 316 + i * 62, 226, 48, 8); x.fill();
    x.strokeStyle = 'rgba(14,45,55,0.10)'; x.lineWidth = 1;
    x.beginPath(); x.roundRect(772.5, 316.5 + i * 62, 225, 47, 8); x.stroke();
  }

  const tex = new THREE.CanvasTexture(c);
  tex.colorSpace = THREE.SRGBColorSpace;
  tex.anisotropy = 8;
  return tex;
}

export function buildTerminal({ scene, layer, iframeUrl, quality, width = 4.6, height = 3.05 }) {
  const group = new THREE.Group();
  group.name = 'terminal';

  /* ---- the WebGL panel ------------------------------------------------- */

  const screenTex = interfaceTexture();
  const screenMat = new THREE.MeshBasicMaterial({
    map: screenTex,
    transparent: true,
    opacity: 0,
    toneMapped: false,
    depthWrite: false,
  });
  const screen = new THREE.Mesh(new THREE.PlaneGeometry(width, height), screenMat);
  screen.position.z = 0.045;
  screen.renderOrder = 4;
  group.add(screen);

  /* The bezel. A slab of glass with an aluminium surround — the same two
     materials as the products, so the terminal reads as a Fenster object
     rather than as a UI dropped into the room. */
  const glassMat = new THREE.MeshPhysicalMaterial({
    color: linearColour(0x9dc4d2),
    metalness: 0,
    roughness: 0.05,
    transmission: glassRefracts(quality) ? 0.96 : 0,
    thickness: 0.14,
    ior: 1.5,
    transparent: true,
    opacity: quality === 'high' ? 1 : 0.2,
    depthWrite: false,
    clearcoat: 1,
    clearcoatRoughness: 0.02,
    side: THREE.DoubleSide,
    attenuationColor: linearColour(0xd9f4ff),
    attenuationDistance: 2.0,
  });
  const glass = new THREE.Mesh(new THREE.BoxGeometry(width * 1.045, height * 1.06, 0.05), glassMat);
  glass.renderOrder = 3;
  group.add(glass);

  const frameMat = new THREE.MeshPhysicalMaterial({
    color: linearColour(0x2b3b42),
    metalness: 0.95,
    roughness: 0.2,
    clearcoat: 1,
    clearcoatRoughness: 0.1,
  });
  const frameGroup = new THREE.Group();
  const t = 0.085, d = 0.14;
  const bar = (w, h, px, py) => {
    const m = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), frameMat);
    m.position.set(px, py, 0);
    frameGroup.add(m);
  };
  bar(width * 1.09, t, 0, height * 0.53 + t / 2);
  bar(width * 1.09, t, 0, -height * 0.53 - t / 2);
  bar(t, height * 1.06 + t * 2, -width * 0.545 - t / 2, 0);
  bar(t, height * 1.06 + t * 2, width * 0.545 + t / 2, 0);
  group.add(frameGroup);

  // Emissive edge glow along the bezel, so the terminal looks powered.
  const edgeMat = new THREE.MeshBasicMaterial({
    color: linearColour(BRAND.accent),
    transparent: true, opacity: 0, blending: THREE.AdditiveBlending, depthWrite: false, toneMapped: false,
  });
  const edge = new THREE.LineSegments(
    new THREE.EdgesGeometry(new THREE.BoxGeometry(width * 1.06, height * 1.07, 0.06)),
    edgeMat
  );
  group.add(edge);

  // A soft halo card behind, so the terminal throws light into the room.
  const haloMat = new THREE.ShaderMaterial({
    transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
    uniforms: {
      uColour: { value: linearColour(0x51c9e8) },
      uIntensity: { value: 0 },
      uTime: { value: 0 },
    },
    vertexShader: `varying vec2 vUv; void main(){ vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0);} `,
    fragmentShader: `
      uniform vec3 uColour; uniform float uIntensity; uniform float uTime;
      varying vec2 vUv;
      void main(){
        vec2 p = (vUv - 0.5) * 2.0;
        float d = length(p * vec2(1.0, 1.35));
        float a = pow(max(0.0, 1.0 - d), 2.8) * (0.9 + 0.1 * sin(uTime * 0.8));
        gl_FragColor = vec4(uColour, a * uIntensity);
      }`,
  });
  const halo = new THREE.Mesh(new THREE.PlaneGeometry(width * 2.6, height * 2.8), haloMat);
  halo.position.z = -0.35;
  halo.renderOrder = 2;
  group.add(halo);

  scene.add(group);

  /* ---- the real iframe ------------------------------------------------- */

  const shell = document.createElement('div');
  shell.className = 'fx-terminal';
  shell.setAttribute('aria-hidden', 'true');
  // Sized in CSS pixels at a fixed ratio matching the world plane, so the DOM
  // rectangle and the WebGL rectangle are the same shape and the crossfade
  // between them has nothing to give it away.
  const pxPerUnit = 210;
  shell.style.width = `${Math.round(width * pxPerUnit)}px`;
  shell.style.height = `${Math.round(height * pxPerUnit)}px`;
  shell.innerHTML = `
    <div class="fx-terminal__chrome">
      <span class="fx-terminal__dot"></span>
      <span class="fx-terminal__title">Fenster Instant Pricing</span>
      <span class="fx-terminal__meta">WindowCAD &middot; live</span>
    </div>
    <div class="fx-terminal__frame">
      <iframe title="Fenster instant pricing configurator"
              loading="lazy"
              data-fx-quote-src="${iframeUrl}"
              allow="fullscreen"></iframe>
    </div>
    <div class="fx-terminal__glare" aria-hidden="true"></div>
  `;
  const projected = new ProjectedElement(shell, layer, pxPerUnit);
  const iframe = shell.querySelector('iframe');
  let iframeLoaded = false;

  return {
    group,
    screen,
    shell,
    iframe,
    anchor: projected.object,
    /* Square-on and resting: swap to a 2D box so the iframe can be clicked.
       See ProjectedElement.setFlat. */
    setFlat(on) { projected.setFlat(on); },

    /** Load the real configurator. Deferred until the phase is approaching. */
    arm() {
      if (iframeLoaded) return;
      iframeLoaded = true;
      iframe.src = iframe.dataset.fxQuoteSrc;
    },

    /**
     * `reveal` 0..1 drives the WebGL panel; `handover` 0..1 crossfades to the
     * live iframe and turns interaction on.
     */
    set(reveal, handover) {
      screenMat.opacity = Math.max(0, reveal * (1 - handover));
      edgeMat.opacity = reveal * 0.55;
      haloMat.uniforms.uIntensity.value = reveal * 0.42;
      glassMat.opacity = (quality === 'high' ? 1 : 0.2) * Math.max(0.05, reveal);
      group.visible = reveal > 0.004;

      shell.style.opacity = String(handover);
      shell.style.pointerEvents = handover > 0.92 ? 'auto' : 'none';
      shell.setAttribute('aria-hidden', handover > 0.92 ? 'false' : 'true');
      // The WebGL bezel stays visible under the live iframe — it is the thing
      // that keeps the terminal an object in the room rather than a panel
      // floating over a render.
      frameMat.opacity = 1;
    },

    update(camera, w, h, time) {
      haloMat.uniforms.uTime.value = time;
      projected.object.position.copy(group.position);
      projected.object.quaternion.copy(group.quaternion);
      projected.object.scale.setScalar(group.scale.x);
      projected.update(camera, w, h);
    },

    dispose() {
      screenTex.dispose();
      screenMat.dispose();
      glassMat.dispose();
      frameMat.dispose();
      edgeMat.dispose();
      haloMat.dispose();
      shell.remove();
    },
  };
}
