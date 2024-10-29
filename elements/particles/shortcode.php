<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-particles-js-<?php echo $post_id; ?> .adv-vis-ele-bg-particles-main-content {
		width: <?php echo $settings['main_content_width']; ?>%;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-particles-js-<?php echo $post_id; ?> .adv-vis-ele-bg-particles-main-content {
			width: <?php echo $settings['main_content_width_mobile']; ?>%;
		}
	}
</style>
<div id="ave-particles-js-<?php echo $post_id; ?>" class="adv-vis-ele-bg-particles" style="background-color: <?php echo $settings['background_color']; ?>; background-image: url(<?php echo $settings['background_image'] ?>);">
	<?php
	if (!empty($settings['background_video'])) {
		// detect if the video URL is from YouTube or self-hosted
		?>
		<div class="adv-vis-ele-bg-particles-bg-video">
		<?php
		$video = Adv_Vis_Ele_Helpers::parseVideos($settings['background_video']);
		
		if ($video) {
			if ($video['type'] === 'youtube') {
				?>
				<iframe src="https://www.youtube.com/embed/<?php echo $video['id']; ?>?controls=0&showinfo=0&rel=0&autoplay=1&mute=1&loop=1&playlist=<?php echo $video['id']; ?>" frameborder="0" allowfullscreen></iframe>
				<?php
			} else if ($video['type'] === 'vimeo') { ?>
				<iframe src="https://player.vimeo.com/video/<?php echo $video['id']; ?>?controls=0&muted=1&autoplay=1&loop=1&transparent=0&background=1" frameborder="0" allowfullscreen allow=autoplay></iframe>
			<?php } ?>
			</div>
		<?php } else { ?>
			<video autoplay muted playsinline loop src="<?php echo $settings['background_video']; ?>"></video>
		<?php }
	}
	
	if (!empty($settings['main_content'])) { ?>
		<div class="adv-vis-ele-bg-particles-main-content"><?php echo $settings['main_content']; ?></div>
	<?php } ?>
</div>