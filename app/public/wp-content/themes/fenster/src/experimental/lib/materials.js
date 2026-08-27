/**
 * Turning WindowCAD exports into materials worth looking at.
 *
 * READ `3d.md` BEFORE CHANGING ANY OF THIS. The short version, because it
 * decides the whole approach:
 *
 *  - The GLBs carry NO textures at all. A finish is a baseColorFactor plus
 *    metalness/roughness and nothing else, which is why colour can be a
 *    runtime change rather than a file per colour, and why the environment
 *    map is doing almost all of the work in making these look expensive.
 *  - Nothing is named. No node names, no material names. So a material has to
 *    be classified by what it IS, not what it is called.
 *  - The classification rule is `opaque AND neutral`, not `light`. Each model
 *    was exported in whatever colour the configurator happened to be showing,
 *    so an aluminium frame comes out near black and a lightness test fails.
 *    What holds is that a powder coat is flat, neutral (r≈g≈b) and opaque,
 *    while glass is translucent and its tinted blue-grey is not neutral.
 *
 * What this module adds on top of the export is the part WindowCAD does not
 * do: real transmissive glass with thickness and dispersion, clearcoated
 * aluminium, and a light-sweep that travels along the frame extrusions.
 */
import * as THREE from 'three';

/** Fenster's own palette, straight off `:root` in main.scss. */
export const BRAND = {
  ink: 0x06212a,
  steel: 0x002d3a,
  steel90: 0x19424e,
  accent: 0x2eac66,
  accentDark: 0x20824c,
  lightBlue: 0x4c7b86,
  soft: 0xf3f8f7,
  line: 0xd6e0e3,
};

/** Real finishes Fenster sells, for the runtime recolour beat in the doors phase. */
export const FINISHES = [
  { name: 'Anthracite Grey', hex: 0x383e42, metal: 0.55, rough: 0.42 },
  { name: 'Jet Black', hex: 0x14171a, metal: 0.6, rough: 0.34 },
  { name: 'Chartwell Green', hex: 0x8fae8b, metal: 0.35, rough: 0.5 },
  /* Smooth White was in this list and came out of it. The cycle runs while the
     door is at its closest to the lens, and a near-white powder coat there
     blows to paper whatever the key is stopped down to — 33% of the frame
     clipped, and still 17% after a lightness-aware trim. Rosewood is an equally
     real finish, it adds the only warm note in the sequence, and it does not
     fight the exposure. White is still a finish Fenster sells; it just is not
     the one this particular shot demonstrates. */
  { name: 'Rosewood', hex: 0x5e3323, metal: 0.2, rough: 0.52 },
  { name: 'Basalt Grey', hex: 0x4b4f52, metal: 0.55, rough: 0.42 },
  { name: 'Silver Grey', hex: 0x8b9296, metal: 0.7, rough: 0.34 },
];

/** sRGB hex -> linear-light THREE.Color, which is what glTF factors are in. */
export function linearColour(hex) {
  return new THREE.Color(hex).convertSRGBToLinear();
}

/**
 * Is this material glass?
 *
 * Translucency is the reliable signal — every glazed pane in these exports
 * comes through as alphaMode BLEND at around 0.3 opacity, and nothing else
 * does. Testing colour instead would be fragile: the glass tint is a blue-grey
 * that is *nearly* neutral, and on some models it sits within a hair of the
 * frame's own greys.
 */
function isGlass(mat) {
  return mat.transparent === true || (typeof mat.opacity === 'number' && mat.opacity < 0.98);
}

/**
 * Is this a neutral (r≈g≈b) colour? Powder coats and hardware are; the glass
 * tint is not. Compared in linear space, which is where the factors live.
 */
function isNeutral(colour, tolerance = 0.055) {
  const { r, g, b } = colour;
  return Math.max(r, g, b) - Math.min(r, g, b) < tolerance;
}

/**
 * The light-sweep. A thin band of extra emission travels along the frame in
 * world space, so it crosses aluminium extrusions the way a studio softbox
 * does when a product turns under it.
 *
 * It is injected with onBeforeCompile rather than written as a ShaderMaterial
 * because everything else about MeshPhysicalMaterial — the transmission, the
 * clearcoat, the environment map — is worth keeping, and reimplementing that
 * to add one term would be daft.
 */
