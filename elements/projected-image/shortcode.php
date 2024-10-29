<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$url = '';

if (!empty($settings['url'])) {
	$url = '<a href="' . $settings['url'] . '"';
	
	$url .= $settings['open-in-new-tab'] ? ' target="_blank"' : '';
	
	$url .= '>';
}
?>

<style>
	#ave-projected-image-<?php echo $post_id; ?> .adv-vis-ele-projected-image-card {
		width: <?php echo $settings['width']; ?>px;
		height: <?php echo $settings['height']; ?>px;
	}
	#ave-projected-image-<?php echo $post_id; ?> .adv-vis-ele-projected-image-card:hover .adv-vis-ele-projected-image-wrapper {
		<?php echo $settings['hide-background-image-on-hover'] ? 'opacity: 0;' : ''; ?>
		<?php echo $settings['background-shadow'] ? 'box-shadow: 2px 35px 32px -8px rgba(0, 0, 0, 0.75);' : ''; ?>
	}
	#ave-projected-image-<?php echo $post_id; ?>  .adv-vis-ele-projected-image-wrapper:before {
		<?php echo $settings['background-shadow'] ? 'background-image: linear-gradient(to top, transparent 46%, rgba(12, 13, 19, 0.5) 68%, rgba(12, 13, 19, 1) 97%);' : ''; ?>
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-projected-image-<?php echo $post_id; ?> .adv-vis-ele-projected-image-card {
			width: <?php echo $settings['width-mobile']; ?>px;
			height: <?php echo $settings['height-mobile']; ?>px;
		}
	}
</style>

<div id="ave-projected-image-<?php echo $post_id; ?>" class="adv-vis-ele-projected-image">
	<?php echo $url; ?>
	<div class="adv-vis-ele-projected-image-card">
		<div class="adv-vis-ele-projected-image-wrapper">
			<?php if(!empty($settings['image'])) { ?>
				<img src="<?php echo $settings['image']; ?>" class="adv-vis-ele-projected-image-cover-image"/>
			<?php } ?>
		</div>
			<?php if(!empty($settings['projected-image'])) { ?>
				<img src="<?php echo $settings['projected-image']; ?>" class="adv-vis-ele-projected-image-character"/>
			<?php } ?>
	</div>
	<?php echo !empty($url) ? '</a>' : ''; ?>
</div>