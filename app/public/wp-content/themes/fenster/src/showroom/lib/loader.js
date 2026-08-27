/**
 * Load one optimised product, and hand back the three things the page needs:
 * the object, its open/close clip, and its materials indexed by role.
 *
 * ONE PRODUCT AT A TIME. `dispose()` is not an afterthought here — the whole
 * performance case for these pages rests on never holding more than one model
 * in GPU memory, and three.js will happily leak every geometry and material
 * you stop referencing. The acceptance gate is that `renderer.info.memory`
 * returns to baseline after ten product switches, which only happens if the
 * caller actually calls this.
 */

import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { MeshoptDecoder } from 'three/examples/jsm/libs/meshopt_decoder.module.js';

/* Bundled rather than fetched. The decoder is 6.3KB gzipped — smaller than the
   round trip it would cost to ask for it separately, and it means the viewer
   has exactly one network dependency per product: the model itself.
   (Draco was measured at 73.6KB gzipped for the same job. It compresses the
   meshes about 26KB harder each, so it wins a session where someone opens
   three or more products — but it loses the first interaction by 42KB and
   decodes a good deal slower, and the first interaction is the one that
   decides whether there is a session at all.) */
let loader = null;
function sharedLoader() {
  if (!loader) {
    loader = new GLTFLoader();
    loader.setMeshoptDecoder(MeshoptDecoder);
  }
  return loader;
}

/**
 * Materials carry their role in their name, written by scripts/optimise-models.mjs
 * — `fenster:frame`, `fenster:glass`, `fenster:hardware`, `fenster:trim`.
 *
 * A name rather than an index, because an index is not stable across a rebuild
 * of the assets and the finish switcher has to find the frame material by
 * something that survives re-optimising the models.
 */
function indexMaterials(root) {
  const byRole = { frame: [], glass: [], hardware: [], trim: [], other: [] };
  const seen = new Set();
  root.traverse((n) => {
    if (!n.isMesh) return;
    const list = Array.isArray(n.material) ? n.material : [n.material];
    for (const m of list) {
      if (!m || seen.has(m.uuid)) continue;
      seen.add(m.uuid);
      const role = (m.name || '').startsWith('fenster:')
        ? m.name.slice('fenster:'.length)
        : 'other';
      (byRole[role] || byRole.other).push(m);
    }
  });
  return byRole;
}

/**
 * Normalise to a known height and centre on the origin, so the camera framing
 * is one number for every product rather than a table of exceptions.
 * Returns the scale applied, because the callout positions need it.
 */
function normalise(root, targetHeight) {
  const box = new THREE.Box3().setFromObject(root);
  const size = box.getSize(new THREE.Vector3());
  const centre = box.getCenter(new THREE.Vector3());
  const scale = size.y > 1e-6 ? targetHeight / size.y : 1;

  /* Scale on a WRAPPER, never on the loaded root. Anything parented to a
     scaled node inherits that scale, and these models are in millimetres — a
     0.001 factor turns a callout offset of "1.2 metres" into 1.2mm, at full
     opacity, invisibly. That trap cost this project a full pass. */
  const pivot = new THREE.Group();
  pivot.name = 'productPivot';
  root.position.sub(centre);
  pivot.add(root);
  pivot.scale.setScalar(scale);

  const holder = new THREE.Group();
  holder.name = 'productHolder';
  holder.add(pivot);
  return { holder, pivot, scale, size, box };
}

export async function loadProduct(url, { targetHeight = 2.2, onProgress } = {}) {
  const gltf = await sharedLoader().loadAsync(url, (e) => {
    if (onProgress && e.lengthComputable) onProgress(e.loaded / e.total);
  });

  const root = gltf.scene;
  const { holder, pivot, scale, size } = normalise(root, targetHeight);
  const materials = indexMaterials(root);

  /* The baked clip is named `open-close`, runs 5.00s, and goes shut -> open ->
     shut. Only the first half is ever used, so `setOpen(1)` is the fully open
     state and not a return to shut. */
  const clip = gltf.animations && gltf.animations.length ? gltf.animations[0] : null;
  let mixer = null;
  let action = null;
  if (clip) {
    mixer = new THREE.AnimationMixer(root);
    action = mixer.clipAction(clip);
    action.play();
    action.paused = true;
    action.clampWhenFinished = true;
  }

  return {
    holder,
    pivot,
    root,
    scale,
    size,
    materials,
    animated: !!clip,
    clipDuration: clip ? clip.duration : 0,

    /**
     * Scrub the first half of the clip. 0 is shut, 1 is fully open.
     *
     * `action.time` is written directly and the mixer is ticked with a zero
     * delta. It is NOT `mixer.setTime()`, which zeroes the action's time and
     * then relies on a delta that a paused action multiplies away to nothing —
     * the clip appears to run, `mixer.time` advances correctly, and no geometry
     * moves. Seven baked clips on this project were dead for two entire
     * development passes because of exactly that call.
     */
    setOpen(t) {
      if (!mixer || !action) return;
      const c = Math.min(1, Math.max(0, t));
      action.time = c * clip.duration * 0.5;
      mixer.update(0);
    },

    dispose() {
      if (mixer) mixer.stopAllAction();
      holder.traverse((n) => {
        if (!n.isMesh) return;
        n.geometry?.dispose();
        const list = Array.isArray(n.material) ? n.material : [n.material];
        for (const m of list) {
          if (!m) continue;
          for (const k of Object.keys(m)) {
            const v = m[k];
            if (v && v.isTexture) v.dispose();
          }
          m.dispose();
        }
      });
      holder.removeFromParent();
    },
  };
}
