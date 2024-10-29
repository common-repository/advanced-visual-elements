<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Adv_Vis_Ele_Deactivator {
	/**
	 * Runs when user uninstalls the plugin
	 */
	public static function deactivate() {
		if (get_option('adv_vis_ele_delete_settings_on_uninstall') == 'on') {
			delete_option('adv_vis_ele_library_info_v2');
			delete_option('adv_vis_ele_global_mobile_breakpoint');
			delete_option('adv_vis_ele_auto_play_library_videos');
			delete_option('adv_vis_ele_enable_default_meta_viewport');
			delete_option('adv_vis_ele_disable_admin_commands_frontend');
			delete_option('adv_vis_ele_delete_settings_on_uninstall');
			
			// not used anymore but leave it here for cleanup
			delete_option('adv_vis_ele_library_info');
			delete_option('adv_vis_ele_installed_elements');
			delete_option('adv_vis_ele_library_version');
			delete_option('adv_vis_ele_site_url');
			delete_option('adv_vis_ele_library_info_new');
			
			$ave_shortcodes = get_posts(['post_type' => 'adv-vis-element', 'numberposts' => -1, 'post_status' => 'any']);
			
			foreach ($ave_shortcodes as $post) {
				wp_delete_post($post->ID, true);
			}
		}
		
		// if old Elements folder is present, delete it, then wipe the whole folder if it's empty
		$old_elements_path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'wp-ave-elements';
		
		if (is_dir($old_elements_path)) {
			$old_elements_folder = list_files($old_elements_path);
			
			if (empty($old_elements_folder)) {
				Adv_Vis_Ele_Helpers::get_wp_filesystem()->rmdir($old_elements_path);
			}
		}
	}
}