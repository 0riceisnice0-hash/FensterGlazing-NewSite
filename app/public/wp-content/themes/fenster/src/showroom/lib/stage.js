/**
 * The studio: renderer, light, ground, and a camera that frames whatever you
 * give it. Shared by the poster generator and the live viewer, so a poster and
 * the 3D that replaces it are the same photograph — which is the only way the
 * cross-fade between them is invisible.
 *
 * DELIBERATELY CHEAP. There is no post-processing, no planar reflection and no
 * shadow-map pass anywhere in here. The audit of this project's earlier 3D page
 * measured all three and found that turning every one of them off moved the
 * frame rate by a single frame per second — the cost was 2,223 draw calls, not
 * the effects. So there is no budget to spend on effects and nothing to gain
 * from them. What is left does the work: an image-based environment for the
 * glass and the metal, one soft key for shape, and a drawn contact shadow.
 */

import * as THREE from 'three';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';

export const GROUND_Y = -1.25;

/**
 * A contact shadow that is drawn, not computed.
 *
 * A shadow-map pass costs a second render of every mesh in the scene. A radial
 * gradient on a plane costs one draw call and, for a product standing on a
 * plain ground with soft light, is indistinguishable. It multiplies rather than
 * blending, so it darkens the floor instead of laying grey paint on it.
 */
function buildContactShadow(scene, { width = 3.2, depth = 1.6 } = {}) {
  const size = 256;
  const canvas = document.createElement('canvas');
  canvas.width = canvas.height = size;
  const ctx = canvas.getContext('2d');
  /* PURE BLACK with a varying alpha, blended normally — not a tinted colour
     multiplied in. The first version multiplied the floor by (1 - shadowColour)
     using a blue-grey shadow, which removes more blue than red and turned the
     contact shadow PINK. A shadow has no hue of its own here; the ground and
     the environment supply all the colour there is. */
  const g = ctx.createRadialGradient(size / 2, size / 2, 0, size / 2, size / 2, size / 2);
  g.addColorStop(0, 'rgba(0,0,0,0.42)');
  g.addColorStop(0.45, 'rgba(0,0,0,0.15)');
  g.addColorStop(1, 'rgba(0,0,0,0)');
  ctx.fillStyle = g;
  ctx.fillRect(0, 0, size, size);

  const tex = new THREE.CanvasTexture(canvas);
  tex.colorSpace = THREE.SRGBColorSpace;
  const mat = new THREE.MeshBasicMaterial({
    map: tex,
    transparent: true,
    depthWrite: false,
    toneMapped: false,
  });
  const mesh = new THREE.Mesh(new THREE.PlaneGeometry(width, depth), mat);
  mesh.rotation.x = -Math.PI / 2;
  mesh.position.y = GROUND_Y + 0.004;
  mesh.renderOrder = 2;
  scene.add(mesh);
  return {
    mesh,
    fit(box) {
      const size3 = box.getSize(new THREE.Vector3());
      mesh.scale.set(Math.max(0.4, size3.x / width * 1.5), Math.max(0.4, size3.z / depth * 2.6), 1);
      mesh.position.x = (box.min.x + box.max.x) / 2;
    },
    dispose() { mesh.geometry.dispose(); tex.dispose(); mat.dispose(); },
  };
}

/* Deeper than the page's own ground. A white uPVC window on a near-white
   background has almost no silhouette, and half this range is white uPVC. This
   is still unmistakably a light studio; it just gives the product an edge. */
