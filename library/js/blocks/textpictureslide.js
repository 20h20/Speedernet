(function($) {
	var section = document.querySelector('.cbo-textpictureslide');
	if (!section) return;
	var contentEls = section.querySelectorAll('.list-el');
	var imageEls   = section.querySelectorAll('.image-el');
	if (!contentEls.length || !imageEls.length) return;
	var currentActive = -1;
	var triggerLine = window.innerHeight * 0.25;

	function updateActiveImage() {
		var newActive = 0;
		for (var i = 0; i < contentEls.length; i++) {
			if (contentEls[i].getBoundingClientRect().top <= triggerLine) {
				newActive = i;
			} else {
				break;
			}
		}
		if (newActive !== currentActive) {
			imageEls.forEach(function(img) { img.classList.remove('is-active'); });
			var active = section.querySelector('.image-el[data-index="' + newActive + '"]');
			if (active) active.classList.add('is-active');
			currentActive = newActive;
		}
	}

	updateActiveImage();
	$(window).on('scroll.textpictureslide', function() {
		window.requestAnimationFrame(updateActiveImage);
	});
})(jQuery);