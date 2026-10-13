(function($) {
	function hasVideoConsent() {
		if (typeof window.cmplz_has_consent === 'function') {
			return window.cmplz_has_consent('marketing');
		}
		return true;
	}

	function playYoutube($player, ytId) {
		var title  = $player.find('img').attr('alt') || 'Vidéo';
		// Attributs posés via .attr() : valeurs échappées, aucune injection HTML possible
		var $iframe = $('<iframe allowfullscreen frameborder="0"></iframe>').attr({
			src:   'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(ytId) + '?autoplay=1&rel=0&modestbranding=1',
			allow: 'autoplay; encrypted-media; picture-in-picture; fullscreen',
			title: title
		});

		$player.find('.player-embed').empty().append($iframe);
		$player.removeClass('player--consent').addClass('player--playing');
	}

	function showConsentNotice($player) {
		var $notice = $(
			'<div class="player-consent">'
			+ '<p></p>'
			+ '<button type="button" class="cbo-button button--white cmplz-manage-consent"></button>'
			+ '</div>'
		);
		$notice.find('p').text($player.data('consent-text'));
		$notice.find('button').text($player.data('consent-button'));

		$player.find('.player-embed').empty().append($notice);
		$player.addClass('player--consent');
	}

	$(function() {
		$('.video-player').each(function() {
			var $player = $(this);
			var ytId    = $.trim(String($player.data('youtube-id') || ''));
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
