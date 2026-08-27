/**
 * The room the products hang in.
 *
 * Nothing here is a product. This is the space: the light rig, the drifting
 * dust, the sheets of architectural glass, the floor the whole thing sits
 * over, and the volumetric haze that makes distance readable.
 *
 * The brief for the look is a dark architectural studio at the end of the day
 * rather than anything neon — so the lighting is a big soft key, a cold rim
 * and one warm bounce, and the only saturated colour in the room is Fenster
 * green used sparingly as an accent.
 */
import * as THREE from 'three';
import { BRAND, linearColour, glassRefracts } from './materials.js';

/* ---------------------------------------------------------------- lighting */

export function buildLightRig(scene, quality) {
  const rig = new THREE.Group();
  rig.name = 'lightRig';

  // Key. Large, soft, high and slightly camera-left — a 2m softbox, which is
  // what an architectural product shoot actually uses.
  const key = new THREE.DirectionalLight(0xffffff, 3.6);
  key.position.set(-6.5, 9, 7.5);
  rig.add(key);

  // Cold rim from behind, so aluminium edges separate from the background.
  // This is most of what makes a dark scene read as expensive.
  const rim = new THREE.DirectionalLight(linearColour(0x9fd4e8), 4.4);
  rim.position.set(7.5, 3.2, -8);
  rig.add(rim);

  // Warm bounce from below-front, standing in for a floor return.
  const bounce = new THREE.DirectionalLight(linearColour(0xffe6c8), 0.9);
  bounce.position.set(2, -5, 5);
  rig.add(bounce);

  // Fenster green, used only as a wash on one side. Restraint matters here:
  // any more and the room stops being architectural and starts being a gamer
  // keyboard.
  const accent = new THREE.PointLight(linearColour(BRAND.accent), 26, 26, 2.1);
  accent.position.set(-5.5, 1.4, 3.2);
  rig.add(accent);

  const accent2 = new THREE.PointLight(linearColour(BRAND.lightBlue), 18, 22, 2.2);
  accent2.position.set(6.2, -1.6, -2.4);
  rig.add(accent2);

  const ambient = new THREE.AmbientLight(linearColour(0x18313c), 0.85);
  rig.add(ambient);

  // Two moving strip lights that travel through the composition. They are the
  // reason a static frozen frame still has motion in it: something is always
  // crossing a surface somewhere.
  const strips = [];
  if (quality !== 'low') {
    for (let i = 0; i < 2; i++) {
      const strip = new THREE.RectAreaLight(0xffffff, i === 0 ? 9 : 6, 9, 0.16);
      strip.position.set(0, 3 - i * 5.4, 2.4);
      strip.lookAt(0, 0, 0);
      rig.add(strip);
      strips.push(strip);
    }
  }

  /* THE FOLLOW KEY.
   *
   * The room lights are fixed, and with a dark room and dark anthracite
   * exports that left every hero product as a silhouette with a bright edge —
   * technically lit, visually black. A real product shoot does not light the
   * room and hope; the key is on a stand and it moves with the subject.
   *
   * These three do that. A hot key just off-axis, a tight rim from behind to
   * cut the product off the backdrop, and a soft bounce underneath. The
   * choreography aims all three at whatever is centre stage each frame.
   */
  const heroKey = new THREE.SpotLight(0xffffff, 0, 30, Math.PI * 0.34, 0.7, 2);
  const heroRim = new THREE.SpotLight(linearColour(0xbfe6f5), 0, 30, Math.PI * 0.36, 0.8, 2);
  const heroFill = new THREE.PointLight(linearColour(0xa8cddd), 0, 22, 2);
  const heroTarget = new THREE.Object3D();
  scene.add(heroTarget);
  heroKey.target = heroTarget;
  heroRim.target = heroTarget;
  rig.add(heroKey, heroRim, heroFill);

  scene.add(rig);
  return {
    rig, key, rim, bounce, accent, accent2, ambient, strips,
    heroKey, heroRim, heroFill, heroTarget,
    /**
     * Point the moving key at a world position.
     * `power` scales the whole group so the follow lights can be faded out
     * when nothing is centre stage.
     */
    aimHero(pos, power = 1, cameraDistance = 8) {
      heroTarget.position.copy(pos);

      /* Pull the key down as the subject approaches the lens.
         A white uPVC frame two units from the camera under a key sized for a
         subject eight units away is simply white, and the pass-through — the
         best shot in the sequence — was blowing out because of it. A gaffer
         would flag the lamp; this is the same move. */
      const close = Math.min(1, Math.max(0, (7.5 - cameraDistance) / 5.5));
      const trim = 1 - close * 0.34;

      // Key: high, camera-left, far enough that the falloff across a 2m
      // product is gentle rather than a hotspot.
      heroKey.position.set(pos.x - 4.6, pos.y + 5.4, pos.z + 4.8);
      heroKey.intensity = 150 * power * trim;
      // Rim: behind and opposite, which draws the bright line down an
      // aluminium edge and separates it from the dark.
      heroRim.position.set(pos.x + 5.2, pos.y + 2.2, pos.z - 5.4);
      heroRim.intensity = 92 * power * trim;
      // Fill: low and in front, so the underside of a cill is not dead.
      heroFill.position.set(pos.x + 0.6, pos.y - 2.4, pos.z + 2.8);
      heroFill.intensity = 30 * power * trim;
    },
  };
}

