<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-sliced-text-<?php echo $post_id; ?> .adv-vis-ele-sliced-text-wrapper {
		font-size: <?php echo $settings['text_size']; ?>px;
		color: <?php echo $settings['text_color']; ?>;
	}
	#ave-sliced-text-<?php echo $post_id; ?> .adv-vis-ele-sliced-text-wrapper > div {
		line-height: <?php echo $settings['line_height']; ?>;
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
	}
	#ave-sliced-text-<?php echo $post_id; ?> .adv-vis-ele-sliced-text-bottom {
		background: linear-gradient(177deg, <?php echo $settings['shadow_color']; ?> 57%, <?php echo $settings['text_color']; ?> 70%);
		background-clip: text;
		-webkit-background-clip: text;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-sliced-text-<?php echo $post_id; ?> .adv-vis-ele-sliced-text-wrapper {
			font-size: <?php echo $settings['text_size_mobile']; ?>px;
		}
		#ave-sliced-text-<?php echo $post_id; ?> .adv-vis-ele-sliced-text-wrapper > div {
			letter-spacing: <?php echo $settings['letter-spacing-mobile']; ?>px;
		}
	}
</style>

<div id="ave-sliced-text-<?php echo $post_id; ?>" class="adv-vis-ele-sliced-text">
	<div class="adv-vis-ele-sliced-text-wrapper">
		<div class="adv-vis-ele-sliced-text-top"><?php echo $settings['main_text']; ?></div>
		<div class="adv-vis-ele-sliced-text-bottom" aria-hidden="true"><?php echo $settings['main_text']; ?></div>
	</div>
</div>