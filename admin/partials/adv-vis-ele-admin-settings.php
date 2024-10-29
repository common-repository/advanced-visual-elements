<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$library = new Adv_Vis_Ele_Library();

$readme_path = ADV_VIS_ELE_PLUGIN_DIR . '/README.txt';

$faq_str = '== Frequently Asked Questions ==';

$readme_raw = Adv_Vis_Ele_Helpers::get_wp_filesystem()->get_contents($readme_path);
$readme = substr($readme_raw, strpos($readme_raw, $faq_str) + strlen($faq_str));
preg_match_all('/^= (.+) =$/m', $readme, $questions);
$answers = preg_split("/\n\n= (.+) =\n/", $readme);
$answers = array_values(array_filter($answers));
?>
<div class="adv-vis-ele-admin adv-vis-ele-admin-settings">
	<h3><?php _e('Settings', 'adv-vis-ele'); ?></h3>

	<div class="adv-vis-ele-admin-settings-form">
		<form method="POST" action="options.php">
			<?php
			settings_fields('adv_vis_ele_general_settings');
			do_settings_sections('adv_vis_ele_general_settings');
			?>

			<div class="adv-vis-ele-options-container">
				<div class="adv-vis-ele-options-single">
					<div class="adv-vis-ele-options-input">
						<input required type="text" id="adv_vis_ele_global_mobile_breakpoint" name="adv_vis_ele_global_mobile_breakpoint" value="<?php echo esc_attr(get_option('adv_vis_ele_global_mobile_breakpoint')); ?>"/>
					</div>
					<label for="adv_vis_ele_global_mobile_breakpoint" class="adv-vis-ele-options-label"><?php _e('Global Mobile Breakpoint (in pixels). Can be set individually for each shortcode created.', 'adv-vis-ele'); ?></label>
				</div>

				<div class="adv-vis-ele-options-single">
					<label class="adv-vis-ele-switch-input" for="adv_vis_ele_auto_play_library_videos">
						<input id="adv_vis_ele_auto_play_library_videos" name="adv_vis_ele_auto_play_library_videos" type="checkbox" <?php checked(get_option('adv_vis_ele_auto_play_library_videos'), 'on'); ?>>
						<span class="adv-vis-ele-slider-input"></span>
					</label>
					<label for="adv_vis_ele_auto_play_library_videos"><?php _e('Auto-play preview videos in library?', 'adv-vis-ele'); ?></label>
				</div>

				<div class="adv-vis-ele-options-single">
					<label class="adv-vis-ele-switch-input" for="adv_vis_ele_enable_default_meta_viewport">
						<input id="adv_vis_ele_enable_default_meta_viewport" name="adv_vis_ele_enable_default_meta_viewport" type="checkbox" <?php checked(get_option('adv_vis_ele_enable_default_meta_viewport'), 'on'); ?>>
						<span class="adv-vis-ele-slider-input"></span>
					</label>
					<label for="adv_vis_ele_enable_default_meta_viewport"><?php _e('Enable Meta Viewport Default Scale?', 'adv-vis-ele'); ?></label>
					<span class="adv-vis-ele-abbr" data-title="<?php _e('This will add a default meta tag to head section of your website which will help reset device scaling. Use this if Elements look on mobile as they would on desktop - in other words they appear bigger than usual.', 'adv-vis-ele'); ?>">?</span>
				</div>

				<div class="adv-vis-ele-options-single">
					<label class="adv-vis-ele-switch-input" for="adv_vis_ele_disable_admin_commands_frontend">
						<input id="adv_vis_ele_disable_admin_commands_frontend" name="adv_vis_ele_disable_admin_commands_frontend" type="checkbox" <?php checked(get_option('adv_vis_ele_disable_admin_commands_frontend'), 'on'); ?>>
						<span class="adv-vis-ele-slider-input"></span>
					</label>
					<label for="adv_vis_ele_disable_admin_commands_frontend"><?php _e('Disable admin buttons while hovering ELements on frontend? (such as Edit Element button)', 'adv-vis-ele'); ?></label>
				</div>

				<div class="adv-vis-ele-options-single">
					<label class="adv-vis-ele-switch-input" for="adv_vis_ele_delete_settings_on_uninstall">
						<input id="adv_vis_ele_delete_settings_on_uninstall" name="adv_vis_ele_delete_settings_on_uninstall" type="checkbox" <?php checked(get_option('adv_vis_ele_delete_settings_on_uninstall'), 'on'); ?>>
						<span class="adv-vis-ele-slider-input"></span>
					</label>
					<label for="adv_vis_ele_delete_settings_on_uninstall"><?php _e('Delete all plugin settings and shortcodes on plugin uninstall?', 'adv-vis-ele'); ?></label>
				</div>
			</div>
			
			<?php submit_button('Save'); ?>
		</form>
	</div>

	<hr>

	<h3 class="adv-vis-ele-admin-support-h3"><?php _e('Support', 'adv-vis-ele'); ?></h3>
	
	<div class="adv-vis-ele-admin-support-container">
		<div class="adv-vis-ele-admin-support-faq-container">
			<p><i><?php _e('FAQ', 'adv-vis-ele'); ?></i></p>

			<div class="adv-vis-ele-admin-support-faq">
				<?php
				if (!empty($questions[1])) {
					foreach ($questions[1] as $k => $question) {
						echo '<div>';
						
						echo '<i>' . esc_html($question) . '</i>';
						echo '<div>' . wp_kses_post(nl2br($answers[$k])) . '</div>';
						
						echo '</div>';
					}
				}
				?>
			</div>
		</div>

		<div class="adv-vis-ele-admin-support-debug-container">
			<p><i><?php _e('Debug info', 'adv-vis-ele'); ?></i></p>
			<?php
			try {
				$notavailable = __('This information is not available.', 'adv-vis-ele');
				
				$new_line = '&#13;&#10;';
				
				if (!function_exists('get_bloginfo')) {
					$wp = $notavailable;
				} else {
					$wp = get_bloginfo('version');
				}
				
				if (!function_exists('wp_get_theme')) {
					$theme = $notavailable;
				} else {
					$theme = wp_get_theme();
				}
				
				if (!function_exists('get_plugins')) {
					$plugins = $notavailable;
				} else {
					$plugins_list = get_plugins();
					$plugins = '';
					
					if (is_array($plugins_list)) {
						foreach ($plugins_list as $plugin) {
							$version = '' != $plugin['Version'] ? $plugin['Version'] : __('Unversioned', 'adv-vis-ele');
							
							if (!empty($plugin['PluginURI'])) {
								$plugins .= $plugin['Name'] . ' (ver. ' . $version . ') [' . $plugin['PluginURI'] . ']' . $new_line;
							} else {
								$plugins .= $plugin['Name'] . ' (ver. ' . $version . ')' . $new_line;
							}
						}
					} else {
						$plugins = __('No plugins installed.');
					}
				}
				
				if (!function_exists('phpversion')) {
					$php = $notavailable;
				} else {
					$php = phpversion();
				}
				
				global $wpdb;
				$rows = $wpdb->get_results('select version() as mysqlversion');
				if (!empty($rows)) {
					$mysql = $rows[0]->mysqlversion;
				} else {
					$mysql = $notavailable;
				}
				
				$themeversion = $theme->get('Name') . __(' version ', 'adv-vis-ele') . $theme->get('Version') . ' - ' . $theme->get('Template');
				$themeauth = $theme->get('Author') . ' - ' . $theme->get('AuthorURI');
				$uri = $theme->get('ThemeURI');
				
				echo '<form>';
				echo '<textarea rows="30" cols="100" disabled style="resize: none;">';
				
				echo 'WordPress Version: ' . wp_kses_post($wp . $new_line . $new_line);
				echo 'Current WordPress Theme: ' . wp_kses_post($themeversion . $new_line);
				echo 'Theme Author: ' . wp_kses_post($themeauth . $new_line);
				echo 'Theme URI: ' . wp_kses_post($uri . $new_line . $new_line);
				echo 'PHP Version: ' . wp_kses_post($php . $new_line . $new_line);
				echo 'MySQL Version: ' . wp_kses_post($mysql . $new_line . $new_line);
				echo 'Server Version: ' . wp_kses_post($_SERVER['SERVER_SOFTWARE'] . $new_line . $new_line);
				echo 'Memory Limit: ' . wp_kses_post(WP_MEMORY_LIMIT . $new_line . $new_line);
				echo 'Active Plugins: ' . wp_kses_post($new_line . $plugins . $new_line);
				echo 'WP AVE info:' . wp_kses_post($new_line . $new_line);
				echo 'Plugin Version: ' . wp_kses_post(ADV_VIS_ELE_VERSION . $new_line);
				echo 'Elements Folder Writable: ' . (wp_is_writable(ADV_VIS_ELE_ELEMENTS_DIR) ? 'Yes' : 'No') . wp_kses_post($new_line);
				
				echo '</textarea>';
				echo '</form>';
			} catch (Exception $e) {
				_e('Something went wrong.', 'adv-vis-ele');
			}
			?>
		</div>
	</div>
	
	<?php include('adv-vis-ele-admin-footer.php'); ?>
</div>