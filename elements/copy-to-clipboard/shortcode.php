<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$width = !empty($settings['width']) ? $settings['width'] . 'px' : 'auto';
$width_mobile = !empty($settings['width-mobile']) ? $settings['width-mobile'] . 'px' : 'auto';

?>

<style>
	#ave-copy-to-clipboard-<?php echo $post_id; ?> .adv-vis-ele-copy-to-clipboard-t {
		width: <?php echo $width; ?>;
		display: flex;
		flex-wrap: nowrap;
		justify-content: center;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-copy-to-clipboard-<?php echo $post_id; ?> .adv-vis-ele-copy-to-clipboard-t {
			width: <?php echo $width_mobile; ?>;
		}
	}
</style>

<div id="ave-copy-to-clipboard-<?php echo $post_id; ?>" class="adv-vis-ele-copy-to-clipboard" style="cursor: pointer;">
	<div class="adv-vis-ele-copy-to-clipboard-inner">
		<?php
		if (!empty($settings['text-to-be-copied'])) {
			if ($settings['use-input']) {
				echo '<input type="text" class="adv-vis-ele-copy-to-clipboard-t" value="' . $settings['text-to-be-copied'] . '" />';
			} else {
				echo '<div class="adv-vis-ele-copy-to-clipboard-t">' . $settings['text-to-be-copied'] . '</div>';
			}
		}
		?>
	</div>
</div>