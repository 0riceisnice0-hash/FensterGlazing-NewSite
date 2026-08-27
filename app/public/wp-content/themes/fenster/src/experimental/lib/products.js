/**
 * Loading the real WindowCAD geometry.
 *
 * Every model here is genuine exported scene geometry from the configurator
 * the business quotes with — see `assets/experimental/models/manifest.json`
 * for provenance and, more importantly, for what genuinely varies. All
 * thirteen files are distinct meshes, verified by hash, so nothing on this
 * page is the same product wearing two names. Size is deliberately not an
 * axis: `3d.md` records that only bifolds truly vary by size, so showing size
 * variants would be inventing a range.
 *
 * The seven animated models each carry one clip, `open-close`, five seconds,
 * shut -> open -> shut. Only the first half is ever used, scrubbed against
 * scroll, so scrolling physically opens the product.
 */
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { MeshoptDecoder } from 'three/examples/jsm/libs/meshopt_decoder.module.js';
import { dressModel } from './materials.js';

export class ProductLoader {
  constructor({ baseUrl, manifestFile, envMap, quality, transmissive = null, onProgress }) {
    this.baseUrl = baseUrl.replace(/\/$/, '');
    /* A manifest PER ROUTE. The gallery streams everything its manifest
       lists — heroes first, then the rest as scenery — so a shared manifest
       would have the window route quietly downloading seven door models to
       dress its colonnade. 408KB against 1.1MB. */
    this.manifestFile = manifestFile || 'manifest.json';
    this.envMap = envMap;
    this.quality = quality;
    this.transmissive = transmissive;
    this.onProgress = onProgress || (() => {});
    this.loader = new GLTFLoader();
    /* The optimised models are meshopt-compressed. The decoder is 6.3KB
       gzipped and is bundled rather than fetched — Draco was measured at
       73.6KB for the same job, which is more than a whole window model. */
    this.loader.setMeshoptDecoder(MeshoptDecoder);
    this.cache = new Map();
    this.loaded = 0;
    this.total = 0;
  }

  async manifest() {
    if (this._manifest) return this._manifest;
    const res = await fetch(`${this.baseUrl}/${this.manifestFile}`);
    this._manifest = await res.json();
    return this._manifest;
  }

  /**
   * Load one product and normalise it.
   *
   * Normalising to a target height rather than trusting the export's units is
   * the safe move: these came out of an architectural configurator and the
   * unit convention is not documented anywhere I would want to rely on. It
   * also means every product sits at a comparable size in its bay whatever
   * it actually measures, which is what the composition needs.
   */
  async load(entry, opts = {}) {
    const key = entry.file;
    if (this.cache.has(key)) return this.cache.get(key);

    const gltf = await this.loader.loadAsync(`${this.baseUrl}/${entry.file}`);
    const root = gltf.scene;

    const dressed = dressModel(root, {
      transmissive: this.transmissive,
      envMap: this.envMap,
      quality: this.quality,
      frameColour: opts.frameColour ?? null,
    });

    // Centre on the bounding box and scale to a real height.
    const box = new THREE.Box3().setFromObject(root);
    const size = new THREE.Vector3();
    const centre = new THREE.Vector3();
    box.getSize(size);
    box.getCenter(centre);

    const targetHeight = opts.targetHeight ?? 2.35;
    const scale = size.y > 0.0001 ? targetHeight / size.y : 1;

    const pivot = new THREE.Group();
    pivot.name = entry.id;
    /* CENTRED ON ITS OWN BOUNDING BOX, not sat on its base.
       Sitting each product on its base gives a row of them a shared floor
       line, which is right for a catalogue rail and wrong here: it puts the
       pivot at the product's feet, so anything blocked at y = 0 floats
       entirely into the top half of frame. Measured before the change, the
       hero window spanned ndc y 0 to 4.8 — most of it above the top edge.
       Where a floor line IS wanted, whatever holds the product supplies it:
       `installInBay()` and the hero blocks both position by
       `FLOOR_Y + height/2`, which stands the product on the floor. */
    root.position.sub(centre);
    pivot.add(root);
    pivot.scale.setScalar(scale);

    let mixer = null;
    let action = null;
    let clipDuration = 0;
    if (gltf.animations && gltf.animations.length) {
      mixer = new THREE.AnimationMixer(root);
      const clip = gltf.animations.find((c) => c.name === 'open-close') || gltf.animations[0];
      clipDuration = clip.duration;
      action = mixer.clipAction(clip);
      action.play();
      action.paused = true;
      // Park it shut. Setting time before the mixer has ticked once does
      // nothing, so tick a zero-length frame to arm it — the same trap the
      // product pages hit with model-viewer's currentTime.
      mixer.setTime(0);
    }

    const product = {
      entry,
      pivot,
      root,
      ...dressed,
      mixer,
      action,
      clipDuration,
      height: targetHeight,
      /**
       * Scrub the open/close clip. `t` is 0 shut to 1 fully open, mapped onto
       * the clip's first half only, because the baked clip closes again in its
       * second half and a scroll-driven product should not shut itself when
       * the user keeps scrolling.
       */
      setOpen(t) {
        if (!mixer || !action) return;
        const clamped = Math.min(1, Math.max(0, t));

        /* SET `action.time` DIRECTLY. DO NOT USE `mixer.setTime()`.
         *
         * This was the single worst bug in the project and it survived two
         * passes. `AnimationMixer.setTime(x)` zeroes `action.time` on every
         * action and then calls `update(x)`, expecting the delta to carry each
         * action forward. But a **paused** action has `_updateTimeScale()`
         * return 0, so its delta is multiplied to nothing and its time stays
         * at the zero that `setTime` just wrote.
         *
         * The action here is paused on purpose — that is what stops the clip
         * playing itself on a wall clock. So the combination is silently
         * inert: `mixer.time` advanced to exactly the right value, every call
         * looked correct from the outside, and `action.time` never left 0.
         *
         * Net effect: NONE of the seven baked open/close clips ever ran. No
         * sash ever opened, the composite door never swung, and the bifold
         * "concertina" that the whole windows-to-doors transition is built on
         * was a closed slab sliding across the frame. The page's central
         * claim — that scroll scrubs real WindowCAD hinge geometry — was not
         * true until this line changed.
         *
         * Writing `action.time` and ticking a zero-length frame is the correct
         * scrub: `mixer.update(0)` still evaluates and applies every action's
         * bindings at its current time, paused or not.
         */
        action.time = clamped * clipDuration * 0.5;
        mixer.update(0);
      },
      setVisible(v) { pivot.visible = v; },
      dispose() {
        root.traverse((n) => {
          if (n.isMesh) {
            n.geometry.dispose();
            if (Array.isArray(n.material)) n.material.forEach((m) => m.dispose());
            else n.material?.dispose();
          }
        });
      },
    };

    this.cache.set(key, product);
    this.loaded += 1;
    this.onProgress(this.loaded, this.total);
    return product;
  }

  /** Load a set in parallel, reporting progress as each lands. */
  async loadSet(entries, optsFor = () => ({})) {
    this.total += entries.length;
    return Promise.all(entries.map((e) => this.load(e, optsFor(e))));
  }
}

/* The `Orbit` class lived here and was removed in pass three.
   It placed products on a ring that revolved around the origin, which made
   sense while the camera was fixed and the world turned. Once the camera
   started travelling the length of a building it stopped meaning anything, and
   it showed: products drifted half in and half out of frame, cropped at odd
   angles, at no particular height, belonging to nothing. They are installed in
   the colonnade's bays now — see `buildColonnade()` in lib/architecture.js. */
