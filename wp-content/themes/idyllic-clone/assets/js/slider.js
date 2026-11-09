/**
 * Idyllic Clone — slider.js (interações dedicadas ao hero/vitrine superior).
 * Delegado ao core vanilla em main.js; aqui só registramos o hero logo cedo
 * para não acoplar ordem de carregamento.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var hero = document.querySelector('.main-slider[data-idyllic-slider]');

		if (hero && window.idyllicClone && typeof window.idyllicClone.createSlider === 'function') {
			var auto = hero.getAttribute('data-idyllic-auto') !== 'false';
			window.idyllicClone.createSlider(hero, { auto: auto, interval: 6000 });
		}
	});
})();
