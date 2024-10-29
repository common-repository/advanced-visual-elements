<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

class Adv_Vis_Ele_Library
{
    public  $library_info ;
    public static  $dynamic_settings_delimiter_start = '{{' ;
    public static  $dynamic_settings_delimiter_end = '}}' ;
    public static  $dynamic_settings = array(
        'Global'    => array(
        'SITE_TITLE'   => 'Site Title',
        'SITE_TAGLINE' => 'Site Tagline',
        'SITE_URL'     => 'Site URL',
        'CURRENT_DATE' => 'Current date',
        'CURRENT_TIME' => 'Current time',
    ),
        'Post/Page' => array(
        'POST_ID'              => 'Post ID',
        'POST_TITLE'           => 'Post title',
        'POST_CATEGORY'        => 'Post category',
        'POST_FEATURED_IMAGE'  => 'Post Featured image',
        'POST_EXCERPT'         => 'Post excerpt',
        'POST_URL'             => 'Post URL',
        'POST_DATE'            => 'Post date',
        'POST_TIME'            => 'Post time',
        'POST_COMMENTS_NUMBER' => 'Number of comments',
    ),
        'Archive'   => array(
        'ARCHIVE_ID'    => 'Archive ID',
        'ARCHIVE_TITLE' => 'Archive title',
        'ARCHIVE_URL'   => 'Archive URL',
    ),
        'Author'    => array(
        'AUTHOR_ID'           => 'Author ID',
        'AUTHOR_FIRST_NAME'   => 'Author first name',
        'AUTHOR_LAST_NAME'    => 'Author last name',
        'AUTHOR_DISPLAY_NAME' => 'Author display name',
        'AUTHOR_EMAIL'        => 'Author e-mail',
        'AUTHOR_URL'          => 'Author Profile URL',
        'AUTHOR_POSTS_URL'    => 'Author Posts URL',
    ),
    ) ;
    public function __construct()
    {
        if ( isset( $_GET['adv-vis-ele-library-reset'] ) && $_GET['adv-vis-ele-library-reset'] === 'true' ) {
            update_option( 'adv_vis_ele_library_info_v2', [] );
        }
        $library_info = array_filter( get_option( 'adv_vis_ele_library_info_v2', [] ) );
        
        if ( !empty($library_info) ) {
            $this->library_info = $library_info;
        } else {
            $data = [
                'request' => 'elements-json',
            ];
            $response = wp_safe_remote_post( ADV_VIS_ELE_PLUGIN_WEBSITE . '/adv-vis-ele/v2/index.php', [
                'body'    => $data,
                'timeout' => 10,
            ] );
            $output = wp_remote_retrieve_body( $response );
            
            if ( !empty($output) ) {
                $decoded = json_decode( $output );
                if ( is_object( $decoded ) ) {
                    
                    if ( isset( $decoded->response ) && $decoded->response === 'success' && isset( $decoded->data->elements_json ) && !empty($decoded->data->elements_json) ) {
                        
                        if ( Adv_Vis_Ele_Admin::is_dev() && isset( $_GET['adv-vis-ele-library-dev'] ) && $_GET['adv-vis-ele-library-dev'] === 'true' && isset( $decoded->data_dev->elements_json ) && !empty($decoded->data_dev->elements_json) ) {
                            $live_json_ids = array_column( $decoded->data->elements_json, 'id' );
                            $dev_json_ids = array_column( $decoded->data_dev->elements_json, 'id' );
                            foreach ( $dev_json_ids as $did ) {
                                if ( in_array( $did, $live_json_ids ) ) {
                                    foreach ( $decoded->data->elements_json as $kid => $lid ) {
                                        if ( $did === $lid->id ) {
                                            unset( $decoded->data->elements_json[$kid] );
                                        }
                                    }
                                }
                            }
                            $decoded->data->elements_json = array_merge( $decoded->data->elements_json, $decoded->data_dev->elements_json );
                        }
                        
                        $this->library_info = $decoded->data->elements_json;
                        update_option( 'adv_vis_ele_library_info_v2', $decoded->data->elements_json );
                    }
                
                }
            }
        
        }
        
        // WooCommerce dynamic settings array
        if ( class_exists( 'woocommerce' ) ) {
            Adv_Vis_Ele_Library::$dynamic_settings['WooCommerce'] = [
                'WOO_PRODUCT_SKU'               => 'Product SKU',
                'WOO_PRODUCT_IMAGE'             => 'Product image',
                'WOO_PRODUCT_SHORT_DESCRIPTION' => 'Product short description',
                'WOO_PRODUCT_LONG_DESCRIPTION'  => 'Product long description',
                'WOO_PRODUCT_REGULAR_PRICE'     => 'Product regular price',
                'WOO_PRODUCT_SALE_PRICE'        => 'Product sale price',
                'WOO_CURRENCY_SYMBOL'           => 'WooCommerce currency symbol',
                'WOO_PRODUCT_STOCK_STATUS'      => 'Product stock status',
                'WOO_PRODUCT_STOCK_QUANTITY'    => 'Product stock quantity',
                'WOO_PRODUCT_SHIPPING_CLASS'    => 'Product shipping class',
                'WOO_ADD_TO_CART_TEXT'          => 'WooCommerce "Add to cart" text',
            ];
        }
        // Make meta field last array value
        Adv_Vis_Ele_Library::$dynamic_settings['Meta/ACF'] = [
            'META_FIELD' => 'Meta or ACF field',
        ];
    }
    
