/**
 * A purpose-built environment map.
 *
 * On materials that carry no textures — which is every product here, they are
 * a baseColorFactor and two scalars — the environment IS the look. So this is
 * built to brief rather than loaded.
 *
 * PASS TWO, REVISED: THE GALLERY IS LIT, NOT DARK.
 *
 * The first two versions of this file were a dark studio at the end of the
 * day, and it produced a real problem the brief kept circling: almost all of
 * this product range is specified in anthracite, and a dark object in a dark
 * room is a silhouette no amount of rim light truly fixes. Turning the room up
 * solves it at the source. Anthracite against a pale ground separates
 * perfectly, with no trickery at all, and it is how premium window and door
 * photography is actually shot — the frame is the dark shape and the room is
 * the light one.
 *
 * `RoomEnvironment` is still the wrong answer, for the opposite reason it was
 * before: it is a room of hard white rectangles, which turns aluminium into
 * chrome and puts blown panels through every pane of glass. This is a diffuse
 * daylit gallery — large, soft, gently graded sources with one clean key, so
 * reflections are long soft gradients rather than cut-out shapes.
 *
 * It costs nothing to ship: no HDR file, no request. Generated once at boot
 * and pre-filtered by PMREM.
 */
import * as THREE from 'three';

/** An emissive panel. `intensity` is in the same arbitrary units throughout. */
function panel(scene, { w, h, x, y, z, rx = 0, ry = 0, rz = 0, colour, intensity }) {
  const mat = new THREE.MeshBasicMaterial({
    color: new THREE.Color(colour).multiplyScalar(intensity),
    side: THREE.DoubleSide,
    toneMapped: false,
  });
  const mesh = new THREE.Mesh(new THREE.PlaneGeometry(w, h), mat);
  mesh.position.set(x, y, z);
  mesh.rotation.set(rx, ry, rz);
  scene.add(mesh);
  return mesh;
}

