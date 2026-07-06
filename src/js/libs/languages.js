(function($) {

	var $langBtn      = $('.upheader-languages .languages-button');
	var $langDropdown = $('.upheader-languages .languages-list');

	function closeLanguages() {
		$langDropdown.removeClass('lang-open');
		$langBtn.attr('aria-expanded', 'false');
	}

	$langBtn.on('click', function(e) {
		e.stopPropagation();
		var isOpen = $langDropdown.hasClass('lang-open');
		$langDropdown.toggleClass('lang-open', !isOpen);
		$langBtn.attr('aria-expanded', !isOpen ? 'true' : 'false');
	});

	$(document).on('click.langDropdown', closeLanguages);

	$(document).on('keydown.langDropdown', function(e) {
		if (e.key === 'Escape' && $langDropdown.hasClass('lang-open')) {
			closeLanguages();
			$langBtn.focus();
		}
	});

})(jQuery);