    /**
     * Get library info
     */
    public function get_library_info( $limit = false, $page = false )
    {
        $library_ordering = get_user_meta( get_current_user_id(), 'adv_vis_ele_library_ordering', true );
        
        if ( empty($library_ordering) ) {
            $library_ordering = 'asc';
            add_user_meta( get_current_user_id(), 'adv_vis_ele_library_ordering', $library_ordering );
        }
        
        
        if ( empty($this->library_info) ) {
            update_option( 'adv_vis_ele_library_info_v2', [] );
            // reset for the next constructor
            return [];
            // should never happen
        }
        
        array_multisort( array_column( $this->library_info, 'name' ), SORT_NATURAL, $this->library_info );
        
        if ( $library_ordering === 'desc' ) {
            $library_info = array_reverse( $this->library_info );
        } else {
            $library_info = $this->library_info;
        }
        
        if ( is_int( $limit ) && is_int( $page ) ) {
            return array_slice( $library_info, $page * $limit - $limit, $limit );
        }
        return $library_info;
    }
    
    /**
     * Get all element IDs
     */
    public function get_all_element_ids()
    {
        $all_elements = [];
        if ( !empty($this->library_info) ) {
            foreach ( $this->library_info as $e ) {
                $all_elements[] = $e->id;
            }
        }
        return $all_elements;
    }
    
    /**
     * Get element info from local library
     */
    public function get_element( $element_id )
    {
        $info = $this->get_library_info();
        $key = array_search( $element_id, array_column( $info, 'id' ) );
        if ( $key === false ) {
            return false;
        }
        if ( is_object( $info[$key] ) ) {
            return $info[$key];
        }
        return false;
    }
    
    /**
     * Get element options from local library
     */
    public function get_element_setting( $element_id, $setting_name )
    {
        $element = $this->get_element( $element_id );
        
        if ( $element ) {
            $key = array_search( $setting_name, array_column( $element->settings, 'id' ) );
            if ( $key !== false ) {
                return $element->settings[$key];
            }
        }
        
        return false;
    }
    
