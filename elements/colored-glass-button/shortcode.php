<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$padding = '7px 30px';
$base_box_shadow_multiplier = 1;

if ($settings['button-size'] === 'small') {
	$padding = '4px 15px';
	$addons_size = 20;
	$base_box_shadow_multiplier = 0.5;
} else if ($settings['button-size'] === 'medium') {
	$padding = '7px 30px';
	$addons_size = 30;
	$base_box_shadow_multiplier = 1;
} else if ($settings['button-size'] === 'big') {
	$padding = '15px 50px';
	$addons_size = 50;
	$base_box_shadow_multiplier = 2;
} else if ($settings['button-size'] === 'huge') {
	$padding = '30px 100px';
	$addons_size = 80;
	$base_box_shadow_multiplier = 3;
}

$box_shadow = '';
if ($settings['box-shadow']) {
	$box_shadow = 'box-shadow: 0 15px 15px rgba(0, 0, 0, 0.3);';
}

?>

<style>
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c a {
		background: <?php echo $settings['primary-color']; ?>;
		<?php echo $box_shadow; ?>;
		border-radius: <?php echo $settings['border-radius']; ?>px;
		padding: <?php echo $padding; ?>;
		font-size: <?php echo $settings['text-size']; ?>px;
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c::before {
		width: <?php echo $addons_size; ?>px;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c:hover::before {
		border-radius: <?php echo $settings['border-radius']; ?>px;
		box-shadow: 0 0 5px <?php echo $settings['secondary-color']; ?>, 0 0 <?php echo $base_box_shadow_multiplier * 15; ?>px <?php echo $settings['secondary-color']; ?>, 0 0 <?php echo $base_box_shadow_multiplier * 30; ?>px <?php echo $settings['secondary-color']; ?>,
		0 0 <?php echo $base_box_shadow_multiplier * 60; ?>px <?php echo $settings['secondary-color']; ?>;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c::after {
		width: <?php echo $addons_size; ?>px;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c:hover::after {
		border-radius: <?php echo $settings['border-radius']; ?>px;
		box-shadow: 0 0 5px <?php echo $settings['secondary-color']; ?>, 0 0 <?php echo $base_box_shadow_multiplier * 15; ?>px <?php echo $settings['secondary-color']; ?>, 0 0 <?php echo $base_box_shadow_multiplier * 30; ?>px <?php echo $settings['secondary-color']; ?>,
		0 0 <?php echo $base_box_shadow_multiplier * 60; ?>px <?php echo $settings['secondary-color']; ?>;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c::before,
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c::after {
		background: <?php echo $settings['secondary-color']; ?>;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c:hover::before {
		bottom: 0;
		height: 50%;
		width: 80%;
	}
	#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c:hover::after {
		top: 0;
		height: 50%;
		width: 80%;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-colored-glass-button-<?php echo $post_id; ?> .adv-vis-ele-colored-glass-button-c a {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-colored-glass-button-<?php echo $post_id; ?>" class="adv-vis-ele-colored-glass-button">
	<div class="adv-vis-ele-colored-glass-button-c"><a<?php echo $settings['open-in-new-tab'] ? ' target="_blank"' : ''; ?> href="<?php echo $settings['button-link']; ?>"><?php echo $settings['button-text']; ?></a></div>
</div>