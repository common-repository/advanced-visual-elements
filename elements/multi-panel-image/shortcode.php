<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

if (empty($settings['width'])) {
	$settings['width'] = '768';
}

if (empty($settings['width-mobile'])) {
	$settings['width-mobile'] = '300';
}

?>

<style>
	#ave-multi-panel-image-<?php echo $post_id; ?>.adv-vis-ele-multi-panel-image {
		width: <?php echo $settings['width']; ?>px;
	}
	#ave-multi-panel-image-<?php echo $post_id; ?> .multi-panel-image-side {
		background-image: url(<?php echo $settings['image']; ?>);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-multi-panel-image-<?php echo $post_id; ?>.adv-vis-ele-multi-panel-image {
			width: <?php echo $settings['width-mobile']; ?>px;
		}
	}
</style>

<div id="ave-multi-panel-image-<?php echo $post_id; ?>" class="adv-vis-ele-multi-panel-image">
	<div class="multi-panel-image-c">
		<div class="multi-panel-image-block">
			<div class="multi-panel-image-side multi-panel-image-main"></div>
			<div class="multi-panel-image-side multi-panel-image-left"></div>
		</div>
		<div class="multi-panel-image-block">
			<div class="multi-panel-image-side multi-panel-image-main"></div>
			<div class="multi-panel-image-side multi-panel-image-left"></div>
		</div>
		<div class="multi-panel-image-block">
			<div class="multi-panel-image-side multi-panel-image-main"></div>
			<div class="multi-panel-image-side multi-panel-image-left"></div>
		</div>
	</div>
</div>