/* ------------------------------------------------------------------- dust */

/**
 * Dust motes. Two shells: a far field that sits with the products and reads as
 * atmosphere, and a near field almost on the lens that exaggerates every
 * camera move. The near field is doing the parallax heavy lifting — it is what
 * makes the camera feel like it is travelling rather than the world spinning.
 */
export function buildDust(scene, quality) {
  /* Near field cut hard. These are now large soft out-of-focus flecks, and a
     few of those read as a lens; five hundred of them read as weather. */
  const counts = { high: [4600, 110], medium: [2200, 70], low: [800, 34] }[quality];
  const group = new THREE.Group();
  group.name = 'dust';

  const make = (count, radius, size, opacity, near) => {
    const pos = new Float32Array(count * 3);
    const seed = new Float32Array(count);
    const scale = new Float32Array(count);
    for (let i = 0; i < count; i++) {
      // Cube rather than sphere for the near field, so motes keep entering
      // frame from the edges instead of thinning out at the corners.
      if (near) {
        pos[i * 3] = (Math.random() - 0.5) * radius * 2.4;
        pos[i * 3 + 1] = (Math.random() - 0.5) * radius * 1.6;
        pos[i * 3 + 2] = (Math.random() - 0.5) * radius;
      } else {
        const r = radius * (0.35 + Math.pow(Math.random(), 0.6) * 0.65);
        const th = Math.random() * Math.PI * 2;
        const ph = Math.acos(2 * Math.random() - 1);
        pos[i * 3] = r * Math.sin(ph) * Math.cos(th);
        pos[i * 3 + 1] = r * Math.cos(ph) * 0.55;
        pos[i * 3 + 2] = r * Math.sin(ph) * Math.sin(th);
      }
      seed[i] = Math.random() * Math.PI * 2;
      /* Heavily skewed, not uniform. Pass one used `0.35 + rand * 0.65`, which
         gives every mote roughly the same size and is precisely why it read as
         snow — real particulate is overwhelmingly too small to see, with the
         occasional large fleck. The fourth power puts most motes near the
         floor of the range and leaves a handful big. */
      scale[i] = 0.16 + Math.pow(Math.random(), 4) * 1.5;
    }

    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('aSeed', new THREE.BufferAttribute(seed, 1));
    geo.setAttribute('aScale', new THREE.BufferAttribute(scale, 1));

    const mat = new THREE.ShaderMaterial({
      transparent: true,
      depthWrite: false,
      blending: THREE.AdditiveBlending,
      uniforms: {
        uTime: { value: 0 },
        uSize: { value: size },
        uOpacity: { value: opacity },
        uColour: { value: linearColour(0xcfe9f2) },
        uAccent: { value: linearColour(BRAND.accent) },
        uPixelRatio: { value: 1 },
        uDrift: { value: near ? 0.30 : 0.09 },
        // Where the key is. Motes near the beam get brighter, which is what
        // "dust catching the light" actually is, and it means the particulate
        // reveals the lighting rather than sitting on top of it.
        uBeam: { value: new THREE.Vector3(-4, 4, 3) },
        uNear: { value: near ? 1 : 0 },
      },
      vertexShader: `
        attribute float aSeed;
        attribute float aScale;
        uniform float uTime;
        uniform float uSize;
        uniform float uPixelRatio;
        uniform float uDrift;
        uniform float uNear;
        uniform vec3 uBeam;
        varying float vAlpha;
        varying float vAccent;
        varying float vBeam;
        varying float vBlur;
        void main() {
          vec3 p = position;
          // Three incommensurate sine drifts, so no mote ever visibly loops.
          p.x += sin(uTime * 0.11 + aSeed) * uDrift;
          p.y += cos(uTime * 0.083 + aSeed * 1.7) * uDrift * 1.35;
          p.z += sin(uTime * 0.067 + aSeed * 2.3) * uDrift;

          vec3 world = (modelMatrix * vec4(p, 1.0)).xyz;
          vBeam = 1.0 - smoothstep(1.5, 9.0, distance(world, uBeam));

          vec4 mv = modelViewMatrix * vec4(p, 1.0);
          gl_Position = projectionMatrix * mv;
          float dist = -mv.z;
          gl_PointSize = uSize * aScale * uPixelRatio * (14.0 / max(dist, 0.35));

          /* Fade both ways: motes right on the lens would otherwise be white
             discs, and distant ones would stipple. */
          vAlpha = smoothstep(0.15, 1.1, dist) * (1.0 - smoothstep(16.0, 34.0, dist));
          /* How out of focus a mote is. The near field sits inside the focal
             distance, so it should be a soft disc rather than a point — this
             is the foreground particulate the brief asked for, and it also
             stops the near field competing with the subject for attention. */
          vBlur = uNear * (1.0 - smoothstep(0.4, 4.5, dist));
          vAccent = step(0.988, fract(aSeed * 13.37));
        }
      `,
      fragmentShader: `
        uniform vec3 uColour;
        uniform vec3 uAccent;
        uniform float uOpacity;
        varying float vAlpha;
        varying float vAccent;
        varying float vBeam;
        varying float vBlur;
        void main() {
          vec2 c = gl_PointCoord - 0.5;
          float d = length(c);
          if (d > 0.5) discard;
          /* A tight speck by default; a wide flat disc when it is close enough
             to be out of focus. Pass one used one profile for both fields,
             which is why every mote read as the same bright dot. */
          float sharp = pow(1.0 - d * 2.0, 2.6);
          float bokeh = smoothstep(0.5, 0.34, d) * 0.30;
          float a = mix(sharp, bokeh, vBlur);
          vec3 col = mix(uColour, uAccent, vAccent * 0.5);
          // In the beam it is brighter and slightly warmer.
          col *= 1.0 + vBeam * 1.6;
          gl_FragColor = vec4(col, a * vAlpha * uOpacity * (0.45 + vBeam * 0.9));
        }
      `,
    });

    const pts = new THREE.Points(geo, mat);
    pts.frustumCulled = false;
    return pts;
  };

  /* Sizes down hard from pass one (11 and 30) and opacities roughly halved.
     The far field is now genuinely fine — atmosphere rather than objects — and
     the near field is a handful of large soft flecks close to the lens. */
  const FAR_OPACITY = 0.115;
  const NEAR_OPACITY = 0.075;
  const far = make(counts[0], 15, 6.5, FAR_OPACITY, false);
  const near = make(counts[1], 3.2, 26, NEAR_OPACITY, true);
  group.add(far, near);
  scene.add(group);

  const _beam = new THREE.Vector3(-4, 4, 3);
  return {
    group,
    far,
    near,
    setPixelRatio(pr) {
      far.material.uniforms.uPixelRatio.value = pr;
      near.material.uniforms.uPixelRatio.value = pr;
    },
    /** Tell the dust where the key is, so the beam lights it. */
    setBeam(pos) { _beam.copy(pos); },
    update(time, opacity = 1) {
      for (const p of [far, near]) {
        p.material.uniforms.uTime.value = time;
        p.material.uniforms.uBeam.value.copy(_beam);
      }
      far.material.uniforms.uOpacity.value = FAR_OPACITY * opacity;
      near.material.uniforms.uOpacity.value = NEAR_OPACITY * opacity;
    },
  };
}

