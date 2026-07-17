(function($) {

	function initFaqsSidebar($block) {
		var $links = $block.find('.sidebar-link');
		var $cats  = $block.find('.content-category');

		if (!$links.length || !$cats.length) return;

		function headerH() {
			return $('header').outerHeight() || 0;
		}

		// Smooth scroll avec offset header
		$links.on('click', function(e) {
			e.preventDefault();
			var $target = $($(this).attr('href'));
			if (!$target.length) return;

			var scrollTo = $target.offset().top - headerH() - 20;
			$('html, body').animate({ scrollTop: scrollTo }, 400);
		});

		// Active link selon position de scroll
		var ticking = false;

		function updateActive() {
			var marker    = $(window).scrollTop() + headerH() + 40;
			var activeCat = null;

			$cats.each(function() {
				if ($(this).offset().top <= marker) {
					activeCat = $(this).data('cat');
				}
			});

			if (activeCat !== null) {
				$links.removeClass('active');
				$links.filter('[data-cat="' + activeCat + '"]').addClass('active');
			}
		}

		$(window).on('scroll.faqsSidebar', function() {
			if (!ticking) {
				requestAnimationFrame(function() {
					updateActive();
					ticking = false;
				});
				ticking = true;
			}
		});

		updateActive();
	}

	$(document).ready(function() {
		$('.cbo-faqs').each(function() {
			initFaqsSidebar($(this));
		});
	});

})(jQuery);
