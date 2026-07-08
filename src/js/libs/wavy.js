(function($) {
	function initWordAnim() {
		var elements = document.querySelectorAll('[data-word-anim]');
		if (!elements.length) return;

		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			elements.forEach(function(el) { el.classList.add('word-anim--ready'); });
			return;
		}

		function wrapTextNode(textNode, delay, counter) {
			var parts = textNode.nodeValue.split(/(\s+)/);
			var fragment = document.createDocumentFragment();
			parts.forEach(function(part) {
				if (!part) return;
				if (/^\s+$/.test(part)) {
					fragment.appendChild(document.createTextNode(part));
				} else {
					var wrapper = document.createElement('span');
					wrapper.className = 'word-wrapper';
					var anim = document.createElement('span');
					anim.className = 'word-anim';
					anim.style.animationDelay = (counter.value * delay) + 's';
					anim.textContent = part;
					wrapper.appendChild(anim);
					fragment.appendChild(wrapper);
					counter.value++;
				}
			});
			textNode.parentNode.replaceChild(fragment, textNode);
		}

		function walkNodes(node, delay, counter) {
			if (node.nodeType === Node.TEXT_NODE) {
				if (node.nodeValue.trim()) wrapTextNode(node, delay, counter);
			} else if (node.nodeType === Node.ELEMENT_NODE) {
				Array.from(node.childNodes).forEach(function(child) {
					walkNodes(child, delay, counter);
				});
			}
		}

		elements.forEach(function(el) {
			if (!el.getAttribute('aria-label')) {
				el.setAttribute('aria-label', el.textContent.trim());
			}
			var delay = parseFloat(el.getAttribute('data-word-delay') || 0.07);
			var counter = { value: 0 };
			walkNodes(el, delay, counter);
			el.querySelectorAll('.word-wrapper').forEach(function(s) { s.setAttribute('aria-hidden', 'true'); });
		});

		if ('IntersectionObserver' in window) {
			var observer = new IntersectionObserver(function(entries) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('word-anim--ready');
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.2 });
			elements.forEach(function(el) { observer.observe(el); });
		} else {
			elements.forEach(function(el) { el.classList.add('word-anim--ready'); });
		}
	}
	initWordAnim();
})(jQuery);