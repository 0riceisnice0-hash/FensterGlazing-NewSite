/**
 * THE LIGHT RIG.
 *
 * Split out of atmosphere.js in pass two, because lighting stopped being one
 * setup and became a timeline of its own.
 *
 * The problem this solves, stated plainly: most of the exported geometry is
 * anthracite, the room is near-black, and a dark object in a dark room with a
 * point light on it is a silhouette. Pass one lit the room and hoped.
 *
 * The fix is how a dark car is actually photographed in a dark studio. You do
 * not make the room brighter — you put enormous softboxes just out of frame and
 * let the object's own edges reflect them. What you see is not the light, it is
 * the shape of the light *in the surface*. Every bevel, every mullion, every
 * profile change becomes a break in a long soft highlight.
 *
 * So the rig is now built around two large travelling RectAreaLights that
 * flank whatever is centre stage, plus a thin overhead blade that rakes across
 * it. That is the whole trick.
 *
 * ONE TRAP, AND IT COST PASS ONE ITS HIGHLIGHTS: three.js RectAreaLight needs
 * `RectAreaLightUniformsLib.init()` before it emits anything at all. Pass one
 * created two of them and never called it, so the two "travelling strip
 * lights" that were supposed to keep the frame alive contributed exactly
 * nothing for the entire sequence. No error, no warning — just a rig quietly
 * missing its two most important sources.
 */
import * as THREE from 'three';
import { RectAreaLightUniformsLib } from 'three/examples/jsm/lights/RectAreaLightUniformsLib.js';
import { BRAND, linearColour } from './materials.js';

let ltcReady = false;
function ensureLtc() {
  if (ltcReady) return;
  RectAreaLightUniformsLib.init();
  ltcReady = true;
}

/**
 * Named lighting states, one per hero moment.
 *
 * The room stays coherent — same sources, same positions relative to the
 * subject — but each beat gets its own art direction, which is the difference
 * between a lit scene and a lit *shot*.
 */
