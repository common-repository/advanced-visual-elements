jQuery(document).ready(function ($) {
	let options = $(".adv-vis-ele-expanding-image-cards-option");

	options.click(function () {
		$(this).parent().children().removeClass("adv-vis-ele-expanding-image-cards-active");

		$(this).addClass("adv-vis-ele-expanding-image-cards-active");
	});
});