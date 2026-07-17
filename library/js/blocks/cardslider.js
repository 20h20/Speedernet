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
	var $activeItem  = $cardItems.eq(0);

	function readOffsets() {
		var style    = getComputedStyle($cardList[0]);
		var offsetX  = parseInt(style.getPropertyValue('--card-offset-x'), 10);
		var offsetY  = parseInt(style.getPropertyValue('--card-offset-y'), 10);
		return {
			x: isNaN(offsetX) ? 20 : offsetX,
			y: isNaN(offsetY) ? 20 : offsetY,
		};
	}

	var offsets      = readOffsets();
	var heightOffset = (cardTotal - 1) * offsets.y;

	function renderCardStack() {
		requestAnimationFrame(function() {
			$cardItems.each(function(i) {
				var pos      = ((i - cardCurrent) + cardTotal) % cardTotal;
				var isActive = pos === 0;
				var tx       = pos * offsets.x;
				var ty       = (cardTotal - 1 - pos) * offsets.y;
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

	/* BIG TEXT FIT */
	var bigTxt = document.querySelector('.cbo-cardslider .cardslider-bigtxt');
	function fitBigText() {
		if (!bigTxt) return;
		var naturalW   = bigTxt.scrollWidth;
		var containerW = bigTxt.closest('.cbo-cardslider').offsetWidth;
		var maxScale   = (window.innerWidth * 0.70) / naturalW;
		var scale      = Math.min((containerW / naturalW) * 1.05, maxScale);
		bigTxt.style.transform = 'translateX(-50%) rotate(-10deg) scale(' + scale + ') translateZ(0)';
	}
	fitBigText();

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
		resizeTimer = setTimeout(function() {
			offsets      = readOffsets();
			heightOffset = (cardTotal - 1) * offsets.y;
			renderCardStack();
			fitBigText();
		}, 100);
	});
})(jQuery);