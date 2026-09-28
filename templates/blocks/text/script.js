(function($) {

	/* ---- Lightbox images ---- */
	var IMG_URL  = /\.(jpe?g|png|gif|webp|avif)(\?.*)?$/i;
	var $lb      = null;
	var $lbImg   = null;
	var $counter = null;
	var images   = [];
	var current  = 0;

	function buildLightbox() {
		$lb = $(
			'<div class="cbo-gallery-lightbox" role="dialog" aria-modal="true" aria-label="Image">' +
				'<div class="lb-overlay"></div>' +
				'<button class="lb-close" aria-label="Fermer"><i class="icon icon--close"></i></button>' +
				'<button class="lb-prev" aria-label="Image précédente"></button>' +
				'<button class="lb-next" aria-label="Image suivante"></button>' +
				'<div class="lb-content"><img class="lb-img" src="" alt=""></div>' +
				'<span class="lb-counter"></span>' +
			'</div>'
		).appendTo('body');

		$lbImg   = $lb.find('.lb-img');
		$counter = $lb.find('.lb-counter');

		$lb.find('.lb-overlay, .lb-close').on('click', closeLightbox);
		$lb.find('.lb-prev').on('click', function() { navigate(-1); });
		$lb.find('.lb-next').on('click', function() { navigate(1); });
	}

	// Image sans lien, ou dont le lien pointe vers un fichier image
	function isZoomable(img) {
		var $a = $(img).closest('a');
		return !$a.length || IMG_URL.test($a.attr('href') || '');
	}

	// Lien vers le fichier image, sinon la plus grande taille du srcset
	function fullSrc($img) {
		var $a   = $img.closest('a');
		var best = $img.attr('src');
		var max  = 0;

		if ($a.length) return $a.attr('href');

		($img.attr('srcset') || '').split(',').forEach(function(candidate) {
			var parts = $.trim(candidate).split(/\s+/);
			var width = parseInt(parts[1], 10);
			if (width > max) { max = width; best = parts[0]; }
		});
		return best;
	}

	function openLightbox(list, index) {
		if (!$lb) buildLightbox();
		images  = list;
		current = index;
		showImage();

		$lb.addClass('is-open');
		$('body').css('overflow', 'hidden');
		$lb.find('.lb-close').trigger('focus');
	}

	function closeLightbox() {
		$lb.removeClass('is-open');
		$('body').css('overflow', '');
	}

	function showImage() {
		var img = images[current];
		$lbImg.attr({ src: img.src, alt: img.alt });
		$counter.text(images.length > 1 ? (current + 1) + ' / ' + images.length : '');
		$lb.find('.lb-prev, .lb-next').toggle(images.length > 1);
	}

	function navigate(dir) {
		current = (current + dir + images.length) % images.length;
		showImage();
	}

	$('.cbo-text .cbo-cms img').filter(function() { return isZoomable(this); })
		.addClass('is-zoomable')
		.attr({ tabindex: 0, role: 'button', 'aria-label': 'Agrandir l\'image' });

	// Click on image
	$(document).on('click keydown', '.cbo-text .cbo-cms img.is-zoomable', function(e) {
		if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
		e.preventDefault();

		var $items = $(this).closest('.cbo-cms').find('img.is-zoomable');
		var list   = $items.map(function() {
			return { src: fullSrc($(this)), alt: $(this).attr('alt') || '' };
		}).get();

		openLightbox(list, $items.index(this));
	});

	// Keyboard navigation
	$(document).on('keydown', function(e) {
		if (!$lb || !$lb.hasClass('is-open')) return;
		if (e.key === 'Escape')      closeLightbox();
		if (e.key === 'ArrowLeft')   navigate(-1);
		if (e.key === 'ArrowRight')  navigate(1);
	});

})(jQuery);
