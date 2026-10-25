<?php

/**
 * Fired during plugin activation
 *
 * @link       https://jahid.co/
 * @since      3.0.0
 *
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/Class
 * @author     Jahid <contact@jahid.co>
 */
namespace CoderPlus\XScrollTopResponsive;

class Activator {

	/**
	 * This static method will run when activate the plugin
	 *
	 * Long Description.
	 *
	 * @since    3.0.0
	 */
	public static function activate() {

		// Flush rewrite rules upon activation
		flush_rewrite_rules( );
	}

}