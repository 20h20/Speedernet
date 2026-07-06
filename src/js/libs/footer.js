(function($) {

	$('footer .footer-menu .menu-item-has-children > a').on('click', function(e) {
		e.preventDefault();
		var $item = $(this).closest('.menu-item-has-children');
		$('footer .footer-menu .menu-item-has-children').not($item).removeClass('active');
		$item.toggleClass('active');
	});

})(jQuery);