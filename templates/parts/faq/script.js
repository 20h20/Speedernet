(function($) {
	function initFaqAccordion($container) {
		$container.find('.cbo-faq .el-title').off('click').on('click', function() {
			var $btn     = $(this);
			var $el      = $btn.closest('.cbo-faq');
			var $content = $('#' + $btn.attr('aria-controls'));
			var open     = $btn.attr('aria-expanded') === 'true';

			// Fermer les autres
			$el.siblings('.cbo-faq.el--open').each(function() {
				var $c = $(this).find('.el-content');
				$(this).removeClass('el--open').find('.el-title').attr('aria-expanded', 'false');
				$c.css('height', $c[0].scrollHeight + 'px');
				$c[0].offsetHeight;
				$c.css('height', '0');
				setTimeout(function() { $c.attr('hidden', ''); }, 300);
			});

			if (open) {
				$btn.attr('aria-expanded', 'false');
				$el.removeClass('el--open');
				$content.css('height', $content[0].scrollHeight + 'px');
				$content[0].offsetHeight;
				$content.css('height', '0');
				setTimeout(function() { $content.attr('hidden', ''); }, 300);
			} else {
				$btn.attr('aria-expanded', 'true');
				$el.addClass('el--open');
				$content.removeAttr('hidden');
				var fullHeight = $content[0].scrollHeight + 'px';
				$content.css('height', '0');
				$content[0].offsetHeight;
				$content.css('height', fullHeight);
				setTimeout(function() { $content.css('height', 'auto'); }, 300);
			}
		});
	}

	$(document).ready(function() {
		$('.cbo-faqs, .cbo-accordion').each(function() {
			initFaqAccordion($(this));
		});
	});
})(jQuery);