export const MOODS = {
  /* THE ROOM IS LIT NOW, SO THE RIG'S JOB CHANGED COMPLETELY.
     In a dark gallery these numbers were fighting to make anything visible at
     all. In a bright one the environment already lights everything, and the
     direct sources exist only to SHAPE — to put a gradient down a face, a
     long soft highlight along an extrusion, and a shadow on the floor. So
     every intensity here is a fraction of what it was, and the softboxes are
     doing something quite different: on a dark frame in a light room, the box
     is the only bright thing the surface can reflect, and its shape breaking
     at every profile change is what makes the section readable. */

  /* The mark. Even, calm, symmetrical. The first frame has to be beautiful
     before anything has moved, and in a white room that means restraint. */
  mark: {
    boxL: { w: 5.4, h: 6.2, i: 1.7, colour: 0xffffff, at: [-4.2, 1.6, 3.4] },
    boxR: { w: 4.2, h: 5.4, i: 1.0, colour: 0xeaf2f6, at: [4.6, 0.8, 2.4] },
    blade: { i: 1.2, colour: 0xfffdf8, y: 5.0, z: 1.2 },
    key: 1.05, rim: 0.5, accent: 9, accent2: 4, ambient: 0.42,
  },
  /* Windows. One big box close and raking, so the frame profile and the
     glazing bead read as separate planes rather than one flat grey shape. */
  windows: {
    /* PULLED WELL BACK OFF THE WALL.
       At [-2.9, 1.0, 1.7] the key box sat about a metre from the face of the
       portal pier, and a 3x6.8 metre area source that close to a 0.85-albedo
       wall clips it — measured at 8.7 per cent of frame on the approach beat,
       the single worst reading left in the sequence. Distance is the fix, not
       intensity: further back keeps the same soft wrap on the product while
       the inverse square takes the wall out of trouble. */
    /* The soft sources come down and the narrow spot picks up the slack.
       A big area source cannot be flagged off the wall the window is installed
       in; a 22-degree spot can simply be aimed past it. The wrap on the frame
       is a little less generous than it was, and the wall keeps its tone. */
    boxL: { w: 3.0, h: 6.8, i: 2.1, colour: 0xffffff, at: [-4.2, 1.0, 4.4] },
    boxR: { w: 5.0, h: 4.2, i: 0.7, colour: 0xdcebf2, at: [5.6, -0.5, 3.4] },
    blade: { i: 1.5, colour: 0xffffff, y: 4.2, z: 0.4 },
    key: 1.35, rim: 0.8, accent: 7, accent2: 8, ambient: 0.44,
  },
  /* Doors. A raking material light — the box comes round to a shallow angle so
     it travels vertically down the slab, which is what a finish demonstration
     needs. Slightly warm, because it is standing in for a hallway. */
  doors: {
    boxL: { w: 1.8, h: 7.6, i: 3.4, colour: 0xfff4e8, at: [-2.4, 1.3, 2.5] },
    boxR: { w: 3.2, h: 5.8, i: 1.1, colour: 0xdfeef6, at: [4.0, 0.3, -0.7] },
    blade: { i: 2.2, colour: 0xffffff, y: 4.8, z: 1.4 },
    key: 1.1, rim: 0.9, accent: 11, accent2: 4, ambient: 0.5,
  },
  /* Pricing. The chamber is the one dark volume in the building, so the rig
     comes right down and the terminal is the brightest thing in frame — the
     only moment in the sequence where that is true, and the reason the arrival
     lands. */
  pricing: {
    boxL: { w: 6.0, h: 5.0, i: 1.5, colour: 0xdcecf4, at: [-4.6, 0.9, 3.6] },
    boxR: { w: 6.0, h: 5.0, i: 1.1, colour: 0xc6dce8, at: [4.6, 0.9, 3.6] },
    blade: { i: 0.9, colour: 0xe6faf1, y: 4.4, z: 2.0 },
    /* The green accent all but off. In the chamber it had nothing pale to
       bounce off and simply tinted the whole volume, so the one dark room in
       the building read as murky green rather than as dark. */
    key: 0.5, rim: 0.4, accent: 1.5, accent2: 1, ambient: 0.34,
  },
};

const lerp = (a, b, t) => a + (b - a) * t;

