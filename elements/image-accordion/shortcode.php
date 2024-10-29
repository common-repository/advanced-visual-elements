<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$images = [];

for ($i = 1; $i <= 8; $i++) {
	$images[] = $settings['image-' . $i];
}

$images = array_filter($images);

$single_width = number_format(50 / (count($images) - 1), 3, '.', '');

if ($single_width > 33.333) {
	$single_width = 33.333;
}

?>

<style>
	#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-c {
		width: <?php echo $settings['width']; ?>px;
	}
	#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img {
		display: inline-block;
		width: <?php echo $single_width ?>%;
		height: <?php echo $settings['height'] ?>px;
		opacity: <?php echo $settings['opacity']; ?>;
	}
	#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:hover,
	#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:first-child ~ .adv-vis-ele-image-accordion-img:last-child {
		width: 50%;
		opacity: 1;
		transition: all 0.5s ease-in-out;
	}
	#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:hover ~ .adv-vis-ele-image-accordion-img:last-child {
		width: <?php echo $single_width ?>%;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-c {
			width: <?php echo $settings['width-mobile']; ?>px;
			height: <?php echo $settings['height-mobile']; ?>px;
		}
		#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img {
			display: block;
			height: <?php echo $single_width ?>%;
			width: 100% !important;
		}
		#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:hover,
		#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:first-child ~ .adv-vis-ele-image-accordion-img:last-child {
			height: 50%;
		}
		#ave-image-accordion-<?php echo $post_id; ?> .adv-vis-ele-image-accordion-img:hover ~ .adv-vis-ele-image-accordion-img:last-child {
			height: <?php echo $single_width ?>%;
		}
	}
</style>

<div id="ave-image-accordion-<?php echo $post_id; ?>" class="adv-vis-ele-image-accordion">
	<div class="adv-vis-ele-image-accordion-c">
		<?php
		foreach ($images as $image) {
			echo '<div style="background-image: url(' . $image . ')" class="adv-vis-ele-image-accordion-img"></div>';
		}
		?>
	</div>
</div>