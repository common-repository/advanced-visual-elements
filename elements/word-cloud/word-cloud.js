jQuery(document).ready(function ($) {
	$('.adv-vis-ele-word-cloud').each(function () {
		var $t = $(this);

		var rc = $(this).closest('.adv-vis-ele-shortcode-render-container');

		var post_id = rc.attr('data-post-id');
		var selector = '#ave-word-cloud-' + post_id;

		var mobileBreakpoint = rc.attr('data-mobile-breakpoint');

		var words = [];
		var colors = [];
		var minSize = parseInt($t.attr('data-min-size')) || 14;
		var maxSize = parseInt($t.attr('data-max-size')) || 30;

		for (var i = 1; i <= 5; i++) {
			colors.push($t.attr('data-color-' + i));
		}

		$t.find('.adv-vis-ele-word-cloud-word').each(function () {
			words.push({'text': $(this).attr('data-text'), 'url': $(this).attr('data-url')});
		});

		var width = $(window).width() < mobileBreakpoint ? $t.attr('data-width-mobile') : $t.attr('data-width');
		var height = $(window).width() < mobileBreakpoint ? $t.attr('data-height-mobile') : $t.attr('data-height');

		for (var i = 0; i < words.length; i++) {
			words[i].size = minSize + Math.random() * maxSize;
		}

		d3.layout.cloud()
			.size([width, height])
			.words(words)
			.padding(10)
			.rotate(function () {
				return ~~(Math.random() * 2) * 90;
			})
			.fontSize(function (d) {
				return d.size;
			})
			.on("end", draw)
			.start();

		function draw(words) {
			d3.select(selector)
				.append("svg")
				.attr("width", width)
				.attr("height", height)
				.append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
				.selectAll("text")
				.data(words)
				.enter()
				.append("text")
				.style("font-size", function (d) {
					return d.size + "px";
				})
				.style('font-weight', 'bold')
				.attr("text-anchor", "middle")
				.attr("transform", function (d) {
					return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
				})
				.text(function (d) {
					return d.text;
				})
				.on("click", function (d, i) {
					window.open(i.url, $t.attr('data-new-tab'));
				});

			d3.selectAll(selector + ' g text').each(function (d) {
				d3.select(this).attr('fill', function (d) {
					return colors[Math.floor(Math.random() * colors.length)].toLowerCase();
				});
			});
		}
	});
});