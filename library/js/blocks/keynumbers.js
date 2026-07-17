(function() {
	var els = document.querySelectorAll('.keynumbers-bigtxt');
	if (!els.length) return;

	function fitKeyNumbersBigText() {
		els.forEach(function(el) {
			el.style.fontSize = '100px';
			var ratio = window.innerWidth / el.scrollWidth;
			el.style.fontSize = Math.floor(110 * ratio) + 'px';
		});
	}

	fitKeyNumbersBigText();
	window.addEventListener('resize', fitKeyNumbersBigText);
})();