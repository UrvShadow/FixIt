// FixIT — shared interactivity

document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const mobileMenu = document.querySelector('.nav-mobile');

  if (toggle && mobileMenu) {
    toggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('-open');
      const expanded = mobileMenu.classList.contains('-open');
      toggle.setAttribute('aria-expanded', String(expanded));
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => mobileMenu.classList.remove('-open'));
    });
  }
});
