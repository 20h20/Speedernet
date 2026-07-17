(function($) {
	$(function() {
		var videoTrack = document.querySelector('.cbo-video');
		if (!videoTrack) return;

		var videoInner = videoTrack.querySelector('.video-inner');
		var videoFile  = videoTrack.querySelector('.video-file');
		var videoEl    = videoTrack.querySelector('.cbo-video-element');
		var playBtn    = videoTrack.querySelector('.video-play');
		var modal      = videoTrack.querySelector('.video-modal');
		var backdrop   = modal ? modal.querySelector('.modal-backdrop') : null;
		var closeBtn   = modal ? modal.querySelector('.modal-close')   : null;
		var modalVideo = modal ? modal.querySelector('.modal-video')   : null;

		if (!videoFile || !videoEl) return;

		var videoTargetP = 0;
		var videoSmoothP = 0;
		var videoRafId   = null;
		var headerH      = 0;

		function videoMeasure() {
			var siteHeader = document.querySelector('header');
			headerH = siteHeader ? siteHeader.offsetHeight : 0;
			document.documentElement.style.setProperty('--video-header-h', headerH + 'px');
		}

		/* Mobile sticky (desktop uses CSS position:sticky) */
		function videoUpdateSticky() {
			if (!videoInner || window.innerWidth >= 1024) return;
			var rect = videoTrack.getBoundingClientRect();
			var h    = (window.innerHeight - headerH) + 'px';
			if (rect.top > headerH) {
				videoInner.classList.remove('video-inner--fixed', 'video-inner--end');
				videoInner.style.height = '';
			} else if (rect.bottom > window.innerHeight) {
				videoInner.classList.add('video-inner--fixed');
				videoInner.classList.remove('video-inner--end');
				videoInner.style.height = h;
			} else {
				videoInner.classList.remove('video-inner--fixed');
				videoInner.classList.add('video-inner--end');
				videoInner.style.height = h;
			}
		}

		function videoCalcTarget() {
			var rect      = videoTrack.getBoundingClientRect();
			var vh        = window.innerHeight - headerH;
			var animRange = (videoTrack.offsetHeight - vh) / 2;
			if (animRange <= 0) return 0;
			var raw   = (headerH - rect.top) / animRange;
			var delay = 0.45; // reste plein écran pour les 45% premiers du scroll
			return Math.max(0, Math.min(1, (raw - delay) / (1 - delay)));
		}

		/* Inverted: fullscreen → shrink to 90% with border-radius */
		function videoRender(sp) {
			var p     = -(Math.cos(Math.PI * sp) - 1) / 2;
			var scale = 1 - 0.1 * p;
			var br    = 24 * p;

			videoFile.style.transform    = 'scale(' + scale + ')';
			videoFile.style.borderRadius = br + 'px';
		}

		function videoRafTick() {
			videoSmoothP += (videoTargetP - videoSmoothP) * 0.1;
			videoRender(videoSmoothP);

			if (Math.abs(videoTargetP - videoSmoothP) > 0.0003) {
				videoRafId = requestAnimationFrame(videoRafTick);
			} else {
				videoSmoothP = videoTargetP;
				videoRender(videoSmoothP);
				videoRafId = null;
			}
		}

		function videoOnScroll() {
			videoUpdateSticky();
			videoTargetP = videoCalcTarget();
			if (!videoRafId) {
				videoRafId = requestAnimationFrame(videoRafTick);
			}
		}

		/* Modal */
		function openModal() {
			if (!modal) return;
			modal.hidden = false;
			document.body.style.overflow = 'hidden';
			if (modalVideo) { modalVideo.play(); }
		}

		function closeModal() {
			if (!modal) return;
			modal.hidden = true;
			document.body.style.overflow = '';
			if (modalVideo) {
				modalVideo.pause();
				modalVideo.currentTime = 0;
			}
		}

		if (playBtn)  { playBtn.addEventListener('click', openModal); }
		if (closeBtn) { closeBtn.addEventListener('click', closeModal); }
		if (backdrop) { backdrop.addEventListener('click', closeModal); }

		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && modal && !modal.hidden) { closeModal(); }
		});

		/* Scroll & resize */
		$(window).on('scroll.videoExpand', videoOnScroll);
		$(window).on('resize.videoExpand', function() {
			videoMeasure();
			if (window.innerWidth >= 1024 && videoInner) {
				videoInner.classList.remove('video-inner--fixed', 'video-inner--end');
				videoInner.style.height = '';
			}
			videoUpdateSticky();
			videoTargetP = videoSmoothP = videoCalcTarget();
			videoRender(videoSmoothP);
		});

		videoMeasure();
		videoUpdateSticky();
		videoTargetP = videoSmoothP = videoCalcTarget();
		videoRender(videoSmoothP);
	});
})(jQuery);
