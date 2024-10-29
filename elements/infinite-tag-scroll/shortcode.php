<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>
<style>
	#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-list {
		width: <?php echo $settings['width']; ?>px;
	}
	#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-slider .adv-vis-ele-infinite-tag-scroll-inner {
		animation-duration: <?php echo $settings['speed']; ?>s;
	}
	#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-tag {
		color: <?php echo $settings['text-color']; ?>;
		font-size: <?php echo $settings['tag-text-size']; ?>px;
		background-color: <?php echo $settings['tag-background-color']; ?>;
		margin-right: <?php echo $settings['tag-gap-size']; ?>px;
		box-shadow: 0 0 5px <?php echo $settings['tag-background-color']; ?>;
	}
	#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-slider-fade {
		opacity: <?php echo $settings['enable-fade-effect'] ? '1' : '0'; ?>;
		background: linear-gradient(90deg, <?php echo $settings['fade-effect-color']; ?>, transparent 30%, transparent 70%, <?php echo $settings['fade-effect-color']; ?>);
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-list {
			width: <?php echo $settings['width-mobile']; ?>px;
		}
		#ave-infinite-tag-scroll-<?php echo $post_id; ?> .adv-vis-ele-infinite-tag-scroll-tag {
			font-size: <?php echo $settings['tag-text-size-mobile']; ?>px;
		}
	}
</style>
<div id="ave-infinite-tag-scroll-<?php echo $post_id; ?>" class="adv-vis-ele-infinite-tag-scroll">
	<div class="adv-vis-ele-infinite-tag-scroll-list">
		<div class="adv-vis-ele-infinite-tag-scroll-slider">
			<div class="adv-vis-ele-infinite-tag-scroll-inner">
				<?php
				for ($z = 1; $z <= 2; $z++) {
					for ($i = 1; $i <= 10; $i++) {
						if (!empty($settings['tag-' . $i])) {
							echo '<div class="adv-vis-ele-infinite-tag-scroll-tag">' . $settings['tag-' . $i] . '</div>';
						}
					}
				}
				?>
			</div>
		</div>
		<div class="adv-vis-ele-infinite-tag-scroll-slider-fade"></div>
	</div>
</div>