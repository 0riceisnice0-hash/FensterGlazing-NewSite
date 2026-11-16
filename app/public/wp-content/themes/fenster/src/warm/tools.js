/* The renting letter and the picker.

   PRIVACY: nothing typed here leaves the browser. No network requests, no
   storage of any kind, nothing written into the URL, and no field value is
   ever put into an attribute. The three letter buttons carry `data-fg-cta`
   only, so the site's own click listener records their label and nothing else.
   Nothing here calls a tracking function. */

const reduceMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function readJson(scope, selector) {
  const node = scope.querySelector(selector);
  if (!node) return null;
  try {
    return JSON.parse(node.textContent || 'null');
  } catch (_error) {
    return null;
  }
}

/* "a", "a and b", "a, b and c". */
export function joinList(items) {
  if (items.length < 2) return items[0] || '';
  return `${items.slice(0, -1).join(', ')} and ${items[items.length - 1]}`;
}

function fill(text, values) {
  return String(text || '').replace(/\{(\w+)\}/g, (match, key) => (key in values ? values[key] : match));
}

function tidy(value) {
  return String(value || '').replace(/\s+/g, ' ').trim().replace(/[\s.,;:]+$/, '');
}

/* ---------------------------------------------------------------- Letter */

/* Blocks are paragraphs; `sep` joins their lines (a space within a paragraph,
   a line break under the sign-off). */
export function buildLetter(config, input, date) {
  const t = config.template || {};
  const fb = config.fallbacks || {};
  let rooms = tidy(input.rooms);
  /* "The two sash windows" reads as "It concerns the two sash windows." */
  if (/^[A-Z][a-z]/.test(rooms)) rooms = rooms.charAt(0).toLowerCase() + rooms.slice(1);
  const values = {
    landlord: tidy(input.landlord) || fb.landlord || '',
    address: tidy(input.address) || fb.address || '',
    rooms,
    /* Each problem and each request is a whole sentence in the data, so any
       combination reads correctly: they are set side by side, not strung
       together with commas and "and". */
    problems: input.problems.map((key) => config.problems[key]).filter(Boolean).join(' '),
    asks: input.asks.map((key) => config.asks[key]).filter(Boolean).join(' '),
  };
  const para = (...lines) => ({ lines: lines.filter(Boolean), sep: ' ' });
  const blocks = [
    { lines: [date], sep: ' ', date: true },
    para(fill(t.greeting, values)),
    para(fill(t.opening, values), rooms && fill(t.which, values)),
    /* The follow-on line only makes sense after a problem has been named. */
    para(values.problems && fill(t.problem, values), values.problems && fill(t.effect, values)),
    para(values.asks && fill(t.ask, values)),
    para(fill(t.access, values)),
    { lines: [t.sign, tidy(input.tenant) || fb.tenant || ''].filter(Boolean), sep: '\n', sign: true },
  ].filter((block) => block.lines.length);
  return {
    blocks,
    subject: fill(config.subject, values),
    text: blocks.map((block) => block.lines.join(block.sep)).join('\n\n'),
  };
}

function renderBlocks(target, blocks) {
  target.replaceChildren(
    ...blocks.map((block) => {
      const p = document.createElement('p');
      if (block.date) p.className = 'fg-warm-letter__date';
      if (block.sign) p.className = 'fg-warm-letter__sign';
      block.lines.forEach((line, i) => {
        if (i) p.append(block.sep === '\n' ? document.createElement('br') : ' ');
        p.append(line);
      });
      return p;
    })
  );
}

async function copyText(text) {
  try {
    if (navigator.clipboard && window.isSecureContext) {
      await navigator.clipboard.writeText(text);
      return true;
    }
  } catch (_error) {}
  const area = document.createElement('textarea');
  area.value = text;
  area.setAttribute('readonly', '');
  area.style.cssText = 'position:fixed;top:0;left:-9999px;opacity:0';
  document.body.append(area);
  area.select();
  let ok = false;
  try {
    ok = document.execCommand('copy');
  } catch (_error) {}
  area.remove();
  return ok;
}

