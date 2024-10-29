<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<div id="ave-expanding-image-cards-<?php echo $post_id; ?>" class="adv-vis-ele-expanding-image-cards">
	<div class="adv-vis-ele-expanding-image-cards-options">
		<?php
		for ($i = 1; $i <= 5; $i++) {
			if (!empty($settings['image-' . $i])) { ?>
				<div class="adv-vis-ele-expanding-image-cards-option <?php echo $i === 1 ? 'adv-vis-ele-expanding-image-cards-active' : ''; ?>" style="background-image:url(<?php echo $settings['image-' . $i]; ?>);">
					<div class="adv-vis-ele-expanding-image-cards-label">
						<div class="adv-vis-ele-expanding-image-cards-info">
							<?php
							if (!empty($settings['title-link-' . $i])) {
								echo '<a target="_blank" href="' . $settings['title-link-' . $i] . '">';
							}
							
							if (!empty($settings['title-text-' . $i])) {
								echo '<div class="adv-vis-ele-expanding-image-cards-main">' . $settings['title-text-' . $i] . '</div>';
							}
							
							if (!empty($settings['subtitle-text-' . $i])) {
								echo '<div class="adv-vis-ele-expanding-image-cards-sub">' . $settings['subtitle-text-' . $i] . '</div>';
							}
							
							if (!empty($settings['title-link-' . $i])) {
								echo '</a>';
							}
							?>
						</div>
					</div>
				</div>
			<?php }
		} ?>
	</div>
</div>