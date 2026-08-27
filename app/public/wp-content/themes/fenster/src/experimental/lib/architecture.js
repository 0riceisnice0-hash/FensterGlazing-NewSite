/**
 * THE GALLERY.
 *
 * Pass one put the products in a void, and the void was the single biggest
 * thing holding the look back: with nothing around them the eye had no scale,
 * no depth cue and nowhere to rest, so a 2.3m window read as a small object in
 * a large empty rectangle.
 *
 * This is the room. An impossible Fenster showroom — not a house, not a
 * realistic interior, but architecture: a floor that recedes, vertical fins,
 * portals to travel through, shadow gaps, and slabs fading into haze.
 *
 * IT IS A WHITE-BOX GALLERY, AND THE INVERSION IS THE WHOLE POINT.
 *
 * The first version of this file was dark, and it fought the product range the
 * entire way: almost everything here is specified in anthracite, and a dark
 * frame in a dark room is a silhouette. Pale walls fix that at the source. A
 * dark frame against a light ground separates on its own, with no rim light
 * doing rescue work, and every bevel and profile change reads as an actual
 * change in tone rather than as a bright line drawn round a black shape.
 *
 * The lighting vocabulary inverts with it. In a dark room you draw with light
 * — seams, strips, glowing edges. In a light room you draw with SHADOW: the
 * recessed gap, the reveal, the dark line where two planes meet. Almost every
 * `seam()` here is now a dark line, not a bright one, and the few genuinely
 * emissive ones are warm and restrained.
 *
 * Two layers:
 *
 *   FIXED    the floor, the walls, the fins. One coherent room, so the camera
 *            travelling through it feels like one place.
 *   SETS     a set piece per station — the mark's glass hall, the window's
 *            portal wall, the door's material bay, the pricing chamber.
 */
import * as THREE from 'three';
import { Reflector } from 'three/examples/jsm/objects/Reflector.js';
import { mergeGeometries } from 'three/examples/jsm/utils/BufferGeometryUtils.js';
import { BRAND, linearColour, glassRefracts } from './materials.js';

/** Where the floor is. Everything in the room is measured off this. */
export const FLOOR_Y = -2.6;

/* ------------------------------------------------------------------ floor */

/**
 * A large floor, receding into haze.
 *
 * Pale polished concrete: light, faintly warm, with a survey grid that fades
 * out with distance. The grid is the important part — parallel lines
 * converging are the strongest perspective cue available and they cost one
 * shader. On a light floor the grid lines are DARKER than the slab, which is
 * how a real scored floor looks and reads far cleaner than glowing lines.
 */
export function buildFloor(scene, quality, envMap) {
  /* A POLISHED FLOOR, NOT A PAINTED ONE.
   *
   * This was a ShaderMaterial: unlit, so it could never reflect anything, and
   * the room's whole lower half was a flat drawn surface. A showroom floor is
   * the second most reflective thing in the building after the glass, and it
   * is most of what makes one look expensive — the ceiling, the walls and the
   * lit products all come back up off it.
   *
   * So it is a MeshPhysicalMaterial with the studio environment on it and a
   * clearcoat over the top, and everything the old shader drew — the scored
   * module lines, the light pools under the ceiling panels, the green inlay,
   * the aggregate — is injected into its shader instead of replacing it. That
   * keeps every drawn detail and adds real reflections for one material swap.
   *
   * Roughness is deliberately not zero. A mirror floor is a swimming pool; a
   * polished concrete or resin floor has a slightly milky reflection, and the
   * clearcoat gives the sharp component on top of the diffuse one.
   */
  const geo = new THREE.PlaneGeometry(240, 240, 1, 1);
  const mat = new THREE.MeshPhysicalMaterial({
    color: linearColour(0xdcdad6),
    metalness: 0.0,
    roughness: quality === 'low' ? 0.55 : 0.14,
    envMap,
    envMapIntensity: quality === 'low' ? 0.4 : 1.25,
    clearcoat: quality === 'low' ? 0 : 1.0,
    clearcoatRoughness: 0.07,
  });

  const uniforms = {
    uHero: { value: new THREE.Vector3(0, 0, 0) },
    uHeroGlow: { value: 0 },
    uBayPitch: { value: 9 },
    uBayFrom: { value: 14 },
    uAccent: { value: linearColour(BRAND.accent) },
  };

  mat.onBeforeCompile = (shader) => {
    Object.assign(shader.uniforms, uniforms);
    shader.vertexShader = shader.vertexShader
      .replace('#include <common>', '#include <common>\nvarying vec3 vFloorPos;')
      .replace('#include <begin_vertex>',
        '#include <begin_vertex>\nvFloorPos = (modelMatrix * vec4(position, 1.0)).xyz;');

    shader.fragmentShader = shader.fragmentShader
      .replace('#include <common>', `#include <common>
        varying vec3 vFloorPos;
        uniform vec3 uHero, uAccent;
        uniform float uHeroGlow, uBayPitch, uBayFrom;
        float fHash(vec2 p) {
          p = fract(p * vec2(443.897, 441.423));
          p += dot(p, p + 19.19);
          return fract(p.x * p.y);
        }
        float fGrid(vec2 p, float spacing, float weight) {
          vec2 g = abs(fract(p / spacing - 0.5) - 0.5) / fwidth(p / spacing);
          return 1.0 - min(min(g.x, g.y) * weight, 1.0);
        }`)
      .replace('#include <color_fragment>', `#include <color_fragment>
        {
          float d = length(vFloorPos.xz);

          /* Aggregate. A polished slab is not one colour: it is a ground
             surface with fines in it, and at a glancing angle that scatter is
             most of what stops the reflection looking like a mirror. */
          float fines = fHash(floor(vFloorPos.xz * 90.0)) - 0.5;
          diffuseColor.rgb *= 1.0 + fines * 0.05;

          // Scored joints, both darker than the slab.
          float fine = fGrid(vFloorPos.xz, 1.0, 1.0) * (1.0 - smoothstep(4.0, 20.0, d));
          float coarse = fGrid(vFloorPos.xz, 6.0, 1.2) * (1.0 - smoothstep(14.0, 58.0, d));
          diffuseColor.rgb = mix(diffuseColor.rgb, diffuseColor.rgb * 0.74, fine * 0.16 + coarse * 0.34);

          // A pool of light under whatever is centre stage.
          float hd = length(vFloorPos.xz - uHero.xz);
          diffuseColor.rgb += vec3(0.05, 0.048, 0.042) * pow(max(0.0, 1.0 - hd / 7.5), 2.4) * uHeroGlow;

          // The rhythm of the ceiling panels, carried on the floor beneath.
          float band = abs(mod(vFloorPos.z - uBayFrom + uBayPitch * 0.5, uBayPitch) - uBayPitch * 0.5);
          diffuseColor.rgb += vec3(0.05, 0.048, 0.043)
            * (1.0 - smoothstep(0.0, uBayPitch * 0.45, band))
            * (1.0 - smoothstep(6.0, 58.0, d));

          // One Fenster-green inlay running the length of the room.
          float inlay = 1.0 - min(abs(vFloorPos.x + 9.0) / 0.075, 1.0);
          diffuseColor.rgb = mix(diffuseColor.rgb, uAccent, inlay * 0.6);
        }`)
      /* The joints are cut into the slab, so they are ROUGHER than the polish
         around them. Without this the reflection runs straight over a scored
         line as though it were painted on, which is the tell that a floor is a
         texture rather than a surface. */
      .replace('#include <roughnessmap_fragment>', `#include <roughnessmap_fragment>
        {
          float d2 = length(vFloorPos.xz);
          float j = fGrid(vFloorPos.xz, 1.0, 1.0) * (1.0 - smoothstep(4.0, 20.0, d2))
                  + fGrid(vFloorPos.xz, 6.0, 1.2) * (1.0 - smoothstep(14.0, 58.0, d2));
          roughnessFactor = clamp(roughnessFactor + j * 0.42
            + (fHash(floor(vFloorPos.xz * 60.0)) - 0.5) * 0.06, 0.02, 1.0);
        }`);
    mat.userData.shader = shader;
  };
  mat.customProgramCacheKey = () => 'fenster-floor';

  const floor = new THREE.Mesh(geo, mat);
  floor.rotation.x = -Math.PI / 2;
  floor.position.y = FLOOR_Y;
  floor.receiveShadow = quality === 'high';
  scene.add(floor);

  return {
    mesh: floor,
    y: FLOOR_Y,
    update(time, heroPos, glow) {
      if (heroPos) uniforms.uHero.value.copy(heroPos);
      uniforms.uHeroGlow.value = glow;
    },
    dispose() { geo.dispose(); mat.dispose(); },
  };
}

/* -------------------------------------------------------- contact shadow */

/**
 * A soft shadow under a product.
 *
 * On a pale floor this stops being a nicety and becomes the main thing
 * anchoring an object — the dark contact patch immediately under it is what
 * reads as weight. It MULTIPLIES into the floor rather than painting over it,
 * so the scored grid stays visible through the penumbra the way a real soft
 * shadow lets a floor's texture show through.
 */
