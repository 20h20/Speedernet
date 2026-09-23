(function($) {
	function hasVideoConsent() {
		if (typeof window.cmplz_has_consent === 'function') {
			return window.cmplz_has_consent('marketing');
		}
		return true;
	}

	function playYoutube($player, ytId) {
		var title  = $player.find('img').attr('alt') || 'Vidéo';
		var iframe = '<iframe'
			+ ' src="https://www.youtube-nocookie.com/embed/' + ytId
			+ '?autoplay=1&rel=0&modestbranding=1"'
			+ ' allow="autoplay; encrypted-media; picture-in-picture; fullscreen"'
			+ ' allowfullscreen'
			+ ' frameborder="0"'
			+ ' title="' + title + '"'
			+ '></iframe>';

		$player.find('.player-embed').html(iframe);
		$player.removeClass('player--consent').addClass('player--playing');
	}

	function showConsentNotice($player) {
		var notice = '<div class="player-consent">'
			+ '<p>' + $player.data('consent-text') + '</p>'
			+ '<button type="button" class="cbo-button button--white cmplz-manage-consent-cats">' + $player.data('consent-button') + '</button>'
			+ '</div>';

		$player.find('.player-embed').html(notice);
		$player.addClass('player--consent');
	}

	$(function() {
		$('.video-player').each(function() {
			var $player = $(this);
			var ytId    = $player.data('youtube-id');
			if (!ytId) return;

			$player.find('.player-button, .player-cover').on('click', function() {
				if ($player.hasClass('player--playing')) return;

				if (!hasVideoConsent()) {
					showConsentNotice($player);
					return;
				}

				playYoutube($player, ytId);
			});

			document.addEventListener('cmplz_status_change', function() {
				if ($player.hasClass('player--consent') && hasVideoConsent()) {
					playYoutube($player, ytId);
				}
			});
		});
	});
})(jQuery);
