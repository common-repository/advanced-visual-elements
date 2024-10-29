<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-image-reveal-<?php echo $post_id; ?> .adv-vis-ele-image-reveal-zoom {
		height: <?php echo $settings['reveal-circle-size'] * 2; ?>px;
		width: <?php echo $settings['reveal-circle-size'] * 2; ?>px;
	}
</style>

<div id="ave-image-reveal-<?php echo $post_id; ?>" class="adv-vis-ele-image-reveal">
	<div class="adv-vis-ele-image-reveal-container">
		<div class="adv-vis-ele-image-reveal-back" style="background-image: url(<?php echo $settings['underlay-image']; ?>);"></div>
		<div class="adv-vis-ele-image-reveal-zoom"></div>
		<div class="adv-vis-ele-image-reveal-front">
			<?php
			if (!empty($settings['overlay-image'])) { ?>
				<img src="<?php echo $settings['overlay-image']; ?>" alt="<?php echo $settings['image-alt']; ?>">
			<?php } ?>
		</div>
	</div>
</div>