export function buildContactShadow(parent, { width = 2.6, depth = 1.2, floorY = FLOOR_Y }) {
  const geo = new THREE.PlaneGeometry(width, depth);
  const mat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    // dst * (1 - src). A black source leaves the floor alone; a bright source
    // darkens it. This is a multiply, done with fixed-function blending.
    blending: THREE.CustomBlending,
    blendSrc: THREE.ZeroFactor,
    blendDst: THREE.OneMinusSrcColorFactor,
    uniforms: { uOpacity: { value: 0 }, uSharp: { value: 1.6 } },
    vertexShader: `
      varying vec2 vUv;
      void main() { vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }
    `,
    fragmentShader: `
      uniform float uOpacity, uSharp;
      varying vec2 vUv;
      void main() {
        vec2 p = (vUv - 0.5) * 2.0;
        float d = length(p * vec2(1.0, 1.35));
        /* Tight dark core, long soft skirt. A single gaussian reads as a grey
           oval; the two-term falloff reads as contact. */
        float core = pow(max(0.0, 1.0 - d), uSharp);
        float skirt = pow(max(0.0, 1.0 - d * 0.62), 3.2);
        gl_FragColor = vec4(vec3((core * 0.6 + skirt * 0.4) * uOpacity * 0.7), 1.0);
      }
    `,
  });
  const mesh = new THREE.Mesh(geo, mat);
  mesh.rotation.x = -Math.PI / 2;
  mesh.renderOrder = -2;
  parent.add(mesh);

  return {
    mesh,
    /** Park it under a world position, sized to how far it is off the floor. */
    set(worldPos, opacity, spread = 1) {
      mesh.position.set(worldPos.x, floorY + 0.006, worldPos.z);
      mesh.scale.set(spread, spread, 1);
      mat.uniforms.uOpacity.value = opacity;
      // A shadow gets softer and weaker the further the object is off the floor.
      const lift = Math.max(0, worldPos.y - floorY);
      mat.uniforms.uSharp.value = Math.max(0.6, 1.9 - lift * 0.22);
      mesh.visible = opacity > 0.005;
    },
    dispose() { geo.dispose(); mat.dispose(); },
  };
}

/* ------------------------------------------------------- structural forms */

/**
 * A wall with something on it.
 *
 * Flat untextured planes are what made every pale surface in this room land
 * within a few per cent of the same value and read as fog. This is a plaster
 * surface: a fine grain that breaks up the specular, and a shallow panel joint
 * on a regular module so the elevation has a scale to be read against. Both
 * are procedural in `onBeforeCompile` — no texture fetch, no asset, and the
 * module lines stay crisp at any distance because they are derivative-based.
 *
 * A showroom wall is never a flat colour. It is plaster, and plaster has tooth.
 */
export function wallMaterial(quality, colour, rough = 0.9) {
  const mat = new THREE.MeshStandardMaterial({
    color: linearColour(colour),
    metalness: 0.0,
    roughness: rough,
    side: THREE.FrontSide,
  });
  if (quality === 'low') return mat;

  mat.onBeforeCompile = (shader) => {
    shader.vertexShader = shader.vertexShader
      .replace('#include <common>', '#include <common>\nvarying vec3 vWallPos;')
      .replace('#include <begin_vertex>',
        '#include <begin_vertex>\nvWallPos = (modelMatrix * vec4(position, 1.0)).xyz;');

    shader.fragmentShader = shader.fragmentShader
      .replace('#include <common>', `#include <common>
        varying vec3 vWallPos;
        float wallHash(vec2 p) {
          p = fract(p * vec2(443.897, 441.423));
          p += dot(p, p + 19.19);
          return fract(p.x * p.y);
        }
        // A crisp line on a module, one pixel wide at any distance.
        float wallJoint(float v, float pitch) {
          float g = abs(fract(v / pitch - 0.5) - 0.5) / fwidth(v / pitch);
          return 1.0 - min(g * 1.4, 1.0);
        }`)
      .replace('#include <color_fragment>', `#include <color_fragment>
        {
          /* Plaster tooth. Fine, low amplitude, and it moves the ROUGHNESS as
             well as the colour — a surface whose specular breaks up is what
             reads as a real material, where a surface that only changes colour
             reads as a printed pattern. */
          float grain = wallHash(floor(vWallPos.xy * 190.0) + floor(vWallPos.zy * 190.0)) - 0.5;
          diffuseColor.rgb *= 1.0 + grain * 0.045;

          /* Panel joints on a 1.2m module vertically and a 2.4m module
             horizontally: a plasterboard-and-shadow-gap wall, which is what a
             gallery of this kind is actually built from. */
          float joint = max(wallJoint(vWallPos.y, 1.2), wallJoint(vWallPos.x + vWallPos.z, 2.4));
          diffuseColor.rgb *= 1.0 - joint * 0.10;
        }`);
    mat.userData.shader = shader;
  };
  // Distinguish the compiled program from the plain slab material's.
  mat.customProgramCacheKey = () => 'fenster-wall-' + rough.toFixed(2);
  return mat;
}

const slabMat = (quality, colour, rough = 0.85) => new THREE.MeshStandardMaterial({
  color: linearColour(colour),
  metalness: 0.0,
  roughness: rough,
  // Everything structural faces inward; the camera never gets outside the
  // room, and double-siding this much geometry is wasted fill.
  side: THREE.FrontSide,
});

/**
 * A line where two planes meet.
 *
 * In a light room this is a SHADOW GAP by default — a thin dark recess, which
 * is the detail that makes pale architecture read as built rather than as a
 * stack of untextured boxes. Pass `emissive` for the few places that genuinely
 * are a light fitting.
 */
/**
 * ONE MATERIAL PER KIND OF SEAM, not one per seam.
 *
 * Every shadow gap, datum line and slot light in this building is a `seam`, and
 * each used to make its own material. Measured on the doors route that came to
 * 208 seam meshes carrying 208 distinct materials — a third of the entire scene,
 * none of it able to batch with anything.
 *
 * What is lost is real and worth stating: the emissive strips were pulsed with
 * a per-seam phase offset, `sin(time * 0.22 + i * 1.7)`, and sharing a material
 * means they now breathe together. The amplitude is eight per cent of opacity
 * on a strip a few centimetres wide. Against a third of the draw calls, that is
 * not a close decision.
 *
 * Cleared per build, so a quality-tier switch never hands out a disposed
 * material.
 */
let SEAM_MATERIALS = new Map();

export function resetSeamMaterials() {
  SEAM_MATERIALS = new Map();
}

function seamMaterial(colour, intensity, emissive) {
  const key = `${colour}|${intensity}|${emissive ? 'e' : 'o'}`;
  let mat = SEAM_MATERIALS.get(key);
  if (!mat) {
    mat = emissive
      ? new THREE.MeshBasicMaterial({
        color: linearColour(colour).multiplyScalar(intensity),
        toneMapped: false, transparent: true, opacity: 0.88,
      })
      : new THREE.MeshBasicMaterial({
        color: linearColour(colour), transparent: true, opacity: 0.5 * intensity,
      });
    SEAM_MATERIALS.set(key, mat);
  }
  return mat;
}

function seam(parent, {
  w, h, x, y, z, ry = 0, rx = 0, colour = 0x3c4d53, intensity = 1, emissive = false,
}) {
  const mat = seamMaterial(colour, intensity, emissive);
  const m = new THREE.Mesh(new THREE.PlaneGeometry(w, h), mat);
  m.position.set(x, y, z);
  m.rotation.set(rx, ry, 0);
  /* Tagged, so `mergeStatic` can fold the ones that never change and leave the
     emissive ones alone — those are pulsed individually every frame. */
  m.userData.seam = true;
  m.userData.seamEmissive = emissive;
  m.userData.seamKey = `seam|${colour}|${intensity}`;
  parent.add(m);
  return { mesh: m, material: mat, emissive };
}

/**
 * The fixed shell: walls, ceiling, fins.
 *
 * Placed once, does not rotate. This is what makes the whole sequence read as
 * one enormous room rather than four unrelated backdrops.
 */
