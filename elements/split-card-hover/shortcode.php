<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$link = '';
if (!empty($settings['link-url'])) {
	$link = 'href="' . $settings['link-url'] . '"';
	
	if ($settings['open-in-new-tab']) {
		$link .= ' target="_blank"';
	}
}

$width = 240;
$width_mobile = $width;

if (!empty($settings['width'])) {
	$width = $settings['width'];
}

if (!empty($settings['width-mobile'])) {
	$width_mobile = $settings['width-mobile'];
}

$title_size = 30;
if (!empty($settings['title-text-size'])) {
	$title_size = $settings['title-text-size'];
}

$text_size = 14;
if (!empty($settings['text-size'])) {
	$text_size = $settings['text-size'];
}

?>

<style>
	#ave-split-card-hover-<?php echo $post_id; ?>.adv-vis-ele-split-card-hover {
		width: <?php echo $width; ?>px;
	}
	#ave-split-card-hover-<?php echo $post_id; ?>.adv-vis-ele-split-card-hover h3 {
		font-size: <?php echo $title_size; ?>px;
	}
	#ave-split-card-hover-<?php echo $post_id; ?>.adv-vis-ele-split-card-hover p {
		font-size: <?php echo $text_size; ?>px;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-split-card-hover-<?php echo $post_id; ?>.adv-vis-ele-split-card-hover {
			width: <?php echo $width_mobile; ?>px;
		}
	}
</style>

<div id="ave-split-card-hover-<?php echo $post_id; ?>" class="adv-vis-ele-split-card-hover">
	<div class="adv-vis-ele-split-card-hover-n">
		<?php
		if (!empty($settings['image'])) {
			echo '<img class="adv-vis-ele-split-card-hover-i" src="' . $settings['image'] . '"/>';
		}
		?>
		<a class="adv-vis-ele-split-card-hover-t" <?php echo $link; ?> target="_blank">
			<?php
			if (!empty($settings['title'])) {
				echo '<h3 data-splitting="">' . $settings['title'] . '</h3>';
			}
			
			if (!empty($settings['text'])) {
				echo '<p data-splitting="">' . $settings['text'] . '</p>';
			}
			?>
		</a>
	</div>
</div>