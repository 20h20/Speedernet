(function($) {
	var section  = document.querySelector('.cbo-textpictureslide');
	if (!section) return;

	var listEls  = section.querySelectorAll('.list-el');
	var imageEls = section.querySelectorAll('.image-el');
	var count    = listEls.length;
	if (!count) return;

	var currentIdx = -1;
	var isMd = window.matchMedia('(min-width: 1024px)');

	function measureHeader() {
		var h = document.querySelector('header');
		document.documentElement.style.setProperty('--video-header-h', (h ? h.offsetHeight : 100) + 'px');
	}

	/* Desktop : index basé sur la progression dans la hauteur totale */
	function getIdxDesktop() {
		var rect  = section.getBoundingClientRect();
		var total = section.offsetHeight - window.innerHeight;
		if (total <= 0) return 0;
		var p = Math.max(0, Math.min(1, -rect.top / total));
		return Math.min(count - 1, Math.floor(p * count));
	}

	/* Mobile : index basé sur la position du texte dans le viewport */
	var triggerLine = window.innerHeight * 0.25;
	function getIdxMobile() {
		var idx = 0;
		for (var i = 0; i < listEls.length; i++) {
			if (listEls[i].getBoundingClientRect().top <= triggerLine) {
				idx = i;
			} else {
				break;
			}
		}
		return idx;
	}

	function getIdx() {
		return isMd.matches ? getIdxDesktop() : getIdxMobile();
	}

	var leavingTimer = null;

	function update() {
		var newIdx = getIdx();
		if (newIdx === currentIdx) return;

		var prevIdx = currentIdx;
		currentIdx  = newIdx;

		// Textes : sortie de l'ancien (is-leaving), entrée du nouveau
		listEls.forEach(function(el, i) {
			el.classList.remove('is-active', 'is-leaving');
			if (i === newIdx) {
				el.classList.add('is-active');
			} else if (i === prevIdx && prevIdx >= 0) {
				el.classList.add('is-leaving');
			}
		});

		// Nettoie is-leaving après la transition
		if (leavingTimer) clearTimeout(leavingTimer);
		leavingTimer = setTimeout(function() {
			listEls.forEach(function(el) { el.classList.remove('is-leaving'); });
		}, 600);

		// Images : wipe-up
		imageEls.forEach(function(el, i) {
			el.classList.toggle('is-active', i === newIdx);
		});
	}

	measureHeader();
	update();

	$(window).on('scroll.textpictureslide', function() {
		window.requestAnimationFrame(update);
	});

	$(window).on('resize.textpictureslide', function() {
		measureHeader();
		triggerLine = window.innerHeight * 0.25;
		update();
	});
})(jQuery);
