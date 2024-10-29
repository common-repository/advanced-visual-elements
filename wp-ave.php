<?php

/**
 *
 * @link              https://www.upwork.com/freelancers/~0145929f1d88e4c19e
 * @package           Adv_Vis_Ele
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Visual Elements
 * Plugin URI:        https://www.wp-ave.com
 * Description:       A collection of addons you can't find in standard builders - customize and display visuals to spice up your website's looks!
 * Version:           2.0.4
 * Author:            wp-ave.com
 * Author URI:        https://wp-ave.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-ave
 * Domain Path:       /languages
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}


if ( function_exists( 'wpave_fs' ) ) {
    wpave_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'wpave_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wpave_fs()
        {
            global  $wpave_fs ;
            
            if ( !isset( $wpave_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wpave_fs = fs_dynamic_init( [
                    'id'             => '10740',
                    'slug'           => 'wp-ave',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_eda0c13c26d0d74ec76b2b6ecd171',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => [
                    'slug'    => 'adv-vis-ele',
                    'contact' => false,
                    'support' => false,
                ],
                    'is_live'        => true,
                ] );
            }
            
            return $wpave_fs;
        }
        
        // Init Freemius.
        wpave_fs();
        // Signal that SDK was initiated.
        do_action( 'wpave_fs_loaded' );
    }
    
    /**
     * Plugin constants
     */
    define( 'ADV_VIS_ELE_VERSION', '2.0.4' );
    define( 'ADV_VIS_ELE_NEW_ELEMENTS', [ 'copy-to-clipboard', 'split-card-hover' ] );
    define( 'ADV_VIS_ELE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
    define( 'ADV_VIS_ELE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    define( 'ADV_VIS_ELE_ELEMENTS_DIR', ADV_VIS_ELE_PLUGIN_DIR . 'elements' );
    define( 'ADV_VIS_ELE_ELEMENTS_URL', plugin_dir_url( __FILE__ ) . 'elements' );
    define( 'ADV_VIS_ELE_GLOBAL_MOBILE_BREAKPOINT', 768 );
    define( 'ADV_VIS_ELE_PAGE_SCREEN_IDS', [
        'Library'    => 'toplevel_page_adv-vis-ele',
        'Shortcodes' => 'edit-adv-vis-element',
        'Settings'   => 'advanced-visual-elements_page_adv-vis-ele-settings',
    ] );
    // remote URLs
    define( 'ADV_VIS_ELE_PLUGIN_WEBSITE', 'https://wp-ave.com' );
    define( 'ADV_VIS_ELE_PLUGIN_WEBSITE_SHOP', 'https://wp-ave.com/shop' );
    /**
     * The code that runs during plugin activation.
     */
    function ave_activate_adv_vis_ele()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-adv-vis-ele-activator.php';
        Adv_Vis_Ele_Activator::activate();
    }
    
    register_activation_hook( __FILE__, 'ave_activate_adv_vis_ele' );
    /**
     * The code that runs when plugin is getting uninstalled.
     */
    function wpave_fs_uninstall_cleanup()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-adv-vis-ele-deactivator.php';
        Adv_Vis_Ele_Deactivator::deactivate();
    }
    
    wpave_fs()->add_action( 'after_uninstall', 'wpave_fs_uninstall_cleanup' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-adv-vis-ele.php';
    /**
     * Run the plugin.
     */
    function ave_run_adv_vis_ele()
    {
        $plugin = new Adv_Vis_Ele();
        $plugin->run();
    }
    
    ave_run_adv_vis_ele();
}
