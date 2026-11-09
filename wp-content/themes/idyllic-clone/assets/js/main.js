/**
 * Idyllic Clone — JS principal (vanilla, sem jQuery).
 *
 * Cuida de: menu mobile, busca expansível, sticky "is-sticky",
 * "voltar ao topo" e contadores animados da seção stats.
 *
 * Exposto como window.idyllicClone para uso do slider.js.
 */
(function () {
	'use strict';

	var app = {};

	/* ---------- Menu mobile (hambúrguer) ---------- */
	app.initMenu = function () {
		var toggles = document.querySelectorAll('.menu-toggle');

		toggles.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var nav = btn.closest('.main-header').querySelector('.main-navigation');
				if (!nav) {
					return;
				}
				var open = nav.classList.toggle('is-open');
				btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
		});
	};

	/* ---------- Busca expansível ---------- */
	app.initSearch = function () {
		var btn = document.getElementById('search-toggle');

		if (!btn) {
			return;
		}

		btn.addEventListener('click', function () {
			var box = document.getElementById('search-box');

			if (!box) {
				return;
			}

			var open = box.classList.toggle('is-open');
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');

			if (open) {
				var field = box.querySelector('.search-field');
				if (field) {
					field.focus();
				}
			}
		});
	};

	/* ---------- Sticky header + botão voltar ao topo ---------- */
	app.initScrollEffects = function () {
		var header = document.getElementById('sticky-header');
		var toTop = document.querySelector('.go-to-top');
		var mark = 'is-sticky';
		var ticking = false;
		var lastTop = -1;

		if (!header && !toTop) {
			return;
		}

		function onScroll() {
			var top = window.scrollY || 0;

			if (header && top > 140) {
				header.classList.add(mark);
			} else if (header) {
				header.classList.remove(mark);
			}

			if (toTop) {
				toTop.classList.toggle('is-visible', top > 600);
			}

			lastTop = top;
			ticking = false;
		}

		window.addEventListener('scroll', function () {
			if (!ticking) {
				window.requestAnimationFrame(onScroll);
				ticking = true;
			}
		}, { passive: true });

		onScroll();

		if (toTop) {
			toTop.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		}
	};

	/* ---------- Contadores animados ---------- */
	app.initCounters = function () {
		var counters = document.querySelectorAll('.jsn-idyllic-counter[data-target]');
		var duration = 1600;

		if (counters.length === 0 || !('IntersectionObserver' in window)) {
			counters.forEach(function (el) {
				el.textContent = el.getAttribute('data-target');
			});
			return;
		}

		function animate(el) {
			var target = parseInt(el.getAttribute('data-target'), 10) || 0;
			var start = null;

			function step(ts) {
				if (start === null) {
					start = ts;
				}
				var progress = Math.min((ts - start) / duration, 1);
				var eased = 1 - Math.pow(1 - progress, 3);
				el.textContent = String(Math.round(target * eased));
				if (progress < 1) {
					window.requestAnimationFrame(step);
				}
			}

			window.requestAnimationFrame(step);
		}

		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					animate(entry.target);
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.4 });

		counters.forEach(function (el) {
			observer.observe(el);
		});
	};

	/* ---------- Slider genérico (hero e depoimentos) ---------- */
	app.createSlider = function (container, options) {
		var settings = Object.assign({ auto: true, interval: 6000 }, options || {});
		var slides = container.querySelectorAll('.jsn-idyllic-slide, .jsn-idyllic-testimonial-slide');
		var dotsBox = container.querySelector('.slider-controls, .testimonial-controls');

		if (slides.length === 0) {
			return null;
		}

		var current = 0;
		var timer = null;

		function show(index) {
			slides.forEach(function (slide, i) {
				slide.classList.toggle('is-active', i === index);
				slide.setAttribute('aria-hidden', i === index ? 'false' : 'true');
			});

			if (dotsBox) {
				var dots = dotsBox.querySelectorAll('.slider-control');
				dots.forEach(function (dot, i) {
					dot.classList.toggle('is-active', i === index);
					dot.setAttribute('aria-current', i === index ? 'true' : 'false');
				});
			}

			current = index;
		}

		function goTo(index) {
			var total = slides.length;
			show((index % total + total) % total);
			restart();
		}

		function next() { goTo(current + 1); }
		function prev() { goTo(current - 1); }

		function restart() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}

			if (settings.auto) {
				timer = window.setInterval(next, settings.interval);
			}
		}

		// Dots
		if (dotsBox) {
			dotsBox.querySelectorAll('.slider-control').forEach(function (dot, i) {
				dot.addEventListener('click', function () { goTo(i); });
			});
		}

		// Setas
		container.querySelectorAll('.jsn-idyllic-prev').forEach(function (btn) {
			btn.addEventListener('click', prev);
		});
		container.querySelectorAll('.jsn-idyllic-next').forEach(function (btn) {
			btn.addEventListener('click', next);
		});

		// Pausa em interação
		container.addEventListener('mouseenter', function () {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		});
		container.addEventListener('mouseleave', restart);

		// Teclado (acessibilidade)
		container.setAttribute('tabindex', '-1');
		container.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') {
				next();
			} else if (e.key === 'ArrowLeft') {
				prev();
			}
		});

		show(0);
		restart();

		return { next: next, prev: prev, goTo: goTo };
	};

	/* ---------- Animações de entrada (estilo wow.js) ---------- */
	app.initAnimations = function () {
		var items = document.querySelectorAll('.jsn-idyllic-animate');

		if (items.length === 0) {
			return;
		}

		if (!('IntersectionObserver' in window)) {
			items.forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}

		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					var el = entry.target;
					var delay = parseInt(el.getAttribute('data-delay') || '0', 10);

					window.setTimeout(function () {
						el.classList.add('is-visible');
					}, delay);

					observer.unobserve(el);
				}
			});
		}, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

		items.forEach(function (el) {
			observer.observe(el);
		});
	};
	document.addEventListener('DOMContentLoaded', function () {
		app.initMenu();
		app.initSearch();
		app.initScrollEffects();
		app.initCounters();
		app.initAnimations();

		document.querySelectorAll('[data-idyllic-slider]').forEach(function (el) {
			var auto = el.getAttribute('data-idyllic-auto') !== 'false';
			app.createSlider(el, { auto: auto });
		});
	});

	window.idyllicClone = app;
})();
