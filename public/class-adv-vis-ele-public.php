<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

class Adv_Vis_Ele_Public
{
    private  $plugin_name, $version, $library ;
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->library = new Adv_Vis_Ele_Library();
        $this->add_shortcodes();
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        if ( !wp_style_is( $this->plugin_name . '-public' ) ) {
            wp_enqueue_style(
                $this->plugin_name . '-public',
                plugin_dir_url( __FILE__ ) . 'css/adv-vis-ele-public.css',
                [],
                $this->version,
                'all'
            );
        }
        foreach ( $this->library->get_all_element_ids() as $element_id ) {
            $element = $this->library->get_element( $element_id );
            if ( !empty($element->files) ) {
                foreach ( $element->files as $file ) {
                    
                    if ( $file->type === 'css' ) {
                        $dependencies = [];
                        if ( !empty($file->wp_dependencies) ) {
                            $dependencies = $file->wp_dependencies;
                        }
                        $script_slug = 'ave-' . $element_id . '-' . $file->slug;
                        wp_register_style(
                            $script_slug,
                            ADV_VIS_ELE_ELEMENTS_URL . '/' . $element_id . '/' . $file->file,
                            $dependencies,
                            ADV_VIS_ELE_PLUGIN_URL,
                            'all'
                        );
                    }
                
                }
            }
        }
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts()
    {
        if ( !wp_script_is( $this->plugin_name . '-public' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-public',
                plugin_dir_url( __FILE__ ) . 'js/adv-vis-ele-public.js',
                [ 'jquery' ],
                $this->version,
                false
            );
        }
        foreach ( $this->library->get_all_element_ids() as $element_id ) {
            $element = $this->library->get_element( $element_id );
            if ( !empty($element->files) ) {
                foreach ( $element->files as $file ) {
                    
                    if ( $file->type === 'js' ) {
                        $dependencies = [];
                        if ( !empty($file->wp_dependencies) ) {
                            $dependencies = $file->wp_dependencies;
                        }
                        $script_slug = 'ave-' . $element_id . '-' . $file->slug;
                        wp_register_script(
                            $script_slug,
                            ADV_VIS_ELE_ELEMENTS_URL . '/' . $element_id . '/' . $file->file,
                            $dependencies,
                            ADV_VIS_ELE_VERSION,
                            true
                        );
                    }
                
                }
            }
        }
    }
    
    /**
     * Add shortcodes for rendering element shortcodes
     *
     */
    public function add_shortcodes()
    {
        if ( !shortcode_exists( 'ave-element' ) ) {
            add_shortcode( 'ave-element', [ $this, 'output_shortcode' ] );
        }
    }
    
    /**
     * Enqueue all element scripts
     */
    public function enqueue_element_scripts( $element_ids = array() )
    {
        $js_dependencies = [];
        if ( empty($element_ids) ) {
            $element_ids = $this->library->get_all_element_ids();
        }
        foreach ( $element_ids as $element_id ) {
            $element = $this->library->get_element( $element_id );
            if ( !empty($element->files) ) {
                foreach ( $element->files as $file ) {
                    
                    if ( $file->type === 'js' ) {
                        $dependencies = [];
                        if ( !empty($file->wp_dependencies) ) {
                            $dependencies = $file->wp_dependencies;
                        }
                        $script_slug = 'ave-' . $element_id . '-' . $file->slug;
                        
                        if ( !wp_script_is( $script_slug ) ) {
                            wp_enqueue_script(
                                $script_slug,
                                ADV_VIS_ELE_ELEMENTS_URL . '/' . $element_id . '/' . $file->file,
                                $dependencies,
                                ADV_VIS_ELE_VERSION,
                                true
                            );
                            $js_dependencies[] = $script_slug;
                        }
                    
                    }
                    
                    
                    if ( $file->type === 'css' ) {
                        $dependencies = [];
                        if ( !empty($file->wp_dependencies) ) {
                            $dependencies = $file->wp_dependencies;
                        }
                        $script_slug = 'ave-' . $element_id . '-' . $file->slug;
                        if ( !wp_style_is( $script_slug ) ) {
                            wp_enqueue_style(
                                $script_slug,
                                ADV_VIS_ELE_ELEMENTS_URL . '/' . $element_id . '/' . $file->file,
                                $dependencies,
                                ADV_VIS_ELE_PLUGIN_URL,
                                'all'
                            );
                        }
                    }
                
                }
            }
        }
        return $js_dependencies;
    }
    