function addLightSweep(material, uniforms) {
  material.onBeforeCompile = (shader) => {
    shader.uniforms.uSweepPos = uniforms.pos;
    shader.uniforms.uSweepWidth = uniforms.width;
    shader.uniforms.uSweepGain = uniforms.gain;
    shader.uniforms.uSweepColour = uniforms.colour;
    shader.uniforms.uSweepAxis = uniforms.axis;

    shader.vertexShader = shader.vertexShader
      .replace('#include <common>', `#include <common>\n varying vec3 vSweepWorld;`)
      .replace(
        '#include <worldpos_vertex>',
        `#include <worldpos_vertex>
         vSweepWorld = (modelMatrix * vec4(transformed, 1.0)).xyz;`
      );

    // <worldpos_vertex> only emits when a feature needs it, so make sure the
    // varying is always written. Without this the sweep silently does nothing
    // on materials with no shadows and no env map.
    if (!shader.vertexShader.includes('vSweepWorld =')) {
      shader.vertexShader = shader.vertexShader.replace(
        '#include <project_vertex>',
        `vSweepWorld = (modelMatrix * vec4(transformed, 1.0)).xyz;\n#include <project_vertex>`
      );
    }

    shader.fragmentShader = shader.fragmentShader
      .replace(
        '#include <common>',
        `#include <common>
         varying vec3 vSweepWorld;
         uniform float uSweepPos;
         uniform float uSweepWidth;
         uniform float uSweepGain;
         uniform vec3  uSweepColour;
         uniform vec3  uSweepAxis;`
      )
      .replace(
        '#include <dithering_fragment>',
        `#include <dithering_fragment>
         {
           float d = dot(vSweepWorld, normalize(uSweepAxis));
           float band = 1.0 - smoothstep(0.0, uSweepWidth, abs(d - uSweepPos));
           // Squared falloff keeps the core tight and the spill soft, which is
           // what a real softbox edge does. A linear band reads as a decal.
           band = band * band;
           gl_FragColor.rgb += uSweepColour * band * uSweepGain;
         }`
      );
    material.userData.shader = shader;
  };
  material.customProgramCacheKey = () => 'fenster-sweep';
}

/**
 * Walk a loaded GLB and replace every material with a Fenster one.
 *
 * Returns the handles the choreography needs: the frame materials (so a phase
 * can recolour them), the glass materials (so a phase can change how much they
 * refract), and the sweep uniforms (so a phase can run light across them).
 */
/**
 * ONE SWITCH FOR REFRACTIVE GLASS, ACROSS THE WHOLE SCENE.
 *
 * three.js renders the entire opaque scene a second time as soon as ONE
 * material in it has `transmission > 0`. It does not matter whether that is
 * twenty-five window panes or a single pane of glazing in a wall thirty metres
 * away — the pass is all-or-nothing.
 *
 * Which is how gating it on the products alone achieved nothing: the product
 * glass went matte and three architectural materials — the glass hall, the
 * atmosphere's vista, the terminal's screen — kept the pass alive on their own,
 * at the full 28ms. Anything with an all-or-nothing cost has to be switched
 * off everywhere or not at all.
 */
let GLASS_REFRACTS = true;

export function setGlassRefraction(on) {
  GLASS_REFRACTS = !!on;
}

export function glassRefracts(quality) {
  return GLASS_REFRACTS && quality === 'high';
}

