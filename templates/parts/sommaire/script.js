(function($) {
	var nav = document.querySelector('.cbo-summary');
	if (!nav) return;

	var toggle = nav.querySelector('.summary-toggle');
	var links  = nav.querySelectorAll('.el-link');

	/* Ouverture/fermeture mobile (bouton masqué en CSS dès le breakpoint sm) */
	toggle.addEventListener('click', function() {
		var isOpen = nav.classList.toggle('is-open');
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});

	links.forEach(function(link) {
		link.addEventListener('click', function() {
			nav.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		});
	});

	/* Scrollspy : surligne le lien de la section actuellement visible */
	var targets = [];
	links.forEach(function(link) {
		var target = document.getElementById(link.dataset.anchor);
		if (target) targets.push({ link: link, el: target });
	});
	if (!targets.length || !('IntersectionObserver' in window)) return;

	/* IntersectionObserver n'accepte rootMargin qu'en px/% (pas en rem) :
	   on récupère le décalage de scroll déjà défini globalement (html { scroll-padding-top }). */
	var scrollOffset = parseFloat(getComputedStyle(document.documentElement).scrollPaddingTop) || 0;

	var observer = new IntersectionObserver(function(entries) {
		entries.forEach(function(entry) {
			var match = targets.find(function(t) { return t.el === entry.target; });
			if (!match) return;
			if (entry.isIntersecting) {
				links.forEach(function(l) { l.classList.remove('is-active'); });
				match.link.classList.add('is-active');
			}
		});
	}, { rootMargin: '-' + scrollOffset + 'px 0px -70% 0px', threshold: 0 });

	targets.forEach(function(t) { observer.observe(t.el); });
})(jQuery);