    /**
     * Main shortcode for displaying elements
     */
    public function output_shortcode( $atts )
    {
        if ( empty($atts['id']) ) {
            return '';
        }
        $post_id = (int) $atts['id'];
        // for use in shortcode.php
        if ( $post_id === false ) {
            return '';
        }
        $do_not_render = apply_filters( 'ave_filter_render_flag', $post_id );
        if ( $do_not_render === false ) {
            return '';
        }
        $element_post = get_post( $post_id );
        if ( is_null( $element_post ) ) {
            return '';
        }
        if ( $element_post->post_type !== 'adv-vis-element' ) {
            return '';
        }
        if ( !current_user_can( 'administrator' ) && $element_post->post_status !== 'publish' ) {
            return '';
        }
        if ( !empty($element_post->post_password) ) {
            return '';
        }
        if ( $element_post->post_status === 'trash' ) {
            return '';
        }
        $disable_on_mobile = get_post_meta( $post_id, 'adv-vis-ele-disable_on_mobile', true );
        if ( $disable_on_mobile && wp_is_mobile() ) {
            return '';
        }
        $element_id = get_post_meta( $post_id, 'adv-vis-ele-element_id', true );
        $element_id = sanitize_text_field( $element_id );
        if ( empty($element_id) && !current_user_can( 'administrator' ) ) {
            return '';
        }
        // if it's the first time editing element, so it's not saved yet - construct the preview from default settings
        if ( $element_post->post_status === 'auto-draft' ) {
            
            if ( isset( $_GET['element-id'] ) ) {
                $element_id = sanitize_text_field( $_GET['element-id'] );
            } else {
                if ( !current_user_can( 'administrator' ) ) {
                    return '';
                }
            }
        
        }
        $element = $this->library->get_element( $element_id );
        if ( !current_user_can( 'administrator' ) && $element->license !== 'free' && !wpave_fs()->can_use_premium_code() ) {
            return '';
        }
        // get element settings and cast them to object - they are used in the include file
        $meta_settings = Adv_Vis_Ele_Admin::get_element_meta_settings( $post_id, isset( $_GET['ave-preview-settings'] ) );
        // insert dynamic post settings, do not do it if in quick preview
        foreach ( $element->settings as $element_setting ) {
            if ( empty($meta_settings[$element_setting->id]) ) {
                continue;
            }
            if ( $element_setting->type !== 'text' && $element_setting->type !== 'content' && $element_setting->type !== 'image' ) {
                continue;
            }
            
            if ( strpos( $meta_settings[$element_setting->id], Adv_Vis_Ele_Library::$dynamic_settings_delimiter_start ) !== false ) {
                preg_match_all( '/' . Adv_Vis_Ele_Library::$dynamic_settings_delimiter_start . '(\\S*?)' . Adv_Vis_Ele_Library::$dynamic_settings_delimiter_end . '/', $meta_settings[$element_setting->id], $dynamic_settings_found );
                if ( !empty($dynamic_settings_found[0]) && !empty($dynamic_settings_found[1]) ) {
                    foreach ( $dynamic_settings_found[0] as $k => $dynamic_setting ) {
                        
                        if ( !isset( $_GET['ave-preview-on-front'] ) ) {
                            $replacement_setting = '';
                        } else {
                            $replacement_setting = $dynamic_settings_found[1][$k];
                            $meta_settings[$element_setting->id] = str_replace( $dynamic_setting, $replacement_setting, $meta_settings[$element_setting->id] );
                            continue;
                        }
                        
                        $replacement_setting = '';
                        $meta_settings[$element_setting->id] = str_replace( $dynamic_setting, $replacement_setting, $meta_settings[$element_setting->id] );
                    }
                }
            }
        
        }
        $settings_clean = [];
        // reserved variables
        $settings_clean['post_id'] = absint( $post_id );
        $settings_clean['element_id'] = $element_id;
        $settings_clean['element_path'] = ADV_VIS_ELE_ELEMENTS_DIR . DIRECTORY_SEPARATOR . $element_id;
        $settings_clean['mobile_breakpoint'] = absint( get_option( 'adv_vis_ele_global_mobile_breakpoint', ADV_VIS_ELE_GLOBAL_MOBILE_BREAKPOINT ) );
        $meta_mobile_breakpoint = absint( get_post_meta( $post_id, 'adv-vis-ele-mobile_breakpoint', true ) );
        
        if ( !empty($meta_mobile_breakpoint) ) {
            $filtered_mobile_breakpoint = absint( $meta_mobile_breakpoint );
            if ( !empty($filtered_mobile_breakpoint) ) {
                $settings_clean['mobile_breakpoint'] = $filtered_mobile_breakpoint;
            }
        }
        
        foreach ( $element->settings as $element_setting ) {
            
            if ( $element_setting->type === 'boolean' ) {
                
                if ( isset( $meta_settings[$element_setting->id] ) && is_bool( $meta_settings[$element_setting->id] ) ) {
                    $settings_clean[$element_setting->id] = $meta_settings[$element_setting->id];
                } else {
                    if ( isset( $element_setting->default ) && is_bool( $element_setting->default ) ) {
                        $settings_clean[$element_setting->id] = $element_setting->default;
                    }
                }
            
            } else {
                
                if ( isset( $meta_settings[$element_setting->id] ) ) {
                    $settings_clean[$element_setting->id] = $meta_settings[$element_setting->id];
                } else {
                    
                    if ( !empty($element_setting->default) ) {
                        $settings_clean[$element_setting->id] = $element_setting->default;
                    } else {
                        $settings_clean[$element_setting->id] = '';
                        // populate this so we don't get "undefined index errors" etc.
                    }
                
                }
            
            }
            
            // escape all of the settings
            
            if ( $element_setting->type === 'text' ) {
                $settings_clean[$element_setting->id] = esc_html( $settings_clean[$element_setting->id] );
            } else {
                
                if ( $element_setting->type === 'color' ) {
                    $settings_clean[$element_setting->id] = esc_attr( $settings_clean[$element_setting->id] );
                } else {
                    
                    if ( $element_setting->type === 'content' ) {
                        $settings_clean[$element_setting->id] = wp_kses_post( nl2br( $settings_clean[$element_setting->id] ) );
                    } else {
                        
                        if ( $element_setting->type === 'number' ) {
                            $settings_clean[$element_setting->id] = (int) $settings_clean[$element_setting->id];
                        } else {
                            
                            if ( $element_setting->type === 'float' ) {
                                $settings_clean[$element_setting->id] = (double) $settings_clean[$element_setting->id];
                            } else {
                                
                                if ( $element_setting->type === 'image' || $element_setting->type === 'video' ) {
                                    $settings_clean[$element_setting->id] = esc_url( $settings_clean[$element_setting->id] );
                                } else {
                                    
                                    if ( $element_setting->type === 'select' ) {
                                        if ( is_array( $settings_clean[$element_setting->id] ) ) {
                                            foreach ( $settings_clean[$element_setting->id] as $setting ) {
                                                if ( !in_array( $setting, array_column( $element_setting->options, 'value' ) ) ) {
                                                    $settings_clean[$element_setting->id] = '';
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $element_setting->type === 'boolean' ) {
                                            $settings_clean[$element_setting->id] = (bool) $settings_clean[$element_setting->id];
                                        }
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                
                }
            
            }
        
        }
        // enqueue all element scripts and get back all their slugs to act as dependencies for the main script.js file
        $js_element_dependencies = $this->enqueue_element_scripts( [ $element_id ] );
        $encoded_element_settings = json_encode( $settings_clean );
        
        if ( $encoded_element_settings ) {
            $script_code = 'if(typeof ave_element_settings == "undefined") {var ave_element_settings = {}}; ave_element_settings["' . (int) $post_id . '"] = ' . $encoded_element_settings . ';';
        } else {
            if ( current_user_can( 'administrator' ) ) {
                return __( 'There was a problem with parsing/encoding Element settings. This message is visible to administrators only.' );
            }
            return '';
        }
        
        
        if ( file_exists( ADV_VIS_ELE_ELEMENTS_DIR . DIRECTORY_SEPARATOR . $element_id . '/script.js' ) && !wp_script_is( 'ave-' . $element_id ) ) {
            $merged_js_dependencies = array_merge( $element->js_dependencies, $js_element_dependencies );
            wp_enqueue_script(
                'ave-' . $element_id,
                ADV_VIS_ELE_ELEMENTS_URL . '/' . $element_id . '/script.js',
                $merged_js_dependencies,
                $this->version,
                true
            );
        }
        
        if ( isset( $script_code ) && wp_script_is( 'ave-' . $element_id ) ) {
            wp_add_inline_script( 'ave-' . $element_id, $script_code, 'before' );
        }
        $shortcode_file = ADV_VIS_ELE_ELEMENTS_DIR . DIRECTORY_SEPARATOR . $element->id . DIRECTORY_SEPARATOR . 'shortcode.php';
        
        if ( !file_exists( realpath( $shortcode_file ) ) ) {
            if ( current_user_can( 'administrator' ) ) {
                return '<div class="adv-vis-ele-this-element-needs-install"><a href="' . admin_url( 'admin.php?page=adv-vis-ele' ) . '">' . __( 'This element will not render - critical element files missing, click here to go to library to re-install it. This message is visible to administrators only.' ) . '</a></div>';
            }
            return '';
        }
        
        do_action( 'ave_action_before_element', $post_id, $element_id );
        // begin shortcode output
        ob_start();
        $output = '';
        $custom_css = get_post_meta( $post_id, 'adv-vis-ele-custom_css', true );
        
        if ( !empty($custom_css) ) {
            $custom_css_slug = 'ave-custom-inline-css-' . (int) $post_id;
            wp_register_style( $custom_css_slug, false );
            wp_enqueue_style( $custom_css_slug );
            wp_add_inline_style( $custom_css_slug, strip_tags( $custom_css ) );
        }
        
        $container_styles_out = '';
        $container_styles_width = get_post_meta( $post_id, 'adv-vis-ele-container_styles', true );
        $container_styles_vertical = get_post_meta( $post_id, 'adv-vis-ele-container_styles_vertical', true );
        if ( !empty($container_styles_width) ) {
            
            if ( substr( $container_styles_width, 0, 4 ) === 'flex' || $container_styles_width === 'center' ) {
                $container_styles_out .= 'display: flex; justify-content: ' . $container_styles_width . ';';
                if ( !empty($container_styles_vertical) ) {
                    $container_styles_out .= ' align-items: ' . $container_styles_vertical . ';';
                }
            } else {
                $container_styles_out .= 'display: ' . $container_styles_width . ';';
            }
        
        }
        $output .= '<div id="adv-vis-ele-shortcode-' . esc_attr( $element_id ) . '-' . (int) $post_id . '" data-post-id="' . (int) $post_id . '" data-mobile-breakpoint="' . esc_attr( $settings_clean['mobile_breakpoint'] ) . '" class="adv-vis-ele-shortcode-render-container" style="' . esc_attr( $container_styles_out ) . '">';
        $output .= '<div class="adv-vis-ele-shortcode-render-container-inner">';
        global  $pagenow ;
        
        if ( get_option( 'adv_vis_ele_disable_admin_commands_frontend' ) != 'on' && current_user_can( 'administrator' ) && ($pagenow != 'post.php' && $pagenow != 'post-new.php') ) {
            $output .= '<div class="adv-vis-ele-shortcode-render-admin-commands">';
            if ( !isset( $_GET['ave-preview-on-front'] ) ) {
                $output .= '<a class="adv-vis-ele-btn" href="' . esc_url( get_edit_post_link( $post_id ) ) . '" target="_blank">' . __( 'Edit Element', 'wp-ave' ) . '</a>';
            }
            $output .= '</div>';
            // .adv-vis-ele-shortcode-render-admin-commands
            if ( $element_post->post_status !== 'publish' && !isset( $_GET['ave-preview-on-front'] ) ) {
                $output .= '<span class="adv-vis-ele-shortcode-draft-notice">' . __( 'This render is only visible to admins. Publish this element to show it to all site visitors.', 'wp-ave' ) . '</span>';
            }
            if ( $element->license !== 'free' && !wpave_fs()->can_use_premium_code() ) {
                $output .= '<span class="adv-vis-ele-shortcode-license-notice">' . __( 'This render is only visible to admins. This element requires PRO license in order for it to render for all site visitors.', 'wp-ave' ) . '</span>';
            }
        }
        
        $settings = $settings_clean;
        unset( $settings_clean );
        include $shortcode_file;
        $output .= ob_get_clean();
        $output .= '</div>';
        // .adv-vis-ele-shortcode-render-container-inner
        $output .= '</div>';
        // .adv-vis-ele-shortcode-render-container
        ob_start();
        do_action( 'ave_action_after_element' . $post_id, $element_id );
        $after = ob_get_clean();
        return $output . $after;
    }

}