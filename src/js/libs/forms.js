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
})(jQuery);