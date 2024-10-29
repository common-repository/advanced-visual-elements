<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

?>

<style>
	#ave-ad-box-sticky-<?php echo $post_id; ?>.adv-vis-ele-ad-box-sticky {
		height: <?php echo $settings['height']; ?>px;
		overflow: unset;
	}
	#ave-ad-box-sticky-<?php echo $post_id; ?> .adv-vis-ele-ad-box-sticky-inner {
		position: sticky;
		top: <?php echo $settings['top-margin']; ?>px;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-ad-box-sticky-<?php echo $post_id; ?>.adv-vis-ele-ad-box-sticky {
			height: <?php echo $settings['height-mobile']; ?>px;
		}
		#ave-ad-box-sticky-<?php echo $post_id; ?> .adv-vis-ele-ad-box-sticky-inner {
			top: <?php echo $settings['top-margin-mobile']; ?>px;
		}
	}
</style>

<div id="ave-ad-box-sticky-<?php echo $post_id; ?>" class="adv-vis-ele-ad-box-sticky">
	<div class="adv-vis-ele-ad-box-sticky-inner">
		<?php echo $settings['ad-code']; ?>
	</div>
</div>