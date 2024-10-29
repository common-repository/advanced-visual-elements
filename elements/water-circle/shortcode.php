<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-water-circle-<?php echo $post_id; ?> {
		width: <?php echo $settings['circle-size']; ?>px;
		height: <?php echo $settings['circle-size']; ?>px;
	}
	#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-inner {
		width: <?php echo $settings['circle-size']; ?>px;
		height: <?php echo $settings['circle-size']; ?>px;
		background: <?php echo $settings['primary-color']; ?>;
		border: 5px solid <?php echo $settings['primary-color']; ?>;
	}
	#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-text {
		color: <?php echo $settings['primary-color']; ?>;
		font-size: <?php echo $settings['text-size']; ?>px;
	}
	#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-wave {
		background-color: <?php echo $settings['primary-color']; ?>;
	}
	#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-wave:before {
		background-color: <?php echo $settings['secondary-color']; ?>;
		animation: adv-vis-ele-water-circle-animate <?php echo $settings['wave-speed']; ?>s linear infinite;
	}
	#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-wave:after {
		background-color: <?php echo $settings['secondary-color']; ?>;
		animation: adv-vis-ele-water-circle-animate <?php echo $settings['wave-speed']; ?>s linear infinite;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-inner {
			width: <?php echo $settings['circle-size-mobile']; ?>px;
			height: <?php echo $settings['circle-size-mobile']; ?>px;
		}
		#ave-water-circle-<?php echo $post_id; ?> .adv-vis-ele-water-circle-text {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-water-circle-<?php echo $post_id; ?>" class="adv-vis-ele-water-circle">
	<div class="adv-vis-ele-water-circle-inner">
		<div class="adv-vis-ele-water-circle-wave"></div>
		<div class="adv-vis-ele-water-circle-text"><?php echo $settings['text']; ?></div>
	</div>
</div>