(function($) {
	function initCasestudiesSlider() {
		var $lists = $('.cbo-casestudies.casestudies--relationship .casestudies-list');
		if (!$lists.length || typeof $.fn.slick === 'undefined') return;
		var width = $(window).width();

		$lists.each(function() {
			var $el = $(this);
			var count = $el.data('item-count');
			if (count === undefined) {
				count = $el.children().not('.slick-cloned').length;
				$el.data('item-count', count);
			}

			if (width < 1024) {
				var sts = width < 767 ? 1 : 2;
				if ($el.hasClass('slick-initialized')) {
					$el.slick('slickSetOption', 'slidesToShow', sts, true);
					$el.slick('slickSetOption', 'slidesToScroll', sts, true);
				} else {
					$el.slick({ arrows: false, dots: true, infinite: false, slidesToShow: sts, slidesToScroll: sts });
				}
			} else if (count > 3) {
				if (!$el.hasClass('slick-initialized')) {
					$el.slick({ arrows: false, dots: true, infinite: false, slidesToShow: 3, slidesToScroll: 1 });
				}
			} else {
				if ($el.hasClass('slick-initialized')) $el.slick('unslick');
			}
		});
	}

	initCasestudiesSlider();
	$(window).on('resize', initCasestudiesSlider);
})(jQuery);