(function($) {
	/////////////////// STICKY ///////////////////
	var stickyTicking = false;
	var $header = $('header.cbo-header');
	var surheaderH = $('.cbo-surheader').outerHeight() || 40;

	function updateHeaderOffset() {
		var h = $header.length ? $header[0].getBoundingClientRect().height : 160;
		document.documentElement.style.scrollPaddingTop = (h + 20) + 'px';
	}

	function updateSticky() {
		if (window.scrollY > surheaderH) {
			$header.addClass('header-scroll');
		} else {
			$header.removeClass('header-scroll');
		}
		updateHeaderOffset();
		stickyTicking = false;
	}
	$(window).on('scroll.sticky', function() {
		if (!stickyTicking) {
			window.requestAnimationFrame(updateSticky);
			stickyTicking = true;
		}
	});
	$(window).on('resize.headerOffset load', updateHeaderOffset);
	updateSticky();

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

	/////////////////// SOUS-MENU MOBILE — PANEL SYSTEM ///////////////////
	$headerNav.on('click.mobilePanel', 'li.menu-item-has-children > a', function(e) {
		if (window.innerWidth >= 1280) return;
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
	var $backdrop     = $('.mega-backdrop');
	var megaDelay;
	var $desktopItems = $('header .menu-item-has-children');

	// Init aria-expanded sur les liens parents
	$desktopItems.children('a').attr('aria-expanded', 'false');

	function desktopOpenMenu($li) {
		clearTimeout(megaDelay);
		$desktopItems.removeClass('mega-open').children('a').attr('aria-expanded', 'false');
		$li.addClass('mega-open').children('a').attr('aria-expanded', 'true');
		if ($li.hasClass('megamenu')) {
			$backdrop.addClass('backdrop--visible');
		}
	}

	function desktopCloseMenu($li) {
		$li.removeClass('mega-open').children('a').attr('aria-expanded', 'false');
		if (!$desktopItems.filter('.megamenu.mega-open').length) {
			$backdrop.removeClass('backdrop--visible');
		}
	}

	function desktopCloseAll() {
		$desktopItems.removeClass('mega-open').children('a').attr('aria-expanded', 'false');
		$backdrop.removeClass('backdrop--visible');
	}

	// Souris
	$desktopItems.on('mouseenter', function() {
		if ($(window).width() < 1024) return;
		desktopOpenMenu($(this));
	}).on('mouseleave', function() {
		if ($(window).width() < 1024) return;
		var $li = $(this);
		megaDelay = setTimeout(function() {
			desktopCloseMenu($li);
		}, 120);
	});

	// Clavier : focusin ouvre, focusout ferme si le focus sort du <li> entier
	$desktopItems.on('focusin', function() {
		if ($(window).width() < 1024) return;
		desktopOpenMenu($(this));
	}).on('focusout', function() {
		if ($(window).width() < 1024) return;
		var li = this;
		setTimeout(function() {
			if (!li.contains(document.activeElement)) {
				desktopCloseMenu($(li));
			}
		}, 0);
	});

	$backdrop.on('click', function() {
		desktopCloseAll();
	});

	$(document).on('keydown', function(e) {
		if (e.key === 'Escape') {
			var $open = $desktopItems.filter('.mega-open');
			if ($open.length) {
				var $parentLink = $open.children('a').first();
				desktopCloseAll();
				$parentLink.focus();
			}
		}
	});

	/////////////////// MEGA MENU — SIDEBAR PANEL SWITCH ///////////////////
	function switchMegaPanel($sidebarItem) {
		if ($(window).width() < 1283) return;
		var $container = $sidebarItem.closest('.mega-container');
		var panelId    = $sidebarItem.data('panel');
		$container.find('.sidebar-item').removeClass('is-active');
		$sidebarItem.addClass('is-active');
		$container.find('.mega-panel').removeClass('is-active');
		$container.find('#' + panelId).addClass('is-active');
	}

	$headerNav.on('mouseenter', '.sidebar-item', function() {
		switchMegaPanel($(this));
	});

	$headerNav.on('focusin', '.sidebar-item .sidebar-link', function() {
		switchMegaPanel($(this).closest('.sidebar-item'));
	});
})(jQuery);