export function buildShell(scene, quality, rng) {
  const group = new THREE.Group();
  group.name = 'shell';
  const seams = [];

  /* Neutral, very slightly warm. The palette had drifted green-cyan across
     several rounds of tuning and the whole gallery read as faintly dirty
     rather than clean — the one adjective in the brief that is not
     negotiable. A gallery white is a warm white. */
  const wall = wallMaterial(quality, 0xe4e3e0, 0.94);
  const fin = wallMaterial(quality, 0xd9d8d5, 0.8);

  /* Two long side walls a good way out, so the room has edges without ever
     boxing the camera in. */
  for (const side of [-1, 1]) {
    const w = new THREE.Mesh(new THREE.PlaneGeometry(130, 26), wall);
    w.position.set(side * 22, 5, -14);
    w.rotation.y = side * -Math.PI / 2;
    w.receiveShadow = quality === 'high';
    group.add(w);

    /* Vertical fins along each wall. Receding verticals are the strongest
       architectural depth cue there is and they cost almost nothing — and on a
       pale wall each one throws its own soft shadow, which is what stops the
       wall reading as a flat card. */
    const count = quality === 'low' ? 8 : 18;
    for (let i = 0; i < count; i++) {
      const z = 12 - i * 6.5;
      const h = 11 + rng() * 7;
      const f = new THREE.Mesh(new THREE.BoxGeometry(0.5, h, 1.6), fin);
      f.position.set(side * 19.8, h / 2 - FLOOR_Y * -1 - 2.6 + 2.6, z);
      f.position.y = h / 2 + FLOOR_Y;
      f.castShadow = quality === 'high';
      f.receiveShadow = quality === 'high';
      group.add(f);

      // A shadow gap behind every third fin.
      if (i % 3 === 1) {
        seams.push(seam(group, {
          w: 0.16, h: h * 0.8, x: side * 19.0, y: h * 0.4 + FLOOR_Y, z: z - 1.0,
          ry: side * -Math.PI / 2, colour: 0x33454b, intensity: 0.95,
        }));
      }
    }
  }

  /* A ceiling plane, high and pale, with diffusing panels let into it. */
  const ceiling = new THREE.Mesh(new THREE.PlaneGeometry(120, 100), slabMat(quality, 0xeceae7, 0.96));
  ceiling.rotation.x = Math.PI / 2;
  ceiling.position.set(0, 13.5, -16);
  group.add(ceiling);

  /* DOWNSTAND BEAMS.
     The ceiling was a single flat plane with light strips let into it, and the
     upper third of most frames was consequently empty. A run of beams across
     the route gives the ceiling a structure, throws the strips into coffers
     between them, and gives the eye a rhythm overhead to match the colonnade's
     rhythm at the sides. Twelve boxes; the cost is nothing. */
  const beamMat = slabMat(quality, 0xdcdbd8, 0.9);
  if (quality !== 'low') {
    for (let i = 0; i < 12; i++) {
      const z = 16 - i * 4.5;
      const beam = new THREE.Mesh(new THREE.BoxGeometry(46, 1.15, 0.75), beamMat);
      beam.position.set(0, 12.85, z);
      beam.castShadow = quality === 'high';
      group.add(beam);
      // The shadow gap where each beam meets the soffit.
      seams.push(seam(group, {
        w: 46, h: 0.05, x: 0, y: 13.44, z: z + 0.4,
        rx: Math.PI / 2, colour: 0x8d9fa4, intensity: 1,
      }));
    }
  }

  const strips = quality === 'low' ? 4 : 9;
  for (let i = 0; i < strips; i++) {
    const z = 14 - i * 9;
    /* Genuinely emissive: these are the gallery's own lights and they are
       meant to be seen. Warm white, and deliberately NOT hot enough to bloom —
       a light fitting that flares is a lamp, and this is a ceiling. */
    seams.push(seam(group, {
      w: 26, h: 1.1, x: 0, y: 13.3, z,
      rx: Math.PI / 2, colour: 0xfffaf2, intensity: 1.04, emissive: true,
    }));
    // The recess they sit in.
    seams.push(seam(group, {
      w: 27.6, h: 0.14, x: 0, y: 13.36, z: z - 0.72,
      rx: Math.PI / 2, colour: 0x8d9fa4, intensity: 1,
    }));
  }

  /* THE FAR END: a vista rather than a wall.
     Its whole job is to be the thing the gallery recedes toward — a screen of
     tall glazed bays reads as somewhere the building continues to, which is a
     much better end to a room than a blank plane.
     *
     * FAR_Z, not the -52 this was pinned at. The line above this used to read
     * "the camera never reaches it", and when the route ended around -40 that
     * was true. Doubling the experience carried the route out to -88 and left
     * a 64m x 28m plane standing across the middle of it at station three: the
     * camera closed to 2.3m of it, so it filled the entire frame as one flat
     * lit surface, and then passed straight through it.
     *
     * That is the frame the sweep flagged at t=0.800 — mean 0.778, spread
     * collapsed to 0.28 against ~0.75 everywhere else. It read as an empty
     * corridor in the metrics and it was the opposite: a wall pressed against
     * the lens. Worth remembering that a flat-frame signature says nothing
     * about whether the cause is too little in shot or far too much. */
  const FAR_Z = -118;   // clear of the chamber, which now reaches about -111
  const endWall = new THREE.Mesh(new THREE.PlaneGeometry(64, 28), wall);
  endWall.position.set(0, 7, FAR_Z);
  group.add(endWall);
  for (let i = -3; i <= 3; i++) {
    seams.push(seam(group, {
      w: 2.1, h: 11.5, x: i * 3.6, y: 3.4, z: FAR_Z + 0.2,
      colour: 0xffffff, intensity: 1.02 - Math.abs(i) * 0.06, emissive: true,
    }));
    // the mullion between each bay
    seams.push(seam(group, {
      w: 0.16, h: 11.5, x: i * 3.6 + 1.8, y: 3.4, z: FAR_Z + 0.3,
      colour: 0x8a9ca2, intensity: 1,
    }));
  }
  // A transfer beam across the head of the glazed screen.
  const transfer = new THREE.Mesh(new THREE.BoxGeometry(28, 0.9, 0.6), wall);
  transfer.position.set(0, 9.4, FAR_Z + 0.4);
  group.add(transfer);

  scene.add(group);
  return {
    group,
    seams,
    update(time) {
      /* The emissive panels breathe very slightly and out of phase, so the
         room is never completely static even when nothing is moving. The dark
         shadow gaps hold still — a moving shadow would be wrong. */
      for (let i = 0; i < seams.length; i++) {
        if (!seams[i].emissive) continue;
        seams[i].material.opacity = 0.82 + 0.08 * Math.sin(time * 0.22 + i * 1.7);
      }
    },
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      wall.dispose(); fin.dispose(); beamMat.dispose();
      seams.forEach((s) => s.material.dispose());
    },
  };
}

/* ----------------------------------------------------------- the portal */

/**
 * A monumental architectural opening, with the casement installed in it.
 *
 * It gives the product a reason to be where it is, gives the camera something
 * to move behind and pass through, and frames the shot. Built from slabs
 * around a hole rather than as a CSG cut, because the hole never needs to be
 * anything but a rectangle and a few boxes cost nothing.
 *
 * `width` and `height` are the OPENING, and the choreography sizes them from
 * the casement's own measured bounding box — a window standing in a hole
 * plainly too big for it is the tell that neither was built for the other.
 */
/**
 * A wall with TWO openings, sharing a head datum.
 *
 * The window is installed in one; the other is a door-height void the camera
 * travels through. That second opening is not decoration — it is the fix for a
 * real fault.
 *
 * WHY: the pass-through beat used to aim the camera straight at the installed
 * casement and fly through it. A dense frame sweep measured mean luminance
 * dropping to 0.177 against a run median of 0.60 across that stretch, because
 * the camera ended up 0.68 metres from a closed 2.35m window and the frame was
 * entirely dark frame and dark glazing. It was also nonsense: you cannot walk
 * through a shut window.
 *
 * Dodging the camera around the wall would have fixed the collision and lost
 * the move. A second opening fixes both at once, and it is what the wall
 * should always have been: a single hole in a slab reads as a card with a
 * rectangle cut in it, whereas a window and a doorway sharing a head height is
 * how an elevation is actually composed.
 *
 * AN EARLIER VERSION OF THIS COMMENT ALSO CLAIMED THE SECOND OPENING BUYS
 * FOREGROUND OCCLUSION — the camera passing the installed window in the near
 * foreground on its way through the doorway. It does not, and the claim was
 * measured and refuted: that occlusion peaks at 7.15% of frame at t = 0.540
 * and is entirely gone by t = 0.558. Nor is it deliverable by spacing —
 * holding the casement's frame edge in shot until the camera reaches the wall
 * face would put the camera inside the window opening itself. Two openings in
 * one plane cannot give parallax occlusion at this field of view; that has to
 * come from something standing off the wall.
 *
 * The window also sits on a CILL now rather than on the floor. A casement
 * whose bottom rail runs into the slab is the detail that most gave away that
 * this was geometry in a void rather than a building.
 */
export const PORTAL_SILL = 0.62;

