(function($) {

	/* ---- Slick ---- */
	$('.cbo-gallery .gallery-list').slick({
		arrows: false,
		dots: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		infinite: true,
		centerMode: false,
		centerPadding: '10%',
		responsive: [
			{
				breakpoint: 1283,
				settings: {
					slidesToShow: 2,
					centerPadding: '120px',
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					centerPadding: '30px',
				}
			}
		]
	});

	/* ---- Lightbox ---- */
	var $lb      = null;
	var $lbImg   = null;
	var $counter = null;
	var images   = [];
	var current  = 0;

	function buildLightbox() {
		$lb = $(
			'<div class="cbo-gallery-lightbox" role="dialog" aria-modal="true" aria-label="Galerie">' +
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

	function collectImages() {
		images = [];
		$('.cbo-gallery .list-el:not(.slick-cloned) .el-inner').each(function() {
			images.push({
				src: $(this).data('full'),
				alt: $(this).data('alt') || ''
			});
		});
	}

	function openLightbox(index) {
		if (!$lb) buildLightbox();
		collectImages();
		if (!images.length) return;

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
		$counter.text((current + 1) + ' / ' + images.length);

		// Toggle nav visibility
		$lb.find('.lb-prev, .lb-next').toggle(images.length > 1);
	}

	function navigate(dir) {
		current = (current + dir + images.length) % images.length;
		showImage();
	}

	// Click on gallery item
	$(document).on('click keydown', '.cbo-gallery .list-el:not(.slick-cloned) .el-inner', function(e) {
		if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
		e.preventDefault();

		var $el    = $(this).closest('.list-el');
		var $items = $('.cbo-gallery .list-el:not(.slick-cloned)');
		var index  = $items.index($el);

		openLightbox(index >= 0 ? index : 0);
	});

	// Keyboard navigation
	$(document).on('keydown', function(e) {
		if (!$lb || !$lb.hasClass('is-open')) return;
		if (e.key === 'Escape')      closeLightbox();
		if (e.key === 'ArrowLeft')   navigate(-1);
		if (e.key === 'ArrowRight')  navigate(1);
	});

})(jQuery);