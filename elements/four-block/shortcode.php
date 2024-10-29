<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-four-block-<?php echo $post_id; ?> .ave-four-block-c {
		width: <?php echo $settings['square-size']; ?>px;
		height: <?php echo $settings['square-size']; ?>px;
	}
	#ave-four-block-<?php echo $post_id; ?> .ave-four-block-i {
		transition: all <?php echo $settings['transition-duration']; ?>s ease;
	}
	#ave-four-block-<?php echo $post_id; ?> .ave-four-block-i div,
	#ave-four-block-<?php echo $post_id; ?> .ave-four-block-v div {
		font-size: <?php echo $settings['font-size']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
	}
	#ave-four-block-<?php echo $post_id; ?> .ave-four-block-v {
		background: <?php echo $settings['front-square-color']; ?>;
		transition: all <?php echo $settings['transition-duration']; ?>s ease;
		box-shadow: 0 -<?php echo $settings['square-size']; ?>px 0 0 <?php echo $settings['top-square-color']; ?>, <?php echo $settings['square-size']; ?>px 0 0 0 <?php echo $settings['right-square-color']; ?>, 0 <?php echo $settings['square-size']; ?>px 0 0 <?php echo $settings['bottom-square-color']; ?>, -<?php echo $settings['square-size']; ?>px 0 0 0 <?php echo $settings['left-square-color']; ?>;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-four-block-<?php echo $post_id; ?> .ave-four-block-c {
			width: <?php echo $settings['square-size-mobile']; ?>px;
			height: <?php echo $settings['square-size-mobile']; ?>px;
		}
		#ave-four-block-<?php echo $post_id; ?> .ave-four-block-i div,
		#ave-four-block-<?php echo $post_id; ?> .ave-four-block-v div {
			font-size: <?php echo $settings['font-size-mobile']; ?>px;
		}
		#ave-four-block-<?php echo $post_id; ?> .ave-four-block-v {
			box-shadow: 0 -<?php echo $settings['square-size-mobile']; ?>px 0 0 <?php echo $settings['top-square-color']; ?>, <?php echo $settings['square-size-mobile']; ?>px 0 0 0 <?php echo $settings['right-square-color']; ?>, 0 <?php echo $settings['square-size-mobile']; ?>px 0 0 <?php echo $settings['bottom-square-color']; ?>, -<?php echo $settings['square-size-mobile']; ?>px 0 0 0 <?php echo $settings['left-square-color']; ?>;
		}
	}
</style>
<div id="ave-four-block-<?php echo $post_id; ?>" class="ave-four-block">
	<div class="ave-four-block-c">
		<div class="ave-four-block-i">
			<div><?php echo $settings['top-square-text']; ?></div>
		</div>
		<div class="ave-four-block-i">
			<div><?php echo $settings['right-square-text']; ?></div>
		</div>
		<div class="ave-four-block-i">
			<div><?php echo $settings['bottom-square-text']; ?></div>
		</div>
		<div class="ave-four-block-i">
			<div><?php echo $settings['left-square-text']; ?></div>
		</div>
		<div class="ave-four-block-v">
			<div>
				<?php echo $settings['front-square-text']; ?>
			</div>
		</div>
	</div>
</div>