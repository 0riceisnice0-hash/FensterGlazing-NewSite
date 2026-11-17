/**
 * The winter guide's script, built to assets/warm/warm.js by
 * `npm run build:warm`. Two jobs, both optional: the page reads the same
 * without it.
 *
 * - The diagrams only animate while they are on screen.
 * - The landlord letter gets a "Copy the letter" button. Nothing is sent or
 *   stored anywhere: it copies text that is already on the page.
 */
(function () {
  var figures = document.querySelectorAll('[data-fgw-anim]');

  if (figures.length && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        entry.target.classList.toggle('is-waiting', !entry.isIntersecting);
      });
    }, { rootMargin: '0px 0px -10% 0px' });

    figures.forEach(function (figure) {
      figure.classList.add('is-waiting');
      observer.observe(figure);
    });
  }

  document.querySelectorAll('[data-fgw-copy]').forEach(function (button) {
    var letter = button.closest('.fgw-letter');
    var text = letter && letter.querySelector('[data-fgw-letter]');

    if (!text || !navigator.clipboard || !window.isSecureContext) {
      return;
    }

    var label = button.textContent;
    button.hidden = false;
    button.addEventListener('click', function () {
      var paragraphs = Array.prototype.map.call(text.querySelectorAll('p'), function (p) {
        return p.innerText.trim();
      });

      navigator.clipboard.writeText(paragraphs.join('\n\n')).then(function () {
        button.textContent = button.getAttribute('data-fgw-copied') || label;
        button.classList.add('is-copied');
        window.setTimeout(function () {
          button.textContent = label;
          button.classList.remove('is-copied');
        }, 2400);
      });
    });
  });
})();
