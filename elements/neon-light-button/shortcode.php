<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$padding = '15px 30px';

if ($settings['button-size'] === 'small') {
	$padding = '7px 15px';
} else if ($settings['button-size'] === 'medium') {
	$padding = '15px 30px';
} else if ($settings['button-size'] === 'big') {
	$padding = '30px 60px';
} else if ($settings['button-size'] === 'huge') {
	$padding = '50px 100px';
}

?>

<style>
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link {
		padding: <?php echo $padding; ?>;
		color: <?php echo $settings['primary-color']; ?>;
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
		font-size: <?php echo $settings['text-size']; ?>px;
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link:hover,
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link:hover:focus {
		color: <?php echo $settings['secondary-color']; ?>;
		background: <?php echo $settings['primary-color']; ?>;
		box-shadow: 0 0 10px <?php echo $settings['primary-color']; ?>, 0 0 40px <?php echo $settings['primary-color']; ?>, 0 0 70px <?php echo $settings['primary-color']; ?>;
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link:focus {
		color: <?php echo $settings['primary-color']; ?>;
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link span:first-child {
		background: linear-gradient(90deg, transparent, <?php echo $settings['primary-color']; ?>);
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link span:nth-child(2) {
		background: linear-gradient(270deg, transparent, <?php echo $settings['primary-color']; ?>);
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link span:nth-child(3) {
		background: linear-gradient(180deg, transparent, <?php echo $settings['primary-color']; ?>);
	}
	#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link span:nth-child(4) {
		background: linear-gradient(0deg, transparent, <?php echo $settings['primary-color']; ?>);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-neon-light-button-<?php echo $post_id; ?> .adv-vis-ele-neon-light-button-link {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-neon-light-button-<?php echo $post_id; ?>" class="adv-vis-ele-neon-light-button">
	<a <?php echo $settings['open-in-new-tab'] ? 'target="_blank"' : ''; ?> href="<?php echo $settings['button-link']; ?>" class="adv-vis-ele-neon-light-button-link">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<?php echo $settings['button-text']; ?>
	</a>
</div>