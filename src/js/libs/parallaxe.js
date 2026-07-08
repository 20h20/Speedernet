(function($) {
	function galleryParallax() {
		var pictures = document.querySelectorAll('.cbo-gallery .inner-picture img, .cbo-heroarticle .content-picture img, .cbo-textpicture .textpicture-picture  img');
		if (!pictures.length) return;

		var ticking = false;

		function applyParallax() {
			for (var i = 0; i < pictures.length; i++) {
				var img = pictures[i];
				var rect = img.closest('.inner-picture, .content-picture, .textpicture-picture ').getBoundingClientRect();
				var center = rect.top + rect.height / 2;
				var offset = (window.innerHeight / 2 - center) * 0.1;
				img.style.transform = 'scale(1.15) translateY(' + offset + 'px)';
			}
		}

		function scheduleParallax() {
			requestAnimationFrame(function() {
				requestAnimationFrame(applyParallax);
			});
		}

		if (document.readyState === 'complete') {
			scheduleParallax();
		} else {
			$(window).on('load.galleryParallax', scheduleParallax);
		}

		window.addEventListener('scroll', function() {
			if (!ticking) {
			requestAnimationFrame(function() {
				applyParallax();
				ticking = false;
			});
			ticking = true;
			}
		}, { passive: true });
	}
	galleryParallax();
})(jQuery);