export function buildPortal(parent, quality, { width = 2.2, height = 2.6, depth = 1.1 }) {
  const group = new THREE.Group();
  group.name = 'portal';

  /* A DEEPER STONE THAN THE GALLERY, AND THAT IS AN EXPOSURE DECISION.
   *
   * The subject is installed IN this wall, so any light that models the window
   * necessarily lands on the wall around it — that is not a bug, it is what
   * happens on a real shoot, and the photographer's answer is to flag the lamp.
   * There is no flag available here: a RectAreaLight casts no shadow, and
   * three.js cannot light one object without lighting another (see below).
   *
   * So the wall gets the headroom instead. At 0xdfdedb the pier beside the
   * softbox measured 39% of its area clipped; a fifth off the albedo brings
   * that under 1% while the gallery around it stays white. It also gives the
   * elevation more presence — a feature wall in a deeper stone, read against
   * the pale room, which is a better composition than white-on-white anyway.
   *
   * WHAT DOES NOT WORK, TESTED: light layers. It is natural to assume that
   * `light.layers.set(1)` plus `mesh.layers.enable(1)` on the products would
   * let the rig light the products and spare the architecture. It does not.
   * three.js tests a light's layers against the CAMERA, not against each
   * object, so all that happens is the lamp is dropped from the render
   * entirely. Measured: wall 0.756 with the lamp, 0.510 with layers set, and
   * 0.756 again the moment the camera was also put on layer 1 — which is the
   * signature of the light being collected or not, not of it being filtered.
   */
  const mat = slabMat(quality, 0xcac9c5, 0.92);
  /* The reveal is a shade DARKER, not lighter. In a bright room the inside
     faces of an opening are in shadow — that is exactly how wall thickness
     reads, and getting it the wrong way round makes the wall look like paper. */
  const reveal = slabMat(quality, 0xa9a7a3, 0.84);

  /* THE DATUM.
     Both openings finish at the same height. Aligning heads is the oldest
     move in elevational composition and it is the single thing that makes two
     holes in a wall read as designed rather than as punched where convenient. */
  const HEAD = PORTAL_SILL + height;
  const DOOR_W = 1.52;
  const PIER = 1.05;          // the pier between the two openings
  const WING = 2.2;           // the outer piers
  const TOP = HEAD + 1.75;    // wall height above the datum

  const doorX = width / 2 + PIER + DOOR_W / 2;
  const leftEdge = -(width / 2 + WING);
  const rightEdge = doorX + DOOR_W / 2 + WING;

  const slab = (w, h, d, x, y, z, m = mat) => {
    const sl = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), m);
    sl.position.set(x, y, z);
    sl.castShadow = quality === 'high';
    sl.receiveShadow = quality === 'high';
    group.add(sl);
    return sl;
  };

  // outer piers
  slab(WING, TOP, depth, leftEdge + WING / 2, TOP / 2, 0);
  slab(WING, TOP, depth, rightEdge - WING / 2, TOP / 2, 0);
  // the pier between the two openings
  slab(PIER, TOP, depth, width / 2 + PIER / 2, TOP / 2, 0);
  // the cill upstand under the window, and the panel over it
  slab(width, PORTAL_SILL, depth, 0, PORTAL_SILL / 2, 0);
  slab(width, TOP - HEAD, depth, 0, HEAD + (TOP - HEAD) / 2, 0);
  // the panel over the doorway
  slab(DOOR_W, TOP - HEAD, depth, doorX, HEAD + (TOP - HEAD) / 2, 0);

  /* Reveals. Every face of both openings, a shade darker than the wall. */
  const rv = (w, h, x, y) => slab(w, h, depth * 0.94, x, y, 0, reveal);
  rv(0.1, height, -width / 2 + 0.05, PORTAL_SILL + height / 2);
  rv(0.1, height, width / 2 - 0.05, PORTAL_SILL + height / 2);
  rv(width, 0.1, 0, HEAD - 0.05);
  rv(width, 0.1, 0, PORTAL_SILL + 0.05);                       // the cill face
  rv(0.1, HEAD, doorX - DOOR_W / 2 + 0.05, HEAD / 2);
  rv(0.1, HEAD, doorX + DOOR_W / 2 - 0.05, HEAD / 2);
  rv(DOOR_W, 0.1, doorX, HEAD - 0.05);

  /* Shadow gaps: the dark line where the wall meets each reveal, and the outer
     arrises of the piers. This is the whole vocabulary of a light room — you
     draw with the shadow, not with a highlight. */
  const gaps = [];
  const gz = depth / 2 + 0.006;
  const gap = (w, h, x, y, colour = 0x46585e) =>
    gaps.push(seam(group, { w, h, x, y, z: gz, colour }));

  gap(0.055, height + 0.11, -width / 2 - 0.028, PORTAL_SILL + height / 2);
  gap(0.055, height + 0.11, width / 2 + 0.028, PORTAL_SILL + height / 2);
  gap(width + 0.11, 0.055, 0, HEAD + 0.028);
  gap(width + 0.11, 0.055, 0, PORTAL_SILL - 0.028);
  gap(0.055, HEAD + 0.06, doorX - DOOR_W / 2 - 0.028, HEAD / 2);
  gap(0.055, HEAD + 0.06, doorX + DOOR_W / 2 + 0.028, HEAD / 2);
  gap(DOOR_W + 0.11, 0.055, doorX, HEAD + 0.028);
  gap(0.05, TOP, leftEdge - 0.02, TOP / 2, 0x51636a);
  gap(0.05, TOP, rightEdge + 0.02, TOP / 2, 0x51636a);
  // A datum line scored across the whole wall at head height. One horizontal
  // that ties the two openings together and gives the elevation a reading.
  gap(rightEdge - leftEdge, 0.03, (leftEdge + rightEdge) / 2, HEAD + 0.12, 0x64767c);

  /* PLACEHOLDER-NOTHING: the portal's slot lights follow. */
  /* Slot lights let into both heads, washing down the inside of each opening.
     The only genuinely emissive things in the set. */
  const wash = seam(group, {
    w: width * 0.88, h: 0.06, x: 0, y: HEAD - 0.085, z: depth * 0.22,
    rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.3, emissive: true,
  });
  const doorWash = seam(group, {
    w: DOOR_W * 0.86, h: 0.06, x: doorX, y: HEAD - 0.085, z: depth * 0.22,
    rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.15, emissive: true,
  });

  parent.add(group);
  return {
    group, wash, doorWash,
    width, height,
    sill: PORTAL_SILL,
    head: HEAD,
    doorX, doorW: DOOR_W, doorH: HEAD,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      mat.dispose(); reveal.dispose();
      wash.material.dispose(); doorWash.material.dispose();
      gaps.forEach((g) => g.material.dispose());
    },
  };
}

/* --------------------------------------------------------- material bay */

/**
 * The doors set: a plinth and a pair of flanking blades.
 *
 * The brief asks the doors phase to read as a premium material laboratory. A
 * door standing on a low plinth between two vertical blades, lit from a narrow
 * slot above, is that — and the blades give the moving finish light something
 * to reflect off either side of the slab.
 */
export function buildMaterialBay(parent, quality) {
  const group = new THREE.Group();
  group.name = 'materialBay';

  const stone = slabMat(quality, 0xcccbc7, 0.9);
  /* PALE PIERS, NOT DARK BLADES — and this is the second time the negative
     fill had to be walked back.
     The idea was sound: a dark card gives a lacquered slab something to
     reflect, without which it has no contrast in its specular. The execution
     was not. A near-black blade five metres from the lens took most of the
     right-hand third of frame, and the doors phase rendered as a lit door
     between two enormous black slabs — a lighting flag photographed by
     accident. Shrinking it only made a smaller black slab.
     The negative fill now lives ENTIRELY in the environment map, where a
     reflection source belongs and where it costs no pixels at all. What is
     left here is architecture: two slim pale piers framing the bay, which is
     what the composition actually needed. */
  const blade = slabMat(quality, 0xd5d4d0, 0.72);

  const plinth = new THREE.Mesh(new THREE.BoxGeometry(4.8, 0.34, 2.6), stone);
  plinth.position.set(0, FLOOR_Y + 0.17, 0);
  plinth.receiveShadow = quality === 'high';
  plinth.castShadow = quality === 'high';
  group.add(plinth);

  // A shadow gap under the plinth, so it reads as standing on the floor rather
  // than being part of it.
  seam(group, {
    w: 4.86, h: 0.07, x: 0, y: FLOOR_Y + 0.004, z: 0,
    rx: -Math.PI / 2, colour: 0x2b3a40, intensity: 1.5,
  });

  for (const side of [-1, 1]) {
    const b = new THREE.Mesh(new THREE.BoxGeometry(0.34, 7.2, 0.9), blade);
    b.position.set(side * 3.9, FLOOR_Y + 3.6, -1.1);
    b.castShadow = quality === 'high';
    b.receiveShadow = quality === 'high';
    group.add(b);
    // The shadow gap where each pier meets the backdrop.
    seam(group, {
      w: 0.05, h: 7.2, x: side * (3.9 + 0.19), y: FLOOR_Y + 3.6, z: -1.1,
      ry: side * Math.PI / 2, colour: 0x4a5c62, intensity: 1.1,
    });
  }

  /* A BACKDROP WALL WITH A DOORWAY IN IT.
   *
   * Two faults, one fix.
   *
   * First: the bay originally stood directly in front of the open mouth of the
   * pricing chamber, which is the one dark volume in the building, so the
   * doors phase played out as a lit door floating in a black rectangle —
   * handsome, and completely at odds with every other beat. It needed a wall.
   *
   * Then the wall became the second fault: a solid plane 4.6 metres behind the
   * door is 1.5 metres in FRONT of the camera by the end of the sequence, so
   * the terminal — the thing the whole timeline is travelling toward — was
   * being occluded by scenery at the exact moment it arrived.
   *
   * So it is a wall with an opening, which is what the choreography always
   * described anyway: the door swings, there is a dark room beyond it, and the
   * camera goes through. The opening is the chamber's own pale surround, and
   * the camera passes through it on the last beat.
   */
  const OPENING_W = 5.6;
  const OPENING_H = 4.9;
  const bz = -4.6;
  const wing = (34 - OPENING_W) / 2;
  const panel = (w, h, x, y) => {
    const m = new THREE.Mesh(new THREE.PlaneGeometry(w, h), stone);
    m.position.set(x, y, bz);
    m.receiveShadow = quality === 'high';
    group.add(m);
  };
  panel(wing, 16, -(OPENING_W / 2 + wing / 2), FLOOR_Y + 8);
  panel(wing, 16, (OPENING_W / 2 + wing / 2), FLOOR_Y + 8);
  panel(OPENING_W, 16 - OPENING_H, 0, FLOOR_Y + OPENING_H + (16 - OPENING_H) / 2);

  // Shadow gaps: the base of the wall, and the reveal around the doorway.
  seam(group, {
    w: 34, h: 0.09, x: 0, y: FLOOR_Y + 0.045, z: bz + 0.05, colour: 0x3d4f55, intensity: 1.2,
  });
  seam(group, {
    w: 0.06, h: OPENING_H, x: -OPENING_W / 2, y: FLOOR_Y + OPENING_H / 2, z: bz + 0.05, colour: 0x46585e,
  });
  seam(group, {
    w: 0.06, h: OPENING_H, x: OPENING_W / 2, y: FLOOR_Y + OPENING_H / 2, z: bz + 0.05, colour: 0x46585e,
  });
  seam(group, {
    w: OPENING_W, h: 0.06, x: 0, y: FLOOR_Y + OPENING_H, z: bz + 0.05, colour: 0x46585e,
  });

  /* TWO DISPLAY BAYS FLANKING THE DOORWAY.
   *
   * The colonnade down the sides of the route only reads while the camera is
   * TRAVELLING; measured at the doors station, not one of its ten products was
   * inside the frame, because a stopped camera looks down the room and the
   * bays are ninety degrees off that axis. So the doors phase had a whole
   * backdrop wall and nothing on it.
   *
   * These are recessed into that wall either side of the doorway, at the width
   * the camera actually frames from the plinth. They put two more real
   * products into the shot the visitor spends longest looking at, and they
   * make the "09 door systems" claim visible instead of merely written on the
   * floor.
   */
  const wallBays = [];
  const BW = 2.25, BH = 3.0, BD = 0.55;
  for (const side of [-1, 1]) {
    /* 4.0, not 4.6. Measured from the plinth, the left bay at 4.6 fell outside
       the frame entirely while the right one sat at ndc 0.37 — the camera pans
       right through this beat, so a symmetric pair is not symmetric on screen.
       Narrower bays let both sit inside the frame without fouling the doorway
       reveal at x = 2.8. */
    const bx = side * 4.0;
    const back = new THREE.Mesh(new THREE.PlaneGeometry(BW, BH), blade);
    back.position.set(bx, FLOOR_Y + BH / 2, bz - BD);
    back.receiveShadow = quality === 'high';
    group.add(back);

    for (const end of [-1, 1]) {
      const ret = new THREE.Mesh(new THREE.PlaneGeometry(BD, BH), stone);
      ret.position.set(bx + end * BW / 2, FLOOR_Y + BH / 2, bz - BD / 2);
      ret.rotation.y = end < 0 ? Math.PI / 2 : -Math.PI / 2;
      group.add(ret);
    }
    const soff = new THREE.Mesh(new THREE.PlaneGeometry(BW, BD), stone);
    soff.position.set(bx, FLOOR_Y + BH, bz - BD / 2);
    soff.rotation.x = Math.PI / 2;
    group.add(soff);

    // Slot light in the soffit, and a shadow gap round the opening.
    seam(group, {
      w: BW * 0.82, h: 0.05, x: bx, y: FLOOR_Y + BH - 0.04, z: bz - BD * 0.5,
      rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.3, emissive: true,
    });
    seam(group, { w: 0.05, h: BH, x: bx - BW / 2, y: FLOOR_Y + BH / 2, z: bz + 0.05, colour: 0x46585e });
    seam(group, { w: 0.05, h: BH, x: bx + BW / 2, y: FLOOR_Y + BH / 2, z: bz + 0.05, colour: 0x46585e });
    seam(group, { w: BW + 0.1, h: 0.05, x: bx, y: FLOOR_Y + BH, z: bz + 0.05, colour: 0x46585e });

    wallBays.push({ x: bx, z: bz - BD * 0.45, rotationY: side * -0.16 });
  }

  // The slot light above the plinth — the raking source for the finish moment.
  const slot = seam(group, {
    w: 3.0, h: 0.1, x: 0, y: FLOOR_Y + 6.4, z: 0.5,
    rx: Math.PI / 2, colour: 0xfff4e6, intensity: 1.45, emissive: true,
  });

  parent.add(group);
  return {
    group, slot, wallBays,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      stone.dispose(); blade.dispose(); slot.material.dispose();
    },
  };
}

