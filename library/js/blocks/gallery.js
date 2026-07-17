(function($) {
	$('.cbo-gallery .gallery-list').slick({
		arrows: false,
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true,
		centerPadding: '20%',
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					centerPadding: '120px',
				}
			},
			{
				breakpoint: 767,
				settings: {
					centerPadding: '30px',
				}
			}
		]
	});
})(jQuery);