<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

class Adv_Vis_Ele
{
    protected 
        $loader,
        $library,
        $plugin_name,
        $version
    ;
    public function __construct()
    {
        
        if ( defined( 'ADV_VIS_ELE_VERSION' ) ) {
            $this->version = ADV_VIS_ELE_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        
        $this->plugin_name = 'wp-ave';
        $this->load_dependencies();
        $this->set_locale();
        $this->library = new Adv_Vis_Ele_Library();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->load_elements_editor();
    }
    
    private function load_dependencies()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-adv-vis-ele-helpers.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-adv-vis-ele-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-adv-vis-ele-i18n.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-adv-vis-ele-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-adv-vis-ele-elementor.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-adv-vis-ele-gutenberg.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-adv-vis-ele-public.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-adv-vis-ele-library.php';
        $this->loader = new Adv_Vis_Ele_Loader();
    }
    
    private function set_locale()
    {
        $plugin_i18n = new Adv_Vis_Ele_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    private function define_admin_hooks()
    {
        $plugin_admin = new Adv_Vis_Ele_Admin( $this->get_plugin_name(), $this->get_version() );
        $gutenberg_shortcode = new Adv_Vis_Ele_Gutenberg_Shortcode();
        if ( get_option( 'adv_vis_ele_enable_default_meta_viewport' ) == 'on' ) {
            $this->loader->add_action( 'wp_head', $plugin_admin, 'add_viewport_meta_tag' );
        }
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'create_plugin_admin_page' );
        $this->loader->add_action( 'wp_ajax_adv_vis_ele_ajax_load_more_elements', $this->library, 'ajax_load_more_elements' );
        $this->loader->add_action( 'wp_ajax_adv_vis_ele_ajax_import_settings', $this, 'ajax_import_settings' );
        $this->loader->add_action( 'wp_ajax_adv_vis_ele_ajax_save_ordering', $this->library, 'ajax_save_ordering' );
        $this->loader->add_action( 'wp_ajax_adv_vis_ele_ajax_full_import', $this->library, 'ajax_full_import' );
        $this->loader->add_action( 'wp_ajax_adv_vis_ele_ajax_quick_save', $this->library, 'ajax_quick_save' );
        $this->loader->add_action( 'edit_form_after_editor', $this, 'element_settings_editor' );
        $this->loader->add_action( 'publish_adv-vis-element', $plugin_admin, 'on_publish_element' );
        $this->loader->add_action( 'draft_adv-vis-element', $plugin_admin, 'on_publish_element' );
        $this->loader->add_action(
            'transition_post_status',
            $plugin_admin,
            'on_transition_element',
            10,
            3
        );
        $this->loader->add_action(
            'manage_adv-vis-element_posts_custom_column',
            $plugin_admin,
            'populate_shortcodes_in_element_list',
            10,
            2
        );
        $this->loader->add_filter( 'manage_adv-vis-element_posts_columns', $plugin_admin, 'add_shortcodes_to_element_list' );
        $this->loader->add_filter(
            'post_row_actions',
            $plugin_admin,
            'add_preview_link',
            10,
            2
        );
        $this->loader->add_filter(
            'post_row_actions',
            $plugin_admin,
            'add_duplicate_button',
            10,
            2
        );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'duplicate_element' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_plugin_settings' );
        $this->loader->add_filter( 'plugin_action_links_wp-ave/wp-ave.php', $plugin_admin, 'add_plugin_page_links' );
        $this->loader->add_filter( 'admin_body_class', $plugin_admin, 'add_editor_body_classes' );
        $this->loader->add_filter( 'parent_file', $plugin_admin, 'keep_admin_menu_parent_item_open' );
        $this->loader->add_action( 'post_submitbox_misc_actions', $plugin_admin, 'add_links_to_publish_box' );
        $this->loader->add_filter( 'wp_loaded', $plugin_admin, 'quick_preview' );
        $this->loader->add_action( 'init', $gutenberg_shortcode, 'gutenberg_shortcode_block' );
        $this->loader->add_filter(
            'use_block_editor_for_post_type',
            $this,
            'disable_gutenberg',
            PHP_INT_MAX,
            2
        );
        $this->loader->add_action(
            'admin_footer',
            $plugin_admin,
            'render_help_box',
            PHP_INT_MAX
        );
        $this->loader->add_action(
            'upgrader_process_complete',
            $this,
            'delete_library_info',
            10,
            2
        );
        if ( Adv_Vis_Ele_Admin::is_dev() ) {
            $this->loader->add_action(
                'admin_footer',
                $plugin_admin,
                'dev_control_dashboard',
                PHP_INT_MAX
            );
        }
    }
    
