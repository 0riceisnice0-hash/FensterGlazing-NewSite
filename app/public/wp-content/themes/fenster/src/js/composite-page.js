/* The page's controls do not intercept wheel, touch or document scrolling. */
const page = document.querySelector('[data-composite-page]');
if (page) {
  const range = page.querySelector('[data-cdoor-range]');
  if (range) {
    const tabs = [...range.querySelectorAll('[data-cdoor-tab]')];
    const panels = [...range.querySelectorAll('[data-cdoor-collection]')];
    const filter = range.querySelector('[data-cdoor-glass]');
    const count = range.querySelector('[data-cdoor-count]');
    const prev = range.querySelector('[data-cdoor-prev]');
    const next = range.querySelector('[data-cdoor-next]');
    const phone = matchMedia('(max-width: 600px)');
    let active = 0;
    let offset = 0;
    const render = () => {
      const size = phone.matches ? 6 : 10;
      const cards = [...panels[active].querySelectorAll('[data-cdoor-style]')];
      const matches = cards.filter(card => filter.value === '' || card.dataset.glass === filter.value);
      offset = Math.min(offset, Math.max(0, Math.ceil(matches.length / size) - 1));
      panels.forEach((panel, index) => { panel.hidden = index !== active; });
      tabs.forEach((tab, index) => {
        tab.setAttribute('aria-selected', String(index === active));
        tab.tabIndex = index === active ? 0 : -1;
      });
      const shown = new Set(matches.slice(offset * size, (offset + 1) * size));
      cards.forEach(card => { card.hidden = !shown.has(card); });
      count.textContent = matches.length
        ? `${offset * size + 1}–${Math.min((offset + 1) * size, matches.length)} of ${matches.length} styles`
        : 'No doors match this glass choice. Try another collection or amount of glass.';
      prev.disabled = offset === 0;
      next.disabled = (offset + 1) * size >= matches.length;
    };
    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => { active = index; offset = 0; render(); });
      tab.addEventListener('keydown', event => {
        let target;
        if (event.key === 'ArrowRight') target = (index + 1) % tabs.length;
        if (event.key === 'ArrowLeft') target = (index - 1 + tabs.length) % tabs.length;
        if (event.key === 'Home') target = 0;
        if (event.key === 'End') target = tabs.length - 1;
        if (target === undefined) return;
        event.preventDefault(); active = target; offset = 0; render(); tabs[target].focus();
      });
    });
    filter.addEventListener('change', () => { offset = 0; render(); });
    prev.addEventListener('click', () => { offset -= 1; render(); });
    next.addEventListener('click', () => { offset += 1; render(); });
    phone.addEventListener('change', () => { offset = 0; render(); });
    panels.forEach((panel, index) => {
      panel.setAttribute('role', 'tabpanel');
      panel.setAttribute('aria-labelledby', `cdoor-tab-${index}`);
    });
    render();
    range.classList.add('is-enhanced');
    range.querySelector('[data-cdoor-range-tools]').hidden = false;
    range.querySelector('[data-cdoor-range-footer]').hidden = false;
  }

  page.querySelectorAll('[data-cdoor-picker]').forEach(picker => {
    const image = picker.querySelector('.fg-cdoor-choice__image');
    const name = picker.querySelector('[data-cdoor-name]');
    const kind = picker.querySelector('[data-cdoor-kind]');
    const choices = [...picker.querySelectorAll('[data-cdoor-choice]')];
    let requested = 0;
    choices.forEach(choice => choice.addEventListener('click', () => {
      const token = ++requested;
      const candidate = new Image();
      candidate.onload = () => {
        if (token !== requested) return;
        image.removeAttribute('srcset');
        image.src = candidate.src;
        image.alt = `${choice.dataset.name}: ${choice.dataset.kind.toLowerCase()}`;
        name.textContent = choice.dataset.name;
        kind.textContent = choice.dataset.kind;
        choices.forEach(button => button.setAttribute('aria-pressed', String(button === choice)));
      };
      candidate.onerror = () => {
        if (token === requested) kind.textContent = 'This preview could not load. Please try another finish.';
      };
      candidate.src = choice.dataset.image;
    }));
  });

  const questions = [...page.querySelectorAll('.fg-cdoor-faq details')];
  questions.forEach(detail => detail.addEventListener('toggle', () => {
    if (detail.open) questions.forEach(other => { if (other !== detail) other.open = false; });
  }));
  const assist = page.querySelector('[data-cdoor-assist]');
  // Shared quiz links must reveal their result even though the optional finder
  // is collapsed for visitors who have not asked to use it.
  if (assist && new URLSearchParams(location.search).has('door')) assist.open = true;
}
