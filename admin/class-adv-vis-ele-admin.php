<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

class Adv_Vis_Ele_Admin
{
    private  $plugin_name, $version, $library ;
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->library = new Adv_Vis_Ele_Library();
    }
    
    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles()
    {
        
        if ( Adv_Vis_Ele_Admin::visiting_plugin_pages() ) {
            if ( !wp_style_is( 'wp-color-picker' ) ) {
                wp_enqueue_style( 'wp-color-picker' );
            }
            if ( !wp_style_is( 'font-awesome' ) ) {
                wp_enqueue_style(
                    'font-awesome',
                    ADV_VIS_ELE_PLUGIN_URL . 'vendor/fontawesome-5.15.1/css/all.min.css',
                    [],
                    $this->version,
                    'all'
                );
            }
            if ( !wp_style_is( $this->plugin_name ) ) {
                wp_enqueue_style(
                    $this->plugin_name,
                    ADV_VIS_ELE_PLUGIN_URL . 'admin/css/adv-vis-ele-admin.css',
                    [],
                    $this->version,
                    'all'
                );
            }
        }
    
    }
    
    /**
     * Check if we're on any of the plugin pages
     */
    public static function visiting_plugin_pages()
    {
        return in_array( get_current_screen()->id, ADV_VIS_ELE_PAGE_SCREEN_IDS ) || get_current_screen()->base === 'post' && get_current_screen()->post_type === 'adv-vis-element';
    }
    
    /**
     * Register JavaScript for the admin area.
     */
    public function enqueue_scripts()
    {
        
        if ( Adv_Vis_Ele_Admin::visiting_plugin_pages() ) {
            global  $pagenow ;
            // disable auto saves
            switch ( get_post_type() ) {
                case 'adv-vis-element':
                    wp_dequeue_script( 'autosave' );
                    break;
            }
            $editing_element = isset( $_GET['post_type'] ) && $pagenow === 'edit.php' && sanitize_text_field( $_GET['post_type'] ) === 'adv-vis-element' || $pagenow == 'post.php' && get_post_type() == 'adv-vis-element';
            if ( !did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            if ( !wp_script_is( 'jquery' ) ) {
                wp_enqueue_script( 'jquery' );
            }
            $adv_ce_settings['codeEditor'] = wp_enqueue_code_editor( [
                'type' => 'text/css',
            ] );
            if ( !wp_script_is( 'wp-theme-plugin-editor' ) ) {
                wp_enqueue_script(
                    'wp-theme-plugin-editor',
                    '',
                    [ 'jquery' ],
                    false,
                    true
                );
            }
            if ( !wp_style_is( 'wp-codemirror' ) ) {
                wp_enqueue_style( 'wp-codemirror' );
            }
            if ( !wp_script_is( 'wp-color-picker' ) ) {
                wp_enqueue_script( 'wp-color-picker' );
            }
            if ( !wp_script_is( 'wp-color-picker-alpha' ) ) {
                wp_enqueue_script(
                    'wp-color-picker-alpha',
                    ADV_VIS_ELE_PLUGIN_URL . 'admin/js/wp-color-picker-alpha.js',
                    [ 'wp-color-picker' ],
                    '3.0.0',
                    true
                );
            }
            if ( !wp_script_is( 'popper-js' ) ) {
                wp_enqueue_script(
                    'popper-js',
                    ADV_VIS_ELE_PLUGIN_URL . 'vendor/tippyjs/popper.min.js',
                    [],
                    $this->version,
                    true
                );
            }
            if ( !wp_script_is( 'tippy-js' ) ) {
                wp_enqueue_script(
                    'tippy-js',
                    ADV_VIS_ELE_PLUGIN_URL . 'vendor/tippyjs/tippy-bundle.umd.min.js',
                    [],
                    $this->version,
                    true
                );
            }
            if ( !wp_script_is( $this->plugin_name ) ) {
                wp_enqueue_script(
                    $this->plugin_name,
                    ADV_VIS_ELE_PLUGIN_URL . 'admin/js/adv-vis-ele-admin.js',
                    [ 'jquery' ],
                    $this->version,
                    true
                );
            }
            $is_add_new_btn = is_admin() && $editing_element;
            $library_ordering = get_user_meta( get_current_user_id(), 'adv_vis_ele_library_ordering', true );
            
            if ( empty($library_ordering) ) {
                $library_ordering = 'asc';
                add_user_meta( get_current_user_id(), 'adv_vis_ele_library_ordering', $library_ordering );
            }
            
            wp_localize_script( $this->plugin_name, 'adv_vis_ele_admin_vars', [
                'nonce'                           => wp_create_nonce( 'ave_ajax' ),
                'site_url'                        => site_url(),
                'ajax_url'                        => admin_url( 'admin-ajax.php' ),
                'admin_url'                       => admin_url( 'admin.php' ),
                'wp_admin_url'                    => admin_url(),
                'is_pro'                          => wpave_fs()->is__premium_only(),
                'translations'                    => Adv_Vis_Ele_i18n::$translations,
                'auto_play_library_videos'        => ( get_option( 'adv_vis_ele_auto_play_library_videos' ) == 'on' ? 1 : 0 ),
                'is_add_new_btn'                  => $is_add_new_btn,
                'cm_settings'                     => $adv_ce_settings,
                'library_ordering'                => $library_ordering,
                'dynamic_setting_delimiter_start' => Adv_Vis_Ele_Library::$dynamic_settings_delimiter_start,
                'dynamic_setting_delimiter_end'   => Adv_Vis_Ele_Library::$dynamic_settings_delimiter_end,
            ] );
        }
    
    }
    
    /**
     * Creates the plugin configuration page(s)
     */
    public function create_plugin_admin_page()
    {
        add_menu_page(
            'Advanced Visual Elements',
            'Advanced Visual Elements',
            'manage_options',
            'adv-vis-ele',
            function () {
            include_once 'partials/adv-vis-ele-admin-library.php';
        },
            ADV_VIS_ELE_PLUGIN_URL . 'img/adv-vis-ele-dashicon.png'
        );
        add_submenu_page(
            'adv-vis-ele',
            'Advanced Visual Elements Library',
            'Library',
            'manage_options',
            'adv-vis-ele',
            function () {
            include_once 'partials/adv-vis-ele-admin-library.php';
        }
        );
        add_submenu_page(
            'adv-vis-ele',
            'Advanced Visual Shortcodes',
            'Shortcodes',
            'manage_options',
            'edit.php?post_type=adv-vis-element'
        );
        add_submenu_page(
            'adv-vis-ele',
            'Advanced Visual Elements Settings',
            'Settings',
            'manage_options',
            'adv-vis-ele-settings',
            function () {
            include_once 'partials/adv-vis-ele-admin-settings.php';
        }
        );
    }
    
    /**
     * Add element ID when publishing it for the first time
     */
    public function on_publish_element( $post_id )
    {
        if ( isset( $_POST['element-id'] ) ) {
            $element_id = sanitize_text_field( $_POST['element-id'] );
        }
        
        if ( !empty($element_id) ) {
            // this means we are in editor
            update_post_meta( $post_id, 'adv-vis-ele-element_id', $element_id );
            update_post_meta( $post_id, 'adv-vis-ele-custom_css', sanitize_textarea_field( $_POST['adv-vis-ele-editor-custom-css'] ) );
            update_post_meta( $post_id, 'adv-vis-ele-mobile_breakpoint', sanitize_text_field( $_POST['adv-vis-ele-editor-mobile-breakpoint'] ) );
            update_post_meta( $post_id, 'adv-vis-ele-disable_on_mobile', ( isset( $_POST['adv-vis-ele-editor-disable-on-mobile'] ) ? 'on' : false ) );
            update_post_meta( $post_id, 'adv-vis-ele-container_styles', sanitize_textarea_field( $_POST['adv-vis-ele-editor-container-styles'] ) );
            update_post_meta( $post_id, 'adv-vis-ele-container_styles_vertical', sanitize_textarea_field( $_POST['adv-vis-ele-editor-container-styles-vertical'] ) );
        }
        
        
        if ( isset( $_POST['adv-vis-ele-editor-settings'] ) ) {
            $settings = [];
            foreach ( $_POST['adv-vis-ele-editor-settings'] as $key => $setting ) {
                $key = sanitize_text_field( $key );
                
                if ( is_array( $setting ) ) {
                    $settings[$key] = array_map( 'wp_kses_post', $setting );
                } else {
                    $settings[$key] = wp_kses_post( $setting );
                }
            
            }
        }
        
        if ( !empty($_POST['adv-vis-ele-editor-settings-dynamic']) ) {
            foreach ( $_POST['adv-vis-ele-editor-settings-dynamic'] as $setting_name => $dynamic_setting ) {
                $setting_name = sanitize_text_field( $setting_name );
                $settings[$setting_name] = sanitize_text_field( $dynamic_setting );
            }
        }
        if ( isset( $_POST['adv-vis-ele-editor-settings-bool'] ) ) {
            foreach ( $_POST['adv-vis-ele-editor-settings-bool'] as $bool_name => $bool_value ) {
                $bool_name = sanitize_text_field( $bool_name );
                $settings[$bool_name] = ( isset( $_POST['adv-vis-ele-editor-settings'][$bool_name] ) ? sanitize_text_field( $_POST['adv-vis-ele-editor-settings'][$bool_name] ) : false );
            }
        }
        if ( !isset( $settings ) || !isset( $element_id ) ) {
            return;
        }
        
        if ( !empty($settings) && !empty($element_id) ) {
            $post_meta = Adv_Vis_Ele_Admin::get_element_meta_settings( $post_id );
            $saving = [];
            foreach ( $settings as $setting_name => $setting_value ) {
                $setting = $this->library->get_element_setting( $element_id, $setting_name );
                
                if ( $setting ) {
                    
                    if ( $setting->license !== 'free' ) {
                        
                        if ( isset( $post_meta[$setting_name] ) && !empty($post_meta[$setting_name]) ) {
                            $saving[$setting_name] = $post_meta[$setting_name];
                        } else {
                            $saving[$setting_name] = $setting->default;
                        }
                    
                    } else {
                        $saving[$setting_name] = Adv_Vis_Ele_Admin::filter_setting( $setting, $setting_value );
                    }
                
                } else {
                    $saving[$setting_name] = '';
                }
            
            }
            Adv_Vis_Ele_Admin::save_element_meta_settings( $saving, $post_id );
        }
    
    }
    
    /**
     * Fired before new Element transitions it's post status
     */
    function on_transition_element( $new_status, $old_status, $post )
    {
        
        if ( ($new_status === 'publish' || $new_status === 'private') && $post->post_type === 'adv-vis-element' ) {
            global  $wpdb ;
            $count = $wpdb->get_var( "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_type = 'adv-vis-element' and (post_status = 'publish' OR post_status = 'private')" );
            if ( (int) $count > 10 - 7 ) {
                if ( $post->ID > 0 ) {
                    $wpdb->query( "UPDATE {$wpdb->posts} SET post_status = 'draft' WHERE ID = {$post->ID};" );
                }
            }
        }
    
    }
    
    /**
     * Get meta settings
     */
    public static function get_element_meta_settings( $post_id, $preview = false )
    {
        
        if ( $preview ) {
            $meta_settings = get_post_meta( $post_id, 'adv-vis-ele-editor-settings-preview', true );
        } else {
            $meta_settings = get_post_meta( $post_id, 'adv-vis-ele-editor-settings', true );
        }
        
        if ( empty($meta_settings) ) {
            return [];
        }
        // WordPress automatically adds slashes before they're saved to post meta
        foreach ( $meta_settings as $key => $meta_setting ) {
            
            if ( is_array( $meta_setting ) ) {
                $meta_settings[$key] = array_map( 'wp_unslash', $meta_setting );
            } else {
                $meta_settings[$key] = wp_unslash( $meta_setting );
            }
        
        }
        return $meta_settings;
    }
    
    /**
     * Save meta settings
     */
    public static function save_element_meta_settings( $saving, $post_id, $preview = false )
    {
        
        if ( $preview ) {
            return update_post_meta( $post_id, 'adv-vis-ele-editor-settings-preview', $saving );
        } else {
            // save preview settings as well along with live settings
            update_post_meta( $post_id, 'adv-vis-ele-editor-settings-preview', $saving );
            return update_post_meta( $post_id, 'adv-vis-ele-editor-settings', $saving );
        }
    
    }
    
    /**
     * Filter settings
     */
    public static function filter_setting( $setting, $setting_value )
    {
        
        if ( $setting->type === 'number' ) {
            
            if ( !empty($setting->min) && !empty($setting->max) ) {
                $value = Adv_Vis_Ele_Helpers::clamp( $setting_value, $setting->min, $setting->max );
            } else {
                $value = $setting_value;
            }
        
        } else {
            
            if ( $setting->type === 'boolean' ) {
                if ( strtolower( $setting_value ) === 'on' || $setting_value === '1' || $setting_value === true ) {
                    return true;
                }
                return false;
            } else {
                $value = $setting_value;
            }
        
        }
        
        return $value;
    }
    
    /**
     * Add shortcodes to element lists
     */
    public function add_shortcodes_to_element_list( $defaults )
    {
        $defaults['ave_element_id'] = 'Library Element';
        $defaults['ave_shortcode'] = 'Shortcode/PHP code';
        return $defaults;
    }
    
    /**
     * Populate shortcodes in element list
     */
    public function populate_shortcodes_in_element_list( $column_name, $post_id )
    {
        
        if ( $column_name === 'ave_shortcode' ) {
            echo  '<div class="adv-vis-ele-shortcode-list-container">' ;
            echo  '<div><code>[ave-element id=&quot;' . (int) $post_id . '&quot;]</code><i class="adv-vis-ele-elements-list-clipboard fas fa-copy"></i></div>' ;
            echo  '<div><code>&lt;?php echo do_shortcode(&#39;[ave-element id=&quot;' . (int) $post_id . '&quot;]&#39;); ?&gt;</code><i class="adv-vis-ele-elements-list-clipboard fas fa-copy"></i></div>' ;
            echo  '</div>' ;
        }
        
        
        if ( $column_name === 'ave_element_id' ) {
            $element_id = get_post_meta( $post_id, 'adv-vis-ele-element_id', true );
            
            if ( !empty($element_id) ) {
                $element = $this->library->get_element( $element_id );
                echo  '<div class="adv-vis-ele-element-list-container">' ;
                
                if ( $element ) {
                    echo  '<div>' . esc_html( $element->name ) . '</div>' ;
                } else {
                    echo  '<div>' . __( 'Missing Element.', 'wp-ave' ) . '</div>' ;
                }
                
                echo  '</div>' ;
            }
        
        }
    
    }
    
    /**
     * Get duplicate Element URL/link
     */
    public static function get_duplicate_link( $post_id )
    {
        $url = admin_url( 'edit.php' );
        return add_query_arg( [
            'post_type'  => 'adv-vis-element',
            'post_id'    => $post_id,
            'ave_action' => 'adv_vis_ele_duplicate_element',
            'nonce'      => wp_create_nonce( 'adv_vis_ele_duplicate_element' ),
        ], $url );
    }
    
    /**
     * Add duplicate button to elements list
     */
    public function add_duplicate_button( $actions, $post )
    {
        if ( $post->post_type === 'adv-vis-element' ) {
            $actions = array_merge( $actions, [
                'adv_vis_ele_duplicate_element' => sprintf( '<a href="%1$s">%2$s</a>', esc_url( Adv_Vis_Ele_Admin::get_duplicate_link( $post->ID ) ), __( 'Duplicate Element' ) ),
            ] );
        }
        return $actions;
    }
    
    /**
     * Duplicate element
     */
    public function duplicate_element()
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }
        if ( !isset( $_GET['ave_action'] ) ) {
            return;
        }
        $nonce_verified = isset( $_GET['nonce'] ) && wp_verify_nonce( $_GET['nonce'], 'adv_vis_ele_duplicate_element' );
        if ( !$nonce_verified ) {
            return;
        }
        
        if ( sanitize_text_field( $_GET['ave_action'] ) === 'adv_vis_ele_duplicate_element' ) {
            $post_id = (int) $_GET['post_id'];
            if ( !current_user_can( 'administrator' ) ) {
                return;
            }
            $title = get_the_title( $post_id );
            $oldpost = get_post( $post_id );
            $current_user = wp_get_current_user();
            $author = $current_user->ID;
            $post = [
                'post_title'  => $title . ' (duplicate)',
                'post_status' => 'draft',
                'post_type'   => $oldpost->post_type,
                'post_author' => $author,
            ];
            $new_post_id = wp_insert_post( $post );
            $element_id = get_post_meta( $post_id, 'adv-vis-ele-element_id', true );
            add_post_meta( $new_post_id, 'adv-vis-ele-element_id', $element_id );
            $meta_settings = get_post_meta( $post_id, 'adv-vis-ele-editor-settings', true );
            add_post_meta( $new_post_id, 'adv-vis-ele-editor-settings', $meta_settings );
            wp_redirect( admin_url( 'edit.php?post_type=adv-vis-element' ) );
            die;
        }
    
    }
    
    /**
     * Add preview link to elements list
     */
    public function add_preview_link( $actions, $post )
    {
        if ( $post->post_type === 'adv-vis-element' ) {
            $actions = array_merge( $actions, [
                'adv_vis_ele_preview_on_front_end' => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( site_url( '?ave-preview-on-front=' . esc_attr( $post->ID ) ) ), __( 'Preview on front-end' ) ),
            ] );
        }
        return $actions;
    }
    
    /**
     * Plugin settings
     */
    public function register_plugin_settings()
    {
        
        if ( empty(get_option( 'adv_vis_ele_global_mobile_breakpoint' )) ) {
            add_option( 'adv_vis_ele_global_mobile_breakpoint', ADV_VIS_ELE_GLOBAL_MOBILE_BREAKPOINT );
            add_option( 'adv_vis_ele_auto_play_library_videos', 'on' );
            add_option( 'adv_vis_ele_enable_default_meta_viewport', '' );
            add_option( 'adv_vis_ele_delete_settings_on_uninstall', '' );
            add_option( 'adv_vis_ele_disable_admin_commands_frontend', '' );
        }
        
        register_setting( 'adv_vis_ele_general_settings', 'adv_vis_ele_global_mobile_breakpoint' );
        register_setting( 'adv_vis_ele_general_settings', 'adv_vis_ele_auto_play_library_videos' );
        register_setting( 'adv_vis_ele_general_settings', 'adv_vis_ele_enable_default_meta_viewport' );
        register_setting( 'adv_vis_ele_general_settings', 'adv_vis_ele_disable_admin_commands_frontend' );
        register_setting( 'adv_vis_ele_general_settings', 'adv_vis_ele_delete_settings_on_uninstall' );
    }
    
    /**
     * Add "Settings" link to the plugin list page
     */
    public function add_plugin_page_links( $links )
    {
        $links[] = '<a href="' . admin_url( 'admin.php?page=adv-vis-ele-settings' ) . '">' . __( 'Settings', 'wp-ave' ) . '</a>';
        return $links;
    }
    
    /**
     * Add editor body classes to stylize editor interface,
     */
    public function add_editor_body_classes( $classes )
    {
        if ( function_exists( 'get_current_screen' ) && get_current_screen() !== null ) {
            if ( Adv_Vis_Ele_Admin::visiting_plugin_pages() ) {
                return $classes . ' adv-vis-ele-admin-editor-interface ';
            }
        }
        return $classes;
    }
    
    /**
     * Keep plugin menu item open in admin menu when editing shortcodes
     */
    public function keep_admin_menu_parent_item_open( $parent_file )
    {
        if ( function_exists( 'get_current_screen' ) && get_current_screen() !== null ) {
            
            if ( get_current_screen()->id === 'adv-vis-element' ) {
                $parent_file = 'adv-vis-ele';
                global  $submenu_file ;
                $submenu_file = 'edit.php?post_type=adv-vis-element';
            }
        
        }
        return $parent_file;
    }
    
    /**
     * Adds preview link to publish meta box
     */
    public function add_links_to_publish_box( $post )
    {
        
        if ( $post->post_type === 'adv-vis-element' ) {
            
            if ( isset( $_GET['element-id'] ) ) {
                // first time editing, redirected from the library
                $element_id = sanitize_text_field( $_GET['element-id'] );
            } else {
                $element_id = get_post_meta( $post->ID, 'adv-vis-ele-element_id', true );
            }
            
            $element_info = $this->library->get_element( $element_id );
            ?>

			<div class="misc-pub-section adv-vis-ele-editor-element-name"><?php 
            echo  __( 'Library element ', 'wp-ave' ) . '<b>' . esc_html( $element_info->name ) . '</b>' ;
            ?></div>

			<div class="misc-pub-section adv-vis-ele-editor-element-duplicate adv-vis-ele-confirm">
				<a href="<?php 
            echo  esc_url( Adv_Vis_Ele_Admin::get_duplicate_link( $post->ID ) ) ;
            ?>"><?php 
            echo  __( 'Duplicate Element', 'wp-ave' ) ;
            ?>
					<i class="fas fa-layer-group"></i></a>
			</div>

			<div class="misc-pub-section adv-vis-ele-shortcode-code">
				<div id="adv-vis-ele-shortcode-code">
					<div>
						<?php 
            _e( 'Shortcode', 'wp-ave' );
            ?>
						<span id="adv-vis-ele-shortcode-code-copy">
							<span title="<?php 
            _e( 'Copy to clipboard', 'wp-ave' );
            ?>"><i class="fas fa-copy"></i></span>
						</span>
					</div>
					<div>
						<code id="adv-vis-ele-shortcode-code-val">[ave-element id=&quot;<?php 
            echo  (int) $post->ID ;
            ?>&quot;]</code>
					</div>
				</div>
			</div>

			<div class="misc-pub-section adv-vis-ele-shortcode-code">
				<div id="adv-vis-ele-shortcode-code-2">
					<div>
						<?php 
            _e( 'PHP code', 'wp-ave' );
            ?>
						<span id="adv-vis-ele-shortcode-code-copy-2">
							<span title="<?php 
            _e( 'Copy to clipboard', 'wp-ave' );
            ?>"><i class="fas fa-copy"></i></span>
						</span>
					</div>
					<code id="adv-vis-ele-shortcode-code-val-2">&lt;?php echo do_shortcode(&#39;[ave-element id=&quot;<?php 
            echo  (int) $post->ID ;
            ?>&quot;]&#39;); ?&gt;</code>
				</div>
			</div>
			
			<?php 
            
            if ( $post->post_status === 'publish' || $post->post_status === 'draft' ) {
                ?>
				<div class="misc-pub-section adv-vis-ele-preview-link">
					<?php 
                
                if ( Adv_Vis_Ele_Admin::is_dev() ) {
                    echo  '<div>' ;
                    echo  '<a target="_blank" href="' . site_url( '?ave-preview-on-front=' . esc_attr( $post->ID ) . '&element-id=' . esc_attr( $element_id ) ) . '">Front end preview (DEV)</a>' ;
                    echo  '</div>' ;
                }
                
                ?>
					<a href="#" target="_blank"><?php 
                _e( 'Quick preview', 'wp-ave' );
                ?>
						<i class="fas fa-sync-alt fa-spin"></i></a>
				</div>
				<?php 
            }
        
        }
    
    }
    
    /**
     * Output shortcode on preview front page
     */
    public function quick_preview()
    {
        if ( current_user_can( 'administrator' ) ) {
            
            if ( isset( $_GET['ave-preview-on-front'] ) && !empty($_GET['ave-preview-on-front']) ) {
                $shortcode_id = (int) $_GET['ave-preview-on-front'];
                
                if ( $shortcode_id > 0 ) {
                    wp_head();
                    $theme = 'light';
                    if ( isset( $_GET['ave-preview-theme'] ) ) {
                        $theme = ( sanitize_text_field( $_GET['ave-preview-theme'] ) === 'dark' ? 'dark' : 'light' );
                    }
                    echo  '<div class="adv-vis-ele-preview-front-container" data-theme="' . esc_attr( $theme ) . '">' . do_shortcode( '[ave-element id="' . $shortcode_id . '" preview=""]' ) . '</div>' ;
                    wp_footer();
                    die;
                }
            
            }
        
        }
    }
    
    /**
     * Adds Viewport Meta Tag
     */
    public function add_viewport_meta_tag()
    {
        echo  '<meta name="viewport" content="width=device-width, initial-scale=1"/>' ;
    }
    
    /**
     * Add Help box to plugin pages
     */
    public function render_help_box()
    {
        $link = ADV_VIS_ELE_PLUGIN_WEBSITE_SHOP;
        ?>
		<div class="adv-vis-ele-help-box">
			<a href="<?php 
        echo  $link ;
        ?>" target="_blank" class="adv-vis-ele-abbr adv-vis-ele-abbr-instructions" data-title="<?php 
        _e( "Element isn't rendering properly or you'd like to add a suggestion for the next library update? Our PRO users can click this link to get support.", 'wp-ave' );
        ?>">?</a>
		</div>
	<?php 
    }
    
    /**
     * Checks if we're the developer
     */
    public static function is_dev()
    {
        return defined( 'ADV_VIS_ELE_DEV' ) && ADV_VIS_ELE_DEV === true;
    }
    
    /**
     * Adds a Developer command dashboard
     */
    public function dev_control_dashboard()
    {
        if ( function_exists( 'get_current_screen' ) && get_current_screen() !== null ) {
            
            if ( Adv_Vis_Ele_Admin::visiting_plugin_pages() ) {
                $url = add_query_arg( [
                    'adv-vis-ele-library-reset' => 'true',
                    'adv-vis-ele-library-dev'   => 'true',
                ] );
                ?>
				<div class="adv-vis-ele-dev-dashboard">
					<h3>WPAVE DEV Dashboard</h3>

					<p>Total elements <b><?php 
                echo  count( $this->library->get_library_info() ) ;
                ?></b></p>

					<a href="<?php 
                echo  esc_url( $url ) ;
                ?>" class="adv-vis-ele-btn">DEV Library</a>

					<a href="<?php 
                echo  esc_url( remove_query_arg( [ 'adv-vis-ele-library-dev' ], $url ) ) ;
                ?>" class="adv-vis-ele-btn adv-vis-ele-dev-dashboard-reset">Reset Library</a>

					<button class="adv-vis-ele-dev-dashboard-toggle"><</button>
				</div>
				<?php 
            }
        
        }
    }

}