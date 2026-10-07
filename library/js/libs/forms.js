(function($) {
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

	/* Complianz - placeholder reCaptcha Gravity Forms : affiché uniquement sans consentement
	   marketing. Complianz l'injecte à chaque chargement, le CSS le masque par défaut. */
	function cbo_toggle_recaptcha_notice() {
		var noConsent = typeof window.cmplz_has_consent === 'function' && !window.cmplz_has_consent('marketing');
		document.documentElement.classList.toggle('cbo-cmplz-no-marketing', noConsent);
	}
	cbo_toggle_recaptcha_notice();
	document.addEventListener('DOMContentLoaded', cbo_toggle_recaptcha_notice);
	document.addEventListener('cmplz_status_change', cbo_toggle_recaptcha_notice);
	document.addEventListener('cmplz_enable_category', cbo_toggle_recaptcha_notice);

	/* Complianz - placeholder reCaptcha Gravity Forms : au clic, ouvre la fenêtre de
	   gestion des cookies au lieu d'accepter directement la catégorie marketing.
	   Écoute en phase de capture pour passer avant le handler Complianz (délégué sur document). */
	document.addEventListener('click', function (e) {
		if (!e.target.closest('.cmplz-gf-recaptcha')) return;
		e.preventDefault();
		e.stopImmediatePropagation();

		var manageBtn = document.querySelector('button.cmplz-manage-consent');
		if (manageBtn) {
			manageBtn.click();
		} else if (typeof window.cmplz_set_banner_status === 'function') {
			window.cmplz_set_banner_status('show');
		}
	}, true);
})(jQuery);