/* ------------------------------------------------------ pricing chamber */

/**
 * The pricing set: a recessed chamber with the terminal at the far end.
 *
 * The brief wants the reveal to be a distant rectangle that resolves into the
 * terminal. In a light gallery the terminal cannot be the brightest thing in
 * frame, so the chamber inverts instead: it is the one DARK volume in the
 * building, and the terminal is the lit rectangle at the end of it. Walking
 * out of a bright room into a dark one toward a screen is a far stronger
 * arrival than another pale box, and it puts the interface on the only
 * background it will ever be comfortable to read against.
 */
export function buildChamber(parent, quality) {
  const group = new THREE.Group();
  group.name = 'chamber';
  /* Genuinely dark. At 0x33434a the chamber measured as a mid grey-green and
     the terminal — the brightest object in the sequence — sat only a shade
     above it, so the arrival had no contrast in it at all. The whole point of
     this volume is to be the one dark room in a light building. */
  /* Lifted from 0x1e2a30. The chamber is meant to be the one dark volume in
     the building, not a void: at the old value the approach to it measured a
     mean of 0.077 with a tonal spread of 0.32, which is a black frame, not a
     dark room. It still reads as far darker than anything else here. */
  const mat = slabMat(quality, 0x2b3940, 0.94);
  const lip = slabMat(quality, 0xdfdedb, 0.9);

  const W = 11, H = 8, D = 17;
  const face = (w, h, x, y, z, rx = 0, ry = 0, m = mat) => {
    const me = new THREE.Mesh(new THREE.PlaneGeometry(w, h), m);
    me.position.set(x, y, z);
    me.rotation.set(rx, ry, 0);
    group.add(me);
  };
  face(W, D, 0, FLOOR_Y + 0.05, -D / 2, -Math.PI / 2);
  face(W, D, 0, FLOOR_Y + H, -D / 2, Math.PI / 2);
  face(D, H, -W / 2, FLOOR_Y + H / 2, -D / 2, 0, Math.PI / 2);
  face(D, H, W / 2, FLOOR_Y + H / 2, -D / 2, 0, -Math.PI / 2);
  /* THE BACK. It was missing, and it was an 11 x 8 metre hole.
     `buildChamber` made a floor, a ceiling and two sides and stopped, so the
     one dark volume in the building was open at its far end — and the shell's
     emissive end-wall aperture, twenty-five metres further on, shone straight
     through it behind the terminal. Measured at t = 0.93: the pale rectangle
     behind the terminal spanned px 475-1150 and the opening projects to
     445-1155; the brighter band inside it spanned 750-880 against the
     aperture's 737-863. Two triangles fix it. */
  face(W, H, 0, FLOOR_Y + H / 2, -D, 0, 0);

  /* A pale surround at the mouth, so the dark volume reads as an opening cut
     into the bright gallery rather than as the room simply going dark. */
  /* The material bay's backdrop wall is the surround you actually see from
     outside; this sits just behind it and closes the gap, so there is no seam
     of daylight where the two meet. */
  const surroundW = 20;
  for (const side of [-1, 1]) {
    const p = new THREE.Mesh(new THREE.BoxGeometry(surroundW, H + 9, 0.9), lip);
    p.position.set(side * (W / 2 + surroundW / 2), FLOOR_Y + H / 2, 0.45);
    group.add(p);
  }
  const head = new THREE.Mesh(new THREE.BoxGeometry(W + surroundW * 2, 7.5, 0.9), lip);
  head.position.set(0, FLOOR_Y + H + 3.75, 0.45);
  group.add(head);

  // Recessed light lines running the length of the chamber, converging on the
  // terminal. They are the perspective that makes the approach feel long.
  const rails = [];
  for (const side of [-1, 1]) {
    for (const y of [FLOOR_Y + 0.4, FLOOR_Y + H - 0.5]) {
      const s = seam(group, {
        w: D * 0.92, h: 0.05, x: side * (W / 2 - 0.14), y, z: -D / 2,
        ry: side * -Math.PI / 2, colour: 0x8fe6c0, intensity: 1.0, emissive: true,
      });
      s.material.opacity = 0.55;
      rails.push(s);
    }
  }

  parent.add(group);
  return {
    group, rails,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      mat.dispose(); lip.dispose();
      rails.forEach((r) => r.material.dispose());
    },
  };
}

/* --------------------------------------------------------- glass hall */

/**
 * The opening set: sheets of glass standing in the room around the mark.
 *
 * Upright, near-tangent, at varied depths — closer to a curtain-walling mock-up
 * than to floating debris. In a bright gallery these read as a faint green edge
 * and a surface reflection, which is exactly what real glass looks like
 * standing in a white room.
 */
export function buildGlassHall(parent, envMap, quality, rng) {
  const group = new THREE.Group();
  group.name = 'glassHall';

  const glass = new THREE.MeshPhysicalMaterial({
    /* Nearly colourless. The first light-room version carried the dark
       version's tint and attenuation straight over, and against a pale
       background that came out as solid teal panels — the tint that had been
       invisible over black was the brightest thing in the frame over white.
       Real float glass standing in a white room is almost entirely its
       reflections and a faint green edge, so the body is white and the colour
       is left to the edge lines. */
    color: linearColour(0xffffff),
    metalness: 0,
    roughness: 0.03,
    transmission: glassRefracts(quality) ? 1 : 0,
    thickness: 0.02,
    ior: 1.5,
    envMap,
    envMapIntensity: 1.1,
    transparent: true,
    opacity: quality === 'high' ? 1 : 0.1,
    depthWrite: false,
    side: THREE.DoubleSide,
    clearcoat: 1,
    clearcoatRoughness: 0.02,
    attenuationColor: linearColour(0xeaf7f1),
    attenuationDistance: 6,
  });

  // The green edge of a cut pane. This is now where all of the glass's
  // colour lives, which is also where it lives in reality.
  const edgeMat = new THREE.LineBasicMaterial({
    color: linearColour(0x3f8f7a), transparent: true, opacity: 0.42, depthWrite: false,
  });

  const count = { high: 12, medium: 8, low: 4 }[quality];
  const panes = [];
  for (let i = 0; i < count; i++) {
    const w = 1.5 + rng() * 1.6;
    const h = 3.4 + rng() * 3.6;
    const geo = new THREE.BoxGeometry(w, h, 0.02);
    const pane = new THREE.Mesh(geo, glass);

    /* PLACED IN CARTESIAN, WITH A KEEP-OUT, BECAUSE THE POLAR VERSION PUT THEM
       EXACTLY WHERE IT CLAIMED TO KEEP THEM AWAY FROM.
       *
       * It read: radius 9-18, angle biased to +/-PI/2, "out to the sides and
       * never entered". But sin(+/-PI/2) is +/-1 and cos(+/-PI/2) is 0, so
       * biasing the angle to the poles put every pane on x ~ 0 at z = +/-9 to
       * 18 — which is not beside the route, it IS the route. One 1.8 x 5.7m
       * sheet of glass ended up at (-0.3, -16.9), and the camera passed 6cm
       * from it. The comment described the intent and the maths did the
       * opposite, which is the kind of thing that survives review precisely
       * because the comment sounds right.
       *
       * The camera is a straight line down x = 0 now, so the keep-out can be
       * stated once and enforced rather than hoped for. */
    const CORRIDOR = 5.6;              // clear of the colonnade fins at +/-4.3
    const side = rng() < 0.5 ? -1 : 1;
    const x = side * (CORRIDOR + rng() * 7.5);
    const z = 9 - rng() * 30;          // dressing the opening and the first run
    // Standing on the floor, not floating. That single change is most of why
    // these read as architecture rather than as debris.
    pane.position.set(x, FLOOR_Y + h / 2, z);
    /* Turned roughly to face the route, so they catch the light across their
       faces rather than presenting an edge and vanishing. */
    pane.rotation.y = -side * (Math.PI * 0.5) + (rng() - 0.5) * 0.9;
    pane.renderOrder = 1;
    group.add(pane);

    pane.add(new THREE.LineSegments(new THREE.EdgesGeometry(geo), edgeMat));
    pane.userData = { phase: rng() * Math.PI * 2, sway: 0.0006 + rng() * 0.0012 };
    panes.push(pane);
  }

  parent.add(group);
  return {
    group, panes,
    update(time, opacity = 1) {
      for (const p of panes) {
        // A millimetre of sway. Present, never visible as animation.
        p.rotation.z = Math.sin(time * 0.19 + p.userData.phase) * p.userData.sway * 6;
      }
      glass.opacity = (quality === 'high' ? 1 : 0.16) * opacity;
      edgeMat.opacity = 0.3 * opacity;
      group.visible = opacity > 0.02;
    },
    dispose() {
      panes.forEach((p) => p.geometry.dispose());
      glass.dispose(); edgeMat.dispose();
    },
  };
}

