/*include /libs/footer.js*/
/*include /libs/forms.js*/
/*include /libs/languages.js*/
/*include /libs/nav.js*/
/*include /libs/parallaxe.js*/
/*include /libs/slick.js*/
/*include /libs/scrollanim.js*/
/*include /libs/search.js*/
/*include /libs/wavy.js*/

(function($) { 
	
	var Master = {
		onready : function(){

			





			


			


			


			


			


		

			

			


			
		},

		onload : function(){

		},

		onresize : function(){

		},

		onscroll : function(){
			
		},
	
	};

	$(document).ready( function(){
		Master.onready();
		
	});

	$(window).on( 'load', function(){
		Master.onload();
	});

	$(window).resize( function(){
		Master.onresize();
	});

	var parallaxTicking = false;
	$(window).on('scroll', function(){
		if (!parallaxTicking) {
			window.requestAnimationFrame(function() {
				Master.onscroll();
				parallaxTicking = false;
			});
			parallaxTicking = true;
		}
	});

})(jQuery);

/*include ../../templates/blocks/articles/script.js*/
/*include ../../templates/blocks/keynumbers/script.js*/
/*include ../../templates/blocks/casestudies/script.js*/
/*include ../../templates/blocks/cardslider/script.js*/
/*include ../../templates/blocks/gallery/script.js*/
/*include ../../templates/blocks/jobslider/script.js*/
/*include ../../templates/blocks/partners/script.js*/
/*include ../../templates/blocks/team/script.js*/
/*include ../../templates/blocks/testimonials/script.js*/
/*include ../../templates/blocks/textpictureslide/script.js*/
/*include ../../templates/blocks/textpictureaccordion/script.js*/
/*include ../../templates/blocks/faqs/script.js*/
/*include ../../templates/blocks/video/script.js*/
/*include ../../templates/parts/faq/script.js*/