    private function define_public_hooks()
    {
        $plugin_public = new Adv_Vis_Ele_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }
    
    public function run()
    {
        $this->loader->run();
    }
    
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    public function get_loader()
    {
        return $this->loader;
    }
    
    public function get_version()
    {
        return $this->version;
    }
    
    public function load_elements_editor()
    {
        $this->loader->add_action( 'init', $this, 'register_cpt_adv_vis_element' );
    }
    
    public function register_cpt_adv_vis_element()
    {
        $labels = [
            "name"                     => __( "Elements", 'wp-ave' ),
            "singular_name"            => __( "Element", 'wp-ave' ),
            "menu_name"                => __( "My Elements", 'wp-ave' ),
            "all_items"                => __( "All Elements", 'wp-ave' ),
            "add_new"                  => __( "Add new", 'wp-ave' ),
            "add_new_item"             => __( "Add new Element", 'wp-ave' ),
            "edit_item"                => __( "Edit Element", 'wp-ave' ),
            "new_item"                 => __( "New Element", 'wp-ave' ),
            "view_item"                => __( "View Element", 'wp-ave' ),
            "view_items"               => __( "View Elements", 'wp-ave' ),
            "search_items"             => __( "Search Elements", 'wp-ave' ),
            "not_found"                => __( "No Elements found", 'wp-ave' ),
            "not_found_in_trash"       => __( "No Elements found in trash", 'wp-ave' ),
            "parent"                   => __( "Parent Element:", 'wp-ave' ),
            "featured_image"           => __( "Featured image for this Element", 'wp-ave' ),
            "set_featured_image"       => __( "Set featured image for this Element", 'wp-ave' ),
            "remove_featured_image"    => __( "Remove featured image for this Element", 'wp-ave' ),
            "use_featured_image"       => __( "Use as featured image for this Element", 'wp-ave' ),
            "archives"                 => __( "Element archives", 'wp-ave' ),
            "insert_into_item"         => __( "Insert into Element", 'wp-ave' ),
            "uploaded_to_this_item"    => __( "Upload to this Element", 'wp-ave' ),
            "filter_items_list"        => __( "Filter Elements list", 'wp-ave' ),
            "items_list_navigation"    => __( "Elements list navigation", 'wp-ave' ),
            "items_list"               => __( "Elements list", 'wp-ave' ),
            "attributes"               => __( "Elements attributes", 'wp-ave' ),
            "name_admin_bar"           => __( "Element", 'wp-ave' ),
            "item_published"           => __( "Element published", 'wp-ave' ),
            "item_published_privately" => __( "Element published privately.", 'wp-ave' ),
            "item_reverted_to_draft"   => __( "Element reverted to draft.", 'wp-ave' ),
            "item_scheduled"           => __( "Element scheduled", 'wp-ave' ),
            "item_updated"             => __( "Element updated.", 'wp-ave' ),
            "parent_item_colon"        => __( "Parent Element:", 'wp-ave' ),
        ];
        $args = [
            "label"                 => __( "Elements", 'wp-ave' ),
            "labels"                => $labels,
            "description"           => "",
            "public"                => false,
            "publicly_queryable"    => false,
            "show_ui"               => true,
            "show_in_rest"          => false,
            "rest_base"             => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive"           => false,
            "show_in_menu"          => false,
            "show_in_nav_menus"     => false,
            "delete_with_user"      => false,
            "exclude_from_search"   => true,
            "capability_type"       => "post",
            "map_meta_cap"          => true,
            "hierarchical"          => false,
            "rewrite"               => false,
            "query_var"             => true,
            "supports"              => [ "title" ],
        ];
        register_post_type( "adv-vis-element", $args );
        remove_post_type_support( 'adv-vis-element', 'revisions' );
    }
    
