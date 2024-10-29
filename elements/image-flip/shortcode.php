<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$c = '';

if ($settings['horizontal-flip'] === true) {
	$c = 'adv-vis-ele-image-flip-horizontal';
}

if ($settings['vertical-flip'] === true) {
	$c = 'adv-vis-ele-image-flip-vertical';
}

if ($settings['vertical-flip'] === true && $settings['horizontal-flip'] === true) {
	$c = 'adv-vis-ele-image-flip-both';
}

?>

<style>
	#ave-image-flip-<?php echo $post_id; ?> .adv-vis-ele-image-flip-ctrl {
		color: <?php echo $settings['title-color']; ?>;
	}
</style>

<div id="ave-image-flip-<?php echo $post_id; ?>" class="adv-vis-ele-image-flip">
	<div class="adv-vis-ele-image-flip-c" data-flip="<?php echo $c; ?>" data-type="<?php echo $settings['use-a-switch-to-flip'] === true ? 'switch' : 'img'; ?>">
		<?php
		if ((!empty($settings['title']) || $settings['use-a-switch-to-flip'] === true) && $settings['title-and-switch-position'] === 'top') {
			echo '<div class="adv-vis-ele-image-flip-ctrl">' . (!empty($settings['title']) ? $settings['title'] : '') . ($settings['use-a-switch-to-flip'] === true ? '<div class="adv-vis-ele-image-flip-switch"></div>' : '') . '</div>';
		}
		
		if (!empty($settings['image'])) {
			echo '<div class="adv-vis-ele-image-flip-img"><img src="' . $settings['image'] . '" alt="' . $settings['image-alt-attribute'] . '"></div>';
		}
		
		if ((!empty($settings['title']) || $settings['use-a-switch-to-flip'] === true) && $settings['title-and-switch-position'] === 'bottom') {
			echo '<div class="adv-vis-ele-image-flip-ctrl">' . (!empty($settings['title']) ? $settings['title'] : '') . ($settings['use-a-switch-to-flip'] === true ? '<div class="adv-vis-ele-image-flip-switch"></div>' : '') . '</div>';
		}
		?>
	</div>
</div>