/* ------------------------------------------------------------ colonnade */

/**
 * THE GALLERY SPINE: a colonnade of product bays down both sides of the route.
 *
 * This replaces the orbit, and the orbit had to go for two reasons.
 *
 * It was a leftover from the first concept, where the world rotated around a
 * fixed camera. Once the camera started travelling the length of a building,
 * a ring of products revolving around the origin stopped meaning anything —
 * and it showed. Products drifted half in and half out of frame at the edges
 * of shots, cropped at odd angles, sitting at no particular height, belonging
 * to nothing. They read exactly as what they were: models parked in mid-air.
 *
 * Installed in the architecture they read as a showroom instead. Each product
 * stands in its own recess with a head, two returns, a slot light and a
 * threshold strip on the floor in front of it, angled a little toward the
 * approaching camera so it is presented rather than passed edge-on.
 *
 * That also answers "add more to the scenery" with the same geometry: a
 * colonnade IS the scenery. Twenty-two piers and ten lit bays give the route
 * a rhythm, somewhere for shadows to fall, and a reason for the eye to keep
 * looking sideways as it travels.
 *
 * Returns anchors rather than placing anything itself, so the choreography
 * decides which product goes where.
 */
export function buildColonnade(parent, quality, rng, { span = 7.6, from = 3, to = -27, count = 10 } = {}) {
  const group = new THREE.Group();
  group.name = 'colonnade';

  const pierMat = wallMaterial(quality, 0xe2e1de, 0.9);
  // The back of a bay is deeper in tone: it is in shadow, and a product needs
  // something a shade darker behind it to separate against.
  const bayMat = slabMat(quality, 0xb9b8b4, 0.94);
  const soffitMat = slabMat(quality, 0xd0cfcb, 0.92);

  const BAY_W = 3.0;      // clear width of a recess
  const BAY_H = 3.2;      // clear height
  const BAY_D = 1.3;      // how far it is recessed
  const PIER_W = 1.5;
  const TOP = 6.4;        // height of the whole colonnade wall

  const bays = [];
  const seams = [];
  const pitch = (from - to) / count;

  for (const side of [-1, 1]) {
    const x = side * span;
    // Offset one side by half a pitch, so the two colonnades interleave rather
    // than lining up like a corridor of doorways. A staggered rhythm reads as
    // designed; a matched pair reads as a tunnel.
    const stagger = side < 0 ? 0 : pitch * 0.5;

    for (let i = 0; i < count; i++) {
      const z = from - i * pitch - stagger;

      /* the pier between this bay and the next */
      const pier = new THREE.Mesh(new THREE.BoxGeometry(BAY_D + 0.5, TOP, PIER_W), pierMat);
      pier.position.set(x + side * 0.25, FLOOR_Y + TOP / 2, z + pitch / 2);
      pier.castShadow = quality === 'high';
      pier.receiveShadow = quality === 'high';
      group.add(pier);

      /* the recess: a back panel, two returns and a soffit */
      const back = new THREE.Mesh(new THREE.PlaneGeometry(BAY_W, BAY_H), bayMat);
      back.position.set(x + side * BAY_D, FLOOR_Y + BAY_H / 2, z);
      back.rotation.y = side < 0 ? Math.PI / 2 : -Math.PI / 2;
      back.receiveShadow = quality === 'high';
      group.add(back);

      if (quality !== 'low') {
        for (const end of [-1, 1]) {
          const ret = new THREE.Mesh(new THREE.PlaneGeometry(BAY_D, BAY_H), soffitMat);
          ret.position.set(x + side * BAY_D / 2, FLOOR_Y + BAY_H / 2, z + end * BAY_W / 2);
          ret.rotation.y = end < 0 ? 0 : Math.PI;
          group.add(ret);
        }
        const soffit = new THREE.Mesh(new THREE.PlaneGeometry(BAY_W, BAY_D), soffitMat);
        soffit.position.set(x + side * BAY_D / 2, FLOOR_Y + BAY_H, z);
        soffit.rotation.x = Math.PI / 2;
        group.add(soffit);
      }

      /* the slot light in the soffit — this is what makes a bay read as a
         display case rather than as a dent in a wall */
      seam(group, {
        w: BAY_W * 0.8, h: 0.06,
        x: x + side * (BAY_D * 0.55), y: FLOOR_Y + BAY_H - 0.05, z,
        rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.25, emissive: true,
      });

      /* a threshold strip on the floor in front of the opening */
      seam(group, {
        w: BAY_W, h: 0.07,
        x: x + side * 0.06, y: FLOOR_Y + 0.008, z,
        rx: -Math.PI / 2, ry: side < 0 ? Math.PI / 2 : -Math.PI / 2,
        colour: 0x4a5c62, intensity: 1.3,
      });

      /* Angled a little toward the approaching camera, which comes from +Z.
         Facing dead across the route means every product is seen edge-on at
         the moment it is closest. */
      bays.push({
        x: x + side * (BAY_D * 0.45),
        z,
        side,
        rotationY: side < 0 ? Math.PI / 2 - 0.42 : -Math.PI / 2 + 0.42,
      });
    }

    /* A PLINTH COURSE along the base of the colonnade.
       Everything in this room was landing within a few per cent of the same
       tone — pale piers against a pale wall against a pale floor — and the
       result measured as well exposed while reading as fog. A darker band at
       low level is the oldest fix in architecture: it gives the elevation a
       horizontal to read against, grounds the piers so they stop looking like
       they are hovering, and puts a real dark value back in the bottom of the
       frame without making anything dim. */
    const plinth = new THREE.Mesh(
      new THREE.BoxGeometry(BAY_D + 1.0, 0.62, Math.abs(from - to) + 4),
      slabMat(quality, 0x7d8a8e, 0.86)
    );
    plinth.position.set(x + side * 0.38, FLOOR_Y + 0.31, (from + to) / 2);
    plinth.receiveShadow = quality === 'high';
    group.add(plinth);
    seams.push(seam(group, {
      w: Math.abs(from - to) + 4, h: 0.05,
      x: x - side * 0.5, y: FLOOR_Y + 0.63, z: (from + to) / 2,
      ry: side < 0 ? -Math.PI / 2 : Math.PI / 2,
      colour: 0x3f5157, intensity: 1.3,
    }));

    /* A continuous band above the bays: the underside of a mezzanine. It caps
       the colonnade, stops the piers reading as free-standing fins, and gives
       the room an upper storey without modelling one. */
    const band = new THREE.Mesh(new THREE.BoxGeometry(BAY_D + 0.9, 1.5, Math.abs(from - to) + 4), pierMat);
    band.position.set(x + side * 0.35, FLOOR_Y + TOP + 0.75, (from + to) / 2);
    band.castShadow = quality === 'high';
    group.add(band);

    seam(group, {
      w: Math.abs(from - to) + 4, h: 0.07,
      x: x - side * 0.42, y: FLOOR_Y + TOP - 0.03, z: (from + to) / 2,
      ry: side < 0 ? -Math.PI / 2 : Math.PI / 2,
      colour: 0x3f5157, intensity: 1.2,
    });
  }

  parent.add(group);
  return {
    group,
    bays,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      pierMat.dispose(); bayMat.dispose(); soffitMat.dispose();
      seams.forEach((sm) => sm.material.dispose());
    },
  };
}

/* ------------------------------------------------------------- the V wall */

/**
 * TWO WALLS ANGLED TOWARD THE CAMERA WITH A GAP BETWEEN THEM.
 *
 * This replaces the flat wall-with-two-holes, and it replaces it everywhere —
 * the previous layout was one set piece repeated six times down the route,
 * which is the opposite of a designed building. Six identical elevations in a
 * row read as a corridor in a video game.
 *
 * A splayed pair does four things a flat wall cannot:
 *
 *   - **Two products are in shot at once**, angled, so the visitor sees a
 *     range rather than a sequence of single objects.
 *   - **The angle catches light differently on each side**, which is the whole
 *     reason a showroom splays its display walls rather than lining them up.
 *   - **There is a real gap to travel through.** The camera route is the gap,
 *     so it can never clip a wall — the old layout had the camera threading a
 *     1.5m doorway and grazing jambs.
 *   - **It is not symmetrical in shot.** Approaching off-axis, one wall is
 *     near and raking, the other far and flatter. Every arrival is a different
 *     composition even though the geometry repeats.
 *
 * `splay` is the angle each wall turns toward the camera; `gap` is the clear
 * width between their inner edges, which is the camera's route and must stay
 * comfortably wider than the camera's near plane sweep.
 */
