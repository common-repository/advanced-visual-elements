<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Adv_Vis_Ele_i18n {
	public static $translations;
	
	public function __construct() {
		self::$translations = [
			/*0*/
			__('Are you sure you want to uninstall this element? Local files will be deleted and shortcodes that use them will not render.', 'wp-ave'),
			/*1*/
			__('Are you sure you want to delete this element?', 'wp-ave'),
			/*2*/
			__('All library elements loaded.', 'wp-ave'),
			/*3*/
			__('Code copied to clipboard.', 'wp-ave'),
			/*4*/
			__('Are you sure you want to do this?', 'wp-ave'),
			/*5*/
			__('Options field is empty.', 'wp-ave'),
			/*6*/
			__('There was an error installing the element. Please try from the library.', 'wp-ave'),
			/*7*/
			__('There was an error importing element options. Please refresh the page and try again.', 'wp-ave'),
			/*8*/
			__('No elements found.', 'wp-ave'),
			/*9*/
			__('Element installed. Reload page?', 'wp-ave'),
			/*10*/
			__('Paste the import code here', 'wp-ave'),
			/*11*/
			__('Library was manually updated.', 'wp-ave'),
			/*12*/
			__('Quick preview updated.', 'wp-ave'),
			/*13*/
			__('You need to be a PRO user to use this feature.', 'wp-ave'),
			/*14*/
			__('There was an error with Quick preview. Please refresh the page and try again.', 'wp-ave'),
		];
	}
	
	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'adv-vis-ele',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}