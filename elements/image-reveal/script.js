jQuery(document).ready(function ($) {
	$('.adv-vis-ele-image-reveal').each(function () {
		let post_id = $(this).closest('.adv-vis-ele-shortcode-render-container').attr('data-post-id');

		let $t = $(this);

		if ($(window).width() < parseInt(ave_element_settings[post_id]['mobile_breakpoint'])) {
			if (ave_element_settings[post_id]['show-on-mobile']) {
				$(this).find('.adv-vis-ele-image-reveal-front').css({
					'transition': 'opacity 1s',
					'opacity': 0,
					'z-index': 1,
				});

				$(this).find('.adv-vis-ele-image-reveal-back').css({
					'transition': 'opacity 1s',
					'opacity': 1,
					'z-index': 4,
				});

				return;
			}
		}

		$t.find('.adv-vis-ele-image-reveal-back').on('mousemove', function (e) {
			let parentOffset = $(this).parent().offset();

			let relX = (e.pageX - parentOffset.left);
			let relY = (e.pageY - parentOffset.top);

			$(this).css({
				'opacity': 1,
				'clip-path': 'circle(' + ave_element_settings[post_id]['reveal-circle-size'] + 'px at ' + relX + 'px ' + relY + 'px)',
				'cursor': 'none'
			});

			$(this).next('.adv-vis-ele-image-reveal-zoom').css({'left': relX, 'top': relY});
		}).on('mouseleave', function () {
			$(this).css({
				'opacity': 0,
				'clip-path': 'none',
				'cursor': 'initial'
			});

			$(this).next('.adv-vis-ele-image-reveal-zoom').hide().css('z-index', 0);
		});

		$t.find('.adv-vis-ele-image-reveal-container').on('mouseenter', function (e) {
			let parentOffset = $(this).parent().offset();

			let relX = (e.pageX - parentOffset.left);
			let relY = (e.pageY - parentOffset.top);

			$(this).find('.adv-vis-ele-image-reveal-back').css({
				'z-index': 4,
				'clip-path': 'circle(' + ave_element_settings[post_id]['reveal-circle-size'] + 'px at ' + relX + 'px ' + relY + 'px)',
				'cursor': 'none'
			});

			$(this).find('.adv-vis-ele-image-reveal-zoom').show().css({
				'z-index': 3,
				'left': relX,
				'top': relY
			});
		});
	});
});