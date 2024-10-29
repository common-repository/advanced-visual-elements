<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Adv_Vis_Ele_Activator {
	/**
	 * Runs when user activates the plugin
	 */
	public static function activate() {
		flush_rewrite_rules();
	}
}