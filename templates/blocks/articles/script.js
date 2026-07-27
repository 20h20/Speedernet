(function($) {
	var $list = $('.cbo-articles.articles--relationship .articles-list');
	if (!$list.length || typeof $.fn.slick === 'undefined') return;

	$list.slick({
		arrows: true,
		dots: false,
		infinite: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					arrows: false,
					dots: true,
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					dots: true,
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});
})(jQuery);