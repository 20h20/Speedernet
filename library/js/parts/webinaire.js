(function($) {
	$(document).on('click', '.cbo-webinaire .webinaire-toggle', function() {
		var $btn       = $(this);
		var $card      = $btn.closest('.cbo-webinaire');
		var $secondary = $('#' + $btn.attr('aria-controls'));
		var open       = $btn.attr('aria-expanded') === 'true';

		var title   = $card.find('.content-title').text().trim();
		var labelOpen  = '+ d\'infos sur : ' + title;
		var labelClose = 'Fermer les infos sur : ' + title;

		if (open) {
			$btn.attr('aria-expanded', 'false').attr('aria-label', labelOpen);
			$card.removeClass('webinaire--open');
			$secondary.attr('hidden', '');
		} else {
			$btn.attr('aria-expanded', 'true').attr('aria-label', labelClose);
			$card.addClass('webinaire--open');
			$secondary.removeAttr('hidden');
			setTimeout(function() {
				$secondary[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}, 50);
		}
	});
})(jQuery);