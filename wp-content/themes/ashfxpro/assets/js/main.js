(function () {
  'use strict';

  /* ── Nav menu ── */
  var btn     = document.getElementById('nav-menu-btn');
  var nav     = document.getElementById('site-nav');
  var overlay = document.getElementById('nav-overlay');

  if (btn && nav && overlay) {

    function openMenu() {
      btn.setAttribute('aria-expanded', 'true');
      btn.setAttribute('aria-label', 'Закрыть меню');
      nav.classList.add('is-open');
      nav.setAttribute('aria-hidden', 'false');
      overlay.classList.add('is-visible');
      overlay.setAttribute('aria-hidden', 'false');
      // trap focus: first focusable link
      var first = nav.querySelector('a, button');
      if (first) first.focus();
    }

    function closeMenu() {
      btn.setAttribute('aria-expanded', 'false');
      btn.setAttribute('aria-label', 'Открыть меню');
      nav.classList.remove('is-open');
      nav.setAttribute('aria-hidden', 'true');
      overlay.classList.remove('is-visible');
      overlay.setAttribute('aria-hidden', 'true');
      btn.focus();
    }

    function toggleMenu() {
      btn.getAttribute('aria-expanded') === 'true' ? closeMenu() : openMenu();
    }

    btn.addEventListener('click', toggleMenu);

    /* Close on overlay click */
    overlay.addEventListener('click', closeMenu);

    /* Close on Escape */
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && btn.getAttribute('aria-expanded') === 'true') {
        closeMenu();
      }
    });

    /* Close when clicking a nav link */
    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });
  }

  /* ── Theme toggle ── */
  var themeBtn  = document.querySelector('.site-nav__theme-btn');
  if (themeBtn) {
    var themeImg  = themeBtn.querySelector('img');
    var iconDark  = themeBtn.dataset.iconDark;   // sun  — shown in dark mode (switch to light)
    var iconLight = themeBtn.dataset.iconLight;  // moon — shown in light mode (switch to dark)

    function applyTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      localStorage.setItem('ashfxpro_theme', theme);
      if (themeImg) themeImg.src = theme === 'dark' ? iconDark : iconLight;
    }

    // Sync icon with theme already set by the anti-FOUC script
    var initTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    if (themeImg) themeImg.src = initTheme === 'dark' ? iconDark : iconLight;

    themeBtn.addEventListener('click', function () {
      var cur = document.documentElement.getAttribute('data-theme') || 'dark';
      applyTheme(cur === 'dark' ? 'light' : 'dark');
    });
  }

  /* ── Carousel drag-to-scroll ── */
  document.querySelectorAll('.js-carousel').forEach(function (el) {
    var isDown = false, startX, scrollLeft;

    el.addEventListener('mousedown', function (e) {
      isDown = true;
      el.classList.add('dragging');
      startX    = e.pageX - el.offsetLeft;
      scrollLeft = el.scrollLeft;
    });

    el.addEventListener('mouseleave', function () { isDown = false; el.classList.remove('dragging'); });
    el.addEventListener('mouseup',    function () { isDown = false; el.classList.remove('dragging'); });

    el.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      e.preventDefault();
      var x = e.pageX - el.offsetLeft;
      el.scrollLeft = scrollLeft - (x - startX) * 1.5;
    });

    el.addEventListener('touchstart', function (e) {
      startX    = e.touches[0].pageX - el.offsetLeft;
      scrollLeft = el.scrollLeft;
    }, { passive: true });

    el.addEventListener('touchmove', function (e) {
      var x = e.touches[0].pageX - el.offsetLeft;
      el.scrollLeft = scrollLeft - (x - startX) * 1.5;
    }, { passive: true });
  });

})();
