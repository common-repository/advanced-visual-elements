<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-outter {
		width: <?php echo $settings['bar-width']; ?>px;
		border-radius: <?php echo $settings['border-radius']; ?>px;
	}
	#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-bg {
		height: <?php echo $settings['bar-height']; ?>px;
	<?php
	
	if($settings['use-inset-background']) {
		echo 'box-shadow: inset 0 5px 10px #1d2327;';
	}
	
	if($settings['use-background-color-gradient']) {
		echo 'background: linear-gradient(90deg, ' . $settings['background-color'] . ' 0%, ' . $settings['background-color-2'] . ' 100%);';
	} else {
		echo 'background: ' . $settings['background-color'];
	}
	
	?>
	}
	#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-bg-color {
		transition: width <?php echo $settings['fill-duration']; ?>s;
	<?php

	if($settings['use-inset-background']) {
		echo 'box-shadow: inset -3px 0 5px #ffffff;';
	}

	if($settings['use-progress-bar-color-gradient']) {
		echo 'background: linear-gradient(90deg, ' . $settings['fill-bar-color'] . ' 0%, ' . $settings['fill-bar-color-2'] . ' 100%);';
	} else {
		echo 'background: ' . $settings['fill-bar-color'];
	}
	
	?>
	}
	#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-title-text {
		color: <?php echo $settings['text-color']; ?>;
		font-size: <?php echo $settings['font-size']; ?>px;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-outter {
			width: <?php echo $settings['bar-width-mobile']; ?>px;
		}
		#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-bg {
			height: <?php echo $settings['bar-height-mobile']; ?>px;
		}
		#ave-progress-bar-<?php echo $post_id; ?> .adv-vis-ele-progress-bar-title-text {
			font-size: <?php echo $settings['font-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-progress-bar-<?php echo $post_id; ?>" class="adv-vis-ele-progress-bar">
	<div class="adv-vis-ele-progress-bar-outter">
		<div class="adv-vis-ele-progress-bar-bg">
			<div class="adv-vis-ele-progress-bar-bg-color" data-width="<?php echo $settings['fill-percentage']; ?>"></div>
		</div>
		<div class="adv-vis-ele-progress-bar-title">
			<div class="adv-vis-ele-progress-bar-title-text"><?php echo $settings['inner-text']; ?></div>
		</div>
	</div>
</div>