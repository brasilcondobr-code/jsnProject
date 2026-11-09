(function () {
	"use strict";

	var hero = document.querySelector(".jsn-hero");
	if (!hero) {
		return;
	}

	window.requestAnimationFrame(function () {
		hero.classList.add("is-ready");
	});
})();