    /**
     * Options editing, after the post editor
     */
    public function element_settings_editor()
    {
        global  $post ;
        $post_id = $post->ID;
        if ( $post->post_type != 'adv-vis-element' ) {
            return;
        }
        
        if ( isset( $_GET['element-id'] ) ) {
            // first time editing, redirected from the library
            $element_id = sanitize_text_field( $_GET['element-id'] );
        } else {
            $element_id = get_post_meta( $post_id, 'adv-vis-ele-element_id', true );
        }
        
        ?>
		<div class="adv-vis-ele-admin adv-vis-ele-admin-editor" data-post-id="<?php 
        echo  esc_attr( $post_id ) ;
        ?>" data-element-id="<?php 
        echo  esc_attr( $element_id ) ;
        ?>">
			<?php 
        
        if ( $element_id === false || empty($element_id) ) {
            $installed = $this->library->get_all_element_ids();
            
            if ( empty($installed) ) {
                ?>
					<div class="adv-vis-ele-notifications">
						<h5 class="adv-vis-ele-notification adv-vis-ele-error">
							<i class="fas fa-exclamation-triangle"></i><?php 
                _e( "It appears that you don't have any elements installed. Please go back to library and install some elements first.", 'wp-ave' );
                ?>
							<span class="adv-vis-ele-dismiss-notification"></span>
						</h5>
					</div>
					<?php 
                return;
            } else {
                $element_id = $installed[0];
            }
        
        }
        
        $element_info = $this->library->get_element( $element_id );
        
        if ( !$element_info ) {
            echo  '<h2>' . __( 'Sorry, this Element does not exist anymore.', 'wp-ave' ) . '</h2>' ;
            echo  '</div>' ;
            return;
        }
        
        // update first time editing metas
        if ( isset( $_GET['element-id'] ) ) {
            update_post_meta( $post_id, 'adv-vis-ele-element_id', $element_id );
        }
        ?>
			<input type="hidden" name="element-id" value="<?php 
        echo  esc_attr( $element_info->id ) ;
        ?>">
			
			<?php 
        $go_pro_link = '<h4 class="adv-vis-ele-editor-buy-heading">' . __( 'You can only publish 3 Elements with Free version. <a target="_blank" href="' . admin_url( 'admin.php?page=adv-vis-ele-pricing' ) . '"><span>' . __( 'Buy Pro!', 'wp-ave' ) . '</span></a><br><br><small>', 'wp-ave' ) . __( 'Get updates, support, unlock unlimited number of Elements, all settings including dynamic content tags and more!', 'wp-ave' ) . '</small></h4>';
        echo  wp_kses_post( $go_pro_link ) ;
        ?>
			
			<h3><?php 
        _e( 'Options', 'wp-ave' );
        ?></h3>
			<div class="adv-vis-ele-element-editor">
				<?php 
        
        if ( !empty($element_info->settings) ) {
            $meta_settings = Adv_Vis_Ele_Admin::get_element_meta_settings( $post_id );
            foreach ( $element_info->settings as $setting ) {
                
                if ( $setting->type === 'boolean' ) {
                    
                    if ( isset( $meta_settings[$setting->id] ) ) {
                        $setting->value = $meta_settings[$setting->id];
                    } else {
                        $setting->value = $setting->default;
                    }
                
                } else {
                    
                    if ( empty($meta_settings[$setting->id]) ) {
                        
                        if ( isset( $setting->default ) ) {
                            $setting->value = $setting->default;
                        } else {
                            $setting->value = '';
                        }
                    
                    } else {
                        $setting->value = $meta_settings[$setting->id];
                    }
                
                }
                
                echo  '<div class="adv-vis-ele-editor-setting adv-vis-ele-editor-setting-' . esc_attr( $setting->type ) . '" data-license="' . (( $setting->license === 'free' || wpave_fs()->is__premium_only() ? 'enabled' : 'disabled' )) . '">' ;
                
                if ( $setting->license !== 'free' && !wpave_fs()->is__premium_only() ) {
                    $go_pro_link = '<a target="_blank" href="' . admin_url( 'admin.php?page=adv-vis-ele-pricing' ) . '" class="adv-vis-ele-editor-setting-disabled-overlay"><span>' . __( 'Buy Pro!', 'wp-ave' ) . '</span></a>';
                    echo  wp_kses_post( $go_pro_link ) ;
                }
                
                echo  $this->library->render_setting_field( $setting ) ;
                echo  '</div>' ;
                // .adv-vis-ele-editor-setting
            }
        }
        
        ?>
			</div><!-- .adv-vis-ele-element-editor -->

			<h3><?php 
        _e( 'Custom code & settings', 'wp-ave' );
        ?>
				<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( 'Quick preview will not use these settings.', 'wp-ave' );
        ?>">?</span>
			</h3>

			<div class="adv-vis-ele-shortcode-css-parent-selector">
				<?php 
        echo  __( 'CSS parent/container selector', 'wp-ave' ) ;
        ?>
				<code>#adv-vis-ele-shortcode-<?php 
        echo  esc_html( $element_id ) ;
        ?>-<?php 
        echo  (int) $post_id ;
        ?></code>
				<span class="adv-vis-ele-shortcode-css-parent-selector-copy">
				<span title="Copy to clipboard"><i class="fas fa-copy"></i></span>
			</span>
			</div>
			
			<?php 
        $custom_css = get_post_meta( $post_id, 'adv-vis-ele-custom_css', true );
        $mobile_breakpoint = get_post_meta( $post_id, 'adv-vis-ele-mobile_breakpoint', true );
        $disable_on_mobile = get_post_meta( $post_id, 'adv-vis-ele-disable_on_mobile', true );
        $container_styles = get_post_meta( $post_id, 'adv-vis-ele-container_styles', true );
        $container_styles_vertical = get_post_meta( $post_id, 'adv-vis-ele-container_styles_vertical', true );
        ?>
			<div class="adv-vis-ele-editor-custom-css">
				<div>
					<textarea name="adv-vis-ele-editor-custom-css" id="adv-vis-ele-editor-custom-css" cols="30" rows="5" placeholder="<?php 
        _e( 'Custom CSS (please read the tip)', 'wp-ave' );
        ?>"><?php 
        echo  esc_textarea( $custom_css ) ;
        ?></textarea>
				</div>
				<div>
					<div class="adv-vis-ele-editor-container-styles-wrapper">
						<div>
							<label for="adv-vis-ele-editor-container-styles"><?php 
        _e( 'Container display behavior', 'wp-ave' );
        ?></label>
							<span class="adv-vis-ele-abbr" data-title="If you are using a page builder - you probably want to leave this on Default and set it on a parent element inside the builder.">?</span>
						</div>
						<select name="adv-vis-ele-editor-container-styles" id="adv-vis-ele-editor-container-styles">
							<option value="" <?php 
        selected( $container_styles, '' );
        ?>>Default</option>
							<option value="block" <?php 
        selected( $container_styles, 'block' );
        ?>>Block</option>
							<option value="inline-block" <?php 
        selected( $container_styles, 'inline-block' );
        ?>>Inline Block</option>
							<option value="flex-start" <?php 
        selected( $container_styles, 'flex-start' );
        ?>>Flex left</option>
							<option value="center" <?php 
        selected( $container_styles, 'center' );
        ?>>Flex center</option>
							<option value="flex-end" <?php 
        selected( $container_styles, 'flex-end' );
        ?>>Flex right</option>
							<option value="inline-flex" <?php 
        selected( $container_styles, 'inline-flex' );
        ?>>Inline Flex</option>
						</select>
						<select name="adv-vis-ele-editor-container-styles-vertical" id="adv-vis-ele-editor-container-styles-vertical" title="<?php 
        _e( 'Vertical align', 'wp-ave' );
        ?>">
							<option value="flex-start" <?php 
        selected( $container_styles_vertical, 'top' );
        ?>>Top</option>
							<option value="center" <?php 
        selected( $container_styles_vertical, 'center' );
        ?>>Center</option>
							<option value="flex-end" <?php 
        selected( $container_styles_vertical, 'bottom' );
        ?>>Bottom</option>
						</select>
					</div>
					<div class="adv-vis-ele-editor-disable-on-mobile-wrapper">
						<div>
							<label for="adv-vis-ele-editor-disable-on-mobile"><?php 
        _e( 'Disable on mobile?', 'wp-ave' );
        ?></label>
							<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( 'This depends on wp_is_mobile() WordPress function.', 'wp-ave' );
        ?> <a target='_blank' href='https://developer.wordpress.org/reference/functions/wp_is_mobile/'>wp_is_mobile()</a>">?</span>
						</div>
						<label class="adv-vis-ele-switch-input" for="adv-vis-ele-editor-disable-on-mobile">
							<input id="adv-vis-ele-editor-disable-on-mobile" name="adv-vis-ele-editor-disable-on-mobile" type="checkbox" <?php 
        checked( $disable_on_mobile, 'on' );
        ?>>
							<span class="adv-vis-ele-slider-input"></span></label>
					</div>
					<div class="adv-vis-ele-editor-mobile-breakpoint-wrapper">
						<label for="adv-vis-ele-editor-mobile-breakpoint"><?php 
        _e( 'Mobile breakpoint', 'wp-ave' );
        ?>
							<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( 'If there are mobile settings in the editor above, this value applies to them. If left empty - this value will be overwritten by the value set in general plugin settings.', 'wp-ave' );
        ?>">?</span>
						</label>
						<input type="number" name="adv-vis-ele-editor-mobile-breakpoint" id="adv-vis-ele-editor-mobile-breakpoint" min="0" placeholder="<?php 
        _e( esc_attr( get_option( 'adv_vis_ele_global_mobile_breakpoint' ) ), 'wp-ave' );
        ?>" value="<?php 
        echo  esc_attr( $mobile_breakpoint ) ;
        ?>">&nbsp;px
					</div>
				</div>
			</div>

			<h3><?php 
        _e( 'Export & Import options', 'wp-ave' );
        ?></h3>
			<?php 
        $element_settings_for_export = [];
        // add the Element ID here first so we can compare it when importing
        $element_settings_for_export['adv-vis-ele-element_id'] = $element_id;
        foreach ( $element_info->settings as $setting ) {
            $element_settings_for_export[$setting->id] = $setting->value;
        }
        $element_settings_for_export = json_encode( $element_settings_for_export );
        ?>
			<div class="adv-vis-ele-editor-export-import">
				<div class="adv-vis-ele-editor-export-container">
					<h4>Export</h4>
					<textarea name="adv-vis-ele-export-settings" id="adv-vis-ele-export-settings" cols="30" rows="5"><?php 
        echo  esc_textarea( $element_settings_for_export ) ;
        ?></textarea>
					<button type="button" class="adv-vis-ele-btn"><?php 
        _e( 'Copy options', 'wp-ave' );
        ?></button>
				</div>
				<div class="adv-vis-ele-editor-import-container">
					<h4>Import</h4>
					<textarea name="adv-vis-ele-import-settings" id="adv-vis-ele-import-settings" cols="30" rows="5"></textarea>
					<button type="button" class="adv-vis-ele-btn" data-post-id="<?php 
        echo  (int) $post_id ;
        ?>" data-element-id="<?php 
        echo  esc_attr( $element_id ) ;
        ?>"><?php 
        _e( 'Import options', 'wp-ave' );
        ?></button>
				</div>
			</div>
		</div>

		<div class="adv-vis-ele-element-previewer-container">
			<h3><?php 
        _e( 'Quick preview', 'wp-ave' );
        ?>
				<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( 'Elements that are not Published will not show for visitors. Only administrators can see Drafted elements.', 'wp-ave' );
        ?>">?</span>
				<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( 'Some older browsers might render differently or not render at all. Make sure to test thoroughly using tools like Browserstack. You can use AVE filters to prevent rendering elements on different browsers/devices. Please check FAQ section on the Settings page.', 'wp-ave' );
        ?>">?</span>
				<span class="adv-vis-ele-abbr" data-title="<?php 
        _e( "If your mobile Elements appear as desktop - go to Settings page and enable Meta Viewport Default Scale option.", 'wp-ave' );
        ?>">?</span>
				<span class="dashicons dashicons-star-half adv-vis-ele-element-previewer-theme" data-theme="light"></span>
			</h3>

			<div class="adv-vis-ele-element-previewer" data-theme="light">
				<iframe src="<?php 
        echo  esc_url( site_url( '?ave-preview-on-front=' . $post->ID . '&element-id=' . $element_id ) ) ;
        ?>" frameborder="0"></iframe>
			</div>
		</div>

		<div id="adv-vis-ele-element-dynamic-settings-modal">
			<div class="adv-vis-ele-element-dynamic-settings-type"></div>
			<a href="#" class="adv-vis-ele-element-dynamic-settings-modal-close">
				<i class="fas fa-times"></i>
			</a>
			<div class="adv-vis-ele-element-dynamic-settings-modal-add">
				<?php 
        foreach ( Adv_Vis_Ele_Library::$dynamic_settings as $category_name => $dynamic_category ) {
            echo  '<h3>' . esc_html( $category_name ) . '</h3>' ;
            echo  '<div>' ;
            foreach ( $dynamic_category as $id => $name ) {
                echo  '<a href="#" data-setting="' . esc_attr( Adv_Vis_Ele_Library::$dynamic_settings_delimiter_start . $id . Adv_Vis_Ele_Library::$dynamic_settings_delimiter_end ) . '">' . esc_html( $name ) . '</a>' ;
                
                if ( $category_name === 'Meta/ACF' ) {
                    echo  '<input class="adv-vis-ele-element-dynamic-settings-meta-key" value="" autocomplete="off"/>' ;
                    echo  '<span class="adv-vis-ele-abbr" data-title="' . __( 'Please provide meta field key. You can also select from suggestions below. Will work only with textual (string) and numeric (integer) fields.', 'wp-ave' ) . ' ">?</span>' ;
                    $meta_keys = Adv_Vis_Ele_Helpers::get_all_meta_keys();
                    
                    if ( !empty($meta_keys) ) {
                        $meta_html = '';
                        foreach ( $meta_keys as $meta_key ) {
                            if ( strpos( $meta_key, 'adv-vis-ele-' ) === 0 ) {
                                continue;
                            }
                            $meta_html .= '<option>' . esc_html( $meta_key ) . '</option>';
                        }
                        
                        if ( !empty($meta_html) ) {
                            echo  '<div>' ;
                            echo  '<select class="adv-vis-ele-element-dynamic-settings-meta-select">' ;
                            echo  wp_kses( $meta_html, [
                                'option' => [],
                            ] ) ;
                            echo  '</select>' ;
                            echo  '</div>' ;
                        }
                    
                    }
                
                }
            
            }
            echo  '</div>' ;
        }
        ?>
			</div>
		</div>
		<?php 
    }
    