/* ------------------------------------------------------- glass architecture */

/**
 * Sheets of architectural glass, hung on the orbit at varying radii.
 *
 * These are the "architectural fragments" of the brief and they do three jobs:
 * they give the empty parts of the orbit something to catch light, they
 * occlude products as they pass which is what sells the depth, and they carry
 * the Fenster green in reflection so the accent colour appears in the room
 * without a coloured light being pointed at anything.
 */
export function buildGlassArchitecture(parent, envMap, quality, rng) {
  const group = new THREE.Group();
  group.name = 'glassArchitecture';

  const count = { high: 15, medium: 10, low: 5 }[quality];
  const panes = [];

  /* Deliberately restrained. The first build ran these at envMapIntensity 2.4
     with 22 of them tumbling at random angles, and the result was a field of
     blown white rectangles that fought the products for attention. Glass in a
     dark room is mostly a faint edge and a long soft streak; it should be
     something the eye finds after the product, not before it. */
  const glassMat = new THREE.MeshPhysicalMaterial({
    color: linearColour(0x7fa8bb),
    metalness: 0,
    roughness: 0.08,
    transmission: glassRefracts(quality) ? 0.98 : 0,
    thickness: 0.09,
    ior: 1.5,
    envMap,
    envMapIntensity: 0.62,
    transparent: true,
    opacity: quality === 'high' ? 1 : 0.09,
    depthWrite: false,
    side: THREE.DoubleSide,
    clearcoat: 1,
    clearcoatRoughness: 0.04,
    attenuationColor: linearColour(0xbfe2f2),
    attenuationDistance: 2.4,
  });

  // A frosted variant. Mixing clear and frosted is what stops the panes
  // reading as a repeated asset.
  const frostedMat = glassMat.clone();
  frostedMat.roughness = 0.42;
  frostedMat.transmission = quality === 'high' ? 0.86 : 0;
  frostedMat.opacity = quality === 'high' ? 1 : 0.2;
  frostedMat.color = linearColour(0xd8e8ee);

  // Edge-lit strips along the pane borders. Glass edges catch light far more
  // than faces do, and drawing that explicitly is the difference between a
  // sheet of glass and a grey rectangle.
  const edgeMat = new THREE.MeshBasicMaterial({
    color: linearColour(0x9fd4dd),
    transparent: true,
    opacity: 0.2,
    blending: THREE.AdditiveBlending,
    depthWrite: false,
  });

  for (let i = 0; i < count; i++) {
    /* Architectural proportions rather than random rectangles: tall and
       narrow, like a curtain-walling bay. And they stand nearly upright and
       nearly tangent to the orbit, so they read as a building's glazing seen
       from inside rather than as debris floating in space. A pane at a jaunty
       angle is the single thing that made the first build look like a
       screensaver. */
    const w = 0.9 + rng() * 1.8;
    const h = w * (1.9 + rng() * 2.1);
    const geo = new THREE.BoxGeometry(w, h, 0.016);
    const pane = new THREE.Mesh(geo, rng() > 0.7 ? frostedMat : glassMat);

    const radius = 6.5 + rng() * 10;
    const angle = rng() * Math.PI * 2;
    const height = (rng() - 0.45) * 7;
    pane.position.set(Math.cos(angle) * radius, height, Math.sin(angle) * radius);
    pane.rotation.set(
      (rng() - 0.5) * 0.1,                                   // near vertical
      angle + Math.PI / 2 + (rng() - 0.5) * 0.42,            // near tangent
      (rng() - 0.5) * 0.06
    );
    pane.renderOrder = 1;

    if (quality === 'high' && rng() > 0.45) {
      const edge = new THREE.LineSegments(
        new THREE.EdgesGeometry(geo),
        edgeMat.clone()
      );
      edge.material.opacity = 0.07 + rng() * 0.14;
      pane.add(edge);
    }

    pane.userData = {
      baseY: height,
      radius,
      angle,
      spin: (rng() - 0.5) * 0.06,
      bob: 0.1 + rng() * 0.3,
      phase: rng() * Math.PI * 2,
    };
    group.add(pane);
    panes.push(pane);
  }

  parent.add(group);

  return {
    group,
    panes,
    update(time, opacity = 1) {
      for (const p of panes) {
        const d = p.userData;
        p.position.y = d.baseY + Math.sin(time * 0.22 + d.phase) * d.bob;
        p.rotation.z += d.spin * 0.0016;
        p.rotation.y += d.spin * 0.0009;
      }
      glassMat.opacity = (quality === 'high' ? 1 : 0.16) * opacity;
      frostedMat.opacity = (quality === 'high' ? 1 : 0.2) * opacity;
      glassMat.visible = opacity > 0.02;
    },
    dispose() {
      panes.forEach((p) => p.geometry.dispose());
      glassMat.dispose();
      frostedMat.dispose();
      edgeMat.dispose();
    },
  };
}