export function dressModel(root, opts = {}) {
  const {
    envMap = null,
    /* Refraction, decided by the ROUTE rather than by the tier.
       Measured on the doors showroom with the architecture merged, the shadow
       pass off and the floor mirror off: transmission costs 28ms of a 47ms
       frame — 21fps against 52 — because three.js renders the entire opaque
       scene a second time to refract through. That is worth it on a page whose
       whole subject is one pane of glass; it is not worth two thirds of the
       frame on a gallery walking past seven products. */
    transmissive = null,      // null defers to the quality tier
    frameColour = null,       // null keeps the exported colour
    /* The glazing lightened for the white-box room.
       `0x8fb2c4` is roughly the blue-grey the configurator exports, and against
       a black backdrop it read as convincing glass. Against a pale gallery it
       reads as a navy hole punched in the wall — the darkest thing in the
       frame by a wide margin, which is not what a window looks like from
       inside a bright room. Lighter body, higher transmission, and the colour
       left to the attenuation so it is still recognisably glazing and not a
       clear hole. */
    glassTint = 0xd3e4ec,
    glassOpacity = 0.16,
    quality = 'high',
  } = opts;

  const sweep = {
    pos: { value: -50 },
    width: { value: 0.42 },
    gain: { value: 0.0 },
    colour: { value: new THREE.Color(0xffffff) },
    axis: { value: new THREE.Vector3(0.45, 1, 0.2).normalize() },
  };

  const frames = [];
  const glass = [];
  const hardware = [];

  root.traverse((node) => {
    if (!node.isMesh) return;

    node.castShadow = false;
    node.receiveShadow = false;
    node.frustumCulled = true;

    const src = node.material;
    const srcColour = src && src.color ? src.color.clone() : new THREE.Color(0.5, 0.5, 0.5);
    const glassy = src ? isGlass(src) : false;
    const refract = (transmissive === null ? quality === 'high' : !!transmissive) && GLASS_REFRACTS;

    if (glassy) {
      /* Real glass. `transmission` gives refraction through the pane rather
         than a flat alpha, which is the difference between a window that reads
         as glazed and one that reads as a hole with a tint on it. On low
         quality it falls back to plain transparency, because transmission
         costs a full extra render of the scene per frame. */
      const mat = new THREE.MeshPhysicalMaterial({
        color: linearColour(glassTint),
        metalness: 0,
        roughness: 0.04,
        transmission: refract ? 0.94 : 0.0,
        thickness: 0.028,
        ior: 1.46,
        // A little dispersion at the edges. Real IGUs do this and it is the
        // detail that stops the glass reading as cellophane.
        attenuationColor: linearColour(0xdaf0ff),
        attenuationDistance: 3.6,
        envMap,
        // Restrained on purpose. At 2.1 the studio's key panel came through
        // the glazing as a solid white rectangle and every window read as a
        // hole cut in a lightbox.
        envMapIntensity: 1.05,
        transparent: !refract,
        opacity: refract ? 1.0 : glassOpacity,
        depthWrite: quality === 'high',
        side: THREE.DoubleSide,
        clearcoat: 1.0,
        clearcoatRoughness: 0.03,
        specularIntensity: 1.0,
      });
      if (quality === 'high') mat.iridescence = 0.14, mat.iridescenceIOR = 1.25;
      node.material = mat;
      node.renderOrder = 2;
      glass.push(mat);
      return;
    }

    const neutral = isNeutral(srcColour);
    /* Neutral + opaque is the frame or the hardware. The two are told apart by
       how reflective the export made them: WindowCAD gives handles and hinges
       metalness 1 and a low roughness, and gives the powder coat metalness 0.
       Getting this wrong is only cosmetic — 3d.md notes hardware usually
       matches the frame on the real product anyway. */
    const isHardware = neutral && (src?.metalness ?? 0) > 0.5;

    const base = frameColour !== null && neutral && !isHardware
      ? linearColour(frameColour)
      : srcColour;

    const mat = new THREE.MeshPhysicalMaterial({
      color: base,
      // The exports are flat matte. Pushing metalness up and roughness down is
      // what makes an aluminium extrusion catch a highlight along its edge
      // instead of reading as grey card.
      metalness: isHardware ? 0.92 : 0.12,
      roughness: isHardware ? 0.24 : 0.46,
      envMap,
      envMapIntensity: isHardware ? 2.2 : 1.5,
      clearcoat: isHardware ? 0.3 : 0.62,
      clearcoatRoughness: isHardware ? 0.16 : 0.24,
      side: THREE.FrontSide,
      // A faint sheen across the powder coat. Real coatings are not perfectly
      // lambertian and this is most of why they look painted rather than CG.
      sheen: isHardware ? 0 : 0.22,
      sheenRoughness: 0.6,
      sheenColor: linearColour(0xbfd8dd),
    });

    if (quality === 'high') addLightSweep(mat, sweep);

    node.material = mat;
    (isHardware ? hardware : frames).push(mat);
  });

  return { frames, glass, hardware, sweep };
}

/** Push a new sweep position/intensity. Called every frame by the choreography. */
export function setSweep(sweep, pos, gain, colour) {
  sweep.pos.value = pos;
  sweep.gain.value = gain;
  if (colour !== undefined) sweep.colour.value.set(colour);
  // onBeforeCompile clones uniforms into each program, so the live shader
  // objects have to be written too. Missing this is why a sweep can look
  // wired up and do nothing.
}

/**
 * Recolour a model's frames. This is the runtime-colour system from `3d.md`
 * used as a visual event rather than a product picker: a finish crossfading
 * under a moving light is a far better demonstration of "we do this in twelve
 * colours" than a row of swatches.
 */
export function recolour(frames, hex, metal, rough, mix = 1) {
  const target = linearColour(hex);
  for (const mat of frames) {
    mat.color.lerp(target, mix);
    if (typeof metal === 'number') mat.metalness += (metal - mat.metalness) * mix;
    if (typeof rough === 'number') mat.roughness += (rough - mat.roughness) * mix;
  }
}

/**
 * The extruded logo's materials. The two strokes are steel; the leaf is glass
 * in Fenster green, so the mark is literally made of the two things the
 * company sells.
 */
