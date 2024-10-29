<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner {
		width: <?php echo $settings['width']; ?>px;
		height: <?php echo $settings['height']; ?>px;
		line-height: <?php echo $settings['height']; ?>px;
		font-size: <?php echo $settings['text-size']; ?>px;
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:first-child {
		background-color: <?php echo $settings['color-left']; ?>;
		color: <?php echo $settings['text-color-left']; ?>;
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:last-child {
		background-color: <?php echo $settings['color-right']; ?>;
		color: <?php echo $settings['text-color-right']; ?>;
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner span {
		animation: adv-vis-ele-text-marquee <?php echo $settings['speed']; ?>s linear infinite;
		<?php echo $settings['selectable-text'] ? '' : 'user-select: none;'; ?>
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:first-child span {
		animation-delay: <?php echo number_format($settings['speed'] / 2, 2, '.', ''); ?>s;
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:first-child {
		transform: perspective(<?php echo $settings['perspective']; ?>px) rotateY(-15deg);
	}
	#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:last-child {
		transform: perspective(<?php echo $settings['perspective']; ?>px) rotateY(15deg);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner {
			width: <?php echo $settings['width-mobile']; ?>px;
			height: <?php echo $settings['height-mobile']; ?>px;
			line-height: <?php echo $settings['height-mobile']; ?>px;
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
		#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:first-child {
			transform: perspective(<?php echo $settings['perspective-mobile']; ?>px) rotateY(-15deg);
		}
		#ave-text-marquee-<?php echo $post_id; ?>.adv-vis-ele-text-marquee .adv-vis-ele-text-marquee-inner:last-child {
			transform: perspective(<?php echo $settings['perspective-mobile']; ?>px) rotateY(15deg);
		}
	}
</style>

<div id="ave-text-marquee-<?php echo $post_id; ?>" class="adv-vis-ele-text-marquee">
	<div class="adv-vis-ele-text-marquee-inner">
		<span><?php echo $settings['text']; ?></span>
	</div>
	<div class="adv-vis-ele-text-marquee-inner">
		<span><?php echo $settings['text']; ?></span>
	</div>
</div>