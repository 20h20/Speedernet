(function($) {
	var $section = $('.cbo-textpictureaccordion');
	if (!$section.length) return;

	/* ---- ACCORDION ---- */
	$section.on('click', '.item-header', function() {
		var $header = $(this);
		var $item   = $header.closest('.accordion-item');
		var $body   = $item.find('.item-body');
		var isOpen  = $item.hasClass('is-active');

		$section.find('.accordion-item').removeClass('is-active');
		$section.find('.item-header').attr('aria-expanded', 'false');
		$section.find('.item-body').removeClass('is-open');

		if (!isOpen) {
			$item.addClass('is-active');
			$header.attr('aria-expanded', 'true');
			$body.addClass('is-open');
		}
	});

	/* ---- PARALLAX ---- */
	var $grid = $section.find('.textpictureaccordion-pictures .pictures-grid');
	if (!$grid.length) return;

	var $pics  = $grid.find('.picture-el img');
	if (!$pics.length) return;

	var rafId  = null;
	var speeds = [-60, 20, 70];

	$pics.css('will-change', 'transform');

	function applyParallax() {
		if (rafId) return;
		rafId = requestAnimationFrame(function() {
			rafId = null;
			var rect     = $grid[0].getBoundingClientRect();
			var viewH    = window.innerHeight;
			var progress = (viewH - rect.top) / (viewH + rect.height);
			progress     = Math.max(0, Math.min(1, progress));

			$pics.each(function(i) {
				var offset = (progress - 0.5) * 2 * (speeds[i] || 0);
				this.style.transform = 'translateY(' + offset + 'px)';
			});
		});
	}

	$(window).on('scroll.tpa-parallax touchmove.tpa-parallax', applyParallax);
	applyParallax();
})(jQuery);
