(function($) {
	var scroll = window.requestAnimationFrame || function(callback){ window.setTimeout(callback, 1000/60)};
	var elementsToShow = document.querySelectorAll('.slide-up, .slide-up, .slide-right, .slide-left, .scale-up, .scale-down'); 
	function loop() {
		Array.prototype.forEach.call(elementsToShow, function(element){
			if (isElementInViewport(element)) {
				element.classList.add('anim-scroll');
			} else {
				element.classList.remove('anim-scroll');
			}
		});
		scroll(loop);
	}	
	loop();
	function isElementInViewport(el) {
		if (typeof jQuery === "function" && el instanceof jQuery) {
			el = el[0];
		}
		var rect = el.getBoundingClientRect();
		return (
			(rect.top <= 0&& rect.bottom >= 0)||(rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) && rect.top <= (window.innerHeight || document.documentElement.clientHeight))||(rect.top >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
		);
	}
})(jQuery);