    /**
     * Get elements HTML
     */
    public function get_element_html( $element )
    {
        ob_start();
        ?>
		<div class="adv-vis-ele-library-element <?php 
        echo  ( $element->new_element === true ? 'adv-vis-ele-library-element-new' : '' ) ;
        ?>" data-id="<?php 
        echo  esc_attr( $element->id ) ;
        ?>" data-license="<?php 
        echo  esc_attr( $element->license ) ;
        ?>">
			<h6><?php 
        echo  esc_attr( $element->name ) ;
        ?></h6>
			<div class="adv-vis-ele-library-video">
				<span class="adv-vis-ele-video-label">
					<?php 
        _e( 'Preview', 'wp-ave' );
        ?>
					<i class="fas fa-eye"></i>
				</span>
				<span class="adv-vis-ele-span-fullscreen" id="adv-vis-ele-span-fullscreen-<?php 
        echo  esc_attr( $element->video_id ) ;
        ?>">
					<?php 
        _e( 'Fullscreen', 'wp-ave' );
        ?>
					<i class="fas fa-window-restore"></i>
				</span>
				<?php 
        $web_preview_url = ADV_VIS_ELE_PLUGIN_WEBSITE . '/element-preview/' . $element->id . '/';
        ?>
				<span class="adv-vis-ele-span-web-preview" id="adv-vis-ele-span-web-preview-<?php 
        echo  esc_attr( $element->video_id ) ;
        ?>" data-web-preview-url="<?php 
        echo  esc_url( $web_preview_url ) ;
        ?>">
					<?php 
        _e( 'Web preview', 'wp-ave' );
        ?>
					<i class="fas fa-code"></i>
				</span>
				<?php 
        $settings_string = '';
        if ( !empty($element->settings) && is_array( $element->settings ) ) {
            foreach ( $element->settings as $setting ) {
                $settings_string .= '<div class="adv-vis-ele-settings-popup-single-setting">';
                $mobile_string = '';
                if ( isset( $setting->mobile ) && $setting->mobile === true ) {
                    $mobile_string .= ' ' . __( '(mobile)', 'wp-ave' );
                }
                
                if ( $element->license !== 'free' ) {
                    $settings_string .= '<span>' . esc_attr( $setting->name . $mobile_string ) . '</span>' . '<span class="adv-vis-ele-settings-popup-single-setting-pro">PRO</span>';
                } else {
                    $settings_string .= '<span>' . esc_attr( $setting->name . $mobile_string ) . '</span>' . '<span class"' . (( $setting->license === 'free' ? '' : 'adv-vis-ele-settings-popup-single-setting-pro' )) . '">' . (( $setting->license === 'free' ? 'Free' : 'PRO' )) . '</span>';
                }
                
                $settings_string .= '</div>';
            }
        }
        if ( empty($settings_string) ) {
            $settings_string = __( 'No options listed.', 'wp-ave' );
        }
        ?>
				<span class="adv-vis-ele-span-settings adv-vis-ele-abbr">
					<?php 
        _e( 'Options', 'adv-vis-ele' );
        ?>
					<i class="fas fa-cogs"></i>
					<span class="adv-vis-ele-abbr-tippy-content"><?php 
        echo  wp_kses_post( $settings_string ) ;
        ?></span>
				</span>

				<div class="adv-vis-ele-library-video-wrap">
					<?php 
        
        if ( get_option( 'adv_vis_ele_auto_play_library_videos' ) == 'on' ) {
            ?>
						<div id="adv-vis-ele-video-id-<?php 
            echo  esc_attr( $element->video_id ) ;
            ?>" class="adv-vis-ele-api-video adv-vis-ele-api-video-not-started" data-src="<?php 
            echo  esc_attr( $element->video_id ) ;
            ?>"></div>
					<?php 
        } else {
            ?>
						<img class="adv-vis-ele-api-thumbnail" src="https://img.youtube.com/vi/<?php 
            echo  esc_attr( $element->video_id ) ;
            ?>/maxresdefault.jpg" alt="<?php 
            echo  esc_attr( $element->name ) ;
            ?>">
					<?php 
        }
        
        
        if ( $element->license != 'free' ) {
            ?>
						<div class="adv-vis-ele-pro-ribbon <?php 
            echo  ( wpave_fs()->is__premium_only() ? 'adv-vis-ele-pro-ribbon-inverted' : '' ) ;
            ?>">
							<span><?php 
            echo  ( wpave_fs()->is__premium_only() ? 'PRO' : '<a target="_blank" href="' . esc_url( ADV_VIS_ELE_PLUGIN_WEBSITE_SHOP ) . '">PRO</a>' ) ;
            ?></span>
						</div>
					<?php 
        }
        
        ?>
				</div>
			</div>
			<?php 
        
        if ( isset( $element->performance_heavy ) && $element->performance_heavy === true ) {
            ?>
				<span class="adv-vis-ele-performance-heavy">
					<span class="adv-vis-ele-abbr" data-title="<?php 
            _e( 'This Element could impact website performance.', 'adv-vis-ele' );
            ?>">!</span>
				</span>
			<?php 
        }
        
        
        if ( $element->license !== 'free' && !wpave_fs()->is__premium_only() ) {
            ?>
				<button onclick="window.open('<?php 
            echo  admin_url( 'admin.php?page=adv-vis-ele-pricing' ) ;
            ?>');" class="adv-vis-ele-btn">
					<?php 
            _e( 'Buy PRO', 'adv-vis-ele' );
            ?>
					<i class="fas fa-cart-arrow-down"></i>
				</button>
			<?php 
        } else {
            ?>
				<button class="adv-vis-ele-btn adv-vis-ele-use-btn">
					<?php 
            _e( 'Create', 'adv-vis-ele' );
            ?>
					<i class="fas fa-arrow-right"></i>
				</button>
			<?php 
        }
        
        ?>
		</div>
		<?php 
        return ob_get_clean();
    }
    
