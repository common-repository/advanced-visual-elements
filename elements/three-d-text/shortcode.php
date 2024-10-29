<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$sm = $settings['shadow-multiplier'];
$dp = $settings['depth-multiplier'];
?>

<style>
	#ave-three-d-text-<?php echo $post_id; ?> .adv-vis-ele-three-d-text-inner {
		font-size: <?php echo $settings['text-size']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
		<?php echo $settings['selectable-text'] ? '' : 'user-select: none;'; ?>
		text-shadow: 1px 1px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 2; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 3; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 4; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 5; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 6; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 7; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 8; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 9; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $dp * 10; ?>px 1px <?php echo $settings['shadow-color']; ?>,
		1px <?php echo $sm * 18; ?>px <?php echo $sm * 6; ?>px <?php echo $settings['background-shadow-color']; ?>,
		1px <?php echo $sm * 22; ?>px <?php echo $sm * 10; ?>px <?php echo $settings['background-shadow-color']; ?>,
		1px <?php echo $sm * 25; ?>px <?php echo $sm * 35; ?>px <?php echo $settings['background-shadow-color']; ?>,
		1px <?php echo $sm * 30; ?>px <?php echo $sm * 60; ?>px <?php echo $settings['background-shadow-color']; ?>;
		letter-spacing: <?php echo $settings['letter-spacing']; ?>px;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-three-d-text-<?php echo $post_id; ?> .adv-vis-ele-three-d-text-inner {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
	}
</style>

<div id="ave-three-d-text-<?php echo $post_id; ?>" class="adv-vis-ele-three-d-text">
	<div class="adv-vis-ele-three-d-text-inner"><?php echo $settings['text']; ?></div>
</div>