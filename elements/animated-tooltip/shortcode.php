<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$url = $settings['text-element-tag'] === 'a' ? ' href="' . $settings['link-url'] . '"' : '';

$open_in_new_tab = '';

if ($settings['text-element-tag'] === 'a') {
	if ($settings['open-link-in-new-tab'] === true) {
		$open_in_new_tab = ' target="_blank"';
	}
}

?>

<style>
	#ave-animated-tooltip-<?php echo $post_id; ?> .adv-vis-ele-animated-tooltip-c {
		font-size: <?php echo $settings['font-size']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> .adv-vis-ele-animated-tooltip-c:hover {
		color: <?php echo $settings['text-hover-color']; ?>;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip]:before {
		background-color: <?php echo $settings['tooltip-background-color']; ?>;
		color: <?php echo $settings['tooltip-text-color']; ?>;
		font-size: <?php echo $settings['tooltip-font-size']; ?>px;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip]:after {
		border-color: <?php echo $settings['tooltip-background-color']; ?> transparent transparent transparent;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip-location="left"]:after {
		border-color: transparent transparent transparent<?php echo $settings['tooltip-background-color']; ?>;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip-location="right"]:after {
		border-color: transparent <?php echo $settings['tooltip-background-color']; ?> transparent transparent;
	}
	#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip-location="bottom"]:after {
		border-color: transparent transparent <?php echo $settings['tooltip-background-color']; ?> transparent;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-animated-tooltip-<?php echo $post_id; ?> .adv-vis-ele-animated-tooltip-c {
			font-size: <?php echo $settings['font-size-mobile']; ?>px;
		}
		#ave-animated-tooltip-<?php echo $post_id; ?> [data-ave-tooltip]:before {
			font-size: <?php echo $settings['tooltip-font-size-mobile']; ?>px;
		}
	}
</style>

<!--@formatter:off-->
<div id="ave-animated-tooltip-<?php echo $post_id; ?>" class="adv-vis-ele-animated-tooltip">
	<<?php echo $settings['text-element-tag']; ?> <?php echo $url; ?> <?php echo $open_in_new_tab; ?> class="adv-vis-ele-animated-tooltip-c" data-ave-tooltip="<?php echo $settings['tooltip-text']; ?>" data-ave-tooltip-location="<?php echo $settings['tooltip-position']; ?>">
		<?php echo $settings['main-text']; ?>
	</<?php echo $settings['text-element-tag']; ?>>
</div>
<!--@formatter:on-->