    /**
     * Load more elements (AJAX)
     */
    public function ajax_load_more_elements()
    {
        $page = (int) $_POST['page'];
        $limit = (int) $_POST['limit'];
        $search = sanitize_text_field( $_POST['search'] );
        
        if ( !empty($search) ) {
            $elements = $this->get_library_info();
        } else {
            $elements = $this->get_library_info( $limit, $page );
        }
        
        $filtered_elements = [];
        
        if ( !empty($search) ) {
            foreach ( $elements as $element ) {
                if ( stristr( $element->name, $search ) !== false || stristr( $element->id, $search ) !== false ) {
                    $filtered_elements[] = $element;
                }
            }
            $elements = array_slice( $filtered_elements, $page * $limit - $limit, $limit );
            
            if ( empty($elements) ) {
                $r = [
                    'message' => 'No search results.',
                ];
                $r['hide'] = true;
                wp_send_json_error( $r );
            }
        
        } else {
            
            if ( empty($elements) ) {
                $r = [
                    'message' => 'Loaded all elements.',
                ];
                $r['hide'] = true;
                wp_send_json_error( $r );
            }
        
        }
        
        $html = '';
        foreach ( $elements as $element ) {
            $element->new_element = in_array( $element->id, ADV_VIS_ELE_NEW_ELEMENTS );
            $html .= $this->get_element_html( $element );
        }
        $r = [
            'message' => wp_kses_post( $html ),
        ];
        
        if ( !empty($search) ) {
            
            if ( count( $filtered_elements ) > $page * $limit ) {
                $r['hide'] = false;
            } else {
                $r['hide'] = true;
            }
        
        } else {
            
            if ( count( $this->library_info ) > $page * $limit ) {
                $r['hide'] = false;
            } else {
                $r['hide'] = true;
            }
        
        }
        
        wp_send_json_success( $r );
    }
    
