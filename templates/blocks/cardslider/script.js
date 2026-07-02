(function($) {
	var $cardList = $('.cbo-cardslider .cardslider-list');
	if (!$cardList.length) return;

	var $cardItems   = $cardList.find('> .list-el');
	var $cardTabs    = $('.cbo-cardslider .cardslider-tabs .tab-el');
	var $cardPrev    = $('.cbo-cardslider .nav-btn--prev');
	var $cardNext    = $('.cbo-cardslider .nav-btn--next');
	var cardTotal    = $cardItems.length;
	var cardCurrent  = 0;
	var cardBusy     = false;
	var OFFSET       = 20;
	var heightOffset = (cardTotal - 1) * OFFSET;
	var $activeItem  = $cardItems.eq(0);

	function renderCardStack() {
		requestAnimationFrame(function() {
			$cardItems.each(function(i) {
				var pos      = ((i - cardCurrent) + cardTotal) % cardTotal;
				var isActive = pos === 0;
				var tx       = pos * OFFSET;
				var ty       = (cardTotal - 1 - pos) * OFFSET;
				if (isActive) $activeItem = $(this);
				$(this)
					.data('stack-pos', pos)
					.css({
						'z-index'   : cardTotal - pos,
						'transform' : 'translate(' + tx + 'px,' + ty + 'px)',
					})
					.toggleClass('stack-active', isActive)
					.attr('aria-hidden', isActive ? 'false' : 'true');
			});
			$cardTabs
				.attr('aria-selected', 'false')
				.removeClass('active')
				.eq(cardCurrent)
				.addClass('active')
				.attr('aria-selected', 'true');
			updateCardHeight();
		});
	}

	function updateCardHeight() {
		$cardList.height($activeItem.outerHeight() + heightOffset);
	}

	function goToCard(index) {
		if (cardBusy) return;
		cardBusy = true;
		cardCurrent = ((index % cardTotal) + cardTotal) % cardTotal;
		renderCardStack();
		setTimeout(function() { cardBusy = false; }, 450);
	}

	$cardPrev.on('click', function() { goToCard(cardCurrent - 1); });
	$cardNext.on('click', function() { goToCard(cardCurrent + 1); });
	$cardTabs.on('click', function() { goToCard($(this).index()); });
	$cardItems.on('click', function() {
		var pos = $(this).data('stack-pos');
		if (pos > 0) { goToCard(cardCurrent + pos); }
	});

	renderCardStack();

	var resizeTimer;
	var isVisible = true;

	if ('IntersectionObserver' in window) {
		new IntersectionObserver(function(entries) {
			isVisible = entries[0].isIntersecting;
		}, { threshold: 0 }).observe($cardList[0]);
	}

	$(window).on('resize', function() {
		if (!isVisible) return;
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(updateCardHeight, 100);
	});
})(jQuery);
