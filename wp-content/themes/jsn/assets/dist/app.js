(function () {
	"use strict";

	var toggle = document.querySelector("[data-jsn-nav-toggle]");
	var nav = document.querySelector("[data-jsn-nav]");

	if (toggle && nav) {
		toggle.addEventListener("click", function () {
			var open = nav.classList.toggle("is-open");
			toggle.setAttribute("aria-expanded", open ? "true" : "false");
		});

		document.addEventListener("keydown", function (event) {
			if (event.key === "Escape" && nav.classList.contains("is-open")) {
				nav.classList.remove("is-open");
				toggle.setAttribute("aria-expanded", "false");
				toggle.focus();
			}
		});
	}
})();
