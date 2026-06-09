/*include /libs/slick.js*/

(function($) { 
	
	var Master = {
		onready : function(){

			//////////////////// FOOTER ////////////////////
			$('footer .footer-menu .menu-item').on('click', function(){
				$('footer .footer-menu .menu-item').not(this).removeClass('active');
				$(this).toggleClass('active');
			});


			/////////////////// SLIDER ARTICLES ///////////////////
			function initArticlesSlider() {
				var $list = $('.cbo-articles.articles--relationship .articles-list, .cbo-casestudies .casestudies-list');
				if (!$list.length || typeof $.fn.slick === 'undefined') return;
				var width = $(window).width();
				if (width < 1024) {
					var slidesToShow = width < 767 ? 1 : 2;
					if ($list.hasClass('slick-initialized')) {
						$list.slick('slickSetOption', 'slidesToShow', slidesToShow, true);
						$list.slick('slickSetOption', 'slidesToScroll', slidesToShow, true);
					} else {
						$list.slick({
							arrows: false,
							dots: true,
							infinite: false,
							slidesToShow: slidesToShow,
							slidesToScroll: slidesToShow
						});
					}
				} else {
					if ($list.hasClass('slick-initialized')) {
						$list.slick('unslick');
					}
				}
			}

			initArticlesSlider();
			$(window).on('resize', initArticlesSlider);


			/////////////////// SLIDER PARTNERS ///////////////////
			$('.cbo-partners .partners-list').each(function(){
				var $slider = $(this);
				$slider.append($slider.html());
				$slider.slick({
					arrows: false,
					dots: false,
					infinite: true,
					slidesToShow: 8,
					slidesToScroll: 1,
					speed: 4000,
					autoplay: true,
					autoplaySpeed: 0,
					cssEase: 'linear',
					variableWidth: false,
					responsive: [
						{ breakpoint: 991, settings: { slidesToShow: 5 } },
						{ breakpoint: 767, settings: { slidesToShow: 4 } },
						{ breakpoint: 500, settings: { slidesToShow: 2 } }
					]
				});
			});


			/////////////////// SLIDER TESTIMONIALS ///////////////////
			$('.cbo-testimonials.testimonials--relationship .testimonials-list').slick({
				arrows: false,
				dots: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: false,
				responsive: [
					{
						breakpoint: 1283,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 767,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			});


			/////////////////// SLIDER GALLERY ///////////////////
			$('.cbo-gallery .gallery-list').slick({
				arrows: false,
				dots: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				centerMode: true,
				centerPadding: '20%',
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							centerPadding: '120px',
						}
					},
					{
						breakpoint: 767,
						settings: {
							centerPadding: '30px',
						}
					}
				]
			});


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


			/////////////////// BIG TEXT FIT (keynumbers + cardslider) ///////////////////
			function fitKeyNumbersBigText() {
				document.querySelectorAll('.keynumbers-bigtxt, .cardslider-bigtxt').forEach(function(el) {
					el.style.fontSize = '100px';
					var maxWidth = el.classList.contains('cardslider-bigtxt') ? Math.min(window.innerWidth, 1400) : window.innerWidth;
					var ratio = maxWidth / el.scrollWidth;
					var fontSize = Math.floor(110 * ratio);
					el.style.fontSize = fontSize + 'px';

					if (el.classList.contains('cardslider-bigtxt')) {
						el.style.top = '0';
					}
				});
			}
			fitKeyNumbersBigText();
			$(window).on('resize', fitKeyNumbersBigText);


			/////////////////// SLIDER JOBS ///////////////////
			$('.cbo-jobslider .jobslider-list').slick({
				arrows: true,
				dots: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				centerMode: true,
				centerPadding: '245px',
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							centerPadding: '40px',
						}
					}
				]
			});


			/////////////////// CARD STACK - CARDSLIDER ///////////////////
			var $cardList = $('.cbo-cardslider .cardslider-list');
			if ($cardList.length) {
				var $cardItems   = $cardList.find('> .list-el');
				var $cardTabs    = $('.cbo-cardslider .cardslider-tabs .tab-el');
				var $cardPrev    = $('.cbo-cardslider .nav-btn--prev');
				var $cardNext    = $('.cbo-cardslider .nav-btn--next');
				var cardTotal   = $cardItems.length;
				var cardCurrent = 0;
				var cardBusy    = false;
				var OFFSET      = 20;

				function renderCardStack() {
					$cardItems.each(function(i) {
						var pos = ((i - cardCurrent) + cardTotal) % cardTotal;
						var isActive = pos === 0;
						$(this)
							.data('stack-pos', pos)
							.css({
								'z-index' : cardTotal - pos,
								'top'     : ((cardTotal - 1 - pos) * OFFSET) + 'px',
								'left'    : (pos * OFFSET) + 'px',
							})
							.toggleClass('stack-active', isActive)
							.attr('aria-hidden', isActive ? 'false' : 'true');
					});
					$cardTabs
						.attr('aria-selected', 'false')
						.removeClass('active')
						.eq(cardCurrent)
						.addClass('active')
						.attr('aria-selected', 'true');
					updateCardHeight();
				}

				function updateCardHeight() {
					var $front = $cardList.find('.stack-active');
					if ($front.length) {
						$cardList.height($front.outerHeight() + (cardTotal - 1) * OFFSET);
					}
				}

				function goToCard(index) {
					if (cardBusy) return;
					cardBusy = true;
					cardCurrent = ((index % cardTotal) + cardTotal) % cardTotal;
					renderCardStack();
					setTimeout(function() { cardBusy = false; }, 450);
				}

				$cardPrev.on('click', function() { goToCard(cardCurrent - 1); });
				$cardNext.on('click', function() { goToCard(cardCurrent + 1); });

				$cardTabs.on('click', function() { goToCard($(this).index()); });

				$cardItems.on('click', function() {
					var pos = $(this).data('stack-pos');
					if (pos > 0) { goToCard(cardCurrent + pos); }
				});

				renderCardStack();
				$(window).on('resize', updateCardHeight);
			}


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


			/////////////////// VIDEO SCROLL EXPAND ///////////////////
			var videoTrack = document.querySelector('.cbo-video');
			if (videoTrack) {
				var videoInner           = videoTrack.querySelector('.video-inner');
				var videoExpandContainer = videoTrack.querySelector('.video-file');
				var videoExpandEl        = videoTrack.querySelector('.cbo-video-element');

				if (videoExpandContainer && videoExpandEl) {
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
						var rect    = videoTrack.getBoundingClientRect();
						var headerH = parseFloat(document.documentElement.style.getPropertyValue('--video-header-h')) || 0;
						var h       = (window.innerHeight - headerH) + 'px';
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
						var animRange = (videoTrack.offsetHeight - window.innerHeight) / 2;
						return Math.max(0, Math.min(1, -rect.top / animRange));
					}

					function videoRender(sp) {
						var p     = -(Math.cos(Math.PI * sp) - 1) / 2;
						var scale = 0.5 + 0.5 * p;
						var br    = (20 * (1 - p)) / scale;

						videoExpandContainer.style.transform    = 'scale(' + scale + ')';
						videoExpandContainer.style.borderRadius = br + 'px';
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

					$(window).on('resize.videoExpand', function () {
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
				}
			}


			/////////////////// SMARTPHONE NAVIGATION ///////////////////
			$('.burger-menu').on('click', function(){
				$('.header-nav').toggleClass('nav--open');
				$('.burger-menu').toggleClass('burger-menu-cross');
				$('body').toggleClass('menu--open');
				$('html').toggleClass('html--hidden');
			});


			/////////////////// Burger menu - Accessibilité ///////////////////
			var burger = document.querySelector('.burger-menu');
			var nav = document.querySelector('.header-nav');
			if (burger && nav) {
				burger.addEventListener('click', function () {
					var expanded = burger.getAttribute('aria-expanded') === 'true';
					burger.setAttribute('aria-expanded', !expanded);
					burger.classList.toggle('is-active');
					nav.classList.toggle('is-open');
				});
			}


			//////////////// STICKY ////////////////
			var stickyTicking = false;
			var $header = $('header');
			function updateSticky() {
				if (window.scrollY > 80) {
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


			///////////////////  SOUS-MENU ///////////////////
			$('header .menu-item-has-children').on('click', function (e) {
				e.stopPropagation();
				var parentLi = $(this);
				$('header .menu-item-has-children').not(parentLi).find('.sub-menu').removeClass('submenu--open');
				$('header .menu-item-has-children').not(parentLi).removeClass('active');
				parentLi.find('.sub-menu').toggleClass('submenu--open');
				parentLi.toggleClass('active');
			});


			//////////////// ACCORDION ////////////////
			function initAccordion($container) {
				$container.find('.accordion-list .el-title').off('click').on('click', function(){
					var $btn = $(this);
					var $el = $btn.closest('.list-el');
					var $content = $('#' + $btn.attr('aria-controls'));
					var open = $btn.attr('aria-expanded') === 'true';

					// Fermer les autres
					$el.siblings('.list-el.el--open').each(function() {
						var $c = $(this).find('.el-content');
						$(this).removeClass('el--open').find('.el-title').attr('aria-expanded', 'false');
						$c.css('height', $c[0].scrollHeight + 'px');
						$c[0].offsetHeight;
						$c.css('height', '0');
						setTimeout(function(){ $c.attr('hidden', ''); }, 300);
					});

					// Toggle celui-ci
					if(open){
						$btn.attr('aria-expanded', 'false');
						$el.removeClass('el--open');
						$content.css('height', $content[0].scrollHeight + 'px');
						$content[0].offsetHeight;
						$content.css('height', '0');
						setTimeout(function(){ $content.attr('hidden', ''); }, 300);
					} else {
						$btn.attr('aria-expanded', 'true');
						$el.addClass('el--open');
						$content.removeAttr('hidden');
						var fullHeight = $content[0].scrollHeight + 'px';
						$content.css('height', '0');
						$content[0].offsetHeight;
						$content.css('height', fullHeight);
						setTimeout(function(){ $content.css('height', 'auto'); }, 300);
					}
				});
			}

			$(document).ready(function(){
				initAccordion($('.cbo-accordionpicture'));
				initAccordion($('.cbo-accordion'));
			});


			//////////////// TEXTPICTURESLIDE STICKY SCROLL ////////////////
			(function() {
				var section = document.querySelector('.cbo-textpictureslide');
				if (!section) return;

				var contentEls = section.querySelectorAll('.list-el');
				var imageEls   = section.querySelectorAll('.image-el');

				if (!contentEls.length || !imageEls.length) return;

				var currentActive = -1;
				var triggerLine = window.innerHeight * 0.25;

				function updateActiveImage() {
					var newActive = 0;
					for (var i = 0; i < contentEls.length; i++) {
						if (contentEls[i].getBoundingClientRect().top <= triggerLine) {
							newActive = i;
						} else {
							break;
						}
					}
					if (newActive !== currentActive) {
						imageEls.forEach(function(img) { img.classList.remove('is-active'); });
						var active = section.querySelector('.image-el[data-index="' + newActive + '"]');
						if (active) active.classList.add('is-active');
						currentActive = newActive;
					}
				}

				updateActiveImage();
				$(window).on('scroll.textpictureslide', function() {
					window.requestAnimationFrame(updateActiveImage);
				});
			})();


			/////////////////// WORD SLIDE-UP ANIMATION ///////////////////
			function initWordAnim() {
				var elements = document.querySelectorAll('[data-word-anim]');
				if (!elements.length) return;

				function escHtml(str) {
					return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				}

				elements.forEach(function(el) {
					var words = el.textContent.trim().split(/\s+/);
					var delay = parseFloat(el.getAttribute('data-word-delay') || 0.07);
					var html  = '';
					words.forEach(function(word, i) {
						html += '<span class="word-wrapper">'
							+ '<span class="word-anim" style="animation-delay:' + (i * delay) + 's">'
							+ escHtml(word)
							+ '</span></span>';
						if (i < words.length - 1) html += ' ';
					});
					el.innerHTML = html;
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