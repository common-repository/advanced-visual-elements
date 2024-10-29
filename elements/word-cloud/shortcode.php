<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$colors = '';
for ($i = 1; $i <= 5; $i++) {
	if (!empty($settings['color-' . $i])) {
		$colors .= 'data-color-' . $i . '="' . $settings['color-' . $i] . '" ';
	}
}

$new_tab = 'data-new-tab="' . ($settings['open-links-in-new-tab'] === true ? '_blank' : '_self') . '"';

$settings['width'] = !empty($settings['width']) ? $settings['width'] : '500';
$settings['height'] = !empty($settings['height']) ? $settings['height'] : '400';

$settings['width-mobile'] = !empty($settings['width-mobile']) ? $settings['width-mobile'] : '300';
$settings['height-mobile'] = !empty($settings['height-mobile']) ? $settings['height-mobile'] : '180';

$width = 'data-width="' . $settings['width'] . '"';
$height = ' data-height="' . $settings['height'] . '"';

$width_mobile = ' data-width-mobile="' . $settings['width-mobile'] . '"';
$height_mobile = ' data-height-mobile="' . $settings['height-mobile'] . '"';

$wh = $width . $height . $width_mobile . $height_mobile;

?>

<style>
	.adv-vis-ele-word-cloud {

	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {

	}
</style>

<div id="ave-word-cloud-<?php echo $post_id; ?>" class="adv-vis-ele-word-cloud" <?php echo $colors; ?> data-min-size="<?php echo $settings['min-font-size']; ?>" data-max-size="<?php echo $settings['max-font-size']; ?>" <?php echo $new_tab; ?> <?php echo $wh; ?>>
	<?php
	
	for ($i = 1; $i <= 10; $i++) {
		if (!empty($settings['word-' . $i])) {
			echo '<div class="adv-vis-ele-word-cloud-word"';
			
			if (!empty($settings['word-' . $i . '-url'])) {
				echo ' data-url="' . $settings['word-' . $i . '-url'] . '"';
			}
			
			echo ' data-text="' . $settings['word-' . $i] . '"';
			
			echo '></div>';
		}
	}
	
	?>
</div>