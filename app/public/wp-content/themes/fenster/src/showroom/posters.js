/**
 * POSTER GENERATOR.
 *
 * Renders one product full-bleed at the viewport size so a screenshot IS the
 * poster — no cropping, no scaling, no guesswork about what the harness
 * captured. Driven by `?id=`, one product per page load.
 *
 * The poster matters more than it sounds. It is the LCP element on both
 * showroom pages: the page is complete and indexable as HTML plus this image,
 * and the 3D viewer is an upgrade that loads later on intent. Rendering it
 * through the same stage the viewer uses is what makes the hand-over between
 * them invisible.
 *
 * Local build tool. Not linked from any page, not shipped.
 */
import { buildStage } from './lib/stage.js';
import { loadProduct } from './lib/loader.js';

const THEME = '/wp-content/themes/fenster';
const params = new URLSearchParams(location.search);
const id = params.get('id') || 'casement';
const file = params.get('file');

const canvas = document.getElementById('c');
const W = window.innerWidth;
const H = window.innerHeight;
canvas.width = W; canvas.height = H;

const stage = buildStage(canvas, { width: W, height: H, background: 0xeef1f0 });

(async () => {
  try {
    const product = await loadProduct(`${THEME}/assets/showroom/models/${file}`, { targetHeight: 2.0 });
    stage.scene.add(product.holder);
    stage.standOn(product.holder);
    /* Shut. A poster of a door hanging open reads as a mistake; the open state
       is something the visitor does, and it should be theirs to discover. */
    product.setOpen(0);
    stage.frame(product.holder, { fill: 0.80, yaw: 0.44, pitch: 0.12 });
    stage.render();
    // two frames, so the environment map is definitely resolved before capture
    requestAnimationFrame(() => { stage.render(); document.body.dataset.ready = id; });
  } catch (e) {
    document.body.dataset.error = String(e && e.message ? e.message : e);
  }
})();
