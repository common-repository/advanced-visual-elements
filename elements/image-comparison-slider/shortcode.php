<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-image-comparison-slider-<?php echo $post_id; ?> .adv-vis-ele-image-comparison-slider-image-container {
		width: <?php echo $settings['width']; ?>px;
	}
	#ave-image-comparison-slider-<?php echo $post_id; ?> .adv-vis-ele-image-comparison-slider-resize-img {
		background: url("<?php echo $settings['image-1']; ?>") no-repeat left top;
		background-size: auto 100%;
	}
	#ave-image-comparison-slider-<?php echo $post_id; ?> .adv-vis-ele-image-comparison-slider-handle {
		background: #fff url("<?php echo esc_url(ADV_VIS_ELE_ELEMENTS_URL . '/image-comparison-slider/left-right-arrow-icon.svg'); ?>");
		background-size: 66%;
		background-repeat: no-repeat;
		background-position: center;
	}
	.adv-vis-ele-image-comparison-slider-image-label {
		color: <?php echo $settings['caption-text-color']; ?>;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-image-comparison-slider-<?php echo $post_id; ?> .adv-vis-ele-image-comparison-slider-image-container {
			width: <?php echo $settings['width-mobile']; ?>px;
		}
	}
</style>

<div id="ave-image-comparison-slider-<?php echo $post_id; ?>" class="adv-vis-ele-image-comparison-slider">
	<div class="adv-vis-ele-image-comparison-slider-image-container">
		<img src="<?php echo $settings['image-2']; ?>" alt="<?php echo $settings['image-2-caption']; ?>">
		<span class="adv-vis-ele-image-comparison-slider-image-label" data-type="original"><?php echo $settings['image-2-caption']; ?></span>

		<div class="adv-vis-ele-image-comparison-slider-resize-img">
			<span class="adv-vis-ele-image-comparison-slider-image-label" data-type="modified"><?php echo $settings['image-1-caption']; ?></span>
		</div>

		<span class="adv-vis-ele-image-comparison-slider-handle"></span>
	</div>
</div>