export function buildVWall(parent, quality, {
  /* PER SIDE, because the two products of a pair are not the same size and a
     hole that fits one of them cannot fit the other.
     *
     * What was here before took a single `opening` and used it for both leaves.
     * Worse, atrium.js computed that one opening from `sample.height * 0.82 +
     * 0.16` where `sample.height` is the NORMALISATION TARGET - literally 2.35
     * for every model in the building - so the expression collapsed to the
     * constant 2.087 x 2.49 and every hole in the gallery was identical.
     *
     * Measured against the real bounding boxes, six of the eight station
     * products were WIDER than the hole they stood in: the casement and the
     * flush sash by 524mm, which buried 262mm of frame in solid wall on each
     * jamb. That is the "casement is overlapping with frame" fault, and it was
     * visible in a screenshot long before anyone measured it. The two doors
     * have the opposite problem - a 1.135m composite in a 2.087m hole, half a
     * metre of bare void each side - which is the "frames are too big" fault.
     * One bug, two symptoms that look like opposites. */
  openings = [{ width: 2.1, height: 2.5 }, { width: 2.1, height: 2.5 }],
  /* Distance from the gap edge to the product CENTRE, shared by both leaves.
     The openings differ in width, so the piers either side of them have to
     differ too - otherwise the pair sits off-centre and the frame is lopsided.
     Holding the centres and varying the pier is the way round that keeps the
     composition symmetric while giving each product its own hole. */
  centre = 1.9,
  sill = 0.62,
  splay = 0.42,
  gap = 1.6,
  wingOuter = 3.4,
  depth = 0.85,
  minPier = 0.3,
} = {}) {
  const group = new THREE.Group();
  group.name = 'vWall';

  const mat = wallMaterial(quality, 0xcfcecb, 0.9);
  const reveal = slabMat(quality, 0xa9a7a3, 0.84);

  /* A window stands on the lining that caps its cill; a door goes to the
     ground. Before this, the 90mm bottom lining was drawn across the opening
     at BOTH kinds of station and the product's foot was set on the structural
     line underneath it - so every product in the building had its bottom 90mm
     buried in a bar, and at the door stations that bar lay across the
     threshold with both doors' bottom rails inside it. */
  const foot = sill > 0.3 ? 0.09 : 0;

  const headOf = (op) => sill + foot + op.height;
  const TOP = Math.max(headOf(openings[0]), headOf(openings[1])) + 1.9;
  const HEAD = headOf(openings[0]);

  const slots = [];

  for (const side of [-1, 1]) {
    const op = openings[side < 0 ? 0 : 1];
    const head = headOf(op);
    const innerPier = Math.max(minPier, centre - op.width / 2);

    const leaf = new THREE.Group();
    /* Hinged about its inner edge, which sits on the gap. Rotating about the
       panel's own centre would swing the gap open and closed with the splay
       and make the two numbers fight each other. */
    leaf.position.set(side * gap / 2, 0, 0);
    leaf.rotation.y = -side * splay;
    group.add(leaf);

    // x within the leaf, measured out from the gap edge
    const xOpen = innerPier + op.width / 2;
    const xInner = innerPier / 2;
    const xOuter = innerPier + op.width + wingOuter / 2;
    const panelW = innerPier + op.width + wingOuter;

    const slab = (w, h, d, x, y, m = mat) => {
      const b = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), m);
      b.position.set(side * x, y, 0);
      b.castShadow = quality === 'high';
      b.receiveShadow = quality === 'high';
      leaf.add(b);
      return b;
    };

    /* The `y` argument, which both of these were missing.
       `slab(w, h, d, x, y)` defaults nothing, so y arrived as undefined,
       position.set() wrote NaN, and a mesh with a NaN world matrix is simply
       not drawn - no warning, no error, nothing in the console. Four meshes
       per station, sixteen in all: the narrow pier beside the gap and the
       broad wing outboard of every opening. Every V wall in the building has
       been standing here as a pair of floating reveals with no wall around
       them. Found by sweeping the route for camera clearance and noticing the
       probe was skipping sixteen bounding boxes it could not evaluate. */
    slab(innerPier, TOP, depth, xInner, TOP / 2);
    slab(wingOuter, TOP, depth, xOuter, TOP / 2);
    if (sill + foot > 0.01) slab(op.width, sill + foot, depth, xOpen, (sill + foot) / 2);
    slab(op.width, TOP - head, depth, xOpen, head + (TOP - head) / 2);

    // reveals: two jambs and a head. No bar across the foot - see `foot`.
    const rv = (w, h, x, y) => slab(w, h, depth * 0.94, x, y, reveal);
    rv(0.09, op.height, xOpen - op.width / 2 + 0.045, sill + foot + op.height / 2);
    rv(0.09, op.height, xOpen + op.width / 2 - 0.045, sill + foot + op.height / 2);
    rv(op.width, 0.09, xOpen, head - 0.045);
    if (foot > 0) rv(op.width, foot, xOpen, sill + foot / 2);

    /* Shadow gaps: round the opening, up the inner arris facing the gap, and a
       datum scored across the whole leaf at head height. In a light room the
       drawing is done with shadow, not with highlight. */
    const gz = depth / 2 + 0.006;
    const gapSeam = (w, h, x, y, colour = 0x46585e) => seam(leaf, {
      w, h, x: side * x, y, z: gz, colour,
    });
    gapSeam(0.05, op.height + 0.1, xOpen - op.width / 2 - 0.025, sill + foot + op.height / 2);
    gapSeam(0.05, op.height + 0.1, xOpen + op.width / 2 + 0.025, sill + foot + op.height / 2);
    gapSeam(op.width + 0.1, 0.05, xOpen, head + 0.025);
    if (sill + foot > 0.01) gapSeam(op.width + 0.1, 0.05, xOpen, sill + foot - 0.025);
    gapSeam(panelW, 0.028, panelW / 2, head + 0.14, 0x64767c);
    gapSeam(0.05, TOP, 0.02, TOP / 2, 0x51636a);

    // A slot light in the head, washing down the reveal.
    seam(leaf, {
      w: op.width * 0.86, h: 0.055, x: side * xOpen, y: head - 0.08, z: depth * 0.2,
      rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.25, emissive: true,
    });

    /* A low bench running along the base of each leaf - but only where there
       is a cill above it. A bench under a window is what a showroom has; a
       bench across a doorway is an obstruction, and at the two door stations
       it was running straight through the bottom half of both doors. */
    if (sill > 0.3) {
      const bench = new THREE.Mesh(
        new THREE.BoxGeometry(panelW - 0.4, 0.42, 0.7),
        /* Pale stone, not a dark slab. At 0x7d8a8e these read as black boxes
           hovering over a bright reflective floor - the one dark object in the
           lower half of every frame, and the eye went straight to them instead
           of to the product above. A showroom bench is pale stone. */
        slabMat(quality, 0xc6c4c0, 0.72)
      );
      bench.position.set(side * (panelW / 2), 0.21, depth / 2 + 0.35);
      bench.castShadow = quality === 'high';
      bench.receiveShadow = quality === 'high';
      leaf.add(bench);
    }

    slots.push({
      side, sill, opening: op, innerPier,
      /* Where the product's FOOT goes, measured off the wall base. The caller
         used to work this out from `sill` alone and stood every product on the
         structural line, underneath the lining. */
      footY: sill + foot,
      x: 0, z: 0, rotationY: -side * splay, xOpen,
    });
  }

  /* Recompute each slot properly through the leaf transform rather than by
     hand: the rotation is about the leaf origin, so the product's world offset
     is the rotated local offset. */
  group.updateMatrixWorld(true);
  slots.forEach((slot, i) => {
    const leaf = group.children[i];
    const local = new THREE.Vector3(slot.side * slot.xOpen, 0, 0);
    leaf.localToWorld(local);
    group.worldToLocal(local);
    slot.x = local.x;
    slot.z = local.z;
  });

  parent.add(group);
  return {
    group, slots, head: HEAD, sill, gap,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      mat.dispose(); reveal.dispose();
    },
  };
}

/* ------------------------------------------------------- floor reflection */

/**
 * A real planar reflection, laid over the polished floor.
 *
 * The floor already carries the environment map, which gives it a wet sheen —
 * but an environment map only reflects the generated studio, never the scene.
 * In a showroom the thing you actually notice in the floor is the PRODUCT
 * standing on it, and no amount of envMapIntensity will put it there.
 *
 * So this is a second plane a few millimetres above the floor, rendering the
 * scene from a mirrored camera. Two departures from the stock `Reflector`:
 *
 *   - **Fresnel-weighted.** Stock Reflector composites at a flat strength,
 *     which gives a floor that is equally mirrored underfoot and at the far
 *     end — a swimming pool. A real polished slab reflects almost nothing when
 *     you look straight down at it and a great deal at a glancing angle, so
 *     the alpha is driven by the view angle.
 *   - **Blurred with distance.** The reflection is softened as it recedes,
 *     which stands in for the roughness of the surface. A perfectly sharp
 *     reflection reads as glass, not as polished concrete.
 *
 * It costs one extra render of the scene per frame, which is why it is gated
 * to the high tier and is the first thing the performance governor drops.
 */
