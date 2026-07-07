(function($) {
	$(function() {
		$('.video-player').each(function() {
			var $player = $(this);
			var ytId    = $player.data('youtube-id');
			if (!ytId) return;

			$player.find('.player-button, .player-cover').on('click', function() {
				if ($player.hasClass('player--playing')) return;

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
				$player.addClass('player--playing');
			});
		});
	});
})(jQuery);