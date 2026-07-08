(function($) {
	var $slider = $('.cbo-testimonials.testimonials--relationship .testimonials-list');
	if (!$slider.length) return;

	$slider.slick({
		arrows: false,
		dots: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		infinite: false,
		responsive: [
			{
				breakpoint: 1283,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});
})(jQuery);