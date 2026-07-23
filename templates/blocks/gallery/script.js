(function($) {
	$('.cbo-gallery .gallery-list').slick({
		arrows: false,
		dots: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true,
		centerPadding: '10%',
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					centerPadding: '120px',
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					centerPadding: '30px',
				}
			}
		]
	});
})(jQuery);