    /**
     * Render setting field
     */
    public function render_setting_field( $setting )
    {
        ob_start();
        echo  '<label for="' . esc_attr( $setting->id ) . '">' . esc_html( $setting->name ) ;
        if ( $setting->type === 'select' ) {
            if ( isset( $setting->multiple ) && $setting->multiple ) {
                echo  '<span class="adv-vis-ele-abbr adv-vis-ele-abbr-select-multiple" data-title="' . __( 'Hold CTRL/CMD keyboard key to select multiple options.' ) . '">?</span>' ;
            }
        }
        if ( $setting->type === 'content' ) {
            echo  '<span class="adv-vis-ele-abbr adv-vis-ele-abbr-content" data-title="' . __( 'Shortcodes supported inside this field. You should explicitly declare styling for elements in this field as it can be easily overwritten by your active theme or plugin CSS.', 'adv-vis-ele' ) . '">?</span>' ;
        }
        
        if ( !empty($setting->instructions) ) {
            echo  '<span class="adv-vis-ele-abbr adv-vis-ele-abbr-instructions" data-title="' . __( $setting->instructions, 'adv-vis-ele' ) . '">?</span>' ;
        } else {
            if ( $setting->type === 'video' ) {
                echo  '<span class="adv-vis-ele-abbr adv-vis-ele-abbr-instructions" data-title="' . __( 'Choose your video carefully, if not optimized - videos can slow page load and cause bad user experience. YouTube and Vimeo videos are supported.', 'adv-vis-ele' ) . '">?</span>' ;
            }
        }
        
        if ( isset( $setting->mobile ) && $setting->mobile === true ) {
            echo  '<i class="far fa-mobile-alt adv-vis-ele-abbr" data-title="' . __( 'This option is intended for mobile devices.' ) . '"></i>' ;
        }
        echo  '</label>' ;
        
        if ( $setting->type === 'color' ) {
            $color_format = ( $setting->format === 'rgba' ? ' data-alpha-enabled="true"' : '' );
            echo  '<input id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" type="text" value="' . esc_attr( $setting->value ) . '" data-default-color="' . esc_attr( $setting->default ) . '" class="color-field" data-format="' . esc_attr( $setting->format ) . '"' . esc_attr( $color_format ) . '/>' ;
        } else {
            
            if ( $setting->type === 'text' ) {
                echo  '<input id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" type="text" value="' . esc_attr( $setting->value ) . '"/>' ;
            } else {
                
                if ( $setting->type === 'number' ) {
                    $min = '';
                    $max = '';
                    if ( isset( $setting->min ) ) {
                        $min = 'min="' . esc_attr( $setting->min ) . '"';
                    }
                    if ( isset( $setting->max ) ) {
                        $max = 'max="' . esc_attr( $setting->max ) . '"';
                    }
                    echo  '<input id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" type="number" value="' . esc_attr( $setting->value ) . '" ' . $min . ' ' . $max . ' step="1"/>' ;
                } else {
                    
                    if ( $setting->type === 'float' ) {
                        $min = '';
                        $max = '';
                        if ( isset( $setting->min ) ) {
                            $min = 'min="' . esc_attr( $setting->min ) . '"';
                        }
                        if ( isset( $setting->max ) ) {
                            $max = 'max="' . esc_attr( $setting->max ) . '"';
                        }
                        $step = '0.1';
                        if ( isset( $setting->step ) ) {
                            $step = $setting->step;
                        }
                        echo  '<input id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" type="number" step="' . esc_attr( $step ) . '" value="' . esc_attr( $setting->value ) . '" ' . $min . ' ' . $max . '/>' ;
                    } else {
                        
                        if ( $setting->type === 'select' ) {
                            
                            if ( isset( $setting->multiple ) && $setting->multiple ) {
                                $size = Adv_Vis_Ele_Helpers::clamp( count( $setting->options ), 1, 10 );
                                echo  '<select id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . '][]" multiple size="' . esc_attr( $size ) . '">' ;
                                foreach ( $setting->options as $option ) {
                                    
                                    if ( isset( $option->label ) ) {
                                        $label = $option->label;
                                    } else {
                                        $label = ucfirst( $option->value );
                                    }
                                    
                                    $selected_flag = false;
                                    
                                    if ( is_array( $setting->value ) ) {
                                        if ( in_array( $option->value, $setting->value ) ) {
                                            $selected_flag = true;
                                        }
                                    } else {
                                        if ( $option->value == $setting->value ) {
                                            $selected_flag = true;
                                        }
                                    }
                                    
                                    echo  '<option value="' . esc_attr( $option->value ) . '" ' . selected( $selected_flag ) . '>' . esc_attr( $label ) . '</option>' ;
                                }
                                echo  '</select>' ;
                            } else {
                                echo  '<select id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']">' ;
                                foreach ( $setting->options as $option ) {
                                    
                                    if ( isset( $option->label ) ) {
                                        $label = $option->label;
                                    } else {
                                        $label = ucfirst( $option->value );
                                    }
                                    
                                    $selected_flag = false;
                                    if ( $option->value == $setting->value ) {
                                        $selected_flag = true;
                                    }
                                    echo  '<option value="' . esc_attr( $option->value ) . '" ' . selected( $selected_flag ) . '>' . esc_html( $label ) . '</option>' ;
                                }
                                echo  '</select>' ;
                            }
                        
                        } else {
                            
                            if ( $setting->type === 'boolean' ) {
                                echo  '<label class="adv-vis-ele-switch-input" for="' . esc_attr( $setting->id ) . '">' ;
                                echo  '<input id="' . esc_attr( $setting->id ) . '" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" type="checkbox" ' . checked( $setting->value, true, false ) . '/>' ;
                                echo  '<span class="adv-vis-ele-slider-input"></span>' ;
                                echo  '</label>' ;
                                // this is needed to submit FALSE value
                                echo  '<input id="' . esc_attr( $setting->id ) . '-bool" name="adv-vis-ele-editor-settings-bool[' . esc_attr( $setting->id ) . ']" type="hidden" value="0"/>' ;
                            } else {
                                
                                if ( $setting->type === 'content' ) {
                                    wp_editor( wp_kses_post( wpautop( $setting->value ) ), esc_attr( $setting->id ), [
                                        'wpautop'       => false,
                                        'textarea_name' => 'adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']',
                                        'editor_height' => 150,
                                    ] );
                                } else {
                                    
                                    if ( $setting->type === 'image' ) {
                                        echo  '<input type="text" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" id="' . esc_attr( $setting->id ) . '" value="' . esc_attr( $setting->value ) . '"/>' ;
                                        echo  '<a href="#" class="button " data-editor="' . esc_attr( $setting->id ) . '">' . __( 'Choose Image', 'adv-vis-ele' ) . '</a>' ;
                                    } else {
                                        
                                        if ( $setting->type === 'video' ) {
                                            echo  '<input type="text" name="adv-vis-ele-editor-settings[' . esc_attr( $setting->id ) . ']" id="' . esc_attr( $setting->id ) . '" value="' . esc_attr( $setting->value ) . '"/>' ;
                                            echo  '<a href="#" class="button " data-editor="' . esc_attr( $setting->id ) . '">' . __( 'Choose Video', 'adv-vis-ele' ) . '</a>' ;
                                        }
                                    
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                
                }
            
            }
        
        }
        
        // dynamic post values
        if ( $setting->type === 'text' || $setting->type === 'content' || $setting->type === 'image' ) {
            echo  '<a class="adv-vis-ele-setting-dynamic-add adv-vis-ele-abbr" data-title="' . __( 'Insert a dynamic value that will be fetched on-the-fly, such as post or archive ID, title, category, author name, a WooCommerce product image etc. This is a PRO feature.', 'adv-vis-ele' ) . '" data-type="' . esc_attr( $setting->type ) . '"><i class="fas fa-plus"></i></a>' ;
        }
        return ob_get_clean();
    }
    
    /**
     * Save library ordering (AJAX)
     */
    public function ajax_save_ordering()
    {
        $nonce_verified = isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ave_ajax' );
        if ( !$nonce_verified ) {
            wp_send_json_error( [
                'code' => '010',
            ] );
        }
        $ordering = sanitize_text_field( $_POST['ordering'] );
        update_user_meta( get_current_user_id(), 'adv_vis_ele_library_ordering', $ordering );
        wp_send_json_success();
    }
    
    /**
     * Full import (AJAX)
     */
    public function ajax_full_import()
    {
        $nonce_verified = isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ave_ajax' );
        if ( !$nonce_verified ) {
            wp_send_json_error( [
                'code' => '010',
            ] );
        }
        $current_user = wp_get_current_user();
        $author = $current_user->ID;
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
        
        if ( !empty($settings) ) {
            $element_id = $settings['adv-vis-ele-element_id'];
            unset( $settings['adv-vis-ele-element_id'] );
            // remove the Element ID because we want only settings
            $post = [
                'post_title'  => 'Imported Element (' . $element_id . ')',
                'post_status' => 'draft',
                'post_type'   => 'adv-vis-element',
                'post_author' => $author,
            ];
            $new_post_id = wp_insert_post( $post );
            
            if ( is_int( $new_post_id ) && $new_post_id > 0 ) {
                add_post_meta( $new_post_id, 'adv-vis-ele-element_id', $element_id );
                $saving = $this->get_saving_settings( $settings, $element_id );
                Adv_Vis_Ele_Admin::save_element_meta_settings( $saving, $new_post_id );
                $redirection_url = admin_url() . 'post.php?post=' . $new_post_id . '&action=edit';
                wp_send_json_success( [
                    'redirection_url' => $redirection_url,
                ] );
            }
        
        }
        
        wp_send_json_error();
    }
    
    /**
     * Get Element options for saving
     */
    public function get_saving_settings( $settings, $element_id )
    {
        $saving = [];
        foreach ( $settings as $setting_name => $setting_value ) {
            $setting = $this->get_element_setting( $element_id, $setting_name );
            if ( $setting ) {
                
                if ( $setting->license !== 'free' ) {
                    $saving[$setting_name] = $setting->default;
                } else {
                    $saving[$setting_name] = Adv_Vis_Ele_Admin::filter_setting( $setting, $setting_value );
                }
            
            }
        }
        return $saving;
    }
    
    /**
     * Quick save preview (AJAX)
     */
    public function ajax_quick_save()
    {
        $nonce_verified = isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ave_ajax' );
        if ( !$nonce_verified ) {
            wp_send_json_error( [
                'code' => '010',
            ] );
        }
        if ( !isset( $_POST['id'] ) ) {
            return;
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
        
        }
        $meta_settings = Adv_Vis_Ele_Admin::get_element_meta_settings( $post_id, true );
        
        if ( !empty($meta_settings) ) {
            foreach ( $settings as $name => $setting ) {
                if ( in_array( $name, array_keys( $meta_settings ) ) ) {
                    $meta_settings[$name] = $setting;
                }
            }
        } else {
            $meta_settings = $settings;
        }
        
        $saving = $this->get_saving_settings( $meta_settings, $element_id );
        Adv_Vis_Ele_Admin::save_element_meta_settings( $saving, $post_id, true );
        $saving['adv-vis-ele-element_id'] = $element_id;
        wp_send_json_success( [
            'export' => json_encode( $saving ),
        ] );
    }

}