(function($) {
	$(function() {
		var videoTrack = document.querySelector('.cbo-video');
		if (!videoTrack) return;

		var videoInner           = videoTrack.querySelector('.video-inner');
		var videoExpandContainer = videoTrack.querySelector('.video-file');
		var videoExpandEl        = videoTrack.querySelector('.cbo-video-element');

		if (!videoExpandContainer || !videoExpandEl) return;

		var videoLabelEl = videoTrack.querySelector('.video-label');
		var videoTargetP = 0;
		var videoSmoothP = 0;
		var videoRafId   = null;

		function videoMeasure() {
			var siteHeader = document.querySelector('header');
			var headerH    = siteHeader ? siteHeader.offsetHeight : 0;
			document.documentElement.style.setProperty('--video-header-h', headerH + 'px');
		}

		// Sticky piloté par JS pour mobile (desktop utilise position:sticky CSS)
		function videoUpdateSticky() {
			if (!videoInner || window.innerWidth >= 1024) return;
			var rect = videoTrack.getBoundingClientRect();
			var h    = window.innerHeight + 'px';
			if (rect.top > 0) {
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
			var animRange = (videoTrack.offsetHeight - window.innerHeight) / 2;
			return Math.max(0, Math.min(1, -rect.top / animRange));
		}

		function videoRender(sp) {
			var p     = -(Math.cos(Math.PI * sp) - 1) / 2;
			var scale = 0.5 + 0.3 * p;
			var br    = (20 * (1 - p)) / scale;

			videoExpandContainer.style.transform    = 'scale(' + scale + ')';
			videoExpandContainer.style.borderRadius = br + 'px';

			document.documentElement.style.setProperty('--video-p', p);
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