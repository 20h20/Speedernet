(function($) {
	$('.cbo-partners .partners-list').each(function(){
		var $slider = $(this);
		$slider.append($slider.html());
		$slider.slick({
			arrows: false,
			dots: false,
			infinite: true,
			slidesToShow: 8,
			slidesToScroll: 1,
			speed: 4000,
			autoplay: true,
			autoplaySpeed: 0,
			cssEase: 'linear',
			variableWidth: false,
			responsive: [
				{ breakpoint: 991, settings: { slidesToShow: 5 } },
				{ breakpoint: 767, settings: { slidesToShow: 4 } },
				{ breakpoint: 500, settings: { slidesToShow: 2 } }
			]
		});
	});
})(jQuery);