(function($) {
	var $searchBar     = $('.cbo-searchbar');
	var $searchBg      = $('.cbo-searchoverlay');
	var $searchTrigger = $('.tools-search, .upheader-search');

	function updateSearchbarTop() {
		var headerEl = document.querySelector('header.cbo-header');
		if (headerEl) {
			document.documentElement.style.setProperty('--searchbar-top', headerEl.getBoundingClientRect().bottom + 'px');
		}
	}

	function openSearch() {
		updateSearchbarTop();
		$searchBar.add($searchBg).addClass('is-open');
		$searchBar.attr('aria-hidden', 'false');
		$searchTrigger.attr('aria-expanded', 'true');
		setTimeout(function() { $searchBar.find('.searchbar-input').focus(); }, 150);
	}

	function closeSearch() {
		$searchBar.add($searchBg).removeClass('is-open');
		$searchBar.attr('aria-hidden', 'true');
		$searchTrigger.attr('aria-expanded', 'false');
		$searchTrigger.focus();
	}

	$searchTrigger.on('click', openSearch);
	$searchBar.find('.searchbar-close').on('click', closeSearch);
	$searchBg.on('click', closeSearch);

	$(document).on('keydown.search', function(e) {
		if (e.key === 'Escape' && $searchBar.hasClass('is-open')) closeSearch();
	});

})(jQuery);