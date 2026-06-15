const revealSelectors = [
  'main > header',
  'main > section',
  'main > article',
  '.hero-slider-section',
  '.info-section',
  '.info-wakif',
  '.quote-wakaf',
  '.macam-program',
  '.artikel-section',
  '.moreprogram',
  '.moreartikel',
  '.site-footer',
  '.program-card',
  '.artikel-card',
  '.artikel-list-card',
  '.tentang-vm-card',
  '.tentang-structure-item',
  '.admin-card',
  '.slider-admin-card',
  '.slider-edit-card',
];

let wakafLoader;

function ensureWakafLoader() {
  if (wakafLoader) {
    return wakafLoader;
  }

  wakafLoader = document.createElement('div');
  wakafLoader.className = 'wakaf-loader';
  wakafLoader.setAttribute('aria-hidden', 'true');
  wakafLoader.innerHTML = '<img src="/image/Logonavbar.png" alt="">';
  document.body.appendChild(wakafLoader);

  return wakafLoader;
}

function showWakafLoader() {
  ensureWakafLoader().classList.add('is-active');
}

function hideWakafLoader() {
  ensureWakafLoader().classList.remove('is-active');
}

function prepareWakafLoader() {
  ensureWakafLoader();
  hideWakafLoader();

  window.addEventListener('pageshow', hideWakafLoader);

  document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', showWakafLoader);
  });

  document.querySelectorAll('a[href]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const href = link.getAttribute('href');
      const isNewTab = link.target === '_blank' || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey;

      if (!href || href.startsWith('#') || href.startsWith('javascript:') || isNewTab) {
        return;
      }

      showWakafLoader();
    });
  });
}

function prepareStackReveal() {
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const elements = Array.from(document.querySelectorAll(revealSelectors.join(',')))
    .filter((element) => !element.closest('.navbar') && !element.classList.contains('stack-reveal'));

  elements.forEach((element, index) => {
    element.classList.add('stack-reveal');
    element.style.setProperty('--stack-delay', `${Math.min(index % 6, 5) * 80}ms`);
  });

  if (reducedMotion || !('IntersectionObserver' in window)) {
    elements.forEach((element) => element.classList.add('is-visible'));
    return;
  }

  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, {
    rootMargin: '0px 0px -12% 0px',
    threshold: 0.12,
  });

  elements.forEach((element) => revealObserver.observe(element));
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    prepareWakafLoader();
    prepareStackReveal();
  });
} else {
  prepareWakafLoader();
  prepareStackReveal();
}
