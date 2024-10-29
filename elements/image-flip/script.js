"use strict";
(function ($) {
	$(window).on('load', (function () {
		let c = $('.adv-vis-ele-image-flip-c');

		c.each(function() {
			let s = '';

			if($(this).attr('data-type') === 'switch') {
				s = '.adv-vis-ele-image-flip-switch';
			} else {
				s = 'img';
			}

			$(this).on('click', s, function (e) {
				e.stopPropagation();

				let p = $(this).closest('.adv-vis-ele-image-flip-c');

				let d = p.attr('data-flip');

				p.toggleClass(d);
			});
		});
	}));
})(jQuery);