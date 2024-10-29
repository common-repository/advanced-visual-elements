<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-c {
		width: <?php echo $settings['size']; ?>px;
		height: <?php echo $settings['size']; ?>px;
	}
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-img {
		width: <?php echo $settings['size']; ?>px;
		height: <?php echo $settings['size']; ?>px;
		transition: transform <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1), -webkit-clip-path <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
		transition: transform <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1), clip-path <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
		transition: transform <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1), clip-path <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1), -webkit-clip-path <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
	}
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-img img {
		transition: transform <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
	}
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-img::after {
		background-color: <?php echo $settings['overlay-color']; ?>;
		transition: opacity <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
	}
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-t {
		font-size: <?php echo $settings['text-size']; ?>px;
		color: <?php echo $settings['text-color']; ?>;
	}
	#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-t::after {
		font-size: calc(calc(<?php echo $settings['size']; ?>px / 8) / 3);
		transition: transform <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1), opacity <?php echo $settings['speed']; ?>ms cubic-bezier(0.25, 1, 0.5, 1);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-c {
			width: <?php echo $settings['size-mobile']; ?>px;
			height: <?php echo $settings['size-mobile']; ?>px;
		}
		#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-img {
			width: <?php echo $settings['size-mobile']; ?>px;
			height: <?php echo $settings['size-mobile']; ?>px;
		}
		#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-t {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
		#ave-image-arrow-skew-<?php echo $post_id; ?> .adv-vis-ele-image-arrow-skew-t::after {
			font-size: calc(calc(<?php echo $settings['size-mobile']; ?>px / 8) / 3);
		}
	}
</style>

<div id="ave-image-arrow-skew-<?php echo $post_id; ?>" class="adv-vis-ele-image-arrow-skew">
	<div class="adv-vis-ele-image-arrow-skew-c">
		<a href="<?php echo $settings['link-url']; ?>"<?php echo $settings['open-in-new-tab'] === true ? ' target="_blank"' : ''; ?>>
			<?php
			if (!empty($settings['image'])) { ?>
				<div class="adv-vis-ele-image-arrow-skew-img">
					<img src="<?php echo $settings['image']; ?>" alt="<?php echo $settings['primary-text']; ?>">
				</div>
			<?php }
			if (!empty($settings['primary-text'])) { ?>
				<h2 class="adv-vis-ele-image-arrow-skew-t" data-cta="<?php echo $settings['secondary-text']; ?>"><?php echo $settings['primary-text']; ?></h2>
			<?php }
			?>
		</a>
	</div>
</div>