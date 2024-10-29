<?php

if (!defined("ABSPATH")) {
	exit; // Exit if accessed directly.
}

$socials = ['facebook', 'twitter', 'linkedin', 'instagram', 'github', 'dribbble'];
$social_icons = [];

foreach ($socials as $social) {
	if (!empty($settings[$social])) {
		$social_icons[$social]['link'] = $settings[$social];
		$social_icons[$social]['icon'] = ADV_VIS_ELE_ELEMENTS_URL . '/profile-card-hover/icons/' . $social . '-icon.svg';
	}
}

if (empty($settings['width'])) {
	$settings['width'] = 300;
}

if (empty($settings['width-mobile'])) {
	$settings['width-mobile'] = 300;
}

if (empty($settings['height'])) {
	$settings['height'] = 380;
}
if (empty($settings['height-mobile'])) {
	$settings['height-mobile'] = 380;
}

$bg_size = max([$settings['width'], $settings['height']]);
$bg_size_mobile = max([$settings['width-mobile'], $settings['height-mobile']]);

?>
<style>
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-border {
		border-radius: <?php echo $settings['border-radius']; ?>px;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-border:hover {
		border: 1px solid<?php echo $settings['inner-border-color']; ?>;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-c {
		width: <?php echo $settings['width']; ?>px;
		height: <?php echo $settings['height']; ?>px;
		border-radius: <?php echo $settings['border-radius']; ?>px;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-c {
		background: url("<?php echo $settings['image']; ?>") center center no-repeat;
		background-size: <?php echo $bg_size; ?>px;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-c:hover {
		background: url("<?php echo $settings['image']; ?>") left center no-repeat;
		background-size: <?php echo number_format($bg_size * 1.5, 0, '.', ''); ?>px;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-name,
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-text,
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-contact a {
		color: <?php echo $settings['hover-text-color']; ?>;
		font-size: <?php echo $settings['text-size']; ?>px;
	}
	#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-icons > a {
		width: <?php echo $settings['icon-size']; ?>px;
		height: <?php echo $settings['icon-size']; ?>px;
	}
	@media screen and (max-width: <?php echo $settings['mobile_breakpoint']; ?>px) {
		#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-c {
			width: <?php echo $settings['width-mobile']; ?>px;
			height: <?php echo $settings['height-mobile']; ?>px;
		}
		#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-name,
		#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-text,
		#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-contact a {
			font-size: <?php echo $settings['text-size-mobile']; ?>px;
		}
		#ave-profile-card-hover-<?php echo $post_id; ?> .adv-vis-ele-profile-card-hover-icons > a {
			width: <?php echo $settings['icon-size-mobile']; ?>px;
			height: <?php echo $settings['icon-size-mobile']; ?>px;
		}
	}
</style>
<div id="ave-profile-card-hover-<?php echo $post_id; ?>" class="adv-vis-ele-profile-card-hover">
	<div class="adv-vis-ele-profile-card-hover-c">
		<div class="adv-vis-ele-profile-card-hover-border">
			<div class="adv-vis-ele-profile-card-hover-details">
				<div class="adv-vis-ele-profile-card-hover-name"><?php echo $settings['name']; ?></div>
				<div class="adv-vis-ele-profile-card-hover-text"><?php echo $settings['text']; ?></div>
			</div>
			<div class="adv-vis-ele-profile-card-hover-lower">
				<div class="adv-vis-ele-profile-card-hover-icons">
					<?php
					foreach ($social_icons as $icon) {
						echo '<a target="_blank" href="' . esc_url($icon['link']) . '"><img src="' . esc_url($icon['icon']) . '" /></a>';
					}
					?>
				</div>
				<div class="adv-vis-ele-profile-card-hover-contact">
					<?php
					if (!empty($settings['email'])) {
						echo '<div><a href="mailto:' . $settings['email'] . '">' . $settings['email'] . '</a></div>';
					}
					
					if (!empty($settings['phone'])) {
						echo '<div><a href="tel:' . $settings['phone'] . '">' . $settings['phone'] . '</a></div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>