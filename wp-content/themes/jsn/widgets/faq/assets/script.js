(function () {
	"use strict";

	var details = document.querySelectorAll(".jsn-faq__item");
	if (!details.length) {
		return;
	}

	details.forEach(function (item) {
		item.addEventListener("toggle", function () {
			item.setAttribute("data-jsn-open", item.open ? "true" : "false");
		});
	});
})();