export function markMaterials(envMap, quality) {
  /* The two strokes are anodised aluminium, not black plastic.
     `0x0d2a35` at metalness 0.92 came out as a silhouette with a white rim —
     a dark metal reflects the room and the room is dark, so there was nothing
     to see but the specular. Lifting the base and softening the roughness
     gives the faces something to hold, which is what makes it read as a
     machined object. */
  /* THE MARK IS DARK, BECAUSE THE ROOM IS LIGHT.
     Two rewrites happened here and both were forced by the room. Against
     black it was pale aluminium; then the softbox rig was fixed — pass one's
     RectAreaLights were never initialised and emitted nothing — and a
     blue-grey metal under two cool sources came out as cyan plastic. Now the
     gallery is white, and a white mark on a white wall is invisible.

     So it is the brand's own dark: `BRAND.ink`, which is the exact colour the
     traced SVG carries for the strokes and the colour the real logo uses on a
     light ground. Read as a deep anodised charcoal with a clearcoat, it is a
     dark machined object standing in a bright room, which is both correct for
     the brand and the strongest thing this composition can do. */
  const steel = new THREE.MeshPhysicalMaterial({
    /* Dark, but NOT black, and the metalness matters as much as the colour.
       At metalness 0.55 a near-black base has almost no diffuse term left, so
       the faces render as void and only the rim survives — which is a
       silhouette, the thing this whole rewrite exists to avoid. Lower
       metalness keeps a real diffuse shoulder on every face, and the clearcoat
       supplies the specular that makes it read as a machined, lacquered
       object rather than as flat paint. */
    /* A LINEAR-SPACE TRAP WORTH WRITING DOWN.
       `0x21454f` looks like a handsome deep teal as a swatch, but sRGB 0x21 is
       0.129, which is 0.014 in LINEAR light — effectively black to the
       renderer. Every colour chosen by eye from a hex value for a dark object
       lands in that trap, and the result is a shape with a rim and no faces.
       This is roughly three times lighter in linear terms while still reading
       as a dark anodised charcoal, and the clearcoat does the rest. */
    color: linearColour(0x3d5b66),
    metalness: 0.45,
    roughness: 0.2,
    envMap,
    envMapIntensity: 1.3,
    clearcoat: 1.0,
    clearcoatRoughness: 0.05,
  });

  /* The leaf is cast glass, and the first pass had it as a boiled sweet:
     full-saturation accent green, clearcoat 1, an emissive lift and a blown
     specular. Real coloured glass is DARKER than the colour it transmits,
     because the colour comes from absorption through thickness rather than
     from the surface. So the base goes deep, the attenuation carries the
     Fenster green, and the emissive comes off entirely. */
  /* The leaf has to read as FENSTER GREEN on every tier, because it is the
     one piece of brand colour in the first viewport. Two different materials
     rather than one with a flag:

     - With transmission, it is genuine cast glass. A deep base plus the
       accent as the attenuation colour, because coloured glass gets its
       colour from absorption through thickness rather than from its surface.
     - Without it, transmission is 0 and that same deep base is simply a dark
       green solid that vanishes into the room. So the fallback is a brighter
       body with a small emissive lift, which is not physically the same thing
       but is the same *impression*, and the impression is the point. */
  const glassy = quality === 'high';
  const leaf = new THREE.MeshPhysicalMaterial({
    color: linearColour(glassy ? 0x35a768 : 0x3cb974),
    metalness: 0,
    roughness: glassy ? 0.11 : 0.22,
    transmission: glassy && GLASS_REFRACTS ? 0.42 : 0,
    thickness: 0.7,
    ior: 1.52,
    attenuationColor: linearColour(0x3fd98a),
    attenuationDistance: 0.42,
    envMap,
    envMapIntensity: glassy ? 1.35 : 1.6,
    clearcoat: 0.85,
    clearcoatRoughness: 0.08,
    transparent: false,
    opacity: 1,
    side: THREE.DoubleSide,
    // Small on the glass version, larger on the fallback. It is the floor on
    // how dark the leaf is ever allowed to get.
    emissive: linearColour(0x37c47c),
    emissiveIntensity: glassy ? 0.14 : 0.1,
    // A hint of dispersion at the edges. Thick cast glass splits light and it
    // is the detail that separates this from a tinted solid.
    iridescence: glassy ? 0.25 : 0,
    iridescenceIOR: 1.3,
  });

  const edge = new THREE.MeshPhysicalMaterial({
    color: linearColour(0x6b8f9c),
    metalness: 1,
    roughness: 0.22,
    envMap,
    envMapIntensity: 1.4,
  });

  return { steel, leaf, edge };
}
