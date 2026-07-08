(function($) {
	var teamBlock    = document.querySelector('.cbo-team');
	var teamColLeft  = document.querySelector('.cbo-team .list-left');
	var teamColRight = document.querySelector('.cbo-team .list-right');

	if (!teamBlock || !teamColLeft || !teamColRight) return;

	var TEAM_FACTOR    = 0.2;
	var teamTicking    = false;
	var teamSectionTop = 0;
	var teamRightInit  = 0;

	function teamMeasure() {
		teamSectionTop = teamBlock.getBoundingClientRect().top + window.scrollY;

		var firstCard = teamColLeft.querySelector('.list-el');
		var teamList  = teamBlock.querySelector('.team-list');
		if (!firstCard || !teamList) return;

		var cardH    = firstCard.offsetHeight;
		var cardStep = cardH + 14;
		teamList.style.height        = (3 * cardH + 2 * 14) + 'px';
		teamRightInit                = -cardStep;
		teamColRight.style.transform = 'translateY(' + teamRightInit + 'px)';
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
})(jQuery);
