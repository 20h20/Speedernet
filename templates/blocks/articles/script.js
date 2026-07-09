(function($) {
	function getSlidesToShow() {
		var w = $(window).width();
		if (w >= 1024) return 3;
		if (w >= 768)  return 2;
		return 1;
	}

	function initArticlesSlider() {
		var $list = $('.cbo-articles.articles--relationship .articles-list');
		if (!$list.length || typeof $.fn.slick === 'undefined') return;

		var n = getSlidesToShow();

		if ($list.hasClass('slick-initialized')) {
			$list.slick('slickSetOption', 'slidesToShow', n, true);
			$list.slick('slickSetOption', 'slidesToScroll', n, true);
		} else {
			$list.slick({
				arrows: false,
				dots: true, 
				infinite: false,
				slidesToShow: n, 
				slidesToScroll: n
			});
		}
	}

	initArticlesSlider();
	$(window).on('resize', initArticlesSlider);
})(jQuery);