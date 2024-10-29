jQuery(document).ready(function($) {
	let progress_bars = $('.adv-vis-ele-progress-bar');

	if (progress_bars.length > 0) {
		$(document).on('scroll', function () {
			checkIfProgressBarsNeedAnimating();
		});
	}

	function checkIfProgressBarsNeedAnimating() {
		progress_bars.each(function (index, element) {
			if ($(element).hasClass('progress-bars-sport-finished-animating')) {
				return;
			}

			if (isScrolledIntoView($(element))) {
				let width = $(element).find('.adv-vis-ele-progress-bar-bg-color')[0].getAttribute('data-width');

				$(element).find('.adv-vis-ele-progress-bar-bg-color').css('width', width + '%');

				$(element).addClass('progress-bars-sport-finished-animating');
			}
		});
	}

	checkIfProgressBarsNeedAnimating();

	function isScrolledIntoView(elem) {
		let docViewTop = $(window).scrollTop();
		let docViewBottom = docViewTop + $(window).height();

		let elemTop = elem.offset().top;
		let elemBottom = elemTop + elem.height();

		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}
});