    /**
     * Element editor AJAX options import
     */
    public function ajax_import_settings()
    {
        $nonce_verified = isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ave_ajax' );
        if ( !$nonce_verified ) {
            wp_send_json_error( [
                'code' => '010',
            ] );
        }
        $post_id = (int) $_POST['id'];
        $element_id = sanitize_text_field( $_POST['element-id'] );
        $settings = [];
        foreach ( $_POST['settings'] as $key => $setting ) {
            $key = sanitize_text_field( $key );
            
            if ( is_array( $setting ) ) {
                $settings[$key] = array_map( 'wp_kses_post', $setting );
            } else {
                $settings[$key] = wp_kses_post( $setting );
            }
            
            if ( $settings[$key] === 'true' ) {
                $settings[$key] = 'on';
            }
        }
        if ( !$settings ) {
            wp_send_json_error( [
                'message' => __( "Couldn't properly decode options string.", 'wp-ave' ),
            ] );
        }
        $redirection_url = '';
        
        if ( get_post_status( $post_id ) === 'auto-draft' ) {
            wp_update_post( [
                'ID'          => $post_id,
                'post_status' => 'draft',
                'post_title'  => 'AVE Element ' . $post_id,
            ] );
            $redirection_url = admin_url() . 'post.php?post=' . (int) $post_id . '&action=edit';
        }
        
        
        if ( !empty($settings) && !empty($post_id) ) {
            $settings_element_id = $settings['adv-vis-ele-element_id'];
            if ( $element_id !== $settings_element_id ) {
                wp_send_json_error( [
                    'message' => __( 'These options do not match the library Element. Try importing to a different shortcode.', 'wp-ave' ),
                ] );
            }
            unset( $settings['adv-vis-ele-element_id'] );
            // remove the Element ID because we want only options
            $saving = $this->library->get_saving_settings( $settings, $element_id );
            Adv_Vis_Ele_Admin::save_element_meta_settings( $saving, $post_id );
            wp_send_json_success( [
                'redirection_url' => $redirection_url,
                'message'         => __( 'Options imported. Reloading the page...', 'wp-ave' ),
            ] );
        } else {
            wp_send_json_error( [
                'message' => __( "Couldn't properly decode options string.", 'wp-ave' ),
            ] );
        }
    
    }
    
    /**
     * Disable Gutenberg editor for WP AVE Elements
     */
    public function disable_gutenberg( $current_status, $post_type )
    {
        return $post_type !== 'adv-vis-element';
    }
    
    /**
     * Delete library info when plugin is being updated, next time it loads it will fetch new info
     */
    function delete_library_info( $upgrader_object, $options )
    {
        if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
            update_option( 'adv_vis_ele_library_info_v2', [] );
        }
    }

}