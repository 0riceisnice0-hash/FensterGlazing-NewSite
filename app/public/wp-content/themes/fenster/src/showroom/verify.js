/**
 * DOES THE ANIMATION STILL WORK AFTER OPTIMISATION?
 *
 * `join()` merges primitives. Merging an animated node destroys its clip, and
 * it does so silently: the file loads, the clip is still listed, the mixer's
 * time advances, and nothing moves. That exact failure survived two full
 * development passes on this project's earlier 3D page.
 *
 * So this measures actual world-space displacement of every node between shut
 * and open, on the optimised file AND on the untouched original, and compares
 * them. Eyeballing a render cannot tell you the difference between "the door
 * opened" and "the door was already drawn open".
 *
 * This file is a local verification harness. It is not part of the shipped
 * viewer and must not be linked from any page.
 */

import * as THREE from 'three';
import { loadProduct } from './lib/loader.js';

const THEME = '/wp-content/themes/fenster';
const OPT = `${THEME}/assets/showroom/models`;
const RAW = `${THEME}/assets/experimental/models`;

const RANGE = [
  { id: 'casement', file: 'upvc-casement-window.glb' },
  { id: 'flush', file: 'flush-sash-window.glb' },
  { id: 'sash', file: 'sliding-sash-window.glb' },
  { id: 'alu-window', file: 'aluminium-windows.glb' },
  { id: 'composite', file: 'composite-front-door.glb' },
  { id: 'heritage-door', file: 'heritage-aluminium-door.glb' },
  { id: 'slide-fold', file: 'slide-fold-doors.glb' },
  { id: 'bifold', file: 'aluminium-bifold-door.glb' },
  { id: 'upvc-slider', file: 'upvc-sliding-patio-doors.glb' },
  { id: 'alu-door', file: 'aluminium-doors.glb' },
  { id: 'alu-slider', file: 'aluminium-sliding-patio-door.glb' },
];

/** World position and orientation of every named node, at the current pose. */
function snapshot(product) {
  product.holder.updateMatrixWorld(true);
  const out = new Map();
  const p = new THREE.Vector3();
  const q = new THREE.Quaternion();
  const s = new THREE.Vector3();
  product.root.traverse((n) => {
    n.matrixWorld.decompose(p, q, s);
    out.set(n.uuid, { name: n.name || '(unnamed)', p: p.clone(), q: q.clone() });
  });
  return out;
}

/** Largest movement of any node between two poses, in metres and degrees. */
function motion(a, b) {
  let maxMove = 0;
  let maxTurn = 0;
  let moverName = '';
  let movers = 0;
  for (const [uuid, before] of a) {
    const after = b.get(uuid);
    if (!after) continue;
    const d = before.p.distanceTo(after.p);
    const ang = 2 * Math.acos(Math.min(1, Math.abs(before.q.dot(after.q)))) * (180 / Math.PI);
    if (d > 0.001 || ang > 0.1) movers++;
    if (d > maxMove) { maxMove = d; moverName = before.name; }
    if (ang > maxTurn) maxTurn = ang;
  }
  return { maxMoveMm: Math.round(maxMove * 1000), maxTurnDeg: Math.round(maxTurn * 10) / 10, movers, moverName };
}

/** How much the silhouette actually changes — a second, independent signal. */
function extent(product) {
  product.holder.updateMatrixWorld(true);
  const box = new THREE.Box3().setFromObject(product.holder);
  const size = box.getSize(new THREE.Vector3());
  return { x: size.x, y: size.y, z: size.z };
}

async function measure(url) {
  const product = await loadProduct(url, { targetHeight: 2.2 });
  product.setOpen(0);
  const shut = snapshot(product);
  const shutSize = extent(product);
  product.setOpen(1);
  const open = snapshot(product);
  const openSize = extent(product);

  const m = motion(shut, open);
  const result = {
    animated: product.animated,
    ...m,
    depthChangeMm: Math.round((openSize.z - shutSize.z) * 1000),
    widthChangeMm: Math.round((openSize.x - shutSize.x) * 1000),
    materials: Object.fromEntries(
      Object.entries(product.materials).map(([k, v]) => [k, v.length]).filter(([, n]) => n > 0)
    ),
    meshes: (() => { let n = 0; product.root.traverse((o) => { if (o.isMesh) n++; }); return n; })(),
  };
  product.dispose();
  return result;
}

window.__verify = async function verify() {
  const rows = [];
  for (const item of RANGE) {
    let opt = null;
    let raw = null;
    let error = null;
    try {
      opt = await measure(`${OPT}/${item.file}`);
      raw = await measure(`${RAW}/${item.file}`);
    } catch (e) {
      error = String(e && e.message ? e.message : e);
    }
    if (error) { rows.push({ id: item.id, error }); continue; }

    /* THE VERDICT, AND WHICH INVARIANT IT USES.
     *
     * The obvious test — did the furthest-travelling node travel as far as it
     * used to — is the wrong one, and it produced three false alarms before
     * this was corrected. `join()` merges primitives, so the optimised file has
     * a different SET of nodes; "which node moves furthest" is not comparable
     * between the two, and the composite door reported a 99% change while
     * opening by exactly the same amount.
     *
     * What is comparable is the silhouette. If a door swings 646mm out of its
     * frame, the bounding box grows 646mm whatever the node topology is. That,
     * plus the rotation, is the physically meaningful "how far does it open",
     * and both survive an arbitrary re-parenting. Node displacement is kept
     * below as information, not as a gate. */
    const silOpt = Math.max(Math.abs(opt.depthChangeMm), Math.abs(opt.widthChangeMm));
    const silRaw = Math.max(Math.abs(raw.depthChangeMm), Math.abs(raw.widthChangeMm));
    const silDrift = Math.abs(silOpt - silRaw);
    const turnDrift = Math.abs(opt.maxTurnDeg - raw.maxTurnDeg);
    const moves = opt.maxMoveMm >= 1 || opt.maxTurnDeg >= 1;

    const verdict = !raw.animated
      ? 'static (nothing to preserve)'
      : !moves
        ? 'BROKEN - optimised model does not move'
        : (silDrift > Math.max(5, silRaw * 0.02) || turnDrift > 1)
          ? `SUSPECT - silhouette ${silOpt}mm vs ${silRaw}mm, turn ${opt.maxTurnDeg} vs ${raw.maxTurnDeg}`
          : 'ok';

    rows.push({
      id: item.id,
      verdict,
      optMoveMm: opt.maxMoveMm, rawMoveMm: raw.maxMoveMm,
      optTurnDeg: opt.maxTurnDeg, rawTurnDeg: raw.maxTurnDeg,
      movers: `${opt.movers} of ${opt.meshes} (was ${raw.movers})`,
      mover: opt.moverName,
      depthChangeMm: `${opt.depthChangeMm} (was ${raw.depthChangeMm})`,
      meshes: `${opt.meshes} (was ${raw.meshes})`,
      materials: opt.materials,
    });
  }
  return rows;
};

document.body.dataset.ready = '1';
