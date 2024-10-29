<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-glowing-text-<?php echo $post_id; ?> {
		background-color: <?php echo $settings['background-color']; ?>;
	}
	#ave-glowing-text-<?php echo $post_id; ?> .adv-vis-ele-glowing-text-main-text {
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
		font-size: <?php echo $settings['font-size']; ?>px;
		-webkit-text-stroke: 1px <?php echo $settings['text-shadow']; ?>;
		<?php echo $settings['selectable-text'] ? '' : 'user-select: none;'; ?>
	}
	#ave-glowing-text-<?php echo $post_id; ?> .adv-vis-ele-glowing-text-main-text<?php echo $settings['animate-on-hover'] ? ':hover' : ''; ?> {
		animation: ave-glowing-text-<?php echo $post_id; ?> <?php echo $settings['animation-duration']; ?>s linear infinite;
	}
	@keyframes ave-glowing-text-<?php echo $post_id; ?> {
		0%, 18%, 19%, 20%, 40.1%, 60%, 67%, 80.1%, 87% {
			color: <?php echo $settings['text-color-off']; ?>;
			text-shadow: 0 0 5px <?php echo $settings['text-shadow']; ?>;
			transition: text-shadow 0.1s;
		}
		18.1%, 19.2%, 20.3%, 40%, 67.1%, 80%, 87.1%, 100% {
			color: <?php echo $settings['text-color-on']; ?>;
			text-shadow: 0 0 10px <?php echo $settings['text-glow']; ?>,
			0 0 20px <?php echo $settings['text-glow']; ?>,
			0 0 40px <?php echo $settings['text-glow']; ?>,
			0 0 80px <?php echo $settings['text-glow']; ?>,
			0 0 120px <?php echo $settings['text-glow']; ?>
		}
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-glowing-text-<?php echo $post_id; ?> .adv-vis-ele-glowing-text-main-text {
			font-size: <?php echo $settings['font-size-mobile']; ?>px;
		}
	}
</style>
<div id="ave-glowing-text-<?php echo $post_id; ?>" class="adv-vis-ele-glowing-text">
	<<?php echo $settings['text_container_tag']; ?> class="adv-vis-ele-glowing-text-main-text"><?php echo $settings['main-text']; ?></<?php echo $settings['text_container_tag']; ?>>
</div>