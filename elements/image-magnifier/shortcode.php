<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-image-magnifier-<?php echo $post_id; ?> .adv-vis-ele-image-magnifier-glass {
	<?php echo $settings['use-border-for-magnifier'] ? 'border: 4px solid #000;' : ''; ?>
		width: <?php echo $settings['size']; ?>px;
		height: <?php echo $settings['size']; ?>px;
	}
</style>
<div id="ave-image-magnifier-<?php echo $post_id; ?>" class="adv-vis-ele-image-magnifier" <?php echo !empty($settings['image']) ? 'data-img-id="ave-image-magnifier-img-' . $post_id . '"' : ''; ?> data-zoom-level="<?php echo $settings['zoom-level']; ?>">
	<?php if (!empty($settings['image'])) { ?>
		<div class="adv-vis-ele-image-magnifier-container">
			<img id="ave-image-magnifier-img-<?php echo $post_id; ?>" src="<?php echo $settings['image']; ?>" alt="<?php echo $settings['image-alt-tag']; ?>">
		</div>
	<?php } ?>
</div>