export function buildLightRig(scene, quality) {
  ensureLtc();

  const rig = new THREE.Group();
  rig.name = 'lightRig';

  const ambient = new THREE.AmbientLight(linearColour(0xdae6ea), 0.42);
  rig.add(ambient);

  // Key: high and camera-left, standing in for the room's own overheads.
  const key = new THREE.DirectionalLight(0xfffdf8, 1.05);
  key.position.set(-6.5, 9, 7.5);
  if (quality === 'high') {
    key.castShadow = true;
    key.shadow.mapSize.set(1024, 1024);
    key.shadow.camera.near = 1;
    key.shadow.camera.far = 42;
    const s = 12;
    key.shadow.camera.left = -s; key.shadow.camera.right = s;
    key.shadow.camera.top = s; key.shadow.camera.bottom = -s;
    // Anthracite on dark concrete: a hard shadow edge looks wrong at this
    // scale, and a soft one is what a big source actually casts.
    /* Softer. On a pale reflective floor a tight shadow edge from a source
       this large is the one thing that gives the lighting away as computed —
       a 5m ceiling panel does not draw a crisp line. */
    key.shadow.radius = 11;
    key.shadow.bias = -0.0009;
  }
  rig.add(key);

  const rim = new THREE.DirectionalLight(linearColour(0xcfe6f2), 0.6);
  rim.position.set(7.5, 3.2, -8);
  rig.add(rim);

  const bounce = new THREE.DirectionalLight(linearColour(0xfff0dc), 0.35);
  bounce.position.set(2, -5, 5);
  rig.add(bounce);

  /* Fenster green, one side only. Restraint matters: any more of this and the
     room stops being architectural and starts being a gaming keyboard. */
  const accent = new THREE.PointLight(linearColour(BRAND.accent), 9, 22, 2.1);
  accent.position.set(-5.5, 1.4, 3.2);
  rig.add(accent);

  const accent2 = new THREE.PointLight(linearColour(BRAND.lightBlue), 5, 18, 2.2);
  accent2.position.set(6.2, -1.6, -2.4);
  rig.add(accent2);

  /* ------------------------------------------------------- the softboxes */

  /* The two big panels. These are the rig. They follow the subject, and
     because a RectAreaLight is a real area source its reflection in the frame
     has *shape* — a long soft streak that breaks at every profile change,
     which is exactly the information a silhouette was throwing away. */
  const boxL = new THREE.RectAreaLight(0xffffff, 0, 4, 6);
  const boxR = new THREE.RectAreaLight(0xffffff, 0, 4, 5);
  rig.add(boxL, boxR);

  /* An overhead blade. Narrow, so it rakes rather than floods; this is the one
     that produces the highlight travelling across a surface as the product
     turns, and the one the doors phase uses for the finish demonstration. */
  const blade = new THREE.RectAreaLight(0xffffff, 0, 7, 0.24);
  rig.add(blade);

  /* --------------------------------------------------------- follow spots */

  /* Kept from pass one: a hot key just off axis, a tight rim behind, and a
     bounce underneath. The softboxes give the surfaces their shape; these give
     the subject its separation from the room. */
  /* NARROW, and that is the fix for the biggest fault in the light grade.
     At a 61-degree cone these threw a large soft circle onto whatever pale
     wall stood behind the subject, and a 0.8-albedo wall two metres from a
     gallery spot clips — measured at 18 to 28 per cent of frame across the
     whole windows phase. A gallery spot has a narrow beam precisely so it
     lights the object and not the room; these are 40 degrees now, with a
     shorter throw so the falloff has run out before the wall. */
  const heroKey = new THREE.SpotLight(0xffffff, 0, 13, Math.PI * 0.22, 0.9, 2);
  const heroRim = new THREE.SpotLight(linearColour(0xbfe6f5), 0, 13, Math.PI * 0.26, 0.9, 2);
  const heroFill = new THREE.PointLight(linearColour(0xa8cddd), 0, 24, 2);
  const heroTarget = new THREE.Object3D();
  scene.add(heroTarget);
  heroKey.target = heroTarget;
  heroRim.target = heroTarget;
  if (quality === 'high') {
    heroKey.castShadow = true;
    heroKey.shadow.mapSize.set(1024, 1024);
    heroKey.shadow.camera.near = 0.8;
    heroKey.shadow.camera.far = 30;
    heroKey.shadow.bias = -0.0012;
    heroKey.shadow.radius = 5;
  }
  rig.add(heroKey, heroRim, heroFill);

  scene.add(rig);

  /* The blended mood. Rather than switching setups — which shows as a jump —
     the choreography blends between named moods and the rig reads whatever the
     blend produced. */
  const mood = JSON.parse(JSON.stringify(MOODS.mark));
  const _v = new THREE.Vector3();
  const _c = new THREE.Color();

  const blendInto = (target, a, b, t) => {
    for (const box of ['boxL', 'boxR']) {
      target[box].w = lerp(a[box].w, b[box].w, t);
      target[box].h = lerp(a[box].h, b[box].h, t);
      target[box].i = lerp(a[box].i, b[box].i, t);
      target[box].colour = _c.setHex(a[box].colour).lerp(new THREE.Color(b[box].colour), t).getHex();
      for (let k = 0; k < 3; k++) target[box].at[k] = lerp(a[box].at[k], b[box].at[k], t);
    }
    target.blade.i = lerp(a.blade.i, b.blade.i, t);
    target.blade.y = lerp(a.blade.y, b.blade.y, t);
    target.blade.z = lerp(a.blade.z, b.blade.z, t);
    target.blade.colour = _c.setHex(a.blade.colour).lerp(new THREE.Color(b.blade.colour), t).getHex();
    for (const k of ['key', 'rim', 'accent', 'accent2', 'ambient']) {
      target[k] = lerp(a[k], b[k], t);
    }
  };

  return {
    rig, key, rim, bounce, accent, accent2, ambient,
    boxL, boxR, blade,
    heroKey, heroRim, heroFill, heroTarget,
    mood,

    /**
     * Blend the whole rig between two named moods.
     * `power` is a global trim, used to pull everything down when nothing is
     * centre stage or when the pricing phase needs the room to go quiet.
     */
    setMood(fromName, toName, t, power = 1) {
      blendInto(mood, MOODS[fromName], MOODS[toName], Math.min(1, Math.max(0, t)));
      key.intensity = mood.key * power;
      rim.intensity = mood.rim * power;
      accent.intensity = mood.accent * power;
      accent2.intensity = mood.accent2 * power;
      ambient.intensity = mood.ambient;
    },

    /**
     * Park the softboxes around a subject and aim them at it.
     *
     * `travel` slides the boxes along their own long axis. That is the
     * mechanism behind "a highlight travels across the surface": the object
     * does not have to move and neither does the camera — the reflection of a
     * moving source moves across a stationary curve.
     */
    placeBoxes(pos, cameraPos, travel = 0, power = 1) {
      // Build the boxes in a frame relative to the camera, so "camera-left"
      // stays camera-left however far the orbit has turned. A rig defined in
      // world space drifts round behind the subject and stops flattering it.
      _v.subVectors(cameraPos, pos);
      _v.y = 0;
      if (_v.lengthSq() < 0.0001) _v.set(0, 0, 1);
      _v.normalize();
      const right = new THREE.Vector3(-_v.z, 0, _v.x);

      const put = (light, cfg, side) => {
        light.width = cfg.w;
        light.height = cfg.h;
        light.color.copy(linearColour(cfg.colour));
        light.intensity = cfg.i * power;
        light.position.set(
          pos.x + right.x * cfg.at[0] * side + _v.x * cfg.at[2],
          pos.y + cfg.at[1] + travel * 0.9,
          pos.z + right.z * cfg.at[0] * side + _v.z * cfg.at[2]
        );
        light.lookAt(pos.x, pos.y, pos.z);
      };
      // `at[0]` already carries the sign in the mood table, so side is 1 for
      // both; keeping the argument makes a mirrored rig one edit away.
      put(boxL, mood.boxL, 1);
      put(boxR, mood.boxR, 1);

      blade.width = 7;
      blade.color.copy(linearColour(mood.blade.colour));
      blade.intensity = mood.blade.i * power;
      blade.position.set(
        pos.x + _v.x * mood.blade.z,
        pos.y + mood.blade.y,
        pos.z + _v.z * mood.blade.z
      );
      blade.lookAt(pos.x, pos.y, pos.z);
    },

    /**
     * Point the follow spots at a world position.
     * `power` fades the whole group out when nothing is centre stage.
     */
    aimHero(pos, power = 1, cameraDistance = 8) {
      heroTarget.position.copy(pos);

      /* Pull the key down as the subject approaches the lens. A frame two
         units from the camera under a key sized for eight units is simply
         white; a gaffer would flag the lamp, and this is that. */
      const close = Math.min(1, Math.max(0, (7.5 - cameraDistance) / 5.5));
      const trim = 1 - close * 0.34;

      /* A QUARTER OF WHAT THEY WERE.
         These numbers were tuned against a near-black room where the follow
         spots were the only thing making a product visible. In a lit gallery
         they are a gallery spot, not a floodlight: enough to lift the subject
         a stop above the room and cast a shadow on the floor, and no more.
         At the old values the casement rendered as a white cut-out. */
      heroKey.position.set(pos.x - 4.2, pos.y + 5.0, pos.z + 4.6);
      heroKey.intensity = 24 * power * trim;
      heroRim.position.set(pos.x + 5.0, pos.y + 2.2, pos.z - 5.2);
      heroRim.intensity = 9 * power * trim;
      heroFill.position.set(pos.x + 0.6, pos.y - 2.2, pos.z + 2.8);
      heroFill.intensity = 4 * power * trim;
    },
  };
}
