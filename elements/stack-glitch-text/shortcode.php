<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-stack-glitch-text-<?php echo $post_id; ?> .adv-vis-ele-stack-glitch-text-stack span {
		font-size: <?php echo $settings['text-size']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-stack-glitch-text-<?php echo $post_id; ?> .adv-vis-ele-stack-glitch-text-stack span {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-stack-glitch-text-<?php echo $post_id; ?>" class="adv-vis-ele-stack-glitch-text">
	<div class="adv-vis-ele-stack-glitch-text-stack">
		<span><?php echo $settings['text']; ?></span>
		<span><?php echo $settings['text']; ?></span>
		<span><?php echo $settings['text']; ?></span>
	</div>
</div>