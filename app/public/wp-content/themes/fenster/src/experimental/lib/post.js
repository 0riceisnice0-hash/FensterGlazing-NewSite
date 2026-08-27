/**
 * The finishing pass — the difference between a render and a shot.
 *
 * Pass two added the piece that was most obviously missing: real depth of
 * field. Everything else here is grading. A perfectly sharp frame from front to
 * back is the single loudest tell that something is CG, because no lens does
 * that; a subject in focus with the architecture behind it falling soft is
 * what makes a frame read as photographed.
 *
 * Order: bokeh (which also renders the scene) → bloom → grade → SMAA.
 *
 * Bloom is deliberately restrained now. Pass one ran it at strength 0.62 with
 * threshold 0.86, and on the beats where a soft light and a specular highlight
 * landed in the same place it produced a cyan-white blob that dominated the
 * frame. Bloom is polish, not content: threshold up, strength down, and the
 * choreography pulls it further back on the beats that were worst.
 */
import * as THREE from 'three';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js';
import { BokehPass } from 'three/examples/jsm/postprocessing/BokehPass.js';
import { UnrealBloomPass } from 'three/examples/jsm/postprocessing/UnrealBloomPass.js';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass.js';
import { SMAAPass } from 'three/examples/jsm/postprocessing/SMAAPass.js';

const FinishShader = {
  uniforms: {
    tDiffuse: { value: null },
    uTime: { value: 0 },
    uAberration: { value: 0.0007 },
    uVignette: { value: 0.16 },
    uGrain: { value: 0.008 },
    uStreak: { value: 0.0 },
    uLift: { value: 0.16 },
    uResolution: { value: new THREE.Vector2(1, 1) },
    uFade: { value: 0.0 },
    uFadeColour: { value: new THREE.Color(0, 0, 0) },
    uHighlightRoll: { value: 0.0 },
  },
  vertexShader: `
    varying vec2 vUv;
    void main() { vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }
  `,
  fragmentShader: `
    uniform sampler2D tDiffuse;
    uniform float uTime, uAberration, uVignette, uGrain, uStreak, uLift, uFade, uHighlightRoll;
    uniform vec2 uResolution;
    uniform vec3 uFadeColour;
    varying vec2 vUv;

    float hash(vec2 p) {
      p = fract(p * vec2(443.897, 441.423));
      p += dot(p, p + 19.19);
      return fract(p.x * p.y);
    }

    void main() {
      vec2 uv = vUv;
      vec2 centred = uv - 0.5;
      float r2 = dot(centred, centred);

      // Chromatic aberration scaled by r^2, so the centre of frame — where the
      // product is — stays perfectly clean and only the corners fringe. A flat
      // aberration across the whole frame just looks like a broken monitor.
      vec2 offset = centred * uAberration * r2 * 4.0;
      vec3 col;
      col.r = texture2D(tDiffuse, uv + offset).r;
      col.g = texture2D(tDiffuse, uv).g;
      col.b = texture2D(tDiffuse, uv - offset).b;

      // Horizontal streak on the brightest parts only. Cheap seven-tap; it is
      // the highlight behaviour of an anamorphic lens and it makes every
      // specular hit on an aluminium edge feel like it was shot rather than
      // computed.
      if (uStreak > 0.001) {
        vec3 streak = vec3(0.0);
        float texel = 1.0 / uResolution.x;
        for (int i = 1; i <= 7; i++) {
          float w = 1.0 - float(i) / 8.0;
          float d = float(i) * texel * 9.0;
          vec3 a = texture2D(tDiffuse, uv + vec2(d, 0.0)).rgb;
          vec3 b = texture2D(tDiffuse, uv - vec2(d, 0.0)).rgb;
          streak += (max(a - 0.72, 0.0) + max(b - 0.72, 0.0)) * w;
        }
        col += streak * uStreak;
      }

      /* A second highlight roll-off on top of ACES.
         The brief asked for no blown white surfaces anywhere, and the places
         that still clipped were not lighting mistakes — they were a light
         finish and a specular landing on the same pixel. This compresses only
         what is already near the top, so midtones are untouched and a white
         uPVC frame keeps its bevels instead of going to paper. */
      if (uHighlightRoll > 0.001) {
        float lum = dot(col, vec3(0.2126, 0.7152, 0.0722));
        float over = max(0.0, lum - 0.74);
        float squash = over / (over + 0.42);
        col *= mix(1.0, 1.0 - squash * 0.62, uHighlightRoll);
      }

      /* Shadow shaping. On the dark grade this was a LIFT — pure black
         crushes the depth out of a dark scene. On a light grade the opposite
         is true: without a real black point everything goes milky and the
         whole thing looks washed out rather than clean. So this now pulls the
         toe DOWN a little, which is what gives a bright frame its snap and
         what lets an anthracite frame read as genuinely dark. */
      float toe = dot(col, vec3(0.2126, 0.7152, 0.0722));
      col *= 1.0 - uLift * 1.6 * (1.0 - smoothstep(0.0, 0.30, toe));

      /* Vignette. Deliberately gentle and wide.
         The first version ran a smoothstep from 0.86 to 0.12 at strength 0.95,
         which multiplies the corners by about 0.45 — it darkened more than half
         the frame by more than half a stop, and every attempt to fix the
         "everything is too dark" problem upstream was being eaten by it.
         A vignette should be felt and not seen. */
      col *= mix(1.0, smoothstep(1.5, 0.05, r2 * 2.1), uVignette);

      /* A trace of grain. Much lighter than the dark grade carried, because
         "clean" is the brief and visible grain on a white wall is the one
         thing that instantly reads as a filter. It is still not zero: a
         perfectly smooth pale gradient bands badly on an 8-bit display, and
         a little noise is the standard fix. */
      float g = hash(gl_FragCoord.xy + fract(uTime) * 431.0) - 0.5;
      col += g * uGrain;

      col = mix(col, uFadeColour, uFade);
      gl_FragColor = vec4(col, 1.0);
    }
  `,
};

