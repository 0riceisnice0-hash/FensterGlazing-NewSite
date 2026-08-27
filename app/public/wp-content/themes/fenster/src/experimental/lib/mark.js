/**
 * The Fenster mark, as an object rather than an image.
 *
 * The mark is traced out of `assets/brand/favicon-512.png` into real vector
 * paths by `scripts/trace-logo.mjs`, then extruded here. That matters: it is
 * genuine geometry with thickness, so it takes the room's light on its bevels,
 * casts its green into the glass beside it, and can be turned to catch a
 * highlight along an edge. A textured plane cannot do any of that, and at this
 * size the difference is the whole first impression.
 *
 * The two strokes are steel and the leaf is glass, so the mark is made of the
 * two materials the company sells.
 */
import * as THREE from 'three';
import { SVGLoader } from 'three/examples/jsm/loaders/SVGLoader.js';
import { markMaterials, BRAND, linearColour } from './materials.js';

export async function buildMark({ url, envMap, quality, targetHeight = 3.1 }) {
  const loader = new SVGLoader();
  const data = await loader.loadAsync(url);

  const mats = markMaterials(envMap, quality);
  const group = new THREE.Group();
  group.name = 'fensterMark';

  const bevel = quality === 'low'
    ? { bevelEnabled: false }
    : {
        bevelEnabled: true,
        bevelThickness: 6,
        bevelSize: 5,
        bevelOffset: 0,
        bevelSegments: quality === 'high' ? 5 : 2,
      };

  const strokeMeshes = [];
  let leafMesh = null;

  for (const path of data.paths) {
    // The tracer writes the two groups with the brand colours, which is how
    // the steel strokes and the leaf are told apart here without relying on
    // path order.
    const hex = path.color.getHex();
    const isLeaf = path.color.g > path.color.r + 0.05;

    const shapes = SVGLoader.createShapes(path);
    for (const shape of shapes) {
      const geo = new THREE.ExtrudeGeometry(shape, {
        depth: isLeaf ? 44 : 66,
        curveSegments: quality === 'high' ? 14 : 6,
        steps: 1,
        ...bevel,
      });
      geo.computeVertexNormals();
      const mesh = new THREE.Mesh(geo, isLeaf ? mats.leaf : mats.steel);
      mesh.renderOrder = isLeaf ? 3 : 2;
      group.add(mesh);
      if (isLeaf) leafMesh = mesh; else strokeMeshes.push(mesh);
    }
  }

  /* SVG's Y axis runs down the page and three's runs up, so the whole thing is
     flipped, then centred on its own bounding box and scaled to a real-world
     height. Doing this from the measured box rather than from the viewBox is
     what keeps it centred if the tracer output ever changes. */
  group.scale.y *= -1;
  const box = new THREE.Box3().setFromObject(group);
  const size = new THREE.Vector3();
  const centre = new THREE.Vector3();
  box.getSize(size);
  box.getCenter(centre);

  const inner = new THREE.Group();
  inner.name = 'markInner';
  while (group.children.length) inner.add(group.children[0]);
  inner.position.set(-centre.x, -centre.y, -centre.z);

  const scale = targetHeight / size.y;
  const outer = new THREE.Group();
  outer.name = 'fensterMark';
  outer.add(inner);
  outer.scale.setScalar(scale);
  // Undo the parent's own flip so the mark reads the right way up.
  inner.scale.y *= -1;
  inner.scale.x *= 1;

  /* A green glow disc behind the leaf. The brief asks for the logo to cast a
     faint glow onto nearby glass; a real light would be the honest way to do
     it but it costs a shadow-casting light in a scene that has none, so this
     is an additive card that reads identically from the front and is free. */
  const glowGeo = new THREE.PlaneGeometry(targetHeight * 2.1, targetHeight * 2.1);
  const glowMat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    uniforms: {
      uColour: { value: linearColour(BRAND.accent) },
      uIntensity: { value: 0.5 },
      uTime: { value: 0 },
    },
    vertexShader: `
      varying vec2 vUv;
      void main() { vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }
    `,
    fragmentShader: `
      uniform vec3 uColour; uniform float uIntensity; uniform float uTime;
      varying vec2 vUv;
      void main() {
        float d = length(vUv - 0.5) * 2.0;
        float a = pow(max(0.0, 1.0 - d), 3.4);
        // Very slow breathe, so the mark is never completely still.
        a *= 0.86 + 0.14 * sin(uTime * 0.5);
        gl_FragColor = vec4(uColour, a * uIntensity);
      }
    `,
  });
  const glow = new THREE.Mesh(glowGeo, glowMat);
  glow.position.set(-targetHeight * 0.12, -targetHeight * 0.24, -0.42);
  glow.renderOrder = 0;
  outer.add(glow);

  return {
    group: outer,
    inner,
    strokes: strokeMeshes,
    leaf: leafMesh,
    materials: mats,
    glow,
    setGlow(v) { glowMat.uniforms.uIntensity.value = v; },
    /**
     * Fade the whole mark out.
     *
     * Needed because it is a travelling companion now: it rides along in
     * camera space for most of the journey, and there are two beats — the
     * bifold wipe and the travel through the doorway — that are supposed to
     * own the entire frame. A logo hanging in the corner through those is the
     * one thing that would break them.
     *
     * `transparent` is toggled rather than left on, because a permanently
     * transparent mark joins the sorted pass and loses its depth ordering
     * against the glass panes it floats among.
     */
    setOpacity(v) {
      const o = Math.min(1, Math.max(0, v));
      const clear = o > 0.995;
      for (const m of [mats.steel, mats.leaf, mats.edge]) {
        if (!m) continue;
        m.transparent = !clear;
        m.opacity = o;
        m.depthWrite = clear;
      }
      outer.visible = o > 0.01;
    },
    update(time) { glowMat.uniforms.uTime.value = time; },
    dispose() {
      inner.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      glowGeo.dispose();
      glowMat.dispose();
      Object.values(mats).forEach((m) => m.dispose());
    },
  };
}
