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

  /* ── Donut chart ── */
  var donutSvg  = document.getElementById('stat-donut-svg');
  var donutData = window.ashfxproDonutData;
  if (donutSvg && donutData && donutData.segments) {
    var CX = 134, CY = 134, R = 125, SW = 3, GAP = 5;
    var C     = 2 * Math.PI * R;
    var total = donutData.segments.reduce(function (s, seg) { return s + seg.value; }, 0);
    var cumPct = 0;
    var drawn  = [];

    donutData.segments.forEach(function (seg) {
      var pct    = seg.value / total;
      var segLen = Math.max(0, pct * C - GAP);
      var rotDeg = -90 + cumPct * 360;

      var circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
      circle.setAttribute('cx', CX);
      circle.setAttribute('cy', CY);
      circle.setAttribute('r', R);
      circle.setAttribute('fill', 'none');
      circle.setAttribute('stroke', seg.color);
      circle.setAttribute('stroke-width', SW);
      circle.setAttribute('stroke-linecap', 'butt');
      circle.setAttribute('transform', 'rotate(' + rotDeg + ' ' + CX + ' ' + CY + ')');
      circle.style.strokeDasharray = '0 ' + C;
      donutSvg.appendChild(circle);
      drawn.push({ el: circle, segLen: segLen });
      cumPct += pct;
    });

    var counterEl     = document.querySelector('.stat-chart-num');
    var counterTarget = donutData.total_count ? parseInt(donutData.total_count, 10) : 0;
    if (counterEl) counterEl.textContent = '0';

    // Two rAF frames ensure elements are in the DOM before transition starts
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        // Donut segments
        drawn.forEach(function (d, i) {
          d.el.style.transition = 'stroke-dasharray 1s ease-out ' + (i * 80) + 'ms';
          d.el.style.strokeDasharray = d.segLen + ' ' + C;
        });

        // Counter: 0 → total_count, 1.5s cubic ease-out
        if (counterEl && counterTarget > 0) {
          var startTs  = null;
          var duration = 1500;
          function easeOut(t) { return 1 - Math.pow(1 - t, 3); }
          function tick(ts) {
            if (!startTs) startTs = ts;
            var progress = Math.min((ts - startTs) / duration, 1);
            counterEl.textContent = Math.round(easeOut(progress) * counterTarget);
            if (progress < 1) { requestAnimationFrame(tick); }
            else { counterEl.textContent = counterTarget; }
          }
          requestAnimationFrame(tick);
        }
      });
    });
  }

  /* ── Bar chart ── */
  var barItems = document.querySelectorAll('.bar-item[data-bar-h]');
  if (barItems.length) {
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        barItems.forEach(function (bar, i) {
          var targetH = parseInt(bar.dataset.barH, 10);
          bar.style.transition = 'height 0.8s ease-out ' + (i * 80) + 'ms';
          bar.style.height = targetH + 'px';
        });
      });
    });
  }

  /* ── Carousel drag-to-scroll ── */
  document.querySelectorAll('.js-carousel').forEach(function (el) {
    var isDown = false, isDragging = false, startX, startY, scrollLeft;
    var DRAG_THRESHOLD = 5;

    // ── Mouse ──
    el.addEventListener('mousedown', function (e) {
      isDown     = true;
      isDragging = false;
      el.classList.add('dragging');
      startX     = e.pageX - el.offsetLeft;
      scrollLeft = el.scrollLeft;
    });

    el.addEventListener('mouseleave', function () { isDown = false; isDragging = false; el.classList.remove('dragging'); });
    el.addEventListener('mouseup',    function () { isDown = false; isDragging = false; el.classList.remove('dragging'); });

    el.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      var x = e.pageX - el.offsetLeft;
      if (!isDragging && Math.abs(x - startX) > DRAG_THRESHOLD) isDragging = true;
      if (!isDragging) return;
      e.preventDefault();
      el.scrollLeft = scrollLeft - (x - startX) * 1.5;
    });

    // Prevent <a> link activation after a drag
    el.addEventListener('click', function (e) {
      if (isDragging) e.preventDefault();
    }, true);

    // ── Touch (direction-aware) ──
    var touchStartX, touchStartY, touchScrollLeft, touchAxisLocked = null;

    el.addEventListener('touchstart', function (e) {
      touchStartX    = e.touches[0].pageX;
      touchStartY    = e.touches[0].pageY;
      touchScrollLeft = el.scrollLeft;
      touchAxisLocked = null;
    }, { passive: true });

    el.addEventListener('touchmove', function (e) {
      var dx = e.touches[0].pageX - touchStartX;
      var dy = e.touches[0].pageY - touchStartY;

      if (touchAxisLocked === null) {
        if (Math.abs(dx) < 5 && Math.abs(dy) < 5) return;
        touchAxisLocked = Math.abs(dx) >= Math.abs(dy) ? 'x' : 'y';
      }

      if (touchAxisLocked === 'x') {
        e.preventDefault();
        el.scrollLeft = touchScrollLeft - dx * 1.5;
      }
    }, { passive: false });
  });

  /* ── Fonda parallax ── */
  (function () {
    var section = document.querySelector('.section-fonda');
    var words   = document.querySelectorAll('.section-fonda .fonda-word');
    if (!section || !words.length) return;

    function update() {
      var rect  = section.getBoundingClientRect();
      var winH  = window.innerHeight;
      var inView = rect.top < winH && rect.top + rect.height > 0;

      words.forEach(function (el) {
        var d   = parseFloat(el.dataset.distance) || 100;
        var dir = el.dataset.direction;
        if (!inView) {
          el.style.transform = 'translateX(' + (dir === 'left' ? -d : d) + 'px)';
          return;
        }
        var progress = Math.max(0, Math.min(1, (winH - rect.top) / (winH + rect.height)));
        var speed    = parseFloat(el.dataset.speed) || 1;
        var tx = dir === 'left'
          ? -d * (0.2 - progress * speed)
          :  d * (0.2 - progress * speed);
        el.style.transform = 'translateX(' + tx + 'px)';
      });
    }

    var tid;
    function throttled() {
      if (!tid) tid = setTimeout(function () { update(); tid = null; }, 16);
    }

    window.addEventListener('scroll', throttled, { passive: true });
    window.addEventListener('resize', throttled, { passive: true });
    update();
  }());

  /* ── Forecast card scale effect ── */
  (function () {
    var cards = document.querySelectorAll('.section-forecasts .card-item');
    if (!cards.length) return;

    function update() {
      var triggerLine = window.innerHeight / 3;
      cards.forEach(function (card) {
        var rect = card.getBoundingClientRect();
        var dist = triggerLine - rect.top;
        if (dist > 0) {
          card.style.transform = 'scale(' + Math.max(0.75, 1 - dist * 0.001) + ')';
          card.style.transition = 'transform 0.1s ease-out';
        } else {
          card.style.transform = 'scale(1)';
          card.style.transition = 'transform 0.2s ease-out';
        }
      });
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    update();
  }());

  /* ── Publications carousel: vertical-scroll → horizontal shift ── */
  var pubCarousel = document.querySelector('.publications-carousel');
  if (pubCarousel) {
    var prevScrollY = window.scrollY;
    var scrollTicking = false;

    window.addEventListener('scroll', function () {
      if (scrollTicking) return;
      scrollTicking = true;
      requestAnimationFrame(function () {
        var dy = window.scrollY - prevScrollY;
        prevScrollY = window.scrollY;
        var rect = pubCarousel.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          pubCarousel.scrollLeft = Math.max(0, pubCarousel.scrollLeft + dy * 0.5);
        }
        scrollTicking = false;
      });
    }, { passive: true });
  }

})();
