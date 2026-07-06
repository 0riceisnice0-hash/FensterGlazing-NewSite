const cp = require('node:child_process');
const fs = require('node:fs');
const path = require('node:path');
const ffmpeg = require('ffmpeg-static');
const dir = path.join(__dirname, '..', 'assets', 'videos', 'product-scroll');
const sourceDir = process.env.FENSTER_VIDEO_SOURCE_DIR
  ? path.resolve(process.env.FENSTER_VIDEO_SOURCE_DIR)
  : path.resolve(__dirname, '..', '..', '..', '..', '..', '..', 'source-assets', 'fenster-theme-public-removed');
const videos = [
  { file: 'bifold-video.mp4', alphaSource: 'bifold-video.source.mov', webm: 'bifold-video.webm', key: '0.08:0.03' },
  { file: 'classic-door-turntable.mp4', webm: 'classic-door-turntable.webm', key: '0.28:0.12' },
  { file: 'heritage.mp4', webm: 'heritage.webm', key: '0.28:0.12' },
  { file: 'prestige-window.mp4', webm: 'prestige-window.webm', key: '0.20:0.10' },
];

for (const video of videos) {
  const file = video.file;
  const input = path.join(dir, file);
  const temp = path.join(dir, file.replace(/\.mp4$/, '.scrub.mp4'));
  const mp4Source = path.join(sourceDir, file.replace(/\.mp4$/, '.source.mp4'));
  const alphaSource = video.alphaSource ? path.join(sourceDir, video.alphaSource) : '';
  const source = alphaSource && fs.existsSync(alphaSource) ? alphaSource : (fs.existsSync(mp4Source) ? mp4Source : input);
  const args = [
    '-y', '-i', source,
    '-an',
    '-vf', 'scale=900:-2',
    '-c:v', 'libx264',
    '-preset', 'slow',
    '-crf', '23',
    '-pix_fmt', 'yuv420p',
    '-movflags', '+faststart',
    '-g', '6',
    '-keyint_min', '6',
    '-sc_threshold', '0',
    temp,
  ];
  console.log(`\nEncoding ${file}`);
  cp.execFileSync(ffmpeg, args, { stdio: 'inherit' });
  fs.copyFileSync(temp, input);
  fs.unlinkSync(temp);
  const before = fs.statSync(source).size;
  const after = fs.statSync(input).size;
  console.log(`${file}: ${before} -> ${after}`);

  if (video.webm) {
    const webm = path.join(dir, video.webm);
    const webmTemp = webm.replace(/\.webm$/, '.scrub.webm');
    const webmSource = alphaSource && fs.existsSync(alphaSource) ? alphaSource : source;
    const webmArgs = [
      '-y', '-i', webmSource,
      '-an',
      '-vf', `scale=900:-2,colorkey=0xFFFFFF:${video.key || '0.08:0.03'},format=yuva420p`,
      '-c:v', 'libvpx-vp9',
      '-pix_fmt', 'yuva420p',
      '-b:v', '0',
      '-crf', '30',
      '-deadline', 'good',
      '-cpu-used', '2',
      '-g', '6',
      '-auto-alt-ref', '0',
      webmTemp,
    ];
    console.log(`\nEncoding ${video.webm}`);
    cp.execFileSync(ffmpeg, webmArgs, { stdio: 'inherit' });
    fs.copyFileSync(webmTemp, webm);
    fs.unlinkSync(webmTemp);
    console.log(`${video.webm}: ${fs.statSync(webmSource).size} -> ${fs.statSync(webm).size}`);
  }
}
