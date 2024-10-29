<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

if (empty($settings['width'])) {
	$settings['width'] = '768';
}

if (empty($settings['width-mobile'])) {
	$settings['width'] = '200';
}

if (empty($settings['height'])) {
	$settings['height'] = '384';
}

if (empty($settings['height-mobile'])) {
	$settings['height-mobile'] = '100';
}

?>

<style>
	#ave-image-hue-rotate-<?php echo $post_id; ?> .adv-vis-ele-image-hue-rotate-c {
		width: <?php echo $settings['width']; ?>px;
		height: <?php echo $settings['height']; ?>px;
		background-image: url(<?php echo $settings['image']; ?>);
		animation: adv-vis-ele-image-hue-rotate-animation <?php echo $settings['speed']; ?>s linear infinite;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-image-hue-rotate-<?php echo $post_id; ?> .adv-vis-ele-image-hue-rotate-c {
			width: <?php echo $settings['width-mobile']; ?>px;
			height: <?php echo $settings['height-mobile']; ?>px;
		}
	}
</style>

<div id="ave-image-hue-rotate-<?php echo $post_id; ?>" class="adv-vis-ele-image-hue-rotate">
	<div class="adv-vis-ele-image-hue-rotate-c"></div>
</div>