/* ------------------------------------------------------------------ ground */

/**
 * The floor. Not a mirror — a mirror in a scene this reflective reads as a
 * showroom photograph rather than a void. This is a large disc with a radial
 * gradient that fades to nothing at the edge, so the room has a bottom near
 * the products and no bottom at all further out.
 */
export function buildGround(scene) {
  const geo = new THREE.CircleGeometry(46, 96);
  const mat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    uniforms: {
      uTime: { value: 0 },
      uInner: { value: linearColour(0x15394a) },
      uOuter: { value: linearColour(0x081d28) },
      uAccent: { value: linearColour(BRAND.accent) },
      uOpacity: { value: 1 },
    },
    vertexShader: `
      varying vec2 vUv;
      varying vec3 vPos;
      void main() {
        vUv = uv;
        vPos = position;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `,
    fragmentShader: `
      uniform vec3 uInner;
      uniform vec3 uOuter;
      uniform vec3 uAccent;
      uniform float uTime;
      uniform float uOpacity;
      varying vec2 vUv;
      varying vec3 vPos;
      void main() {
        float d = length(vPos.xy) / 46.0;
        vec3 col = mix(uInner, uOuter, smoothstep(0.0, 0.62, d));
        // A slow green sweep across the floor, keyed off world position so it
        // reads as a light moving through the room rather than a texture.
        float sweep = sin(vPos.x * 0.16 + uTime * 0.19) * 0.5 + 0.5;
        col += uAccent * sweep * 0.035 * (1.0 - smoothstep(0.0, 0.5, d));
        // Concentric survey rings, very faint. Architectural rather than sci-fi
        // because they are wide, sparse and almost invisible.
        float ring = smoothstep(0.985, 1.0, abs(sin(d * 42.0)));
        col += vec3(0.035, 0.075, 0.09) * ring * (1.0 - smoothstep(0.1, 0.6, d));
        float a = (1.0 - smoothstep(0.28, 0.98, d)) * uOpacity;
        gl_FragColor = vec4(col, a);
      }
    `,
  });
  const ground = new THREE.Mesh(geo, mat);
  ground.rotation.x = -Math.PI / 2;
  ground.position.y = -4.4;
  ground.renderOrder = -1;
  scene.add(ground);
  return {
    mesh: ground,
    update(time, opacity = 1) {
      mat.uniforms.uTime.value = time;
      mat.uniforms.uOpacity.value = opacity;
    },
  };
}