function printLetter(blocks) {
  document.querySelectorAll('.fg-warm-letter-print').forEach((old) => old.remove());
  const sheet = document.createElement('div');
  sheet.className = 'fg-warm-letter-print';
  renderBlocks(sheet, blocks);
  document.body.append(sheet);
  document.documentElement.classList.add('fg-warm-letter-printing');
  const cleanup = () => {
    document.documentElement.classList.remove('fg-warm-letter-printing');
    sheet.remove();
    window.removeEventListener('afterprint', cleanup);
  };
  window.addEventListener('afterprint', cleanup);
  /* The sheet is invisible on screen, so it is safe to leave it until
     afterprint; a later print replaces it in any case. */
  window.print();
}

function initLetter(tool) {
  const config = readJson(tool, '[data-fg-warm-letter-data]');
  const controls = tool.querySelector('[data-fg-warm-letter-controls]');
  const actions = tool.querySelector('[data-fg-warm-letter-actions]');
  const paper = tool.querySelector('[data-fg-warm-letter-paper]');
  const status = tool.querySelector('[data-fg-warm-letter-status]');
  const copyButton = tool.querySelector('[data-fg-warm-letter-copy]');
  if (!config || !controls || !actions || !paper) return;

  const fields = {};
  controls.querySelectorAll('[data-fg-warm-letter-field]').forEach((field) => {
    fields[field.getAttribute('data-fg-warm-letter-field')] = field;
  });
  const ticked = (selector) => Array.from(controls.querySelectorAll(`${selector}:checked`), (box) => box.value);
  const today = new Intl.DateTimeFormat('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }).format(new Date());

  const current = () =>
    buildLetter(
      config,
      {
        tenant: fields.tenant ? fields.tenant.value : '',
        landlord: fields.landlord ? fields.landlord.value : '',
        address: fields.address ? fields.address.value : '',
        rooms: fields.rooms ? fields.rooms.value : '',
        problems: ticked('[data-fg-warm-letter-problem]'),
        asks: ticked('[data-fg-warm-letter-ask]'),
      },
      today
    );

  const render = () => renderBlocks(paper, current().blocks);
  controls.addEventListener('input', render);
  controls.addEventListener('change', render);
  controls.hidden = false;
  actions.hidden = false;
  tool.classList.add('is-live');
  render();

  let copiedTimer = 0;
  if (copyButton) {
    copyButton.addEventListener('click', async () => {
      const ok = await copyText(current().text);
      if (!ok) {
        /* Leave the letter selected so Ctrl+C still works. */
        const range = document.createRange();
        range.selectNodeContents(paper);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        return;
      }
      window.clearTimeout(copiedTimer);
      copyButton.textContent = config.copied;
      copyButton.classList.add('is-done');
      if (status) status.textContent = config.copied;
      copiedTimer = window.setTimeout(() => {
        copyButton.textContent = config.copy;
        copyButton.classList.remove('is-done');
        if (status) status.textContent = '';
      }, 2000);
    });
  }

  const email = tool.querySelector('[data-fg-warm-letter-email]');
  if (email) {
    email.addEventListener('click', () => {
      const letter = current();
      /* No recipient: the tenant chooses who it goes to in their own mail app. */
      window.location.href = `mailto:?subject=${encodeURIComponent(letter.subject)}&body=${encodeURIComponent(letter.text.replace(/\n/g, '\r\n'))}`;
    });
  }

  const print = tool.querySelector('[data-fg-warm-letter-print]');
  if (print) print.addEventListener('click', () => printLetter(current().blocks));
}

/* ---------------------------------------------------------------- Picker */

/* The first result whose every `when` key includes the answer wins. */
export function matchResult(results, answers) {
  return (
    results.find((result) =>
      Object.entries(result.when || {}).every(([key, allowed]) => Array.isArray(allowed) && allowed.includes(answers[key]))
    ) || null
  );
}

/* "MK11", "mk11 1aa" -> "MK11"; anything that is not a UK postcode -> ''. */
export function postcodeDistrict(value) {
  const clean = String(value || '').toUpperCase().replace(/\s+/g, '');
  const full = clean.match(/^([A-Z]{1,2}\d[A-Z\d]?)(\d[A-Z]{2})$/);
  if (full) return full[1];
  return /^[A-Z]{1,2}\d[A-Z\d]?$/.test(clean) ? clean : '';
}

export function postcodeVerdict(config, value) {
  const district = postcodeDistrict(value);
  if (!district) return { key: 'invalid', district: '' };
  const districts = config.districts || [];
  if (districts.includes(district)) return { key: 'yes', district };
  const letters = (code) => (code.match(/^[A-Z]+/) || [''])[0];
  if (districts.some((d) => letters(d) === letters(district))) return { key: 'near', district };
  return { key: 'no', district };
}

function initPicker(section) {
  const config = readJson(section, '[data-fg-warm-picker-data]');
  const questions = section.querySelector('[data-fg-warm-picker-questions]');
  const hint = section.querySelector('[data-fg-warm-picker-hint]');
  const result = section.querySelector('[data-fg-warm-picker-result]');
  if (!config || !questions || !hint || !result) return;

  const sets = Array.from(questions.querySelectorAll('[data-fg-warm-question]'));
  const keys = sets.map((set) => set.getAttribute('data-fg-warm-question'));
  const title = result.querySelector('[data-fg-warm-picker-title]');
  const copy = result.querySelector('[data-fg-warm-picker-copy]');
  const primary = result.querySelector('[data-fg-warm-picker-primary]');
  const secondary = result.querySelector('[data-fg-warm-picker-secondary]');
  const status = section.querySelector('[data-fg-warm-picker-status]');
  const restart = section.querySelector('[data-fg-warm-picker-restart]');
  const eyebrow = result.querySelector('.eyebrow');
  let shown = null;

  const answers = () => {
    const out = {};
    sets.forEach((set, i) => {
      const picked = set.querySelector('input:checked');
      if (picked) out[keys[i]] = picked.value;
    });
    return out;
  };

  const update = () => {
    const given = answers();
    const count = Object.keys(given).length;
    section.querySelectorAll('[data-fg-warm-picker-progress]').forEach((item) => {
      item.classList.toggle('is-done', item.getAttribute('data-fg-warm-picker-progress') in given);
    });
    if (restart) restart.classList.toggle('is-shown', count > 0);
    const match = count === keys.length ? matchResult(config.results, given) : null;
    hint.hidden = Boolean(match);
    result.hidden = !match;
    if (!match) {
      shown = null;
      return;
    }
    if (match === shown) return;
    shown = match;
    title.textContent = match.title;
    copy.textContent = match.copy;
    primary.textContent = match.primary.label;
    primary.href = match.primary.url;
    secondary.textContent = match.secondary.label;
    secondary.href = match.secondary.url;
    if (status) status.textContent = `${eyebrow ? eyebrow.textContent : ''}: ${match.title}`;
    if (!reduceMotion()) {
      result.classList.remove('is-in');
      void result.offsetWidth;
      result.classList.add('is-in');
    }
  };

  questions.addEventListener('change', update);
  if (restart) {
    restart.addEventListener('click', () => {
      questions.querySelectorAll('input:checked').forEach((input) => {
        input.checked = false;
      });
      if (status) status.textContent = '';
      update();
      const first = questions.querySelector('input');
      if (first) first.focus();
    });
  }
  questions.hidden = false;
  update();

  /* Do we cover you? Read from the box, answered in the page, never kept. */
  const postcode = section.querySelector('[data-fg-warm-postcode]');
  if (!postcode || !config.postcode) return;
  const input = postcode.querySelector('[data-fg-warm-postcode-input]');
  const check = postcode.querySelector('[data-fg-warm-postcode-check]');
  const message = postcode.querySelector('[data-fg-warm-postcode-message]');
  const run = () => {
    const verdict = postcodeVerdict(config.postcode, input.value);
    const text = fill(config.postcode[verdict.key], { district: verdict.district });
    message.setAttribute('data-verdict', verdict.key);
    /* Clear first so the same answer twice is still read out. */
    message.textContent = '';
    window.setTimeout(() => {
      message.textContent = text;
    }, 60);
  };
  check.addEventListener('click', run);
  input.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
      run();
    }
  });
  postcode.hidden = false;
}

export function initTools(root) {
  if (!root) return;
  root.querySelectorAll('[data-fg-warm-letter]').forEach(initLetter);
  root.querySelectorAll('[data-fg-warm-picker]').forEach(initPicker);
}
