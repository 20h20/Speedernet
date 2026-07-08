(function($) {
	var $slider = $('.cbo-jobslider .jobslider-list');
	if (!$slider.length) return;

	$slider.slick({
		arrows: true,
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true,
		centerPadding: '245px',
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					centerPadding: '40px',
				}
			}
		]
	});
})(jQuery);