export function buildComposer(renderer, scene, camera, quality) {
  const size = renderer.getSize(new THREE.Vector2());
  const composer = new EffectComposer(renderer);
  composer.setPixelRatio(renderer.getPixelRatio());
  composer.setSize(size.x, size.y);

  /* DEPTH OF FIELD.
   *
   * High tier only: BokehPass renders the scene a second time with a depth
   * material, which is roughly a 35% frame cost on this geometry. Worth it
   * where there is headroom, first thing to drop where there is not.
   *
   * The aperture is small on purpose. The hero product must stay sharp — the
   * brief is explicit that this is not a screen-wide blur — so the focal plane
   * sits on the subject and only the architecture behind and the dust in front
   * fall off. Focus is racked by the choreography, slowly, the way an operator
   * pulls it.
   */
  /* RenderPass FIRST, always.
     BokehPass renders the scene only to get a depth buffer; its colour input
     is `readBuffer`, which is whatever the previous pass left. Used as the
     first pass it reads an empty target and outputs black — the whole frame,
     silently, with no error and no warning. The only symptom was
     `renderer.info.render.triangles === 1`, that one triangle being the final
     fullscreen quad. Worth knowing: it is not a replacement for RenderPass,
     it is a filter that sits after one. */
  composer.addPass(new RenderPass(scene, camera));

  let bokeh = null;
  if (quality === 'high') {
    bokeh = new BokehPass(scene, camera, {
      focus: 9.0,
      aperture: 0.00042,
      maxblur: 0.011,
    });
    composer.addPass(bokeh);
  }

  let bloom = null;
  if (quality !== 'low') {
    bloom = new UnrealBloomPass(
      new THREE.Vector2(size.x, size.y),
      quality === 'high' ? 0.13 : 0.09,  // strength. Barely there: on a light
      0.6,                               // grade every pale surface is already
      0.97                               // near the threshold, so anything more
                                         // than a trace turns the whole room
                                         // into fog. Threshold up to 0.97 so
                                         // only a genuine specular blooms.
    );
    composer.addPass(bloom);
  }

  const finish = new ShaderPass(FinishShader);
  finish.uniforms.uResolution.value.set(size.x, size.y);
  if (quality === 'low') {
    finish.uniforms.uAberration.value = 0;
    finish.uniforms.uGrain.value = 0.014;
  }
  composer.addPass(finish);

  // SMAA rather than MSAA: the composer's render targets are not multisampled
  // on every driver, and hard aluminium edges against a dark backdrop are
  // exactly the case that shows it.
  if (quality === 'high') {
    composer.addPass(new SMAAPass(
      size.x * renderer.getPixelRatio(),
      size.y * renderer.getPixelRatio()
    ));
  }

  /* The focus is damped rather than set. A focus value driven straight off
     scroll pumps on every small wheel movement, which is the most obviously
     wrong thing a virtual camera can do — real operators pull focus slowly and
     never twitch. */
  let focusTarget = 9.0;
  let focusCurrent = 9.0;

  return {
    composer,
    bloom,
    bokeh,
    finish,
    setSize(w, h, pr) {
      composer.setPixelRatio(pr);
      composer.setSize(w, h);
      finish.uniforms.uResolution.value.set(w * pr, h * pr);
      bloom?.setSize(w, h);
    },
    /** Ask for a focal distance, in world units from the camera. */
    focusOn(distance, aperture) {
      focusTarget = distance;
      if (bokeh && aperture !== undefined) bokeh.uniforms.aperture.value = aperture;
    },
    update(time, dt = 0.016) {
      finish.uniforms.uTime.value = time;
      if (bokeh) {
        // ~0.6s to travel most of the way. Slow enough to read as a pull.
        focusCurrent += (focusTarget - focusCurrent) * Math.min(1, dt * 2.6);
        bokeh.uniforms.focus.value = focusCurrent;
      }
    },
  };
}
