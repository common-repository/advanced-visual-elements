<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

if (empty($settings['scale'])) {
	$settings['scale'] = '1.0';
}

if (empty($settings['scale-mobile'])) {
	$settings['scale-mobile'] = '1.0';
}

$scale = number_format($settings['scale'], 2, '.', '');
$scale_mobile = number_format($settings['scale-mobile'], 2, '.', '');

?>

<style>
	#ave-rotating-gallery-<?php echo $post_id; ?> .adv-vis-ele-rotating-gallery {
		transform: scale(<?php echo $scale; ?>);
	}
	#ave-rotating-gallery-<?php echo $post_id; ?> .adv-vis-ele-rotating-gallery-c {
		animation: adv-vis-ele-rotating-gallery-rotate <?php echo $settings['rotation-speed']; ?>s linear infinite;
	}
	<?php

	$k = 0;
	for ($i = 1; $i <= 8; $i++) {
		if (!empty($settings['image-' . $i])) {
			$k++;
		}
	}
	
	$deg = number_format(360 / $k, 0,  '.', '');
	
	for($i = 1; $i <= $k; $i++) {
		if($i === 1) {
			echo '#ave-rotating-gallery-' . $post_id . ' .adv-vis-ele-rotating-gallery-c div {transform: rotateY(calc(1 * '. $deg .'deg)) translateZ(380px);}';
		} else {
			echo '#ave-rotating-gallery-' . $post_id . ' .adv-vis-ele-rotating-gallery-c div:nth-child(' . $i . ') {transform: rotateY(calc(' . $i . ' * '. $deg .'deg)) translateZ(380px);}';
		}
	}
	?>
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-rotating-gallery-<?php echo $post_id; ?> .adv-vis-ele-rotating-gallery {
			transform: scale(<?php echo $scale_mobile; ?>);
		}
	}
</style>

<div id="ave-rotating-gallery-<?php echo $post_id; ?>" class="adv-vis-ele-rotating-gallery">
	<div class="adv-vis-ele-rotating-gallery-c">
		<?php
		for ($i = 1; $i <= 8; $i++) {
			if (!empty($settings['image-' . $i])) {
				echo '<div>';
				echo '<img src="' . $settings['image-' . $i] . '" alt="' . $settings['image-' . $i . '-alt'] . '"/>';
				echo '</div>';
			}
		}
		?>
	</div>
</div>