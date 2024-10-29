<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-strikethrough-text-<?php echo $post_id; ?> {
		font-size: <?php echo $settings['text_size']; ?>px;
	}
	#ave-strikethrough-text-<?php echo $post_id; ?> > .adv-vis-ele-strikethrough-main-text::before,
	#ave-strikethrough-text-<?php echo $post_id; ?> > .adv-vis-ele-strikethrough-main-text::after {
		color: <?php echo $settings['text_color']; ?>;
	}
	#ave-strikethrough-text-<?php echo $post_id; ?>:hover > .adv-vis-ele-strikethrough-main-text::before,
	#ave-strikethrough-text-<?php echo $post_id; ?>:hover > .adv-vis-ele-strikethrough-main-text::after {
		color: <?php echo $settings['hover_color']; ?>;
		transform: skewX(<?php echo $settings['skew_degrees']; ?>deg);
	}
	#ave-strikethrough-text-<?php echo $post_id; ?>::before {
		background-color: <?php echo $settings['line_color']; ?>;
	}
	#ave-strikethrough-text-<?php echo $post_id; ?>::before {
		height: <?php echo $settings['line_height']; ?>px;
	}
	#ave-strikethrough-text-<?php echo $post_id; ?>::before {
		top: calc(50% - <?php echo $settings['line_height'] / 2; ?>px);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-strikethrough-text-<?php echo $post_id; ?> {
			font-size: <?php echo $settings['text_size_mobile']; ?>px;
		}
	}
</style>
<div id="ave-strikethrough-text-<?php echo $post_id; ?>" class="adv-vis-ele-strikethrough-text">
	<<?php echo $settings['text_container_tag']; ?> class="adv-vis-ele-strikethrough-main-text" data-text="<?php echo $settings['main_text']; ?>">
		<?php echo $settings['main_text']; ?>
	</<?php echo $settings['text_container_tag']; ?>>
</div>