export function buildFloorMirror(scene, renderer, quality) {
  if (quality !== 'high') return null;

  const size = renderer.getSize(new THREE.Vector2());
  const mirror = new Reflector(new THREE.PlaneGeometry(150, 150), {
    // Deliberately under-resolved. The reflection is blurred and heavily
    // attenuated, so a full-resolution target would be spending memory
    // bandwidth on detail the fresnel throws away.
    textureWidth: Math.min(1024, Math.round(size.x * 0.5)),
    textureHeight: Math.min(1024, Math.round(size.y * 0.5)),
    color: 0xffffff,
  });

  const mat = mirror.material;
  mat.transparent = true;
  mat.depthWrite = false;

  mat.fragmentShader = `
    uniform vec3 color;
    uniform sampler2D tDiffuse;
    varying vec4 vUv;
    varying vec3 vWorldPos;

    float blurWeight(int i) { return 1.0 - abs(float(i)) / 4.0; }

    void main() {
      vec2 uv = vUv.xy / vUv.w;

      /* Blur along the reflected ray, widening with distance. Cheap: five taps
         vertically in screen space, which is the direction a floor reflection
         actually smears. */
      float spread = clamp(length(vWorldPos.xz) * 0.0016, 0.0006, 0.011);
      vec3 acc = vec3(0.0);
      float wsum = 0.0;
      for (int i = -2; i <= 2; i++) {
        float w = blurWeight(i);
        acc += texture2DProj(tDiffuse, vec4(uv + vec2(0.0, float(i) * spread), vUv.zw)).rgb * w;
        wsum += w;
      }
      vec3 refl = acc / wsum;

      /* Fresnel. Almost nothing straight down, a great deal at a grazing
         angle — which is what makes a polished floor read as polished rather
         than as a mirror lying on the ground. */
      vec3 viewDir = normalize(cameraPosition - vWorldPos);
      float f = pow(1.0 - clamp(viewDir.y, 0.0, 1.0), 3.4);

      // And it fades out with distance, where the haze takes over anyway.
      float far = 1.0 - smoothstep(18.0, 52.0, length(vWorldPos.xz - cameraPosition.xz));

      gl_FragColor = vec4(refl * color, f * far * 0.5);
      #include <tonemapping_fragment>
      #include <colorspace_fragment>
    }
  `;
  mat.vertexShader = mat.vertexShader
    .replace('varying vec4 vUv;', 'varying vec4 vUv;\nvarying vec3 vWorldPos;')
    .replace('#include <project_vertex>', '#include <project_vertex>\nvWorldPos = (modelMatrix * vec4(position, 1.0)).xyz;');
  mat.needsUpdate = true;

  mirror.rotation.x = -Math.PI / 2;
  mirror.position.y = FLOOR_Y + 0.004;
  mirror.renderOrder = -1;
  scene.add(mirror);

  return {
    mirror,
    setEnabled(on) { mirror.visible = on; },
    dispose() {
      mirror.geometry.dispose();
      mirror.material.dispose();
      mirror.getRenderTarget?.().dispose?.();
    },
  };
}

/* ---------------------------------------------------------- the screen */

/**
 * A GLAZED SCREEN ACROSS THE ROUTE, WITH THE BIFOLD IN IT.
 *
 * The bifold used to be blocked in camera space and swept across the lens.
 * Technically it worked and it was, in the owner's word, random: every other
 * product in this building is installed in a wall at a station, and then a set
 * of doors would fly past the camera from nowhere, belonging to nothing,
 * demonstrating nothing except that it could move.
 *
 * This gives it the one reason a bifold exists. It is a screen standing across
 * the gallery — the whole width of the route glazed, the way a bifold actually
 * gets specified — and it folds open to let the visitor through. You approach
 * it shut, it concertinas, and you walk through the opening it just made.
 *
 * That is the product demonstrating its own purpose rather than performing a
 * transition, it keeps the camera on its straight line, and it turns the one
 * arbitrary moment in the sequence into the most motivated one: it is the
 * only thing in the building that has to move before you can carry on.
 */
export function buildScreen(parent, quality, { width = 5.6, height = 2.5, depth = 0.5 }) {
  const group = new THREE.Group();
  group.name = 'screen';

  const mat = wallMaterial(quality, 0xd7d6d3, 0.9);
  const reveal = slabMat(quality, 0xb2b0ac, 0.84);

  const TOP = height + 2.6;
  const WING = 9;

  const slab = (w, h, d, x, y, m = mat) => {
    const b = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), m);
    b.position.set(x, y, 0);
    b.castShadow = quality === 'high';
    b.receiveShadow = quality === 'high';
    group.add(b);
    return b;
  };

  // piers either side, and the head over the opening
  slab(WING, TOP, depth, -(width / 2 + WING / 2), TOP / 2);
  slab(WING, TOP, depth, (width / 2 + WING / 2), TOP / 2);
  slab(width, TOP - height, depth, 0, height + (TOP - height) / 2);

  // reveals
  slab(0.09, height, depth * 0.94, -width / 2 + 0.045, height / 2, reveal);
  slab(0.09, height, depth * 0.94, width / 2 - 0.045, height / 2, reveal);
  slab(width, 0.09, depth * 0.94, 0, height - 0.045, reveal);

  /* Shadow gaps round the opening and a datum across the screen. In a light
     room the drawing is done with shadow, not with highlight. */
  const gz = depth / 2 + 0.006;
  const gaps = [];
  const gap = (w, h, x, y, colour = 0x46585e) =>
    gaps.push(seam(group, { w, h, x, y, z: gz, colour }));
  gap(0.05, height + 0.1, -width / 2 - 0.025, height / 2);
  gap(0.05, height + 0.1, width / 2 + 0.025, height / 2);
  gap(width + 0.1, 0.05, 0, height + 0.025);
  gap(width + 2 * WING, 0.03, 0, height + 0.16, 0x64767c);

  /* The track the bifold runs on, let into the floor across the opening. It is
     a small thing and it is most of what makes the doors read as INSTALLED
     rather than as standing there. */
  gaps.push(seam(group, {
    w: width + 0.4, h: 0.05, x: 0, y: 0.006, z: depth * 0.1,
    rx: -Math.PI / 2, colour: 0x3b4d53, intensity: 1.4,
  }));

  // A slot light in the head, washing down over the doors.
  const wash = seam(group, {
    w: width * 0.9, h: 0.06, x: 0, y: height - 0.08, z: depth * 0.2,
    rx: Math.PI / 2, colour: 0xfff6ea, intensity: 1.3, emissive: true,
  });

  parent.add(group);
  return {
    group, wash, width, height,
    dispose() {
      group.traverse((n) => { if (n.isMesh) n.geometry.dispose(); });
      mat.dispose(); reveal.dispose(); wash.material.dispose();
      gaps.forEach((g) => g.material.dispose());
    },
  };
}

/* ------------------------------------------------------- static merging */

/**
 * FOLD A GROUP'S UNCHANGING GEOMETRY INTO ONE MESH PER MATERIAL.
 *
 * This is the same lesson the models taught, applied to the building. Once the
 * WindowCAD exports were reprocessed the products stopped being the expensive
 * thing and the ARCHITECTURE became it: measured on the doors route, the
 * colonnade alone was 344 meshes — more than all seven products together — and
 * the whole scene was issuing 1,315 draw calls at 13fps with barely a megabyte
 * of geometry loaded. Bytes were never the problem. Draw calls were.
 *
 * A colonnade bay is a pier, a back panel, two returns and a soffit, repeated
 * forty-eight times across three materials. None of it ever moves. There is no
 * reason for the renderer to be told about it 288 separate times.
 *
 * WHAT IS DELIBERATELY LEFT ALONE:
 *   - anything tagged `userData.seamEmissive`, because those strips are pulsed
 *     individually every frame and merging them would freeze the room;
 *   - anything with a name, so a caller can still find a part it needs;
 *   - anything under a node that is animated or repositioned later.
 * The caller decides what is safe by choosing what to pass in — products and
 * the hero stage never go through here.
 *
 * Geometries are baked into the group's local space, so the group can still be
 * moved as a whole afterwards.
 */
export function mergeStatic(group, { keepNamed = true } = {}) {
  const buckets = new Map();
  const doomed = [];

  group.updateMatrixWorld(true);
  const groupInverse = new THREE.Matrix4().copy(group.matrixWorld).invert();

  group.traverse((n) => {
    if (!n.isMesh || !n.geometry) return;
    /* Emissive seams used to be excluded here, because each was pulsed
       individually. They share a material now, so the pulse is applied to the
       material rather than the mesh and merging their geometry changes
       nothing about it. */
    if (keepNamed && n.name) return;                  // someone may look it up
    if (n.userData.noMerge) return;

    const m = Array.isArray(n.material) ? null : n.material;
    if (!m) return;

    /* Keyed by the MATERIAL, not by the mesh. Two bays' piers share one
       material instance, so they land in the same bucket and become one
       draw call. */
    if (!buckets.has(m)) buckets.set(m, []);
    buckets.get(m).push(n);
  });

  let before = 0;
  let after = 0;

  for (const [material, meshes] of buckets) {
    before += meshes.length;
    if (meshes.length < 2) { after += meshes.length; continue; }

    const geometries = [];
    for (const mesh of meshes) {
      const g = mesh.geometry.clone();
      /* Into the group's space: world matrix, then back out of the group's own
         transform, so moving the group afterwards still works. */
      g.applyMatrix4(new THREE.Matrix4().multiplyMatrices(groupInverse, mesh.matrixWorld));
      /* mergeGeometries refuses a set whose attributes differ, and a plane has
         no groups while a box does. Normalising both to position/normal/uv is
         what lets a pier and a back panel share a bucket. */
      for (const key of Object.keys(g.attributes)) {
        if (!['position', 'normal', 'uv'].includes(key)) g.deleteAttribute(key);
      }
      if (!g.attributes.uv && g.attributes.position) {
        g.setAttribute('uv', new THREE.BufferAttribute(
          new Float32Array((g.attributes.position.count) * 2), 2
        ));
      }
      g.clearGroups();
      geometries.push(g);
    }

    let merged = null;
    try {
      merged = mergeGeometries(geometries, false);
    } catch (e) {
      merged = null;
    }
    if (!merged) {
      /* Never silently drop geometry. If a bucket will not merge, leave it as
         it was and say so — a room that is missing a wall is a worse outcome
         than a room that is a few draw calls heavier. */
      geometries.forEach((g) => g.dispose());
      after += meshes.length;
      console.warn('[atrium] a static bucket would not merge; left as-is', meshes.length);
      continue;
    }

    const mesh = new THREE.Mesh(merged, material);
    mesh.castShadow = meshes[0].castShadow;
    mesh.receiveShadow = meshes[0].receiveShadow;
    mesh.userData.merged = meshes.length;
    group.add(mesh);
    after += 1;

    geometries.forEach((g) => g.dispose());
    meshes.forEach((m2) => doomed.push(m2));
  }

  for (const m of doomed) {
    m.geometry.dispose();
    m.removeFromParent();
  }

  return { before, after };
}