/* ------------------------------------------------------------- light wall */

/**
 * A soft luminous panel that sits BEHIND whatever is centre stage.
 *
 * This is the piece the scene was missing and it is worth explaining, because
 * the problem it solves looks like a lighting problem and is not.
 *
 * These products are mostly glass, the glass is transmissive, and a dark room
 * behind it means every pane transmits black. So a window could be perfectly
 * lit and still read as a black rectangle with a bright edge — which is
 * exactly what the first five passes produced. No amount of key light fixes
 * it, because the key is not what you see through a window; what you see
 * through a window is whatever is on the other side.
 *
 * A product photographer solves this with a lit backdrop, and so does this. It
 * gives the glazing something to carry, throws the frame into relief, and is
 * the reason the panes now read as glass rather than as holes.
 */
export function buildLightWall(scene) {
  const geo = new THREE.PlaneGeometry(24, 14);
  const mat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    side: THREE.DoubleSide,
    uniforms: {
      uTime: { value: 0 },
      uIntensity: { value: 1 },
      uWarm: { value: linearColour(0x9fbccb) },
      uCool: { value: linearColour(0x1c4457) },
      uAccent: { value: linearColour(BRAND.accent) },
      uAccentMix: { value: 0.0 },
    },
    vertexShader: `
      varying vec2 vUv;
      void main() { vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }
    `,
    fragmentShader: `
      uniform float uTime, uIntensity, uAccentMix;
      uniform vec3 uWarm, uCool, uAccent;
      varying vec2 vUv;
      void main() {
        vec2 p = (vUv - vec2(0.5, 0.46)) * vec2(1.0, 1.5);
        float d = length(p);
        // A big soft pool rather than an even panel, so the backdrop has a
        // gradient across it and the glass picks up a falloff instead of a
        // flat grey. Two lobes, slowly drifting apart and together.
        float pool = pow(max(0.0, 1.0 - d * 1.25), 2.6);
        float second = pow(max(0.0, 1.0 - length(p - vec2(0.28 + sin(uTime * 0.13) * 0.06, 0.1)) * 1.9), 3.0);
        float a = pool + second * 0.55;
        vec3 col = mix(uCool, uWarm, clamp(a * 1.35, 0.0, 1.0));
        col = mix(col, uAccent, uAccentMix * 0.28 * (1.0 - a));
        gl_FragColor = vec4(col, clamp(a, 0.0, 1.0) * uIntensity);
      }
    `,
  });
  const wall = new THREE.Mesh(geo, mat);
  wall.renderOrder = -2;
  wall.position.set(0, 0, -6);
  scene.add(wall);

  return {
    mesh: wall,
    /** Park it behind a world position, facing the camera. */
    placeBehind(pos, distance = 6.5, intensity = 1, accent = 0) {
      wall.position.set(pos.x * 0.55, pos.y * 0.5 + 0.2, pos.z - distance);
      // Hard ceiling. Scenery does not get to out-shine the product.
      mat.uniforms.uIntensity.value = Math.min(0.88, intensity);
      mat.uniforms.uAccentMix.value = accent;
      wall.visible = intensity > 0.01;
    },
    update(time) { mat.uniforms.uTime.value = time; },
    dispose() { geo.dispose(); mat.dispose(); },
  };
}

