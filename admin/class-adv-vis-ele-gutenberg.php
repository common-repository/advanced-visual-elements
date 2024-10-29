<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Adv_Vis_Ele_Gutenberg_Shortcode {
	public function gutenberg_shortcode_block() {
		if (!function_exists('register_block_type') || !is_user_logged_in()) {
			return;
		}
		
		wp_enqueue_script('adv-vis-ele-gutenberg-shortcode', ADV_VIS_ELE_PLUGIN_URL . 'admin/js/adv-vis-ele-gutenberg-shortcode.js', ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'], null, true);
		
		$ave_shortcodes = get_posts(['post_type' => 'adv-vis-element', 'post_status' => 'any', 'numberposts' => -1]);
		
		$options = [];
		$options[] = ['value' => '', 'label' => 'Please select', 'disabled' => true];
		
		if (!empty($ave_shortcodes)) {
			foreach ($ave_shortcodes as $shortcode) {
				if ($shortcode->post_status !== 'publish') {
					$options[] = ['value' => $shortcode->ID, 'label' => $shortcode->post_title . ' (draft)'];
				} else {
					$options[] = ['value' => $shortcode->ID, 'label' => $shortcode->post_title];
				}
			}
		}
		
		wp_localize_script('adv-vis-ele-gutenberg-shortcode', 'aveVars', ['shortcodes' => $options]);
		
		register_block_type(__DIR__);
	}
}