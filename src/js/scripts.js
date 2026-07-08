/*include /libs/footer.js*/
/*include /libs/languages.js*/
/*include /libs/slick.js*/
/*include /libs/search.js*/

(function($) { 
	
	var Master = {
		onready : function(){

			





			


			/////////////////// PARALLAX PICTURE ///////////////////
			function galleryParallax() {
				var pictures = document.querySelectorAll('.cbo-gallery .inner-picture img, .cbo-heroarticle .content-picture img, .cbo-textpicture .textpicture-picture  img');
				if (!pictures.length) return;

				var ticking = false;

				function applyParallax() {
					for (var i = 0; i < pictures.length; i++) {
						var img = pictures[i];
						var rect = img.closest('.inner-picture, .content-picture, .textpicture-picture ').getBoundingClientRect();
						var center = rect.top + rect.height / 2;
						var offset = (window.innerHeight / 2 - center) * 0.1;
						img.style.transform = 'scale(1.15) translateY(' + offset + 'px)';
					}
				}

				function scheduleParallax() {
					requestAnimationFrame(function() {
						requestAnimationFrame(applyParallax);
					});
				}

				if (document.readyState === 'complete') {
					scheduleParallax();
				} else {
					$(window).on('load.galleryParallax', scheduleParallax);
				}

				window.addEventListener('scroll', function() {
					if (!ticking) {
					requestAnimationFrame(function() {
						applyParallax();
						ticking = false;
					});
					ticking = true;
					}
				}, { passive: true });
			}
			galleryParallax();
			


			/////////////////// SLIDER JOBS ///////////////////
			


			


			/////////////////// TEAM PARALLAX ///////////////////
			var teamBlock    = document.querySelector('.cbo-team');
			var teamColLeft  = document.querySelector('.cbo-team .list-left');
			var teamColRight = document.querySelector('.cbo-team .list-right');

			if (teamBlock && teamColLeft && teamColRight) {
				var TEAM_FACTOR      = 0.2;
				var teamTicking      = false;
				var teamSectionTop   = 0;
				var teamRightInit    = 0;

				function teamMeasure() {
					teamSectionTop = teamBlock.getBoundingClientRect().top + window.scrollY;

					var firstCard = teamColLeft.querySelector('.list-el');
					var teamList  = teamBlock.querySelector('.team-list');
					if (firstCard && teamList) {
						var cardH    = firstCard.offsetHeight;
						var cardStep = cardH + 14;
						teamList.style.height = (3 * cardH + 2 * 14) + 'px';
						teamRightInit = -cardStep;
						teamColRight.style.transform = 'translateY(' + teamRightInit + 'px)';
					}
				}

				function updateTeamParallax() {
					var rel = Math.max(0, window.scrollY - (teamSectionTop - window.innerHeight));
					teamColLeft.style.transform  = 'translateY(' + (-rel * TEAM_FACTOR) + 'px)';
					teamColRight.style.transform = 'translateY(' + (teamRightInit + rel * TEAM_FACTOR) + 'px)';
					teamTicking = false;
				}

				window.addEventListener('scroll', function() {
					if (!teamTicking) {
						requestAnimationFrame(updateTeamParallax);
						teamTicking = true;
					}
				}, { passive: true });

				window.addEventListener('resize', function() {
					teamMeasure();
					updateTeamParallax();
				});

				teamMeasure();
				updateTeamParallax();

				$(window).on('load', function() {
					teamMeasure();
					updateTeamParallax();
				});
			}


			


			


			/////////////////// BURGER MENU ///////////////////
			var $burger = $('.burger-menu');
			var $headerNav = $('.cbo-nav');

			$burger.on('click', function() {
				var isOpen = $headerNav.hasClass('nav--open');
				$headerNav.toggleClass('nav--open');
				$burger.toggleClass('burger-menu-cross');
				$('body').toggleClass('menu--open');
				$('html').toggleClass('html--hidden');
				$burger.attr('aria-expanded', !isOpen);
			});


			/////////////////// STICKY ///////////////////
			var stickyTicking = false;
			var $header = $('header.cbo-header');
			var surheaderH = $('.cbo-surheader').outerHeight() || 40;

			function updateSticky() {
				if (window.scrollY > surheaderH) {
					$header.addClass('header-scroll');
				} else {
					$header.removeClass('header-scroll');
				}
				stickyTicking = false;
			}
			$(window).on('scroll.sticky', function() {
				if (!stickyTicking) {
					window.requestAnimationFrame(updateSticky);
					stickyTicking = true;
				}
			});
			updateSticky();


			/////////////////// SOUS-MENU MOBILE — PANEL SYSTEM ///////////////////
			$headerNav.on('click.mobilePanel', 'li.menu-item-has-children > a', function(e) {
				if (window.innerWidth >= 1024) return;
				e.preventDefault();
				e.stopPropagation();

				var $li = $(this).closest('li.menu-item-has-children');

				if (!$li.data('panel-ready')) {
					var title = $(this).clone().children('i, .icon').remove().end().text().trim();
					$li.children('.sub-menu').prepend(
						'<div class="panel-header">' +
							'<button type="button" class="panel-back" aria-label="Retour">' +
								'<i class="icon icon--arrow-next" aria-hidden="true"></i>' +
							'</button>' +
							'<span class="panel-title">' + title + '</span>' +
						'</div>'
					);
					$li.data('panel-ready', true);
				}

				$li.addClass('panel--open');
			});

			$headerNav.on('click.panelBack', '.panel-back', function() {
				$(this).closest('li.menu-item-has-children').removeClass('panel--open');
			});

			$burger.on('click.panelReset', function() {
				if ($headerNav.hasClass('nav--open')) {
					$headerNav.find('li.menu-item-has-children.panel--open').removeClass('panel--open');
				}
			});


			/////////////////// MEGA MENU (desktop) ///////////////////
			var $backdrop  = $('.mega-backdrop');
			var megaDelay;

			$('header .menu-item-has-children').on('mouseenter', function() {
				if ($(window).width() < 1024) return;
				clearTimeout(megaDelay);
				$('header .menu-item-has-children').removeClass('mega-open');
				$(this).addClass('mega-open');
				if ($(this).hasClass('megamenu')) {
					$backdrop.addClass('backdrop--visible');
				}
			}).on('mouseleave', function() {
				if ($(window).width() < 1024) return;
				var $li = $(this);
				megaDelay = setTimeout(function() {
					$li.removeClass('mega-open');
					if (!$('header .menu-item-has-children.megamenu.mega-open').length) {
						$backdrop.removeClass('backdrop--visible');
					}
				}, 120);
			});

			$backdrop.on('click', function() {
				$('header .menu-item-has-children').removeClass('mega-open');
				$backdrop.removeClass('backdrop--visible');
			});

			$(document).on('keydown', function(e) {
				if (e.key === 'Escape') {
					$('header .menu-item-has-children').removeClass('mega-open');
					$backdrop.removeClass('backdrop--visible');
				}
			});


		

			


			/////////////////// WORD SLIDE-UP ANIMATION ///////////////////
			function initWordAnim() {
				var elements = document.querySelectorAll('[data-word-anim]');
				if (!elements.length) return;

				// Skip animation entirely if user prefers reduced motion
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
					// Store plain text for screen readers before rewriting DOM
					if (!el.getAttribute('aria-label')) {
						el.setAttribute('aria-label', el.textContent.trim());
					}
					var delay = parseFloat(el.getAttribute('data-word-delay') || 0.07);
					var counter = { value: 0 };
					walkNodes(el, delay, counter);
					// Hide visual spans from screen readers (aria-label covers the full text)
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


			//////////////// SCROLL ANIMATIONS ////////////////
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



























			













			
			/////////////////// Modales CF7 accessibles (role dialog + focus trap + Echap) ///////////////////
			function openCF7Modal(cssClass, innerHTML) {
				var previousFocus = document.activeElement;

				var modal = document.createElement('div');
				modal.className = cssClass;
				modal.setAttribute('role', 'dialog');
				modal.setAttribute('aria-modal', 'true');
				modal.setAttribute('aria-label', 'Notification');
				modal.innerHTML = innerHTML;
				document.body.appendChild(modal);

				var focusables = modal.querySelectorAll('button,[href],input,select,textarea,[tabindex]:not([tabindex="-1"])');
				var first = focusables[0];
				var last  = focusables[focusables.length - 1];

				function closeModal() {
					modal.remove();
					document.removeEventListener('keydown', handleKey);
					if (previousFocus) previousFocus.focus();
				}

				function handleKey(e) {
					if (e.key === 'Escape') {
						closeModal();
					} else if (e.key === 'Tab') {
						if (focusables.length === 1) { e.preventDefault(); return; }
						if (e.shiftKey) {
							if (document.activeElement === first) { e.preventDefault(); last.focus(); }
						} else {
							if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
						}
					}
				}

				modal.querySelector('.inner-button').addEventListener('click', closeModal);
				document.addEventListener('keydown', handleKey);
				if (first) first.focus();
			}

			document.addEventListener('wpcf7mailsent', function(event) {
				event.preventDefault();
				openCF7Modal('cbo-cf7modale',
					'<div class="cf7modale-inner">' +
						'<i class="inner-icon icon icon--success" aria-hidden="true"></i>' +
						'<p class="inner-title cbo-title-3">Votre message a bien été envoyé !</p>' +
						'<button type="button" class="inner-button cbo-button" aria-label="Fermer la fenêtre">Fermer la fenêtre</button>' +
					'</div>'
				);
			}, false);

			document.addEventListener('wpcf7mailfailed', function(event) {
				event.preventDefault();
				openCF7Modal('cbo-cf7modale cbo-cf7modale--error',
					'<div class="cf7modale-inner">' +
						'<i class="inner-icon icon icon--warning" aria-hidden="true"></i>' +
						'<p class="inner-title cbo-title-3">Une erreur s\'est produite lors de l\'envoi de votre message. Veuillez essayer à nouveau plus tard.</p>' +
						'<button type="button" class="inner-button cbo-button" aria-label="Fermer la fenêtre">Fermer la fenêtre</button>' +
					'</div>'
				);
			}, false);


			/////////////////// ADD CHECK TO ACCEPTANCE ///////////////////
			var cbo_forms = {
				init: function () {
				this.bind_checked();
				this.check_checked();
				},
				
				bind_checked: function () {
				$(".cbo-form")
					.find('input[type="radio"], input[type="checkbox"]')
					.on("change", function () {
					cbo_forms.check_checked();
					});
				},
				
				check_checked: function () {
				$(".cbo-form")
					.find('input[type="radio"], input[type="checkbox"]')
					.each(function () {
					if ($(this).is(":checked")) {
						$(this).closest(".form-field").find(".field-inner").addClass("checked");
					} else {
						$(this).closest(".form-field").find(".field-inner").removeClass("checked");
					}
					});
				},
			};
			cbo_forms.init();


			
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
/*include ../../templates/blocks/testimonials/script.js*/
/*include ../../templates/blocks/textpictureslide/script.js*/
/*include ../../templates/blocks/textpictureaccordion/script.js*/
/*include ../../templates/blocks/faqs/script.js*/
/*include ../../templates/blocks/video/script.js*/
/*include ../../templates/parts/faq/script.js*/