export function buildStage(canvas, { width, height, background = 0xe3e8e7, ground = true } = {}) {
  const renderer = new THREE.WebGLRenderer({
    canvas,
    antialias: true,
    alpha: false,
    powerPreference: 'high-performance',
  });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(width, height, false);
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.0;

  const scene = new THREE.Scene();
  scene.background = new THREE.Color(background);

  /* Generated, not loaded. An HDR file would be another request and another
     hundred kilobytes for a product that is mostly grey aluminium and glass;
     RoomEnvironment is compiled once at startup and gives the glass something
     to reflect, which is the entire job. */
  const pmrem = new THREE.PMREMGenerator(renderer);
  const envRT = pmrem.fromScene(new RoomEnvironment(), 0.04);
  scene.environment = envRT.texture;

  /* One key for shape and one fill to stop the shadow side going dead. The
     environment does the rest. */
  const key = new THREE.DirectionalLight(0xfff6ec, 1.55);
  key.position.set(2.4, 3.4, 3.2);
  scene.add(key);
  const fill = new THREE.DirectionalLight(0xdfeaf2, 0.45);
  fill.position.set(-3.0, 1.2, -1.4);
  scene.add(fill);

  /* NO FLOOR PLANE AT ALL, and the reason is worth writing down because the
     obvious fix does not work.
     *
     * A ground plane drew a hard horizon across every frame. Setting its colour
     * to match the background does NOT remove it: the floor is a lit
     * MeshStandardMaterial taking key, fill and environment, while the
     * background is a flat constant the renderer clears to. They cannot match
     * by construction, only by coincidence, and they did not.
     *
     * The floor was never doing anything else. The contact shadow blends onto
     * the background perfectly well without a surface underneath it, which is
     * how a product is photographed on seamless paper — and this is one fewer
     * draw call and one fewer object in every frame. */
  const floor = null;
  const shadow = ground ? buildContactShadow(scene) : null;

  const camera = new THREE.PerspectiveCamera(32, width / height, 0.1, 100);

  /**
   * Frame an object so it fills a chosen fraction of the SHORTER axis, then
   * back off far enough that the wider axis fits too.
   *
   * Solving for height alone is what produced a page of cropped doors on the
   * earlier build: a narrow product framed on height is fine, a wide one
   * framed on height runs off both sides. Both constraints, take the further.
   */
  function frame(object, { fill: fillFrac = 0.82, yaw = 0.42, pitch = 0.13, box: cached } = {}) {
    /* `cached` matters more than it looks. `Box3.setFromObject` walks every
       mesh in the object and transforms its bounding box — on a hundred-mesh
       door that is real work, and doing it inside the per-frame camera update
       held the viewer to 28fps while it was being dragged. The box is measured
       once when a product loads and passed in from then on.
       The product is framed SHUT and stays framed that way while it opens,
       which is also the better shot: a camera that backs off as a door swings
       reads as the camera flinching. */
    const box = cached || new THREE.Box3().setFromObject(object);
    const size = box.getSize(new THREE.Vector3());
    const centre = box.getCenter(new THREE.Vector3());

    const vFov = (camera.fov * Math.PI) / 180;
    const distH = (size.y / fillFrac) / (2 * Math.tan(vFov / 2));
    const hFov = 2 * Math.atan(Math.tan(vFov / 2) * camera.aspect);
    const distW = (size.x / fillFrac) / (2 * Math.tan(hFov / 2));
    const dist = Math.max(distH, distW) + size.z * 0.5;

    camera.position.set(
      centre.x + Math.sin(yaw) * Math.cos(pitch) * dist,
      centre.y + Math.sin(pitch) * dist,
      centre.z + Math.cos(yaw) * Math.cos(pitch) * dist
    );
    camera.lookAt(centre);
    camera.updateProjectionMatrix();
    return { box, centre, size, dist };
  }

  /** Stand an object on the ground rather than centring it on the origin. */
  function standOn(object) {
    const box = new THREE.Box3().setFromObject(object);
    object.position.y += GROUND_Y - box.min.y;
    object.updateMatrixWorld(true);
    const settled = new THREE.Box3().setFromObject(object);
    if (shadow) shadow.fit(settled);
    return settled;
  }

  function resize(w, h) {
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
  }

  function render() {
    renderer.render(scene, camera);
  }

  function dispose() {
    shadow?.dispose();
    if (floor) { floor.geometry.dispose(); floor.material.dispose(); }
    envRT.dispose();
    pmrem.dispose();
    renderer.dispose();
  }

  return { renderer, scene, camera, frame, standOn, resize, render, dispose, shadow };
}