export function buildStudioEnvironment(renderer) {
  const scene = new THREE.Scene();

  /* The shell. A bright, very slightly warm white — this is the ambient the
     whole room floats in, and it is what stops any surface reflecting void.
     Kept a little under 1 so the actual sources still have somewhere to go;
     an environment that is uniformly at full is a lightbox, and everything in
     it goes flat. */
  const shell = new THREE.Mesh(
    new THREE.BoxGeometry(28, 18, 28),
    new THREE.MeshBasicMaterial({
      color: new THREE.Color(0xf2f1ee).multiplyScalar(0.62),
      side: THREE.BackSide,
      toneMapped: false,
    })
  );
  scene.add(shell);

  /* CEILING. The gallery's diffusing roof. Large, even, slightly cool — the
     single biggest contributor, and the reason everything here has a soft
     gradient down its faces rather than a hotspot. */
  panel(scene, { w: 26, h: 26, x: 0, y: 8.6, z: 0, rx: Math.PI / 2, colour: 0xffffff, intensity: 1.55 });

  /* FLOOR RETURN. A pale floor throws a great deal back up, and that bounce is
     what fills the underside of a cill and the bottom rail of a door. Without
     it a dark frame goes black along its lower edge even in a bright room. */
  panel(scene, { w: 28, h: 28, x: 0, y: -8.9, z: 0, rx: -Math.PI / 2, colour: 0xf4f2ee, intensity: 0.95 });

  /* KEY. One large soft source, high, camera-left and slightly behind. This is
     the reflection that runs the length of an extrusion and reads as a
     softbox. Wide and short — a square source produces a square highlight and
     gives the trick away. */
  panel(scene, { w: 17, h: 6.0, x: -7.5, y: 6.0, z: 5.2, ry: Math.PI * 0.28, colour: 0xffffff, intensity: 2.6 });

  /* A tall window wall. Long vertical sources are what give glass its
     characteristic streak reflections; without something tall in the room the
     panes read as flat tinted plastic. In a light gallery this doubles as the
     reason the room feels daylit rather than lamplit. */
  panel(scene, { w: 1.6, h: 13, x: -11.4, y: 0.5, z: -1.5, ry: Math.PI / 2, colour: 0xffffff, intensity: 2.2 });
  panel(scene, { w: 1.1, h: 11, x: -11.4, y: 0.5, z: 4.5, ry: Math.PI / 2, colour: 0xf6fbff, intensity: 1.9 });

  /* FILL, opposite side. Broad and weak, only there so the shadow side of a
     frame keeps its shape instead of going to one flat tone. */
  panel(scene, { w: 13, h: 9, x: 9.4, y: 1.2, z: -3.5, ry: -Math.PI * 0.34, colour: 0xdfe9ee, intensity: 1.05 });

  /* THE FRONT SCRIM, AND IT IS NOT OPTIONAL IN A LIGHT ROOM.
     Everything above lights the room from above, behind and the sides, and
     the result was that every surface facing the CAMERA had nothing bright to
     reflect: at normal incidence a dielectric returns about four per cent, so
     the extruded mark rendered as a flat black cut-out with a nice rim and no
     faces. The fix is the scrim a photographer puts between the lens and the
     subject — a big soft source directly in front, at an intensity that lifts
     the front planes without flattening the modelling the key is doing.
     Two panels rather than one, slightly off-axis, so the reflection has a
     shape and a direction instead of being an even wash. */
  panel(scene, { w: 13, h: 8, x: -3.4, y: 1.6, z: 11.2, ry: Math.PI * 0.06, colour: 0xffffff, intensity: 1.5 });
  panel(scene, { w: 8, h: 6, x: 6.2, y: -1.2, z: 10.4, ry: -Math.PI * 0.1, colour: 0xeaf2f6, intensity: 0.95 });

  /* A DARK PANEL. This is the one that matters most in a light room and it is
     the exact inverse of the note in the dark version.
     In a bright environment every surface reflects something bright, so a
     polished frame has no contrast in it and reads as flat plastic. A large
     dark card gives the specular something to fall to — it is the negative
     fill a real product photographer tapes up just out of frame, and without
     it none of this metal reads as metal. */
  /* Kept small and pushed to the SIDES. The first version was a 14x9 card
     sitting square in front of the subject, and the result was that every
     camera-facing surface reflected a big dark rectangle: the extruded mark
     came out as a black silhouette with a bright rim, which is the exact
     failure the light room was supposed to cure. A negative fill belongs at
     the edge of the frame, shaping the turn of a surface — not across the
     face of it. */
  panel(scene, { w: 5, h: 8, x: 10.6, y: -0.5, z: 3.2, ry: -Math.PI / 2, colour: 0x33454c, intensity: 1.0 });
  panel(scene, { w: 5, h: 8, x: -10.6, y: -0.5, z: -6.0, ry: Math.PI / 2, colour: 0x3a4c53, intensity: 1.0 });
  panel(scene, { w: 9, h: 4, x: -2.0, y: -7.0, z: -9.0, rx: Math.PI * 0.22, colour: 0x415359, intensity: 1.0 });

  /* Fenster green, low and to one side, at an intensity that shows up in a
     reflection and nowhere else. This is why the aluminium picks up a green
     edge without a green light being aimed at anything. */
  panel(scene, { w: 7, h: 3, x: -6.5, y: -5.0, z: -6, rx: Math.PI * 0.18, ry: Math.PI * 0.2, colour: 0x2eac66, intensity: 1.4 });

  /* One warm source, small, to keep the whole thing from going monochrome
     cold. Barely visible, and its absence is very visible. */
  panel(scene, { w: 5, h: 3, x: 7.5, y: -4.0, z: 6.5, rx: -Math.PI * 0.2, ry: -Math.PI * 0.3, colour: 0xffe0bc, intensity: 1.25 });

  const pmrem = new THREE.PMREMGenerator(renderer);
  pmrem.compileEquirectangularShader();
  const target = pmrem.fromScene(scene, 0.02);
  pmrem.dispose();

  // The generator holds the render target; the scene itself is disposable.
  scene.traverse((n) => {
    if (n.isMesh) { n.geometry.dispose(); n.material.dispose(); }
  });

  return target.texture;
}
