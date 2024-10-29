<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$the_2 = 2 * $settings['offset_multiplier'];
$the_3 = 3 * $settings['offset_multiplier'];
$the_4 = 4 * $settings['offset_multiplier'];

?>
<style>
	#ave-glitchy-text-<?php echo $post_id; ?> .adv-vis-ele-glitchy-text-main-text {
		color: <?php echo $settings['text_color']; ?>;
		font-size: <?php echo $settings['text_size']; ?>px;
		<?php
		if($settings['animate-on-hover']){
			echo 'text-shadow: none;';
		} else { ?>
		text-shadow: <?php echo $the_4; ?>px <?php echo $the_4; ?>px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_2; ?>px -<?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		<?php } ?>
		animation-duration: <?php echo $settings['flicker_duration']; ?>s;
		animation-iteration-count: infinite;
		<?php echo $settings['selectable-text'] ? '' : 'user-select: none;'; ?>
	}
	#ave-glitchy-text-<?php echo $post_id; ?> .adv-vis-ele-glitchy-text-main-text<?php echo $settings['animate-on-hover'] ? ':hover': ''; ?> {
		animation-name: ave-glitchy-text-flicker-<?php echo $post_id; ?>;
		<?php
		
		if($settings['animate-on-hover']) { ?>
		text-shadow: <?php echo $the_4; ?>px <?php echo $the_4; ?>px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_2; ?>px -<?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color'];
		} ?>
	}
	@keyframes ave-glitchy-text-flicker-<?php echo $post_id; ?> {
		0% {
			text-shadow: <?php echo $the_4; ?>px <?php echo $the_4; ?>px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_2; ?>px -<?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		33% {
			text-shadow: <?php echo $the_2; ?>px <?php echo $the_2; ?>px 0 <?php echo $settings['primary_color']; ?>, <?php echo $the_3; ?>px <?php echo $the_3; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		34% {
			text-shadow: <?php echo $the_3; ?>px <?php echo $the_3; ?>px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_2; ?>px -<?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		35% {
			text-shadow: <?php echo $the_3; ?>px <?php echo $the_2; ?>px 0 <?php echo $settings['primary_color']; ?>, 0 0 0 <?php echo $settings['secondary_color']; ?>;
		}
		38% {
			text-shadow: -<?php echo $the_3; ?>px <?php echo $the_3; ?>px 0 <?php echo $settings['primary_color']; ?>, 1px -<?php echo $the_3; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		53% {
			text-shadow: 0 0 0 <?php echo $settings['primary_color']; ?>, <?php echo $the_2; ?>px 0 0 <?php echo $settings['secondary_color']; ?>;
		}
		55% {
			text-shadow: <?php echo $the_3; ?>px -<?php echo $the_3; ?>px 0 <?php echo $settings['primary_color']; ?>, <?php echo $the_2; ?>px <?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		65% {
			text-shadow: -<?php echo $the_2; ?>px -<?php echo $the_3; ?>px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_2; ?>px <?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		68% {
			text-shadow: <?php echo $the_2; ?>px 1px 0 <?php echo $settings['primary_color']; ?>, -<?php echo $the_3; ?>px -<?php echo $the_3; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		83% {
			text-shadow: 0 0 0 <?php echo $settings['primary_color']; ?>, <?php echo $the_3; ?>px <?php echo $the_3; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
		95% {
			text-shadow: <?php echo $the_3; ?>px -<?php echo $the_3; ?>px 0 <?php echo $settings['primary_color']; ?>, <?php echo $the_2; ?>px <?php echo $the_2; ?>px 0 <?php echo $settings['secondary_color']; ?>;
		}
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-glitchy-text-<?php echo $post_id; ?> .adv-vis-ele-glitchy-text-main-text {
			font-size: <?php echo $settings['text_size_mobile']; ?>px;
		}
	}
</style>
<div id="ave-glitchy-text-<?php echo $post_id; ?>" class="adv-vis-ele-glitchy-text">
	<?php
	if (!empty($settings['main_text'])) { ?>
		<<?php echo $settings['text_container_tag']; ?> class="adv-vis-ele-glitchy-text-main-text"><?php echo $settings['main_text']; ?></<?php echo $settings['text_container_tag']; ?>>
	<?php } ?>
</div>