jQuery(document).ready(function ($) {
	$('.adv-vis-ele-image-comparison-slider').each(function() {
		aveImageComparisonSliderDrags($(this).find('.adv-vis-ele-image-comparison-slider-handle'), $(this).find('.adv-vis-ele-image-comparison-slider-resize-img'), $(this).find('.adv-vis-ele-image-comparison-slider-image-container'));
	});

	// draggable funtionality - credits to https://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/
	function aveImageComparisonSliderDrags(dragElement, resizeElement, container) {
		dragElement.on("mousedown vmousedown", function (e) {
			dragElement.addClass('draggable');
			resizeElement.addClass('resizable');

			let dragWidth = dragElement.outerWidth(),
				xPosition = dragElement.offset().left + dragWidth - e.pageX,
				containerOffset = container.offset().left,
				containerWidth = container.outerWidth(),
				minLeft = containerOffset + 10,
				maxLeft = containerOffset + containerWidth - dragWidth - 10;

			dragElement.parents().on("mousemove vmousemove", function (e) {
				let leftValue = e.pageX + xPosition - dragWidth;

				if (leftValue < minLeft) {
					leftValue = minLeft;
				} else if (leftValue > maxLeft) {
					leftValue = maxLeft;
				}

				let widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';

				$('.draggable').css('left', widthValue).on("mouseup vmouseup", function () {
					$(this).removeClass('draggable');
					resizeElement.removeClass('resizable');
				});

				$('.resizable').css('width', widthValue);

			}).on("mouseup vmouseup", function () {
				dragElement.removeClass('draggable');

				resizeElement.removeClass('resizable');
			});

			e.preventDefault();
		}).on("mouseup vmouseup", function () {
			dragElement.removeClass('draggable');
			resizeElement.removeClass('resizable');
		});
	}
});