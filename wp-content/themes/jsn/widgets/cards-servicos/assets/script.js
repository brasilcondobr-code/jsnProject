(function () {
	"use strict";

	var cards = document.querySelectorAll(".jsn-cards-servicos .jsn-card");
	if (!cards.length) {
		return;
	}

	cards.forEach(function (card, index) {
		card.style.transitionDelay = Math.min(index * 60, 240) + "ms";
	});
})();