/* --------------------------------------------------------------- backdrop */

/**
 * A very large inward-facing sphere carrying a gradient. It is the horizon —
 * the thing that stops the scene being a black void, and the thing that gives
 * the transmissive glass something worth refracting.
 */
export function buildBackdrop(scene) {
  const geo = new THREE.SphereGeometry(120, 48, 32);
  const mat = new THREE.ShaderMaterial({
    side: THREE.BackSide,
    depthWrite: false,
    uniforms: {
      uTop: { value: linearColour(0x0e2c3a) },
      uMid: { value: linearColour(0x143d4d) },
      uBottom: { value: linearColour(0x061620) },
      uAccent: { value: linearColour(BRAND.accent) },
      uTime: { value: 0 },
      uPhase: { value: 0 },
    },
    vertexShader: `
      varying vec3 vPos;
      void main() {
        vPos = position;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `,
    fragmentShader: `
      uniform vec3 uTop; uniform vec3 uMid; uniform vec3 uBottom; uniform vec3 uAccent;
      uniform float uTime; uniform float uPhase;
      varying vec3 vPos;
      void main() {
        vec3 n = normalize(vPos);
        float h = n.y * 0.5 + 0.5;
        vec3 col = mix(uBottom, uMid, smoothstep(0.0, 0.52, h));
        col = mix(col, uTop, smoothstep(0.45, 1.0, h));
        // One soft glow on the horizon that drifts round with the phase, so the
        // backdrop is not the same picture in all four phases.
        float az = atan(n.z, n.x);
        float glow = pow(max(0.0, cos(az - uPhase * 1.6 - 0.6)), 7.0);
        col += mix(uAccent, vec3(0.35, 0.62, 0.78), 0.55) * glow * 0.16 * (1.0 - abs(n.y));
        gl_FragColor = vec4(col, 1.0);
      }
    `,
  });
  const sky = new THREE.Mesh(geo, mat);
  sky.frustumCulled = false;
  scene.add(sky);
  return {
    mesh: sky,
    update(time, phase) {
      mat.uniforms.uTime.value = time;
      mat.uniforms.uPhase.value = phase;
    },
  };
}
